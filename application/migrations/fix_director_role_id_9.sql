-- Fix live Director role: app expects id 9; some Hostinger DBs only have id 15.
-- Safe to re-run.

INSERT INTO `roles` (`id`, `name`, `prefix`, `is_system`)
VALUES (9, 'Director', 'director', 1)
ON DUPLICATE KEY UPDATE `name` = 'Director', `prefix` = 'director', `is_system` = 1;

DELETE FROM `staff_privileges` WHERE `role_id` = 9;

INSERT INTO `staff_privileges` (`role_id`, `permission_id`, `is_add`, `is_edit`, `is_view`, `is_delete`)
SELECT 9, `permission_id`, `is_add`, `is_edit`, `is_view`, `is_delete`
FROM `staff_privileges`
WHERE `role_id` = 15;

INSERT INTO `staff_privileges` (`role_id`, `permission_id`, `is_add`, `is_edit`, `is_view`, `is_delete`)
SELECT 9, sp.`permission_id`, sp.`is_add`, sp.`is_edit`, sp.`is_view`, sp.`is_delete`
FROM `staff_privileges` sp
WHERE sp.`role_id` = 2
  AND NOT EXISTS (SELECT 1 FROM `staff_privileges` x WHERE x.`role_id` = 9 LIMIT 1);

UPDATE `login_credential` SET `role` = 9 WHERE `role` = 15;
UPDATE `login_credential` SET `role` = 9 WHERE `username` = 'dir@gmail.com';

UPDATE `roles` SET `name` = 'Director (old)', `prefix` = 'director_old' WHERE `id` = 15;

-- Verify:
-- SELECT id, name, prefix FROM roles WHERE id IN (9,15);
-- SELECT username, role FROM login_credential WHERE username = 'dir@gmail.com';
-- SELECT COUNT(*) FROM staff_privileges WHERE role_id = 9;
