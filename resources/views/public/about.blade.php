@extends('layouts.app')

@section('title', 'About Us - නිවි සඳ (Nivi Sanda) Family Holiday Resort')

@section('content')
<section class="relative py-20 bg-brand-900 text-white text-center bg-cover bg-center" style="background-image: linear-gradient(rgba(14, 45, 28, 0.85), rgba(14, 45, 28, 0.9)), url('https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1600&q=80');">
    <div class="max-w-4xl mx-auto px-4">
        <span class="text-gold-400 font-bold text-xs uppercase tracking-widest block mb-2">Our Story & Heritage</span>
        <h1 class="text-4xl sm:text-5xl font-serif font-bold text-white mb-4">About Nivi Sanda Resort</h1>
        <p class="text-slate-200 text-base max-w-2xl mx-auto font-light">
            Crafted for families seeking peace, refreshment, and sacred memories in the heart of Sella Katharagama.
        </p>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6 text-slate-700 leading-relaxed text-base">
                <span class="text-gold-600 font-bold text-xs uppercase tracking-widest block">A Tranquil Haven</span>
                <h2 class="text-3xl font-serif font-bold text-brand-900">The Spirit of නිවි සඳ (Nivi Sanda)</h2>
                <p>
                    Nestled just off Sella Road in Sella Katharagama, <strong>නිවි සඳ (Nivi Sanda) Family Holiday Resort</strong> was born from a desire to provide travelers and pilgrims with an exceptional level of cleanliness, family comfort, and authentic Sri Lankan warmth.
                </p>
                <p>
                    "නිවි සඳ" symbolizes the soothing, calming glow of the moon—bringing serenity and peace to weary travelers. Our resort offers a tranquil counterpoint to busy pilgrimages and thrilling safari adventures, allowing you to unwind by our illuminated swimming pool, listen to birds chirping from nearby riverbanks, and savor fresh homestyle meals prepared by our local chefs.
                </p>
                <div class="bg-brand-50 p-6 rounded-2xl border border-brand-100">
                    <h4 class="font-bold text-brand-900 font-serif text-lg mb-2">Our Core Commitments</h4>
                    <ul class="space-y-2 text-sm text-slate-700">
                        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-brand-600"></i> Pure family atmosphere with 24/7 security & CCTV</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-brand-600"></i> Highest standards of linen cleanliness and hygiene</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-brand-600"></i> Full backup electricity generator for uninterrupted comfort</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-brand-600"></i> Comprehensive assistance for Kataragama Pooja and Yala Safaris</li>
                    </ul>
                </div>
            </div>

            <div class="space-y-6">
                <img src="{{ asset('images/logo.jpg') }}" alt="Nivi Sanda Logo" class="max-h-56 mx-auto object-contain drop-shadow-xl rounded-2xl">
                <div class="grid grid-cols-2 gap-4">
                    <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=800&q=80" alt="Villa" class="rounded-xl shadow h-48 w-full object-cover">
                    <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=800&q=80" alt="Room" class="rounded-xl shadow h-48 w-full object-cover">
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
