-- Allow Class/Section "None" on admission (enroll.class_id / section_id nullable).
-- Safe to re-run.

SET @fk3 := (
  SELECT COUNT(*) FROM information_schema.TABLE_CONSTRAINTS
  WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'enroll' AND CONSTRAINT_NAME = 'enroll_rms_3'
);
SET @sql := IF(@fk3 > 0, 'ALTER TABLE `enroll` DROP FOREIGN KEY `enroll_rms_3`', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @fk4 := (
  SELECT COUNT(*) FROM information_schema.TABLE_CONSTRAINTS
  WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'enroll' AND CONSTRAINT_NAME = 'enroll_rms_4'
);
SET @sql := IF(@fk4 > 0, 'ALTER TABLE `enroll` DROP FOREIGN KEY `enroll_rms_4`', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

ALTER TABLE `enroll`
  MODIFY `class_id` INT(11) NULL DEFAULT NULL,
  MODIFY `section_id` INT(11) NULL DEFAULT NULL;

-- Convert legacy 0 placeholders to NULL
UPDATE `enroll` SET `class_id` = NULL WHERE `class_id` = 0;
UPDATE `enroll` SET `section_id` = NULL WHERE `section_id` = 0;

SET @fk3b := (
  SELECT COUNT(*) FROM information_schema.TABLE_CONSTRAINTS
  WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'enroll' AND CONSTRAINT_NAME = 'enroll_rms_3'
);
SET @sql := IF(@fk3b = 0,
  'ALTER TABLE `enroll` ADD CONSTRAINT `enroll_rms_3` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`) ON DELETE SET NULL',
  'SELECT 1'
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @fk4b := (
  SELECT COUNT(*) FROM information_schema.TABLE_CONSTRAINTS
  WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'enroll' AND CONSTRAINT_NAME = 'enroll_rms_4'
);
SET @sql := IF(@fk4b = 0,
  'ALTER TABLE `enroll` ADD CONSTRAINT `enroll_rms_4` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`) ON DELETE SET NULL',
  'SELECT 1'
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
