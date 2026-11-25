@extends('layouts.app')

@section('title', 'Sanda Guest House - Clean, Peaceful & Affordable Family Stays')

@section('content')

<!-- 1. Hero Section (Aesthetic Matched to Pinterest Architecture & Luxury Landing Page) -->
<section class="bg-brand-900 text-white pt-12 pb-24 lg:pt-16 lg:pb-32 relative overflow-hidden">
    <!-- Ambient Subtle Glow & Gradient Background -->
    <div class="absolute inset-0 bg-gradient-to-r from-brand-950 via-brand-900 to-brand-950 opacity-90"></div>
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-gold-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left Hero Content -->
            <div class="lg:col-span-6 space-y-6">
                <!-- Eyebrow with Indicator -->
                <div class="flex items-center gap-3 text-gold-400 font-semibold text-xs uppercase tracking-[0.25em]">
                    <span class="w-1.5 h-1.5 rounded-full bg-gold-400 inline-block ring-4 ring-gold-400/20"></span>
                    <span>SERENE HOSPITALITY IN SRI LANKA</span>
                </div>

                <!-- Editorial Headline (Cormorant Garamond Serif with Gold Italic Accent) -->
                <h1 class="text-4xl sm:text-6xl lg:text-7xl font-serif text-white leading-[1.08] tracking-tight">
                    A Peaceful Stay.<br>
                    <span class="italic text-gold-400 font-normal">Moments of Serenity,</span><br>
                    Built Around You.
                </h1>

                <!-- Subtitle -->
                <p class="text-slate-300 text-sm sm:text-base font-light leading-relaxed max-w-lg">
                    Clean, peaceful, and affordable family accommodation. Spotless A/C and Non-A/C rooms, attached bathrooms with hot water, and secure parking for pilgrims and holiday travellers across Sri Lanka.
                </p>

                <!-- Action Button Group -->
                <div class="pt-2 flex flex-wrap items-center gap-4">
                    <a href="{{ route('rooms.index') }}" class="inline-flex items-center gap-2 bg-gold-500 hover:bg-gold-400 text-brand-950 font-bold px-6 py-3.5 rounded text-xs uppercase tracking-wider transition shadow-lg">
                        EXPLORE OUR ROOMS <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    </a>
                    
                    <a href="https://wa.me/94779876543?text=Hello%20New%20Sanda%20Guest%20House,%20I%20would%20like%20to%20inquire%20about%20room%20availability." target="_blank" class="inline-flex items-center gap-2 border border-white/20 hover:border-gold-400 text-white hover:text-gold-400 font-semibold px-6 py-3.5 rounded text-xs uppercase tracking-wider transition backdrop-blur-sm">
                        <i class="fa-brands fa-whatsapp text-emerald-400 text-sm"></i> QUICK WHATSAPP
                    </a>
                </div>

                <!-- Direct Phone Line -->
                <div class="pt-2 flex items-center gap-2 text-xs text-slate-400">
                    <i class="fa-solid fa-phone text-gold-400"></i>
                    <span>Direct Hotline: <a href="tel:+94779876543" class="text-slate-200 hover:text-gold-400 font-semibold">+94 77 987 6543</a></span>
                </div>
            </div>

            <!-- Right Hero Architectural Showcase Image -->
            <div class="lg:col-span-6">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-white/10 group">
                    <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80" 
                         alt="Sanda Guest House" 
                         class="w-full h-[360px] sm:h-[460px] lg:h-[500px] object-cover group-hover:scale-105 transition duration-700">
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-brand-950/85 via-brand-950/20 to-transparent"></div>

                    <!-- Floating Image Info Card (Matches Pinterest Card Design) -->
                    <div class="absolute bottom-6 left-6 right-6 flex items-center justify-between backdrop-blur-md bg-brand-950/70 border border-white/15 px-5 py-3.5 rounded-2xl">
                        <div>
                            <div class="font-serif font-bold text-base sm:text-lg text-white">Sanda Guest House</div>
                            <div class="text-gold-400 text-xs font-light">Sanitized Rooms • Hot Water • Secure Parking</div>
                        </div>
                        <span class="bg-gold-500 text-brand-950 font-bold px-3 py-1 rounded text-[10px] uppercase tracking-wider">
                            Verified Stay
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Quick Live Availability & Booking Search Bar (Deep Forest Green & Gold Dark Card Theme) -->
<div class="max-w-6xl mx-auto px-4 -mt-10 sm:-mt-12 relative z-30 mb-8">
    <div class="bg-[#082017]/95 border border-gold-500/30 rounded-3xl p-5 sm:p-6 shadow-2xl backdrop-blur-md">
        <form action="{{ route('booking.create') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3.5 items-end">
            <div>
                <label class="block text-[11px] font-bold text-gold-400 uppercase tracking-wider mb-1">
                    <i class="fa-regular fa-calendar-check mr-1"></i> Check-in Date & Time
                </label>
                <div class="grid grid-cols-5 gap-1.5">
                    <input type="date" name="check_in" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" class="col-span-3 bg-[#051710] border border-emerald-500/30 rounded-xl px-2.5 py-2 text-xs text-white focus:ring-2 focus:ring-gold-400 focus:outline-none">
                    <input type="time" name="check_in_time" value="14:00" class="col-span-2 bg-[#051710] border border-emerald-500/30 rounded-xl px-2 py-2 text-xs text-white focus:ring-2 focus:ring-gold-400 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-gold-400 uppercase tracking-wider mb-1">
                    <i class="fa-regular fa-calendar-xmark mr-1"></i> Check-out Date & Time
                </label>
                <div class="grid grid-cols-5 gap-1.5">
                    <input type="date" name="check_out" value="{{ date('Y-m-d', strtotime('+1 day')) }}" min="{{ date('Y-m-d') }}" class="col-span-3 bg-[#051710] border border-emerald-500/30 rounded-xl px-2.5 py-2 text-xs text-white focus:ring-2 focus:ring-gold-400 focus:outline-none">
                    <input type="time" name="check_out_time" value="11:00" class="col-span-2 bg-[#051710] border border-emerald-500/30 rounded-xl px-2 py-2 text-xs text-white focus:ring-2 focus:ring-gold-400 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-emerald-300 uppercase tracking-wider mb-1">
                    <i class="fa-solid fa-users mr-1 text-gold-400"></i> Adult Guests
                </label>
                <select name="adults" class="w-full bg-[#051710] border border-emerald-500/30 rounded-xl px-3 py-2 text-xs text-white focus:ring-2 focus:ring-gold-400 focus:outline-none">
                    <option value="1">1 Adult</option>
                    <option value="2" selected>2 Adults</option>
                    <option value="3">3 Adults</option>
                    <option value="4">4 Adults</option>
                    <option value="6">6+ Adults (Group)</option>
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-emerald-300 uppercase tracking-wider mb-1">
                    <i class="fa-solid fa-hotel mr-1 text-gold-400"></i> Room Preference
                </label>
                <select name="room_type_id" class="w-full bg-[#051710] border border-emerald-500/30 rounded-xl px-3 py-2 text-xs text-white focus:ring-2 focus:ring-gold-400 focus:outline-none">
                    <option value="">Any Available Room</option>
                    @foreach($featuredRooms as $fr)
                        <option value="{{ $fr->id }}">{{ $fr->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit" class="w-full bg-gradient-to-r from-gold-500 via-amber-500 to-gold-600 hover:from-gold-400 hover:to-amber-500 text-slate-950 font-bold py-2.5 rounded-xl shadow-lg transition text-xs uppercase tracking-wider flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-magnifying-glass"></i> Check & Book
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 2. Floating Stats Bar (Docked Between Hero and Content) -->
<div class="max-w-6xl mx-auto px-4 relative z-20">
    <div class="bg-brand-950 border border-white/15 rounded-2xl sm:rounded-full py-6 px-6 sm:px-12 shadow-2xl backdrop-blur-md">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center divide-y md:divide-y-0 md:divide-x divide-white/10">
            <div class="p-2 flex flex-col items-center">
                <div class="flex items-center gap-2 mb-1">
                    <i class="fa-solid fa-award text-gold-400 text-lg"></i>
                    <span class="text-2xl sm:text-3xl font-serif font-bold text-white">10+</span>
                </div>
                <p class="text-xs text-slate-400 font-light">Years of Hospitality</p>
            </div>

            <div class="p-2 pt-4 md:pt-2 flex flex-col items-center">
                <div class="flex items-center gap-2 mb-1">
                    <i class="fa-solid fa-users text-gold-400 text-lg"></i>
                    <span class="text-2xl sm:text-3xl font-serif font-bold text-white">5,000+</span>
                </div>
                <p class="text-xs text-slate-400 font-light">Happy Families & Devotees</p>
            </div>

            <div class="p-2 flex flex-col items-center">
                <div class="flex items-center gap-2 mb-1">
                    <i class="fa-solid fa-star text-gold-400 text-lg"></i>
                    <span class="text-2xl sm:text-3xl font-serif font-bold text-white">99%</span>
                </div>
                <p class="text-xs text-slate-400 font-light">Guest Satisfaction</p>
            </div>

            <div class="p-2 pt-4 md:pt-2 flex flex-col items-center">
                <div class="flex items-center gap-2 mb-1">
                    <i class="fa-solid fa-shield-halved text-gold-400 text-lg"></i>
                    <span class="text-2xl sm:text-3xl font-serif font-bold text-white">24/7</span>
                </div>
                <p class="text-xs text-slate-400 font-light">Secure Parking & Care</p>
            </div>
        </div>
    </div>
</div>

<!-- 3. Featured Rooms & Suites (Pinterest "Spaces That Define Excellence" Masonry Style) -->
<section class="bg-[#fcfaf7] pt-24 pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            
            <!-- Left Header Column -->
            <div class="lg:col-span-4 space-y-4">
                <span class="text-gold-600 font-bold text-xs uppercase tracking-[0.25em] block">FEATURED ACCOMMODATION</span>
                <h2 class="text-4xl sm:text-5xl font-serif text-brand-900 leading-tight">
                    Spaces<br>That Define<br><span class="italic font-normal">Comfort.</span>
                </h2>
                <p class="text-slate-600 text-xs sm:text-sm leading-relaxed font-light">
                    Thoughtfully designed rooms for families, couples, and pilgrimage travellers. Air-conditioned comfort, attached hot water bathrooms, and peaceful ventilation.
                </p>
                <div class="pt-2">
                    <a href="{{ route('rooms.index') }}" class="inline-flex items-center gap-2 border border-brand-900/30 hover:border-brand-900 text-brand-900 hover:bg-brand-900 hover:text-white px-5 py-2.5 rounded text-xs font-semibold uppercase tracking-wider transition">
                        VIEW ALL ROOMS <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    </a>
                </div>
            </div>

            <!-- Right Asymmetric Rooms Grid -->
            <div class="lg:col-span-8">
                @if($featuredRooms->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
                        
                        <!-- Primary Featured Big Card (Spans 6 cols, Tall) -->
                        @php $primaryRoom = $featuredRooms->first(); @endphp
                        @if($primaryRoom)
                            <div class="md:col-span-6 relative rounded-2xl overflow-hidden shadow-md group min-h-[420px] flex flex-col justify-end bg-brand-950">
                                <img src="{{ $primaryRoom->image }}" alt="{{ $primaryRoom->name }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-brand-950/90 via-brand-950/40 to-transparent"></div>
                                
                                <!-- Top Pill Badge -->
                                <div class="absolute top-4 left-4">
                                    <span class="bg-gold-500 text-brand-950 font-bold text-[10px] uppercase tracking-wider px-3 py-1 rounded-full shadow">
                                        Starting Rs. {{ number_format($primaryRoom->base_price_per_night) }}
                                    </span>
                                </div>

                                <!-- Bottom Info -->
                                <div class="relative z-10 p-6 space-y-2">
                                    <div class="text-[11px] text-gold-400 font-medium">
                                        {{ $primaryRoom->bed_type }} • Up to {{ $primaryRoom->max_adults }} Adults
                                    </div>
                                    <h3 class="text-2xl font-serif font-bold text-white leading-tight">
                                        {{ $primaryRoom->name }}
                                    </h3>
                                    <p class="text-xs text-slate-300 line-clamp-2 font-light">
                                        {{ $primaryRoom->short_description }}
                                    </p>
                                    
                                    <div class="pt-3 flex items-center justify-between">
                                        <a href="{{ route('rooms.show', $primaryRoom->slug) }}" class="text-xs font-semibold uppercase tracking-wider text-white hover:text-gold-400 transition inline-flex items-center gap-1.5">
                                            View Details <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                        </a>
                                        <a href="https://wa.me/94779876543?text={{ urlencode('Hello Sanda Guest House, I want to reserve: ' . $primaryRoom->name) }}" target="_blank" class="w-9 h-9 rounded-full border border-white/20 hover:border-gold-400 bg-brand-900/60 hover:bg-gold-500 hover:text-brand-950 text-white flex items-center justify-center transition text-xs">
                                            <i class="fa-solid fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Secondary Stacked Column (Spans 6 cols, 2 stacked cards) -->
                        <div class="md:col-span-6 flex flex-col gap-5">
                            @foreach($featuredRooms->skip(1)->take(2) as $secRoom)
                                <div class="relative rounded-2xl overflow-hidden shadow-sm group h-[200px] flex flex-col justify-end bg-brand-950">
                                    <img src="{{ $secRoom->image }}" alt="{{ $secRoom->name }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-700">
                                    <div class="absolute inset-0 bg-gradient-to-t from-brand-950/90 via-brand-950/30 to-transparent"></div>

                                    <div class="absolute top-3 right-3">
                                        <span class="bg-brand-900/80 backdrop-blur text-gold-400 text-[10px] font-bold px-2.5 py-1 rounded-full border border-white/10">
                                            Rs. {{ number_format($secRoom->base_price_per_night) }}
                                        </span>
                                    </div>

                                    <div class="relative z-10 p-5 space-y-1">
                                        <div class="text-[10px] text-slate-300">
                                            {{ $secRoom->bed_type }} • {{ $secRoom->max_adults }} Guests
                                        </div>
                                        <h4 class="text-lg font-serif font-bold text-white leading-snug">
                                            {{ $secRoom->name }}
                                        </h4>
                                        <div class="flex items-center justify-between pt-1">
                                            <a href="{{ route('rooms.show', $secRoom->slug) }}" class="text-[11px] font-semibold uppercase tracking-wider text-gold-400 hover:text-white transition">
                                                Explore &rarr;
                                            </a>
                                            <a href="https://wa.me/94779876543?text={{ urlencode('Hello Sanda Guest House, I want to reserve: ' . $secRoom->name) }}" target="_blank" class="w-7 h-7 rounded-full border border-white/20 bg-brand-900/60 hover:bg-gold-500 hover:text-brand-950 text-white flex items-center justify-center transition text-[10px]">
                                                <i class="fa-solid fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                @endif
            </div>

        </div>
    </div>
</section>

<!-- 4. Thoughtful Amenities (Pinterest "Our Services / End-to-End Solutions") -->
<section class="bg-brand-950 py-24 text-white relative border-y border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start mb-12">
            <!-- Left Header -->
            <div class="lg:col-span-5 space-y-3">
                <span class="text-gold-400 font-semibold text-xs uppercase tracking-[0.25em] block">OUR AMENITIES</span>
                <h2 class="text-4xl sm:text-5xl font-serif text-white leading-tight">
                    End-to-End<br><span class="italic text-gold-400 font-normal">Hospitality.</span>
                </h2>
                <p class="text-slate-300 text-xs sm:text-sm font-light leading-relaxed max-w-md">
                    Integrated comfort across every stage of your stay. From sparkling clean bathrooms to safe vehicle parking, we care for every detail.
                </p>
                <div class="pt-2">
                    <a href="{{ route('facilities') }}" class="inline-flex items-center gap-2 border border-white/20 hover:border-gold-400 text-white hover:text-gold-400 px-5 py-2.5 rounded text-xs font-semibold uppercase tracking-wider transition">
                        EXPLORE ALL FACILITIES <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    </a>
                </div>
            </div>

            <!-- Right 5 Clean Cards (Matches Pinterest Line-art Icon Cards) -->
            <div class="lg:col-span-7">
                <div class="grid grid-cols-1 sm:grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3.5">
                    
                    <!-- Card 1 -->
                    <div class="bg-white/[0.03] border border-white/10 rounded-xl p-5 hover:border-gold-400/50 hover:bg-white/[0.06] transition flex flex-col justify-between group">
                        <div>
                            <div class="w-10 h-10 rounded-lg bg-gold-500/10 border border-gold-400/20 flex items-center justify-center text-gold-400 mb-4 group-hover:scale-110 transition">
                                <i class="fa-solid fa-bath text-base"></i>
                            </div>
                            <h4 class="font-serif font-bold text-white text-base mb-1.5 leading-snug">Attached Bathrooms</h4>
                            <p class="text-[11px] text-slate-300 font-light leading-relaxed">
                                Spotless private bathrooms with 24/7 hot water supply.
                            </p>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white/[0.03] border border-white/10 rounded-xl p-5 hover:border-gold-400/50 hover:bg-white/[0.06] transition flex flex-col justify-between group">
                        <div>
                            <div class="w-10 h-10 rounded-lg bg-gold-500/10 border border-gold-400/20 flex items-center justify-center text-gold-400 mb-4 group-hover:scale-110 transition">
                                <i class="fa-solid fa-snowflake text-base"></i>
                            </div>
                            <h4 class="font-serif font-bold text-white text-base mb-1.5 leading-snug">A/C Comfort</h4>
                            <p class="text-[11px] text-slate-300 font-light leading-relaxed">
                                Quiet inverter air conditioning & cooling ceiling fans.
                            </p>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white/[0.03] border border-white/10 rounded-xl p-5 hover:border-gold-400/50 hover:bg-white/[0.06] transition flex flex-col justify-between group">
                        <div>
                            <div class="w-10 h-10 rounded-lg bg-gold-500/10 border border-gold-400/20 flex items-center justify-center text-gold-400 mb-4 group-hover:scale-110 transition">
                                <i class="fa-solid fa-square-parking text-base"></i>
                            </div>
                            <h4 class="font-serif font-bold text-white text-base mb-1.5 leading-snug">Secure Parking</h4>
                            <p class="text-[11px] text-slate-300 font-light leading-relaxed">
                                Gated dedicated space for cars, vans, and buses.
                            </p>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="bg-white/[0.03] border border-white/10 rounded-xl p-5 hover:border-gold-400/50 hover:bg-white/[0.06] transition flex flex-col justify-between group">
                        <div>
                            <div class="w-10 h-10 rounded-lg bg-gold-500/10 border border-gold-400/20 flex items-center justify-center text-gold-400 mb-4 group-hover:scale-110 transition">
                                <i class="fa-solid fa-utensils text-base"></i>
                            </div>
                            <h4 class="font-serif font-bold text-white text-base mb-1.5 leading-snug">Home Meals</h4>
                            <p class="text-[11px] text-slate-300 font-light leading-relaxed">
                                Fresh hot Sri Lankan home-style meals on request.
                            </p>
                        </div>
                    </div>

                    <!-- Card 5 -->
                    <div class="bg-white/[0.03] border border-white/10 rounded-xl p-5 hover:border-gold-400/50 hover:bg-white/[0.06] transition flex flex-col justify-between group">
                        <div>
                            <div class="w-10 h-10 rounded-lg bg-gold-500/10 border border-gold-400/20 flex items-center justify-center text-gold-400 mb-4 group-hover:scale-110 transition">
                                <i class="fa-solid fa-gopuram text-base"></i>
                            </div>
                            <h4 class="font-serif font-bold text-white text-base mb-1.5 leading-snug">Temple Proximity</h4>
                            <p class="text-[11px] text-slate-300 font-light leading-relaxed">
                                Close to sacred shrines, Menik river & safari routes.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<!-- 5. Seamless Journey / Process (Pinterest "Our Process - A Seamless Journey From Vision to Reality") -->
<section class="bg-[#fcfaf7] py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            
            <!-- Left Header -->
            <div class="lg:col-span-4 space-y-4">
                <span class="text-gold-600 font-bold text-xs uppercase tracking-[0.25em] block">OUR PROCESS</span>
                <h2 class="text-4xl sm:text-5xl font-serif text-brand-900 leading-tight">
                    A Seamless Journey<br><span class="italic font-normal">From Booking to Rest.</span>
                </h2>
                <div class="pt-2">
                    <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 border border-brand-900/30 hover:border-brand-900 text-brand-900 hover:bg-brand-900 hover:text-white px-5 py-2.5 rounded text-xs font-semibold uppercase tracking-wider transition">
                        HOW TO BOOK <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    </a>
                </div>
            </div>

            <!-- Right 5 Sequential Process Steps -->
            <div class="lg:col-span-8">
                <div class="grid grid-cols-1 sm:grid-cols-5 gap-6">
                    
                    <!-- Step 01 -->
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-full bg-gold-500 text-brand-950 font-bold text-xs flex items-center justify-center shadow">
                            01
                        </div>
                        <h4 class="font-serif font-bold text-base text-brand-900">Discover</h4>
                        <p class="text-xs text-slate-600 font-light leading-relaxed">
                            Browse A/C and Non-A/C family rooms for your group size.
                        </p>
                    </div>

                    <!-- Step 02 -->
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-full bg-gold-500 text-brand-950 font-bold text-xs flex items-center justify-center shadow">
                            02
                        </div>
                        <h4 class="font-serif font-bold text-base text-brand-900">Confirm</h4>
                        <p class="text-xs text-slate-600 font-light leading-relaxed">
                            Instant booking via WhatsApp or simple phone call.
                        </p>
                    </div>

                    <!-- Step 03 -->
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-full bg-gold-500 text-brand-950 font-bold text-xs flex items-center justify-center shadow">
                            03
                        </div>
                        <h4 class="font-serif font-bold text-base text-brand-900">Arrive</h4>
                        <p class="text-xs text-slate-600 font-light leading-relaxed">
                            Spotless beds, clean towels, and hot water ready upon arrival.
                        </p>
                    </div>

                    <!-- Step 04 -->
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-full bg-gold-500 text-brand-950 font-bold text-xs flex items-center justify-center shadow">
                            04
                        </div>
                        <h4 class="font-serif font-bold text-base text-brand-900">Experience</h4>
                        <p class="text-xs text-slate-600 font-light leading-relaxed">
                            Enjoy peaceful pooja visits, temple rituals, and family meals.
                        </p>
                    </div>

                    <!-- Step 05 -->
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-full bg-gold-500 text-brand-950 font-bold text-xs flex items-center justify-center shadow">
                            05
                        </div>
                        <h4 class="font-serif font-bold text-base text-brand-900">Rejuvenate</h4>
                        <p class="text-xs text-slate-600 font-light leading-relaxed">
                            Leave refreshed with lasting sacred and holiday memories.
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- 6. Guest Testimonials (Pinterest "Insights - Ideas. Trends. Inspiration." Dark Cards) -->
<section class="bg-brand-900 py-24 text-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start mb-12">
            
            <!-- Left Header -->
            <div class="lg:col-span-4 space-y-3">
                <span class="text-gold-400 font-semibold text-xs uppercase tracking-[0.25em] block">VISITOR FEEDBACK</span>
                <h2 class="text-4xl sm:text-5xl font-serif text-white leading-tight">
                    Words of<br><span class="italic text-gold-400 font-normal">Gratitude & Trust.</span>
                </h2>
                <p class="text-slate-300 text-xs sm:text-sm font-light leading-relaxed">
                    Honest impressions from visiting families and devotees who made Sanda Guest House their sanctuary.
                </p>
            </div>

            <!-- Right 3 Testimonial Cards -->
            <div class="lg:col-span-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    @forelse($reviews as $rev)
                        <div class="bg-white/[0.04] border border-white/10 rounded-2xl p-6 flex flex-col justify-between hover:border-gold-400/50 transition">
                            <div class="space-y-3">
                                <div class="flex text-gold-400 text-xs gap-1">
                                    @for($i = 0; $i < $rev->rating; $i++)
                                        <i class="fa-solid fa-star"></i>
                                    @endfor
                                </div>
                                <p class="text-xs text-slate-200 font-serif italic leading-relaxed">
                                    "{{ $rev->comment }}"
                                </p>
                            </div>

                            <div class="pt-4 border-t border-white/10 mt-4 flex items-center justify-between">
                                <div>
                                    <div class="text-xs font-bold text-white">{{ $rev->guest_name }}</div>
                                    <div class="text-[10px] text-slate-400">{{ $rev->guest_location }}</div>
                                </div>
                                <span class="text-[10px] text-gold-400 uppercase tracking-widest font-semibold">Verified</span>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-8 text-slate-400 text-xs">
                            No reviews published yet.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
