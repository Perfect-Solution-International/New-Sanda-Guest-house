@extends('layouts.app')

@section('title', 'Reserve Your Stay - Nivi Sanda Family Holiday Resort')

@section('content')
<section class="py-12 bg-brand-900 text-white text-center">
    <div class="max-w-4xl mx-auto px-4">
        <span class="text-gold-400 font-bold text-xs uppercase tracking-widest block mb-2">Instant Online Booking</span>
        <h1 class="text-3xl sm:text-4xl font-serif font-bold text-white mb-2">Reserve Your Stay at Nivi Sanda</h1>
        <p class="text-slate-200 text-sm max-w-xl mx-auto font-light">
            Guaranteed best rates directly from our resort desk in Sella Katharagama.
        </p>
    </div>
</section>

<section class="py-16 bg-stone-50" x-data="bookingApp()">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <form action="{{ route('booking.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <!-- Left: Booking Form Details -->
                <div class="lg:col-span-8 space-y-8">
                    <!-- Step 1: Dates & Room Category -->
                    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-slate-200 space-y-6">
                        <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                            <span class="w-8 h-8 rounded-full bg-brand-700 text-white font-bold flex items-center justify-center text-sm">1</span>
                            <h3 class="text-xl font-serif font-bold text-brand-900">Dates & Room Selection</h3>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Check-in Date *</label>
                                <input type="date" name="check_in_date" x-model="checkIn" @change="recalculateNights()" min="{{ date('Y-m-d') }}" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Check-out Date *</label>
                                <input type="date" name="check_out_date" x-model="checkOut" @change="recalculateNights()" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Adult Guests *</label>
                                <select name="adults" x-model.number="adults" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm bg-white focus:ring-2 focus:ring-brand-500">
                                    <option value="1">1 Adult</option>
                                    <option value="2">2 Adults</option>
                                    <option value="3">3 Adults</option>
                                    <option value="4">4 Adults</option>
                                    <option value="6">6 Adults</option>
                                    <option value="8">8+ Adults (Group)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Children (Under 10)</label>
                                <select name="children" x-model.number="children" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm bg-white focus:ring-2 focus:ring-brand-500">
                                    <option value="0">0 Children</option>
                                    <option value="1">1 Child</option>
                                    <option value="2">2 Children</option>
                                    <option value="3">3+ Children</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Select Room / Cabana *</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($roomTypes as $rt)
                                    <label class="relative flex flex-col justify-between p-4 rounded-2xl border-2 cursor-pointer transition"
                                           :class="selectedRoomId == {{ $rt->id }} ? 'border-brand-700 bg-brand-50/60 shadow-sm' : 'border-slate-200 hover:border-slate-300 bg-white'">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <input type="radio" name="room_type_id" value="{{ $rt->id }}" x-model="selectedRoomId" @change="updateRoomRate({{ $rt->id }}, {{ $rt->base_price_per_night }})" class="text-brand-700 focus:ring-brand-500 mr-2" {{ (old('room_type_id', $selectedRoomTypeId) == $rt->id || $loop->first && !$selectedRoomTypeId) ? 'checked' : '' }}>
                                                <strong class="text-slate-900 font-serif text-base">{{ $rt->name }}</strong>
                                            </div>
                                        </div>
                                        <p class="text-xs text-slate-500 mt-2 line-clamp-2">{{ $rt->short_description }}</p>
                                        <div class="mt-3 pt-2 border-t border-slate-200/60 flex items-center justify-between text-xs">
                                            <span class="text-slate-500">{{ $rt->bed_type }}</span>
                                            <span class="font-bold text-brand-900 text-sm">Rs. {{ number_format($rt->base_price_per_night) }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Safari & Addon Packages -->
                    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-slate-200 space-y-4">
                        <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                            <span class="w-8 h-8 rounded-full bg-brand-700 text-white font-bold flex items-center justify-center text-sm">2</span>
                            <div>
                                <h3 class="text-xl font-serif font-bold text-brand-900">Experiences & Tour Add-ons (Optional)</h3>
                                <p class="text-xs text-slate-500">Add exciting excursions and meals directly to your booking.</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            @foreach($addons as $addon)
                                <label class="flex items-center justify-between p-4 rounded-2xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition">
                                    <div class="flex items-start gap-3">
                                        <input type="checkbox" name="addons[]" value="{{ $addon->id }}" 
                                               @change="toggleAddon({{ $addon->id }}, {{ $addon->price }}, '{{ $addon->price_type }}', $event.target.checked)"
                                               class="w-5 h-5 mt-0.5 rounded text-brand-700 focus:ring-brand-500 border-slate-300">
                                        <div>
                                            <h4 class="font-bold text-sm text-slate-900">{{ $addon->name }}</h4>
                                            <p class="text-xs text-slate-500 max-w-lg mt-0.5">{{ $addon->description }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right pl-4">
                                        <span class="font-bold text-brand-900 text-sm block">Rs. {{ number_format($addon->price) }}</span>
                                        <span class="text-[10px] text-slate-400 block uppercase">
                                            {{ str_replace('_', ' ', $addon->price_type) }}
                                        </span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Step 3: Guest Contact & Details -->
                    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-slate-200 space-y-6">
                        <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                            <span class="w-8 h-8 rounded-full bg-brand-700 text-white font-bold flex items-center justify-center text-sm">3</span>
                            <h3 class="text-xl font-serif font-bold text-brand-900">Guest Information</h3>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Primary Guest Full Name *</label>
                                <input type="text" name="guest_name" required value="{{ old('guest_name') }}" placeholder="e.g. Ruwan Perera" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Mobile Phone / WhatsApp *</label>
                                <input type="text" name="guest_phone" required value="{{ old('guest_phone') }}" placeholder="+94 7X XXX XXXX" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Email Address *</label>
                                <input type="email" name="guest_email" required value="{{ old('guest_email') }}" placeholder="name@example.com" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">NIC or Passport Number</label>
                                <input type="text" name="guest_nic_passport" value="{{ old('guest_nic_passport') }}" placeholder="National Identity Card No" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">City / Residential Address</label>
                            <input type="text" name="guest_address" value="{{ old('guest_address') }}" placeholder="City / Town (e.g. Colombo, Kandy, Galle)" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Special Requests or Arrival Notes</label>
                            <textarea name="special_requests" rows="2" placeholder="Late check-in, dietary preferences, extra pillows, safari timing..." class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500">{{ old('special_requests') }}</textarea>
                        </div>
                    </div>

                    <!-- Step 4: Payment Option -->
                    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-slate-200 space-y-4">
                        <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                            <span class="w-8 h-8 rounded-full bg-brand-700 text-white font-bold flex items-center justify-center text-sm">4</span>
                            <h3 class="text-xl font-serif font-bold text-brand-900">Payment Preference</h3>
                        </div>

                        <div class="space-y-3">
                            <label class="flex items-center p-4 rounded-2xl border-2 border-brand-700 bg-brand-50/40 cursor-pointer">
                                <input type="radio" name="payment_method" value="bank_transfer" checked class="text-brand-700 focus:ring-brand-500 mr-3">
                                <div>
                                    <strong class="text-slate-900 text-sm block">Bank Transfer (Advance Deposit)</strong>
                                    <p class="text-xs text-slate-500">Direct deposit to Resort BOC Account to lock your dates.</p>
                                </div>
                            </label>

                            <label class="flex items-center p-4 rounded-2xl border border-slate-200 hover:bg-slate-50 cursor-pointer">
                                <input type="radio" name="payment_method" value="cash" class="text-brand-700 focus:ring-brand-500 mr-3">
                                <div>
                                    <strong class="text-slate-900 text-sm block">Cash on Arrival</strong>
                                    <p class="text-xs text-slate-500">Pay at the resort front desk upon check-in.</p>
                                </div>
                            </label>

                            <label class="flex items-center p-4 rounded-2xl border border-slate-200 hover:bg-slate-50 cursor-pointer">
                                <input type="radio" name="payment_method" value="card_at_desk" class="text-brand-700 focus:ring-brand-500 mr-3">
                                <div>
                                    <strong class="text-slate-900 text-sm block">Visa / Master Card at Front Desk</strong>
                                    <p class="text-xs text-slate-500">POS machine swipe available at reception.</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Right: Sticky Live Price Summary -->
                <div class="lg:col-span-4 sticky top-28">
                    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-lg border border-slate-200 space-y-6">
                        <h4 class="font-serif font-bold text-xl text-brand-900 border-b border-slate-100 pb-3">Booking Summary</h4>

                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between text-slate-600">
                                <span>Duration:</span>
                                <span class="font-bold text-slate-900" x-text="nights + ' Night(s)'"></span>
                            </div>
                            <div class="flex justify-between text-slate-600">
                                <span>Room Rate:</span>
                                <span class="font-bold text-slate-900" x-text="'Rs. ' + roomRate.toLocaleString()"></span>
                            </div>
                            <div class="flex justify-between text-slate-600">
                                <span>Room Subtotal:</span>
                                <span class="font-bold text-slate-900" x-text="'Rs. ' + (roomRate * nights).toLocaleString()"></span>
                            </div>
                            <div class="flex justify-between text-slate-600" x-show="addonsTotal > 0">
                                <span>Add-ons Total:</span>
                                <span class="font-bold text-emerald-700" x-text="'Rs. ' + addonsTotal.toLocaleString()"></span>
                            </div>

                            <div class="pt-4 border-t border-slate-200 flex justify-between items-end">
                                <div>
                                    <span class="text-xs uppercase tracking-wider font-bold text-slate-500 block">Total Est. Amount</span>
                                    <span class="text-2xl font-serif font-bold text-brand-900" x-text="'Rs. ' + ( (roomRate * nights) + addonsTotal ).toLocaleString()"></span>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-brand-700 hover:bg-brand-800 text-white font-bold py-3.5 rounded-xl shadow-md hover:shadow-lg transition text-sm flex items-center justify-center gap-2">
                            <i class="fa-solid fa-lock text-gold-400"></i> Confirm Reservation
                        </button>

                        <div class="text-[11px] text-slate-400 text-center leading-relaxed">
                            By confirming, you agree to Nivi Sanda Resort's reservation & check-in guidelines. Confirmation reference will be generated immediately.
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
function bookingApp() {
    return {
        checkIn: '{{ $checkIn }}',
        checkOut: '{{ $checkOut }}',
        adults: {{ $adults }},
        children: {{ $children }},
        selectedRoomId: {{ $selectedRoomTypeId ?? ($roomTypes->first()->id ?? 1) }},
        roomRate: {{ $roomTypes->where('id', $selectedRoomTypeId)->first()->base_price_per_night ?? ($roomTypes->first()->base_price_per_night ?? 20000) }},
        nights: 1,
        addonsTotal: 0,
        selectedAddonsMap: {},

        init() {
            this.recalculateNights();
        },

        recalculateNights() {
            if (this.checkIn && this.checkOut) {
                const start = new Date(this.checkIn);
                const end = new Date(this.checkOut);
                const diffTime = Math.abs(end - start);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                this.nights = diffDays > 0 ? diffDays : 1;
                this.recalculateAddons();
            }
        },

        updateRoomRate(id, rate) {
            this.selectedRoomId = id;
            this.roomRate = rate;
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
            for (const [id, item] of Object.entries(this.selectedAddonsMap)) {
                let qty = 1;
                if (item.type === 'per_night') {
                    qty = this.nights;
                } else if (item.type === 'per_person') {
                    qty = this.adults + this.children;
                }
                sum += item.price * qty;
            }
            this.addonsTotal = sum;
        }
    }
}
</script>
@endsection
