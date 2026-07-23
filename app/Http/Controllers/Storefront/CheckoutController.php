<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderCheckoutRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentProof;
use App\Models\Product;
use App\Models\Setting;
use App\Models\ShippingRate;
use App\Models\ShippingZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    // Step 1: shipping form (guest checkout always available)
    public function show(Request $request)
    {
        $cart = $this->carts($request);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
        $zones = ShippingZone::where('status', 'active')->get();
        return view('storefront.checkout', ['cart' => $cart, 'zones' => $zones]);
    }

    // Step 2: create the order, then redirect to bank details page
    public function place(OrderCheckoutRequest $request)
    {
        $data = $request->validated();

        $cart = $request->session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Cart is empty.');
        }

        $shippingRate = null;
        if ($request->shipping_rate_id) {
            $shippingRate = ShippingRate::where('id', $request->shipping_rate_id)
                ->where('shipping_zone_id', $data['shipping_zone_id'])
                ->firstOrFail();
        }


        $order = DB::transaction(function () use ($data, $cart, $request, $shippingRate) {

            $subtotal = 0;

            $order = Order::create([
                'order_number' => 'BK-' . now()->format('Y') . '-' . Str::upper(Str::random(6)),
                'user_id' => $request->user()?->id,

                'customer_name' => $data['customer_name'],
                'email' => $data['email'],
                'mobile' => $data['mobile'],
                'address' => $data['address'],

                'shipping_zone_id' => $data['shipping_zone_id'],
                'shipping_rate_id' => $shippingRate->id ?? $shippingRate,
                'shipping_method' => $shippingRate->name ?? $shippingRate,

                'shipping_cost' => 0,
                'subtotal' => 0,
                'total_amount' => 0,

                'payment_status' => 'pending',
                'order_status' => 'pending',
            ]);

            foreach ($cart as $line) {

                $product = Product::find($line['id']);

                if (!$product) {
                    continue;
                }

                $unitPrice = $product->effectivePrice();

                $lineTotal = $unitPrice * $line['quantity'];

                $subtotal += $lineTotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'unit_price' => $unitPrice,
                    'quantity' => $line['quantity'],
                    'line_total' => $lineTotal,
                ]);
            }

            // Calculate shipping
            $shippingCost = $shippingRate->price ?? 0;

            if (
                $shippingRate && $shippingRate->free_shipping &&
                $subtotal >= $shippingRate->min_order_amount
            ) {
                $shippingCost = 0;
            }

            $totalAmount = $subtotal + $shippingCost;

            $order->update([
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'total_amount' => $totalAmount,
            ]);

            return $order;
        });

        // $request->session()->forget('cart');

        return redirect()->route('checkout.bank', $order->order_number);
    }








    // Step 3: display bank details + active timeline (Section 8)
    public function bank(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['items.product', 'paymentProofs'])
            ->firstOrFail();

        return view('storefront.bank-details', [
            'order' => $order,
            'bank' => [
                'bank_name' => Setting::get('bank_name', 'Meezan Bank'),
                'account_title' => Setting::get('account_title', 'Bookish Store'),
                'iban' => Setting::get('bank_iban', 'PK00XXXX0000000000000000'),
                'account_no' => Setting::get('bank_account_no', '0000-0000000-0'),
                'raast_id' => Setting::get('raast_id', '03000000000'),
                'qr_image' => Setting::get('qr_image'),
                'qr_bank_name' => Setting::get('qr_bank_name'),
                'qr_account_title' => Setting::get('qr_account_title'),

            ],
        ]);
    }

    // Step 4: customer uploads receipt screenshot (web form)
    public function uploadProof(Request $request, string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        if ($request->proof === 'whatsapp') {
            $request->validate([
                'proof' => ['required'],
            ]);
            $path = 'whatsapp';
            $source = 'whatsapp';
            $message = 'Order payment confirmation received via WhatsApp. Our team will verify it shortly.';
        } else {

            $request->validate(
                [
                    'screenshot' => [
                        'nullable',
                        'file',
                        'mimes:jpg,jpeg,png,webp,pdf',
                        'max:5120',
                    ],
                ],
                [
                    'screenshot.file' => 'The uploaded file is invalid.',
                    'screenshot.mimes' => 'The screenshot must be a JPG, JPEG, PNG, WEBP, or PDF file.',
                    'screenshot.max' => 'The screenshot must not be larger than 5 MB.',
                ]
            );
            $source = 'web';
            $path = null;
            $message = 'No proof is submitted.';
            if ($request->hasFile('screenshot')) {
                $path = $request->file('screenshot')->store('payment-proofs', 'public');
                $message = 'Payment proof submitted. Our team will verify it shortly.';
            }
        }

        PaymentProof::create([
            'order_id' => $order->id,
            'screenshot_path' => $path,
            'source' => $source,
            'status' => 'submitted',
        ]);

        $order->update([
            'payment_status' => 'pending',
        ]);

        return redirect()
            ->route('checkout.confirmation', $order->order_number)
            ->with('success', $message);
    }

    private function carts(Request $request): array
    {
        $items = $request->session()->get('cart', []);
        $productIds = collect($items)->pluck('id');
        $products = Product::whereIn('id', $productIds)
            ->get()
            ->keyBy('id');
        foreach ($items as &$item) {
            $item['image'] = $products[$item['id']]->imageUrl();
        }

        $total = collect($items)->sum(fn($i) => $i['price'] * $i['quantity']);

        return [
            'items' => $items,
            'total' => $total
        ];
    }

    public function statusUpdate(Request $request, $order)
    {
        $request->validate([
            'pay' => 'required|in:cash_on_delivery,bank_transfer',
        ]);

        $order = Order::where('order_number', $order)->firstOrFail();

        $order->update(['payment_method' => $request->pay]);

        if ($request->pay == 'cash_on_delivery') {
            $route = 'checkout.confirmation';
            $message = 'Order placed successfully using Cash on Delivery.';
        } elseif ($request->pay == 'bank_transfer') {

            $route = 'checkout.bank';
            $message = 'Payment method selected. Please transfer payment and upload proof.';
        }
        $request->session()->forget('cart');
        return redirect()->route($route, $order->order_number)->with('success', $message);
    }

    public function confirmation($order)
    {
        $order = Order::where('order_number', $order)->firstOrFail();

        return view('storefront.OrderComplete.order_complete', compact('order'));
    }


    public function getShippingRates($zoneId)
    {
        $rates = ShippingRate::where('shipping_zone_id', $zoneId)
            ->where('status', 1)
            ->get();

        if ($rates) {
            return view('partials.shipping_rates', compact('rates'));
        }

        return response()->json([
            'message' => 'no rate available',
        ], 404);
    }
}
