@extends('layouts.app')

@section('title', 'Contact Us - New Sanda Guest House')

@section('content')
<section class="py-16 bg-brand-900 text-white text-center relative overflow-hidden border-b border-white/10">
    <div class="max-w-4xl mx-auto px-4 relative z-10">
        <span class="text-gold-400 font-semibold text-xs uppercase tracking-[0.25em] block mb-2">GET IN TOUCH</span>
        <h1 class="text-4xl sm:text-5xl font-serif text-white mb-3">Contact and Location</h1>
        <p class="text-slate-300 text-sm font-light max-w-2xl mx-auto">
            We are here to assist with room bookings, pilgrimage guidance, and family reservations across our branches.
        </p>
    </div>
</section>

<section class="py-20 bg-stone-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Info & Map Details -->
            <div class="space-y-8">
                <div>
                    <span class="text-gold-600 font-bold text-xs uppercase tracking-widest block mb-1">Direct Contact</span>
                    <h2 class="text-3xl font-serif font-bold text-brand-900">Reach Out to Our Desk</h2>
                    <p class="text-slate-600 mt-2 text-sm">
                        Our front desk team is available 24/7 to answer calls and assist with reservations.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 space-y-2">
                        <i class="fa-solid fa-phone text-2xl text-brand-600"></i>
                        <h4 class="font-bold text-slate-900">Phone Hotlines</h4>
                        <p class="text-sm text-slate-600">+94 77 987 6543<br>+94 47 223 5566</p>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 space-y-2">
                        <i class="fa-brands fa-whatsapp text-2xl text-emerald-500"></i>
                        <h4 class="font-bold text-slate-900">WhatsApp Chat</h4>
                        <p class="text-sm text-slate-600">+94 77 987 6543</p>
                        <a href="https://wa.me/94779876543" target="_blank" class="inline-block text-xs font-bold text-emerald-600 hover:underline">Chat with us &rarr;</a>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 space-y-2">
                        <i class="fa-solid fa-location-dot text-2xl text-rose-500"></i>
                        <h4 class="font-bold text-slate-900">Resort Address</h4>
                        <p class="text-sm text-slate-600">No. 45, Sella Road, Sella Katharagama, Sri Lanka</p>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 space-y-2">
                        <i class="fa-solid fa-envelope text-2xl text-gold-500"></i>
                        <h4 class="font-bold text-slate-900">Email Address</h4>
                        <p class="text-sm text-slate-600">info@newsandaresort.com</p>
                    </div>
                </div>

                <!-- Directions & Distances Box -->
                <div class="bg-brand-900 text-white p-6 rounded-2xl">
                    <h4 class="font-bold font-serif text-lg mb-3 text-gold-400">Approximate Distances</h4>
                    <ul class="text-xs space-y-2 text-slate-200">
                        <li class="flex justify-between border-b border-brand-800 pb-1.5">
                            <span>Kataragama Maha Devalaya</span>
                            <span class="font-bold text-gold-400">4.5 km (10 mins)</span>
                        </li>
                        <li class="flex justify-between border-b border-brand-800 pb-1.5">
                            <span>Sella Kataragama Temple & Menik Ganga</span>
                            <span class="font-bold text-gold-400">1.2 km (3 mins)</span>
                        </li>
                        <li class="flex justify-between border-b border-brand-800 pb-1.5">
                            <span>Yala National Park Katagamuwa Gate</span>
                            <span class="font-bold text-gold-400">18 km (25 mins)</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Kiri Vehera Sacred Stupa</span>
                            <span class="font-bold text-gold-400">5 km (12 mins)</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Inquiry Form -->
            <div class="bg-white p-8 sm:p-10 rounded-3xl shadow-sm border border-slate-100">
                <span class="text-gold-600 font-bold text-xs uppercase tracking-widest block mb-1">Send a Message</span>
                <h3 class="text-2xl font-serif font-bold text-slate-900 mb-6">Online Inquiry Form</h3>

                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Your Full Name *</label>
                        <input type="text" name="name" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Email Address *</label>
                            <input type="email" name="email" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Phone / WhatsApp</label>
                            <input type="text" name="phone" placeholder="+94 7X XXX XXXX" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Subject</label>
                        <input type="text" name="subject" placeholder="Room booking inquiry, safari, etc." class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Message / Requirements *</label>
                        <textarea name="message" rows="4" required placeholder="Let us know dates, number of guests, or special requirements..." class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500 focus:outline-none"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-brand-700 hover:bg-brand-800 text-white font-bold py-3.5 rounded-xl shadow-md transition text-sm">
                        Send Inquiry Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
