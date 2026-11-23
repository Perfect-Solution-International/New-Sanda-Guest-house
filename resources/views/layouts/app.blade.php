<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'New Sanda Guest House & Holiday Home - Sella Katharagama')</title>
    <meta name="description" content="New Sanda Guest House in Sella Katharagama offers clean, affordable A/C and Non-A/C family rooms, attached bathrooms with hot water, and secure parking.">
    
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
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-[#fcfaf7] text-slate-800 font-sans antialiased flex flex-col min-h-screen" x-data="{ mobileMenu: false }">

    <!-- Main Navigation Header -->
    <header class="bg-white/95 backdrop-blur-md sticky top-0 z-50 shadow-sm border-b border-stone-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Brand Name -->
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.jpg') }}" alt="New Sanda" class="h-14 w-auto object-contain rounded shadow-sm">
                    <div>
                        <div class="text-xl sm:text-2xl font-serif font-bold text-brand-900 tracking-tight leading-none">
                            New Sanda <span class="text-gold-500 font-sans text-base sm:text-lg font-semibold tracking-normal">Guest House</span>
                        </div>
                        <div class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider mt-0.5">
                            Holiday Home • Sella Katharagama
                        </div>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-6">
                    <a href="{{ route('home') }}" class="text-sm font-semibold {{ request()->routeIs('home') ? 'text-brand-700 font-bold border-b-2 border-brand-700 py-1' : 'text-slate-600 hover:text-brand-700' }} transition">Home</a>
                    <a href="{{ route('rooms.index') }}" class="text-sm font-semibold {{ request()->routeIs('rooms.*') ? 'text-brand-700 font-bold border-b-2 border-brand-700 py-1' : 'text-slate-600 hover:text-brand-700' }} transition">Rooms & Rates</a>
                    <a href="{{ route('facilities') }}" class="text-sm font-semibold {{ request()->routeIs('facilities') ? 'text-brand-700 font-bold border-b-2 border-brand-700 py-1' : 'text-slate-600 hover:text-brand-700' }} transition">Facilities</a>
                    <a href="{{ route('gallery') }}" class="text-sm font-semibold {{ request()->routeIs('gallery') ? 'text-brand-700 font-bold border-b-2 border-brand-700 py-1' : 'text-slate-600 hover:text-brand-700' }} transition">Photos</a>
                    <a href="{{ route('about') }}" class="text-sm font-semibold {{ request()->routeIs('about') ? 'text-brand-700 font-bold border-b-2 border-brand-700 py-1' : 'text-slate-600 hover:text-brand-700' }} transition">About</a>
                    <a href="{{ route('contact') }}" class="text-sm font-semibold {{ request()->routeIs('contact') ? 'text-brand-700 font-bold border-b-2 border-brand-700 py-1' : 'text-slate-600 hover:text-brand-700' }} transition">Contact</a>
                </nav>

                <!-- Direct Call Action -->
                <div class="hidden sm:flex items-center gap-3">
                    <a href="tel:+94779876543" class="bg-brand-700 hover:bg-brand-800 text-white px-5 py-2.5 rounded-full font-bold text-xs sm:text-sm shadow transition flex items-center gap-2">
                        <i class="fa-solid fa-phone text-gold-400"></i> 077 987 6543
                    </a>
                    <a href="{{ route('admin.dashboard') }}" title="Staff Login" class="text-slate-400 hover:text-brand-800 p-2 rounded-full hover:bg-slate-100 transition">
                        <i class="fa-solid fa-user-shield text-base"></i>
                    </a>
                </div>

                <!-- Mobile Hamburger Button -->
                <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 rounded-md text-slate-600 hover:text-brand-800 hover:bg-slate-100 focus:outline-none">
                    <i class="fa-solid" :class="mobileMenu ? 'fa-xmark text-xl' : 'fa-bars text-xl'"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div x-show="mobileMenu" x-cloak class="md:hidden bg-white border-t border-slate-100 px-4 pt-3 pb-6 space-y-3">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-brand-50 hover:text-brand-800">Home</a>
            <a href="{{ route('rooms.index') }}" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-brand-50 hover:text-brand-800">Rooms & Rates</a>
            <a href="{{ route('facilities') }}" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-brand-50 hover:text-brand-800">Facilities</a>
            <a href="{{ route('gallery') }}" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-brand-50 hover:text-brand-800">Photos</a>
            <a href="{{ route('about') }}" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-brand-50 hover:text-brand-800">About Us</a>
            <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-brand-50 hover:text-brand-800">Contact & Location</a>
            <div class="pt-2 space-y-2">
                <a href="tel:+94779876543" class="block w-full text-center bg-brand-700 text-white py-2.5 rounded-xl font-bold text-sm">
                    <i class="fa-solid fa-phone mr-1"></i> Call: 077 987 6543
                </a>
                <a href="https://wa.me/94779876543" target="_blank" class="block w-full text-center bg-emerald-600 text-white py-2.5 rounded-xl font-bold text-sm">
                    <i class="fa-brands fa-whatsapp mr-1"></i> WhatsApp Booking
                </a>
            </div>
        </div>
    </header>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-4xl mx-auto px-4 mt-6">
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-3 text-emerald-800">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                    <p class="font-medium text-sm">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
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
    <footer class="bg-brand-900 text-slate-300 pt-12 pb-8 border-t border-brand-800 mt-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pb-8 border-b border-brand-800/60">
                <div class="space-y-3">
                    <div class="font-serif font-bold text-xl text-white">New Sanda Guest House</div>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Clean and affordable guest house in Sella Katharagama. Perfect for families and pilgrims visiting Ruhunu Kataragama Maha Devalaya, Kiri Vehera, and Sella Temple.
                    </p>
                </div>

                <div>
                    <h4 class="text-white font-serif font-bold text-sm mb-3 text-gold-400">Quick Links</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('home') }}" class="hover:text-gold-400">Home</a></li>
                        <li><a href="{{ route('rooms.index') }}" class="hover:text-gold-400">Rooms & Rates</a></li>
                        <li><a href="{{ route('facilities') }}" class="hover:text-gold-400">Guest House Facilities</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-gold-400">Contact & Directions</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-serif font-bold text-sm mb-3 text-gold-400">Contact Us Directly</h4>
                    <div class="space-y-2 text-xs text-slate-300">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-location-dot text-gold-400"></i>
                            <span>No. 45, Sella Road, Sella Katharagama</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-phone text-gold-400"></i>
                            <span>+94 77 987 6543 / +94 47 223 5566</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-brands fa-whatsapp text-emerald-400"></i>
                            <span>+94 77 987 6543 (WhatsApp)</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-6 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-400 gap-2">
                <p>&copy; {{ date('Y') }} New Sanda Guest House & Holiday Home. All rights reserved.</p>
                <a href="{{ route('admin.login') }}" class="text-slate-500 hover:text-gold-400 text-[11px]">
                    <i class="fa-solid fa-lock"></i> Staff Login
                </a>
            </div>
        </div>
    </footer>

</body>
</html>
