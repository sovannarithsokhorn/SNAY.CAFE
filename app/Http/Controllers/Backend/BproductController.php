<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class BproductController extends Controller
{
    /**
     * Display a listing of products for management.
     */
    public function index()
    {
        $allProducts = Product::with('category')->latest()->get();
        $allCategories = Category::all();

        return view('backend.products.index', compact('allProducts', 'allCategories'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $allCategories = Category::all();
        return view('backend.products.add', compact('allCategories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_en' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0|gt:price',
            'stock' => 'required|integer|min:0',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_bestseller' => 'boolean',
            'is_organic' => 'boolean',
            'is_new' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $imagePath = null;
        if ($request->hasFile('image_file')) {
            $image = $request->file('image_file');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $directory = 'product_images';
            $fullPath = $directory . '/' . $filename;

            try {
                $image->storeAs($directory, $filename, 'public');
                $imagePath = $fullPath;

            } catch (\Exception $e) {
                \Log::error('Image processing failed: ' . $e->getMessage());
                $image->storeAs($directory, $filename, 'public');
                $imagePath = $fullPath;
            }
        }

        Product::create([
            'name_en' => $request->name_en,
            'description_en' => $request->description_en,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'old_price' => $request->old_price,
            'stock' => $request->stock,
            'image_url' => $imagePath,
            'is_bestseller' => $request->has('is_bestseller'),
            'is_organic' => $request->has('is_organic'),
            'is_new' => $request->has('is_new'),
        ]);

        // Keep this returning JSON as it's handled by AJAX in add.blade.php
        return response()->json([
            'success' => true,
            'message' => 'Product "' . $request->name_en . '" added successfully!',
        ]);
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $allCategories = Category::all();
        return view('backend.products.edit', compact('product', 'allCategories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name_en' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0|gt:price',
            'stock' => 'required|integer|min:0',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_bestseller' => 'boolean',
            'is_organic' => 'boolean',
            'is_new' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->except(['_token', '_method', 'image_file']);

        if ($request->hasFile('image_file')) {
            if ($product->image_url) {
                Storage::disk('public')->delete($product->image_url);
            }

            $image = $request->file('image_file');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $directory = 'product_images';
            $fullPath = $directory . '/' . $filename;

            try {
                $image->storeAs($directory, $filename, 'public');
                $data['image_url'] = $fullPath;

            } catch (\Exception $e) {
                \Log::error('Image processing failed during update: ' . $e->getMessage());
                $image->storeAs($directory, $filename, 'public');
                $data['image_url'] = $fullPath;
            }
        }

        $product->update($data);

        // Keep this returning JSON as it's handled by AJAX in edit.blade.php
        return response()->json([
            'success' => true,
            'message' => 'Product "' . $product->name_en . '" updated successfully!',
        ]);
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image_url) {
            Storage::disk('public')->delete($product->image_url);
        }
        $productName = $product->name_en;
        $product->delete();

        // CRITICAL CHANGE: Redirect back with a success message for traditional form submission
        return redirect()->route('admin.products.index')->with('success', 'Product "' . $productName . '" deleted successfully!');
    }
}
