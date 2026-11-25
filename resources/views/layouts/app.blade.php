<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sanda Guest House')</title>
    <meta name="description" content="Sanda Guest House offers clean, affordable A/C and Non-A/C family rooms, attached bathrooms with hot water, and secure parking across our branch locations.">
    
    <!-- Google Fonts: Cormorant Garamond (Editorial Luxury Headings) & Plus Jakarta Sans (Modern UI & Body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
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
                            950: '#081a10',
                        },
                        gold: {
                            300: '#f8cf74',
                            400: '#f3b747',
                            500: '#d99726',
                            600: '#b87717',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Cormorant Garamond"', 'Georgia', 'serif'],
                    }
                }
            }
        }
    </script>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-[#fcfaf7] text-slate-800 font-sans antialiased flex flex-col min-h-screen" x-data="{ mobileMenu: false }">

    <!-- Main Navigation Header (Luxury Dark Style from Design Pin) -->
    <header class="bg-brand-900/95 backdrop-blur-md sticky top-0 z-50 border-b border-white/10 shadow-lg">
        <div class="w-full px-4 sm:px-8 lg:px-12">
            <div class="flex justify-between items-center h-20">
                <!-- Brand Name (Left-aligned) -->
                <a href="{{ route('home') }}" class="flex items-center gap-3.5 flex-shrink-0 group">
                    <img src="{{ asset('images/logo.png') }}" alt="Sanda" class="h-12 w-auto object-contain transition group-hover:scale-105">
                    <div>
                        <div class="text-2xl sm:text-3xl font-serif font-bold text-white tracking-tight leading-none group-hover:text-gold-300 transition">
                            Sanda
                        </div>
                        <div class="text-[10px] font-semibold text-gold-400 uppercase tracking-[0.25em] mt-1">
                            Guest House
                        </div>
                    </div>
                </a>

                <!-- Desktop Navigation Links (Center-aligned, Editorial Upper-case) -->
                <nav class="hidden md:flex items-center gap-7">
                    <a href="{{ route('home') }}" class="text-xs font-semibold uppercase tracking-[0.18em] {{ request()->routeIs('home') ? 'text-gold-400 border-b border-gold-400 pb-1' : 'text-slate-300 hover:text-white' }} transition">Home</a>
                    <a href="{{ route('rooms.index') }}" class="text-xs font-semibold uppercase tracking-[0.18em] {{ request()->routeIs('rooms.*') ? 'text-gold-400 border-b border-gold-400 pb-1' : 'text-slate-300 hover:text-white' }} transition">Rooms and Rates</a>
                    <a href="{{ route('facilities') }}" class="text-xs font-semibold uppercase tracking-[0.18em] {{ request()->routeIs('facilities') ? 'text-gold-400 border-b border-gold-400 pb-1' : 'text-slate-300 hover:text-white' }} transition">Facilities</a>
                    <a href="{{ route('gallery') }}" class="text-xs font-semibold uppercase tracking-[0.18em] {{ request()->routeIs('gallery') ? 'text-gold-400 border-b border-gold-400 pb-1' : 'text-slate-300 hover:text-white' }} transition">Photos</a>
                    <a href="{{ route('about') }}" class="text-xs font-semibold uppercase tracking-[0.18em] {{ request()->routeIs('about') ? 'text-gold-400 border-b border-gold-400 pb-1' : 'text-slate-300 hover:text-white' }} transition">About</a>
                    <a href="{{ route('contact') }}" class="text-xs font-semibold uppercase tracking-[0.18em] {{ request()->routeIs('contact') ? 'text-gold-400 border-b border-gold-400 pb-1' : 'text-slate-300 hover:text-white' }} transition">Contact</a>
                </nav>

                <!-- Action Button & Staff Portal (Right-aligned) -->
                <div class="hidden md:flex items-center gap-4">
                    <a href="https://wa.me/94779876543?text=Hello%20New%20Sanda%20Guest%20House,%20I%20would%20like%20to%20inquire%20about%20room%20availability." target="_blank" class="border border-gold-400/70 hover:border-gold-400 text-gold-400 hover:bg-gold-400 hover:text-brand-900 px-4 py-2 rounded-full text-xs font-semibold uppercase tracking-wider transition flex items-center gap-1.5 shadow-sm">
                        <i class="fa-brands fa-whatsapp text-emerald-400 text-sm"></i> Book Stay
                    </a>
                    <a href="{{ route('admin.dashboard') }}" title="Staff Portal" class="text-slate-400 hover:text-gold-400 p-2 rounded-full hover:bg-white/10 transition">
                        <i class="fa-solid fa-user-shield text-sm"></i>
                    </a>
                </div>

                <!-- Mobile Hamburger Button -->
                <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 rounded-md text-slate-300 hover:text-white hover:bg-white/10 focus:outline-none">
                    <i class="fa-solid" :class="mobileMenu ? 'fa-xmark text-xl' : 'fa-bars text-xl'"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div x-show="mobileMenu" x-cloak class="md:hidden bg-brand-950 border-t border-white/10 px-4 pt-3 pb-6 space-y-2">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg font-medium text-slate-200 hover:bg-white/10 hover:text-gold-400 text-sm">Home</a>
            <a href="{{ route('rooms.index') }}" class="block px-3 py-2 rounded-lg font-medium text-slate-200 hover:bg-white/10 hover:text-gold-400 text-sm">Rooms and Rates</a>
            <a href="{{ route('facilities') }}" class="block px-3 py-2 rounded-lg font-medium text-slate-200 hover:bg-white/10 hover:text-gold-400 text-sm">Facilities</a>
            <a href="{{ route('gallery') }}" class="block px-3 py-2 rounded-lg font-medium text-slate-200 hover:bg-white/10 hover:text-gold-400 text-sm">Photos</a>
            <a href="{{ route('about') }}" class="block px-3 py-2 rounded-lg font-medium text-slate-200 hover:bg-white/10 hover:text-gold-400 text-sm">About Us</a>
            <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-lg font-medium text-slate-200 hover:bg-white/10 hover:text-gold-400 text-sm">Contact and Location</a>
            <div class="pt-3 space-y-2">
                <a href="tel:+94779876543" class="block w-full text-center bg-gold-500 text-brand-950 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider">
                    <i class="fa-solid fa-phone mr-1"></i> Call: 077 987 6543
                </a>
                <a href="https://wa.me/94779876543" target="_blank" class="block w-full text-center bg-emerald-600 text-white py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider">
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

    <!-- Luxury Dark Footer (Aesthetic matched to the Design Pin) -->
    <footer class="bg-brand-950 text-slate-300 pt-16 pb-8 border-t border-white/10 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-10 pb-12 border-b border-white/10">
                <!-- Col 1: Editorial CTA -->
                <div class="md:col-span-5 space-y-4">
                    <span class="text-gold-400 font-semibold text-xs uppercase tracking-[0.25em] block">Reservations & Stay</span>
                    <h3 class="text-3xl sm:text-4xl lg:text-5xl font-serif text-white leading-tight">
                        Plan Your<br>Peaceful<br><span class="italic text-gold-400 font-normal">Getaway.</span>
                    </h3>
                    <div class="pt-2">
                        <a href="https://wa.me/94779876543?text=Hello%20New%20Sanda%20Guest%20House,%20I%20would%20like%20to%20reserve%20a%20room." target="_blank" class="inline-flex items-center gap-2 bg-gold-500 hover:bg-gold-400 text-brand-950 font-bold px-6 py-3.5 rounded text-xs uppercase tracking-wider transition shadow-lg">
                            RESERVE VIA WHATSAPP <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        </a>
                    </div>
                </div>

                <!-- Col 2: Direct Contact Details & Socials -->
                <div class="md:col-span-4 space-y-4">
                    <h4 class="text-white font-serif font-semibold text-xl tracking-wide">Direct Contact</h4>
                    <div class="space-y-3 text-xs text-slate-300">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-envelope text-gold-400 text-sm w-4"></i>
                            <a href="mailto:info@sanda.lk" class="hover:text-gold-400 transition">info@sanda.lk</a>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-phone text-gold-400 text-sm w-4"></i>
                            <span>+94 77 987 6543 / +94 47 223 5566</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fa-solid fa-location-dot text-gold-400 text-sm w-4 mt-0.5"></i>
                            <span>Sanda Guest House, Sella Katharagama, Sri Lanka</span>
                        </div>
                    </div>

                    <!-- Follow Us / Connect Icons -->
                    <div class="pt-2">
                        <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest block mb-2">Connect With Us</span>
                        <div class="flex items-center gap-2.5">
                            <a href="https://wa.me/94779876543" target="_blank" class="w-8 h-8 rounded-full border border-white/20 hover:border-gold-400 flex items-center justify-center text-slate-300 hover:text-gold-400 transition text-xs">
                                <i class="fa-brands fa-whatsapp"></i>
                            </a>
                            <a href="tel:+94779876543" class="w-8 h-8 rounded-full border border-white/20 hover:border-gold-400 flex items-center justify-center text-slate-300 hover:text-gold-400 transition text-xs">
                                <i class="fa-solid fa-phone"></i>
                            </a>
                            <a href="{{ route('contact') }}" class="w-8 h-8 rounded-full border border-white/20 hover:border-gold-400 flex items-center justify-center text-slate-300 hover:text-gold-400 transition text-xs">
                                <i class="fa-solid fa-map-location-dot"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Col 3: Brand & Hospitality Statement -->
                <div class="md:col-span-3 space-y-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Sanda" class="h-10 w-auto object-contain">
                        <div>
                            <div class="text-xl font-serif font-bold text-white leading-none">Sanda</div>
                            <div class="text-[9px] font-semibold text-gold-400 uppercase tracking-[0.2em] mt-0.5">Guest House</div>
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed font-light">
                        We offer clean, serene, and comfortable spaces that elevate your pilgrimage and holiday in Sri Lanka. Thoughtful care, spotless rooms, and family-first hospitality.
                    </p>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="pt-6 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500 gap-3">
                <p>&copy; {{ date('Y') }} Sanda Guest House. All rights reserved.</p>
                <div class="flex items-center gap-6 text-xs">
                    <a href="{{ route('about') }}" class="hover:text-slate-300 transition">About</a>
                    <a href="{{ route('rooms.index') }}" class="hover:text-slate-300 transition">Rooms</a>
                    <a href="{{ route('contact') }}" class="hover:text-slate-300 transition">Contact</a>
                    <a href="{{ route('admin.login') }}" class="hover:text-gold-400 transition text-[11px] flex items-center gap-1">
                        <i class="fa-solid fa-lock text-[10px]"></i> Staff Login
                    </a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
