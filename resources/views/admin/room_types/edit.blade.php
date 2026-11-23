@extends('admin.layouts.app')

@section('title', 'Edit Category - ' . $roomType->name)
@section('page_title', 'Edit Room Category')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-3xl shadow-sm border border-slate-200">
    <form action="{{ route('admin.room-types.update', $roomType->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Category Name *</label>
                <input type="text" name="name" value="{{ $roomType->name }}" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Base Price Per Night (Rs.) *</label>
                <input type="number" step="0.01" name="base_price_per_night" value="{{ $roomType->base_price_per_night }}" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Max Adults *</label>
                <input type="number" name="max_adults" value="{{ $roomType->max_adults }}" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Max Children *</label>
                <input type="number" name="max_children" value="{{ $roomType->max_children }}" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Bed Configuration *</label>
                <input type="text" name="bed_type" value="{{ $roomType->bed_type }}" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Room Area Size *</label>
                <input type="text" name="room_size" value="{{ $roomType->room_size }}" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm">
            </div>
            <div class="sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Main Cover Photo URL</label>
                <input type="text" name="image" value="{{ $roomType->image }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm">
            </div>
            <div class="sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Short Description *</label>
                <input type="text" name="short_description" value="{{ $roomType->short_description }}" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm">
            </div>
            <div class="sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Full Detailed Description *</label>
                <textarea name="description" rows="4" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm">{{ $roomType->description }}</textarea>
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Amenities</label>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                @php $assignedIds = $roomType->amenities->pluck('id')->toArray(); @endphp
                @foreach($amenities as $am)
                    <label class="flex items-center gap-2 p-2 border border-slate-200 rounded-lg text-xs cursor-pointer hover:bg-slate-50">
                        <input type="checkbox" name="amenities[]" value="{{ $am->id }}" {{ in_array($am->id, $assignedIds) ? 'checked' : '' }} class="rounded text-brand-700">
                        <span>{{ $am->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="flex items-center gap-6 pt-4 border-t border-slate-100">
            <label class="flex items-center text-sm font-medium text-slate-700">
                <input type="checkbox" name="is_featured" value="1" {{ $roomType->is_featured ? 'checked' : '' }} class="rounded text-brand-700 mr-2"> Highlight on Homepage
            </label>
            <div class="flex items-center gap-2 text-sm">
                <label class="text-xs font-bold uppercase text-slate-500">Status:</label>
                <select name="status" class="border border-slate-300 rounded-lg px-2 py-1 text-xs bg-white">
                    <option value="active" {{ $roomType->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $roomType->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>

        <div class="flex justify-between items-center pt-4">
            <a href="{{ route('admin.room-types.index') }}" class="text-xs font-bold text-slate-500">Cancel</a>
            <button type="submit" class="bg-brand-700 text-white font-bold px-6 py-2.5 rounded-xl text-xs">Update Category</button>
        </div>
    </form>
</div>
@endsection
