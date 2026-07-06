<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Order {{ $order->order_number }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
            vertical-align: middle;
        }


        th {
            background: #f3f3f3;
        }

        .right {
            text-align: right;
        }
    </style>
</head>

<body>

    <h2>Order {{ $order->order_number }}</h2>

    <p><strong>Customer:</strong> {{ $order->customer_name }}</p>
    <p><strong>Mobile:</strong> {{ $order->mobile }}</p>
    <p><strong>Address:</strong> {{ $order->address }}</p>
    <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unit_price) }}</td>
                    <td>{{ number_format($item->line_total) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3 style="text-align:right">
        Grand Total: {{ number_format($order->total_amount) }} PKR
    </h3>

</body>

</html>