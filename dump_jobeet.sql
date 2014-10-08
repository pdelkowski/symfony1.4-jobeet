-- MySQL dump 10.13  Distrib 5.5.38, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: jobeet
-- ------------------------------------------------------
-- Server version	5.5.38-0+wheezy1

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
-- Table structure for table `jobeet_affiliate`
--

DROP TABLE IF EXISTS `jobeet_affiliate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobeet_affiliate` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobeet_affiliate`
--

LOCK TABLES `jobeet_affiliate` WRITE;
/*!40000 ALTER TABLE `jobeet_affiliate` DISABLE KEYS */;
INSERT INTO `jobeet_affiliate` VALUES (3,'http://www.sensio-labs.com/','fabien.potencier@example.com','sensio_labs',1,'2014-10-08 09:06:25','2014-10-08 09:06:25'),(4,'/','fabien.potencier@example.org','symfony',0,'2014-10-08 09:06:25','2014-10-08 09:06:25');
/*!40000 ALTER TABLE `jobeet_affiliate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobeet_category`
--

DROP TABLE IF EXISTS `jobeet_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobeet_category` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `jobeet_category_sluggable_idx` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobeet_category`
--

LOCK TABLES `jobeet_category` WRITE;
/*!40000 ALTER TABLE `jobeet_category` DISABLE KEYS */;
INSERT INTO `jobeet_category` VALUES (5,'2014-10-08 09:06:25','2014-10-08 09:06:25','programming'),(6,'2014-10-08 09:06:25','2014-10-08 09:06:25','design'),(7,'2014-10-08 09:06:25','2014-10-08 09:06:25','manager'),(8,'2014-10-08 09:06:25','2014-10-08 09:06:25','administrator');
/*!40000 ALTER TABLE `jobeet_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobeet_category_affiliate`
--

DROP TABLE IF EXISTS `jobeet_category_affiliate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobeet_category_affiliate` (
  `category_id` bigint(20) NOT NULL DEFAULT '0',
  `affiliate_id` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`category_id`,`affiliate_id`),
  KEY `jobeet_category_affiliate_affiliate_id_jobeet_affiliate_id` (`affiliate_id`),
  CONSTRAINT `jobeet_category_affiliate_affiliate_id_jobeet_affiliate_id` FOREIGN KEY (`affiliate_id`) REFERENCES `jobeet_affiliate` (`id`) ON DELETE CASCADE,
  CONSTRAINT `jobeet_category_affiliate_category_id_jobeet_category_id` FOREIGN KEY (`category_id`) REFERENCES `jobeet_category` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobeet_category_affiliate`
--

LOCK TABLES `jobeet_category_affiliate` WRITE;
/*!40000 ALTER TABLE `jobeet_category_affiliate` DISABLE KEYS */;
INSERT INTO `jobeet_category_affiliate` VALUES (5,3),(5,4),(6,4);
/*!40000 ALTER TABLE `jobeet_category_affiliate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobeet_category_translation`
--

DROP TABLE IF EXISTS `jobeet_category_translation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobeet_category_translation` (
  `id` bigint(20) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `lang` char(2) NOT NULL DEFAULT '',
  `slug` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`,`lang`),
  UNIQUE KEY `jobeet_category_translation_sluggable_idx` (`slug`,`lang`,`name`),
  CONSTRAINT `jobeet_category_translation_id_jobeet_category_id` FOREIGN KEY (`id`) REFERENCES `jobeet_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobeet_category_translation`
--

LOCK TABLES `jobeet_category_translation` WRITE;
/*!40000 ALTER TABLE `jobeet_category_translation` DISABLE KEYS */;
INSERT INTO `jobeet_category_translation` VALUES (8,'Administrateur','fr','administrateur'),(8,'Administrator','en','administrator'),(6,'Design','en','design'),(6,'design','fr','design'),(7,'Manager','en','manager'),(7,'Manager','fr','manager'),(5,'Programmation','fr','programmation'),(5,'Programming','en','programming');
/*!40000 ALTER TABLE `jobeet_category_translation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobeet_job`
--

DROP TABLE IF EXISTS `jobeet_job`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobeet_job` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `company` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `position` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `how_to_apply` text NOT NULL,
  `token` varchar(255) NOT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT '1',
  `is_activated` tinyint(1) NOT NULL DEFAULT '0',
  `email` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`),
  KEY `category_id_idx` (`category_id`),
  CONSTRAINT `jobeet_job_category_id_jobeet_category_id` FOREIGN KEY (`category_id`) REFERENCES `jobeet_category` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobeet_job`
--

LOCK TABLES `jobeet_job` WRITE;
/*!40000 ALTER TABLE `jobeet_job` DISABLE KEYS */;
INSERT INTO `jobeet_job` VALUES (32,5,NULL,'Company 100',NULL,NULL,'Web Developer','Paris, France','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','Send your resume to lorem.ipsum [at] company_100.sit\n','job_100',1,1,'job@example.com','2014-11-07 08:06:26','2014-10-08 09:06:26','2014-10-08 09:06:26'),(33,5,NULL,'Company 101',NULL,NULL,'Web Developer','Paris, France','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','Send your resume to lorem.ipsum [at] company_101.sit\n','job_101',1,1,'job@example.com','2014-11-07 08:06:27','2014-10-08 09:06:27','2014-10-08 09:06:27'),(34,5,NULL,'Company 102',NULL,NULL,'Web Developer','Paris, France','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','Send your resume to lorem.ipsum [at] company_102.sit\n','job_102',1,1,'job@example.com','2014-11-07 08:06:28','2014-10-08 09:06:28','2014-10-08 09:06:28'),(35,5,NULL,'Company 103',NULL,NULL,'Web Developer','Paris, France','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','Send your resume to lorem.ipsum [at] company_103.sit\n','job_103',1,1,'job@example.com','2014-11-07 08:06:29','2014-10-08 09:06:29','2014-10-08 09:06:29'),(36,5,NULL,'Company 104',NULL,NULL,'Web Developer','Paris, France','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','Send your resume to lorem.ipsum [at] company_104.sit\n','job_104',1,1,'job@example.com','2014-11-07 08:06:30','2014-10-08 09:06:30','2014-10-08 09:06:30'),(37,5,NULL,'Company 105',NULL,NULL,'Web Developer','Paris, France','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','Send your resume to lorem.ipsum [at] company_105.sit\n','job_105',1,1,'job@example.com','2014-11-07 08:06:31','2014-10-08 09:06:31','2014-10-08 09:06:31'),(38,5,NULL,'Company 106',NULL,NULL,'Web Developer','Paris, France','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','Send your resume to lorem.ipsum [at] company_106.sit\n','job_106',1,1,'job@example.com','2014-11-07 08:06:32','2014-10-08 09:06:32','2014-10-08 09:06:32'),(39,5,NULL,'Company 107',NULL,NULL,'Web Developer','Paris, France','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','Send your resume to lorem.ipsum [at] company_107.sit\n','job_107',1,1,'job@example.com','2014-11-07 08:06:33','2014-10-08 09:06:33','2014-10-08 09:06:33'),(40,5,NULL,'Company 108',NULL,NULL,'Web Developer','Paris, France','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','Send your resume to lorem.ipsum [at] company_108.sit\n','job_108',1,1,'job@example.com','2014-11-07 08:06:34','2014-10-08 09:06:34','2014-10-08 09:06:34'),(41,5,NULL,'Company 109',NULL,NULL,'Web Developer','Paris, France','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','Send your resume to lorem.ipsum [at] company_109.sit\n','job_109',1,1,'job@example.com','2014-11-07 08:06:35','2014-10-08 09:06:35','2014-10-08 09:06:35'),(42,5,NULL,'Company 110',NULL,NULL,'Web Developer','Paris, France','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','Send your resume to lorem.ipsum [at] company_110.sit\n','job_110',1,1,'job@example.com','2014-11-07 08:06:36','2014-10-08 09:06:36','2014-10-08 09:06:36'),(43,5,NULL,'Company 111',NULL,NULL,'Web Developer','Paris, France','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','Send your resume to lorem.ipsum [at] company_111.sit\n','job_111',1,1,'job@example.com','2014-11-07 08:06:37','2014-10-08 09:06:37','2014-10-08 09:06:37'),(44,5,NULL,'Company 112',NULL,NULL,'Web Developer','Paris, France','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','Send your resume to lorem.ipsum [at] company_112.sit\n','job_112',1,1,'job@example.com','2014-11-07 08:06:38','2014-10-08 09:06:38','2014-10-08 09:06:38'),(45,5,NULL,'Company 113',NULL,NULL,'Web Developer','Paris, France','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','Send your resume to lorem.ipsum [at] company_113.sit\n','job_113',1,1,'job@example.com','2014-11-07 08:06:39','2014-10-08 09:06:39','2014-10-08 09:06:39'),(46,5,NULL,'Company 114',NULL,NULL,'Web Developer','Paris, France','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','Send your resume to lorem.ipsum [at] company_114.sit\n','job_114',1,1,'job@example.com','2014-11-07 08:06:40','2014-10-08 09:06:40','2014-10-08 09:06:40'),(47,5,NULL,'Company 115',NULL,NULL,'Web Developer','Paris, France','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','Send your resume to lorem.ipsum [at] company_115.sit\n','job_115',1,1,'job@example.com','2014-11-07 08:06:41','2014-10-08 09:06:41','2014-10-08 09:06:41'),(48,5,NULL,'Company 116',NULL,NULL,'Web Developer','Paris, France','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','Send your resume to lorem.ipsum [at] company_116.sit\n','job_116',1,1,'job@example.com','2014-11-07 08:06:42','2014-10-08 09:06:42','2014-10-08 09:06:42'),(49,5,NULL,'Company 117',NULL,NULL,'Web Developer','Paris, France','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','Send your resume to lorem.ipsum [at] company_117.sit\n','job_117',1,1,'job@example.com','2014-11-07 08:06:43','2014-10-08 09:06:43','2014-10-08 09:06:43'),(50,5,NULL,'Company 118',NULL,NULL,'Web Developer','Paris, France','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','Send your resume to lorem.ipsum [at] company_118.sit\n','job_118',1,1,'job@example.com','2014-11-07 08:06:44','2014-10-08 09:06:44','2014-10-08 09:06:44'),(51,5,NULL,'Company 119',NULL,NULL,'Web Developer','Paris, France','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','Send your resume to lorem.ipsum [at] company_119.sit\n','job_119',1,1,'job@example.com','2014-11-07 08:06:45','2014-10-08 09:06:45','2014-10-08 09:06:45'),(52,5,NULL,'Company 120',NULL,NULL,'Web Developer','Paris, France','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','Send your resume to lorem.ipsum [at] company_120.sit\n','job_120',1,1,'job@example.com','2014-11-07 08:06:46','2014-10-08 09:06:46','2014-10-08 09:06:46'),(53,5,NULL,'Company 121',NULL,NULL,'Web Developer','Paris, France','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','Send your resume to lorem.ipsum [at] company_121.sit\n','job_121',1,1,'job@example.com','2014-11-07 08:06:47','2014-10-08 09:06:47','2014-10-08 09:06:47'),(54,5,NULL,'Company 122',NULL,NULL,'Web Developer','Paris, France','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','Send your resume to lorem.ipsum [at] company_122.sit\n','job_122',1,1,'job@example.com','2014-11-07 08:06:48','2014-10-08 09:06:48','2014-10-08 09:06:48'),(55,5,NULL,'Company 123',NULL,NULL,'Web Developer','Paris, France','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','Send your resume to lorem.ipsum [at] company_123.sit\n','job_123',1,1,'job@example.com','2014-11-07 08:06:49','2014-10-08 09:06:49','2014-10-08 09:06:49'),(56,5,NULL,'Company 124',NULL,NULL,'Web Developer','Paris, France','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','Send your resume to lorem.ipsum [at] company_124.sit\n','job_124',1,1,'job@example.com','2014-11-07 08:06:50','2014-10-08 09:06:50','2014-10-08 09:06:50'),(57,5,NULL,'Company 125',NULL,NULL,'Web Developer','Paris, France','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','Send your resume to lorem.ipsum [at] company_125.sit\n','job_125',1,1,'job@example.com','2014-11-07 08:06:51','2014-10-08 09:06:51','2014-10-08 09:06:51'),(58,5,NULL,'Company 126',NULL,NULL,'Web Developer','Paris, France','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','Send your resume to lorem.ipsum [at] company_126.sit\n','job_126',1,1,'job@example.com','2014-11-07 08:06:52','2014-10-08 09:06:52','2014-10-08 09:06:52'),(59,5,NULL,'Company 127',NULL,NULL,'Web Developer','Paris, France','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','Send your resume to lorem.ipsum [at] company_127.sit\n','job_127',1,1,'job@example.com','2014-11-07 08:06:53','2014-10-08 09:06:53','2014-10-08 09:06:53'),(60,5,NULL,'Company 128',NULL,NULL,'Web Developer','Paris, France','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','Send your resume to lorem.ipsum [at] company_128.sit\n','job_128',1,1,'job@example.com','2014-11-07 08:06:54','2014-10-08 09:06:54','2014-10-08 09:06:54'),(61,5,NULL,'Company 129',NULL,NULL,'Web Developer','Paris, France','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','Send your resume to lorem.ipsum [at] company_129.sit\n','job_129',1,1,'job@example.com','2014-11-07 08:06:55','2014-10-08 09:06:55','2014-10-08 09:06:55'),(62,5,NULL,'Company 130',NULL,NULL,'Web Developer','Paris, France','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','Send your resume to lorem.ipsum [at] company_130.sit\n','job_130',1,1,'job@example.com','2014-11-07 08:06:56','2014-10-08 09:06:56','2014-10-08 09:06:56');
/*!40000 ALTER TABLE `jobeet_job` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sf_guard_forgot_password`
--

DROP TABLE IF EXISTS `sf_guard_forgot_password`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sf_guard_forgot_password` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `unique_key` varchar(255) DEFAULT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id_idx` (`user_id`),
  CONSTRAINT `sf_guard_forgot_password_user_id_sf_guard_user_id` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sf_guard_forgot_password`
--

LOCK TABLES `sf_guard_forgot_password` WRITE;
/*!40000 ALTER TABLE `sf_guard_forgot_password` DISABLE KEYS */;
/*!40000 ALTER TABLE `sf_guard_forgot_password` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sf_guard_group`
--

DROP TABLE IF EXISTS `sf_guard_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sf_guard_group` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sf_guard_group`
--

LOCK TABLES `sf_guard_group` WRITE;
/*!40000 ALTER TABLE `sf_guard_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `sf_guard_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sf_guard_group_permission`
--

DROP TABLE IF EXISTS `sf_guard_group_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sf_guard_group_permission` (
  `group_id` bigint(20) NOT NULL DEFAULT '0',
  `permission_id` bigint(20) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`group_id`,`permission_id`),
  KEY `sf_guard_group_permission_permission_id_sf_guard_permission_id` (`permission_id`),
  CONSTRAINT `sf_guard_group_permission_group_id_sf_guard_group_id` FOREIGN KEY (`group_id`) REFERENCES `sf_guard_group` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sf_guard_group_permission_permission_id_sf_guard_permission_id` FOREIGN KEY (`permission_id`) REFERENCES `sf_guard_permission` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sf_guard_group_permission`
--

LOCK TABLES `sf_guard_group_permission` WRITE;
/*!40000 ALTER TABLE `sf_guard_group_permission` DISABLE KEYS */;
/*!40000 ALTER TABLE `sf_guard_group_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sf_guard_permission`
--

DROP TABLE IF EXISTS `sf_guard_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sf_guard_permission` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sf_guard_permission`
--

LOCK TABLES `sf_guard_permission` WRITE;
/*!40000 ALTER TABLE `sf_guard_permission` DISABLE KEYS */;
/*!40000 ALTER TABLE `sf_guard_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sf_guard_remember_key`
--

DROP TABLE IF EXISTS `sf_guard_remember_key`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sf_guard_remember_key` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `remember_key` varchar(32) DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id_idx` (`user_id`),
  CONSTRAINT `sf_guard_remember_key_user_id_sf_guard_user_id` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sf_guard_remember_key`
--

LOCK TABLES `sf_guard_remember_key` WRITE;
/*!40000 ALTER TABLE `sf_guard_remember_key` DISABLE KEYS */;
/*!40000 ALTER TABLE `sf_guard_remember_key` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sf_guard_user`
--

DROP TABLE IF EXISTS `sf_guard_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sf_guard_user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email_address` varchar(255) NOT NULL,
  `username` varchar(128) NOT NULL,
  `algorithm` varchar(128) NOT NULL DEFAULT 'sha1',
  `salt` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `is_super_admin` tinyint(1) DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_address` (`email_address`),
  UNIQUE KEY `username` (`username`),
  KEY `is_active_idx_idx` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sf_guard_user`
--

LOCK TABLES `sf_guard_user` WRITE;
/*!40000 ALTER TABLE `sf_guard_user` DISABLE KEYS */;
INSERT INTO `sf_guard_user` VALUES (1,NULL,NULL,'admin@admin','admin','sha1','81942e0f8172d00a5b1f3c723933af2b','1f0260327b178fdda8d9d37e7c8594f193b6ff50',1,1,'2014-10-08 09:13:52','2014-10-08 09:13:38','2014-10-08 09:13:52');
/*!40000 ALTER TABLE `sf_guard_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sf_guard_user_group`
--

DROP TABLE IF EXISTS `sf_guard_user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sf_guard_user_group` (
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `group_id` bigint(20) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`),
  KEY `sf_guard_user_group_group_id_sf_guard_group_id` (`group_id`),
  CONSTRAINT `sf_guard_user_group_group_id_sf_guard_group_id` FOREIGN KEY (`group_id`) REFERENCES `sf_guard_group` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sf_guard_user_group_user_id_sf_guard_user_id` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sf_guard_user_group`
--

LOCK TABLES `sf_guard_user_group` WRITE;
/*!40000 ALTER TABLE `sf_guard_user_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `sf_guard_user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sf_guard_user_permission`
--

DROP TABLE IF EXISTS `sf_guard_user_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sf_guard_user_permission` (
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `permission_id` bigint(20) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`user_id`,`permission_id`),
  KEY `sf_guard_user_permission_permission_id_sf_guard_permission_id` (`permission_id`),
  CONSTRAINT `sf_guard_user_permission_permission_id_sf_guard_permission_id` FOREIGN KEY (`permission_id`) REFERENCES `sf_guard_permission` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sf_guard_user_permission_user_id_sf_guard_user_id` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sf_guard_user_permission`
--

LOCK TABLES `sf_guard_user_permission` WRITE;
/*!40000 ALTER TABLE `sf_guard_user_permission` DISABLE KEYS */;
/*!40000 ALTER TABLE `sf_guard_user_permission` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-10-08  9:39:14
