-- School fees: Section × Programme Category × Student Category (PWD)
-- Safe to re-run. category_id = programme (With/Without Technical Skills).
-- pwd_category_id = Physically Fit / ALL / Visually Impaired / Hearing Impaired.

SET @pwd_fee_col := (
  SELECT COUNT(*) FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'school_fee_settings'
    AND COLUMN_NAME = 'pwd_category_id'
);
SET @sql := IF(@pwd_fee_col = 0,
  'ALTER TABLE `school_fee_settings` ADD COLUMN `pwd_category_id` INT(11) NOT NULL DEFAULT 0 AFTER `category_id`',
  'SELECT 1'
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- Rebuild unique key for 3D matrix
SET @idx := (
  SELECT COUNT(*) FROM information_schema.STATISTICS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'school_fee_settings'
    AND INDEX_NAME = 'uq_branch_section_category'
);
SET @sql := IF(@idx > 0,
  'ALTER TABLE `school_fee_settings` DROP INDEX `uq_branch_section_category`',
  'SELECT 1'
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @idx2 := (
  SELECT COUNT(*) FROM information_schema.STATISTICS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'school_fee_settings'
    AND INDEX_NAME = 'uq_branch_section_cat_pwd'
);
SET @sql := IF(@idx2 = 0,
  'ALTER TABLE `school_fee_settings` ADD UNIQUE KEY `uq_branch_section_cat_pwd` (`branch_id`,`section_id`,`category_id`,`pwd_category_id`)',
  'SELECT 1'
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- Default fee
INSERT INTO `school_fee_settings` (`branch_id`, `section_id`, `category_id`, `pwd_category_id`, `amount`)
SELECT 1, 0, 0, 0, 2500000 FROM DUAL
WHERE NOT EXISTS (
  SELECT 1 FROM `school_fee_settings`
  WHERE branch_id = 1 AND section_id = 0 AND category_id = 0 AND pwd_category_id = 0
  LIMIT 1
);

-- Physically Fit: 2,500,000 for all Section × Programme cells
INSERT INTO `school_fee_settings` (`branch_id`, `section_id`, `category_id`, `pwd_category_id`, `amount`)
SELECT 1, s.id, sc.id, p.id, 2500000
FROM `section` s
CROSS JOIN `student_category` sc
CROSS JOIN `pwd_category` p
WHERE s.branch_id = 1
  AND p.branch_id = 1 AND p.is_default = 1
  AND sc.name IN ('Without Technical Skills', 'With Technical Skills')
  AND NOT EXISTS (
    SELECT 1 FROM `school_fee_settings` f
    WHERE f.branch_id = 1 AND f.section_id = s.id AND f.category_id = sc.id AND f.pwd_category_id = p.id
  );

-- PWD ALL (same as spreadsheet "all")
INSERT INTO `school_fee_settings` (`branch_id`, `section_id`, `category_id`, `pwd_category_id`, `amount`)
SELECT 1, s.id, sc.id, p.id,
  CASE
    WHEN s.name = 'Boarding' AND sc.name = 'With Technical Skills' THEN 1000000
    WHEN s.name = 'Boarding' AND sc.name = 'Without Technical Skills' THEN 800000
    WHEN s.name = 'Day' AND sc.name = 'With Technical Skills' THEN 800000
    WHEN s.name = 'Day' AND sc.name = 'Without Technical Skills' THEN 500000
    WHEN s.name = 'Weekend' AND sc.name = 'With Technical Skills' THEN 60000
    WHEN s.name = 'Weekend' AND sc.name = 'Without Technical Skills' THEN 50000
    ELSE 1000000
  END
FROM `section` s
CROSS JOIN `student_category` sc
CROSS JOIN `pwd_category` p
WHERE s.branch_id = 1 AND p.branch_id = 1 AND p.name = 'ALL'
  AND sc.name IN ('Without Technical Skills', 'With Technical Skills')
  AND NOT EXISTS (
    SELECT 1 FROM `school_fee_settings` f
    WHERE f.branch_id = 1 AND f.section_id = s.id AND f.category_id = sc.id AND f.pwd_category_id = p.id
  );

-- Visually Impaired (Blind)
INSERT INTO `school_fee_settings` (`branch_id`, `section_id`, `category_id`, `pwd_category_id`, `amount`)
SELECT 1, s.id, sc.id, p.id,
  CASE
    WHEN s.name = 'Boarding' AND sc.name = 'With Technical Skills' THEN 1000000
    WHEN s.name = 'Boarding' AND sc.name = 'Without Technical Skills' THEN 1000000
    WHEN s.name = 'Day' AND sc.name = 'With Technical Skills' THEN 800000
    WHEN s.name = 'Day' AND sc.name = 'Without Technical Skills' THEN 800000
    WHEN s.name = 'Weekend' AND sc.name = 'With Technical Skills' THEN 50000
    WHEN s.name = 'Weekend' AND sc.name = 'Without Technical Skills' THEN 40000
    ELSE 1000000
  END
FROM `section` s
CROSS JOIN `student_category` sc
CROSS JOIN `pwd_category` p
WHERE s.branch_id = 1 AND p.branch_id = 1 AND p.name = 'Visually Impaired (Blind)'
  AND sc.name IN ('Without Technical Skills', 'With Technical Skills')
  AND NOT EXISTS (
    SELECT 1 FROM `school_fee_settings` f
    WHERE f.branch_id = 1 AND f.section_id = s.id AND f.category_id = sc.id AND f.pwd_category_id = p.id
  );

-- Hearing Impaired (Deaf)
INSERT INTO `school_fee_settings` (`branch_id`, `section_id`, `category_id`, `pwd_category_id`, `amount`)
SELECT 1, s.id, sc.id, p.id,
  CASE
    WHEN s.name = 'Boarding' AND sc.name = 'With Technical Skills' THEN 1500000
    WHEN s.name = 'Boarding' AND sc.name = 'Without Technical Skills' THEN 1500000
    WHEN s.name = 'Day' AND sc.name = 'With Technical Skills' THEN 1000000
    WHEN s.name = 'Day' AND sc.name = 'Without Technical Skills' THEN 1000000
    WHEN s.name = 'Weekend' AND sc.name = 'With Technical Skills' THEN 800000
    WHEN s.name = 'Weekend' AND sc.name = 'Without Technical Skills' THEN 50000
    ELSE 1500000
  END
FROM `section` s
CROSS JOIN `student_category` sc
CROSS JOIN `pwd_category` p
WHERE s.branch_id = 1 AND p.branch_id = 1 AND p.name = 'Hearing Impaired (Deaf)'
  AND sc.name IN ('Without Technical Skills', 'With Technical Skills')
  AND NOT EXISTS (
    SELECT 1 FROM `school_fee_settings` f
    WHERE f.branch_id = 1 AND f.section_id = s.id AND f.category_id = sc.id AND f.pwd_category_id = p.id
  );
