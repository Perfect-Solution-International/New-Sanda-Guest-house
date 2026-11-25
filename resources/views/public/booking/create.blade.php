@extends('layouts.app')

@section('title', 'Room Booking & Live Availability - Sanda Guest House')

@section('content')
<!-- Hero Section (Deep Forest Green & Warm Gold) -->
<section class="relative py-14 bg-gradient-to-b from-[#041710] via-[#072419] to-[#0a2f21] text-white overflow-hidden border-b border-emerald-900/40">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#d4af37_1px,transparent_1px)] [background-size:24px_24px]"></div>
    <div class="relative max-w-5xl mx-auto px-4 text-center">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-950/80 border border-gold-500/30 text-gold-400 text-xs font-semibold tracking-wider uppercase mb-3 shadow-inner">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
            <span>Live Availability & Instant Booking</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-serif font-bold text-white mb-3 tracking-tight">
            Reserve Your Stay at <span class="text-transparent bg-clip-text bg-gradient-to-r from-gold-300 via-gold-400 to-amber-200">Sanda</span>
        </h1>
        <p class="text-emerald-100/80 text-sm sm:text-base max-w-2xl mx-auto font-light leading-relaxed">
            Real-time room availability, guaranteed best rates, flexible hours or overnight stays, and instant WhatsApp confirmation.
        </p>
    </div>
</section>

<!-- Main Booking App with Dark Cards Theme -->
<section class="py-12 bg-[#04150e] min-h-screen text-slate-100" x-data="liveBookingApp()" x-init="initApp()">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <!-- Live Availability Metric Counter Cards (Dark Cards with Gold Accents) -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <!-- Total Rooms -->
            <div class="bg-[#0b241b]/90 border border-emerald-500/20 rounded-2xl p-5 shadow-lg relative overflow-hidden backdrop-blur-md">
                <div class="absolute -right-3 -bottom-3 text-emerald-800/20 text-6xl pointer-events-none">
                    <i class="fa-solid fa-hotel"></i>
                </div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-400/80 block mb-1">Total Rooms</span>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-serif font-bold text-white" x-text="totalRooms"></span>
                    <span class="text-xs text-emerald-300/70">Units</span>
                </div>
                <div class="text-[11px] text-emerald-200/50 mt-1">Across all categories</div>
            </div>

            <!-- Available Rooms -->
            <div class="bg-[#0b241b]/90 border border-gold-500/30 rounded-2xl p-5 shadow-lg relative overflow-hidden backdrop-blur-md">
                <div class="absolute -right-3 -bottom-3 text-gold-500/10 text-6xl pointer-events-none">
                    <i class="fa-solid fa-door-open"></i>
                </div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-gold-400 block mb-1">Available Rooms</span>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-serif font-bold text-emerald-400" x-text="availableRooms"></span>
                    <span class="text-xs text-gold-300/80 font-medium">Free Now</span>
                </div>
                <div class="text-[11px] text-emerald-300/60 mt-1 flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    <span>Ready for your dates</span>
                </div>
            </div>

            <!-- Booked Rooms -->
            <div class="bg-[#0b241b]/90 border border-emerald-500/20 rounded-2xl p-5 shadow-lg relative overflow-hidden backdrop-blur-md">
                <div class="absolute -right-3 -bottom-3 text-rose-500/10 text-6xl pointer-events-none">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Booked Units</span>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-serif font-bold text-rose-300" x-text="bookedRooms"></span>
                    <span class="text-xs text-slate-400">Reserved</span>
                </div>
                <div class="text-[11px] text-slate-400/70 mt-1">For selected time range</div>
            </div>

            <!-- Stay Duration -->
            <div class="bg-[#0b241b]/90 border border-gold-500/25 rounded-2xl p-5 shadow-lg relative overflow-hidden backdrop-blur-md">
                <div class="absolute -right-3 -bottom-3 text-gold-500/10 text-6xl pointer-events-none">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-gold-400 block mb-1">Calculated Duration</span>
                <div class="flex items-baseline gap-1">
                    <span class="text-xl sm:text-2xl font-serif font-bold text-gold-300 truncate" x-text="durationDisplay"></span>
                </div>
                <div class="text-[11px] text-emerald-200/60 mt-1">Auto-calculated duration</div>
            </div>
        </div>

        @if(session('error'))
            <div class="bg-rose-950/80 border border-rose-500/50 text-rose-200 px-5 py-4 rounded-2xl text-xs sm:text-sm flex items-start gap-3 shadow-lg">
                <i class="fa-solid fa-circle-exclamation text-rose-400 text-lg mt-0.5"></i>
                <div>
                    <strong class="font-bold block">Booking Notice:</strong>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <form action="{{ route('booking.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                <!-- Left Column: Booking Form Steps -->
                <div class="lg:col-span-8 space-y-6">

                    <!-- Step 1: Check-in / Check-out Date & Exact Time -->
                    <div class="bg-[#082017]/90 border border-emerald-500/25 rounded-3xl p-6 sm:p-8 shadow-2xl backdrop-blur-md space-y-6">
                        <div class="flex items-center justify-between border-b border-emerald-500/20 pb-4">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 rounded-full bg-gradient-to-br from-gold-400 to-amber-600 text-slate-950 font-bold flex items-center justify-center text-sm shadow-md">1</span>
                                <h3 class="text-lg sm:text-xl font-serif font-bold text-white">Select Dates & Exact Time Range</h3>
                            </div>
                            <span class="text-xs text-gold-400 font-semibold flex items-center gap-1.5">
                                <i class="fa-solid fa-shield-halved text-emerald-400"></i> No Double Booking
                            </span>
                        </div>

                        <!-- Date & Time Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <!-- Check-in -->
                            <div class="bg-[#051710] p-4 rounded-2xl border border-emerald-500/20 space-y-2">
                                <label class="block text-xs font-bold text-gold-400 uppercase tracking-wider">
                                    <i class="fa-regular fa-calendar-check mr-1"></i> Check-in Date *
                                </label>
                                <input type="date" name="check_in_date" x-model="checkIn" @change="onDateTimeChanged()" min="{{ date('Y-m-d') }}" required
                                       class="w-full bg-[#09261b] border border-emerald-500/30 rounded-xl px-4 py-2.5 text-sm text-white focus:ring-2 focus:ring-gold-400 focus:outline-none">

                                <div class="pt-2">
                                    <label class="block text-[11px] font-semibold text-emerald-300 uppercase tracking-wider mb-1">
                                        <i class="fa-regular fa-clock mr-1"></i> Check-in Time *
                                    </label>
                                    <input type="time" name="check_in_time" x-model="checkInTime" @change="onDateTimeChanged()" required
                                           class="w-full bg-[#09261b] border border-emerald-500/30 rounded-xl px-4 py-2 text-sm text-white focus:ring-2 focus:ring-gold-400 focus:outline-none">
                                    <span class="text-[10px] text-slate-400 block mt-1">Standard check-in starts at 02:00 PM</span>
                                </div>
                            </div>

                            <!-- Check-out -->
                            <div class="bg-[#051710] p-4 rounded-2xl border border-emerald-500/20 space-y-2">
                                <label class="block text-xs font-bold text-gold-400 uppercase tracking-wider">
                                    <i class="fa-regular fa-calendar-xmark mr-1"></i> Check-out Date *
                                </label>
                                <input type="date" name="check_out_date" x-model="checkOut" @change="onDateTimeChanged()" min="{{ date('Y-m-d') }}" required
                                       class="w-full bg-[#09261b] border border-emerald-500/30 rounded-xl px-4 py-2.5 text-sm text-white focus:ring-2 focus:ring-gold-400 focus:outline-none">

                                <div class="pt-2">
                                    <label class="block text-[11px] font-semibold text-emerald-300 uppercase tracking-wider mb-1">
                                        <i class="fa-regular fa-clock mr-1"></i> Check-out Time *
                                    </label>
                                    <input type="time" name="check_out_time" x-model="checkOutTime" @change="onDateTimeChanged()" required
                                           class="w-full bg-[#09261b] border border-emerald-500/30 rounded-xl px-4 py-2 text-sm text-white focus:ring-2 focus:ring-gold-400 focus:outline-none">
                                    <span class="text-[10px] text-slate-400 block mt-1">Standard check-out is 11:00 AM</span>
                                </div>
                            </div>
                        </div>

                        <!-- Guests Count -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                            <div>
                                <label class="block text-xs font-bold text-emerald-300 uppercase tracking-wider mb-1">Adult Guests *</label>
                                <select name="adults" x-model.number="adults" class="w-full bg-[#051710] border border-emerald-500/30 rounded-xl px-4 py-2.5 text-sm text-white focus:ring-2 focus:ring-gold-400 focus:outline-none">
                                    <option value="1">1 Adult</option>
                                    <option value="2">2 Adults</option>
                                    <option value="3">3 Adults</option>
                                    <option value="4">4 Adults</option>
                                    <option value="6">6 Adults</option>
                                    <option value="8">8+ Adults (Group)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-emerald-300 uppercase tracking-wider mb-1">Children (Under 10)</label>
                                <select name="children" x-model.number="children" class="w-full bg-[#051710] border border-emerald-500/30 rounded-xl px-4 py-2.5 text-sm text-white focus:ring-2 focus:ring-gold-400 focus:outline-none">
                                    <option value="0">0 Children</option>
                                    <option value="1">1 Child</option>
                                    <option value="2">2 Children</option>
                                    <option value="3">3+ Children</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Choose Room with Live Availability Status Cards -->
                    <div class="bg-[#082017]/90 border border-emerald-500/25 rounded-3xl p-6 sm:p-8 shadow-2xl backdrop-blur-md space-y-6">
                        <div class="flex flex-wrap items-center justify-between border-b border-emerald-500/20 pb-4 gap-2">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 rounded-full bg-gradient-to-br from-gold-400 to-amber-600 text-slate-950 font-bold flex items-center justify-center text-sm shadow-md">2</span>
                                <div>
                                    <h3 class="text-lg sm:text-xl font-serif font-bold text-white">Choose Your Room Category</h3>
                                    <p class="text-xs text-emerald-200/60">Live availability is calculated for your exact date & hours.</p>
                                </div>
                            </div>
                            <span class="text-[11px] text-emerald-300 font-mono bg-emerald-950 px-2.5 py-1 rounded-md border border-emerald-800">
                                <i class="fa-solid fa-arrows-rotate mr-1 text-gold-400 animate-spin" x-show="loadingAvailability"></i>
                                Live Overlap Protection Active
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($roomTypes as $rt)
                                <div class="relative flex flex-col justify-between p-5 rounded-2xl border-2 transition duration-200 cursor-pointer"
                                     :class="selectedRoomId == {{ $rt->id }} ? 'border-gold-400 bg-[#0d2e22] shadow-xl ring-1 ring-gold-400/50' : 'border-emerald-500/20 hover:border-emerald-400/40 bg-[#051811]'"
                                     @click="selectRoomType({{ $rt->id }}, {{ $rt->base_price_per_night }})">

                                    <div>
                                        <div class="flex items-start justify-between gap-2 mb-2">
                                            <div class="flex items-center gap-2">
                                                <input type="radio" name="room_type_id" value="{{ $rt->id }}" x-model="selectedRoomId"
                                                       :disabled="!isRoomTypeAvailable({{ $rt->id }})"
                                                       class="text-gold-500 focus:ring-gold-400 h-4 w-4">
                                                <strong class="text-white font-serif text-base">{{ $rt->name }}</strong>
                                            </div>

                                            <!-- Live Availability Badge -->
                                            <template x-if="getRoomAvailability({{ $rt->id }})">
                                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full border"
                                                      :class="getRoomAvailability({{ $rt->id }}).available_rooms > 0 
                                                              ? 'bg-emerald-950 text-emerald-300 border-emerald-500/40' 
                                                              : 'bg-rose-950 text-rose-300 border-rose-500/40'">
                                                    <span x-text="getRoomAvailability({{ $rt->id }}).available_rooms > 0 ? getRoomAvailability({{ $rt->id }}).available_rooms + ' Free' : 'Fully Booked'"></span>
                                                </span>
                                            </template>
                                        </div>

                                        <p class="text-xs text-emerald-100/70 line-clamp-2 mt-1">{{ $rt->short_description }}</p>

                                        <div class="flex items-center gap-4 text-xs text-emerald-300/80 mt-3">
                                            <span><i class="fa-solid fa-bed text-gold-400 mr-1"></i> {{ $rt->bed_type }}</span>
                                            <span><i class="fa-solid fa-users text-gold-400 mr-1"></i> Max {{ $rt->max_adults }} Adults</span>
                                        </div>
                                    </div>

                                    <div class="mt-4 pt-3 border-t border-emerald-500/20 flex items-center justify-between">
                                        <div>
                                            <span class="text-[10px] uppercase tracking-wider text-emerald-400/80 block">Nightly Rate</span>
                                            <span class="text-lg font-serif font-bold text-gold-300">Rs. {{ number_format($rt->base_price_per_night) }}</span>
                                        </div>
                                        <div>
                                            <span class="text-[11px] font-bold px-3 py-1 rounded-xl transition"
                                                  :class="selectedRoomId == {{ $rt->id }} ? 'bg-gold-500 text-slate-950' : 'bg-[#09261b] text-emerald-300'">
                                                <span x-text="selectedRoomId == {{ $rt->id }} ? 'Selected' : 'Select'"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Step 3: Tour & Food Addons (Optional) -->
                    @if(isset($addons) && $addons->count() > 0)
                        <div class="bg-[#082017]/90 border border-emerald-500/25 rounded-3xl p-6 sm:p-8 shadow-2xl backdrop-blur-md space-y-4">
                            <div class="flex items-center gap-3 border-b border-emerald-500/20 pb-4">
                                <span class="w-8 h-8 rounded-full bg-gradient-to-br from-gold-400 to-amber-600 text-slate-950 font-bold flex items-center justify-center text-sm shadow-md">3</span>
                                <div>
                                    <h3 class="text-lg sm:text-xl font-serif font-bold text-white">Experience & Safari Add-ons (Optional)</h3>
                                    <p class="text-xs text-emerald-200/60">Enhance your Kataragama stay with tours and meals.</p>
                                </div>
                            </div>

                            <div class="space-y-3">
                                @foreach($addons as $addon)
                                    <label class="flex items-center justify-between p-4 rounded-2xl border border-emerald-500/20 bg-[#051811] hover:bg-[#09261b] cursor-pointer transition">
                                        <div class="flex items-start gap-3">
                                            <input type="checkbox" name="addons[]" value="{{ $addon->id }}" 
                                                   @change="toggleAddon({{ $addon->id }}, {{ $addon->price }}, '{{ $addon->price_type }}', $event.target.checked)"
                                                   class="w-5 h-5 mt-0.5 rounded text-gold-500 focus:ring-gold-400 border-emerald-600 bg-[#051710]">
                                            <div>
                                                <h4 class="font-bold text-sm text-white">{{ $addon->name }}</h4>
                                                <p class="text-xs text-emerald-100/60 max-w-lg mt-0.5">{{ $addon->description }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right pl-4">
                                            <span class="font-bold text-gold-300 text-sm block">Rs. {{ number_format($addon->price) }}</span>
                                            <span class="text-[10px] text-emerald-400/80 block uppercase">{{ str_replace('_', ' ', $addon->price_type) }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Step 4: Customer Name & Phone / WhatsApp -->
                    <div class="bg-[#082017]/90 border border-emerald-500/25 rounded-3xl p-6 sm:p-8 shadow-2xl backdrop-blur-md space-y-6">
                        <div class="flex items-center gap-3 border-b border-emerald-500/20 pb-4">
                            <span class="w-8 h-8 rounded-full bg-gradient-to-br from-gold-400 to-amber-600 text-slate-950 font-bold flex items-center justify-center text-sm shadow-md">4</span>
                            <div>
                                <h3 class="text-lg sm:text-xl font-serif font-bold text-white">Guest Information</h3>
                                <p class="text-xs text-emerald-200/60">Your booking confirmation will be sent directly via WhatsApp / SMS.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gold-400 uppercase tracking-wider mb-1">
                                    <i class="fa-solid fa-user mr-1 text-emerald-400"></i> Primary Guest Full Name *
                                </label>
                                <input type="text" name="guest_name" required value="{{ old('guest_name') }}" placeholder="e.g. Ruwan Perera"
                                       class="w-full bg-[#051710] border border-emerald-500/30 rounded-xl px-4 py-2.5 text-sm text-white focus:ring-2 focus:ring-gold-400 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gold-400 uppercase tracking-wider mb-1">
                                    <i class="fa-brands fa-whatsapp mr-1 text-emerald-400 text-sm"></i> Mobile Phone / WhatsApp Number *
                                </label>
                                <input type="text" name="guest_phone" required value="{{ old('guest_phone') }}" placeholder="+94 7X XXX XXXX"
                                       class="w-full bg-[#051710] border border-emerald-500/30 rounded-xl px-4 py-2.5 text-sm text-white focus:ring-2 focus:ring-gold-400 focus:outline-none">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-emerald-300 uppercase tracking-wider mb-1">
                                    <i class="fa-regular fa-envelope mr-1 text-gold-400"></i> Email Address (Optional)
                                </label>
                                <input type="email" name="guest_email" value="{{ old('guest_email') }}" placeholder="yourname@example.com"
                                       class="w-full bg-[#051710] border border-emerald-500/30 rounded-xl px-4 py-2.5 text-sm text-white focus:ring-2 focus:ring-gold-400 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-emerald-300 uppercase tracking-wider mb-1">
                                    <i class="fa-solid fa-id-card mr-1 text-gold-400"></i> NIC / Passport (Optional)
                                </label>
                                <input type="text" name="guest_nic_passport" value="{{ old('guest_nic_passport') }}" placeholder="National ID / Passport No"
                                       class="w-full bg-[#051710] border border-emerald-500/30 rounded-xl px-4 py-2.5 text-sm text-white focus:ring-2 focus:ring-gold-400 focus:outline-none">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-emerald-300 uppercase tracking-wider mb-1">Special Requests or Arrival Notes</label>
                            <textarea name="special_requests" rows="2" placeholder="Late arrival timing, extra bed requirement, pooja timing in Kataragama..."
                                      class="w-full bg-[#051710] border border-emerald-500/30 rounded-xl px-4 py-2 text-sm text-white focus:ring-2 focus:ring-gold-400 focus:outline-none">{{ old('special_requests') }}</textarea>
                        </div>
                    </div>

                    <!-- Step 5: Payment Preference -->
                    <div class="bg-[#082017]/90 border border-emerald-500/25 rounded-3xl p-6 sm:p-8 shadow-2xl backdrop-blur-md space-y-4">
                        <div class="flex items-center gap-3 border-b border-emerald-500/20 pb-4">
                            <span class="w-8 h-8 rounded-full bg-gradient-to-br from-gold-400 to-amber-600 text-slate-950 font-bold flex items-center justify-center text-sm shadow-md">5</span>
                            <h3 class="text-lg sm:text-xl font-serif font-bold text-white">Payment Preference</h3>
                        </div>

                        <div class="space-y-3">
                            <label class="flex items-center p-4 rounded-2xl border border-gold-400/50 bg-[#0d2e22] cursor-pointer">
                                <input type="radio" name="payment_method" value="bank_transfer" checked class="text-gold-500 focus:ring-gold-400 mr-3">
                                <div>
                                    <strong class="text-white text-sm block">Bank Transfer (Advance Deposit)</strong>
                                    <p class="text-xs text-emerald-200/60">Lock your room dates by transferring advance to Sanda Guest House BOC account.</p>
                                </div>
                            </label>

                            <label class="flex items-center p-4 rounded-2xl border border-emerald-500/20 bg-[#051811] hover:bg-[#09261b] cursor-pointer">
                                <input type="radio" name="payment_method" value="cash" class="text-gold-500 focus:ring-gold-400 mr-3">
                                <div>
                                    <strong class="text-white text-sm block">Cash on Arrival</strong>
                                    <p class="text-xs text-emerald-200/60">Pay full cash at front desk during check-in.</p>
                                </div>
                            </label>

                            <label class="flex items-center p-4 rounded-2xl border border-emerald-500/20 bg-[#051811] hover:bg-[#09261b] cursor-pointer">
                                <input type="radio" name="payment_method" value="card_at_desk" class="text-gold-500 focus:ring-gold-400 mr-3">
                                <div>
                                    <strong class="text-white text-sm block">Credit / Debit Card at Desk</strong>
                                    <p class="text-xs text-emerald-200/60">Visa / Mastercard swipe machine available at resort reception.</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Sticky Summary & Confirmation Card (Dark Card with Gold Accents) -->
                <div class="lg:col-span-4 sticky top-28">
                    <div class="bg-gradient-to-b from-[#0b271d] to-[#071c14] p-6 sm:p-8 rounded-3xl shadow-2xl border border-gold-500/30 space-y-6 backdrop-blur-md">
                        <div class="border-b border-emerald-500/20 pb-4">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-gold-400 block mb-1">Reservation Overview</span>
                            <h4 class="font-serif font-bold text-2xl text-white">Booking Summary</h4>
                        </div>

                        <div class="space-y-3.5 text-xs sm:text-sm">
                            <div class="flex justify-between text-emerald-200/80">
                                <span>Check-in:</span>
                                <span class="font-bold text-white" x-text="checkIn + ' @ ' + formatTime(checkInTime)"></span>
                            </div>
                            <div class="flex justify-between text-emerald-200/80">
                                <span>Check-out:</span>
                                <span class="font-bold text-white" x-text="checkOut + ' @ ' + formatTime(checkOutTime)"></span>
                            </div>
                            <div class="flex justify-between text-emerald-200/80">
                                <span>Duration:</span>
                                <span class="font-bold text-gold-300" x-text="durationDisplay"></span>
                            </div>
                            <div class="flex justify-between text-emerald-200/80">
                                <span>Guests:</span>
                                <span class="font-bold text-white" x-text="adults + ' Adults, ' + children + ' Children'"></span>
                            </div>
                            <div class="flex justify-between text-emerald-200/80 pt-2 border-t border-emerald-500/15">
                                <span>Room Rate:</span>
                                <span class="font-bold text-white" x-text="'Rs. ' + roomRate.toLocaleString()"></span>
                            </div>
                            <div class="flex justify-between text-emerald-200/80">
                                <span>Room Subtotal:</span>
                                <span class="font-bold text-white" x-text="'Rs. ' + calculateRoomSubtotal().toLocaleString()"></span>
                            </div>
                            <div class="flex justify-between text-emerald-200/80" x-show="addonsTotal > 0">
                                <span>Add-ons Total:</span>
                                <span class="font-bold text-emerald-300" x-text="'Rs. ' + addonsTotal.toLocaleString()"></span>
                            </div>

                            <div class="pt-4 border-t border-gold-500/30 flex justify-between items-end">
                                <div>
                                    <span class="text-[10px] uppercase tracking-wider font-bold text-gold-400 block">Total Est. Amount</span>
                                    <span class="text-2xl sm:text-3xl font-serif font-bold text-transparent bg-clip-text bg-gradient-to-r from-gold-300 via-gold-400 to-amber-200"
                                          x-text="'Rs. ' + (calculateRoomSubtotal() + addonsTotal).toLocaleString()"></span>
                                </div>
                            </div>
                        </div>

                        <button type="submit"
                                :disabled="availableRooms <= 0 || !isCurrentRoomAvailable()"
                                class="w-full bg-gradient-to-r from-gold-500 via-amber-500 to-gold-600 hover:from-gold-400 hover:to-amber-500 text-slate-950 font-bold py-4 rounded-xl shadow-lg hover:shadow-gold-500/20 transition text-sm flex items-center justify-center gap-2 uppercase tracking-wider disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fa-solid fa-lock text-slate-950"></i>
                            <span x-text="availableRooms > 0 && isCurrentRoomAvailable() ? 'Confirm Reservation' : 'Room Fully Booked'"></span>
                        </button>

                        <div class="text-[11px] text-emerald-200/50 text-center leading-relaxed">
                            <i class="fa-brands fa-whatsapp text-emerald-400 mr-1"></i> Instant reference code generated & locked in system.
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Alpine.js Live Availability & Price Logic -->
<script>
function liveBookingApp() {
    return {
        checkIn: '{{ $checkIn }}',
        checkInTime: '{{ $checkInTime }}',
        checkOut: '{{ $checkOut }}',
        checkOutTime: '{{ $checkOutTime }}',
        adults: {{ $adults }},
        children: {{ $children }},
        selectedRoomId: {{ $selectedRoomTypeId ?? ($roomTypes->first()->id ?? 1) }},
        roomRate: {{ $roomTypes->where('id', $selectedRoomTypeId)->first()->base_price_per_night ?? ($roomTypes->first()->base_price_per_night ?? 5500) }},
        nights: 1,
        durationHours: 21,
        durationDisplay: '1 Night (21 Hours)',
        totalRooms: {{ $initialAvailability['total_rooms'] ?? 6 }},
        availableRooms: {{ $initialAvailability['available_rooms'] ?? 6 }},
        bookedRooms: {{ $initialAvailability['booked_rooms'] ?? 0 }},
        roomTypeAvailability: @json($initialAvailability['room_types'] ?? []),
        addonsTotal: 0,
        selectedAddonsMap: {},
        loadingAvailability: false,
        debounceTimer: null,

        initApp() {
            this.recalculateClientDuration();
            this.fetchLiveAvailability();
        },

        onDateTimeChanged() {
            this.recalculateClientDuration();
            clearTimeout(this.debounceTimer);
            this.debounceTimer = setTimeout(() => {
                this.fetchLiveAvailability();
            }, 300);
        },

        recalculateClientDuration() {
            if (this.checkIn && this.checkOut) {
                const inStr = `${this.checkIn}T${this.checkInTime || '14:00'}`;
                const outStr = `${this.checkOut}T${this.checkOutTime || '11:00'}`;
                const start = new Date(inStr);
                const end = new Date(outStr);

                if (end > start) {
                    const diffMs = end - start;
                    const hours = Math.round(diffMs / (1000 * 60 * 60));
                    this.durationHours = hours;

                    const startDay = new Date(this.checkIn);
                    const endDay = new Date(this.checkOut);
                    const dayDiff = Math.round((endDay - startDay) / (1000 * 60 * 60 * 24));

                    if (dayDiff >= 1 && hours >= 12) {
                        this.nights = dayDiff;
                        this.durationDisplay = `${this.nights} Night${this.nights > 1 ? 's' : ''} (${hours} Hours)`;
                    } else {
                        this.nights = 0;
                        this.durationDisplay = `${hours} Hours (Day Use)`;
                    }
                } else {
                    this.durationDisplay = 'Invalid Date/Time Range';
                }
                this.recalculateAddons();
            }
        },

        async fetchLiveAvailability() {
            if (!this.checkIn || !this.checkOut) return;
            this.loadingAvailability = true;

            try {
                const url = new URL('{{ route("api.availability") }}', window.location.origin);
                url.searchParams.append('check_in_date', this.checkIn);
                url.searchParams.append('check_in_time', this.checkInTime || '14:00');
                url.searchParams.append('check_out_date', this.checkOut);
                url.searchParams.append('check_out_time', this.checkOutTime || '11:00');

                const res = await fetch(url.toString());
                const data = await res.json();

                if (data.success && data.data) {
                    this.totalRooms = data.data.total_rooms;
                    this.availableRooms = data.data.available_rooms;
                    this.bookedRooms = data.data.booked_rooms;
                    this.roomTypeAvailability = data.data.room_types;

                    if (data.data.duration) {
                        this.nights = data.data.duration.nights;
                        this.durationHours = data.data.duration.hours;
                        this.durationDisplay = data.data.duration.duration_text;
                    }
                }
            } catch (err) {
                console.error('Failed to fetch availability:', err);
            } finally {
                this.loadingAvailability = false;
            }
        },

        getRoomAvailability(typeId) {
            return this.roomTypeAvailability.find(rt => rt.id == typeId) || null;
        },

        isRoomTypeAvailable(typeId) {
            const rt = this.getRoomAvailability(typeId);
            return rt ? rt.available_rooms > 0 : true;
        },

        isCurrentRoomAvailable() {
            return this.isRoomTypeAvailable(this.selectedRoomId);
        },

        selectRoomType(id, rate) {
            this.selectedRoomId = id;
            this.roomRate = rate;
            this.recalculateAddons();
        },

        calculateRoomSubtotal() {
            if (this.nights >= 1) {
                return this.roomRate * this.nights;
            }
            // Day use stay
            return Math.max(Math.round(this.roomRate * (this.durationHours / 24) * 1.2), Math.round(this.roomRate * 0.6));
        },

        toggleAddon(id, price, type, isChecked) {
            if (isChecked) {
                this.selectedAddonsMap[id] = { price: price, type: type };
            } else {
                delete this.selectedAddonsMap[id];
            }
            this.recalculateAddons();
        },

        recalculateAddons() {
            let sum = 0;
            const nightCount = Math.max(1, this.nights);
            for (const [id, item] of Object.entries(this.selectedAddonsMap)) {
                let qty = 1;
                if (item.type === 'per_night') {
                    qty = nightCount;
                } else if (item.type === 'per_person') {
                    qty = this.adults + this.children;
                }
                sum += item.price * qty;
            }
            this.addonsTotal = sum;
        },

        formatTime(t) {
            if (!t) return '';
            const [h, m] = t.split(':');
            let hour = parseInt(h);
            const ampm = hour >= 12 ? 'PM' : 'AM';
            hour = hour % 12 || 12;
            return `${hour}:${m} ${ampm}`;
        }
    }
}
</script>
@endsection
