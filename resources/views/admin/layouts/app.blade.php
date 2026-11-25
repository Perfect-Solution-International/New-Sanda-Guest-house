<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - Sanda')</title>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,500;0,600;0,700;1,500;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
                        serif: ['"Lora"', 'Georgia', 'serif'],
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-100 text-slate-800 font-sans antialiased min-h-screen flex" x-data="{ sidebarOpen: false }">

    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-brand-900 text-white transform transition-transform duration-200 lg:translate-x-0 flex flex-col justify-between"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
        <div>
            <!-- Resort Brand -->
            <div class="h-20 flex items-center gap-3 px-6 border-b border-brand-800 bg-brand-900">
                <img src="{{ asset('images/logo.png') }}" alt="Sanda" class="h-10 w-auto object-contain">
                <div>
                    <div class="font-serif font-bold text-base text-white leading-tight">Sanda Guest House</div>
                    <div class="text-[10px] text-gold-400 font-semibold uppercase tracking-wider">Management Desk</div>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="p-4 space-y-1 text-sm font-medium">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-brand-800 text-gold-400 font-bold' : 'text-slate-300 hover:bg-brand-800/60 hover:text-white' }}">
                    <i class="fa-solid fa-gauge w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.bookings.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.bookings.*') ? 'bg-brand-800 text-gold-400 font-bold' : 'text-slate-300 hover:bg-brand-800/60 hover:text-white' }}">
                    <i class="fa-solid fa-calendar-check w-5 text-center"></i>
                    <span>Reservations</span>
                </a>

                <a href="{{ route('admin.timeline') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.timeline') ? 'bg-brand-800 text-gold-400 font-bold' : 'text-slate-300 hover:bg-brand-800/60 hover:text-white' }}">
                    <i class="fa-solid fa-calendar-days w-5 text-center"></i>
                    <span>Timeline & Calendar</span>
                </a>

                <a href="{{ route('admin.rooms.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.rooms.*') ? 'bg-brand-800 text-gold-400 font-bold' : 'text-slate-300 hover:bg-brand-800/60 hover:text-white' }}">
                    <i class="fa-solid fa-door-closed w-5 text-center"></i>
                    <span>Physical Rooms</span>
                </a>

                <a href="{{ route('admin.room-types.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.room-types.*') ? 'bg-brand-800 text-gold-400 font-bold' : 'text-slate-300 hover:bg-brand-800/60 hover:text-white' }}">
                    <i class="fa-solid fa-layer-group w-5 text-center"></i>
                    <span>Room Categories</span>
                </a>

                <a href="{{ route('admin.addons.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.addons.*') ? 'bg-brand-800 text-gold-400 font-bold' : 'text-slate-300 hover:bg-brand-800/60 hover:text-white' }}">
                    <i class="fa-solid fa-truck-monster w-5 text-center"></i>
                    <span>Safari & Tour Addons</span>
                </a>

                <a href="{{ route('admin.inquiries.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.inquiries.*') ? 'bg-brand-800 text-gold-400 font-bold' : 'text-slate-300 hover:bg-brand-800/60 hover:text-white' }}">
                    <i class="fa-solid fa-envelope w-5 text-center"></i>
                    <span>Guest Inquiries</span>
                </a>

                <a href="{{ route('admin.reviews.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.reviews.*') ? 'bg-brand-800 text-gold-400 font-bold' : 'text-slate-300 hover:bg-brand-800/60 hover:text-white' }}">
                    <i class="fa-solid fa-star w-5 text-center"></i>
                    <span>Guest Reviews</span>
                </a>

                <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.settings.*') ? 'bg-brand-800 text-gold-400 font-bold' : 'text-slate-300 hover:bg-brand-800/60 hover:text-white' }}">
                    <i class="fa-solid fa-sliders w-5 text-center"></i>
                    <span>Resort Settings</span>
                </a>
            </nav>
        </div>

        <!-- User profile & Logout -->
        <div class="p-4 border-t border-brand-800 bg-brand-900/60">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-full bg-gold-500 text-brand-900 font-bold flex items-center justify-center text-sm">
                    {{ substr(Auth::user()->name ?? 'Admin', 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <div class="text-xs font-bold text-white truncate">{{ Auth::user()->name ?? 'Administrator' }}</div>
                    <div class="text-[10px] text-slate-400 uppercase tracking-wider">{{ Auth::user()->role ?? 'Staff' }}</div>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('home') }}" target="_blank" class="flex-1 text-center bg-brand-800 hover:bg-brand-700 text-slate-200 text-xs py-2 rounded-lg font-medium transition">
                    <i class="fa-solid fa-globe mr-1"></i> Public Site
                </a>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" title="Logout" class="bg-rose-900/60 hover:bg-rose-800 text-rose-300 px-3 py-2 rounded-lg text-xs transition">
                        <i class="fa-solid fa-power-off"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Container -->
    <div class="flex-1 lg:pl-64 flex flex-col min-h-screen">
        <!-- Top Navigation -->
        <header class="bg-white border-b border-slate-200 h-20 flex items-center justify-between px-4 sm:px-8 sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 text-slate-600 hover:text-slate-900">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h2 class="text-xl font-bold text-slate-900 font-serif">@yield('page_title', 'Management Dashboard')</h2>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('admin.bookings.create') }}" class="bg-brand-700 hover:bg-brand-800 text-white font-bold text-xs sm:text-sm px-4 py-2 rounded-xl shadow-sm flex items-center gap-2 transition">
                    <i class="fa-solid fa-plus text-gold-400"></i> New Reservation
                </a>
            </div>
        </header>

        <!-- Flash messages -->
        @if(session('success'))
            <div class="mx-4 sm:mx-8 mt-6">
                <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-sm flex items-center justify-between text-emerald-800 text-sm font-medium">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mx-4 sm:mx-8 mt-6">
                <div class="bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-lg shadow-sm flex items-center justify-between text-rose-800 text-sm font-medium">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation text-rose-600 text-lg"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>
        @endif

        <!-- Main Body -->
        <main class="flex-1 p-4 sm:p-8">
            @yield('content')
        </main>
    </div>

</body>
</html>
