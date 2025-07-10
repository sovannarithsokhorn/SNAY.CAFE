@extends('backend.layout.master')

@section('title', 'Products Management') {{-- Changed title to reflect product listing --}}

@section('content')
    <!-- Products Section -->
    <div id="products" class="section">
        <h2 class="font-syne text-3xl font-bold mb-6">Products Management</h2>
        {{-- Success Message Display (for redirects from add/edit/delete) --}}
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg mb-6 text-center">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-500 text-white p-4 rounded-lg mb-6 text-center">
                {{ session('error') }}
            </div>
        @endif

        {{-- Changed to navigate to a dedicated add page --}}
        <a href="{{ route('admin.products.create') }}" class="bg-noir-accent hover:bg-noir-accent/90 text-noir-dark font-medium py-2 px-4 rounded-lg mb-6 inline-block">
            Add New Product
        </a>
        <div class="bg-noir-medium rounded-xl p-6 shadow-lg">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr>
                            <th class="rounded-tl-lg">ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th class="rounded-tr-lg">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allProducts as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td class="py-2">
                                <img src="{{ asset('storage/' . $product->image_url) }}"
                                     alt="{{ $product->name_en }}"
                                     class="w-16 h-16 object-cover rounded-md border border-noir-light mx-auto"
                                     onerror="this.onerror=null;this.src='https://placehold.co/64x64/2A2A2A/D4A95C?text=No+Image';">
                            </td>
                            <td>{{ $product->name_en }}</td>
                            <td>{{ $product->category->name_en ?? 'N/A' }}</td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->stock }}</td>
                            <td class="space-x-2">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-500 hover:text-blue-700 text-sm">Edit</a>
                                {{-- REVERTED: Traditional Delete Form with onsubmit confirm --}}
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">No products found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
{{-- No custom JavaScript for delete confirmation needed here anymore --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // This page is a dedicated product management page, so ensure its content is visible.
        const productsSection = document.getElementById('products');
        if (productsSection) {
            productsSection.classList.remove('hidden');
        }
        // Optionally, if you want the sidebar "Products" button to appear active on this page:
        const productsButton = document.querySelector('button[onclick*="admin.products.index"]');
        if (productsButton) {
            const navButtons = document.querySelectorAll('nav ul li button');
            navButtons.forEach(button => {
                button.classList.remove('bg-noir-light', 'text-white');
                button.classList.add('text-noir-muted', 'hover:text-white', 'hover:bg-noir-light');
            });
            productsButton.classList.add('bg-noir-light', 'text-white');
            productsButton.classList.remove('text-noir-muted', 'hover:text-white', 'hover:bg-noir-light');

            // Update the header title if you have one
            const sectionTitle = document.getElementById('section-title');
            if (sectionTitle) {
                sectionTitle.innerText = productsButton.innerText.trim();
            }
        }
    });
</script>
<style>
    /* Custom scrollbar for form content if it overflows */
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #1A1A1A;
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #D4A95C;
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #c39a52;
    }
    /* Table styling for backend */
    table {
        border-collapse: separate;
        border-spacing: 0;
    }
    th, td {
        padding: 12px 16px;
        text-align: left;
        border-bottom: 1px solid #2A2A2A; /* Light border for rows */
        color: #fff; /* Ensure text is white */
    }
    thead th {
        background-color: #1A1A1A; /* Darker background for header */
        color: #D4A95C; /* Accent color for header text */
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    tbody tr:last-child td {
        border-bottom: none;
    }
    tbody tr:hover {
        background-color: #2A2A2A; /* Hover effect for rows */
    }
    /* Rounded corners for table header */
    thead th:first-child {
        border-top-left-radius: 0.75rem; /* rounded-tl-lg */
    }
    thead th:last-child {
        border-top-right-radius: 0.75rem; /* rounded-tr-lg */
    }
    /* Center image in table cell */
    td img {
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
</style>
@endpush
