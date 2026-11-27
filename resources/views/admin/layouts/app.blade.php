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
    <style>
        [x-cloak] { display: none !important; }

        /* Unified Dark-Green Glassmorphic Theme for All Admin Pages */
        .admin-glass-theme {
            color: #e2e8f0;
        }
        .admin-glass-theme .bg-white {
            background-color: rgba(255, 255, 255, 0.06) !important;
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-color: rgba(255, 255, 255, 0.12) !important;
        }
        .admin-glass-theme .fixed .bg-white {
            background-color: rgba(10, 31, 19, 0.96) !important;
            backdrop-filter: blur(24px);
            border-color: rgba(255, 255, 255, 0.18) !important;
        }
        .admin-glass-theme .bg-slate-50,
        .admin-glass-theme .bg-slate-100,
        .admin-glass-theme .bg-stone-50 {
            background-color: rgba(255, 255, 255, 0.04) !important;
        }
        .admin-glass-theme .hover\:bg-slate-50:hover,
        .admin-glass-theme .hover\:bg-slate-50\/70:hover,
        .admin-glass-theme .hover\:bg-slate-50\/80:hover,
        .admin-glass-theme .hover\:bg-slate-100:hover {
            background-color: rgba(255, 255, 255, 0.09) !important;
        }
        .admin-glass-theme .border-slate-100,
        .admin-glass-theme .border-slate-200,
        .admin-glass-theme .border-slate-300 {
            border-color: rgba(255, 255, 255, 0.12) !important;
        }
        .admin-glass-theme .divide-slate-100 > :not([hidden]) ~ :not([hidden]),
        .admin-glass-theme .divide-slate-200 > :not([hidden]) ~ :not([hidden]) {
            border-color: rgba(255, 255, 255, 0.09) !important;
        }
        .admin-glass-theme .text-slate-900,
        .admin-glass-theme .text-slate-800 {
            color: #ffffff !important;
        }
        .admin-glass-theme .text-slate-700,
        .admin-glass-theme .text-slate-600 {
            color: #cbd5e1 !important;
        }
        .admin-glass-theme .text-slate-500,
        .admin-glass-theme .text-slate-400 {
            color: #94a3b8 !important;
        }
        .admin-glass-theme .text-brand-900:not(.bg-gold-500):not(.bg-gold-400),
        .admin-glass-theme .text-brand-700:not(.bg-brand-700) {
            color: #f3b747 !important;
        }
        .admin-glass-theme .bg-gold-500,
        .admin-glass-theme .bg-gold-400 {
            color: #0e2d1c !important;
        }
        .admin-glass-theme .bg-amber-100 { background-color: rgba(245, 158, 11, 0.2) !important; color: #fcd34d !important; border-color: rgba(245, 158, 11, 0.35) !important; }
        .admin-glass-theme .bg-emerald-100 { background-color: rgba(16, 185, 129, 0.2) !important; color: #6ee7b7 !important; border-color: rgba(16, 185, 129, 0.35) !important; }
        .admin-glass-theme .bg-emerald-50 { background-color: rgba(16, 185, 129, 0.14) !important; color: #6ee7b7 !important; }
        .admin-glass-theme .bg-rose-100 { background-color: rgba(244, 63, 94, 0.2) !important; color: #fda4af !important; border-color: rgba(244, 63, 94, 0.35) !important; }
        .admin-glass-theme .bg-rose-50 { background-color: rgba(244, 63, 94, 0.14) !important; color: #fda4af !important; }
        .admin-glass-theme .bg-blue-100,
        .admin-glass-theme .bg-sky-100 { background-color: rgba(56, 189, 248, 0.2) !important; color: #7dd3fc !important; }
        .admin-glass-theme .bg-purple-100 { background-color: rgba(168, 85, 247, 0.2) !important; color: #d8b4fe !important; }

        .admin-glass-theme input:not([type="checkbox"]):not([type="radio"]):not([type="file"]),
        .admin-glass-theme select,
        .admin-glass-theme textarea {
            background-color: rgba(7, 25, 15, 0.65) !important;
            color: #ffffff !important;
            border-color: rgba(255, 255, 255, 0.18) !important;
        }
        .admin-glass-theme input::placeholder,
        .admin-glass-theme textarea::placeholder {
            color: #94a3b8 !important;
        }
        .admin-glass-theme select option {
            background-color: #0e2d1c;
            color: #ffffff;
        }
    </style>
</head>
<body class="bg-[#07190f] text-slate-800 font-sans antialiased min-h-screen flex relative selection:bg-gold-500 selection:text-brand-900"
      style="background-image: radial-gradient(circle at 18% 15%, rgba(43, 122, 75, 0.28), transparent 45%), radial-gradient(circle at 85% 80%, rgba(217, 151, 38, 0.12), transparent 45%), linear-gradient(135deg, #07190f 0%, #0e2d1c 55%, #071a10 100%);"
      x-data="adminPortalApp()">

    <!-- Sidebar (Glassmorphic Forest Green) -->
    <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-[#092014]/85 backdrop-blur-xl text-white transform transition-transform duration-200 lg:translate-x-0 flex flex-col justify-between border-r border-white/10 shadow-2xl"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
        <div class="overflow-y-auto flex-1">
            <!-- Resort Brand -->
            <div class="h-20 flex items-center gap-3 px-5 border-b border-white/10 bg-white/[0.02]">
                <img src="{{ asset('images/logo-nobg.png') }}?v={{ filemtime(public_path('images/logo-nobg.png')) }}" alt="Sanda" class="h-11 w-auto object-contain">
                <div>
                    <div class="font-serif font-bold text-base text-white leading-tight">Sanda Guest House</div>
                    <div class="text-[10px] text-gold-400 font-semibold uppercase tracking-wider">Management Desk</div>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="p-3.5 space-y-1 text-sm font-medium">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-white/12 text-gold-400 font-bold border border-white/15 shadow-sm' : 'text-slate-300 hover:bg-white/[0.07] hover:text-white' }}">
                    <i class="fa-solid fa-gauge w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.bookings.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.bookings.*') ? 'bg-white/12 text-gold-400 font-bold border border-white/15 shadow-sm' : 'text-slate-300 hover:bg-white/[0.07] hover:text-white' }}">
                    <i class="fa-solid fa-calendar-check w-5 text-center"></i>
                    <span>Reservations</span>
                </a>

                <a href="{{ route('admin.customers.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.customers.*') ? 'bg-white/12 text-gold-400 font-bold border border-white/15 shadow-sm' : 'text-slate-300 hover:bg-white/[0.07] hover:text-white' }}">
                    <i class="fa-solid fa-users w-5 text-center"></i>
                    <span>Guest CRM & History</span>
                </a>

                <a href="{{ route('admin.timeline') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.timeline') ? 'bg-white/12 text-gold-400 font-bold border border-white/15 shadow-sm' : 'text-slate-300 hover:bg-white/[0.07] hover:text-white' }}">
                    <i class="fa-solid fa-calendar-days w-5 text-center"></i>
                    <span>Timeline & Calendar</span>
                </a>

                <a href="{{ route('admin.rooms.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.rooms.*') ? 'bg-white/12 text-gold-400 font-bold border border-white/15 shadow-sm' : 'text-slate-300 hover:bg-white/[0.07] hover:text-white' }}">
                    <i class="fa-solid fa-door-closed w-5 text-center"></i>
                    <span>Physical Rooms</span>
                </a>

                <a href="{{ route('admin.room-types.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.room-types.*') ? 'bg-white/12 text-gold-400 font-bold border border-white/15 shadow-sm' : 'text-slate-300 hover:bg-white/[0.07] hover:text-white' }}">
                    <i class="fa-solid fa-layer-group w-5 text-center"></i>
                    <span>Room Categories</span>
                </a>

                <a href="{{ route('admin.addons.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.addons.*') ? 'bg-white/12 text-gold-400 font-bold border border-white/15 shadow-sm' : 'text-slate-300 hover:bg-white/[0.07] hover:text-white' }}">
                    <i class="fa-solid fa-truck-monster w-5 text-center"></i>
                    <span>Safari & Tour Addons</span>
                </a>

                <a href="{{ route('admin.inquiries.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.inquiries.*') ? 'bg-white/12 text-gold-400 font-bold border border-white/15 shadow-sm' : 'text-slate-300 hover:bg-white/[0.07] hover:text-white' }}">
                    <i class="fa-solid fa-envelope w-5 text-center"></i>
                    <span>Guest Inquiries</span>
                </a>

                <a href="{{ route('admin.reviews.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.reviews.*') ? 'bg-white/12 text-gold-400 font-bold border border-white/15 shadow-sm' : 'text-slate-300 hover:bg-white/[0.07] hover:text-white' }}">
                    <i class="fa-solid fa-star w-5 text-center"></i>
                    <span>Guest Reviews</span>
                </a>

                <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.reports.*') ? 'bg-white/12 text-gold-400 font-bold border border-white/15 shadow-sm' : 'text-slate-300 hover:bg-white/[0.07] hover:text-white' }}">
                    <i class="fa-solid fa-chart-line w-5 text-center"></i>
                    <span>Reports &amp; Analytics</span>
                </a>

                <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.settings.*') ? 'bg-white/12 text-gold-400 font-bold border border-white/15 shadow-sm' : 'text-slate-300 hover:bg-white/[0.07] hover:text-white' }}">
                    <i class="fa-solid fa-sliders w-5 text-center"></i>
                    <span>Resort Settings</span>
                </a>
            </nav>
        </div>

        <!-- User profile & Logout -->
        <div class="p-4 border-t border-white/10 bg-black/20">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-full bg-gold-500 text-brand-900 font-bold flex items-center justify-center text-sm shadow">
                    {{ substr(Auth::user()->name ?? 'Admin', 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <div class="text-xs font-bold text-white truncate">{{ Auth::user()->name ?? 'Administrator' }}</div>
                    <div class="text-[10px] text-gold-400/80 uppercase tracking-wider">{{ Auth::user()->role ?? 'Staff' }}</div>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('home') }}" target="_blank" class="flex-1 text-center bg-white/10 hover:bg-white/20 text-slate-200 text-xs py-2 rounded-lg font-medium transition border border-white/10">
                    <i class="fa-solid fa-globe mr-1 text-gold-400"></i> Public Site
                </a>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" title="Logout" class="bg-rose-500/20 hover:bg-rose-500/35 text-rose-300 px-3 py-2 rounded-lg text-xs transition border border-rose-500/25">
                        <i class="fa-solid fa-power-off"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Container -->
    <div class="flex-1 lg:pl-64 flex flex-col min-h-screen">
        <!-- Top Glass Navigation -->
        <header class="bg-[#092014]/65 backdrop-blur-md border-b border-white/10 h-20 flex items-center justify-between px-4 sm:px-8 sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 text-slate-300 hover:text-white rounded-lg hover:bg-white/10 transition">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <div>
                    <h2 class="text-lg sm:text-xl font-bold text-white font-serif tracking-tight">@yield('page_title', 'Management Dashboard')</h2>
                    <p class="text-[11px] text-emerald-200/70 hidden sm:block">Sanda Guest House • Sella Katharagama</p>
                </div>
            </div>

            <div class="flex items-center gap-3 sm:gap-5">
                <div class="hidden md:flex items-center gap-3 text-xs text-slate-200 bg-white/[0.06] border border-white/10 px-3.5 py-2 rounded-full">
                    <i class="fa-regular fa-clock text-gold-400"></i>
                    <span class="font-semibold" x-text="currentTime"></span>
                </div>
                <a href="{{ route('admin.bookings.index', ['status' => 'pending']) }}" title="Pending Reservations" class="relative p-2.5 rounded-full bg-white/[0.06] hover:bg-white/15 border border-white/10 text-slate-200 hover:text-gold-400 transition hidden sm:flex items-center justify-center">
                    <i class="fa-regular fa-bell text-sm"></i>
                </a>
                <a href="{{ route('admin.bookings.create') }}" class="bg-gold-500 hover:bg-gold-400 text-brand-900 font-bold text-xs sm:text-sm px-4 py-2.5 rounded-xl shadow-lg shadow-black/25 flex items-center gap-2 transition">
                    <i class="fa-solid fa-plus"></i> New Reservation
                </a>
            </div>
        </header>

        <!-- Flash messages -->
        @if(session('success'))
            <div class="mx-4 sm:mx-8 mt-5">
                <div class="bg-emerald-950/90 border border-emerald-500/40 border-l-4 border-l-emerald-400 p-4 rounded-xl shadow-lg flex items-center justify-between text-emerald-100 text-sm font-medium backdrop-blur-md">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-circle-check text-emerald-400 text-lg"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-300 hover:text-white">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mx-4 sm:mx-8 mt-5">
                <div class="bg-rose-950/90 border border-rose-500/40 border-l-4 border-l-rose-400 p-4 rounded-xl shadow-lg flex items-center justify-between text-rose-100 text-sm font-medium backdrop-blur-md">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-circle-exclamation text-rose-400 text-lg"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-rose-300 hover:text-white">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>
        @endif

        <!-- Main Body -->
        <main class="flex-1 p-4 sm:p-7 admin-glass-theme">
            @yield('content')
        </main>
    </div>

    <!-- Global Invoice Popup Modal (In-Page Print Dialog) -->
    <div x-show="invoiceModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/75 backdrop-blur-xs flex items-center justify-center p-3 sm:p-6"
         @keydown.escape.window="invoiceModalOpen = false">
        <div class="bg-white rounded-3xl shadow-2xl max-w-4xl w-full overflow-hidden border border-slate-200 flex flex-col h-[90vh] max-h-[850px]"
             @click.outside="invoiceModalOpen = false">
            <!-- Modal Header Toolbar -->
            <div class="px-6 py-4 bg-slate-900 text-white flex items-center justify-between border-b border-slate-800 flex-shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gold-500/20 text-gold-400 flex items-center justify-center">
                        <i class="fa-solid fa-receipt text-sm"></i>
                    </div>
                    <div>
                        <h3 class="font-serif font-bold text-base text-white">Official Guest Invoice & Receipt</h3>
                        <p class="text-xs text-slate-400 font-mono" x-text="'Reservation Reference: ' + invoiceCode"></p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" @click="printInvoiceIframe()" class="bg-gold-500 hover:bg-gold-600 text-brand-900 font-bold px-4 py-2 rounded-xl text-xs flex items-center gap-1.5 transition shadow">
                        <i class="fa-solid fa-print"></i> Print Invoice
                    </button>
                    <button type="button" @click="invoiceModalOpen = false" class="text-slate-400 hover:text-white p-2 rounded-lg hover:bg-white/10 transition" title="Close [Esc]">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Iframe Body -->
            <div class="flex-1 bg-slate-100 p-2 sm:p-4 overflow-hidden">
                <iframe id="invoiceFrame" :src="invoiceUrl" class="w-full h-full rounded-2xl border border-slate-200 bg-white shadow-inner"></iframe>
            </div>
        </div>
    </div>

    <script>
        function adminPortalApp() {
            return {
                sidebarOpen: false,
                invoiceModalOpen: false,
                invoiceUrl: '',
                invoiceCode: '',
                currentTime: '',
                init() {
                    const updateClock = () => {
                        this.currentTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                    };
                    updateClock();
                    setInterval(updateClock, 30000);
                },
                openInvoiceModal(url, code) {
                    this.invoiceUrl = url;
                    this.invoiceCode = code;
                    this.invoiceModalOpen = true;
                },
                printInvoiceIframe() {
                    const frame = document.getElementById('invoiceFrame');
                    if (frame && frame.contentWindow) {
                        frame.contentWindow.focus();
                        frame.contentWindow.print();
                    }
                }
            }
        }
    </script>
</body>
</html>
