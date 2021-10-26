-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 24, 2021 at 12:45 PM
-- Server version: 5.6.35
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `almanak`
--

-- --------------------------------------------------------

--
-- Table structure for table `almanak_events`
--

CREATE TABLE `almanak_events` (
  `id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `title` varchar(255) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `location` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(120) NOT NULL DEFAULT '',
  `cat` tinyint(2) NOT NULL DEFAULT '0',
  `starttime` varchar(8) NOT NULL DEFAULT '0',
  `endtime` varchar(8) NOT NULL DEFAULT '0',
  `day` tinyint(2) NOT NULL DEFAULT '0',
  `month` int(2) NOT NULL DEFAULT '0',
  `year` int(4) NOT NULL DEFAULT '0',
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `fee` varchar(15) NOT NULL DEFAULT '',
  `priority` tinyint(1) NOT NULL DEFAULT '0',
  `user` varchar(30) NOT NULL DEFAULT '',
  `timezone` varchar(5) NOT NULL DEFAULT '',
  `idgroup` varchar(30) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `almanak_holidays`
--

CREATE TABLE `almanak_holidays` (
  `id` int(11) NOT NULL,
  `type` tinytext NOT NULL,
  `title` text NOT NULL,
  `day` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `before_easter` int(11) NOT NULL,
  `after_easter` int(11) NOT NULL,
  `nth` int(11) NOT NULL,
  `nth_day` int(11) NOT NULL,
  `nth_month` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `almanak_settings`
--

CREATE TABLE `almanak_settings` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `almanak_settings`
--

INSERT INTO `almanak_settings` (`id`, `name`, `value`) VALUES
(1, 'language', 'English'),
(2, 'starting year of the calendar', '2015'),
(3, 'future years of the calendar', '5'),
(4, 'e-mail address', '');

-- --------------------------------------------------------

--
-- Table structure for table `almanak_users`
--

CREATE TABLE `almanak_users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(40) NOT NULL,
  `description` text,
  `email` varchar(50) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `name` text NOT NULL,
  `address` text,
  `group_id` int(11) NOT NULL,
  `approve` tinyint(1) NOT NULL DEFAULT '1',
  `theme` varchar(255) DEFAULT NULL,
  `catlist` varchar(255) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `almanak_users`
--

INSERT INTO `almanak_users` (`user_id`, `username`, `password`, `description`, `email`, `url`, `name`, `address`, `group_id`, `approve`, `theme`, `catlist`) VALUES
(1, 'root', 'dc76e9f0c0006e8f919e0c515c66dbba3982f785', 'dit is de root user', NULL, NULL, '', NULL, 2, 1, NULL, '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `almanak_events`
--
ALTER TABLE `almanak_events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `almanak_holidays`
--
ALTER TABLE `almanak_holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `almanak_settings`
--
ALTER TABLE `almanak_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `almanak_users`
--
ALTER TABLE `almanak_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `almanak_events`
--
ALTER TABLE `almanak_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1133;
--
-- AUTO_INCREMENT for table `almanak_holidays`
--
ALTER TABLE `almanak_holidays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `almanak_settings`
--
ALTER TABLE `almanak_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `almanak_users`
--
ALTER TABLE `almanak_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
