<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add the profile_picture_url column
            // It's nullable because a user might not have a profile picture
            // You can place it after 'email' or any other suitable column
            $table->string('profile_picture_url')->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the profile_picture_url column if rolling back the migration
            $table->dropColumn('profile_picture_url');
        });
    }
};
