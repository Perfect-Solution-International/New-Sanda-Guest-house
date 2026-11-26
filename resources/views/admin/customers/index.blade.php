@extends('admin.layouts.app')

@section('title', 'Guest CRM & Customer History - Sanda Guest House')
@section('page_title', 'Guest CRM & Customer History')

@section('content')
<div class="space-y-6">

    <!-- Top Action & Overview Bar -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-serif font-bold text-slate-900">Guest Directory & CRM</h2>
            <p class="text-xs text-slate-500">Track repeat guests, lifetime booking history, VIP preferences, and management blacklist protection.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.bookings.create') }}" class="bg-brand-700 hover:bg-brand-800 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition flex items-center gap-2 shadow-md">
                <i class="fa-solid fa-plus text-gold-400"></i> New Reservation
            </a>
        </div>
    </div>

    <!-- Metric Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <!-- Total Guests -->
        <a href="{{ route('admin.customers.index') }}" 
           class="p-4 rounded-2xl border transition {{ !request('filter') || request('filter') === 'all' ? 'bg-brand-900 text-white border-brand-800 shadow-md ring-2 ring-gold-400/40' : 'bg-white hover:bg-slate-50 text-slate-800 border-slate-200 shadow-xs' }}">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider block opacity-75">Total Guests</span>
                <i class="fa-solid fa-users text-gold-400 text-sm"></i>
            </div>
            <span class="text-2xl font-serif font-bold block mt-1">{{ $stats['total'] ?? 0 }}</span>
            <span class="text-[10px] opacity-75">Registered in system</span>
        </a>

        <!-- Repeat Guests -->
        <a href="{{ route('admin.customers.index', ['filter' => 'repeat']) }}" 
           class="p-4 rounded-2xl border transition {{ request('filter') === 'repeat' ? 'bg-emerald-800 text-white border-emerald-900 shadow-md ring-2 ring-emerald-400/50' : 'bg-white hover:bg-slate-50 text-slate-800 border-slate-200 shadow-xs' }}">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider block opacity-75">Repeat Guests</span>
                <i class="fa-solid fa-repeat text-emerald-400 text-sm"></i>
            </div>
            <span class="text-2xl font-serif font-bold block mt-1 text-emerald-600 {{ request('filter') === 'repeat' ? 'text-white' : '' }}">{{ $stats['repeat'] ?? 0 }}</span>
            <span class="text-[10px] opacity-75">Stayed 2+ times</span>
        </a>

        <!-- VIP Guests -->
        <a href="{{ route('admin.customers.index', ['filter' => 'vip']) }}" 
           class="p-4 rounded-2xl border transition {{ request('filter') === 'vip' ? 'bg-amber-600 text-white border-amber-700 shadow-md ring-2 ring-gold-400/50' : 'bg-white hover:bg-slate-50 text-slate-800 border-slate-200 shadow-xs' }}">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider block opacity-75">VIP Guests</span>
                <i class="fa-solid fa-crown text-amber-300 text-sm"></i>
            </div>
            <span class="text-2xl font-serif font-bold block mt-1 text-amber-500 {{ request('filter') === 'vip' ? 'text-white' : '' }}">{{ $stats['vip'] ?? 0 }}</span>
            <span class="text-[10px] opacity-75">Special priority status</span>
        </a>

        <!-- Blacklisted Guests -->
        <a href="{{ route('admin.customers.index', ['filter' => 'blacklisted']) }}" 
           class="p-4 rounded-2xl border transition {{ request('filter') === 'blacklisted' ? 'bg-rose-700 text-white border-rose-800 shadow-md ring-2 ring-rose-400/50' : 'bg-white hover:bg-slate-50 text-slate-800 border-slate-200 shadow-xs' }}">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider block opacity-75">Blacklisted</span>
                <i class="fa-solid fa-ban text-rose-300 text-sm"></i>
            </div>
            <span class="text-2xl font-serif font-bold block mt-1 text-rose-600 {{ request('filter') === 'blacklisted' ? 'text-white' : '' }}">{{ $stats['blacklisted'] ?? 0 }}</span>
            <span class="text-[10px] opacity-75">Blocked from booking</span>
        </a>
    </div>

    <!-- Search & Filters Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
        <form method="GET" action="{{ route('admin.customers.index') }}" class="flex flex-col sm:flex-row gap-3 items-center justify-between">
            <input type="hidden" name="filter" value="{{ request('filter', 'all') }}">

            <div class="relative w-full sm:w-96">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search guest name, phone, email, NIC..." 
                       class="w-full pl-9 pr-4 py-2 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-brand-700 focus:outline-none">
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <select name="sort" onchange="this.form.submit()" class="border border-slate-300 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest Registered</option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name (A-Z)</option>
                    <option value="bookings" {{ request('sort') == 'bookings' ? 'selected' : '' }}>Most Stays</option>
                </select>

                <button type="submit" class="bg-brand-800 hover:bg-brand-900 text-white font-bold text-xs px-4 py-2 rounded-xl transition">
                    Search
                </button>

                @if(request('search') || request('filter') || request('sort'))
                    <a href="{{ route('admin.customers.index') }}" class="text-xs text-slate-500 hover:text-slate-800 px-2 py-2">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Customers Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                        <th class="py-3.5 px-4">Guest Information</th>
                        <th class="py-3.5 px-4">Category & Status</th>
                        <th class="py-3.5 px-4">Stays & Visits</th>
                        <th class="py-3.5 px-4">Lifetime Spend</th>
                        <th class="py-3.5 px-4">Preferences / Notes</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($customers as $customer)
                        <tr class="hover:bg-slate-50/80 transition {{ $customer->is_blacklisted ? 'bg-rose-50/40' : '' }}">
                            
                            <!-- Guest Info -->
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-xs uppercase shadow-xs flex-shrink-0 {{ $customer->is_blacklisted ? 'bg-rose-100 text-rose-700' : ($customer->is_vip ? 'bg-amber-100 text-amber-800' : 'bg-brand-50 text-brand-800') }}">
                                        {{ substr($customer->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-1.5">
                                            <a href="{{ route('admin.customers.show', $customer) }}" class="font-bold text-slate-900 hover:text-brand-700 hover:underline">
                                                {{ $customer->name }}
                                            </a>
                                            @if($customer->is_vip)
                                                <span class="text-[9px] bg-amber-100 text-amber-800 font-bold px-1.5 py-0.5 rounded-full border border-amber-300">
                                                    <i class="fa-solid fa-crown text-[8px]"></i> VIP
                                                </span>
                                            @endif
                                            @if($customer->is_blacklisted)
                                                <span class="text-[9px] bg-rose-100 text-rose-700 font-bold px-1.5 py-0.5 rounded-full border border-rose-300">
                                                    <i class="fa-solid fa-ban text-[8px]"></i> BLOCKED
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-slate-500 font-mono text-[11px] mt-0.5 flex items-center gap-2">
                                            <span><i class="fa-solid fa-phone text-slate-400 text-[10px]"></i> {{ $customer->phone }}</span>
                                            @if($customer->nic_passport)
                                                <span>&bull; NIC: {{ $customer->nic_passport }}</span>
                                            @endif
                                        </div>
                                        @if($customer->email)
                                            <div class="text-[10px] text-slate-400">{{ $customer->email }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Badges -->
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <div class="space-y-1">
                                    @if($customer->bookings_count >= 2)
                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 px-2 py-0.5 rounded-full">
                                            <i class="fa-solid fa-repeat text-[9px]"></i> Repeat Guest ({{ $customer->bookings_count }}x)
                                        </span>
                                    @else
                                        <span class="inline-block text-[10px] text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">
                                            First-time Guest
                                        </span>
                                    @endif

                                    @if($customer->is_blacklisted)
                                        <div class="text-[10px] text-rose-600 font-semibold truncate max-w-[150px]" title="{{ $customer->blacklist_reason }}">
                                            Reason: {{ $customer->blacklist_reason ?? 'Management Flag' }}
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Stays & Visits -->
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <strong class="text-slate-900 font-mono text-sm">{{ $customer->bookings_count }}</strong>
                                <span class="text-slate-500 text-[11px]">Stay(s)</span>
                            </td>

                            <!-- Lifetime Spend -->
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <strong class="text-brand-900 font-mono font-bold text-xs">
                                    Rs. {{ number_format($customer->total_spent) }}
                                </strong>
                            </td>

                            <!-- Preferences & Notes -->
                            <td class="py-3.5 px-4">
                                @if($customer->special_preferences)
                                    <div class="text-[11px] text-amber-900 bg-amber-50/80 border border-amber-200/80 px-2 py-1 rounded-lg line-clamp-2 max-w-xs">
                                        <i class="fa-solid fa-star text-amber-500 text-[9px] mr-1"></i>{{ $customer->special_preferences }}
                                    </div>
                                @elseif($customer->notes)
                                    <div class="text-[11px] text-slate-600 line-clamp-2 max-w-xs italic">
                                        {{ $customer->notes }}
                                    </div>
                                @else
                                    <span class="text-slate-400 text-[11px]">No special notes</span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    <!-- WhatsApp -->
                                    @php
                                        $cleanPhone = preg_replace('/[^0-9]/', '', $customer->phone);
                                        if (str_starts_with($cleanPhone, '0')) {
                                            $cleanPhone = '94' . substr($cleanPhone, 1);
                                        }
                                    @endphp
                                    <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" 
                                       title="WhatsApp Guest" 
                                       class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 flex items-center justify-center transition border border-emerald-200">
                                        <i class="fa-brands fa-whatsapp"></i>
                                    </a>

                                    <!-- Phone Call -->
                                    <a href="tel:{{ $customer->phone }}" 
                                       title="Call Guest" 
                                       class="w-7 h-7 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 flex items-center justify-center transition">
                                        <i class="fa-solid fa-phone text-[10px]"></i>
                                    </a>

                                    <!-- View Profile & History -->
                                    <a href="{{ route('admin.customers.show', $customer) }}" 
                                       class="bg-brand-700 hover:bg-brand-800 text-white font-bold px-3 py-1.5 rounded-lg text-xs flex items-center gap-1 shadow-xs transition">
                                        <span>Profile & History</span>
                                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <div class="w-12 h-12 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-3 text-lg">
                                    <i class="fa-solid fa-user-slash"></i>
                                </div>
                                <strong class="text-slate-600 block text-sm">No Customers Found</strong>
                                <span class="text-xs">Try adjusting your search criteria or filter.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($customers->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $customers->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
