<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage; // Import Storage facade

class BcategoryController extends Controller
{
    /**
     * Display a listing of categories for management.
     */
    public function index()
    {
        $allCategories = Category::all();
        return view('backend.categories.index', compact('allCategories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('backend.categories.add');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_en' => 'required|string|max:255',
            'name_km' => 'nullable|string|max:255', // Added validation for name_km
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Added image validation
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with(['_add_form' => true]);
        }

        $imagePath = null;
        if ($request->hasFile('image_file')) {
            $image = $request->file('image_file');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $directory = 'category_images';
            $fullPath = $directory . '/' . $filename;

            try {
                $image->storeAs($directory, $filename, 'public');
                $imagePath = $fullPath;
            } catch (\Exception $e) {
                \Log::error('Image upload failed for category: ' . $e->getMessage());
                // Optionally, return with an error message
                return redirect()->back()->withErrors(['image_file' => 'Failed to upload image.'])->withInput()->with(['_add_form' => true]);
            }
        }

        Category::create([
            'name_en' => $request->name_en,
            'name_km' => $request->name_km, // Save name_km
            'image_url' => $imagePath, // Save image path
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category added successfully!');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category)
    {
        return view('backend.categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name_en' => 'required|string|max:255',
            'name_km' => 'nullable|string|max:255', // Added validation for name_km
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Added image validation
            'remove_image' => 'nullable|boolean', // Hidden field to track image removal
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with(['_edit_form' => true, 'edited_category_id' => $category->id]);
        }

        $data = $request->only(['name_en', 'name_km']); // Include name_km in data
        $imagePath = $category->image_url; // Default to existing image

        if ($request->hasFile('image_file')) {
            // Delete old image if it exists
            if ($category->image_url) {
                Storage::disk('public')->delete($category->image_url);
            }

            $image = $request->file('image_file');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $directory = 'category_images';
            $fullPath = $directory . '/' . $filename;

            try {
                $image->storeAs($directory, $filename, 'public');
                $imagePath = $fullPath;
            } catch (\Exception $e) {
                \Log::error('Image upload failed for category update: ' . $e->getMessage());
                return redirect()->back()->withErrors(['image_file' => 'Failed to upload new image.'])->withInput()->with(['_edit_form' => true, 'edited_category_id' => $category->id]);
            }
        } elseif ($request->input('remove_image') == '1') {
            // If remove_image flag is set and no new file is uploaded
            if ($category->image_url) {
                Storage::disk('public')->delete($category->image_url);
            }
            $imagePath = null;
        }

        $data['image_url'] = $imagePath;

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category)
    {
        // Delete associated image file if it exists
        if ($category->image_url) {
            Storage::disk('public')->delete($category->image_url);
        }
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully!');
    }
}

