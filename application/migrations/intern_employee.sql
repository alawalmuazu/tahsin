-- Intern employees are mentored by one facilitator.
-- Safe to re-run.

INSERT INTO `roles` (`name`, `prefix`, `is_system`)
SELECT 'Intern', 'intern', '1' FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `roles` WHERE `prefix` = 'intern' OR `name` = 'Intern');

SET @c := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'staff' AND COLUMN_NAME = 'mentor_id'
);
SET @sql := IF(@c = 0, 'ALTER TABLE `staff` ADD COLUMN `mentor_id` INT(11) NULL DEFAULT NULL', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

INSERT INTO `staff_designation` (`name`, `branch_id`)
SELECT 'Intern', 1 FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `staff_designation` WHERE `name` = 'Intern');

INSERT INTO `languages` (`word`, `english`)
SELECT 'intern', 'Intern' FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `languages` WHERE `word` = 'intern');

INSERT INTO `languages` (`word`, `english`)
SELECT 'mentor', 'Mentor' FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `languages` WHERE `word` = 'mentor');

INSERT INTO `languages` (`word`, `english`)
SELECT 'my_interns', 'My interns' FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `languages` WHERE `word` = 'my_interns');

INSERT INTO `languages` (`word`, `english`)
SELECT 'my_mentor', 'My mentor' FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `languages` WHERE `word` = 'my_mentor');
