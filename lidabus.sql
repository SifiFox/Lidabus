-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 16, 2021 at 02:45 PM
-- Server version: 5.7.25-log
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lidabus`
--

-- --------------------------------------------------------

--
-- Table structure for table `autos`
--

CREATE TABLE `autos` (
  `ID` int(11) NOT NULL,
  `Mark` varchar(65) NOT NULL,
  `Model` varchar(65) NOT NULL,
  `GovernmentNumber` varchar(65) NOT NULL,
  `SeatsNumber` int(2) NOT NULL,
  `Color` varchar(65) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `autos`
--

INSERT INTO `autos` (`ID`, `Mark`, `Model`, `GovernmentNumber`, `SeatsNumber`, `Color`) VALUES
(1, 'Volkswagen', 'Crafter', '1447MM-4', 14, 'White');

-- --------------------------------------------------------

--
-- Table structure for table `auto_driver`
--

CREATE TABLE `auto_driver` (
  `ID` int(11) NOT NULL,
  `ID_Auto` int(11) NOT NULL,
  `ID_Driver` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `ID` int(11) NOT NULL,
  `Name` varchar(65) NOT NULL,
  `Email` varchar(65) NOT NULL,
  `PhoneNumber` varchar(13) NOT NULL,
  `Password` longtext NOT NULL,
  `Role` varchar(65) NOT NULL DEFAULT 'Driver',
  `Status` varchar(10) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`ID`, `Name`, `Email`, `PhoneNumber`, `Password`, `Role`, `Status`) VALUES
(1, 'driverTests', 'driver@test.', '+375337182470', '90b278781bd4cdcc342da032aeb66f016c14da109e294d1e8155be8aa4b1ce8e', 'Driver', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `ID` int(11) NOT NULL,
  `ID_User` int(11) NOT NULL,
  `ID_Auto` int(11) NOT NULL,
  `ID_Promocode` int(11) NOT NULL,
  `Date` varchar(65) NOT NULL,
  `Status` varchar(65) NOT NULL,
  `PassengersCount` int(11) NOT NULL,
  `Cost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `promocodes`
--

CREATE TABLE `promocodes` (
  `ID` int(11) NOT NULL,
  `Promocode` varchar(6) NOT NULL,
  `Sale` float NOT NULL DEFAULT '0.05'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `promocodes`
--

INSERT INTO `promocodes` (`ID`, `Promocode`, `Sale`) VALUES
(8, 'Y0DLcx', 0.05),
(10, 'DyFWUh', 0.05);

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `ID` int(11) NOT NULL,
  `ID_Auto` int(11) NOT NULL,
  `Direction` varchar(65) NOT NULL,
  `Pickup` varchar(65) NOT NULL,
  `Date` datetime NOT NULL,
  `Status` varchar(65) NOT NULL DEFAULT 'Free'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`ID`, `ID_Auto`, `Direction`, `Pickup`, `Date`, `Status`) VALUES
(1, 1, 'Минск-Лида', 'Автовокзал', '2021-03-15 00:00:00', 'Free'),
(2, 1, 'Лида-Минск', 'Автовокзал', '2021-03-15 00:00:00', 'Free');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `Name` varchar(65) NOT NULL,
  `Email` varchar(65) NOT NULL,
  `PhoneNumber` varchar(13) NOT NULL,
  `Password` longtext NOT NULL,
  `Role` varchar(65) NOT NULL DEFAULT 'User',
  `Status` varchar(10) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `Name`, `Email`, `PhoneNumber`, `Password`, `Role`, `Status`) VALUES
(1, 'test1', 'test1@a.com', '+375257182470', '90b278781bd4cdcc342da032aeb66f016c14da109e294d1e8155be8aa4b1ce8e', 'User', 'Block'),
(2, 'test1', 'test1@a.com', '+375257182470', '90b278781bd4cdcc342da032aeb66f016c14da109e294d1e8155be8aa4b1ce8e', 'User', 'Block'),
(3, 'test1', 'test1@a.com', '+375257182470', '90b278781bd4cdcc342da032aeb66f016c14da109e294d1e8155be8aa4b1ce8e', 'User', 'Active'),
(4, 'test1', 'test1@a.com1', '+375257182470', '53e63bb22111c0edadfbac8f1733028c6c14da109e294d1e8155be8aa4b1ce8e', 'User', 'Active'),
(5, 'test1', '1test1@a1.com1', '+375257182470', '90b278781bd4cdcc342da032aeb66f016c14da109e294d1e8155be8aa4b1ce8e', 'User', 'Active'),
(6, 'test1', '2test1@a1.com1', '+375257182470', '0c154d5f65297415c9d2959fa699798b6c14da109e294d1e8155be8aa4b1ce8e', 'User', 'Active'),
(7, 'test1', '3test1@a1.com1', '+375257182470', '34ed0abdcca518ec6c8bf7eb93c7f33f6c14da109e294d1e8155be8aa4b1ce8e', 'User', 'Active'),
(8, 'test1', '4test1@a1.com1', '+375257182470', '90b278781bd4cdcc342da032aeb66f016c14da109e294d1e8155be8aa4b1ce8e', 'User', 'Active'),
(9, 'test1', '6test1@a1.com1', '+375257182471', '90b278781bd4cdcc342da032aeb66f016c14da109e294d1e8155be8aa4b1ce8e', 'User', 'Active'),
(10, 'ADMIN', 'ADMIN', 'ADMIN', 'ADMIN', 'Admin', 'Active'),
(11, 'asd', 'das', 'das', 'dasd', 'Driver', 'Active'),
(12, 'asd', 'das', 'das', 'dasd', 'Driver', 'Active'),
(13, 'driverTests', 'driver@test.by', '+375337182470', '90b278781bd4cdcc342da032aeb66f016c14da109e294d1e8155be8aa4b1ce8e', 'Driver', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `autos`
--
ALTER TABLE `autos`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `auto_driver`
--
ALTER TABLE `auto_driver`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_Auto` (`ID_Auto`),
  ADD KEY `ID_Driver` (`ID_Driver`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_User` (`ID_User`),
  ADD KEY `ID_Auto` (`ID_Auto`),
  ADD KEY `ID_Promocode` (`ID_Promocode`);

--
-- Indexes for table `promocodes`
--
ALTER TABLE `promocodes`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_Auto` (`ID_Auto`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `autos`
--
ALTER TABLE `autos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `auto_driver`
--
ALTER TABLE `auto_driver`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promocodes`
--
ALTER TABLE `promocodes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auto_driver`
--
ALTER TABLE `auto_driver`
  ADD CONSTRAINT `auto_driver_ibfk_1` FOREIGN KEY (`ID_Auto`) REFERENCES `autos` (`ID`),
  ADD CONSTRAINT `auto_driver_ibfk_2` FOREIGN KEY (`ID_Driver`) REFERENCES `drivers` (`ID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`ID_User`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`ID_Auto`) REFERENCES `autos` (`ID`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`ID_Promocode`) REFERENCES `promocodes` (`ID`);

--
-- Constraints for table `routes`
--
ALTER TABLE `routes`
  ADD CONSTRAINT `routes_ibfk_1` FOREIGN KEY (`ID_Auto`) REFERENCES `autos` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
