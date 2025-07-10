@extends('backend.layout.master')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mx-auto px-6 ">
    <h1 class="text-3xl font-bold text-white mb-6">Overview</h1>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-noir-medium rounded-lg shadow-xl p-6 border border-noir-light flex flex-col items-center justify-center text-center transform transition-transform duration-300 hover:scale-[1.02]">
            <i class="fas fa-users text-4xl text-noir-accent mb-3"></i>
            <p class="text-noir-muted text-sm uppercase font-semibold">Total Users</p>
            <p class="text-white text-4xl font-bold font-syne">{{ $totalUsers }}</p>
        </div>
        <div class="bg-noir-medium rounded-lg shadow-xl p-6 border border-noir-light flex flex-col items-center justify-center text-center transform transition-transform duration-300 hover:scale-[1.02]">
            <i class="fas fa-coffee text-4xl text-noir-accent mb-3"></i>
            <p class="text-noir-muted text-sm uppercase font-semibold">Total Products</p>
            <p class="text-white text-4xl font-bold font-syne">{{ $totalProducts }}</p>
        </div>
        <div class="bg-noir-medium rounded-lg shadow-xl p-6 border border-noir-light flex flex-col items-center justify-center text-center transform transition-transform duration-300 hover:scale-[1.02]">
            <i class="fas fa-receipt text-4xl text-noir-accent mb-3"></i>
            <p class="text-noir-muted text-sm uppercase font-semibold">Total Orders</p>
            <p class="text-white text-4xl font-bold font-syne">{{ $totalOrders }}</p>
        </div>
        <div class="bg-noir-medium rounded-lg shadow-xl p-6 border border-noir-light flex flex-col items-center justify-center text-center transform transition-transform duration-300 hover:scale-[1.02]">
            <i class="fas fa-dollar-sign text-4xl text-noir-accent mb-3"></i>
            <p class="text-noir-muted text-sm uppercase font-semibold">Total Revenue</p>
            <p class="text-white text-4xl font-bold font-syne">${{ number_format($totalRevenue, 2) }}</p>
        </div>
    </div>

    {{-- Recent Activities Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent Orders --}}
        <div class="bg-noir-medium rounded-lg shadow-xl p-8 border border-noir-light">
            <h2 class="text-xl font-semibold text-white mb-4 border-b border-noir-light pb-2">Recent Orders</h2>
            @if($recentOrders->isEmpty())
                <p class="text-noir-muted">No recent orders.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-noir-light">
                        <thead class="bg-noir-dark">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">Order ID</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">Customer</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">Amount</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-noir-light">
                            @foreach($recentOrders as $order)
                            <tr>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-white">#{{ $order->id }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-noir-muted">{{ $order->user->name ?? 'Guest' }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-noir-accent">${{ number_format($order->total_amount, 2) }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm">
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
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 text-right">
                    <a href="{{ route('admin.orders.index') }}" class="text-noir-accent hover:underline text-sm">View All Orders &rarr;</a>
                </div>
            @endif
        </div>

        {{-- Recent Users --}}
        <div class="bg-noir-medium rounded-lg shadow-xl p-8 border border-noir-light">
            <h2 class="text-xl font-semibold text-white mb-4 border-b border-noir-light pb-2">Recent Users</h2>
            @if($recentUsers->isEmpty())
                <p class="text-noir-muted">No recent users.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-noir-light">
                        <thead class="bg-noir-dark">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">ID</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">Name</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">Email</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">Registered</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-noir-light">
                            @foreach($recentUsers as $user)
                            <tr>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-white">{{ $user->id }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-white">{{ $user->name }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-noir-muted">{{ $user->email }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-noir-muted">{{ $user->created_at ? $user->created_at->format('Y-m-d') : 'N/A' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 text-right">
                    <a href="{{ route('admin.users.index') }}" class="text-noir-accent hover:underline text-sm">View All Users &rarr;</a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the session message. Use a more explicit check for the session key.
        // Laravel's default login often uses 'status' for success messages.
        // If your login uses a different key (e.g., 'success_message'), change this.
        const successMessage = "{{ session('status') ?? session('success') ?? '' }}"; 
        
        // --- DEBUGGING STEP: Check what the successMessage variable contains ---
        console.log('SweetAlert check: successMessage =', successMessage);
        // Open your browser's developer console (F12) and check this output after logging in.

        // Check if the message exists and contains relevant keywords for a login success
        if (successMessage.length > 0 && (successMessage.includes('logged in') || successMessage.includes('Welcome') || successMessage.includes('Login successful'))) {
            Swal.fire({
                title: 'Welcome Admin!',
                text: 'You have successfully logged in.',
                icon: 'success',
                confirmButtonColor: '#D4A95C', // SNAY.CAFE accent color
                background: '#1A1A1A', // SweetAlert background to match noir-medium
                color: '#FFFFFF' // White text
            });
        }
    });
</script>
@endpush
@endsection