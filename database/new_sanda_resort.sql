-- =========================================================
-- New Sanda Guest House - Sella Katharagama
-- Complete MySQL Database Dump
-- Generated: 2026-11-23 10:27:51
-- Target: MySQL 5.7+ / 8.0+ / MariaDB
-- =========================================================

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+05:30";

CREATE DATABASE IF NOT EXISTS `new_sanda_resort` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `new_sanda_resort`;

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
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (1, 'Nivi Sanda Manager', 'admin@nivisandaresort.com', '+94 77 987 6543', 'admin', NULL, '$2y$12$lmvZo.exq/YlmVjpKHGhheIsodJRarrV5aSjLdIubPcUj81hKWqs.', NULL, '2026-11-23 09:33:45', '2026-11-23 09:33:45');
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (2, 'Guest House Reception', 'reception@nivisandaresort.com', '+94 47 223 5566', 'receptionist', NULL, '$2y$12$KGXLrB/ytj7XhcpF6GQmi.RZ0tbA4cVQEAYpCxhBYGnPHen2Pm8eG', NULL, '2026-11-23 09:33:45', '2026-11-23 09:33:45');
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (3, 'New Sanda Manager', 'admin@newsandaresort.com', '+94 77 987 6543', 'admin', NULL, '$2y$12$2YTuP706019Y3n.lyiUkK.HOpatYOcQ98KMxLq7VsFApIiBE22/mO', NULL, '2026-11-23 10:27:33', '2026-11-23 10:27:33');
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (4, 'Guest House Reception', 'reception@newsandaresort.com', '+94 47 223 5566', 'receptionist', NULL, '$2y$12$6NQwar0j8ndOzqMB2HezY.gEErBbmRDwOn67kHOsQW.kzZCVQ.aem', NULL, '2026-11-23 10:27:34', '2026-11-23 10:27:34');

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
INSERT INTO `room_types` (`id`, `name`, `slug`, `short_description`, `description`, `base_price_per_night`, `max_adults`, `max_children`, `bed_type`, `room_size`, `image`, `gallery`, `is_featured`, `status`, `created_at`, `updated_at`) VALUES (1, 'Standard A/C Double Room', 'standard-ac-double-room', 'Comfortable air-conditioned double room with king/queen bed, attached bathroom with hot shower, and free Wi-Fi.', 'A clean and restful room equipped with cold inverter air conditioning, plush double bed, attached private bathroom with hot water, ceiling fan, and clothes rack. Perfect for couples or small families visiting Kataragama.', 5500, 2, 1, '1 Double / King Bed', '220 sq ft', 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=800&q=80', '[\"https:\\/\\/images.unsplash.com\\/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=800&q=80\",\"https:\\/\\/images.unsplash.com\\/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=800&q=80\"]', 1, 'active', '2026-11-23 09:33:46', '2026-11-23 09:33:46');
INSERT INTO `room_types` (`id`, `name`, `slug`, `short_description`, `description`, `base_price_per_night`, `max_adults`, `max_children`, `bed_type`, `room_size`, `image`, `gallery`, `is_featured`, `status`, `created_at`, `updated_at`) VALUES (2, 'Budget Non-A/C Double Room', 'budget-non-ac-double-room', 'Affordable and clean double room with ceiling fan, attached bathroom, and free vehicle parking.', 'Economical choice for pilgrims and visitors seeking neat, spotless accommodation. Features a comfortable double bed, ceiling fan, attached bathroom, and peaceful ventilation.', 3500, 2, 1, '1 Double Bed', '200 sq ft', 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=800&q=80', '[\"https:\\/\\/images.unsplash.com\\/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=800&q=80\"]', 0, 'active', '2026-11-23 09:33:46', '2026-11-23 09:33:46');
INSERT INTO `room_types` (`id`, `name`, `slug`, `short_description`, `description`, `base_price_per_night`, `max_adults`, `max_children`, `bed_type`, `room_size`, `image`, `gallery`, `is_featured`, `status`, `created_at`, `updated_at`) VALUES (3, 'Family A/C Room (4-5 Guests)', 'family-ac-room', 'Spacious family room with two double beds, air conditioning, hot water bathroom, and room for the whole family.', 'Designed specifically for visiting families. Contains two large double beds, air conditioning, ceiling fan, attached modern bathroom with hot water, and ample space for luggage.', 8500, 4, 2, '2 Double Beds', '320 sq ft', 'https://images.unsplash.com/photo-1591088398332-8a7791972843?auto=format&fit=crop&w=800&q=80', '[\"https:\\/\\/images.unsplash.com\\/photo-1591088398332-8a7791972843?auto=format&fit=crop&w=800&q=80\"]', 1, 'active', '2026-11-23 09:33:46', '2026-11-23 09:33:46');
INSERT INTO `room_types` (`id`, `name`, `slug`, `short_description`, `description`, `base_price_per_night`, `max_adults`, `max_children`, `bed_type`, `room_size`, `image`, `gallery`, `is_featured`, `status`, `created_at`, `updated_at`) VALUES (4, 'Family Non-A/C Room (Budget Group)', 'family-non-ac-room', 'Spacious and low-cost family room with two double beds, ceiling fans, and attached bathroom for pilgrimage groups.', 'Great value for families and groups travelling to Ruhunu Kataragama Maha Devalaya and Kiri Vehera. Clean bedding, ceiling fans, and attached bathroom.', 5500, 4, 2, '2 Double Beds', '300 sq ft', 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=800&q=80', '[\"https:\\/\\/images.unsplash.com\\/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=800&q=80\"]', 0, 'active', '2026-11-23 09:33:46', '2026-11-23 09:33:46');

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
INSERT INTO `amenities` (`id`, `name`, `icon`, `category`, `created_at`, `updated_at`) VALUES (1, 'Air Conditioning', 'snowflake', 'room', '2026-11-23 09:33:46', '2026-11-23 09:33:46');
INSERT INTO `amenities` (`id`, `name`, `icon`, `category`, `created_at`, `updated_at`) VALUES (2, 'Ceiling Fan', 'wind', 'room', '2026-11-23 09:33:46', '2026-11-23 09:33:46');
INSERT INTO `amenities` (`id`, `name`, `icon`, `category`, `created_at`, `updated_at`) VALUES (3, 'Attached Bathroom', 'bath', 'room', '2026-11-23 09:33:46', '2026-11-23 09:33:46');
INSERT INTO `amenities` (`id`, `name`, `icon`, `category`, `created_at`, `updated_at`) VALUES (4, 'Hot Water Shower', 'shower', 'room', '2026-11-23 09:33:46', '2026-11-23 09:33:46');
INSERT INTO `amenities` (`id`, `name`, `icon`, `category`, `created_at`, `updated_at`) VALUES (5, 'Free Wi-Fi', 'wifi', 'resort', '2026-11-23 09:33:46', '2026-11-23 09:33:46');
INSERT INTO `amenities` (`id`, `name`, `icon`, `category`, `created_at`, `updated_at`) VALUES (6, 'Secure Vehicle Parking', 'car', 'resort', '2026-11-23 09:33:46', '2026-11-23 09:33:46');
INSERT INTO `amenities` (`id`, `name`, `icon`, `category`, `created_at`, `updated_at`) VALUES (7, 'LED TV', 'tv', 'room', '2026-11-23 09:33:46', '2026-11-23 09:33:46');
INSERT INTO `amenities` (`id`, `name`, `icon`, `category`, `created_at`, `updated_at`) VALUES (8, 'Home-Cooked Food on Request', 'utensils', 'resort', '2026-11-23 09:33:46', '2026-11-23 09:33:46');
INSERT INTO `amenities` (`id`, `name`, `icon`, `category`, `created_at`, `updated_at`) VALUES (9, '24/7 Water & Power Backup', 'bolt', 'resort', '2026-11-23 09:33:46', '2026-11-23 09:33:46');
INSERT INTO `amenities` (`id`, `name`, `icon`, `category`, `created_at`, `updated_at`) VALUES (10, 'Near Sella Temple & Menik Ganga', 'location-dot', 'resort', '2026-11-23 09:33:46', '2026-11-23 09:33:46');

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
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (7, 2, 1, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (8, 2, 2, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (9, 2, 3, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (10, 2, 4, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (11, 2, 5, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (12, 2, 6, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (13, 3, 1, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (14, 3, 2, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (15, 3, 3, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (16, 3, 4, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (17, 3, 5, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (18, 3, 6, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (19, 4, 1, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (20, 4, 2, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (21, 4, 3, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (22, 4, 4, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (23, 4, 5, NULL, NULL);
INSERT INTO `room_type_amenity` (`id`, `room_type_id`, `amenity_id`, `created_at`, `updated_at`) VALUES (24, 4, 6, NULL, NULL);

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
INSERT INTO `rooms` (`id`, `room_type_id`, `room_number`, `floor_wing`, `status`, `notes`, `created_at`, `updated_at`) VALUES (1, 1, 'Room 01', 'Ground Floor', 'available', NULL, '2026-11-23 09:33:46', '2026-11-23 09:33:46');
INSERT INTO `rooms` (`id`, `room_type_id`, `room_number`, `floor_wing`, `status`, `notes`, `created_at`, `updated_at`) VALUES (2, 1, 'Room 02', 'Ground Floor', 'available', NULL, '2026-11-23 09:33:46', '2026-11-23 09:33:46');
INSERT INTO `rooms` (`id`, `room_type_id`, `room_number`, `floor_wing`, `status`, `notes`, `created_at`, `updated_at`) VALUES (3, 2, 'Room 03', 'Ground Floor', 'available', NULL, '2026-11-23 09:33:46', '2026-11-23 09:33:46');
INSERT INTO `rooms` (`id`, `room_type_id`, `room_number`, `floor_wing`, `status`, `notes`, `created_at`, `updated_at`) VALUES (4, 3, 'Room 04', 'First Floor', 'available', NULL, '2026-11-23 09:33:46', '2026-11-23 09:33:46');
INSERT INTO `rooms` (`id`, `room_type_id`, `room_number`, `floor_wing`, `status`, `notes`, `created_at`, `updated_at`) VALUES (5, 3, 'Room 05', 'First Floor', 'available', NULL, '2026-11-23 09:33:46', '2026-11-23 09:33:46');
INSERT INTO `rooms` (`id`, `room_type_id`, `room_number`, `floor_wing`, `status`, `notes`, `created_at`, `updated_at`) VALUES (6, 4, 'Room 06', 'First Floor', 'available', NULL, '2026-11-23 09:33:46', '2026-11-23 09:33:46');

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
INSERT INTO `addons` (`id`, `name`, `description`, `price`, `price_type`, `icon`, `is_active`, `created_at`, `updated_at`) VALUES (1, 'Extra Single Mattress & Pillow', 'Comfortable single mattress with clean bedsheet, blanket, and pillow for an additional guest.', 1000, 'per_night', 'bed', 1, '2026-11-23 09:33:46', '2026-11-23 09:33:46');
INSERT INTO `addons` (`id`, `name`, `description`, `price`, `price_type`, `icon`, `is_active`, `created_at`, `updated_at`) VALUES (2, 'Home-Cooked Breakfast (Per Person)', 'Traditional Sri Lankan breakfast (Roti or String Hoppers with dhal & lunu miris, tea).', 600, 'per_person', 'utensils', 1, '2026-11-23 09:33:46', '2026-11-23 09:33:46');
INSERT INTO `addons` (`id`, `name`, `description`, `price`, `price_type`, `icon`, `is_active`, `created_at`, `updated_at`) VALUES (3, 'Kataragama Devalaya Transport / Tuk-Tuk', 'Assistance with local vehicle or three-wheeler to Kataragama temple & Kiri Vehera.', 1200, 'per_booking', 'car', 1, '2026-11-23 09:33:46', '2026-11-23 09:33:46');

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
INSERT INTO `reviews` (`id`, `guest_name`, `guest_location`, `rating`, `comment`, `stay_date`, `is_approved`, `created_at`, `updated_at`) VALUES (1, 'Lalith & Family', 'Colombo', 5, 'Very clean and peaceful place to stay with family for Kataragama pilgrimage. Hot water and A/C worked perfectly, and ample space to park our van.', 'Recent Stay', 1, '2026-11-23 09:33:46', '2026-11-23 09:33:46');
INSERT INTO `reviews` (`id`, `guest_name`, `guest_location`, `rating`, `comment`, `stay_date`, `is_approved`, `created_at`, `updated_at`) VALUES (2, 'Nadeeka Priyadharshani', 'Kandy', 5, 'Affordable rates and very friendly owner. Sella Kataragama temple is just a few minutes away. Highly recommended for families.', 'Recent Stay', 1, '2026-11-23 09:33:46', '2026-11-23 09:33:46');

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
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (1, 'resort_name', 'New Sanda Holiday Home & Guest House', '2026-11-23 09:33:45', '2026-11-23 10:27:34');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (2, 'resort_tagline', 'Clean, Comfortable & Affordable Family Stay in Sella Katharagama', '2026-11-23 09:33:45', '2026-11-23 09:33:45');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (3, 'phone', '+94 77 987 6543', '2026-11-23 09:33:45', '2026-11-23 09:33:45');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (4, 'hotline', '+94 47 223 5566', '2026-11-23 09:33:45', '2026-11-23 09:33:45');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (5, 'whatsapp', +94779876543, '2026-11-23 09:33:45', '2026-11-23 09:33:45');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (6, 'email', 'info@newsandaresort.com', '2026-11-23 09:33:45', '2026-11-23 10:27:34');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (7, 'address', 'No. 45, Sella Road, Sella Katharagama, Sri Lanka', '2026-11-23 09:33:46', '2026-11-23 09:33:46');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (8, 'check_in_time', '02:00 PM', '2026-11-23 09:33:46', '2026-11-23 09:33:46');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (9, 'check_out_time', '11:00 AM', '2026-11-23 09:33:46', '2026-11-23 09:33:46');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (10, 'currency', 'LKR', '2026-11-23 09:33:46', '2026-11-23 09:33:46');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (11, 'currency_symbol', 'Rs.', '2026-11-23 09:33:46', '2026-11-23 09:33:46');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (12, 'bank_details', 'Bank: Bank of Ceylon (BOC)
Branch: Kataragama Branch
Account Name: New Sanda Guest House
Account No: 8876543201', '2026-11-23 09:33:46', '2026-11-23 10:27:34');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (13, 'about_text', 'New Sanda is a peaceful, family-run guest house situated in sacred Sella Katharagama. We offer clean, affordable A/C and Non-A/C rooms with attached bathrooms, hot water, free Wi-Fi, and spacious vehicle parking. Ideal for families, pilgrims visiting Ruhunu Kataragama Maha Devalaya, and travellers.', '2026-11-23 09:33:46', '2026-11-23 10:27:34');

SET FOREIGN_KEY_CHECKS=1;
COMMIT;
