<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoomController extends Controller
{
    public function index(Request $request): View
    {
        $query = RoomType::with(['amenities', 'rooms'])->where('status', 'active');

        if ($request->filled('guests')) {
            $guests = (int) $request->guests;
            $query->where('max_adults', '>=', $guests);
        }

        if ($request->filled('min_price')) {
            $query->where('base_price_per_night', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('base_price_per_night', '<=', $request->max_price);
        }

        $rooms = $query->orderBy('base_price_per_night', 'asc')->get();

        return view('public.rooms.index', compact('rooms'));
    }

    public function show(string $slug): View
    {
        $room = RoomType::with(['amenities', 'rooms' => function ($q) {
            $q->where('status', 'available');
        }])->where('slug', $slug)->firstOrFail();

        $otherRooms = RoomType::where('id', '!=', $room->id)
            ->where('status', 'active')
            ->take(3)
            ->get();

        return view('public.rooms.show', compact('room', 'otherRooms'));
    }
}
