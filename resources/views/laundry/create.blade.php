@extends('layouts/base')
@section('content')
    <div class="mt-4 text-dark ml-2">
        <a href="{{ route('laundry.index') }}" class="mdi mdi-chevron-left text-dark"> Back to Laundry Type & Service</a>
    </div>
    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mt-0 mb-2">Create Laundry Type & Service</h4>
                        <!-- Checkout Steps -->
                        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                            <li class="nav-item">
                                <a href="#type" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
                                    <i class="mdi mdi-tshirt-v font-18"></i>
                                    <span class="d-none d-lg-block">Laundry Type</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#services" data-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
                                    <i class="mdi mdi-cog font-18"></i>
                                    <span class="d-none d-lg-block">Laundry Service</span>
                                </a>
                            </li>
                        </ul>

                        <!-- Steps Information -->
                        <div class="tab-content">
                            <!-- Billing Content-->
                            <div class="tab-pane show active" id="type">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h4 class="mt-0">Laundry Type</h4>

                                        <p class="text-muted mb-4">Fill the form below in order to
                                            create list of laundry type.</p>

                                        <form method="POST" action={{ route('laundry.store') }}>
                                            @csrf
                                            <input type="hidden" name="form_type" value="laundry_type" />
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label for="billing-first-name">Laundry Type</label>
                                                        <input class="form-control" type="text"
                                                            placeholder="Enter your laundry type" name="laundry_name" />
                                                    </div>
                                                </div>
                                            </div> <!-- end row -->

                                            <div class="row mt-4">
                                                <div class="col-sm-7">
                                                    <div class="text-sm-right">
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                    </div>
                                                </div> <!-- end col -->
                                            </div> <!-- end row -->
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Billing Content-->
                            <div class="tab-pane" id="services">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h4 class="mt-0">Laundry Services</h4>

                                        <p class="text-muted mb-4">Fill the form below in order to
                                            create list of laundry services.</p>

                                        <form method="POST" action="{{ route('laundry.store')}}">
                                            @csrf
                                            <input type="hidden" name="form_type" value="laundry_service" />
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="billing-first-name">Laundry Type</label>
                                                        <select name="laundry_type_id" id="laundry_type_id" class="form-control">
                                                            <option selected disabled>Please select...</option>
                                                            @foreach($type as $type)
                                                                <option value="{{ $type->id }}">{{ $type->laundry_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="billing-last-name">Service Name</label>
                                                        <input class="form-control" type="text"
                                                            placeholder="Enter your service name" name="service_name" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="billing-first-name">Price per Piece</label>
                                                        <input class="form-control" type="text"
                                                            placeholder="0" name="price" />
                                                    </div>
                                                </div>
                                            </div> <!-- end row -->

                                            <div class="row mt-4">
                                                <div class="col-sm-7">
                                                    <div class="text-sm-right">
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                    </div>
                                                </div> <!-- end col -->
                                            </div> <!-- end row -->
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
