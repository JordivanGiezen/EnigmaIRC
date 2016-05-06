CREATE DATABASE  IF NOT EXISTS `enigma` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `enigma`;
-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: enigma
-- ------------------------------------------------------
-- Server version	5.6.13-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `enigma_eye_downtime`
--

DROP TABLE IF EXISTS `enigma_eye_downtime`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enigma_eye_downtime` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start` int(11) NOT NULL,
  `finish` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `enigma_eye_economy`
--

DROP TABLE IF EXISTS `enigma_eye_economy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enigma_eye_economy` (
  `bullets` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `enigma_eye_famdeaths`
--

DROP TABLE IF EXISTS `enigma_eye_famdeaths`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enigma_eye_famdeaths` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `famid` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `enigma_eye_families`
--

DROP TABLE IF EXISTS `enigma_eye_families`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enigma_eye_families` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `famid` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `rank` varchar(45) NOT NULL,
  `users` varchar(45) NOT NULL,
  `city` varchar(45) NOT NULL,
  `boss` varchar(45) NOT NULL,
  `firstboss` varchar(45) NOT NULL,
  `createdon` int(11) NOT NULL,
  `state` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `enigma_eye_famnamechanges`
--

DROP TABLE IF EXISTS `enigma_eye_famnamechanges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enigma_eye_famnamechanges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `famid` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `previousname` varchar(45) NOT NULL,
  `newname` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `enigma_eye_famproms`
--

DROP TABLE IF EXISTS `enigma_eye_famproms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enigma_eye_famproms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `famid` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `previousrank` varchar(45) NOT NULL,
  `newrank` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `enigma_eye_namechanges`
--

DROP TABLE IF EXISTS `enigma_eye_namechanges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enigma_eye_namechanges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `previousname` varchar(45) NOT NULL,
  `newname` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `enigma_eye_online`
--

DROP TABLE IF EXISTS `enigma_eye_online`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enigma_eye_online` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `state` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=170813 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `enigma_eye_proms`
--

DROP TABLE IF EXISTS `enigma_eye_proms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enigma_eye_proms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `previousrank` varchar(45) NOT NULL,
  `newrank` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6268 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `enigma_eye_shots`
--

DROP TABLE IF EXISTS `enigma_eye_shots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enigma_eye_shots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` int(11) NOT NULL,
  `bullets` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `enigma_eye_stalkers`
--

DROP TABLE IF EXISTS `enigma_eye_stalkers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enigma_eye_stalkers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `host` varchar(45) NOT NULL,
  `userid` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `enigma_eye_userdeaths`
--

DROP TABLE IF EXISTS `enigma_eye_userdeaths`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enigma_eye_userdeaths` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `admin` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=380 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `enigma_eye_userfams`
--

DROP TABLE IF EXISTS `enigma_eye_userfams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enigma_eye_userfams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `previousfamily` varchar(45) DEFAULT NULL,
  `newfamily` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=797 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `enigma_eye_userroles`
--

DROP TABLE IF EXISTS `enigma_eye_userroles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enigma_eye_userroles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `previousrole` varchar(45) DEFAULT NULL,
  `newrole` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=147 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `enigma_eye_users`
--

DROP TABLE IF EXISTS `enigma_eye_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enigma_eye_users` (
  `userid` int(11) NOT NULL,
  `ingame` varchar(45) NOT NULL DEFAULT '-',
  `rank` varchar(45) NOT NULL DEFAULT 'Empty-suit',
  `family` varchar(45) DEFAULT NULL,
  `role` varchar(45) DEFAULT NULL,
  `status` varchar(45) NOT NULL DEFAULT 'Alive',
  `firstseen` varchar(45) NOT NULL DEFAULT '0',
  `lastseen` varchar(45) NOT NULL DEFAULT '0',
  `firstrank` varchar(45) NOT NULL DEFAULT 'Empty-suit',
  `state` varchar(45) NOT NULL DEFAULT 'Offline',
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `enigma_ideas`
--

DROP TABLE IF EXISTS `enigma_ideas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enigma_ideas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idea` text NOT NULL,
  `date` varchar(45) NOT NULL,
  `nick` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `enigma_logs`
--

DROP TABLE IF EXISTS `enigma_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enigma_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `channel` varchar(45) NOT NULL,
  `nickname` varchar(45) NOT NULL,
  `message` text NOT NULL,
  `date` varchar(45) NOT NULL,
  `seenby` text NOT NULL,
  `spiedfrom` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `enigma_omerta_users`
--

DROP TABLE IF EXISTS `enigma_omerta_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enigma_omerta_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `host` varchar(90) NOT NULL,
  `ingame` varchar(45) NOT NULL,
  `rank` varchar(45) NOT NULL DEFAULT 'Empty Suit',
  `balas` varchar(45) NOT NULL DEFAULT '0',
  `lastbalas` varchar(45) NOT NULL DEFAULT '00-00-0000',
  `lastrank` varchar(45) NOT NULL DEFAULT '00-00-0000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-12-05  2:29:18
