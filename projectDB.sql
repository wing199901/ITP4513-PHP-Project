-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主機： localhost
-- 產生時間： 2019 年 06 月 26 日 11:23
-- 伺服器版本： 10.1.40-MariaDB
-- PHP 版本： 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `projectDB`
--

-- --------------------------------------------------------

--
-- 資料表結構 `Administrator`
--

CREATE TABLE `Administrator` (
  `email` varchar(100) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 傾印資料表的資料 `Administrator`
--

INSERT INTO `Administrator` (`email`, `firstName`, `lastName`, `password`) VALUES
('wing199901@gmail.com', 'Steven', 'Siu', '19991110');

-- --------------------------------------------------------

--
-- 資料表結構 `Dealer`
--

CREATE TABLE `Dealer` (
  `dealerID` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phoneNumber` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 資料表結構 `OrderPart`
--

CREATE TABLE `OrderPart` (
  `orderID` int(11) NOT NULL,
  `partNumber` int(11) NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 資料表結構 `Orders`
--

CREATE TABLE `Orders` (
  `orderID` int(11) NOT NULL,
  `dealerID` varchar(50) NOT NULL,
  `orderDate` date NOT NULL,
  `deliveryAddress` varchar(255) DEFAULT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 資料表結構 `Part`
--

CREATE TABLE `Part` (
  `partNumber` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `partName` varchar(100) NOT NULL,
  `stockQuantity` int(11) NOT NULL,
  `stockPrice` decimal(10,2) NOT NULL,
  `stockStatus` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 傾印資料表的資料 `Part`
--

INSERT INTO `Part` (`partNumber`, `email`, `partName`, `stockQuantity`, `stockPrice`, `stockStatus`) VALUES
(100001, 'wing199901@gmail.com', 'test', 1, '10.00', 1),
(100002, 'wing199901@gmail.com', 'test02', 1, '10.00', 2),
(100003, 'wing199901@gmail.com', 'test03', 0, '10.00', 1),
(100004, 'wing199901@gmail.com', 'test04', 1, '10.00', 1),
(100005, 'wing199901@gmail.com', 'test05', 1, '10.00', 1),
(100006, 'wing199901@gmail.com', 'test06', 1, '10.00', 1),
(100008, 'wing199901@gmail.com', 'test08', 1, '10.00', 1),
(100009, 'wing199901@gmail.com', 'test09', 0, '20.00', 2),
(100010, 'wing199901@gmail.com', 'test10', 0, '20.00', 2),
(100011, 'wing199901@gmail.com', 'test11', 0, '20.00', 2),
(100012, 'wing199901@gmail.com', 'test12', 0, '20.00', 2);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `Administrator`
--
ALTER TABLE `Administrator`
  ADD PRIMARY KEY (`email`);

--
-- 資料表索引 `Dealer`
--
ALTER TABLE `Dealer`
  ADD PRIMARY KEY (`dealerID`);

--
-- 資料表索引 `OrderPart`
--
ALTER TABLE `OrderPart`
  ADD KEY `FKOrderPart106296` (`orderID`),
  ADD KEY `FKOrderPart737123` (`partNumber`);

--
-- 資料表索引 `Orders`
--
ALTER TABLE `Orders`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `FKOrders795865` (`dealerID`);

--
-- 資料表索引 `Part`
--
ALTER TABLE `Part`
  ADD PRIMARY KEY (`partNumber`),
  ADD UNIQUE KEY `partName` (`partName`),
  ADD KEY `FKPart451022` (`email`);

--
-- 在傾印的資料表使用自動增長(AUTO_INCREMENT)
--

--
-- 使用資料表自動增長(AUTO_INCREMENT) `Orders`
--
ALTER TABLE `Orders`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100001;

--
-- 使用資料表自動增長(AUTO_INCREMENT) `Part`
--
ALTER TABLE `Part`
  MODIFY `partNumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100013;

--
-- 已傾印資料表的限制(constraint)
--

--
-- 資料表的限制(constraint) `OrderPart`
--
ALTER TABLE `OrderPart`
  ADD CONSTRAINT `FKOrderPart106296` FOREIGN KEY (`orderID`) REFERENCES `Orders` (`orderID`),
  ADD CONSTRAINT `FKOrderPart737123` FOREIGN KEY (`partNumber`) REFERENCES `Part` (`partNumber`);

--
-- 資料表的限制(constraint) `Orders`
--
ALTER TABLE `Orders`
  ADD CONSTRAINT `FKOrders795865` FOREIGN KEY (`dealerID`) REFERENCES `Dealer` (`dealerID`);

--
-- 資料表的限制(constraint) `Part`
--
ALTER TABLE `Part`
  ADD CONSTRAINT `FKPart451022` FOREIGN KEY (`email`) REFERENCES `Administrator` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
