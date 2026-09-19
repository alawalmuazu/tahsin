ALTER TABLE global_settings ADD COLUMN staff_registration_enabled TINYINT(1) NOT NULL DEFAULT 1;
ALTER TABLE global_settings ADD COLUMN staff_registration_deadline DATE DEFAULT NULL;
