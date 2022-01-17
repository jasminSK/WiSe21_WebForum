-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 17, 2022 at 02:30 PM
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
-- Database: `forum`
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
(1000, 'Erster Forum Post', 'Willkommen auf dem Forum.', 1000, '2022-01-17 13:24:33'),
(1001, 'Super wichte Information', 'Diese Seite ist sehr unsicher :(', 1001, '2022-01-17 13:25:49'),
(1002, 'HTML Injection', '<b>Dieser text fürfte nicht fettgedruckt sein :(</b>', 1002, '2022-01-17 13:27:48'),
(1003, 'Diese Website ist doof', 'Ich mag das Forum nicht.', 1003, '2022-01-17 13:28:41');

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
(1000, 'noahjauchmann', '123456789', 'upload/default.png', 1, '2022-01-17 13:21:13'),
(1001, 'jasminkufner', 'password', 'upload/default.png', 1, '2022-01-17 13:21:23'),
(1002, 'lisahüttinger', 'qwertz', 'upload/default.png', 1, '2022-01-17 13:22:04'),
(1003, 'regularuser', 'abcdefg', 'upload/default.png', NULL, '2022-01-17 13:23:14');

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
(1000, 1001, 1000, 1),
(1001, 1001, 1001, 1),
(1002, 1002, 1001, 1),
(1003, 1002, 1000, 1),
(1004, 1000, 1003, -1),
(1005, 1001, 1003, -1),
(1006, 1001, 1002, 1);

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
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1004;

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
