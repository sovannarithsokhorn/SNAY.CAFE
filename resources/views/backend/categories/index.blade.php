@extends('backend.layout.master')

@section('title', 'Categories Management')

@section('content')
    <!-- Global Alert Message Area -->
    <div id="global-alert" class="hidden fixed top-4 right-4 z-50 w-full max-w-sm rounded-lg p-4 shadow-lg text-white transition-all duration-300 transform translate-x-full">
        <div class="flex items-center">
            <span id="alert-icon" class="mr-3"></span>
            <p id="alert-message" class="font-medium"></p>
            <button class="ml-auto text-white opacity-75 hover:opacity-100" onclick="hideAlert()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Categories Section -->
    <div id="categories" class="section">
        <h2 class="font-syne text-3xl font-bold mb-6">Categories Management</h2>
        {{-- Button to open the Add New Category Modal --}}
        <button class="bg-noir-accent hover:bg-noir-accent/90 text-noir-dark font-medium py-2 px-4 rounded-lg mb-6 inline-block" onclick="openModal('addCategoryModal')">
            Add New Category
        </button>
        <div class="bg-noir-medium rounded-xl p-6 shadow-lg">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr>
                            <th class="rounded-tl-lg">ID</th>
                            <th>Image</th> {{-- Added Image column header --}}
                            <th>Name (EN)</th> {{-- Updated column header --}}
                            <th>Name (KM)</th> {{-- Added column header for Khmer name --}}
                            <th class="rounded-tr-lg">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allCategories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>
                                @if($category->image_url)
                                    <img src="{{ asset('storage/' . $category->image_url) }}" alt="{{ $category->name_en }}" class="h-10 w-10 object-cover rounded-md">
                                @else
                                    <div class="h-10 w-10 bg-noir-light rounded-md flex items-center justify-center text-xs text-noir-muted">No Image</div>
                                @endif
                            </td>
                            <td>{{ $category->name_en }}</td>
                            <td>{{ $category->name_km ?? 'N/A' }}</td> {{-- Display Khmer name --}}
                            <td class="space-x-2">
                                {{-- Button to open the Edit Category Modal --}}
                                <button class="text-blue-500 hover:text-blue-700 text-sm" onclick="openEditModal({{ $category->id }}, '{{ $category->name_en }}', '{{ $category->name_km ?? '' }}', '{{ $category->image_url ? asset('storage/' . $category->image_url) : '' }}')">Edit</button>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">No categories found.</td> {{-- Updated colspan --}}
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Add Category Modal --}}
    <div id="addCategoryModal" class="modal hidden fixed inset-0 bg-black bg-opacity-75 items-center justify-center z-50">
        <div class="bg-noir-medium rounded-xl p-8 shadow-lg w-full max-w-md relative">
            <button class="absolute top-4 right-4 text-noir-muted hover:text-white" onclick="closeModal('addCategoryModal')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <h3 class="font-syne text-2xl font-bold mb-6">Add New Category</h3>
            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4" enctype="multipart/form-data"> {{-- Added enctype for file upload --}}
                @csrf
                <input type="hidden" name="_add_form" value="1">
                <div>
                    <label for="add_category_name_en" class="block text-white text-sm font-medium mb-2">Category Name (English)</label>
                    <input type="text" id="add_category_name_en" name="name_en" class="w-full p-3 rounded-md bg-noir-dark border border-noir-light text-white focus:outline-none focus:ring-2 focus:ring-noir-accent" value="{{ old('name_en') }}" required>
                    @error('name_en')
                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="add_category_name_km" class="block text-white text-sm font-medium mb-2">Category Name (Khmer)</label> {{-- Added field for Khmer name --}}
                    <input type="text" id="add_category_name_km" name="name_km" class="w-full p-3 rounded-md bg-noir-dark border border-noir-light text-white focus:outline-none focus:ring-2 focus:ring-noir-accent" value="{{ old('name_km') }}">
                    @error('name_km')
                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                {{-- Image Upload for Add Category --}}
                <div>
                    <label for="add_category_image_file" class="block text-white text-sm font-medium mb-2">Category Image</label>
                    <div class="w-full h-32 bg-noir-dark border-2 border-dashed border-noir-light rounded-md flex items-center justify-center cursor-pointer relative overflow-hidden group" id="add_image_upload_area">
                        <input type="file" id="add_category_image_file" name="image_file" class="hidden" accept="image/*">
                        <img id="add_image_preview" src="" alt="Image Preview" class="absolute inset-0 w-full h-full object-cover hidden">
                        <div class="text-noir-muted text-center group-hover:text-noir-accent transition-colors" id="add_upload_placeholder">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Click to Upload Image
                        </div>
                        <button type="button" id="add_remove_image_btn" class="absolute top-1 right-1 bg-red-600 text-white rounded-full p-1 hidden opacity-0 group-hover:opacity-100 transition-opacity" title="Remove Image">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    @error('image_file')
                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-end space-x-4 mt-6">
                    <button type="button" class="bg-noir-muted hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg" onclick="closeModal('addCategoryModal')">
                        Cancel
                    </button>
                    <button type="submit" class="bg-noir-accent hover:bg-noir-accent/90 text-noir-dark font-medium py-2 px-4 rounded-lg">
                        Add Category
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Category Modal --}}
    <div id="editCategoryModal" class="modal hidden fixed inset-0 bg-black bg-opacity-75 items-center justify-center z-50">
        <div class="bg-noir-medium rounded-xl p-8 shadow-lg w-full max-w-md relative">
            <button class="absolute top-4 right-4 text-noir-muted hover:text-white" onclick="closeModal('editCategoryModal')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <h3 class="font-syne text-2xl font-bold mb-6">Edit Category</h3>
            <form id="editCategoryForm" method="POST" class="space-y-4" enctype="multipart/form-data"> {{-- Added enctype --}}
                @csrf
                @method('PUT')
                <input type="hidden" name="_edit_form" value="1">
                <input type="hidden" name="remove_image" id="edit_remove_image_flag" value="0"> {{-- Hidden field to signal image removal --}}
                <div>
                    <label for="edit_category_name_en" class="block text-white text-sm font-medium mb-2">Category Name (English)</label>
                    <input type="text" id="edit_category_name_en" name="name_en" class="w-full p-3 rounded-md bg-noir-dark border border-noir-light text-white focus:outline-none focus:ring-2 focus:ring-noir-accent" required>
                    @error('name_en')
                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="edit_category_name_km" class="block text-white text-sm font-medium mb-2">Category Name (Khmer)</label> {{-- Added field for Khmer name --}}
                    <input type="text" id="edit_category_name_km" name="name_km" class="w-full p-3 rounded-md bg-noir-dark border border-noir-light text-white focus:outline-none focus:ring-2 focus:ring-noir-accent">
                    @error('name_km')
                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                {{-- Image Upload for Edit Category --}}
                <div>
                    <label for="edit_category_image_file" class="block text-white text-sm font-medium mb-2">Category Image</label>
                    <div class="w-full h-32 bg-noir-dark border-2 border-dashed border-noir-light rounded-md flex items-center justify-center cursor-pointer relative overflow-hidden group" id="edit_image_upload_area">
                        <input type="file" id="edit_category_image_file" name="image_file" class="hidden" accept="image/*">
                        <img id="edit_image_preview" src="" alt="Image Preview" class="absolute inset-0 w-full h-full object-cover hidden">
                        <div class="text-noir-muted text-center group-hover:text-noir-accent transition-colors" id="edit_upload_placeholder">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Click to Upload Image
                        </div>
                        <button type="button" id="edit_remove_image_btn" class="absolute top-1 right-1 bg-red-600 text-white rounded-full p-1 hidden opacity-0 group-hover:opacity-100 transition-opacity" title="Remove Image">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    @error('image_file')
                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-end space-x-4 mt-6">
                    <button type="button" class="bg-noir-muted hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg" onclick="closeModal('editCategoryModal')">
                        Cancel
                    </button>
                    <button type="submit" class="bg-noir-accent hover:bg-noir-accent/90 text-noir-dark font-medium py-2 px-4 rounded-lg">
                        Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // Global function to show alerts (moved here for clarity, assuming it's also in master.blade.php)
    function showAlert(message, type = 'success') {
        const alertDiv = document.getElementById('global-alert');
        const alertMessage = document.getElementById('alert-message');
        const alertIcon = document.getElementById('alert-icon');

        alertMessage.textContent = message;
        alertDiv.classList.remove('bg-green-500', 'bg-red-500');
        alertIcon.innerHTML = ''; // Clear previous icon

        if (type === 'success') {
            alertDiv.classList.add('bg-green-500');
            alertIcon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
        } else if (type === 'error') {
            alertDiv.classList.add('bg-red-500');
            alertIcon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
        }

        alertDiv.classList.remove('hidden', 'translate-x-full');
        alertDiv.classList.add('flex', 'translate-x-0');

        // Automatically hide after 5 seconds
        setTimeout(() => {
            hideAlert();
        }, 5000);
    }

    function hideAlert() {
        const alertDiv = document.getElementById('global-alert');
        alertDiv.classList.remove('translate-x-0');
        alertDiv.classList.add('translate-x-full');
        setTimeout(() => {
            alertDiv.classList.add('hidden');
        }, 300); // Match CSS transition duration
    }

    document.addEventListener('DOMContentLoaded', () => {
        // This page is a dedicated category management page, so ensure its content is visible.
        const categoriesSection = document.getElementById('categories');
        if (categoriesSection) {
            categoriesSection.classList.remove('hidden');
        }
        // Optionally, if you want the sidebar "Categories" button to appear active on this page:
        const categoriesButton = document.querySelector('button[onclick*="showSection(\'categories\')"]');
        if (categoriesButton) {
            const navButtons = document.querySelectorAll('nav ul li button');
            navButtons.forEach(button => {
                button.classList.remove('bg-noir-light', 'text-white');
                button.classList.add('text-noir-muted', 'hover:text-white', 'hover:bg-noir-light');
            });
            categoriesButton.classList.add('bg-noir-light', 'text-white');
            categoriesButton.classList.remove('text-noir-muted', 'hover:text-white', 'hover:bg-noir-light');

            // Update the header title if you have one
            const sectionTitle = document.getElementById('section-title');
            if (sectionTitle) {
                sectionTitle.innerText = categoriesButton.innerText.trim();
            }
        }

        // Check for session messages and display global alert
        @if(session('success'))
            showAlert('{{ session('success') }}', 'success');
        @endif

        @if($errors->any())
            let errorMessage = "Please correct the following errors:";
            @foreach ($errors->all() as $error)
                errorMessage += "\n- {{ $error }}";
            @endforeach
            showAlert(errorMessage, 'error');

            // Reopen the correct modal if there were validation errors
            @if(old('_add_form'))
                openModal('addCategoryModal');
            @elseif(old('_edit_form') && old('edited_category_id'))
                // To reopen edit modal with pre-filled data, you need to re-fetch it or pass it.
                // For now, we'll just open the modal and let the user re-enter.
                // In a real app, you might pass all old input data back to the view.
                const categoryId = {{ old('edited_category_id') }};
                const categoryNameEn = "{{ old('name_en') }}";
                const categoryNameKm = "{{ old('name_km') }}"; // Pass old Khmer name
                const imageUrl = "{{ old('image_url') ? asset('storage/' . old('image_url')) : '' }}";
                openEditModal(categoryId, categoryNameEn, categoryNameKm, imageUrl);
            @endif
        @endif

        // Image upload and preview logic for Add Category Modal
        const addImageUploadArea = document.getElementById('add_image_upload_area');
        const addCategoryImageFile = document.getElementById('add_category_image_file');
        const addImagePreview = document.getElementById('add_image_preview');
        const addUploadPlaceholder = document.getElementById('add_upload_placeholder');
        const addRemoveImageBtn = document.getElementById('add_remove_image_btn');

        if (addImageUploadArea) {
            addImageUploadArea.addEventListener('click', () => {
                addCategoryImageFile.click();
            });

            addCategoryImageFile.addEventListener('change', (event) => {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        addImagePreview.src = e.target.result;
                        addImagePreview.classList.remove('hidden');
                        addUploadPlaceholder.classList.add('hidden');
                        addRemoveImageBtn.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    addImagePreview.src = '';
                    addImagePreview.classList.add('hidden');
                    addUploadPlaceholder.classList.remove('hidden');
                    addRemoveImageBtn.classList.add('hidden');
                }
            });

            addRemoveImageBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                addCategoryImageFile.value = '';
                addImagePreview.src = '';
                addImagePreview.classList.add('hidden');
                addUploadPlaceholder.classList.remove('hidden');
                addRemoveImageBtn.classList.add('hidden');
            });
        }

        // Image upload and preview logic for Edit Category Modal
        const editImageUploadArea = document.getElementById('edit_image_upload_area');
        const editCategoryImageFile = document.getElementById('edit_category_image_file');
        const editImagePreview = document.getElementById('edit_image_preview');
        const editUploadPlaceholder = document.getElementById('edit_upload_placeholder');
        const editRemoveImageBtn = document.getElementById('edit_remove_image_btn');
        const editRemoveImageFlag = document.getElementById('edit_remove_image_flag');

        if (editImageUploadArea) {
            editImageUploadArea.addEventListener('click', () => {
                editCategoryImageFile.click();
            });

            editCategoryImageFile.addEventListener('change', (event) => {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        editImagePreview.src = e.target.result;
                        editImagePreview.classList.remove('hidden');
                        editUploadPlaceholder.classList.add('hidden');
                        editRemoveImageBtn.classList.remove('hidden');
                        editRemoveImageFlag.value = '0'; // A new image is selected, so don't remove
                    };
                    reader.readAsDataURL(file);
                } else {
                    if (editImagePreview.src === '' || editImagePreview.classList.contains('hidden')) {
                        editUploadPlaceholder.classList.remove('hidden');
                        editRemoveImageBtn.classList.add('hidden');
                    }
                }
            });

            editRemoveImageBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                editCategoryImageFile.value = '';
                editImagePreview.src = '';
                editImagePreview.classList.add('hidden');
                editUploadPlaceholder.classList.remove('hidden');
                editRemoveImageBtn.classList.add('hidden');
                editRemoveImageFlag.value = '1'; // Set flag to indicate image removal
            });
        }
    });

    // Function to open the edit modal and populate data
    function openEditModal(categoryId, categoryNameEn, categoryNameKm, imageUrl) { // Added categoryNameKm
        const editCategoryForm = document.getElementById('editCategoryForm');
        const editCategoryNameEnInput = document.getElementById('edit_category_name_en');
        const editCategoryNameKmInput = document.getElementById('edit_category_name_km'); // Get Khmer name input
        const editImagePreview = document.getElementById('edit_image_preview');
        const editUploadPlaceholder = document.getElementById('edit_upload_placeholder');
        const editRemoveImageBtn = document.getElementById('edit_remove_image_btn');
        const editCategoryImageFile = document.getElementById('edit_category_image_file');
        const editRemoveImageFlag = document.getElementById('edit_remove_image_flag');

        // Reset file input and remove image flag
        editCategoryImageFile.value = '';
        editRemoveImageFlag.value = '0';

        // Set the form action to the update route for the specific category
        editCategoryForm.action = `/admin/categories/${categoryId}`;
        editCategoryNameEnInput.value = categoryNameEn;
        editCategoryNameKmInput.value = categoryNameKm; // Set Khmer name value

        // Set image preview
        if (imageUrl) {
            editImagePreview.src = imageUrl;
            editImagePreview.classList.remove('hidden');
            editUploadPlaceholder.classList.add('hidden');
            editRemoveImageBtn.classList.remove('hidden');
        } else {
            editImagePreview.src = '';
            editImagePreview.classList.add('hidden');
            editUploadPlaceholder.classList.remove('hidden');
            editRemoveImageBtn.classList.add('hidden');
        }

        openModal('editCategoryModal');
    }

    // Modal functionality (defined in master.blade.php, but repeated here for clarity if needed)
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        document.getElementById(modalId).classList.add('flex');
        setTimeout(() => {
            document.getElementById(modalId).style.opacity = '1';
        }, 10); // Small delay for transition
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.opacity = '0';
        setTimeout(() => {
            document.getElementById(modalId).classList.add('hidden');
            document.getElementById(modalId).classList.remove('flex');
        }, 300); // Match CSS transition duration
    }
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
</style>
@endpush
