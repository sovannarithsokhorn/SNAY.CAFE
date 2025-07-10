<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User; // Make sure to import the User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; // Import Rule for unique validation

class RegisterController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users'], // Validate username
            'phone_number' => ['nullable', 'string', 'max:20'], // Made nullable
            'password' => ['required', 'string', 'confirmed'], // 'confirmed' checks against password_confirmation
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->username, // Assign username to 'name'
            'username' => $request->username, // Assign username to 'username'
            'email' => null, // Set email to null or a default if not collected
            'phone_number' => $request->phone_number, // Assign phone_number
            'date_of_birth' => null, // Set date_of_birth to null if not collected
            'password' => Hash::make($request->password), // Hash the password
            'role' => 'user', // Default role
        ]);

        // Log the user in after successful registration (optional)
        // Auth::login($user);

        // Redirect to login with a success message
        return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
    }
}
