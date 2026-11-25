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
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden w-full max-w-md">
        <div class="bg-brand-900 p-8 text-center text-white space-y-3">
            <img src="{{ asset('images/logo.png') }}" alt="Sanda" class="h-16 mx-auto object-contain">
            <div>
                <h1 class="font-serif font-bold text-2xl text-white">Sanda Guest House</h1>
                <p class="text-xs text-gold-400 font-semibold uppercase tracking-widest mt-0.5">Staff Management Portal</p>
            </div>
        </div>

        <div class="p-8">
            @if($errors->any())
                <div class="bg-rose-50 text-rose-700 p-3 rounded-xl text-xs mb-6 border border-rose-200">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="admin@example.com" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Password</label>
                    <input type="password" name="password" required placeholder="••••••••" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center text-slate-600">
                        <input type="checkbox" name="remember" class="rounded text-brand-700 focus:ring-brand-700 mr-2"> Remember login
                    </label>
                </div>

                <button type="submit" class="w-full bg-brand-700 hover:bg-brand-800 text-white font-bold py-3 rounded-xl shadow-md transition text-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-right-to-bracket text-gold-400"></i> Sign In to Dashboard
                </button>
            </form>
        </div>
    </div>

</body>
</html>
