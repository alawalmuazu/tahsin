-- Full audit trail: table + Settings permission + Admin/Director privileges
-- Safe to re-run (IF NOT EXISTS / INSERT IGNORE patterns).

CREATE TABLE IF NOT EXISTS `audit_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `username` varchar(191) DEFAULT NULL,
  `action` varchar(32) NOT NULL,
  `module` varchar(100) NOT NULL DEFAULT '',
  `table_name` varchar(100) DEFAULT NULL,
  `record_id` varchar(64) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `old_values` longtext DEFAULT NULL,
  `new_values` longtext DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(500) DEFAULT NULL,
  `url` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_audit_user` (`user_id`),
  KEY `idx_audit_action` (`action`),
  KEY `idx_audit_module` (`module`),
  KEY `idx_audit_table` (`table_name`),
  KEY `idx_audit_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `permission` (`module_id`, `name`, `prefix`, `show_view`, `show_add`, `show_edit`, `show_delete`)
SELECT 18, 'Audit Trail', 'audit_trail', 1, 0, 0, 1
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `permission` WHERE `prefix` = 'audit_trail');

INSERT INTO `staff_privileges` (`role_id`, `permission_id`, `is_add`, `is_edit`, `is_view`, `is_delete`)
SELECT r.role_id, p.id, 0, 0, 1, 1
FROM `permission` p
CROSS JOIN (
  SELECT 2 AS role_id
  UNION ALL
  SELECT 9 AS role_id
) r
WHERE p.prefix = 'audit_trail'
  AND NOT EXISTS (
    SELECT 1 FROM `staff_privileges` sp
    WHERE sp.role_id = r.role_id AND sp.permission_id = p.id
  );

UPDATE `staff_privileges` sp
INNER JOIN `permission` p ON p.id = sp.permission_id
SET sp.is_view = 1, sp.is_delete = 1
WHERE p.prefix = 'audit_trail' AND sp.role_id IN (2, 9);
