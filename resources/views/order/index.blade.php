@extends('layouts/base')
@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mt-2">
                            <h4 class="mx-2 header-title">Order List</h4>
                            @if (auth()->user()->role === 'Customer')
                                <a href="{{ route('order.create') }}" class="btn btn-primary btn-sm"
                                    style="position: absolute; right:2%;">+ New Order</a>
                            @endif
                        </div>
                        <br>
                        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                            <thead style="background: #F9FAFB;">
                                <tr>
                                    <th>No.</th>
                                    @if (auth()->user()->role === 'Staff')
                                        <th>Name</th>
                                    @endif
                                    <th>Laundry Type</th>
                                    <th>Laundry Service</th>
                                    <th>Remark</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        @if (auth()->user()->role === 'Staff')
                                            <td>{{ $order->user->name ?? $order->guest->name }}</td>
                                        @endif
                                        <td>{{ $order->laundryType->laundry_name }}</td>
                                        <td>{{ $order->laundryService->service_name }}</td>
                                        <td>{{ Str::limit($order->remark ?? 'No remarks', 20) }}</td>
                                        <td>RM {{ number_format($order->total_amount, 2) ?? '0.00' }}</td>
                                        <td>
                                            <!-- Display status with badge -->
                                            @if ($order->status === 'Pending')
                                                <span class="badge badge-light badge-pill">Pending</span>
                                            @elseif($order->status === 'Assign Pickup')
                                                <span class="badge badge-secondary badge-pill">Assign Pickup</span>
                                            @elseif($order->status === 'Pickup')
                                                <span class="badge badge-info badge-pill">Pickup</span>
                                            @elseif($order->status === 'In Work')
                                                <span class="badge badge-warning badge-pill">In Work</span>
                                            @elseif($order->status === 'Pay')
                                                <span class="badge badge-danger badge-pill">Pay</span>
                                            @elseif($order->status === 'Assign Delivery')
                                                <span class="badge badge-secondary badge-pill">Assign Delivery</span>
                                            @elseif($order->status === 'Delivery')
                                                <span class="badge badge-info badge-pill">Delivery</span>
                                            @elseif($order->status === 'Complete')
                                                <span class="badge badge-success badge-pill">Complete</span>
                                            @endif
                                        </td>
                                        <td>
                                            <!-- View Page -->
                                            <a href="{{ route('order.show', $order->id) }}" class="action-icon-info"
                                                data-toggle="tooltip" title="Click here to view order"><i
                                                    class="mdi mdi-eye"></i></a>

                                            <!-- Update Status to Pay -->
                                            @if ($order->status === 'In Work' && auth()->user()->role === 'Staff')
                                                <!-- Trigger Icon -->
                                                <a href="javascript:void(0);" class="action-icon-warning"
                                                    data-toggle="modal" data-target="#statusModal-{{ $order->id }}"
                                                    title="Click here to update status">
                                                    <i class="mdi mdi-check-circle-outline"></i>
                                                </a>

                                                <!-- Modal -->
                                                <div class="modal fade" id="statusModal-{{ $order->id }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="statusModalLabel-{{ $order->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="statusModalLabel-{{ $order->id }}">Confirm
                                                                    Update Status</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to update the order status to "Pay"?
                                                                <br>
                                                                Please confirm that all laundry services have been completed
                                                                successfully.
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancel</button>
                                                                <form method="POST"
                                                                    action="{{ route('order.update-status', $order->id) }}">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Confirm</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Edit Page (for Pending orders) -->
                                            @if ($order->status === 'Pending' && auth()->user()->role === 'Staff')
                                                <a href="{{ route('order.edit', $order->id) }}" class="action-icon-success"
                                                    data-toggle="tooltip" title="Click here to update total amount"><i
                                                        class="mdi mdi-square-edit-outline"></i></a>
                                            @elseif ($order->status === 'Assign Pickup' && auth()->user()->role === 'Customer')
                                                <a href="{{ route('order.edit', $order->id) }}" class="action-icon-success"
                                                    data-toggle="tooltip" title="Click here to update order"><i
                                                        class="mdi mdi-square-edit-outline"></i></a>
                                                <a href="#" class="action-icon-danger" data-toggle="modal"
                                                    data-toggle="tooltip" title="Click here to delete order"
                                                    data-target="#delete-modal-{{ $order->id }}"><i
                                                        class="mdi mdi-delete"></i></a>

                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="delete-modal-{{ $order->id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="deleteModalLabel-{{ $order->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-sm modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="font-14"
                                                                    id="deleteModalLabel-{{ $order->id }}">Delete
                                                                    Order</h4>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to delete this order?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light btn-sm"
                                                                    data-dismiss="modal">No, Cancel
                                                                </button>
                                                                <form method="POST"
                                                                    action="{{ route('order.destroy', $order->id) }}">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-danger btn-sm">Yes, Delete
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Modal -->
                                            @elseif($order->status === 'Pay' && auth()->user()->role === 'Customer')
                                                <!-- Pay Action (for Pay or Complete orders) -->
                                                <a href="{{ route('billing.customer.payment.page', $order->id) }}"
                                                    class="side-nav-link action-icon-secondary" data-toggle="tooltip"
                                                    title="Click here to make payment"><i
                                                        class="mdi mdi-credit-card"></i></a>
                                            @endif
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

    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
