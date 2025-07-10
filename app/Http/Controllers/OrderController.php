<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product; // Make sure Product model is imported
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Helper method to get the current user's cart (DB for logged-in, null for guests).
     *
     * @return \App\Models\Cart|null
     */
    private function getUserDbCart()
    {
        if (Auth::check()) {
            return Cart::firstOrCreate(['user_id' => Auth::id()]);
        }
        return null; // No DB cart for guests
    }

    /**
     * Display the shopping cart.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $cartItems = [];
        $total = 0;

        if (Auth::check()) {
            // For logged-in users, retrieve cart from DB
            $cart = $this->getUserDbCart();
            if ($cart) {
                foreach ($cart->items as $item) {
                    $cartItems[$item->product_id] = [
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                        'name' => $item->name,
                        'image' => $item->image,
                        'product' => $item->product // Link to actual product model
                    ];
                    $total += $item->price * $item->quantity;
                }
            }
        } else {
            // For guests, retrieve cart from session
            $sessionCart = Session::get('cart', []);
            foreach ($sessionCart as $id => $details) {
                $product = Product::find($id);
                if ($product) {
                    $cartItems[$id] = [
                        'quantity' => $details['quantity'],
                        'price' => $details['price'],
                        'name' => $details['name'],
                        'image' => $details['image'],
                        'product' => $product
                    ];
                    $total += $details['price'] * $details['quantity'];
                } else {
                    // If product no longer exists, remove from cart
                    unset($sessionCart[$id]);
                    Session::put('cart', $sessionCart);
                }
            }
        }

        return view('frontend.cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add an item to the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request, Product $product)
    {
        $quantity = $request->input('quantity', 1);

        if (Auth::check()) {
            // Logged-in user: Add to database cart
            $cart = $this->getUserDbCart();
            $cartItem = $cart->items()->where('product_id', $product->id)->first();

            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                $cart->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'name' => $product->name_en,
                    'image' => $product->image_url,
                ]);
            }
            $message = $product->name_en . ' added to your persistent cart!';
        } else {
            // Guest user: Add to session cart
            $sessionCart = Session::get('cart', []);
            if (isset($sessionCart[$product->id])) {
                $sessionCart[$product->id]['quantity'] += $quantity;
            } else {
                $sessionCart[$product->id] = [
                    "name" => $product->name_en,
                    "quantity" => $quantity,
                    "price" => $product->price,
                    "image" => $product->image_url,
                ];
            }
            Session::put('cart', $sessionCart);
            $message = $product->name_en . ' added to your session cart!';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'cartCount' => $this->getCartItemCount()->original
        ]);
    }

    /**
     * Update item quantity in the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Product $product)
    {
        $quantity = $request->input('quantity');

        if (Auth::check()) {
            $cart = $this->getUserDbCart();
            $cartItem = $cart->items()->where('product_id', $product->id)->first();

            if ($cartItem) {
                if ($quantity > 0) {
                    $cartItem->quantity = $quantity;
                    $cartItem->save();
                    $message = 'Cart updated successfully.';
                } else {
                    // If quantity is 0 or less, remove the item
                    return $this->remove($product);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found in your persistent cart.'
                ], 404);
            }
        } else {
            $sessionCart = Session::get('cart', []);
            if (isset($sessionCart[$product->id])) {
                if ($quantity > 0) {
                    $sessionCart[$product->id]['quantity'] = $quantity;
                    Session::put('cart', $sessionCart);
                    $message = 'Cart updated successfully.';
                } else {
                    // If quantity is 0 or less, remove the item
                    return $this->remove($product);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found in your session cart.'
                ], 404);
            }
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'cartCount' => $this->getCartItemCount()->original
        ]);
    }

    /**
     * Remove an item from the cart.
     *
     * @param  \Illuminate\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove(Product $product)
    {
        if (Auth::check()) {
            $cart = $this->getUserDbCart();
            $cartItem = $cart->items()->where('product_id', $product->id)->first();

            if ($cartItem) {
                $cartItem->delete();
                $message = $product->name_en . ' removed from your persistent cart.';
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found in your persistent cart.'
                ], 404);
            }
        } else {
            $sessionCart = Session::get('cart', []);
            if (isset($sessionCart[$product->id])) {
                unset($sessionCart[$product->id]);
                Session::put('cart', $sessionCart);
                $message = $product->name_en . ' removed from your session cart.';
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found in your session cart.'
                ], 404);
            }
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'cartCount' => $this->getCartItemCount()->original
        ]);
    }

    /**
     * Get the current number of items in the cart.
     * Used for updating the cart count in the header.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCartItemCount()
    {
        $count = 0;
        if (Auth::check()) {
            $cart = $this->getUserDbCart();
            if ($cart) {
                $count = $cart->items->sum('quantity');
            }
        } else {
            $sessionCart = Session::get('cart', []);
            foreach ($sessionCart as $item) {
                $count += $item['quantity'];
            }
        }
        return response()->json($count);
    }

    /**
     * Static method to merge session cart into database cart upon user login.
     * This method will be called by an event listener.
     */
    public static function mergeSessionCartToDbCart()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $sessionCart = Session::get('cart', []);

            if (!empty($sessionCart)) {
                $dbCart = Cart::firstOrCreate(['user_id' => $user->id]);

                DB::transaction(function () use ($sessionCart, $dbCart) {
                    foreach ($sessionCart as $productId => $details) {
                        $item = $dbCart->items()->where('product_id', $productId)->first();

                        if ($item) {
                            // If item exists, update quantity
                            $item->quantity += $details['quantity'];
                            $item->save();
                        } else {
                            // If item does not exist, create new cart item
                            $dbCart->items()->create([
                                'product_id' => $productId,
                                'quantity' => $details['quantity'],
                                'price' => $details['price'],
                                'name' => $details['name'],
                                'image' => $details['image'],
                            ]);
                        }
                    }
                    Session::forget('cart'); // Clear session cart after merging
                });
            }
        }
    }

    /**
     * Process the checkout, create an order, and clear the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function processCheckout(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please log in to proceed with checkout.',
                'redirect' => route('login')
            ], 401);
        }

        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty. Please add items before checking out.'
            ], 400);
        }

        DB::beginTransaction();

        try {
            $totalAmount = 0;
            foreach ($cart->items as $item) {
                $totalAmount += $item->price * $item->quantity;
            }

            // Create the Order
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $totalAmount,
                'status' => 'pending', // Default status
            ]);

            // Move cart items to order items
            foreach ($cart->items as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price, // Capture price at time of order
                    'name' => $cartItem->name,   // Capture name at time of order
                    'image' => $cartItem->image, // Capture image at time of order
                ]);
            }

            // Clear the user's cart
            $cart->items()->delete(); // Delete all cart items
            $cart->delete(); // Delete the cart itself

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Your order has been placed successfully! Our call center will contact you shortly to confirm your order.',
                'redirect' => route('profile.show') . '#orders' // Redirect to profile with orders section
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout failed for user ' . $user->id . ': ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during checkout. Please try again. ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Fetch details for a single order, including its items.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOrderDetails(Order $order)
    {
        // Ensure the authenticated user owns this order
        if (Auth::id() !== $order->user_id) {
            return response()->json(['message' => 'Unauthorized to view this order.'], 403);
        }

        // Load the order items and their associated products
        $order->load(['items.product']);

        // Return the order and its items as JSON
        return response()->json($order);
    }
}
