<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;    // Import the User model
use App\Models\Product; // Import the Product model
use App\Models\Order;   // Import the Order model

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch key metrics
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount'); // Sum of completed orders

        // Fetch recent users (e.g., last 5 registered)
        $recentUsers = User::latest()->take(5)->get();

        // Fetch recent orders (e.g., last 5 orders, regardless of status)
        $recentOrders = Order::latest()->take(5)->get();

        // Return the dashboard view and pass the fetched data
        return view('backend.dashboard.index', compact(
            'totalUsers',
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'recentUsers',
            'recentOrders'
        ));
    }
}
