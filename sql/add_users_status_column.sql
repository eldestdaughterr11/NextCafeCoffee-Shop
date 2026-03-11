-- ============================================
-- Migration: Add Status Column to Users Table
-- For phpMyAdmin
-- ============================================
-- 
-- NOTE: If you imported nextcafe_ecomms.sql (the complete schema),
--       you do NOT need to run this file separately.
--       This is only needed if you are upgrading an existing database.
-- ============================================

ALTER TABLE `users`
ADD COLUMN `status` enum('active','inactive') DEFAULT 'active' AFTER `role`;
