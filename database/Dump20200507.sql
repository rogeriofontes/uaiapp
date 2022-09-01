-- MySQL dump 10.13  Distrib 5.7.26, for Linux (x86_64)
--
-- Host: mysql524.umbler.com    Database: aplication
-- ------------------------------------------------------
-- Server version	5.6.40-log

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
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `addresses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cep` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `neighborhood` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `complement` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city_id` int(10) unsigned NOT NULL,
  `person_id` int(10) unsigned NOT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `addresses_person_id_foreign` (`person_id`),
  KEY `addresses_city_id_foreign` (`city_id`),
  CONSTRAINT `addresses_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  CONSTRAINT `addresses_person_id_foreign` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addresses`
--

LOCK TABLES `addresses` WRITE;
/*!40000 ALTER TABLE `addresses` DISABLE KEYS */;
INSERT INTO `addresses` VALUES (1,'14730-000','Rua 1','Bairro 1','1','Complemento 1',1,4,-20.8890637,-48.6790007,'2018-06-28 13:50:13','2018-07-12 19:59:40',NULL),(2,'14780-580','Rua 38','Jardim Alvorada','192A',NULL,2,42,-20.55729969953509,-48.580689925270065,'2018-07-13 17:00:06','2018-07-13 17:00:06',NULL),(3,'38200-000','Avenida MP 13 - Doutor Domingos Boldrini','centro','1027',NULL,3,3,NULL,NULL,'2019-07-08 14:16:08','2019-07-29 13:30:50',NULL),(4,'38200-000','Rua Bias Fortes,','Centro','338',NULL,3,120,NULL,NULL,'2019-07-29 13:41:58','2019-07-29 13:41:58',NULL);
/*!40000 ALTER TABLE `addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banners` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `media_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `banners_media_id_foreign` (`media_id`),
  CONSTRAINT `banners_media_id_foreign` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banners`
--

LOCK TABLES `banners` WRITE;
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;
INSERT INTO `banners` VALUES (1,'edit','edit.com',33,'2018-06-28 13:47:58','2018-06-28 13:48:24','2018-06-28 13:48:24'),(2,'Rural Brokers','www.ruralbrokers.com.br',59,'2018-07-03 14:25:00','2018-07-03 17:46:50',NULL),(3,'Banner TMG','toquesmotog.com.br',60,'2018-07-03 17:18:03','2018-07-03 18:06:06','2018-07-03 18:06:06'),(4,'Fazenda Jaó','fjaomg.com.br/',151,'2018-11-09 14:15:46','2019-07-08 14:14:14','2019-07-08 14:14:14');
/*!40000 ALTER TABLE `banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `checkouts`
--

DROP TABLE IF EXISTS `checkouts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `checkouts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code_pagseguro` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_pagseguro` datetime DEFAULT NULL,
  `status` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'PROCESSANDO',
  `link_boleto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paymentMethod` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `plan_id` int(10) unsigned NOT NULL,
  `user_app_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `checkouts_plan_id_foreign` (`plan_id`),
  KEY `checkouts_user_app_id_foreign` (`user_app_id`),
  KEY `checkouts_product_id_foreign` (`product_id`),
  CONSTRAINT `checkouts_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `checkouts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `checkouts_user_app_id_foreign` FOREIGN KEY (`user_app_id`) REFERENCES `user_apps` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `checkouts`
--

LOCK TABLES `checkouts` WRITE;
/*!40000 ALTER TABLE `checkouts` DISABLE KEYS */;
INSERT INTO `checkouts` VALUES (10,'FC0FB89B-BE9F-42E9-91EF-F8B14DAF3219','2019-07-08 16:44:55','6','','1',2,1,88,'2019-07-08 19:39:18','2019-07-08 19:45:00',NULL),(11,'B9211C8A-CF64-4FC1-9945-F1F7DF72FAD1','2019-07-08 16:47:02','3','https://sandbox.pagseguro.uol.com.br/checkout/payment/booklet/print.jhtml?c=919fcf874152cca560efb97d46011cf347d517a53b03a7c5b1be37ec88d51a0517f294c54a66bc4c','2',3,1,89,'2019-07-08 19:46:28','2019-07-08 19:47:08',NULL),(12,NULL,NULL,'PROCESSANDO',NULL,'1',2,115,92,'2019-07-29 13:46:07','2019-07-29 13:46:07',NULL),(13,NULL,NULL,'PROCESSANDO',NULL,'1',2,115,92,'2019-07-29 13:47:56','2019-07-29 13:47:56',NULL),(14,NULL,NULL,'PROCESSANDO',NULL,'1',2,115,92,'2019-07-29 13:48:24','2019-07-29 13:48:24',NULL),(15,NULL,NULL,'PROCESSANDO',NULL,'1',2,115,92,'2019-07-29 13:49:02','2019-07-29 13:49:02',NULL),(16,NULL,NULL,'PROCESSANDO',NULL,'1',2,115,93,'2019-07-29 13:55:54','2019-07-29 13:55:54',NULL),(17,NULL,NULL,'PROCESSANDO',NULL,'1',2,115,93,'2019-07-29 13:56:35','2019-07-29 13:56:35',NULL),(18,'A8251D9F-C142-4CAA-8F34-C557EA283276','2019-07-29 11:08:49','3','','1',2,115,93,'2019-07-29 14:06:38','2019-07-29 14:08:55',NULL),(19,NULL,'2019-08-22 09:26:36','3',NULL,NULL,1,1,94,'2019-08-22 12:26:36','2019-08-22 12:26:36',NULL),(20,NULL,'2019-08-29 09:05:50','3',NULL,NULL,1,1,95,'2019-08-29 12:05:50','2019-08-29 12:05:50',NULL),(21,NULL,'2019-09-04 17:20:29','3',NULL,NULL,1,115,96,'2019-09-04 20:20:29','2019-09-04 20:20:29',NULL),(22,NULL,'2019-09-17 16:55:10','3',NULL,NULL,1,1,98,'2019-09-17 19:55:10','2019-09-17 19:55:10',NULL),(23,NULL,'2019-10-05 18:30:10','3',NULL,NULL,1,115,99,'2019-10-05 21:30:10','2019-10-05 21:30:10',NULL);
/*!40000 ALTER TABLE `checkouts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cities_state_id_foreign` (`state_id`),
  CONSTRAINT `cities_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cities`
--

LOCK TABLES `cities` WRITE;
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (1,'Monte Azul Paulista',1,'2018-06-28 13:49:48','2018-06-28 13:49:48',NULL),(2,'Barretos',1,'2018-07-13 16:59:02','2018-07-13 16:59:02',NULL),(3,'Frutal',2,'2018-11-09 14:39:32','2018-11-09 14:39:32',NULL);
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `countries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (1,'Brasil','2018-04-06 17:48:43','2018-04-06 17:48:43',NULL);
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fcms`
--

DROP TABLE IF EXISTS `fcms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fcms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `device_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_app_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fcms_user_app_id_foreign` (`user_app_id`),
  CONSTRAINT `fcms_user_app_id_foreign` FOREIGN KEY (`user_app_id`) REFERENCES `user_apps` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fcms`
--

LOCK TABLES `fcms` WRITE;
/*!40000 ALTER TABLE `fcms` DISABLE KEYS */;
/*!40000 ALTER TABLE `fcms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `media` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `thumbnail_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `media_type_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `media_media_type_id_foreign` (`media_type_id`),
  CONSTRAINT `media_media_type_id_foreign` FOREIGN KEY (`media_type_id`) REFERENCES `media_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
INSERT INTO `media` VALUES (1,'3ae19688-33bf-48a1-af66-76b711635ebd.jpeg','pictures/Gj3rwg9wA8qJLyq0eJ2xHe1YeKoTJ8XkeAYW15PI.jpeg','pictures/e6d974d4fae099f3eaee59be8d40afa8.jpg',1,'2018-04-18 15:47:08','2018-04-18 15:47:08',NULL),(2,'3ae19688-33bf-48a1-af66-76b711635ebd.jpeg','pictures/hMhG2Cb9XF3aMrUxBgK6x21acml9OlI7jAJNxaXI.jpeg','pictures/e6d974d4fae099f3eaee59be8d40afa8.jpg',1,'2018-04-18 15:47:46','2018-04-18 15:47:46',NULL),(3,'3ae19688-33bf-48a1-af66-76b711635ebd.jpeg','pictures/3LDsn2M9fKTkP4htXyy1dI1FhjH61zNBNHdcgJVr.jpeg','pictures/e6d974d4fae099f3eaee59be8d40afa8.jpg',1,'2018-04-18 15:47:52','2018-04-18 15:47:52',NULL),(4,'3ae19688-33bf-48a1-af66-76b711635ebd.jpeg','pictures/HIJGgqp2sl4S8xy1uNBH2BFFVJjpTuqZ302LXwpH.jpeg','pictures/e6d974d4fae099f3eaee59be8d40afa8.jpg',1,'2018-04-18 15:48:26','2018-04-18 16:13:10','2018-04-18 16:13:10'),(5,'01@2x (1).png','pictures/rw0KeuCiWhaupvRiUzRNze0U1Zxk57W0XVCNJ5nO.png','pictures/e7b5658fed61bf112cd12008d8794ddb.jpg',1,'2018-04-18 16:13:10','2018-04-18 17:17:32','2018-04-18 17:17:32'),(6,'01@2x.png','pictures/2PoASz7qapZ4Eb7yu7296zyrazyTSF6UmkzbbDq6.png','pictures/c36c915055049f7791eb29d4f176edeb.jpg',1,'2018-04-18 17:17:32','2018-04-18 17:23:27','2018-04-18 17:23:27'),(9,'dsc_0022.jpg','pictures/D6pl5JOLJlF02mKgtjrfYWZS62arjviNIclyygTG.jpeg','pictures/67615f5b61412fcdd4609dfd4f30301d.jpg',1,'2018-04-18 17:26:10','2018-04-18 17:26:10',NULL),(10,'1.jpg','pictures/rf36o18hmBfMxuU093cI6ecdW0B5DclkQ4dFSBjz.jpeg','pictures/25985ac6565ef97a5beb57a89cb53472.jpg',1,'2018-04-23 02:57:57','2018-04-23 16:47:54','2018-04-23 16:47:54'),(11,'30428610.jpg','pictures/cj3FbHUmIFu7NQmMHnlSea0D7QfF4aVtYqic81UZ.jpeg','pictures/4faa5c7e3f8afac4c26deb01e1655465.jpg',1,'2018-04-23 02:58:07','2018-04-23 16:48:16','2018-04-23 16:48:16'),(20,'loja.png','pictures/yGA7H9BEyvn2J0Lxt6gTh7P68ND6cpnRV8FFESP6.png','pictures/ba41a1e09f820d52e018fbd093943c0d.jpg',1,'2018-06-28 13:09:26','2018-06-28 13:09:26',NULL),(26,'img_2.png','pictures/CfPJHcotgnw2Hssp8KsY7Rfex3NfHZGLovpVbRxt.png','pictures/feeec296b537a5259f607de2b7672e2c.jpg',1,'2018-06-28 13:17:14','2018-06-28 13:17:14',NULL),(29,'d144f11645841afb440c2818aaf4c5ee','pictures/e6b35ac91f1d3ba8261b4bcff7f9e9391749d75b.jpg','pictures/d144f11645841afb440c2818aaf4c5ee.jpg',1,'2018-06-28 13:25:43','2018-06-28 13:25:43',NULL),(30,'93395bdafae3c98b9a12cb1a2c449456','pictures/a312cc0c0833cad4613fe786587ac3f6b9cc17fd.jpg','pictures/93395bdafae3c98b9a12cb1a2c449456.jpg',1,'2018-06-28 13:25:43','2018-06-28 13:25:43',NULL),(31,'img_2.png','pictures/D7X2pwW4kFC91Yj4NXjMIoY4SneJi0D5zUv5MQNy.png','pictures/feeec296b537a5259f607de2b7672e2c.jpg',1,'2018-06-28 13:29:08','2018-06-28 13:29:08',NULL),(33,'img_3.jpg','pictures/dnKqce6eJcXMWmisfJTaAz0IT2Ww4Ws6p4VKQYeF.jpeg','pictures/7cd9d027b72ec296ee2415857a911a25.jpg',1,'2018-06-28 13:48:13','2018-06-28 13:48:13',NULL),(34,'img_3.jpg','pictures/LIbycjgv3OxNv0xIqtOGTmeypcR9hUzEFGISiPvc.jpeg','pictures/7cd9d027b72ec296ee2415857a911a25.jpg',1,'2018-06-28 13:50:13','2018-06-28 13:50:13',NULL),(35,'img_4.png','pictures/yPGEhrlDDtZffYJBZ7TtlbgM6QcsuHrfGoZ0KcxP.png','pictures/3e818de1cdd15848856b8cac577be865.jpg',1,'2018-06-28 13:50:40','2018-06-28 13:50:40',NULL),(36,'c306d6e3f64073aebeabfa5d09fe77cf','pictures/debb0737dbc213e8d42787a36aaa467578b35308.jpg','pictures/c306d6e3f64073aebeabfa5d09fe77cf.jpg',1,'2018-06-28 14:09:05','2018-06-28 14:09:05',NULL),(37,'96b7f775cad42575e7a41cc392d5a51f','pictures/87494908f1c82e9de276dd139a6104ff10ef0d74.jpg','pictures/96b7f775cad42575e7a41cc392d5a51f.jpg',1,'2018-06-28 15:19:07','2018-06-28 15:19:07',NULL),(38,'1305005749061799ecd114405405acae','pictures/c4955cc755c612b508620d07903d8dc12e4f3438.jpg','pictures/1305005749061799ecd114405405acae.jpg',1,'2018-06-28 15:24:57','2018-06-28 15:24:57',NULL),(39,'15c8e7bbcb5b721aff64f7a3f1888b54','pictures/7762a91b8ef9d2305d001384a1f89b706a036677.jpg','pictures/15c8e7bbcb5b721aff64f7a3f1888b54.jpg',1,'2018-06-28 15:27:41','2018-06-28 15:27:41',NULL),(40,'aminais-mini.png','pictures/Bef59IFGgGPE5okk2eyY6a14NgiUDXaTOAoE2dyj.png','pictures/1390a49388f040823a3bba60929842a7.jpg',1,'2018-06-29 12:23:38','2018-06-29 12:23:38',NULL),(41,'Grãos-mini.png','pictures/4ILTyrKfI41TRXeJttgpUSPvNg2R3WTOz3M8YLRC.png','pictures/d5f7e505650cfdf5bc0af06edd879320.jpg',1,'2018-06-29 12:23:45','2018-06-29 12:23:45',NULL),(42,'MAQUINAS-mini.png','pictures/XYyPQg1bDVi6Mly7dNW5KTwqA37xRoVhASEi3RRE.png','pictures/d58c364c5ec23a497fd4ae834913e5a3.jpg',1,'2018-06-29 12:23:51','2018-06-29 12:23:51',NULL),(43,'SERVIÇOS-mini.png','pictures/YXQNKqLfjuYfSujhFKZ1CNODmHioTGNsv9Ldf3cl.png','pictures/ea23a76187a8712c62ddddbe5bb0eafa.jpg',1,'2018-06-29 12:23:59','2018-06-29 12:23:59',NULL),(44,'LOJAS-mini.png','pictures/mzkxiR5q9F6MHD6NTJLWKpTvuvBESzylnyhXdjkp.png','pictures/00237ee61b7fe1a0720abd76d28a4123.jpg',1,'2018-06-29 12:24:08','2018-06-29 12:24:08',NULL),(45,'insumos-mini.png','pictures/bHIUOPUldPQdEQfYf7lkvqNazIWVhG0r10erUv0j.png','pictures/a180b0c48bd045dcb7ba07284b7f7c93.jpg',1,'2018-06-29 12:24:15','2018-06-29 12:24:15',NULL),(46,'Frete-mini.png','pictures/nLg2Dz5kkCsKYDfqafcUkRhFiU259T0WtGdc0bdK.png','pictures/6510637677380650c4433e1cf5eb8578.jpg',1,'2018-06-29 12:24:23','2018-06-29 12:24:23',NULL),(47,'IMOVEIS-mini.png','pictures/5q6JSc8i989AiAwqcZYwBXlYa3oaFpUk3dMAyopC.png','pictures/2d11eb21ac1de745fbd925d4a320454e.jpg',1,'2018-06-29 12:24:32','2018-06-29 12:24:32',NULL),(48,'5a2cc3fce2a828f098b58deb1af897a4','pictures/2f54de6c92baf372d395bb85dbb7b35d0c59b973.jpg','pictures/5a2cc3fce2a828f098b58deb1af897a4.jpg',1,'2018-06-30 12:10:16','2018-06-30 12:10:16',NULL),(49,'70cfccb57678dce1b458f04be57ed132','pictures/0a5f260a4fd3f7434ebfaa5b8ccee34b6234f4ce.jpg','pictures/70cfccb57678dce1b458f04be57ed132.jpg',1,'2018-06-30 12:12:23','2018-06-30 12:12:23',NULL),(50,'30a5d8e15e915c1e25f8964bde873702','pictures/66c03019cc2e6008f98a24d059c3c78691029df1.jpg','pictures/30a5d8e15e915c1e25f8964bde873702.jpg',1,'2018-06-30 12:14:23','2018-06-30 12:14:23',NULL),(51,'1e70f930bcb92bba04081e4b690db032','pictures/7272208fbc5bd05348d83b04202fe98521a13240.jpg','pictures/1e70f930bcb92bba04081e4b690db032.jpg',1,'2018-06-30 12:24:51','2018-06-30 12:24:51',NULL),(52,'ed1fd0a4574404459831a0acf2788df9','pictures/8383d4e4baadb0277f2c500d1b833484175043fe.jpg','pictures/ed1fd0a4574404459831a0acf2788df9.jpg',1,'2018-06-30 12:26:26','2018-06-30 12:26:26',NULL),(53,'abe4d5eef4a7de3450b706dc267b6c3e','pictures/c9068b111415761115a785e00ff12bca471ea79a.jpg','pictures/abe4d5eef4a7de3450b706dc267b6c3e.jpg',1,'2018-06-30 12:28:56','2018-06-30 12:28:56',NULL),(54,'b59064f65a0edbfdfe005c0f48f90312','pictures/bd446c343de3e7d53817eaba4bd74a56394b57bf.jpg','pictures/b59064f65a0edbfdfe005c0f48f90312.jpg',1,'2018-07-02 11:42:27','2018-07-02 11:42:27',NULL),(57,'ec319844d53d4d7a9841d55707e02b99','pictures/ad3a04d1f247e02854ae9b49cbc87b0d91969cee.jpg','pictures/ec319844d53d4d7a9841d55707e02b99.jpg',1,'2018-07-03 16:31:43','2018-07-03 16:31:43',NULL),(59,'b_brokers.png','pictures/Thc6Qh2nkLgGpsdlr6NFje3Im1t7wUxfScJSTBGO.png','pictures/fb780167cda04b2d5d7c20117d271399.jpg',1,'2018-07-03 17:46:50','2018-07-03 17:46:50',NULL),(60,'blog.png','pictures/aCh48anuPbqQcNSDizPLcoJFh9dYTb7dfbMlDA0f.png','pictures/d90fa9138d50a529733efb5aff85c094.jpg',1,'2018-07-03 17:47:04','2018-07-03 17:47:04',NULL),(61,'8cbf2d2bd9a55ed5220f8d0145ebf07f','pictures/bbf8a698d284c4fa328974f4fa23a1775d78d53c.jpg','pictures/8cbf2d2bd9a55ed5220f8d0145ebf07f.jpg',1,'2018-07-04 18:47:34','2018-07-04 18:47:34',NULL),(62,'05f0907f358b087b9bae733db7a690c3','pictures/7f1bd1d90dc463a1fed0ff06d6178274eb20be9a.jpg','pictures/05f0907f358b087b9bae733db7a690c3.jpg',1,'2018-07-04 18:47:34','2018-07-04 18:47:34',NULL),(63,'9458a41daa734098e05fc6bfa181e38f','pictures/aae58bae4f8a494fc5d211bad95fabe218222640.jpg','pictures/9458a41daa734098e05fc6bfa181e38f.jpg',1,'2018-07-04 18:47:34','2018-07-04 18:47:34',NULL),(64,'58f151310d230af5bf70542b5e4108d5','pictures/fb8031f6a2cd7849e398f908787721f1fd1b512b.jpg','pictures/58f151310d230af5bf70542b5e4108d5.jpg',1,'2018-07-04 18:47:34','2018-07-04 18:47:34',NULL),(65,'43b05639ddc710968d1cbbe161c6427e','pictures/7235aa26a24b413f299cc2aab5798e56e316f487.jpg','pictures/43b05639ddc710968d1cbbe161c6427e.jpg',1,'2018-07-04 18:47:34','2018-07-04 18:47:34',NULL),(66,'61cf6cf201d7ad67ea525e24860fca3f','pictures/07c4c1aea212b20debc7428cd123e9ccdd79efce.jpg','pictures/61cf6cf201d7ad67ea525e24860fca3f.jpg',1,'2018-07-04 23:56:00','2018-07-04 23:56:00',NULL),(67,'398000c37dfd7be0c29d5f707c970fc5','pictures/4e7f0232be9eb2fb75f24e581d1ef1738503c94f.jpg','pictures/398000c37dfd7be0c29d5f707c970fc5.jpg',1,'2018-07-04 23:56:00','2018-07-04 23:56:00',NULL),(68,'d4cbecfe2068106bd8d66d8d261bdea3','pictures/e03dd08ce72c0d8ca359274da5615452afbac1fe.jpg','pictures/d4cbecfe2068106bd8d66d8d261bdea3.jpg',1,'2018-07-05 00:05:14','2018-07-05 00:05:14',NULL),(69,'78bdf6d0d7f46c0f94ff631c159dd890','pictures/f4063c45847bb6d051ccd5ada5b973958b76eb3f.jpg','pictures/78bdf6d0d7f46c0f94ff631c159dd890.jpg',1,'2018-07-05 00:05:14','2018-07-05 00:05:14',NULL),(70,'bf111562d0dc0b8a726a2a9c9309e0d3','pictures/03e27abfd7fa860cf7a04fc39c9c0cdd1fb9bfef.jpg','pictures/bf111562d0dc0b8a726a2a9c9309e0d3.jpg',1,'2018-07-05 00:05:14','2018-07-05 00:05:14',NULL),(71,'2d1f5a9bfdff03c10f0140596ddf142a','pictures/8809ca404d201d17f3f446df13862a27709e5dec.jpg','pictures/2d1f5a9bfdff03c10f0140596ddf142a.jpg',1,'2018-07-05 00:05:14','2018-07-05 00:05:14',NULL),(72,'139220a0a29e760092c2019329c00a8f','pictures/cf3ea0cc34ad070cc3f6b0a7971e0ffea82d0574.jpg','pictures/139220a0a29e760092c2019329c00a8f.jpg',1,'2018-07-05 00:05:14','2018-07-05 00:05:14',NULL),(73,'8091bf7ea02bc3e99044e59ca8c817c4','pictures/eab0aab6393e4806d6e600211e7eb8d04edcf253.jpg','pictures/8091bf7ea02bc3e99044e59ca8c817c4.jpg',1,'2018-07-12 00:15:08','2018-07-12 00:15:08',NULL),(74,'a9f2daf22665f85e3ffaa85acbc485c0','pictures/003cbe82b7d5d035d7168a700e0d6dfbb31d3a80.jpg','pictures/a9f2daf22665f85e3ffaa85acbc485c0.jpg',1,'2018-07-12 01:35:02','2018-07-12 01:35:02',NULL),(75,'icone.png','pictures/Bnrmg7mThpw1eyxmOpiQM2jewO3YO2cSjSbPtrpK.png','pictures/26401f06fb8525ebdc122e3dd56d90f6.jpg',1,'2018-07-13 17:00:06','2018-07-13 17:00:06',NULL),(76,'icone.png','pictures/CnSPdGiR9up5nH8TPZRRYX85tgEZPHCflxis8DAZ.png','pictures/26401f06fb8525ebdc122e3dd56d90f6.jpg',1,'2018-07-13 17:01:19','2018-07-13 17:01:19',NULL),(77,'3f07d95f8eb14c5b62edb102d117b1df','pictures/6e8d041d5bb45807203c1ac972090c74c1987921.jpg','pictures/3f07d95f8eb14c5b62edb102d117b1df.jpg',1,'2018-07-13 17:55:24','2018-07-13 17:55:24',NULL),(78,'0fd39209d8f08e5c39731ea9a233cb14','pictures/7ca1c3f2f55d0157a9fbb37e1ee26990bf91257d.jpg','pictures/0fd39209d8f08e5c39731ea9a233cb14.jpg',1,'2018-07-13 18:02:33','2018-07-13 18:02:33',NULL),(79,'327bba5240d98a38c2ea72b15c242f1b','pictures/efc65a26e88d9642352c791cfb3ac567cf5d01c8.jpg','pictures/327bba5240d98a38c2ea72b15c242f1b.jpg',1,'2018-07-16 17:11:59','2018-07-16 17:11:59',NULL),(80,'99fc610e6d882da3263d532db4f505ca','pictures/4f0ea7d1758c93335fcd6849be7065da1504d719.jpg','pictures/99fc610e6d882da3263d532db4f505ca.jpg',1,'2018-07-16 17:12:00','2018-07-16 17:12:00',NULL),(81,'bf804a040683caeba618ffdbaf8ac945','pictures/5a718421bb85daa4acd217b347db12f26036354d.jpg','pictures/bf804a040683caeba618ffdbaf8ac945.jpg',1,'2018-07-16 22:48:58','2018-07-16 22:48:58',NULL),(82,'comodities_bancoabc 16.07.2018.jpg','pictures/qe2rZDshQSpjPvBfi9oH9LqvducuGW1yzAi0UBXe.jpeg','pictures/772b59ca67386e3678b21e42e15809e4.jpg',1,'2018-07-16 23:02:35','2018-07-16 23:02:35',NULL),(84,'na rota do boi 17.07.2018.jpg','pictures/RReBe2p8oNvurwQz7SUkGtYPwdx5FyWBCYN6u4gL.jpeg','pictures/7261f9f7dac119e9bc14528377239a21.jpg',1,'2018-07-17 15:08:25','2018-07-17 15:08:25',NULL),(85,'diarreia em bezerros 17.07.2018.png','pictures/LEWMw3NV6w3UGhAt9zkBzRXWKNScsmIvQsCpx2tJ.png','pictures/0f0e419b45cad3cf2476318826dbb711.jpg',1,'2018-07-17 19:07:55','2018-07-17 19:07:55',NULL),(86,'92f39b649415d51c2b9d13dfadf691a1','pictures/fc5cbe73ffc36708701a71d58905fb744f1ab53b.jpg','pictures/92f39b649415d51c2b9d13dfadf691a1.jpg',1,'2018-07-18 11:03:21','2018-07-18 11:03:21',NULL),(87,'3c2db660000029c68af411d616b253a8','pictures/ce8f37f255cba425e448354d52e61902c7d8903f.jpg','pictures/3c2db660000029c68af411d616b253a8.jpg',1,'2018-07-18 11:05:28','2018-07-18 11:05:28',NULL),(88,'0115c830906d4d59d2761565b9983efd','pictures/4d4e91b8f61a88efcb51ebf444ba0347ee39754b.jpg','pictures/0115c830906d4d59d2761565b9983efd.jpg',1,'2018-07-18 11:08:14','2018-07-18 11:08:14',NULL),(89,'b1b4a68346302385fc7af87c094c034e','pictures/edfec293ca7021d35d9846ff63c4483c2199a866.jpg','pictures/b1b4a68346302385fc7af87c094c034e.jpg',1,'2018-07-18 11:10:17','2018-07-18 11:10:17',NULL),(90,'553f0fab7d77ba403a539b334bf70b0e','pictures/1fc6129cb427aca4d8c0aead1d5db11d724c9072.jpg','pictures/553f0fab7d77ba403a539b334bf70b0e.jpg',1,'2018-07-18 11:12:56','2018-07-18 11:12:56',NULL),(91,'6e5795bf637cb9799aeb2caf2199deda','pictures/fca66a3893242ee387a5b92a44b9f1cc45fe872c.jpg','pictures/6e5795bf637cb9799aeb2caf2199deda.jpg',1,'2018-07-18 11:15:05','2018-07-18 11:15:05',NULL),(92,'18c209d52be26c609ed219cbc182feb8','pictures/d89a48bbfd56acf28a494e9ae48fad12ee6f8ab7.jpg','pictures/18c209d52be26c609ed219cbc182feb8.jpg',1,'2018-07-18 11:16:35','2018-07-18 11:16:35',NULL),(93,'93d911b5892755808250d7bd1ec98e3d','pictures/f1f783294f09598394d682ae9d0b5823a294f45e.jpg','pictures/93d911b5892755808250d7bd1ec98e3d.jpg',1,'2018-07-18 11:27:24','2018-07-18 11:27:24',NULL),(94,'7f85b031d5e92df033279c5fdcdacd16','pictures/87f8b6ce955f29bc4a1638385da612c8bb7395c4.jpg','pictures/7f85b031d5e92df033279c5fdcdacd16.jpg',1,'2018-07-18 11:29:52','2018-07-18 11:29:52',NULL),(95,'a4bfcea811585e8098279ae48509d8c8','pictures/1f77600f7a29ace5a79bf23fec686cbc4246b563.jpg','pictures/a4bfcea811585e8098279ae48509d8c8.jpg',1,'2018-07-18 15:11:10','2018-07-18 15:11:10',NULL),(96,'0c6d4a647f75b2dcd1e6f0cf8fab172e','pictures/f2827c40ef6f937255d48e88614e8debccc4c0cf.jpg','pictures/0c6d4a647f75b2dcd1e6f0cf8fab172e.jpg',1,'2018-07-19 15:53:09','2018-07-19 15:53:09',NULL),(97,'efa5aee503916a91f89bd50d71107683','pictures/80e71bf3de0789a2df8fe1fffbf413b571c2c146.jpg','pictures/efa5aee503916a91f89bd50d71107683.jpg',1,'2018-07-19 18:03:04','2018-07-19 18:03:04',NULL),(98,'b678685235a98836ec29ba56d275eab1','pictures/f47c80b321fc9efdc23675a2c7e8aafd5985c7b0.jpg','pictures/b678685235a98836ec29ba56d275eab1.jpg',1,'2018-07-19 22:07:32','2018-07-19 22:07:32',NULL),(99,'db02593cde1ab1073d459ba1b84f7ec3','pictures/42627a9e40dc569d8d21d6f7f209affeb947b87a.jpg','pictures/db02593cde1ab1073d459ba1b84f7ec3.jpg',1,'2018-07-19 22:08:24','2018-07-19 22:08:24',NULL),(100,'2abe67b82fc927ae5fbf92ecec700501','pictures/aa3b725cffa7e7c5bb81f7a71a60730048a22339.jpg','pictures/2abe67b82fc927ae5fbf92ecec700501.jpg',1,'2018-07-20 22:25:39','2018-07-20 22:25:39',NULL),(101,'a25364e09866f20733c5bbf7a6b7ee6c','pictures/e3bf9ee92b4cca8106f802e778db4d549c6e2a7c.jpg','pictures/a25364e09866f20733c5bbf7a6b7ee6c.jpg',1,'2018-07-20 22:27:10','2018-07-20 22:27:10',NULL),(102,'918faf795bfceeee62b065249852b713','pictures/b8e36a96a7909fcd17225bc2d263d3826804c064.jpg','pictures/918faf795bfceeee62b065249852b713.jpg',1,'2018-07-20 22:27:39','2018-07-20 22:27:39',NULL),(103,'4d8879607ec9737658dcb4e424aba44f','pictures/03498f928d7ce6d1963561c3e36e0f006aff4e21.jpg','pictures/4d8879607ec9737658dcb4e424aba44f.jpg',1,'2018-07-20 22:28:22','2018-07-20 22:28:22',NULL),(104,'22b7c727fd15d03c425a3a5972ec8b93','pictures/f91c2620bafc5cb6e26258aab215bf938088f920.jpg','pictures/22b7c727fd15d03c425a3a5972ec8b93.jpg',1,'2018-07-20 22:30:12','2018-07-20 22:30:12',NULL),(105,'040afe0e03eaa30eb0c7db0a0d98bbe7','pictures/2b1c606c03bedddff194f935e3d776d5e421360b.jpg','pictures/040afe0e03eaa30eb0c7db0a0d98bbe7.jpg',1,'2018-07-20 22:30:36','2018-07-20 22:30:36',NULL),(106,'81f4c04be94b232e0b8dba1af4af63b7','pictures/845711cab048b0ab2694487ab7539b3840a0c3aa.jpg','pictures/81f4c04be94b232e0b8dba1af4af63b7.jpg',1,'2018-07-20 22:30:59','2018-07-20 22:30:59',NULL),(107,'60416d402190bbe358f726bb78679fe2','pictures/4f8601463799e4eede1fec5c3b0a8bad3c2b336f.jpg','pictures/60416d402190bbe358f726bb78679fe2.jpg',1,'2018-07-20 22:31:19','2018-07-20 22:31:19',NULL),(108,'8ea01d077c6b29bf5c4fb2249b2cfa92','pictures/13ce39b7a017b13f0959cfd1c193111c1304900a.jpg','pictures/8ea01d077c6b29bf5c4fb2249b2cfa92.jpg',1,'2018-07-20 22:32:32','2018-07-20 22:32:32',NULL),(109,'8269182b9cb481f489150487f3d6adbf','pictures/a56d08fc573df717daf0562007d47507833ebe33.jpg','pictures/8269182b9cb481f489150487f3d6adbf.jpg',1,'2018-07-20 22:34:06','2018-07-20 22:34:06',NULL),(110,'77d63d054cc8b1a98a59e93bebe04ce5','pictures/b4bcec4329ebf7766e3d9f97d06ee995981f1447.jpg','pictures/77d63d054cc8b1a98a59e93bebe04ce5.jpg',1,'2018-07-20 22:34:32','2018-07-20 22:34:32',NULL),(111,'06f2f542b9d1ea885c45005ec52c87f9','pictures/e0f506152a7ef8f10d8c9d1c0feb61212e86734a.jpg','pictures/06f2f542b9d1ea885c45005ec52c87f9.jpg',1,'2018-07-20 22:35:37','2018-07-20 22:35:37',NULL),(112,'bbba978c711a05255c88fc87ff966862','pictures/821c9abc5b5fdcd27faddbb5b566c157224b516a.jpg','pictures/bbba978c711a05255c88fc87ff966862.jpg',1,'2018-07-20 22:36:05','2018-07-20 22:36:05',NULL),(113,'9b166f8800589d3ac9bb8f087359013d','pictures/644c02bc1c258987489aa280310d6d9843b58053.jpg','pictures/9b166f8800589d3ac9bb8f087359013d.jpg',1,'2018-07-20 22:37:10','2018-07-20 22:37:10',NULL),(114,'912a1b2d061c0bfde0b27ba0009ed4a7','pictures/0dc5063b45fc55d0e08477a7f7c0ec4d4dc08019.jpg','pictures/912a1b2d061c0bfde0b27ba0009ed4a7.jpg',1,'2018-07-20 22:37:35','2018-07-20 22:37:35',NULL),(115,'6f8067bfeae390ee125945c023e5e6fb','pictures/50952f04147742fe933de123fc143b24b9365fd0.jpg','pictures/6f8067bfeae390ee125945c023e5e6fb.jpg',1,'2018-07-20 22:51:24','2018-07-20 22:51:24',NULL),(116,'08541b90e427c5846b09eaec67fb52a0','pictures/25257983afcacde96cab8388b40e63cf9e0e6617.jpg','pictures/08541b90e427c5846b09eaec67fb52a0.jpg',1,'2018-07-20 22:51:24','2018-07-20 22:51:24',NULL),(120,'af0f1f37a18ab96c873de715af67fd39','pictures/759061a08ea2f8cac47eea471d8a83b1f7b9a42e.jpg','pictures/af0f1f37a18ab96c873de715af67fd39.jpg',1,'2018-07-26 03:29:13','2018-07-26 03:29:13',NULL),(121,'5ab7ee94ed5aab16e8716118d9688bdd','pictures/8d5545c1f0038a18dae9afed9a97aa76132e55be.jpg','pictures/5ab7ee94ed5aab16e8716118d9688bdd.jpg',1,'2018-07-26 03:29:13','2018-07-26 03:29:13',NULL),(122,'979e99e2e9f14f0b40b6fa05ae92ab98','pictures/f4923a8776a91ae30f463505a232bfc23cf17d9d.jpg','pictures/979e99e2e9f14f0b40b6fa05ae92ab98.jpg',1,'2018-07-26 13:25:29','2018-07-26 13:25:29',NULL),(123,'e3aaaefd4fe53a4650f439933ef61822','pictures/296c3365a7ed325be3e77804943fab3f348ee426.jpg','pictures/e3aaaefd4fe53a4650f439933ef61822.jpg',1,'2018-07-26 13:25:29','2018-07-26 13:25:29',NULL),(124,'6af20048e52496f6d354961b5b3f01b8','pictures/d600d27e38b80a551607d40f2265449c715e667b.jpg','pictures/6af20048e52496f6d354961b5b3f01b8.jpg',1,'2018-08-01 12:14:25','2018-08-01 12:14:25',NULL),(125,'884e372d3b6b4c1ba1a41cf3716012c1','pictures/7e1ee24d02c72e9ffe065ea3a89768d4b78933d5.jpg','pictures/884e372d3b6b4c1ba1a41cf3716012c1.jpg',1,'2018-08-05 16:11:00','2018-08-05 16:11:00',NULL),(126,'951d0194c79bc01ff653c6cd46664ed2','pictures/b3caec4f15435189610ec248babd8ef96a9188b4.jpg','pictures/951d0194c79bc01ff653c6cd46664ed2.jpg',1,'2018-08-05 16:12:20','2018-08-05 16:12:20',NULL),(127,'dd36c4f0438bdfb35003de676a35f338','pictures/353ad50b7fb174301deb42459df720424030aeb4.jpg','pictures/dd36c4f0438bdfb35003de676a35f338.jpg',1,'2018-08-13 23:47:45','2018-08-13 23:47:45',NULL),(128,'43d47b8cc634a73ef77b2412f81941e7','pictures/a5443fea893d6ec5624920b35c975270a064c3e5.jpg','pictures/43d47b8cc634a73ef77b2412f81941e7.jpg',1,'2018-08-14 22:52:03','2018-08-14 22:52:03',NULL),(129,'7c02432b838db9ed1c56593fcfd03d17','pictures/b215d2ca7778cd04592672dcab6826ca32efc8f9.jpg','pictures/7c02432b838db9ed1c56593fcfd03d17.jpg',1,'2018-08-14 22:52:03','2018-08-14 22:52:03',NULL),(130,'4a4bc2c9de8d0b9d64672d018bcd3592','pictures/55d38680736e6a80096ee8edcb871bbdd5a03379.jpg','pictures/4a4bc2c9de8d0b9d64672d018bcd3592.jpg',1,'2018-08-14 22:52:03','2018-08-14 22:52:03',NULL),(131,'29a34cdf7bb08a74187780e095ac4ca5','pictures/f1986d760a25d6cf253a1379f7a6cadfeaac7796.jpg','pictures/29a34cdf7bb08a74187780e095ac4ca5.jpg',1,'2018-08-14 22:57:07','2018-08-14 22:57:07',NULL),(132,'5faac3263970237d76b2dc666f9aa25a','pictures/ecd70aab7c66cf59bac0fb858d9f0db422e29d30.jpg','pictures/5faac3263970237d76b2dc666f9aa25a.jpg',1,'2018-08-14 22:57:07','2018-08-14 22:57:07',NULL),(133,'9a89a8022c8999e8100485599f7a842e','pictures/174a72fb341b85ec75deda47cffdc4e74dff9671.jpg','pictures/9a89a8022c8999e8100485599f7a842e.jpg',1,'2018-08-14 22:57:07','2018-08-14 22:57:07',NULL),(134,'ffc10f97a118597210c3e0ea02be13bb','pictures/728c4b8ddc87edd2fb45da777524dc336006ae0f.jpg','pictures/ffc10f97a118597210c3e0ea02be13bb.jpg',1,'2018-08-14 22:57:07','2018-08-14 22:57:07',NULL),(135,'306b5afc23019a43397a9fc21e5e151d','pictures/b06fde7e20eaed79cb467272dd02d1c46c15c35d.jpg','pictures/306b5afc23019a43397a9fc21e5e151d.jpg',1,'2018-08-14 22:57:07','2018-08-14 22:57:07',NULL),(136,'ebb789f0ed9d7f7ea8bfecaa485e52aa','pictures/fdd9007916e7793fc84428731631b0efaa12da71.jpg','pictures/ebb789f0ed9d7f7ea8bfecaa485e52aa.jpg',1,'2018-08-16 22:23:28','2018-08-16 22:23:28',NULL),(137,'a1c737da8a6eddbd852871cd9551f32f','pictures/9d29c3d8b310c1d25aae8fcc27b76cf15dec60f8.jpg','pictures/a1c737da8a6eddbd852871cd9551f32f.jpg',1,'2018-08-18 13:30:30','2018-08-18 13:30:30',NULL),(138,'367851dbbb6a4e7425ac3c2ddee4ef95','pictures/e1b9eeb3db91bafd56e4abf86b859642dede1606.jpg','pictures/367851dbbb6a4e7425ac3c2ddee4ef95.jpg',1,'2018-08-28 00:34:26','2018-08-28 00:34:26',NULL),(139,'97B46926-DDE4-467C-AA51-5088BEBEBE1C.jpeg','pictures/y50kDI4uhwx4bjimK9DIopTotSWd4KTEeUvVZG7j.jpeg','pictures/2bcfa960dea4c17a5ce8f99447f1625c.jpg',1,'2018-09-04 14:36:43','2018-09-04 14:36:43',NULL),(140,'3b9fadf16a4e649b2c6044c68346600c','pictures/f593442567a2c2c881a3abb4db026dcf4ea460b2.jpg','pictures/3b9fadf16a4e649b2c6044c68346600c.jpg',1,'2018-09-04 21:35:28','2018-09-04 21:35:28',NULL),(141,'83b07b6963953c6404516b77de9fbea9','pictures/063428ea5b6d8cf6eaf87f87ba867545bf541e36.jpg','pictures/83b07b6963953c6404516b77de9fbea9.jpg',1,'2018-09-10 15:49:04','2018-09-10 15:49:04',NULL),(142,'5e41429d751130530b99e7eb71e0b5cb','pictures/810a8d6f5ade34deb666d992462c63a182be3296.jpg','pictures/5e41429d751130530b99e7eb71e0b5cb.jpg',1,'2018-09-14 02:44:23','2018-09-14 02:44:23',NULL),(143,'5b448319fb4865b26fe1da6b39f3040b','pictures/415404b725c169c8c52ffd9eaf43e053616599b8.jpg','pictures/5b448319fb4865b26fe1da6b39f3040b.jpg',1,'2018-09-14 02:44:23','2018-09-14 02:44:23',NULL),(144,'48e91f05013a3d4ced7e66de3afac8e8','pictures/4203686a14a08b9ab8ba705e7d22ce93df845435.jpg','pictures/48e91f05013a3d4ced7e66de3afac8e8.jpg',1,'2018-09-14 02:44:23','2018-09-14 02:44:23',NULL),(145,'969bd878bfdbc700a117f700e19c0886','pictures/d3c98e10181811e8056f78febb8da61562a17482.jpg','pictures/969bd878bfdbc700a117f700e19c0886.jpg',1,'2018-10-09 12:11:00','2018-10-09 12:11:00',NULL),(146,'cc38f97ee3fe6c46930fbe4ee67166ca','pictures/7a29b2cfb59ffb1ebd3b31bed84e2ee5b51d61ce.jpg','pictures/cc38f97ee3fe6c46930fbe4ee67166ca.jpg',1,'2018-10-09 12:11:05','2018-10-09 12:11:05',NULL),(147,'6f4a91178e117f5da86c4154832e9a4a','pictures/0bde778fc5d39520a3fd0314373cb1e39e995088.jpg','pictures/6f4a91178e117f5da86c4154832e9a4a.jpg',1,'2018-10-29 23:29:15','2018-10-29 23:29:15',NULL),(148,'09.11.18 agri.png','pictures/MQaV0ojLkZIRhSskUsSRwYabTILRj0h2vzWX0iDf.png','pictures/099a074878e04f8be67de3799477d3cb.jpg',1,'2018-11-09 13:57:35','2018-11-09 13:57:35',NULL),(149,'09.11.18 pec.jpg','pictures/RSLlfGd55sKjIZZv7Cy9pjtNebA2kHDstuDHwdHP.jpeg','pictures/7228fd3c1ed0cf9b2484208cf6476150.jpg',1,'2018-11-09 14:06:45','2018-11-09 14:06:45',NULL),(150,'09.11.18 politica.jpg','pictures/OanoQOl6FOFoUgyFdtFxkeoCSQMrkw9z7IeqlgAa.jpeg','pictures/fdf65d0714e27376670bcd720b22cfba.jpg',1,'2018-11-09 14:12:19','2018-11-09 14:12:19',NULL),(151,'logo fazenda Jaó.png','pictures/1RwhLvlTXzeDOXL9RXReXAD8m3wtrXusWcDzn025.png','pictures/da751fa1e8db43d9e9c085398421b239.jpg',1,'2018-11-09 14:15:46','2018-11-09 14:15:46',NULL),(152,'logo fazenda Jaó.png','pictures/YDDpRui5WaMGmV27VhUscFJ1BFPUeWsal9rkA9cj.png','pictures/da751fa1e8db43d9e9c085398421b239.jpg',1,'2018-11-09 14:48:13','2018-11-09 14:48:13',NULL),(153,'logo fazenda Jaó.png','pictures/pV8Ds8osYald2kpaozfis5oWhFueYoeaI1uiHALG.png','pictures/da751fa1e8db43d9e9c085398421b239.jpg',1,'2018-11-09 14:48:27','2018-11-09 14:48:27',NULL),(154,'logo fazenda Jaó.png','pictures/Qsp83znxLySVHIORHbvouXOd4uz0Fo2rjopWiVMo.png','pictures/da751fa1e8db43d9e9c085398421b239.jpg',1,'2018-11-09 14:51:11','2018-11-09 14:51:11',NULL),(155,'logo fazenda Jaó.png','pictures/WHBvJyOrjWlzoV3vlwWN7FGqV5xIxuEDs5F12Lpd.png','pictures/da751fa1e8db43d9e9c085398421b239.jpg',1,'2018-11-09 14:51:25','2018-11-09 14:51:25',NULL),(156,'D3E33D2A-D5F7-4427-BE04-9A344077B5BD.jpeg','pictures/qkwsoxaKIyOO0FQRMcCGUgyfRP1NnObdXzdxZf45.jpeg','pictures/4522c63780eacf68a0aff161d4bacf04.jpg',1,'2019-01-02 22:07:43','2019-01-02 22:07:43',NULL),(157,'D3E33D2A-D5F7-4427-BE04-9A344077B5BD.jpeg','pictures/T5IPAi9QpXfj9dgmgKwPWoL3anxzg1jkSIynKabC.jpeg','pictures/4522c63780eacf68a0aff161d4bacf04.jpg',1,'2019-01-02 22:07:48','2019-01-02 22:07:48',NULL),(158,'download.jpeg','pictures/AIzQeWXPeBED2iPOU1hRXDJcr4kHB9XxKLhiWc8e.jpeg','pictures/26776727aed5c4985f12ad499e2c96f6.jpg',1,'2019-01-02 22:22:18','2019-01-02 22:22:18',NULL),(160,'news37221-big.jpg','pictures/PZyvZVOaP7Z6dAoAumMMy5IQWOfdxg8uSzeD5k4i.jpeg','pictures/d650cce786cd3d860eab7101d183fd02.jpg',1,'2019-01-16 10:21:23','2019-01-16 10:21:23',NULL),(161,'download.png','pictures/BJpVCi0FKhorVBM3dsGtgtbw2sx6X9jxBEHQxOdU.png','pictures/64776820f174e0e53f64d6753ba68024.jpg',1,'2019-01-16 10:21:35','2019-01-16 10:21:35',NULL),(162,'46734871_2199556123618206_6471631570284314624_n.jpg','pictures/xJ1twvMZmIJKXuxSWhzxnpuFu5lxHVgpQZpxlyx4.jpeg','pictures/0ea485dc27084c8d22430db7a43af402.jpg',1,'2019-01-16 10:21:54','2019-01-16 10:21:54',NULL),(163,'46734871_2199556123618206_6471631570284314624_n.jpg','pictures/UklSaUOW8GXBteGmTLa6iLOso5N8aa9EJ4PXfVZA.jpeg','pictures/0ea485dc27084c8d22430db7a43af402.jpg',1,'2019-01-16 10:21:55','2019-01-16 10:21:55',NULL),(164,'drooper.jpg','pictures/XpaY32j6xpPZ352Euah4zo4D1Dse7qOYfUZDomzV.jpeg','pictures/7708310ac7f903282239f7b4f994f942.jpg',1,'2019-01-16 10:21:55','2019-01-16 10:21:55',NULL),(167,'lC7CUWj6MGSMESW2veYvA5voeXVDNjRt7qifmedc.mp4','movies/mV9qSP9CUyRfZ6pSY8DH1KLBob8HV3cSMrjQYl7l.mp4',NULL,3,'2019-01-16 12:33:03','2019-01-16 12:33:03',NULL),(168,'403dd3ca16ed5ff1040bbc416304b4fe','pictures/d21f91ec99ef329dcd0681a89f9cf1af8644938d.jpg','pictures/403dd3ca16ed5ff1040bbc416304b4fe.jpg',1,'2019-03-27 20:26:29','2019-03-27 20:26:29',NULL),(169,'b8ef8dc556fcad948eeecb1d367a1bed','pictures/0e4f41e05909113a49e063f0f85c777105fea058.jpg','pictures/b8ef8dc556fcad948eeecb1d367a1bed.jpg',1,'2019-03-27 20:26:29','2019-03-27 20:26:29',NULL),(170,'f05bf1cdcac42b693ea936cd1df2fb28','pictures/63c15527c1db89d3008ab31932e63b31d83a7f38.jpg','pictures/f05bf1cdcac42b693ea936cd1df2fb28.jpg',1,'2019-03-27 20:26:30','2019-03-27 20:26:30',NULL),(171,'a4e7dfd232cdd1efcece6872f71fcf2d','pictures/85d6820964189fe1bf513b849ccb8f7397c04708.jpg','pictures/a4e7dfd232cdd1efcece6872f71fcf2d.jpg',1,'2019-03-27 20:26:30','2019-03-27 20:26:30',NULL),(172,'0.jpeg','pictures/QiNFCGmcPTkr89BEMbELf68Qh4xbpP16A7bv8sdZ.jpeg','pictures/1fc5d694b03b44cd683f13283943a641.jpg',1,'2019-06-28 17:25:40','2019-06-28 17:25:40',NULL),(173,'019226ed-3b1f-40c1-a7c9-1a76d74582c8.jpeg','pictures/Cunp9iSPpfpZzUoATDBiHFH7SxFSMOT500SvD4q4.jpeg','pictures/fff9dcf8ff66c8d1e5b84a52ce702589.jpg',1,'2019-07-08 14:15:38','2019-07-08 14:15:38',NULL),(174,'f49df649-cd6f-4471-80bc-cf02b072cb31.jpeg','pictures/dsOTl6R5sD2LhhSY0JoGgk5sCfUWloy1c1h6gult.jpeg','pictures/d0b7164e7d7291feda40a05d90863320.jpg',1,'2019-07-08 14:17:06','2019-07-08 14:17:06',NULL),(175,'Screenshot_2019-07-07-22-23-47-940.jpeg','pictures/2GRce8WwPhFyArvOJaTrxxHPS5MgTHESELxERzyn.jpeg','pictures/8675ad19ab457f7637b0bfc5b6ecbb1b.jpg',1,'2019-07-08 17:23:08','2019-07-08 17:23:08',NULL),(176,'Screenshot_2019-07-07-16-15-26-139.jpeg','pictures/qOMy9r6skEb752vfz9uGqpXcZn73UP7VeQ3lPt77.jpeg','pictures/d52900d0f39c9ad7ab40619b0ffc66da.jpg',1,'2019-07-08 17:25:12','2019-07-08 17:25:12',NULL),(177,'VID_26960415_033843_478.mp4','movies/IOePTSD1MGX3Fz4MWFSfjhU8074taEBv46eXrU7f.mp4',NULL,3,'2019-07-08 17:25:12','2019-07-08 17:25:12',NULL),(178,'IMG-20190704-WA0021.jpeg','pictures/IfQkRws7fFUl5XJ0QIaPWKMeFjvrV4gJ5ZHbqbtx.jpeg','pictures/68d6d81891fcc677c615afee7a88fac8.jpg',1,'2019-07-08 18:31:38','2019-07-08 18:31:38',NULL),(179,'IMG-20190702-WA0013.jpg','pictures/BQ41x5SC2atRU9xRR0qJ35946nIrH4Kf9lFxCWkl.jpeg','pictures/6c6f556bf3bdb5b12dcf867cf71d8e85.jpg',1,'2019-07-08 19:09:51','2019-07-08 19:09:51',NULL),(180,'IMG-20190704-WA0021.jpeg','pictures/GjBrSI07BOgXJUqnBSHNu3YXw1wvwDFi7aGJfDW4.jpeg','pictures/68d6d81891fcc677c615afee7a88fac8.jpg',1,'2019-07-08 19:18:29','2019-07-08 19:18:29',NULL),(181,'Screenshot_2019-07-07-22-23-47-940.jpeg','pictures/QF2OvpKs1tZUPFV1pVJOFW57GofzDT57g6g92SXM.jpeg','pictures/8675ad19ab457f7637b0bfc5b6ecbb1b.jpg',1,'2019-07-08 19:20:29','2019-07-08 19:20:29',NULL),(182,'Screenshot_2019-07-07-16-15-26-139.jpeg','pictures/4FDptV8Y05MTz60tlFKSJQm2Rdvzm7Q4V1XAeYRM.jpeg','pictures/d52900d0f39c9ad7ab40619b0ffc66da.jpg',1,'2019-07-08 19:38:31','2019-07-08 19:38:31',NULL),(183,'Screenshot_2019-07-07-16-15-26-139.jpeg','pictures/cGUA5q3sWTE6uom9aKFkZdaRheEzuc7jVCjGSygX.jpeg','pictures/d52900d0f39c9ad7ab40619b0ffc66da.jpg',1,'2019-07-08 19:46:10','2019-07-08 19:46:10',NULL),(184,'B4CB3A4C-562C-46EA-83C8-F15CF8CE5018.jpeg','pictures/hqau58WO3oRUBwUoB7xo5t4sTIKVmzFiHR7btVCU.jpeg','pictures/8e7ebf7b905bace0ef27ae0a9c1721ab.jpg',1,'2019-07-26 19:26:17','2019-07-26 19:26:17',NULL),(185,'IMG_20190728_171704.jpg','pictures/zwuz1xf8zlzVnPV3oWz5Ao8pcc1WmMUvuUAuCDaU.jpeg','pictures/cd647fc54d2015c3c6e0786491c2f3a6.jpg',1,'2019-07-29 13:29:21','2019-07-29 13:29:21',NULL),(186,'F7B002F7-EB32-4DD6-9813-024B30D12313.jpeg','pictures/SogzLcaXh73EFSyPELpef7zWrCDfz4I83VbsR3Lj.jpeg','pictures/35bc1ec711f2235d312ca1cc0f2ccd2f.jpg',1,'2019-07-29 13:39:45','2019-07-29 13:39:45',NULL),(187,'AA161DF6-B52B-4080-A7BF-D5D8433DC68D.jpeg','pictures/XN465B136zTcLKKTVYw84Gl7TcNahnB7rMB150gb.jpeg','pictures/35bc1ec711f2235d312ca1cc0f2ccd2f.jpg',1,'2019-07-29 13:54:05','2019-07-29 13:54:05',NULL),(188,'Screenshot_2019-08-16-13-31-33-474.jpeg','pictures/n0fdt4RfVY3YX9KWOj7ypkMXEEq7dd8Ls0p8uC3K.jpeg','pictures/a3127823df15a8bae7bb77a3a0d40cd4.jpg',1,'2019-08-22 12:26:23','2019-08-22 12:26:23',NULL),(189,'IMG-20190827-WA0033.jpg','pictures/jxv0VL1fSmdLgflXhbnSJ5uI7K1tCQg9IxQc119a.jpeg','pictures/00fd29ad0645bde99733aaa2804a43db.jpg',1,'2019-08-29 12:05:40','2019-08-29 12:05:40',NULL),(190,'76F912A2-37CD-4D53-8877-C8FA14A13245.jpeg','pictures/bjzS4OAe0A7xnsWV1QhYPuQbNTXN8Qy0fRJVHJAb.jpeg','pictures/506509218cef777bf62e411f32718bd3.jpg',1,'2019-09-04 20:19:55','2019-09-04 20:19:55',NULL),(191,'Screenshot_2019-09-15-22-30-21-663.jpeg','pictures/lUjjud57qWqkh7yy6KYlZky3RJuSgCy41gZEkFUo.jpeg','pictures/eca8c76c1153033aa81c86dd2ba325e5.jpg',1,'2019-09-17 19:54:52','2019-09-17 19:54:52',NULL),(192,'Screenshot_2019-09-15-22-30-21-663.jpeg','pictures/ICzgaSrkVxV52ruVbFHakhkX2mSJ6vpfe6hXBLqv.jpeg','pictures/eca8c76c1153033aa81c86dd2ba325e5.jpg',1,'2019-09-17 19:54:56','2019-09-17 19:54:56',NULL),(193,'CC4A6057-7120-423F-B5A8-9203D498C068.jpeg','pictures/RfHxQejqusMMPJ1MmdHHlV7O22NLI4RzmOeWNs3g.jpeg','pictures/35bc1ec711f2235d312ca1cc0f2ccd2f.jpg',1,'2019-10-05 21:29:53','2019-10-05 21:29:53',NULL);
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media_types`
--

DROP TABLE IF EXISTS `media_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `files` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media_types`
--

LOCK TABLES `media_types` WRITE;
/*!40000 ALTER TABLE `media_types` DISABLE KEYS */;
INSERT INTO `media_types` VALUES (1,'image','pictures','png,jpg','2018-04-06 17:48:43','2018-04-06 17:48:43',NULL),(2,'application','pdfs','pdf','2018-04-06 17:48:43','2018-04-06 17:48:43',NULL),(3,'video','movies','mp4','2018-04-06 17:48:43','2018-04-06 17:48:43',NULL);
/*!40000 ALTER TABLE `media_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menu` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `route` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `show` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `menu_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menus_menu_id_foreign` (`menu_id`),
  CONSTRAINT `menus_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (1,'Configurações','fa-cogs','config.index','1',NULL,'2018-02-09 21:34:08','2018-02-09 21:34:08',NULL),(2,'Usuários','fa-user','user.index','1',1,'2018-02-09 21:34:33','2018-02-09 21:34:33',NULL),(3,'Usuários - Create','fa-plus','user.create','0',2,'2018-02-09 21:34:33','2018-02-09 21:34:33',NULL),(4,'Usuários - Edit','fa-pencil','user.edit','0',2,'2018-02-09 21:34:33','2018-02-09 21:34:33',NULL),(5,'Usuários - Destroy','fa-trash','user.destroy','0',2,'2018-02-09 21:34:34','2018-02-09 21:34:34',NULL),(6,'Usuários - Store','fa-save','user.store','0',2,'2018-02-09 21:34:34','2018-02-09 21:34:34',NULL),(7,'Usuários - Update','fa-save','user.update','0',2,'2018-02-09 21:34:36','2018-02-09 21:34:36',NULL),(8,'Role','fa-key','role.index','1',1,'2018-02-09 21:34:52','2018-02-09 21:34:52',NULL),(9,'Role - Create','fa-plus','role.create','0',8,'2018-02-09 21:34:52','2018-02-09 21:34:52',NULL),(10,'Role - Edit','fa-pencil','role.edit','0',8,'2018-02-09 21:34:52','2018-02-09 21:34:52',NULL),(11,'Role - Destroy','fa-trash','role.destroy','0',8,'2018-02-09 21:34:53','2018-02-09 21:34:53',NULL),(12,'Role - Store','fa-save','role.store','0',8,'2018-02-09 21:34:53','2018-02-09 21:34:53',NULL),(13,'Role - Update','fa-save','role.update','0',8,'2018-02-09 21:34:53','2018-02-09 21:34:53',NULL),(14,'Menu','fa-th-large','menu.index','1',1,'2018-02-09 21:35:26','2018-02-09 21:35:26',NULL),(15,'Menu - Create','fa-plus','menu.create','0',14,'2018-02-09 21:35:26','2018-02-09 21:35:26',NULL),(16,'Menu - Edit','fa-pencil','menu.edit','0',14,'2018-02-09 21:35:26','2018-02-09 21:35:26',NULL),(17,'Menu - Destroy','fa-trash','menu.destroy','0',14,'2018-02-09 21:35:26','2018-02-09 21:35:26',NULL),(18,'Menu - Store','fa-save','menu.store','0',14,'2018-02-09 21:35:26','2018-02-09 21:35:26',NULL),(19,'Menu - Update','fa-save','menu.update','0',14,'2018-02-09 21:35:27','2018-02-09 21:35:27',NULL),(20,'Gestão','fa-tachometer','gestao.index','1',NULL,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(21,'Notícias','fa-plus-circle','news.index','1',20,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(22,'Visualizar','fa-eye','news.index','1',21,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(23,'Visualizar - Create','fa-plus','news.create','0',22,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(24,'Visualizar - Edit','fa-pencil','news.edit','0',22,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(25,'Visualizar - Destroy','fa-trash','news.destroy','0',22,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(26,'Visualizar - Store','fa-save','news.store','0',22,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(27,'Visualizar - Update','fa-save','news.update','0',22,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(28,'Categorias','fa-align-center','news-category.index','1',21,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(29,'Categorias - Create','fa-plus','news-category.create','0',28,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(30,'Categorias - Edit','fa-pencil','news-category.edit','0',28,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(31,'Categorias - Destroy','fa-trash','news-category.destroy','0',28,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(32,'Categorias - Store','fa-save','news-category.store','0',28,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(33,'Categorias - Update','fa-save','news-category.update','0',28,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(34,'Produtos','fa-product-hunt','products.index','1',20,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(35,'Visualizar','fa-eye','products.index','1',34,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(36,'Visualizar - Show','fa-eye','products.show','0',35,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(37,'Visualizar - Create','fa-plus','products.create','0',35,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(38,'Visualizar - Edit','fa-pencil','products.edit','0',35,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(39,'Visualizar - Destroy','fa-trash','products.destroy','0',35,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(40,'Visualizar - Store','fa-save','products.store','0',35,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(41,'Visualizar - Update','fa-save','products.update','0',35,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(42,'Categorias','fa-align-center','product-category.index','1',34,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(43,'Categorias - Show','fa-eye','product-category.show','0',42,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(44,'Categorias - Create','fa-plus','product-category.create','0',42,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(45,'Categorias - Edit','fa-pencil','product-category.edit','0',42,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(46,'Categorias - Destroy','fa-trash','product-category.destroy','0',42,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(47,'Categorias - Store','fa-save','product-category.store','0',42,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(48,'Categorias - Update','fa-save','product-category.update','0',42,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(49,'Sub Categorias','fa-align-justify','product-sub-category.index','1',34,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(50,'Sub Categorias - Show','fa-eye','product-sub-category.show','0',49,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(51,'Sub Categorias - Create','fa-plus','product-sub-category.create','0',49,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(52,'Sub Categorias - Edit','fa-pencil','product-sub-category.edit','0',49,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(53,'Sub Categorias - Destroy','fa-trash','product-sub-category.destroy','0',49,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(54,'Sub Categorias - Store','fa-save','product-sub-category.store','0',49,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(55,'Sub Categorias - Update','fa-save','product-sub-category.update','0',49,'2018-04-18 23:22:38','2018-04-19 00:37:11',NULL),(56,'Aplicativo','fa-android','aplicativo.index','1',NULL,'2018-04-25 00:51:36','2018-04-25 00:51:36',NULL),(57,'Usuários','fa-user','users-app.index','1',56,'2018-04-25 00:53:36','2018-04-25 00:53:36',NULL),(58,'Usuários - Show','fa-eye','users-app.show','0',57,'2018-04-25 00:53:36','2018-04-25 00:53:36',NULL),(59,'Usuários - Create','fa-plus','users-app.create','0',57,'2018-04-25 00:53:36','2018-04-25 00:53:36',NULL),(60,'Usuários - Edit','fa-pencil','users-app.edit','0',57,'2018-04-25 00:53:36','2018-04-25 00:53:36',NULL),(61,'Usuários - Destroy','fa-trash','users-app.destroy','0',57,'2018-04-25 00:53:36','2018-04-25 00:53:36',NULL),(62,'Usuários - Store','fa-save','users-app.store','0',57,'2018-04-25 00:53:36','2018-04-25 00:53:36',NULL),(63,'Usuários - Update','fa-save','users-app.update','0',57,'2018-04-25 00:53:37','2018-04-25 00:53:37',NULL),(64,'Banner','fa-image','banner.index','1',20,'2018-06-18 16:48:52','2018-06-18 16:48:52',NULL),(65,'Banner - Show','fa-eye','banner.show','0',64,'2018-06-18 16:48:52','2018-06-18 16:48:52',NULL),(66,'Banner - Create','fa-plus','banner.create','0',64,'2018-06-18 16:48:52','2018-06-18 16:48:52',NULL),(67,'Banner - Edit','fa-pencil','banner.edit','0',64,'2018-06-18 16:48:52','2018-06-18 16:48:52',NULL),(68,'Banner - Destroy','fa-trash','banner.destroy','0',64,'2018-06-18 16:48:52','2018-06-18 16:48:52',NULL),(69,'Banner - Store','fa-save','banner.store','0',64,'2018-06-18 16:48:52','2018-06-18 16:48:52',NULL),(70,'Banner - Update','fa-save','banner.update','0',64,'2018-06-18 16:48:52','2018-06-18 16:48:52',NULL),(71,'Lojas','fa-shopping-cart','store.index','1',20,'2018-06-18 20:24:07','2018-06-18 20:24:07',NULL),(72,'Lojas - Show','fa-eye','store.show','0',71,'2018-06-18 20:24:07','2018-06-18 20:24:07',NULL),(73,'Lojas - Create','fa-plus','store.create','0',71,'2018-06-18 20:24:07','2018-06-18 20:24:07',NULL),(74,'Lojas - Edit','fa-pencil','store.edit','0',71,'2018-06-18 20:24:07','2018-06-18 20:24:07',NULL),(75,'Lojas - Destroy','fa-trash','store.destroy','0',71,'2018-06-18 20:24:07','2018-06-18 20:24:07',NULL),(76,'Lojas - Store','fa-save','store.store','0',71,'2018-06-18 20:24:07','2018-06-18 20:24:07',NULL),(77,'Lojas - Update','fa-save','store.update','0',71,'2018-06-18 20:24:07','2018-06-18 20:24:07',NULL),(78,'Interesses','fa-bell','interests.index','1',20,'2018-06-18 20:24:07','2018-06-18 20:24:07',NULL),(79,'Planos','fa-tags','plan.index','1',20,'2019-07-08 14:08:01','2019-07-08 14:08:01',NULL),(80,'Planos - Show','fa-eye','plan.show','0',79,'2019-07-08 14:08:01','2019-07-08 14:08:01',NULL),(81,'Planos - Create','fa-plus','plan.create','0',79,'2019-07-08 14:08:01','2019-07-08 14:08:01',NULL),(82,'Planos - Edit','fa-pencil','plan.edit','0',79,'2019-07-08 14:08:01','2019-07-08 14:08:01',NULL),(83,'Planos - Destroy','fa-trash','plan.destroy','0',79,'2019-07-08 14:08:01','2019-07-08 14:08:01',NULL),(84,'Planos - Store','fa-save','plan.store','0',79,'2019-07-08 14:08:01','2019-07-08 14:08:01',NULL),(85,'Planos - Update','fa-save','plan.update','0',79,'2019-07-08 14:08:01','2019-07-08 14:08:01',NULL),(86,'Checkout','fa-credit-card','checkout.index','1',NULL,'2019-07-08 14:08:22','2019-07-08 14:08:22',NULL),(87,'Checkout - Show','fa-eye','checkout.show','0',86,'2019-07-08 14:08:22','2019-07-08 14:08:22',NULL),(88,'Checkout - Create','fa-plus','checkout.create','0',86,'2019-07-08 14:08:22','2019-07-08 14:08:22',NULL),(89,'Checkout - Edit','fa-pencil','checkout.edit','0',86,'2019-07-08 14:08:22','2019-07-08 14:08:22',NULL),(90,'Checkout - Destroy','fa-trash','checkout.destroy','0',86,'2019-07-08 14:08:22','2019-07-08 14:08:22',NULL),(91,'Checkout - Store','fa-save','checkout.store','0',86,'2019-07-08 14:08:22','2019-07-08 14:08:22',NULL),(92,'Checkout - Update','fa-save','checkout.update','0',86,'2019-07-08 14:08:22','2019-07-08 14:08:22',NULL);
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=136 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (107,'2014_10_12_000000_create_users_table',1),(108,'2014_10_12_100000_create_password_resets_table',1),(109,'2017_12_21_040145_create_menus_table',1),(110,'2017_12_21_041758_create_roles_table',1),(111,'2017_12_21_041848_create_permissions_table',1),(112,'2017_12_21_042834_create_media_types_table',1),(113,'2017_12_21_042843_create_media_table',1),(114,'2017_12_21_043616_create_people_table',1),(115,'2017_12_21_045937_create_countries_table',1),(116,'2017_12_21_050020_create_states_table',1),(117,'2017_12_21_050030_create_cities_table',1),(118,'2017_12_21_050407_create_addresses_table',1),(119,'2017_12_21_051739_create_phones_table',1),(120,'2018_04_17_230707_create_news_categories_table',1),(121,'2018_04_17_231217_create_news_table',1),(122,'2018_04_18_200132_create_product_categories_table',1),(123,'2018_04_18_200143_create_product_sub_categories_table',1),(124,'2018_04_24_161405_create_user_apps_table',1),(125,'2018_04_25_223833_create_products_table',1),(126,'2018_04_25_224430_create_product_has_media_table',1),(127,'2018_04_30_231032_create_product_has_interests_table',1),(128,'2018_06_18_105454_create_banners_table',1),(129,'2018_06_18_141805_create_stores_table',1),(130,'2019_01_16_163401_create_notifications_table',2),(131,'2019_01_16_164148_create_fcms_table',2),(132,'2019_01_16_164213_create_notification_has_fcms_table',2),(133,'2019_06_28_154947_create_plans_table',2),(134,'2019_07_01_113956_create_checkouts_table',2),(135,'2019_07_05_155216_add-column-date_end-to-products',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `news_category_id` int(10) unsigned NOT NULL,
  `media_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `news_media_id_foreign` (`media_id`),
  KEY `news_news_category_id_foreign` (`news_category_id`),
  CONSTRAINT `news_media_id_foreign` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`),
  CONSTRAINT `news_news_category_id_foreign` FOREIGN KEY (`news_category_id`) REFERENCES `news_categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (1,'2018-04-17','AgRural eleva previsão de safra de milho com melhores condições em MT e GO','Revisão positiva pode ser considerada um alento para uma safrinha cujas perspectivas de colheita vinham sendo reduzidas há meses','São Paulo – A AgRural elevou levemente nesta sexta-feira sua estimativa para a segunda safra de milho 2017/18 no centro-sul do Brasil, a 53,6 milhões de toneladas, de 53,3 milhões anteriormente, citando uma produção melhor em Mato Grosso e Goiás.\r\nA revisão positiva pode ser considerada um alento para uma safrinha cujas perspectivas de colheita vinham sendo reduzidas há meses, após um atraso no plantio, estiagem em abril e maio e mesmo uma área plantada menor.\r\nEm boletim, a consultoria disse que o aumento na previsão “deve-se a incrementos na produção estimada para Mato Grosso e Goiás, que mais do que compensam os novos cortes feitos nos demais Estados do centro-sul”. Mato Grosso, por sinal, é o maior produtor brasileiro de milho.\r\nA AgRural não faz cálculos a nível nacional, mas destacou que, considerando-se a estimativa da Conab para o Norte/Nordeste, o Brasil deve colher neste ano 57,1 milhões de toneladas de milho na safrinha.\r\nNa comparação anual, contudo, o volume tende a ser menor. No centro-sul, a expectativa da AgRural é de uma colheita 15,6 por cento abaixo do recorde observado em 2016/17, já que tanto área quanto rendimentos devem ser inferiores.\r\n“O menor rendimento das lavouras foi causado pela falta de chuvas regulares a partir de abril em algumas áreas, localizadas principalmente em Mato Grosso do Sul, São Paulo e Paraná”, afirmou a consultoria.\r\nConforme a AgRural, até o momento 16 por cento da área cultivada com milho “safrinha” já foi colhida no centro-sul, ante 24 por cento há um ano e 20 por cento na média de cinco temporadas.\r\n“O atraso no plantio e a umidade ainda elevada do milho em parte das áreas prontas explicam o atraso da colheita. Além disso, muitos produtores estão sem pressa de colher, já que o mercado está lento”, explicou a consultoria.',1,82,'2018-04-18 15:48:26','2018-07-25 19:31:38','2018-07-25 19:31:38'),(2,'2018-07-17','Na Rota do Boi','Escoamento lento limita altas no mercado do boi gordo','Se dependesse da oferta de boiadas, o cenário seria de alta em todas as praças. Entretanto, a demanda está aquém do esperado. Este é o limitador das valorizações.\r\n\r\nNa última segunda-feira (16/7), com muitos frigoríficos aguardando uma melhor posição do mercado, especialmente de como começarão as vendas de carne nesta semana, o cenário foi de estabilidade na maioria das praças pecuárias.\r\n\r\nNo mercado atacadista de carne bovina sem osso, já são quatro semanas seguidas de desvalorização. Em trinta dias, a queda acumulada foi de 2,8%, puxada principalmente pelos cortes do traseiro, que tiveram retração média de 3%.\r\n\r\nEnquanto isso, a arroba do boi gordo, em São Paulo, apresentou alta de 2% no período, o que levou ao estreitamento da margem de comercialização dos frigoríficos que fazem a desossa. Atualmente esta margem gira em torno de 23,6%, são cinco pontos percentuais a menos em um mês.',1,84,'2018-04-18 17:24:44','2018-07-25 19:38:40','2018-07-25 19:38:40'),(3,'2018-04-17','Tempo ensolarado no Sul favorece atividades de campo','Região segue sem chuvas, assim como o Estado de São Paulo e parte do interior de Minas Gerais','O produtor da região Sul pode aproveitar os próximos dias para fazer suas atividades de campo. Isso porque a tendência vista nos últimos dias, de tempo seco e ensolarado, seguirá, segundo a previsão da Somar Meteorologia.\r\n\r\nO cenário também ocorrerá em outras áreas do país. O Estado de São Paulo, parte do interior de Minas Gerais e o interior da Bahia terão tempo aberto nos próximos dias. Já na faixa norte do país, as chuvas seguirão volumosas.',1,9,'2018-04-18 17:26:10','2018-07-17 15:02:19','2018-07-17 15:02:19'),(4,'2018-06-27','edit título','edit subtítulo','edit descrição',1,31,'2018-06-28 13:16:56','2018-06-28 13:29:22','2018-06-28 13:29:22'),(5,'2018-07-17','Causas e Tratamento da diarreia em Bezerros','Entenda como ocorre e saiba como previnir a diarréia em bezerros.','A diarreia é considerada uma das principais causas de perdas de bezerros na bovinocultura brasileira, de alta morbidade e mortalidade considerável em bezerros neonatos, as diarreias merecem a atenção especial do produtor e técnicos, uma vez que pequenos detalhes podem culminar em grandes prejuízos econômicos e sanitários ao rebanho.\r\n\r\nNas primeiras semanas de vida, os bezerros necessitam de maiores cuidados e proteção, devido a sua elevada susceptibilidade às infecções, por este fato a prevenção e o diagnóstico precoce são de extrema importância. Em todo o sistema de criação, a preocupação com a higiene e medidas profiláticas são de crucial importância. A limpeza diária juntamente, adequação de instalações, incidência de sol e ventilação são pontos que não podem ser negligenciados. O colostro é outro fator fundamental e determinante para a manutenção da sanidade dos bezerros, evitando doenças e permitindo o melhor desenvolvimento dos animais; este é um alimento insubstituível, pois é rico em imunoglobulinas que são fundamentais para a saúde do recém-nascido.\r\n\r\nAs diarreias neonatais têm causas multifatoriais, como: ambiental, nutricional, infeccioso e verminótico.\r\nPrincipais causas das diarreias em bezerros.\r\n\r\nAs bactérias estão entre os principais agentes causadores de diarreias em bezerros recém-nascidos. A Escherichia coli causa a colibacilose; a Salmonella spp, conhecida por “paratifo” dos bezerros e a enterotoxemia hemorrágica, causada por Clostridium perfringens tipo C (diarreia hemorrágica). Essas diarreias causam grandes perdas econômicas em rebanhos devido ao baixo desenvolvimento dos animais.\r\n \r\nDentre as diarreias virais, o vírus mais comumente encontrado é o rotavírus, com casos relatados e diagnosticados em vários estados do Brasil.\r\nAs diarreias causadas por protozoários, como a coccidiose ou eimeriose (Eimeria sp), é conhecida como “curso negro”, geralmente afeta bezerros até os seis meses de idade. As fezes apresentam-se líquidas e escuras, com muco, sangue e com odor fétido.\r\n \r\nCondições em que a higiene seja prejudicada, como alta densidade de animais, convívio de animais de diferentes idades, umidade excessiva, presença de contaminantes são fatores que favorecem a presença e proliferação de microrganismos patogênicos e devem ser levados em consideração para o controle desta doença.\r\n \r\nPara tratar o bezerro com diarreia em primeiro lugar deve-se ficar atento à reposição de líquidos e eletrólitos, visando à correção da desidratação, da acidose e do desequilíbrio eletrolítico. A terapia antimicrobiana deve ser feita com medicamentos de amplo espectro de ação, como por exemplo, a Doxiciclina associada ao Benzetimide (Corta Curso, na dosagem de 1mL para cada 10 Kg de peso vivo, por via intramuscular, em dose única). Biobac (probiótico, que ajuda a repor a microbiota intestinal, protege o trato gastrointestinal, promove melhor aproveitamento dos nutrientes contidos no alimento).\r\n \r\nPara o controle e tratamento da diarreia causada por coccídeos (Eimeria sp), estudos demonstram a eficácia do Toltrazuril (Isocox Pig doser) na dosagem de 15 mg/Kg de peso vivo, via oral, em dose única. Ainda as sulfas e seus derivados são produtos que assim como entre outros medicamentos tem eficácia no controle desta doença.\r\n \r\nNos casos de vírus, como o rotavírus e coronavírus, o tratamento mais indicado é o sintomático com a administração de soros (Fortemil), antitérmicos (Finador) e probióticos (Biobac). Destaca-se ainda que em casos de surtos, a necessidade de vacinação dos animais. Em casos de infecções secundárias, recomenda-se a utilização de terapia antimicrobiana com sulfametoxazol associado ao trimetoprim (Trissulfin).\r\n \r\nEm situações onde a diarreia é causada pela presença de vermes, recomenda-se fazer o exame de OPG (ovos por grama de fezes) para avaliar o grau de infecção. O tratamento deve ser feito com anti-helmíntico de amplo espectro de ação, como o Ricobendazole 10 ou Ricobendazole Oral, à base de sulfóxido de albendazole, vermífugo este que combate ovos, larvas e vermes adultos.\r\n \r\nDestaca-se que a orientação de um médico veterinário é sempre muito importante e proveitosa para a manutenção da sanidade do rebanho. A higiene, manejo e sanidade da propriedade são fatores importantes para a prevenção das diarreias neonatais, evitando assim os sérios prejuízos ao produtor.',1,85,'2018-07-17 19:07:55','2018-07-25 19:17:44','2018-07-25 19:17:44'),(6,'2018-11-09','Política','Deputada Tereza Cristina será ministra da Agricultura de Bolsonaro','A deputada federal Tereza Cristina (DEM-MS) será a ministra da Agricultura do governo Jair Bolsonaro. Tereza Cristina é atualmente presidente da Frente Parlamentar Agropecuária (FPA).\r\nO anúncio foi feito pelo primeiro vice- presidente da FPA, deputado Alceu Moreira (MDB-RS), após reunião de colegas da frente com o presidente eleito. Momentos depois, Bolsonaro reiterou a indicação no Twitter.\r\nMoreira confirmou que as pastas de Agricultura e do Meio Ambiente serão separadas. Mas afirmou ter ouvido de Bolsonaro que os ritualistas vão “homologar” o nome do titular dessa pasta.\r\n“Ele não disse para nós que nós indicaríamos o nome do novo ministro do Meio Ambiente. Mas disse que nós homologaríamos esse nome. Foram as palavras dele.”\r\nFonte: Valor Econômico.',1,150,'2018-07-25 19:29:18','2018-11-09 14:12:19',NULL),(7,'2018-11-09','Contratação de crédito rural até outubro soma R$ 64 bilhões','Nos primeiros quatro meses de financiamento da produção, valor supera em 26% o que foi registrado em igual período do ano anterior','A contratação do crédito rural pelo Plano Agrícola e Pecuário (PAP) por médios e grandes produtores rurais atingiu R$ 64 bilhões, de julho a outubro deste ano, 26% a mais do que na safra anterior em igual período. Para o secretário de Política Agrícola, Wilson Vaz de Araújo, a liberação de recursos continua forte, tanto de custeio quanto de investimento. \"Nossa expectativa, é que, daqui para frente, a demanda por custeio se reduza, e aumente a procura por recursos para investimento\", afirma.\r\nOs dados da contratação constam do Relatório de Financiamento Agropecuário de liberação de recursos da safra 2018/2019, divulgado pela Secretaria de Política Agrícola do Ministério da Agricultura, Pecuária e Abastecimento (Mapa), nesta quinta-feira (8).\r\nHouve aumento de aplicação em todas as finalidades do crédito. No custeio, o aumento foi de 20%, correspondendo a um total aplicado de R$ 37,4 bilhões. A industrialização cresceu 49%, totalizando R$ 3 bilhões, e a comercialização teve alta de 30% superior à safra passada, somando R$ 11,3 bilhões. Os investimentos somam aplicações, no período, de R$ 12,5 bilhões, 38% acima de igual período da safra anterior.\r\nQuanto aos programas específicos de investimento, o Sistema do Banco Central (SICOR) contabilizou mais de R$ 4 bilhões aplicados, nesses primeiros quatro meses da safra, pelo Moderfrota ((Programa de Modernização da Frota de Tratores Agrícolas e Implementos Associados e Colheitadeiras), correspondendo a aumento de 62% em relação à safra passada.\r\nModeragro (Programa de Modernização da Agricultura e Conservação de Recursos Naturais), ABC (Programa para Redução da Emissão de Gases de Efeito Estufa na Agricultura), Inovagro e PCA também são destaques, contabilizando aumentos de 287%, 141%, 113% e 103%, respectivamente.\r\nDe acordo com o estudo, o número de contratos aumentou em 7%, contabilizando 258 mil operações. A atividade agrícola representou 74% do valor aplicado, ou R$ 47,4 bilhões. Já a pecuária contou com R$ 16,7 bilhões contratados.\r\nQuanto às fontes de recursos, a poupança rural controlada se destaca com participação de 36%, no total das contratações do crédito rural, o que representam R$ 22,8 bilhões. Quanto aos recursos com taxas de juros livres, as Letras de Crédito do Agronegócio (LCA’s) registraram montante aplicado de R$ 7,8 bilhões, sendo que destes, R$ 5,7 bilhões a taxas de até 8,5% ao ano.\r\nDe acordo com o secretário, a demanda por recursos deve ser suficiente para a futura safra. \"Estamos atentos e monitorando a necessidade de fazer ajustes, deslocando recursos para os programas de investimento que apresentarem maior procura por parte dos produtores rurais\".\r\nMais informações à Imprensa\r\nCoordenação Geral de Imprensa\r\nimprensa@agricultura.gov.br',1,148,'2018-07-25 19:38:30','2018-11-09 13:57:35',NULL),(8,'2018-11-09','Na Rota do Boi','Vacina contra aftosa fica mais cara mas poder de compra de pecuarista melhora, diz Imea Publicado em 09/11/2018 11:42','O preço pago por uma dose de vacina contra a febre aftosa aumentou em um ano, no Estado. De acordo com o Instituto Mato-grossense de Economia Agropecuária (Imea), o valor da dose chegou R$ 1,35, em setembro, 10,5% a mais que no mesmo mês do ano passado.\r\nO instituto, no entanto, ressaltou que, ao comparar a relação de troca entre os preços do leite e o custo da imunização, houve melhora de 5,1% no poder de compra do pecuarista. “Desta forma, o produtor que imunizar o seu rebanho, além de assegurar a sanidade dos animais, pode estar se prevenindo de cair em prejuízos futuros”.\r\nhttps//:www.noticiasagricolas.com.br',1,149,'2018-07-25 19:56:47','2018-11-09 14:08:24',NULL);
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news_categories`
--

DROP TABLE IF EXISTS `news_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news_categories`
--

LOCK TABLES `news_categories` WRITE;
/*!40000 ALTER TABLE `news_categories` DISABLE KEYS */;
INSERT INTO `news_categories` VALUES (1,'Nova Categoria 2','2018-04-18 06:01:36','2018-04-18 06:06:30',NULL),(2,'Categoria para testes','2018-06-28 13:16:42','2018-06-28 13:29:32','2018-06-28 13:29:32'),(3,'Teste edit','2018-06-28 13:29:43','2018-06-28 13:29:57','2018-06-28 13:29:57');
/*!40000 ALTER TABLE `news_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification_has_fcms`
--

DROP TABLE IF EXISTS `notification_has_fcms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notification_has_fcms` (
  `fcm_id` int(10) unsigned NOT NULL,
  `notification_id` int(10) unsigned NOT NULL,
  `visualized` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  KEY `notification_has_fcms_fcm_id_foreign` (`fcm_id`),
  KEY `notification_has_fcms_notification_id_foreign` (`notification_id`),
  CONSTRAINT `notification_has_fcms_fcm_id_foreign` FOREIGN KEY (`fcm_id`) REFERENCES `fcms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `notification_has_fcms_notification_id_foreign` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification_has_fcms`
--

LOCK TABLES `notification_has_fcms` WRITE;
/*!40000 ALTER TABLE `notification_has_fcms` DISABLE KEYS */;
/*!40000 ALTER TABLE `notification_has_fcms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category` enum('A','N') COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type_link` enum('E','I') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'E',
  `date` date NOT NULL,
  `hour` time NOT NULL,
  `success` int(11) NOT NULL DEFAULT '0',
  `failure` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_phone_index` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
INSERT INTO `password_resets` VALUES ('34992156456','0DB28C','2018-07-03 10:30:42','2018-07-03 10:30:42'),('17991035102','3C2F5C','2018-07-03 15:05:07','2018-07-03 15:05:07'),('34991252731','7529AB','2018-07-17 13:24:53','2018-07-17 13:24:53'),('11981199316','778920','2018-11-02 16:36:53','2018-11-02 16:36:53'),('34999176227','098E77','2018-11-04 22:48:21','2018-11-04 22:48:21'),('986722992','FA77B6','2019-01-11 01:18:29','2019-01-11 01:18:29'),('31980180888','27079C','2019-01-11 20:48:13','2019-01-11 20:48:13'),('94991469718','F646CA','2019-04-19 23:38:45','2019-04-19 23:38:45'),('61981816724','4A3192','2019-07-21 13:34:10','2019-07-21 13:34:10'),('44991537691','1AAA0C','2019-08-25 19:23:44','2019-08-25 19:23:44'),('34999693787','00E3FA','2019-11-28 22:27:59','2019-11-28 22:27:59'),('5555555555','1E9151','2020-02-29 08:37:08','2020-02-29 08:37:08');
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `people`
--

DROP TABLE IF EXISTS `people`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `people` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` date DEFAULT NULL,
  `type_person` enum('J','F') COLLATE utf8_unicode_ci NOT NULL,
  `cpf_cnpj` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ie` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `media_id` int(10) unsigned DEFAULT NULL,
  `role_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `people_role_id_foreign` (`role_id`),
  KEY `people_user_id_foreign` (`user_id`),
  KEY `people_media_id_foreign` (`media_id`),
  CONSTRAINT `people_media_id_foreign` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`),
  CONSTRAINT `people_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  CONSTRAINT `people_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=150 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `people`
--

LOCK TABLES `people` WRITE;
/*!40000 ALTER TABLE `people` DISABLE KEYS */;
INSERT INTO `people` VALUES (1,'Zordon','1991-04-04','J',NULL,NULL,1,NULL,1,'2018-02-09 21:36:57','2018-02-09 21:36:57',NULL),(2,'Usuário','2018-06-28','J',NULL,NULL,2,NULL,2,'2018-06-28 13:07:54','2018-06-28 13:07:54',NULL),(3,'Lucas Emmanuel','1991-04-04','F','365.396.718-06','123456',3,NULL,NULL,'2018-06-28 13:14:19','2019-07-08 14:16:08',NULL),(4,'Loja laranjão',NULL,'J',NULL,NULL,4,35,NULL,'2018-06-28 13:50:13','2018-07-12 19:59:40',NULL),(6,'Paulo Cesar',NULL,'J',NULL,NULL,6,NULL,NULL,'2018-06-28 14:19:32','2018-06-28 14:19:32',NULL),(7,'pedro henrique',NULL,'J',NULL,NULL,7,NULL,NULL,'2018-06-28 17:37:32','2018-06-28 17:37:32',NULL),(8,'Natália',NULL,'J',NULL,NULL,8,NULL,NULL,'2018-06-28 21:53:03','2018-06-28 21:53:03',NULL),(9,'Aderlandio oliveira',NULL,'J',NULL,NULL,9,NULL,NULL,'2018-06-29 11:55:54','2018-06-29 11:55:54',NULL),(10,'Text',NULL,'J',NULL,NULL,10,NULL,NULL,'2018-06-29 12:55:19','2018-06-29 12:55:19',NULL),(11,'Uai APP',NULL,'J',NULL,NULL,11,NULL,3,'2018-06-29 18:13:51','2018-06-29 18:14:42',NULL),(12,'Joao',NULL,'F','42140096819',NULL,12,NULL,NULL,'2018-07-02 18:57:05','2018-07-12 01:35:52',NULL),(13,'Rodrigo Heitor de Mendonça',NULL,'J',NULL,NULL,13,NULL,NULL,'2018-07-02 19:56:25','2018-07-02 19:56:25',NULL),(14,'Simon Reis',NULL,'J',NULL,NULL,14,NULL,NULL,'2018-07-02 22:49:09','2018-07-02 22:49:09',NULL),(16,'Neto',NULL,'J',NULL,NULL,16,NULL,NULL,'2018-07-03 15:06:07','2018-07-03 15:06:07',NULL),(22,'Teste',NULL,'J',NULL,NULL,22,NULL,NULL,'2018-07-03 18:17:22','2018-07-03 18:17:22',NULL),(23,'tome',NULL,'J',NULL,NULL,23,NULL,NULL,'2018-07-03 21:41:51','2018-07-03 21:41:51',NULL),(24,'Sebastião Macedo Ribeiro Junior',NULL,'J',NULL,NULL,24,NULL,NULL,'2018-07-03 22:45:13','2018-07-03 22:45:13',NULL),(25,'silvia',NULL,'J',NULL,NULL,26,NULL,NULL,'2018-07-05 23:06:11','2018-07-05 23:06:11',NULL),(26,'douglas',NULL,'J',NULL,NULL,28,NULL,NULL,'2018-07-06 13:57:35','2018-07-06 13:57:35',NULL),(27,'Edson',NULL,'J',NULL,NULL,29,NULL,NULL,'2018-07-06 18:31:43','2018-07-06 18:31:43',NULL),(28,'Daniel rocha',NULL,'J',NULL,NULL,30,NULL,NULL,'2018-07-07 00:57:01','2018-07-07 00:57:01',NULL),(29,'vasco',NULL,'J',NULL,NULL,31,NULL,NULL,'2018-07-07 01:40:37','2018-07-07 01:40:37',NULL),(31,'louribal',NULL,'J',NULL,NULL,33,NULL,NULL,'2018-07-07 23:24:41','2018-07-07 23:24:41',NULL),(32,'Otavio',NULL,'J',NULL,NULL,34,NULL,NULL,'2018-07-08 01:24:00','2018-07-08 01:24:00',NULL),(33,'titim',NULL,'J',NULL,NULL,36,NULL,NULL,'2018-07-08 22:10:17','2018-07-08 22:10:17',NULL),(34,'Henrique Dutra',NULL,'J',NULL,NULL,38,NULL,NULL,'2018-07-08 22:32:23','2018-07-08 22:32:23',NULL),(35,'André Luiz de Freitas Carvalho',NULL,'J',NULL,NULL,39,NULL,NULL,'2018-07-09 18:52:30','2018-07-09 18:52:30',NULL),(36,'RONALDO MARTINS CARVALHO FILHO',NULL,'J',NULL,NULL,40,NULL,NULL,'2018-07-10 11:48:56','2018-07-10 11:48:56',NULL),(37,'Alex Pedro Barcelos Ferreira',NULL,'J',NULL,NULL,42,NULL,NULL,'2018-07-10 13:45:42','2018-07-10 13:45:42',NULL),(38,'Eduardo Petrochi Neto',NULL,'J',NULL,NULL,43,NULL,NULL,'2018-07-10 21:23:52','2018-07-10 21:23:52',NULL),(39,'Rian',NULL,'J',NULL,NULL,44,NULL,NULL,'2018-07-10 22:25:41','2018-07-10 22:25:41',NULL),(41,'Lucas',NULL,'J',NULL,NULL,46,NULL,NULL,'2018-07-13 16:45:14','2018-07-13 16:45:14',NULL),(42,'Loja UAI',NULL,'J',NULL,NULL,47,75,NULL,'2018-07-13 17:00:06','2018-07-13 17:00:06',NULL),(44,'Solange',NULL,'J',NULL,NULL,49,NULL,NULL,'2018-07-13 17:38:00','2018-07-13 17:38:00',NULL),(45,'Joel Batista',NULL,'J',NULL,NULL,50,NULL,NULL,'2018-07-15 01:07:53','2018-07-15 01:07:53',NULL),(46,'Roger Martins',NULL,'J',NULL,NULL,51,NULL,NULL,'2018-07-15 16:44:13','2018-07-15 16:44:13',NULL),(47,'fabiano jose de souza Fofão',NULL,'J',NULL,NULL,52,NULL,NULL,'2018-07-15 21:00:06','2018-07-15 21:00:06',NULL),(48,'Ricardo Melotti',NULL,'J',NULL,NULL,53,NULL,NULL,'2018-07-16 15:01:13','2018-07-16 15:01:13',NULL),(50,'Fabiano',NULL,'J',NULL,NULL,55,NULL,NULL,'2018-07-16 22:14:39','2018-07-16 22:14:39',NULL),(51,'Fabiano',NULL,'F',NULL,NULL,56,NULL,NULL,'2018-07-16 22:16:31','2018-07-22 22:52:06',NULL),(52,'Marlene',NULL,'J',NULL,NULL,57,NULL,NULL,'2018-07-17 13:52:56','2018-07-17 13:52:56',NULL),(53,'Olavo Caetano',NULL,'J',NULL,NULL,58,NULL,NULL,'2018-07-17 18:08:29','2018-07-17 18:08:29',NULL),(54,'Cleusa',NULL,'J',NULL,NULL,59,NULL,NULL,'2018-07-18 15:27:13','2018-07-18 15:27:13',NULL),(55,'Cleusa',NULL,'J',NULL,NULL,60,NULL,NULL,'2018-07-18 15:29:55','2018-07-18 15:29:55',NULL),(56,'Eduardo Castro',NULL,'J',NULL,NULL,61,NULL,NULL,'2018-07-18 17:27:04','2018-07-18 17:27:04',NULL),(57,'Natanael',NULL,'J',NULL,NULL,62,NULL,NULL,'2018-07-19 22:28:15','2018-07-19 22:28:15',NULL),(58,'Daniel Silveira de Brito',NULL,'J',NULL,NULL,63,NULL,NULL,'2018-07-19 22:38:56','2018-07-19 22:38:56',NULL),(59,'Edson Vidotto Vanzelli Júnior',NULL,'J',NULL,NULL,64,NULL,NULL,'2018-07-20 01:55:47','2018-07-20 01:55:47',NULL),(60,'Vidotto Júnior',NULL,'J',NULL,NULL,65,NULL,NULL,'2018-07-20 02:02:58','2018-07-20 02:02:58',NULL),(61,'Vantuir Junior Rodrigues',NULL,'J',NULL,NULL,66,NULL,NULL,'2018-07-20 13:20:29','2018-07-20 13:20:29',NULL),(62,'Augusto',NULL,'J',NULL,NULL,67,NULL,NULL,'2018-07-20 16:07:52','2018-07-20 16:07:52',NULL),(63,'Nathan',NULL,'J',NULL,NULL,68,NULL,NULL,'2018-07-22 21:31:13','2018-07-22 21:31:13',NULL),(64,'Thiago',NULL,'J',NULL,NULL,69,NULL,NULL,'2018-07-25 19:51:57','2018-07-25 19:51:57',NULL),(65,'Anselmo alves dos santos',NULL,'J',NULL,NULL,70,NULL,NULL,'2018-07-25 23:48:40','2018-07-25 23:48:40',NULL),(66,'Jonata.',NULL,'J',NULL,NULL,71,NULL,NULL,'2018-07-28 15:09:59','2018-07-28 15:09:59',NULL),(67,'Jonata silva',NULL,'J',NULL,NULL,73,NULL,NULL,'2018-07-28 15:10:52','2018-07-28 15:10:52',NULL),(68,'Emerson',NULL,'J',NULL,NULL,74,NULL,NULL,'2018-07-29 12:53:51','2018-07-29 12:53:51',NULL),(69,'JORGEJAO',NULL,'F','020.307.768-71','001166095.00-90',75,NULL,NULL,'2018-07-30 18:20:29','2018-07-30 18:32:19',NULL),(70,'Reinaldo Nunes  Neto',NULL,'J',NULL,NULL,76,NULL,NULL,'2018-08-01 11:36:12','2018-08-01 11:36:12',NULL),(71,'helio ismar lages',NULL,'J',NULL,NULL,77,NULL,NULL,'2018-08-07 00:59:05','2018-08-07 00:59:05',NULL),(72,'Eduardo',NULL,'J',NULL,NULL,78,NULL,NULL,'2018-08-20 21:46:15','2018-08-20 21:46:15',NULL),(73,'Edilson',NULL,'J',NULL,NULL,80,NULL,NULL,'2018-08-21 02:14:23','2018-08-21 02:14:23',NULL),(74,'edson',NULL,'J',NULL,NULL,81,NULL,NULL,'2018-08-21 08:08:16','2018-08-21 08:08:16',NULL),(75,'Mário Sérgio Perassoli',NULL,'J',NULL,NULL,82,NULL,NULL,'2018-08-21 09:58:46','2018-08-21 09:58:46',NULL),(76,'Caio Assunção',NULL,'J',NULL,NULL,83,NULL,NULL,'2018-08-21 12:36:49','2018-08-21 12:36:49',NULL),(77,'jhocelyto boschi coelho',NULL,'J',NULL,NULL,84,NULL,NULL,'2018-08-21 15:19:10','2018-08-21 15:19:10',NULL),(78,'elielson',NULL,'J',NULL,NULL,85,NULL,NULL,'2018-08-21 23:12:04','2018-08-21 23:12:04',NULL),(79,'Débora Fernanda Alves de Souza',NULL,'J',NULL,NULL,86,NULL,NULL,'2018-08-23 11:01:52','2018-08-23 11:01:52',NULL),(80,'Milton',NULL,'J',NULL,NULL,87,NULL,NULL,'2018-08-29 00:38:21','2018-08-29 00:38:21',NULL),(81,'Eduardo Ferreira',NULL,'J',NULL,NULL,88,NULL,NULL,'2018-09-02 23:37:11','2018-09-02 23:37:11',NULL),(82,'Luana',NULL,'J',NULL,NULL,90,NULL,NULL,'2018-09-05 16:32:09','2018-09-05 16:32:09',NULL),(83,'Luana',NULL,'J',NULL,NULL,92,NULL,NULL,'2018-09-05 16:33:51','2018-09-05 16:33:51',NULL),(84,'Sérgio Castanheira',NULL,'J',NULL,NULL,93,NULL,NULL,'2018-09-08 21:57:56','2018-09-08 21:57:56',NULL),(85,'Jhonnatan M',NULL,'J',NULL,NULL,94,NULL,NULL,'2018-09-11 12:51:15','2018-09-11 12:51:15',NULL),(86,'SÉRVIO AGUIAR MENEZES',NULL,'J',NULL,NULL,95,NULL,NULL,'2018-09-19 23:00:11','2018-09-19 23:00:11',NULL),(87,'Rafael M Vasconcelos',NULL,'J',NULL,NULL,96,NULL,NULL,'2018-09-20 00:12:40','2018-09-20 00:12:40',NULL),(88,'Tamara',NULL,'J',NULL,NULL,97,NULL,NULL,'2018-09-24 13:02:22','2018-09-24 13:02:22',NULL),(89,'Tamara',NULL,'J',NULL,NULL,99,NULL,NULL,'2018-09-24 13:02:39','2018-09-24 13:02:39',NULL),(90,'Gustavo Ilha',NULL,'J',NULL,NULL,100,NULL,NULL,'2018-10-02 21:40:40','2018-10-02 21:40:40',NULL),(91,'Anderson Cavasin',NULL,'J',NULL,NULL,101,NULL,NULL,'2018-10-16 02:07:47','2018-10-16 02:07:47',NULL),(92,'leandro silva Barbosa',NULL,'J',NULL,NULL,102,NULL,NULL,'2018-10-16 11:50:52','2018-10-16 11:50:52',NULL),(93,'bribor metais',NULL,'J',NULL,NULL,103,NULL,NULL,'2018-10-23 19:30:53','2018-10-23 19:30:53',NULL),(94,'Arthur',NULL,'J',NULL,NULL,104,NULL,NULL,'2018-10-27 21:52:54','2018-10-27 21:52:54',NULL),(95,'Gleiber',NULL,'J',NULL,NULL,106,NULL,NULL,'2018-10-31 13:22:38','2018-10-31 13:22:38',NULL),(96,'Vanderlei',NULL,'J',NULL,NULL,107,NULL,NULL,'2018-10-31 21:18:39','2018-10-31 21:18:39',NULL),(97,'Michel',NULL,'J',NULL,NULL,108,NULL,NULL,'2018-11-02 16:33:46','2018-11-02 16:33:46',NULL),(98,'Michel',NULL,'J',NULL,NULL,110,NULL,NULL,'2018-11-02 16:40:59','2018-11-02 16:40:59',NULL),(99,'Michel',NULL,'J',NULL,NULL,111,NULL,NULL,'2018-11-02 16:42:10','2018-11-02 16:42:10',NULL),(100,'Fernando Sousa',NULL,'J',NULL,NULL,112,NULL,NULL,'2018-11-05 12:02:35','2018-11-05 12:02:35',NULL),(101,'Pedro Gomed',NULL,'J',NULL,NULL,117,NULL,NULL,'2018-11-09 23:25:58','2018-11-09 23:25:58',NULL),(102,'Geziel',NULL,'J',NULL,NULL,118,NULL,NULL,'2018-11-22 00:37:22','2018-11-22 00:37:22',NULL),(103,'Geziel',NULL,'J',NULL,NULL,119,NULL,NULL,'2018-11-22 00:39:13','2018-11-22 00:39:13',NULL),(104,'Lilian moreira',NULL,'J',NULL,NULL,120,NULL,NULL,'2018-11-24 22:58:13','2018-11-24 22:58:13',NULL),(105,'José Geraldo',NULL,'J',NULL,NULL,121,NULL,NULL,'2018-12-05 21:13:09','2018-12-05 21:13:09',NULL),(106,'Rita',NULL,'J',NULL,NULL,123,NULL,NULL,'2018-12-10 12:16:28','2018-12-10 12:16:28',NULL),(107,'Marcos Vinícius Tosta',NULL,'J',NULL,NULL,125,NULL,NULL,'2018-12-17 00:18:38','2018-12-17 00:18:38',NULL),(108,'Luiz H Marino',NULL,'J',NULL,NULL,126,NULL,NULL,'2018-12-24 21:24:28','2018-12-24 21:24:28',NULL),(109,'Karen Martini',NULL,'J',NULL,NULL,127,NULL,NULL,'2019-01-06 15:00:25','2019-01-06 15:00:25',NULL),(110,'Adilson',NULL,'J',NULL,NULL,128,NULL,NULL,'2019-01-11 01:15:03','2019-01-11 01:15:03',NULL),(111,'Leticia Ramos',NULL,'J',NULL,NULL,129,NULL,NULL,'2019-01-11 20:47:18','2019-01-11 20:47:18',NULL),(112,'darcy Mendes Fasciani',NULL,'J',NULL,NULL,131,NULL,NULL,'2019-02-11 12:43:26','2019-02-11 12:43:26',NULL),(113,'erivaldo dos santos silva',NULL,'J',NULL,NULL,133,NULL,NULL,'2019-02-14 19:11:58','2019-02-14 19:11:58',NULL),(114,'ERIVALDO DOS SANTOS SILVA',NULL,'J',NULL,NULL,134,NULL,NULL,'2019-02-14 19:17:40','2019-02-14 19:17:40',NULL),(115,'Leandro Orsi',NULL,'J',NULL,NULL,135,NULL,NULL,'2019-02-16 00:21:40','2019-02-16 00:21:40',NULL),(116,'Marcelo',NULL,'J',NULL,NULL,136,NULL,NULL,'2019-02-18 15:58:56','2019-02-18 15:58:56',NULL),(117,'Marcelo',NULL,'J',NULL,NULL,138,NULL,NULL,'2019-02-18 15:59:07','2019-02-18 15:59:07',NULL),(120,'Hebert Martins Ferreira','2019-02-24','F',NULL,NULL,141,NULL,NULL,'2019-02-18 19:32:10','2019-07-29 13:41:58',NULL),(121,'Murilo de Castro Assis',NULL,'J',NULL,NULL,142,NULL,NULL,'2019-02-18 21:44:37','2019-02-18 21:44:37',NULL),(122,'Marcelo Diniz',NULL,'J',NULL,NULL,143,NULL,NULL,'2019-03-11 22:38:21','2019-03-11 22:38:21',NULL),(123,'Marcos Bruno',NULL,'J',NULL,NULL,144,NULL,NULL,'2019-03-27 20:00:22','2019-03-27 20:00:22',NULL),(124,'Marina Dolabella Caldeira',NULL,'J',NULL,NULL,145,NULL,NULL,'2019-04-02 13:57:49','2019-04-02 13:57:49',NULL),(125,'Marna Dolabella Caldeira',NULL,'J',NULL,NULL,146,NULL,NULL,'2019-04-02 14:00:17','2019-04-02 14:00:17',NULL),(126,'Marina  Dolabella Caldeira',NULL,'F','00418331634',NULL,147,NULL,NULL,'2019-04-02 14:02:04','2019-04-02 14:32:25',NULL),(127,'Lucas',NULL,'J',NULL,NULL,148,NULL,NULL,'2019-04-12 15:49:51','2019-04-12 15:49:51',NULL),(128,'Matheus',NULL,'J',NULL,NULL,149,NULL,NULL,'2019-04-12 21:13:27','2019-04-12 21:13:27',NULL),(129,'Carlos',NULL,'J',NULL,NULL,150,NULL,NULL,'2019-04-19 23:37:51','2019-04-19 23:37:51',NULL),(130,'Thiago Carrijo Benedetti',NULL,'J',NULL,NULL,151,NULL,NULL,'2019-04-22 18:51:12','2019-04-22 18:51:12',NULL),(131,'Diego Andrade',NULL,'J',NULL,NULL,152,NULL,NULL,'2019-05-15 18:38:43','2019-05-15 18:38:43',NULL),(132,'Antônio',NULL,'J',NULL,NULL,153,NULL,NULL,'2019-06-12 04:33:37','2019-06-12 04:33:37',NULL),(133,'Valdomiro  anjo furtado',NULL,'J',NULL,NULL,154,NULL,NULL,'2019-06-30 00:13:53','2019-06-30 00:13:53',NULL),(134,'Joel',NULL,'J',NULL,NULL,155,NULL,NULL,'2019-07-13 01:34:08','2019-07-13 01:34:08',NULL),(135,'Evane  Margareth',NULL,'J',NULL,NULL,156,NULL,NULL,'2019-07-19 21:28:53','2019-07-19 21:28:53',NULL),(136,'Gostosão da capital',NULL,'J',NULL,NULL,157,NULL,NULL,'2019-07-21 13:32:57','2019-07-21 13:32:57',NULL),(137,'Abraão Lemos dos santos',NULL,'J',NULL,NULL,158,NULL,NULL,'2019-08-15 12:54:38','2019-08-15 12:54:38',NULL),(138,'Willian Tedy',NULL,'J',NULL,NULL,159,NULL,NULL,'2019-08-25 19:14:46','2019-08-25 19:14:46',NULL),(139,'Willian. Tedy',NULL,'J',NULL,NULL,161,NULL,NULL,'2019-08-25 19:19:17','2019-08-25 19:19:17',NULL),(140,'João Victor Janczeski Brandão',NULL,'J',NULL,NULL,162,NULL,NULL,'2019-09-23 15:30:04','2019-09-23 15:30:04',NULL),(141,'Willians',NULL,'J',NULL,NULL,164,NULL,NULL,'2019-10-03 22:39:29','2019-10-03 22:39:29',NULL),(142,'Tarcísio',NULL,'J',NULL,NULL,165,NULL,NULL,'2019-11-24 19:16:33','2019-11-24 19:16:33',NULL),(143,'pipo silva',NULL,'J',NULL,NULL,166,NULL,NULL,'2020-01-23 15:15:38','2020-01-23 15:15:38',NULL),(144,'pipo',NULL,'J',NULL,NULL,168,NULL,NULL,'2020-01-23 15:21:32','2020-01-23 15:21:32',NULL),(145,'Sônia Almeida',NULL,'J',NULL,NULL,169,NULL,NULL,'2020-01-29 15:36:25','2020-01-29 15:36:25',NULL),(146,'Lerço  Batista',NULL,'J',NULL,NULL,170,NULL,NULL,'2020-02-03 13:58:30','2020-02-03 13:58:30',NULL),(147,'ligia moreira',NULL,'J',NULL,NULL,171,NULL,NULL,'2020-02-24 16:22:29','2020-02-24 16:22:29',NULL),(148,'Edson ozelim',NULL,'J',NULL,NULL,172,NULL,NULL,'2020-03-02 03:32:56','2020-03-02 03:32:56',NULL),(149,'Gustavo',NULL,'J',NULL,NULL,173,NULL,NULL,'2020-03-12 17:22:23','2020-03-12 17:22:23',NULL);
/*!40000 ALTER TABLE `people` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `role_id` int(10) unsigned NOT NULL,
  `menu_id` int(10) unsigned NOT NULL,
  KEY `permissions_menu_id_foreign` (`menu_id`),
  KEY `permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `permissions_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (2,20),(2,21),(2,22),(2,34),(2,35),(2,36),(2,64),(2,65),(2,71),(2,72),(3,20),(3,21),(3,22),(3,23),(3,24),(3,25),(3,26),(3,27),(3,28),(3,29),(3,30),(3,31),(3,32),(3,33),(3,34),(3,35),(3,36),(3,37),(3,38),(3,39),(3,40),(3,41),(3,42),(3,43),(3,44),(3,45),(3,46),(3,47),(3,48),(3,49),(3,50),(3,51),(3,52),(3,53),(3,54),(3,55),(3,64),(3,65),(3,66),(3,67),(3,68),(3,69),(3,70),(3,71),(3,72),(3,73),(3,74),(3,75),(3,76),(3,77),(3,78),(3,56),(3,57),(3,58),(3,59),(3,60),(3,61),(3,62),(3,63),(1,1),(1,2),(1,3),(1,4),(1,5),(1,6),(1,7),(1,8),(1,9),(1,10),(1,11),(1,12),(1,13),(1,14),(1,15),(1,16),(1,17),(1,18),(1,19),(1,20),(1,21),(1,22),(1,23),(1,24),(1,25),(1,26),(1,27),(1,28),(1,29),(1,30),(1,31),(1,32),(1,33),(1,34),(1,35),(1,36),(1,37),(1,38),(1,39),(1,40),(1,41),(1,42),(1,43),(1,44),(1,45),(1,46),(1,47),(1,48),(1,49),(1,50),(1,51),(1,52),(1,53),(1,54),(1,55),(1,64),(1,65),(1,66),(1,67),(1,68),(1,69),(1,70),(1,71),(1,72),(1,73),(1,74),(1,75),(1,76),(1,77),(1,78),(1,79),(1,80),(1,81),(1,82),(1,83),(1,84),(1,85),(1,56),(1,57),(1,58),(1,59),(1,60),(1,61),(1,62),(1,63),(1,86),(1,87),(1,88),(1,89),(1,90),(1,91),(1,92);
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phones`
--

DROP TABLE IF EXISTS `phones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phones` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `person_id` int(10) unsigned NOT NULL,
  `type` enum('fixo','celular','whatsapp') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `phones_person_id_foreign` (`person_id`),
  CONSTRAINT `phones_person_id_foreign` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phones`
--

LOCK TABLES `phones` WRITE;
/*!40000 ALTER TABLE `phones` DISABLE KEYS */;
/*!40000 ALTER TABLE `phones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plans`
--

DROP TABLE IF EXISTS `plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `plan` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `days` int(11) NOT NULL,
  `price` double(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plans`
--

LOCK TABLES `plans` WRITE;
/*!40000 ALTER TABLE `plans` DISABLE KEYS */;
INSERT INTO `plans` VALUES (1,'Plano Bronze',3,0.00,'2019-07-08 14:09:17','2019-07-08 14:09:17',NULL),(2,'Plano Prata',15,9.90,'2019-07-08 14:09:27','2019-07-08 14:09:27',NULL),(3,'Plano Ouro',30,19.90,'2019-07-08 14:09:36','2019-07-08 14:09:36',NULL);
/*!40000 ALTER TABLE `plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_categories`
--

DROP TABLE IF EXISTS `product_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `media_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_categories_media_id_foreign` (`media_id`),
  CONSTRAINT `product_categories_media_id_foreign` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_categories`
--

LOCK TABLES `product_categories` WRITE;
/*!40000 ALTER TABLE `product_categories` DISABLE KEYS */;
INSERT INTO `product_categories` VALUES (1,'Animais',40,'2018-04-23 02:57:57','2018-06-29 12:23:38',NULL),(2,'Grãos',41,'2018-04-23 02:58:07','2018-06-29 12:23:45',NULL),(3,'Máquinas',42,'2018-04-23 16:48:33','2018-06-29 12:23:51',NULL),(4,'Serviços',43,'2018-04-23 16:48:46','2018-06-29 12:23:59',NULL),(5,'Lojas',44,'2018-04-23 16:48:46','2018-06-29 12:24:08',NULL),(6,'Insumos',45,'2018-04-23 16:48:46','2018-06-29 12:24:15',NULL),(7,'Fretes',46,'2018-06-28 13:10:32','2018-06-29 12:24:23',NULL),(8,'Propriedades',47,'2018-06-28 13:10:48','2018-06-29 12:24:33',NULL),(9,'Silagem de cana',139,'2018-09-04 14:36:43','2018-09-04 21:29:33','2018-09-04 21:29:33');
/*!40000 ALTER TABLE `product_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_has_interests`
--

DROP TABLE IF EXISTS `product_has_interests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_has_interests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_app_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `status` enum('0','1','2') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_has_interests_user_app_id_foreign` (`user_app_id`),
  KEY `product_has_interests_product_id_foreign` (`product_id`),
  CONSTRAINT `product_has_interests_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_has_interests_user_app_id_foreign` FOREIGN KEY (`user_app_id`) REFERENCES `user_apps` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_has_interests`
--

LOCK TABLES `product_has_interests` WRITE;
/*!40000 ALTER TABLE `product_has_interests` DISABLE KEYS */;
INSERT INTO `product_has_interests` VALUES (4,8,13,'0','2018-07-02 19:00:24','2018-07-02 19:00:24',NULL),(5,4,7,'0','2018-07-03 15:10:32','2018-07-03 15:10:32',NULL),(6,4,11,'0','2018-07-03 16:14:06','2018-07-03 16:14:06',NULL),(7,19,11,'0','2018-07-03 21:47:21','2018-07-03 21:47:21',NULL),(8,20,11,'0','2018-07-03 22:49:16','2018-07-03 22:49:16',NULL),(9,5,11,'0','2018-07-04 14:17:41','2018-07-04 14:17:41',NULL),(10,8,8,'0','2018-07-04 17:14:56','2018-07-04 17:14:56',NULL),(11,8,11,'0','2018-07-04 17:15:28','2018-07-04 17:15:28',NULL),(12,8,7,'0','2018-07-04 17:16:22','2018-07-04 17:16:22',NULL),(13,4,15,'0','2018-07-04 20:37:27','2018-07-04 20:37:27',NULL),(14,10,15,'0','2018-07-04 22:31:41','2018-07-04 22:31:41',NULL),(15,5,7,'0','2018-07-05 01:36:32','2018-07-05 01:36:32',NULL),(16,21,7,'0','2018-07-05 23:10:45','2018-07-05 23:10:45',NULL),(17,8,12,'0','2018-07-06 13:49:36','2018-07-06 13:49:36',NULL),(18,6,15,'0','2018-07-06 19:56:38','2018-07-06 19:56:38',NULL),(19,5,17,'0','2018-07-06 23:58:29','2018-07-06 23:58:29',NULL),(20,28,17,'0','2018-07-08 01:25:50','2018-07-08 01:25:50',NULL),(21,34,8,'0','2018-07-10 21:28:59','2018-07-10 21:28:59',NULL),(23,40,20,'0','2018-07-15 01:10:50','2018-07-15 01:10:50',NULL),(26,52,20,'0','2018-07-19 22:29:42','2018-07-19 22:29:42',NULL),(28,46,8,'0','2018-07-22 22:50:20','2018-07-22 22:50:20',NULL),(29,63,20,'0','2018-07-29 12:58:43','2018-07-29 12:58:43',NULL),(32,67,8,'0','2018-08-20 21:53:33','2018-08-20 21:53:33',NULL),(44,115,93,'0','2019-07-30 13:09:35','2019-07-30 13:09:35',NULL),(45,8,95,'0','2019-08-29 13:35:11','2019-08-29 13:35:11',NULL),(46,115,96,'0','2019-09-04 20:21:07','2019-09-04 20:21:07',NULL),(47,115,98,'0','2019-09-18 22:58:24','2019-09-18 22:58:24',NULL),(48,39,99,'0','2019-10-05 21:30:52','2019-10-05 21:30:52',NULL),(49,115,99,'0','2019-10-08 14:47:19','2019-10-08 14:47:19',NULL);
/*!40000 ALTER TABLE `product_has_interests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_has_media`
--

DROP TABLE IF EXISTS `product_has_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_has_media` (
  `media_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  KEY `product_has_media_media_id_foreign` (`media_id`),
  KEY `product_has_media_product_id_foreign` (`product_id`),
  CONSTRAINT `product_has_media_media_id_foreign` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_has_media_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_has_media`
--

LOCK TABLES `product_has_media` WRITE;
/*!40000 ALTER TABLE `product_has_media` DISABLE KEYS */;
INSERT INTO `product_has_media` VALUES (48,7),(49,8),(51,10),(52,11),(53,12),(54,13),(61,15),(62,15),(63,15),(64,15),(65,15),(66,16),(67,16),(68,17),(69,17),(70,17),(71,17),(72,17),(76,20),(115,55),(116,55),(120,56),(121,56),(122,57),(123,57),(124,58),(125,59),(126,60),(128,62),(129,62),(130,62),(131,63),(132,63),(133,63),(134,63),(135,63),(145,70),(146,71),(147,72),(182,88),(183,89),(184,90),(185,91),(186,92),(187,93),(188,94),(189,95),(190,96),(191,97),(192,98),(193,99);
/*!40000 ALTER TABLE `product_has_media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_sub_categories`
--

DROP TABLE IF EXISTS `product_sub_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_sub_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subcategory` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_category_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_sub_categories_product_category_id_foreign` (`product_category_id`),
  CONSTRAINT `product_sub_categories_product_category_id_foreign` FOREIGN KEY (`product_category_id`) REFERENCES `product_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_sub_categories`
--

LOCK TABLES `product_sub_categories` WRITE;
/*!40000 ALTER TABLE `product_sub_categories` DISABLE KEYS */;
INSERT INTO `product_sub_categories` VALUES (4,'Equinos e Muares',1,'2018-04-23 02:58:21','2018-07-03 02:01:44',NULL),(5,'Bovinos',1,'2018-04-23 02:58:31','2018-07-30 18:16:08','2018-07-30 18:16:08'),(6,'Sub Categoria 2',5,'2018-04-23 02:58:40','2018-07-03 11:52:47','2018-07-03 11:52:47'),(7,'Suínos',1,'2018-04-23 18:32:23','2018-07-03 02:04:11',NULL),(8,'Galinhas',1,'2018-04-23 18:32:34','2018-07-03 02:05:24','2018-07-03 02:05:24'),(9,'Vacas',1,'2018-04-23 18:32:46','2018-07-03 02:19:33','2018-07-03 02:19:33'),(10,'Ovinos',1,'2018-04-23 18:32:56','2018-07-03 02:05:14',NULL),(12,'Angola',1,'2018-04-23 18:33:33','2018-07-03 02:05:32','2018-07-03 02:05:32'),(13,'Coelhos',1,'2018-04-23 18:33:38','2018-07-03 02:04:38','2018-07-03 02:04:38'),(14,'Patos',1,'2018-04-23 18:33:42','2018-07-03 02:06:12','2018-07-03 02:06:12'),(15,'Milho',2,'2018-06-29 18:10:35','2018-07-03 02:14:14','2018-07-03 02:14:14'),(16,'Tratores',3,'2018-06-29 18:10:42','2018-06-29 18:10:42',NULL),(17,'Soja',2,'2018-06-29 18:10:46','2018-06-30 12:23:08','2018-06-30 12:23:08'),(18,'Agropecuárias',5,'2018-06-29 18:11:00','2018-06-29 18:11:00',NULL),(19,'Bovinos',7,'2018-06-29 18:11:20','2018-06-30 12:22:38','2018-06-30 12:22:38'),(20,'Graneleiro',7,'2018-06-29 18:11:25','2018-07-03 02:14:57','2018-07-03 02:14:57'),(21,'Fazendas',8,'2018-06-29 18:11:34','2018-06-29 18:11:34',NULL),(22,'Cercas',4,'2018-06-29 18:12:04','2018-06-30 12:22:53','2018-06-30 12:22:53'),(23,'Veterinário',4,'2018-06-29 18:12:15','2018-06-29 18:12:15',NULL),(24,'Agrotóxicos',6,'2018-06-30 12:27:48','2018-06-30 12:27:48',NULL),(25,'Sorgo',2,'2018-07-03 02:06:56','2018-07-03 02:06:56',NULL),(26,'Soja',2,'2018-07-03 02:07:18','2018-07-03 02:07:18',NULL),(27,'Boiadeiro',7,'2018-07-03 02:08:25','2018-07-03 02:08:25',NULL),(28,'Basculante',7,'2018-07-03 02:09:38','2018-07-03 02:09:38',NULL),(29,'Baú',7,'2018-07-03 02:10:04','2018-07-03 02:10:04',NULL),(30,'Touros P.O.',1,'2018-07-03 02:11:12','2018-07-03 02:11:12',NULL),(31,'Vacas Leiteiras',1,'2018-07-03 02:11:46','2018-07-03 02:11:46',NULL),(32,'Novilhas',1,'2018-07-03 02:12:01','2018-07-03 02:12:01',NULL),(33,'Boi Magro',1,'2018-07-03 02:12:36','2018-07-03 02:12:36',NULL),(34,'Desmama',1,'2018-07-03 02:12:52','2018-07-03 02:12:52',NULL),(35,'Machos Cruzados',1,'2018-07-03 02:13:27','2018-07-03 02:13:27',NULL),(36,'HEMAFE ASSESSORIA AGROPECUÁRIA',4,'2018-07-03 02:25:11','2018-07-04 22:38:37','2018-07-04 22:38:37'),(37,'Milho',2,'2018-07-05 00:07:58','2018-07-05 00:07:58',NULL),(38,'Graneleiro',7,'2018-07-05 00:08:43','2018-07-05 00:08:43',NULL),(39,'Chacaras',8,'2018-07-05 00:09:45','2018-07-05 00:09:45',NULL),(40,'Arrendamento',8,'2018-07-05 00:10:04','2018-07-05 00:10:04',NULL),(41,'Implementos',3,'2018-07-05 00:10:43','2018-07-05 00:11:48',NULL),(42,'Agrônomos',4,'2018-07-05 00:12:52','2018-07-05 00:12:52',NULL),(43,'Diaristas',4,'2018-07-05 00:13:15','2018-07-05 00:13:15',NULL),(44,'Plantio',4,'2018-07-05 00:13:53','2018-07-05 00:13:53',NULL),(45,'Colheita',4,'2018-07-05 00:14:47','2018-07-05 00:14:47',NULL),(46,'Topógrafos',4,'2018-07-05 00:15:04','2018-07-05 00:15:04',NULL),(47,'Pulverização Aérea',4,'2018-07-05 00:15:55','2018-07-05 00:15:55',NULL),(48,'Veículos',3,'2018-07-18 13:17:43','2018-07-18 13:17:43',NULL),(49,'Silagem',6,'2018-09-04 21:32:05','2018-09-04 21:32:05',NULL);
/*!40000 ALTER TABLE `product_sub_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_sub_category_id` int(10) unsigned NOT NULL,
  `price` double(10,2) NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `date_end` date DEFAULT NULL,
  `type` enum('L','A') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'A',
  `person_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_product_sub_category_id_foreign` (`product_sub_category_id`),
  KEY `products_person_id_foreign` (`person_id`),
  CONSTRAINT `products_person_id_foreign` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_product_sub_category_id_foreign` FOREIGN KEY (`product_sub_category_id`) REFERENCES `product_sub_categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (7,'Trator',16,599.99,'Trator em perfeito estado','1',NULL,'A',3,'2018-06-30 12:10:16','2018-09-04 21:36:38','2018-09-04 21:36:38'),(8,'Casqueamento',23,100.00,'fazer casqueadura dos animais','1',NULL,'A',3,'2018-06-30 12:12:23','2019-08-07 12:52:03','2019-08-07 12:52:03'),(10,'Milho',26,80.00,'valor da saca','1',NULL,'A',3,'2018-06-30 12:24:51','2019-08-07 12:51:52','2019-08-07 12:51:52'),(11,'Fazenda',21,500000.00,'1000 hectares, ótimo para fazer pastagem','1',NULL,'A',3,'2018-06-30 12:26:26','2018-07-04 22:39:08','2018-07-04 22:39:08'),(12,'Borrão',24,699.99,'mata borrão','1',NULL,'A',3,'2018-06-30 12:28:56','2019-08-07 12:51:57','2019-08-07 12:51:57'),(13,'Filhotes',5,299.90,'Valor do filhotes','1',NULL,'A',3,'2018-07-02 11:42:27','2018-07-05 00:01:39','2018-07-05 00:01:39'),(15,'Fazenda Tocantins - TO',21,800000.00,'MUNICÍPIO DE CHAPADA DA NATIVIDADE\n*IMPERDÍVEL*\n- Área de 157 hectares;\n- Casa com energia;\n-Mini posso artesiano;\n-Sinal de telefone e internet;\n-Barragem;\n-40% formada de brachiarão;\n- Área 100% plana com terra macia;\n-20 km de chapada da Natividade (15 de asfalto e 5 de terra);\n-Localizada em região de plantio de sorja e milho; \n-30 km do armazém de grãos de Santa Rosa;\n-39 km da mineração de Calcário;\n-175 Km da capital Palmas;\n-indice pluviométrico 1600-1700 mm/ano. \n(aceito propostas)','1',NULL,'A',7,'2018-07-04 18:47:33','2018-07-04 18:47:33',NULL),(16,'garrotes',5,1728.00,'25 cabeças com média de 12 arrobas.','1',NULL,'A',7,'2018-07-04 23:56:00','2018-07-05 00:01:59','2018-07-05 00:01:59'),(17,'garrotes',5,1728.00,'25 cabeças com média de 12 arrobas. \n(preço por cabeça)','1',NULL,'A',7,'2018-07-05 00:05:13','2018-07-30 18:16:00','2018-07-30 18:16:00'),(20,'Produto UAI',33,199.99,'Descrição do produto','1',NULL,'L',42,'2018-07-13 17:01:08','2018-07-13 17:01:08',NULL),(55,'sorgo',25,27.00,'Está a 15 km de planura.','1',NULL,'A',13,'2018-07-20 22:51:24','2018-07-20 22:59:44','2018-07-20 22:59:44'),(56,'Pulverizador Jacto',41,30000.00,'Pulverizador Jacto modelo Ad-18 Columbia - 2000 l','1',NULL,'A',13,'2018-07-26 03:29:13','2018-07-26 03:29:13',NULL),(57,'porcos',7,120.00,'120 a  @ e leitoa a combinar','1',NULL,'A',37,'2018-07-26 13:25:29','2018-07-26 13:25:29',NULL),(58,'TOPOGRAFIA EM GERAL',46,1.00,'Serviços de Georreferenciamento, Car, Planialtimetrico, Consultoria Ambiental, levantamentos aéreos com Drones, loteamentos urbanos e rurais','1',NULL,'A',70,'2018-08-01 12:14:22','2018-08-01 12:14:22',NULL),(59,'Rodrigo Heitor',39,15000000.00,'Otima oportunidade para investimento!\n\nRegião de Comendador Gomes - MG.\n\nÁrea total: 198 alqueire (4,84)\nÁrea arrendada pra cana: 96 alqueire.\n*Valor do arrendamento 60 Ton/alqueire*\nÁrea em seringueira: 4 alqueire \n*Dentro de 2 anos está produzindo*\nÁrea em pastagens e reserva: 98 alqueire\n*Engorda 500 bois*\n\n*Valor 75 mil/alqueire*\nOu \n*15 milhões*','1',NULL,'A',13,'2018-08-05 16:10:58','2018-08-05 16:10:58',NULL),(60,'Rodrigo Heitor',39,15000000.00,'Otima oportunidade para investimento!\n\nRegião de Comendador Gomes - MG.\n\nÁrea total: 198 alqueire (4,84)\nÁrea arrendada pra cana: 96 alqueire.\n*Valor do arrendamento 60 Ton/alqueire*\nÁrea em seringueira: 4 alqueire \n*Dentro de 2 anos está produzindo*\nÁrea em pastagens e reserva: 98 alqueire\n*Engorda 500 bois*\n\n*Valor 75 mil/alqueire*\nOu \n*15 milhões*','1',NULL,'A',13,'2018-08-05 16:12:20','2018-08-05 16:12:20',NULL),(62,'carreta Volvo 330',48,230000.00,'carreta Volvo 330 ano 2014.\núnico dono.','1',NULL,'A',13,'2018-08-14 22:52:02','2018-08-14 22:52:02',NULL),(63,'Carreta Graneleira',48,110000.00,'Caminhão VW 19310 ano 2004 - Valor R$65.000,00\n\ncarreta graneleira random 2008 \nvalor: R$45.000,00','1',NULL,'A',13,'2018-08-14 22:57:07','2018-08-14 22:57:07',NULL),(70,'camionete Amarok 4×4 diesel 2013.2013 com 102.000 km',48,63000.00,'troco por gado ou carro','1',NULL,'A',37,'2018-10-09 12:10:56','2018-10-09 12:10:56',NULL),(71,'camionete Amarok 4×4 diesel 2013.2013 com 102.000 km',48,63000.00,'troco por gado ou carro','1',NULL,'A',37,'2018-10-09 12:11:04','2018-10-09 12:11:04',NULL),(72,'ordenha',41,7500.00,'ordenha e transferidor','1',NULL,'A',37,'2018-10-29 23:29:14','2018-10-29 23:29:14',NULL),(88,'Ok',35,11.11,'Ok','1','2019-07-23','A',3,'2019-07-08 19:38:30','2019-07-08 19:44:20',NULL),(89,'Novo',35,2.52,'Uy','1','2019-08-07','A',3,'2019-07-08 19:46:10','2019-07-09 12:06:48',NULL),(90,'Búfalos',33,145.00,'Valor por @','0',NULL,'A',120,'2019-07-26 19:26:15','2019-07-29 13:31:27',NULL),(91,'Teste',4,19.90,'Se','0',NULL,'A',3,'2019-07-29 13:29:13','2019-07-29 13:29:13',NULL),(92,'Girolando 1/2 sangue',31,6000.00,'Animais com média de 35 kg leite/dia','0',NULL,'A',120,'2019-07-29 13:39:44','2019-10-05 21:26:28',NULL),(93,'Vacas Girolando 1/2 sangue',31,6000.00,'Vacas com média de 35 kg de leite/dia','1','2019-08-13','A',120,'2019-07-29 13:54:03','2019-08-31 17:32:39',NULL),(94,'ATeste',4,19.90,'Teste','1','2019-08-25','A',3,'2019-08-22 12:26:21','2019-08-22 12:26:36',NULL),(95,'TESTE',4,19.90,'Teste','1','2019-09-01','A',3,'2019-08-29 12:05:39','2019-08-29 12:05:50',NULL),(96,'Girolanda',31,6000.00,'Animal com 2 partos, registrada, com média de produção de 30 litros','1','2019-09-07','A',120,'2019-09-04 20:19:52','2019-09-04 20:20:29',NULL),(97,'Boizinho',33,999.99,'Muu','0',NULL,'A',3,'2019-09-17 19:54:47','2019-09-17 19:54:47',NULL),(98,'Boizinho',33,999.99,'Muu','1','2019-09-20','A',3,'2019-09-17 19:54:55','2019-09-17 19:55:10',NULL),(99,'Girolanda 1/2 sangue',31,6000.00,'Animal com 4 anos e meio, duas crias e produção média de 35 litros','1','2019-10-08','A',120,'2019-10-05 21:29:52','2019-11-25 17:44:48',NULL),(100,'Hebert',23,1.00,'Total','0',NULL,'A',120,'2019-10-26 16:53:37','2019-10-26 16:53:37',NULL),(101,'Hebert',23,1.00,'Total','0',NULL,'A',120,'2019-10-26 16:55:18','2019-10-26 16:55:18',NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Administrador','2018-02-09 21:35:39','2018-02-09 21:35:39',NULL),(2,'Usuário','2018-06-28 13:05:57','2018-06-28 13:05:57',NULL),(3,'Admin UAI','2018-06-29 18:14:31','2018-06-29 18:14:31',NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `states`
--

DROP TABLE IF EXISTS `states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `states` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `states_country_id_foreign` (`country_id`),
  CONSTRAINT `states_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `states`
--

LOCK TABLES `states` WRITE;
/*!40000 ALTER TABLE `states` DISABLE KEYS */;
INSERT INTO `states` VALUES (1,'SP',1,'2018-06-28 13:49:48','2018-06-28 13:49:48',NULL),(2,'MG',1,'2018-11-09 14:39:32','2018-11-09 14:39:32',NULL);
/*!40000 ALTER TABLE `states` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stores`
--

DROP TABLE IF EXISTS `stores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stores` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `person_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stores_person_id_foreign` (`person_id`),
  CONSTRAINT `stores_person_id_foreign` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stores`
--

LOCK TABLES `stores` WRITE;
/*!40000 ALTER TABLE `stores` DISABLE KEYS */;
INSERT INTO `stores` VALUES (1,4,'2018-06-28 13:50:13','2018-07-30 18:18:19','2018-07-30 18:18:19'),(2,42,'2018-07-13 17:00:06','2018-11-09 14:20:31','2018-11-09 14:20:31');
/*!40000 ALTER TABLE `stores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_apps`
--

DROP TABLE IF EXISTS `user_apps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_apps` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `person_id` int(10) unsigned NOT NULL,
  `token` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_apps_person_id_foreign` (`person_id`),
  CONSTRAINT `user_apps_person_id_foreign` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_apps`
--

LOCK TABLES `user_apps` WRITE;
/*!40000 ALTER TABLE `user_apps` DISABLE KEYS */;
INSERT INTO `user_apps` VALUES (1,3,'','1','2018-06-28 13:14:19','2018-06-28 13:14:44',NULL),(3,6,'','1','2018-06-28 14:19:32','2018-06-28 14:20:00',NULL),(4,7,'','1','2018-06-28 17:37:32','2018-06-28 17:38:10',NULL),(5,8,'','1','2018-06-28 21:53:03','2018-06-28 21:53:28',NULL),(6,9,'','1','2018-06-29 11:55:54','2018-06-29 11:57:34',NULL),(7,10,'63791A','0','2018-06-29 12:55:19','2020-02-29 08:37:03',NULL),(8,12,'','1','2018-07-02 18:57:06','2018-07-02 18:57:47',NULL),(9,13,'','1','2018-07-02 19:56:25','2018-07-02 19:57:03',NULL),(10,14,'','1','2018-07-02 22:49:09','2018-07-02 22:52:39',NULL),(12,16,'','1','2018-07-03 15:06:07','2018-07-03 15:08:53',NULL),(18,22,'','1','2018-07-03 18:17:22','2018-07-03 18:17:57',NULL),(19,23,'','1','2018-07-03 21:41:51','2018-07-03 21:43:03',NULL),(20,24,'','1','2018-07-03 22:45:13','2018-07-03 22:46:57',NULL),(21,25,'','1','2018-07-05 23:06:11','2018-07-05 23:06:54',NULL),(22,26,'','1','2018-07-06 13:57:35','2018-07-06 13:58:16',NULL),(23,27,'','1','2018-07-06 18:31:43','2018-07-06 18:33:24',NULL),(24,28,'','1','2018-07-07 00:57:01','2018-07-07 00:57:23',NULL),(25,29,'726F9C','0','2018-07-07 01:40:37','2018-07-07 01:40:37',NULL),(27,31,'','1','2018-07-07 23:24:41','2018-07-07 23:25:04',NULL),(28,32,'','1','2018-07-08 01:24:00','2018-07-08 01:25:02',NULL),(29,33,'','1','2018-07-08 22:10:17','2018-07-08 22:13:59',NULL),(30,34,'','1','2018-07-08 22:32:23','2018-07-08 22:33:06',NULL),(31,35,'E06249','0','2018-07-09 18:52:30','2018-07-09 18:52:30',NULL),(32,36,'','1','2018-07-10 11:48:56','2018-07-10 11:49:11',NULL),(33,37,'','1','2018-07-10 13:45:42','2018-07-10 13:47:49',NULL),(34,38,'','1','2018-07-10 21:23:52','2018-07-10 21:25:26',NULL),(35,39,'','1','2018-07-10 22:25:41','2018-07-10 22:26:06',NULL),(37,41,'','1','2018-07-13 16:45:14','2018-07-13 16:45:42',NULL),(39,44,'','1','2018-07-13 17:38:00','2018-07-13 17:38:39',NULL),(40,45,'','1','2018-07-15 01:07:53','2018-07-15 01:10:00',NULL),(41,46,'','1','2018-07-15 16:44:13','2018-07-15 16:45:18',NULL),(42,47,'','1','2018-07-15 21:00:06','2018-07-15 21:01:06',NULL),(43,48,'','1','2018-07-16 15:01:13','2018-07-16 15:03:11',NULL),(45,50,'20F5FF','0','2018-07-16 22:14:39','2018-07-16 22:14:39',NULL),(46,51,'','1','2018-07-16 22:16:31','2018-07-16 22:17:30',NULL),(47,52,'','1','2018-07-17 13:52:56','2018-07-17 13:53:51',NULL),(48,53,'','1','2018-07-17 18:08:29','2018-07-17 18:10:59',NULL),(49,54,'187151','0','2018-07-18 15:27:13','2018-07-18 15:27:13',NULL),(50,55,'','1','2018-07-18 15:29:55','2018-07-18 15:38:50',NULL),(51,56,'','1','2018-07-18 17:27:04','2018-07-18 17:31:24',NULL),(52,57,'','1','2018-07-19 22:28:15','2018-07-19 22:28:50',NULL),(53,58,'','1','2018-07-19 22:38:56','2018-07-19 22:40:43',NULL),(54,59,'','1','2018-07-20 01:55:47','2018-07-20 01:56:26',NULL),(55,60,'9C4AB5','0','2018-07-20 02:02:58','2018-07-20 02:02:58',NULL),(56,61,'','1','2018-07-20 13:20:30','2018-07-20 13:24:30',NULL),(57,62,'','1','2018-07-20 16:07:52','2018-07-20 16:09:04',NULL),(58,63,'','1','2018-07-22 21:31:13','2018-07-22 21:33:46',NULL),(59,64,'','1','2018-07-25 19:51:57','2018-07-25 19:52:51',NULL),(60,65,'C0AF02','0','2018-07-25 23:48:40','2018-07-26 10:17:10',NULL),(61,66,'7BDD12','0','2018-07-28 15:09:59','2018-07-28 15:09:59',NULL),(62,67,'','1','2018-07-28 15:10:52','2018-08-08 16:48:31',NULL),(63,68,'','1','2018-07-29 12:53:51','2018-07-29 12:54:32',NULL),(64,69,'','1','2018-07-30 18:20:29','2018-07-30 18:28:28',NULL),(65,70,'','1','2018-08-01 11:36:12','2018-08-01 11:36:48',NULL),(66,71,'','1','2018-08-07 00:59:05','2018-08-07 01:02:06',NULL),(67,72,'','1','2018-08-20 21:46:16','2018-08-20 21:46:44',NULL),(68,73,'','1','2018-08-21 02:14:23','2018-08-21 02:17:02',NULL),(69,74,'D20604','0','2018-08-21 08:08:16','2018-08-21 08:08:16',NULL),(70,75,'','1','2018-08-21 09:58:46','2018-08-21 09:59:34',NULL),(71,76,'','1','2018-08-21 12:36:49','2018-08-21 12:39:29',NULL),(72,77,'','1','2018-08-21 15:19:10','2018-08-21 15:21:13',NULL),(73,78,'232792','0','2018-08-21 23:12:04','2018-08-21 23:12:04',NULL),(74,79,'B8F82E','0','2018-08-23 11:01:53','2018-08-23 11:01:53',NULL),(75,80,'','1','2018-08-29 00:38:21','2018-08-29 00:42:07',NULL),(76,81,'AC0999','0','2018-09-02 23:37:11','2018-09-02 23:37:11',NULL),(77,82,'','1','2018-09-05 16:32:09','2018-09-05 16:33:29',NULL),(78,83,'DACBB0','0','2018-09-05 16:33:51','2018-09-05 16:33:51',NULL),(79,84,'AC2E49','0','2018-09-08 21:57:56','2018-09-08 21:59:28',NULL),(80,85,'','1','2018-09-11 12:51:15','2018-09-11 12:51:50',NULL),(81,86,'DCE335','0','2018-09-19 23:00:11','2018-09-19 23:02:06',NULL),(82,87,'','1','2018-09-20 00:12:40','2018-09-20 00:25:53',NULL),(83,88,'BA434A','0','2018-09-24 13:02:23','2018-09-24 13:02:23',NULL),(84,89,'A68AE2','0','2018-09-24 13:02:39','2018-09-24 13:02:39',NULL),(85,90,'','1','2018-10-02 21:40:40','2018-10-02 21:41:32',NULL),(86,91,'','1','2018-10-16 02:07:47','2018-10-16 02:08:54',NULL),(87,92,'','1','2018-10-16 11:50:52','2018-10-16 11:57:48',NULL),(88,93,'','1','2018-10-23 19:30:53','2018-10-23 19:31:36',NULL),(89,94,'','1','2018-10-27 21:52:54','2018-10-27 21:53:23',NULL),(90,95,'92D948','0','2018-10-31 13:22:39','2018-10-31 13:22:39',NULL),(91,96,'756013','0','2018-10-31 21:18:39','2018-10-31 21:18:39',NULL),(92,97,'04D34D','0','2018-11-02 16:33:47','2018-11-02 16:33:47',NULL),(93,98,'2ACB7B','0','2018-11-02 16:40:59','2018-11-02 16:40:59',NULL),(94,99,'BCCE9D','0','2018-11-02 16:42:10','2018-11-02 16:42:10',NULL),(95,100,'4D408C','0','2018-11-05 12:02:35','2018-11-05 12:02:35',NULL),(96,101,'B945E2','0','2018-11-09 23:25:58','2018-11-09 23:25:58',NULL),(97,102,'22EFDA','0','2018-11-22 00:37:22','2018-11-22 00:37:22',NULL),(98,103,'57B30A','0','2018-11-22 00:39:13','2018-11-22 00:39:13',NULL),(99,104,'D92E47','0','2018-11-24 22:58:13','2018-11-24 23:00:06',NULL),(100,105,'2356D0','0','2018-12-05 21:13:09','2018-12-05 21:13:09',NULL),(101,106,'F0D172','0','2018-12-10 12:16:28','2018-12-10 12:16:28',NULL),(102,107,'922369','0','2018-12-17 00:18:38','2018-12-20 18:51:04',NULL),(103,108,'BFBF61','0','2018-12-24 21:24:28','2018-12-24 21:27:52',NULL),(104,109,'F425C3','0','2019-01-06 15:00:26','2019-01-06 15:00:26',NULL),(105,110,'5CD015','0','2019-01-11 01:15:03','2019-01-11 01:15:03',NULL),(106,111,'A18E44','0','2019-01-11 20:47:18','2019-01-11 20:47:18',NULL),(107,112,'CE7492','0','2019-02-11 12:43:26','2019-02-11 12:56:33',NULL),(108,113,'AC3798','0','2019-02-14 19:11:58','2019-02-14 19:16:03',NULL),(109,114,'677BDD','0','2019-02-14 19:17:40','2019-02-14 19:17:40',NULL),(110,115,'09460D','0','2019-02-16 00:21:40','2019-02-16 00:21:40',NULL),(111,116,'E2553E','0','2019-02-18 15:58:56','2019-02-18 15:58:56',NULL),(112,117,'02ED33','0','2019-02-18 15:59:07','2019-02-18 15:59:07',NULL),(115,120,'','1','2019-02-18 19:32:10','2019-02-18 19:32:34',NULL),(116,121,'','1','2019-02-18 21:44:37','2019-02-18 22:23:43',NULL),(117,122,'C404ED','0','2019-03-11 22:38:21','2019-03-11 22:38:21',NULL),(118,123,'','1','2019-03-27 20:00:22','2019-03-27 20:01:01',NULL),(119,124,'215341','0','2019-04-02 13:57:49','2019-04-02 13:57:49',NULL),(120,125,'9B744A','0','2019-04-02 14:00:17','2019-04-02 14:00:17',NULL),(121,126,'','1','2019-04-02 14:02:04','2019-04-02 14:11:12',NULL),(122,127,'','1','2019-04-12 15:49:51','2019-04-12 15:50:19',NULL),(123,128,'','1','2019-04-12 21:13:27','2019-04-12 21:13:41',NULL),(124,129,'32A12F','0','2019-04-19 23:37:51','2019-04-19 23:37:51',NULL),(125,130,'5FC25A','0','2019-04-22 18:51:13','2019-04-22 19:47:30',NULL),(126,131,'D8815D','0','2019-05-15 18:38:43','2019-05-15 23:35:33',NULL),(127,132,'','1','2019-06-12 04:33:37','2019-06-12 04:46:47',NULL),(128,133,'2A1DCA','0','2019-06-30 00:13:53','2019-06-30 00:13:53',NULL),(129,134,'1F6097','0','2019-07-13 01:34:08','2019-07-13 01:34:08',NULL),(130,135,'3D8A6B','0','2019-07-19 21:28:54','2019-07-19 21:28:54',NULL),(131,136,'489A20','0','2019-07-21 13:32:57','2019-07-21 13:35:54',NULL),(132,137,'1F57AC','0','2019-08-15 12:54:38','2019-08-15 12:57:09',NULL),(133,138,'82BBDF','0','2019-08-25 19:14:46','2019-08-25 19:14:46',NULL),(134,139,'9A975B','0','2019-08-25 19:19:17','2019-08-25 19:19:17',NULL),(135,140,'','1','2019-09-23 15:30:04','2019-09-23 15:30:47',NULL),(136,141,'','1','2019-10-03 22:39:29','2019-10-03 22:40:15',NULL),(137,142,'570BBB','0','2019-11-24 19:16:33','2019-11-24 19:16:33',NULL),(138,143,'873AE8','0','2020-01-23 15:15:38','2020-01-23 15:15:38',NULL),(139,144,'611C93','0','2020-01-23 15:21:32','2020-01-25 13:21:47',NULL),(140,145,'218137','0','2020-01-29 15:36:26','2020-01-29 15:38:14',NULL),(141,146,'7FF408','0','2020-02-03 13:58:30','2020-02-03 13:58:30',NULL),(142,147,'45B45A','0','2020-02-24 16:22:29','2020-02-24 16:23:25',NULL),(143,148,'215306','0','2020-03-02 03:32:56','2020-03-02 03:32:56',NULL),(144,149,'8542C2','0','2020-03-12 17:22:23','2020-03-12 17:22:23',NULL);
/*!40000 ALTER TABLE `user_apps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `api_token` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_phone_unique` (`phone`),
  UNIQUE KEY `users_api_token_unique` (`api_token`)
) ENGINE=InnoDB AUTO_INCREMENT=174 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin@zordon.com.br',NULL,'$2y$10$mibypizPgNOtUPXBZRQCnumwNuPeC8ReGMbttqMqnac.cOyAS4DTO',NULL,'DT46do2eEUhMHMoroMmSU2MscYUPkZrLQApBJ4MHZT7ZaMHhjZSX1fqsPoxX','2018-02-09 21:36:57','2018-07-13 16:40:46',NULL),(2,'user@uaiapp.com.br','(22) 22222-2222','$2y$10$Fz.6wYYsCJMlP41dLMPSGeCLHymx11UI.zSmYFIOuuM7eY7DsE2um',NULL,'lvaAGY10Qcoq0xAAdvHdI0Ez6PGaH8ZWwDRXEJcsbVSr4tPbXVvxeIRTPqRx','2018-06-28 13:07:54','2018-06-28 13:12:16','2018-06-28 13:12:16'),(3,'lucas.emmanuel28@gmail.com','17988051914','$2y$10$nIuRFY2cQEb7P8HKHil.hOMsI3oQkJcCK/m5u0ItwsOXf904x3ZOu','MliwrfZCVRdNk9vYqaaVtgPf8M6FK1gedbPgwWYHqA1rkqPSqh6qu0l3ZI61','5e77OCDb2pD1Vum9OdubQMsWJ1LTUUocw5fyy1BBAwMzAmWhsLAnfRuIWWwU','2018-06-28 13:14:19','2018-07-30 18:04:53',NULL),(4,'agropecuaria@laranjao.com.br','(34) 9974-3503',NULL,NULL,NULL,'2018-06-28 13:50:13','2018-07-12 19:59:40',NULL),(6,NULL,'17991621430','$2y$10$Em2eLPn8pbUObCOdJaDTlueN6528m5tlDjo8jJgEpr8jHqNBW6VNy','rGYqizeH51fXbVumSjclgA7zYup6l6XQgZWhtpxTEXRj1VT2R12Q4mHtMvTf',NULL,'2018-06-28 14:19:32','2018-06-28 14:19:32',NULL),(7,NULL,'34999955338','$2y$10$83MJYWm8sv3eysXaXeohNe.3jS9Art7UEokgyH56AczF6W7JDd5ri','Q9mUfFpsmsI94mX5j99ezOFPSUM4IAjyqx8REwU3fpPUZuQl2whqHoI89ZvE','hTuYVFYGS76tDLj0iora2eWOIMAbhkaDiSFlqf4BRMURR4aWEW8vJibLzW7a','2018-06-28 17:37:32','2018-06-30 15:26:30',NULL),(8,NULL,'34992323730','$2y$10$9lm/jmssR3VZrQbmhz6IkuXYLZ/kyj4FSJ7Li1crB2PCTGKIAPsey','byoUBRRgXe8JLNPDoMAHUST63vLnrgZd4UBHU3QkhMCCJjRFDaR0IJppcBBW','77xTOaWg8zluBiPwjumfmRs4yN4QrEnoflQNXGMrgUEnBbDQ3YuZhmOTMOZz','2018-06-28 21:53:03','2018-06-28 21:53:03',NULL),(9,NULL,'17991035102','$2y$10$wKIXprBKP84BMRtYwpn9d.9CeRTN6pZfoHN3XlkITMra/oFAbSte6','y4dYlFBcFR6eP3CwHLzTAqc5Qo7pUamKv6COtlQSPsGIMgy0bSiseQ3383tt','j24fue5xvO10oaydpQL5m8X525LubfkDM490KyhECPMiGmiNDsPw5sra3hxw','2018-06-29 11:55:54','2018-06-29 11:55:54',NULL),(10,NULL,'5555555555','$2y$10$pn5SyESUWqG8vfVOac0K6ut8cj7RN/8EU80hyqGn10lRp8ED.D5SO','HzgEyW5gLtxeIgLjHUrupHGD7eleYciMZSrxDqE4lPKsddFFVy0w3OGzLu7I',NULL,'2018-06-29 12:55:19','2018-06-29 12:55:19',NULL),(11,'admin@uaiapp.com.br',NULL,'$2y$10$mDd0tsAuHpKb8Kp2tMQCBOP7XIhcC8O2cLGQvMRfmoV17qmpnbqD2',NULL,'6O3IJ8r6qzmTJ7tpy0dx3iv6PF3W20d0PDdzupusJ8bVc3UIjrhZBw42biq5','2018-06-29 18:13:51','2019-03-06 13:59:41',NULL),(12,'joaolimiere@gmail.com','17988041595','$2y$10$rA7vfZtT8I7a0zesOsJLmu.O5jmERwnU/iyYJjfzY0ubaAWvfO99S','c4CwFstGqRZnyJVesSXc5QeEPXcr2yzL9DTIzEuz3pgciz3pBOjWWjVcvRd2','jQpX4Z9uuAl11EH9cGOUKrsTSaaXq9kJuIEPuFvZHDjvl8EJi3Bl92YifZNU','2018-07-02 18:57:05','2018-07-24 22:19:51',NULL),(13,NULL,'34991252731','$2y$10$JyZ9Os3iaA1xzvtlG46rS.Hruxnb5TY.SMca/GUvZ9qoqyg90JaUu','LcGpZ2ZGZUvQqMa4aP1QiggAfXU8X6vanqLm98jikvjo7FmjlbrKGv7XOtog','pJ6mDi3bhkWPL7tsD7Et59VPw5uvqjx6rkxPDnaNbZAY2ntAMPCXjarlyPrP','2018-07-02 19:56:25','2018-07-02 19:56:25',NULL),(14,NULL,'34996630070','$2y$10$Xgevq.JDdM5TYIygpv.wV.jMYjyq11EmnhYsQxm3MkfeCeWQAGRVW','FvRH97tid95UJtrDIHsHkIBj6nRgc0bDdVqKdxCQyTzSP0SpOlQ2wjZcpCnh','feb3JBUbSRZqVLFGawZEuqlBrqkCBJjQKNjHtH4OndCLHIwMGLCUfM637tdm','2018-07-02 22:49:09','2018-07-02 22:49:09',NULL),(16,NULL,'34999677017','$2y$10$xfJCWvbgXmRrPM6ocv1TDumwhhY0b5SkFFg/L2Bx5zHQSe1FLKSOG','MDkJEgom5Mix1KleModhNIJCKds61MEVc9GSvwM0QMDvLR1NbAFUs3HhjI07',NULL,'2018-07-03 15:06:07','2018-07-03 15:06:07',NULL),(22,NULL,'17982148445','$2y$10$DIJZk6LsTdG4T2XuOGIj5eeagXAAlENyUBCc4s3V8kLtXfHwUfq42','cGwsiqbVHLedLQGU6kJBg3JDU4kLIBOYeWaajoDW1VFq4safOZIk5qqdU0G5','AqrpQe7kxzM2kFZ0PfPZGdLuqP30P8EFwEfjwQZXcgV2CiebjCqXsbkcIIob','2018-07-03 18:17:22','2018-07-03 18:17:22',NULL),(23,NULL,'34996684422','$2y$10$KMEeGDh2F5Vtdtt.CsQ2Rees1wWBKAZemeSlIlpnCkMvUib9XpELu','R7foctFWm61uKcMRyuh2a5DN72JooejotSF77hcplCdhWBInp6Vko6D7fbQ4','2FtFpIBGVUwh1JqmECKUwddKNdwKJvXrUN5XgtSU8cgge0Z8PpTtAwpeCyyw','2018-07-03 21:41:51','2018-07-03 21:44:44',NULL),(24,NULL,'34999797236','$2y$10$FCaZfwFoOp9GpO9.SrdytO6eJglX/o7J/KxjeZFSk/QThLVI.KVa.','fzrofKvr1hO8iZysNW6D9SZGZoFPlKHaMM398jC1JhV6kBnkDrtUemuEeH4v','VcRbVGBZbGLCpzvqAaMyT71L4JkJBroIMUdwMEL7xyEbTveR0O8lI6rQVNWr','2018-07-03 22:45:13','2018-07-03 22:45:13',NULL),(25,NULL,'','$2y$10$T0G7tTBxWqV6wXyVwOJDjum4tGh2K//K8IS5dFmlttNhTA4MBJY0.','wUiU6HHDCQr7TFmZu2SHKtvEeVByR8CPWv8SoiTVfJiCMlbnIMWlaLojQPPV',NULL,'2018-07-04 17:09:10','2018-07-04 17:09:10',NULL),(26,NULL,'34984166236','$2y$10$uAlZBQmYKO1I3f7ZMri3Q.ld2ft20liNtqW2OnhTvzgH2.LnaRk9e','eG98FPvDqfq77wrC2uYkUL98W7ugfaQQFiUW701h6hsK3zaaljpvybHRKAYm','HrixSzpS3dOEQr8V14ueq2qm7JT7ff5zqGBX7hbH8lKttf5Ox7ccAzVFi4UV','2018-07-05 23:06:11','2018-07-05 23:06:11',NULL),(28,NULL,'34996711304','$2y$10$Ga5t7QkZmSvmo3PluQSheOrFGT2xMEq6bAy5pt3/XSyJ7A1v1gPnm','ne0tsQBBbdzelngU3pRjyjI6vRU5zOd0waUArUAOHR7jg9tZi5m9OOQw3kRa','N0iwThUaFeON0nL7fjmocEhcIL1F0LTHo1G0EecZZRZ7DrawLcktlUnAEmh9','2018-07-06 13:57:35','2018-07-06 13:57:35',NULL),(29,NULL,'34992313213','$2y$10$QfSJ.E.dxyQuFWqsVu.NkuJi4w8cGia.yO9zYpOz4ujg1ipgrpdfa','VsJAMJwxTYKHCuwR4BfVsbLccaSV0KNNPhZbmqPmrfpYYXgHz6zKbyWPghwq','16Iry3fxSLB0TG2bkPt2Fd1XOw50g5CrRRGzGYexyMPx8vDten5mTOklXzak','2018-07-06 18:31:43','2018-07-06 18:31:43',NULL),(30,NULL,'3499919301','$2y$10$9Ud7FGSYs7PsG7arp.8LDefkX1QI8RHs7HF66evpsdPxALLxq2ZL6','03M3uDWlbQUt9AGBKR8yWRjpIccT23hTynUh9LlHbMCnoaxq4u74qveYUOxN','1fo5IkqTjDSY05dSfqYMpfX5f11yJ8hzUfjRcENuL6rH21r3H8IjaOFiTSCB','2018-07-07 00:57:01','2018-07-07 00:57:01',NULL),(31,NULL,'34984179191','$2y$10$2f.0VuiG8BvdEVo60nFPn.Jq3jMpuhOSRAUdFBd8zxTf/O8YK570O','x4kDoAP9mH0Dt85O97PgsEgBWN5sayTMbntE8ypmJpjG1AdQzQpwwZix7HL7',NULL,'2018-07-07 01:40:37','2018-07-07 01:40:37',NULL),(33,NULL,'34999781206','$2y$10$20jXDQT3prGxg.DUIQkCdOSZWhOJSSA/nCKPGK2o2V.v41W3KmU2e','Y96ox2ZDvn4mLkGe3nXnUBspzmWOi2dIa2eygdcfZEBAFE7RZoeF41P0MHuw','v0tx7JNDAZBX765jU1TuupwSeu3XKV6RFNnjWGnV2rtaknqH0Udpft4kevBW','2018-07-07 23:24:41','2018-07-07 23:24:41',NULL),(34,NULL,'34999740745','$2y$10$/sf9MS2BzmYzvq2ocO73sObMqUgT2YMyF8RwXVwCeuTSiel.95Aqi','mE8n8haOlRUDmn1FInhpzH4kPfXytkSDunRr74PalarBIC9EIEOva9uG0tyL','DL6MEJt07v2SukJDMQD0q2bxGSlsQJdx6We0T25lHhiABfh4ymOtmOa5DVaz','2018-07-08 01:24:00','2018-07-08 01:24:00',NULL),(36,NULL,'17981522106','$2y$10$qsjVVv16JwQ9XsUb9WYvFO/3mHGv5EOHaTsw/SWNRLD5/ha/ZIvVC','ETwZ7csZeEP0M9gd4gZlktCctDtNmJnYBDZANHtJXZdgRBc7gPuYcir4F0PO','DSemU3LyvT5Yrw1s4Sfhnc0pKs47hfAO4AcEBYyZsgw0hz3OXI6raQhcglxd','2018-07-08 22:10:17','2018-07-08 22:10:17',NULL),(38,NULL,'34991665030','$2y$10$P87hnaHezLu0lVlThfcRUuKKItSjqBubq5wiwtKZDqWrsOLK2IVpy','zUrC2W4ZtdFO5xzD9mKVvij84kPUrt0GkP6s2S3NxEXVG6QaI4QsyOrl43Ty','UPaoxbSTAilmffkj7C0DxJ3hbuVFkUupf439dpMbNgSU8TpEGQAUiQ4L5e6o','2018-07-08 22:32:23','2018-07-08 22:32:23',NULL),(39,NULL,'34999203586','$2y$10$QAz9Sfymub5tffjNSryB9.UOCkzAZEwvbNoXrZeCFd8zG/f/szjoC','QR8RSU9RCsFheADRFp3PE6BXVN8QjEOvUIrMhO4uau1gP6cGjJa9uULOI02u',NULL,'2018-07-09 18:52:30','2018-07-09 18:52:30',NULL),(40,NULL,'3499965225','$2y$10$mtJ.Cou6rQUmofLTjiqdhuM6T.yZELn5RB.opGcmru/tgB9QvDX0C','pNJPPZEkPpAXsp82QVjiGuyfi4U4BV9CUoBn2JNrbHRFhEl1ogbNJHZuup5i','Ibaoa9ikXR4jrKvBT8B636P0bOW8Iw0V8963Phqoj7D1cCJHtXMA0oprg4Rr','2018-07-10 11:48:56','2018-07-10 11:48:56',NULL),(42,NULL,'34999797807','$2y$10$Zq3OIWOuflTOHI.bw8qgB.Df9QAX8YQ/OWMnBz/df1dua5l9OeApG','pItewVgcy2CoXsnnHuxjF5yay1AtAYAiVCcNRIq77EkxsOG0Svyc76idDMAX','yWY5SgNHvjvFKGwDNntJGO7MXX9tm6oh4D1ex8WGWzIe5B0uvWEgrxxVEgOK','2018-07-10 13:45:42','2018-07-10 13:45:42',NULL),(43,NULL,'17981685022','$2y$10$cbVwFIKaF353scE7AgNjX.afXlomOEbuGHCasUjfdNrck5PVtdxI2','nkIBfxAs0E2Raj0KCaMoKyOBNR6DsR1Iiy4EdGD5at8HshipnmGznN1UYSKw','8Q8fKcQ1fB054ryQjmny9hiNw4rbWbGNOBrRYw1O06aMjTtCMmZOhUEIlyXN','2018-07-10 21:23:52','2018-07-10 21:23:52',NULL),(44,NULL,'34996844192','$2y$10$XlOlUQp7o9VsSvd4zuBbnertK5l3zTC5guUoXZZBmOrRK0N/l6UyW','zh7sVcS60pZUdAlCfu5w8953JpZA1cKK9uNo7EKubqcPa9ylRvCk9vFsXU3x',NULL,'2018-07-10 22:25:41','2018-07-10 22:25:41',NULL),(46,NULL,'17991211139','$2y$10$aQ/mb3DYq3p9Jpo2zd2b3.VgAOheQ8zzcolSlVstkFIteNK9.zZKO','iTs242ywzIc1q7XkXrhXFtZNtMfZqQWpkNiPQNmGfw1fn0JppODlCBWZdp1r','nSmLN79BHpg9H6Ip54Uj5o8oKUuEXRf9AdUdTPVazAavN2jJvEgQsFBZ640J','2018-07-13 16:45:14','2018-07-13 16:45:14',NULL),(47,'contato@uai.com.br','(17) 3323-4689',NULL,NULL,NULL,'2018-07-13 17:00:06','2018-07-13 17:00:06',NULL),(49,NULL,'67998835259','$2y$10$Jvxk9b8MgQqA448P9qZmVuFh/gI7Q/vkIL8cRearyZG4Isb4dWPjW','BLPvkn7SaVnol1BFfFjQw1unQx4y6deOfWJXu4FHPeSA14352s3cFdbGK2gT','Uqkcyaxnv1BIPQvJRlKJhTzJFNF1rECLOQCyQ805cf7Anrn3YIjvvWIL79OT','2018-07-13 17:38:00','2018-07-13 17:38:00',NULL),(50,NULL,'34996813435','$2y$10$/7j6YH1xhkMkdY9oBGCrhOkNLwyQ/cnxSaWzSZk0IcJ2yRtedMC0.','H73PKpJy6ymNXO2H2BmwBZrlaDKvCt6gxv3rQSyQfVUxCJZJ3XIxifeKZgKH','sT04Id0IUrUlbp8kISYIXaXjMT5fMJZOqliP9maCkyq7fFtIbzrnkzExm8yS','2018-07-15 01:07:53','2018-07-15 01:07:53',NULL),(51,NULL,'17982095042','$2y$10$sYj4JPX6BDGgwvf5Ep4HduxZOyVg5liV3wV5IsMrMjteVjJnVrrni','D79AMHPga77DWuzQZXQjlp8BPCm5mHpSSgdaCZTUZ0pSWTjTRizGOnAITx9d','myVaWqqyLMb1aeu1LtN6RhWp3DzN1zHY1uICMvCfx3vtMN3283dmkW5728wz','2018-07-15 16:44:13','2018-07-20 01:32:59',NULL),(52,NULL,'34999740845','$2y$10$qif9OafqAhY.8BUUb96yu.zOemD7hqXhOuWOORIGM1J1U6H/wafpG','1u7oqL1djhCCd3eU5x7RRwtIGgEbD7kwK8ZcSEdqwjDBPmJvpWzj34xk5eRd','ksA2AlKOa3HMmsTrPD2mzjrFkewF7jlBlfJfvUeeHjYTP23M8Qs3gBG2WW94','2018-07-15 21:00:06','2018-07-15 21:00:06',NULL),(53,NULL,'67999857667','$2y$10$e8/uLtUpZtE2NhBbGqCza.MpgWdx1bk6EPExJ3x0/TM/fD4RdhYDS','BvzbnjsUc31hVw5A5MQpZs7b55LGe4473IyMbS6hZ1sQYvhdO1YPy83vowUh','62ZKzMMJvoslzPx2VdwMIBJESe88XLopsE8uUffpdzLh5Gi5MgNT8vXsOSj9','2018-07-16 15:01:13','2018-07-16 15:01:13',NULL),(55,NULL,'34999742391','$2y$10$SaqpuBkvWJdUAhipdKlv4uJJQnFm4Aw6vyWOUK9qEE8xYBTmOflC.','fpKjcpZOyg86smqX154eOqrF942K1THyLlV3WKTu9EFk487RlQSMnoxWLA6I',NULL,'2018-07-16 22:14:39','2018-07-16 22:14:39',NULL),(56,NULL,'34999742361','$2y$10$7ILkLl6GGLKlNmrfSWwUl.9PPHzOuoKaJDQ/AqwUcXmErnmLeh6nq','gVu1IfJNTIhCOk1cPWKTjVQMLgg0qRImG3nT9thUJLNHkxCP7uPafcwsKaQy','pNVUrgCbEY6Abp8jRZp5K70UxkLr9AxwvSJD6bsHmJkxbs4vrh63cxLsH2rI','2018-07-16 22:16:31','2018-07-16 22:16:31',NULL),(57,NULL,'31987318913','$2y$10$XPQdfNZ9SQiqzuZb4NodHunUlzjB4tGegvEJDxOQ1Ovtxmt1p0i7q','jaOCuutrnU2QmH2vcxttdApF9dXcB8ysukDIoFRugzJvqm1qjcMtzT7pATiQ',NULL,'2018-07-17 13:52:56','2018-07-17 13:52:56',NULL),(58,NULL,'34997632293','$2y$10$4gQNmUpogVNCWhgDKIiDrOtSqv0DUmqsKkRu8XtpgbZQrG3aNFdAu','l6ep416pSrF8OEVagh0DrlgjkeX5xUYRHKeuggEZncNFkEkcNcLKj864AZfN','IVxTkTOcDr8u2sQWru9a6fF5q9AA4BHcZCA2v04FqRkBqSWx0BjOFadZiN5U','2018-07-17 18:08:29','2018-07-17 18:08:29',NULL),(59,NULL,'999768272','$2y$10$gpsJ5gK6Rl0BqaxmEFEDhe7lhMME/s3RWiWbrB32X0flsCn/b4E6G','prn5RvCm0OENLcP52BKxdVrNuXDbqT2RiPLWlF8nZS0d0LGhAlsb32Rx9Rjl',NULL,'2018-07-18 15:27:13','2018-07-18 15:27:13',NULL),(60,NULL,'34999768272','$2y$10$L6ONUQ3p0YNRLrJ54SZtk.XCuHu.8/pUvF3S8rDkb1IT4nkDFscXO','Lo3yUlQQviuoUJoh7uzAgGZF7phdqVM8QjdZe65h74b9AI8BKytXEQW2uL5u','ZgtSOkhEnpYNWAO4wG9wY4uF0HHvUaamSN6yD9BeSo6llquAIdNTrMrkgiOl','2018-07-18 15:29:55','2018-07-18 15:29:55',NULL),(61,NULL,'34984062787','$2y$10$MvFAI37o3S.Wa3VrvUCxpuc/T9ilEiBUY0jxD5oCJUKppG7gXmUbO','QSxei7vwdxymWfhVaqMzM4N4qi0Z4zY4RWAl3gxAdR7tvl8MWROG28ZpHIOj','l9SyOz0C14acUoG5JMdqsJktPYuFaFZOVCe5qrm1mSCevbTZqDMT80MeRDDJ','2018-07-18 17:27:04','2018-07-18 17:27:04',NULL),(62,NULL,'35999147468','$2y$10$485mLCguo9EQPxLp.Pjf4eeD8hMqzTk33u13xQuKrBqdVxxpmHmUi','8WAMPq81dn2Z8uzXmpZG898850rZ4sH4bIW4aRq3DcvpRI2xeOpIqJvBBv3Z','cjdbGAbhzBCX9mlYDpbA2I4vVy3IqZXik8X0MQXz8jNl8HGL4v9djeTrFdBf','2018-07-19 22:28:15','2018-07-19 22:28:15',NULL),(63,NULL,'34999693787','$2y$10$QK2ABWvLtrX4I2x0vszrMujOGjyHqNeCwLkf1uQXMO0F/OsJa4Qki','LMpQFWeX4DfnPYDTDOkCrLGp2Xxmecg7Id7hIYMRnR2phOy3AbVHLdWpcjvX','3n53lSoDpIEoljOvjaQW2GrcwvFswaC7QC6cy98zF4847A5zLLqizw775aty','2018-07-19 22:38:56','2018-07-19 22:38:56',NULL),(64,NULL,'34999740777','$2y$10$Lxc9Ie3D.EcWsE/7aWPv/.N8KcsD/TWvJLscPUzqwC6JxxAYHILjK','60G8GEYXOkpesO4LMc8gmQX3koM4FumPPeklUJLU9FJGEG6qjfHyrCIp9App',NULL,'2018-07-20 01:55:46','2018-07-20 01:55:46',NULL),(65,NULL,'999740777','$2y$10$G6P8vMHMw6g1VxCNh.4O0eWIdR/Ubh4/j.1.oktpv5eOhfvcSiq4u','woxIT94SvlnNjLd3y4iICTN2H6Ucjh7nz1tiy0HBGsbMTyAuuw7m992CZG0x',NULL,'2018-07-20 02:02:58','2018-07-20 02:02:58',NULL),(66,NULL,'34996578020','$2y$10$deR.4G.eSCtZYL5ZFyR4z.GHykxaDjJD2RGZuOwP9p.mQ.8E4TVGm','7I7GkSGNs3HHdOY94DgBBAXJL9JpI6N8nbU9eiSOY16ti5XhETAOoWHhjhXo','yLU4gnXgNQtDLzndFYxPUf7aK9OXw1XhQjhZGC409gHh0EdBPwxci2vWbLkY','2018-07-20 13:20:29','2018-07-20 13:20:29',NULL),(67,NULL,'34996738272','$2y$10$7dJ/hLWSYqEhR8a5XgIvmO6Qe1NmMpsUfxVblBTfCO2BnkfEaGLYe','X6qhuGAYDbVFROOKLGzFqSTXD7eO5AsJp7O60YiyPNCAoipa9ScVjJwudkTk','52KLyPcwbOd7iwRsZjEtL3brNXCmYqHpcSupz0MEXSwVmOecz08Bg4lO49TW','2018-07-20 16:07:52','2018-07-20 16:07:52',NULL),(68,NULL,'34998855752','$2y$10$oS7AH.xcJriE4JxPPsWbmeWK9c486ju9B7U1axdDUzWKcZGGw7Ny2','H27V8QCeKTqF8DecyNAb2uhTRNO7bkBT3FcOPVr9CRant2sN3KzYfsCVCp6W','x9ejQo75arOTOdEqqVpCu1bBdKydFOezd0bLUSUlSqNzoc9Ql8UUGaHplFpD','2018-07-22 21:31:12','2018-07-22 21:31:12',NULL),(69,NULL,'34997965459','$2y$10$3JxS2L7cHVVzrcrlfxUwSuBEHK3yfjN07i7IDIEipMWffERrJGUAO','JKSsfSvdaQXKjMKPHXWUKp0WldSomgr9vVE2WJYtMTGaksORDJqBXuGh6YY9','lcRJMqb4HeieOr7LUqxUi2EDbCOFg89YmjJTCI2K0MMWLol9j55wfYmKCPMe','2018-07-25 19:51:57','2018-07-25 19:51:57',NULL),(70,NULL,'31997936151','$2y$10$5UvlMnZXDIa7tWpfY39wk.59zrzPmF2sTPj0HOuI7dsNwG/niZ55S','0qbH68GeZLM5a1sbM6WYR8G1flhHlQ7bhPxLdFHP8YFubjFaCbuWMz5xgq2F',NULL,'2018-07-25 23:48:40','2018-07-25 23:48:40',NULL),(71,NULL,'992349542','$2y$10$UNf4J2CblrUOk8ZInC.4yuuE8TYOW2iBjWkLaR8MhPABYSnegNkPK','5Nel6IbcCHcDgqxDcfm9U6ufRu3dFjPdOxrXtqGCpMY5TcRcZNdxcdnS25EI',NULL,'2018-07-28 15:09:59','2018-07-28 15:09:59',NULL),(73,NULL,'47992349542','$2y$10$0XTefBigLKvGIuLzqZafFOzEHJ3rkjwrevVJ2Hx4RhdnTRhaJsAy2','N5xb0JRroKkvGnI3BTyGUF1lEwQYd01ecTDqmrWymBx0PrPtCiX6IYc4S2JA','tWXAfiRYSFouz4eeV1p7mAI1EVTR1JKdVt8d8uRLgoNw5irxi7WRZi7if0UX','2018-07-28 15:10:52','2018-08-08 16:53:52',NULL),(74,NULL,'31986461077','$2y$10$3ddehePxuwkhQpXId8yzkumCAt7XnRj0s98YnRnJdc.Qh3FgwoAz.','pjOjdz9a7yxuv6fmeVIHK2hWJDYoz6prPanqW8w8wrqt34s6ickifZwfS04q','tZzldpxymWWipDMNhptsL9rjXk5U9kFm8K7CdCSMYCUUSf1lWDuP7PNxEkA7','2018-07-29 12:53:51','2018-07-29 12:53:51',NULL),(75,'jorgefjao@bol.com.br','34991558346','$2y$10$7S2RN8mm3/Le5xQC1M9Ni.dNCgNkR/lKcyKCM86LeMIU0YjJXnpIS','Z9iwLR3QcAp6w7XMg3bmJPcPQJLCY3hdqERKNNVbiGIuRGZ3nNK1IQ6eyC1r','9zR7DuXdERhOqBhlJ3afeofR4tJpzWtEv2QYP2hGB8hCx6h04sWjTA7QJf1A','2018-07-30 18:20:29','2018-07-30 18:32:19',NULL),(76,NULL,'34999776868','$2y$10$5vwhbDMd6IwlzcpRu1sEiOTnmu23k0wwU2Pz4.7EzWlnxhaprnfhm','vaaFYO3YwryoSSIQ085qY3BMKw70Z6smgevH16rmdut84B55F7f1gAvunocW','lVLb1NjlAZCd6dGcS2FNexFgzy777OLpcG6AhqVxlv9kDZtaCmm92OIeAAv8','2018-08-01 11:36:12','2018-08-01 11:36:12',NULL),(77,NULL,'33999138073','$2y$10$5t5uJXyFJJYFCXjgsPYDRuwlY2JtaEIKT9pst3WNYY9KV7js75Ury','okv4IhcpqtB3flMfyOHjYFLMh2yyTnvBr94QiPKhUiMpuO0SsHtVfUhRaaJs','oWi4JYHM5Xa00qza02cFcsl1BWvlpnQnsVWMg8CSMwHLvDzHm7YTiRBOCnij','2018-08-07 00:59:05','2018-08-07 00:59:05',NULL),(78,NULL,'34993198430','$2y$10$jFJrsf5BJBUIOANzMKN7AOxJR57BXO0vllSZUwc7LLQxPBP2ci7Oq','pdfE4W1LrV0U605N61fa3oGji6nVamNkNrwWoBrNbF2jO0Jtg3RQJLgjxHA1','Du1i1Fy7HX80SgzBfFrtb80Zitepn8KWlgFvSPiSsupXqPLZKztWXbAe6ooS','2018-08-20 21:46:15','2018-08-20 21:46:15',NULL),(80,NULL,'43999251122','$2y$10$oPjKgQ4WvajLnFsvRLc2YOXKvxeY0uwku4B52TUSllb3cHcIXp.xy','miQvwlPzgep3lehpl944OBtDSLamitu6UX0HGcAOOePZsnD7u7W5eXrWGNNl',NULL,'2018-08-21 02:14:23','2018-08-21 02:14:23',NULL),(81,NULL,'17981151056','$2y$10$Xtyjs8IgJs.CqGw4e2A9w.8mAvGT1mZO2bj9ujY0RkwrSiHqzK5je','WE937g1GoMiND0xUeJFVMrlXgOgnTL8YGCueqgcBOXz5e257ANpfQhKwWKfc',NULL,'2018-08-21 08:08:16','2018-08-21 08:08:16',NULL),(82,NULL,'16994099889','$2y$10$ANFYbigL0hyFKZIQC4FgAetCebe/VOXNrOQio/C/oFAHRPknpvoe2','Lqncj6jqgdCJ79KE6GoBF1DsFmrd2QSDtXPz5DIgbN1eQhrKBzvYkOVzFurA','Gw0Hkd0VeX1ANaZZrSbVchSVdf9qNot4okGPYYv032UhfhMXIs9GPnBjt71A','2018-08-21 09:58:46','2018-08-21 09:58:46',NULL),(83,NULL,'034996630345','$2y$10$7SlJvjBDrU4tdxoDQ7VeReMfw6qFatnUWosIS611VwcIQorcCX2he','hKtjsop7wsq0Q7NjibnYU5GVL8jVWgTU6K7aypJgGe3G05YQ3zQXn6joRuev','8QMKjSMksXk6C8jNOF9nvaeDBXm5NrVAIDLi6JRF7mIGaM10bpGhZ5mbdx2q','2018-08-21 12:36:49','2018-08-21 12:36:49',NULL),(84,NULL,'48991363340','$2y$10$ctxnjKWTI7T8aJwHY7Ouse4Gbu6YnwzOwZ3fEwUvdc5kR0rGN37vi','B9jzjdGqHgMnGOL6HSrseM581YG6RsUCsivrh3n5rZitvWwwwATbvZe0cSok','iDPAQGp9Chvw8AzFh4DvrwvXCqEaLOpY7EsdCusM5E4x74B2C7am9VgN2ZTQ','2018-08-21 15:19:10','2018-08-21 15:19:10',NULL),(85,NULL,'34999749753','$2y$10$FuSoqH/WCLOKfK32DtU9getW0F7e4VjV6dFdpzYsPWjZig0fV683m','qkpKwJ8rLULfFjwa8pg4UTG54pzdqtBQgNLHj9SUPA6Rx3E56wms3q01P9rs',NULL,'2018-08-21 23:12:04','2018-08-21 23:12:04',NULL),(86,NULL,'3899967098','$2y$10$8vISnV70QBvgmPUmH6Otx.7XGfhuicb4Pq642rPCSuK6yF7j51Psy','aOc6jAxLiZnsT9cYH8BdfPXTgvXwrwQdYCAgJVpzw72FbhiPdVMJLQ2H7rPk',NULL,'2018-08-23 11:01:52','2018-08-23 11:01:52',NULL),(87,NULL,'35991024112','$2y$10$nK2dx6x7KB1oiZtHaNYJY.7DThyOmVeVpZ5tEz8viHjJV4DzdiPOC','mYA6dm5C7wIt6rTe1HgC7trFWXxe7tcJh4E9YHLFYdWT5kDGZ4CB7b85hSt8','94PAJ43FBkWWaoMNQImchCvDKHbVhlkHdpP3UUwZ0r9lA4EPTYcVgqR77riV','2018-08-29 00:38:21','2018-08-29 00:38:21',NULL),(88,NULL,'01577999712461','$2y$10$yPy9tPzmxS/lA2UTe4j/neB57RKNCbk8EYONgoMio0mHhJ1Wpo.Su','CeAcCXZz4noSpghixjG0Hv4OKbr1GMEMEBe3GsCYZTp38suTo4oKBptvpf6r',NULL,'2018-09-02 23:37:11','2018-09-02 23:37:11',NULL),(90,NULL,'12997998898','$2y$10$McoGkAddVxG3sj9mwsbDI.tUorg87nEx1k8GPL87BUwsDNTf8DA7.','pfXwh7mDZ8FsxecqEccgfFEMmmPFi3mRFkHK0SigKmzSSJ1gE0833QzRQJ6I',NULL,'2018-09-05 16:32:09','2018-09-05 16:32:09',NULL),(92,NULL,'5512997998898','$2y$10$d7huqPQfxIG55vCWkq/3K.9UATMSQPUMvrSgrire3dVjzBbKJdBhG','9khD1RRroNxMlqeQnLYHPgiEAiNbFKFWQJlq35pyR5Uxn0azShUHGjets37f',NULL,'2018-09-05 16:33:51','2018-09-05 16:33:51',NULL),(93,NULL,'34996725285','$2y$10$Xd53iZy6ECZL.0RGro9JBe4khJuFycz2BxrJ3CCVkrwcUnC6Cs2Pu','2LbaEmrLEkJCZb7RBNOVissT8Oy3njyACrUAJBqWPBGQakBpLCjg9NTeJyLZ',NULL,'2018-09-08 21:57:56','2018-09-08 21:57:56',NULL),(94,NULL,'34996890144','$2y$10$qSTy43lx51rXbyPwyQELXOZN6tI6kG5hiRIJv2oQfY1ry6Ax1spK.','5ozXMpiYCzgtEvlZi6q2uyigMDXPCMU5RrJ9PQArdw9x8F38hSFkURyIXGqY','XOMi0QnMXdfEXqnDvWgFBmFwdGdEusX3edLhdmJZs4vSOO0Ky3gBscB2dOic','2018-09-11 12:51:15','2018-09-11 12:51:15',NULL),(95,NULL,'33999897669','$2y$10$2UNHfCEsCADqbq8qHxpLcu2CelEyHQecsXikNoA/NsQ89kNdOS4Ta','KQmjESnsFaKCsyLyP76KTUajMZPgc0DK7JQU2zPvhlhDk4ZQydbUDNYpGexH',NULL,'2018-09-19 23:00:11','2018-09-19 23:00:11',NULL),(96,NULL,'34992156546','$2y$10$9NrZsdVjqDTNdFrhxn3yBeSJ.JaMq6tLWzp2WUD4reub9LD.CxfNS','5czzFsHclpUnv7aOLbohEFRdmBmIaHmr950aTwGjQDXywtfAR72lSBz12bk8','2lEfWWz3g1SXSgW2NDgu3rZL9bodoQWDnHaiCXRv2tafWTtAsATQfks1Mnqg','2018-09-20 00:12:40','2018-09-20 00:12:40',NULL),(97,NULL,'31982622466','$2y$10$5L5P68lT.lAFPRXzx7lYPuJoI5Jjk.LigvdI6vHdTCRTYWixI0OWG','zcPucTs3wMGKw8bXcmECH3urjOvUU4sTaKRAlkcrpkah4TUltUJOF0APjQvj',NULL,'2018-09-24 13:02:22','2018-09-24 13:02:22',NULL),(99,NULL,'3182622466','$2y$10$.ovQupV7wvxEfJ7fQ7kBJuSEY8eCv/ONGWt5lBSqFvUMRIeYK3Fui','bkiflzUQGztXECgtk6OGQREAxkieLliRcdsDNfH3fmVRNrh82KTh38wAQOfY',NULL,'2018-09-24 13:02:39','2018-09-24 13:02:39',NULL),(100,NULL,'51981419936','$2y$10$z.z3bPuF1972D86zZLkprudPDv2MjgWAZu5aCn3/h1TfMb6NKg6.W','6mqnKpIhFj5owEWQwpEmq6YaPtNL6ilUwakc15rRdNYTGUog7Qgwil1BViXk','O4Px1fVkwUCEQYMPTGwlQNzUu2ENWcFWKne9pfDZrC9hzKfyJw4SOOdXg4c1','2018-10-02 21:40:40','2018-10-02 21:40:40',NULL),(101,NULL,'49999492953','$2y$10$O/ysf1MKQ579dNewXLTAcOYjXsD3gaWX5LhmBIZyCVosWtR3.c8li','bI9SnrTxkSNdI7NSvf76RnGNBEm4TrH5pJKUBgmGAa3EjqtD7tOiI3zc41il','dvBDTmEN5JRx97KUmhvTJFhGdBt1bTUu50231uTBmORW6nrEqwQhuSWRsp9J','2018-10-16 02:07:47','2018-10-16 02:07:47',NULL),(102,NULL,'31971538206','$2y$10$0UPN0vYSchl2N1EUIktpJuwoOdziU3rDxZjSBJKULjKvj2tjWcuSS','gXMmNQf6EmtfFq13KsAftjZCFluFbAEkL0Mul4nBJR66VcCk7FWUgdpaILv4','8nctLaRk6gqanwVIOpHKh1n1IXhk7I7detfVvSBYOr7Pme3BH5d9zh1IbadV','2018-10-16 11:50:52','2018-10-16 11:50:52',NULL),(103,NULL,'34999768160','$2y$10$EKnvOJ8dmY/iLAtR08bQAu.aMqJ6CBpGhloGeDiFT7stEOC35eQ/y','cmeE56SZcwMbHbYSrrPCOgid8XvRCRaDyLumGwg5K6sTWhDn4sne6hYCUvbm','eCt2xcUCFTlDrO6kIwZZIVPOjQpTQGnNv3rC95kfwdJOG99GyHzI82FBeitm','2018-10-23 19:30:52','2018-10-23 19:30:52',NULL),(104,NULL,'31996150415','$2y$10$g/.8gw.3/XqBLyd9J8mkKulQvXQOPMpGVnUVdIIkqJXEjaBNHIaSa','elY51C7xQ6wNCRP9nKMjpuj5Y4OSDeKAFy0lfayIRkKA7E74ufmfHrl2V0Uu','wbUgz9zRoPC67BnIupMrVbCyDFPUDu64sHmuSbJa3EebqAUWWuuxX203chHs','2018-10-27 21:52:53','2018-10-27 21:52:53',NULL),(106,NULL,'34999176227','$2y$10$SzgIFAHTGlL9N8spvAWHAuBqriJWPpkRjX5755.7BiDxlTOP6O7HG','eh0NqhVYdDWMpegOh2wnpBnaSWHP1hFgo5mxYhQvzRq06Fjt3LkcJqF1jJXZ',NULL,'2018-10-31 13:22:38','2018-10-31 13:22:38',NULL),(107,NULL,'992426887','$2y$10$kZcykRoRKtu1Pk01zJh6Y.4xvwarhqrxC4MnOjP6qIkrQPc0GYvbG','UnmrgVyR8IvGWgv5x3F74NjiShxaOyqIC5Mm1klOH5u62Oi5WGBE67h5zwnM',NULL,'2018-10-31 21:18:39','2018-10-31 21:18:39',NULL),(108,NULL,'11981199316','$2y$10$JMwd74LpO1v7jilsCjyMN..Sml8YsXULoHxJ4TVs1hU3U.C1vxdhm','6oUaVx4mN7PMomNPFb8CC39pCwNNpAifdctkeT4KPiDbQz3nHH49QiCih8sE',NULL,'2018-11-02 16:33:46','2018-11-02 16:33:46',NULL),(110,NULL,'981199316','$2y$10$BXdbWGbpAjJ946eLfYYj1.MPM8OYMBi1fWYrrjyego9cIbsehXP9K','iuNPWt9HvkXRYGFWOzSHGXJk4gLNdDoONyZMv0ge64m5DfsxvDUbdmuuVHOF',NULL,'2018-11-02 16:40:59','2018-11-02 16:40:59',NULL),(111,NULL,'+5511981199316','$2y$10$p5yCaaIr8Q09R8d/HQzPhe1NGZlhw.B.kMY9URXart.TcE/Y3Fs7a','icEP3rh469EwJ4erbqJnOUHkYYy5pTwDQjssQ154c2gBjhZZ8h5RygXPlZcd',NULL,'2018-11-02 16:42:10','2018-11-02 16:42:10',NULL),(112,NULL,'34991724004','$2y$10$WqupOSjmDd8ugcEF/BBhbexB/KGPJvOUQG8B6f8zToa7.rUecPDc.','qVVLkyOEOoGfYsLFNQ51WsDqk5sVw0uBi6zWcU0Cj6rjEB76fX0Gind0vfGN',NULL,'2018-11-05 12:02:34','2018-11-05 12:02:34',NULL),(117,NULL,'21981577838','$2y$10$YFPaDZhiptPjq8Lqah7QtudWFPIJMWEFrmvyuu4Q/BNVn2t/.B.ee','jPpcZvOQIxOQLLZsZmO2Kr4RvkhHmRWOd6CJHJrU0wikcIaIYmO5HKY0KPhG',NULL,'2018-11-09 23:25:58','2018-11-09 23:25:58',NULL),(118,NULL,'+5511971272309','$2y$10$pEixuRj21IS7PHh2T10D2uO7coVX9Lvh/aB19I4hWdkOm0hMkZmNq','H5tnTxuLylRZmKifsjF1mGpaAcYtZfwSEf7XCIzffDoi0K1uT16f5C4LcBxx',NULL,'2018-11-22 00:37:22','2018-11-22 00:37:22',NULL),(119,NULL,'11971272309','$2y$10$VIshBJwI69vmXt5QkuSH4ulDxXb8zcV9QQZXXkbycQloVboqAW.me','EcjLrt1FTEODQVbfN4Gsf4fLz9NhaW1YFcNrMdCbjZGl6dfTrYV9NWhxS5aR',NULL,'2018-11-22 00:39:13','2018-11-22 00:39:13',NULL),(120,NULL,'3598851605','$2y$10$eOoPi92HRrMBSieOGo0PpOL9g82ZV1RJFSOwzf4RttUoqswiIVK4u','QXybdvFu17kAxfk269o9YTdLUHUgyL2hTFvygBzT8uEKq9LwJEdM7sLwu9U7',NULL,'2018-11-24 22:58:13','2018-11-24 22:58:13',NULL),(121,NULL,'31999637992','$2y$10$6HaVEjCthCxc0FnHhPRvzuyKK8D8Jplr7T.J2axKCZfJNqcxpWRA.','x2N1LfFFPLnoR9dyj8NhFVfHJN0WQCFk9ecVuV99eqH4Jyq6bSbFdcwznfG0',NULL,'2018-12-05 21:13:09','2018-12-05 21:13:09',NULL),(123,NULL,'12996072907','$2y$10$hqxjh1TdvmUpPHTc2w6dVebBRbzoEJJhDsdpZQmRJj8MFMSvkT/jK','MS19bVUkCtVUqfngZwOHRtKSJRUoYyVJzKOzIQS2VVW1ALkgArLlTU5U37Xz',NULL,'2018-12-10 12:16:28','2018-12-10 12:16:28',NULL),(125,NULL,'17981812000','$2y$10$pYsvR9d5cqHvQ/.D6UqXw.khdaKVaNM67vWEGyiBZ7aotux4kWaqi','SgCimSGjVQELJQ6OSzFKe8laZWruTMRpyQM0S8RLzc3lMs14cqHjzcmJOiy7',NULL,'2018-12-17 00:18:37','2018-12-17 00:18:37',NULL),(126,NULL,'34991762598','$2y$10$c0InmH4hAgzw/BQzL2G00.q6XsXIuUgLlNnBGuYXudHjFspY2BlpO','JcpZt5axxcTHkvsAYtQ4zJS22asdNCKS4R6sUMrqbh2UIjuyY6syVTLX31PS',NULL,'2018-12-24 21:24:27','2018-12-24 21:24:27',NULL),(127,NULL,'15996589825','$2y$10$fsEM5Neizx9VFiEKXS/0sunYulytx22cKS8fEcamvBHqoQxo3Fsp6','cfclGy4KDrouCWsWALgQMj3QRPGLwv3SlYTeCgclojEv87fLpPm4oZkoKLqJ',NULL,'2019-01-06 15:00:25','2019-01-06 15:00:25',NULL),(128,NULL,'986722992','$2y$10$9mwt5dHIrylmNZjll0WZcOIjAbMdxRYqpa.kVdsJSCbr0YdqZ4PIW','rqmoyOfv34PeVWgDEjC1667MDKzYclcAJke6VoyBZhXwyxaYyBYs3D6XoDGN',NULL,'2019-01-11 01:15:02','2019-01-11 01:15:02',NULL),(129,NULL,'31980180888','$2y$10$nhR5fYDn6WcyM7V.YWEf2ecPZnk6JfFV3FZ6UWSDF4sm0HP/pQJBO','4bqBGxwdPM2hjuAoUq0FV28XuHhyCsSrUBcI1SomK9ZRD9CJautgLezms5iY',NULL,'2019-01-11 20:47:18','2019-01-11 20:47:18',NULL),(131,NULL,'31991842725','$2y$10$4OsAMpLEU1/Uf4xcu7d/Xuy0VQmVeS1CoxmD8ziTR2NhVlt8VXMe.','RowP0GyGwo6KB7cPNMFKaSNF2Exwx50wjqYamWEqfSfBYGESx07ohtdPfNe5',NULL,'2019-02-11 12:43:26','2019-02-11 12:43:26',NULL),(133,NULL,'35991154148','$2y$10$esrHFdSSZJbNvTVRpM1XpOt5twbyK9rARpCKLij1Qu4MJYXGxLReW','ViGLhVRT8b95u32ZsYy0jZ5ANXLp9vz6FGEKhn1x5WIH9IpMbCyWGQ5or79I',NULL,'2019-02-14 19:11:58','2019-02-14 19:11:58',NULL),(134,NULL,'35991545181','$2y$10$e5muoyxk1Bpg5qZ7mL19C.op.TBDCWv2NDrXt8CDrZnr3bjxktzG6','UMoiZe43NEU3qKO55rT2rTjNs5TaskkHpAMQ0BedyNYIVerOfovi2cituLaW',NULL,'2019-02-14 19:17:40','2019-02-14 19:17:40',NULL),(135,NULL,'+5218712771651','$2y$10$DYJZhhS2eNGiLvJJ/yRoZ.38Nxyvu371F/GiBvFGmL///0bz1LoqC','IOWkbHH7UBW5G7aORW06ppeeRKoRAwxyjEMpociWpDNwJpocfxXwvJj8ghqx',NULL,'2019-02-16 00:21:40','2019-02-16 00:21:40',NULL),(136,NULL,'11981812306','$2y$10$Mx0kPHvyxjMy//anZ3qh8.K1jI5yL8jZBYYHvfHy3MgDrVgtVoTTm','zZW4nY92Cez5N5tCVfYRC34GCjSXms99g18UuqszblCrIPZNoXqfpTwiOuVy',NULL,'2019-02-18 15:58:56','2019-02-18 15:58:56',NULL),(138,NULL,'011981812306','$2y$10$VgFlqayswroY2I.FPaHhW.r58d/CI0ewMRG45J3EVNEOAyUeUlLCG','y4LMn4D8BCV6yIwxKvqQkVBrtdEhAqWU9SyENZQOcte0POquto97IDqLUoqK',NULL,'2019-02-18 15:59:07','2019-02-18 15:59:07',NULL),(141,NULL,'34999743503','$2y$10$gh89UjVHG4ofL0PcSvqaCeM6go64a7NZTShIPv5UNMYt0sYKsSja2','jgGbswHtChsE0GzbAfxk7C0jfDPxfn3U7UGMpnPTitDO38C2LqhRnBczeC0W','vUSkerKPKfqz7CRrwDn2uwhhdxX0IU6n3mgetaEAsV3wy6MB39ogrkQEmIXz','2019-02-18 19:32:10','2019-02-18 19:32:10',NULL),(142,NULL,'34999749795','$2y$10$xKg7OZmODX7zDKPEcRiqyONt9v3NKXjntxBYCk9E6P.H5hcMFnRWa','Pfj4WTrBE1MvqA5v1XFcqZNUvIQ0l6FlfZbpEExGGcKxpoVSa61Uygt4pelZ','wzqXV7QPXieydzOfcs1o2pxL9suRBtsciAennocDcmMzMePIppdhyrMaN2Wv','2019-02-18 21:44:37','2019-02-18 21:44:37',NULL),(143,NULL,'31996941300','$2y$10$HH1USC125enpReCE.UN8H.PFZTc438BcnFaI5c9j3VNjBCiK/7E5m','m4snfH4BZIVS5Lh9lMRUXAPMW8wVGMckM3FbgG8TgRf7hgWoP2PqbE52Zstm',NULL,'2019-03-11 22:38:21','2019-03-11 22:38:21',NULL),(144,NULL,'17981739089','$2y$10$8qi7UPNEW4dDIewCkDTi5esNnV8LfqLfjz8zM/olc1MYwx0QIcwNW','yiG8GhiKmSsqZy6hVgwGlJSYr8UMCbdrC2hpOzeew4V16FWKy3g74B0cTQpd','xkukNXYHfAyw1ulAHXgQGXMQlZozKU74DEr4INEYBG6rXNLKXMX5qHQgU08A','2019-03-27 20:00:22','2019-03-27 20:00:22',NULL),(145,NULL,'31025312930','$2y$10$3arTuhdDjAqUhNv5gZ5EIuwjzS2AgvhbUZcmhFq2Kzn6QgcPd1.T6','elBjaCwXSQ1iOq38PohRTVYppg5yO4flp5mTzjCoeJj2zK2pZmivwS3y4cwu',NULL,'2019-04-02 13:57:49','2019-04-02 13:57:49',NULL),(146,NULL,'3125312930','$2y$10$UdiBsputITRF9lufAJyc4eHPCrntCVb1Uzxo8pJ2nv8Tq.Qtovd56','xXmIvWhwywz6UYDx3VnBIeDTg5hQsc4ywjBosw4aBA7r4BGZQ8EO2sCYqNgM',NULL,'2019-04-02 14:00:17','2019-04-02 14:00:17',NULL),(147,'joaocaldeira@hotmail.com','31988882940','$2y$10$xpnAaHDa/Sj8SNpppiFsuOhQkc/HPIHQvVlgZOD67N7QNZiUtJ5Ja','Kde81AePWrXNd0Ue1xPjxvrEtNWjxTeugbJzIIWaNck1HRPTSm2gQR5OuBfb','aP3PuNFGBYnUhH1JdDs4JmvEvtJKGL7kCKY9T7DJWwKYBEBczg0lbkEgf8hV','2019-04-02 14:02:03','2019-04-02 14:32:25',NULL),(148,NULL,'11989753174','$2y$10$hhGQOQuwiyTnOzpKro6y/uqWi6Sf37MEt4.sehL/qsYLqREkE5/va','CysmZV743iTS4ghX6q2OokFAqU4sMekpNL6PVLHaj4xby5QsRVoiebVPyFkY','WkxAyyyGrnNjvloVeWuUcCpFnTHZx8JqhlgimpCupOtJ3waygJhQdlmnvJ5l','2019-04-12 15:49:51','2019-04-12 15:49:51',NULL),(149,NULL,'21973819817','$2y$10$/RizFVfLrp9Uy3Je8ncV9egila3SQzVnJwCqy665U35cVFmTpg7x2','GbD2KS4OOPaUfvboyPAtEyFH2upGOJFF8oo7s3qpMzAZsAvCtqOJPvohnEoy','dfaUH4tblrzolVtRU4SCebQZrhYeEKP8U4QHVmRPLW6CqtHc8BAe8Jh3fw19','2019-04-12 21:13:27','2019-04-12 21:13:27',NULL),(150,NULL,'94991469718','$2y$10$KqK0A/lx715c/W2oM8Nr5eCUHJKGLBNUCzRX33hAImOwXrcwcVLwi','hNRbWiw3FgMmSwb1QzYS8ZHHmhziOFFcpftUgIGAozyHKjNRnozRAl3V3AmL',NULL,'2019-04-19 23:37:50','2019-04-19 23:37:50',NULL),(151,NULL,'34996625347','$2y$10$jRM0.haQjlcbdRjvwVbfRuOvr..aFFO9jkQ0T/ehNzJYQK2O5ahzW','mSstaJ2rCEyL5h6ML8FkvNCihEmt1GUTgzKwOR50f3GZyfkborVdS1qISm49',NULL,'2019-04-22 18:51:12','2019-04-22 18:51:12',NULL),(152,NULL,'91981103248','$2y$10$t580hCdyaxXxa1cqJDZxwOr8ACxR2B3OljMZBbhXVuqRZyYBwXkxe','QhWXgWQaeTG6DXzuZwv0i3iJ3u5WDA02XCs2CLK7dH0XjRuljnyR8hJeod26',NULL,'2019-05-15 18:38:43','2019-05-15 18:38:43',NULL),(153,NULL,'37999350682','$2y$10$cI8PwmuPkTPHyggWRVVhWOwj1mYZ0l9Y8EatZA.z9Ezvh6S59mb7m','Rj88MZHCxm9OzTcAymUtLvrfkDJJhe7nDnnh5EmNeVqbdYdUcGaxPNQKNLky','VpjiOwugDUzVIguLxFMrdesHwu4DsDbfvsASRrmH4AVopy2tovL0gQJXjQIw','2019-06-12 04:33:36','2019-06-12 04:33:36',NULL),(154,NULL,'34991730002','$2y$10$dY7pFBryKw.ecJYOeuL.kevJgs1H0i6skJIdD9vNzk8h2ka4ySqOi','IDgqJGgXze09ekWkfZK5y9OgRR4uKiaz8t1S5zCxfd1EqR3CBIBwe3cMkjOs',NULL,'2019-06-30 00:13:53','2019-06-30 00:13:53',NULL),(155,NULL,'519928871','$2y$10$7j0WFltihWikwWUM4yDcU.vSdGrGoqzPqAOlZLOOKWT2wodctet9O','a5Q0pKkk9mWlB9o0CatgU0yK0liT5FHTdAXUHxnQIhAPRlovYvIowBf07PbQ',NULL,'2019-07-13 01:34:08','2019-07-13 01:34:08',NULL),(156,NULL,'999562959','$2y$10$OQwBcu44KSnjOg32s/HbBe8msQy..WoLK7jyYrzDFBlS5qBpsNRga','oHe0Rw4w7Z3PVo3ddYKNCxdszjDKAOpPdCgdY13ZSOFfdui69u0btZP1HGSL',NULL,'2019-07-19 21:28:53','2019-07-19 21:28:53',NULL),(157,NULL,'61981816724','$2y$10$A/718uk2Tscn0bgTg6S8X.wmFy2zhStb479k3KgKZvu7q4hD3zwCq','T1DiOWLiELUMvOBiAMvJmJW5jIRUbMxOTPhFpvgHJF1YP09W7pJehxlH5dFX',NULL,'2019-07-21 13:32:57','2019-07-21 13:32:57',NULL),(158,NULL,'73998712809','$2y$10$OLkWZEUboLJfDqUZBh7dWO.rBieTUPH8vhfKIdTOCS/Y14GUugex2','p70c2PMKakDIRTwlGag1MwAkt7yr0ZwSuhRrdNOGqJhWBws7yoMI4RBbTKP4',NULL,'2019-08-15 12:54:37','2019-08-15 12:54:37',NULL),(159,NULL,'44991537691','$2y$10$mEzwbwunm/sSFhK/qp9om.9e3lKtL8ENNn7FLk7RP6xD9nqrQo7mW','OzwOAI45ZE8fxgvWBy5GAqjmA9uYnZS6yqfPKzdbZGvMpRxXoXYGc3fY6E2P',NULL,'2019-08-25 19:14:46','2019-08-25 19:14:46',NULL),(161,NULL,'991537691','$2y$10$5EbRCIgMwjPWWLaHHAJrceR4Jk9/RintgVlZwoRtT7KE7KshCWY6C','zuZ937yOzMMKzH55LqI6Wj3c0tBwZStLPJ4kbDPSRXBGm1rxmZFFXdN0eWut',NULL,'2019-08-25 19:19:17','2019-08-25 19:19:17',NULL),(162,NULL,'67982142559','$2y$10$3pfe9xo8i9byfr2DawliieYvsUrHi6iJekZyfw1hSjI3rTwyVLlsS','rye1OwiB3P2iGZgvqFlGLwYi0S5YMuLfXgBMSpL7Xq6HCLJPJBGcfMNG2M5i','35fmSAwGlbcUBFwe6B4ELpxLT0iD6gtKdBtiE0aG3ckuw6VvLJOfhnD6ob2X','2019-09-23 15:30:04','2019-09-23 15:30:04',NULL),(164,NULL,'17996259288','$2y$10$axG0/sBko0XyZxenyl/unO1V8H8P.3O5ey2jFW65XiYyR0U/iFFVq','ARKz5it1KkrB0gThYEee6UHhUViTeOHWQqMR58uJPTtBRrr3qASxnjEeWO9v','5YKaSzKshOwwu0BSAhb3FvBKijtI9GpkwPOMSy8fZyYlWmvi4Sf7uta7HuaA','2019-10-03 22:39:28','2019-10-03 22:39:28',NULL),(165,NULL,'31991841762','$2y$10$KyhJcQ5l7MtjcdDk1ypBYeWUEf83/QGiN5xzDoOFtUTAyYezapRIm','1GscATWEcvlrhNSUsA4te7cSst652dcftAd4smMpiD9gIRsyY3gYr5jVVxEB',NULL,'2019-11-24 19:16:33','2019-11-24 19:16:33',NULL),(166,NULL,'55159979388','$2y$10$2vJgHgYQSjcAS..3SYJkhOrD8XJ2S5L3B1OeyetRv6lbsDW.wT8u6','kChcZslOkig09Ff2MhhlRLPmU0cqQEfRu7ifDX3omYiI8bpJiz3ZBujzzX9r',NULL,'2020-01-23 15:15:38','2020-01-23 15:15:38',NULL),(168,NULL,'15997938816','$2y$10$9XIC4fVy5dxniXC1JA.yUuQoXniS/96kxYqfVB7nwnqC5trJ97Mpu','D925aXAGCM3OMjiKgb1Xw9YZ1qqc711p4RZuiC7qDrw6JPE2w4Vr2Lif3iGZ',NULL,'2020-01-23 15:21:32','2020-01-23 15:21:32',NULL),(169,NULL,'21981572470','$2y$10$TxeMIKGjXVh/vORNQZRYFOibpP3KFS7/ORDMYDPZCDeibQg.k725S','yb94kEFeBTivmLiLYZUswTOtfvdKCF6dzddsGQwSgCkV3fx9biS5bs3RSCa5',NULL,'2020-01-29 15:36:25','2020-01-29 15:36:25',NULL),(170,NULL,'31996118861','$2y$10$HmzizpekPknn3w4FVWh4uuHiBMvt7zaOYH.oQlu9R/FlwuKb9rs6u','JwCGUBrYbR0ju2BpVh9YoF8WM2PJAl1pyrsOzAQPDrYXK8MmR7cOn6HLgrYx',NULL,'2020-02-03 13:58:30','2020-02-03 13:58:30',NULL),(171,NULL,'21987604609','$2y$10$kj.tVEM9id/d3wpJ1dfqterYC9j2RBwbxwkkjK./PbWE8WhYBLixK','VCzVAyQnsGuLjtAdTWoRsB7b5ZMre14OV8mI7ToCaciqLNCs7aQEpUUuizri',NULL,'2020-02-24 16:22:28','2020-02-24 16:22:28',NULL),(172,NULL,'35999711704','$2y$10$mkCXRgMGWU8vwofTWTKqUu9wtRf6Budcs8o7p6rVMoHuC6rdjzkUO','4OIyDRRnEKbTUOxlBge1DyAQKQeEO2gRFrnDz98EuSNzEycRGBxxXoGkoioc',NULL,'2020-03-02 03:32:56','2020-03-02 03:32:56',NULL),(173,NULL,'31992166443','$2y$10$EKub2fws5edf18FyxxCKAuELKBpMFuO91tG3Vwe7cceACGZHPyRta','QGA1ZzrscMoMOf0ROgBFjNvX3O7ACfmvBYJbk2IOR48AzgsL3JIQ6VqminNY',NULL,'2020-03-12 17:22:23','2020-03-12 17:22:23',NULL);
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

-- Dump completed on 2020-05-07  7:41:32
