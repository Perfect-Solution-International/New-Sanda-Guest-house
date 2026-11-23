<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoomAdminController extends Controller
{
    public function index(Request $request): View
    {
        $query = Room::with('roomType');

        if ($request->filled('type_id')) {
            $query->where('room_type_id', $request->type_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $rooms = $query->orderBy('room_number')->get();
        $roomTypes = RoomType::all();

        return view('admin.rooms.index', compact('rooms', 'roomTypes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'room_number' => 'required|string|max:50|unique:rooms,room_number',
            'floor_wing' => 'nullable|string|max:100',
            'status' => 'required|in:available,occupied,cleaning,maintenance',
            'notes' => 'nullable|string',
        ]);

        Room::create($validated);
        return redirect()->route('admin.rooms.index')->with('success', "Room {$validated['room_number']} created successfully!");
    }

    public function update(Request $request, Room $room): RedirectResponse
    {
        $validated = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'room_number' => 'required|string|max:50|unique:rooms,room_number,' . $room->id,
            'floor_wing' => 'nullable|string|max:100',
            'status' => 'required|in:available,occupied,cleaning,maintenance',
            'notes' => 'nullable|string',
        ]);

        $room->update($validated);
        return redirect()->route('admin.rooms.index')->with('success', "Room {$room->room_number} updated!");
    }

    public function destroy(Room $room): RedirectResponse
    {
        $num = $room->room_number;
        $room->delete();
        return redirect()->route('admin.rooms.index')->with('success', "Room {$num} removed.");
    }
}
