-- Make guardian Occupation / Income / Education optional on admission (safe to re-run).

UPDATE `student_fields`
SET `default_required` = 0
WHERE `prefix` IN ('guardian_occupation', 'guardian_income', 'guardian_education');

UPDATE `student_admission_fields` saf
INNER JOIN `student_fields` sf ON sf.id = saf.fields_id
SET saf.`required` = 0
WHERE sf.`prefix` IN ('guardian_occupation', 'guardian_income', 'guardian_education');

-- Keep online admission / profile in sync if those tables exist
UPDATE `online_admission_fields` oaf
INNER JOIN `student_fields` sf ON sf.id = oaf.fields_id AND oaf.system = 1
SET oaf.`required` = 0
WHERE sf.`prefix` IN ('guardian_occupation', 'guardian_income', 'guardian_education');

UPDATE `student_profile_fields` spf
INNER JOIN `student_fields` sf ON sf.id = spf.fields_id
SET spf.`required` = 0
WHERE sf.`prefix` IN ('guardian_occupation', 'guardian_income', 'guardian_education');
