@extends('frontend.layout.master')

@section('title', 'Our Products')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;700&display=swap');

        .bg-noir-dark {
            --tw-bg-opacity: 1;
            background-color: rgb(15 15 15 / var(--tw-bg-opacity, 1));
            background-image: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url('https://images.unsplash.com/photo-1447933601403-0c6688de566e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1956&q=80');
        }
    </style>
    <section class="py-12 md:py-24 bg-noir-dark min-h-screen">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="bg-noir-medium rounded-lg shadow-xl p-8 md:p-12 border border-noir-light relative overflow-hidden">
                {{-- Decorative top bar --}}
                <div
                    class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-transparent via-noir-accent to-transparent">
                </div>

                <h1 class="font-syne text-5xl font-bold mb-6 text-center">Our Products</h1>

                {{-- Search and Filter Form --}}
                <form id="productFilterForm" action="{{ route('products.index') }}" method="GET"
                    class="mb-10 p-6 bg-noir-dark rounded-lg shadow-inner border border-noir-light flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-6">
                    <div class="flex-1 w-full">
                        <label for="search" class="sr-only">Search Products</label>
                        <input type="text" name="search" id="search" placeholder="Search by name or description..."
                            value="{{ request('search') }}"
                            class="w-full p-3 rounded-md bg-noir-light border border-noir-muted text-white placeholder-noir-muted focus:outline-none focus:border-noir-accent">
                    </div>

                    <div class="w-full md:w-auto">
                        <label for="category" class="sr-only">Filter by Category</label>
                        <select name="category" id="category"
                            class="w-full p-3 rounded-md bg-noir-light border border-noir-muted text-white focus:outline-none focus:border-noir-accent appearance-none pr-8">
                            <option value="all">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name_en }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- NEW: Sort By Dropdown --}}
                    <div class="w-full md:w-auto">
                        <label for="sort_by" class="sr-only">Sort By</label>
                        <select name="sort_by" id="sort_by"
                            class="w-full p-3 rounded-md bg-noir-light border border-noir-muted text-white focus:outline-none focus:border-noir-accent appearance-none pr-8">
                            <option value="default" {{ request('sort_by') == 'default' ? 'selected' : '' }}>Default Sorting</option>
                            <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="bestseller" {{ request('sort_by') == 'bestseller' ? 'selected' : '' }}>Bestseller</option>
                            <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </div>

                    {{-- The "Apply Filters" button is removed as per requirement --}}
                    {{-- <button type="submit"
                        class="w-full md:w-auto btn ripple bg-noir-accent text-noir-dark px-8 py-3 rounded-md font-medium text-lg transition-all duration-300 hover:bg-opacity-90">
                        Apply Filters
                    </button> --}}
                </form>

                {{-- Product Grid --}}
                @if ($products->isEmpty())
                    <div class="bg-noir-light p-6 rounded-lg text-center text-noir-muted">
                        <p class="text-lg">No products found matching your criteria.</p>
                        <a href="{{ route('products.index') }}"
                            class="mt-4 inline-block text-noir-accent hover:underline">Clear Filters</a>
                    </div>
                @else
                    {{-- Adjusted grid for better spacing and consistency --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
                        @foreach ($products as $product)
                            {{-- Product Card Structure (copied and adapted from homepage) --}}
                            <div
                                class="product-card bg-noir-medium rounded-lg overflow-hidden shadow-lg relative hover-lift reveal active">
                                @if ($product->is_bestseller)
                                    <div class="product-badge badge-bestseller">
                                        <span data-lang="en">Bestseller</span>
                                        <span data-lang="km">លក់ដាច់បំផុត</span>
                                    </div>
                                @elseif($product->is_organic)
                                    <div class="product-badge badge-organic">
                                        <span data-lang="en">Organic</span>
                                        <span data-lang="km">សរីរាង្គ</span>
                                    </div>
                                @elseif($product->is_new)
                                    <div class="product-badge badge-new">
                                        <span data-lang="en">New</span>
                                        <span data-lang="km">ថ្មី</span>
                                    </div>
                                @endif
                                <div class="image-hover h-60 overflow-hidden"> {{-- Fixed height for consistent image size --}}
                                    <a href="{{ route('products.show', $product->id) }}">
                                        <img src="{{ $product->image_url ? asset('storage/' . $product->image_url) : 'https://placehold.co/600x400/2A2A2A/D4A95C?text=No+Image' }}"
                                            alt="{{ $product->name_en }}" class="w-full h-full object-cover"
                                            onerror="this.onerror=null;this.src='https://placehold.co/600x400/2A2A2A/D4A95C?text=Image+Load+Error';">
                                    </a>
                                </div>
                                <div class="p-6 relative">
                                    {{-- Flex container for name, description, and price --}}
                                    <div class="flex flex-col h-full">
                                        <h3 class="text-xl font-normal text-white font-syne mb-1 truncate">
                                            {{-- Smaller text, thinner font --}}
                                            <a href="{{ route('products.show', $product->id) }}"
                                                class="hover:text-noir-accent transition-colors">
                                                <span data-lang="en">{{ $product->name_en }}</span>
                                                <span data-lang="km">{{ $product->name_km ?? $product->name_en }}</span>
                                            </a>
                                        </h3>
                                        <p class="text-noir-muted text-sm mb-4"
                                            style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                            <span data-lang="en">{{ $product->description_en }}</span>
                                            <span
                                                data-lang="km">{{ $product->description_km ?? $product->description_en }}</span>
                                        </p>
                                        <div class="flex items-center justify-between mt-auto"> {{-- mt-auto pushes price to bottom --}}
                                            <span
                                                class="text-noir-accent text-2xl font-medium">${{ number_format($product->price, 2) }}</span>
                                            {{-- Adjusted font-bold to font-medium --}}
                                            @if ($product->old_price)
                                                <span
                                                    class="text-gray-300 line-through text-base">${{ number_format($product->old_price, 2) }}</span>
                                                {{-- Adjusted text size --}}
                                            @endif
                                        </div>
                                    </div>
                                    {{-- Product Overlay for Add to Cart --}}
                                    <div
                                        class="product-overlay absolute bottom-0 left-0 right-0 p-6 flex justify-center items-center">
                                        <button type="button"
                                            class="add-to-cart-btn ripple bg-noir-accent hover:bg-white text-noir-dark font-medium py-3 px-6 rounded-full transition-colors"
                                            data-product-id="{{ $product->id }}"
                                            data-product-name="{{ $product->name_en }}" {{-- Use name_en for JS --}}
                                            data-product-price="{{ $product->price }}"
                                            data-product-image="{{ $product->image_url ?? 'https://placehold.co/100x100/D4A95C/0F0F0F?text=Product' }}">
                                            <span data-lang="en">Add to Cart</span>
                                            <span data-lang="km">បន្ថែមទៅរទេះ</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination Links --}}
                    <div class="mt-10">
                        {{ $products->links('vendor.pagination.tailwind') }} {{-- Using Tailwind pagination view --}}
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productFilterForm = document.getElementById('productFilterForm');
            const categorySelect = document.getElementById('category');
            const sortSelect = document.getElementById('sort_by');

            // Function to submit the form
            const submitForm = () => {
                productFilterForm.submit();
            };

            // Auto-submit on category change
            if (categorySelect) {
                categorySelect.addEventListener('change', submitForm);
            }

            // Auto-submit on sort by change
            if (sortSelect) {
                sortSelect.addEventListener('change', submitForm);
            }

            // Add to Cart functionality (updated to use .add-to-cart-btn class)
            document.querySelectorAll('.add-to-cart-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.dataset.productId;
                    const productName = this.dataset.productName;
                    const productPrice = this.dataset.productPrice;
                    const productImage = this.dataset.productImage;

                    // Disable button and show loading feedback
                    this.disabled = true;
                    this.textContent = 'Adding...';

                    fetch(`{{ url('/cart/add') }}/${productId}`, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                quantity: 1, // Default quantity for initial add
                                name: productName,
                                price: productPrice,
                                image: productImage
                            })
                        })
                        .then(response => {
                            // Re-enable button regardless of success/failure
                            button.disabled = false;
                            button.textContent = 'Add to Cart';

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
                                        if (result.isConfirmed && data
                                            .redirect) {
                                            window.location.href = data
                                                .redirect;
                                        }
                                    });
                                    return Promise.reject('Unauthorized');
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
                                if (typeof updateCartCount === 'function') {
                                    updateCartCount();
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
            });
        });
    </script>
@endpush
