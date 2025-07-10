
@extends('backend.layout.master')

@section('title', 'Edit Product')

@section('content')
    <h2 class="font-syne text-3xl font-bold mb-4 text-center">Edit Product</h2>
    <div class="bg-noir-medium rounded-xl p-6 shadow-lg w-full max-w-6xl mx-auto h-full flex flex-col">
        {{-- Error Message Display (kept for server-side validation errors that redirect) --}}
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

        {{-- Form for editing an existing product --}}
        <form id="editProductForm" action="{{ route('admin.products.update', $product->id) }}" method="POST" class="flex-1 flex flex-col justify-between" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- Specify that this is a PUT request for updates --}}

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-4 overflow-y-auto pr-4 custom-scrollbar">
                {{-- Product Name (English) --}}
                <div>
                    <label for="edit_product_name_en" class="block text-white text-sm font-medium mb-2">Product Name (English)</label>
                    <input type="text" id="edit_product_name_en" name="name_en" class="w-full p-3 rounded-md bg-noir-dark border border-noir-light text-white focus:outline-none focus:ring-2 focus:ring-noir-accent" value="{{ old('name_en', $product->name_en) }}" required>
                    @error('name_en')
                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Category --}}
                <div>
                    <label for="edit_product_category" class="block text-white text-sm font-medium mb-2">Category</label>
                    <select id="edit_product_category" name="category_id" class="w-full p-3 rounded-md bg-noir-dark border border-noir-light text-white focus:outline-none focus:ring-2 focus:ring-noir-accent" required>
                        <option value="">Select Category</option>
                        @foreach($allCategories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name_en }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Price --}}
                <div>
                    <label for="edit_product_price" class="block text-white text-sm font-medium mb-2">Price</label>
                    <input type="number" id="edit_product_price" name="price" step="0.01" class="w-full p-3 rounded-md bg-noir-dark border border-noir-light text-white focus:outline-none focus:ring-2 focus:ring-noir-accent" value="{{ old('price', $product->price) }}" required>
                    @error('price')
                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Old Price (Optional) --}}
                <div>
                    <label for="edit_product_old_price" class="block text-white text-sm font-medium mb-2">Old Price (Optional)</label>
                    <input type="number" id="edit_product_old_price" name="old_price" step="0.01" class="w-full p-3 rounded-md bg-noir-dark border border-noir-light text-white focus:outline-none focus:ring-2 focus:ring-noir-accent" value="{{ old('old_price', $product->old_price) }}">
                    @error('old_price')
                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Stock --}}
                <div>
                    <label for="edit_product_stock" class="block text-white text-sm font-medium mb-2">Stock</label>
                    <input type="number" id="edit_product_stock" name="stock" class="w-full p-3 rounded-md bg-noir-dark border border-noir-light text-white focus:outline-none focus:ring-2 focus:ring-noir-accent" value="{{ old('stock', $product->stock) }}" required>
                    @error('stock')
                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Image Upload/Preview --}}
                <div class="lg:col-span-2">
                    <label for="edit_product_image_file" class="block text-white text-sm font-medium mb-2">Product Image</label>
                    <div class="w-full h-32 bg-noir-dark border-2 border-dashed border-noir-light rounded-md flex items-center justify-center cursor-pointer relative overflow-hidden group" id="image_upload_area">
                        <input type="file" id="edit_product_image_file" name="image_file" class="hidden" accept="image/*">
                        <img id="image_preview" src="{{ $product->image_url ? asset('storage/' . $product->image_url) : '' }}" alt="Image Preview" class="absolute inset-0 w-full h-full object-cover {{ $product->image_url ? '' : 'hidden' }}">
                        <div class="text-noir-muted text-center group-hover:text-noir-accent transition-colors {{ $product->image_url ? 'hidden' : '' }}" id="upload_placeholder">
                            <svg xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" class="h-8 w-8 mx-auto mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Click to Upload Image
                        </div>
                        <button type="button" id="remove_image_btn" class="absolute top-1 right-1 bg-red-600 text-white rounded-full p-1 {{ $product->image_url ? '' : 'hidden' }} opacity-0 group-hover:opacity-100 transition-opacity" title="Remove Image">
                            <svg xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    @error('image_file')
                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description (English) - Spans remaining columns --}}
                <div class="lg:col-span-4">
                    <label for="edit_product_description_en" class="block text-white text-sm font-medium mb-2">Description (English)</label>
                    <textarea id="edit_product_description_en" name="description_en" rows="3" class="w-full p-3 rounded-md bg-noir-dark border border-noir-light text-white focus:outline-none focus:ring-2 focus:ring-noir-accent">{{ old('description_en', $product->description_en) }}</textarea>
                    @error('description_en')
                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Checkboxes and Form Actions in the same row --}}
                <div class="lg:col-span-4 flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0 md:space-x-6 mt-2">
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center">
                            <input type="checkbox" id="edit_is_bestseller" name="is_bestseller" value="1" class="rounded text-noir-accent focus:ring-noir-accent" {{ old('is_bestseller', $product->is_bestseller) ? 'checked' : '' }}>
                            <label for="edit_is_bestseller" class="text-white text-sm ml-2">Bestseller</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="edit_is_organic" name="is_organic" value="1" class="rounded text-noir-accent focus:ring-noir-accent" {{ old('is_organic', $product->is_organic) ? 'checked' : '' }}>
                            <label for="edit_is_organic" class="text-white text-sm ml-2">Organic</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="edit_is_new" name="is_new" value="1" class="rounded text-noir-accent focus:ring-noir-accent" {{ old('is_new', $product->is_new) ? 'checked' : '' }}>
                            <label for="edit_is_new" class="text-white text-sm ml-2">New</label>
                        </div>
                    </div>
                    {{-- Form Actions (moved here) --}}
                    <div class="flex justify-end space-x-4 w-full md:w-auto">
                        <a href="{{ route('admin.products.index') }}" class="bg-noir-muted hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            Cancel
                        </a>
                        <button type="submit" id="updateProductBtn" class="bg-noir-accent hover:bg-noir-accent/90 text-noir-dark font-medium py-2 px-4 rounded-lg transition-colors">
                            Update Product
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
{{-- Include SweetAlert2 library (if not already included in master.blade.php) --}}
<script src="[https://cdn.jsdelivr.net/npm/sweetalert2@11](https://cdn.jsdelivr.net/npm/sweetalert2@11)"></script>
<script>
    console.log('Script block started.'); // Debugging log 1

    document.addEventListener('DOMContentLoaded', () => {
        console.log('DOMContentLoaded fired.'); // Debugging log 2

        // Ensure the content is visible on this dedicated page
        const contentSection = document.querySelector('.flex-1.overflow-y-auto.p-6.bg-noir-dark');
        if (contentSection) {
            contentSection.classList.remove('hidden');
            console.log('Content section unhidden.'); // Debugging log 3
        }

        const imageUploadArea = document.getElementById('image_upload_area');
        const productImageFile = document.getElementById('edit_product_image_file');
        const imagePreview = document.getElementById('image_preview');
        const uploadPlaceholder = document.getElementById('upload_placeholder');
        const removeImageBtn = document.getElementById('remove_image_btn');
        const editProductForm = document.getElementById('editProductForm');
        const updateProductBtn = document.getElementById('updateProductBtn');

        // Debugging: Check if elements are found
        console.log('editProductForm element:', editProductForm);
        console.log('updateProductBtn element:', updateProductBtn);

        // Function to display SweetAlert2 toast messages (consistent style)
        const showToast = (icon, title, text) => {
            Swal.fire({
                icon: icon,
                title: title,
                text: text,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'swal2-toast-popup',
                }
            });
        };

        // Initialize preview based on existing product image
        const initialImageUrl = imagePreview.src;

        if (initialImageUrl && initialImageUrl !== window.location.href) {
            imagePreview.classList.remove('hidden');
            uploadPlaceholder.classList.add('hidden');
            removeImageBtn.classList.remove('hidden');
        } else {
            imagePreview.classList.add('hidden');
            uploadPlaceholder.classList.remove('hidden');
            removeImageBtn.classList.add('hidden');
        }
        console.log('Image preview initialized.'); // Debugging log 4

        // Trigger file input when the image upload area is clicked
        imageUploadArea.addEventListener('click', () => {
            productImageFile.click();
            console.log('Image upload area clicked.'); // Debugging log 5
        });

        // Handle file selection and preview
        productImageFile.addEventListener('change', (event) => {
            console.log('Product image file changed.'); // Debugging log 6
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
                if (initialImageUrl) {
                    imagePreview.src = initialImageUrl;
                    imagePreview.classList.remove('hidden');
                    uploadPlaceholder.classList.add('hidden');
                    removeImageBtn.classList.remove('hidden');
                } else {
                    imagePreview.src = '';
                    imagePreview.classList.add('hidden');
                    uploadPlaceholder.classList.remove('hidden');
                    removeImageBtn.classList.add('hidden');
                }
            }
        });

        // Function to remove the image
        removeImageBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            productImageFile.value = '';
            imagePreview.src = '';
            imagePreview.classList.add('hidden');
            uploadPlaceholder.classList.remove('hidden');
            removeImageBtn.classList.add('hidden');
            console.log('Image removed.'); // Debugging log 7
        });

        // Intercept form submission for AJAX
        if (editProductForm) { // Added a check here
            editProductForm.addEventListener('submit', function(e) {
                console.log('Form submit event fired!'); // Debugging log 8
                e.preventDefault(); // Prevent default form submission

                const formData = new FormData(this);
                const url = this.action;

                // Disable button and show loading state
                if (updateProductBtn) { // Added a check here
                    updateProductBtn.disabled = true;
                    updateProductBtn.textContent = 'Updating...';
                    updateProductBtn.classList.add('opacity-75', 'cursor-not-allowed');
                    console.log('Update button disabled.'); // Debugging log 9
                }


                fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest',
                            // DO NOT set 'Content-Type': 'application/json' when sending FormData with files
                        },
                        body: formData,
                    })
                    .then(response => {
                        console.log('Fetch response received.', response); // Debugging log 10
                        // Re-enable button regardless of success/failure
                        if (updateProductBtn) {
                            updateProductBtn.disabled = false;
                            updateProductBtn.textContent = 'Update Product';
                            updateProductBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                        }

                        const contentType = response.headers.get('content-type');
                        if (contentType && contentType.includes('application/json')) {
                            return response.json();
                        } else {
                            throw new Error('Unexpected response from server (not JSON). Status: ' + response.status);
                        }
                    })
                    .then(data => {
                        console.log('Fetch data parsed:', data); // Debugging log 11
                        if (data.success) {
                            showToast('success', 'Updated!', data.message);
                        } else {
                            if (data.errors) {
                                let errorMessages = Object.values(data.errors).flat().join('\n');
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Validation Error!',
                                    text: errorMessages || 'Please check your input.',
                                    confirmButtonColor: '#D4A95C'
                                });
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
                        console.error('Error submitting form:', error); // Debugging log 12
                        Swal.fire({
                            icon: 'error',
                            title: 'Submission Failed!',
                            text: error.message || 'Could not update product. Please try again.',
                            confirmButtonColor: '#D4A95C'
                        });
                    });
            });
        } else {
            console.error('Error: editProductForm element not found!'); // Debugging log A
        }


        // Handle success/error messages from redirects (e.g., if validation fails and Laravel redirects)
        @if(session('success'))
            console.log('Session success message detected.'); // Debugging log B
            showToast('success', 'Success!', '{{ session('success') }}');
        @endif
        @if(session('error'))
            console.log('Session error message detected.'); // Debugging log C
            showToast('error', 'Error!', '{{ session('error') }}');
        @endif
    });
    console.log('Script block finished parsing.'); // Debugging log D
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
    /* SweetAlert2 toast styling (copied from index.blade.php for consistency) */
    .swal2-toast-popup {
        background-color: #1A1A1A !important;
        color: #fff !important;
        border: 1px solid #D4A95C !important;
        box-shadow: 0 0 10px rgba(212, 169, 92, 0.5) !important;
    }
    .swal2-title {
        color: #fff !important;
    }
    .swal2-html-container {
        color: #ddd !important;
    }
    .swal2-success-line-long, .swal2-success-line-tip {
        background-color: #D4A95C !important;
    }
    .swal2-progress-bar {
        background-color: #D4A95C !important;
    }
    .swal2-icon.swal2-warning {
        border-color: #D4A95C !important;
        color: #D4A95C !important;
    }
    .swal2-icon.swal2-error {
        border-color: #EF4444 !important;
        color: #EF4444 !important;
    }
</style>
@endpush
