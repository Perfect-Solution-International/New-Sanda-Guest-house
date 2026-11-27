@extends('admin.layouts.app')

@section('title', 'Physical Rooms & Units - Admin')
@section('page_title', 'Physical Rooms & Housekeeping Status')

@section('content')
<div class="space-y-6" x-data="{ newModal: false, editModal: false, editRoom: {} }">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <p class="text-xs text-slate-500">Track and assign individual physical rooms across Villa, Cabana, and Suite wings.</p>
        <button @click="newModal = true" class="bg-brand-700 hover:bg-brand-800 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow transition flex items-center gap-2">
            <i class="fa-solid fa-plus text-gold-400"></i> Add Room Unit
        </button>
    </div>

    <!-- Rooms Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-6">Room Number</th>
                        <th class="py-3.5 px-6">Category</th>
                        <th class="py-3.5 px-6">Wing / Floor</th>
                        <th class="py-3.5 px-6">Current Status</th>
                        <th class="py-3.5 px-6">Notes</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($rooms as $room)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-4 px-6 font-mono font-bold text-slate-900 text-base">
                                {{ $room->room_number }}
                            </td>
                            <td class="py-4 px-6 font-semibold text-slate-800 text-xs">
                                {{ $room->roomType->name }}
                            </td>
                            <td class="py-4 px-6 text-xs text-slate-600">
                                {{ $room->floor_wing ?? 'Main Compound' }}
                            </td>
                            <td class="py-4 px-6">
                                @php
                                    $statusStyle = [
                                        'available' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                        'occupied' => 'bg-rose-100 text-rose-800 border-rose-200',
                                        'cleaning' => 'bg-amber-100 text-amber-800 border-amber-200',
                                        'maintenance' => 'bg-slate-100 text-slate-700 border-slate-300',
                                    ];
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase border {{ $statusStyle[$room->status] ?? 'bg-slate-100' }}">
                                    {{ $room->status === 'occupied' ? 'Booked / Occupied' : $room->status }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-xs text-slate-500">
                                {{ $room->notes ?? '-' }}
                            </td>
                            <td class="py-4 px-6 text-right space-x-2 whitespace-nowrap">
                                <form action="{{ route('admin.rooms.toggle-status', $room->id) }}" method="POST" class="inline">
                                    @csrf
                                    @if($room->status === 'available')
                                        <button type="submit" class="text-[11px] font-bold px-2.5 py-1 rounded-lg bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 transition">
                                            Mark Booked
                                        </button>
                                    @else
                                        <button type="submit" class="text-[11px] font-bold px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 transition">
                                            Mark Available
                                        </button>
                                    @endif
                                </form>
                                <button @click="editRoom = {{ json_encode($room) }}; editModal = true" class="text-xs font-bold text-brand-700 hover:text-brand-900">
                                    Edit
                                </button>
                                <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete room unit {{ $room->room_number }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-bold text-rose-600 hover:text-rose-800">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">No rooms registered.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create Room Modal -->
    <div x-show="newModal" x-cloak class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl">
            <h3 class="font-serif font-bold text-xl text-slate-900 mb-4">Add Physical Room</h3>
            <form action="{{ route('admin.rooms.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Room Number *</label>
                    <input type="text" name="room_number" required placeholder="e.g. VILLA-104 or CABANA-205" class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-brand-700">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Room Category *</label>
                    <select name="room_type_id" required class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm bg-white">
                        @foreach($roomTypes as $rt)
                            <option value="{{ $rt->id }}">{{ $rt->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Wing / Location</label>
                    <input type="text" name="floor_wing" placeholder="e.g. Poolside Wing, Garden Cabana Lawn" class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Status *</label>
                    <select name="status" required class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm bg-white">
                        <option value="available">Available (Clean &amp; Ready)</option>
                        <option value="occupied">Booked / Occupied</option>
                        <option value="cleaning">Cleaning / Housekeeping</option>
                        <option value="maintenance">Maintenance</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Notes</label>
                    <input type="text" name="notes" placeholder="e.g. Near pool gate" class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm">
                </div>

                <div class="flex justify-end gap-3 pt-3">
                    <button type="button" @click="newModal = false" class="text-xs font-bold text-slate-500 px-4 py-2">Cancel</button>
                    <button type="submit" class="bg-brand-700 text-white font-bold px-6 py-2 rounded-xl text-xs">Save Room</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Room Modal -->
    <div x-show="editModal" x-cloak class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl">
            <h3 class="font-serif font-bold text-xl text-slate-900 mb-4">Edit Room <span x-text="editRoom.room_number"></span></h3>
            <form :action="'{{ url('admin/rooms') }}/' + editRoom.id" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Room Number *</label>
                    <input type="text" name="room_number" x-model="editRoom.room_number" required class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Room Category *</label>
                    <select name="room_type_id" x-model="editRoom.room_type_id" required class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm bg-white">
                        @foreach($roomTypes as $rt)
                            <option value="{{ $rt->id }}">{{ $rt->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Wing / Location</label>
                    <input type="text" name="floor_wing" x-model="editRoom.floor_wing" class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Status *</label>
                    <select name="status" x-model="editRoom.status" required class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm bg-white">
                        <option value="available">Available (Clean &amp; Ready)</option>
                        <option value="occupied">Booked / Occupied</option>
                        <option value="cleaning">Cleaning / Housekeeping</option>
                        <option value="maintenance">Maintenance</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Notes</label>
                    <input type="text" name="notes" x-model="editRoom.notes" class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm">
                </div>

                <div class="flex justify-end gap-3 pt-3">
                    <button type="button" @click="editModal = false" class="text-xs font-bold text-slate-500 px-4 py-2">Cancel</button>
                    <button type="submit" class="bg-brand-700 text-white font-bold px-6 py-2 rounded-xl text-xs">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
