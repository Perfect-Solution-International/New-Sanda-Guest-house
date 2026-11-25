@extends('layouts.app')

@section('title', 'About Us & Policies - Sanda Guest House')

@section('content')
<!-- Header -->
<section class="relative py-20 bg-brand-900 text-white text-center bg-cover bg-center border-b border-white/10" style="background-image: linear-gradient(rgba(14, 45, 28, 0.90), rgba(14, 45, 28, 0.94)), url('https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1600&q=80');">
    <div class="max-w-4xl mx-auto px-4 relative z-10">
        <span class="text-gold-400 font-semibold text-xs uppercase tracking-[0.25em] block mb-2">OUR STORY & GUEST POLICIES</span>
        <h1 class="text-4xl sm:text-5xl font-serif text-white mb-3">About Sanda Guest House</h1>
        <p class="text-slate-300 text-sm font-light max-w-2xl mx-auto leading-relaxed">
            A tranquil sanctuary crafted for families and pilgrims seeking genuine cleanliness, peaceful refreshment, and sacred memories across our branch locations.
        </p>
    </div>
</section>

<!-- Story & Core Standards -->
<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6 text-slate-700 leading-relaxed text-sm sm:text-base">
                <span class="text-gold-600 font-bold text-xs uppercase tracking-widest block">A Tranquil Haven</span>
                <h2 class="text-3xl font-serif font-bold text-brand-900">The Story of Sanda</h2>
                <p>
                    <strong>Sanda Guest House</strong> was founded with a clear purpose: to offer visiting pilgrims and holiday travellers an honest, peaceful, and spotlessly clean sanctuary with true Sri Lankan hospitality.
                </p>
                <p>
                    In Sinhala, <em>"Sanda"</em> represents the gentle, soothing glow of the moon—bringing serenity and comfort to tired travelers. We pride ourselves on creating a calm counterpoint to bustling pilgrimages, giving your family a restful base with clean beds, attached hot water bathrooms, secure parking, and wholesome home-cooked meals upon request.
                </p>

                <!-- Cleanliness & Safety Standards -->
                <div class="bg-brand-50/80 p-6 rounded-2xl border border-brand-100 space-y-3">
                    <h4 class="font-bold text-brand-900 font-serif text-base flex items-center gap-2">
                        <i class="fa-solid fa-sparkles text-gold-500"></i> Cleanliness & Safety Standards
                    </h4>
                    <ul class="space-y-2 text-xs sm:text-sm text-slate-700">
                        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-brand-600 text-xs"></i> <strong>Sanitized Bathrooms:</strong> Rigorous daily disinfection and continuous 24/7 hot shower water.</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-brand-600 text-xs"></i> <strong>Fresh Crisp Linens:</strong> 100% fresh, steam-washed bedsheets and pillowcases for every new guest.</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-brand-600 text-xs"></i> <strong>24/7 Secure Gated Compound:</strong> Safe on-site overnight vehicle parking with night staff care.</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-brand-600 text-xs"></i> <strong>Family Atmosphere:</strong> Strictly quiet, alcohol-respectful, and family-friendly environment.</li>
                    </ul>
                </div>
            </div>

            <div class="space-y-6">
                <img src="{{ asset('images/logo.png') }}" alt="Sanda Logo" class="max-h-48 mx-auto object-contain drop-shadow-md">
                <div class="grid grid-cols-2 gap-4">
                    <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=800&q=80" alt="Resort Grounds" class="rounded-2xl shadow h-48 w-full object-cover">
                    <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=800&q=80" alt="Clean Room" class="rounded-2xl shadow h-48 w-full object-cover">
                </div>
            </div>
        </div>

        <!-- Check-in/Check-out Policies & Cancellation Rules (Cards Grid) -->
        <div class="pt-8 border-t border-slate-100">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="text-gold-600 font-bold text-xs uppercase tracking-widest block mb-1">TRANSPARENCY & GUIDELINES</span>
                <h3 class="text-3xl font-serif font-bold text-slate-900">Check-in, Check-out & Cancellation Rules</h3>
                <p class="text-xs text-slate-500 mt-1">Clear, straightforward policies to ensure smooth travel for every visiting family.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Check-in Policy -->
                <div class="bg-stone-50 p-6 rounded-2xl border border-slate-200 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-brand-100 text-brand-800 flex items-center justify-center text-lg font-bold">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <h4 class="font-serif font-bold text-base text-slate-900">Check-in & Check-out Times</h4>
                    <ul class="text-xs text-slate-600 space-y-2 leading-relaxed">
                        <li><strong>Standard Check-in:</strong> From 02:00 PM onwards.</li>
                        <li><strong>Standard Check-out:</strong> By 11:00 AM on departure day.</li>
                        <li><strong>Early Arrival / Late Check-out:</strong> Available upon prior request (subject to room availability).</li>
                        <li><strong>Hourly / Day-use Stays:</strong> Flexible check-in/out times accommodated through our live booking desk.</li>
                    </ul>
                </div>

                <!-- Cancellation Rules -->
                <div class="bg-stone-50 p-6 rounded-2xl border border-slate-200 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center text-lg font-bold">
                        <i class="fa-solid fa-file-contract"></i>
                    </div>
                    <h4 class="font-serif font-bold text-base text-slate-900">Cancellation & Rescheduling Rules</h4>
                    <ul class="text-xs text-slate-600 space-y-2 leading-relaxed">
                        <li><strong>Free Rescheduling:</strong> Change your dates up to 48 hours prior to arrival at zero penalty.</li>
                        <li><strong>Advance Deposit Policy:</strong> Advance payments lock your room dates; in case of emergency cancellations, credits can be rolled over to future dates.</li>
                        <li><strong>No-show Policy:</strong> Unnotified no-shows release the room at midnight to assist waiting devotees.</li>
                    </ul>
                </div>

                <!-- House Rules -->
                <div class="bg-stone-50 p-6 rounded-2xl border border-slate-200 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-lg font-bold">
                        <i class="fa-solid fa-shield-heart"></i>
                    </div>
                    <h4 class="font-serif font-bold text-base text-slate-900">Guest Respect & Sacred Conduct</h4>
                    <ul class="text-xs text-slate-600 space-y-2 leading-relaxed">
                        <li><strong>Sacred Environment:</strong> Guests are requested to respect sacred pilgrim atmosphere and maintain quiet hours after 10:00 PM.</li>
                        <li><strong>Valid Identification:</strong> Primary guest NIC, driving license, or passport required during desk registration.</li>
                        <li><strong>Meals Preparation:</strong> Pure vegetarian and home-style meal requests should be placed 2 hours in advance.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Nearby Landmarks & Sacred Pilgrim Destinations -->
        <div class="pt-8 border-t border-slate-100">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="text-gold-600 font-bold text-xs uppercase tracking-widest block mb-1">LOCAL PILGRIMAGE DESTINATIONS</span>
                <h3 class="text-3xl font-serif font-bold text-slate-900">Nearby Sacred Landmarks</h3>
                <p class="text-xs text-slate-500 mt-1">Conveniently situated near Kataragama's most venerated temples and natural wonders.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-5">
                <div class="bg-stone-50 p-5 rounded-2xl border border-slate-200 space-y-2">
                    <span class="text-xs font-bold text-gold-600 uppercase tracking-wider block">1.2 km • 3 mins</span>
                    <h4 class="font-serif font-bold text-base text-slate-900">Sella Temple & Menik Ganga</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">Historic Sella Kataragama Ganesh devalaya and the sacred bathing ghats of Menik Ganga.</p>
                </div>

                <div class="bg-stone-50 p-5 rounded-2xl border border-slate-200 space-y-2">
                    <span class="text-xs font-bold text-gold-600 uppercase tracking-wider block">4.5 km • 10 mins</span>
                    <h4 class="font-serif font-bold text-base text-slate-900">Ruhunu Kataragama Maha Devalaya</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">The focal shrine dedicated to God Skanda-Murugan, hosting daily morning, afternoon & night poojas.</p>
                </div>

                <div class="bg-stone-50 p-5 rounded-2xl border border-slate-200 space-y-2">
                    <span class="text-xs font-bold text-gold-600 uppercase tracking-wider block">5.0 km • 12 mins</span>
                    <h4 class="font-serif font-bold text-base text-slate-900">Kiri Vehera Sacred Stupa</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">Ancient Buddhist stupa built by King Mahasena, radiating spiritual peace under the evening breeze.</p>
                </div>

                <div class="bg-stone-50 p-5 rounded-2xl border border-slate-200 space-y-2">
                    <span class="text-xs font-bold text-gold-600 uppercase tracking-wider block">18 km • 25 mins</span>
                    <h4 class="font-serif font-bold text-base text-slate-900">Yala National Park (Katagamuwa)</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">Direct safari gate access to world-famous leopard, elephant, and sloth bear wilderness.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
