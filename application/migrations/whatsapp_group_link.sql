-- Add parent WhatsApp group link to whatsapp_cloud_config.
-- Safe to re-run.

SET @col_exists = (
  SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'whatsapp_cloud_config' AND COLUMN_NAME = 'parent_group_link'
);
SET @sql = IF(@col_exists = 0,
  'ALTER TABLE `whatsapp_cloud_config` ADD COLUMN `parent_group_link` VARCHAR(500) DEFAULT NULL AFTER `media_max_per_student`',
  'SELECT 1'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
