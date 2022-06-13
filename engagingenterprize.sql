-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2022 at 01:54 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `engagingenterprize`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `pid` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `timestamps` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`pid`, `title`, `description`, `image`, `status`, `timestamps`) VALUES
(1, 'Iphone 11', 'this is iphone desciption', '', 'Active', '2022-06-13 09:38:58'),
(2, 'Samsung j', 'this is samsung j', '', 'Active', '2022-06-13 09:38:58'),
(3, 'Electric Bike xcv', 'electric bike xcv', '', 'Inactive', '2022-06-13 10:56:08'),
(4, 'Electric car z model', 'decription of electric car z model', '', 'Inactive', '2022-06-13 09:40:35'),
(5, 'Electric car Y model', 'decription of electric car Y model', '', 'Active', '2022-06-13 09:41:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `userstatus` enum('Active','Inactive') NOT NULL,
  `isvarified` tinyint(1) NOT NULL DEFAULT 0,
  `createdon` datetime NOT NULL,
  `usertimestamps` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `firstname`, `lastname`, `email`, `password`, `userstatus`, `isvarified`, `createdon`, `usertimestamps`) VALUES
(1, 'John', 'Doe', 'john@somedomain.com', '123456', 'Active', 1, '2022-06-13 11:41:47', '2022-06-13 09:42:20'),
(2, 'jane', 'doe', 'jane@somedomain.com', '123456', 'Active', 0, '2022-06-13 11:42:30', '2022-06-13 09:43:17'),
(3, 'simpson', 'doe', 'simpson@somedomain.com', '123456', 'Inactive', 0, '2022-06-13 11:42:30', '2022-06-13 09:43:17'),
(4, 'Syed', 'naeem', 'syed@mydomainxxx.com', '123456', 'Active', 1, '2022-06-13 11:43:27', '2022-06-13 09:43:53'),
(5, 'sarah', 'smith', 'sarah@domainxxcc.com', '123456', 'Active', 1, '2022-06-13 11:44:49', '2022-06-13 09:45:21');

-- --------------------------------------------------------

--
-- Table structure for table `users_products`
--

CREATE TABLE `users_products` (
  `userid` int(9) NOT NULL,
  `pid` int(9) NOT NULL,
  `instock` int(9) NOT NULL,
  `price` float(9,2) NOT NULL,
  `createdon` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_products`
--

INSERT INTO `users_products` (`userid`, `pid`, `instock`, `price`, `createdon`) VALUES
(1, 1, 5, 2000.00, '2022-06-13 12:01:16'),
(2, 3, 3, 500.00, '2022-06-13 12:02:41'),
(4, 2, 4, 100.00, '2022-06-13 12:03:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `users_products`
--
ALTER TABLE `users_products`
  ADD PRIMARY KEY (`userid`,`pid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
