<header id="header" class="sticky-header py-6 px-6 md:px-12">
    <div class="container mx-auto">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="text-3xl font-bold text-white font-syne glitch" data-text="SNAY.CAFE">
                <span class="text-noir-accent">SNAY.</span>CAFE
            </a>
            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center space-x-10">
                <a href="{{ url('/') }}" class="nav-link text-white hover:text-noir-accent transition-colors">
                    <span data-lang="en">Home</span>
                    <span data-lang="km">ទំព័រដើម</span>
                </a>
                <a href="{{ route('products.index') }}"
                    class="nav-link text-white hover:text-noir-accent transition-colors">
                    <span data-lang="en">Products</span>
                    <span data-lang="km">ផលិតផល</span>
                </a>
                <a href="{{ route('services.index') }}"
                    class="nav-link text-white hover:text-noir-accent transition-colors">
                    <span data-lang="en">Services</span>
                    <span data-lang="km">សេវាកម្ម</span>
                </a>
                <a href="{{ url('/') }}#about"
                    class="nav-link text-white hover:text-noir-accent transition-colors">
                    <span data-lang="en">About</span>
                    <span data-lang="km">អំពីយើង</span>
                </a>
                <a href="{{ url('/') }}#contact"
                    class="nav-link text-white hover:text-noir-accent transition-colors">
                    <span data-lang="en">Contact</span>
                    <span data-lang="km">ទំនាក់ទំនង</span>
                </a>
            </nav>
            <div class="flex items-center space-x-6">
                @auth
                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                            class="text-white hover:text-noir-accent transition-colors flex items-center space-x-1"
                            title="Go to Admin Dashboard">
                            <i class="fa-solid fa-screwdriver-wrench text-lg"></i>
                        </a>
                    @endif
                @endauth

                {{-- Cart Icon - Updated to link to cart page and use dynamic count --}}
                <a href="{{ route('cart.index') }}"
                    class="text-white hover:text-noir-accent transition-colors relative shake cart-icon-container">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <span id="cart-item-count"
                        class="absolute -top-2 -right-2 bg-noir-accent text-noir-dark text-xs rounded-full w-5 h-5 flex items-center justify-center font-semibold"
                        style="display: none;">0</span>
                </a>

                <div class="language-switcher">
                    <button id="language-toggle"
                        class="text-white hover:text-noir-accent transition-colors flex items-center">
                        <span class="text-lg font-medium" id="current-lang">EN</span>
                        <i class="fas fa-chevron-down text-xs ml-1"></i>
                    </button>
                    <div class="language-options">
                        <div class="language-option active" id="lang-en" data-lang-code="en">
                            <span class="font-medium">EN</span>
                        </div>
                        <div class="language-option" id="lang-km" data-lang-code="km">
                            <span class="font-medium">KH</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    @guest
                        <a href="{{ url('/login') }}" class="text-white hover:text-noir-accent transition-colors">
                            <i class="fas fa-user-circle text-lg"></i>
                        </a>
                    @endguest

                    @auth
                        {{-- Admin Dashboard Link (Desktop) --}}


                        <a href="{{ url('/profile') }}"
                            class="text-white hover:text-noir-accent transition-colors flex items-center space-x-2 focus:outline-none">
                            {{-- Profile Picture with optional Crown Icon --}}
                            <div class="relative">
                                @if (Auth::user()->profile_picture_url)
                                    <img src="{{ Auth::user()->profile_picture_url ? asset('storage/' . Auth::user()->profile_picture_url) : 'https://placehold.co/600x400/2A2A2A/D4A95C?text=No+Image' }}"
                                        alt="{{ Auth::user()->name ?? 'User' }}"
                                        class="w-9 h-9 rounded-full object-cover border-2 border-noir-accent"> {{-- Changed w-8 h-8 to w-9 h-9 --}}
                                @else
                                    <i class="fas fa-user-circle text-lg"></i> {{-- Fallback to icon if no picture --}}
                                @endif

                                {{-- Crown Icon for Admin --}}
                                @if (Auth::user()->role === 'admin')
                                    <span
                                        class="absolute -top-1 -right-1 bg-noir-accent rounded-full p-0.5 flex items-center justify-center"
                                        {{-- Changed p-px to p-0.5, adjusted top/right --}} title="Admin User">
                                        <i class="fa-solid fa-crown text-noir-dark text-[0.6rem]"></i> {{-- Kept text-[0.6rem] --}}
                                    </span>
                                @endif
                            </div>
                            {{-- Username --}}
                            <span class="">{{ Auth::user()->name ?? 'User' }}</span>
                        </a>
                        {{-- Logout Icon (red color) --}}
                        <a href="#" id="logout-desktop-btn"
                            class="text-red-500 hover:text-red-600 transition-colors flex items-center space-x-1"
                            style="font-size: 1.5em; margin-left: 2em;"> <i
                                class="fa-solid fa-arrow-right-from-bracket"></i>
                        </a>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    @endauth
                </div>

                <button id="mobile-menu-button" class="md:hidden text-white hover:text-noir-accent transition-colors">
                    <i class="fas fa-bars text-lg"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="header-effect-bar"></div>
</header>

<div id="mobile-menu" class="fixed inset-0 bg-noir-dark bg-opacity-95 z-50 flex items-center justify-center hidden">
    <button id="mobile-close" class="absolute top-6 right-6 text-white hover:text-noir-accent">
        <i class="fas fa-times text-2xl"></i>
    </button>
    <nav class="flex flex-col items-center space-y-8 text-center">
        <a href="{{ url('/') }}" class="nav-link text-white text-3xl hover:text-noir-accent transition-colors font-syne">
            <span data-lang="en">Home</span>
            <span data-lang="km">ទំព័រដើម</span>
        </a>
        <a href="{{ route('products.index') }}"
            class="nav-link text-white text-3xl hover:text-noir-accent transition-colors font-syne">
            <span data-lang="en">Products</span>
            <span data-lang="km">ផលិតផល</span>
        </a>
        <a href="{{ route('services.index') }}"
            class="nav-link text-white text-3xl hover:text-noir-accent transition-colors font-syne">
            <span data-lang="en">Services</span>
            <span data-lang="km">សេវាកម្ម</span>
        </a>
        <a href="{{ url('/') }}#about"
            class="nav-link text-white text-3xl hover:text-noir-accent transition-colors font-syne">
            <span data-lang="en">About</span>
            <span data-lang="km">អំពីយើង</span>
        </a>
        <a href="{{ url('/') }}#contact"
            class="nav-link text-white text-3xl hover:text-noir-accent transition-colors font-syne">
            <span data-lang="en">Contact</span>
            <span data-lang="km">ទំនាក់ទំនង</span>
        </a>
        {{-- Admin Dashboard Link (Mobile) --}}
        @auth
            @if (Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}"
                    class="text-white text-3xl hover:text-noir-accent transition-colors font-syne flex items-center justify-center space-x-2"
                    title="Go to Admin Dashboard">
                    <i class="fa-solid fa-screwdriver-wrench text-2xl"></i>
                    <span>Admin Dashboard</span>
                </a>
            @endif
        @endauth
        {{-- Login/Logout for Mobile Menu --}}
        @guest
            <a href="{{ url('/login') }}" class="text-white text-3xl hover:text-noir-accent transition-colors font-syne">
                <span data-lang="en">Login</span>
                <span data-lang="km">ចូលគណនី</span>
            </a>
        @endguest
        @auth
            <a href="{{ url('/profile') }}"
                class="text-white text-3xl hover:text-noir-accent transition-colors font-syne flex items-center justify-center space-x-2">
                {{-- Profile Picture for Mobile Menu with optional Crown Icon --}}
                <div class="relative">
                    @if (Auth::user()->profile_picture_url)
                        <img src="{{ Auth::user()->profile_picture_url ? asset('storage/' . Auth::user()->profile_picture_url) : 'https://placehold.co/600x400/2A2A2A/D4A95C?text=No+Image' }}"
                            alt="{{ Auth::user()->name ?? 'User' }}"
                            class="w-9 h-9 rounded-full object-cover border-2 border-noir-accent"> {{-- Changed w-8 h-8 to w-9 h-9 --}}
                    @else
                        <i class="fas fa-user-circle text-2xl"></i> {{-- Fallback to icon if no picture, larger for mobile --}}
                    @endif

                    {{-- Crown Icon for Admin (Mobile) --}}
                    @if (Auth::user()->role === 'admin')
                        <span
                            class="absolute -top-1 -right-1 bg-noir-accent rounded-full p-0.5 flex items-center justify-center"
                            {{-- Changed p-px to p-0.5, adjusted top/right --}} title="Admin User">
                            <i class="fa-solid fa-crown text-noir-dark text-[0.6rem]"></i> {{-- Kept text-[0.6rem] --}}
                        </span>
                    @endif
                </div>
                {{-- Username --}}
                <span class="">Profile ({{ Auth::user()->name ?? 'User' }})</span>
            </a>
            {{-- Logout Icon (red color) --}}
            <a href="#" id="logout-mobile-btn"
                class="text-red-500 text-3xl hover:text-red-600 transition-colors font-syne">
                <span data-lang="en">Logout</span>
                <span data-lang="km">ចេញពីគណនី</span>
            </a>
            <form id="logout-form-mobile" action="{{ url('/logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        @endauth
    </nav>
</div>

{{-- Add this script block at the end of the header.blade.php file, before the closing </header> tag or </body> --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> {{-- Ensure SweetAlert2 is loaded --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navLinks = document.querySelectorAll('.nav-link'); // Ensure your nav links have this class
        const currentPath = window.location.pathname; // e.g., "/", "/products", "/products/123", "/services"
        const currentHash = window.location.hash; // e.g., "#about", "#contact"

        // 1. Clear active class from all links once before checking
        navLinks.forEach(link => {
            link.classList.remove('active');
        });

        // 2. Loop through links to determine which one should be active
        navLinks.forEach(link => {
            // Normalize the link's href to just its path (without domain or query params)
            const linkUrl = new URL(link.href);
            let linkPath = linkUrl.pathname;
            let linkHash = linkUrl.hash;

            // Remove trailing slashes for consistent comparison, unless it's just the root '/'
            const normalizedCurrentPath = currentPath === '/' ? '/' : currentPath.replace(/\/$/, '');
            const normalizedLinkPath = linkPath === '/' ? '/' : linkPath.replace(/\/$/, '');

            // Handle links that are purely path-based (Home, Products, Services)
            if (linkHash === '') { // Only consider links without a hash for path-based matching
                if (normalizedCurrentPath === normalizedLinkPath) {
                    // Exact match (e.g., / and /, or /products and /products)
                    link.classList.add('active');
                } else if (normalizedCurrentPath.startsWith(normalizedLinkPath) && normalizedLinkPath !== '/') {
                    // If current path starts with the link's path (e.g., /products/123 starts with /products)
                    // Exclude the root path to prevent all links from being active if currentPath starts with '/'
                    link.classList.add('active');
                }
            }
            // Handle links that are hash-based (About, Contact)
            else if (normalizedCurrentPath === '{{ url('/') }}' && currentHash === linkHash) {
                // Only activate hash links if we are on the homepage AND the hash matches
                link.classList.add('active');
            }
        });

        // SweetAlert2 Confirmation for Logout (remains unchanged)
        const logoutDesktopBtn = document.getElementById('logout-desktop-btn');
        const logoutMobileBtn = document.getElementById('logout-mobile-btn');
        const logoutForm = document.getElementById('logout-form');
        const logoutMobileForm = document.getElementById('logout-form-mobile');

        function confirmLogout(formToSubmit) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You will be logged out of your account.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#D4A95C', // Your accent color
                cancelButtonColor: '#2A2A2A', // Your dark color
                confirmButtonText: 'Yes, log me out!'
            }).then((result) => {
                if (result.isConfirmed) {
                    formToSubmit.submit(); // Submit the form if confirmed
                }
            });
        }

        if (logoutDesktopBtn) {
            logoutDesktopBtn.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent default link behavior
                confirmLogout(logoutForm);
            });
        }

        if (logoutMobileBtn) {
            logoutMobileBtn.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent default link behavior
                confirmLogout(logoutMobileForm); // Use the mobile form for mobile logout
            });
        }
    });
</script>
