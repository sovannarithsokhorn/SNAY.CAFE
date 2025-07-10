<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Apply search filter
        if ($request->has('search') && $request->input('search') != '') {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name_en', 'like', '%' . $search . '%')
                  ->orWhere('description_en', 'like', '%' . $search . '%');
                // Add more fields if you have them, e.g., 'name_km', 'description_km'
            });
        }

        // Apply category filter
        if ($request->has('category') && $request->input('category') != 'all') {
            $categoryId = $request->input('category');
            $query->where('category_id', $categoryId);
        }

        // NEW: Apply sorting
        if ($request->has('sort_by')) {
            switch ($request->input('sort_by')) {
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'bestseller':
                    // Assuming 'is_bestseller' is a boolean (1 or 0)
                    // We sort by bestseller first, then by created_at for consistency
                    $query->orderBy('is_bestseller', 'desc')->orderBy('created_at', 'desc');
                    break;
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'default':
                default:
                    $query->orderBy('name_en', 'asc'); // Default sorting by name
                    break;
            }
        } else {
            $query->orderBy('name_en', 'asc'); // Default sorting if no sort_by parameter
        }


        $products = $query->paginate(12); // Paginate the results
        $categories = Category::all(); // Get all categories for the filter dropdown

        return view('frontend.products.index', compact('products', 'categories'));
    }

    /**
     * Display the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\View\View
     */
    public function show(Product $product)
    {
        // Eager load category if needed on single product view
        $product->load('category');
        return view('frontend.products.show', compact('product'));
    }
}
