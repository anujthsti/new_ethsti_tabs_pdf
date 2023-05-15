-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2023 at 02:54 PM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `new_ethsti`
--

-- --------------------------------------------------------

--
-- Table structure for table `apply_job_hr_remarks`
--

CREATE TABLE `apply_job_hr_remarks` (
  `id` int(11) NOT NULL,
  `category` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `code` varchar(5) COLLATE utf8_bin DEFAULT NULL,
  `remarks_desc` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `apply_job_hr_remarks`
--

INSERT INTO `apply_job_hr_remarks` (`id`, `category`, `code`, `remarks_desc`, `status`) VALUES
(1, 'GENERAL', 'R1', 'Overaged', 1),
(2, 'GENERAL', 'R2', 'Not possessing essential / relevant qualification', 1),
(3, 'SPECIFIC', 'S1', 'PG diploma is of one year instead of two years', 1),
(4, 'SPECIFIC', 'S2', 'Less than 9 years of post qualification supervisory experience in the relevant functional area', 1),
(5, 'PROVISIONAL', 'P1', 'OBC certificate to be provided in the Govt. of India format and issued by an appropriate authority on or after 1.4.2019', 1),
(6, 'PROVISIONAL', 'P2', 'SC/ST/PwBD certificate to be provided in the Govt. of India format', 1),
(7, 'GENERAL', 'R3', 'Not possessing relevant experience', 1),
(8, 'GENERAL', 'R4', 'Not possessing required period of post qualification experience / less than required experience', 1),
(9, 'GENERAL', 'R5', 'Incomplete application/Relevant document not uploaded', 1),
(10, 'GENERAL', 'R6', 'The candidate does not belong to the category for which the vacancy is reserved', 1),
(11, 'GENERAL', 'R7', 'PwBD certificate not in the relevant format', 1),
(12, 'GENERAL', 'R8', 'Payment not received', 1),
(13, 'PROVISIONAL', 'P3', 'Experience certificate from all the employers to be provided duly indicating the period of employment in each grade/post within the same organisation', 1),
(14, 'PROVISIONAL', 'P4', 'Discharge certificate / NOC to be provided to obtain relaxation entitled for Ex-servicemen', 1),
(15, 'PROVISIONAL', 'P5', 'All the documents to be provided', 1),
(16, 'PROVISIONAL', 'P6', 'PG Diploma Certificate/other proof indicating that the duration of the diploma is of two years should be provided (one year diploma will not be considered as the essential qualification)', 1),
(17, 'PROVISIONAL', 'P7', 'Diploma certificate/other proof indicating that the duration of the diploma is of one year should be provided (diplomas of duration  less than one year will not be considered as essential qualification)', 1),
(18, 'PROVISIONAL', 'P8', 'Forwarding letter/NOC for deputation to be provided from the present employer', 1),
(19, 'PROVISIONAL', 'P9', 'Document from the Institution/University certifying that the PG Degree/Diploma is in Finance/Accounts', 1),
(20, 'GENERAL', 'R9', 'Duplicate application', 1),
(21, 'PROVISIONAL', 'P10', 'NOC from current employer to be provided', 1),
(22, 'SPECIFIC', 'S3', 'Not possessing requisite experience in the relevant grade for deputation', 1),
(23, 'PROVISIONAL', 'P11', 'Degree mark sheet showing that at least one of the subjects is related to CS/IT to be provided', 1),
(24, 'SPECIFIC', 'S4', 'Final year marksheet issued on or before 1st July 2020 to be provided ', 1),
(25, 'SPECIFIC', 'S5', 'Valid GATE/NET-LS/GPAT score card to be provided', 1),
(26, 'SPECIFIC', 'S6', 'Fellowship award letter to be provided', 1);

-- --------------------------------------------------------

--
-- Table structure for table `candidates_academics_details`
--

CREATE TABLE `candidates_academics_details` (
  `id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL COMMENT 'primary key of registered candidates',
  `job_id` int(11) NOT NULL,
  `candidate_job_apply_id` int(11) DEFAULT NULL COMMENT 'primary key of candidates_jobs_apply table',
  `education_id` int(11) DEFAULT NULL COMMENT 'Education master primary key from code_master',
  `month` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `duration_of_course` int(11) DEFAULT NULL COMMENT 'in years',
  `degree_or_subject` varchar(255) DEFAULT NULL COMMENT 'Will store degree or subjects name',
  `board_or_university` varchar(255) DEFAULT NULL,
  `percentage` decimal(10,0) DEFAULT NULL,
  `cgpa` varchar(255) DEFAULT NULL,
  `division` varchar(255) DEFAULT NULL,
  `phd_result` int(11) DEFAULT NULL COMMENT '1 for Degree Awarded,\r\n2 for Thesis Submitted',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 - active, \r\n2 - inactive, \r\n3 - delete',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `candidates_academics_details`
--

INSERT INTO `candidates_academics_details` (`id`, `candidate_id`, `job_id`, `candidate_job_apply_id`, `education_id`, `month`, `year`, `duration_of_course`, `degree_or_subject`, `board_or_university`, `percentage`, `cgpa`, `division`, `phd_result`, `status`, `created_at`, `updated_at`) VALUES
(3, 1, 2, 1, 15, 3, 2010, 1, 'yrgfyg', 'rftgr', '80', '8', 'I', NULL, 1, '2023-03-28 07:25:36', '2023-05-09 05:50:26'),
(4, 1, 2, 1, 16, 5, 2014, 3, 'drft', 'ertrt', '72', '9', 'I', NULL, 1, '2023-03-28 07:25:36', '2023-05-09 05:50:26'),
(5, 2, 2, 2, 15, 2, 2010, 2, 'jdhgj', 'hgdjhgj', '70', '7', 'I', NULL, 1, '2023-05-12 12:13:24', '2023-05-12 07:20:38'),
(6, 2, 2, 2, 16, 3, 2014, 2, 'jhgjd', 'dhgjdgh', '70', '8', 'I', NULL, 1, '2023-05-12 12:13:24', '2023-05-12 07:20:38'),
(7, 2, 2, 2, 18, 2, 2015, 2, 'dfds', 'sdas', NULL, NULL, 'I', 1, 1, '2023-05-12 12:13:24', '2023-05-12 07:20:38');

-- --------------------------------------------------------

--
-- Table structure for table `candidates_academics_documents`
--

CREATE TABLE `candidates_academics_documents` (
  `id` int(11) NOT NULL,
  `candidate_id` int(11) DEFAULT NULL,
  `job_id` int(11) DEFAULT NULL,
  `candidate_job_apply_id` int(11) DEFAULT NULL,
  `education_id` int(11) DEFAULT NULL,
  `folder_name` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 for active,\r\n2 for inactive,\r\n3 for delete',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `candidates_academics_documents`
--

INSERT INTO `candidates_academics_documents` (`id`, `candidate_id`, `job_id`, `candidate_job_apply_id`, `education_id`, `folder_name`, `file_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, 16, NULL, 'thsti-pay-slip.pdf', 1, '2023-04-06 00:33:17', '2023-04-06 00:46:52'),
(2, 1, 2, 1, 15, NULL, 'thsti-pay-slip.pdf', 1, '2023-04-06 00:46:52', '2023-04-06 00:46:52');

-- --------------------------------------------------------

--
-- Table structure for table `candidates_common_documents`
--

CREATE TABLE `candidates_common_documents` (
  `id` int(11) NOT NULL,
  `candidate_id` int(11) DEFAULT NULL,
  `job_id` int(11) DEFAULT NULL,
  `candidate_job_apply_id` int(11) DEFAULT NULL,
  `folder_name` varchar(255) DEFAULT NULL,
  `category_certificate` varchar(255) DEFAULT NULL,
  `esm_certificate` varchar(255) DEFAULT NULL,
  `pwd_certificate` varchar(255) DEFAULT NULL,
  `candidate_photo` varchar(255) DEFAULT NULL,
  `candidate_sign` varchar(255) DEFAULT NULL,
  `fellowship_certificate` varchar(255) DEFAULT NULL,
  `exam_qualified_certificate` varchar(255) DEFAULT NULL,
  `id_card` varchar(255) DEFAULT NULL,
  `age_proof` varchar(255) DEFAULT NULL,
  `noc_certificate` varchar(255) DEFAULT NULL,
  `stmt_proposal` varchar(255) DEFAULT NULL,
  `candidate_cv` varchar(255) DEFAULT NULL,
  `listpublication` varchar(255) DEFAULT NULL,
  `publication` varchar(255) DEFAULT NULL,
  `project_proposal` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 for active,\r\n2 for inactive,\r\n3 for delete',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `candidates_common_documents`
--

INSERT INTO `candidates_common_documents` (`id`, `candidate_id`, `job_id`, `candidate_job_apply_id`, `folder_name`, `category_certificate`, `esm_certificate`, `pwd_certificate`, `candidate_photo`, `candidate_sign`, `fellowship_certificate`, `exam_qualified_certificate`, `id_card`, `age_proof`, `noc_certificate`, `stmt_proposal`, `candidate_cv`, `listpublication`, `publication`, `project_proposal`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, NULL, NULL, NULL, NULL, 'sign (1).jpg', 'sign (1)-min.jpg', 'thsti-pay-slip.pdf', 'thsti-pay-slip.pdf', 'thsti-pay-slip.pdf', 'thsti-pay-slip.pdf', 'thsti-pay-slip.pdf', 'thsti-pay-slip.pdf', 'thsti-pay-slip.pdf', 'thsti-pay-slip.pdf', 'thsti-pay-slip.pdf', 'thsti-pay-slip.pdf', 1, '2023-04-06 00:33:17', '2023-04-06 00:46:52');

-- --------------------------------------------------------

--
-- Table structure for table `candidates_experience_details`
--

CREATE TABLE `candidates_experience_details` (
  `id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `candidate_job_apply_id` int(11) DEFAULT NULL COMMENT 'primary key of candidates_jobs_apply table',
  `organization_name` varchar(900) DEFAULT NULL,
  `nature_of_duties` text DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `from_date` timestamp NULL DEFAULT NULL,
  `to_date` timestamp NULL DEFAULT NULL,
  `total_experience` varchar(255) DEFAULT NULL,
  `pay_level` varchar(255) DEFAULT NULL,
  `gross_pay` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 for active,\r\n2 for inactive,\r\n3 for delete',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `candidates_experience_details`
--

INSERT INTO `candidates_experience_details` (`id`, `candidate_id`, `job_id`, `candidate_job_apply_id`, `organization_name`, `nature_of_duties`, `designation`, `from_date`, `to_date`, `total_experience`, `pay_level`, `gross_pay`, `status`, `created_at`, `updated_at`) VALUES
(2, 1, 2, 1, 'Digitech Software Solutions', 'php development, websites development', 'Programmer', '2016-02-01 18:30:00', '2019-03-06 18:30:00', '03 Year, 01 Months, 5 Days', '3', '20000', 1, '2023-03-29 06:42:47', '2023-05-09 05:50:26'),
(3, 1, 2, 1, 'Teq Mavens', 'cakephp development, websites development', 'Sr. Developer', '2019-03-09 18:30:00', '2023-03-28 18:30:00', '04 Year, 00 Months, 19 Days', '5', '30000', 1, '2023-03-29 08:29:59', '2023-05-09 05:50:26');

-- --------------------------------------------------------

--
-- Table structure for table `candidates_experience_documents`
--

CREATE TABLE `candidates_experience_documents` (
  `id` int(11) NOT NULL,
  `candidate_id` int(11) DEFAULT NULL,
  `job_id` int(11) DEFAULT NULL,
  `candidate_job_apply_id` int(11) DEFAULT NULL,
  `candidate_experience_detail_id` int(11) DEFAULT NULL COMMENT 'primary key of candidates_experience_details table',
  `folder_name` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 for active,\r\n2 for inactive,\r\n3 for delete',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `candidates_experience_documents`
--

INSERT INTO `candidates_experience_documents` (`id`, `candidate_id`, `job_id`, `candidate_job_apply_id`, `candidate_experience_detail_id`, `folder_name`, `file_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, 3, NULL, 'thsti-pay-slip.pdf', 1, '2023-04-06 00:33:17', '2023-04-06 00:46:52'),
(2, 1, 2, 1, 2, NULL, 'thsti-pay-slip.pdf', 1, '2023-04-06 00:46:52', '2023-04-06 00:46:52');

-- --------------------------------------------------------

--
-- Table structure for table `candidates_jobs_apply`
--

CREATE TABLE `candidates_jobs_apply` (
  `id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL COMMENT 'primary key of register_candidates',
  `rn_no_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `domain_id` int(11) DEFAULT NULL,
  `appointment_method_id` int(11) DEFAULT NULL,
  `is_ex_serviceman` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 for yes,\r\n0 for No',
  `is_esm_reservation_avail` int(11) DEFAULT NULL COMMENT '1 for Yes,\r\n0 for No',
  `is_govt_servent` int(11) DEFAULT NULL COMMENT '1 for yes,\r\n0 for No',
  `type_of_employment` int(11) DEFAULT NULL COMMENT '1 for Permanent,\r\n2 for Temporary',
  `type_of_employer` int(11) DEFAULT NULL COMMENT 'type_of_employer id from masters',
  `is_pwd` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 for yes,\r\n0 for No',
  `category_id` int(11) DEFAULT NULL COMMENT 'caste_category from code_names master',
  `marital_status` int(11) DEFAULT NULL COMMENT '1 - Single,\r\n2 - Married,\r\n3 - Divorced',
  `application_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 for pending,\r\n1 for completed,\r\n2 for ---',
  `trainee_category_id` int(11) DEFAULT NULL COMMENT 'trainee_category from codes master',
  `institute_name` varchar(255) DEFAULT NULL,
  `is_experience` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 for Yes,\r\n0 for No',
  `total_experience` varchar(255) DEFAULT NULL,
  `age_calculated` varchar(255) DEFAULT NULL,
  `is_publication` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 for Yes,\r\n0 for No',
  `relative_name` varchar(255) DEFAULT NULL COMMENT 'relative or friend in thsti',
  `relative_designation` varchar(255) DEFAULT NULL,
  `relative_relationship` varchar(255) DEFAULT NULL COMMENT '1 for Yes,\r\n0 for No',
  `data_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 for pending,\r\n1 for completed',
  `file_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 for pending,\r\n1 for completed',
  `payment_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 for pending,\r\n1 for success,\r\n2 for Failed',
  `is_completed` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 for No,\r\n1 for Yes',
  `is_screened` int(11) DEFAULT 0 COMMENT ' 0 for No,\r\n1 for Yes',
  `shortlisting_status` int(11) DEFAULT NULL COMMENT '1 - shortlisted,\r\n2 - rejected,\r\n3 - provisional shortlisted',
  `hr_additional_remarks` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 for active,\r\n2 for inactive,\r\n3 for delete',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `candidates_jobs_apply`
--

INSERT INTO `candidates_jobs_apply` (`id`, `candidate_id`, `rn_no_id`, `job_id`, `domain_id`, `appointment_method_id`, `is_ex_serviceman`, `is_esm_reservation_avail`, `is_govt_servent`, `type_of_employment`, `type_of_employer`, `is_pwd`, `category_id`, `marital_status`, `application_status`, `trainee_category_id`, `institute_name`, `is_experience`, `total_experience`, `age_calculated`, `is_publication`, `relative_name`, `relative_designation`, `relative_relationship`, `data_status`, `file_status`, `payment_status`, `is_completed`, `is_screened`, `shortlisting_status`, `hr_additional_remarks`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 10, 2, 29, 31, 1, 0, 1, 1, 118, 1, 37, 2, 0, NULL, NULL, 1, '7 YEARS,1 MONTHS,24 DAYS', '31 Year, 00 Months, 8 Days', 1, 'Satyam Kumar', 'Programmer', 'Friend', 1, 1, 1, 1, 1, 3, 'Candidate provisional shortlisted', 1, '2023-03-14 04:55:38', '2023-05-10 09:41:09'),
(2, 2, 10, 2, 29, 31, 0, 0, 0, NULL, NULL, 0, 37, 1, 0, NULL, NULL, 0, NULL, '00 Year, 02 Months, 0 Days', 0, NULL, NULL, NULL, 1, 0, 0, 0, 0, NULL, NULL, 1, '2023-05-12 01:14:56', '2023-05-12 07:20:38');

-- --------------------------------------------------------

--
-- Table structure for table `candidates_job_hr_remarks`
--

CREATE TABLE `candidates_job_hr_remarks` (
  `id` int(11) NOT NULL,
  `candidate_job_apply_id` int(11) NOT NULL,
  `remarks_code_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 for active,\r\n0 for inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `candidates_job_hr_remarks`
--

INSERT INTO `candidates_job_hr_remarks` (`id`, `candidate_job_apply_id`, `remarks_code_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, '2023-05-04 10:50:43', '2023-05-04 10:50:43'),
(2, 1, 7, 1, '2023-05-04 10:50:43', '2023-05-04 10:50:43'),
(3, 1, 8, 1, '2023-05-04 10:50:43', '2023-05-04 10:50:43');

-- --------------------------------------------------------

--
-- Table structure for table `candidates_phd_research_details`
--

CREATE TABLE `candidates_phd_research_details` (
  `id` int(11) NOT NULL,
  `candidate_id` int(11) DEFAULT NULL,
  `job_id` int(11) DEFAULT NULL,
  `candidate_job_apply_id` int(11) DEFAULT NULL,
  `patent_information` text DEFAULT NULL,
  `is_have_patents` int(11) NOT NULL DEFAULT 0 COMMENT '1 for Yes,\r\n0 for No',
  `research_statement` text DEFAULT NULL,
  `is_submitted_research_statement` int(11) NOT NULL DEFAULT 0 COMMENT '1 for Yes,\r\n0 for No',
  `funding_agency` varchar(255) DEFAULT NULL,
  `rank` varchar(255) DEFAULT NULL,
  `admission_test` varchar(255) DEFAULT NULL,
  `fellowship_valid_up_to` date DEFAULT NULL,
  `is_fellowship_activated` int(11) DEFAULT 0 COMMENT '1 for Yes,\r\n0 for No',
  `active_institute_name` varchar(900) DEFAULT NULL,
  `activation_date` date DEFAULT NULL,
  `is_exam_qualified` int(11) DEFAULT 0 COMMENT '1 for Yes,\r\n0 for No',
  `exam_name` text DEFAULT NULL,
  `exam_score` varchar(255) DEFAULT NULL,
  `exam_qualified_val_up_to` date DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 for active,\r\n2 for inactive,\r\n3 for delete',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `candidates_phd_research_details`
--

INSERT INTO `candidates_phd_research_details` (`id`, `candidate_id`, `job_id`, `candidate_job_apply_id`, `patent_information`, `is_have_patents`, `research_statement`, `is_submitted_research_statement`, `funding_agency`, `rank`, `admission_test`, `fellowship_valid_up_to`, `is_fellowship_activated`, `active_institute_name`, `activation_date`, `is_exam_qualified`, `exam_name`, `exam_score`, `exam_qualified_val_up_to`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, 'Patents Text', 1, 'Research Statement Text Box', 1, 'THSTI', '2nd', 'THSTI Test', '2023-05-11', 0, NULL, NULL, 1, 'THSTI Exam', '850', '2024-07-18', 1, '2023-04-03 01:09:11', '2023-04-03 01:09:11'),
(2, 1, 2, 1, 'Patents Text', 1, 'Research Statement Text Box', 1, 'THSTI', '2nd', 'THSTI Test', '2023-05-11', 0, NULL, NULL, 1, 'THSTI Exam', '850', '2024-07-18', 1, '2023-04-03 01:18:26', '2023-04-03 01:18:26'),
(3, 1, 2, 1, 'Patents Text', 1, 'Research Statement Text Box', 1, 'THSTI', '2nd', 'THSTI Test', '2023-05-11', 0, NULL, NULL, 1, 'THSTI Exam', '850', '2024-07-18', 1, '2023-04-24 06:41:41', '2023-04-24 06:41:41'),
(4, 1, 2, 1, 'Patents Text', 1, 'Research Statement Text Box', 1, 'THSTI', '2nd', 'THSTI Test', '2023-05-11', 0, NULL, NULL, 1, 'THSTI Exam', '850', '2024-07-18', 1, '2023-04-25 01:38:42', '2023-04-25 01:38:42'),
(5, 1, 2, 1, 'Patents Text', 1, 'Research Statement Text Box', 1, 'THSTI', '2nd', 'THSTI Test', '2023-05-11', 0, NULL, NULL, 1, 'THSTI Exam', '850', '2024-07-18', 1, '2023-04-25 01:42:16', '2023-04-25 01:42:16'),
(6, 1, 2, 1, 'Patents Text', 1, 'Research Statement Text Box', 1, 'THSTI', '2nd', 'THSTI Test', '2023-05-11', 0, NULL, NULL, 1, 'THSTI Exam', '850', '2024-07-18', 1, '2023-04-25 23:33:37', '2023-04-25 23:33:37'),
(7, 1, 2, 1, 'Patents Text', 1, 'Research Statement Text Box', 1, 'THSTI', '2nd', 'THSTI Test', '2023-05-11', 0, NULL, NULL, 1, 'THSTI Exam', '850', '2024-07-18', 1, '2023-04-26 00:23:42', '2023-04-26 00:23:42'),
(8, 1, 2, 1, 'Patents Text', 1, 'Research Statement Text Box', 1, 'THSTI', '2nd', 'THSTI Test', '2023-05-11', 0, NULL, NULL, 1, 'THSTI Exam', '850', '2024-07-18', 1, '2023-04-26 00:24:55', '2023-04-26 00:24:55'),
(9, 1, 2, 1, 'Patents Text', 1, 'Research Statement Text Box', 1, 'THSTI', '2nd', 'THSTI Test', '2023-05-11', 0, NULL, NULL, 1, 'THSTI Exam', '850', '2024-07-18', 1, '2023-04-26 00:25:55', '2023-04-26 00:25:55'),
(10, 1, 2, 1, 'Patents Text', 1, 'Research Statement Text Box', 1, 'THSTI', '2nd', 'THSTI Test', '2023-05-11', 0, NULL, NULL, 1, 'THSTI Exam', '850', '2024-07-18', 1, '2023-04-26 00:26:31', '2023-04-26 00:26:31'),
(11, 1, 2, 1, 'Patents Text', 1, 'Research Statement Text Box', 1, 'THSTI', '2nd', 'THSTI Test', '2023-05-11', 0, NULL, NULL, 1, 'THSTI Exam', '850', '2024-07-18', 1, '2023-04-26 00:26:49', '2023-04-26 00:26:49'),
(12, 1, 2, 1, 'Patents Text', 1, 'Research Statement Text Box', 1, 'THSTI', '2nd', 'THSTI Test', '2023-05-11', 0, NULL, NULL, 1, 'THSTI Exam', '850', '2024-07-18', 1, '2023-04-26 00:27:09', '2023-04-26 00:27:09'),
(13, 1, 2, 1, 'Patents Text', 1, 'Research Statement Text Box', 1, 'THSTI', '2nd', 'THSTI Test', '2023-05-11', 0, NULL, NULL, 1, 'THSTI Exam', '850', '2024-07-18', 1, '2023-04-26 01:28:07', '2023-04-26 01:28:07'),
(14, 1, 2, 1, 'Patents Text', 1, 'Research Statement Text Box', 1, 'THSTI', '2nd', 'THSTI Test', '2023-05-11', 0, NULL, NULL, 1, 'THSTI Exam', '850', '2024-07-18', 1, '2023-04-26 03:15:43', '2023-04-26 03:15:43'),
(15, 1, 2, 1, 'Patents Text', 1, 'Research Statement Text Box', 1, 'THSTI', '2nd', 'THSTI Test', '2023-05-11', 0, NULL, NULL, 1, 'THSTI Exam', '850', '2024-07-18', 1, '2023-04-26 03:16:39', '2023-04-26 03:16:39'),
(16, 1, 2, 1, 'Patents Text', 1, 'Research Statement Text Box', 1, 'THSTI', '2nd', 'THSTI Test', '2023-05-11', 0, NULL, NULL, 1, 'THSTI Exam', '850', '2024-07-18', 1, '2023-04-26 03:17:03', '2023-04-26 03:17:03'),
(17, 1, 2, 1, 'Patents Text', 1, 'Research Statement Text Box', 1, 'THSTI', '2nd', 'THSTI Test', '2023-05-11', 0, NULL, NULL, 1, 'THSTI Exam', '850', '2024-07-18', 1, '2023-04-26 03:17:46', '2023-04-26 03:17:46'),
(18, 1, 2, 1, 'Patents Text', 1, 'Research Statement Text Box', 1, 'THSTI', '2nd', 'THSTI Test', '2023-05-11', 0, NULL, NULL, 1, 'THSTI Exam', '850', '2024-07-18', 1, '2023-04-26 04:43:53', '2023-04-26 04:43:53'),
(19, 1, 2, 1, 'Patents Text', 1, 'Research Statement Text Box', 1, 'THSTI', '2nd', 'THSTI Test', '2023-05-11', 0, NULL, NULL, 1, 'THSTI Exam', '850', '2024-07-18', 1, '2023-04-26 04:44:27', '2023-04-26 04:44:27'),
(20, 1, 2, 1, 'Patents Text', 1, 'Research Statement Text Box', 1, 'THSTI', '2nd', 'THSTI Test', '2023-05-11', 0, NULL, NULL, 1, 'THSTI Exam', '850', '2024-07-18', 1, '2023-04-28 06:30:25', '2023-04-28 06:30:25'),
(21, 1, 2, 1, 'Patents Text', 1, 'Research Statement Text Box', 1, 'THSTI', '2nd', 'THSTI Test', '2023-05-11', 0, NULL, NULL, 1, 'THSTI Exam', '850', '2024-07-18', 1, '2023-04-28 06:38:43', '2023-04-28 06:38:43'),
(22, 1, 2, 1, 'Patents Text', 1, 'Research Statement Text Box', 1, 'THSTI', '2nd', 'THSTI Test', '2023-05-11', 0, NULL, NULL, 1, 'THSTI Exam', '850', '2024-07-18', 1, '2023-04-28 06:39:39', '2023-04-28 06:39:39'),
(23, 1, 2, 1, 'Patents Text', 1, 'Research Statement Text Box', 1, 'THSTI', '2nd', 'THSTI Test', '2023-05-11', 0, NULL, NULL, 1, 'THSTI Exam', '850', '2024-07-18', 1, '2023-05-09 05:50:26', '2023-05-09 05:50:26'),
(24, 2, 2, 2, NULL, 0, NULL, 0, 'DBT', '1', 'Admission Test', '2023-05-02', 0, NULL, NULL, 0, NULL, NULL, NULL, 1, '2023-05-12 06:43:24', '2023-05-12 06:43:24'),
(25, 2, 2, 2, NULL, 0, NULL, 0, 'DBT', '1', 'Admission Test', '2023-05-02', 0, NULL, NULL, 0, NULL, NULL, NULL, 1, '2023-05-12 06:51:12', '2023-05-12 06:51:12'),
(26, 2, 2, 2, NULL, 0, NULL, 0, 'DBT', '1', 'Admission Test', '2023-05-02', 0, NULL, NULL, 0, NULL, NULL, NULL, 1, '2023-05-12 06:52:30', '2023-05-12 06:52:30'),
(27, 2, 2, 2, NULL, 0, NULL, 0, 'DBT', '1', 'Admission Test', '2023-05-02', 0, NULL, NULL, 0, NULL, NULL, NULL, 1, '2023-05-12 07:20:38', '2023-05-12 07:20:38');

-- --------------------------------------------------------

--
-- Table structure for table `candidates_publications_details`
--

CREATE TABLE `candidates_publications_details` (
  `id` int(11) NOT NULL,
  `candidate_id` int(11) DEFAULT NULL,
  `job_id` int(11) DEFAULT NULL,
  `candidate_job_apply_id` int(11) DEFAULT NULL,
  `publication_number` int(11) DEFAULT NULL,
  `authors` text DEFAULT NULL,
  `article_title` text DEFAULT NULL,
  `journal_name` text DEFAULT NULL,
  `year_volume` text NOT NULL,
  `doi` text NOT NULL,
  `pubmed_pmid` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 for active,\r\n2 for inactive,\r\n3 for delete',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `candidates_publications_details`
--

INSERT INTO `candidates_publications_details` (`id`, `candidate_id`, `job_id`, `candidate_job_apply_id`, `publication_number`, `authors`, `article_title`, `journal_name`, `year_volume`, `doi`, `pubmed_pmid`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, 1, 'Author 1', 'Article 1', 'Journal 1', '2010', 'asd-2012', '120-5210', 1, '2023-03-29 10:17:55', '2023-05-09 05:50:26'),
(2, 1, 2, 1, 2, 'Author 2', 'Article 2', 'Journal 2', '2012', 'dfre-2014', '456-7895', 1, '2023-03-29 10:17:55', '2023-05-09 05:50:26');

-- --------------------------------------------------------

--
-- Table structure for table `candidates_refree_details`
--

CREATE TABLE `candidates_refree_details` (
  `id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `candidate_job_apply_id` int(11) NOT NULL,
  `refree_name` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `organisation` varchar(500) DEFAULT NULL,
  `email_id` varchar(255) DEFAULT NULL,
  `phone_no` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 for active,\r\n2 for inactive,\r\n3 for delete',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `candidates_refree_details`
--

INSERT INTO `candidates_refree_details` (`id`, `candidate_id`, `job_id`, `candidate_job_apply_id`, `refree_name`, `designation`, `organisation`, `email_id`, `phone_no`, `mobile_no`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, 'Anoop', 'MD', 'AMAZL', 'anoop@amazl.in', '9898989898', '9898989898', 1, '2023-03-29 12:33:35', '2023-05-09 05:50:26'),
(2, 1, 2, 1, 'Subhanshu', 'Developer', 'AMAZL', 'sdfd@gmail.com', '8989898989', '8989898989', 1, '2023-03-29 12:33:35', '2023-05-09 05:50:26'),
(3, 2, 2, 2, 'dhgjhg', 'hdgj', 'THSTI', 'sdfd@gmail.com', '8989898989', '8989898989', 1, '2023-05-12 12:13:24', '2023-05-12 07:20:38');

-- --------------------------------------------------------

--
-- Table structure for table `code_master`
--

CREATE TABLE `code_master` (
  `id` int(11) NOT NULL,
  `code_name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `code_master`
--

INSERT INTO `code_master` (`id`, `code_name`, `code`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Job Types', 'job_types', 1, '2023-02-07 06:38:22', '2023-02-09 04:49:17'),
(3, 'Payment Modes', 'payment_modes', 1, '2023-02-08 06:23:26', '2023-02-09 04:49:26'),
(4, 'Centers', 'centers', 1, '2023-02-08 06:24:10', '2023-02-09 04:49:36'),
(5, 'Age Categories', 'age_category', 1, '2023-02-13 04:37:23', '2023-02-13 10:16:55'),
(6, 'Education', 'education', 1, '2023-02-13 06:20:25', '2023-02-13 11:50:49'),
(7, 'Fee Categories', 'fee_categories', 1, '2023-02-13 23:12:02', '2023-02-15 23:31:47'),
(9, 'Domain Area', 'domain_area', 1, '2023-03-02 04:17:34', '2023-03-02 04:17:34'),
(10, 'Method of Appointment', 'method_of_appointment', 1, '2023-03-02 23:16:12', '2023-03-02 23:16:12'),
(11, 'Salutation', 'salutation', 1, '2023-03-03 00:28:23', '2023-03-03 00:28:23'),
(12, 'Caste Categories', 'cast_categories', 1, '2023-03-05 23:33:46', '2023-04-11 05:43:30'),
(13, 'Trainee Category', 'trainee_category', 1, '2023-03-06 00:16:35', '2023-03-06 00:16:35'),
(14, 'States', 'states', 1, '2023-03-06 01:22:39', '2023-03-06 01:22:39'),
(15, 'Post Master', 'post_master', 1, '2023-03-06 05:58:26', '2023-03-06 05:58:26'),
(16, 'RN No. Type', 'rn_no_type', 1, '2023-03-09 01:37:49', '2023-03-09 01:37:55'),
(17, 'Gender', 'gender', 1, '2023-03-10 04:44:20', '2023-03-10 04:44:20'),
(18, 'THS RN Types', 'ths_rn_types', 1, '2023-03-26 23:38:40', '2023-03-26 23:38:40'),
(19, 'Type of employer', 'type_of_employer', 1, '2023-04-26 03:50:12', '2023-04-26 03:50:12');

-- --------------------------------------------------------

--
-- Table structure for table `code_names`
--

CREATE TABLE `code_names` (
  `id` int(11) NOT NULL,
  `code_id` int(11) NOT NULL,
  `code_meta_name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `code_names`
--

INSERT INTO `code_names` (`id`, `code_id`, `code_meta_name`, `code`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Online', 'online', 1, '2023-02-08 06:50:50', '2023-02-15 23:34:36'),
(2, 1, 'Offline', 'offline', 1, '2023-02-08 06:50:50', '2023-02-13 06:59:35'),
(4, 4, 'THSTI', 'thsti', 1, '2023-02-09 03:47:00', '2023-02-13 06:59:47'),
(5, 4, 'PBC', 'pbc', 1, '2023-02-09 03:47:49', '2023-02-13 06:59:50'),
(6, 3, 'Online', 'online', 1, '2023-02-09 22:38:05', '2023-02-13 06:59:42'),
(7, 3, 'Offline', 'offline', 1, '2023-02-09 22:38:13', '2023-02-13 06:59:44'),
(8, 5, 'GEN', 'gen', 1, '2023-02-13 04:47:55', '2023-02-13 06:59:52'),
(9, 5, 'OBC', 'obc', 1, '2023-02-13 04:48:04', '2023-02-13 06:59:21'),
(10, 5, 'SC', 'sc', 1, '2023-02-13 04:48:16', '2023-02-13 06:59:59'),
(11, 5, 'ST', 'st', 1, '2023-02-13 04:48:23', '2023-02-13 07:00:01'),
(12, 5, 'PWD', 'pwd', 1, '2023-02-13 04:48:43', '2023-02-13 07:00:06'),
(13, 5, 'EWS', 'ews', 1, '2023-02-13 04:48:50', '2023-02-13 07:00:12'),
(14, 6, 'CLASS X', 'class_x', 1, '2023-02-13 06:24:24', '2023-02-13 07:00:16'),
(15, 6, 'CLASS XII', 'class_xii', 1, '2023-02-13 06:24:40', '2023-02-13 07:00:20'),
(16, 6, 'GRADUATION', 'graduation', 1, '2023-02-13 06:24:52', '2023-02-13 07:00:23'),
(17, 6, 'POST-GRADUATION', 'post_graduation', 1, '2023-02-13 06:25:03', '2023-02-13 12:31:45'),
(18, 6, 'PHD/MD/EQUIVLENT', 'phd_md_equivlent', 1, '2023-02-13 06:25:17', '2023-02-13 12:31:54'),
(19, 7, 'Fee for UR', 'fee_for_ur', 1, '2023-02-13 23:12:39', '2023-02-13 23:12:39'),
(20, 7, 'Fee for EWS', 'fee_for_ews', 1, '2023-02-13 23:12:54', '2023-02-13 23:12:54'),
(21, 7, 'Fee for OBC', 'fee_for_obc', 1, '2023-02-13 23:13:07', '2023-02-13 23:13:07'),
(22, 7, 'Fee for Women', 'fee_for_women', 1, '2023-02-13 23:13:33', '2023-02-13 23:13:33'),
(23, 7, 'Fee for SC/ST', 'fee_for_scst', 1, '2023-02-13 23:13:46', '2023-02-14 04:45:07'),
(24, 7, 'Fee for PwBD', 'fee_for_pwbd', 1, '2023-02-13 23:13:57', '2023-02-13 23:13:57'),
(25, 7, 'Fee for Govt', 'fee_for_govt', 1, '2023-02-13 23:14:08', '2023-02-13 23:14:08'),
(26, 7, 'Fee for Non-Govt', 'fee_for_non_govt', 1, '2023-02-13 23:14:19', '2023-02-14 04:45:20'),
(27, 7, 'Fee for ESIC', 'fee_for_esic', 1, '2023-02-13 23:14:32', '2023-02-13 23:14:32'),
(28, 1, 'TRAIN Program', 'train_program', 1, '2023-03-01 22:50:25', '2023-03-01 22:50:25'),
(29, 9, 'IT', 'it', 1, '2023-03-02 04:23:47', '2023-03-02 04:23:47'),
(30, 9, 'Civil', 'civil', 1, '2023-03-02 04:24:05', '2023-03-02 04:24:05'),
(31, 10, 'DIRECT RECRUITMENT', 'direct_recruitment', 1, '2023-03-02 23:16:32', '2023-03-02 23:16:32'),
(32, 10, 'DEPUTATION', 'deputation', 1, '2023-03-02 23:16:45', '2023-03-02 23:16:45'),
(33, 11, 'PROF', 'prof', 1, '2023-03-03 00:28:38', '2023-03-03 00:28:38'),
(34, 11, 'DR', 'dr', 1, '2023-03-03 00:28:49', '2023-03-03 00:28:49'),
(35, 11, 'MR', 'mr', 1, '2023-03-03 00:28:59', '2023-03-03 00:28:59'),
(36, 11, 'MS', 'ms', 1, '2023-03-03 00:29:09', '2023-03-03 00:29:09'),
(37, 12, 'GEN', 'gen', 1, '2023-03-05 23:34:08', '2023-03-05 23:34:08'),
(38, 12, 'SC', 'sc', 1, '2023-03-05 23:34:19', '2023-03-05 23:34:19'),
(39, 12, 'ST', 'st', 1, '2023-03-05 23:34:28', '2023-03-05 23:34:28'),
(40, 12, 'OBC', 'obc', 1, '2023-03-05 23:34:51', '2023-03-05 23:34:51'),
(41, 12, 'EWS', 'ews', 1, '2023-03-05 23:35:06', '2023-03-05 23:35:06'),
(42, 1, 'Faculty/ Scientists', 'faculty_scientists', 1, '2023-03-05 23:54:30', '2023-03-06 05:24:55'),
(43, 1, 'Administration & Technical', 'administration_&_technical', 1, '2023-03-05 23:55:22', '2023-03-05 23:55:22'),
(44, 1, 'PhD Students', 'phd_students', 1, '2023-03-05 23:55:37', '2023-03-05 23:55:37'),
(45, 1, 'JRF/SRF', 'jrf_srf', 1, '2023-03-05 23:55:59', '2023-03-05 23:56:06'),
(46, 1, 'none', 'none', 1, '2023-03-05 23:56:44', '2023-03-05 23:56:44'),
(47, 1, 'Rolling Advt', 'rolling_advt', 1, '2023-03-05 23:56:57', '2023-03-05 23:56:57'),
(48, 1, 'Siip-fellowships', 'siip_fellowships', 1, '2023-03-05 23:57:15', '2023-03-05 23:57:25'),
(49, 1, 'Rolling-JRF', 'rolling-jrf', 1, '2023-03-05 23:57:40', '2023-03-05 23:57:40'),
(50, 1, 'Rolling-RA', 'rolling-ra', 1, '2023-03-05 23:58:00', '2023-03-05 23:58:00'),
(51, 1, 'Rolling-SRF', 'rolling-srf', 1, '2023-03-05 23:58:13', '2023-03-05 23:58:13'),
(52, 1, 'SRF', 'srf', 1, '2023-03-05 23:58:24', '2023-03-05 23:58:24'),
(53, 1, 'Scientists', 'scientists', 1, '2023-03-05 23:58:38', '2023-03-05 23:58:38'),
(54, 1, 'Rolling online', 'rolling_online', 1, '2023-03-05 23:58:49', '2023-03-05 23:58:49'),
(55, 1, 'JRF', 'jrf', 1, '2023-03-05 23:59:01', '2023-03-05 23:59:01'),
(56, 13, 'Govt', 'govt', 1, '2023-03-06 00:16:57', '2023-03-06 00:16:57'),
(57, 13, 'Non Govt', 'non_govt', 1, '2023-03-06 00:17:06', '2023-03-06 00:17:06'),
(58, 13, 'ESIC', 'esic', 1, '2023-03-06 00:17:15', '2023-03-06 00:17:15'),
(59, 14, 'ANDAMAN AND NICOBAR ISLANDS', 'andaman_and_nicobar_islands', 1, '2023-03-06 01:22:52', '2023-03-06 01:22:52'),
(60, 14, 'ANDHRA PRADESH', 'andhra_pradesh', 1, '2023-03-06 01:23:03', '2023-03-06 01:23:03'),
(61, 14, 'ARUNACHAL PRADESH', 'arunachal_pradesh', 1, '2023-03-06 01:23:15', '2023-03-06 01:23:15'),
(62, 14, 'ASSAM', 'assam', 1, '2023-03-06 01:23:26', '2023-03-06 01:23:26'),
(63, 14, 'BIHAR', 'bihar', 1, '2023-03-06 01:23:36', '2023-03-06 01:23:36'),
(64, 14, 'CHATTISGARH', 'chattisgarh', 1, '2023-03-06 01:23:48', '2023-03-06 01:23:48'),
(65, 14, 'CHANDIGARH', 'chandigarh', 1, '2023-03-06 01:23:59', '2023-03-06 01:23:59'),
(66, 14, 'DAMAN AND DIU', 'daman_and_diu', 1, '2023-03-06 01:24:08', '2023-03-06 01:24:08'),
(67, 14, 'DELHI', 'delhi', 1, '2023-03-06 01:24:18', '2023-03-06 01:24:18'),
(68, 14, 'DADRA AND NAGAR HAVELI', 'dadra_and_nagar_haveli', 1, '2023-03-06 01:24:29', '2023-03-06 01:24:29'),
(69, 14, 'GOA', 'goa', 1, '2023-03-06 01:24:39', '2023-03-06 01:24:39'),
(70, 14, 'GUJARAT', 'gujarat', 1, '2023-03-06 01:24:48', '2023-03-06 01:24:48'),
(71, 14, 'HIMACHAL PRADESH', 'himachal_pradesh', 1, '2023-03-06 01:25:00', '2023-03-06 01:25:00'),
(72, 14, 'HARYANA', 'haryana', 1, '2023-03-06 01:25:10', '2023-03-06 01:25:10'),
(73, 14, 'JAMMU AND KASHMIR', 'jammu_and_kashmir', 1, '2023-03-06 01:25:21', '2023-03-06 01:25:21'),
(74, 14, 'JHARKHAND', 'jharkhand', 1, '2023-03-06 01:25:31', '2023-03-06 01:25:31'),
(75, 14, 'KERALA', 'kerala', 1, '2023-03-06 01:25:42', '2023-03-06 01:25:42'),
(76, 14, 'KARNATAKA', 'karnataka', 1, '2023-03-06 01:25:52', '2023-03-06 01:25:52'),
(77, 14, 'LAKSHADWEEP', 'lakshadweep', 1, '2023-03-06 01:26:05', '2023-03-06 01:26:05'),
(78, 14, 'MEGHALAYA', 'meghalaya', 1, '2023-03-06 01:26:14', '2023-03-06 01:26:14'),
(79, 14, 'MAHARASHTRA', 'maharashtra', 1, '2023-03-06 01:26:24', '2023-03-06 01:26:24'),
(80, 14, 'MANIPUR', 'manipur', 1, '2023-03-06 01:26:34', '2023-03-06 01:26:34'),
(81, 14, 'MADHYA PRADESH', 'madhya_pradesh', 1, '2023-03-06 01:26:44', '2023-03-06 01:26:44'),
(82, 14, 'MIZORAM', 'mizoram', 1, '2023-03-06 01:26:53', '2023-03-06 01:26:53'),
(83, 14, 'NAGALAND', 'nagaland', 1, '2023-03-06 01:27:04', '2023-03-06 01:27:04'),
(84, 15, 'Executive Director', 'executive_director', 1, '2023-03-06 06:01:26', '2023-03-06 06:01:26'),
(85, 15, 'Dean', 'dean', 1, '2023-03-06 06:01:59', '2023-03-06 06:01:59'),
(86, 15, 'Sr. Professor', 'sr_professor', 1, '2023-03-06 06:02:31', '2023-03-06 11:32:46'),
(87, 15, 'Professor (with NPA)', 'professor_with_npa', 1, '2023-03-06 06:03:13', '2023-03-06 06:03:26'),
(88, 15, 'Professor', 'professor', 1, '2023-03-06 06:03:47', '2023-03-06 06:03:47'),
(89, 15, 'Associate Professor', 'associate_professor', 1, '2023-03-06 06:04:08', '2023-03-06 06:04:08'),
(90, 15, 'Assistant Professor', 'assistant_professor', 1, '2023-03-06 06:04:26', '2023-03-06 06:04:26'),
(91, 15, 'Professional Expert', 'professional_expert', 1, '2023-03-06 06:04:56', '2023-03-06 06:04:56'),
(92, 15, 'Institute Engineer', 'institute_engineer', 1, '2023-03-06 06:06:09', '2023-03-06 06:06:09'),
(93, 15, 'Instrumentation Engineer', 'instrumentation_engineer', 1, '2023-03-06 06:06:39', '2023-03-06 06:06:39'),
(94, 15, 'Senior Technical Officer', 'senior_technical_officer', 1, '2023-03-06 06:07:00', '2023-03-06 06:07:00'),
(95, 15, 'Technical Officer II', 'technical_officer_ii', 1, '2023-03-06 06:07:33', '2023-03-06 06:07:33'),
(96, 15, 'Technical Officer I', 'technical_officer_i', 1, '2023-03-06 06:07:44', '2023-03-06 06:07:44'),
(97, 15, 'Technical Assistant', 'technical_assistant', 1, '2023-03-06 06:07:59', '2023-03-06 06:07:59'),
(98, 15, 'Lab Technician', 'lab_technician', 1, '2023-03-06 06:08:15', '2023-03-06 06:08:15'),
(99, 15, 'Computer Programmer', 'computer_programmer', 1, '2023-03-06 06:08:32', '2023-03-06 06:08:32'),
(100, 15, 'Data Entry Operator', 'data_entry_operator', 1, '2023-03-06 06:08:46', '2023-03-06 06:08:46'),
(101, 15, 'Computer Operator', 'computer_operator', 1, '2023-03-06 06:09:06', '2023-03-06 06:09:06'),
(102, 15, 'Senior Manager (Admin & Finance)', 'senior_manager_admin_&_finance', 1, '2023-03-06 06:11:42', '2023-03-06 06:11:54'),
(103, 15, 'Admin. Officer', 'admin_officer', 1, '2023-03-06 06:12:12', '2023-03-06 06:12:19'),
(104, 15, 'Staff Officer to ED', 'staff_officer_to_ed', 1, '2023-03-06 06:13:01', '2023-03-06 06:13:01'),
(105, 15, 'Section Officer', 'section_officer', 1, '2023-03-06 06:13:13', '2023-03-06 06:13:13'),
(106, 15, 'Management Assistant', 'management_assistant', 1, '2023-03-06 06:13:31', '2023-03-06 06:13:31'),
(107, 15, 'Jr. Mgt. Assistant', 'jr_mgt_assistant', 1, '2023-03-06 06:13:55', '2023-03-06 06:14:04'),
(108, 15, 'Driver', 'driver', 1, '2023-03-06 06:14:17', '2023-03-06 06:14:17'),
(109, 16, 'THSTI', 'thsti', 1, '2023-03-09 01:43:07', '2023-03-09 01:43:07'),
(110, 16, 'CDSA', 'cdsa', 1, '2023-03-09 01:43:15', '2023-03-09 01:43:15'),
(111, 17, 'Male', 'male', 1, '2023-03-10 04:44:47', '2023-03-10 04:44:47'),
(112, 17, 'Female', 'female', 1, '2023-03-10 04:44:55', '2023-03-10 04:44:55'),
(113, 17, 'Transgender', 'transgender', 1, '2023-03-10 04:45:02', '2023-03-10 04:45:02'),
(114, 6, 'Other', 'other', 1, '2023-03-16 03:14:35', '2023-03-16 03:14:35'),
(115, 18, 'Rolling', 'rolling', 1, '2023-03-26 23:38:54', '2023-03-26 23:38:54'),
(116, 18, 'Clinical', 'clinical', 1, '2023-03-26 23:39:04', '2023-03-26 23:39:04'),
(117, 18, 'Other', 'other', 1, '2023-03-26 23:39:11', '2023-03-26 23:39:11'),
(118, 19, 'Center Govt.', 'center_govt.', 1, '2023-04-26 03:52:28', '2023-04-26 03:52:28'),
(119, 19, 'State Govt.', 'state_govt.', 1, '2023-04-26 03:52:53', '2023-04-26 03:52:53'),
(120, 19, 'Autonomous Body', 'autonomous_body', 1, '2023-04-26 04:11:07', '2023-04-26 04:11:07'),
(121, 19, 'PSE/PSU', 'pse/psu', 1, '2023-04-26 04:11:33', '2023-04-26 04:11:33');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fee_crone_job`
--

CREATE TABLE `fee_crone_job` (
  `id` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL COMMENT '1 for completed,\r\n2 for initiated',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fee_crone_job`
--

INSERT INTO `fee_crone_job` (`id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '2023-04-19 22:44:53', '2023-04-19 22:44:54'),
(2, 1, '2023-04-21 03:04:07', '2023-04-21 03:04:09');

-- --------------------------------------------------------

--
-- Table structure for table `fee_crone_job_trans`
--

CREATE TABLE `fee_crone_job_trans` (
  `id` int(11) NOT NULL,
  `fee_crone_job_id` int(11) DEFAULT NULL,
  `status_code` varchar(255) DEFAULT NULL,
  `msg_body` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fee_crone_job_trans`
--

INSERT INTO `fee_crone_job_trans` (`id`, `fee_crone_job_id`, `status_code`, `msg_body`, `created_at`, `updated_at`) VALUES
(1, 1, '200', '0130|THSTI|THSTI_1_1_20230419062851|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|Invalid checksum|NA|NA|NA|NA|NA|N|2A1A4B77E171DB8F3C96AFB43108B1E76FB53073CDDD8061E73A6E38383ED1C1', '2023-04-19 22:44:54', '2023-04-19 22:44:54'),
(2, 2, '200', '0130|THSTI|THSTI_1_1_20230419062851|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|Invalid checksum|NA|NA|NA|NA|NA|N|2A1A4B77E171DB8F3C96AFB43108B1E76FB53073CDDD8061E73A6E38383ED1C1', '2023-04-21 03:04:09', '2023-04-21 03:04:09'),
(3, 2, '200', '0130|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|NA|Invalid message|NA|NA|NA|NA|NA|N|2146206332', '2023-04-21 03:04:09', '2023-04-21 03:04:09');

-- --------------------------------------------------------

--
-- Table structure for table `fee_status_transactions`
--

CREATE TABLE `fee_status_transactions` (
  `id` int(11) NOT NULL,
  `job_apply_id` int(11) DEFAULT NULL,
  `pay_status_code` varchar(255) DEFAULT NULL,
  `code_description` varchar(255) DEFAULT NULL,
  `is_by_crone_job` int(11) DEFAULT NULL,
  `msg_json` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fee_transactions`
--

CREATE TABLE `fee_transactions` (
  `id` int(11) NOT NULL,
  `job_apply_id` int(11) DEFAULT NULL,
  `merchant_id` varchar(255) DEFAULT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `checksum` text DEFAULT NULL,
  `msg` text DEFAULT NULL,
  `currency_type` varchar(255) DEFAULT NULL,
  `txn_amount` decimal(10,2) DEFAULT NULL,
  `txn_reference_no` varchar(255) DEFAULT NULL,
  `txn_charges` decimal(10,2) DEFAULT NULL,
  `txn_date` datetime DEFAULT NULL,
  `bank_ref_no` varchar(255) DEFAULT NULL,
  `bank_id` varchar(255) DEFAULT NULL,
  `pay_status` varchar(255) DEFAULT NULL,
  `error_status` varchar(255) DEFAULT NULL,
  `error_description` varchar(255) DEFAULT NULL,
  `checksum_res` text DEFAULT NULL,
  `msg_res` text DEFAULT NULL,
  `sms_res` varchar(255) DEFAULT NULL,
  `sms_id` int(11) DEFAULT NULL,
  `sms_status` varchar(20) DEFAULT NULL,
  `method` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fee_transactions`
--

INSERT INTO `fee_transactions` (`id`, `job_apply_id`, `merchant_id`, `customer_id`, `email`, `mobile`, `name`, `checksum`, `msg`, `currency_type`, `txn_amount`, `txn_reference_no`, `txn_charges`, `txn_date`, `bank_ref_no`, `bank_id`, `pay_status`, `error_status`, `error_description`, `checksum_res`, `msg_res`, `sms_res`, `sms_id`, `sms_status`, `method`, `created_at`, `updated_at`) VALUES
(1, 1, 'THSTI', 'THSTI_1_1_20230419062851', 'kambojanuj1992@gmail.com', '9517886722', 'Anuj Kamboj', 'F9783D1ECF39B57125078D7330DB3B3B734E559E827BFF674CDCB6F9A0570ACE', 'THSTI|THSTI_1_1_20230419062851|NA|1000|NA|NA|NA|INR|NA|R|thsti|NA|NA|F|kambojanuj1992@gmail.com|9517886722|Anuj Kamboj|1|NA|NA|NA|NA|F9783D1ECF39B57125078D7330DB3B3B734E559E827BFF674CDCB6F9A0570ACE', NULL, '1000.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-19 00:58:53', '2023-04-19 00:58:53'),
(2, 1, 'THSTI', 'THSTI_1_JobFee_1_20230421061518', 'kambojanuj1992@gmail.com', '9517886722', 'Anuj Kamboj', '5BBA17971D4B98BF0CC40A6F2B7A1D5F9DBA40F04A793E81F18167C8AA4FA773', 'THSTI|THSTI_1_JobFee_1_20230421061518|NA|1000|NA|NA|NA|INR|NA|R|thsti|NA|NA|F|kambojanuj1992@gmail.com|9517886722|Anuj Kamboj|1|NA|NA|NA|NA|5BBA17971D4B98BF0CC40A6F2B7A1D5F9DBA40F04A793E81F18167C8AA4FA773', NULL, '1000.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-21 00:45:20', '2023-04-21 00:45:20'),
(3, 1, 'THSTI', 'THSTI_1_JobFee_1_20230424055904', 'kambojanuj1992@gmail.com', '9517886722', 'Anuj Kamboj', 'FB683A661DC141FC4CF67351E4A800F99BA562C592DBF40B349008AA9BA681BF', 'THSTI|THSTI_1_JobFee_1_20230424055904|NA|1|NA|NA|NA|INR|NA|R|thsti|NA|NA|F|kambojanuj1992@gmail.com|9517886722|Anuj Kamboj|1|NA|NA|NA|NA|FB683A661DC141FC4CF67351E4A800F99BA562C592DBF40B349008AA9BA681BF', NULL, '1.00', 'YCPH1857324726', NULL, '2023-04-25 14:54:59', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-24 00:29:52', '2023-05-03 06:27:35');

-- --------------------------------------------------------

--
-- Table structure for table `form_configuration`
--

CREATE TABLE `form_configuration` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 - active,\r\n2 - inactive,\r\n3 - delete',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `form_configuration`
--

INSERT INTO `form_configuration` (`id`, `post_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 105, 1, '2023-03-09 00:56:28', '2023-03-10 06:09:50'),
(2, 99, 1, '2023-04-09 23:39:39', '2023-04-09 23:39:39');

-- --------------------------------------------------------

--
-- Table structure for table `form_fields_configuration`
--

CREATE TABLE `form_fields_configuration` (
  `id` int(11) NOT NULL,
  `form_config_id` int(11) NOT NULL COMMENT 'primary key of form_configuration table',
  `form_tab_field_id` int(11) NOT NULL,
  `is_tab_field` int(11) NOT NULL COMMENT '1 for tab, \r\n2 for field',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 - active, \r\n2 - inactive, \r\n3 - delete	',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `form_fields_configuration`
--

INSERT INTO `form_fields_configuration` (`id`, `form_config_id`, `form_tab_field_id`, `is_tab_field`, `status`, `created_at`, `updated_at`) VALUES
(1, 45, 1, 1, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(2, 45, 2, 1, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(3, 45, 3, 1, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(4, 45, 1, 2, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(5, 45, 2, 2, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(6, 45, 3, 2, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(7, 45, 4, 2, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(8, 45, 7, 2, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(9, 45, 8, 2, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(10, 45, 9, 2, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(11, 45, 5, 2, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(12, 45, 6, 2, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(13, 45, 10, 2, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(14, 45, 11, 2, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(15, 45, 12, 2, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(16, 45, 13, 2, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(17, 45, 14, 2, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(18, 45, 15, 2, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(19, 45, 16, 2, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(20, 45, 17, 2, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(21, 45, 18, 2, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(22, 45, 19, 2, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(23, 45, 20, 2, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(24, 45, 21, 2, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(25, 45, 22, 2, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(26, 45, 23, 2, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(27, 45, 24, 2, 3, '2023-02-27 08:50:04', '2023-03-12 22:38:04'),
(28, 45, 25, 2, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(29, 45, 26, 2, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(30, 45, 27, 2, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(31, 45, 28, 2, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(32, 45, 29, 2, 3, '2023-02-27 08:50:04', '2023-03-16 03:23:06'),
(33, 45, 30, 2, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(34, 45, 31, 2, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(35, 45, 33, 2, 1, '2023-02-27 08:50:04', '2023-02-27 08:50:04'),
(36, 45, 34, 2, 1, '2023-02-27 08:50:04', '2023-02-27 10:30:01'),
(70, 45, 32, 2, 1, '2023-02-27 10:29:30', '2023-02-27 10:29:30'),
(71, 45, 35, 2, 1, '2023-02-27 10:29:30', '2023-02-27 10:29:30'),
(72, 45, 36, 2, 1, '2023-02-27 10:29:30', '2023-02-27 10:29:30'),
(73, 1, 1, 1, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(74, 1, 2, 1, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(75, 1, 3, 1, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(76, 1, 1, 2, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(77, 1, 2, 2, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(78, 1, 3, 2, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(79, 1, 4, 2, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(80, 1, 7, 2, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(81, 1, 8, 2, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(82, 1, 9, 2, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(83, 1, 5, 2, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(84, 1, 6, 2, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(85, 1, 10, 2, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(86, 1, 11, 2, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(87, 1, 12, 2, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(88, 1, 13, 2, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(89, 1, 14, 2, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(90, 1, 15, 2, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(91, 1, 16, 2, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(92, 1, 17, 2, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(93, 1, 18, 2, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(94, 1, 19, 2, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(95, 1, 20, 2, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(96, 1, 21, 2, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(97, 1, 22, 2, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(98, 1, 23, 2, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(99, 1, 24, 2, 3, '2023-03-09 06:26:28', '2023-03-12 22:38:04'),
(100, 1, 25, 2, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(101, 1, 26, 2, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(102, 1, 27, 2, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(103, 1, 28, 2, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(104, 1, 29, 2, 3, '2023-03-09 06:26:28', '2023-03-16 03:23:06'),
(105, 1, 30, 2, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(106, 1, 31, 2, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(107, 1, 33, 2, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(108, 1, 34, 2, 1, '2023-03-09 06:26:28', '2023-03-09 06:26:28'),
(109, 1, 29, 2, 1, '2023-03-16 08:53:19', '2023-03-16 08:53:19'),
(110, 1, 4, 1, 1, '2023-03-20 04:16:22', '2023-03-20 04:16:22'),
(111, 1, 32, 2, 1, '2023-03-20 04:16:22', '2023-03-20 04:16:22'),
(112, 1, 35, 2, 1, '2023-03-20 04:16:22', '2023-03-20 04:16:22'),
(113, 1, 36, 2, 1, '2023-03-20 04:16:22', '2023-03-20 04:16:22'),
(114, 1, 37, 2, 1, '2023-03-20 04:16:22', '2023-03-20 04:16:22'),
(115, 1, 38, 2, 1, '2023-03-20 04:16:22', '2023-03-20 04:16:22'),
(116, 1, 5, 1, 1, '2023-03-21 04:07:54', '2023-03-21 04:07:54'),
(117, 1, 6, 1, 1, '2023-03-21 04:07:54', '2023-03-21 04:07:54'),
(118, 1, 7, 1, 1, '2023-03-21 04:07:54', '2023-03-21 04:07:54'),
(119, 1, 39, 2, 1, '2023-03-21 04:07:54', '2023-03-21 04:07:54'),
(120, 1, 40, 2, 1, '2023-03-21 04:07:54', '2023-03-21 04:07:54'),
(121, 1, 41, 2, 1, '2023-03-21 04:07:54', '2023-03-21 04:07:54'),
(122, 1, 42, 2, 1, '2023-03-21 04:07:54', '2023-03-21 04:07:54'),
(123, 1, 43, 2, 1, '2023-03-21 04:07:54', '2023-03-21 04:07:54'),
(124, 1, 44, 2, 1, '2023-03-21 04:07:54', '2023-03-21 04:07:54'),
(125, 1, 45, 2, 1, '2023-03-21 04:07:54', '2023-03-21 04:07:54'),
(126, 1, 8, 1, 1, '2023-03-21 11:31:12', '2023-03-21 11:31:12'),
(127, 1, 9, 1, 1, '2023-03-21 11:31:12', '2023-03-21 11:31:12'),
(128, 1, 46, 2, 1, '2023-03-21 11:31:12', '2023-03-21 11:31:12'),
(129, 1, 47, 2, 1, '2023-03-21 11:31:12', '2023-03-21 11:31:12'),
(130, 1, 48, 2, 1, '2023-03-21 11:31:12', '2023-03-21 11:31:12'),
(131, 1, 49, 2, 1, '2023-03-21 11:31:12', '2023-03-21 11:31:12'),
(132, 1, 50, 2, 1, '2023-03-21 11:31:12', '2023-03-21 11:31:12'),
(133, 1, 51, 2, 1, '2023-03-21 11:31:12', '2023-03-21 11:31:12'),
(134, 1, 52, 2, 1, '2023-03-21 11:31:12', '2023-03-21 11:31:12'),
(135, 1, 53, 2, 1, '2023-03-21 11:31:12', '2023-03-21 11:31:12'),
(136, 1, 54, 2, 1, '2023-03-21 11:31:12', '2023-03-21 11:31:12'),
(137, 1, 12, 1, 1, '2023-03-22 04:34:05', '2023-03-22 04:34:05'),
(138, 1, 13, 1, 1, '2023-03-22 04:34:05', '2023-03-22 04:34:05'),
(139, 1, 56, 2, 1, '2023-03-22 04:34:05', '2023-03-22 04:34:05'),
(140, 1, 57, 2, 1, '2023-03-22 04:34:05', '2023-03-22 04:34:05'),
(141, 1, 58, 2, 1, '2023-03-22 04:34:05', '2023-03-22 04:34:05'),
(142, 1, 59, 2, 1, '2023-03-22 04:34:05', '2023-03-22 04:34:05'),
(143, 1, 61, 2, 1, '2023-03-22 04:34:05', '2023-03-22 04:34:05'),
(144, 1, 62, 2, 1, '2023-03-22 04:34:05', '2023-03-22 04:34:05'),
(145, 1, 63, 2, 1, '2023-03-22 04:34:05', '2023-03-22 04:34:05'),
(146, 1, 14, 1, 1, '2023-04-03 12:11:58', '2023-04-03 12:11:58'),
(147, 1, 64, 2, 1, '2023-04-03 12:11:58', '2023-04-03 12:11:58'),
(148, 1, 65, 2, 1, '2023-04-03 12:11:58', '2023-04-03 12:11:58'),
(149, 1, 66, 2, 1, '2023-04-03 12:11:58', '2023-04-03 12:11:58'),
(150, 1, 67, 2, 1, '2023-04-03 12:11:58', '2023-04-03 12:11:58'),
(151, 1, 68, 2, 1, '2023-04-03 12:11:58', '2023-04-03 12:11:58'),
(152, 1, 69, 2, 1, '2023-04-03 12:11:58', '2023-04-03 12:11:58'),
(153, 1, 70, 2, 1, '2023-04-03 12:11:58', '2023-04-03 12:11:58'),
(154, 1, 71, 2, 1, '2023-04-03 12:11:58', '2023-04-03 12:11:58'),
(155, 1, 72, 2, 1, '2023-04-03 12:11:58', '2023-04-03 12:11:58'),
(156, 1, 73, 2, 1, '2023-04-03 12:11:58', '2023-04-03 12:11:58'),
(157, 2, 1, 1, 1, '2023-04-10 05:09:39', '2023-04-10 05:09:39'),
(158, 2, 2, 1, 1, '2023-04-10 05:09:39', '2023-04-10 05:09:39'),
(159, 2, 1, 2, 1, '2023-04-10 05:09:39', '2023-04-10 05:09:39'),
(160, 2, 2, 2, 1, '2023-04-10 05:09:39', '2023-04-10 05:09:39'),
(161, 2, 3, 2, 1, '2023-04-10 05:09:39', '2023-04-10 05:09:39'),
(162, 2, 4, 2, 1, '2023-04-10 05:09:39', '2023-04-10 05:09:39'),
(163, 2, 7, 2, 1, '2023-04-10 05:09:39', '2023-04-10 05:09:39'),
(164, 2, 8, 2, 1, '2023-04-10 05:09:39', '2023-04-10 05:09:39'),
(165, 2, 9, 2, 1, '2023-04-10 05:09:39', '2023-04-10 05:09:39'),
(166, 2, 5, 2, 1, '2023-04-10 05:09:39', '2023-04-10 05:09:39'),
(167, 2, 6, 2, 1, '2023-04-10 05:09:39', '2023-04-10 05:09:39'),
(168, 2, 10, 2, 1, '2023-04-10 05:09:39', '2023-04-10 05:09:39'),
(169, 2, 11, 2, 1, '2023-04-10 05:09:39', '2023-04-10 05:09:39'),
(170, 2, 12, 2, 1, '2023-04-10 05:09:39', '2023-04-10 05:09:39'),
(171, 2, 13, 2, 1, '2023-04-10 05:09:39', '2023-04-10 05:09:39'),
(172, 2, 14, 2, 1, '2023-04-10 05:09:39', '2023-04-10 05:09:39'),
(173, 2, 15, 2, 1, '2023-04-10 05:09:39', '2023-04-10 05:09:39'),
(174, 2, 16, 2, 1, '2023-04-10 05:09:39', '2023-04-10 05:09:39'),
(175, 2, 17, 2, 1, '2023-04-10 05:09:39', '2023-04-10 05:09:39'),
(176, 2, 18, 2, 1, '2023-04-10 05:09:39', '2023-04-10 05:09:39'),
(177, 2, 19, 2, 1, '2023-04-10 05:09:39', '2023-04-10 05:09:39'),
(178, 2, 20, 2, 1, '2023-04-10 05:09:39', '2023-04-10 05:09:39'),
(179, 2, 21, 2, 1, '2023-04-10 05:09:39', '2023-04-10 05:09:39'),
(180, 2, 22, 2, 1, '2023-04-10 05:09:39', '2023-04-10 05:09:39'),
(181, 2, 23, 2, 1, '2023-04-10 05:09:39', '2023-04-10 05:09:39'),
(182, 2, 24, 2, 1, '2023-04-10 05:09:39', '2023-04-10 05:09:39'),
(183, 1, 77, 2, 1, '2023-04-26 06:54:06', '2023-04-26 06:54:06');

-- --------------------------------------------------------

--
-- Table structure for table `form_field_options`
--

CREATE TABLE `form_field_options` (
  `id` int(11) NOT NULL,
  `form_tab_field_id` int(11) NOT NULL,
  `field_option` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 - active,\r\n2 - inactive,\r\n3 - delete',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `form_field_types`
--

CREATE TABLE `form_field_types` (
  `id` int(11) NOT NULL,
  `field_type` varchar(255) NOT NULL,
  `is_multiple_option` int(11) NOT NULL DEFAULT 0 COMMENT '1 - yes,\r\n0 - no,\r\neg. options, dropdown values',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 - active,\r\n2 - inactive,\r\n3 - delete',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `form_field_types`
--

INSERT INTO `form_field_types` (`id`, `field_type`, `is_multiple_option`, `status`, `created_at`, `updated_at`) VALUES
(1, 'input', 0, 1, '2023-02-23 03:24:58', '2023-02-23 03:24:58'),
(2, 'textarea', 0, 1, '2023-02-23 03:26:30', '2023-02-23 03:26:30'),
(3, 'datetime', 0, 1, '2023-02-23 03:26:47', '2023-02-23 03:26:47'),
(4, 'checkbox', 0, 1, '2023-02-23 03:27:24', '2023-02-23 03:27:24'),
(5, 'radio', 1, 1, '2023-02-23 03:27:33', '2023-02-23 03:27:33'),
(6, 'dropdown', 1, 1, '2023-02-23 03:27:44', '2023-02-23 03:27:44');

-- --------------------------------------------------------

--
-- Table structure for table `form_tabs`
--

CREATE TABLE `form_tabs` (
  `id` int(11) NOT NULL,
  `tab_title` varchar(255) NOT NULL,
  `tab_code` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `form_tabs`
--

INSERT INTO `form_tabs` (`id`, `tab_title`, `tab_code`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Vacancy Information', 'vacancy_information', 1, 1, '2023-02-21 00:40:17', '2023-03-02 07:15:04'),
(2, 'Personal Information', 'personal_information', 2, 1, '2023-02-21 00:41:32', '2023-03-02 07:15:04'),
(3, 'Academic Details', 'academic_details', 3, 1, '2023-02-21 00:41:43', '2023-03-02 07:15:04'),
(4, 'Experience', 'experience', 4, 1, '2023-02-21 00:41:58', '2023-03-02 07:15:04'),
(5, 'Publication\'s', 'publications', 5, 1, '2023-02-21 00:42:18', '2023-03-02 07:15:04'),
(6, 'Patent\'s', 'patents', 6, 1, '2023-02-21 00:42:37', '2023-03-02 07:15:04'),
(7, 'Research statement', 'research_statement', 7, 1, '2023-02-21 00:42:49', '2023-03-02 07:15:04'),
(8, 'Relative/friend working in THSTI', 'relativefriend_working_in_thsti', 8, 1, '2023-02-21 00:43:02', '2023-03-02 07:15:04'),
(9, 'Name of the Referee\'s', 'name_of_the_referees', 9, 1, '2023-02-21 00:43:18', '2023-03-02 07:15:04'),
(10, 'PhD Form (Group -A)', 'phd_form_group_a', 10, 1, '2023-02-21 00:44:17', '2023-03-02 07:17:21'),
(11, 'PhD Form (Group -B)', 'phd_form_group_b', 11, 1, '2023-02-21 00:44:26', '2023-03-02 07:17:21'),
(12, 'Fellowship Details', 'fellowship_details', 12, 1, '2023-02-21 00:44:35', '2023-03-02 07:15:04'),
(13, 'Exam Qualified Details', 'exam_qualified_details', 13, 1, '2023-02-21 00:44:46', '2023-03-02 07:15:04'),
(14, 'Attachments', 'attachments', 14, 1, '2023-02-21 00:45:01', '2023-03-02 07:15:04'),
(15, 'DD Information', 'dd_information', 15, 1, '2023-02-21 00:45:12', '2023-03-02 07:15:04');

-- --------------------------------------------------------

--
-- Table structure for table `form_tab_fields`
--

CREATE TABLE `form_tab_fields` (
  `id` int(11) NOT NULL,
  `field_name` varchar(255) NOT NULL,
  `field_slug` varchar(255) NOT NULL,
  `form_tab_id` int(11) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 for active,\r\n1 for inactive,\r\n3 for delete',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `form_tab_fields`
--

INSERT INTO `form_tab_fields` (`id`, `field_name`, `field_slug`, `form_tab_id`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'RN No.', 'rn_no.', 1, 1, 1, '2023-02-23 05:29:56', '2023-02-23 05:29:56'),
(2, 'Post Applied For', 'post_applied_for', 1, 2, 1, '2023-02-23 05:45:42', '2023-02-23 05:45:42'),
(3, 'Domain Area', 'domain_area', 1, 3, 1, '2023-02-23 05:46:02', '2023-02-23 05:46:02'),
(4, 'Method of Appointment', 'method_of_appointment', 1, 4, 1, '2023-02-23 05:46:20', '2023-02-23 05:46:20'),
(5, 'Full Name', 'full_name', 2, 1, 1, '2023-02-23 05:46:34', '2023-02-23 05:46:34'),
(6, 'Father\'s Name', 'fathers_name', 2, 2, 1, '2023-02-23 05:46:49', '2023-02-23 11:33:16'),
(7, 'Groups', 'groups', 1, 5, 1, '2023-02-23 05:49:10', '2023-02-23 05:49:10'),
(8, 'Group-A', 'group-a', 1, 6, 1, '2023-02-23 06:02:06', '2023-02-23 06:02:06'),
(9, 'Group-B', 'group-b', 1, 7, 1, '2023-02-23 06:02:21', '2023-02-23 06:02:21'),
(10, 'Mother\'s Name', 'mothers_name', 2, 3, 1, '2023-02-23 06:02:41', '2023-02-23 11:33:10'),
(11, 'Date of Birth', 'date_of_birth', 2, 4, 1, '2023-02-23 06:02:58', '2023-02-23 06:02:58'),
(12, 'Gender', 'gender', 2, 5, 1, '2023-02-23 06:04:21', '2023-02-23 06:04:21'),
(13, 'Category', 'category', 2, 6, 1, '2023-02-23 06:04:40', '2023-02-23 06:04:40'),
(14, 'Person with disability?', 'person_with_disability', 2, 7, 1, '2023-02-23 06:05:01', '2023-02-23 11:35:17'),
(15, 'Domecile Check', 'domecile_check', 2, 8, 1, '2023-02-23 06:09:48', '2023-02-23 11:43:03'),
(16, 'Institute Address', 'institute_address', 2, 9, 1, '2023-02-23 06:10:44', '2023-02-23 11:43:08'),
(17, 'Ex-Servicemen?', 'ex-servicemen', 2, 10, 1, '2023-02-23 06:11:06', '2023-02-23 06:11:06'),
(18, 'Nationality', 'nationality', 2, 11, 1, '2023-02-23 06:11:20', '2023-02-23 06:11:20'),
(19, 'Correspondence Address', 'correspondence_address', 2, 12, 1, '2023-02-23 06:11:33', '2023-02-23 11:43:18'),
(20, 'Permanent Address', 'permanent_address', 2, 13, 1, '2023-02-23 06:11:46', '2023-02-23 11:43:25'),
(21, 'Email ID', 'email_id', 2, 14, 1, '2023-02-23 06:12:00', '2023-02-23 11:43:31'),
(22, 'Mobile no.', 'mobile_no', 2, 15, 1, '2023-02-23 06:12:14', '2023-02-23 11:43:36'),
(23, 'Phone no.', 'phoneno', 2, 16, 1, '2023-02-23 06:13:53', '2023-02-23 06:13:53'),
(24, 'Trainee Category', 'traineecategory', 2, 17, 1, '2023-02-23 06:14:06', '2023-02-23 06:14:06'),
(25, 'Name of the Examination Passed', 'nameoftheexaminationpassed', 3, 1, 1, '2023-02-23 06:14:20', '2023-02-23 06:14:20'),
(26, 'Year of Passing', 'yearofpassing', 3, 2, 1, '2023-02-23 06:14:31', '2023-02-23 06:14:31'),
(27, 'Name of the degree/Subjects', 'nameofthedegreesubjects', 3, 3, 1, '2023-02-23 06:15:00', '2023-02-23 06:15:00'),
(28, 'Board / University', 'boarduniversity', 3, 4, 1, '2023-02-23 06:15:13', '2023-02-23 06:15:13'),
(29, '% (Round Off)', 'roundoff', 3, 5, 1, '2023-02-23 06:15:25', '2023-02-23 06:15:25'),
(30, 'CGPA', 'cgpa', 3, 6, 1, '2023-02-23 06:15:33', '2023-02-23 06:15:33'),
(31, 'Division', 'division', 3, 7, 1, '2023-02-23 06:15:49', '2023-02-23 06:15:49'),
(32, 'From', 'exp_from', 4, 1, 1, '2023-02-23 06:16:30', '2023-03-20 04:34:33'),
(33, 'To', 'to', 3, 8, 1, '2023-02-23 06:16:57', '2023-02-23 06:16:57'),
(34, 'Total Experience', 'totalexperience', 3, 9, 1, '2023-02-23 06:17:11', '2023-02-23 06:17:11'),
(35, 'Designation', 'designation', 4, 2, 1, '2023-02-23 06:17:20', '2023-02-23 06:17:20'),
(36, 'Name of the Organisation', 'nameoftheorganisation', 4, 3, 1, '2023-02-23 06:17:32', '2023-02-23 06:17:32'),
(37, 'Grade Pay', 'gradepay', 4, 4, 1, '2023-02-23 06:17:45', '2023-02-23 06:17:45'),
(38, 'Gross Pay', 'grosspay', 4, 5, 1, '2023-02-23 06:17:55', '2023-02-23 06:17:55'),
(39, 'Select Number in Publication', 'selectnumberinpublication', 5, 1, 1, '2023-02-23 06:18:12', '2023-02-23 06:18:12'),
(40, 'List of authors', 'listofauthors', 5, 2, 1, '2023-02-23 06:18:22', '2023-02-23 06:18:22'),
(41, 'Title of the article', 'titleofthearticle', 5, 3, 1, '2023-02-23 06:18:32', '2023-02-23 06:18:32'),
(42, 'Journal name', 'journalname', 5, 4, 1, '2023-02-23 06:18:49', '2023-02-23 06:18:49'),
(43, 'Year/Volume(Issue)', 'yearvolumeissue', 5, 5, 1, '2023-02-23 06:19:05', '2023-02-23 06:19:05'),
(44, 'Doi', 'doi', 5, 6, 1, '2023-02-23 06:19:15', '2023-02-23 06:19:15'),
(45, 'PubMed PMID', 'pubmedpmid', 5, 7, 1, '2023-02-23 06:19:27', '2023-02-23 06:19:27'),
(46, 'Name of the person(s)', 'nameofthepersons', 8, 1, 1, '2023-02-23 06:19:46', '2023-02-23 06:19:46'),
(47, 'Designation', 'designation', 8, 2, 1, '2023-02-23 06:19:55', '2023-02-23 06:19:55'),
(48, 'Relationship with the candidate', 'relationshipwiththecandidate', 8, 3, 1, '2023-02-23 06:20:07', '2023-02-23 06:20:07'),
(49, 'Name of Refree', 'nameofrefree', 9, 1, 1, '2023-02-23 06:20:19', '2023-02-23 06:20:19'),
(50, 'Referee Designation', 'refereedesignation', 9, 2, 1, '2023-02-23 06:21:03', '2023-02-23 06:21:03'),
(51, 'Referee Organisation', 'refereeorganisation', 9, 3, 1, '2023-02-23 06:21:17', '2023-02-23 06:21:17'),
(52, 'Referee Email Id', 'refereeemailid', 9, 4, 1, '2023-02-23 06:21:28', '2023-02-23 06:21:28'),
(53, 'Referee Phone No.', 'refereephoneno', 9, 5, 1, '2023-02-23 06:21:45', '2023-02-23 06:21:45'),
(54, 'Referee Mobile No.', 'refereemobileno', 9, 6, 1, '2023-02-23 06:21:54', '2023-02-23 06:21:54'),
(56, 'Fund Agency', 'fundagency', 12, 2, 1, '2023-02-23 06:22:31', '2023-02-23 11:56:46'),
(57, 'Rank', 'phdrank', 12, 3, 1, '2023-02-23 06:22:47', '2023-02-23 11:58:10'),
(58, 'Admission Test', 'phdadmissiontest', 12, 4, 1, '2023-02-23 06:23:05', '2023-02-23 11:58:14'),
(59, 'Validity Up To', 'phdvalidityupto', 12, 5, 1, '2023-02-23 06:23:19', '2023-02-23 11:58:18'),
(61, 'Exam Qualified', 'phdexamqualified', 13, 2, 1, '2023-02-23 06:23:58', '2023-02-23 11:58:23'),
(62, 'Score', 'phdscore', 13, 3, 1, '2023-02-23 06:24:11', '2023-02-23 11:58:26'),
(63, 'Exam Validity Up To', 'phdexamvalidityupto', 13, 4, 1, '2023-02-23 06:24:28', '2023-02-23 11:58:30'),
(64, 'Upload Image', 'uploadimage', 14, 1, 1, '2023-02-23 06:28:42', '2023-02-23 06:28:42'),
(65, 'Upload Signature', 'uploadsignature', 14, 2, 1, '2023-02-23 06:28:54', '2023-02-23 06:28:54'),
(66, 'Upload CV', 'uploadcv', 14, 3, 1, '2023-02-23 06:29:06', '2023-02-23 06:29:06'),
(67, 'List of Publications and Patents', 'listofpublicationsandpatents', 14, 4, 1, '2023-02-23 06:29:17', '2023-02-23 06:29:17'),
(68, 'Publications (Best three)', 'publicationsbestthree', 14, 5, 1, '2023-02-23 06:29:28', '2023-02-23 06:29:28'),
(69, 'Project Proposal', 'projectproposal', 14, 6, 1, '2023-02-23 06:29:38', '2023-02-23 06:29:38'),
(70, 'Age Proof', 'ageproof', 14, 7, 1, '2023-02-23 06:29:50', '2023-02-23 06:29:50'),
(71, 'Forwarding letter / NOC', 'forwardingletternoc', 14, 8, 1, '2023-02-23 06:30:01', '2023-02-23 06:30:01'),
(72, 'Statement of Proposal', 'statementofproposal', 14, 9, 1, '2023-02-23 06:30:12', '2023-02-23 06:30:12'),
(73, 'ID Card', 'idcard', 14, 10, 1, '2023-02-23 06:30:22', '2023-02-23 06:30:22'),
(74, 'DD Amount', 'ddamount', 15, 1, 1, '2023-02-23 06:30:33', '2023-02-23 06:30:33'),
(75, 'DD Date', 'dddate', 15, 2, 1, '2023-02-23 06:30:43', '2023-02-23 06:30:43'),
(76, 'DD No', 'ddno', 15, 3, 1, '2023-02-23 06:30:54', '2023-02-23 06:30:54'),
(77, 'Is Govt Servent', 'isgovtservent', 2, 18, 1, '2023-04-26 00:59:22', '2023-04-26 00:59:22');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `rn_no_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `job_validation_id` int(11) DEFAULT NULL,
  `job_configuration_id` int(11) DEFAULT NULL,
  `job_type_id` int(11) DEFAULT NULL,
  `center_id` int(11) NOT NULL,
  `payment_mode_id` int(11) DEFAULT NULL,
  `post_domain_id` int(11) DEFAULT NULL,
  `apply_start_date` date DEFAULT NULL,
  `apply_end_date` date DEFAULT NULL,
  `hard_copy_submission_date` date DEFAULT NULL,
  `no_of_posts` int(11) DEFAULT NULL,
  `age_limit` int(11) DEFAULT NULL COMMENT 'In years',
  `age_limit_as_on_date` date DEFAULT NULL,
  `phd_document` varchar(255) DEFAULT NULL,
  `announcement` varchar(900) DEFAULT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `email_id` varchar(255) DEFAULT NULL,
  `is_payment_required` int(11) DEFAULT NULL,
  `is_permanent` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 2 COMMENT '1 - publish,\r\n2 - unpublish,\r\n3 - archive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `rn_no_id`, `post_id`, `job_validation_id`, `job_configuration_id`, `job_type_id`, `center_id`, `payment_mode_id`, `post_domain_id`, `apply_start_date`, `apply_end_date`, `hard_copy_submission_date`, `no_of_posts`, `age_limit`, `age_limit_as_on_date`, `phd_document`, `announcement`, `alt_text`, `email_id`, `is_payment_required`, `is_permanent`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 99, 6, 2, 2, 5, 7, NULL, '2023-02-17', '2023-02-28', NULL, 5, 30, NULL, 'Payment_Receipt.pdf', 'test announcement text updated', 'Walk-in', 'kambojanuj@thsti.res.in', 1, 2, 1, '2023-02-10 03:42:09', '2023-04-11 00:51:41'),
(2, 10, 105, 8, 1, 1, 4, 6, NULL, '2023-02-24', '2023-03-10', NULL, 2, 30, '2023-05-08', NULL, 'test announcement', NULL, 'kambojanuj@thsti.res.in', 1, 1, 1, '2023-02-20 05:11:47', '2023-05-08 23:58:19');

-- --------------------------------------------------------

--
-- Table structure for table `job_age_limit_validation_trans`
--

CREATE TABLE `job_age_limit_validation_trans` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `job_validation_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL COMMENT 'code_name_id for Age Limit Category',
  `years` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 - for active,\r\n2 - for inactive,\r\n3 - for delete',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `job_age_limit_validation_trans`
--

INSERT INTO `job_age_limit_validation_trans` (`id`, `post_id`, `job_validation_id`, `category_id`, `years`, `status`, `created_at`, `updated_at`) VALUES
(1, 99, 1, 9, 3, 3, '2023-03-09 05:55:10', '2023-03-09 00:33:13'),
(2, 99, 1, 10, 5, 3, '2023-03-09 05:55:10', '2023-03-09 00:33:13'),
(3, 99, 1, 11, 5, 3, '2023-03-09 05:55:10', '2023-03-09 00:33:13'),
(4, 99, 1, 9, 3, 3, '2023-03-09 06:03:00', '2023-03-09 00:33:13'),
(5, 99, 1, 10, 5, 3, '2023-03-09 06:03:00', '2023-03-09 00:33:13'),
(6, 99, 1, 11, 5, 3, '2023-03-09 06:03:00', '2023-03-09 00:33:13'),
(7, 99, 2, 9, 3, 3, '2023-03-09 06:03:13', '2023-03-15 03:51:42'),
(8, 99, 2, 10, 5, 3, '2023-03-09 06:03:13', '2023-03-15 03:51:42'),
(9, 99, 2, 11, 5, 3, '2023-03-09 06:03:13', '2023-03-15 03:51:42'),
(10, 105, 3, 9, 3, 3, '2023-03-15 09:21:42', '2023-03-16 04:24:34'),
(11, 105, 3, 10, 5, 3, '2023-03-15 09:21:42', '2023-03-16 04:24:34'),
(12, 105, 3, 11, 5, 3, '2023-03-15 09:21:42', '2023-03-16 04:24:34'),
(13, 105, 4, 9, 3, 3, '2023-03-16 09:54:34', '2023-03-20 23:40:12'),
(14, 105, 4, 10, 5, 3, '2023-03-16 09:54:34', '2023-03-20 23:40:12'),
(15, 105, 4, 11, 5, 3, '2023-03-16 09:54:34', '2023-03-20 23:40:12'),
(16, 105, 5, 9, 3, 3, '2023-03-21 05:10:12', '2023-04-12 05:19:30'),
(17, 105, 5, 10, 5, 3, '2023-03-21 05:10:12', '2023-04-12 05:19:30'),
(18, 105, 5, 11, 5, 3, '2023-03-21 05:10:12', '2023-04-12 05:19:30'),
(19, 99, 6, 9, 3, 1, '2023-04-11 06:21:41', '2023-04-11 06:21:41'),
(20, 99, 6, 10, 5, 1, '2023-04-11 06:21:41', '2023-04-11 06:21:41'),
(21, 99, 6, 11, 5, 1, '2023-04-11 06:21:41', '2023-04-11 06:21:41'),
(22, 105, 7, 9, 3, 3, '2023-04-12 10:49:30', '2023-05-08 23:58:19'),
(23, 105, 7, 10, 5, 3, '2023-04-12 10:49:30', '2023-05-08 23:58:19'),
(24, 105, 7, 11, 5, 3, '2023-04-12 10:49:30', '2023-05-08 23:58:19'),
(25, 105, 8, 9, 3, 1, '2023-05-09 05:28:19', '2023-05-09 05:28:19'),
(26, 105, 8, 10, 5, 1, '2023-05-09 05:28:19', '2023-05-09 05:28:19'),
(27, 105, 8, 11, 5, 1, '2023-05-09 05:28:19', '2023-05-09 05:28:19'),
(28, 105, 8, 12, 3, 1, '2023-05-09 05:28:19', '2023-05-09 05:28:19');

-- --------------------------------------------------------

--
-- Table structure for table `job_application_fee_trans`
--

CREATE TABLE `job_application_fee_trans` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `job_validation_id` int(11) NOT NULL,
  `fee_category_id` int(11) NOT NULL COMMENT 'code_names_id from Fee Category Master',
  `fee` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 - for active,\r\n2 - for inactive,\r\n3 - for delete',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `job_application_fee_trans`
--

INSERT INTO `job_application_fee_trans` (`id`, `post_id`, `job_validation_id`, `fee_category_id`, `fee`, `status`, `created_at`, `updated_at`) VALUES
(1, 99, 1, 19, 1, 3, '2023-03-09 05:55:10', '2023-04-24 05:58:54'),
(2, 99, 1, 20, 1, 3, '2023-03-09 05:55:10', '2023-04-24 05:58:54'),
(3, 99, 1, 21, 1, 3, '2023-03-09 05:55:10', '2023-04-24 05:58:54'),
(4, 99, 2, 19, 1, 3, '2023-03-09 06:03:13', '2023-04-24 05:58:54'),
(5, 99, 2, 20, 1, 3, '2023-03-09 06:03:13', '2023-04-24 05:58:54'),
(6, 99, 2, 21, 1, 3, '2023-03-09 06:03:13', '2023-04-24 05:58:54'),
(7, 99, 2, 22, 1, 3, '2023-03-09 06:03:13', '2023-04-24 05:58:54'),
(8, 105, 3, 19, 1, 3, '2023-03-15 09:21:42', '2023-04-24 05:58:54'),
(9, 105, 3, 20, 1, 3, '2023-03-15 09:21:42', '2023-04-24 05:58:54'),
(10, 105, 3, 21, 1, 3, '2023-03-15 09:21:42', '2023-04-24 05:58:54'),
(11, 105, 3, 22, 1, 3, '2023-03-15 09:21:42', '2023-04-24 05:58:54'),
(12, 105, 4, 19, 1, 3, '2023-03-16 09:54:34', '2023-04-24 05:58:54'),
(13, 105, 4, 20, 1, 3, '2023-03-16 09:54:34', '2023-04-24 05:58:54'),
(14, 105, 4, 21, 1, 3, '2023-03-16 09:54:34', '2023-04-24 05:58:54'),
(15, 105, 4, 22, 1, 3, '2023-03-16 09:54:34', '2023-04-24 05:58:54'),
(16, 105, 5, 19, 1, 3, '2023-03-21 05:10:12', '2023-04-24 05:58:54'),
(17, 105, 5, 20, 1, 3, '2023-03-21 05:10:12', '2023-04-24 05:58:54'),
(18, 105, 5, 21, 1, 3, '2023-03-21 05:10:12', '2023-04-24 05:58:54'),
(19, 105, 5, 22, 1, 3, '2023-03-21 05:10:12', '2023-04-24 05:58:54'),
(20, 99, 6, 19, 1, 1, '2023-04-11 06:21:41', '2023-04-24 05:58:54'),
(21, 99, 6, 20, 1, 1, '2023-04-11 06:21:41', '2023-04-24 05:58:54'),
(22, 99, 6, 21, 1, 1, '2023-04-11 06:21:41', '2023-04-24 05:58:54'),
(23, 99, 6, 22, 1, 1, '2023-04-11 06:21:41', '2023-04-24 05:58:54'),
(24, 99, 6, 23, 1, 1, '2023-04-11 06:21:41', '2023-04-24 05:58:54'),
(25, 99, 6, 24, 1, 1, '2023-04-11 06:21:41', '2023-04-24 05:58:54'),
(26, 99, 6, 25, 1, 1, '2023-04-11 06:21:41', '2023-04-24 05:58:54'),
(27, 99, 6, 26, 1, 1, '2023-04-11 06:21:41', '2023-04-24 05:58:54'),
(28, 99, 6, 27, 1, 1, '2023-04-11 06:21:41', '2023-04-24 05:58:54'),
(29, 105, 7, 19, 1, 3, '2023-04-12 10:49:30', '2023-05-08 23:58:19'),
(30, 105, 7, 20, 1, 3, '2023-04-12 10:49:30', '2023-05-08 23:58:19'),
(31, 105, 7, 21, 1, 3, '2023-04-12 10:49:30', '2023-05-08 23:58:19'),
(32, 105, 7, 22, 1, 3, '2023-04-12 10:49:30', '2023-05-08 23:58:19'),
(33, 105, 7, 23, 1, 3, '2023-04-12 10:49:30', '2023-05-08 23:58:19'),
(34, 105, 7, 24, 1, 3, '2023-04-12 10:49:30', '2023-05-08 23:58:19'),
(35, 105, 8, 19, 1, 1, '2023-05-09 05:28:19', '2023-05-09 05:28:19'),
(36, 105, 8, 20, 1, 1, '2023-05-09 05:28:19', '2023-05-09 05:28:19'),
(37, 105, 8, 21, 1, 1, '2023-05-09 05:28:19', '2023-05-09 05:28:19'),
(38, 105, 8, 22, 1, 1, '2023-05-09 05:28:19', '2023-05-09 05:28:19'),
(39, 105, 8, 23, 1, 1, '2023-05-09 05:28:19', '2023-05-09 05:28:19'),
(40, 105, 8, 24, 1, 1, '2023-05-09 05:28:19', '2023-05-09 05:28:19');

-- --------------------------------------------------------

--
-- Table structure for table `job_domain_area`
--

CREATE TABLE `job_domain_area` (
  `id` int(11) NOT NULL,
  `rn_no_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `domain_area_id` int(11) NOT NULL COMMENT 'from codes - domain_area',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 for active,\r\n2 for inactive,\r\n3 for delete',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `job_domain_area`
--

INSERT INTO `job_domain_area` (`id`, `rn_no_id`, `job_id`, `domain_area_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 10, 2, 29, 1, '2023-03-02 11:54:37', '2023-03-02 11:54:37'),
(2, 10, 2, 30, 3, '2023-03-02 11:59:25', '2023-03-02 06:29:41'),
(3, 10, 2, 30, 1, '2023-03-02 12:00:21', '2023-03-02 12:00:21'),
(4, 1, 1, 29, 1, '2023-03-14 04:23:31', '2023-03-14 04:23:31');

-- --------------------------------------------------------

--
-- Table structure for table `job_min_education_trans`
--

CREATE TABLE `job_min_education_trans` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `job_validation_id` int(11) NOT NULL,
  `education_id` int(11) NOT NULL COMMENT 'code_name_id from Education Master',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 - for active,\r\n2 - for inactive,\r\n3 - for delete',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `job_min_education_trans`
--

INSERT INTO `job_min_education_trans` (`id`, `post_id`, `job_validation_id`, `education_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 99, 1, 16, 3, '2023-03-09 05:55:10', '2023-03-09 00:33:13'),
(2, 99, 1, 16, 3, '2023-03-09 06:03:00', '2023-03-09 00:33:13'),
(3, 99, 2, 16, 3, '2023-03-09 06:03:13', '2023-03-15 03:51:42'),
(4, 105, 3, 16, 3, '2023-03-15 09:21:42', '2023-03-16 04:24:34'),
(5, 105, 4, 15, 3, '2023-03-16 09:54:34', '2023-03-20 23:40:12'),
(6, 105, 4, 16, 3, '2023-03-16 09:54:34', '2023-03-20 23:40:12'),
(7, 105, 5, 15, 3, '2023-03-21 05:10:12', '2023-04-12 05:19:30'),
(8, 105, 5, 16, 3, '2023-03-21 05:10:12', '2023-04-12 05:19:30'),
(9, 99, 6, 14, 1, '2023-04-11 06:21:41', '2023-04-11 06:21:41'),
(10, 99, 6, 15, 1, '2023-04-11 06:21:41', '2023-04-11 06:21:41'),
(11, 99, 6, 16, 1, '2023-04-11 06:21:41', '2023-04-11 06:21:41'),
(12, 105, 7, 15, 3, '2023-04-12 10:49:30', '2023-05-08 23:58:19'),
(13, 105, 7, 16, 3, '2023-04-12 10:49:30', '2023-05-08 23:58:19'),
(14, 105, 8, 15, 1, '2023-05-09 05:28:19', '2023-05-09 05:28:19'),
(15, 105, 8, 16, 1, '2023-05-09 05:28:19', '2023-05-09 05:28:19');

-- --------------------------------------------------------

--
-- Table structure for table `job_min_experience_trans`
--

CREATE TABLE `job_min_experience_trans` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `job_validation_id` int(11) NOT NULL,
  `education_id` int(11) NOT NULL COMMENT 'code_name_id : from code_names Education Master',
  `years` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 - for active,\r\n2 - for inactive,\r\n3 - for delete',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `job_min_experience_trans`
--

INSERT INTO `job_min_experience_trans` (`id`, `post_id`, `job_validation_id`, `education_id`, `years`, `status`, `created_at`, `updated_at`) VALUES
(1, 99, 1, 16, 2, 3, '2023-03-09 05:55:10', '2023-03-09 00:33:13'),
(2, 99, 1, 16, 2, 3, '2023-03-09 06:03:00', '2023-03-09 00:33:13'),
(3, 99, 2, 16, 2, 3, '2023-03-09 06:03:13', '2023-03-15 03:51:42'),
(4, 105, 3, 16, 2, 3, '2023-03-15 09:21:42', '2023-03-16 04:24:34'),
(5, 105, 4, 16, 2, 3, '2023-03-16 09:54:34', '2023-03-20 23:40:12'),
(6, 105, 5, 16, 2, 3, '2023-03-21 05:10:12', '2023-04-12 05:19:30'),
(7, 105, 7, 16, 2, 3, '2023-04-12 10:49:30', '2023-05-08 23:58:19'),
(8, 105, 8, 16, 2, 1, '2023-05-09 05:28:19', '2023-05-09 05:28:19');

-- --------------------------------------------------------

--
-- Table structure for table `job_validation`
--

CREATE TABLE `job_validation` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `is_age_validate` int(11) NOT NULL DEFAULT 0,
  `is_exp_tab` int(11) DEFAULT NULL,
  `is_publication_tab` int(11) DEFAULT NULL,
  `is_patent_tab` int(11) DEFAULT NULL,
  `is_research_tab` int(11) DEFAULT NULL,
  `is_proposal_tab` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 - for active,\r\n2 - for inactive,\r\n3 - for delete',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `job_validation`
--

INSERT INTO `job_validation` (`id`, `post_id`, `is_age_validate`, `is_exp_tab`, `is_publication_tab`, `is_patent_tab`, `is_research_tab`, `is_proposal_tab`, `status`, `created_at`, `updated_at`) VALUES
(1, 99, 0, 1, 0, 0, 0, 0, 3, '2023-03-09 00:33:00', '2023-03-09 00:33:13'),
(2, 99, 0, 1, 0, 0, 0, 0, 3, '2023-03-09 00:33:13', '2023-03-15 03:51:42'),
(3, 105, 0, 1, 0, 0, 0, 0, 3, '2023-03-15 03:51:42', '2023-03-16 04:24:34'),
(4, 105, 0, 1, 0, 0, 0, 0, 3, '2023-03-16 04:24:34', '2023-03-20 23:40:12'),
(5, 105, 0, 1, 1, 1, 1, 1, 3, '2023-03-20 23:40:12', '2023-04-12 05:19:30'),
(6, 99, 0, 1, 0, 0, 0, 0, 1, '2023-04-11 00:51:41', '2023-04-11 00:51:41'),
(7, 105, 0, 1, 1, 1, 1, 1, 3, '2023-04-12 05:19:30', '2023-05-08 23:58:19'),
(8, 105, 0, 1, 1, 1, 1, 1, 1, '2023-05-08 23:58:19', '2023-05-08 23:58:19');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_01_31_090858_create_rn_nos_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `register_candidates`
--

CREATE TABLE `register_candidates` (
  `id` int(11) NOT NULL,
  `email_id` varchar(255) NOT NULL,
  `mobile_no` varchar(255) NOT NULL,
  `salutation` int(11) DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `mother_name` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` int(11) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `correspondence_address` varchar(900) NOT NULL,
  `cors_state_id` int(11) DEFAULT NULL,
  `cors_city` varchar(255) DEFAULT NULL,
  `cors_pincode` varchar(255) DEFAULT NULL,
  `permanent_address` varchar(900) DEFAULT NULL,
  `perm_state_id` int(11) DEFAULT NULL,
  `perm_city` varchar(255) DEFAULT NULL,
  `perm_pincode` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 for active,\r\n2 for inactive,\r\n3 for delete',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `register_candidates`
--

INSERT INTO `register_candidates` (`id`, `email_id`, `mobile_no`, `salutation`, `full_name`, `father_name`, `mother_name`, `dob`, `gender`, `nationality`, `correspondence_address`, `cors_state_id`, `cors_city`, `cors_pincode`, `permanent_address`, `perm_state_id`, `perm_city`, `perm_pincode`, `status`, `created_at`, `updated_at`) VALUES
(1, 'kambojanuj1992@gmail.com', '9517886722', 35, 'Anuj Kamboj', 'Kamal Kumar Kamboj', 'Saroj Devi', '1992-03-02', 111, 'India', '#86 Sec 19', 72, 'Panchkula', '134113', '#86 Sec 19', 72, 'Panchkula', '134113', 1, '2023-03-14 04:55:38', '2023-05-09 05:50:26'),
(2, 'asdf@gmail.com', '9898989898', 35, 'asdf', 'fgda', 'werewrw', '2023-05-10', 111, 'fdfsa', 'fdsfa', 76, 'dfsd', '123456', 'fdsfa', 76, 'dfsd', '123456', 1, '2023-05-12 01:14:56', '2023-05-12 07:20:38');

-- --------------------------------------------------------

--
-- Table structure for table `rn_nos`
--

CREATE TABLE `rn_nos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rn_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rn_type_id` int(11) NOT NULL COMMENT '	from code_names - RN No Type',
  `ths_rn_type_id` int(11) DEFAULT NULL COMMENT 'will contain id for THS\r\nfor CDSA will be null',
  `sequence_no` int(11) DEFAULT NULL COMMENT 'will store Sequence no',
  `rn_document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
  `cycle` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 - active,\r\n2 - inactive,\r\n3 - delete',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rn_nos`
--

INSERT INTO `rn_nos` (`id`, `rn_no`, `rn_type_id`, `ths_rn_type_id`, `sequence_no`, `rn_document`, `year`, `month`, `cycle`, `status`, `created_at`, `updated_at`) VALUES
(1, 'THSTI/RN/36/2023', 109, 3, 36, NULL, 2023, NULL, NULL, 1, '2023-01-31 05:54:04', '2023-02-01 01:30:05'),
(10, 'THSTI/RN/37/2023', 109, 3, 37, 'SchemeInfo.pdf', 2023, NULL, NULL, 1, '2023-02-07 01:01:29', '2023-03-01 00:12:26'),
(12, 'THSTI/12/36/THSTI', 109, 3, NULL, NULL, 2023, NULL, NULL, 3, '2023-03-01 00:16:58', '2023-03-01 00:16:58'),
(17, 'THS/RN/01/2023/03-I', 109, 115, 1, NULL, 2023, 3, 1, 1, '2023-03-27 04:33:14', '2023-03-27 04:33:14'),
(18, 'THS/RN/02/2023/03-I', 109, 116, 2, NULL, 2023, 3, 1, 1, '2023-03-27 04:33:36', '2023-03-27 04:33:36'),
(21, 'THS-C/RN/01/2023', 110, 115, 1, NULL, 2023, 3, 0, 1, '2023-03-27 05:59:29', '2023-03-27 05:59:29'),
(22, 'THS/RN/01/2023/04-I', 109, 115, 1, NULL, 2023, 4, 1, 1, '2023-04-06 04:02:43', '2023-04-06 04:02:43'),
(23, 'THS/RN/02/2023', 109, 117, 2, NULL, 2023, NULL, NULL, 1, '2023-04-06 04:03:33', '2023-04-06 04:03:33');

-- --------------------------------------------------------

--
-- Table structure for table `rn_type_details`
--

CREATE TABLE `rn_type_details` (
  `id` int(11) NOT NULL,
  `rn_type_id` int(11) NOT NULL COMMENT 'from code_names - RN No Type',
  `prefix` varchar(255) DEFAULT NULL,
  `suffix` varchar(255) DEFAULT NULL,
  `sequence_start_from` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 for active,\r\n2 for inactive,\r\n3 for delete',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rn_type_details`
--

INSERT INTO `rn_type_details` (`id`, `rn_type_id`, `prefix`, `suffix`, `sequence_start_from`, `status`, `created_at`, `updated_at`) VALUES
(1, 109, 'THS/RN', NULL, 1, 1, '2023-03-09 04:41:34', '2023-03-27 06:20:57'),
(3, 110, 'THS-C/RN', NULL, 1, 1, '2023-03-27 06:50:17', '2023-03-27 06:50:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Anuj Kamboj', 'kambojanuj1992@gmail.com', NULL, '$2y$10$o5sd5Me8mtlqNX9hMezGJ.4AsdacsCYHV0/T0qtFB5PVtGkwqywvG', NULL, '2023-01-25 06:35:33', '2023-01-25 06:35:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apply_job_hr_remarks`
--
ALTER TABLE `apply_job_hr_remarks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `candidates_academics_details`
--
ALTER TABLE `candidates_academics_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `candidates_academics_documents`
--
ALTER TABLE `candidates_academics_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `candidates_common_documents`
--
ALTER TABLE `candidates_common_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `candidates_experience_details`
--
ALTER TABLE `candidates_experience_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `candidates_experience_documents`
--
ALTER TABLE `candidates_experience_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `candidates_jobs_apply`
--
ALTER TABLE `candidates_jobs_apply`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `candidates_job_hr_remarks`
--
ALTER TABLE `candidates_job_hr_remarks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `candidates_phd_research_details`
--
ALTER TABLE `candidates_phd_research_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `candidates_publications_details`
--
ALTER TABLE `candidates_publications_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `candidates_refree_details`
--
ALTER TABLE `candidates_refree_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `code_master`
--
ALTER TABLE `code_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `code_names`
--
ALTER TABLE `code_names`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code_master_id` (`code_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fee_crone_job`
--
ALTER TABLE `fee_crone_job`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fee_crone_job_trans`
--
ALTER TABLE `fee_crone_job_trans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fee_status_transactions`
--
ALTER TABLE `fee_status_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fee_transactions`
--
ALTER TABLE `fee_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_configuration`
--
ALTER TABLE `form_configuration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_fields_configuration`
--
ALTER TABLE `form_fields_configuration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_field_options`
--
ALTER TABLE `form_field_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_field_types`
--
ALTER TABLE `form_field_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_tabs`
--
ALTER TABLE `form_tabs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_tab_fields`
--
ALTER TABLE `form_tab_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code_name_id` (`rn_no_id`),
  ADD KEY `job_type_id` (`job_type_id`),
  ADD KEY `center_id` (`center_id`);

--
-- Indexes for table `job_age_limit_validation_trans`
--
ALTER TABLE `job_age_limit_validation_trans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_validation_id` (`job_validation_id`);

--
-- Indexes for table `job_application_fee_trans`
--
ALTER TABLE `job_application_fee_trans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_domain_area`
--
ALTER TABLE `job_domain_area`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_min_education_trans`
--
ALTER TABLE `job_min_education_trans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_min_experience_trans`
--
ALTER TABLE `job_min_experience_trans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_validation`
--
ALTER TABLE `job_validation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `register_candidates`
--
ALTER TABLE `register_candidates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rn_nos`
--
ALTER TABLE `rn_nos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rn_type_details`
--
ALTER TABLE `rn_type_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apply_job_hr_remarks`
--
ALTER TABLE `apply_job_hr_remarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `candidates_academics_details`
--
ALTER TABLE `candidates_academics_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `candidates_academics_documents`
--
ALTER TABLE `candidates_academics_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `candidates_common_documents`
--
ALTER TABLE `candidates_common_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `candidates_experience_details`
--
ALTER TABLE `candidates_experience_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `candidates_experience_documents`
--
ALTER TABLE `candidates_experience_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `candidates_jobs_apply`
--
ALTER TABLE `candidates_jobs_apply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `candidates_job_hr_remarks`
--
ALTER TABLE `candidates_job_hr_remarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `candidates_phd_research_details`
--
ALTER TABLE `candidates_phd_research_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `candidates_publications_details`
--
ALTER TABLE `candidates_publications_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `candidates_refree_details`
--
ALTER TABLE `candidates_refree_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `code_master`
--
ALTER TABLE `code_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `code_names`
--
ALTER TABLE `code_names`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fee_crone_job`
--
ALTER TABLE `fee_crone_job`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fee_crone_job_trans`
--
ALTER TABLE `fee_crone_job_trans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fee_status_transactions`
--
ALTER TABLE `fee_status_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fee_transactions`
--
ALTER TABLE `fee_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `form_configuration`
--
ALTER TABLE `form_configuration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `form_fields_configuration`
--
ALTER TABLE `form_fields_configuration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT for table `form_field_options`
--
ALTER TABLE `form_field_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_field_types`
--
ALTER TABLE `form_field_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `form_tabs`
--
ALTER TABLE `form_tabs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `form_tab_fields`
--
ALTER TABLE `form_tab_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `job_age_limit_validation_trans`
--
ALTER TABLE `job_age_limit_validation_trans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `job_application_fee_trans`
--
ALTER TABLE `job_application_fee_trans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `job_domain_area`
--
ALTER TABLE `job_domain_area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `job_min_education_trans`
--
ALTER TABLE `job_min_education_trans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `job_min_experience_trans`
--
ALTER TABLE `job_min_experience_trans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `job_validation`
--
ALTER TABLE `job_validation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `register_candidates`
--
ALTER TABLE `register_candidates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rn_nos`
--
ALTER TABLE `rn_nos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `rn_type_details`
--
ALTER TABLE `rn_type_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
