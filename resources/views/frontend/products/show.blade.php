@extends('frontend.layout.master')

@section('title', $product->name_en) {{-- Set title dynamically --}}

@section('content')
    <style>
        /* This style block should ideally be in your main CSS file or a dedicated Blade file for styles */
        .bg-noir-dark {
            --tw-bg-opacity: 1;
            background-color: rgb(15 15 15 / var(--tw-bg-opacity, 1));
            background-image: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url('https://images.unsplash.com/photo-1511537190424-bbbab87ac5eb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80');
        }
    </style>
    <section class="py-12 md:py-24 bg-noir-dark min-h-screen flex items-center justify-center">
        <div class="container mx-auto px-6 max-w-4xl">
            <div class="bg-noir-medium rounded-lg shadow-xl p-8 md:p-12 border border-noir-light relative overflow-hidden">
                {{-- Decorative top bar --}}
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-transparent via-noir-accent to-transparent"></div>

                {{-- New: Red Close Button (X) for the product details view --}}
                <button onclick="history.back()" class="absolute top-4 right-4 text-red-500 text-4xl hover:text-red-600 focus:outline-none z-10">
                    &times;
                </button>

                <div class="flex flex-col md:flex-row gap-8 md:gap-12 items-start">
                    {{-- Product Image --}}
                    <div class="w-full md:w-1/2 flex-shrink-0">
                        <img src="{{ asset('storage/' . $product->image_url) }}"
                            alt="{{ $product->name_en }}"
                            id="productMainImage" {{-- Added ID for JavaScript --}}
                            class="w-full h-auto object-cover rounded-lg shadow-md border border-noir-light cursor-pointer transition-transform duration-300 hover:scale-[1.01]" {{-- Added cursor and hover effect --}}
                            onerror="this.onerror=null;this.src='https://placehold.co/600x400/D4A95C/0F0F0F?text=Product+Image';">
                    </div>

                    {{-- Product Details --}}
                    <div class="w-full md:w-1/2">
                        <h1 class="text-4xl font-normal text-white font-syne mb-4">{{ $product->name_en }}</h1>
                        <p class="text-noir-muted text-sm mb-6">{{ $product->description_en }}</p>

                        <div class="mb-6">
                            <span class="text-noir-accent text-4xl font-medium">${{ number_format($product->price, 2) }}</span>
                            @if($product->old_price)
                                <span class="text-gray-300 line-through ml-4 text-xl">${{ number_format($product->old_price, 2) }}</span>
                            @endif
                        </div>

                        <div class="text-noir-muted text-sm mb-8">
                            <span class="font-semibold text-noir-accent">Category:</span>
                            {{ $product->category->name_en ?? 'N/A' }}
                        </div>

                        {{-- Add to Cart Form --}}
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
                            @csrf
                            <div class="flex items-center space-x-4 mb-6">
                                <label for="quantity" class="text-white font-normal">Quantity:</label>
                                <input type="number" name="quantity" id="quantity" value="1" min="1"
                                    class="w-20 p-2 rounded-md bg-noir-dark border border-noir-muted text-white text-center focus:outline-none focus:border-noir-accent">
                            </div>
                            <button type="submit" class="btn ripple bg-noir-accent text-noir-dark px-8 py-4 rounded-md font-medium text-lg transition-all duration-300 hover:bg-opacity-90 w-full">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Full Image Modal --}}
    <div id="fullImageModal" class="fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center z-[1000] hidden">
        <div class="relative max-w-full max-h-full p-4">
            <button id="closeFullImageModal" class="absolute top-4 right-4 text-white text-4xl hover:text-noir-accent focus:outline-none">
                &times;
            </button>
            <img src="" alt="Full Product Image" id="fullImageDisplay" class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-xl">
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add to Cart functionality for single product page
            const addToCartForm = document.querySelector('.add-to-cart-form');
            if (addToCartForm) {
                addToCartForm.addEventListener('submit', function(e) {
                    e.preventDefault(); // Prevent default form submission

                    const productId = this.action.split('/').pop(); // Extract product ID from action URL
                    const quantity = this.querySelector('input[name="quantity"]').value;

                    // Disable button and show loading feedback
                    const submitButton = this.querySelector('button[type="submit"]');
                    submitButton.disabled = true;
                    submitButton.textContent = 'Adding...';

                    fetch(this.action, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                quantity: quantity
                            })
                        })
                        .then(response => {
                            // Re-enable button regardless of success/failure
                            submitButton.disabled = false;
                            submitButton.textContent = 'Add to Cart';

                            if (response.status === 401) { // Unauthorized
                                return response.json().then(data => {
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Login Required',
                                        text: data.message,
                                        confirmButtonText: 'Go to Login',
                                        confirmButtonColor: '#D4A95C',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false
                                    }).then((result) => {
                                        if (result.isConfirmed && data.redirect) {
                                            window.location.href = data.redirect;
                                        }
                                    });
                                    return Promise.reject('Unauthorized'); // Stop further processing
                                });
                            }
                            if (!response.ok) {
                                return response.json().then(err => Promise.reject(err));
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Added to Cart!',
                                    text: data.message,
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                });
                                // Update cart count in header
                                if (typeof updateCartCount === 'function') {
                                    updateCartCount(); // Call the global function from master.blade.php
                                }
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed to Add to Cart!',
                                    text: data.message || 'An error occurred.',
                                    confirmButtonColor: '#D4A95C'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error adding to cart:', error);
                            let errorMessage = 'Could not add item to cart. Please try again.';
                            if (error.message) {
                                errorMessage = error.message;
                            } else if (typeof error === 'string') {
                                errorMessage = error;
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Network Error!',
                                text: errorMessage,
                                confirmButtonColor: '#D4A95C'
                            });
                        });
                });
            }

            // Full Image Modal Logic (remains unchanged)
            const productMainImage = document.getElementById('productMainImage');
            const fullImageModal = document.getElementById('fullImageModal');
            const fullImageDisplay = document.getElementById('fullImageDisplay');
            const closeFullImageModalBtn = document.getElementById('closeFullImageModal');

            if (productMainImage) {
                productMainImage.addEventListener('click', function() {
                    fullImageDisplay.src = this.src; // Set the modal image source to the clicked image's source
                    fullImageModal.classList.remove('hidden'); // Show the modal
                });
            }

            if (closeFullImageModalBtn) {
                closeFullImageModalBtn.addEventListener('click', function() {
                    fullImageModal.classList.add('hidden'); // Hide the modal
                });
            }

            // Close modal if clicked outside the image
            if (fullImageModal) {
                fullImageModal.addEventListener('click', function(event) {
                    if (event.target === fullImageModal) {
                        fullImageModal.classList.add('hidden');
                    }
                });
            }
        });
    </script>
@endpush
