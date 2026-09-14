-- Portal login is off by default. First successful login must change password.
ALTER TABLE `login_credential`
  ADD COLUMN `must_change_password` TINYINT(1) NOT NULL DEFAULT 0 AFTER `active`;
