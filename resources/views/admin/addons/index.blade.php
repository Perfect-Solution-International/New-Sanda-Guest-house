@extends('admin.layouts.app')

@section('title', 'Safari & Tour Addons - Admin')
@section('page_title', 'Tour Packages & Resort Add-ons')

@section('content')
<div class="space-y-6" x-data="{ addModal: false, editModal: false, editAddon: {} }">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <p class="text-xs text-slate-500">Configure Yala Safari packages, BBQ dinners, Pooja transports, and guest extra services.</p>
        <button @click="addModal = true" class="bg-brand-700 hover:bg-brand-800 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow transition flex items-center gap-2">
            <i class="fa-solid fa-plus text-gold-400"></i> New Tour / Addon
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($addons as $addon)
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200 flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-gift"></i>
                        </div>
                        <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded {{ $addon->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                            {{ $addon->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <h3 class="font-serif font-bold text-lg text-slate-900 mb-1">{{ $addon->name }}</h3>
                    <p class="text-xs text-slate-500 mb-4 line-clamp-2">{{ $addon->description }}</p>

                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-500 uppercase tracking-wider font-semibold text-[10px]">Pricing</span>
                        <div>
                            <strong class="text-brand-900 text-sm">Rs. {{ number_format($addon->price) }}</strong>
                            <span class="text-slate-400 text-[10px]">/ {{ str_replace('_', ' ', $addon->price_type) }}</span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 mt-4 flex items-center justify-between">
                    <button @click="editAddon = {{ json_encode($addon) }}; editModal = true" class="text-xs font-bold text-brand-700 hover:text-brand-900">
                        Edit
                    </button>
                    <form action="{{ route('admin.addons.destroy', $addon->id) }}" method="POST" onsubmit="return confirm('Delete addon?');">
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

    <!-- Create Addon Modal -->
    <div x-show="addModal" x-cloak class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl">
            <h3 class="font-serif font-bold text-xl text-slate-900 mb-4">Add Tour / Package Addon</h3>
            <form action="{{ route('admin.addons.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Addon Name *</label>
                    <input type="text" name="name" required placeholder="e.g. Yala Safari Half-Day Jeep" class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Price (Rs.) *</label>
                    <input type="number" step="0.01" name="price" required class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Pricing Model *</label>
                    <select name="price_type" required class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm bg-white">
                        <option value="per_booking">Per Booking (Fixed Total)</option>
                        <option value="per_person">Per Person</option>
                        <option value="per_night">Per Night</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Description</label>
                    <textarea name="description" rows="3" class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm" placeholder="Inclusions, duration, jeep details..."></textarea>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" checked class="rounded text-brand-700">
                    <label class="text-xs font-medium text-slate-700">Available for Online Booking</label>
                </div>
                <div class="flex justify-end gap-3 pt-3">
                    <button type="button" @click="addModal = false" class="text-xs font-bold text-slate-500 px-4 py-2">Cancel</button>
                    <button type="submit" class="bg-brand-700 text-white font-bold px-6 py-2 rounded-xl text-xs">Save Addon</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Addon Modal -->
    <div x-show="editModal" x-cloak class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl">
            <h3 class="font-serif font-bold text-xl text-slate-900 mb-4">Edit Addon</h3>
            <form :action="'{{ url('admin/addons') }}/' + editAddon.id" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Addon Name *</label>
                    <input type="text" name="name" x-model="editAddon.name" required class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Price (Rs.) *</label>
                    <input type="number" step="0.01" name="price" x-model="editAddon.price" required class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Pricing Model *</label>
                    <select name="price_type" x-model="editAddon.price_type" required class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm bg-white">
                        <option value="per_booking">Per Booking (Fixed Total)</option>
                        <option value="per_person">Per Person</option>
                        <option value="per_night">Per Night</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Description</label>
                    <textarea name="description" x-model="editAddon.description" rows="3" class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm"></textarea>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" :checked="editAddon.is_active" class="rounded text-brand-700">
                    <label class="text-xs font-medium text-slate-700">Available for Online Booking</label>
                </div>
                <div class="flex justify-end gap-3 pt-3">
                    <button type="button" @click="editModal = false" class="text-xs font-bold text-slate-500 px-4 py-2">Cancel</button>
                    <button type="submit" class="bg-brand-700 text-white font-bold px-6 py-2 rounded-xl text-xs">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
