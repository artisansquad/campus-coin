-- =========================================================
-- Campus Coin: Database Schema & Test Data Export
-- Generated: 2026-09-27 08:31:59
-- Database: artisan
-- =========================================================

SET FOREIGN_KEY_CHECKS=0;

-- ---------------------------------------------------------
-- Table structure for table `ai_learnings`
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `ai_learnings`;
CREATE TABLE `ai_learnings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `keyword` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `confidence` double NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ai_learnings_category_id_foreign` (`category_id`),
  KEY `ai_learnings_user_id_keyword_index` (`user_id`,`keyword`),
  KEY `ai_learnings_keyword_index` (`keyword`),
  CONSTRAINT `ai_learnings_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ai_learnings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for table `budgets`
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `budgets`;
CREATE TABLE `budgets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `month` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `limit_amount` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `budgets_user_id_category_id_month_unique` (`user_id`,`category_id`,`month`),
  KEY `budgets_category_id_foreign` (`category_id`),
  CONSTRAINT `budgets_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `budgets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for table `cache`
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for table `cache_locks`
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for table `categories`
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('income','expense') COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tag',
  `color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#3B82F6',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categories_user_id_foreign` (`user_id`),
  CONSTRAINT `categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for table `contact_messages`
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE `contact_messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_messages_user_id_foreign` (`user_id`),
  KEY `contact_messages_status_created_at_index` (`status`,`created_at`),
  CONSTRAINT `contact_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for table `failed_jobs`
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for table `in_app_notifications`
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `in_app_notifications`;
CREATE TABLE `in_app_notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sender_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sender_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_message_id` bigint unsigned DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'info',
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `in_app_notifications_user_id_is_read_index` (`user_id`,`is_read`),
  KEY `in_app_notifications_contact_message_id_foreign` (`contact_message_id`),
  CONSTRAINT `in_app_notifications_contact_message_id_foreign` FOREIGN KEY (`contact_message_id`) REFERENCES `contact_messages` (`id`) ON DELETE SET NULL,
  CONSTRAINT `in_app_notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for table `insights`
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `insights`;
CREATE TABLE `insights` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `month` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `flagged_category` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `growth_percentage` decimal(6,2) DEFAULT NULL,
  `tip_text` text COLLATE utf8mb4_unicode_ci,
  `is_bookmarked` tinyint(1) NOT NULL DEFAULT '0',
  `generated_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `insights_user_id_month_index` (`user_id`,`month`),
  CONSTRAINT `insights_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for table `job_batches`
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for table `jobs`
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for table `migrations`
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `migrations`
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('1', '0001_01_01_000000_create_users_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('2', '0001_01_01_000001_create_cache_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('3', '0001_01_01_000002_create_jobs_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('4', '2026_09_24_074536_create_categories_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('5', '2026_09_24_184234_create_password_reset_otps_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('6', '2026_09_25_145546_create_transactions_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('7', '2026_09_25_145547_create_budgets_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('8', '2026_09_25_145548_create_insights_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('9', '2026_09_25_145549_create_saving_tips_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('10', '2026_09_25_145550_create_ai_learnings_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('11', '2026_09_25_145551_create_in_app_notifications_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('12', '2026_09_26_122540_create_contact_messages_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('13', '2026_09_26_123000_add_sender_fields_to_in_app_notifications_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('14', '2026_09_26_141035_create_platform_analytics_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('15', '2026_09_27_071212_create_user_dashboards_table', '1');

-- ---------------------------------------------------------
-- Table structure for table `password_reset_otps`
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `password_reset_otps`;
CREATE TABLE `password_reset_otps` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `password_reset_otps_email_index` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for table `password_reset_tokens`
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for table `platform_analytics`
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `platform_analytics`;
CREATE TABLE `platform_analytics` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `metric_key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'kpi',
  `period` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '12m',
  `value` decimal(15,2) NOT NULL DEFAULT '0.00',
  `change` decimal(10,2) NOT NULL DEFAULT '0.00',
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suffix` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `platform_analytics_metric_key_period_unique` (`metric_key`,`period`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for table `saving_tips`
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `saving_tips`;
CREATE TABLE `saving_tips` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `impact_amount` decimal(10,2) DEFAULT NULL,
  `category` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_pinned` tinyint(1) NOT NULL DEFAULT '0',
  `is_dismissed` tinyint(1) NOT NULL DEFAULT '0',
  `is_bookmarked` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `saving_tips_user_id_foreign` (`user_id`),
  CONSTRAINT `saving_tips_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for table `sessions`
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for table `transactions`
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `type` enum('income','expense') COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `date` date NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_recurring` tinyint(1) NOT NULL DEFAULT '0',
  `recurring_frequency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ai_suggested_category_id` bigint unsigned DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `is_flagged` tinyint(1) NOT NULL DEFAULT '0',
  `flag_reason` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transactions_category_id_foreign` (`category_id`),
  KEY `transactions_ai_suggested_category_id_foreign` (`ai_suggested_category_id`),
  KEY `transactions_user_id_date_index` (`user_id`,`date`),
  KEY `transactions_user_id_type_index` (`user_id`,`type`),
  CONSTRAINT `transactions_ai_suggested_category_id_foreign` FOREIGN KEY (`ai_suggested_category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `transactions_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for table `user_dashboards`
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `user_dashboards`;
CREATE TABLE `user_dashboards` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `month` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `net_balance` decimal(12,2) NOT NULL DEFAULT '0.00',
  `monthly_income` decimal(12,2) NOT NULL DEFAULT '0.00',
  `monthly_expense` decimal(12,2) NOT NULL DEFAULT '0.00',
  `monthly_savings_goal` decimal(12,2) NOT NULL DEFAULT '0.00',
  `saving_rate` decimal(5,2) NOT NULL DEFAULT '0.00',
  `top_category` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `top_category_percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
  `summary_json` json DEFAULT NULL,
  `last_updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_dashboards_user_id_month_unique` (`user_id`,`month`),
  CONSTRAINT `user_dashboards_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for table `users`
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'student',
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `age` int DEFAULT NULL,
  `academic_year` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preferred_currency` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PKR',
  `monthly_allowance_baseline` decimal(12,2) NOT NULL DEFAULT '0.00',
  `monthly_savings_goal` decimal(12,2) NOT NULL DEFAULT '0.00',
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS=1;
