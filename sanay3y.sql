-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2023 at 04:38 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sanay3y`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'admin',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_id` bigint(20) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `image`, `phone`, `role`, `address`, `city_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(7, 'Ahmed', 'ahmed@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ahhhhhhhhhhhhhhhhhh', '01097899008', 'admin', 'sajkajaska;', NULL, NULL, '2023-04-24 14:19:05', '2023-04-24 14:19:05');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 'نقاش', 'لعمل الدهانات والترميمات', 'aaaaaaaaaaaaaaaaaajjdsdjls;ajahf;ajdssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssdnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnssssssssssssssssssssssssssssssssssssssssssssssss', NULL, NULL),
(2, 'جبس بورد', 'لعمل الاسقف المعلقه', 'aadlkwwi', '2023-04-20 09:27:24', '2023-04-20 09:27:24'),
(3, 'سباك', 'عمل المواسير والصرف', 'ffffffffffffffffffffffffaffhsf', '2023-04-20 09:30:26', '2023-04-20 09:30:26');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT current_timestamp(),
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active_status` tinyint(1) NOT NULL DEFAULT 0,
  `dark_mode` tinyint(1) NOT NULL DEFAULT 0,
  `messenger_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#2180f3',
  `city_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `phone`, `address`, `active_status`, `dark_mode`, `messenger_color`, `city_id`, `image`, `status`, `role`, `created_at`, `updated_at`) VALUES
(7, 'hamsa', 'hamsa@gmail.com', NULL, '$2y$10$LKmPpqwFpKHc5OKVw6GEwuYfc.eps/GBhjNsz6dDHTvAezmTzq4gK', NULL, '01097899008', 'jalahdldwi', 0, 0, '#2180f3', 0, 'kljdhsdhfdlkfhiskkkkkkkkkkkkkkkkkkkkkkkkkkljdhsdhfdlkfhiskkkkkkkkkkkkkkkkkkkkkkkkk\nkljdhsdhfdlkfhiskkkkkkkkkkkkkkkkkkkkkkkkk', 'active', 'customer', '2023-04-20 09:56:39', '2023-04-20 09:56:39'),
(8, 'hamsa', 'haesa@gmail.com', NULL, '$2y$10$50.N1XB6SmxesSS0w1.f2.ywqPEhTZXkFX3lnzkQFRdbzmrL5lshC', NULL, '01097899008', 'jalahdldwi', 0, 0, '#2180f3', 0, 'kljdhsdhfdlkfhiskkkkkkkkkkkkkkkkkkkkkkkkkkljdhsdhfdlkfhiskkkkkkkkkkkkkkkkkkkkkkkkk\nkljdhsdhfdlkfhiskkkkkkkkkkkkkkkkkkkkkkkkk', 'active', 'customer', '2023-04-24 11:03:00', '2023-04-24 11:03:00'),
(9, 'hamsa', 'haes3a@gmail.com', NULL, '$2y$10$uZwXagvBza.K.e/NNhkIbOukdtk/ogwR4wO3XtRDTRTtAQtebrAi2', NULL, '01097899008', 'jalahdldwi', 0, 0, '#2180f3', 0, 'kljdhsdhfdlkfhiskkkkkkkkkkkkkkkkkkkkkkkkkkljdhsdhfdlkfhiskkkkkkkkkkkkkkkkkkkkkkkkk\nkljdhsdhfdlkfhiskkkkkkkkkkkkkkkkkkkkkkkkk', 'active', 'customer', '2023-04-24 11:04:52', '2023-04-24 11:04:52'),
(10, 'hamsa', 'haa@gmail.com', NULL, '$2y$10$u9gUDak5yFoG3m2t32qgle/UZKflXmvjWaTN7SVvCG//b878TVX6S', NULL, '01097899008', 'jalahdldwi', 0, 0, '#2180f3', 0, 'kljdhsdhfdlkfhiskkkkkkkkkkkkkkkkkkkkkkkkkkljdhsdhfdlkfhiskkkkkkkkkkkkkkkkkkkkkkkkk\nkljdhsdhfdlkfhiskkkkkkkkkkkkkkkkkkkkkkkkk', 'active', 'customer', '2023-04-26 06:17:01', '2023-04-26 06:17:01'),
(12, 'hamsa', 'riri@gmail.com', '2023-04-26 11:28:30', '$2y$10$EvHLszg9Fb7akmblq1Uvy.BWCvuCShK1QeMWP.8R/EB7mMpK6jgSq', NULL, '01097899008', 'jalahdldwi', 0, 0, '#2180f3', 16, 'kljdhsdhfdlkfhiskkkkkkkkkkkkkkkkkkkkkkkkkkljdhsdhfdlkfhiskkkkkkkkkkkkkkkkkkkkkkkkk\nkljdhsdhfdlkfhiskkkkkkkkkkkkkkkkkkkkkkkkk', 'active', 'customer', '2023-04-26 09:28:30', '2023-04-26 09:28:30');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `worker_id` bigint(20) UNSIGNED DEFAULT NULL,
  `body` varchar(5000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2023_01_29_134920_create_admin_table', 1),
(3, '2023_01_29_135524_create_region_table', 1),
(4, '2023_01_29_141154_create_worker_table', 1),
(5, '2023_01_29_142025_create_customer_table', 1),
(6, '2023_01_29_144455_create_category_table', 1),
(7, '2023_01_30_110057_create_rate_table', 1),
(8, '2023_01_30_112450_create_report_table', 1),
(9, '2023_01_30_112755_create_request_table', 1),
(10, '2023_01_30_115550_create_messages_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `portfolio`
--

CREATE TABLE `portfolio` (
  `id` bigint(20) NOT NULL,
  `worker_id` bigint(255) UNSIGNED DEFAULT NULL,
  `description` varchar(500) NOT NULL,
  `some_work_images` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rate`
--

CREATE TABLE `rate` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quality_rate` int(11) NOT NULL,
  `price_rate` int(11) NOT NULL,
  `time_rate` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `worker_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `region`
--

CREATE TABLE `region` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `city_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `region`
--

INSERT INTO `region` (`id`, `city_name`, `code`, `created_at`, `updated_at`) VALUES
(16, 'القاهرة', '1', '2023-04-24 12:46:56', '2023-04-24 12:46:56'),
(17, 'الاسكندريه', '2', '2023-04-24 12:52:41', '2023-04-24 12:52:41'),
(18, 'بورسعيد', '3', '2023-04-24 12:53:09', '2023-04-24 12:53:09'),
(19, 'السويس', '4', '2023-04-24 12:53:52', '2023-04-24 12:53:52'),
(20, 'دمياط', '5', '2023-04-24 12:54:13', '2023-04-24 12:54:13'),
(21, 'الدهقلية', '6', '2023-04-24 12:55:19', '2023-04-24 12:55:19'),
(22, 'الشرقية', '7', '2023-04-24 12:55:58', '2023-04-24 12:55:58'),
(23, 'الغربية', '8', '2023-04-24 12:56:18', '2023-04-24 12:56:18'),
(24, 'القليوبية', '9', '2023-04-24 12:56:49', '2023-04-24 12:56:49'),
(25, 'كفر الشيخ', '10', '2023-04-24 12:57:06', '2023-04-24 12:57:06'),
(26, 'المنوفية', '11', '2023-04-24 12:57:37', '2023-04-24 12:57:37'),
(27, 'البحيرة', '12', '2023-04-24 12:57:51', '2023-04-24 12:57:51'),
(28, 'الاسماعلية', '13', '2023-04-24 12:58:57', '2023-04-24 12:58:57'),
(29, 'الجيزة', '14', '2023-04-24 12:59:31', '2023-04-24 12:59:31'),
(30, 'بني سويف', '15', '2023-04-24 13:00:14', '2023-04-24 13:00:14'),
(31, 'الفيوم', '16', '2023-04-24 13:00:30', '2023-04-24 13:00:30'),
(32, 'المنيا', '17', '2023-04-24 13:00:50', '2023-04-24 13:00:50'),
(33, 'اسيوط', '18', '2023-04-24 13:01:11', '2023-04-24 13:01:11'),
(34, 'سوهاج', '19', '2023-04-24 13:01:28', '2023-04-24 13:01:28'),
(35, 'قنا', '20', '2023-04-24 13:01:44', '2023-04-24 13:01:44'),
(36, 'اسوان', '21', '2023-04-24 13:02:08', '2023-04-24 13:02:08'),
(37, 'الاقصر', '22', '2023-04-24 13:02:25', '2023-04-24 13:02:25'),
(38, 'البحر الأحمر', '23', '2023-04-24 13:02:44', '2023-04-24 13:02:44'),
(39, 'الوادي الجديد', '24', '2023-04-24 13:03:12', '2023-04-24 13:03:12'),
(40, 'مطروح', '25', '2023-04-24 13:03:27', '2023-04-24 13:03:27'),
(41, 'شمال سيناء', '26', '2023-04-24 13:03:56', '2023-04-24 13:03:56'),
(42, 'جنوب سيناْ', '27', '2023-04-24 13:04:18', '2023-04-24 13:04:18');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `worker_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `worker_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `worker`
--

CREATE TABLE `worker` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'worker',
  `active_status` tinyint(1) NOT NULL DEFAULT 0,
  `dark_mode` tinyint(1) NOT NULL DEFAULT 0,
  `messenger_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#2180f3',
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accepted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `worker`
--

INSERT INTO `worker` (`id`, `name`, `email`, `password`, `phone`, `address`, `city_id`, `image`, `category_id`, `description`, `status`, `role`, `active_status`, `dark_mode`, `messenger_color`, `remember_token`, `accepted_by`, `created_at`, `updated_at`) VALUES
(32, 'Ahmed', 'Ahmed@gmail.com', '$2y$10$ckN5Nmi0mzpJso3Vu1WrmejUeZYONnVo0RpXIGzFvUh1EJ4ginI0W', '01097899008', 'jalahdldwi', 16, 'kljdhsdhfdlkfhiskkkkkkkkkkkkkkkkkkkkkkkkkkljdhsdhfdlkfhiskkkkkkkkkkkkkkkkkkkkkkkkk\nkljdhsdhfdlkfhiskkkkkkkkkkkkkkkkkkkkkkkkk', 1, 'نقاش و الزمن جري عليا يولاد التيييييييييييييييييييييييييييييييييييييت', 'active', 'worker', 0, 0, '#2180f3', NULL, NULL, '2023-04-26 09:22:00', '2023-04-26 09:22:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_email_unique` (`email`),
  ADD KEY `admin_city_id_index` (`city_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_email_unique` (`email`),
  ADD KEY `customer_city_id_index` (`city_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_customer_id_index` (`customer_id`),
  ADD KEY `messages_worker_id_index` (`worker_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `portfolio`
--
ALTER TABLE `portfolio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `worker_id` (`worker_id`);

--
-- Indexes for table `rate`
--
ALTER TABLE `rate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rate_user_id_index` (`user_id`),
  ADD KEY `rate_worker_id_index` (`worker_id`);

--
-- Indexes for table `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_customer_id_index` (`customer_id`),
  ADD KEY `report_worker_id_index` (`worker_id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_customer_id_index` (`customer_id`),
  ADD KEY `request_worker_id_index` (`worker_id`);

--
-- Indexes for table `worker`
--
ALTER TABLE `worker`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `worker_email_unique` (`email`),
  ADD KEY `worker_city_id_index` (`city_id`),
  ADD KEY `worker_category_id_index` (`category_id`),
  ADD KEY `worker_accepted_by_index` (`accepted_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `portfolio`
--
ALTER TABLE `portfolio`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rate`
--
ALTER TABLE `rate`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `region`
--
ALTER TABLE `region`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `worker`
--
ALTER TABLE `worker`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `region` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `region` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`worker_id`) REFERENCES `worker` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `portfolio`
--
ALTER TABLE `portfolio`
  ADD CONSTRAINT `portfolio_ibfk_1` FOREIGN KEY (`worker_id`) REFERENCES `worker` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rate`
--
ALTER TABLE `rate`
  ADD CONSTRAINT `rate_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rate_ibfk_2` FOREIGN KEY (`worker_id`) REFERENCES `worker` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `report_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `report_ibfk_2` FOREIGN KEY (`worker_id`) REFERENCES `worker` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `request_ibfk_2` FOREIGN KEY (`worker_id`) REFERENCES `worker` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `worker`
--
ALTER TABLE `worker`
  ADD CONSTRAINT `worker_ibfk_2` FOREIGN KEY (`accepted_by`) REFERENCES `admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `worker_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `worker_ibfk_7` FOREIGN KEY (`city_id`) REFERENCES `region` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
