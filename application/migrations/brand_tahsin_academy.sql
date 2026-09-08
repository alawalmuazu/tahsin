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
  `fav_icon` = 'tahsin-logo.png'
WHERE `application_title` LIKE '%Smart%'
   OR `application_title` = 'School Management System With CMS'
   OR `application_title` = '';

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
