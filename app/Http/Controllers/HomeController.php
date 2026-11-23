<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Inquiry;
use App\Models\Review;
use App\Models\RoomType;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredRooms = RoomType::with('amenities')
            ->where('status', 'active')
            ->orderBy('is_featured', 'desc')
            ->get();

        $reviews = Review::where('is_approved', true)->latest()->take(6)->get();
        $resortAmenities = Amenity::where('category', 'resort')->take(8)->get();
        $settings = Setting::pluck('value', 'key');

        return view('public.home', compact('featuredRooms', 'reviews', 'resortAmenities', 'settings'));
    }

    public function about(): View
    {
        $settings = Setting::pluck('value', 'key');
        return view('public.about', compact('settings'));
    }

    public function facilities(): View
    {
        $amenities = Amenity::all();
        $settings = Setting::pluck('value', 'key');
        return view('public.facilities', compact('amenities', 'settings'));
    }

    public function gallery(): View
    {
        $roomTypes = RoomType::where('status', 'active')->get();
        return view('public.gallery', compact('roomTypes'));
    }

    public function contact(): View
    {
        $settings = Setting::pluck('value', 'key');
        return view('public.contact', compact('settings'));
    }

    public function submitInquiry(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        Inquiry::create($validated);

        return redirect()->route('contact')->with('success', 'Thank you! Your message has been sent to New Sanda. Our team will contact you shortly.');
    }
}
