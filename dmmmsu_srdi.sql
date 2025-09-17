-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: localhost    Database: dmmmsu_srdi
-- ------------------------------------------------------
-- Server version	9.1.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `activities` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=104 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES (1,'User logged in',1,'2025-08-17 17:27:13'),(2,'User logged in',1,'2025-08-17 17:38:09'),(3,'User logged in',1,'2025-08-17 17:40:11'),(4,'User logged out',1,'2025-08-17 17:43:18'),(5,'User logged out',1,'2025-08-17 17:44:46'),(6,'User logged out',1,'2025-08-17 17:45:31'),(7,'User logged out',1,'2025-08-17 17:47:45'),(8,'User logged in',1,'2025-08-17 17:47:46'),(9,'User logged in',1,'2025-08-17 20:49:19'),(10,'User registered',6,'2025-08-17 21:12:54'),(11,'User logged in',1,'2025-08-17 21:13:05'),(12,'User logged in',1,'2025-08-17 21:21:11'),(13,'User logged in',1,'2025-08-17 22:31:07'),(14,'User logged in',1,'2025-08-17 22:31:10'),(15,'User logged in',1,'2025-08-17 22:31:33'),(16,'User logged in',1,'2025-08-17 22:31:47'),(17,'User logged in',1,'2025-08-17 22:31:51'),(18,'User logged in',1,'2025-08-17 22:31:55'),(19,'User logged in',1,'2025-08-17 22:32:07'),(20,'User logged in',1,'2025-08-17 22:32:32'),(21,'User logged in',1,'2025-08-17 22:34:04'),(22,'User logged in',1,'2025-08-17 22:34:08'),(23,'User logged in',1,'2025-08-17 22:34:52'),(24,'User logged in',2,'2025-09-07 16:33:29'),(25,'User logged in',2,'2025-09-07 16:34:05'),(26,'Password updated',1,'2025-09-07 16:34:43'),(27,'User logged in',2,'2025-09-07 16:34:45'),(28,'User logged in',1,'2025-09-07 16:34:55'),(29,'User logged in',1,'2025-09-07 16:42:29'),(30,'User logged in',2,'2025-09-07 16:42:55'),(31,'User logged in',4,'2025-09-07 16:43:51'),(32,'User logged in',4,'2025-09-07 16:46:14'),(33,'User logged in',4,'2025-09-07 16:46:46'),(34,'User logged in',4,'2025-09-07 16:47:14'),(35,'User logged in',2,'2025-09-07 16:48:02'),(36,'User logged in',1,'2025-09-07 16:48:09'),(37,'User registered',7,'2025-09-07 16:52:10'),(38,'User logged in',1,'2025-09-07 16:52:57'),(39,'User logged in',1,'2025-09-07 16:54:43'),(40,'User logged in',1,'2025-09-07 17:01:30'),(41,'User logged in',1,'2025-09-07 17:02:01'),(42,'User registered',8,'2025-09-07 17:06:43'),(43,'User registered',9,'2025-09-07 17:06:53'),(44,'User registered',10,'2025-09-07 17:07:00'),(45,'User registered',11,'2025-09-07 17:07:07'),(46,'User registered',12,'2025-09-07 17:07:14'),(47,'User logged in',8,'2025-09-07 17:07:29'),(48,'User logged in',8,'2025-09-07 19:06:12'),(49,'User logged in',9,'2025-09-07 19:06:26'),(50,'User logged in',9,'2025-09-07 19:18:02'),(51,'User logged in',9,'2025-09-07 19:20:23'),(52,'User logged in',9,'2025-09-07 19:20:30'),(53,'User logged in',9,'2025-09-07 19:20:44'),(54,'User logged in',9,'2025-09-07 19:25:39'),(55,'User logged in',9,'2025-09-07 19:25:46'),(56,'User logged in',9,'2025-09-07 19:26:16'),(57,'User logged in',10,'2025-09-07 19:26:28'),(58,'User logged in',9,'2025-09-07 19:29:10'),(59,'User logged in',9,'2025-09-07 19:30:17'),(60,'User logged in',10,'2025-09-07 19:31:52'),(61,'User logged in',12,'2025-09-07 19:33:00'),(62,'User logged in',8,'2025-09-07 19:34:16'),(63,'User logged in',9,'2025-09-07 19:44:16'),(64,'User logged in',9,'2025-09-07 19:45:56'),(65,'User logged in',10,'2025-09-07 19:49:07'),(66,'User registered',13,'2025-09-07 19:53:28'),(67,'User logged in',13,'2025-09-07 19:53:48'),(68,'User registered',14,'2025-09-07 20:50:04'),(69,'User registered',15,'2025-09-07 20:50:12'),(70,'Updated research paper #10 status to Approved',13,'2025-09-07 21:03:37'),(71,'Updated research paper #9 status to Revised',13,'2025-09-07 21:03:51'),(72,'User logged in',11,'2025-09-07 21:41:24'),(73,'User logged in',11,'2025-09-07 21:44:20'),(74,'User logged in',8,'2025-09-07 22:00:14'),(75,'Updated research paper #12 status to Cancelled',8,'2025-09-07 23:00:01'),(76,'Updated research paper #13 status to Cancelled',8,'2025-09-07 23:12:10'),(77,'User logged in',13,'2025-09-07 23:13:38'),(78,'Updated research paper #11 status to Approved',13,'2025-09-07 23:17:32'),(79,'Updated research paper #13 status to Approved',13,'2025-09-07 23:18:11'),(80,'Updated research paper #12 status to Approved',13,'2025-09-07 23:18:13'),(81,'User logged in',11,'2025-09-07 23:18:53'),(82,'User logged in',8,'2025-09-07 23:19:24'),(83,'User logged in',13,'2025-09-07 23:28:05'),(84,'User logged in',13,'2025-09-07 23:28:41'),(85,'Updated research paper #10 status to Declined',13,'2025-09-07 23:30:35'),(86,'User logged in',12,'2025-09-07 23:48:58'),(87,'User logged in',13,'2025-09-07 23:50:08'),(88,'User logged in',12,'2025-09-07 23:50:21'),(89,'User logged in',12,'2025-09-07 23:51:40'),(90,'User logged in',12,'2025-09-07 23:53:45'),(91,'User logged out',12,'2025-09-07 23:55:00'),(92,'User logged in',12,'2025-09-07 23:55:02'),(93,'User logged out',12,'2025-09-07 23:56:24'),(94,'User logged in',9,'2025-09-07 23:56:28'),(95,'User logged in',9,'2025-09-07 23:59:29'),(96,'User logged in',9,'2025-09-08 00:06:46'),(97,'Updated research paper #13 status to Approved (app',9,'2025-09-08 00:11:30'),(98,'Updated research paper #13 status to Approved (app',9,'2025-09-08 00:11:35'),(99,'Updated research paper #13 status to Approved (app',9,'2025-09-08 00:11:53'),(100,'Updated research paper #12 status to Approved (app',9,'2025-09-08 00:12:10'),(101,'Updated research paper #13 status to Approved (app',9,'2025-09-08 00:12:13'),(102,'Updated research paper #11 status to Approved (app',9,'2025-09-08 00:12:15'),(103,'User logged in',10,'2025-09-08 00:20:13');
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employees` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `middle_name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `permanent_address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` enum('researcher','admin','researcher_division_head','section_head','srdi_record_staff','executive_director') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (8,'Colette','Renee Snider','Horton','Ipsum ab quibusdam','rizuwyjyf@mailinator.com','$2y$10$a83QyQcZguoe9rWh9dthluTmgTUqZEOG8yz7KahRpaQ2kw3HCzcnS','researcher',1,'2025-09-07 17:06:43','2025-09-07 17:06:43'),(9,'Rhona','Sonia Johnston','Britt','Porro omnis cumque q','ruwu@mailinator.com','$2y$10$0m4mcDFKk7eUBn9RcYQin.dda3.HtlIvFkx7fbuXQH5GQ7SvybxLK','researcher_division_head',1,'2025-09-07 17:06:53','2025-09-07 17:06:53'),(10,'Naomi','Daphne Noel','Willis','Sed in et nulla volu','goweqax@mailinator.com','$2y$10$yrY.17nvVNfzrVg8jrvk4O9vGYU8IvFBBvdGmZr7iW19qjvfeEPbe','section_head',1,'2025-09-07 17:07:00','2025-09-07 17:07:00'),(11,'Thane','Austin Cervantes','Byrd','Magna laudantium el','tifibuv@mailinator.com','$2y$10$rJmk7we97v.X8RJ4KNDrv.Yw.PLJx4Bj3tKiy6TYiEmj/xaPR8G2y','srdi_record_staff',1,'2025-09-07 17:07:07','2025-09-07 17:07:07'),(12,'Naida','Honorato Olson','Bowen','Dolore qui sint corp','kideg@mailinator.com','$2y$10$/19k5x0Hf.OanRgylm1vGOcwH8g0KPQ1iH6pFd1qzVaxIXXjLDIjy','executive_director',1,'2025-09-07 17:07:14','2025-09-07 17:07:14'),(13,'Tobias','Branden Wise','Ford','Ea illum delectus','qixuso@mailinator.com','$2y$10$ZNKk7Dpsu.vDdAF3fF1w..BUEuDNOmnRZlLOpW4CI3UBQd66jZEt6','admin',1,'2025-09-07 19:53:28','2025-09-07 19:53:41'),(14,'Reese','Briar Carlson','Mccall','Qui Nam doloribus di','turycec@mailinator.com','$2y$10$Np1EvcXwp0EHI1.KRswJ5e5RGZkjGYiBocIl6vsXqnNpVyMWUXrFe','researcher',1,'2025-09-07 20:50:04','2025-09-07 20:50:04'),(15,'Shafira','Deborah Snyder','Best','Adipisicing qui sequ','qyjyfuc@mailinator.com','$2y$10$BgWam.1UjRWocaAzlfoQg.YIcsPfZGixcFb7CzB6iR8FuJBS2x/eq','admin',1,'2025-09-07 20:50:12','2025-09-07 20:50:12');
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `information` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int NOT NULL,
  `status` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `research_papers`
--

DROP TABLE IF EXISTS `research_papers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `research_papers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `research_title` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `research_abstract` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `research_objective` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `research_members` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `research_created_by` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `research_created_by_user_id` int NOT NULL,
  `research_status` enum('Pending','Approved','Cancelled','Declined','Revised','Publish') COLLATE utf8mb4_general_ci NOT NULL,
  `research_recieved_by` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pdf_filename` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `research_recieved_by` (`research_recieved_by`(250))
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `research_papers`
--

LOCK TABLES `research_papers` WRITE;
/*!40000 ALTER TABLE `research_papers` DISABLE KEYS */;
INSERT INTO `research_papers` VALUES (9,'Est quis doloribus i','Dicta ducimus quibu','Amet natus nemo nes','Aut sunt est optio ','Kato Ware',0,'Revised','13','SQL QUERY PRACTICE.pdf','2025-09-07 16:35:07','2025-09-07 23:47:17'),(10,'Sed corporis omnis p','Veniam alias volupt','Maxime quia laudanti','Iure impedit quia a','Kato Ware',0,'Declined','13','ABMA-106_Module-2_unlocked.pdf','2025-09-07 16:36:52','2025-09-07 23:33:10'),(11,'Eos hic ut consequat','Aut dolores velit ni','Dolores inventore qu','Sed quia ut magnam m','Colette Horton',8,'Approved','13','ISSM102.pdf','2025-09-07 22:12:35','2025-09-08 00:12:15'),(12,'Blanditiis pariatur','Vel fugiat odio nos','Quia totam dicta inv','Vero consequuntur mi','Colette Horton',8,'Approved','13','1757257978_Klaire_MTLP[1].pdf','2025-09-07 22:52:37','2025-09-08 00:12:10'),(13,'Id nemo tempora min','Aliquid voluptatem ','Repudiandae dolore o','Pariatur Veniam ve','Colette Horton',8,'Approved','13','1757257926_Klaire_MTLP[1].pdf','2025-09-07 23:12:06','2025-09-08 00:12:13');
/*!40000 ALTER TABLE `research_papers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-08  0:35:23
