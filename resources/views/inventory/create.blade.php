@extends('layouts.base')

@section('content')
    <div class="mt-4 text-dark ml-2">
        <a href="{{ route('inventory.index') }}" class="mdi mdi-chevron-left text-dark"> Back to Inventory List</a>
    </div>
    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="">New Inventory Item</h4>
                        <p class="text-muted font-13 mb-4">
                            Add a new inventory item to the system here.
                        </p>
                        <form method="POST" action="{{ route('inventory.store') }}">
                            @csrf
                            <div class="row justify-content-center align-items-center g-2">
                                <!-- Inventory Number -->
                                <div class="col-md-6 mt-2">
                                    <label for="inventory_number" class="form-label">Inventory Number</label>
                                    <input type="text" class="form-control" name="inventory_number" placeholder="INV001" required>
                                </div>
                                <!-- Inventory Name -->
                                <div class="col-md-6 mt-2">
                                    <label for="name" class="form-label">Inventory Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Detergent, Bleach, etc." required>
                                </div>
                                <!-- Details -->
                                <div class="col-md-6 mt-2">
                                    <label for="details" class="form-label">Details</label>
                                    <textarea class="form-control" name="details" rows="3" placeholder="Enter brand name..."></textarea>
                                </div>
                                <!-- Current Stock -->
                                <div class="col-md-6 mt-2">
                                    <label for="current_stock" class="form-label">Current Stock</label>
                                    <input type="number" class="form-control" name="current_stock" placeholder="0" required min="0">
                                </div>
                                <!-- Max Stock -->
                                <div class="col-md-6 mt-2">
                                    <label for="max_stock" class="form-label">Maximum Stock</label>
                                    <input type="number" class="form-control" name="max_stock" placeholder="50" required min="1">
                                </div>
                                <!-- Unit -->
                                <div class="col-md-6 mt-2">
                                    <label for="unit" class="form-label">Unit</label>
                                    <input type="text" class="form-control" name="unit" placeholder="Liters, Kg, Pcs, etc." required>
                                </div>
                            </div><!-- end row-->
                            <div class="text-center mt-4">
                                <button type="button" onclick="history.back()" class="btn btn-light mr-3">Back</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div> <!-- end card-body-->
                </div><!-- end card-->
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
@endsection
