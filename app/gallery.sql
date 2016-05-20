-- MySQL dump 10.13  Distrib 5.7.12, for Linux (i686)
--
-- Host: localhost    Database: gallery
-- ------------------------------------------------------
-- Server version	5.7.12-0ubuntu1

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
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `header` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `imageId` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Індивідуальні фотосесії',1,'Індивідуальні фотосесії'),(2,'Сімейні фотосесії',1,'Сімейні фотосесії'),(3,'Love story',1,'Love story');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `image`
--

DROP TABLE IF EXISTS `image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `image`
--

LOCK TABLES `image` WRITE;
/*!40000 ALTER TABLE `image` DISABLE KEYS */;
INSERT INTO `image` VALUES (1,'Photo 2016-05-20 02:35:20','894d3685a934c5bb0d6b71e1138f8997.jpeg',0,'empty description'),(2,'Photo 2016-05-20 02:37:36','8e77ba6180bd662a8547f45f56cbd0db.jpeg',0,'empty description'),(3,'Photo 2016-05-20 02:38:53','0036115b59b8b800598508e057457740.jpeg',0,'empty description'),(4,'Photo 2016-05-20 02:39:03','353411142cc08e01665a51b5a1833819.jpeg',0,'empty description'),(5,'Photo 2016-05-20 02:39:15','8637a27119f4a4014755d6f473c7d463.jpeg',0,'empty description'),(6,'Photo 2016-05-20 02:39:39','0b1d8c9bb511c536cbf6ea787029c30a.jpeg',0,'empty description'),(7,'Photo 2016-05-20 02:40:02','d0d0f6b724b80ab7d63151b1d7a8d6f3.jpeg',0,'empty description'),(8,'Photo 2016-05-20 02:40:12','173ea9fea64bfc5c91bdf0410cf31af1.jpeg',0,'empty description'),(9,'Photo 2016-05-20 02:40:20','d864f866a34c1457708f82635562f03e.jpeg',0,'empty description'),(10,'Photo 2016-05-20 02:40:29','cde58df0f4e67073fec9c5ee149c9103.jpeg',0,'empty description'),(11,'Photo 2016-05-20 02:40:39','72aa365e9bd81c7099ce73ddb2bbbf81.jpeg',0,'empty description'),(12,'Photo 2016-05-20 02:40:49','4076f3eaf26941b4d13f1142c0ac9d21.jpeg',0,'empty description'),(13,'Photo 2016-05-20 02:41:00','bef704527d2980237d23750eb87fb080.jpeg',0,'empty description'),(14,'Photo 2016-05-20 02:41:10','dc60bdbd0759c01b73cc29d7261a0639.jpeg',0,'empty description'),(15,'Photo 2016-05-20 02:41:19','34b2cf12e95b21e8f60c9a2627d8c939.jpeg',0,'empty description'),(16,'Photo 2016-05-20 02:41:33','98d03681f337869820e832f0c116097d.jpeg',0,'empty description'),(17,'Photo 2016-05-20 02:41:42','0caad4aabc0418378c6ecfabb05465e5.jpeg',0,'empty description'),(18,'Photo 2016-05-20 02:41:51','ad7f514274e7a49b37f796ec45891c27.jpeg',0,'empty description'),(19,'Photo 2016-05-20 02:42:00','acaf4d4cde370f4fd9b8e55e3acb86bf.jpeg',0,'empty description'),(20,'Photo 2016-05-20 02:42:11','8f84ae2618463029b2949f12e59879dc.jpeg',0,'empty description'),(21,'Photo 2016-05-20 02:42:22','fa0f411a3e10f85ae771366530adf709.jpeg',0,'empty description'),(22,'Photo 2016-05-20 02:42:32','b18af170dccb9e2305cf75f2902b83ec.jpeg',0,'empty description');
/*!40000 ALTER TABLE `image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `image_category`
--

DROP TABLE IF EXISTS `image_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `image_category` (
  `imageId` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL,
  PRIMARY KEY (`imageId`,`categoryId`),
  KEY `IDX_89BC976910F3034D` (`imageId`),
  KEY `IDX_89BC97699C370B71` (`categoryId`),
  CONSTRAINT `FK_89BC976910F3034D` FOREIGN KEY (`imageId`) REFERENCES `image` (`id`),
  CONSTRAINT `FK_89BC97699C370B71` FOREIGN KEY (`categoryId`) REFERENCES `category` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `image_category`
--

LOCK TABLES `image_category` WRITE;
/*!40000 ALTER TABLE `image_category` DISABLE KEYS */;
INSERT INTO `image_category` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1);
/*!40000 ALTER TABLE `image_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` longtext COLLATE utf8_unicode_ci NOT NULL,
  `isShow` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` VALUES (1,'Послуги','<p>Сімейна фотосесія</p>\r\n<p>Індивідуальна фотосесія</p>\r\n<p>Репортажна фотосесія (дні народження)</p>\r\n<p>Весільна зйомка</p>\r\n<p>&nbsp;</p>',1),(2,'Потрібно знати','<p>Тра ля ля</p>',1),(3,'Ціни','<p>один два</p>',1),(4,'Контакти','<p>Мої контакти</p>',1);
/*!40000 ALTER TABLE `post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-05-20 18:31:43
