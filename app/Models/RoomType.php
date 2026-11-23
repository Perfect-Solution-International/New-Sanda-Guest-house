<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoomType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'base_price_per_night',
        'max_adults',
        'max_children',
        'bed_type',
        'room_size',
        'image',
        'gallery',
        'is_featured',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'base_price_per_night' => 'decimal:2',
            'max_adults' => 'integer',
            'max_children' => 'integer',
            'gallery' => 'array',
            'is_featured' => 'boolean',
        ];
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class, 'room_type_amenity');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function availableRoomsCount(): int
    {
        return $this->rooms()->where('status', 'available')->count();
    }
}
