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
        $categorySuggestions = $this->categorySuggestions();
        return view('admin.room_types.create', compact('amenities', 'categorySuggestions'));
    }

    /**
     * @return list<string>
     */
    private function categorySuggestions(): array
    {
        $presets = [
            'Standard A/C Double Room',
            'Budget Non-A/C Double Room',
            'Family A/C Room (4-5 Guests)',
            'Family Non-A/C Room (Budget Group)',
            'Deluxe Family Villa',
            'Superior Double Room',
            'Triple A/C Room',
        ];

        return RoomType::query()
            ->pluck('name')
            ->merge($presets)
            ->unique()
            ->values()
            ->all();
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
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif|max:10240',
            'gallery_files' => 'nullable|array',
            'gallery_files.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif|max:10240',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|in:active,inactive',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . rand(100, 999);
        $validated['is_featured'] = $request->has('is_featured');

        // Handle uploaded cover photo
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/rooms'), $filename);
            $validated['image'] = asset('uploads/rooms/' . $filename);
        } elseif ($request->filled('image')) {
            $validated['image'] = $request->input('image');
        } else {
            $validated['image'] = 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80';
        }

        // Handle uploaded gallery photos
        if ($request->hasFile('gallery_files')) {
            $galleryUrls = [];
            foreach ($request->file('gallery_files') as $gFile) {
                if ($gFile && $gFile->isValid()) {
                    $gFilename = time() . '_' . uniqid() . '.' . $gFile->getClientOriginalExtension();
                    $gFile->move(public_path('uploads/rooms'), $gFilename);
                    $galleryUrls[] = asset('uploads/rooms/' . $gFilename);
                }
            }
            if (!empty($galleryUrls)) {
                $validated['gallery'] = $galleryUrls;
            }
        }

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
        $categorySuggestions = $this->categorySuggestions();
        return view('admin.room_types.edit', compact('roomType', 'amenities', 'categorySuggestions'));
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
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif|max:10240',
            'gallery_files' => 'nullable|array',
            'gallery_files.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif|max:10240',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|in:active,inactive',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
        ]);

        $validated['is_featured'] = $request->has('is_featured');

        // Handle uploaded cover photo
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/rooms'), $filename);
            $validated['image'] = asset('uploads/rooms/' . $filename);
        } elseif ($request->filled('image')) {
            $validated['image'] = $request->input('image');
        } else {
            $validated['image'] = $roomType->image;
        }

        // Handle uploaded gallery photos
        if ($request->hasFile('gallery_files')) {
            $existingGallery = is_array($roomType->gallery) ? $roomType->gallery : [];
            foreach ($request->file('gallery_files') as $gFile) {
                if ($gFile && $gFile->isValid()) {
                    $gFilename = time() . '_' . uniqid() . '.' . $gFile->getClientOriginalExtension();
                    $gFile->move(public_path('uploads/rooms'), $gFilename);
                    $existingGallery[] = asset('uploads/rooms/' . $gFilename);
                }
            }
            $validated['gallery'] = $existingGallery;
        }

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
