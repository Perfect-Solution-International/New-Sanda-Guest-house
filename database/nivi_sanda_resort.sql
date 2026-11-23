-- =========================================================
-- Nivi Sanda Family Holiday Resort - Sella Katharagama
-- Complete MySQL Database Dump
-- Generated: 2026-11-23 09:27:24
-- Target: MySQL 5.7+ / 8.0+ / MariaDB
-- =========================================================

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+05:30";

CREATE DATABASE IF NOT EXISTS `nivi_sanda_resort` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `nivi_sanda_resort`;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `users`
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (1, 'Nivi Sanda General Manager', 'admin@nivisandaresort.com', '+94 77 987 6543', 'admin', NULL, '$2y$12$Hli9dvSdn8YgsJiNz.fDI.m48uNY45mGWNHnfUVWNN/jUc5RItemi', NULL, '2026-11-23 09:27:22', '2026-11-23 09:27:22');
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (2, 'Front Desk Reception', 'reception@nivisandaresort.com', '+94 47 223 5566', 'receptionist', NULL, '$2y$12$hlzH138w4Jxp5H/d0PYv..SgC6iuZo1fzoeucNCVPZKZkWDP2LkYy', NULL, '2026-11-23 09:27:22', '2026-11-23 09:27:22');

DROP TABLE IF EXISTS `room_types`;
CREATE TABLE `room_types` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `base_price_per_night` decimal(10,2) NOT NULL,
  `max_adults` int(11) NOT NULL DEFAULT '2',
  `max_children` int(11) NOT NULL DEFAULT '2',
  `bed_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1 King Bed',
  `room_size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '350 sq ft',
  `image` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gallery` json DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `room_types_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `room_types`
INSERT INTO `room_types` (`id`, `name`, `slug`, `short_description`, `description`, `base_price_per_night`, `max_adults`, `max_children`, `bed_type`, `room_size`, `image`, `gallery`, `is_featured`, `status`, `created_at`, `updated_at`) VALUES (1, 'Deluxe Family Villa (Pool View)', 'deluxe-family-villa', 'Ultra-spacious luxury villa designed for families, featuring two king beds, private veranda overlooking the swimming pool, and tropical open-air rain shower.', 'Our flagship Deluxe Family Villa is the ultimate comfort experience in Sella Katharagama. Crafted with refined wooden finishes and high ceilings, this villa accommodates up to 6 guests comfortably. Enjoy direct pool views, two plush king-sized spring beds, dedicated lounging sofa area, luxury modern bathroom with solar hot water, and tranquil veranda where you can sip your morning Ceylon tea amidst tropical birdsong.', 28500, 4, 2, '2 King Beds + 1 Daybed', '650 sq ft', 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80', '[\"https:\\/\\/images.unsplash.com\\/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80\",\"https:\\/\\/images.unsplash.com\\/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=1200&q=80\",\"https:\\/\\/images.unsplash.com\\/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80\"]', 1, 'active', '2026-11-23 09:27:22', '2026-11-23 09:27:22');
INSERT INTO `room_types` (`id`, `name`, `slug`, `short_description`, `description`, `base_price_per_night`, `max_adults`, `max_children`, `bed_type`, `room_size`, `image`, `gallery`, `is_featured`, `status`, `created_at`, `updated_at`) VALUES (2, 'Luxury River-Breeze Cabana', 'luxury-river-breeze-cabana', 'Charming eco-luxurious wooden cabana surrounded by coconut palms and birds, equipped with king bed, air conditioning, and serene sit-out patio.', 'Experience nature with luxury in our standalone River-Breeze Cabanas. Perfect for couples or small families, each cabana offers complete privacy, eco-friendly wooden aesthetics, whisper-quiet air conditioning, 43-inch smart TV, luxury mattress, mini-fridge, and an attached garden-view bathroom with hot shower.', 22000, 2, 2, '1 King Bed + 1 Single Bed', '480 sq ft', 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=80', '[\"https:\\/\\/images.unsplash.com\\/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=80\",\"https:\\/\\/images.unsplash.com\\/photo-1591088398332-8a7791972843?auto=format&fit=crop&w=1200&q=80\"]', 1, 'active', '2026-11-23 09:27:22', '2026-11-23 09:27:22');
INSERT INTO `room_types` (`id`, `name`, `slug`, `short_description`, `description`, `base_price_per_night`, `max_adults`, `max_children`, `bed_type`, `room_size`, `image`, `gallery`, `is_featured`, `status`, `created_at`, `updated_at`) VALUES (3, 'Executive Nature Suite', 'executive-nature-suite', 'Contemporary luxury room featuring a king bed, work corner, panoramic nature views, and modern comforts ideal for relaxing weekend getaways.', 'The Executive Nature Suite brings refined comfort to your spiritual and safari vacation. Fitted with premium linens, soundproofing, high-speed Wi-Fi, tea/coffee maker, modern en-suite bath, and easy access to the restaurant and swimming pool.', 17500, 2, 1, '1 King Bed', '400 sq ft', 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80', '[\"https:\\/\\/images.unsplash.com\\/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80\"]', 1, 'active', '2026-11-23 09:27:22', '2026-11-23 09:27:22');
INSERT INTO `room_types` (`id`, `name`, `slug`, `short_description`, `description`, `base_price_per_night`, `max_adults`, `max_children`, `bed_type`, `room_size`, `image`, `gallery`, `is_featured`, `status`, `created_at`, `updated_at`) VALUES (4, 'Standard Family Room', 'standard-family-room', 'Budget-friendly, spotless family room equipped with two queen beds, A/C, and attached bathroom. Perfect for pilgrimage and holiday groups.', 'Designed specifically for visiting families and pilgrimage devotees travelling together to Ruhunu Kataragama Maha Devalaya and Kiri Vehera. Clean, comfortable, fully air-conditioned, with pristine bedding and generous space for luggage.', 14000, 4, 1, '2 Queen Beds', '380 sq ft', 'https://images.unsplash.com/photo-1591088398332-8a7791972843?auto=format&fit=crop&w=1200&q=80', '[\"https:\\/\\/images.unsplash.com\\/photo-1591088398332-8a7791972843?auto=format&fit=crop&w=1200&q=80\"]', 0, 'active', '2026-11-23 09:27:22', '2026-11-23 09:27:22');

DROP TABLE IF EXISTS `amenities`;
CREATE TABLE `amenities` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'room',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `amenities`
INSERT INTO `amenities` (`id`, `name`, `icon`, `category`, `created_at`, `updated_at`) VALUES (1, 'Inverter Air Conditioning', 'wind', 'room', '2026-11-23 09:27:22', '2026-11-23 09:27:22');
INSERT INTO `amenities` (`id`, `name`, `icon`, `category`, `created_at`, `updated_at`) VALUES (2, 'Free High-Speed Wi-Fi', 'wifi', 'resort', '2026-11-23 09:27:22', '2026-11-23 09:27:22');
INSERT INTO `amenities` (`id`, `name`, `icon`, `category`, `created_at`, `updated_at`) VALUES (3, 'Swimming Pool & Kids Pool', 'water', 'resort', '2026-11-23 09:27:22', '2026-11-23 09:27:22');
INSERT INTO `amenities` (`id`, `name`, `icon`, `category`, `created_at`, `updated_at`) VALUES (4, 'Hot Water Shower', 'shower', 'room', '2026-11-23 09:27:22', '2026-11-23 09:27:22');
INSERT INTO `amenities` (`id`, `name`, `icon`, `category`, `created_at`, `updated_at`) VALUES (5, 'Private Balcony / Verandah', 'door-open', 'room', '2026-11-23 09:27:22', '2026-11-23 09:27:22');
INSERT INTO `amenities` (`id`, `name`, `icon`, `category`, `created_at`, `updated_at`) VALUES (6, 'Smart LED TV', 'tv', 'room', '2026-11-23 09:27:22', '2026-11-23 09:27:22');
INSERT INTO `amenities` (`id`, `name`, `icon`, `category`, `created_at`, `updated_at`) VALUES (7, 'Electric Kettle & Tea/Coffee', 'coffee', 'room', '2026-11-23 09:27:22', '2026-11-23 09:27:22');
INSERT INTO `amenities` (`id`, `name`, `icon`, `category`, `created_at`, `updated_at`) VALUES (8, 'Mini Refrigerator', 'snowflake', 'room', '2026-11-23 09:27:22', '2026-11-23 09:27:22');
INSERT INTO `amenities` (`id`, `name`, `icon`, `category`, `created_at`, `updated_at`) VALUES (9, 'Lush Garden & Mountain View', 'mountain', 'room', '2026-11-23 09:27:22', '2026-11-23 09:27:22');
INSERT INTO `amenities` (`id`, `name`, `icon`, `category`, `created_at`, `updated_at`) VALUES (10, 'Free Secure Parking', 'car', 'resort', '2026-11-23 09:27:22', '2026-11-23 09:27:22');
INSERT INTO `amenities` (`id`, `name`, `icon`, `category`, `created_at`, `updated_at`) VALUES (11, '24/7 Power Backup Generator', 'bolt', 'resort', '2026-11-23 09:27:22', '2026-11-23 09:27:22');
INSERT INTO `amenities` (`id`, `name`, `icon`, `category`, `created_at`, `updated_at`) VALUES (12, 'Restaurant & In-room Dining', 'utensils', 'resort', '2026-11-23 09:27:22', '2026-11-23 09:27:22');
INSERT INTO `amenities` (`id`, `name`, `icon`, `category`, `created_at`, `updated_at`) VALUES (13, 'Outdoor BBQ Facilities', 'fire', 'resort', '2026-11-23 09:27:22', '2026-11-23 09:27:22');
INSERT INTO `amenities` (`id`, `name`, `icon`, `category`, `created_at`, `updated_at`) VALUES (14, 'Kataragama Temple Shuttle', 'bus', 'resort', '2026-11-23 09:27:22', '2026-11-23 09:27:22');

DROP TABLE IF EXISTS `room_type_amenity`;
CREATE TABLE `room_type_amenity` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `room_type_id` bigint(20) UNSIGNED NOT NULL,
  `amenity_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rta_room_type_fk` (`room_type_id`),
  KEY `rta_amenity_fk` (`amenity_id`),
  CONSTRAINT `rta_room_type_fk` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rta_amenity_fk` FOREIGN KEY (`amenity_id`) REFERENCES `amenities` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `room_type_amenity`
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (1, 1, 1, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (2, 1, 2, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (3, 1, 3, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (4, 1, 4, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (5, 1, 5, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (6, 1, 6, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (7, 1, 7, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (8, 1, 8, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (9, 2, 1, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (10, 2, 2, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (11, 2, 3, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (12, 2, 4, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (13, 2, 5, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (14, 2, 6, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (15, 2, 7, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (16, 2, 8, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (17, 3, 1, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (18, 3, 2, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (19, 3, 3, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (20, 3, 4, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (21, 3, 5, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (22, 3, 6, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (23, 3, 7, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (24, 3, 8, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (25, 4, 1, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (26, 4, 2, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (27, 4, 3, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (28, 4, 4, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (29, 4, 5, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (30, 4, 6, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (31, 4, 7, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (32, 4, 8, NULL, NULL);

DROP TABLE IF EXISTS `rooms`;
CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `room_type_id` bigint(20) UNSIGNED NOT NULL,
  `room_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `floor_wing` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rooms_room_number_unique` (`room_number`),
  KEY `rooms_room_type_id_fk` (`room_type_id`),
  CONSTRAINT `rooms_room_type_id_fk` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `rooms`
INSERT INTO `rooms` (`id`, `room_type_id`, `room_number`, `floor_wing`, `status`, `notes`, `created_at`, `updated_at`) VALUES (1, 1, 'VILLA-101', 'Poolside Villa Wing', 'available', NULL, '2026-11-23 09:27:22', '2026-11-23 09:27:22');
INSERT INTO `rooms` (`id`, `room_type_id`, `room_number`, `floor_wing`, `status`, `notes`, `created_at`, `updated_at`) VALUES (2, 1, 'VILLA-102', 'Poolside Villa Wing', 'available', NULL, '2026-11-23 09:27:22', '2026-11-23 09:27:22');
INSERT INTO `rooms` (`id`, `room_type_id`, `room_number`, `floor_wing`, `status`, `notes`, `created_at`, `updated_at`) VALUES (3, 1, 'VILLA-103', 'Poolside Villa Wing', 'available', NULL, '2026-11-23 09:27:22', '2026-11-23 09:27:22');
INSERT INTO `rooms` (`id`, `room_type_id`, `room_number`, `floor_wing`, `status`, `notes`, `created_at`, `updated_at`) VALUES (4, 2, 'CABANA-201', 'Garden Cabana Lawn', 'available', NULL, '2026-11-23 09:27:23', '2026-11-23 09:27:23');
INSERT INTO `rooms` (`id`, `room_type_id`, `room_number`, `floor_wing`, `status`, `notes`, `created_at`, `updated_at`) VALUES (5, 2, 'CABANA-202', 'Garden Cabana Lawn', 'available', NULL, '2026-11-23 09:27:23', '2026-11-23 09:27:23');
INSERT INTO `rooms` (`id`, `room_type_id`, `room_number`, `floor_wing`, `status`, `notes`, `created_at`, `updated_at`) VALUES (6, 2, 'CABANA-203', 'Garden Cabana Lawn', 'available', NULL, '2026-11-23 09:27:23', '2026-11-23 09:27:23');
INSERT INTO `rooms` (`id`, `room_type_id`, `room_number`, `floor_wing`, `status`, `notes`, `created_at`, `updated_at`) VALUES (7, 2, 'CABANA-204', 'Garden Cabana Lawn', 'available', NULL, '2026-11-23 09:27:23', '2026-11-23 09:27:23');
INSERT INTO `rooms` (`id`, `room_type_id`, `room_number`, `floor_wing`, `status`, `notes`, `created_at`, `updated_at`) VALUES (8, 3, 'SUITE-301', 'Main Wing 1st Floor', 'available', NULL, '2026-11-23 09:27:23', '2026-11-23 09:27:23');
INSERT INTO `rooms` (`id`, `room_type_id`, `room_number`, `floor_wing`, `status`, `notes`, `created_at`, `updated_at`) VALUES (9, 3, 'SUITE-302', 'Main Wing 1st Floor', 'available', NULL, '2026-11-23 09:27:23', '2026-11-23 09:27:23');
INSERT INTO `rooms` (`id`, `room_type_id`, `room_number`, `floor_wing`, `status`, `notes`, `created_at`, `updated_at`) VALUES (10, 3, 'SUITE-303', 'Main Wing 1st Floor', 'available', NULL, '2026-11-23 09:27:23', '2026-11-23 09:27:23');
INSERT INTO `rooms` (`id`, `room_type_id`, `room_number`, `floor_wing`, `status`, `notes`, `created_at`, `updated_at`) VALUES (11, 4, 'FAM-401', 'Pilgrim Ground Wing', 'available', NULL, '2026-11-23 09:27:23', '2026-11-23 09:27:23');
INSERT INTO `rooms` (`id`, `room_type_id`, `room_number`, `floor_wing`, `status`, `notes`, `created_at`, `updated_at`) VALUES (12, 4, 'FAM-402', 'Pilgrim Ground Wing', 'available', NULL, '2026-11-23 09:27:23', '2026-11-23 09:27:23');
INSERT INTO `rooms` (`id`, `room_type_id`, `room_number`, `floor_wing`, `status`, `notes`, `created_at`, `updated_at`) VALUES (13, 4, 'FAM-403', 'Pilgrim Ground Wing', 'available', NULL, '2026-11-23 09:27:23', '2026-11-23 09:27:23');
INSERT INTO `rooms` (`id`, `room_type_id`, `room_number`, `floor_wing`, `status`, `notes`, `created_at`, `updated_at`) VALUES (14, 4, 'FAM-404', 'Pilgrim Ground Wing', 'available', NULL, '2026-11-23 09:27:23', '2026-11-23 09:27:23');

DROP TABLE IF EXISTS `addons`;
CREATE TABLE `addons` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `price_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'per_booking',
  `icon` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `addons`
INSERT INTO `addons` (`id`, `name`, `description`, `price`, `price_type`, `icon`, `is_active`, `created_at`, `updated_at`) VALUES (1, 'Yala National Park Safari (4x4 Jeep + Driver)', 'Half-day thrilling safari into Yala Block 1 or 5. Includes modified 4x4 open safari jeep, professional wildlife tracker driver, and pickup/drop from resort gate.', 19500, 'per_booking', 'truck', 1, '2026-11-23 09:27:23', '2026-11-23 09:27:23');
INSERT INTO `addons` (`id`, `name`, `description`, `price`, `price_type`, `icon`, `is_active`, `created_at`, `updated_at`) VALUES (2, 'Outdoor Poolside BBQ Dinner Setup', 'Freshly grilled chicken, fish, sausage skewers, butter corn, garlic bread, and tropical salad served beside the illuminated swimming pool under the night stars.', 8500, 'per_booking', 'fire', 1, '2026-11-23 09:27:23', '2026-11-23 09:27:23');
INSERT INTO `addons` (`id`, `name`, `description`, `price`, `price_type`, `icon`, `is_active`, `created_at`, `updated_at`) VALUES (3, 'Kataragama Devalaya Pooja Transport & Guidance', 'A/C van transfer to Maha Devalaya and Kiri Vehera, timing coordination for evening Pooja rituals, and assistance with fruit basket offerings.', 4500, 'per_booking', 'bus', 1, '2026-11-23 09:27:23', '2026-11-23 09:27:23');
INSERT INTO `addons` (`id`, `name`, `description`, `price`, `price_type`, `icon`, `is_active`, `created_at`, `updated_at`) VALUES (4, 'Extra Luxury Mattress & Linens', 'Additional comfortable single mattress with pillows, blanket, and bath towels for extra guest.', 3000, 'per_night', 'bed', 1, '2026-11-23 09:27:23', '2026-11-23 09:27:23');
INSERT INTO `addons` (`id`, `name`, `description`, `price`, `price_type`, `icon`, `is_active`, `created_at`, `updated_at`) VALUES (5, 'Traditional Southern Sri Lankan Breakfast (Per Person)', 'Delicious string hoppers, pol sambol, kiri hodhi, fish ambul thiyal, fresh fruit platter, and Ceylon tea.', 1500, 'per_person', 'utensils', 1, '2026-11-23 09:27:23', '2026-11-23 09:27:23');

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `booking_code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_type_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED DEFAULT NULL,
  `guest_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guest_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guest_phone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guest_nic_passport` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guest_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `nights` int(11) NOT NULL DEFAULT '1',
  `adults` int(11) NOT NULL DEFAULT '2',
  `children` int(11) NOT NULL DEFAULT '0',
  `room_rate` decimal(10,2) NOT NULL,
  `room_subtotal` decimal(10,2) NOT NULL,
  `addons_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_amount` decimal(10,2) NOT NULL,
  `advance_paid` decimal(10,2) NOT NULL DEFAULT '0.00',
  `balance_due` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_method` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cash',
  `booking_status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `special_requests` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bookings_booking_code_unique` (`booking_code`),
  KEY `bookings_room_type_id_fk` (`room_type_id`),
  KEY `bookings_room_id_fk` (`room_id`),
  CONSTRAINT `bookings_room_type_id_fk` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bookings_room_id_fk` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `booking_addons`;
CREATE TABLE `booking_addons` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `addon_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `unit_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ba_booking_id_fk` (`booking_id`),
  KEY `ba_addon_id_fk` (`addon_id`),
  CONSTRAINT `ba_booking_id_fk` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ba_addon_id_fk` FOREIGN KEY (`addon_id`) REFERENCES `addons` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `guest_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guest_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` int(11) NOT NULL DEFAULT '5',
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `stay_date` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `reviews`
INSERT INTO `reviews` (`id`, `guest_name`, `guest_location`, `rating`, `comment`, `stay_date`, `is_approved`, `created_at`, `updated_at`) VALUES (1, 'Lalith Warnakulasooriya & Family', 'Colombo, Sri Lanka', 5, 'Our 3-day family vacation at Nivi Sanda Resort was truly an unforgettable experience! Large swimming pool, delicious Sri Lankan rice & curry, and the staff helped us organize the Kataragama Pooja and Yala safari smoothly. Highly recommended for families!', 'October 2026', 1, '2026-11-23 09:27:23', '2026-11-23 09:27:23');
INSERT INTO `reviews` (`id`, `guest_name`, `guest_location`, `rating`, `comment`, `stay_date`, `is_approved`, `created_at`, `updated_at`) VALUES (2, 'Nadeeka Priyadharshani', 'Kurunegala', 5, 'Great ambiance in Sella Katharagama. Very clean cabanas with hot water and strong AC. Kids loved the swimming pool so much. Staff was exceptionally welcoming and helpful.', 'November 2026', 1, '2026-11-23 09:27:23', '2026-11-23 09:27:23');
INSERT INTO `reviews` (`id`, `guest_name`, `guest_location`, `rating`, `comment`, `stay_date`, `is_approved`, `created_at`, `updated_at`) VALUES (3, 'Asanka Jayawardena', 'Matara', 5, 'The best family holiday resort near Kataragama! Ample parking for large vans and buses, peaceful green environment away from noise, and great BBQ setup by the pool at night.', 'November 2026', 1, '2026-11-23 09:27:23', '2026-11-23 09:27:23');

DROP TABLE IF EXISTS `inquiries`;
CREATE TABLE `inquiries` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unread',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `inquiries`
INSERT INTO `inquiries` (`id`, `name`, `email`, `phone`, `subject`, `message`, `status`, `created_at`, `updated_at`) VALUES (1, 'Bandara Senadeera', 'bandara@gmail.com', '+94 77 443 3221', 'Family Gathering & 4 Rooms Booking for December', 'Hello, we are planning a family reunion of 18 members during late December. Can we reserve all 3 Deluxe Family Villas and 2 Cabanas? Please send group discount rates and meal packages.', 'unread', '2026-11-23 09:27:23', '2026-11-23 09:27:23');
INSERT INTO `inquiries` (`id`, `name`, `email`, `phone`, `subject`, `message`, `status`, `created_at`, `updated_at`) VALUES (2, 'Sunil Wickramaratne', 'sunilw@yahoo.com', '+94 71 998 8776', 'Yala Safari + Kataragama 2 Days Package', 'We want to book 2 Executive Suites with Yala Jeep Safari arrangement for next Saturday. Please confirm availability.', 'replied', '2026-11-23 09:27:23', '2026-11-23 09:27:23');

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `settings`
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (1, 'resort_name', 'Nivi Sanda Family Holiday Resort', '2026-11-23 09:27:22', '2026-11-23 09:27:22');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (2, 'resort_tagline', 'Your Serene Family Haven in Sacred Sella Katharagama', '2026-11-23 09:27:22', '2026-11-23 09:27:22');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (3, 'phone', '+94 77 987 6543', '2026-11-23 09:27:22', '2026-11-23 09:27:22');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (4, 'hotline', '+94 47 223 5566', '2026-11-23 09:27:22', '2026-11-23 09:27:22');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (5, 'whatsapp', +94779876543, '2026-11-23 09:27:22', '2026-11-23 09:27:22');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (6, 'email', 'info@nivisandaresort.com', '2026-11-23 09:27:22', '2026-11-23 09:27:22');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (7, 'address', 'No. 45, Sella Road, Sella Katharagama, Sri Lanka', '2026-11-23 09:27:22', '2026-11-23 09:27:22');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (8, 'check_in_time', '02:00 PM', '2026-11-23 09:27:22', '2026-11-23 09:27:22');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (9, 'check_out_time', '11:00 AM', '2026-11-23 09:27:22', '2026-11-23 09:27:22');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (10, 'currency', 'LKR', '2026-11-23 09:27:22', '2026-11-23 09:27:22');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (11, 'currency_symbol', 'Rs.', '2026-11-23 09:27:22', '2026-11-23 09:27:22');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (12, 'bank_details', 'Bank: Bank of Ceylon (BOC)
Branch: Kataragama Branch
Account Name: Nivi Sanda Holiday Resort
Account No: 8876543201', '2026-11-23 09:27:22', '2026-11-23 09:27:22');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (13, 'about_text', 'Nestled amidst the tranquil nature of Sella Katharagama and minutes away from the sacred Kataragama Devalaya and Yala National Park, Nivi Sanda Family Holiday Resort provides the ultimate peaceful escape for families, pilgrims, and nature lovers. Featuring lush tropical gardens, a sparkling swimming pool, spacious family villas, and warm Sri Lankan hospitality.', '2026-11-23 09:27:22', '2026-11-23 09:27:22');

SET FOREIGN_KEY_CHECKS=1;
COMMIT;
