@extends('backend.layout.master')

@section('title', 'Edit Order - #' . $order->id)

@section('content')
<div class="container mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold text-white mb-6">Edit Order #{{ $order->id }}</h1>

    <div class="bg-noir-medium rounded-lg shadow-xl p-8 border border-noir-light">
        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="status" class="block text-noir-muted text-sm font-bold mb-2">Order Status:</label>
                <select name="status" id="status"
                        class="w-full p-3 rounded-md bg-noir-light border border-noir-muted text-white focus:outline-none focus:border-noir-accent appearance-none pr-8 @error('status') border-red-500 @enderror">
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- Optionally, you could add fields to edit total_amount, but it's usually derived. --}}
            {{-- <div class="mb-6">
                <label for="total_amount" class="block text-noir-muted text-sm font-bold mb-2">Total Amount:</label>
                <input type="number" step="0.01" name="total_amount" id="total_amount"
                       value="{{ old('total_amount', $order->total_amount) }}"
                       class="w-full p-3 rounded-md bg-noir-light border border-noir-muted text-white focus:outline-none focus:border-noir-accent @error('total_amount') border-red-500 @enderror">
                @error('total_amount')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div> --}}

            <div class="flex items-center justify-between">
                <button type="submit" class="btn ripple bg-noir-accent text-noir-dark px-6 py-2 rounded-md font-medium text-base transition-all duration-300 hover:bg-opacity-90">
                    Update Order
                </button>
                <a href="{{ route('admin.orders.index') }}" class="btn animated-border border-2 border-white text-white px-6 py-2 rounded-md font-medium text-base hover:border-noir-accent hover:text-noir-accent">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
