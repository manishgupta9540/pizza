-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 26, 2025 at 12:30 AM
-- Server version: 10.11.13-MariaDB-0ubuntu0.24.04.1
-- PHP Version: 8.3.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pizza_ordering`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_09_25_105612_create_pizzas_table', 1),
(6, '2025_09_25_110449_create_pizza_sizes_table', 2),
(7, '2025_09_25_111021_create_toppings_table', 3),
(8, '2025_09_25_111355_create_topping_prices_table', 4),
(9, '2025_09_25_112714_create_orders_table', 5),
(10, '2025_09_25_113254_create_order_items_table', 5),
(11, '2025_09_25_113652_create_order_item_toppings_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `status` enum('pending','confirmed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `total_amount`, `customer_name`, `customer_email`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 690.00, 'testing', 'email@gamil.com', 'pending', '2025-09-25 18:15:37', '2025-09-25 18:15:37'),
(2, NULL, 350.00, 'test', 'test@email.com', 'pending', '2025-09-25 18:24:59', '2025-09-25 18:24:59'),
(3, NULL, 230.00, 'diya', 'diya@email.ocm', 'pending', '2025-09-25 18:31:47', '2025-09-25 18:31:47'),
(4, NULL, 320.00, 'raju', 'raju@email.com', 'pending', '2025-09-25 18:40:02', '2025-09-25 18:40:02'),
(5, NULL, 120.00, 'priya', 'priya@email.com', 'pending', '2025-09-25 18:42:17', '2025-09-25 18:42:17'),
(6, NULL, 570.00, 'rahul', 'rahul@email.com', 'pending', '2025-09-25 18:45:26', '2025-09-25 18:45:26');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `pizza_id` bigint(20) UNSIGNED NOT NULL,
  `size` enum('small','medium','large') NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `unit_price` decimal(8,2) NOT NULL,
  `total_price` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `pizza_id`, `size`, `quantity`, `unit_price`, `total_price`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'small', 1, 100.00, 120.00, '2025-09-25 18:15:37', '2025-09-25 18:15:37'),
(2, 1, 2, 'medium', 1, 200.00, 230.00, '2025-09-25 18:15:37', '2025-09-25 18:15:37'),
(3, 1, 2, 'large', 1, 300.00, 340.00, '2025-09-25 18:15:37', '2025-09-25 18:15:37'),
(4, 2, 2, 'small', 1, 100.00, 120.00, '2025-09-25 18:24:59', '2025-09-25 18:24:59'),
(5, 2, 3, 'medium', 1, 200.00, 230.00, '2025-09-25 18:24:59', '2025-09-25 18:24:59'),
(6, 3, 2, 'medium', 1, 200.00, 230.00, '2025-09-25 18:31:47', '2025-09-25 18:31:47'),
(7, 4, 1, 'medium', 1, 200.00, 320.00, '2025-09-25 18:40:02', '2025-09-25 18:40:02'),
(8, 5, 3, 'small', 1, 100.00, 120.00, '2025-09-25 18:42:17', '2025-09-25 18:42:17'),
(9, 6, 2, 'medium', 1, 200.00, 230.00, '2025-09-25 18:45:26', '2025-09-25 18:45:26'),
(10, 6, 3, 'large', 1, 300.00, 340.00, '2025-09-25 18:45:26', '2025-09-25 18:45:26');

-- --------------------------------------------------------

--
-- Table structure for table `order_item_toppings`
--

CREATE TABLE `order_item_toppings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_item_id` bigint(20) UNSIGNED NOT NULL,
  `topping_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_item_toppings`
--

INSERT INTO `order_item_toppings` (`id`, `order_item_id`, `topping_id`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 20.00, '2025-09-25 18:15:37', '2025-09-25 18:15:37'),
(2, 1, 2, 20.00, '2025-09-25 18:15:37', '2025-09-25 18:15:37'),
(3, 2, 2, 30.00, '2025-09-25 18:15:37', '2025-09-25 18:15:37'),
(4, 2, 2, 30.00, '2025-09-25 18:15:37', '2025-09-25 18:15:37'),
(5, 3, 3, 40.00, '2025-09-25 18:15:37', '2025-09-25 18:15:37'),
(6, 3, 3, 40.00, '2025-09-25 18:15:37', '2025-09-25 18:15:37'),
(7, 4, 3, 20.00, '2025-09-25 18:24:59', '2025-09-25 18:24:59'),
(8, 4, 3, 20.00, '2025-09-25 18:24:59', '2025-09-25 18:24:59'),
(9, 5, 3, 30.00, '2025-09-25 18:24:59', '2025-09-25 18:24:59'),
(10, 5, 3, 30.00, '2025-09-25 18:24:59', '2025-09-25 18:24:59'),
(11, 6, 2, 30.00, '2025-09-25 18:31:47', '2025-09-25 18:31:47'),
(12, 6, 3, 30.00, '2025-09-25 18:31:47', '2025-09-25 18:31:47'),
(13, 6, 2, 30.00, '2025-09-25 18:31:47', '2025-09-25 18:31:47'),
(14, 6, 3, 30.00, '2025-09-25 18:31:47', '2025-09-25 18:31:47'),
(15, 7, 1, 30.00, '2025-09-25 18:40:02', '2025-09-25 18:40:02'),
(16, 7, 2, 30.00, '2025-09-25 18:40:02', '2025-09-25 18:40:02'),
(17, 7, 1, 30.00, '2025-09-25 18:40:02', '2025-09-25 18:40:02'),
(18, 7, 2, 30.00, '2025-09-25 18:40:02', '2025-09-25 18:40:02'),
(19, 8, 2, 20.00, '2025-09-25 18:42:17', '2025-09-25 18:42:17'),
(20, 8, 3, 20.00, '2025-09-25 18:42:17', '2025-09-25 18:42:17'),
(21, 8, 2, 20.00, '2025-09-25 18:42:17', '2025-09-25 18:42:17'),
(22, 8, 3, 20.00, '2025-09-25 18:42:17', '2025-09-25 18:42:17'),
(23, 9, 3, 30.00, '2025-09-25 18:45:26', '2025-09-25 18:45:26'),
(24, 9, 3, 30.00, '2025-09-25 18:45:26', '2025-09-25 18:45:26'),
(25, 10, 3, 40.00, '2025-09-25 18:45:26', '2025-09-25 18:45:26'),
(26, 10, 3, 40.00, '2025-09-25 18:45:26', '2025-09-25 18:45:26');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pizzas`
--

CREATE TABLE `pizzas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pizzas`
--

INSERT INTO `pizzas` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Farmhouse', NULL, NULL),
(2, 'Margarita', NULL, NULL),
(3, 'Peppy Paneer', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pizza_sizes`
--

CREATE TABLE `pizza_sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pizza_id` bigint(20) UNSIGNED NOT NULL,
  `size` enum('small','medium','large') NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pizza_sizes`
--

INSERT INTO `pizza_sizes` (`id`, `pizza_id`, `size`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 'small', 100.00, NULL, NULL),
(2, 1, 'medium', 200.00, NULL, NULL),
(3, 1, 'large', 300.00, NULL, NULL),
(4, 2, 'small', 100.00, NULL, NULL),
(5, 2, 'medium', 200.00, NULL, NULL),
(6, 2, 'large', 300.00, NULL, NULL),
(7, 3, 'small', 100.00, NULL, NULL),
(8, 3, 'medium', 200.00, NULL, NULL),
(9, 3, 'large', 300.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `toppings`
--

CREATE TABLE `toppings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `toppings`
--

INSERT INTO `toppings` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Extra Cheese', NULL, NULL),
(2, 'Jalapenos', NULL, NULL),
(3, 'Sweet Corns', NULL, NULL),
(4, 'Extra Veggies', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `topping_prices`
--

CREATE TABLE `topping_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `topping_id` bigint(20) UNSIGNED NOT NULL,
  `pizza_size` enum('small','medium','large') NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `topping_prices`
--

INSERT INTO `topping_prices` (`id`, `topping_id`, `pizza_size`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 'small', 20.00, NULL, NULL),
(2, 1, 'medium', 30.00, NULL, NULL),
(3, 1, 'large', 40.00, NULL, NULL),
(4, 4, 'small', 20.00, NULL, NULL),
(5, 4, 'medium', 30.00, NULL, NULL),
(6, 4, 'large', 40.00, NULL, NULL),
(7, 2, 'small', 20.00, NULL, NULL),
(8, 2, 'medium', 30.00, NULL, NULL),
(9, 2, 'large', 40.00, NULL, NULL),
(10, 3, 'small', 20.00, NULL, NULL),
(11, 3, 'medium', 30.00, NULL, NULL),
(12, 3, 'large', 40.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_pizza_id_foreign` (`pizza_id`);

--
-- Indexes for table `order_item_toppings`
--
ALTER TABLE `order_item_toppings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_item_toppings_order_item_id_foreign` (`order_item_id`),
  ADD KEY `order_item_toppings_topping_id_foreign` (`topping_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pizzas`
--
ALTER TABLE `pizzas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pizza_sizes`
--
ALTER TABLE `pizza_sizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pizza_sizes_pizza_id_foreign` (`pizza_id`);

--
-- Indexes for table `toppings`
--
ALTER TABLE `toppings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topping_prices`
--
ALTER TABLE `topping_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topping_prices_topping_id_foreign` (`topping_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order_item_toppings`
--
ALTER TABLE `order_item_toppings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pizzas`
--
ALTER TABLE `pizzas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pizza_sizes`
--
ALTER TABLE `pizza_sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `toppings`
--
ALTER TABLE `toppings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `topping_prices`
--
ALTER TABLE `topping_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_pizza_id_foreign` FOREIGN KEY (`pizza_id`) REFERENCES `pizzas` (`id`);

--
-- Constraints for table `order_item_toppings`
--
ALTER TABLE `order_item_toppings`
  ADD CONSTRAINT `order_item_toppings_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`),
  ADD CONSTRAINT `order_item_toppings_topping_id_foreign` FOREIGN KEY (`topping_id`) REFERENCES `toppings` (`id`);

--
-- Constraints for table `pizza_sizes`
--
ALTER TABLE `pizza_sizes`
  ADD CONSTRAINT `pizza_sizes_pizza_id_foreign` FOREIGN KEY (`pizza_id`) REFERENCES `pizzas` (`id`);

--
-- Constraints for table `topping_prices`
--
ALTER TABLE `topping_prices`
  ADD CONSTRAINT `topping_prices_topping_id_foreign` FOREIGN KEY (`topping_id`) REFERENCES `toppings` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
