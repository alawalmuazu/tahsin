-- Wipe all guardians/parents and reset IDs so the next parent starts at 1.
-- Run once on Hostinger (phpMyAdmin / MySQL). Irreversible.

SET FOREIGN_KEY_CHECKS = 0;

-- Unlink students from deleted guardians
UPDATE `student`
SET `parent_id` = 0
WHERE `parent_id` IS NOT NULL AND `parent_id` <> 0;

-- Remove parent portal logins
DELETE FROM `login_credential` WHERE `role` = 6;

-- Optional: custom field values stored against parents
DELETE cfv FROM `custom_fields_values` cfv
INNER JOIN `custom_fields` cf ON cf.id = cfv.field_id
WHERE cf.form_to = 'parents' OR cf.belong_to = 'parents' OR cf.form_to = 'parent' OR cf.belong_to = 'parent';

-- Clear all parent rows and reset auto-increment to 1
TRUNCATE TABLE `parent`;

SET FOREIGN_KEY_CHECKS = 1;

-- Confirm
-- SELECT COUNT(*) AS parents_left FROM parent;
-- SHOW TABLE STATUS LIKE 'parent';
