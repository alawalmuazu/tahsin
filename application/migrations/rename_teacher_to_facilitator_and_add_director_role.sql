-- =====================================================================
-- Migration: Rename Teacher to Facilitator and Add Director Role
-- Tahsin Academy — Excellence In Deen & Duniya
-- =====================================================================

-- 1. Rename Teacher role (ID: 3) to Facilitator
UPDATE `roles`
SET `name` = 'Facilitator', `prefix` = 'facilitator'
WHERE `id` = 3;

-- 2. Add Director role (ID: 9)
INSERT INTO `roles` (`id`, `name`, `prefix`, `is_system`)
VALUES (9, 'Director', 'director', 1)
ON DUPLICATE KEY UPDATE `name` = 'Director', `prefix` = 'director';

-- 3. Seed Director permissions from Admin (Role 2) in staff_privileges
DELETE FROM `staff_privileges` WHERE `role_id` = 9;
INSERT INTO `staff_privileges` (`role_id`, `permission_id`, `is_add`, `is_edit`, `is_view`, `is_delete`)
SELECT 9, `permission_id`, `is_add`, `is_edit`, `is_view`, `is_delete`
FROM `staff_privileges`
WHERE `role_id` = 2;

-- 4. Update Staff Designations from Teacher to Facilitator
UPDATE `staff_designation` SET `name` = 'Facilitator' WHERE `id` = 2;
UPDATE `staff_designation` SET `name` = 'Asst. Facilitator' WHERE `id` = 3;
UPDATE `staff_designation` SET `name` = 'Head Facilitator' WHERE `id` = 7;
UPDATE `staff_designation` SET `name` = 'Assistant Head Facilitator' WHERE `id` = 8;
UPDATE `staff_designation` SET `name` = 'Class Facilitator' WHERE `id` = 9;
UPDATE `staff_designation` SET `name` = 'Subject Facilitator' WHERE `id` = 10;

-- 5. Update Staff Department
UPDATE `staff_department` SET `name` = 'Facilitating Staff' WHERE `id` = 8;

-- 6. Update Language Dictionary entries for Teacher -> Facilitator
UPDATE `languages` SET `english` = 'Facilitator' WHERE `word` = 'teacher';
UPDATE `languages` SET `english` = 'Facilitators' WHERE `word` = 'teachers';
UPDATE `languages` SET `english` = 'No of Facilitator' WHERE `word` = 'no_of_teacher';
UPDATE `languages` SET `english` = 'Edit Facilitator' WHERE `word` = 'edit_teacher';
UPDATE `languages` SET `english` = 'Select Facilitator' WHERE `word` = 'select_teacher';
UPDATE `languages` SET `english` = 'Assign Class Facilitator' WHERE `word` = 'assign_class_teacher';
UPDATE `languages` SET `english` = 'Class Facilitator Allocation' WHERE `word` = 'class_teacher_allocation';
UPDATE `languages` SET `english` = 'Class Facilitator' WHERE `word` = 'class_teacher';
UPDATE `languages` SET `english` = 'Facilitator Assign' WHERE `word` = 'teacher_assign';
UPDATE `languages` SET `english` = 'Facilitator Assign List' WHERE `word` = 'teacher_assign_list';
UPDATE `languages` SET `english` = 'Class Facilitator List' WHERE `word` = 'class_teacher_list';
UPDATE `languages` SET `english` = 'Facilitator Restricted' WHERE `word` = 'teacher_restricted';
UPDATE `languages` SET `english` = 'Facilitator Comments' WHERE `word` = 'teacher_comments';

-- Ensure new dictionary keywords exist
INSERT INTO `languages` (`word`, `english`)
SELECT 'director', 'Director' FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `languages` WHERE `word` = 'director');

INSERT INTO `languages` (`word`, `english`)
SELECT 'facilitator', 'Facilitator' FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `languages` WHERE `word` = 'facilitator');

INSERT INTO `languages` (`word`, `english`)
SELECT 'facilitators', 'Facilitators' FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `languages` WHERE `word` = 'facilitators');
