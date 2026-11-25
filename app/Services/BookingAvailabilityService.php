<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class BookingAvailabilityService
{
    /**
     * Parse date and time into a unified Carbon instance.
     */
    public static function parseDateTime(string $date, ?string $time = null, string $defaultTime = '14:00'): Carbon
    {
        $timeStr = !empty($time) ? trim($time) : $defaultTime;
        // Normalize time if formatted with AM/PM or 24-hr
        try {
            return Carbon::parse("{$date} {$timeStr}");
        } catch (\Exception $e) {
            return Carbon::parse("{$date} {$defaultTime}");
        }
    }

    /**
     * Compute duration in nights and hours, and formatted text.
     *
     * @return array{nights: int, hours: float, duration_type: string, duration_text: string}
     */
    public static function calculateDuration(Carbon $checkInAt, Carbon $checkOutAt): array
    {
        $hours = round($checkInAt->diffInMinutes($checkOutAt) / 60, 2);
        if ($hours <= 0) {
            $hours = 1;
        }

        $calendarDays = $checkInAt->copy()->startOfDay()->diffInDays($checkOutAt->copy()->startOfDay());

        if ($calendarDays >= 1 && $hours >= 12) {
            $nights = (int) $calendarDays;
            $durationType = 'nights';
            $nightsText = $nights === 1 ? '1 Night' : "{$nights} Nights";
            $durationText = "{$nightsText} (" . round($hours) . " Hours)";
        } else {
            $nights = 0;
            $durationType = 'hours';
            $durationText = round($hours) . " Hours (Day Use)";
        }

        return [
            'nights' => $nights,
            'hours' => $hours,
            'duration_type' => $durationType,
            'duration_text' => $durationText,
        ];
    }

    /**
     * Get live availability summary across the resort and per room type.
     *
     * @return array{
     *     total_rooms: int,
     *     available_rooms: int,
     *     booked_rooms: int,
     *     duration: array,
     *     room_types: array,
     *     has_availability: bool
     * }
     */
    public static function getAvailability(
        Carbon $checkInAt,
        Carbon $checkOutAt,
        ?int $selectedRoomTypeId = null,
        ?int $excludeBookingId = null
    ): array {
        $duration = self::calculateDuration($checkInAt, $checkOutAt);

        // Fetch all rooms and room types
        $allRooms = Room::all();
        $allRoomTypes = RoomType::where('status', 'active')->get();
        if ($allRoomTypes->isEmpty()) {
            $allRoomTypes = RoomType::all();
        }

        // Fetch overlapping active bookings in this time range
        $overlappingBookings = Booking::overlapping($checkInAt, $checkOutAt, $excludeBookingId)->get();

        // Room IDs physically occupied
        $occupiedRoomIds = $overlappingBookings->whereNotNull('room_id')->pluck('room_id')->toArray();

        // Count of unassigned bookings per room_type_id
        $unassignedCountsByType = $overlappingBookings->whereNull('room_id')
            ->groupBy('room_type_id')
            ->map(fn (Collection $group) => $group->count());

        $roomTypeSummaries = [];
        $totalResortRooms = $allRooms->count();
        $totalBookedCount = 0;

        foreach ($allRoomTypes as $rt) {
            $physicalRoomsOfType = $allRooms->where('room_type_id', $rt->id);
            $totalOfType = $physicalRoomsOfType->count();

            // Rooms with matching room_id booked
            $bookedByIdCount = $physicalRoomsOfType->whereIn('id', $occupiedRoomIds)->count();
            $unassignedCount = $unassignedCountsByType->get($rt->id, 0);

            $bookedOfType = min($totalOfType, $bookedByIdCount + $unassignedCount);
            $availableOfType = max(0, $totalOfType - $bookedOfType);

            // Free physical rooms of this type
            $freePhysicalRooms = $physicalRoomsOfType->whereNotIn('id', $occupiedRoomIds)->values();

            $totalBookedCount += $bookedOfType;

            $roomTypeSummaries[] = [
                'id' => $rt->id,
                'name' => $rt->name,
                'slug' => $rt->slug,
                'bed_type' => $rt->bed_type,
                'max_adults' => $rt->max_adults,
                'max_children' => $rt->max_children,
                'base_price_per_night' => (float) $rt->base_price_per_night,
                'total_rooms' => $totalOfType,
                'booked_rooms' => $bookedOfType,
                'available_rooms' => $availableOfType,
                'is_available' => $availableOfType > 0,
                'free_rooms' => $freePhysicalRooms->map(fn ($r) => [
                    'id' => $r->id,
                    'room_number' => $r->room_number,
                    'floor_wing' => $r->floor_wing,
                ])->toArray(),
            ];
        }

        $totalAvailableRooms = max(0, $totalResortRooms - $totalBookedCount);

        // Calculate schedule for every individual physical room
        $roomsSchedule = [];
        $allPhysicalRooms = Room::with('roomType')->orderBy('room_number')->get();

        $upcomingBookings = Booking::whereIn('booking_status', ['confirmed', 'checked_in', 'pending'])
            ->where(function ($q) use ($checkInAt) {
                $q->where('check_out_at', '>=', now()->startOfDay())
                  ->orWhere('check_out_date', '>=', now()->toDateString());
            })
            ->where(function ($q) {
                $q->where('check_in_at', '<=', now()->addDays(14)->endOfDay())
                  ->orWhere('check_in_date', '<=', now()->addDays(14)->toDateString());
            })
            ->orderBy('check_in_date')
            ->get();

        foreach ($allPhysicalRooms as $room) {
            $isOccupiedInSelectedSlot = in_array($room->id, $occupiedRoomIds);

            $activeRoomBookings = $upcomingBookings->where('room_id', $room->id);
            $bookedSlots = [];
            foreach ($activeRoomBookings as $b) {
                $inFormatted = $b->check_in_at ? $b->check_in_at->format('M d, h:i A') : (Carbon::parse($b->check_in_date)->format('M d') . ' ' . date('h:i A', strtotime($b->check_in_time ?? '14:00')));
                $outFormatted = $b->check_out_at ? $b->check_out_at->format('M d, h:i A') : (Carbon::parse($b->check_out_date)->format('M d') . ' ' . date('h:i A', strtotime($b->check_out_time ?? '11:00')));

                $isConflict = false;
                if ($b->check_in_at && $b->check_out_at) {
                    $isConflict = ($b->check_in_at < $checkOutAt && $b->check_out_at > $checkInAt);
                } else {
                    $bIn = Carbon::parse($b->check_in_date . ' ' . ($b->check_in_time ?? '14:00'));
                    $bOut = Carbon::parse($b->check_out_date . ' ' . ($b->check_out_time ?? '11:00'));
                    $isConflict = ($bIn < $checkOutAt && $bOut > $checkInAt);
                }

                $bookedSlots[] = [
                    'from' => $inFormatted,
                    'to' => $outFormatted,
                    'duration' => $b->duration_display,
                    'status' => $b->booking_status,
                    'is_conflict' => $isConflict,
                ];
            }

            $roomsSchedule[] = [
                'id' => $room->id,
                'room_number' => $room->room_number,
                'room_type_id' => $room->room_type_id,
                'room_type_name' => $room->roomType->name ?? 'Room',
                'floor_wing' => $room->floor_wing ?: 'Ground Floor',
                'is_available_in_slot' => !$isOccupiedInSelectedSlot && $room->status !== 'maintenance',
                'status' => $room->status,
                'booked_slots' => $bookedSlots,
            ];
        }

        return [
            'total_rooms' => $totalResortRooms,
            'available_rooms' => $totalAvailableRooms,
            'booked_rooms' => $totalBookedCount,
            'duration' => $duration,
            'room_types' => $roomTypeSummaries,
            'rooms_schedule' => $roomsSchedule,
            'has_availability' => $totalAvailableRooms > 0,
        ];
    }

    /**
     * Check if a specific physical room is free during the given time window.
     */
    public static function isPhysicalRoomAvailable(int $roomId, Carbon $checkInAt, Carbon $checkOutAt, ?int $excludeBookingId = null): bool
    {
        return !Booking::overlapping($checkInAt, $checkOutAt, $excludeBookingId)
            ->where('room_id', $roomId)
            ->exists();
    }

    /**
     * Find an available physical room for a given room type during the time window.
     */
    public static function findFreeRoomForType(int $roomTypeId, Carbon $checkInAt, Carbon $checkOutAt, ?int $excludeBookingId = null): ?Room
    {
        $overlappingRoomIds = Booking::overlapping($checkInAt, $checkOutAt, $excludeBookingId)
            ->whereNotNull('room_id')
            ->pluck('room_id')
            ->toArray();

        return Room::where('room_type_id', $roomTypeId)
            ->whereNotIn('id', $overlappingRoomIds)
            ->where('status', '!=', 'maintenance')
            ->first();
    }
}
