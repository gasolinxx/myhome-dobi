@extends('layouts.base')

@section('content')
    <div class="container-fluid mt-5">
        <!-- Header -->
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h4 class="header-title">Chemical Order Details</h4>
                <a href="{{ route('inventory.index') }}" class="mdi mdi-chevron-left text-dark">Back to Inventory List</a>
            </div>
        </div>

        <!-- Table -->
        <div class="card">
            <div class="card-body">
                <table id="chemical-table" class="table table-hover dt-responsive nowrap w-100">
                    <thead style="background: #F9FAFB;">
                        <tr>
                            <th>No.</th>
                            <th>Details</th>
                            <th>Supplier Name</th>
                            <th>Quantity/pcs</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($chemicalOrders as $chemicalOrder)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $chemicalOrder->details }}</td>
                                <td>{{ $chemicalOrder->supplier_name ?? 'N/A' }}</td>
                                <td>{{ $chemicalOrder->quantity }}</td>
                                <td>
    <!-- Delete Icon -->
    <a href="#" class="text-danger" data-toggle="modal" data-target="#deleteModal-{{ $chemicalOrder->id }}">
        <i class="mdi mdi-delete"></i>
    </a>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal-{{ $chemicalOrder->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this order?
                </div>
                <div class="modal-footer">
                    <!-- Delete Form -->
                    <form action="{{ route('chemical-orders.destroy', $chemicalOrder->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Buttons -->
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('inventory.index') }}" class="btn btn-secondary mr-2">Back</a>
                    <button onclick="window.print()" class="btn btn-success">Print</button>
                </div>
            </div>
        </div>
    </div>
@endsection
