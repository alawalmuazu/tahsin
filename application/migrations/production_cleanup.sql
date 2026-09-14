-- Production cleanup for Tahsin Academy
-- Keeps: school identity, academic programmes, staff logins, Access Bank collection account
-- Removes: save-check leftovers, demo learner accounts, dummy contact copy

SET FOREIGN_KEY_CHECKS = 0;

DELETE FROM accounts WHERE name LIKE 'Save %' OR name LIKE '%178940%';
DELETE FROM student_category WHERE name LIKE 'Save %' OR name LIKE '%178940%';
DELETE FROM sections_allocation WHERE section_id IN (SELECT id FROM section WHERE name LIKE 'Save %' OR name LIKE '%178940%');
DELETE FROM section WHERE name LIKE 'Save %' OR name LIKE '%178940%';
DELETE FROM voucher_head WHERE name LIKE 'Save %' OR name LIKE '%178940%';
DELETE FROM product_unit WHERE name LIKE 'Save %' OR name LIKE '%178940%';

DELETE FROM fee_payment_history;
DELETE FROM fee_allocation;
DELETE FROM student_documents;
DELETE FROM student_attendance;
DELETE FROM student_subject_attendance;
DELETE FROM homework_submit;
DELETE FROM homework_evaluation;
DELETE FROM mark;
DELETE FROM exam_attendance;
DELETE FROM enroll;
DELETE FROM online_admission;
DELETE FROM login_credential WHERE role IN (6, 7);
DELETE FROM student;
DELETE FROM parent;

SET FOREIGN_KEY_CHECKS = 1;

UPDATE branch
SET mobileno = ''
WHERE mobileno IN ('08022332233', '+12345678') OR mobileno LIKE '%123456%';

UPDATE global_settings
SET institute_email = 'info@tahsinacademy.edu.ng',
    footer_text = CONCAT('© ', YEAR(CURDATE()), ' Tahsin Academy')
WHERE institute_email LIKE '%gmail.com%' OR institute_email LIKE '%jamilusalis%';

UPDATE front_cms_setting
SET application_title = 'Tahsin Academy',
    email = 'info@tahsinacademy.edu.ng',
    receive_contact_email = 'info@tahsinacademy.edu.ng',
    mobile_no = '',
    url_alias = '',
    footer_about_text = 'Tahsin Academy — Excellence In Deen & Duniya. Nurturing future leaders through authentic Islamic values, Quranic memorization, and a rigorous academic path.',
    copyright_text = CONCAT('© ', YEAR(CURDATE()), ' Tahsin Academy. All rights reserved.')
WHERE branch_id = 1;

UPDATE front_cms_home SET title = 'Welcome To Tahsin Academy', description = 'Excellence In Deen & Duniya — a school where Quranic memorization, sound character, and academic excellence grow together.' WHERE item_type = 'wellcome' AND branch_id = 1;
UPDATE front_cms_home SET title = 'Teachers Who Form Character', description = 'Our teachers combine scholarship in the deen with the patience and discipline of a strong classroom.' WHERE item_type = 'teachers' AND branch_id = 1;
UPDATE front_cms_home SET title = 'Why Families Choose Tahsin', description = 'Boarding, Day and Weekend tracks. Quran with or without technical skills. One academy, two worlds held together.' WHERE item_type = 'services' AND branch_id = 1;
UPDATE front_cms_home SET title = 'A Place Of Knowledge', description = 'Certified teachers, enrolled students, structured programmes, and a community built around the Quran.' WHERE item_type = 'statistics' AND branch_id = 1;
UPDATE front_cms_home SET title = 'What Families Say' WHERE item_type = 'testimonial' AND branch_id = 1;
UPDATE front_cms_home SET title = 'Library & Learning' WHERE title LIKE '%Liberary%';

UPDATE front_cms_home_seo
SET page_title = 'Home',
    meta_keyword = 'Tahsin Academy, Islamic school Nigeria, Tahfeez, Quran memorization, boarding school',
    meta_description = 'Tahsin Academy — Excellence in Deen and Duniya. Boarding, Day and Weekend programmes combining Quranic memorization with a rigorous academic path.'
WHERE branch_id = 1;
