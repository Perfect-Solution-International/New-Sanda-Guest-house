<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Inquiry;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $today = Carbon::today()->format('Y-m-d');

        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('booking_status', 'pending')->count();
        $todayCheckIns = Booking::where('check_in_date', $today)->whereIn('booking_status', ['confirmed', 'checked_in'])->count();
        $todayCheckOuts = Booking::where('check_out_date', $today)->where('booking_status', 'checked_in')->count();
        
        $totalRevenue = Booking::whereIn('booking_status', ['confirmed', 'checked_in', 'checked_out'])->sum('total_amount');
        $advanceCollected = Booking::sum('advance_paid');

        $totalRooms = Room::count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100) : 0;

        $recentBookings = Booking::with(['roomType', 'room'])->latest()->take(6)->get();
        $unreadInquiries = Inquiry::where('status', 'unread')->count();

        return view('admin.dashboard', compact(
            'totalBookings',
            'pendingBookings',
            'todayCheckIns',
            'todayCheckOuts',
            'totalRevenue',
            'advanceCollected',
            'totalRooms',
            'occupiedRooms',
            'occupancyRate',
            'recentBookings',
            'unreadInquiries'
        ));
    }
}
