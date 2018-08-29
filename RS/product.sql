-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-08-29 02:48:44
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
-- 表的结构 `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`username`, `hash`, `name`, `email`) VALUES
('admin', 'password', 'Admin', 'admin@gmail.com');

-- --------------------------------------------------------

--
-- 表的结构 `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `product_id` int(5) NOT NULL,
  `quantity` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `customer`
--

INSERT INTO `customer` (`username`, `hash`, `name`, `email`, `phone`, `gender`) VALUES
('johnwick', '$2y$10$c1dl29ssDnxbNnxAlvmwseq8QJqImYE.Yfz2T3X1G7ZC3Vq4DJT0e', 'John Wick', 'benlyr1212@gmail.com', '012-5478963', 'M'),
('zifeng', '$2y$10$1JO9rKHhfMX8Pcm93CjxyOhTKWX1rFuAx5tlQ1TaHkf311CcLVF22', 'Zifeng', 'wongzf@gmail.com', '019-6320145', 'M');

-- --------------------------------------------------------

--
-- 表的结构 `favourite`
--

DROP TABLE IF EXISTS `favourite`;
CREATE TABLE `favourite` (
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `product_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `order_id` int(5) NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `card` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total_payment` decimal(7,2) NOT NULL,
  `date` date NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `order`
--

INSERT INTO `order` (`order_id`, `username`, `card`, `address`, `total_payment`, `date`, `name`, `email`) VALUES
(1001, 'Shawn Lim', '1010101010101010', 'PV 5', '5000.00', '2018-08-28', '', ''),
(1002, 'johnwick', '6666666666666666', 'ddd', '500.00', '2018-08-28', '', ''),
(1003, 'zifeng', '3030303030300303', 'PV 16', '2350.00', '2018-08-28', '', ''),
(1004, 'Lim Jia Ying', '2929922929292929', 'Toilet', '390.00', '2018-08-28', '', ''),
(1005, 'johnwick', '3664563546369286', 'Titiwangsa', '1875.00', '2018-08-28', '', ''),
(1006, 'johnwick', '2094928734986219', 'Prima Setapak', '1125.00', '2018-08-28', '', ''),
(1007, 'johnwick', '2123213341213123', 'sadw', '490.00', '2018-08-28', '', ''),
(1008, 'johnwick', '5788934574986458', 'fhgrghriughdkgru', '598.00', '2018-08-28', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `order_detail`
--

DROP TABLE IF EXISTS `order_detail`;
CREATE TABLE `order_detail` (
  `order_id` int(5) NOT NULL,
  `product_id` int(10) NOT NULL,
  `quantity` int(5) NOT NULL,
  `price` decimal(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `order_detail`
--

INSERT INTO `order_detail` (`order_id`, `product_id`, `quantity`, `price`) VALUES
(1002, 1022, 1, '500.00'),
(1003, 2001, 5, '470.00'),
(1004, 2005, 1, '390.00'),
(1005, 1016, 3, '625.00'),
(1006, 1001, 3, '375.00'),
(1007, 1004, 1, '490.00'),
(1008, 1003, 2, '299.00');

-- --------------------------------------------------------

--
-- 表的结构 `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `product_id` int(5) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `category` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `brand` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `size` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `product`
--

INSERT INTO `product` (`product_id`, `name`, `price`, `desc`, `gender`, `category`, `brand`, `size`, `quantity`) VALUES
(1001, 'Nike Lebron Soldier XII SFG Shoes', '375.00', 'The LeBron Soldier XII SFG Basketball Shoe delivers lightweight, responsive cushioning for the court with Nike Zoom Air cushioning. Adjustable hook-and-loop straps offer adjustable, secure lockdown.', 'Male', 'Basketball', 'Nike', '27,28,29,30,31', 100),
(1002, 'Nike Kyrie 4 Shoes', '390.00', 'The Kyrie 4 Men\'s Basketball Shoe is ultra-flexible, responsive and supportive. It\'s designed for Kyrie Irving\'s sudden changes of direction and smooth yet rapid playing style.', 'Male', 'Basketball', 'Nike', '27,28,29,30,31', 100),
(1003, 'Nike Jordan Ultra Fly 2 Low Shoes', '299.00', 'Designed for the versatile player who can play any position, the Jordan Ultra Fly 2 Low Men\'s Basketball Shoe offers responsive cushioning and lightweight lockdown.', 'Male', 'Basketball', 'Nike', '27,28,29,30,31', 100),
(1004, 'Nike Kobe A.D. Black Mamba Shoes', '490.00', 'The Kobe A.D. Basketball Shoe delivers lightweight support, responsive cushioning and excellent traction during practice and on game day to help you push past your potential.', 'Male', 'Basketball', 'Nike', '27,28,29,30,31', 100),
(1005, 'Nike Air Max Dominate Shoes', '399.00', 'The Nike Air Max Dominate Men\'s Basketball Shoe offers breathable support and plush cushioning for dynamic movement on the court.', 'Male', 'Basketball', 'Nike', '27,28,29,30,31', 100),
(1006, 'Nike TW 17 Shoes', '300.00', 'The Nike Air Zoom TW \'17 Men\'s Golf Shoe provides lightweight, responsive cushioning and a propulsive feel underfoot for a powerful swing.', 'Male', 'Golf', 'Nike', '27,28,29,30,31', 100),
(1007, 'Nike Air Zoom 90 IT Shoes', '500.00', 'An updated favourite of Rory McIlroy\'s, the Nike Air Zoom 90 IT Men\'s Golf Shoe features a waterproof upper and incredible traction for those who don\'t let the weather stand in their way.', 'Male', 'Golf', 'Nike', '27,28,29,30,31', 100),
(1008, 'Nike Lunar Command 2 Shoes', '425.00', 'The Nike Lunar Command 2 Men\'s Golf Shoe features Flywire technology for an exceptionally secure fit and lightweight cushioning that keeps you in total comfort from the first hole to the last.', 'Male', 'Golf', 'Nike', '27,28,29,30,31', 100),
(1009, 'Nike Lunar Control Vapor 2 Shoes', '525.00', 'The Nike Lunar Control Vapor 2 Men\'s Golf Shoe delivers the grip, support and comfort you need to drive further off the tee.', 'Male', 'Golf', 'Nike', '27,28,29,30,31', 100),
(1010, 'Nike FI Flex Shoes', '300.00', 'The Nike FI Flex Men\'s Golf Shoe flexes with your foot for a smooth, natural feel and features lightweight cushioning to help keep you comfortable through to the eighteenth hole.', 'Male', 'Golf', 'Nike', '27,28,29,30,31', 100),
(1011, 'Nike Free X Metcon Shoes', '400.00', 'The Nike Free x Metcon Training Shoe combines the lightweight flexibility of Nike Free with the durability and stability of Nike Metcon shoes—which means it can stand up to short runs, boot camps, str', 'Male', 'Gym & Training', 'Nike', '27,28,29,30,31', 100),
(1012, 'Nike Free TR V8 Shoes', '355.00', 'Designed for natural movement and lockdown during intense workouts, the Nike Free TR V8 Men\'s Training Shoe features a flexible sole pattern and a stabilising wing that wraps your heel for a supportiv', 'Male', 'Gym & Training', 'Nike', '27,28,29,30,31', 100),
(1013, 'Nike Metcon 4 Shoes', '400.00', 'The Metcon 4 Men\'s Cross Training, Weightlifting Shoe provides a strong, stable base, flexible support and extreme durability for a wide range of training activities, from sprints and sled pushes to l', 'Male', 'Gym & Training', 'Nike', '27,28,29,30,31', 100),
(1014, 'Nike Lunar Prime Iron II Shoes', '225.00', 'The Nike Lunar Prime Iron II Men\'s Training Shoe features Flywire that integrates with the laces for locked-down support and a lightweight foam midsole for comfort during your most explosive workouts.', 'Male', 'Gym & Training', 'Nike', '27,28,29,30,31', 100),
(1015, 'Nike Zoom Train Command Shoes', '355.00', 'The Nike Zoom Train Command Men\'s Bootcamp, Gym Shoe provides locked-down support and Zoom Air cushioning for increased responsiveness during your workout.', 'Male', 'Gym & Training', 'Nike', '27,28,29,30,31', 100),
(1016, 'Nike Air Vapormax Flyknit 2 Shoes', '625.00', 'With the latest Max Air innovation underfoot, the Nike Air VaporMax Flyknit 2 Men\'s Running Shoe brings fresh design elements. The futuristic sole completes the package, for a shoe that\'s as ready for', 'Male', 'Running', 'Nike', '27,28,29,30,31', 100),
(1017, 'Nike Odyssey React Shoes', '350.00', 'The Nike Odyssey React Men\'s Running Shoe provides crazy comfort that lasts as long as you can run. The upper of the Nike Odyssey React is built with a lightweight, breathable fabric instead of the pr', 'Male', 'Running', 'Nike', '27,28,29,30,31', 100),
(1018, 'Nike Zoom Fly Shoes', '500.00', 'Built with a carbon-infused nylon plate inspired by the VaporFly 4%—our most efficient marathon shoe ever—the Nike Zoom Fly Men\'s Running Shoe is the perfect response to the demands of your toughest t', 'Male', 'Running', 'Nike', '27,28,29,30,31', 100),
(1019, 'Nike Free RN Commuter 2017 Shoes', '410.00', 'The Nike Free RN Commuter 2017 Men\'s Running Shoe adapts to your day. Perfect for a short run between work or errands, it features the ultra-flexible and innovative Free sole that lets your foot move ', 'Male', 'Running', 'Nike', '27,28,29,30,31', 100),
(1020, 'Nike Jordan Zoom Tenacity Shoes', '450.00', 'The Jordan Zoom Tenacity Men\'s Shoe offers responsive cushioning and lightweight comfort for the user in order for them to experience the ultimate running experience. ', 'Male', 'Running', 'Nike', '27,28,29,30,31', 100),
(1021, 'Nike PG 2 Shoes', '355.00', 'The PG 2 Basketball Shoe is designed for the game\'s most versatile players. It\'s light yet strong, with supportive straps and comfortable cushioning that responds to every fast, focused step.', 'Female', 'Basketball', 'Nike', '25,26,27,28,29', 100),
(1022, 'Nike LeBron 15 Shoes', '500.00', 'The LeBron 15 Basketball Shoe features a new kind of Flyknit and a powerful combination of cushioning designed to meet the demands of explosive players like LeBron.', 'Female', 'Basketball', 'Nike', '25,26,27,28,29', 100),
(1023, 'Nike Hyperdunk 2017 (Team) Shoes', '450.00', 'The Nike Hyperdunk 2017 Women\'s Basketball Shoe features the latest revolution in basketball cushioning: ultra-responsive Nike React foam designed to help you play harder and go further.', 'Female', 'Basketball', 'Nike', '25,26,27,28,29', 100),
(1024, 'Nike Kobe A.D. NXT 360 Shoes', '650.00', 'The Kobe A.D. NXT 360 Basketball Shoe features a Flyknit upper that wraps your foot for lightweight support. Responsive cushioning and excellent traction help you push past your potential and your opp', 'Female', 'Basketball', 'Nike', '25,26,27,28,29', 100),
(1025, 'Nike Lebron Soldier XII Shoes', '330.00', 'The LeBron Soldier XII Men\'s Basketball Shoe delivers lightweight, responsive comfort on the court with Nike Zoom Air cushioning. Adjustable hook-and-loop straps offer personalised, secure lockdown.', 'Female', 'Basketball', 'Nike', '25,26,27,28,29', 100),
(1026, 'Nike FI Flex Women\'s Ver Shoes', '300.00', 'The Nike FI Flex Women\'s Golf Shoe flexes with your foot for a smooth, natural feel and features lightweight cushioning to help keep you comfortable through to the eighteenth hole.', 'Female', 'Golf', 'Nike', '25,26,27,28,29', 100),
(1027, 'Nike Lunar Control Vapor Shoes', '565.00', 'The Nike Lunar Control Vapor (Wide) Women\'s Golf Shoe features a waterproof upper to help you stay dry and an Articulated Integrated Traction pattern to help stabilise your swing and offer traction in', 'Female', 'Golf', 'Nike', '25,26,27,28,29', 100),
(1028, 'Nike Lunar Command 2 Women\'s Ver Shoes', '450.00', 'The Nike Lunar Command 2 Women\'s Golf Shoe is made with Flywire technology and a Lunarlon midsole for adaptive support and springy cushioning from your first drive to your final putt.', 'Female', 'Golf', 'Nike', '25,26,27,28,29', 100),
(1029, 'Nike Lunar Control Vapor 2 Women\'s Ver Shoes', '515.00', 'The Nike Lunar Control Vapor 2 Women\'s Golf Shoe delivers the grip, support and comfort you need to drive further off the tee.', 'Female', 'Golf', 'Nike', '25,26,27,28,29', 100),
(1030, 'Nike Air Zoom 90 IT Women\'s Ver Shoes', '485.00', 'An updated favourite of Rory McIlroy\'s, the Nike Air Zoom 90 IT Women\'s Golf Shoe features a waterproof upper and incredible traction for those who don\'t let the weather stand in their way.', 'Female', 'Golf', 'Nike', '25,26,27,28,29', 100),
(1031, 'Nike Free TR Flyknit 3 Shoes', '425.00', 'The Nike Free TR Flyknit 3 Women\'s Training Shoe offers lightweight support and breathability for fitness classes. With a wide, flat heel, it also provides exceptional stability during high-intensity ', 'Female', 'Gym & Training', 'Nike', '25,26,27,28,29', 100),
(1032, 'Nike Free TR8 Shoes', '350.00', 'The Nike Free TR8 Women\'s Training shoe has a stronger heel than ever before, plus extra cushioning that hugs and contains your foot. The sole is still unbelievably flexible, offering a natural, light', 'Female', 'Gym & Training', 'Nike', '25,26,27,28,29', 100),
(1033, 'Nike Air Zoom Fearless Flyknit Selfie Shoes', '335.00', 'The Nike Air Zoom Fearless Flyknit Selfie Women\'s Training Shoe supports you through quick runs and high-intensity sessions with its flexible stability, responsive cushioning and durable traction.', 'Female', 'Gym & Training', 'Nike', '25,26,27,28,29', 100),
(1034, 'Nike Free TR 7 Selfie Shoes', '325.00', 'Designed for natural movement and lockdown during intense workouts, the Nike Free TR 7 Selfie Women\'s Training Shoe features a flexible tri-star sole pattern and a lightweight mesh construction.', 'Female', 'Gym & Training', 'Nike', '25,26,27,28,29', 100),
(1035, 'Nike Flex Supreme TR 6 Shoes', '215.00', 'The Nike Flex Supreme TR 6 Women\'s Training Shoe features a flexible construction and sole to promote a natural range of motion during your workout.', 'Female', 'Gym & Training', 'Nike', '25,26,27,28,29', 100),
(1036, 'Nike Air Zoom Pegasus 35 Premium Shoes', '495.00', 'The Nike Air Zoom Pegasus 35 Premium is built for runners at every level, whether you\'re a seasoned veteran or just starting out. The cushioning combines full-length Zoom Air and a soft foam that\'s be', 'Female', 'Running', 'Nike', '25,26,27,28,29', 100),
(1037, 'Nike Air Vapormax Flyknit Moc 2 Shoes', '625.00', 'With a sleeker take on the original design, the Nike Air VaporMax Flyknit Moc 2 Running Shoe delivers a lightweight, bouncy ride. The revolutionary cushioning creates a gravity-defying sensation direc', 'Female', 'Running', 'Nike', '25,26,27,28,29', 100),
(1038, 'Nike Epic React Flyknit Shoes', '550.00', 'The Nike Epic React Flyknit Women\'s Running Shoe provides crazy comfort that lasts as long as you can run. Its Nike React foam cushioning is responsive yet lightweight, durable yet soft.', 'Female', 'Running', 'Nike', '25,26,27,28,29', 100),
(1039, 'Nike Lunar Epic Low Flyknit 2 Shoes', '775.00', 'The Nike LunarEpic Low Flyknit 2 Women\'s Running Shoe improves on its predecessor with an updated slip-on design for a snug, seamless fit. The same luxurious cushioning and targeted support remain to ', 'Female', 'Running', 'Nike', '25,26,27,28,29', 100),
(1040, 'Nike Flex 2017 RN Shoes', '360.00', 'The Nike Flex 2017 RN Women\'s Running Shoe helps keep you light on your feet from start to finish with an engineered mesh upper and lightweight, flexible outsole.', 'Female', 'Running', 'Nike', '25,26,27,28,29', 100),
(2001, 'Adidas DAME D.O.L.L.A  Shoes', '470.00', 'These basketball shoes combine Damian Lillard\'s signature look with a multicolour graphic inspired by summer runs and pickup games. The comfortable cushioning gives you stability for quick, side-to-si', 'Male', 'Basketball', 'Adidas', '27,28,29,30,31', 100),
(2002, 'Adidas Crazylight Boost 2018 Shoes', '515.00', 'Featuring a multicolour graphic inspired by outdoor runs and pickup games, these lightweight shoes are built for players who rely on quickness and acceleration by unleashing raw energy with every chan', 'Male', 'Basketball', 'Adidas', '27,28,29,30,31', 100),
(2003, 'Adidas Harden Vol. 2 LS Shoes', '655.00', 'Gas, brake, cook. James Harden freezes defenders with his signature mix of Euro steps, hesitations and lightning-quick crossovers. These shoes combine James Harden\'s go-to style with a streetwear insp', 'Male', 'Basketball', 'Adidas', '27,28,29,30,31', 100),
(2004, 'Adidas DAME 4 Shoes', '359.00', 'A breathable, lightweight upper and comfortable cushioning gives you stability for quick, side-to-side movement and acceleration.', 'Male', 'Basketball', 'Adidas', '27,28,29,30,31', 100),
(2005, 'Adidas Explosive Bounce 2018 Shoes', '390.00', 'From no-look passes to lockdown defence, build your game from the ground up in comfort. These shoes feature enhanced cushioning in the midsole and sockliner, and a lightweight, durable upper that keep', 'Male', 'Basketball', 'Adidas', '27,28,29,30,31', 100),
(2006, 'Adidas Ultraboost Shoes', '699.00', 'These running shoes combine comfort and high-performance technology for a best-ever-run feeling. Responsive midsole cushioning and a flexible outsole deliver a smooth and energised ride.', 'Male', 'Running', 'Adidas', '27,28,29,30,31', 100),
(2007, 'Adidas AlphaBounce Beyond Shoes', '320.00', 'Designed for athletes who run to be the best at their sport, these shoes support multidirectional movements with flexible cushioning and a wide, stable platform in the forefoot and heel.', 'Male', 'Running', 'Adidas', '27,28,29,30,31', 100),
(2008, 'Adidas Ultraboost Parley LTD Shoes', '800.00', 'These running shoes combine comfort and high-performance technology. They have a foot-hugging knit upper that\'s made with moisture-wicking yarn spun from recycled plastic. A supportive knit cage at th', 'Male', 'Running', 'Adidas', '27,28,29,30,31', 100),
(2009, 'Adidas Pureboost GO Shoes', '440.00', 'These shoes are made with a light, flexible knit upper that adapts to your foot\'s natural movement. A wider forefoot and reinforced heel give stability when taking curbs and corners. Responsive cushio', 'Male', 'Running', 'Adidas', '27,28,29,30,31', 100),
(2010, 'Adidas Ultraboost Uncaged Shoes', '699.00', 'Leave the scissors in the drawer. Inspired by runners who cut off the cages of their shoes, adidas created a simplified design to give you a feeling of free and unrestricted movement. The shoes have a', 'Male', 'Running', 'Adidas', '27,28,29,30,31', 100),
(2011, 'Adidas Crazytrain LT Shoes', '315.00', 'These training shoes are designed to take on any sport or workout. Featuring a lightweight mesh upper for breathable comfort, they include zoned overlays for targeted support. Flexible midsole cushion', 'Male', 'Gym & Training', 'Adidas', '27,28,29,30,31', 100),
(2012, 'Adidas Crazytrain Elite Shoes', '559.00', 'These shoes have a training-specific design that supports multidirectional movement. The lightweight mesh upper hugs the foot with a sock-like fit. Built-in midfoot support provides stability, and for', 'Male', 'Gym & Training', 'Adidas', '27,28,29,30,31', 100),
(2013, 'Adidas AlphaBounce Trainer Shoes', '370.00', 'These cross-training shoes give you stability as you move from barbell exercises to box jumps, burpees or a short run. Made with strength training in mind, they have a low heel drop to give you a soli', 'Male', 'Gym & Training', 'Adidas', '27,28,29,30,31', 100),
(2014, 'Adidas 24/7 Shoes', '385.00', 'Stretch, mobilise or warm up in these training shoes. The shoes feature a breathable mesh upper that flexes and adapts to the changing shape of your foot as you move. The lacing system locks down the ', 'Male', 'Gym & Training', 'Adidas', '27,28,29,30,31', 100),
(2015, 'Adidas Athletic 24/7 TR Shoes', '399.00', 'These training shoes feature a sockfit upper that adapts to your foot for a fit that supports every step. The stretchy mesh upper has a split tongue design for easy in and out. An additional moulded s', 'Male', 'Gym & Training', 'Adidas', '27,28,29,30,31', 100),
(2016, 'Adidas Harden LS 2 Shoes', '600.00', 'James Harden freezes defenders with his signature Euro steps, hesitations and lightning-quick crossovers. Built for flexibility, featuring ultra-soft cushioning for all-day comfort.', 'Female', 'Basketball', 'Adidas', '25,26,27,28,29', 100),
(2017, 'Adidas Harden Vol. 2 Shoes', '535.00', 'These basketball shoes are built to create separation from opponents and get buckets with Harden\'s go-to style. Boost returns energy from opening to final whistle, while the stitched fibre upper provi', 'Female', 'Basketball', 'Adidas', '25,26,27,28,29', 100),
(2018, 'Adidas Crazy BYW X Shoes', '705.00', 'These Crazy BYW shoes are created in collaboration with artist Daniel Arsham. Like the natural movement of the \'90s-era FYW concept, these shoes feature a \"Boost You Wear\" midsole with a triple Boost ', 'Female', 'Basketball', 'Adidas', '25,26,27,28,29', 100),
(2019, 'Adidas DAME 3 Shoes', '259.00', 'Represent Dame Time all summer long. A breathable, lightweight upper and comfortable cushioning gives you stability for quick, side-to-side movement and acceleration', 'Female', 'Basketball', 'Adidas', '25,26,27,28,29', 100),
(2020, 'Adidas Crazylight Boost 2017 Shoes', '560.00', 'Designed for lethal combination of speed and agility, these shoes keeps your feet light. Full-length Boost provides ultra-responsive cushioning while keeping you low to the ground, and the TPU wrap ad', 'Female', 'Basketball', 'Adidas', '25,26,27,28,29', 100),
(2021, 'Adidas Ultraboost X Parley Shoes', '705.00', 'These shoes were created using motion capture technology to meet the needs of the female runner. The stretchy knit upper is made with yarn spun from Parley Ocean Plastic??? and adapts to the changing ', 'Female', 'Running', 'Adidas', '25,26,27,28,29', 100),
(2022, 'Adidas Adizero Takumi Sen 3 Shoes', '555.00', 'The expert craftsmanship of Japanese cobblers Omori and Mimura gives these elite racing shoes a superior fit and a fast, light ride. An energy-returning boost??? midsole balances cushioning with groun', 'Female', 'Running', 'Adidas', '25,26,27,28,29', 100),
(2023, 'Adidas Ultraboost X Shoes', '650.00', 'Serious runners will find a fluid stride in these women\'s running shoes. A super-grippy outsole offers exceptional traction on wet and dry streets.', 'Female', 'Running', 'Adidas', '25,26,27,28,29', 100),
(2024, 'Adidas Alphabounce 1 Parley Shoes', '399.00', 'These women\'s running shoes are designed with a seamless mesh upper that supports and flexes with your foot through the gait cycle. Underfoot, Bounce provides comfortable cushioning.', 'Female', 'Running', 'Adidas', '25,26,27,28,29', 100),
(2025, 'Adidas Solar Glide Shoes', '495.00', 'A go-to pair for all your runs, these shoes have energised cushioning that works with a flexible outsole to deliver a smooth and comfortable ride. The breathable mesh upper is designed to support and ', 'Female', 'Running', 'Adidas', '25,26,27,28,29', 100),
(2026, 'Adidas Pureboost X TR 3.0 Shoes', '600.00', 'These shoes bring enhanced support to each step with ultra-responsive cushioning and a sock-like construction. A design collaboration with Stella McCartney, the versatile shoes have a multilayered mes', 'Female', 'Gym & Training', 'Adidas', '25,26,27,28,29', 100),
(2027, 'Adidas Ultraboost X All Terrain Shoes', '850.00', 'These streamlined running shoes have a slip-on design that wraps the foot in supportive comfort. With a mid cut, they ride on a rubber outsole that grips the pavement in wet conditions. Matte and shin', 'Female', 'Gym & Training', 'Adidas', '25,26,27,28,29', 100),
(2028, 'Adidas Crazytrain Pro Shoes', '655.00', 'The lightweight design of the adidas by Stella McCartney CrazyTrain Pro Shoes offers comfort and stability as you power through drills. They have a sock-like construction with strategic support zones.', 'Female', 'Gym & Training', 'Adidas', '25,26,27,28,29', 100),
(2029, 'Adidas Ultraboost X Mid Shoes', '995.00', 'The adidas by Stella McCartney Ultraboost X Mid Shoes provide a stable grip and adaptive support to every step of your 10K. Energy-returning Boost cushioning propels you through the final mile.', 'Female', 'Gym & Training', 'Adidas', '25,26,27,28,29', 100),
(2030, 'Adidas Ultraboost Women\'s Shoes', '700.00', 'Melt away miles in these shoes as each step propels you forward. A design collaboration with Stella McCartney, they have a knit upper that adapts to the changing shape of your foot for flexible comfor', 'Female', 'Gym & Training', 'Adidas', '25,26,27,28,29', 100);

-- --------------------------------------------------------

--
-- 替换视图以便查看 `user`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `user`;
CREATE TABLE `user` (
`username` varchar(50)
,`hash` varchar(255)
,`name` varchar(100)
,`email` varchar(200)
,`role` varchar(8)
);

-- --------------------------------------------------------

--
-- 视图结构 `user`
--
DROP TABLE IF EXISTS `user`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user`  AS  select `admin`.`username` AS `username`,`admin`.`hash` AS `hash`,`admin`.`name` AS `name`,`admin`.`email` AS `email`,'admin' AS `role` from `admin` union select `customer`.`username` AS `username`,`customer`.`hash` AS `hash`,`customer`.`name` AS `name`,`customer`.`email` AS `email`,'customer' AS `role` from `customer` ;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
