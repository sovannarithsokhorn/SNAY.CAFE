document.addEventListener('DOMContentLoaded', () => {
    // Mobile Menu Toggle
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileCloseButton = document.getElementById('mobile-close');

    if (mobileMenuButton && mobileMenu && mobileCloseButton) {
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.remove('hidden');
        });

        mobileCloseButton.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
        });

        // Close mobile menu when a link is clicked
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
            });
        });
    }

    // Language Switcher
    const languageToggle = document.getElementById('language-toggle');
    const languageOptions = document.querySelector('.language-options');
    const languageOptionsDivs = document.querySelectorAll('.language-option');
    const body = document.body;
    const currentLangDisplay = document.getElementById('current-lang');

    if (languageToggle) {
        languageToggle.addEventListener('click', (e) => {
            e.stopPropagation(); // Prevent document click from closing immediately
            languageOptions.classList.toggle('opacity-0');
            languageOptions.classList.toggle('visibility-hidden');
            languageOptions.classList.toggle('translate-y-10');
        });
    }

    languageOptionsDivs.forEach(option => {
        option.addEventListener('click', () => {
            const langCode = option.dataset.langCode;
            // Remove existing language class (en or km)
            body.className = body.className.replace(/(en|km)/g, '').trim();
            body.classList.add(langCode); // Add new language class

            languageOptionsDivs.forEach(opt => opt.classList.remove('active'));
            option.classList.add('active');

            // Close dropdown after selection
            languageOptions.classList.add('opacity-0');
            languageOptions.classList.add('visibility-hidden');
            languageOptions.classList.add('translate-y-10');

            // Update the displayed language in the toggle button
            currentLangDisplay.textContent = langCode.toUpperCase();
        });
    });

    // Close language switcher when clicking outside
    document.addEventListener('click', (e) => {
        if (languageOptions && !languageOptions.contains(e.target) && (!languageToggle || !languageToggle.contains(e.target))) {
            languageOptions.classList.add('opacity-0');
            languageOptions.classList.add('visibility-hidden');
            languageOptions.classList.add('translate-y-10');
        }
    });

    // Set initial language based on browser or default to English
    const userLang = navigator.language.split('-')[0];
    let initialLang = 'en'; // Default to English
    if (userLang === 'km') {
        initialLang = 'km';
    }
    
    // Apply initial language class to body
    body.classList.add(initialLang);
    currentLangDisplay.textContent = initialLang.toUpperCase();

    // Set active class for the initial language option
    languageOptionsDivs.forEach(option => {
        if (option.dataset.langCode === initialLang) {
            option.classList.add('active');
        } else {
            option.classList.remove('active');
        }
    });

    // JavaScript for Sticky Header
    window.addEventListener('scroll', () => {
        const header = document.querySelector('header'); // Select the header element
        if (header) {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        }
    });

    // JavaScript for Reveal Animations (Intersection Observer)
    const revealElements = document.querySelectorAll('.reveal');

    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    revealElements.forEach(el => observer.observe(el));

    // JavaScript for Scroll Progress Indicator (if you have one)
    const scrollProgress = document.querySelector('.scroll-progress');
    if (scrollProgress) {
        window.addEventListener('scroll', () => {
            const totalHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const progress = (window.scrollY / totalHeight) * 100;
            scrollProgress.style.width = progress + '%';
        });
    }

    // JavaScript for Product Filtering (from new-2-html)
    const filterButtons = document.querySelectorAll('.filter-btn');
    const productGrid = document.getElementById('product-grid');
    const productCards = document.querySelectorAll('.product-card');

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            const filter = button.dataset.filter;
            productCards.forEach(card => {
                if (filter === 'all' || card.dataset.category === filter) {
                    card.style.display = 'block'; // Show element
                } else {
                    card.style.display = 'none'; // Hide element
                }
            });
        });
    });

    // JavaScript for Product Sorting (from new-2-html)
    const sortToggle = document.getElementById('sort-toggle');
    const sortMenu = document.getElementById('sort-menu');
    const sortItems = document.querySelectorAll('.sort-dropdown-item');

    if (sortToggle) {
        sortToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            sortMenu.parentElement.classList.toggle('active');
        });
    }

    sortItems.forEach(item => {
        item.addEventListener('click', () => {
            sortItems.forEach(i => i.classList.remove('active'));
            item.classList.add('active');
            
            const sortType = item.dataset.sort;
            // Get the text content of the span corresponding to the current language
            const currentLang = body.classList.contains('km') ? 'km' : 'en';
            const currentTextSpan = item.querySelector(`span[data-lang="${currentLang}"]`);
            const currentText = currentTextSpan ? currentTextSpan.textContent : ''; // Fallback if span not found

            // Update the sort toggle text with the selected item's text
            sortToggle.innerHTML = `<span data-lang="${currentLang}">Sort by: ${currentText}</span><i class="fas fa-chevron-down ml-2 text-xs"></i>`;
            
            sortProducts(sortType);
            sortMenu.parentElement.classList.remove('active');
        });
    });

    document.addEventListener('click', (e) => {
        if (sortMenu && !sortMenu.contains(e.target) && !sortToggle.contains(e.target)) {
            sortMenu.parentElement.classList.remove('active');
        }
    });

    function sortProducts(sortType) {
        const productsArray = Array.from(productCards);

        productsArray.sort((a, b) => {
            const priceA = parseFloat(a.dataset.price);
            const priceB = parseFloat(b.dataset.price);
            const nameA = a.dataset.name.toLowerCase();
            const nameB = b.dataset.name.toLowerCase();

            if (sortType === 'price-asc') {
                return priceA - priceB;
            } else if (sortType === 'price-desc') {
                return priceB - priceA;
            } else if (sortType === 'name-asc') {
                return nameA.localeCompare(nameB);
            } else if (sortType === 'name-desc') {
                return nameB.localeCompare(a);
            }
            return 0; // Featured or default order
        });

        // Re-append sorted products to the grid
        productsArray.forEach(card => productGrid.appendChild(card));
    }

    // JavaScript for Grid/List View Toggle (from new-2-html)
    const gridViewBtn = document.getElementById('grid-view-btn');
    const listViewBtn = document.getElementById('list-view-btn');

    if (gridViewBtn) {
        gridViewBtn.addEventListener('click', () => {
            gridViewBtn.classList.add('active');
            listViewBtn.classList.remove('active');
            productGrid.classList.remove('product-list-view');
            productGrid.classList.add('grid-cols-1', 'sm:grid-cols-2', 'lg:grid-cols-3', 'xl:grid-cols-4');
        });
    }

    if (listViewBtn) {
        listViewBtn.addEventListener('click', () => {
            listViewBtn.classList.add('active');
            gridViewBtn.classList.remove('active');
            productGrid.classList.add('product-list-view');
            productGrid.classList.remove('grid-cols-1', 'sm:grid-cols-2', 'lg:grid-cols-3', 'xl:grid-cols-4');
        });
    }

    // JavaScript for Quick View Modal (from new-2-html)
    const quickViewButtons = document.querySelectorAll('.quick-view-btn');
    const quickViewModal = document.getElementById('quick-view-modal');
    const quickViewCloseBtn = document.getElementById('quick-view-close-btn');
    const quickViewTitle = document.getElementById('quick-view-title');
    const quickViewPrice = document.getElementById('quick-view-price');
    const quickViewDescription = document.getElementById('quick-view-description');
    const quickViewMainImg = document.getElementById('quick-view-main-img');
    const productQtyInput = document.getElementById('product-qty');
    const decreaseQtyBtn = document.getElementById('decrease-qty');
    const increaseQtyBtn = document.getElementById('increase-qty');
    const colorOptionsContainer = document.querySelector('#quick-view-options .mb-4 .flex.gap-2'); 
    const sizeOptionsContainer = document.querySelector('#quick-view-options .mb-6 .flex.gap-2'); 

    // Example product data (replace with actual data fetching in a real app)
    // In a Laravel app, this data would be fetched from your backend API
    const productData = {
        "Ethiopian Yirgacheffe": {
            title: { en: "Ethiopian Yirgacheffe", km: "អេត្យូពី យីហ្គាឆេហ្វ" },
            price: "$25.00",
            description: { en: "A light roast with delicate floral notes and a bright citrus finish, offering a truly exquisite coffee experience.", km: "កាហ្វេអាំងស្រាលៗ ជាមួយនឹងរសជាតិផ្កាដ៏ស្រទន់ និងរសជាតិក្រូចឆ្មារ ដែលផ្តល់នូវបទពិសោធន៍កាហ្វេដ៏អស្ចារ្យ។" },
            images: [
                "https://placehold.co/600x400/2A2A2A/D4A95C?text=Ethiopian+Yirgacheffe+1",
                "https://placehold.co/80x80/2A2A2A/D4A95C?text=EY+Thumb+2",
                "https://placehold.co/80x80/2A2A2A/D4A95C?text=EY+Thumb+3"
            ],
            colors: [{ name: { en: "Brown", km: "ត្នោត" }, hex: "#8B4513" }, { name: { en: "Dark", km: "ខ្មៅ" }, hex: "#0F0F0F" }],
            sizes: [{ name: { en: "250g", km: "២៥០ក្រាម" } }, { name: { en: "500g", km: "៥០០ក្រាម" } }]
        },
        "Colombian Supremo": {
            title: { en: "Colombian Supremo", km: "កូឡុំប៊ី ស៊ូព្រីម៉ូ" },
            price: "$22.50",
            description: { en: "A classic medium roast, known for its rich chocolatey flavor and subtle nutty undertones, a perfect everyday brew.", km: "កាហ្វេអាំងមធ្យមបែបបុរាណ ល្បីល្បាញដោយសាររសជាតិសូកូឡាដ៏សម្បូរបែប និងរសជាតិគ្រាប់ធញ្ញជាតិដ៏ឈ្ងុយឆ្ងាញ់ ដែលល្អឥតខ្ចោះសម្រាប់ផឹកប្រចាំថ្ងៃ។" },
            images: [
                "https://placehold.co/600x400/2A2A2A/D4A95C?text=Colombian+Supremo+1",
                "https://placehold.co/80x80/2A2A2A/D4A95C?text=CS+Thumb+2",
                "https://placehold.co/80x80/2A2A2A/D4A95C?text=CS+Thumb+3"
            ],
            colors: [{ name: { en: "Brown", km: "ត្នោត" }, hex: "#8B4513" }, { name: { en: "Light Brown", km: "ត្នោតស្រាល" }, hex: "#A0522D" }],
            sizes: [{ name: { en: "250g", km: "២៥០ក្រាម" } }, { name: "500g", km: "៥០០ក្រាម" }]
        },
        "Sumatra Mandheling": {
            title: { en: "Sumatra Mandheling", km: "ស៊ូម៉ាត្រា ម៉ាន់ហេលីង" },
            price: "$28.00",
            description: { en: "A bold dark roast with earthy and herbaceous notes, boasting a full body and remarkably low acidity.", km: "កាហ្វេអាំងខ្មៅដ៏ខ្លាំងក្លា ជាមួយនឹងរសជាតិដី និងរុក្ខជាតិ ដែលមានជាតិអាស៊ីតទាបគួរឱ្យកត់សម្គាល់។" },
            images: [
                "https://placehold.co/600x400/2A2A2A/D4A95C?text=Sumatra+Mandheling+1",
                "https://placehold.co/80x80/2A2A2A/D4A95C?text=SM+Thumb+2",
                "https://placehold.co/80x80/2A2A2A/D4A95C?text=SM+Thumb+3"
            ],
            colors: [{ name: { en: "Dark Brown", km: "ត្នោតខ្មៅ" }, hex: "#654321" }],
        sizes: [{ name: { en: "250g", km: "២៥០ក្រាម" } }, { name: { en: "500g", km: "៥០០ក្រាម" } }]
        },
        "French Press": {
            title: { en: "French Press", km: "ម៉ាស៊ីនឆុងកាហ្វេបារាំង" },
            price: "$45.00",
            description: { en: "Craft rich, full-bodied coffee with ease using our durable 8-cup French Press, featuring a sleek, modern design.", km: "ឆុងកាហ្វេដែលមានរសជាតិឈ្ងុយឆ្ងាញ់ និងពេញលេញយ៉ាងងាយស្រួលដោយប្រើម៉ាស៊ីនឆុងកាហ្វេបារាំងចំណុះ ៨ ពែងរបស់យើង ដែលមានការរចនាបែបទំនើប។" },
            images: [
                "https://placehold.co/600x400/2A2A2A/D4A95C?text=French+Press+1",
                "https://placehold.co/80x80/2A2A2A/D4A95C?text=FP+Thumb+2",
                "https://placehold.co/80x80/2A2A2A/D4A95C?text=FP+Thumb+3"
            ],
            colors: [{ name: { en: "Black", km: "ខ្មៅ" }, hex: "#0F0F0F" }, { name: { en: "Silver", km: "ប្រាក់" }, hex: "#C0C0C0" }],
            sizes: [{ name: { en: "8-Cup", km: "៨ពែង" } }, { name: "12-Cup", km: "១២ពែង" }]
        },
        "Brazilian Santos": {
            title: { en: "Brazilian Santos", km: "ប្រេស៊ីល សាន់តូស" },
            price: "$30.00",
            oldPrice: "$35.00",
            description: { en: "A classic Brazilian coffee with a mild, nutty flavor and low acidity, perfect for a smooth and balanced cup.", km: "កាហ្វេប្រេស៊ីលបែបបុរាណ ជាមួយនឹងរសជាតិគ្រាប់ធញ្ញជាតិស្រាល និងជាតិអាស៊ីតទាប ល្អឥតខ្ចោះសម្រាប់កាហ្វេដែលមានរសជាតិរលោង និងមានតុល្យភាព។" },
            images: [
                "https://placehold.co/600x400/2A2A2A/D4A95C?text=Brazilian+Santos+1",
                "https://placehold.co/80x80/2A2A2A/D4A95C?text=BS+Thumb+2",
                "https://placehold.co/80x80/2A2A2A/D4A95C?text=BS+Thumb+3"
            ],
            colors: [{ name: { en: "Brown", km: "ត្នោត" }, hex: "#8B4513" }],
            sizes: [{ name: { en: "250g", km: "២៥០ក្រាម" } }, { name: { en: "500g", km: "៥០០ក្រាម" } }]
        },
        "Decaf Espresso Blend": {
            title: { en: "Decaf Espresso Blend", km: "កាហ្វេ Decaf Espresso" },
            price: "$20.00",
            description: { en: "Enjoy the rich, smooth flavor of espresso without the caffeine. Our decaf blend is perfect for any time of day.", km: "រីករាយជាមួយរសជាតិ Espresso ដ៏ឈ្ងុយឆ្ងាញ់ ដោយគ្មានជាតិកាហ្វេអ៊ីន។ កាហ្វេ Decaf របស់យើងល្អឥតខ្ចោះសម្រាប់គ្រប់ពេលនៃថ្ងៃ។" },
            images: [
                "https://placehold.co/600x400/2A2A2A/D4A95C?text=Decaf+Espresso+Blend+1",
                "https://placehold.co/80x80/2A2A2A/D4A95C?text=DE+Thumb+2",
                "https://placehold.co/80x80/2A2A2A/D4A95C?text=DE+Thumb+3"
            ],
            colors: [{ name: { en: "Dark Brown", km: "ត្នោតខ្មៅ" }, hex: "#654321" }],
            sizes: [{ name: { en: "250g", km: "២៥០ក្រាម" } }, { name: { en: "500g", km: "៥០០ក្រាម" } }]
        },
        "Ceramic Coffee Mug": {
            title: { en: "Ceramic Coffee Mug", km: "ពែងកាហ្វេសេរ៉ាមិច" },
            price: "$15.00",
            description: { en: "A stylish and durable 12oz ceramic mug with an ergonomic design, perfect for your daily brew. Dishwasher safe.", km: "ពែងសេរ៉ាមិចទំហំ ១២ អោនដ៏ទាន់សម័យ និងប្រើប្រាស់បានយូរ ជាមួយនឹងការរចនាបែប Ergonomic ល្អឥតខ្ចោះសម្រាប់កាហ្វេប្រចាំថ្ងៃរបស់អ្នក។ អាចលាងចានបាន។" },
            images: [
                "https://placehold.co/600x400/2A2A2A/D4A95C?text=Ceramic+Mug+1",
                "https://placehold.co/80x80/2A2A2A/D4A95C?text=CM+Thumb+2",
                "https://placehold.co/80x80/2A2A2A/D4A95C?text=CM+Thumb+3"
            ],
            colors: [{ name: { en: "Black", km: "ខ្មៅ" }, hex: "#0F0F0F" }, { name: { en: "White", km: "ស" }, hex: "#FFFFFF" }],
            sizes: [{ name: { en: "12oz", km: "១២អោន" } }]
        },
        "Guatemalan Antigua": {
            title: { en: "Guatemalan Antigua", km: "ហ្គាតេម៉ាឡា អាន់ទីហ្គ័រ" },
            price: "$26.50",
            description: { en: "A medium-dark roast from Guatemala, offering spicy and smoky notes with a hint of cocoa, a truly complex flavor.", km: "កាហ្វេអាំងមធ្យម-ខ្មៅពីហ្គាតេម៉ាឡា ដែលផ្តល់នូវរសជាតិហឹរ និងផ្សែង ជាមួយនឹងរសជាតិកាកាវ ដែលជារសជាតិដ៏ស្មុគស្មាញ។" },
            images: [
                "https://placehold.co/600x400/2A2A2A/D4A95C?text=Guatemalan+Antigua+1",
                "https://placehold.co/80x80/2A2A2A/D4A95C?text=GA+Thumb+2",
                "https://placehold.co/80x80/2A2A2A/D4A95C?text=GA+Thumb+3"
            ],
            colors: [{ name: { en: "Brown", km: "ត្នោត" }, hex: "#8B4513" }],
            sizes: [{ name: { en: "250g", km: "២៥០ក្រាម" } }, { name: { en: "500g", km: "៥០០ក្រាម" } }]
        }
    };

    quickViewButtons.forEach(button => {
        button.addEventListener('click', () => {
            const productCard = button.closest('.product-card');
            const productName = productCard.dataset.name;
            const product = productData[productName];
            const currentLang = body.classList.contains('km') ? 'km' : 'en';

            if (product) {
                quickViewTitle.textContent = product.title[currentLang];
                quickViewPrice.textContent = product.price;
                quickViewDescription.textContent = product.description[currentLang];
                quickViewMainImg.src = product.images[0];

                // Update thumbnails
                const thumbsContainer = quickViewModal.querySelector('.product-gallery-thumbs');
                thumbsContainer.innerHTML = ''; // Clear existing thumbnails
                product.images.forEach((imgSrc, index) => {
                    // For quick view, we might want to show all images as thumbnails
                    const thumbDiv = document.createElement('div');
                    thumbDiv.classList.add('product-gallery-thumb');
                    if (index === 0) thumbDiv.classList.add('active'); // First thumbnail is active by default
                    thumbDiv.innerHTML = `<img src="${imgSrc}" alt="Thumbnail ${index + 1}" class="w-full h-full object-cover">`;
                    thumbDiv.addEventListener('click', () => {
                        quickViewMainImg.src = imgSrc;
                        thumbsContainer.querySelectorAll('.product-gallery-thumb').forEach(t => t.classList.remove('active'));
                        thumbDiv.classList.add('active');
                    });
                    thumbsContainer.appendChild(thumbDiv);
                });

                // Update color options
                const colorOptionsHtml = product.colors ? product.colors.map((color, index) => `
                    <div class="color-option ${index === 0 ? 'active' : ''}" style="background-color: ${color.hex};" data-color="${color.name[currentLang]}"></div>
                `).join('') : '';
                if (colorOptionsContainer) {
                    colorOptionsContainer.innerHTML = colorOptionsHtml;
                    const selectedColorSpan = document.getElementById('selected-color');
                    if (product.colors && product.colors.length > 0) {
                        selectedColorSpan.textContent = product.colors[0].name[currentLang];
                        colorOptionsContainer.closest('div').style.display = 'block';
                    } else {
                        colorOptionsContainer.closest('div').style.display = 'none';
                    }
                    colorOptionsContainer.querySelectorAll('.color-option').forEach(option => {
                        option.addEventListener('click', () => {
                            colorOptionsContainer.querySelectorAll('.color-option').forEach(opt => opt.classList.remove('active'));
                            option.classList.add('active');
                            selectedColorSpan.textContent = option.dataset.color;
                        });
                    });
                }

                // Update size options
                const sizeOptionsHtml = product.sizes ? product.sizes.map((size, index) => `
                    <div class="size-option ${index === 0 ? 'active' : ''}" data-size="${size.name[currentLang]}">
                        <span data-lang="en">${size.name.en}</span><span data-lang="km">${size.name.km}</span>
                    </div>
                `).join('') : '';
                if (sizeOptionsContainer) {
                    sizeOptionsContainer.innerHTML = sizeOptionsHtml;
                    const selectedSizeSpan = document.getElementById('selected-size');
                    if (product.sizes && product.sizes.length > 0) {
                        selectedSizeSpan.textContent = product.sizes[0].name[currentLang];
                        sizeOptionsContainer.closest('div').style.display = 'block';
                    } else {
                        sizeOptionsContainer.closest('div').style.display = 'none';
                    }
                    sizeOptionsContainer.querySelectorAll('.size-option').forEach(option => {
                        option.addEventListener('click', () => {
                            sizeOptionsContainer.querySelectorAll('.size-option').forEach(opt => opt.classList.remove('active'));
                            option.classList.add('active');
                            selectedSizeSpan.textContent = option.dataset.size;
                        });
                    });
                }
                
                productQtyInput.value = 1; // Reset quantity

                quickViewModal.classList.add('active');
                document.body.style.overflow = 'hidden'; // Prevent scrolling
            }
        });
    });

    if (quickViewCloseBtn) {
        quickViewCloseBtn.addEventListener('click', () => {
            quickViewModal.classList.remove('active');
            document.body.style.overflow = ''; // Restore scrolling
        });
    }

    if (decreaseQtyBtn) {
        decreaseQtyBtn.addEventListener('click', () => {
            let qty = parseInt(productQtyInput.value);
            if (qty > 1) {
                productQtyInput.value = qty - 1;
            }
        });
    }

    if (increaseQtyBtn) {
        increaseQtyBtn.addEventListener('click', () => {
            let qty = parseInt(productQtyInput.value);
            productQtyInput.value = qty + 1;
        });
    }

    // Add to Cart functionality (simple notification)
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    const cartNotification = document.getElementById('cart-notification');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', () => {
            cartNotification.classList.add('show');
            setTimeout(() => {
                cartNotification.classList.remove('show');
            }, 3000); // Hide after 3 seconds
        });
    });

    // Pagination (simple client-side logic for demonstration)
    const paginationItems = document.querySelectorAll('.pagination-item');
    paginationItems.forEach(item => {
        item.addEventListener('click', () => {
            paginationItems.forEach(p => p.classList.remove('active'));
            item.classList.add('active');
            // In a real application, this would trigger loading new products based on the page number
            console.log('Pagination clicked:', item.textContent.trim());
        });
    });


    // Slideshow functionality
    const slides = document.querySelectorAll('.slide');
    const slideIndicators = document.querySelectorAll('.slide-indicator');
    const prevSlideBtn = document.getElementById('prev-slide');
    const nextSlideBtn = document.getElementById('next-slide');
    const slideNumberCurrent = document.querySelector('.slide-number .current');
    const slideNumberTotal = document.querySelector('.slide-number .total');
    const slideProgressBar = document.getElementById('slide-progress');

    let currentSlide = 0;
    let autoSlideInterval;
    const slideDuration = 5000; // 5 seconds for each slide

    // Update total slide count
    if (slideNumberTotal) {
        slideNumberTotal.textContent = String(slides.length).padStart(2, '0');
    }

    function updateSlider() {
        slides.forEach((slide, index) => {
            slide.classList.remove('active', 'prev');
            if (index === currentSlide) {
                slide.classList.add('active');
            } else if (index === (currentSlide - 1 + slides.length) % slides.length) {
                slide.classList.add('prev');
            }
        });

        slideIndicators.forEach((indicator, index) => {
            indicator.classList.remove('active');
            if (index === currentSlide) {
                indicator.classList.add('active');
            }
        });

        if (slideNumberCurrent) {
            slideNumberCurrent.textContent = String(currentSlide + 1).padStart(2, '0');
        }

        resetProgressBar();
    }

    function changeSlide(direction) {
        if (direction === 'next') {
            currentSlide = (currentSlide + 1) % slides.length;
        } else if (direction === 'prev') {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        } else if (typeof direction === 'number') {
            currentSlide = direction;
        }
        updateSlider();
        startAutoSlide(); // Restart auto-slide after manual change
    }

    function startAutoSlide() {
        clearInterval(autoSlideInterval);
        autoSlideInterval = setInterval(() => {
            changeSlide('next');
        }, slideDuration);
    }

    function resetProgressBar() {
        if (slideProgressBar) {
            slideProgressBar.style.transition = 'none';
            slideProgressBar.style.width = '0%';
            // Force reflow
            void slideProgressBar.offsetWidth; 
            slideProgressBar.style.transition = `width ${slideDuration / 1000}s linear`;
            slideProgressBar.style.width = '100%';
        }
    }

    // Event Listeners for slideshow controls
    if (prevSlideBtn) {
        prevSlideBtn.addEventListener('click', () => changeSlide('prev'));
    }
    if (nextSlideBtn) {
        nextSlideBtn.addEventListener('click', () => changeSlide('next'));
    }
    slideIndicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => changeSlide(index));
    });

    // Initialize slideshow
    updateSlider();
    startAutoSlide();
});
