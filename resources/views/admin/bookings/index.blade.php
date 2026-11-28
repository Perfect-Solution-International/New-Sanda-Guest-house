@extends('admin.layouts.app')

@section('title', 'Manage Reservations - Sanda Guest House')
@section('page_title', 'Reservations & Room Availability Desk')

@section('content')
<div class="space-y-6">

    <!-- Top Action & Overview Bar -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-serif font-bold text-slate-900">Reservations & Live Desk</h2>
            <p class="text-xs text-slate-500">Track exact time ranges, room occupancy, guest contact, and instant booking statuses.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('booking.create') }}" target="_blank" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs px-3.5 py-2.5 rounded-xl transition flex items-center gap-1.5 border border-slate-200">
                <i class="fa-solid fa-arrow-up-right-from-square text-emerald-700"></i> Open Public Booking
            </a>
            <a href="{{ route('admin.bookings.create') }}" class="bg-brand-700 hover:bg-brand-800 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition flex items-center gap-2 shadow-md">
                <i class="fa-solid fa-plus text-gold-400"></i> Add New Reservation
            </a>
        </div>
    </div>

    <!-- Status Metric Cards (Dark Luxury Styling) -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
        <!-- Total -->
        <a href="{{ route('admin.bookings.index') }}" class="p-4 rounded-2xl border transition {{ !request('status') ? 'bg-brand-900 text-white border-brand-800 shadow-md ring-2 ring-gold-400/40' : 'bg-white hover:bg-slate-50 text-slate-800 border-slate-200 shadow-xs' }}">
            <span class="text-[10px] font-bold uppercase tracking-wider block opacity-75">All Bookings</span>
            <span class="text-2xl font-serif font-bold block mt-1">{{ $stats['total'] ?? 0 }}</span>
        </a>

        <!-- Pending -->
        <a href="{{ route('admin.bookings.index', ['status' => 'pending']) }}" class="p-4 rounded-2xl border transition {{ request('status') == 'pending' ? 'bg-amber-600 text-white border-amber-700 shadow-md' : 'bg-white hover:bg-slate-50 text-slate-800 border-slate-200 shadow-xs' }}">
            <span class="text-[10px] font-bold uppercase tracking-wider block opacity-75">Pending</span>
            <span class="text-2xl font-serif font-bold block mt-1 text-amber-500 {{ request('status') == 'pending' ? 'text-white' : '' }}">{{ $stats['pending'] ?? 0 }}</span>
        </a>

        <!-- Confirmed -->
        <a href="{{ route('admin.bookings.index', ['status' => 'confirmed']) }}" class="p-4 rounded-2xl border transition {{ request('status') == 'confirmed' ? 'bg-blue-700 text-white border-blue-800 shadow-md' : 'bg-white hover:bg-slate-50 text-slate-800 border-slate-200 shadow-xs' }}">
            <span class="text-[10px] font-bold uppercase tracking-wider block opacity-75">Confirmed</span>
            <span class="text-2xl font-serif font-bold block mt-1 text-blue-600 {{ request('status') == 'confirmed' ? 'text-white' : '' }}">{{ $stats['confirmed'] ?? 0 }}</span>
        </a>

        <!-- Checked In -->
        <a href="{{ route('admin.bookings.index', ['status' => 'checked_in']) }}" class="p-4 rounded-2xl border transition {{ request('status') == 'checked_in' ? 'bg-emerald-700 text-white border-emerald-800 shadow-md' : 'bg-white hover:bg-slate-50 text-slate-800 border-slate-200 shadow-xs' }}">
            <span class="text-[10px] font-bold uppercase tracking-wider block opacity-75">Checked In</span>
            <span class="text-2xl font-serif font-bold block mt-1 text-emerald-600 {{ request('status') == 'checked_in' ? 'text-white' : '' }}">{{ $stats['checked_in'] ?? 0 }}</span>
        </a>

        <!-- Checked Out -->
        <a href="{{ route('admin.bookings.index', ['status' => 'checked_out']) }}" class="p-4 rounded-2xl border transition {{ request('status') == 'checked_out' ? 'bg-purple-700 text-white border-purple-800 shadow-md' : 'bg-white hover:bg-slate-50 text-slate-800 border-slate-200 shadow-xs' }}">
            <span class="text-[10px] font-bold uppercase tracking-wider block opacity-75">Checked Out</span>
            <span class="text-2xl font-serif font-bold block mt-1 text-purple-600 {{ request('status') == 'checked_out' ? 'text-white' : '' }}">{{ $stats['checked_out'] ?? 0 }}</span>
        </a>

        <!-- Cancelled -->
        <a href="{{ route('admin.bookings.index', ['status' => 'cancelled']) }}" class="p-4 rounded-2xl border transition {{ request('status') == 'cancelled' ? 'bg-rose-700 text-white border-rose-800 shadow-md' : 'bg-white hover:bg-slate-50 text-slate-800 border-slate-200 shadow-xs' }}">
            <span class="text-[10px] font-bold uppercase tracking-wider block opacity-75">Cancelled</span>
            <span class="text-2xl font-serif font-bold block mt-1 text-rose-600 {{ request('status') == 'cancelled' ? 'text-white' : '' }}">{{ $stats['cancelled'] ?? 0 }}</span>
        </a>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-slate-200">
        <form action="{{ route('admin.bookings.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Search Guest / Reference / Phone</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search code, name, phone..."
                       class="w-full text-sm border border-slate-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-brand-700 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Status Filter</label>
                <select name="status" class="w-full text-sm border border-slate-300 rounded-xl px-4 py-2.5 bg-white focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="checked_in" {{ request('status') == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                    <option value="checked_out" {{ request('status') == 'checked_out' ? 'selected' : '' }}>Checked Out</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Payment Status</label>
                <select name="payment_status" class="w-full text-sm border border-slate-300 rounded-xl px-4 py-2.5 bg-white focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    <option value="">All Payment States</option>
                    <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="advance_paid" {{ request('payment_status') == 'advance_paid' ? 'selected' : '' }}>Advance Paid</option>
                    <option value="paid_in_full" {{ request('payment_status') == 'paid_in_full' ? 'selected' : '' }}>Paid in Full</option>
                    <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-brand-700 hover:bg-brand-800 text-white font-bold py-2.5 rounded-xl text-xs transition flex items-center justify-center gap-1.5 shadow-sm">
                    <i class="fa-solid fa-filter"></i> Apply Filters
                </button>
                <a href="{{ route('admin.bookings.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-3.5 py-2.5 rounded-xl text-xs flex items-center justify-center transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Bookings Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="py-4 px-6">Reference & Stay</th>
                        <th class="py-4 px-6">Guest Contact</th>
                        <th class="py-4 px-6">Room Assigned</th>
                        <th class="py-4 px-6">Exact Time Range</th>
                        <th class="py-4 px-6">Billing</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-slate-50/80 transition {{ $booking->booking_status == 'cancelled' ? 'opacity-60 bg-slate-50/40' : '' }}">
                            <td class="py-4 px-6">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="font-mono font-bold text-brand-900 text-xs hover:underline block">
                                    {{ $booking->booking_code }}
                                </a>
                                <span class="inline-block mt-1 bg-slate-100 text-slate-700 font-semibold text-[10px] px-2 py-0.5 rounded-md">
                                    <i class="fa-regular fa-clock mr-1 text-slate-400"></i>{{ $booking->duration_display }}
                                </span>
                            </td>

                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900">{{ $booking->guest_name }}</div>
                                <div class="text-xs mt-0.5 flex items-center gap-1.5">
                                    @php
                                        $cleanPhone = preg_replace('/[^0-9]/', '', $booking->guest_phone);
                                    @endphp
                                    <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" title="Message on WhatsApp" class="inline-flex items-center gap-1 text-emerald-700 hover:text-emerald-800 font-semibold">
                                        <i class="fa-brands fa-whatsapp text-emerald-600 text-sm"></i> {{ $booking->guest_phone }}
                                    </a>
                                </div>
                                @if($booking->guest_email)
                                    <div class="text-[11px] text-slate-400 mt-0.5">{{ $booking->guest_email }}</div>
                                @endif
                            </td>

                            <td class="py-4 px-6">
                                <div class="font-semibold text-slate-800 text-xs">{{ $booking->roomType->name }}</div>
                                @if($booking->room)
                                    <span class="inline-block bg-emerald-50 text-emerald-800 font-bold text-[10px] px-2.5 py-0.5 rounded-md mt-1 border border-emerald-200">
                                        <i class="fa-solid fa-door-closed mr-1 text-emerald-600"></i>Room {{ $booking->room->room_number }}
                                    </span>
                                @else
                                    <span class="inline-block text-[10px] text-amber-700 bg-amber-50 px-2 py-0.5 rounded-md font-semibold mt-1 border border-amber-200">
                                        <i class="fa-solid fa-triangle-exclamation mr-1 text-amber-500"></i>Not Assigned
                                    </span>
                                @endif
                            </td>

                            <td class="py-4 px-6 text-xs text-slate-700 space-y-1">
                                <div>
                                    <span class="text-slate-400 font-semibold text-[10px] uppercase">In:</span> 
                                    <strong>{{ $booking->check_in_at ? $booking->check_in_at->format('M d, Y h:i A') : (\Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') . ' ' . date('h:i A', strtotime($booking->check_in_time ?? '14:00'))) }}</strong>
                                </div>
                                <div>
                                    <span class="text-slate-400 font-semibold text-[10px] uppercase">Out:</span> 
                                    <strong>{{ $booking->check_out_at ? $booking->check_out_at->format('M d, Y h:i A') : (\Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') . ' ' . date('h:i A', strtotime($booking->check_out_time ?? '11:00'))) }}</strong>
                                </div>
                            </td>

                            <td class="py-4 px-6 text-xs">
                                <div class="font-bold text-slate-900">Total: Rs. {{ number_format($booking->total_amount) }}</div>
                                <div class="text-emerald-700">Paid: Rs. {{ number_format($booking->advance_paid) }}</div>
                                @if($booking->balance_due > 0)
                                    <div class="text-rose-600 font-bold">Due: Rs. {{ number_format($booking->balance_due) }}</div>
                                @endif
                            </td>

                            <td class="py-4 px-6">
                                @php
                                    $badge = [
                                        'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
                                        'confirmed' => 'bg-blue-100 text-blue-800 border-blue-200',
                                        'checked_in' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                        'checked_out' => 'bg-purple-100 text-purple-800 border-purple-200',
                                        'cancelled' => 'bg-rose-100 text-rose-800 border-rose-200',
                                    ];
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase border {{ $badge[$booking->booking_status] ?? 'bg-slate-100 text-slate-700' }}">
                                    {{ str_replace('_', ' ', $booking->booking_status) }}
                                </span>
                            </td>

                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5 justify-end">
                                    <!-- Quick Check-In (for pending/confirmed) -->
                                    @if(in_array($booking->booking_status, ['pending', 'confirmed']))
                                        <form action="{{ route('admin.bookings.check-in', $booking->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" title="Mark Guest Checked In" class="inline-flex items-center gap-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-2.5 py-1.5 rounded-lg transition shadow-xs cursor-pointer">
                                                <i class="fa-solid fa-right-to-bracket text-[11px]"></i> <span>Check In</span>
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Quick Check-Out (for checked_in) -->
                                    @if($booking->booking_status === 'checked_in')
                                        <form action="{{ route('admin.bookings.check-out', $booking->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" title="Mark Guest Checked Out" class="inline-flex items-center gap-1 bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs px-2.5 py-1.5 rounded-lg transition shadow-xs cursor-pointer">
                                                <i class="fa-solid fa-right-from-bracket text-[11px]"></i> <span>Check Out</span>
                                            </button>
                                        </form>
                                    @endif

                                    <!-- View -->
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" title="View & Manage" class="inline-flex items-center gap-1 bg-brand-700 hover:bg-brand-800 text-white font-bold text-xs px-2.5 py-1.5 rounded-lg transition shadow-xs">
                                        <i class="fa-solid fa-eye text-[11px]"></i> <span>View</span>
                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('admin.bookings.edit', $booking->id) }}" title="Edit Reservation" class="inline-flex items-center gap-1 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs px-2.5 py-1.5 rounded-lg transition shadow-xs">
                                        <i class="fa-solid fa-pen-to-square text-[11px]"></i> <span>Edit</span>
                                    </a>

                                    <!-- Quick Cancel (if not already cancelled or checked out) -->
                                    @if(!in_array($booking->booking_status, ['cancelled', 'checked_out']))
                                        <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Cancel reservation #{{ $booking->booking_code }} for {{ addslashes($booking->guest_name) }}? The room will immediately become available for other guests.');">
                                            @csrf
                                            <button type="submit" title="Cancel Booking (Releases Room)" class="inline-flex items-center gap-1 bg-amber-50 hover:bg-amber-100 text-amber-700 hover:text-amber-800 font-bold text-xs px-2 py-1.5 rounded-lg transition border border-amber-200">
                                                <i class="fa-solid fa-ban text-[11px]"></i>
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Print Invoice (In-Page Modal) -->
                                    <button type="button" @click="openInvoiceModal('{{ route('admin.bookings.invoice', $booking->id) }}', '{{ $booking->booking_code }}')" title="Print Invoice" class="inline-flex items-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs px-2.5 py-1.5 rounded-lg transition border border-slate-200">
                                        <i class="fa-solid fa-print"></i>
                                    </button>

                                    <!-- Delete -->
                                    <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to permanently delete reservation #{{ $booking->booking_code }} ({{ addslashes($booking->guest_name) }})?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Delete Reservation" class="inline-flex items-center bg-rose-50 hover:bg-rose-100 text-rose-700 hover:text-rose-800 font-bold text-xs px-2 py-1.5 rounded-lg transition border border-rose-200">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-calendar-xmark text-4xl text-slate-300 block mb-2"></i>
                                No reservations match your query or filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($bookings->hasPages())
            <div class="p-6 border-t border-slate-100">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
