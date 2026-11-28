<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Expense;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportAdminController extends Controller
{
    /**
     * Parse date range from request (supports presets and custom range)
     *
     * @return array{0: Carbon, 1: Carbon, 2: string}
     */
    protected function parseDateRange(Request $request): array
    {
        $preset = $request->get('period', 'this_month');
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');

        if ($fromDate && $toDate) {
            $preset = 'custom';
            $startDate = Carbon::parse($fromDate)->startOfDay();
            $endDate = Carbon::parse($toDate)->endOfDay();
        } else {
            switch ($preset) {
                case 'today':
                    $startDate = Carbon::today()->startOfDay();
                    $endDate = Carbon::today()->endOfDay();
                    break;
                case 'yesterday':
                    $startDate = Carbon::yesterday()->startOfDay();
                    $endDate = Carbon::yesterday()->endOfDay();
                    break;
                case 'this_week':
                    $startDate = Carbon::now()->startOfWeek()->startOfDay();
                    $endDate = Carbon::now()->endOfWeek()->endOfDay();
                    break;
                case 'last_7_days':
                    $startDate = Carbon::now()->subDays(6)->startOfDay();
                    $endDate = Carbon::now()->endOfDay();
                    break;
                case 'last_30_days':
                    $startDate = Carbon::now()->subDays(29)->startOfDay();
                    $endDate = Carbon::now()->endOfDay();
                    break;
                case 'last_month':
                    $startDate = Carbon::now()->subMonth()->startOfMonth()->startOfDay();
                    $endDate = Carbon::now()->subMonth()->endOfMonth()->endOfDay();
                    break;
                case 'this_year':
                    $startDate = Carbon::now()->startOfYear()->startOfDay();
                    $endDate = Carbon::now()->endOfYear()->endOfDay();
                    break;
                case 'this_month':
                default:
                    $preset = 'this_month';
                    $startDate = Carbon::now()->startOfMonth()->startOfDay();
                    $endDate = Carbon::now()->endOfMonth()->endOfDay();
                    break;
            }
        }

        return [$startDate, $endDate, $preset];
    }

    public function index(Request $request): View
    {
        [$startDate, $endDate, $preset] = $this->parseDateRange($request);

        $roomTypeFilter = $request->get('room_type_id');
        $statusFilter = $request->get('status');
        $paymentStatusFilter = $request->get('payment_status');

        $query = Booking::with(['roomType', 'room'])
            ->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('check_in_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                  ->orWhereBetween('created_at', [$startDate->format('Y-m-d H:i:s'), $endDate->format('Y-m-d H:i:s')]);
            });

        if ($roomTypeFilter) {
            $query->where('room_type_id', $roomTypeFilter);
        }
        if ($statusFilter && $statusFilter !== 'all') {
            $query->where('booking_status', $statusFilter);
        }
        if ($paymentStatusFilter && $paymentStatusFilter !== 'all') {
            $query->where('payment_status', $paymentStatusFilter);
        }

        $bookings = (clone $query)->latest('id')->paginate(20)->withQueryString();

        // High Level Metrics
        $totalBookings = (clone $query)->count();
        $confirmedBookings = (clone $query)->whereIn('booking_status', ['confirmed', 'checked_in', 'checked_out'])->count();
        $cancelledBookings = (clone $query)->where('booking_status', 'cancelled')->count();
        $pendingBookings = (clone $query)->where('booking_status', 'pending')->count();

        // Revenue Metrics (Confirmed / Completed / In-House)
        $revenueQuery = (clone $query)->whereIn('booking_status', ['confirmed', 'checked_in', 'checked_out']);
        $grossRevenue = (float) $revenueQuery->sum('total_amount');
        $advanceCollected = (float) (clone $query)->sum('advance_paid');
        $balanceDue = (float) $revenueQuery->sum('balance_due');
        $roomRevenue = (float) $revenueQuery->sum('room_subtotal');
        $addonsRevenue = (float) $revenueQuery->sum('addons_total');

        // Occupancy Metrics
        $totalRooms = Room::count();
        $daysCount = max(1, (int) $startDate->diffInDays($endDate) + 1);
        $totalAvailableRoomNights = $totalRooms * $daysCount;
        $occupiedNights = (int) $revenueQuery->sum('nights');
        $occupancyRate = $totalAvailableRoomNights > 0 
            ? min(100.0, round(($occupiedNights / $totalAvailableRoomNights) * 100, 1)) 
            : 0;

        $adr = $occupiedNights > 0 ? round($roomRevenue / $occupiedNights, 2) : 0;
        $revpar = $totalAvailableRoomNights > 0 ? round($roomRevenue / $totalAvailableRoomNights, 2) : 0;

        // Room-wise Revenue Breakdown
        $rooms = Room::with('roomType')->orderBy('room_number')->get();
        $roomBreakdown = [];
        foreach ($rooms as $rm) {
            $rmBookings = Booking::where('room_id', $rm->id)
                ->whereIn('booking_status', ['confirmed', 'checked_in', 'checked_out'])
                ->where(function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('check_in_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                      ->orWhereBetween('created_at', [$startDate->format('Y-m-d H:i:s'), $endDate->format('Y-m-d H:i:s')]);
                });

            $rmCount = $rmBookings->count();
            $rmNights = (int) $rmBookings->sum('nights');
            $rmRevenue = (float) $rmBookings->sum('total_amount');
            $rmOccupancy = $daysCount > 0 ? min(100.0, round(($rmNights / $daysCount) * 100, 1)) : 0;

            $roomBreakdown[] = [
                'room' => $rm,
                'bookings_count' => $rmCount,
                'nights' => $rmNights,
                'revenue' => $rmRevenue,
                'occupancy_rate' => $rmOccupancy,
            ];
        }

        $roomTypes = RoomType::all();

        $expenses = Expense::whereBetween('expense_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->orderByDesc('expense_date')
            ->orderByDesc('id')
            ->get();

        $totalExpenses = (float) $expenses->sum('amount');
        $netProfit = $grossRevenue - $totalExpenses;
        $expensesByCategory = $expenses->groupBy('category')->map(fn ($group) => (float) $group->sum('amount'));

        return view('admin.reports.index', compact(
            'bookings',
            'totalBookings',
            'confirmedBookings',
            'cancelledBookings',
            'pendingBookings',
            'grossRevenue',
            'advanceCollected',
            'balanceDue',
            'roomRevenue',
            'addonsRevenue',
            'totalRooms',
            'daysCount',
            'totalAvailableRoomNights',
            'occupiedNights',
            'occupancyRate',
            'adr',
            'revpar',
            'roomBreakdown',
            'roomTypes',
            'startDate',
            'endDate',
            'preset',
            'expenses',
            'totalExpenses',
            'netProfit',
            'expensesByCategory'
        ));
    }

    /**
     * Export detailed Bookings CSV
     */
    public function exportBookingsCsv(Request $request): StreamedResponse
    {
        [$startDate, $endDate] = $this->parseDateRange($request);

        $query = Booking::with(['roomType', 'room'])
            ->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('check_in_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                  ->orWhereBetween('created_at', [$startDate->format('Y-m-d H:i:s'), $endDate->format('Y-m-d H:i:s')]);
            });

        if ($request->filled('room_type_id')) {
            $query->where('room_type_id', $request->room_type_id);
        }
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('booking_status', $request->status);
        }

        $filename = 'sanda_bookings_' . $startDate->format('Ymd') . '_to_' . $endDate->format('Ymd') . '.csv';

        return new StreamedResponse(function () use ($query) {
            $handle = fopen('php://output', 'w');
            // Write UTF-8 BOM for Excel compatibility
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'Booking Code',
                'Guest Name',
                'Phone Number',
                'Email',
                'NIC / Passport',
                'Room Category',
                'Physical Room',
                'Check-in Date',
                'Check-in Time',
                'Check-out Date',
                'Check-out Time',
                'Duration (Nights/Hours)',
                'Adults',
                'Children',
                'Room Rate (Rs)',
                'Room Subtotal (Rs)',
                'Addons Total (Rs)',
                'Total Amount (Rs)',
                'Advance Paid (Rs)',
                'Balance Due (Rs)',
                'Payment Status',
                'Payment Method',
                'Booking Status',
                'Special Requests',
                'Booked On',
            ]);

            $query->chunk(100, function ($bookings) use ($handle) {
                foreach ($bookings as $b) {
                    fputcsv($handle, [
                        $b->booking_code,
                        $b->guest_name,
                        $b->guest_phone,
                        $b->guest_email,
                        $b->guest_nic_passport ?? 'N/A',
                        $b->roomType?->name ?? 'Standard',
                        $b->room ? (str_starts_with($b->room->room_number, 'Room') ? $b->room->room_number : 'Room ' . $b->room->room_number) : 'Unassigned',
                        $b->check_in_date,
                        $b->check_in_time ?? '14:00',
                        $b->check_out_date,
                        $b->check_out_time ?? '11:00',
                        $b->duration_display,
                        $b->adults,
                        $b->children ?? 0,
                        number_format($b->room_rate, 2, '.', ''),
                        number_format($b->room_subtotal, 2, '.', ''),
                        number_format($b->addons_total, 2, '.', ''),
                        number_format($b->total_amount, 2, '.', ''),
                        number_format($b->advance_paid, 2, '.', ''),
                        number_format($b->balance_due, 2, '.', ''),
                        strtoupper($b->payment_status),
                        strtoupper($b->payment_method),
                        strtoupper($b->booking_status),
                        $b->special_requests ?? '',
                        $b->created_at->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Export Revenue & Financial Summary CSV
     */
    public function exportRevenueCsv(Request $request): StreamedResponse
    {
        [$startDate, $endDate] = $this->parseDateRange($request);

        $filename = 'sanda_revenue_summary_' . $startDate->format('Ymd') . '_to_' . $endDate->format('Ymd') . '.csv';

        return new StreamedResponse(function () use ($startDate, $endDate) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'Date',
                'Total Reservations',
                'Confirmed / Stayed',
                'Cancelled',
                'Room Charges (Rs)',
                'Add-ons Income (Rs)',
                'Gross Revenue (Rs)',
                'Advance Collected (Rs)',
                'Balance Pending (Rs)',
            ]);

            $current = (clone $startDate)->startOfDay();
            while ($current->lte($endDate)) {
                $dayStr = $current->format('Y-m-d');

                $dayBookings = Booking::whereDate('check_in_date', $dayStr);
                $totalDay = (clone $dayBookings)->count();
                $confirmedDay = (clone $dayBookings)->whereIn('booking_status', ['confirmed', 'checked_in', 'checked_out'])->count();
                $cancelledDay = (clone $dayBookings)->where('booking_status', 'cancelled')->count();

                $revQuery = (clone $dayBookings)->whereIn('booking_status', ['confirmed', 'checked_in', 'checked_out']);
                $dayRoom = (float) $revQuery->sum('room_subtotal');
                $dayAddons = (float) $revQuery->sum('addons_total');
                $dayGross = (float) $revQuery->sum('total_amount');
                $dayAdvance = (float) (clone $dayBookings)->sum('advance_paid');
                $dayBalance = (float) $revQuery->sum('balance_due');

                fputcsv($handle, [
                    $dayStr,
                    $totalDay,
                    $confirmedDay,
                    $cancelledDay,
                    number_format($dayRoom, 2, '.', ''),
                    number_format($dayAddons, 2, '.', ''),
                    number_format($dayGross, 2, '.', ''),
                    number_format($dayAdvance, 2, '.', ''),
                    number_format($dayBalance, 2, '.', ''),
                ]);

                $current->addDay();
            }

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Export Room-wise Occupancy & Income CSV
     */
    public function exportRoomsCsv(Request $request): StreamedResponse
    {
        [$startDate, $endDate] = $this->parseDateRange($request);
        $daysCount = max(1, (int) $startDate->diffInDays($endDate) + 1);

        $filename = 'sanda_room_performance_' . $startDate->format('Ymd') . '_to_' . $endDate->format('Ymd') . '.csv';

        return new StreamedResponse(function () use ($startDate, $endDate, $daysCount) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'Room Number',
                'Room Category',
                'Floor / Wing',
                'Base Price / Night (Rs)',
                'Reservations Count',
                'Nights Occupied',
                'Occupancy Rate (%)',
                'Total Revenue (Rs)',
            ]);

            $rooms = Room::with('roomType')->orderBy('room_number')->get();
            foreach ($rooms as $rm) {
                $rmBookings = Booking::where('room_id', $rm->id)
                    ->whereIn('booking_status', ['confirmed', 'checked_in', 'checked_out'])
                    ->where(function ($q) use ($startDate, $endDate) {
                        $q->whereBetween('check_in_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                          ->orWhereBetween('created_at', [$startDate->format('Y-m-d H:i:s'), $endDate->format('Y-m-d H:i:s')]);
                    });

                $count = $rmBookings->count();
                $nights = (int) $rmBookings->sum('nights');
                $rev = (float) $rmBookings->sum('total_amount');
                $occ = $daysCount > 0 ? min(100.0, round(($nights / $daysCount) * 100, 1)) : 0;

                fputcsv($handle, [
                    str_starts_with($rm->room_number, 'Room') ? $rm->room_number : 'Room ' . $rm->room_number,
                    $rm->roomType?->name ?? 'Standard',
                    $rm->floor_wing,
                    number_format($rm->roomType?->base_price_per_night ?? 0, 2, '.', ''),
                    $count,
                    $nights,
                    $occ . '%',
                    number_format($rev, 2, '.', ''),
                ]);
            }

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Dedicated printable / PDF executive report view
     */
    public function printReport(Request $request): View
    {
        [$startDate, $endDate, $preset] = $this->parseDateRange($request);
        $settings = Setting::pluck('value', 'key');

        $query = Booking::with(['roomType', 'room'])
            ->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('check_in_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                  ->orWhereBetween('created_at', [$startDate->format('Y-m-d H:i:s'), $endDate->format('Y-m-d H:i:s')]);
            });

        $totalBookings = (clone $query)->count();
        $confirmedBookings = (clone $query)->whereIn('booking_status', ['confirmed', 'checked_in', 'checked_out'])->count();
        $cancelledBookings = (clone $query)->where('booking_status', 'cancelled')->count();

        $revQuery = (clone $query)->whereIn('booking_status', ['confirmed', 'checked_in', 'checked_out']);
        $grossRevenue = (float) $revQuery->sum('total_amount');
        $advanceCollected = (float) (clone $query)->sum('advance_paid');
        $balanceDue = (float) $revQuery->sum('balance_due');
        $roomRevenue = (float) $revQuery->sum('room_subtotal');
        $addonsRevenue = (float) $revQuery->sum('addons_total');

        $totalRooms = Room::count();
        $daysCount = max(1, (int) $startDate->diffInDays($endDate) + 1);
        $totalAvailableRoomNights = $totalRooms * $daysCount;
        $occupiedNights = (int) $revQuery->sum('nights');
        $occupancyRate = $totalAvailableRoomNights > 0 
            ? min(100.0, round(($occupiedNights / $totalAvailableRoomNights) * 100, 1)) 
            : 0;

        $adr = $occupiedNights > 0 ? round($roomRevenue / $occupiedNights, 2) : 0;
        $revpar = $totalAvailableRoomNights > 0 ? round($roomRevenue / $totalAvailableRoomNights, 2) : 0;

        $bookingsList = (clone $query)->latest('id')->take(100)->get();

        $rooms = Room::with('roomType')->orderBy('room_number')->get();
        $roomBreakdown = [];
        foreach ($rooms as $rm) {
            $rmBookings = Booking::where('room_id', $rm->id)
                ->whereIn('booking_status', ['confirmed', 'checked_in', 'checked_out'])
                ->where(function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('check_in_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                      ->orWhereBetween('created_at', [$startDate->format('Y-m-d H:i:s'), $endDate->format('Y-m-d H:i:s')]);
                });

            $rmCount = $rmBookings->count();
            $rmNights = (int) $rmBookings->sum('nights');
            $rmRevenue = (float) $rmBookings->sum('total_amount');
            $rmOccupancy = $daysCount > 0 ? min(100.0, round(($rmNights / $daysCount) * 100, 1)) : 0;

            $roomBreakdown[] = [
                'room' => $rm,
                'bookings_count' => $rmCount,
                'nights' => $rmNights,
                'revenue' => $rmRevenue,
                'occupancy_rate' => $rmOccupancy,
            ];
        }

        return view('admin.reports.print', compact(
            'settings',
            'totalBookings',
            'confirmedBookings',
            'cancelledBookings',
            'grossRevenue',
            'advanceCollected',
            'balanceDue',
            'roomRevenue',
            'addonsRevenue',
            'totalRooms',
            'daysCount',
            'totalAvailableRoomNights',
            'occupiedNights',
            'occupancyRate',
            'adr',
            'revpar',
            'bookingsList',
            'roomBreakdown',
            'startDate',
            'endDate',
            'preset'
        ));
    }

    public function storeExpense(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0.01',
            'expense_date' => 'required|date',
            'notes' => 'nullable|string|max:500',
        ]);

        $validated['recorded_by'] = Auth::id();
        Expense::create($validated);

        return back()->with('success', "Expense '{$validated['title']}' (Rs. " . number_format((float) $validated['amount'], 2) . ') recorded successfully.');
    }

    public function destroyExpense(Expense $expense): RedirectResponse
    {
        $title = $expense->title;
        $expense->delete();

        return back()->with('success', "Expense '{$title}' deleted.");
    }
}
