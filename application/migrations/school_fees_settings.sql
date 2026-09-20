-- School fee settings by Section × Category (safe to re-run)

CREATE TABLE IF NOT EXISTS `school_fee_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL DEFAULT 0,
  `category_id` int(11) NOT NULL DEFAULT 0,
  `amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_branch_section_category` (`branch_id`,`section_id`,`category_id`),
  KEY `idx_branch` (`branch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Seed default fee (section 0 + category 0) if missing — uses existing constant-equivalent
INSERT INTO `school_fee_settings` (`branch_id`, `section_id`, `category_id`, `amount`)
SELECT 1, 0, 0, 2500000
FROM DUAL
WHERE NOT EXISTS (
  SELECT 1 FROM `school_fee_settings`
  WHERE `branch_id` = 1 AND `section_id` = 0 AND `category_id` = 0
  LIMIT 1
);

INSERT INTO `permission` (`module_id`, `name`, `prefix`, `show_view`, `show_add`, `show_edit`, `show_delete`)
SELECT 18, 'School Fees', 'school_fees', 1, 0, 1, 0
FROM DUAL
WHERE NOT EXISTS (
  SELECT 1 FROM `permission` WHERE `prefix` = 'school_fees' LIMIT 1
);

INSERT INTO `staff_privileges` (`role_id`, `permission_id`, `is_add`, `is_edit`, `is_view`, `is_delete`)
SELECT r.role_id, p.id, 0, 1, 1, 0
FROM `permission` p
CROSS JOIN (
  SELECT 2 AS role_id
  UNION ALL
  SELECT 9 AS role_id
) r
WHERE p.prefix = 'school_fees'
  AND NOT EXISTS (
    SELECT 1 FROM `staff_privileges` sp
    WHERE sp.role_id = r.role_id AND sp.permission_id = p.id
    LIMIT 1
  );
