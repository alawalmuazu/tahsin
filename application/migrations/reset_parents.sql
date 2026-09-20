-- Wipe all guardians/parents and reset IDs so the next parent starts at 1.
-- Run once on Hostinger (phpMyAdmin / MySQL). Irreversible.

SET FOREIGN_KEY_CHECKS = 0;

-- Unlink students from deleted guardians
UPDATE `student`
SET `parent_id` = 0
WHERE `parent_id` IS NOT NULL AND `parent_id` <> 0;

-- Remove parent portal logins
DELETE FROM `login_credential` WHERE `role` = 6;

-- Clear all parent rows and reset auto-increment to 1
TRUNCATE TABLE `parent`;

SET FOREIGN_KEY_CHECKS = 1;
