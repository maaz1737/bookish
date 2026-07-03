<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
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
    public function place(Request $request)
    {

        $data = $request->validate([
            'customer_name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email:rfc,dns',
                'max:255',
            ],

            'mobile' => [
                'required',
                'regex:/^(03[0-9]{9}|\+923[0-9]{9})$/',
            ],

            'shipping_zone_id' => [
                'required',
                'exists:shipping_zones,id',
            ],

            'shipping_rate_id' => [
                'required',
                'exists:shipping_rates,id',
            ],

            'address' => [
                'required',
                'string',
                'min:10',
                'max:1000',
            ],

        ], [

            'customer_name.required' => 'Please enter your full name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'mobile.required' => 'Please enter your mobile number.',
            'mobile.regex' => 'Please enter a valid Pakistani mobile number (e.g. 03XXXXXXXXX).',
            'shipping_zone_id.required' => 'Please select your province.',
            'shipping_zone_id.exists' => 'The selected province is invalid.',
            'shipping_rate_id.required' => 'Please select a shipping method.',
            'shipping_rate_id.exists' => 'The selected shipping method is invalid.',
            'address.required' => 'Please enter your complete address.',
            'address.min' => 'Please enter a more complete delivery address.',
        ]);

        $cart = $request->session()->get('cart', []);
        abort_if(empty($cart), 422, 'Cart is empty.');
        $shippingRate = ShippingRate::where('id', $data['shipping_rate_id'])
            ->where('shipping_zone_id', $data['shipping_zone_id'])
            ->firstOrFail();
        $order = DB::transaction(function () use ($data, $cart, $request, $shippingRate) {

            $subtotal = 0;

            $order = Order::create([
                'order_number' => 'BK-' . now()->format('Y') . '-' . Str::upper(Str::random(6)),
                'user_id' => $request->user()?->id,

                'customer_name' => $data['customer_name'],
                'email' => $data['email'],
                'mobile' => $data['mobile'],
                'address' => $data['address'],

                'shipping_zone_id' => $shippingRate->shipping_zone_id,
                'shipping_rate_id' => $shippingRate->id,
                'shipping_method' => $shippingRate->name,

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
            $shippingCost = $shippingRate->price;

            if (
                $shippingRate->free_shipping &&
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
            ],
        ]);
    }

    // Step 4: customer uploads receipt screenshot (web form)
    public function uploadProof(Request $request, string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        if ($request->confirm_method === 'whatsapp') {

            $request->validate([
                'whatsapp_agree' => ['required', 'accepted'],
            ]);

            $path = 'whatsapp';
            $source = 'whatsapp';
            $message = 'Order payment confirmation received via WhatsApp. Our team will verify it shortly.';

        } else {

            $request->validate([
                'screenshot' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:5120'],
            ]);

            $path = $request->file('screenshot')->store('payment-proofs', 'public');
            $source = 'web';
            $message = 'Payment proof submitted. Our team will verify it shortly.';
        }

        PaymentProof::create([
            'order_id' => $order->id,
            'screenshot_path' => $path,
            'source' => $source,
            'status' => 'submitted',
        ]);

        $order->update([
            'payment_status' => 'paid',
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
            ->pluck('images', 'id');
        foreach ($items as &$item) {
            $item['image'] = $products[$item['id']] ?? null;
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

        return view('partials.shipping_rates', compact('rates'));
    }

}
