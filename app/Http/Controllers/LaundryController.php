<?php

namespace App\Http\Controllers;

use App\Models\LaundryType;
use App\Models\LaundryService;
use Illuminate\Http\Request;

class LaundryController extends Controller
{
    /**
     * Display a listing of the resource....
     */
    public function index()
    {
        // Fetch all laundry types and services with relationships
        $services = LaundryService::with('laundryType')->get()
        ->sortBy(fn($service) => $service->laundryType->laundry_name);

        // Pass the data to the view
        return view('laundry.index', compact( 'services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type = LaundryType::all();
        return view('laundry.create', compact('type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Handle the creation of Laundry Type
        if ($request->input('form_type') === 'laundry_type') {
            // Validate the incoming request to ensure 'laundry_name' is unique and required
            $request->validate([
                'laundry_name' => 'required|string|max:255|unique:laundry_types,laundry_name',
            ]);
    
            // Create the new LaundryType record with the validated name
            LaundryType::create([
                'laundry_name' => $request->input('laundry_name'),
            ]);
        }
        // Handle the creation of Laundry Service
        else if ($request->input('form_type') === 'laundry_service') {
            // Validate the incoming request to ensure all required fields are provided
            $request->validate([
                'service_name' => 'required|string|max:255',
                'laundry_type_id' => 'required|exists:laundry_types,id',
                'price' => 'required|numeric',
            ]);
    
            // Create the new LaundryService record
            LaundryService::create([
                'service_name' => $request->input('service_name'),
                'laundry_type_id' => $request->input('laundry_type_id'),
                'price' => $request->input('price'),
            ]);
        }
    
        // Redirect back with success message
        return redirect()->route('laundry.index')->with('success', 'Record Inserted Successfully!');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
