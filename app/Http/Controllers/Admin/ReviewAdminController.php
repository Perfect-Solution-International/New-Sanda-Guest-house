<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewAdminController extends Controller
{
    public function index(): View
    {
        $reviews = Review::latest()->paginate(20);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'guest_name' => 'required|string|max:255',
            'guest_location' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
            'stay_date' => 'nullable|string|max:100',
        ]);

        $validated['is_approved'] = true;
        Review::create($validated);

        return redirect()->route('admin.reviews.index')->with('success', 'Review added successfully!');
    }

    public function toggleApproval(Review $review): RedirectResponse
    {
        $review->update(['is_approved' => !$review->is_approved]);
        return back()->with('success', 'Review status updated.');
    }

    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();
        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted.');
    }
}
