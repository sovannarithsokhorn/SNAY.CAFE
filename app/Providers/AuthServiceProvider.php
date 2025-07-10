<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate; // IMPORTANT: Ensure this line is present

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Define the 'admin-access' Gate
        // This Gate checks if the authenticated user's 'role' attribute is 'admin'.
        Gate::define('admin-access', function ($user) {
            // IMPORTANT: Ensure your 'users' table has a 'role' column
            // and that the admin user you're testing with has 'admin' in that column.
            return $user->role === 'admin';
        });
    }
}
