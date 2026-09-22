-- Academy: assign students to a teacher, then review each day's session
-- Teacher records → Director approve/reject → Admin acknowledge/reject → WhatsApp + parent/student dashboards.
-- Safe to re-run.

CREATE TABLE IF NOT EXISTS `academy_teacher_student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `session_id` int(11) NOT NULL DEFAULT 0,
  `teacher_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `assigned_by` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_ats_teacher_student` (`branch_id`, `session_id`, `teacher_id`, `student_id`),
  KEY `idx_ats_teacher` (`teacher_id`, `session_id`),
  KEY `idx_ats_student` (`student_id`, `session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `academy_class_session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `academic_session_id` int(11) NOT NULL DEFAULT 0,
  `teacher_id` int(11) NOT NULL,
  `session_date` date NOT NULL,
  `status` varchar(32) NOT NULL DEFAULT 'recording',
  `student_total` int(11) NOT NULL DEFAULT 0,
  `recorded_count` int(11) NOT NULL DEFAULT 0,
  `submitted_at` datetime DEFAULT NULL,
  `director_user_id` int(11) DEFAULT NULL,
  `director_note` varchar(500) DEFAULT NULL,
  `director_at` datetime DEFAULT NULL,
  `admin_user_id` int(11) DEFAULT NULL,
  `admin_note` varchar(500) DEFAULT NULL,
  `admin_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_acs_teacher_day` (`branch_id`, `teacher_id`, `session_date`),
  KEY `idx_acs_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `academy_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `user_id` int(11) NOT NULL,
  `title` varchar(160) NOT NULL,
  `body` varchar(500) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_an_user` (`user_id`, `is_read`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A student may be assigned to more than one teacher (Quran, Maths, English, …).
-- Safe to re-run on databases created with the earlier one-teacher unique key.
SET @old_uq := (
  SELECT COUNT(*) FROM information_schema.STATISTICS
  WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'academy_teacher_student' AND INDEX_NAME = 'uq_ats_student_session'
);
SET @sql := IF(@old_uq > 0, 'ALTER TABLE `academy_teacher_student` DROP INDEX `uq_ats_student_session`', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @new_uq := (
  SELECT COUNT(*) FROM information_schema.STATISTICS
  WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'academy_teacher_student' AND INDEX_NAME = 'uq_ats_teacher_student'
);
SET @sql := IF(@new_uq = 0, 'ALTER TABLE `academy_teacher_student` ADD UNIQUE KEY `uq_ats_teacher_student` (`branch_id`, `session_id`, `teacher_id`, `student_id`)', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
