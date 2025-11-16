-- Migration: Add role management to CMS
-- Date: November 16, 2025
-- Description: Adds role column to admins table for role-based access control

-- Check if role column exists before adding it
SET @col_exists = 0;
SELECT COUNT(*) INTO @col_exists
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_SCHEMA = DATABASE()
  AND TABLE_NAME = 'admins'
  AND COLUMN_NAME = 'role';

-- Add role column to admins table only if it doesn't exist
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE `admins` ADD COLUMN `role` ENUM(''super_admin'', ''admin'', ''editor'', ''author'') NOT NULL DEFAULT ''author'' AFTER `password`',
    'SELECT "Column role already exists" AS message');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Update existing users (set first user as super_admin if role is still default)
UPDATE `admins` SET `role` = 'super_admin' WHERE `id` = 1 AND `role` = 'author';
UPDATE `admins` SET `role` = 'admin' WHERE `id` IN (2, 3, 4) AND `role` = 'author';
UPDATE `admins` SET `role` = 'editor' WHERE `id` IN (5, 6) AND `role` = 'author';

-- Add index for better performance if it doesn't exist
SET @index_exists = 0;
SELECT COUNT(*) INTO @index_exists
FROM INFORMATION_SCHEMA.STATISTICS
WHERE TABLE_SCHEMA = DATABASE()
  AND TABLE_NAME = 'admins'
  AND INDEX_NAME = 'idx_role';

SET @sql = IF(@index_exists = 0,
    'ALTER TABLE `admins` ADD INDEX `idx_role` (`role`)',
    'SELECT "Index idx_role already exists" AS message');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
