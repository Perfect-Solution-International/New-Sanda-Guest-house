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
        'check_out_date',
        'nights',
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
            'nights' => 'integer',
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
