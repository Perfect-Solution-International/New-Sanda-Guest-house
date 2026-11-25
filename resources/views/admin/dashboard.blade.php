@extends('admin.layouts.app')

@section('title', 'Resort Overview - Admin Portal')
@section('page_title', 'Dashboard & Operational Overview')

@section('content')
<div class="space-y-8">
    <!-- Quick Stats Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Revenue Card -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Revenue Overview</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-coins"></i>
                </div>
            </div>
            <div class="text-2xl font-bold font-serif text-slate-900">
                Rs. {{ number_format($totalRevenue) }}
            </div>
            <div class="text-xs text-slate-500 mt-2 space-y-1">
                <div class="flex items-center justify-between">
                    <span class="text-slate-600">This Month:</span>
                    <span class="font-bold text-slate-800">Rs. {{ number_format($monthlyRevenue) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-600">Today:</span>
                    <span class="font-bold text-emerald-700">Rs. {{ number_format($todayRevenue) }}</span>
                </div>
                <div class="flex items-center justify-between text-[11px] text-slate-400 pt-1 border-t border-slate-100">
                    <span>Advance Collected:</span>
                    <span>Rs. {{ number_format($advanceCollected) }}</span>
                </div>
            </div>
        </div>

        <!-- Occupancy & Available Rooms -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Room Occupancy & Free</span>
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-chart-pie"></i>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <div class="text-2xl font-bold font-serif text-slate-900">
                    {{ $availableRooms }}
                </div>
                <div class="text-xs font-bold text-emerald-700 uppercase tracking-wider">
                    Rooms Available
                </div>
            </div>
            <div class="text-xs text-slate-500 mt-2 space-y-1">
                <div class="flex items-center justify-between">
                    <span class="text-slate-600">Occupancy Rate:</span>
                    <span class="font-bold text-slate-800">{{ $occupancyRate }}%</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-600">Currently Occupied:</span>
                    <span class="font-bold text-rose-700">{{ $occupiedRooms }} of {{ $totalRooms }}</span>
                </div>
                @if($cleaningRooms > 0 || $maintenanceRooms > 0)
                    <div class="flex items-center justify-between text-[11px] text-amber-600 pt-1 border-t border-slate-100">
                        <span>Cleaning / Maint:</span>
                        <span>{{ $cleaningRooms + $maintenanceRooms }} rooms</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Today's Activity -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Today's Moves</span>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-bell-concierge"></i>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div>
                    <span class="text-xl font-bold text-emerald-700">{{ $todayCheckIns }}</span>
                    <span class="text-xs text-slate-500 block">Check-ins</span>
                </div>
                <div class="h-8 border-r border-slate-200"></div>
                <div>
                    <span class="text-xl font-bold text-rose-700">{{ $todayCheckOuts }}</span>
                    <span class="text-xs text-slate-500 block">Check-outs</span>
                </div>
            </div>
            <div class="text-[11px] text-slate-400 mt-4 pt-2 border-t border-slate-100 flex items-center gap-1">
                <i class="fa-regular fa-calendar-check text-gold-500"></i>
                <span>Active front desk operations</span>
            </div>
        </div>

        <!-- Pending Bookings / Actions -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pending Attention</span>
                <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div>
                    <span class="text-xl font-bold text-amber-700">{{ $pendingBookings }}</span>
                    <span class="text-xs text-slate-500 block">Unconfirmed</span>
                </div>
                <div class="h-8 border-r border-slate-200"></div>
                <div>
                    <span class="text-xl font-bold text-brand-700">{{ $unreadInquiries }}</span>
                    <span class="text-xs text-slate-500 block">New Messages</span>
                </div>
            </div>
            <div class="text-[11px] text-slate-400 mt-4 pt-2 border-t border-slate-100 flex items-center gap-1">
                <i class="fa-solid fa-bolt text-amber-500"></i>
                <span>Requires staff review</span>
            </div>
        </div>
    </div>

    <!-- Quick Operations Actions -->
    <div class="bg-brand-900 rounded-3xl p-6 text-white flex flex-wrap items-center justify-between gap-4">
        <div>
            <h3 class="text-lg font-serif font-bold text-white">Front Desk Quick Actions</h3>
            <p class="text-xs text-slate-300">Fast operations for arriving guests, room assignments, and inquiries.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.bookings.create') }}" class="bg-gold-500 hover:bg-gold-600 text-brand-900 font-bold px-4 py-2 rounded-xl text-xs flex items-center gap-1.5 transition shadow-xs">
                <i class="fa-solid fa-plus"></i> Walk-in Reservation
            </a>
            <a href="{{ route('admin.timeline') }}" class="bg-brand-800 hover:bg-brand-700 text-white font-medium px-4 py-2 rounded-xl text-xs flex items-center gap-1.5 transition">
                <i class="fa-solid fa-calendar-days text-gold-400"></i> Availability Timeline
            </a>
            <a href="{{ route('admin.bookings.index', ['status' => 'pending']) }}" class="bg-brand-800 hover:bg-brand-700 text-white font-medium px-4 py-2 rounded-xl text-xs flex items-center gap-1.5 transition">
                <i class="fa-solid fa-circle-exclamation text-amber-400"></i> Review Pending ({{ $pendingBookings }})
            </a>
            <a href="{{ route('admin.rooms.index') }}" class="bg-brand-800 hover:bg-brand-700 text-white font-medium px-4 py-2 rounded-xl text-xs flex items-center gap-1.5 transition">
                <i class="fa-solid fa-broom text-blue-300"></i> Room Housekeeping
            </a>
        </div>
    </div>

    <!-- Recent Bookings Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-serif font-bold text-lg text-slate-900">Recent Reservations</h3>
            <a href="{{ route('admin.bookings.index') }}" class="text-xs font-bold text-brand-700 hover:underline">
                View All Reservations &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-6">Booking Code</th>
                        <th class="py-3.5 px-6">Guest Name & Phone</th>
                        <th class="py-3.5 px-6">Room / Wing</th>
                        <th class="py-3.5 px-6">Dates</th>
                        <th class="py-3.5 px-6">Amount / Balance</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentBookings as $booking)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-6 font-mono font-bold text-brand-900 text-xs">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="hover:underline">
                                    {{ $booking->booking_code }}
                                </a>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900">{{ $booking->guest_name }}</div>
                                <div class="text-xs text-slate-500">{{ $booking->guest_phone }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-semibold text-slate-800 text-xs">{{ $booking->roomType->name }}</div>
                                @if($booking->room)
                                    <span class="inline-block bg-brand-50 text-brand-800 text-[10px] font-bold px-2 py-0.5 rounded">
                                        {{ $booking->room->room_number }}
                                    </span>
                                @else
                                    <span class="text-[10px] text-amber-600 font-semibold italic">Unassigned</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-xs text-slate-600">
                                <div>{{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d') }} - {{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}</div>
                                <div class="text-[11px] text-slate-400">{{ $booking->nights }} Night(s)</div>
                            </td>
                            <td class="py-4 px-6 text-xs">
                                <div class="font-bold text-slate-900">Rs. {{ number_format($booking->total_amount) }}</div>
                                @if($booking->balance_due > 0)
                                    <div class="text-rose-600 font-semibold text-[11px]">Due: Rs. {{ number_format($booking->balance_due) }}</div>
                                @else
                                    <div class="text-emerald-600 font-semibold text-[11px]">Settled</div>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                @php
                                    $badge = [
                                        'pending' => 'bg-amber-100 text-amber-800',
                                        'confirmed' => 'bg-blue-100 text-blue-800',
                                        'checked_in' => 'bg-emerald-100 text-emerald-800',
                                        'checked_out' => 'bg-purple-100 text-purple-800',
                                        'cancelled' => 'bg-rose-100 text-rose-800',
                                    ];
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $badge[$booking->booking_status] ?? 'bg-slate-100 text-slate-700' }}">
                                    {{ str_replace('_', ' ', $booking->booking_status) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right space-x-2">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-xs bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold px-3 py-1.5 rounded-lg transition">
                                    Manage
                                </a>
                                <button type="button" @click="openInvoiceModal('{{ route('admin.bookings.invoice', $booking->id) }}', '{{ $booking->booking_code }}')" title="Print Invoice" class="text-xs bg-brand-50 hover:bg-brand-100 text-brand-800 font-bold px-2 py-1.5 rounded-lg transition">
                                    <i class="fa-solid fa-print"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400 text-sm">
                                No reservations recorded yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
