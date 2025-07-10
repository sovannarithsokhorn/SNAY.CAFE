<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Assuming you have a User model
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule; // Import Rule for unique validation
use Illuminate\Support\Facades\Hash; // Import Hash for password hashing
use Illuminate\Support\Facades\Storage; // Import Storage for profile picture management
use Carbon\Carbon; // Import Carbon for date formatting if needed (already in ProfileController, good to have here too)

class BuserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $query = User::query();

        // Apply search filter if 'search' parameter is present
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('username', 'like', '%' . $search . '%') // Also search by username
                  ->orWhere('email', 'like', '%' . $search . '%');   // Also search by email
        }

        // Paginate the results
        $users = $query->paginate(10); // You can adjust the number of items per page

        // Pass the search query back to the view for input field persistence
        return view('backend.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('backend.users.create');
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validation for creating a new user
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'date_of_birth' => ['nullable', 'date'],
            'role' => ['required', 'string', 'in:user,admin'], // Assuming roles 'user' and 'admin'
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'profile_picture' => ['nullable', 'image', 'max:2048'], // Max 2MB image
        ]);

        $user = new User();
        $user->name = $validatedData['name'];
        $user->username = $validatedData['username'];
        $user->email = $validatedData['email'];
        $user->phone_number = $validatedData['phone_number'];
        $user->date_of_birth = $validatedData['date_of_birth'];
        $user->role = $validatedData['role'];
        $user->password = Hash::make($validatedData['password']);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture_url = $path;
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
    }

    /**
     * Display the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function show(User $user): View
    {
        return view('backend.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user): View
    {
        // The User model is automatically resolved by Laravel's route model binding
        return view('backend.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($user->id), // Ignore current user's username
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id), // Ignore current user's email
            ],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'date_of_birth' => ['nullable', 'date'],
            'role' => ['required', 'string', 'in:user,admin'], // Assuming roles 'user' and 'admin'
            'password' => ['nullable', 'string', 'min:8', 'confirmed'], // Optional password change
            'profile_picture' => ['nullable', 'image', 'max:2048'], // Max 2MB image
        ]);

        $user->name = $validatedData['name'];
        $user->username = $validatedData['username'];
        $user->email = $validatedData['email'];
        $user->phone_number = $validatedData['phone_number'];
        $user->date_of_birth = $validatedData['date_of_birth'];
        $user->role = $validatedData['role'];

        // Handle password update if provided
        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture_url) {
                Storage::disk('public')->delete($user->profile_picture_url);
            }
            // Store the new picture
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture_url = $path;
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        // Prevent deleting the currently authenticated user
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        // Delete profile picture if exists
        if ($user->profile_picture_url) {
            Storage::disk('public')->delete($user->profile_picture_url);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }
}
