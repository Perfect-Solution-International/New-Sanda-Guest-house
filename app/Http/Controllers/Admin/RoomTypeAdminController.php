<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\RoomType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RoomTypeAdminController extends Controller
{
    public function index(): View
    {
        $roomTypes = RoomType::withCount('rooms')->get();
        return view('admin.room_types.index', compact('roomTypes'));
    }

    public function create(): View
    {
        $amenities = Amenity::all();
        return view('admin.room_types.create', compact('amenities'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'base_price_per_night' => 'required|numeric|min:0',
            'max_adults' => 'required|integer|min:1',
            'max_children' => 'required|integer|min:0',
            'bed_type' => 'required|string|max:255',
            'room_size' => 'required|string|max:100',
            'image' => 'nullable|string|max:500',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|in:active,inactive',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . rand(100, 999);
        $validated['is_featured'] = $request->has('is_featured');

        $roomType = RoomType::create($validated);

        if (!empty($validated['amenities'])) {
            $roomType->amenities()->sync($validated['amenities']);
        }

        return redirect()->route('admin.room-types.index')->with('success', 'Room category added successfully!');
    }

    public function edit(RoomType $roomType): View
    {
        $amenities = Amenity::all();
        $roomType->load('amenities');
        return view('admin.room_types.edit', compact('roomType', 'amenities'));
    }

    public function update(Request $request, RoomType $roomType): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'base_price_per_night' => 'required|numeric|min:0',
            'max_adults' => 'required|integer|min:1',
            'max_children' => 'required|integer|min:0',
            'bed_type' => 'required|string|max:255',
            'room_size' => 'required|string|max:100',
            'image' => 'nullable|string|max:500',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|in:active,inactive',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
        ]);

        $validated['is_featured'] = $request->has('is_featured');
        $roomType->update($validated);

        if (isset($validated['amenities'])) {
            $roomType->amenities()->sync($validated['amenities']);
        } else {
            $roomType->amenities()->detach();
        }

        return redirect()->route('admin.room-types.index')->with('success', 'Room category updated successfully!');
    }

    public function destroy(RoomType $roomType): RedirectResponse
    {
        $roomType->delete();
        return redirect()->route('admin.room-types.index')->with('success', 'Room category deleted.');
    }
}
