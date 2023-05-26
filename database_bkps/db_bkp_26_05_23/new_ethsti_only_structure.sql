-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2023 at 12:57 PM
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
  `is_basic_info_done` int(11) NOT NULL DEFAULT 0 COMMENT '1 for Yes,\r\n0 for No',
  `is_qualification_exp_done` int(11) NOT NULL DEFAULT 0 COMMENT '1 for Yes,\r\n0 for No',
  `is_phd_details_done` int(11) NOT NULL DEFAULT 0 COMMENT '1 for Yes,\r\n0 for No',
  `is_document_upload_done` int(11) NOT NULL DEFAULT 0 COMMENT '1 for Yes,\r\n0 for No',
  `is_final_submission_done` int(11) NOT NULL DEFAULT 0 COMMENT '1 for Yes,\r\n0 for No',
  `is_payment_done` int(11) NOT NULL DEFAULT 0 COMMENT '1 for Yes,\r\n0 for No',
  `is_final_submit_after_payment` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 for Yes,\r\n0 for No',
  `payment_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 for pending,\r\n1 for success,\r\n2 for Failed',
  `is_completed` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 for No,\r\n1 for Yes',
  `is_screened` int(11) DEFAULT 0 COMMENT ' 0 for No,\r\n1 for Yes',
  `shortlisting_status` int(11) DEFAULT NULL COMMENT '1 - shortlisted,\r\n2 - rejected,\r\n3 - provisional shortlisted',
  `hr_additional_remarks` text DEFAULT NULL,
  `details_pdf_name` varchar(255) DEFAULT NULL,
  `pay_receipt_pdf_name` varchar(255) DEFAULT NULL,
  `is_after_payment_mail_sent` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 - sent,\r\n0 - pending',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 for active,\r\n2 for inactive,\r\n3 for delete',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Table structure for table `exam_centers`
--

CREATE TABLE `exam_centers` (
  `id` int(11) NOT NULL,
  `centre_name` text DEFAULT NULL,
  `centre_address` text DEFAULT NULL,
  `centre_location` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 - Active,\r\n2 - Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `exam_center_mapping`
--

CREATE TABLE `exam_center_mapping` (
  `id` int(11) NOT NULL,
  `rn_no_id` int(11) DEFAULT NULL,
  `job_id` int(11) DEFAULT NULL,
  `exam_center_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 - active,\r\n2 - inactive,\r\n3 - deleted',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `nationality_type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 for India,\r\n2 for Foreigner',
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

-- --------------------------------------------------------

--
-- Table structure for table `registration_otp`
--

CREATE TABLE `registration_otp` (
  `id` int(11) NOT NULL,
  `email_id` varchar(900) NOT NULL,
  `otp` varchar(10) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1 for success,\r\n0 for fail',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Indexes for table `exam_centers`
--
ALTER TABLE `exam_centers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_center_mapping`
--
ALTER TABLE `exam_center_mapping`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `registration_otp`
--
ALTER TABLE `registration_otp`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `candidates_academics_details`
--
ALTER TABLE `candidates_academics_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `candidates_academics_documents`
--
ALTER TABLE `candidates_academics_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `candidates_common_documents`
--
ALTER TABLE `candidates_common_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `candidates_experience_details`
--
ALTER TABLE `candidates_experience_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `candidates_experience_documents`
--
ALTER TABLE `candidates_experience_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `candidates_jobs_apply`
--
ALTER TABLE `candidates_jobs_apply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `candidates_job_hr_remarks`
--
ALTER TABLE `candidates_job_hr_remarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `candidates_phd_research_details`
--
ALTER TABLE `candidates_phd_research_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `candidates_publications_details`
--
ALTER TABLE `candidates_publications_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `candidates_refree_details`
--
ALTER TABLE `candidates_refree_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `code_master`
--
ALTER TABLE `code_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `code_names`
--
ALTER TABLE `code_names`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_centers`
--
ALTER TABLE `exam_centers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_center_mapping`
--
ALTER TABLE `exam_center_mapping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fee_crone_job`
--
ALTER TABLE `fee_crone_job`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fee_crone_job_trans`
--
ALTER TABLE `fee_crone_job_trans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fee_status_transactions`
--
ALTER TABLE `fee_status_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fee_transactions`
--
ALTER TABLE `fee_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_configuration`
--
ALTER TABLE `form_configuration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_fields_configuration`
--
ALTER TABLE `form_fields_configuration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_field_options`
--
ALTER TABLE `form_field_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_field_types`
--
ALTER TABLE `form_field_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_tabs`
--
ALTER TABLE `form_tabs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_tab_fields`
--
ALTER TABLE `form_tab_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_age_limit_validation_trans`
--
ALTER TABLE `job_age_limit_validation_trans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_application_fee_trans`
--
ALTER TABLE `job_application_fee_trans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_domain_area`
--
ALTER TABLE `job_domain_area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_min_education_trans`
--
ALTER TABLE `job_min_education_trans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_min_experience_trans`
--
ALTER TABLE `job_min_experience_trans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_validation`
--
ALTER TABLE `job_validation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `register_candidates`
--
ALTER TABLE `register_candidates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registration_otp`
--
ALTER TABLE `registration_otp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rn_nos`
--
ALTER TABLE `rn_nos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rn_type_details`
--
ALTER TABLE `rn_type_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
