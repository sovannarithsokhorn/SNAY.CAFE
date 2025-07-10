@extends('backend.layout.master')

@section('title', 'Create New Order')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold text-white mb-6">Create New Order</h1>

    <div class="bg-noir-medium rounded-lg shadow-xl p-8 border border-noir-light">
        <form action="{{ route('admin.orders.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label for="user_id" class="block text-noir-muted text-sm font-bold mb-2">Customer:</label>
                <select name="user_id" id="user_id"
                        class="w-full p-3 rounded-md bg-noir-light border border-noir-muted text-white focus:outline-none focus:border-noir-accent appearance-none pr-8 @error('user_id') border-red-500 @enderror">
                    <option value="">Select a Customer</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="status" class="block text-noir-muted text-sm font-bold mb-2">Order Status:</label>
                <select name="status" id="status"
                        class="w-full p-3 rounded-md bg-noir-light border border-noir-muted text-white focus:outline-none focus:border-noir-accent appearance-none pr-8 @error('status') border-red-500 @enderror">
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <h2 class="text-2xl font-bold text-white mb-4 border-b border-noir-light pb-2">Order Items</h2>
            <div id="order-items-container" class="space-y-4 mb-6">
                {{-- Dynamic items will be added here via JavaScript if you implement that --}}
                <div class="flex flex-col md:flex-row gap-4 p-4 bg-noir-dark rounded-md border border-noir-light">
                    <div class="flex-1">
                        <label for="product_id_0" class="block text-noir-muted text-sm font-bold mb-2">Product:</label>
                        <select name="items[0][product_id]" id="product_id_0"
                                class="w-full p-2 rounded-md bg-noir-light border border-noir-muted text-white focus:outline-none focus:border-noir-accent appearance-none pr-8 @error('items.0.product_id') border-red-500 @enderror">
                            <option value="">Select a Product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ old('items.0.product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name_en }} (${{ number_format($product->price, 2) }})
                                </option>
                            @endforeach
                        </select>
                        @error('items.0.product_id')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="w-full md:w-24">
                        <label for="quantity_0" class="block text-noir-muted text-sm font-bold mb-2">Quantity:</label>
                        <input type="number" name="items[0][quantity]" id="quantity_0" value="{{ old('items.0.quantity', 1) }}" min="1"
                               class="w-full p-2 rounded-md bg-noir-light border border-noir-muted text-white text-center focus:outline-none focus:border-noir-accent @error('items.0.quantity') border-red-500 @enderror">
                        @error('items.0.quantity')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                {{-- You would add a button here to "Add More Items" with JavaScript --}}
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="btn ripple bg-noir-accent text-noir-dark px-6 py-2 rounded-md font-medium text-base transition-all duration-300 hover:bg-opacity-90">
                    Create Order
                </button>
                <a href="{{ route('admin.orders.index') }}" class="btn animated-border border-2 border-white text-white px-6 py-2 rounded-md font-medium text-base hover:border-noir-accent hover:text-noir-accent">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
