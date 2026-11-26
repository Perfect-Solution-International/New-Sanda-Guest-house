<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'nic_passport',
        'address',
        'city',
        'country',
        'is_vip',
        'is_blacklisted',
        'blacklist_reason',
        'special_preferences',
        'notes',
    ];

    protected $casts = [
        'is_vip' => 'boolean',
        'is_blacklisted' => 'boolean',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class)->latest('id');
    }

    public function getTotalSpentAttribute(): float
    {
        return (float) $this->bookings()
            ->whereIn('booking_status', ['confirmed', 'checked_in', 'checked_out'])
            ->sum('total_amount');
    }

    public function getCompletedStaysCountAttribute(): int
    {
        return $this->bookings()
            ->whereIn('booking_status', ['confirmed', 'checked_in', 'checked_out'])
            ->count();
    }

    public function getIsRepeatAttribute(): bool
    {
        return $this->bookings()->count() > 1;
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (empty($term)) {
            return $query;
        }

        $term = trim($term);
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
              ->orWhere('phone', 'like', "%{$term}%")
              ->orWhere('email', 'like', "%{$term}%")
              ->orWhere('nic_passport', 'like', "%{$term}%")
              ->orWhere('city', 'like', "%{$term}%");
        });
    }

    public function scopeVip(Builder $query): Builder
    {
        return $query->where('is_vip', true);
    }

    public function scopeBlacklisted(Builder $query): Builder
    {
        return $query->where('is_blacklisted', true);
    }

    public function scopeRepeatGuests(Builder $query): Builder
    {
        return $query->has('bookings', '>=', 2);
    }
}
