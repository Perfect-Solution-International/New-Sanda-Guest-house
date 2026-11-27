<?php

namespace Database\Seeders;

use App\Models\Addon;
use App\Models\Amenity;
use App\Models\Booking;
use App\Models\Inquiry;
use App\Models\Review;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ResortDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Users
        User::updateOrCreate(
            ['email' => 'superadmin@pos.lk'],
            [
                'name' => 'Super Admin',
                'phone' => '+94 77 987 6543',
                'role' => 'admin',
                'password' => Hash::make('admin123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@sandaresort.com'],
            [
                'name' => 'Sanda Manager',
                'phone' => '+94 77 987 6543',
                'role' => 'admin',
                'password' => Hash::make('admin123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'reception@sandaresort.com'],
            [
                'name' => 'Reception Desk',
                'phone' => '+94 47 223 5566',
                'role' => 'receptionist',
                'password' => Hash::make('reception123'),
            ]
        );

        // 2. Basic Settings
        $settings = [
            'resort_name' => 'Sanda Guest House',
            'resort_tagline' => 'Clean, Comfortable & Affordable Family Stays Across Sri Lanka',
            'phone' => '+94 77 987 6543',
            'hotline' => '+94 47 223 5566',
            'whatsapp' => '+94779876543',
            'email' => 'info@sandaresort.com',
            'address' => 'No. 45, Sella Road, Sella Katharagama, Sri Lanka',
            'check_in_time' => '02:00 PM',
            'check_out_time' => '11:00 AM',
            'currency' => 'LKR',
            'currency_symbol' => 'Rs.',
            'bank_details' => "Bank: Bank of Ceylon (BOC)\nBranch: Kataragama Branch\nAccount Name: Sanda Guest House\nAccount No: 8876543201",
            'about_text' => 'Sanda Guest House is a peaceful, family-run accommodation network. We offer clean, affordable A/C and Non-A/C rooms with attached bathrooms, hot water, free Wi-Fi, and spacious vehicle parking across our branch locations.',
        ];

        foreach ($settings as $key => $val) {
            Setting::updateOrCreate(['key' => $key], ['value' => $val]);
        }

        // 3. Basic Amenities
        $amenitiesData = [
            ['name' => 'Air Conditioning', 'icon' => 'snowflake', 'category' => 'room'],
            ['name' => 'Ceiling Fan', 'icon' => 'wind', 'category' => 'room'],
            ['name' => 'Attached Bathroom', 'icon' => 'bath', 'category' => 'room'],
            ['name' => 'Hot Water Shower', 'icon' => 'shower', 'category' => 'room'],
            ['name' => 'Free Wi-Fi', 'icon' => 'wifi', 'category' => 'resort'],
            ['name' => 'Secure Vehicle Parking', 'icon' => 'car', 'category' => 'resort'],
            ['name' => 'LED TV', 'icon' => 'tv', 'category' => 'room'],
            ['name' => 'Home-Cooked Food on Request', 'icon' => 'utensils', 'category' => 'resort'],
            ['name' => '24/7 Water & Power Backup', 'icon' => 'bolt', 'category' => 'resort'],
            ['name' => 'Near Sella Temple & Menik Ganga', 'icon' => 'location-dot', 'category' => 'resort'],
        ];

        $amenityModels = [];
        foreach ($amenitiesData as $amenity) {
            $amenityModels[] = Amenity::updateOrCreate(['name' => $amenity['name']], $amenity);
        }

        // 4. Basic Realistic Rooms
        $roomTypes = [
            [
                'name' => 'Standard A/C Double Room',
                'slug' => 'standard-ac-double-room',
                'short_description' => 'Comfortable air-conditioned double room with king/queen bed, attached bathroom with hot shower, and free Wi-Fi.',
                'description' => 'A clean and restful room equipped with cold inverter air conditioning, plush double bed, attached private bathroom with hot water, ceiling fan, and clothes rack. Perfect for couples or small families visiting Kataragama.',
                'base_price_per_night' => 5500.00,
                'max_adults' => 2,
                'max_children' => 1,
                'bed_type' => '1 Double / King Bed',
                'room_size' => '220 sq ft',
                'image' => '/uploads/rooms/standard-ac-double-room.jpg',
                'gallery' => [
                    '/uploads/rooms/standard-ac-double-room.jpg',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=800&q=80',
                ],
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Budget Non-A/C Double Room',
                'slug' => 'budget-non-ac-double-room',
                'short_description' => 'Affordable and clean double room with ceiling fan, attached bathroom, and free vehicle parking.',
                'description' => 'Economical choice for pilgrims and visitors seeking neat, spotless accommodation. Features a comfortable double bed, ceiling fan, attached bathroom, and peaceful ventilation.',
                'base_price_per_night' => 3500.00,
                'max_adults' => 2,
                'max_children' => 1,
                'bed_type' => '1 Double Bed',
                'room_size' => '200 sq ft',
                'image' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=800&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=800&q=80',
                ],
                'is_featured' => false,
                'status' => 'active',
            ],
            [
                'name' => 'Family A/C Room (4-5 Guests)',
                'slug' => 'family-ac-room',
                'short_description' => 'Spacious family room with two double beds, air conditioning, hot water bathroom, and room for the whole family.',
                'description' => 'Designed specifically for visiting families. Contains two large double beds, air conditioning, ceiling fan, attached modern bathroom with hot water, and ample space for luggage.',
                'base_price_per_night' => 8500.00,
                'max_adults' => 4,
                'max_children' => 2,
                'bed_type' => '2 Double Beds',
                'room_size' => '320 sq ft',
                'image' => '/uploads/rooms/family-ac-room.jpg',
                'gallery' => [
                    '/uploads/rooms/family-ac-room.jpg',
                ],
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Family Non-A/C Room (Budget Group)',
                'slug' => 'family-non-ac-room',
                'short_description' => 'Spacious and low-cost family room with two double beds, ceiling fans, and attached bathroom for pilgrimage groups.',
                'description' => 'Great value for families and groups travelling to Ruhunu Kataragama Maha Devalaya and Kiri Vehera. Clean bedding, ceiling fans, and attached bathroom.',
                'base_price_per_night' => 5500.00,
                'max_adults' => 4,
                'max_children' => 2,
                'bed_type' => '2 Double Beds',
                'room_size' => '300 sq ft',
                'image' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=800&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=800&q=80',
                ],
                'is_featured' => false,
                'status' => 'active',
            ],
        ];

        $createdRoomTypes = [];
        foreach ($roomTypes as $data) {
            $rt = RoomType::updateOrCreate(['slug' => $data['slug']], $data);
            $rt->amenities()->sync(Amenity::pluck('id')->take(6));
            $createdRoomTypes[$data['slug']] = $rt;
        }

        // 5. Basic Physical Rooms (Room 01 to Room 06)
        $physicalRooms = [
            ['type' => 'standard-ac-double-room', 'number' => 'Room 01', 'wing' => 'Ground Floor', 'status' => 'available'],
            ['type' => 'standard-ac-double-room', 'number' => 'Room 02', 'wing' => 'Ground Floor', 'status' => 'available'],
            ['type' => 'budget-non-ac-double-room', 'number' => 'Room 03', 'wing' => 'Ground Floor', 'status' => 'available'],
            ['type' => 'family-ac-room', 'number' => 'Room 04', 'wing' => 'First Floor', 'status' => 'available'],
            ['type' => 'family-ac-room', 'number' => 'Room 05', 'wing' => 'First Floor', 'status' => 'available'],
            ['type' => 'family-non-ac-room', 'number' => 'Room 06', 'wing' => 'First Floor', 'status' => 'available'],
        ];

        foreach ($physicalRooms as $pr) {
            $roomType = $createdRoomTypes[$pr['type']];
            Room::updateOrCreate(
                ['room_number' => $pr['number']],
                [
                    'room_type_id' => $roomType->id,
                    'floor_wing' => $pr['wing'],
                    'status' => $pr['status'],
                ]
            );
        }

        // 6. Simple Addons (Extra bed, meals)
        $addons = [
            [
                'name' => 'Extra Single Mattress & Pillow',
                'description' => 'Comfortable single mattress with clean bedsheet, blanket, and pillow for an additional guest.',
                'price' => 1000.00,
                'price_type' => 'per_night',
                'icon' => 'bed',
                'is_active' => true,
            ],
            [
                'name' => 'Home-Cooked Breakfast (Per Person)',
                'description' => 'Traditional Sri Lankan breakfast (Roti or String Hoppers with dhal & lunu miris, tea).',
                'price' => 600.00,
                'price_type' => 'per_person',
                'icon' => 'utensils',
                'is_active' => true,
            ],
            [
                'name' => 'Kataragama Devalaya Transport / Tuk-Tuk',
                'description' => 'Assistance with local vehicle or three-wheeler to Kataragama temple & Kiri Vehera.',
                'price' => 1200.00,
                'price_type' => 'per_booking',
                'icon' => 'car',
                'is_active' => true,
            ],
        ];

        foreach ($addons as $addonData) {
            Addon::updateOrCreate(['name' => $addonData['name']], $addonData);
        }

        // 7. No dummy bookings (Clean)

        // 8. Basic Reviews
        $reviews = [
            [
                'guest_name' => 'Lalith & Family',
                'guest_location' => 'Colombo',
                'rating' => 5,
                'comment' => 'Very clean and peaceful place to stay with family for Kataragama pilgrimage. Hot water and A/C worked perfectly, and ample space to park our van.',
                'stay_date' => 'Recent Stay',
                'is_approved' => true,
            ],
            [
                'guest_name' => 'Nadeeka Priyadharshani',
                'guest_location' => 'Kandy',
                'rating' => 5,
                'comment' => 'Affordable rates and very friendly owner. Sella Kataragama temple is just a few minutes away. Highly recommended for families.',
                'stay_date' => 'Recent Stay',
                'is_approved' => true,
            ],
        ];

        foreach ($reviews as $rev) {
            Review::updateOrCreate(['guest_name' => $rev['guest_name']], $rev);
        }
    }
}
