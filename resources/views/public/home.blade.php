@extends('layouts.app')

@section('title', 'නිවි සඳ (Nivi Sanda) Family Holiday Resort - Sella Katharagama')

@section('content')

<!-- Hero Section with Background, Logo & Booking Quick Search -->
<section class="relative min-h-[580px] lg:min-h-[660px] flex items-center justify-center bg-cover bg-center overflow-hidden" 
         style="background-image: linear-gradient(to bottom, rgba(14, 45, 28, 0.72), rgba(14, 45, 28, 0.88)), url('https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1920&q=80');">
    
    <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center z-10 text-white">
        <!-- Resort Badge / Emblem -->
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-gold-400 text-xs sm:text-sm font-semibold tracking-wide uppercase mb-6 animate-pulse">
            <i class="fa-solid fa-sparkles"></i> Welcome to Sacred Sella Katharagama
        </div>

        <div class="flex justify-center mb-6">
            <img src="{{ asset('images/logo.jpg') }}" alt="නිවි සඳ Family Holiday Resort" class="h-28 sm:h-36 w-auto object-contain drop-shadow-2xl rounded-xl border-2 border-gold-400/30">
        </div>

        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-serif font-bold tracking-tight text-white mb-4 leading-tight">
            නිවි සඳ <span class="text-gold-400">Family Holiday Resort</span>
        </h1>
        <p class="text-base sm:text-xl text-slate-200 max-w-2xl mx-auto font-light leading-relaxed mb-8">
            Your serene nature haven nestled amidst the tranquil greenery of Sella Katharagama. Luxury family villas, crystal swimming pool, authentic dining, and Yala Safari adventures.
        </p>

        <!-- Quick Booking Search Card -->
        <div class="bg-white/95 backdrop-blur-md p-4 sm:p-6 rounded-2xl shadow-2xl text-slate-800 max-w-4xl mx-auto text-left border border-stone-200">
            <form action="{{ route('booking.create') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">
                        <i class="fa-regular fa-calendar-days text-brand-600 mr-1"></i> Check-in Date
                    </label>
                    <input type="date" name="check_in" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" class="w-full text-sm font-medium border border-slate-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">
                        <i class="fa-regular fa-calendar-check text-brand-600 mr-1"></i> Check-out Date
                    </label>
                    <input type="date" name="check_out" value="{{ date('Y-m-d', strtotime('+1 day')) }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="w-full text-sm font-medium border border-slate-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">
                        <i class="fa-solid fa-users text-brand-600 mr-1"></i> Guests (Adults)
                    </label>
                    <select name="adults" class="w-full text-sm font-medium border border-slate-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-brand-500 focus:outline-none bg-white">
                        <option value="2" selected>2 Adults (Couple / Friends)</option>
                        <option value="3">3 Adults</option>
                        <option value="4">4 Adults (Family / Group)</option>
                        <option value="6">6+ Adults (Large Family)</option>
                    </select>
                </div>

                <div>
                    <button type="submit" class="w-full bg-brand-700 hover:bg-brand-800 text-white font-bold py-2.5 px-4 rounded-lg shadow-md hover:shadow-lg transition duration-200 flex items-center justify-center gap-2 text-sm">
                        <i class="fa-solid fa-magnifying-glass text-gold-400"></i> Check Availability
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Why Choose Us / Resort Highlights Bar -->
<section class="py-8 bg-brand-900 text-white border-y border-brand-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div class="p-3">
                <i class="fa-solid fa-water text-3xl text-gold-400 mb-2"></i>
                <h4 class="font-bold text-base">Outdoor Pool & Kids Area</h4>
                <p class="text-xs text-slate-300 mt-1">Crystal clear swimming pool surrounded by nature</p>
            </div>
            <div class="p-3">
                <i class="fa-solid fa-gopuram text-3xl text-gold-400 mb-2"></i>
                <h4 class="font-bold text-base">Near Kataragama Temple</h4>
                <p class="text-xs text-slate-300 mt-1">10 mins to Maha Devalaya & Kiri Vehera</p>
            </div>
            <div class="p-3">
                <i class="fa-solid fa-paw text-3xl text-gold-400 mb-2"></i>
                <h4 class="font-bold text-base">Yala Safari Excursions</h4>
                <p class="text-xs text-slate-300 mt-1">Dedicated 4x4 Safari Jeeps & expert drivers</p>
            </div>
            <div class="p-3">
                <i class="fa-solid fa-utensils text-3xl text-gold-400 mb-2"></i>
                <h4 class="font-bold text-base">Authentic Sri Lankan Food</h4>
                <p class="text-xs text-slate-300 mt-1">Southern culinary specialties & BBQ nights</p>
            </div>
        </div>
    </div>
</section>

<!-- Featured Rooms & Cabanas Section -->
<section class="py-20 bg-stone-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
            <div>
                <span class="text-gold-600 font-bold text-xs uppercase tracking-widest block mb-2">Luxury Accommodation</span>
                <h2 class="text-3xl sm:text-4xl font-serif font-bold text-brand-900">Featured Rooms & Cabanas</h2>
                <p class="text-slate-600 mt-2 max-w-xl text-sm sm:text-base">
                    Every room is crafted for family comfort, peaceful rest, and complete privacy during your Kataragama pilgrimage and holiday.
                </p>
            </div>
            <a href="{{ route('rooms.index') }}" class="mt-4 md:mt-0 inline-flex items-center gap-2 text-brand-700 hover:text-brand-900 font-bold text-sm">
                View All Rooms & Cabanas <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredRooms as $room)
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col group">
                    <div class="relative h-60 overflow-hidden">
                        <img src="{{ $room->image }}" alt="{{ $room->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute top-3 right-3 bg-brand-900/80 backdrop-blur-md text-gold-400 text-xs font-bold px-3 py-1.5 rounded-full border border-gold-400/30">
                            Rs. {{ number_format($room->base_price_per_night) }} <span class="text-white font-normal text-[10px]">/ night</span>
                        </div>
                        @if($room->is_featured)
                            <div class="absolute top-3 left-3 bg-gold-500 text-brand-900 text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded shadow">
                                Popular Choice
                            </div>
                        @endif
                    </div>

                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-3 text-xs text-slate-500 mb-2">
                                <span><i class="fa-solid fa-user-group text-brand-600 mr-1"></i> Up to {{ $room->max_adults }} Adults</span>
                                <span>•</span>
                                <span><i class="fa-solid fa-bed text-brand-600 mr-1"></i> {{ $room->bed_type }}</span>
                            </div>
                            <h3 class="text-xl font-serif font-bold text-slate-900 mb-2 group-hover:text-brand-700 transition">
                                <a href="{{ route('rooms.show', $room->slug) }}">{{ $room->name }}</a>
                            </h3>
                            <p class="text-sm text-slate-600 line-clamp-2 mb-4 leading-relaxed">
                                {{ $room->short_description }}
                            </p>

                            <!-- Amenities Tags -->
                            <div class="flex flex-wrap gap-1.5 mb-6">
                                @foreach($room->amenities->take(4) as $amenity)
                                    <span class="inline-flex items-center gap-1 text-[11px] bg-slate-100 text-slate-700 px-2 py-0.5 rounded">
                                        <i class="fa-solid fa-check text-brand-600 text-[9px]"></i> {{ $amenity->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                            <a href="{{ route('rooms.show', $room->slug) }}" class="text-xs font-bold text-slate-600 hover:text-brand-800 transition">
                                Details & Photos <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                            <a href="{{ route('booking.create', ['room_type_id' => $room->id]) }}" class="bg-brand-700 hover:bg-brand-800 text-white text-xs font-bold px-4 py-2 rounded-lg transition shadow-sm">
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- About & Sacred Location Story -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <span class="text-gold-600 font-bold text-xs uppercase tracking-widest block">Welcome to Sella Katharagama</span>
                <h2 class="text-3xl sm:text-4xl font-serif font-bold text-brand-900 leading-tight">
                    A Peaceful Sanctuary Where Faith Meets Natural Serenity
                </h2>
                <p class="text-slate-600 text-base leading-relaxed">
                    Sella Katharagama is revered for its ancient spiritual lore, the sacred waters of Menik Ganga, and the untouched beauty of Sri Lanka's southern wilderness. At <strong>නිවි සඳ (Nivi Sanda) Family Holiday Resort</strong>, we have created a haven specifically tailored for families, pilgrimage devotees, and vacationers.
                </p>
                <div class="grid grid-cols-2 gap-4 pt-2">
                    <div class="border-l-4 border-brand-600 pl-4">
                        <span class="text-2xl font-bold font-serif text-brand-900">100%</span>
                        <p class="text-xs text-slate-500 font-medium">Family-Friendly Environment</p>
                    </div>
                    <div class="border-l-4 border-gold-500 pl-4">
                        <span class="text-2xl font-bold font-serif text-brand-900">10 Mins</span>
                        <p class="text-xs text-slate-500 font-medium">To Kataragama Maha Devalaya</p>
                    </div>
                </div>
                <div class="pt-4 flex flex-wrap gap-4">
                    <a href="{{ route('about') }}" class="bg-brand-700 hover:bg-brand-800 text-white px-6 py-3 rounded-xl font-bold text-sm shadow transition">
                        Discover Our Story
                    </a>
                    <a href="{{ route('contact') }}" class="border-2 border-brand-700 text-brand-700 hover:bg-brand-50 px-6 py-3 rounded-xl font-bold text-sm transition">
                        Contact Resort
                    </a>
                </div>
            </div>

            <!-- Image collage -->
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-4">
                    <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80" alt="Resort Pool" class="rounded-2xl shadow-md object-cover h-64 w-full">
                    <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=800&q=80" alt="Resort Dining" class="rounded-2xl shadow-md object-cover h-44 w-full">
                </div>
                <div class="space-y-4 pt-8">
                    <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=800&q=80" alt="Luxury Bedroom" class="rounded-2xl shadow-md object-cover h-44 w-full">
                    <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=800&q=80" alt="Villa Exterior" class="rounded-2xl shadow-md object-cover h-64 w-full">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Safari & Special Packages Callout -->
<section class="py-16 bg-gradient-to-r from-brand-900 to-brand-800 text-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
            <div class="lg:col-span-2 space-y-4">
                <span class="text-gold-400 font-bold text-xs uppercase tracking-widest">Adventures & Pilgrimage</span>
                <h2 class="text-3xl sm:text-4xl font-serif font-bold text-white leading-tight">
                    Yala Safari & Sacred Kataragama Tour Coordination
                </h2>
                <p class="text-slate-200 text-sm sm:text-base leading-relaxed">
                    We take care of your entire itinerary! Book an authentic open-top 4x4 Jeep Safari into Yala National Park to spot Sri Lankan leopards and wild elephants, or let us arrange comfortable transport and guidance for your evening Kataragama Pooja rituals.
                </p>
                <div class="flex flex-wrap gap-4 pt-2">
                    <div class="flex items-center gap-2 text-xs bg-white/10 px-3 py-1.5 rounded-lg border border-white/10">
                        <i class="fa-solid fa-check text-gold-400"></i> 4x4 Safari Jeep Hire
                    </div>
                    <div class="flex items-center gap-2 text-xs bg-white/10 px-3 py-1.5 rounded-lg border border-white/10">
                        <i class="fa-solid fa-check text-gold-400"></i> Pooja Transport & Guidance
                    </div>
                    <div class="flex items-center gap-2 text-xs bg-white/10 px-3 py-1.5 rounded-lg border border-white/10">
                        <i class="fa-solid fa-check text-gold-400"></i> Poolside Night BBQ Setup
                    </div>
                </div>
            </div>

            <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/20 text-center">
                <span class="text-xs text-gold-400 font-bold uppercase tracking-wider block mb-1">Direct Hotline Booking</span>
                <h3 class="text-2xl font-serif font-bold text-white mb-2">Speak With Resort Desk</h3>
                <p class="text-xs text-slate-300 mb-6">Call us to customize group packages or safari timing.</p>
                <a href="tel:+94779876543" class="block w-full bg-gold-500 hover:bg-gold-600 text-brand-900 font-bold py-3 rounded-xl shadow-lg transition duration-200 text-sm mb-3">
                    <i class="fa-solid fa-phone mr-1"></i> +94 77 987 6543
                </a>
                <a href="https://wa.me/94779876543" target="_blank" class="block w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl shadow transition duration-200 text-sm">
                    <i class="fa-brands fa-whatsapp mr-1"></i> Chat on WhatsApp
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Guest Reviews / Testimonials -->
<section class="py-20 bg-stone-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-gold-600 font-bold text-xs uppercase tracking-widest block mb-2">Guest Testimonials</span>
            <h2 class="text-3xl sm:text-4xl font-serif font-bold text-brand-900">What Our Guests Say</h2>
            <p class="text-slate-600 mt-2 text-sm sm:text-base">Real experiences from families and devotees who stayed at Nivi Sanda Resort.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($reviews as $review)
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-between">
                    <div>
                        <div class="flex text-gold-500 text-sm mb-4">
                            @for($i = 0; $i < $review->rating; $i++)
                                <i class="fa-solid fa-star"></i>
                            @endfor
                        </div>
                        <p class="text-slate-700 text-sm italic leading-relaxed mb-6">
                            "{{ $review->comment }}"
                        </p>
                    </div>
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <div>
                            <h4 class="font-bold text-sm text-slate-900">{{ $review->guest_name }}</h4>
                            <span class="text-xs text-slate-500">{{ $review->guest_location ?? 'Sri Lanka' }}</span>
                        </div>
                        <span class="text-[11px] text-slate-400">{{ $review->stay_date }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
