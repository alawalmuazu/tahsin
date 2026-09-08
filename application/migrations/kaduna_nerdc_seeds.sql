-- =============================================================
-- SmartSchool Kaduna State: NERDC + Gap Feature Seeds
-- Run once against the `smartschool` database
-- =============================================================

-- -------------------------------------------------------
-- 1. NERDC MARK DISTRIBUTIONS
--    Seed "CA Score" and "Exam Score" for ALL 10 branches
--    (existing branches 1-10)
-- -------------------------------------------------------
-- Remove the old non-NERDC distributions from branch 1 only
-- (Practical, Attendance, Written) - comment out if you wish to keep them
-- DELETE FROM exam_mark_distribution WHERE branch_id = 1 AND name IN ('Practical','Attendance','Written');

-- Insert CA Score (40 marks) + Exam Score (60 marks) per branch
INSERT IGNORE INTO exam_mark_distribution (name, branch_id) VALUES
('CA Score',   1), ('Exam Score',   1),
('CA Score',   2), ('Exam Score',   2),
('CA Score',   3), ('Exam Score',   3),
('CA Score',   4), ('Exam Score',   4),
('CA Score',   5), ('Exam Score',   5),
('CA Score',   6), ('Exam Score',   6),
('CA Score',   7), ('Exam Score',   7),
('CA Score',   8), ('Exam Score',   8),
('CA Score',   9), ('Exam Score',   9),
('CA Score',  10), ('Exam Score',  10);

-- -------------------------------------------------------
-- 2. GRADE SCALE CORRECTIONS
--    Secondary (board_id=2): A1-F9 is ALREADY correct.
--    Primary (board_id=1): Update to Federal Primary standard
--    A=75-100, B=60-74, C=50-59, D=40-49, F=0-39
-- -------------------------------------------------------
UPDATE grade SET lower_mark = 75, upper_mark = 100, remark = 'Distinction',  grade_point = 5.0 WHERE name = 'A' AND board_id = 1;
UPDATE grade SET lower_mark = 60, upper_mark = 74,  remark = 'Credit',       grade_point = 4.0 WHERE name = 'B' AND board_id = 1;
UPDATE grade SET lower_mark = 50, upper_mark = 59,  remark = 'Merit',        grade_point = 3.0 WHERE name = 'C' AND board_id = 1;
UPDATE grade SET lower_mark = 40, upper_mark = 49,  remark = 'Pass',         grade_point = 2.0 WHERE name = 'D' AND board_id = 1;
UPDATE grade SET lower_mark = 0,  upper_mark = 39,  remark = 'Fail',         grade_point = 0.0 WHERE name = 'F' AND board_id = 1;

-- Remove unused 'E' grade for primary if it exists
-- DELETE FROM grade WHERE name = 'E' AND board_id = 1;

-- -------------------------------------------------------
-- 3. INVENTORY: STATE-LEVEL LEARNING MATERIALS CATEGORIES
--    branch_id = 0 = owned by State/Superadmin,
--    visible to all schools
-- -------------------------------------------------------
INSERT IGNORE INTO product_category (name, branch_id) VALUES
('Textbooks',                0),
('Exercise Books',           0),
('Uniforms',                 0),
('School Feeding Supplies',  0),
('Stationery',               0);

INSERT IGNORE INTO product_store (name, code, branch_id) VALUES
('State Learning Materials Store', 'SLMS-STATE', 0);

-- -------------------------------------------------------
-- 4. INVENTORY: STATE-LEVEL SCHOOL INFRASTRUCTURE CATEGORIES
-- -------------------------------------------------------
INSERT IGNORE INTO product_category (name, branch_id) VALUES
('Classrooms',          0),
('Science Labs',        0),
('Toilets & Sanitation',0),
('Library',             0),
('ICT / Computers',     0),
('Furniture & Fittings',0),
('Water Supply',        0);

INSERT IGNORE INTO product_store (name, code, branch_id) VALUES
('State Infrastructure Register', 'SIR-STATE', 0);

-- -------------------------------------------------------
-- 5. STUDENT NIN + STATE STUDENT ID COLUMNS
-- -------------------------------------------------------
ALTER TABLE student
    ADD COLUMN IF NOT EXISTS nin VARCHAR(11) NULL COMMENT 'National Identification Number (NIN)' AFTER register_no,
    ADD COLUMN IF NOT EXISTS state_student_id VARCHAR(25) NULL COMMENT 'Auto-generated Kaduna State Student ID' AFTER nin;

-- Add unique index (ignore if already exists)
ALTER TABLE student ADD UNIQUE INDEX IF NOT EXISTS idx_state_student_id (state_student_id);

-- -------------------------------------------------------
-- 6. NEMIS REPORTING: No table changes required —
--    Reports run against existing student/staff/branch tables
-- -------------------------------------------------------
SELECT 'Seeds applied successfully.' as status;
