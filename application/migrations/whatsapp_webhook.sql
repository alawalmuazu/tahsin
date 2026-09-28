-- Meta WhatsApp webhook: verify token + event log.
-- Safe to re-run.

SET @c := (
  SELECT COUNT(*) FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'whatsapp_cloud_config' AND COLUMN_NAME = 'webhook_verify_token'
);
SET @sql := IF(@c = 0,
  'ALTER TABLE `whatsapp_cloud_config` ADD COLUMN `webhook_verify_token` VARCHAR(80) DEFAULT NULL AFTER `media_max_per_student`',
  'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

CREATE TABLE IF NOT EXISTS `whatsapp_webhook_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `event_field` varchar(64) NOT NULL,
  `wamid` varchar(120) DEFAULT NULL,
  `delivery_status` varchar(20) DEFAULT NULL,
  `error_code` varchar(16) DEFAULT NULL,
  `error_title` varchar(255) DEFAULT NULL,
  `template_name` varchar(120) DEFAULT NULL,
  `template_event` varchar(64) DEFAULT NULL,
  `recipient` varchar(32) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_wa_hook_wamid` (`wamid`),
  KEY `idx_wa_hook_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
