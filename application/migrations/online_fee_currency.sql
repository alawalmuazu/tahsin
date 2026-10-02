-- Online fees by currency. Naira is calculated from the current rate at admission.
-- Safe to re-run.

CREATE TABLE IF NOT EXISTS `online_fee_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `currency` char(3) NOT NULL,
  `amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`),
  UNIQUE KEY `branch_currency` (`branch_id`, `currency`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET @c := (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'enroll' AND COLUMN_NAME = 'fee_currency');
SET @sql := IF(@c = 0, 'ALTER TABLE `enroll` ADD COLUMN `fee_currency` CHAR(3) NULL DEFAULT NULL', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @c := (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'enroll' AND COLUMN_NAME = 'fee_foreign');
SET @sql := IF(@c = 0, 'ALTER TABLE `enroll` ADD COLUMN `fee_foreign` DECIMAL(15,2) NULL DEFAULT NULL AFTER `fee_currency`', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @c := (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'enroll' AND COLUMN_NAME = 'fee_rate');
SET @sql := IF(@c = 0, 'ALTER TABLE `enroll` ADD COLUMN `fee_rate` DECIMAL(18,6) NULL DEFAULT NULL AFTER `fee_foreign`', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @c := (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'enroll' AND COLUMN_NAME = 'fee_naira');
SET @sql := IF(@c = 0, 'ALTER TABLE `enroll` ADD COLUMN `fee_naira` DECIMAL(15,2) NULL DEFAULT NULL AFTER `fee_rate`', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
