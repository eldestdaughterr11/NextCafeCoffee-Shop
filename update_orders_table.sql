-- SQL command to add missing columns to the orders table
-- Run this in your MySQL client (e.g., phpMyAdmin, Workbench, or command line)

ALTER TABLE `orders`
ADD COLUMN `shipping_method` varchar(50) DEFAULT 'Delivery' AFTER `status`,
ADD COLUMN `payment_method` varchar(50) DEFAULT 'COD' AFTER `shipping_method`,
ADD COLUMN `address` text DEFAULT NULL AFTER `payment_method`;
