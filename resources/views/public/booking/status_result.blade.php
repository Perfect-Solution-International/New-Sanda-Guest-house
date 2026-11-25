@extends('layouts.app')

@section('title', 'Guest Portal - Reservation ' . $booking->booking_code . ' | Sanda Guest House')

@section('content')
<section class="py-10 bg-brand-900 text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#d99726_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="bg-gold-400/20 text-gold-400 border border-gold-400/30 text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                    Guest Self-Service Portal
                </span>
                <span class="text-xs text-slate-300">
                    Booked on {{ $booking->created_at->format('M d, Y') }}
                </span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-serif font-bold text-white flex items-center gap-3">
                <span>{{ $booking->booking_code }}</span>
            </h1>
            <p class="text-xs text-slate-300 mt-1">
                Guest: <strong class="text-white">{{ $booking->guest_name }}</strong> &bull; {{ $booking->guest_phone }}
            </p>
        </div>

        <!-- Status Badge -->
        <div class="flex items-center gap-3">
            @php
                $statusBadges = [
                    'pending' => 'bg-amber-400/20 text-amber-300 border-amber-400/40',
                    'confirmed' => 'bg-blue-400/20 text-blue-300 border-blue-400/40',
                    'checked_in' => 'bg-emerald-400/20 text-emerald-300 border-emerald-400/40',
                    'checked_out' => 'bg-purple-400/20 text-purple-300 border-purple-400/40',
                    'cancelled' => 'bg-rose-400/20 text-rose-300 border-rose-400/40',
                ];
                $statusLabels = [
                    'pending' => 'Pending Approval',
                    'confirmed' => 'Confirmed Stay',
                    'checked_in' => 'Checked In (In-House)',
                    'checked_out' => 'Completed Stay',
                    'cancelled' => 'Cancelled',
                ];
            @endphp
            <div class="px-4 py-2 rounded-2xl border text-xs font-bold uppercase tracking-wider shadow-sm {{ $statusBadges[$booking->booking_status] ?? 'bg-white/10 text-white' }}">
                Status: {{ $statusLabels[$booking->booking_status] ?? ucfirst($booking->booking_status) }}
            </div>
        </div>
    </div>
</section>

<section class="py-12 bg-[#fcfaf7]">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <!-- Cancellation Banner if Cancelled -->
        @if($booking->booking_status === 'cancelled')
            <div class="bg-rose-50 border border-rose-300 text-rose-900 p-6 rounded-3xl shadow-sm flex items-start gap-4">
                <div class="w-10 h-10 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center text-lg flex-shrink-0 mt-0.5">
                    <i class="fa-solid fa-ban"></i>
                </div>
                <div>
                    <h3 class="font-bold text-base text-rose-900">This Reservation Has Been Cancelled</h3>
                    <p class="text-xs text-rose-700 mt-1">
                        The room slot has been released. If you had paid an advance deposit, our management will process refunds or adjustments according to our guest house policy.
                    </p>
                    <div class="mt-3 flex items-center gap-3">
                        <a href="https://wa.me/94779876543?text={{ urlencode('Hello Sanda Guest House, I am inquiring regarding refund for my cancelled booking ' . $booking->booking_code) }}" 
                           target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-rose-800 bg-rose-200/60 hover:bg-rose-200 px-3 py-1.5 rounded-xl transition">
                            <i class="fa-brands fa-whatsapp"></i> Chat with Reception on WhatsApp
                        </a>
                        <a href="{{ route('booking.create') }}" class="text-xs font-bold text-brand-800 underline">
                            Book a New Stay &rarr;
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Left 2 Columns: Stay Details, Modification & Cancellation -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Stay Details Card -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
                        <h3 class="text-lg font-serif font-bold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-hotel text-brand-700"></i> Accommodation & Stay Schedule
                        </h3>
                        <span class="text-xs font-bold text-brand-700 bg-brand-50 px-3 py-1 rounded-full">
                            {{ $booking->duration_display }}
                        </span>
                    </div>

                    <!-- Room & Schedule Details -->
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-slate-50 p-5 rounded-2xl border border-slate-100">
                            <div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Category</span>
                                <div class="text-base font-serif font-bold text-brand-900 mt-0.5">{{ $booking->roomType->name }}</div>
                                <div class="text-xs text-slate-500 mt-1">
                                    Bed: {{ $booking->roomType->bed_type }} &bull; Max {{ $booking->roomType->max_adults }} Adults
                                </div>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Allocated Room</span>
                                @if($booking->room)
                                    <div class="text-base font-bold text-emerald-800 mt-0.5">
                                        <i class="fa-solid fa-door-open text-emerald-600 mr-1"></i> Room {{ $booking->room->room_number }}
                                    </div>
                                    <div class="text-xs text-slate-500 mt-1">
                                        Floor / Wing: {{ $booking->room->floor_wing ?: 'Main Guest Wing' }}
                                    </div>
                                @else
                                    <div class="text-sm font-semibold text-amber-700 mt-0.5">
                                        Assigned at Check-in
                                    </div>
                                    <div class="text-xs text-slate-400 mt-1">Guaranteed room under this category</div>
                                @endif
                            </div>
                        </div>

                        <!-- Exact Date & Times Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            <div class="p-4 rounded-2xl border border-slate-200 bg-white">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Check-in</span>
                                <div class="text-base font-bold text-slate-900 mt-1">
                                    {{ $booking->check_in_at ? $booking->check_in_at->format('D, M d, Y') : \Carbon\Carbon::parse($booking->check_in_date)->format('D, M d, Y') }}
                                </div>
                                <div class="text-xs font-bold text-brand-700 mt-0.5 flex items-center gap-1">
                                    <i class="fa-regular fa-clock"></i>
                                    <span>Time: {{ $booking->check_in_at ? $booking->check_in_at->format('h:i A') : date('h:i A', strtotime($booking->check_in_time ?? '14:00')) }}</span>
                                </div>
                            </div>

                            <div class="p-4 rounded-2xl border border-slate-200 bg-white">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Check-out</span>
                                <div class="text-base font-bold text-slate-900 mt-1">
                                    {{ $booking->check_out_at ? $booking->check_out_at->format('D, M d, Y') : \Carbon\Carbon::parse($booking->check_out_date)->format('D, M d, Y') }}
                                </div>
                                <div class="text-xs font-bold text-brand-700 mt-0.5 flex items-center gap-1">
                                    <i class="fa-regular fa-clock"></i>
                                    <span>Time: {{ $booking->check_out_at ? $booking->check_out_at->format('h:i A') : date('h:i A', strtotime($booking->check_out_time ?? '11:00')) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Guests & Addons -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs bg-stone-50 p-4 rounded-2xl">
                            <div>
                                <span class="text-slate-400 uppercase font-bold text-[10px]">Adults</span>
                                <div class="font-bold text-slate-800 text-sm">{{ $booking->adults }}</div>
                            </div>
                            <div>
                                <span class="text-slate-400 uppercase font-bold text-[10px]">Children</span>
                                <div class="font-bold text-slate-800 text-sm">{{ $booking->children ?? 0 }}</div>
                            </div>
                            <div>
                                <span class="text-slate-400 uppercase font-bold text-[10px]">Duration Type</span>
                                <div class="font-bold text-slate-800 text-sm uppercase">{{ $booking->duration_type ?? 'Nights' }}</div>
                            </div>
                            <div>
                                <span class="text-slate-400 uppercase font-bold text-[10px]">Total Hours</span>
                                <div class="font-bold text-slate-800 text-sm">{{ round($booking->duration_hours ?? ($booking->nights * 24)) }} hrs</div>
                            </div>
                        </div>

                        @if($booking->addons && $booking->addons->count() > 0)
                            <div>
                                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block mb-2">Selected Addons & Packages:</span>
                                <div class="space-y-1.5">
                                    @foreach($booking->addons as $addon)
                                        <div class="flex items-center justify-between text-xs bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                                            <span class="font-semibold text-slate-800">{{ $addon->name }}</span>
                                            <span class="font-mono text-slate-600">Rs. {{ number_format($addon->pivot->subtotal ?? $addon->price) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Special Requests & History -->
                @if($booking->special_requests)
                    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200">
                        <h3 class="text-base font-serif font-bold text-slate-900 mb-3 flex items-center gap-2">
                            <i class="fa-solid fa-clipboard-list text-brand-700"></i> Special Requests & Notes History
                        </h3>
                        <div class="bg-amber-50/70 border border-amber-200/80 rounded-2xl p-4 text-xs text-amber-900 whitespace-pre-line font-mono leading-relaxed">
                            {{ $booking->special_requests }}
                        </div>
                    </div>
                @endif

                <!-- Self-Service Action 1: Add Special Request / Stay Modification -->
                @if(!in_array($booking->booking_status, ['cancelled', 'checked_out']))
                    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200" x-data="{ openRequest: false }">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-base font-serif font-bold text-slate-900 flex items-center gap-2">
                                    <i class="fa-solid fa-pen-to-square text-brand-700"></i> Request Special Arrangements
                                </h3>
                                <p class="text-xs text-slate-500 mt-1">
                                    Need extra pillows, late check-in, temple pooja guidance, or dietary requests?
                                </p>
                            </div>
                            <button type="button" @click="openRequest = !openRequest" class="bg-brand-50 hover:bg-brand-100 text-brand-800 font-bold px-4 py-2 rounded-xl text-xs transition">
                                <span x-show="!openRequest">+ Add Request</span>
                                <span x-show="openRequest">Hide</span>
                            </button>
                        </div>

                        <div x-show="openRequest" x-cloak class="mt-6 pt-6 border-t border-slate-100">
                            <form action="{{ route('booking.track.modify') }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                <input type="hidden" name="phone" value="{{ $booking->guest_phone }}">

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                        Your Request or Message for Front Desk *
                                    </label>
                                    <textarea name="modification_note" rows="3" required placeholder="e.g. We will arrive around 6:00 PM; please ensure hot water is ready and arrange an extra pillow."
                                              class="w-full border border-slate-300 rounded-xl p-3 text-xs focus:ring-2 focus:ring-brand-700 focus:outline-none"></textarea>
                                </div>

                                <div class="flex items-center justify-end gap-3">
                                    <button type="button" @click="openRequest = false" class="text-xs text-slate-500 hover:underline px-3 py-2">
                                        Cancel
                                    </button>
                                    <button type="submit" class="bg-brand-800 hover:bg-brand-900 text-white font-bold px-5 py-2 rounded-xl text-xs transition shadow-xs">
                                        Submit Request to Reception
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif

                <!-- Self-Service Action 2: Cancel Reservation -->
                @if(in_array($booking->booking_status, ['pending', 'confirmed']))
                    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-rose-200/80" x-data="{ openCancel: false }">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-base font-serif font-bold text-rose-900 flex items-center gap-2">
                                    <i class="fa-solid fa-triangle-exclamation text-rose-600"></i> Cancel Reservation
                                </h3>
                                <p class="text-xs text-slate-500 mt-1">
                                    Unable to make it? You can cancel your booking directly online.
                                </p>
                            </div>
                            <button type="button" @click="openCancel = !openCancel" class="bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold px-4 py-2 rounded-xl text-xs transition border border-rose-200">
                                <span x-show="!openCancel">Cancel Stay</span>
                                <span x-show="openCancel">Close</span>
                            </button>
                        </div>

                        <div x-show="openCancel" x-cloak class="mt-6 pt-6 border-t border-rose-100">
                            <form action="{{ route('booking.track.cancel') }}" method="POST" class="space-y-4" onsubmit="return confirm('Are you sure you want to cancel your reservation at Sanda Guest House? This will release your room slot.');">
                                @csrf
                                <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                <input type="hidden" name="phone" value="{{ $booking->guest_phone }}">

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                        Reason for Cancellation *
                                    </label>
                                    <select name="cancellation_reason" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-xs bg-white focus:ring-2 focus:ring-rose-500 focus:outline-none">
                                        <option value="">-- Please select a reason --</option>
                                        <option value="Change of travel dates or itinerary">Change of travel dates or itinerary</option>
                                        <option value="Personal emergency or health reason">Personal emergency or health reason</option>
                                        <option value="Found alternative accommodation">Found alternative accommodation</option>
                                        <option value="Booked by mistake">Booked by mistake</option>
                                        <option value="Pilgrimage postponed">Pilgrimage postponed</option>
                                        <option value="Other reason">Other reason</option>
                                    </select>
                                </div>

                                <div class="bg-amber-50 p-3 rounded-xl border border-amber-200 text-[11px] text-amber-800">
                                    <i class="fa-solid fa-circle-info text-amber-600 mr-1"></i>
                                    <strong>Cancellation Policy Notice:</strong> Free cancellation is supported prior to check-in. If an advance was deposited, please contact reception for settlement.
                                </div>

                                <div class="flex items-center justify-end gap-3 pt-2">
                                    <button type="button" @click="openCancel = false" class="text-xs text-slate-500 hover:underline px-3 py-2">
                                        Nevermind, keep my reservation
                                    </button>
                                    <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs transition shadow-sm">
                                        Yes, Confirm Cancellation
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif

            </div>

            <!-- Right Column (Billing Summary & Concierge Actions) -->
            <div class="space-y-6">

                <!-- Billing Summary Card -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200">
                    <h3 class="text-base font-serif font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100 flex items-center justify-between">
                        <span>Payment Summary</span>
                        @php
                            $payBadge = [
                                'pending' => 'bg-amber-100 text-amber-800',
                                'advance_paid' => 'bg-blue-100 text-blue-800',
                                'full_paid' => 'bg-emerald-100 text-emerald-800',
                            ];
                        @endphp
                        <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full {{ $payBadge[$booking->payment_status] ?? 'bg-slate-100 text-slate-700' }}">
                            {{ str_replace('_', ' ', $booking->payment_status) }}
                        </span>
                    </h3>

                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between text-slate-600">
                            <span>Room Subtotal:</span>
                            <span class="font-mono">Rs. {{ number_format($booking->room_subtotal) }}</span>
                        </div>

                        @if($booking->addons_total > 0)
                            <div class="flex justify-between text-slate-600">
                                <span>Add-ons / Safari:</span>
                                <span class="font-mono">Rs. {{ number_format($booking->addons_total) }}</span>
                            </div>
                        @endif

                        <div class="flex justify-between font-bold text-slate-900 pt-2 border-t border-slate-100 text-sm">
                            <span>Total Amount:</span>
                            <span class="font-serif font-bold">Rs. {{ number_format($booking->total_amount) }}</span>
                        </div>

                        <div class="flex justify-between text-emerald-700 font-semibold pt-1">
                            <span>Advance Paid:</span>
                            <span class="font-mono">Rs. {{ number_format($booking->advance_paid) }}</span>
                        </div>

                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 mt-4">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Payable at Check-in</span>
                            <div class="text-xl font-serif font-bold {{ $booking->balance_due > 0 ? 'text-rose-700' : 'text-emerald-700' }} mt-1">
                                Rs. {{ number_format($booking->balance_due) }}
                            </div>
                            <span class="text-[10px] text-slate-400 block mt-0.5">Payment Method: {{ ucfirst($booking->payment_method) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Concierge & Direct Assistance Card -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200 space-y-4">
                    <h3 class="text-base font-serif font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-headset text-gold-500"></i> Front Desk Assistance
                    </h3>
                    <p class="text-xs text-slate-500">
                        Our resort reception team is available 24/7 to assist with directions, parking, or check-in queries.
                    </p>

                    <div class="space-y-2.5 pt-2">
                        <!-- WhatsApp Direct -->
                        <a href="https://wa.me/94779876543?text={{ urlencode('Hello Sanda Guest House, I am inquiring regarding my Reservation ' . $booking->booking_code . ' (' . $booking->guest_name . ')') }}" 
                           target="_blank" 
                           class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-4 rounded-xl text-xs flex items-center justify-center gap-2 transition shadow-xs">
                            <i class="fa-brands fa-whatsapp text-sm"></i> WhatsApp Concierge
                        </a>

                        <!-- Direct Hotline Call -->
                        <a href="tel:+94779876543" 
                           class="w-full bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold py-2.5 px-4 rounded-xl text-xs flex items-center justify-center gap-2 transition">
                            <i class="fa-solid fa-phone text-xs text-slate-600"></i> Call: 077 987 6543
                        </a>

                        <!-- Print / Save Voucher -->
                        <button type="button" onclick="window.print()" 
                                class="w-full border border-slate-300 hover:bg-slate-50 text-slate-700 font-bold py-2.5 px-4 rounded-xl text-xs flex items-center justify-center gap-2 transition">
                            <i class="fa-solid fa-print text-xs"></i> Print Booking Voucher
                        </button>

                        <!-- Look up Another -->
                        <a href="{{ route('booking.track') }}" 
                           class="w-full text-center text-xs font-semibold text-slate-400 hover:text-brand-800 block pt-2">
                            Find Another Reservation &rarr;
                        </a>
                    </div>
                </div>

                <!-- Location & Landmarks Card -->
                <div class="bg-brand-900 rounded-3xl p-6 text-white text-xs space-y-2">
                    <span class="text-gold-400 font-bold uppercase tracking-wider text-[10px] block">Location & Direction</span>
                    <strong class="text-white block font-serif text-sm">Sanda Guest House</strong>
                    <p class="text-slate-300 leading-relaxed">
                        Near Sella Temple Road, Kataragama, Sri Lanka.<br>
                        24/7 Secure Guest Parking Available.
                    </p>
                    <a href="https://maps.google.com" target="_blank" class="inline-flex items-center gap-1 text-gold-400 font-bold hover:underline pt-2">
                        <i class="fa-solid fa-location-dot"></i> Open in Google Maps &rarr;
                    </a>
                </div>

            </div>
        </div>

    </div>
</section>
@endsection
