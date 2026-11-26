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
</head>
<body class="bg-slate-100 min-h-screen flex flex-col items-center justify-center p-4">

    <div class="w-full max-w-md mb-4 flex items-center justify-between px-1">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-brand-900 transition bg-white/90 hover:bg-white px-3.5 py-1.5 rounded-full shadow-sm border border-slate-200">
            <i class="fa-solid fa-arrow-left text-brand-700"></i> Back to Website
        </a>
        <a href="{{ route('home') }}" class="text-[11px] text-slate-400 hover:text-brand-800 transition">
            <i class="fa-solid fa-house mr-1"></i> Home
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden w-full max-w-md">
        <div class="bg-brand-900 p-8 text-center text-white space-y-3">
            <a href="{{ route('home') }}" class="inline-block group" title="Return to Sanda Guest House Home">
                <img src="{{ asset('images/logo.png') }}" alt="Sanda" class="h-16 mx-auto object-contain transition group-hover:scale-105">
                <div class="mt-2">
                    <h1 class="font-serif font-bold text-2xl text-white group-hover:text-gold-300 transition">Sanda Guest House</h1>
                    <p class="text-xs text-gold-400 font-semibold uppercase tracking-widest mt-0.5">Staff Management Portal</p>
                </div>
            </a>
        </div>

        <div class="p-8">
            @if($errors->any())
                <div class="bg-rose-50 text-rose-700 p-3 rounded-xl text-xs mb-6 border border-rose-200">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Quick Default Credentials Notice with 1-Click Auto Fill -->
            <div class="mb-5 p-4 rounded-2xl bg-amber-50/90 border border-amber-200 text-xs space-y-2.5 shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="font-bold text-amber-950 uppercase tracking-wider text-[10px] flex items-center gap-1.5">
                        <i class="fa-solid fa-key text-gold-600"></i> Default Admin Credentials (පෙරනිමි පිවිසුම)
                    </span>
                    <span class="text-[10px] bg-amber-200/80 text-amber-900 font-bold px-2 py-0.5 rounded-full">Super Admin</span>
                </div>
                <div class="space-y-1 text-slate-700 font-mono text-[11px] bg-white/80 p-2.5 rounded-xl border border-amber-100">
                    <div>Email: <strong class="text-slate-900">shelinim.senevirathna@gmail.com</strong></div>
                    <div>Default Password: <strong class="text-slate-900">admin123</strong></div>
                </div>
            </div>

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4"
                  x-data="{ email: '{{ old('email', 'shelinim.senevirathna@gmail.com') }}', password: 'admin123' }">
                @csrf
                
                <div class="flex items-center justify-end gap-1.5 pb-1">
                    <button type="button" @click="email='shelinim.senevirathna@gmail.com'; password='admin123'" 
                            class="text-[10px] text-amber-800 hover:text-amber-900 bg-amber-100/70 hover:bg-amber-100 font-bold px-2.5 py-1 rounded-lg transition flex items-center gap-1 border border-amber-300/60 cursor-pointer">
                        <i class="fa-solid fa-wand-magic-sparkles text-amber-600"></i> Fill Shelini Login
                    </button>
                    <button type="button" @click="email='admin@sandaresort.com'; password='admin123'" 
                            class="text-[10px] text-slate-700 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 font-bold px-2.5 py-1 rounded-lg transition flex items-center gap-1 border border-slate-200 cursor-pointer">
                        Fill Resort Admin
                    </button>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Email Address</label>
                    <input type="email" name="email" x-model="email" required placeholder="admin@example.com" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Password</label>
                    <input type="password" name="password" x-model="password" required placeholder="••••••••" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    <span class="text-[10px] text-slate-400 mt-1 block">Default system password: <strong>admin123</strong></span>
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center text-slate-600 cursor-pointer">
                        <input type="checkbox" name="remember" checked class="rounded text-brand-700 focus:ring-brand-700 mr-2"> Remember login
                    </label>
                </div>

                <button type="submit" class="w-full bg-brand-700 hover:bg-brand-800 text-white font-bold py-3 rounded-xl shadow-md transition text-sm flex items-center justify-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-right-to-bracket text-gold-400"></i> Sign In to Dashboard
                </button>
            </form>

            <div class="mt-6 pt-5 border-t border-slate-100 text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-brand-800 transition">
                    <i class="fa-solid fa-arrow-left text-[11px] text-brand-700"></i> Return to Main Website
                </a>
            </div>
        </div>
    </div>

</body>
</html>
