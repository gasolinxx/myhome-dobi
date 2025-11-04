<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Delivery;
use App\Models\LaundryService;
use App\Models\LaundryType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as DomPDF;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['user', 'laundryService', 'laundryType']);

        // Check if the user is a staff member with restricted roles (e.g., Dry Cleaner, Washer/Folder, etc.)
        if (auth()->user()->role === 'Customer') {
            // If the user is a customer, get their specific orders (show all statuses for customers)
            $userId = auth()->user()->id;
            $orders = $orders->where('user_id', $userId);
        } elseif (in_array(auth()->user()->staff->role, ['Dry Cleaner', 'Washer/Folder', 'Presser/Ironing', 'Dryer'])) {
            // If the user is a restricted staff role, only get orders with "In Work" status
            $orders = $orders->where('status', 'In Work');
        } else {
            $orders = $orders->whereIn('status', ['Pending', 'In Work', 'Pay', 'Complete']);
        }

        // Retrieve orders, ordered by the predefined status order for customers
        if (auth()->user()->role === 'Customer') {
            $orders = $orders->orderByRaw("FIELD(status, 'Assign Pickup', 'Pickup', 'Pending', 'In Work', 'Pay', 'Assign Delivery', 'Delivery', 'Complete')")->get();
        } else {
            // For staff, we order based on their specific role
            $orders = $orders->orderByRaw("FIELD(status, 'Pending', 'In Work', 'Pay', 'Complete')")->get();
        }

        return view('order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('id', auth()->user()->id)->first();
        $laundryServices = LaundryService::all();
        $laundryTypes = LaundryType::all();
        return view('order.create', compact('users', 'laundryServices', 'laundryTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate data based on order_method and delivery_option
        $request->validate([
            'order_method' => 'required|in:Walk in,Pickup',
            'laundry_type_id' => 'required|exists:laundry_types,id',
            'laundry_service_id' => 'required|exists:laundry_services,id',
            'remark' => 'nullable|string',
            'delivery_option' => 'nullable|boolean',
            'address' => 'nullable|string|required_if:order_method,Pickup|required_if:delivery_option,true',
            'pickup_date' => 'nullable|date|after:now|required_if:order_method,Pickup',
        ]);
    
        // Create a new order
        $order = Order::create([
            'user_id' => auth()->user()->id,
            'order_method' => $request->order_method,
            'laundry_type_id' => $request->laundry_type_id,
            'laundry_service_id' => $request->laundry_service_id,
            'delivery_option' => $request->delivery_option ?? false,
            'address' => $request->address ?? null,
            'pickup_date' => $request->pickup_date ?? null,
            'remark' => $request->remark ?? null,
            'status' => $request->order_method === 'Pickup' ? 'Assign Pickup' : 'Pending',
        ]);
    
        // Redirect with a success message
        return redirect()->route('order.index')->with('success', 'Order created successfully!');
    }
    
    



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Fetch the order with its related data
        $order = Order::with(['user', 'laundryService', 'laundryType'])
            ->findOrFail($id);
        $delivery = Delivery::with(['order', 'pickupDriver', 'deliveryDriver']) // Ensure relationships are loaded
            ->where('order_id', $id) // Match the delivery to the given order
            ->first(); // Retrieve a single Delivery model instance

        // Pass the order data to the view
        return view('order.show', compact('order', 'delivery'));
    }

    // Show the edit page
    public function edit($id)
    {

        $order = Order::findOrFail($id); // Fetch the order by ID
        $laundryTypes = LaundryType::all(); // Fetch laundry types
        $laundryServices = LaundryService::all(); // Fetch laundry services

        if (auth()->user()->role === 'Customer') {
            return view('order.update', compact('order', 'laundryTypes', 'laundryServices'));
        } elseif (auth()->user()->role === 'Staff') {
            return view('order.edit', compact('order', 'laundryTypes', 'laundryServices'));
        }
    }

    // Update the order
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
    
        // Validate the incoming data
        $validatedData = $request->validate([
            'order_method' => 'required|string|in:Walk in,Pickup',
            'delivery_option' => 'nullable|boolean',
            'laundry_type_id' => 'required|exists:laundry_types,id',
            'laundry_service_id' => 'required|exists:laundry_services,id',
            'address' => 'nullable|string|max:500|required_if:order_method,Pickup',
            'remark' => 'nullable|string|max:500',
            'pickup_date' => 'nullable|date|after:now|required_if:order_method,Pickup',
        ]);
    
        // Update the order fields
        $order->order_method = $validatedData['order_method'];
        $order->delivery_option = $request->has('delivery_option') ? 1 : 0;
        $order->laundry_type_id = $validatedData['laundry_type_id'];
        $order->laundry_service_id = $validatedData['laundry_service_id'];
        $order->remark = $validatedData['remark'] ?? null;
    
        // Handle address and pickup_date based on order_method
        if ($validatedData['order_method'] === 'Walk in') {
            $order->address = null; // Set address to null for "Walk in"
            $order->pickup_date = null; // Set pickup_date to null for "Walk in"
        } else {
            $order->address = $validatedData['address'] ?? null;
            $order->pickup_date = $validatedData['pickup_date'] ?? null;
        }
    
        $order->save(); // Save the updated order
    
        return redirect()->route('order.index')->with('success', 'Order updated successfully!');
    }
    

    public function updateQuantity(Request $request, $id)
    {
        // Validate the input
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'delivery_fee' => 'nullable|numeric|min:0', // Delivery fee is optional
        ]);

        // Find the order by ID
        $order = Order::findOrFail($id);

        // Update the quantity
        $order->quantity = $request->input('quantity');

        // Get the price per unit from the related service
        $pricePerUnit = $order->laundryService->price;

        // Get the delivery fee (if provided), otherwise default to 0
        $deliveryFee = $request->input('delivery_fee', 0);

        // Update the delivery fee in the order
        $order->delivery_fee = $deliveryFee;

        // Recalculate the total amount
        $order->total_amount = ($order->quantity * $pricePerUnit) + $deliveryFee;

        // Update the order status based on the order method
        $order->status = 'In Work';

        // Save the updated order
        $order->save();

        // Redirect back with a success message
        return redirect()->route('order.index')->with('success', 'Order quantity updated successfully.');
    }


    public function destroy($id)
    {
        // Find the order by ID
        $order = Order::findOrFail($id);

        // Check if the order has a delivery or pickup option
        if ($order->delivery_option === true || $order->order_method === 'Pickup') {
            // Find and delete the associated delivery record
            $delivery = Delivery::where('order_id', $order->id)->first();
            if ($delivery) {
                $delivery->delete();
            }
        }

        // Delete the order
        $order->delete();

        // Redirect back with a success message
        return redirect()->route('order.index')->with('success', 'Order data deleted successfully.');
    }


    public function updateStatus($id)
    {
        // Find the order
        $order = Order::find($id);

        if (!$order) {
            return redirect()->route('order.index')->withErrors('Order not found.');
        }

        // Check the current status
        if ($order->status === 'Pending' || $order->status === 'In Work') {
            // Update the status to "Pay"
            $order->status = 'Pay';
            $order->save();

            return redirect()->route('order.index')->with('success', 'Order status updated to Pay.');
        }

        // Return with an error if the status cannot be updated
        return redirect()->route('order.index')->withErrors('Order status cannot be updated.');
    }

    // Proof of Pickup PDF
    public function generateProofOfPickup($id)
    {
        $order = Order::with('delivery') // Optionally, load delivery if needed
            ->findOrFail($id);

        $pdf = PDF::loadView('order.proof-of-pickup', compact('order'));
        return $pdf->download('Proof_of_Pickup_Order_' . $order->id . '.pdf');
    }

    // Proof of Delivery PDF
    public function generateProofOfDelivery($id)
    {
        $order = Order::with('delivery') // Optionally, load delivery if needed
            ->findOrFail($id);

        $pdf = PDF::loadView('order.proof-of-delivery', compact('order'));
        return $pdf->download('Proof_of_Delivery_Order_' . $order->id . '.pdf');
    }
}
