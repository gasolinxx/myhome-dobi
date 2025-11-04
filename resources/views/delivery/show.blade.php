@extends('layouts/base')
@section('content')
    <div class="mt-4 text-dark ml-2">
        <a href="{{ route('delivery.index') }}" class="mdi mdi-chevron-left text-dark"> Back to Delivery & Pickup List</a>
    </div>
    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="">Pickup Driver</h4>
                        <p class="text-muted font-13 mb-4">
                        </p>
                        <form>
                            <div class="row justify-content-center align-items-center g-2">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="inputNama">Name</label>
                                        <input type="text" name="user-name" class="form-control"
                                            value="{{ $order->user->name ?? $order->guest->name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="kiosk-number">Phone Number</label>
                                        <input type="text" name="contact-number" class="form-control"
                                            value="{{ $order->user->contact_number ?? $order->guest->contact_number }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="kiosk-number">Email</label>
                                        <input type="text" name="email" class="form-control"
                                            value="{{ $order->user->email ?? $order->guest->email }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="kiosk-number">Order Method</label>
                                        <input type="text" name="order_method" class="form-control"
                                            value="{{ $order->order_method }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="example-textarea">Address</label>
                                        <textarea class="form-control" name="address" id="example-textarea" rows="5" readonly>{{ $order->address }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="example-textarea">Remark</label>
                                        <textarea class="form-control" name="remark" id="example-textarea" rows="5" readonly>{{ $order->remark }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="card text-white overflow-hidden" style="background-color: #73C0BF;">
                                        <div class="card-body">
                                            <div class="toll-free-box text-center">
                                                <h4> <i class="mdi mdi-home-map-marker"></i> Pickup Details </h4>
                                            </div>
                                        </div> <!-- end card-body-->
                                    </div> <!-- end card-->
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="kiosk-number">Pickup Date</label>
                                        <input type="text" id="pickup_date" class="form-control"
                                            value="{{ \Carbon\Carbon::parse($order->pickup_date)->format('d F Y') }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="kiosk-number">Pickup Time</label>
                                        <input type="text" id="pickup_time" class="form-control"
                                            value="{{ \Carbon\Carbon::parse($order->pickup_date)->format('h:i A') }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label for="inputPickupDriver" class="col-form-label">Driver Assign</label>
                                        <input type="text" name="pickup_id" class="form-control"
                                            value="{{ $delivery && $delivery->pickupDriver ? $delivery->pickupDriver->name : 'Not Assigned' }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label for="image">Proof of Pickup</label>
                                        <p class="form-control-plaintext">
                                            @if ($delivery && $delivery->proof_pickup)
                                                <a href="{{ Storage::url($delivery->proof_pickup) }}" target="_blank">View
                                                    Proof</a>
                                            @else
                                                <a href="javascript:void(0);" class="text-muted"
                                                    style="pointer-events: none;">No Proof Uploaded</a>
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="card text-white overflow-hidden" style="background-color: #73C0BF;">
                                        <div class="card-body">
                                            <div class="toll-free-box text-center">
                                                <h4> <i class="mdi mdi-truck"></i> Delivery Details </h4>
                                            </div>
                                        </div> <!-- end card-body-->
                                    </div> <!-- end card-->
                                </div>
                                @if ($delivery && $delivery->order && 
                                (( $delivery->order->status === 'Complete' && $delivery->order->status === 'Complete') || 
                                $delivery->order->status === 'Delivery'))
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="kiosk-number">Delivery Date</label>
                                            <input type="text" id="delivery_date" class="form-control"
                                                value="{{ \Carbon\Carbon::parse($delivery->delivery_date)->format('d F Y') }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="kiosk-number">Delivery Time</label>
                                            <input type="text" id="delivery_time" class="form-control"
                                                value="{{ \Carbon\Carbon::parse($delivery->delivery_date)->format('h:i A') }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="inputdeliverDriver" class="col-form-label">Driver Assign</label>
                                            <input type="text" name="delivery_id" class="form-control"
                                                value="{{ $delivery && $delivery->deliveryDriver ? $delivery->deliveryDriver->name : 'Not Assigned' }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="inputdeliverDriver" class="col-form-label">Completed At</label>
                                            <input type="text" name="delivery_id" class="form-control"
                                                value="{{ $delivery->updated_at ? $delivery->updated_at : 'Process of Delivery' }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <label for="image">Proof of Delivery</label>
                                            <p class="form-control-plaintext">
                                                @if ($delivery && $delivery->proof_deliver)
                                                    <a href="{{ Storage::url($delivery->proof_deliver) }}"
                                                        target="_blank">View
                                                        Proof</a>
                                                @else
                                                    <a href="javascript:void(0);" class="text-muted"
                                                        style="pointer-events: none;">No Proof Uploaded</a>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <label for="no-delivery" class="col-form-label">No Delivery Data
                                                Available</label>
                                            <input type="text" id="no-delivery" class="form-control"
                                                value="No delivery information available." readonly>
                                        </div>
                                    </div>
                                @endif

                            </div><!-- end row-->
                            <div class="text-center mt-2">
                                <button type="button" onclick="history.back()" class="btn btn-info">Back</button>
                            </div>
                        </form>
                    </div> <!-- end card-body-->
                </div><!-- end card-->
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div>
@endsection
