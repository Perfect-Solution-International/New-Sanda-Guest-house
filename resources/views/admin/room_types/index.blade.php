@extends('admin.layouts.app')

@section('title', 'Room Categories - Admin')
@section('page_title', 'Room Categories & Cabanas')

@section('content')
<div class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <p class="text-xs text-slate-500">Manage categories, nightly rates, bed capacities, and featured showcases.</p>
        <a href="{{ route('admin.room-types.create') }}" class="bg-brand-700 hover:bg-brand-800 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow transition flex items-center gap-2">
            <i class="fa-solid fa-plus text-gold-400"></i> Add Room Category
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($roomTypes as $rt)
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-200 flex flex-col justify-between">
                <div>
                    <div class="relative h-48">
                        <img src="{{ $rt->image }}" alt="{{ $rt->name }}" class="w-full h-full object-cover">
                        <div class="absolute top-3 right-3 bg-brand-900/80 backdrop-blur-md text-gold-400 font-bold text-xs px-3 py-1 rounded-full">
                            Rs. {{ number_format($rt->base_price_per_night) }}
                        </div>
                    </div>

                    <div class="p-6 space-y-3">
                        <div class="flex items-center justify-between">
                            <h3 class="font-serif font-bold text-lg text-slate-900">{{ $rt->name }}</h3>
                            <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded {{ $rt->status == 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                                {{ $rt->status }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 line-clamp-2">{{ $rt->short_description }}</p>
                        <div class="text-xs text-slate-600 flex items-center gap-4">
                            <span><i class="fa-solid fa-bed text-brand-700 mr-1"></i> {{ $rt->bed_type }}</span>
                            <span><i class="fa-solid fa-door-open text-brand-700 mr-1"></i> {{ $rt->rooms_count }} physical rooms</span>
                        </div>
                    </div>
                </div>

                <div class="p-6 pt-0 border-t border-slate-100 mt-4 flex items-center justify-between">
                    <a href="{{ route('admin.room-types.edit', $rt->id) }}" class="text-xs font-bold text-brand-700 hover:text-brand-900">
                        <i class="fa-solid fa-pen-to-square mr-1"></i> Edit Category
                    </a>
                    <form action="{{ route('admin.room-types.destroy', $rt->id) }}" method="POST" onsubmit="return confirm('Delete this room category?');">
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
</div>
@endsection
