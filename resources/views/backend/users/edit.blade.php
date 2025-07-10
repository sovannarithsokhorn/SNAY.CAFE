<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - Admin Panel</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome CDN for icons (used for camera, save, cancel icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Syne Font (now the primary font) -->
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- SweetAlert2 CDN (from your provided code) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Lucide Icons CDN (from your provided code, though Font Awesome is mostly used here) -->
    <script src="https://unpkg.com/lucide@latest"></script> 
    <style>
        /* Custom CSS Variables for SNAY.CAFE Theme */
        :root {
            --noir-dark: #1A1A1A;
            --noir-medium: #2A2A2A;
            --noir-light: #3A3A3A;
            --noir-muted: #888888;
            --noir-accent: #D4A95C; /* Your primary accent color (golden/yellowish) */
            /* Header gradient colors now derived from your SNAY.CAFE accent */
            --header-gradient-start: #D4A95C; /* Your accent color */
            --header-gradient-end: #CC9944; /* A slightly darker/richer variant of your accent */
        }

        /* Base Body and Layout */
        body {
            font-family: 'Syne', sans-serif; /* Changed to Syne for all text */
            background-color: var(--noir-dark); /* Dark background for the page */
            
            background-image:linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url('https://images.unsplash.com/photo-1447933601403-0c6688de566e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1956&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 1rem;
            box-sizing: border-box;
            overflow: auto; /* Allow body scroll if content slightly overflows */
        }

        /* Main Form Card Styling (The "Window") */
        .form-card {
            background-color: var(--noir-medium); /* Darker background for the form card */
            border-radius: 1.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3); /* Stronger shadow for "window" effect */
            max-width: 800px; /* Adjusted max-width for the two-panel layout */
            animation: fadeIn 0.3s ease-out;
            max-height: 95vh; /* Max height to ensure it fits within viewport */
            overflow: hidden; /* Hide overflow on the main card, inner content will scroll if needed */
            display: flex; /* Use flexbox for header and content stacking */
            flex-direction: column;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Header Gradient (Top bar of the "Window") */
        .header-gradient {
            background: linear-gradient(135deg, var(--header-gradient-start) 0%, var(--header-gradient-end) 100%);
            padding: 1.5rem 2rem; /* Generous padding for the header */
            border-radius: 1.25rem 1.25rem 0 0;
            color: var(--noir-dark); /* Dark text on accent background */
            font-family: 'Syne', sans-serif; /* Syne for header title */
            font-weight: 800;
            font-size: 1.5rem; /* Larger header title */
            text-align: center;
        }

        /* Input Field Styling */
        .input-field {
            border: 1px solid var(--noir-light); /* Lighter border for inputs */
            background-color: var(--noir-dark); /* Dark input background */
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            color: #ffffff; /* White text in inputs */
            transition: all 0.2s ease-in-out;
            width: 100%;
            font-family: 'Syne', sans-serif; /* Ensure Syne is applied to inputs */
        }

        .input-field::placeholder {
            color: var(--noir-muted); /* Muted placeholder text */
        }

        .input-field:focus {
            outline: none;
            border-color: var(--noir-accent); /* Accent border on focus */
            box-shadow: 0 0 0 3px rgba(212, 169, 92, 0.2); /* Soft focus ring with accent color */
        }

        /* Error Message Styling */
        .error-message {
            color: #EF4444; /* Standard red for errors */
            font-size: 0.75rem;
            margin-top: 0.3rem;
            font-family: 'Syne', sans-serif; /* Ensure Syne is applied to error messages */
        }

        /* Label Text Styling */
        .label-text {
            color: var(--noir-muted); /* Muted gray for labels */
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 0.3rem;
            font-family: 'Syne', sans-serif; /* Ensure Syne is applied to labels */
        }

        /* Date input specific styles for placeholder color */
        input[type="date"]::-webkit-datetime-edit-text,
        input[type="date"]::-webkit-datetime-edit-month-field,
        input[type="date"]::-webkit-datetime-edit-day-field,
        input[type="date"]::-webkit-datetime-edit-year-field {
            color: var(--noir-muted); /* Placeholder color for date fields */
        }

        input[type="date"].has-value::-webkit-datetime-edit-text,
        input[type="date"].has-value::-webkit-datetime-edit-month-field,
        input[type="date"].has-value::-webkit-datetime-edit-day-field,
        input[type="date"].has-value::-webkit-datetime-edit-year-field {
            color: #ffffff; /* Actual value color for date fields */
        }

        /* Button styles */
        .action-button {
            padding: 0.75rem 1.5rem; /* Adjusted button padding */
            border-radius: 0.75rem; /* More rounded buttons */
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem; /* Gap for icons */
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2); /* Subtle shadow */
            transition: all 0.2s ease-in-out;
            cursor: pointer;
            font-size: 0.9rem;
            white-space: nowrap;
            font-family: 'Syne', sans-serif; /* Ensure Syne is applied to buttons */
        }

        .cancel-button {
            background-color: var(--noir-light); /* Darker background for cancel */
            color: #ffffff; /* White text */
        }

        .cancel-button:hover {
            background-color: var(--noir-muted); /* Slightly lighter on hover */
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.25);
        }

        .update-staff-button {
            background-image: linear-gradient(to right, var(--header-gradient-start), var(--header-gradient-end)); /* Accent gradient */
            color: var(--noir-dark); /* Dark text on accent gradient */
            box-shadow: 0 3px 10px rgba(212, 169, 92, 0.4); /* Shadow reflecting accent */
        }

        .update-staff-button:hover {
            background-image: linear-gradient(to right, #C29A4E, #B8893D); /* Slightly darker accent on hover */
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(212, 169, 92, 0.5);
        }

        /* Responsive grid for input fields */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr; /* Default single column for mobile */
            gap: 1.25rem; /* Gap between rows/columns */
        }

        @media (min-width: 768px) { /* Medium screens and up (desktop two-panel) */
            .form-grid {
                grid-template-columns: repeat(2, 1fr); /* Two columns for desktop */
                gap: 2.5rem; /* Larger gap between the two main panels */
            }
            /* Adjusted border and padding for the new left panel (which is now the user details panel) */
            .form-grid > div:first-child { /* This is now the User Details panel */
                border-right: 1px solid var(--noir-light); /* Separator line */
                padding-right: 2.5rem; /* Padding for separator */
            }
            .form-grid > div:last-child { /* This is now the Role/Password panel */
                padding-left: 0; /* No left padding needed as gap handles it */
            }

            /* Adjust inner grids for fields within panels */
            .form-grid .inner-grid {
                grid-template-columns: repeat(2, 1fr); /* Two columns for fields within panels */
                gap: 1.25rem; /* Consistent gap for inner fields */
            }
            .form-grid .inner-grid .full-span {
                grid-column: span 2; /* Email field spans full width of its panel */
            }
            .form-grid .password-grid {
                grid-template-columns: 1fr; /* Password fields stack vertically within right panel */
            }
        }

        /* Profile Photo Styling */
        .photo-upload-container {
            display: flex;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .profile-photo-wrapper {
            position: relative;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: var(--noir-dark); /* Dark background for N/A */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            border: 2px solid var(--noir-accent); /* Accent border for profile pic */
        }

        .profile-photo-wrapper:hover {
            box-shadow: 0 6px 15px rgba(0,0,0,0.3);
            transform: translateY(-2px);
        }

        .profile-image-preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            display: none; /* Hidden by default, managed by JS */
        }

        .no-photo-text {
            color: var(--noir-muted); /* Muted color for N/A text */
            font-size: 2.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif; /* Ensure Syne is applied to N/A text */
        }
    </style>
</head>
<body class="bg-noir-dark font-syne antialiased"> {{-- Changed font-sans to font-syne here --}}

<div id="staff-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="bg-noir-medium rounded-xl shadow-lg w-full relative z-10 form-card">
        {{-- Header Bar (Now uses SNAY.CAFE accent color gradient) --}}
        <div class="header-gradient">
            <h2 class="text-white font-bold">Edit User</h2> {{-- Title from your screenshot --}}
        </div>

        {{-- Form Content --}}
        <form id="staff-form" action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="flex-grow p-8 md:p-10">
            @csrf
            @method('PUT')

            <div class="form-grid">
                {{-- Left Panel: Profile Picture & User Details --}}
                <div>
                    <!-- Profile Photo Upload Section -->
                    <div class="photo-upload-container">
                        <label for="profilePhotoInput" class="profile-photo-wrapper">
                            <img id="profileImagePreview"
                                 src="{{ $user->profile_picture_url ? asset('storage/' . $user->profile_picture_url) : '' }}"
                                 alt="Profile Photo"
                                 class="profile-image-preview">
                            <span id="noPhotoText" class="no-photo-text">N/A</span>
                            <input type="file" id="profilePhotoInput" name="profile_picture" accept="image/*" class="hidden">
                        </label>
                    </div>

                    <h1 class="text-xl font-syne font-extrabold text-white mb-5 text-center tracking-wide"><span class="text-noir-accent" style="color: #D4A95C;">{{ $user->name }}</span></h1>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-3 inner-grid">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block label-text">Name</label>
                            <input type="text" id="name" name="name"
                                   value="{{ old('name', $user->name) }}"
                                   class="input-field"
                                   placeholder="Enter full name" required>
                            @error('name')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Username -->
                        <div>
                            <label for="username" class="block label-text">Username</label>
                            <input type="text" id="username" name="username"
                                   value="{{ old('username', $user->username) }}"
                                   class="input-field"
                                   placeholder="Enter username" required>
                            @error('username')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Email -->
                        <div class="md:col-span-2 full-span">
                            <label for="email" class="block label-text">Email</label>
                            <input type="email" id="email" name="email"
                                   value="{{ old('email', $user->email) }}"
                                   class="input-field"
                                   placeholder="Enter email address" required>
                            @error('email')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Phone Number -->
                        <div>
                            <label for="phone-number" class="block label-text">Phone Number</label>
                            <input type="text" id="phone-number" name="phone_number"
                                   value="{{ old('phone_number', $user->phone_number) }}"
                                   class="input-field"
                                   placeholder="Enter phone number">
                            @error('phone_number')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Date of Birth -->
                        <div>
                            <label for="date-of-birth" class="block label-text">Date of Birth</label>
                            <input type="date" id="date-of-birth" name="date_of_birth"
                                   value="{{ old('date_of_birth', $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('Y-m-d') : '') }}"
                                   class="input-field">
                            @error('date_of_birth')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Right Panel: Role & Password Change, Buttons --}}
                <div>
                    <div class="space-y-5">
                        <!-- Role -->
                        <div>
                            <label for="role" class="block label-text">Role</label>
                            <select id="role" name="role"
                                    class="input-field" required>
                                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Password Change Section -->
                    <div class="border-t border-noir-light pt-6 mt-6">
                        <h3 class="text-xl font-syne font-bold text-white mb-4">Change Password (Optional)</h3>
                        <div class="grid grid-cols-1 gap-y-5 password-grid">
                            <div>
                                <label for="password" class="block label-text">New Password</label>
                                <input type="password" id="password" name="password"
                                       class="input-field"
                                       placeholder="Enter new password">
                                @error('password')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="block label-text">Confirm New Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                       class="input-field"
                                       placeholder="Confirm new password">
                                @error('password_confirmation')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons - Directly after Confirm New Password, centered -->
                    <div class="flex flex-col sm:flex-row items-center justify-center mt-8 space-y-4 sm:space-y-0 sm:space-x-4">
                        {{-- Update Staff button --}}
                        <button type="submit" id="update-staff-btn"
                                class="action-button update-staff-button">
                            <i class="fas fa-save"></i>
                            Update Staff
                        </button>
                        {{-- Cancel button --}}
                        <button type="button" id="cancel-btn"
                                class="action-button cancel-button mr-2">
                            <i class="fas fa-times-circle"></i>
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // --- Profile Photo Preview Logic ---
        const profilePhotoInput = document.getElementById('profilePhotoInput');
        const profileImagePreview = document.getElementById('profileImagePreview');
        const noPhotoText = document.getElementById('noPhotoText');

        function updatePhotoDisplay() {
            // Check if profileImagePreview has a valid src and has loaded successfully
            // naturalWidth/Height will be > 0 if image loaded, 0 if it failed or is empty
            if (profileImagePreview.src && profileImagePreview.naturalWidth > 0 && profileImagePreview.naturalHeight > 0) {
                profileImagePreview.style.display = 'block';
                noPhotoText.style.display = 'none';
            } else {
                profileImagePreview.style.display = 'none';
                noPhotoText.style.display = 'flex'; // Ensure N/A text is centered
            }
        }

        // Attach load and error listeners to the image for dynamic updates
        profileImagePreview.addEventListener('load', updatePhotoDisplay);
        profileImagePreview.addEventListener('error', updatePhotoDisplay);

        // Handle file input change for live preview
        profilePhotoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    profileImagePreview.src = event.target.result;
                    // updatePhotoDisplay will be called by the 'load' event on profileImagePreview
                };
                reader.readAsDataURL(file);
            } else {
                // If no file selected (e.g., user cancels dialog), revert to current stored image or N/A
                const currentStoredUrl = profileImagePreview.getAttribute('src');
                profileImagePreview.src = currentStoredUrl; // Re-trigger load/error for current src
                if (!currentStoredUrl) { // If no current stored URL, force N/A display
                    updatePhotoDisplay();
                }
            }
        });

        // Initial call to set photo display based on current photo status on page load
        // Use a small timeout to allow the browser to attempt loading the initial src.
        setTimeout(updatePhotoDisplay, 50);

        // --- Date Input Class for Styling ---
        const dobInput = document.getElementById('date-of-birth');

        function updateDateClass(inputElement) {
            if (inputElement.value) {
                inputElement.classList.add('has-value');
            } else {
                inputElement.classList.remove('has-value');
            }
        }

        updateDateClass(dobInput);
        dobInput.addEventListener('change', () => updateDateClass(dobInput));


        // --- Cancel Button Logic ---
        document.getElementById('cancel-btn').addEventListener('click', function () {
            window.location.href = '{{ route('admin.users.index') }}'; // Use Laravel route helper
        });

        // --- Form Submission (Laravel handles validation, so no custom JS validation needed here) ---
        // The form will submit normally, and Laravel's backend validation will handle errors.
        // Success/error messages will be flashed to the session and displayed by Blade.
    });
</script>

</body>
</html>
