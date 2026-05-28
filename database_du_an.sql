-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: namvuongthegioi
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `counter`
--

DROP TABLE IF EXISTS `counter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `counter` (
  `id` int NOT NULL AUTO_INCREMENT,
  `views` int DEFAULT '0',
  `visits` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `counter`
--

LOCK TABLES `counter` WRITE;
/*!40000 ALTER TABLE `counter` DISABLE KEYS */;
INSERT INTO `counter` VALUES (1,3692,1563);
/*!40000 ALTER TABLE `counter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nam_vuong_id` int NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `nam_vuong_id` (`nam_vuong_id`),
  CONSTRAINT `images_ibfk_1` FOREIGN KEY (`nam_vuong_id`) REFERENCES `nam_vuong` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nam_vuong`
--

DROP TABLE IF EXISTS `nam_vuong`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nam_vuong` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `thumbnail` varchar(255) DEFAULT 'default-avatar.jpg',
  `votes` int DEFAULT '0',
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nam_vuong`
--

LOCK TABLES `nam_vuong` WRITE;
/*!40000 ALTER TABLE `nam_vuong` DISABLE KEYS */;
INSERT INTO `nam_vuong` VALUES (1,'Tôn Đức Long','long.jpg',1100,'Chm anh ngắn nhưng ý chí anh dài\r\nHơi nghèo tí nhưng được cái đẹp trai','2026-05-16 08:07:57',1),(2,'Le Viet Anh','vanh.jpg\r\n',465020,'Đẹp trai nhất Vịnh Bắc Bộ','2026-05-16 09:00:29',1),(3,'Huy','ahuy.jpg',9081,'Muốn làm Sugar Daddy','2026-05-16 09:04:35',1),(4,'Buoi Ngọc Dương','duong.jpg',521,'Hồng hài nhi ngọt nước','2026-05-16 09:05:50',1),(6,'Lê Tuấn Danh','tuan.jpg',1009,'Đẹp trai hai mái\r\nTay phải to hơn tay trái','2026-05-16 09:09:46',1),(9,'Nguyễn Hoàng Vinh','vinh.png\r\n',102314,'Đẹp trai nhưng ngắn ?','2026-05-16 14:41:00',1),(10,'PHONG','phong.png\r\n',999999,'edfwdf','2026-05-18 02:37:12',1),(13,'Hiếu Thứ Tha','1779938162_17a9cbd575.jpg',9999999,'gggg','2026-05-26 11:08:51',1),(19,'Minh Quân','1779938463_4ae9c329ff.jpeg',1000000,'trưởng CLB Bóng đá','2026-05-28 03:21:03',1),(25,'Nam Sầm Sơn','1779948705_e78547a282.jpg',1000000,'Nam đến từ Sầm Sơn','2026-05-28 06:11:45',1);
/*!40000 ALTER TABLE `nam_vuong` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `so_du_so` int DEFAULT '100',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'long','$2y$10$e.Un6p.rq7OcoUrnAi2TLO95rv8pPF7Kuar7EnRRKu1BMSAcTbI8S',1000,'2026-05-16 15:51:06'),(2,'long1','$2y$10$EEV7185sM6sPXexwa3NiGe5Y7WlV92k8qfl2Cq5QDxYFRKMg.8IKS',10000000,'2026-05-16 15:51:06'),(3,'long2','$2y$10$JYFh815m75x98o8kN056DeWp2I3yFdPrxS.Ax2WJSAIm9ptOM3Srq',4499,'2026-05-16 15:51:06'),(4,'Giangnguyen','$2y$10$3THSe6SFnhwQlZ6trJZIROT3VMbDBVmmMMrHwYcywHt0GfIUYe7qy',10000,'2026-05-16 15:51:06'),(5,'Giangnguyen123','$2y$10$t.ucFD0s4feC5Z2kyqulG.9N9ulpoxB7pYGo2cPeTU0hu20L4wJtm',0,'2026-05-16 15:51:06'),(6,'Longkk','$2y$10$J9/lVkctYsK.itbNeZ6YZuTXr5JG9jzPF8A9LAo127DFhgF87WvqC',421,'2026-05-16 15:51:06'),(7,'Oke','$2y$10$M0OKIRdj8izRlws5PqefF.2fjfar61pxH3ePmnGbbpMc1mwcCTGZ6',9000,'2026-05-16 15:51:06'),(8,'ghét tên Long','$2y$10$MGm67DuvWQ4WQ9moBnpeoOnTNiNQMYef0FsMtIRCrlLqsgkekWNFu',9997,'2026-05-16 15:51:06'),(10,'Qwer','$2y$10$8oD1hKmj0QJq/DdzdRuobevO6NYRWpw93DcvE8ii1/Z1.pTnnFl9S',999993334,'2026-05-16 15:51:06'),(11,'admin','$2y$10$H3vR8P/vf9qQWGLqkfg5TeGD.NOZD9fmOCRWOEwU0fUoCJ9JXv7Na',99999,'2026-05-16 15:51:06'),(12,'abc','$2y$10$.g0.S4IrBmflZ0qfNSVPdefxXzRoQuMwkWim.zCOaEnhXUwBma3f6',9,'2026-05-17 14:48:45'),(13,'anh1310@','$2y$10$UrFZwNFML09hCbuEmDuFEe/1U55GB9UpuGLUVi41s04ZRclsCcYmy',9,'2026-05-18 02:30:20'),(15,'huylt','$2y$10$IWaT/O3q3oszytn8kV2zwOTzZfWHOFaL8.mv2advUBfMAUjdXDYae',1000000000,'2026-05-19 02:56:29'),(17,'log','$2y$10$zpdVErV8TQBfHMOIdW531uy0cfSVnZHpS1YbCeNe6WmHSuiYfWfQG',9000,'2026-05-26 16:27:43');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vote_history`
--

DROP TABLE IF EXISTS `vote_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vote_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `candidate_id` int NOT NULL,
  `so_luong_vote` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `fk_vote_candidate` (`candidate_id`),
  CONSTRAINT `fk_vote_candidate` FOREIGN KEY (`candidate_id`) REFERENCES `nam_vuong` (`id`) ON DELETE CASCADE,
  CONSTRAINT `vote_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vote_history`
--

LOCK TABLES `vote_history` WRITE;
/*!40000 ALTER TABLE `vote_history` DISABLE KEYS */;
INSERT INTO `vote_history` VALUES (1,3,2,5000,'2026-05-16 14:23:03'),(3,3,9,1,'2026-05-16 14:46:46'),(5,6,4,500,'2026-05-16 15:09:14'),(6,7,6,1000,'2026-05-16 15:15:36'),(9,6,3,1,'2026-05-16 15:22:22'),(19,1,4,1,'2026-05-17 05:50:55'),(20,12,2,10000,'2026-05-17 14:49:27'),(24,11,10,50000,'2026-05-18 02:38:07'),(25,11,2,450000,'2026-05-18 03:37:29'),(26,11,9,4433,'2026-05-19 02:48:31'),(27,10,9,1,'2026-05-19 02:52:48'),(28,10,9,1,'2026-05-19 02:53:07'),(31,15,2,1,'2026-05-19 02:56:41'),(34,6,3,76,'2026-05-20 15:56:58'),(35,6,9,1,'2026-05-20 16:18:52'),(36,6,3,1,'2026-05-20 16:19:04'),(37,1,10,9999999,'2026-05-22 02:26:34'),(38,11,9,95567,'2026-05-22 02:27:24'),(39,11,2,9,'2026-05-25 05:00:47'),(41,11,10,10,'2026-05-26 09:41:50'),(42,11,9,10,'2026-05-26 10:38:15'),(44,11,4,1,'2026-05-26 10:50:11'),(45,11,4,7,'2026-05-26 10:50:42'),(54,11,25,1,'2026-05-28 06:13:37');
/*!40000 ALTER TABLE `vote_history` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-28 15:55:54
