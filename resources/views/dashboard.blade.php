@extends('layouts.base')
@section('content')

    @if (auth()->user()->role === 'Admin')
        <div class="container mt-4">
            <h4>Admin Dashboard</h4>

            <!-- Sales Summary Section -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Sales</h5>
                            <p class="card-text h4">RM {{ number_format($totalSales, 2) }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Orders</h5>
                            <p class="card-text h4">{{ $totalOrders }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer List Section -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Customer List</h5>
                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                        <thead style="background: #F9FAFB;">
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Contact Number</th>
                                <th>Total Orders</th>
                                <th>Total Spent</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->user->contact_number  ?? 'N/A' }}</td>
                                    <td>{{ $order->user->orders->count() }}</td>
                                    <td>RM {{ number_format($order->user->orders->sum('total_amount'), 2) }}</td>
                                    <td>
                                        <!-- View Page -->
                                        <a href="{{ route('order.show', $order->id) }}" class="action-icon-info"
                                            data-toggle="tooltip" title="View Order"><i class="mdi mdi-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    @if (auth()->user()->role === 'Customer')
        <div class="container mt-4">
            <h2 class="mb-4">Welcome, {{ $customer->name }}!</h2>

            <div class="row">
                <!-- Customer Info -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Profile Info</h5>
                            <p><strong>Name:</strong> {{ $customer->name }}</p>
                            <p><strong>Email:</strong> {{ $customer->email }}</p>
                            <p><strong>Phone:</strong> {{ $customer->contact_number ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Recent Orders</h5>
                            @if ($recentOrders->isEmpty())
                                <p>You have no recent orders.</p>
                            @else
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Laundry Type</th>
                                            <th>Laundry Services</th>
                                            <th>Status</th>
                                            <th>Total Amount</th>
                                            <th>Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentOrders as $index => $order)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $order->laundryService->service_name }}</td>
                                                <td>{{ $order->laundryType->laundry_name }}</td>
                                                <td>{{ $order->status }}</td>
                                                <td>RM {{ number_format($order->total_amount, 2) }}</td>
                                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (auth()->user()->role === 'Staff')
        <div class="row mt-3">
            <div class="col-lg-3">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-right">
                            <i class="mdi mdi-account-multiple widget-icon" style="color: black; "></i>
                        </div>
                        <h5 class="text-muted font-weight-normal mt-0" title="Order Today">Order Today</h5>
                        <h3 class="mt-3 mb-3">{{ $orderToday }} </h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-right">
                            <i class="mdi mdi-account-multiple widget-icon" style="color: black;"></i>
                        </div>
                        <h5 class="text-muted font-weight-normal mt-0" title="Overdue Jobs">Overdue Jobs</h5>
                        <h3 class="mt-3 mb-3">{{ $overdueJobs }} </h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-right">
                            <i class="mdi mdi-pulse widget-icon" style="color: black; "></i>
                        </div>
                        <h5 class="text-muted font-weight-normal mt-0" title="This Month Sales ">This Month Sales </h5>
                        <h3 class="mt-3 mb-3">RM {{ number_format($thisMonthSales, 2) }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-right">
                            <i class="mdi mdi-pulse widget-icon" style="color: black; "></i>
                        </div>
                        <h5 class="text-muted font-weight-normal mt-0" title="This Year Sales">This Year Sales </h5>
                        <h3 class="mt-3 mb-3">RM {{ number_format($thisYearSales, 2) }}</h3>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mt-2">
                            <h4 class="mx-2 header-title">Customer List</h4>
                        </div>
                        <br>

                        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                            <thead style="background: #F9FAFB;">
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Phone Number</th>
                                    <th>Service</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $key => $order)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $order->user ? $order->user->name : ($order->guest ? $order->guest->name : 'N/A') }}
                                        </td>
                                        <td>{{ $order->user ? $order->user->contact_number : ($order->guest ? $order->guest->contact_number : 'N/A') }}
                                        </td>
                                        <td>{{ $order->laundryService ? $order->laundryService->service_name : 'N/A' }}
                                        </td>
                                        <td>
                                            <!-- View -->
                                            <a href="#" data-toggle="modal"
                                                data-target="#view-order-{{ $order->id }}" class="action-icon-success">
                                                <i class="mdi mdi-eye"></i>
                                            </a>

                                            <!-- Delete -->
                                            <a href="#" data-toggle="modal"
                                                data-target="#delete-order-{{ $order->id }}" class="action-icon-danger">
                                                <i class="mdi mdi-delete"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- View Modal -->
                                    <div id="view-order-{{ $order->id }}" class="modal fade" tabindex="-1"
                                        role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Order Details</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label>Customer Name</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $order->user ? $order->user->name : ($order->guest ? $order->guest->name : 'N/A') }}"
                                                                    readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label>Phone Number</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $order->user ? $order->user->contact_number : ($order->guest ? $order->guest->contact_number : 'N/A') }}"
                                                                    readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label>Service</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $order->laundryService ? $order->laundryService->service_name : 'N/A' }}"
                                                                    readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label>Quantity</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $order->quantity ?? 'N/A' }}" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label>Remark</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $order->remark ?? 'N/A' }}" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label>Total Amount</label>
                                                                <input type="text" class="form-control"
                                                                    value="${{ number_format($order->total_amount, 2) }}"
                                                                    readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label>Order Method</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $order->order_method }}" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label>Delivery Option</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $order->delivery_option }}" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label>Pickup Date</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $order->pickup_date ? \Carbon\Carbon::parse($order->pickup_date)->format('d M Y ') : 'N/A' }}"
                                                                    readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label>Address</label>
                                                                <textarea class="form-control" rows="2" readonly>{{ $order->address ?? 'N/A' }}</textarea>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div id="delete-order-{{ $order->id }}" class="modal fade" tabindex="-1"
                                        role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-sm modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Confirm Deletion</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete
                                                        <strong>{{ $order->user ? $order->user->name : ($order->guest ? $order->guest->name : 'this order') }}</strong>?
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('customers.destroy', $order->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-light"
                                                            data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No customers found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div> <!-- end row -->

        @if ($showTutorial)
            <!-- Tutorial Overlay -->
            <div id="tutorial-overlay"
                style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.6); z-index: 9999; display: flex; justify-content: center; align-items: center;">
                <!-- Arrow Pointer -->
                <div style="position: absolute; top: 240px; left: 180px; transform: rotate(-45deg); z-index: 10000;">
                    <i class="uil uil-arrow-left" style="font-size: 60px; color: #39afd1;"></i>
                </div>

                <!-- Tooltip -->
                <div
                    style="position: absolute; top: 250px; left: 240px; background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); max-width: 300px; z-index: 10000;">
                    <h5 class="text-dark font-weight-bold">Welcome!</h5>
                    <p class="text-dark" style="font-size: 14px;">This is your <strong>Schedule</strong>. Click on the
                        sidebar link to view your schedule.</p>
                    <button id="dismiss-tutorial" class="btn btn-primary btn-sm">Got it, Don’t Show Again</button>
                </div>
            </div>

            <!-- JavaScript -->
            <script>
                document.getElementById('dismiss-tutorial').addEventListener('click', function() {
                    fetch('{{ route('dismiss.schedule.tutorial') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    }).then(response => {
                        if (response.ok) {
                            document.getElementById('tutorial-overlay').style.display = 'none';
                        } else {
                            console.error('Error dismissing tutorial');
                        }
                    }).catch(error => console.error('Fetch error:', error));
                });
            </script>
        @endif
    @endif


@endsection
