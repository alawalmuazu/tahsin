-- Audit trail migration — safe to re-run.
-- Skips anything that already exists (table, permission, privileges).

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

-- Skip if permission already exists
INSERT INTO `permission` (`module_id`, `name`, `prefix`, `show_view`, `show_add`, `show_edit`, `show_delete`)
SELECT 18, 'Audit Trail', 'audit_trail', 1, 0, 0, 1
FROM DUAL
WHERE NOT EXISTS (
  SELECT 1 FROM `permission` WHERE `prefix` = 'audit_trail' LIMIT 1
);

-- Skip Admin (2) privilege if already exists
INSERT INTO `staff_privileges` (`role_id`, `permission_id`, `is_add`, `is_edit`, `is_view`, `is_delete`)
SELECT 2, p.id, 0, 0, 1, 1
FROM `permission` p
WHERE p.prefix = 'audit_trail'
  AND NOT EXISTS (
    SELECT 1 FROM `staff_privileges` sp
    WHERE sp.role_id = 2 AND sp.permission_id = p.id
    LIMIT 1
  );

-- Skip Director (9) privilege if already exists
INSERT INTO `staff_privileges` (`role_id`, `permission_id`, `is_add`, `is_edit`, `is_view`, `is_delete`)
SELECT 9, p.id, 0, 0, 1, 1
FROM `permission` p
WHERE p.prefix = 'audit_trail'
  AND NOT EXISTS (
    SELECT 1 FROM `staff_privileges` sp
    WHERE sp.role_id = 9 AND sp.permission_id = p.id
    LIMIT 1
  );
