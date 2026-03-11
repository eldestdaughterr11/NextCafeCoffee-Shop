-- ============================================
-- SQL Update for Coffee Product Images
-- Generated on 2026-03-11
-- ============================================

-- Use the correct database
USE `nextcafe_ecomms`;

-- Update image URLs for specific products to match the files in public/images
UPDATE products SET image_url = 'images/hotchocolate.jpg' WHERE product_name = 'Hot Chocolate';
UPDATE products SET image_url = 'images/matchalatte.jpg' WHERE product_name = 'Matcha Latte';
UPDATE products SET image_url = 'images/flatwhite.jpg' WHERE product_name = 'Flat White';
UPDATE products SET image_url = 'images/caramellatte.jpg' WHERE product_name = 'Caramel Latte';
UPDATE products SET image_url = 'images/cappuccino.jpg' WHERE product_name = 'Cappuccino';

-- To verify the changes, run:
-- SELECT product_name, image_url FROM products WHERE product_name IN ('Hot Chocolate', 'Matcha Latte', 'Flat White', 'Caramel Latte', 'Cappuccino');
