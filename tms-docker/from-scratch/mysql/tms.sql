-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 11, 2019 at 10:47 PM
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
-- Database: `tms`
--

-- --------------------------------------------------------

--
-- Table structure for table `daily_goals`
--

CREATE TABLE `daily_goals` (
  `id` int(10) NOT NULL,
  `type` varchar(20) NOT NULL,
  `goal` varchar(255) NOT NULL,
  `priority` varchar(255) NOT NULL,
  `urgency` int(2) NOT NULL,
  `deadline` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `goals`
--

CREATE TABLE `goals` (
  `id` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `goal` varchar(255) NOT NULL,
  `priority` varchar(255) NOT NULL,
  `urgency` int(2) NOT NULL,
  `deadline` date NOT NULL,
  `status` varchar(40) NOT NULL,
  `stage` varchar(40) NOT NULL,
  `smart` tinyint(1) NOT NULL DEFAULT '0',
  `type` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `goals`
--

INSERT INTO `goals` (`id`, `created_at`, `updated_at`, `goal`, `priority`, `urgency`, `deadline`, `status`, `stage`, `smart`, `type`) VALUES
(59, '2019-06-10 01:04:21', '2019-06-10 05:04:21', 'frog goal', 'A', 1, '2019-06-09', 'In Progress', 'Execution', 1, 'Business'),
(60, '2019-06-10 05:00:28', '2019-06-10 05:00:28', 'test goal 2', 'A', 1, '2019-06-09', 'Not Started', 'Definition', 1, 'Business');

-- --------------------------------------------------------

--
-- Table structure for table `goals_subtasks`
--

CREATE TABLE `goals_subtasks` (
  `id` int(10) NOT NULL,
  `tid` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `subtask` varchar(255) NOT NULL,
  `priority` varchar(255) NOT NULL,
  `urgency` tinyint(4) NOT NULL,
  `start` date NOT NULL,
  `deadline` date NOT NULL,
  `status` varchar(40) NOT NULL DEFAULT 'Not Started'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `goals_tasks`
--

CREATE TABLE `goals_tasks` (
  `id` int(10) NOT NULL,
  `gid` int(10) NOT NULL,
  `vid` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `start` date NOT NULL,
  `task` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'task',
  `priority` varchar(4) NOT NULL,
  `urgency` tinyint(4) NOT NULL,
  `deadline` date NOT NULL,
  `status` varchar(40) NOT NULL DEFAULT 'Not Started'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `goals_tasks`
--

INSERT INTO `goals_tasks` (`id`, `gid`, `vid`, `created_at`, `updated_at`, `start`, `task`, `type`, `priority`, `urgency`, `deadline`, `status`) VALUES
(5, 59, 1, '2019-06-10 04:50:50', '2019-06-10 04:50:50', '2019-06-09', '1', 'Task', 'C', 1, '2019-06-09', 'In Progress'),
(6, 59, 1, '2019-06-11 21:14:55', '2019-06-10 04:51:36', '2019-06-09', '2', 'Task', 'A', 1, '2019-06-15', 'Complete'),
(7, 59, 1, '2019-06-11 22:46:48', '2019-06-12 02:46:48', '2019-06-11', 'DiffVendor', 'Task', 'C', 1, '2019-06-11', 'Not Started');

-- --------------------------------------------------------

--
-- Table structure for table `habits`
--

CREATE TABLE `habits` (
  `id` int(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `start` date NOT NULL,
  `name` varchar(250) NOT NULL,
  `status` varchar(40) NOT NULL,
  `freq` varchar(20) NOT NULL DEFAULT 'Daily'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `habits`
--

INSERT INTO `habits` (`id`, `created_at`, `updated_at`, `start`, `name`, `status`, `freq`) VALUES
(9, '2019-06-08 09:33:36', '2019-06-08 09:33:36', '2019-06-08', 'sdfsdfsdf', 'Current', 'Daily');

-- --------------------------------------------------------

--
-- Table structure for table `habits_days`
--

CREATE TABLE `habits_days` (
  `id` int(10) NOT NULL,
  `hid` int(10) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(12) DEFAULT NULL,
  `day` tinyint(2) NOT NULL,
  `check` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `habits_days`
--

INSERT INTO `habits_days` (`id`, `hid`, `date`, `time`, `day`, `check`) VALUES
(336, 9, '2019-06-28', NULL, 21, 0),
(335, 9, '2019-06-27', NULL, 20, 0),
(334, 9, '2019-06-26', NULL, 19, 0),
(333, 9, '2019-06-25', NULL, 18, 0),
(332, 9, '2019-06-24', NULL, 17, 0),
(331, 9, '2019-06-23', NULL, 16, 0),
(330, 9, '2019-06-22', NULL, 15, 0),
(329, 9, '2019-06-21', NULL, 14, 0),
(328, 9, '2019-06-20', NULL, 13, 0),
(327, 9, '2019-06-19', NULL, 12, 0),
(326, 9, '2019-06-18', NULL, 11, 0),
(325, 9, '2019-06-17', NULL, 10, 0),
(324, 9, '2019-06-16', NULL, 9, 0),
(323, 9, '2019-06-15', NULL, 8, 0),
(322, 9, '2019-06-14', NULL, 7, 0),
(321, 9, '2019-06-13', NULL, 6, 0),
(320, 9, '2019-06-12', NULL, 5, 0),
(319, 9, '2019-06-11', NULL, 4, 0),
(318, 9, '2019-06-10', NULL, 3, 0),
(317, 9, '2019-06-09', NULL, 2, 0),
(316, 9, '2019-06-08', '01:33', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2016_03_01_032612_create_vendors_table', 2),
('2016_03_06_023622_create_mindstorms_ideas_table', 3),
('2016_03_22_210041_create_todo_lists_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `mindstorms`
--

CREATE TABLE `mindstorms` (
  `id` int(10) NOT NULL,
  `question` varchar(255) NOT NULL,
  `status` varchar(40) NOT NULL,
  `smart` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mindstorms`
--

INSERT INTO `mindstorms` (`id`, `question`, `status`, `smart`, `created_at`, `updated_at`) VALUES
(1, 'testIdea', 'In Progress', 1, '2016-03-27 03:09:48', '2016-03-27 03:09:55');

-- --------------------------------------------------------

--
-- Table structure for table `mindstorms_ideas`
--

CREATE TABLE `mindstorms_ideas` (
  `id` int(10) NOT NULL,
  `gid` int(10) NOT NULL,
  `idea` varchar(255) NOT NULL,
  `priority` varchar(4) NOT NULL,
  `urgency` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mindstorms_ideas`
--

INSERT INTO `mindstorms_ideas` (`id`, `gid`, `idea`, `priority`, `urgency`, `created_at`, `updated_at`) VALUES
(1, 1, 'test1', 'A', 1, '2016-03-27 03:12:05', '2016-03-27 03:12:05'),
(2, 1, 'test2', 'A', 1, '2016-03-27 03:12:10', '2016-03-27 03:12:10');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `readinglist`
--

CREATE TABLE `readinglist` (
  `id` int(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `priority` varchar(4) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `readinglist`
--

INSERT INTO `readinglist` (`id`, `created_at`, `updated_at`, `title`, `category`, `priority`, `status`) VALUES
(1, '2016-03-27 03:12:35', '2016-03-27 03:26:07', 'testBookTitle', 'PHP', 'A', 'Reading');

-- --------------------------------------------------------

--
-- Table structure for table `readinglist_notes`
--

CREATE TABLE `readinglist_notes` (
  `id` int(10) NOT NULL,
  `bid` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `readinglist_notes`
--

INSERT INTO `readinglist_notes` (`id`, `bid`, `title`, `description`) VALUES
(1, 1, 'Arrays', '<p>arrays iterators<br></p>'),
(2, 1, 'dsdfsdfsdsdfsdf', '<p>dsfdsfsdf<br></p>');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super', 'demo@lindynetech.com', '$2y$10$QaTaHZyJL9O/MKX0fbF77e9E/qfaKGsh1Q/IdKSg8ezufWIZPU4V6', '1Y9FYABwDVVXl7dIV9Ne9p3sxfLUs3sYJlBI9hR0VdtmmDmLqh0z6XhPbP7U', '2016-03-01 07:16:19', '2016-03-27 03:14:43');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `contact` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `name`, `role`, `status`, `contact`, `created_at`, `updated_at`) VALUES
(1, 'Super', 'Assignee', 'Active', 'lindynetech@gmail.com', '2016-03-19 01:07:01', '2016-03-19 01:07:01'),
(2, 'Sam', 'Vendor', 'Active', '', '2014-07-27 04:00:00', '2016-03-19 01:07:18'),
(3, 'Robert', 'Assignee', 'Inactive', 'Robert', '2016-03-27 03:13:34', '2019-06-12 02:46:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `daily_goals`
--
ALTER TABLE `daily_goals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `goals`
--
ALTER TABLE `goals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `goals_subtasks`
--
ALTER TABLE `goals_subtasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `goals_tasks`
--
ALTER TABLE `goals_tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `habits`
--
ALTER TABLE `habits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `habits_days`
--
ALTER TABLE `habits_days`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mindstorms`
--
ALTER TABLE `mindstorms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mindstorms_ideas`
--
ALTER TABLE `mindstorms_ideas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `readinglist`
--
ALTER TABLE `readinglist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `readinglist_notes`
--
ALTER TABLE `readinglist_notes`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daily_goals`
--
ALTER TABLE `daily_goals`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `goals`
--
ALTER TABLE `goals`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `goals_subtasks`
--
ALTER TABLE `goals_subtasks`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `goals_tasks`
--
ALTER TABLE `goals_tasks`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `habits`
--
ALTER TABLE `habits`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `habits_days`
--
ALTER TABLE `habits_days`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=337;

--
-- AUTO_INCREMENT for table `mindstorms`
--
ALTER TABLE `mindstorms`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mindstorms_ideas`
--
ALTER TABLE `mindstorms_ideas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `readinglist`
--
ALTER TABLE `readinglist`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `readinglist_notes`
--
ALTER TABLE `readinglist_notes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
