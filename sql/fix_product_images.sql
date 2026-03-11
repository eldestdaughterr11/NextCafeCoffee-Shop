-- ============================================
-- Fix Product Images - Update Cold Brew image paths
-- Run this in phpMyAdmin to fix existing products
-- ============================================

UPDATE `products` SET `image_url` = 'images/classic_cold_brew.png' WHERE `slug` = 'classic-cold-brew';
UPDATE `products` SET `image_url` = 'images/nitro_cold_brew.png' WHERE `slug` = 'nitro-cold-brew';
UPDATE `products` SET `image_url` = 'images/vanilla_sweet_cream_cold_brew.png' WHERE `slug` = 'vanilla-sweet-cream-cold-brew';
UPDATE `products` SET `image_url` = 'images/brown_sugar_cold_brew.png' WHERE `slug` = 'brown-sugar-cold-brew';
UPDATE `products` SET `image_url` = 'images/iced_americano_new.png' WHERE `slug` = 'iced-americano';

UPDATE `products` SET `image_url` = 'images/classic_espresso.jpg' WHERE `slug` = 'classic-espresso';
UPDATE `products` SET `image_url` = 'images/double_espresso.jpg' WHERE `slug` = 'double-espresso';
UPDATE `products` SET `image_url` = 'images/ristretto.jpg' WHERE `slug` = 'ristretto';
UPDATE `products` SET `image_url` = 'images/macchiato.jpg' WHERE `slug` = 'macchiato';
UPDATE `products` SET `image_url` = 'images/americano_hot.jpg' WHERE `slug` = 'americano';
UPDATE `products` SET `image_url` = 'images/classiccofeefrappe.jpg' WHERE `slug` = 'classic-coffee-frappe';
UPDATE `products` SET `image_url` = 'images/caramelfrappe.jpg' WHERE `slug` = 'caramel-frappe';
UPDATE `products` SET `image_url` = 'images/mochafrappe.webp' WHERE `slug` = 'mocha-frappe';
UPDATE `products` SET `image_url` = 'images/matchafrappe.jpg' WHERE `slug` = 'matcha-frappe';
UPDATE `products` SET `image_url` = 'images/vanillafrappe.jpg' WHERE `slug` = 'vanilla-frappe';
