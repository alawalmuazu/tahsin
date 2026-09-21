-- WhatsApp Business Cloud API credentials (School Settings).
-- Safe to re-run.

CREATE TABLE IF NOT EXISTS `whatsapp_cloud_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `enabled` tinyint(1) NOT NULL DEFAULT 0,
  `access_token` text DEFAULT NULL,
  `phone_number_id` varchar(64) DEFAULT NULL,
  `waba_id` varchar(64) DEFAULT NULL,
  `api_version` varchar(16) NOT NULL DEFAULT 'v21.0',
  `template_name` varchar(120) NOT NULL DEFAULT 'tahsin_daily_digest',
  `template_lang` varchar(16) NOT NULL DEFAULT 'en',
  `send_media_after_template` tinyint(1) NOT NULL DEFAULT 1,
  `media_max_per_student` tinyint(3) UNSIGNED NOT NULL DEFAULT 3,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_wa_cloud_branch` (`branch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
