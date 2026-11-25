@extends('layouts.app')

@section('title', 'Photo Gallery - Sanda Guest House')

@section('content')
<section class="py-16 bg-brand-900 text-white text-center relative overflow-hidden border-b border-white/10">
    <div class="max-w-4xl mx-auto px-4 relative z-10">
        <span class="text-gold-400 font-semibold text-xs uppercase tracking-[0.25em] block mb-2">VISUAL PROPERTY TOUR</span>
        <h1 class="text-4xl sm:text-5xl font-serif text-white mb-3">Photo Gallery</h1>
        <p class="text-slate-300 text-sm font-light max-w-2xl mx-auto">
            Explore authentic photos of our clean family rooms, spotless bathrooms, secure parking, and peaceful surroundings across our locations.
        </p>
    </div>
</section>

<section class="py-16 bg-stone-50" x-data="{ activeCategory: 'all' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

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
                Rooms & Suites
            </button>
            <button @click="activeCategory = 'bathrooms'"
                    class="px-5 py-2.5 rounded-full text-xs font-bold transition shadow-xs"
                    :class="activeCategory === 'bathrooms' ? 'bg-brand-700 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'">
                Bathrooms & Hot Water
            </button>
            <button @click="activeCategory = 'exterior'"
                    class="px-5 py-2.5 rounded-full text-xs font-bold transition shadow-xs"
                    :class="activeCategory === 'exterior' ? 'bg-brand-700 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'">
                Exterior & Grounds
            </button>
            <button @click="activeCategory = 'parking'"
                    class="px-5 py-2.5 rounded-full text-xs font-bold transition shadow-xs"
                    :class="activeCategory === 'parking' ? 'bg-brand-700 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'">
                Parking & Common Areas
            </button>
        </div>

        <!-- Photos Grid -->
        @php
            $photos = [
                ['url' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80', 'title' => 'Standard A/C Double Bedroom', 'category' => 'rooms', 'badge' => 'Double Bed'],
                ['url' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=1200&q=80', 'title' => 'Family Suite with Two Double Beds', 'category' => 'rooms', 'badge' => 'Family A/C'],
                ['url' => 'https://images.unsplash.com/photo-1591088398332-8a7791972843?auto=format&fit=crop&w=1200&q=80', 'title' => 'Non-A/C Clean Budget Room', 'category' => 'rooms', 'badge' => 'Budget Group'],
                ['url' => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80', 'title' => 'Attached Bathroom with Hot Water Shower', 'category' => 'bathrooms', 'badge' => 'Hot Shower'],
                ['url' => 'https://images.unsplash.com/photo-1620626011761-996317b8d101?auto=format&fit=crop&w=1200&q=80', 'title' => 'Spotless Private Bathroom Vanity', 'category' => 'bathrooms', 'badge' => 'Sanitized'],
                ['url' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80', 'title' => 'Resort Property Exterior & Garden', 'category' => 'exterior', 'badge' => 'Exterior'],
                ['url' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=80', 'title' => 'Peaceful River-Breeze Veranda', 'category' => 'exterior', 'badge' => 'Garden Veranda'],
                ['url' => 'https://images.unsplash.com/photo-1506521781263-d8422e82f27a?auto=format&fit=crop&w=1200&q=80', 'title' => 'Secure 24/7 Gated Vehicle Parking Area', 'category' => 'parking', 'badge' => 'Secure Parking'],
                ['url' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1200&q=80', 'title' => 'Guest Dining & Common Seating Area', 'category' => 'parking', 'badge' => 'Common Lounge'],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($photos as $photo)
                <div x-show="activeCategory === 'all' || activeCategory === '{{ $photo['category'] }}'"
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
