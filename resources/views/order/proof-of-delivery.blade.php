<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - Order #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
        }
        .invoice-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 28px;
            margin: 0;
        }
        .header p {
            font-size: 16px;
            color: #777;
        }
        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .invoice-details .section {
            width: 48%;
        }
        .invoice-details .section p {
            margin: 5px 0;
        }
        .section strong {
            color: #333;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .table th, .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .table th {
            background-color: #f4f4f4;
        }
        .table .total {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .footer {
            text-align: center;
            font-size: 14px;
            color: #777;
            margin-top: 40px;
        }
        @media (max-width: 600px) {
            .invoice-container {
                margin: 10px;
                padding: 15px;
            }
            .header h1 {
                font-size: 22px;
            }
            .invoice-details {
                flex-direction: column;
            }
            .invoice-details .section {
                width: 100%;
            }
            .table td, .table th {
                padding: 8px;
            }
        }
    </style>
</head>
<body>

    <div class="invoice-container">
        <!-- Header Section -->
        <div class="header">
            <h1>Invoice</h1>
            <p>Order ID: #{{ $order->id }}</p>
        </div>

        <!-- Invoice Details -->
        <div class="invoice-details">
            <div class="section">
                <p><strong>Customer:</strong> {{ $order->user->name }}</p>
                <p><strong>Contact Number:</strong> {{ $order->user->contact_number }}</p>
                <p><strong>Email:</strong> {{ $order->user->email }}</p>
                <p><strong>delivery Address:</strong> {{ $order->address ?? 'N/A' }}</p>
            </div>
            <div class="section">
                <p><strong>Invoice Date:</strong> {{ $order->created_at->format('d F Y') }}</p>
                <p><strong>Order Method:</strong> {{ $order->order_method }}</p>
                <p><strong>Delivery:</strong> {{ $order->delivery_option ? 'Yes' : 'No' }}</p>
            </div>
        </div>

        <!-- Items Table -->
        <table class="table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Delivery Fee</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $order->laundryType->laundry_name }} - {{ $order->laundryService->service_name }}</td>
                    <td>{{ $order->quantity ?? 'N/A' }}</td>
                    <td>RM {{ number_format($order->laundryService->price, 2) }}</td>
                    <td>RM {{ number_format($order->delivery_fee, 2) }}</td>
                    <td>RM {{ number_format($order->total_amount, 2) }}</td>
                </tr>
                <!-- Add other rows for additional items if needed -->
            </tbody>
        </table>

        <!-- Total Amount -->
        <div class="table">
            <p class="total">
                <strong>Total Amount: </strong>RM {{ number_format($order->total_amount, 2) }}
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for choosing our services!</p>
            <p>For any queries, please contact us at myhomedobi@laundry.com</p>
        </div>
    </div>

</body>
</html>
