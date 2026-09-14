-- Tahsin Academy programmes: class = full track, section = mode, category = skills.

-- Remap the only existing student (Basic 7 / A / General)
-- to Day without Technical Skills.
UPDATE `enroll` SET `class_id` = 16, `section_id` = 2 WHERE `class_id` = 4;
UPDATE `subject_assign` SET `class_id` = 16, `section_id` = 2 WHERE `class_id` = 4;
UPDATE `timetable_class` SET `class_id` = 16, `section_id` = 2 WHERE `class_id` = 4;
UPDATE `teacher_allocation` SET `class_id` = 16, `section_id` = 2 WHERE `class_id` = 4;
UPDATE `timetable_exam` SET `class_id` = 16, `section_id` = 2 WHERE `class_id` = 4;
UPDATE `live_class` SET `class_id` = 16, `section_id` = '["2"]' WHERE `class_id` = 4;

UPDATE `class` SET `name` = 'Boarding Quran without Technical Skills', `name_numeric` = '1', `branch_id` = 1 WHERE `id` = 14;
UPDATE `class` SET `name` = 'Boarding Quran with Technical Skills', `name_numeric` = '2', `branch_id` = 1 WHERE `id` = 15;
UPDATE `class` SET `name` = 'Day without Technical Skills', `name_numeric` = '3', `branch_id` = 1 WHERE `id` = 16;
UPDATE `class` SET `name` = 'Day with Technical Skills', `name_numeric` = '4', `branch_id` = 1 WHERE `id` = 17;
UPDATE `class` SET `name` = 'Weekend Tahfeez with Skills', `name_numeric` = '5', `branch_id` = 1 WHERE `id` = 18;
UPDATE `class` SET `name` = 'Weekend Tahfeez without Technical skills', `name_numeric` = '6', `branch_id` = 1 WHERE `id` = 19;

DELETE FROM `class` WHERE `id` NOT IN (14, 15, 16, 17, 18, 19);

UPDATE `section` SET `name` = 'Boarding', `capacity` = NULL, `branch_id` = 1 WHERE `id` = 1;
UPDATE `section` SET `name` = 'Day', `capacity` = NULL, `branch_id` = 1 WHERE `id` = 2;
UPDATE `section` SET `name` = 'Weekend', `capacity` = NULL, `branch_id` = 1 WHERE `id` = 3;
DELETE FROM `section` WHERE `id` NOT IN (1, 2, 3);

DELETE FROM `sections_allocation`;
INSERT INTO `sections_allocation` (`class_id`, `section_id`) VALUES
(14, 1),
(15, 1),
(16, 2),
(17, 2),
(18, 3),
(19, 3);

UPDATE `student_category` SET `name` = 'Without Technical Skills', `branch_id` = 1 WHERE `id` = 1;
UPDATE `student_category` SET `name` = 'With Technical Skills', `branch_id` = 1 WHERE `id` = 2;
DELETE FROM `student_category` WHERE `id` NOT IN (1, 2);
UPDATE `student` SET `category_id` = 1 WHERE `category_id` NOT IN (1, 2);
