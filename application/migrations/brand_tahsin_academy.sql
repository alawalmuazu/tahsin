-- Rebrand institute names from Smart School to Tahsin Academy
UPDATE `global_settings`
SET
  `institute_name` = 'Tahsin Academy',
  `footer_text` = '© 2026 Tahsin Academy'
WHERE `id` = 1;

UPDATE `front_cms_setting`
SET
  `application_title` = 'Tahsin Academy',
  `copyright_text` = REPLACE(REPLACE(`copyright_text`, 'SmartSchool', 'Tahsin Academy'), 'Smart School', 'Tahsin Academy'),
  `logo` = 'tahsin-logo.png',
  `fav_icon` = 'tahsin-logo.png',
  `online_admission` = 1
WHERE `application_title` LIKE '%Smart%'
   OR `application_title` = 'School Management System With CMS'
   OR `application_title` = '';

UPDATE `front_cms_setting`
SET `online_admission` = 1;

UPDATE `global_settings`
SET `cms_default_branch` = (
  SELECT `id` FROM (SELECT MIN(`id`) AS `id` FROM `branch`) AS `first_branch`
)
WHERE `id` = 1 AND (`cms_default_branch` IS NULL OR `cms_default_branch` = 0);

UPDATE `education_board`
SET
  `name` = 'Tahsin Basic Education',
  `description` = 'Tahsin Academy basic education board'
WHERE `name` IN ('KADSUBEB', 'Kaduna State Universal Basic Education Board')
   OR `description` LIKE '%Kaduna State Universal Basic%';

UPDATE `education_board`
SET
  `name` = 'Tahsin Secondary Education',
  `description` = 'Tahsin Academy secondary education board'
WHERE `name` IN ('KADSSSEB', 'Kaduna State Senior Secondary School Education Board')
   OR `description` LIKE '%Kaduna State Senior Secondary%';

UPDATE `branch`
SET
  `name` = 'Tahsin Academy',
  `school_name` = 'Tahsin Academy'
WHERE `id` = 1
   OR `name` LIKE '%Kaduna%'
   OR `school_name` LIKE '%Kaduna%';

UPDATE `front_cms_setting`
SET `application_title` = 'Tahsin Academy';

UPDATE `front_cms_setting`
SET `url_alias` = ''
WHERE `url_alias` = 'example' OR `url_alias` IS NULL;

UPDATE `front_cms_setting`
SET `footer_about_text` = 'Tahsin Academy — Excellence In Deen &amp; Duniya. Nurturing future leaders through authentic Islamic values and high academic standards.'
WHERE `footer_about_text` LIKE '%LorIsum%'
   OR `footer_about_text` LIKE '%Lorem Ipsum%'
   OR `footer_about_text` = '';

UPDATE `front_cms_setting`
SET `working_hours` = '<span>Hours: </span> Mon - Fri: 8:00 AM - 3:00 PM'
WHERE `working_hours` LIKE '%Sunday Closed%'
   OR `working_hours` LIKE '%10AM - 04PM%';

UPDATE `front_cms_home`
SET `elements` = '{"mobile_no":"","button_text":"Apply for Admission","button_url":"admission"}'
WHERE `item_type` = 'cta';

UPDATE `front_cms_home`
SET `title` = REPLACE(REPLACE(`title`, 'SmartSchool', 'Tahsin Academy'), 'Smart School', 'Tahsin Academy')
WHERE `title` LIKE '%SmartSchool%' OR `title` LIKE '%Smart School%';

UPDATE `front_cms_menu`
SET `publish` = 1
WHERE `alias` = 'admission';

-- Tahsin Academy Types of Admission
INSERT INTO `student_category` (`name`, `branch_id`)
SELECT 'Boarding Quran without Technical skills', 1 FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `student_category` WHERE `name` = 'Boarding Quran without Technical skills');
INSERT INTO `student_category` (`name`, `branch_id`)
SELECT 'Boarding Quran with Technical skills', 1 FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `student_category` WHERE `name` = 'Boarding Quran with Technical skills');
INSERT INTO `student_category` (`name`, `branch_id`)
SELECT 'Day without Technical Skills', 1 FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `student_category` WHERE `name` = 'Day without Technical Skills');
INSERT INTO `student_category` (`name`, `branch_id`)
SELECT 'Day with Technical Skills', 1 FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `student_category` WHERE `name` = 'Day with Technical Skills');
INSERT INTO `student_category` (`name`, `branch_id`)
SELECT 'Weekend Tahfeez with Skills', 1 FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `student_category` WHERE `name` = 'Weekend Tahfeez with Skills');
INSERT INTO `student_category` (`name`, `branch_id`)
SELECT 'Weekend Tahfeez without Technical skills', 1 FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `student_category` WHERE `name` = 'Weekend Tahfeez without Technical skills');

DELETE FROM `student_category`
WHERE `name` IN ('General Science', 'Commerce', 'Art', 'Technical', 'Day Student');


