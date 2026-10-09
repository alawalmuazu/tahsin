-- Wipe ALL students + parents and related learner data.
-- Next student register no = TA-00001, next parent id = 1.
-- Run on Hostinger phpMyAdmin (production). IRREVERSIBLE.

SET FOREIGN_KEY_CHECKS = 0;

-- Fees / payments tied to enrollments
DELETE FROM `fee_payment_history`;
DELETE FROM `fee_allocation`;
DELETE FROM `offline_fees_payments`;
DELETE FROM `transport_fee_details`;

-- Academic / attendance / homework / marks
DELETE FROM `student_documents`;
DELETE FROM `student_attendance`;
DELETE FROM `student_subject_attendance`;
DELETE FROM `homework_submit`;
DELETE FROM `homework_evaluation`;
DELETE FROM `mark`;
DELETE FROM `exam_attendance`;
DELETE FROM `online_exam_answer`;
DELETE FROM `online_exam_attempts`;
DELETE FROM `online_exam_submitted`;
DELETE FROM `online_exam_payment`;

-- Custom field values linked to students / parents
DELETE cfv FROM `custom_fields_values` cfv
INNER JOIN `custom_field` cf ON cf.id = cfv.field_id
WHERE cf.form_to IN ('student', 'parent', 'guardian');

-- Enrollments & online applications
DELETE FROM `enroll`;
DELETE FROM `online_admission`;
DELETE FROM `alumni_students`;

-- Portal logins for students (7) and parents (6)
DELETE FROM `login_credential` WHERE `role` IN (6, 7);

-- Core records
DELETE FROM `student`;
DELETE FROM `parent`;

-- Reset auto-increment so next IDs start at 1
ALTER TABLE `student` AUTO_INCREMENT = 1;
ALTER TABLE `parent` AUTO_INCREMENT = 1;
ALTER TABLE `enroll` AUTO_INCREMENT = 1;
ALTER TABLE `fee_allocation` AUTO_INCREMENT = 1;
ALTER TABLE `fee_payment_history` AUTO_INCREMENT = 1;
ALTER TABLE `student_documents` AUTO_INCREMENT = 1;
ALTER TABLE `transport_fee_details` AUTO_INCREMENT = 1;
ALTER TABLE `offline_fees_payments` AUTO_INCREMENT = 1;

-- Ensure register-number prefix produces TA-00001
UPDATE `branch`
SET `reg_prefix_enable` = 1,
    `institution_code` = 'TA-',
    `reg_start_from` = 1,
    `reg_prefix_digit` = 5
WHERE `id` = 1;

SET FOREIGN_KEY_CHECKS = 1;

-- Verify (expect zeros / auto_increment 1)
SELECT
  (SELECT COUNT(*) FROM `student`) AS students,
  (SELECT COUNT(*) FROM `parent`) AS parents,
  (SELECT COUNT(*) FROM `enroll`) AS enrolls,
  (SELECT COUNT(*) FROM `login_credential` WHERE role IN (6, 7)) AS learner_logins;
