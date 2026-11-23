@extends('layouts.app')

@section('title', 'Facilities - New Sanda')

@section('content')
<section class="py-12 bg-brand-900 text-white text-center">
    <div class="max-w-3xl mx-auto px-4">
        <h1 class="text-3xl font-serif font-bold text-white mb-2">Facilities & Comforts</h1>
        <p class="text-slate-200 text-sm">Everything you need for a comfortable, clean, and restful family stay in Sella Katharagama.</p>
    </div>
</section>

<section class="py-16 bg-stone-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <!-- A/C and Fans -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-2">
                <i class="fa-solid fa-snowflake text-2xl text-brand-700"></i>
                <h3 class="font-bold text-slate-900 text-base">A/C & Non-A/C Rooms</h3>
                <p class="text-xs text-slate-600 leading-relaxed">Choose between inverter air-conditioned rooms or well-ventilated rooms with ceiling fans according to your preference and budget.</p>
            </div>

            <!-- Attached Bathrooms -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-2">
                <i class="fa-solid fa-shower text-2xl text-brand-700"></i>
                <h3 class="font-bold text-slate-900 text-base">Hot Water Showers</h3>
                <p class="text-xs text-slate-600 leading-relaxed">Every room includes a spotless attached private bathroom with 24/7 hot and cold water shower.</p>
            </div>

            <!-- Parking -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-2">
                <i class="fa-solid fa-square-parking text-2xl text-brand-700"></i>
                <h3 class="font-bold text-slate-900 text-base">Spacious Safe Parking</h3>
                <p class="text-xs text-slate-600 leading-relaxed">Ample on-premises secure parking space for pilgrim vans, family cars, and travel buses inside our gated premises.</p>
            </div>

            <!-- Wi-Fi -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-2">
                <i class="fa-solid fa-wifi text-2xl text-brand-700"></i>
                <h3 class="font-bold text-slate-900 text-base">Free Wi-Fi</h3>
                <p class="text-xs text-slate-600 leading-relaxed">High-speed wireless internet connection available for guests across the property.</p>
            </div>

            <!-- Home-Cooked Food -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-2">
                <i class="fa-solid fa-utensils text-2xl text-brand-700"></i>
                <h3 class="font-bold text-slate-900 text-base">Meals on Request</h3>
                <p class="text-xs text-slate-600 leading-relaxed">Fresh, authentic Sri Lankan rice and curry or morning string hoppers/roti prepared upon prior notification.</p>
            </div>

            <!-- Temple Distance -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-2">
                <i class="fa-solid fa-location-dot text-2xl text-brand-700"></i>
                <h3 class="font-bold text-slate-900 text-base">5 Mins to Sella Temple</h3>
                <p class="text-xs text-slate-600 leading-relaxed">Walking distance to Sella Kataragama temple and Menik Ganga, and just 10 minutes drive to Kataragama Maha Devalaya.</p>
            </div>
        </div>

        <div class="mt-12 text-center">
            <a href="tel:+94779876543" class="inline-flex items-center gap-2 bg-brand-700 hover:bg-brand-800 text-white font-bold py-3 px-8 rounded-full shadow text-sm">
                <i class="fa-solid fa-phone"></i> Call for Inquiries: 077 987 6543
            </a>
        </div>
    </div>
</section>
@endsection
