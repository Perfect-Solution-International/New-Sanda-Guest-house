<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login - Sanda Guest House</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            700: '#174b2d',
                            800: '#133d25',
                            900: '#0e2d1c',
                        },
                        gold: {
                            400: '#f3b747',
                            500: '#d99726',
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
    <style>
        [x-cloak] { display: none !important; }
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-text-fill-color: #ffffff;
            -webkit-box-shadow: 0 0 0px 1000px rgba(10, 22, 15, 0.92) inset;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
</head>
<body class="min-h-screen bg-[#06150d] flex items-center justify-center p-4 sm:p-6 relative overflow-hidden"
      style="background-image: radial-gradient(circle at 18% 22%, rgba(43, 122, 75, 0.40), transparent 46%), radial-gradient(circle at 82% 78%, rgba(217, 151, 38, 0.20), transparent 45%), linear-gradient(135deg, #05110a 0%, #0e2d1c 50%, #07190f 100%);">

    <!-- Custom Geometric & Organic Resort Vector Design (No Photo) -->
    <svg class="pointer-events-none fixed inset-0 w-full h-full opacity-35" viewBox="0 0 1440 900" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <linearGradient id="goldArc" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#f3b747" stop-opacity="0.45"/>
                <stop offset="100%" stop-color="#2b7a4b" stop-opacity="0.05"/>
            </linearGradient>
            <linearGradient id="waveGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                <stop offset="0%" stop-color="#2b7a4b" stop-opacity="0.28"/>
                <stop offset="50%" stop-color="#f3b747" stop-opacity="0.18"/>
                <stop offset="100%" stop-color="#174b2d" stop-opacity="0.25"/>
            </linearGradient>
        </defs>
        <!-- Crescent Sun / Moon Rings (Echoing Sanda Logo) -->
        <circle cx="1180" cy="180" r="340" fill="none" stroke="url(#goldArc)" stroke-width="1.5"/>
        <circle cx="1180" cy="180" r="260" fill="none" stroke="url(#goldArc)" stroke-width="1" stroke-dasharray="6 10"/>
        <circle cx="220" cy="760" r="290" fill="none" stroke="url(#goldArc)" stroke-width="1.2"/>
        <!-- Flowing Resort Waves -->
        <path d="M-80 720 C 260 600, 580 840, 960 690 C 1200 595, 1360 650, 1520 590 L 1520 960 L -80 960 Z" fill="url(#waveGrad)"/>
        <path d="M-80 790 C 310 680, 640 880, 1020 750 C 1240 675, 1380 720, 1520 680 L 1520 960 L -80 960 Z" fill="#040e08" fill-opacity="0.45"/>
    </svg>

    <!-- Soft Ambient Glow Orbs -->
    <div class="pointer-events-none fixed -top-24 -left-24 w-96 h-96 rounded-full bg-emerald-500/15 blur-3xl"></div>
    <div class="pointer-events-none fixed -bottom-24 -right-24 w-96 h-96 rounded-full bg-gold-500/15 blur-3xl"></div>

    <!-- Main Split Glassmorphic Card -->
    <div class="relative z-10 w-full max-w-4xl rounded-3xl overflow-hidden shadow-[0_25px_70px_rgba(0,0,0,0.65)] border border-white/15 grid grid-cols-1 md:grid-cols-12 backdrop-blur-sm">

        <!-- Left Side: Tropical Glass Welcome Panel -->
        <div class="md:col-span-6 bg-brand-900/50 backdrop-blur-md p-8 sm:p-11 flex flex-col justify-between text-white border-b md:border-b-0 md:border-r border-white/10">
            <div class="flex items-center justify-between gap-3">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group" title="Return to Sanda Guest House">
                    <img src="{{ asset('images/logo-nobg.png') }}?v={{ filemtime(public_path('images/logo-nobg.png')) }}" alt="Sanda" class="h-12 w-auto object-contain transition group-hover:scale-105">
                    <div>
                        <div class="font-serif font-bold text-xl text-white leading-none group-hover:text-gold-400 transition">Sanda</div>
                        <div class="text-[9px] text-gold-400 font-semibold uppercase tracking-[0.22em] mt-1">Guest House</div>
                    </div>
                </a>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-white/80 hover:text-white bg-white/10 hover:bg-white/20 px-3 py-1.5 rounded-full border border-white/15 transition">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i> Home
                </a>
            </div>

            <div class="my-10 md:my-0 space-y-4">
                <span class="inline-block text-[10px] font-bold uppercase tracking-[0.25em] text-gold-400 bg-black/25 px-3 py-1 rounded-full border border-gold-400/30">
                    Staff Management Portal
                </span>
                <h1 class="text-3xl sm:text-4xl font-bold tracking-tight leading-tight text-white">
                    Welcome Back
                </h1>
                <p class="text-sm text-slate-200/85 leading-relaxed font-normal max-w-sm">
                    Manage reservations, physical room availability, guest check-ins, and daily operations for Sanda Guest House, Sella Katharagama.
                </p>
            </div>

            <div class="flex items-center gap-2 text-[11px] text-emerald-200/80">
                <i class="fa-solid fa-shield-halved text-emerald-400"></i>
                <span>Secure Staff Access • Sella Katharagama</span>
            </div>
        </div>

        <!-- Right Side: Dark Sign-In Form -->
        <div class="md:col-span-6 bg-black/75 backdrop-blur-xl p-8 sm:p-11 text-white flex flex-col justify-center"
             x-data="{
                 email: '{{ old('email', 'admin@sandaguesthouse.lk') }}',
                 password: 'admin123',
                 showPassword: false,
                 showHint: false
             }">

            <div class="mb-7">
                <h2 class="text-2xl font-bold text-white tracking-tight">Login</h2>
                <p class="text-xs text-slate-400 mt-1">Enter your staff credentials to access the dashboard.</p>
            </div>

            @if($errors->any())
                <div class="bg-rose-500/15 text-rose-200 p-3.5 rounded-xl text-xs mb-5 border border-rose-500/30 flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-exclamation text-rose-400"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Your Email</label>
                    <div class="relative">
                        <input type="email"
                               name="email"
                               x-model="email"
                               required
                               placeholder="admin@sandaguesthouse.lk"
                               class="w-full bg-transparent border-0 border-b border-white/25 focus:border-emerald-400 px-0 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-0 transition">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Password</label>
                    <div class="relative flex items-center">
                        <input :type="showPassword ? 'text' : 'password'"
                               name="password"
                               x-model="password"
                               required
                               placeholder="••••••••"
                               class="w-full bg-transparent border-0 border-b border-white/25 focus:border-emerald-400 pl-0 pr-9 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-0 transition">
                        <button type="button"
                                @click="showPassword = !showPassword"
                                class="absolute right-0 text-slate-400 hover:text-white p-1.5 transition"
                                :title="showPassword ? 'Hide password' : 'Show password'">
                            <i class="fa-solid text-xs" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center text-slate-300 cursor-pointer select-none">
                        <input type="checkbox" name="remember" checked class="rounded bg-white/10 border-white/25 text-emerald-500 focus:ring-emerald-500 mr-2">
                        Remember login
                    </label>
                    <button type="button" @click="showHint = !showHint" class="text-[11px] text-emerald-400 hover:text-emerald-300 font-semibold transition">
                        <i class="fa-solid fa-key mr-1"></i> Default Login
                    </button>
                </div>

                <!-- Optional Collapsible Quick Credentials & Auto-Fill -->
                <div x-show="showHint" x-cloak x-transition class="p-3.5 rounded-xl bg-white/5 border border-white/10 text-[11px] space-y-2">
                    <div class="text-slate-300 font-mono space-y-0.5">
                        <div>Email: <span class="text-white font-semibold">admin@sandaguesthouse.lk</span></div>
                        <div>Password: <span class="text-white font-semibold">admin123</span></div>
                    </div>
                    <div class="flex flex-wrap gap-2 pt-1">
                        <button type="button" @click="email='admin@sandaguesthouse.lk'; password='admin123'"
                                class="text-[10px] bg-emerald-600/30 hover:bg-emerald-600/50 text-emerald-200 font-semibold px-2.5 py-1 rounded-lg border border-emerald-500/30 transition cursor-pointer">
                            Fill Guest House Admin
                        </button>
                        <button type="button" @click="email='admin@sandaresort.com'; password='admin123'"
                                class="text-[10px] bg-white/10 hover:bg-white/20 text-slate-200 font-semibold px-2.5 py-1 rounded-lg border border-white/15 transition cursor-pointer">
                            Fill Resort Admin
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full bg-brand-700 hover:bg-brand-800 border border-white/15 text-white font-bold py-3.5 rounded-lg shadow-lg shadow-black/40 transition text-sm flex items-center justify-center gap-2 cursor-pointer">
                    <span>Login</span>
                    <i class="fa-solid fa-arrow-right text-xs text-gold-400"></i>
                </button>
            </form>
        </div>

    </div>

</body>
</html>
