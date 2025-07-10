<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SNAY.CAFE System - @yield('title', 'Admin Dashboard')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Syne:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'noir-dark': '#0F0F0F',
                        'noir-medium': '#1A1A1A',
                        'noir-light': '#2A2A2A',
                        'noir-accent': '#D4A95C',
                        'noir-muted': '#8A8A8A',
                    },
                    fontFamily: {
                        'syne': ['Syne', 'sans-serif'],
                        'inter': ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    {{-- Font Awesome for icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    {{-- SweetAlert2 CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        body {
            background-color: #0F0F0F;
            color: #fff;
            font-family: 'Inter', sans-serif; /* Default body font, can be overridden by Syne classes */
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Syne', sans-serif;
        }
        .transition-all {
            transition: all 0.3s ease;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #1A1A1A;
        }
        ::-webkit-scrollbar-thumb {
            background: #D4A95C;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #c39a52;
        }
        /* Table styles */
        table {
            border-collapse: separate;
            border-spacing: 0;
        }
        th, td {
            padding: 12px 16px;
            text-align: left;
        }
        th {
            background-color: #1A1A1A;
            font-weight: 600;
        }
        tr:nth-child(even) {
            background-color: #1A1A1A;
        }
        tr:nth-child(odd) {
            background-color: #0F0F0F;
        }
        tr:hover {
            background-color: #2A2A2A;
        }
        .modal {
            transition: opacity 0.3s ease;
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    @include('backend.layout.sidebar')

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Bar (Header) -->
        @include('backend.layout.header')

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-6 bg-noir-dark">
            @yield('content')
        </div>
    </div>

    {{-- SweetAlert2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Global function to update the header title
        // This function is now directly available for onclick events from sidebar.blade.php
        function updateHeaderTitle(title) {
            const headerTitleElement = document.getElementById('section-title');
            if (headerTitleElement) {
                headerTitleElement.textContent = title;
            }
        }

        // Logout Confirmation for Admin Backend (if you have a logout button in the header or sidebar)
        // This function is global and can be called from any included partial.
        function confirmLogout() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You will be logged out!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#D4A95C', // Your accent color
                cancelButtonColor: '#2A2A2A', // Your dark color
                confirmButtonText: 'Yes, log me out!',
                background: '#1A1A1A', // SweetAlert background to match noir-medium
                color: '#FFFFFF' // SweetAlert text color
            }).then((result) => {
                if (result.isConfirmed) {
                    // Assuming you have a hidden form with id="logout-form" for logout
                    document.getElementById('logout-form').submit();
                }
            });
        }

        // Initial active state for sidebar on page load
        document.addEventListener('DOMContentLoaded', () => {
            const currentPath = window.location.pathname;
            const navButtons = document.querySelectorAll('nav ul li button');

            // Remove active class from all buttons initially
            navButtons.forEach(button => {
                button.classList.remove('text-white', 'bg-noir-light');
                button.classList.add('text-noir-muted');
            });

            // Determine the active link and apply styles
            let matchedButton = null;
            let activeTitle = 'Dashboard'; // Default title

            if (currentPath.includes('/admin/products')) {
                matchedButton = document.querySelector('button[onclick*="admin.products.index"]');
                activeTitle = 'Products';
            } else if (currentPath.includes('/admin/categories')) {
                matchedButton = document.querySelector('button[onclick*="admin.categories.index"]');
                activeTitle = 'Categories';
            } else if (currentPath.includes('/admin/orders')) {
                matchedButton = document.querySelector('button[onclick*="admin.orders.index"]');
                activeTitle = 'Orders';
            } else if (currentPath.includes('/admin/users')) {
                matchedButton = document.querySelector('button[onclick*="admin.users.index"]');
                activeTitle = 'Users';
            } else if (currentPath.includes('/admin/services')) {
                matchedButton = document.querySelector('button[onclick*="admin.services.index"]');
                activeTitle = 'Services';
            } else if (currentPath.includes('/admin/settings')) {
                matchedButton = document.querySelector('button[onclick*="admin.settings.index"]');
                activeTitle = 'Settings';
            } else { // Fallback for dashboard or other routes, explicitly check for dashboard
                if (currentPath === '/admin' || currentPath === '/admin/dashboard') {
                    matchedButton = document.querySelector('button[onclick*="admin.dashboard"]');
                }
            }

            if (matchedButton) {
                matchedButton.classList.add('text-white', 'bg-noir-light');
                matchedButton.classList.remove('text-noir-muted');
            }
            updateHeaderTitle(activeTitle); // Update header title based on active page
        });
    </script>
    @stack('scripts') {{-- This is crucial for pushing page-specific scripts --}}
</body>
</html>
