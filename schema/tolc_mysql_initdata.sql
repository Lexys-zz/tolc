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
-- Dumping data for table `www_content`
--

LOCK TABLES `www_content` WRITE;
/*!40000 ALTER TABLE `www_content` DISABLE KEYS */;
/*!40000 ALTER TABLE `www_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `www_languages`
--

LOCK TABLES `www_languages` WRITE;
/*!40000 ALTER TABLE `www_languages` DISABLE KEYS */;
INSERT INTO `www_languages` VALUES (1,'af_ZA','Afrikaans','Afrikaans',NULL,NULL,NULL),(2,'gn_PY','Guaraní','Avañe\'ẽ',NULL,NULL,NULL),(3,'ay_BO','Aymara','Aymar aru',NULL,NULL,NULL),(4,'az_AZ','Azeri','Azərbaycan dili',NULL,NULL,NULL),(5,'id_ID','Indonesian','Bahasa Indonesia',NULL,NULL,NULL),(6,'ms_MY','Malay','Bahasa Melayu',NULL,NULL,NULL),(7,'jv_ID','Javanese','Basa Jawa',NULL,NULL,NULL),(8,'bs_BA','Bosnian','Bosanski',NULL,NULL,NULL),(9,'ca_ES','Catalan','Català',NULL,NULL,NULL),(10,'cs_CZ','Czech','Čeština',NULL,NULL,NULL),(11,'ck_US','Cherokee','Cherokee',NULL,NULL,NULL),(12,'cy_GB','Welsh','Cymraeg',NULL,NULL,NULL),(13,'da_DK','Danish','Dansk',NULL,NULL,NULL),(14,'se_NO','Northern Sámi','Davvisámegiella',NULL,NULL,NULL),(15,'de_DE','German','Deutsch',NULL,NULL,NULL),(16,'et_EE','Estonian','Eesti',NULL,NULL,NULL),(17,'en_IN','English (India)','English (India)',NULL,NULL,NULL),(18,'en_PI','English (Pirate)','English (Pirate)',NULL,NULL,NULL),(19,'en_GB','English (UK)','English (UK)',1,NULL,NULL),(20,'en_UD','English (Upside Down)','English (Upside Down)',NULL,NULL,NULL),(21,'en_US','English (US)','English (US)',NULL,NULL,NULL),(22,'es_LA','Spanish','Español',NULL,NULL,NULL),(23,'es_CL','Spanish (Chile)','Español (Chile)',NULL,NULL,NULL),(24,'es_CO','Spanish (Colombia)','Español (Colombia)',NULL,NULL,NULL),(25,'es_ES','Spanish (Spain)','Español (España)',NULL,NULL,NULL),(26,'es_MX','Spanish (Mexico)','Español (México)',NULL,NULL,NULL),(27,'es_VE','Spanish (Venezuela)','Español (Venezuela)',NULL,NULL,NULL),(28,'eo_EO','Esperanto','Esperanto',NULL,NULL,NULL),(29,'eu_ES','Basque','Euskara',NULL,NULL,NULL),(30,'tl_PH','Filipino','Filipino',NULL,NULL,NULL),(31,'fo_FO','Faroese','Føroyskt',NULL,NULL,NULL),(32,'fr_FR','French (France)','Français (France)',NULL,NULL,NULL),(33,'fr_CA','French (Canada)','Français (Canada)',NULL,NULL,NULL),(34,'fy_NL','Frisian','Frysk',NULL,NULL,NULL),(35,'ga_IE','Irish','Gaeilge',NULL,NULL,NULL),(36,'gl_ES','Galician','Galego',NULL,NULL,NULL),(37,'ko_KR','Korean','한국어',NULL,NULL,NULL),(38,'hr_HR','Croatian','Hrvatski',NULL,NULL,NULL),(39,'xh_ZA','Xhosa','isiXhosa',NULL,NULL,NULL),(40,'zu_ZA','Zulu','isiZulu',NULL,NULL,NULL),(41,'is_IS','Icelandic','Íslenska',NULL,NULL,NULL),(42,'it_IT','Italian','Italiano',NULL,NULL,NULL),(43,'ka_GE','Georgian','ქართული',NULL,NULL,NULL),(44,'sw_KE','Swahili','Kiswahili',NULL,NULL,NULL),(45,'tl_ST','Klingon','tlhIngan-Hol',NULL,NULL,NULL),(46,'ku_TR','Kurdish','Kurdî',NULL,NULL,NULL),(47,'lv_LV','Latvian','Latviešu',NULL,NULL,NULL),(48,'fb_LT','Leet Speak','Leet Speak',NULL,NULL,NULL),(49,'lt_LT','Lithuanian','Lietuvių',NULL,NULL,NULL),(50,'li_NL','Limburgish','Lèmbörgs',NULL,NULL,NULL),(51,'la_VA','Latin','lingua latina',NULL,NULL,NULL),(52,'hu_HU','Hungarian','Magyar',NULL,NULL,NULL),(53,'mg_MG','Malagasy','Malagasy',NULL,NULL,NULL),(54,'mt_MT','Maltese','Malti',NULL,NULL,NULL),(55,'nl_NL','Dutch','Nederlands',NULL,NULL,NULL),(56,'nl_BE','Dutch (België)','Nederlands (België)',NULL,NULL,NULL),(57,'ja_JP','Japanese','日本語',NULL,NULL,NULL),(58,'nb_NO','Norwegian (bokmal)','Norsk (bokmål)',NULL,NULL,NULL),(59,'nn_NO','Norwegian (nynorsk)','Norsk (nynorsk)',NULL,NULL,NULL),(60,'uz_UZ','Uzbek','O\'zbek',NULL,NULL,NULL),(61,'pl_PL','Polish','Polski',NULL,NULL,NULL),(62,'pt_BR','Portuguese (Brazil)','Português (Brasil)',NULL,NULL,NULL),(63,'pt_PT','Portuguese (Portugal)','Português (Portugal)',NULL,NULL,NULL),(64,'qu_PE','Quechua','Qhichwa',NULL,NULL,NULL),(65,'ro_RO','Romanian','Română',NULL,NULL,NULL),(66,'rm_CH','Romansh','Rumantsch',NULL,NULL,NULL),(67,'ru_RU','Russian','Русский',NULL,NULL,NULL),(68,'sq_AL','Albanian','Shqip',NULL,NULL,NULL),(69,'sk_SK','Slovak','Slovenčina',NULL,NULL,NULL),(70,'sl_SI','Slovenian','Slovenščina',NULL,NULL,NULL),(71,'so_SO','Somali','Soomaaliga',NULL,NULL,NULL),(72,'fi_FI','Finnish','Suomi',NULL,NULL,NULL),(73,'sv_SE','Swedish','Svenska',NULL,NULL,NULL),(74,'th_TH','Thai','ภาษาไทย',NULL,NULL,NULL),(75,'vi_VN','Vietnamese','Tiếng Việt',NULL,NULL,NULL),(76,'tr_TR','Turkish','Türkçe',NULL,NULL,NULL),(77,'zh_CN','Simplified Chinese (China)','中文(简体)',NULL,NULL,NULL),(78,'zh_TW','Traditional Chinese (Taiwan)','中文(台灣)',NULL,NULL,NULL),(79,'zh_HK','Traditional Chinese (Hong Kong)','中文(香港)',NULL,NULL,NULL),(80,'el_GR','Greek','Ελληνικά',1,NULL,NULL),(81,'gx_GR','Classical Greek','Ἑλληνική ἀρχαία',NULL,NULL,NULL),(82,'be_BY','Belarusian','Беларуская',NULL,NULL,NULL),(83,'bg_BG','Bulgarian','Български',NULL,NULL,NULL),(84,'kk_KZ','Kazakh','Қазақша',NULL,NULL,NULL),(85,'mk_MK','Macedonian','Македонски',NULL,NULL,NULL),(86,'mn_MN','Mongolian','Монгол',NULL,NULL,NULL),(87,'sr_RS','Serbian','Српски',NULL,NULL,NULL),(88,'tt_RU','Tatar','татарча / Tatarça / تاتارچا',NULL,NULL,NULL),(89,'tg_TJ','Tajik','тоҷикӣ, تاجیکی‎, tojikī',NULL,NULL,NULL),(90,'uk_UA','Ukrainian','Українська',NULL,NULL,NULL),(91,'hy_AM','Armenian','Հայերեն',NULL,NULL,NULL),(92,'yi_DE','Yiddish','ייִדיש',NULL,NULL,NULL),(93,'he_IL','Hebrew','‏עברית‏',NULL,NULL,NULL),(94,'ur_PK','Urdu','اردو',NULL,NULL,NULL),(95,'ar_AR','Arabic','العربية',NULL,NULL,NULL),(96,'ps_AF','Pashto','پښتو',NULL,NULL,NULL),(97,'fa_IR','Persian','فارسی',NULL,NULL,NULL),(98,'sy_SY','Syriac','‏ܐܪܡܝܐ‏',NULL,NULL,NULL),(99,'ne_NP','Nepali','नेपाली',NULL,NULL,NULL),(100,'mr_IN','Marathi','मराठी',NULL,NULL,NULL),(101,'sa_IN','Sanskrit','संस्कृतम्',NULL,NULL,NULL),(102,'hi_IN','Hindi','हिन्दी',NULL,NULL,NULL),(103,'bn_IN','Bengali','বাংলা',NULL,NULL,NULL),(104,'pa_IN','Punjabi','ਪੰਜਾਬੀ',NULL,NULL,NULL),(105,'gu_IN','Gujarati','ગુજરાતી',NULL,NULL,NULL),(106,'ta_IN','Tamil','தமிழ்',NULL,NULL,NULL),(107,'te_IN','Telugu','తెలుగు',NULL,NULL,NULL),(108,'kn_IN','Kannada','ಕನ್ನಡ',NULL,NULL,NULL),(109,'ml_IN','Malayalam','മലയാളം',NULL,NULL,NULL),(110,'km_KH','Khmer','ភាសាខ្មែរ',NULL,NULL,NULL);
/*!40000 ALTER TABLE `www_languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `www_pages`
--

LOCK TABLES `www_pages` WRITE;
/*!40000 ALTER TABLE `www_pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `www_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `www_template_active_elements`
--

LOCK TABLES `www_template_active_elements` WRITE;
/*!40000 ALTER TABLE `www_template_active_elements` DISABLE KEYS */;
/*!40000 ALTER TABLE `www_template_active_elements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `www_templates`
--

LOCK TABLES `www_templates` WRITE;
/*!40000 ALTER TABLE `www_templates` DISABLE KEYS */;
INSERT INTO `www_templates` VALUES (1,'Default1 (Variant trio)','/app/templates/variant-trio/','index.php','/app/templates/variant-trio/variant-trio.css',NULL),(2,'Default2 (FreshPick10)','/app/templates/FreshPick10/','index.php','/app/templates/FreshPick10/css/FreshPick.css ',NULL);
/*!40000 ALTER TABLE `www_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `www_users`
--

LOCK TABLES `www_users` WRITE;
/*!40000 ALTER TABLE `www_users` DISABLE KEYS */;
INSERT INTO `www_users` VALUES (1,'root','63a9f0ea7bb98050796b649e85481845','user@example.com','Default user',NULL,'20120101',2,1,'UTC');
/*!40000 ALTER TABLE `www_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-07-13 20:01:38
