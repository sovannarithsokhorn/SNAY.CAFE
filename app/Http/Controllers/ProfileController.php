<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage; // Import Storage facade
use App\Models\Order; // Ensure Order model is imported
use Illuminate\View\View; // Make sure this is imported
use Illuminate\Http\RedirectResponse; // Make sure this is imported

class ProfileController extends Controller
{
    /**
     * Display the user's profile and order history.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(): View|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to view your profile.');
        }

        $user = Auth::user();
        // Eager load orders and their items, and the product associated with each item
        $user->load(['orders.items.product']);

        // Correctly pass the user object which now contains loaded orders
        return view('frontend.layout.usersdetail', compact('user'));
    }

    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate the incoming request data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'date_of_birth' => ['nullable', 'date'],
            'profile_picture' => ['nullable', 'image', 'max:2048'], // Added validation for image upload (max 2MB)
        ]);

        // Update user data (non-file fields)
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->date_of_birth = $request->date_of_birth;

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture_url) {
                // Ensure the path is relative to the storage disk
                Storage::disk('public')->delete($user->profile_picture_url);
            }
            // Store the new picture in the 'profile_pictures' directory within 'public' disk
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture_url = $path; // Save the path to the database
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully!',
            'user' => [ // Return updated user data, including new profile picture URL
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'phone_number' => $user->phone_number,
                // CORRECTED LINE: Assumes $user->date_of_birth is a Carbon instance due to model casting
                'date_of_birth' => optional($user->date_of_birth)->format('Y-m-d'),
                'profile_picture_url' => $user->profile_picture_url ? asset('storage/' . $user->profile_picture_url) : null,
            ]
        ]);
    }
}