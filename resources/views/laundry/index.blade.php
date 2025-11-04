@extends('layouts/base')
@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if ($message = session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <p class="text-black mb-0">{{ session()->get('success') }}</p>
                            </div>

                            <!-- Add the following JavaScript to auto-dismiss the alert after 3 seconds -->
                            <script>
                                setTimeout(function() {
                                    $('.alert').alert('close');
                                }, 3000); // 3000 milliseconds = 3 seconds
                            </script>
                        @endif
                        <div class="row mt-2">
                            <h4 class="mx-2 header-title">Laundry Type & Service</h4>
                            <a href="{{ route('laundry.create') }}" class="btn btn-primary btn-sm"
                                style="position: absolute; right:2%;">+
                                Type & Service</a>
                        </div>
                        <br>

                        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                            <thead style="background: #F9FAFB;">
                                <tr>
                                    <th>No.</th>
                                    <th>Laundry Type</th>
                                    <th>Service</th>
                                    <th>Price (per piece)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $service)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $service->laundryType->laundry_name }}</td>
                                        <!-- Display Laundry Type Name -->
                                        <td>{{ $service->service_name }}</td> <!-- Display Service Name -->
                                        <td>RM {{ number_format($service->price, 2) }}</td> <!-- Display Price -->
                                        <td>
                                            <!-- Edit Page-->
                                            <a href="" class="action-icon-success"><i
                                                    class="mdi mdi-square-edit-outline"></i></a>
                                            <!-- Delete -->
                                            <a href="#" class="action-icon-danger" data-toggle="modal"
                                                data-target="#bs-danger-modal-sm"> <i class="mdi mdi-delete"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
@endsection
