-- Other name(s) sit between first name and surname.
ALTER TABLE `student`
  ADD COLUMN `other_name` varchar(255) DEFAULT NULL AFTER `first_name`;
