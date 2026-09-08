-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 08, 2026 at 02:03 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smartschool`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `balance` double(18,2) NOT NULL DEFAULT 0.00,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `name`, `number`, `description`, `balance`, `branch_id`, `created_at`, `updated_at`) VALUES
(1, 'Main Account', '0123456789', '', 0.00, 1, '2026-03-27 09:45:42', '2026-03-27 10:45:42');

-- --------------------------------------------------------

--
-- Table structure for table `addon`
--

CREATE TABLE `addon` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `prefix` varchar(255) NOT NULL,
  `version` varchar(100) NOT NULL,
  `purchase_code` varchar(255) DEFAULT NULL,
  `items_code` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `last_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `advance_salary`
--

CREATE TABLE `advance_salary` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `deduct_month` varchar(20) DEFAULT NULL,
  `year` varchar(20) NOT NULL,
  `reason` text CHARACTER SET utf32 COLLATE utf32_unicode_ci DEFAULT NULL,
  `request_date` datetime DEFAULT NULL,
  `paid_date` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=pending,2=paid,3=rejected',
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `issued_by` varchar(200) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `branch_id` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `alumni_events`
--

CREATE TABLE `alumni_events` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `audience` varchar(100) NOT NULL,
  `session_id` int(11) DEFAULT NULL,
  `selected_list` longtext NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `note` text NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `show_web` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `alumni_students`
--

CREATE TABLE `alumni_students` (
  `id` int(11) NOT NULL,
  `enroll_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile_no` varchar(255) NOT NULL,
  `address` varchar(500) NOT NULL,
  `profession` varchar(255) NOT NULL,
  `photo` varchar(500) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE `attachments` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `remarks` text NOT NULL,
  `type_id` int(11) NOT NULL,
  `uploader_id` varchar(20) NOT NULL,
  `class_id` varchar(20) DEFAULT 'unfiltered',
  `file_name` varchar(255) NOT NULL,
  `enc_name` varchar(255) NOT NULL,
  `subject_id` varchar(200) DEFAULT 'unfiltered',
  `session_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attachments_type`
--

CREATE TABLE `attachments_type` (
  `id` int(11) NOT NULL,
  `name` longtext NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `attachments_type`
--

INSERT INTO `attachments_type` (`id`, `name`, `branch_id`, `created_at`, `updated_at`) VALUES
(1, 'Note', 1, '2026-03-27 08:05:30', NULL),
(2, 'Assignment', 1, '2026-03-27 08:05:36', NULL),
(3, 'Daily Activity', 1, '2026-03-27 08:05:42', NULL),
(4, 'Hand Book', 1, '2026-03-27 08:05:48', NULL),
(5, 'Syllabus', 1, '2026-03-27 08:05:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `award`
--

CREATE TABLE `award` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `gift_item` varchar(255) NOT NULL,
  `award_amount` decimal(18,2) NOT NULL,
  `award_reason` text NOT NULL,
  `given_date` date NOT NULL,
  `session_id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `author` varchar(255) NOT NULL,
  `isbn_no` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `publisher` varchar(255) NOT NULL,
  `edition` varchar(255) NOT NULL,
  `purchase_date` date NOT NULL,
  `description` text NOT NULL,
  `price` decimal(18,2) NOT NULL,
  `total_stock` varchar(20) NOT NULL,
  `issued_copies` varchar(20) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `book_category`
--

CREATE TABLE `book_category` (
  `id` int(11) NOT NULL,
  `name` longtext NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `board_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `book_category`
--

INSERT INTO `book_category` (`id`, `name`, `branch_id`, `board_id`) VALUES
(1, 'History', 1, NULL),
(2, 'Science', 1, NULL),
(3, 'Programming', 1, NULL),
(4, 'Drawing', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `book_issues`
--

CREATE TABLE `book_issues` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `date_of_issue` date DEFAULT NULL,
  `date_of_expiry` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `fine_amount` decimal(18,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = pending, 1 = accepted, 2 = rejected, 3 = returned',
  `issued_by` varchar(255) DEFAULT NULL,
  `return_by` int(11) DEFAULT NULL,
  `session_id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `id` int(11) NOT NULL,
  `board_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `school_name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobileno` varchar(100) NOT NULL,
  `currency` varchar(100) NOT NULL,
  `symbol` varchar(25) NOT NULL,
  `currency_formats` tinyint(4) NOT NULL DEFAULT 1,
  `symbol_position` tinyint(4) NOT NULL DEFAULT 1,
  `lga` varchar(255) DEFAULT NULL,
  `ward` varchar(255) DEFAULT NULL,
  `state` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `stu_generate` tinyint(4) NOT NULL DEFAULT 0,
  `stu_username_prefix` varchar(255) NOT NULL,
  `stu_default_password` varchar(255) NOT NULL,
  `grd_generate` tinyint(4) NOT NULL DEFAULT 0,
  `grd_username_prefix` varchar(255) NOT NULL,
  `grd_default_password` varchar(255) NOT NULL,
  `teacher_restricted` tinyint(1) DEFAULT 1,
  `due_days` float NOT NULL DEFAULT 30,
  `due_with_fine` tinyint(4) NOT NULL DEFAULT 1,
  `translation` varchar(255) NOT NULL DEFAULT 'english',
  `timezone` varchar(255) NOT NULL,
  `weekends` varchar(255) NOT NULL DEFAULT '1',
  `reg_prefix_enable` tinyint(1) NOT NULL DEFAULT 0,
  `student_login` tinyint(4) NOT NULL DEFAULT 1,
  `parent_login` tinyint(4) NOT NULL DEFAULT 1,
  `teacher_mobile_visible` tinyint(4) NOT NULL DEFAULT 1,
  `teacher_email_visible` tinyint(4) NOT NULL DEFAULT 1,
  `reg_start_from` tinyint(4) NOT NULL DEFAULT 1,
  `institution_code` varchar(100) DEFAULT NULL,
  `reg_prefix_digit` int(11) NOT NULL,
  `offline_payments` tinyint(1) NOT NULL DEFAULT 1,
  `attendance_type` tinyint(1) NOT NULL DEFAULT 0,
  `show_own_question` tinyint(4) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `unique_roll` tinyint(4) NOT NULL DEFAULT 1,
  `default_admitcard_temp` int(11) NOT NULL DEFAULT 0,
  `default_marksheet_temp` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `board_id`, `name`, `school_name`, `email`, `mobileno`, `currency`, `symbol`, `currency_formats`, `symbol_position`, `lga`, `ward`, `state`, `address`, `stu_generate`, `stu_username_prefix`, `stu_default_password`, `grd_generate`, `grd_username_prefix`, `grd_default_password`, `teacher_restricted`, `due_days`, `due_with_fine`, `translation`, `timezone`, `weekends`, `reg_prefix_enable`, `student_login`, `parent_login`, `teacher_mobile_visible`, `teacher_email_visible`, `reg_start_from`, `institution_code`, `reg_prefix_digit`, `offline_payments`, `attendance_type`, `show_own_question`, `status`, `unique_roll`, `default_admitcard_temp`, `default_marksheet_temp`, `created_at`, `updated_at`) VALUES
(1, 2, 'Government College Kaduna', 'Government College Kaduna', 'gckaduna.edu@kdsg.gov.ng', '08022332233', 'NGN', '₦', 1, 1, 'Kaduna South', 'Kakuri Hausa', 'Kaduna', '', 0, '', '', 0, '', '', 1, 30, 1, 'english', '', '1', 0, 0, 0, 1, 1, 1, NULL, 0, 1, 0, 0, 1, 1, 0, 0, '2026-03-25 11:58:56', '2026-04-14 09:36:50'),
(2, 2, 'Queen Amina College', 'Queen Amina College', 'qac.edu@kdsg.gov.ng', '09022332233', 'NGN', '₦', 1, 1, 'Kaduna South', 'Television', 'Kaduna', '', 0, '', '', 0, '', '', 1, 30, 1, 'english', '', '1', 0, 1, 1, 1, 1, 1, NULL, 0, 1, 0, 0, 1, 1, 0, 0, '2026-03-25 12:00:03', '2026-04-14 09:36:50'),
(3, 2, 'Barewa College', 'Barewa College', 'bc.edu@kdsg.gov.ng', '09022332233', 'NGN', '₦', 1, 1, 'Zaria', 'Kwarbai ', 'Kaduna', '', 0, '', '', 0, '', '', 1, 30, 1, 'english', '', '1', 0, 1, 1, 1, 1, 1, NULL, 0, 1, 0, 0, 1, 1, 0, 0, '2026-03-25 12:01:47', '2026-04-14 09:36:50'),
(4, 1, 'LEA Primary School Malali', 'L.E.A. Primary School Malali', 'lea.malali@kdsg.gov.ng', '08011111101', 'NGN', '₦', 1, 1, 'Kaduna North', 'Hayin Banki', 'Kaduna', 'Malali, Kaduna North LGA', 0, '', '', 0, '', '', 1, 30, 1, 'english', 'Africa/Lagos', '1', 0, 1, 1, 1, 1, 1, NULL, 0, 1, 0, 0, 1, 1, 0, 0, '2026-04-14 11:49:19', '2026-04-14 11:49:19'),
(5, 1, 'LEA Primary School Tudun Wada', 'L.E.A. Primary School Tudun Wada', 'lea.tudunwada@kdsg.gov.ng', '08011111102', 'NGN', '₦', 1, 1, 'Kaduna South', 'Tudun Wada North', 'Kaduna', 'Tudun Wada, Kaduna South LGA', 0, '', '', 0, '', '', 1, 30, 1, 'english', 'Africa/Lagos', '1', 0, 1, 1, 1, 1, 1, NULL, 0, 1, 0, 0, 1, 1, 0, 0, '2026-04-14 11:49:19', '2026-04-14 11:49:19'),
(6, 1, 'JSS Kawo', 'Junior Secondary School Kawo', 'jss.kawo@kdsg.gov.ng', '08011111103', 'NGN', '₦', 1, 1, 'Kaduna North', 'Kawo', 'Kaduna', 'Kawo, Kaduna North LGA', 0, '', '', 0, '', '', 1, 30, 1, 'english', 'Africa/Lagos', '1', 0, 1, 1, 1, 1, 1, NULL, 0, 1, 0, 0, 1, 1, 0, 0, '2026-04-14 11:49:19', '2026-04-14 11:49:19'),
(7, 1, 'LEA Primary School Rigasa', 'L.E.A. Primary School Rigasa', 'lea.rigasa@kdsg.gov.ng', '08011111104', 'NGN', '₦', 1, 1, 'Igabi', 'Rigasa', 'Kaduna', 'Rigasa, Igabi LGA', 0, '', '', 0, '', '', 1, 30, 1, 'english', 'Africa/Lagos', '1', 0, 1, 1, 1, 1, 1, NULL, 0, 1, 0, 0, 1, 1, 0, 0, '2026-04-14 11:49:19', '2026-04-14 11:49:19'),
(8, 1, 'JSS Sabon Tasha', 'Junior Secondary School Sabon Tasha', 'jss.sabontasha@kdsg.gov.ng', '08011111105', 'NGN', '₦', 1, 1, 'Chikun', 'Sabon Tasha', 'Kaduna', 'Sabon Tasha, Chikun LGA', 0, '', '', 0, '', '', 1, 30, 1, 'english', 'Africa/Lagos', '1', 0, 1, 1, 1, 1, 1, NULL, 0, 1, 0, 0, 1, 1, 0, 0, '2026-04-14 11:49:19', '2026-04-14 11:49:19'),
(9, 2, 'GSS Tudun Wada', 'Govt Secondary School Tudun Wada', 'gss.tudunwada@kdsg.gov.ng', '08022222201', 'NGN', '₦', 1, 1, 'Kaduna South', 'Tudun Wada South', 'Kaduna', 'Tudun Wada, Kaduna South LGA', 0, '', '', 0, '', '', 1, 30, 1, 'english', 'Africa/Lagos', '1', 0, 1, 1, 1, 1, 1, NULL, 0, 1, 0, 0, 1, 1, 0, 0, '2026-04-14 11:49:19', '2026-04-14 11:49:19'),
(10, 2, 'GGSS Kawo', 'Govt Girls Secondary School Kawo', 'ggss.kawo@kdsg.gov.ng', '08022222202', 'NGN', '₦', 1, 1, 'Kaduna North', 'Kawo', 'Kaduna', 'Kawo, Kaduna North LGA', 0, '', '', 0, '', '', 1, 30, 1, 'english', 'Africa/Lagos', '1', 0, 1, 1, 1, 1, 1, NULL, 0, 1, 0, 0, 1, 1, 0, 0, '2026-04-14 11:49:19', '2026-04-14 11:49:19');

-- --------------------------------------------------------

--
-- Table structure for table `bulk_msg_category`
--

CREATE TABLE `bulk_msg_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `body` longtext NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT 'sms=1, email=2',
  `branch_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bulk_sms_email`
--

CREATE TABLE `bulk_sms_email` (
  `id` int(11) NOT NULL,
  `campaign_name` varchar(255) DEFAULT NULL,
  `sms_gateway` varchar(55) DEFAULT '0',
  `message` text DEFAULT NULL,
  `email_subject` varchar(255) DEFAULT NULL,
  `message_type` tinyint(3) DEFAULT 0 COMMENT 'sms=1, email=2',
  `recipient_type` tinyint(3) NOT NULL COMMENT 'group=1, individual=2, class=3',
  `recipients_details` longtext DEFAULT NULL,
  `additional` longtext DEFAULT NULL,
  `schedule_time` datetime DEFAULT NULL,
  `posting_status` tinyint(3) NOT NULL COMMENT 'schedule=1,competed=2',
  `total_thread` int(11) NOT NULL,
  `successfully_sent` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `call_log`
--

CREATE TABLE `call_log` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `number` varchar(255) DEFAULT NULL,
  `purpose_id` int(11) DEFAULT NULL,
  `call_type` tinyint(1) DEFAULT NULL,
  `date` date NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `follow_up` date DEFAULT NULL,
  `note` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `call_purpose`
--

CREATE TABLE `call_purpose` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `call_purpose`
--

INSERT INTO `call_purpose` (`id`, `name`, `branch_id`) VALUES
(1, 'Fees', 1),
(2, 'To inquire about the child', 1),
(3, 'Student Health Checkup', 1),
(4, 'Electricity Office', 1);

-- --------------------------------------------------------

--
-- Table structure for table `card_templete`
--

CREATE TABLE `card_templete` (
  `id` int(11) NOT NULL,
  `card_type` tinyint(1) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL,
  `user_type` tinyint(1) NOT NULL,
  `background` varchar(355) DEFAULT NULL,
  `logo` varchar(355) DEFAULT NULL,
  `signature` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `layout_width` varchar(11) NOT NULL DEFAULT '54',
  `layout_height` varchar(11) NOT NULL DEFAULT '86',
  `photo_style` tinyint(1) NOT NULL,
  `photo_size` varchar(25) NOT NULL,
  `top_space` varchar(25) NOT NULL,
  `bottom_space` varchar(25) NOT NULL,
  `right_space` varchar(25) NOT NULL,
  `left_space` varchar(25) NOT NULL,
  `qr_code` varchar(25) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `card_templete`
--

INSERT INTO `card_templete` (`id`, `card_type`, `name`, `user_type`, `background`, `logo`, `signature`, `content`, `layout_width`, `layout_height`, `photo_style`, `photo_size`, `top_space`, `bottom_space`, `right_space`, `left_space`, `qr_code`, `branch_id`, `created_at`) VALUES
(1, 1, 'Templete1', 1, '', '', '', '<p><br style=\"\"><br style=\"\"><br style=\"\"></p><div style=\"float: left;\">{student_photo}<br>{signature}</div><div style=\"float: right; line-height: 1.4;\">Name :&nbsp;{name}<br>Gender :&nbsp;{gender}<br>Roll :&nbsp;&nbsp;{roll}<br>DOB :&nbsp;&nbsp;{birthday}<br>Date of Issue :&nbsp;&nbsp;{print_date}<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{qr_code}</div>', '96.856', '64.0', 1, '110', '5', '5', '20', '20', 'register_no', 1, '2026-03-27 07:18:42'),
(2, 2, 'First Term Exam Admit Card', 1, '', '', '', '<div style=\"text-align: center;\"><b style=\"\"><span style=\"font-size: 28px;\">{institute_name}</span><span style=\"font-size: 28px;\"></span></b></div><div style=\"text-align: center;\">{institute_email} | {mobileno}&nbsp;</div><div style=\"text-align: center;\">{institute_address}</div><div style=\"text-align: center;\">{student_photo}&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; {qr_code}&nbsp;</div><div style=\"text-align: center;\"><span style=\"font-size: 18px;\"><b><br></b></span></div><div style=\"text-align: center;\"><span style=\"font-size: 18px;\"><b>ADMIT CARD&nbsp; FIRST TERM EXAMINATION</b></span></div><div style=\"text-align: center;\"><span style=\"font-size: 18px;\"><b><br></b></span></div><table class=\"table table-bordered table-condensed mb-none\" style=\"width: 724px; border-color: rgb(66, 68, 71);\"><tbody><tr><td style=\"line-height: 1.42857; border-color: rgb(66, 68, 71);\"><b>Student Name:&nbsp;</b>{name}<br></td><td style=\"line-height: 1.42857; border-color: rgb(66, 68, 71);\"><b>Exam Name:&nbsp;</b>{exam_name}<br></td></tr><tr><td style=\"line-height: 1.42857; border-color: rgb(66, 68, 71);\"><b>Father\'s Name:&nbsp;</b>{father_name}<br></td><td style=\"line-height: 1.42857; border-color: rgb(66, 68, 71);\"><b>Class:&nbsp;</b>{class}<br></td></tr><tr><td style=\"line-height: 1.42857; border-color: rgb(66, 68, 71);\"><b>Gender:&nbsp;</b>{gender}<br></td><td style=\"line-height: 1.42857; border-color: rgb(66, 68, 71);\"><b>Roll:</b>&nbsp;{roll}<br></td></tr><tr><td style=\"line-height: 1.42857; border-color: rgb(66, 68, 71);\"><b>Date Of Birth:&nbsp;</b>{birthday}<br></td><td style=\"line-height: 1.42857; border-color: rgb(66, 68, 71);\"><b>Admission On:</b>&nbsp;{admission_date}<br></td></tr><tr><td style=\"line-height: 1.42857; border-color: rgb(66, 68, 71);\"><b>Email:&nbsp;</b>{email}<br></td><td style=\"line-height: 1.42857; border-color: rgb(66, 68, 71);\"><b>Student Group:&nbsp;</b>{category}<br></td></tr><tr><td style=\"line-height: 1.42857; border-color: rgb(66, 68, 71);\"><b>Contact No:&nbsp;</b>{mobileno}<br></td><td style=\"line-height: 1.42857; border-color: rgb(66, 68, 71);\"><b>Blood Group</b>: {blood_group}&nbsp;<br></td></tr></tbody></table><div style=\"text-align: center;\"><br><div style=\"text-align: left;\"><b>Subject Details :</b></div><div style=\"text-align: left;\">{subject_list_table}</div><div style=\"\">Date of Admit Card Print : {print_date}&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Principal Signature</div><div style=\"\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;{signature}</div></div>', '210', '297', 1, '100', '80', '80', '80', '90', 'register_no', 1, '2026-03-27 07:23:39');

-- --------------------------------------------------------

--
-- Table structure for table `certificates_templete`
--

CREATE TABLE `certificates_templete` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_type` tinyint(1) NOT NULL,
  `background` varchar(355) DEFAULT NULL,
  `logo` varchar(355) DEFAULT NULL,
  `signature` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `page_layout` tinyint(1) NOT NULL,
  `photo_style` tinyint(1) NOT NULL,
  `photo_size` varchar(25) NOT NULL,
  `top_space` varchar(25) NOT NULL,
  `bottom_space` varchar(25) NOT NULL,
  `right_space` varchar(25) NOT NULL,
  `left_space` varchar(25) NOT NULL,
  `qr_code` varchar(25) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_numeric` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `board_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `name`, `name_numeric`, `created_at`, `updated_at`, `branch_id`, `board_id`) VALUES
(4, 'Basic 7', '7', '2026-03-27 07:47:27', NULL, NULL, 1),
(14, 'Basic 1', '1', '2026-04-14 08:34:32', NULL, NULL, 1),
(15, 'Basic 2', '2', '2026-04-14 08:34:32', NULL, 0, 1),
(16, 'Basic 3', '3', '2026-04-14 08:34:32', NULL, 0, 1),
(17, 'Basic 4', '4', '2026-04-14 08:34:32', NULL, 0, 1),
(18, 'Basic 5', '5', '2026-04-14 08:34:32', NULL, 0, 1),
(19, 'Basic 6', '6', '2026-04-14 08:34:32', NULL, 0, 1),
(21, 'Basic 8', '8', '2026-04-14 08:34:32', NULL, 0, 1),
(22, 'Basic 9', '9', '2026-04-14 08:34:32', NULL, 0, 1),
(41, 'SS 1', '10', '2026-04-14 08:36:50', NULL, 0, 2),
(42, 'SS 2', '11', '2026-04-14 08:36:50', NULL, 0, 2),
(43, 'SS 3', '12', '2026-04-14 08:36:50', NULL, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `complaint`
--

CREATE TABLE `complaint` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `number` varchar(255) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `assigned_id` int(11) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `date_of_solution` date DEFAULT NULL,
  `file` varchar(500) NOT NULL,
  `note` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `complaint_type`
--

CREATE TABLE `complaint_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `board_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `complaint_type`
--

INSERT INTO `complaint_type` (`id`, `name`, `branch_id`, `board_id`) VALUES
(1, 'Fees', 1, NULL),
(2, 'Hostel', 1, NULL),
(3, 'Facilities', 1, NULL),
(4, 'Teacher', 1, NULL),
(5, 'Management', 1, NULL),
(6, 'General', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `custom_field`
--

CREATE TABLE `custom_field` (
  `id` int(11) NOT NULL,
  `form_to` varchar(50) DEFAULT NULL,
  `field_label` varchar(100) NOT NULL,
  `default_value` text DEFAULT NULL,
  `field_type` enum('text','textarea','dropdown','date','checkbox','number','url','email') NOT NULL,
  `required` varchar(5) NOT NULL DEFAULT 'false',
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `show_on_table` varchar(5) DEFAULT NULL,
  `field_order` int(11) NOT NULL,
  `bs_column` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_fields_online_values`
--

CREATE TABLE `custom_fields_online_values` (
  `id` int(11) NOT NULL,
  `relid` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_fields_values`
--

CREATE TABLE `custom_fields_values` (
  `id` int(11) NOT NULL,
  `relid` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `disable_reason`
--

CREATE TABLE `disable_reason` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `disable_reason_details`
--

CREATE TABLE `disable_reason_details` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `reason_id` int(11) NOT NULL,
  `note` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `education_board`
--

CREATE TABLE `education_board` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `education_board`
--

INSERT INTO `education_board` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'KADSUBEB', 'Kaduna State Universal Basic Education Board', '2026-04-14 07:25:04', '2026-04-14 08:27:14'),
(2, 'KADSSSEB', 'Kaduna State Senior Secondary School Education Board', '2026-04-14 07:28:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `email_config`
--

CREATE TABLE `email_config` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `protocol` varchar(255) NOT NULL,
  `smtp_host` varchar(255) DEFAULT NULL,
  `smtp_user` varchar(255) DEFAULT NULL,
  `smtp_pass` varchar(255) DEFAULT NULL,
  `smtp_port` varchar(100) DEFAULT NULL,
  `smtp_encryption` varchar(10) DEFAULT NULL,
  `smtp_auth` varchar(10) NOT NULL DEFAULT 'true',
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `tags` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `name`, `tags`) VALUES
(1, 'account_registered', '{institute_name}, {name}, {login_username}, {password}, {user_role}, {login_url}'),
(2, 'forgot_password', '{institute_name}, {username}, {email}, {reset_url}'),
(3, 'change_password', '{institute_name}, {name}, {email}, {password}'),
(4, 'new_message_received', '{institute_name}, {recipient}, {message}, {message_url}'),
(5, 'payslip_generated', '{institute_name}, {username}, {month_year}, {payslip_url}'),
(6, 'award', '{institute_name}, {winner_name}, {award_name}, {gift_item}, {award_reason}, {given_date}'),
(7, 'leave_approve', '{institute_name}, {applicant_name}, {start_date}, {end_date}, {comments}'),
(8, 'leave_reject', '{institute_name}, {applicant_name}, {start_date}, {end_date}, {comments}'),
(9, 'advance_salary_approve', '{institute_name}, {applicant_name}, {deduct_motnh}, {amount}, {comments}'),
(10, 'advance_salary_reject', '{institute_name}, {applicant_name}, {deduct_motnh}, {amount}, {comments}'),
(11, 'apply_online_admission', '{institute_name}, {reference_no}, {applicant_name}, {applicant_mobile}, {class}, {section}, {apply_date}, {payment_url}, {admission_copy_url}, {paid_amount}'),
(12, 'student_admission', '{institute_name}, {academic_year}, {admission_date}, {admission_no}, {roll}, {category}, {student_name}, {student_mobile}, {class}, {section}, {login_username}, {password}, {login_url}'),
(13, 'email_pdf_exam_marksheet', '{institute_name}, {academic_year}, {admission_date}, {register_no}, {roll}, {student_name}, {class}, {section}, {exam_name}'),
(14, 'email_pdf_fee_invoice', '{institute_name}, {academic_year}, {today_date}, {admission_date}, {register_no}, {roll}, {student_name}, {class}, {section}'),
(15, 'online_exam_published', '{institute_name}, {student_name}, {student_mobile}, {register_no}, {roll}, {class}, {section}, {exam_title}, {start_time}, {end_time},{time_duration}, {attempt}, {passing_mark}, {exam_fee}');

-- --------------------------------------------------------

--
-- Table structure for table `email_templates_details`
--

CREATE TABLE `email_templates_details` (
  `id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `template_body` text NOT NULL,
  `notified` tinyint(1) NOT NULL DEFAULT 1,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enquiry`
--

CREATE TABLE `enquiry` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `birthday` date DEFAULT NULL,
  `gender` tinyint(1) DEFAULT 0,
  `father_name` varchar(255) DEFAULT NULL,
  `mother_name` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `previous_school` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `reference_id` int(11) NOT NULL,
  `response_id` int(11) NOT NULL,
  `response` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `note` varchar(255) NOT NULL,
  `assigned_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `no_of_child` float NOT NULL,
  `class_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `branch_id` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enquiry_follow_up`
--

CREATE TABLE `enquiry_follow_up` (
  `id` int(11) NOT NULL,
  `enquiry_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `next_date` date NOT NULL,
  `response` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `note` varchar(255) NOT NULL,
  `follow_up_by` int(11) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enquiry_reference`
--

CREATE TABLE `enquiry_reference` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enquiry_response`
--

CREATE TABLE `enquiry_response` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `enquiry_response`
--

INSERT INTO `enquiry_response` (`id`, `name`, `branch_id`) VALUES
(1, 'Very Good', 1),
(2, 'Excellent', 1),
(3, 'Negative', 1),
(4, 'Bad', 1);

-- --------------------------------------------------------

--
-- Table structure for table `enroll`
--

CREATE TABLE `enroll` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `roll` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `default_login` tinyint(4) NOT NULL DEFAULT 0,
  `branch_id` int(11) NOT NULL,
  `is_alumni` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `enroll`
--

INSERT INTO `enroll` (`id`, `student_id`, `class_id`, `section_id`, `roll`, `session_id`, `default_login`, `branch_id`, `is_alumni`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 1, 111231, 3, 0, 1, 0, '2026-04-02 14:55:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `remark` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `type` text NOT NULL,
  `audition` longtext NOT NULL,
  `selected_list` longtext NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `created_by` varchar(200) NOT NULL,
  `session_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `show_web` tinyint(3) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_types`
--

CREATE TABLE `event_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `icon` varchar(200) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `board_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `event_types`
--

INSERT INTO `event_types` (`id`, `name`, `icon`, `branch_id`, `board_id`) VALUES
(1, 'Independent Day', 'bullhorn', 1, NULL),
(2, 'Anniversary', 'users', 1, NULL),
(3, 'Special Holiday', 'bullhorn', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE `exam` (
  `id` int(11) NOT NULL,
  `name` longtext NOT NULL,
  `term_id` int(11) DEFAULT NULL,
  `type_id` tinyint(4) NOT NULL COMMENT '1=mark,2=gpa,3=both',
  `session_id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `remark` text NOT NULL,
  `mark_distribution` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `publish_result` tinyint(1) NOT NULL DEFAULT 1,
  `rank_generated` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `exam`
--

INSERT INTO `exam` (`id`, `name`, `term_id`, `type_id`, `session_id`, `branch_id`, `remark`, `mark_distribution`, `status`, `publish_result`, `rank_generated`, `created_at`, `updated_at`) VALUES
(1, 'First Term Examination for 2026/27 Session', 7, 3, 3, 1, '', '[\"27\",\"28\"]', 1, 0, 0, '2026-04-02 14:46:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exam_attendance`
--

CREATE TABLE `exam_attendance` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `status` varchar(4) DEFAULT NULL COMMENT 'P=Present, A=Absent, L=Late',
  `remark` varchar(255) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam_hall`
--

CREATE TABLE `exam_hall` (
  `id` int(11) NOT NULL,
  `hall_no` longtext NOT NULL,
  `seats` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `exam_hall`
--

INSERT INTO `exam_hall` (`id`, `hall_no`, `seats`, `branch_id`) VALUES
(1, 'Arewa 101', 400, 1);

-- --------------------------------------------------------

--
-- Table structure for table `exam_mark_distribution`
--

CREATE TABLE `exam_mark_distribution` (
  `id` int(11) NOT NULL,
  `name` longtext NOT NULL,
  `branch_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `exam_mark_distribution`
--

INSERT INTO `exam_mark_distribution` (`id`, `name`, `branch_id`) VALUES
(24, 'Practical', NULL),
(25, 'Attendance', NULL),
(26, 'Written', NULL),
(27, 'CA Score', NULL),
(28, 'Exam Score', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exam_rank`
--

CREATE TABLE `exam_rank` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `enroll_id` int(11) NOT NULL,
  `principal_comments` text DEFAULT NULL,
  `teacher_comments` text DEFAULT NULL,
  `rank` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam_term`
--

CREATE TABLE `exam_term` (
  `id` int(11) NOT NULL,
  `name` longtext NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `session_id` int(11) NOT NULL,
  `board_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `exam_term`
--

INSERT INTO `exam_term` (`id`, `name`, `branch_id`, `session_id`, `board_id`) VALUES
(4, '1st Term', 0, 3, 1),
(5, '2nd Term', 0, 3, 1),
(6, '3rd Term', 0, 3, 1),
(7, '1st Term', 0, 3, 2),
(8, '2nd Term', 0, 3, 2),
(9, '3rd Term', 0, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `fees_reminder`
--

CREATE TABLE `fees_reminder` (
  `id` int(11) NOT NULL,
  `frequency` varchar(255) NOT NULL,
  `days` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `dlt_template_id` varchar(255) DEFAULT NULL,
  `student` tinyint(3) NOT NULL,
  `guardian` tinyint(3) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fees_type`
--

CREATE TABLE `fees_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `fee_code` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `system` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `board_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `fees_type`
--

INSERT INTO `fees_type` (`id`, `name`, `fee_code`, `description`, `branch_id`, `system`, `created_at`, `board_id`) VALUES
(1, 'Online Exam', 'online-exam', '', 1, 0, '2026-03-27 09:41:35', NULL),
(2, 'Admission Fees', 'admission-fees', '', 1, 0, '2026-03-27 09:41:48', NULL),
(4, 'Sports Fees', 'sports-fees', '', 1, 0, '2026-03-27 09:42:03', NULL),
(5, 'Exam Fees', 'exam-fees', '', 1, 0, '2026-03-27 09:42:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fee_allocation`
--

CREATE TABLE `fee_allocation` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `prev_due` decimal(18,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fee_fine`
--

CREATE TABLE `fee_fine` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `fine_value` varchar(20) NOT NULL,
  `fine_type` varchar(20) NOT NULL,
  `fee_frequency` varchar(20) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fee_groups`
--

CREATE TABLE `fee_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `session_id` int(11) NOT NULL,
  `system` tinyint(4) NOT NULL DEFAULT 0,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fee_groups_details`
--

CREATE TABLE `fee_groups_details` (
  `id` int(11) NOT NULL,
  `fee_groups_id` int(11) NOT NULL,
  `fee_type_id` int(11) NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `due_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fee_payment_history`
--

CREATE TABLE `fee_payment_history` (
  `id` int(11) NOT NULL,
  `allocation_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `transport_fee_details_id` int(11) DEFAULT NULL,
  `collect_by` varchar(20) DEFAULT NULL,
  `amount` decimal(18,2) NOT NULL,
  `discount` decimal(18,2) NOT NULL,
  `fine` decimal(18,2) NOT NULL,
  `pay_via` varchar(20) NOT NULL,
  `remarks` longtext NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_about`
--

CREATE TABLE `front_cms_about` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `page_title` varchar(255) NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `about_image` varchar(255) NOT NULL,
  `elements` mediumtext NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keyword` text NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `front_cms_about`
--

INSERT INTO `front_cms_about` (`id`, `title`, `subtitle`, `page_title`, `content`, `banner_image`, `about_image`, `elements`, `meta_description`, `meta_keyword`, `branch_id`) VALUES
(1, 'Welcome to School', 'Best Education Mangment Systems', 'About Us', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut volutpat rutrum eros amet sollicitudin interdum. Suspendisse pulvinar, velit nec pharetra interdum, ante tellus ornare mi, et mollis tellus neque vitae elit. Mauris adipiscing mauris fringilla turpis interdum sed pulvinar nisi malesuada. Lorem ipsum dolor sit amet, consectetur adipiscing elit.\r\n                        </p>\r\n                        <p>\r\n                            Donec sed odio dui. Nulla vitae elit libero, a pharetra augue. Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Duis mollis, est non commodo luctus, nisi erat porttitor ligula. Mauris sit amet neque nec nunc gravida. \r\n                        </p>\r\n                        <div class=\"row\">\r\n                            <div class=\"col-sm-6 col-12\">\r\n                                <ul class=\"list-unstyled list-style-3\">\r\n                                    <li><a href=\"#\">Cardiothoracic Surgery</a></li>\r\n                                    <li><a href=\"#\">Cardiovascular Diseases</a></li>\r\n                                    <li><a href=\"#\">Ophthalmology</a></li>\r\n                                    <li><a href=\"#\">Dermitology</a></li>\r\n                                </ul>\r\n                            </div>\r\n                            <div class=\"col-sm-6 col-12\">\r\n                                <ul class=\"list-unstyled list-style-3\">\r\n                                    <li><a href=\"#\">Cardiothoracic Surgery</a></li>\r\n                                    <li><a href=\"#\">Cardiovascular Diseases</a></li>\r\n                                    <li><a href=\"#\">Ophthalmology</a></li>\r\n                                </ul>\r\n                            </div>\r\n                        </div>', 'about1.jpg', 'about1.png', '{\"cta_title\":\"Get in touch to join our community\",\"button_text\":\"Contact Our Office\",\"button_url\":\"contact\"}', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_admission`
--

CREATE TABLE `front_cms_admission` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `terms_conditions_title` varchar(255) DEFAULT NULL,
  `terms_conditions_description` text NOT NULL,
  `fee_elements` text DEFAULT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `meta_description` text NOT NULL,
  `meta_keyword` text NOT NULL,
  `application_form_name` varchar(255) DEFAULT NULL,
  `application_form_file` varchar(255) DEFAULT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `front_cms_admission`
--

INSERT INTO `front_cms_admission` (`id`, `title`, `description`, `page_title`, `terms_conditions_title`, `terms_conditions_description`, `fee_elements`, `banner_image`, `meta_description`, `meta_keyword`, `application_form_name`, `application_form_file`, `branch_id`) VALUES
(1, 'Make An Admission', '<p>Lorem ipsum dolor sit amet, eum illum dolore concludaturque ex, ius latine adipisci no. Pro at nullam laboramus definitiones. Mandamusconceptam omittantur cu cum. Brute appetere it scriptorem ei eam, ne vim velit novum nominati. Causae volutpat percipitur at sed ne.</p>\r\n', 'Admission', '', '', '', 'admission1.jpg', 'SmartSchool - School Management System', 'SmartSchool Admission Page', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_admitcard`
--

CREATE TABLE `front_cms_admitcard` (
  `id` int(11) NOT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `templete_id` int(11) NOT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keyword` text NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `front_cms_admitcard`
--

INSERT INTO `front_cms_admitcard` (`id`, `page_title`, `templete_id`, `banner_image`, `description`, `meta_description`, `meta_keyword`, `branch_id`) VALUES
(1, 'Admit Card', 1, 'admit_card1.jpg', 'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.', 'SmartSchool - School Management System', 'SmartSchool Admit Card Page', 1);

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_certificates`
--

CREATE TABLE `front_cms_certificates` (
  `id` int(11) NOT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keyword` text NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `front_cms_certificates`
--

INSERT INTO `front_cms_certificates` (`id`, `page_title`, `banner_image`, `description`, `meta_description`, `meta_keyword`, `branch_id`) VALUES
(1, 'Certificates', 'certificates1.jpg', 'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.', 'SmartSchool - School Management System', 'SmartSchool Admit Card Page', 1);

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_contact`
--

CREATE TABLE `front_cms_contact` (
  `id` int(11) NOT NULL,
  `box_title` varchar(255) DEFAULT NULL,
  `box_description` varchar(500) DEFAULT NULL,
  `box_image` varchar(255) DEFAULT NULL,
  `form_title` varchar(355) DEFAULT NULL,
  `address` varchar(355) DEFAULT NULL,
  `phone` varchar(355) DEFAULT NULL,
  `email` varchar(355) DEFAULT NULL,
  `submit_text` varchar(355) NOT NULL,
  `map_iframe` text DEFAULT NULL,
  `page_title` varchar(255) NOT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `meta_description` text NOT NULL,
  `meta_keyword` text NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `front_cms_contact`
--

INSERT INTO `front_cms_contact` (`id`, `box_title`, `box_description`, `box_image`, `form_title`, `address`, `phone`, `email`, `submit_text`, `map_iframe`, `page_title`, `banner_image`, `meta_description`, `meta_keyword`, `branch_id`) VALUES
(1, 'WE\'D LOVE TO HEAR FROM YOU', 'Fusce convallis diam vitae velit tempus rutrum. Donec nisl nisl, vulputate eu sapien sed, adipiscing vehicula massa. Mauris eget commodo neque, id molestie enim.', 'contact-info-box1.png', 'Get in touch by filling the form below', '4896  Romrog Way, LOS ANGELES,\r\nCalifornia', '954-648-1802, \r\n963-612-1782', 'jamilusalis@gmail.com\rjamilusalis@gmail.com', 'Send', '<iframe width=\"100%\" height=\"350\" id=\"gmap_canvas\" src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3313.3833161665298!2d-118.03745848530627!3d33.85401093559897!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80dd2c6c97f8f3ed%3A0x47b1bde165dcc056!2sOak+Dr%2C+La+Palma%2C+CA+90623%2C+USA!5e0!3m2!1sen!2sbd!4v1544238752504\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\"></iframe>', 'Contact Us', 'contact1.jpg', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_events`
--

CREATE TABLE `front_cms_events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `meta_description` text NOT NULL,
  `meta_keyword` text NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `front_cms_events`
--

INSERT INTO `front_cms_events` (`id`, `title`, `description`, `page_title`, `banner_image`, `meta_description`, `meta_keyword`, `branch_id`) VALUES
(1, 'Upcoming Events', '<p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.</p><p>Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS.</p>', 'Events', 'events1.jpg', 'SmartSchool - School Management System', 'SmartSchool Events Page', 1);

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_exam_results`
--

CREATE TABLE `front_cms_exam_results` (
  `id` int(11) NOT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `grade_scale` tinyint(1) NOT NULL,
  `attendance` tinyint(1) NOT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keyword` text NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `front_cms_exam_results`
--

INSERT INTO `front_cms_exam_results` (`id`, `page_title`, `grade_scale`, `attendance`, `banner_image`, `description`, `meta_description`, `meta_keyword`, `branch_id`) VALUES
(1, 'Exam Results', 1, 1, 'exam_results1.jpg', 'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.', 'SmartSchool - School Management System', 'SmartSchool Admit Card Page', 1);

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_faq`
--

CREATE TABLE `front_cms_faq` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `meta_description` text NOT NULL,
  `meta_keyword` text NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `front_cms_faq`
--

INSERT INTO `front_cms_faq` (`id`, `title`, `description`, `page_title`, `banner_image`, `meta_description`, `meta_keyword`, `branch_id`) VALUES
(1, 'Frequently Asked Questions', '<p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.</p>\r\n\r\n<p>Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven&#39;t heard of them accusamus labore sustainable VHS.</p>', 'Faq', 'faq1.jpg', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_faq_list`
--

CREATE TABLE `front_cms_faq_list` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `front_cms_faq_list`
--

INSERT INTO `front_cms_faq_list` (`id`, `title`, `description`, `branch_id`) VALUES
(1, 'Any Information you provide on applications for disability, life or accidental insurance ?', '<p>\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco quat. It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.\r\n</p>\r\n<ul>\r\n<li>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>\r\n<li>Sed do eiusmod tempor incididunt ut labore et dolore magna aliq.</li>\r\n<li>Ut enim ad minim veniam, quis nostrud exercitation ullamco quat. It is a long established fact.</li>\r\n<li>That a reader will be distracted by the readable content of a page when looking at its layout.</li>\r\n<li>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>\r\n<li>Eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</li>\r\n<li>Quis nostrud exercitation ullamco quat. It is a long established fact that a reader will be distracted.</li>\r\n<li>Readable content of a page when looking at its layout.</li>\r\n<li>The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.</li>\r\n<li>Opposed to using \'Content here, content here\', making it look like readable English.</li>\r\n</ul>', 1),
(2, 'Readable content of a page when looking at its layout ?', '<p>\r\n                                Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS.\r\n                            </p>\r\n                            <ol>\r\n                                <li>Quis nostrud exercitation ullamco quat. It is a long established fact that a reader will be distracted.</li>\r\n                                <li>Readable content of a page when looking at its layout.</li>\r\n                                <li>The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.</li>\r\n                                <li>Opposed to using \'Content here, content here\', making it look like readable English.</li>\r\n                            </ol>\r\n                            <p>\r\n                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.\r\n                            </p>', 1),
(3, 'Opposed to using \'Content here, content here\', making it look like readable English ?', '<p>\r\n                                Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS.\r\n                            </p>\r\n                            <ol>\r\n                                <li>Quis nostrud exercitation ullamco quat. It is a long established fact that a reader will be distracted.</li>\r\n                                <li>Readable content of a page when looking at its layout.</li>\r\n                                <li>The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.</li>\r\n                                <li>Opposed to using \'Content here, content here\', making it look like readable English.</li>\r\n                            </ol>\r\n                            <p>\r\n                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.\r\n                            </p>', 1),
(4, 'Readable content of a page when looking at its layout ?', '<p>\r\n                                Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS.\r\n                            </p>\r\n                            <ol>\r\n                                <li>Quis nostrud exercitation ullamco quat. It is a long established fact that a reader will be distracted.</li>\r\n                                <li>Readable content of a page when looking at its layout.</li>\r\n                                <li>The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.</li>\r\n                                <li>Opposed to using \'Content here, content here\', making it look like readable English.</li>\r\n                            </ol>\r\n                            <p>\r\n                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.\r\n                            </p>', 1),
(5, 'What types of documents are required to travel?', '<p><strong>Lorem ipsum</strong> dolor sit amet, an labores explicari qui, eu nostrum copiosae argumentum has. Latine propriae quo no, unum ridens expetenda id sit, at usu eius eligendi singulis. Sea ocurreret principes ne. At nonumy aperiri pri, nam quodsi copiosae intellegebat et, ex deserunt euripidis usu. Per ad ullum lobortis. Duo volutpat imperdiet ut, postea salutatus imperdiet ut per, ad utinam debitis invenire has.</p>\r\n\r\n<ol>\r\n	<li>labores explicari qui</li>\r\n	<li>labores explicari qui</li>\r\n	<li>labores explicari quilabores explicari qui</li>\r\n	<li>labores explicari qui</li>\r\n</ol>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_gallery`
--

CREATE TABLE `front_cms_gallery` (
  `id` int(11) NOT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `meta_description` text NOT NULL,
  `meta_keyword` text NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `front_cms_gallery`
--

INSERT INTO `front_cms_gallery` (`id`, `page_title`, `banner_image`, `meta_description`, `meta_keyword`, `branch_id`) VALUES
(1, 'Gallery', 'gallery1.jpg', 'SmartSchool - School Management System', 'SmartSchool Gallery Page', 1);

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_gallery_category`
--

CREATE TABLE `front_cms_gallery_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_gallery_content`
--

CREATE TABLE `front_cms_gallery_content` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `thumb_image` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `category_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `elements` longtext NOT NULL,
  `show_web` tinyint(4) NOT NULL DEFAULT 0,
  `branch_id` int(11) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_home`
--

CREATE TABLE `front_cms_home` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `item_type` varchar(20) NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `elements` mediumtext NOT NULL,
  `color1` varchar(100) DEFAULT NULL,
  `color2` varchar(100) DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  `active` tinyint(3) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `front_cms_home`
--

INSERT INTO `front_cms_home` (`id`, `title`, `subtitle`, `item_type`, `description`, `elements`, `color1`, `color2`, `branch_id`, `active`) VALUES
(1, 'Welcome To Education', 'We will give you future', 'wellcome', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using content.\r\n\r\nMaking it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '{\"image\":\"wellcome1.png\"}', NULL, NULL, 1, 1),
(2, 'Experience Teachers Team', NULL, 'teachers', 'Making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident.', '{\"teacher_start\":\"0\",\"image\":\"featured-parallax1.jpg\"}', NULL, NULL, 1, 1),
(3, 'WHY CHOOSE US', NULL, 'services', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', '', NULL, NULL, 1, 1),
(4, 'Apply for Admission', 'Medical Services', 'cta', '', '{\"mobile_no\":\"08022332233\",\"button_text\":\"Request Now\",\"button_url\":\"http:\\/\\/localhost\\/SmartSchool\\/home\\/admission\\/\"}', '#464646', '#fff', 1, 1),
(5, 'Wellcome To <span>SmartSchool</span>', NULL, 'slider', 'Lorem Ipsum is simply dummy text printer took a galley of type and scrambled it to make a type specimen book.', '{\"position\":\"c-left\",\"button_text1\":\"View Services\",\"button_url1\":\"https:\\/\\/www.youtube.com\\/watch?v=Zec8KQmoSOU\",\"button_text2\":\"Learn More\",\"button_url2\":\"#\",\"image\":\"home-slider-1592582779.jpg\"}', NULL, NULL, 1, 1),
(6, 'Online <span>Live Class</span> Facility', NULL, 'slider', 'Lorem Ipsum is simply dummy text printer took a galley of type and scrambled it to make a type specimen book.', '{\"position\":\"c-left\",\"button_text1\":\"Read More\",\"button_url1\":\"#\",\"button_text2\":\"Get Started\",\"button_url2\":\"#\",\"image\":\"home-slider-1592582805.jpg\"}', NULL, NULL, 1, 1),
(7, 'Online Classes', NULL, 'features', 'Nulla metus metus ullamcorper vel tincidunt sed euismod nibh Quisque volutpat condimentum velit class aptent taciti sociosqu.', '{\"button_text\":\"Read More\",\"button_url\":\"#\",\"icon\":\"fas fa-video\"}', NULL, NULL, 1, 1),
(8, 'Scholarship', NULL, 'features', 'Nulla metus metus ullamcorper vel tincidunt sed euismod nibh Quisque volutpat condimentum velit class aptent taciti sociosqu.', '{\"button_text\":\"Read More\",\"button_url\":\"#\",\"icon\":\"fas fa-graduation-cap\"}', NULL, NULL, 1, 1),
(9, 'Books & Liberary', NULL, 'features', 'Nulla metus metus ullamcorper vel tincidunt sed euismod nibh Quisque volutpat condimentum velit class aptent taciti sociosqu.', '{\"button_text\":\"Read More\",\"button_url\":\"#\",\"icon\":\"fas fa-book-reader\"}', NULL, NULL, 1, 1),
(10, 'Trending Courses', NULL, 'features', 'Nulla metus metus ullamcorper vel tincidunt sed euismod nibh Quisque volutpat condimentum velit class aptent taciti sociosqu.', '{\"button_text\":\"Read More\",\"button_url\":\"#\",\"icon\":\"fab fa-discourse\"}', NULL, NULL, 1, 1),
(11, 'WHAT PEOPLE SAYS', NULL, 'testimonial', 'Fusce sem dolor, interdum in efficitur at, faucibus nec lorem. Sed nec molestie justo.', '', NULL, NULL, 1, 1),
(12, '20 years experience in the field of study', NULL, 'statistics', 'Lorem Ipsum is simply dummy text printer took a galley of type and scrambled it to make a type specimen book.', '{\"image\":\"counter-parallax1.jpg\",\"widget_title_1\":\"Certified Teachers\",\"widget_icon_1\":\"fas fa-user-tie\",\"type_1\":\"teacher\",\"widget_title_2\":\"Students Enrolled\",\"widget_icon_2\":\"fas fa-user-graduate\",\"type_2\":\"student\",\"widget_title_3\":\"Classes\",\"widget_icon_3\":\"fas fa-graduation-cap\",\"type_3\":\"class\",\"widget_title_4\":\"Section\",\"widget_icon_4\":\"fas fa-award\",\"type_4\":\"section\"}', NULL, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_home_seo`
--

CREATE TABLE `front_cms_home_seo` (
  `id` int(11) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `meta_keyword` text NOT NULL,
  `meta_description` text NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `front_cms_home_seo`
--

INSERT INTO `front_cms_home_seo` (`id`, `page_title`, `meta_keyword`, `meta_description`, `branch_id`) VALUES
(1, 'Home', 'SmartSchool Home Page', 'SmartSchool - School Management System', 1);

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_menu`
--

CREATE TABLE `front_cms_menu` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `ordering` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT 0,
  `open_new_tab` int(11) NOT NULL DEFAULT 0,
  `ext_url` tinyint(3) NOT NULL DEFAULT 0,
  `ext_url_address` text DEFAULT NULL,
  `publish` tinyint(3) NOT NULL,
  `system` tinyint(3) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `front_cms_menu`
--

INSERT INTO `front_cms_menu` (`id`, `title`, `alias`, `ordering`, `parent_id`, `open_new_tab`, `ext_url`, `ext_url_address`, `publish`, `system`, `branch_id`, `created_at`) VALUES
(1, 'Home', '', 1, 0, 0, 0, '', 1, 1, 0, '2026-02-12 12:18:54'),
(2, 'Events', 'events', 3, 0, 0, 0, '', 1, 1, 0, '2026-02-12 12:18:54'),
(3, 'Teachers', 'teachers', 2, 0, 0, 0, '', 1, 1, 0, '2026-02-12 12:18:54'),
(4, 'About Us', 'about', 4, 0, 0, 0, '', 1, 1, 0, '2026-02-12 12:18:54'),
(5, 'FAQ', 'faq', 5, 0, 0, 0, '', 1, 1, 0, '2026-02-12 12:18:54'),
(6, 'Online Admission', 'admission', 6, 0, 0, 0, '', 1, 1, 0, '2026-02-12 12:18:54'),
(7, 'Contact Us', 'contact', 13, 0, 0, 0, '', 1, 1, 0, '2026-02-12 12:18:54'),
(8, 'Pages', 'pages', 9, 0, 0, 1, '#', 1, 1, 0, '2026-02-12 12:18:54'),
(9, 'Admit Card', 'admit_card', 10, 8, 0, 0, '', 1, 1, 0, '2026-02-16 04:24:32'),
(10, 'Exam Results', 'exam_results', 11, 8, 0, 0, '', 1, 1, 0, '2026-02-16 04:24:32'),
(11, 'Certificates', 'certificates', 12, 8, 0, 0, '', 1, 1, 0, '2026-02-16 12:04:44'),
(12, 'Gallery', 'gallery', 7, 0, 0, 0, '', 1, 1, 0, '2026-02-16 12:04:44'),
(13, 'News', 'news', 8, 0, 0, 0, '', 1, 1, 0, '2026-02-21 14:50:05');

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_menu_visible`
--

CREATE TABLE `front_cms_menu_visible` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `menu_id` int(11) NOT NULL,
  `parent_id` varchar(11) DEFAULT NULL,
  `ordering` varchar(20) DEFAULT NULL,
  `invisible` tinyint(2) NOT NULL DEFAULT 1,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_news`
--

CREATE TABLE `front_cms_news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `meta_description` text NOT NULL,
  `meta_keyword` text NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `front_cms_news`
--

INSERT INTO `front_cms_news` (`id`, `title`, `description`, `page_title`, `banner_image`, `meta_description`, `meta_keyword`, `branch_id`) VALUES
(1, '', '<p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.</p><p>Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS.</p>', 'News', 'news1.jpg', 'SmartSchool - School Management System', 'SmartSchool News Page', 1);

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_news_list`
--

CREATE TABLE `front_cms_news_list` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `alias` varchar(500) NOT NULL,
  `date` date NOT NULL,
  `show_web` tinyint(4) NOT NULL DEFAULT 1,
  `branch_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_pages`
--

CREATE TABLE `front_cms_pages` (
  `id` int(11) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `content` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `menu_id` int(11) NOT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `meta_description` text NOT NULL,
  `meta_keyword` text NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_services`
--

CREATE TABLE `front_cms_services` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `parallax_image` varchar(255) DEFAULT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `front_cms_services`
--

INSERT INTO `front_cms_services` (`id`, `title`, `subtitle`, `parallax_image`, `branch_id`) VALUES
(1, 'Get Well Soon', 'Our Best <span>Services</span>', 'service_parallax1.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_services_list`
--

CREATE TABLE `front_cms_services_list` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `front_cms_services_list`
--

INSERT INTO `front_cms_services_list` (`id`, `title`, `description`, `icon`, `branch_id`) VALUES
(1, 'Online Course Facilities', 'Making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text.', 'fas fa-headphones', 1),
(2, 'Modern Book Library', 'Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover.', 'fas fa-book-open', 1),
(3, 'Be Industrial Leader', 'Making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model.', 'fas fa-industry', 1),
(4, 'Programming Courses', 'Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will.', 'fas fa-code', 1),
(5, 'Foreign Languages', 'Making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover.', 'fas fa-language', 1),
(6, 'Alumni Directory', 'Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a for \'lorem ipsum\' will uncover.', 'fas fa-user-graduate', 1);

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_setting`
--

CREATE TABLE `front_cms_setting` (
  `id` int(11) NOT NULL,
  `application_title` varchar(255) NOT NULL,
  `url_alias` varchar(255) DEFAULT NULL,
  `cms_active` tinyint(4) NOT NULL DEFAULT 0,
  `online_admission` tinyint(4) NOT NULL DEFAULT 0,
  `theme` varchar(255) NOT NULL,
  `captcha_status` varchar(20) NOT NULL,
  `recaptcha_site_key` varchar(255) NOT NULL,
  `recaptcha_secret_key` varchar(255) NOT NULL,
  `address` varchar(350) NOT NULL,
  `mobile_no` varchar(60) NOT NULL,
  `fax` varchar(60) NOT NULL,
  `receive_contact_email` varchar(255) NOT NULL,
  `email` varchar(60) NOT NULL,
  `copyright_text` varchar(255) NOT NULL,
  `fav_icon` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `footer_about_text` varchar(300) NOT NULL,
  `working_hours` varchar(300) NOT NULL,
  `google_analytics` text DEFAULT NULL,
  `primary_color` varchar(100) NOT NULL DEFAULT '#ff685c',
  `menu_color` varchar(100) NOT NULL DEFAULT '#fff',
  `hover_color` varchar(100) NOT NULL DEFAULT '#f04133',
  `text_color` varchar(100) NOT NULL DEFAULT '#232323',
  `text_secondary_color` varchar(100) NOT NULL DEFAULT '#383838',
  `footer_background_color` varchar(100) NOT NULL DEFAULT '#383838',
  `footer_text_color` varchar(100) NOT NULL DEFAULT '#8d8d8d',
  `copyright_bg_color` varchar(100) NOT NULL DEFAULT '#262626',
  `copyright_text_color` varchar(100) NOT NULL DEFAULT '#8d8d8d',
  `border_radius` varchar(100) NOT NULL DEFAULT '0',
  `facebook_url` varchar(100) NOT NULL,
  `twitter_url` varchar(100) NOT NULL,
  `youtube_url` varchar(100) NOT NULL,
  `google_plus` varchar(100) NOT NULL,
  `linkedin_url` varchar(100) NOT NULL,
  `pinterest_url` varchar(100) NOT NULL,
  `instagram_url` varchar(100) NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `front_cms_setting`
--

INSERT INTO `front_cms_setting` (`id`, `application_title`, `url_alias`, `cms_active`, `online_admission`, `theme`, `captcha_status`, `recaptcha_site_key`, `recaptcha_secret_key`, `address`, `mobile_no`, `fax`, `receive_contact_email`, `email`, `copyright_text`, `fav_icon`, `logo`, `footer_about_text`, `working_hours`, `google_analytics`, `primary_color`, `menu_color`, `hover_color`, `text_color`, `text_secondary_color`, `footer_background_color`, `footer_text_color`, `copyright_bg_color`, `copyright_text_color`, `border_radius`, `facebook_url`, `twitter_url`, `youtube_url`, `google_plus`, `linkedin_url`, `pinterest_url`, `instagram_url`, `branch_id`) VALUES
(1, 'School Management System With CMS', 'example', 0, 1, 'red', 'disable', '', '', 'Your Address', '+12345678', '12345678', 'jamilusalis@gmail.com', 'jamilusalis@gmail.com', 'Copyright © 2026 <span>SmartSchool</span>. All Rights Reserved.', 'fav_icon1.png', 'logo1.png', 'If you are going to use a passage LorIsum, you anythirassing hidden in the middle of text. Lators on the Internet tend to.', '<span>Hours : </span>  Mon To Fri - 10AM - 04PM,  Sunday Closed', NULL, '#ff685c', '#fff', '#f04133', '#232323', '#8d8d8d', '#383838', '#8d8d8d', '#262626', '#8d8d8d', '0', 'https://facebook.com', 'https://twitter.com', 'https://youtube.com', 'https://google.com', 'https://linkedin.com', 'https://pinterest.com', 'https://instagram.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_teachers`
--

CREATE TABLE `front_cms_teachers` (
  `id` int(11) NOT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `meta_description` text NOT NULL,
  `meta_keyword` text NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `front_cms_teachers`
--

INSERT INTO `front_cms_teachers` (`id`, `page_title`, `banner_image`, `meta_description`, `meta_keyword`, `branch_id`) VALUES
(1, 'Teachers', 'teachers1.jpg', 'SmartSchool - School Management System', 'SmartSchool Teachers Page', 1);

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_testimonial`
--

CREATE TABLE `front_cms_testimonial` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(355) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `rank` int(5) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `front_cms_testimonial`
--

INSERT INTO `front_cms_testimonial` (`id`, `name`, `surname`, `image`, `description`, `rank`, `branch_id`, `created_by`, `created_at`) VALUES
(1, 'Gartrell Wright', 'Los Angeles', 'defualt.png', 'Intexure have done an excellent job presenting the analysis & insights. I am confident in saying  have helped encounter  is to be welcomed and every pain avoided”.', 1, 1, 1, '2026-02-12 12:26:42'),
(2, 'Clifton Hyde', 'Newyork City', 'defualt.png', '“Owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repudiated and annoyances accepted always holds”.', 4, 1, 1, '2026-02-12 12:26:42'),
(3, 'Emily Lemus', 'Los Angeles', 'defualt.png', '“Intexure have done an excellent job presenting the analysis & insights. I am confident in saying  have helped encounter  is to be welcomed and every pain avoided”.', 5, 1, 1, '2026-02-12 12:26:42'),
(4, 'Michel Jhon', 'CEO', 'defualt.png', '“Owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repudiated and annoyances accepted always holds”.', 3, 2, 1, '2026-02-12 12:26:42'),
(5, 'Hilda Howard', 'Chicago City', 'defualt.png', '“Owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repudiated and annoyances accepted always holds”.', 4, 2, 1, '2026-02-12 12:26:42');

-- --------------------------------------------------------

--
-- Table structure for table `global_settings`
--

CREATE TABLE `global_settings` (
  `id` int(11) NOT NULL,
  `institute_name` varchar(255) NOT NULL,
  `institution_code` varchar(255) NOT NULL,
  `reg_prefix` varchar(255) NOT NULL,
  `institute_email` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `mobileno` varchar(100) NOT NULL,
  `currency` varchar(100) NOT NULL,
  `currency_symbol` varchar(100) NOT NULL,
  `currency_formats` tinyint(4) NOT NULL DEFAULT 1,
  `symbol_position` tinyint(4) NOT NULL DEFAULT 1,
  `sms_service_provider` varchar(100) NOT NULL,
  `session_id` int(11) NOT NULL,
  `translation` varchar(100) NOT NULL,
  `footer_text` varchar(255) NOT NULL,
  `animations` varchar(100) NOT NULL,
  `timezone` varchar(100) NOT NULL,
  `date_format` varchar(100) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `facebook_url` varchar(255) NOT NULL,
  `twitter_url` varchar(255) NOT NULL,
  `linkedin_url` varchar(255) NOT NULL,
  `youtube_url` varchar(255) NOT NULL,
  `cron_secret_key` varchar(255) DEFAULT NULL,
  `preloader_backend` tinyint(1) NOT NULL DEFAULT 1,
  `footer_branch_switcher` tinyint(1) NOT NULL DEFAULT 1,
  `cms_default_branch` int(11) NOT NULL,
  `cache_store` tinyint(1) NOT NULL DEFAULT 0,
  `image_extension` text DEFAULT NULL,
  `image_size` float NOT NULL DEFAULT 1024,
  `file_extension` text DEFAULT NULL,
  `pid` varchar(255) DEFAULT NULL,
  `file_size` float DEFAULT 1024,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `global_settings`
--

INSERT INTO `global_settings` (`id`, `institute_name`, `institution_code`, `reg_prefix`, `institute_email`, `address`, `mobileno`, `currency`, `currency_symbol`, `currency_formats`, `symbol_position`, `sms_service_provider`, `session_id`, `translation`, `footer_text`, `animations`, `timezone`, `date_format`, `facebook_url`, `twitter_url`, `linkedin_url`, `youtube_url`, `cron_secret_key`, `preloader_backend`, `footer_branch_switcher`, `cms_default_branch`, `cache_store`, `image_extension`, `image_size`, `file_extension`, `pid`, `file_size`, `created_at`, `updated_at`) VALUES
(1, 'Smart School', 'KDS-', 'on', 'jamilusalis@gmail.com', '', '', 'NGN', '₦', 3, 1, 'disabled', 3, 'english', '© 2026 SmartSchool Management System', 'fadeInUp', 'Africa/Lagos', 'd.M.Y', '', '', '', '', '74250cf4dd95bedd3276ebc9888143fa', 1, 0, 0, 0, 'jpeg, jpg, bmp, png', 2048, 'txt, pdf, doc, xls, docx, xlsx, jpg, jpeg, png, gif, bmp, zip, mp4, 7z, wmv, rar', 'N2I3MmY1M2MtOWQzOC00YzUzLWEzOWYtYmU0NDA5ODE0NGQ0', 2048, '2026-02-24 13:31:40', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `grade`
--

CREATE TABLE `grade` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `grade_point` varchar(255) NOT NULL,
  `lower_mark` int(11) NOT NULL,
  `upper_mark` int(11) NOT NULL,
  `remark` text NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `board_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `grade`
--

INSERT INTO `grade` (`id`, `name`, `grade_point`, `lower_mark`, `upper_mark`, `remark`, `branch_id`, `board_id`) VALUES
(1, 'A', '5.0', 75, 100, 'Distinction', 0, 1),
(2, 'B', '4.0', 60, 74, 'Credit', 0, 1),
(3, 'C', '3.0', 50, 59, 'Merit', 0, 1),
(4, 'D', '2.0', 40, 49, 'Pass', 0, 1),
(5, 'E', '1.0', 40, 44, 'Poor', 0, 1),
(6, 'F', '0.0', 0, 39, 'Fail', 0, 1),
(7, 'A1', '4.0', 75, 100, 'Excellent', 0, 2),
(8, 'B2', '3.5', 70, 74, 'Very Good', 0, 2),
(9, 'B3', '3.0', 65, 69, 'Good', 0, 2),
(10, 'C4', '2.5', 60, 64, 'Credit', 0, 2),
(11, 'C5', '2.0', 55, 59, 'Credit', 0, 2),
(12, 'C6', '1.5', 50, 54, 'Credit', 0, 2),
(13, 'D7', '1.0', 45, 49, 'Pass', 0, 2),
(14, 'E8', '0.5', 40, 44, 'Pass', 0, 2),
(15, 'F9', '0.0', 0, 39, 'Fail', 0, 2),
(16, 'A1', '1', 75, 100, 'Excellent', 1, 0),
(17, 'B2', '2', 70, 74, 'Very Good', 1, 0),
(18, 'B3', '3', 65, 69, 'Very Good', 1, 0),
(19, 'C4', '4', 60, 64, 'Credit', 1, 0),
(20, 'C5', '5', 55, 59, 'Credit', 1, 0),
(21, 'C6', '6', 50, 54, 'Credit', 1, 0),
(22, 'D7', '7', 45, 49, 'Pass', 1, 0),
(23, 'E8', '8', 40, 44, 'Poor', 1, 0),
(24, 'F9', '9', 0, 39, 'Fail', 1, 0),
(25, 'A1', '1', 75, 100, 'Excellent', 2, 0),
(26, 'B2', '2', 70, 74, 'Very Good', 2, 0),
(27, 'B3', '3', 65, 69, 'Very Good', 2, 0),
(28, 'C4', '4', 60, 64, 'Credit', 2, 0),
(29, 'C5', '5', 55, 59, 'Credit', 2, 0),
(30, 'C6', '6', 50, 54, 'Credit', 2, 0),
(31, 'D7', '7', 45, 49, 'Pass', 2, 0),
(32, 'E8', '8', 40, 44, 'Poor', 2, 0),
(33, 'F9', '9', 0, 39, 'Fail', 2, 0),
(34, 'A1', '1', 75, 100, 'Excellent', 3, 0),
(35, 'B2', '2', 70, 74, 'Very Good', 3, 0),
(36, 'B3', '3', 65, 69, 'Very Good', 3, 0),
(37, 'C4', '4', 60, 64, 'Credit', 3, 0),
(38, 'C5', '5', 55, 59, 'Credit', 3, 0),
(39, 'C6', '6', 50, 54, 'Credit', 3, 0),
(40, 'D7', '7', 45, 49, 'Pass', 3, 0),
(41, 'E8', '8', 40, 44, 'Poor', 3, 0),
(42, 'F9', '9', 0, 39, 'Fail', 3, 0),
(43, 'A1', '1', 75, 100, 'Excellent', 4, 0),
(44, 'B2', '2', 70, 74, 'Very Good', 4, 0),
(45, 'B3', '3', 65, 69, 'Very Good', 4, 0),
(46, 'C4', '4', 60, 64, 'Credit', 4, 0),
(47, 'C5', '5', 55, 59, 'Credit', 4, 0),
(48, 'C6', '6', 50, 54, 'Credit', 4, 0),
(49, 'D7', '7', 45, 49, 'Pass', 4, 0),
(50, 'E8', '8', 40, 44, 'Poor', 4, 0),
(51, 'F9', '9', 0, 39, 'Fail', 4, 0),
(52, 'A1', '1', 75, 100, 'Excellent', 5, 0),
(53, 'B2', '2', 70, 74, 'Very Good', 5, 0),
(54, 'B3', '3', 65, 69, 'Very Good', 5, 0),
(55, 'C4', '4', 60, 64, 'Credit', 5, 0),
(56, 'C5', '5', 55, 59, 'Credit', 5, 0),
(57, 'C6', '6', 50, 54, 'Credit', 5, 0),
(58, 'D7', '7', 45, 49, 'Pass', 5, 0),
(59, 'E8', '8', 40, 44, 'Poor', 5, 0),
(60, 'F9', '9', 0, 39, 'Fail', 5, 0),
(61, 'A1', '1', 75, 100, 'Excellent', 6, 0),
(62, 'B2', '2', 70, 74, 'Very Good', 6, 0),
(63, 'B3', '3', 65, 69, 'Very Good', 6, 0),
(64, 'C4', '4', 60, 64, 'Credit', 6, 0),
(65, 'C5', '5', 55, 59, 'Credit', 6, 0),
(66, 'C6', '6', 50, 54, 'Credit', 6, 0),
(67, 'D7', '7', 45, 49, 'Pass', 6, 0),
(68, 'E8', '8', 40, 44, 'Poor', 6, 0),
(69, 'F9', '9', 0, 39, 'Fail', 6, 0),
(70, 'A1', '1', 75, 100, 'Excellent', 7, 0),
(71, 'B2', '2', 70, 74, 'Very Good', 7, 0),
(72, 'B3', '3', 65, 69, 'Very Good', 7, 0),
(73, 'C4', '4', 60, 64, 'Credit', 7, 0),
(74, 'C5', '5', 55, 59, 'Credit', 7, 0),
(75, 'C6', '6', 50, 54, 'Credit', 7, 0),
(76, 'D7', '7', 45, 49, 'Pass', 7, 0),
(77, 'E8', '8', 40, 44, 'Poor', 7, 0),
(78, 'F9', '9', 0, 39, 'Fail', 7, 0),
(79, 'A1', '1', 75, 100, 'Excellent', 8, 0),
(80, 'B2', '2', 70, 74, 'Very Good', 8, 0),
(81, 'B3', '3', 65, 69, 'Very Good', 8, 0),
(82, 'C4', '4', 60, 64, 'Credit', 8, 0),
(83, 'C5', '5', 55, 59, 'Credit', 8, 0),
(84, 'C6', '6', 50, 54, 'Credit', 8, 0),
(85, 'D7', '7', 45, 49, 'Pass', 8, 0),
(86, 'E8', '8', 40, 44, 'Poor', 8, 0),
(87, 'F9', '9', 0, 39, 'Fail', 8, 0),
(88, 'A1', '1', 75, 100, 'Excellent', 9, 0),
(89, 'B2', '2', 70, 74, 'Very Good', 9, 0),
(90, 'B3', '3', 65, 69, 'Very Good', 9, 0),
(91, 'C4', '4', 60, 64, 'Credit', 9, 0),
(92, 'C5', '5', 55, 59, 'Credit', 9, 0),
(93, 'C6', '6', 50, 54, 'Credit', 9, 0),
(94, 'D7', '7', 45, 49, 'Pass', 9, 0),
(95, 'E8', '8', 40, 44, 'Poor', 9, 0),
(96, 'F9', '9', 0, 39, 'Fail', 9, 0),
(97, 'A1', '1', 75, 100, 'Excellent', 10, 0),
(98, 'B2', '2', 70, 74, 'Very Good', 10, 0),
(99, 'B3', '3', 65, 69, 'Very Good', 10, 0),
(100, 'C4', '4', 60, 64, 'Credit', 10, 0),
(101, 'C5', '5', 55, 59, 'Credit', 10, 0),
(102, 'C6', '6', 50, 54, 'Credit', 10, 0),
(103, 'D7', '7', 45, 49, 'Pass', 10, 0),
(104, 'E8', '8', 40, 44, 'Poor', 10, 0),
(105, 'F9', '9', 0, 39, 'Fail', 10, 0);

-- --------------------------------------------------------

--
-- Table structure for table `hall_allocation`
--

CREATE TABLE `hall_allocation` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `hall_no` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `homework`
--

CREATE TABLE `homework` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `date_of_homework` date NOT NULL,
  `date_of_submission` date NOT NULL,
  `description` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `create_date` date NOT NULL,
  `status` varchar(10) NOT NULL,
  `sms_notification` tinyint(2) NOT NULL,
  `schedule_date` date DEFAULT NULL,
  `document` varchar(255) NOT NULL,
  `evaluation_date` date DEFAULT NULL,
  `evaluated_by` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `homework_evaluation`
--

CREATE TABLE `homework_evaluation` (
  `id` int(11) NOT NULL,
  `homework_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `remark` text NOT NULL,
  `rank` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `homework_submit`
--

CREATE TABLE `homework_submit` (
  `id` int(11) NOT NULL,
  `homework_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `message` varchar(355) NOT NULL,
  `enc_name` varchar(355) DEFAULT NULL,
  `file_name` varchar(355) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hostel`
--

CREATE TABLE `hostel` (
  `id` int(11) NOT NULL,
  `name` longtext NOT NULL,
  `category_id` int(11) NOT NULL,
  `address` longtext NOT NULL,
  `watchman` longtext NOT NULL,
  `remarks` longtext DEFAULT NULL,
  `branch_id` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hostel_category`
--

CREATE TABLE `hostel_category` (
  `id` int(11) NOT NULL,
  `name` longtext NOT NULL,
  `description` longtext DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `type` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `board_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `hostel_category`
--

INSERT INTO `hostel_category` (`id`, `name`, `description`, `branch_id`, `type`, `created_at`, `updated_at`, `board_id`) VALUES
(1, 'Residential', 'Only seat for resident', 1, 'room', '2026-03-27 09:31:18', NULL, NULL),
(2, 'Residential For Girls', 'Only For Girls.', 1, 'hostel', '2026-03-27 09:31:36', NULL, NULL),
(3, 'Residential For Boys', 'For Boys', 1, 'hostel', '2026-03-27 09:31:55', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hostel_room`
--

CREATE TABLE `hostel_room` (
  `id` int(11) NOT NULL,
  `name` longtext NOT NULL,
  `hostel_id` int(11) NOT NULL,
  `no_beds` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `bed_fee` decimal(18,2) NOT NULL,
  `remarks` longtext NOT NULL,
  `branch_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `infrastructure`
--

CREATE TABLE `infrastructure` (
  `id` int(10) UNSIGNED NOT NULL,
  `branch_id` int(10) UNSIGNED NOT NULL,
  `type` varchar(60) NOT NULL DEFAULT '',
  `name` varchar(150) NOT NULL DEFAULT '',
  `quantity` smallint(6) NOT NULL DEFAULT 1,
  `capacity` smallint(6) NOT NULL DEFAULT 0,
  `condition` enum('Good','Fair','Poor','Condemned') NOT NULL DEFAULT 'Good',
  `year_built` smallint(6) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inspection_deficiencies`
--

CREATE TABLE `inspection_deficiencies` (
  `id` int(11) NOT NULL,
  `inspection_id` int(11) NOT NULL,
  `category` enum('Infrastructure','Staffing','Resources','Compliance') NOT NULL DEFAULT 'Infrastructure',
  `description` text NOT NULL,
  `severity` enum('Critical','Moderate','Minor') NOT NULL DEFAULT 'Moderate',
  `remediation_status` enum('Open','In Progress','Resolved') NOT NULL DEFAULT 'Open',
  `resolved_at` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `inspection_deficiencies`
--

INSERT INTO `inspection_deficiencies` (`id`, `inspection_id`, `category`, `description`, `severity`, `remediation_status`, `resolved_at`, `created_at`) VALUES
(1, 1, 'Staffing', 'ONLY 1 teachers teachers 4 classes', 'Critical', 'Open', NULL, '2026-04-15 11:27:22'),
(2, 1, 'Infrastructure', 'roofing are licking', 'Moderate', 'Open', NULL, '2026-04-15 11:28:52'),
(3, 1, 'Resources', 'Needs more computers', 'Moderate', 'Open', NULL, '2026-04-15 11:28:52'),
(4, 1, 'Compliance', 'Needs trained the trainers session', 'Minor', 'Open', NULL, '2026-04-15 11:28:52');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `word` varchar(255) NOT NULL,
  `english` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `word`, `english`) VALUES
(1, 'language', 'Language'),
(2, 'attendance_overview', 'Attendance Overview'),
(3, 'annual_fee_summary', 'Annual Fee Summary'),
(4, 'my_annual_attendance_overview', 'My Annual Attendance Overview'),
(5, 'schedule', 'Schedule'),
(6, 'student_admission', 'Student Admission'),
(7, 'returned', 'Returned'),
(8, 'user_name', 'User Name'),
(9, 'rejected', 'Rejected'),
(10, 'route_name', 'Route Name'),
(11, 'route_fare', 'Route Fare'),
(12, 'edit_route', 'Edit Route'),
(13, 'this_value_is_required', 'This value is required.'),
(14, 'vehicle_no', 'Vehicle No'),
(15, 'insurance_renewal_date', 'Insurance Renewal Date'),
(16, 'driver_name', 'Driver Name'),
(17, 'driver_license', 'Driver License'),
(18, 'select_route', 'Select Route'),
(19, 'edit_vehicle', 'Edit Vehicle'),
(20, 'add_students', 'Add Students'),
(21, 'vehicle_number', 'Vehicle Number'),
(22, 'select_route_first', 'Select Route First'),
(23, 'transport_fee', 'Transport Fee'),
(24, 'control', 'Control'),
(25, 'set_students', 'Set Students'),
(26, 'hostel_list', 'Hostel List'),
(27, 'watchman_name', 'Watchman Name'),
(28, 'hostel_address', 'Hostel Address'),
(29, 'edit_hostel', 'Edit Hostel'),
(30, 'room_name', 'Room Name'),
(31, 'no_of_beds', 'No Of Beds'),
(32, 'select_hostel_first', 'Select Hostel First'),
(33, 'remaining', 'Remaining'),
(34, 'hostel_fee', 'Hostel Fee'),
(35, 'accountant_list', 'Accountant List'),
(36, 'students_fees', 'Students Fees'),
(37, 'fees_status', 'Fees Status'),
(38, 'books', 'Books'),
(39, 'home_page', 'Home Page'),
(40, 'collected', 'Collected'),
(41, 'student_mark', 'Student Mark'),
(42, 'select_exam_first', 'Select Exam First'),
(43, 'transport_details', 'Transport Details'),
(44, 'no_of_teacher', 'No of Teacher'),
(45, 'basic_details', 'Basic Details'),
(46, 'fee_progress', 'Fee Progress'),
(47, 'word', 'Word'),
(48, 'book_category', 'Book Category'),
(49, 'driver_phone', 'Driver Phone'),
(50, 'invalid_csv_file', 'Invalid / Corrupted CSV File'),
(51, 'requested_book_list', 'Requested Book List'),
(52, 'request_status', 'Request Status'),
(53, 'book_request', 'Book Request'),
(54, 'logout', 'Logout'),
(55, 'select_payment_method', 'Select Payment Method'),
(56, 'select_method', 'Select Method'),
(57, 'payment', 'Payment'),
(58, 'filter', 'Filter'),
(59, 'status', 'Status'),
(60, 'paid', 'Paid'),
(61, 'unpaid', 'Unpaid'),
(62, 'method', 'Method'),
(63, 'cash', 'Cash'),
(64, 'check', 'Check'),
(65, 'card', 'Card'),
(66, 'payment_history', 'Payment History'),
(67, 'category', 'Category'),
(68, 'book_list', 'Book List'),
(69, 'author', 'Author'),
(70, 'price', 'Price'),
(71, 'available', 'Available'),
(72, 'unavailable', 'Unavailable'),
(73, 'transport_list', 'Transport List'),
(74, 'edit_transport', 'Edit Transport'),
(75, 'hostel_name', 'Hostel Name'),
(76, 'number_of_room', 'Hostel Of Room'),
(77, 'yes', 'Yes'),
(78, 'no', 'No'),
(79, 'messages', 'Messages'),
(80, 'compose', 'Compose'),
(81, 'recipient', 'Recipient'),
(82, 'select_a_user', 'Select A User'),
(83, 'send', 'Send'),
(84, 'global_settings', 'Global Settings'),
(85, 'currency', 'Currency'),
(86, 'system_email', 'System Email'),
(87, 'create', 'Create'),
(88, 'save', 'Save'),
(89, 'file', 'File'),
(90, 'theme_settings', 'Theme Settings'),
(91, 'default', 'Default'),
(92, 'select_theme', 'Select Theme'),
(93, 'upload_logo', 'Upload Logo'),
(94, 'upload', 'Upload'),
(95, 'remember', 'Remember'),
(96, 'not_selected', 'Not Selected'),
(97, 'disabled', 'Disabled'),
(98, 'inactive_account', 'Inactive Account'),
(99, 'update_translations', 'Update Translations'),
(100, 'language_list', 'Language List'),
(101, 'option', 'Option'),
(102, 'edit_word', 'Edit Word'),
(103, 'update_profile', 'Update Profile'),
(104, 'current_password', 'Current Password'),
(105, 'new_password', 'New Password'),
(106, 'login', 'Login'),
(107, 'reset_password', 'Reset Password'),
(108, 'present', 'Present'),
(109, 'absent', 'Absent'),
(110, 'update_attendance', 'Update Attendance'),
(111, 'undefined', 'Undefined'),
(112, 'back', 'Back'),
(113, 'save_changes', 'Save Changes'),
(114, 'uploader', 'Uploader'),
(115, 'download', 'Download'),
(116, 'remove', 'Remove'),
(117, 'print', 'Print'),
(118, 'select_file_type', 'Select File Type'),
(119, 'excel', 'Excel'),
(120, 'other', 'Other'),
(121, 'students_of_class', 'Students Of Class'),
(122, 'marks_obtained', 'Marks Obtained'),
(123, 'attendance_for_class', 'Attendance For Class'),
(124, 'receiver', 'Receiver'),
(125, 'please_select_receiver', 'Please Select Receiver'),
(126, 'session_changed', 'Session Changed'),
(127, 'exam_marks', 'Exam Marks'),
(128, 'total_mark', 'Total Mark'),
(129, 'mark_obtained', 'Mark Obtained'),
(130, 'invoice/payment_list', 'Invoice / Payment List'),
(131, 'obtained_marks', 'Obtained Marks'),
(132, 'highest_mark', 'Highest Mark'),
(133, 'grade', 'Grade (GPA)'),
(134, 'dashboard', 'Dashboard'),
(135, 'student', 'Student'),
(136, 'rename', 'Rename'),
(137, 'class', 'Class'),
(138, 'teacher', 'Teacher'),
(139, 'parents', 'Parents'),
(140, 'subject', 'Subject'),
(141, 'student_attendance', 'Student Attendance'),
(142, 'exam_list', 'Exam List'),
(143, 'grades_range', 'Grades Range'),
(144, 'loading', 'Loading'),
(145, 'library', 'Library'),
(146, 'hostel', 'Hostel'),
(147, 'events', 'Events'),
(148, 'message', 'Message'),
(149, 'translations', 'Translations'),
(150, 'account', 'Account'),
(151, 'selected_session', 'Selected Session'),
(152, 'change_password', 'Change Password'),
(153, 'section', 'Section'),
(154, 'edit', 'Edit'),
(155, 'delete', 'Delete'),
(156, 'cancel', 'Cancel'),
(157, 'parent', 'Parent'),
(158, 'attendance', 'Attendance'),
(159, 'addmission_form', 'Admission Form'),
(160, 'name', 'Name'),
(161, 'select', 'Select'),
(162, 'roll', 'Roll'),
(163, 'birthday', 'Date Of Birth'),
(164, 'gender', 'Gender'),
(165, 'male', 'Male'),
(166, 'female', 'Female'),
(167, 'address', 'Address'),
(168, 'phone', 'Phone'),
(169, 'email', 'Email'),
(170, 'password', 'Password'),
(171, 'transport_route', 'Transport Route'),
(172, 'photo', 'Photo'),
(173, 'select_class', 'Select Class'),
(174, 'username_password_incorrect', 'Username Or Password Is Incorrect'),
(175, 'select_section', 'Select Section'),
(176, 'options', 'Options'),
(177, 'mark_sheet', 'Mark Sheet'),
(178, 'profile', 'Profile'),
(179, 'select_all', 'Select All'),
(180, 'select_none', 'Select None'),
(181, 'average', 'Average'),
(182, 'transfer', 'Transfer'),
(183, 'edit_teacher', 'Edit Teacher'),
(184, 'sex', 'Sex'),
(185, 'marksheet_for', 'Marksheet For'),
(186, 'total_marks', 'Total Marks'),
(187, 'parent_phone', 'Parent Phone'),
(188, 'subject_author', 'Curriculum PDF'),
(189, 'update', 'Update'),
(190, 'class_list', 'Class List'),
(191, 'class_name', 'Class Name'),
(192, 'name_numeric', 'Name Numeric'),
(193, 'select_teacher', 'Select Teacher'),
(194, 'edit_class', 'Edit Class'),
(195, 'section_name', 'Section Name'),
(196, 'add_section', 'Add Section'),
(197, 'subject_list', 'Subject List'),
(198, 'subject_name', 'Subject Name'),
(199, 'edit_subject', 'Edit Subject'),
(200, 'day', 'Day'),
(201, 'starting_time', 'Starting Time'),
(202, 'hour', 'Hour'),
(203, 'minutes', 'Minutes'),
(204, 'ending_time', 'Ending Time'),
(205, 'select_subject', 'Select Subject'),
(206, 'select_date', 'Select Date'),
(207, 'select_month', 'Select Month'),
(208, 'select_year', 'Select Year'),
(209, 'add_language', 'Add Language'),
(210, 'exam_name', 'Exam Name'),
(211, 'date', 'Date'),
(212, 'comment', 'Comment'),
(213, 'edit_exam', 'Edit Exam'),
(214, 'grade_list', 'Grade List'),
(215, 'grade_name', 'Grade Name'),
(216, 'grade_point', 'Grade Point'),
(217, 'select_exam', 'Select Exam'),
(218, 'students', 'Students'),
(219, 'subjects', 'Subjects'),
(220, 'total', 'Total'),
(221, 'select_academic_session', 'Select Academic Session'),
(222, 'invoice_informations', 'Invoice Informations'),
(223, 'title', 'Title'),
(224, 'description', 'Description'),
(225, 'payment_informations', 'Payment Informations'),
(226, 'view_invoice', 'View Invoice'),
(227, 'payment_to', 'Payment To'),
(228, 'bill_to', 'Bill To'),
(229, 'total_amount', 'Total Amount'),
(230, 'paid_amount', 'Paid Amount'),
(231, 'due', 'Due'),
(232, 'amount_paid', 'Amount Paid'),
(233, 'payment_successfull', 'Payment has been successful'),
(234, 'add_invoice/payment', 'Add Invoice/payment'),
(235, 'invoices', 'Invoices'),
(236, 'action', 'Action'),
(237, 'required', 'Required'),
(238, 'info', 'Info'),
(239, 'month', 'Month'),
(240, 'details', 'Details'),
(241, 'new', 'New'),
(242, 'reply_message', 'Reply Message'),
(243, 'message_sent', 'Message Sent'),
(244, 'search', 'Search'),
(245, 'religion', 'Religion'),
(246, 'blood_group', 'Blood group'),
(247, 'database_backup', 'Database Backup'),
(248, 'search', 'Search'),
(249, 'payments_history', 'Payment History'),
(250, 'message_restore', 'Message Restore'),
(251, 'write_new_message', 'Write New Message'),
(252, 'attendance_sheet', 'Attendance Sheet'),
(253, 'holiday', 'Holiday'),
(254, 'exam', 'Exam'),
(255, 'successfully', 'Successfully'),
(256, 'admin', 'Admin'),
(257, 'inbox', 'Inbox'),
(258, 'sent', 'Sent'),
(259, 'important', 'Important'),
(260, 'trash', 'Trash'),
(261, 'error', 'Unsuccessful'),
(262, 'sessions_list', 'Sessions List'),
(263, 'session_settings', 'Session Settings'),
(264, 'add_designation', 'Add Designation'),
(265, 'users', 'Users'),
(266, 'librarian', 'Librarian'),
(267, 'accountant', 'Accountant'),
(268, 'academics', 'Academics'),
(269, 'employees_attendance', 'Employees Attendance'),
(270, 'set_exam_term', 'Set Exam Term'),
(271, 'set_attendance', 'Set Attendance'),
(272, 'marks', 'Marks'),
(273, 'books_category', 'Books Category'),
(274, 'transport', 'Transport'),
(275, 'fees', 'Fees'),
(276, 'fees_allocation', 'Levy Allocation'),
(277, 'fee_category', 'Fee Category'),
(278, 'report', 'Report'),
(279, 'employee', 'Employee'),
(280, 'invoice', 'Invoice'),
(281, 'event_catalogue', 'Event Catalogue'),
(282, 'total_paid', 'Total Paid'),
(283, 'total_due', 'Total Due'),
(284, 'fees_collect', 'Fees Collect'),
(285, 'total_school_students_attendance', 'Total School Students Attendance'),
(286, 'overview', 'Overview'),
(287, 'currency_symbol', 'Currency Symbol'),
(288, 'enable', 'Enable'),
(289, 'disable', 'Disable'),
(290, 'payment_settings', 'Payment Settings'),
(291, 'student_attendance_report', 'Student Attendance Report'),
(292, 'attendance_type', 'Attendance Type'),
(293, 'late', 'Late'),
(294, 'employees_attendance_report', 'Employees Attendance Report'),
(295, 'attendance_report_of', 'Attendance Report Of'),
(296, 'fee_paid_report', 'Fee Paid Report'),
(297, 'invoice_no', 'Invoice No'),
(298, 'payment_mode', 'Payment Mode'),
(299, 'payment_type', 'Payment Type'),
(300, 'done', 'Done'),
(301, 'select_fee_category', 'Select Fee Category'),
(302, 'discount', 'Discount'),
(303, 'enter_discount_amount', 'Enter Discount Amount'),
(304, 'online_payment', 'Online Payment'),
(305, 'student_name', 'Student Name'),
(306, 'invoice_history', 'Invoice History'),
(307, 'discount_amount', 'Discount Amount'),
(308, 'invoice_list', 'Invoice List'),
(309, 'partly_paid', 'Partly Paid'),
(310, 'fees_list', 'Fees List'),
(311, 'voucher_id', 'Voucher ID'),
(312, 'transaction_date', 'Transaction Date'),
(313, 'admission_date', 'Admission Date'),
(314, 'user_status', 'User Status'),
(315, 'nationality', 'Nationality'),
(316, 'register_no', 'Register No'),
(317, 'first_name', 'First Name'),
(318, 'last_name', 'Last Name'),
(319, 'state', 'State'),
(320, 'transport_vehicle_no', 'Transport Vehicle No'),
(321, 'percent', 'Percent'),
(322, 'average_result', 'Average Result'),
(323, 'student_category', 'Student Category'),
(324, 'category_name', 'Category Name'),
(325, 'category_list', 'Category List'),
(326, 'please_select_student_first', 'Please Select Students First'),
(327, 'designation', 'Designation'),
(328, 'qualification', 'Qualification'),
(329, 'account_deactivated', 'Account Deactivated'),
(330, 'account_activated', 'Account Activated'),
(331, 'designation_list', 'Designation List'),
(332, 'joining_date', 'Joining Date'),
(333, 'relation', 'Relation'),
(334, 'father_name', 'Father Name'),
(335, 'librarian_list', 'Librarian List'),
(336, 'class_numeric', 'Class Numeric'),
(337, 'maximum_students', 'Maximum Students'),
(338, 'class_room', 'Class Room'),
(339, 'pass_mark', 'Pass Mark'),
(340, 'exam_time', 'Exam Time (Min)'),
(341, 'time', 'Time'),
(342, 'subject_code', 'Subject Code'),
(343, 'full_mark', 'Full Mark'),
(344, 'subject_type', 'Subject Type'),
(345, 'date_of_publish', 'Date Of Publish'),
(346, 'file_name', 'File Name'),
(347, 'students_list', 'Students List'),
(348, 'start_date', 'Start Date'),
(349, 'end_date', 'End Date'),
(350, 'term_name', 'Term Name'),
(351, 'grand_total', 'Grand Total'),
(352, 'result', 'Result'),
(353, 'books_list', 'Books List'),
(354, 'book_isbn_no', 'Book ISBN No'),
(355, 'total_stock', 'Total Stock'),
(356, 'issued_copies', 'Issued Copies'),
(357, 'publisher', 'Publisher'),
(358, 'books_issue', 'Books Issue'),
(359, 'user', 'User'),
(360, 'fine', 'Fine'),
(361, 'pending', 'Pending'),
(362, 'return_date', 'Return Date'),
(363, 'accept', 'Accept'),
(364, 'reject', 'Reject'),
(365, 'issued', 'Issued'),
(366, 'return', 'Return'),
(367, 'renewal', 'Renewal'),
(368, 'fine_amount', 'Fine Amount'),
(369, 'password_mismatch', 'Password Mismatch'),
(370, 'settings_updated', 'Settings Update'),
(371, 'pass', 'Pass'),
(372, 'event_to', 'Event To'),
(373, 'all_users', 'All Users'),
(374, 'employees_list', 'Employees List'),
(375, 'on', 'On'),
(376, 'timezone', 'Timezone'),
(377, 'get_result', 'Get Result'),
(378, 'apply', 'Apply'),
(379, 'hrm', 'Human Resource'),
(380, 'payroll', 'Payroll'),
(381, 'salary_assign', 'Salary Assign'),
(382, 'employee_salary', 'Payment Salary'),
(383, 'application', 'Application'),
(384, 'award', 'Award'),
(385, 'basic_salary', 'Basic Salary'),
(386, 'employee_name', 'Employee Name'),
(387, 'name_of_allowance', 'Name Of Allowance'),
(388, 'name_of_deductions', 'Name Of Deductions'),
(389, 'all_employees', 'All Employees'),
(390, 'total_allowance', 'Total Allowance'),
(391, 'total_deduction', 'Total Deductions'),
(392, 'net_salary', 'Net Salary'),
(393, 'payslip', 'Payslip'),
(394, 'days', 'Days'),
(395, 'category_name_already_used', 'Category Name Already Used'),
(396, 'leave_list', 'Leave List'),
(397, 'leave_category', 'Leave Category'),
(398, 'applied_on', 'Applied On'),
(399, 'accepted', 'Accepted'),
(400, 'leave_statistics', 'Leave Statistics'),
(401, 'leave_type', 'Leave Type'),
(402, 'reason', 'Reason'),
(403, 'close', 'Close'),
(404, 'give_award', 'Give Award'),
(405, 'list', 'List'),
(406, 'award_name', 'Award Name'),
(407, 'gift_item', 'Gift Item'),
(408, 'cash_price', 'Cash Price'),
(409, 'award_reason', 'Award Reason'),
(410, 'given_date', 'Given Date'),
(411, 'apply_leave', 'Apply Leave'),
(412, 'leave_application', 'Leave Application'),
(413, 'allowances', 'Allowances'),
(414, 'add_more', 'Add More'),
(415, 'deductions', 'Deductions'),
(416, 'salary_details', 'Salary Details'),
(417, 'salary_month', 'Salary Month'),
(418, 'leave_data_update_successfully', 'Leave Data Updated Successfully'),
(419, 'fees_history', 'Fees History'),
(420, 'bank_name', 'Bank Name'),
(421, 'branch', 'Branch'),
(422, 'bank_address', 'Bank Address'),
(423, 'ifsc_code', 'IFSC Code'),
(424, 'account_no', 'Account No'),
(425, 'add_bank', 'Add Bank'),
(426, 'account_name', 'Account Holder'),
(427, 'database_backup_completed', 'Database Backup Completed'),
(428, 'restore_database', 'Restore Database'),
(429, 'template', 'Template'),
(430, 'time_and_date', 'Time And Date'),
(431, 'everyone', 'Everyone'),
(432, 'invalid_amount', 'Invalid Amount'),
(433, 'leaving_date_is_not_available_for_you', 'Leaving Date Is Not Available For You'),
(434, 'animations', 'Animations'),
(435, 'email_settings', 'Email Settings'),
(436, 'deduct_month', 'Deduct Month'),
(437, 'no_employee_available', 'No Employee Available'),
(438, 'advance_salary_application_submitted', 'Advance Salary Application Submitted'),
(439, 'date_format', 'Date Format'),
(440, 'id_card_generate', 'ID Card Generate'),
(441, 'issue_salary', 'Issue Salary'),
(442, 'advance_salary', 'Advance Salary'),
(443, 'logo', 'Logo'),
(444, 'book_request', 'Book Request'),
(445, 'reporting', 'Reporting'),
(446, 'paid_salary', 'Paid Salary'),
(447, 'due_salary', 'Due Salary'),
(448, 'route', 'Route'),
(449, 'academic_details', 'Academic Details'),
(450, 'guardian_details', 'Guardian Details'),
(451, 'due_amount', 'Due Amount'),
(452, 'fee_due_report', 'Fee Due Report'),
(453, 'other_details', 'Other Details'),
(454, 'last_exam_report', 'Last Exam Report'),
(455, 'book_issued', 'Book Issued'),
(456, 'interval_month', 'Interval 30 Days'),
(457, 'attachments', 'Attachments'),
(458, 'fees_payment', 'Fees Payment'),
(459, 'fees_summary', 'Fees Summary'),
(460, 'total_fees', 'Total Fees'),
(461, 'weekend_attendance_inspection', 'Weekend Attendance Inspection'),
(462, 'book_issued_list', 'Book Issued List'),
(463, 'lose_your_password', 'Lose Your Password?'),
(464, 'all_branch_dashboard', 'All Branch Dashboard'),
(465, 'academic_session', 'Academic Session'),
(466, 'all_branches', 'All Branches'),
(467, 'admission', 'Admission'),
(468, 'create_admission', 'Create Admission'),
(469, 'multiple_import', 'Multiple Import'),
(470, 'student_details', 'Student Details'),
(471, 'student_list', 'Student List'),
(472, 'login_deactivate', 'Login Deactivate'),
(473, 'parents_list', 'Parents List'),
(474, 'add_parent', 'Add Parent'),
(475, 'employee_list', 'Employee List'),
(476, 'add_department', 'Add Department'),
(477, 'add_employee', 'Add Employee'),
(478, 'salary_template', 'Salary Template'),
(479, 'salary_payment', 'Salary Payment'),
(480, 'payroll_summary', 'Payroll Summary'),
(481, 'academic', 'Academic'),
(482, 'control_classes', 'Control Classes'),
(483, 'assign_class_teacher', 'Assign Class Teacher'),
(484, 'class_assign', 'Class Assign'),
(485, 'assign', 'Assign'),
(486, 'promotion', 'Promotion'),
(487, 'attachments_book', 'Attachments Book'),
(488, 'upload_content', 'Upload Content'),
(489, 'attachment_type', 'Attachment Type'),
(490, 'exam_master', 'Exam Master'),
(491, 'exam_hall', 'Exam Hall'),
(492, 'mark_entries', 'Mark Entries'),
(493, 'tabulation_sheet', 'Tabulation Sheet'),
(494, 'supervision', 'Supervision'),
(495, 'hostel_master', 'Hostel Master'),
(496, 'hostel_room', 'Hostel Room'),
(497, 'allocation_report', 'Allocation Report'),
(498, 'route_master', 'Route Master'),
(499, 'vehicle_master', 'Vehicle Master'),
(500, 'stoppage', 'Stoppage'),
(501, 'assign_vehicle', 'Assign Vehicle'),
(502, 'reports', 'Reports'),
(503, 'books_entry', 'Books Entry'),
(504, 'event_type', 'Event Type'),
(505, 'add_events', 'Add Events'),
(506, 'student_accounting', 'Levies & Charges'),
(507, 'create_single_invoice', 'Create Single Invoice'),
(508, 'create_multi_invoice', 'Create Multi Invoice'),
(509, 'summary_report', 'Summary Report'),
(510, 'office_accounting', 'Office Accounting'),
(511, 'under_group', 'Under Group'),
(512, 'bank_account', 'Bank Account'),
(513, 'ledger_account', 'Ledger Account'),
(514, 'create_voucher', 'Create Voucher'),
(515, 'day_book', 'Day Book'),
(516, 'cash_book', 'Cash Book'),
(517, 'bank_book', 'Bank Book'),
(518, 'ledger_book', 'Ledger Book'),
(519, 'trial_balance', 'Trial Balance'),
(520, 'settings', 'Settings'),
(521, 'sms_settings', 'Sms Settings'),
(522, 'cash_book_of', 'Cash Book Of'),
(523, 'by_cash', 'By Cash'),
(524, 'by_bank', 'By Bank'),
(525, 'total_strength', 'Total Strength'),
(526, 'teachers', 'Teachers'),
(527, 'student_quantity', 'Student Quantity'),
(528, 'voucher', 'Voucher'),
(529, 'total_number', 'Total Number'),
(530, 'total_route', 'Total Route'),
(531, 'total_room', 'Total Room'),
(532, 'amount', 'Amount'),
(533, 'branch_dashboard', 'Branch Dashboard'),
(534, 'branch_list', 'Branch List'),
(535, 'create_branch', 'Create Branch'),
(536, 'branch_name', 'Branch Name'),
(537, 'school_name', 'School Name'),
(538, 'mobile_no', 'Mobile No'),
(539, 'symbol', 'Symbol'),
(540, 'city', 'City'),
(541, 'academic_year', 'Academic Year'),
(542, 'select_branch_first', 'First Select The Branch'),
(543, 'select_class_first', 'Select Class First'),
(544, 'select_country', 'Select Country'),
(545, 'mother_tongue', 'Mother Tongue'),
(546, 'caste', 'Caste'),
(547, 'present_address', 'Present Address'),
(548, 'permanent_address', 'Permanent Address'),
(549, 'profile_picture', 'Profile Picture'),
(550, 'login_details', 'Login Details'),
(551, 'retype_password', 'Retype Password'),
(552, 'occupation', 'Occupation'),
(553, 'income', 'Income'),
(554, 'education', 'Education'),
(555, 'first_select_the_route', 'First Select The Route'),
(556, 'hostel_details', 'Hostel Details'),
(557, 'first_select_the_hostel', 'First Select The Hostel'),
(558, 'previous_school_details', 'Previous School Details'),
(559, 'book_name', 'Book Name'),
(560, 'select_ground', 'Select Ground'),
(561, 'import', 'Import'),
(562, 'add_student_category', 'Add Student Category'),
(563, 'id', 'Id'),
(564, 'edit_category', 'Edit Category'),
(565, 'deactivate_account', 'Deactivate Account'),
(566, 'all_sections', 'All Sections'),
(567, 'authentication_activate', 'Authentication Activate'),
(568, 'department', 'Department'),
(569, 'salary_grades', 'Salary Grades'),
(570, 'overtime', 'Overtime Rate (Per Hour)'),
(571, 'salary_grade', 'Salary Grade'),
(572, 'payable_type', 'Payable Type'),
(573, 'edit_type', 'Edit Type'),
(574, 'role', 'Role'),
(575, 'remuneration_info_for', 'Remuneration Info For'),
(576, 'salary_paid', 'Salary Paid'),
(577, 'salary_unpaid', 'Salary Unpaid'),
(578, 'pay_now', 'Pay Now'),
(579, 'employee_role', 'Employee Role'),
(580, 'create_at', 'Create At'),
(581, 'select_employee', 'Select Employee'),
(582, 'review', 'Review'),
(583, 'reviewed_by', 'Reviewed By'),
(584, 'submitted_by', 'Submitted By'),
(585, 'employee_type', 'Employee Type'),
(586, 'approved', 'Approved'),
(587, 'unreviewed', 'Unreviewed'),
(588, 'creation_date', 'Creation Date'),
(589, 'no_information_available', 'No Information Available'),
(590, 'continue_to_payment', 'Continue To Payment'),
(591, 'overtime_total_hour', 'Overtime Total Hour'),
(592, 'overtime_amount', 'Overtime Amount'),
(593, 'remarks', 'Remarks'),
(594, 'view', 'View'),
(595, 'leave_appeal', 'Leave Appeal'),
(596, 'create_leave', 'Create Leave'),
(597, 'user_role', 'User Role'),
(598, 'date_of_start', 'Date Of Start'),
(599, 'date_of_end', 'Date Of End'),
(600, 'winner', 'Winner'),
(601, 'select_user', 'Select User'),
(602, 'create_class', 'Create Class'),
(603, 'class_teacher_allocation', 'Class Teacher Allocation'),
(604, 'class_teacher', 'Class Teacher'),
(605, 'create_subject', 'Create Subject'),
(606, 'select_multiple_subject', 'Select Multiple Subject'),
(607, 'teacher_assign', 'Teacher Assign'),
(608, 'teacher_assign_list', 'Teacher Assign List'),
(609, 'select_department_first', 'Select Department First'),
(610, 'create_book', 'Create Book'),
(611, 'book_title', 'Book Title'),
(612, 'cover', 'Cover'),
(613, 'edition', 'Edition'),
(614, 'isbn_no', 'ISBN No'),
(615, 'purchase_date', 'Purchase Date'),
(616, 'cover_image', 'Cover Image'),
(617, 'book_issue', 'Book Issue'),
(618, 'date_of_issue', 'Date Of Issue'),
(619, 'date_of_expiry', 'Date Of Expiry'),
(620, 'select_category_first', 'Select Category First'),
(621, 'type_name', 'Type Name'),
(622, 'type_list', 'Type List'),
(623, 'icon', 'Icon'),
(624, 'event_list', 'Event List'),
(625, 'create_event', 'Create Event'),
(626, 'type', 'Type'),
(627, 'audience', 'Audience'),
(628, 'created_by', 'Created By'),
(629, 'publish', 'Publish'),
(630, 'everybody', 'Everybody'),
(631, 'selected_class', 'Selected Class'),
(632, 'selected_section', 'Selected Section'),
(633, 'information_has_been_updated_successfully', 'Information Has Been Updated Successfully'),
(634, 'create_invoice', 'Create Invoice'),
(635, 'invoice_entry', 'Invoice Entry'),
(636, 'quick_payment', 'Quick Payment'),
(637, 'write_your_remarks', 'Write Your Remarks'),
(638, 'reset', 'Reset'),
(639, 'fees_payment_history', 'Fees Payment History'),
(640, 'fees_summary_report', 'Fees Summary Report'),
(641, 'add_account_group', 'Add Account Group'),
(642, 'account_group', 'Account Group'),
(643, 'account_group_list', 'Account Group List'),
(644, 'mailbox', 'Mailbox'),
(645, 'refresh_mail', 'Refresh Mail'),
(646, 'sender', 'Sender'),
(647, 'general_settings', 'General Settings'),
(648, 'institute_name', 'Institute Name'),
(649, 'institution_code', 'Institution Code'),
(650, 'sms_service_provider', 'Sms Service Provider'),
(651, 'footer_text', 'Footer Text'),
(652, 'payment_control', 'Payment Control'),
(653, 'sms_config', 'Sms Config'),
(654, 'sms_triggers', 'Sms Triggers'),
(655, 'authentication_token', 'Authentication Token'),
(656, 'sender_number', 'Sender Number'),
(657, 'username', 'Username'),
(658, 'api_key', 'Api Key'),
(659, 'authkey', 'Authkey'),
(660, 'sender_id', 'Sender Id'),
(661, 'sender_name', 'Sender Name'),
(662, 'hash_key', 'Hash Key'),
(663, 'notify_enable', 'Notify Enable'),
(664, 'exam_attendance', 'Exam Attendance'),
(665, 'exam_results', 'Exam Results'),
(666, 'email_config', 'Email Config'),
(667, 'email_triggers', 'Email Triggers'),
(668, 'account_registered', 'Account Registered'),
(669, 'forgot_password', 'Forgot Password'),
(670, 'new_message_received', 'New Message Received'),
(671, 'payslip_generated', 'Payslip Generated'),
(672, 'leave_approve', 'Leave Approve'),
(673, 'leave_reject', 'Leave Reject'),
(674, 'advance_salary_approve', 'Leave Reject'),
(675, 'advance_salary_reject', 'Advance Salary Reject'),
(676, 'add_session', 'Add Session'),
(677, 'session', 'Session'),
(678, 'created_at', 'Created At'),
(679, 'sessions', 'Sessions'),
(680, 'flag', 'Flag'),
(681, 'stats', 'Stats'),
(682, 'updated_at', 'Updated At'),
(683, 'flag_icon', 'Flag Icon'),
(684, 'password_restoration', 'Password Restoration'),
(685, 'forgot', 'Forgot'),
(686, 'back_to_login', 'Back To Login'),
(687, 'database_list', 'Database List'),
(688, 'create_backup', 'Create Backup'),
(689, 'backup', 'Backup'),
(690, 'backup_size', 'Backup Size'),
(691, 'file_upload', 'File Upload'),
(692, 'parents_details', 'Parents Details'),
(693, 'social_links', 'Social Links'),
(694, 'create_hostel', 'Create Hostel'),
(695, 'allocation_list', 'Allocation List'),
(696, 'payslip_history', 'Payslip History'),
(697, 'my_attendance_overview', 'My Attendance Overview'),
(698, 'total_present', 'Total Present'),
(699, 'total_absent', 'Total Absent'),
(700, 'total_late', 'Total Late'),
(701, 'class_teacher_list', 'Class Teacher List'),
(702, 'section_control', 'Section Control'),
(703, 'capacity ', 'Capacity'),
(704, 'request', 'Request'),
(705, 'salary_year', 'Salary Year'),
(706, 'create_attachments', 'Create Attachments'),
(707, 'publish_date', 'Publish Date'),
(708, 'attachment_file', 'Attachment File'),
(709, 'age', 'Age'),
(710, 'student_profile', 'Student Profile'),
(711, 'authentication', 'Authentication'),
(712, 'parent_information', 'Parent Information'),
(713, 'full_marks', 'Full Marks'),
(714, 'passing_marks', 'Passing Marks'),
(715, 'highest_marks', 'Highest Marks'),
(716, 'unknown', 'Unknown'),
(717, 'unpublish', 'Unpublish'),
(718, 'login_authentication_deactivate', 'Login Authentication Deactivate'),
(719, 'employee_profile', 'Employee Profile'),
(720, 'employee_details', 'Employee Details'),
(721, 'salary_transaction', 'Salary Transaction'),
(722, 'documents', 'Documents'),
(723, 'actions', 'Actions'),
(724, 'activity', 'Activity'),
(725, 'department_list', 'Department List'),
(726, 'manage_employee_salary', 'Manage Employee Salary'),
(727, 'the_configuration_has_been_updated', 'The Configuration Has Been Updated'),
(728, 'add', 'Add'),
(729, 'create_exam', 'Create Exam'),
(730, 'term', 'Term'),
(731, 'add_term', 'Add Term'),
(732, 'create_grade', 'Create Grade'),
(733, 'mark_starting', 'Mark Starting'),
(734, 'mark_until', 'Mark Until'),
(735, 'room_list', 'Room List'),
(736, 'room', 'Room'),
(737, 'route_list', 'Route List'),
(738, 'create_route', 'Create Route'),
(739, 'vehicle_list', 'Vehicle List'),
(740, 'create_vehicle', 'Create Vehicle'),
(741, 'stoppage_list', 'Stoppage List'),
(742, 'create_stoppage', 'Create Stoppage'),
(743, 'stop_time', 'Stop Time'),
(744, 'employee_attendance', 'Employee Attendance'),
(745, 'attendance_report', 'Attendance Report'),
(746, 'opening_balance', 'Opening Balance'),
(747, 'add_opening_balance', 'Add Opening Balance'),
(748, 'credit', 'Credit'),
(749, 'debit', 'Debit'),
(750, 'opening_balance_list', 'Opening Balance List'),
(751, 'voucher_list', 'Voucher List'),
(752, 'voucher_head', 'Voucher Head'),
(753, 'payment_method', 'Payment Method'),
(754, 'credit_ledger_account', 'Credit Ledger Account'),
(755, 'debit_ledger_account', 'Debit Ledger Account'),
(756, 'voucher_no', 'Voucher No'),
(757, 'balance', 'Balance'),
(758, 'event_details', 'Event Details'),
(759, 'welcome_to', 'Welcome To'),
(760, 'report_card', 'Report Card'),
(761, 'online_pay', 'Online Pay'),
(762, 'annual_fees_summary', 'Annual Fees Summary'),
(763, 'my_children', 'My Children'),
(764, 'assigned', 'Assigned'),
(765, 'confirm_password', 'Confirm Password'),
(766, 'searching_results', 'Searching Results'),
(767, 'information_has_been_saved_successfully', 'Information Has Been Saved Successfully'),
(768, 'information_deleted', 'The information has been successfully deleted'),
(769, 'deleted_note', '*Note : This data will be permanently deleted'),
(770, 'are_you_sure', 'Are You Sure?'),
(771, 'delete_this_information', 'Do You Want To Delete This Information?'),
(772, 'yes_continue', 'Yes, Continue'),
(773, 'deleted', 'Deleted'),
(774, 'collect', 'Collect'),
(775, 'school_setting', 'School Setting'),
(776, 'set', 'Set'),
(777, 'quick_view', 'Quick View'),
(778, 'due_fees_invoice', 'Pending Levy Invoice'),
(779, 'my_application', 'My Application'),
(780, 'manage_application', 'Manage Application'),
(781, 'leave', 'Leave'),
(782, 'live_class_rooms', 'Live Class Rooms'),
(783, 'homework', 'Homework'),
(784, 'evaluation_report', 'Evaluation Report'),
(785, 'exam_term', 'Exam Term'),
(786, 'distribution', 'Distribution'),
(787, 'exam_setup', 'Exam Setup'),
(788, 'sms', 'Sms'),
(789, 'fees_type', 'Levy Type'),
(790, 'fees_group', 'Levy Group'),
(791, 'fine_setup', 'Surcharge Setup'),
(792, 'fees_reminder', 'Levy Reminder'),
(793, 'new_deposit', 'New Deposit'),
(794, 'new_expense', 'New Expense'),
(795, 'all_transactions', 'All Transactions'),
(796, 'head', 'Head'),
(797, 'fees_reports', 'Levy Reports'),
(798, 'fees_report', 'Levy Report'),
(799, 'receipts_report', 'Receipts Report'),
(800, 'due_fees_report', 'Pending Levy Report'),
(801, 'fine_report', 'Surcharge Report'),
(802, 'financial_reports', 'Financial Reports'),
(803, 'statement', 'Statement'),
(804, 'repots', 'Repots'),
(805, 'expense', 'Expense'),
(806, 'transitions', 'Transitions'),
(807, 'sheet', 'Sheet'),
(808, 'income_vs_expense', 'Income Vs Expense'),
(809, 'attendance_reports', 'Attendance Reports'),
(810, 'examination', 'Examination'),
(811, 'school_settings', 'School Settings'),
(812, 'role_permission', 'Role Permission'),
(813, 'cron_job', 'Cron Job'),
(814, 'custom_field', 'Custom Field'),
(815, 'enter_valid_email', 'Enter Valid Email'),
(816, 'lessons', 'Lessons'),
(817, 'live_class', 'Live Class'),
(818, 'sl', 'Sl'),
(819, 'meeting_id', 'Meeting ID'),
(820, 'start_time', 'Start Time'),
(821, 'end_time', 'End Time'),
(822, 'zoom_meeting_id', 'Zoom Meeting Id'),
(823, 'zoom_meeting_password', 'Zoom Meeting Password'),
(824, 'time_slot', 'Time Slot'),
(825, 'send_notification_sms', 'Send Notification Sms'),
(826, 'host', 'Host'),
(827, 'school', 'School'),
(828, 'accounting_links', 'Accounting Links'),
(829, 'applicant', 'Applicant'),
(830, 'apply_date', 'Apply Date'),
(831, 'add_leave', 'Add Leave'),
(832, 'leave_date', 'Leave Date'),
(833, 'attachment', 'Attachment'),
(834, 'comments', 'Comments'),
(835, 'staff_id', 'Staff Id'),
(836, 'income_vs_expense_of', 'Income Vs Expense Of'),
(837, 'designation_name', 'Designation Name'),
(838, 'already_taken', 'This %s already exists.'),
(839, 'department_name', 'Department Name'),
(840, 'date_of_birth', 'Date Of Birth'),
(841, 'bulk_delete', 'Bulk Delete'),
(842, 'guardian_name', 'Guardian Name'),
(843, 'fees_progress', 'Fees Progress'),
(844, 'evaluate', 'Evaluate'),
(845, 'date_of_homework', 'Date Of Homework'),
(846, 'date_of_submission', 'Date Of Submission'),
(847, 'student_fees_report', 'Student Fees Report'),
(848, 'student_fees_reports', 'Student Fees Reports'),
(849, 'due_date', 'Due Date'),
(850, 'payment_date', 'Payment Date'),
(851, 'payment_via', 'Payment Via'),
(852, 'generate', 'Generate'),
(853, 'print_date', 'Print Date'),
(854, 'bulk_sms_and_email', 'Bulk Sms And Email'),
(855, 'campaign_type', 'Campaign Type'),
(856, 'both', 'Both'),
(857, 'regular', 'Regular'),
(858, 'Scheduled', 'Scheduled'),
(859, 'campaign', 'Campaign'),
(860, 'campaign_name', 'Campaign Name'),
(861, 'sms_gateway', 'Sms Gateway'),
(862, 'recipients_type', 'Recipients Type'),
(863, 'recipients_count', 'Recipients Count'),
(864, 'body', 'Body'),
(865, 'guardian_already_exist', 'Guardian Already Exist'),
(866, 'guardian', 'Guardian'),
(867, 'mother_name', 'Mother Name'),
(868, 'bank_details', 'Bank Details'),
(869, 'skipped_bank_details', 'Skipped Bank Details'),
(870, 'bank', 'Bank'),
(871, 'holder_name', 'Holder Name'),
(872, 'bank_branch', 'Bank Branch'),
(873, 'custom_field_for', 'Custom Field For'),
(874, 'label', 'Label'),
(875, 'order', 'Order'),
(876, 'online_admission', 'Online Admission'),
(877, 'field_label', 'Field Label'),
(878, 'field_type', 'Field Label'),
(879, 'default_value', 'Default Value'),
(880, 'checked', 'Checked'),
(881, 'unchecked', 'Unchecked'),
(882, 'roll_number', 'Roll Number'),
(883, 'add_rows', 'Add Rows'),
(884, 'salary', 'Salary'),
(885, 'basic', 'Basic'),
(886, 'allowance', 'Allowance'),
(887, 'deduction', 'Deduction'),
(888, 'net', 'Net'),
(889, 'activated_sms_gateway', 'Activated Sms Gateway'),
(890, 'account_sid', 'Account Sid'),
(891, 'roles', 'Roles'),
(892, 'system_role', 'System Role'),
(893, 'permission', 'Permission'),
(894, 'edit_session', 'Edit Session'),
(895, 'transactions', 'Transactions'),
(896, 'default_account', 'Default Account'),
(897, 'deposit', 'Deposit'),
(898, 'acccount', 'Acccount'),
(899, 'role_permission_for', 'Role Permission For'),
(900, 'feature', 'Feature'),
(901, 'access_denied', 'Access Denied'),
(902, 'time_start', 'Time Start'),
(903, 'time_end', 'Time End'),
(904, 'month_of_salary', 'Month Of Salary'),
(905, 'add_documents', 'Add Documents'),
(906, 'document_type', 'Document Type'),
(907, 'document', 'Document'),
(908, 'document_title', 'Document Title'),
(909, 'document_category', 'Document Category'),
(910, 'exam_result', 'Exam Result'),
(911, 'my_annual_fee_summary', 'My Annual Fee Summary'),
(912, 'book_manage', 'Book Manage'),
(913, 'add_leave_category', 'Add Leave Category'),
(914, 'edit_leave_category', 'Edit Leave Category'),
(915, 'staff_role', 'Staff Role'),
(916, 'edit_assign', 'Edit Assign'),
(917, 'view_report', 'View Report'),
(918, 'rank_out_of_5', 'Rank Out Of 5'),
(919, 'hall_no', 'Hall No'),
(920, 'no_of_seats', 'No Of Seats'),
(921, 'mark_distribution', 'Mark Distribution'),
(922, 'exam_type', 'Exam Type'),
(923, 'marks_and_grade', 'Marks And Grade'),
(924, 'min_percentage', 'Min Percentage'),
(925, 'max_percentage', 'Max Percentage'),
(926, 'cost_per_bed', 'Cost Per Bed'),
(927, 'add_category', 'Add Category'),
(928, 'category_for', 'Category For'),
(929, 'start_place', 'Start Place'),
(930, 'stop_place', 'Stop Place'),
(931, 'vehicle', 'Vehicle'),
(932, 'select_multiple_vehicle', 'Select Multiple Vehicle'),
(933, 'book_details', 'Book Details'),
(934, 'issued_by', 'Issued By'),
(935, 'return_by', 'Return By'),
(936, 'group', 'Group'),
(937, 'individual', 'Individual'),
(938, 'recipients', 'Recipients'),
(939, 'group_name', 'Group Name'),
(940, 'fee_code', 'Fee Code'),
(941, 'fine_type', 'Fine Type'),
(942, 'fine_value', 'Fine Value'),
(943, 'late_fee_frequency', 'Late Fee Frequency'),
(944, 'fixed_amount', 'Fixed Amount'),
(945, 'fixed', 'Fixed'),
(946, 'daily', 'Daily'),
(947, 'weekly', 'Weekly'),
(948, 'monthly', 'Monthly'),
(949, 'annually', 'Annually'),
(950, 'first_select_the_group', 'First Select The Group'),
(951, 'percentage', 'Percentage'),
(952, 'value', 'Value'),
(953, 'fee_group', 'Fee Group'),
(954, 'due_invoice', 'Due Invoice'),
(955, 'reminder', 'Reminder'),
(956, 'frequency', 'Frequency'),
(957, 'notify', 'Notify'),
(958, 'before', 'Before'),
(959, 'after', 'After'),
(960, 'number', 'Number'),
(961, 'ref_no', 'Ref No'),
(962, 'pay_via', 'Pay Via'),
(963, 'ref', 'Ref'),
(964, 'dr', 'Dr'),
(965, 'cr', 'Cr'),
(966, 'edit_book', 'Edit Book'),
(967, 'leaves', 'Leaves'),
(968, 'leave_request', 'Leave Request'),
(969, 'this_file_type_is_not_allowed', 'This File Type Is Not Allowed'),
(970, 'error_reading_the_file', 'Error Reading The File'),
(971, 'staff', 'Staff'),
(972, 'waiting', 'Waiting'),
(973, 'live', 'Live'),
(974, 'by', 'By'),
(975, 'host_live_class', 'Host Live Class'),
(976, 'join_live_class', 'Join Live Class'),
(977, 'system_logo', 'System Logo'),
(978, 'text_logo', 'Text Logo'),
(979, 'printing_logo', 'Printing Logo'),
(980, 'expired', 'Expired'),
(981, 'collect_fees', 'Collect Fees'),
(982, 'fees_code', 'Fees Code'),
(983, 'collect_by', 'Collect By'),
(984, 'fee_payment', 'Fee Payment'),
(985, 'write_message', 'Write Message'),
(986, 'discard', 'Discard'),
(987, 'message_sent_successfully', 'Message Sent Successfully'),
(988, 'visit_home_page', 'Visit Home Page'),
(989, 'frontend', 'Frontend'),
(990, 'setting', 'Setting'),
(991, 'menu', 'Menu'),
(992, 'page', 'Page'),
(993, 'manage', 'Manage'),
(994, 'slider', 'Slider'),
(995, 'features', 'Features'),
(996, 'testimonial', 'Testimonial'),
(997, 'service', 'Service'),
(998, 'faq', 'Faq'),
(999, 'card_management', 'Card Management'),
(1000, 'id_card', 'Id Card'),
(1001, 'templete', 'Templete'),
(1002, 'admit_card', 'Admit Card'),
(1003, 'certificate', 'Certificate'),
(1004, 'system_update', 'System Update'),
(1005, 'url', 'Url'),
(1006, 'content', 'Content'),
(1007, 'banner_photo', 'Banner Photo'),
(1008, 'meta', 'Meta'),
(1009, 'keyword', 'Keyword'),
(1010, 'applicable_user', 'Applicable User'),
(1011, 'page_layout', 'Page Layout'),
(1012, 'background', 'Background'),
(1013, 'image', 'Image'),
(1014, 'width', 'Width'),
(1015, 'height', 'Height'),
(1016, 'signature', 'Signature'),
(1017, 'website', 'Website'),
(1018, 'cms', 'Cms'),
(1019, 'url_alias', 'Url Alias'),
(1020, 'cms_frontend', 'Cms Frontend'),
(1021, 'enabled', 'Enabled'),
(1022, 'receive_email_to', 'Receive Email To'),
(1023, 'captcha_status', 'Captcha Status'),
(1024, 'recaptcha_site_key', 'Recaptcha Site Key'),
(1025, 'recaptcha_secret_key', 'Recaptcha Secret Key'),
(1026, 'working_hours', 'Working Hours'),
(1027, 'fav_icon', 'Fav Icon'),
(1028, 'theme', 'Theme'),
(1029, 'fax', 'Fax'),
(1030, 'footer_about_text', 'Footer About Text'),
(1031, 'copyright_text', 'Copyright Text'),
(1032, 'facebook_url', 'Facebook Url'),
(1033, 'twitter_url', 'Twitter Url'),
(1034, 'youtube_url', 'Youtube Url'),
(1035, 'google_plus', 'Google Plus'),
(1036, 'linkedin_url', 'Linkedin Url'),
(1037, 'pinterest_url', 'Pinterest Url'),
(1038, 'instagram_url', 'Instagram Url'),
(1039, 'play', 'Play'),
(1040, 'video', 'Video'),
(1041, 'usename', 'Usename'),
(1042, 'experience_details', 'Experience Details'),
(1043, 'total_experience', 'Total Experience'),
(1044, 'class_schedule', 'Class Schedule'),
(1045, 'cms_default_branch', 'Cms Default Branch'),
(1046, 'website_page', 'Website Page'),
(1047, 'welcome', 'Welcome'),
(1048, 'services', 'Services'),
(1049, 'call_to_action_section', 'Call To Action Section'),
(1050, 'subtitle', 'Subtitle'),
(1051, 'cta', 'Cta'),
(1052, 'button_text', 'Button Text'),
(1053, 'button_url', 'Button Url'),
(1054, '_title', ' Title'),
(1055, 'contact', 'Contact'),
(1056, 'box_title', 'Box Title'),
(1057, 'box_description', 'Box Description'),
(1058, 'box_photo', 'Box Photo'),
(1059, 'form_title', 'Form Title'),
(1060, 'submit_button_text', 'Submit Button Text'),
(1061, 'map_iframe', 'Map Iframe'),
(1062, 'email_subject', 'Email Subject'),
(1063, 'prefix', 'Prefix'),
(1064, 'surname', 'Surname'),
(1065, 'rank', 'Rank'),
(1066, 'submit', 'Submit'),
(1067, 'certificate_name', 'Certificate Name'),
(1068, 'layout_width', 'Layout Width'),
(1069, 'layout_height', 'Layout Height'),
(1070, 'expiry_date', 'Expiry Date'),
(1071, 'position', 'Position'),
(1072, 'target_new_window', 'Target New Window'),
(1073, 'external_url', 'External Url'),
(1074, 'external_link', 'External Link'),
(1075, 'sms_notification', 'Sms Notification'),
(1076, 'scheduled_at', 'Scheduled At'),
(1077, 'published', 'Published'),
(1078, 'unpublished_on_website', 'Unpublished On Website'),
(1079, 'published_on_website', 'Published On Website'),
(1080, 'no_selection_available', 'No Selection Available'),
(1081, 'select_for_everyone', 'Select For Everyone'),
(1082, 'teacher_restricted', 'Teacher Restricted'),
(1083, 'guardian_relation', 'Guardian Relation'),
(1084, 'username_prefix', 'Username Prefix'),
(1085, 'default_password', 'Default Password'),
(1086, 'parents_profile', 'Parents Profile'),
(1087, 'childs', 'Childs'),
(1088, 'page_title', 'Page Title'),
(1089, 'select_menu', 'Select Menu'),
(1090, 'meta_keyword', 'Meta Keyword'),
(1091, 'meta_description', 'Meta Description'),
(1092, 'evaluation_date', 'Evaluation Date'),
(1093, 'evaluated_by', 'Evaluated By'),
(1094, 'complete', 'Complete'),
(1095, 'incomplete', 'Incomplete'),
(1096, 'payment_details', 'Payment Details'),
(1097, 'edit_attachments', 'Edit Attachments'),
(1098, 'live_classes', 'Live Classes'),
(1099, 'duration', 'Duration'),
(1100, 'metting_id', 'Metting Id'),
(1101, 'set_record', 'Set Record'),
(1102, 'set_mute_on_start', 'Set Mute On Start'),
(1103, 'button_text_1', 'Button Text 1'),
(1104, 'button_url_1', 'Button Url 1'),
(1105, 'button_text_2', 'Button Text 2'),
(1106, 'button_url_2', 'Button Url 2'),
(1107, 'left', 'Left'),
(1108, 'center', 'Center'),
(1109, 'right', 'Right'),
(1110, 'about', 'About'),
(1111, 'about_photo', 'About Photo'),
(1112, 'parallax_photo', 'Parallax Photo'),
(1113, 'decline', 'Decline'),
(1114, 'edit_grade', 'Edit Grade'),
(1115, 'mark', 'Mark'),
(1116, 'hall_room', 'Hall Room'),
(1117, 'student_promotion', 'Student Promotion'),
(1118, 'username_has_already_been_used', 'Username Has Already Been Used'),
(1119, 'fee_collection', 'Fee Collection'),
(1120, 'not_found_anything', 'Not Found Anything'),
(1121, 'preloader_backend', 'Preloader Backend'),
(1122, 'ive_class_method', 'Ive Class Method'),
(1123, 'live_class_method', 'Live Class Method'),
(1124, 'api_credential', 'Api Credential'),
(1125, 'translation_update', 'Translation Update'),
(1126, ' live_class_reports', ' Live Class Reports'),
(1127, 'live_class_reports', 'Live Class Reports'),
(1128, 'all', 'All'),
(1129, 'student_participation_report', 'Student Participation Report'),
(1130, 'joining_time', 'Joining Time'),
(1131, 'inventory', 'School Assets'),
(1132, 'product', 'Product'),
(1133, 'store', 'Store'),
(1134, 'supplier', 'Supplier'),
(1135, 'unit', 'Unit'),
(1136, 'purchase', 'Purchase'),
(1137, 'sales', 'Sales'),
(1138, 'issue', 'Issue'),
(1139, 'gallery', 'Gallery'),
(1140, 'news', 'News'),
(1141, 'reception', 'Reception'),
(1142, 'admission_enquiry', 'Admission Enquiry'),
(1143, 'postal_record', 'Postal Record'),
(1144, 'call_log', 'Call Log'),
(1145, 'visitor_log', 'Visitor Log'),
(1146, 'complaint', 'Complaint'),
(1147, 'multi_class', 'Multi Class'),
(1148, 'deactivate_reason', 'Deactivate Reason'),
(1149, 'marksheet', 'Marksheet'),
(1150, 'generate_position', 'Generate Position'),
(1151, 'online_exam', 'Online Exam'),
(1152, 'question_bank', 'Question Bank'),
(1153, 'question_group', 'Question Group'),
(1154, 'fees_setup', 'Fees Setup'),
(1155, 'subject_wise', 'Subject Wise'),
(1156, 'my_issued_book', 'My Issued Book'),
(1157, 'book_issue/return', 'Book Issue/return'),
(1158, 'offline_payments', 'Offline Payments'),
(1159, 'payments', 'Payments'),
(1160, ' offline_payments', ' Offline Payments'),
(1161, 'login_credential', 'Login Credential'),
(1162, 'admission_report', 'Admission Report'),
(1163, 'class_&_section_report', 'Class & Section Report'),
(1164, 'sibling_report', 'Sibling Report'),
(1165, 'daily_reports', 'Daily Reports'),
(1166, 'overview_reports', 'Overview Reports'),
(1167, 'subject_wise_reports', 'Subject Wise Reports'),
(1168, 'subject_wise_by', 'Subject Wise By'),
(1169, 'progress', 'Progress'),
(1170, 'stock', 'Stock'),
(1171, 'issues', 'Issues'),
(1172, 'alumni', 'Alumni'),
(1173, 'manage_alumni', 'Manage Alumni'),
(1174, 'addon_manager', 'Addon Manager'),
(1175, 'modules', 'Modules'),
(1176, 'system_student_field', 'System Student Field'),
(1177, 'user_login_log', 'User Login Log'),
(1178, 'march', 'March'),
(1179, 'today_birthday', 'Today Birthday'),
(1180, 'addon', 'Addon'),
(1181, 'install', 'Install'),
(1182, 'version', 'Version'),
(1183, 'installed', 'Installed'),
(1184, 'last_upgrade', 'Last Upgrade'),
(1185, 'addon_purchase_code', 'Addon Purchase Code'),
(1186, 'install_now', 'Install Now'),
(1187, 'cache_control', 'Cache Control'),
(1188, 'currency_formats', 'Currency Formats'),
(1189, 'symbol_position', 'Symbol Position'),
(1190, 'database_backup_failed', 'Database Backup Failed'),
(1191, 'clear_userlog', 'Clear Userlog'),
(1192, 'browser', 'Browser'),
(1193, 'login_date_time', 'Login Date Time'),
(1194, 'platform', 'Platform'),
(1195, 'passing_session', 'Passing Session'),
(1196, 'profession', 'Profession'),
(1197, 'event', 'Event'),
(1198, 'note', 'Note'),
(1199, 'send_confirmation_sms', 'Send Confirmation Sms'),
(1200, 'change', 'Change'),
(1201, 'admission_reports', 'Admission Reports'),
(1202, 'class_&_section', 'Class & Section'),
(1203, 'questions_qty', 'Questions Qty'),
(1204, 'exam_status', 'Exam Status'),
(1205, 'limits_of_participation', 'Limits Of Participation'),
(1206, 'passing_mark', 'Passing Mark'),
(1207, 'instruction', 'Instruction'),
(1208, 'free', 'Free'),
(1209, 'question', 'Question'),
(1210, 'random', 'Random'),
(1211, 'result_publish', 'Result Publish'),
(1212, 'negative_mark', 'Negative Mark'),
(1213, 'applicable', 'Applicable'),
(1214, 'marks_display', 'Marks Display'),
(1215, 'make', 'Make'),
(1216, 'edit_branch', 'Edit Branch'),
(1217, 'code', 'Code'),
(1218, 'purchase_unit', 'Purchase Unit'),
(1219, 'sale_unit', 'Sale Unit'),
(1220, 'unit_ratio', 'Unit Ratio'),
(1221, 'purchase_price', 'Purchase Price'),
(1222, 'sales_price', 'Sales Price'),
(1223, 'sales_unit', 'Sales Unit'),
(1224, 'whatsapp_settings', 'Whatsapp Settings'),
(1225, 'general_setting', 'General Setting'),
(1226, 'weekends', 'Weekends'),
(1227, 'sunday', 'Sunday'),
(1228, 'monday', 'Monday'),
(1229, 'tuesday', 'Tuesday'),
(1230, 'wednesday', 'Wednesday'),
(1231, 'thursday', 'Thursday'),
(1232, 'friday', 'Friday'),
(1233, 'saturday', 'Saturday'),
(1234, 'select_weekends', 'Select Weekends'),
(1235, 'unique_roll', 'Unique Roll'),
(1236, 'classes_wise', 'Classes Wise'),
(1237, 'section_wise', 'Section Wise'),
(1238, 'start_from', 'Start From'),
(1239, 'digit', 'Digit'),
(1240, 'fees_carry_forward_setting', 'Fees Carry Forward Setting'),
(1241, 'due_days', 'Due Days'),
(1242, 'due_fees_calculation_with_fine_', 'Due Fees Calculation With Fine '),
(1243, 'store_code', 'Store Code'),
(1244, 'google_analytics', 'Google Analytics'),
(1245, 'parent_menu', 'Parent Menu'),
(1246, 'statistics', 'Statistics'),
(1247, 'employees', 'Employees'),
(1248, 'classes', 'Classes'),
(1249, 'fields_setting', 'Fields Setting'),
(1250, 'terms_conditions', 'Terms Conditions'),
(1251, 'admission_application_form', 'Admission Application Form'),
(1252, 'online_addmission', 'Online Addmission'),
(1253, 'fee', 'Fee'),
(1254, 'fields', 'Fields'),
(1255, 'active', 'Active'),
(1256, 'reference', 'Reference'),
(1257, 'response', 'Response'),
(1258, 'calling_purpose', 'Calling Purpose'),
(1259, 'visiting_purpose', 'Visiting Purpose'),
(1260, 'guardian_picture', 'Guardian Picture'),
(1261, 'pickup_point', 'Pickup Point'),
(1262, 'exploring', 'Exploring'),
(1263, 'leave_days', 'Leave Days'),
(1264, 'create_section', 'Create Section'),
(1265, 'section_list', 'Section List'),
(1266, 'set_parameters_to_quickly_create_schedule', 'Set Parameters To Quickly Create Schedule'),
(1267, 'starting_date', 'Starting Date'),
(1268, 'interval', 'Interval'),
(1269, 'the_next_session_was_transferred_to_the_students', 'The Next Session Was Transferred To The Students'),
(1270, 'promote_to_session', 'Promote To Session'),
(1271, 'promote_to_class', 'Promote To Class'),
(1272, 'promote_to_section', 'Promote To Section'),
(1273, 'mark_summary', 'Mark Summary'),
(1274, 'current_due_amount', 'Current Due Amount'),
(1275, 'with_fine', 'With Fine'),
(1276, 'publish_result', 'Publish Result'),
(1277, 'middle', 'Middle'),
(1278, 'header', 'Header'),
(1279, 'footer', 'Footer'),
(1280, 'grading_scale', 'Grading Scale'),
(1281, 'cumulative', 'Cumulative'),
(1282, 'remark', 'Remark'),
(1283, 'class_position', 'Class Position'),
(1284, 'level', 'Level'),
(1285, 'single_choice', 'Single Choice'),
(1286, 'multiple_choice', 'Multiple Choice'),
(1287, 'true/false', 'True/false'),
(1288, 'descriptive', 'Descriptive'),
(1289, 'easy', 'Easy'),
(1290, 'medium', 'Medium'),
(1291, 'hard', 'Hard'),
(1292, 'half_day', 'Half Day'),
(1293, 'show_website', 'Show Website'),
(1294, 'all_section', 'All Section'),
(1295, 'all_class', 'All Class'),
(1296, 'no_row_are_selected', 'No Row Are Selected'),
(1297, 'restore', 'Restore'),
(1298, 'delete_forever', 'Delete Forever'),
(1299, 'all_select', 'All Select'),
(1300, 'product_stock', 'Product Stock'),
(1301, 'purchase_qty', 'Purchase Qty'),
(1302, 'total_issued', 'Total Issued'),
(1303, 'total_sales', 'Total Sales'),
(1304, 'current', 'Current'),
(1305, 'april', 'April'),
(1306, 'reference_no', 'Reference No'),
(1307, 'payment_status', 'Payment Status'),
(1308, 'promotion_history', 'Promotion History'),
(1309, 'from_class', 'From Class'),
(1310, 'from_session', 'From Session'),
(1311, 'promoted_class', 'Promoted Class'),
(1312, 'promoted_session', 'Promoted Session'),
(1313, 'promoted_date', 'Promoted Date'),
(1314, 'sibling_information', 'Sibling Information'),
(1315, 'disable_reason', 'Disable Reason'),
(1316, 'bill_no', 'Bill No'),
(1317, 'payable', 'Payable'),
(1318, 'ordered', 'Ordered'),
(1319, 'received', 'Received'),
(1320, 'add_products_to_stock_list', 'Add Products To Stock List'),
(1321, 'quantity', 'Quantity'),
(1322, 'net_total', 'Net Total'),
(1323, 'contact_number', 'Contact Number'),
(1324, 'company_name', 'Company Name'),
(1325, 'advance_salary_request', 'Advance Salary Request'),
(1326, 'student_parent_panel', 'Student Parent Panel'),
(1327, 'privacy', 'Privacy'),
(1328, 'default_template', 'Default Template'),
(1329, 'zoom_credentials', 'Zoom Credentials'),
(1330, 'set_zoom_redirect_url', 'Set Zoom Redirect Url'),
(1331, 'header_title', 'Header Title'),
(1332, 'frontend_enable_chat', 'Frontend Enable Chat'),
(1333, 'backend_enable_chat', 'Backend Enable Chat'),
(1334, 'whatsapp_agent', 'Whatsapp Agent'),
(1335, 'agent', 'Agent'),
(1336, 'whataspp_number', 'Whataspp Number'),
(1337, 'weekend', 'Weekend'),
(1338, 'day_wise', 'Day Wise'),
(1339, 'curriculum_pdf', 'Curriculum Pdf'),
(1340, 'edit_section', 'Edit Section'),
(1341, 'instructions', 'Instructions'),
(1342, 'suspended', 'Suspended'),
(1343, 'trx_id', 'Trx Id'),
(1344, 'submit_date', 'Submit Date'),
(1345, 'exam_rank', 'Exam Rank'),
(1346, 'principal_comments', 'Principal Comments'),
(1347, 'teacher_comments', 'Teacher Comments'),
(1348, 'enquiry', 'Enquiry'),
(1349, 'next', 'Next'),
(1350, 'follow_up', 'Follow Up'),
(1351, 'previous_school', 'Previous School'),
(1352, 'no_of_child', 'No Of Child'),
(1353, 'class_applying_for', 'Class Applying For'),
(1354, 'online_exam_publish', 'Online Exam Publish'),
(1355, 'student_birthday_wishes', 'Student Birthday Wishes'),
(1356, 'staff_birthday_wishes', 'Staff Birthday Wishes'),
(1357, 'alumni_event', 'Alumni Event'),
(1358, 'lga', 'Lga'),
(1359, 'select_or_statewide', 'Select Or Statewide'),
(1360, 'issue_to', 'Issue To'),
(1361, 'sale_to', 'Sale To'),
(1362, 'bill', 'Bill'),
(1363, 'summary', 'Summary'),
(1364, 'sub_total', 'Sub Total'),
(1365, 'enter_payment_amount', 'Enter Payment Amount');
INSERT INTO `languages` (`id`, `word`, `english`) VALUES
(1366, 'first_select_the_category', 'First Select The Category'),
(1367, 'may', 'May'),
(1368, 'supplier_name', 'Supplier Name'),
(1369, 'available_stock_quantity', 'Available Stock Quantity'),
(1370, 'mark_type', 'Mark Type'),
(1371, 'question_type', 'Question Type'),
(1372, 'recent', 'Recent'),
(1373, 'information', 'Information');

-- --------------------------------------------------------

--
-- Table structure for table `language_list`
--

CREATE TABLE `language_list` (
  `id` int(11) NOT NULL,
  `name` varchar(600) NOT NULL,
  `lang_field` varchar(600) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `rtl` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `language_list`
--

INSERT INTO `language_list` (`id`, `name`, `lang_field`, `status`, `rtl`, `created_at`, `updated_at`) VALUES
(1, 'English', 'english', 1, 0, '2026-02-10 11:36:31', '2026-05-08 06:34:06');

-- --------------------------------------------------------

--
-- Table structure for table `leave_application`
--

CREATE TABLE `leave_application` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `category_id` int(2) NOT NULL,
  `reason` longtext CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `leave_days` varchar(20) NOT NULL DEFAULT '0',
  `status` int(2) NOT NULL DEFAULT 1 COMMENT '1=pending,2=accepted 3=rejected',
  `apply_date` date DEFAULT NULL,
  `approved_by` int(11) NOT NULL,
  `orig_file_name` varchar(255) NOT NULL,
  `enc_file_name` varchar(255) NOT NULL,
  `comments` varchar(255) NOT NULL,
  `session_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_category`
--

CREATE TABLE `leave_category` (
  `id` int(2) NOT NULL,
  `name` longtext CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `role_id` tinyint(1) NOT NULL,
  `days` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `board_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `leave_category`
--

INSERT INTO `leave_category` (`id`, `name`, `role_id`, `days`, `branch_id`, `board_id`) VALUES
(1, 'Illness', 3, 10, 1, NULL),
(2, 'Tour', 7, 5, 1, NULL),
(3, 'Medical Leave', 3, 10, 1, NULL),
(4, 'Casual Leave', 3, 10, 1, NULL),
(5, 'Maternity Leave', 3, 60, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `live_class`
--

CREATE TABLE `live_class` (
  `id` int(11) NOT NULL,
  `live_class_method` tinyint(1) NOT NULL DEFAULT 1,
  `title` varchar(255) NOT NULL,
  `meeting_id` varchar(255) NOT NULL,
  `meeting_password` varchar(255) NOT NULL,
  `own_api_key` tinyint(1) NOT NULL DEFAULT 0,
  `duration` int(11) NOT NULL,
  `bbb` longtext NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` text NOT NULL,
  `remarks` text NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_by` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `live_class`
--

INSERT INTO `live_class` (`id`, `live_class_method`, `title`, `meeting_id`, `meeting_password`, `own_api_key`, `duration`, `bbb`, `class_id`, `section_id`, `remarks`, `date`, `start_time`, `end_time`, `created_by`, `status`, `created_at`, `branch_id`) VALUES
(1, 3, 'Live Classroom Test', '', '', 0, 60, '{\"join_url\":\"https:\\/\\/meet.google.com\\/abc-defg-xyz\"}', 4, '[\"1\"]', '', '2026-03-30', '09:15:00', '10:15:00', 1, 0, '2026-03-27 08:03:16', 1);

-- --------------------------------------------------------

--
-- Table structure for table `live_class_config`
--

CREATE TABLE `live_class_config` (
  `id` int(11) NOT NULL,
  `zoom_api_key` varchar(255) DEFAULT NULL,
  `zoom_api_secret` varchar(255) DEFAULT NULL,
  `bbb_salt_key` varchar(355) DEFAULT NULL,
  `bbb_server_base_url` varchar(355) DEFAULT NULL,
  `staff_api_credential` tinyint(1) NOT NULL DEFAULT 0,
  `student_api_credential` tinyint(1) NOT NULL DEFAULT 0,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `live_class_reports`
--

CREATE TABLE `live_class_reports` (
  `id` int(11) NOT NULL,
  `live_class_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_credential`
--

CREATE TABLE `login_credential` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `role` tinyint(2) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1(active) 0(deactivate)',
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `login_credential`
--

INSERT INTO `login_credential` (`id`, `user_id`, `username`, `password`, `role`, `active`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin@gmail.com', '$2y$10$rXRti8CIAOP1YOY329FnKu5Vs3X04vpYUa476UTKHL5a8MaHhmlVq', 1, 1, '2026-05-08 08:24:54', '2026-02-24 13:31:42', NULL),
(2, 2, 'madina@gmail.com', '$2y$10$sLzEo.o7L34GeHPVOLDsvO/K5lBeZFn1TGu7LEb0EAWm4RGgSOAHq', 3, 1, '2026-05-07 19:56:35', '2026-03-27 07:08:29', NULL),
(3, 1, 'salmanu@gmail.com', '$2y$10$0108oZEcD.8sC6aRS8xlDOx6kUhup0KtV2noRDEDjFq0LajfB.25S', 6, 1, NULL, '2026-04-02 14:55:07', NULL),
(4, 1, 'ridwan@gmail.com', '$2y$10$mhptERi2xz1BkDJxAucmX.S6JrDn4peeYaAN7FC5HuYQGbMVeXFy.', 7, 1, NULL, '2026-04-02 14:55:07', NULL),
(5, 3, 'jamilusalis@gmail.com', '$2y$10$PoqFsNHVI9hobUJ9lOBpnOcah4kkFSytyeqk6RkBeH5HOUJ/YELi.', 2, 1, '2026-04-14 08:49:01', '2026-04-14 07:47:56', NULL),
(6, 4, 'admin.malali@kdsg.gov.ng', '$2y$10$dwK26u6e/3aKxYkpHRh2Ou0zwbYUrJz6JpkLxw9K0EDokX8ne94pm', 2, 1, '2026-04-14 16:21:04', '2026-04-14 10:51:12', NULL),
(7, 5, 'admin.tudunwada@kdsg.gov.ng', '$2y$10$dwK26u6e/3aKxYkpHRh2Ou0zwbYUrJz6JpkLxw9K0EDokX8ne94pm', 2, 1, NULL, '2026-04-14 10:51:12', NULL),
(8, 6, 'admin.jsskawo@kdsg.gov.ng', '$2y$10$dwK26u6e/3aKxYkpHRh2Ou0zwbYUrJz6JpkLxw9K0EDokX8ne94pm', 2, 1, NULL, '2026-04-14 10:51:12', NULL),
(9, 7, 'admin.rigasa@kdsg.gov.ng', '$2y$10$dwK26u6e/3aKxYkpHRh2Ou0zwbYUrJz6JpkLxw9K0EDokX8ne94pm', 2, 1, NULL, '2026-04-14 10:51:12', NULL),
(10, 8, 'admin.sabontasha@kdsg.gov.ng', '$2y$10$dwK26u6e/3aKxYkpHRh2Ou0zwbYUrJz6JpkLxw9K0EDokX8ne94pm', 2, 1, NULL, '2026-04-14 10:51:12', NULL),
(11, 9, 'admin.gsstw@kdsg.gov.ng', '$2y$10$dwK26u6e/3aKxYkpHRh2Ou0zwbYUrJz6JpkLxw9K0EDokX8ne94pm', 2, 1, NULL, '2026-04-14 10:51:12', NULL),
(12, 10, 'admin.ggsskawo@kdsg.gov.ng', '$2y$10$dwK26u6e/3aKxYkpHRh2Ou0zwbYUrJz6JpkLxw9K0EDokX8ne94pm', 2, 1, NULL, '2026-04-14 10:51:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `login_log`
--

CREATE TABLE `login_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `browser` varchar(255) NOT NULL,
  `platform` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `branch_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `login_log`
--

INSERT INTO `login_log` (`id`, `user_id`, `role`, `ip`, `browser`, `platform`, `timestamp`, `branch_id`) VALUES
(1, 1, 1, '127.0.0.1', 'Chrome 146.0.0.0', 'Mac OS X', '2026-02-24 13:33:00', NULL),
(2, 1, 1, '127.0.0.1', 'Chrome 146.0.0.0', 'Mac OS X', '2026-03-24 14:47:36', NULL),
(3, 1, 1, '127.0.0.1', 'Chrome 146.0.0.0', 'Mac OS X', '2026-03-24 15:23:25', NULL),
(4, 1, 1, '127.0.0.1', 'Chrome 146.0.0.0', 'Mac OS X', '2026-03-25 10:45:32', NULL),
(5, 1, 1, '127.0.0.1', 'Chrome 146.0.0.0', 'Mac OS X', '2026-03-26 08:51:07', NULL),
(6, 1, 1, '127.0.0.1', 'Chrome 146.0.0.0', 'Mac OS X', '2026-03-26 12:20:34', NULL),
(7, 1, 1, '127.0.0.1', 'Chrome 146.0.0.0', 'Mac OS X', '2026-03-26 12:59:37', NULL),
(8, 1, 1, '127.0.0.1', 'Chrome 146.0.0.0', 'Mac OS X', '2026-03-26 13:17:37', NULL),
(9, 1, 1, '127.0.0.1', 'Chrome 146.0.0.0', 'Mac OS X', '2026-03-27 06:52:48', NULL),
(10, 1, 1, '127.0.0.1', 'Chrome 146.0.0.0', 'Mac OS X', '2026-04-02 10:05:43', NULL),
(11, 1, 1, '127.0.0.1', 'Chrome 146.0.0.0', 'Mac OS X', '2026-04-02 13:57:46', NULL),
(12, 1, 1, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-04-14 07:00:28', NULL),
(13, 3, 2, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-04-14 07:49:01', 1),
(14, 4, 2, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-04-14 10:57:45', 4),
(15, 4, 2, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-04-14 11:02:39', 4),
(16, 4, 2, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-04-14 11:15:05', 4),
(17, 4, 2, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-04-14 11:45:26', 4),
(18, 4, 2, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-04-14 13:00:57', 4),
(19, 4, 2, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-04-14 15:21:04', 4),
(20, 1, 1, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-04-14 19:53:52', NULL),
(21, 1, 1, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-04-14 20:01:48', NULL),
(22, 1, 1, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-04-14 20:04:39', NULL),
(23, 1, 1, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-04-14 20:10:53', NULL),
(24, 1, 1, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-04-15 06:12:48', NULL),
(25, 1, 1, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-04-15 07:05:23', NULL),
(26, 1, 1, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-04-15 09:11:58', NULL),
(27, 1, 1, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-04-15 09:19:26', NULL),
(28, 1, 1, '127.0.0.1', 'Unknown', '', '2026-04-15 09:31:21', NULL),
(29, 2, 3, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-04-15 11:54:56', 10),
(30, 1, 1, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-04-15 17:31:11', NULL),
(31, 2, 3, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-04-15 19:46:42', 10),
(32, 1, 1, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-04-15 20:24:02', NULL),
(33, 1, 1, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-04-16 05:34:42', NULL),
(34, 1, 1, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-05-06 23:26:25', NULL),
(35, 1, 1, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-05-07 00:06:04', NULL),
(36, 1, 1, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-05-07 05:38:28', NULL),
(37, 1, 1, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-05-07 05:52:25', NULL),
(38, 1, 1, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-05-07 10:45:47', NULL),
(39, 1, 1, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-05-07 11:34:30', NULL),
(40, 2, 3, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-05-07 13:51:17', 10),
(41, 1, 1, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-05-07 17:49:31', NULL),
(42, 1, 1, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-05-07 18:20:30', NULL),
(43, 2, 3, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-05-07 18:56:35', 10),
(44, 1, 1, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-05-07 19:07:47', NULL),
(45, 1, 1, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-05-07 21:33:24', NULL),
(46, 1, 1, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-05-08 05:31:04', NULL),
(47, 1, 1, '127.0.0.1', 'Chrome 147.0.0.0', 'Mac OS X', '2026-05-08 07:24:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mark`
--

CREATE TABLE `mark` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `mark` text DEFAULT NULL,
  `absent` varchar(4) DEFAULT NULL,
  `session_id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `marksheet_template`
--

CREATE TABLE `marksheet_template` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `background` varchar(355) DEFAULT NULL,
  `logo` varchar(355) DEFAULT NULL,
  `left_signature` varchar(255) NOT NULL,
  `middle_signature` varchar(255) DEFAULT NULL,
  `right_signature` varchar(255) DEFAULT NULL,
  `attendance_percentage` tinyint(4) NOT NULL DEFAULT 1,
  `grading_scale` tinyint(4) NOT NULL DEFAULT 1,
  `position` tinyint(4) NOT NULL DEFAULT 1,
  `cumulative_average` tinyint(4) NOT NULL DEFAULT 1,
  `class_average` tinyint(4) NOT NULL DEFAULT 1,
  `result` tinyint(4) NOT NULL DEFAULT 1,
  `subject_position` tinyint(4) NOT NULL DEFAULT 1,
  `remark` tinyint(4) NOT NULL DEFAULT 1,
  `header_content` text DEFAULT NULL,
  `footer_content` text DEFAULT NULL,
  `page_layout` tinyint(1) NOT NULL,
  `photo_style` tinyint(1) NOT NULL,
  `photo_size` float NOT NULL DEFAULT 120,
  `top_space` varchar(25) NOT NULL DEFAULT '0',
  `bottom_space` varchar(25) NOT NULL DEFAULT '0',
  `right_space` varchar(25) NOT NULL DEFAULT '0',
  `left_space` varchar(25) NOT NULL DEFAULT '0',
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `body` longtext NOT NULL,
  `subject` varchar(255) NOT NULL,
  `file_name` text DEFAULT NULL,
  `enc_name` text DEFAULT NULL,
  `trash_sent` tinyint(1) NOT NULL,
  `trash_inbox` int(11) NOT NULL,
  `fav_inbox` tinyint(1) NOT NULL,
  `fav_sent` tinyint(1) NOT NULL,
  `reciever` varchar(100) NOT NULL,
  `sender` varchar(100) NOT NULL,
  `read_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 unread 1 read',
  `reply_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 unread 1 read',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message_reply`
--

CREATE TABLE `message_reply` (
  `id` int(11) UNSIGNED NOT NULL,
  `message_id` int(11) NOT NULL,
  `body` text NOT NULL,
  `file_name` text NOT NULL,
  `enc_name` text NOT NULL,
  `identity` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`version`) VALUES
(710);

-- --------------------------------------------------------

--
-- Table structure for table `modules_manage`
--

CREATE TABLE `modules_manage` (
  `id` int(11) NOT NULL,
  `modules_id` int(11) NOT NULL,
  `isEnabled` tinyint(1) NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `modules_manage`
--

INSERT INTO `modules_manage` (`id`, `modules_id`, `isEnabled`, `branch_id`) VALUES
(1, 10, 0, 1),
(2, 11, 0, 1),
(3, 19, 0, 1),
(4, 22, 0, 1),
(6, 26, 1, 1),
(7, 27, 0, 1),
(8, 10, 0, 2),
(9, 11, 0, 2),
(10, 19, 0, 2),
(11, 22, 0, 2),
(13, 26, 1, 2),
(14, 27, 0, 2),
(15, 10, 0, 3),
(16, 11, 0, 3),
(17, 19, 0, 3),
(18, 22, 0, 3),
(20, 26, 1, 3),
(21, 27, 0, 3),
(22, 10, 0, 4),
(23, 11, 0, 4),
(24, 19, 0, 4),
(25, 22, 0, 4),
(27, 26, 1, 4),
(28, 27, 0, 4),
(29, 10, 0, 5),
(30, 11, 0, 5),
(31, 19, 0, 5),
(32, 22, 0, 5),
(34, 26, 1, 5),
(35, 27, 0, 5),
(36, 10, 0, 6),
(37, 11, 0, 6),
(38, 19, 0, 6),
(39, 22, 0, 6),
(41, 26, 1, 6),
(42, 27, 0, 6),
(43, 10, 0, 7),
(44, 11, 0, 7),
(45, 19, 0, 7),
(46, 22, 0, 7),
(48, 26, 1, 7),
(49, 27, 0, 7),
(50, 10, 0, 8),
(51, 11, 0, 8),
(52, 19, 0, 8),
(53, 22, 0, 8),
(55, 26, 1, 8),
(56, 27, 0, 8),
(57, 10, 0, 9),
(58, 11, 0, 9),
(59, 19, 0, 9),
(60, 22, 0, 9),
(62, 26, 1, 9),
(63, 27, 0, 9),
(64, 10, 0, 10),
(65, 11, 0, 10),
(66, 19, 0, 10),
(67, 22, 0, 10),
(69, 26, 1, 10),
(70, 27, 0, 10),
(71, 26, 1, 1),
(72, 26, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `offline_fees_payments`
--

CREATE TABLE `offline_fees_payments` (
  `id` int(11) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `student_enroll_id` int(11) DEFAULT NULL,
  `fees_allocation_id` int(11) DEFAULT NULL,
  `fees_type_id` int(11) DEFAULT NULL,
  `transport_fee_details_id` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `reference` varchar(200) DEFAULT NULL,
  `amount` float(10,2) DEFAULT NULL,
  `fine` float(10,2) DEFAULT NULL,
  `submit_date` datetime DEFAULT NULL,
  `approve_date` datetime DEFAULT NULL,
  `orig_file_name` varchar(255) DEFAULT NULL,
  `enc_file_name` text DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offline_payment_types`
--

CREATE TABLE `offline_payment_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `note` varchar(500) DEFAULT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `online_admission`
--

CREATE TABLE `online_admission` (
  `id` int(11) NOT NULL,
  `reference_no` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `gender` varchar(25) DEFAULT NULL,
  `birthday` varchar(100) DEFAULT NULL,
  `religion` varchar(100) DEFAULT NULL,
  `caste` varchar(100) DEFAULT NULL,
  `blood_group` varchar(100) DEFAULT NULL,
  `mobile_no` varchar(50) DEFAULT NULL,
  `mother_tongue` varchar(100) DEFAULT NULL,
  `present_address` text DEFAULT NULL,
  `permanent_address` text DEFAULT NULL,
  `admission_date` varchar(100) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `student_photo` varchar(255) DEFAULT NULL,
  `category_id` varchar(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `previous_school_details` text DEFAULT NULL,
  `guardian_name` varchar(255) DEFAULT NULL,
  `guardian_relation` varchar(50) DEFAULT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `mother_name` varchar(255) DEFAULT NULL,
  `grd_occupation` varchar(255) DEFAULT NULL,
  `grd_income` varchar(25) DEFAULT NULL,
  `grd_education` varchar(255) DEFAULT NULL,
  `grd_email` varchar(255) DEFAULT NULL,
  `grd_mobile_no` varchar(50) DEFAULT NULL,
  `grd_address` text DEFAULT NULL,
  `grd_city` varchar(255) DEFAULT NULL,
  `grd_state` varchar(255) DEFAULT NULL,
  `grd_photo` varchar(255) DEFAULT NULL,
  `status` tinyint(3) NOT NULL DEFAULT 1,
  `payment_status` tinyint(1) NOT NULL DEFAULT 0,
  `payment_amount` decimal(18,2) NOT NULL,
  `payment_details` longtext NOT NULL,
  `branch_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` varchar(11) DEFAULT NULL,
  `apply_date` datetime NOT NULL,
  `doc` varchar(255) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `online_admission_fields`
--

CREATE TABLE `online_admission_fields` (
  `id` int(11) NOT NULL,
  `fields_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `required` tinyint(4) NOT NULL DEFAULT 0,
  `system` tinyint(1) NOT NULL DEFAULT 1,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `online_exam`
--

CREATE TABLE `online_exam` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` text NOT NULL,
  `subject_id` text NOT NULL,
  `limits_participation` int(11) NOT NULL,
  `exam_start` datetime DEFAULT NULL,
  `exam_end` datetime DEFAULT NULL,
  `duration` time NOT NULL,
  `mark_type` tinyint(1) NOT NULL DEFAULT 1,
  `passing_mark` float NOT NULL DEFAULT 0,
  `instruction` text DEFAULT NULL,
  `session_id` int(11) DEFAULT NULL,
  `publish_result` tinyint(1) NOT NULL DEFAULT 0,
  `marks_display` tinyint(1) NOT NULL DEFAULT 1,
  `neg_mark` tinyint(1) NOT NULL DEFAULT 0,
  `question_type` tinyint(1) NOT NULL DEFAULT 0,
  `publish_status` tinyint(1) NOT NULL DEFAULT 0,
  `exam_type` tinyint(1) NOT NULL DEFAULT 0,
  `fee` float NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL,
  `position_generated` tinyint(1) NOT NULL DEFAULT 0,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `online_exam_answer`
--

CREATE TABLE `online_exam_answer` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `online_exam_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `online_exam_attempts`
--

CREATE TABLE `online_exam_attempts` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `online_exam_id` int(11) NOT NULL,
  `count` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `online_exam_payment`
--

CREATE TABLE `online_exam_payment` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `payment_method` tinyint(4) NOT NULL,
  `amount` float NOT NULL DEFAULT 0,
  `transaction_id` varchar(500) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `online_exam_submitted`
--

CREATE TABLE `online_exam_submitted` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `online_exam_id` int(11) NOT NULL,
  `remark` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parent`
--

CREATE TABLE `parent` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `relation` varchar(255) DEFAULT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `mother_name` varchar(255) DEFAULT NULL,
  `occupation` varchar(100) DEFAULT NULL,
  `income` varchar(100) DEFAULT NULL,
  `education` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobileno` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `facebook_url` varchar(255) DEFAULT NULL,
  `linkedin_url` varchar(255) DEFAULT NULL,
  `twitter_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `active` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0(active) 1(deactivate)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `parent`
--

INSERT INTO `parent` (`id`, `name`, `relation`, `father_name`, `mother_name`, `occupation`, `income`, `education`, `email`, `mobileno`, `address`, `city`, `state`, `branch_id`, `photo`, `facebook_url`, `linkedin_url`, `twitter_url`, `created_at`, `updated_at`, `active`) VALUES
(1, 'Salmanu Muhammad', 'Father', '', '', 'Civil Servant', '0', 'PhD', 'salmanu@gmail.com', '09022334455', 'Kaudna', '', '', 1, 'defualt.png', NULL, NULL, NULL, '2026-04-02 14:55:07', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `payment_config`
--

CREATE TABLE `payment_config` (
  `id` int(11) NOT NULL,
  `paypal_username` varchar(255) DEFAULT NULL,
  `paypal_password` varchar(255) DEFAULT NULL,
  `paypal_signature` varchar(255) DEFAULT NULL,
  `paypal_email` varchar(255) DEFAULT NULL,
  `paypal_sandbox` tinyint(4) DEFAULT NULL,
  `paypal_status` tinyint(4) DEFAULT NULL,
  `stripe_secret` varchar(255) DEFAULT NULL,
  `stripe_publishiable` varchar(255) NOT NULL,
  `stripe_demo` varchar(255) DEFAULT NULL,
  `stripe_status` tinyint(4) DEFAULT NULL,
  `payumoney_key` varchar(255) DEFAULT NULL,
  `payumoney_salt` varchar(255) DEFAULT NULL,
  `payumoney_demo` tinyint(4) DEFAULT NULL,
  `payumoney_status` tinyint(4) DEFAULT NULL,
  `paystack_secret_key` varchar(255) NOT NULL,
  `paystack_status` tinyint(4) NOT NULL,
  `razorpay_key_id` varchar(255) NOT NULL,
  `razorpay_key_secret` varchar(255) NOT NULL,
  `razorpay_demo` tinyint(4) NOT NULL,
  `razorpay_status` tinyint(4) NOT NULL,
  `sslcz_store_id` varchar(255) NOT NULL,
  `sslcz_store_passwd` varchar(255) NOT NULL,
  `sslcommerz_sandbox` tinyint(1) NOT NULL,
  `sslcommerz_status` tinyint(1) NOT NULL,
  `jazzcash_merchant_id` varchar(255) NOT NULL,
  `jazzcash_passwd` varchar(255) NOT NULL,
  `jazzcash_integerity_salt` varchar(255) NOT NULL,
  `jazzcash_sandbox` tinyint(1) NOT NULL,
  `jazzcash_status` tinyint(1) NOT NULL,
  `midtrans_client_key` varchar(255) NOT NULL,
  `midtrans_server_key` varchar(255) NOT NULL,
  `midtrans_sandbox` tinyint(1) NOT NULL,
  `midtrans_status` tinyint(1) NOT NULL,
  `flutterwave_public_key` varchar(255) DEFAULT NULL,
  `flutterwave_secret_key` varchar(255) DEFAULT NULL,
  `flutterwave_sandbox` tinyint(4) NOT NULL DEFAULT 0,
  `flutterwave_status` tinyint(4) NOT NULL DEFAULT 0,
  `paytm_merchantmid` varchar(255) DEFAULT NULL,
  `paytm_merchantkey` varchar(255) DEFAULT NULL,
  `paytm_merchant_website` varchar(255) DEFAULT NULL,
  `paytm_industry_type` varchar(255) DEFAULT NULL,
  `paytm_status` tinyint(1) NOT NULL DEFAULT 0,
  `toyyibpay_secretkey` varchar(255) DEFAULT NULL,
  `toyyibpay_categorycode` varchar(255) DEFAULT NULL,
  `toyyibpay_status` tinyint(1) NOT NULL DEFAULT 0,
  `payhere_merchant_id` varchar(255) DEFAULT NULL,
  `payhere_merchant_secret` varchar(255) DEFAULT NULL,
  `payhere_status` tinyint(1) NOT NULL DEFAULT 0,
  `nepalste_public_key` varchar(255) DEFAULT NULL,
  `nepalste_secret_key` varchar(255) DEFAULT NULL,
  `nepalste_status` tinyint(1) NOT NULL DEFAULT 0,
  `bkash_app_key` varchar(255) DEFAULT NULL,
  `bkash_app_secret` varchar(255) DEFAULT NULL,
  `bkash_username` varchar(255) DEFAULT NULL,
  `bkash_password` varchar(255) DEFAULT NULL,
  `bkash_sandbox` tinyint(1) NOT NULL DEFAULT 0,
  `bkash_status` tinyint(1) NOT NULL DEFAULT 0,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `payment_config`
--

INSERT INTO `payment_config` (`id`, `paypal_username`, `paypal_password`, `paypal_signature`, `paypal_email`, `paypal_sandbox`, `paypal_status`, `stripe_secret`, `stripe_publishiable`, `stripe_demo`, `stripe_status`, `payumoney_key`, `payumoney_salt`, `payumoney_demo`, `payumoney_status`, `paystack_secret_key`, `paystack_status`, `razorpay_key_id`, `razorpay_key_secret`, `razorpay_demo`, `razorpay_status`, `sslcz_store_id`, `sslcz_store_passwd`, `sslcommerz_sandbox`, `sslcommerz_status`, `jazzcash_merchant_id`, `jazzcash_passwd`, `jazzcash_integerity_salt`, `jazzcash_sandbox`, `jazzcash_status`, `midtrans_client_key`, `midtrans_server_key`, `midtrans_sandbox`, `midtrans_status`, `flutterwave_public_key`, `flutterwave_secret_key`, `flutterwave_sandbox`, `flutterwave_status`, `paytm_merchantmid`, `paytm_merchantkey`, `paytm_merchant_website`, `paytm_industry_type`, `paytm_status`, `toyyibpay_secretkey`, `toyyibpay_categorycode`, `toyyibpay_status`, `payhere_merchant_id`, `payhere_merchant_secret`, `payhere_status`, `nepalste_public_key`, `nepalste_secret_key`, `nepalste_status`, `bkash_app_key`, `bkash_app_secret`, `bkash_username`, `bkash_password`, `bkash_sandbox`, `bkash_status`, `branch_id`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, 0, NULL, '', NULL, 0, NULL, NULL, NULL, 0, '', 1, '', '', 0, 0, '', '', 0, 0, '', '', '', 0, 0, '', '', 0, 0, NULL, NULL, 0, 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 2, '2026-04-16 06:34:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment_salary_stipend`
--

CREATE TABLE `payment_salary_stipend` (
  `id` int(11) NOT NULL,
  `payslip_id` int(11) NOT NULL,
  `name` longtext NOT NULL,
  `amount` int(11) NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_types`
--

CREATE TABLE `payment_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `timestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `payment_types`
--

INSERT INTO `payment_types` (`id`, `name`, `branch_id`, `timestamp`) VALUES
(1, 'Cash', 0, '2026-02-12 18:12:21'),
(2, 'Card', 0, '2026-02-12 18:12:31'),
(3, 'Cheque', 0, '2026-02-12 10:07:59'),
(4, 'Bank Transfer', 0, '2026-02-12 10:08:36'),
(5, 'Other', 0, '2026-02-12 10:08:45'),
(6, 'Paypal', 0, '2026-02-12 10:08:45'),
(7, 'Stripe', 0, '2026-02-12 10:08:45'),
(8, 'PayUmoney', 0, '2026-02-12 10:08:45'),
(9, 'Paystack', 0, '2026-02-12 10:08:45'),
(10, 'Razorpay', 0, '2026-02-12 10:08:45'),
(11, 'SSLcommerz', 0, '2026-02-18 10:08:45'),
(12, 'Jazzcash', 0, '2026-02-18 10:08:45'),
(13, 'Midtrans', 0, '2026-02-18 10:08:45'),
(14, 'Flutter Wave', 0, '2026-02-18 10:08:45'),
(15, 'Offline Payments', 0, '2026-02-18 10:08:45'),
(16, 'Paytm', 0, '2026-02-20 12:08:45'),
(17, 'toyyibPay', 0, '2026-02-20 12:08:45'),
(18, 'Payhere', 0, '2026-02-20 12:08:45'),
(19, 'Nepalste', 0, '2026-02-20 12:08:45'),
(20, 'bKash', 0, '2026-02-22 18:19:08');

-- --------------------------------------------------------

--
-- Table structure for table `payslip`
--

CREATE TABLE `payslip` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `month` varchar(200) DEFAULT NULL,
  `year` varchar(20) NOT NULL,
  `basic_salary` decimal(18,2) NOT NULL,
  `total_allowance` decimal(18,2) NOT NULL,
  `total_deduction` decimal(18,2) NOT NULL,
  `net_salary` decimal(18,2) NOT NULL,
  `bill_no` varchar(25) NOT NULL,
  `remarks` text NOT NULL,
  `pay_via` tinyint(1) NOT NULL,
  `hash` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `paid_by` varchar(200) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payslip_details`
--

CREATE TABLE `payslip_details` (
  `id` int(11) NOT NULL,
  `payslip_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `type` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `prefix` varchar(100) NOT NULL,
  `show_view` tinyint(1) DEFAULT 1,
  `show_add` tinyint(1) DEFAULT 1,
  `show_edit` tinyint(1) DEFAULT 1,
  `show_delete` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`id`, `module_id`, `name`, `prefix`, `show_view`, `show_add`, `show_edit`, `show_delete`, `created_at`) VALUES
(1, 2, 'Student', 'student', 1, 1, 1, 1, '2026-02-14 11:45:47'),
(2, 2, 'Multiple Import', 'multiple_import', 0, 1, 0, 0, '2026-02-14 11:45:47'),
(3, 2, 'Student Category', 'student_category', 1, 1, 1, 1, '2026-02-14 11:45:47'),
(4, 2, 'Student Id Card', 'student_id_card', 1, 0, 0, 0, '2026-02-14 11:45:47'),
(5, 2, 'Disable Authentication', 'student_disable_authentication', 1, 1, 0, 0, '2026-02-14 11:45:47'),
(6, 4, 'Employee', 'employee', 1, 1, 1, 1, '2026-02-14 11:55:19'),
(7, 3, 'Parent', 'parent', 1, 1, 1, 1, '2026-02-14 13:24:05'),
(8, 3, 'Disable Authentication', 'parent_disable_authentication', 1, 1, 0, 0, '2026-02-14 14:22:21'),
(9, 4, 'Department', 'department', 1, 1, 1, 1, '2026-02-14 17:41:39'),
(10, 4, 'Designation', 'designation', 1, 1, 1, 1, '2026-02-14 17:41:39'),
(11, 4, 'Disable Authentication', 'employee_disable_authentication', 1, 1, 0, 0, '2026-02-14 17:41:39'),
(12, 5, 'Salary Template', 'salary_template', 1, 1, 1, 1, '2026-02-14 05:13:57'),
(13, 5, 'Salary Assign', 'salary_assign', 1, 1, 0, 0, '2026-02-14 05:14:05'),
(14, 5, 'Salary Payment', 'salary_payment', 1, 1, 0, 0, '2026-02-14 06:45:40'),
(15, 5, 'Salary Summary Report', 'salary_summary_report', 1, 0, 0, 0, '2026-02-14 17:09:17'),
(16, 5, 'Advance Salary', 'advance_salary', 1, 1, 1, 1, '2026-02-14 18:23:39'),
(17, 5, 'Advance Salary Manage', 'advance_salary_manage', 1, 1, 1, 1, '2026-02-14 04:57:12'),
(18, 5, 'Advance Salary Request', 'advance_salary_request', 1, 1, 0, 1, '2026-02-14 17:49:58'),
(19, 5, 'Leave Category', 'leave_category', 1, 1, 1, 1, '2026-02-14 02:46:23'),
(20, 5, 'Leave Request', 'leave_request', 1, 1, 1, 1, '2026-02-14 12:06:33'),
(21, 5, 'Leave Manage', 'leave_manage', 1, 1, 1, 1, '2026-02-14 07:27:15'),
(22, 5, 'Award', 'award', 1, 1, 1, 1, '2026-02-14 18:49:11'),
(23, 6, 'Classes', 'classes', 1, 1, 1, 1, '2026-02-14 18:10:00'),
(24, 6, 'Section', 'section', 1, 1, 1, 1, '2026-02-14 21:06:44'),
(25, 6, 'Assign Class Teacher', 'assign_class_teacher', 1, 1, 1, 1, '2026-02-14 07:09:22'),
(26, 6, 'Subject', 'subject', 1, 1, 1, 1, '2026-02-14 04:32:39'),
(27, 6, 'Subject Class Assign ', 'subject_class_assign', 1, 1, 1, 1, '2026-02-14 17:43:19'),
(28, 6, 'Subject Teacher Assign', 'subject_teacher_assign', 1, 1, 0, 1, '2026-02-14 19:05:11'),
(29, 6, 'Class Timetable', 'class_timetable', 1, 1, 1, 1, '2026-02-14 05:50:37'),
(30, 2, 'Student Promotion', 'student_promotion', 1, 1, 0, 0, '2026-02-14 18:20:30'),
(31, 8, 'Attachments', 'attachments', 1, 1, 1, 1, '2026-02-14 17:59:43'),
(32, 7, 'Homework', 'homework', 1, 1, 1, 1, '2026-02-14 05:40:08'),
(33, 8, 'Attachment Type', 'attachment_type', 1, 1, 1, 1, '2026-02-14 07:16:28'),
(34, 9, 'Exam', 'exam', 1, 1, 1, 1, '2026-02-14 09:59:29'),
(35, 9, 'Exam Term', 'exam_term', 1, 1, 1, 1, '2026-02-14 12:09:28'),
(36, 9, 'Exam Hall', 'exam_hall', 1, 1, 1, 1, '2026-02-14 14:31:04'),
(37, 9, 'Exam Timetable', 'exam_timetable', 1, 1, 0, 1, '2026-02-14 17:04:31'),
(38, 9, 'Exam Mark', 'exam_mark', 1, 1, 1, 1, '2026-02-14 12:53:41'),
(39, 9, 'Exam Grade', 'exam_grade', 1, 1, 1, 1, '2026-02-14 17:29:16'),
(40, 10, 'Hostel', 'hostel', 1, 1, 1, 1, '2026-02-14 04:41:36'),
(41, 10, 'Hostel Category', 'hostel_category', 1, 1, 1, 1, '2026-02-14 07:52:31'),
(42, 10, 'Hostel Room', 'hostel_room', 1, 1, 1, 1, '2026-02-14 11:50:09'),
(43, 10, 'Hostel Allocation', 'hostel_allocation', 1, 0, 0, 1, '2026-02-14 13:06:15'),
(44, 11, 'Transport Route', 'transport_route', 1, 1, 1, 1, '2026-02-14 05:26:19'),
(45, 11, 'Transport Vehicle', 'transport_vehicle', 1, 1, 1, 1, '2026-02-14 05:57:30'),
(46, 11, 'Transport Stoppage', 'transport_stoppage', 1, 1, 1, 1, '2026-02-14 06:49:20'),
(47, 11, 'Transport Assign', 'transport_assign', 1, 1, 1, 1, '2026-02-14 09:55:21'),
(48, 11, 'Transport Allocation', 'transport_allocation', 1, 0, 0, 1, '2026-02-14 19:33:05'),
(49, 12, 'Student Attendance', 'student_attendance', 0, 1, 0, 0, '2026-02-14 05:25:53'),
(50, 12, 'Employee Attendance', 'employee_attendance', 0, 1, 0, 0, '2026-02-14 10:04:16'),
(51, 12, 'Exam Attendance', 'exam_attendance', 0, 1, 0, 0, '2026-02-14 11:08:14'),
(52, 12, 'Student Attendance Report', 'student_attendance_report', 1, 0, 0, 0, '2026-02-14 19:20:56'),
(53, 12, 'Employee Attendance Report', 'employee_attendance_report', 1, 0, 0, 0, '2026-02-14 06:08:53'),
(54, 12, 'Exam Attendance Report', 'exam_attendance_report', 1, 0, 0, 0, '2026-02-14 06:21:40'),
(55, 13, 'Book', 'book', 1, 1, 1, 1, '2026-02-14 06:40:42'),
(56, 13, 'Book Category', 'book_category', 1, 1, 1, 1, '2026-02-14 04:11:41'),
(57, 13, 'Book Manage', 'book_manage', 1, 1, 0, 1, '2026-02-14 11:13:24'),
(58, 13, 'Book Request', 'book_request', 1, 1, 0, 1, '2026-02-14 06:45:19'),
(59, 14, 'Event', 'event', 1, 1, 1, 1, '2026-02-14 18:02:15'),
(60, 14, 'Event Type', 'event_type', 1, 1, 1, 1, '2026-02-14 04:40:33'),
(61, 15, 'Sendsmsmail', 'sendsmsmail', 1, 1, 0, 1, '2026-02-14 07:19:57'),
(62, 15, 'Sendsmsmail Template', 'sendsmsmail_template', 1, 1, 1, 1, '2026-02-14 10:14:57'),
(63, 17, 'Account', 'account', 1, 1, 1, 1, '2026-02-14 09:34:43'),
(64, 17, 'Deposit', 'deposit', 1, 1, 1, 1, '2026-02-14 12:56:11'),
(65, 17, 'Expense', 'expense', 1, 1, 1, 1, '2026-02-14 06:35:57'),
(66, 17, 'All Transactions', 'all_transactions', 1, 0, 0, 0, '2026-02-14 13:35:05'),
(67, 17, 'Voucher Head', 'voucher_head', 1, 1, 1, 1, '2026-02-14 10:50:56'),
(68, 17, 'Accounting Reports', 'accounting_reports', 1, 1, 1, 1, '2026-02-14 13:36:24'),
(69, 16, 'Fees Type', 'fees_type', 1, 1, 1, 1, '2026-02-14 10:11:03'),
(70, 16, 'Fees Group', 'fees_group', 1, 1, 1, 1, '2026-02-14 05:49:09'),
(71, 16, 'Fees Fine Setup', 'fees_fine_setup', 1, 1, 1, 1, '2026-02-14 02:59:27'),
(72, 16, 'Fees Allocation', 'fees_allocation', 1, 1, 1, 1, '2026-02-14 13:47:43'),
(73, 16, 'Collect Fees', 'collect_fees', 0, 1, 0, 0, '2026-02-14 04:23:58'),
(74, 16, 'Fees Reminder', 'fees_reminder', 1, 1, 1, 1, '2026-02-14 04:29:58'),
(75, 16, 'Due Invoice', 'due_invoice', 1, 0, 0, 0, '2026-02-14 04:33:36'),
(76, 16, 'Invoice', 'invoice', 1, 0, 0, 1, '2026-02-14 04:38:06'),
(77, 9, 'Mark Distribution', 'mark_distribution', 1, 1, 1, 1, '2026-02-14 13:02:54'),
(78, 9, 'Report Card', 'report_card', 1, 0, 0, 0, '2026-02-14 12:20:28'),
(79, 9, 'Tabulation Sheet', 'tabulation_sheet', 1, 0, 0, 0, '2026-02-14 07:12:38'),
(80, 15, 'Sendsmsmail Reports', 'sendsmsmail_reports', 1, 0, 0, 0, '2026-02-14 17:02:02'),
(81, 18, 'Global Settings', 'global_settings', 1, 0, 1, 0, '2026-02-14 05:05:41'),
(82, 18, 'Payment Settings', 'payment_settings', 1, 1, 0, 0, '2026-02-14 05:08:57'),
(83, 18, 'Sms Settings', 'sms_settings', 1, 1, 1, 1, '2026-02-14 05:08:57'),
(84, 18, 'Email Settings', 'email_settings', 1, 1, 1, 1, '2026-02-14 05:10:39'),
(85, 18, 'Translations', 'translations', 1, 1, 1, 1, '2026-02-14 05:18:33'),
(86, 18, 'Backup', 'backup', 1, 1, 1, 1, '2026-02-14 07:09:33'),
(87, 18, 'Backup Restore', 'backup_restore', 0, 1, 0, 0, '2026-02-14 07:09:34'),
(88, 7, 'Homework Evaluate', 'homework_evaluate', 1, 1, 0, 0, '2026-02-14 04:20:29'),
(89, 7, 'Evaluation Report', 'evaluation_report', 1, 0, 0, 0, '2026-02-14 09:56:04'),
(90, 18, 'School Settings', 'school_settings', 1, 0, 1, 0, '2026-02-14 17:36:37'),
(91, 1, 'Monthly Income Vs Expense Pie Chart', 'monthly_income_vs_expense_chart', 1, 0, 0, 0, '2026-02-14 06:15:31'),
(92, 1, 'Annual Student Fees Summary Chart', 'annual_student_fees_summary_chart', 1, 0, 0, 0, '2026-02-14 06:15:31'),
(93, 1, 'Employee Count Widget', 'employee_count_widget', 1, 0, 0, 0, '2026-02-14 06:31:56'),
(94, 1, 'Student Count Widget', 'student_count_widget', 1, 0, 0, 0, '2026-02-14 06:31:56'),
(95, 1, 'Parent Count Widget', 'parent_count_widget', 1, 0, 0, 0, '2026-02-14 06:31:56'),
(96, 1, 'Teacher Count Widget', 'teacher_count_widget', 1, 0, 0, 0, '2026-02-14 06:31:56'),
(97, 1, 'Student Quantity Pie Chart', 'student_quantity_pie_chart', 1, 0, 0, 0, '2026-02-14 07:14:07'),
(98, 1, 'Weekend Attendance Inspection Chart', 'weekend_attendance_inspection_chart', 1, 0, 0, 0, '2026-02-14 07:14:07'),
(99, 1, 'Admission Count Widget', 'admission_count_widget', 1, 0, 0, 0, '2026-02-14 07:22:05'),
(100, 1, 'Voucher Count Widget', 'voucher_count_widget', 1, 0, 0, 0, '2026-02-14 07:22:05'),
(101, 1, 'Transport Count Widget', 'transport_count_widget', 1, 0, 0, 0, '2026-02-14 07:22:05'),
(102, 1, 'Hostel Count Widget', 'hostel_count_widget', 1, 0, 0, 0, '2026-02-14 07:22:05'),
(103, 18, 'Accounting Links', 'accounting_links', 1, 0, 1, 0, '2026-02-14 09:46:30'),
(104, 16, 'Fees Reports', 'fees_reports', 1, 0, 0, 0, '2026-02-14 15:52:19'),
(105, 18, 'Cron Job', 'cron_job', 1, 0, 1, 0, '2026-02-14 09:46:30'),
(106, 18, 'Custom Field', 'custom_field', 1, 1, 1, 1, '2026-02-14 09:46:30'),
(107, 5, 'Leave Reports', 'leave_reports', 1, 0, 0, 0, '2026-02-14 09:46:30'),
(108, 18, 'Live Class Config', 'live_class_config', 1, 0, 1, 0, '2026-02-14 09:46:30'),
(109, 19, 'Live Class', 'live_class', 1, 1, 1, 1, '2026-02-14 09:46:30'),
(110, 20, 'Certificate Templete', 'certificate_templete', 1, 1, 1, 1, '2026-02-14 09:46:30'),
(111, 20, 'Generate Student Certificate', 'generate_student_certificate', 1, 0, 0, 0, '2026-02-14 09:46:30'),
(112, 20, 'Generate Employee Certificate', 'generate_employee_certificate', 1, 0, 0, 0, '2026-02-14 09:46:30'),
(113, 21, 'ID Card Templete', 'id_card_templete', 1, 1, 1, 1, '2026-02-14 09:46:30'),
(114, 21, 'Generate Student ID Card', 'generate_student_idcard', 1, 0, 0, 0, '2026-02-14 09:46:30'),
(115, 21, 'Generate Employee ID Card', 'generate_employee_idcard', 1, 0, 0, 0, '2026-02-14 09:46:30'),
(116, 21, 'Admit Card Templete', 'admit_card_templete', 1, 1, 1, 1, '2026-02-14 09:46:30'),
(117, 21, 'Generate Admit card', 'generate_admit_card', 1, 0, 0, 0, '2026-02-14 09:46:30'),
(118, 22, 'Frontend Setting', 'frontend_setting', 1, 1, 0, 0, '2026-02-12 03:24:07'),
(119, 22, 'Frontend Menu', 'frontend_menu', 1, 1, 1, 1, '2026-02-12 04:03:39'),
(120, 22, 'Frontend Section', 'frontend_section', 1, 1, 0, 0, '2026-02-12 04:26:11'),
(121, 22, 'Manage Page', 'manage_page', 1, 1, 1, 1, '2026-02-12 05:54:08'),
(122, 22, 'Frontend Slider', 'frontend_slider', 1, 1, 1, 1, '2026-02-12 06:12:31'),
(123, 22, 'Frontend Features', 'frontend_features', 1, 1, 1, 1, '2026-02-12 06:47:51'),
(124, 22, 'Frontend Testimonial', 'frontend_testimonial', 1, 1, 1, 1, '2026-02-12 06:54:30'),
(125, 22, 'Frontend Services', 'frontend_services', 1, 1, 1, 1, '2026-02-12 07:01:44'),
(126, 22, 'Frontend Faq', 'frontend_faq', 1, 1, 1, 1, '2026-02-12 07:06:16'),
(127, 2, 'Online Admission', 'online_admission', 1, 1, 0, 1, '2026-02-12 07:06:16'),
(128, 18, 'System Update', 'system_update', 0, 1, 0, 0, '2026-02-12 07:06:16'),
(129, 19, 'Live Class Reports', 'live_class_reports', 1, 0, 0, 0, '2026-02-14 09:46:30'),
(130, 16, 'Fees Revert', 'fees_revert', 0, 0, 0, 1, '2026-02-14 09:46:30'),
(131, 22, 'Frontend Gallery', 'frontend_gallery', 1, 1, 1, 1, '2026-02-12 07:06:16'),
(132, 22, 'Frontend Gallery Category', 'frontend_gallery_category', 1, 1, 1, 1, '2026-02-12 07:06:16'),
(133, 6, 'Teacher Timetable', 'teacher_timetable', 1, 0, 0, 0, '2026-02-16 09:46:30'),
(134, 18, 'Whatsapp Config', 'whatsapp_config', 1, 1, 1, 1, '2026-02-16 09:46:30'),
(135, 18, 'System Student Field', 'system_student_field', 1, 0, 1, 0, '2026-02-16 09:46:30'),
(136, 23, 'Online Exam', 'online_exam', 1, 1, 1, 1, '2026-02-16 09:46:30'),
(137, 23, 'Question Bank', 'question_bank', 1, 1, 1, 1, '2026-02-16 09:46:30'),
(138, 23, 'Add Questions', 'add_questions', 0, 1, 0, 0, '2026-02-16 09:46:30'),
(139, 23, 'Question Group', 'question_group', 1, 1, 1, 1, '2026-02-16 09:46:30'),
(140, 23, 'Exam Result', 'exam_result', 1, 0, 0, 0, '2026-02-16 09:46:30'),
(141, 23, 'Position Generate', 'position_generate', 1, 1, 0, 0, '2026-02-16 09:46:30'),
(142, 24, 'Postal Record', 'postal_record', 1, 1, 1, 1, '2026-02-16 09:46:30'),
(143, 24, 'Call Log', 'call_log', 1, 1, 1, 1, '2026-02-16 09:46:30'),
(144, 24, 'Visitor Log', 'visitor_log', 1, 1, 1, 1, '2026-02-16 09:46:30'),
(145, 24, 'Complaint', 'complaint', 1, 1, 1, 1, '2026-02-16 09:46:30'),
(146, 24, 'Enquiry', 'enquiry', 1, 1, 1, 1, '2026-02-16 09:46:30'),
(147, 24, 'Follow Up', 'follow_up', 1, 1, 0, 1, '2026-02-16 09:46:30'),
(148, 24, 'Config Reception', 'config_reception', 1, 1, 1, 1, '2026-02-16 09:46:30'),
(149, 15, 'Student Birthday Wishes', 'student_birthday_wishes', 1, 0, 0, 0, '2026-02-16 09:46:30'),
(150, 15, 'Staff Birthday Wishes', 'staff_birthday_wishes', 1, 0, 0, 0, '2026-02-16 09:46:30'),
(151, 1, 'Student Birthday Wishes Widget', 'student_birthday_widget', 1, 0, 0, 0, '2026-02-16 07:22:05'),
(152, 1, 'Staff Birthday Wishes Widget', 'staff_birthday_widget', 1, 0, 0, 0, '2026-02-16 07:22:05'),
(153, 9, 'Progress Reports', 'progress_reports', 1, 0, 0, 0, '2026-02-16 07:12:38'),
(154, 2, 'Disable Reason', 'disable_reason', 1, 1, 1, 1, '2026-02-16 07:12:38'),
(155, 16, 'Offline Payments', 'offline_payments', 1, 0, 0, 0, '2026-02-20 07:12:38'),
(156, 16, 'Offline Payments Type', 'offline_payments_type', 1, 1, 1, 1, '2026-02-20 07:12:38'),
(157, 25, 'Product', 'product', 1, 1, 1, 1, '2026-02-20 19:21:42'),
(158, 25, 'Product Category', 'product_category', 1, 1, 1, 1, '2026-02-20 19:21:42'),
(159, 25, 'Product Supplier', 'product_supplier', 1, 1, 1, 1, '2026-02-20 19:21:42'),
(160, 25, 'Product Unit', 'product_unit', 1, 1, 1, 1, '2026-02-20 19:21:42'),
(161, 25, 'Product Purchase', 'product_purchase', 1, 1, 1, 1, '2026-02-20 19:21:42'),
(162, 25, 'Purchase Payment', 'purchase_payment', 1, 1, 0, 0, '2026-02-20 19:21:42'),
(163, 25, 'Product Store', 'product_store', 1, 1, 1, 1, '2026-02-20 19:21:42'),
(164, 25, 'Product Sales', 'product_sales', 1, 1, 0, 1, '2026-02-20 19:21:42'),
(165, 25, 'Sales Payment', 'sales_payment', 1, 0, 0, 0, '2026-02-20 07:05:10'),
(166, 25, 'Product Issue', 'product_issue', 1, 1, 0, 1, '2026-02-20 19:21:42'),
(167, 25, 'Inventory Report', 'inventory_report', 1, 0, 0, 0, '2026-02-20 03:56:45'),
(168, 9, 'Generate Position', 'generate_position', 1, 0, 0, 0, '2026-02-20 15:08:29'),
(169, 18, 'User Login Log', 'user_login_log', 1, 0, 0, 1, '2026-02-21 09:01:26'),
(170, 26, 'Manage Alumni', 'manage_alumni', 1, 1, 1, 1, '2026-02-21 09:01:26'),
(171, 26, 'Alumni Events', 'alumni_events', 1, 1, 1, 1, '2026-02-21 09:01:26'),
(172, 27, 'Multi Class Student', 'multi_class', 1, 1, 0, 0, '2026-02-21 08:28:04'),
(173, 22, 'Frontend News', 'frontend_news', 1, 1, 1, 1, '2026-02-21 08:45:48'),
(174, 9, 'Marksheet Template', 'marksheet_template', 1, 1, 1, 1, '2026-02-21 05:59:53'),
(175, 11, 'Fees setup', 'transport_fees_setup', 1, 1, 1, 1, '2026-02-22 17:41:23'),
(176, 2, 'Infrastructure Register', 'infrastructure', 1, 1, 1, 1, '2026-02-14 11:45:47');

-- --------------------------------------------------------

--
-- Table structure for table `permission_modules`
--

CREATE TABLE `permission_modules` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `prefix` varchar(50) NOT NULL,
  `system` tinyint(1) NOT NULL,
  `sorted` tinyint(10) NOT NULL,
  `in_module` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `permission_modules`
--

INSERT INTO `permission_modules` (`id`, `name`, `prefix`, `system`, `sorted`, `in_module`, `created_at`) VALUES
(1, 'Dashboard', 'dashboard', 1, 1, 0, '2026-02-12 22:23:00'),
(2, 'Student', 'student', 1, 4, 0, '2026-02-12 22:23:00'),
(3, 'Parents', 'parents', 1, 5, 0, '2026-02-12 22:23:00'),
(4, 'Employee', 'employee', 1, 6, 0, '2026-02-12 22:23:00'),
(5, 'Human Resource', 'human_resource', 1, 9, 1, '2026-02-12 22:23:00'),
(6, 'Academic', 'academic', 1, 10, 0, '2026-02-12 22:23:00'),
(7, 'Homework', 'homework', 1, 13, 1, '2026-02-12 22:23:00'),
(8, 'Attachments Book', 'attachments_book', 1, 12, 1, '2026-02-12 22:23:00'),
(9, 'Exam Master', 'exam_master', 1, 14, 0, '2026-02-12 22:23:00'),
(10, 'Hostel', 'hostel', 1, 16, 1, '2026-02-12 22:23:00'),
(11, 'Transport', 'transport', 1, 17, 1, '2026-02-12 22:23:00'),
(12, 'Attendance', 'attendance', 1, 18, 1, '2026-02-12 22:23:00'),
(13, 'Library', 'library', 1, 19, 1, '2026-02-12 22:23:00'),
(14, 'Events', 'events', 1, 20, 1, '2026-02-12 22:23:00'),
(15, 'Bulk Sms And Email', 'bulk_sms_and_email', 1, 21, 1, '2026-02-12 22:23:00'),
(16, 'Student Accounting', 'student_accounting', 1, 22, 1, '2026-02-12 22:23:00'),
(17, 'Office Accounting', 'office_accounting', 1, 23, 1, '2026-02-12 22:23:00'),
(18, 'Settings', 'settings', 1, 24, 0, '2026-02-12 22:23:00'),
(19, 'Live Class', 'live_class', 1, 11, 1, '2026-02-12 22:23:00'),
(20, 'Certificate', 'certificate', 1, 8, 1, '2026-02-12 22:23:00'),
(21, 'Card Management', 'card_management', 1, 7, 1, '2026-02-12 22:23:00'),
(22, 'Website', 'website', 1, 2, 1, '2026-02-12 22:23:00'),
(23, 'Online Exam', 'online_exam', 1, 15, 1, '2026-02-12 22:23:00'),
(24, 'Reception', 'reception', 1, 3, 1, '2026-02-12 22:23:00'),
(25, 'Inventory', 'inventory', 1, 3, 1, '2026-02-20 19:16:49'),
(26, 'Alumni', 'alumni', 1, 24, 1, '2026-02-21 19:16:49'),
(27, 'Multi Class', 'multi_class', 1, 25, 1, '2026-02-21 08:32:01'),
(28, 'Teacher Transfer', 'teacher_transfer', 0, 28, 1, '2026-04-15 10:43:31'),
(29, 'School Inspection', 'school_inspection', 0, 29, 1, '2026-04-15 10:43:31'),
(30, 'Infrastructure Register', 'infrastructure', 1, 1, 1, '2026-02-12 22:23:00');

-- --------------------------------------------------------

--
-- Table structure for table `postal_record`
--

CREATE TABLE `postal_record` (
  `id` int(11) NOT NULL,
  `sender_title` varchar(255) DEFAULT NULL,
  `receiver_title` varchar(255) DEFAULT NULL,
  `reference_no` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `date` date NOT NULL,
  `note` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `file` varchar(250) NOT NULL,
  `confidential` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 1,
  `branch_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(50) NOT NULL,
  `category_id` int(11) NOT NULL,
  `purchase_unit_id` int(11) NOT NULL,
  `sales_unit_id` int(11) NOT NULL,
  `unit_ratio` varchar(20) DEFAULT '1',
  `purchase_price` decimal(18,2) NOT NULL DEFAULT 0.00,
  `sales_price` decimal(18,2) NOT NULL DEFAULT 0.00,
  `available_stock` varchar(11) NOT NULL DEFAULT '0',
  `photo` varchar(100) DEFAULT NULL,
  `remarks` text NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `code`, `category_id`, `purchase_unit_id`, `sales_unit_id`, `unit_ratio`, `purchase_price`, `sales_price`, `available_stock`, `photo`, `remarks`, `branch_id`, `created_at`, `updated_at`) VALUES
(1, 'Female\'s Uniform', 'TP2026', 4, 3, 4, '1000', 15000000.00, 0.00, '0', NULL, '', NULL, '2026-05-07 00:44:55', '2026-05-07 00:58:40');

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`id`, `name`, `branch_id`, `created_at`, `updated_at`) VALUES
(1, 'Sports', NULL, '2026-03-26 15:26:45', NULL),
(2, 'Accessories', NULL, '2026-03-26 15:26:53', NULL),
(3, 'Study material', NULL, '2026-03-26 15:27:02', NULL),
(4, 'Dress', NULL, '2026-03-26 15:27:11', NULL),
(5, 'Books Stationery', NULL, '2026-03-26 15:27:17', NULL),
(6, 'Furniture and Equipment', NULL, '2026-03-26 15:27:24', NULL),
(7, 'Computer', NULL, '2026-03-26 15:27:33', NULL),
(56, 'Textbooks', NULL, '2026-04-16 08:10:45', NULL),
(66, 'Exercise Books', NULL, '2026-04-16 08:10:45', NULL),
(76, 'Uniforms', NULL, '2026-04-16 08:10:45', NULL),
(86, 'School Feeding Supplies', NULL, '2026-04-16 08:10:45', NULL),
(96, 'Stationery', NULL, '2026-04-16 08:10:45', NULL),
(106, 'Classrooms', NULL, '2026-04-16 08:10:45', NULL),
(116, 'Science Labs', NULL, '2026-04-16 08:10:45', NULL),
(126, 'Toilets and Sanitation', NULL, '2026-04-16 08:10:45', NULL),
(136, 'Library', NULL, '2026-04-16 08:10:45', NULL),
(146, 'ICT Computers', NULL, '2026-04-16 08:10:45', NULL),
(156, 'Furniture and Fittings', NULL, '2026-04-16 08:10:45', NULL),
(166, 'Water Supply', NULL, '2026-04-16 08:10:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_issues`
--

CREATE TABLE `product_issues` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_issue` date NOT NULL,
  `due_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `remarks` text NOT NULL,
  `prepared_by` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `branch_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_issues_details`
--

CREATE TABLE `product_issues_details` (
  `id` int(11) NOT NULL,
  `issues_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_store`
--

CREATE TABLE `product_store` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `mobileno` varchar(255) DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `product_store`
--

INSERT INTO `product_store` (`id`, `name`, `code`, `mobileno`, `address`, `description`, `branch_id`, `created_at`) VALUES
(1, 'State Learning Materials Store', 'SLMS-STATE', '09011223344', '', '', NULL, '2026-04-16 08:09:03'),
(2, 'State Infrastructure Register', 'SIR-STATE', NULL, NULL, NULL, NULL, '2026-04-16 08:09:03');

-- --------------------------------------------------------

--
-- Table structure for table `product_supplier`
--

CREATE TABLE `product_supplier` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `address` text NOT NULL,
  `mobileno` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `company_name` varchar(200) NOT NULL,
  `product_list` mediumtext NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `product_supplier`
--

INSERT INTO `product_supplier` (`id`, `name`, `address`, `mobileno`, `email`, `company_name`, `product_list`, `branch_id`, `created_at`, `updated_at`) VALUES
(1, 'ABC Company', '', '09022334455', '', '', '', NULL, '2026-05-07 00:33:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_unit`
--

CREATE TABLE `product_unit` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `product_unit`
--

INSERT INTO `product_unit` (`id`, `name`, `branch_id`, `created_at`, `updated_at`) VALUES
(1, 'KG', NULL, '2026-03-26 15:28:30', NULL),
(2, 'Piece', NULL, '2026-03-26 15:28:38', NULL),
(3, 'Dozen', NULL, '2026-03-26 15:28:45', NULL),
(4, 'Unit', NULL, '2026-03-26 15:28:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `promotion_history`
--

CREATE TABLE `promotion_history` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `pre_class` int(11) NOT NULL,
  `pre_section` int(11) NOT NULL,
  `pre_session` int(11) NOT NULL,
  `pro_class` int(11) NOT NULL,
  `pro_section` int(11) NOT NULL,
  `pro_session` int(11) NOT NULL,
  `prev_due` float NOT NULL DEFAULT 0,
  `is_leave` tinyint(4) NOT NULL DEFAULT 0,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_bill`
--

CREATE TABLE `purchase_bill` (
  `id` int(11) NOT NULL,
  `bill_no` varchar(200) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `remarks` text NOT NULL,
  `total` decimal(18,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(18,2) NOT NULL DEFAULT 0.00,
  `paid` decimal(18,2) NOT NULL DEFAULT 0.00,
  `due` decimal(18,2) NOT NULL DEFAULT 0.00,
  `payment_status` int(11) NOT NULL,
  `purchase_status` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `prepared_by` int(11) DEFAULT NULL,
  `modifier_id` int(11) DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_bill_details`
--

CREATE TABLE `purchase_bill_details` (
  `id` int(11) NOT NULL,
  `purchase_bill_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `unit_price` decimal(18,2) NOT NULL DEFAULT 0.00,
  `quantity` varchar(20) NOT NULL,
  `discount` decimal(18,2) NOT NULL DEFAULT 0.00,
  `sub_total` decimal(18,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_payment_history`
--

CREATE TABLE `purchase_payment_history` (
  `id` int(11) NOT NULL,
  `purchase_bill_id` varchar(11) NOT NULL,
  `payment_by` int(11) DEFAULT NULL,
  `amount` decimal(18,2) NOT NULL DEFAULT 0.00,
  `pay_via` varchar(25) NOT NULL,
  `remarks` text NOT NULL,
  `attach_orig_name` varchar(255) DEFAULT NULL,
  `attach_file_name` varchar(255) DEFAULT NULL,
  `paid_on` date DEFAULT NULL,
  `coll_type` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `level` tinyint(1) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) DEFAULT 0,
  `subject_id` int(11) NOT NULL DEFAULT 0,
  `group_id` int(11) NOT NULL,
  `question` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `opt_1` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `opt_2` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `opt_3` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `opt_4` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `answer` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `mark` float(10,2) NOT NULL DEFAULT 0.00,
  `branch_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions_manage`
--

CREATE TABLE `questions_manage` (
  `id` int(11) NOT NULL,
  `question_id` int(11) DEFAULT NULL,
  `onlineexam_id` int(11) DEFAULT NULL,
  `marks` float(10,2) NOT NULL DEFAULT 0.00,
  `neg_marks` float(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `question_group`
--

CREATE TABLE `question_group` (
  `id` int(11) NOT NULL,
  `name` longtext NOT NULL,
  `branch_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `question_group`
--

INSERT INTO `question_group` (`id`, `name`, `branch_id`) VALUES
(1, 'General', 1),
(2, 'Maths', 1),
(3, 'English', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reset_password`
--

CREATE TABLE `reset_password` (
  `key` longtext NOT NULL,
  `username` varchar(100) NOT NULL,
  `login_credential_id` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `reset_password`
--

INSERT INTO `reset_password` (`key`, `username`, `login_credential_id`, `created_at`) VALUES
('7c612cdaad3a79d52f1931e28f5e71d5acdd0c3b06762fa752e164f4e73e87964e107f9d686f4c849e52321f57a9ab6fe9a50c75f38e02ab04c8e0cc2766a23f', 'admin.malali@kdsg.gov.ng', '6', '2026-04-14 10:55:59'),
('ca09fdd26e715809d3367c7cbef5935bb6f83e54ce7a4d0cbb03c4cb8fa6373606c721332a9cdf69851747dd5cdcfd008f561c8d14e5e63632a47e278856202d', 'admin@gmail.com', '1', '2026-05-07 11:17:15');

-- --------------------------------------------------------

--
-- Table structure for table `rm_sessions`
--

CREATE TABLE `rm_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `rm_sessions`
--

INSERT INTO `rm_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('01cpmeae78h8269qi7ouce3neesgtsou', '::1', 1778168800, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383136383830303b72656469726563745f75726c7c733a33363a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f70726f66696c65223b),
('0bm3t21ovb2f61cfk8m4pjnaa0i3sukf', '::1', 1778177137, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383137373133373b72656469726563745f75726c7c733a34323a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f656d706c6f7965652f76696577223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('10vsf82bu6n9lt60hge9cmju727a4t26', '::1', 1778175913, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383137353931333b72656469726563745f75726c7c733a34323a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f656d706c6f7965652f76696577223b616c6572742d6d6573736167652d6572726f727c733a33333a22557365726e616d65204f722050617373776f726420497320496e636f7272656374223b5f5f63695f766172737c613a313a7b733a31393a22616c6572742d6d6573736167652d6572726f72223b733a333a226f6c64223b7d),
('1ivth19hq7on62g9idnhpojnc554korc', '::1', 1778160717, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383136303731373b72656469726563745f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f64617368626f617264223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('251qo93lt8a02r8iv3db2faceemcn3rt', '::1', 1778222284, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383232323238343b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('2bk3a8u12g80l5madpuj3fa5onhrqfa6', '::1', 1778163277, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383136333237373b),
('3novkkbkv8ep264gtj69u6s73bq276ci', '::1', 1778236050, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383233353835313b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('4mrp32f1ej6clpbhmbughm667h02nfi0', '::1', 1778227729, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383232373732393b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('50cgmv8ts4k60if4b1f82ucvq6f71div', '::1', 1778163985, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383136333938353b),
('56kl1jomgb9kumqm4kr2fteae0d6vlfq', '::1', 1778178826, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383137383832363b72656469726563745f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f64617368626f617264223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('5huu46q88srovv90st5vav8anpfdh8bd', '::1', 1778234394, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383233343339343b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('5ns1kdrn80ognvu66e2bj3fr256sccp6', '::1', 1778177859, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383137373835393b72656469726563745f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f64617368626f617264223b),
('5p0risb4lqq4lv6k5nbm0vli8lm2bkih', '::1', 1778233142, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383233333134323b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('6s627drvkaogjrul0g66ddmv9knbjqoe', '::1', 1778174851, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383137343835313b72656469726563745f75726c7c733a34323a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f656d706c6f7965652f76696577223b616c6572742d6d6573736167652d6572726f727c733a31373a22546f6b656e204861732045787069726564223b5f5f63695f766172737c613a313a7b733a31393a22616c6572742d6d6573736167652d6572726f72223b733a333a226f6c64223b7d),
('713jrrjju62061lgi2gg45pcfq8anig6', '::1', 1778165137, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383136353133373b),
('74sm1i111a272bgprs3v6ra6oabmrbk0', '::1', 1778235209, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383233353230393b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('7bmk4f5fmjd2inv9jab2b4u4tl0cqioi', '::1', 1778176215, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383137363231353b72656469726563745f75726c7c733a34323a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f656d706c6f7965652f76696577223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('831lc5i8qvjod99eofp1vpqr0klc8ebh', '::1', 1778235851, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383233353835313b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('8431sd07191b7qgbcfulv9ta5m0nuvu4', '::1', 1778229256, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383232393235363b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('8dsl845a52jeli9qg227jesqr04q0b63', '::1', 1778166172, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383136363137323b),
('8pc4dmo4n08060rdd4gm0ok1hp64ch1b', '::1', 1778166499, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383136363439393b),
('ab51bbh51hnudd7eti9b5uml4m5na0se', '::1', 1778169248, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383136393234383b72656469726563745f75726c7c733a34323a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f656d706c6f7965652f76696577223b),
('ai1reocjts5cl3fg4i9vmuufjsj7tdti', '::1', 1778162420, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383136323432303b6e616d657c733a31353a224d6164696e61204d7568616d6d6164223b6c6f676765725f70686f746f7c733a31313a2264656675616c742e706e67223b6c6f67676564696e5f6272616e63687c733a323a223130223b6c6f67676564696e5f656d61696c7c733a31363a226d6164696e6140676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2232223b6c6f67676564696e5f7573657269647c733a313a2232223b6c6f67676564696e5f726f6c655f69647c733a313a2233223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b6c6173745f706167657c733a33353a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f6272616e6368223b),
('b4ge08vms8eh2s6n88ccqt1fv33ult92', '::1', 1778220588, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383232303538383b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('ba2fo7677djb83mcnh9limg7k9gud87q', '::1', 1778228934, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383232383933343b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('blsolgccl2r7hjn7o52dlk6ur2671cbp', '::1', 1778189679, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383138393539343b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('bu9jfjlmgaavg02pujdf614hsvfna9ua', '::1', 1778166915, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383136363931353b),
('c30096kjb1395pmnik93smk8l7aqub0e', '::1', 1778180859, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383138303835393b),
('chd5t1bfmgolm9sgdtohlu0q445btk4t', '::1', 1778159206, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383135393230363b72656469726563745f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f64617368626f617264223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('ck4aqivf9uiehclkpeuvqcnghba6ufrp', '::1', 1778174092, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383137343039323b72656469726563745f75726c7c733a34323a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f656d706c6f7965652f76696577223b),
('d298udokbrmci7pclb23p1t900d3cvgi', '::1', 1778165565, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383136353536353b),
('ed6r9bpk334p1id0u5igv2kd2eobv79k', '::1', 1778224796, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383232343739363b),
('eokhb2cm9lem63gis9ucjp3rdt9ejnj8', '::1', 1778168389, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383136383338393b),
('f7r1cgrvvgcdh9lc2mvb8u5tcrss89sk', '::1', 1778161724, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383136313732343b72656469726563745f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f64617368626f617264223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('fnq1tgqd373i47oteje1lpbl51qfrsq5', '::1', 1778224389, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383232343338393b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('g0iuuj8cq05it9oaamclhj11ckn28eeo', '::1', 1778223093, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383232333039333b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('g2dikvuichsl42b85n234h3s9kqn9giv', '::1', 1778220272, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383232303237323b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('g6gja5qhlss3vdrp7cuntdi7ace22bj7', '::1', 1778162076, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383136323037363b6e616d657c733a31353a224d6164696e61204d7568616d6d6164223b6c6f676765725f70686f746f7c733a31313a2264656675616c742e706e67223b6c6f67676564696e5f6272616e63687c733a323a223130223b6c6f67676564696e5f656d61696c7c733a31363a226d6164696e6140676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2232223b6c6f67676564696e5f7573657269647c733a313a2232223b6c6f67676564696e5f726f6c655f69647c733a313a2233223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('gl1nfmlntiuljo927fshdiipc8sjhpmc', '::1', 1778233956, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383233333935363b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('go3s9vpkb1afeq2vpfb4b6aatu4ghlvq', '::1', 1778225425, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383232353432353b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('h5etl9f3e8ca2is3bdrjotn1kqqo3qfh', '::1', 1778238262, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383233383236323b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('i47n2jvqcutta9brrr9r84ba3stjpffl', '::1', 1778221529, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383232313532393b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('i4obkpktloc7ouqebjljietjqec6lr56', '::1', 1778164823, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383136343832333b),
('isnt82gnts4djo48ai777qsbe4pu470t', '::1', 1778225714, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383232353731343b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('ivn46ika7587fkhnds5pmvm8iqsaj5b5', '::1', 1778229678, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383232393637383b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('jn3g7qmg7kl88o8apdp1ioprnjeo6qom', '::1', 1778180154, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383138303135343b72656469726563745f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f64617368626f617264223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('jnkt3de1n6kof07knufg3df7q987ne4i', '::1', 1778182174, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383138323131363b72656469726563745f75726c7c733a34343a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f666565732f616c6c6f636174696f6e223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('jsf5sg0cbue79hb26qlbln912lch87hc', '::1', 1778173612, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383137333631323b72656469726563745f75726c7c733a34323a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f656d706c6f7965652f76696577223b),
('kdbqf90tgsrhvje4pkorb66p7cn0c9ia', '::1', 1778231051, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383233313035313b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('knt47nq2cmsjr7dfqaq73thvhg2gep38', '::1', 1778165867, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383136353836373b),
('l7c9g96a0meafkjjr5h1lsrot5ql4hkg', '::1', 1778156988, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383135363938383b72656469726563745f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f64617368626f617264223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('m4qafn4pdbimn1fn0e1s0nf1f7bfkbo0', '::1', 1778226532, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383232363533323b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('majvkeqa40jt008c5u06aecesfucpuhe', '::1', 1778241680, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383234313631383b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('mb3ces7rscnvomnr4nbfhotoafkqc1kt', '::1', 1778227412, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383232373431323b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('mj5534fpfvrul1116aijff5n4kr5iaoe', '::1', 1778179243, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383137393234333b72656469726563745f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f64617368626f617264223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('mm28ufgebucinitrgs2hel7bjdvapmee', '::1', 1778228593, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383232383539333b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('n44gojlganqb6rg1lropdd58pd5ub19u', '::1', 1778233463, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383233333436333b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('nhf07csb764gecophj7mbq0hhv8s775n', '::1', 1778182116, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383138323131363b72656469726563745f75726c7c733a34343a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f666565732f616c6c6f636174696f6e223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('nodhkflq56gggbrve2ok9jg8813jqfpk', '::1', 1778232071, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383233323037313b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('od15tkf6lqobkre67irtr4mvd0cjcrvm', '::1', 1778224974, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383232343936363b),
('p0emnjlerhqhbb0upnmo5ub13fi20tc2', '::1', 1778224718, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383232343731383b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('peg8nn24sngejjlojf548dr5ggmgbfae', '::1', 1778157359, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383135373335393b72656469726563745f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f64617368626f617264223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('peua0ma8cjkfruoei5ankl60du6n5sqm', '::1', 1778221975, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383232313937353b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('pjfdg9g2kp39reun15tjikg1eo9kf9sd', '::1', 1778175478, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383137353437383b72656469726563745f75726c7c733a34323a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f656d706c6f7965652f76696577223b),
('plrrieh4kfa31sa37sgid9fgfqa5rkre', '::1', 1778222671, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383232323637313b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('pq3g9u9q7rmfof79e9lblt4202pjkjuo', '::1', 1778176589, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383137363538393b72656469726563745f75726c7c733a34323a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f656d706c6f7965652f76696577223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('puibr94kvi72p1936abo41lpl8b7o1o9', '::1', 1778162836, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383136323833363b6e616d657c733a31353a224d6164696e61204d7568616d6d6164223b6c6f676765725f70686f746f7c733a31313a2264656675616c742e706e67223b6c6f67676564696e5f6272616e63687c733a323a223130223b6c6f67676564696e5f656d61696c7c733a31363a226d6164696e6140676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2232223b6c6f67676564696e5f7573657269647c733a313a2232223b6c6f67676564696e5f726f6c655f69647c733a313a2233223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b6c6173745f706167657c733a33353a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f6272616e6368223b),
('q1p002ebot3rabof092omio68uv4laie', '::1', 1778223541, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383232333534313b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('qet6683qku7fpkkmqili1ae4jkl4unki', '::1', 1778161087, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383136313038373b72656469726563745f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f64617368626f617264223b),
('qiaivqe04b4aqbfkrsrtho305cdn9412', '::1', 1778223966, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383232333936363b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('qp4nv00gkp0sfbek1jeouam5e1urtmhe', '::1', 1778228072, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383232383037323b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('qrk9imfhp4e1krili48j47s6om5jr0ov', '::1', 1778179720, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383137393732303b72656469726563745f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f64617368626f617264223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('qvd5geiprgbd5pfr633qq7ojvmecnp9a', '::1', 1778156529, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383135363532393b72656469726563745f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f64617368626f617264223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('rivnjj9ugrg8iric6cq6befvs0q80cpi', '::1', 1778177546, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383137373534363b),
('rmt3cr4v97ib4qoupje58b275hn7o71n', '::1', 1778225174, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383232353136383b),
('rogfjttqj7ce10dcvkmvnefu0k2mivtt', '::1', 1778232288, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383233323238383b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('snnvj2uj2otukmk4mok97l4lpfl7d2ua', '::1', 1778241618, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383234313631383b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('sttiabq8k8lqvjr3edh4r285mrp9iscc', '::1', 1778231742, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383233313734323b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('t1vig65qd3hidkjnlfnmmgarjc6uhnf1', '::1', 1778218571, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383231383537313b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('t5t53nopk0abloggbdotov615jbplnmu', '::1', 1778227059, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383232373035393b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('t9h07259vb4va7562fj1s090bm1uopnb', '::1', 1778178177, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383137383137373b72656469726563745f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f64617368626f617264223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('td65lh1jsugnkqpudrqmhukn6hdisu5c', '::1', 1778226879, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383232363837393b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('u9se9k22avd9celo89rs3mkcfgmirk2o', '::1', 1778231375, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383233313337353b72656469726563745f75726c7c733a34333a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f696e667261737472756374757265223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b),
('ummrt6jnrof6eg8ld72ibufdcm9m6ajj', '::1', 1778163580, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383136333538303b),
('v0tdgk3qdd79i1e8opshdsbb4pue6rcs', '::1', 1778174400, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383137343430303b72656469726563745f75726c7c733a34323a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f656d706c6f7965652f76696577223b),
('v99sbn5s925fv6r4nrr4igkm1i5752qa', '::1', 1778156165, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383135363136353b72656469726563745f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f536d6172745363686f6f6c2f64617368626f617264223b6e616d657c733a353a2261646d696e223b6c6f676765725f70686f746f7c4e3b6c6f67676564696e5f6272616e63687c4e3b6c6f67676564696e5f656d61696c7c733a31353a2261646d696e40676d61696c2e636f6d223b6c6f67676564696e5f69647c733a313a2231223b6c6f67676564696e5f7573657269647c733a313a2231223b6c6f67676564696e5f726f6c655f69647c733a313a2231223b6c6f67676564696e5f747970657c733a353a227374616666223b7365745f6c616e677c733a373a22656e676c697368223b69735f72746c7c623a303b7365745f73657373696f6e5f69647c733a313a2233223b6c6f67676564696e7c623a313b);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `is_system` varchar(10) NOT NULL,
  `is_statewide` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `prefix`, `is_system`, `is_statewide`) VALUES
(1, 'Super Admin', 'superadmin', '1', 0),
(2, 'Admin', 'admin', '1', 0),
(3, 'Teacher', 'teacher', '1', 0),
(4, 'Accountant', 'accountant', '1', 0),
(5, 'Librarian', 'librarian', '1', 0),
(6, 'Parent', 'parent', '1', 0),
(7, 'Student', 'student', '1', 0),
(8, 'Receptionist', 'receptionist', '1', 0),
(9, 'Commissioner of Education', 'commissioner', '1', 1),
(10, 'Permanent Secretary', 'perm_sec', '1', 1),
(11, 'SUBEB Director', 'subeb_director', '1', 1),
(12, 'Zonal Education Officer', 'zonal_officer', '1', 1),
(13, 'LGA Education Secretary', 'lga_sec', '1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `salary_template`
--

CREATE TABLE `salary_template` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `basic_salary` decimal(18,2) NOT NULL,
  `overtime_salary` varchar(100) NOT NULL DEFAULT '0',
  `branch_id` tinyint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `salary_template`
--

INSERT INTO `salary_template` (`id`, `name`, `basic_salary`, `overtime_salary`, `branch_id`) VALUES
(1, 'Grade 5', 120000.00, '0', 1);

-- --------------------------------------------------------

--
-- Table structure for table `salary_template_details`
--

CREATE TABLE `salary_template_details` (
  `id` int(11) NOT NULL,
  `salary_template_id` varchar(20) NOT NULL,
  `name` varchar(200) NOT NULL,
  `amount` decimal(18,2) NOT NULL DEFAULT 0.00,
  `type` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `salary_template_details`
--

INSERT INTO `salary_template_details` (`id`, `salary_template_id`, `name`, `amount`, `type`) VALUES
(1, '1', 'House Rent', 20000.00, 1),
(2, '1', 'Transport Allowance', 24000.00, 1),
(3, '1', 'Medical Allowance', 50000.00, 1),
(4, '1', 'Provident Fund', 15000.00, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sales_bill`
--

CREATE TABLE `sales_bill` (
  `id` int(11) NOT NULL,
  `bill_no` varchar(200) NOT NULL,
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `remarks` text NOT NULL,
  `total` decimal(18,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(18,2) NOT NULL DEFAULT 0.00,
  `paid` decimal(18,2) NOT NULL DEFAULT 0.00,
  `due` decimal(18,2) NOT NULL DEFAULT 0.00,
  `payment_status` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `prepared_by` int(11) DEFAULT NULL,
  `modifier_id` int(11) DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_bill_details`
--

CREATE TABLE `sales_bill_details` (
  `id` int(11) NOT NULL,
  `sales_bill_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `unit_price` decimal(18,2) NOT NULL DEFAULT 0.00,
  `quantity` varchar(20) NOT NULL,
  `discount` decimal(18,2) NOT NULL DEFAULT 0.00,
  `sub_total` decimal(18,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_payment_history`
--

CREATE TABLE `sales_payment_history` (
  `id` int(11) NOT NULL,
  `sales_bill_id` varchar(11) NOT NULL,
  `payment_by` int(11) DEFAULT NULL,
  `amount` decimal(18,2) NOT NULL DEFAULT 0.00,
  `pay_via` varchar(25) NOT NULL,
  `remarks` text NOT NULL,
  `attach_orig_name` varchar(255) DEFAULT NULL,
  `attach_file_name` varchar(255) DEFAULT NULL,
  `paid_on` date DEFAULT NULL,
  `coll_type` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schoolyear`
--

CREATE TABLE `schoolyear` (
  `id` int(11) NOT NULL,
  `school_year` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `schoolyear`
--

INSERT INTO `schoolyear` (`id`, `school_year`, `created_by`, `created_at`, `updated_at`) VALUES
(3, '2026-2027', 1, '2026-02-14 19:35:41', '2026-02-20 01:35:41'),
(4, '2027-2028', 1, '2026-02-14 19:35:41', '2026-02-20 01:35:41'),
(5, '2028-2029', 1, '2026-02-14 19:35:41', '2026-02-20 01:20:04'),
(6, '2029-2030', 1, '2026-02-14 07:00:10', '2026-02-20 13:00:24'),
(7, '2030-2031', 1, '2026-02-14 07:00:10', '2026-02-20 13:00:24'),
(8, '2031-2032', 1, '2026-02-14 07:00:10', '2026-02-20 13:00:24');

-- --------------------------------------------------------

--
-- Table structure for table `school_inspections`
--

CREATE TABLE `school_inspections` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `inspector_id` int(11) NOT NULL,
  `inspection_date` date NOT NULL,
  `infrastructure_score` tinyint(4) NOT NULL DEFAULT 0,
  `teaching_quality_score` tinyint(4) NOT NULL DEFAULT 0,
  `compliance_score` tinyint(4) NOT NULL DEFAULT 0,
  `total_score` tinyint(4) NOT NULL DEFAULT 0,
  `overall_grade` enum('Excellent','Good','Fair','Poor') NOT NULL DEFAULT 'Good',
  `status` enum('Pending','In Progress','Completed') DEFAULT 'Pending',
  `recommendations` text DEFAULT NULL,
  `next_inspection_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `school_inspections`
--

INSERT INTO `school_inspections` (`id`, `branch_id`, `inspector_id`, `inspection_date`, `infrastructure_score`, `teaching_quality_score`, `compliance_score`, `total_score`, `overall_grade`, `status`, `recommendations`, `next_inspection_date`, `created_at`) VALUES
(1, 10, 1, '2026-04-16', 30, 65, 58, 51, 'Fair', 'Completed', 'long text', '2026-05-18', '2026-04-15 11:07:35'),
(2, 10, 5, '2026-04-20', 0, 0, 0, 0, 'Poor', 'In Progress', '', '0000-00-00', '2026-04-15 12:17:06');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `capacity` varchar(20) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `board_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`id`, `name`, `capacity`, `branch_id`, `board_id`) VALUES
(1, 'A', '300', 1, NULL),
(2, 'B', '300', 1, NULL),
(3, 'C', '300', 1, NULL),
(4, 'D', '300', 1, NULL),
(5, 'Sci 1', '200', 1, NULL),
(6, 'Sci 2', '200', 1, NULL),
(7, 'Art 1', '300', 1, NULL),
(8, 'Art 2', '300', 1, NULL),
(9, 'Com 1', '300', 1, NULL),
(10, 'Com 2', '300', 1, NULL),
(11, 'A', NULL, 0, 1),
(12, 'B', NULL, 0, 1),
(13, 'C', NULL, 0, 1),
(14, 'D', NULL, 0, 1),
(23, 'Science 1', NULL, 0, 2),
(24, 'Science 2', NULL, 0, 2),
(25, 'Art 1', NULL, 0, 2),
(26, 'Art 2', NULL, 0, 2),
(27, 'Commercial 1', NULL, 0, 2),
(28, 'Commercial 2', NULL, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sections_allocation`
--

CREATE TABLE `sections_allocation` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `sections_allocation`
--

INSERT INTO `sections_allocation` (`id`, `class_id`, `section_id`) VALUES
(23, 14, 11),
(24, 14, 12),
(25, 14, 13),
(26, 14, 14),
(27, 15, 11),
(28, 15, 12),
(29, 15, 13),
(30, 15, 14),
(31, 16, 11),
(32, 16, 12),
(33, 16, 13),
(34, 16, 14),
(35, 17, 11),
(36, 17, 12),
(37, 17, 13),
(38, 17, 14),
(39, 18, 11),
(40, 18, 12),
(41, 18, 13),
(42, 18, 14),
(43, 19, 11),
(44, 19, 12),
(45, 19, 13),
(46, 19, 14),
(51, 21, 11),
(52, 21, 12),
(53, 21, 13),
(54, 21, 14),
(55, 22, 11),
(56, 22, 12),
(57, 22, 13),
(58, 22, 14),
(59, 41, 23),
(60, 41, 24),
(61, 41, 25),
(62, 41, 26),
(63, 41, 27),
(64, 41, 28),
(65, 42, 23),
(66, 42, 24),
(67, 42, 25),
(68, 42, 26),
(69, 42, 27),
(70, 42, 28),
(71, 43, 23),
(72, 43, 24),
(73, 43, 25),
(74, 43, 26),
(75, 43, 27),
(76, 43, 28),
(77, 4, 11),
(78, 4, 12),
(79, 4, 13),
(80, 4, 14);

-- --------------------------------------------------------

--
-- Table structure for table `sms_api`
--

CREATE TABLE `sms_api` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `sms_api`
--

INSERT INTO `sms_api` (`id`, `name`) VALUES
(1, 'twilio'),
(2, 'clickatell'),
(3, 'msg91'),
(4, 'bulksms'),
(5, 'textlocal'),
(6, 'smscountry'),
(7, 'bulksmsbd'),
(8, 'customsms');

-- --------------------------------------------------------

--
-- Table structure for table `sms_credential`
--

CREATE TABLE `sms_credential` (
  `id` int(11) NOT NULL,
  `sms_api_id` int(11) NOT NULL,
  `field_one` varchar(300) NOT NULL,
  `field_two` varchar(300) NOT NULL,
  `field_three` varchar(300) NOT NULL,
  `field_four` varchar(300) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sms_template`
--

CREATE TABLE `sms_template` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `tags` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `sms_template`
--

INSERT INTO `sms_template` (`id`, `name`, `tags`) VALUES
(1, 'admission', '{name}, {class}, {section}, {admission_date}, {roll}, {register_no}'),
(2, 'fee_collection', '{name}, {class}, {section}, {admission_date}, {roll}, {register_no}, {paid_amount}, {paid_date} '),
(3, 'attendance', '{name}, {class}, {section}, {admission_date}, {roll}, {register_no}'),
(4, 'exam_attendance', '{name}, {class}, {section}, {admission_date}, {roll}, {register_no}, {exam_name}, {term_name}, {subject}'),
(5, 'exam_results', '{name}, {class}, {section}, {admission_date}, {roll}, {register_no}, {exam_name}, {term_name}, {subject}, {marks}'),
(6, 'homework', '{name}, {class}, {section}, {admission_date}, {roll}, {register_no}, {subject}, {date_of_homework}, {date_of_submission}'),
(7, 'live_class', '{name}, {class}, {section}, {admission_date}, {roll}, {register_no}, {date_of_live_class}, {start_time}, {end_time}, {host_by}'),
(8, 'online_exam_publish', '{name}, {class}, {section}, {admission_date}, {roll}, {register_no}, {exam_title}, {start_time}, {end_time}, {time_duration}, {attempt}, {passing_mark}, {exam_fee}'),
(9, 'student_birthday_wishes', '{name}, {class}, {section}, {admission_date}, {roll}, {register_no}, {birthday}'),
(10, 'staff_birthday_wishes', '{name}, {birthday}, {joining_date}'),
(11, 'alumni_event', '{student_name}, {event_title}, {start_date}, {end_date}');

-- --------------------------------------------------------

--
-- Table structure for table `sms_template_details`
--

CREATE TABLE `sms_template_details` (
  `id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `dlt_template_id` varchar(255) DEFAULT NULL,
  `notify_student` tinyint(3) NOT NULL DEFAULT 1,
  `notify_parent` tinyint(3) NOT NULL DEFAULT 1,
  `template_body` longtext NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `staff_id` varchar(25) NOT NULL,
  `name` varchar(255) NOT NULL,
  `department` int(11) NOT NULL,
  `qualification` varchar(255) NOT NULL,
  `experience_details` varchar(255) DEFAULT NULL,
  `total_experience` varchar(255) DEFAULT NULL,
  `designation` int(11) NOT NULL,
  `joining_date` varchar(100) NOT NULL,
  `birthday` varchar(100) NOT NULL,
  `sex` varchar(20) NOT NULL,
  `religion` varchar(100) NOT NULL,
  `blood_group` varchar(20) NOT NULL,
  `present_address` text NOT NULL,
  `permanent_address` text NOT NULL,
  `mobileno` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `salary_template_id` int(11) DEFAULT 0,
  `branch_id` int(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `facebook_url` varchar(255) DEFAULT NULL,
  `linkedin_url` varchar(255) DEFAULT NULL,
  `twitter_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `staff_id`, `name`, `department`, `qualification`, `experience_details`, `total_experience`, `designation`, `joining_date`, `birthday`, `sex`, `religion`, `blood_group`, `present_address`, `permanent_address`, `mobileno`, `email`, `salary_template_id`, `branch_id`, `photo`, `facebook_url`, `linkedin_url`, `twitter_url`, `created_at`, `updated_at`) VALUES
(1, 'd360115', 'admin', 0, '', NULL, NULL, 0, '2026-02-24', '', '', '', '', '', '', '', 'admin@gmail.com', 0, NULL, NULL, NULL, NULL, NULL, '2026-02-24 13:31:42', NULL),
(2, 'a8b38f2', 'Madina Muhammad', 1, 'BEd', '', '', 2, '2026-03-30', '2000-10-01', 'female', 'Islam', 'B+', 'Unguwan Sunusi', '', '09022334455', 'madina@gmail.com', 0, 10, 'defualt.png', '', '', '', '2026-03-27 07:08:28', NULL),
(3, '5934d5e', 'Jamilu Salisu', 7, 'MSc', '', '', 6, '2026-04-14', '', 'male', 'Islam', 'B+', 'Kaduna', '', '08022334455', 'jamilusalis@gmail.com', 0, 1, 'defualt.png', '', '', '', '2026-04-14 07:47:56', NULL),
(4, 'ADM-004', 'Admin LEA Malali', 8, 'B.Ed', NULL, NULL, 7, '2026-01-01', '1980-01-01', 'Male', 'Islam', 'O+', 'Malali, Kaduna', 'Malali, Kaduna', '08011111101', 'admin.malali@kdsg.gov.ng', 0, 4, NULL, NULL, NULL, NULL, '2026-04-14 10:51:01', NULL),
(5, 'ADM-005', 'Admin LEA Tudun Wada', 8, 'B.Ed', NULL, NULL, 7, '2026-01-01', '1980-01-01', 'Male', 'Islam', 'O+', 'Tudun Wada, Kaduna', 'Tudun Wada, Kaduna', '08011111102', 'admin.tudunwada@kdsg.gov.ng', 0, 5, NULL, NULL, NULL, NULL, '2026-04-14 10:51:01', NULL),
(6, 'ADM-006', 'Admin JSS Kawo', 8, 'B.Ed', NULL, NULL, 7, '2026-01-01', '1980-01-01', 'Female', 'Christianity', 'A+', 'Kawo, Kaduna', 'Kawo, Kaduna', '08011111103', 'admin.jsskawo@kdsg.gov.ng', 0, 6, NULL, NULL, NULL, NULL, '2026-04-14 10:51:01', NULL),
(7, 'ADM-007', 'Admin LEA Rigasa', 8, 'B.Ed', NULL, NULL, 7, '2026-01-01', '1980-01-01', 'Male', 'Islam', 'B+', 'Rigasa, Kaduna', 'Rigasa, Kaduna', '08011111104', 'admin.rigasa@kdsg.gov.ng', 0, 7, NULL, NULL, NULL, NULL, '2026-04-14 10:51:01', NULL),
(8, 'ADM-008', 'Admin JSS Sabon Tasha', 8, 'B.Ed', NULL, NULL, 7, '2026-01-01', '1980-01-01', 'Female', 'Christianity', 'O+', 'Sabon Tasha, Kaduna', 'Sabon Tasha, Kaduna', '08011111105', 'admin.sabontasha@kdsg.gov.ng', 0, 8, NULL, NULL, NULL, NULL, '2026-04-14 10:51:01', NULL),
(9, 'ADM-009', 'Admin GSS Tudun Wada', 8, 'B.Ed', NULL, NULL, 7, '2026-01-01', '1980-01-01', 'Male', 'Islam', 'A+', 'Tudun Wada, Kaduna', 'Tudun Wada, Kaduna', '08022222201', 'admin.gsstw@kdsg.gov.ng', 0, 9, NULL, NULL, NULL, NULL, '2026-04-14 10:51:01', NULL),
(10, 'ADM-010', 'Admin GGSS Kawo', 8, 'B.Ed', NULL, NULL, 7, '2026-01-01', '1985-06-15', 'Female', 'Christianity', 'B+', 'Kawo, Kaduna', 'Kawo, Kaduna', '08022222202', 'admin.ggsskawo@kdsg.gov.ng', 0, 10, NULL, NULL, NULL, NULL, '2026-04-14 10:51:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staff_attendance`
--

CREATE TABLE `staff_attendance` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `status` varchar(11) DEFAULT NULL COMMENT 'P=Present, A=Absent, H=Holiday, L=Late',
  `remark` varchar(255) NOT NULL,
  `date` date DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `staff_attendance`
--

INSERT INTO `staff_attendance` (`id`, `staff_id`, `status`, `remark`, `date`, `branch_id`) VALUES
(1, 2, 'P', '', '2026-03-24', 1),
(2, 2, 'P', '', '2026-03-27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `staff_bank_account`
--

CREATE TABLE `staff_bank_account` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `bank_name` varchar(200) NOT NULL,
  `holder_name` varchar(255) NOT NULL,
  `bank_branch` varchar(255) NOT NULL,
  `bank_address` varchar(255) NOT NULL,
  `ifsc_code` varchar(200) NOT NULL,
  `account_no` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `staff_bank_account`
--

INSERT INTO `staff_bank_account` (`id`, `staff_id`, `bank_name`, `holder_name`, `bank_branch`, `bank_address`, `ifsc_code`, `account_no`, `created_at`, `updated_at`) VALUES
(1, 2, 'GT Bank', 'Madina Muhammad', 'Kaduna', '', '', '0123456789', '2026-03-27 07:08:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staff_department`
--

CREATE TABLE `staff_department` (
  `id` int(11) NOT NULL,
  `name` longtext NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `board_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `staff_department`
--

INSERT INTO `staff_department` (`id`, `name`, `branch_id`, `created_at`, `updated_at`, `board_id`) VALUES
(1, 'Science', 1, '2026-03-27 06:59:21', NULL, NULL),
(2, 'Commerce', 1, '2026-03-27 06:59:27', NULL, NULL),
(3, 'General', 1, '2026-03-27 06:59:33', NULL, NULL),
(4, 'Arts', 1, '2026-03-27 06:59:40', NULL, NULL),
(5, 'Libraries', 1, '2026-03-27 06:59:49', NULL, NULL),
(6, 'Finance', 1, '2026-03-27 06:59:55', NULL, NULL),
(7, 'Academic', 1, '2026-03-27 07:00:00', NULL, NULL),
(8, 'Teaching Staff', 0, '2026-04-14 08:36:50', NULL, 1),
(9, 'Administrative Staff', 0, '2026-04-14 08:36:50', NULL, 1),
(10, 'Support Staff', 0, '2026-04-14 08:36:50', NULL, 1),
(11, 'Guidance & Counselling', 0, '2026-04-14 08:36:50', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `staff_designation`
--

CREATE TABLE `staff_designation` (
  `id` int(11) NOT NULL,
  `name` longtext NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `board_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `staff_designation`
--

INSERT INTO `staff_designation` (`id`, `name`, `branch_id`, `created_at`, `updated_at`, `board_id`) VALUES
(1, 'Principal', 1, '2026-03-27 07:00:56', NULL, NULL),
(2, 'Teacher', 1, '2026-03-27 07:01:05', NULL, NULL),
(3, 'Asst. Teacher', 1, '2026-03-27 07:01:13', NULL, NULL),
(4, 'Librarian', 1, '2026-03-27 07:01:20', NULL, NULL),
(5, 'Accountant', 1, '2026-03-27 07:01:29', NULL, NULL),
(6, 'Director', 1, '2026-03-27 07:01:35', NULL, NULL),
(7, 'Head Teacher', 0, '2026-04-14 08:36:50', NULL, 1),
(8, 'Assistant Head Teacher', 0, '2026-04-14 08:36:50', NULL, 1),
(9, 'Class Teacher', 0, '2026-04-14 08:36:50', NULL, 1),
(10, 'Subject Teacher', 0, '2026-04-14 08:36:50', NULL, 1),
(11, 'Clerk', 0, '2026-04-14 08:36:50', NULL, 1),
(12, 'Gateman', 0, '2026-04-14 08:36:50', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `staff_documents`
--

CREATE TABLE `staff_documents` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category_id` varchar(20) NOT NULL,
  `remarks` text NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `enc_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff_posting_history`
--

CREATE TABLE `staff_posting_history` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `posted_by` int(11) DEFAULT NULL,
  `date_posted` date NOT NULL,
  `date_left` date DEFAULT NULL,
  `reason` varchar(255) DEFAULT 'Initial Posting'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `staff_posting_history`
--

INSERT INTO `staff_posting_history` (`id`, `staff_id`, `branch_id`, `posted_by`, `date_posted`, `date_left`, `reason`) VALUES
(1, 2, 10, 1, '2026-04-16', NULL, 'Transfer Approval');

-- --------------------------------------------------------

--
-- Table structure for table `staff_privileges`
--

CREATE TABLE `staff_privileges` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `is_add` tinyint(1) NOT NULL,
  `is_edit` tinyint(1) NOT NULL,
  `is_view` tinyint(1) NOT NULL,
  `is_delete` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `staff_privileges`
--

INSERT INTO `staff_privileges` (`id`, `role_id`, `permission_id`, `is_add`, `is_edit`, `is_view`, `is_delete`) VALUES
(1, 3, 1, 1, 1, 1, 1),
(2, 3, 2, 0, 0, 0, 0),
(3, 3, 3, 1, 1, 1, 1),
(4, 3, 4, 0, 0, 0, 0),
(5, 3, 5, 0, 0, 0, 0),
(6, 3, 30, 0, 0, 0, 0),
(7, 3, 7, 0, 0, 0, 0),
(8, 3, 8, 0, 0, 0, 0),
(9, 3, 6, 0, 0, 1, 0),
(10, 3, 9, 0, 0, 0, 0),
(11, 3, 10, 0, 0, 0, 0),
(12, 3, 11, 0, 0, 0, 0),
(13, 3, 12, 0, 0, 0, 0),
(14, 3, 13, 0, 0, 0, 0),
(15, 3, 14, 0, 0, 1, 0),
(16, 3, 15, 0, 0, 1, 0),
(17, 3, 16, 0, 0, 0, 0),
(18, 3, 17, 0, 0, 0, 0),
(20, 3, 19, 0, 0, 0, 0),
(21, 3, 20, 1, 1, 1, 1),
(22, 3, 21, 0, 0, 0, 0),
(23, 3, 22, 0, 0, 1, 0),
(24, 3, 23, 0, 0, 1, 0),
(25, 3, 24, 0, 0, 1, 0),
(26, 3, 25, 0, 0, 1, 0),
(27, 3, 26, 0, 0, 1, 0),
(28, 3, 27, 0, 0, 1, 0),
(29, 3, 28, 0, 0, 1, 0),
(30, 3, 29, 0, 0, 1, 0),
(31, 3, 32, 1, 1, 1, 1),
(32, 3, 31, 1, 1, 1, 1),
(33, 3, 33, 1, 1, 1, 1),
(34, 3, 34, 1, 1, 1, 1),
(35, 3, 35, 1, 1, 1, 1),
(36, 3, 36, 1, 1, 1, 1),
(37, 3, 37, 0, 0, 0, 0),
(38, 3, 38, 1, 1, 1, 1),
(39, 3, 39, 1, 1, 1, 1),
(40, 3, 77, 1, 1, 1, 1),
(41, 3, 78, 0, 0, 1, 0),
(42, 3, 79, 0, 0, 0, 0),
(43, 3, 40, 0, 0, 0, 0),
(44, 3, 41, 0, 0, 0, 0),
(45, 3, 42, 0, 0, 0, 0),
(46, 3, 43, 0, 0, 0, 0),
(47, 3, 44, 0, 0, 0, 0),
(48, 3, 45, 0, 0, 0, 0),
(49, 3, 46, 0, 0, 0, 0),
(50, 3, 47, 0, 0, 0, 0),
(51, 3, 48, 0, 0, 0, 0),
(52, 3, 49, 1, 0, 0, 0),
(53, 3, 50, 0, 0, 0, 0),
(54, 3, 51, 0, 0, 0, 0),
(55, 3, 52, 0, 0, 0, 0),
(56, 3, 53, 0, 0, 0, 0),
(57, 3, 54, 0, 0, 0, 0),
(58, 3, 55, 0, 0, 1, 0),
(59, 3, 56, 0, 0, 0, 0),
(60, 3, 57, 0, 0, 0, 0),
(61, 3, 58, 1, 0, 1, 1),
(62, 3, 59, 0, 0, 1, 0),
(63, 3, 60, 0, 0, 0, 0),
(64, 3, 61, 0, 0, 0, 0),
(65, 3, 62, 0, 0, 0, 0),
(66, 3, 80, 0, 0, 0, 0),
(67, 3, 69, 0, 0, 0, 0),
(68, 3, 70, 0, 0, 0, 0),
(69, 3, 71, 0, 0, 0, 0),
(70, 3, 72, 0, 0, 0, 0),
(71, 3, 73, 0, 0, 0, 0),
(72, 3, 74, 0, 0, 0, 0),
(73, 3, 75, 0, 0, 0, 0),
(74, 3, 76, 0, 0, 0, 0),
(75, 3, 63, 0, 0, 0, 0),
(76, 3, 64, 0, 0, 0, 0),
(77, 3, 65, 0, 0, 0, 0),
(78, 3, 66, 0, 0, 0, 0),
(79, 3, 67, 0, 0, 0, 0),
(80, 3, 68, 0, 0, 0, 0),
(81, 3, 81, 0, 0, 0, 0),
(82, 3, 82, 0, 0, 0, 0),
(83, 3, 83, 0, 0, 0, 0),
(84, 3, 84, 0, 0, 0, 0),
(85, 3, 85, 0, 0, 0, 0),
(86, 3, 86, 0, 0, 0, 0),
(87, 3, 87, 0, 0, 0, 0),
(88, 2, 1, 1, 1, 1, 1),
(89, 2, 2, 1, 0, 0, 0),
(90, 2, 3, 1, 1, 1, 1),
(91, 2, 4, 0, 0, 1, 0),
(92, 2, 5, 1, 0, 1, 0),
(93, 2, 30, 1, 0, 1, 0),
(94, 2, 7, 1, 1, 1, 1),
(95, 2, 8, 1, 0, 1, 0),
(96, 2, 6, 1, 1, 1, 1),
(97, 2, 9, 1, 1, 1, 1),
(98, 2, 10, 1, 1, 1, 1),
(99, 2, 11, 1, 0, 1, 0),
(100, 2, 12, 1, 1, 1, 1),
(101, 2, 13, 1, 0, 1, 0),
(102, 2, 14, 1, 0, 1, 0),
(103, 2, 15, 0, 0, 1, 0),
(104, 2, 16, 1, 1, 1, 1),
(105, 2, 17, 1, 1, 1, 1),
(107, 2, 19, 1, 1, 1, 1),
(108, 2, 20, 1, 1, 1, 1),
(109, 2, 21, 1, 1, 1, 1),
(110, 2, 22, 1, 1, 1, 1),
(111, 2, 23, 1, 1, 1, 1),
(112, 2, 24, 1, 1, 1, 1),
(113, 2, 25, 1, 1, 1, 1),
(114, 2, 26, 1, 1, 1, 1),
(115, 2, 27, 1, 1, 1, 1),
(116, 2, 28, 1, 0, 1, 1),
(117, 2, 29, 1, 1, 1, 1),
(118, 2, 32, 1, 1, 1, 1),
(119, 2, 31, 1, 1, 1, 1),
(120, 2, 33, 1, 1, 1, 1),
(121, 2, 34, 1, 1, 1, 1),
(122, 2, 35, 1, 1, 1, 1),
(123, 2, 36, 1, 1, 1, 1),
(124, 2, 37, 1, 0, 1, 1),
(125, 2, 38, 1, 1, 1, 1),
(126, 2, 39, 1, 1, 1, 1),
(127, 2, 77, 1, 1, 1, 1),
(128, 2, 78, 0, 0, 1, 0),
(129, 2, 79, 0, 0, 1, 0),
(130, 2, 40, 1, 1, 1, 1),
(131, 2, 41, 1, 1, 1, 1),
(132, 2, 42, 1, 1, 1, 1),
(133, 2, 43, 0, 0, 1, 1),
(134, 2, 44, 1, 1, 1, 1),
(135, 2, 45, 1, 1, 1, 1),
(136, 2, 46, 1, 1, 1, 1),
(137, 2, 47, 1, 1, 1, 1),
(138, 2, 48, 0, 0, 1, 1),
(139, 2, 49, 1, 0, 0, 0),
(140, 2, 50, 1, 0, 0, 0),
(141, 2, 51, 1, 0, 0, 0),
(142, 2, 52, 0, 0, 1, 0),
(143, 2, 53, 0, 0, 1, 0),
(144, 2, 54, 0, 0, 1, 0),
(145, 2, 55, 1, 1, 1, 1),
(146, 2, 56, 1, 1, 1, 1),
(147, 2, 57, 1, 0, 1, 1),
(148, 2, 58, 1, 0, 1, 1),
(149, 2, 59, 1, 1, 1, 1),
(150, 2, 60, 1, 1, 1, 1),
(151, 2, 61, 1, 0, 1, 1),
(152, 2, 62, 1, 1, 1, 1),
(153, 2, 80, 0, 0, 1, 0),
(154, 2, 69, 1, 1, 1, 1),
(155, 2, 70, 1, 1, 1, 1),
(156, 2, 71, 1, 1, 1, 1),
(157, 2, 72, 1, 1, 1, 1),
(158, 2, 73, 1, 0, 0, 0),
(159, 2, 74, 1, 1, 1, 1),
(160, 2, 75, 0, 0, 1, 0),
(161, 2, 76, 0, 0, 1, 1),
(162, 2, 63, 1, 1, 1, 1),
(163, 2, 64, 1, 1, 1, 1),
(164, 2, 65, 1, 1, 1, 1),
(165, 2, 66, 0, 0, 1, 0),
(166, 2, 67, 1, 1, 1, 1),
(167, 2, 68, 1, 1, 1, 1),
(168, 2, 81, 0, 0, 0, 0),
(169, 2, 82, 1, 0, 1, 0),
(170, 2, 83, 1, 1, 1, 1),
(171, 2, 84, 1, 1, 1, 1),
(172, 2, 85, 1, 1, 1, 1),
(173, 2, 86, 0, 0, 0, 0),
(174, 2, 87, 0, 0, 0, 0),
(175, 7, 1, 0, 0, 0, 0),
(176, 7, 2, 0, 0, 0, 0),
(177, 7, 3, 0, 0, 0, 0),
(178, 7, 4, 0, 0, 0, 0),
(179, 7, 5, 0, 0, 0, 0),
(180, 7, 30, 0, 0, 0, 0),
(181, 7, 7, 0, 0, 0, 0),
(182, 7, 8, 0, 0, 0, 0),
(183, 7, 6, 0, 0, 0, 0),
(184, 7, 9, 0, 0, 0, 0),
(185, 7, 10, 0, 0, 0, 0),
(186, 7, 11, 0, 0, 0, 0),
(187, 7, 12, 0, 0, 0, 0),
(188, 7, 13, 0, 0, 0, 0),
(189, 7, 14, 0, 0, 0, 0),
(190, 7, 15, 0, 0, 0, 0),
(191, 7, 16, 0, 0, 0, 0),
(192, 7, 17, 0, 0, 0, 0),
(194, 7, 19, 0, 0, 0, 0),
(195, 7, 20, 0, 0, 0, 0),
(196, 7, 21, 0, 0, 0, 0),
(197, 7, 22, 0, 0, 0, 0),
(198, 7, 23, 0, 0, 0, 0),
(199, 7, 24, 0, 0, 0, 0),
(200, 7, 25, 0, 0, 0, 0),
(201, 7, 26, 0, 0, 1, 0),
(202, 7, 27, 0, 0, 0, 0),
(203, 7, 28, 0, 0, 0, 0),
(204, 7, 29, 0, 0, 1, 0),
(205, 7, 32, 0, 0, 0, 0),
(206, 7, 31, 0, 0, 0, 0),
(207, 7, 33, 0, 0, 0, 0),
(208, 7, 34, 0, 0, 0, 0),
(209, 7, 35, 0, 0, 0, 0),
(210, 7, 36, 0, 0, 0, 0),
(211, 7, 37, 0, 0, 0, 0),
(212, 7, 38, 0, 0, 0, 0),
(213, 7, 39, 0, 0, 0, 0),
(214, 7, 77, 0, 0, 0, 0),
(215, 7, 78, 0, 0, 0, 0),
(216, 7, 79, 0, 0, 0, 0),
(217, 7, 40, 0, 0, 0, 0),
(218, 7, 41, 0, 0, 0, 0),
(219, 7, 42, 0, 0, 0, 0),
(220, 7, 43, 0, 0, 0, 0),
(221, 7, 44, 0, 0, 0, 0),
(222, 7, 45, 0, 0, 0, 0),
(223, 7, 46, 0, 0, 0, 0),
(224, 7, 47, 0, 0, 0, 0),
(225, 7, 48, 0, 0, 0, 0),
(226, 7, 49, 0, 0, 0, 0),
(227, 7, 50, 0, 0, 0, 0),
(228, 7, 51, 0, 0, 0, 0),
(229, 7, 52, 0, 0, 0, 0),
(230, 7, 53, 0, 0, 0, 0),
(231, 7, 54, 0, 0, 0, 0),
(232, 7, 55, 0, 0, 0, 0),
(233, 7, 56, 0, 0, 0, 0),
(234, 7, 57, 0, 0, 0, 0),
(235, 7, 58, 0, 0, 0, 0),
(236, 7, 59, 0, 0, 0, 0),
(237, 7, 60, 0, 0, 0, 0),
(238, 7, 61, 0, 0, 0, 0),
(239, 7, 62, 0, 0, 0, 0),
(240, 7, 80, 0, 0, 0, 0),
(241, 7, 69, 0, 0, 0, 0),
(242, 7, 70, 0, 0, 0, 0),
(243, 7, 71, 0, 0, 0, 0),
(244, 7, 72, 0, 0, 0, 0),
(245, 7, 73, 0, 0, 0, 0),
(246, 7, 74, 0, 0, 0, 0),
(247, 7, 75, 0, 0, 0, 0),
(248, 7, 76, 0, 0, 0, 0),
(249, 7, 63, 0, 0, 0, 0),
(250, 7, 64, 0, 0, 0, 0),
(251, 7, 65, 0, 0, 0, 0),
(252, 7, 66, 0, 0, 0, 0),
(253, 7, 67, 0, 0, 0, 0),
(254, 7, 68, 0, 0, 0, 0),
(255, 7, 81, 0, 0, 0, 0),
(256, 7, 82, 0, 0, 0, 0),
(257, 7, 83, 0, 0, 0, 0),
(258, 7, 84, 0, 0, 0, 0),
(259, 7, 85, 0, 0, 0, 0),
(260, 7, 86, 0, 0, 0, 0),
(261, 7, 87, 0, 0, 0, 0),
(262, 88, 88, 1, 1, 1, 1),
(263, 88, 88, 1, 1, 1, 1),
(264, 89, 89, 1, 1, 1, 1),
(265, 90, 90, 1, 1, 1, 1),
(266, 2, 88, 1, 0, 1, 0),
(267, 2, 89, 0, 0, 1, 0),
(268, 90, 90, 1, 1, 1, 1),
(269, 2, 90, 0, 1, 1, 0),
(270, 91, 91, 1, 1, 1, 1),
(271, 92, 92, 1, 1, 1, 1),
(272, 2, 91, 0, 0, 1, 0),
(273, 2, 92, 0, 0, 1, 0),
(274, 93, 93, 1, 1, 1, 1),
(275, 94, 94, 1, 1, 1, 1),
(276, 95, 95, 1, 1, 1, 1),
(277, 96, 96, 1, 1, 1, 1),
(278, 2, 93, 0, 0, 1, 0),
(279, 2, 94, 0, 0, 1, 0),
(280, 2, 95, 0, 0, 1, 0),
(281, 2, 96, 0, 0, 1, 0),
(282, 97, 97, 1, 1, 1, 1),
(283, 98, 98, 1, 1, 1, 1),
(284, 2, 97, 0, 0, 1, 0),
(285, 2, 98, 0, 0, 1, 0),
(286, 99, 99, 1, 1, 1, 1),
(287, 100, 100, 1, 1, 1, 1),
(288, 101, 101, 1, 1, 1, 1),
(289, 102, 102, 1, 1, 1, 1),
(290, 2, 99, 0, 0, 1, 0),
(291, 2, 100, 0, 0, 1, 0),
(292, 2, 101, 0, 0, 1, 0),
(293, 2, 102, 0, 0, 1, 0),
(294, 103, 103, 1, 1, 1, 1),
(295, 2, 103, 0, 1, 1, 0),
(296, 3, 91, 0, 0, 0, 0),
(297, 3, 92, 0, 0, 0, 0),
(298, 3, 93, 0, 0, 1, 0),
(299, 3, 94, 0, 0, 1, 0),
(300, 3, 95, 0, 0, 1, 0),
(301, 3, 96, 0, 0, 1, 0),
(302, 3, 97, 0, 0, 1, 0),
(303, 3, 98, 0, 0, 1, 0),
(304, 3, 99, 0, 0, 0, 0),
(305, 3, 100, 0, 0, 0, 0),
(306, 3, 101, 0, 0, 0, 0),
(307, 3, 102, 0, 0, 0, 0),
(308, 3, 88, 1, 0, 1, 0),
(309, 3, 89, 0, 0, 1, 0),
(310, 3, 90, 0, 0, 0, 0),
(311, 3, 103, 0, 0, 0, 0),
(312, 4, 91, 0, 0, 1, 0),
(313, 4, 92, 0, 0, 1, 0),
(314, 4, 93, 0, 0, 0, 0),
(315, 4, 94, 0, 0, 0, 0),
(316, 4, 95, 0, 0, 0, 0),
(317, 4, 96, 0, 0, 0, 0),
(318, 4, 97, 0, 0, 0, 0),
(319, 4, 98, 0, 0, 0, 0),
(320, 4, 99, 0, 0, 0, 0),
(321, 4, 100, 0, 0, 0, 0),
(322, 4, 101, 0, 0, 0, 0),
(323, 4, 102, 0, 0, 0, 0),
(324, 4, 1, 0, 0, 0, 0),
(325, 4, 2, 0, 0, 0, 0),
(326, 4, 3, 0, 0, 0, 0),
(327, 4, 4, 0, 0, 0, 0),
(328, 4, 5, 0, 0, 0, 0),
(329, 4, 30, 0, 0, 0, 0),
(330, 4, 7, 0, 0, 0, 0),
(331, 4, 8, 0, 0, 0, 0),
(332, 4, 6, 0, 0, 0, 0),
(333, 4, 9, 0, 0, 0, 0),
(334, 4, 10, 0, 0, 0, 0),
(335, 4, 11, 0, 0, 0, 0),
(336, 4, 12, 1, 1, 1, 1),
(337, 4, 13, 1, 0, 1, 0),
(338, 4, 14, 1, 0, 1, 0),
(339, 4, 15, 0, 0, 1, 0),
(340, 4, 16, 1, 1, 1, 1),
(341, 4, 17, 1, 1, 1, 1),
(343, 4, 19, 1, 1, 1, 1),
(344, 4, 20, 1, 1, 1, 1),
(345, 4, 21, 1, 1, 1, 1),
(346, 4, 22, 1, 1, 1, 1),
(347, 4, 23, 0, 0, 0, 0),
(348, 4, 24, 0, 0, 0, 0),
(349, 4, 25, 0, 0, 0, 0),
(350, 4, 26, 0, 0, 0, 0),
(351, 4, 27, 0, 0, 0, 0),
(352, 4, 28, 0, 0, 0, 0),
(353, 4, 29, 0, 0, 0, 0),
(354, 4, 32, 0, 0, 0, 0),
(355, 4, 88, 0, 0, 0, 0),
(356, 4, 89, 0, 0, 0, 0),
(357, 4, 31, 0, 0, 0, 0),
(358, 4, 33, 0, 0, 0, 0),
(359, 4, 34, 0, 0, 0, 0),
(360, 4, 35, 0, 0, 0, 0),
(361, 4, 36, 0, 0, 0, 0),
(362, 4, 37, 0, 0, 0, 0),
(363, 4, 38, 0, 0, 0, 0),
(364, 4, 39, 0, 0, 0, 0),
(365, 4, 77, 0, 0, 0, 0),
(366, 4, 78, 0, 0, 0, 0),
(367, 4, 79, 0, 0, 0, 0),
(368, 4, 40, 0, 0, 0, 0),
(369, 4, 41, 0, 0, 0, 0),
(370, 4, 42, 0, 0, 0, 0),
(371, 4, 43, 0, 0, 0, 0),
(372, 4, 44, 0, 0, 0, 0),
(373, 4, 45, 0, 0, 0, 0),
(374, 4, 46, 0, 0, 0, 0),
(375, 4, 47, 0, 0, 0, 0),
(376, 4, 48, 0, 0, 0, 0),
(377, 4, 49, 0, 0, 0, 0),
(378, 4, 50, 0, 0, 0, 0),
(379, 4, 51, 0, 0, 0, 0),
(380, 4, 52, 0, 0, 0, 0),
(381, 4, 53, 0, 0, 0, 0),
(382, 4, 54, 0, 0, 0, 0),
(383, 4, 55, 0, 0, 1, 0),
(384, 4, 56, 0, 0, 0, 0),
(385, 4, 57, 0, 0, 0, 0),
(386, 4, 58, 1, 0, 1, 0),
(387, 4, 59, 0, 0, 0, 0),
(388, 4, 60, 0, 0, 0, 0),
(389, 4, 61, 0, 0, 0, 0),
(390, 4, 62, 0, 0, 0, 0),
(391, 4, 80, 0, 0, 0, 0),
(392, 4, 69, 1, 1, 1, 1),
(393, 4, 70, 1, 1, 1, 1),
(394, 4, 71, 1, 1, 1, 1),
(395, 4, 72, 1, 1, 1, 1),
(396, 4, 73, 1, 0, 0, 0),
(397, 4, 74, 1, 1, 1, 1),
(398, 4, 75, 0, 0, 1, 0),
(399, 4, 76, 0, 0, 1, 0),
(400, 4, 63, 1, 1, 1, 1),
(401, 4, 64, 1, 1, 1, 1),
(402, 4, 65, 1, 1, 1, 1),
(403, 4, 66, 0, 0, 1, 0),
(404, 4, 67, 1, 1, 1, 1),
(405, 4, 68, 1, 1, 1, 1),
(406, 4, 81, 0, 0, 0, 0),
(407, 4, 82, 0, 0, 0, 0),
(408, 4, 83, 0, 0, 0, 0),
(409, 4, 84, 0, 0, 0, 0),
(410, 4, 85, 0, 0, 0, 0),
(411, 4, 86, 0, 0, 0, 0),
(412, 4, 87, 0, 0, 0, 0),
(413, 4, 90, 0, 0, 0, 0),
(414, 4, 103, 0, 0, 0, 0),
(415, 5, 91, 0, 0, 0, 0),
(416, 5, 92, 0, 0, 0, 0),
(417, 5, 93, 0, 0, 1, 0),
(418, 5, 94, 0, 0, 1, 0),
(419, 5, 95, 0, 0, 0, 0),
(420, 5, 96, 0, 0, 0, 0),
(421, 5, 97, 0, 0, 0, 0),
(422, 5, 98, 0, 0, 0, 0),
(423, 5, 99, 0, 0, 0, 0),
(424, 5, 100, 0, 0, 0, 0),
(425, 5, 101, 0, 0, 0, 0),
(426, 5, 102, 0, 0, 0, 0),
(427, 5, 1, 0, 0, 1, 0),
(428, 5, 2, 0, 0, 0, 0),
(429, 5, 3, 0, 0, 0, 0),
(430, 5, 4, 0, 0, 0, 0),
(431, 5, 5, 0, 0, 0, 0),
(432, 5, 30, 0, 0, 0, 0),
(433, 5, 7, 0, 0, 0, 0),
(434, 5, 8, 0, 0, 0, 0),
(435, 5, 6, 0, 0, 1, 0),
(436, 5, 9, 0, 0, 0, 0),
(437, 5, 10, 0, 0, 0, 0),
(438, 5, 11, 0, 0, 0, 0),
(439, 5, 12, 0, 0, 0, 0),
(440, 5, 13, 0, 0, 0, 0),
(441, 5, 14, 0, 0, 0, 0),
(442, 5, 15, 0, 0, 0, 0),
(443, 5, 16, 0, 0, 0, 0),
(444, 5, 17, 0, 0, 0, 0),
(446, 5, 19, 0, 0, 0, 0),
(447, 5, 20, 1, 1, 1, 1),
(448, 5, 21, 0, 0, 0, 0),
(449, 5, 22, 0, 0, 0, 0),
(450, 5, 23, 0, 0, 0, 0),
(451, 5, 24, 0, 0, 0, 0),
(452, 5, 25, 0, 0, 0, 0),
(453, 5, 26, 0, 0, 0, 0),
(454, 5, 27, 0, 0, 0, 0),
(455, 5, 28, 0, 0, 0, 0),
(456, 5, 29, 0, 0, 0, 0),
(457, 5, 32, 0, 0, 0, 0),
(458, 5, 88, 0, 0, 0, 0),
(459, 5, 89, 0, 0, 0, 0),
(460, 5, 31, 0, 0, 0, 0),
(461, 5, 33, 0, 0, 0, 0),
(462, 5, 34, 0, 0, 0, 0),
(463, 5, 35, 0, 0, 0, 0),
(464, 5, 36, 0, 0, 0, 0),
(465, 5, 37, 0, 0, 0, 0),
(466, 5, 38, 0, 0, 0, 0),
(467, 5, 39, 0, 0, 0, 0),
(468, 5, 77, 0, 0, 0, 0),
(469, 5, 78, 0, 0, 0, 0),
(470, 5, 79, 0, 0, 0, 0),
(471, 5, 40, 0, 0, 0, 0),
(472, 5, 41, 0, 0, 0, 0),
(473, 5, 42, 0, 0, 0, 0),
(474, 5, 43, 0, 0, 0, 0),
(475, 5, 44, 0, 0, 0, 0),
(476, 5, 45, 0, 0, 0, 0),
(477, 5, 46, 0, 0, 0, 0),
(478, 5, 47, 0, 0, 0, 0),
(479, 5, 48, 0, 0, 0, 0),
(480, 5, 49, 0, 0, 0, 0),
(481, 5, 50, 0, 0, 0, 0),
(482, 5, 51, 0, 0, 0, 0),
(483, 5, 52, 0, 0, 0, 0),
(484, 5, 53, 0, 0, 0, 0),
(485, 5, 54, 0, 0, 0, 0),
(486, 5, 55, 1, 1, 1, 1),
(487, 5, 56, 1, 1, 1, 1),
(488, 5, 57, 1, 0, 1, 1),
(489, 5, 58, 1, 0, 1, 1),
(490, 5, 59, 0, 0, 0, 0),
(491, 5, 60, 0, 0, 0, 0),
(492, 5, 61, 0, 0, 0, 0),
(493, 5, 62, 0, 0, 0, 0),
(494, 5, 80, 0, 0, 0, 0),
(495, 5, 69, 0, 0, 0, 0),
(496, 5, 70, 0, 0, 0, 0),
(497, 5, 71, 0, 0, 0, 0),
(498, 5, 72, 0, 0, 0, 0),
(499, 5, 73, 0, 0, 0, 0),
(500, 5, 74, 0, 0, 0, 0),
(501, 5, 75, 0, 0, 0, 0),
(502, 5, 76, 0, 0, 0, 0),
(503, 5, 63, 0, 0, 0, 0),
(504, 5, 64, 0, 0, 0, 0),
(505, 5, 65, 0, 0, 0, 0),
(506, 5, 66, 0, 0, 0, 0),
(507, 5, 67, 0, 0, 0, 0),
(508, 5, 68, 0, 0, 0, 0),
(509, 5, 81, 0, 0, 0, 0),
(510, 5, 82, 0, 0, 0, 0),
(511, 5, 83, 0, 0, 0, 0),
(512, 5, 84, 0, 0, 0, 0),
(513, 5, 85, 0, 0, 0, 0),
(514, 5, 86, 0, 0, 0, 0),
(515, 5, 87, 0, 0, 0, 0),
(516, 5, 90, 0, 0, 0, 0),
(517, 5, 103, 0, 0, 0, 0),
(518, 104, 104, 1, 1, 1, 1),
(519, 2, 104, 0, 0, 1, 0),
(520, 4, 104, 0, 0, 1, 0),
(521, 2, 18, 1, 1, 1, 0),
(522, 2, 105, 0, 1, 1, 0),
(523, 2, 106, 1, 1, 1, 1),
(524, 2, 107, 0, 0, 1, 0),
(525, 2, 109, 1, 1, 1, 1),
(526, 2, 108, 0, 1, 1, 0),
(527, 3, 18, 0, 0, 0, 0),
(528, 3, 107, 0, 0, 0, 0),
(529, 3, 109, 1, 1, 1, 1),
(530, 3, 104, 0, 0, 0, 0),
(531, 3, 105, 0, 0, 0, 0),
(532, 3, 106, 0, 0, 0, 0),
(533, 3, 108, 0, 0, 0, 0),
(534, 2, 110, 1, 1, 1, 1),
(535, 2, 111, 0, 0, 1, 0),
(536, 2, 112, 0, 0, 1, 0),
(537, 2, 113, 1, 1, 1, 1),
(538, 2, 114, 0, 0, 1, 0),
(539, 2, 115, 0, 0, 1, 0),
(540, 2, 116, 1, 1, 1, 1),
(541, 2, 117, 0, 0, 1, 0),
(542, 3, 110, 1, 1, 1, 1),
(543, 3, 111, 0, 0, 1, 0),
(544, 3, 112, 0, 0, 0, 0),
(545, 3, 113, 1, 1, 1, 1),
(546, 3, 114, 0, 0, 1, 0),
(547, 3, 115, 0, 0, 0, 0),
(548, 3, 116, 1, 1, 1, 1),
(549, 3, 117, 0, 0, 1, 0),
(550, 2, 127, 1, 0, 1, 1),
(551, 2, 118, 1, 0, 1, 0),
(552, 2, 119, 1, 1, 1, 1),
(553, 2, 120, 1, 0, 1, 0),
(554, 2, 121, 1, 1, 1, 1),
(555, 2, 122, 1, 1, 1, 1),
(556, 2, 123, 1, 1, 1, 1),
(557, 2, 124, 1, 1, 1, 1),
(558, 2, 125, 1, 1, 1, 1),
(559, 2, 126, 1, 1, 1, 1),
(560, 3, 118, 0, 0, 0, 0),
(561, 3, 119, 0, 0, 0, 0),
(562, 3, 120, 0, 0, 0, 0),
(563, 3, 121, 0, 0, 0, 0),
(564, 3, 122, 0, 0, 0, 0),
(565, 3, 123, 0, 0, 0, 0),
(566, 3, 124, 0, 0, 0, 0),
(567, 3, 125, 0, 0, 0, 0),
(568, 3, 126, 0, 0, 0, 0),
(569, 3, 127, 0, 0, 0, 0),
(570, 3, 128, 0, 0, 0, 0),
(571, 2, 129, 0, 0, 1, 0),
(572, 2, 128, 0, 0, 0, 0),
(573, 2, 131, 1, 1, 1, 1),
(574, 2, 132, 1, 1, 1, 1),
(575, 2, 130, 0, 0, 0, 1),
(576, 4, 118, 0, 0, 0, 0),
(577, 4, 119, 0, 0, 0, 0),
(578, 4, 120, 0, 0, 0, 0),
(579, 4, 121, 0, 0, 0, 0),
(580, 4, 122, 0, 0, 0, 0),
(581, 4, 123, 0, 0, 0, 0),
(582, 4, 124, 0, 0, 0, 0),
(583, 4, 125, 0, 0, 0, 0),
(584, 4, 126, 0, 0, 0, 0),
(585, 4, 131, 0, 0, 0, 0),
(586, 4, 132, 0, 0, 0, 0),
(587, 4, 127, 0, 0, 0, 0),
(588, 4, 113, 0, 0, 0, 0),
(589, 4, 114, 0, 0, 0, 0),
(590, 4, 115, 0, 0, 0, 0),
(591, 4, 116, 0, 0, 0, 0),
(592, 4, 117, 0, 0, 0, 0),
(593, 4, 110, 0, 0, 0, 0),
(594, 4, 111, 0, 0, 0, 0),
(595, 4, 112, 0, 0, 0, 0),
(596, 4, 18, 0, 0, 0, 0),
(597, 4, 107, 0, 0, 0, 0),
(598, 4, 109, 0, 0, 0, 0),
(599, 4, 129, 0, 0, 0, 0),
(600, 4, 130, 0, 0, 0, 1),
(601, 4, 105, 0, 0, 0, 0),
(602, 4, 106, 0, 0, 0, 0),
(603, 4, 108, 0, 0, 0, 0),
(604, 4, 128, 0, 0, 0, 0),
(605, 2, 154, 1, 1, 1, 1),
(606, 2, 155, 0, 0, 1, 0),
(607, 2, 133, 0, 0, 1, 0),
(608, 3, 133, 0, 0, 1, 0),
(609, 2, 134, 1, 1, 1, 1),
(610, 2, 136, 1, 1, 1, 1),
(611, 2, 137, 1, 1, 1, 1),
(612, 2, 138, 1, 0, 0, 0),
(613, 2, 139, 1, 1, 1, 1),
(614, 2, 140, 0, 0, 1, 0),
(615, 2, 135, 0, 1, 1, 0),
(616, 3, 131, 0, 0, 0, 0),
(617, 3, 132, 0, 0, 0, 0),
(618, 3, 129, 0, 0, 0, 0),
(619, 3, 130, 0, 0, 0, 0),
(620, 3, 136, 1, 1, 1, 1),
(621, 3, 137, 1, 1, 1, 1),
(622, 3, 138, 1, 0, 0, 0),
(623, 3, 139, 1, 1, 1, 1),
(624, 3, 140, 0, 0, 1, 0),
(625, 3, 134, 0, 0, 0, 0),
(626, 3, 135, 0, 0, 0, 0),
(627, 2, 141, 1, 0, 1, 0),
(628, 2, 142, 1, 1, 1, 1),
(629, 2, 143, 1, 1, 1, 1),
(630, 2, 144, 1, 1, 1, 1),
(631, 2, 145, 1, 1, 1, 1),
(632, 2, 146, 1, 1, 1, 1),
(633, 2, 147, 1, 0, 1, 1),
(634, 2, 148, 1, 1, 1, 1),
(635, 2, 149, 0, 0, 1, 0),
(636, 2, 150, 0, 0, 1, 0),
(637, 2, 151, 0, 0, 1, 0),
(638, 2, 152, 0, 0, 1, 0),
(639, 2, 153, 0, 0, 1, 0),
(640, 8, 91, 0, 0, 0, 0),
(641, 8, 92, 0, 0, 0, 0),
(642, 8, 93, 0, 0, 1, 0),
(643, 8, 94, 0, 0, 1, 0),
(644, 8, 95, 0, 0, 1, 0),
(645, 8, 96, 0, 0, 1, 0),
(646, 8, 97, 0, 0, 0, 0),
(647, 8, 98, 0, 0, 0, 0),
(648, 8, 99, 0, 0, 0, 0),
(649, 8, 100, 0, 0, 0, 0),
(650, 8, 101, 0, 0, 0, 0),
(651, 8, 102, 0, 0, 0, 0),
(652, 8, 151, 0, 0, 1, 0),
(653, 8, 152, 0, 0, 1, 0),
(654, 8, 118, 0, 0, 0, 0),
(655, 8, 119, 0, 0, 0, 0),
(656, 8, 120, 0, 0, 0, 0),
(657, 8, 121, 0, 0, 0, 0),
(658, 8, 122, 0, 0, 0, 0),
(659, 8, 123, 0, 0, 0, 0),
(660, 8, 124, 0, 0, 0, 0),
(661, 8, 125, 0, 0, 0, 0),
(662, 8, 126, 0, 0, 0, 0),
(663, 8, 131, 0, 0, 0, 0),
(664, 8, 132, 0, 0, 0, 0),
(665, 8, 1, 0, 0, 1, 0),
(666, 8, 2, 0, 0, 0, 0),
(667, 8, 3, 0, 0, 0, 0),
(668, 8, 4, 0, 0, 0, 0),
(669, 8, 5, 0, 0, 0, 0),
(670, 8, 30, 0, 0, 0, 0),
(671, 8, 127, 0, 0, 0, 0),
(672, 8, 7, 0, 0, 1, 0),
(673, 8, 8, 0, 0, 0, 0),
(674, 8, 6, 0, 0, 1, 0),
(675, 8, 9, 0, 0, 0, 0),
(676, 8, 10, 0, 0, 0, 0),
(677, 8, 11, 0, 0, 0, 0),
(678, 8, 113, 0, 0, 0, 0),
(679, 8, 114, 0, 0, 0, 0),
(680, 8, 115, 0, 0, 0, 0),
(681, 8, 116, 0, 0, 0, 0),
(682, 8, 117, 0, 0, 0, 0),
(683, 8, 110, 0, 0, 0, 0),
(684, 8, 111, 0, 0, 0, 0),
(685, 8, 112, 0, 0, 0, 0),
(686, 8, 12, 0, 0, 0, 0),
(687, 8, 13, 0, 0, 0, 0),
(688, 8, 14, 0, 0, 1, 0),
(689, 8, 15, 0, 0, 0, 0),
(690, 8, 16, 0, 0, 0, 0),
(691, 8, 17, 0, 0, 0, 0),
(692, 8, 18, 1, 0, 1, 1),
(693, 8, 19, 0, 0, 0, 0),
(694, 8, 20, 1, 1, 1, 1),
(695, 8, 21, 0, 0, 0, 0),
(696, 8, 22, 0, 0, 0, 0),
(697, 8, 107, 0, 0, 0, 0),
(698, 8, 23, 0, 0, 0, 0),
(699, 8, 24, 0, 0, 0, 0),
(700, 8, 25, 0, 0, 0, 0),
(701, 8, 26, 0, 0, 0, 0),
(702, 8, 27, 0, 0, 0, 0),
(703, 8, 28, 0, 0, 0, 0),
(704, 8, 29, 0, 0, 0, 0),
(705, 8, 133, 0, 0, 0, 0),
(706, 8, 109, 0, 0, 0, 0),
(707, 8, 129, 0, 0, 0, 0),
(708, 8, 31, 0, 0, 0, 0),
(709, 8, 33, 0, 0, 0, 0),
(710, 8, 32, 0, 0, 0, 0),
(711, 8, 88, 0, 0, 0, 0),
(712, 8, 89, 0, 0, 0, 0),
(713, 8, 34, 0, 0, 0, 0),
(714, 8, 35, 0, 0, 0, 0),
(715, 8, 36, 0, 0, 0, 0),
(716, 8, 37, 0, 0, 0, 0),
(717, 8, 38, 0, 0, 0, 0),
(718, 8, 39, 0, 0, 0, 0),
(719, 8, 77, 0, 0, 0, 0),
(720, 8, 78, 0, 0, 0, 0),
(721, 8, 79, 0, 0, 0, 0),
(722, 8, 153, 0, 0, 0, 0),
(723, 8, 40, 0, 0, 0, 0),
(724, 8, 41, 0, 0, 0, 0),
(725, 8, 42, 0, 0, 0, 0),
(726, 8, 43, 0, 0, 0, 0),
(727, 8, 44, 0, 0, 0, 0),
(728, 8, 45, 0, 0, 0, 0),
(729, 8, 46, 0, 0, 0, 0),
(730, 8, 47, 0, 0, 0, 0),
(731, 8, 48, 0, 0, 0, 0),
(732, 8, 49, 0, 0, 0, 0),
(733, 8, 50, 0, 0, 0, 0),
(734, 8, 51, 0, 0, 0, 0),
(735, 8, 52, 0, 0, 0, 0),
(736, 8, 53, 0, 0, 0, 0),
(737, 8, 54, 0, 0, 0, 0),
(738, 8, 55, 0, 0, 0, 0),
(739, 8, 56, 0, 0, 0, 0),
(740, 8, 57, 0, 0, 0, 0),
(741, 8, 58, 0, 0, 0, 0),
(742, 8, 59, 0, 0, 0, 0),
(743, 8, 60, 0, 0, 0, 0),
(744, 8, 61, 0, 0, 0, 0),
(745, 8, 62, 0, 0, 0, 0),
(746, 8, 80, 0, 0, 0, 0),
(747, 8, 149, 0, 0, 0, 0),
(748, 8, 150, 0, 0, 0, 0),
(749, 8, 69, 0, 0, 0, 0),
(750, 8, 70, 0, 0, 0, 0),
(751, 8, 71, 0, 0, 0, 0),
(752, 8, 72, 0, 0, 0, 0),
(753, 8, 73, 0, 0, 0, 0),
(754, 8, 74, 0, 0, 0, 0),
(755, 8, 75, 0, 0, 0, 0),
(756, 8, 76, 0, 0, 0, 0),
(757, 8, 104, 0, 0, 0, 0),
(758, 8, 130, 0, 0, 0, 0),
(759, 8, 63, 0, 0, 0, 0),
(760, 8, 64, 0, 0, 0, 0),
(761, 8, 65, 0, 0, 0, 0),
(762, 8, 66, 0, 0, 0, 0),
(763, 8, 67, 0, 0, 0, 0),
(764, 8, 68, 0, 0, 0, 0),
(765, 8, 136, 0, 0, 0, 0),
(766, 8, 137, 0, 0, 0, 0),
(767, 8, 138, 0, 0, 0, 0),
(768, 8, 139, 0, 0, 0, 0),
(769, 8, 140, 0, 0, 0, 0),
(770, 8, 141, 0, 0, 0, 0),
(771, 8, 142, 1, 1, 1, 1),
(772, 8, 143, 1, 1, 1, 1),
(773, 8, 144, 1, 1, 1, 1),
(774, 8, 145, 1, 1, 1, 1),
(775, 8, 146, 1, 1, 1, 1),
(776, 8, 147, 1, 0, 1, 1),
(777, 8, 148, 1, 1, 1, 1),
(778, 8, 81, 0, 0, 0, 0),
(779, 8, 82, 0, 0, 0, 0),
(780, 8, 83, 0, 0, 0, 0),
(781, 8, 84, 0, 0, 0, 0),
(782, 8, 85, 0, 0, 0, 0),
(783, 8, 86, 0, 0, 0, 0),
(784, 8, 87, 0, 0, 0, 0),
(785, 8, 90, 0, 0, 0, 0),
(786, 8, 103, 0, 0, 0, 0),
(787, 8, 105, 0, 0, 0, 0),
(788, 8, 106, 0, 0, 0, 0),
(789, 8, 108, 0, 0, 0, 0),
(790, 8, 128, 0, 0, 0, 0),
(791, 8, 134, 0, 0, 0, 0),
(792, 8, 135, 0, 0, 0, 0),
(793, 2, 157, 1, 1, 1, 1),
(794, 2, 158, 1, 1, 1, 1),
(795, 2, 159, 1, 1, 1, 1),
(796, 2, 160, 1, 1, 1, 1),
(797, 2, 161, 1, 1, 1, 1),
(798, 2, 162, 1, 0, 1, 0),
(799, 2, 163, 1, 1, 1, 1),
(800, 2, 164, 1, 0, 1, 1),
(801, 2, 165, 0, 0, 1, 0),
(802, 2, 166, 1, 0, 1, 1),
(803, 2, 167, 0, 0, 1, 0),
(804, 2, 168, 0, 0, 1, 0),
(805, 2, 173, 1, 1, 1, 1),
(806, 2, 174, 1, 1, 1, 1),
(807, 2, 155, 0, 0, 1, 0),
(808, 2, 156, 1, 1, 1, 1),
(809, 2, 169, 0, 0, 1, 1),
(810, 2, 170, 1, 1, 1, 1),
(811, 2, 171, 1, 1, 1, 1),
(812, 2, 172, 1, 0, 1, 0),
(813, 2, 175, 1, 1, 1, 1),
(814, 9, 1, 0, 0, 1, 0),
(815, 10, 1, 0, 0, 1, 0),
(816, 11, 1, 0, 0, 1, 0),
(817, 12, 1, 0, 0, 1, 0),
(818, 13, 1, 0, 0, 1, 0),
(819, 9, 2, 0, 0, 1, 0),
(820, 10, 2, 0, 0, 1, 0),
(821, 11, 2, 0, 0, 1, 0),
(822, 12, 2, 0, 0, 1, 0),
(823, 13, 2, 0, 0, 1, 0),
(824, 9, 3, 0, 0, 1, 0),
(825, 10, 3, 0, 0, 1, 0),
(826, 11, 3, 0, 0, 1, 0),
(827, 12, 3, 0, 0, 1, 0),
(828, 13, 3, 0, 0, 1, 0),
(829, 9, 4, 0, 0, 1, 0),
(830, 10, 4, 0, 0, 1, 0),
(831, 11, 4, 0, 0, 1, 0),
(832, 12, 4, 0, 0, 1, 0),
(833, 13, 4, 0, 0, 1, 0),
(834, 9, 5, 0, 0, 1, 0),
(835, 10, 5, 0, 0, 1, 0),
(836, 11, 5, 0, 0, 1, 0),
(837, 12, 5, 0, 0, 1, 0),
(838, 13, 5, 0, 0, 1, 0),
(839, 9, 6, 0, 0, 1, 0),
(840, 10, 6, 0, 0, 1, 0),
(841, 11, 6, 0, 0, 1, 0),
(842, 12, 6, 0, 0, 1, 0),
(843, 13, 6, 0, 0, 1, 0),
(844, 9, 7, 0, 0, 1, 0),
(845, 10, 7, 0, 0, 1, 0),
(846, 11, 7, 0, 0, 1, 0),
(847, 12, 7, 0, 0, 1, 0),
(848, 13, 7, 0, 0, 1, 0),
(849, 9, 8, 0, 0, 1, 0),
(850, 10, 8, 0, 0, 1, 0),
(851, 11, 8, 0, 0, 1, 0),
(852, 12, 8, 0, 0, 1, 0),
(853, 13, 8, 0, 0, 1, 0),
(854, 9, 9, 0, 0, 1, 0),
(855, 10, 9, 0, 0, 1, 0),
(856, 11, 9, 0, 0, 1, 0),
(857, 12, 9, 0, 0, 1, 0),
(858, 13, 9, 0, 0, 1, 0),
(859, 9, 10, 0, 0, 1, 0),
(860, 10, 10, 0, 0, 1, 0),
(861, 11, 10, 0, 0, 1, 0),
(862, 12, 10, 0, 0, 1, 0),
(863, 13, 10, 0, 0, 1, 0),
(864, 9, 11, 0, 0, 1, 0),
(865, 10, 11, 0, 0, 1, 0),
(866, 11, 11, 0, 0, 1, 0),
(867, 12, 11, 0, 0, 1, 0),
(868, 13, 11, 0, 0, 1, 0),
(869, 9, 12, 0, 0, 1, 0),
(870, 10, 12, 0, 0, 1, 0),
(871, 11, 12, 0, 0, 1, 0),
(872, 12, 12, 0, 0, 1, 0),
(873, 13, 12, 0, 0, 1, 0),
(874, 9, 13, 0, 0, 1, 0),
(875, 10, 13, 0, 0, 1, 0),
(876, 11, 13, 0, 0, 1, 0),
(877, 12, 13, 0, 0, 1, 0),
(878, 13, 13, 0, 0, 1, 0),
(879, 9, 14, 0, 0, 1, 0),
(880, 10, 14, 0, 0, 1, 0),
(881, 11, 14, 0, 0, 1, 0),
(882, 12, 14, 0, 0, 1, 0),
(883, 13, 14, 0, 0, 1, 0),
(884, 9, 15, 0, 0, 1, 0),
(885, 10, 15, 0, 0, 1, 0),
(886, 11, 15, 0, 0, 1, 0),
(887, 12, 15, 0, 0, 1, 0),
(888, 13, 15, 0, 0, 1, 0),
(889, 9, 16, 0, 0, 1, 0),
(890, 10, 16, 0, 0, 1, 0),
(891, 11, 16, 0, 0, 1, 0),
(892, 12, 16, 0, 0, 1, 0),
(893, 13, 16, 0, 0, 1, 0),
(894, 9, 17, 0, 0, 1, 0),
(895, 10, 17, 0, 0, 1, 0),
(896, 11, 17, 0, 0, 1, 0),
(897, 12, 17, 0, 0, 1, 0),
(898, 13, 17, 0, 0, 1, 0),
(899, 9, 18, 0, 0, 1, 0),
(900, 10, 18, 0, 0, 1, 0),
(901, 11, 18, 0, 0, 1, 0),
(902, 12, 18, 0, 0, 1, 0),
(903, 13, 18, 0, 0, 1, 0),
(904, 9, 19, 0, 0, 1, 0),
(905, 10, 19, 0, 0, 1, 0),
(906, 11, 19, 0, 0, 1, 0),
(907, 12, 19, 0, 0, 1, 0),
(908, 13, 19, 0, 0, 1, 0),
(909, 9, 20, 0, 0, 1, 0),
(910, 10, 20, 0, 0, 1, 0),
(911, 11, 20, 0, 0, 1, 0),
(912, 12, 20, 0, 0, 1, 0),
(913, 13, 20, 0, 0, 1, 0),
(914, 9, 21, 0, 0, 1, 0),
(915, 10, 21, 0, 0, 1, 0),
(916, 11, 21, 0, 0, 1, 0),
(917, 12, 21, 0, 0, 1, 0),
(918, 13, 21, 0, 0, 1, 0),
(919, 9, 22, 0, 0, 1, 0),
(920, 10, 22, 0, 0, 1, 0),
(921, 11, 22, 0, 0, 1, 0),
(922, 12, 22, 0, 0, 1, 0),
(923, 13, 22, 0, 0, 1, 0),
(924, 9, 23, 0, 0, 1, 0),
(925, 10, 23, 0, 0, 1, 0),
(926, 11, 23, 0, 0, 1, 0),
(927, 12, 23, 0, 0, 1, 0),
(928, 13, 23, 0, 0, 1, 0),
(929, 9, 24, 0, 0, 1, 0),
(930, 10, 24, 0, 0, 1, 0),
(931, 11, 24, 0, 0, 1, 0),
(932, 12, 24, 0, 0, 1, 0),
(933, 13, 24, 0, 0, 1, 0),
(934, 9, 25, 0, 0, 1, 0),
(935, 10, 25, 0, 0, 1, 0),
(936, 11, 25, 0, 0, 1, 0),
(937, 12, 25, 0, 0, 1, 0),
(938, 13, 25, 0, 0, 1, 0),
(939, 9, 26, 0, 0, 1, 0),
(940, 10, 26, 0, 0, 1, 0),
(941, 11, 26, 0, 0, 1, 0),
(942, 12, 26, 0, 0, 1, 0),
(943, 13, 26, 0, 0, 1, 0),
(944, 9, 27, 0, 0, 1, 0),
(945, 10, 27, 0, 0, 1, 0),
(946, 11, 27, 0, 0, 1, 0),
(947, 12, 27, 0, 0, 1, 0),
(948, 13, 27, 0, 0, 1, 0),
(949, 1, 28, 1, 1, 1, 1),
(950, 1, 29, 1, 1, 1, 1),
(951, 3, 176, 1, 1, 1, 1),
(952, 2, 176, 1, 1, 1, 1),
(953, 7, 176, 1, 1, 1, 1),
(954, 88, 176, 1, 1, 1, 1),
(955, 89, 176, 1, 1, 1, 1),
(956, 90, 176, 1, 1, 1, 1),
(957, 91, 176, 1, 1, 1, 1),
(958, 92, 176, 1, 1, 1, 1),
(959, 93, 176, 1, 1, 1, 1),
(960, 94, 176, 1, 1, 1, 1),
(961, 95, 176, 1, 1, 1, 1),
(962, 96, 176, 1, 1, 1, 1),
(963, 97, 176, 1, 1, 1, 1),
(964, 98, 176, 1, 1, 1, 1),
(965, 99, 176, 1, 1, 1, 1),
(966, 100, 176, 1, 1, 1, 1),
(967, 101, 176, 1, 1, 1, 1),
(968, 102, 176, 1, 1, 1, 1),
(969, 103, 176, 1, 1, 1, 1),
(970, 4, 176, 1, 1, 1, 1),
(971, 5, 176, 1, 1, 1, 1),
(972, 104, 176, 1, 1, 1, 1),
(973, 8, 176, 1, 1, 1, 1),
(974, 9, 176, 1, 1, 1, 1),
(975, 10, 176, 1, 1, 1, 1),
(976, 11, 176, 1, 1, 1, 1),
(977, 12, 176, 1, 1, 1, 1),
(978, 13, 176, 1, 1, 1, 1),
(979, 1, 176, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `register_no` varchar(100) DEFAULT NULL,
  `nin` varchar(11) DEFAULT NULL COMMENT 'National Identification Number (NIN)',
  `state_student_id` varchar(25) DEFAULT NULL COMMENT 'Auto-generated Kaduna State Student ID',
  `admission_date` varchar(100) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `birthday` varchar(100) DEFAULT NULL,
  `religion` varchar(100) DEFAULT NULL,
  `caste` varchar(100) DEFAULT NULL,
  `blood_group` varchar(100) DEFAULT NULL,
  `mother_tongue` varchar(100) DEFAULT NULL,
  `current_address` text DEFAULT NULL,
  `permanent_address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `mobileno` varchar(100) DEFAULT NULL,
  `category_id` int(11) NOT NULL DEFAULT 0,
  `email` varchar(100) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `route_id` int(11) NOT NULL DEFAULT 0,
  `stoppage_point_id` int(11) DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `hostel_id` int(11) NOT NULL DEFAULT 0,
  `room_id` int(11) NOT NULL DEFAULT 0,
  `previous_details` text DEFAULT NULL,
  `photo` varchar(100) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `register_no`, `nin`, `state_student_id`, `admission_date`, `first_name`, `last_name`, `gender`, `birthday`, `religion`, `caste`, `blood_group`, `mother_tongue`, `current_address`, `permanent_address`, `city`, `state`, `mobileno`, `category_id`, `email`, `parent_id`, `route_id`, `stoppage_point_id`, `vehicle_id`, `hostel_id`, `room_id`, `previous_details`, `photo`, `active`, `created_at`, `updated_at`) VALUES
(1, 'KD1234', NULL, NULL, '2026-04-02', 'Ridwan', 'Salmanu', 'male', '2023-01-01', 'Islam', '', 'O+', '', '', '', '', '', '', 1, '', 1, 0, NULL, 0, 0, 0, '{\"school_name\":\"\",\"qualification\":\"\",\"remarks\":\"\"}', 'defualt.png', 1, '2026-04-02 14:55:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_admission_fields`
--

CREATE TABLE `student_admission_fields` (
  `id` int(11) NOT NULL,
  `fields_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `required` tinyint(4) NOT NULL DEFAULT 0,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_attendance`
--

CREATE TABLE `student_attendance` (
  `id` int(11) NOT NULL,
  `enroll_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(4) DEFAULT NULL COMMENT 'P=Present, A=Absent, H=Holiday, L=Late',
  `remark` text DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_category`
--

CREATE TABLE `student_category` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL,
  `board_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `student_category`
--

INSERT INTO `student_category` (`id`, `branch_id`, `name`, `board_id`) VALUES
(1, 1, 'General', NULL),
(2, 1, 'Science', NULL),
(3, 1, 'Commerce', NULL),
(4, 1, 'Art', NULL),
(5, 1, 'Technical', NULL),
(6, 0, 'Day Student', 1),
(7, 0, 'Day Student', 2);

-- --------------------------------------------------------

--
-- Table structure for table `student_documents`
--

CREATE TABLE `student_documents` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` varchar(100) NOT NULL,
  `remarks` text NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `enc_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_fields`
--

CREATE TABLE `student_fields` (
  `id` int(11) NOT NULL,
  `prefix` varchar(255) NOT NULL,
  `default_status` tinyint(1) NOT NULL DEFAULT 1,
  `default_required` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `student_fields`
--

INSERT INTO `student_fields` (`id`, `prefix`, `default_status`, `default_required`, `created_at`) VALUES
(1, 'roll', 1, 0, '2026-02-18 20:27:04'),
(2, 'last_name', 1, 1, '2026-02-18 20:27:04'),
(3, 'gender', 1, 0, '2026-02-18 20:27:04'),
(4, 'birthday', 1, 0, '2026-02-18 20:27:04'),
(5, 'admission_date', 1, 1, '2026-02-18 20:27:04'),
(6, 'category', 1, 1, '2026-02-18 20:27:04'),
(7, 'section', 1, 1, '2026-02-18 20:27:04'),
(8, 'religion', 1, 0, '2026-02-18 20:27:04'),
(9, 'caste', 1, 0, '2026-02-18 20:27:04'),
(10, 'blood_group', 1, 0, '2026-02-18 20:27:04'),
(11, 'mother_tongue', 1, 0, '2026-02-18 20:27:04'),
(12, 'present_address', 1, 0, '2026-02-18 20:27:04'),
(13, 'permanent_address', 1, 0, '2026-02-18 20:27:04'),
(14, 'city', 1, 0, '2026-02-18 20:27:04'),
(15, 'state', 1, 0, '2026-02-18 20:27:04'),
(16, 'student_email', 1, 0, '2026-02-18 20:27:04'),
(17, 'student_mobile_no', 1, 0, '2026-02-18 20:27:04'),
(18, 'student_photo', 1, 0, '2026-02-18 20:27:04'),
(19, 'previous_school_details', 1, 0, '2026-02-18 20:27:04'),
(20, 'guardian_name', 1, 1, '2026-02-18 20:27:04'),
(21, 'guardian_relation', 1, 1, '2026-02-18 20:27:04'),
(22, 'father_name', 1, 0, '2026-02-18 20:27:04'),
(23, 'mother_name', 1, 0, '2026-02-18 20:27:04'),
(24, 'guardian_occupation', 1, 1, '2026-02-18 20:27:04'),
(25, 'guardian_income', 1, 1, '2026-02-18 20:27:04'),
(26, 'guardian_education', 1, 1, '2026-02-18 20:27:04'),
(27, 'guardian_email', 1, 1, '2026-02-18 20:27:04'),
(28, 'guardian_mobile_no', 1, 1, '2026-02-18 20:27:04'),
(29, 'guardian_address', 1, 1, '2026-02-18 20:27:04'),
(30, 'guardian_photo', 1, 0, '2026-02-18 20:27:04'),
(31, 'upload_documents', 1, 1, '2026-02-18 20:27:04'),
(32, 'guardian_city', 1, 0, '2026-02-18 20:27:04'),
(33, 'guardian_state', 1, 0, '2026-02-18 20:27:04'),
(34, 'first_name', 1, 1, '2026-02-18 20:27:04');

-- --------------------------------------------------------

--
-- Table structure for table `student_profile_fields`
--

CREATE TABLE `student_profile_fields` (
  `id` int(11) NOT NULL,
  `fields_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `required` tinyint(4) NOT NULL DEFAULT 0,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_subject_attendance`
--

CREATE TABLE `student_subject_attendance` (
  `id` int(11) NOT NULL,
  `enroll_id` int(11) DEFAULT NULL,
  `subject_timetable_id` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `subject_code` varchar(200) NOT NULL,
  `subject_type` varchar(255) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `curriculum_pdf` varchar(255) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `board_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `name`, `subject_code`, `subject_type`, `curriculum_pdf`, `branch_id`, `board_id`) VALUES
(1, 'English', 'ENG', 'Mandatory', '', 1, NULL),
(2, 'Mathematic', 'MTH', 'Mandatory', '', 1, NULL),
(3, 'Computer', 'COM', 'Mandatory', '', 1, NULL),
(4, 'Civic Education', 'CIV', 'Optional', '', 1, NULL),
(5, 'English Language', 'ENG', 'Theory', '', 0, 1),
(6, 'Mathematics', 'MTH', 'Theory', '', 0, 1),
(7, 'Basic Science', 'BSC', 'Theory', '', 0, 1),
(8, 'Social Studies', 'SST', 'Theory', '', 0, 1),
(9, 'Christian Religious Knowledge', 'CRK', 'Theory', '', 0, 1),
(10, 'Islamic Religious Knowledge', 'IRK', 'Theory', '', 0, 1),
(11, 'Hausa Language', 'HAU', 'Theory', '', 0, 1),
(12, 'Arabic Studies', 'ARB', 'Theory', '', 0, 1),
(13, 'Civic Education', 'CVE', 'Theory', '', 0, 1),
(14, 'Basic Technology', 'BTC', 'Practical', '', 0, 1),
(15, 'Agricultural Science', 'AGR', 'Theory', '', 0, 1),
(16, 'Business Studies', 'BSN', 'Theory', '', 0, 1),
(17, 'Home Economics', 'HEC', 'Practical', '', 0, 1),
(18, 'Physical & Health Education', 'PHE', 'Practical', '', 0, 1),
(19, 'Creative Arts', 'CRA', 'Practical', '', 0, 1),
(20, 'French', 'FRN', 'Theory', '', 0, 1),
(21, 'Computer Studies', 'CMP', 'Practical', '', 0, 1),
(22, 'English Language', 'ENG', 'Theory', '', 0, 2),
(23, 'Mathematics', 'MTH', 'Theory', '', 0, 2),
(24, 'Physics', 'PHY', 'Practical', '', 0, 2),
(25, 'Chemistry', 'CHM', 'Practical', '', 0, 2),
(26, 'Biology', 'BIO', 'Practical', '', 0, 2),
(27, 'Further Mathematics', 'FMT', 'Theory', '', 0, 2),
(28, 'Geography', 'GEO', 'Theory', '', 0, 2),
(29, 'Economics', 'ECO', 'Theory', '', 0, 2),
(30, 'Government', 'GOV', 'Theory', '', 0, 2),
(31, 'Literature-in-English', 'LIT', 'Theory', '', 0, 2),
(32, 'Hausa Language', 'HAU', 'Theory', '', 0, 2),
(33, 'Arabic Studies', 'ARB', 'Theory', '', 0, 2),
(34, 'Christian Religious Knowledge', 'CRK', 'Theory', '', 0, 2),
(35, 'Islamic Religious Knowledge', 'IRK', 'Theory', '', 0, 2),
(36, 'Civic Education', 'CVE', 'Theory', '', 0, 2),
(37, 'Computer Studies', 'CMP', 'Practical', '', 0, 2),
(38, 'Agricultural Science', 'AGR', 'Theory', '', 0, 2),
(39, 'Technical Drawing', 'TDR', 'Practical', '', 0, 2),
(40, 'Financial Accounting', 'ACC', 'Theory', '', 0, 2),
(41, 'Commerce', 'COM', 'Theory', '', 0, 2),
(42, 'French', 'FRN', 'Theory', '', 0, 2),
(43, 'Programming', 'PRG', 'Practical', NULL, 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subject_assign`
--

CREATE TABLE `subject_assign` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `subject_assign`
--

INSERT INTO `subject_assign` (`id`, `class_id`, `section_id`, `subject_id`, `teacher_id`, `branch_id`, `session_id`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 1, 2, 1, 3, '2026-03-27 07:51:53', NULL),
(2, 4, 1, 2, 2, 1, 3, '2026-03-27 07:51:53', NULL),
(3, 4, 1, 3, 2, 1, 3, '2026-03-27 07:51:53', NULL),
(8, 14, 11, 43, 0, 4, 3, '2026-04-14 17:21:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_allocation`
--

CREATE TABLE `teacher_allocation` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `teacher_allocation`
--

INSERT INTO `teacher_allocation` (`id`, `class_id`, `section_id`, `teacher_id`, `session_id`, `branch_id`) VALUES
(1, 4, 1, 2, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_note`
--

CREATE TABLE `teacher_note` (
  `id` int(11) NOT NULL,
  `title` longtext NOT NULL,
  `description` longtext NOT NULL,
  `file_name` longtext NOT NULL,
  `enc_name` longtext NOT NULL,
  `type_id` int(11) NOT NULL,
  `class_id` longtext NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_transfers`
--

CREATE TABLE `teacher_transfers` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `from_branch_id` int(11) NOT NULL,
  `to_branch_id` int(11) NOT NULL,
  `effective_date` date NOT NULL,
  `reason` text DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `reviewed_by` int(11) DEFAULT NULL,
  `rejection_note` text DEFAULT NULL,
  `reviewer_note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `teacher_transfers`
--

INSERT INTO `teacher_transfers` (`id`, `staff_id`, `from_branch_id`, `to_branch_id`, `effective_date`, `reason`, `attachment`, `status`, `reviewed_by`, `rejection_note`, `reviewer_note`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 6, '2026-04-16', 'Testing', NULL, 'rejected', 1, 'hhhh', NULL, '2026-04-15 11:02:26', '2026-04-15 12:04:01'),
(2, 2, 1, 10, '2026-04-16', 'tttt', NULL, 'approved', 1, NULL, NULL, '2026-04-15 11:05:35', '2026-04-15 12:05:39'),
(3, 10, 10, 1, '2026-04-30', 'sssss', NULL, 'pending', NULL, NULL, NULL, '2026-04-15 17:41:11', NULL),
(4, 2, 10, 3, '2026-04-27', 'Mariage purpose and relocating', NULL, 'pending', NULL, NULL, NULL, '2026-04-15 19:57:08', NULL),
(5, 2, 10, 5, '2026-04-30', 'jbjbjb', 'be39bd9f52b954a0622b04356a3ccada.jpg', 'pending', NULL, NULL, NULL, '2026-04-15 20:42:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `theme_settings`
--

CREATE TABLE `theme_settings` (
  `id` int(11) NOT NULL,
  `border_mode` varchar(200) NOT NULL,
  `dark_skin` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `theme_settings`
--

INSERT INTO `theme_settings` (`id`, `border_mode`, `dark_skin`, `created_at`, `updated_at`) VALUES
(1, 'true', 'false', '2026-02-10 16:59:38', '2026-02-14 14:08:47');

-- --------------------------------------------------------

--
-- Table structure for table `timetable_class`
--

CREATE TABLE `timetable_class` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `break` varchar(11) DEFAULT 'false',
  `subject_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `class_room` varchar(100) DEFAULT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  `day` varchar(20) NOT NULL,
  `session_id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `timetable_class`
--

INSERT INTO `timetable_class` (`id`, `class_id`, `section_id`, `break`, `subject_id`, `teacher_id`, `class_room`, `time_start`, `time_end`, `day`, `session_id`, `branch_id`) VALUES
(1, 4, 1, '0', 1, 2, '1', '08:00:00', '08:45:00', 'monday', 3, 1),
(2, 4, 1, '0', 2, 2, '2', '08:50:00', '09:35:00', 'monday', 3, 1),
(3, 4, 1, '0', 3, 2, '3', '09:40:00', '10:35:00', 'monday', 3, 1),
(4, 4, 1, '1', 0, 0, '', '10:40:00', '11:10:00', 'monday', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `timetable_exam`
--

CREATE TABLE `timetable_exam` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `time_start` varchar(20) NOT NULL,
  `time_end` varchar(20) NOT NULL,
  `mark_distribution` text NOT NULL,
  `hall_id` int(11) NOT NULL,
  `exam_date` date NOT NULL,
  `branch_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `timetable_exam`
--

INSERT INTO `timetable_exam` (`id`, `exam_id`, `class_id`, `section_id`, `subject_id`, `time_start`, `time_end`, `mark_distribution`, `hall_id`, `exam_date`, `branch_id`, `session_id`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 1, 1, '9:00 AM', '12:00 PM', '{\"2\":{\"full_mark\":\"30\",\"pass_mark\":\"15\"},\"3\":{\"full_mark\":\"80\",\"pass_mark\":\"40\"}}', 1, '2026-04-02', 1, 3, '2026-04-02 14:49:14', NULL),
(2, 1, 4, 1, 2, '9:00 AM', '12:00 PM', '{\"2\":{\"full_mark\":\"30\",\"pass_mark\":\"15\"},\"3\":{\"full_mark\":\"80\",\"pass_mark\":\"40\"}}', 1, '2026-04-06', 1, 3, '2026-04-02 14:49:14', NULL),
(3, 1, 4, 1, 3, '9:00 AM', '12:00 PM', '{\"2\":{\"full_mark\":\"30\",\"pass_mark\":\"15\"},\"3\":{\"full_mark\":\"80\",\"pass_mark\":\"40\"}}', 1, '2026-04-08', 1, 3, '2026-04-02 14:49:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `account_id` varchar(20) NOT NULL,
  `voucher_head_id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `category` varchar(20) NOT NULL,
  `ref` varchar(255) NOT NULL,
  `amount` decimal(18,2) NOT NULL DEFAULT 0.00,
  `dr` decimal(18,2) NOT NULL DEFAULT 0.00,
  `cr` decimal(18,2) NOT NULL DEFAULT 0.00,
  `bal` decimal(18,2) NOT NULL DEFAULT 0.00,
  `date` date NOT NULL,
  `pay_via` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `attachments` varchar(255) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `system` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions_links`
--

CREATE TABLE `transactions_links` (
  `id` int(11) NOT NULL,
  `status` tinyint(3) DEFAULT NULL,
  `deposit` tinyint(3) DEFAULT NULL,
  `expense` tinyint(3) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions_links_details`
--

CREATE TABLE `transactions_links_details` (
  `id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `transactions_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transport_assign`
--

CREATE TABLE `transport_assign` (
  `id` int(11) NOT NULL,
  `route_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transport_fee_details`
--

CREATE TABLE `transport_fee_details` (
  `id` int(11) NOT NULL,
  `month` varchar(2) DEFAULT NULL,
  `transport_fee_fine_id` int(11) DEFAULT NULL,
  `enroll_id` int(11) NOT NULL,
  `stoppage_point_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transport_fee_fine`
--

CREATE TABLE `transport_fee_fine` (
  `id` int(11) NOT NULL,
  `month` varchar(2) NOT NULL,
  `due_date` date NOT NULL,
  `fine_value` varchar(20) DEFAULT NULL,
  `fine_type` varchar(20) DEFAULT NULL,
  `fee_frequency` varchar(20) DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transport_route`
--

CREATE TABLE `transport_route` (
  `id` int(11) NOT NULL,
  `name` longtext NOT NULL,
  `start_place` longtext NOT NULL,
  `remarks` longtext NOT NULL,
  `stop_place` longtext NOT NULL,
  `branch_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transport_stoppage`
--

CREATE TABLE `transport_stoppage` (
  `id` int(11) NOT NULL,
  `stop_position` varchar(255) NOT NULL,
  `stop_time` time NOT NULL,
  `route_fare` decimal(18,2) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transport_stoppage_point`
--

CREATE TABLE `transport_stoppage_point` (
  `id` int(11) NOT NULL,
  `route_id` int(11) NOT NULL,
  `stoppage_id` int(11) NOT NULL,
  `route_fare` decimal(18,2) DEFAULT NULL,
  `stop_time` time DEFAULT NULL,
  `order_no` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transport_vehicle`
--

CREATE TABLE `transport_vehicle` (
  `id` int(11) NOT NULL,
  `vehicle_no` longtext NOT NULL,
  `capacity` longtext NOT NULL,
  `insurance_renewal` longtext NOT NULL,
  `driver_name` longtext NOT NULL,
  `driver_phone` longtext NOT NULL,
  `driver_license` longtext NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visitor_log`
--

CREATE TABLE `visitor_log` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `number` varchar(255) DEFAULT NULL,
  `purpose_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `entry_time` time DEFAULT NULL,
  `exit_time` time DEFAULT NULL,
  `number_of_visitor` float DEFAULT NULL,
  `id_number` varchar(255) DEFAULT NULL,
  `token_pass` varchar(255) DEFAULT NULL,
  `note` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visitor_purpose`
--

CREATE TABLE `visitor_purpose` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `visitor_purpose`
--

INSERT INTO `visitor_purpose` (`id`, `name`, `branch_id`) VALUES
(1, 'Seminer', 1),
(2, 'Event', 1),
(3, 'Sports', 1),
(4, 'Government', 1),
(5, 'General', 1),
(6, 'To meet the child', 1);

-- --------------------------------------------------------

--
-- Table structure for table `voucher_head`
--

CREATE TABLE `voucher_head` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL,
  `system` tinyint(1) DEFAULT 0,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `voucher_head`
--

INSERT INTO `voucher_head` (`id`, `name`, `type`, `system`, `branch_id`) VALUES
(1, 'Salary payments', 'expense', 0, 1),
(2, 'Electricity bills', 'expense', 0, 1),
(3, 'Office Rent', 'income', 0, 1),
(4, 'Student Fees Collection', 'income', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `whatsapp_agent`
--

CREATE TABLE `whatsapp_agent` (
  `id` int(11) NOT NULL,
  `agent_name` varchar(255) NOT NULL,
  `agent_image` varchar(255) NOT NULL,
  `agent_designation` varchar(255) NOT NULL,
  `whataspp_number` varchar(255) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `weekend` varchar(20) DEFAULT NULL,
  `enable` tinyint(1) NOT NULL DEFAULT 1,
  `branch_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `whatsapp_chat`
--

CREATE TABLE `whatsapp_chat` (
  `id` int(11) NOT NULL,
  `header_title` varchar(255) NOT NULL,
  `subtitle` varchar(355) DEFAULT NULL,
  `footer_text` varchar(255) DEFAULT NULL,
  `popup_message` varchar(255) DEFAULT NULL,
  `frontend_enable_chat` tinyint(1) NOT NULL DEFAULT 0,
  `backend_enable_chat` tinyint(1) NOT NULL DEFAULT 0,
  `branch_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `whatsapp_chat`
--

INSERT INTO `whatsapp_chat` (`id`, `header_title`, `subtitle`, `footer_text`, `popup_message`, `frontend_enable_chat`, `backend_enable_chat`, `branch_id`, `created_at`) VALUES
(1, 'Start a Conversation', 'Start a Conversation', 'Use this feature to chat with our agent.', NULL, 1, 1, 1, '2026-02-18 13:49:13'),
(2, 'Conversation', 'Hi! Click one of our members below to chat on WhatsApp ;)', 'Use this feature to chat with our agent.', NULL, 1, 1, 2, '2026-02-18 13:49:13');

-- --------------------------------------------------------

--
-- Table structure for table `zoom_own_api`
--

CREATE TABLE `zoom_own_api` (
  `id` int(11) NOT NULL,
  `user_type` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `zoom_api_key` varchar(255) NOT NULL,
  `zoom_api_secret` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accounts_rms_1` (`branch_id`);

--
-- Indexes for table `addon`
--
ALTER TABLE `addon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `advance_salary`
--
ALTER TABLE `advance_salary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `advance_salary_rms_1` (`branch_id`),
  ADD KEY `advance_salary_rms_2` (`staff_id`);

--
-- Indexes for table `alumni_events`
--
ALTER TABLE `alumni_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `alumni_events_rms_1` (`branch_id`);

--
-- Indexes for table `alumni_students`
--
ALTER TABLE `alumni_students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alumni_students_rms_1` (`enroll_id`);

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attachments_rms_1` (`session_id`),
  ADD KEY `attachments_rms_2` (`branch_id`);

--
-- Indexes for table `attachments_type`
--
ALTER TABLE `attachments_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attachments_type_rms_1` (`branch_id`);

--
-- Indexes for table `award`
--
ALTER TABLE `award`
  ADD PRIMARY KEY (`id`),
  ADD KEY `award_rms_1` (`branch_id`),
  ADD KEY `award_rms_2` (`session_id`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_rms_1` (`branch_id`);

--
-- Indexes for table `book_category`
--
ALTER TABLE `book_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_category_rms_1` (`branch_id`);

--
-- Indexes for table `book_issues`
--
ALTER TABLE `book_issues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_issues_rms1` (`branch_id`),
  ADD KEY `book_issues_rms2` (`book_id`),
  ADD KEY `book_issues_rms3` (`session_id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bulk_msg_category`
--
ALTER TABLE `bulk_msg_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bulk_msg_category_rms_1` (`branch_id`);

--
-- Indexes for table `bulk_sms_email`
--
ALTER TABLE `bulk_sms_email`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bulk_sms_email_rms_1` (`branch_id`);

--
-- Indexes for table `call_log`
--
ALTER TABLE `call_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `call_log_rms_1` (`branch_id`);

--
-- Indexes for table `call_purpose`
--
ALTER TABLE `call_purpose`
  ADD PRIMARY KEY (`id`),
  ADD KEY `call_purpose_rms_1` (`branch_id`);

--
-- Indexes for table `card_templete`
--
ALTER TABLE `card_templete`
  ADD PRIMARY KEY (`id`),
  ADD KEY `card_templete_rms_1` (`branch_id`);

--
-- Indexes for table `certificates_templete`
--
ALTER TABLE `certificates_templete`
  ADD PRIMARY KEY (`id`),
  ADD KEY `certificates_templete_rms_1` (`branch_id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_rms_1` (`branch_id`);

--
-- Indexes for table `complaint`
--
ALTER TABLE `complaint`
  ADD PRIMARY KEY (`id`),
  ADD KEY `complaint_rms_1` (`branch_id`);

--
-- Indexes for table `complaint_type`
--
ALTER TABLE `complaint_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `complaint_type_rms_1` (`branch_id`);

--
-- Indexes for table `custom_field`
--
ALTER TABLE `custom_field`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_fields_online_values`
--
ALTER TABLE `custom_fields_online_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `relid` (`relid`),
  ADD KEY `fieldid` (`field_id`);

--
-- Indexes for table `custom_fields_values`
--
ALTER TABLE `custom_fields_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `relid` (`relid`),
  ADD KEY `fieldid` (`field_id`);

--
-- Indexes for table `disable_reason`
--
ALTER TABLE `disable_reason`
  ADD PRIMARY KEY (`id`),
  ADD KEY `disable_reason_rms_1` (`branch_id`);

--
-- Indexes for table `disable_reason_details`
--
ALTER TABLE `disable_reason_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `education_board`
--
ALTER TABLE `education_board`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_config`
--
ALTER TABLE `email_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_templates_details`
--
ALTER TABLE `email_templates_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enquiry`
--
ALTER TABLE `enquiry`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enquiry_rms_1` (`branch_id`);

--
-- Indexes for table `enquiry_follow_up`
--
ALTER TABLE `enquiry_follow_up`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enquiry_follow_up_rms_1` (`enquiry_id`);

--
-- Indexes for table `enquiry_reference`
--
ALTER TABLE `enquiry_reference`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enquiry_reference_rms_1` (`branch_id`);

--
-- Indexes for table `enquiry_response`
--
ALTER TABLE `enquiry_response`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enquiry_response_rms_1` (`branch_id`);

--
-- Indexes for table `enroll`
--
ALTER TABLE `enroll`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enroll_rms_1` (`student_id`),
  ADD KEY `enroll_rms_2` (`session_id`),
  ADD KEY `enroll_rms_3` (`class_id`),
  ADD KEY `enroll_rms_4` (`section_id`),
  ADD KEY `enroll_rms_5` (`branch_id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_rms_1` (`branch_id`),
  ADD KEY `event_rms_2` (`session_id`);

--
-- Indexes for table `event_types`
--
ALTER TABLE `event_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_types_rms_1` (`branch_id`);

--
-- Indexes for table `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_rms_1` (`branch_id`),
  ADD KEY `exam_rms_2` (`session_id`);

--
-- Indexes for table `exam_attendance`
--
ALTER TABLE `exam_attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_attendance_rms_1` (`branch_id`),
  ADD KEY `exam_attendance_rms_2` (`exam_id`),
  ADD KEY `exam_attendance_rms_3` (`student_id`);

--
-- Indexes for table `exam_hall`
--
ALTER TABLE `exam_hall`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_hall_rms_1` (`branch_id`);

--
-- Indexes for table `exam_mark_distribution`
--
ALTER TABLE `exam_mark_distribution`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_mark_distribution_rms_1` (`branch_id`);

--
-- Indexes for table `exam_rank`
--
ALTER TABLE `exam_rank`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_group_class_batch_exam_id` (`exam_id`),
  ADD KEY `student_id` (`enroll_id`);

--
-- Indexes for table `exam_term`
--
ALTER TABLE `exam_term`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fees_reminder`
--
ALTER TABLE `fees_reminder`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fees_reminder_rms_1` (`branch_id`);

--
-- Indexes for table `fees_type`
--
ALTER TABLE `fees_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fee_allocation`
--
ALTER TABLE `fee_allocation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fee_allocation_rsm_1` (`student_id`),
  ADD KEY `fee_allocation_rsm_2` (`branch_id`),
  ADD KEY `fee_allocation_rsm_3` (`session_id`);

--
-- Indexes for table `fee_fine`
--
ALTER TABLE `fee_fine`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fee_fine_rms_2` (`group_id`),
  ADD KEY `fee_fine_rms_3` (`session_id`),
  ADD KEY `fee_fine_rms_4` (`branch_id`);

--
-- Indexes for table `fee_groups`
--
ALTER TABLE `fee_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fee_groups_rms_1` (`branch_id`),
  ADD KEY `fee_groups_rms_2` (`session_id`);

--
-- Indexes for table `fee_groups_details`
--
ALTER TABLE `fee_groups_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fee_groups_details_rms_1` (`fee_groups_id`),
  ADD KEY `fee_groups_details_rms_2` (`fee_type_id`);

--
-- Indexes for table `fee_payment_history`
--
ALTER TABLE `fee_payment_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fee_payment_history_rms_1` (`allocation_id`),
  ADD KEY `fee_payment_history_rms_2` (`type_id`);

--
-- Indexes for table `front_cms_about`
--
ALTER TABLE `front_cms_about`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `front_cms_admission`
--
ALTER TABLE `front_cms_admission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `front_cms_admitcard`
--
ALTER TABLE `front_cms_admitcard`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `front_cms_certificates`
--
ALTER TABLE `front_cms_certificates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `front_cms_contact`
--
ALTER TABLE `front_cms_contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `front_cms_events`
--
ALTER TABLE `front_cms_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `front_cms_exam_results`
--
ALTER TABLE `front_cms_exam_results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `front_cms_faq`
--
ALTER TABLE `front_cms_faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `front_cms_faq_list`
--
ALTER TABLE `front_cms_faq_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `front_cms_gallery`
--
ALTER TABLE `front_cms_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `front_cms_gallery_category`
--
ALTER TABLE `front_cms_gallery_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `front_cms_gallery_content`
--
ALTER TABLE `front_cms_gallery_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `front_cms_home`
--
ALTER TABLE `front_cms_home`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `front_cms_home_seo`
--
ALTER TABLE `front_cms_home_seo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `front_cms_menu`
--
ALTER TABLE `front_cms_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `front_cms_menu_visible`
--
ALTER TABLE `front_cms_menu_visible`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `front_cms_news`
--
ALTER TABLE `front_cms_news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `front_cms_news_list`
--
ALTER TABLE `front_cms_news_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `front_cms_news_list_rms_1` (`branch_id`);

--
-- Indexes for table `front_cms_pages`
--
ALTER TABLE `front_cms_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `front_cms_services`
--
ALTER TABLE `front_cms_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `front_cms_services_list`
--
ALTER TABLE `front_cms_services_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `front_cms_setting`
--
ALTER TABLE `front_cms_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `front_cms_teachers`
--
ALTER TABLE `front_cms_teachers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `front_cms_testimonial`
--
ALTER TABLE `front_cms_testimonial`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `global_settings`
--
ALTER TABLE `global_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grade`
--
ALTER TABLE `grade`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grade_rms_1` (`branch_id`);

--
-- Indexes for table `hall_allocation`
--
ALTER TABLE `hall_allocation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homework`
--
ALTER TABLE `homework`
  ADD PRIMARY KEY (`id`),
  ADD KEY `homework_rms_1` (`branch_id`),
  ADD KEY `homework_rms_2` (`class_id`),
  ADD KEY `homework_rms_3` (`section_id`),
  ADD KEY `homework_rms_4` (`session_id`),
  ADD KEY `homework_rms_5` (`subject_id`);

--
-- Indexes for table `homework_evaluation`
--
ALTER TABLE `homework_evaluation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `homework_evaluation_rms_1` (`homework_id`);

--
-- Indexes for table `homework_submit`
--
ALTER TABLE `homework_submit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `homework_submit_rms_1` (`homework_id`),
  ADD KEY `homework_submit_rms_2` (`student_id`);

--
-- Indexes for table `hostel`
--
ALTER TABLE `hostel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hostel_rms_1` (`branch_id`);

--
-- Indexes for table `hostel_category`
--
ALTER TABLE `hostel_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hostel_room`
--
ALTER TABLE `hostel_room`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `infrastructure`
--
ALTER TABLE `infrastructure`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_branch` (`branch_id`),
  ADD KEY `idx_condition` (`condition`);

--
-- Indexes for table `inspection_deficiencies`
--
ALTER TABLE `inspection_deficiencies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inspection_id` (`inspection_id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language_list`
--
ALTER TABLE `language_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_application`
--
ALTER TABLE `leave_application`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_category`
--
ALTER TABLE `leave_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `live_class`
--
ALTER TABLE `live_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `live_class_config`
--
ALTER TABLE `live_class_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `live_class_reports`
--
ALTER TABLE `live_class_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_credential`
--
ALTER TABLE `login_credential`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_log`
--
ALTER TABLE `login_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `login_log_rms_1` (`branch_id`);

--
-- Indexes for table `mark`
--
ALTER TABLE `mark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marksheet_template`
--
ALTER TABLE `marksheet_template`
  ADD PRIMARY KEY (`id`),
  ADD KEY `certificates_templete_rms_1` (`branch_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_reply`
--
ALTER TABLE `message_reply`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules_manage`
--
ALTER TABLE `modules_manage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `offline_fees_payments`
--
ALTER TABLE `offline_fees_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_fees_master_id` (`fees_allocation_id`),
  ADD KEY `fee_groups_feetype_id` (`fees_type_id`),
  ADD KEY `offline_fees_payments_ibfk_4` (`approved_by`),
  ADD KEY `student_session_id` (`student_enroll_id`);

--
-- Indexes for table `offline_payment_types`
--
ALTER TABLE `offline_payment_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `online_admission`
--
ALTER TABLE `online_admission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `online_admission_rms_1` (`branch_id`);

--
-- Indexes for table `online_admission_fields`
--
ALTER TABLE `online_admission_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `online_exam`
--
ALTER TABLE `online_exam`
  ADD PRIMARY KEY (`id`),
  ADD KEY `session_id` (`session_id`);

--
-- Indexes for table `online_exam_answer`
--
ALTER TABLE `online_exam_answer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `online_exam_attempts`
--
ALTER TABLE `online_exam_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `online_exam_payment`
--
ALTER TABLE `online_exam_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `online_exam_submitted`
--
ALTER TABLE `online_exam_submitted`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parent`
--
ALTER TABLE `parent`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_config`
--
ALTER TABLE `payment_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_salary_stipend`
--
ALTER TABLE `payment_salary_stipend`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_types`
--
ALTER TABLE `payment_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payslip`
--
ALTER TABLE `payslip`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payslip_details`
--
ALTER TABLE `payslip_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_modules`
--
ALTER TABLE `permission_modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `postal_record`
--
ALTER TABLE `postal_record`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_rms_1` (`branch_id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_category_rms_1` (`branch_id`);

--
-- Indexes for table `product_issues`
--
ALTER TABLE `product_issues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_issues_rms_1` (`branch_id`);

--
-- Indexes for table `product_issues_details`
--
ALTER TABLE `product_issues_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_issues_details_rms_1` (`product_id`);

--
-- Indexes for table `product_store`
--
ALTER TABLE `product_store`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_supplier`
--
ALTER TABLE `product_supplier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_supplier_rms_1` (`branch_id`);

--
-- Indexes for table `product_unit`
--
ALTER TABLE `product_unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promotion_history`
--
ALTER TABLE `promotion_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promotion_history_rms_1` (`student_id`);

--
-- Indexes for table `purchase_bill`
--
ALTER TABLE `purchase_bill`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_bill_rms_1` (`branch_id`);

--
-- Indexes for table `purchase_bill_details`
--
ALTER TABLE `purchase_bill_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_bill_details_rms_1` (`product_id`);

--
-- Indexes for table `purchase_payment_history`
--
ALTER TABLE `purchase_payment_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions_manage`
--
ALTER TABLE `questions_manage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `onlineexam_id` (`onlineexam_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `question_group`
--
ALTER TABLE `question_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rm_sessions`
--
ALTER TABLE `rm_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary_template`
--
ALTER TABLE `salary_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary_template_details`
--
ALTER TABLE `salary_template_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_bill`
--
ALTER TABLE `sales_bill`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_bill_rms_1` (`branch_id`);

--
-- Indexes for table `sales_bill_details`
--
ALTER TABLE `sales_bill_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_bill_details_rms_1` (`product_id`);

--
-- Indexes for table `sales_payment_history`
--
ALTER TABLE `sales_payment_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schoolyear`
--
ALTER TABLE `schoolyear`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school_inspections`
--
ALTER TABLE `school_inspections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sections_allocation`
--
ALTER TABLE `sections_allocation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sections_allocation_rms_1` (`class_id`),
  ADD KEY `sections_allocation_rms_2` (`section_id`);

--
-- Indexes for table `sms_api`
--
ALTER TABLE `sms_api`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_credential`
--
ALTER TABLE `sms_credential`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_template`
--
ALTER TABLE `sms_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_template_details`
--
ALTER TABLE `sms_template_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_attendance`
--
ALTER TABLE `staff_attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_attendance_rms_1` (`branch_id`),
  ADD KEY `staff_attendance_rms_2` (`staff_id`);

--
-- Indexes for table `staff_bank_account`
--
ALTER TABLE `staff_bank_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_department`
--
ALTER TABLE `staff_department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_designation`
--
ALTER TABLE `staff_designation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_documents`
--
ALTER TABLE `staff_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_posting_history`
--
ALTER TABLE `staff_posting_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `staff_privileges`
--
ALTER TABLE `staff_privileges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_state_student_id` (`state_student_id`);

--
-- Indexes for table `student_admission_fields`
--
ALTER TABLE `student_admission_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_attendance`
--
ALTER TABLE `student_attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_attendance_rms_1` (`branch_id`),
  ADD KEY `student_attendance_rms_2` (`enroll_id`);

--
-- Indexes for table `student_category`
--
ALTER TABLE `student_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_documents`
--
ALTER TABLE `student_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_fields`
--
ALTER TABLE `student_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_profile_fields`
--
ALTER TABLE `student_profile_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_subject_attendance`
--
ALTER TABLE `student_subject_attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendence_type_id` (`status`),
  ADD KEY `student_session_id` (`enroll_id`),
  ADD KEY `subject_timetable_id` (`subject_timetable_id`),
  ADD KEY `student_subject_attendance_rms_1` (`branch_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject_assign`
--
ALTER TABLE `subject_assign`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_assign_rms_1` (`branch_id`),
  ADD KEY `subject_assign_rms_2` (`session_id`),
  ADD KEY `subject_assign_rms_3` (`class_id`),
  ADD KEY `subject_assign_rms_4` (`section_id`),
  ADD KEY `subject_assign_rms_5` (`subject_id`);

--
-- Indexes for table `teacher_allocation`
--
ALTER TABLE `teacher_allocation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_note`
--
ALTER TABLE `teacher_note`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_transfers`
--
ALTER TABLE `teacher_transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `theme_settings`
--
ALTER TABLE `theme_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timetable_class`
--
ALTER TABLE `timetable_class`
  ADD PRIMARY KEY (`id`),
  ADD KEY `timetable_class_rms_1` (`branch_id`),
  ADD KEY `timetable_class_rms_2` (`class_id`),
  ADD KEY `timetable_class_rms_3` (`section_id`),
  ADD KEY `timetable_class_rms_4` (`session_id`);

--
-- Indexes for table `timetable_exam`
--
ALTER TABLE `timetable_exam`
  ADD PRIMARY KEY (`id`),
  ADD KEY `timetable_exam_rms_1` (`branch_id`),
  ADD KEY `timetable_exam_rms_2` (`exam_id`),
  ADD KEY `timetable_exam_rms_3` (`class_id`),
  ADD KEY `timetable_exam_rms_4` (`section_id`),
  ADD KEY `timetable_exam_rms_5` (`session_id`),
  ADD KEY `timetable_exam_rms_6` (`subject_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_rms_1` (`branch_id`);

--
-- Indexes for table `transactions_links`
--
ALTER TABLE `transactions_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_links_rms_1` (`branch_id`);

--
-- Indexes for table `transactions_links_details`
--
ALTER TABLE `transactions_links_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transport_assign`
--
ALTER TABLE `transport_assign`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transport_assign_rms_1` (`branch_id`);

--
-- Indexes for table `transport_fee_details`
--
ALTER TABLE `transport_fee_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transport_fee_details_rms_1` (`stoppage_point_id`),
  ADD KEY `transport_fee_details_rms_2` (`enroll_id`);

--
-- Indexes for table `transport_fee_fine`
--
ALTER TABLE `transport_fee_fine`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fee_fine_rms_2` (`month`),
  ADD KEY `fee_fine_rms_3` (`session_id`),
  ADD KEY `fee_fine_rms_4` (`branch_id`);

--
-- Indexes for table `transport_route`
--
ALTER TABLE `transport_route`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transport_route_rms_1` (`branch_id`);

--
-- Indexes for table `transport_stoppage`
--
ALTER TABLE `transport_stoppage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transport_stoppage_rms_1` (`branch_id`);

--
-- Indexes for table `transport_stoppage_point`
--
ALTER TABLE `transport_stoppage_point`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transport_assign_rms_1` (`branch_id`),
  ADD KEY `transport_stoppage_point_rms_1` (`route_id`),
  ADD KEY `transport_stoppage_point_rms_3` (`session_id`);

--
-- Indexes for table `transport_vehicle`
--
ALTER TABLE `transport_vehicle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transport_vehicle_rms_1` (`branch_id`);

--
-- Indexes for table `visitor_log`
--
ALTER TABLE `visitor_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visitor_log_rms_1` (`branch_id`);

--
-- Indexes for table `visitor_purpose`
--
ALTER TABLE `visitor_purpose`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visitor_purpose_rms_1` (`branch_id`);

--
-- Indexes for table `voucher_head`
--
ALTER TABLE `voucher_head`
  ADD PRIMARY KEY (`id`),
  ADD KEY `voucher_head_rms_1` (`branch_id`);

--
-- Indexes for table `whatsapp_agent`
--
ALTER TABLE `whatsapp_agent`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `whatsapp_chat`
--
ALTER TABLE `whatsapp_chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zoom_own_api`
--
ALTER TABLE `zoom_own_api`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `addon`
--
ALTER TABLE `addon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `advance_salary`
--
ALTER TABLE `advance_salary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `alumni_events`
--
ALTER TABLE `alumni_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `alumni_students`
--
ALTER TABLE `alumni_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attachments_type`
--
ALTER TABLE `attachments_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `award`
--
ALTER TABLE `award`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `book_category`
--
ALTER TABLE `book_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `book_issues`
--
ALTER TABLE `book_issues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `bulk_msg_category`
--
ALTER TABLE `bulk_msg_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bulk_sms_email`
--
ALTER TABLE `bulk_sms_email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `call_log`
--
ALTER TABLE `call_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `call_purpose`
--
ALTER TABLE `call_purpose`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `card_templete`
--
ALTER TABLE `card_templete`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `certificates_templete`
--
ALTER TABLE `certificates_templete`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `complaint`
--
ALTER TABLE `complaint`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `complaint_type`
--
ALTER TABLE `complaint_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `custom_field`
--
ALTER TABLE `custom_field`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_fields_online_values`
--
ALTER TABLE `custom_fields_online_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `custom_fields_values`
--
ALTER TABLE `custom_fields_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `disable_reason`
--
ALTER TABLE `disable_reason`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `disable_reason_details`
--
ALTER TABLE `disable_reason_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `education_board`
--
ALTER TABLE `education_board`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `email_config`
--
ALTER TABLE `email_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `email_templates_details`
--
ALTER TABLE `email_templates_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enquiry`
--
ALTER TABLE `enquiry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enquiry_follow_up`
--
ALTER TABLE `enquiry_follow_up`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enquiry_reference`
--
ALTER TABLE `enquiry_reference`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enquiry_response`
--
ALTER TABLE `enquiry_response`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `enroll`
--
ALTER TABLE `enroll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_types`
--
ALTER TABLE `event_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `exam`
--
ALTER TABLE `exam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `exam_attendance`
--
ALTER TABLE `exam_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_hall`
--
ALTER TABLE `exam_hall`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `exam_mark_distribution`
--
ALTER TABLE `exam_mark_distribution`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `exam_rank`
--
ALTER TABLE `exam_rank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_term`
--
ALTER TABLE `exam_term`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `fees_reminder`
--
ALTER TABLE `fees_reminder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fees_type`
--
ALTER TABLE `fees_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `fee_allocation`
--
ALTER TABLE `fee_allocation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fee_fine`
--
ALTER TABLE `fee_fine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fee_groups`
--
ALTER TABLE `fee_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fee_groups_details`
--
ALTER TABLE `fee_groups_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fee_payment_history`
--
ALTER TABLE `fee_payment_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `front_cms_about`
--
ALTER TABLE `front_cms_about`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `front_cms_admission`
--
ALTER TABLE `front_cms_admission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `front_cms_admitcard`
--
ALTER TABLE `front_cms_admitcard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `front_cms_certificates`
--
ALTER TABLE `front_cms_certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `front_cms_contact`
--
ALTER TABLE `front_cms_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `front_cms_events`
--
ALTER TABLE `front_cms_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `front_cms_exam_results`
--
ALTER TABLE `front_cms_exam_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `front_cms_faq`
--
ALTER TABLE `front_cms_faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `front_cms_faq_list`
--
ALTER TABLE `front_cms_faq_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `front_cms_gallery`
--
ALTER TABLE `front_cms_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `front_cms_gallery_category`
--
ALTER TABLE `front_cms_gallery_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `front_cms_gallery_content`
--
ALTER TABLE `front_cms_gallery_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `front_cms_home`
--
ALTER TABLE `front_cms_home`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `front_cms_home_seo`
--
ALTER TABLE `front_cms_home_seo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `front_cms_menu`
--
ALTER TABLE `front_cms_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `front_cms_menu_visible`
--
ALTER TABLE `front_cms_menu_visible`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `front_cms_news`
--
ALTER TABLE `front_cms_news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `front_cms_news_list`
--
ALTER TABLE `front_cms_news_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `front_cms_pages`
--
ALTER TABLE `front_cms_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `front_cms_services`
--
ALTER TABLE `front_cms_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `front_cms_services_list`
--
ALTER TABLE `front_cms_services_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `front_cms_setting`
--
ALTER TABLE `front_cms_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `front_cms_teachers`
--
ALTER TABLE `front_cms_teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `front_cms_testimonial`
--
ALTER TABLE `front_cms_testimonial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `global_settings`
--
ALTER TABLE `global_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `grade`
--
ALTER TABLE `grade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `hall_allocation`
--
ALTER TABLE `hall_allocation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `homework`
--
ALTER TABLE `homework`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `homework_evaluation`
--
ALTER TABLE `homework_evaluation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `homework_submit`
--
ALTER TABLE `homework_submit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hostel`
--
ALTER TABLE `hostel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hostel_category`
--
ALTER TABLE `hostel_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hostel_room`
--
ALTER TABLE `hostel_room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `infrastructure`
--
ALTER TABLE `infrastructure`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inspection_deficiencies`
--
ALTER TABLE `inspection_deficiencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1374;

--
-- AUTO_INCREMENT for table `language_list`
--
ALTER TABLE `language_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `leave_application`
--
ALTER TABLE `leave_application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_category`
--
ALTER TABLE `leave_category`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `live_class`
--
ALTER TABLE `live_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `live_class_config`
--
ALTER TABLE `live_class_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `live_class_reports`
--
ALTER TABLE `live_class_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_credential`
--
ALTER TABLE `login_credential`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `login_log`
--
ALTER TABLE `login_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `mark`
--
ALTER TABLE `mark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `marksheet_template`
--
ALTER TABLE `marksheet_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message_reply`
--
ALTER TABLE `message_reply`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `modules_manage`
--
ALTER TABLE `modules_manage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `offline_fees_payments`
--
ALTER TABLE `offline_fees_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offline_payment_types`
--
ALTER TABLE `offline_payment_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_admission`
--
ALTER TABLE `online_admission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_admission_fields`
--
ALTER TABLE `online_admission_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_exam`
--
ALTER TABLE `online_exam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_exam_answer`
--
ALTER TABLE `online_exam_answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_exam_attempts`
--
ALTER TABLE `online_exam_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_exam_payment`
--
ALTER TABLE `online_exam_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_exam_submitted`
--
ALTER TABLE `online_exam_submitted`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parent`
--
ALTER TABLE `parent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_config`
--
ALTER TABLE `payment_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_salary_stipend`
--
ALTER TABLE `payment_salary_stipend`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_types`
--
ALTER TABLE `payment_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `payslip`
--
ALTER TABLE `payslip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payslip_details`
--
ALTER TABLE `payslip_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;

--
-- AUTO_INCREMENT for table `permission_modules`
--
ALTER TABLE `permission_modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `postal_record`
--
ALTER TABLE `postal_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;

--
-- AUTO_INCREMENT for table `product_issues`
--
ALTER TABLE `product_issues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_issues_details`
--
ALTER TABLE `product_issues_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_store`
--
ALTER TABLE `product_store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `product_supplier`
--
ALTER TABLE `product_supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_unit`
--
ALTER TABLE `product_unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `promotion_history`
--
ALTER TABLE `promotion_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_bill`
--
ALTER TABLE `purchase_bill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_bill_details`
--
ALTER TABLE `purchase_bill_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_payment_history`
--
ALTER TABLE `purchase_payment_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions_manage`
--
ALTER TABLE `questions_manage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `question_group`
--
ALTER TABLE `question_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `salary_template`
--
ALTER TABLE `salary_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `salary_template_details`
--
ALTER TABLE `salary_template_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sales_bill`
--
ALTER TABLE `sales_bill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_bill_details`
--
ALTER TABLE `sales_bill_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_payment_history`
--
ALTER TABLE `sales_payment_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schoolyear`
--
ALTER TABLE `schoolyear`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `school_inspections`
--
ALTER TABLE `school_inspections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `sections_allocation`
--
ALTER TABLE `sections_allocation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `sms_api`
--
ALTER TABLE `sms_api`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sms_credential`
--
ALTER TABLE `sms_credential`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sms_template`
--
ALTER TABLE `sms_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sms_template_details`
--
ALTER TABLE `sms_template_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `staff_attendance`
--
ALTER TABLE `staff_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `staff_bank_account`
--
ALTER TABLE `staff_bank_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staff_department`
--
ALTER TABLE `staff_department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `staff_designation`
--
ALTER TABLE `staff_designation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `staff_documents`
--
ALTER TABLE `staff_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_posting_history`
--
ALTER TABLE `staff_posting_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staff_privileges`
--
ALTER TABLE `staff_privileges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=980;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student_admission_fields`
--
ALTER TABLE `student_admission_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_attendance`
--
ALTER TABLE `student_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_category`
--
ALTER TABLE `student_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `student_documents`
--
ALTER TABLE `student_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_fields`
--
ALTER TABLE `student_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `student_profile_fields`
--
ALTER TABLE `student_profile_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_subject_attendance`
--
ALTER TABLE `student_subject_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `subject_assign`
--
ALTER TABLE `subject_assign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `teacher_allocation`
--
ALTER TABLE `teacher_allocation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `teacher_note`
--
ALTER TABLE `teacher_note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teacher_transfers`
--
ALTER TABLE `teacher_transfers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `theme_settings`
--
ALTER TABLE `theme_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `timetable_class`
--
ALTER TABLE `timetable_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `timetable_exam`
--
ALTER TABLE `timetable_exam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions_links`
--
ALTER TABLE `transactions_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions_links_details`
--
ALTER TABLE `transactions_links_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transport_assign`
--
ALTER TABLE `transport_assign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transport_fee_details`
--
ALTER TABLE `transport_fee_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transport_fee_fine`
--
ALTER TABLE `transport_fee_fine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transport_route`
--
ALTER TABLE `transport_route`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transport_stoppage`
--
ALTER TABLE `transport_stoppage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transport_stoppage_point`
--
ALTER TABLE `transport_stoppage_point`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transport_vehicle`
--
ALTER TABLE `transport_vehicle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visitor_log`
--
ALTER TABLE `visitor_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visitor_purpose`
--
ALTER TABLE `visitor_purpose`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `voucher_head`
--
ALTER TABLE `voucher_head`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `whatsapp_agent`
--
ALTER TABLE `whatsapp_agent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `whatsapp_chat`
--
ALTER TABLE `whatsapp_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `zoom_own_api`
--
ALTER TABLE `zoom_own_api`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `advance_salary`
--
ALTER TABLE `advance_salary`
  ADD CONSTRAINT `advance_salary_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `advance_salary_rms_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `alumni_events`
--
ALTER TABLE `alumni_events`
  ADD CONSTRAINT `alumni_events_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `alumni_students`
--
ALTER TABLE `alumni_students`
  ADD CONSTRAINT `alumni_students_rms_1` FOREIGN KEY (`enroll_id`) REFERENCES `enroll` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attachments`
--
ALTER TABLE `attachments`
  ADD CONSTRAINT `attachments_rms_1` FOREIGN KEY (`session_id`) REFERENCES `schoolyear` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attachments_rms_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attachments_type`
--
ALTER TABLE `attachments_type`
  ADD CONSTRAINT `attachments_type_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `award`
--
ALTER TABLE `award`
  ADD CONSTRAINT `award_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `award_rms_2` FOREIGN KEY (`session_id`) REFERENCES `schoolyear` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `book_issues`
--
ALTER TABLE `book_issues`
  ADD CONSTRAINT `book_issues_rms1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `book_issues_rms2` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `book_issues_rms3` FOREIGN KEY (`session_id`) REFERENCES `schoolyear` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bulk_msg_category`
--
ALTER TABLE `bulk_msg_category`
  ADD CONSTRAINT `bulk_msg_category_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bulk_sms_email`
--
ALTER TABLE `bulk_sms_email`
  ADD CONSTRAINT `bulk_sms_email_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `call_log`
--
ALTER TABLE `call_log`
  ADD CONSTRAINT `call_log_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `call_purpose`
--
ALTER TABLE `call_purpose`
  ADD CONSTRAINT `call_purpose_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `card_templete`
--
ALTER TABLE `card_templete`
  ADD CONSTRAINT `card_templete_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `certificates_templete`
--
ALTER TABLE `certificates_templete`
  ADD CONSTRAINT `certificates_templete_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `complaint`
--
ALTER TABLE `complaint`
  ADD CONSTRAINT `complaint_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `disable_reason`
--
ALTER TABLE `disable_reason`
  ADD CONSTRAINT `disable_reason_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `enquiry`
--
ALTER TABLE `enquiry`
  ADD CONSTRAINT `enquiry_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `enquiry_follow_up`
--
ALTER TABLE `enquiry_follow_up`
  ADD CONSTRAINT `enquiry_follow_up_rms_1` FOREIGN KEY (`enquiry_id`) REFERENCES `enquiry` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `enquiry_reference`
--
ALTER TABLE `enquiry_reference`
  ADD CONSTRAINT `enquiry_reference_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `enquiry_response`
--
ALTER TABLE `enquiry_response`
  ADD CONSTRAINT `enquiry_response_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `enroll`
--
ALTER TABLE `enroll`
  ADD CONSTRAINT `enroll_rms_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enroll_rms_2` FOREIGN KEY (`session_id`) REFERENCES `schoolyear` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enroll_rms_3` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enroll_rms_4` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enroll_rms_5` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_rms_2` FOREIGN KEY (`session_id`) REFERENCES `schoolyear` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exam`
--
ALTER TABLE `exam`
  ADD CONSTRAINT `exam_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_rms_2` FOREIGN KEY (`session_id`) REFERENCES `schoolyear` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exam_attendance`
--
ALTER TABLE `exam_attendance`
  ADD CONSTRAINT `exam_attendance_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_attendance_rms_2` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_attendance_rms_3` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exam_hall`
--
ALTER TABLE `exam_hall`
  ADD CONSTRAINT `exam_hall_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exam_mark_distribution`
--
ALTER TABLE `exam_mark_distribution`
  ADD CONSTRAINT `exam_mark_distribution_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exam_rank`
--
ALTER TABLE `exam_rank`
  ADD CONSTRAINT `exam_rank_rms_1` FOREIGN KEY (`enroll_id`) REFERENCES `enroll` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_rank_rms_2` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fees_reminder`
--
ALTER TABLE `fees_reminder`
  ADD CONSTRAINT `fees_reminder_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fee_allocation`
--
ALTER TABLE `fee_allocation`
  ADD CONSTRAINT `fee_allocation_rsm_1` FOREIGN KEY (`student_id`) REFERENCES `enroll` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fee_allocation_rsm_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fee_allocation_rsm_3` FOREIGN KEY (`session_id`) REFERENCES `schoolyear` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fee_fine`
--
ALTER TABLE `fee_fine`
  ADD CONSTRAINT `fee_fine_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fee_fine_rms_2` FOREIGN KEY (`group_id`) REFERENCES `fee_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fee_fine_rms_3` FOREIGN KEY (`session_id`) REFERENCES `schoolyear` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fee_fine_rms_4` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fee_groups`
--
ALTER TABLE `fee_groups`
  ADD CONSTRAINT `fee_groups_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fee_groups_rms_2` FOREIGN KEY (`session_id`) REFERENCES `schoolyear` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fee_groups_details`
--
ALTER TABLE `fee_groups_details`
  ADD CONSTRAINT `fee_groups_details_rms_1` FOREIGN KEY (`fee_groups_id`) REFERENCES `fee_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fee_groups_details_rms_2` FOREIGN KEY (`fee_type_id`) REFERENCES `fees_type` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fee_payment_history`
--
ALTER TABLE `fee_payment_history`
  ADD CONSTRAINT `fee_payment_history_rms_1` FOREIGN KEY (`allocation_id`) REFERENCES `fee_allocation` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fee_payment_history_rms_2` FOREIGN KEY (`type_id`) REFERENCES `fees_type` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `front_cms_news_list`
--
ALTER TABLE `front_cms_news_list`
  ADD CONSTRAINT `front_cms_news_list_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `homework`
--
ALTER TABLE `homework`
  ADD CONSTRAINT `homework_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `homework_rms_2` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `homework_rms_3` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `homework_rms_4` FOREIGN KEY (`session_id`) REFERENCES `schoolyear` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `homework_rms_5` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `homework_evaluation`
--
ALTER TABLE `homework_evaluation`
  ADD CONSTRAINT `homework_evaluation_rms_1` FOREIGN KEY (`homework_id`) REFERENCES `homework` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `homework_submit`
--
ALTER TABLE `homework_submit`
  ADD CONSTRAINT `homework_submit_rms_1` FOREIGN KEY (`homework_id`) REFERENCES `homework` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `homework_submit_rms_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hostel`
--
ALTER TABLE `hostel`
  ADD CONSTRAINT `hostel_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inspection_deficiencies`
--
ALTER TABLE `inspection_deficiencies`
  ADD CONSTRAINT `inspection_deficiencies_ibfk_1` FOREIGN KEY (`inspection_id`) REFERENCES `school_inspections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `login_log`
--
ALTER TABLE `login_log`
  ADD CONSTRAINT `login_log_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `marksheet_template`
--
ALTER TABLE `marksheet_template`
  ADD CONSTRAINT `marksheet_template_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `online_admission`
--
ALTER TABLE `online_admission`
  ADD CONSTRAINT `online_admission_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_category`
--
ALTER TABLE `product_category`
  ADD CONSTRAINT `product_category_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_issues`
--
ALTER TABLE `product_issues`
  ADD CONSTRAINT `product_issues_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_issues_details`
--
ALTER TABLE `product_issues_details`
  ADD CONSTRAINT `product_issues_details_rms_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_supplier`
--
ALTER TABLE `product_supplier`
  ADD CONSTRAINT `product_supplier_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `promotion_history`
--
ALTER TABLE `promotion_history`
  ADD CONSTRAINT `promotion_history_rms_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_bill`
--
ALTER TABLE `purchase_bill`
  ADD CONSTRAINT `purchase_bill_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_bill_details`
--
ALTER TABLE `purchase_bill_details`
  ADD CONSTRAINT `purchase_bill_details_rms_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sales_bill`
--
ALTER TABLE `sales_bill`
  ADD CONSTRAINT `sales_bill_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sales_bill_details`
--
ALTER TABLE `sales_bill_details`
  ADD CONSTRAINT `sales_bill_details_rms_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sections_allocation`
--
ALTER TABLE `sections_allocation`
  ADD CONSTRAINT `sections_allocation_rms_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sections_allocation_rms_2` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `staff_attendance`
--
ALTER TABLE `staff_attendance`
  ADD CONSTRAINT `staff_attendance_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `staff_attendance_rms_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `staff_posting_history`
--
ALTER TABLE `staff_posting_history`
  ADD CONSTRAINT `staff_posting_history_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_attendance`
--
ALTER TABLE `student_attendance`
  ADD CONSTRAINT `student_attendance_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_attendance_rms_2` FOREIGN KEY (`enroll_id`) REFERENCES `enroll` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_subject_attendance`
--
ALTER TABLE `student_subject_attendance`
  ADD CONSTRAINT `student_subject_attendance_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_subject_attendance_rms_2` FOREIGN KEY (`enroll_id`) REFERENCES `enroll` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subject_assign`
--
ALTER TABLE `subject_assign`
  ADD CONSTRAINT `subject_assign_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subject_assign_rms_2` FOREIGN KEY (`session_id`) REFERENCES `schoolyear` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subject_assign_rms_3` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subject_assign_rms_4` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subject_assign_rms_5` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teacher_transfers`
--
ALTER TABLE `teacher_transfers`
  ADD CONSTRAINT `teacher_transfers_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `timetable_class`
--
ALTER TABLE `timetable_class`
  ADD CONSTRAINT `timetable_class_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `timetable_class_rms_2` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `timetable_class_rms_3` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `timetable_class_rms_4` FOREIGN KEY (`session_id`) REFERENCES `schoolyear` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `timetable_exam`
--
ALTER TABLE `timetable_exam`
  ADD CONSTRAINT `timetable_exam_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `timetable_exam_rms_2` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `timetable_exam_rms_3` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `timetable_exam_rms_4` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `timetable_exam_rms_5` FOREIGN KEY (`session_id`) REFERENCES `schoolyear` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `timetable_exam_rms_6` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions_links`
--
ALTER TABLE `transactions_links`
  ADD CONSTRAINT `transactions_links_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transport_assign`
--
ALTER TABLE `transport_assign`
  ADD CONSTRAINT `transport_assign_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transport_fee_details`
--
ALTER TABLE `transport_fee_details`
  ADD CONSTRAINT `transport_fee_details_rms_2` FOREIGN KEY (`enroll_id`) REFERENCES `enroll` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `transport_route`
--
ALTER TABLE `transport_route`
  ADD CONSTRAINT `transport_route_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transport_stoppage`
--
ALTER TABLE `transport_stoppage`
  ADD CONSTRAINT `transport_stoppage_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transport_stoppage_point`
--
ALTER TABLE `transport_stoppage_point`
  ADD CONSTRAINT `transport_stoppage_point_rms_1` FOREIGN KEY (`route_id`) REFERENCES `transport_route` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `transport_stoppage_point_rms_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `transport_stoppage_point_rms_3` FOREIGN KEY (`session_id`) REFERENCES `schoolyear` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `transport_vehicle`
--
ALTER TABLE `transport_vehicle`
  ADD CONSTRAINT `transport_vehicle_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `visitor_log`
--
ALTER TABLE `visitor_log`
  ADD CONSTRAINT `visitor_log_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `visitor_purpose`
--
ALTER TABLE `visitor_purpose`
  ADD CONSTRAINT `visitor_purpose_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `voucher_head`
--
ALTER TABLE `voucher_head`
  ADD CONSTRAINT `voucher_head_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
