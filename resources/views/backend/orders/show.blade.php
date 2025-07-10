@extends('backend.layout.master')

@section('title', 'Order Details - #' . $order->id)

@section('content')
<div class="container mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold text-white mb-6">Order Details #{{ $order->id }}</h1>

    <div class="bg-noir-medium rounded-lg shadow-xl p-8 border border-noir-light mb-8">
        {{-- Rearranged grid for 3 items on left, 3 on right --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            {{-- Left Column --}}
            <div>
                <p class="text-noir-muted text-sm uppercase font-semibold">Customer Name:</p>
                <p class="text-white text-lg">{{ $order->user->name ?? 'Guest User' }}</p>
            </div>
            <div>
                <p class="text-noir-muted text-sm uppercase font-semibold">Current Status:</p>
                <p class="text-white text-lg">
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                        @if($order->status == 'completed') bg-green-100 text-green-800
                        @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800
                        @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                        @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>
            </div>
            <div>
                <p class="text-noir-muted text-sm uppercase font-semibold">Total Amount:</p>
                <p class="text-noir-accent text-3xl font-bold">${{ number_format($order->total_amount, 2) }}</p>
            </div>

            {{-- Right Column --}}
            <div>
                <p class="text-noir-muted text-sm uppercase font-semibold">Customer Email:</p>
                <p class="text-white text-lg">{{ $order->user->email ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-noir-muted text-sm uppercase font-semibold">Customer Phone:</p>
                <p class="text-white text-lg">{{ $order->user->phone_number ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-noir-muted text-sm uppercase font-semibold">Order Date:</p>
                <p class="text-white text-lg">{{ $order->created_at->format('M d, Y H:i') }}</p>
            </div>
        </div>

        <h2 class="text-2xl font-bold text-white mb-4 border-b border-noir-light pb-2">Order Items</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-noir-light">
                <thead class="bg-noir-dark">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">
                            Product
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">
                            Quantity
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">
                            Price
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">
                            Subtotal
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-noir-medium divide-y divide-noir-light">
                    @foreach($order->items as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ $item->image ? asset('storage/' . $item->image) : 'https://placehold.co/40x40/2A2A2A/D4A95C?text=P' }}" alt="{{ $item->name }}" onerror="this.onerror=null;this.src='https://placehold.co/40x40/2A2A2A/D4A95C?text=P';">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-white">{{ $item->name }}</div>
                                    <div class="text-sm text-noir-muted">ID: {{ $item->product_id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                            {{ $item->quantity }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-noir-muted">
                            ${{ number_format($item->price, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-noir-accent">
                            ${{ number_format($item->quantity * $item->price, 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('admin.orders.index') }}" class="btn animated-border border-2 border-white text-white px-6 py-2 rounded-md font-medium text-base hover:border-noir-accent hover:text-noir-accent">
                Back to Orders
            </a>
            <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn ripple bg-noir-accent text-noir-dark px-6 py-2 rounded-md font-medium text-base transition-all duration-300 hover:bg-opacity-90">
                Edit Order
            </a>
        </div>
    </div>
</div>
@endsection
