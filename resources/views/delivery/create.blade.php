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
                            Please Fill the Form Below
                        </p>
                        <form method="POST" action={{ route('delivery.store') }} enctype="multipart/form-data">
                            @csrf
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
                                        <input type="text" name="order_method" class="form-control"
                                            value="{{ $orders->order_method }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="kiosk-number">Pickup Date</label>
                                        <input type="text" id="pickup_date" class="form-control"
                                            value="{{ \Carbon\Carbon::parse($orders->pickup_date)->format('d F Y') }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="kiosk-number">Pickup Time</label>
                                        <input type="text" id="pickup_time" class="form-control"
                                            value="{{ \Carbon\Carbon::parse($orders->pickup_date)->format('h:i A') }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="example-textarea">Pickup Address</label>
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
                                        <label for="inputPickupDriver" class="col-form-label">Assign Driver</label>
                                        <select id="pickup-driver" name="pickup_id" class="form-control">
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
                              {{--===== // FUNCTIONAL CORRECTNESS (S1): Tactic 2- Disabling the Assign Driver Button Until Schedule is Viewed  =====--}}
                                <button type="submit" class="btn btn-info" 
                                    @if(!session('schedule_viewed')) 
                                        disabled 
                                        data-toggle="tooltip" 
                                        title="This button will be disabled if the staff didn't view the schedule." 
                                    @endif>
                                    Assign Pickup Driver
                                </button>
                            </div>
                        </form>
                    </div> <!-- end card-body-->
                </div><!-- end card-->
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div>
@endsection

@section('scripts')
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip(); // Initialize tooltips
    });
</script>
@endsection