-- ============================================
-- Migration: Create Categories Table
-- For phpMyAdmin
-- ============================================
-- 
-- NOTE: If you imported nextcafe_ecomms.sql (the complete schema),
--       you do NOT need to run this file separately.
--       This is only needed if you are upgrading an existing database.
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

-- ----------------------------
-- Default Categories
-- ----------------------------
INSERT INTO `categories` (`name`, `slug`, `status`, `created_at`, `updated_at`) VALUES
('Espresso', 'espresso', 'active', NOW(), NOW()),
('Milk Based', 'milk-based', 'active', NOW(), NOW()),
('Cold Brew', 'cold-brew', 'active', NOW(), NOW()),
('Pastries', 'pastries', 'active', NOW(), NOW());
