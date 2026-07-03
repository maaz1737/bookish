@extends('admin.layout')
@section('title', 'Order')
@section('content')

    <div class="space-y-6">

        <!-- Header -->
        <div class="bg-white rounded-xl shadow-sm border p-6 flex items-center justify-between">

            <div>

                <h1 class="text-3xl font-bold text-gray-800">
                    {{ $order->order_number }}
                </h1>

                <p class="text-gray-500 mt-1">
                    {{ $order->customer_name }}
                    •
                    {{ $order->mobile }}
                </p>

            </div>

            <a href="{{ route('admin.orders.pdf', $order) }}" target="_blank"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-lg shadow">

                <i class="fa fa-download mr-2"></i>
                Generate PDF

            </a>

        </div>


        <!-- Top Cards -->
        <div class="grid lg:grid-cols-4 gap-5">

            <!-- Customer -->
            <div class="bg-white rounded-xl shadow-sm border p-5">

                <h3 class="font-semibold text-gray-700 mb-4">
                    Customer
                </h3>

                <div class="space-y-3 text-sm">

                    <div>
                        <div class="text-gray-500">Name</div>
                        <div class="font-medium">{{ $order->customer_name }}</div>
                    </div>

                    <div>
                        <div class="text-gray-500">Phone</div>
                        <div class="font-medium">{{ $order->mobile }}</div>
                    </div>

                    <div>
                        <div class="text-gray-500">Address</div>
                        <div class="font-medium">
                            {{ $order->address }}
                        </div>
                    </div>

                </div>

            </div>

            <!-- Payment -->
            <div class="bg-white rounded-xl shadow-sm border p-5">

                <h3 class="font-semibold text-gray-700 mb-4">
                    Payment
                </h3>

                @if($order->paymentProofs->count())

                    @php
                        $proof = $order->paymentProofs->first();
                    @endphp

                    @if($proof->source == 'whatsapp')
                        <div class="bg-green-100 text-green-700 rounded-lg p-3 text-sm">
                            <i class="fa-brands fa-whatsapp mr-2"></i>
                            Receipt shared on WhatsApp
                        </div>
                    @else
                        <img src="{{ asset('storage/' . $proof->screenshot_path) }}"
                            class="rounded-lg border w-full h-52 object-contain">
                    @endif
                @else
                    @if($order->payment_method == 'cash_on_delivery')
                        <p class="text-gray-400">
                            Cash On Delivery
                        </p>
                    @else
                        <p class="text-gray-400">
                            No payment proof
                        </p>
                    @endif
                @endif
            </div>
            <!-- Order Status -->
            <div class="bg-white rounded-xl shadow-sm border p-5">

                <h3 class="font-semibold mb-4">
                    Order Status
                </h3>

                <span class="inline-flex px-3 py-1 rounded-full
                @if($order->order_status == 'pending')
                   bg-yellow-100 text-yellow-700
                @elseif($order->order_status == 'shipped')
                    bg-blue-100 text-blue-700
                @elseif($order->order_status == 'delivered')
                     bg-green-100 text-green-700
                @else
                   bg-red-100 text-red-700
                @endif">

                    {{ ucfirst($order->order_status) }}

                </span>

            </div>

            <!-- Payment Status -->
            <div class="bg-white rounded-xl shadow-sm border p-5">

                <h3 class="font-semibold mb-4">
                    Payment Status
                </h3>

                <span class="inline-flex px-3 py-1 rounded-full
                @if($order->payment_status == 'paid')
                    bg-green-100 text-green-700
                @else
                    bg-yellow-100 text-yellow-700
                @endif">

                    {{ ucfirst($order->payment_status) }}

                </span>

            </div>

        </div>


        <!-- Order Table -->
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">

            <div class="px-6 py-4 border-b">

                <h2 class="text-lg font-bold text-gray-800">
                    Order Items
                </h2>

            </div>

            <table class="w-full">

                <thead class="bg-gray-100">

                    <tr>

                        <th class="text-left px-6 py-3">
                            Product
                        </th>

                        <th class="text-center">
                            Price
                        </th>

                        <th class="text-center">
                            Qty
                        </th>

                        <th class="text-right px-6">
                            Total
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($order->items as $item)

                        <tr class="border-t hover:bg-gray-50">

                            <td class="px-6 py-4">

                                {{ $item->name }}

                            </td>

                            <td class="text-center">

                                PKR {{ number_format($item->unit_price) }}

                            </td>

                            <td class="text-center">

                                {{ $item->quantity }}

                            </td>

                            <td class="text-right px-6 font-medium">

                                PKR {{ number_format($item->line_total) }}

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        <!-- Totals + Update -->
        <div class="grid lg:grid-cols-2 gap-6">

            <!-- Totals -->

            <div class="bg-white rounded-xl shadow-sm border p-6">

                <h3 class="font-semibold mb-5">
                    Billing Summary
                </h3>

                <div class="space-y-4">

                    <div class="flex justify-between">

                        <span>Subtotal</span>

                        <strong>
                            PKR {{ number_format($order->subtotal) }}
                        </strong>

                    </div>

                    <div class="flex justify-between">

                        <span>Shipping</span>

                        <strong>

                            @if($order->shipping_cost)

                                PKR {{ number_format($order->shipping_cost) }}

                            @else

                                FREE

                            @endif

                        </strong>

                    </div>

                    <hr>

                    <div class="flex justify-between text-xl font-bold text-indigo-700">

                        <span>Grand Total</span>

                        <span>

                            PKR {{ number_format($order->total_amount) }}

                        </span>

                    </div>

                </div>

            </div>

            <!-- Update -->

            <div class="bg-white rounded-xl shadow-sm border p-6">

                <h3 class="font-semibold mb-5">

                    Update Order

                </h3>

                <form method="POST" action="{{ route('admin.orders.status', $order) }}">

                    @csrf
                    @method('PUT')

                    <label class="block text-sm mb-2">

                        Order Status

                    </label>

                    <select name="order_status" class="w-full border rounded-lg px-3 py-2 mb-5">

                        @foreach(['pending', 'shipped', 'delivered', 'returned'] as $s)

                            <option value="{{ $s }}" @selected($order->order_status == $s)>

                                {{ ucfirst($s) }}

                            </option>

                        @endforeach

                    </select>

                    <label class="block text-sm mb-2">

                        Payment Status

                    </label>

                    <select name="payment_status" class="w-full border rounded-lg px-3 py-2 mb-5">

                        @foreach(['pending', 'paid'] as $s)

                            <option value="{{ $s }}" @selected($order->payment_status == $s)>

                                {{ ucfirst($s) }}

                            </option>

                        @endforeach

                    </select>

                    <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg py-3">

                        Save Changes

                    </button>

                </form>

            </div>

        </div>

    </div>

@endsection