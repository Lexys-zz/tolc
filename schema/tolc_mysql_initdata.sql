-- MySQL dump 10.13  Distrib 5.5.23, for Linux (x86_64)
--
-- Host: localhost    Database: tolc_tmpl
-- ------------------------------------------------------
-- Server version	5.5.23

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
-- Dumping data for table `www_languages`
--

LOCK TABLES `www_languages` WRITE;
/*!40000 ALTER TABLE `www_languages` DISABLE KEYS */;
INSERT INTO `www_languages` VALUES (1,'aa','Afar','Afar',NULL,NULL,NULL),(2,'ab','Abkhazian','Аҧсуа',NULL,NULL,NULL),(3,'af','Afrikaans','Afrikaans',NULL,NULL,NULL),(4,'ak','Akan','Akana',NULL,NULL,NULL),(5,'als','Alemannic','Alemannisch',NULL,NULL,NULL),(6,'am','Amharic','አማርኛ',NULL,NULL,NULL),(7,'an','Aragonese','Aragonés',NULL,NULL,NULL),(8,'ang','Anglo-Saxon / Old English','Englisc',NULL,NULL,NULL),(9,'ar','Arabic','العربية',NULL,NULL,NULL),(10,'arc','Aramaic','ܣܘܪܬ',NULL,NULL,NULL),(11,'as','Assamese','অসমীয়া',NULL,NULL,NULL),(12,'ast','Asturian','Asturianu',NULL,NULL,NULL),(13,'av','Avar','Авар',NULL,NULL,NULL),(14,'ay','Aymara','Aymar',NULL,NULL,NULL),(15,'az','Azerbaijani','Azərbaycanca / آذربايجان',NULL,NULL,NULL),(16,'ba','Bashkir','Башҡорт',NULL,NULL,NULL),(17,'bar','Bavarian','Boarisch',NULL,NULL,NULL),(18,'bat-smg','Samogitian','Žemaitėška',NULL,NULL,NULL),(19,'bcl','Bikol','Bikol Central',NULL,NULL,NULL),(20,'be','Belarusian','Беларуская',NULL,NULL,NULL),(21,'be-x-old','Belarusian (Taraškievica)','Беларуская (тарашкевіца)',NULL,NULL,NULL),(22,'bg','Bulgarian','Български',NULL,NULL,NULL),(23,'bh','Bihari','भोजपुरी',NULL,NULL,NULL),(24,'bi','Bislama','Bislama',NULL,NULL,NULL),(25,'bm','Bambara','Bamanankan',NULL,NULL,NULL),(26,'bn','Bengali','বাংলা',NULL,NULL,NULL),(27,'bo','Tibetan','བོད་ཡིག / Bod skad',NULL,NULL,NULL),(28,'bpy','Bishnupriya Manipuri','ইমার ঠার/বিষ্ণুপ্রিয়া মণিপুরী',NULL,NULL,NULL),(29,'br','Breton','Brezhoneg',NULL,NULL,NULL),(30,'bs','Bosnian','Bosanski',NULL,NULL,NULL),(31,'bug','Buginese','ᨅᨔ ᨕᨘᨁᨗ / Basa Ugi',NULL,NULL,NULL),(32,'bxr','Buriat (Russia)','Буряад хэлэн',NULL,NULL,NULL),(33,'ca','Catalan','Català',NULL,NULL,NULL),(34,'ce','Chechen','Нохчийн',NULL,NULL,NULL),(35,'ceb','Cebuano','Sinugboanong Binisaya',NULL,NULL,NULL),(36,'ch','Chamorro','Chamoru',NULL,NULL,NULL),(37,'cho','Choctaw','Choctaw',NULL,NULL,NULL),(38,'chr','Cherokee','ᏣᎳᎩ',NULL,NULL,NULL),(39,'chy','Cheyenne','Tsetsêhestâhese',NULL,NULL,NULL),(40,'co','Corsican','Corsu',NULL,NULL,NULL),(41,'cr','Cree','Nehiyaw',NULL,NULL,NULL),(42,'cs','Czech','Česky',NULL,NULL,NULL),(43,'csb','Kashubian','Kaszëbsczi',NULL,NULL,NULL),(44,'cu','Old Church Slavonic / Old Bulgarian','словѣньскъ / slověnĭskŭ',NULL,NULL,NULL),(45,'cv','Chuvash','Чăваш',NULL,NULL,NULL),(46,'cy','Welsh','Cymraeg',NULL,NULL,NULL),(47,'da','Danish','Dansk',NULL,NULL,NULL),(48,'de','German','Deutsch',NULL,NULL,NULL),(49,'diq','Dimli','Zazaki',NULL,NULL,NULL),(50,'dsb','Lower Sorbian','Dolnoserbski',NULL,NULL,NULL),(51,'dv','Divehi','ދިވެހިބަސް',NULL,NULL,NULL),(52,'dz','Dzongkha','ཇོང་ཁ',NULL,NULL,NULL),(53,'ee','Ewe','Ɛʋɛ',NULL,NULL,NULL),(54,'el','Greek','Ελληνικά',1,1,NULL),(55,'en','English','English',1,NULL,NULL),(56,'eo','Esperanto','Esperanto',NULL,NULL,NULL),(57,'es','Spanish','Español',NULL,NULL,NULL),(58,'et','Estonian','Eesti',NULL,NULL,NULL),(59,'eu','Basque','Euskara',NULL,NULL,NULL),(60,'ext','Extremaduran','Estremeñu',NULL,NULL,NULL),(61,'fa','Persian','فارسی',NULL,NULL,NULL),(62,'ff','Peul','Fulfulde',NULL,NULL,NULL),(63,'fi','Finnish','Suomi',NULL,NULL,NULL),(64,'fiu-vro','Võro','Võro',NULL,NULL,NULL),(65,'fj','Fijian','Na Vosa Vakaviti',NULL,NULL,NULL),(66,'fo','Faroese','Føroyskt',NULL,NULL,NULL),(67,'fr','French','Français',NULL,NULL,NULL),(68,'frp','Arpitan / Franco-Provençal','Arpitan / francoprovençal',NULL,NULL,NULL),(69,'fur','Friulian','Furlan',NULL,NULL,NULL),(70,'fy','West Frisian','Frysk',NULL,NULL,NULL),(71,'ga','Irish','Gaeilge',NULL,NULL,NULL),(72,'gd','Scottish Gaelic','Gàidhlig',NULL,NULL,NULL),(73,'gil','Gilbertese','Taetae ni kiribati',NULL,NULL,NULL),(74,'gl','Galician','Galego',NULL,NULL,NULL),(75,'gn','Guarani','Avañe\'ẽ',NULL,NULL,NULL),(76,'got','Gothic','gutisk',NULL,NULL,NULL),(77,'gu','Gujarati','ગુજરાતી',NULL,NULL,NULL),(78,'gv','Manx','Gaelg',NULL,NULL,NULL),(79,'ha','Hausa','هَوُسَ',NULL,NULL,NULL),(80,'haw','Hawaiian','Hawai`i',NULL,NULL,NULL),(81,'he','Hebrew','עברית',NULL,NULL,NULL),(82,'hi','Hindi','हिन्दी',NULL,NULL,NULL),(83,'ho','Hiri Motu','Hiri Motu',NULL,NULL,NULL),(84,'hr','Croatian','Hrvatski',NULL,NULL,NULL),(85,'ht','Haitian','Krèyol ayisyen',NULL,NULL,NULL),(86,'hu','Hungarian','Magyar',NULL,NULL,NULL),(87,'hy','Armenian','Հայերեն',NULL,NULL,NULL),(88,'hz','Herero','Otsiherero',NULL,NULL,NULL),(89,'ia','Interlingua','Interlingua',NULL,NULL,NULL),(90,'id','Indonesian','Bahasa Indonesia',NULL,NULL,NULL),(91,'ie','Interlingue','Interlingue',NULL,NULL,NULL),(92,'ig','Igbo','Igbo',NULL,NULL,NULL),(93,'ii','Sichuan Yi','ꆇꉙ / 四川彝语',NULL,NULL,NULL),(94,'ik','Inupiak','Iñupiak',NULL,NULL,NULL),(95,'ilo','Ilokano','Ilokano',NULL,NULL,NULL),(96,'io','Ido','Ido',NULL,NULL,NULL),(97,'is','Icelandic','Íslenska',NULL,NULL,NULL),(98,'it','Italian','Italiano',NULL,NULL,NULL),(99,'iu','Inuktitut','ᐃᓄᒃᑎᑐᑦ',NULL,NULL,NULL),(100,'ja','Japanese','日本語',NULL,NULL,NULL),(101,'jbo','Lojban','Lojban',NULL,NULL,NULL),(102,'jv','Javanese','Basa Jawa',NULL,NULL,NULL),(103,'ka','Georgian','ქართული',NULL,NULL,NULL),(104,'kg','Kongo','KiKongo',NULL,NULL,NULL),(105,'ki','Kikuyu','Gĩkũyũ',NULL,NULL,NULL),(106,'kj','Kuanyama','Kuanyama',NULL,NULL,NULL),(107,'kk','Kazakh','Қазақша',NULL,NULL,NULL),(108,'kl','Greenlandic','Kalaallisut',NULL,NULL,NULL),(109,'km','Cambodian','ភាសាខ្មែរ',NULL,NULL,NULL),(110,'kn','Kannada','ಕನ್ನಡ',NULL,NULL,NULL),(111,'ko','Korean','한국어',NULL,NULL,NULL),(112,'kr','Kanuri','Kanuri',NULL,NULL,NULL),(113,'ks','Kashmiri','कश्मीरी / كشميري',NULL,NULL,NULL),(114,'ksh','Ripuarian','Ripoarisch',NULL,NULL,NULL),(115,'ku','Kurdish','Kurdî / كوردی',NULL,NULL,NULL),(116,'kv','Komi','Коми',NULL,NULL,NULL),(117,'kw','Cornish','Kernewek',NULL,NULL,NULL),(118,'ky','Kirghiz','Kırgızca / Кыргызча',NULL,NULL,NULL),(119,'la','Latin','Latina',NULL,NULL,NULL),(120,'lad','Ladino / Judeo-Spanish','Dzhudezmo / Djudeo-Espanyol',NULL,NULL,NULL),(121,'lan','Lango','Leb Lango / Luo',NULL,NULL,NULL),(122,'lb','Luxembourgish','Lëtzebuergesch',NULL,NULL,NULL),(123,'lg','Ganda','Luganda',NULL,NULL,NULL),(124,'li','Limburgian','Limburgs',NULL,NULL,NULL),(125,'lij','Ligurian','Líguru',NULL,NULL,NULL),(126,'lmo','Lombard','Lumbaart',NULL,NULL,NULL),(127,'ln','Lingala','Lingála',NULL,NULL,NULL),(128,'lo','Laotian','ລາວ / Pha xa lao',NULL,NULL,NULL),(129,'lt','Lithuanian','Lietuvių',NULL,NULL,NULL),(130,'lv','Latvian','Latviešu',NULL,NULL,NULL),(131,'map-bms','Banyumasan','Basa Banyumasan',NULL,NULL,NULL),(132,'mg','Malagasy','Malagasy',NULL,NULL,NULL),(133,'mh','Marshallese','Kajin Majel / Ebon',NULL,NULL,NULL),(134,'mi','Maori','Māori',NULL,NULL,NULL),(135,'mk','Macedonian','Македонски',NULL,NULL,NULL),(136,'ml','Malayalam','മലയാളം',NULL,NULL,NULL),(137,'mn','Mongolian','Монгол',NULL,NULL,NULL),(138,'mo','Moldovan','Moldovenească',NULL,NULL,NULL),(139,'mr','Marathi','मराठी',NULL,NULL,NULL),(140,'ms','Malay','Bahasa Melayu',NULL,NULL,NULL),(141,'mt','Maltese','bil-Malti',NULL,NULL,NULL),(142,'mus','Creek / Muskogee','Mvskoke',NULL,NULL,NULL),(143,'my','Burmese','Myanmasa',NULL,NULL,NULL),(144,'na','Nauruan','Dorerin Naoero',NULL,NULL,NULL),(145,'nah','Nahuatl','Nahuatl',NULL,NULL,NULL),(146,'nap','Neapolitan','Nnapulitano',NULL,NULL,NULL),(147,'nd','North Ndebele','Sindebele',NULL,NULL,NULL),(148,'nds','Low German / Low Saxon','Plattdüütsch',NULL,NULL,NULL),(149,'nds-nl','Dutch Low Saxon','Nedersaksisch',NULL,NULL,NULL),(150,'ne','Nepali','नेपाली',NULL,NULL,NULL),(151,'new','Newar','नेपालभाषा / Newah Bhaye',NULL,NULL,NULL),(152,'ng','Ndonga','Oshiwambo',NULL,NULL,NULL),(153,'nl','Dutch','Nederlands',NULL,NULL,NULL),(154,'nn','Norwegian Nynorsk','Norsk (nynorsk)',NULL,NULL,NULL),(155,'no','Norwegian','Norsk (bokmål / riksmål)',NULL,NULL,NULL),(156,'nr','South Ndebele','isiNdebele',NULL,NULL,NULL),(157,'nso','Northern Sotho','Sesotho sa Leboa / Sepedi',NULL,NULL,NULL),(158,'nrm','Norman','Nouormand / Normaund',NULL,NULL,NULL),(159,'nv','Navajo','Diné bizaad',NULL,NULL,NULL),(160,'ny','Chichewa','Chi-Chewa',NULL,NULL,NULL),(161,'oc','Occitan','Occitan',NULL,NULL,NULL),(162,'oj','Ojibwa','ᐊᓂᔑᓈᐯᒧᐎᓐ / Anishinaabemowin',NULL,NULL,NULL),(163,'om','Oromo','Oromoo',NULL,NULL,NULL),(164,'or','Oriya','ଓଡ଼ିଆ',NULL,NULL,NULL),(165,'os','Ossetian / Ossetic','Иронау',NULL,NULL,NULL),(166,'pa','Panjabi / Punjabi','ਪੰਜਾਬੀ / पंजाबी / پنجابي',NULL,NULL,NULL),(167,'pag','Pangasinan','Pangasinan',NULL,NULL,NULL),(168,'pam','Kapampangan','Kapampangan',NULL,NULL,NULL),(169,'pap','Papiamentu','Papiamentu',NULL,NULL,NULL),(170,'pdc','Pennsylvania German','Deitsch',NULL,NULL,NULL),(171,'pi','Pali','Pāli / पाऴि',NULL,NULL,NULL),(172,'pih','Norfolk','Norfuk',NULL,NULL,NULL),(173,'pl','Polish','Polski',NULL,NULL,NULL),(174,'pms','Piedmontese','Piemontèis',NULL,NULL,NULL),(175,'ps','Pashto','پښتو',NULL,NULL,NULL),(176,'pt','Portuguese','Português',NULL,NULL,NULL),(177,'qu','Quechua','Runa Simi',NULL,NULL,NULL),(178,'rm','Raeto Romance','Rumantsch',NULL,NULL,NULL),(179,'rmy','Romani','Romani / रोमानी',NULL,NULL,NULL),(180,'rn','Kirundi','Kirundi',NULL,NULL,NULL),(181,'ro','Romanian','Română',NULL,NULL,NULL),(182,'roa-rup','Aromanian','Armâneashti',NULL,NULL,NULL),(183,'ru','Russian','Русский',NULL,NULL,NULL),(184,'rw','Rwandi','Kinyarwandi',NULL,NULL,NULL),(185,'sa','Sanskrit','संस्कृतम्',NULL,NULL,NULL),(186,'sc','Sardinian','Sardu',NULL,NULL,NULL),(187,'scn','Sicilian','Sicilianu',NULL,NULL,NULL),(188,'sco','Scots','Scots',NULL,NULL,NULL),(189,'sd','Sindhi','सिनधि',NULL,NULL,NULL),(190,'se','Northern Sami','Sámegiella',NULL,NULL,NULL),(191,'sg','Sango','Sängö',NULL,NULL,NULL),(192,'sh','Serbo-Croatian','Srpskohrvatski / Српскохрватски',NULL,NULL,NULL),(193,'si','Sinhalese','සිංහල',NULL,NULL,NULL),(194,'simple','Simple English','Simple English',NULL,NULL,NULL),(195,'sk','Slovak','Slovenčina',NULL,NULL,NULL),(196,'sl','Slovenian','Slovenščina',NULL,NULL,NULL),(197,'sm','Samoan','Gagana Samoa',NULL,NULL,NULL),(198,'sn','Shona','chiShona',NULL,NULL,NULL),(199,'so','Somalia','Soomaaliga',NULL,NULL,NULL),(200,'sq','Albanian','Shqip',NULL,NULL,NULL),(201,'sr','Serbian','Српски',NULL,NULL,NULL),(202,'ss','Swati','SiSwati',NULL,NULL,NULL),(203,'st','Southern Sotho','Sesotho',NULL,NULL,NULL),(204,'su','Sundanese','Basa Sunda',NULL,NULL,NULL),(205,'sv','Swedish','Svenska',NULL,NULL,NULL),(206,'sw','Swahili','Kiswahili',NULL,NULL,NULL),(207,'ta','Tamil','தமிழ்',NULL,NULL,NULL),(208,'te','Telugu','తెలుగు',NULL,NULL,NULL),(209,'tet','Tetum','Tetun',NULL,NULL,NULL),(210,'tg','Tajik','Тоҷикӣ',NULL,NULL,NULL),(211,'th','Thai','ไทย / Phasa Thai',NULL,NULL,NULL),(212,'ti','Tigrinya','ትግርኛ',NULL,NULL,NULL),(213,'tk','Turkmen','Туркмен / تركمن',NULL,NULL,NULL),(214,'tl','Tagalog / Filipino','Tagalog',NULL,NULL,NULL),(215,'tlh','Klingon','tlhIngan-Hol',NULL,NULL,NULL),(216,'tn','Tswana','Setswana',NULL,NULL,NULL),(217,'to','Tonga','Lea Faka-Tonga',NULL,NULL,NULL),(218,'tpi','Tok Pisin','Tok Pisin',NULL,NULL,NULL),(219,'tr','Turkish','Türkçe',NULL,NULL,NULL),(220,'ts','Tsonga','Xitsonga',NULL,NULL,NULL),(221,'tt','Tatar','Tatarça',NULL,NULL,NULL),(222,'tum','Tumbuka','chiTumbuka',NULL,NULL,NULL),(223,'tw','Twi','Twi',NULL,NULL,NULL),(224,'ty','Tahitian','Reo Mā`ohi',NULL,NULL,NULL),(225,'udm','Udmurt','Удмурт кыл',NULL,NULL,NULL),(226,'ug','Uyghur','Uyƣurqə / ئۇيغۇرچە',NULL,NULL,NULL),(227,'uk','Ukrainian','Українська',NULL,NULL,NULL),(228,'ur','Urdu','اردو',NULL,NULL,NULL),(229,'uz','Uzbek','Ўзбек',NULL,NULL,NULL),(230,'ve','Venda','Tshivenḓa',NULL,NULL,NULL),(231,'vi','Vietnamese','Tiếng Việt',NULL,NULL,NULL),(232,'vec','Venetian','Vèneto',NULL,NULL,NULL),(233,'vls','West Flemish','West-Vlaoms',NULL,NULL,NULL),(234,'vo','Volapük','Volapük',NULL,NULL,NULL),(235,'wa','Walloon','Walon',NULL,NULL,NULL),(236,'war','Waray-Waray / Samar-Leyte Visayan','Winaray / Binisaya Lineyte-Samarnon',NULL,NULL,NULL),(237,'wo','Wolof','Wollof',NULL,NULL,NULL),(238,'xal','Kalmyk','Хальмг',NULL,NULL,NULL),(239,'xh','Xhosa','isiXhosa',NULL,NULL,NULL),(240,'yi','Yiddish','ייִדיש',NULL,NULL,NULL),(241,'yo','Yoruba','Yorùbá',NULL,NULL,NULL),(242,'za','Zhuang','Cuengh / Tôô / 壮语',NULL,NULL,NULL),(243,'zh','Chinese','中文',NULL,NULL,NULL),(244,'zh-min-nan','Minnan','Bân-lâm-gú',NULL,NULL,NULL),(245,'zh-yue','Cantonese','粵語 / 粤语',NULL,NULL,NULL),(246,'zu','Zulu','isiZulu',NULL,NULL,NULL);
/*!40000 ALTER TABLE `www_languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `www_lookup_data`
--

LOCK TABLES `www_lookup_data` WRITE;
/*!40000 ALTER TABLE `www_lookup_data` DISABLE KEYS */;
INSERT INTO `www_lookup_data` VALUES (1,1,55,1,'pending registration',10),(2,1,55,2,'active user',20),(3,1,55,3,'inactive user',30),(4,1,54,1,'σε αναμονή για έγγραφή',10),(5,1,54,2,'ενεργός χρήστης',20),(6,1,54,3,'ανενεργός χρήστης',30),(7,2,55,7,'pending publication',10),(8,2,55,8,'published',20),(9,2,55,9,'discarded',30),(10,2,55,10,'removed',40),(11,2,54,7,'σε αναμονή για δημοσίευση',10),(12,2,54,8,'δημοσιευμένο',20),(13,2,54,9,'απορρίφθηκε',30),(14,2,54,10,'απομακρύνθηκε',40);
/*!40000 ALTER TABLE `www_lookup_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `www_lookups`
--

LOCK TABLES `www_lookups` WRITE;
/*!40000 ALTER TABLE `www_lookups` DISABLE KEYS */;
INSERT INTO `www_lookups` VALUES (1,'lk_user_status_id',NULL),(2,'lk_publish_status_id',NULL);
/*!40000 ALTER TABLE `www_lookups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `www_modules`
--

LOCK TABLES `www_modules` WRITE;
/*!40000 ALTER TABLE `www_modules` DISABLE KEYS */;
/*!40000 ALTER TABLE `www_modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `www_pages`
--

LOCK TABLES `www_pages` WRITE;
/*!40000 ALTER TABLE `www_pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `www_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `www_section_content`
--

LOCK TABLES `www_section_content` WRITE;
/*!40000 ALTER TABLE `www_section_content` DISABLE KEYS */;
/*!40000 ALTER TABLE `www_section_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `www_sections`
--

LOCK TABLES `www_sections` WRITE;
/*!40000 ALTER TABLE `www_sections` DISABLE KEYS */;
/*!40000 ALTER TABLE `www_sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `www_template_active_divs`
--

LOCK TABLES `www_template_active_divs` WRITE;
/*!40000 ALTER TABLE `www_template_active_divs` DISABLE KEYS */;
/*!40000 ALTER TABLE `www_template_active_divs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `www_templates`
--

LOCK TABLES `www_templates` WRITE;
/*!40000 ALTER TABLE `www_templates` DISABLE KEYS */;
/*!40000 ALTER TABLE `www_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `www_users`
--

LOCK TABLES `www_users` WRITE;
/*!40000 ALTER TABLE `www_users` DISABLE KEYS */;
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

-- Dump completed on 2012-05-24 20:59:24
