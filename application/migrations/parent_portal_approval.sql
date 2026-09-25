-- Parent portal: approval flag for the compulsory install step after the first real login.
-- Safe to re-run.

SET @col := (
  SELECT COUNT(*) FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'login_credential' AND COLUMN_NAME = 'pwa_required'
);
SET @sql := IF(@col = 0, 'ALTER TABLE `login_credential` ADD COLUMN `pwa_required` tinyint(1) NOT NULL DEFAULT 0', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
