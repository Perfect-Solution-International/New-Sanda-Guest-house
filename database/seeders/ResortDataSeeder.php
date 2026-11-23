<?php

namespace Database\Seeders;

use App\Models\Addon;
use App\Models\Amenity;
use App\Models\Booking;
use App\Models\BookingAddon;
use App\Models\Inquiry;
use App\Models\Review;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResortDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Users
        User::updateOrCreate(
            ['email' => 'admin@nivisandaresort.com'],
            [
                'name' => 'Nivi Sanda General Manager',
                'phone' => '+94 77 987 6543',
                'role' => 'admin',
                'password' => Hash::make('admin123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'reception@nivisandaresort.com'],
            [
                'name' => 'Front Desk Reception',
                'phone' => '+94 47 223 5566',
                'role' => 'receptionist',
                'password' => Hash::make('reception123'),
            ]
        );

        // 2. Settings
        $settings = [
            'resort_name' => 'නිවි සඳ (Nivi Sanda) Family Holiday Resort',
            'resort_tagline' => 'Your Serene Family Haven in Sacred Sella Katharagama',
            'phone' => '+94 77 987 6543',
            'hotline' => '+94 47 223 5566',
            'whatsapp' => '+94779876543',
            'email' => 'info@nivisandaresort.com',
            'address' => 'No. 45, Sella Road, Sella Katharagama, Sri Lanka',
            'check_in_time' => '02:00 PM',
            'check_out_time' => '11:00 AM',
            'currency' => 'LKR',
            'currency_symbol' => 'Rs.',
            'bank_details' => "Bank: Bank of Ceylon (BOC)\nBranch: Kataragama Branch\nAccount Name: Nivi Sanda Holiday Resort\nAccount No: 8876543201",
            'about_text' => 'Nestled amidst the tranquil nature of Sella Katharagama and minutes away from the sacred Kataragama Devalaya and Yala National Park, Nivi Sanda Family Holiday Resort provides the ultimate peaceful escape for families, pilgrims, and nature lovers. Featuring lush tropical gardens, a sparkling swimming pool, spacious family villas, and warm Sri Lankan hospitality.',
        ];

        foreach ($settings as $key => $val) {
            Setting::updateOrCreate(['key' => $key], ['value' => $val]);
        }

        // 3. Amenities
        $amenitiesData = [
            ['name' => 'Inverter Air Conditioning', 'icon' => 'wind', 'category' => 'room'],
            ['name' => 'Free High-Speed Wi-Fi', 'icon' => 'wifi', 'category' => 'resort'],
            ['name' => 'Swimming Pool & Kids Pool', 'icon' => 'water', 'category' => 'resort'],
            ['name' => 'Hot Water Shower', 'icon' => 'shower', 'category' => 'room'],
            ['name' => 'Private Balcony / Verandah', 'icon' => 'door-open', 'category' => 'room'],
            ['name' => 'Smart LED TV', 'icon' => 'tv', 'category' => 'room'],
            ['name' => 'Electric Kettle & Tea/Coffee', 'icon' => 'coffee', 'category' => 'room'],
            ['name' => 'Mini Refrigerator', 'icon' => 'snowflake', 'category' => 'room'],
            ['name' => 'Lush Garden & Mountain View', 'icon' => 'mountain', 'category' => 'room'],
            ['name' => 'Free Secure Parking', 'icon' => 'car', 'category' => 'resort'],
            ['name' => '24/7 Power Backup Generator', 'icon' => 'bolt', 'category' => 'resort'],
            ['name' => 'Restaurant & In-room Dining', 'icon' => 'utensils', 'category' => 'resort'],
            ['name' => 'Outdoor BBQ Facilities', 'icon' => 'fire', 'category' => 'resort'],
            ['name' => 'Kataragama Temple Shuttle', 'icon' => 'bus', 'category' => 'resort'],
        ];

        $amenityModels = [];
        foreach ($amenitiesData as $amenity) {
            $amenityModels[] = Amenity::updateOrCreate(['name' => $amenity['name']], $amenity);
        }

        // 4. Room Types
        $roomTypes = [
            [
                'name' => 'Deluxe Family Villa (Pool View)',
                'slug' => 'deluxe-family-villa',
                'short_description' => 'Ultra-spacious luxury villa designed for families, featuring two king beds, private veranda overlooking the swimming pool, and tropical open-air rain shower.',
                'description' => 'Our flagship Deluxe Family Villa is the ultimate comfort experience in Sella Katharagama. Crafted with refined wooden finishes and high ceilings, this villa accommodates up to 6 guests comfortably. Enjoy direct pool views, two plush king-sized spring beds, dedicated lounging sofa area, luxury modern bathroom with solar hot water, and tranquil veranda where you can sip your morning Ceylon tea amidst tropical birdsong.',
                'base_price_per_night' => 28500.00,
                'max_adults' => 4,
                'max_children' => 2,
                'bed_type' => '2 King Beds + 1 Daybed',
                'room_size' => '650 sq ft',
                'image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80',
                ],
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Luxury River-Breeze Cabana',
                'slug' => 'luxury-river-breeze-cabana',
                'short_description' => 'Charming eco-luxurious wooden cabana surrounded by coconut palms and birds, equipped with king bed, air conditioning, and serene sit-out patio.',
                'description' => 'Experience nature with luxury in our standalone River-Breeze Cabanas. Perfect for couples or small families, each cabana offers complete privacy, eco-friendly wooden aesthetics, whisper-quiet air conditioning, 43-inch smart TV, luxury mattress, mini-fridge, and an attached garden-view bathroom with hot shower.',
                'base_price_per_night' => 22000.00,
                'max_adults' => 2,
                'max_children' => 2,
                'bed_type' => '1 King Bed + 1 Single Bed',
                'room_size' => '480 sq ft',
                'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1591088398332-8a7791972843?auto=format&fit=crop&w=1200&q=80',
                ],
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Executive Nature Suite',
                'slug' => 'executive-nature-suite',
                'short_description' => 'Contemporary luxury room featuring a king bed, work corner, panoramic nature views, and modern comforts ideal for relaxing weekend getaways.',
                'description' => 'The Executive Nature Suite brings refined comfort to your spiritual and safari vacation. Fitted with premium linens, soundproofing, high-speed Wi-Fi, tea/coffee maker, modern en-suite bath, and easy access to the restaurant and swimming pool.',
                'base_price_per_night' => 17500.00,
                'max_adults' => 2,
                'max_children' => 1,
                'bed_type' => '1 King Bed',
                'room_size' => '400 sq ft',
                'image' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80',
                ],
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Standard Family Room',
                'slug' => 'standard-family-room',
                'short_description' => 'Budget-friendly, spotless family room equipped with two queen beds, A/C, and attached bathroom. Perfect for pilgrimage and holiday groups.',
                'description' => 'Designed specifically for visiting families and pilgrimage devotees travelling together to Ruhunu Kataragama Maha Devalaya and Kiri Vehera. Clean, comfortable, fully air-conditioned, with pristine bedding and generous space for luggage.',
                'base_price_per_night' => 14000.00,
                'max_adults' => 4,
                'max_children' => 1,
                'bed_type' => '2 Queen Beds',
                'room_size' => '380 sq ft',
                'image' => 'https://images.unsplash.com/photo-1591088398332-8a7791972843?auto=format&fit=crop&w=1200&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1591088398332-8a7791972843?auto=format&fit=crop&w=1200&q=80',
                ],
                'is_featured' => false,
                'status' => 'active',
            ],
        ];

        $createdRoomTypes = [];
        foreach ($roomTypes as $data) {
            $rt = RoomType::updateOrCreate(['slug' => $data['slug']], $data);
            $rt->amenities()->sync(Amenity::pluck('id')->take(8));
            $createdRoomTypes[$data['slug']] = $rt;
        }

        // 5. Physical Rooms
        $physicalRooms = [
            // Deluxe Family Villa
            ['type' => 'deluxe-family-villa', 'number' => 'VILLA-101', 'wing' => 'Poolside Villa Wing', 'status' => 'available'],
            ['type' => 'deluxe-family-villa', 'number' => 'VILLA-102', 'wing' => 'Poolside Villa Wing', 'status' => 'occupied'],
            ['type' => 'deluxe-family-villa', 'number' => 'VILLA-103', 'wing' => 'Poolside Villa Wing', 'status' => 'available'],
            // River Breeze Cabana
            ['type' => 'luxury-river-breeze-cabana', 'number' => 'CABANA-201', 'wing' => 'Garden Cabana Lawn', 'status' => 'available'],
            ['type' => 'luxury-river-breeze-cabana', 'number' => 'CABANA-202', 'wing' => 'Garden Cabana Lawn', 'status' => 'available'],
            ['type' => 'luxury-river-breeze-cabana', 'number' => 'CABANA-203', 'wing' => 'Garden Cabana Lawn', 'status' => 'occupied'],
            ['type' => 'luxury-river-breeze-cabana', 'number' => 'CABANA-204', 'wing' => 'Garden Cabana Lawn', 'status' => 'cleaning'],
            // Executive Nature Suite
            ['type' => 'executive-nature-suite', 'number' => 'SUITE-301', 'wing' => 'Main Wing 1st Floor', 'status' => 'available'],
            ['type' => 'executive-nature-suite', 'number' => 'SUITE-302', 'wing' => 'Main Wing 1st Floor', 'status' => 'available'],
            ['type' => 'executive-nature-suite', 'number' => 'SUITE-303', 'wing' => 'Main Wing 1st Floor', 'status' => 'maintenance'],
            // Standard Family Room
            ['type' => 'standard-family-room', 'number' => 'FAM-401', 'wing' => 'Pilgrim Ground Wing', 'status' => 'available'],
            ['type' => 'standard-family-room', 'number' => 'FAM-402', 'wing' => 'Pilgrim Ground Wing', 'status' => 'occupied'],
            ['type' => 'standard-family-room', 'number' => 'FAM-403', 'wing' => 'Pilgrim Ground Wing', 'status' => 'available'],
            ['type' => 'standard-family-room', 'number' => 'FAM-404', 'wing' => 'Pilgrim Ground Wing', 'status' => 'available'],
        ];

        $roomMap = [];
        foreach ($physicalRooms as $pr) {
            $roomType = $createdRoomTypes[$pr['type']];
            $r = Room::updateOrCreate(
                ['room_number' => $pr['number']],
                [
                    'room_type_id' => $roomType->id,
                    'floor_wing' => $pr['wing'],
                    'status' => $pr['status'],
                ]
            );
            $roomMap[$pr['number']] = $r;
        }

        // 6. Addons
        $addons = [
            [
                'name' => 'Yala National Park Safari (4x4 Jeep + Driver)',
                'description' => 'Half-day thrilling safari into Yala Block 1 or 5. Includes modified 4x4 open safari jeep, professional wildlife tracker driver, and pickup/drop from resort gate.',
                'price' => 19500.00,
                'price_type' => 'per_booking',
                'icon' => 'truck',
                'is_active' => true,
            ],
            [
                'name' => 'Outdoor Poolside BBQ Dinner Setup',
                'description' => 'Freshly grilled chicken, fish, sausage skewers, butter corn, garlic bread, and tropical salad served beside the illuminated swimming pool under the night stars.',
                'price' => 8500.00,
                'price_type' => 'per_booking',
                'icon' => 'fire',
                'is_active' => true,
            ],
            [
                'name' => 'Kataragama Devalaya Pooja Transport & Guidance',
                'description' => 'A/C van transfer to Maha Devalaya and Kiri Vehera, timing coordination for evening Pooja rituals, and assistance with fruit basket offerings.',
                'price' => 4500.00,
                'price_type' => 'per_booking',
                'icon' => 'bus',
                'is_active' => true,
            ],
            [
                'name' => 'Extra Luxury Mattress & Linens',
                'description' => 'Additional comfortable single mattress with pillows, blanket, and bath towels for extra guest.',
                'price' => 3000.00,
                'price_type' => 'per_night',
                'icon' => 'bed',
                'is_active' => true,
            ],
            [
                'name' => 'Traditional Southern Sri Lankan Breakfast (Per Person)',
                'description' => 'Delicious string hoppers, pol sambol, kiri hodhi, fish ambul thiyal, fresh fruit platter, and Ceylon tea.',
                'price' => 1500.00,
                'price_type' => 'per_person',
                'icon' => 'utensils',
                'is_active' => true,
            ],
        ];

        $createdAddons = [];
        foreach ($addons as $addonData) {
            $createdAddons[] = Addon::updateOrCreate(['name' => $addonData['name']], $addonData);
        }

        // 7. Seed Bookings
        $sampleBookings = [
            [
                'booking_code' => 'NS-2026-A101',
                'room_type_id' => $createdRoomTypes['deluxe-family-villa']->id,
                'room_id' => $roomMap['VILLA-102']->id,
                'guest_name' => 'Dr. Kanishka Weerasinghe',
                'guest_email' => 'kanishka.w@gmail.com',
                'guest_phone' => '+94 77 123 4567',
                'guest_nic_passport' => '198512345678',
                'guest_address' => 'Colombo 07, Sri Lanka',
                'check_in_date' => Carbon::now()->subDays(1)->format('Y-m-d'),
                'check_out_date' => Carbon::now()->addDays(2)->format('Y-m-d'),
                'nights' => 3,
                'adults' => 4,
                'children' => 2,
                'room_rate' => 28500.00,
                'room_subtotal' => 85500.00,
                'addons_total' => 19500.00,
                'total_amount' => 105000.00,
                'advance_paid' => 50000.00,
                'balance_due' => 55000.00,
                'payment_status' => 'advance_paid',
                'payment_method' => 'bank_transfer',
                'booking_status' => 'checked_in',
                'special_requests' => 'Please arrange early morning Yala safari jeep pickup at 5:30 AM.',
                'admin_notes' => 'Checked in smoothly. Family very pleased with pool view villa.',
            ],
            [
                'booking_code' => 'NS-2026-B203',
                'room_type_id' => $createdRoomTypes['luxury-river-breeze-cabana']->id,
                'room_id' => $roomMap['CABANA-203']->id,
                'guest_name' => 'Ruwan Samantha Perera',
                'guest_email' => 'ruwan.perera@yahoo.com',
                'guest_phone' => '+94 71 889 2211',
                'guest_nic_passport' => '199277889900',
                'guest_address' => 'Galle Road, Panadura',
                'check_in_date' => Carbon::now()->format('Y-m-d'),
                'check_out_date' => Carbon::now()->addDays(1)->format('Y-m-d'),
                'nights' => 1,
                'adults' => 2,
                'children' => 0,
                'room_rate' => 22000.00,
                'room_subtotal' => 22000.00,
                'addons_total' => 8500.00,
                'total_amount' => 30500.00,
                'advance_paid' => 30500.00,
                'balance_due' => 0.00,
                'payment_status' => 'paid_in_full',
                'payment_method' => 'card_at_desk',
                'booking_status' => 'checked_in',
                'special_requests' => 'Outdoor BBQ dinner requested around 8:00 PM tonight.',
                'admin_notes' => 'Full payment settled upon arrival.',
            ],
            [
                'booking_code' => 'NS-2026-C402',
                'room_type_id' => $createdRoomTypes['standard-family-room']->id,
                'room_id' => $roomMap['FAM-402']->id,
                'guest_name' => 'Mrs. Dilani Senanayake',
                'guest_email' => 'dilani.sen@gmail.com',
                'guest_phone' => '+94 76 555 4321',
                'guest_nic_passport' => '197866554433',
                'guest_address' => 'Kandy Road, Kiribathgoda',
                'check_in_date' => Carbon::now()->addDays(2)->format('Y-m-d'),
                'check_out_date' => Carbon::now()->addDays(4)->format('Y-m-d'),
                'nights' => 2,
                'adults' => 4,
                'children' => 1,
                'room_rate' => 14000.00,
                'room_subtotal' => 28000.00,
                'addons_total' => 4500.00,
                'total_amount' => 32500.00,
                'advance_paid' => 15000.00,
                'balance_due' => 17500.00,
                'payment_status' => 'advance_paid',
                'payment_method' => 'bank_transfer',
                'booking_status' => 'confirmed',
                'special_requests' => 'Attending Kataragama annual festival pooja.',
                'admin_notes' => 'Advance verified via bank slip.',
            ],
            [
                'booking_code' => 'NS-2026-D301',
                'room_type_id' => $createdRoomTypes['executive-nature-suite']->id,
                'room_id' => null,
                'guest_name' => 'Chaminda Silva',
                'guest_email' => 'chaminda.silva@outlook.com',
                'guest_phone' => '+94 70 334 9876',
                'guest_nic_passport' => '199044332211',
                'guest_address' => 'Kurunegala',
                'check_in_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
                'check_out_date' => Carbon::now()->addDays(7)->format('Y-m-d'),
                'nights' => 2,
                'adults' => 2,
                'children' => 0,
                'room_rate' => 17500.00,
                'room_subtotal' => 35000.00,
                'addons_total' => 0.00,
                'total_amount' => 35000.00,
                'advance_paid' => 0.00,
                'balance_due' => 35000.00,
                'payment_status' => 'pending',
                'payment_method' => 'cash',
                'booking_status' => 'pending',
                'special_requests' => 'Quiet room preferred.',
                'admin_notes' => 'Waiting for advance slip confirmation.',
            ],
        ];

        foreach ($sampleBookings as $bData) {
            $booking = Booking::updateOrCreate(['booking_code' => $bData['booking_code']], $bData);

            if ($bData['addons_total'] > 0) {
                if ($bData['booking_code'] === 'NS-2026-A101') {
                    BookingAddon::updateOrCreate(
                        ['booking_id' => $booking->id, 'addon_id' => $createdAddons[0]->id],
                        ['quantity' => 1, 'unit_price' => 19500.00, 'subtotal' => 19500.00]
                    );
                } elseif ($bData['booking_code'] === 'NS-2026-B203') {
                    BookingAddon::updateOrCreate(
                        ['booking_id' => $booking->id, 'addon_id' => $createdAddons[1]->id],
                        ['quantity' => 1, 'unit_price' => 8500.00, 'subtotal' => 8500.00]
                    );
                } elseif ($bData['booking_code'] === 'NS-2026-C402') {
                    BookingAddon::updateOrCreate(
                        ['booking_id' => $booking->id, 'addon_id' => $createdAddons[2]->id],
                        ['quantity' => 1, 'unit_price' => 4500.00, 'subtotal' => 4500.00]
                    );
                }
            }
        }

        // 8. Reviews
        $reviews = [
            [
                'guest_name' => 'Lalith Warnakulasooriya & Family',
                'guest_location' => 'Colombo, Sri Lanka',
                'rating' => 5,
                'comment' => 'නිවි සඳ Resort එකේ අපේ පවුලේ අය සමඟ ගත කරපු දවස් 3 ඇත්තටම අමතක නොවන අත්දැකීමක්! Large swimming pool, delicious Sri Lankan rice & curry, and the staff helped us organize the Kataragama Pooja and Yala safari smoothly. Highly recommended for families!',
                'stay_date' => 'October 2026',
                'is_approved' => true,
            ],
            [
                'guest_name' => 'Nadeeka Priyadharshani',
                'guest_location' => 'Kurunegala',
                'rating' => 5,
                'comment' => 'Great ambiance in Sella Katharagama. Very clean cabanas with hot water and strong AC. Kids loved the swimming pool so much. Staff was exceptionally welcoming and helpful.',
                'stay_date' => 'November 2026',
                'is_approved' => true,
            ],
            [
                'guest_name' => 'Asanka Jayawardena',
                'guest_location' => 'Matara',
                'rating' => 5,
                'comment' => 'The best family holiday resort near Kataragama! Ample parking for large vans and buses, peaceful green environment away from noise, and great BBQ setup by the pool at night.',
                'stay_date' => 'November 2026',
                'is_approved' => true,
            ],
        ];

        foreach ($reviews as $rev) {
            Review::updateOrCreate(['guest_name' => $rev['guest_name']], $rev);
        }

        // 9. Inquiries
        $inquiries = [
            [
                'name' => 'Bandara Senadeera',
                'email' => 'bandara@gmail.com',
                'phone' => '+94 77 443 3221',
                'subject' => 'Family Gathering & 4 Rooms Booking for December',
                'message' => 'Hello, we are planning a family reunion of 18 members during late December. Can we reserve all 3 Deluxe Family Villas and 2 Cabanas? Please send group discount rates and meal packages.',
                'status' => 'unread',
            ],
            [
                'name' => 'Sunil Wickramaratne',
                'email' => 'sunilw@yahoo.com',
                'phone' => '+94 71 998 8776',
                'subject' => 'Yala Safari + Kataragama 2 Days Package',
                'message' => 'We want to book 2 Executive Suites with Yala Jeep Safari arrangement for next Saturday. Please confirm availability.',
                'status' => 'replied',
            ],
        ];

        foreach ($inquiries as $inq) {
            Inquiry::updateOrCreate(['name' => $inq['name']], $inq);
        }
    }
}
