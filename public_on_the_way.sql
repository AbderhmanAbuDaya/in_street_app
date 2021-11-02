-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 17, 2021 at 03:55 PM
-- Server version: 8.0.21
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `public_on_the_way`
--

-- --------------------------------------------------------

--
-- Table structure for table `cites`
--

DROP TABLE IF EXISTS `cites`;
CREATE TABLE IF NOT EXISTS `cites` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `governate_id` bigint UNSIGNED NOT NULL,
  `name_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cites_governate_id_foreign` (`governate_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cites`
--

INSERT INTO `cites` (`id`, `governate_id`, `name_ar`, `name_en`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(1, 1, 'الخليل', 'Hebron', NULL, NULL, NULL, NULL),
(2, 2, 'بيت لحم', 'Bethlehem', NULL, NULL, NULL, NULL),
(3, 3, 'أريحا', 'Jericho', NULL, NULL, NULL, NULL),
(4, 4, 'رام الله ', 'Ramallah', NULL, NULL, NULL, NULL),
(5, 4, 'البيرة', 'Al-Bireh', NULL, NULL, NULL, NULL),
(6, 5, 'القدس', 'Jerusalem', NULL, NULL, NULL, NULL),
(7, 6, 'سلفيت', 'Salfit', NULL, NULL, NULL, NULL),
(8, 7, 'جنين', 'Jenin', NULL, NULL, NULL, NULL),
(9, 8, 'طولكرم', 'Tulkarem', NULL, NULL, NULL, NULL),
(10, 9, 'طوباس', 'Tubas', NULL, NULL, NULL, NULL),
(11, 10, 'نابلس', 'Nablus', NULL, NULL, NULL, NULL),
(12, 1, 'حلحول', 'Halhul', NULL, NULL, NULL, NULL),
(13, 1, 'دورا', 'Dora', NULL, NULL, NULL, NULL),
(14, 1, 'يطا', 'Yatta', NULL, NULL, NULL, NULL),
(15, 1, 'الظاهرية', 'Al-Thahriyya', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `custom_locations`
--

DROP TABLE IF EXISTS `custom_locations`;
CREATE TABLE IF NOT EXISTS `custom_locations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `custom_locations_user_id_foreign` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

DROP TABLE IF EXISTS `drivers`;
CREATE TABLE IF NOT EXISTS `drivers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `license_number` int NOT NULL,
  `license_issue_date` date NOT NULL,
  `license_expiry_date` date NOT NULL,
  `vehicle_type` bigint UNSIGNED NOT NULL,
  `vehicle_model` bigint UNSIGNED NOT NULL,
  `car_panel_number_int` int NOT NULL,
  `driver_license_image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicle_license_image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicle_insurance_image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicle_front_image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicle_back_image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_operation_path` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `drivers_user_id_foreign` (`user_id`),
  KEY `drivers_vehicle_type_foreign` (`vehicle_type`),
  KEY `drivers_vehicle_model_foreign` (`vehicle_model`),
  KEY `drivers_parent_operation_path_foreign` (`parent_operation_path`),
  KEY `drivers_status_foreign` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `user_id`, `license_number`, `license_issue_date`, `license_expiry_date`, `vehicle_type`, `vehicle_model`, `car_panel_number_int`, `driver_license_image`, `vehicle_license_image`, `vehicle_insurance_image`, `vehicle_front_image`, `vehicle_back_image`, `parent_operation_path`, `created_at`, `updated_at`, `status`) VALUES
(1, 3, 8569245, '2021-10-12', '2021-10-18', 10, 11, 5, 'drivers/Y7cB1mZYZD2iUPd7mSQdAX2zX5dRUBjFmQ5Kze15.png', 'drivers/1uQYIH04mnfU5mW5nHWHIDDANu9ydIsgveoRo8AO.png', 'drivers/9KP9iFeuaPsHnWL6orbyW5OeQOnUqZfHtnmD89Ev.png', 'drivers/dwuL3TE4ZPWB8wvaaszYxV1UOiMz9r6flnqZ3XLb.png', 'drivers/TFO0C43R1LcDDSDF1DUc9iDWshrFHXKMnZYy9m4V.png', 1, '2021-10-17 11:54:50', '2021-10-17 11:54:50', 8),
(2, 1, 8569245, '2021-10-12', '2021-10-18', 9, 12, 5, 'drivers/S58XzJqmyAd6Bhb58wKW1FhXs9SyFb5I4NTnSytC.png', 'drivers/Q4S1qdrMeV1cjyOKDi85vamLww5VVVlHbhAtxJBf.png', 'drivers/fZrNsY3vzXf6DxHxKTrZMysZK8QYYASHV3SIXpIX.png', 'drivers/lXzaRisvY2nTiBFHVPiETUvNG8zT7OQ6TRWlVm0d.png', 'drivers/aAv7s1GwKTWJy3je9VQ0CV1YtcRHYhu4YOiUDE3g.png', 2, '2021-10-17 11:55:32', '2021-10-17 11:55:32', 8);

-- --------------------------------------------------------

--
-- Table structure for table `governates`
--

DROP TABLE IF EXISTS `governates`;
CREATE TABLE IF NOT EXISTS `governates` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `governates`
--

INSERT INTO `governates` (`id`, `name_ar`, `name_en`, `created_at`, `updated_at`) VALUES
(1, 'الخليل', 'Hebron', NULL, NULL),
(2, 'بيت لحم', 'Bethlehem', NULL, NULL),
(3, 'أريحا', 'Jericho', NULL, NULL),
(4, 'رام الله والبيرة', 'Ramallah & Al-Bireh', NULL, NULL),
(5, 'القدس', 'Jerusalem', NULL, NULL),
(6, 'سلفيت', 'Salfit', NULL, NULL),
(7, 'جنين', 'Jenin', NULL, NULL),
(8, 'طولكرم', 'Tulkarem', NULL, NULL),
(9, 'طوباس', 'Tubas', NULL, NULL),
(10, 'نابلس', 'Nablus', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lookups`
--

DROP TABLE IF EXISTS `lookups`;
CREATE TABLE IF NOT EXISTS `lookups` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `lookup_id` bigint UNSIGNED NOT NULL,
  `value_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lookups_lookup_id_foreign` (`lookup_id`),
  KEY `lookups_value_id_foreign` (`value_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lookups`
--

INSERT INTO `lookups` (`id`, `lookup_id`, `value_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 1, 2, NULL, NULL),
(3, 1, 3, NULL, NULL),
(4, 1, 4, NULL, NULL),
(5, 1, 5, NULL, NULL),
(6, 1, 6, NULL, NULL),
(7, 2, 7, NULL, NULL),
(8, 2, 8, NULL, NULL),
(9, 3, 9, NULL, NULL),
(10, 3, 10, NULL, NULL),
(11, 4, 11, NULL, NULL),
(12, 4, 12, NULL, NULL),
(13, 4, 13, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lookup_names`
--

DROP TABLE IF EXISTS `lookup_names`;
CREATE TABLE IF NOT EXISTS `lookup_names` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lookup_names`
--

INSERT INTO `lookup_names` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'region_type', NULL, NULL),
(2, 'driver_request_status', NULL, NULL),
(3, 'vehicle_size', NULL, NULL),
(4, 'vehicle_model', NULL, NULL),
(5, 'driver_status', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lookup_values`
--

DROP TABLE IF EXISTS `lookup_values`;
CREATE TABLE IF NOT EXISTS `lookup_values` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_en` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_ar` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lookup_values`
--

INSERT INTO `lookup_values` (`id`, `name_en`, `name_ar`, `created_at`, `updated_at`) VALUES
(1, 'City', 'مدينة', NULL, NULL),
(2, 'Village', 'قرية', NULL, NULL),
(3, 'Camp', 'مخيم', NULL, NULL),
(4, 'Town', 'بلدة', NULL, NULL),
(5, 'Kherbih', 'خربة', NULL, NULL),
(6, 'Lounge', 'استراحة', NULL, NULL),
(7, 'approve', 'موافق', NULL, NULL),
(8, 'deny', 'غير موافق', NULL, NULL),
(9, 'large', 'كبير', NULL, NULL),
(10, 'small', 'صغير', NULL, NULL),
(11, 'Mercedes', 'مرسيدس ', NULL, NULL),
(12, 'Caravelle', 'كارافيل ', NULL, NULL),
(13, 'Ford Transit', 'فورد ترانسيت ', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(3, '2021_09_05_110918_create_types_table', 1),
(26, '2021_10_17_125736_add_colume_status_in_drivers_table', 6),
(19, '2021_10_04_231643_create_parent_operation_paths_table', 3),
(6, '2021_10_04_231745_create_governates_table', 1),
(7, '2021_10_04_231843_create_cites_table', 1),
(8, '2021_10_04_232125_create_regines_table', 1),
(9, '2021_10_05_215328_create_operation_paths_table', 1),
(10, '2021_10_05_215421_create_trips_table', 1),
(11, '2021_10_05_215506_create_trip_evaluation_table', 1),
(12, '2021_10_05_215549_create_pick_up_request_table', 1),
(13, '2021_10_05_221215_create_notifications_table', 1),
(14, '2021_10_05_221744_create_custom_locations_table', 1),
(15, '2021_10_05_221930_create_user_evaluations_table', 1),
(17, '2021_10_14_220139_add_colume_verification_code_table', 2),
(20, '2021_10_17_104156_create_lookup_names_table', 4),
(21, '2021_10_17_104250_create_lookup_values_table', 4),
(22, '2021_10_17_104306_create_lookups_table', 4),
(23, '2021_10_17_114400_add_colume_is_admin_in_users_table', 5),
(25, '2021_10_04_225057_create_drivers_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `request_id` bigint UNSIGNED NOT NULL,
  `notification_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `notification_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_on_screen` tinyint(1) NOT NULL,
  `is_sent` tinyint(1) NOT NULL,
  `is_opened` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `notifications_client_id_foreign` (`client_id`),
  KEY `notifications_request_id_foreign` (`request_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `operation_paths`
--

DROP TABLE IF EXISTS `operation_paths`;
CREATE TABLE IF NOT EXISTS `operation_paths` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_operation_path_id` bigint UNSIGNED NOT NULL,
  `source` int NOT NULL,
  `destination` double NOT NULL,
  `cost` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `operation_paths_parent_operation_path_id_foreign` (`parent_operation_path_id`)
) ENGINE=MyISAM AUTO_INCREMENT=187 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `operation_paths`
--

INSERT INTO `operation_paths` (`id`, `parent_operation_path_id`, `source`, `destination`, `cost`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 59, NULL, '2021-10-16 19:42:53', '2021-10-16 19:42:53'),
(2, 1, 59, 1, NULL, '2021-10-16 19:42:53', '2021-10-16 19:42:53'),
(3, 2, 1, 62, NULL, '2021-10-16 19:42:53', '2021-10-16 19:42:53'),
(4, 2, 62, 1, NULL, '2021-10-16 19:42:53', '2021-10-16 19:42:53'),
(5, 3, 1, 63, NULL, '2021-10-16 19:42:53', '2021-10-16 19:42:53'),
(6, 3, 63, 1, NULL, '2021-10-16 19:42:53', '2021-10-16 19:42:53'),
(7, 4, 1, 64, NULL, '2021-10-16 19:42:53', '2021-10-16 19:42:53'),
(8, 4, 64, 1, NULL, '2021-10-16 19:42:53', '2021-10-16 19:42:53'),
(9, 5, 1, 27, NULL, '2021-10-16 19:42:53', '2021-10-16 19:42:53'),
(10, 5, 27, 1, NULL, '2021-10-16 19:42:53', '2021-10-16 19:42:53'),
(11, 6, 1, 2, NULL, '2021-10-16 19:42:53', '2021-10-16 19:42:53'),
(12, 6, 2, 1, NULL, '2021-10-16 19:42:53', '2021-10-16 19:42:53'),
(13, 7, 1, 3, NULL, '2021-10-16 19:42:53', '2021-10-16 19:42:53'),
(14, 7, 3, 1, NULL, '2021-10-16 19:42:53', '2021-10-16 19:42:53'),
(15, 8, 1, 4, NULL, '2021-10-16 19:42:53', '2021-10-16 19:42:53'),
(16, 8, 4, 1, NULL, '2021-10-16 19:42:53', '2021-10-16 19:42:53'),
(17, 9, 1, 5, NULL, '2021-10-16 19:42:53', '2021-10-16 19:42:53'),
(18, 9, 5, 1, NULL, '2021-10-16 19:42:53', '2021-10-16 19:42:53'),
(19, 10, 1, 6, NULL, '2021-10-16 19:42:53', '2021-10-16 19:42:53'),
(20, 10, 6, 1, NULL, '2021-10-16 19:42:53', '2021-10-16 19:42:53'),
(21, 11, 1, 7, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(22, 11, 7, 1, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(23, 12, 1, 8, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(24, 12, 8, 1, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(25, 13, 1, 9, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(26, 13, 9, 1, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(27, 14, 1, 10, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(28, 14, 10, 1, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(29, 15, 1, 11, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(30, 15, 11, 1, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(31, 16, 1, 12, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(32, 16, 12, 1, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(33, 17, 1, 13, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(34, 17, 13, 1, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(35, 18, 1, 14, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(36, 18, 14, 1, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(37, 19, 1, 15, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(38, 19, 15, 1, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(39, 20, 1, 16, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(40, 20, 16, 1, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(41, 21, 1, 17, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(42, 21, 17, 1, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(43, 22, 1, 18, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(44, 22, 18, 1, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(45, 23, 1, 19, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(46, 23, 19, 1, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(47, 24, 1, 20, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(48, 24, 20, 1, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(49, 25, 1, 21, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(50, 25, 21, 1, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(51, 26, 1, 22, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(52, 26, 22, 1, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(53, 27, 1, 23, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(54, 27, 23, 1, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(55, 28, 1, 24, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(56, 28, 24, 1, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(57, 29, 1, 25, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(58, 29, 25, 1, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(59, 30, 1, 26, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(60, 30, 26, 1, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(61, 31, 17, 62, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(62, 31, 62, 17, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(63, 32, 11, 62, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(64, 32, 62, 11, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(65, 33, 12, 62, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(66, 33, 62, 12, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(67, 34, 18, 62, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(68, 34, 62, 18, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(69, 35, 18, 59, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(70, 35, 59, 18, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(71, 36, 18, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(72, 36, 27, 18, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(73, 37, 18, 1, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(74, 37, 1, 18, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(75, 38, 18, 20, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(76, 38, 20, 18, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(77, 39, 18, 19, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(78, 39, 19, 18, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(79, 40, 23, 62, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(80, 40, 62, 23, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(81, 41, 23, 59, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(82, 41, 59, 23, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(83, 42, 23, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(84, 42, 27, 23, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(85, 43, 23, 63, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(86, 43, 63, 23, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(87, 44, 23, 19, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(88, 44, 19, 23, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(89, 45, 23, 21, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(90, 45, 21, 23, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(91, 46, 23, 13, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(92, 46, 13, 23, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(93, 47, 21, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(94, 47, 27, 21, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(95, 48, 21, 62, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(96, 48, 62, 21, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(97, 49, 21, 59, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(98, 49, 59, 21, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(99, 50, 21, 63, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(100, 50, 63, 21, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(101, 51, 21, 22, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(102, 51, 22, 21, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(103, 52, 26, 62, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(104, 52, 62, 26, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(105, 53, 27, 59, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(106, 53, 59, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(107, 54, 27, 62, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(108, 54, 62, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(109, 55, 27, 63, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(110, 55, 63, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(111, 56, 27, 64, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(112, 56, 64, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(113, 57, 27, 1, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(114, 57, 1, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(115, 58, 27, 61, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(116, 58, 61, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(117, 59, 27, 28, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(118, 59, 28, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(119, 60, 27, 29, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(120, 60, 29, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(121, 61, 27, 30, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(122, 61, 30, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(123, 62, 27, 31, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(124, 62, 31, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(125, 63, 27, 32, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(126, 63, 32, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(127, 64, 27, 33, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(128, 64, 33, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(129, 65, 27, 34, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(130, 65, 34, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(131, 66, 27, 35, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(132, 66, 35, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(133, 67, 27, 36, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(134, 67, 36, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(135, 68, 27, 37, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(136, 68, 37, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(137, 69, 27, 38, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(138, 69, 38, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(139, 70, 27, 39, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(140, 70, 39, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(141, 71, 27, 40, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(142, 71, 40, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(143, 72, 27, 41, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(144, 72, 41, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(145, 73, 27, 42, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(146, 73, 42, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(147, 74, 27, 2, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(148, 74, 2, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(149, 75, 27, 8, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(150, 75, 8, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(151, 76, 27, 43, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(152, 76, 43, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(153, 77, 27, 44, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(154, 77, 44, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(155, 78, 27, 45, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(156, 78, 45, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(157, 79, 27, 46, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(158, 79, 46, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(159, 80, 27, 47, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(160, 80, 47, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(161, 81, 27, 48, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(162, 81, 48, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(163, 82, 27, 49, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(164, 82, 49, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(165, 83, 27, 50, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(166, 83, 50, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(167, 84, 27, 51, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(168, 84, 51, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(169, 85, 27, 52, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(170, 85, 52, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(171, 86, 27, 53, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(172, 86, 53, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(173, 87, 27, 54, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(174, 87, 54, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(175, 88, 27, 55, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(176, 88, 55, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(177, 89, 27, 56, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(178, 89, 56, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(179, 90, 27, 57, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(180, 90, 57, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(181, 91, 27, 71, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(182, 91, 71, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(183, 92, 27, 58, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(184, 92, 58, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(185, 93, 27, 18, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28'),
(186, 93, 18, 27, NULL, '2021-10-16 21:05:28', '2021-10-16 21:05:28');

-- --------------------------------------------------------

--
-- Table structure for table `parent_operation_paths`
--

DROP TABLE IF EXISTS `parent_operation_paths`;
CREATE TABLE IF NOT EXISTS `parent_operation_paths` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `from` bigint UNSIGNED NOT NULL,
  `to` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_operation_paths_from_foreign` (`from`)
) ENGINE=MyISAM AUTO_INCREMENT=94 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `parent_operation_paths`
--

INSERT INTO `parent_operation_paths` (`id`, `from`, `to`, `created_at`, `updated_at`) VALUES
(1, 59, 1, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(2, 62, 1, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(3, 63, 1, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(4, 64, 1, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(5, 27, 1, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(6, 2, 1, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(7, 3, 1, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(8, 4, 1, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(9, 5, 1, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(10, 6, 1, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(11, 7, 1, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(12, 8, 1, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(13, 9, 1, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(14, 10, 1, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(15, 11, 1, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(16, 12, 1, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(17, 13, 1, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(18, 14, 1, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(19, 15, 1, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(20, 16, 1, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(21, 17, 1, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(22, 18, 1, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(23, 19, 1, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(24, 20, 1, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(25, 21, 1, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(26, 22, 1, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(27, 23, 1, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(28, 24, 1, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(29, 25, 1, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(30, 26, 1, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(31, 62, 17, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(32, 62, 11, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(33, 62, 12, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(34, 62, 18, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(35, 59, 18, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(36, 27, 18, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(37, 1, 18, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(38, 20, 18, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(39, 19, 18, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(40, 62, 23, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(41, 59, 23, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(42, 27, 23, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(43, 63, 23, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(44, 19, 23, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(45, 21, 23, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(46, 13, 23, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(47, 27, 21, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(48, 62, 21, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(49, 59, 21, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(50, 63, 21, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(51, 22, 21, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(52, 62, 26, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(53, 59, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(54, 62, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(55, 63, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(56, 64, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(57, 1, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(58, 61, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(59, 28, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(60, 29, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(61, 30, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(62, 31, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(63, 32, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(64, 33, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(65, 34, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(66, 35, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(67, 36, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(68, 37, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(69, 38, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(70, 39, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(71, 40, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(72, 41, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(73, 42, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(74, 2, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(75, 8, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(76, 43, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(77, 44, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(78, 45, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(79, 46, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(80, 47, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(81, 48, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(82, 49, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(83, 50, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(84, 51, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(85, 52, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(86, 53, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(87, 54, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(88, 55, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(89, 56, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(90, 57, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(91, 71, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(92, 58, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21'),
(93, 18, 27, '2021-10-16 11:12:21', '2021-10-16 11:12:21');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'idk', '5a2c8861e72d34cb27b61fc2936ccc99a3a700fb077a0e36b53abe4f6befbf2a', '[\"*\"]', '2021-10-17 12:32:30', '2021-10-08 20:07:48', '2021-10-17 12:32:30'),
(2, 'App\\Models\\User', 2, 'idk', 'd7777dfe2ae68735ce0f23c6e832567656ce45deac16a1d6cba4025efc69f9c1', '[\"*\"]', '2021-10-17 10:26:59', '2021-10-17 09:52:11', '2021-10-17 10:26:59'),
(3, 'App\\Models\\User', 3, 'idk', '1e553bc6d91e4c6ad01963ceb4669f661a3425a8df3201f4d260741558cc48db', '[\"*\"]', '2021-10-17 11:54:50', '2021-10-17 10:27:49', '2021-10-17 11:54:50');

-- --------------------------------------------------------

--
-- Table structure for table `pick_up_requests`
--

DROP TABLE IF EXISTS `pick_up_requests`;
CREATE TABLE IF NOT EXISTS `pick_up_requests` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `trip_id` bigint UNSIGNED NOT NULL,
  `operation_path_id` bigint UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `num_seats` int NOT NULL,
  `estimated_driver_arrival_time` int NOT NULL,
  `estimated_arrival_time` int NOT NULL,
  `actual_arrival_time` int NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `actual_cost` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `pick_up_requests_client_id_foreign` (`client_id`),
  KEY `pick_up_requests_trip_id_foreign` (`trip_id`),
  KEY `pick_up_requests_operation_path_id_foreign` (`operation_path_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

DROP TABLE IF EXISTS `regions`;
CREATE TABLE IF NOT EXISTS `regions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `city_id` bigint UNSIGNED NOT NULL,
  `type_id` int NOT NULL,
  `name_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `regions_city_id_foreign` (`city_id`)
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `regions`
--

INSERT INTO `regions` (`id`, `city_id`, `type_id`, `name_ar`, `name_en`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'الخليل', 'Hebron', NULL, NULL, NULL, NULL),
(2, 1, 3, 'مخيم العروب', 'Arroub Camp', NULL, NULL, NULL, NULL),
(3, 12, 4, 'حلحول (زبود)', 'Halhul (Zboud)', NULL, NULL, NULL, NULL),
(4, 12, 4, 'حلحول (النبي يونس)', 'Halhul (Nabi Younis)', NULL, NULL, NULL, NULL),
(5, 12, 4, 'حلحول (الحواور)', 'Halhul (Hawawer)', NULL, NULL, NULL, NULL),
(6, 1, 4, 'ترقوميا', 'Tarqumia', NULL, NULL, NULL, NULL),
(7, 1, 4, 'بيت كاحل', 'Beit Kahel', NULL, NULL, NULL, NULL),
(8, 1, 4, 'بيت امر', 'Beit Ummer', NULL, NULL, NULL, NULL),
(9, 1, 4, 'صوريف', 'Surif', NULL, NULL, NULL, NULL),
(10, 1, 4, 'خاراس', 'Kharas', NULL, NULL, NULL, NULL),
(11, 1, 4, 'نوبا', 'Nuba', NULL, NULL, NULL, NULL),
(12, 1, 4, 'بيت اولا', 'Beit Ola', NULL, NULL, NULL, NULL),
(13, 1, 4, 'إذنا', 'Ethna', NULL, NULL, NULL, NULL),
(14, 1, 4, 'تفوح', 'Taffuh', NULL, NULL, NULL, NULL),
(15, 1, 4, 'سعير', 'Su\'eer', NULL, NULL, NULL, NULL),
(16, 1, 2, 'الشيوخ', 'Shyookh', NULL, NULL, NULL, NULL),
(17, 1, 4, 'بني نعيم', 'Bani Na\'im', NULL, NULL, NULL, NULL),
(18, 14, 1, 'يطا', 'Yatta', NULL, NULL, NULL, NULL),
(19, 1, 4, 'السموع', 'Samoo', NULL, NULL, NULL, NULL),
(20, 1, 3, 'الفوار', 'Al-Fawwar Camp', NULL, NULL, NULL, NULL),
(21, 15, 1, 'الظاهرية', 'Al-Thahriyya', NULL, NULL, NULL, NULL),
(22, 15, 2, 'الرماضين', 'Al-Ramadin', NULL, NULL, NULL, NULL),
(23, 13, 1, 'دورا', 'Dora', NULL, NULL, NULL, NULL),
(24, 1, 2, 'الكرم-المورق', 'AlKaram-AlMowreq', NULL, NULL, NULL, NULL),
(25, 1, 2, 'دير سامت', 'Deir Samet', NULL, NULL, NULL, NULL),
(26, 1, 4, 'بيت عوا', 'Beit Awwa', NULL, NULL, NULL, NULL),
(27, 2, 1, 'بيت لحم', 'Bethlehem', NULL, NULL, NULL, NULL),
(28, 2, 2, 'زعترة', 'Za\'tara', NULL, NULL, NULL, NULL),
(29, 2, 4, 'تقوع', 'Tqoo', NULL, NULL, NULL, NULL),
(30, 2, 2, 'التعامرة', 'Al-Ta\'amra', NULL, NULL, NULL, NULL),
(31, 2, 2, 'الشواورة', 'Al-Shawawreh', NULL, NULL, NULL, NULL),
(32, 2, 2, 'المعصرة', 'Al-Ma\'sara', NULL, NULL, NULL, NULL),
(33, 2, 4, 'بيت فجار', 'Beit Fajjar', NULL, NULL, NULL, NULL),
(34, 2, 2, 'الجعبة', 'Al-Ju\'ba', NULL, NULL, NULL, NULL),
(35, 2, 2, 'اسكاريا', 'Iskarya', NULL, NULL, NULL, NULL),
(36, 2, 2, 'الولجة', 'Al-Walaja', NULL, NULL, NULL, NULL),
(37, 2, 4, 'العبيدية', 'Al-Ebedeya', NULL, NULL, NULL, NULL),
(38, 2, 2, 'دار صلاح', 'Dar Salah', NULL, NULL, NULL, NULL),
(39, 2, 2, 'واد النيص', 'Wad Al-Nees', NULL, NULL, NULL, NULL),
(40, 2, 2, 'جورة الشمعة', 'Juret Al-Sham\'a', NULL, NULL, NULL, NULL),
(41, 2, 2, 'مراح معلا', 'Marah M\'alla', NULL, NULL, NULL, NULL),
(42, 2, 2, 'ام سلمونة', 'Um-Samalona', NULL, NULL, NULL, NULL),
(43, 2, 2, 'خلة الحداد', 'Khellet Al-Haddad', NULL, NULL, NULL, NULL),
(44, 2, 2, 'ابو نجيم', 'Abu-Njeem', NULL, NULL, NULL, NULL),
(45, 2, 2, 'حلة اللوز', 'Hallat Al-Looz', NULL, NULL, NULL, NULL),
(46, 2, 2, 'الرشايدة', 'Al-Rashayda', NULL, NULL, NULL, NULL),
(47, 2, 2, 'واد رحال', 'Wad Rahhal', NULL, NULL, NULL, NULL),
(48, 2, 2, 'جناته', 'Janata', NULL, NULL, NULL, NULL),
(49, 2, 2, 'المنشية', 'Al-Mansheyya', NULL, NULL, NULL, NULL),
(50, 2, 2, 'الخاص و النعمان', 'Al-Khas W Al-No\'man', NULL, NULL, NULL, NULL),
(51, 2, 2, 'هندازة', 'Handaza', NULL, NULL, NULL, NULL),
(52, 2, 2, 'مراح رباح', 'Marah Rabah', NULL, NULL, NULL, NULL),
(53, 2, 2, 'بتير', 'Battir', NULL, NULL, NULL, NULL),
(54, 2, 2, 'حوسان', 'Husan', NULL, NULL, NULL, NULL),
(55, 2, 2, 'نحالين', 'Nahhalen', NULL, NULL, NULL, NULL),
(56, 2, 2, 'الخضر', 'Al-Khader', NULL, NULL, NULL, NULL),
(57, 2, 2, 'واد فوكين', 'Wad Fuqin', NULL, NULL, NULL, NULL),
(58, 2, 2, 'برك سليمان', 'Burak Sulaiman', NULL, NULL, NULL, NULL),
(59, 4, 1, 'رام الله', 'Ramallah', NULL, NULL, NULL, NULL),
(60, 5, 1, 'البيرة', 'Al-Bireh', NULL, NULL, NULL, NULL),
(61, 3, 1, 'أريحا', 'Jericho', NULL, NULL, NULL, NULL),
(62, 3, 6, 'استراحة أريحا', 'Jericho Lounge', NULL, NULL, NULL, NULL),
(63, 6, 4, 'أبو ديس', 'Anu Dis', NULL, NULL, NULL, NULL),
(64, 6, 4, 'العيزرية', 'Ezariyya', NULL, NULL, NULL, NULL),
(65, 6, 1, 'القدس', 'Jerusalem', NULL, NULL, NULL, NULL),
(66, 7, 1, 'سلفيت', 'Salfit', NULL, NULL, NULL, NULL),
(67, 8, 1, 'جنين', 'Jenin', NULL, NULL, NULL, NULL),
(68, 9, 1, 'طولكرم', 'Tulkarem', NULL, NULL, NULL, NULL),
(69, 10, 1, 'طوباس', 'Tubas', NULL, NULL, NULL, NULL),
(70, 11, 1, 'نابلس', 'Nablus', NULL, NULL, NULL, NULL),
(71, 6, 6, 'باب العامود', 'Bab Al-Amood', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

DROP TABLE IF EXISTS `trips`;
CREATE TABLE IF NOT EXISTS `trips` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `drive_id` bigint UNSIGNED NOT NULL,
  `operation_path_id` bigint UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `dateTime` date NOT NULL,
  `num_available_seats` int NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `trips_drive_id_foreign` (`drive_id`),
  KEY `trips_operation_path_id_foreign` (`operation_path_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trip_evaluation`
--

DROP TABLE IF EXISTS `trip_evaluation`;
CREATE TABLE IF NOT EXISTS `trip_evaluation` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `trip_id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `rating` double NOT NULL DEFAULT '0',
  `feedback` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `trip_evaluation_trip_id_foreign` (`trip_id`),
  KEY `trip_evaluation_client_id_foreign` (`client_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

DROP TABLE IF EXISTS `types`;
CREATE TABLE IF NOT EXISTS `types` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `types_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'driver', NULL, NULL),
(2, 'user', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_id` bigint UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verification_code_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_phone_number_unique` (`phone_number`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_type_id_foreign` (`type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `type_id`, `email`, `phone_number`, `image`, `password`, `is_admin`, `address`, `emergency_number`, `verification_code_date`, `created_at`, `updated_at`) VALUES
(1, 'Abderhman Daya', 1, 'abood@hotmail.com', '0592735486', 'users/qZ9pK7G17Ykv3px5FwRXsIOK3MLHtmNCPIjQWdfr.jpg', '$2y$10$FhWC0/y0u47uL5tzTOKiuOvrmzxEDQAyoxKfNHxlFdcBW/hs5IE/e', 1, 'alnassers -street', '4554556', NULL, '2021-10-08 20:07:48', '2021-10-16 07:35:23'),
(3, 'abedrahman abud daya', 1, 'abood@hotmail.com3', '05927354863', '', '$2y$10$xGVF.1DJ8smXM0OUJDY8OOPupgTg3SV7UJBgqkGeQ80DjvjidngSK', 0, NULL, NULL, NULL, '2021-10-17 10:27:49', '2021-10-17 10:27:49');

-- --------------------------------------------------------

--
-- Table structure for table `user_evaluations`
--

DROP TABLE IF EXISTS `user_evaluations`;
CREATE TABLE IF NOT EXISTS `user_evaluations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `drive_id` bigint UNSIGNED NOT NULL,
  `rating` double NOT NULL,
  `feedback` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_evaluations_user_id_foreign` (`user_id`),
  KEY `user_evaluations_drive_id_foreign` (`drive_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
