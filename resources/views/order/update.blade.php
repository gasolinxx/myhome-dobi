@extends('layouts.base')
@section('content')
    <div class="mt-4 text-dark ml-2">
        <a href="{{ route('order.index') }}" class="mdi mdi-chevron-left text-dark"> Back to Order List</a>
    </div>
    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-2">Edit Order</h4>
                        <p class="text-muted font-13 mb-1">Modify the details of your order here.</p>
                        <p class="text-muted font-13 mb-3">Fields marked with <span class="text-danger">*</span> are
                            required.</p>
                        <form method="POST" action="{{ route('order.update', $order->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row justify-content-center align-items-center g-2">
                                <!-- Name -->
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name"
                                        value="{{ old('name', $order->user->name) }}" readonly>
                                </div>
                                <!-- Phone Number -->
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone Number<span
                                            class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" name="contact_number"
                                         value="{{ old('contact_number', $order->user->contact_number) }}"
                                        readonly>
                                </div>
                                <!-- Email -->
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email"
                                         value="{{ old('email', $order->user->email) }}"
                                        readonly>
                                </div>
                                <!-- Order Method -->
                                <div class="col-md-6 mb-3">
                                    <label for="order-method" class="form-label">Order Method<span
                                            class="text-danger">*</span><i class="mdi mdi-information" data-toggle="tooltip"
                                            title="Walk in means you drop off at the store. Pickup means we'll take the laundry from your home."></i></label>
                                    <select class="form-select form-control" name="order_method" id="order_method" required
                                        onchange="toggleAddressForm()">
                                        <option value="" disabled>Please Select...</option>
                                        <option value="Walk in"
                                            {{ old('order_method', $order->order_method) == 'Walk in' ? 'selected' : '' }}>
                                            Walk in</option>
                                        <option value="Pickup"
                                            {{ old('order_method', $order->order_method) == 'Pickup' ? 'selected' : '' }}>
                                            Pickup</option>
                                    </select>
                                    @error('order_method')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6"></div>
                                <!-- Delivery Option -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="delivery_option"
                                            id="delivery_option" value="1" onchange="toggleAddressForm()"
                                            {{ old('delivery_option', $order->delivery_option) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="delivery_option">
                                            Please tick if you want the delivery option <i class="mdi mdi-information"
                                                data-toggle="tooltip"
                                                title="Delivery will be made to your home once the laundry is completed."></i>
                                        </label>
                                    </div>
                                </div>
                                <!-- Laundry Type -->
                                <div class="col-md-6 mb-3">
                                    <label for="laundry-type" class="form-label">Laundry Type<span
                                            class="text-danger">*</span></label>
                                    <select name="laundry_type_id" id="laundry_type_id" class="form-select form-control"
                                        required onchange="filterLaundryServices()">
                                        <option value="" disabled>Please Select...</option>
                                        @foreach ($laundryTypes as $type)
                                            <option value="{{ $type->id }}"
                                                {{ old('laundry_type_id', $order->laundry_type_id) == $type->id ? 'selected' : '' }}>
                                                {{ $type->laundry_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('laundry_type_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <!-- Service -->
                                <div class="col-md-6 mb-3">
                                    <label for="service" class="form-label">Service<span
                                            class="text-danger">*</span></label>
                                    <select name="laundry_service_id" id="laundry_service_id"
                                        class="form-select form-control" required>
                                        <option value="" disabled>Please Select...</option>
                                        @foreach ($laundryServices as $service)
                                            <option value="{{ $service->id }} "
                                                data-type="{{ $service->laundry_type_id }}"
                                                {{ old('laundry_service_id', $order->laundry_service_id) == $service->id ? 'selected' : '' }}>
                                                {{ $service->service_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('laundry_service_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <!-- Remark -->
                                <div class="col-md-6 mb-3">
                                    <label for="remark" class="form-label">Remark</label>
                                    <textarea class="form-control" name="remark" rows="3" placeholder="Enter any remarks here...">{{ old('remark', $order->remark) }}</textarea>
                                    @error('remark')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <!-- Address -->
                                <div class="col-md-6 mb-3" id="address_form" style="display: none;">
                                    <label for="address" class="form-label">Address<span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" name="address" rows="3" placeholder="Enter your address...">{{ old('address', $order->address) }}</textarea>
                                    @error('address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <!-- Pickup Date -->
                                <div class="col-md-6 mb-3" id="pickup_date_form" style="display: none;">
                                    <label for="pickup_date" class="form-label">Pickup Date<span
                                            class="text-danger">*</span> <i class="mdi mdi-information"
                                            data-toggle="tooltip"
                                            title="Select a future date and time for your laundry pickup, between Monday to Friday, 8:00 AM to 5:00 PM."></i></label>
                                    <input type="datetime-local" name="pickup_date" id="pickup_date"
                                        class="form-control" value="{{ old('pickup_date', $order->pickup_date) }}">
                                    @error('pickup_date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6"></div>
                            </div>
                            <div class="text-center mt-3">
                                <button type="button" onclick="history.back()" class="btn btn-light mr-3">Back</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>

    <script>
        function filterLaundryServices() {
            const selectedTypeId = document.getElementById('laundry_type_id').value;
            const serviceDropdown = document.getElementById('laundry_service_id');
            for (const option of serviceDropdown.options) {
                if (!option.dataset.type || option.dataset.type == selectedTypeId) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                }
            }
            serviceDropdown.value = '';
        }

        function toggleAddressForm() {
            const orderMethod = document.getElementById('order_method').value;
            const isDelivery = document.getElementById('delivery_option').checked;
            const addressForm = document.getElementById('address_form');
            const pickupDateForm = document.getElementById('pickup_date_form');

            const addressField = document.querySelector('[name="address"]');
            const pickupDateField = document.querySelector('[name="pickup_date"]');

            // Toggle visibility of address and pickup date forms
            addressForm.style.display = (orderMethod === 'Pickup' || isDelivery) ? 'block' : 'none';
            pickupDateForm.style.display = (orderMethod === 'Pickup') ? 'block' : 'none';

            // Set required attributes based on conditions
            if (orderMethod === 'Pickup') {
                pickupDateField.required = true;
                addressField.required = true;
            } else if (isDelivery) {
                pickupDateField.required = false;
                addressField.required = true;
            } else {
                pickupDateField.required = false;
                addressField.required = false;
            }
        }

        // Set minimum date to tomorrow and restrict working hours (8:00 AM to 5:00 PM)
        document.addEventListener('DOMContentLoaded', function() {
            const now = new Date();

            // Set minimum date to tomorrow
            const minDate = new Date(now);
            minDate.setDate(now.getDate() + 1); // Set to tomorrow
            minDate.setHours(8, 0, 0, 0); // Set to 8:00 AM

            // Set the min attribute for the pickup date field
            const dateInput = document.getElementById('pickup_date');
            dateInput.setAttribute('min', minDate.toISOString().slice(0, 16)); // Format to "YYYY-MM-DDTHH:MM"

            // Initialize visibility based on current values
            toggleAddressForm();
        });

        // Validate the pickup date when it changes
        function validatePickupDate() {
            const input = document.getElementById('pickup_date');
            const selectedDate = new Date(input.value);
            const day = selectedDate.getDay(); // Get the day of the week (0-6, where 0 is Sunday and 6 is Saturday)
            const hours = selectedDate.getHours();

            // Check if the selected day is between Monday (1) and Friday (5), and if the time is between 8 AM and 5 PM
            if (day === 0 || day === 6 || hours < 8 || hours >= 17) {
                alert('Pickup date and time must be between Monday to Friday, 8:00 AM to 5:00 PM.');
                input.setCustomValidity('Invalid date or time');
            } else {
                input.setCustomValidity('');
            }
        }

        // Listen for changes on the pickup date input
        document.getElementById('pickup_date').addEventListener('change', validatePickupDate);

        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
