<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerAdminController extends Controller
{
    public function index(Request $request): View
    {
        $query = Customer::withCount('bookings');

        // Stats
        $stats = [
            'total' => Customer::count(),
            'repeat' => Customer::has('bookings', '>=', 2)->count(),
            'vip' => Customer::where('is_vip', true)->count(),
            'blacklisted' => Customer::where('is_blacklisted', true)->count(),
        ];

        // Search Filter
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Status Filter
        $filter = $request->get('filter', 'all');
        if ($filter === 'vip') {
            $query->where('is_vip', true);
        } elseif ($filter === 'blacklisted') {
            $query->where('is_blacklisted', true);
        } elseif ($filter === 'repeat') {
            $query->has('bookings', '>=', 2);
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        if ($sort === 'name') {
            $query->orderBy('name', 'asc');
        } elseif ($sort === 'bookings') {
            $query->orderBy('bookings_count', 'desc');
        } else {
            $query->latest('id');
        }

        $customers = $query->paginate(15)->withQueryString();

        return view('admin.customers.index', compact('customers', 'stats', 'filter'));
    }

    public function show(Customer $customer): View
    {
        $customer->load([
            'bookings.roomType',
            'bookings.room',
            'bookings.payments',
            'bookings.addons.addon',
        ]);

        $bookings = $customer->bookings;

        $stats = [
            'total_bookings' => $bookings->count(),
            'completed_stays' => $bookings->whereIn('booking_status', ['checked_in', 'checked_out'])->count(),
            'confirmed_stays' => $bookings->where('booking_status', 'confirmed')->count(),
            'cancelled_stays' => $bookings->where('booking_status', 'cancelled')->count(),
            'total_spent' => $bookings->whereIn('booking_status', ['confirmed', 'checked_in', 'checked_out'])->sum('total_amount'),
            'total_advance' => $bookings->sum('advance_paid'),
        ];

        return view('admin.customers.show', compact('customer', 'stats'));
    }

    public function update(Request $request, Customer $customer): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'nic_passport' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'special_preferences' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:2000',
            'is_vip' => 'nullable|boolean',
        ]);

        $validated['is_vip'] = $request->boolean('is_vip');

        $customer->update($validated);

        return back()->with('success', "Customer details for {$customer->name} updated successfully.");
    }

    public function toggleBlacklist(Request $request, Customer $customer): RedirectResponse
    {
        $isBlacklisted = $request->boolean('is_blacklisted');
        $reason = $request->input('blacklist_reason');

        if ($isBlacklisted && empty(trim($reason ?? ''))) {
            $reason = 'Blacklisted by Hotel Management';
        }

        $customer->update([
            'is_blacklisted' => $isBlacklisted,
            'blacklist_reason' => $isBlacklisted ? trim($reason) : null,
        ]);

        $statusMsg = $isBlacklisted 
            ? "Customer {$customer->name} has been placed on the BLACKLIST." 
            : "Customer {$customer->name} has been removed from the Blacklist.";

        return back()->with('success', $statusMsg);
    }

    public function toggleVip(Request $request, Customer $customer): RedirectResponse
    {
        $isVip = !$customer->is_vip;
        $customer->update(['is_vip' => $isVip]);

        $msg = $isVip 
            ? "Customer {$customer->name} is now marked as VIP Guest."
            : "VIP status removed for {$customer->name}.";

        return back()->with('success', $msg);
    }

    public function destroy(Customer $customer): RedirectResponse
    {
        $name = $customer->name;
        // Detach customer_id from bookings so booking history remains intact
        $customer->bookings()->update(['customer_id' => null]);
        $customer->delete();

        return redirect()->route('admin.customers.index')->with('success', "Customer record for {$name} deleted successfully.");
    }
}
