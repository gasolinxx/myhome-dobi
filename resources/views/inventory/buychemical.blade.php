@extends('layouts.base')

@section('content')
    <div class="container-fluid mt-5">
        <!-- Header -->
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h4 class="header-title">Order Chemical</h4>
                <a href="{{ route('inventory.index') }}" class="mdi mdi-chevron-left text-dark">Back to Inventory List</a>
            </div>
        </div>

        <!-- Order Form -->
        <div class="card">
            <div class="card-body">
                <form action="{{ route('chemical-orders.store') }}" method="POST">
                    @csrf

                    <!-- Inventory Details -->
                    <div class="form-group">
                        <label for="inventory_number">Inventory Number</label>
                        <input type="text" class="form-control" id="inventory_number" value="{{ $inventory->inventory_number }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" value="{{ $inventory->name }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="current_stock">Current Stock</label>
                        <input type="text" class="form-control" id="current_stock" value="{{ $inventory->current_stock }}" disabled>
                    </div>

                    <!-- Order Quantity -->
                    <div class="form-group">
                        <label for="quantity">Quantity to Order</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="" required>
                    </div>

                    <!-- Supplier Selection -->
                    <div class="form-group">
                        <label for="supplier_name">Supplier</label>
                        <select class="form-control" id="supplier_name" name="supplier_name" required>
                            <option value="SM Import and Export SDN. BHD.">SM Import and Export SDN. BHD.</option>
                            <option value="Pakshoo Industrial Group">Pakshoo Industrial Group</option>
                        </select>
                    </div>

                    <!-- Hidden Field for Inventory ID -->
                    <input type="hidden" name="inventory_id" value="{{ $inventory->id }}">

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-success">Submit Order</button>
                </form>
            </div>
        </div>
    </div>
@endsection
