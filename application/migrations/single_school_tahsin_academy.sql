-- =====================================================================
--  Collapse the Kaduna State multi-school platform into a single school
--  Tahsin Academy — Excellence In Deen & Duniya
--
--  Every table keeps its `branch_id` column, but the only legal value is
--  1 (SCHOOL_ID in application/config/constants.php). Rows belonging to
--  the other nine demo schools are removed, and the board-level shared
--  catalogue (branch_id 0/NULL) is adopted by the school.
-- =====================================================================

SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- 1. Keep the one teacher who has class allocations, then discard the
--    other schools' records.
-- ---------------------------------------------------------------------
UPDATE `staff` SET `branch_id` = 1 WHERE `id` = 2;

DELETE FROM `login_credential`
WHERE `role` NOT IN (6, 7)
  AND `user_id` IN (SELECT `id` FROM `staff` WHERE `branch_id` BETWEEN 2 AND 10);

-- Drop every row that belongs to schools 2-10
DELETE FROM `accounts` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `advance_salary` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `alumni_events` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `attachments` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `attachments_type` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `award` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `book` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `book_category` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `book_issues` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `bulk_msg_category` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `bulk_sms_email` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `call_log` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `call_purpose` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `card_templete` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `certificates_templete` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `class` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `complaint` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `complaint_type` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `custom_field` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `disable_reason` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `email_config` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `email_templates_details` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `enquiry` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `enquiry_reference` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `enquiry_response` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `enroll` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `event` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `event_types` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `exam` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `exam_attendance` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `exam_hall` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `exam_mark_distribution` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `exam_term` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `fee_allocation` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `fee_fine` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `fee_groups` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `fees_reminder` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `fees_type` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `front_cms_about` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `front_cms_admission` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `front_cms_admitcard` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `front_cms_certificates` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `front_cms_contact` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `front_cms_events` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `front_cms_exam_results` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `front_cms_faq` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `front_cms_faq_list` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `front_cms_gallery` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `front_cms_gallery_category` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `front_cms_gallery_content` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `front_cms_home` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `front_cms_home_seo` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `front_cms_menu` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `front_cms_menu_visible` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `front_cms_news` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `front_cms_news_list` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `front_cms_pages` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `front_cms_services` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `front_cms_services_list` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `front_cms_setting` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `front_cms_teachers` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `front_cms_testimonial` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `grade` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `hall_allocation` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `homework` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `hostel` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `hostel_category` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `hostel_room` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `leave_application` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `leave_category` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `live_class` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `live_class_config` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `login_log` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `mark` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `marksheet_template` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `modules_manage` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `offline_payment_types` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `online_admission` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `online_admission_fields` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `online_exam` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `parent` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `payment_config` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `payment_types` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `payslip` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `postal_record` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `product` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `product_category` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `product_issues` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `product_store` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `product_supplier` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `product_unit` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `purchase_bill` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `question_group` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `questions` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `salary_template` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `sales_bill` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `section` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `sms_credential` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `sms_template_details` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `staff` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `staff_attendance` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `staff_department` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `staff_designation` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `staff_posting_history` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `student_admission_fields` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `student_attendance` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `student_category` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `student_profile_fields` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `student_subject_attendance` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `subject` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `subject_assign` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `teacher_allocation` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `teacher_note` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `timetable_class` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `timetable_exam` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `transactions` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `transactions_links` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `transport_assign` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `transport_fee_fine` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `transport_route` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `transport_stoppage` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `transport_stoppage_point` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `transport_vehicle` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `visitor_log` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `visitor_purpose` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `voucher_head` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `whatsapp_agent` WHERE `branch_id` BETWEEN 2 AND 10;
DELETE FROM `whatsapp_chat` WHERE `branch_id` BETWEEN 2 AND 10;

-- ---------------------------------------------------------------------
-- 2. Adopt the shared curriculum: board-level rows used branch_id 0/NULL.
-- ---------------------------------------------------------------------
UPDATE `accounts` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `advance_salary` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `alumni_events` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `attachments` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `attachments_type` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `award` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `book` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `book_category` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `book_issues` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `bulk_msg_category` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `bulk_sms_email` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `call_log` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `call_purpose` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `card_templete` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `certificates_templete` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `class` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `complaint` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `complaint_type` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `custom_field` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `disable_reason` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `email_config` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `email_templates_details` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `enquiry` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `enquiry_reference` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `enquiry_response` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `enroll` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `event` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `event_types` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `exam` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `exam_attendance` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `exam_hall` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `exam_mark_distribution` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `exam_term` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `fee_allocation` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `fee_fine` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `fee_groups` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `fees_reminder` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `fees_type` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `front_cms_about` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `front_cms_admission` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `front_cms_admitcard` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `front_cms_certificates` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `front_cms_contact` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `front_cms_events` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `front_cms_exam_results` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `front_cms_faq` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `front_cms_faq_list` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `front_cms_gallery` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `front_cms_gallery_category` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `front_cms_gallery_content` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `front_cms_home` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `front_cms_home_seo` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `front_cms_menu` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `front_cms_menu_visible` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `front_cms_news` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `front_cms_news_list` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `front_cms_pages` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `front_cms_services` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `front_cms_services_list` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `front_cms_setting` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `front_cms_teachers` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `front_cms_testimonial` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `grade` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `hall_allocation` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `homework` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `hostel` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `hostel_category` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `hostel_room` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `leave_application` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `leave_category` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `live_class` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `live_class_config` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `login_log` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `mark` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `marksheet_template` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `modules_manage` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `offline_payment_types` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `online_admission` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `online_admission_fields` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `online_exam` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `parent` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `payment_config` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `payment_types` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `payslip` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `postal_record` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `product` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `product_category` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `product_issues` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `product_store` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `product_supplier` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `product_unit` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `purchase_bill` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `question_group` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `questions` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `salary_template` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `sales_bill` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `section` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `sms_credential` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `sms_template_details` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `staff` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `staff_attendance` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `staff_department` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `staff_designation` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `staff_posting_history` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `student_admission_fields` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `student_attendance` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `student_category` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `student_profile_fields` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `student_subject_attendance` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `subject` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `subject_assign` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `teacher_allocation` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `teacher_note` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `timetable_class` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `timetable_exam` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `transactions` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `transactions_links` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `transport_assign` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `transport_fee_fine` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `transport_route` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `transport_stoppage` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `transport_stoppage_point` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `transport_vehicle` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `visitor_log` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `visitor_purpose` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `voucher_head` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `whatsapp_agent` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;
UPDATE `whatsapp_chat` SET `branch_id` = 1 WHERE `branch_id` IS NULL OR `branch_id` = 0;

-- ---------------------------------------------------------------------
-- 3. Merge the duplicates that existed only because two exam boards each
--    carried their own copy of the catalogue.
-- ---------------------------------------------------------------------

-- Align the school's ad-hoc subject names with the national curriculum so
-- they collapse onto the same rows instead of sitting beside them.
UPDATE `subject` SET `name` = 'English Language' WHERE `id` = 1;
UPDATE `subject` SET `name` = 'Mathematics'      WHERE `id` = 2;
UPDATE `subject` SET `name` = 'Computer Studies' WHERE `id` = 3;

-- Repoint references onto the surviving (lowest-id) subject of each name.
UPDATE `subject_assign`  sa JOIN `subject` s ON s.id = sa.subject_id
   JOIN (SELECT MIN(id) id, name FROM `subject` GROUP BY name) k ON k.name = s.name
   SET sa.subject_id = k.id;
UPDATE `timetable_class` tc JOIN `subject` s ON s.id = tc.subject_id
   JOIN (SELECT MIN(id) id, name FROM `subject` GROUP BY name) k ON k.name = s.name
   SET tc.subject_id = k.id;
UPDATE `mark` m JOIN `subject` s ON s.id = m.subject_id
   JOIN (SELECT MIN(id) id, name FROM `subject` GROUP BY name) k ON k.name = s.name
   SET m.subject_id = k.id;
DELETE FROM `subject` WHERE `id` NOT IN (SELECT id FROM (SELECT MIN(id) id FROM `subject` GROUP BY name) k);

-- One set of terms, not one per board.
UPDATE `exam` e JOIN `exam_term` t ON t.id = e.term_id
   JOIN (SELECT MIN(id) id, name FROM `exam_term` GROUP BY name) k ON k.name = t.name
   SET e.term_id = k.id;
DELETE FROM `exam_term` WHERE `id` NOT IN (SELECT id FROM (SELECT MIN(id) id FROM `exam_term` GROUP BY name) k);

-- Sections: the school's own A-D / Sci / Art / Com list supersedes the board copies.
DELETE FROM `section` WHERE `id` > 10;

-- Grades: keep the single WAEC/NECO scale (A1-F9). The coarse A-F scale
-- overlapped the same mark ranges and made grade lookup ambiguous.
DELETE FROM `grade` WHERE `name` IN ('A','B','C','D','E','F');
DELETE FROM `grade` WHERE `id` NOT IN (SELECT id FROM (SELECT MIN(id) id FROM `grade` GROUP BY name) k);

-- Remaining catalogues: collapse identical names.
DELETE FROM `book_category` WHERE `id` NOT IN (SELECT id FROM (SELECT MIN(id) id FROM `book_category` GROUP BY name) k);
DELETE FROM `complaint_type` WHERE `id` NOT IN (SELECT id FROM (SELECT MIN(id) id FROM `complaint_type` GROUP BY name) k);
DELETE FROM `event_types` WHERE `id` NOT IN (SELECT id FROM (SELECT MIN(id) id FROM `event_types` GROUP BY name) k);
DELETE FROM `fees_type` WHERE `id` NOT IN (SELECT id FROM (SELECT MIN(id) id FROM `fees_type` GROUP BY name) k);
DELETE FROM `hostel_category` WHERE `id` NOT IN (SELECT id FROM (SELECT MIN(id) id FROM `hostel_category` GROUP BY name) k);
DELETE FROM `leave_category` WHERE `id` NOT IN (SELECT id FROM (SELECT MIN(id) id FROM `leave_category` GROUP BY name) k);
DELETE FROM `staff_department` WHERE `id` NOT IN (SELECT id FROM (SELECT MIN(id) id FROM `staff_department` GROUP BY name) k);
DELETE FROM `staff_designation` WHERE `id` NOT IN (SELECT id FROM (SELECT MIN(id) id FROM `staff_designation` GROUP BY name) k);
DELETE FROM `student_category` WHERE `id` NOT IN (SELECT id FROM (SELECT MIN(id) id FROM `student_category` GROUP BY name) k);
DELETE FROM `product_category` WHERE `id` NOT IN (SELECT id FROM (SELECT MIN(id) id FROM `product_category` GROUP BY name) k);
DELETE FROM `product_unit` WHERE `id` NOT IN (SELECT id FROM (SELECT MIN(id) id FROM `product_unit` GROUP BY name) k);
DELETE FROM `product_store` WHERE `id` NOT IN (SELECT id FROM (SELECT MIN(id) id FROM `product_store` GROUP BY name) k);
DELETE FROM `product_supplier` WHERE `id` NOT IN (SELECT id FROM (SELECT MIN(id) id FROM `product_supplier` GROUP BY name) k);

-- Module on/off switches were stored per school, so collapsing the branches
-- leaves several rows voting on the same module. Keep the lowest id.
DELETE mm FROM `modules_manage` mm
    INNER JOIN `modules_manage` keep
        ON keep.modules_id = mm.modules_id
       AND keep.branch_id  = mm.branch_id
       AND keep.id < mm.id;

-- ---------------------------------------------------------------------
-- 4. There is only one school row.
-- ---------------------------------------------------------------------
DELETE FROM `branch` WHERE `id` <> 1;

UPDATE `branch` SET
    `name`        = 'Tahsin Academy',
    `school_name` = 'Tahsin Academy',
    `email`       = 'info@tahsinacademy.edu.ng',
    `address`     = ''
WHERE `id` = 1;

UPDATE `global_settings` SET
    `institute_name` = 'Tahsin Academy',
    `footer_text`    = CONCAT('© ', YEAR(CURDATE()), ' Tahsin Academy')
WHERE `id` = 1;

UPDATE `front_cms_setting` SET
    `branch_id`         = 1,
    `application_title` = 'Tahsin Academy',
    `copyright_text`    = CONCAT('© ', YEAR(CURDATE()), ' Tahsin Academy'),
    `online_admission`  = 1;

-- ---------------------------------------------------------------------
-- 5. Remove the state-government role tier.
-- ---------------------------------------------------------------------
DELETE FROM `staff_privileges` WHERE `role_id` IN (SELECT `id` FROM `roles` WHERE `is_statewide` = 1);
DELETE FROM `roles` WHERE `is_statewide` = 1;

-- ---------------------------------------------------------------------
-- 6. Drop the state-government feature tables and their permissions.
-- ---------------------------------------------------------------------
DELETE FROM `permission` WHERE `module_id` IN
    (SELECT `id` FROM `permission_modules` WHERE `name` IN ('teacher_transfer','school_inspection','infrastructure'));
DELETE FROM `permission_modules` WHERE `name` IN ('teacher_transfer','school_inspection','infrastructure');

DROP TABLE IF EXISTS `inspection_deficiencies`;
DROP TABLE IF EXISTS `school_inspections`;
DROP TABLE IF EXISTS `teacher_transfers`;
DROP TABLE IF EXISTS `infrastructure`;
DROP TABLE IF EXISTS `education_board`;

-- ---------------------------------------------------------------------
-- 7. Drop the columns that only made sense across many schools.
-- ---------------------------------------------------------------------
ALTER TABLE `book_category` DROP COLUMN `board_id`;
ALTER TABLE `class` DROP COLUMN `board_id`;
ALTER TABLE `complaint_type` DROP COLUMN `board_id`;
ALTER TABLE `event_types` DROP COLUMN `board_id`;
ALTER TABLE `exam_term` DROP COLUMN `board_id`;
ALTER TABLE `fees_type` DROP COLUMN `board_id`;
ALTER TABLE `grade` DROP COLUMN `board_id`;
ALTER TABLE `hostel_category` DROP COLUMN `board_id`;
ALTER TABLE `leave_category` DROP COLUMN `board_id`;
ALTER TABLE `section` DROP COLUMN `board_id`;
ALTER TABLE `staff_department` DROP COLUMN `board_id`;
ALTER TABLE `staff_designation` DROP COLUMN `board_id`;
ALTER TABLE `student_category` DROP COLUMN `board_id`;
ALTER TABLE `subject` DROP COLUMN `board_id`;
ALTER TABLE `branch` DROP COLUMN `lga`, DROP COLUMN `ward`, DROP COLUMN `state`;
ALTER TABLE `roles`  DROP COLUMN `is_statewide`;
ALTER TABLE `global_settings` DROP COLUMN `cms_default_branch`, DROP COLUMN `footer_branch_switcher`;
ALTER TABLE `student` CHANGE `state_student_id` `state_student_id` VARCHAR(25) DEFAULT NULL COMMENT 'Auto-generated Tahsin Academy student ID';

-- ---------------------------------------------------------------------
-- 8. Wording: a branch is now simply the school.
-- ---------------------------------------------------------------------
DELETE FROM `languages` WHERE `word` IN ('lga','select_or_statewide','all_branches','all_branch_dashboard','branch_list','create_branch','edit_branch','cms_default_branch');
UPDATE `languages` SET `english` = 'Tahsin Academy'         WHERE `word` = 'branch';
UPDATE `languages` SET `english` = 'School Name'            WHERE `word` = 'branch_name';
UPDATE `languages` SET `english` = 'Dashboard'              WHERE `word` = 'branch_dashboard';
-- still used as a generic "nothing chosen yet" placeholder in dependent dropdowns
UPDATE `languages` SET `english` = 'Make A Selection First' WHERE `word` = 'select_branch_first';

-- ---------------------------------------------------------------------
-- 9. Unrelated pre-existing bug, fixed while we were in here.
--
-- Employee_model writes these three fields and the CSV export reads them,
-- but the columns were never added to `staff`, so saving an employee failed
-- with "Unknown column" and the profile page warned on every load.
-- ---------------------------------------------------------------------
ALTER TABLE `staff`
    ADD COLUMN `next_of_kin_name`     VARCHAR(200) NULL DEFAULT NULL,
    ADD COLUMN `next_of_kin_phone`    VARCHAR(50)  NULL DEFAULT NULL,
    ADD COLUMN `next_of_kin_relation` VARCHAR(100) NULL DEFAULT NULL;

-- ---------------------------------------------------------------------
-- 10. Tuition fee type + session group so admission can record payment
--     including mode of payment (Cash, Bank Transfer, etc.).
-- ---------------------------------------------------------------------
INSERT INTO `fees_type` (`name`, `fee_code`, `description`, `branch_id`, `system`)
SELECT 'Tuition', 'tuition', 'Termly tuition fee', 1, 0
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `fees_type` WHERE `name` = 'Tuition' AND `branch_id` = 1);

INSERT INTO `fee_groups` (`name`, `description`, `session_id`, `system`, `branch_id`)
SELECT 'Tuition', 'Tuition fee for the academic session', gs.session_id, 0, 1
FROM `global_settings` gs
WHERE NOT EXISTS (
    SELECT 1 FROM `fee_groups` g
    WHERE g.name = 'Tuition' AND g.branch_id = 1 AND g.session_id = gs.session_id
);

INSERT INTO `fee_groups_details` (`fee_groups_id`, `fee_type_id`, `amount`, `due_date`)
SELECT g.id, t.id, 0, DATE_ADD(CURDATE(), INTERVAL 30 DAY)
FROM `fee_groups` g
INNER JOIN `fees_type` t ON t.name = 'Tuition' AND t.branch_id = 1
WHERE g.name = 'Tuition' AND g.branch_id = 1
  AND NOT EXISTS (
      SELECT 1 FROM `fee_groups_details` d
      WHERE d.fee_groups_id = g.id AND d.fee_type_id = t.id
  );

SET FOREIGN_KEY_CHECKS = 1;

