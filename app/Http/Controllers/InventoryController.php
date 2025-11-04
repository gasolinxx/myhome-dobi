<?php

namespace App\Http\Controllers;

use App\Models\ChemicalOrder;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all inventory items
        $inventories = Inventory::all();

        // Pass the inventory data to the view
        return view('inventory.index', compact('inventories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inventory.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'inventory_number' => 'required|string|unique:inventories,inventory_number|max:255',
            'name' => 'required|string|max:255',
            'details' => 'nullable|string',
            'current_stock' => 'required|integer|min:0',
            'max_stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
        ]);

        // Create a new inventory record
        Inventory::create([
            'inventory_number' => $request->input('inventory_number'),
            'name' => $request->input('name'),
            'details' => $request->input('details'),
            'current_stock' => $request->input('current_stock'),
            'max_stock' => $request->input('max_stock'),
            'unit' => $request->input('unit'),
        ]);

        return redirect()->route('inventory.index')->with('success', 'Inventory item created successfully!');
    }

    public function show()
    {
        // Fetch all chemical orders
        $chemicalOrders = ChemicalOrder::all();
        
        // Return the view with the data
        return view('inventory.show', compact('chemicalOrders'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        // Show the edit form with existing inventory data
        return view('inventory.edit', compact('inventory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        // Validate the updated data
        $request->validate([
            'name' => 'required|string|max:255',
            'details' => 'nullable|string',
            'current_stock' => 'required|integer|min:0',
            'max_stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
        ]);

        // Update the inventory record
        $inventory->update([
            'name' => $request->input('name'),
            'details' => $request->input('details'),
            'current_stock' => $request->input('current_stock'),
            'max_stock' => $request->input('max_stock'),
            'unit' => $request->input('unit'),
        ]);

        return redirect()->route('inventory.index')->with('success', 'Inventory item updated successfully!');
    }

    public function buy(Inventory $inventory)
    {
        // Return the buychemical view with the inventory data
        return view('inventory.buychemical', compact('inventory'));
    }

    
public function storeChemicalOrder(Request $request)
{
    // Validate the incoming request
    $request->validate([
        'quantity' => 'required|integer|min:1',
        'company' => 'required|in:SM Import and Export SDN. BHD.,Pakshoo Industrial Group',
        'inventory_id' => 'required|exists:inventories,id',
    ]);

    // Create a new chemical order
    ChemicalOrder::create([
        'quantity' => $request->input('quantity'),
        'supplier_name' => $request->input('company'),
        'inventory_id' => $request->input('inventory_id'),
    ]);

    // Update inventory stock (reduce the quantity based on the order)
    $inventory = Inventory::find($request->input('inventory_id'));
    $inventory->current_stock -= $request->input('quantity');
    $inventory->save();

    // Redirect back to the inventory page with a success message
    return redirect()->route('inventory.index')->with('success', 'Chemical order placed successfully!');
}


    

    public function purchase()
{
    // Fetch all chemical orders from the database
    $chemicalOrders = ChemicalOrder::all();

    // Return the view with the chemical orders data
    return view('inventory.purchase', compact('chemicalOrders'));
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        // Delete the inventory item
        $inventory->delete();

        return redirect()->route('inventory.index')->with('success', 'Inventory item deleted successfully!');
    }
}
