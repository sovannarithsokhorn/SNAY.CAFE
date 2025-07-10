@extends('backend.layout.master')

@section('title', 'Manage Users')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold text-white mb-6">User Management</h1>

    <div class="bg-noir-medium rounded-lg shadow-xl p-8 border border-noir-light">
        <h2 class="text-xl font-semibold text-white mb-4">All Users</h2>

        {{-- Search and Filter Form --}}
        <form action="{{ route('admin.users.index') }}" method="GET" class="mb-6 flex flex-col sm:flex-row gap-4">
            <input type="text" name="search" placeholder="Search by name..."
                   value="{{ request('search') }}"
                   class="flex-1 bg-noir-light text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-noir-accent">

            <button type="submit" class="bg-noir-accent text-noir-dark px-6 py-2 rounded-md font-medium transition-all duration-300 hover:bg-opacity-90">
                Search
            </button>
            @if(request('search'))
                <a href="{{ route('admin.users.index') }}" class="bg-gray-600 text-white px-6 py-2 rounded-md font-medium transition-all duration-300 hover:bg-gray-700">
                    Clear Search
                </a>
            @endif
        </form>

        @if($users->isEmpty())
            <p class="text-noir-muted">No users found.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-noir-light">
                    <thead class="bg-noir-dark">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">Picture</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">Username</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">Phone</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-noir-medium divide-y divide-noir-light">
                        @foreach($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $user->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full overflow-hidden border-2 border-noir-accent flex items-center justify-center">
                                    <img class="max-h-full max-w-full object-contain"
                                         src="{{ $user->profile_picture_url ? asset('storage/' . $user->profile_picture_url) : 'https://placehold.co/40x40/2A2A2A/D4A95C?text=U' }}"
                                         alt="Profile"
                                         onerror="this.onerror=null;this.src='https://placehold.co/40x40/2A2A2A/D4A95C?text=U';">
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-noir-muted">{{ $user->username ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-noir-muted">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-noir-muted">{{ $user->phone_number ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-noir-muted">{{ ucfirst($user->role ?? 'User') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="text-noir-accent hover:text-white mr-3">View</a>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-400 hover:text-white mr-3">Edit</a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block delete-user-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-white">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                {{ $users->appends(request()->query())->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // SweetAlert for Delete Confirmation
        document.querySelectorAll('.delete-user-form').forEach(form => {
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
    });
</script>
@endpush
@endsection
