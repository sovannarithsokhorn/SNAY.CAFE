@extends('frontend.layout.master') {{-- Assuming your frontend master layout --}}

@section('title', 'Edit Profile')

@section('content')
{{-- CHANGED: Increased top padding (pt) to move the box down. py-50 is not a standard Tailwind class. --}}
<section class="py-20 md:py-32 bg-noir-dark min-h-screen flex items-center justify-center">
    <div class="container mx-auto px-4 max-w-2xl"> {{-- CHANGED: Reduced horizontal padding on container to px-4 --}}
        <div class="bg-noir-medium rounded-xl shadow-2xl p-6 md:p-8 border border-noir-light relative overflow-hidden"> {{-- CHANGED: Reduced padding on main box to p-6 md:p-8 --}}
            {{-- Decorative top bar --}}
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-transparent via-noir-accent to-transparent"></div>

            {{-- CHANGED: Increased size to text-4xl, changed font-bold to font-normal, increased mb to mb-4 --}}
            <h1 class="text-4xl font-syne font-normal text-white mb-4 text-center">Edit Your Profile</h1>

            <form id="profileEditForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') {{-- Use PUT method for update --}}

                <div class="mb-1 text-center"> {{-- CHANGED: Reduced margin-bottom --}}
                    <label for="profile_picture" class="cursor-pointer inline-block relative group">
                        <img src="{{ $user->profile_picture_url ? asset('storage/' . Auth::user()->profile_picture_url) : 'https://placehold.co/120x120/D4A95C/0F0F0F?text=User' }}"
                             alt="Profile Picture"
                             id="currentProfilePicture"
                             class="w-24 h-24 rounded-full object-cover border-3 border-noir-accent mx-auto transition-all duration-300 group-hover:scale-105 group-hover:shadow-lg"> {{-- CHANGED: Reduced size to w-24 h-24, border to border-3 --}}
                        <div class="absolute inset-0 rounded-full bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <i class="fas fa-camera text-white text-lg"></i> {{-- CHANGED: Reduced camera icon size --}}
                        </div>
                        <p class="text-noir-muted text-xs mt-1">Click to change profile picture</p> {{-- CHANGED: Reduced font size and margin --}}
                    </label>
                    <input type="file" name="profile_picture" id="profile_picture" class="hidden" accept="image/*">
                    @error('profile_picture')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2"> {{-- CHANGED: Reduced gaps --}}
                    <div>
                        <label for="name" class="block text-noir-muted text-sm font-semibold mb-1">Name:</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                               class="w-full h-9 py-1.5 px-2 bg-noir-dark text-white rounded-md border border-noir-light focus:outline-none focus:ring-1 focus:ring-noir-accent text-sm" required> {{-- CHANGED: Reduced height to h-9, padding to py-1.5 px-2, ring to ring-1 --}}
                        @error('name')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="username" class="block text-noir-muted text-sm font-semibold mb-1">Username:</label>
                        <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}"
                               class="w-full h-9 py-1.5 px-2 bg-noir-dark text-white rounded-md border border-noir-light focus:outline-none focus:ring-1 focus:ring-noir-accent text-sm" required>
                        @error('username')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-2"> {{-- CHANGED: Reduced margin-top --}}
                    <label for="email" class="block text-noir-muted text-sm font-semibold mb-1">Email:</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                           class="w-full h-9 py-1.5 px-2 bg-noir-dark text-white rounded-md border border-noir-light focus:outline-none focus:ring-1 focus:ring-noir-accent text-sm" required>
                    @error('email')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2 mt-2"> {{-- CHANGED: Reduced gaps and margin-top --}}
                    <div>
                        <label for="phone_number" class="block text-noir-muted text-sm font-semibold mb-1">Phone Number:</label>
                        <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $user->phone_number) }}"
                               class="w-full h-9 py-1.5 px-2 bg-noir-dark text-white rounded-md border border-noir-light focus:outline-none focus:ring-1 focus:ring-noir-accent text-sm">
                        @error('phone_number')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="date_of_birth" class="block text-noir-muted text-sm font-semibold mb-1">Date of Birth:</label>
                        <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('Y-m-d') : '') }}"
                               class="w-full h-9 py-1.5 px-2 bg-noir-dark text-white rounded-md border border-noir-light focus:outline-none focus:ring-1 focus:ring-noir-accent text-sm">
                        @error('date_of_birth')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end mt-6 space-x-3"> {{-- CHANGED: Reduced margin-top and spacing --}}
                    <a href="{{ route('profile.show') }}" class="text-noir-muted hover:text-white transition-colors duration-300 text-sm py-1.5 px-3 rounded-md">Cancel</a> {{-- CHANGED: Added padding for clickable area, reduced padding --}}
                    <button type="submit" class="bg-noir-accent text-noir-dark font-semibold py-1.5 px-4 rounded-md focus:outline-none focus:shadow-outline hover:bg-opacity-90 transition-all duration-300 text-sm"> {{-- CHANGED: Reduced padding --}}
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const profileEditForm = document.getElementById('profileEditForm');
        const profilePictureInput = document.getElementById('profile_picture');
        const currentProfilePicture = document.getElementById('currentProfilePicture');

        // Live preview for profile picture
        if (profilePictureInput) {
            profilePictureInput.addEventListener('change', function(event) {
                if (event.target.files && event.target.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        currentProfilePicture.src = e.target.result;
                    };
                    reader.readAsDataURL(event.target.files[0]);
                }
            });
        }

        // Handle form submission via AJAX for better UX
        if (profileEditForm) {
            profileEditForm.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                Swal.fire({
                    title: 'Saving Profile...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                const formData = new FormData(this); // Get form data, including file
                const actionUrl = this.action;

                fetch(actionUrl, {
                    method: 'POST', // Fetch will use POST, but Laravel will interpret _method as PUT
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest', // Important for Laravel to recognize AJAX
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        // Handle validation errors or other HTTP errors
                        return response.json().then(errorData => {
                            throw new Error(errorData.message || 'Failed to update profile.');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    Swal.close();
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message,
                            confirmButtonColor: '#D4A95C'
                        }).then(() => {
                            // Update profile picture on the page without full reload if successful
                            if (data.user.profile_picture_url) {
                                const userProfilePicOnShowPage = document.getElementById('userProfilePicture');
                                if (userProfilePicOnShowPage) {
                                    userProfilePicOnShowPage.src = data.user.profile_picture_url;
                                }
                            }
                            window.location.href = "{{ route('profile.show') }}"; // Redirect to profile show page
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message || 'An unknown error occurred.',
                            confirmButtonColor: '#D4A95C'
                        });
                    }
                })
                .catch(error => {
                    Swal.close();
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed to Update!',
                        text: error.message || 'An error occurred while updating your profile.',
                        confirmButtonColor: '#D4A95C'
                    });
                });
            });
        }
    });
</script>
@endpush
@endsection