@extends('layouts.app')

@section('title', 'Rooms and Rates - Sanda Guest House')

@section('content')
<section class="py-16 bg-brand-900 text-white text-center relative overflow-hidden border-b border-white/10">
    <div class="max-w-3xl mx-auto px-4 relative z-10">
        <span class="text-gold-400 font-semibold text-xs uppercase tracking-[0.25em] block mb-2">ACCOMMODATION & RATES</span>
        <h1 class="text-4xl sm:text-5xl font-serif text-white mb-3">Our Rooms and Rates</h1>
        <p class="text-slate-300 text-sm font-light">Clean, comfortable, and affordable accommodation with live availability across our branch locations.</p>
        <div class="mt-4 flex flex-wrap items-center justify-center gap-3">
            <span class="inline-flex items-center gap-1.5 bg-emerald-950/80 border border-emerald-500/40 text-emerald-300 text-xs px-3 py-1 rounded-full">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Live Availability Active
            </span>
            <span class="inline-flex items-center gap-1.5 bg-brand-950/80 border border-gold-500/30 text-gold-300 text-xs px-3 py-1 rounded-full">
                <i class="fa-solid fa-clock text-gold-400"></i> Nightly & Flexible Day-Use Rates
            </span>
        </div>
    </div>
</section>

<section class="py-16 bg-stone-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-6">
            @foreach($rooms as $room)
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200 grid grid-cols-1 md:grid-cols-12 hover:shadow-md transition">
                    <div class="md:col-span-5 relative min-h-[220px]">
                        <img src="{{ $room->image }}" alt="{{ $room->name }}" class="w-full h-full object-cover">
                        <div class="absolute top-3 left-3 bg-brand-900/90 text-gold-400 text-xs font-bold px-3 py-1.5 rounded-full shadow-md backdrop-blur-xs">
                            Rs. {{ number_format($room->base_price_per_night) }} / night
                        </div>
                        <div class="absolute bottom-3 left-3 bg-emerald-900/90 text-emerald-200 text-[10px] font-bold px-2.5 py-1 rounded-md backdrop-blur-xs flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Live Available
                        </div>
                    </div>

                    <div class="md:col-span-7 p-6 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-3 text-xs text-slate-500 mb-1">
                                <span><i class="fa-solid fa-users text-brand-700 mr-1"></i> Max {{ $room->max_adults }} Adults, {{ $room->max_children }} Children</span>
                                <span>•</span>
                                <span><i class="fa-solid fa-bed text-brand-700 mr-1"></i> {{ $room->bed_type }}</span>
                                @if($room->room_size)
                                    <span>•</span>
                                    <span><i class="fa-solid fa-ruler-combined text-brand-700 mr-1"></i> {{ $room->room_size }}</span>
                                @endif
                            </div>

                            <h3 class="text-xl font-serif font-bold text-slate-900">{{ $room->name }}</h3>
                            <p class="text-xs text-slate-600 leading-relaxed mt-1 mb-3">{{ $room->short_description }}</p>

                            <div class="flex flex-wrap gap-1.5 mb-4">
                                @foreach($room->amenities->take(6) as $am)
                                    <span class="text-[11px] bg-slate-100 text-slate-700 px-2 py-0.5 rounded flex items-center gap-1">
                                        <i class="fa-solid fa-check text-brand-700 text-[9px]"></i> {{ $am->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-2">
                            <div>
                                <span class="text-[10px] text-slate-400 block uppercase">Base Rate</span>
                                <span class="font-serif font-bold text-xl text-brand-900">Rs. {{ number_format($room->base_price_per_night) }}</span>
                                <span class="text-[10px] text-slate-500 block">Day-use / Hourly rates calculated live</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <a href="tel:+94779876543" class="bg-brand-700 hover:bg-brand-800 text-white font-bold text-xs px-3.5 py-2 rounded-lg transition flex items-center gap-1.5">
                                    <i class="fa-solid fa-phone"></i> Call
                                </a>
                                <a href="https://wa.me/94779876543?text={{ urlencode('Hello, I would like to inquire about booking: ' . $room->name) }}" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-3.5 py-2 rounded-lg transition flex items-center gap-1.5">
                                    <i class="fa-brands fa-whatsapp"></i> WhatsApp
                                </a>
                                <a href="{{ route('booking.create', ['room_type_id' => $room->id]) }}" class="bg-gold-500 hover:bg-gold-400 text-brand-950 font-bold text-xs px-3.5 py-2 rounded-lg transition shadow-xs flex items-center gap-1">
                                    Book Live &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
