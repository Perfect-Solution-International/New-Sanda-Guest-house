<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InquiryAdminController extends Controller
{
    public function index(): View
    {
        $inquiries = Inquiry::latest()->paginate(20);
        return view('admin.inquiries.index', compact('inquiries'));
    }

    public function toggleReplied(Inquiry $inquiry): RedirectResponse
    {
        $newStatus = $inquiry->status === 'replied' ? 'unread' : 'replied';
        $inquiry->update(['status' => $newStatus]);
        return back()->with('success', "Inquiry marked as {$newStatus}.");
    }

    public function destroy(Inquiry $inquiry): RedirectResponse
    {
        $inquiry->delete();
        return redirect()->route('admin.inquiries.index')->with('success', 'Inquiry deleted.');
    }
}
