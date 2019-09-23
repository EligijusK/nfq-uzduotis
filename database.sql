-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Sep 23, 2019 at 05:56 PM
-- Server version: 5.7.26
-- PHP Version: 7.2.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `NFQ`
--

-- --------------------------------------------------------

--
-- Table structure for table `ADMINS`
--

CREATE TABLE `ADMINS` (
  `_id` int(6) NOT NULL,
  `admin_user` varchar(30) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ADMINS`
--

INSERT INTO `ADMINS` (`_id`, `admin_user`, `first_name`, `last_name`, `email`, `password`) VALUES
(1, 'vartotoas1', 'vartotoas1', 'vartotoas1', 'vartotoas1@email.com', '$2y$10$4AjcjXSfUF8jg2PyKebHIe4Wjz/HD2e2n4xzbvXYbFd8lCTulmrry'),
(2, 'vartotojas2', 'vartotojas2', 'vartotojas2', 'vartotojas2@email.com', '$2y$10$4AjcjXSfUF8jg2PyKebHIe4Wjz/HD2e2n4xzbvXYbFd8lCTulmrry');

-- --------------------------------------------------------

--
-- Table structure for table `SERVING`
--

CREATE TABLE `SERVING` (
  `_id` int(6) UNSIGNED NOT NULL,
  `servicing_info` varchar(256) DEFAULT NULL,
  `serviced_check` int(1) NOT NULL,
  `visit_time` int(6) NOT NULL,
  `time_submitted` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `time_accepted` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `time_finished` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_USER_id` int(11) NOT NULL,
  `fk_ADMIN_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `USERS`
--

CREATE TABLE `USERS` (
  `_id` int(6) NOT NULL,
  `username` varchar(30) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `PASSWORD` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ADMINS`
--
ALTER TABLE `ADMINS`
  ADD PRIMARY KEY (`_id`),
  ADD UNIQUE KEY `admin_user` (`admin_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `SERVING`
--
ALTER TABLE `SERVING`
  ADD PRIMARY KEY (`_id`),
  ADD KEY `serviced` (`fk_USER_id`),
  ADD KEY `servicing` (`fk_ADMIN_id`);

--
-- Indexes for table `USERS`
--
ALTER TABLE `USERS`
  ADD PRIMARY KEY (`_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ADMINS`
--
ALTER TABLE `ADMINS`
  MODIFY `_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `SERVING`
--
ALTER TABLE `SERVING`
  MODIFY `_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `USERS`
--
ALTER TABLE `USERS`
  MODIFY `_id` int(6) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `SERVING`
--
ALTER TABLE `SERVING`
  ADD CONSTRAINT `serviced` FOREIGN KEY (`fk_USER_id`) REFERENCES `USERS` (`_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `servicing` FOREIGN KEY (`fk_ADMIN_id`) REFERENCES `ADMINS` (`_id`) ON DELETE CASCADE;
