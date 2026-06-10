<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentProof;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    // Step 1: shipping form (guest checkout always available)
    public function show(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
        return view('storefront.checkout', ['cart' => $cart]);
    }

    // Step 2: create the order, then redirect to bank details page
    public function place(Request $request)
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'mobile'        => ['required', 'string', 'max:50'],
            'address'       => ['required', 'string', 'max:1000'],
        ]);

        $cart = $request->session()->get('cart', []);
        abort_if(empty($cart), 422, 'Cart is empty.');

        $order = DB::transaction(function () use ($data, $cart, $request) {
            $total = 0;

            $order = Order::create([
                'order_number'   => 'BK-'.now()->format('Y').'-'.Str::upper(Str::random(6)),
                'user_id'        => $request->user()?->id,   // null for guests
                'customer_name'  => $data['customer_name'],
                'mobile'         => $data['mobile'],
                'address'        => $data['address'],
                'total_amount'   => 0,
                'payment_status' => 'pending',
                'order_status'   => 'pending_payment',
            ]);

            foreach ($cart as $line) {
                $product = Product::find($line['id']);
                if (! $product) {
                    continue;
                }
                $unit = $product->effectivePrice();
                $lineTotal = $unit * $line['quantity'];
                $total += $lineTotal;

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'name'       => $product->name,
                    'unit_price' => $unit,
                    'quantity'   => $line['quantity'],
                    'line_total' => $lineTotal,
                ]);
            }

            $order->update(['total_amount' => $total]);
            return $order;
        });

        $request->session()->forget('cart');

        return redirect()->route('checkout.bank', $order->order_number);
    }

    // Step 3: display bank details + active timeline (Section 8)
    public function bank(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        return view('storefront.bank-details', [
            'order' => $order,
            'bank'  => [
                'bank_name'     => Setting::get('bank_name', 'Meezan Bank'),
                'account_title' => Setting::get('account_title', 'Bookish Store'),
                'iban'          => Setting::get('bank_iban', 'PK00XXXX0000000000000000'),
                'account_no'    => Setting::get('bank_account_no', '0000-0000000-0'),
                'raast_id'      => Setting::get('raast_id', '03000000000'),
            ],
        ]);
    }

    // Step 4: customer uploads receipt screenshot (web form)
    public function uploadProof(Request $request, string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        $request->validate([
            'screenshot' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $path = $request->file('screenshot')->store('payment-proofs', 'public');

        PaymentProof::create([
            'order_id'        => $order->id,
            'screenshot_path' => $path,
            'source'          => 'web',
            'status'          => 'submitted',
        ]);

        // Move payment status forward -> admin gets notified queue (Stage 02)
        $order->update(['payment_status' => 'proof_submitted']);

        return redirect()->route('checkout.bank', $order->order_number)
            ->with('success', 'Payment proof submitted. Our team will verify it shortly.');
    }
}
