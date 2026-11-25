<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'room_type_id',
        'room_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'guest_nic_passport',
        'guest_address',
        'check_in_date',
        'check_in_time',
        'check_out_date',
        'check_out_time',
        'check_in_at',
        'check_out_at',
        'nights',
        'duration_hours',
        'duration_type',
        'adults',
        'children',
        'room_rate',
        'room_subtotal',
        'addons_total',
        'total_amount',
        'advance_paid',
        'balance_due',
        'payment_status',
        'payment_method',
        'booking_status',
        'special_requests',
        'admin_notes',
    ];

    protected function casts(): array
    {
        return [
            'check_in_date' => 'date',
            'check_out_date' => 'date',
            'check_in_at' => 'datetime',
            'check_out_at' => 'datetime',
            'nights' => 'integer',
            'duration_hours' => 'decimal:2',
            'adults' => 'integer',
            'children' => 'integer',
            'room_rate' => 'decimal:2',
            'room_subtotal' => 'decimal:2',
            'addons_total' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'advance_paid' => 'decimal:2',
            'balance_due' => 'decimal:2',
        ];
    }

    public function getDurationDisplayAttribute(): string
    {
        $hours = $this->duration_hours ?? ($this->check_in_at && $this->check_out_at ? round($this->check_in_at->diffInHours($this->check_out_at)) : ($this->nights * 24));
        if ($this->nights > 0) {
            $nightsText = $this->nights === 1 ? '1 Night' : "{$this->nights} Nights";
            return "{$nightsText} (" . round($hours) . " hrs)";
        }
        return round($hours) . " Hours (Day Use)";
    }

    public function getTimeRangeDisplayAttribute(): string
    {
        if ($this->check_in_at && $this->check_out_at) {
            return $this->check_in_at->format('M d, Y h:i A') . ' - ' . $this->check_out_at->format('M d, Y h:i A');
        }
        $inTime = $this->check_in_time ? date('h:i A', strtotime($this->check_in_time)) : '02:00 PM';
        $outTime = $this->check_out_time ? date('h:i A', strtotime($this->check_out_time)) : '11:00 AM';
        return $this->check_in_date->format('M d, Y') . " {$inTime} - " . $this->check_out_date->format('M d, Y') . " {$outTime}";
    }

    public function scopeActive($query)
    {
        return $query->whereNotIn('booking_status', ['cancelled']);
    }

    public function scopeOverlapping($query, $startAt, $endAt, ?int $excludeBookingId = null)
    {
        $query->whereNotIn('booking_status', ['cancelled'])
            ->where(function ($q) use ($startAt, $endAt) {
                $q->where('check_in_at', '<', $endAt)
                  ->where('check_out_at', '>', $startAt);
            });

        if ($excludeBookingId) {
            $query->where('id', '!=', $excludeBookingId);
        }

        return $query;
    }

    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function bookingAddons(): HasMany
    {
        return $this->hasMany(BookingAddon::class);
    }

    public function addons(): BelongsToMany
    {
        return $this->belongsToMany(Addon::class, 'booking_addons')
            ->withPivot(['quantity', 'unit_price', 'subtotal'])
            ->withTimestamps();
    }

    public static function generateBookingCode(): string
    {
        $year = date('Y');
        $random = strtoupper(bin2hex(random_bytes(3))); // 6 chars
        return "NS-{$year}-{$random}";
    }
}
