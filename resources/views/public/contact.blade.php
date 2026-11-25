@extends('layouts.app')

@section('title', 'Contact Us & Location Map - Sanda Guest House')

@section('content')
<section class="py-16 bg-brand-900 text-white text-center relative overflow-hidden border-b border-white/10">
    <div class="max-w-4xl mx-auto px-4 relative z-10">
        <span class="text-gold-400 font-semibold text-xs uppercase tracking-[0.25em] block mb-2">GET IN TOUCH</span>
        <h1 class="text-4xl sm:text-5xl font-serif text-white mb-3">Contact and Location</h1>
        <p class="text-slate-300 text-sm font-light max-w-2xl mx-auto">
            We are always here to assist you with room reservations, pilgrimage guidance, directions, and family bookings across our branches.
        </p>
    </div>
</section>

<section class="py-16 bg-stone-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-300 text-emerald-800 p-4 rounded-2xl text-sm flex items-center gap-3 shadow-xs">
                <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            <!-- Contact Info & Quick Links -->
            <div class="space-y-8">
                <div>
                    <span class="text-gold-600 font-bold text-xs uppercase tracking-widest block mb-1">Direct Helpdesk</span>
                    <h2 class="text-3xl font-serif font-bold text-brand-900">Reach Out to Our Desk</h2>
                    <p class="text-slate-600 mt-2 text-sm leading-relaxed">
                        Our friendly front desk team is on-site 24/7 to answer your calls, respond to WhatsApp messages, and help you lock your dates.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- Phone Hotlines -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-2">
                        <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <h4 class="font-bold text-slate-900 text-sm">Direct Phone Call</h4>
                        <p class="text-xs text-slate-600">
                            <a href="tel:+94779876543" class="hover:text-brand-800 font-bold text-slate-900 block">+94 77 987 6543</a>
                            <a href="tel:+94472235566" class="hover:text-brand-800 text-slate-600 block mt-0.5">+94 47 223 5566</a>
                        </p>
                    </div>

                    <!-- WhatsApp Chat Link -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-2">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                            <i class="fa-brands fa-whatsapp"></i>
                        </div>
                        <h4 class="font-bold text-slate-900 text-sm">WhatsApp Chat</h4>
                        <p class="text-xs text-slate-600">+94 77 987 6543</p>
                        <a href="https://wa.me/94779876543?text={{ urlencode('Hello Sanda Guest House, I would like to inquire about room availability.') }}" target="_blank"
                           class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 hover:text-emerald-700 mt-1">
                            Chat on WhatsApp &rarr;
                        </a>
                    </div>

                    <!-- Exact Address -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-2">
                        <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <h4 class="font-bold text-slate-900 text-sm">Exact Address</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            No. 45, Sella Road, Sella Katharagama, Southern Province, Sri Lanka
                        </p>
                    </div>

                    <!-- Email -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-2">
                        <div class="w-10 h-10 rounded-xl bg-gold-50 text-gold-600 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <h4 class="font-bold text-slate-900 text-sm">Email Inquiries</h4>
                        <p class="text-xs text-slate-600">
                            <a href="mailto:info@sandaresort.com" class="hover:text-brand-800">info@sandaresort.com</a>
                        </p>
                    </div>
                </div>

                <!-- Distance Landmarks -->
                <div class="bg-brand-900 text-white p-6 rounded-2xl shadow-md border border-brand-800">
                    <h4 class="font-bold font-serif text-base mb-3 text-gold-400 flex items-center gap-2">
                        <i class="fa-solid fa-compass"></i> Approximate Distances to Sacred Shrines
                    </h4>
                    <ul class="text-xs space-y-2.5 text-slate-200">
                        <li class="flex justify-between border-b border-brand-800 pb-1.5">
                            <span>Sella Kataragama Temple & Menik Ganga Bathing Ghats</span>
                            <span class="font-bold text-gold-400">1.2 km (3 mins)</span>
                        </li>
                        <li class="flex justify-between border-b border-brand-800 pb-1.5">
                            <span>Ruhunu Kataragama Maha Devalaya (Main Shrine)</span>
                            <span class="font-bold text-gold-400">4.5 km (10 mins)</span>
                        </li>
                        <li class="flex justify-between border-b border-brand-800 pb-1.5">
                            <span>Kiri Vehera Sacred Stupa</span>
                            <span class="font-bold text-gold-400">5.0 km (12 mins)</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Yala National Park Katagamuwa Entrance</span>
                            <span class="font-bold text-gold-400">18 km (25 mins)</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Inquiry Form -->
            <div class="bg-white p-8 sm:p-10 rounded-3xl shadow-sm border border-slate-200 space-y-6">
                <div>
                    <span class="text-gold-600 font-bold text-xs uppercase tracking-widest block mb-1">Direct Message</span>
                    <h3 class="text-2xl font-serif font-bold text-slate-900">Send Us an Inquiry</h3>
                    <p class="text-xs text-slate-500 mt-1">Leave your details and requirements; our manager will reply within 30 minutes.</p>
                </div>

                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Your Full Name *</label>
                        <input type="text" name="name" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500 focus:outline-none" placeholder="e.g. Kasun Fernando">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Email Address *</label>
                            <input type="email" name="email" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500 focus:outline-none" placeholder="kasun@example.com">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                                <i class="fa-brands fa-whatsapp text-emerald-600 mr-1"></i> Phone / WhatsApp
                            </label>
                            <input type="text" name="phone" placeholder="+94 7X XXX XXXX" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Subject</label>
                        <input type="text" name="subject" placeholder="Room availability, pilgrimage dates, etc." class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Your Message / Requirements *</label>
                        <textarea name="message" rows="4" required placeholder="Let us know dates, number of family members, or specific questions..." class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500 focus:outline-none"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-brand-700 hover:bg-brand-800 text-white font-bold py-3.5 rounded-xl shadow-md transition text-sm flex items-center justify-center gap-2">
                        <i class="fa-regular fa-paper-plane"></i> Send Inquiry Message
                    </button>
                </form>
            </div>
        </div>

        <!-- Interactive Google Maps Embed Section -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-slate-200 space-y-4">
            <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-100 pb-3">
                <div>
                    <h3 class="font-serif font-bold text-xl text-slate-900">Location Map & Directions</h3>
                    <p class="text-xs text-slate-500">Located conveniently along Sella Road, Kataragama.</p>
                </div>
                <a href="https://maps.google.com/?q=Sella+Kataragama,+Sri+Lanka" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-700 hover:text-brand-900">
                    <i class="fa-solid fa-diamond-turn-right text-gold-600"></i> Open in Google Maps App &rarr;
                </a>
            </div>

            <div class="w-full h-80 sm:h-96 rounded-2xl overflow-hidden border border-slate-200">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15858.916120894762!2d81.2891!3d6.4422!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae69cc0606ecb6d%3A0xb363ea534c0f2095!2sSella%20Kataragama!5e0!3m2!1sen!2slk!4v1700000000000!5m2!1sen!2slk"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

    </div>
</section>
@endsection
