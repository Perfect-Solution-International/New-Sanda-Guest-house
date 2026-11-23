@extends('admin.layouts.app')

@section('title', 'Guest Inquiries - Admin')
@section('page_title', 'Incoming Messages & Inquiries')

@section('content')
<div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100">
                <tr>
                    <th class="py-3.5 px-6">Sender Details</th>
                    <th class="py-3.5 px-6">Subject & Message</th>
                    <th class="py-3.5 px-6">Date Received</th>
                    <th class="py-3.5 px-6">Status</th>
                    <th class="py-3.5 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($inquiries as $inq)
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="py-4 px-6">
                            <strong class="text-slate-900 block">{{ $inq->name }}</strong>
                            <div class="text-xs text-brand-700 font-semibold">{{ $inq->phone }}</div>
                            <div class="text-[11px] text-slate-400">{{ $inq->email }}</div>
                        </td>
                        <td class="py-4 px-6 max-w-md">
                            @if($inq->subject)
                                <div class="font-bold text-slate-800 text-xs mb-1">{{ $inq->subject }}</div>
                            @endif
                            <p class="text-xs text-slate-600 leading-relaxed">{{ $inq->message }}</p>
                        </td>
                        <td class="py-4 px-6 text-xs text-slate-500">
                            {{ $inq->created_at->format('M d, Y') }}
                            <span class="block text-[10px] text-slate-400">{{ $inq->created_at->diffForHumans() }}</span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $inq->status == 'replied' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ $inq->status }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right space-x-2">
                            <form action="{{ route('admin.inquiries.toggle', $inq->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-xs font-bold text-brand-700 hover:underline">
                                    {{ $inq->status == 'replied' ? 'Mark Unread' : 'Mark Replied' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.inquiries.destroy', $inq->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete message?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-bold text-rose-600 hover:text-rose-800">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-slate-400">No customer messages received yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
