-- ============================================
-- NextCafe E-Commerce - Complete Database Schema
-- For phpMyAdmin Import
-- Generated on 2026-03-11
-- ============================================
-- 
-- INSTRUCTIONS:
-- 1. Open phpMyAdmin
-- 2. Create a new database called "nextcafe_ecomms"
-- 3. Select the database
-- 4. Go to the "Import" tab
-- 5. Choose this file and click "Go"
-- ============================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ============================================
-- DATABASE
-- ============================================
CREATE DATABASE IF NOT EXISTS `nextcafe_ecomms`
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_general_ci;

USE `nextcafe_ecomms`;

-- ============================================
-- Table: users
-- ============================================
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT 'default.png',
  `bio` text DEFAULT NULL,
  `role` enum('admin','customer') DEFAULT 'customer',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- Table: categories
-- ============================================
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- Table: products
-- ============================================
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(100) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `status` enum('available','unavailable') DEFAULT 'available',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- Table: orders
-- ============================================
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','completed','cancelled') DEFAULT 'pending',
  `shipping_method` varchar(50) DEFAULT 'Delivery',
  `payment_method` varchar(50) DEFAULT 'COD',
  `address` text DEFAULT NULL,
  `tracking_number` varchar(100) DEFAULT NULL,
  `courier` varchar(50) DEFAULT NULL,
  `estimated_delivery` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_orders_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- Table: order_items
-- ============================================
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_order_items_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_order_items_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- Table: reviews
-- ============================================
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `rating` tinyint(1) NOT NULL CHECK (`rating` >= 1 AND `rating` <= 5),
  `review_text` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_product_id` (`product_id`),
  KEY `idx_user_id` (`user_id`),
  CONSTRAINT `fk_reviews_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_reviews_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- Table: wishlist
-- ============================================
CREATE TABLE IF NOT EXISTS `wishlist` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_product` (`user_id`, `product_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_product_id` (`product_id`),
  CONSTRAINT `fk_wishlist_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_wishlist_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- Default Data: Users
-- ============================================
-- Default password for both users is: "password"
INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `picture`, `bio`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'default.png', 'I am the administrator.', 'admin', 'active', NOW(), NOW()),
(2, 'John Doe', 'johndoe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'default.png', 'Regular user.', 'customer', 'active', NOW(), NOW());

-- ============================================
-- Default Data: Categories
-- ============================================
INSERT INTO `categories` (`name`, `slug`, `status`, `created_at`, `updated_at`) VALUES
('Espresso', 'espresso', 'active', NOW(), NOW()),
('Milk Based', 'milk-based', 'active', NOW(), NOW()),
('Cold Brew', 'cold-brew', 'active', NOW(), NOW()),
('Pastries', 'pastries', 'active', NOW(), NOW()),
('Frappe', 'frappe', 'active', NOW(), NOW());

-- ============================================
-- Default Data: Products
-- ============================================
INSERT INTO `products` (`product_name`, `slug`, `description`, `price`, `category`, `image_url`, `status`, `created_at`, `updated_at`) VALUES
-- Cold Brew
('Classic Cold Brew', 'classic-cold-brew', 'Smooth and bold cold-brewed coffee steeped for 24 hours for a naturally sweet, low-acid flavor.', 130.00, 'Cold Brew', 'images/classic_cold_brew.png', 'available', NOW(), NOW()),
('Nitro Cold Brew', 'nitro-cold-brew', 'Cold brew infused with nitrogen for a creamy, velvety texture and cascading bubbles.', 160.00, 'Cold Brew', 'images/nitro_cold_brew.png', 'available', NOW(), NOW()),
('Vanilla Sweet Cream Cold Brew', 'vanilla-sweet-cream-cold-brew', 'Cold brew topped with a silky vanilla sweet cream, perfectly balanced.', 175.00, 'Cold Brew', 'images/vanilla_sweet_cream_cold_brew.png', 'available', NOW(), NOW()),
('Brown Sugar Cold Brew', 'brown-sugar-cold-brew', 'Our classic cold brew sweetened with rich brown sugar syrup and a splash of oat milk.', 165.00, 'Cold Brew', 'images/brown_sugar_cold_brew.png', 'available', NOW(), NOW()),
('Iced Americano', 'iced-americano', 'Espresso shots topped with cold water and ice for a clean, crisp coffee experience.', 110.00, 'Cold Brew', 'images/iced_americano_new.png', 'available', NOW(), NOW()),
-- Espresso
('Classic Espresso', 'classic-espresso', 'Rich and intense single shot of pure espresso, the foundation of all great coffee.', 90.00, 'Espresso', 'images/classic_espresso.jpg', 'available', NOW(), NOW()),
('Double Espresso', 'double-espresso', 'A concentrated double shot for extra energy and a deeper, bolder flavor.', 120.00, 'Espresso', 'images/double_espresso.jpg', 'available', NOW(), NOW()),
('Ristretto', 'ristretto', 'A shorter, more concentrated espresso pull — sweeter and less bitter than a standard shot.', 100.00, 'Espresso', 'images/ristretto.jpg', 'available', NOW(), NOW()),
('Macchiato', 'macchiato', 'A bold espresso shot stained with a dollop of velvety steamed milk foam.', 115.00, 'Espresso', 'images/macchiato.jpg', 'available', NOW(), NOW()),
('Americano', 'americano', 'Espresso diluted with hot water for a smooth, full-bodied coffee experience.', 105.00, 'Espresso', 'images/americano_hot.jpg', 'available', NOW(), NOW()),
-- Milk Based
('Cappuccino', 'cappuccino', 'Classic espresso with an equal ratio of steamed milk and rich, airy foam.', 140.00, 'Milk Based', 'images/cappuccino.jpg', 'available', NOW(), NOW()),
('Caramel Latte', 'caramel-latte', 'Smooth espresso mixed with caramel syrup, steamed milk, and whipped cream.', 155.00, 'Milk Based', 'images/caramel_latte.png', 'available', NOW(), NOW()),
('Flat White', 'flat-white', 'A velvety flat white with silky micro-foam poured over a ristretto shot.', 145.00, 'Milk Based', 'images/cappuccino.jpg', 'available', NOW(), NOW()),
('Matcha Latte', 'matcha-latte', 'Premium ceremonial-grade matcha whisked with steamed oat milk. Earthy, creamy, and perfectly balanced.', 165.00, 'Milk Based', 'images/caramel_latte.png', 'available', NOW(), NOW()),
('Hot Chocolate', 'hot-chocolate', 'Rich, velvety Belgian chocolate blended with steamed milk for the ultimate comfort drink.', 135.00, 'Milk Based', 'images/cappuccino.jpg', 'available', NOW(), NOW()),
-- Pastries
('Blueberry Muffin', 'blueberry-muffin', 'Freshly baked golden muffin bursting with real blueberries. Soft inside, gently crisp on top.', 85.00, 'Pastries', 'images/blueberrymuffin.jpg', 'available', NOW(), NOW()),
('Butter Croissant', 'butter-croissant', 'Golden, flaky, made-from-scratch croissant with layers of pure butter. A Parisian classic.', 95.00, 'Pastries', 'images/blueberrymuffin.jpg', 'available', NOW(), NOW()),
('Chocolate Muffin', 'chocolate-muffin', 'Decadent dark chocolate muffin loaded with chocolate chips. A chocolate lovers dream.', 90.00, 'Pastries', 'images/blueberrymuffin.jpg', 'available', NOW(), NOW()),
('Cinnamon Roll', 'cinnamon-roll', 'Pillowy-soft roll swirled with cinnamon sugar and topped with a creamy vanilla glaze.', 105.00, 'Pastries', 'images/blueberrymuffin.jpg', 'available', NOW(), NOW()),
('Banana Bread', 'banana-bread', 'moist, dense banana bread made with ripe bananas, walnuts, and a hint of vanilla.', 80.00, 'Pastries', 'images/blueberrymuffin.jpg', 'available', NOW(), NOW()),
-- Frappe
('Classic Coffee Frappe', 'classic-coffee-frappe', 'Rich blended espresso with milk and ice, topped with whipped cream. The ultimate frozen coffee treat.', 155.00, 'Frappe', 'images/classiccofeefrappe.jpg', 'available', NOW(), NOW()),
('Caramel Frappe', 'caramel-frappe', 'A dreamy blend of espresso, caramel syrup, milk, and ice finished with caramel drizzle and whipped cream.', 170.00, 'Frappe', 'images/caramelfrappe.jpg', 'available', NOW(), NOW()),
('Mocha Frappe', 'mocha-frappe', 'Espresso blended with rich chocolate sauce, milk, and ice — topped with chocolate drizzle and cream.', 175.00, 'Frappe', 'images/mochafrappe.webp', 'available', NOW(), NOW()),
('Matcha Frappe', 'matcha-frappe', 'Premium matcha blended with milk and ice for a refreshing, earthy, and creamy frozen drink.', 175.00, 'Frappe', 'images/matchafrappe.jpg', 'available', NOW(), NOW()),
('Vanilla Frappe', 'vanilla-frappe', 'A smooth, creamy vanilla frappe made with real vanilla bean, blended with milk and ice.', 160.00, 'Frappe', 'images/vanillafrappe.jpg', 'available', NOW(), NOW());

SET FOREIGN_KEY_CHECKS = 1;
