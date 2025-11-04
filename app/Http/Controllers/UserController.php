<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'Staff') {
            $user = auth()->user();

            // Check if this user has already dismissed the tutorial
            $showTutorial = !$user->has_seen_schedule_tutorial;

            // Total orders for today
            $orderToday = Order::whereDate('created_at', Carbon::today())
                ->count();

            // Overdue Jobs (orders with status 'Pending' and created before today)
            $overdueJobs = Order::where('status', 'Pending')
                ->whereDate('created_at', '<', Carbon::today())
                ->count();

            // This month's sales (sum total_amount for the current month)
            $thisMonthSales = Order::whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->sum('total_amount');

            // This year's sales (sum total_amount for the current year)
            $thisYearSales = Order::whereYear('created_at', Carbon::now()->year)
                ->sum('total_amount');

            // Fetch orders with their user, guest, and service details
            $orders = Order::with(['user', 'guest', 'laundryService'])->get();

            // Pass variables to the view
            return view('dashboard', compact('showTutorial', 'orderToday', 'overdueJobs', 'thisMonthSales', 'thisYearSales', 'orders'));
        } elseif (auth()->user()->role === 'Admin') {

            // Get orders with the related user
            $orders = Order::with('user')->get();

            $totalSales = Order::sum('total_amount'); // Total sales
            $totalOrders = Order::count(); // Total orders

            return view('dashboard', compact('orders', 'totalSales', 'totalOrders'));
        } else {
            $customerId = auth()->user()->id;

            // Fetch customer information
            $customer = auth()->user();

            // Fetch recent orders for the logged-in customer
            $recentOrders = Order::where('user_id', $customerId)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            return view('dashboard', compact('customer', 'recentOrders'));
        }

    }


    // Delete an order
    public function destroy($id)
    {
        // Find the order
        $order = Order::find($id);

        if ($order) {
            $order->delete();
            return redirect()->route('dashboard')->with('success', 'Order deleted successfully!');
        }

        return redirect()->route('customers.index')->with('error', 'Order not found!');
    }

    public function dismissScheduleTutorial()
    {
        $user = auth()->user();

        if ($user) {
            DB::table('users')
                ->where('id', $user->id)
                ->update(['has_seen_schedule_tutorial' => true]);

            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'User not authenticated'], 401);
    }



}
