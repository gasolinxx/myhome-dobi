@extends('layouts.base')

@section('content')
<div class="container-fluid mt-5">
    <h4 class="header-title">Payment Page</h4>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5>Order Details</h5>
                    <p><strong>Laundry Type:</strong> {{ $order->laundry_type_name }}</p>
                    <p><strong>Service:</strong> {{ $order->service_name }}</p>
                    <p><strong>Quantity:</strong> {{ $order->quantity }}</p>
                    <p><strong>Total Amount:</strong> RM {{ number_format($order->total_amount, 2) }}</p>

                    <form id="paymentForm" action="{{ route('billing.customer.payment') }}" method="POST">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        
                        <!-- Payment Method -->
                        <div class="form-group">
                            <label for="payment_method">Choose Payment Method:</label>
                            <select name="payment_method" id="payment_method" class="form-control" required>
                                <option value="" disabled selected>Select a payment method</option>
                                <option value="paypal">PayPal</option>
                                <option value="online_banking">Online Banking</option>
                                <option value="cash">Cash</option>
                            </select>
                        </div>

                        <!-- Online Banking Options -->
                        <div class="form-group" id="bank-selection" style="display: none;">
                            <label for="bank_name">Choose Your Bank:</label>
                            <select name="bank_name" id="bank_name" class="form-control">
                                <option value="maybank">Maybank</option>
                                <option value="cimb">CIMB Bank</option>
                                <option value="rhb">RHB Bank</option>
                            </select>
                        </div>

                        <!-- PayPal Button -->
                        <div id="paypal-button-container" style="display: none;"></div>

                        <!-- Confirm Payment Button -->
                        <button type="submit" id="confirm-payment-btn" class="btn btn-primary" style="display: none;">
                            Confirm Payment
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include PayPal SDK -->
<script src="https://www.paypal.com/sdk/js?client-id=AdIXZZR2FEXNTRg9CVRl4Se8im7XUAI0ww7SRhyHeEmaoOwQk75PZAYKWmLkz0tP6n3HemceuG_CjtjX&currency=USD"></script>

<script>
    document.getElementById('payment_method').addEventListener('change', function() {
        const paymentMethod = this.value;
        const paypalContainer = document.getElementById('paypal-button-container');
        const bankSelection = document.getElementById('bank-selection');
        const confirmPaymentBtn = document.getElementById('confirm-payment-btn');

        paypalContainer.style.display = 'none';
        bankSelection.style.display = 'none';
        confirmPaymentBtn.style.display = 'none';

        if (paymentMethod === 'paypal') {
            paypalContainer.style.display = 'block';
        } else if (paymentMethod === 'online_banking') {
            bankSelection.style.display = 'block';
            confirmPaymentBtn.style.display = 'block';
        } else if (paymentMethod === 'cash') {
            confirmPaymentBtn.style.display = 'block';
        }
    });

    // PayPal Button Rendering
    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '{{ $order->total_amount }}' // Set the amount dynamically
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                alert('Payment successful! Transaction ID: ' + details.id);
                // Redirect to confirmation route
                document.getElementById('paymentForm').submit();
            });
        },
        onError: function(err) {
            alert('Payment failed. Please try again.');
        }
    }).render('#paypal-button-container');
</script>
@endsection
