-- One naira amount for online students, separate from the campus fee matrix.
-- Safe to re-run.

SET @c := (
  SELECT COUNT(*) FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'school_fee_settings' AND COLUMN_NAME = 'online_amount'
);
SET @sql := IF(@c = 0,
  'ALTER TABLE `school_fee_settings` ADD COLUMN `online_amount` DECIMAL(15,2) NOT NULL DEFAULT 0.00 AFTER `amount`',
  'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
