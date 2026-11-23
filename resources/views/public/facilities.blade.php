@extends('layouts.app')

@section('title', 'Resort Facilities - නිවි සඳ (Nivi Sanda) Family Holiday Resort')

@section('content')
<section class="py-16 bg-brand-900 text-white text-center bg-cover bg-center" style="background-image: linear-gradient(rgba(14, 45, 28, 0.85), rgba(14, 45, 28, 0.9)), url('https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1600&q=80');">
    <div class="max-w-4xl mx-auto px-4">
        <span class="text-gold-400 font-bold text-xs uppercase tracking-widest block mb-2">Luxury & Comfort</span>
        <h1 class="text-4xl sm:text-5xl font-serif font-bold text-white mb-4">Resort Facilities & Services</h1>
        <p class="text-slate-200 text-base max-w-2xl mx-auto font-light">
            Everything you and your family need for a relaxing, carefree holiday in Sella Katharagama.
        </p>
    </div>
</section>

<section class="py-20 bg-stone-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Swimming Pool -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100 p-8 space-y-4">
                <div class="w-14 h-14 rounded-2xl bg-water-500/10 text-water-600 flex items-center justify-center text-2xl">
                    <i class="fa-solid fa-water"></i>
                </div>
                <h3 class="text-xl font-serif font-bold text-slate-900">Swimming Pool & Kids Pool</h3>
                <p class="text-slate-600 text-sm leading-relaxed">
                    Unwind in our pristine outdoor swimming pool surrounded by tropical palm trees. Features a shallow, dedicated children's pool section and relaxing poolside sun loungers.
                </p>
            </div>

            <!-- Southern Dining -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100 p-8 space-y-4">
                <div class="w-14 h-14 rounded-2xl bg-amber-500/10 text-amber-600 flex items-center justify-center text-2xl">
                    <i class="fa-solid fa-utensils"></i>
                </div>
                <h3 class="text-xl font-serif font-bold text-slate-900">Sri Lankan Dining & Restaurant</h3>
                <p class="text-slate-600 text-sm leading-relaxed">
                    Taste authentic southern Sri Lankan cuisine! Fresh fish ambul thiyal, rich curries, fragrant rice, and customizable set menus. In-room dining and pool patio service available.
                </p>
            </div>

            <!-- Yala Safari -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100 p-8 space-y-4">
                <div class="w-14 h-14 rounded-2xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center text-2xl">
                    <i class="fa-solid fa-truck-monster"></i>
                </div>
                <h3 class="text-xl font-serif font-bold text-slate-900">Yala Safari Tour Desk</h3>
                <p class="text-slate-600 text-sm leading-relaxed">
                    We arrange private 4x4 open safari jeeps with veteran wildlife trackers for morning or afternoon safaris into Yala National Park and Lunugamvehera.
                </p>
            </div>

            <!-- BBQ Nights -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100 p-8 space-y-4">
                <div class="w-14 h-14 rounded-2xl bg-rose-500/10 text-rose-600 flex items-center justify-center text-2xl">
                    <i class="fa-solid fa-fire"></i>
                </div>
                <h3 class="text-xl font-serif font-bold text-slate-900">Night BBQ & Campfire Lawn</h3>
                <p class="text-slate-600 text-sm leading-relaxed">
                    Celebrate family gatherings under the stars with our live charcoal BBQ nights by the poolside garden, complete with music and campfire warmth.
                </p>
            </div>

            <!-- Temple Coordination -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100 p-8 space-y-4">
                <div class="w-14 h-14 rounded-2xl bg-gold-500/10 text-gold-600 flex items-center justify-center text-2xl">
                    <i class="fa-solid fa-gopuram"></i>
                </div>
                <h3 class="text-xl font-serif font-bold text-slate-900">Pilgrimage & Pooja Support</h3>
                <p class="text-slate-600 text-sm leading-relaxed">
                    Direct guidance and timing advice for Kataragama Maha Devalaya, Sella Temple, and Kiri Vehera ceremonies, along with custom van shuttle arrangements.
                </p>
            </div>

            <!-- 24/7 Power & Security -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100 p-8 space-y-4">
                <div class="w-14 h-14 rounded-2xl bg-indigo-500/10 text-indigo-600 flex items-center justify-center text-2xl">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h3 class="text-xl font-serif font-bold text-slate-900">Backup Generator & Security</h3>
                <p class="text-slate-600 text-sm leading-relaxed">
                    Uninterrupted 24/7 air conditioning and electricity with our heavy-duty diesel generator, spacious bus/van parking, and continuous CCTV surveillance.
                </p>
            </div>
        </div>

        <div class="mt-16 text-center">
            <a href="{{ route('booking.create') }}" class="bg-brand-700 hover:bg-brand-800 text-white font-bold py-3.5 px-8 rounded-full shadow-lg transition">
                Book Your Stay Today
            </a>
        </div>
    </div>
</section>
@endsection
