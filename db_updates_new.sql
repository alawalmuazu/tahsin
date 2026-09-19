-- --------------------------------------------------------
-- Database Updates for Staff Registration System
-- --------------------------------------------------------

-- Add staff registration toggle and deadline to global_settings
ALTER TABLE `global_settings` 
ADD COLUMN IF NOT EXISTS `staff_registration_enabled` TINYINT(1) NOT NULL DEFAULT 1 AFTER `translation`,
ADD COLUMN IF NOT EXISTS `staff_registration_deadline` DATE NULL DEFAULT NULL AFTER `staff_registration_enabled`;

-- Note: The `staff` table already contains the `photo` column used for the headshot uploads.
-- No modifications are required for the `staff` table.
