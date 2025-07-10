<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details - {{ $user->name }}</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Syne Font (for all text) -->
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Custom CSS Variables for SNAY.CAFE Theme */
        :root {
            --noir-dark: #1A1A1A;
            --noir-medium: #2A2A2A;
            --noir-light: #3A3A3A;
            --noir-muted: #888888;
            --noir-accent: #D4A95C; /* Your primary accent color (golden/yellowish) */
            --header-gradient-start: #D4A95C; /* Your accent color */
            --header-gradient-end: #CC9944; /* A slightly darker/richer variant of your accent */
        }

        /* Base Body and Layout */
        body {
            font-family: 'Syne', sans-serif; /* All text in Syne */
            background-color: var(--noir-dark); /* Fallback background color */
            background-image: url('http://127.0.0.1:8000/storage/img/bg.jpg'); /* Placeholder coffee image */
            background-size: cover;
            background-position: center;
            background-attachment: fixed; /* Keeps background fixed on scroll */
            
            /* Align content to the top-left */
            display: flex;
            align-items: flex-start; /* Align to top */
            justify-content: flex-start; /* Align to left */
            min-height: 100vh; /* Ensure body takes full viewport height */
            overflow: auto; /* Allow body scroll if content slightly overflows */

            padding: 1rem;
            box-sizing: border-box;
            position: relative; /* For the overlay */
        }

        /* Dark Overlay for Readability */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7); /* Dark overlay */
            z-index: -1; /* Behind the content */
        }

        /* Main Card Styling (The "Window") */
        .details-card {
            align-content: center; /* This property is for grid/flex items within the container, not the container itself */
            background-color: var(--noir-medium); /* Darker background for the card */
            border-radius: 1.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3); /* Stronger shadow */
            max-width: 1000px; /* Wider for the two-panel layout */
            animation: fadeIn 0.3s ease-out;
            max-height: 95vh; /* Max height to ensure it fits within viewport */
            overflow: hidden; /* Hide overflow on the main card */
            display: flex; /* Use flex for main content area */
            flex-direction: column; /* Stack header and content */
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Main Content Area - Split into two columns for desktop */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr; /* Default single column for mobile */
            gap: 1.5rem; /* Gap between rows/columns */
            padding: 1.5rem; /* Padding for the content area */
            padding-bottom: 0%;
            flex-grow: 1; /* Allow content to grow */
            overflow-y: auto; /* Enable scrolling for content if it exceeds height */
        }

        @media (min-width: 768px) { /* Medium screens and up (desktop two-panel) */
            .content-grid {
                grid-template-columns: 0.35fr 0.65fr; /* Left column narrower, right wider */
                gap: 2.5rem; /* Larger gap between the two main panels */
                padding: 2.5rem;
            }
            .content-grid > div:first-child { /* Left panel (Profile) */
                border-right: 1px solid var(--noir-light); /* Separator line */
                padding-right: 2.5rem; /* Padding for separator */
            }
            .content-grid > div:last-child { /* Right panel (Details) */
                padding-left: 0; /* No left padding needed as gap handles it */
            }
        }

        /* Profile Section Styling */
        .profile-section {
            background-color: var(--noir-dark); /* Dark background for profile section */
            border-radius: 1rem; /* Rounded corners for the section */
            padding: 1.5rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Subtle shadow */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center; /* Center content vertically */
            text-align: center;
            position: relative; /* For blurred background image positioning */
            overflow: hidden; /* Hide overflow of blurred image */
        }

        .profile-section-bg-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: blur(20px); /* Apply blur filter */
            opacity: 0.3; /* Adjust opacity as needed */
            z-index: 0; /* Place behind other content */
        }

        .profile-picture {
            width: 140px; /* Larger profile picture */
            height: 140px;
            object-fit: cover;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3); /* Stronger shadow for the picture */
            border: 4px solid var(--noir-accent); /* Accent border */
            margin-bottom: 1.5rem;
            position: relative; /* Ensure it's above the blurred background */
            z-index: 1;
        }

        .profile-name {
            font-size: 1.8rem; /* Larger name font */
            font-weight: 700;
            color: #ffffff; /* White text */
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .profile-role {
            background-color: var(--noir-accent); /* Accent background for role badge */
            color: var(--noir-dark); /* Dark text on accent */
            padding: 0.4rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: inline-block; /* For the badge effect */
            position: relative;
            z-index: 1;
        }

        /* Details Grid Styling (Right Panel) */
        .details-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr); /* Default single column for mobile */
            gap: 1.25rem; /* Gap between detail items */
        }

        @media (min-width: 640px) { /* Small screens and up (for inner details grid) */
            .details-grid {
                grid-template-columns: repeat(2, 1fr); /* Two columns for details */
            }
        }

        /* Individual Detail Item */
        .detail-item {
            background-color: var(--noir-dark); /* Dark background for each detail item */
            border-radius: 0.75rem;
            padding: 1rem 1.25rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15); /* Subtle shadow */
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 80px; /* Ensure consistent height for detail boxes */
        }

        .detail-label {
            color: #ffffff; /* All labels are white */
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 0.3rem;
            display: flex;
            align-items: center;
            gap: 0.5rem; /* Space between icon and text */
        }

        .detail-value {
            color: var(--noir-accent); /* All values are accent color */
            font-size: 1rem;
            font-weight: 500;
            word-break: break-all; /* Prevent long words from overflowing */
        }

        /* Action Buttons */
        .action-buttons-container {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 2.5rem; /* Margin above buttons */
        }

        @media (min-width: 640px) {
            .action-buttons-container {
                flex-direction: row;
                justify-content: center; /* Center buttons horizontally */
                gap: 1.5rem;
            }
        }

        .action-button {
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            transition: all 0.2s ease-in-out;
            cursor: pointer;
            font-size: 0.9rem;
            white-space: nowrap;
            font-family: 'Syne', sans-serif; /* Ensure Syne is applied to buttons */
        }

        .back-button {
            background-color: var(--noir-light); /* Dark background for back button */
            color: #ffffff;
        }

        .back-button:hover {
            background-color: var(--noir-muted);
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.25);
        }

        .edit-button {
            background-image: linear-gradient(to right, var(--header-gradient-start), var(--header-gradient-end)); /* Accent gradient */
            color: var(--noir-dark); /* Dark text on accent gradient */
            box-shadow: 0 3px 10px rgba(212, 169, 92, 0.4);
        }

        .edit-button:hover {
            background-image: linear-gradient(to right, #C29A4E, #B8893D);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(212, 169, 92, 0.5);
        }
    </style>
</head>
<body class="bg-noir-dark font-syne antialiased">

<div class="container  mx-auto px-10 sm:px-6 lg:px-8" style="padding-left: 15em"> {{-- Changed px-50 to px-8 for valid Tailwind padding --}}
    <div class="details-card" style="padding-top: 2em">
        {{-- Main Content Grid --}}
        <div class="content-grid">
            {{-- Left Panel: Profile Picture & Role --}}
            <div class="profile-section">
                {{-- Blurred Background Image --}}
                @if($user->profile_picture_url)
                    <img src="{{ asset('storage/' . $user->profile_picture_url) }}"
                         alt="Blurred Background"
                         class="profile-section-bg-image">
                @else
                    <img src="https://placehold.co/140x140/2A2A2A/D4A95C/blur?text=User"
                         alt="Blurred Placeholder Background"
                         class="profile-section-bg-image">
                @endif

                {{-- Main Profile Picture --}}
                <img src="{{ $user->profile_picture_url ? asset('storage/' . $user->profile_picture_url) : 'https://placehold.co/140x140/2A2A2A/D4A95C?text=User' }}"
                     alt="Profile Picture"
                     class="profile-picture"
                     onerror="this.onerror=null;this.src='https://placehold.co/140x140/2A2A2A/D4A95C?text=User';">
                
                <h2 class="profile-name">{{ $user->name }}</h2>
                <span class="profile-role">
                    {{ ucfirst($user->role ?? 'User') }}
                </span>
            </div>

            {{-- Right Panel: User Details Grid --}}
            <div>
                <div class="details-grid">
                    {{-- User ID --}}
                    <div class="detail-item">
                        <p class="detail-label"><i class="fas fa-id-badge"></i> User ID:</p>
                        <p class="detail-value">#{{ $user->id }}</p>
                    </div>
                    {{-- Date of Birth --}}
                    <div class="detail-item">
                        <p class="detail-label"><i class="fas fa-calendar-alt"></i> Date of Birth:</p>
                        <p class="detail-value">{{ $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('M d, Y') : 'N/A' }}</p>
                    </div>
                    {{-- Role (was Position) --}}
                    <div class="detail-item">
                        <p class="detail-label"><i class="fas fa-briefcase"></i> Role:</p>
                        <p class="detail-value">{{ ucfirst($user->role ?? 'N/A') }}</p>
                    </div>
                    {{-- Email --}}
                    <div class="detail-item">
                        <p class="detail-label"><i class="fas fa-envelope"></i> Email:</p>
                        <p class="detail-value">{{ $user->email ?? 'N/A' }}</p>
                    </div>
                    {{-- Phone Number --}}
                    <div class="detail-item">
                        <p class="detail-label"><i class="fas fa-phone"></i> Phone Number:</p>
                        <p class="detail-value">{{ $user->phone_number ?? 'N/A' }}</p>
                    </div>
                    {{-- Created At --}}
                    <div class="detail-item">
                        <p class="detail-label"><i class="fas fa-clock"></i> Created At:</p>
                        <p class="detail-value">{{ $user->created_at ? $user->created_at->format('M d, Y H:i') : 'N/A' }}</p>
                    </div>
                    {{-- Last Updated At --}}
                    <div class="detail-item">
                        <p class="detail-label"><i class="fas fa-sync-alt"></i> Last Updated At:</p>
                        <p class="detail-value">{{ $user->updated_at ? $user->updated_at->format('M d, Y H:i') : 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="action-buttons-container  md:p-8 border-t border-noir-light" style="padding-top: -1em">
            <a href="{{ route('admin.users.index') }}" class="action-button back-button">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
            <a href="{{ route('admin.users.edit', $user->id) }}" class="action-button edit-button">
                <i class="fas fa-edit"></i> Edit Staff
            </a>
        </div>
    </div>
</div>

</body>
</html>
