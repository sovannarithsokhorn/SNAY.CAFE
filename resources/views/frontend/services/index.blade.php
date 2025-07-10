@extends('frontend.layout.master')

@section('title', 'Services - SNAY.CAFE')

@section('content')
    <style>
        /* Tailwind CSS configuration from original HTML */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Syne:wght@400;500;600;700&display=swap');

        /* Custom styles from original HTML */
        body {
            background: linear-gradient(135deg, #0F0F0F 0%, #1A1A1A 100%);
            color: #fff;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Syne', sans-serif;
        }
        .transition-all {
            transition: all 0.3s ease;
        }
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(26, 26, 26, 0.8);
            border: 1px solid rgba(212, 169, 92, 0.1);
        }
        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite alternate;
        }
        @keyframes pulse-glow {
            from { box-shadow: 0 0 20px rgba(212, 169, 92, 0.3); }
            to { box-shadow: 0 0 30px rgba(212, 169, 92, 0.6); }
        }
        .service-card {
            transform: translateY(0);
            transition: all 0.3s ease;
        }
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(212, 169, 92, 0.2);
        }
        .coffee-bean {
            width: 8px;
            height: 12px;
            background: #D4A95C;
            border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
            position: relative;
        }
        .coffee-bean::before {
            content: '';
            position: absolute;
            top: 2px;
            left: 50%;
            transform: translateX(-50%);
            width: 1px;
            height: 8px;
            background: #0F0F0F;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
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
        .fade-in {
            animation: fadeIn 0.8s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .stagger-1 { animation-delay: 0.1s; }
        .stagger-2 { animation-delay: 0.2s; }
        .stagger-3 { animation-delay: 0.3s; }
        .stagger-4 { animation-delay: 0.4s; }
        .stagger-5 { animation-delay: 0.5s; }

        /* Styles for the modal */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 100; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0,0,0,0.7); /* Black w/ opacity */
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #1A1A1A;
            margin: auto;
            padding: 2rem;
            border-radius: 0.75rem;
            width: 90%;
            max-width: 600px;
            position: relative;
            box-shadow: 0 0 30px rgba(212, 169, 92, 0.4);
        }

        .close-button {
            color: #8A8A8A;
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 1.5rem;
            font-weight: bold;
            cursor: pointer;
        }

        .close-button:hover,
        .close-button:focus {
            color: #D4A95C;
            text-decoration: none;
            cursor: pointer;
        }
    </style>

    <!-- Hero Section -->
    <section class="pt-24  py-50 pb-1 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto text-center">
            <div>
                <h1 class="font-syne font-bold text-5xl md:text-7xl mb-6">
                    Professional <span class="text-noir-accent">Services</span>
                </h1>
                <p class="text-xl text-noir-muted max-w-3xl mx-auto mb-8">
                    Expert coffee equipment maintenance, repair, and consultation services to keep your coffee experience at its peak. From home setups to commercial operations.
                </p>
            </div>
        </div>
    </section>

    <!-- Services Overview -->
    <section class="py-1 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="font-syne font-bold text-4xl mb-4">Our Expert Services</h2>
                <p class="text-noir-muted text-lg max-w-2xl mx-auto">
                    We provide comprehensive coffee equipment services to ensure your brewing experience is always exceptional.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Equipment Repair & Maintenance -->
                <div class="service-card glass-effect rounded-2xl p-8 fade-in stagger-1">
                    <div class="relative mb-6 overflow-hidden rounded-xl">
                        <img src="https://images.unsplash.com/photo-1559056199-641a0ac8b55e?ixlib=rb-4.0.3&amp;ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&amp;auto=format&amp;fit=crop&amp;w=1000&amp;q=80"
                            alt="Coffee machine repair" class="w-full h-48 object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-noir-dark/80 to-transparent"></div>
                        <div class="absolute bottom-4 left-4">
                            <div class="w-12 h-12 bg-noir-accent rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-noir-dark" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <h3 class="font-syne font-semibold text-2xl mb-4 text-center">Equipment Repair &amp; Maintenance</h3>
                    <p class="text-noir-muted text-center mb-6">
                        Professional repair and maintenance services for espresso machines, grinders, and brewing equipment. Keep your machines running at peak performance.
                    </p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-noir-accent mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span class="text-sm">Espresso machine servicing</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-noir-accent mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span class="text-sm">Grinder calibration &amp; repair</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-noir-accent mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span class="text-sm">Preventive maintenance plans</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-noir-accent mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span class="text-sm">Emergency repair services</span>
                        </li>
                    </ul>
                    <div class="text-center">
                        <button onclick="openServiceModal('repair')"
                            class="bg-noir-accent text-noir-dark px-6 py-3 rounded-lg font-medium hover:bg-noir-accent/90 transition-all">
                            Learn More
                        </button>
                    </div>
                </div>

                <!-- Deep Cleaning Services -->
                <div class="service-card glass-effect rounded-2xl p-8 fade-in stagger-2">
                    <div class="relative mb-6 overflow-hidden rounded-xl">
                        <img src="https://images.unsplash.com/photo-1581833971358-2c8b550f87b3?ixlib=rb-4.0.3&amp;ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&amp;auto=format&amp;fit=crop&amp;w=1000&amp;q=80"
                            alt="Coffee machine cleaning" class="w-full h-48 object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-noir-dark/80 to-transparent"></div>
                        <div class="absolute bottom-4 left-4">
                            <div class="w-12 h-12 bg-noir-accent rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-noir-dark" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <h3 class="font-syne font-semibold text-2xl mb-4 text-center">Deep Cleaning Services</h3>
                    <p class="text-noir-muted text-center mb-6">
                        Comprehensive cleaning and descaling services to maintain hygiene standards and extend equipment lifespan. Professional-grade cleaning solutions.
                    </p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-noir-accent mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span class="text-sm">Machine descaling &amp; sanitization</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-noir-accent mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span class="text-sm">Internal component cleaning</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-noir-accent mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span class="text-sm">Water system purification</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-noir-accent mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span class="text-sm">Scheduled cleaning programs</span>
                        </li>
                    </ul>
                    <div class="text-center">
                        <button onclick="openServiceModal('cleaning')"
                            class="bg-noir-accent text-noir-dark px-6 py-3 rounded-lg font-medium hover:bg-noir-accent/90 transition-all">
                            Learn More
                        </button>
                    </div>
                </div>

                <!-- Parts & Accessories -->
                <div class="service-card glass-effect rounded-2xl p-8 fade-in stagger-3">
                    <div class="relative mb-6 overflow-hidden rounded-xl">
                        <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-4.0.3&amp;ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&amp;auto=format&amp;fit=crop&amp;w=1000&amp;q=80"
                            alt="Coffee accessories and parts" class="w-full h-48 object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-noir-dark/80 to-transparent"></div>
                        <div class="absolute bottom-4 left-4">
                            <div class="w-12 h-12 bg-noir-accent rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-noir-dark" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <h3 class="font-syne font-semibold text-2xl mb-4 text-center">Parts &amp; Accessories</h3>
                    <p class="text-noir-muted text-center mb-6">
                        Genuine replacement parts and premium accessories for all major coffee equipment brands. Upgrade your setup with professional-grade components.
                    </p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-noir-accent mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span class="text-sm">Genuine OEM replacement parts</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-noir-accent mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span class="text-sm">Premium brewing accessories</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-noir-accent mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span class="text-sm">Water filtration systems</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-noir-accent mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span class="text-sm">Specialty cleaning tools</span>
                        </li>
                    </ul>
                    <div class="text-center">
                        <button onclick="openServiceModal('parts')"
                            class="bg-noir-accent text-noir-dark px-6 py-3 rounded-lg font-medium hover:bg-noir-accent/90 transition-all">
                            Learn More
                        </button>
                    </div>
                </div>

                <!-- Consultation & Setup -->
                <div class="service-card glass-effect rounded-2xl p-8 fade-in stagger-4">
                    <div class="relative mb-6 overflow-hidden rounded-xl">
                        <img src="https://images.unsplash.com/photo-1517248135467-4c7ed153b042?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80"
                            alt="Coffee shop consultation" class="w-full h-48 object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-noir-dark/80 to-transparent"></div>
                        <div class="absolute bottom-4 left-4">
                            <div class="w-12 h-12 bg-noir-accent rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-noir-dark" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 13.255A23.55 23.55 0 0112 15c-1.685 0-3.32-.219-4.904-.645m9.321 1.865c.09.2.16.4.21.611a2.004 2.004 0 01-.853 1.995l-1.074.676a2.004 2.004 0 00-.645 3.355l.391.391a2.004 2.004 0 010 2.828l-3.91 3.91a2.004 2.004 0 01-2.828 0L3 14.21l-.391-.391A2.004 2.004 0 013.255 12c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <h3 class="font-syne font-semibold text-2xl mb-4 text-center">Consultation &amp; Setup</h3>
                    <p class="text-noir-muted text-center mb-6">
                        Expert guidance on setting up new coffee stations, optimizing workflow, and choosing the right equipment for your needs.
                    </p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-noir-accent mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span class="text-sm">New cafe setup consultation</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-noir-accent mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span class="text-sm">Workflow optimization</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-noir-accent mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span class="text-sm">Equipment selection guidance</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-noir-accent mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span class="text-sm">On-site installation &amp; testing</span>
                        </li>
                    </ul>
                    <div class="text-center">
                        <button onclick="openServiceModal('consultation')"
                            class="bg-noir-accent text-noir-dark px-6 py-3 rounded-lg font-medium hover:bg-noir-accent/90 transition-all">
                            Learn More
                        </button>
                    </div>
                </div>

                <!-- Barista Training -->
                <div class="service-card glass-effect rounded-2xl p-8 fade-in stagger-5">
                    <div class="relative mb-6 overflow-hidden rounded-xl">
                        <img src="https://images.unsplash.com/photo-1511920170033-f8396924c348?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80"
                            alt="Barista training" class="w-full h-48 object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-noir-dark/80 to-transparent"></div>
                        <div class="absolute bottom-4 left-4">
                            <div class="w-12 h-12 bg-noir-accent rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-noir-dark" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <h3 class="font-syne font-semibold text-2xl mb-4 text-center">Barista Training</h3>
                    <p class="text-noir-muted text-center mb-6">
                        Comprehensive training programs for aspiring and experienced baristas. Master brewing techniques, latte art, and customer service.
                    </p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-noir-accent mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span class="text-sm">Basic to advanced brewing techniques</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-noir-accent mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span class="text-sm">Latte art &amp; milk frothing</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-noir-accent mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span class="text-sm">Coffee bean knowledge &amp; sourcing</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-noir-accent mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span class="text-sm">Customer service excellence</span>
                        </li>
                    </ul>
                    <div class="text-center">
                        <button onclick="openServiceModal('training')"
                            class="bg-noir-accent text-noir-dark px-6 py-3 rounded-lg font-medium hover:bg-noir-accent/90 transition-all">
                            Learn More
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-16 px-4 sm:px-6 lg:px-8 bg-noir-medium text-center pulse-glow rounded-xl max-w-4xl mx-auto mb-12">
        <h2 class="font-syne font-bold text-4xl mb-4">Ready to Elevate Your Coffee Experience?</h2>
        <p class="text-lg text-noir-muted max-w-2xl mx-auto mb-8">
            Contact us today to discuss your specific service needs and get a personalized quote.
        </p>
        <button onclick="openServiceModal('contact')"
            class="bg-noir-accent text-noir-dark px-8 py-4 rounded-lg font-bold text-xl hover:bg-noir-accent/90 transition-all shadow-lg">
            Request a Service
        </button>
    </section>

    <!-- Service Request Modal -->
    <div id="serviceModal" class="modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeServiceModal()">&times;</span>
            <h2 id="modalTitle" class="font-syne font-bold text-3xl text-white mb-6 text-center">Request Service</h2>
            <form id="serviceRequestForm" action="#" method="POST" class="space-y-6">
                <input type="hidden" id="serviceType" name="service_type">

                <div>
                    <label for="fullName" class="block text-noir-muted text-sm font-medium mb-2">Full Name</label>
                    <input type="text" id="fullName" name="full_name" required
                        class="w-full p-3 rounded-lg bg-noir-light border border-noir-muted/20 text-white placeholder-noir-muted focus:outline-none focus:border-transparent focus:ring-2 focus:ring-noir-accent focus:ring-offset-2 focus:ring-offset-noir-dark transition-all">
                </div>
                <div>
                    <label for="email" class="block text-noir-muted text-sm font-medium mb-2">Email Address</label>
                    <input type="email" id="email" name="email" required
                        class="w-full p-3 rounded-lg bg-noir-light border border-noir-muted/20 text-white placeholder-noir-muted focus:outline-none focus:border-transparent focus:ring-2 focus:ring-noir-accent focus:ring-offset-2 focus:ring-offset-noir-dark transition-all">
                </div>
                <div>
                    <label for="phone" class="block text-noir-muted text-sm font-medium mb-2">Phone Number (Optional)</label>
                    <input type="tel" id="phone" name="phone"
                        class="w-full p-3 rounded-lg bg-noir-light border border-noir-muted/20 text-white placeholder-noir-muted focus:outline-none focus:border-transparent focus:ring-2 focus:ring-noir-accent focus:ring-offset-2 focus:ring-offset-noir-dark transition-all">
                </div>
                <div>
                    <label for="serviceDescription" class="block text-noir-muted text-sm font-medium mb-2">Service Details</label>
                    <textarea id="serviceDescription" name="service_description" rows="4" required
                        class="w-full p-3 rounded-lg bg-noir-light border border-noir-muted/20 text-white placeholder-noir-muted resize-none focus:outline-none focus:border-transparent focus:ring-2 focus:ring-noir-accent focus:ring-offset-2 focus:ring-offset-noir-dark transition-all"></textarea>
                </div>
                <div>
                    <label for="preferredDate" class="block text-noir-muted text-sm font-medium mb-2">Preferred Date</label>
                    <input type="date" id="preferredDate" name="preferred_date"
                        class="w-full p-3 rounded-lg bg-noir-light border border-noir-muted/20 text-white placeholder-noir-muted focus:outline-none focus:border-transparent focus:ring-2 focus:ring-noir-accent focus:ring-offset-2 focus:ring-offset-noir-dark transition-all">
                </div>
                <div>
                    <label for="preferredTime" class="block text-noir-muted text-sm font-medium mb-2">Preferred Time</label>
                    <input type="time" id="preferredTime" name="preferred_time"
                        class="w-full p-3 rounded-lg bg-noir-light border border-noir-muted/20 text-white placeholder-noir-muted focus:outline-none focus:border-transparent focus:ring-2 focus:ring-noir-accent focus:ring-offset-2 focus:ring-offset-noir-dark transition-all">
                </div>

                <div class="text-center">
                    <button type="submit"
                        class="bg-green-500 text-white px-8 py-3 rounded-lg font-bold text-lg hover:bg-green-600 transition-all focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-noir-dark">
                        Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Get the modal
        var modal = document.getElementById("serviceModal");
        var modalTitle = document.getElementById("modalTitle");
        var serviceTypeInput = document.getElementById("serviceType");

        // Function to open the modal
        function openServiceModal(service) {
            modal.style.display = "flex"; // Use flex to center
            let titleText = "Request Service";
            switch (service) {
                case 'repair':
                    titleText = "Request Equipment Repair & Maintenance";
                    break;
                case 'cleaning':
                    titleText = "Request Deep Cleaning Service";
                    break;
                case 'parts':
                    titleText = "Inquire About Parts & Accessories";
                    break;
                case 'consultation':
                    titleText = "Request Consultation & Setup";
                    break;
                case 'training':
                    titleText = "Request Barista Training";
                    break;
                case 'contact':
                    titleText = "Request a Service Quote";
                    break;
            }
            modalTitle.textContent = titleText;
            serviceTypeInput.value = service; // Set the hidden input value
        }

        // Function to close the modal
        function closeServiceModal() {
            modal.style.display = "none";
        }

        // Close the modal if the user clicks outside of it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Add focus/blur effects to form inputs
        document.querySelectorAll('#serviceRequestForm input, #serviceRequestForm textarea').forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value === '') {
                    this.style.borderColor = 'rgba(138, 138, 138, 0.2)';
                }
            });

            input.addEventListener('focus', function() {
                this.style.borderColor = '#D4A95C';
            });
        });

        // Set minimum date to today for service requests
        document.getElementById('preferredDate').min = new Date().toISOString().split('T')[0];

        // Handle form submission (example - you'll need to implement actual AJAX/Laravel logic)
        document.getElementById('serviceRequestForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            // Here you would typically send the form data via AJAX
            // For now, let's just log it and show a success message
            const formData = new FormData(this);
            const data = {};
            formData.forEach((value, key) => (data[key] = value));

            console.log('Service Request Submitted:', data);

            // Simulate a successful submission
            setTimeout(() => {
                alert('Your service request has been submitted successfully!');
                closeServiceModal();
                this.reset(); // Clear the form
            }, 500);
        });
    </script>
@endpush
