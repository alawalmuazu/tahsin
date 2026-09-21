-- Recitation categories for halaqah milestones (Hifz Fauq/Taht, Talqeen, Murajaa, etc.)
-- Safe to re-run.

SET @rc := (
  SELECT COUNT(*) FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'academy_tahfiz_record'
    AND COLUMN_NAME = 'recitation_category'
);
SET @sql := IF(@rc = 0,
  'ALTER TABLE `academy_tahfiz_record` ADD COLUMN `recitation_category` VARCHAR(40) DEFAULT NULL COMMENT ''HIFZ_FAUQ|HIFZ_TAHT|TALQEEN|MURAJAA_QAREEBAH|MURAJAA_BAEEDAH|MUSAFFA|QIYAAMULLAIL'' AFTER `portion_mode`',
  'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
