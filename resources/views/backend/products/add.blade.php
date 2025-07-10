@extends('backend.layout.master')

@section('title', 'Add New Product')

@section('content')
    <h2 class="font-syne text-3xl font-bold mb-4 text-center">Add New Product</h2>
    <div class="bg-noir-medium rounded-xl p-6 shadow-lg w-full max-w-6xl mx-auto h-full flex flex-col">
        {{-- Error Message Display (kept for server-side validation errors) --}}
        @if($errors->any())
            <div class="bg-red-500 text-white p-4 rounded-lg mb-6">
                <p class="font-bold">Please correct the following errors:</p>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- This form is for adding a new product. It uses the same styling as the modals for consistency. --}}
        <form id="addProductForm" action="{{ route('admin.products.store') }}" method="POST" class="flex-1 flex flex-col justify-between" enctype="multipart/form-data">
            @csrf
            {{-- Grid container for horizontal layout with 4 columns on large screens --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-4 overflow-y-auto pr-4 custom-scrollbar">
                {{-- Product Name (English) --}}
                <div>
                    <label for="add_product_name_en" class="block text-white text-sm font-medium mb-2">Product Name (English)</label>
                    <input type="text" id="add_product_name_en" name="name_en" class="w-full p-3 rounded-md bg-noir-dark border border-noir-light text-white focus:outline-none focus:ring-2 focus:ring-noir-accent" value="{{ old('name_en') }}" required>
                    @error('name_en')
                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Category --}}
                <div>
                    <label for="add_product_category" class="block text-white text-sm font-medium mb-2">Category</label>
                    <select id="add_product_category" name="category_id" class="w-full p-3 rounded-md bg-noir-dark border border-noir-light text-white focus:outline-none focus:ring-2 focus:ring-noir-accent" required>
                        <option value="">Select Category</option>
                        {{-- Loop through categories passed from the controller (e.g., BproductController) --}}
                        @foreach($allCategories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name_en }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Price --}}
                <div>
                    <label for="add_product_price" class="block text-white text-sm font-medium mb-2">Price</label>
                    <input type="number" id="add_product_price" name="price" step="0.01" class="w-full p-3 rounded-md bg-noir-dark border border-noir-light text-white focus:outline-none focus:ring-2 focus:ring-noir-accent" value="{{ old('price') }}" required>
                    @error('price')
                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Old Price (Optional) --}}
                <div>
                    <label for="add_product_old_price" class="block text-white text-sm font-medium mb-2">Old Price (Optional)</label>
                    <input type="number" id="add_product_old_price" name="old_price" step="0.01" class="w-full p-3 rounded-md bg-noir-dark border border-noir-light text-white focus:outline-none focus:ring-2 focus:ring-noir-accent" value="{{ old('old_price') }}">
                    @error('old_price')
                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Stock --}}
                <div>
                    <label for="add_product_stock" class="block text-white text-sm font-medium mb-2">Stock</label>
                    <input type="number" id="add_product_stock" name="stock" class="w-full p-3 rounded-md bg-noir-dark border border-noir-light text-white focus:outline-none focus:ring-2 focus:ring-noir-accent" value="{{ old('stock') }}" required>
                    @error('stock')
                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Image Upload/Preview --}}
                <div class="lg:col-span-2"> {{-- Spanning 2 columns for better visual --}}
                    <label for="add_product_image_file" class="block text-white text-sm font-medium mb-2">Product Image</label>
                    <div class="w-full h-32 bg-noir-dark border-2 border-dashed border-noir-light rounded-md flex items-center justify-center cursor-pointer relative overflow-hidden group" id="image_upload_area"> {{-- Reduced height to h-32 --}}
                        {{-- Hidden file input --}}
                        <input type="file" id="add_product_image_file" name="image_file" class="hidden" accept="image/*">
                        <img id="image_preview" src="{{ old('image_url') }}" alt="Image Preview" class="absolute inset-0 w-full h-full object-cover {{ old('image_url') ? '' : 'hidden' }}">
                        <div class="text-noir-muted text-center group-hover:text-noir-accent transition-colors {{ old('image_url') ? 'hidden' : '' }}" id="upload_placeholder">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"> {{-- Reduced icon size --}}
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Click to Upload Image
                        </div>
                        <button type="button" id="remove_image_btn" class="absolute top-1 right-1 bg-red-600 text-white rounded-full p-1 {{ old('image_url') ? '' : 'hidden' }} opacity-0 group-hover:opacity-100 transition-opacity" title="Remove Image"> {{-- Adjusted position --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    @error('image_file')
                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description (English) - Spans remaining columns --}}
                <div class="lg:col-span-4"> {{-- Spanning all 4 columns --}}
                    <label for="add_product_description_en" class="block text-white text-sm font-medium mb-2">Description (English)</label>
                    <textarea id="add_product_description_en" name="description_en" rows="3" class="w-full p-3 rounded-md bg-noir-dark border border-noir-light text-white focus:outline-none focus:ring-2 focus:ring-noir-accent">{{ old('description_en') }}</textarea>
                    @error('description_en')
                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Checkboxes and Form Actions in the same row --}}
                <div class="lg:col-span-4 flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0 md:space-x-6 mt-2">
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center">
                            <input type="checkbox" id="add_is_bestseller" name="is_bestseller" value="1" class="rounded text-noir-accent focus:ring-noir-accent" {{ old('is_bestseller') ? 'checked' : '' }}>
                            <label for="add_is_bestseller" class="text-white text-sm ml-2">Bestseller</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="add_is_organic" name="is_organic" value="1" class="rounded text-noir-accent focus:ring-noir-accent" {{ old('is_organic') ? 'checked' : '' }}>
                            <label for="add_is_organic" class="text-white text-sm ml-2">Organic</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="add_is_new" name="is_new" value="1" class="rounded text-noir-accent focus:ring-noir-accent" {{ old('is_new') ? 'checked' : '' }}>
                            <label for="add_is_new" class="text-white text-sm ml-2">New</label>
                        </div>
                    </div>
                    {{-- Form Actions (moved here) --}}
                    <div class="flex justify-end space-x-4 w-full md:w-auto">
                        <a href="{{ route('admin.products.index') }}" class="bg-noir-muted hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            Cancel
                        </a>
                        <button type="submit" id="submitProductBtn" class="bg-noir-accent hover:bg-noir-accent/90 text-noir-dark font-medium py-2 px-4 rounded-lg transition-colors">
                            Add Product
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
{{-- Include SweetAlert2 library (if not already included in master.blade.php) --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const addProductForm = document.getElementById('addProductForm');
        const submitProductBtn = document.getElementById('submitProductBtn');
        const imageUploadArea = document.getElementById('image_upload_area');
        const productImageFile = document.getElementById('add_product_image_file');
        const imagePreview = document.getElementById('image_preview');
        const uploadPlaceholder = document.getElementById('upload_placeholder');
        const removeImageBtn = document.getElementById('remove_image_btn');

        // Function to reset the form (including image preview)
        const resetForm = () => {
            addProductForm.reset(); // Resets text inputs, selects, and checkboxes
            imagePreview.src = '';
            imagePreview.classList.add('hidden');
            uploadPlaceholder.classList.remove('hidden');
            removeImageBtn.classList.add('hidden');
            // Clear any validation messages if they were displayed via JS (though Laravel handles this on reload)
            document.querySelectorAll('.text-red-300').forEach(el => el.remove());
        };

        // Initialize preview if old('image_url') exists
        if (imagePreview.src && imagePreview.src !== window.location.href) {
            imagePreview.classList.remove('hidden');
            uploadPlaceholder.classList.add('hidden');
            removeImageBtn.classList.remove('hidden');
        }

        // Trigger file input when the image upload area is clicked
        imageUploadArea.addEventListener('click', () => {
            productImageFile.click();
        });

        // Handle file selection and preview
        productImageFile.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                    uploadPlaceholder.classList.add('hidden');
                    removeImageBtn.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                // If no file is selected (e.g., user cancels), clear preview
                imagePreview.src = '';
                imagePreview.classList.add('hidden');
                uploadPlaceholder.classList.remove('hidden');
                removeImageBtn.classList.add('hidden');
            }
        });

        // Function to remove the image
        removeImageBtn.addEventListener('click', (e) => {
            e.stopPropagation(); // Prevent triggering the imageUploadArea click
            productImageFile.value = ''; // Clear the file input
            imagePreview.src = '';
            imagePreview.classList.add('hidden');
            uploadPlaceholder.classList.remove('hidden');
            removeImageBtn.classList.add('hidden');
        });

        // Intercept form submission for AJAX
        addProductForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            const formData = new FormData(this); // Get form data, including file
            const url = this.action;

            // Disable button and show loading state
            submitProductBtn.disabled = true;
            submitProductBtn.textContent = 'Adding...';
            submitProductBtn.classList.add('opacity-75', 'cursor-not-allowed');

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        // Do NOT set 'Content-Type': 'application/json' when sending FormData with files
                    },
                    body: formData, // Send FormData directly
                })
                .then(response => {
                    // Re-enable button regardless of success/failure
                    submitProductBtn.disabled = false;
                    submitProductBtn.textContent = 'Add Product';
                    submitProductBtn.classList.remove('opacity-75', 'cursor-not-allowed');

                    // Check if response is JSON (Laravel returns JSON for validation errors by default)
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json();
                    } else {
                        // If not JSON, it's likely a full page redirect (e.g., for validation errors if not AJAX)
                        // Or an unexpected response. Handle as a generic error.
                        throw new Error('Unexpected response from server.');
                    }
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            customClass: {
                                popup: 'swal2-toast-popup',
                            }
                        });
                        resetForm(); // Clear the form on success
                    } else {
                        // Handle server-side validation errors or other non-success responses
                        // Laravel's default validation returns errors in a 'errors' key
                        if (data.errors) {
                            // You could dynamically display these errors next to fields
                            // For simplicity, we'll show a general error toast
                            let errorMessages = Object.values(data.errors).flat().join('\n');
                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error!',
                                text: errorMessages || 'Please check your input.',
                                confirmButtonColor: '#D4A95C'
                            });
                            // Optionally, re-populate old input values if needed, though form.reset() clears them
                            // You might need to manually set values if you want to retain them after a validation error
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: data.message || 'An unknown error occurred.',
                                confirmButtonColor: '#D4A95C'
                            });
                        }
                    }
                })
                .catch(error => {
                    console.error('Error submitting form:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Submission Failed!',
                        text: error.message || 'Could not add product. Please try again.',
                        confirmButtonColor: '#D4A95C'
                    });
                });
        });
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
    /* Custom class for SweetAlert2 toast popups */
    .swal2-toast-popup {
        background-color: #1A1A1A !important; /* Dark background for toasts */
        color: #fff !important; /* White text */
        border: 1px solid #D4A95C !important; /* Accent border */
        box-shadow: 0 0 10px rgba(212, 169, 92, 0.5) !important; /* Subtle glow */
    }
    .swal2-title {
        color: #fff !important;
    }
    .swal2-html-container {
        color: #ddd !important;
    }
    .swal2-success-line-long, .swal2-success-line-tip {
        background-color: #D4A95C !important; /* Change success icon color */
    }
    .swal2-progress-bar {
        background-color: #D4A95C !important; /* Change progress bar color */
    }
</style>
@endpush
