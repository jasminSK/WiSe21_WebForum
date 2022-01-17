-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 17, 2022 at 03:03 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `forumsec`
--

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `title` varchar(32) NOT NULL DEFAULT '""',
  `content` longtext NOT NULL DEFAULT '""',
  `author` int(11) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `title`, `content`, `author`, `creation_date`) VALUES
(1000, 'Erster Forum Post', 'Willkommen auf dem sichereren Forum', 1000, '2022-01-17 13:50:14'),
(1001, 'Super wichte Information', 'Diese Seite ist sehr sicherer', 1001, '2022-01-17 13:52:54'),
(1002, 'HTML Injection', '&lt;b&gt;Dieser text ist nicht mehr fettgedruckt :)&lt;/b&gt;', 1002, '2022-01-17 13:54:15'),
(1003, 'Jetzt mag ich das Forum', 'Dieses Forum ist super :)', 1003, '2022-01-17 13:56:49');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL,
  `file_path` varchar(64) NOT NULL DEFAULT 'upload/default.png',
  `is_admin` tinyint(1) DEFAULT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `file_path`, `is_admin`, `creation_date`) VALUES
(1000, 'noahjauchmann', '$2y$10$O8Hfc96Ujtr3C0k4CywHoeLWRjJBXZs19bGoXtY4i920hkUN13j/O', 'upload/default.png', 1, '2022-01-17 13:48:44'),
(1001, 'jasminkufner', '$2y$10$FgOZUrtAg5f0CN/MnQM6hek78KPqWlOuSkw2mjsZMWXwc/m525luG', 'upload/default.png', 1, '2022-01-17 13:52:31'),
(1002, 'lisahüttinger', '$2y$10$QzaAgpMr50W2uw6B9xVY0.8PXDBmIhleKK2FIaZ67THV0.vt2F46q', 'upload/default.png', 1, '2022-01-17 13:53:44'),
(1003, 'regularuser', '$2y$10$b5PJ.TDhLNdsGb.YuoWmu.xYTFXWd0JhckRlXH42Td48JUikhAYBC', 'upload/default.png', NULL, '2022-01-17 13:55:53');

-- --------------------------------------------------------

--
-- Table structure for table `user_post`
--

CREATE TABLE `user_post` (
  `user_post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `vote` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_post`
--

INSERT INTO `user_post` (`user_post_id`, `user_id`, `post_id`, `vote`) VALUES
(1000, 1000, 1000, 1),
(1001, 1001, 1001, 1),
(1002, 1001, 1000, 1),
(1003, 1002, 1002, 1),
(1004, 1002, 1001, 1),
(1005, 1002, 1000, 1),
(1006, 1003, 1003, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `post_ibfk_1` (`author`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_post`
--
ALTER TABLE `user_post`
  ADD PRIMARY KEY (`user_post_id`),
  ADD KEY `user_post_ibfk_1` (`user_id`),
  ADD KEY `user_post_ibfk_2` (`post_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1004;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1005;

--
-- AUTO_INCREMENT for table `user_post`
--
ALTER TABLE `user_post`
  MODIFY `user_post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1007;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`author`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_post`
--
ALTER TABLE `user_post`
  ADD CONSTRAINT `user_post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_post_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
