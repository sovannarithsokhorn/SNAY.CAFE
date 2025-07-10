@extends('frontend.layout.master')

@section('title', 'Your Shopping Cart')

@section('content')
    <style>
        .bg-noir-dark {
            --tw-bg-opacity: 1;
            background-color: rgb(15 15 15 / var(--tw-bg-opacity, 1));
            background-image: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url('https://images.unsplash.com/photo-1447933601403-0c6688de566e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1956&q=80');
        }
    </style>
    <section class="py-12 md:py-24 bg-noir-dark min-h-screen flex items-center justify-center">
        <div class="container mx-auto px-6 max-w-5xl">
            <div class="bg-noir-medium rounded-lg shadow-xl p-8 md:p-12 border border-noir-light relative overflow-hidden">
                {{-- Decorative top bar --}}
                <div
                    class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-transparent via-noir-accent to-transparent">
                </div>

                <h1 class="text-4xl font-bold text-white font-syne mb-8 pb-4 border-b border-noir-light text-center">Your
                    Shopping Cart</h1>

                @if (empty($cartItems))
                    <div class="bg-noir-light p-6 rounded-lg text-center text-noir-muted">
                        <p class="text-lg mb-4">Your cart is empty.</p>
                        <a href="{{ url('/products') }}"
                            class="inline-block btn ripple bg-noir-accent text-noir-dark px-8 py-3 rounded-full font-medium text-lg">
                            Start Shopping!
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto bg-noir-light rounded-lg shadow-md border border-noir-medium mb-8">
                        <table class="min-w-full divide-y divide-noir-muted">
                            <thead class="bg-noir-medium">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">
                                        Product</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">
                                        Price</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">
                                        Quantity</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">
                                        Subtotal</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-noir-muted">
                                @foreach ($cartItems as $id => $item)
                                    <tr class="hover:bg-noir-dark transition-colors duration-200"
                                        data-product-id="{{ $id }}">
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white flex items-center">
                                            {{-- THIS IS THE CRITICAL LINE FOR THE CART PAGE --}}
                                            <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}"
                                                class="w-16 h-16 object-cover rounded-md mr-4 border border-noir-medium"
                                                onerror="this.onerror=null;this.src='https://placehold.co/100x100/D4A95C/0F0F0F?text=Product';">
                                            {{ $item['name'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-noir-muted">
                                            ${{ number_format($item['price'], 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <input type="number" min="1" value="{{ $item['quantity'] }}"
                                                class="w-20 p-2 rounded-md bg-noir-dark border border-noir-muted text-white text-center quantity-input"
                                                data-product-id="{{ $id }}">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-noir-accent">
                                            ${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button type="button"
                                                class="text-red-500 hover:text-red-700 transition-colors remove-from-cart-btn"
                                                data-product-id="{{ $id }}">
                                                Remove
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="text-right text-white text-2xl font-bold font-syne mb-8">
                        Total: <span class="text-noir-accent">${{ number_format($total, 2) }}</span>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="{{ url('/products') }}"
                            class="btn animated-border border-2 border-white text-white px-8 py-3 rounded-md font-medium text-lg hover:border-noir-accent hover:text-noir-accent text-center">
                            Continue Shopping
                        </a>
                        <button type="button" id="clear-cart-btn"
                            class="btn ripple bg-red-600 text-white px-8 py-3 rounded-md font-medium text-lg transition-all duration-300 hover:bg-red-700 text-center">
                            Clear Cart
                        </button>
                        <button type="button" id="proceed-to-checkout-btn"
                            class="btn ripple bg-noir-accent text-noir-dark px-8 py-3 rounded-md font-medium text-lg transition-all duration-300 hover:bg-opacity-90 text-center">
                            Proceed to Checkout
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </section>


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Function to update item quantity
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', function() {
                    const productId = this.dataset.productId;
                    const newQuantity = this.value;

                    if (newQuantity < 1) {
                        // If quantity is reduced to 0, trigger remove
                        Swal.fire({
                            title: 'Remove Item?',
                            text: "Are you sure you want to remove this item from your cart?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#D4A95C',
                            cancelButtonColor: '#2A2A2A',
                            confirmButtonText: 'Yes, remove it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                removeItem(productId);
                            } else {
                                // Revert quantity if cancelled
                                this.value = parseInt(this.dataset.previousQuantity || 1);
                            }
                        });
                        return;
                    }

                    // Store current quantity for potential revert
                    this.dataset.previousQuantity = this.value;

                    fetch(`/cart/update/${productId}`, {
                            method: 'POST', // Laravel interprets PUT via _method
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                quantity: newQuantity,
                                _method: 'POST' // Explicitly send _method for update
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(err => Promise.reject(err));
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Cart Updated!',
                                    text: data.message,
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true,
                                });
                                updateCartCount(); // Update header cart count
                                // Reload page to reflect subtotal changes and ensure consistency
                                setTimeout(() => {
                                    window.location.reload();
                                }, 2000);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: data.message,
                                    confirmButtonColor: '#D4A95C'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error updating cart:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Update Failed!',
                                text: error.message ||
                                    'Could not update cart. Please try again.',
                                confirmButtonColor: '#D4A95C'
                            });
                            this.value = parseInt(this.dataset.previousQuantity ||
                                1); // Revert on error
                        });
                });
                // Store initial quantity
                input.dataset.previousQuantity = input.value;
            });

            // Function to remove item from cart
            function removeItem(productId) {
                fetch(`/cart/remove/${productId}`, {
                        method: 'POST', // Laravel interprets DELETE via _method
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            _method: 'DELETE' // Explicitly send _method for delete
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => Promise.reject(err));
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Item Removed!',
                                text: data.message,
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true,
                            });
                            updateCartCount(); // Update header cart count
                            // Reload page to reflect changes in cart display
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: data.message,
                                confirmButtonColor: '#D4A95C'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error removing item:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Removal Failed!',
                            text: error.message || 'Could not remove item. Please try again.',
                            confirmButtonColor: '#D4A95C'
                        });
                    });
            }

            document.querySelectorAll('.remove-from-cart-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.dataset.productId;
                    Swal.fire({
                        title: 'Remove Item?',
                        text: "Are you sure you want to remove this item from your cart?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#D4A95C',
                        cancelButtonColor: '#2A2A2A',
                        confirmButtonText: 'Yes, remove it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            removeItem(productId);
                        }
                    });
                });
            });

            // NEW: Clear Cart Button Logic
            const clearCartBtn = document.getElementById('clear-cart-btn');
            if (clearCartBtn) {
                clearCartBtn.addEventListener('click', function() {
                    Swal.fire({
                        title: 'Clear Cart?',
                        text: "Are you sure you want to remove all items from your cart?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#D4A95C',
                        cancelButtonColor: '#2A2A2A',
                        confirmButtonText: 'Yes, clear it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading spinner
                            Swal.fire({
                                title: 'Clearing Cart...',
                                text: 'Please wait while your cart is being emptied.',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                },
                                customClass: {
                                    popup: 'swal2-toast-popup'
                                }
                            });

                            fetch('{{ route('cart.clear') }}', { // Use the new route
                                    method: 'POST', // Or DELETE, depending on your route definition
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'X-CSRF-TOKEN': csrfToken,
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        _method: 'DELETE' // If using a DELETE route
                                    })
                                })
                                .then(response => {
                                    Swal.close(); // Close loading spinner
                                    if (!response.ok) {
                                        return response.json().then(err => Promise.reject(err));
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Cart Cleared!',
                                            text: data.message,
                                            toast: true,
                                            position: 'top-end',
                                            showConfirmButton: false,
                                            timer: 2000,
                                            timerProgressBar: true,
                                        });
                                        updateCartCount(); // Reset cart count in header
                                        setTimeout(() => {
                                            window.location.reload(); // Reload to show empty cart
                                        }, 2000);
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error!',
                                            text: data.message,
                                            confirmButtonColor: '#D4A95C'
                                        });
                                    }
                                })
                                .catch(error => {
                                    Swal.close(); // Ensure loading spinner is closed on error
                                    console.error('Error clearing cart:', error);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Clear Cart Failed!',
                                        text: error.message || 'Could not clear cart. Please try again.',
                                        confirmButtonColor: '#D4A95C'
                                    });
                                });
                        }
                    });
                });
            }

            // NEW: Proceed to Checkout Button Logic
            const proceedToCheckoutBtn = document.getElementById('proceed-to-checkout-btn');
            if (proceedToCheckoutBtn) {
                proceedToCheckoutBtn.addEventListener('click', function() {
                    Swal.fire({
                        title: 'Confirm Order?',
                        text: "Are you sure you want to proceed to checkout?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#D4A95C',
                        cancelButtonColor: '#2A2A2A',
                        confirmButtonText: 'Yes, Confirm Order!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading spinner while processing
                            Swal.fire({
                                title: 'Processing Your Order...',
                                text: 'Please wait while we finalize your purchase.',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                },
                                customClass: {
                                    popup: 'swal2-toast-popup' // Use custom class for consistent styling
                                }
                            });

                            fetch('{{ route('checkout.process') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'X-CSRF-TOKEN': csrfToken
                                    },
                                    body: JSON
                                        .stringify({}) // No specific data needed, cart is on server
                                })
                                .then(response => {
                                    Swal.close(); // Close loading spinner
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
                                            return Promise.reject(
                                                'Unauthorized'); // Stop further processing
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
                                            title: 'Order Placed!',
                                            text: data.message,
                                            confirmButtonColor: '#D4A95C',
                                            allowOutsideClick: false,
                                            allowEscapeKey: false
                                        }).then(() => {
                                            // Clear cart count in header immediately
                                            if (typeof updateCartCount === 'function') {
                                                updateCartCount();
                                            }
                                            // Redirect to order history page
                                            if (data.redirect) {
                                                window.location.href = data.redirect;
                                            } else {
                                                // Fallback if redirect not provided
                                                window.location.href =
                                                    '{{ url('/profile') }}#orders';
                                            }
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Order Failed!',
                                            text: data.message,
                                            confirmButtonColor: '#D4A95C'
                                        });
                                    }
                                })
                                .catch(error => {
                                    Swal.close(); // Ensure loading spinner is closed on error
                                    console.error('Checkout error:', error);
                                    if (error !==
                                        'Unauthorized') { // Only show generic error if not handled by 401 redirect
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Checkout Failed!',
                                            text: error.message ||
                                                'An unexpected error occurred during checkout. Please try again.',
                                            confirmButtonColor: '#D4A95C'
                                        });
                                    }
                                });
                        }
                    });
                });
            }
        });

        // updateCartCount is globally defined in master.blade.php
    </script>
@endpush
@endsection