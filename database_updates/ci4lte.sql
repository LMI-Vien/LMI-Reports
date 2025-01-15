-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2025 at 06:21 AM
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
(1, 'ictadmin', 'jan.lifestrong@gmail.com', 'Administrator', 'a5ce8a3e905e7ec090292403f735b4503ff69124411ed0a4e4ad08cd5116ac5e', '89B6089108oI0409', NULL, NULL, 1, 1, 1, 0, 1, 0, 0, NULL, NULL, NULL),
(18, 'ictuser', 'jan2.lifestrong@gmail.com', 'User', 'a5ce8a3e905e7ec090292403f735b4503ff69124411ed0a4e4ad08cd5116ac5e', '89B6089108oI0409', NULL, NULL, 1, 1, 1, 0, 2, 0, 0, NULL, NULL, NULL);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_report_users`
--
ALTER TABLE `tbl_report_users`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
