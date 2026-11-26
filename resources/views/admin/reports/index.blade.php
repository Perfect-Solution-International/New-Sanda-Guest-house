@extends('admin.layouts.app')

@section('title', 'Financial Reports & Occupancy Analytics - Sanda Guest House')
@section('page_title', 'Business Reports & CSV Exports')

@section('content')
<div class="space-y-6">

    <!-- Top Action & Overview Bar -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-serif font-bold text-slate-900">Financial Reports & Occupancy Analytics</h2>
            <p class="text-xs text-slate-500">
                Period: <strong class="text-slate-800">{{ $startDate->format('M d, Y') }}</strong> to <strong class="text-slate-800">{{ $endDate->format('M d, Y') }}</strong> ({{ $daysCount }} Day{{ $daysCount > 1 ? 's' : '' }})
            </p>
        </div>
        
        <!-- Export & Print Actions -->
        <div class="flex items-center gap-2 flex-wrap" x-data="{ exportOpen: false }">
            <!-- Printable / Save as PDF Button -->
            <a href="{{ route('admin.reports.print', request()->query()) }}" target="_blank" 
               class="bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition flex items-center gap-1.5 shadow-sm">
                <i class="fa-solid fa-print text-gold-400"></i> Print / PDF Report
            </a>

            <!-- CSV Exports Dropdown -->
            <div class="relative">
                <button type="button" @click="exportOpen = !exportOpen" @click.outside="exportOpen = false"
                        class="bg-brand-700 hover:bg-brand-800 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition flex items-center gap-2 shadow-md">
                    <i class="fa-solid fa-file-excel text-emerald-300"></i>
                    <span>Export CSV Datasets</span>
                    <i class="fa-solid fa-chevron-down text-[10px] ml-1"></i>
                </button>

                <div x-show="exportOpen" x-cloak 
                     class="absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-xl border border-slate-200 py-2 z-30 text-xs space-y-1">
                    <span class="text-[10px] uppercase font-bold text-slate-400 px-4 py-1 block">Download Spreadsheet</span>
                    
                    <a href="{{ route('admin.reports.export-bookings', request()->query()) }}" 
                       class="flex items-center gap-2.5 px-4 py-2 hover:bg-slate-50 text-slate-800 font-semibold transition">
                        <i class="fa-solid fa-table text-emerald-600"></i>
                        <div>
                            <div>All Bookings Detailed CSV</div>
                            <div class="text-[10px] text-slate-400 font-normal">Full guest, date, price breakdown</div>
                        </div>
                    </a>

                    <a href="{{ route('admin.reports.export-revenue', request()->query()) }}" 
                       class="flex items-center gap-2.5 px-4 py-2 hover:bg-slate-50 text-slate-800 font-semibold transition">
                        <i class="fa-solid fa-coins text-gold-500"></i>
                        <div>
                            <div>Daily Revenue Summary CSV</div>
                            <div class="text-[10px] text-slate-400 font-normal">Day-by-day cash, advance & dues</div>
                        </div>
                    </a>

                    <a href="{{ route('admin.reports.export-rooms', request()->query()) }}" 
                       class="flex items-center gap-2.5 px-4 py-2 hover:bg-slate-50 text-slate-800 font-semibold transition">
                        <i class="fa-solid fa-door-open text-blue-600"></i>
                        <div>
                            <div>Room Performance & Occupancy CSV</div>
                            <div class="text-[10px] text-slate-400 font-normal">Room-wise nights & income</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Date Range & Filters Filter Card -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-xs space-y-4">
        <!-- Quick Preset Buttons -->
        <div class="flex items-center gap-2 flex-wrap pb-3 border-b border-slate-100">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider mr-1">Period Presets:</span>
            @php
                $presets = [
                    'today' => 'Today',
                    'yesterday' => 'Yesterday',
                    'this_week' => 'This Week',
                    'last_7_days' => 'Last 7 Days',
                    'this_month' => 'This Month',
                    'last_month' => 'Last Month',
                    'this_year' => 'This Year',
                ];
            @endphp
            @foreach($presets as $key => $label)
                <a href="{{ route('admin.reports.index', array_merge(request()->except(['from_date', 'to_date', 'page']), ['period' => $key])) }}"
                   class="text-xs font-semibold px-3 py-1.5 rounded-xl border transition {{ $preset === $key ? 'bg-brand-900 text-gold-400 border-brand-800 font-bold shadow-xs' : 'bg-slate-50 hover:bg-slate-100 text-slate-700 border-slate-200' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <!-- Custom Range & Filters Form -->
        <form method="GET" action="{{ route('admin.reports.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3 items-end text-xs">
            <!-- From Date -->
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1">From Date</label>
                <input type="date" name="from_date" value="{{ request('from_date', $startDate->format('Y-m-d')) }}"
                       class="w-full border border-slate-300 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-brand-700 focus:outline-none">
            </div>

            <!-- To Date -->
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1">To Date</label>
                <input type="date" name="to_date" value="{{ request('to_date', $endDate->format('Y-m-d')) }}"
                       class="w-full border border-slate-300 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-brand-700 focus:outline-none">
            </div>

            <!-- Room Category Filter -->
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1">Room Category</label>
                <select name="room_type_id" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    <option value="">All Room Types</option>
                    @foreach($roomTypes as $rt)
                        <option value="{{ $rt->id }}" {{ request('room_type_id') == $rt->id ? 'selected' : '' }}>{{ $rt->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Booking Status Filter -->
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1">Stay Status</label>
                <select name="status" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    <option value="all">All Statuses</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed Only</option>
                    <option value="checked_in" {{ request('status') == 'checked_in' ? 'selected' : '' }}>Checked In (In-House)</option>
                    <option value="checked_out" {{ request('status') == 'checked_out' ? 'selected' : '' }}>Completed Stays</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <!-- Submit Filter -->
            <div class="flex items-center gap-2">
                <button type="submit" class="w-full bg-brand-800 hover:bg-brand-900 text-white font-bold py-2 px-4 rounded-xl text-xs transition shadow-xs">
                    Apply Filter
                </button>
                @if(request()->hasAny(['from_date', 'to_date', 'room_type_id', 'status', 'period']))
                    <a href="{{ route('admin.reports.index') }}" class="text-xs text-slate-500 hover:text-slate-800 px-2 py-2">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- High-Level KPI Summary Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3.5">
        <!-- Gross Revenue -->
        <div class="bg-brand-900 text-white p-4 rounded-2xl border border-brand-800 shadow-md">
            <span class="text-[10px] font-bold text-gold-400 uppercase tracking-wider block">Gross Revenue</span>
            <strong class="text-xl sm:text-2xl font-serif font-bold block mt-1">Rs. {{ number_format($grossRevenue) }}</strong>
            <span class="text-[10px] text-slate-300">Room: Rs. {{ number_format($roomRevenue) }}</span>
        </div>

        <!-- Advance Collected -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider block">Advance Paid</span>
            <strong class="text-xl sm:text-2xl font-serif font-bold text-emerald-700 block mt-1">Rs. {{ number_format($advanceCollected) }}</strong>
            <span class="text-[10px] text-slate-400">Cash / Bank verification</span>
        </div>

        <!-- Balance Pending -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-[10px] font-bold text-rose-600 uppercase tracking-wider block">Balance Pending</span>
            <strong class="text-xl sm:text-2xl font-serif font-bold text-rose-700 block mt-1">Rs. {{ number_format($balanceDue) }}</strong>
            <span class="text-[10px] text-slate-400">Due upon check-out</span>
        </div>

        <!-- Occupancy Rate -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider block">Occupancy Rate</span>
            <strong class="text-xl sm:text-2xl font-serif font-bold text-blue-800 block mt-1">{{ $occupancyRate }}%</strong>
            <span class="text-[10px] text-slate-400">{{ $occupiedNights }} / {{ $totalAvailableRoomNights }} room nights</span>
        </div>

        <!-- Total Stays -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Total Bookings</span>
            <strong class="text-xl sm:text-2xl font-serif font-bold text-slate-900 block mt-1">{{ $totalBookings }}</strong>
            <span class="text-[10px] text-slate-400">{{ $confirmedBookings }} confirmed, {{ $cancelledBookings }} cancelled</span>
        </div>

        <!-- ADR (Average Daily Rate) -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-[10px] font-bold text-purple-600 uppercase tracking-wider block">Average Daily Rate</span>
            <strong class="text-xl sm:text-2xl font-serif font-bold text-purple-800 block mt-1">Rs. {{ number_format($adr) }}</strong>
            <span class="text-[10px] text-slate-400">RevPAR: Rs. {{ number_format($revpar) }}</span>
        </div>
    </div>

    <!-- Room-Wise Occupancy & Revenue Breakdown -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-serif font-bold text-slate-900 text-sm flex items-center gap-2">
                    <i class="fa-solid fa-door-open text-brand-700"></i> Room-Wise Performance & Income Breakdown
                </h3>
                <p class="text-xs text-slate-500">Earnings and occupancy percentage calculated per individual physical room.</p>
            </div>
            <a href="{{ route('admin.reports.export-rooms', request()->query()) }}" class="text-xs text-brand-700 hover:underline font-bold flex items-center gap-1">
                <i class="fa-solid fa-download"></i> Download CSV
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider text-[10px] font-bold">
                        <th class="py-3 px-4">Room</th>
                        <th class="py-3 px-4">Category & Wing</th>
                        <th class="py-3 px-4">Reservations</th>
                        <th class="py-3 px-4">Nights Occupied</th>
                        <th class="py-3 px-4">Occupancy Rate</th>
                        <th class="py-3 px-4 text-right">Gross Income</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($roomBreakdown as $rb)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4 font-bold text-slate-900 font-mono">
                                <i class="fa-solid fa-bed text-gold-500 mr-1.5"></i> {{ str_starts_with($rb['room']->room_number, 'Room') ? $rb['room']->room_number : 'Room ' . $rb['room']->room_number }}
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-semibold text-slate-800">{{ $rb['room']->roomType?->name ?? 'Standard' }}</div>
                                <div class="text-[10px] text-slate-400">{{ $rb['room']->floor_wing }}</div>
                            </td>
                            <td class="py-3.5 px-4 font-mono font-bold text-slate-700">
                                {{ $rb['bookings_count'] }}
                            </td>
                            <td class="py-3.5 px-4 font-mono text-slate-700">
                                {{ $rb['nights'] }} night(s)
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-24 bg-slate-200 rounded-full h-2 overflow-hidden">
                                        <div class="bg-brand-700 h-2 rounded-full" style="width: {{ $rb['occupancy_rate'] }}%"></div>
                                    </div>
                                    <span class="font-mono font-bold text-slate-800">{{ $rb['occupancy_rate'] }}%</span>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-right font-mono font-bold text-brand-900 text-sm">
                                Rs. {{ number_format($rb['revenue']) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Detailed Reservations Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-serif font-bold text-slate-900 text-sm flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-brand-700"></i> Reservation Records in Selected Period
                </h3>
                <p class="text-xs text-slate-500">Filtered stay details and financial status for each reservation.</p>
            </div>
            <a href="{{ route('admin.reports.export-bookings', request()->query()) }}" class="text-xs text-brand-700 hover:underline font-bold flex items-center gap-1">
                <i class="fa-solid fa-download"></i> Export Full Bookings CSV
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider text-[10px] font-bold">
                        <th class="py-3 px-4">Booking Code</th>
                        <th class="py-3 px-4">Guest Details</th>
                        <th class="py-3 px-4">Room</th>
                        <th class="py-3 px-4">Stay Dates</th>
                        <th class="py-3 px-4">Total Amount</th>
                        <th class="py-3 px-4">Payment & Balance</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3 px-4 font-mono font-bold text-brand-900 whitespace-nowrap">
                                {{ $booking->booking_code }}
                            </td>
                            <td class="py-3 px-4">
                                <strong class="text-slate-900 block">{{ $booking->guest_name }}</strong>
                                <span class="text-[11px] text-slate-500 font-mono">{{ $booking->guest_phone }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="font-semibold text-slate-800">{{ $booking->roomType?->name ?? 'Standard' }}</span>
                                @if($booking->room)
                                    <div class="text-[10px] text-emerald-700 font-bold font-mono">Room {{ $booking->room->room_number }}</div>
                                @endif
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap font-mono text-[11px]">
                                <span class="text-slate-800 block">{{ $booking->check_in_date }}</span>
                                <span class="text-slate-400 block">to {{ $booking->check_out_date }} ({{ $booking->nights }}N)</span>
                            </td>
                            <td class="py-3 px-4 font-mono font-bold text-slate-900">
                                Rs. {{ number_format($booking->total_amount) }}
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap">
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full uppercase {{ $booking->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : ($booking->payment_status === 'partial' ? 'bg-blue-100 text-blue-800' : 'bg-rose-100 text-rose-800') }}">
                                    {{ $booking->payment_status }}
                                </span>
                                @if($booking->balance_due > 0)
                                    <span class="text-[10px] text-rose-600 block mt-0.5 font-mono">Due: Rs. {{ number_format($booking->balance_due) }}</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap">
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full uppercase bg-slate-100 text-slate-700">
                                    {{ $booking->booking_status }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button type="button" @click="$dispatch('open-invoice-modal', { bookingId: {{ $booking->id }} })" 
                                            class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-2 py-1 rounded text-[11px] font-bold transition">
                                        <i class="fa-solid fa-receipt text-slate-500"></i> Invoice
                                    </button>
                                    <a href="{{ route('admin.bookings.show', $booking) }}" 
                                       class="bg-brand-50 hover:bg-brand-100 text-brand-800 px-2 py-1 rounded text-[11px] font-bold transition">
                                        View
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-8 text-center text-slate-400">
                                No reservations found for the selected period and filters.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($bookings->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
