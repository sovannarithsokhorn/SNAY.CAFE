<div class="w-64 bg-noir-medium h-full flex flex-col">
    <div class="p-6 border-b border-noir-light">
        <h1 class="font-syne font-bold text-2xl text-noir-accent">SNAY.CAFE</h1>
        <p class="text-noir-muted text-sm mt-1">Admin Dashboard</p>
    </div>
    <nav class="flex-1 overflow-y-auto py-4">
        <ul>
            <li>
                {{-- Updated to directly use route() --}}
                <button class="w-full text-left px-6 py-3 flex items-center text-noir-muted hover:text-white hover:bg-noir-light transition-all" onclick="window.location.href='{{ route('admin.dashboard') }}'; updateHeaderTitle('Dashboard');">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    Dashboard
                </button>
            </li>
            <li>
                {{-- Updated to directly use route() --}}
                <button class="w-full text-left px-6 py-3 flex items-center text-noir-muted hover:text-white hover:bg-noir-light transition-all" onclick="window.location.href='{{ route('admin.products.index') }}'; updateHeaderTitle('Products');">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Products
                </button>
            </li>
            <li>
                {{-- Updated to directly use route() --}}
                <button class="w-full text-left px-6 py-3 flex items-center text-noir-muted hover:text-white hover:bg-noir-light transition-all" onclick="window.location.href='{{ route('admin.categories.index') }}'; updateHeaderTitle('Categories');">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    Categories
                </button>
            </li>
            {{-- NEW: Orders Link --}}
            <li>
                {{-- Updated to directly use route() and Font Awesome icon --}}
                <button class="w-full text-left px-6 py-3 flex items-center text-noir-muted hover:text-white hover:bg-noir-light transition-all" onclick="window.location.href='{{ route('admin.orders.index') }}'; updateHeaderTitle('Orders');">
                    <i class="fas fa-receipt h-5 w-5 mr-3"></i> {{-- Font Awesome icon for orders --}}
                    Orders
                </button>
            </li>
            <li>
                {{-- Updated to directly use route() --}}
                <button class="w-full text-left px-6 py-3 flex items-center text-noir-muted hover:text-white hover:bg-noir-light transition-all" onclick="window.location.href='{{ route('admin.users.index') }}'; updateHeaderTitle('Users');"> {{-- Assuming admin.users.index route exists --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    Users
                </button>
            </li>
            {{-- New: Services Link (assuming this is a separate section in your backend) --}}
            <li>
                {{-- Updated to directly use route() --}}
                <button class="w-full text-left px-6 py-3 flex items-center text-noir-muted hover:text-white hover:bg-noir-light transition-all" onclick="window.location.href='{{ route('admin.services.index') }}'; updateHeaderTitle('Services');"> {{-- Assuming admin.services.index route exists --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Services
                </button>
            </li>
            <li>
                {{-- Updated to directly use route() --}}
                <button class="w-full text-left px-6 py-3 flex items-center text-noir-muted hover:text-white hover:bg-noir-light transition-all" onclick="window.location.href='{{ route('admin.settings.index') }}'; updateHeaderTitle('Settings');"> {{-- Assuming admin.settings.index route exists --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Settings
                </button>
            </li>
            {{-- Button to go to Frontend --}}
            <li>
                <button class="w-full text-left px-6 py-3 flex items-center text-noir-muted hover:text-white hover:bg-noir-light transition-all" onclick="window.location.href='{{ route('home') }}'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    View Website
                </button>
            </li>
        </ul>
    </nav>
    <div class="p-4 border-t border-noir-light">
        <div class="flex items-center">
            {{-- User Profile Picture --}}
            <div class="flex-shrink-0 h-10 w-10 rounded-full overflow-hidden border-2 border-noir-accent flex items-center justify-center"> {{-- Added border-2 and border-red-500 --}}
                @if(Auth::user()->profile_picture_url)
                    <img src="{{ asset('storage/' . Auth::user()->profile_picture_url) }}" alt="User Profile" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-noir-accent flex items-center justify-center text-noir-dark font-bold">
                        {{-- Display first letter of name if no pic --}}
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
            </div>
            <div class="ml-3">
                <p class="text-white text-sm font-medium">{{ Auth::user()->name }}</p> {{-- Display logged-in user's name --}}
                <p class="text-xs text-noir-muted">{{ Auth::user()->email }}</p> {{-- Display logged-in user's email --}}
            </div>
            <button class="ml-auto text-red-500 hover:text-red-400" onclick="confirmLogout()"> {{-- Changed text-noir-muted to text-red-500 and hover:text-white to hover:text-red-400 --}}
                <i class="fas fa-sign-out-alt h-5 w-5"></i> {{-- Font Awesome Logout Icon --}}
            </button>
        </div>
    </div>
</div>

{{-- Hidden Logout Form --}}
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function updateHeaderTitle(title) {
        const headerTitleElement = document.getElementById('section-title');
        if (headerTitleElement) {
            headerTitleElement.textContent = title;
        }
    }

    // Function to confirm logout with SweetAlert2
    function confirmLogout() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You will be logged out!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#D4A95C', // SNAY.CAFE accent color
            cancelButtonColor: '#3A3A3A', // SNAY.CAFE light color
            confirmButtonText: 'Yes, log me out!',
            background: '#2A2A2A', // SNAY.CAFE medium color
            color: '#FFFFFF' // White text
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }

    // Call updateHeaderTitle on page load based on the current route
    document.addEventListener('DOMContentLoaded', () => {
        const currentPath = window.location.pathname;
        // Remove active class from all buttons initially
        document.querySelectorAll('nav button').forEach(button => {
            button.classList.remove('text-white', 'bg-noir-light');
            button.classList.add('text-noir-muted');
        });

        // Determine the active link and apply styles
        let activeTitle = 'Dashboard'; // Default title

        if (currentPath.includes('/admin/products')) {
            activeTitle = 'Products';
            document.querySelector('button[onclick*="admin.products.index"]').classList.add('text-white', 'bg-noir-light');
            document.querySelector('button[onclick*="admin.products.index"]').classList.remove('text-noir-muted');
        } else if (currentPath.includes('/admin/categories')) {
            activeTitle = 'Categories';
            document.querySelector('button[onclick*="admin.categories.index"]').classList.add('text-white', 'bg-noir-light');
            document.querySelector('button[onclick*="admin.categories.index"]').classList.remove('text-noir-muted');
        } else if (currentPath.includes('/admin/orders')) {
            activeTitle = 'Orders';
            document.querySelector('button[onclick*="admin.orders.index"]').classList.add('text-white', 'bg-noir-light');
            document.querySelector('button[onclick*="admin.orders.index"]').classList.remove('text-noir-muted');
        } else if (currentPath.includes('/admin/users')) {
            activeTitle = 'Users';
            document.querySelector('button[onclick*="admin.users.index"]').classList.add('text-white', 'bg-noir-light');
            document.querySelector('button[onclick*="admin.users.index"]').classList.remove('text-noir-muted');
        } else if (currentPath.includes('/admin/services')) {
            activeTitle = 'Services';
            document.querySelector('button[onclick*="admin.services.index"]').classList.add('text-white', 'bg-noir-light');
            document.querySelector('button[onclick*="admin.services.index"]').classList.remove('text-noir-muted');
        } else if (currentPath.includes('/admin/settings')) {
            activeTitle = 'Settings';
            document.querySelector('button[onclick*="admin.settings.index"]').classList.add('text-white', 'bg-noir-light');
            document.querySelector('button[onclick*="admin.settings.index"]').classList.remove('text-noir-muted');
        } else { // Default to Dashboard if no specific match
            document.querySelector('button[onclick*="admin.dashboard"]').classList.add('text-white', 'bg-noir-light');
            document.querySelector('button[onclick*="admin.dashboard"]').classList.remove('text-noir-muted');
        }
        updateHeaderTitle(activeTitle);
    });
</script>
