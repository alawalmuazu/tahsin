-- Online students: delivery mode, country, timezone, and group meeting slot.
-- Safe to re-run.

SET @c := (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'enroll' AND COLUMN_NAME = 'instruction_mode');
SET @sql := IF(@c = 0, 'ALTER TABLE `enroll` ADD COLUMN `instruction_mode` VARCHAR(16) NOT NULL DEFAULT ''campus'' AFTER `roll`', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @c := (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'student' AND COLUMN_NAME = 'country');
SET @sql := IF(@c = 0, 'ALTER TABLE `student` ADD COLUMN `country` VARCHAR(80) NULL DEFAULT NULL AFTER `state`', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @c := (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'student' AND COLUMN_NAME = 'timezone');
SET @sql := IF(@c = 0, 'ALTER TABLE `student` ADD COLUMN `timezone` VARCHAR(64) NOT NULL DEFAULT ''Africa/Lagos'' AFTER `country`', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @c := (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'academy_teacher_group' AND COLUMN_NAME = 'starts_at_lagos');
SET @sql := IF(@c = 0, 'ALTER TABLE `academy_teacher_group` ADD COLUMN `starts_at_lagos` TIME NULL DEFAULT NULL AFTER `sort_order`', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @c := (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'academy_teacher_group' AND COLUMN_NAME = 'duration_minutes');
SET @sql := IF(@c = 0, 'ALTER TABLE `academy_teacher_group` ADD COLUMN `duration_minutes` INT(11) NOT NULL DEFAULT 45 AFTER `starts_at_lagos`', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @c := (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'academy_teacher_group' AND COLUMN_NAME = 'meeting_url');
SET @sql := IF(@c = 0, 'ALTER TABLE `academy_teacher_group` ADD COLUMN `meeting_url` VARCHAR(500) NULL DEFAULT NULL AFTER `duration_minutes`', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
