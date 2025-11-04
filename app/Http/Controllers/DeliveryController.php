<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Guest;
use Illuminate\Http\Request;
use App\Models\Delivery;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Exists;
use Symfony\Contracts\Service\Attribute\Required;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $pickupCount = Order::where('status', 'Pickup')->count();
        $deliveryCount = Order::where('status', 'Delivery')->count();
        $assignCount = Order::whereIn('status', ['Assign Delivery', 'Assign Pickup'])->count();
        $completeCount = Order::whereIn('status', ['in Work', 'Complete'])->count();

        if ($user->role === 'Staff' && $user->staff->role === 'Manager') {
            // Managers can view all orders and deliveries
            $orders = Order::with(['user', 'guest', 'laundryService', 'delivery'])->get();
            $delivery = Delivery::all();
        } else {
            // Drivers only see their assigned deliveries
            $pickupDeliveries = Delivery::where('pickup_id', $user->id)->get();
            $deliveryDeliveries = Delivery::where('deliver_id', $user->id)->get();

            // Combine the results if needed
            $delivery = $pickupDeliveries->merge($deliveryDeliveries);

            // Retrieve related orders for the deliveries
            $orders = Order::whereIn('id', $delivery->pluck('order_id'))->get();
        }

        return view('delivery.index', compact('orders', 'delivery', 'pickupCount', 'assignCount', 'deliveryCount','completeCount'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function AssignPickupDriver($id)
    {

        $orders = Order::findOrFail($id);
        $users = User::whereHas('staff', function ($query) {
            $query->where('role', 'Pickup & Delivery Driver');
        })->get();

        return view('delivery.create', compact('orders', 'users'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pickup_id' => 'required|exists:users,id',
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = Order::findOrFail($request->order_id);
        $order->status = 'Pickup';
        $order->save();

        $delivery = new Delivery();

        $delivery->order_id = $request->order_id;
        $delivery->pickup_id = $request->pickup_id;

        $delivery->save();
        return redirect()->route('delivery.index')->with('success', 'Pickup Driver Successfully Assigned.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);
        $delivery = Delivery::with(['order', 'pickupDriver', 'deliveryDriver']) // Ensure relationships are loaded
        ->where('order_id', $id) // Match the delivery to the given order
        ->first(); // Retrieve a single Delivery model instance


        return view('delivery.show', compact('order', 'delivery'));
    }


    public function EditProofPickup($id)
    {
        // Fetch the order
        $order = Order::findOrFail($id);

        // Fetch the related delivery, ensuring relationships are loaded
        $delivery = Delivery::with(['order', 'pickupDriver', 'deliveryDriver']) // Load necessary relationships
            ->where('order_id', $id) // Match delivery to the given order
            ->first(); // Retrieve a single Delivery model instance

        if (!$delivery) {
            return redirect()->route('delivery.index')->with('error', 'Delivery record not found for the specified order.');
        }

        return view('delivery.proof-pickup', compact('order', 'delivery'));
    }

    public function ProofPickup(Request $request, $id)
    {
        // --=====FUNCTIONAL CORRECTNESS (S2): Tactic 1- Back-End Validation for Pickup Status Updates  =====--
        $request->validate([
            'proof_pickup' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Find the delivery record
        $delivery = Delivery::findOrFail($id);

        // Update the order status
        $order = Order::findOrFail($delivery->order_id); // Use delivery's `order_id`
        $order->status = 'Pending';
        $order->save();

        // Handle proof pickup file upload if provided
        if ($request->hasFile('proof_pickup')) {
            $originalFileName = $request->file('proof_pickup')->getClientOriginalName();
            $imagePath = $request->file('proof_pickup')->storeAs('public/banner', $originalFileName);
            $delivery->proof_pickup = $imagePath;
        } else {
            return redirect()->back()->withErrors('You must confirm proof of pickup before marking the order as Complete Pickup.');
        }

        // Save the updated delivery record
        $delivery->save();

        return redirect()->route('delivery.index')->with('success', 'Pickup proof uploaded successfully.');
    }




    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $orders = Order::findOrFail($id);
        $delivery = Delivery::with(['order', 'pickupDriver', 'deliveryDriver']) // Ensure relationships are loaded
            ->where('order_id', $id) // Match the delivery to the given order
            ->first(); // Retrieve a single Delivery model instance
        $users = User::whereHas('staff', function ($query) {
            $query->where('role', 'Pickup & Delivery Driver');
        })->get();

        return view('delivery.edit', compact('orders', 'users', 'delivery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Retrieve the pickup date from the order
        $pickupDate = Order::findOrFail($request->order_id)->pickup_date;

 // --=====USER ERROR PROTECTION (S1): Tactic 1 - Implement Date Validation Rules=====--
        $request->validate([
            'deliver_id' => 'required|exists:users,id',
            'delivery_date' => 'nullable|date|after_or_equal:' . $pickupDate . '|after_or_equal:' . now(),
        ], [
            'delivery_date.after_or_equal' => 'The delivery date cannot be earlier than the pickup date or a past date.',
        ]);

        // Update the order status to 'In Work'
        $order = Order::findOrFail($request->order_id);
        $order->status = 'Delivery';
        $order->save();

        $delivery = Delivery::findOrFail($id);
        $delivery->order_id = $request->order_id;
        $delivery->deliver_id = $request->deliver_id;
        $delivery->delivery_date = $request->delivery_date;

        $delivery->save();
        return redirect()->route('delivery.index')->with('success', 'Delivery Driver Successfully Assigned.');
    }


    public function EditProofDeliver($id)
    {
        // Fetch the order
        $order = Order::findOrFail($id);

        // Fetch the related delivery, ensuring relationships are loaded
        $delivery = Delivery::with(['order', 'pickupDriver', 'deliveryDriver']) // Load necessary relationships
            ->where('order_id', $id) // Match delivery to the given order
            ->first(); // Retrieve a single Delivery model instance

        if (!$delivery) {
            return redirect()->route('delivery.index')->with('error', 'Delivery record not found for the specified order.');
        }

        return view('delivery.proof-deliver', compact('order', 'delivery'));
    }

    public function ProofDeliver(Request $request, $id)
    {
         //--===== USER ERROR PROTECTION (S2): Tactic 1-Implement File Format and Size Validation=====--
        $request->validate([
            'proof_deliver' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Find the delivery record
        $delivery = Delivery::findOrFail($id);

        // Update the order status
        $order = Order::findOrFail($delivery->order_id); // Use delivery's `order_id`
        $order->status = 'Complete';
        $order->save();

        // Handle proof pickup file upload if provided
        if ($request->hasFile('proof_deliver')) {
            $originalFileName = $request->file('proof_deliver')->getClientOriginalName();
            $imagePath = $request->file('proof_deliver')->storeAs('public/banner', $originalFileName);
            $delivery->proof_deliver = $imagePath;
        }

        // Save the updated delivery record
        $delivery->save();

        return redirect()->route('delivery.index')->with('success', 'Pickup proof uploaded successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Delivery $delivery)
    {
        //
    }
}
