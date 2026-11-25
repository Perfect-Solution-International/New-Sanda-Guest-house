@extends('layouts.app')

@section('title', 'About Us - Sanda Guest House')

@section('content')
<section class="relative py-20 bg-brand-900 text-white text-center bg-cover bg-center border-b border-white/10" style="background-image: linear-gradient(rgba(14, 45, 28, 0.88), rgba(14, 45, 28, 0.94)), url('https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1600&q=80');">
    <div class="max-w-4xl mx-auto px-4 relative z-10">
        <span class="text-gold-400 font-semibold text-xs uppercase tracking-[0.25em] block mb-2">OUR STORY AND HERITAGE</span>
        <h1 class="text-4xl sm:text-5xl font-serif text-white mb-3">About Sanda Guest House</h1>
        <p class="text-slate-300 text-sm font-light max-w-2xl mx-auto leading-relaxed">
            Crafted for families seeking peace, refreshment, and sacred memories across our branch locations.
        </p>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6 text-slate-700 leading-relaxed text-base">
                <span class="text-gold-600 font-bold text-xs uppercase tracking-widest block">A Tranquil Haven</span>
                <h2 class="text-3xl font-serif font-bold text-brand-900">The Spirit of Sanda Guest House</h2>
                <p>
                    <strong>Sanda Guest House</strong> was born from a desire to provide travelers and pilgrims with an exceptional level of cleanliness, family comfort, and authentic Sri Lankan warmth across our branches.
                </p>
                <p>
                    "Sanda" symbolizes the soothing, calming glow of the moon—bringing serenity and peace to weary travelers. We offer a tranquil counterpoint to busy pilgrimages, allowing you to unwind in clean rooms, listen to birds chirping from nearby riverbanks, and savor fresh homestyle meals upon request.
                </p>
                <div class="bg-brand-50 p-6 rounded-2xl border border-brand-100">
                    <h4 class="font-bold text-brand-900 font-serif text-lg mb-2">Our Core Commitments</h4>
                    <ul class="space-y-2 text-sm text-slate-700">
                        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-brand-600"></i> Pure family atmosphere with secure gated premises</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-brand-600"></i> Highest standards of linen cleanliness and sanitized bathrooms</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-brand-600"></i> Hot water showers and comfortable A/C & fan rooms</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-brand-600"></i> Helpful local guidance for Kataragama Pooja and Sella Temple visits</li>
                    </ul>
                </div>
            </div>

            <div class="space-y-6">
                <img src="{{ asset('images/logo.png') }}" alt="Sanda Logo" class="max-h-56 mx-auto object-contain drop-shadow-xl">
                <div class="grid grid-cols-2 gap-4">
                    <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=800&q=80" alt="Sanda" class="rounded-xl shadow h-48 w-full object-cover">
                    <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=800&q=80" alt="Room" class="rounded-xl shadow h-48 w-full object-cover">
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
