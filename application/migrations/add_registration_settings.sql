-- Staff registration toggle. Safe to re-run.

SET @col := (
  SELECT COUNT(*) FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'global_settings' AND COLUMN_NAME = 'staff_registration_enabled'
);
SET @sql := IF(@col = 0, 'ALTER TABLE `global_settings` ADD COLUMN `staff_registration_enabled` TINYINT(1) NOT NULL DEFAULT 1', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @col := (
  SELECT COUNT(*) FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'global_settings' AND COLUMN_NAME = 'staff_registration_deadline'
);
SET @sql := IF(@col = 0, 'ALTER TABLE `global_settings` ADD COLUMN `staff_registration_deadline` DATE DEFAULT NULL', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
