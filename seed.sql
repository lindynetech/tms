-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 17, 2019 at 01:49 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tms-cloud`
--

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE `billing` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_date` timestamp NULL DEFAULT NULL,
  `payment_amount` decimal(8,2) DEFAULT NULL,
  `paid_till` timestamp NULL DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Free Trial',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `billing`
--

INSERT INTO `billing` (`id`, `user_id`, `payment_method`, `payment_date`, `payment_amount`, `paid_till`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, NULL, NULL, 'Free Trial', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `daily_goals`
--

CREATE TABLE `daily_goals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `goal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `urgency` tinyint(3) UNSIGNED NOT NULL,
  `deadline` date NOT NULL,
  `type` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `daily_goals`
--

INSERT INTO `daily_goals` (`id`, `user_id`, `goal`, `priority`, `urgency`, `deadline`, `type`) VALUES
(1, 1, 'Complete AWS Solutions Architect Certification', 'A', 1, '2025-03-15', 'Self-Development'),
(2, 1, 'Launch new product feature by Q2', 'B', 2, '2025-06-30', 'Business');

-- --------------------------------------------------------

--
-- Table structure for table `goals`
--

CREATE TABLE `goals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `goal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `urgency` tinyint(3) UNSIGNED NOT NULL,
  `deadline` date NOT NULL,
  `status` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stage` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `smart` tinyint(1) NOT NULL DEFAULT '0',
  `type` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `goals`
--

INSERT INTO `goals` (`id`, `user_id`, `goal`, `priority`, `urgency`, `deadline`, `status`, `stage`, `smart`, `type`, `created_at`, `updated_at`) VALUES
(1, 1, 'Master Python and build 5 production applications by December 2025', 'A', 1, '2025-12-31', 'In Progress', 'Execution', 1, 'Self-Development', '2025-01-15 08:00:00', '2025-01-20 10:30:00'),
(2, 1, 'Increase monthly revenue to $50,000 by Q4 2025', 'A', 2, '2025-10-31', 'In Progress', 'Planning', 1, 'Business', '2025-01-10 09:15:00', '2025-01-18 14:20:00');

-- --------------------------------------------------------

--
-- Table structure for table `goals_subtasks`
--

CREATE TABLE `goals_subtasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tid` bigint(20) UNSIGNED NOT NULL,
  `start` date NOT NULL,
  `deadline` date NOT NULL,
  `subtask` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `urgency` tinyint(3) UNSIGNED NOT NULL,
  `status` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Not Started',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `goals_subtasks`
--

INSERT INTO `goals_subtasks` (`id`, `tid`, `start`, `deadline`, `subtask`, `priority`, `urgency`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-02-01', '2025-02-15', 'Complete Django tutorial and build REST API', 'A', 1, 'In Progress', '2025-01-15 10:00:00', '2025-01-20 15:30:00'),
(2, 1, '2025-02-16', '2025-03-01', 'Deploy application to AWS with CI/CD pipeline', 'A', 2, 'Not Started', '2025-01-15 10:05:00', '2025-01-15 10:05:00');

-- --------------------------------------------------------

--
-- Table structure for table `goals_tasks`
--

CREATE TABLE `goals_tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gid` bigint(20) UNSIGNED NOT NULL,
  `vid` bigint(20) UNSIGNED NOT NULL,
  `start` date NOT NULL,
  `deadline` date NOT NULL,
  `task` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'task',
  `priority` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `urgency` tinyint(3) UNSIGNED NOT NULL,
  `status` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Not Started',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `goals_tasks`
--

INSERT INTO `goals_tasks` (`id`, `gid`, `vid`, `start`, `deadline`, `task`, `type`, `priority`, `urgency`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-01-20', '2025-03-15', 'Complete Python advanced course and build portfolio project', 'Task', 'A', 1, 'In Progress', '2025-01-15 08:30:00', '2025-01-20 11:00:00'),
(2, 2, 1, '2025-01-25', '2025-04-30', 'Launch marketing campaign and optimize conversion funnel', 'Task', 'A', 1, 'In Progress', '2025-01-10 09:30:00', '2025-01-18 16:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `habits`
--

CREATE TABLE `habits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start` date NOT NULL,
  `status` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `freq` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Daily',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `habits_days`
--

CREATE TABLE `habits_days` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hid` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `time` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `day` tinyint(3) UNSIGNED NOT NULL,
  `check` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(3, '2016_03_01_032612_create_vendors_table', 1),
(4, '2019_06_14_005606_create_billing_table', 1),
(5, '2019_06_14_011841_create_goals_table', 1),
(6, '2019_06_14_013745_create_goals_tasks_table', 1),
(7, '2019_06_14_013804_create_goals_sub_tasks_table', 1),
(8, '2019_06_14_021218_create_habits_table', 1),
(9, '2019_06_14_021233_create_habits_days_table', 1),
(10, '2019_06_14_022815_create_mindstorms_table', 1),
(11, '2019_06_14_022823_create_mindstorms_ideas_table', 1),
(12, '2019_06_14_023742_create_readinglist_table', 1),
(13, '2019_06_14_025259_create_daily_goals_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mindstorms`
--

CREATE TABLE `mindstorms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `smart` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mindstorms`
--

INSERT INTO `mindstorms` (`id`, `user_id`, `question`, `status`, `smart`, `created_at`, `updated_at`) VALUES
(2, 1, 'What steps to take to quit smoking by the end of July?', 'Not Started', 1, '2019-06-26 02:50:16', '2019-06-26 02:50:16');

-- --------------------------------------------------------

--
-- Table structure for table `mindstorms_ideas`
--

CREATE TABLE `mindstorms_ideas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gid` bigint(20) UNSIGNED NOT NULL,
  `idea` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `urgency` tinyint(3) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mindstorms_ideas`
--

INSERT INTO `mindstorms_ideas` (`id`, `gid`, `idea`, `priority`, `urgency`, `created_at`, `updated_at`) VALUES
(1, 2, 'Start wearing patches', 'A', 1, '2019-06-26 03:18:15', '2019-06-26 03:18:15'),
(2, 2, 'Start exercises', 'A', 2, '2019-06-26 03:18:28', '2019-06-26 03:18:28'),
(3, 2, 'Avoid being stressed, take a short vacation', 'A', 3, '2019-06-26 03:18:44', '2019-06-26 03:18:44'),
(4, 2, 'Avoid meeting anybody who smokes', 'B', 1, '2019-06-26 03:19:10', '2019-06-26 03:19:10'),
(5, 2, '...', 'C', 1, '2019-06-26 03:19:15', '2019-06-26 03:19:22');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('admin@tms.dev', '$2y$10$806tSG1AWkSgAd8aBxae..Ga2eB93AOCIDjk6xy10j4uOkKaNM9wa', '2019-06-18 07:51:44');

-- --------------------------------------------------------

--
-- Table structure for table `readinglist`
--

CREATE TABLE `readinglist` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `readinglist`
--

INSERT INTO `readinglist` (`id`, `user_id`, `title`, `category`, `priority`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'CCNA Routing and Switching Complete Guide Exam 200-125, Lammle T.', 'Cisco', 'A', 'Reading', '2019-06-26 02:42:07', '2019-06-26 02:42:07'),
(2, 1, 'The Phoenix Project _ A Novel about IT, DevOps, and Helping Your Business Win', 'IT', 'B', 'Pending', '2019-06-26 02:42:47', '2019-06-26 02:42:47'),
(3, 1, 'Kubernetes Deep Dive, Nigel Poulton', 'DevOps', 'A', 'Reading', '2019-06-26 02:43:30', '2019-06-26 02:43:49');

-- --------------------------------------------------------

--
-- Table structure for table `readinglist_notes`
--

CREATE TABLE `readinglist_notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bid` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `readinglist_notes`
--

INSERT INTO `readinglist_notes` (`id`, `bid`, `title`, `description`) VALUES
(1, 1, 'Chapter 1: Introduction', '<p>Basic networking concepts and OSI model overview</p>'),
(2, 1, 'Chapter 2: Ethernet', '<p>Ethernet standards and frame structure</p>');

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
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@tms.dev', NULL, '$2y$12$X.No6IspXLs0JdwyT6.yB.WvAVUukWEJxd0h0XnWcaH3O7lxbpGci', 1, '35kOYf4RYWGddrZkN17SnNlvXjbm3HZUPsOSsQ6E1MGd6RU1oo2GBFGDVNJe', '2019-06-15 07:35:19', '2019-06-15 07:35:19');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Assignee',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `contact` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `user_id`, `name`, `role`, `status`, `contact`, `created_at`, `updated_at`) VALUES
(1, 1, 'Admin', 'Assignee', 'Active', 'admin@tms.dev', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `billing`
--
ALTER TABLE `billing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `billing_user_id_foreign` (`user_id`);

--
-- Indexes for table `daily_goals`
--
ALTER TABLE `daily_goals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `daily_goals_user_id_foreign` (`user_id`);

--
-- Indexes for table `goals`
--
ALTER TABLE `goals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goals_user_id_foreign` (`user_id`);

--
-- Indexes for table `goals_subtasks`
--
ALTER TABLE `goals_subtasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goals_subtasks_tid_foreign` (`tid`);

--
-- Indexes for table `goals_tasks`
--
ALTER TABLE `goals_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goals_tasks_gid_foreign` (`gid`),
  ADD KEY `goals_tasks_vid_foreign` (`vid`);

--
-- Indexes for table `habits`
--
ALTER TABLE `habits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `habits_user_id_foreign` (`user_id`);

--
-- Indexes for table `habits_days`
--
ALTER TABLE `habits_days`
  ADD PRIMARY KEY (`id`),
  ADD KEY `habits_days_hid_foreign` (`hid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mindstorms`
--
ALTER TABLE `mindstorms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mindstorms_user_id_foreign` (`user_id`);

--
-- Indexes for table `mindstorms_ideas`
--
ALTER TABLE `mindstorms_ideas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mindstorms_ideas_gid_foreign` (`gid`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `readinglist`
--
ALTER TABLE `readinglist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `readinglist_user_id_foreign` (`user_id`);

--
-- Indexes for table `readinglist_notes`
--
ALTER TABLE `readinglist_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `readinglist_notes_bid_foreign` (`bid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendors_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `billing`
--
ALTER TABLE `billing`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `daily_goals`
--
ALTER TABLE `daily_goals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `goals`
--
ALTER TABLE `goals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `goals_subtasks`
--
ALTER TABLE `goals_subtasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `goals_tasks`
--
ALTER TABLE `goals_tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `habits`
--
ALTER TABLE `habits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `habits_days`
--
ALTER TABLE `habits_days`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `mindstorms`
--
ALTER TABLE `mindstorms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mindstorms_ideas`
--
ALTER TABLE `mindstorms_ideas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `readinglist`
--
ALTER TABLE `readinglist`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `readinglist_notes`
--
ALTER TABLE `readinglist_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `billing`
--
ALTER TABLE `billing`
  ADD CONSTRAINT `billing_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `daily_goals`
--
ALTER TABLE `daily_goals`
  ADD CONSTRAINT `daily_goals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `goals`
--
ALTER TABLE `goals`
  ADD CONSTRAINT `goals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `goals_subtasks`
--
ALTER TABLE `goals_subtasks`
  ADD CONSTRAINT `goals_subtasks_tid_foreign` FOREIGN KEY (`tid`) REFERENCES `goals_tasks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `goals_tasks`
--
ALTER TABLE `goals_tasks`
  ADD CONSTRAINT `goals_tasks_gid_foreign` FOREIGN KEY (`gid`) REFERENCES `goals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `goals_tasks_vid_foreign` FOREIGN KEY (`vid`) REFERENCES `vendors` (`id`);

--
-- Constraints for table `habits`
--
ALTER TABLE `habits`
  ADD CONSTRAINT `habits_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `habits_days`
--
ALTER TABLE `habits_days`
  ADD CONSTRAINT `habits_days_hid_foreign` FOREIGN KEY (`hid`) REFERENCES `habits` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mindstorms`
--
ALTER TABLE `mindstorms`
  ADD CONSTRAINT `mindstorms_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mindstorms_ideas`
--
ALTER TABLE `mindstorms_ideas`
  ADD CONSTRAINT `mindstorms_ideas_gid_foreign` FOREIGN KEY (`gid`) REFERENCES `mindstorms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `readinglist`
--
ALTER TABLE `readinglist`
  ADD CONSTRAINT `readinglist_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `readinglist_notes`
--
ALTER TABLE `readinglist_notes`
  ADD CONSTRAINT `readinglist_notes_bid_foreign` FOREIGN KEY (`bid`) REFERENCES `readinglist` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vendors`
--
ALTER TABLE `vendors`
  ADD CONSTRAINT `vendors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
