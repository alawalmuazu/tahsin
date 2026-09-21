-- Strip duplicated Tarteel/Audio telemetry tags from akhlaq_note.
-- Safe to re-run. Leaves human prose intact; nulls pure-telemetry notes.
-- Requires MySQL 8+ / MariaDB 10.0.5+ (REGEXP_REPLACE).

-- Preview
SELECT id, student_id, surah_name, akhlaq_note AS before_note,
  NULLIF(TRIM(REGEXP_REPLACE(
    REGEXP_REPLACE(
      REGEXP_REPLACE(akhlaq_note,
        '[[:space:]]*\\[[^\\]]*Audio Attached[^\\]]*\\]', ''),
      '[[:space:]]*\\[[^\\]]*(Tarteel AI|Live ASR)[^\\]]*\\]', ''),
    '[[:space:]]{2,}', ' ')), '') AS after_note
FROM academy_tahfiz_record
WHERE akhlaq_note IS NOT NULL
  AND akhlaq_note REGEXP 'Audio Attached|Tarteel AI|Live ASR';

-- Apply
UPDATE academy_tahfiz_record
SET akhlaq_note = NULLIF(TRIM(REGEXP_REPLACE(
  REGEXP_REPLACE(
    REGEXP_REPLACE(akhlaq_note,
      '[[:space:]]*\\[[^\\]]*Audio Attached[^\\]]*\\]', ''),
    '[[:space:]]*\\[[^\\]]*(Tarteel AI|Live ASR)[^\\]]*\\]', ''),
  '[[:space:]]{2,}', ' ')), '')
WHERE akhlaq_note IS NOT NULL
  AND akhlaq_note REGEXP 'Audio Attached|Tarteel AI|Live ASR';
