<?php

namespace App\Http\Controllers;

use App\Models\Category; // Import the Category model
use App\Models\Product;  // Import the Product model
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page with categories and featured products.
     */
    public function index()
    {
        // Fetch all categories from the database
        $categories = Category::all();

        // Fetch featured products from the database
        // We'll prioritize bestsellers and new products, and then take up to 6.
        $featuredProducts = Product::where('is_bestseller', true)
                                   ->orWhere('is_new', true)
                                   // You can add more ordering if you have specific preferences
                                   // For example, to show bestsellers first, then new, then by creation date:
                                   ->orderBy('is_bestseller', 'desc') // Bestsellers first
                                   ->orderBy('is_new', 'desc')        // Then new products
                                   ->orderBy('created_at', 'desc')    // Fallback to newest if neither
                                   ->limit(6) // <--- CHANGED THIS TO 6
                                   ->get();

        // If for some reason there are fewer than 6 products that are bestsellers or new,
        // you might want to fill the remaining slots with other recent products.
        // This ensures you always try to display 6 if available.
        if ($featuredProducts->count() < 6) {
            $remainingCount = 6 - $featuredProducts->count();
            $additionalProducts = Product::whereNotIn('id', $featuredProducts->pluck('id')) // Exclude already fetched products
                                         ->orderBy('created_at', 'desc') // Get newest products
                                         ->limit($remainingCount)
                                         ->get();
            $featuredProducts = $featuredProducts->merge($additionalProducts);
        }

        // Pass the fetched data to the 'frontend.home.index' view
        return view('frontend.home.index', compact('categories', 'featuredProducts'));
    }
}
