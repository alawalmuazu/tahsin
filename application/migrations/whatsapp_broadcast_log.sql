-- WhatsApp Cloud API: extra columns on academy_broadcast_log.
-- Safe to re-run.

SET @c1 := (
  SELECT COUNT(*) FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'academy_broadcast_log' AND COLUMN_NAME = 'meta_message_id'
);
SET @sql := IF(@c1 = 0,
  'ALTER TABLE `academy_broadcast_log` ADD COLUMN `meta_message_id` VARCHAR(120) DEFAULT NULL AFTER `status`',
  'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @c2 := (
  SELECT COUNT(*) FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'academy_broadcast_log' AND COLUMN_NAME = 'error_message'
);
SET @sql := IF(@c2 = 0,
  'ALTER TABLE `academy_broadcast_log` ADD COLUMN `error_message` TEXT DEFAULT NULL AFTER `meta_message_id`',
  'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @c3 := (
  SELECT COUNT(*) FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'academy_broadcast_log' AND COLUMN_NAME = 'channel'
);
SET @sql := IF(@c3 > 0,
  'ALTER TABLE `academy_broadcast_log` MODIFY COLUMN `channel` VARCHAR(40) NOT NULL DEFAULT ''preview''',
  'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
