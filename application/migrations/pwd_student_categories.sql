-- Student Category (ability / PWD) — separate from programme Category (skills).
-- Safe to re-run.

CREATE TABLE IF NOT EXISTS `pwd_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `name` varchar(191) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_pwd_branch` (`branch_id`),
  KEY `idx_pwd_active` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Core student categories (Physically Fit = default)
INSERT INTO `pwd_category` (`branch_id`, `name`, `is_default`, `sort_order`, `active`)
SELECT 1, 'Physically Fit', 1, 1, 1 FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `pwd_category` WHERE `name` = 'Physically Fit' AND `branch_id` = 1 LIMIT 1);

INSERT INTO `pwd_category` (`branch_id`, `name`, `is_default`, `sort_order`, `active`)
SELECT 1, 'ALL', 0, 2, 1 FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `pwd_category` WHERE `name` = 'ALL' AND `branch_id` = 1 LIMIT 1);

INSERT INTO `pwd_category` (`branch_id`, `name`, `is_default`, `sort_order`, `active`)
SELECT 1, 'Visually Impaired (Blind)', 0, 3, 1 FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `pwd_category` WHERE `name` = 'Visually Impaired (Blind)' AND `branch_id` = 1 LIMIT 1);

INSERT INTO `pwd_category` (`branch_id`, `name`, `is_default`, `sort_order`, `active`)
SELECT 1, 'Hearing Impaired (Deaf)', 0, 4, 1 FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `pwd_category` WHERE `name` = 'Hearing Impaired (Deaf)' AND `branch_id` = 1 LIMIT 1);

-- Link students to Student Category (PWD / ability)
SET @pwd_col := (
  SELECT COUNT(*) FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'student'
    AND COLUMN_NAME = 'pwd_category_id'
);
SET @sql := IF(@pwd_col = 0,
  'ALTER TABLE `student` ADD COLUMN `pwd_category_id` INT(11) NULL DEFAULT NULL AFTER `category_id`, ADD KEY `idx_student_pwd_category` (`pwd_category_id`)',
  'SELECT 1'
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- Default existing students to Physically Fit
UPDATE `student` s
INNER JOIN `pwd_category` p ON p.branch_id = 1 AND p.is_default = 1
SET s.pwd_category_id = p.id
WHERE s.pwd_category_id IS NULL OR s.pwd_category_id = 0;

-- Permission for Settings → PWD Categories
INSERT INTO `permission` (`module_id`, `name`, `prefix`, `show_view`, `show_add`, `show_edit`, `show_delete`)
SELECT 18, 'PWD Categories', 'pwd_category', 1, 1, 1, 1
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `permission` WHERE `prefix` = 'pwd_category' LIMIT 1);

INSERT INTO `staff_privileges` (`role_id`, `permission_id`, `is_add`, `is_edit`, `is_view`, `is_delete`)
SELECT r.role_id, p.id, 1, 1, 1, 1
FROM `permission` p
CROSS JOIN (SELECT 2 AS role_id UNION ALL SELECT 9 AS role_id) r
WHERE p.prefix = 'pwd_category'
  AND NOT EXISTS (
    SELECT 1 FROM `staff_privileges` sp
    WHERE sp.role_id = r.role_id AND sp.permission_id = p.id LIMIT 1
  );

-- Ensure school_fee_settings exists (no-op if already there)
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

-- Seed fees: Section × Student Category (PWD). category_id = pwd_category.id
-- Physically Fit / ALL
INSERT INTO `school_fee_settings` (`branch_id`, `section_id`, `category_id`, `amount`)
SELECT 1, s.id, p.id,
  CASE s.name
    WHEN 'Boarding' THEN 1000000
    WHEN 'Day' THEN 800000
    WHEN 'Weekend' THEN 60000
    ELSE 1000000
  END
FROM `section` s
CROSS JOIN `pwd_category` p
WHERE s.branch_id = 1 AND p.branch_id = 1 AND p.name IN ('Physically Fit', 'ALL')
  AND NOT EXISTS (
    SELECT 1 FROM `school_fee_settings` f
    WHERE f.branch_id = 1 AND f.section_id = s.id AND f.category_id = p.id
  );

INSERT INTO `school_fee_settings` (`branch_id`, `section_id`, `category_id`, `amount`)
SELECT 1, s.id, p.id,
  CASE s.name
    WHEN 'Boarding' THEN 1000000
    WHEN 'Day' THEN 800000
    WHEN 'Weekend' THEN 50000
    ELSE 1000000
  END
FROM `section` s
CROSS JOIN `pwd_category` p
WHERE s.branch_id = 1 AND p.branch_id = 1 AND p.name = 'Visually Impaired (Blind)'
  AND NOT EXISTS (
    SELECT 1 FROM `school_fee_settings` f
    WHERE f.branch_id = 1 AND f.section_id = s.id AND f.category_id = p.id
  );

INSERT INTO `school_fee_settings` (`branch_id`, `section_id`, `category_id`, `amount`)
SELECT 1, s.id, p.id,
  CASE s.name
    WHEN 'Boarding' THEN 1500000
    WHEN 'Day' THEN 1000000
    WHEN 'Weekend' THEN 800000
    ELSE 1500000
  END
FROM `section` s
CROSS JOIN `pwd_category` p
WHERE s.branch_id = 1 AND p.branch_id = 1 AND p.name = 'Hearing Impaired (Deaf)'
  AND NOT EXISTS (
    SELECT 1 FROM `school_fee_settings` f
    WHERE f.branch_id = 1 AND f.section_id = s.id AND f.category_id = p.id
  );

INSERT INTO `school_fee_settings` (`branch_id`, `section_id`, `category_id`, `amount`)
SELECT 1, 0, 0, 1000000 FROM DUAL
WHERE NOT EXISTS (
  SELECT 1 FROM `school_fee_settings` WHERE branch_id = 1 AND section_id = 0 AND category_id = 0 LIMIT 1
);
