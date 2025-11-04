<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .details {
            margin-bottom: 30px;
        }
        .details p {
            margin: 5px 0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table th {
            text-align: left;
            background-color: #f2f2f2;
        }
        .total {
            margin-top: 20px;
            text-align: right;
            font-size: 16px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="logo">
        <img src="{{ public_path('assets/images/logo.png') }}" alt="Logo" height="85">
        <img src="{{ public_path('assets/images/brand.png') }}" alt="Brand Logo" height="40">
    </div>
    <div class="header">
        <h1>Invoice</h1>
        <p><strong>Order ID:</strong> {{ $order->id }}</p>
        <p><strong>Date:</strong> {{ date('d F Y', strtotime($order->created_at)) }}</p>
    </div>
    <div class="details">
        <h3>Order Details</h3>
        <p><strong>Laundry Type:</strong> {{ $order->laundry_type_id }}</p>
        <p><strong>Service:</strong> {{ $order->laundry_service_id }}</p>
        <p><strong>Quantity:</strong> {{ $order->quantity }}</p>
        <p><strong>Remark:</strong> {{ $order->remark ?? 'No remarks' }}</p>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Order Total</td>
                <td>RM {{ number_format($order->total_amount, 2) }}</td>
            </tr>
        </tbody>
    </table>
    <div class="total">
        <p>Total: RM {{ number_format($order->total_amount, 2) }}</p>
    </div>
</body>
</html>
