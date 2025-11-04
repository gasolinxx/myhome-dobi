@extends('layouts/base')

@section('content')
    <div class="container mt-4">
        <div class="mb-2 text-dark ml-2">
            <a href="{{ route('order.index') }}" class="mdi mdi-chevron-left text-dark"> Back to Order List</a>
        </div>

        <div class="card shadow-sm border-light">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <span class="h3 text-dark">Order #{{ $order->id }}</span>
                        <p class="mb-1 text-muted mt-2">{{ $order->created_at->format('d F Y, H:i') }}</p>
                        <h4 class="font-weight-bold">{{ $order->user->name }}</h4>
                        <p class="text-muted">{{ $order->user->contact_number }}</p>
                    </div>
                    <span
                        class="badge badge-pill 
                        @if ($order->status === 'Pending') badge-light
                        @elseif ($order->status === 'Assign Pickup') badge-secondary
                        @elseif ($order->status === 'Pickup') badge-info
                        @elseif ($order->status === 'In Work') badge-warning
                        @elseif ($order->status === 'Pay') badge-danger
                        @elseif ($order->status === 'Assign Delivery') badge-secondary
                        @elseif ($order->status === 'Delivery') badge-info
                        @elseif ($order->status === 'Complete') badge-success @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <hr>

                <div class="row mb-2">
                    <div class="col-md-6">
                        <p><strong>Email:</strong> {{ $order->user->email }}</p>
                        <p><strong>Laundry Type:</strong> {{ $order->laundryType->laundry_name }}</p>
                        <p><strong>Total Amount:</strong> RM {{ number_format($order->total_amount, 2) }}</p>
                        <p><strong>Delivery Fee:</strong> RM {{ number_format($order->delivery_fee, 2) ?? '0.00' }}</p>
                        <p><strong>Quantity:</strong> {{ $order->quantity ?? 'N/A' }}</p>
                        <p><strong>Unit Per Price:</strong> RM {{ number_format($order->laundryService->price, 2) ?? '0.00' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Order Method:</strong> {{ $order->order_method }}</p>
                        <p><strong>Delivery:</strong> {{ $order->delivery_option ? 'Yes' : 'No' }}</p>
                        <p><strong>Address:</strong> {{ $order->address ?? 'N/A' }}</p>
                        <p><strong>Laundry Service:</strong> {{ $order->laundryService->service_name }}</p>
                        <p><strong>Remark:</strong> {{ $order->remark ?? 'No remarks' }}</p>
                    </div>
                </div>
                <hr>
                <h5 class="text-dark mb-3">Pickup & Delivery</h5>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <p><strong>Pickup Driver:</strong> {{ $delivery->pickupDriver->name ?? 'N/A' }}</p>
                        <p><strong>Pickup Date:</strong> {{ $delivery->order->pickup_date ?? 'N/A' }}</p>
                        <p><strong>Proof of Pickup:</strong>
                            @if ($delivery && $delivery->proof_pickup)
                                <a href="{{ Storage::url($delivery->proof_pickup) }}" target="_blank">View
                                    Proof</a>
                            @else
                                <a href="javascript:void(0);" class="text-muted" style="pointer-events: none;">No Proof
                                    Uploaded</a>
                            @endif
                        </p>
                    </div>

                    <div class="col-md-6">
                        <p><strong>Delivery Driver:</strong> {{ $delivery->deliveryDriver->name ?? 'N/A' }}</p>
                        <p><strong>Delivery Date:</strong> {{ $delivery->delivery_date ?? 'N/A' }}</p>
                        <p><strong>Proof of Delivery:</strong>
                            @if ($delivery && $delivery->proof_deliver)
                                <a href="{{ Storage::url($delivery->proof_deliver) }}" target="_blank">View
                                    Proof</a>
                            @else
                                <a href="javascript:void(0);" class="text-muted" style="pointer-events: none;">No Proof
                                    Uploaded</a>
                            @endif
                        </p>
                    </div>

                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="text-dark mb-3">Related Documents</h5>
                        <ul class="list-unstyled">
                            <!-- Proof of Pickup - Display if order method is 'Pickup' and status is 'In Work' or 'Complete' -->
                            @if (
                                $order->order_method === 'Pickup' &&
                                    in_array($order->status, ['In Work', 'Assign Delivery', 'Delivery', 'Pay', 'Complete']))
                                <li>
                                    <a href="{{ route('order.proof-of-pickup', $order->id) }}" class="text-decoration-none"
                                        target="_blank">
                                        <i class="mdi mdi-file-pdf text-danger"></i> Proof of Pickup.pdf
                                    </a>
                                </li>
                            @endif

                            <!-- Proof of Delivery - Display if delivery option is enabled, status is 'Complete', and proof_delivery exists -->
                            @if ($order->delivery_option && $order->status === 'Complete')
                                <li>
                                    <a href="{{ route('order.proof-of-delivery', $order->id) }}"
                                        class="text-decoration-none" target="_blank">
                                        <i class="mdi mdi-file-pdf text-danger"></i> Proof of Delivery.pdf
                                    </a>
                                </li>
                            @endif

                            <!-- Invoice link (only if order status is Complete) -->
                            <li>
                                <a href="{{ route('billing.invoice', $order->id) }}" class="text-decoration-none"
                                    target="_blank"
                                    @if ($order->status !== 'Complete') onclick="event.preventDefault(); alert('Invoice is only available for completed orders.');" @endif>
                                    <i class="mdi mdi-file-pdf text-danger"></i> Invoice Payment.pdf
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="button" onclick="history.back()" class="btn btn-light">
                        <i class="mdi mdi-arrow-left"></i> Back
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
