@extends('layouts.base')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <p class="text-black mb-0">{{ session()->get('success') }}</p>
                            </div>

                            <!-- Auto-dismiss the alert after 3 seconds -->
                            <script>
                                setTimeout(function() {
                                    $('.alert').alert('close');
                                }, 3000); // 3 seconds
                            </script>
                        @endif

                        <div class="row mt-2">
    <h4 class="mx-2 header-title">Inventory Status</h4>
    <div class="ml-auto">
    <a href="{{ route('inventory.purchase') }}" class="btn btn-primary btn-sm">Show List Order</a>
        <a href="{{ route('inventory.create') }}" class="btn btn-primary btn-sm ml-2">+ New Chemical</a>
    </div>
</div>

                        <br>

                        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                            <thead style="background: #F9FAFB;">
                                <tr>
                                    <th>No.</th>
                                    <th>Inventory Number</th>
                                    <th>Name</th>
                                    <th>Details</th>
                                    <th>Stock</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inventories as $inventory)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $inventory->inventory_number }}</td>
                                        <td>{{ $inventory->name }}</td>
                                        <td>{{ $inventory->details ?? 'No details available' }}</td>
                                        <td>
                                            @php
                                                $stockPercentage = ($inventory->current_stock / $inventory->max_stock) * 100;
                                                if ($stockPercentage > 60) {
                                                    $color = 'green';
                                                } elseif ($stockPercentage > 20) {
                                                    $color = 'yellow';
                                                } else {
                                                    $color = 'red';
                                                }
                                            @endphp
                                            <span style="color: {{ $color }};">&#9679;</span>
                                            {{ $inventory->current_stock }}/{{ $inventory->max_stock }}
                                        </td>
                                        <td>
                                            <!-- Edit Icon -->
                                            <a href="{{ route('inventory.edit', $inventory->id) }}" class="text-purple mr-2">
                                                <i class="mdi mdi-square-edit-outline"></i>
                                            </a>

                                           <!-- Purchase Icon -->
                                            <a href="{{ route('inventory.buychemical', $inventory->id) }}" class="text-success mr-2">
                                                <i class="mdi mdi-cart"></i>
                                            </a> 

                                            
                                            <!-- Delete Icon -->
                                            <a href="#" class="text-danger" data-toggle="modal" data-target="#deleteModal-{{ $inventory->id }}">
                                                <i class="mdi mdi-delete"></i>
                                            </a>

                                            <!-- Delete Confirmation Modal -->
                                            <div class="modal fade" id="deleteModal-{{ $inventory->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirm Delete</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete this inventory item?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="{{ route('inventory.destroy', $inventory->id) }}" method="POST">
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

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
@endsection
