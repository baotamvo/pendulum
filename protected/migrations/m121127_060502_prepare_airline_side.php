<?php

class m121127_060502_prepare_airline_side extends CDbMigration
{
	public function down()
	{
		echo "m121127_060502_prepare_airline_side does not support migration down.\n";
		return false;
	}

	
	public function safeUp()
	{
        $sql = '-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 27, 2012 at 03:15 AM
-- Server version: 5.5.25a
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `wingstat_wingstats`
--

-- --------------------------------------------------------

--
-- Table structure for table `airlinejobpositions`
--

DROP TABLE IF EXISTS `airlinejobpositions`;
CREATE TABLE IF NOT EXISTS `airlinejobpositions` (
  `airlinejobpositionId` int(11) NOT NULL AUTO_INCREMENT,
  `airlineId` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `description` varchar(2000) CHARACTER SET utf32 COLLATE utf32_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`airlinejobpositionId`),
  KEY `airlineId` (`airlineId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `airlinejobpostings`
--

DROP TABLE IF EXISTS `airlinejobpostings`;
CREATE TABLE IF NOT EXISTS `airlinejobpostings` (
  `airlinejobpostingId` int(11) NOT NULL AUTO_INCREMENT,
  `jobpositionId` int(11) NOT NULL,
  `title` varchar(200) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `jobdescription` text CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `startdate` date DEFAULT NULL,
  `expires` date DEFAULT NULL,
  `typerating` varchar(1000) CHARACTER SET utf32 COLLATE utf32_unicode_ci DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `education` varchar(45) CHARACTER SET utf32 COLLATE utf32_unicode_ci DEFAULT NULL,
  `backgroundcheck` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`airlinejobpostingId`),
  KEY `jobpositionId` (`jobpositionId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `airlines`
--

DROP TABLE IF EXISTS `airlines`;
CREATE TABLE IF NOT EXISTS `airlines` (
  `airlineId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `email` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(1000) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `website` varchar(1000) CHARACTER SET utf16 COLLATE utf16_unicode_ci DEFAULT NULL,
  `about` longtext CHARACTER SET utf32 COLLATE utf32_unicode_ci,
  `address` varchar(500) CHARACTER SET utf32 COLLATE utf32_unicode_ci DEFAULT NULL,
  `city` varchar(500) CHARACTER SET utf16 COLLATE utf16_unicode_ci DEFAULT NULL,
  `stateId` int(11) DEFAULT NULL,
  `zip` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `countryId` int(11) DEFAULT NULL,
  `phone` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `datecreated` date DEFAULT NULL,
  PRIMARY KEY (`airlineId`),
  KEY `airlineuser` (`userId`),
  KEY `airlinecountry` (`countryId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jobapplications`
--

DROP TABLE IF EXISTS `jobapplications`;
CREATE TABLE IF NOT EXISTS `jobapplications` (
  `jobapplicationId` int(11) NOT NULL AUTO_INCREMENT,
  `airlinejobpostingId` int(11) NOT NULL,
  `pilotId` int(11) NOT NULL,
  `timecreated` datetime NOT NULL,
  `jobapplicationstatusId` int(11) NOT NULL,
  PRIMARY KEY (`jobapplicationId`),
  KEY `jobapplicationstatusId` (`jobapplicationstatusId`),
  KEY `pilotId` (`pilotId`),
  KEY `airlinejobpostingId` (`airlinejobpostingId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jobapplicationstatuses`
--

DROP TABLE IF EXISTS `jobapplicationstatuses`;
CREATE TABLE IF NOT EXISTS `jobapplicationstatuses` (
  `jobapplicationstatusId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `airlineId` int(11) DEFAULT NULL,
  `jobapplicationstatusgroupId` int(11) NOT NULL,
  PRIMARY KEY (`jobapplicationstatusId`),
  KEY `jobapplicationstatusgroupId` (`jobapplicationstatusgroupId`),
  KEY `airlineId` (`airlineId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jobapplicationstatusgroups`
--

DROP TABLE IF EXISTS `jobapplicationstatusgroups`;
CREATE TABLE IF NOT EXISTS `jobapplicationstatusgroups` (
  `jobapplicationstatusgroupId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `airlineId` int(11) DEFAULT NULL,
  PRIMARY KEY (`jobapplicationstatusgroupId`),
  KEY `airlineId` (`airlineId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jobapplication_trainingclasses`
--

DROP TABLE IF EXISTS `jobapplication_trainingclasses`;
CREATE TABLE IF NOT EXISTS `jobapplication_trainingclasses` (
  `jobapplicationId` int(11) NOT NULL,
  `trainingclassId` int(11) NOT NULL,
  PRIMARY KEY (`jobapplicationId`,`trainingclassId`),
  KEY `trainingclassId` (`trainingclassId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jobinterviews`
--

DROP TABLE IF EXISTS `jobinterviews`;
CREATE TABLE IF NOT EXISTS `jobinterviews` (
  `jobinterviewId` int(11) NOT NULL AUTO_INCREMENT,
  `jobapplicationId` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `location` varchar(200) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `current` tinyint(1) NOT NULL,
  PRIMARY KEY (`jobinterviewId`),
  KEY `jobapplicationId` (`jobapplicationId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `trainingclasses`
--

DROP TABLE IF EXISTS `trainingclasses`;
CREATE TABLE IF NOT EXISTS `trainingclasses` (
  `trainingclassId` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `location` varchar(200) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `description` varchar(2000) CHARACTER SET utf32 COLLATE utf32_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`trainingclassId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `airlinejobpositions`
--
ALTER TABLE `airlinejobpositions`
  ADD CONSTRAINT `airlinejobpositions_ibfk_1` FOREIGN KEY (`airlineId`) REFERENCES `airlines` (`airlineId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `airlinejobpostings`
--
ALTER TABLE `airlinejobpostings`
  ADD CONSTRAINT `airlinejobpostings_ibfk_1` FOREIGN KEY (`jobpositionId`) REFERENCES `jobpositions` (`jobpositionId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `airlines`
--
ALTER TABLE `airlines`
  ADD CONSTRAINT `airlines_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `airlines_ibfk_2` FOREIGN KEY (`countryId`) REFERENCES `countries` (`countryId`) ON UPDATE CASCADE;

--
-- Constraints for table `jobapplications`
--
ALTER TABLE `jobapplications`
  ADD CONSTRAINT `jobapplications_ibfk_1` FOREIGN KEY (`airlinejobpostingId`) REFERENCES `airlinejobpostings` (`airlinejobpostingId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jobapplications_ibfk_2` FOREIGN KEY (`pilotId`) REFERENCES `pilots` (`pilotId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jobapplications_ibfk_3` FOREIGN KEY (`jobapplicationstatusId`) REFERENCES `jobapplicationstatuses` (`jobapplicationstatusId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jobapplicationstatuses`
--
ALTER TABLE `jobapplicationstatuses`
  ADD CONSTRAINT `jobapplicationstatuses_ibfk_2` FOREIGN KEY (`jobapplicationstatusgroupId`) REFERENCES `jobapplicationstatusgroups` (`jobapplicationstatusgroupId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jobapplicationstatuses_ibfk_1` FOREIGN KEY (`airlineId`) REFERENCES `airlines` (`airlineId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jobapplicationstatusgroups`
--
ALTER TABLE `jobapplicationstatusgroups`
  ADD CONSTRAINT `jobapplicationstatusgroups_ibfk_1` FOREIGN KEY (`airlineId`) REFERENCES `airlines` (`airlineId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jobapplication_trainingclasses`
--
ALTER TABLE `jobapplication_trainingclasses`
  ADD CONSTRAINT `jobapplication_trainingclasses_ibfk_1` FOREIGN KEY (`jobapplicationId`) REFERENCES `jobapplications` (`jobapplicationId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jobapplication_trainingclasses_ibfk_2` FOREIGN KEY (`trainingclassId`) REFERENCES `trainingclasses` (`trainingclassId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jobinterviews`
--
ALTER TABLE `jobinterviews`
  ADD CONSTRAINT `jobinterviews_ibfk_2` FOREIGN KEY (`jobapplicationId`) REFERENCES `jobapplications` (`jobapplicationId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Table structure for table `airlinejobpostingfields`
--

DROP TABLE IF EXISTS `airlinejobpostingfields`;
CREATE TABLE IF NOT EXISTS `airlinejobpostingfields` (
  `airlinejobpostingfieldId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `value` varchar(200) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `airlinejobpostingfieldtypeId` int(11) NOT NULL,
  PRIMARY KEY (`airlinejobpostingfieldId`),
  KEY `airlinejobpostingfieldtypeId` (`airlinejobpostingfieldtypeId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `airlinejobpostingfieldtypes`
--

DROP TABLE IF EXISTS `airlinejobpostingfieldtypes`;
CREATE TABLE IF NOT EXISTS `airlinejobpostingfieldtypes` (
  `airlinejobpostingfieldtypeId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  PRIMARY KEY (`airlinejobpostingfieldtypeId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `airlinejobpostingfields`
--
ALTER TABLE `airlinejobpostingfields`
  ADD CONSTRAINT `airlinejobpostingfields_ibfk_1` FOREIGN KEY (`airlinejobpostingfieldtypeId`) REFERENCES `airlinejobpostingfieldtypes` (`airlinejobpostingfieldtypeId`) ON DELETE CASCADE ON UPDATE CASCADE;
  
  ';
        $this->execute($sql);
	}
	
}