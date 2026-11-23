<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'නිවි සඳ (Nivi Sanda) Family Holiday Resort - Sella Katharagama')</title>
    <meta name="description" content="Nivi Sanda Family Holiday Resort in Sella Katharagama offers luxury family villas, wooden cabanas, swimming pool, authentic dining, and Yala Safari tours.">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f2f8f4',
                            100: '#e1efe6',
                            200: '#c5dfd0',
                            500: '#2b7a4b',
                            600: '#1e5f38',
                            700: '#174b2d',
                            800: '#133d25',
                            900: '#0e2d1c',
                        },
                        gold: {
                            400: '#f3b747',
                            500: '#d99726',
                            600: '#b87717',
                        },
                        water: {
                            500: '#0284c7',
                            600: '#0369a1',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        .hero-gradient {
            background: linear-gradient(180deg, rgba(14, 45, 28, 0.75) 0%, rgba(14, 45, 28, 0.88) 100%);
        }
    </style>
</head>
<body class="bg-[#fcfaf7] text-slate-800 font-sans antialiased flex flex-col min-h-screen" x-data="{ mobileMenu: false }">

    <!-- Top Announcement & Hotline Bar -->
    <div class="bg-brand-900 text-white text-xs py-2 px-4 border-b border-brand-800">
        <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center gap-2">
            <div class="flex items-center gap-4">
                <span class="flex items-center gap-1.5 text-gold-400 font-medium">
                    <i class="fa-solid fa-location-dot"></i> Sella Katharagama, Sri Lanka
                </span>
                <span class="hidden md:inline-block text-brand-200">•</span>
                <span class="hidden md:inline-flex items-center gap-1.5 text-slate-200">
                    <i class="fa-solid fa-leaf text-emerald-400"></i> Minutes to Ruhunu Kataragama Maha Devalaya & Yala Safari
                </span>
            </div>
            <div class="flex items-center gap-4">
                <a href="tel:+94779876543" class="hover:text-gold-400 transition flex items-center gap-1">
                    <i class="fa-solid fa-phone text-xs text-gold-400"></i> +94 77 987 6543
                </a>
                <a href="https://wa.me/94779876543" target="_blank" class="hover:text-emerald-400 transition flex items-center gap-1 text-emerald-400 font-medium">
                    <i class="fa-brands fa-whatsapp"></i> WhatsApp
                </a>
                <a href="{{ route('booking.track') }}" class="hover:text-gold-400 transition flex items-center gap-1 text-slate-200">
                    <i class="fa-solid fa-search text-xs"></i> Track Booking
                </a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <header class="bg-white/95 backdrop-blur-md sticky top-0 z-50 shadow-sm border-b border-stone-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Resort Logo & Name -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Nivi Sanda Family Holiday Resort" class="h-16 w-auto object-contain rounded shadow-sm group-hover:scale-105 transition duration-300">
                    <div>
                        <div class="text-xl sm:text-2xl font-serif font-bold text-brand-900 tracking-tight leading-none">
                            නිවි සඳ <span class="text-gold-500 font-sans text-lg font-semibold tracking-normal">Resort</span>
                        </div>
                        <div class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-widest mt-0.5">
                            Family Holiday Resort • Sella Katharagama
                        </div>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden lg:flex items-center gap-7">
                    <a href="{{ route('home') }}" class="text-sm font-semibold {{ request()->routeIs('home') ? 'text-brand-700 font-bold border-b-2 border-brand-700 py-1' : 'text-slate-600 hover:text-brand-700' }} transition">Home</a>
                    <a href="{{ route('rooms.index') }}" class="text-sm font-semibold {{ request()->routeIs('rooms.*') ? 'text-brand-700 font-bold border-b-2 border-brand-700 py-1' : 'text-slate-600 hover:text-brand-700' }} transition">Rooms & Cabanas</a>
                    <a href="{{ route('facilities') }}" class="text-sm font-semibold {{ request()->routeIs('facilities') ? 'text-brand-700 font-bold border-b-2 border-brand-700 py-1' : 'text-slate-600 hover:text-brand-700' }} transition">Facilities</a>
                    <a href="{{ route('gallery') }}" class="text-sm font-semibold {{ request()->routeIs('gallery') ? 'text-brand-700 font-bold border-b-2 border-brand-700 py-1' : 'text-slate-600 hover:text-brand-700' }} transition">Gallery</a>
                    <a href="{{ route('about') }}" class="text-sm font-semibold {{ request()->routeIs('about') ? 'text-brand-700 font-bold border-b-2 border-brand-700 py-1' : 'text-slate-600 hover:text-brand-700' }} transition">About Us</a>
                    <a href="{{ route('contact') }}" class="text-sm font-semibold {{ request()->routeIs('contact') ? 'text-brand-700 font-bold border-b-2 border-brand-700 py-1' : 'text-slate-600 hover:text-brand-700' }} transition">Contact</a>
                </nav>

                <!-- Book Now Action & Admin Link -->
                <div class="hidden sm:flex items-center gap-3">
                    <a href="{{ route('booking.create') }}" class="bg-brand-700 hover:bg-brand-800 text-white px-5 py-2.5 rounded-full font-semibold text-sm shadow-md hover:shadow-lg hover:-translate-y-0.5 transition duration-200 flex items-center gap-2">
                        <i class="fa-solid fa-calendar-check text-gold-400"></i> Book Your Stay
                    </a>
                    <a href="{{ route('admin.dashboard') }}" title="Staff / Admin Portal" class="text-slate-400 hover:text-brand-800 p-2 rounded-full hover:bg-slate-100 transition">
                        <i class="fa-solid fa-user-shield text-base"></i>
                    </a>
                </div>

                <!-- Mobile Hamburger Button -->
                <button @click="mobileMenu = !mobileMenu" class="lg:hidden p-2 rounded-md text-slate-600 hover:text-brand-800 hover:bg-slate-100 focus:outline-none">
                    <i class="fa-solid" :class="mobileMenu ? 'fa-xmark text-xl' : 'fa-bars text-xl'"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div x-show="mobileMenu" x-cloak class="lg:hidden bg-white border-t border-slate-100 px-4 pt-3 pb-6 space-y-3">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-brand-50 hover:text-brand-800">Home</a>
            <a href="{{ route('rooms.index') }}" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-brand-50 hover:text-brand-800">Rooms & Cabanas</a>
            <a href="{{ route('facilities') }}" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-brand-50 hover:text-brand-800">Facilities & Pool</a>
            <a href="{{ route('gallery') }}" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-brand-50 hover:text-brand-800">Photo Gallery</a>
            <a href="{{ route('about') }}" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-brand-50 hover:text-brand-800">About Us</a>
            <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-brand-50 hover:text-brand-800">Contact & Location</a>
            <a href="{{ route('booking.track') }}" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-brand-50 hover:text-brand-800">Check Booking Status</a>
            <div class="pt-2">
                <a href="{{ route('booking.create') }}" class="block w-full text-center bg-brand-700 hover:bg-brand-800 text-white py-3 rounded-xl font-bold shadow">
                    Book Your Stay Now
                </a>
            </div>
        </div>
    </header>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-5xl mx-auto px-4 mt-6">
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-3 text-emerald-800">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-xl"></i>
                    <p class="font-medium text-sm">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-5xl mx-auto px-4 mt-6">
            <div class="bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-lg shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-3 text-rose-800">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-xl"></i>
                    <p class="font-medium text-sm">{{ session('error') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Main Content Slot -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-brand-900 text-slate-300 pt-16 pb-8 border-t border-brand-800 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 pb-12 border-b border-brand-800/60">
                <!-- Column 1: Brand & Bio -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Nivi Sanda Resort" class="h-14 w-auto bg-white/10 rounded p-1">
                        <div>
                            <div class="font-serif font-bold text-xl text-white">නිවි සඳ Resort</div>
                            <div class="text-xs text-gold-400 uppercase tracking-widest font-semibold">Family Holiday Resort</div>
                        </div>
                    </div>
                    <p class="text-sm text-slate-300 leading-relaxed">
                        A peaceful nature oasis in Sella Katharagama. Luxurious family cabanas, sparkling swimming pool, tranquil nature gardens, and warm southern Sri Lankan hospitality.
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <a href="#" class="w-9 h-9 rounded-full bg-brand-800 hover:bg-gold-500 hover:text-white flex items-center justify-center text-slate-300 transition">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="https://wa.me/94779876543" target="_blank" class="w-9 h-9 rounded-full bg-brand-800 hover:bg-emerald-500 hover:text-white flex items-center justify-center text-slate-300 transition">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                        <a href="#" class="w-9 h-9 rounded-full bg-brand-800 hover:bg-gold-500 hover:text-white flex items-center justify-center text-slate-300 transition">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                    </div>
                </div>

                <!-- Column 2: Quick Links -->
                <div>
                    <h4 class="text-white font-serif font-bold text-base mb-4 tracking-wide border-l-2 border-gold-500 pl-2">Quick Navigation</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-gold-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-brand-500"></i> Home</a></li>
                        <li><a href="{{ route('rooms.index') }}" class="hover:text-gold-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-brand-500"></i> Rooms & Luxury Cabanas</a></li>
                        <li><a href="{{ route('facilities') }}" class="hover:text-gold-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-brand-500"></i> Facilities & Swimming Pool</a></li>
                        <li><a href="{{ route('gallery') }}" class="hover:text-gold-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-brand-500"></i> Photo Gallery</a></li>
                        <li><a href="{{ route('booking.create') }}" class="hover:text-gold-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-brand-500"></i> Online Reservation</a></li>
                        <li><a href="{{ route('booking.track') }}" class="hover:text-gold-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-brand-500"></i> Track Booking Status</a></li>
                    </ul>
                </div>

                <!-- Column 3: Nearby Attractions -->
                <div>
                    <h4 class="text-white font-serif font-bold text-base mb-4 tracking-wide border-l-2 border-gold-500 pl-2">Nearby Attractions</h4>
                    <ul class="space-y-2 text-sm text-slate-300">
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-gopuram text-gold-400 mt-1"></i>
                            <div>
                                <strong class="text-white">Kataragama Maha Devalaya</strong>
                                <p class="text-xs text-slate-400">10 mins drive for Pooja & blessings</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-paw text-gold-400 mt-1"></i>
                            <div>
                                <strong class="text-white">Yala National Park Safari</strong>
                                <p class="text-xs text-slate-400">Leopards, elephants & wildlife tours</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-water text-gold-400 mt-1"></i>
                            <div>
                                <strong class="text-white">Menik Ganga & Sella Temple</strong>
                                <p class="text-xs text-slate-400">Sacred bath & river breeze nearby</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-mountain text-gold-400 mt-1"></i>
                            <div>
                                <strong class="text-white">Wedahitikanda & Kiri Vehera</strong>
                                <p class="text-xs text-slate-400">Ancient historical pilgrimage sites</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Column 4: Contact & Location -->
                <div>
                    <h4 class="text-white font-serif font-bold text-base mb-4 tracking-wide border-l-2 border-gold-500 pl-2">Contact & Inquiries</h4>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-start gap-3">
                            <i class="fa-solid fa-map-pin text-gold-400 mt-1"></i>
                            <span>No. 45, Sella Road, Sella Katharagama, Sri Lanka</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-phone text-gold-400"></i>
                            <span>+94 77 987 6543 / +94 47 223 5566</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fa-brands fa-whatsapp text-emerald-400 text-base"></i>
                            <span>+94 77 987 6543 (Direct WhatsApp)</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-envelope text-gold-400"></i>
                            <span>info@nivisandaresort.com</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Copyright & Admin portal link -->
            <div class="pt-8 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-400 gap-4">
                <p>&copy; {{ date('Y') }} නිවි සඳ (Nivi Sanda) Family Holiday Resort. All rights reserved.</p>
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.login') }}" class="text-slate-400 hover:text-gold-400 transition flex items-center gap-1">
                        <i class="fa-solid fa-lock text-[10px]"></i> Resort Staff Login
                    </a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
