-- Grant full School Fees & Student Accounting permissions to the Receptionist role.
-- Safe to re-run.

SET @role_id := (SELECT `id` FROM `roles` WHERE `prefix` = 'receptionist' OR `name` = 'Receptionist' LIMIT 1);

-- Ensure permission 'school_fees' exists in permission table if used in code
INSERT INTO `permission` (`module_id`, `name`, `prefix`, `show_view`, `show_add`, `show_edit`, `show_delete`)
SELECT 1, 'School Fees', 'school_fees', 1, 1, 1, 0 FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `permission` WHERE `prefix` = 'school_fees');

-- Delete any existing fee permissions for receptionist to avoid duplicates
DELETE FROM `staff_privileges`
WHERE `role_id` = @role_id
AND `permission_id` IN (
    SELECT `id` FROM `permission` WHERE `prefix` IN (
        'fees_type',
        'fees_group',
        'fees_fine_setup',
        'fees_allocation',
        'collect_fees',
        'fees_reminder',
        'due_invoice',
        'invoice',
        'annual_student_fees_summary_chart',
        'fees_reports',
        'offline_payments',
        'offline_payments_type',
        'transport_fees_setup',
        'school_fees'
    )
);

-- 1. Fees Type
INSERT INTO `staff_privileges` (`role_id`, `permission_id`, `is_add`, `is_edit`, `is_view`, `is_delete`)
SELECT @role_id, `id`, 1, 1, 1, 0 FROM `permission` WHERE `prefix` = 'fees_type';

-- 2. Fees Group
INSERT INTO `staff_privileges` (`role_id`, `permission_id`, `is_add`, `is_edit`, `is_view`, `is_delete`)
SELECT @role_id, `id`, 1, 1, 1, 0 FROM `permission` WHERE `prefix` = 'fees_group';

-- 3. Fees Fine Setup
INSERT INTO `staff_privileges` (`role_id`, `permission_id`, `is_add`, `is_edit`, `is_view`, `is_delete`)
SELECT @role_id, `id`, 1, 1, 1, 0 FROM `permission` WHERE `prefix` = 'fees_fine_setup';

-- 4. Fees Allocation
INSERT INTO `staff_privileges` (`role_id`, `permission_id`, `is_add`, `is_edit`, `is_view`, `is_delete`)
SELECT @role_id, `id`, 1, 1, 1, 0 FROM `permission` WHERE `prefix` = 'fees_allocation';

-- 5. Collect Fees (Record payments at front desk)
INSERT INTO `staff_privileges` (`role_id`, `permission_id`, `is_add`, `is_edit`, `is_view`, `is_delete`)
SELECT @role_id, `id`, 1, 0, 1, 0 FROM `permission` WHERE `prefix` = 'collect_fees';

-- 6. Fees Reminder
INSERT INTO `staff_privileges` (`role_id`, `permission_id`, `is_add`, `is_edit`, `is_view`, `is_delete`)
SELECT @role_id, `id`, 1, 1, 1, 0 FROM `permission` WHERE `prefix` = 'fees_reminder';

-- 7. Due Invoice (Unpaid & balance lists)
INSERT INTO `staff_privileges` (`role_id`, `permission_id`, `is_add`, `is_edit`, `is_view`, `is_delete`)
SELECT @role_id, `id`, 0, 0, 1, 0 FROM `permission` WHERE `prefix` = 'due_invoice';

-- 8. Invoice (Payments history & receipts)
INSERT INTO `staff_privileges` (`role_id`, `permission_id`, `is_add`, `is_edit`, `is_view`, `is_delete`)
SELECT @role_id, `id`, 0, 0, 1, 0 FROM `permission` WHERE `prefix` = 'invoice';

-- 9. Fees Summary Chart
INSERT INTO `staff_privileges` (`role_id`, `permission_id`, `is_add`, `is_edit`, `is_view`, `is_delete`)
SELECT @role_id, `id`, 0, 0, 1, 0 FROM `permission` WHERE `prefix` = 'annual_student_fees_summary_chart';

-- 10. Fees Reports
INSERT INTO `staff_privileges` (`role_id`, `permission_id`, `is_add`, `is_edit`, `is_view`, `is_delete`)
SELECT @role_id, `id`, 0, 0, 1, 0 FROM `permission` WHERE `prefix` = 'fees_reports';

-- 11. Offline Payments (Bank transfers & deposits)
INSERT INTO `staff_privileges` (`role_id`, `permission_id`, `is_add`, `is_edit`, `is_view`, `is_delete`)
SELECT @role_id, `id`, 0, 0, 1, 0 FROM `permission` WHERE `prefix` = 'offline_payments';

-- 12. Offline Payments Type
INSERT INTO `staff_privileges` (`role_id`, `permission_id`, `is_add`, `is_edit`, `is_view`, `is_delete`)
SELECT @role_id, `id`, 1, 1, 1, 0 FROM `permission` WHERE `prefix` = 'offline_payments_type';

-- 13. Transport Fees Setup
INSERT INTO `staff_privileges` (`role_id`, `permission_id`, `is_add`, `is_edit`, `is_view`, `is_delete`)
SELECT @role_id, `id`, 1, 1, 1, 0 FROM `permission` WHERE `prefix` = 'transport_fees_setup';

-- 14. School Fees Settings (Pricing matrix)
INSERT INTO `staff_privileges` (`role_id`, `permission_id`, `is_add`, `is_edit`, `is_view`, `is_delete`)
SELECT @role_id, `id`, 0, 1, 1, 0 FROM `permission` WHERE `prefix` = 'school_fees';
