-- Offline collection methods + destination Office Accounting account.
UPDATE `payment_types` SET `name` = 'Bank Transfer' WHERE `id` = 4;

INSERT INTO `transactions_links` (`status`, `deposit`, `expense`, `branch_id`)
SELECT 1, 1, 1, 1
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `transactions_links` WHERE `branch_id` = 1);

UPDATE `transactions_links`
SET `status` = 1,
    `deposit` = IFNULL(NULLIF(`deposit`, 0), 1),
    `expense` = IFNULL(NULLIF(`expense`, 0), 1)
WHERE `branch_id` = 1;
