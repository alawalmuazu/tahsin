-- Academy Engine v2: media consent, Tarteel telemetry, Genome & Broadcast permissions.
-- Safe to re-run. Requires academy_engine.sql first.

-- Media consent on student
SET @mc := (
  SELECT COUNT(*) FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'student' AND COLUMN_NAME = 'media_consent'
);
SET @sql := IF(@mc = 0,
  'ALTER TABLE `student` ADD COLUMN `media_consent` TINYINT(1) NOT NULL DEFAULT 0',
  'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- Tarteel / recitation telemetry on tahfiz records
SET @t1 := (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'academy_tahfiz_record' AND COLUMN_NAME = 'accuracy_score');
SET @sql := IF(@t1 = 0, 'ALTER TABLE `academy_tahfiz_record` ADD COLUMN `accuracy_score` DECIMAL(5,2) DEFAULT NULL', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @t2 := (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'academy_tahfiz_record' AND COLUMN_NAME = 'mistake_word_count');
SET @sql := IF(@t2 = 0, 'ALTER TABLE `academy_tahfiz_record` ADD COLUMN `mistake_word_count` INT(11) DEFAULT NULL', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @t3 := (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'academy_tahfiz_record' AND COLUMN_NAME = 'mistake_breakdown');
SET @sql := IF(@t3 = 0, 'ALTER TABLE `academy_tahfiz_record` ADD COLUMN `mistake_breakdown` TEXT DEFAULT NULL', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @t4 := (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'academy_tahfiz_record' AND COLUMN_NAME = 'audio_url');
SET @sql := IF(@t4 = 0, 'ALTER TABLE `academy_tahfiz_record` ADD COLUMN `audio_url` VARCHAR(500) DEFAULT NULL', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @t5 := (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'academy_tahfiz_record' AND COLUMN_NAME = 'video_url');
SET @sql := IF(@t5 = 0, 'ALTER TABLE `academy_tahfiz_record` ADD COLUMN `video_url` VARCHAR(500) DEFAULT NULL', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @t6 := (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'academy_tahfiz_record' AND COLUMN_NAME = 'tarteel_status');
SET @sql := IF(@t6 = 0, 'ALTER TABLE `academy_tahfiz_record` ADD COLUMN `tarteel_status` VARCHAR(32) NOT NULL DEFAULT ''UNVERIFIED''', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @t7 := (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'academy_tahfiz_record' AND COLUMN_NAME = 'recitation_seconds');
SET @sql := IF(@t7 = 0, 'ALTER TABLE `academy_tahfiz_record` ADD COLUMN `recitation_seconds` INT(11) DEFAULT NULL', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- Broadcast dispatch log
CREATE TABLE IF NOT EXISTS `academy_broadcast_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `student_id` int(11) NOT NULL,
  `parent_contact` varchar(50) DEFAULT NULL,
  `channel` varchar(20) NOT NULL DEFAULT 'preview',
  `message` text NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'preview',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_bcast_branch` (`branch_id`),
  KEY `idx_bcast_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

SET @academy_module_id := (SELECT `id` FROM `permission_modules` WHERE `prefix` = 'academy' LIMIT 1);

INSERT INTO `permission` (`module_id`, `name`, `prefix`, `show_view`, `show_add`, `show_edit`, `show_delete`)
SELECT @academy_module_id, 'Genome Intelligence', 'academy_genome', 1, 0, 0, 0 FROM DUAL
WHERE @academy_module_id IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM `permission` WHERE `prefix` = 'academy_genome' LIMIT 1);

INSERT INTO `permission` (`module_id`, `name`, `prefix`, `show_view`, `show_add`, `show_edit`, `show_delete`)
SELECT @academy_module_id, 'Academy Broadcast', 'academy_broadcast', 1, 1, 0, 0 FROM DUAL
WHERE @academy_module_id IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM `permission` WHERE `prefix` = 'academy_broadcast' LIMIT 1);

INSERT INTO `staff_privileges` (`role_id`, `permission_id`, `is_add`, `is_edit`, `is_view`, `is_delete`)
SELECT r.role_id, p.id,
  IF(p.prefix = 'academy_broadcast', 1, 0),
  0, 1, 0
FROM `permission` p
CROSS JOIN (SELECT 2 AS role_id UNION ALL SELECT 3 AS role_id UNION ALL SELECT 9 AS role_id) r
WHERE p.prefix IN ('academy_genome', 'academy_broadcast')
  AND NOT EXISTS (
    SELECT 1 FROM `staff_privileges` sp
    WHERE sp.role_id = r.role_id AND sp.permission_id = p.id LIMIT 1
  );
