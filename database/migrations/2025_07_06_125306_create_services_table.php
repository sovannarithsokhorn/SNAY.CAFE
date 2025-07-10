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
        // Creates the 'services' table to store information about services offered.
        Schema::create('services', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key for the service
            $table->string('name_en'); // English name of the service
            $table->text('description_en')->nullable(); // English description of the service
            $table->decimal('price', 10, 2); // Price of the service
            $table->string('image_url')->nullable(); // Optional: URL to an image representing the service
            $table->boolean('is_featured')->default(false); // Flag to mark if the service should be featured (e.g., on homepage)
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drops the 'services' table if it exists when rolling back migrations.
        Schema::dropIfExists('services');
    }
};

