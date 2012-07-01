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
-- Table structure for table `www_languages`
--

DROP TABLE IF EXISTS `www_languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `www_languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang_code` varchar(10) NOT NULL,
  `lang_name_intl` varchar(254) NOT NULL,
  `lang_name_local` varchar(254) NOT NULL,
  `admin_interface` tinyint(4) DEFAULT NULL,
  `website_content` tinyint(4) DEFAULT NULL,
  `display_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `www_languages_ix1` (`lang_code`)
) ENGINE=InnoDB AUTO_INCREMENT=247 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `www_lookup_data`
--

DROP TABLE IF EXISTS `www_lookup_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `www_lookup_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `www_lookups_id` int(11) NOT NULL,
  `www_languages_id` int(11) NOT NULL,
  `any_lang_id` int(11) NOT NULL DEFAULT '0',
  `description` varchar(254) NOT NULL,
  `display_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `www_lookup_data_ix1` (`www_lookups_id`),
  KEY `www_lookup_data_ix2` (`www_languages_id`),
  KEY `www_lookup_data_ix3` (`any_lang_id`),
  CONSTRAINT `www_lookup_data_fk1` FOREIGN KEY (`www_lookups_id`) REFERENCES `www_lookups` (`id`),
  CONSTRAINT `www_lookup_data_fk2` FOREIGN KEY (`www_languages_id`) REFERENCES `www_languages` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `www_lookups`
--

DROP TABLE IF EXISTS `www_lookups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `www_lookups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lookup_table` varchar(254) NOT NULL,
  `display_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `www_modules`
--

DROP TABLE IF EXISTS `www_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `www_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(254) NOT NULL,
  `url` varchar(254) NOT NULL,
  `display_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
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
  `www_templates_id` int(11) NOT NULL,
  `www_users_id` int(11) NOT NULL,
  `date_created` varchar(12) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `display_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `www_pages_ix1` (`url`),
  KEY `www_pages_ix2` (`www_templates_id`),
  KEY `www_pages_ix3` (`www_users_id`),
  KEY `www_pages_ix4` (`parent_id`),
  CONSTRAINT `www_pages_fk1` FOREIGN KEY (`www_templates_id`) REFERENCES `www_templates` (`id`),
  CONSTRAINT `www_pages_fk2` FOREIGN KEY (`www_users_id`) REFERENCES `www_users` (`id`),
  CONSTRAINT `www_pages_fk3` FOREIGN KEY (`parent_id`) REFERENCES `www_pages` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `www_section_content`
--

DROP TABLE IF EXISTS `www_section_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `www_section_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `www_sections_id` int(11) NOT NULL,
  `date_start` varchar(12) NOT NULL,
  `date_end` varchar(12) DEFAULT NULL,
  `lk_publish_status_id` int(11) NOT NULL,
  `html` longtext,
  `www_modules_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `www_section_content_ix1` (`www_sections_id`),
  KEY `www_section_content_ix2` (`date_start`),
  KEY `www_section_content_ix3` (`lk_publish_status_id`),
  KEY `www_section_content_ix4` (`www_modules_id`),
  CONSTRAINT `www_section_content_fk1` FOREIGN KEY (`www_sections_id`) REFERENCES `www_sections` (`id`),
  CONSTRAINT `www_section_content_fk2` FOREIGN KEY (`lk_publish_status_id`) REFERENCES `www_lookup_data` (`any_lang_id`),
  CONSTRAINT `www_section_content_fk3` FOREIGN KEY (`www_modules_id`) REFERENCES `www_modules` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `www_sections`
--

DROP TABLE IF EXISTS `www_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `www_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `www_pages_id` int(11) NOT NULL,
  `www_template_active_divs_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `www_sections_ix1` (`www_pages_id`),
  KEY `www_sections_ix2` (`www_template_active_divs_id`),
  CONSTRAINT `www_sections_fk1` FOREIGN KEY (`www_pages_id`) REFERENCES `www_pages` (`id`),
  CONSTRAINT `www_sections_fk2` FOREIGN KEY (`www_template_active_divs_id`) REFERENCES `www_template_active_divs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `www_template_active_divs`
--

DROP TABLE IF EXISTS `www_template_active_divs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `www_template_active_divs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `www_templates_id` int(11) NOT NULL,
  `div_id` varchar(254) NOT NULL,
  `www_modules_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `www_template_active_divs_ix3` (`www_templates_id`,`div_id`),
  KEY `www_template_active_divs_ix1` (`www_templates_id`),
  KEY `www_template_active_divs_ix2` (`www_modules_id`),
  CONSTRAINT `www_template_active_divs_fk2` FOREIGN KEY (`www_modules_id`) REFERENCES `www_modules` (`id`),
  CONSTRAINT `www_template_active_divs_fk1` FOREIGN KEY (`www_templates_id`) REFERENCES `www_templates` (`id`)
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
  `display_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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
  `date_registered` varchar(12) NOT NULL,
  `lk_user_status_id` int(11) NOT NULL,
  `is_admin` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `www_users_ix1` (`username`),
  KEY `www_users_ix2` (`fullname`),
  KEY `www_users_ix3` (`date_registered`),
  KEY `www_users_ix4` (`lk_user_status_id`),
  CONSTRAINT `www_users_fk1` FOREIGN KEY (`lk_user_status_id`) REFERENCES `www_lookup_data` (`any_lang_id`)
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

-- Dump completed on 2012-07-01 21:25:37
