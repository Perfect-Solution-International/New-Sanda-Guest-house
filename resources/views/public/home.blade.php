@extends('layouts.app')

@section('title', 'New Sanda - Sella Katharagama')

@section('content')

<!-- Hero Section -->
<section class="relative py-20 lg:py-28 bg-cover bg-center text-white" 
         style="background-image: linear-gradient(to bottom, rgba(14, 45, 28, 0.78), rgba(14, 45, 28, 0.90)), url('https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1600&q=80');">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">
        <div class="inline-flex items-center gap-2 px-4 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-gold-400 text-xs font-semibold uppercase tracking-wider">
            <i class="fa-solid fa-location-dot"></i> Sella Katharagama, Sri Lanka
        </div>

        <h1 class="text-4xl sm:text-6xl lg:text-7xl font-serif font-bold tracking-tight text-white leading-tight">
            New Sanda
        </h1>

        <p class="text-base sm:text-lg text-slate-200 max-w-2xl mx-auto font-light leading-relaxed">
            Clean, peaceful, and affordable family accommodation in Sella Katharagama. Spotless A/C and Non-A/C rooms, attached bathrooms with hot water, and secure parking for pilgrims and holiday travellers.
        </p>

        <!-- Direct Contact / Booking Action Buttons -->
        <div class="flex flex-wrap items-center justify-center gap-3 pt-4">
            <a href="tel:+94779876543" class="bg-gold-500 hover:bg-gold-600 text-brand-900 font-bold px-6 py-3.5 rounded-full shadow-lg transition flex items-center gap-2 text-sm sm:text-base">
                <i class="fa-solid fa-phone"></i> Call to Book: 077 987 6543
            </a>
            <a href="https://wa.me/94779876543?text=Hello%20New%20Sanda,%20I%20would%20like%20to%20inquire%20about%20room%20availability." target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-3.5 rounded-full shadow-lg transition flex items-center gap-2 text-sm sm:text-base">
                <i class="fa-brands fa-whatsapp text-lg"></i> WhatsApp Booking
            </a>
            <a href="{{ route('rooms.index') }}" class="bg-white/15 hover:bg-white/25 text-white border border-white/30 font-semibold px-6 py-3.5 rounded-full text-sm sm:text-base transition">
                View Rooms & Rates
            </a>
        </div>
    </div>
</section>

<!-- Highlights Strip -->
<section class="py-6 bg-brand-900 text-white border-y border-brand-800">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
            <div class="p-2">
                <i class="fa-solid fa-bath text-gold-400 text-2xl mb-1.5 block"></i>
                <h4 class="font-bold text-sm">Attached Bathrooms</h4>
                <p class="text-xs text-slate-300">Clean & with Hot Water</p>
            </div>
            <div class="p-2">
                <i class="fa-solid fa-square-parking text-gold-400 text-2xl mb-1.5 block"></i>
                <h4 class="font-bold text-sm">Secure Parking</h4>
                <p class="text-xs text-slate-300">Cars, Vans & Buses</p>
            </div>
            <div class="p-2">
                <i class="fa-solid fa-gopuram text-gold-400 text-2xl mb-1.5 block"></i>
                <h4 class="font-bold text-sm">Close to Temple</h4>
                <p class="text-xs text-slate-300">Near Sella & Kiri Vehera</p>
            </div>
            <div class="p-2">
                <i class="fa-solid fa-wallet text-gold-400 text-2xl mb-1.5 block"></i>
                <h4 class="font-bold text-sm">Budget Friendly</h4>
                <p class="text-xs text-slate-300">Starting from Rs. 3,500</p>
            </div>
        </div>
    </div>
</section>

<!-- Rooms & Rates Section -->
<section class="py-16 bg-stone-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-gold-600 font-bold text-xs uppercase tracking-widest block mb-1">Accommodation</span>
            <h2 class="text-3xl font-serif font-bold text-brand-900">Rooms & Rates</h2>
            <p class="text-slate-600 text-sm mt-1">Clean and comfortable family rooms for your pilgrimage and holiday stay.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($featuredRooms as $room)
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200 flex flex-col justify-between hover:shadow-md transition">
                    <div class="relative h-56">
                        <img src="{{ $room->image }}" alt="{{ $room->name }}" class="w-full h-full object-cover">
                        <div class="absolute top-3 right-3 bg-brand-900/90 text-gold-400 text-xs font-bold px-3 py-1.5 rounded-full shadow">
                            Rs. {{ number_format($room->base_price_per_night) }} <span class="text-white font-normal text-[10px]">/ night</span>
                        </div>
                    </div>

                    <div class="p-6 space-y-4 flex-grow flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-3 text-xs text-slate-500 mb-1.5">
                                <span><i class="fa-solid fa-users text-brand-700 mr-1"></i> Up to {{ $room->max_adults }} Adults</span>
                                <span>•</span>
                                <span><i class="fa-solid fa-bed text-brand-700 mr-1"></i> {{ $room->bed_type }}</span>
                            </div>
                            <h3 class="text-xl font-serif font-bold text-slate-900">{{ $room->name }}</h3>
                            <p class="text-xs text-slate-600 leading-relaxed mt-1">{{ $room->short_description }}</p>

                            <div class="flex flex-wrap gap-1.5 mt-3">
                                @foreach($room->amenities->take(4) as $am)
                                    <span class="text-[11px] bg-slate-100 text-slate-700 px-2 py-0.5 rounded">
                                        <i class="fa-solid fa-check text-brand-700 text-[9px]"></i> {{ $am->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Direct Call / WhatsApp / Book buttons -->
                        <div class="pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-2">
                            <a href="tel:+94779876543" class="bg-brand-700 hover:bg-brand-800 text-white font-bold text-xs px-3.5 py-2 rounded-lg transition flex items-center gap-1.5">
                                <i class="fa-solid fa-phone"></i> Call
                            </a>
                            <a href="https://wa.me/94779876543?text={{ urlencode('Hello New Sanda, I want to inquire about: ' . $room->name) }}" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-3.5 py-2 rounded-lg transition flex items-center gap-1.5">
                                <i class="fa-brands fa-whatsapp"></i> WhatsApp
                            </a>
                            <a href="{{ route('booking.create', ['room_type_id' => $room->id]) }}" class="bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs px-3 py-2 rounded-lg transition ml-auto">
                                Book Online &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- About Section -->
<section class="py-16 bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
            <div class="space-y-4">
                <span class="text-gold-600 font-bold text-xs uppercase tracking-widest block">Welcome</span>
                <h2 class="text-3xl font-serif font-bold text-brand-900">About New Sanda</h2>
                <p class="text-slate-600 text-sm leading-relaxed">
                    New Sanda is a peaceful, family-run holiday home located on Sella Road in Sella Katharagama. We specialize in providing clean, safe, and peaceful lodging for families and pilgrimage devotees visiting Ruhunu Kataragama Maha Devalaya and Kiri Vehera.
                </p>
                <ul class="text-xs text-slate-700 space-y-2 pt-2">
                    <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-brand-600"></i> Walking distance to Sella Kataragama temple and Menik Ganga</li>
                    <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-brand-600"></i> Spacious safe parking for vans, cars, and pilgrim buses</li>
                    <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-brand-600"></i> Fresh, hot home-cooked meals prepared upon prior request</li>
                    <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-brand-600"></i> Clean bedsheets and sanitized attached bathrooms with hot water</li>
                </ul>
            </div>

            <div class="bg-stone-50 p-6 rounded-3xl border border-slate-200 space-y-4 text-center">
                <i class="fa-solid fa-phone-volume text-4xl text-brand-700"></i>
                <h3 class="font-serif font-bold text-xl text-slate-900">Plan Your Visit</h3>
                <p class="text-xs text-slate-500">Call us directly to reserve rooms for your Kataragama trip.</p>
                <div class="space-y-2 pt-2">
                    <a href="tel:+94779876543" class="block w-full bg-brand-700 hover:bg-brand-800 text-white font-bold py-3 rounded-xl text-sm transition">
                        <i class="fa-solid fa-phone mr-1"></i> +94 77 987 6543
                    </a>
                    <a href="https://wa.me/94779876543" target="_blank" class="block w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl text-sm transition">
                        <i class="fa-brands fa-whatsapp mr-1"></i> WhatsApp: 077 987 6543
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Guest Reviews -->
<section class="py-16 bg-stone-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h3 class="text-2xl font-serif font-bold text-brand-900">Visitor Feedback</h3>
            <p class="text-xs text-slate-500 mt-1">Honest feedback from visiting families and pilgrims.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($reviews as $rev)
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                    <div class="flex text-gold-500 text-xs mb-3">
                        @for($i = 0; $i < $rev->rating; $i++)
                            <i class="fa-solid fa-star"></i>
                        @endfor
                    </div>
                    <p class="text-xs text-slate-600 italic leading-relaxed mb-4">"{{ $rev->comment }}"</p>
                    <div class="text-xs font-bold text-slate-900">{{ $rev->guest_name }} <span class="text-slate-400 font-normal">({{ $rev->guest_location }})</span></div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
