<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle an incoming authentication request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request)
    {
        // Validate the incoming request data for username and password
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // Attempt to authenticate the user using the 'username' and 'password'.
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Regenerate the session to prevent session fixation attacks
            $request->session()->regenerate();

            // *** NEW: Redirect based on user role ***
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success_message', 'Welcome, ' . $user->name . '!');
            } else {
                // Default redirect for 'user' role or others
                return redirect(url('/'))->with('success_message', 'Welcome, ' . $user->name . '!');
            }
        }

        // If authentication fails, throw a validation exception with a custom message
        throw ValidationException::withMessages([
            'username' => trans('auth.failed'),
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout(); // Log out the user

        $request->session()->invalidate(); // Invalidate the current session
        $request->session()->regenerateToken(); // Regenerate the CSRF token

        return redirect(url('/')); // Redirect to the home page after logout
    }
}
