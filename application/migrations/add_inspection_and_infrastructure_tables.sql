-- Migration: add missing inspection and infrastructure tables

CREATE TABLE `education_board` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `education_board` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Tahsin Basic Education', 'Tahsin Academy basic education board', '2026-04-14 07:25:04', '2026-04-14 08:27:14'),
(2, 'Tahsin Secondary Education', 'Tahsin Academy secondary education board', '2026-04-14 07:28:00', NULL);

ALTER TABLE `education_board`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `education_board`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

CREATE TABLE `infrastructure` (
  `id` int(10) UNSIGNED NOT NULL,
  `branch_id` int(10) UNSIGNED NOT NULL,
  `type` varchar(60) NOT NULL DEFAULT '',
  `name` varchar(150) NOT NULL DEFAULT '',
  `quantity` smallint(6) NOT NULL DEFAULT 1,
  `capacity` smallint(6) NOT NULL DEFAULT 0,
  `condition` enum('Good','Fair','Poor','Condemned') NOT NULL DEFAULT 'Good',
  `year_built` smallint(6) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `infrastructure`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_branch` (`branch_id`),
  ADD KEY `idx_condition` (`condition`);

ALTER TABLE `infrastructure`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

CREATE TABLE `inspection_deficiencies` (
  `id` int(11) NOT NULL,
  `inspection_id` int(11) NOT NULL,
  `category` enum('Infrastructure','Staffing','Resources','Compliance') NOT NULL DEFAULT 'Infrastructure',
  `description` text NOT NULL,
  `severity` enum('Critical','Moderate','Minor') NOT NULL DEFAULT 'Moderate',
  `remediation_status` enum('Open','In Progress','Resolved') NOT NULL DEFAULT 'Open',
  `resolved_at` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `inspection_deficiencies` (`id`, `inspection_id`, `category`, `description`, `severity`, `remediation_status`, `resolved_at`, `created_at`) VALUES
(1, 1, 'Staffing', 'ONLY 1 teachers teachers 4 classes', 'Critical', 'Open', NULL, '2026-04-15 11:27:22'),
(2, 1, 'Infrastructure', 'roofing are licking', 'Moderate', 'Open', NULL, '2026-04-15 11:28:52'),
(3, 1, 'Resources', 'Needs more computers', 'Moderate', 'Open', NULL, '2026-04-15 11:28:52'),
(4, 1, 'Compliance', 'Needs trained the trainers session', 'Minor', 'Open', NULL, '2026-04-15 11:28:52');

ALTER TABLE `inspection_deficiencies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inspection_id` (`inspection_id`);

ALTER TABLE `inspection_deficiencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

CREATE TABLE `school_inspections` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `inspector_id` int(11) NOT NULL,
  `inspection_date` date NOT NULL,
  `infrastructure_score` tinyint(4) NOT NULL DEFAULT 0,
  `teaching_quality_score` tinyint(4) NOT NULL DEFAULT 0,
  `compliance_score` tinyint(4) NOT NULL DEFAULT 0,
  `total_score` tinyint(4) NOT NULL DEFAULT 0,
  `overall_grade` enum('Excellent','Good','Fair','Poor') NOT NULL DEFAULT 'Good',
  `status` enum('Pending','In Progress','Completed') DEFAULT 'Pending',
  `recommendations` text DEFAULT NULL,
  `next_inspection_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `school_inspections` (`id`, `branch_id`, `inspector_id`, `inspection_date`, `infrastructure_score`, `teaching_quality_score`, `compliance_score`, `total_score`, `overall_grade`, `status`, `recommendations`, `next_inspection_date`, `created_at`) VALUES
(1, 10, 1, '2026-04-16', 30, 65, 58, 51, 'Fair', 'Completed', 'long text', '2026-05-18', '2026-04-15 11:07:35'),
(2, 10, 5, '2026-04-20', 0, 0, 0, 0, 'Poor', 'In Progress', '', '0000-00-00', '2026-04-15 12:17:06');

ALTER TABLE `school_inspections`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `school_inspections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

CREATE TABLE `teacher_transfers` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `from_branch_id` int(11) NOT NULL,
  `to_branch_id` int(11) NOT NULL,
  `effective_date` date NOT NULL,
  `reason` text DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `reviewed_by` int(11) DEFAULT NULL,
  `rejection_note` text DEFAULT NULL,
  `reviewer_note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `teacher_transfers` (`id`, `staff_id`, `from_branch_id`, `to_branch_id`, `effective_date`, `reason`, `attachment`, `status`, `reviewed_by`, `rejection_note`, `reviewer_note`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 6, '2026-04-16', 'Testing', NULL, 'rejected', 1, 'hhhh', NULL, '2026-04-15 11:02:26', '2026-04-15 12:04:01'),
(2, 2, 1, 10, '2026-04-16', 'tttt', NULL, 'approved', 1, NULL, NULL, '2026-04-15 11:05:35', '2026-04-15 12:05:39'),
(3, 10, 10, 1, '2026-04-30', 'sssss', NULL, 'pending', NULL, NULL, NULL, '2026-04-15 17:41:11', NULL),
(4, 2, 10, 3, '2026-04-27', 'Mariage purpose and relocating', NULL, 'pending', NULL, NULL, NULL, '2026-04-15 19:57:08', NULL),
(5, 2, 10, 5, '2026-04-30', 'jbjbjb', 'be39bd9f52b954a0622b04356a3ccada.jpg', 'pending', NULL, NULL, NULL, '2026-04-15 20:42:43', NULL);

ALTER TABLE `teacher_transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`);

ALTER TABLE `teacher_transfers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

