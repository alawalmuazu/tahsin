-- Pillar B Academy Engine (Performance drills + Tahfiz).
-- Safe to re-run. Next student register / parent IDs are unrelated.

-- ── Permission module group ────────────────────────────────
INSERT INTO `permission_modules` (`name`, `prefix`, `system`, `sorted`, `in_module`)
SELECT 'Academy', 'academy', 1, 4, 1 FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `permission_modules` WHERE `prefix` = 'academy' LIMIT 1);

SET @academy_module_id := (SELECT `id` FROM `permission_modules` WHERE `prefix` = 'academy' LIMIT 1);

INSERT INTO `permission` (`module_id`, `name`, `prefix`, `show_view`, `show_add`, `show_edit`, `show_delete`)
SELECT @academy_module_id, 'Academy Performance', 'academy_performance', 1, 1, 1, 1 FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `permission` WHERE `prefix` = 'academy_performance' LIMIT 1);

INSERT INTO `permission` (`module_id`, `name`, `prefix`, `show_view`, `show_add`, `show_edit`, `show_delete`)
SELECT @academy_module_id, 'Tahfiz Tracker', 'tahfiz', 1, 1, 1, 1 FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `permission` WHERE `prefix` = 'tahfiz' LIMIT 1);

INSERT INTO `staff_privileges` (`role_id`, `permission_id`, `is_add`, `is_edit`, `is_view`, `is_delete`)
SELECT r.role_id, p.id, 1, 1, 1, 1
FROM `permission` p
CROSS JOIN (SELECT 2 AS role_id UNION ALL SELECT 3 AS role_id UNION ALL SELECT 9 AS role_id) r
WHERE p.prefix IN ('academy_performance', 'tahfiz')
  AND NOT EXISTS (
    SELECT 1 FROM `staff_privileges` sp
    WHERE sp.role_id = r.role_id AND sp.permission_id = p.id LIMIT 1
  );

-- Enable Academy module per branch (modules_manage)
INSERT INTO `modules_manage` (`modules_id`, `branch_id`, `isEnabled`)
SELECT @academy_module_id, b.id, 1
FROM `branch` b
WHERE @academy_module_id IS NOT NULL
  AND NOT EXISTS (
    SELECT 1 FROM `modules_manage` mm
    WHERE mm.modules_id = @academy_module_id AND mm.branch_id = b.id LIMIT 1
  );

-- ── Daily drills (Maths, English, Arabic, Quran, Skills, Core) ──
CREATE TABLE IF NOT EXISTS `academy_daily_drill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `student_id` int(11) NOT NULL,
  `evaluator_id` int(11) NOT NULL DEFAULT 0,
  `pillar` varchar(32) NOT NULL COMMENT 'MATH|ENGLISH|ARABIC|QURAN|VOCATIONAL|CORE_SKILLS',
  `sub_category` varchar(100) DEFAULT NULL,
  `score` int(11) NOT NULL DEFAULT 0,
  `total_possible` int(11) NOT NULL DEFAULT 20,
  `time_seconds` int(11) NOT NULL DEFAULT 0,
  `spp_metric` decimal(10,4) NOT NULL DEFAULT 0.0000,
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_drill_branch` (`branch_id`),
  KEY `idx_drill_student` (`student_id`),
  KEY `idx_drill_pillar` (`pillar`),
  KEY `idx_drill_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ── Tahfiz portion ledger ──────────────────────────────────
CREATE TABLE IF NOT EXISTS `academy_tahfiz_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `student_id` int(11) NOT NULL,
  `instructor_id` int(11) NOT NULL DEFAULT 0,
  `surah_number` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `surah_name` varchar(80) NOT NULL,
  `portion_mode` varchar(32) NOT NULL DEFAULT 'FULL_SURAH'
    COMMENT 'FULL_SURAH|AYAH|FROM_TO_AYAH|SUMMUI|RUBBUI|SAFHA',
  `ayah_from` int(11) DEFAULT NULL,
  `ayah_to` int(11) DEFAULT NULL,
  `page_from` int(11) DEFAULT NULL,
  `page_to` int(11) DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 1,
  `akhlaq_note` text DEFAULT NULL,
  `completed_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_tahfiz_branch` (`branch_id`),
  KEY `idx_tahfiz_student` (`student_id`),
  KEY `idx_tahfiz_surah` (`surah_number`),
  KEY `idx_tahfiz_completed` (`completed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
