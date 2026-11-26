@extends('admin.layouts.app')

@section('title', 'Guest Profile: ' . $customer->name . ' - Sanda Guest House')
@section('page_title', 'Customer CRM & Stay History')

@section('content')
<div class="space-y-6">

    <!-- Back & Breadcrumb Navigation -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.customers.index') }}" class="text-xs font-semibold text-slate-500 hover:text-brand-800 flex items-center gap-1.5 transition">
            <i class="fa-solid fa-arrow-left"></i> Back to Guest Directory
        </a>

        <!-- Fast Booking CTA -->
        <a href="{{ route('admin.bookings.create', [
            'guest_name' => $customer->name,
            'guest_phone' => $customer->phone,
            'guest_email' => $customer->email,
            'guest_nic_passport' => $customer->nic_passport,
            'guest_address' => $customer->address,
        ]) }}" class="bg-brand-700 hover:bg-brand-800 text-white font-bold text-xs px-4 py-2 rounded-xl transition flex items-center gap-1.5 shadow-sm">
            <i class="fa-solid fa-calendar-plus text-gold-400"></i> Book New Stay for {{ strtok($customer->name, ' ') }}
        </a>
    </div>

    <!-- Blacklist Alert Banner (If Blacklisted) -->
    @if($customer->is_blacklisted)
        <div class="bg-rose-900 border-2 border-rose-500 text-white p-5 rounded-3xl shadow-lg flex items-start gap-4">
            <div class="w-10 h-10 rounded-2xl bg-rose-800 text-rose-200 flex items-center justify-center text-xl flex-shrink-0 mt-0.5">
                <i class="fa-solid fa-ban"></i>
            </div>
            <div class="flex-grow">
                <div class="flex items-center gap-2">
                    <span class="bg-rose-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">MANAGEMENT BLACKLIST ACTIVE</span>
                    <span class="text-xs text-rose-200">Guest is blocked from making online and walk-in reservations</span>
                </div>
                <p class="text-sm font-semibold text-rose-100 mt-1">
                    Blacklist Reason: <span class="text-white font-normal">{{ $customer->blacklist_reason ?? 'Flagged by hotel administration.' }}</span>
                </p>
            </div>
            <form action="{{ route('admin.customers.toggle-blacklist', $customer) }}" method="POST" onsubmit="return confirm('Remove this guest from the blacklist?');">
                @csrf
                <input type="hidden" name="is_blacklisted" value="0">
                <button type="submit" class="bg-white text-rose-900 hover:bg-rose-100 font-bold px-4 py-2 rounded-xl text-xs shadow transition">
                    Remove Blacklist
                </button>
            </form>
        </div>
    @endif

    <!-- Profile Header Card (Deep Forest Luxury Style) -->
    <div class="bg-brand-900 text-white p-6 sm:p-8 rounded-3xl shadow-md border border-brand-800 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 opacity-10 text-9xl text-gold-400">
            <i class="fa-solid fa-user-shield"></i>
        </div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-start gap-4">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-2xl font-serif font-bold uppercase shadow-md flex-shrink-0 {{ $customer->is_blacklisted ? 'bg-rose-700 text-white' : ($customer->is_vip ? 'bg-gradient-to-br from-gold-400 to-amber-600 text-slate-950' : 'bg-emerald-800 text-white border border-emerald-600/40') }}">
                    {{ substr($customer->name, 0, 2) }}
                </div>
                <div class="space-y-1">
                    <div class="flex flex-wrap items-center gap-2">
                        <h1 class="text-2xl font-serif font-bold text-white">{{ $customer->name }}</h1>
                        @if($customer->is_vip)
                            <span class="bg-gradient-to-r from-gold-400 to-amber-500 text-slate-950 font-bold text-[10px] px-2.5 py-0.5 rounded-full uppercase tracking-wider shadow-xs">
                                <i class="fa-solid fa-crown mr-1"></i> VIP Guest
                            </span>
                        @endif
                        @if($customer->bookings_count >= 2)
                            <span class="bg-emerald-400/20 text-emerald-300 border border-emerald-400/30 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">
                                Repeat Guest ({{ $customer->bookings_count }} Stays)
                            </span>
                        @endif
                    </div>
                    
                    <!-- Contact Details Bar -->
                    <div class="flex flex-wrap items-center gap-3 text-xs text-slate-300 pt-1 font-mono">
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-phone text-gold-400"></i> {{ $customer->phone }}
                        </span>
                        @if($customer->email)
                            <span>&bull;</span>
                            <span class="flex items-center gap-1.5 font-sans">
                                <i class="fa-solid fa-envelope text-gold-400"></i> {{ $customer->email }}
                            </span>
                        @endif
                        @if($customer->nic_passport)
                            <span>&bull;</span>
                            <span class="flex items-center gap-1.5">
                                <i class="fa-solid fa-id-card text-gold-400"></i> NIC: {{ $customer->nic_passport }}
                            </span>
                        @endif
                        @if($customer->city)
                            <span>&bull;</span>
                            <span class="flex items-center gap-1.5 font-sans">
                                <i class="fa-solid fa-location-dot text-gold-400"></i> {{ $customer->city }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Action Badges -->
            <div class="flex flex-wrap items-center gap-2.5">
                <!-- Toggle VIP -->
                <form action="{{ route('admin.customers.toggle-vip', $customer) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 border {{ $customer->is_vip ? 'bg-amber-400/20 text-amber-300 border-amber-400/50 hover:bg-amber-400/30' : 'bg-white/10 text-white border-white/20 hover:bg-white/20' }}">
                        <i class="fa-solid fa-crown {{ $customer->is_vip ? 'text-gold-400' : 'text-slate-400' }}"></i>
                        <span>{{ $customer->is_vip ? 'Remove VIP' : 'Mark as VIP' }}</span>
                    </button>
                </form>

                <!-- WhatsApp Quick Chat -->
                @php
                    $cleanPhone = preg_replace('/[^0-9]/', '', $customer->phone);
                    if (str_starts_with($cleanPhone, '0')) {
                        $cleanPhone = '94' . substr($cleanPhone, 1);
                    }
                @endphp
                <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode('Hello ' . $customer->name . ', greetings from Sanda Guest House Kataragama!') }}" target="_blank" 
                   class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-3.5 py-2 rounded-xl transition flex items-center gap-1.5 shadow">
                    <i class="fa-brands fa-whatsapp text-sm"></i> WhatsApp
                </a>

                <!-- Phone Call -->
                <a href="tel:{{ $customer->phone }}" class="bg-white/10 hover:bg-white/20 text-white font-bold text-xs px-3.5 py-2 rounded-xl transition flex items-center gap-1.5 border border-white/20">
                    <i class="fa-solid fa-phone"></i> Call
                </a>
            </div>
        </div>
    </div>

    <!-- Stay Metrics Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3.5">
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Total Bookings</span>
            <strong class="text-2xl font-serif font-bold text-slate-900 block mt-1">{{ $stats['total_bookings'] }}</strong>
            <span class="text-[10px] text-slate-400">All recorded stays</span>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider block">Completed Stays</span>
            <strong class="text-2xl font-serif font-bold text-emerald-700 block mt-1">{{ $stats['completed_stays'] }}</strong>
            <span class="text-[10px] text-slate-400">Checked-in & Checked-out</span>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider block">Upcoming / Confirmed</span>
            <strong class="text-2xl font-serif font-bold text-blue-700 block mt-1">{{ $stats['confirmed_stays'] }}</strong>
            <span class="text-[10px] text-slate-400">Future reservations</span>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Lifetime Spend</span>
            <strong class="text-xl font-serif font-bold text-brand-900 block mt-1">Rs. {{ number_format($stats['total_spent']) }}</strong>
            <span class="text-[10px] text-slate-400">Total revenue generated</span>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Advance Paid</span>
            <strong class="text-xl font-serif font-bold text-emerald-600 block mt-1">Rs. {{ number_format($stats['total_advance']) }}</strong>
            <span class="text-[10px] text-slate-400">Across all visits</span>
        </div>
    </div>

    <!-- 2-Column Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Left Column: Complete Booking History Timeline (8 cols) -->
        <div class="lg:col-span-8 space-y-4">
            <div class="flex items-center justify-between pb-1">
                <div>
                    <h3 class="text-base font-serif font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-clock-rotate-left text-brand-700"></i> Reservation History Timeline
                    </h3>
                    <p class="text-xs text-slate-500">Chronological history of all room stays and requests made by {{ $customer->name }}.</p>
                </div>
                <span class="text-xs font-mono bg-slate-100 text-slate-700 font-bold px-2.5 py-1 rounded-xl">
                    {{ $customer->bookings->count() }} Record(s)
                </span>
            </div>

            <div class="space-y-3.5">
                @forelse($customer->bookings as $booking)
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs hover:border-brand-500/40 transition">
                        <div class="flex flex-wrap items-start justify-between gap-3 border-b border-slate-100 pb-3">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="font-mono font-bold text-brand-900 text-sm">{{ $booking->booking_code }}</span>
                                    @php
                                        $badgeStyles = [
                                            'pending' => 'bg-amber-100 text-amber-800 border-amber-300',
                                            'confirmed' => 'bg-blue-100 text-blue-800 border-blue-300',
                                            'checked_in' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                                            'checked_out' => 'bg-purple-100 text-purple-800 border-purple-300',
                                            'cancelled' => 'bg-rose-100 text-rose-800 border-rose-300',
                                        ];
                                    @endphp
                                    <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full border {{ $badgeStyles[$booking->booking_status] ?? 'bg-slate-100 text-slate-700' }}">
                                        {{ $booking->booking_status_label ?? ucfirst($booking->booking_status) }}
                                    </span>
                                </div>
                                <div class="text-xs text-slate-500 mt-1">
                                    Booked on {{ $booking->created_at->format('M d, Y h:i A') }}
                                </div>
                            </div>

                            <div class="text-right">
                                <strong class="text-sm font-bold font-mono text-slate-900 block">Rs. {{ number_format($booking->total_amount) }}</strong>
                                <span class="text-[11px] font-medium {{ $booking->balance_due > 0 ? 'text-rose-600' : 'text-emerald-600' }}">
                                    {{ $booking->balance_due > 0 ? 'Due: Rs. ' . number_format($booking->balance_due) : 'Fully Paid' }}
                                </span>
                            </div>
                        </div>

                        <!-- Stay Details -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 py-3 text-xs">
                            <div>
                                <span class="text-[10px] text-slate-400 uppercase tracking-wider block font-semibold">Room & Wing</span>
                                <strong class="text-slate-800 block mt-0.5">{{ $booking->roomType?->name ?? 'Standard' }}</strong>
                                @if($booking->room)
                                    <span class="text-[11px] font-bold text-emerald-700 block">Room {{ $booking->room->room_number }} ({{ $booking->room->floor_wing }})</span>
                                @endif
                            </div>
                            <div>
                                <span class="text-[10px] text-slate-400 uppercase tracking-wider block font-semibold">Stay Time Window</span>
                                <span class="text-slate-800 font-mono block mt-0.5">
                                    {{ $booking->check_in_at ? $booking->check_in_at->format('M d, Y h:i A') : $booking->check_in_date }}
                                </span>
                                <span class="text-slate-500 font-mono block text-[11px]">
                                    to {{ $booking->check_out_at ? $booking->check_out_at->format('M d, Y h:i A') : $booking->check_out_date }}
                                </span>
                            </div>
                            <div>
                                <span class="text-[10px] text-slate-400 uppercase tracking-wider block font-semibold">Duration & Guests</span>
                                <span class="text-slate-800 font-semibold block mt-0.5">{{ $booking->duration_display }}</span>
                                <span class="text-slate-500 block text-[11px]">{{ $booking->adults }} Adults, {{ $booking->children }} Children</span>
                            </div>
                        </div>

                        <!-- Addons / Special Requests if present -->
                        @if($booking->addons->count() > 0 || $booking->special_requests)
                            <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 text-xs space-y-1 mb-2">
                                @if($booking->addons->count() > 0)
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        <span class="font-bold text-slate-600 text-[11px]">Add-ons:</span>
                                        @foreach($booking->addons as $ba)
                                            <span class="bg-white border border-slate-200 px-2 py-0.5 rounded text-[11px] text-slate-700">
                                                {{ $ba->addon?->name ?? 'Addon' }} &times; {{ $ba->quantity }} (Rs. {{ number_format($ba->subtotal) }})
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                                @if($booking->special_requests)
                                    <div class="text-[11px] text-slate-600">
                                        <strong class="text-slate-700">Requests:</strong> {{ $booking->special_requests }}
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Actions Bar -->
                        <div class="flex items-center justify-between pt-2 border-t border-slate-100 text-xs">
                            <span class="text-slate-400 text-[11px]">Payment: <strong class="text-slate-700 uppercase font-mono">{{ $booking->payment_method }}</strong></span>
                            <div class="flex items-center gap-2">
                                <button type="button" @click="$dispatch('open-invoice-modal', { bookingId: {{ $booking->id }} })" 
                                        class="text-xs bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-3 py-1.5 rounded-lg transition flex items-center gap-1">
                                    <i class="fa-solid fa-receipt text-slate-500"></i> Invoice
                                </button>
                                <a href="{{ route('admin.bookings.show', $booking) }}" 
                                   class="text-xs bg-brand-50 hover:bg-brand-100 text-brand-800 font-bold px-3 py-1.5 rounded-lg transition flex items-center gap-1">
                                    <span>Manage Booking</span>
                                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white p-8 rounded-2xl border border-slate-200 text-center text-slate-400">
                        <i class="fa-solid fa-calendar-xmark text-3xl mb-2"></i>
                        <p class="text-xs">No booking records found for this customer.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right Column: Notes, VIP Preferences & Blacklist (4 cols) -->
        <div class="lg:col-span-4 space-y-5">

            <!-- 1. Blacklist Control Card -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-3">
                <div class="flex items-center gap-2 border-b border-slate-100 pb-3">
                    <div class="w-8 h-8 rounded-xl bg-rose-50 text-rose-700 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-user-slash"></i>
                    </div>
                    <div>
                        <h4 class="font-serif font-bold text-slate-900 text-sm">Blacklist & Security Flag</h4>
                        <p class="text-[11px] text-slate-500">Prevent future bookings from this guest</p>
                    </div>
                </div>

                <form action="{{ route('admin.customers.toggle-blacklist', $customer) }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Blacklist Status</label>
                        <select name="is_blacklisted" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-xs font-semibold focus:ring-2 focus:ring-brand-700 focus:outline-none"
                                :class="{{ $customer->is_blacklisted ? "'text-rose-700 bg-rose-50 font-bold'" : "'text-slate-800'" }}">
                            <option value="0" {{ !$customer->is_blacklisted ? 'selected' : '' }}>🟢 Active / Allowed Guest (Normal)</option>
                            <option value="1" {{ $customer->is_blacklisted ? 'selected' : '' }}>🔴 Blacklisted / Blocked from Booking</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Reason for Blacklisting</label>
                        <textarea name="blacklist_reason" rows="2" placeholder="e.g. Property damage, non-payment, disruptive behavior..."
                                  class="w-full border border-slate-300 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-brand-700 focus:outline-none">{{ old('blacklist_reason', $customer->blacklist_reason) }}</textarea>
                        <span class="text-[10px] text-slate-400 block mt-0.5">Visible only to hotel staff and managers.</span>
                    </div>

                    <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-bold py-2 rounded-xl text-xs transition shadow-sm">
                        Update Blacklist Status
                    </button>
                </form>
            </div>

            <!-- 2. VIP Preferences & Special Notes -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-3">
                <div class="flex items-center gap-2 border-b border-slate-100 pb-3">
                    <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-crown"></i>
                    </div>
                    <div>
                        <h4 class="font-serif font-bold text-slate-900 text-sm">Guest Preferences & Notes</h4>
                        <p class="text-[11px] text-slate-500">Record customized stay requirements</p>
                    </div>
                </div>

                <form action="{{ route('admin.customers.update', $customer) }}" method="POST" class="space-y-3">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="name" value="{{ $customer->name }}">
                    <input type="hidden" name="phone" value="{{ $customer->phone }}">
                    <input type="hidden" name="email" value="{{ $customer->email }}">
                    <input type="hidden" name="nic_passport" value="{{ $customer->nic_passport }}">
                    <input type="hidden" name="city" value="{{ $customer->city }}">
                    <input type="hidden" name="address" value="{{ $customer->address }}">

                    <!-- VIP Checkbox -->
                    <div class="flex items-center gap-2 bg-amber-50/60 p-2.5 rounded-xl border border-amber-200/60">
                        <input type="checkbox" name="is_vip" id="is_vip" value="1" {{ $customer->is_vip ? 'checked' : '' }}
                               class="w-4 h-4 text-amber-600 rounded focus:ring-amber-500">
                        <label for="is_vip" class="text-xs font-bold text-amber-900 cursor-pointer">
                            Mark as VIP Guest (Gold Priority)
                        </label>
                    </div>

                    <!-- Special Preferences -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            <i class="fa-solid fa-heart text-amber-500 mr-1"></i> Special Stay Preferences
                        </label>
                        <textarea name="special_preferences" rows="3" placeholder="e.g. Prefers ground floor A/C, vegetarian breakfast, quiet corner room, pilgrim family..."
                                  class="w-full border border-slate-300 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-brand-700 focus:outline-none">{{ old('special_preferences', $customer->special_preferences) }}</textarea>
                    </div>

                    <!-- Internal Admin Notes -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            <i class="fa-solid fa-note-sticky text-brand-700 mr-1"></i> Internal Staff Notes
                        </label>
                        <textarea name="notes" rows="3" placeholder="Internal remarks about customer interactions, payment reliability, etc."
                                  class="w-full border border-slate-300 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-brand-700 focus:outline-none">{{ old('notes', $customer->notes) }}</textarea>
                    </div>

                    <button type="submit" class="w-full bg-brand-800 hover:bg-brand-900 text-white font-bold py-2 rounded-xl text-xs transition shadow-sm">
                        Save Preferences & Notes
                    </button>
                </form>
            </div>

            <!-- 3. Edit Contact Information Modal/Card -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-3" x-data="{ editing: false }">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center text-sm">
                            <i class="fa-solid fa-address-card"></i>
                        </div>
                        <h4 class="font-serif font-bold text-slate-900 text-sm">Contact Information</h4>
                    </div>
                    <button type="button" @click="editing = !editing" class="text-xs text-brand-700 hover:underline font-semibold" x-text="editing ? 'Cancel' : 'Edit'"></button>
                </div>

                <div x-show="!editing" class="space-y-2 text-xs">
                    <div class="flex justify-between py-1 border-b border-slate-50">
                        <span class="text-slate-400">Full Name:</span>
                        <strong class="text-slate-800">{{ $customer->name }}</strong>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-50">
                        <span class="text-slate-400">Phone:</span>
                        <strong class="text-slate-800 font-mono">{{ $customer->phone }}</strong>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-50">
                        <span class="text-slate-400">Email:</span>
                        <span class="text-slate-800">{{ $customer->email ?? 'Not provided' }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-50">
                        <span class="text-slate-400">NIC / Passport:</span>
                        <strong class="text-slate-800 font-mono">{{ $customer->nic_passport ?? 'Not provided' }}</strong>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-50">
                        <span class="text-slate-400">City / District:</span>
                        <span class="text-slate-800">{{ $customer->city ?? 'Not provided' }}</span>
                    </div>
                    <div class="pt-1">
                        <span class="text-slate-400 block text-[11px]">Address:</span>
                        <span class="text-slate-700">{{ $customer->address ?? 'Not provided' }}</span>
                    </div>
                </div>

                <!-- Edit Form -->
                <form x-show="editing" x-cloak action="{{ route('admin.customers.update', $customer) }}" method="POST" class="space-y-3">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="special_preferences" value="{{ $customer->special_preferences }}">
                    <input type="hidden" name="notes" value="{{ $customer->notes }}">
                    <input type="hidden" name="is_vip" value="{{ $customer->is_vip ? 1 : 0 }}">

                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-0.5">Full Name *</label>
                        <input type="text" name="name" value="{{ old('name', $customer->name) }}" required class="w-full border border-slate-300 rounded-xl px-3 py-1.5 text-xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-0.5">Phone Number *</label>
                        <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" required class="w-full border border-slate-300 rounded-xl px-3 py-1.5 text-xs font-mono">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-0.5">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $customer->email) }}" class="w-full border border-slate-300 rounded-xl px-3 py-1.5 text-xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-0.5">NIC / Passport</label>
                        <input type="text" name="nic_passport" value="{{ old('nic_passport', $customer->nic_passport) }}" class="w-full border border-slate-300 rounded-xl px-3 py-1.5 text-xs font-mono">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-0.5">City / District</label>
                        <input type="text" name="city" value="{{ old('city', $customer->city) }}" class="w-full border border-slate-300 rounded-xl px-3 py-1.5 text-xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-0.5">Address</label>
                        <textarea name="address" rows="2" class="w-full border border-slate-300 rounded-xl p-2 text-xs">{{ old('address', $customer->address) }}</textarea>
                    </div>

                    <div class="flex items-center gap-2 pt-1">
                        <button type="submit" class="bg-brand-700 hover:bg-brand-800 text-white font-bold px-4 py-2 rounded-xl text-xs transition">
                            Save Changes
                        </button>
                        <button type="button" @click="editing = false" class="text-xs text-slate-500 hover:text-slate-800 px-2 py-2">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>

            <!-- Danger Zone: Delete Record -->
            <div class="p-4 rounded-2xl border border-rose-200 bg-rose-50/50 flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-rose-800 block">Delete Customer Profile</span>
                    <span class="text-[10px] text-rose-600 block">Past booking records will remain preserved.</span>
                </div>
                <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" onsubmit="return confirm('Delete this customer profile? Booking history records will remain.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-xs font-bold text-rose-700 hover:text-rose-900 border border-rose-300 hover:bg-rose-100 px-3 py-1.5 rounded-xl transition">
                        Delete
                    </button>
                </form>
            </div>

        </div>
    </div>

</div>
@endsection
