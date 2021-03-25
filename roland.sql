-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2021 at 03:54 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `roland`
--

-- --------------------------------------------------------

--
-- Table structure for table `tablefieldcontent`
--

CREATE TABLE `tablefieldcontent` (
  `id` int(11) NOT NULL,
  `fieldname` varchar(30) NOT NULL,
  `value` varchar(30) NOT NULL,
  `tablename` varchar(20) NOT NULL,
  `value_unit` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tablestructure`
--

CREATE TABLE `tablestructure` (
  `id` int(11) NOT NULL,
  `field1` varchar(50) NOT NULL,
  `field2` varchar(50) NOT NULL,
  `field3` varchar(50) NOT NULL,
  `table_date` varchar(50) NOT NULL,
  `tablename` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `usertable`
--

CREATE TABLE `usertable` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `country` varchar(10) NOT NULL,
  `user_pass` varchar(50) NOT NULL,
  `user_status` varchar(5) NOT NULL,
  `created_at` varchar(50) NOT NULL,
  `updated_at` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usertable`
--

INSERT INTO `usertable` (`id`, `username`, `user_email`, `fullname`, `address`, `city`, `country`, `user_pass`, `user_status`, `created_at`, `updated_at`) VALUES
(1, 'daniel', 'daniel@test.com', 'daniel ramos', 'ert', 'ert', 'ES', '12345678', '1', '2021-03-19 06:00:45pm', '2021-03-19 06:00:45pm'),
(3, 'roland', 'roland.berger@e-flox.de', 'Roland Berger', 'fs', 'asd', 'DE', '12345678', '2', '2021-03-19 10:21:24pm', '2021-03-22 07:03:28pm');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tablefieldcontent`
--
ALTER TABLE `tablefieldcontent`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tablestructure`
--
ALTER TABLE `tablestructure`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usertable`
--
ALTER TABLE `usertable`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tablefieldcontent`
--
ALTER TABLE `tablefieldcontent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tablestructure`
--
ALTER TABLE `tablestructure`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usertable`
--
ALTER TABLE `usertable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
