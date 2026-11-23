@extends('admin.layouts.app')

@section('title', 'Resort Settings - Admin')
@section('page_title', 'Resort Configuration & Bank Details')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-3xl shadow-sm border border-slate-200">
    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <h3 class="text-lg font-serif font-bold text-slate-900 mb-4 border-b border-slate-100 pb-2">Resort Branding & Identity</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Resort Name</label>
                    <input type="text" name="resort_name" value="{{ $settings['resort_name'] ?? 'නිවි සඳ (Nivi Sanda) Family Holiday Resort' }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-semibold">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Tagline</label>
                    <input type="text" name="resort_tagline" value="{{ $settings['resort_tagline'] ?? 'Your Serene Family Haven in Sacred Sella Katharagama' }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Physical Address</label>
                    <input type="text" name="address" value="{{ $settings['address'] ?? 'No. 45, Sella Road, Sella Katharagama, Sri Lanka' }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm">
                </div>
            </div>
        </div>

        <div>
            <h3 class="text-lg font-serif font-bold text-slate-900 mb-4 border-b border-slate-100 pb-2">Contact & Hotlines</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Primary Mobile / Front Desk</label>
                    <input type="text" name="phone" value="{{ $settings['phone'] ?? '+94 77 987 6543' }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Landline / Second Hotline</label>
                    <input type="text" name="hotline" value="{{ $settings['hotline'] ?? '+94 47 223 5566' }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">WhatsApp Hotline</label>
                    <input type="text" name="whatsapp" value="{{ $settings['whatsapp'] ?? '+94779876543' }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Public Email</label>
                    <input type="email" name="email" value="{{ $settings['email'] ?? 'info@nivisandaresort.com' }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm">
                </div>
            </div>
        </div>

        <div>
            <h3 class="text-lg font-serif font-bold text-slate-900 mb-4 border-b border-slate-100 pb-2">Check-in Policies</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Default Check-in Time</label>
                    <input type="text" name="check_in_time" value="{{ $settings['check_in_time'] ?? '02:00 PM' }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Default Check-out Time</label>
                    <input type="text" name="check_out_time" value="{{ $settings['check_out_time'] ?? '11:00 AM' }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm">
                </div>
            </div>
        </div>

        <div>
            <h3 class="text-lg font-serif font-bold text-slate-900 mb-4 border-b border-slate-100 pb-2">Official Bank Details for Advance Deposits</h3>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Bank Instructions (Displayed on Guest Vouchers)</label>
                <textarea name="bank_details" rows="4" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-mono">{{ $settings['bank_details'] ?? '' }}</textarea>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 text-right">
            <button type="submit" class="bg-brand-700 hover:bg-brand-800 text-white font-bold px-8 py-3 rounded-xl shadow transition text-sm">
                Save Resort Settings
            </button>
        </div>
    </form>
</div>
@endsection
