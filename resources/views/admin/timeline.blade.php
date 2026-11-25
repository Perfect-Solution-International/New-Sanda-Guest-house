@extends('admin.layouts.app')

@section('title', 'Room Availability Timeline & Visual Calendar - Sanda Guest House')
@section('page_title', 'Room Availability Timeline & Calendar')

@section('content')
<div class="space-y-6">

    <!-- Top Toolbar & Navigation -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200 space-y-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-serif font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-calendar-days text-brand-700"></i> Visual Room Schedule & Timeline
                </h2>
                <p class="text-xs text-slate-500 mt-1">
                    Visual day-by-day occupancy schedule, booking slots, and immediate availability.
                </p>
            </div>

            <!-- Quick Action -->
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.bookings.create') }}" class="bg-gold-500 hover:bg-gold-600 text-brand-900 font-bold px-4 py-2.5 rounded-xl text-xs flex items-center gap-2 transition shadow-xs">
                    <i class="fa-solid fa-plus"></i> New Reservation
                </a>
            </div>
        </div>

        <!-- Filter & Period Controls -->
        <form method="GET" action="{{ route('admin.timeline') }}" class="pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-4">
            <!-- Date Jump Controls -->
            <div class="flex items-center gap-2 flex-wrap">
                <a href="{{ route('admin.timeline', ['start_date' => $prevDate, 'days' => $days, 'room_type_id' => request('room_type_id')]) }}" 
                   class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition flex items-center gap-1.5"
                   title="Previous {{ $days }} days">
                    <i class="fa-solid fa-chevron-left text-[10px]"></i> Previous {{ $days }} Days
                </a>

                <a href="{{ route('admin.timeline', ['start_date' => now()->format('Y-m-d'), 'days' => $days, 'room_type_id' => request('room_type_id')]) }}" 
                   class="px-3 py-2 bg-brand-50 hover:bg-brand-100 text-brand-800 rounded-xl text-xs font-bold transition">
                    Today
                </a>

                <a href="{{ route('admin.timeline', ['start_date' => $nextDate, 'days' => $days, 'room_type_id' => request('room_type_id')]) }}" 
                   class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition flex items-center gap-1.5"
                   title="Next {{ $days }} days">
                    Next {{ $days }} Days <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </a>
            </div>

            <!-- Date Picker & Room Filter -->
            <div class="flex items-center gap-3 flex-wrap">
                <div class="flex items-center gap-2">
                    <label class="text-xs font-bold text-slate-600">Start Date:</label>
                    <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" 
                           class="border border-slate-300 rounded-xl px-3 py-1.5 text-xs focus:ring-2 focus:ring-brand-700 focus:outline-none">
                </div>

                <div class="flex items-center gap-2">
                    <label class="text-xs font-bold text-slate-600">Window:</label>
                    <select name="days" class="border border-slate-300 rounded-xl px-3 py-1.5 text-xs focus:ring-2 focus:ring-brand-700 focus:outline-none">
                        <option value="7" {{ $days == 7 ? 'selected' : '' }}>7 Days</option>
                        <option value="14" {{ $days == 14 ? 'selected' : '' }}>14 Days</option>
                        <option value="21" {{ $days == 21 ? 'selected' : '' }}>21 Days</option>
                        <option value="30" {{ $days == 30 ? 'selected' : '' }}>30 Days</option>
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <label class="text-xs font-bold text-slate-600">Category:</label>
                    <select name="room_type_id" class="border border-slate-300 rounded-xl px-3 py-1.5 text-xs focus:ring-2 focus:ring-brand-700 focus:outline-none">
                        <option value="">All Categories</option>
                        @foreach($roomTypes as $rt)
                            <option value="{{ $rt->id }}" {{ request('room_type_id') == $rt->id ? 'selected' : '' }}>
                                {{ $rt->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="bg-brand-900 hover:bg-brand-800 text-white font-bold px-4 py-1.5 rounded-xl text-xs transition">
                    Apply Filter
                </button>
            </div>
        </form>

        <!-- Legend -->
        <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center gap-4 text-xs font-semibold text-slate-600">
            <span class="text-slate-400 font-bold uppercase text-[10px] tracking-wider">Legend:</span>
            <div class="flex items-center gap-1.5">
                <span class="w-3.5 h-3.5 rounded bg-emerald-500 inline-block shadow-xs"></span>
                <span>Checked-In</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="w-3.5 h-3.5 rounded bg-blue-500 inline-block shadow-xs"></span>
                <span>Confirmed</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="w-3.5 h-3.5 rounded bg-amber-500 inline-block shadow-xs"></span>
                <span>Pending Approval</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="w-3.5 h-3.5 rounded bg-slate-200 border border-slate-300 inline-block shadow-xs"></span>
                <span>Available (Click + to Book)</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="w-3.5 h-3.5 rounded bg-rose-200 border border-rose-300 inline-block shadow-xs"></span>
                <span>Maintenance / Cleaning</span>
            </div>
        </div>
    </div>

    <!-- Unassigned Bookings Banner (If Any) -->
    @if(count($unassignedBookings) > 0)
        <div class="bg-amber-50 border border-amber-300 text-amber-900 p-5 rounded-3xl shadow-sm">
            <div class="flex items-center gap-2 mb-2">
                <i class="fa-solid fa-triangle-exclamation text-amber-600 text-lg"></i>
                <h4 class="font-bold text-sm">Action Needed: {{ count($unassignedBookings) }} Booking(s) Without Physical Room Assignment</h4>
            </div>
            <p class="text-xs text-amber-800 mb-3">
                These reservations were submitted online and need staff to assign an available physical room number.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($unassignedBookings as $ub)
                    <div class="bg-white/90 p-3 rounded-2xl border border-amber-200 flex items-center justify-between text-xs">
                        <div>
                            <span class="font-bold font-mono text-brand-900">{{ $ub->booking_code }}</span>
                            <div class="font-semibold text-slate-800">{{ $ub->guest_name }}</div>
                            <div class="text-[11px] text-slate-500">
                                {{ $ub->roomType->name }} &bull; {{ \Carbon\Carbon::parse($ub->check_in_date)->format('M d') }} - {{ \Carbon\Carbon::parse($ub->check_out_date)->format('M d') }}
                            </div>
                        </div>
                        <a href="{{ route('admin.bookings.edit', $ub->id) }}" class="bg-amber-600 hover:bg-amber-700 text-white font-bold px-3 py-1.5 rounded-lg text-xs transition">
                            Assign Room &rarr;
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Visual Timeline Grid -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[900px]">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-700 text-xs">
                        <!-- Sticky Room Column Header -->
                        <th class="py-3.5 px-4 font-bold uppercase tracking-wider sticky left-0 z-20 bg-slate-100 min-w-[200px] shadow-[2px_0_5px_rgba(0,0,0,0.04)] border-r border-slate-200">
                            Room & Category
                        </th>
                        <!-- Date Headers -->
                        @foreach($dates as $date)
                            @php
                                $isToday = $date->isToday();
                                $isWeekend = $date->isWeekend();
                            @endphp
                            <th class="py-3 px-2 text-center min-w-[100px] border-r border-slate-200 {{ $isToday ? 'bg-gold-50 font-bold text-brand-900' : ($isWeekend ? 'bg-slate-100/70 text-slate-600' : 'bg-slate-50 text-slate-700') }}">
                                <div class="text-[10px] uppercase font-bold {{ $isToday ? 'text-gold-700' : 'text-slate-400' }}">
                                    {{ $date->format('D') }}
                                </div>
                                <div class="text-sm font-extrabold font-mono {{ $isToday ? 'text-brand-900 underline' : 'text-slate-800' }}">
                                    {{ $date->format('d M') }}
                                </div>
                                @if($isToday)
                                    <span class="inline-block bg-brand-900 text-gold-400 text-[9px] font-bold px-1.5 py-0.2 rounded-full mt-0.5">
                                        TODAY
                                    </span>
                                @endif
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($rooms as $room)
                        @php
                            $roomStatusBadge = [
                                'available' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                                'occupied' => 'bg-blue-50 text-blue-700 border border-blue-200',
                                'cleaning' => 'bg-amber-50 text-amber-700 border border-amber-200',
                                'maintenance' => 'bg-rose-50 text-rose-700 border border-rose-200',
                            ];
                        @endphp
                        <tr class="hover:bg-slate-50/50 transition">
                            <!-- Sticky Room Info Cell -->
                            <td class="py-3 px-4 sticky left-0 z-10 bg-white shadow-[2px_0_5px_rgba(0,0,0,0.04)] border-r border-slate-200">
                                <div class="flex items-center justify-between gap-2">
                                    <div class="font-bold font-serif text-slate-900 text-sm">
                                        Room {{ $room->room_number }}
                                    </div>
                                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded uppercase {{ $roomStatusBadge[$room->status] ?? 'bg-slate-100 text-slate-600' }}">
                                        {{ $room->status }}
                                    </span>
                                </div>
                                <div class="text-[11px] text-slate-500 font-medium truncate max-w-[170px]" title="{{ $room->roomType->name }}">
                                    {{ $room->roomType->name }}
                                </div>
                                @if($room->floor_wing)
                                    <div class="text-[10px] text-slate-400">
                                        <i class="fa-solid fa-location-dot text-[9px]"></i> {{ $room->floor_wing }}
                                    </div>
                                @endif
                            </td>

                            <!-- Date Schedule Cells -->
                            @foreach($dates as $date)
                                @php
                                    $dStr = $date->format('Y-m-d');
                                    $dayBookings = $schedule[$room->id][$dStr] ?? [];
                                    $isToday = $date->isToday();
                                @endphp
                                <td class="p-1.5 align-top text-center border-r border-slate-200 {{ $isToday ? 'bg-gold-50/20' : '' }} min-h-[64px]">
                                    @if(count($dayBookings) > 0)
                                        <!-- Room Booked for this date -->
                                        <div class="space-y-1.5">
                                            @foreach($dayBookings as $b)
                                                @php
                                                    $isCheckIn = ($b->check_in_date === $dStr);
                                                    $isCheckOut = ($b->check_out_date === $dStr);
                                                    $colorClasses = match($b->booking_status) {
                                                        'checked_in' => 'bg-emerald-600 text-white hover:bg-emerald-700',
                                                        'confirmed' => 'bg-blue-600 text-white hover:bg-blue-700',
                                                        'pending' => 'bg-amber-500 text-white hover:bg-amber-600',
                                                        default => 'bg-slate-600 text-white'
                                                    };
                                                @endphp
                                                <a href="{{ route('admin.bookings.show', $b->id) }}" 
                                                   title="{{ $b->guest_name }} ({{ $b->booking_code }})&#10;{{ $b->check_in_date }} {{ $b->check_in_time }} to {{ $b->check_out_date }} {{ $b->check_out_time }}&#10;Status: {{ ucfirst($b->booking_status) }}"
                                                   class="block p-1.5 rounded-xl text-[10px] font-semibold transition text-left shadow-xs {{ $colorClasses }}">
                                                    <div class="truncate font-bold leading-tight">
                                                        {{ $b->guest_name }}
                                                    </div>
                                                    <div class="text-[9px] opacity-90 font-mono truncate">
                                                        {{ $b->booking_code }}
                                                    </div>
                                                    @if($isCheckIn)
                                                        <div class="text-[8px] bg-black/25 px-1 rounded inline-block mt-0.5">
                                                            &darr; In {{ $b->check_in_time ?? '14:00' }}
                                                        </div>
                                                    @elseif($isCheckOut)
                                                        <div class="text-[8px] bg-black/25 px-1 rounded inline-block mt-0.5">
                                                            &uarr; Out {{ $b->check_out_time ?? '11:00' }}
                                                        </div>
                                                    @endif
                                                </a>
                                            @endforeach
                                        </div>
                                    @elseif($room->status === 'maintenance')
                                        <!-- Maintenance cell -->
                                        <div class="py-2 text-[10px] text-rose-500 font-semibold bg-rose-50/60 rounded-xl" title="Room in maintenance">
                                            <i class="fa-solid fa-wrench"></i> Maint.
                                        </div>
                                    @elseif($room->status === 'cleaning')
                                        <!-- Cleaning cell -->
                                        <div class="py-2 text-[10px] text-amber-600 font-semibold bg-amber-50/60 rounded-xl" title="Room being cleaned">
                                            <i class="fa-solid fa-broom"></i> Clean
                                        </div>
                                    @else
                                        <!-- Room Available on this date -->
                                        <a href="{{ route('admin.bookings.create', ['room_id' => $room->id, 'check_in_date' => $dStr]) }}"
                                           title="Room is Free! Click to reserve Room {{ $room->room_number }} for {{ $date->format('M d, Y') }}"
                                           class="group h-full min-h-[50px] w-full flex flex-col items-center justify-center p-2 rounded-xl text-slate-300 hover:text-emerald-700 hover:bg-emerald-50 transition border border-transparent hover:border-emerald-200">
                                            <i class="fa-solid fa-plus text-xs group-hover:scale-125 transition-transform text-slate-300 group-hover:text-emerald-600"></i>
                                            <span class="text-[9px] font-bold text-slate-400 group-hover:text-emerald-700 mt-0.5">Free</span>
                                        </a>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($dates) + 1 }}" class="py-12 text-center text-slate-400 text-sm">
                                No physical rooms found. <a href="{{ route('admin.rooms.index') }}" class="text-brand-700 font-bold underline">Add rooms first</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
