<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class BillingPaymentController extends Controller
{
    // Main page for billing and payment
    public function index()
    {
        // Calculate sales summary
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $salesSummary = [
            'thisMonth' => DB::table('orders')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->sum('total_amount'),
            'thisYear' => DB::table('orders')
                ->whereYear('created_at', $currentYear)
                ->sum('total_amount'),
            'total' => DB::table('orders')->sum('total_amount'),
        ];

        // Calculate monthly sales data for chart
        $monthlySales = DB::table('orders')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_amount) as total_sales')
            )
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->pluck('total_sales', 'month'); // Retrieve data as key-value pairs

        $salesData = array_fill(1, 12, 0); // Initialize array with 12 months set to 0
        foreach ($monthlySales as $month => $total) {
            $salesData[$month] = $total;
        }

        // Calculate sales list for table
        $sales = DB::table('orders')
            ->select(
                DB::raw('CAST(MONTH(created_at) AS UNSIGNED) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(total_amount) as total_sales')
            )
            ->whereNotNull('created_at') // Exclude rows with NULL created_at
            ->groupBy('month', 'year')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'asc')
            ->get();


        // Pass data to the view
        return view('billing.billing-payment', compact('salesSummary', 'salesData', 'sales'));
    }


    // Detailed sales report for a specific month and year
    public function salesDetails($month, $year)
    {
        // Fetch the sales details with laundry type and service names
        $salesDetails = DB::table('orders')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id') // Join users for user name
            ->leftJoin('guests', 'orders.guest_id', '=', 'guests.id') // Join guests for guest name
            ->leftJoin('laundry_types', 'orders.laundry_type_id', '=', 'laundry_types.id') // Join laundry types
            ->leftJoin('laundry_services', 'orders.laundry_service_id', '=', 'laundry_services.id') // Join laundry services
            ->whereMonth('orders.created_at', $month)
            ->whereYear('orders.created_at', $year)
            ->select(
                'orders.*',
                DB::raw('COALESCE(users.name, guests.name) as customer_name'),
                'laundry_types.laundry_name as laundry_type',
                'laundry_services.service_name as service_name'
            )
            ->get();

        // Pass the sales details to the view
        return view('billing.sales-details', compact('salesDetails', 'month', 'year'));
    }





    public function payOrder(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|string',
            'bank_name' => 'nullable|string', // For online banking
        ]);
    
        $customerId = auth()->user()->id;
    
        // Fetch the order and ensure it belongs to the logged-in customer
        $order = DB::table('orders')
            ->where('id', $validated['order_id'])
            ->where('user_id', $customerId)
            ->first();
    
        if (!$order || $order->status !== 'Pay') {
            return redirect()->route('order.index')->withErrors('Invalid order or payment is not required.');
        }
    
        // Determine the status based on delivery option
        $status = ($order->delivery_option) ? 'Assign Delivery' : 'Complete';
    
        // Handle payment methods
        if ($validated['payment_method'] === 'paypal') {
            // PayPal is handled via frontend; update status only
            DB::table('orders')
                ->where('id', $validated['order_id'])
                ->update([
                    'status' => $status,
                    'updated_at' => now(),
                    'remark' => 'Paid via PayPal',
                ]);
        } elseif ($validated['payment_method'] === 'online_banking') {
            // Update the order with bank details
            DB::table('orders')
                ->where('id', $validated['order_id'])
                ->update([
                    'status' => $status,
                    'updated_at' => now(),
                    'remark' => 'Paid via ' . $validated['bank_name'],
                ]);
        } elseif ($validated['payment_method'] === 'cash') {
            // Cash payment handling
            DB::table('orders')
                ->where('id', $validated['order_id'])
                ->update([
                    'status' => $status,
                    'updated_at' => now(),
                    'remark' => 'Paid in cash',
                ]);
        }
    
        return redirect()->route('order.index')->with('success', 'Payment successful! Your order is now marked as completed.');
    }
    

    



    public function customerPaymentPage($order_id)
    {
        $customerId = auth()->user()->id; // Get the logged-in customer's ID

        // Fetch the order along with its laundry type, service, and quantity
        $order = DB::table('orders')
            ->join('laundry_types', 'orders.laundry_type_id', '=', 'laundry_types.id')
            ->join('laundry_services', 'orders.laundry_service_id', '=', 'laundry_services.id')
            ->where('orders.id', $order_id)
            ->where('orders.user_id', $customerId)
            ->select(
                'orders.*',
                'laundry_types.laundry_name as laundry_type_name',
                'laundry_services.service_name as service_name',
                'orders.quantity'
            )
            ->first();

        if (!$order || $order->status !== 'Pay') {
            return redirect()->route('order.index')->withErrors('Order not found or not eligible for payment.');
        }

        return view('billing.customer-payment', compact('order'));
    }




    public function generateInvoice($orderId)
    {
        $order = DB::table('orders')
            ->where('id', $orderId)
            ->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }

        if ($order->status !== 'Complete') {
            return redirect()->back()->with('error', 'Invoice is only available for completed orders.');
        }

        // Prepare data for the PDF
        $data = [
            'order' => $order,
            'logo' => asset('assets/images/logo.png'),
            'brandLogo' => asset('assets/images/brand.png'),
        ];

        // Load the view into the PDF
        $pdf = Pdf::loadView('billing.invoice', $data);

        // Return the PDF for download
        return $pdf->download('invoice_' . $order->id . '.pdf');
    }







}



