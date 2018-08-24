-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-08-24 02:46:35
-- 服务器版本： 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `product`
--
CREATE DATABASE IF NOT EXISTS `product` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `product`;

-- --------------------------------------------------------

--
-- 表的结构 `cart`
--

CREATE TABLE `cart` (
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `product_id` int(5) NOT NULL,
  `quantity` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `customer`
--

CREATE TABLE `customer` (
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `customer`
--

INSERT INTO `customer` (`username`, `password`, `name`, `email`, `phone`, `gender`) VALUES
('admin', 'password', 'admin', '', '', ''),
('shawnlim', 'shawnlim', 'shawn', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `favourite`
--

CREATE TABLE `favourite` (
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `product_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `order`
--

CREATE TABLE `order` (
  `order_id` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `product_id` int(5) NOT NULL,
  `quantity` int(3) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `product`
--

CREATE TABLE `product` (
  `product_id` int(5) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `desc` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `category` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `brand` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `size` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- 转存表中的数据 `product`
--

INSERT INTO `product` (`product_id`, `name`, `price`, `desc`, `gender`, `category`, `brand`, `size`) VALUES
(8, 'ASDASD', '14.00', 'asdash ashjd hasda asd', 'male', 'aa', 'nike', '21'),
(9, 'ASDASD', '14.00', 'asdash ashjd hasda asd', 'male', 'aa', 'nike', '21'),
(10, 'ASDASD', '14.00', 'asdash ashjd hasda asd', 'male', '', 'nike', '21'),
(11, 'ASDASD', '14.00', 'asdash ashjd hasda asd', 'male', '', 'nike', '21'),
(12, 'ASDASD', '14.00', 'asdash ashjd hasda asd', 'male', '', 'nike', '21'),
(13, 'ASDASD', '14.00', 'asdash ashjd hasda asd', 'male', '0', 'nike', '21'),
(14, 'ASDASD', '14.00', 'asdash ashjd hasda asd', 'male', '0', 'nike', '21'),
(15, 'ASDASD', '14.00', 'asdash ashjd hasda asd', 'male', '0', 'nike', '21'),
(16, '', '0.00', '', '', '0', '', ''),
(17, '', '0.00', '', '', '0', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
