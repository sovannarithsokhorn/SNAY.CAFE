@extends('frontend.layout.master')

@section('title', 'Premium Coffee Supplier') {{-- Set the title for this page --}}

@section('content')

    {{-- The old custom welcome-message-popup div has been removed as SweetAlert2 handles the UI --}}

    <section class="slideshow relative">
        <div class="slide-progress" id="slide-progress"></div>
        <div class="slide active" id="slide-1">
            <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-4.0.3&amp;ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&amp;auto=format&fit=crop&amp;w=1170&q=80"
                alt="Coffee Beans" class="slide-image">
            <div class="slide-overlay"></div>
            <div class="slide-content">
                <div class="container mx-auto px-6">
                    <div class="max-w-3xl">
                        <span class="text-noir-accent uppercase tracking-widest font-medium mb-4 block">
                            <span data-lang="en">Premium Coffee Supplier</span>
                            <span data-lang="km">អ្នកផ្គត់ផ្គង់កាហ្វេគុណភាពខ្ពស់</span>
                        </span>
                        <h1 class="text-5xl md:text-7xl font-bold text-white mb-8 leading-tight font-syne animated-text">
                            <span data-lang="en">Elevate Your <span class="text-accent">Coffee</span> Experience</span>
                            <span data-lang="km">លើកកម្ពស់បទពិសោធន៍ <span class="text-accent">កាហ្វេ</span> របស់អ្នក</span>
                        </h1>
                        <p class="text-xl md:text-2xl text-gray-300 mb-12">
                            <span data-lang="en">From premium coffee beans to professional equipment, we provide everything
                                you need for the perfect coffee experience.</span>
                            <span data-lang="km">ពីគ្រាប់កាហ្វេពិសេស រហូតដល់ឧបករណ៍ជំនាញ
                                យើងផ្តល់ជូនអ្វីគ្រប់យ៉ាងដែលអ្នកត្រូវការសម្រាប់បទពិសោធន៍កាហ្វេដ៏ល្អឥតខ្ចោះ។</span>
                        </p>
                        <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-6">
                            <a href="{{ route('products.index') }}"
                                class="btn ripple bg-noir-accent text-noir-dark px-10 py-4 rounded-none text-center font-medium text-lg">
                                <span data-lang="en">Explore Products</span>
                                <span data-lang="km">ស្វែងរកផលិតផល</span>
                            </a>
                            <a href="#contact"
                                class="btn animated-border border-2 border-white text-white px-10 py-4 rounded-none text-center font-medium text-lg hover:border-noir-accent hover:text-noir-accent">
                                <span data-lang="en">Business Solutions</span>
                                <span data-lang="km">ដំណោះស្រាយអាជីវកម្ម</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="slide" id="slide-2">
            <img src="https://images.unsplash.com/photo-1511537190424-bbbab87ac5eb?ixlib=rb-4.0.3&amp;ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&amp;auto=format&fit=crop&amp;w=1170&q=80"
                alt="Coffee Shop" class="slide-image">
            <div class="slide-overlay"></div>
            <div class="slide-content">
                <div class="container mx-auto px-6">
                    <div class="max-w-3xl">
                        <span class="text-noir-accent uppercase tracking-widest font-medium mb-4 block">
                            <span data-lang="en">Business Solutions</span>
                            <span data-lang="km">ដំណោះស្រាយអាជីវកម្ម</span>
                        </span>
                        <h1 class="text-5xl md:text-7xl font-bold text-white mb-8 leading-tight font-syne animated-text">
                            <span data-lang="en">Complete <span class="text-accent">Cafe</span> Solutions</span>
                            <span data-lang="km">ដំណោះស្រាយ <span class="text-accent">ហាងកាហ្វេ</span> ពេញលេញ</span>
                        </h1>
                        <p class="text-xl md::text-2xl text-gray-300 mb-12">
                            <span data-lang="en">Everything you need to start or upgrade your coffee business. From
                                equipment to training and supplies.</span>
                            <span data-lang="km">អ្វីគ្រប់យ៉ាងដែលអ្នកត្រូវការដើម្បីចាប់ផ្តើម ឬដំឡើងអាជីវកម្មកាហ្វេរបស់អ្នក។
                                ពីឧបករណ៍ រហូតដល់ការបណ្តុះបណ្តាល និងសម្ភារៈ។</span>
                        </p>
                        <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-6">
                            <a href="#business"
                                class="btn ripple bg-noir-accent text-noir-dark px-10 py-4 rounded-none text-center font-medium text-lg">
                                <span data-lang="en">Business Account</span>
                                <span data-lang="km">គណនីអាជីវកម្ម</span>
                            </a>
                            <a href="#contact"
                                class="btn animated-border border-2 border-white text-white px-10 py-4 rounded-none text-center font-medium text-lg hover:border-noir-accent hover:text-noir-accent">
                                <span data-lang="en">Contact Sales</span>
                                <span data-lang="km">ទំនាក់ទំនងផ្នែកលក់</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="slide" id="slide-3">
            <img src="https://images.unsplash.com/photo-1498804103079-a6351b050096?ixlib=rb-4.0.3&amp;ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&amp;auto=format&fit=crop&amp;w=1170&q=80"
                alt="Coffee Brewing" class="slide-image">
            <div class="slide-overlay"></div>
            <div class="slide-content">
                <div class="container mx-auto px-6">
                    <div class="max-w-3xl">
                        <span class="text-noir-accent uppercase tracking-widest font-medium mb-4 block">
                            <span data-lang="en">Expert Training</span>
                            <span data-lang="km">ការបណ្តុះបណ្តាលអ្នកជំនាញ</span>
                        </span>
                        <h1 class="text-5xl md:text-7xl font-bold text-white mb-8 leading-tight font-syne animated-text">
                            <span data-lang="en">Master the <span class="text-accent">Art</span> of Coffee</span>
                            <span data-lang="km">ស្ទាត់ជំនាញ <span class="text-accent">សិល្បៈ</span> កាហ្វេ</span>
                        </h1>
                        <p class="text-xl md:text-2xl text-gray-300 mb-12">
                            <span data-lang="en">Join our professional barista training programs and learn from the best in
                                the industry.</span>
                            <span data-lang="km">ចូលរួមកម្មវិធីបណ្តុះបណ្តាលបារីស្តាអាជីពរបស់យើង
                                ហើយរៀនពីអ្នកជំនាញល្អបំផុតក្នុងឧស្សាហកម្មនេះ។</span>
                        </p>
                        <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-6">
                            <a href="#training"
                                class="btn ripple bg-noir-accent text-noir-dark px-10 py-4 rounded-none text-center font-medium text-lg">
                                <span data-lang="en">Training Programs</span>
                                <span data-lang="km">កម្មវិធីបណ្តុះបណ្តាល</span>
                            </a>
                            <a href="#workshops"
                                class="btn animated-border border-2 border-white text-white px-10 py-4 rounded-none text-center font-medium text-lg hover:border-noir-accent hover:text-noir-accent">
                                <span data-lang="en">Upcoming Workshops</span>
                                <span data-lang="km">សិក្ខាសាលាខាងមុខ</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="slide-number">
            <span class="current">01</span>
            <span>/</span>
            <span class="total">03</span>
        </div>
        <div class="slide-arrow prev" id="prev-slide">
            <i class="fas fa-chevron-left"></i>
        </div>
        <div class="slide-arrow next" id="next-slide">
            <i class="fas fa-chevron-right"></i>
        </div>
        <div class="slide-indicators">
            <div class="slide-indicator active" data-slide="1"></div>
            <div class="slide-indicator" data-slide="2"></div>
            <div class="slide-indicator" data-slide="3"></div>
        </div>
        <div class="scroll-down text-white text-center">
            <span class="text-sm uppercase tracking-widest">
                <span data-lang="en">Scroll Down</span>
                <span data-lang="km">រំកិលចុះក្រោម</span>
            </span>
            <div class="mt-2">
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>
    </section>

    <div id="popup-slideshow-modal"
        class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-[1000] hidden opacity-0 transition-opacity duration-500">
        <div class="bg-noir-dark rounded-lg shadow-lg relative w-11/12 max-w-4xl h-[80vh] overflow-hidden flex flex-col">
            <button id="popup-slideshow-close-btn"
                class="absolute top-4 right-4 text-white text-2xl z-20 hover:text-noir-accent transition-colors">
                <i class="fas fa-times"></i>
            </button>

            <div id="popup-slideshow-container" class="relative flex-1 overflow-hidden">
                <div
                    class="popup-slide absolute inset-0 transition-opacity duration-700 active opacity-100 flex items-center justify-center">
                    <img src="https://images.unsplash.com/photo-1501139082322-a18955a5c68f?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="Sponsorship Slide 1" class="w-full h-full object-cover">
                    <div
                        class="absolute inset-0 bg-black bg-opacity-40 flex flex-col items-center justify-center p-8 text-center">
                        <h2 class="text-4xl md:text-5xl font-bold text-white font-syne mb-4">
                            <span data-lang="en">Exclusive Partnership Offers!</span>
                            <span data-lang="km">ការផ្តល់ជូនភាពជាដៃគូផ្តាច់មុខ!</span>
                        </h2>
                        <p class="text-lg text-gray-300 max-w-2xl">
                            <span data-lang="en">Discover special deals from our trusted partners.</span>
                            <span data-lang="km">ស្វែងរកកិច្ចព្រមព្រៀងពិសេសពីដៃគូដែលគួរឱ្យទុកចិត្តរបស់យើង។</span>
                        </p>
                        <a href="#"
                            class="mt-6 btn ripple bg-noir-accent text-noir-dark px-8 py-3 rounded-full font-medium text-lg">
                            <span data-lang="en">Learn More</span>
                            <span data-lang="km">ស្វែងយល់បន្ថែម</span>
                        </a>
                    </div>
                </div>
                <div
                    class="popup-slide absolute inset-0 transition-opacity duration-700 opacity-0 flex items-center justify-center">
                    <img src="https://images.unsplash.com/photo-1521017432537-bfe0a92d2755?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="Sponsorship Slide 2" class="w-full h-full object-cover">
                    <div
                        class="absolute inset-0 bg-black bg-opacity-40 flex flex-col items-center justify-center p-8 text-center">
                        <h2 class="text-4xl md:text-5xl font-bold text-white font-syne mb-4">
                            <span data-lang="en">Join Our Barista Training!</span>
                            <span data-lang="km">ចូលរួមវគ្គបណ្តុះបណ្តាលបារីស្តារបស់យើង!</span>
                        </h2>
                        <p class="text-lg text-gray-300 max-w-2xl">
                            <span data-lang="en">Master the art of coffee brewing with our expert instructors.</span>
                            <span data-lang="km">ស្ទាត់ជំនាញសិល្បៈនៃការឆុងកាហ្វេជាមួយគ្រូបង្រៀនជំនាញរបស់យើង។</span>
                        </p>
                        <a href="#"
                            class="mt-6 btn ripple bg-noir-accent text-noir-dark px-8 py-3 rounded-full font-medium text-lg">
                            <span data-lang="en">Sign Up Today</span>
                            <span data-lang="km">ចុះឈ្មោះថ្ងៃនេះ</span>
                        </a>
                    </div>
                </div>
                <div
                    class="popup-slide absolute inset-0 transition-opacity duration-700 opacity-0 flex items-center justify-center">
                    <img src="https://images.unsplash.com/photo-1507133750040-4a6b777029ca?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="Sponsorship Slide 3" class="w-full h-full object-cover">
                    <div
                        class="absolute inset-0 bg-black bg-opacity-40 flex flex-col items-center justify-center p-8 text-center">
                        <h2 class="text-4xl md:text-5xl font-bold text-white font-syne mb-4">
                            <span data-lang="en">New Coffee Bean Arrivals!</span>
                            <span data-lang="km">គ្រាប់កាហ្វេថ្មីមកដល់ហើយ!</span>
                        </h2>
                        <p class="text-lg text-gray-300 max-w-2xl">
                            <span data-lang="en">Explore our latest selection of premium, ethically sourced beans.</span>
                            <span data-lang="km">ស្វែងយល់ពីជម្រើសគ្រាប់កាហ្វេពិសេសដែលទើបមកដល់ថ្មីរបស់យើង។</span>
                        </p>
                        <a href="#"
                            class="mt-6 btn ripple bg-noir-accent text-noir-dark px-8 py-3 rounded-full font-medium text-lg">
                            <span data-lang="en">Shop Now</span>
                            <span data-lang="km">ទិញឥឡូវនេះ</span>
                        </a>
                    </div>
                </div>
            </div>

            <button id="popup-slideshow-prev"
                class="absolute left-4 top-1/2 -translate-y-1/2 bg-noir-medium text-white p-3 rounded-full z-10 hover:bg-noir-accent hover:text-noir-dark transition-colors">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button id="popup-slideshow-next"
                class="absolute right-4 top-1/2 -translate-y-1/2 bg-noir-medium text-white p-3 rounded-full z-10 hover:bg-noir-accent hover:text-noir-dark transition-colors">
                <i class="fas fa-chevron-right"></i>
            </button>

            <div id="popup-slideshow-indicators" class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2 z-10">
                <div class="popup-indicator w-3 h-3 bg-white rounded-full cursor-pointer opacity-50 active"></div>
                <div class="popup-indicator w-3 h-3 bg-white rounded-full cursor-pointer opacity-50"></div>
                <div class="popup-indicator w-3 h-3 bg-white rounded-full cursor-pointer opacity-50"></div>
            </div>
        </div>
    </div>
    <div class="running-text-container">
        <div class="running-text">
            <div class="running-text-item">
                <i class="fas fa-truck"></i>
                <span data-lang="en">Free shipping on orders over $100</span>
                <span data-lang="km">ដឹកជញ្ជូនឥតគិតថ្លៃសម្រាប់ការបញ្ជាទិញលើសពី ១០០ ដុល្លារ</span>
            </div>
            <div class="running-text-item">
                <i class="fas fa-medal"></i>
                <span data-lang="en">Premium quality, ethically sourced beans</span>
                <span data-lang="km">គុណភាពខ្ពស់ គ្រាប់កាហ្វេប្រភពប្រកបដោយក្រមសីលធម៌</span>
            </div>
            <div class="running-text-item">
                <i class="fas fa-percentage"></i>
                <span data-lang="en">15% off for new business customers</span>
                <span data-lang="km">បញ្ចុះតម្លៃ ១៥% សម្រាប់អតិថិជនអាជីវកម្មថ្មី</span>
            </div>
            <div class="running-text-item">
                <i class="fas fa-star"></i>
                <span data-lang="en">Join our loyalty program for exclusive rewards</span>
                <span data-lang="km">ចូលរួមកម្មវិធីភក្តីភាពរបស់យើងសម្រាប់រង្វាន់ផ្តាច់មុខ</span>
            </div>
            <div class="running-text-item">
                <i class="fas fa-calendar"></i>
                <span data-lang="en">Monthly barista workshops - Register now!</span>
                <span data-lang="km">សិក្ខាសាលាបារីស្តាប្រចាំខែ - ចុះឈ្មោះឥឡូវនេះ!</span>
            </div>
        </div>
    </div>

    <section class="py-12 bg-noir-medium"> {{-- Changed py-16 to py-12 for smaller vertical padding --}}
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16">
                <div>
                    <span class="text-noir-accent uppercase tracking-widest font-medium mb-4 block">
                        <span data-lang="en">Our Selection</span>
                        <span data-lang="km">ជម្រើសរបស់យើង</span>
                    </span>
                    <h2 class="text-4xl md:text-5xl font-bold text-white mb-4 section-title font-syne">
                        <span data-lang="en">Premium Coffee Selection</span>
                        <span data-lang="km">ជម្រើសកាហ្វេពិសេស</span>
                    </h2>
                </div>
                <a href="{{ route('products.index') }}" {{-- Changed from # to products.index route --}}
                    class="text-noir-accent hover:text-white transition-colors flex items-center mt-6 md:mt-0 group">
                    <span class="mr-2">
                        <span data-lang="en">View All Categories</span>
                        <span data-lang="km">មើលប្រភេទទាំងអស់</span>
                    </span>
                    <i class="fas fa-arrow-right transform group-hover:translate-x-2 transition-transform"></i>
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4 gap-6 md:gap-10">
                {{-- Kept original grid for categories --}}
                @foreach ($categories as $category)
                    {{-- Changed the div to an anchor tag to make the whole card clickable --}}
                    <a href="{{ route('products.index', ['category' => $category->id]) }}" {{-- CHANGED: Pass category ID as query parameter --}}
                        class="hover-lift hover-glow bg-noir-light rounded-lg overflow-hidden reveal active shine"
                        style="transition-delay: {{ $loop->iteration * 0.1 }}s;">
                        <div class="image-hover h-60 overflow-hidden">
                            {{-- Use category image_url if available, otherwise fallback to placeholder --}}
                            <img src="{{ $category->image_url ? asset('storage/' . $category->image_url) : 'https://placehold.co/1000x640/1A1A1A/D4A95C?text=' . urlencode($category->name_en) }}"
                                alt="{{ $category->name_en }}" class="w-full h-full object-cover"
                                onerror="this.onerror=null;this.src='https://placehold.co/1000x640/1A1A1A/D4A95C?text=Image+Load+Error';">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-white font-syne">
                                <span data-lang="en">{{ $category->name_en }}</span>
                                <span data-lang="km">{{ $category->name_km ?? $category->name_en }}</span>
                                {{-- Fallback to EN if KM is null --}}
                            </h3>
                            <div class="flex items-center mt-4 text-noir-accent font-medium group">
                                <span>
                                    <span data-lang="en">View Selection</span>
                                    <span data-lang="km">មើលជម្រើស</span>
                                </span>
                                <i
                                    class="fas fa-arrow-right ml-2 transform group-hover:translate-x-3 transition-transform"></i>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section id="products" class="py-24 bg-noir-dark">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16">
                <div>
                    <span class="text-noir-accent uppercase tracking-widest font-medium mb-4 block">
                        <span data-lang="en">Shop Now</span>
                        <span data-lang="km">ទិញឥឡូវនេះ</span>
                    </span>
                    <h2 class="text-4xl md:text-5xl font-bold text-white mb-4 section-title font-syne">
                        <span data-lang="en">Featured Products</span>
                        <span data-lang="km">ផលិតផលលេចធ្លោ</span>
                    </h2>
                </div>
                <a href="{{ route('products.index') }}"
                    class="text-noir-accent hover:text-white transition-colors flex items-center mt-6 md:mt-0 group">
                    <span class="mr-2">
                        <span data-lang="en">View All Products</span>
                        <span data-lang="km">មើលផលិតផលទាំងអស់</span>
                    </span>
                    <i class="fas fa-arrow-right transform group-hover:translate-x-2 transition-transform"></i>
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 xl:grid-cols-6 gap-8"> {{-- Adjusted lg:grid-cols-4 to lg:grid-cols-5 and xl:grid-cols-5 to xl:grid-cols-6 --}}
                @foreach ($featuredProducts->take(6) as $product)
                    {{-- Added ->take(6) to limit to 6 products --}}
                    <div class="product-card bg-noir-medium rounded-lg overflow-hidden shadow-lg relative hover-lift reveal active"
                        style="transition-delay: {{ $loop->iteration * 0.1 }}s;">
                        @if ($product->is_bestseller)
                            <div class="product-badge badge-bestseller">
                                <span data-lang="en">Bestseller</span>
                                <span data-lang="km">លក់ដាច់បំផុត</span>
                            </div>
                        @elseif($product->is_organic)
                            <div class="product-badge badge-organic">
                                <span data-lang="en">Organic</span>
                                <span data-lang="km">សរីរាង្គ</span>
                            </div>
                        @elseif($product->is_new)
                            <div class="product-badge badge-new">
                                <span data-lang="en">New</span>
                                <span data-lang="km">ថ្មី</span>
                            </div>
                        @endif
                        <div class="image-hover h-60 overflow-hidden">
                            <a href="{{ route('products.show', $product->id) }}">
                                <img src="{{ $product->image_url ? asset('storage/' . $product->image_url) : 'https://placehold.co/600x400/2A2A2A/D4A95C?text=No+Image' }}"
                                    alt="{{ $product->name_en }}" class="w-full h-full object-cover"
                                    onerror="this.onerror=null;this.src='https://placehold.co/600x400/2A2A2A/D4A95C?text=Image+Load+Error';">
                            </a>
                        </div>
                        <div class="p-6 relative">
                            {{-- Flex container for name, description, and price --}}
                            <div class="flex flex-col h-full">
                                <h3 class="text-2xl font-semibold text-white font-syne mb-2 truncate">
                                    <span data-lang="en">{{ $product->name_en }}</span>
                                    <span data-lang="km">{{ $product->name_km ?? $product->name_en }}</span>
                                </h3>

                                <div class="flex items-center justify-between mt-auto"> {{-- mt-auto pushes price to bottom --}}
                                    <span
                                        class="text-noir-accent text-1xl font-bold">${{ number_format($product->price, 2) }}</span>
                                    @if ($product->old_price)
                                        <span
                                            class="text-gray-300 line-through">${{ number_format($product->old_price, 2) }}</span>
                                    @endif
                                </div>
                            </div>
                            <div
                                class="product-overlay absolute bottom-0 left-0 right-0 p-6 flex justify-center items-center">
                                <button type="button"
                                    class="add-to-cart-btn ripple bg-noir-accent hover:bg-white text-noir-dark font-medium py-3 px-6 rounded-full transition-colors"
                                    data-product-id="{{ $product->id }}" data-product-name="{{ $product->name_en }}"
                                    {{-- Use name_en for JS --}} data-product-price="{{ $product->price }}"
                                    {{-- CORRECTED: Pass only the relative path for the image --}}
                                    data-product-image="{{ $product->image_url ?? 'https://placehold.co/100x100/D4A95C/0F0F0F?text=Product' }}">
                                    <span data-lang="en">Add to Cart</span>
                                    <span data-lang="km">បន្ថែមទៅរទេះ</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-16">
                <a href="{{ route('products.index') }}"
                    class="btn animated-border border-2 border-white text-white px-10 py-4 rounded-none text-center font-medium text-lg hover:border-noir-accent hover:text-noir-accent">
                    <span data-lang="en">View All Products</span>
                    <span data-lang="km">មើលផលិតផលទាំងអស់</span>
                </a>
            </div>
        </div>
    </section>

    <section class="py-24 bg-noir-medium">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <span class="text-noir-accent uppercase tracking-widest font-medium mb-4 block">
                    <span data-lang="en">Why Choose Us</span>
                    <span data-lang="km">ហេតុអ្វីជ្រើសរើសយើង</span>
                </span>
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-4 section-title section-title-center font-syne">
                    <span data-lang="en">Our Commitment to Quality</span>
                    <span data-lang="km">ការប្តេជ្ញាចិត្តរបស់យើងចំពោះគុណភាព</span>
                </h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 text-center">
                <div class="feature-card flex flex-col items-center reveal active" style="transition-delay: 0.1s;">
                    <div class="feature-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white font-syne mb-4">
                        <span data-lang="en">Ethically Sourced</span>
                        <span data-lang="km">ប្រភពប្រកបដោយក្រមសីលធម៌</span>
                    </h3>
                    <p class="text-gray-300">
                        <span data-lang="en">We partner with farms committed to sustainable and fair trade
                            practices.</span>
                        <span data-lang="km">យើងសហការជាមួយកសិដ្ឋានដែលប្តេជ្ញាចិត្តចំពោះការអនុវត្តប្រកបដោយនិរន្តរភាព
                            និងពាណិជ្ជកម្មយុត្តិធម៌។</span>
                    </p>
                </div>
                <div class="feature-card flex flex-col items-center reveal active" style="transition-delay: 0.2s;">
                    <div class="feature-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white font-syne mb-4">
                        <span data-lang="en">Premium Quality</span>
                        <span data-lang="km">គុណភាពពិសេស</span>
                    </h3>
                    <p class="text-gray-300">
                        <span data-lang="en">Only the finest beans and equipment make it into our selection.</span>
                        <span data-lang="km">មានតែគ្រាប់កាហ្វេ និងឧបករណ៍ល្អបំផុតប៉ុណ្ណោះដែលត្រូវបានជ្រើសរើស។</span>
                    </p>
                </div>
                <div class="feature-card flex flex-col items-center reveal active" style="transition-delay: 0.3s;">
                    <div class="feature-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white font-syne mb-4">
                        <span data-lang="en">Expert Support</span>
                        <span data-lang="km">ការគាំទ្រពីអ្នកជំនាញ</span>
                    </h3>
                    <p class="text-gray-300">
                        <span data-lang="en">Our team of experts is always ready to assist you with any query.</span>
                        <span data-lang="km">ក្រុមអ្នកជំនាញរបស់យើងតែងតែត្រៀមខ្លួនជួយអ្នកជាមួយនឹងសំណួរណាមួយ។</span>
                    </p>
                </div>
                <div class="feature-card flex flex-col items-center reveal active" style="transition-delay: 0.4s;">
                    <div class="feature-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white font-syne mb-4">
                        <span data-lang="en">Fast Delivery</span>
                        <span data-lang="km">ដឹកជញ្ជូនលឿន</span>
                    </h3>
                    <p class="text-gray-300">
                        <span data-lang="en">Reliable and express delivery services to your doorstep.</span>
                        <span data-lang="km">សេវាកម្មដឹកជញ្ជូនរហ័ស និងគួរឱ្យទុកចិត្តដល់មាត់ទ្វាររបស់អ្នក។</span>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-noir-dark">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <span class="text-noir-accent uppercase tracking-widest font-medium mb-4 block">
                    <span data-lang="en">What Our Customers Say</span>
                    <span data-lang="km">អ្វីដែលអតិថិជនរបស់យើងនិយាយ</span>
                </span>
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-4 section-title section-title-center font-syne">
                    <span data-lang="en">Trusted by Coffee Lovers</span>
                    <span data-lang="km">ជឿទុកចិត្តដោយអ្នកស្រឡាញ់កាហ្វេ</span>
                </h2>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 sm:grid-cols-2 gap-10">
                <div class="testimonial-card bg-noir-medium reveal active" style="transition-delay: 0.1s;">
                    <p class="text-lg text-gray-300 mb-6">
                        <span data-lang="en">"The best coffee beans I've ever tasted! Their Arabica selection is simply
                            divine. Highly recommend for any coffee enthusiast."</span>
                        <span data-lang="km">"គ្រាប់កាហ្វេល្អបំផុតដែលខ្ញុំធ្លាប់ភ្លក់! ជម្រើស Arabica
                            របស់ពួកគេពិតជាអស្ចារ្យ។ ណែនាំយ៉ាងខ្លាំងសម្រាប់អ្នកចូលចិត្តកាហ្វេ។"</span>
                    </p>
                    <div class="flex items-center">
                        <img src="https://placehold.co/50x50/D4A95C/0F0F0F?text=JD" alt="John Doe"
                            class="rounded-full w-12 h-12 object-cover mr-4">
                        <div>
                            <p class="font-semibold text-white">
                                <span data-lang="en">John Doe</span>
                                <span data-lang="km">ចន ដូ</span>
                            </p>
                            <p class="text-sm text-noir-accent">
                                <span data-lang="en">Coffee Enthusiast</span>
                                <span data-lang="km">អ្នកចូលចិត្តកាហ្វេ</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card bg-noir-medium reveal active" style="transition-delay: 0.2s;">
                    <p class="text-lg text-gray-300 mb-6">
                        <span data-lang="en">"NOIRCOFFEE provides exceptional service and top-notch machines. Our cafe's
                            efficiency has significantly improved since we switched to them."</span>
                        <span data-lang="km">"NOIRCOFFEE ផ្តល់សេវាកម្មពិសេស និងម៉ាស៊ីនគុណភាពខ្ពស់។
                            ប្រសិទ្ធភាពហាងកាហ្វេរបស់យើងបានប្រសើរឡើងគួរឱ្យកត់សម្គាល់ចាប់តាំងពីយើងប្តូរមកប្រើពួកគេ។"</span>
                    </p>
                    <div class="flex items-center">
                        <img src="https://placehold.co/50x50/D4A95C/0F0F0F?text=CS" alt="Cafe Owner"
                            class="rounded-full w-12 h-12 object-cover mr-4">
                        <div>
                            <p class="font-semibold text-white">
                                <span data-lang="en">Cafe Solutions</span>
                                <span data-lang="km">ដំណោះស្រាយហាងកាហ្វេ</span>
                            </p>
                            <p class="text-sm text-noir-accent">
                                <span data-lang="en">Business Client</span>
                                <span data-lang="km">អតិថិជនអាជីវកម្ម</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card bg-noir-medium reveal active" style="transition-delay: 0.3s;">
                    <p class="text-lg text-gray-300 mb-6">
                        <span data-lang="en">"Their barista training transformed my skills. I feel much more confident now.
                            Highly professional and engaging instructors!"</span>
                        <span data-lang="km">"ការបណ្តុះបណ្តាលបារីស្តារបស់ពួកគេបានផ្លាស់ប្តូរជំនាញរបស់ខ្ញុំ។
                            ខ្ញុំមានអារម្មណ៍ជឿជាក់ជាងមុន។ គ្រូបង្រៀនមានជំនាញវិជ្ជាជីវៈខ្ពស់ និងទាក់ទាញ!"</span>
                    </p>
                    <div class="flex items-center">
                        <img src="https://placehold.co/50x50/D4A95C/0F0F0F?text=SK" alt="Sarah K."
                            class="rounded-full w-12 h-12 object-cover mr-4">
                        <div>
                            <p class="font-semibold text-white">
                                <span data-lang="en">Sarah K.</span>
                                <span data-lang="km">សារ៉ា ខេ</span>
                            </p>
                            <p class="text-sm text-noir-accent">
                                <span data-lang="en">Aspiring Barista</span>
                                <span data-lang="km">បារីស្តាដែលប្រាថ្នា</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="py-24 bg-noir-dark">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <span class="text-noir-accent uppercase tracking-widest font-medium mb-4 block">
                    <span data-lang="en">Get in Touch</span>
                    <span data-lang="km">ទាក់ទងមកយើង</span>
                </span>
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-4 section-title section-title-center font-syne">
                    <span data-lang="en">Contact Us</span>
                    <span data-lang="km">ទំនាក់ទំនងយើង</span>
                </h2>
            </div>
            <div class="max-w-3xl mx-auto bg-noir-light p-8 rounded-lg shadow-lg reveal active">
                <form class="space-y-6">
                    <div>
                        <label for="name" class="block text-white text-sm font-medium mb-2">
                            <span data-lang="en">Name</span>
                            <span data-lang="km">ឈ្មោះ</span>
                        </label>
                        <input type="text" id="name" name="name"
                            class="w-full p-3 rounded-md bg-noir-dark border border-noir-muted text-white focus:outline-none focus:border-noir-accent">
                    </div>
                    <div>
                        <label for="email" class="block text-white text-sm font-medium mb-2">
                            <span data-lang="en">Email</span>
                            <span data-lang="km">អ៊ីមែល</span>
                        </label>
                        <input type="email" id="email" name="email"
                            class="w-full p-3 rounded-md bg-noir-dark border border-noir-muted text-white focus:outline-none focus:border-noir-accent">
                    </div>
                    <div>
                        <label for="message" class="block text-white text-sm font-medium mb-2">
                            <span data-lang="en">Message</span>
                            <span data-lang="km">សារ</span>
                        </label>
                        <textarea id="message" name="message" rows="5"
                            class="w-full p-3 rounded-md bg-noir-dark border border-noir-muted text-white focus:outline-none focus:border-noir-accent"></textarea>
                    </div>
                    <button type="submit"
                        class="btn ripple bg-noir-accent text-noir-dark px-8 py-3 rounded-full font-medium text-lg w-full">
                        <span data-lang="en">Send Message</span>
                        <span data-lang="km">ផ្ញើសារ</span>
                    </button>
                </form>
            </div>
        </div>
    </section>


    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Check if there's a flashed success message from the session
                @if (session('success_message'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: "{{ session('success_message') }}",
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                        customClass: {
                            popup: 'swal2-toast-popup', // Custom class for styling
                        }
                    });
                @endif

                // Get CSRF token from meta tag
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Add to Cart Button Logic
                document.querySelectorAll('.add-to-cart-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const productId = this.dataset.productId;
                        const productName = this.dataset.productName;
                        const productPrice = this.dataset.productPrice;
                        const productImage = this.dataset
                            .productImage; // This will be the relative path or placeholder URL

                        // Disable button and show loading feedback
                        this.disabled = true;
                        this.textContent = 'Adding...';

                        fetch(`{{ url('/cart/add') }}/${productId}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: JSON.stringify({
                                    quantity: 1, // Default quantity for initial add
                                    name: productName,
                                    price: productPrice,
                                    image: productImage // Pass the image path/URL directly from data-attribute
                                })
                            })
                            .then(response => {
                                // Re-enable button regardless of success/failure
                                button.disabled = false;
                                button.textContent = 'Add to Cart';

                                if (response.status === 401) { // Unauthorized
                                    return response.json().then(data => {
                                        Swal.fire({
                                            icon: 'info',
                                            title: 'Login Required',
                                            text: data.message,
                                            confirmButtonText: 'Go to Login',
                                            confirmButtonColor: '#D4A95C',
                                            allowOutsideClick: false,
                                            allowEscapeKey: false
                                        }).then((result) => {
                                            if (result.isConfirmed && data
                                                .redirect) {
                                                window.location.href = data
                                                    .redirect;
                                            }
                                        });
                                        return Promise.reject(
                                            'Unauthorized'); // Stop further processing
                                    });
                                }
                                if (!response.ok) {
                                    return response.json().then(err => Promise.reject(err));
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Added to Cart!',
                                        text: data.message,
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 2000,
                                        timerProgressBar: true,
                                    });
                                    // Call the global updateCartCount function (defined in master.blade.php)
                                    if (typeof updateCartCount === 'function') {
                                        updateCartCount();
                                    } else {
                                        console.warn(
                                            'updateCartCount function not found. Cart count in header may not update.'
                                        );
                                    }
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: data.message,
                                        confirmButtonColor: '#D4A95C'
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error adding to cart:', error);
                                // Only show generic error if not handled by 401 redirect
                                if (error !== 'Unauthorized') {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Failed to Add!',
                                        text: error.message ||
                                            'Could not add item to cart. Please try again.',
                                        confirmButtonColor: '#D4A95C'
                                    });
                                }
                            });
                    });
                });
            });
        </script>
    @endpush
@endsection
