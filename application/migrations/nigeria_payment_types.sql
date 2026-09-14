-- Keep historical payment_types rows (ids 6–20) for old fee_payment_history.
-- Dropdowns only show ids 1–5. Default is Commercial Bank Account (id 4).
UPDATE `payment_types` SET `name` = 'Commercial Bank Account' WHERE `id` = 4;
UPDATE `payment_types` SET `name` = 'POS' WHERE `id` = 2;
UPDATE `payment_types` SET `name` = 'Cash' WHERE `id` = 1;
UPDATE `payment_types` SET `name` = 'Cheque' WHERE `id` = 3;
UPDATE `payment_types` SET `name` = 'Other' WHERE `id` = 5;
