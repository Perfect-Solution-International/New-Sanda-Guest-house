@extends('admin.layouts.app')

@section('title', 'Resort Overview - Admin Portal')
@section('page_title', 'Dashboard & Operational Overview')

@section('content')
<div class="space-y-6 text-white" x-data="{ selectedCategory: 'all' }">

    <!-- Top Bento Row: Resort Status + Property Live Card -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Left Hero Status Card (7 cols) -->
        <div class="lg:col-span-7 flex flex-col justify-between space-y-5">
            <div class="bg-white/[0.07] backdrop-blur-xl border border-white/10 rounded-3xl p-6 sm:p-7 shadow-xl">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-[0.22em] text-gold-400">Live Operations</span>
                        <h3 class="text-3xl sm:text-4xl font-serif font-bold text-white mt-1">Resort Status</h3>
                        <p class="text-sm text-emerald-100/85 mt-2">
                            @if($pendingBookings > 0 || $unreadInquiries > 0)
                                {{ $availableRooms }} of {{ $totalRooms }} rooms ready • {{ $pendingBookings }} pending reservation(s) need review.
                            @else
                                Everything looks good • {{ $availableRooms }} of {{ $totalRooms }} rooms clean and ready.
                            @endif
                        </p>
                        <p class="text-[11px] text-slate-300/70 mt-1">Last Sync • Just now</p>
                    </div>
                    <div class="flex items-center gap-2 bg-emerald-500/15 border border-emerald-400/30 px-3.5 py-1.5 rounded-full">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span class="text-xs font-bold text-emerald-200">{{ $occupancyRate }}% Occupied</span>
                    </div>
                </div>
            </div>

            <!-- Room Categories Pill Bar (matches reference "Rooms" pills) -->
            <div class="space-y-3">
                <div class="flex items-center justify-between px-1">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-200">Room Categories</span>
                    <a href="{{ route('admin.rooms.index') }}" class="text-xs text-gold-400 hover:text-gold-300 font-semibold transition">
                        Manage Rooms &rarr;
                    </a>
                </div>
                <div class="flex flex-wrap gap-2.5">
                    <button type="button"
                            @click="selectedCategory = 'all'"
                            class="px-4 py-2 rounded-full text-xs font-semibold transition border cursor-pointer"
                            :class="selectedCategory === 'all' ? 'bg-gold-500 text-brand-900 border-gold-400 shadow-md font-bold' : 'bg-white/[0.07] text-slate-200 border-white/10 hover:bg-white/15'">
                        All ({{ $totalRooms }})
                    </button>
                    @foreach($roomTypes as $rt)
                        <button type="button"
                                @click="selectedCategory = '{{ $rt->id }}'"
                                class="px-4 py-2 rounded-full text-xs font-semibold transition border cursor-pointer"
                                :class="selectedCategory === '{{ $rt->id }}' ? 'bg-gold-500 text-brand-900 border-gold-400 shadow-md font-bold' : 'bg-white/[0.07] text-slate-200 border-white/10 hover:bg-white/15'">
                            {{ \Illuminate\Support\Str::limit($rt->name, 22) }}
                            <span class="opacity-75 ml-1">({{ $rt->available_rooms_count }}/{{ $rt->rooms_count }})</span>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Visual Property & Quick Actions Card (5 cols) -->
        <div class="lg:col-span-5 relative rounded-3xl overflow-hidden border border-white/15 shadow-xl min-h-[235px] flex flex-col justify-between p-6 bg-cover bg-center"
             style="background-image: linear-gradient(to top, rgba(7, 25, 15, 0.92) 15%, rgba(7, 25, 15, 0.45) 60%, rgba(7, 25, 15, 0.72) 100%), url('/uploads/gallery/exterior-parking.jpg');">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-base font-bold text-white">Sanda Guest House</h4>
                    <div class="flex items-center gap-2 text-xs text-emerald-200 mt-0.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        <span>Live • {{ $availableRooms }} Rooms Free</span>
                    </div>
                </div>
                <a href="{{ route('admin.timeline') }}" class="text-xs font-semibold text-gold-400 hover:text-gold-300 bg-black/35 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/15 transition">
                    View Timeline
                </a>
            </div>

            <div class="grid grid-cols-2 gap-2.5 pt-4">
                <a href="{{ route('admin.bookings.create') }}" class="bg-gold-500 hover:bg-gold-400 text-brand-900 font-bold px-3.5 py-2.5 rounded-xl text-xs flex items-center justify-center gap-1.5 transition shadow">
                    <i class="fa-solid fa-plus"></i> Walk-in Booking
                </a>
                <a href="{{ route('admin.rooms.index') }}" class="bg-white/15 hover:bg-white/25 backdrop-blur-md text-white font-semibold px-3.5 py-2.5 rounded-xl text-xs flex items-center justify-center gap-1.5 border border-white/15 transition">
                    <i class="fa-solid fa-door-closed text-gold-400"></i> Physical Rooms
                </a>
                <a href="{{ route('admin.bookings.index', ['status' => 'pending']) }}" class="bg-white/10 hover:bg-white/20 backdrop-blur-md text-white font-medium px-3.5 py-2 rounded-xl text-xs flex items-center justify-center gap-1.5 border border-white/10 transition">
                    <i class="fa-solid fa-clock text-amber-400"></i> Pending ({{ $pendingBookings }})
                </a>
                <a href="{{ route('admin.inquiries.index') }}" class="bg-white/10 hover:bg-white/20 backdrop-blur-md text-white font-medium px-3.5 py-2 rounded-xl text-xs flex items-center justify-center gap-1.5 border border-white/10 transition">
                    <i class="fa-solid fa-envelope text-emerald-300"></i> Inquiries ({{ $unreadInquiries }})
                </a>
            </div>
        </div>
    </div>

    <!-- Bottom Bento Row: 2x2 Frosted Stat Tiles (7 cols) + Recent Activity Feed (5 cols) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Left 2x2 Glassmorphic Stat Cards -->
        <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-5">

            <!-- Tile 1: Revenue -->
            <div class="bg-white/[0.06] backdrop-blur-xl border border-white/10 rounded-3xl p-6 hover:bg-white/[0.09] transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-500/15 border border-emerald-400/25 text-emerald-300 flex items-center justify-center">
                        <i class="fa-solid fa-coins"></i>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-300/80">Revenue</span>
                </div>
                <div class="text-2xl font-serif font-bold text-white">Rs. {{ number_format($totalRevenue) }}</div>
                <div class="mt-3 pt-3 border-t border-white/10 text-xs space-y-1 text-slate-300">
                    <div class="flex justify-between">
                        <span>This Month:</span>
                        <span class="font-bold text-white">Rs. {{ number_format($monthlyRevenue) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Today:</span>
                        <span class="font-bold text-emerald-300">Rs. {{ number_format($todayRevenue) }}</span>
                    </div>
                    <div class="flex justify-between text-[11px] text-slate-400">
                        <span>Advance Collected:</span>
                        <span>Rs. {{ number_format($advanceCollected) }}</span>
                    </div>
                </div>
            </div>

            <!-- Tile 2: Room Occupancy -->
            <div class="bg-white/[0.06] backdrop-blur-xl border border-white/10 rounded-3xl p-6 hover:bg-white/[0.09] transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 rounded-2xl bg-gold-500/15 border border-gold-400/25 text-gold-400 flex items-center justify-center">
                        <i class="fa-solid fa-bed"></i>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-300/80">Occupancy</span>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-2xl font-serif font-bold text-white">{{ $availableRooms }}</span>
                    <span class="text-xs font-bold text-emerald-300 uppercase">Rooms Free</span>
                </div>
                <div class="mt-3 pt-3 border-t border-white/10 text-xs space-y-1 text-slate-300">
                    <div class="flex justify-between">
                        <span>Occupancy Rate:</span>
                        <span class="font-bold text-white">{{ $occupancyRate }}%</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Currently Occupied:</span>
                        <span class="font-bold text-rose-300">{{ $occupiedRooms }} of {{ $totalRooms }}</span>
                    </div>
                    @if($cleaningRooms > 0 || $maintenanceRooms > 0)
                        <div class="flex justify-between text-[11px] text-amber-300">
                            <span>Cleaning / Maint:</span>
                            <span>{{ $cleaningRooms + $maintenanceRooms }} rooms</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tile 3: Today's Moves -->
            <div class="bg-white/[0.06] backdrop-blur-xl border border-white/10 rounded-3xl p-6 hover:bg-white/[0.09] transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 rounded-2xl bg-amber-500/15 border border-amber-400/25 text-amber-300 flex items-center justify-center">
                        <i class="fa-solid fa-bell-concierge"></i>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-300/80">Today's Moves</span>
                </div>
                <div class="flex items-center gap-6">
                    <div>
                        <span class="text-2xl font-serif font-bold text-emerald-300">{{ $todayCheckIns }}</span>
                        <span class="text-xs text-slate-300 block">Check-ins</span>
                    </div>
                    <div class="h-9 border-r border-white/15"></div>
                    <div>
                        <span class="text-2xl font-serif font-bold text-rose-300">{{ $todayCheckOuts }}</span>
                        <span class="text-xs text-slate-300 block">Check-outs</span>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-white/10 text-[11px] text-slate-300/80 flex items-center gap-1.5">
                    <i class="fa-regular fa-calendar-check text-gold-400"></i>
                    <span>Active front desk operations</span>
                </div>
            </div>

            <!-- Tile 4: Pending Attention -->
            <div class="bg-white/[0.06] backdrop-blur-xl border border-white/10 rounded-3xl p-6 hover:bg-white/[0.09] transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 rounded-2xl bg-rose-500/15 border border-rose-400/25 text-rose-300 flex items-center justify-center">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-300/80">Attention</span>
                </div>
                <div class="flex items-center gap-6">
                    <div>
                        <span class="text-2xl font-serif font-bold text-gold-400">{{ $pendingBookings }}</span>
                        <span class="text-xs text-slate-300 block">Unconfirmed</span>
                    </div>
                    <div class="h-9 border-r border-white/15"></div>
                    <div>
                        <span class="text-2xl font-serif font-bold text-white">{{ $unreadInquiries }}</span>
                        <span class="text-xs text-slate-300 block">New Messages</span>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-white/10 text-[11px] text-slate-300/80 flex items-center gap-1.5">
                    <i class="fa-solid fa-bolt text-gold-400"></i>
                    <span>Requires staff review</span>
                </div>
            </div>
        </div>

        <!-- Right Recent Reservations Feed (5 cols, matches reference "Recent Activity") -->
        <div class="lg:col-span-5 bg-white/[0.06] backdrop-blur-xl border border-white/10 rounded-3xl p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-4 border-b border-white/10">
                    <h3 class="font-serif font-bold text-lg text-white">Recent Reservations</h3>
                    <a href="{{ route('admin.bookings.index') }}" class="text-xs font-semibold text-gold-400 hover:text-gold-300 transition">
                        View All &rarr;
                    </a>
                </div>

                <div class="divide-y divide-white/10 mt-2">
                    @forelse($recentBookings as $booking)
                        <div class="py-3.5 flex items-center justify-between gap-3"
                             x-show="selectedCategory === 'all' || selectedCategory === '{{ $booking->room_type_id }}'">
                            <div class="min-w-0">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="font-mono font-bold text-xs text-gold-400 hover:underline">
                                        {{ $booking->booking_code }}
                                    </a>
                                    @php
                                        $badge = [
                                            'pending' => 'bg-amber-400/20 text-amber-300 border-amber-400/30',
                                            'confirmed' => 'bg-emerald-400/20 text-emerald-300 border-emerald-400/30',
                                            'checked_in' => 'bg-sky-400/20 text-sky-300 border-sky-400/30',
                                            'checked_out' => 'bg-white/10 text-slate-300 border-white/15',
                                            'cancelled' => 'bg-rose-400/20 text-rose-300 border-rose-400/30',
                                        ];
                                    @endphp
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase border {{ $badge[$booking->booking_status] ?? 'bg-white/10 text-slate-300 border-white/15' }}">
                                        {{ str_replace('_', ' ', $booking->booking_status) }}
                                    </span>
                                </div>
                                <div class="text-sm font-semibold text-white truncate mt-0.5">{{ $booking->guest_name }}</div>
                                <div class="text-[11px] text-slate-300/75 truncate">
                                    {{ $booking->roomType->name }}
                                    @if($booking->room) • Room {{ $booking->room->room_number }} @endif
                                </div>
                            </div>

                            <div class="text-right flex-shrink-0">
                                <div class="text-xs font-bold text-white">Rs. {{ number_format($booking->total_amount) }}</div>
                                <div class="text-[10px] text-slate-300/70">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d') }} - {{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d') }}</div>
                                <div class="mt-1 flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-[10px] font-semibold bg-white/10 hover:bg-white/20 text-white px-2.5 py-1 rounded-lg transition">
                                        Manage
                                    </a>
                                    <button type="button" @click="openInvoiceModal('{{ route('admin.bookings.invoice', $booking->id) }}', '{{ $booking->booking_code }}')" class="text-[10px] bg-white/10 hover:bg-white/20 text-gold-400 px-2 py-1 rounded-lg transition" title="Invoice">
                                        <i class="fa-solid fa-print"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="py-10 text-center text-slate-300/70 text-xs">
                            No reservations recorded yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
