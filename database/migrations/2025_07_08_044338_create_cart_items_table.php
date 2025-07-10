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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('quantity');
            $table->decimal('price', 10, 2); // Store price at time of add
            $table->string('name'); // Store product name at time of add
            $table->string('image')->nullable(); // Store product image URL at time of add
            $table->timestamps();

            $table->unique(['cart_id', 'product_id']); // A product can only be in a cart once
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};