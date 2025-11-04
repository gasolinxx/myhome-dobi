<?php

namespace App\Http\Controllers;

use App\Models\ChemicalOrder;
use App\Models\Inventory;
use Illuminate\Http\Request;

class ChemicalOrderController extends Controller
{
    /**
     * Store a newly created chemical order in the database.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'supplier_name' => 'required|string',
            'inventory_id' => 'required|exists:inventories,id',
        ]);

        // Fetch the inventory item
        $inventory = Inventory::findOrFail($request->inventory_id);

        // Create a new chemical order
        ChemicalOrder::create([
            'details' =>  $inventory->name,
            'supplier_name' => $request->supplier_name,
            'quantity' => $request->quantity,
            'inventory_id' => $inventory->id, // Link to the inventory item
        ]);

        

        // Redirect with success message
        return redirect()->route('inventory.index')->with('success', 'Order placed successfully!');
    }

    public function destroy(ChemicalOrder $chemicalOrder)
{

    
    // Delete the chemical order from the database
    $chemicalOrder->delete();
    
    // Redirect back with success message
    return redirect()->route('inventory.purchase')->with('success', 'Chemical order deleted successfully!');
}

}
