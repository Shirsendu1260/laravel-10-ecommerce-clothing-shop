-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 17, 2025 at 09:52 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce-clothing-shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `addon_cart`
--

CREATE TABLE `addon_cart` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `addon_product_id` bigint(20) UNSIGNED NOT NULL,
  `qty` smallint(6) NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addon_cart`
--

INSERT INTO `addon_cart` (`id`, `addon_product_id`, `qty`, `cart_id`, `created_at`, `updated_at`) VALUES
(1, 11, 2, 1, '2025-07-22 10:45:59', '2025-07-22 10:45:59'),
(2, 6, 1, 3, '2025-07-22 11:44:45', '2025-07-22 11:44:45'),
(3, 6, 2, 12, '2025-08-17 07:32:20', '2025-08-17 07:32:20');

-- --------------------------------------------------------

--
-- Table structure for table `addon_products`
--

CREATE TABLE `addon_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `is_in_stock` enum('1','0') NOT NULL COMMENT '''1'' => ''In Stock'', ''0'' => ''Out of Stock''',
  `status` enum('1','0') NOT NULL DEFAULT '1' COMMENT '''1'' => ''Active'', ''0'' => ''Inactive''',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addon_products`
--

INSERT INTO `addon_products` (`id`, `name`, `image`, `slug`, `sku`, `price`, `qty`, `brand_id`, `category_id`, `is_in_stock`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Addon Product 1', NULL, 'addon-product-1', 'ADDON-SKU-8135', 120.00, 150, 13, 14, '1', '1', '2025-06-09 07:36:49', '2025-06-09 07:36:49'),
(2, 'Addon Product 2', NULL, 'addon-product-2', 'ADDON-SKU-8005', 100.00, 110, 14, 14, '1', '1', '2025-06-09 07:39:08', '2025-06-09 07:39:08'),
(3, 'Addon Product 3', NULL, 'addon-product-3', 'ADDON-SKU-1111', 60.00, 50, 15, 14, '1', '1', '2025-06-09 07:42:16', '2025-06-09 07:42:16'),
(4, 'Addon Product 4', NULL, 'addon-product-4', 'ADDON-SKU-1155', 40.00, 50, 11, 14, '1', '1', '2025-06-09 07:43:11', '2025-06-09 07:43:11'),
(5, 'Addon Product 5', NULL, 'addon-product-5', 'ADDON-SKU-2493', 46.00, 26, 12, 14, '1', '1', '2025-06-09 07:44:11', '2025-06-09 07:44:11'),
(6, 'Nike Backpack', '20250610044602_569.jpg', 'nike-backpack', 'ADDON-SKU-0007', 349.00, 90, 2, 14, '1', '1', '2025-06-09 23:16:02', '2025-06-09 23:16:04'),
(7, 'Addon Product 6', NULL, 'addon-product-6', 'ADDON-SKU-0207', 243.00, 80, 10, 14, '1', '1', '2025-06-09 23:16:45', '2025-06-09 23:16:45'),
(8, 'Addon Product 7', NULL, 'addon-product-7', 'ADDON-SKU-0767', 359.00, 68, 1, 14, '1', '1', '2025-06-09 23:17:17', '2025-06-09 23:17:17'),
(9, 'Addon Product 8', NULL, 'addon-product-8', 'ADDON-SKU-1167', 319.00, 68, 11, 6, '1', '1', '2025-06-09 23:17:45', '2025-06-09 23:17:45'),
(10, 'Addon Product 9', NULL, 'addon-product-9', 'ADDON-SKU-1557', 79.00, 58, 15, 6, '1', '1', '2025-06-09 23:18:10', '2025-06-09 23:18:10'),
(11, 'Addon Product 10', NULL, 'addon-product-10', 'ADDON-SKU-1554', 50.00, 56, 13, 18, '1', '1', '2025-06-09 23:18:35', '2025-06-09 23:18:35'),
(12, 'Addon Product 11', NULL, 'addon-product-11', 'ADDON-SKU-1550', 120.00, 57, 1, 18, '1', '1', '2025-06-09 23:18:52', '2025-06-10 00:01:07'),
(13, 'Addon Product 12', NULL, 'addon-product-12', 'ADDON-SKU-1511', 49.00, 55, 11, 1, '1', '1', '2025-06-09 23:19:14', '2025-06-09 23:19:14'),
(14, 'Addon Product 13', NULL, 'addon-product-13', 'ADDON-SKU-6005', 125.00, 44, 5, 1, '1', '1', '2025-06-09 23:19:44', '2025-06-09 23:19:44'),
(15, 'Addon Product 14', NULL, 'addon-product-14', 'ADDON-SKU-6075', 75.00, 44, 5, 2, '1', '1', '2025-06-09 23:20:08', '2025-06-09 23:20:08'),
(16, 'Addon Product 15', NULL, 'addon-product-15', 'ADDON-SKU-0075', 55.00, 44, 12, 2, '1', '1', '2025-06-09 23:20:23', '2025-06-09 23:20:23'),
(17, 'Addon Product 16', NULL, 'addon-product-16', 'ADDON-SKU-0675', 105.00, 41, 14, 16, '1', '1', '2025-06-09 23:20:46', '2025-06-09 23:20:46'),
(18, 'Addon Product 17', NULL, 'addon-product-17', 'ADDON-SKU-0875', 100.00, 0, 11, 16, '1', '1', '2025-06-09 23:21:20', '2025-06-09 23:21:20'),
(19, 'Addon Product 18', NULL, 'addon-product-18', 'ADDON-SKU-0118', 150.00, 76, 1, 10, '1', '1', '2025-06-09 23:21:57', '2025-06-09 23:21:57'),
(20, 'Addon Product 19', NULL, 'addon-product-19', 'ADDON-SKU-0110', 120.00, 72, 13, 10, '1', '1', '2025-06-09 23:22:17', '2025-06-09 23:22:17'),
(21, 'Addon Product 20', NULL, 'addon-product-20', 'ADDON-SKU-0133', 125.00, 72, 10, 8, '1', '1', '2025-06-09 23:24:27', '2025-06-09 23:24:27'),
(22, 'Addon Product 21', NULL, 'addon-product-21', 'ADDON-SKU-0641', 35.00, 70, 14, 8, '1', '1', '2025-06-09 23:26:00', '2025-06-09 23:26:00'),
(23, 'Addon Product 22', NULL, 'addon-product-22', 'ADDON-SKU-0436', 155.00, 70, 1, 15, '1', '1', '2025-06-09 23:26:49', '2025-06-09 23:26:49'),
(24, 'Addon Product 23', NULL, 'addon-product-23', 'ADDON-SKU-0455', 155.00, 70, 14, 9, '1', '1', '2025-06-09 23:27:06', '2025-06-10 00:02:10'),
(25, 'Addon Product 24', NULL, 'addon-product-24', 'ADDON-SKU-3456', 100.00, 100, 5, 13, '1', '1', '2025-06-09 23:27:30', '2025-06-09 23:27:30');

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phonecode` varchar(7) DEFAULT '+91',
  `mobile` varchar(10) NOT NULL,
  `locality` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `landmark` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `zip` varchar(6) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'home',
  `is_default` enum('1','0') NOT NULL DEFAULT '0' COMMENT '''1'' => ''Default address'', ''0'' => ''Not a default address''',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `name`, `phonecode`, `mobile`, `locality`, `address`, `landmark`, `city`, `state`, `country`, `zip`, `type`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 2, 'K. Mali', '+91', '5555566666', 'ABC Road', '10', 'Near Metro Stn.', 'Kolkata', 'West Bengal', 'India', '700012', 'home', '0', '2025-07-22 10:47:42', '2025-07-22 10:47:42'),
(2, 2, 'M. Das', '+91', '4455223300', 'PQR Road', '19', 'Near Rly. Stn.', 'N24 Parganas', 'West Bengal', 'India', '700070', 'home', '0', '2025-07-22 10:47:42', '2025-07-22 10:47:42'),
(3, 3, 'P. Mali', '+91', '1155446633', 'P Road', '24R', 'Near XYZ Rly. Stn.', 'Kolkata', 'West Bengal', 'India', '700015', 'home', '0', '2025-08-08 11:17:22', '2025-08-08 11:17:22'),
(4, 2, 'S. Sarma', '+91', '9988998811', 'ABC', 'MS35', 'Near XYZ Playground', 'Madhyamgram', 'West Bengal', 'India', '700070', 'home', '0', '2025-08-15 13:33:56', '2025-08-15 13:33:56'),
(5, 2, 'D. Mali', '+91', '3344556677', 'PQR', 'R3', 'Near ABC Metro Station', 'Kolkata', 'West Bengal', 'India', '700008', 'home', '0', '2025-08-15 13:36:41', '2025-08-15 13:36:41'),
(6, 2, 'M. Mali', '+91', '6677889999', 'PQR', 'R3', 'Near ABC Metro Station', 'Kolkata', 'West Bengal', 'India', '700008', 'home', '1', '2025-08-15 15:22:59', '2025-08-15 15:22:59');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1' COMMENT '''1'' => ''Active'', ''0'' => ''Inactive''',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Adidas', 'adidas', '20250426083724_716.jpg', '1', '2025-04-26 02:54:36', '2025-04-26 03:07:24'),
(2, 'Nike', 'nike', '20250426083733_665.png', '1', '2025-04-26 02:55:07', '2025-04-26 03:07:33'),
(5, 'Puma', 'puma', '20250428101729_573.jpg', '1', '2025-04-28 04:47:00', '2025-04-28 04:47:44'),
(10, 'H&M', 'hm', '20250510083518_31.jpg', '1', '2025-05-10 03:01:15', '2025-05-10 03:05:18'),
(11, 'Demo Brand 01', 'demo-brand-01', NULL, '1', '2025-05-12 00:38:43', '2025-05-12 00:38:43'),
(12, 'Demo Brand 02', 'demo-brand-02', NULL, '1', '2025-05-12 00:38:53', '2025-05-12 00:39:07'),
(13, 'Demo Brand 03', 'demo-brand-03', NULL, '1', '2025-05-12 00:39:03', '2025-05-12 00:39:03'),
(14, 'Demo Brand 04', 'demo-brand-04', NULL, '1', '2025-05-12 00:39:17', '2025-05-12 00:39:17'),
(15, 'Demo Brand 05', 'demo-brand-05', NULL, '1', '2025-05-12 00:39:26', '2025-05-12 00:39:26'),
(16, 'Demo Brand 06', 'demo-brand-06', NULL, '1', '2025-05-12 00:39:36', '2025-05-12 00:39:36'),
(17, 'New Brand 01', 'new-brand-01', NULL, '1', '2025-06-24 11:17:50', '2025-06-24 11:17:50');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_session_id` varchar(255) NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `size` varchar(10) NOT NULL COMMENT 'XS => Extra Small, S => Small, M => Medium, L => Large, XL => Extra Large, XXL => Extra Extra Large',
  `qty` smallint(6) UNSIGNED NOT NULL,
  `coupon_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'null => Coupon is not applied',
  `order_date` date NOT NULL,
  `delivery_method_id` bigint(20) UNSIGNED NOT NULL,
  `delivery_timeslot_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `cart_session_id`, `product_id`, `size`, `qty`, `coupon_id`, `order_date`, `delivery_method_id`, `delivery_timeslot_id`, `created_at`, `updated_at`) VALUES
(1, '2ecd0f9cbd738eaa92a381390751d326', 15, 'xl', 1, 2, '2025-08-05', 2, 11, '2025-07-22 10:45:59', '2025-07-22 10:45:59'),
(2, '2ecd0f9cbd738eaa92a381390751d326', 10, 'l', 1, 2, '2025-08-08', 2, 11, '2025-07-22 10:46:15', '2025-07-22 10:46:15'),
(3, 'd5a0f9942aaa4576124a5fc9fea9e729', 18, 'xl', 1, 2, '2025-08-12', 2, 11, '2025-07-22 11:44:45', '2025-07-22 11:44:45'),
(5, '709f1947cf0391067357b7be74776649', 10, 'l', 1, 2, '2025-08-08', 3, 10, '2025-08-08 11:15:33', '2025-08-08 11:15:33'),
(7, '0f9c0ede67b24199d535a12023e9ac8b', 7, 'xl', 1, NULL, '2025-08-13', 1, 2, '2025-08-12 06:39:12', '2025-08-12 06:39:12'),
(8, '26c365f775381d67a8060e5e5f9138a3', 19, 'xl', 1, NULL, '2025-08-13', 1, 1, '2025-08-12 06:44:15', '2025-08-12 06:44:15'),
(9, 'd4df95bf24fb031c69c479975aaed52b', 7, 'xl', 1, NULL, '2025-08-13', 1, 1, '2025-08-12 07:56:44', '2025-08-12 07:56:44'),
(10, '4c300b94e38949064a682fbd797a43ed', 7, 'xl', 1, NULL, '2025-08-13', 1, 1, '2025-08-12 10:58:27', '2025-08-12 10:58:27'),
(12, '872eeea9339cc09887da5103968e1060', 6, 'xl', 1, NULL, '2025-08-20', 2, 11, '2025-08-17 07:32:20', '2025-08-17 07:32:20');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1' COMMENT '''1'' => ''Active'', ''0'' => ''Inactive''',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Trousers for Men', 'trousers-for-men', '20250430081340_409.png', '1', '2025-04-30 02:43:40', '2025-05-14 23:58:52'),
(2, 'Trousers for Women', 'trousers-for-women', '20250430082300_79.png', '1', '2025-04-30 02:53:00', '2025-05-14 23:58:26'),
(6, 'Sweatshirts for Women', 'sweatshirts-for-women', '20250430104609_595.png', '1', '2025-04-30 05:16:09', '2025-05-14 23:58:08'),
(7, 'Shirts for Women', 'shirts-for-women', '20250430105015_40.png', '1', '2025-04-30 05:18:49', '2025-05-14 23:57:44'),
(8, 'Shoes for Men', 'shoes-for-men', '20250430105100_995.png', '1', '2025-04-30 05:21:00', '2025-05-14 23:57:29'),
(9, 'Jackets for Women', 'jackets-for-women', '20250505081546_383.png', '1', '2025-04-30 05:21:49', '2025-05-14 23:57:18'),
(10, 'Sweaters for Men', 'sweaters-for-men', '20250430105916_507.png', '1', '2025-04-30 05:29:16', '2025-05-14 23:57:03'),
(13, 'Jackets for Men', 'jackets-for-men', '20250505131258_33.png', '1', '2025-05-05 07:42:58', '2025-05-14 23:56:56'),
(14, 'Sweatshirts for Men', 'sweatshirts-for-men', '20250510083956_106.png', '1', '2025-05-10 03:09:56', '2025-05-14 23:56:49'),
(15, 'Shirts for Men', 'shirts-for-men', '20250512081944_493.png', '1', '2025-05-12 02:49:44', '2025-05-14 23:56:39'),
(16, 'Womens\' Wear', 'womens-wear', '20250512091516_930.png', '1', '2025-05-12 03:45:16', '2025-05-12 03:45:16'),
(18, 'T-shirts for Men', 'tshirts-for-men', '20250515052610_127.png', '1', '2025-05-14 23:56:10', '2025-05-14 23:56:13');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  `is_replied` enum('1','0') NOT NULL DEFAULT '0' COMMENT '''1'' => ''Replied'', ''0'' => ''Not replied''',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `name`, `email`, `subject`, `message`, `is_replied`, `created_at`, `updated_at`) VALUES
(1, 'N. Das', 'nd@gmail.com', 'Test', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1', '2025-08-05 08:45:36', '2025-08-05 08:45:36'),
(2, 'MD', 'md1@gmail.com', 'Demo', 'Random message', '0', '2025-08-06 05:20:41', '2025-08-06 05:20:41');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `iso` varchar(2) NOT NULL,
  `name` varchar(100) NOT NULL,
  `iso3` varchar(3) DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL,
  `phonecode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `iso`, `name`, `iso3`, `numcode`, `phonecode`) VALUES
(1, 'IN', 'India', 'IND', 356, 91);

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `max_uses` int(10) DEFAULT NULL,
  `max_uses_per_user` int(10) DEFAULT NULL,
  `type` enum('fixed','percent') NOT NULL DEFAULT 'fixed',
  `discount` decimal(10,2) UNSIGNED NOT NULL,
  `min_cart_amount` decimal(10,2) UNSIGNED NOT NULL,
  `starts_at` date NOT NULL,
  `expires_at` date NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1' COMMENT '''1'' => ''Active'', ''0'' => ''Inactive''',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `description`, `max_uses`, `max_uses_per_user`, `type`, `discount`, `min_cart_amount`, `starts_at`, `expires_at`, `status`, `created_at`, `updated_at`) VALUES
(1, 'FLAT100', 'Flat 100 Rs. Discount', 10, 1, 'fixed', 100.00, 1100.00, '2025-06-10', '2025-09-10', '1', '2025-06-09 02:09:28', '2025-06-23 01:12:55'),
(2, 'IND10', '10% Off to Independence Day', 1000, 2, 'percent', 10.00, 400.00, '2025-06-10', '2025-08-15', '1', '2025-06-09 04:08:23', '2025-06-23 01:18:11');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_methods`
--

CREATE TABLE `delivery_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` decimal(6,2) NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1' COMMENT '''1'' => ''Active'', ''0'' => ''Inactive''',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_methods`
--

INSERT INTO `delivery_methods` (`id`, `name`, `slug`, `description`, `price`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Express Delivery', 'express-delivery', 'Choose from any 4-hour slot during the day', 25.00, '1', '2025-06-03 06:28:33', '2025-06-03 06:28:33'),
(2, 'Standard Delivery', 'standard-delivery', 'Full Day Slot', 2.00, '1', '2025-06-03 02:20:20', '2025-06-03 02:20:20'),
(3, 'Fixed Time Delivery', 'fixed-time-delivery', 'Choose from any 1-hour slot', 75.00, '1', '2025-06-03 02:33:31', '2025-06-03 02:43:53'),
(4, 'Pre-Midnight Delivery', 'premidnight-delivery', 'Products will be delivered any time between 11:00 PM - 11:59 PM', 200.00, '1', '2025-06-03 02:35:38', '2025-06-23 01:13:38');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_timeslots`
--

CREATE TABLE `delivery_timeslots` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `time_range` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `start` varchar(10) NOT NULL COMMENT '''HH:MM''',
  `end` varchar(10) NOT NULL COMMENT '''HH:MM''',
  `delivery_method_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1' COMMENT '''1'' => ''Active'', ''0'' => ''Inactive''',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_timeslots`
--

INSERT INTO `delivery_timeslots` (`id`, `time_range`, `slug`, `start`, `end`, `delivery_method_id`, `status`, `created_at`, `updated_at`) VALUES
(1, '09:00 - 13:00 Hrs', '0900-1300-hrs', '09:00', '13:00', 1, '1', '2025-06-03 07:45:07', '2025-06-03 07:45:07'),
(2, '13:00 - 17:00 Hrs', '1300-1700-hrs', '13:00', '17:00', 1, '1', '2025-06-03 07:48:25', '2025-06-03 07:48:25'),
(3, '17:00 - 21:00 Hrs', '1700-2100-hrs', '17:00', '21:00', 1, '1', '2025-06-03 07:49:00', '2025-06-03 07:49:00'),
(4, '19:00 - 23:00 Hrs', '1900-2300-hrs', '19:00', '23:00', 1, '1', '2025-06-03 07:49:28', '2025-06-03 07:49:28'),
(5, '10:00 - 11:00 Hrs', '1000-1100-hrs', '10:00', '11:00', 3, '1', '2025-06-03 07:50:34', '2025-06-03 07:50:34'),
(6, '12:00 - 13:00 Hrs', '1200-1300-hrs', '12:00', '13:00', 3, '1', '2025-06-03 07:50:59', '2025-06-03 07:50:59'),
(7, '14:00 - 15:00 Hrs', '1400-1500-hrs', '14:00', '15:00', 3, '1', '2025-06-03 07:51:24', '2025-06-03 07:51:24'),
(8, '16:00 - 17:00 Hrs', '1600-1700-hrs', '16:00', '17:00', 3, '1', '2025-06-03 07:52:10', '2025-06-03 07:52:10'),
(9, '18:00 - 19:00 Hrs', '1800-1900-hrs', '18:00', '19:00', 3, '1', '2025-06-03 23:06:22', '2025-06-03 23:06:22'),
(10, '20:00 - 21:00 Hrs', '2000-2100-hrs', '20:00', '21:00', 3, '1', '2025-06-03 23:07:08', '2025-06-03 23:07:08'),
(11, '06:00 - 22:00 Hrs', '0600-2200-hrs', '06:00', '22:00', 2, '1', '2025-06-03 23:07:57', '2025-06-03 23:07:57'),
(12, '23:00 - 23:59 Hrs', '2300-2359-hrs', '23:00', '23:59', 4, '1', '2025-06-03 23:08:24', '2025-06-04 23:47:50');

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
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2014_10_12_100000_create_password_resets_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `months`
--

CREATE TABLE `months` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `months`
--

INSERT INTO `months` (`id`, `name`) VALUES
(1, 'January'),
(2, 'February'),
(3, 'March'),
(4, 'April'),
(5, 'May'),
(6, 'June'),
(7, 'July'),
(8, 'August'),
(9, 'September'),
(10, 'October'),
(11, 'November'),
(12, 'December');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unique_oid` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `shipping` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `coupon_id` bigint(20) UNSIGNED DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phonecode` varchar(7) DEFAULT '+91',
  `mobile` varchar(10) NOT NULL,
  `locality` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `zip` varchar(6) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'home',
  `status` enum('ORD','DEL','CANC') NOT NULL DEFAULT 'ORD' COMMENT '''ORD'' => ''Ordered'', ''DEL'' => ''Delivered'', ''CANC'' => ''Cancelled''',
  `cancelled_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `unique_oid`, `user_id`, `subtotal`, `shipping`, `discount`, `coupon_id`, `total`, `name`, `phonecode`, `mobile`, `locality`, `address`, `landmark`, `city`, `state`, `country`, `zip`, `type`, `status`, `cancelled_date`, `created_at`, `updated_at`) VALUES
(1, 'LE-52063-847', 2, 1398.00, 4.00, 140.00, 2, 1262.00, 'K. Mali', '+91', '5555566666', 'ABC Road', '10', 'Near Metro Stn.', 'Kolkata', 'West Bengal', 'India', '700012', 'home', 'DEL', NULL, '2025-07-22 05:17:42', '2025-07-22 05:17:42'),
(2, 'LE-93776-323', 2, 2648.00, 2.00, 265.00, 2, 2385.00, 'M. Das', '+91', '4455223300', 'PQR Road', '19', 'Near Rly. Stn.', 'Kolkata', 'West Bengal', 'India', '700070', 'home', 'CANC', '2025-07-30 07:14:52', '2025-07-22 06:29:22', '2025-07-22 06:29:22'),
(3, 'LE-81163-3-33', 3, 799.00, 75.00, 80.00, 2, 794.00, 'P. Mali', '+91', '1155446633', 'P Road', '24R', 'Near XYZ Rly. Stn.', 'Kolkata', 'West Bengal', 'India', '700015', 'home', 'DEL', NULL, '2025-08-08 05:47:22', '2025-08-08 05:47:22'),
(4, 'LE-72593-4-17', 2, 1997.00, 2.00, 0.00, NULL, 1999.00, 'M. Mali', '+91', '6677889999', 'PQR', 'R3', 'Near ABC Metro Station', 'Kolkata', 'West Bengal', 'India', '700008', 'home', 'ORD', NULL, '2025-08-17 07:34:01', '2025-08-17 07:34:01');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `delivered_date` timestamp NULL DEFAULT NULL,
  `refund_status` enum('1','0') NOT NULL DEFAULT '0' COMMENT '''1'' => ''Refunded'', ''0'' => ''Not refunded''',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `product_id`, `order_id`, `cart_id`, `delivered_date`, `refund_status`, `created_at`, `updated_at`) VALUES
(1, 15, 1, 1, '2025-08-04 07:17:00', '0', '2025-07-22 05:17:42', '2025-07-22 05:17:42'),
(2, 10, 1, 2, '2025-08-07 01:18:00', '0', '2025-07-22 05:17:42', '2025-07-22 05:17:42'),
(3, 18, 2, 3, NULL, '0', '2025-07-22 06:29:22', '2025-07-22 06:29:22'),
(4, 10, 3, 5, '2025-08-08 09:47:00', '0', '2025-08-08 05:47:22', '2025-08-08 05:47:22'),
(5, 6, 4, 12, NULL, '0', '2025-08-17 07:34:01', '2025-08-17 07:34:01');

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
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `gallery_images_count` tinyint(2) UNSIGNED NOT NULL DEFAULT 0,
  `slug` varchar(255) NOT NULL,
  `short_description` mediumtext DEFAULT NULL,
  `description` longtext NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `actual_price` decimal(10,2) DEFAULT NULL,
  `sku` varchar(255) NOT NULL,
  `available_sizes` varchar(20) NOT NULL COMMENT 'XS => Extra Small, S => Small, M => Medium, L => Large, XL => Extra Large, XXL => Extra Extra Large',
  `qty` int(11) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `is_featured` enum('1','0') NOT NULL DEFAULT '0' COMMENT '''1'' => ''Featured'', ''0'' => ''Not featured''',
  `is_in_stock` enum('1','0') NOT NULL COMMENT '''1'' => ''In Stock'', ''0'' => ''Out of Stock''',
  `status` enum('1','0') NOT NULL DEFAULT '1' COMMENT '''1'' => ''Active'', ''0'' => ''Inactive''',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `image`, `gallery_images_count`, `slug`, `short_description`, `description`, `price`, `actual_price`, `sku`, `available_sizes`, `qty`, `brand_id`, `category_id`, `is_featured`, `is_in_stock`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Lightweight Puffer Jacket With a Hood', '20250512104827_987.jpg', 4, 'lightweight-puffer-jacket-with-a-hood', '<p>Lorem ipsum dolor sit amet. Est neque assumenda aut doloribus aliquam eos eveniet tenetur et debitis quia ea velit velit est dolorem facere et velit illum. Hic omnis deleniti eos maiores nobis aut illum voluptas. Sit perferendis esse ut temporibus magni 33 Quis recusandae et temporibus ipsa.</p>', '<p>Lorem ipsum dolor sit amet. Eum molestiae quibusdam qui quaerat temporibus sit quidem molestiae? Aut fugit magnam qui corporis reprehenderit qui galisum illum ut harum fugit qui deleniti asperiores nam necessitatibus numquam sed impedit optio. </p><p>Sit alias perspiciatis sit voluptates voluptatem quo enim velit. Aut culpa dignissimos eum asperiores ipsa aut ducimus dolorem.</p><p><br></p><p> </p><dl><dt><dfn>Non sequi debitis 33 fugiat corporis. </dfn></dt><dd>Sed praesentium debitis cum incidunt saepe in eligendi velit id obcaecati necessitatibus. </dd><dt><dfn>Quo dolor ipsum quo repudiandae soluta. </dfn></dt><dd>Qui numquam laudantium ea quas recusandae eum omnis exercitationem qui commodi perferendis. </dd></dl><p>Aut rerum dolorum aut saepe expedita et sunt asperiores in animi molestiae eos veniam architecto nam voluptate repudiandae. Quo omnis tempora cum culpa accusamus et provident modi. Est laboriosam culpa est galisum quibusdam in voluptas repellat sed culpa internos sit quia dolores ut repellat vero vel laudantium accusamus. Qui aperiam nemo ex laudantium reiciendis id esse illum est delectus necessitatibus eum labore rerum eum illo modi quo debitis illo.</p>', 2799.00, 3500.00, 'SKU-4045', 'xs,s,m,l,xl,xxl', 12, 1, 13, '1', '1', '1', '2025-05-06 04:27:45', '2025-05-30 01:18:05'),
(6, 'H&M Hooded Cotton Sweatshirt', '20250512104336_741.jpg', 1, 'hm-hooded-cotton-sweatshirt', '<p>Lorem ipsum dolor sit amet. Ad laboriosam autem id repudiandae voluptasIn possimus et commodi quia quo aspernatur aliquid et consequatur labore. Cum facilis culpa Non saepe sit iusto deserunt vel odit cupiditate ut veritatis praesentium.</p>', '<p>Lorem ipsum dolor sit amet. Et iste quibusdam aut debitis doloreet tempore. Est minima nihil <em>Et facilis non doloremque necessitatibus quo incidunt labore eos optio accusamus</em> non sint nesciunt est omnis obcaecati. Ex culpa molestiae <strong>Et incidunt eum consectetur repellat non veritatis porro</strong> qui iure asperiores et odio voluptas et explicabo aliquam.</p><p><br></p><p> </p><dl><dt><dfn>Et laboriosam sapiente eos sequi voluptatem. </dfn></dt><dd>Ut soluta quasi vel eveniet quaerat. </dd><dt><dfn>Et velit quae et minima perspiciatis? </dfn></dt><dd>Aut voluptas inventore sed voluptatem voluptates ad omnis dolorem non autem internos? </dd><dt><dfn>Id laborum atque et perspiciatis vitae? </dfn></dt><dd>Sed architecto voluptas ut consequatur dicta. </dd><dt><dfn>Vel blanditiis reiciendis! </dfn></dt><dd>Ea beatae veritatis aut quia repellendus? </dd></dl><p>Ut fugit voluptatum <strong>Ut fugiat est ipsam nemo</strong>. Ut voluptas culpaEos dolor At rerum numquam. </p><p>Et dolor quasi aut architecto saepe <strong>Et laboriosam</strong>! Est harum necessitatibus vel dignissimos consequuntur <em>Sed quia ea vero nobis ut quia maxime ut aperiam velit</em>. </p>', 1299.00, 2599.00, 'SKU-1526', 'xs,s,m,l,xl,xxl', 10, 10, 14, '0', '1', '1', '2025-05-10 03:15:22', '2025-05-30 01:19:32'),
(7, 'Demo Product 01', '20250512104317_329.jpg', 2, 'demo-product-01', '<p><span style=\"color: rgb(33, 37, 41); font-family: system-ui, -apple-system, \"Segoe UI\", Roboto, \"Helvetica Neue\", Arial, \"Noto Sans\", \"Liberation Sans\", sans-serif, \"Apple Color Emoji\", \"Segoe UI Emoji\", \"Segoe UI Symbol\", \"Noto Color Emoji\"; font-size: 16px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;\">Lorem ipsum dolor sit amet. Sed molestiae maiores ut perspiciatis evenietid autem ea tempora consequuntur non consequatur nihil. Est nihil sunt et eligendi quia </span><em style=\"color: rgb(33, 37, 41); font-family: system-ui, -apple-system, \"Segoe UI\", Roboto, \"Helvetica Neue\", Arial, \"Noto Sans\", \"Liberation Sans\", sans-serif, \"Apple Color Emoji\", \"Segoe UI Emoji\", \"Segoe UI Symbol\", \"Noto Color Emoji\"; font-size: 16px; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;\">Et provident sed dolores aliquid est doloremque provident At repellat fuga</em><span style=\"color: rgb(33, 37, 41); font-family: system-ui, -apple-system, \"Segoe UI\", Roboto, \"Helvetica Neue\", Arial, \"Noto Sans\", \"Liberation Sans\", sans-serif, \"Apple Color Emoji\", \"Segoe UI Emoji\", \"Segoe UI Symbol\", \"Noto Color Emoji\"; font-size: 16px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;\">.</span></p>', '<p>Lorem ipsum dolor sit amet. Cum facere assumenda <em>Ut quia sit repellat omnis</em>. A molestiae quos non velit dolorumet omnis sed nostrum laboriosam qui deserunt quas.</p><p><br></p><p> </p><p>Est omnis quia sit tempore consequatur <em>Ut autem cum harum modi aut consequatur doloribus</em>. Nam facere dolorum <strong>Eum corporis ut quam quaerat</strong>? Quo eaque omnisAut illum quo quam dolorum et perferendis fugiat non quod aspernatur sed excepturi nihil. Aut sint molestias rem amet animised quisquam quo enim debitis!</p><p><br></p><p> </p><p>Rem aliquam asperiores id illo repellat <strong>Ex ipsam id nisi modi ea nemo laudantium qui reprehenderit quia</strong>. Ea quas neque qui ipsa earumAut labore ut fuga reiciendis et blanditiis ducimus eos natus nemo qui beatae quas! Eum quia molestiae <em>Et perspiciatis</em> ut exercitationem quod. </p>', 1999.00, 2799.00, 'SKU-0004', 'xs,s,m,l,xl,xxl', 7, 16, 14, '0', '1', '1', '2025-05-12 02:15:45', '2025-05-30 01:19:18'),
(8, 'Demo Product 02', '20250512104119_548.jpg', 2, 'demo-product-02', '<p>Lorem ipsum dolor sit amet. Aut beatae blanditiis aut explicabo recusandaeeos voluptatem et autem dolor. Aut quasi adipisci Ut aliquam sit mollitia reiciendis et illum facere rem tempore consectetur aut labore dolore nam adipisci aliquam.</p>', '<p>Lorem ipsum dolor sit amet. Sed dignissimos voluptatem qui doloremque maximecum doloremque aut voluptatibus illo sed molestias atque. Ea soluta ipsa sed illum voluptatem <strong>Ut voluptatem ex nisi culpa</strong>.</p><p><br></p><p> </p><p>Et amet reiciendis aut quos evenietquo nihil est temporibus suscipit. Et amet minus ea fugit porroEst recusandae ut obcaecati officia in laboriosam consequuntur et perspiciatis soluta ea quaerat iusto. Est enim distinctio <em>Est voluptatem id odit ullam est galisum porro</em> sit nobis voluptatem! Qui facilis velit ex quae aperiameos laudantium.</p><p><br></p><p> </p><p>Ab dolorum fuga aut corporis voluptas <strong>Id esse sit fugiat omnis qui minima natus qui asperiores vero</strong>? Ut odit iste est reprehenderit nihilEx repudiandae ut culpa commodi ut pariatur nostrum et saepe perferendis quo officia odio!</p><p><br></p><p> </p><dl><dt><dfn>At voluptas libero qui commodi quaerat? </dfn></dt><dd>Hic asperiores maxime eos ipsum magnam aut quos velit. </dd><dt><dfn>Vel nulla veritatis qui rerum itaque. </dfn></dt><dd>Et alias porro rem consectetur assumenda est rerum totam 33 dolorem quod. </dd><dt><dfn>Sed esse aliquid. </dfn></dt><dd>A quam illo sit aspernatur ipsam.</dd></dl>', 1299.00, 2000.00, 'SKU-0008', 'xs,s,m,l,xl', 8, 2, 13, '0', '1', '0', '2025-05-12 02:27:06', '2025-05-30 01:19:07'),
(9, 'Demo Product 03', '20250512104107_254.jpg', 1, 'demo-product-03', '<p><span style=\"color: rgb(33, 37, 41); font-family: system-ui, -apple-system, \"Segoe UI\", Roboto, \"Helvetica Neue\", Arial, \"Noto Sans\", \"Liberation Sans\", sans-serif, \"Apple Color Emoji\", \"Segoe UI Emoji\", \"Segoe UI Symbol\", \"Noto Color Emoji\"; font-size: 16px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;\">Lorem ipsum dolor sit amet. Rem consequatur culpa aut corporis reprehenderitet nemo. Et sapiente modi aut sunt undeUt laudantium qui modi fuga aut perspiciatis quia ad laborum harum. In repellendus amet et dolores nullaut minima!</span></p>', '<p>Lorem ipsum dolor sit amet. Ut tempora necessitatibus sit quos maioresUt esse eum itaque rerum eos nihil voluptates sit ducimus accusamus quo perspiciatis quibusdam? Qui quidem magni 33 esse itaque <strong>In quae</strong>. A earum officia a quis eius <em>Qui dolore ut adipisci debitis</em>. Et provident animi sit illum aspernatursit minus a autem voluptate.</p><p><br></p><p> </p><p>Et voluptatibus galisum ea nesciunt similiqueet ullam non ratione aspernatur. Est voluptatem enim et tempora incidunt <strong>Et dolorum</strong>. Ab nesciunt voluptatem qui maxime eaqueEt architecto qui galisum inventore qui consequatur dicta sit provident velit?</p><p><br></p><p> </p><p>Non iusto temporeEst atque cum modi voluptate nam rerum laborum aut itaque sequi et necessitatibus doloremque qui quidem nostrum. Hic neque omnis sed molestiae rerum <strong>Sit numquam in deleniti autem hic expedita aspernatur ea internos corporis</strong>. Eum distinctio enim non aspernatur voluptatemeum quisquam. Sit molestias repudiandaeEt reiciendis 33 maiores autem est neque repellat et pariatur modi ut neque officiis quo velit recusandae. </p>', 1999.00, 2999.00, 'SKU-0010', 'xs,s,m,l,xl', 10, 16, 9, '1', '1', '1', '2025-05-12 02:41:19', '2025-05-30 01:18:55'),
(10, 'Demo Product 04', '20250512104055_604.jpg', 1, 'demo-product-04', '<p>Et dolores fuga et earum voluptatum et impedit enim in natus dolore vel facere ratione ut quia quod et consequatur necessitatibus. Non illo internos sit laboriosam eveniet eos dicta repudiandae. In voluptatem corrupti et dignissimos porro ea fugit voluptatum ab error esse eum voluptatem nobis At beatae perferendis aut fugiat dolor.</p>', '<p>Lorem ipsum dolor sit amet. Et labore unde <strong>Est quaerat aut sunt quaerat aut veniam deserunt</strong> est suscipit voluptatum! Qui itaque odit sit delectus facilis <em>Et inventore</em>. Ea maiores omnis qui voluptas voluptatemSed obcaecati sit nihil temporibus At quisquam repudiandae sit harum minus in repellendus dolore. Et ipsa molestiaeQuo voluptatibus ab nulla dicta ut quisquam vero ea quisquam consequatur qui minima illo est incidunt corrupti.</p><p><br></p><p> </p><p>Vel quia omnis et quia voluptatemSed corporis vel mollitia ipsa. Aut voluptas iusto <strong>Eos blanditiis</strong> ut quia amet. Sit cupiditate ipsum ut numquam officiis <em>Sit dolore eos nihil voluptate non eius quia et libero labore</em> 33 placeat quas. Ut perspiciatis aspernatur et omnis nemoaut fuga.</p><p><br></p><p> </p><p>Eos error iste et deserunt quisquamsit quam hic sunt facilis non veritatis obcaecati! In ipsam magnam rem obcaecati suscipit <em>At tenetur cum consequatur debitis non reiciendis maiores et enim quam</em>. Aut autem fugiat 33 officia voluptatesSed veritatis aut dignissimos suscipit vel rerum sunt ut cumque velit. </p>', 799.00, 1499.00, 'SKU-0001', 'xs,s,m,l,xl,xxl', 13, 10, 15, '0', '1', '1', '2025-05-12 02:53:03', '2025-05-30 01:18:40'),
(12, 'Demo Product 06', '20250512104036_6.jpg', 2, 'demo-product-06', '<p>Lorem ipsum dolor sit amet. Qui quia libero est aliquid repellendus et sint sunt et rerum voluptates non rerum iste 33 omnis voluptatibus et autem possimus. Et commodi quia non consequatur perspiciatis in ratione atque ut tenetur omnis ab ipsa provident.</p>', '<p>Lorem ipsum dolor sit amet. Id beatae fugit et saepe inventoresed galisum. Ab delectus iusto <strong>A eligendi et galisum minus et ullam eligendi</strong> vel quod accusantium est quia omnis. Sed omnis animi est laborum animiRem enim quo dolores veniam aut sapiente praesentium est omnis esse.</p><p><br></p><p> </p><p>Aut dolorum laudantium sed dicta iustoaut expedita est asperiores nostrum ut quibusdam voluptas. Vel nihil quisquam <em>Ab nesciunt qui explicabo dolorem et recusandae ratione</em> At ullam autem non optio inventore. Qui molestiae itaque qui unde delenitiUt nobis ab autem quaerat qui molestiae voluptatem.</p><p><br></p><p> </p><p>Ut maxime consequatur id voluptas aperiam <strong>Nam voluptas aut quia commodi ad mollitia illum ut possimus velit</strong>. Id officiis temporeEt autem eos maiores praesentium quo dolorum velit? </p>', 1199.00, 1999.00, 'SKU-0114', 'm,l,xl', 5, 15, 16, '0', '1', '1', '2025-05-12 03:47:06', '2025-05-30 01:18:26'),
(13, 'Demo Product 07', '20250512104025_2.jpg', 2, 'demo-product-07', '<p>Lorem ipsum dolor sit amet. Ut iure voluptates vel nemo quia sed adipisci galisum At repellat maiores. Et debitis cupiditate non quia cumque sed nisi minima et earum laboriosam ut mollitia magnam. Est molestiae ratione sed enim rerum qui laborum nulla. Et repellendus cumque est autem libero ut culpa suscipit.</p>', '<p>Lorem ipsum dolor sit amet. Et aliquam blanditiis eum dolor commodi <strong>Est odio est aspernatur explicabo qui voluptatum fuga qui quidem eius</strong>. Ut reprehenderit aliasut consequatur aut odit perferendis. Ea nihil possimusUt rerum aut adipisci voluptate et autem nihil et dolore enim!.</p><p><br></p><p>Aut illum tempora eum odio doloribusHic facere et voluptatem perspiciatis ut voluptas voluptatem sit Quis ducimus aut possimus quia. Ut omnis quam <strong>Sed voluptatem</strong> et autem corrupti et vitae veniam! Est deleniti accusantium <em>Ut explicabo 33 error illum ea minus consectetur a voluptates voluptates</em>.</p><p><br></p><p> </p><p>Id earum molestiae <strong>Sit amet qui maxime perspiciatis et ratione officia</strong>. Et rerum corporis qui beatae itaquehic quibusdam nam accusantium nihil eum quod maiores. Et temporibus exercitationem sed illo providentut aspernatur. Aut ipsam laborumEt quia ab quia commodi ut blanditiis quos? </p>', 699.00, 1249.00, 'SKU-7777', 'm,l,xl,xxl', 17, 16, 10, '1', '1', '1', '2025-05-12 04:14:27', '2025-05-30 01:18:17'),
(14, 'Demo Product 08', '20250512104015_712.jpg', 1, 'demo-product-08', '<p>Lorem ipsum dolor sit amet. Et Quis velit et dolorem suscipit in accusamus dignissimos ad nemo placeat eos amet earum. Aut aliquam incidunt vel internos blanditiis ut veritatis laudantium eum officia rerum qui fugiat voluptate ut ullam earum est fugiat quia. Vel dolores placeat qui esse ipsa qui dolores totam est blanditiis dolor quo veniam iusto.</p>', '<p>Lorem ipsum dolor sit amet. Ut accusantium distinctio est rerum quisquamIn ullam eos officiis quos aut magnam galisum non fuga soluta. Eos voluptates modi <strong>Cum quas</strong> non libero fugit sed exercitationem explicabo. Et obcaecati numquam eos quod dolores <em>Qui velit rem reprehenderit impedit</em> eos quia nihil et omnis reiciendis sed dolorem similique?</p><p><br></p><p> </p><p>Et tempora molestiae est voluptatem inventoreEt modi aut iure consequatur est ipsam sapiente. Et suscipit adipisci eos velit voluptatum <em>Ut autem et aspernatur nisi eum itaque perspiciatis et dolor voluptatem</em>. Rem molestias fuga <strong>Et molestiae qui quasi maxime qui natus cupiditate</strong> non eaque sint aut voluptatum reprehenderit sit expedita perspiciatis.</p><p><br></p><p> </p><p>Et molestias rerumSed sequi ea consectetur harum in quia eligendi At iste praesentium non tempore aliquam aut eligendi nisi. Est dicta doloremque <strong>Aut similique et explicabo numquam aut reiciendis excepturi</strong>. Ut obcaecati ipsum quo consectetur aspernatur <em>Ex maxime est nesciunt voluptatem</em>. Et sint facilis aut nesciunt doloresEos nostrum sit iure error et quibusdam quam ut eius facilis id sint adipisci. </p>', 549.00, 999.00, 'SKU-2258', 's,m,l,xl', 15, 1, 15, '0', '1', '1', '2025-05-12 04:18:47', '2025-05-30 01:17:42'),
(15, 'Demo Product 09', '20250512104006_429.jpg', 2, 'demo-product-09', '<p>Lorem ipsum dolor sit amet. Aut repellat voluptas rem voluptatem maiores ad ipsum fugit in eligendi ipsam et delectus dolorem et aspernatur fugit hic officia reprehenderit. Ab eveniet nisi qui nisi voluptas non quas repudiandae et ipsam iste. Et fugiat blanditiis eos tempora ullam ut nihil rerum ea aliquam expedita eos eaque perspiciatis vel itaque dolorum aut dolorum corporis.</p>', '<p>Lorem ipsum dolor sit amet. Qui iste omnisAut Quis est debitis quidem non culpa sunt ad totam velit est corrupti dolor qui consequatur voluptatibus. Aut veritatis odio aut placeat culpa33 aperiam.</p><p><br></p><p> </p><p>Et rerum voluptas <em>33 omnis ut exercitationem asperiores id perferendis asperiores</em> non doloribus vero est officia rerum. Eos dolor totam vel esse sequi <strong>Eos quisquam et deserunt facere sed dolores dolores qui assumenda commodi</strong>. Hic voluptatum suntVel architecto vel accusamus ipsa et dicta animi et libero sunt est molestiae repudiandae qui aspernatur quasi. Ad voluptatem veritatisEst magnam est dignissimos molestiae non molestiae nihil vel asperiores quas hic quod aspernatur nam quaerat modi.</p><p><br></p><p> </p><p>Id dolores nihil <strong>At nihil et rerum neque est ipsa autem et impedit adipisci</strong> et deleniti dolore et expedita quisquam! Et consectetur sunt <em>Et totam est autem quam et beatae impedit</em> sit delectus praesentium est dolore temporibus et possimus molestias? Eum quia excepturi in nemo errorEt veniam sit consequatur earum et aperiam autem. Aut quibusdam fugit non sint eiusQui autem aut asperiores quibusdam in commodi odit eos obcaecati impedit qui laudantium incidunt. </p>', 499.00, 999.00, 'SKU-1001', 'xs,s,m,l,xl,xxl', 19, 13, 18, '0', '1', '1', '2025-05-12 04:28:41', '2025-05-30 01:17:29'),
(16, 'Demo Product 10', '20250512103947_114.jpg', 1, 'demo-product-10', '<p>Lorem ipsum dolor sit amet. Nam amet optio est necessitatibus quam qui dolorem saepe id veniam fugit. Et internos eaque ut optio enim et galisum dignissimos qui quasi distinctio qui quasi dolor ab veritatis modi? Cum laboriosam incidunt et recusandae laudantium est ipsam dolores ut voluptatibus libero ut ullam quam sit quisquam expedita. Et reiciendis fuga sed autem earum non ratione maiores.</p>', '<p>Lorem ipsum dolor sit amet. Nam iure eiusSit necessitatibus et nihil eius sit cupiditate internos ea galisum molestiae in atque fugiat! 33 quidem rerum non eveniet illoEa ipsam. In temporibus quam sed voluptatem consequaturut nulla ut consequatur maxime. Ut laudantium exercitationem aut alias temporaAb quaerat et eius ducimus sit voluptatum doloremque.</p><p><br></p><p> </p><p>Ut quasi iure a nostrum nobisVel incidunt qui delectus modi id error voluptates ut fuga libero. Aut modi voluptatum <strong>Et voluptates et galisum consequatur At maiores corrupti</strong> in veniam dolore aut nobis ullam. Id facere eveniet est recusandae possimuseos perferendis eos beatae voluptates. Et tempora sint et ipsum iureAut dolorum qui excepturi consequuntur id molestiae voluptatem aut incidunt dolores in libero aliquid.</p><p><br></p><p> </p><p>Qui earum consequatur cum saepe delectusEt laboriosam et sint nesciunt quo aspernatur aspernatur aut minima odit cum quisquam earum. Sit corrupti reprehenderit <strong>Est impedit</strong> sed deleniti voluptate qui vitae necessitatibus! Qui veritatis quae <em>Aut temporibus eum omnis odit qui dolorem inventore vel voluptatum quia</em> aut maxime enim qui voluptatem distinctio. Hic itaque optio et nulla Quissed tempora aut aliquid Quis. </p>', 999.00, 1699.00, 'SKU-0708', 'xs,s,m,l,xl,xxl', 11, 16, 13, '1', '1', '1', '2025-05-12 04:30:58', '2025-05-30 01:17:18'),
(17, 'Demo Product 11', '20250512105114_324.jpg', 2, 'demo-product-11', '<p>Lorem ipsum dolor sit amet. Rem aliquid ipsa sit quod laboriosam ut dolores dolore qui dolorum eveniet aut dignissimos natus. Et ducimus porro ut numquam eaque ut modi magnam rem mollitia nisi sed quia voluptas est autem odio. Qui vitae maxime et nobis similique qui quas laudantium. Vel ipsum velit aut dolore impedit aut omnis sapiente sit voluptas harum qui deserunt sint.</p>', '<p>Lorem ipsum dolor sit amet. Ea quaerat iusto et reprehenderit culpaSit illum a illum quae et recusandae rerum non rerum tempore id nulla repellendus. Eum iusto doloremque <em>Aut quia 33 sapiente nihil cum libero tempore</em> qui ipsum omnis quo eaque cupiditate. Et voluptatem facere <strong>Ut provident et eaque possimus At consequuntur illo</strong> ut vero eveniet in harum quibusdam non corporis natus.</p><p><br></p><p> </p><p>Et ullam voluptatesRem culpa et accusamus distinctio et aperiam internos id tempora dolore sed atque inventore. Sed odio officiis in vero dolores <strong>Et eius ex adipisci minus a commodi quia non doloremque ipsam</strong>! Et consequatur dolorem a voluptatem nobis <em>In quae et autem ipsam qui fugiat provident</em>!</p><p><br></p><p> </p><p>Qui porro aliquam <strong>Id officiis eos voluptates recusandae non molestiae natus</strong> qui vitae ducimus in ipsum quae! Et vitae doloresIn soluta quo voluptate nesciunt ut exercitationem fugit et cumque placeat. Ea ullam quaerateum temporibus ab maxime cumque. Aut nostrum veritatis et saepe perspiciatisQui architecto ex autem quasi sed commodi libero. </p>', 1599.00, 2299.00, 'SKU-0108', 's,m,l,xl,xxl', 10, 10, 7, '1', '1', '1', '2025-05-12 05:21:14', '2025-05-30 01:17:04'),
(18, 'Demo Product 12', '20250512105417_95.jpg', 2, 'demo-product-12', '<p>Lorem ipsum dolor sit amet. Aut galisum iure id quos ipsa ad corrupti quae ad consequatur sequi est quia similique. Aut accusantium consequatur et quisquam nulla At fuga quia et dolores nesciunt. Qui sunt reiciendis non veritatis facilis est laudantium quos ut fugit nemo sit perferendis rerum. Aut nihil doloremque est officia minus ut esse sapiente eos delectus quibusdam!</p>', '<p>Lorem ipsum dolor sit amet. Et iusto ducimus et animi reiciendisEt nobis quo blanditiis officiis et eveniet molestiae aut explicabo vitae. 33 iusto pariatur id quia repellendusa velit et unde voluptatem. Sed quia dolorem <strong>Et dicta sit temporibus praesentium</strong>. Rem voluptas consectetur At minima nihilEx corrupti hic soluta cupiditate quo sunt provident id tenetur optio.</p><p><br></p><p> </p><p>Rem repudiandae esse <em>Aut sunt et cumque voluptatem ut laudantium repellat</em> eum recusandae eveniet rem repudiandae voluptate! Qui accusamus totam et placeat minima <strong>Est vero</strong>.</p><p><br></p><p> </p><p>Non accusantium sequi rem dicta magnamQuo fuga vel pariatur distinctio! Sed repellat placeat 33 exercitationem rerumqui cupiditate qui unde doloremque. Aut numquam saepeSed aspernatur est distinctio mollitia?</p><p><br></p><p> </p><p>Sed reiciendis dolorem <em>In alias est assumenda consectetur quo aliquid cumque</em> ea suscipit ipsa! Et Quis voluptas <strong>Ut velit</strong> ut praesentium dolor est error maxime? Aut voluptas aliquid vel dolorem excepturiUt dolor. </p>', 2299.00, 2999.00, 'SKU-0009', 'm,l,xl,xxl', 8, 16, 14, '1', '1', '1', '2025-05-12 05:24:17', '2025-05-30 01:16:51'),
(19, 'Demo Product 13', '20250512110336_248.jpg', 1, 'demo-product-13', '<p>Lorem ipsum dolor sit amet. Non dolorem delectus et soluta aliquam qui voluptas atque. Eos consequatur rerum est perferendis illum ut voluptatem voluptatem est inventore vero qui tenetur veritatis eum dicta dolorum sit nemo nulla. Qui ipsam adipisci et omnis facere ut minima quae qui consequatur ipsam ut facilis autem eos fugiat fugiat.</p>', '<p>Lorem ipsum dolor sit amet. Sed minima quasi <em>Et dolores est enim adipisci et assumenda vero</em> et beatae nesciunt sed earum atque est culpa dolores. Vel obcaecati illo aut quae consecteturEt saepe ad excepturi alias in commodi blanditiis id adipisci exercitationem est velit rerum. Id delectus repudiandae At nemo officiis <strong>Est voluptates ut pariatur doloribus</strong>. Quo quis autem aut nihil doloresaut provident est facilis voluptates sit fugiat saepe.</p><p><br></p><p> </p><p>Hic excepturi voluptatem <strong>Quo blanditiis sed quis nulla aut dolorem internos</strong> et repellendus nihil non corrupti aperiam qui quas commodi. Ut possimus sunt <em>Et dolor eum consequatur dolorem et eaque quasi</em>.</p><p><br></p><p> </p><p>Eum velit itaque <em>Eum veniam in maiores earum qui consectetur commodi est inventore cupiditate</em>. In enim voluptatibus et iure delenitiAt asperiores ex incidunt possimus At quos enim et atque dignissimos est magni impedit.</p><p><br></p><p> </p><p>In rerum suscipit ut aspernatur impeditNon laudantium. Ad nulla Quis <em>Ut corporis sit similique possimus eum dolores iusto</em> ut minus internos ut corporis natus. Ut reprehenderit quasi <strong>Quo quis est accusamus dolorum qui quam voluptatem</strong> sit consequatur corporis. </p>', 2699.00, 3299.00, 'SKU-0222', 'xs,s,m,l,xl,xxl', 10, 2, 14, '0', '1', '1', '2025-05-12 05:33:36', '2025-05-30 01:14:53'),
(20, 'Demo Product 14', '20250512110518_803.jpg', 1, 'demo-product-14', '<p>Lorem ipsum dolor sit amet. Ut debitis fugit aut rerum laudantium sit minima iste ut nulla omnis et neque autem sed ipsa alias! Et voluptas expedita non consequatur voluptatibus aut dolorem aperiam est possimus voluptatem quo excepturi expedita ut molestiae error? Ut commodi accusantium id cumque rerum aut cumque autem id voluptatem laboriosam sit tempora repellendus eum ullam porro 33 inventore beatae.</p>', '<p>Lorem ipsum dolor sit amet. Qui sint voluptas <strong>Sed saepe est delectus autem et sunt pariatur</strong>. 33 odit voluptas <em>At laudantium ut officia ratione At Quis earum</em> et numquam autem ad voluptatem aspernatur et dolores quisquam. In eius placeat non distinctio similiqueQuo aperiam eos ducimus rerum.</p><p><br></p><p> </p><p>Sed obcaecati omnisEt esse ut maxime ullam non voluptate illum quo itaque alias. Non itaque eveniet <strong>Et adipisci et unde reiciendis et accusantium totam</strong> ab quisquam aspernatur et nihil repellat? Aut laudantium dolorum <em>Sed itaque est quisquam voluptatem est sint consequatur</em> et ducimus velit ea necessitatibus iusto? Sit omnis consequaturSed ipsum aut consequatur alias sit facere neque.</p><p><br></p><p> </p><p>In minus voluptate et voluptatem officiis <strong>Qui repellat et obcaecati explicabo aut dignissimos vitae nam necessitatibus sapiente</strong>. Ea sunt esse et commodi voluptatem <em>Et odio aut pariatur incidunt qui consectetur facilis</em>. Hic voluptatem repellendus 33 sunt repellendusEum quod.</p><p><br></p><p> </p><p>Ut fugiat harum ut voluptatibus nihilEt ipsa et atque unde in ratione quia sed natus quam eum totam nisi. Ut blanditiis ipsum aut placeat nemo <strong>Ut voluptatem est quia natus et autem perferendis</strong>. Sit assumenda esse <em>Non labore et voluptatem amet ut corrupti quidem</em> eos voluptatem asperiores sed aliquam quis non architecto officiis. Non galisum totamQuo perspiciatis est odio quaerat. </p>', 3199.00, 3999.00, 'SKU-5767', 's,m,xl,xxl', 6, 14, 14, '1', '1', '1', '2025-05-12 05:35:18', '2025-05-30 01:14:41'),
(21, 'Demo Product 15', '20250512110749_679.jpg', 1, 'demo-product-15', '<p>Lorem ipsum dolor sit amet. Est odit rerum et magni vitae id ducimus similique At tenetur commodi et consequuntur distinctio et iure quam! Qui aspernatur tenetur et galisum perspiciatis eum voluptas saepe id incidunt tempore. Aut vero odit sit tenetur repellendus sed quis consequatur non nihil dicta. Ad eius fugit qui inventore eaque et deserunt praesentium!</p>', '<p>Lorem ipsum dolor sit amet. Vel pariatur asperioresQui veritatis aut iste corrupti rem similique iusto id velit totam sed corporis mollitia sit minima distinctio! Ut harum doloremque aut voluptates molestias <em>Aut voluptates sit quisquam unde nam facilis vero qui fuga corrupti</em>? Quo nemo laborum sit amet nesciunt <strong>Et suscipit sit laudantium doloremque sit aliquid dolor</strong>. Eos earum quisquamAd saepe vel internos ipsa ea rerum obcaecati.</p><p><br></p><p> </p><p>Et laborum quia sit sapiente magniest velit in deleniti suscipit. Qui dolores nisiUt quia ut blanditiis obcaecati sit commodi doloribus qui enim internos et quibusdam sint cum ratione quia.</p><p><br></p><p> </p><p>Ut corporis tenetur est eius fuga <em>Et Quis aut fugit galisum id nobis accusantium est veritatis magnam</em>. Et pariatur porro sed inventore ipsamEum libero ex dicta officia ut dolores voluptate. Quo laboriosam repellat id dolores recusandae <strong>Vel libero eos autem illum</strong> ut rerum facilis et necessitatibus illo ut asperiores fugiat.</p><p><br></p><p> </p><p>Est consequatur dignissimosUt suscipit non obcaecati sint sit ratione explicabo ut quia soluta et consequatur nemo. In tempore voluptas et fuga eligendi <strong>Et expedita rem officiis dolor sed magni consequuntur non saepe culpa</strong>! In totam fugiat eum beatae corporis <em>Et vitae est numquam ratione ad ratione aspernatur</em>. Ea voluptatem voluptatem ut excepturi atqueQui ducimus vel rerum tempore id exercitationem velit At omnis voluptate nam sequi atque. </p>', 3499.00, 4299.00, 'SKU-4011', 'xs,s,m,l,xl,xxl', 9, 1, 9, '1', '1', '1', '2025-05-12 05:37:34', '2025-05-30 01:14:14'),
(22, 'Demo Product 16', '20250512110925_317.jpg', 1, 'demo-product-16', '<p>Lorem ipsum dolor sit amet. Sit natus quos ut enim mollitia sed magni unde non sint totam. Et eaque nesciunt ut iusto galisum quo atque voluptatem et facere debitis! Est voluptatem laboriosam quo ratione error id modi voluptatem et sunt saepe et exercitationem esse. Ea aperiam dolorum aut asperiores dolorem et distinctio autem est optio enim rem magni ipsa.</p>', '<p>Lorem ipsum dolor sit amet. Aut voluptatum perspiciatis <strong>Sit perferendis quo obcaecati iusto eum obcaecati similique</strong>. Non voluptas fugiat et voluptatem teneturut exercitationem est voluptatem error qui porro impedit. Qui maxime laboriosam et odio fugaSed neque et dolor delectus qui sapiente laudantium et nulla molestiae.</p><p><br></p><p> </p><p>Et tenetur molestias aut autem voluptasSed neque sed fugiat architecto! Ut illo dolor At sint praesentium <strong>Nam tempora At velit officiis ut facilis nesciunt sit quos tempora</strong>? Vel internos voluptatem <em>Hic distinctio sit laborum nobis est unde autem</em>. Id vero eaque et porro voluptatemAut similique.</p><p><br></p><p> </p><p>Et quidem adipisci <em>Ut voluptatem nam beatae illo et perferendis ipsam</em> non quia dolorum. Et laborum itaque <strong>Et minus eos autem sint rem velit similique ut ullam dolorem</strong> sed natus accusantium et laboriosam itaque. Ea expedita QuisEum molestiae quo voluptatum dolorum.</p><p><br></p><p> </p><p>Qui provident dolorumqui porro sed earum veniam. Ut blanditiis recusandae vel porro libero <em>Et galisum in reprehenderit voluptas vel aliquam accusamus et iure adipisci</em>. Est consectetur facereAut galisum et laboriosam facilis sed numquam ratione qui error maxime hic sint possimus! Aut voluptas odit qui sequi quiaUt saepe sed placeat quia quo voluptatem quod qui sapiente corrupti qui voluptates pariatur. </p>', 2599.00, 3155.00, 'SKU-2045', 's,m,l,xl', 0, 13, 16, '0', '1', '1', '2025-05-12 05:39:25', '2025-05-30 01:14:05'),
(23, 'Demo Product 17', NULL, 0, 'demo-product-17', '<p>Lorem ipsum dolor sit amet. Sed magni dicta eum recusandae dolor Est distinctio et officiis dolorum rem autem omnis id animi nisi aut rerum asperiores! Non fuga consectetur qui omnis suntaut dolore non sunt Quis. Ut assumenda officia ut esse commodiut laborum ut neque eaque? Ut odio enim nam consectetur nostrumSit enim est tempore velit et iusto sequi.</p>', '<p>Lorem ipsum dolor sit amet. Sed velit QuisEt veniam aut galisum doloremque eum veritatis veritatis sed molestiae sint et rerum similique sed autem iste! Et itaque assumenda <em>Cum quasi in quasi vitae et modi consequatur</em>. Nam recusandae debitis in sunt sint <strong>Qui ratione et nemo officiis in voluptas alias nam atque deserunt</strong>.</p><p><br></p><p> </p><p>Sit necessitatibus culpa non beatae corporisvel quia. Sit aspernatur ipsam et consequatur iusto <strong>Quo facilis qui vero Quis sit omnis porro non velit voluptate</strong> aut mollitia quia. Est consequatur corporis ut enim ullamet quod! Est incidunt doloresSed reiciendis in voluptas Quis qui deserunt consequatur ut suscipit deleniti ut exercitationem beatae.</p><p><br></p><p> </p><p>Eos omnis eligendiUt pariatur et voluptas odit et rerum voluptatum ut quas deserunt. Qui architecto molestiae qui voluptates obcaecatiea cumque 33 dolorem quasi. Non facilis beatae <strong>Et sequi qui voluptatibus corporis est enim voluptatem</strong> et earum amet ex dolorem praesentium ea fugiat mollitia. Est voluptas atque aut voluptas aspernaturQuo ipsum.</p><p><br></p><p> </p><p>In totam galisum <em>Qui possimus non internos velit qui officiis omnis</em> et consequatur distinctio. Est architecto repellendus <strong>Est itaque et aliquid nesciunt eos vero voluptatem</strong> quo fugit commodi. </p>', 399.00, 899.00, 'SKU-1701', 'xs,s,m,l,xl,xxl', 20, 16, 18, '0', '1', '1', '2025-05-15 01:05:03', '2025-05-30 01:10:30'),
(24, 'Demo Product 18', NULL, 0, 'demo-product-18', '<p>At minus sapiente ut odio blanditiis nam quasi aperiam eum tempora inventore a sunt fugiat et nisi itaque. Eos ipsam nostrum aut omnis voluptatum ad consequatur ipsum et dolore aperiam quo voluptas nihil qui iusto consequatur. Et consequatur assumenda et eaque reprehenderit aut voluptates exercitationem in quia corrupti qui deserunt necessitatibus et delectus nisi. Non ullam omnis qui voluptas enim aut magnam impedit et delectus quia qui deleniti molestiae aut fugiat dicta.</p>', '<p>Lorem ipsum dolor sit amet. Ad Quis iste <em>At voluptates et debitis debitis aut facilis galisum</em> est sunt sunt et Quis cumque! Ex nesciunt internos sed totam accusantium <strong>Ab facilis quo consequatur dolor et consequatur animi ut internos assumenda</strong>. Et galisum eveniet sed veritatis Quisest dolorem in quis dolores.</p><p><br></p><p> </p><p>33 repudiandae fugaQuo animi ut incidunt officiis est dolores architecto ut reiciendis velit qui illo quisquam in ipsum quibusdam! Et aspernatur minima ea nihil fugit <strong>Est laudantium in modi consectetur et maxime inventore id numquam eveniet</strong> non sunt adipisci. A doloribus laboriosam <em>Ex reprehenderit est facere sapiente qui eius nihil</em> qui dolor deserunt rem velit omnis. Est incidunt obcaecatiAut debitis aut nostrum voluptatem et voluptatem sunt qui consequatur tempore.</p><p><br></p><p> </p><p>Eum fuga omnisSit voluptatibus rem dolor veniam rem aspernatur dolor. Et autem nisi <em>Et impedit</em> ex vero atque eum quaerat alias.</p><p><br></p><p> </p><p>Quo assumenda accusantium <em>Aut doloribus sit accusantium voluptas aut tenetur dicta ut obcaecati veritatis</em> vel adipisci veritatis ut quos quam. Eos accusamus nostrum aut nulla nihileum aperiam sit illum quam. Hic architecto fuga aut omnis cupiditate <strong>Aut iste aut molestiae tempora et quibusdam corrupti et officiis quia</strong>. Id quod iureEt illo nam consequatur accusantium et tenetur quisquam in laboriosam amet id quos omnis qui perspiciatis obcaecati. </p>', 1099.00, 1699.00, 'SKU-0768', 's,m,l,xl', 14, 14, 7, '0', '1', '1', '2025-05-15 01:08:22', '2025-05-30 01:10:19'),
(25, 'Demo Product 19', NULL, 0, 'demo-product-19', '<p>Lorem ipsum dolor sit amet. Ab assumenda dolor sit adipisci sunt non corrupti odio qui nesciunt temporibus aut ullam dolorem et omnis exercitationem. At eligendi consectetur ut sunt quibusdam ut laborum provident At repudiandae officiis et vero minus sed accusamus deserunt qui delectus natus. Aut nesciunt iure et enim nemo nam exercitationem saepe non enim cumque.</p>', '<p>Lorem ipsum dolor sit amet. Qui dolorem cupiditate et nostrum quamAut perferendis aut eveniet provident sit quasi maiores ea animi voluptatem ea consequatur iure? Et minus corruptiId error a molestiae ullam et sunt dolorem ut itaque voluptas non temporibus dolor. Sit quisquam galisum <em>Est magnam</em> qui quae velit.</p><p><br></p><p> </p><p>Ut tempora praesentium ad dolorem omnis <strong>Aut labore quo doloribus voluptates sed nostrum dolore</strong>. Eos voluptas quidem aut consectetur expedita <em>Non repudiandae vel omnis itaque est quisquam numquam nam velit galisum</em>. Et quaerat doloremQui necessitatibus eum omnis nesciunt quo omnis praesentium ut aliquid enim vel voluptas officia! Et magnam inventore sit dignissimos sapienteEt adipisci vel nisi pariatur non internos laudantium est placeat necessitatibus.</p><p><br></p><p> </p><p>Aut corrupti beatae ad vero nesciunt <em>In laboriosam nam quaerat consequatur ut neque quia</em>. In galisum minus et laboriosam nostrum <strong>Quo architecto vel architecto Quis ex repudiandae consequatur sit dolor excepturi</strong> id dignissimos fugiat.</p><p><br></p><p> </p><p>Sed sapiente nihil <em>Et rerum et facilis ratione quo autem velit ea vero aspernatur</em>. Ad temporibus expedita <strong>Et officiis est dolores necessitatibus ea libero facere</strong> et dolorum quia et error dolor. Qui saepe repellat sed quia repellatet maiores est galisum asperiores. Est suscipit suntEt iste qui enim expedita. </p>', 3499.00, 4550.00, 'SKU-1075', 'xs,s,m,l,xl,xxl', 6, 13, 16, '0', '1', '1', '2025-05-15 01:10:25', '2025-05-30 01:10:08'),
(26, 'Demo Product 20', NULL, 0, 'demo-product-20', '<p>Ut architecto sequi et minima corrupti non minima minima ut aspernatur numquam aut distinctio doloremque ut soluta nihil ut error reiciendis. Ut veniam facilis eum ducimus veniam et voluptatem quisquam et blanditiis tempore. Et molestiae iste sit doloremque temporibus est repellendus repellat qui similique voluptatem qui commodi nemo. Ad natus aspernatur qui galisum suscipit aut quasi adipisci.</p>', '<p>Lorem ipsum dolor sit amet. Ut praesentium deserunt <strong>Sit doloremque qui culpa perspiciatis qui iste reiciendis</strong>. 33 nisi autemEt quidem et pariatur commodi est aspernatur quos. Et quae dolorum cum corrupti tenetur <em>Aut internos eos ratione reiciendis cum debitis culpa ad ipsam unde</em> sit sint cumque? Est dicta deleniti hic voluptatem maioresea galisum et quisquam voluptas?</p><p><br></p><p> </p><p>Aut tempore aliquam <strong>Eum rerum id natus illum et excepturi assumenda ab tempore minus</strong> est sint unde et suscipit magnam. Vel omnis dolorem non doloribus necessitatibus <em>Ea sint 33 harum molestias et reprehenderit doloribus sed nulla praesentium</em> eum molestiae recusandae. A quaerat animiSit vitae eos aliquid eligendi est ducimus quod. Aut corrupti nemo qui doloremque enimUt asperiores.</p><p><br></p><p> </p><p>Qui sunt sint <strong>Qui saepe At rerum nemo</strong>. Eos omnis voluptasUt consequatur ab pariatur animi ut tenetur nobis. Nam odit animi ut nostrum facilisnon voluptas sit incidunt impedit et dolorem consequatur.</p><p><br></p><p> </p><p>Sed dolorem culpaAut obcaecati et blanditiis deleniti et eveniet facere! Et incidunt molestiae vel blanditiis consequunturut error. </p>', 2299.00, 3000.00, 'SKU-4635', 'xs,s,m,l,xl', 10, 14, 1, '0', '1', '1', '2025-05-15 01:12:38', '2025-05-30 01:10:00'),
(28, 'Demo Product 21', NULL, 0, 'demo-product-21', '<p><span style=\"color: rgb(33, 37, 41); font-family: system-ui, -apple-system, \"Segoe UI\", Roboto, \"Helvetica Neue\", Arial, \"Noto Sans\", \"Liberation Sans\", sans-serif, \"Apple Color Emoji\", \"Segoe UI Emoji\", \"Segoe UI Symbol\", \"Noto Color Emoji\"; font-size: 16px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;\">Lorem ipsum dolor sit amet. Et dignissimos dignissimos aut eveniet nesciunt aut tempora dolores. Quo perspiciatis optio est fugiat repudiandae eum minima accusantium qui laborum maiores sed veritatis nostrum nam fugit temporibus aut doloremque quia. Sit nulla tempore ut sapiente aspernatur ut expedita magni hic voluptatem blanditiis et sapiente voluptatem.</span></p>', '<p>Lorem ipsum dolor sit amet. Et quisquam omniseum harum non suscipit molestiae. Eos dolores reiciendis qui maxime internos <em>Aut ducimus ea consequatur esse</em> non magni sunt ut nihil maiores ut odio fugiat. Sed Quis aspernatur <strong>Est rerum est reiciendis internos</strong>. Est corrupti animiEt reprehenderit ea laborum necessitatibus sed suscipit animi. </p><p>Ea repellat totam et porro velitid velit ex maxime enim non quae aliquid. Ut omnis laudantium aut aliquid magnamEt alias et rerum quidem non assumenda saepe et odio asperiores et nemo incidunt! Qui amet sunt <strong>Et molestiae id quisquam quia nam rerum ullam qui eligendi tempora</strong> et odio iste cum consequatur velit. Et aspernatur enim et similique consequaturA quidem ut soluta voluptates est animi optio qui odit nobis. </p><dl><dt><dfn>Et quaerat deserunt? </dfn></dt><dd>Quo provident dolor aut explicabo rerum sit neque eius qui tempora consequatur. </dd><dt><dfn>Et natus impedit qui suscipit galisum. </dfn></dt><dd>At fugiat sunt ut officia ipsa sit minus voluptatem. </dd><dt><dfn>Aut quia magni. </dfn></dt><dd>Ab odio fugit aut inventore eveniet sed quia repellendus qui eius repudiandae? </dd></dl><p>Ut autem voluptates et quibusdam galisum <strong>Et consequatur sed obcaecati vitae qui Quis nisi sit nemo odio</strong> ut nulla enim. Sit earum corruptiEt soluta est soluta voluptatem ea minus nihil 33 optio eligendi qui molestiae nisi. </p><p>Est facere officia sed eveniet dictaEt velit quo consequatur obcaecati ad rerum cumque vel omnis officia. Aut aliquid eaque eum quis tenetursed autem. </p>', 849.00, 1349.00, 'SKU-9438', 's,m,l,xl,xxl', 11, 1, 2, '0', '1', '1', '2025-05-30 00:56:55', '2025-05-30 01:07:52');

-- --------------------------------------------------------

--
-- Table structure for table `product_gallery_images`
--

CREATE TABLE `product_gallery_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_gallery_images`
--

INSERT INTO `product_gallery_images` (`id`, `name`, `product_id`, `created_at`, `updated_at`) VALUES
(91, '20250512102311_143.jpg', 9, '2025-05-12 04:53:11', '2025-05-12 04:53:11'),
(92, '20250512102336_124.jpg', 8, '2025-05-12 04:53:36', '2025-05-12 04:53:36'),
(93, '20250512102336_535.jpg', 8, '2025-05-12 04:53:36', '2025-05-12 04:53:36'),
(94, '20250512102406_728.jpg', 7, '2025-05-12 04:54:06', '2025-05-12 04:54:06'),
(95, '20250512102406_978.jpg', 7, '2025-05-12 04:54:06', '2025-05-12 04:54:06'),
(96, '20250512102430_344.jpg', 6, '2025-05-12 04:54:30', '2025-05-12 04:54:30'),
(97, '20250512102454_868.jpg', 1, '2025-05-12 04:54:54', '2025-05-12 04:54:54'),
(98, '20250512102454_126.jpg', 1, '2025-05-12 04:54:54', '2025-05-12 04:54:54'),
(99, '20250512102454_209.jpg', 1, '2025-05-12 04:54:54', '2025-05-12 04:54:54'),
(100, '20250512102454_108.jpg', 1, '2025-05-12 04:54:55', '2025-05-12 04:54:55'),
(101, '20250512102748_959.jpg', 16, '2025-05-12 04:57:48', '2025-05-12 04:57:48'),
(102, '20250512102828_0.jpg', 15, '2025-05-12 04:58:28', '2025-05-12 04:58:28'),
(103, '20250512102828_644.jpg', 15, '2025-05-12 04:58:28', '2025-05-12 04:58:28'),
(104, '20250512102845_111.jpg', 14, '2025-05-12 04:58:45', '2025-05-12 04:58:45'),
(105, '20250512102903_695.jpg', 13, '2025-05-12 04:59:04', '2025-05-12 04:59:04'),
(106, '20250512102904_14.jpg', 13, '2025-05-12 04:59:04', '2025-05-12 04:59:04'),
(107, '20250512102919_522.jpg', 12, '2025-05-12 04:59:19', '2025-05-12 04:59:19'),
(108, '20250512102919_714.jpg', 12, '2025-05-12 04:59:19', '2025-05-12 04:59:19'),
(110, '20250512102942_173.jpg', 10, '2025-05-12 04:59:43', '2025-05-12 04:59:43'),
(111, '20250512105114_195.jpg', 17, '2025-05-12 05:21:14', '2025-05-12 05:21:14'),
(112, '20250512105114_278.jpg', 17, '2025-05-12 05:21:14', '2025-05-12 05:21:14'),
(113, '20250512105417_190.jpg', 18, '2025-05-12 05:24:17', '2025-05-12 05:24:17'),
(114, '20250512105417_868.jpg', 18, '2025-05-12 05:24:17', '2025-05-12 05:24:17'),
(115, '20250512110336_925.jpg', 19, '2025-05-12 05:33:36', '2025-05-12 05:33:36'),
(116, '20250512110519_147.jpg', 20, '2025-05-12 05:35:19', '2025-05-12 05:35:19'),
(117, '20250512110749_356.jpg', 21, '2025-05-12 05:37:49', '2025-05-12 05:37:49'),
(118, '20250513095454_46.jpg', 22, '2025-05-13 04:24:56', '2025-05-13 04:24:56');

-- --------------------------------------------------------

--
-- Table structure for table `product_ratings`
--

CREATE TABLE `product_ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `rating` double(2,1) NOT NULL,
  `comment` text DEFAULT NULL,
  `status` enum('1','0') NOT NULL COMMENT '''1'' => ''Active'', ''0'' => ''Inactive''',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_ratings`
--

INSERT INTO `product_ratings` (`id`, `product_id`, `user_id`, `rating`, `comment`, `status`, `created_at`, `updated_at`) VALUES
(1, 10, 2, 5.0, 'Good product.', '1', '2025-08-08 10:38:29', '2025-08-08 10:38:29'),
(2, 10, 3, 4.0, 'Quality seems good.', '1', '2025-08-08 11:19:02', '2025-08-08 11:19:02'),
(3, 15, 2, 5.0, NULL, '1', '2025-08-09 05:17:02', '2025-08-09 05:17:02');

-- --------------------------------------------------------

--
-- Table structure for table `slides`
--

CREATE TABLE `slides` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tagline` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1' COMMENT '''1'' => ''Active'', ''0'' => ''Inactive''',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `slides`
--

INSERT INTO `slides` (`id`, `tagline`, `title`, `subtitle`, `link`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'New Designs', 'Dresses', 'Women Collection', 'http://127.0.0.1:8000/shop', '20250807105527_98.png', '1', '2025-08-07 05:25:33', '2025-08-07 05:25:33'),
(2, 'Latest Collection', 'Simple', 'Casual Wears', 'http://127.0.0.1:8000/shop', '20250807105749_123.png', '1', '2025-08-07 05:27:52', '2025-08-07 05:27:52'),
(3, 'Premium Sets', 'Formal', 'Men Collection', 'http://127.0.0.1:8000/shop', '20250807105648_175.png', '1', '2025-08-07 05:26:53', '2025-08-07 05:26:53');

-- --------------------------------------------------------

--
-- Table structure for table `temp_images`
--

CREATE TABLE `temp_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `temp_images`
--

INSERT INTO `temp_images` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, '20250425102254_309.jpg', '2025-04-25 04:52:54', '2025-04-25 04:52:54'),
(2, '20250426045603_770.jpg', '2025-04-25 23:26:03', '2025-04-25 23:26:03'),
(3, '20250426050659_131.jpg', '2025-04-25 23:36:59', '2025-04-25 23:36:59'),
(4, '20250426075057_45.jpg', '2025-04-26 02:20:57', '2025-04-26 02:20:57'),
(5, '20250426075709_35.png', '2025-04-26 02:27:09', '2025-04-26 02:27:09'),
(6, '20250426081545_793.png', '2025-04-26 02:45:45', '2025-04-26 02:45:45'),
(7, '20250426082037_136.png', '2025-04-26 02:50:37', '2025-04-26 02:50:37'),
(8, '20250426082435_393.jpg', '2025-04-26 02:54:35', '2025-04-26 02:54:35'),
(9, '20250426082624_687.png', '2025-04-26 02:56:24', '2025-04-26 02:56:24'),
(10, '20250426082642_950.jpg', '2025-04-26 02:56:42', '2025-04-26 02:56:42'),
(11, '20250426083007_265.jpg', '2025-04-26 03:00:07', '2025-04-26 03:00:07'),
(12, '20250426083723_200.jpg', '2025-04-26 03:07:23', '2025-04-26 03:07:23'),
(13, '20250426083731_258.png', '2025-04-26 03:07:31', '2025-04-26 03:07:31'),
(14, '20250428101656_628.jpg', '2025-04-28 04:46:56', '2025-04-28 04:46:56'),
(15, '20250428101728_969.jpg', '2025-04-28 04:47:28', '2025-04-28 04:47:28'),
(16, '20250430081227_13.png', '2025-04-30 02:42:27', '2025-04-30 02:42:27'),
(17, '20250430082211_344.png', '2025-04-30 02:52:11', '2025-04-30 02:52:11'),
(18, '20250430082258_289.png', '2025-04-30 02:52:58', '2025-04-30 02:52:58'),
(19, '20250430093833_937.png', '2025-04-30 04:08:33', '2025-04-30 04:08:33'),
(20, '20250430103928_944.png', '2025-04-30 05:09:28', '2025-04-30 05:09:28'),
(21, '20250430104306_245.png', '2025-04-30 05:13:06', '2025-04-30 05:13:06'),
(22, '20250430104608_329.png', '2025-04-30 05:16:08', '2025-04-30 05:16:08'),
(23, '20250430105014_872.png', '2025-04-30 05:20:14', '2025-04-30 05:20:14'),
(24, '20250430105058_286.png', '2025-04-30 05:20:58', '2025-04-30 05:20:58'),
(25, '20250430105145_371.png', '2025-04-30 05:21:45', '2025-04-30 05:21:45'),
(26, '20250430105914_875.png', '2025-04-30 05:29:14', '2025-04-30 05:29:14'),
(27, '20250505081047_797.png', '2025-05-05 02:40:47', '2025-05-05 02:40:47'),
(28, '20250505081149_938.png', '2025-05-05 02:41:49', '2025-05-05 02:41:49'),
(29, '20250505081238_191.png', '2025-05-05 02:42:38', '2025-05-05 02:42:38'),
(30, '20250505081544_702.png', '2025-05-05 02:45:44', '2025-05-05 02:45:44'),
(31, '20250505131256_74.png', '2025-05-05 07:42:56', '2025-05-05 07:42:56'),
(32, '20250506053142_962.jpg', '2025-05-06 00:01:42', '2025-05-06 00:01:42'),
(33, '20250506053149_514.jpg', '2025-05-06 00:01:49', '2025-05-06 00:01:49'),
(34, '20250506053150_353.jpg', '2025-05-06 00:01:50', '2025-05-06 00:01:50'),
(35, '20250506053150_463.jpg', '2025-05-06 00:01:50', '2025-05-06 00:01:50'),
(36, '20250506053150_286.jpg', '2025-05-06 00:01:50', '2025-05-06 00:01:50'),
(37, '20250506054352_978.jpg', '2025-05-06 00:13:52', '2025-05-06 00:13:52'),
(38, '20250506054400_626.jpg', '2025-05-06 00:14:00', '2025-05-06 00:14:00'),
(39, '20250506054400_164.jpg', '2025-05-06 00:14:00', '2025-05-06 00:14:00'),
(40, '20250506054400_414.jpg', '2025-05-06 00:14:00', '2025-05-06 00:14:00'),
(41, '20250506054401_960.jpg', '2025-05-06 00:14:01', '2025-05-06 00:14:01'),
(42, '20250506055724_926.jpg', '2025-05-06 00:27:24', '2025-05-06 00:27:24'),
(43, '20250506055730_840.jpg', '2025-05-06 00:27:30', '2025-05-06 00:27:30'),
(44, '20250506055730_181.jpg', '2025-05-06 00:27:30', '2025-05-06 00:27:30'),
(45, '20250506055731_159.jpg', '2025-05-06 00:27:31', '2025-05-06 00:27:31'),
(46, '20250506055731_47.jpg', '2025-05-06 00:27:31', '2025-05-06 00:27:31'),
(47, '20250506095726_751.jpg', '2025-05-06 04:27:26', '2025-05-06 04:27:26'),
(48, '20250506095732_836.jpg', '2025-05-06 04:27:32', '2025-05-06 04:27:32'),
(49, '20250506095732_511.jpg', '2025-05-06 04:27:32', '2025-05-06 04:27:32'),
(50, '20250506095732_176.jpg', '2025-05-06 04:27:32', '2025-05-06 04:27:32'),
(51, '20250506095733_864.jpg', '2025-05-06 04:27:33', '2025-05-06 04:27:33'),
(52, '20250507064109_982.jpg', '2025-05-07 01:11:09', '2025-05-07 01:11:09'),
(53, '20250507064121_837.jpg', '2025-05-07 01:11:21', '2025-05-07 01:11:21'),
(54, '20250507064121_277.jpg', '2025-05-07 01:11:21', '2025-05-07 01:11:21'),
(55, '20250507064121_2.jpg', '2025-05-07 01:11:21', '2025-05-07 01:11:21'),
(56, '20250507064121_829.jpg', '2025-05-07 01:11:21', '2025-05-07 01:11:21'),
(57, '20250507064121_270.jpg', '2025-05-07 01:11:21', '2025-05-07 01:11:21'),
(58, '20250507064122_945.jpg', '2025-05-07 01:11:22', '2025-05-07 01:11:22'),
(59, '20250507064134_252.jpg', '2025-05-07 01:11:34', '2025-05-07 01:11:34'),
(60, '20250507064134_272.jpg', '2025-05-07 01:11:34', '2025-05-07 01:11:34'),
(61, '20250507073759_564.jpg', '2025-05-07 02:07:59', '2025-05-07 02:07:59'),
(62, '20250507073803_155.jpg', '2025-05-07 02:08:03', '2025-05-07 02:08:03'),
(63, '20250507073806_67.jpg', '2025-05-07 02:08:06', '2025-05-07 02:08:06'),
(64, '20250507081654_853.jpg', '2025-05-07 02:46:54', '2025-05-07 02:46:54'),
(65, '20250507082522_402.jpg', '2025-05-07 02:55:22', '2025-05-07 02:55:22'),
(66, '20250507082531_508.jpg', '2025-05-07 02:55:31', '2025-05-07 02:55:31'),
(67, '20250507082531_580.jpg', '2025-05-07 02:55:31', '2025-05-07 02:55:31'),
(68, '20250507082532_491.jpg', '2025-05-07 02:55:32', '2025-05-07 02:55:32'),
(69, '20250507082532_594.jpg', '2025-05-07 02:55:32', '2025-05-07 02:55:32'),
(70, '20250507082532_629.jpg', '2025-05-07 02:55:32', '2025-05-07 02:55:32'),
(71, '20250507082532_577.jpg', '2025-05-07 02:55:32', '2025-05-07 02:55:32'),
(72, '20250507082532_987.jpg', '2025-05-07 02:55:32', '2025-05-07 02:55:32'),
(73, '20250507091807_531.jpg', '2025-05-07 03:48:07', '2025-05-07 03:48:07'),
(74, '20250507092515_272.jpg', '2025-05-07 03:55:15', '2025-05-07 03:55:15'),
(75, '20250507092546_249.jpg', '2025-05-07 03:55:46', '2025-05-07 03:55:46'),
(76, '20250507101925_604.jpg', '2025-05-07 04:49:25', '2025-05-07 04:49:25'),
(77, '20250507101931_984.jpg', '2025-05-07 04:49:31', '2025-05-07 04:49:31'),
(78, '20250507101931_260.jpg', '2025-05-07 04:49:31', '2025-05-07 04:49:31'),
(79, '20250507102740_414.jpg', '2025-05-07 04:57:40', '2025-05-07 04:57:40'),
(80, '20250507102740_735.jpg', '2025-05-07 04:57:40', '2025-05-07 04:57:40'),
(81, '20250507102740_239.jpg', '2025-05-07 04:57:40', '2025-05-07 04:57:40'),
(82, '20250507102741_565.jpg', '2025-05-07 04:57:41', '2025-05-07 04:57:41'),
(83, '20250507102741_950.jpg', '2025-05-07 04:57:41', '2025-05-07 04:57:41'),
(84, '20250507102741_648.jpg', '2025-05-07 04:57:41', '2025-05-07 04:57:41'),
(85, '20250507103133_82.jpg', '2025-05-07 05:01:33', '2025-05-07 05:01:33'),
(86, '20250507103133_893.jpg', '2025-05-07 05:01:33', '2025-05-07 05:01:33'),
(87, '20250507103133_154.jpg', '2025-05-07 05:01:33', '2025-05-07 05:01:33'),
(88, '20250507103133_633.jpg', '2025-05-07 05:01:33', '2025-05-07 05:01:33'),
(89, '20250507103134_266.jpg', '2025-05-07 05:01:34', '2025-05-07 05:01:34'),
(90, '20250507103134_844.jpg', '2025-05-07 05:01:34', '2025-05-07 05:01:34'),
(91, '20250507103635_597.jpg', '2025-05-07 05:06:35', '2025-05-07 05:06:35'),
(92, '20250507103635_613.jpg', '2025-05-07 05:06:35', '2025-05-07 05:06:35'),
(93, '20250507103635_62.jpg', '2025-05-07 05:06:35', '2025-05-07 05:06:35'),
(94, '20250507104027_39.jpg', '2025-05-07 05:10:27', '2025-05-07 05:10:27'),
(95, '20250507104028_532.jpg', '2025-05-07 05:10:28', '2025-05-07 05:10:28'),
(96, '20250507104028_0.jpg', '2025-05-07 05:10:28', '2025-05-07 05:10:28'),
(97, '20250507104028_704.jpg', '2025-05-07 05:10:28', '2025-05-07 05:10:28'),
(98, '20250507104028_282.jpg', '2025-05-07 05:10:28', '2025-05-07 05:10:28'),
(99, '20250507104028_418.jpg', '2025-05-07 05:10:28', '2025-05-07 05:10:28'),
(100, '20250507104029_983.jpg', '2025-05-07 05:10:29', '2025-05-07 05:10:29'),
(101, '20250507105541_178.jpg', '2025-05-07 05:25:41', '2025-05-07 05:25:41'),
(102, '20250507105552_470.jpg', '2025-05-07 05:25:52', '2025-05-07 05:25:52'),
(103, '20250507105552_610.jpg', '2025-05-07 05:25:52', '2025-05-07 05:25:52'),
(104, '20250507105552_667.jpg', '2025-05-07 05:25:52', '2025-05-07 05:25:52'),
(105, '20250507105552_653.jpg', '2025-05-07 05:25:52', '2025-05-07 05:25:52'),
(106, '20250507105553_186.jpg', '2025-05-07 05:25:53', '2025-05-07 05:25:53'),
(107, '20250507105621_358.jpg', '2025-05-07 05:26:21', '2025-05-07 05:26:21'),
(108, '20250507110706_349.jpg', '2025-05-07 05:37:06', '2025-05-07 05:37:06'),
(109, '20250507110710_99.jpg', '2025-05-07 05:37:10', '2025-05-07 05:37:10'),
(110, '20250507110713_800.jpg', '2025-05-07 05:37:13', '2025-05-07 05:37:13'),
(111, '20250507110716_422.jpg', '2025-05-07 05:37:16', '2025-05-07 05:37:16'),
(112, '20250507110735_763.jpg', '2025-05-07 05:37:35', '2025-05-07 05:37:35'),
(113, '20250507110844_209.jpg', '2025-05-07 05:38:44', '2025-05-07 05:38:44'),
(114, '20250507111305_43.jpg', '2025-05-07 05:43:05', '2025-05-07 05:43:05'),
(115, '20250507111309_225.jpg', '2025-05-07 05:43:09', '2025-05-07 05:43:09'),
(116, '20250507111311_149.jpg', '2025-05-07 05:43:11', '2025-05-07 05:43:11'),
(117, '20250507111327_240.jpg', '2025-05-07 05:43:27', '2025-05-07 05:43:27'),
(118, '20250507111327_357.jpg', '2025-05-07 05:43:27', '2025-05-07 05:43:27'),
(119, '20250507111327_791.jpg', '2025-05-07 05:43:27', '2025-05-07 05:43:27'),
(120, '20250507111327_838.jpg', '2025-05-07 05:43:27', '2025-05-07 05:43:27'),
(121, '20250507111333_182.jpg', '2025-05-07 05:43:33', '2025-05-07 05:43:33'),
(122, '20250507111333_181.jpg', '2025-05-07 05:43:33', '2025-05-07 05:43:33'),
(123, '20250507111333_118.jpg', '2025-05-07 05:43:33', '2025-05-07 05:43:33'),
(124, '20250507111411_185.jpg', '2025-05-07 05:44:11', '2025-05-07 05:44:11'),
(125, '20250507111416_521.jpg', '2025-05-07 05:44:16', '2025-05-07 05:44:16'),
(126, '20250507111419_882.jpg', '2025-05-07 05:44:19', '2025-05-07 05:44:19'),
(127, '20250507111455_330.jpg', '2025-05-07 05:44:55', '2025-05-07 05:44:55'),
(128, '20250507111502_267.jpg', '2025-05-07 05:45:02', '2025-05-07 05:45:02'),
(129, '20250507111647_128.jpg', '2025-05-07 05:46:47', '2025-05-07 05:46:47'),
(130, '20250507111650_114.jpg', '2025-05-07 05:46:50', '2025-05-07 05:46:50'),
(131, '20250507111653_260.jpg', '2025-05-07 05:46:53', '2025-05-07 05:46:53'),
(132, '20250507115946_436.jpg', '2025-05-07 06:29:46', '2025-05-07 06:29:46'),
(133, '20250509113436_18.jpg', '2025-05-09 06:04:36', '2025-05-09 06:04:36'),
(134, '20250509113841_378.jpg', '2025-05-09 06:08:41', '2025-05-09 06:08:41'),
(135, '20250509113841_379.jpg', '2025-05-09 06:08:41', '2025-05-09 06:08:41'),
(136, '20250509113853_607.jpg', '2025-05-09 06:08:53', '2025-05-09 06:08:53'),
(137, '20250509114629_745.jpg', '2025-05-09 06:16:29', '2025-05-09 06:16:29'),
(138, '20250509114631_270.jpg', '2025-05-09 06:16:31', '2025-05-09 06:16:31'),
(139, '20250509114632_82.jpg', '2025-05-09 06:16:32', '2025-05-09 06:16:32'),
(140, '20250509114632_763.jpg', '2025-05-09 06:16:32', '2025-05-09 06:16:32'),
(141, '20250509114633_350.jpg', '2025-05-09 06:16:33', '2025-05-09 06:16:33'),
(142, '20250510052852_803.jpg', '2025-05-09 23:58:52', '2025-05-09 23:58:52'),
(143, '20250510052913_769.jpg', '2025-05-09 23:59:13', '2025-05-09 23:59:13'),
(144, '20250510052914_214.jpg', '2025-05-09 23:59:14', '2025-05-09 23:59:14'),
(145, '20250510052915_771.jpg', '2025-05-09 23:59:15', '2025-05-09 23:59:15'),
(146, '20250510052915_27.jpg', '2025-05-09 23:59:15', '2025-05-09 23:59:15'),
(147, '20250510074258_385.jpg', '2025-05-10 02:12:58', '2025-05-10 02:12:58'),
(148, '20250510074258_669.jpg', '2025-05-10 02:12:58', '2025-05-10 02:12:58'),
(149, '20250510074258_119.jpg', '2025-05-10 02:12:58', '2025-05-10 02:12:58'),
(150, '20250510075651_912.jpg', '2025-05-10 02:26:51', '2025-05-10 02:26:51'),
(151, '20250510075651_880.jpg', '2025-05-10 02:26:51', '2025-05-10 02:26:51'),
(152, '20250510075651_233.jpg', '2025-05-10 02:26:51', '2025-05-10 02:26:51'),
(153, '20250510081503_518.jpg', '2025-05-10 02:45:03', '2025-05-10 02:45:03'),
(154, '20250510081503_257.jpg', '2025-05-10 02:45:03', '2025-05-10 02:45:03'),
(155, '20250510081503_590.jpg', '2025-05-10 02:45:03', '2025-05-10 02:45:03'),
(156, '20250510083507_567.jpg', '2025-05-10 03:05:07', '2025-05-10 03:05:07'),
(157, '20250510083952_434.png', '2025-05-10 03:09:52', '2025-05-10 03:09:52'),
(158, '20250510084133_256.jpg', '2025-05-10 03:11:33', '2025-05-10 03:11:33'),
(159, '20250510084520_707.jpg', '2025-05-10 03:15:20', '2025-05-10 03:15:20'),
(160, '20250512073221_406.jpg', '2025-05-12 02:02:21', '2025-05-12 02:02:21'),
(161, '20250512073226_711.jpg', '2025-05-12 02:02:26', '2025-05-12 02:02:26'),
(162, '20250512073226_47.jpg', '2025-05-12 02:02:26', '2025-05-12 02:02:26'),
(163, '20250512074508_776.jpg', '2025-05-12 02:15:08', '2025-05-12 02:15:08'),
(164, '20250512074514_564.jpg', '2025-05-12 02:15:14', '2025-05-12 02:15:14'),
(165, '20250512074514_747.jpg', '2025-05-12 02:15:14', '2025-05-12 02:15:14'),
(166, '20250512075246_654.jpg', '2025-05-12 02:22:46', '2025-05-12 02:22:46'),
(167, '20250512075250_801.jpg', '2025-05-12 02:22:50', '2025-05-12 02:22:50'),
(168, '20250512075250_992.jpg', '2025-05-12 02:22:50', '2025-05-12 02:22:50'),
(169, '20250512075659_709.jpg', '2025-05-12 02:26:59', '2025-05-12 02:26:59'),
(170, '20250512075703_884.jpg', '2025-05-12 02:27:03', '2025-05-12 02:27:03'),
(171, '20250512075703_642.jpg', '2025-05-12 02:27:03', '2025-05-12 02:27:03'),
(172, '20250512080831_890.jpg', '2025-05-12 02:38:31', '2025-05-12 02:38:31'),
(173, '20250512080835_979.jpg', '2025-05-12 02:38:35', '2025-05-12 02:38:35'),
(174, '20250512081720_133.jpg', '2025-05-12 02:47:20', '2025-05-12 02:47:20'),
(175, '20250512081943_543.png', '2025-05-12 02:49:43', '2025-05-12 02:49:43'),
(176, '20250512082138_12.jpg', '2025-05-12 02:51:38', '2025-05-12 02:51:38'),
(177, '20250512082532_847.jpg', '2025-05-12 02:55:32', '2025-05-12 02:55:32'),
(178, '20250512082538_580.jpg', '2025-05-12 02:55:38', '2025-05-12 02:55:38'),
(179, '20250512091502_516.png', '2025-05-12 03:45:02', '2025-05-12 03:45:02'),
(180, '20250512091657_463.jpg', '2025-05-12 03:46:57', '2025-05-12 03:46:57'),
(181, '20250512091704_317.jpg', '2025-05-12 03:47:04', '2025-05-12 03:47:04'),
(182, '20250512091704_28.jpg', '2025-05-12 03:47:04', '2025-05-12 03:47:04'),
(183, '20250512094219_38.jpg', '2025-05-12 04:12:19', '2025-05-12 04:12:19'),
(184, '20250512094241_611.jpg', '2025-05-12 04:12:41', '2025-05-12 04:12:41'),
(185, '20250512094241_86.jpg', '2025-05-12 04:12:41', '2025-05-12 04:12:41'),
(186, '20250512094700_808.jpg', '2025-05-12 04:17:00', '2025-05-12 04:17:00'),
(187, '20250512094706_194.jpg', '2025-05-12 04:17:06', '2025-05-12 04:17:06'),
(188, '20250512095620_655.png', '2025-05-12 04:26:20', '2025-05-12 04:26:20'),
(189, '20250512095644_122.jpg', '2025-05-12 04:26:44', '2025-05-12 04:26:44'),
(190, '20250512095831_720.jpg', '2025-05-12 04:28:31', '2025-05-12 04:28:31'),
(191, '20250512095831_372.jpg', '2025-05-12 04:28:31', '2025-05-12 04:28:31'),
(192, '20250512095946_349.jpg', '2025-05-12 04:29:46', '2025-05-12 04:29:46'),
(193, '20250512100041_435.jpg', '2025-05-12 04:30:41', '2025-05-12 04:30:41'),
(194, '20250512101921_125.jpg', '2025-05-12 04:49:21', '2025-05-12 04:49:21'),
(195, '20250512102020_58.jpg', '2025-05-12 04:50:20', '2025-05-12 04:50:20'),
(196, '20250512102049_790.jpg', '2025-05-12 04:50:49', '2025-05-12 04:50:49'),
(197, '20250512102049_85.jpg', '2025-05-12 04:50:49', '2025-05-12 04:50:49'),
(198, '20250512102113_369.jpg', '2025-05-12 04:51:13', '2025-05-12 04:51:13'),
(199, '20250512102137_927.jpg', '2025-05-12 04:51:37', '2025-05-12 04:51:37'),
(200, '20250512102137_807.jpg', '2025-05-12 04:51:37', '2025-05-12 04:51:37'),
(201, '20250512102157_723.jpg', '2025-05-12 04:51:57', '2025-05-12 04:51:57'),
(202, '20250512102157_149.jpg', '2025-05-12 04:51:57', '2025-05-12 04:51:57'),
(203, '20250512102209_603.jpg', '2025-05-12 04:52:09', '2025-05-12 04:52:09'),
(204, '20250512102219_274.jpg', '2025-05-12 04:52:19', '2025-05-12 04:52:19'),
(205, '20250512102310_767.jpg', '2025-05-12 04:53:10', '2025-05-12 04:53:10'),
(206, '20250512102335_43.jpg', '2025-05-12 04:53:35', '2025-05-12 04:53:35'),
(207, '20250512102335_1.jpg', '2025-05-12 04:53:35', '2025-05-12 04:53:35'),
(208, '20250512102405_728.jpg', '2025-05-12 04:54:05', '2025-05-12 04:54:05'),
(209, '20250512102405_936.jpg', '2025-05-12 04:54:05', '2025-05-12 04:54:05'),
(210, '20250512102429_729.jpg', '2025-05-12 04:54:29', '2025-05-12 04:54:29'),
(211, '20250512102453_456.jpg', '2025-05-12 04:54:53', '2025-05-12 04:54:53'),
(212, '20250512102453_957.jpg', '2025-05-12 04:54:53', '2025-05-12 04:54:53'),
(213, '20250512102453_326.jpg', '2025-05-12 04:54:53', '2025-05-12 04:54:53'),
(214, '20250512102453_771.jpg', '2025-05-12 04:54:53', '2025-05-12 04:54:53'),
(215, '20250512102747_967.jpg', '2025-05-12 04:57:47', '2025-05-12 04:57:47'),
(216, '20250512102826_488.jpg', '2025-05-12 04:58:26', '2025-05-12 04:58:26'),
(217, '20250512102826_290.jpg', '2025-05-12 04:58:26', '2025-05-12 04:58:26'),
(218, '20250512102843_878.jpg', '2025-05-12 04:58:43', '2025-05-12 04:58:43'),
(219, '20250512102903_634.jpg', '2025-05-12 04:59:03', '2025-05-12 04:59:03'),
(220, '20250512102903_407.jpg', '2025-05-12 04:59:03', '2025-05-12 04:59:03'),
(221, '20250512102918_737.jpg', '2025-05-12 04:59:18', '2025-05-12 04:59:18'),
(222, '20250512102918_279.jpg', '2025-05-12 04:59:18', '2025-05-12 04:59:18'),
(223, '20250512102931_249.jpg', '2025-05-12 04:59:31', '2025-05-12 04:59:31'),
(224, '20250512102942_299.jpg', '2025-05-12 04:59:42', '2025-05-12 04:59:42'),
(225, '20250512103945_487.jpg', '2025-05-12 05:09:45', '2025-05-12 05:09:45'),
(226, '20250512104004_517.jpg', '2025-05-12 05:10:04', '2025-05-12 05:10:04'),
(227, '20250512104013_455.jpg', '2025-05-12 05:10:13', '2025-05-12 05:10:13'),
(228, '20250512104023_620.jpg', '2025-05-12 05:10:23', '2025-05-12 05:10:23'),
(229, '20250512104035_642.jpg', '2025-05-12 05:10:35', '2025-05-12 05:10:35'),
(230, '20250512104044_517.jpg', '2025-05-12 05:10:44', '2025-05-12 05:10:44'),
(231, '20250512104053_336.jpg', '2025-05-12 05:10:53', '2025-05-12 05:10:53'),
(232, '20250512104106_624.jpg', '2025-05-12 05:11:06', '2025-05-12 05:11:06'),
(233, '20250512104118_619.jpg', '2025-05-12 05:11:18', '2025-05-12 05:11:18'),
(234, '20250512104316_595.jpg', '2025-05-12 05:13:16', '2025-05-12 05:13:16'),
(235, '20250512104335_602.jpg', '2025-05-12 05:13:35', '2025-05-12 05:13:35'),
(236, '20250512104352_366.jpg', '2025-05-12 05:13:52', '2025-05-12 05:13:52'),
(237, '20250512104552_104.jpg', '2025-05-12 05:15:52', '2025-05-12 05:15:52'),
(238, '20250512104725_924.jpg', '2025-05-12 05:17:25', '2025-05-12 05:17:25'),
(239, '20250512104825_523.jpg', '2025-05-12 05:18:25', '2025-05-12 05:18:25'),
(240, '20250512104930_206.jpg', '2025-05-12 05:19:30', '2025-05-12 05:19:30'),
(241, '20250512105111_344.jpg', '2025-05-12 05:21:11', '2025-05-12 05:21:11'),
(242, '20250512105111_893.jpg', '2025-05-12 05:21:11', '2025-05-12 05:21:11'),
(243, '20250512105242_786.jpg', '2025-05-12 05:22:42', '2025-05-12 05:22:42'),
(244, '20250512105246_469.jpg', '2025-05-12 05:22:46', '2025-05-12 05:22:46'),
(245, '20250512105246_108.jpg', '2025-05-12 05:22:46', '2025-05-12 05:22:46'),
(246, '20250512110201_620.jpg', '2025-05-12 05:32:01', '2025-05-12 05:32:01'),
(247, '20250512110205_667.jpg', '2025-05-12 05:32:05', '2025-05-12 05:32:05'),
(248, '20250512110402_116.jpg', '2025-05-12 05:34:02', '2025-05-12 05:34:02'),
(249, '20250512110406_906.jpg', '2025-05-12 05:34:06', '2025-05-12 05:34:06'),
(250, '20250512110600_146.jpg', '2025-05-12 05:36:00', '2025-05-12 05:36:00'),
(251, '20250512110604_27.jpg', '2025-05-12 05:36:04', '2025-05-12 05:36:04'),
(252, '20250512110744_233.jpg', '2025-05-12 05:37:44', '2025-05-12 05:37:44'),
(253, '20250512110747_82.jpg', '2025-05-12 05:37:47', '2025-05-12 05:37:47'),
(254, '20250512110829_226.jpg', '2025-05-12 05:38:29', '2025-05-12 05:38:29'),
(255, '20250513095452_441.jpg', '2025-05-13 04:24:52', '2025-05-13 04:24:52'),
(256, '20250515052609_870.png', '2025-05-14 23:56:09', '2025-05-14 23:56:09'),
(257, '20250610044529_627.jpg', '2025-06-09 23:15:29', '2025-06-09 23:15:29'),
(258, '20250610053207_305.png', '2025-06-10 00:02:07', '2025-06-10 00:02:07'),
(259, '20250807104011_852.png', '2025-08-07 05:10:11', '2025-08-07 05:10:11'),
(260, '20250807104112_557.png', '2025-08-07 05:11:12', '2025-08-07 05:11:12'),
(261, '20250807105527_98.png', '2025-08-07 05:25:27', '2025-08-07 05:25:27'),
(262, '20250807105648_175.png', '2025-08-07 05:26:48', '2025-08-07 05:26:48'),
(263, '20250807105749_123.png', '2025-08-07 05:27:49', '2025-08-07 05:27:49');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `mode` enum('COD','PP') NOT NULL COMMENT '''COD'' => ''Cash On Delivery'', ''PP'' => ''PhonePe''',
  `status` enum('PEND','APP','DEC','REF') NOT NULL DEFAULT 'PEND' COMMENT '''PEND'' => ''Pending'', ''APP'' => ''Approved'', ''DEC'' => ''Declined'', ''REF'' => ''Refunded''',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `order_id`, `mode`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'COD', 'APP', '2025-07-22 05:17:42', '2025-07-22 05:17:42'),
(2, 2, 2, 'COD', 'DEC', '2025-07-22 06:29:22', '2025-07-22 06:29:22'),
(3, 3, 3, 'COD', 'APP', '2025-08-08 05:47:22', '2025-08-08 05:47:22'),
(4, 2, 4, 'COD', 'PEND', '2025-08-17 07:34:02', '2025-08-17 07:34:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` enum('M','F','O') NOT NULL COMMENT '''M'' => ''Male'', ''F'' => ''Female'', ''O'' => ''Others''',
  `phonecode` varchar(7) DEFAULT NULL,
  `mobile` varchar(10) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `role` enum('A','U') NOT NULL DEFAULT 'U' COMMENT '''A'' => ''Admin'', ''U'' => ''User''',
  `status` enum('1','0') NOT NULL DEFAULT '1' COMMENT '''1'' => ''Active'', ''0'' => ''Inactive''',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `gender`, `phonecode`, `mobile`, `email`, `email_verified_at`, `password`, `remember_token`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'S. Mali', 'M', '+91', '9955911122', 'admin@gmail.com', NULL, '$2y$12$c8Fp0zGyAV9.jO/YJPqFQu5ktW8G8uQZLWI41Vd6BN2n.rbIStaOy', NULL, 'A', '1', '2025-04-17 07:23:32', '2025-08-12 06:04:33'),
(2, 'K. Mali', 'M', '+91', '7755335555', 'km@gmail.com', NULL, '$2y$12$2gkk.tu7mFXWismN/rYYE.oTmgDC748Wh38hBl2kZ0XS/YwxRzkt.', NULL, 'U', '1', '2025-04-17 07:47:33', '2025-08-11 08:21:17'),
(3, 'R. Mali', 'F', '+91', '8844662255', 'rm@gmail.com', NULL, '$2y$12$/TTt6T87GcAJU4oNcybfR.WwSOGmnroGkzJEM3CJHgOZrm284fkiW', NULL, 'U', '1', '2025-04-17 23:33:39', '2025-04-17 23:33:39'),
(4, 'Test', 'M', '+91', '1234554321', 'test@gmail.com', NULL, '$2y$12$IUTTS5y4lO7QAgWDHP8F9ec652yCnd286cg5pNWOF/Ibl5v6Jkgpa', NULL, 'U', '0', '2025-08-07 06:31:49', '2025-08-07 09:58:03');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `product_id`, `user_id`, `created_at`, `updated_at`) VALUES
(5, 6, 2, '2025-06-06 04:37:51', '2025-06-06 04:37:51'),
(9, 19, 2, '2025-06-06 04:38:18', '2025-06-06 04:38:18'),
(10, 28, 2, '2025-06-06 04:38:27', '2025-06-06 04:38:27'),
(12, 17, 2, '2025-06-06 04:42:46', '2025-06-06 04:42:46'),
(13, 1, 2, '2025-06-07 03:05:09', '2025-06-07 03:05:09'),
(14, 15, 2, '2025-06-07 03:05:15', '2025-06-07 03:05:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addon_cart`
--
ALTER TABLE `addon_cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addon_product_id` (`addon_product_id`),
  ADD KEY `cart_id` (`cart_id`);

--
-- Indexes for table `addon_products`
--
ALTER TABLE `addon_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addons_ibfk_1` (`category_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `delivery_method_id` (`delivery_method_id`),
  ADD KEY `delivery_timeslot_id` (`delivery_timeslot_id`),
  ADD KEY `coupon_id` (`coupon_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_methods`
--
ALTER TABLE `delivery_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_timeslots`
--
ALTER TABLE `delivery_timeslots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_method_id` (`delivery_method_id`);

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
-- Indexes for table `months`
--
ALTER TABLE `months`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_ibfk_1` (`user_id`),
  ADD KEY `orders_ibfk_2` (`coupon_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `cart_id` (`cart_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_gallery_images`
--
ALTER TABLE `product_gallery_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_ratings`
--
ALTER TABLE `product_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_ratings_ibfk_1` (`product_id`),
  ADD KEY `product_ratings_ibfk_2` (`user_id`);

--
-- Indexes for table `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_images`
--
ALTER TABLE `temp_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addon_cart`
--
ALTER TABLE `addon_cart`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `addon_products`
--
ALTER TABLE `addon_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `delivery_methods`
--
ALTER TABLE `delivery_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `delivery_timeslots`
--
ALTER TABLE `delivery_timeslots`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `months`
--
ALTER TABLE `months`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `product_gallery_images`
--
ALTER TABLE `product_gallery_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `product_ratings`
--
ALTER TABLE `product_ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `slides`
--
ALTER TABLE `slides`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `temp_images`
--
ALTER TABLE `temp_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=264;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addon_cart`
--
ALTER TABLE `addon_cart`
  ADD CONSTRAINT `addon_cart_ibfk_1` FOREIGN KEY (`addon_product_id`) REFERENCES `addon_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `addon_cart_ibfk_2` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `addon_products`
--
ALTER TABLE `addon_products`
  ADD CONSTRAINT `addon_products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `addon_products_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`delivery_method_id`) REFERENCES `delivery_methods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_3` FOREIGN KEY (`delivery_timeslot_id`) REFERENCES `delivery_timeslots` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_4` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `delivery_timeslots`
--
ALTER TABLE `delivery_timeslots`
  ADD CONSTRAINT `delivery_timeslots_ibfk_1` FOREIGN KEY (`delivery_method_id`) REFERENCES `delivery_methods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_5` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_gallery_images`
--
ALTER TABLE `product_gallery_images`
  ADD CONSTRAINT `product_gallery_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_ratings`
--
ALTER TABLE `product_ratings`
  ADD CONSTRAINT `product_ratings_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ratings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wishlists_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
