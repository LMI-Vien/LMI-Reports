-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2025 at 10:17 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci4lte`
--

-- --------------------------------------------------------

--
-- Table structure for table `cms_audit_trail`
--

CREATE TABLE `cms_audit_trail` (
  `id` int(10) UNSIGNED NOT NULL,
  `site_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `url` mediumtext NOT NULL,
  `action` varchar(30) NOT NULL,
  `old_data` mediumtext NOT NULL,
  `new_data` mediumtext NOT NULL,
  `created_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cms_audit_trail`
--

INSERT INTO `cms_audit_trail` (`id`, `site_id`, `user_id`, `url`, `action`, `old_data`, `new_data`, `created_date`) VALUES
(1, NULL, 1, '', 'Login', '', '', '2025-01-15 08:43:21'),
(2, NULL, 4, '', 'Login', '', '', '2025-01-16 01:10:52'),
(3, NULL, 4, '', 'Login', '', '', '2025-01-16 01:10:52'),
(4, NULL, 1, '', 'Login', '', '', '2025-01-16 01:37:34'),
(5, NULL, 4, '', 'Login', '', '', '2025-01-16 02:08:24'),
(6, NULL, 4, '', 'Login', '', '', '2025-01-16 02:08:24'),
(7, NULL, 4, '', 'Login', '', '', '2025-01-16 03:22:06'),
(8, NULL, 4, '', 'Login', '', '', '2025-01-16 03:22:06'),
(9, NULL, 1, '', 'Login', '', '', '2025-01-16 03:22:42'),
(10, NULL, 1, '', 'Login', '', '', '2025-01-16 03:40:47'),
(11, NULL, 1, '', 'Logout', '', '', '2025-01-16 05:46:44'),
(12, NULL, 1, '', 'Login', '', '', '2025-01-16 05:47:10'),
(13, NULL, 1, '', 'Logout', '', '', '2025-01-16 05:49:15'),
(14, NULL, 4, '', 'Login', '', '', '2025-01-16 05:49:31'),
(15, NULL, 4, '', 'Login', '', '', '2025-01-16 05:49:31'),
(16, NULL, 4, '', 'Login', '', '', '2025-01-16 05:53:48'),
(17, NULL, 4, '', 'Login', '', '', '2025-01-16 05:53:48'),
(18, NULL, 1, '', 'Login', '', '', '2025-01-16 05:54:31'),
(19, NULL, 1, '', 'Login', '', '', '2025-01-16 07:09:01'),
(20, NULL, 1, '', 'Logout', '', '', '2025-01-16 07:42:56'),
(21, NULL, 1, '', 'Login', '', '', '2025-01-16 07:43:05'),
(22, NULL, 1, '', 'Logout', '', '', '2025-01-16 07:44:52'),
(23, NULL, 1, '', 'Login', '', '', '2025-01-16 07:46:05'),
(24, NULL, 1, '', 'Login', '', '', '2025-01-17 01:09:44'),
(25, NULL, 4, '', 'Login', '', '', '2025-01-17 02:07:40'),
(26, NULL, 4, '', 'Login', '', '', '2025-01-17 02:07:40'),
(27, NULL, 1, '', 'Login', '', '', '2025-01-17 05:17:57'),
(28, NULL, 1, '', 'Login', '', '', '2025-01-17 05:46:16'),
(29, NULL, 1, '', 'Logout', '', '', '2025-01-17 06:05:36'),
(30, NULL, 1, '', 'Login', '', '', '2025-01-17 06:06:08'),
(31, NULL, 1, '', 'Logout', '', '', '2025-01-17 06:06:13'),
(32, NULL, 1, '', 'Login', '', '', '2025-01-17 06:06:43'),
(33, NULL, 1, '', 'Login', '', '', '2025-01-17 06:13:37'),
(34, NULL, 1, '', 'Logout', '', '', '2025-01-17 06:43:20'),
(35, NULL, 1, '', 'Login', '', '', '2025-01-17 06:45:14'),
(36, NULL, 1, 'agency', 'Create', '', '{\"code\":\"sdasd\",\"agency\":\"asdasda\",\"created_date\":\"2025-01-17 16:27:13\",\"status\":\"1\"}', '2025-01-17 08:27:13'),
(37, NULL, 1, 'agency', 'Create', '', '{\"code\":\"adasdsadsd\",\"agency\":\"sadsada\",\"created_date\":\"2025-01-17 16:28:00\",\"status\":\"1\"}', '2025-01-17 08:28:00'),
(38, NULL, 1, 'agency', 'Create', '', '{\"code\":\"\",\"agency\":\"\",\"created_date\":\"2025-01-17 16:50:02\",\"created_by\":\"1\",\"status\":\"1\"}', '2025-01-17 08:50:02'),
(39, NULL, 1, 'agency', 'Update', '[{\"id\":\"5\",\"code\":\"\",\"agency\":\"\",\"status\":\"1\",\"created_date\":\"2025-01-17 16:50:02\",\"updated_date\":null,\"created_by\":\"1\",\"updated_by\":\"0\"}]', '{\"code\":\"\",\"agency\":\"\",\"updated_date\":\"2025-01-17 16:57:28\",\"updated_by\":\"1\",\"status\":\"1\"}', '2025-01-17 08:57:28'),
(40, NULL, 1, 'agency', 'Update', '[{\"id\":\"5\",\"code\":\"\",\"agency\":\"\",\"status\":\"1\",\"created_date\":\"2025-01-17 16:50:02\",\"updated_date\":\"2025-01-17 16:57:28\",\"created_by\":\"1\",\"updated_by\":\"1\"}]', '{\"code\":\"sdadas\",\"agency\":\"dasdsadasdsdsd\",\"updated_date\":\"2025-01-17 16:58:18\",\"updated_by\":\"1\",\"status\":\"1\"}', '2025-01-17 08:58:18'),
(41, NULL, 1, 'agency', 'Update', '[{\"id\":\"5\",\"code\":\"sdadas\",\"agency\":\"dasdsadasdsdsd\",\"status\":\"1\",\"created_date\":\"2025-01-17 16:50:02\",\"updated_date\":\"2025-01-17 16:58:18\",\"created_by\":\"1\",\"updated_by\":\"1\"}]', '{\"code\":\"sdadas\",\"agency\":\"dasdsadasdsdsd\",\"updated_date\":\"2025-01-17 16:58:46\",\"updated_by\":\"1\",\"status\":\"1\"}', '2025-01-17 08:58:46'),
(42, NULL, 1, 'agency', 'Update', '[{\"id\":\"5\",\"code\":\"sdadas\",\"agency\":\"dasdsadasdsdsd\",\"status\":\"1\",\"created_date\":\"2025-01-17 16:50:02\",\"updated_date\":\"2025-01-17 16:58:46\",\"created_by\":\"1\",\"updated_by\":\"1\"}]', '{\"code\":\"sdadas\",\"agency\":\"dasdsadasdsdsd\",\"updated_date\":\"2025-01-17 16:59:36\",\"updated_by\":\"1\",\"status\":\"1\"}', '2025-01-17 08:59:36'),
(43, NULL, 1, 'agency', 'Delete', '[{\"id\":\"4\",\"code\":\"adasdsadsd\",\"agency\":\"sadsada\",\"status\":\"1\",\"created_date\":\"2025-01-17 16:28:00\",\"updated_date\":null,\"created_by\":\"0\",\"updated_by\":\"0\"}]', '{\"updated_date\":\"2025-01-17 17:15:48\",\"updated_by\":\"1\",\"status\":\"-2\"}', '2025-01-17 09:15:48'),
(44, NULL, 1, 'agency', 'Delete', '[{\"id\":\"3\",\"code\":\"sdasd\",\"agency\":\"asdasda\",\"status\":\"1\",\"created_date\":\"2025-01-17 16:27:13\",\"updated_date\":null,\"created_by\":\"0\",\"updated_by\":\"0\"}]', '{\"updated_date\":\"2025-01-17 17:15:52\",\"updated_by\":\"1\",\"status\":\"-2\"}', '2025-01-17 09:15:52');

-- --------------------------------------------------------

--
-- Table structure for table `cms_historical_passwords`
--

CREATE TABLE `cms_historical_passwords` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `password` varchar(255) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cms_historical_passwords`
--

INSERT INTO `cms_historical_passwords` (`id`, `user_id`, `password`, `create_date`) VALUES
(1, 1, 'a5ce8a3e905e7ec090292403f735b4503ff69124411ed0a4e4ad08cd5116ac5e', '2025-01-10 18:48:37'),
(50, 18, 'a5ce8a3e905e7ec090292403f735b4503ff69124411ed0a4e4ad08cd5116ac5e', '2025-01-10 18:48:37');

-- --------------------------------------------------------

--
-- Table structure for table `cms_preference`
--

CREATE TABLE `cms_preference` (
  `id` int(10) UNSIGNED NOT NULL,
  `cms_title` varchar(50) NOT NULL,
  `cms_logo` mediumtext NOT NULL,
  `cms_skin` varchar(25) NOT NULL,
  `cms_edit_label` int(11) NOT NULL,
  `ad_authentication` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cms_preference`
--

INSERT INTO `cms_preference` (`id`, `cms_title`, `cms_logo`, `cms_skin`, `cms_edit_label`, `ad_authentication`, `status`, `created_date`, `updated_date`, `created_by`, `updated_by`) VALUES
(1, 'LMI Portal', 'CMS', 'skin-blue', 1, 0, 1, '2025-01-11 13:50:23', '2025-01-11 13:50:23', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cms_site_token`
--

CREATE TABLE `cms_site_token` (
  `id` int(10) UNSIGNED NOT NULL,
  `token` varchar(255) NOT NULL,
  `redirect` mediumtext NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `expire_date` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cms_users`
--

CREATE TABLE `cms_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `notif_signup` int(11) DEFAULT NULL,
  `notif_contactus` int(11) DEFAULT NULL,
  `notif_login` int(11) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  `user_error_logs` int(11) DEFAULT NULL,
  `user_block_logs` int(11) DEFAULT NULL,
  `user_lock_time` datetime DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cms_users`
--

INSERT INTO `cms_users` (`id`, `username`, `email`, `name`, `password`, `salt`, `create_date`, `update_date`, `status`, `notif_signup`, `notif_contactus`, `notif_login`, `role`, `user_error_logs`, `user_block_logs`, `user_lock_time`, `created_by`, `updated_by`) VALUES
(1, 'ictadmin', 'dummy1.lifestrong@gmail.com', 'Administrator', 'a5ce8a3e905e7ec090292403f735b4503ff69124411ed0a4e4ad08cd5116ac5e', '89B6089108oI0409', NULL, NULL, 1, 1, 1, 0, 1, 0, 0, NULL, NULL, NULL),
(18, 'ictuser', 'dummy2.lifestrong@gmail.com', 'User', 'a5ce8a3e905e7ec090292403f735b4503ff69124411ed0a4e4ad08cd5116ac5e', '89B6089108oI0409', NULL, NULL, 1, 1, 1, 0, 2, 0, 0, NULL, NULL, NULL),
(19, 'ictadmin3', 'dummy3.lifestrong@gmail.com', 'Administrator3', 'a5ce8a3e905e7ec090292403f735b4503ff69124411ed0a4e4ad08cd5116ac5e', '89B6089108oI0409', NULL, NULL, 1, 1, 1, 0, 1, 0, 0, NULL, NULL, NULL),
(20, 'ictuser4', 'dummy4.lifestrong@gmail.com', 'User4', 'a5ce8a3e905e7ec090292403f735b4503ff69124411ed0a4e4ad08cd5116ac5e', '89B6089108oI0409', NULL, NULL, 1, 1, 1, 0, 2, 0, 0, NULL, NULL, NULL),
(21, 'ictadmin5', 'dummy5.lifestrong@gmail.com', 'Administrator5', 'a5ce8a3e905e7ec090292403f735b4503ff69124411ed0a4e4ad08cd5116ac5e', '89B6089108oI0409', NULL, NULL, 1, 1, 1, 0, 1, 0, 0, NULL, NULL, NULL),
(22, 'ictuser6', 'dummy6.lifestrong@gmail.com', 'User6', 'a5ce8a3e905e7ec090292403f735b4503ff69124411ed0a4e4ad08cd5116ac5e', '89B6089108oI0409', NULL, NULL, 1, 1, 1, 0, 2, 0, 0, NULL, NULL, NULL),
(23, 'ictadmin7', 'dummy7.lifestrong@gmail.com', 'Administrator7', 'a5ce8a3e905e7ec090292403f735b4503ff69124411ed0a4e4ad08cd5116ac5e', '89B6089108oI0409', NULL, NULL, 1, 1, 1, 0, 1, 0, 0, NULL, NULL, NULL),
(24, 'ictuser8', 'dummy8.lifestrong@gmail.com', 'User8', 'a5ce8a3e905e7ec090292403f735b4503ff69124411ed0a4e4ad08cd5116ac5e', '89B6089108oI0409', NULL, NULL, 1, 1, 1, 0, 2, 0, 0, NULL, NULL, NULL),
(25, 'ictuser9', 'dummy9.lifestrong@gmail.com', 'User9', 'a5ce8a3e905e7ec090292403f735b4503ff69124411ed0a4e4ad08cd5116ac5e', '89B6089108oI0409', NULL, NULL, 1, 1, 1, 0, 2, 0, 0, NULL, NULL, NULL),
(26, 'ictadmin10', 'dummy10.lifestrong@gmail.com', 'Administrator7', 'a5ce8a3e905e7ec090292403f735b4503ff69124411ed0a4e4ad08cd5116ac5e', '89B6089108oI0409', NULL, NULL, 1, 1, 1, 0, 1, 0, 0, NULL, NULL, NULL),
(27, 'ictuser11', 'dummy11.lifestrong@gmail.com', 'User11', 'a5ce8a3e905e7ec090292403f735b4503ff69124411ed0a4e4ad08cd5116ac5e', '89B6089108oI0409', NULL, NULL, 1, 1, 1, 0, 2, 0, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cms_user_roles`
--

CREATE TABLE `cms_user_roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cms_user_roles`
--

INSERT INTO `cms_user_roles` (`id`, `name`, `status`, `create_date`, `update_date`, `created_by`, `updated_by`) VALUES
(1, 'Admin', 1, '2022-09-22 11:16:41', '2022-09-22 11:16:41', NULL, NULL),
(2, 'IT Admin', 1, '2022-09-22 11:16:41', '2022-09-22 11:16:41', NULL, NULL),
(7, 'Sample', 1, '2022-09-22 11:16:41', '2022-09-22 11:16:41', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `key` varchar(255) NOT NULL,
  `value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `site_menu`
--

CREATE TABLE `site_menu` (
  `id` int(11) NOT NULL,
  `menu_url` mediumtext DEFAULT NULL,
  `menu_name` varchar(50) DEFAULT NULL,
  `default_menu` int(11) DEFAULT NULL,
  `menu_type` varchar(255) DEFAULT NULL,
  `menu_parent_id` int(11) DEFAULT 0,
  `menu_level` tinyint(1) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `url_behavior` tinyint(1) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` mediumtext DEFAULT NULL,
  `meta_keyword` mediumtext DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_menu`
--

INSERT INTO `site_menu` (`id`, `menu_url`, `menu_name`, `default_menu`, `menu_type`, `menu_parent_id`, `menu_level`, `sort_order`, `status`, `url_behavior`, `meta_title`, `meta_description`, `meta_keyword`, `updated_date`, `created_date`, `created_by`, `updated_by`) VALUES
(1, 'home', 'Home', 1, 'Module', 0, 1, 1, 1, NULL, '', '', '', '2025-01-17 13:08:07', '2025-01-17 13:08:07', 1, 1),
(2, 'our-purpose-our-values', 'Our Company', 0, 'Group Menu', 0, 1, 2, 1, NULL, '', '', NULL, '2025-01-17 13:08:07', '2025-01-17 13:08:07', 1, 1),
(3, 'products', 'Our Products', 0, 'Group Menu', 0, 1, 3, 1, NULL, '', '', NULL, '2025-01-17 13:08:07', '2025-01-17 13:08:07', 1, 1),
(4, 'programsold', 'Bayanihan Programs', 0, 'Module', 0, 1, 5, -2, NULL, '', '', NULL, '2025-01-17 13:08:07', '2025-01-17 13:08:07', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_agency`
--

CREATE TABLE `tbl_agency` (
  `id` int(11) NOT NULL,
  `code` varchar(25) NOT NULL,
  `agency` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_agency`
--

INSERT INTO `tbl_agency` (`id`, `code`, `agency`, `status`, `created_date`, `updated_date`, `created_by`, `updated_by`) VALUES
(1, 'code-123', 'Accenture', 1, '2025-01-17 08:36:10', NULL, 1, 1),
(2, 'code-234', 'Google', 1, '2025-01-17 08:36:10', NULL, 1, 1),
(3, 'sdasd', 'asdasda', -2, '2025-01-17 16:27:13', '2025-01-17 17:15:52', 0, 1),
(4, 'adasdsadsd', 'sadsada', -2, '2025-01-17 16:28:00', '2025-01-17 17:15:48', 0, 1),
(5, 'sdadas', 'dasdsadasdsdsd', 1, '2025-01-17 16:50:02', '2025-01-17 16:59:36', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_report_users`
--

CREATE TABLE `tbl_report_users` (
  `id` int(6) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `status` int(6) DEFAULT NULL,
  `user_error_logs` int(6) DEFAULT NULL,
  `user_block_logs` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_report_users`
--

INSERT INTO `tbl_report_users` (`id`, `username`, `email`, `name`, `last_name`, `password`, `create_date`, `update_date`, `status`, `user_error_logs`, `user_block_logs`) VALUES
(4, 'dummysa', 'dummy1@gmail.com', 'dummysa', '', 'a5ce8a3e905e7ec090292403f735b4503ff69124411ed0a4e4ad08cd5116ac5e', '2020-07-27 11:36:59', '2020-07-28 10:48:08', 1, 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cms_audit_trail`
--
ALTER TABLE `cms_audit_trail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_historical_passwords`
--
ALTER TABLE `cms_historical_passwords`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cms_preference`
--
ALTER TABLE `cms_preference`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_site_token`
--
ALTER TABLE `cms_site_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_users`
--
ALTER TABLE `cms_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_user_roles`
--
ALTER TABLE `cms_user_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_menu`
--
ALTER TABLE `site_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_agency`
--
ALTER TABLE `tbl_agency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_report_users`
--
ALTER TABLE `tbl_report_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cms_audit_trail`
--
ALTER TABLE `cms_audit_trail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `cms_historical_passwords`
--
ALTER TABLE `cms_historical_passwords`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `cms_preference`
--
ALTER TABLE `cms_preference`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cms_site_token`
--
ALTER TABLE `cms_site_token`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cms_users`
--
ALTER TABLE `cms_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `cms_user_roles`
--
ALTER TABLE `cms_user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_menu`
--
ALTER TABLE `site_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `tbl_agency`
--
ALTER TABLE `tbl_agency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_report_users`
--
ALTER TABLE `tbl_report_users`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
