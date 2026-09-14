-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for osx10.10 (x86_64)
--
-- Host: localhost    Database: tahsin
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Import into the hosting database (no CREATE DATABASE).
USE `u663674447_tahsin`;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `balance` double(18,2) NOT NULL DEFAULT 0.00,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `accounts_rms_1` (`branch_id`),
  CONSTRAINT `accounts_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (1,'Access Bank - 0123456789 (Main Account)','0123456789','',0.00,1,'2026-03-27 09:45:42','2026-09-14 04:42:31');
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `addon`
--

DROP TABLE IF EXISTS `addon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `addon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `prefix` varchar(255) NOT NULL,
  `version` varchar(100) NOT NULL,
  `purchase_code` varchar(255) DEFAULT NULL,
  `items_code` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `last_update` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addon`
--

LOCK TABLES `addon` WRITE;
/*!40000 ALTER TABLE `addon` DISABLE KEYS */;
/*!40000 ALTER TABLE `addon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `advance_salary`
--

DROP TABLE IF EXISTS `advance_salary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `advance_salary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `branch_id` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `advance_salary_rms_1` (`branch_id`),
  KEY `advance_salary_rms_2` (`staff_id`),
  CONSTRAINT `advance_salary_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  CONSTRAINT `advance_salary_rms_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `advance_salary`
--

LOCK TABLES `advance_salary` WRITE;
/*!40000 ALTER TABLE `advance_salary` DISABLE KEYS */;
/*!40000 ALTER TABLE `advance_salary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alumni_events`
--

DROP TABLE IF EXISTS `alumni_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alumni_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `session_id` (`session_id`),
  KEY `alumni_events_rms_1` (`branch_id`),
  CONSTRAINT `alumni_events_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumni_events`
--

LOCK TABLES `alumni_events` WRITE;
/*!40000 ALTER TABLE `alumni_events` DISABLE KEYS */;
/*!40000 ALTER TABLE `alumni_events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alumni_students`
--

DROP TABLE IF EXISTS `alumni_students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alumni_students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `enroll_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile_no` varchar(255) NOT NULL,
  `address` varchar(500) NOT NULL,
  `profession` varchar(255) NOT NULL,
  `photo` varchar(500) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `alumni_students_rms_1` (`enroll_id`),
  CONSTRAINT `alumni_students_rms_1` FOREIGN KEY (`enroll_id`) REFERENCES `enroll` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumni_students`
--

LOCK TABLES `alumni_students` WRITE;
/*!40000 ALTER TABLE `alumni_students` DISABLE KEYS */;
/*!40000 ALTER TABLE `alumni_students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attachments`
--

DROP TABLE IF EXISTS `attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attachments_rms_1` (`session_id`),
  KEY `attachments_rms_2` (`branch_id`),
  CONSTRAINT `attachments_rms_1` FOREIGN KEY (`session_id`) REFERENCES `schoolyear` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attachments_rms_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attachments`
--

LOCK TABLES `attachments` WRITE;
/*!40000 ALTER TABLE `attachments` DISABLE KEYS */;
/*!40000 ALTER TABLE `attachments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attachments_type`
--

DROP TABLE IF EXISTS `attachments_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attachments_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attachments_type_rms_1` (`branch_id`),
  CONSTRAINT `attachments_type_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attachments_type`
--

LOCK TABLES `attachments_type` WRITE;
/*!40000 ALTER TABLE `attachments_type` DISABLE KEYS */;
INSERT INTO `attachments_type` VALUES (1,'Note',1,'2026-03-27 08:05:30',NULL),(2,'Assignment',1,'2026-03-27 08:05:36',NULL),(3,'Daily Activity',1,'2026-03-27 08:05:42',NULL),(4,'Hand Book',1,'2026-03-27 08:05:48',NULL),(5,'Syllabus',1,'2026-03-27 08:05:51',NULL);
/*!40000 ALTER TABLE `attachments_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `award`
--

DROP TABLE IF EXISTS `award`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `award` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `gift_item` varchar(255) NOT NULL,
  `award_amount` decimal(18,2) NOT NULL,
  `award_reason` text NOT NULL,
  `given_date` date NOT NULL,
  `session_id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `award_rms_1` (`branch_id`),
  KEY `award_rms_2` (`session_id`),
  CONSTRAINT `award_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  CONSTRAINT `award_rms_2` FOREIGN KEY (`session_id`) REFERENCES `schoolyear` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `award`
--

LOCK TABLES `award` WRITE;
/*!40000 ALTER TABLE `award` DISABLE KEYS */;
/*!40000 ALTER TABLE `award` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book`
--

DROP TABLE IF EXISTS `book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `book_rms_1` (`branch_id`),
  CONSTRAINT `book_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book`
--

LOCK TABLES `book` WRITE;
/*!40000 ALTER TABLE `book` DISABLE KEYS */;
/*!40000 ALTER TABLE `book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book_category`
--

DROP TABLE IF EXISTS `book_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `book_category_rms_1` (`branch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book_category`
--

LOCK TABLES `book_category` WRITE;
/*!40000 ALTER TABLE `book_category` DISABLE KEYS */;
INSERT INTO `book_category` VALUES (1,'History',1),(2,'Science',1),(3,'Programming',1),(4,'Drawing',1);
/*!40000 ALTER TABLE `book_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book_issues`
--

DROP TABLE IF EXISTS `book_issues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book_issues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `book_issues_rms1` (`branch_id`),
  KEY `book_issues_rms2` (`book_id`),
  KEY `book_issues_rms3` (`session_id`),
  CONSTRAINT `book_issues_rms1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  CONSTRAINT `book_issues_rms2` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE,
  CONSTRAINT `book_issues_rms3` FOREIGN KEY (`session_id`) REFERENCES `schoolyear` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book_issues`
--

LOCK TABLES `book_issues` WRITE;
/*!40000 ALTER TABLE `book_issues` DISABLE KEYS */;
/*!40000 ALTER TABLE `book_issues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `branch`
--

DROP TABLE IF EXISTS `branch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `branch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `board_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `school_name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobileno` varchar(100) NOT NULL,
  `currency` varchar(100) NOT NULL,
  `symbol` varchar(25) NOT NULL,
  `currency_formats` tinyint(4) NOT NULL DEFAULT 1,
  `symbol_position` tinyint(4) NOT NULL DEFAULT 1,
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
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `branch`
--

LOCK TABLES `branch` WRITE;
/*!40000 ALTER TABLE `branch` DISABLE KEYS */;
INSERT INTO `branch` VALUES (1,2,'Tahsin Academy','Tahsin Academy','info@tahsinacademy.edu.ng','','NGN','₦',1,1,'',1,'student_','TahsinStudent@123',0,'','',1,30,1,'english','Pacific/Midway','0,6',1,0,0,1,1,1,'TA-',5,1,0,1,1,0,0,0,'2026-03-25 11:58:56','2026-09-14 17:08:36');
/*!40000 ALTER TABLE `branch` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bulk_msg_category`
--

DROP TABLE IF EXISTS `bulk_msg_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bulk_msg_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `body` longtext NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT 'sms=1, email=2',
  `branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bulk_msg_category_rms_1` (`branch_id`),
  CONSTRAINT `bulk_msg_category_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bulk_msg_category`
--

LOCK TABLES `bulk_msg_category` WRITE;
/*!40000 ALTER TABLE `bulk_msg_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `bulk_msg_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bulk_sms_email`
--

DROP TABLE IF EXISTS `bulk_sms_email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bulk_sms_email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `bulk_sms_email_rms_1` (`branch_id`),
  CONSTRAINT `bulk_sms_email_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bulk_sms_email`
--

LOCK TABLES `bulk_sms_email` WRITE;
/*!40000 ALTER TABLE `bulk_sms_email` DISABLE KEYS */;
/*!40000 ALTER TABLE `bulk_sms_email` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `call_log`
--

DROP TABLE IF EXISTS `call_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `call_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `call_log_rms_1` (`branch_id`),
  CONSTRAINT `call_log_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `call_log`
--

LOCK TABLES `call_log` WRITE;
/*!40000 ALTER TABLE `call_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `call_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `call_purpose`
--

DROP TABLE IF EXISTS `call_purpose`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `call_purpose` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `call_purpose_rms_1` (`branch_id`),
  CONSTRAINT `call_purpose_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `call_purpose`
--

LOCK TABLES `call_purpose` WRITE;
/*!40000 ALTER TABLE `call_purpose` DISABLE KEYS */;
INSERT INTO `call_purpose` VALUES (1,'Fees',1),(2,'To inquire about the child',1),(3,'Student Health Checkup',1),(4,'Electricity Office',1);
/*!40000 ALTER TABLE `call_purpose` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `card_templete`
--

DROP TABLE IF EXISTS `card_templete`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `card_templete` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `card_templete_rms_1` (`branch_id`),
  CONSTRAINT `card_templete_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `card_templete`
--

LOCK TABLES `card_templete` WRITE;
/*!40000 ALTER TABLE `card_templete` DISABLE KEYS */;
INSERT INTO `card_templete` VALUES (1,1,'Templete1',1,'','','','<p><br style=\"\"><br style=\"\"><br style=\"\"></p><div style=\"float: left;\">{student_photo}<br>{signature}</div><div style=\"float: right; line-height: 1.4;\">Name :&nbsp;{name}<br>Gender :&nbsp;{gender}<br>Roll :&nbsp;&nbsp;{roll}<br>DOB :&nbsp;&nbsp;{birthday}<br>Date of Issue :&nbsp;&nbsp;{print_date}<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{qr_code}</div>','96.856','64.0',1,'110','5','5','20','20','register_no',1,'2026-03-27 07:18:42'),(2,2,'First Term Exam Admit Card',1,'','','','<div style=\"text-align: center;\"><b style=\"\"><span style=\"font-size: 28px;\">{institute_name}</span><span style=\"font-size: 28px;\"></span></b></div><div style=\"text-align: center;\">{institute_email} | {mobileno}&nbsp;</div><div style=\"text-align: center;\">{institute_address}</div><div style=\"text-align: center;\">{student_photo}&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; {qr_code}&nbsp;</div><div style=\"text-align: center;\"><span style=\"font-size: 18px;\"><b><br></b></span></div><div style=\"text-align: center;\"><span style=\"font-size: 18px;\"><b>ADMIT CARD&nbsp; FIRST TERM EXAMINATION</b></span></div><div style=\"text-align: center;\"><span style=\"font-size: 18px;\"><b><br></b></span></div><table class=\"table table-bordered table-condensed mb-none\" style=\"width: 724px; border-color: rgb(66, 68, 71);\"><tbody><tr><td style=\"line-height: 1.42857; border-color: rgb(66, 68, 71);\"><b>Student Name:&nbsp;</b>{name}<br></td><td style=\"line-height: 1.42857; border-color: rgb(66, 68, 71);\"><b>Exam Name:&nbsp;</b>{exam_name}<br></td></tr><tr><td style=\"line-height: 1.42857; border-color: rgb(66, 68, 71);\"><b>Father\'s Name:&nbsp;</b>{father_name}<br></td><td style=\"line-height: 1.42857; border-color: rgb(66, 68, 71);\"><b>Class:&nbsp;</b>{class}<br></td></tr><tr><td style=\"line-height: 1.42857; border-color: rgb(66, 68, 71);\"><b>Gender:&nbsp;</b>{gender}<br></td><td style=\"line-height: 1.42857; border-color: rgb(66, 68, 71);\"><b>Roll:</b>&nbsp;{roll}<br></td></tr><tr><td style=\"line-height: 1.42857; border-color: rgb(66, 68, 71);\"><b>Date Of Birth:&nbsp;</b>{birthday}<br></td><td style=\"line-height: 1.42857; border-color: rgb(66, 68, 71);\"><b>Admission On:</b>&nbsp;{admission_date}<br></td></tr><tr><td style=\"line-height: 1.42857; border-color: rgb(66, 68, 71);\"><b>Email:&nbsp;</b>{email}<br></td><td style=\"line-height: 1.42857; border-color: rgb(66, 68, 71);\"><b>Student Group:&nbsp;</b>{category}<br></td></tr><tr><td style=\"line-height: 1.42857; border-color: rgb(66, 68, 71);\"><b>Contact No:&nbsp;</b>{mobileno}<br></td><td style=\"line-height: 1.42857; border-color: rgb(66, 68, 71);\"><b>Blood Group</b>: {blood_group}&nbsp;<br></td></tr></tbody></table><div style=\"text-align: center;\"><br><div style=\"text-align: left;\"><b>Subject Details :</b></div><div style=\"text-align: left;\">{subject_list_table}</div><div style=\"\">Date of Admit Card Print : {print_date}&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Principal Signature</div><div style=\"\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;{signature}</div></div>','210','297',1,'100','80','80','80','90','register_no',1,'2026-03-27 07:23:39');
/*!40000 ALTER TABLE `card_templete` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `certificates_templete`
--

DROP TABLE IF EXISTS `certificates_templete`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `certificates_templete` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `certificates_templete_rms_1` (`branch_id`),
  CONSTRAINT `certificates_templete_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `certificates_templete`
--

LOCK TABLES `certificates_templete` WRITE;
/*!40000 ALTER TABLE `certificates_templete` DISABLE KEYS */;
/*!40000 ALTER TABLE `certificates_templete` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class`
--

DROP TABLE IF EXISTS `class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `name_numeric` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `class_rms_1` (`branch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class`
--

LOCK TABLES `class` WRITE;
/*!40000 ALTER TABLE `class` DISABLE KEYS */;
INSERT INTO `class` VALUES (14,'Boarding Quran without Technical Skills','1','2026-04-14 08:34:32',NULL,1),(15,'Boarding Quran with Technical Skills','2','2026-04-14 08:34:32',NULL,1),(16,'Day without Technical Skills','3','2026-04-14 08:34:32',NULL,1),(17,'Day with Technical Skills','4','2026-04-14 08:34:32',NULL,1),(18,'Weekend Tahfeez with Skills','5','2026-04-14 08:34:32',NULL,1),(19,'Weekend Tahfeez without Technical skills','6','2026-04-14 08:34:32',NULL,1);
/*!40000 ALTER TABLE `class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `complaint`
--

DROP TABLE IF EXISTS `complaint`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `complaint` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `complaint_rms_1` (`branch_id`),
  CONSTRAINT `complaint_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `complaint`
--

LOCK TABLES `complaint` WRITE;
/*!40000 ALTER TABLE `complaint` DISABLE KEYS */;
/*!40000 ALTER TABLE `complaint` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `complaint_type`
--

DROP TABLE IF EXISTS `complaint_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `complaint_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `complaint_type_rms_1` (`branch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `complaint_type`
--

LOCK TABLES `complaint_type` WRITE;
/*!40000 ALTER TABLE `complaint_type` DISABLE KEYS */;
INSERT INTO `complaint_type` VALUES (1,'Fees',1),(2,'Hostel',1),(3,'Facilities',1),(4,'Teacher',1),(5,'Management',1),(6,'General',1);
/*!40000 ALTER TABLE `complaint_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `custom_field`
--

DROP TABLE IF EXISTS `custom_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `custom_field`
--

LOCK TABLES `custom_field` WRITE;
/*!40000 ALTER TABLE `custom_field` DISABLE KEYS */;
/*!40000 ALTER TABLE `custom_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `custom_fields_online_values`
--

DROP TABLE IF EXISTS `custom_fields_online_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_fields_online_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `relid` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `relid` (`relid`),
  KEY `fieldid` (`field_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `custom_fields_online_values`
--

LOCK TABLES `custom_fields_online_values` WRITE;
/*!40000 ALTER TABLE `custom_fields_online_values` DISABLE KEYS */;
/*!40000 ALTER TABLE `custom_fields_online_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `custom_fields_values`
--

DROP TABLE IF EXISTS `custom_fields_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_fields_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `relid` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `relid` (`relid`),
  KEY `fieldid` (`field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `custom_fields_values`
--

LOCK TABLES `custom_fields_values` WRITE;
/*!40000 ALTER TABLE `custom_fields_values` DISABLE KEYS */;
/*!40000 ALTER TABLE `custom_fields_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `disable_reason`
--

DROP TABLE IF EXISTS `disable_reason`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `disable_reason` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `disable_reason_rms_1` (`branch_id`),
  CONSTRAINT `disable_reason_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `disable_reason`
--

LOCK TABLES `disable_reason` WRITE;
/*!40000 ALTER TABLE `disable_reason` DISABLE KEYS */;
/*!40000 ALTER TABLE `disable_reason` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `disable_reason_details`
--

DROP TABLE IF EXISTS `disable_reason_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `disable_reason_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `reason_id` int(11) NOT NULL,
  `note` varchar(255) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `disable_reason_details`
--

LOCK TABLES `disable_reason_details` WRITE;
/*!40000 ALTER TABLE `disable_reason_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `disable_reason_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_config`
--

DROP TABLE IF EXISTS `email_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `protocol` varchar(255) NOT NULL,
  `smtp_host` varchar(255) DEFAULT NULL,
  `smtp_user` varchar(255) DEFAULT NULL,
  `smtp_pass` varchar(255) DEFAULT NULL,
  `smtp_port` varchar(100) DEFAULT NULL,
  `smtp_encryption` varchar(10) DEFAULT NULL,
  `smtp_auth` varchar(10) NOT NULL DEFAULT 'true',
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_config`
--

LOCK TABLES `email_config` WRITE;
/*!40000 ALTER TABLE `email_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `email_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_templates`
--

DROP TABLE IF EXISTS `email_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `tags` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_templates`
--

LOCK TABLES `email_templates` WRITE;
/*!40000 ALTER TABLE `email_templates` DISABLE KEYS */;
INSERT INTO `email_templates` VALUES (1,'account_registered','{institute_name}, {name}, {login_username}, {password}, {user_role}, {login_url}'),(2,'forgot_password','{institute_name}, {username}, {email}, {reset_url}'),(3,'change_password','{institute_name}, {name}, {email}, {password}'),(4,'new_message_received','{institute_name}, {recipient}, {message}, {message_url}'),(5,'payslip_generated','{institute_name}, {username}, {month_year}, {payslip_url}'),(6,'award','{institute_name}, {winner_name}, {award_name}, {gift_item}, {award_reason}, {given_date}'),(7,'leave_approve','{institute_name}, {applicant_name}, {start_date}, {end_date}, {comments}'),(8,'leave_reject','{institute_name}, {applicant_name}, {start_date}, {end_date}, {comments}'),(9,'advance_salary_approve','{institute_name}, {applicant_name}, {deduct_motnh}, {amount}, {comments}'),(10,'advance_salary_reject','{institute_name}, {applicant_name}, {deduct_motnh}, {amount}, {comments}'),(11,'apply_online_admission','{institute_name}, {reference_no}, {applicant_name}, {applicant_mobile}, {class}, {section}, {apply_date}, {payment_url}, {admission_copy_url}, {paid_amount}'),(12,'student_admission','{institute_name}, {academic_year}, {admission_date}, {admission_no}, {roll}, {category}, {student_name}, {student_mobile}, {class}, {section}, {login_username}, {password}, {login_url}'),(13,'email_pdf_exam_marksheet','{institute_name}, {academic_year}, {admission_date}, {register_no}, {roll}, {student_name}, {class}, {section}, {exam_name}'),(14,'email_pdf_fee_invoice','{institute_name}, {academic_year}, {today_date}, {admission_date}, {register_no}, {roll}, {student_name}, {class}, {section}'),(15,'online_exam_published','{institute_name}, {student_name}, {student_mobile}, {register_no}, {roll}, {class}, {section}, {exam_title}, {start_time}, {end_time},{time_duration}, {attempt}, {passing_mark}, {exam_fee}');
/*!40000 ALTER TABLE `email_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_templates_details`
--

DROP TABLE IF EXISTS `email_templates_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email_templates_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `template_body` text NOT NULL,
  `notified` tinyint(1) NOT NULL DEFAULT 1,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_templates_details`
--

LOCK TABLES `email_templates_details` WRITE;
/*!40000 ALTER TABLE `email_templates_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `email_templates_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enquiry`
--

DROP TABLE IF EXISTS `enquiry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enquiry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `enquiry_rms_1` (`branch_id`),
  CONSTRAINT `enquiry_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enquiry`
--

LOCK TABLES `enquiry` WRITE;
/*!40000 ALTER TABLE `enquiry` DISABLE KEYS */;
/*!40000 ALTER TABLE `enquiry` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enquiry_follow_up`
--

DROP TABLE IF EXISTS `enquiry_follow_up`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enquiry_follow_up` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `enquiry_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `next_date` date NOT NULL,
  `response` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `note` varchar(255) NOT NULL,
  `follow_up_by` int(11) NOT NULL,
  `created_at` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `enquiry_follow_up_rms_1` (`enquiry_id`),
  CONSTRAINT `enquiry_follow_up_rms_1` FOREIGN KEY (`enquiry_id`) REFERENCES `enquiry` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enquiry_follow_up`
--

LOCK TABLES `enquiry_follow_up` WRITE;
/*!40000 ALTER TABLE `enquiry_follow_up` DISABLE KEYS */;
/*!40000 ALTER TABLE `enquiry_follow_up` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enquiry_reference`
--

DROP TABLE IF EXISTS `enquiry_reference`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enquiry_reference` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `enquiry_reference_rms_1` (`branch_id`),
  CONSTRAINT `enquiry_reference_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enquiry_reference`
--

LOCK TABLES `enquiry_reference` WRITE;
/*!40000 ALTER TABLE `enquiry_reference` DISABLE KEYS */;
/*!40000 ALTER TABLE `enquiry_reference` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enquiry_response`
--

DROP TABLE IF EXISTS `enquiry_response`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enquiry_response` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `enquiry_response_rms_1` (`branch_id`),
  CONSTRAINT `enquiry_response_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enquiry_response`
--

LOCK TABLES `enquiry_response` WRITE;
/*!40000 ALTER TABLE `enquiry_response` DISABLE KEYS */;
INSERT INTO `enquiry_response` VALUES (1,'Very Good',1),(2,'Excellent',1),(3,'Negative',1),(4,'Bad',1);
/*!40000 ALTER TABLE `enquiry_response` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enroll`
--

DROP TABLE IF EXISTS `enroll`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enroll` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `roll` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `default_login` tinyint(4) NOT NULL DEFAULT 0,
  `branch_id` int(11) NOT NULL,
  `is_alumni` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `enroll_rms_1` (`student_id`),
  KEY `enroll_rms_2` (`session_id`),
  KEY `enroll_rms_3` (`class_id`),
  KEY `enroll_rms_4` (`section_id`),
  KEY `enroll_rms_5` (`branch_id`),
  CONSTRAINT `enroll_rms_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE,
  CONSTRAINT `enroll_rms_2` FOREIGN KEY (`session_id`) REFERENCES `schoolyear` (`id`) ON DELETE CASCADE,
  CONSTRAINT `enroll_rms_3` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`) ON DELETE CASCADE,
  CONSTRAINT `enroll_rms_4` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`) ON DELETE CASCADE,
  CONSTRAINT `enroll_rms_5` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enroll`
--

LOCK TABLES `enroll` WRITE;
/*!40000 ALTER TABLE `enroll` DISABLE KEYS */;
/*!40000 ALTER TABLE `enroll` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `show_web` tinyint(3) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `event_rms_1` (`branch_id`),
  KEY `event_rms_2` (`session_id`),
  CONSTRAINT `event_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  CONSTRAINT `event_rms_2` FOREIGN KEY (`session_id`) REFERENCES `schoolyear` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_types`
--

DROP TABLE IF EXISTS `event_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `icon` varchar(200) NOT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `event_types_rms_1` (`branch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_types`
--

LOCK TABLES `event_types` WRITE;
/*!40000 ALTER TABLE `event_types` DISABLE KEYS */;
INSERT INTO `event_types` VALUES (1,'Independent Day','bullhorn',1),(2,'Anniversary','users',1),(3,'Special Holiday','bullhorn',1);
/*!40000 ALTER TABLE `event_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam`
--

DROP TABLE IF EXISTS `exam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exam_rms_1` (`branch_id`),
  KEY `exam_rms_2` (`session_id`),
  CONSTRAINT `exam_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exam_rms_2` FOREIGN KEY (`session_id`) REFERENCES `schoolyear` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam`
--

LOCK TABLES `exam` WRITE;
/*!40000 ALTER TABLE `exam` DISABLE KEYS */;
INSERT INTO `exam` VALUES (1,'First Term Examination for 2026/27 Session',4,3,3,1,'','[\"27\",\"28\"]',1,0,0,'2026-04-02 14:46:03',NULL);
/*!40000 ALTER TABLE `exam` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam_attendance`
--

DROP TABLE IF EXISTS `exam_attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exam_attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `status` varchar(4) DEFAULT NULL COMMENT 'P=Present, A=Absent, L=Late',
  `remark` varchar(255) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exam_attendance_rms_1` (`branch_id`),
  KEY `exam_attendance_rms_2` (`exam_id`),
  KEY `exam_attendance_rms_3` (`student_id`),
  CONSTRAINT `exam_attendance_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exam_attendance_rms_2` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exam_attendance_rms_3` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_attendance`
--

LOCK TABLES `exam_attendance` WRITE;
/*!40000 ALTER TABLE `exam_attendance` DISABLE KEYS */;
/*!40000 ALTER TABLE `exam_attendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam_hall`
--

DROP TABLE IF EXISTS `exam_hall`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exam_hall` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hall_no` longtext NOT NULL,
  `seats` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exam_hall_rms_1` (`branch_id`),
  CONSTRAINT `exam_hall_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_hall`
--

LOCK TABLES `exam_hall` WRITE;
/*!40000 ALTER TABLE `exam_hall` DISABLE KEYS */;
INSERT INTO `exam_hall` VALUES (1,'Arewa 101',400,1);
/*!40000 ALTER TABLE `exam_hall` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam_mark_distribution`
--

DROP TABLE IF EXISTS `exam_mark_distribution`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exam_mark_distribution` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exam_mark_distribution_rms_1` (`branch_id`),
  CONSTRAINT `exam_mark_distribution_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_mark_distribution`
--

LOCK TABLES `exam_mark_distribution` WRITE;
/*!40000 ALTER TABLE `exam_mark_distribution` DISABLE KEYS */;
INSERT INTO `exam_mark_distribution` VALUES (24,'Practical',1),(25,'Attendance',1),(26,'Written',1),(27,'CA Score',1),(28,'Exam Score',1),(29,'CA Score',1),(30,'Exam Score',1);
/*!40000 ALTER TABLE `exam_mark_distribution` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam_rank`
--

DROP TABLE IF EXISTS `exam_rank`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exam_rank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exam_id` int(11) NOT NULL,
  `enroll_id` int(11) NOT NULL,
  `principal_comments` text DEFAULT NULL,
  `teacher_comments` text DEFAULT NULL,
  `rank` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exam_group_class_batch_exam_id` (`exam_id`),
  KEY `student_id` (`enroll_id`),
  CONSTRAINT `exam_rank_rms_1` FOREIGN KEY (`enroll_id`) REFERENCES `enroll` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exam_rank_rms_2` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_rank`
--

LOCK TABLES `exam_rank` WRITE;
/*!40000 ALTER TABLE `exam_rank` DISABLE KEYS */;
/*!40000 ALTER TABLE `exam_rank` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam_term`
--

DROP TABLE IF EXISTS `exam_term`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exam_term` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `session_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_term`
--

LOCK TABLES `exam_term` WRITE;
/*!40000 ALTER TABLE `exam_term` DISABLE KEYS */;
INSERT INTO `exam_term` VALUES (4,'1st Term',1,3),(5,'2nd Term',1,3),(6,'3rd Term',1,3);
/*!40000 ALTER TABLE `exam_term` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fee_allocation`
--

DROP TABLE IF EXISTS `fee_allocation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fee_allocation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `prev_due` decimal(18,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fee_allocation_rsm_1` (`student_id`),
  KEY `fee_allocation_rsm_2` (`branch_id`),
  KEY `fee_allocation_rsm_3` (`session_id`),
  CONSTRAINT `fee_allocation_rsm_1` FOREIGN KEY (`student_id`) REFERENCES `enroll` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fee_allocation_rsm_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fee_allocation_rsm_3` FOREIGN KEY (`session_id`) REFERENCES `schoolyear` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fee_allocation`
--

LOCK TABLES `fee_allocation` WRITE;
/*!40000 ALTER TABLE `fee_allocation` DISABLE KEYS */;
/*!40000 ALTER TABLE `fee_allocation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fee_fine`
--

DROP TABLE IF EXISTS `fee_fine`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fee_fine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `fine_value` varchar(20) NOT NULL,
  `fine_type` varchar(20) NOT NULL,
  `fee_frequency` varchar(20) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fee_fine_rms_2` (`group_id`),
  KEY `fee_fine_rms_3` (`session_id`),
  KEY `fee_fine_rms_4` (`branch_id`),
  CONSTRAINT `fee_fine_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fee_fine_rms_2` FOREIGN KEY (`group_id`) REFERENCES `fee_groups` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fee_fine_rms_3` FOREIGN KEY (`session_id`) REFERENCES `schoolyear` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fee_fine_rms_4` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fee_fine`
--

LOCK TABLES `fee_fine` WRITE;
/*!40000 ALTER TABLE `fee_fine` DISABLE KEYS */;
/*!40000 ALTER TABLE `fee_fine` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fee_groups`
--

DROP TABLE IF EXISTS `fee_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fee_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `session_id` int(11) NOT NULL,
  `system` tinyint(4) NOT NULL DEFAULT 0,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fee_groups_rms_1` (`branch_id`),
  KEY `fee_groups_rms_2` (`session_id`),
  CONSTRAINT `fee_groups_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fee_groups_rms_2` FOREIGN KEY (`session_id`) REFERENCES `schoolyear` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fee_groups`
--

LOCK TABLES `fee_groups` WRITE;
/*!40000 ALTER TABLE `fee_groups` DISABLE KEYS */;
INSERT INTO `fee_groups` VALUES (1,'Tuition','Tuition fee for the academic session',3,0,1,'2026-09-14 10:20:20');
/*!40000 ALTER TABLE `fee_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fee_groups_details`
--

DROP TABLE IF EXISTS `fee_groups_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fee_groups_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fee_groups_id` int(11) NOT NULL,
  `fee_type_id` int(11) NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `due_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fee_groups_details_rms_1` (`fee_groups_id`),
  KEY `fee_groups_details_rms_2` (`fee_type_id`),
  CONSTRAINT `fee_groups_details_rms_1` FOREIGN KEY (`fee_groups_id`) REFERENCES `fee_groups` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fee_groups_details_rms_2` FOREIGN KEY (`fee_type_id`) REFERENCES `fees_type` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fee_groups_details`
--

LOCK TABLES `fee_groups_details` WRITE;
/*!40000 ALTER TABLE `fee_groups_details` DISABLE KEYS */;
INSERT INTO `fee_groups_details` VALUES (1,1,6,0.00,'2026-10-14','2026-09-14 10:20:20');
/*!40000 ALTER TABLE `fee_groups_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fee_payment_history`
--

DROP TABLE IF EXISTS `fee_payment_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fee_payment_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `allocation_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `transport_fee_details_id` int(11) DEFAULT NULL,
  `collect_by` varchar(20) DEFAULT NULL,
  `amount` decimal(18,2) NOT NULL,
  `discount` decimal(18,2) NOT NULL,
  `fine` decimal(18,2) NOT NULL,
  `pay_via` varchar(20) NOT NULL,
  `remarks` longtext NOT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fee_payment_history_rms_1` (`allocation_id`),
  KEY `fee_payment_history_rms_2` (`type_id`),
  CONSTRAINT `fee_payment_history_rms_1` FOREIGN KEY (`allocation_id`) REFERENCES `fee_allocation` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fee_payment_history_rms_2` FOREIGN KEY (`type_id`) REFERENCES `fees_type` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fee_payment_history`
--

LOCK TABLES `fee_payment_history` WRITE;
/*!40000 ALTER TABLE `fee_payment_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `fee_payment_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fees_reminder`
--

DROP TABLE IF EXISTS `fees_reminder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fees_reminder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `frequency` varchar(255) NOT NULL,
  `days` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `dlt_template_id` varchar(255) DEFAULT NULL,
  `student` tinyint(3) NOT NULL,
  `guardian` tinyint(3) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fees_reminder_rms_1` (`branch_id`),
  CONSTRAINT `fees_reminder_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fees_reminder`
--

LOCK TABLES `fees_reminder` WRITE;
/*!40000 ALTER TABLE `fees_reminder` DISABLE KEYS */;
/*!40000 ALTER TABLE `fees_reminder` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fees_type`
--

DROP TABLE IF EXISTS `fees_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fees_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `fee_code` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `system` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fees_type`
--

LOCK TABLES `fees_type` WRITE;
/*!40000 ALTER TABLE `fees_type` DISABLE KEYS */;
INSERT INTO `fees_type` VALUES (1,'Online Exam','online-exam','',1,0,'2026-03-27 09:41:35'),(2,'Admission Fees','admission-fees','',1,0,'2026-03-27 09:41:48'),(4,'Sports Fees','sports-fees','',1,0,'2026-03-27 09:42:03'),(5,'Exam Fees','exam-fees','',1,0,'2026-03-27 09:42:11'),(6,'Tuition','tuition','Termly tuition fee',1,0,'2026-09-14 10:20:20');
/*!40000 ALTER TABLE `fees_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `front_cms_about`
--

DROP TABLE IF EXISTS `front_cms_about`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `front_cms_about` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `page_title` varchar(255) NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `about_image` varchar(255) NOT NULL,
  `elements` mediumtext NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keyword` text NOT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `front_cms_about`
--

LOCK TABLES `front_cms_about` WRITE;
/*!40000 ALTER TABLE `front_cms_about` DISABLE KEYS */;
INSERT INTO `front_cms_about` VALUES (1,'Welcome to School','Best Education Mangment Systems','About Us','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut volutpat rutrum eros amet sollicitudin interdum. Suspendisse pulvinar, velit nec pharetra interdum, ante tellus ornare mi, et mollis tellus neque vitae elit. Mauris adipiscing mauris fringilla turpis interdum sed pulvinar nisi malesuada. Lorem ipsum dolor sit amet, consectetur adipiscing elit.\r\n                        </p>\r\n                        <p>\r\n                            Donec sed odio dui. Nulla vitae elit libero, a pharetra augue. Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Duis mollis, est non commodo luctus, nisi erat porttitor ligula. Mauris sit amet neque nec nunc gravida. \r\n                        </p>\r\n                        <div class=\"row\">\r\n                            <div class=\"col-sm-6 col-12\">\r\n                                <ul class=\"list-unstyled list-style-3\">\r\n                                    <li><a href=\"#\">Cardiothoracic Surgery</a></li>\r\n                                    <li><a href=\"#\">Cardiovascular Diseases</a></li>\r\n                                    <li><a href=\"#\">Ophthalmology</a></li>\r\n                                    <li><a href=\"#\">Dermitology</a></li>\r\n                                </ul>\r\n                            </div>\r\n                            <div class=\"col-sm-6 col-12\">\r\n                                <ul class=\"list-unstyled list-style-3\">\r\n                                    <li><a href=\"#\">Cardiothoracic Surgery</a></li>\r\n                                    <li><a href=\"#\">Cardiovascular Diseases</a></li>\r\n                                    <li><a href=\"#\">Ophthalmology</a></li>\r\n                                </ul>\r\n                            </div>\r\n                        </div>','about1.jpg','about1.png','{\"cta_title\":\"Get in touch to join our community\",\"button_text\":\"Contact Our Office\",\"button_url\":\"contact\"}','','',1);
/*!40000 ALTER TABLE `front_cms_about` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `front_cms_admission`
--

DROP TABLE IF EXISTS `front_cms_admission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `front_cms_admission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `front_cms_admission`
--

LOCK TABLES `front_cms_admission` WRITE;
/*!40000 ALTER TABLE `front_cms_admission` DISABLE KEYS */;
INSERT INTO `front_cms_admission` VALUES (1,'Make An Admission','<p>Lorem ipsum dolor sit amet, eum illum dolore concludaturque ex, ius latine adipisci no. Pro at nullam laboramus definitiones. Mandamusconceptam omittantur cu cum. Brute appetere it scriptorem ei eam, ne vim velit novum nominati. Causae volutpat percipitur at sed ne.</p>\r\n','Admission','','','','admission1.jpg','SmartSchool - School Management System','SmartSchool Admission Page',NULL,NULL,1);
/*!40000 ALTER TABLE `front_cms_admission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `front_cms_admitcard`
--

DROP TABLE IF EXISTS `front_cms_admitcard`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `front_cms_admitcard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_title` varchar(255) DEFAULT NULL,
  `templete_id` int(11) NOT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keyword` text NOT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `front_cms_admitcard`
--

LOCK TABLES `front_cms_admitcard` WRITE;
/*!40000 ALTER TABLE `front_cms_admitcard` DISABLE KEYS */;
INSERT INTO `front_cms_admitcard` VALUES (1,'Admit Card',1,'admit_card1.jpg','Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.','SmartSchool - School Management System','SmartSchool Admit Card Page',1);
/*!40000 ALTER TABLE `front_cms_admitcard` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `front_cms_certificates`
--

DROP TABLE IF EXISTS `front_cms_certificates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `front_cms_certificates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_title` varchar(255) DEFAULT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keyword` text NOT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `front_cms_certificates`
--

LOCK TABLES `front_cms_certificates` WRITE;
/*!40000 ALTER TABLE `front_cms_certificates` DISABLE KEYS */;
INSERT INTO `front_cms_certificates` VALUES (1,'Certificates','certificates1.jpg','Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.','SmartSchool - School Management System','SmartSchool Admit Card Page',1);
/*!40000 ALTER TABLE `front_cms_certificates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `front_cms_contact`
--

DROP TABLE IF EXISTS `front_cms_contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `front_cms_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `front_cms_contact`
--

LOCK TABLES `front_cms_contact` WRITE;
/*!40000 ALTER TABLE `front_cms_contact` DISABLE KEYS */;
INSERT INTO `front_cms_contact` VALUES (1,'WE\'D LOVE TO HEAR FROM YOU','Fusce convallis diam vitae velit tempus rutrum. Donec nisl nisl, vulputate eu sapien sed, adipiscing vehicula massa. Mauris eget commodo neque, id molestie enim.','contact-info-box1.png','Get in touch by filling the form below','4896  Romrog Way, LOS ANGELES,\r\nCalifornia','954-648-1802, \r\n963-612-1782','jamilusalis@gmail.com\rjamilusalis@gmail.com','Send','<iframe width=\"100%\" height=\"350\" id=\"gmap_canvas\" src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3313.3833161665298!2d-118.03745848530627!3d33.85401093559897!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80dd2c6c97f8f3ed%3A0x47b1bde165dcc056!2sOak+Dr%2C+La+Palma%2C+CA+90623%2C+USA!5e0!3m2!1sen!2sbd!4v1544238752504\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\"></iframe>','Contact Us','contact1.jpg','','',1);
/*!40000 ALTER TABLE `front_cms_contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `front_cms_events`
--

DROP TABLE IF EXISTS `front_cms_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `front_cms_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `meta_description` text NOT NULL,
  `meta_keyword` text NOT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `front_cms_events`
--

LOCK TABLES `front_cms_events` WRITE;
/*!40000 ALTER TABLE `front_cms_events` DISABLE KEYS */;
INSERT INTO `front_cms_events` VALUES (1,'Upcoming Events','<p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.</p><p>Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS.</p>','Events','events1.jpg','SmartSchool - School Management System','SmartSchool Events Page',1);
/*!40000 ALTER TABLE `front_cms_events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `front_cms_exam_results`
--

DROP TABLE IF EXISTS `front_cms_exam_results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `front_cms_exam_results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_title` varchar(255) DEFAULT NULL,
  `grade_scale` tinyint(1) NOT NULL,
  `attendance` tinyint(1) NOT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keyword` text NOT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `front_cms_exam_results`
--

LOCK TABLES `front_cms_exam_results` WRITE;
/*!40000 ALTER TABLE `front_cms_exam_results` DISABLE KEYS */;
INSERT INTO `front_cms_exam_results` VALUES (1,'Exam Results',1,1,'exam_results1.jpg','Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.','SmartSchool - School Management System','SmartSchool Admit Card Page',1);
/*!40000 ALTER TABLE `front_cms_exam_results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `front_cms_faq`
--

DROP TABLE IF EXISTS `front_cms_faq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `front_cms_faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `meta_description` text NOT NULL,
  `meta_keyword` text NOT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `front_cms_faq`
--

LOCK TABLES `front_cms_faq` WRITE;
/*!40000 ALTER TABLE `front_cms_faq` DISABLE KEYS */;
INSERT INTO `front_cms_faq` VALUES (1,'Frequently Asked Questions','<p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.</p>\r\n\r\n<p>Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven&#39;t heard of them accusamus labore sustainable VHS.</p>','Faq','faq1.jpg','','',1);
/*!40000 ALTER TABLE `front_cms_faq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `front_cms_faq_list`
--

DROP TABLE IF EXISTS `front_cms_faq_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `front_cms_faq_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `front_cms_faq_list`
--

LOCK TABLES `front_cms_faq_list` WRITE;
/*!40000 ALTER TABLE `front_cms_faq_list` DISABLE KEYS */;
INSERT INTO `front_cms_faq_list` VALUES (1,'Any Information you provide on applications for disability, life or accidental insurance ?','<p>\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco quat. It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.\r\n</p>\r\n<ul>\r\n<li>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>\r\n<li>Sed do eiusmod tempor incididunt ut labore et dolore magna aliq.</li>\r\n<li>Ut enim ad minim veniam, quis nostrud exercitation ullamco quat. It is a long established fact.</li>\r\n<li>That a reader will be distracted by the readable content of a page when looking at its layout.</li>\r\n<li>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>\r\n<li>Eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</li>\r\n<li>Quis nostrud exercitation ullamco quat. It is a long established fact that a reader will be distracted.</li>\r\n<li>Readable content of a page when looking at its layout.</li>\r\n<li>The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.</li>\r\n<li>Opposed to using \'Content here, content here\', making it look like readable English.</li>\r\n</ul>',1),(2,'Readable content of a page when looking at its layout ?','<p>\r\n                                Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS.\r\n                            </p>\r\n                            <ol>\r\n                                <li>Quis nostrud exercitation ullamco quat. It is a long established fact that a reader will be distracted.</li>\r\n                                <li>Readable content of a page when looking at its layout.</li>\r\n                                <li>The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.</li>\r\n                                <li>Opposed to using \'Content here, content here\', making it look like readable English.</li>\r\n                            </ol>\r\n                            <p>\r\n                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.\r\n                            </p>',1),(3,'Opposed to using \'Content here, content here\', making it look like readable English ?','<p>\r\n                                Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS.\r\n                            </p>\r\n                            <ol>\r\n                                <li>Quis nostrud exercitation ullamco quat. It is a long established fact that a reader will be distracted.</li>\r\n                                <li>Readable content of a page when looking at its layout.</li>\r\n                                <li>The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.</li>\r\n                                <li>Opposed to using \'Content here, content here\', making it look like readable English.</li>\r\n                            </ol>\r\n                            <p>\r\n                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.\r\n                            </p>',1),(4,'Readable content of a page when looking at its layout ?','<p>\r\n                                Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS.\r\n                            </p>\r\n                            <ol>\r\n                                <li>Quis nostrud exercitation ullamco quat. It is a long established fact that a reader will be distracted.</li>\r\n                                <li>Readable content of a page when looking at its layout.</li>\r\n                                <li>The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.</li>\r\n                                <li>Opposed to using \'Content here, content here\', making it look like readable English.</li>\r\n                            </ol>\r\n                            <p>\r\n                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.\r\n                            </p>',1),(5,'What types of documents are required to travel?','<p><strong>Lorem ipsum</strong> dolor sit amet, an labores explicari qui, eu nostrum copiosae argumentum has. Latine propriae quo no, unum ridens expetenda id sit, at usu eius eligendi singulis. Sea ocurreret principes ne. At nonumy aperiri pri, nam quodsi copiosae intellegebat et, ex deserunt euripidis usu. Per ad ullum lobortis. Duo volutpat imperdiet ut, postea salutatus imperdiet ut per, ad utinam debitis invenire has.</p>\r\n\r\n<ol>\r\n	<li>labores explicari qui</li>\r\n	<li>labores explicari qui</li>\r\n	<li>labores explicari quilabores explicari qui</li>\r\n	<li>labores explicari qui</li>\r\n</ol>',1);
/*!40000 ALTER TABLE `front_cms_faq_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `front_cms_gallery`
--

DROP TABLE IF EXISTS `front_cms_gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `front_cms_gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_title` varchar(255) DEFAULT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `meta_description` text NOT NULL,
  `meta_keyword` text NOT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `front_cms_gallery`
--

LOCK TABLES `front_cms_gallery` WRITE;
/*!40000 ALTER TABLE `front_cms_gallery` DISABLE KEYS */;
INSERT INTO `front_cms_gallery` VALUES (1,'Gallery','gallery1.jpg','SmartSchool - School Management System','SmartSchool Gallery Page',1);
/*!40000 ALTER TABLE `front_cms_gallery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `front_cms_gallery_category`
--

DROP TABLE IF EXISTS `front_cms_gallery_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `front_cms_gallery_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `front_cms_gallery_category`
--

LOCK TABLES `front_cms_gallery_category` WRITE;
/*!40000 ALTER TABLE `front_cms_gallery_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `front_cms_gallery_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `front_cms_gallery_content`
--

DROP TABLE IF EXISTS `front_cms_gallery_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `front_cms_gallery_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `created_at` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `front_cms_gallery_content`
--

LOCK TABLES `front_cms_gallery_content` WRITE;
/*!40000 ALTER TABLE `front_cms_gallery_content` DISABLE KEYS */;
/*!40000 ALTER TABLE `front_cms_gallery_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `front_cms_home`
--

DROP TABLE IF EXISTS `front_cms_home`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `front_cms_home` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `item_type` varchar(20) NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `elements` mediumtext NOT NULL,
  `color1` varchar(100) DEFAULT NULL,
  `color2` varchar(100) DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  `active` tinyint(3) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `front_cms_home`
--

LOCK TABLES `front_cms_home` WRITE;
/*!40000 ALTER TABLE `front_cms_home` DISABLE KEYS */;
INSERT INTO `front_cms_home` VALUES (1,'Welcome To Tahsin Academy','We will give you future','wellcome','Excellence In Deen & Duniya — a school where Quranic memorization, sound character, and academic excellence grow together.','{\"image\":\"wellcome1.png\"}',NULL,NULL,1,1),(2,'Teachers Who Form Character',NULL,'teachers','Our teachers combine scholarship in the deen with the patience and discipline of a strong classroom.','{\"teacher_start\":\"0\",\"image\":\"featured-parallax1.jpg\"}',NULL,NULL,1,1),(3,'Why Families Choose Tahsin',NULL,'services','Boarding, Day and Weekend tracks. Quran with or without technical skills. One academy, two worlds held together.','',NULL,NULL,1,1),(4,'Apply for Admission','Medical Services','cta','','{\"mobile_no\":\"\",\"button_text\":\"Apply for Admission\",\"button_url\":\"admission\"}','#464646','#fff',1,1),(5,'Welcome To <span>Tahsin Academy</span>',NULL,'slider','Lorem Ipsum is simply dummy text printer took a galley of type and scrambled it to make a type specimen book.','{\"position\":\"c-left\",\"button_text1\":\"View Services\",\"button_url1\":\"https:\\/\\/www.youtube.com\\/watch?v=Zec8KQmoSOU\",\"button_text2\":\"Learn More\",\"button_url2\":\"#\",\"image\":\"home-slider-1592582779.jpg\"}',NULL,NULL,1,0),(6,'Excellence In <span>Deen & Duniya</span>',NULL,'slider','Lorem Ipsum is simply dummy text printer took a galley of type and scrambled it to make a type specimen book.','{\"position\":\"c-left\",\"button_text1\":\"Read More\",\"button_url1\":\"#\",\"button_text2\":\"Get Started\",\"button_url2\":\"#\",\"image\":\"home-slider-1592582805.jpg\"}',NULL,NULL,1,0),(7,'Online Classes',NULL,'features','Nulla metus metus ullamcorper vel tincidunt sed euismod nibh Quisque volutpat condimentum velit class aptent taciti sociosqu.','{\"button_text\":\"Read More\",\"button_url\":\"#\",\"icon\":\"fas fa-video\"}',NULL,NULL,1,1),(8,'Scholarship',NULL,'features','Nulla metus metus ullamcorper vel tincidunt sed euismod nibh Quisque volutpat condimentum velit class aptent taciti sociosqu.','{\"button_text\":\"Read More\",\"button_url\":\"#\",\"icon\":\"fas fa-graduation-cap\"}',NULL,NULL,1,1),(9,'Library & Learning',NULL,'features','Nulla metus metus ullamcorper vel tincidunt sed euismod nibh Quisque volutpat condimentum velit class aptent taciti sociosqu.','{\"button_text\":\"Read More\",\"button_url\":\"#\",\"icon\":\"fas fa-book-reader\"}',NULL,NULL,1,1),(10,'Trending Courses',NULL,'features','Nulla metus metus ullamcorper vel tincidunt sed euismod nibh Quisque volutpat condimentum velit class aptent taciti sociosqu.','{\"button_text\":\"Read More\",\"button_url\":\"#\",\"icon\":\"fab fa-discourse\"}',NULL,NULL,1,1),(11,'What Families Say',NULL,'testimonial','Fusce sem dolor, interdum in efficitur at, faucibus nec lorem. Sed nec molestie justo.','',NULL,NULL,1,1),(12,'A Place Of Knowledge',NULL,'statistics','Certified teachers, enrolled students, structured programmes, and a community built around the Quran.','{\"image\":\"counter-parallax1.jpg\",\"widget_title_1\":\"Certified Teachers\",\"widget_icon_1\":\"fas fa-user-tie\",\"type_1\":\"teacher\",\"widget_title_2\":\"Students Enrolled\",\"widget_icon_2\":\"fas fa-user-graduate\",\"type_2\":\"student\",\"widget_title_3\":\"Classes\",\"widget_icon_3\":\"fas fa-graduation-cap\",\"type_3\":\"class\",\"widget_title_4\":\"Section\",\"widget_icon_4\":\"fas fa-award\",\"type_4\":\"section\"}',NULL,NULL,1,1);
/*!40000 ALTER TABLE `front_cms_home` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `front_cms_home_seo`
--

DROP TABLE IF EXISTS `front_cms_home_seo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `front_cms_home_seo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_title` varchar(255) NOT NULL,
  `meta_keyword` text NOT NULL,
  `meta_description` text NOT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `front_cms_home_seo`
--

LOCK TABLES `front_cms_home_seo` WRITE;
/*!40000 ALTER TABLE `front_cms_home_seo` DISABLE KEYS */;
INSERT INTO `front_cms_home_seo` VALUES (1,'Home','Tahsin Academy, Islamic school Nigeria, Tahfeez, Quran memorization, boarding school','Tahsin Academy — Excellence in Deen and Duniya. Boarding, Day and Weekend programmes combining Quranic memorization with a rigorous academic path.',1);
/*!40000 ALTER TABLE `front_cms_home_seo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `front_cms_menu`
--

DROP TABLE IF EXISTS `front_cms_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `front_cms_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `front_cms_menu`
--

LOCK TABLES `front_cms_menu` WRITE;
/*!40000 ALTER TABLE `front_cms_menu` DISABLE KEYS */;
INSERT INTO `front_cms_menu` VALUES (1,'Home','',1,0,0,0,'',1,1,1,'2026-02-12 12:18:54'),(2,'Events','events',3,0,0,0,'',1,1,1,'2026-02-12 12:18:54'),(3,'Teachers','teachers',2,0,0,0,'',1,1,1,'2026-02-12 12:18:54'),(4,'About Us','about',4,0,0,0,'',1,1,1,'2026-02-12 12:18:54'),(5,'FAQ','faq',5,0,0,0,'',1,1,1,'2026-02-12 12:18:54'),(6,'Online Admission','admission',6,0,0,0,'',1,1,1,'2026-02-12 12:18:54'),(7,'Contact Us','contact',13,0,0,0,'',1,1,1,'2026-02-12 12:18:54'),(8,'Pages','pages',9,0,0,1,'#',1,1,1,'2026-02-12 12:18:54'),(9,'Admit Card','admit_card',10,8,0,0,'',1,1,1,'2026-02-16 04:24:32'),(10,'Exam Results','exam_results',11,8,0,0,'',1,1,1,'2026-02-16 04:24:32'),(11,'Certificates','certificates',12,8,0,0,'',1,1,1,'2026-02-16 12:04:44'),(12,'Gallery','gallery',7,0,0,0,'',1,1,1,'2026-02-16 12:04:44'),(13,'News','news',8,0,0,0,'',1,1,1,'2026-02-21 14:50:05');
/*!40000 ALTER TABLE `front_cms_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `front_cms_menu_visible`
--

DROP TABLE IF EXISTS `front_cms_menu_visible`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `front_cms_menu_visible` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `menu_id` int(11) NOT NULL,
  `parent_id` varchar(11) DEFAULT NULL,
  `ordering` varchar(20) DEFAULT NULL,
  `invisible` tinyint(2) NOT NULL DEFAULT 1,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `front_cms_menu_visible`
--

LOCK TABLES `front_cms_menu_visible` WRITE;
/*!40000 ALTER TABLE `front_cms_menu_visible` DISABLE KEYS */;
/*!40000 ALTER TABLE `front_cms_menu_visible` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `front_cms_news`
--

DROP TABLE IF EXISTS `front_cms_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `front_cms_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `meta_description` text NOT NULL,
  `meta_keyword` text NOT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `front_cms_news`
--

LOCK TABLES `front_cms_news` WRITE;
/*!40000 ALTER TABLE `front_cms_news` DISABLE KEYS */;
INSERT INTO `front_cms_news` VALUES (1,'','<p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.</p><p>Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS.</p>','News','news1.jpg','SmartSchool - School Management System','SmartSchool News Page',1);
/*!40000 ALTER TABLE `front_cms_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `front_cms_news_list`
--

DROP TABLE IF EXISTS `front_cms_news_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `front_cms_news_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `alias` varchar(500) NOT NULL,
  `date` date NOT NULL,
  `show_web` tinyint(4) NOT NULL DEFAULT 1,
  `branch_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `front_cms_news_list_rms_1` (`branch_id`),
  CONSTRAINT `front_cms_news_list_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `front_cms_news_list`
--

LOCK TABLES `front_cms_news_list` WRITE;
/*!40000 ALTER TABLE `front_cms_news_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `front_cms_news_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `front_cms_pages`
--

DROP TABLE IF EXISTS `front_cms_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `front_cms_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_title` varchar(255) NOT NULL,
  `content` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `menu_id` int(11) NOT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `meta_description` text NOT NULL,
  `meta_keyword` text NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `front_cms_pages`
--

LOCK TABLES `front_cms_pages` WRITE;
/*!40000 ALTER TABLE `front_cms_pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `front_cms_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `front_cms_services`
--

DROP TABLE IF EXISTS `front_cms_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `front_cms_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `parallax_image` varchar(255) DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `front_cms_services`
--

LOCK TABLES `front_cms_services` WRITE;
/*!40000 ALTER TABLE `front_cms_services` DISABLE KEYS */;
INSERT INTO `front_cms_services` VALUES (1,'Get Well Soon','Our Best <span>Services</span>','service_parallax1.jpg',1);
/*!40000 ALTER TABLE `front_cms_services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `front_cms_services_list`
--

DROP TABLE IF EXISTS `front_cms_services_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `front_cms_services_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `front_cms_services_list`
--

LOCK TABLES `front_cms_services_list` WRITE;
/*!40000 ALTER TABLE `front_cms_services_list` DISABLE KEYS */;
INSERT INTO `front_cms_services_list` VALUES (1,'Online Course Facilities','Making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text.','fas fa-headphones',1),(2,'Modern Book Library','Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover.','fas fa-book-open',1),(3,'Be Industrial Leader','Making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model.','fas fa-industry',1),(4,'Programming Courses','Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will.','fas fa-code',1),(5,'Foreign Languages','Making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover.','fas fa-language',1),(6,'Alumni Directory','Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a for \'lorem ipsum\' will uncover.','fas fa-user-graduate',1);
/*!40000 ALTER TABLE `front_cms_services_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `front_cms_setting`
--

DROP TABLE IF EXISTS `front_cms_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `front_cms_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `front_cms_setting`
--

LOCK TABLES `front_cms_setting` WRITE;
/*!40000 ALTER TABLE `front_cms_setting` DISABLE KEYS */;
INSERT INTO `front_cms_setting` VALUES (1,'Tahsin Academy','',0,1,'red','disable','','','','','12345678','info@tahsinacademy.edu.ng','info@tahsinacademy.edu.ng','© 2026 Tahsin Academy. All rights reserved.','tahsin-logo.png','tahsin-logo.png','Tahsin Academy — Excellence In Deen & Duniya. Nurturing future leaders through authentic Islamic values, Quranic memorization, and a rigorous academic path.','Hours:  Mon - Fri: 8:00 AM - 3:00 PM',NULL,'#ff685c','#fff','#f04133','#232323','#8d8d8d','#383838','#8d8d8d','#262626','#8d8d8d','0','https://facebook.com','https://twitter.com','https://youtube.com','https://google.com','https://linkedin.com','https://pinterest.com','https://instagram.com',1);
/*!40000 ALTER TABLE `front_cms_setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `front_cms_teachers`
--

DROP TABLE IF EXISTS `front_cms_teachers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `front_cms_teachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_title` varchar(255) DEFAULT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `meta_description` text NOT NULL,
  `meta_keyword` text NOT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `front_cms_teachers`
--

LOCK TABLES `front_cms_teachers` WRITE;
/*!40000 ALTER TABLE `front_cms_teachers` DISABLE KEYS */;
INSERT INTO `front_cms_teachers` VALUES (1,'Teachers','teachers1.jpg','SmartSchool - School Management System','SmartSchool Teachers Page',1);
/*!40000 ALTER TABLE `front_cms_teachers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `front_cms_testimonial`
--

DROP TABLE IF EXISTS `front_cms_testimonial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `front_cms_testimonial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `surname` varchar(355) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `rank` int(5) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `front_cms_testimonial`
--

LOCK TABLES `front_cms_testimonial` WRITE;
/*!40000 ALTER TABLE `front_cms_testimonial` DISABLE KEYS */;
INSERT INTO `front_cms_testimonial` VALUES (1,'Gartrell Wright','Los Angeles','defualt.png','Intexure have done an excellent job presenting the analysis & insights. I am confident in saying  have helped encounter  is to be welcomed and every pain avoided”.',1,1,1,'2026-02-12 12:26:42'),(2,'Clifton Hyde','Newyork City','defualt.png','“Owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repudiated and annoyances accepted always holds”.',4,1,1,'2026-02-12 12:26:42'),(3,'Emily Lemus','Los Angeles','defualt.png','“Intexure have done an excellent job presenting the analysis & insights. I am confident in saying  have helped encounter  is to be welcomed and every pain avoided”.',5,1,1,'2026-02-12 12:26:42');
/*!40000 ALTER TABLE `front_cms_testimonial` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `global_settings`
--

DROP TABLE IF EXISTS `global_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `global_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `cache_store` tinyint(1) NOT NULL DEFAULT 0,
  `image_extension` text DEFAULT NULL,
  `image_size` float NOT NULL DEFAULT 1024,
  `file_extension` text DEFAULT NULL,
  `pid` varchar(255) DEFAULT NULL,
  `file_size` float DEFAULT 1024,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `global_settings`
--

LOCK TABLES `global_settings` WRITE;
/*!40000 ALTER TABLE `global_settings` DISABLE KEYS */;
INSERT INTO `global_settings` VALUES (1,'Tahsin Academy','TA-','on','info@tahsinacademy.edu.ng','','','NGN','₦',3,1,'disabled',3,'english','© 2026 Tahsin Academy','fadeInUp','Africa/Lagos','d.M.Y','','','','','74250cf4dd95bedd3276ebc9888143fa',1,0,'jpeg, jpg, bmp, png',2048,'txt, pdf, doc, xls, docx, xlsx, jpg, jpeg, png, gif, bmp, zip, mp4, 7z, wmv, rar','N2I3MmY1M2MtOWQzOC00YzUzLWEzOWYtYmU0NDA5ODE0NGQ0',2048,'2026-02-24 13:31:40','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `global_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grade`
--

DROP TABLE IF EXISTS `grade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `grade_point` varchar(255) NOT NULL,
  `lower_mark` int(11) NOT NULL,
  `upper_mark` int(11) NOT NULL,
  `remark` text NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `grade_rms_1` (`branch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grade`
--

LOCK TABLES `grade` WRITE;
/*!40000 ALTER TABLE `grade` DISABLE KEYS */;
INSERT INTO `grade` VALUES (7,'A1','4.0',75,100,'Excellent',1),(8,'B2','3.5',70,74,'Very Good',1),(9,'B3','3.0',65,69,'Good',1),(10,'C4','2.5',60,64,'Credit',1),(11,'C5','2.0',55,59,'Credit',1),(12,'C6','1.5',50,54,'Credit',1),(13,'D7','1.0',45,49,'Pass',1),(14,'E8','0.5',40,44,'Pass',1),(15,'F9','0.0',0,39,'Fail',1);
/*!40000 ALTER TABLE `grade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hall_allocation`
--

DROP TABLE IF EXISTS `hall_allocation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hall_allocation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `hall_no` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hall_allocation`
--

LOCK TABLES `hall_allocation` WRITE;
/*!40000 ALTER TABLE `hall_allocation` DISABLE KEYS */;
/*!40000 ALTER TABLE `hall_allocation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `homework`
--

DROP TABLE IF EXISTS `homework`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `homework` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `homework_rms_1` (`branch_id`),
  KEY `homework_rms_2` (`class_id`),
  KEY `homework_rms_3` (`section_id`),
  KEY `homework_rms_4` (`session_id`),
  KEY `homework_rms_5` (`subject_id`),
  CONSTRAINT `homework_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  CONSTRAINT `homework_rms_2` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`) ON DELETE CASCADE,
  CONSTRAINT `homework_rms_3` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`) ON DELETE CASCADE,
  CONSTRAINT `homework_rms_4` FOREIGN KEY (`session_id`) REFERENCES `schoolyear` (`id`) ON DELETE CASCADE,
  CONSTRAINT `homework_rms_5` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `homework`
--

LOCK TABLES `homework` WRITE;
/*!40000 ALTER TABLE `homework` DISABLE KEYS */;
/*!40000 ALTER TABLE `homework` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `homework_evaluation`
--

DROP TABLE IF EXISTS `homework_evaluation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `homework_evaluation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `homework_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `remark` text NOT NULL,
  `rank` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `homework_evaluation_rms_1` (`homework_id`),
  CONSTRAINT `homework_evaluation_rms_1` FOREIGN KEY (`homework_id`) REFERENCES `homework` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `homework_evaluation`
--

LOCK TABLES `homework_evaluation` WRITE;
/*!40000 ALTER TABLE `homework_evaluation` DISABLE KEYS */;
/*!40000 ALTER TABLE `homework_evaluation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `homework_submit`
--

DROP TABLE IF EXISTS `homework_submit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `homework_submit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `homework_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `message` varchar(355) NOT NULL,
  `enc_name` varchar(355) DEFAULT NULL,
  `file_name` varchar(355) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `homework_submit_rms_1` (`homework_id`),
  KEY `homework_submit_rms_2` (`student_id`),
  CONSTRAINT `homework_submit_rms_1` FOREIGN KEY (`homework_id`) REFERENCES `homework` (`id`) ON DELETE CASCADE,
  CONSTRAINT `homework_submit_rms_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `homework_submit`
--

LOCK TABLES `homework_submit` WRITE;
/*!40000 ALTER TABLE `homework_submit` DISABLE KEYS */;
/*!40000 ALTER TABLE `homework_submit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hostel`
--

DROP TABLE IF EXISTS `hostel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hostel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext NOT NULL,
  `category_id` int(11) NOT NULL,
  `address` longtext NOT NULL,
  `watchman` longtext NOT NULL,
  `remarks` longtext DEFAULT NULL,
  `branch_id` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hostel_rms_1` (`branch_id`),
  CONSTRAINT `hostel_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hostel`
--

LOCK TABLES `hostel` WRITE;
/*!40000 ALTER TABLE `hostel` DISABLE KEYS */;
/*!40000 ALTER TABLE `hostel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hostel_category`
--

DROP TABLE IF EXISTS `hostel_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hostel_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext NOT NULL,
  `description` longtext DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `type` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hostel_category`
--

LOCK TABLES `hostel_category` WRITE;
/*!40000 ALTER TABLE `hostel_category` DISABLE KEYS */;
INSERT INTO `hostel_category` VALUES (1,'Residential','Only seat for resident',1,'room','2026-03-27 09:31:18',NULL),(2,'Residential For Girls','Only For Girls.',1,'hostel','2026-03-27 09:31:36',NULL),(3,'Residential For Boys','For Boys',1,'hostel','2026-03-27 09:31:55',NULL);
/*!40000 ALTER TABLE `hostel_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hostel_room`
--

DROP TABLE IF EXISTS `hostel_room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hostel_room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext NOT NULL,
  `hostel_id` int(11) NOT NULL,
  `no_beds` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `bed_fee` decimal(18,2) NOT NULL,
  `remarks` longtext NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hostel_room`
--

LOCK TABLES `hostel_room` WRITE;
/*!40000 ALTER TABLE `hostel_room` DISABLE KEYS */;
/*!40000 ALTER TABLE `hostel_room` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `language_list`
--

DROP TABLE IF EXISTS `language_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `language_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(600) NOT NULL,
  `lang_field` varchar(600) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `rtl` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `language_list`
--

LOCK TABLES `language_list` WRITE;
/*!40000 ALTER TABLE `language_list` DISABLE KEYS */;
INSERT INTO `language_list` VALUES (1,'English','english',1,0,'2026-02-10 11:36:31','2026-05-08 06:34:06');
/*!40000 ALTER TABLE `language_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word` varchar(255) NOT NULL,
  `english` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1399 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `languages`
--

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` VALUES (1,'language','Language'),(2,'attendance_overview','Attendance Overview'),(3,'annual_fee_summary','Annual Fee Summary'),(4,'my_annual_attendance_overview','My Annual Attendance Overview'),(5,'schedule','Schedule'),(6,'student_admission','Student Admission'),(7,'returned','Returned'),(8,'user_name','User Name'),(9,'rejected','Rejected'),(10,'route_name','Route Name'),(11,'route_fare','Route Fare'),(12,'edit_route','Edit Route'),(13,'this_value_is_required','This value is required.'),(14,'vehicle_no','Vehicle No'),(15,'insurance_renewal_date','Insurance Renewal Date'),(16,'driver_name','Driver Name'),(17,'driver_license','Driver License'),(18,'select_route','Select Route'),(19,'edit_vehicle','Edit Vehicle'),(20,'add_students','Add Students'),(21,'vehicle_number','Vehicle Number'),(22,'select_route_first','Select Route First'),(23,'transport_fee','Transport Fee'),(24,'control','Control'),(25,'set_students','Set Students'),(26,'hostel_list','Hostel List'),(27,'watchman_name','Watchman Name'),(28,'hostel_address','Hostel Address'),(29,'edit_hostel','Edit Hostel'),(30,'room_name','Room Name'),(31,'no_of_beds','No Of Beds'),(32,'select_hostel_first','Select Hostel First'),(33,'remaining','Remaining'),(34,'hostel_fee','Hostel Fee'),(35,'accountant_list','Accountant List'),(36,'students_fees','Students Fees'),(37,'fees_status','Fees Status'),(38,'books','Books'),(39,'home_page','Home Page'),(40,'collected','Collected'),(41,'student_mark','Student Mark'),(42,'select_exam_first','Select Exam First'),(43,'transport_details','Transport Details'),(44,'no_of_teacher','No of Teacher'),(45,'basic_details','Basic Details'),(46,'fee_progress','Fee Progress'),(47,'word','Word'),(48,'book_category','Book Category'),(49,'driver_phone','Driver Phone'),(50,'invalid_csv_file','Invalid / Corrupted CSV File'),(51,'requested_book_list','Requested Book List'),(52,'request_status','Request Status'),(53,'book_request','Book Request'),(54,'logout','Logout'),(55,'select_payment_method','Select Payment Method'),(56,'select_method','Select Method'),(57,'payment','Payment'),(58,'filter','Filter'),(59,'status','Status'),(60,'paid','Paid'),(61,'unpaid','Unpaid'),(62,'method','Method'),(63,'cash','Cash'),(64,'check','Check'),(65,'card','Card'),(66,'payment_history','Payment History'),(67,'category','Category'),(68,'book_list','Book List'),(69,'author','Author'),(70,'price','Price'),(71,'available','Available'),(72,'unavailable','Unavailable'),(73,'transport_list','Transport List'),(74,'edit_transport','Edit Transport'),(75,'hostel_name','Hostel Name'),(76,'number_of_room','Hostel Of Room'),(77,'yes','Yes'),(78,'no','No'),(79,'messages','Messages'),(80,'compose','Compose'),(81,'recipient','Recipient'),(82,'select_a_user','Select A User'),(83,'send','Send'),(84,'global_settings','Global Settings'),(85,'currency','Currency'),(86,'system_email','System Email'),(87,'create','Create'),(88,'save','Save'),(89,'file','File'),(90,'theme_settings','Theme Settings'),(91,'default','Default'),(92,'select_theme','Select Theme'),(93,'upload_logo','Upload Logo'),(94,'upload','Upload'),(95,'remember','Remember'),(96,'not_selected','Not Selected'),(97,'disabled','Disabled'),(98,'inactive_account','Inactive Account'),(99,'update_translations','Update Translations'),(100,'language_list','Language List'),(101,'option','Option'),(102,'edit_word','Edit Word'),(103,'update_profile','Update Profile'),(104,'current_password','Current Password'),(105,'new_password','New Password'),(106,'login','Login'),(107,'reset_password','Reset Password'),(108,'present','Present'),(109,'absent','Absent'),(110,'update_attendance','Update Attendance'),(111,'undefined','Undefined'),(112,'back','Back'),(113,'save_changes','Save Changes'),(114,'uploader','Uploader'),(115,'download','Download'),(116,'remove','Remove'),(117,'print','Print'),(118,'select_file_type','Select File Type'),(119,'excel','Excel'),(120,'other','Other'),(121,'students_of_class','Students Of Class'),(122,'marks_obtained','Marks Obtained'),(123,'attendance_for_class','Attendance For Class'),(124,'receiver','Receiver'),(125,'please_select_receiver','Please Select Receiver'),(126,'session_changed','Session Changed'),(127,'exam_marks','Exam Marks'),(128,'total_mark','Total Mark'),(129,'mark_obtained','Mark Obtained'),(130,'invoice/payment_list','Invoice / Payment List'),(131,'obtained_marks','Obtained Marks'),(132,'highest_mark','Highest Mark'),(133,'grade','Grade (GPA)'),(134,'dashboard','Dashboard'),(135,'student','Student'),(136,'rename','Rename'),(137,'class','Class'),(138,'teacher','Teacher'),(139,'parents','Parents'),(140,'subject','Subject'),(141,'student_attendance','Student Attendance'),(142,'exam_list','Exam List'),(143,'grades_range','Grades Range'),(144,'loading','Loading'),(145,'library','Library'),(146,'hostel','Hostel'),(147,'events','Events'),(148,'message','Message'),(149,'translations','Translations'),(150,'account','Account'),(151,'selected_session','Selected Session'),(152,'change_password','Change Password'),(153,'section','Section'),(154,'edit','Edit'),(155,'delete','Delete'),(156,'cancel','Cancel'),(157,'parent','Parent'),(158,'attendance','Attendance'),(159,'addmission_form','Admission Form'),(160,'name','Name'),(161,'select','Select'),(162,'roll','Roll'),(163,'birthday','Date Of Birth'),(164,'gender','Gender'),(165,'male','Male'),(166,'female','Female'),(167,'address','Address'),(168,'phone','Phone'),(169,'email','Email'),(170,'password','Password'),(171,'transport_route','Transport Route'),(172,'photo','Photo'),(173,'select_class','Select Class'),(174,'username_password_incorrect','Username Or Password Is Incorrect'),(175,'select_section','Select Section'),(176,'options','Options'),(177,'mark_sheet','Mark Sheet'),(178,'profile','Profile'),(179,'select_all','Select All'),(180,'select_none','Select None'),(181,'average','Average'),(182,'transfer','Transfer'),(183,'edit_teacher','Edit Teacher'),(184,'sex','Sex'),(185,'marksheet_for','Marksheet For'),(186,'total_marks','Total Marks'),(187,'parent_phone','Parent Phone'),(188,'subject_author','Curriculum PDF'),(189,'update','Update'),(190,'class_list','Class List'),(191,'class_name','Class Name'),(192,'name_numeric','Name Numeric'),(193,'select_teacher','Select Teacher'),(194,'edit_class','Edit Class'),(195,'section_name','Section Name'),(196,'add_section','Add Section'),(197,'subject_list','Subject List'),(198,'subject_name','Subject Name'),(199,'edit_subject','Edit Subject'),(200,'day','Day'),(201,'starting_time','Starting Time'),(202,'hour','Hour'),(203,'minutes','Minutes'),(204,'ending_time','Ending Time'),(205,'select_subject','Select Subject'),(206,'select_date','Select Date'),(207,'select_month','Select Month'),(208,'select_year','Select Year'),(209,'add_language','Add Language'),(210,'exam_name','Exam Name'),(211,'date','Date'),(212,'comment','Comment'),(213,'edit_exam','Edit Exam'),(214,'grade_list','Grade List'),(215,'grade_name','Grade Name'),(216,'grade_point','Grade Point'),(217,'select_exam','Select Exam'),(218,'students','Students'),(219,'subjects','Subjects'),(220,'total','Total'),(221,'select_academic_session','Select Academic Session'),(222,'invoice_informations','Invoice Informations'),(223,'title','Title'),(224,'description','Description'),(225,'payment_informations','Payment Informations'),(226,'view_invoice','View Invoice'),(227,'payment_to','Payment To'),(228,'bill_to','Bill To'),(229,'total_amount','Total Amount'),(230,'paid_amount','Paid Amount'),(231,'due','Due'),(232,'amount_paid','Amount Paid'),(233,'payment_successfull','Payment has been successful'),(234,'add_invoice/payment','Add Invoice/payment'),(235,'invoices','Invoices'),(236,'action','Action'),(237,'required','Required'),(238,'info','Info'),(239,'month','Month'),(240,'details','Details'),(241,'new','New'),(242,'reply_message','Reply Message'),(243,'message_sent','Message Sent'),(244,'search','Search'),(245,'religion','Religion'),(246,'blood_group','Blood group'),(247,'database_backup','Database Backup'),(248,'search','Search'),(249,'payments_history','Payment History'),(250,'message_restore','Message Restore'),(251,'write_new_message','Write New Message'),(252,'attendance_sheet','Attendance Sheet'),(253,'holiday','Holiday'),(254,'exam','Exam'),(255,'successfully','Successfully'),(256,'admin','Admin'),(257,'inbox','Inbox'),(258,'sent','Sent'),(259,'important','Important'),(260,'trash','Trash'),(261,'error','Unsuccessful'),(262,'sessions_list','Sessions List'),(263,'session_settings','Session Settings'),(264,'add_designation','Add Designation'),(265,'users','Users'),(266,'librarian','Librarian'),(267,'accountant','Accountant'),(268,'academics','Academics'),(269,'employees_attendance','Employees Attendance'),(270,'set_exam_term','Set Exam Term'),(271,'set_attendance','Set Attendance'),(272,'marks','Marks'),(273,'books_category','Books Category'),(274,'transport','Transport'),(275,'fees','Fees'),(276,'fees_allocation','Levy Allocation'),(277,'fee_category','Fee Category'),(278,'report','Report'),(279,'employee','Employee'),(280,'invoice','Invoice'),(281,'event_catalogue','Event Catalogue'),(282,'total_paid','Total Paid'),(283,'total_due','Total Due'),(284,'fees_collect','Fees Collect'),(285,'total_school_students_attendance','Total School Students Attendance'),(286,'overview','Overview'),(287,'currency_symbol','Currency Symbol'),(288,'enable','Enable'),(289,'disable','Disable'),(290,'payment_settings','Payment Settings'),(291,'student_attendance_report','Student Attendance Report'),(292,'attendance_type','Attendance Type'),(293,'late','Late'),(294,'employees_attendance_report','Employees Attendance Report'),(295,'attendance_report_of','Attendance Report Of'),(296,'fee_paid_report','Fee Paid Report'),(297,'invoice_no','Invoice No'),(298,'payment_mode','Payment Mode'),(299,'payment_type','Payment Type'),(300,'done','Done'),(301,'select_fee_category','Select Fee Category'),(302,'discount','Discount'),(303,'enter_discount_amount','Enter Discount Amount'),(304,'online_payment','Online Payment'),(305,'student_name','Student Name'),(306,'invoice_history','Invoice History'),(307,'discount_amount','Discount Amount'),(308,'invoice_list','Invoice List'),(309,'partly_paid','Partly Paid'),(310,'fees_list','Fees List'),(311,'voucher_id','Voucher ID'),(312,'transaction_date','Transaction Date'),(313,'admission_date','Admission Date'),(314,'user_status','User Status'),(315,'nationality','Nationality'),(316,'register_no','Register No'),(317,'first_name','First Name'),(318,'last_name','Last Name'),(319,'state','State'),(320,'transport_vehicle_no','Transport Vehicle No'),(321,'percent','Percent'),(322,'average_result','Average Result'),(323,'student_category','Student Category'),(324,'category_name','Category Name'),(325,'category_list','Category List'),(326,'please_select_student_first','Please Select Students First'),(327,'designation','Designation'),(328,'qualification','Qualification'),(329,'account_deactivated','Account Deactivated'),(330,'account_activated','Account Activated'),(331,'designation_list','Designation List'),(332,'joining_date','Joining Date'),(333,'relation','Relation'),(334,'father_name','Father Name'),(335,'librarian_list','Librarian List'),(336,'class_numeric','Class Numeric'),(337,'maximum_students','Maximum Students'),(338,'class_room','Class Room'),(339,'pass_mark','Pass Mark'),(340,'exam_time','Exam Time (Min)'),(341,'time','Time'),(342,'subject_code','Subject Code'),(343,'full_mark','Full Mark'),(344,'subject_type','Subject Type'),(345,'date_of_publish','Date Of Publish'),(346,'file_name','File Name'),(347,'students_list','Students List'),(348,'start_date','Start Date'),(349,'end_date','End Date'),(350,'term_name','Term Name'),(351,'grand_total','Grand Total'),(352,'result','Result'),(353,'books_list','Books List'),(354,'book_isbn_no','Book ISBN No'),(355,'total_stock','Total Stock'),(356,'issued_copies','Issued Copies'),(357,'publisher','Publisher'),(358,'books_issue','Books Issue'),(359,'user','User'),(360,'fine','Fine'),(361,'pending','Pending'),(362,'return_date','Return Date'),(363,'accept','Accept'),(364,'reject','Reject'),(365,'issued','Issued'),(366,'return','Return'),(367,'renewal','Renewal'),(368,'fine_amount','Fine Amount'),(369,'password_mismatch','Password Mismatch'),(370,'settings_updated','Settings Update'),(371,'pass','Pass'),(372,'event_to','Event To'),(373,'all_users','All Users'),(374,'employees_list','Employees List'),(375,'on','On'),(376,'timezone','Timezone'),(377,'get_result','Get Result'),(378,'apply','Apply'),(379,'hrm','Human Resource'),(380,'payroll','Payroll'),(381,'salary_assign','Salary Assign'),(382,'employee_salary','Payment Salary'),(383,'application','Application'),(384,'award','Award'),(385,'basic_salary','Basic Salary'),(386,'employee_name','Employee Name'),(387,'name_of_allowance','Name Of Allowance'),(388,'name_of_deductions','Name Of Deductions'),(389,'all_employees','All Employees'),(390,'total_allowance','Total Allowance'),(391,'total_deduction','Total Deductions'),(392,'net_salary','Net Salary'),(393,'payslip','Payslip'),(394,'days','Days'),(395,'category_name_already_used','Category Name Already Used'),(396,'leave_list','Leave List'),(397,'leave_category','Leave Category'),(398,'applied_on','Applied On'),(399,'accepted','Accepted'),(400,'leave_statistics','Leave Statistics'),(401,'leave_type','Leave Type'),(402,'reason','Reason'),(403,'close','Close'),(404,'give_award','Give Award'),(405,'list','List'),(406,'award_name','Award Name'),(407,'gift_item','Gift Item'),(408,'cash_price','Cash Price'),(409,'award_reason','Award Reason'),(410,'given_date','Given Date'),(411,'apply_leave','Apply Leave'),(412,'leave_application','Leave Application'),(413,'allowances','Allowances'),(414,'add_more','Add More'),(415,'deductions','Deductions'),(416,'salary_details','Salary Details'),(417,'salary_month','Salary Month'),(418,'leave_data_update_successfully','Leave Data Updated Successfully'),(419,'fees_history','Fees History'),(420,'bank_name','Bank Name'),(421,'branch','Tahsin Academy'),(422,'bank_address','Bank Address'),(423,'ifsc_code','IFSC Code'),(424,'account_no','Account No'),(425,'add_bank','Add Bank'),(426,'account_name','Account Holder'),(427,'database_backup_completed','Database Backup Completed'),(428,'restore_database','Restore Database'),(429,'template','Template'),(430,'time_and_date','Time And Date'),(431,'everyone','Everyone'),(432,'invalid_amount','Invalid Amount'),(433,'leaving_date_is_not_available_for_you','Leaving Date Is Not Available For You'),(434,'animations','Animations'),(435,'email_settings','Email Settings'),(436,'deduct_month','Deduct Month'),(437,'no_employee_available','No Employee Available'),(438,'advance_salary_application_submitted','Advance Salary Application Submitted'),(439,'date_format','Date Format'),(440,'id_card_generate','ID Card Generate'),(441,'issue_salary','Issue Salary'),(442,'advance_salary','Advance Salary'),(443,'logo','Logo'),(444,'book_request','Book Request'),(445,'reporting','Reporting'),(446,'paid_salary','Paid Salary'),(447,'due_salary','Due Salary'),(448,'route','Route'),(449,'academic_details','Academic Details'),(450,'guardian_details','Guardian Details'),(451,'due_amount','Due Amount'),(452,'fee_due_report','Fee Due Report'),(453,'other_details','Other Details'),(454,'last_exam_report','Last Exam Report'),(455,'book_issued','Book Issued'),(456,'interval_month','Interval 30 Days'),(457,'attachments','Attachments'),(458,'fees_payment','Fees Payment'),(459,'fees_summary','Fees Summary'),(460,'total_fees','Total Fees'),(461,'weekend_attendance_inspection','Weekend Attendance Inspection'),(462,'book_issued_list','Book Issued List'),(463,'lose_your_password','Lose Your Password?'),(465,'academic_session','Academic Session'),(467,'admission','Admission'),(468,'create_admission','Create Admission'),(469,'multiple_import','Multiple Import'),(470,'student_details','Student Details'),(471,'student_list','Student List'),(472,'login_deactivate','Login Deactivate'),(473,'parents_list','Parents List'),(474,'add_parent','Add Parent'),(475,'employee_list','Employee List'),(476,'add_department','Add Department'),(477,'add_employee','Add Employee'),(478,'salary_template','Salary Template'),(479,'salary_payment','Salary Payment'),(480,'payroll_summary','Payroll Summary'),(481,'academic','Academic'),(482,'control_classes','Control Classes'),(483,'assign_class_teacher','Assign Class Teacher'),(484,'class_assign','Class Assign'),(485,'assign','Assign'),(486,'promotion','Promotion'),(487,'attachments_book','Attachments Book'),(488,'upload_content','Upload Content'),(489,'attachment_type','Attachment Type'),(490,'exam_master','Exam Master'),(491,'exam_hall','Exam Hall'),(492,'mark_entries','Mark Entries'),(493,'tabulation_sheet','Tabulation Sheet'),(494,'supervision','Supervision'),(495,'hostel_master','Hostel Master'),(496,'hostel_room','Hostel Room'),(497,'allocation_report','Allocation Report'),(498,'route_master','Route Master'),(499,'vehicle_master','Vehicle Master'),(500,'stoppage','Stoppage'),(501,'assign_vehicle','Assign Vehicle'),(502,'reports','Reports'),(503,'books_entry','Books Entry'),(504,'event_type','Event Type'),(505,'add_events','Add Events'),(506,'student_accounting','Levies & Charges'),(507,'create_single_invoice','Create Single Invoice'),(508,'create_multi_invoice','Create Multi Invoice'),(509,'summary_report','Summary Report'),(510,'office_accounting','Office Accounting'),(511,'under_group','Under Group'),(512,'bank_account','Bank Account'),(513,'ledger_account','Ledger Account'),(514,'create_voucher','Create Voucher'),(515,'day_book','Day Book'),(516,'cash_book','Cash Book'),(517,'bank_book','Bank Book'),(518,'ledger_book','Ledger Book'),(519,'trial_balance','Trial Balance'),(520,'settings','Settings'),(521,'sms_settings','Sms Settings'),(522,'cash_book_of','Cash Book Of'),(523,'by_cash','By Cash'),(524,'by_bank','By Bank'),(525,'total_strength','Total Strength'),(526,'teachers','Teachers'),(527,'student_quantity','Student Quantity'),(528,'voucher','Voucher'),(529,'total_number','Total Number'),(530,'total_route','Total Route'),(531,'total_room','Total Room'),(532,'amount','Amount'),(533,'branch_dashboard','Dashboard'),(536,'branch_name','School Name'),(537,'school_name','School Name'),(538,'mobile_no','Mobile No'),(539,'symbol','Symbol'),(540,'city','City'),(541,'academic_year','Academic Year'),(543,'select_class_first','Select Class First'),(544,'select_country','Select Country'),(545,'mother_tongue','Mother Tongue'),(546,'caste','Caste'),(547,'present_address','Present Address'),(548,'permanent_address','Permanent Address'),(549,'profile_picture','Profile Picture'),(550,'login_details','Login Details'),(551,'retype_password','Retype Password'),(552,'occupation','Occupation'),(553,'income','Income'),(554,'education','Education'),(555,'first_select_the_route','First Select The Route'),(556,'hostel_details','Hostel Details'),(557,'first_select_the_hostel','First Select The Hostel'),(558,'previous_school_details','Previous School Details'),(559,'book_name','Book Name'),(560,'select_ground','Select Ground'),(561,'import','Import'),(562,'add_student_category','Add Student Category'),(563,'id','Id'),(564,'edit_category','Edit Category'),(565,'deactivate_account','Deactivate Account'),(566,'all_sections','All Sections'),(567,'authentication_activate','Authentication Activate'),(568,'department','Department'),(569,'salary_grades','Salary Grades'),(570,'overtime','Overtime Rate (Per Hour)'),(571,'salary_grade','Salary Grade'),(572,'payable_type','Payable Type'),(573,'edit_type','Edit Type'),(574,'role','Role'),(575,'remuneration_info_for','Remuneration Info For'),(576,'salary_paid','Salary Paid'),(577,'salary_unpaid','Salary Unpaid'),(578,'pay_now','Pay Now'),(579,'employee_role','Employee Role'),(580,'create_at','Create At'),(581,'select_employee','Select Employee'),(582,'review','Review'),(583,'reviewed_by','Reviewed By'),(584,'submitted_by','Submitted By'),(585,'employee_type','Employee Type'),(586,'approved','Approved'),(587,'unreviewed','Unreviewed'),(588,'creation_date','Creation Date'),(589,'no_information_available','No Information Available'),(590,'continue_to_payment','Continue To Payment'),(591,'overtime_total_hour','Overtime Total Hour'),(592,'overtime_amount','Overtime Amount'),(593,'remarks','Remarks'),(594,'view','View'),(595,'leave_appeal','Leave Appeal'),(596,'create_leave','Create Leave'),(597,'user_role','User Role'),(598,'date_of_start','Date Of Start'),(599,'date_of_end','Date Of End'),(600,'winner','Winner'),(601,'select_user','Select User'),(602,'create_class','Create Class'),(603,'class_teacher_allocation','Class Teacher Allocation'),(604,'class_teacher','Class Teacher'),(605,'create_subject','Create Subject'),(606,'select_multiple_subject','Select Multiple Subject'),(607,'teacher_assign','Teacher Assign'),(608,'teacher_assign_list','Teacher Assign List'),(609,'select_department_first','Select Department First'),(610,'create_book','Create Book'),(611,'book_title','Book Title'),(612,'cover','Cover'),(613,'edition','Edition'),(614,'isbn_no','ISBN No'),(615,'purchase_date','Purchase Date'),(616,'cover_image','Cover Image'),(617,'book_issue','Book Issue'),(618,'date_of_issue','Date Of Issue'),(619,'date_of_expiry','Date Of Expiry'),(620,'select_category_first','Select Category First'),(621,'type_name','Type Name'),(622,'type_list','Type List'),(623,'icon','Icon'),(624,'event_list','Event List'),(625,'create_event','Create Event'),(626,'type','Type'),(627,'audience','Audience'),(628,'created_by','Created By'),(629,'publish','Publish'),(630,'everybody','Everybody'),(631,'selected_class','Selected Class'),(632,'selected_section','Selected Section'),(633,'information_has_been_updated_successfully','Information Has Been Updated Successfully'),(634,'create_invoice','Create Invoice'),(635,'invoice_entry','Invoice Entry'),(636,'quick_payment','Quick Payment'),(637,'write_your_remarks','Write Your Remarks'),(638,'reset','Reset'),(639,'fees_payment_history','Fees Payment History'),(640,'fees_summary_report','Fees Summary Report'),(641,'add_account_group','Add Account Group'),(642,'account_group','Account Group'),(643,'account_group_list','Account Group List'),(644,'mailbox','Mailbox'),(645,'refresh_mail','Refresh Mail'),(646,'sender','Sender'),(647,'general_settings','General Settings'),(648,'institute_name','Institute Name'),(649,'institution_code','Institution Code'),(650,'sms_service_provider','Sms Service Provider'),(651,'footer_text','Footer Text'),(652,'payment_control','Payment Control'),(653,'sms_config','Sms Config'),(654,'sms_triggers','Sms Triggers'),(655,'authentication_token','Authentication Token'),(656,'sender_number','Sender Number'),(657,'username','Username'),(658,'api_key','Api Key'),(659,'authkey','Authkey'),(660,'sender_id','Sender Id'),(661,'sender_name','Sender Name'),(662,'hash_key','Hash Key'),(663,'notify_enable','Notify Enable'),(664,'exam_attendance','Exam Attendance'),(665,'exam_results','Exam Results'),(666,'email_config','Email Config'),(667,'email_triggers','Email Triggers'),(668,'account_registered','Account Registered'),(669,'forgot_password','Forgot Password'),(670,'new_message_received','New Message Received'),(671,'payslip_generated','Payslip Generated'),(672,'leave_approve','Leave Approve'),(673,'leave_reject','Leave Reject'),(674,'advance_salary_approve','Leave Reject'),(675,'advance_salary_reject','Advance Salary Reject'),(676,'add_session','Add Session'),(677,'session','Session'),(678,'created_at','Created At'),(679,'sessions','Sessions'),(680,'flag','Flag'),(681,'stats','Stats'),(682,'updated_at','Updated At'),(683,'flag_icon','Flag Icon'),(684,'password_restoration','Password Restoration'),(685,'forgot','Forgot'),(686,'back_to_login','Back To Login'),(687,'database_list','Database List'),(688,'create_backup','Create Backup'),(689,'backup','Backup'),(690,'backup_size','Backup Size'),(691,'file_upload','File Upload'),(692,'parents_details','Parents Details'),(693,'social_links','Social Links'),(694,'create_hostel','Create Hostel'),(695,'allocation_list','Allocation List'),(696,'payslip_history','Payslip History'),(697,'my_attendance_overview','My Attendance Overview'),(698,'total_present','Total Present'),(699,'total_absent','Total Absent'),(700,'total_late','Total Late'),(701,'class_teacher_list','Class Teacher List'),(702,'section_control','Section Control'),(703,'capacity ','Capacity'),(704,'request','Request'),(705,'salary_year','Salary Year'),(706,'create_attachments','Create Attachments'),(707,'publish_date','Publish Date'),(708,'attachment_file','Attachment File'),(709,'age','Age'),(710,'student_profile','Student Profile'),(711,'authentication','Authentication'),(712,'parent_information','Parent Information'),(713,'full_marks','Full Marks'),(714,'passing_marks','Passing Marks'),(715,'highest_marks','Highest Marks'),(716,'unknown','Unknown'),(717,'unpublish','Unpublish'),(718,'login_authentication_deactivate','Login Authentication Deactivate'),(719,'employee_profile','Employee Profile'),(720,'employee_details','Employee Details'),(721,'salary_transaction','Salary Transaction'),(722,'documents','Documents'),(723,'actions','Actions'),(724,'activity','Activity'),(725,'department_list','Department List'),(726,'manage_employee_salary','Manage Employee Salary'),(727,'the_configuration_has_been_updated','The Configuration Has Been Updated'),(728,'add','Add'),(729,'create_exam','Create Exam'),(730,'term','Term'),(731,'add_term','Add Term'),(732,'create_grade','Create Grade'),(733,'mark_starting','Mark Starting'),(734,'mark_until','Mark Until'),(735,'room_list','Room List'),(736,'room','Room'),(737,'route_list','Route List'),(738,'create_route','Create Route'),(739,'vehicle_list','Vehicle List'),(740,'create_vehicle','Create Vehicle'),(741,'stoppage_list','Stoppage List'),(742,'create_stoppage','Create Stoppage'),(743,'stop_time','Stop Time'),(744,'employee_attendance','Employee Attendance'),(745,'attendance_report','Attendance Report'),(746,'opening_balance','Opening Balance'),(747,'add_opening_balance','Add Opening Balance'),(748,'credit','Credit'),(749,'debit','Debit'),(750,'opening_balance_list','Opening Balance List'),(751,'voucher_list','Voucher List'),(752,'voucher_head','Voucher Head'),(753,'payment_method','Payment Method'),(754,'credit_ledger_account','Credit Ledger Account'),(755,'debit_ledger_account','Debit Ledger Account'),(756,'voucher_no','Voucher No'),(757,'balance','Balance'),(758,'event_details','Event Details'),(759,'welcome_to','Welcome To'),(760,'report_card','Report Card'),(761,'online_pay','Online Pay'),(762,'annual_fees_summary','Annual Fees Summary'),(763,'my_children','My Children'),(764,'assigned','Assigned'),(765,'confirm_password','Confirm Password'),(766,'searching_results','Searching Results'),(767,'information_has_been_saved_successfully','Information Has Been Saved Successfully'),(768,'information_deleted','The information has been successfully deleted'),(769,'deleted_note','*Note : This data will be permanently deleted'),(770,'are_you_sure','Are You Sure?'),(771,'delete_this_information','Do You Want To Delete This Information?'),(772,'yes_continue','Yes, Continue'),(773,'deleted','Deleted'),(774,'collect','Collect'),(775,'school_setting','School Setting'),(776,'set','Set'),(777,'quick_view','Quick View'),(778,'due_fees_invoice','Pending Levy Invoice'),(779,'my_application','My Application'),(780,'manage_application','Manage Application'),(781,'leave','Leave'),(782,'live_class_rooms','Live Class Rooms'),(783,'homework','Homework'),(784,'evaluation_report','Evaluation Report'),(785,'exam_term','Exam Term'),(786,'distribution','Distribution'),(787,'exam_setup','Exam Setup'),(788,'sms','Sms'),(789,'fees_type','Levy Type'),(790,'fees_group','Levy Group'),(791,'fine_setup','Surcharge Setup'),(792,'fees_reminder','Levy Reminder'),(793,'new_deposit','New Deposit'),(794,'new_expense','New Expense'),(795,'all_transactions','All Transactions'),(796,'head','Head'),(797,'fees_reports','Levy Reports'),(798,'fees_report','Levy Report'),(799,'receipts_report','Receipts Report'),(800,'due_fees_report','Pending Levy Report'),(801,'fine_report','Surcharge Report'),(802,'financial_reports','Financial Reports'),(803,'statement','Statement'),(804,'repots','Repots'),(805,'expense','Expense'),(806,'transitions','Transitions'),(807,'sheet','Sheet'),(808,'income_vs_expense','Income Vs Expense'),(809,'attendance_reports','Attendance Reports'),(810,'examination','Examination'),(811,'school_settings','School Settings'),(812,'role_permission','Role Permission'),(813,'cron_job','Cron Job'),(814,'custom_field','Custom Field'),(815,'enter_valid_email','Enter Valid Email'),(816,'lessons','Lessons'),(817,'live_class','Live Class'),(818,'sl','Sl'),(819,'meeting_id','Meeting ID'),(820,'start_time','Start Time'),(821,'end_time','End Time'),(822,'zoom_meeting_id','Zoom Meeting Id'),(823,'zoom_meeting_password','Zoom Meeting Password'),(824,'time_slot','Time Slot'),(825,'send_notification_sms','Send Notification Sms'),(826,'host','Host'),(827,'school','School'),(828,'accounting_links','Accounting Links'),(829,'applicant','Applicant'),(830,'apply_date','Apply Date'),(831,'add_leave','Add Leave'),(832,'leave_date','Leave Date'),(833,'attachment','Attachment'),(834,'comments','Comments'),(835,'staff_id','Staff Id'),(836,'income_vs_expense_of','Income Vs Expense Of'),(837,'designation_name','Designation Name'),(838,'already_taken','This %s already exists.'),(839,'department_name','Department Name'),(840,'date_of_birth','Date Of Birth'),(841,'bulk_delete','Bulk Delete'),(842,'guardian_name','Guardian Name'),(843,'fees_progress','Fees Progress'),(844,'evaluate','Evaluate'),(845,'date_of_homework','Date Of Homework'),(846,'date_of_submission','Date Of Submission'),(847,'student_fees_report','Student Fees Report'),(848,'student_fees_reports','Student Fees Reports'),(849,'due_date','Due Date'),(850,'payment_date','Payment Date'),(851,'payment_via','Payment Via'),(852,'generate','Generate'),(853,'print_date','Print Date'),(854,'bulk_sms_and_email','Bulk Sms And Email'),(855,'campaign_type','Campaign Type'),(856,'both','Both'),(857,'regular','Regular'),(858,'Scheduled','Scheduled'),(859,'campaign','Campaign'),(860,'campaign_name','Campaign Name'),(861,'sms_gateway','Sms Gateway'),(862,'recipients_type','Recipients Type'),(863,'recipients_count','Recipients Count'),(864,'body','Body'),(865,'guardian_already_exist','Guardian Already Exist'),(866,'guardian','Guardian'),(867,'mother_name','Mother Name'),(868,'bank_details','Bank Details'),(869,'skipped_bank_details','Skipped Bank Details'),(870,'bank','Bank'),(871,'holder_name','Holder Name'),(872,'bank_branch','Bank Branch'),(873,'custom_field_for','Custom Field For'),(874,'label','Label'),(875,'order','Order'),(876,'online_admission','Online Admission'),(877,'field_label','Field Label'),(878,'field_type','Field Label'),(879,'default_value','Default Value'),(880,'checked','Checked'),(881,'unchecked','Unchecked'),(882,'roll_number','Roll Number'),(883,'add_rows','Add Rows'),(884,'salary','Salary'),(885,'basic','Basic'),(886,'allowance','Allowance'),(887,'deduction','Deduction'),(888,'net','Net'),(889,'activated_sms_gateway','Activated Sms Gateway'),(890,'account_sid','Account Sid'),(891,'roles','Roles'),(892,'system_role','System Role'),(893,'permission','Permission'),(894,'edit_session','Edit Session'),(895,'transactions','Transactions'),(896,'default_account','Default Account'),(897,'deposit','Deposit'),(898,'acccount','Acccount'),(899,'role_permission_for','Role Permission For'),(900,'feature','Feature'),(901,'access_denied','Access Denied'),(902,'time_start','Time Start'),(903,'time_end','Time End'),(904,'month_of_salary','Month Of Salary'),(905,'add_documents','Add Documents'),(906,'document_type','Document Type'),(907,'document','Document'),(908,'document_title','Document Title'),(909,'document_category','Document Category'),(910,'exam_result','Exam Result'),(911,'my_annual_fee_summary','My Annual Fee Summary'),(912,'book_manage','Book Manage'),(913,'add_leave_category','Add Leave Category'),(914,'edit_leave_category','Edit Leave Category'),(915,'staff_role','Staff Role'),(916,'edit_assign','Edit Assign'),(917,'view_report','View Report'),(918,'rank_out_of_5','Rank Out Of 5'),(919,'hall_no','Hall No'),(920,'no_of_seats','No Of Seats'),(921,'mark_distribution','Mark Distribution'),(922,'exam_type','Exam Type'),(923,'marks_and_grade','Marks And Grade'),(924,'min_percentage','Min Percentage'),(925,'max_percentage','Max Percentage'),(926,'cost_per_bed','Cost Per Bed'),(927,'add_category','Add Category'),(928,'category_for','Category For'),(929,'start_place','Start Place'),(930,'stop_place','Stop Place'),(931,'vehicle','Vehicle'),(932,'select_multiple_vehicle','Select Multiple Vehicle'),(933,'book_details','Book Details'),(934,'issued_by','Issued By'),(935,'return_by','Return By'),(936,'group','Group'),(937,'individual','Individual'),(938,'recipients','Recipients'),(939,'group_name','Group Name'),(940,'fee_code','Fee Code'),(941,'fine_type','Fine Type'),(942,'fine_value','Fine Value'),(943,'late_fee_frequency','Late Fee Frequency'),(944,'fixed_amount','Fixed Amount'),(945,'fixed','Fixed'),(946,'daily','Daily'),(947,'weekly','Weekly'),(948,'monthly','Monthly'),(949,'annually','Annually'),(950,'first_select_the_group','First Select The Group'),(951,'percentage','Percentage'),(952,'value','Value'),(953,'fee_group','Fee Group'),(954,'due_invoice','Due Invoice'),(955,'reminder','Reminder'),(956,'frequency','Frequency'),(957,'notify','Notify'),(958,'before','Before'),(959,'after','After'),(960,'number','Number'),(961,'ref_no','Ref No'),(962,'pay_via','Pay Via'),(963,'ref','Ref'),(964,'dr','Dr'),(965,'cr','Cr'),(966,'edit_book','Edit Book'),(967,'leaves','Leaves'),(968,'leave_request','Leave Request'),(969,'this_file_type_is_not_allowed','This File Type Is Not Allowed'),(970,'error_reading_the_file','Error Reading The File'),(971,'staff','Staff'),(972,'waiting','Waiting'),(973,'live','Live'),(974,'by','By'),(975,'host_live_class','Host Live Class'),(976,'join_live_class','Join Live Class'),(977,'system_logo','System Logo'),(978,'text_logo','Text Logo'),(979,'printing_logo','Printing Logo'),(980,'expired','Expired'),(981,'collect_fees','Collect Fees'),(982,'fees_code','Fees Code'),(983,'collect_by','Collect By'),(984,'fee_payment','Fee Payment'),(985,'write_message','Write Message'),(986,'discard','Discard'),(987,'message_sent_successfully','Message Sent Successfully'),(988,'visit_home_page','Visit Home Page'),(989,'frontend','Frontend'),(990,'setting','Setting'),(991,'menu','Menu'),(992,'page','Page'),(993,'manage','Manage'),(994,'slider','Slider'),(995,'features','Features'),(996,'testimonial','Testimonial'),(997,'service','Service'),(998,'faq','Faq'),(999,'card_management','Card Management'),(1000,'id_card','Id Card'),(1001,'templete','Templete'),(1002,'admit_card','Admit Card'),(1003,'certificate','Certificate'),(1004,'system_update','System Update'),(1005,'url','Url'),(1006,'content','Content'),(1007,'banner_photo','Banner Photo'),(1008,'meta','Meta'),(1009,'keyword','Keyword'),(1010,'applicable_user','Applicable User'),(1011,'page_layout','Page Layout'),(1012,'background','Background'),(1013,'image','Image'),(1014,'width','Width'),(1015,'height','Height'),(1016,'signature','Signature'),(1017,'website','Website'),(1018,'cms','Cms'),(1019,'url_alias','Url Alias'),(1020,'cms_frontend','Cms Frontend'),(1021,'enabled','Enabled'),(1022,'receive_email_to','Receive Email To'),(1023,'captcha_status','Captcha Status'),(1024,'recaptcha_site_key','Recaptcha Site Key'),(1025,'recaptcha_secret_key','Recaptcha Secret Key'),(1026,'working_hours','Working Hours'),(1027,'fav_icon','Fav Icon'),(1028,'theme','Theme'),(1029,'fax','Fax'),(1030,'footer_about_text','Footer About Text'),(1031,'copyright_text','Copyright Text'),(1032,'facebook_url','Facebook Url'),(1033,'twitter_url','Twitter Url'),(1034,'youtube_url','Youtube Url'),(1035,'google_plus','Google Plus'),(1036,'linkedin_url','Linkedin Url'),(1037,'pinterest_url','Pinterest Url'),(1038,'instagram_url','Instagram Url'),(1039,'play','Play'),(1040,'video','Video'),(1041,'usename','Usename'),(1042,'experience_details','Experience Details'),(1043,'total_experience','Total Experience'),(1044,'class_schedule','Class Schedule'),(1046,'website_page','Website Page'),(1047,'welcome','Welcome'),(1048,'services','Services'),(1049,'call_to_action_section','Call To Action Section'),(1050,'subtitle','Subtitle'),(1051,'cta','Cta'),(1052,'button_text','Button Text'),(1053,'button_url','Button Url'),(1054,'_title',' Title'),(1055,'contact','Contact'),(1056,'box_title','Box Title'),(1057,'box_description','Box Description'),(1058,'box_photo','Box Photo'),(1059,'form_title','Form Title'),(1060,'submit_button_text','Submit Button Text'),(1061,'map_iframe','Map Iframe'),(1062,'email_subject','Email Subject'),(1063,'prefix','Prefix'),(1064,'surname','Surname'),(1065,'rank','Rank'),(1066,'submit','Submit'),(1067,'certificate_name','Certificate Name'),(1068,'layout_width','Layout Width'),(1069,'layout_height','Layout Height'),(1070,'expiry_date','Expiry Date'),(1071,'position','Position'),(1072,'target_new_window','Target New Window'),(1073,'external_url','External Url'),(1074,'external_link','External Link'),(1075,'sms_notification','Sms Notification'),(1076,'scheduled_at','Scheduled At'),(1077,'published','Published'),(1078,'unpublished_on_website','Unpublished On Website'),(1079,'published_on_website','Published On Website'),(1080,'no_selection_available','No Selection Available'),(1081,'select_for_everyone','Select For Everyone'),(1082,'teacher_restricted','Teacher Restricted'),(1083,'guardian_relation','Guardian Relation'),(1084,'username_prefix','Username Prefix'),(1085,'default_password','Default Password'),(1086,'parents_profile','Parents Profile'),(1087,'childs','Childs'),(1088,'page_title','Page Title'),(1089,'select_menu','Select Menu'),(1090,'meta_keyword','Meta Keyword'),(1091,'meta_description','Meta Description'),(1092,'evaluation_date','Evaluation Date'),(1093,'evaluated_by','Evaluated By'),(1094,'complete','Complete'),(1095,'incomplete','Incomplete'),(1096,'payment_details','Payment Details'),(1097,'edit_attachments','Edit Attachments'),(1098,'live_classes','Live Classes'),(1099,'duration','Duration'),(1100,'metting_id','Metting Id'),(1101,'set_record','Set Record'),(1102,'set_mute_on_start','Set Mute On Start'),(1103,'button_text_1','Button Text 1'),(1104,'button_url_1','Button Url 1'),(1105,'button_text_2','Button Text 2'),(1106,'button_url_2','Button Url 2'),(1107,'left','Left'),(1108,'center','Center'),(1109,'right','Right'),(1110,'about','About'),(1111,'about_photo','About Photo'),(1112,'parallax_photo','Parallax Photo'),(1113,'decline','Decline'),(1114,'edit_grade','Edit Grade'),(1115,'mark','Mark'),(1116,'hall_room','Hall Room'),(1117,'student_promotion','Student Promotion'),(1118,'username_has_already_been_used','Username Has Already Been Used'),(1119,'fee_collection','Fee Collection'),(1120,'not_found_anything','Not Found Anything'),(1121,'preloader_backend','Preloader Backend'),(1122,'ive_class_method','Ive Class Method'),(1123,'live_class_method','Live Class Method'),(1124,'api_credential','Api Credential'),(1125,'translation_update','Translation Update'),(1126,' live_class_reports',' Live Class Reports'),(1127,'live_class_reports','Live Class Reports'),(1128,'all','All'),(1129,'student_participation_report','Student Participation Report'),(1130,'joining_time','Joining Time'),(1131,'inventory','School Assets'),(1132,'product','Product'),(1133,'store','Store'),(1134,'supplier','Supplier'),(1135,'unit','Unit'),(1136,'purchase','Purchase'),(1137,'sales','Sales'),(1138,'issue','Issue'),(1139,'gallery','Gallery'),(1140,'news','News'),(1141,'reception','Reception'),(1142,'admission_enquiry','Admission Enquiry'),(1143,'postal_record','Postal Record'),(1144,'call_log','Call Log'),(1145,'visitor_log','Visitor Log'),(1146,'complaint','Complaint'),(1147,'multi_class','Multi Class'),(1148,'deactivate_reason','Deactivate Reason'),(1149,'marksheet','Marksheet'),(1150,'generate_position','Generate Position'),(1151,'online_exam','Online Exam'),(1152,'question_bank','Question Bank'),(1153,'question_group','Question Group'),(1154,'fees_setup','Fees Setup'),(1155,'subject_wise','Subject Wise'),(1156,'my_issued_book','My Issued Book'),(1157,'book_issue/return','Book Issue/return'),(1158,'offline_payments','Offline Payments'),(1159,'payments','Payments'),(1160,' offline_payments',' Offline Payments'),(1161,'login_credential','Login Credential'),(1162,'admission_report','Admission Report'),(1163,'class_&_section_report','Class & Section Report'),(1164,'sibling_report','Sibling Report'),(1165,'daily_reports','Daily Reports'),(1166,'overview_reports','Overview Reports'),(1167,'subject_wise_reports','Subject Wise Reports'),(1168,'subject_wise_by','Subject Wise By'),(1169,'progress','Progress'),(1170,'stock','Stock'),(1171,'issues','Issues'),(1172,'alumni','Alumni'),(1173,'manage_alumni','Manage Alumni'),(1174,'addon_manager','Addon Manager'),(1175,'modules','Modules'),(1176,'system_student_field','System Student Field'),(1177,'user_login_log','User Login Log'),(1178,'march','March'),(1179,'today_birthday','Today Birthday'),(1180,'addon','Addon'),(1181,'install','Install'),(1182,'version','Version'),(1183,'installed','Installed'),(1184,'last_upgrade','Last Upgrade'),(1185,'addon_purchase_code','Addon Purchase Code'),(1186,'install_now','Install Now'),(1187,'cache_control','Cache Control'),(1188,'currency_formats','Currency Formats'),(1189,'symbol_position','Symbol Position'),(1190,'database_backup_failed','Database Backup Failed'),(1191,'clear_userlog','Clear Userlog'),(1192,'browser','Browser'),(1193,'login_date_time','Login Date Time'),(1194,'platform','Platform'),(1195,'passing_session','Passing Session'),(1196,'profession','Profession'),(1197,'event','Event'),(1198,'note','Note'),(1199,'send_confirmation_sms','Send Confirmation Sms'),(1200,'change','Change'),(1201,'admission_reports','Admission Reports'),(1202,'class_&_section','Class & Section'),(1203,'questions_qty','Questions Qty'),(1204,'exam_status','Exam Status'),(1205,'limits_of_participation','Limits Of Participation'),(1206,'passing_mark','Passing Mark'),(1207,'instruction','Instruction'),(1208,'free','Free'),(1209,'question','Question'),(1210,'random','Random'),(1211,'result_publish','Result Publish'),(1212,'negative_mark','Negative Mark'),(1213,'applicable','Applicable'),(1214,'marks_display','Marks Display'),(1215,'make','Make'),(1217,'code','Code'),(1218,'purchase_unit','Purchase Unit'),(1219,'sale_unit','Sale Unit'),(1220,'unit_ratio','Unit Ratio'),(1221,'purchase_price','Purchase Price'),(1222,'sales_price','Sales Price'),(1223,'sales_unit','Sales Unit'),(1224,'whatsapp_settings','Whatsapp Settings'),(1225,'general_setting','General Setting'),(1226,'weekends','Weekends'),(1227,'sunday','Sunday'),(1228,'monday','Monday'),(1229,'tuesday','Tuesday'),(1230,'wednesday','Wednesday'),(1231,'thursday','Thursday'),(1232,'friday','Friday'),(1233,'saturday','Saturday'),(1234,'select_weekends','Select Weekends'),(1235,'unique_roll','Unique Roll'),(1236,'classes_wise','Classes Wise'),(1237,'section_wise','Section Wise'),(1238,'start_from','Start From'),(1239,'digit','Digit'),(1240,'fees_carry_forward_setting','Fees Carry Forward Setting'),(1241,'due_days','Due Days'),(1242,'due_fees_calculation_with_fine_','Due Fees Calculation With Fine '),(1243,'store_code','Store Code'),(1244,'google_analytics','Google Analytics'),(1245,'parent_menu','Parent Menu'),(1246,'statistics','Statistics'),(1247,'employees','Employees'),(1248,'classes','Classes'),(1249,'fields_setting','Fields Setting'),(1250,'terms_conditions','Terms Conditions'),(1251,'admission_application_form','Admission Application Form'),(1252,'online_addmission','Online Addmission'),(1253,'fee','Fee'),(1254,'fields','Fields'),(1255,'active','Active'),(1256,'reference','Reference'),(1257,'response','Response'),(1258,'calling_purpose','Calling Purpose'),(1259,'visiting_purpose','Visiting Purpose'),(1260,'guardian_picture','Guardian Picture'),(1261,'pickup_point','Pickup Point'),(1262,'exploring','Exploring'),(1263,'leave_days','Leave Days'),(1264,'create_section','Create Section'),(1265,'section_list','Section List'),(1266,'set_parameters_to_quickly_create_schedule','Set Parameters To Quickly Create Schedule'),(1267,'starting_date','Starting Date'),(1268,'interval','Interval'),(1269,'the_next_session_was_transferred_to_the_students','The Next Session Was Transferred To The Students'),(1270,'promote_to_session','Promote To Session'),(1271,'promote_to_class','Promote To Class'),(1272,'promote_to_section','Promote To Section'),(1273,'mark_summary','Mark Summary'),(1274,'current_due_amount','Current Due Amount'),(1275,'with_fine','With Fine'),(1276,'publish_result','Publish Result'),(1277,'middle','Middle'),(1278,'header','Header'),(1279,'footer','Footer'),(1280,'grading_scale','Grading Scale'),(1281,'cumulative','Cumulative'),(1282,'remark','Remark'),(1283,'class_position','Class Position'),(1284,'level','Level'),(1285,'single_choice','Single Choice'),(1286,'multiple_choice','Multiple Choice'),(1287,'true/false','True/false'),(1288,'descriptive','Descriptive'),(1289,'easy','Easy'),(1290,'medium','Medium'),(1291,'hard','Hard'),(1292,'half_day','Half Day'),(1293,'show_website','Show Website'),(1294,'all_section','All Section'),(1295,'all_class','All Class'),(1296,'no_row_are_selected','No Row Are Selected'),(1297,'restore','Restore'),(1298,'delete_forever','Delete Forever'),(1299,'all_select','All Select'),(1300,'product_stock','Product Stock'),(1301,'purchase_qty','Purchase Qty'),(1302,'total_issued','Total Issued'),(1303,'total_sales','Total Sales'),(1304,'current','Current'),(1305,'april','April'),(1306,'reference_no','Reference No'),(1307,'payment_status','Payment Status'),(1308,'promotion_history','Promotion History'),(1309,'from_class','From Class'),(1310,'from_session','From Session'),(1311,'promoted_class','Promoted Class'),(1312,'promoted_session','Promoted Session'),(1313,'promoted_date','Promoted Date'),(1314,'sibling_information','Sibling Information'),(1315,'disable_reason','Disable Reason'),(1316,'bill_no','Bill No'),(1317,'payable','Payable'),(1318,'ordered','Ordered'),(1319,'received','Received'),(1320,'add_products_to_stock_list','Add Products To Stock List'),(1321,'quantity','Quantity'),(1322,'net_total','Net Total'),(1323,'contact_number','Contact Number'),(1324,'company_name','Company Name'),(1325,'advance_salary_request','Advance Salary Request'),(1326,'student_parent_panel','Student Parent Panel'),(1327,'privacy','Privacy'),(1328,'default_template','Default Template'),(1329,'zoom_credentials','Zoom Credentials'),(1330,'set_zoom_redirect_url','Set Zoom Redirect Url'),(1331,'header_title','Header Title'),(1332,'frontend_enable_chat','Frontend Enable Chat'),(1333,'backend_enable_chat','Backend Enable Chat'),(1334,'whatsapp_agent','Whatsapp Agent'),(1335,'agent','Agent'),(1336,'whataspp_number','Whataspp Number'),(1337,'weekend','Weekend'),(1338,'day_wise','Day Wise'),(1339,'curriculum_pdf','Curriculum Pdf'),(1340,'edit_section','Edit Section'),(1341,'instructions','Instructions'),(1342,'suspended','Suspended'),(1343,'trx_id','Trx Id'),(1344,'submit_date','Submit Date'),(1345,'exam_rank','Exam Rank'),(1346,'principal_comments','Principal Comments'),(1347,'teacher_comments','Teacher Comments'),(1348,'enquiry','Enquiry'),(1349,'next','Next'),(1350,'follow_up','Follow Up'),(1351,'previous_school','Previous School'),(1352,'no_of_child','No Of Child'),(1353,'class_applying_for','Class Applying For'),(1354,'online_exam_publish','Online Exam Publish'),(1355,'student_birthday_wishes','Student Birthday Wishes'),(1356,'staff_birthday_wishes','Staff Birthday Wishes'),(1357,'alumni_event','Alumni Event'),(1360,'issue_to','Issue To'),(1361,'sale_to','Sale To'),(1362,'bill','Bill'),(1363,'summary','Summary'),(1364,'sub_total','Sub Total'),(1365,'enter_payment_amount','Enter Payment Amount'),(1366,'first_select_the_category','First Select The Category'),(1367,'may','May'),(1368,'supplier_name','Supplier Name'),(1369,'available_stock_quantity','Available Stock Quantity'),(1370,'mark_type','Mark Type'),(1371,'question_type','Question Type'),(1372,'recent','Recent'),(1373,'information','Information'),(1374,'dispatch_invites','Dispatch Invites'),(1375,'export','Export'),(1376,'september','September'),(1377,'apply_online_admission','Apply Online Admission'),(1378,'email_pdf_exam_marksheet','Email Pdf Exam Marksheet'),(1379,'email_pdf_fee_invoice','Email Pdf Fee Invoice'),(1380,'online_exam_published','Online Exam Published'),(1381,'call_type','Call Type'),(1382,'outgoing','Outgoing'),(1383,'incoming','Incoming'),(1384,'select_branch_first','Make A Selection First'),(1385,'total_dr','Total Dr'),(1386,'total_cr','Total Cr'),(1387,'fees_fine_reports','Fees Fine Reports'),(1388,'progress_reports','Progress Reports'),(1389,'tuition','Tuition'),(1390,'admission_slip','Admission Slip'),(1391,'complainant','Complainant'),(1392,'date_of_solution','Date Of Solution'),(1393,'assign_to','Assign To'),(1394,'action_taken','Action Taken'),(1395,'other_name','Other Name(s)'),(1396,'select_section_first','Select Section First'),(1397,'lga','Lga'),(1398,'unit_name','Unit Name');
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leave_application`
--

DROP TABLE IF EXISTS `leave_application`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leave_application` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leave_application`
--

LOCK TABLES `leave_application` WRITE;
/*!40000 ALTER TABLE `leave_application` DISABLE KEYS */;
/*!40000 ALTER TABLE `leave_application` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leave_category`
--

DROP TABLE IF EXISTS `leave_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leave_category` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `role_id` tinyint(1) NOT NULL,
  `days` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leave_category`
--

LOCK TABLES `leave_category` WRITE;
/*!40000 ALTER TABLE `leave_category` DISABLE KEYS */;
INSERT INTO `leave_category` VALUES (1,'Illness',3,10,1),(2,'Tour',7,5,1),(3,'Medical Leave',3,10,1),(4,'Casual Leave',3,10,1),(5,'Maternity Leave',3,60,1);
/*!40000 ALTER TABLE `leave_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `live_class`
--

DROP TABLE IF EXISTS `live_class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `live_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `live_class`
--

LOCK TABLES `live_class` WRITE;
/*!40000 ALTER TABLE `live_class` DISABLE KEYS */;
INSERT INTO `live_class` VALUES (1,3,'Live Classroom Test','','',0,60,'{\"join_url\":\"https:\\/\\/meet.google.com\\/abc-defg-xyz\"}',16,'[\"2\"]','','2026-03-30','09:15:00','10:15:00',1,0,'2026-03-27 08:03:16',1);
/*!40000 ALTER TABLE `live_class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `live_class_config`
--

DROP TABLE IF EXISTS `live_class_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `live_class_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zoom_api_key` varchar(255) DEFAULT NULL,
  `zoom_api_secret` varchar(255) DEFAULT NULL,
  `bbb_salt_key` varchar(355) DEFAULT NULL,
  `bbb_server_base_url` varchar(355) DEFAULT NULL,
  `staff_api_credential` tinyint(1) NOT NULL DEFAULT 0,
  `student_api_credential` tinyint(1) NOT NULL DEFAULT 0,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `live_class_config`
--

LOCK TABLES `live_class_config` WRITE;
/*!40000 ALTER TABLE `live_class_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `live_class_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `live_class_reports`
--

DROP TABLE IF EXISTS `live_class_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `live_class_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `live_class_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `live_class_reports`
--

LOCK TABLES `live_class_reports` WRITE;
/*!40000 ALTER TABLE `live_class_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `live_class_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_credential`
--

DROP TABLE IF EXISTS `login_credential`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_credential` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `role` tinyint(2) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1(active) 0(deactivate)',
  `must_change_password` tinyint(1) NOT NULL DEFAULT 0,
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_credential`
--

LOCK TABLES `login_credential` WRITE;
/*!40000 ALTER TABLE `login_credential` DISABLE KEYS */;
INSERT INTO `login_credential` VALUES (1,1,'admin@gmail.com','$2y$10$rXRti8CIAOP1YOY329FnKu5Vs3X04vpYUa476UTKHL5a8MaHhmlVq',1,1,0,'2026-09-14 16:00:57','2026-02-24 13:31:42',NULL),(2,2,'madina@gmail.com','$2y$10$sLzEo.o7L34GeHPVOLDsvO/K5lBeZFn1TGu7LEb0EAWm4RGgSOAHq',3,1,0,'2026-05-07 19:56:35','2026-03-27 07:08:29',NULL),(5,3,'jamilusalis@gmail.com','$2y$10$PoqFsNHVI9hobUJ9lOBpnOcah4kkFSytyeqk6RkBeH5HOUJ/YELi.',2,1,0,'2026-04-14 08:49:01','2026-04-14 07:47:56',NULL);
/*!40000 ALTER TABLE `login_credential` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_log`
--

DROP TABLE IF EXISTS `login_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `browser` varchar(255) NOT NULL,
  `platform` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `login_log_rms_1` (`branch_id`),
  CONSTRAINT `login_log_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_log`
--

LOCK TABLES `login_log` WRITE;
/*!40000 ALTER TABLE `login_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `login_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mark`
--

DROP TABLE IF EXISTS `mark`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mark` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `mark` text DEFAULT NULL,
  `absent` varchar(4) DEFAULT NULL,
  `session_id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mark`
--

LOCK TABLES `mark` WRITE;
/*!40000 ALTER TABLE `mark` DISABLE KEYS */;
/*!40000 ALTER TABLE `mark` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marksheet_template`
--

DROP TABLE IF EXISTS `marksheet_template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `marksheet_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `certificates_templete_rms_1` (`branch_id`),
  CONSTRAINT `marksheet_template_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marksheet_template`
--

LOCK TABLES `marksheet_template` WRITE;
/*!40000 ALTER TABLE `marksheet_template` DISABLE KEYS */;
/*!40000 ALTER TABLE `marksheet_template` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
/*!40000 ALTER TABLE `message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message_reply`
--

DROP TABLE IF EXISTS `message_reply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message_reply` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `message_id` int(11) NOT NULL,
  `body` text NOT NULL,
  `file_name` text NOT NULL,
  `enc_name` text NOT NULL,
  `identity` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message_reply`
--

LOCK TABLES `message_reply` WRITE;
/*!40000 ALTER TABLE `message_reply` DISABLE KEYS */;
/*!40000 ALTER TABLE `message_reply` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (710);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modules_manage`
--

DROP TABLE IF EXISTS `modules_manage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modules_manage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modules_id` int(11) NOT NULL,
  `isEnabled` tinyint(1) NOT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modules_manage`
--

LOCK TABLES `modules_manage` WRITE;
/*!40000 ALTER TABLE `modules_manage` DISABLE KEYS */;
INSERT INTO `modules_manage` VALUES (1,10,0,1),(2,11,0,1),(3,19,0,1),(4,22,0,1),(6,26,1,1),(7,27,0,1);
/*!40000 ALTER TABLE `modules_manage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `offline_fees_payments`
--

DROP TABLE IF EXISTS `offline_fees_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `offline_fees_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `student_fees_master_id` (`fees_allocation_id`),
  KEY `fee_groups_feetype_id` (`fees_type_id`),
  KEY `offline_fees_payments_ibfk_4` (`approved_by`),
  KEY `student_session_id` (`student_enroll_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `offline_fees_payments`
--

LOCK TABLES `offline_fees_payments` WRITE;
/*!40000 ALTER TABLE `offline_fees_payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `offline_fees_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `offline_payment_types`
--

DROP TABLE IF EXISTS `offline_payment_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `offline_payment_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `note` varchar(500) DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `offline_payment_types`
--

LOCK TABLES `offline_payment_types` WRITE;
/*!40000 ALTER TABLE `offline_payment_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `offline_payment_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `online_admission`
--

DROP TABLE IF EXISTS `online_admission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `online_admission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `online_admission_rms_1` (`branch_id`),
  CONSTRAINT `online_admission_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `online_admission`
--

LOCK TABLES `online_admission` WRITE;
/*!40000 ALTER TABLE `online_admission` DISABLE KEYS */;
/*!40000 ALTER TABLE `online_admission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `online_admission_fields`
--

DROP TABLE IF EXISTS `online_admission_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `online_admission_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fields_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `required` tinyint(4) NOT NULL DEFAULT 0,
  `system` tinyint(1) NOT NULL DEFAULT 1,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `online_admission_fields`
--

LOCK TABLES `online_admission_fields` WRITE;
/*!40000 ALTER TABLE `online_admission_fields` DISABLE KEYS */;
/*!40000 ALTER TABLE `online_admission_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `online_exam`
--

DROP TABLE IF EXISTS `online_exam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `online_exam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `session_id` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `online_exam`
--

LOCK TABLES `online_exam` WRITE;
/*!40000 ALTER TABLE `online_exam` DISABLE KEYS */;
/*!40000 ALTER TABLE `online_exam` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `online_exam_answer`
--

DROP TABLE IF EXISTS `online_exam_answer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `online_exam_answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `online_exam_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `online_exam_answer`
--

LOCK TABLES `online_exam_answer` WRITE;
/*!40000 ALTER TABLE `online_exam_answer` DISABLE KEYS */;
/*!40000 ALTER TABLE `online_exam_answer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `online_exam_attempts`
--

DROP TABLE IF EXISTS `online_exam_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `online_exam_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `online_exam_id` int(11) NOT NULL,
  `count` float NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `online_exam_attempts`
--

LOCK TABLES `online_exam_attempts` WRITE;
/*!40000 ALTER TABLE `online_exam_attempts` DISABLE KEYS */;
/*!40000 ALTER TABLE `online_exam_attempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `online_exam_payment`
--

DROP TABLE IF EXISTS `online_exam_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `online_exam_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `payment_method` tinyint(4) NOT NULL,
  `amount` float NOT NULL DEFAULT 0,
  `transaction_id` varchar(500) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `online_exam_payment`
--

LOCK TABLES `online_exam_payment` WRITE;
/*!40000 ALTER TABLE `online_exam_payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `online_exam_payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `online_exam_submitted`
--

DROP TABLE IF EXISTS `online_exam_submitted`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `online_exam_submitted` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `online_exam_id` int(11) NOT NULL,
  `remark` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `online_exam_submitted`
--

LOCK TABLES `online_exam_submitted` WRITE;
/*!40000 ALTER TABLE `online_exam_submitted` DISABLE KEYS */;
/*!40000 ALTER TABLE `online_exam_submitted` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parent`
--

DROP TABLE IF EXISTS `parent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `active` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0(active) 1(deactivate)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parent`
--

LOCK TABLES `parent` WRITE;
/*!40000 ALTER TABLE `parent` DISABLE KEYS */;
/*!40000 ALTER TABLE `parent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_config`
--

DROP TABLE IF EXISTS `payment_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_config`
--

LOCK TABLES `payment_config` WRITE;
/*!40000 ALTER TABLE `payment_config` DISABLE KEYS */;
INSERT INTO `payment_config` VALUES (2,NULL,NULL,NULL,NULL,NULL,0,NULL,'',NULL,0,NULL,NULL,NULL,0,'',0,'','',0,0,'','',0,0,'','','',0,0,'','',0,0,NULL,NULL,0,0,NULL,NULL,NULL,NULL,0,NULL,NULL,0,NULL,NULL,0,NULL,NULL,0,NULL,NULL,NULL,NULL,0,0,1,'2026-09-12 23:07:30',NULL);
/*!40000 ALTER TABLE `payment_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_salary_stipend`
--

DROP TABLE IF EXISTS `payment_salary_stipend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_salary_stipend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payslip_id` int(11) NOT NULL,
  `name` longtext NOT NULL,
  `amount` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_salary_stipend`
--

LOCK TABLES `payment_salary_stipend` WRITE;
/*!40000 ALTER TABLE `payment_salary_stipend` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_salary_stipend` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_types`
--

DROP TABLE IF EXISTS `payment_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `timestamp` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_types`
--

LOCK TABLES `payment_types` WRITE;
/*!40000 ALTER TABLE `payment_types` DISABLE KEYS */;
INSERT INTO `payment_types` VALUES (1,'Cash',1,'2026-02-12 18:12:21'),(2,'POS',1,'2026-02-12 18:12:31'),(3,'Cheque',1,'2026-02-12 10:07:59'),(4,'Bank Transfer',1,'2026-02-12 10:08:36'),(5,'Other',1,'2026-02-12 10:08:45'),(6,'Paypal',1,'2026-02-12 10:08:45'),(7,'Stripe',1,'2026-02-12 10:08:45'),(8,'PayUmoney',1,'2026-02-12 10:08:45'),(9,'Paystack',1,'2026-02-12 10:08:45'),(10,'Razorpay',1,'2026-02-12 10:08:45'),(11,'SSLcommerz',1,'2026-02-18 10:08:45'),(12,'Jazzcash',1,'2026-02-18 10:08:45'),(13,'Midtrans',1,'2026-02-18 10:08:45'),(14,'Flutter Wave',1,'2026-02-18 10:08:45'),(15,'Offline Payments',1,'2026-02-18 10:08:45'),(16,'Paytm',1,'2026-02-20 12:08:45'),(17,'toyyibPay',1,'2026-02-20 12:08:45'),(18,'Payhere',1,'2026-02-20 12:08:45'),(19,'Nepalste',1,'2026-02-20 12:08:45'),(20,'bKash',1,'2026-02-22 18:19:08');
/*!40000 ALTER TABLE `payment_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payslip`
--

DROP TABLE IF EXISTS `payslip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payslip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payslip`
--

LOCK TABLES `payslip` WRITE;
/*!40000 ALTER TABLE `payslip` DISABLE KEYS */;
/*!40000 ALTER TABLE `payslip` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payslip_details`
--

DROP TABLE IF EXISTS `payslip_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payslip_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payslip_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `type` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payslip_details`
--

LOCK TABLES `payslip_details` WRITE;
/*!40000 ALTER TABLE `payslip_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `payslip_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission`
--

DROP TABLE IF EXISTS `permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `prefix` varchar(100) NOT NULL,
  `show_view` tinyint(1) DEFAULT 1,
  `show_add` tinyint(1) DEFAULT 1,
  `show_edit` tinyint(1) DEFAULT 1,
  `show_delete` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=177 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission`
--

LOCK TABLES `permission` WRITE;
/*!40000 ALTER TABLE `permission` DISABLE KEYS */;
INSERT INTO `permission` VALUES (1,2,'Student','student',1,1,1,1,'2026-02-14 11:45:47'),(2,2,'Multiple Import','multiple_import',0,1,0,0,'2026-02-14 11:45:47'),(3,2,'Student Category','student_category',1,1,1,1,'2026-02-14 11:45:47'),(4,2,'Student Id Card','student_id_card',1,0,0,0,'2026-02-14 11:45:47'),(5,2,'Disable Authentication','student_disable_authentication',1,1,0,0,'2026-02-14 11:45:47'),(6,4,'Employee','employee',1,1,1,1,'2026-02-14 11:55:19'),(7,3,'Parent','parent',1,1,1,1,'2026-02-14 13:24:05'),(8,3,'Disable Authentication','parent_disable_authentication',1,1,0,0,'2026-02-14 14:22:21'),(9,4,'Department','department',1,1,1,1,'2026-02-14 17:41:39'),(10,4,'Designation','designation',1,1,1,1,'2026-02-14 17:41:39'),(11,4,'Disable Authentication','employee_disable_authentication',1,1,0,0,'2026-02-14 17:41:39'),(12,5,'Salary Template','salary_template',1,1,1,1,'2026-02-14 05:13:57'),(13,5,'Salary Assign','salary_assign',1,1,0,0,'2026-02-14 05:14:05'),(14,5,'Salary Payment','salary_payment',1,1,0,0,'2026-02-14 06:45:40'),(15,5,'Salary Summary Report','salary_summary_report',1,0,0,0,'2026-02-14 17:09:17'),(16,5,'Advance Salary','advance_salary',1,1,1,1,'2026-02-14 18:23:39'),(17,5,'Advance Salary Manage','advance_salary_manage',1,1,1,1,'2026-02-14 04:57:12'),(18,5,'Advance Salary Request','advance_salary_request',1,1,0,1,'2026-02-14 17:49:58'),(19,5,'Leave Category','leave_category',1,1,1,1,'2026-02-14 02:46:23'),(20,5,'Leave Request','leave_request',1,1,1,1,'2026-02-14 12:06:33'),(21,5,'Leave Manage','leave_manage',1,1,1,1,'2026-02-14 07:27:15'),(22,5,'Award','award',1,1,1,1,'2026-02-14 18:49:11'),(23,6,'Classes','classes',1,1,1,1,'2026-02-14 18:10:00'),(24,6,'Section','section',1,1,1,1,'2026-02-14 21:06:44'),(25,6,'Assign Class Teacher','assign_class_teacher',1,1,1,1,'2026-02-14 07:09:22'),(26,6,'Subject','subject',1,1,1,1,'2026-02-14 04:32:39'),(27,6,'Subject Class Assign ','subject_class_assign',1,1,1,1,'2026-02-14 17:43:19'),(28,6,'Subject Teacher Assign','subject_teacher_assign',1,1,0,1,'2026-02-14 19:05:11'),(29,6,'Class Timetable','class_timetable',1,1,1,1,'2026-02-14 05:50:37'),(30,2,'Student Promotion','student_promotion',1,1,0,0,'2026-02-14 18:20:30'),(31,8,'Attachments','attachments',1,1,1,1,'2026-02-14 17:59:43'),(32,7,'Homework','homework',1,1,1,1,'2026-02-14 05:40:08'),(33,8,'Attachment Type','attachment_type',1,1,1,1,'2026-02-14 07:16:28'),(34,9,'Exam','exam',1,1,1,1,'2026-02-14 09:59:29'),(35,9,'Exam Term','exam_term',1,1,1,1,'2026-02-14 12:09:28'),(36,9,'Exam Hall','exam_hall',1,1,1,1,'2026-02-14 14:31:04'),(37,9,'Exam Timetable','exam_timetable',1,1,0,1,'2026-02-14 17:04:31'),(38,9,'Exam Mark','exam_mark',1,1,1,1,'2026-02-14 12:53:41'),(39,9,'Exam Grade','exam_grade',1,1,1,1,'2026-02-14 17:29:16'),(40,10,'Hostel','hostel',1,1,1,1,'2026-02-14 04:41:36'),(41,10,'Hostel Category','hostel_category',1,1,1,1,'2026-02-14 07:52:31'),(42,10,'Hostel Room','hostel_room',1,1,1,1,'2026-02-14 11:50:09'),(43,10,'Hostel Allocation','hostel_allocation',1,0,0,1,'2026-02-14 13:06:15'),(44,11,'Transport Route','transport_route',1,1,1,1,'2026-02-14 05:26:19'),(45,11,'Transport Vehicle','transport_vehicle',1,1,1,1,'2026-02-14 05:57:30'),(46,11,'Transport Stoppage','transport_stoppage',1,1,1,1,'2026-02-14 06:49:20'),(47,11,'Transport Assign','transport_assign',1,1,1,1,'2026-02-14 09:55:21'),(48,11,'Transport Allocation','transport_allocation',1,0,0,1,'2026-02-14 19:33:05'),(49,12,'Student Attendance','student_attendance',0,1,0,0,'2026-02-14 05:25:53'),(50,12,'Employee Attendance','employee_attendance',0,1,0,0,'2026-02-14 10:04:16'),(51,12,'Exam Attendance','exam_attendance',0,1,0,0,'2026-02-14 11:08:14'),(52,12,'Student Attendance Report','student_attendance_report',1,0,0,0,'2026-02-14 19:20:56'),(53,12,'Employee Attendance Report','employee_attendance_report',1,0,0,0,'2026-02-14 06:08:53'),(54,12,'Exam Attendance Report','exam_attendance_report',1,0,0,0,'2026-02-14 06:21:40'),(55,13,'Book','book',1,1,1,1,'2026-02-14 06:40:42'),(56,13,'Book Category','book_category',1,1,1,1,'2026-02-14 04:11:41'),(57,13,'Book Manage','book_manage',1,1,0,1,'2026-02-14 11:13:24'),(58,13,'Book Request','book_request',1,1,0,1,'2026-02-14 06:45:19'),(59,14,'Event','event',1,1,1,1,'2026-02-14 18:02:15'),(60,14,'Event Type','event_type',1,1,1,1,'2026-02-14 04:40:33'),(61,15,'Sendsmsmail','sendsmsmail',1,1,0,1,'2026-02-14 07:19:57'),(62,15,'Sendsmsmail Template','sendsmsmail_template',1,1,1,1,'2026-02-14 10:14:57'),(63,17,'Account','account',1,1,1,1,'2026-02-14 09:34:43'),(64,17,'Deposit','deposit',1,1,1,1,'2026-02-14 12:56:11'),(65,17,'Expense','expense',1,1,1,1,'2026-02-14 06:35:57'),(66,17,'All Transactions','all_transactions',1,0,0,0,'2026-02-14 13:35:05'),(67,17,'Voucher Head','voucher_head',1,1,1,1,'2026-02-14 10:50:56'),(68,17,'Accounting Reports','accounting_reports',1,1,1,1,'2026-02-14 13:36:24'),(69,16,'Fees Type','fees_type',1,1,1,1,'2026-02-14 10:11:03'),(70,16,'Fees Group','fees_group',1,1,1,1,'2026-02-14 05:49:09'),(71,16,'Fees Fine Setup','fees_fine_setup',1,1,1,1,'2026-02-14 02:59:27'),(72,16,'Fees Allocation','fees_allocation',1,1,1,1,'2026-02-14 13:47:43'),(73,16,'Collect Fees','collect_fees',0,1,0,0,'2026-02-14 04:23:58'),(74,16,'Fees Reminder','fees_reminder',1,1,1,1,'2026-02-14 04:29:58'),(75,16,'Due Invoice','due_invoice',1,0,0,0,'2026-02-14 04:33:36'),(76,16,'Invoice','invoice',1,0,0,1,'2026-02-14 04:38:06'),(77,9,'Mark Distribution','mark_distribution',1,1,1,1,'2026-02-14 13:02:54'),(78,9,'Report Card','report_card',1,0,0,0,'2026-02-14 12:20:28'),(79,9,'Tabulation Sheet','tabulation_sheet',1,0,0,0,'2026-02-14 07:12:38'),(80,15,'Sendsmsmail Reports','sendsmsmail_reports',1,0,0,0,'2026-02-14 17:02:02'),(81,18,'Global Settings','global_settings',1,0,1,0,'2026-02-14 05:05:41'),(82,18,'Payment Settings','payment_settings',1,1,0,0,'2026-02-14 05:08:57'),(83,18,'Sms Settings','sms_settings',1,1,1,1,'2026-02-14 05:08:57'),(84,18,'Email Settings','email_settings',1,1,1,1,'2026-02-14 05:10:39'),(85,18,'Translations','translations',1,1,1,1,'2026-02-14 05:18:33'),(86,18,'Backup','backup',1,1,1,1,'2026-02-14 07:09:33'),(87,18,'Backup Restore','backup_restore',0,1,0,0,'2026-02-14 07:09:34'),(88,7,'Homework Evaluate','homework_evaluate',1,1,0,0,'2026-02-14 04:20:29'),(89,7,'Evaluation Report','evaluation_report',1,0,0,0,'2026-02-14 09:56:04'),(90,18,'School Settings','school_settings',1,0,1,0,'2026-02-14 17:36:37'),(91,1,'Monthly Income Vs Expense Pie Chart','monthly_income_vs_expense_chart',1,0,0,0,'2026-02-14 06:15:31'),(92,1,'Annual Student Fees Summary Chart','annual_student_fees_summary_chart',1,0,0,0,'2026-02-14 06:15:31'),(93,1,'Employee Count Widget','employee_count_widget',1,0,0,0,'2026-02-14 06:31:56'),(94,1,'Student Count Widget','student_count_widget',1,0,0,0,'2026-02-14 06:31:56'),(95,1,'Parent Count Widget','parent_count_widget',1,0,0,0,'2026-02-14 06:31:56'),(96,1,'Teacher Count Widget','teacher_count_widget',1,0,0,0,'2026-02-14 06:31:56'),(97,1,'Student Quantity Pie Chart','student_quantity_pie_chart',1,0,0,0,'2026-02-14 07:14:07'),(98,1,'Weekend Attendance Inspection Chart','weekend_attendance_inspection_chart',1,0,0,0,'2026-02-14 07:14:07'),(99,1,'Admission Count Widget','admission_count_widget',1,0,0,0,'2026-02-14 07:22:05'),(100,1,'Voucher Count Widget','voucher_count_widget',1,0,0,0,'2026-02-14 07:22:05'),(101,1,'Transport Count Widget','transport_count_widget',1,0,0,0,'2026-02-14 07:22:05'),(102,1,'Hostel Count Widget','hostel_count_widget',1,0,0,0,'2026-02-14 07:22:05'),(103,18,'Accounting Links','accounting_links',1,0,1,0,'2026-02-14 09:46:30'),(104,16,'Fees Reports','fees_reports',1,0,0,0,'2026-02-14 15:52:19'),(105,18,'Cron Job','cron_job',1,0,1,0,'2026-02-14 09:46:30'),(106,18,'Custom Field','custom_field',1,1,1,1,'2026-02-14 09:46:30'),(107,5,'Leave Reports','leave_reports',1,0,0,0,'2026-02-14 09:46:30'),(108,18,'Live Class Config','live_class_config',1,0,1,0,'2026-02-14 09:46:30'),(109,19,'Live Class','live_class',1,1,1,1,'2026-02-14 09:46:30'),(110,20,'Certificate Templete','certificate_templete',1,1,1,1,'2026-02-14 09:46:30'),(111,20,'Generate Student Certificate','generate_student_certificate',1,0,0,0,'2026-02-14 09:46:30'),(112,20,'Generate Employee Certificate','generate_employee_certificate',1,0,0,0,'2026-02-14 09:46:30'),(113,21,'ID Card Templete','id_card_templete',1,1,1,1,'2026-02-14 09:46:30'),(114,21,'Generate Student ID Card','generate_student_idcard',1,0,0,0,'2026-02-14 09:46:30'),(115,21,'Generate Employee ID Card','generate_employee_idcard',1,0,0,0,'2026-02-14 09:46:30'),(116,21,'Admit Card Templete','admit_card_templete',1,1,1,1,'2026-02-14 09:46:30'),(117,21,'Generate Admit card','generate_admit_card',1,0,0,0,'2026-02-14 09:46:30'),(118,22,'Frontend Setting','frontend_setting',1,1,0,0,'2026-02-12 03:24:07'),(119,22,'Frontend Menu','frontend_menu',1,1,1,1,'2026-02-12 04:03:39'),(120,22,'Frontend Section','frontend_section',1,1,0,0,'2026-02-12 04:26:11'),(121,22,'Manage Page','manage_page',1,1,1,1,'2026-02-12 05:54:08'),(122,22,'Frontend Slider','frontend_slider',1,1,1,1,'2026-02-12 06:12:31'),(123,22,'Frontend Features','frontend_features',1,1,1,1,'2026-02-12 06:47:51'),(124,22,'Frontend Testimonial','frontend_testimonial',1,1,1,1,'2026-02-12 06:54:30'),(125,22,'Frontend Services','frontend_services',1,1,1,1,'2026-02-12 07:01:44'),(126,22,'Frontend Faq','frontend_faq',1,1,1,1,'2026-02-12 07:06:16'),(127,2,'Online Admission','online_admission',1,1,0,1,'2026-02-12 07:06:16'),(128,18,'System Update','system_update',0,1,0,0,'2026-02-12 07:06:16'),(129,19,'Live Class Reports','live_class_reports',1,0,0,0,'2026-02-14 09:46:30'),(130,16,'Fees Revert','fees_revert',0,0,0,1,'2026-02-14 09:46:30'),(131,22,'Frontend Gallery','frontend_gallery',1,1,1,1,'2026-02-12 07:06:16'),(132,22,'Frontend Gallery Category','frontend_gallery_category',1,1,1,1,'2026-02-12 07:06:16'),(133,6,'Teacher Timetable','teacher_timetable',1,0,0,0,'2026-02-16 09:46:30'),(134,18,'Whatsapp Config','whatsapp_config',1,1,1,1,'2026-02-16 09:46:30'),(135,18,'System Student Field','system_student_field',1,0,1,0,'2026-02-16 09:46:30'),(136,23,'Online Exam','online_exam',1,1,1,1,'2026-02-16 09:46:30'),(137,23,'Question Bank','question_bank',1,1,1,1,'2026-02-16 09:46:30'),(138,23,'Add Questions','add_questions',0,1,0,0,'2026-02-16 09:46:30'),(139,23,'Question Group','question_group',1,1,1,1,'2026-02-16 09:46:30'),(140,23,'Exam Result','exam_result',1,0,0,0,'2026-02-16 09:46:30'),(141,23,'Position Generate','position_generate',1,1,0,0,'2026-02-16 09:46:30'),(142,24,'Postal Record','postal_record',1,1,1,1,'2026-02-16 09:46:30'),(143,24,'Call Log','call_log',1,1,1,1,'2026-02-16 09:46:30'),(144,24,'Visitor Log','visitor_log',1,1,1,1,'2026-02-16 09:46:30'),(145,24,'Complaint','complaint',1,1,1,1,'2026-02-16 09:46:30'),(146,24,'Enquiry','enquiry',1,1,1,1,'2026-02-16 09:46:30'),(147,24,'Follow Up','follow_up',1,1,0,1,'2026-02-16 09:46:30'),(148,24,'Config Reception','config_reception',1,1,1,1,'2026-02-16 09:46:30'),(149,15,'Student Birthday Wishes','student_birthday_wishes',1,0,0,0,'2026-02-16 09:46:30'),(150,15,'Staff Birthday Wishes','staff_birthday_wishes',1,0,0,0,'2026-02-16 09:46:30'),(151,1,'Student Birthday Wishes Widget','student_birthday_widget',1,0,0,0,'2026-02-16 07:22:05'),(152,1,'Staff Birthday Wishes Widget','staff_birthday_widget',1,0,0,0,'2026-02-16 07:22:05'),(153,9,'Progress Reports','progress_reports',1,0,0,0,'2026-02-16 07:12:38'),(154,2,'Disable Reason','disable_reason',1,1,1,1,'2026-02-16 07:12:38'),(155,16,'Offline Payments','offline_payments',1,0,0,0,'2026-02-20 07:12:38'),(156,16,'Offline Payments Type','offline_payments_type',1,1,1,1,'2026-02-20 07:12:38'),(157,25,'Product','product',1,1,1,1,'2026-02-20 19:21:42'),(158,25,'Product Category','product_category',1,1,1,1,'2026-02-20 19:21:42'),(159,25,'Product Supplier','product_supplier',1,1,1,1,'2026-02-20 19:21:42'),(160,25,'Product Unit','product_unit',1,1,1,1,'2026-02-20 19:21:42'),(161,25,'Product Purchase','product_purchase',1,1,1,1,'2026-02-20 19:21:42'),(162,25,'Purchase Payment','purchase_payment',1,1,0,0,'2026-02-20 19:21:42'),(163,25,'Product Store','product_store',1,1,1,1,'2026-02-20 19:21:42'),(164,25,'Product Sales','product_sales',1,1,0,1,'2026-02-20 19:21:42'),(165,25,'Sales Payment','sales_payment',1,0,0,0,'2026-02-20 07:05:10'),(166,25,'Product Issue','product_issue',1,1,0,1,'2026-02-20 19:21:42'),(167,25,'Inventory Report','inventory_report',1,0,0,0,'2026-02-20 03:56:45'),(168,9,'Generate Position','generate_position',1,0,0,0,'2026-02-20 15:08:29'),(169,18,'User Login Log','user_login_log',1,0,0,1,'2026-02-21 09:01:26'),(170,26,'Manage Alumni','manage_alumni',1,1,1,1,'2026-02-21 09:01:26'),(171,26,'Alumni Events','alumni_events',1,1,1,1,'2026-02-21 09:01:26'),(172,27,'Multi Class Student','multi_class',1,1,0,0,'2026-02-21 08:28:04'),(173,22,'Frontend News','frontend_news',1,1,1,1,'2026-02-21 08:45:48'),(174,9,'Marksheet Template','marksheet_template',1,1,1,1,'2026-02-21 05:59:53'),(175,11,'Fees setup','transport_fees_setup',1,1,1,1,'2026-02-22 17:41:23'),(176,2,'Infrastructure Register','infrastructure',1,1,1,1,'2026-02-14 11:45:47');
/*!40000 ALTER TABLE `permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_modules`
--

DROP TABLE IF EXISTS `permission_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `prefix` varchar(50) NOT NULL,
  `system` tinyint(1) NOT NULL,
  `sorted` tinyint(10) NOT NULL,
  `in_module` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_modules`
--

LOCK TABLES `permission_modules` WRITE;
/*!40000 ALTER TABLE `permission_modules` DISABLE KEYS */;
INSERT INTO `permission_modules` VALUES (1,'Dashboard','dashboard',1,1,0,'2026-02-12 22:23:00'),(2,'Student','student',1,4,0,'2026-02-12 22:23:00'),(3,'Parents','parents',1,5,0,'2026-02-12 22:23:00'),(4,'Employee','employee',1,6,0,'2026-02-12 22:23:00'),(5,'Human Resource','human_resource',1,9,1,'2026-02-12 22:23:00'),(6,'Academic','academic',1,10,0,'2026-02-12 22:23:00'),(7,'Homework','homework',1,13,1,'2026-02-12 22:23:00'),(8,'Attachments Book','attachments_book',1,12,1,'2026-02-12 22:23:00'),(9,'Exam Master','exam_master',1,14,0,'2026-02-12 22:23:00'),(10,'Hostel','hostel',1,16,1,'2026-02-12 22:23:00'),(11,'Transport','transport',1,17,1,'2026-02-12 22:23:00'),(12,'Attendance','attendance',1,18,1,'2026-02-12 22:23:00'),(13,'Library','library',1,19,1,'2026-02-12 22:23:00'),(14,'Events','events',1,20,1,'2026-02-12 22:23:00'),(15,'Bulk Sms And Email','bulk_sms_and_email',1,21,1,'2026-02-12 22:23:00'),(16,'Student Accounting','student_accounting',1,22,1,'2026-02-12 22:23:00'),(17,'Office Accounting','office_accounting',1,23,1,'2026-02-12 22:23:00'),(18,'Settings','settings',1,24,0,'2026-02-12 22:23:00'),(19,'Live Class','live_class',1,11,1,'2026-02-12 22:23:00'),(20,'Certificate','certificate',1,8,1,'2026-02-12 22:23:00'),(21,'Card Management','card_management',1,7,1,'2026-02-12 22:23:00'),(22,'Website','website',1,2,1,'2026-02-12 22:23:00'),(23,'Online Exam','online_exam',1,15,1,'2026-02-12 22:23:00'),(24,'Reception','reception',1,3,1,'2026-02-12 22:23:00'),(25,'Inventory','inventory',1,3,1,'2026-02-20 19:16:49'),(26,'Alumni','alumni',1,24,1,'2026-02-21 19:16:49'),(27,'Multi Class','multi_class',1,25,1,'2026-02-21 08:32:01'),(28,'Teacher Transfer','teacher_transfer',0,28,1,'2026-04-15 10:43:31'),(29,'School Inspection','school_inspection',0,29,1,'2026-04-15 10:43:31'),(30,'Infrastructure Register','infrastructure',1,1,1,'2026-02-12 22:23:00');
/*!40000 ALTER TABLE `permission_modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `postal_record`
--

DROP TABLE IF EXISTS `postal_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `postal_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `postal_record`
--

LOCK TABLES `postal_record` WRITE;
/*!40000 ALTER TABLE `postal_record` DISABLE KEYS */;
/*!40000 ALTER TABLE `postal_record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `product_rms_1` (`branch_id`),
  CONSTRAINT `product_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,'Female\'s Uniform','TP2026',4,3,4,'1000',15000000.00,0.00,'0',NULL,'',1,'2026-05-07 00:44:55','2026-09-14 10:39:24');
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_category`
--

DROP TABLE IF EXISTS `product_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_category_rms_1` (`branch_id`),
  CONSTRAINT `product_category_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=189 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_category`
--

LOCK TABLES `product_category` WRITE;
/*!40000 ALTER TABLE `product_category` DISABLE KEYS */;
INSERT INTO `product_category` VALUES (1,'Sports',1,'2026-03-26 15:26:45',NULL),(2,'Accessories',1,'2026-03-26 15:26:53',NULL),(3,'Study material',1,'2026-03-26 15:27:02',NULL),(4,'Dress',1,'2026-03-26 15:27:11',NULL),(5,'Books Stationery',1,'2026-03-26 15:27:17',NULL),(6,'Furniture and Equipment',1,'2026-03-26 15:27:24',NULL),(7,'Computer',1,'2026-03-26 15:27:33',NULL),(56,'Textbooks',1,'2026-04-16 08:10:45',NULL),(66,'Exercise Books',1,'2026-04-16 08:10:45',NULL),(76,'Uniforms',1,'2026-04-16 08:10:45',NULL),(86,'School Feeding Supplies',1,'2026-04-16 08:10:45',NULL),(96,'Stationery',1,'2026-04-16 08:10:45',NULL),(106,'Classrooms',1,'2026-04-16 08:10:45',NULL),(116,'Science Labs',1,'2026-04-16 08:10:45',NULL),(126,'Toilets and Sanitation',1,'2026-04-16 08:10:45',NULL),(136,'Library',1,'2026-04-16 08:10:45',NULL),(146,'ICT Computers',1,'2026-04-16 08:10:45',NULL),(156,'Furniture and Fittings',1,'2026-04-16 08:10:45',NULL),(166,'Water Supply',1,'2026-04-16 08:10:45',NULL);
/*!40000 ALTER TABLE `product_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_issues`
--

DROP TABLE IF EXISTS `product_issues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_issues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `product_issues_rms_1` (`branch_id`),
  CONSTRAINT `product_issues_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_issues`
--

LOCK TABLES `product_issues` WRITE;
/*!40000 ALTER TABLE `product_issues` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_issues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_issues_details`
--

DROP TABLE IF EXISTS `product_issues_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_issues_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `issues_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_issues_details_rms_1` (`product_id`),
  CONSTRAINT `product_issues_details_rms_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_issues_details`
--

LOCK TABLES `product_issues_details` WRITE;
/*!40000 ALTER TABLE `product_issues_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_issues_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_store`
--

DROP TABLE IF EXISTS `product_store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `mobileno` varchar(255) DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_store`
--

LOCK TABLES `product_store` WRITE;
/*!40000 ALTER TABLE `product_store` DISABLE KEYS */;
INSERT INTO `product_store` VALUES (1,'State Learning Materials Store','SLMS-STATE','09011223344','','',1,'2026-04-16 08:09:03'),(2,'State Infrastructure Register','SIR-STATE',NULL,NULL,NULL,1,'2026-04-16 08:09:03');
/*!40000 ALTER TABLE `product_store` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_supplier`
--

DROP TABLE IF EXISTS `product_supplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `address` text NOT NULL,
  `mobileno` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `company_name` varchar(200) NOT NULL,
  `product_list` mediumtext NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_supplier_rms_1` (`branch_id`),
  CONSTRAINT `product_supplier_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_supplier`
--

LOCK TABLES `product_supplier` WRITE;
/*!40000 ALTER TABLE `product_supplier` DISABLE KEYS */;
INSERT INTO `product_supplier` VALUES (1,'ABC Company','','09022334455','','','',1,'2026-05-07 00:33:17',NULL);
/*!40000 ALTER TABLE `product_supplier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_unit`
--

DROP TABLE IF EXISTS `product_unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_unit`
--

LOCK TABLES `product_unit` WRITE;
/*!40000 ALTER TABLE `product_unit` DISABLE KEYS */;
INSERT INTO `product_unit` VALUES (1,'KG',1,'2026-03-26 15:28:30',NULL),(2,'Piece',1,'2026-03-26 15:28:38',NULL),(3,'Dozen',1,'2026-03-26 15:28:45',NULL),(4,'Unit',1,'2026-03-26 15:28:50',NULL);
/*!40000 ALTER TABLE `product_unit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promotion_history`
--

DROP TABLE IF EXISTS `promotion_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `promotion_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `pre_class` int(11) NOT NULL,
  `pre_section` int(11) NOT NULL,
  `pre_session` int(11) NOT NULL,
  `pro_class` int(11) NOT NULL,
  `pro_section` int(11) NOT NULL,
  `pro_session` int(11) NOT NULL,
  `prev_due` float NOT NULL DEFAULT 0,
  `is_leave` tinyint(4) NOT NULL DEFAULT 0,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `promotion_history_rms_1` (`student_id`),
  CONSTRAINT `promotion_history_rms_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promotion_history`
--

LOCK TABLES `promotion_history` WRITE;
/*!40000 ALTER TABLE `promotion_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `promotion_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_bill`
--

DROP TABLE IF EXISTS `purchase_bill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchase_bill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_bill_rms_1` (`branch_id`),
  CONSTRAINT `purchase_bill_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_bill`
--

LOCK TABLES `purchase_bill` WRITE;
/*!40000 ALTER TABLE `purchase_bill` DISABLE KEYS */;
/*!40000 ALTER TABLE `purchase_bill` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_bill_details`
--

DROP TABLE IF EXISTS `purchase_bill_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchase_bill_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_bill_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `unit_price` decimal(18,2) NOT NULL DEFAULT 0.00,
  `quantity` varchar(20) NOT NULL,
  `discount` decimal(18,2) NOT NULL DEFAULT 0.00,
  `sub_total` decimal(18,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`),
  KEY `purchase_bill_details_rms_1` (`product_id`),
  CONSTRAINT `purchase_bill_details_rms_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_bill_details`
--

LOCK TABLES `purchase_bill_details` WRITE;
/*!40000 ALTER TABLE `purchase_bill_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `purchase_bill_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_payment_history`
--

DROP TABLE IF EXISTS `purchase_payment_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchase_payment_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_bill_id` varchar(11) NOT NULL,
  `payment_by` int(11) DEFAULT NULL,
  `amount` decimal(18,2) NOT NULL DEFAULT 0.00,
  `pay_via` varchar(25) NOT NULL,
  `remarks` text NOT NULL,
  `attach_orig_name` varchar(255) DEFAULT NULL,
  `attach_file_name` varchar(255) DEFAULT NULL,
  `paid_on` date DEFAULT NULL,
  `coll_type` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_payment_history`
--

LOCK TABLES `purchase_payment_history` WRITE;
/*!40000 ALTER TABLE `purchase_payment_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `purchase_payment_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_group`
--

DROP TABLE IF EXISTS `question_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_group`
--

LOCK TABLES `question_group` WRITE;
/*!40000 ALTER TABLE `question_group` DISABLE KEYS */;
INSERT INTO `question_group` VALUES (1,'General',1),(2,'Maths',1),(3,'English',1);
/*!40000 ALTER TABLE `question_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions_manage`
--

DROP TABLE IF EXISTS `questions_manage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions_manage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) DEFAULT NULL,
  `onlineexam_id` int(11) DEFAULT NULL,
  `marks` float(10,2) NOT NULL DEFAULT 0.00,
  `neg_marks` float(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `onlineexam_id` (`onlineexam_id`),
  KEY `question_id` (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions_manage`
--

LOCK TABLES `questions_manage` WRITE;
/*!40000 ALTER TABLE `questions_manage` DISABLE KEYS */;
/*!40000 ALTER TABLE `questions_manage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reset_password`
--

DROP TABLE IF EXISTS `reset_password`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reset_password` (
  `key` longtext NOT NULL,
  `username` varchar(100) NOT NULL,
  `login_credential_id` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reset_password`
--

LOCK TABLES `reset_password` WRITE;
/*!40000 ALTER TABLE `reset_password` DISABLE KEYS */;
INSERT INTO `reset_password` VALUES ('7c612cdaad3a79d52f1931e28f5e71d5acdd0c3b06762fa752e164f4e73e87964e107f9d686f4c849e52321f57a9ab6fe9a50c75f38e02ab04c8e0cc2766a23f','admin.malali@kdsg.gov.ng','6','2026-04-14 10:55:59'),('ca09fdd26e715809d3367c7cbef5935bb6f83e54ce7a4d0cbb03c4cb8fa6373606c721332a9cdf69851747dd5cdcfd008f561c8d14e5e63632a47e278856202d','admin@gmail.com','1','2026-05-07 11:17:15');
/*!40000 ALTER TABLE `reset_password` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rm_sessions`
--

DROP TABLE IF EXISTS `rm_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rm_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT 0,
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rm_sessions`
--

LOCK TABLES `rm_sessions` WRITE;
/*!40000 ALTER TABLE `rm_sessions` DISABLE KEYS */;
INSERT INTO `rm_sessions` VALUES ('01cpmeae78h8269qi7ouce3neesgtsou','::1',1778168800,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383136383830303B72656469726563745F75726C7C733A33363A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F70726F66696C65223B),('01sdnh2ta9blalno38qs09s0or67cqlo','::1',1789403502,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393430333530323B),('04ds7a5fbm6prmglbfb07p16eevjvr3l','::1',1789257486,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393235373432383B72656469726563745F75726C7C733A33363A22687474703A2F2F6C6F63616C686F73742F74616873696E2F73747564656E742F76696577223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('04s37aqg2dgubio40mv0f5mhc2dru8j5','::1',1789402754,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393430323735343B72656469726563745F75726C7C733A33353A22687474703A2F2F6C6F63616C686F73742F74616873696E2F73747564656E742F616464223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B666F7263655F70617373776F72645F6368616E67657C693A303B),('0bm3t21ovb2f61cfk8m4pjnaa0i3sukf','::1',1778177137,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383137373133373B72656469726563745F75726C7C733A34323A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F656D706C6F7965652F76696577223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('0id9u7p19cjrh5u09ad2s6m2bi7qe5db','::1',1789378799,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383739393B),('10vsf82bu6n9lt60hge9cmju727a4t26','::1',1778175913,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383137353931333B72656469726563745F75726C7C733A34323A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F656D706C6F7965652F76696577223B616C6572742D6D6573736167652D6572726F727C733A33333A22557365726E616D65204F722050617373776F726420497320496E636F7272656374223B5F5F63695F766172737C613A313A7B733A31393A22616C6572742D6D6573736167652D6572726F72223B733A333A226F6C64223B7D),('11can87qpo6ac7pdrhle8a7af16oiujn','::1',1789398091,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393339383039313B72656469726563745F75726C7C733A33333A22687474703A2F2F6C6F63616C686F73742F74616873696E2F64617368626F617264223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B666F7263655F70617373776F72645F6368616E67657C693A303B),('13r2blhg8nsqgdpg84pk2sj7arlr24nn','::1',1789404489,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393430343437393B),('1e4de7c895tmlr8ukep24vrm18fi53cm','::1',1789378849,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383834393B),('1i3ge68ca3i5intffktu7v3oi2bocick','::1',1789378849,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383834393B),('1ivth19hq7on62g9idnhpojnc554korc','::1',1778160717,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383136303731373B72656469726563745F75726C7C733A33383A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F64617368626F617264223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('1stl1a02n0a770k4e2508kp6pnn5lk0j','::1',1789399432,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393339393433323B72656469726563745F75726C7C733A33333A22687474703A2F2F6C6F63616C686F73742F74616873696E2F64617368626F617264223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B666F7263655F70617373776F72645F6368616E67657C693A303B),('22ggtlisuj2e8i16mkejchehrk6gocav','::1',1789379539,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337393533393B),('251qo93lt8a02r8iv3db2faceemcn3rt','::1',1778222284,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383232323238343B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('292d6dg4d2qufboqdomd0dl87opl083b','::1',1789254732,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393235343733323B72656469726563745F75726C7C733A33363A22687474703A2F2F6C6F63616C686F73742F74616873696E2F73747564656E742F76696577223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('2b7fvoi6tc14mllop5n83gi8rsjtdq55','::1',1789379539,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337393533393B),('2bk3a8u12g80l5madpuj3fa5onhrqfa6','::1',1778163277,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383136333237373B),('2e82r0fm36u0stofc0ulo1hs1d4evb4u','::1',1789210962,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393231303936323B),('2pngm3h10iu3o7bfrtktrb7l56df3ct8','::1',1789378848,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383834383B),('2t5olik3e5g9crld2tqroutv2og3fo8r','::1',1789210945,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393231303934353B),('3789mt9srra8mfva6degobr9tbq65t59','::1',1789257428,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393235373432383B72656469726563745F75726C7C733A33363A22687474703A2F2F6C6F63616C686F73742F74616873696E2F73747564656E742F76696577223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('3novkkbkv8ep264gtj69u6s73bq276ci','::1',1778236050,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383233353835313B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('48f6jl5fubltvimtagekirqa7ecl8a81','::1',1789399738,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393339393733383B72656469726563745F75726C7C733A33333A22687474703A2F2F6C6F63616C686F73742F74616873696E2F64617368626F617264223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B666F7263655F70617373776F72645F6368616E67657C693A303B),('4ed2c0pno1thiqh1ra7pbd9mln0208k6','::1',1789378799,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383739393B),('4mrp32f1ej6clpbhmbughm667h02nfi0','::1',1778227729,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383232373732393B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('50cgmv8ts4k60if4b1f82ucvq6f71div','::1',1778163985,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383136333938353B),('50lfb5v01841pggrdvc5e4p5uh9m353k','::1',1789210962,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393231303936323B),('51ebq2gipsc5tiobckcan9i2ld58nnnk','::1',1789378918,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383837323B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('56kl1jomgb9kumqm4kr2fteae0d6vlfq','::1',1778178826,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383137383832363B72656469726563745F75726C7C733A33383A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F64617368626F617264223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('59l83bmevs7r61qks3rnlt90r80sclh4','::1',1789396932,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393339363933323B72656469726563745F75726C7C733A33353A22687474703A2F2F6C6F63616C686F73742F74616873696E2F73747564656E742F616464223B),('5huu46q88srovv90st5vav8anpfdh8bd','::1',1778234394,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383233343339343B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('5ns1kdrn80ognvu66e2bj3fr256sccp6','::1',1778177859,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383137373835393B72656469726563745F75726C7C733A33383A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F64617368626F617264223B),('5p0risb4lqq4lv6k5nbm0vli8lm2bkih','::1',1778233142,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383233333134323B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('695cb8orubiq50jtkostkmi3s3d28ou0','::1',1789404848,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393430343834383B72656469726563745F75726C7C733A33333A22687474703A2F2F6C6F63616C686F73742F74616873696E2F64617368626F617264223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B666F7263655F70617373776F72645F6368616E67657C693A303B),('6pkgmta0bm6vbo751l1ehfse9lruhorh','::1',1789405265,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393430353137373B),('6s627drvkaogjrul0g66ddmv9knbjqoe','::1',1778174851,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383137343835313B72656469726563745F75726C7C733A34323A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F656D706C6F7965652F76696577223B616C6572742D6D6573736167652D6572726F727C733A31373A22546F6B656E204861732045787069726564223B5F5F63695F766172737C613A313A7B733A31393A22616C6572742D6D6573736167652D6572726F72223B733A333A226F6C64223B7D),('713jrrjju62061lgi2gg45pcfq8anig6','::1',1778165137,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383136353133373B),('74sm1i111a272bgprs3v6ra6oabmrbk0','::1',1778235209,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383233353230393B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('77njnbt2ko79mn82om6ipk3f8qli0jjj','::1',1789210963,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393231303936333B),('7am3r3u3dqmob09cj8hima7dvan2uuc2','::1',1789400788,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393430303738383B72656469726563745F75726C7C733A33353A22687474703A2F2F6C6F63616C686F73742F74616873696E2F73747564656E742F616464223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B666F7263655F70617373776F72645F6368616E67657C693A303B),('7bmk4f5fmjd2inv9jab2b4u4tl0cqioi','::1',1778176215,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383137363231353B72656469726563745F75726C7C733A34323A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F656D706C6F7965652F76696577223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('7os4gk8ll75mf0em13recf79q9qoui8n','::1',1789210963,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393231303936333B),('825g20hhtnkshrnarkcf4d44b89gd079','::1',1789403182,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393430333138323B),('831lc5i8qvjod99eofp1vpqr0klc8ebh','::1',1778235851,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383233353835313B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('8431sd07191b7qgbcfulv9ta5m0nuvu4','::1',1778229256,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383232393235363B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('8bnrpk94bmf3ac2nkqj5s94s0koespbu','::1',1789210962,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393231303936323B),('8dsl845a52jeli9qg227jesqr04q0b63','::1',1778166172,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383136363137323B),('8jq5tlt64tcifa4bp99ci62aqto5mlad','::1',1789378849,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383834393B),('8ks7239f8gmlqsbi9896mrqclk8me1ro','::1',1789397299,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393339373239393B72656469726563745F75726C7C733A33333A22687474703A2F2F6C6F63616C686F73742F74616873696E2F64617368626F617264223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B666F7263655F70617373776F72645F6368616E67657C693A303B),('8pc4dmo4n08060rdd4gm0ok1hp64ch1b','::1',1778166499,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383136363439393B),('93idt8ku93f31esnicegug3buoifqvan','::1',1789396619,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393339363631393B72656469726563745F75726C7C733A33303A22687474703A2F2F6C6F63616C686F73742F74616873696E2F6865616C7468223B),('9a2cv4r8ua2olsi3q6r2pik9tjdjs5sv','::1',1789378849,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383834393B),('a2rvbkvo0ov0or5oim63suri449f6vs6','::1',1789400478,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393430303437383B72656469726563745F75726C7C733A33333A22687474703A2F2F6C6F63616C686F73742F74616873696E2F64617368626F617264223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B666F7263655F70617373776F72645F6368616E67657C693A303B),('ab51bbh51hnudd7eti9b5uml4m5na0se','::1',1778169248,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383136393234383B72656469726563745F75726C7C733A34323A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F656D706C6F7965652F76696577223B),('ai1reocjts5cl3fg4i9vmuufjsj7tdti','::1',1778162420,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383136323432303B6E616D657C733A31353A224D6164696E61204D7568616D6D6164223B6C6F676765725F70686F746F7C733A31313A2264656675616C742E706E67223B6C6F67676564696E5F6272616E63687C733A323A223130223B6C6F67676564696E5F656D61696C7C733A31363A226D6164696E6140676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2232223B6C6F67676564696E5F7573657269647C733A313A2232223B6C6F67676564696E5F726F6C655F69647C733A313A2233223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B6C6173745F706167657C733A33353A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F6272616E6368223B),('ak83ijn26tbrtrchre40bc57mns00cca','::1',1789378806,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383830363B),('as8p4vktb988e2obsu4qmdmafn34h4sd','::1',1789378798,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383739383B),('b3d2oisrkgtm1ogjs5pf5tb1h9etma83','::1',1789378032,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383033323B72656469726563745F75726C7C733A33393A22687474703A2F2F6C6F63616C686F73742F74616873696E2F73746174655F616E616C7974696373223B),('b4ge08vms8eh2s6n88ccqt1fv33ult92','::1',1778220588,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383232303538383B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('ba2fo7677djb83mcnh9limg7k9gud87q','::1',1778228934,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383232383933343B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('bl5cef85bmf7d6salhamsb3hpj529p28','::1',1789383294,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393338333239343B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('blsolgccl2r7hjn7o52dlk6ur2671cbp','::1',1778189679,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383138393539343B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('bm8oc4isugbf7e0727eb02oh9tqv6n39','::1',1789378849,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383834393B),('bu9jfjlmgaavg02pujdf614hsvfna9ua','::1',1778166915,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383136363931353B),('c2787rj6va5fvlkma0mur09kjfp8less','::1',1789322951,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393332323932353B72656469726563745F75726C7C733A33393A22687474703A2F2F6C6F63616C686F73742F74616873696E2F656D706C6F7965652F766965772F39223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('c30096kjb1395pmnik93smk8l7aqub0e','::1',1778180859,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383138303835393B),('cat1d5atuqhk8l02cuauefda8dakhj8i','::1',1789254420,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393235343432303B72656469726563745F75726C7C733A33363A22687474703A2F2F6C6F63616C686F73742F74616873696E2F73747564656E742F76696577223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('chd5t1bfmgolm9sgdtohlu0q445btk4t','::1',1778159206,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383135393230363B72656469726563745F75726C7C733A33383A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F64617368626F617264223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('ck4aqivf9uiehclkpeuvqcnghba6ufrp','::1',1778174092,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383137343039323B72656469726563745F75726C7C733A34323A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F656D706C6F7965652F76696577223B),('crlov9rd0ke5i15c005upgvq4q0o24s1','::1',1789378798,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383739383B),('d298udokbrmci7pclb23p1t900d3cvgi','::1',1778165565,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383136353536353B),('d2a0gnujmdsjb9fjgqcjkorlns6tfjh0','::1',1789378798,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383739383B),('dhgtv33j5a37oh2eqjo3fgbh88qtm9cp','::1',1789378849,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383834393B),('e57uqlangv1blj16vbm5k93evhdgpr28','::1',1789210935,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393231303933353B),('e6ir8l2ge4n4hc245e90ungm4n0nnkfd','::1',1789396774,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393339363737343B72656469726563745F75726C7C733A33333A22687474703A2F2F6C6F63616C686F73742F74616873696E2F64617368626F617264223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B666F7263655F70617373776F72645F6368616E67657C693A303B),('e6oc1bbvuajgckbas5ne1uhcffql9ab2','::1',1789211020,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393231313032303B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('ed6r9bpk334p1id0u5igv2kd2eobv79k','::1',1778224796,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383232343739363B),('efb1o1udq4padl4nfsl1trj8281e206f','::1',1789378848,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383834383B),('eiscl6voe7mtefogq7f02h01ebf2mdf7','::1',1789381043,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393338313033303B72656469726563745F75726C7C733A33393A22687474703A2F2F6C6F63616C686F73742F74616873696E2F73746174655F616E616C7974696373223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('enlvmlggl226mg11n7284cl894ph3vmd','::1',1789400343,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393430303334333B72656469726563745F75726C7C733A33353A22687474703A2F2F6C6F63616C686F73742F74616873696E2F73747564656E742F616464223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B666F7263655F70617373776F72645F6368616E67657C693A303B),('eojn1rq5g71l12bf223dphnkf3jt6ql5','::1',1789380206,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393338303132343B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('eokhb2cm9lem63gis9ucjp3rdt9ejnj8','::1',1778168389,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383136383338393B),('esk1sfdtepm29ks78ri9sjh23v0ds2q2','::1',1789384073,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393338343037333B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('evju2j3k0vvv0vgq3v2562mu1o20rmts','::1',1789400927,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393430303932373B72656469726563745F75726C7C733A33333A22687474703A2F2F6C6F63616C686F73742F74616873696E2F64617368626F617264223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B666F7263655F70617373776F72645F6368616E67657C693A303B),('f0vdngi74usgpqo0ehvqub30unmdv9go','::1',1789384074,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393338343037333B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('f3v9bvpvibj6e10av76rmed0mudqgbe5','::1',1789213002,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393231323938343B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('f5jcb3ac66mt499tiont2l251lf81n7n','::1',1789404479,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393430343437393B),('f7r1cgrvvgcdh9lc2mvb8u5tcrss89sk','::1',1778161724,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383136313732343B72656469726563745F75726C7C733A33383A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F64617368626F617264223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('f8qt8kaoe68l4r73edj9djtp7dbj5f60','::1',1789402293,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393430323239333B72656469726563745F75726C7C733A33353A22687474703A2F2F6C6F63616C686F73742F74616873696E2F73747564656E742F616464223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B666F7263655F70617373776F72645F6368616E67657C693A303B),('fdf1o1t6fapa5oqrsr8lbag0l76v3apt','::1',1789402922,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393430323932323B),('ffkg6fr5bhg00cm4nq1eplbil93qhg8q','::1',1789378849,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383834393B),('fgtd9587qpvqge1qcpai8d888rgh3564','::1',1789379539,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337393533393B),('fnq1tgqd373i47oteje1lpbl51qfrsq5','::1',1778224389,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383232343338393B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('g0dtcnkhub802bv0i5in9rjbu9a6sgn8','::1',1789401343,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393430313334333B72656469726563745F75726C7C733A33353A22687474703A2F2F6C6F63616C686F73742F74616873696E2F73747564656E742F616464223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B666F7263655F70617373776F72645F6368616E67657C693A303B),('g0iuuj8cq05it9oaamclhj11ckn28eeo','::1',1778223093,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383232333039333B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('g2dikvuichsl42b85n234h3s9kqn9giv','::1',1778220272,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383232303237323B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('g6gja5qhlss3vdrp7cuntdi7ace22bj7','::1',1778162076,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383136323037363B6E616D657C733A31353A224D6164696E61204D7568616D6D6164223B6C6F676765725F70686F746F7C733A31313A2264656675616C742E706E67223B6C6F67676564696E5F6272616E63687C733A323A223130223B6C6F67676564696E5F656D61696C7C733A31363A226D6164696E6140676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2232223B6C6F67676564696E5F7573657269647C733A313A2232223B6C6F67676564696E5F726F6C655F69647C733A313A2233223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('gc77tqena1g8n4d6pac8ia1t33pstj2h','::1',1789378849,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383834393B),('gfq2sc0787el881kqqh68rck38994c1c','::1',1789210962,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393231303936323B),('ggjqh7232aoqtktuc4od447rrgpqr1uq','::1',1789210963,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393231303936333B72656469726563745F75726C7C733A33333A22687474703A2F2F6C6F63616C686F73742F74616873696E2F64617368626F617264223B),('gl1nfmlntiuljo927fshdiipc8sjhpmc','::1',1778233956,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383233333935363B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('go3s9vpkb1afeq2vpfb4b6aatu4ghlvq','::1',1778225425,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383232353432353B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('h5etl9f3e8ca2is3bdrjotn1kqqo3qfh','::1',1778238262,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383233383236323B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('h7ihci94qc0h2lfoh5kuimsqdu2qimnp','::1',1789210986,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393231303938353B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('h9j7eq3u0namiohuvu6c2ss0e5353gnr','::1',1789379168,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337393033313B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('hc5il1dqd2ila2o74l7tcuab31c325ug','::1',1789401429,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393430313432393B72656469726563745F75726C7C733A33333A22687474703A2F2F6C6F63616C686F73742F74616873696E2F64617368626F617264223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B666F7263655F70617373776F72645F6368616E67657C693A303B),('hin32il0c5ii5tfs8f8stn1r0dh2qa8q','::1',1789212984,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393231323938343B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('i47n2jvqcutta9brrr9r84ba3stjpffl','::1',1778221529,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383232313532393B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('i4obkpktloc7ouqebjljietjqec6lr56','::1',1778164823,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383136343832333B),('i5gvoc30ettmo5epf5p9n72klsbknp2a','::1',1789210936,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393231303933363B),('i5v3j14vvogn2vs1cjnp28q4n0a5lt6r','::1',1789379539,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337393533393B),('i78m5caejngjeujfq7pjpltdepk5n7t1','::1',1789399689,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393339393638393B72656469726563745F75726C7C733A33353A22687474703A2F2F6C6F63616C686F73742F74616873696E2F73747564656E742F616464223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B666F7263655F70617373776F72645F6368616E67657C693A303B),('io8a4qbr7n4vjfkkqo638f96tt1ihcuj','::1',1789378849,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383834393B),('ir0g04npg4d543r1m12tu811jqrrlr53','::1',1789378849,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383834393B),('isnt82gnts4djo48ai777qsbe4pu470t','::1',1778225714,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383232353731343B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('ivn46ika7587fkhnds5pmvm8iqsaj5b5','::1',1778229678,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383232393637383B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('j7nouk45ottrlk4vujfo9m97l59pmiqj','::1',1789405242,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393430353136333B72656469726563745F75726C7C733A33333A22687474703A2F2F6C6F63616C686F73742F74616873696E2F64617368626F617264223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B666F7263655F70617373776F72645F6368616E67657C693A303B),('jecq6r4bb77sgqk7k429dk09hb1vrkkl','::1',1789381453,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393338313236323B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('jj5o7joke647kt8anllpn7ho0m0qs4mv','::1',1789210963,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393231303936333B),('jmk3ninlokjqocuffgaa397tt3qlcdp7','::1',1789378859,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383835393B),('jn3g7qmg7kl88o8apdp1ioprnjeo6qom','::1',1778180154,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383138303135343B72656469726563745F75726C7C733A33383A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F64617368626F617264223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('jnkt3de1n6kof07knufg3df7q987ne4i','::1',1778182174,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383138323131363B72656469726563745F75726C7C733A34343A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F666565732F616C6C6F636174696F6E223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('jonvdmlgenr8010pkljgditeib3q1gfi','::1',1789378848,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383834383B),('jsf5sg0cbue79hb26qlbln912lch87hc','::1',1778173612,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383137333631323B72656469726563745F75726C7C733A34323A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F656D706C6F7965652F76696577223B),('k7a02ac6glht5thjrtd31ij3b93dpb3q','::1',1789378849,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383834393B),('kb2po0rbupvgoep5lmfflje6h1c9aatn','::1',1789395928,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393339353932383B72656469726563745F75726C7C733A33333A22687474703A2F2F6C6F63616C686F73742F74616873696E2F64617368626F617264223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B666F7263655F70617373776F72645F6368616E67657C693A303B),('kdbqf90tgsrhvje4pkorb66p7cn0c9ia','::1',1778231051,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383233313035313B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('ke71e1k3mrpbd0seg27m1ghnrfs6kkth','::1',1789403275,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393430333237353B72656469726563745F75726C7C733A33353A22687474703A2F2F6C6F63616C686F73742F74616873696E2F73747564656E742F616464223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B666F7263655F70617373776F72645F6368616E67657C693A303B),('kh9fv0fk6ujjet2o9adddn3ami7g29k9','::1',1789379539,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337393533393B),('knt47nq2cmsjr7dfqaq73thvhg2gep38','::1',1778165867,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383136353836373B),('l3mf8r5m0no4gj8j5gqccjg8tsskmnt7','::1',1789378799,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383739393B),('l3t9r4k6i4m7lq15idf5e3sksa8a0iia','::1',1789378799,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383739393B),('l7c9g96a0meafkjjr5h1lsrot5ql4hkg','::1',1778156988,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383135363938383B72656469726563745F75726C7C733A33383A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F64617368626F617264223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('lkvqqb4p44sp5sq9kud338ou265ib1dg','::1',1789378799,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383739393B),('lq7adodgb3g7ooqgcie72t2fjkbom3dq','::1',1789210963,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393231303936323B),('lvl1a0gtojfbf12m3lb9tks413icjn09','::1',1789402339,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393430323333393B72656469726563745F75726C7C733A33333A22687474703A2F2F6C6F63616C686F73742F74616873696E2F64617368626F617264223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B666F7263655F70617373776F72645F6368616E67657C693A303B),('m1laka1imaknndusj9it6b4gc3s2g4ua','::1',1789378849,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383834393B),('m26ir4j0elgha3dsktu81flleqgv0c61','::1',1789405163,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393430353136333B72656469726563745F75726C7C733A33333A22687474703A2F2F6C6F63616C686F73742F74616873696E2F64617368626F617264223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B666F7263655F70617373776F72645F6368616E67657C693A303B),('m32bo906q1f0sno3asjlk3cugh3ucrls','::1',1789253962,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393235333936323B72656469726563745F75726C7C733A33363A22687474703A2F2F6C6F63616C686F73742F74616873696E2F73747564656E742F76696577223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('m3adib9jbt37lsu4paecg92tbet1pfcm','::1',1789379539,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337393533393B),('m4qafn4pdbimn1fn0e1s0nf1f7bfkbo0','::1',1778226532,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383232363533323B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('majvkeqa40jt008c5u06aecesfucpuhe','::1',1778241680,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383234313631383B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('mb3ces7rscnvomnr4nbfhotoafkqc1kt','::1',1778227412,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383232373431323B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('mj5534fpfvrul1116aijff5n4kr5iaoe','::1',1778179243,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383137393234333B72656469726563745F75726C7C733A33383A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F64617368626F617264223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('mm28ufgebucinitrgs2hel7bjdvapmee','::1',1778228593,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383232383539333B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('mon0co0siolh8h31osft65nbdpllvmva','::1',1789398057,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393339383035373B72656469726563745F75726C7C733A33353A22687474703A2F2F6C6F63616C686F73742F74616873696E2F73747564656E742F616464223B),('n44gojlganqb6rg1lropdd58pd5ub19u','::1',1778233463,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383233333436333B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('nhf07csb764gecophj7mbq0hhv8s775n','::1',1778182116,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383138323131363B72656469726563745F75726C7C733A34343A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F666565732F616C6C6F636174696F6E223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('nhhuqk62qhqjltahmrff16dm2sh0bp8q','::1',1789403971,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393430333937313B),('njqa5hbnge40mnj7afmr25clk6ts6p9a','::1',1789380124,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393338303132343B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('nodhkflq56gggbrve2ok9jg8813jqfpk','::1',1778232071,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383233323037313B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('o063rk2ferjvin4612dm9j2n5qb5rgit','::1',1789396954,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393339363935343B72656469726563745F75726C7C733A33353A22687474703A2F2F6C6F63616C686F73742F74616873696E2F73747564656E742F616464223B),('o2d0fk34fp7kki92v0d5rui92kg44676','::1',1789230035,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393232393837383B72656469726563745F75726C7C733A33353A22687474703A2F2F6C6F63616C686F73742F74616873696E2F73747564656E742F616464223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('o45vnh0vb3q3a94fq8qll7omsvo3glgd','::1',1789381030,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393338313033303B72656469726563745F75726C7C733A33393A22687474703A2F2F6C6F63616C686F73742F74616873696E2F73746174655F616E616C7974696373223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('o8akakbet6aptlt4i7nu8b03cs2dil8e','::1',1789378849,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383834393B),('od15tkf6lqobkre67irtr4mvd0cjcrvm','::1',1778224974,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383232343936363B),('ofon552arohu19vbljg7jph1mmrh0dlf','::1',1789378849,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383834393B),('op3krdihhhecbp9bk21ukhhpk8hm9726','::1',1789378849,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383834393B),('otrcdofjoof713g2vbhmplldjbiiuvte','::1',1789210935,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393231303933353B),('p0emnjlerhqhbb0upnmo5ub13fi20tc2','::1',1778224718,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383232343731383B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('p7fljsh37gbvljugnjhfl04d3hugs2uj','::1',1789378849,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383834393B),('pbc7qm41vkkgmm0d0iog8n2kl6regrmm','::1',1789379539,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337393533393B),('peg8nn24sngejjlojf548dr5ggmgbfae','::1',1778157359,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383135373335393B72656469726563745F75726C7C733A33383A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F64617368626F617264223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('peua0ma8cjkfruoei5ankl60du6n5sqm','::1',1778221975,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383232313937353B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('piibu0e2kjbpktohmur6sikdpsjuoini','::1',1789379539,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337393533393B),('pjfdg9g2kp39reun15tjikg1eo9kf9sd','::1',1778175478,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383137353437383B72656469726563745F75726C7C733A34323A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F656D706C6F7965652F76696577223B),('plrrieh4kfa31sa37sgid9fgfqa5rkre','::1',1778222671,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383232323637313B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('pq3g9u9q7rmfof79e9lblt4202pjkjuo','::1',1778176589,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383137363538393B72656469726563745F75726C7C733A34323A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F656D706C6F7965652F76696577223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('progb7m1tujq1sjtesu4cer7tt1c8kb1','::1',1789379539,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337393533393B),('puibr94kvi72p1936abo41lpl8b7o1o9','::1',1778162836,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383136323833363B6E616D657C733A31353A224D6164696E61204D7568616D6D6164223B6C6F676765725F70686F746F7C733A31313A2264656675616C742E706E67223B6C6F67676564696E5F6272616E63687C733A323A223130223B6C6F67676564696E5F656D61696C7C733A31363A226D6164696E6140676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2232223B6C6F67676564696E5F7573657269647C733A313A2232223B6C6F67676564696E5F726F6C655F69647C733A313A2233223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B6C6173745F706167657C733A33353A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F6272616E6368223B),('q1p002ebot3rabof092omio68uv4laie','::1',1778223541,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383232333534313B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('q364lh7sps9gqcr27nv5knudk3b90qpp','::1',1789399235,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393339393233353B72656469726563745F75726C7C733A33353A22687474703A2F2F6C6F63616C686F73742F74616873696E2F73747564656E742F616464223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B666F7263655F70617373776F72645F6368616E67657C693A303B),('q65fng5evcucdjdt4i4n8ehasvv698l3','::1',1789379539,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337393533393B),('q7b52fu0tmmadpnecmc349b2d0ve07k1','::1',1789379539,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337393533393B),('qet6683qku7fpkkmqili1ae4jkl4unki','::1',1778161087,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383136313038373B72656469726563745F75726C7C733A33383A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F64617368626F617264223B),('qiaivqe04b4aqbfkrsrtho305cdn9412','::1',1778223966,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383232333936363B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('qoaq3l0ppv50c49hj9pgntj1jtmb59an','::1',1789210963,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393231303936333B),('qp4nv00gkp0sfbek1jeouam5e1urtmhe','::1',1778228072,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383232383037323B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('qrk9imfhp4e1krili48j47s6om5jr0ov','::1',1778179720,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383137393732303B72656469726563745F75726C7C733A33383A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F64617368626F617264223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('qvd5geiprgbd5pfr633qq7ojvmecnp9a','::1',1778156529,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383135363532393B72656469726563745F75726C7C733A33383A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F64617368626F617264223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('r1c5b2ta2djt3bhppmgc8id2m1gtqh6c','::1',1789257101,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393235373130313B72656469726563745F75726C7C733A33363A22687474703A2F2F6C6F63616C686F73742F74616873696E2F73747564656E742F76696577223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('r1dreps8088ccjjc0ogg1kjpqao68vih','::1',1789378849,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383834393B),('r1jvj057p882hjko16q5kov4a0jt3sc3','::1',1789378798,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383739383B),('r63r7c6j7hk1kb0foto7a5h3lebakblm','::1',1789211150,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393231313037393B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('raeuobd1osjg6b2rrlf6hovejr18mqno','::1',1789404064,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393430343036343B),('rf07ki67q04eoi7us2mshqv6fgdc23rg','::1',1789379539,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337393533383B),('rivnjj9ugrg8iric6cq6befvs0q80cpi','::1',1778177546,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383137373534363B),('rmt3cr4v97ib4qoupje58b275hn7o71n','::1',1778225174,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383232353136383B),('rogfjttqj7ce10dcvkmvnefu0k2mivtt','::1',1778232288,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383233323238383B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('s17atidqac063t9nqsl5ricaca42ropp','::1',1789210936,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393231303933363B),('sc76ga0p1idk6rigq6ns6aug2dv6m54g','::1',1789398927,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393339383932373B72656469726563745F75726C7C733A33333A22687474703A2F2F6C6F63616C686F73742F74616873696E2F64617368626F617264223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B666F7263655F70617373776F72645F6368616E67657C693A303B),('snnvj2uj2otukmk4mok97l4lpfl7d2ua','::1',1778241618,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383234313631383B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('sopm23vogn2t8uoos5jmppf3b9cuqh5l','::1',1789405177,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393430353137373B),('sttiabq8k8lqvjr3edh4r285mrp9iscc','::1',1778231742,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383233313734323B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('t1vig65qd3hidkjnlfnmmgarjc6uhnf1','::1',1778218571,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383231383537313B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('t2sqnt02og055bvn8m1mujfvss32umga','::1',1789381329,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393338313332393B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('t5t53nopk0abloggbdotov615jbplnmu','::1',1778227059,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383232373035393B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('t9h07259vb4va7562fj1s090bm1uopnb','::1',1778178177,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383137383137373B72656469726563745F75726C7C733A33383A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F64617368626F617264223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('td65lh1jsugnkqpudrqmhukn6hdisu5c','::1',1778226879,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383232363837393B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('th14e0ur4s2kp9i68roqvri7iervfko0','::1',1789382234,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393338323233343B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('u98fo3t3dk2ifmg2cgmt6kmfe1qh5tfc','::1',1789396920,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393339363932303B72656469726563745F75726C7C733A33353A22687474703A2F2F6C6F63616C686F73742F74616873696E2F73747564656E742F616464223B),('u9se9k22avd9celo89rs3mkcfgmirk2o','::1',1778231375,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383233313337353B72656469726563745F75726C7C733A34333A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F696E667261737472756374757265223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('ummrt6jnrof6eg8ld72ibufdcm9m6ajj','::1',1778163580,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383136333538303B),('v0tdgk3qdd79i1e8opshdsbb4pue6rcs','::1',1778174400,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383137343430303B72656469726563745F75726C7C733A34323A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F656D706C6F7965652F76696577223B),('v4d7udgukh70lnhe4hp8pg3gqmg261th','::1',1789378798,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383739383B),('v90giip74qle9i368e4blopjb2lplod1','::1',1789378848,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383834383B),('v99sbn5s925fv6r4nrr4igkm1i5752qa','::1',1778156165,0x5F5F63695F6C6173745F726567656E65726174657C693A313737383135363136353B72656469726563745F75726C7C733A33383A22687474703A2F2F6C6F63616C686F73742F536D6172745363686F6F6C2F64617368626F617264223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C4E3B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B),('vnmlad08ek3a7910sejj4psm395vdll1','::1',1789404283,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393430343238333B),('vsvb2im2kei13cnnehahfagkelstil10','::1',1789378799,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393337383739383B),('vt8ge3i555n7bhk0i586db9afr1093m2','::1',1789404497,0x5F5F63695F6C6173745F726567656E65726174657C693A313738393430343439373B72656469726563745F75726C7C733A33333A22687474703A2F2F6C6F63616C686F73742F74616873696E2F64617368626F617264223B6E616D657C733A353A2261646D696E223B6C6F676765725F70686F746F7C4E3B6C6F67676564696E5F6272616E63687C693A313B6C6F67676564696E5F656D61696C7C733A31353A2261646D696E40676D61696C2E636F6D223B6C6F67676564696E5F69647C733A313A2231223B6C6F67676564696E5F7573657269647C733A313A2231223B6C6F67676564696E5F726F6C655F69647C733A313A2231223B6C6F67676564696E5F747970657C733A353A227374616666223B7365745F6C616E677C733A373A22656E676C697368223B69735F72746C7C623A303B7365745F73657373696F6E5F69647C733A313A2233223B6C6F67676564696E7C623A313B666F7263655F70617373776F72645F6368616E67657C693A303B);
/*!40000 ALTER TABLE `rm_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `is_system` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Super Admin','superadmin','1'),(2,'Admin','admin','1'),(3,'Teacher','teacher','1'),(4,'Accountant','accountant','1'),(5,'Librarian','librarian','1'),(6,'Parent','parent','1'),(7,'Student','student','1'),(8,'Receptionist','receptionist','1');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salary_template`
--

DROP TABLE IF EXISTS `salary_template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `salary_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `basic_salary` decimal(18,2) NOT NULL,
  `overtime_salary` varchar(100) NOT NULL DEFAULT '0',
  `branch_id` tinyint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salary_template`
--

LOCK TABLES `salary_template` WRITE;
/*!40000 ALTER TABLE `salary_template` DISABLE KEYS */;
INSERT INTO `salary_template` VALUES (1,'Grade 5',120000.00,'0',1);
/*!40000 ALTER TABLE `salary_template` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salary_template_details`
--

DROP TABLE IF EXISTS `salary_template_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `salary_template_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `salary_template_id` varchar(20) NOT NULL,
  `name` varchar(200) NOT NULL,
  `amount` decimal(18,2) NOT NULL DEFAULT 0.00,
  `type` tinyint(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salary_template_details`
--

LOCK TABLES `salary_template_details` WRITE;
/*!40000 ALTER TABLE `salary_template_details` DISABLE KEYS */;
INSERT INTO `salary_template_details` VALUES (1,'1','House Rent',20000.00,1),(2,'1','Transport Allowance',24000.00,1),(3,'1','Medical Allowance',50000.00,1),(4,'1','Provident Fund',15000.00,2);
/*!40000 ALTER TABLE `salary_template_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales_bill`
--

DROP TABLE IF EXISTS `sales_bill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales_bill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sales_bill_rms_1` (`branch_id`),
  CONSTRAINT `sales_bill_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales_bill`
--

LOCK TABLES `sales_bill` WRITE;
/*!40000 ALTER TABLE `sales_bill` DISABLE KEYS */;
/*!40000 ALTER TABLE `sales_bill` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales_bill_details`
--

DROP TABLE IF EXISTS `sales_bill_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales_bill_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sales_bill_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `unit_price` decimal(18,2) NOT NULL DEFAULT 0.00,
  `quantity` varchar(20) NOT NULL,
  `discount` decimal(18,2) NOT NULL DEFAULT 0.00,
  `sub_total` decimal(18,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`),
  KEY `sales_bill_details_rms_1` (`product_id`),
  CONSTRAINT `sales_bill_details_rms_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales_bill_details`
--

LOCK TABLES `sales_bill_details` WRITE;
/*!40000 ALTER TABLE `sales_bill_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `sales_bill_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales_payment_history`
--

DROP TABLE IF EXISTS `sales_payment_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales_payment_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sales_bill_id` varchar(11) NOT NULL,
  `payment_by` int(11) DEFAULT NULL,
  `amount` decimal(18,2) NOT NULL DEFAULT 0.00,
  `pay_via` varchar(25) NOT NULL,
  `remarks` text NOT NULL,
  `attach_orig_name` varchar(255) DEFAULT NULL,
  `attach_file_name` varchar(255) DEFAULT NULL,
  `paid_on` date DEFAULT NULL,
  `coll_type` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales_payment_history`
--

LOCK TABLES `sales_payment_history` WRITE;
/*!40000 ALTER TABLE `sales_payment_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `sales_payment_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schoolyear`
--

DROP TABLE IF EXISTS `schoolyear`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schoolyear` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `school_year` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schoolyear`
--

LOCK TABLES `schoolyear` WRITE;
/*!40000 ALTER TABLE `schoolyear` DISABLE KEYS */;
INSERT INTO `schoolyear` VALUES (3,'2026-2027',1,'2026-02-14 19:35:41','2026-02-20 01:35:41');
/*!40000 ALTER TABLE `schoolyear` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `section`
--

DROP TABLE IF EXISTS `section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `capacity` varchar(20) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `section`
--

LOCK TABLES `section` WRITE;
/*!40000 ALTER TABLE `section` DISABLE KEYS */;
INSERT INTO `section` VALUES (1,'Boarding',NULL,1),(2,'Day',NULL,1),(3,'Weekend',NULL,1);
/*!40000 ALTER TABLE `section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sections_allocation`
--

DROP TABLE IF EXISTS `sections_allocation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sections_allocation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sections_allocation_rms_1` (`class_id`),
  KEY `sections_allocation_rms_2` (`section_id`),
  CONSTRAINT `sections_allocation_rms_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sections_allocation_rms_2` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sections_allocation`
--

LOCK TABLES `sections_allocation` WRITE;
/*!40000 ALTER TABLE `sections_allocation` DISABLE KEYS */;
INSERT INTO `sections_allocation` VALUES (81,14,1),(82,15,1),(83,16,2),(84,17,2),(85,18,3),(86,19,3);
/*!40000 ALTER TABLE `sections_allocation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sms_api`
--

DROP TABLE IF EXISTS `sms_api`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sms_api` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms_api`
--

LOCK TABLES `sms_api` WRITE;
/*!40000 ALTER TABLE `sms_api` DISABLE KEYS */;
INSERT INTO `sms_api` VALUES (1,'twilio'),(2,'clickatell'),(3,'msg91'),(4,'bulksms'),(5,'textlocal'),(6,'smscountry'),(7,'bulksmsbd'),(8,'customsms');
/*!40000 ALTER TABLE `sms_api` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sms_credential`
--

DROP TABLE IF EXISTS `sms_credential`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sms_credential` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sms_api_id` int(11) NOT NULL,
  `field_one` varchar(300) NOT NULL,
  `field_two` varchar(300) NOT NULL,
  `field_three` varchar(300) NOT NULL,
  `field_four` varchar(300) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms_credential`
--

LOCK TABLES `sms_credential` WRITE;
/*!40000 ALTER TABLE `sms_credential` DISABLE KEYS */;
/*!40000 ALTER TABLE `sms_credential` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sms_template`
--

DROP TABLE IF EXISTS `sms_template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sms_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `tags` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms_template`
--

LOCK TABLES `sms_template` WRITE;
/*!40000 ALTER TABLE `sms_template` DISABLE KEYS */;
INSERT INTO `sms_template` VALUES (1,'admission','{name}, {class}, {section}, {admission_date}, {roll}, {register_no}'),(2,'fee_collection','{name}, {class}, {section}, {admission_date}, {roll}, {register_no}, {paid_amount}, {paid_date} '),(3,'attendance','{name}, {class}, {section}, {admission_date}, {roll}, {register_no}'),(4,'exam_attendance','{name}, {class}, {section}, {admission_date}, {roll}, {register_no}, {exam_name}, {term_name}, {subject}'),(5,'exam_results','{name}, {class}, {section}, {admission_date}, {roll}, {register_no}, {exam_name}, {term_name}, {subject}, {marks}'),(6,'homework','{name}, {class}, {section}, {admission_date}, {roll}, {register_no}, {subject}, {date_of_homework}, {date_of_submission}'),(7,'live_class','{name}, {class}, {section}, {admission_date}, {roll}, {register_no}, {date_of_live_class}, {start_time}, {end_time}, {host_by}'),(8,'online_exam_publish','{name}, {class}, {section}, {admission_date}, {roll}, {register_no}, {exam_title}, {start_time}, {end_time}, {time_duration}, {attempt}, {passing_mark}, {exam_fee}'),(9,'student_birthday_wishes','{name}, {class}, {section}, {admission_date}, {roll}, {register_no}, {birthday}'),(10,'staff_birthday_wishes','{name}, {birthday}, {joining_date}'),(11,'alumni_event','{student_name}, {event_title}, {start_date}, {end_date}');
/*!40000 ALTER TABLE `sms_template` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sms_template_details`
--

DROP TABLE IF EXISTS `sms_template_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sms_template_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template_id` int(11) NOT NULL,
  `dlt_template_id` varchar(255) DEFAULT NULL,
  `notify_student` tinyint(3) NOT NULL DEFAULT 1,
  `notify_parent` tinyint(3) NOT NULL DEFAULT 1,
  `template_body` longtext NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms_template_details`
--

LOCK TABLES `sms_template_details` WRITE;
/*!40000 ALTER TABLE `sms_template_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `sms_template_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` datetime DEFAULT NULL,
  `next_of_kin_name` varchar(200) DEFAULT NULL,
  `next_of_kin_phone` varchar(50) DEFAULT NULL,
  `next_of_kin_relation` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff`
--

LOCK TABLES `staff` WRITE;
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
INSERT INTO `staff` VALUES (1,'d360115','admin',0,'',NULL,NULL,0,'2026-02-24','','','','','','','','admin@gmail.com',0,1,NULL,NULL,NULL,NULL,'2026-02-24 13:31:42',NULL,NULL,NULL,NULL),(2,'a8b38f2','Madina Muhammad',1,'BEd','','',2,'2026-03-30','2000-10-01','female','Islam','B+','Unguwan Sunusi','','09022334455','madina@gmail.com',0,1,'defualt.png','','','','2026-03-27 07:08:28',NULL,NULL,NULL,NULL),(3,'5934d5e','Jamilu Salisu',7,'MSc','','',6,'2026-04-14','','male','Islam','B+','Kaduna','','08022334455','jamilusalis@gmail.com',0,1,'defualt.png','','','','2026-04-14 07:47:56',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `staff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_attendance`
--

DROP TABLE IF EXISTS `staff_attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `status` varchar(11) DEFAULT NULL COMMENT 'P=Present, A=Absent, H=Holiday, L=Late',
  `remark` varchar(255) NOT NULL,
  `date` date DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `staff_attendance_rms_1` (`branch_id`),
  KEY `staff_attendance_rms_2` (`staff_id`),
  CONSTRAINT `staff_attendance_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  CONSTRAINT `staff_attendance_rms_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_attendance`
--

LOCK TABLES `staff_attendance` WRITE;
/*!40000 ALTER TABLE `staff_attendance` DISABLE KEYS */;
INSERT INTO `staff_attendance` VALUES (1,2,'P','','2026-03-24',1),(2,2,'P','','2026-03-27',1);
/*!40000 ALTER TABLE `staff_attendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_bank_account`
--

DROP TABLE IF EXISTS `staff_bank_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_bank_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `bank_name` varchar(200) NOT NULL,
  `holder_name` varchar(255) NOT NULL,
  `bank_branch` varchar(255) NOT NULL,
  `bank_address` varchar(255) NOT NULL,
  `ifsc_code` varchar(200) NOT NULL,
  `account_no` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_bank_account`
--

LOCK TABLES `staff_bank_account` WRITE;
/*!40000 ALTER TABLE `staff_bank_account` DISABLE KEYS */;
INSERT INTO `staff_bank_account` VALUES (1,2,'GT Bank','Madina Muhammad','Kaduna','','','0123456789','2026-03-27 07:08:29',NULL);
/*!40000 ALTER TABLE `staff_bank_account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_department`
--

DROP TABLE IF EXISTS `staff_department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_department`
--

LOCK TABLES `staff_department` WRITE;
/*!40000 ALTER TABLE `staff_department` DISABLE KEYS */;
INSERT INTO `staff_department` VALUES (1,'Science',1,'2026-03-27 06:59:21',NULL),(2,'Commerce',1,'2026-03-27 06:59:27',NULL),(3,'General',1,'2026-03-27 06:59:33',NULL),(4,'Arts',1,'2026-03-27 06:59:40',NULL),(5,'Libraries',1,'2026-03-27 06:59:49',NULL),(6,'Finance',1,'2026-03-27 06:59:55',NULL),(7,'Academic',1,'2026-03-27 07:00:00',NULL),(8,'Teaching Staff',1,'2026-04-14 08:36:50',NULL),(9,'Administrative Staff',1,'2026-04-14 08:36:50',NULL),(10,'Support Staff',1,'2026-04-14 08:36:50',NULL),(11,'Guidance & Counselling',1,'2026-04-14 08:36:50',NULL);
/*!40000 ALTER TABLE `staff_department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_designation`
--

DROP TABLE IF EXISTS `staff_designation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_designation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_designation`
--

LOCK TABLES `staff_designation` WRITE;
/*!40000 ALTER TABLE `staff_designation` DISABLE KEYS */;
INSERT INTO `staff_designation` VALUES (1,'Principal',1,'2026-03-27 07:00:56',NULL),(2,'Teacher',1,'2026-03-27 07:01:05',NULL),(3,'Asst. Teacher',1,'2026-03-27 07:01:13',NULL),(4,'Librarian',1,'2026-03-27 07:01:20',NULL),(5,'Accountant',1,'2026-03-27 07:01:29',NULL),(6,'Director',1,'2026-03-27 07:01:35',NULL),(7,'Head Teacher',1,'2026-04-14 08:36:50',NULL),(8,'Assistant Head Teacher',1,'2026-04-14 08:36:50',NULL),(9,'Class Teacher',1,'2026-04-14 08:36:50',NULL),(10,'Subject Teacher',1,'2026-04-14 08:36:50',NULL),(11,'Clerk',1,'2026-04-14 08:36:50',NULL),(12,'Gateman',1,'2026-04-14 08:36:50',NULL);
/*!40000 ALTER TABLE `staff_designation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_documents`
--

DROP TABLE IF EXISTS `staff_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category_id` varchar(20) NOT NULL,
  `remarks` text NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `enc_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_documents`
--

LOCK TABLES `staff_documents` WRITE;
/*!40000 ALTER TABLE `staff_documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `staff_documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_posting_history`
--

DROP TABLE IF EXISTS `staff_posting_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_posting_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `posted_by` int(11) DEFAULT NULL,
  `date_posted` date NOT NULL,
  `date_left` date DEFAULT NULL,
  `reason` varchar(255) DEFAULT 'Initial Posting',
  PRIMARY KEY (`id`),
  KEY `staff_id` (`staff_id`),
  CONSTRAINT `staff_posting_history_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_posting_history`
--

LOCK TABLES `staff_posting_history` WRITE;
/*!40000 ALTER TABLE `staff_posting_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `staff_posting_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_privileges`
--

DROP TABLE IF EXISTS `staff_privileges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_privileges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `is_add` tinyint(1) NOT NULL,
  `is_edit` tinyint(1) NOT NULL,
  `is_view` tinyint(1) NOT NULL,
  `is_delete` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=980 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_privileges`
--

LOCK TABLES `staff_privileges` WRITE;
/*!40000 ALTER TABLE `staff_privileges` DISABLE KEYS */;
INSERT INTO `staff_privileges` VALUES (1,3,1,1,1,1,1),(2,3,2,0,0,0,0),(3,3,3,1,1,1,1),(4,3,4,0,0,0,0),(5,3,5,0,0,0,0),(6,3,30,0,0,0,0),(7,3,7,0,0,0,0),(8,3,8,0,0,0,0),(9,3,6,0,0,1,0),(10,3,9,0,0,0,0),(11,3,10,0,0,0,0),(12,3,11,0,0,0,0),(13,3,12,0,0,0,0),(14,3,13,0,0,0,0),(15,3,14,0,0,1,0),(16,3,15,0,0,1,0),(17,3,16,0,0,0,0),(18,3,17,0,0,0,0),(20,3,19,0,0,0,0),(21,3,20,1,1,1,1),(22,3,21,0,0,0,0),(23,3,22,0,0,1,0),(24,3,23,0,0,1,0),(25,3,24,0,0,1,0),(26,3,25,0,0,1,0),(27,3,26,0,0,1,0),(28,3,27,0,0,1,0),(29,3,28,0,0,1,0),(30,3,29,0,0,1,0),(31,3,32,1,1,1,1),(32,3,31,1,1,1,1),(33,3,33,1,1,1,1),(34,3,34,1,1,1,1),(35,3,35,1,1,1,1),(36,3,36,1,1,1,1),(37,3,37,0,0,0,0),(38,3,38,1,1,1,1),(39,3,39,1,1,1,1),(40,3,77,1,1,1,1),(41,3,78,0,0,1,0),(42,3,79,0,0,0,0),(43,3,40,0,0,0,0),(44,3,41,0,0,0,0),(45,3,42,0,0,0,0),(46,3,43,0,0,0,0),(47,3,44,0,0,0,0),(48,3,45,0,0,0,0),(49,3,46,0,0,0,0),(50,3,47,0,0,0,0),(51,3,48,0,0,0,0),(52,3,49,1,0,0,0),(53,3,50,0,0,0,0),(54,3,51,0,0,0,0),(55,3,52,0,0,0,0),(56,3,53,0,0,0,0),(57,3,54,0,0,0,0),(58,3,55,0,0,1,0),(59,3,56,0,0,0,0),(60,3,57,0,0,0,0),(61,3,58,1,0,1,1),(62,3,59,0,0,1,0),(63,3,60,0,0,0,0),(64,3,61,0,0,0,0),(65,3,62,0,0,0,0),(66,3,80,0,0,0,0),(67,3,69,0,0,0,0),(68,3,70,0,0,0,0),(69,3,71,0,0,0,0),(70,3,72,0,0,0,0),(71,3,73,0,0,0,0),(72,3,74,0,0,0,0),(73,3,75,0,0,0,0),(74,3,76,0,0,0,0),(75,3,63,0,0,0,0),(76,3,64,0,0,0,0),(77,3,65,0,0,0,0),(78,3,66,0,0,0,0),(79,3,67,0,0,0,0),(80,3,68,0,0,0,0),(81,3,81,0,0,0,0),(82,3,82,0,0,0,0),(83,3,83,0,0,0,0),(84,3,84,0,0,0,0),(85,3,85,0,0,0,0),(86,3,86,0,0,0,0),(87,3,87,0,0,0,0),(88,2,1,1,1,1,1),(89,2,2,1,0,0,0),(90,2,3,1,1,1,1),(91,2,4,0,0,1,0),(92,2,5,1,0,1,0),(93,2,30,1,0,1,0),(94,2,7,1,1,1,1),(95,2,8,1,0,1,0),(96,2,6,1,1,1,1),(97,2,9,1,1,1,1),(98,2,10,1,1,1,1),(99,2,11,1,0,1,0),(100,2,12,1,1,1,1),(101,2,13,1,0,1,0),(102,2,14,1,0,1,0),(103,2,15,0,0,1,0),(104,2,16,1,1,1,1),(105,2,17,1,1,1,1),(107,2,19,1,1,1,1),(108,2,20,1,1,1,1),(109,2,21,1,1,1,1),(110,2,22,1,1,1,1),(111,2,23,1,1,1,1),(112,2,24,1,1,1,1),(113,2,25,1,1,1,1),(114,2,26,1,1,1,1),(115,2,27,1,1,1,1),(116,2,28,1,0,1,1),(117,2,29,1,1,1,1),(118,2,32,1,1,1,1),(119,2,31,1,1,1,1),(120,2,33,1,1,1,1),(121,2,34,1,1,1,1),(122,2,35,1,1,1,1),(123,2,36,1,1,1,1),(124,2,37,1,0,1,1),(125,2,38,1,1,1,1),(126,2,39,1,1,1,1),(127,2,77,1,1,1,1),(128,2,78,0,0,1,0),(129,2,79,0,0,1,0),(130,2,40,1,1,1,1),(131,2,41,1,1,1,1),(132,2,42,1,1,1,1),(133,2,43,0,0,1,1),(134,2,44,1,1,1,1),(135,2,45,1,1,1,1),(136,2,46,1,1,1,1),(137,2,47,1,1,1,1),(138,2,48,0,0,1,1),(139,2,49,1,0,0,0),(140,2,50,1,0,0,0),(141,2,51,1,0,0,0),(142,2,52,0,0,1,0),(143,2,53,0,0,1,0),(144,2,54,0,0,1,0),(145,2,55,1,1,1,1),(146,2,56,1,1,1,1),(147,2,57,1,0,1,1),(148,2,58,1,0,1,1),(149,2,59,1,1,1,1),(150,2,60,1,1,1,1),(151,2,61,1,0,1,1),(152,2,62,1,1,1,1),(153,2,80,0,0,1,0),(154,2,69,1,1,1,1),(155,2,70,1,1,1,1),(156,2,71,1,1,1,1),(157,2,72,1,1,1,1),(158,2,73,1,0,0,0),(159,2,74,1,1,1,1),(160,2,75,0,0,1,0),(161,2,76,0,0,1,1),(162,2,63,1,1,1,1),(163,2,64,1,1,1,1),(164,2,65,1,1,1,1),(165,2,66,0,0,1,0),(166,2,67,1,1,1,1),(167,2,68,1,1,1,1),(168,2,81,0,0,0,0),(169,2,82,1,0,1,0),(170,2,83,1,1,1,1),(171,2,84,1,1,1,1),(172,2,85,1,1,1,1),(173,2,86,0,0,0,0),(174,2,87,0,0,0,0),(175,7,1,0,0,0,0),(176,7,2,0,0,0,0),(177,7,3,0,0,0,0),(178,7,4,0,0,0,0),(179,7,5,0,0,0,0),(180,7,30,0,0,0,0),(181,7,7,0,0,0,0),(182,7,8,0,0,0,0),(183,7,6,0,0,0,0),(184,7,9,0,0,0,0),(185,7,10,0,0,0,0),(186,7,11,0,0,0,0),(187,7,12,0,0,0,0),(188,7,13,0,0,0,0),(189,7,14,0,0,0,0),(190,7,15,0,0,0,0),(191,7,16,0,0,0,0),(192,7,17,0,0,0,0),(194,7,19,0,0,0,0),(195,7,20,0,0,0,0),(196,7,21,0,0,0,0),(197,7,22,0,0,0,0),(198,7,23,0,0,0,0),(199,7,24,0,0,0,0),(200,7,25,0,0,0,0),(201,7,26,0,0,1,0),(202,7,27,0,0,0,0),(203,7,28,0,0,0,0),(204,7,29,0,0,1,0),(205,7,32,0,0,0,0),(206,7,31,0,0,0,0),(207,7,33,0,0,0,0),(208,7,34,0,0,0,0),(209,7,35,0,0,0,0),(210,7,36,0,0,0,0),(211,7,37,0,0,0,0),(212,7,38,0,0,0,0),(213,7,39,0,0,0,0),(214,7,77,0,0,0,0),(215,7,78,0,0,0,0),(216,7,79,0,0,0,0),(217,7,40,0,0,0,0),(218,7,41,0,0,0,0),(219,7,42,0,0,0,0),(220,7,43,0,0,0,0),(221,7,44,0,0,0,0),(222,7,45,0,0,0,0),(223,7,46,0,0,0,0),(224,7,47,0,0,0,0),(225,7,48,0,0,0,0),(226,7,49,0,0,0,0),(227,7,50,0,0,0,0),(228,7,51,0,0,0,0),(229,7,52,0,0,0,0),(230,7,53,0,0,0,0),(231,7,54,0,0,0,0),(232,7,55,0,0,0,0),(233,7,56,0,0,0,0),(234,7,57,0,0,0,0),(235,7,58,0,0,0,0),(236,7,59,0,0,0,0),(237,7,60,0,0,0,0),(238,7,61,0,0,0,0),(239,7,62,0,0,0,0),(240,7,80,0,0,0,0),(241,7,69,0,0,0,0),(242,7,70,0,0,0,0),(243,7,71,0,0,0,0),(244,7,72,0,0,0,0),(245,7,73,0,0,0,0),(246,7,74,0,0,0,0),(247,7,75,0,0,0,0),(248,7,76,0,0,0,0),(249,7,63,0,0,0,0),(250,7,64,0,0,0,0),(251,7,65,0,0,0,0),(252,7,66,0,0,0,0),(253,7,67,0,0,0,0),(254,7,68,0,0,0,0),(255,7,81,0,0,0,0),(256,7,82,0,0,0,0),(257,7,83,0,0,0,0),(258,7,84,0,0,0,0),(259,7,85,0,0,0,0),(260,7,86,0,0,0,0),(261,7,87,0,0,0,0),(262,88,88,1,1,1,1),(263,88,88,1,1,1,1),(264,89,89,1,1,1,1),(265,90,90,1,1,1,1),(266,2,88,1,0,1,0),(267,2,89,0,0,1,0),(268,90,90,1,1,1,1),(269,2,90,0,1,1,0),(270,91,91,1,1,1,1),(271,92,92,1,1,1,1),(272,2,91,0,0,1,0),(273,2,92,0,0,1,0),(274,93,93,1,1,1,1),(275,94,94,1,1,1,1),(276,95,95,1,1,1,1),(277,96,96,1,1,1,1),(278,2,93,0,0,1,0),(279,2,94,0,0,1,0),(280,2,95,0,0,1,0),(281,2,96,0,0,1,0),(282,97,97,1,1,1,1),(283,98,98,1,1,1,1),(284,2,97,0,0,1,0),(285,2,98,0,0,1,0),(286,99,99,1,1,1,1),(287,100,100,1,1,1,1),(288,101,101,1,1,1,1),(289,102,102,1,1,1,1),(290,2,99,0,0,1,0),(291,2,100,0,0,1,0),(292,2,101,0,0,1,0),(293,2,102,0,0,1,0),(294,103,103,1,1,1,1),(295,2,103,0,1,1,0),(296,3,91,0,0,0,0),(297,3,92,0,0,0,0),(298,3,93,0,0,1,0),(299,3,94,0,0,1,0),(300,3,95,0,0,1,0),(301,3,96,0,0,1,0),(302,3,97,0,0,1,0),(303,3,98,0,0,1,0),(304,3,99,0,0,0,0),(305,3,100,0,0,0,0),(306,3,101,0,0,0,0),(307,3,102,0,0,0,0),(308,3,88,1,0,1,0),(309,3,89,0,0,1,0),(310,3,90,0,0,0,0),(311,3,103,0,0,0,0),(312,4,91,0,0,1,0),(313,4,92,0,0,1,0),(314,4,93,0,0,0,0),(315,4,94,0,0,0,0),(316,4,95,0,0,0,0),(317,4,96,0,0,0,0),(318,4,97,0,0,0,0),(319,4,98,0,0,0,0),(320,4,99,0,0,0,0),(321,4,100,0,0,0,0),(322,4,101,0,0,0,0),(323,4,102,0,0,0,0),(324,4,1,0,0,0,0),(325,4,2,0,0,0,0),(326,4,3,0,0,0,0),(327,4,4,0,0,0,0),(328,4,5,0,0,0,0),(329,4,30,0,0,0,0),(330,4,7,0,0,0,0),(331,4,8,0,0,0,0),(332,4,6,0,0,0,0),(333,4,9,0,0,0,0),(334,4,10,0,0,0,0),(335,4,11,0,0,0,0),(336,4,12,1,1,1,1),(337,4,13,1,0,1,0),(338,4,14,1,0,1,0),(339,4,15,0,0,1,0),(340,4,16,1,1,1,1),(341,4,17,1,1,1,1),(343,4,19,1,1,1,1),(344,4,20,1,1,1,1),(345,4,21,1,1,1,1),(346,4,22,1,1,1,1),(347,4,23,0,0,0,0),(348,4,24,0,0,0,0),(349,4,25,0,0,0,0),(350,4,26,0,0,0,0),(351,4,27,0,0,0,0),(352,4,28,0,0,0,0),(353,4,29,0,0,0,0),(354,4,32,0,0,0,0),(355,4,88,0,0,0,0),(356,4,89,0,0,0,0),(357,4,31,0,0,0,0),(358,4,33,0,0,0,0),(359,4,34,0,0,0,0),(360,4,35,0,0,0,0),(361,4,36,0,0,0,0),(362,4,37,0,0,0,0),(363,4,38,0,0,0,0),(364,4,39,0,0,0,0),(365,4,77,0,0,0,0),(366,4,78,0,0,0,0),(367,4,79,0,0,0,0),(368,4,40,0,0,0,0),(369,4,41,0,0,0,0),(370,4,42,0,0,0,0),(371,4,43,0,0,0,0),(372,4,44,0,0,0,0),(373,4,45,0,0,0,0),(374,4,46,0,0,0,0),(375,4,47,0,0,0,0),(376,4,48,0,0,0,0),(377,4,49,0,0,0,0),(378,4,50,0,0,0,0),(379,4,51,0,0,0,0),(380,4,52,0,0,0,0),(381,4,53,0,0,0,0),(382,4,54,0,0,0,0),(383,4,55,0,0,1,0),(384,4,56,0,0,0,0),(385,4,57,0,0,0,0),(386,4,58,1,0,1,0),(387,4,59,0,0,0,0),(388,4,60,0,0,0,0),(389,4,61,0,0,0,0),(390,4,62,0,0,0,0),(391,4,80,0,0,0,0),(392,4,69,1,1,1,1),(393,4,70,1,1,1,1),(394,4,71,1,1,1,1),(395,4,72,1,1,1,1),(396,4,73,1,0,0,0),(397,4,74,1,1,1,1),(398,4,75,0,0,1,0),(399,4,76,0,0,1,0),(400,4,63,1,1,1,1),(401,4,64,1,1,1,1),(402,4,65,1,1,1,1),(403,4,66,0,0,1,0),(404,4,67,1,1,1,1),(405,4,68,1,1,1,1),(406,4,81,0,0,0,0),(407,4,82,0,0,0,0),(408,4,83,0,0,0,0),(409,4,84,0,0,0,0),(410,4,85,0,0,0,0),(411,4,86,0,0,0,0),(412,4,87,0,0,0,0),(413,4,90,0,0,0,0),(414,4,103,0,0,0,0),(415,5,91,0,0,0,0),(416,5,92,0,0,0,0),(417,5,93,0,0,1,0),(418,5,94,0,0,1,0),(419,5,95,0,0,0,0),(420,5,96,0,0,0,0),(421,5,97,0,0,0,0),(422,5,98,0,0,0,0),(423,5,99,0,0,0,0),(424,5,100,0,0,0,0),(425,5,101,0,0,0,0),(426,5,102,0,0,0,0),(427,5,1,0,0,1,0),(428,5,2,0,0,0,0),(429,5,3,0,0,0,0),(430,5,4,0,0,0,0),(431,5,5,0,0,0,0),(432,5,30,0,0,0,0),(433,5,7,0,0,0,0),(434,5,8,0,0,0,0),(435,5,6,0,0,1,0),(436,5,9,0,0,0,0),(437,5,10,0,0,0,0),(438,5,11,0,0,0,0),(439,5,12,0,0,0,0),(440,5,13,0,0,0,0),(441,5,14,0,0,0,0),(442,5,15,0,0,0,0),(443,5,16,0,0,0,0),(444,5,17,0,0,0,0),(446,5,19,0,0,0,0),(447,5,20,1,1,1,1),(448,5,21,0,0,0,0),(449,5,22,0,0,0,0),(450,5,23,0,0,0,0),(451,5,24,0,0,0,0),(452,5,25,0,0,0,0),(453,5,26,0,0,0,0),(454,5,27,0,0,0,0),(455,5,28,0,0,0,0),(456,5,29,0,0,0,0),(457,5,32,0,0,0,0),(458,5,88,0,0,0,0),(459,5,89,0,0,0,0),(460,5,31,0,0,0,0),(461,5,33,0,0,0,0),(462,5,34,0,0,0,0),(463,5,35,0,0,0,0),(464,5,36,0,0,0,0),(465,5,37,0,0,0,0),(466,5,38,0,0,0,0),(467,5,39,0,0,0,0),(468,5,77,0,0,0,0),(469,5,78,0,0,0,0),(470,5,79,0,0,0,0),(471,5,40,0,0,0,0),(472,5,41,0,0,0,0),(473,5,42,0,0,0,0),(474,5,43,0,0,0,0),(475,5,44,0,0,0,0),(476,5,45,0,0,0,0),(477,5,46,0,0,0,0),(478,5,47,0,0,0,0),(479,5,48,0,0,0,0),(480,5,49,0,0,0,0),(481,5,50,0,0,0,0),(482,5,51,0,0,0,0),(483,5,52,0,0,0,0),(484,5,53,0,0,0,0),(485,5,54,0,0,0,0),(486,5,55,1,1,1,1),(487,5,56,1,1,1,1),(488,5,57,1,0,1,1),(489,5,58,1,0,1,1),(490,5,59,0,0,0,0),(491,5,60,0,0,0,0),(492,5,61,0,0,0,0),(493,5,62,0,0,0,0),(494,5,80,0,0,0,0),(495,5,69,0,0,0,0),(496,5,70,0,0,0,0),(497,5,71,0,0,0,0),(498,5,72,0,0,0,0),(499,5,73,0,0,0,0),(500,5,74,0,0,0,0),(501,5,75,0,0,0,0),(502,5,76,0,0,0,0),(503,5,63,0,0,0,0),(504,5,64,0,0,0,0),(505,5,65,0,0,0,0),(506,5,66,0,0,0,0),(507,5,67,0,0,0,0),(508,5,68,0,0,0,0),(509,5,81,0,0,0,0),(510,5,82,0,0,0,0),(511,5,83,0,0,0,0),(512,5,84,0,0,0,0),(513,5,85,0,0,0,0),(514,5,86,0,0,0,0),(515,5,87,0,0,0,0),(516,5,90,0,0,0,0),(517,5,103,0,0,0,0),(518,104,104,1,1,1,1),(519,2,104,0,0,1,0),(520,4,104,0,0,1,0),(521,2,18,1,1,1,0),(522,2,105,0,1,1,0),(523,2,106,1,1,1,1),(524,2,107,0,0,1,0),(525,2,109,1,1,1,1),(526,2,108,0,1,1,0),(527,3,18,0,0,0,0),(528,3,107,0,0,0,0),(529,3,109,1,1,1,1),(530,3,104,0,0,0,0),(531,3,105,0,0,0,0),(532,3,106,0,0,0,0),(533,3,108,0,0,0,0),(534,2,110,1,1,1,1),(535,2,111,0,0,1,0),(536,2,112,0,0,1,0),(537,2,113,1,1,1,1),(538,2,114,0,0,1,0),(539,2,115,0,0,1,0),(540,2,116,1,1,1,1),(541,2,117,0,0,1,0),(542,3,110,1,1,1,1),(543,3,111,0,0,1,0),(544,3,112,0,0,0,0),(545,3,113,1,1,1,1),(546,3,114,0,0,1,0),(547,3,115,0,0,0,0),(548,3,116,1,1,1,1),(549,3,117,0,0,1,0),(550,2,127,1,0,1,1),(551,2,118,1,0,1,0),(552,2,119,1,1,1,1),(553,2,120,1,0,1,0),(554,2,121,1,1,1,1),(555,2,122,1,1,1,1),(556,2,123,1,1,1,1),(557,2,124,1,1,1,1),(558,2,125,1,1,1,1),(559,2,126,1,1,1,1),(560,3,118,0,0,0,0),(561,3,119,0,0,0,0),(562,3,120,0,0,0,0),(563,3,121,0,0,0,0),(564,3,122,0,0,0,0),(565,3,123,0,0,0,0),(566,3,124,0,0,0,0),(567,3,125,0,0,0,0),(568,3,126,0,0,0,0),(569,3,127,0,0,0,0),(570,3,128,0,0,0,0),(571,2,129,0,0,1,0),(572,2,128,0,0,0,0),(573,2,131,1,1,1,1),(574,2,132,1,1,1,1),(575,2,130,0,0,0,1),(576,4,118,0,0,0,0),(577,4,119,0,0,0,0),(578,4,120,0,0,0,0),(579,4,121,0,0,0,0),(580,4,122,0,0,0,0),(581,4,123,0,0,0,0),(582,4,124,0,0,0,0),(583,4,125,0,0,0,0),(584,4,126,0,0,0,0),(585,4,131,0,0,0,0),(586,4,132,0,0,0,0),(587,4,127,0,0,0,0),(588,4,113,0,0,0,0),(589,4,114,0,0,0,0),(590,4,115,0,0,0,0),(591,4,116,0,0,0,0),(592,4,117,0,0,0,0),(593,4,110,0,0,0,0),(594,4,111,0,0,0,0),(595,4,112,0,0,0,0),(596,4,18,0,0,0,0),(597,4,107,0,0,0,0),(598,4,109,0,0,0,0),(599,4,129,0,0,0,0),(600,4,130,0,0,0,1),(601,4,105,0,0,0,0),(602,4,106,0,0,0,0),(603,4,108,0,0,0,0),(604,4,128,0,0,0,0),(605,2,154,1,1,1,1),(606,2,155,0,0,1,0),(607,2,133,0,0,1,0),(608,3,133,0,0,1,0),(609,2,134,1,1,1,1),(610,2,136,1,1,1,1),(611,2,137,1,1,1,1),(612,2,138,1,0,0,0),(613,2,139,1,1,1,1),(614,2,140,0,0,1,0),(615,2,135,0,1,1,0),(616,3,131,0,0,0,0),(617,3,132,0,0,0,0),(618,3,129,0,0,0,0),(619,3,130,0,0,0,0),(620,3,136,1,1,1,1),(621,3,137,1,1,1,1),(622,3,138,1,0,0,0),(623,3,139,1,1,1,1),(624,3,140,0,0,1,0),(625,3,134,0,0,0,0),(626,3,135,0,0,0,0),(627,2,141,1,0,1,0),(628,2,142,1,1,1,1),(629,2,143,1,1,1,1),(630,2,144,1,1,1,1),(631,2,145,1,1,1,1),(632,2,146,1,1,1,1),(633,2,147,1,0,1,1),(634,2,148,1,1,1,1),(635,2,149,0,0,1,0),(636,2,150,0,0,1,0),(637,2,151,0,0,1,0),(638,2,152,0,0,1,0),(639,2,153,0,0,1,0),(640,8,91,0,0,0,0),(641,8,92,0,0,0,0),(642,8,93,0,0,1,0),(643,8,94,0,0,1,0),(644,8,95,0,0,1,0),(645,8,96,0,0,1,0),(646,8,97,0,0,0,0),(647,8,98,0,0,0,0),(648,8,99,0,0,0,0),(649,8,100,0,0,0,0),(650,8,101,0,0,0,0),(651,8,102,0,0,0,0),(652,8,151,0,0,1,0),(653,8,152,0,0,1,0),(654,8,118,0,0,0,0),(655,8,119,0,0,0,0),(656,8,120,0,0,0,0),(657,8,121,0,0,0,0),(658,8,122,0,0,0,0),(659,8,123,0,0,0,0),(660,8,124,0,0,0,0),(661,8,125,0,0,0,0),(662,8,126,0,0,0,0),(663,8,131,0,0,0,0),(664,8,132,0,0,0,0),(665,8,1,0,0,1,0),(666,8,2,0,0,0,0),(667,8,3,0,0,0,0),(668,8,4,0,0,0,0),(669,8,5,0,0,0,0),(670,8,30,0,0,0,0),(671,8,127,0,0,0,0),(672,8,7,0,0,1,0),(673,8,8,0,0,0,0),(674,8,6,0,0,1,0),(675,8,9,0,0,0,0),(676,8,10,0,0,0,0),(677,8,11,0,0,0,0),(678,8,113,0,0,0,0),(679,8,114,0,0,0,0),(680,8,115,0,0,0,0),(681,8,116,0,0,0,0),(682,8,117,0,0,0,0),(683,8,110,0,0,0,0),(684,8,111,0,0,0,0),(685,8,112,0,0,0,0),(686,8,12,0,0,0,0),(687,8,13,0,0,0,0),(688,8,14,0,0,1,0),(689,8,15,0,0,0,0),(690,8,16,0,0,0,0),(691,8,17,0,0,0,0),(692,8,18,1,0,1,1),(693,8,19,0,0,0,0),(694,8,20,1,1,1,1),(695,8,21,0,0,0,0),(696,8,22,0,0,0,0),(697,8,107,0,0,0,0),(698,8,23,0,0,0,0),(699,8,24,0,0,0,0),(700,8,25,0,0,0,0),(701,8,26,0,0,0,0),(702,8,27,0,0,0,0),(703,8,28,0,0,0,0),(704,8,29,0,0,0,0),(705,8,133,0,0,0,0),(706,8,109,0,0,0,0),(707,8,129,0,0,0,0),(708,8,31,0,0,0,0),(709,8,33,0,0,0,0),(710,8,32,0,0,0,0),(711,8,88,0,0,0,0),(712,8,89,0,0,0,0),(713,8,34,0,0,0,0),(714,8,35,0,0,0,0),(715,8,36,0,0,0,0),(716,8,37,0,0,0,0),(717,8,38,0,0,0,0),(718,8,39,0,0,0,0),(719,8,77,0,0,0,0),(720,8,78,0,0,0,0),(721,8,79,0,0,0,0),(722,8,153,0,0,0,0),(723,8,40,0,0,0,0),(724,8,41,0,0,0,0),(725,8,42,0,0,0,0),(726,8,43,0,0,0,0),(727,8,44,0,0,0,0),(728,8,45,0,0,0,0),(729,8,46,0,0,0,0),(730,8,47,0,0,0,0),(731,8,48,0,0,0,0),(732,8,49,0,0,0,0),(733,8,50,0,0,0,0),(734,8,51,0,0,0,0),(735,8,52,0,0,0,0),(736,8,53,0,0,0,0),(737,8,54,0,0,0,0),(738,8,55,0,0,0,0),(739,8,56,0,0,0,0),(740,8,57,0,0,0,0),(741,8,58,0,0,0,0),(742,8,59,0,0,0,0),(743,8,60,0,0,0,0),(744,8,61,0,0,0,0),(745,8,62,0,0,0,0),(746,8,80,0,0,0,0),(747,8,149,0,0,0,0),(748,8,150,0,0,0,0),(749,8,69,0,0,0,0),(750,8,70,0,0,0,0),(751,8,71,0,0,0,0),(752,8,72,0,0,0,0),(753,8,73,0,0,0,0),(754,8,74,0,0,0,0),(755,8,75,0,0,0,0),(756,8,76,0,0,0,0),(757,8,104,0,0,0,0),(758,8,130,0,0,0,0),(759,8,63,0,0,0,0),(760,8,64,0,0,0,0),(761,8,65,0,0,0,0),(762,8,66,0,0,0,0),(763,8,67,0,0,0,0),(764,8,68,0,0,0,0),(765,8,136,0,0,0,0),(766,8,137,0,0,0,0),(767,8,138,0,0,0,0),(768,8,139,0,0,0,0),(769,8,140,0,0,0,0),(770,8,141,0,0,0,0),(771,8,142,1,1,1,1),(772,8,143,1,1,1,1),(773,8,144,1,1,1,1),(774,8,145,1,1,1,1),(775,8,146,1,1,1,1),(776,8,147,1,0,1,1),(777,8,148,1,1,1,1),(778,8,81,0,0,0,0),(779,8,82,0,0,0,0),(780,8,83,0,0,0,0),(781,8,84,0,0,0,0),(782,8,85,0,0,0,0),(783,8,86,0,0,0,0),(784,8,87,0,0,0,0),(785,8,90,0,0,0,0),(786,8,103,0,0,0,0),(787,8,105,0,0,0,0),(788,8,106,0,0,0,0),(789,8,108,0,0,0,0),(790,8,128,0,0,0,0),(791,8,134,0,0,0,0),(792,8,135,0,0,0,0),(793,2,157,1,1,1,1),(794,2,158,1,1,1,1),(795,2,159,1,1,1,1),(796,2,160,1,1,1,1),(797,2,161,1,1,1,1),(798,2,162,1,0,1,0),(799,2,163,1,1,1,1),(800,2,164,1,0,1,1),(801,2,165,0,0,1,0),(802,2,166,1,0,1,1),(803,2,167,0,0,1,0),(804,2,168,0,0,1,0),(805,2,173,1,1,1,1),(806,2,174,1,1,1,1),(807,2,155,0,0,1,0),(808,2,156,1,1,1,1),(809,2,169,0,0,1,1),(810,2,170,1,1,1,1),(811,2,171,1,1,1,1),(812,2,172,1,0,1,0),(813,2,175,1,1,1,1),(949,1,28,1,1,1,1),(950,1,29,1,1,1,1),(951,3,176,1,1,1,1),(952,2,176,1,1,1,1),(953,7,176,1,1,1,1),(954,88,176,1,1,1,1),(955,89,176,1,1,1,1),(956,90,176,1,1,1,1),(957,91,176,1,1,1,1),(958,92,176,1,1,1,1),(959,93,176,1,1,1,1),(960,94,176,1,1,1,1),(961,95,176,1,1,1,1),(962,96,176,1,1,1,1),(963,97,176,1,1,1,1),(964,98,176,1,1,1,1),(965,99,176,1,1,1,1),(966,100,176,1,1,1,1),(967,101,176,1,1,1,1),(968,102,176,1,1,1,1),(969,103,176,1,1,1,1),(970,4,176,1,1,1,1),(971,5,176,1,1,1,1),(972,104,176,1,1,1,1),(973,8,176,1,1,1,1),(979,1,176,1,1,1,1);
/*!40000 ALTER TABLE `staff_privileges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `register_no` varchar(100) DEFAULT NULL,
  `nin` varchar(11) DEFAULT NULL COMMENT 'National Identification Number (NIN)',
  `state_student_id` varchar(25) DEFAULT NULL COMMENT 'Auto-generated Tahsin Academy student ID',
  `admission_date` varchar(100) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `other_name` varchar(255) DEFAULT NULL,
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
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_state_student_id` (`state_student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_admission_fields`
--

DROP TABLE IF EXISTS `student_admission_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_admission_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fields_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `required` tinyint(4) NOT NULL DEFAULT 0,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_admission_fields`
--

LOCK TABLES `student_admission_fields` WRITE;
/*!40000 ALTER TABLE `student_admission_fields` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_admission_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_attendance`
--

DROP TABLE IF EXISTS `student_attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `enroll_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(4) DEFAULT NULL COMMENT 'P=Present, A=Absent, H=Holiday, L=Late',
  `remark` text DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `student_attendance_rms_1` (`branch_id`),
  KEY `student_attendance_rms_2` (`enroll_id`),
  CONSTRAINT `student_attendance_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  CONSTRAINT `student_attendance_rms_2` FOREIGN KEY (`enroll_id`) REFERENCES `enroll` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_attendance`
--

LOCK TABLES `student_attendance` WRITE;
/*!40000 ALTER TABLE `student_attendance` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_attendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_category`
--

DROP TABLE IF EXISTS `student_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_category`
--

LOCK TABLES `student_category` WRITE;
/*!40000 ALTER TABLE `student_category` DISABLE KEYS */;
INSERT INTO `student_category` VALUES (1,1,'Without Technical Skills'),(2,1,'With Technical Skills');
/*!40000 ALTER TABLE `student_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_documents`
--

DROP TABLE IF EXISTS `student_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` varchar(100) NOT NULL,
  `remarks` text NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `enc_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_documents`
--

LOCK TABLES `student_documents` WRITE;
/*!40000 ALTER TABLE `student_documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_fields`
--

DROP TABLE IF EXISTS `student_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prefix` varchar(255) NOT NULL,
  `default_status` tinyint(1) NOT NULL DEFAULT 1,
  `default_required` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_fields`
--

LOCK TABLES `student_fields` WRITE;
/*!40000 ALTER TABLE `student_fields` DISABLE KEYS */;
INSERT INTO `student_fields` VALUES (1,'roll',1,0,'2026-02-18 20:27:04'),(2,'last_name',1,1,'2026-02-18 20:27:04'),(3,'gender',1,0,'2026-02-18 20:27:04'),(4,'birthday',1,0,'2026-02-18 20:27:04'),(5,'admission_date',1,1,'2026-02-18 20:27:04'),(6,'category',1,1,'2026-02-18 20:27:04'),(7,'section',1,1,'2026-02-18 20:27:04'),(8,'religion',1,0,'2026-02-18 20:27:04'),(9,'caste',1,0,'2026-02-18 20:27:04'),(10,'blood_group',1,0,'2026-02-18 20:27:04'),(11,'mother_tongue',1,0,'2026-02-18 20:27:04'),(12,'present_address',1,0,'2026-02-18 20:27:04'),(13,'permanent_address',1,0,'2026-02-18 20:27:04'),(14,'city',1,0,'2026-02-18 20:27:04'),(15,'state',1,0,'2026-02-18 20:27:04'),(16,'student_email',1,0,'2026-02-18 20:27:04'),(17,'student_mobile_no',1,0,'2026-02-18 20:27:04'),(18,'student_photo',1,0,'2026-02-18 20:27:04'),(19,'previous_school_details',1,0,'2026-02-18 20:27:04'),(20,'guardian_name',1,1,'2026-02-18 20:27:04'),(21,'guardian_relation',1,1,'2026-02-18 20:27:04'),(22,'father_name',1,0,'2026-02-18 20:27:04'),(23,'mother_name',1,0,'2026-02-18 20:27:04'),(24,'guardian_occupation',1,1,'2026-02-18 20:27:04'),(25,'guardian_income',1,1,'2026-02-18 20:27:04'),(26,'guardian_education',1,1,'2026-02-18 20:27:04'),(27,'guardian_email',1,1,'2026-02-18 20:27:04'),(28,'guardian_mobile_no',1,1,'2026-02-18 20:27:04'),(29,'guardian_address',1,1,'2026-02-18 20:27:04'),(30,'guardian_photo',1,0,'2026-02-18 20:27:04'),(31,'upload_documents',1,1,'2026-02-18 20:27:04'),(32,'guardian_city',1,0,'2026-02-18 20:27:04'),(33,'guardian_state',1,0,'2026-02-18 20:27:04'),(34,'first_name',1,1,'2026-02-18 20:27:04');
/*!40000 ALTER TABLE `student_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_profile_fields`
--

DROP TABLE IF EXISTS `student_profile_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_profile_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fields_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `required` tinyint(4) NOT NULL DEFAULT 0,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_profile_fields`
--

LOCK TABLES `student_profile_fields` WRITE;
/*!40000 ALTER TABLE `student_profile_fields` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_profile_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_subject_attendance`
--

DROP TABLE IF EXISTS `student_subject_attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_subject_attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `enroll_id` int(11) DEFAULT NULL,
  `subject_timetable_id` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `attendence_type_id` (`status`),
  KEY `student_session_id` (`enroll_id`),
  KEY `subject_timetable_id` (`subject_timetable_id`),
  KEY `student_subject_attendance_rms_1` (`branch_id`),
  CONSTRAINT `student_subject_attendance_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  CONSTRAINT `student_subject_attendance_rms_2` FOREIGN KEY (`enroll_id`) REFERENCES `enroll` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_subject_attendance`
--

LOCK TABLES `student_subject_attendance` WRITE;
/*!40000 ALTER TABLE `student_subject_attendance` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_subject_attendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subject`
--

DROP TABLE IF EXISTS `subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `subject_code` varchar(200) NOT NULL,
  `subject_type` varchar(255) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `curriculum_pdf` varchar(255) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subject`
--

LOCK TABLES `subject` WRITE;
/*!40000 ALTER TABLE `subject` DISABLE KEYS */;
INSERT INTO `subject` VALUES (1,'English Language','ENG','Mandatory','',1),(2,'Mathematics','MTH','Mandatory','',1),(3,'Computer Studies','COM','Mandatory','',1),(4,'Civic Education','CIV','Optional','',1),(7,'Basic Science','BSC','Theory','',1),(8,'Social Studies','SST','Theory','',1),(9,'Christian Religious Knowledge','CRK','Theory','',1),(10,'Islamic Religious Knowledge','IRK','Theory','',1),(11,'Hausa Language','HAU','Theory','',1),(12,'Arabic Studies','ARB','Theory','',1),(14,'Basic Technology','BTC','Practical','',1),(15,'Agricultural Science','AGR','Theory','',1),(16,'Business Studies','BSN','Theory','',1),(17,'Home Economics','HEC','Practical','',1),(18,'Physical & Health Education','PHE','Practical','',1),(19,'Creative Arts','CRA','Practical','',1),(20,'French','FRN','Theory','',1),(24,'Physics','PHY','Practical','',1),(25,'Chemistry','CHM','Practical','',1),(26,'Biology','BIO','Practical','',1),(27,'Further Mathematics','FMT','Theory','',1),(28,'Geography','GEO','Theory','',1),(29,'Economics','ECO','Theory','',1),(30,'Government','GOV','Theory','',1),(31,'Literature-in-English','LIT','Theory','',1),(39,'Technical Drawing','TDR','Practical','',1),(40,'Financial Accounting','ACC','Theory','',1),(41,'Commerce','COM','Theory','',1);
/*!40000 ALTER TABLE `subject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subject_assign`
--

DROP TABLE IF EXISTS `subject_assign`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subject_assign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subject_assign_rms_1` (`branch_id`),
  KEY `subject_assign_rms_2` (`session_id`),
  KEY `subject_assign_rms_3` (`class_id`),
  KEY `subject_assign_rms_4` (`section_id`),
  KEY `subject_assign_rms_5` (`subject_id`),
  CONSTRAINT `subject_assign_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  CONSTRAINT `subject_assign_rms_2` FOREIGN KEY (`session_id`) REFERENCES `schoolyear` (`id`) ON DELETE CASCADE,
  CONSTRAINT `subject_assign_rms_3` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`) ON DELETE CASCADE,
  CONSTRAINT `subject_assign_rms_4` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`) ON DELETE CASCADE,
  CONSTRAINT `subject_assign_rms_5` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subject_assign`
--

LOCK TABLES `subject_assign` WRITE;
/*!40000 ALTER TABLE `subject_assign` DISABLE KEYS */;
INSERT INTO `subject_assign` VALUES (1,16,2,1,2,1,3,'2026-03-27 07:51:53',NULL),(2,16,2,2,2,1,3,'2026-03-27 07:51:53',NULL),(3,16,2,3,2,1,3,'2026-03-27 07:51:53',NULL);
/*!40000 ALTER TABLE `subject_assign` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teacher_allocation`
--

DROP TABLE IF EXISTS `teacher_allocation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teacher_allocation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teacher_allocation`
--

LOCK TABLES `teacher_allocation` WRITE;
/*!40000 ALTER TABLE `teacher_allocation` DISABLE KEYS */;
INSERT INTO `teacher_allocation` VALUES (1,16,2,2,3,1);
/*!40000 ALTER TABLE `teacher_allocation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teacher_note`
--

DROP TABLE IF EXISTS `teacher_note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teacher_note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` longtext NOT NULL,
  `description` longtext NOT NULL,
  `file_name` longtext NOT NULL,
  `enc_name` longtext NOT NULL,
  `type_id` int(11) NOT NULL,
  `class_id` longtext NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teacher_note`
--

LOCK TABLES `teacher_note` WRITE;
/*!40000 ALTER TABLE `teacher_note` DISABLE KEYS */;
/*!40000 ALTER TABLE `teacher_note` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `theme_settings`
--

DROP TABLE IF EXISTS `theme_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `theme_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `border_mode` varchar(200) NOT NULL,
  `dark_skin` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `theme_settings`
--

LOCK TABLES `theme_settings` WRITE;
/*!40000 ALTER TABLE `theme_settings` DISABLE KEYS */;
INSERT INTO `theme_settings` VALUES (1,'true','false','2026-02-10 16:59:38','2026-02-14 14:08:47');
/*!40000 ALTER TABLE `theme_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `timetable_class`
--

DROP TABLE IF EXISTS `timetable_class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `timetable_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `timetable_class_rms_1` (`branch_id`),
  KEY `timetable_class_rms_2` (`class_id`),
  KEY `timetable_class_rms_3` (`section_id`),
  KEY `timetable_class_rms_4` (`session_id`),
  CONSTRAINT `timetable_class_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  CONSTRAINT `timetable_class_rms_2` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`) ON DELETE CASCADE,
  CONSTRAINT `timetable_class_rms_3` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`) ON DELETE CASCADE,
  CONSTRAINT `timetable_class_rms_4` FOREIGN KEY (`session_id`) REFERENCES `schoolyear` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `timetable_class`
--

LOCK TABLES `timetable_class` WRITE;
/*!40000 ALTER TABLE `timetable_class` DISABLE KEYS */;
INSERT INTO `timetable_class` VALUES (1,16,2,'0',1,2,'1','08:00:00','08:45:00','monday',3,1),(2,16,2,'0',2,2,'2','08:50:00','09:35:00','monday',3,1),(3,16,2,'0',3,2,'3','09:40:00','10:35:00','monday',3,1),(4,16,2,'1',0,0,'','10:40:00','11:10:00','monday',3,1);
/*!40000 ALTER TABLE `timetable_class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `timetable_exam`
--

DROP TABLE IF EXISTS `timetable_exam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `timetable_exam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `timetable_exam_rms_1` (`branch_id`),
  KEY `timetable_exam_rms_2` (`exam_id`),
  KEY `timetable_exam_rms_3` (`class_id`),
  KEY `timetable_exam_rms_4` (`section_id`),
  KEY `timetable_exam_rms_5` (`session_id`),
  KEY `timetable_exam_rms_6` (`subject_id`),
  CONSTRAINT `timetable_exam_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  CONSTRAINT `timetable_exam_rms_2` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`id`) ON DELETE CASCADE,
  CONSTRAINT `timetable_exam_rms_3` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`) ON DELETE CASCADE,
  CONSTRAINT `timetable_exam_rms_4` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`) ON DELETE CASCADE,
  CONSTRAINT `timetable_exam_rms_5` FOREIGN KEY (`session_id`) REFERENCES `schoolyear` (`id`) ON DELETE CASCADE,
  CONSTRAINT `timetable_exam_rms_6` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `timetable_exam`
--

LOCK TABLES `timetable_exam` WRITE;
/*!40000 ALTER TABLE `timetable_exam` DISABLE KEYS */;
INSERT INTO `timetable_exam` VALUES (1,1,16,2,1,'9:00 AM','12:00 PM','{\"2\":{\"full_mark\":\"30\",\"pass_mark\":\"15\"},\"3\":{\"full_mark\":\"80\",\"pass_mark\":\"40\"}}',1,'2026-04-02',1,3,'2026-04-02 14:49:14',NULL),(2,1,16,2,2,'9:00 AM','12:00 PM','{\"2\":{\"full_mark\":\"30\",\"pass_mark\":\"15\"},\"3\":{\"full_mark\":\"80\",\"pass_mark\":\"40\"}}',1,'2026-04-06',1,3,'2026-04-02 14:49:14',NULL),(3,1,16,2,3,'9:00 AM','12:00 PM','{\"2\":{\"full_mark\":\"30\",\"pass_mark\":\"15\"},\"3\":{\"full_mark\":\"80\",\"pass_mark\":\"40\"}}',1,'2026-04-08',1,3,'2026-04-02 14:49:14',NULL);
/*!40000 ALTER TABLE `timetable_exam` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transactions_rms_1` (`branch_id`),
  CONSTRAINT `transactions_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions_links`
--

DROP TABLE IF EXISTS `transactions_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(3) DEFAULT NULL,
  `deposit` tinyint(3) DEFAULT NULL,
  `expense` tinyint(3) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transactions_links_rms_1` (`branch_id`),
  CONSTRAINT `transactions_links_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions_links`
--

LOCK TABLES `transactions_links` WRITE;
/*!40000 ALTER TABLE `transactions_links` DISABLE KEYS */;
INSERT INTO `transactions_links` VALUES (1,1,1,1,1);
/*!40000 ALTER TABLE `transactions_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions_links_details`
--

DROP TABLE IF EXISTS `transactions_links_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions_links_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_id` int(11) NOT NULL,
  `transactions_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions_links_details`
--

LOCK TABLES `transactions_links_details` WRITE;
/*!40000 ALTER TABLE `transactions_links_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `transactions_links_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transport_assign`
--

DROP TABLE IF EXISTS `transport_assign`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transport_assign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `route_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `transport_assign_rms_1` (`branch_id`),
  CONSTRAINT `transport_assign_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transport_assign`
--

LOCK TABLES `transport_assign` WRITE;
/*!40000 ALTER TABLE `transport_assign` DISABLE KEYS */;
/*!40000 ALTER TABLE `transport_assign` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transport_fee_details`
--

DROP TABLE IF EXISTS `transport_fee_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transport_fee_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `month` varchar(2) DEFAULT NULL,
  `transport_fee_fine_id` int(11) DEFAULT NULL,
  `enroll_id` int(11) NOT NULL,
  `stoppage_point_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `transport_fee_details_rms_1` (`stoppage_point_id`),
  KEY `transport_fee_details_rms_2` (`enroll_id`),
  CONSTRAINT `transport_fee_details_rms_2` FOREIGN KEY (`enroll_id`) REFERENCES `enroll` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transport_fee_details`
--

LOCK TABLES `transport_fee_details` WRITE;
/*!40000 ALTER TABLE `transport_fee_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `transport_fee_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transport_fee_fine`
--

DROP TABLE IF EXISTS `transport_fee_fine`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transport_fee_fine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `month` varchar(2) NOT NULL,
  `due_date` date NOT NULL,
  `fine_value` varchar(20) DEFAULT NULL,
  `fine_type` varchar(20) DEFAULT NULL,
  `fee_frequency` varchar(20) DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fee_fine_rms_2` (`month`),
  KEY `fee_fine_rms_3` (`session_id`),
  KEY `fee_fine_rms_4` (`branch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transport_fee_fine`
--

LOCK TABLES `transport_fee_fine` WRITE;
/*!40000 ALTER TABLE `transport_fee_fine` DISABLE KEYS */;
/*!40000 ALTER TABLE `transport_fee_fine` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transport_route`
--

DROP TABLE IF EXISTS `transport_route`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transport_route` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext NOT NULL,
  `start_place` longtext NOT NULL,
  `remarks` longtext NOT NULL,
  `stop_place` longtext NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transport_route_rms_1` (`branch_id`),
  CONSTRAINT `transport_route_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transport_route`
--

LOCK TABLES `transport_route` WRITE;
/*!40000 ALTER TABLE `transport_route` DISABLE KEYS */;
/*!40000 ALTER TABLE `transport_route` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transport_stoppage`
--

DROP TABLE IF EXISTS `transport_stoppage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transport_stoppage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stop_position` varchar(255) NOT NULL,
  `stop_time` time NOT NULL,
  `route_fare` decimal(18,2) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `transport_stoppage_rms_1` (`branch_id`),
  CONSTRAINT `transport_stoppage_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transport_stoppage`
--

LOCK TABLES `transport_stoppage` WRITE;
/*!40000 ALTER TABLE `transport_stoppage` DISABLE KEYS */;
/*!40000 ALTER TABLE `transport_stoppage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transport_stoppage_point`
--

DROP TABLE IF EXISTS `transport_stoppage_point`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transport_stoppage_point` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `route_id` int(11) NOT NULL,
  `stoppage_id` int(11) NOT NULL,
  `route_fare` decimal(18,2) DEFAULT NULL,
  `stop_time` time DEFAULT NULL,
  `order_no` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `transport_assign_rms_1` (`branch_id`),
  KEY `transport_stoppage_point_rms_1` (`route_id`),
  KEY `transport_stoppage_point_rms_3` (`session_id`),
  CONSTRAINT `transport_stoppage_point_rms_1` FOREIGN KEY (`route_id`) REFERENCES `transport_route` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `transport_stoppage_point_rms_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `transport_stoppage_point_rms_3` FOREIGN KEY (`session_id`) REFERENCES `schoolyear` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transport_stoppage_point`
--

LOCK TABLES `transport_stoppage_point` WRITE;
/*!40000 ALTER TABLE `transport_stoppage_point` DISABLE KEYS */;
/*!40000 ALTER TABLE `transport_stoppage_point` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transport_vehicle`
--

DROP TABLE IF EXISTS `transport_vehicle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transport_vehicle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_no` longtext NOT NULL,
  `capacity` longtext NOT NULL,
  `insurance_renewal` longtext NOT NULL,
  `driver_name` longtext NOT NULL,
  `driver_phone` longtext NOT NULL,
  `driver_license` longtext NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transport_vehicle_rms_1` (`branch_id`),
  CONSTRAINT `transport_vehicle_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transport_vehicle`
--

LOCK TABLES `transport_vehicle` WRITE;
/*!40000 ALTER TABLE `transport_vehicle` DISABLE KEYS */;
/*!40000 ALTER TABLE `transport_vehicle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visitor_log`
--

DROP TABLE IF EXISTS `visitor_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visitor_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `visitor_log_rms_1` (`branch_id`),
  CONSTRAINT `visitor_log_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visitor_log`
--

LOCK TABLES `visitor_log` WRITE;
/*!40000 ALTER TABLE `visitor_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `visitor_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visitor_purpose`
--

DROP TABLE IF EXISTS `visitor_purpose`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visitor_purpose` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `visitor_purpose_rms_1` (`branch_id`),
  CONSTRAINT `visitor_purpose_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visitor_purpose`
--

LOCK TABLES `visitor_purpose` WRITE;
/*!40000 ALTER TABLE `visitor_purpose` DISABLE KEYS */;
INSERT INTO `visitor_purpose` VALUES (1,'Seminer',1),(2,'Event',1),(3,'Sports',1),(4,'Government',1),(5,'General',1),(6,'To meet the child',1);
/*!40000 ALTER TABLE `visitor_purpose` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `voucher_head`
--

DROP TABLE IF EXISTS `voucher_head`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `voucher_head` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL,
  `system` tinyint(1) DEFAULT 0,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `voucher_head_rms_1` (`branch_id`),
  CONSTRAINT `voucher_head_rms_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voucher_head`
--

LOCK TABLES `voucher_head` WRITE;
/*!40000 ALTER TABLE `voucher_head` DISABLE KEYS */;
INSERT INTO `voucher_head` VALUES (1,'Salary payments','expense',0,1),(2,'Electricity bills','expense',0,1),(3,'Office Rent','income',0,1),(4,'Student Fees Collection','income',0,1);
/*!40000 ALTER TABLE `voucher_head` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `whatsapp_agent`
--

DROP TABLE IF EXISTS `whatsapp_agent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `whatsapp_agent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_name` varchar(255) NOT NULL,
  `agent_image` varchar(255) NOT NULL,
  `agent_designation` varchar(255) NOT NULL,
  `whataspp_number` varchar(255) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `weekend` varchar(20) DEFAULT NULL,
  `enable` tinyint(1) NOT NULL DEFAULT 1,
  `branch_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `whatsapp_agent`
--

LOCK TABLES `whatsapp_agent` WRITE;
/*!40000 ALTER TABLE `whatsapp_agent` DISABLE KEYS */;
/*!40000 ALTER TABLE `whatsapp_agent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `whatsapp_chat`
--

DROP TABLE IF EXISTS `whatsapp_chat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `whatsapp_chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `header_title` varchar(255) NOT NULL,
  `subtitle` varchar(355) DEFAULT NULL,
  `footer_text` varchar(255) DEFAULT NULL,
  `popup_message` varchar(255) DEFAULT NULL,
  `frontend_enable_chat` tinyint(1) NOT NULL DEFAULT 0,
  `backend_enable_chat` tinyint(1) NOT NULL DEFAULT 0,
  `branch_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `whatsapp_chat`
--

LOCK TABLES `whatsapp_chat` WRITE;
/*!40000 ALTER TABLE `whatsapp_chat` DISABLE KEYS */;
INSERT INTO `whatsapp_chat` VALUES (1,'Start a Conversation','Start a Conversation','Use this feature to chat with our agent.',NULL,0,0,1,'2026-02-18 13:49:13');
/*!40000 ALTER TABLE `whatsapp_chat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zoom_own_api`
--

DROP TABLE IF EXISTS `zoom_own_api`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zoom_own_api` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `zoom_api_key` varchar(255) NOT NULL,
  `zoom_api_secret` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zoom_own_api`
--

LOCK TABLES `zoom_own_api` WRITE;
/*!40000 ALTER TABLE `zoom_own_api` DISABLE KEYS */;
/*!40000 ALTER TABLE `zoom_own_api` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-14 18:05:31
