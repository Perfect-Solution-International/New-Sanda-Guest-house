<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Inquiry;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

        // Daily and Monthly revenue summary
        $todayRevenue = Booking::whereDate('created_at', Carbon::today())
            ->whereIn('booking_status', ['confirmed', 'checked_in', 'checked_out'])
            ->sum('total_amount');

        $monthlyRevenue = Booking::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->whereIn('booking_status', ['confirmed', 'checked_in', 'checked_out'])
            ->sum('total_amount');

        $totalRooms = Room::count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $availableRooms = Room::where('status', 'available')->count();
        $cleaningRooms = Room::where('status', 'cleaning')->count();
        $maintenanceRooms = Room::where('status', 'maintenance')->count();
        $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100) : 0;

        $recentBookings = Booking::with(['roomType', 'room'])->latest()->take(6)->get();
        $unreadInquiries = Inquiry::where('status', 'unread')->count();
        $roomTypes = RoomType::withCount([
            'rooms',
            'rooms as available_rooms_count' => fn ($q) => $q->where('status', 'available'),
        ])->get();

        return view('admin.dashboard', compact(
            'totalBookings',
            'pendingBookings',
            'todayCheckIns',
            'todayCheckOuts',
            'totalRevenue',
            'advanceCollected',
            'todayRevenue',
            'monthlyRevenue',
            'totalRooms',
            'occupiedRooms',
            'availableRooms',
            'cleaningRooms',
            'maintenanceRooms',
            'occupancyRate',
            'recentBookings',
            'unreadInquiries',
            'roomTypes'
        ));
    }

    public function timeline(Request $request): View
    {
        $startDateStr = $request->get('start_date', Carbon::today()->format('Y-m-d'));
        try {
            $startDate = Carbon::parse($startDateStr);
        } catch (\Exception $e) {
            $startDate = Carbon::today();
        }

        $days = (int) $request->get('days', 14);
        if ($days < 7 || $days > 31) {
            $days = 14;
        }

        $dates = [];
        for ($i = 0; $i < $days; $i++) {
            $dates[] = (clone $startDate)->addDays($i);
        }
        $endDate = end($dates);

        $roomTypeFilter = $request->get('room_type_id');
        $roomsQuery = Room::with('roomType')->orderBy('room_number');
        if ($roomTypeFilter) {
            $roomsQuery->where('room_type_id', $roomTypeFilter);
        }
        $rooms = $roomsQuery->get();
        $roomTypes = RoomType::all();

        // Get all active bookings in this period
        $bookings = Booking::with(['room', 'roomType'])
            ->whereIn('booking_status', ['pending', 'confirmed', 'checked_in'])
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('check_in_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                    ->orWhereBetween('check_out_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                    ->orWhere(function ($sub) use ($startDate, $endDate) {
                        $sub->where('check_in_date', '<=', $startDate->format('Y-m-d'))
                            ->where('check_out_date', '>=', $endDate->format('Y-m-d'));
                    });
            })
            ->get();

        // Map bookings by room ID and date
        $schedule = [];
        foreach ($rooms as $room) {
            $schedule[$room->id] = [];
            foreach ($dates as $date) {
                $dStr = $date->format('Y-m-d');
                $schedule[$room->id][$dStr] = [];
            }
        }

        $unassignedBookings = [];

        foreach ($bookings as $b) {
            $bIn = Carbon::parse($b->check_in_date);
            $bOut = Carbon::parse($b->check_out_date);

            if ($b->room_id && isset($schedule[$b->room_id])) {
                foreach ($dates as $date) {
                    $dStr = $date->format('Y-m-d');
                    if ($date->greaterThanOrEqualTo($bIn) && $date->lessThanOrEqualTo($bOut)) {
                        $schedule[$b->room_id][$dStr][] = $b;
                    }
                }
            } else {
                $unassignedBookings[] = $b;
            }
        }

        $prevDate = (clone $startDate)->subDays($days)->format('Y-m-d');
        $nextDate = (clone $startDate)->addDays($days)->format('Y-m-d');

        return view('admin.timeline', compact(
            'rooms',
            'roomTypes',
            'dates',
            'startDate',
            'days',
            'schedule',
            'unassignedBookings',
            'prevDate',
            'nextDate'
        ));
    }
}
