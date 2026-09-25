-- One review session per teacher, day, and recitation category.
-- A facilitator can record several categories with the same student; each category is its own director review.
-- Safe to re-run.

SET @col := (
  SELECT COUNT(*) FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'academy_class_session' AND COLUMN_NAME = 'recitation_category'
);
SET @sql := IF(@col = 0,
  'ALTER TABLE `academy_class_session` ADD COLUMN `recitation_category` VARCHAR(40) NOT NULL DEFAULT '''' AFTER `session_date`',
  'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @old_uq := (
  SELECT COUNT(*) FROM information_schema.STATISTICS
  WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'academy_class_session' AND INDEX_NAME = 'uq_acs_teacher_day'
);
SET @sql := IF(@old_uq > 0, 'ALTER TABLE `academy_class_session` DROP INDEX `uq_acs_teacher_day`', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @new_uq := (
  SELECT COUNT(*) FROM information_schema.STATISTICS
  WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'academy_class_session' AND INDEX_NAME = 'uq_acs_teacher_day_cat'
);
SET @mile := (
  SELECT COUNT(*) FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'academy_class_session' AND COLUMN_NAME = 'milestone_id'
);
SET @sql := IF(@mile = 0,
  'ALTER TABLE `academy_class_session` ADD COLUMN `milestone_id` INT(11) NOT NULL DEFAULT 0 AFTER `recitation_category`',
  'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @sql := IF(@new_uq > 0, 'ALTER TABLE `academy_class_session` DROP INDEX `uq_acs_teacher_day_cat`', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @mile_uq := (
  SELECT COUNT(*) FROM information_schema.STATISTICS
  WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'academy_class_session' AND INDEX_NAME = 'uq_acs_milestone'
);
SET @sql := IF(@mile_uq = 0,
  'ALTER TABLE `academy_class_session` ADD UNIQUE KEY `uq_acs_milestone` (`branch_id`, `teacher_id`, `session_date`, `recitation_category`, `milestone_id`)',
  'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
