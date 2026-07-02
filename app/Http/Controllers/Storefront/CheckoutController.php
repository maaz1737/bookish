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
            'customer_name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:1000'],
        ]);

        $cart = $request->session()->get('cart', []);
        abort_if(empty($cart), 422, 'Cart is empty.');

        $order = DB::transaction(function () use ($data, $cart, $request) {
            $total = 0;

            $order = Order::create([
                'order_number' => 'BK-' . now()->format('Y') . '-' . Str::upper(Str::random(6)),
                'user_id' => $request->user()?->id,   // null for guests
                'customer_name' => $data['customer_name'],
                'mobile' => $data['mobile'],
                'address' => $data['address'],
                'total_amount' => 0,
                'payment_status' => 'pending',
                'order_status' => 'pending',
            ]);

            foreach ($cart as $line) {
                $product = Product::find($line['id']);
                if (!$product) {
                    continue;
                }
                $unit = $product->effectivePrice();
                $lineTotal = $unit * $line['quantity'];
                $total += $lineTotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'unit_price' => $unit,
                    'quantity' => $line['quantity'],
                    'line_total' => $lineTotal,
                ]);
            }

            $order->update(['total_amount' => $total]);
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

        if ($request->input('confirm_method') === 'whatsapp') {
            $request->validate([
                'whatsapp_agree' => ['required', 'accepted'],
            ]);

            PaymentProof::create([
                'order_id' => $order->id,
                'screenshot_path' => 'whatsapp',
                'source' => 'whatsapp',
                'status' => 'submitted',
            ]);

            $order->update(['payment_status' => 'paid']);

            return redirect()->route('checkout.confirmation', $order->order_number)
                ->with('success', 'Order payment confirmation received via WhatsApp. Our team will verify it shortly.');
        } else {
            $request->validate([
                'screenshot' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:5120'],
            ]);

            $path = $request->file('screenshot')->store('payment-proofs', 'public');

            PaymentProof::create([
                'order_id' => $order->id,
                'screenshot_path' => $path,
                'source' => 'web',
                'status' => 'submitted',
            ]);

            $order->update(['payment_status' => 'paid']);

            return redirect()->route('checkout.confirmation', $order->order_number)
                ->with('success', 'Payment proof submitted. Our team will verify it shortly.');
        }
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
        $order = Order::where('order_number', $order)->firstOrFail();

        if ($request->pay == 'cash_on_delivery') {
            $order->update([
                'order_status' => 'delivered',
                'payment_method' => 'cash_on_delivery',
                'stock_adjusted' => true,
            ]);

            // Decrement stock immediately for COD since it goes straight to delivered
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->decrement('stock', $item->quantity);
                }
            }

            $request->session()->forget('cart');
            return redirect()->route('checkout.confirmation', $order->order_number)->with('success', 'Order placed successfully using Cash on Delivery.');
        } elseif ($request->pay == 'bank_transfer') {
            $order->update([
                'payment_method' => 'bank_transfer',
            ]);
            $request->session()->forget('cart');
            return redirect()->route('checkout.bank', $order->order_number)->with('success', 'Payment method selected. Please transfer payment and upload proof.');
        }

        $request->session()->forget('cart');
        return redirect()->route('checkout.confirmation', $order->order_number)->with('success', 'Order status updated successfully.');
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
