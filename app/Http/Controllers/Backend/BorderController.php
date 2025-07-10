<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User; // To link orders to users
use App\Models\Product; // To link order items to products
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule; // For validation rules

class BorderController extends Controller // Renamed class
{
    /**
     * Display a listing of the orders.
     * Includes search, filter by status, and pagination.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Order::query();

        // Search by Order ID or User Name
        if ($request->has('search') && $request->input('search') != '') {
            $search = $request->input('search');
            $query->where('id', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('name', 'like', '%' . $search . '%');
                  });
        }

        // Filter by Status
        if ($request->has('status') && $request->input('status') != 'all') {
            $query->where('status', $request->input('status'));
        }

        // Eager load user relationship for display
        $orders = $query->with('user')->orderBy('created_at', 'desc')->paginate(10);

        // Get unique statuses for filter dropdown
        $statuses = ['pending', 'processing', 'completed', 'cancelled']; // Define your possible statuses

        return view('backend.orders.index', compact('orders', 'statuses'));
    }

    /**
     * Show the form for creating a new order.
     * (Less common for admin to create full orders, but included for CRUD completeness).
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $users = User::all(); // Get all users to assign an order to
        $products = Product::all(); // Get all products for order items
        $statuses = ['pending', 'processing', 'completed', 'cancelled'];
        return view('backend.orders.create', compact('users', 'products', 'statuses'));
    }

    /**
     * Store a newly created order in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'status' => ['required', Rule::in(['pending', 'processing', 'completed', 'cancelled'])],
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $totalAmount = 0;
            $orderItemsData = [];

            foreach ($request->items as $itemData) {
                $product = Product::find($itemData['product_id']);
                if (!$product) {
                    throw new \Exception("Product with ID {$itemData['product_id']} not found.");
                }
                $itemPrice = $product->price; // Use current product price
                $itemQuantity = $itemData['quantity'];
                $totalAmount += $itemPrice * $itemQuantity;

                $orderItemsData[] = [
                    'product_id' => $product->id,
                    'quantity' => $itemQuantity,
                    'price' => $itemPrice,
                    'name' => $product->name_en, // Store product name at time of order
                    'image' => $product->image_url, // Store product image at time of order
                ];
            }

            $order = Order::create([
                'user_id' => $request->user_id,
                'total_amount' => $totalAmount,
                'status' => $request->status,
            ]);

            foreach ($orderItemsData as $item) {
                $order->items()->create($item);
            }

            DB::commit();
            return redirect()->route('admin.orders.index')->with('success', 'Order created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating order: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create order: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified order.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\View\View
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items.product']); // Eager load user, items, and product for each item
        return view('backend.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified order.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\View\View
     */
    public function edit(Order $order)
    {
        $statuses = ['pending', 'processing', 'completed', 'cancelled']; // Define your possible statuses
        return view('backend.orders.edit', compact('order', 'statuses'));
    }

    /**
     * Update the specified order in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => ['required', Rule::in(['pending', 'processing', 'completed', 'cancelled'])],
            // You might allow updating total_amount manually, but it's usually derived.
            // If allowing, add: 'total_amount' => 'required|numeric|min:0',
        ]);

        try {
            $order->update([
                'status' => $request->status,
                // 'total_amount' => $request->total_amount, // Uncomment if you allow manual total update
            ]);
            return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating order ' . $order->id . ': ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update order: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified order from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Order $order)
    {
        DB::beginTransaction();
        try {
            // Delete associated order items first to maintain referential integrity
            $order->items()->delete();
            $order->delete();
            DB::commit();
            return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting order ' . $order->id . ': ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete order: ' . $e->getMessage());
        }
    }
}
