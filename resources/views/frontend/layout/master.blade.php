
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <title>DBI - @yield('title', 'Premium Coffee Supplier')</title> {{-- Default title added --}}
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
      <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Bootstrap CSS (Only one instance) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Your compiled app.css (if you have one, e.g., for Laravel Mix/Vite output) --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Tailwind CSS configuration - MUST BE HERE for custom colors/fonts to work
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        noir: {
                            dark: '#0F0F0F',
                            medium: '#1A1A1A',
                            light: '#2A2A2A',
                            accent: '#D4A95C',
                            muted: '#8A8A8A'
                        }
                    },
                    fontFamily: {
                        'syne': ['Syne', 'sans-serif'],
                        'inter': ['Inter', 'sans-serif'],
                        'kantumruy': ['"Kantumruy Pro"', 'sans-serif'],
                        'montserrat': ['Montserrat', 'sans-serif']
                    }
                }
            }
        }
    </script>

    {{-- Font Awesome (latest version) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- SweetAlert2 CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.2/dist/sweetalert2.min.css">

    <link rel="stylesheet" type="text/css" href="{{asset('frontend/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/responsive.css')}}">
    <link rel="icon" href="{{asset('frontend/assets/images/fevicon.png')}}" type="image/gif" />
    <link rel="stylesheet" href="{{asset('frontend/assets/css/jquery.mCustomScrollbar.min.css')}}">
    {{-- CORRECTED: Owl Carousel CSS (Ensure you use OwlCarousel2 for this CDN) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

    <style>
        /* Custom styles to ensure your Noir theme is applied and SweetAlert2 looks good */
        body {
            background-color: #0F0F0F; /* noir-dark */
            color: #fff;
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Syne', sans-serif;
        }

        /* Custom SweetAlert2 styling to match your theme */
        .swal2-popup {
            background-color: #1A1A1A !important; /* noir-medium */
            color: #ffffff !important;
            border-radius: 10px !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5) !important;
        }
        .swal2-title {
            color: #D4A95C !important; /* noir-accent */
            font-family: 'Syne', sans-serif !important;
        }
        .swal2-html-container {
            color: #ffffff !important;
        }
        .swal2-icon.swal2-success [class^=swal2-success-line][class$=long],
        .swal2-icon.swal2-success [class^=swal2-success-line][class$=tip] {
            background-color: #D4A95C !important; /* noir-accent */
        }
        .swal2-icon.swal2-success .swal2-success-ring {
            border-color: rgba(212, 169, 92, 0.5) !important; /* noir-accent with transparency */
        }
        .swal2-timer-progress-bar {
            background: #D4A95C !important; /* noir-accent */
        }
        .swal2-close:focus {
            box-shadow: none !important; /* Remove default focus outline */
        }

        /* Cart icon specific styles */
        .cart-icon-container {
            position: relative;
            display: inline-block;
        }
        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #D4A95C; /* Accent color */
            color: #0F0F0F; /* Dark text */
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.75rem;
            line-height: 1;
            min-width: 20px;
            height: 20px; /* Ensure height matches min-width for perfect circle */
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body class="en">
    
    {{-- Cart Notification (can be a partial if reused) --}}
    <div id="cart-notification" class="cart-notification">
        <div class="flex items-center space-x-3">
            <div class="text-noir-accent">
                <i class="fas fa-check-circle text-xl"></i>
            </div>
            <div>
                <h4 class="font-medium text-white">
                    <span data-lang="en">Added to Cart</span>
                    <span data-lang="km">បានបញ្ចូលក្នុងកន្ត្រក</span>
                </h4>
                <p class="text-sm text-noir-muted">
                    <span data-lang="en">Item has been added to your cart</span>
                    <span data-lang="km">ទំនិញត្រូវបានបញ្ចូលក្នុងកន្ត្រករបស់អ្នក</span>
                </p>
            </div>
        </div>
    </div>

    @include('frontend.layout.header')

    @yield('content')

    @include('frontend.layout.footer')

    {{-- Load jQuery first as many other scripts depend on it --}}
    <script src="{{asset('frontend/assets/js/jquery-3.0.0.min.js')}}"></script>
    <script src="{{asset('frontend/assets/js/popper.min.js')}}"></script>
    <script src="{{asset('frontend/assets/js/bootstrap.bundle.min.js')}}"></script>

    <script src="{{asset('frontend/assets/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <script src="{{asset('frontend/assets/js/custom.js')}}"></script> {{-- Your custom JS --}}
    {{-- CORRECTED: Owl Carousel JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>

    {{-- SweetAlert2 JS - Load after jQuery and Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.2/dist/sweetalert2.all.min.js"></script>

    {{-- This is crucial for pushing page-specific scripts like the pop-up logic --}}
    @stack('scripts')

    <script>
        // Gijgo datepicker initialization (from original HTML)
        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4'
        });

        // Global function to update cart count
        function updateCartCount() {
            fetch('{{ route('cart.count') }}', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                // Ensure the response is OK before parsing as JSON
                if (!response.ok) {
                    // Log more details if the response is not OK
                    return response.text().then(text => {
                        console.error('Network response was not ok. Status:', response.status, 'Response Text:', text);
                        throw new Error('Network response was not ok ' + response.statusText);
                    });
                }
                return response.json();
            })
            .then(count => {
                const cartCountElement = document.getElementById('cart-item-count');
                if (cartCountElement) {
                    cartCountElement.textContent = count;
                    cartCountElement.style.display = count > 0 ? 'flex' : 'none';
                }
            })
            .catch(error => console.error('Error fetching cart count:', error));
        }

        // Call updateCartCount on page load
        document.addEventListener('DOMContentLoaded', updateCartCount);
    </script>
</body>
</html>