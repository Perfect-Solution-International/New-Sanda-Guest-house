@extends('admin.layouts.app')

@section('title', 'Add Room Category - Admin')
@section('page_title', 'Create New Room Category')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-3xl shadow-sm border border-slate-200">
    <form action="{{ route('admin.room-types.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="relative"
                 x-data="{
                     open: false,
                     value: @js(old('name', '')),
                     options: @js($categorySuggestions),
                     get filtered() {
                         if (!this.value) return this.options;
                         const q = this.value.toLowerCase();
                         return this.options.filter(o => o.toLowerCase().includes(q));
                     }
                 }"
                 @click.away="open = false">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Category Name *</label>
                <div class="relative">
                    <input type="text"
                           name="name"
                           x-model="value"
                           @focus="open = true"
                           @keydown.escape="open = false"
                           autocomplete="off"
                           required
                           placeholder="Select or type (e.g. Deluxe Family Villa)"
                           class="w-full border border-slate-300 rounded-xl pl-4 pr-10 py-2.5 text-sm focus:ring-2 focus:ring-brand-600 focus:outline-none">
                    <button type="button"
                            @click="open = !open"
                            class="absolute inset-y-0 right-0 px-3 flex items-center text-slate-400 hover:text-slate-700"
                            title="Show category options">
                        <i class="fa-solid fa-chevron-down text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                </div>
                <div x-show="open"
                     x-cloak
                     class="absolute z-30 mt-1 w-full bg-white border border-slate-200 rounded-xl shadow-lg max-h-52 overflow-y-auto py-1">
                    <template x-for="opt in (filtered.length ? filtered : options)" :key="opt">
                        <button type="button"
                                @click="value = opt; open = false"
                                class="w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-brand-50 hover:text-brand-800 transition flex items-center justify-between">
                            <span x-text="opt"></span>
                            <i x-show="value === opt" class="fa-solid fa-check text-xs text-brand-600"></i>
                        </button>
                    </template>
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Base Price Per Night (Rs.) *</label>
                <input type="number" step="0.01" name="base_price_per_night" value="{{ old('base_price_per_night') }}" required placeholder="e.g. 25000" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Max Adults Capacity *</label>
                <input type="number" name="max_adults" value="{{ old('max_adults', 2) }}" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Max Children Capacity *</label>
                <input type="number" name="max_children" value="{{ old('max_children', 2) }}" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Bed Configuration *</label>
                <input type="text" name="bed_type" value="{{ old('bed_type', '1 King Bed') }}" required placeholder="e.g. 2 King Beds + 1 Single Bed" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Room Area Size *</label>
                <input type="text" name="room_size" value="{{ old('room_size', '450 sq ft') }}" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm">
            </div>

            <!-- Main Cover Photo Upload & URL -->
            <div class="sm:col-span-2 space-y-3 p-5 bg-slate-50 border border-slate-200 rounded-2xl">
                <div class="flex items-center justify-between">
                    <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider">
                        Main Cover Photo *
                    </label>
                    <span class="text-[11px] text-slate-500">File upload or URL</span>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                    <div>
                        <label for="image_file" class="flex flex-col items-center justify-center p-5 border-2 border-dashed border-brand-300 hover:border-brand-700 rounded-2xl cursor-pointer bg-white transition text-center group shadow-sm">
                            <i class="fa-solid fa-cloud-arrow-up text-3xl text-brand-600 group-hover:scale-110 transition mb-2"></i>
                            <span class="text-xs font-bold text-slate-800">Choose Image from Device</span>
                            <span class="text-[11px] text-slate-500 mt-0.5">Click to browse PNG, JPG, WEBP</span>
                            <input type="file" name="image_file" id="image_file" accept="image/*" class="hidden" onchange="previewMainImage(this)">
                        </label>
                    </div>

                    <!-- Live Image Preview Container -->
                    <div id="mainImagePreviewContainer" class="relative rounded-2xl overflow-hidden border border-slate-200 bg-white h-36 flex items-center justify-center shadow-inner">
                        <img id="mainImagePreview" src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80" alt="Preview" class="w-full h-full object-cover">
                        <div class="absolute bottom-2 left-2 bg-brand-950/85 text-white text-[10px] font-bold px-2 py-0.5 rounded backdrop-blur-sm">
                            Cover Preview
                        </div>
                    </div>
                </div>

                <!-- Or Image URL input -->
                <div class="pt-2 border-t border-slate-200/60">
                    <label class="block text-[11px] font-semibold text-slate-500 uppercase mb-1">Or paste Image URL directly</label>
                    <input type="text" name="image" id="image_url" value="{{ old('image', 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80') }}" placeholder="https://..." class="w-full border border-slate-300 rounded-xl px-4 py-2 text-xs text-slate-700 bg-white" oninput="updateUrlPreview(this.value)">
                </div>
            </div>

            <!-- Additional Gallery Photos Upload -->
            <div class="sm:col-span-2 space-y-2 p-5 bg-slate-50 border border-slate-200 rounded-2xl">
                <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider">
                    Additional Gallery Photos (Optional)
                </label>
                <label for="gallery_files" class="flex items-center gap-3 p-3.5 border border-dashed border-slate-300 hover:border-brand-600 rounded-xl cursor-pointer bg-white transition shadow-sm">
                    <i class="fa-solid fa-images text-2xl text-brand-600"></i>
                    <div>
                        <span class="text-xs font-bold text-slate-800">Select Multiple Gallery Photos</span>
                        <span class="text-[10px] text-slate-400 block">Upload extra room views, bathroom, balcony, etc.</span>
                    </div>
                    <input type="file" name="gallery_files[]" id="gallery_files" multiple accept="image/*" class="hidden" onchange="previewGalleryImages(this)">
                </label>
                <div id="galleryPreviewContainer" class="flex flex-wrap gap-2 pt-2"></div>
            </div>

            <div class="sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Short Description *</label>
                <input type="text" name="short_description" value="{{ old('short_description') }}" required placeholder="Summary shown on cards..." class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm">
            </div>
            <div class="sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Full Detailed Description *</label>
                <textarea name="description" rows="4" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm">{{ old('description') }}</textarea>
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Assign Amenities</label>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                @foreach($amenities as $am)
                    <label class="flex items-center gap-2 p-2 border border-slate-200 rounded-lg text-xs cursor-pointer hover:bg-slate-50">
                        <input type="checkbox" name="amenities[]" value="{{ $am->id }}" class="rounded text-brand-700">
                        <span>{{ $am->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="flex items-center gap-6 pt-4 border-t border-slate-100">
            <label class="flex items-center text-sm font-medium text-slate-700">
                <input type="checkbox" name="is_featured" value="1" checked class="rounded text-brand-700 mr-2"> Highlight on Homepage
            </label>
            <div class="flex items-center gap-2 text-sm">
                <label class="text-xs font-bold uppercase text-slate-500">Status:</label>
                <select name="status" class="border border-slate-300 rounded-lg px-2 py-1 text-xs bg-white">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>

        <div class="flex justify-between items-center pt-4">
            <a href="{{ route('admin.room-types.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-700">Cancel</a>
            <button type="submit" class="bg-brand-700 hover:bg-brand-800 text-white font-bold px-6 py-2.5 rounded-xl text-xs shadow-md transition">Save Category</button>
        </div>
    </form>
</div>

<script>
function previewMainImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('mainImagePreview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function updateUrlPreview(url) {
    if (url && url.startsWith('http')) {
        document.getElementById('mainImagePreview').src = url;
    }
}

function previewGalleryImages(input) {
    const container = document.getElementById('galleryPreviewContainer');
    container.innerHTML = '';
    if (input.files) {
        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-20 h-20 object-cover rounded-xl border border-slate-200 shadow-sm';
                container.appendChild(img);
            }
            reader.readAsDataURL(file);
        });
    }
}
</script>
@endsection
