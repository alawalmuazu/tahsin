-- Extra parent phone numbers. Safe to re-run.

SET @col := (
  SELECT COUNT(*) FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'parent' AND COLUMN_NAME = 'extra_phones'
);
SET @sql := IF(@col = 0, 'ALTER TABLE `parent` ADD COLUMN `extra_phones` text NULL', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
