-- MySQL dump 10.13  Distrib 5.5.25, for Linux (x86_64)
--
-- Host: localhost    Database: tolc_tmpl
-- ------------------------------------------------------
-- Server version	5.5.25

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
-- Table structure for table `www_content`
--

DROP TABLE IF EXISTS `www_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `www_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `www_pages_id` int(11) NOT NULL,
  `www_template_active_elements_id` int(11) NOT NULL,
  `date_published` varchar(14) NOT NULL,
  `lk_publish_status_id` int(11) NOT NULL,
  `html` longtext,
  PRIMARY KEY (`id`),
  KEY `www_content_ix1` (`www_pages_id`),
  KEY `www_content_ix2` (`www_template_active_elements_id`),
  KEY `www_content_ix3` (`date_published`),
  KEY `www_content_ix4` (`lk_publish_status_id`),
  CONSTRAINT `www_content_fk1` FOREIGN KEY (`www_pages_id`) REFERENCES `www_pages` (`id`),
  CONSTRAINT `www_content_fk2` FOREIGN KEY (`www_template_active_elements_id`) REFERENCES `www_template_active_elements` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `www_languages`
--

DROP TABLE IF EXISTS `www_languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `www_languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `locale` varchar(10) NOT NULL,
  `lang_intl` varchar(254) NOT NULL,
  `lang_local` varchar(254) NOT NULL,
  `admin_interface` tinyint(4) DEFAULT NULL,
  `website_content` tinyint(4) DEFAULT NULL,
  `display_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `www_languages_new_ix1` (`locale`)
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `www_page_templates`
--

DROP TABLE IF EXISTS `www_page_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `www_page_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `www_pages_id` int(11) NOT NULL,
  `www_templates_id` int(11) NOT NULL,
  `date_start` varchar(14) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `www_page_templates_ix4` (`www_pages_id`,`date_start`),
  KEY `www_page_templates_ix1` (`www_pages_id`),
  KEY `www_page_templates_ix2` (`www_templates_id`),
  KEY `www_page_templates_ix3` (`date_start`),
  CONSTRAINT `www_page_templates_fk2` FOREIGN KEY (`www_templates_id`) REFERENCES `www_templates` (`id`),
  CONSTRAINT `www_page_templates_fk1` FOREIGN KEY (`www_pages_id`) REFERENCES `www_pages` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `www_pages`
--

DROP TABLE IF EXISTS `www_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `www_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(254) NOT NULL,
  `title` varchar(254) NOT NULL,
  `www_users_id` int(11) NOT NULL,
  `date_created` varchar(14) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `display_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `www_pages_ix1` (`url`),
  KEY `www_pages_ix2` (`www_users_id`),
  KEY `www_pages_ix3` (`date_created`),
  KEY `www_pages_ix4` (`parent_id`),
  KEY `www_pages_ix5` (`display_order`),
  CONSTRAINT `www_pages_fk2` FOREIGN KEY (`parent_id`) REFERENCES `www_pages` (`id`),
  CONSTRAINT `www_pages_fk1` FOREIGN KEY (`www_users_id`) REFERENCES `www_users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `www_template_active_elements`
--

DROP TABLE IF EXISTS `www_template_active_elements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `www_template_active_elements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `www_templates_id` int(11) NOT NULL,
  `element_id` varchar(254) NOT NULL,
  `display_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `www_template_active_elements_ix2` (`www_templates_id`,`element_id`),
  KEY `www_template_active_elements_ix1` (`www_templates_id`),
  KEY `www_template_active_elements_ix3` (`display_order`),
  CONSTRAINT `www_template_active_elements_fk1` FOREIGN KEY (`www_templates_id`) REFERENCES `www_templates` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `www_templates`
--

DROP TABLE IF EXISTS `www_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `www_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template_name` varchar(254) NOT NULL,
  `template_path` varchar(254) NOT NULL,
  `template_file` varchar(254) NOT NULL,
  `css_url` varchar(254) NOT NULL,
  `display_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `www_templates_ix1` (`template_name`),
  UNIQUE KEY `www_templates_ix2` (`template_path`,`template_file`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `www_users`
--

DROP TABLE IF EXISTS `www_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `www_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(254) NOT NULL,
  `password` varchar(254) NOT NULL,
  `email` varchar(254) NOT NULL,
  `fullname` varchar(254) NOT NULL,
  `url` varchar(254) DEFAULT NULL,
  `date_registered` varchar(14) NOT NULL,
  `lk_user_status_id` int(11) NOT NULL,
  `is_admin` tinyint(4) NOT NULL,
  `must_change_passwd` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `www_users_ix1` (`username`),
  KEY `www_users_ix2` (`fullname`),
  KEY `www_users_ix3` (`date_registered`),
  KEY `www_users_ix4` (`lk_user_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-08-03 13:04:24
