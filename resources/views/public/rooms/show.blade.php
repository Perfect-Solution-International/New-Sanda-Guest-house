@extends('layouts.app')

@section('title', $room->name . ' - New Sanda Guest House')

@section('content')
<section class="py-12 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <a href="{{ route('rooms.index') }}" class="text-xs font-bold text-brand-700 hover:underline mb-2 inline-flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left"></i> Back to Rooms & Cabanas
                </a>
                <h1 class="text-3xl sm:text-4xl font-serif font-bold text-brand-900">{{ $room->name }}</h1>
                <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500 mt-1">
                    <span><i class="fa-solid fa-user-group text-brand-600 mr-1"></i> Up to {{ $room->max_adults }} Adults, {{ $room->max_children }} Children</span>
                    <span>•</span>
                    <span><i class="fa-solid fa-bed text-brand-600 mr-1"></i> {{ $room->bed_type }}</span>
                    <span>•</span>
                    <span><i class="fa-solid fa-ruler-combined text-brand-600 mr-1"></i> {{ $room->room_size }}</span>
                </div>
            </div>

            <div class="text-right">
                <span class="text-xs text-slate-500 block">Starting from</span>
                <span class="text-3xl font-serif font-bold text-brand-900">Rs. {{ number_format($room->base_price_per_night) }}</span>
                <span class="text-xs text-slate-400 block">per night</span>
            </div>
        </div>
    </div>
</section>

<!-- Room Details & Booking Action -->
<section class="py-12 bg-stone-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Side: Photos & Description -->
            <div class="lg:col-span-8 space-y-8">
                <!-- Main Image -->
                <div class="rounded-3xl overflow-hidden shadow-sm border border-slate-200 h-[380px] sm:h-[460px]">
                    <img src="{{ $room->image }}" alt="{{ $room->name }}" class="w-full h-full object-cover">
                </div>

                <!-- Gallery Thumbnails if any -->
                @if(!empty($room->gallery) && count($room->gallery) > 1)
                    <div class="grid grid-cols-3 gap-4">
                        @foreach($room->gallery as $gUrl)
                            <div class="rounded-2xl overflow-hidden h-32 border border-slate-200">
                                <img src="{{ $gUrl }}" alt="{{ $room->name }}" class="w-full h-full object-cover hover:scale-105 transition">
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Description -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-200 space-y-4">
                    <h3 class="text-2xl font-serif font-bold text-brand-900">Room Overview</h3>
                    <p class="text-slate-700 leading-relaxed text-sm sm:text-base">
                        {{ $room->description }}
                    </p>
                </div>

                <!-- Amenities List -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-200">
                    <h3 class="text-2xl font-serif font-bold text-brand-900 mb-6">Included Room Amenities</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($room->amenities as $amenity)
                            <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">
                                <i class="fa-solid fa-check-circle text-brand-600 text-lg"></i>
                                <span class="text-sm font-medium text-slate-800">{{ $amenity->name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Resort Rules & Times -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-200 space-y-3">
                    <h3 class="text-xl font-serif font-bold text-brand-900">Check-in Policies</h3>
                    <ul class="text-xs sm:text-sm text-slate-600 space-y-2">
                        <li><strong class="text-slate-800">Check-in:</strong> 02:00 PM onwards</li>
                        <li><strong class="text-slate-800">Check-out:</strong> By 11:00 AM</li>
                        <li><strong class="text-slate-800">Advance Deposit:</strong> Required to confirm dates (Bank transfer or instant slip upload).</li>
                        <li><strong class="text-slate-800">Family Atmosphere:</strong> Strictly quiet hours after 10:30 PM for all guests' peaceful rest.</li>
                    </ul>
                </div>
            </div>

            <!-- Right Side: Sticky Quick Booking Card -->
            <div class="lg:col-span-4">
                <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-lg border border-slate-200 sticky top-28 space-y-6">
                    <div>
                        <span class="text-xs font-bold text-gold-600 uppercase tracking-widest block mb-1">Instant Reservation</span>
                        <h3 class="text-2xl font-serif font-bold text-brand-900">Book This Room</h3>
                    </div>

                    <div class="bg-brand-50 p-4 rounded-2xl border border-brand-100 flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-600 block">Nightly Rate</span>
                            <span class="text-2xl font-bold font-serif text-brand-900">Rs. {{ number_format($room->base_price_per_night) }}</span>
                        </div>
                        <span class="text-xs bg-emerald-600 text-white font-bold px-2.5 py-1 rounded-full">Available</span>
                    </div>

                    <a href="{{ route('booking.create', ['room_type_id' => $room->id]) }}" class="block w-full text-center bg-brand-700 hover:bg-brand-800 text-white font-bold py-3.5 rounded-xl shadow-md hover:shadow-lg transition text-sm">
                        Proceed to Reservation &rarr;
                    </a>

                    <div class="pt-4 border-t border-slate-100 space-y-2 text-xs text-slate-500">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-shield-halved text-brand-600"></i> No hidden service charges
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-mug-hot text-brand-600"></i> Ceylon tea/coffee setup included
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-brands fa-whatsapp text-emerald-500"></i> Instant support via WhatsApp
                        </div>
                    </div>

                    <div class="p-4 bg-slate-50 rounded-2xl text-center">
                        <span class="text-xs text-slate-500 block mb-1">Prefer phone booking?</span>
                        <a href="tel:+94779876543" class="text-sm font-bold text-brand-700 hover:underline">
                            <i class="fa-solid fa-phone mr-1"></i> +94 77 987 6543
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
