-- ============================================
-- Update Frappe Images - Fix image paths for Frappe products
-- Run this in phpMyAdmin to fix existing products
-- ============================================

-- Ensure Frappe category exists
INSERT IGNORE INTO `categories` (`name`, `slug`, `status`, `created_at`, `updated_at`) 
VALUES ('Frappe', 'frappe', 'active', NOW(), NOW());

-- Update or insert Frappe products with correct image paths
INSERT INTO `products` (`product_name`, `slug`, `description`, `price`, `category`, `image_url`, `status`, `created_at`, `updated_at`) 
VALUES 
('Classic Coffee Frappe', 'classic-coffee-frappe', 'Rich blended espresso with milk and ice, topped with whipped cream. The ultimate frozen coffee treat.', 155.00, 'Frappe', 'images/classiccofeefrappe.jpg', 'available', NOW(), NOW()),
('Caramel Frappe', 'caramel-frappe', 'A dreamy blend of espresso, caramel syrup, milk, and ice finished with caramel drizzle and whipped cream.', 170.00, 'Frappe', 'images/caramelfrappe.jpg', 'available', NOW(), NOW()),
('Mocha Frappe', 'mocha-frappe', 'Espresso blended with rich chocolate sauce, milk, and ice — topped with chocolate drizzle and cream.', 175.00, 'Frappe', 'images/mochafrappe.webp', 'available', NOW(), NOW()),
('Matcha Frappe', 'matcha-frappe', 'Premium matcha blended with milk and ice for a refreshing, earthy, and creamy frozen drink.', 175.00, 'Frappe', 'images/matchafrappe.jpg', 'available', NOW(), NOW()),
('Vanilla Frappe', 'vanilla-frappe', 'A smooth, creamy vanilla frappe made with real vanilla bean, blended with milk and ice.', 160.00, 'Frappe', 'images/vanillafrappe.jpg', 'available', NOW(), NOW())
ON DUPLICATE KEY UPDATE 
`image_url` = VALUES(`image_url`),
`category` = VALUES(`category`),
`updated_at` = NOW();
