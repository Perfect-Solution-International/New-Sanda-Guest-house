@extends('layouts.app')

@section('title', 'Photo Gallery - New Sanda')

@section('content')
<section class="py-16 bg-brand-900 text-white text-center">
    <div class="max-w-4xl mx-auto px-4">
        <span class="text-gold-400 font-bold text-xs uppercase tracking-widest block mb-2">Visual Tour</span>
        <h1 class="text-4xl sm:text-5xl font-serif font-bold text-white mb-4">Photo Gallery</h1>
        <p class="text-slate-200 text-base max-w-2xl mx-auto font-light">
            Take a visual tour through our clean family rooms, attached bathrooms, and secure premises.
        </p>
    </div>
</section>

<section class="py-20 bg-stone-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @php
                $photos = [
                    ['url' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80', 'title' => 'Deluxe Family Villa & Poolside'],
                    ['url' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=80', 'title' => 'River-Breeze Cabana & Tropical Garden'],
                    ['url' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80', 'title' => 'Executive Nature Suite Bedroom'],
                    ['url' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=1200&q=80', 'title' => 'Luxury Villa Interior & Living Area'],
                    ['url' => 'https://images.unsplash.com/photo-1591088398332-8a7791972843?auto=format&fit=crop&w=1200&q=80', 'title' => 'Standard Family Room'],
                    ['url' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1200&q=80', 'title' => 'Open Restaurant & Dining Space'],
                    ['url' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=1200&q=80', 'title' => 'Resort Outdoor Swimming Pool'],
                    ['url' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1200&q=80', 'title' => 'Evening Illumination & Garden Patio'],
                    ['url' => 'https://images.unsplash.com/photo-1533750349088-cd871a92f312?auto=format&fit=crop&w=1200&q=80', 'title' => 'Yala Safari Wildlife Adventure'],
                ];
            @endphp

            @foreach($photos as $photo)
                <div class="group relative overflow-hidden rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 h-72">
                    <img src="{{ $photo['url'] }}" alt="{{ $photo['title'] }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-brand-900/90 via-brand-900/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-6">
                        <span class="text-white font-serif font-bold text-lg drop-shadow">{{ $photo['title'] }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
