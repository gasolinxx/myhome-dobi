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
                        <h4 class="">Delivery Driver</h4>
                        <p class="text-muted font-13 mb-4">
                            Please Fill the Form Below
                        </p>
                        <form action="{{ route('delivery.update', $delivery->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="order_id" value="{{ $orders->id }}">
                            <div class="row justify-content-center align-items-center g-2">
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label for="kiosk-number">Service</label>
                                        <input type="text" name="laundry_services" class="form-control"
                                            value="{{ $orders->laundryService->service_name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="inputNama">Name</label>
                                        <input type="text" name="user-name" class="form-control"
                                            value="{{ $orders->user->name ?? $orders->guest->name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="kiosk-number">Phone Number</label>
                                        <input type="text" name="contact-number" class="form-control"
                                            value="{{ $orders->user->contact_number ?? $orders->guest->contact_number }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="kiosk-number">Email</label>
                                        <input type="text" name="email" class="form-control"
                                            value="{{ $orders->user->email ?? $orders->guest->email }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="kiosk-number">Order Method</label>
                                        <input type="text" name="delivery_option" class="form-control"
                                            value="{{ $orders->delivery_option == 1 ? 'Delivery' : 'Self Collect' }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="example-textarea">Delivery Address</label>
                                        <textarea class="form-control" name="address" id="example-textarea" rows="5" readonly>{{ $orders->address }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="example-textarea">Remark</label>
                                        <textarea class="form-control" name="remark" id="example-textarea" rows="5" readonly>{{ $orders->remark }}</textarea>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label for="delivery_date">Delivery Date</label>
                                        {{-- <input type="datetime-local" name="delivery_date" id="delivery_date"
                                            class="form-control"> --}}
                                        <input type="datetime-local" id="delivery_date" name="delivery_date"
                                            class="form-control" oninput="validateDeliveryDate()">
                                        <div id="delivery-error" style="color: red; display: none;"></div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label for="inputPickupDriver" class="col-form-label">Assign Driver</label>
                                        <select id="delivery-driver" name="deliver_id" class="form-control">
                                            <option value="">Sila Pilih</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div><!-- end row-->
                            <div class="text-center mt-2">
                                <button type="button" onclick="history.back()" class="btn btn-light mr-3">Back</button>
                                <button type="submit" class="btn btn-info">Assign Delivery Driver</button>
                            </div>
                        </form>
                    </div> <!-- end card-body-->
                </div><!-- end card-->
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div>
    <script>
    // USER ERROR PROTECTION (S1): Tactic 2- Display Error for Invalid Dates
        function validateDeliveryDate() {
            const deliveryDate = new Date(document.getElementById('delivery_date').value);
            const updatedAt = new Date("{{ $orders->updated_at }}"); // Assuming $order->updated_at is passed to the view
            const errorMessage = document.getElementById('delivery-error');
            const submitButton = document.getElementById('submit-button');

            // Check if the delivery date is earlier than pickup date or if it's earlier than updated_at
            if (deliveryDate < updatedAt) {
                errorMessage.innerHTML = "The delivery date cannot be earlier than the last update.";
                errorMessage.style.display = "block";
                submitButton.disabled = true;
            } else if (deliveryDate < new Date()) {
                errorMessage.innerHTML = "The delivery date must be a future date.";
                errorMessage.style.display = "block";
                submitButton.disabled = true;
            } else {
                errorMessage.style.display = "none";
                submitButton.disabled = false;
            }
        }
    </script>
@endsection
