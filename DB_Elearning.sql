-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: lms_multitenant
-- ------------------------------------------------------
-- Server version	8.2.0

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
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `announcements` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int unsigned NOT NULL,
  `author_id` int unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `content` text COLLATE utf8mb4_general_ci NOT NULL,
  `target_role` enum('all','instructor','student') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'all',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tenant_id` (`tenant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcements`
--

LOCK TABLES `announcements` WRITE;
/*!40000 ALTER TABLE `announcements` DISABLE KEYS */;
INSERT INTO `announcements` VALUES (1,1,12,'TES','TES','student','2026-07-28 08:32:09','2026-07-28 08:32:09'),(2,1,2,'TEST','TEST','instructor','2026-07-28 08:33:22','2026-07-28 08:33:22');
/*!40000 ALTER TABLE `announcements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assignments`
--

DROP TABLE IF EXISTS `assignments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `assignments` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `type` enum('submission','quiz','essay','cbt') COLLATE utf8mb4_general_ci DEFAULT 'submission',
  `due_date` datetime DEFAULT NULL,
  `file_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `question_bank_id` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assignments_course_id_foreign` (`course_id`),
  CONSTRAINT `assignments_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assignments`
--

LOCK TABLES `assignments` WRITE;
/*!40000 ALTER TABLE `assignments` DISABLE KEYS */;
INSERT INTO `assignments` VALUES (1,2,'TES','TES','submission','2026-07-29 14:01:00',NULL,NULL,NULL,NULL),(2,2,'YES CBT','CBT','cbt','2026-07-31 16:12:00',NULL,NULL,NULL,NULL),(3,2,'CBT COBA','CEK','cbt','2026-07-29 09:45:00',NULL,NULL,NULL,2),(4,2,'CBT COBA','CEK','cbt','2026-08-01 09:45:00',NULL,NULL,NULL,2);
/*!40000 ALTER TABLE `assignments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_enrollments`
--

DROP TABLE IF EXISTS `course_enrollments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course_enrollments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `course_id` int NOT NULL,
  `student_id` int NOT NULL,
  `status` enum('pending','approved','blocked') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `course_enrollments_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `course_enrollments_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_enrollments`
--

LOCK TABLES `course_enrollments` WRITE;
/*!40000 ALTER TABLE `course_enrollments` DISABLE KEYS */;
INSERT INTO `course_enrollments` VALUES (1,2,14,'approved','2026-07-28 09:05:40');
/*!40000 ALTER TABLE `course_enrollments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_modules`
--

DROP TABLE IF EXISTS `course_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course_modules` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `file_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_modules_course_id_foreign` (`course_id`),
  CONSTRAINT `course_modules_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_modules`
--

LOCK TABLES `course_modules` WRITE;
/*!40000 ALTER TABLE `course_modules` DISABLE KEYS */;
INSERT INTO `course_modules` VALUES (1,2,'TES','TES',NULL,1,NULL,NULL),(2,2,'Cek 2','Teori 2','https://s3.ap-northeast-1.idrivee2.com/lms-multitenant-toscaflow/materials/1785311887_1da1273ae051b6668a4a.pdf',3,NULL,NULL);
/*!40000 ALTER TABLE `course_modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL,
  `instructor_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `enrollment_key` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tenant_id` (`tenant_id`),
  KEY `instructor_id` (`instructor_id`),
  CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
  CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES (1,1,1,'zfdvdf','bxdfbxfd','2026-07-27 10:47:00',NULL),(2,1,12,'TES','TES','2026-07-28 07:00:40','ABC123');
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2026-07-28-062617','App\\Database\\Migrations\\CreateCourseModulesTable','default','App',1785220252,1),(2,'2026-07-28-062635','App\\Database\\Migrations\\CreateAssignmentsTable','default','App',1785220253,1),(3,'2026-07-28-072028','App\\Database\\Migrations\\AddNewFeaturesForInstructor','default','App',1785223251,2),(4,'2026-07-28-073256','App\\Database\\Migrations\\AddEnrollmentsToCourses','default','App',1785227095,3),(5,'2026-07-28-082345','App\\Database\\Migrations\\CreateAnnouncementsTable','default','App',1785227095,3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_banks`
--

DROP TABLE IF EXISTS `question_banks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `question_banks` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int unsigned NOT NULL,
  `instructor_id` int unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_banks`
--

LOCK TABLES `question_banks` WRITE;
/*!40000 ALTER TABLE `question_banks` DISABLE KEYS */;
INSERT INTO `question_banks` VALUES (1,1,12,'TES CBT','CBT TES','2026-07-28 07:29:01','2026-07-28 07:29:01'),(2,1,12,'TES','TES','2026-07-29 02:43:45','2026-07-29 02:43:45');
/*!40000 ALTER TABLE `question_banks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `questions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `question_bank_id` int unsigned NOT NULL,
  `type` enum('multiple_choice','essay') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'multiple_choice',
  `question_text` text COLLATE utf8mb4_general_ci NOT NULL,
  `options` text COLLATE utf8mb4_general_ci,
  `correct_answer` text COLLATE utf8mb4_general_ci,
  `points` int NOT NULL DEFAULT '10',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (1,1,'multiple_choice','ururhrhrh','{\"A\":\"jfjfjfjf\",\"B\":\"ieirjjrir\",\"C\":\"jxydgebe\",\"D\":\"jrjfhfjfjf\"}','A',10,'2026-07-28 07:51:07','2026-07-28 07:51:07'),(4,1,'multiple_choice','Siapa penemu lampu pijar?','{\"A\":\"Albert Einstein\",\"B\":\"Thomas Edison\",\"C\":\"Nikola Tesla\",\"D\":\"Isaac Newton\"}','B',10,'2026-07-28 07:57:02','2026-07-28 07:57:02'),(5,1,'essay','Jelaskan teori relativitas secara singkat!',NULL,'E=mc2, massa dan energi adalah sama.',20,'2026-07-28 07:57:02','2026-07-28 07:57:02'),(6,2,'multiple_choice','Siapa penemu lampu pijar?','{\"A\":\"Albert Einstein\",\"B\":\"Thomas Edison\",\"C\":\"Nikola Tesla\",\"D\":\"Isaac Newton\"}','B',10,'2026-07-29 02:44:22','2026-07-29 02:44:22'),(7,2,'essay','Jelaskan teori relativitas secara singkat!',NULL,'E=mc2, massa dan energi adalah sama.',20,'2026-07-29 02:44:22','2026-07-29 02:44:22');
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `storage_objects`
--

DROP TABLE IF EXISTS `storage_objects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `storage_objects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL,
  `course_id` int DEFAULT NULL,
  `uploaded_by` int NOT NULL,
  `file_type` enum('material','assignment_cbt','submission') NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `s3_path` varchar(500) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `tenant_id` (`tenant_id`),
  CONSTRAINT `storage_objects_ibfk_1` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `storage_objects`
--

LOCK TABLES `storage_objects` WRITE;
/*!40000 ALTER TABLE `storage_objects` DISABLE KEYS */;
/*!40000 ALTER TABLE `storage_objects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_submissions`
--

DROP TABLE IF EXISTS `student_submissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student_submissions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `assignment_id` int unsigned NOT NULL,
  `student_id` int unsigned NOT NULL,
  `file_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `essay_answer` text COLLATE utf8mb4_general_ci,
  `score` int DEFAULT NULL,
  `feedback` text COLLATE utf8mb4_general_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_submissions`
--

LOCK TABLES `student_submissions` WRITE;
/*!40000 ALTER TABLE `student_submissions` DISABLE KEYS */;
INSERT INTO `student_submissions` VALUES (1,1,14,'/uploads/submissions/1785290997_d986dbe302583588c6a1.xlsx',NULL,NULL,NULL,'2026-07-29 02:09:57','2026-07-29 02:09:57'),(2,4,14,NULL,'{\"6\":\"B\",\"7\":\"e=mc2\"}',33,NULL,'2026-07-29 02:49:59','2026-07-29 02:49:59');
/*!40000 ALTER TABLE `student_submissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tenants`
--

DROP TABLE IF EXISTS `tenants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tenants` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tenant_string_id` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `domain` varchar(255) NOT NULL,
  `status` enum('active','blocked') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tenant_string_id` (`tenant_string_id`),
  UNIQUE KEY `domain` (`domain`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tenants`
--

LOCK TABLES `tenants` WRITE;
/*!40000 ALTER TABLE `tenants` DISABLE KEYS */;
INSERT INTO `tenants` VALUES (1,'univ_test','UNIV TEST','https://ut.ac.id','active','2026-07-27 02:52:39');
/*!40000 ALTER TABLE `tenants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tenant_id` int DEFAULT NULL,
  `role` enum('super_admin','tenant_admin','instructor','student') NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `is_blocked` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `tenant_id` (`tenant_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,NULL,'super_admin','Super Admin','superadmin','superadmin@lms.local','$2y$12$bDwsMq05FBmQL93mB5sK.uwCwv0mkG287x4Cu0t7hevLM6LzT.BZ6',0,'2026-07-26 23:57:38'),(2,1,'tenant_admin','admin','univ_test_admin','admin@ut.ac.id','$2y$12$nNYIakY7r2ARVIyq/QS.7.Fy3cBXLtzYV3VrzOYIF013zXCMGHbTq',0,'2026-07-27 02:52:39'),(3,1,'','TEST','farrasdy','farras@tsc.id','$2y$12$jn21QIpC.8fB9xE/ES6M9us6b4FzeEAJIlUXSa8zOCAHgAmdClaKO',0,'2026-07-27 03:46:05'),(4,1,'','dfbxdb','xdfbxdfb','xfbgxgb@drgxdf.iz','$2y$12$LB/QwuBRnemPqenHfwsjquzyZ/7g5w38XbsfLxMAWf2i.HrPwZAL2',0,'2026-07-27 03:47:18'),(5,1,'','NAMA SAYA','nm','nm@tsc.id','$2y$12$kzVdxLoYFmalauv/.D6eXuiGRhR5vF6Uy8zjHM963Lua5zoeFwVnK',0,'2026-07-27 03:50:26'),(6,1,'','dfbxd','fbxdfbx','xfdbxf@dh.if','$2y$12$x/S9dCcjkdKz8EJFUxr4/OPfOwKYwMhma7OYU0H3lXykzJ2j7xxye',0,'2026-07-27 03:50:39'),(7,1,'tenant_admin','zdfzd','gxdfgxdf','xdfgx@hxh.iv','$2y$12$MYUMerbbz6ojTUdpAZSHUeH0Oji6qRij3xbqyevJb4s5uCV9k2yEO',0,'2026-07-27 03:50:55'),(12,1,'instructor','FARRAS DAFFA','daffayrr','farras@tosca.id','$2y$12$G7oGhzXU5.LaPt4PseUINeKQzSqBqTK9DNXjY4PvG1OTNH815QOxK',0,'2026-07-27 23:37:29'),(14,1,'student','IMAM MUQAFFI','imam','imam@tosca.id','$2y$12$qCpp2TaWLiYI7C9e3wswyONFtJd/gWqNRDTLyOI5thudBWrAO3G72',0,'2026-07-28 01:39:01'),(15,1,'student','sdfvsf','sdfvsfdv','sdfvsf@dfvgdf.izd','$2y$12$F/pJkwuexDixowv1YJU1sO0VCm8jVKRSGF.IkJjmt7W/pssfC.1Hu',0,'2026-07-28 01:50:16');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-31  8:33:10
