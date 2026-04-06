-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2026 at 02:07 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `election`
--

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `candID` int(20) NOT NULL,
  `posID` int(20) NOT NULL,
  `candFName` varchar(255) NOT NULL,
  `candMName` varchar(255) NOT NULL,
  `candLName` varchar(255) NOT NULL,
  `candStat` set('OPEN','CLOSE') NOT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `posID` int(20) NOT NULL,
  `posName` varchar(255) NOT NULL,
  `numOfPositions` int(20) NOT NULL,
  `posStat` set('OPEN','CLOSED') NOT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`posID`, `posName`, `numOfPositions`, `posStat`, `isDeleted`) VALUES
(1, 'President', 1, 'OPEN', 1),
(2, 'Vice President', 1, 'OPEN', 0),
(3, 'Senator', 12, 'OPEN', 0);

-- --------------------------------------------------------

--
-- Table structure for table `voters`
--

CREATE TABLE `voters` (
  `voterID` int(20) NOT NULL,
  `voterPass` varchar(255) NOT NULL,
  `voterFName` varchar(255) NOT NULL,
  `voterMName` varchar(255) NOT NULL,
  `voterLName` varchar(255) NOT NULL,
  `voterStat` set('OPEN','CLOSE') NOT NULL DEFAULT 'OPEN',
  `voted` set('YES','NO') NOT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `voteID` int(20) NOT NULL,
  `posID` int(20) UNSIGNED NOT NULL,
  `voterID` int(20) NOT NULL,
  `candID` int(20) NOT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`candID`),
  ADD KEY `posID` (`posID`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`posID`);

--
-- Indexes for table `voters`
--
ALTER TABLE `voters`
  ADD PRIMARY KEY (`voterID`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`voteID`),
  ADD KEY `posID` (`posID`),
  ADD KEY `fk_votes_voters` (`voterID`),
  ADD KEY `fk_votes_candidates` (`candID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `voteID` int(20) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `candidates`
--
ALTER TABLE `candidates`
  ADD CONSTRAINT `posID` FOREIGN KEY (`posID`) REFERENCES `positions` (`posID`);

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `fk_votes_candidates` FOREIGN KEY (`candID`) REFERENCES `candidates` (`candID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_votes_voters` FOREIGN KEY (`voterID`) REFERENCES `voters` (`voterID`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
