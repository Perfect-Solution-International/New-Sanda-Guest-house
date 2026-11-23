@extends('layouts.app')

@section('title', 'Rooms & Luxury Cabanas - නිවි සඳ (Nivi Sanda) Family Holiday Resort')

@section('content')
<section class="py-16 bg-brand-900 text-white text-center bg-cover bg-center" style="background-image: linear-gradient(rgba(14, 45, 28, 0.85), rgba(14, 45, 28, 0.9)), url('https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1600&q=80');">
    <div class="max-w-4xl mx-auto px-4">
        <span class="text-gold-400 font-bold text-xs uppercase tracking-widest block mb-2">Our Accommodations</span>
        <h1 class="text-4xl sm:text-5xl font-serif font-bold text-white mb-4">Villas, Cabanas & Suites</h1>
        <p class="text-slate-200 text-base max-w-2xl mx-auto font-light">
            Designed for family comfort, pilgrims, and nature seekers in serene Sella Katharagama.
        </p>
    </div>
</section>

<!-- Filter & Rooms List -->
<section class="py-16 bg-stone-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Filter Bar -->
        <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-slate-200 mb-12">
            <form action="{{ route('rooms.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Guests Needed</label>
                    <select name="guests" class="w-full text-sm border border-slate-300 rounded-lg px-3 py-2 bg-white focus:ring-2 focus:ring-brand-500">
                        <option value="">Any Guest Count</option>
                        <option value="2" {{ request('guests') == '2' ? 'selected' : '' }}>2+ Guests</option>
                        <option value="3" {{ request('guests') == '3' ? 'selected' : '' }}>3+ Guests</option>
                        <option value="4" {{ request('guests') == '4' ? 'selected' : '' }}>4+ Guests</option>
                        <option value="6" {{ request('guests') == '6' ? 'selected' : '' }}>6+ Guests (Family)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Max Price (Rs. / night)</label>
                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="e.g. 25000" class="w-full text-sm border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-brand-500">
                </div>

                <div>
                    <button type="submit" class="w-full bg-brand-700 hover:bg-brand-800 text-white font-bold py-2 rounded-lg text-sm transition">
                        Filter Rooms
                    </button>
                </div>

                <div>
                    <a href="{{ route('rooms.index') }}" class="block text-center text-xs font-bold text-slate-500 hover:text-slate-800 py-2.5">
                        Reset Filters
                    </a>
                </div>
            </form>
        </div>

        <!-- Rooms Grid -->
        <div class="space-y-8">
            @forelse($rooms as $room)
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-md transition border border-slate-200 grid grid-cols-1 lg:grid-cols-12">
                    <div class="lg:col-span-5 relative min-h-[260px]">
                        <img src="{{ $room->image }}" alt="{{ $room->name }}" class="w-full h-full object-cover">
                        <div class="absolute top-4 left-4 bg-brand-900/80 backdrop-blur-md text-gold-400 text-xs font-bold px-3 py-1.5 rounded-full">
                            Rs. {{ number_format($room->base_price_per_night) }} / night
                        </div>
                    </div>

                    <div class="lg:col-span-7 p-6 sm:p-8 flex flex-col justify-between">
                        <div>
                            <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500 mb-2">
                                <span class="bg-brand-50 text-brand-800 font-semibold px-2.5 py-1 rounded-md">
                                    <i class="fa-solid fa-users mr-1"></i> Up to {{ $room->max_adults }} Adults & {{ $room->max_children }} Kids
                                </span>
                                <span><i class="fa-solid fa-bed text-brand-600 mr-1"></i> {{ $room->bed_type }}</span>
                                <span><i class="fa-solid fa-ruler-combined text-brand-600 mr-1"></i> {{ $room->room_size }}</span>
                            </div>

                            <h3 class="text-2xl font-serif font-bold text-slate-900 mb-2">
                                <a href="{{ route('rooms.show', $room->slug) }}" class="hover:text-brand-700 transition">{{ $room->name }}</a>
                            </h3>

                            <p class="text-slate-600 text-sm leading-relaxed mb-4">
                                {{ $room->short_description }}
                            </p>

                            <!-- Amenities icons -->
                            <div class="flex flex-wrap gap-2 mb-6">
                                @foreach($room->amenities->take(5) as $amenity)
                                    <span class="text-xs bg-slate-100 text-slate-700 px-2.5 py-1 rounded-md flex items-center gap-1.5">
                                        <i class="fa-solid fa-circle-check text-brand-600 text-[10px]"></i> {{ $amenity->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-4">
                            <div>
                                <span class="text-xs text-slate-500 block">Rate per Night (Net)</span>
                                <span class="text-2xl font-bold font-serif text-brand-900">Rs. {{ number_format($room->base_price_per_night) }}</span>
                            </div>

                            <div class="flex items-center gap-3">
                                <a href="{{ route('rooms.show', $room->slug) }}" class="text-sm font-bold text-slate-700 hover:text-brand-800 px-4 py-2">
                                    View Details
                                </a>
                                <a href="{{ route('booking.create', ['room_type_id' => $room->id]) }}" class="bg-brand-700 hover:bg-brand-800 text-white font-bold text-sm px-6 py-2.5 rounded-xl shadow transition">
                                    Book Room
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-16 bg-white rounded-3xl border border-dashed border-slate-300">
                    <i class="fa-solid fa-hotel text-4xl text-slate-300 mb-3"></i>
                    <h3 class="text-lg font-bold text-slate-700">No rooms matched your filter</h3>
                    <p class="text-sm text-slate-500 mt-1">Try resetting your filter parameters or contact us directly.</p>
                    <a href="{{ route('rooms.index') }}" class="inline-block mt-4 bg-brand-700 text-white text-xs font-bold px-4 py-2 rounded-lg">View All Rooms</a>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
