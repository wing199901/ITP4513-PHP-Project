-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 30, 2019 at 12:28 PM
-- Server version: 10.1.22-MariaDB
-- PHP Version: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projectDB`
--
CREATE DATABASE IF NOT EXISTS `projectDB` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `projectDB`;

-- --------------------------------------------------------

--
-- Table structure for table `Administrator`
--

CREATE TABLE `Administrator` (
  `email` varchar(100) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Dealer`
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
-- Table structure for table `OrderPart`
--

CREATE TABLE `OrderPart` (
  `orderID` int(11) NOT NULL,
  `partNumber` int(11) NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Orders`
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
-- Table structure for table `Part`
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
-- Indexes for dumped tables
--

--
-- Indexes for table `Administrator`
--
ALTER TABLE `Administrator`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `Dealer`
--
ALTER TABLE `Dealer`
  ADD PRIMARY KEY (`dealerID`);

--
-- Indexes for table `OrderPart`
--
ALTER TABLE `OrderPart`
  ADD KEY `FKOrderPart106296` (`orderID`),
  ADD KEY `FKOrderPart737123` (`partNumber`);

--
-- Indexes for table `Orders`
--
ALTER TABLE `Orders`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `FKOrders795865` (`dealerID`);

--
-- Indexes for table `Part`
--
ALTER TABLE `Part`
  ADD PRIMARY KEY (`partNumber`),
  ADD UNIQUE KEY `partName` (`partName`),
  ADD KEY `FKPart451022` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Orders`
--
ALTER TABLE `Orders`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Part`
--
ALTER TABLE `Part`
  MODIFY `partNumber` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `OrderPart`
--
ALTER TABLE `OrderPart`
  ADD CONSTRAINT `FKOrderPart106296` FOREIGN KEY (`orderID`) REFERENCES `Orders` (`orderID`),
  ADD CONSTRAINT `FKOrderPart737123` FOREIGN KEY (`partNumber`) REFERENCES `Part` (`partNumber`);

--
-- Constraints for table `Orders`
--
ALTER TABLE `Orders`
  ADD CONSTRAINT `FKOrders795865` FOREIGN KEY (`dealerID`) REFERENCES `Dealer` (`dealerID`);

--
-- Constraints for table `Part`
--
ALTER TABLE `Part`
  ADD CONSTRAINT `FKPart451022` FOREIGN KEY (`email`) REFERENCES `Administrator` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
