-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 23, 2018 at 10:10 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `promptfinder`
--

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` int(11) NOT NULL,
  `bankid` int(11) DEFAULT NULL,
  `accountname` char(100) DEFAULT NULL,
  `accountnum` char(50) DEFAULT NULL,
  `phonenumber` char(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`id`, `bankid`, `accountname`, `accountnum`, `phonenumber`) VALUES
(11, 1, '0030234234', '00000123', '08131528807');

-- --------------------------------------------------------

--
-- Table structure for table `companys`
--

CREATE TABLE `companys` (
  `id` int(11) NOT NULL,
  `promptid` char(100) DEFAULT NULL,
  `apikey` text,
  `assignedshortcode` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `usertext` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `usertext`) VALUES
(197, '1*2*jide'),
(196, '1'),
(195, '1_Jide'),
(194, '1_Jide'),
(193, '1_Jide'),
(192, '1_Jide'),
(191, '1_Jide'),
(190, '1_Jide'),
(189, '1_Jide'),
(188, '1_Jide'),
(187, '1_Jide'),
(186, '1'),
(185, '2'),
(184, '3'),
(183, '3'),
(182, ''),
(198, '1*jide'),
(199, '1*jide*akindejoye'),
(200, '1*jide*akindejoye*male'),
(201, '1*jide*akindejoye*male*skliz@yahoo.com'),
(202, '1*jide*akindejoye*male*skliz@yahoo.com*name'),
(203, '4*1'),
(204, '4'),
(205, '4*1'),
(206, '4*1'),
(207, '4*1'),
(208, '4*1'),
(209, '4*1'),
(210, '4*1'),
(211, '4*01'),
(212, '4*01'),
(213, '4*1'),
(214, '4*1'),
(215, '4*1'),
(216, '4*1'),
(217, '4*1'),
(218, '4*1'),
(219, '4*01'),
(220, '4*01'),
(221, '4*01'),
(222, '4*01'),
(223, '4*01'),
(224, '4*01'),
(225, '4*01'),
(226, '4*01'),
(227, '4*01'),
(228, '4*02'),
(229, '4*2*00000123'),
(230, '4*01'),
(231, '4*01'),
(232, '4*04'),
(233, '4*2*00000123'),
(234, '4*2*00000123'),
(235, '4*2*00000123'),
(236, '4*2*00000123'),
(237, '4*2*00000123'),
(238, '4*2*00000123'),
(239, '4*2*00000123'),
(240, '4*2*00000123'),
(241, '4*2*00000123*1'),
(242, '4*2*00000123*1'),
(243, '4*2*00000123*1'),
(244, '4*2*00000123*1'),
(245, '4*2*00000123*1'),
(246, '4*2*00000123*1'),
(247, '4'),
(248, '4'),
(249, '4*1'),
(250, '4*1'),
(251, '4*1*1'),
(252, '4*1*1*1'),
(253, '4*1*1*1'),
(254, '4*1'),
(255, '4*1*01'),
(256, '4*1*01'),
(257, '4*1*01'),
(258, '4*01'),
(259, '4*1*01'),
(260, '4'),
(261, '4*1'),
(262, '4*1*1'),
(263, '4*1*1*01'),
(264, '4*1*1*01'),
(265, '4*1*1*01'),
(266, '4*1*1*01'),
(267, '4*1*1*01'),
(268, '4'),
(269, '4*1'),
(270, '4*1*01'),
(271, '4'),
(272, '4*1'),
(273, '4*1*01'),
(274, '4*1*01'),
(275, '4*2*00000123'),
(276, '4*2*00000123*1'),
(277, '4*2*00000123*1'),
(278, '4*2*00000123*1'),
(279, '4*2*00000123*1'),
(280, '4*2*00000123*1');

-- --------------------------------------------------------

--
-- Table structure for table `session_levels`
--

CREATE TABLE `session_levels` (
  `session_id` varchar(50) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `level` text,
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `session_levels`
--

INSERT INTO `session_levels` (`session_id`, `phone`, `level`, `id`) VALUES
('111111111', '08131528807', 'confirmacct', 51);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companys`
--
ALTER TABLE `companys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `session_levels`
--
ALTER TABLE `session_levels`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `companys`
--
ALTER TABLE `companys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=281;
--
-- AUTO_INCREMENT for table `session_levels`
--
ALTER TABLE `session_levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
