-- Facilitator student groups (safe to re-run)
CREATE TABLE IF NOT EXISTS `academy_teacher_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `session_id` int(11) NOT NULL DEFAULT 0,
  `teacher_id` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_atg_name` (`branch_id`, `session_id`, `teacher_id`, `name`),
  KEY `idx_atg_teacher` (`teacher_id`, `session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `academy_teacher_group_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_atgm` (`group_id`, `student_id`),
  KEY `idx_atgm_student` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET @col := (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'academy_class_session' AND COLUMN_NAME = 'group_id');
SET @sql := IF(@col = 0, 'ALTER TABLE `academy_class_session` ADD COLUMN `group_id` INT(11) NOT NULL DEFAULT 0 AFTER `teacher_id`', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @o1 := (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'academy_class_session' AND INDEX_NAME = 'uq_acs_teacher_day');
SET @sql := IF(@o1 > 0, 'ALTER TABLE `academy_class_session` DROP INDEX `uq_acs_teacher_day`', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
SET @o2 := (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'academy_class_session' AND INDEX_NAME = 'uq_acs_teacher_day_cat');
SET @sql := IF(@o2 > 0, 'ALTER TABLE `academy_class_session` DROP INDEX `uq_acs_teacher_day_cat`', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
SET @o3 := (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'academy_class_session' AND INDEX_NAME = 'uq_acs_milestone');
SET @sql := IF(@o3 > 0, 'ALTER TABLE `academy_class_session` DROP INDEX `uq_acs_milestone`', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
SET @uq := (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'academy_class_session' AND INDEX_NAME = 'uq_acs_group_day');
SET @sql := IF(@uq > 0, 'SELECT 1', 'ALTER TABLE `academy_class_session` ADD UNIQUE KEY `uq_acs_group_day` (`branch_id`, `teacher_id`, `group_id`, `session_date`, `recitation_category`, `milestone_id`)');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
