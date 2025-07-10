@extends('backend.layout.master') {{-- Assuming your backend master layout --}}

@section('title', 'Manage Orders')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold text-white mb-6">Order Management</h1>

    {{-- Search and Filter Form --}}
    <form action="{{ route('admin.orders.index') }}" method="GET" class="mb-6 p-4 bg-noir-medium rounded-lg shadow-md flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">
        <div class="flex-1 w-full">
            <label for="search" class="sr-only">Search Orders</label>
            <input type="text" name="search" id="search" placeholder="Search by Order ID or User Name..."
                   value="{{ request('search') }}"
                   class="w-full p-2 rounded-md bg-noir-light border border-noir-muted text-white placeholder-noir-muted focus:outline-none focus:border-noir-accent">
        </div>

        <div class="w-full md:w-auto">
            <label for="status" class="sr-only">Filter by Status</label>
            <select name="status" id="status"
                    class="w-full p-2 rounded-md bg-noir-light border border-noir-muted text-white focus:outline-none focus:border-noir-accent appearance-none pr-8">
                <option value="all">All Statuses</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="w-full md:w-auto btn ripple bg-noir-accent text-noir-dark px-6 py-2 rounded-md font-medium text-base transition-all duration-300 hover:bg-opacity-90">
            Apply Filters
        </button>
        <a href="{{ route('admin.orders.index') }}" class="w-full md:w-auto btn animated-border border-2 border-white text-white px-6 py-2 rounded-md font-medium text-base hover:border-noir-accent hover:text-noir-accent text-center">
            Clear Filters
        </a>
    </form>

    {{-- Orders Table --}}
    <div class="bg-noir-medium rounded-lg shadow-xl overflow-hidden border border-noir-light">
        <table class="min-w-full divide-y divide-noir-light">
            <thead class="bg-noir-dark">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">
                        Order ID
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">
                        Customer
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">
                        Total Amount
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">
                        Order Date
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Actions</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-noir-medium divide-y divide-noir-light">
                @forelse($orders as $order)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                        #{{ $order->id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-noir-muted">
                        {{ $order->user->name ?? 'Guest User' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-noir-accent">
                        ${{ number_format($order->total_amount, 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if($order->status == 'completed') bg-green-100 text-green-800
                            @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                            @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-noir-muted">
                        {{ $order->created_at->format('M d, Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-noir-accent hover:text-white mr-3">View</a>
                        <a href="{{ route('admin.orders.edit', $order->id) }}" class="text-blue-400 hover:text-white mr-3">Edit</a>
                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="inline-block delete-order-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-white">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-noir-muted">
                        No orders found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $orders->links('vendor.pagination.tailwind') }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // SweetAlert for Delete Confirmation
        document.querySelectorAll('.delete-order-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#D4A95C',
                    cancelButtonColor: '#2A2A2A',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Flash messages (if you have them from Laravel)
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        @endif
    });
</script>
@endpush
