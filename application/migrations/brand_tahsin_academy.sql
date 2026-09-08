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
