-- NextCafe_eComms Database Schema
-- Generated on 2026-02-04

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for users
-- ----------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT 'default.png',
  `bio` text DEFAULT NULL,
  `role` enum('admin','customer') DEFAULT 'customer',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `picture`, `bio`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'default.png', 'I am the administrator.', 'admin', NOW(), NOW()),
(2, 'John Doe', 'johndoe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'default.png', 'Regular user.', 'customer', NOW(), NOW());

-- ----------------------------
-- Table structure for products
-- ----------------------------
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

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` (`product_name`, `slug`, `description`, `price`, `category`, `image_url`, `status`, `created_at`, `updated_at`) VALUES
('Classic Espresso', 'classic-espresso', 'Rich and intense shot of pure coffee.', 90.00, 'Espresso', 'images/espresso.jpg', 'available', NOW(), NOW()),
('Double Espresso', 'double-espresso', 'A concentrated double shot for extra energy.', 120.00, 'Espresso', 'images/espresso.jpg', 'available', NOW(), NOW()),
('Cappuccino', 'cappuccino', 'Espresso with steamed milk and a deep layer of foam.', 140.00, 'Milk Based', 'images/cappuccino.jpg', 'available', NOW(), NOW()),
('Caramel Latte', 'caramel-latte', 'Smooth espresso mixed with caramel syrup and steamed milk.', 155.00, 'Milk Based', 'images/latte.jpg', 'available', NOW(), NOW()),
('Iced Americano', 'iced-americano', 'Espresso shots topped with cold water and ice.', 110.00, 'Cold Brew', 'images/americano.jpg', 'available', NOW(), NOW()),
('Blueberry Muffin', 'blueberry-muffin', 'Freshly baked muffin with real blueberries.', 85.00, 'Pastries', 'images/blueberrymuffin.jpg', 'available', NOW(), NOW());

-- ----------------------------
-- Table structure for orders
-- ----------------------------
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','completed','cancelled') DEFAULT 'pending',
  `shipping_method` varchar(50) DEFAULT 'Delivery',
  `payment_method` varchar(50) DEFAULT 'COD',
  `address` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_orders_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for order_items
-- ----------------------------
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

SET FOREIGN_KEY_CHECKS = 1;
