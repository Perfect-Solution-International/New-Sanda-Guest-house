@extends('admin.layouts.app')

@section('title', 'Guest Reviews - Admin')
@section('page_title', 'Guest Testimonials & Reviews')

@section('content')
<div class="space-y-6" x-data="{ addModal: false }">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <p class="text-xs text-slate-500">Manage reviews displayed on the public resort website homepage.</p>
        <button @click="addModal = true" class="bg-brand-700 hover:bg-brand-800 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow transition flex items-center gap-2">
            <i class="fa-solid fa-plus text-gold-400"></i> Add Testimonial
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($reviews as $review)
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex text-gold-500 text-xs">
                            @for($i = 0; $i < $review->rating; $i++)
                                <i class="fa-solid fa-star"></i>
                            @endfor
                        </div>
                        <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded {{ $review->is_approved ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                            {{ $review->is_approved ? 'Approved' : 'Hidden' }}
                        </span>
                    </div>

                    <p class="text-xs text-slate-700 italic leading-relaxed mb-4">"{{ $review->comment }}"</p>

                    <div class="text-xs">
                        <strong class="text-slate-900 block">{{ $review->guest_name }}</strong>
                        <span class="text-slate-500">{{ $review->guest_location ?? 'Sri Lanka' }} • {{ $review->stay_date }}</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 mt-4 flex items-center justify-between">
                    <form action="{{ route('admin.reviews.toggle', $review->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-xs font-bold text-brand-700 hover:underline">
                            {{ $review->is_approved ? 'Hide from Site' : 'Approve & Show' }}
                        </button>
                    </form>
                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Delete review?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs font-bold text-rose-600 hover:text-rose-800">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Create Review Modal -->
    <div x-show="addModal" x-cloak class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl">
            <h3 class="font-serif font-bold text-xl text-slate-900 mb-4">Add Guest Review</h3>
            <form action="{{ route('admin.reviews.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Guest / Family Name *</label>
                    <input type="text" name="guest_name" required placeholder="e.g. Asanka & Family" class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Location</label>
                    <input type="text" name="guest_location" placeholder="e.g. Colombo, Sri Lanka" class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Stay Period</label>
                    <input type="text" name="stay_date" placeholder="e.g. November 2026" class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Rating *</label>
                    <select name="rating" required class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm bg-white">
                        <option value="5">5 Stars (Excellent)</option>
                        <option value="4">4 Stars (Very Good)</option>
                        <option value="3">3 Stars (Good)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Review Comment *</label>
                    <textarea name="comment" rows="3" required class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm"></textarea>
                </div>
                <div class="flex justify-end gap-3 pt-3">
                    <button type="button" @click="addModal = false" class="text-xs font-bold text-slate-500 px-4 py-2">Cancel</button>
                    <button type="submit" class="bg-brand-700 text-white font-bold px-6 py-2 rounded-xl text-xs">Save Review</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
