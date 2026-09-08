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
