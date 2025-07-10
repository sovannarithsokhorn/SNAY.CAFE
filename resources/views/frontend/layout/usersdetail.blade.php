@extends('frontend.layout.master')

@section('title', 'User Profile - Order History')

@section('content')
<style>
        .bg-noir-dark {
            --tw-bg-opacity 1: 1;
            background-color: rgb(15 15 15 / var(--tw-bg-opacity, 1));
            background-image:linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url('https://images.unsplash.com/photo-1447933601403-0c6688de566e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1956&q=80');
        }
    </style>
<section class="py-12 md:py-24 bg-noir-dark min-h-screen flex items-center justify-center">
    <div class="container mx-auto px-6 max-w-5xl">
        <div class="bg-noir-medium rounded-lg shadow-xl p-8 md:p-12 border border-noir-light relative overflow-hidden" style="width: 105%;">
            {{-- Decorative top bar --}}
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-transparent via-noir-accent to-transparent"></div>

            <div class="flex flex-col md:flex-row items-center md:items-start space-y-8 md:space-y-0 md:space-x-12">
                {{-- User Profile Card --}}
                <div class="w-full md:w-1/3 flex flex-col items-center text-center bg-noir-light p-8 rounded-lg shadow-md border border-noir-medium">
                    {{-- Profile Picture with Click-to-View --}}
                    <img src="{{ Auth::user()->profile_picture_url ? asset('storage/' . Auth::user()->profile_picture_url) : 'https://placehold.co/150x150/D4A95C/0F0F0F?text=User' }}"
                         alt="User Profile"
                         id="userProfilePicture"
                         data-full-src="{{ Auth::user()->profile_picture_url ? asset('storage/' . Auth::user()->profile_picture_url) : 'https://placehold.co/500x500/D4A95C/0F0F0F?text=User' }}"
                         class="w-32 h-32 rounded-full object-cover border-4 border-noir-accent mb-6 shadow-lg cursor-pointer hover:scale-105 transition-transform duration-300"
                         onerror="this.onerror=null;this.src='https://placehold.co/150x150/D4A95C/0F0F0F?text=User'; this.dataset.fullSrc='https://placehold.co/500x500/D4A95C/0F0F0F?text=User';">
                    <h2 class="text-3xl font-normal text-white font-syne mb-2">{{ $user->name ?? 'Guest User' }}</h2>
                    <p class="text-noir-muted text-lg mb-4">{{ $user->email ?? 'guest@example.com' }}</p>
                    <p class="text-noir-muted text-sm mb-6">
                        <span class="font-semibold text-noir-accent">Role:</span> {{ $user->role ?? 'Customer' }}
                    </p>
                    @if($user->phone_number)
                        <p class="text-noir-muted text-sm mb-2">
                            <span class="font-semibold text-noir-accent">Phone:</span> {{ $user->phone_number }}
                        </p>
                    @endif
                    @if($user->date_of_birth)
                        <p class="text-noir-muted text-sm mb-6">
                            <span class="font-semibold text-noir-accent">DOB:</span> {{ \Carbon\Carbon::parse($user->date_of_birth)->format('M d, Y') }}
                        </p>
                    @endif

                    <div class="w-full space-y-4">
                        <button type="button" id="editProfileBtn" class="w-full btn ripple bg-noir-accent text-noir-dark px-6 py-3 rounded-md font-medium text-lg transition-all duration-300 hover:bg-opacity-90">
                            Edit Profile
                        </button>
                        <a href="{{ url('/') }}" class="w-full btn animated-border border-2 border-white text-white px-6 py-3 rounded-md font-medium text-lg transition-all duration-300 hover:border-noir-accent hover:text-noir-accent">
                            Back to Home
                        </a>
                    </div>
                </div>

                {{-- Order History Section --}}
                <div class="w-full md:w-2/3" >
                    <h3 class="text-3xl font-normal text-white font-syne mb-8 pb-4 border-b border-noir-light"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Order History</h3>

                    @if($user->orders->isEmpty())
                        <div class="bg-noir-light p-6 rounded-lg text-center text-noir-muted">
                            <p class="text-lg">You haven't placed any orders yet.</p>
                            <a href="{{ url('/products') }}" class="mt-4 inline-block text-noir-accent hover:underline">Start Shopping!</a>
                        </div>
                    @else
                        <div class="overflow-x-auto bg-noir-light rounded-lg shadow-md border border-noir-medium" style="width: 105%;">
                            <table class="min-w-full divide-y divide-noir-muted">
                                <thead class="bg-noir-medium">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">Order ID</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">Total</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-noir-muted uppercase tracking-wider">Actions</th>
                                    </tr>   
                                </thead>
                                <tbody class="divide-y divide-noir-muted">
                                    @foreach($user->orders as $order)
                                        <tr class="hover:bg-noir-dark transition-colors duration-200">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-normal text-white">#{{ $order->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-noir-muted">{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-noir-accent">${{ number_format($order->total_amount, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <span class="px-2 inline-flex text-xs leading-5 font-normal rounded-full
                                                    @if($order->status == 'completed') bg-green-100 text-green-800
                                                    @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800
                                                    @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                {{-- Changed data-order to data-order-id --}}
                                                <button type="button"
                                                        class="text-noir-accent hover:text-white transition-colors view-order-details-btn"
                                                        data-order-id="{{ $order->id }}">
                                                    View Details
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Edit Profile Modal --}}
<div id="editProfileModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-[1000] hidden opacity-0 transition-opacity duration-300">
    <div class="bg-noir-medium rounded-lg shadow-xl relative w-11/12 max-w-2xl p-8 md:p-10 border border-noir-light transform scale-95 transition-transform duration-300">
        <button type="button" id="closeModalBtn" class="absolute top-4 right-4 text-white text-2xl z-20 hover:text-noir-accent transition-colors">
            <i class="fas fa-times"></i>
        </button>

        <h3 class="text-3xl font-normal text-white font-syne mb-8 pb-4 border-b border-noir-light">Edit Profile</h3>

        {{-- IMPORTANT: enctype="multipart/form-data" is required for file uploads --}}
        <form id="editProfileForm" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- Use PUT method for updates --}}

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                {{-- Profile Picture Input --}}
                <div class="md:col-span-2 flex flex-col items-center mb-6">
                    <img src="{{ Auth::user()->profile_picture_url ? asset('storage/' . Auth::user()->profile_picture_url) : 'https://placehold.co/150x150/D4A95C/0F0F0F?text=User' }}"
                         alt="Current Profile Picture"
                         id="profilePicturePreview"
                         class="w-24 h-24 rounded-full object-cover border-2 border-noir-accent mb-4">
                    <label for="profile_picture" class="block text-noir-muted text-sm font-normal mb-2 cursor-pointer bg-noir-light px-4 py-2 rounded-md hover:bg-noir-dark transition-colors">
                        Change Profile Picture
                    </label>
                    <input type="file" id="profile_picture" name="profile_picture" accept="image/*" class="hidden">
                </div>

                <div>
                    <label for="edit_name" class="block text-noir-muted text-sm font-normal mb-2">Name</label>
                    <input type="text" id="edit_name" name="name" value="{{ $user->name }}" class="w-full p-3 rounded-md bg-noir-dark border border-noir-muted text-white focus:outline-none focus:border-noir-accent">
                </div>
                <div>
                    <label for="edit_username" class="block text-noir-muted text-sm font-normal mb-2">Username</label>
                    <input type="text" id="edit_username" name="username" value="{{ $user->username }}" class="w-full p-3 rounded-md bg-noir-dark border border-noir-muted text-white focus:outline-none focus:border-noir-accent">
                </div>
                <div>
                    <label for="edit_email" class="block text-noir-muted text-sm font-normal mb-2">Email</label>
                    <input type="email" id="edit_email" name="email" value="{{ $user->email }}" class="w-full p-3 rounded-md bg-noir-dark border border-noir-muted text-white focus:outline-none focus:border-noir-accent">
                </div>
                <div>
                    <label for="edit_phone_number" class="block text-noir-muted text-sm font-normal mb-2">Phone Number</label>
                    <input type="text" id="edit_phone_number" name="phone_number" value="{{ $user->phone_number }}" class="w-full p-3 rounded-md bg-noir-dark border border-noir-muted text-white focus:outline-none focus:border-noir-accent">
                </div>
                <div class="md:col-span-2">
                    <label for="edit_date_of_birth" class="block text-noir-muted text-sm font-normal mb-2">Date of Birth</label>
                    <input type="date" id="edit_date_of_birth" name="date_of_birth" value="{{ $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('Y-m-d') : '' }}" class="w-full p-3 rounded-md bg-noir-dark border border-noir-muted text-white focus:outline-none focus:border-noir-accent">
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <button type="button" id="cancelEditBtn" class="btn animated-border border-2 border-white text-white px-8 py-3 rounded-md font-medium text-lg hover:border-noir-accent hover:text-noir-accent">
                    Cancel
                </button>
                <button type="submit" id="saveProfileBtn" class="btn ripple bg-noir-accent text-noir-dark px-8 py-3 rounded-md font-medium text-lg transition-all duration-300 hover:bg-opacity-90">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Full Image View Modal --}}
<div id="fullImageModal" class="fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center z-[1100] hidden opacity-0 transition-opacity duration-300">
    <div class="relative max-w-full max-h-full">
        <button type="button" id="closeFullImageModalBtn" class="absolute -top-10 right-0 text-white text-3xl z-20 hover:text-noir-accent transition-colors">
            <i class="fas fa-times"></i>
        </button>
        <img src="" alt="Full Profile Picture" id="fullProfilePicture" class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-lg">
    </div>
</div>

{{-- NEW: Order Details Modal --}}
<div id="orderDetailModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-[1050] hidden opacity-0 transition-opacity duration-300">
    <div class="bg-noir-medium rounded-lg shadow-xl relative w-11/12 max-w-2xl p-8 md:p-10 border border-noir-light transform scale-95 transition-transform duration-300">
        <button type="button" id="closeOrderDetailModalBtn" class="absolute top-4 right-4 text-white text-2xl z-20 hover:text-noir-accent transition-colors">
            <i class="fas fa-times"></i>
        </button>

        <h3 class="text-3xl font-normal text-white font-syne mb-8 pb-4 border-b border-noir-light">Order Details <span id="modalOrderId" class="text-noir-accent"></span></h3>

        <div id="orderItemsContainer" class="space-y-4 max-h-96 overflow-y-auto pr-2">
            {{-- Order items will be dynamically loaded here --}}
        </div>

        <div class="text-right text-white text-xl font-normal font-syne mt-6 pt-4 border-t border-noir-light">
            Total: <span id="modalOrderTotal" class="text-noir-accent font-medium"></span>
        </div>

        <div class="text-right text-white text-sm font-normal font-syne mt-2">
            Status: <span id="modalOrderStatus" class="font-medium"></span>
        </div>
    </div>
</div>


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM Content Loaded for usersdetail.blade.php');

        const userProfilePicture = document.getElementById('userProfilePicture');
        const editProfileBtn = document.getElementById('editProfileBtn');
        const editProfileModal = document.getElementById('editProfileModal');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const cancelEditBtn = document.getElementById('cancelEditBtn');
        const editProfileForm = document.getElementById('editProfileForm');
        const saveProfileBtn = document.getElementById('saveProfileBtn');

        const profilePictureInput = document.getElementById('profile_picture');
        const profilePicturePreview = document.getElementById('profilePicturePreview');

        const fullImageModal = document.getElementById('fullImageModal');
        const fullProfilePicture = document.getElementById('fullProfilePicture');
        const closeFullImageModalBtn = document.getElementById('closeFullImageModalBtn');

        // NEW: Order Details Modal elements
        const orderDetailModal = document.getElementById('orderDetailModal');
        const closeOrderDetailModalBtn = document.getElementById('closeOrderDetailModalBtn');
        const modalOrderId = document.getElementById('modalOrderId');
        const orderItemsContainer = document.getElementById('orderItemsContainer');
        const modalOrderTotal = document.getElementById('modalOrderTotal');
        const modalOrderStatus = document.getElementById('modalOrderStatus');


        // Function to open the edit profile modal
        function openEditProfileModal() {
            console.log('Opening edit profile modal...');
            editProfileModal.classList.remove('hidden');
            editProfileModal.classList.add('flex');
            setTimeout(() => {
                editProfileModal.classList.remove('opacity-0');
                editProfileModal.querySelector('div').classList.remove('scale-95');
                editProfileModal.querySelector('div').classList.add('scale-100');
            }, 10); // Small delay for transition
        }

        // Function to close the edit profile modal
        function closeEditProfileModal() {
            console.log('Closing edit profile modal...');
            editProfileModal.classList.add('opacity-0');
            editProfileModal.querySelector('div').classList.remove('scale-100');
            editProfileModal.querySelector('div').classList.add('scale-95');
            setTimeout(() => {
                editProfileModal.classList.remove('flex');
                editProfileModal.classList.add('hidden');
            }, 300); // Match CSS transition duration
        }

        // Function to open the full image modal
        function openFullImageModal(imageUrl) {
            console.log('Opening full image modal with URL:', imageUrl);
            fullProfilePicture.src = imageUrl;
            fullImageModal.classList.remove('hidden');
            fullImageModal.classList.add('flex');
            setTimeout(() => {
                fullImageModal.classList.remove('opacity-0');
            }, 10);
        }

        // Function to close the full image modal
        function closeFullImageModal() {
            console.log('Closing full image modal...');
            fullImageModal.classList.add('opacity-0');
            setTimeout(() => {
                fullImageModal.classList.remove('flex');
                fullImageModal.classList.add('hidden');
                fullProfilePicture.src = ''; // Clear image src
            }, 300);
        }

        // NEW: Function to open Order Details Modal
        function openOrderDetailModal(order) {
            console.log('Opening order detail modal for order:', order.id);
            modalOrderId.textContent = '#' + order.id;
            modalOrderTotal.textContent = '$' + order.total_amount.toFixed(2);
            modalOrderStatus.textContent = order.status.charAt(0).toUpperCase() + order.status.slice(1);

            orderItemsContainer.innerHTML = ''; // Clear previous items

            if (order.items && order.items.length > 0) {
                order.items.forEach(item => {
                    const itemHtml = `
                        <div class="flex items-center space-x-4 bg-noir-dark p-3 rounded-md border border-noir-light">
                            <img src="${item.image ? '{{ asset('storage') }}/' + item.image : 'https://placehold.co/100x100/D4A95C/0F0F0F?text=Product'}"
                                 alt="${item.name}"
                                 class="w-16 h-16 object-cover rounded-md border border-noir-medium"
                                 onerror="this.onerror=null;this.src='https://placehold.co/100x100/D4A95C/0F0F0F?text=Product';">
                            <div class="flex-1">
                                <p class="text-white text-lg font-normal">${item.name}</p>
                                <p class="text-noir-muted text-sm font-normal">$${item.price.toFixed(2)} x ${item.quantity}</p>
                            </div>
                            <span class="text-noir-accent text-lg font-normal">$${(item.price * item.quantity).toFixed(2)}</span>
                        </div>
                    `;
                    orderItemsContainer.insertAdjacentHTML('beforeend', itemHtml);
                });
            } else {
                orderItemsContainer.innerHTML = '<p class="text-noir-muted text-center p-4">No items found for this order.</p>';
            }

            orderDetailModal.classList.remove('hidden');
            orderDetailModal.classList.add('flex');
            setTimeout(() => {
                orderDetailModal.classList.remove('opacity-0');
                orderDetailModal.querySelector('div').classList.remove('scale-95');
                orderDetailModal.querySelector('div').classList.add('scale-100');
            }, 10);
        }

        // NEW: Function to close Order Details Modal
        function closeOrderDetailModal() {
            console.log('Closing order detail modal...');
            orderDetailModal.classList.add('opacity-0');
            orderDetailModal.querySelector('div').classList.remove('scale-100');
            orderDetailModal.querySelector('div').classList.add('scale-95');
            setTimeout(() => {
                orderDetailModal.classList.remove('flex');
                orderDetailModal.classList.add('hidden');
                orderItemsContainer.innerHTML = ''; // Clear items on close
            }, 300);
        }

        // Event listeners for opening and closing the edit profile modal
        if (editProfileBtn) {
            editProfileBtn.addEventListener('click', openEditProfileModal);
            console.log('Edit Profile button listener attached.');
        } else {
            console.error('Error: Edit Profile button not found!');
        }

        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', closeEditProfileModal);
            console.log('Close modal button listener attached.');
        } else {
            console.error('Error: Close modal button not found!');
        }

        if (cancelEditBtn) {
            cancelEditBtn.addEventListener('click', closeEditProfileModal);
            console.log('Cancel button listener attached.');
        } else {
            console.error('Error: Cancel button not found!');
        }

        // Close edit profile modal when clicking outside (on the overlay)
        if (editProfileModal) {
            editProfileModal.addEventListener('click', function(event) {
                if (event.target === editProfileModal) {
                    closeEditProfileModal();
                    console.log('Edit modal overlay clicked, closing modal.');
                }
            });
            console.log('Edit Profile modal overlay listener attached.');
        } else {
            console.error('Error: Edit Profile Modal not found!');
        }

        // Event listener for opening full image modal
        if (userProfilePicture) {
            userProfilePicture.addEventListener('click', function() {
                const fullSrc = this.dataset.fullSrc;
                if (fullSrc) {
                    openFullImageModal(fullSrc);
                } else {
                    console.warn('No full image source found for profile picture.');
                }
            });
            console.log('User Profile Picture click listener attached.');
        } else {
            console.error('Error: User Profile Picture not found!');
        }

        // Event listener for closing full image modal
        if (closeFullImageModalBtn) {
            closeFullImageModalBtn.addEventListener('click', closeFullImageModal);
            console.log('Close Full Image modal button listener attached.');
        } else {
            console.error('Error: Close Full Image modal button not found!');
        }

        // Close full image modal when clicking outside (on the overlay)
        if (fullImageModal) {
            fullImageModal.addEventListener('click', function(event) {
                if (event.target === fullImageModal) {
                    closeFullImageModal();
                }
            });
            console.log('Full Image modal overlay listener attached.');
        } else {
            console.error('Error: Full Image Modal not found!');
        }

        // Handle profile picture input change for preview
        if (profilePictureInput) {
            profilePictureInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        profilePicturePreview.src = e.target.result;
                    };
                    reader.readAsDataURL(this.files[0]);
                    console.log('New profile picture selected for preview.');
                }
            });
            console.log('Profile Picture input change listener attached.');
        } else {
            console.error('Error: Profile Picture input not found!');
        }

        // Handle form submission via AJAX
        if (editProfileForm) {
            editProfileForm.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent default form submission
                console.log('Profile form submitted via AJAX.');

                // Disable the submit button to prevent multiple submissions
                saveProfileBtn.disabled = true;
                saveProfileBtn.textContent = 'Saving...'; // Provide feedback

                const formData = new FormData(this); // Get form data

                // --- DEBUGGING: Log FormData contents ---
                console.log('FormData contents before fetch:');
                for (let pair of formData.entries()) {
                    console.log(pair[0]+ ': ' + pair[1]);
                }
                // --- END DEBUGGING ---

                fetch(this.action, {
                    method: 'POST', // This is correct; Laravel uses _method
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest', // Indicate AJAX request
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF token
                    }
                })
                .then(response => {
                    // Re-enable button regardless of success/failure
                    saveProfileBtn.disabled = false;
                    saveProfileBtn.textContent = 'Save Changes';

                    // Check if the response is a redirect (e.g., for validation errors or unauthenticated)
                    if (response.redirected) {
                        console.warn('Redirect detected, following to:', response.url);
                        window.location.href = response.url; // Follow the redirect
                        return Promise.reject('Redirected'); // Stop further processing
                    }
                    // Check for non-OK HTTP status codes (e.g., 405 Method Not Allowed)
                    if (!response.ok) {
                        return response.json().then(errorData => {
                            console.error('HTTP Error Response:', errorData);
                            return Promise.reject(errorData); // Reject with the error data
                        }).catch(() => {
                            // If response is not JSON, just reject with status text
                            return Promise.reject(response.statusText);
                        });
                    }
                    return response.json(); // Parse JSON response
                })
                .then(data => {
                    console.log('Server response:', data);
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Profile Updated!',
                            text: data.message,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                        closeEditProfileModal();
                        // Reload page to show updated data after SweetAlert disappears
                        setTimeout(() => {
                            window.location.reload();
                        }, 3000);
                    } else {
                        // Handle validation errors or other server-side errors
                        let errorMessage = 'An unknown error occurred.';
                        if (data.errors) {
                            errorMessage = Object.values(data.errors).flat().join('\n');
                        } else if (data.message) {
                            errorMessage = data.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Update Failed!',
                            text: errorMessage,
                            confirmButtonColor: '#D4A95C' // Use your accent color for the button
                        });
                    }
                })
                .catch(error => {
                    // Re-enable button on fetch error as well
                    saveProfileBtn.disabled = false;
                    saveProfileBtn.textContent = 'Save Changes';

                    console.error('Fetch Error:', error);
                    if (error !== 'Redirected') { // Don't show error if it was just a redirect
                        let displayMessage = 'Could not connect to the server or an unexpected error occurred.';
                        if (typeof error === 'object' && error.message) {
                            displayMessage = error.message; // Use message from errorData if available
                        } else if (typeof error === 'string') {
                            displayMessage = error; // Use status text if available
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Network Error!',
                            text: displayMessage,
                            confirmButtonColor: '#D4A95C'
                        });
                    }
                });
            });
            console.log('Edit Profile form listener attached.');
        } else {
            console.error('Error: Edit Profile Form not found!');
        }

        // NEW: Event listeners for "View Details" buttons
        document.querySelectorAll('.view-order-details-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Get the order ID from the data-order-id attribute
                const orderId = this.dataset.orderId;

                // Show loading spinner
                Swal.fire({
                    title: 'Loading Order Details...',
                    text: 'Please wait.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Make an AJAX request to fetch order details
                fetch(`/profile/orders/${orderId}`, { // Use a dedicated route for fetching order details
                    method: 'GET', // Or POST if you prefer, but GET is common for fetching data
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    Swal.close(); // Close loading spinner
                    if (!response.ok) {
                        return response.json().then(err => Promise.reject(err));
                    }
                    return response.json();
                })
                .then(orderData => {
                    if (orderData) {
                        openOrderDetailModal(orderData); // Open modal with fetched data
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Order Not Found!',
                            text: 'Could not retrieve order details.',
                            confirmButtonColor: '#D4A95C'
                        });
                    }
                })
                .catch(error => {
                    Swal.close(); // Ensure loading spinner is closed on error
                    console.error('Error fetching order details:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed to Load Order!',
                        text: error.message || 'An error occurred while fetching order details.',
                        confirmButtonColor: '#D4A95C'
                    });
                });
            });
        });

        // NEW: Event listener for closing Order Details Modal
        if (closeOrderDetailModalBtn) {
            closeOrderDetailModalBtn.addEventListener('click', closeOrderDetailModal);
        }
        if (orderDetailModal) {
            orderDetailModal.addEventListener('click', function(event) {
                if (event.target === orderDetailModal) {
                    closeOrderDetailModal();
                }
            });
        }
    });
</script>
@endpush
@endsection