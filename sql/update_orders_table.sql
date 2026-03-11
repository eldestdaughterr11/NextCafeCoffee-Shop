-- ============================================
-- Migration: Update Orders Table
-- Add shipping_method, payment_method, address columns
-- For phpMyAdmin
-- ============================================
-- 
-- NOTE: If you imported nextcafe_ecomms.sql (the complete schema),
--       you do NOT need to run this file separately.
--       This is only needed if you are upgrading an existing database.
-- ============================================

ALTER TABLE `orders`
ADD COLUMN `shipping_method` varchar(50) DEFAULT 'Delivery' AFTER `status`,
ADD COLUMN `payment_method` varchar(50) DEFAULT 'COD' AFTER `shipping_method`,
ADD COLUMN `address` text DEFAULT NULL AFTER `payment_method`;
