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
                        <h4 class="">Edit Inventory Item</h4>
                        <p class="text-muted font-13 mb-4">
                            Update the details of the inventory item.
                        </p>

                        <form method="POST" action="{{ route('inventory.update', $inventory->id) }}">
                            @csrf
                            @method('PUT') <!-- Use PUT method for updates -->

                            <div class="row justify-content-center align-items-center g-2">
                                <!-- Inventory Number -->
                                <div class="col-md-6 mt-2">
                                    <label for="inventory_number" class="form-label">Inventory Number</label>
                                    <input type="text" class="form-control" name="inventory_number" 
                                        value="{{ $inventory->inventory_number }}" required>
                                </div>
                                <!-- Inventory Name -->
                                <div class="col-md-6 mt-2">
                                    <label for="name" class="form-label">Inventory Name</label>
                                    <input type="text" class="form-control" name="name" 
                                        value="{{ $inventory->name }}" required>
                                </div>
                                <!-- Details -->
                                <div class="col-md-6 mt-2">
                                    <label for="details" class="form-label">Details</label>
                                    <textarea class="form-control" name="details" rows="3">{{ $inventory->details }}</textarea>
                                </div>
                                <!-- Current Stock -->
                                <div class="col-md-6 mt-2">
                                    <label for="current_stock" class="form-label">Current Stock</label>
                                    <input type="number" class="form-control" name="current_stock" 
                                        value="{{ $inventory->current_stock }}" required min="0">
                                </div>
                                <!-- Max Stock -->
                                <div class="col-md-6 mt-2">
                                    <label for="max_stock" class="form-label">Maximum Stock</label>
                                    <input type="number" class="form-control" name="max_stock" 
                                        value="{{ $inventory->max_stock }}" required min="1">
                                </div>
                                <!-- Unit -->
                                <div class="col-md-6 mt-2">
                                    <label for="unit" class="form-label">Unit</label>
                                    <input type="text" class="form-control" name="unit" 
                                        value="{{ $inventory->unit }}" required>
                                </div>
                            </div><!-- end row-->

                            <div class="text-center mt-4">
                                <button type="button" onclick="history.back()" class="btn btn-light mr-3">Back</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>

                    </div> <!-- end card-body-->
                </div><!-- end card-->
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
@endsection
