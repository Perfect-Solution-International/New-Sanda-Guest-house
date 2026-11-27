@extends('layouts.app')

@section('title', 'Facilities and Comforts - Sanda Guest House')

@section('content')
<section class="py-16 bg-brand-900 text-white text-center relative overflow-hidden border-b border-white/10">
    <div class="max-w-3xl mx-auto px-4 relative z-10">
        <span class="text-gold-400 font-semibold text-xs uppercase tracking-[0.25em] block mb-2">HOSPITALITY AMENITIES</span>
        <h1 class="text-4xl sm:text-5xl font-serif text-white mb-3">Facilities and Comforts</h1>
        <p class="text-slate-300 text-sm font-light">Everything you need for a comfortable, clean, and restful family stay — plus authentic photos of our rooms, bathrooms, and parking.</p>
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

<!-- Photo Gallery Section -->
<section class="py-16 bg-white border-t border-slate-200" x-data="{ activeCategory: 'all' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <div class="text-center max-w-2xl mx-auto">
            <span class="text-gold-600 font-bold text-xs uppercase tracking-[0.25em] block mb-2">VISUAL PROPERTY TOUR</span>
            <h2 class="text-3xl sm:text-4xl font-serif text-slate-900 mb-2">Photo Gallery</h2>
            <p class="text-slate-600 text-sm font-light">Explore authentic photos of our clean family rooms, attached bathrooms, and secure gated parking.</p>
        </div>

        <!-- Category Filter Tabs -->
        <div class="flex flex-wrap items-center justify-center gap-2">
            <button @click="activeCategory = 'all'"
                    class="px-5 py-2.5 rounded-full text-xs font-bold transition shadow-xs"
                    :class="activeCategory === 'all' ? 'bg-brand-700 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'">
                All Photos
            </button>
            <button @click="activeCategory = 'rooms'"
                    class="px-5 py-2.5 rounded-full text-xs font-bold transition shadow-xs"
                    :class="activeCategory === 'rooms' ? 'bg-brand-700 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'">
                Rooms &amp; Suites
            </button>
            <button @click="activeCategory = 'bathrooms'"
                    class="px-5 py-2.5 rounded-full text-xs font-bold transition shadow-xs"
                    :class="activeCategory === 'bathrooms' ? 'bg-brand-700 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'">
                Bathrooms &amp; Hot Water
            </button>
            <button @click="activeCategory = 'exterior'"
                    class="px-5 py-2.5 rounded-full text-xs font-bold transition shadow-xs"
                    :class="activeCategory === 'exterior' ? 'bg-brand-700 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'">
                Exterior &amp; Grounds
            </button>
            <button @click="activeCategory = 'parking'"
                    class="px-5 py-2.5 rounded-full text-xs font-bold transition shadow-xs"
                    :class="activeCategory === 'parking' ? 'bg-brand-700 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'">
                Parking &amp; Common Areas
            </button>
        </div>

        @php
            $photos = [
                ['url' => '/uploads/rooms/standard-ac-double-room.jpg', 'title' => 'Standard A/C Double Bedroom', 'category' => 'rooms', 'badge' => 'Double Bed'],
                ['url' => '/uploads/gallery/bedroom-2.jpg', 'title' => 'Spacious Guest Bedroom', 'category' => 'rooms', 'badge' => 'Guest Room'],
                ['url' => '/uploads/gallery/room-bathroom-door.jpg', 'title' => 'Private Room & Attached Bathroom Entrance', 'category' => 'bathrooms', 'badge' => 'Attached Bath'],
                ['url' => '/uploads/gallery/exterior-parking.jpg', 'title' => 'Property Exterior & Secure Gated Parking', 'category' => 'exterior parking', 'badge' => 'Exterior & Parking'],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($photos as $photo)
                <div x-show="activeCategory === 'all' || '{{ $photo['category'] }}'.includes(activeCategory)"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="group relative overflow-hidden rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 h-72 bg-slate-900">
                    <img src="{{ $photo['url'] }}" alt="{{ $photo['title'] }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700 opacity-95 group-hover:opacity-100">

                    <div class="absolute top-3 left-3 bg-brand-950/80 backdrop-blur-md text-gold-400 text-[10px] font-bold px-2.5 py-1 rounded-full border border-white/10 uppercase tracking-wider">
                        {{ $photo['badge'] }}
                    </div>

                    <div class="absolute inset-0 bg-gradient-to-t from-brand-950/90 via-brand-950/30 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-6">
                        <span class="text-white font-serif font-bold text-base drop-shadow">{{ $photo['title'] }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
