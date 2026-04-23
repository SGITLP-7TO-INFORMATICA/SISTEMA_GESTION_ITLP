-- MySQL dump 10.13  Distrib 8.0.44, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: sgitlp
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Dumping data for table `alumnos`
--

LOCK TABLES `alumnos` WRITE;
/*!40000 ALTER TABLE `alumnos` DISABLE KEYS */;
INSERT INTO `alumnos` VALUES (1,NULL,'Ruben Maximiliano','Baungartner','HOMBRE','2026001',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(2,NULL,'Lisandro Ezequiel','Garcia','HOMBRE','2026002',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(3,NULL,'Albano','Gomez Monduzzi','HOMBRE','2026003',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(4,NULL,'Jesus Sebastian','Gonzalez Arias','HOMBRE','2026004',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(5,NULL,'Agostina Loana','Infante','MUJER','2026005',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(6,NULL,'Lautaro Benjamin','Marchant Ortiz','HOMBRE','2026006',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(7,NULL,'Valentin','Marozzi','HOMBRE','2026007',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(8,NULL,'Valentina Lujan','Mendez','MUJER','2026008',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(9,NULL,'Tobias Agustin','Pardal','HOMBRE','2026009',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(10,NULL,'Nahuel Agustin','Peralta','HOMBRE','2026010',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(11,NULL,'Franco Agustin','Piattoni','HOMBRE','2026011',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(12,NULL,'Mariano Alejandro','Ricardes Cotta','HOMBRE','2026012',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(13,NULL,'Maria Caterina','Rochon','MUJER','2026013',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(14,NULL,'Marco Tomas','Wander','HOMBRE','2026014',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(15,NULL,'Benjamin Octavio','Widman','HOMBRE','2026015',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(16,NULL,'Lucciano German','Amaya Monsalve','HOMBRE','2026016',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(17,NULL,'Ian','Barra Colautti','HOMBRE','2026017',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(18,NULL,'Esteban Daniel','Dominguez','HOMBRE','2026018',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(19,NULL,'Albano','Fortunatti','HOMBRE','2026019',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(20,NULL,'Sofia Belen','Garcia','MUJER','2026020',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(21,NULL,'Marcelo David','Herrera','HOMBRE','2026021',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(22,NULL,'Lautaro Baltazar','Lopez','HOMBRE','2026022',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(23,NULL,'Juan Cruz','Maliqueo','HOMBRE','2026023',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(24,NULL,'Nicolas','Popp','HOMBRE','2026024',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(25,NULL,'Lucas','Quijada','HOMBRE','2026025',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(26,NULL,'Santiago Ismael','Rick','HOMBRE','2026026',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(27,NULL,'Lucas Adrian','Schroeder','HOMBRE','2026027',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(28,NULL,'Jose Luis','Acuña','HOMBRE','2026028',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(29,NULL,'Micaela Belen','Barrionuevo','MUJER','2026029',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(30,NULL,'Santino','Basile','HOMBRE','2026030',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(31,NULL,'Guillermo Alejandro','Costazos','HOMBRE','2026031',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(32,NULL,'Facundo','Ercoli Guerreiro','HOMBRE','2026032',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(33,NULL,'Torcuato','Fidani','HOMBRE','2026033',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(34,NULL,'Santiago Ezequiel','Gonzalez','HOMBRE','2026034',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(35,NULL,'Santiago','Macre','HOMBRE','2026035',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(36,NULL,'Lucas Valentino','Miranda Canoves','HOMBRE','2026036',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(37,NULL,'Juan Sebastian','Muñoz','HOMBRE','2026037',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(38,NULL,'Rihana Sofia','Rando','MUJER','2026038',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(39,NULL,'Aldana','Samudio','MUJER','2026039',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(40,NULL,'Alice Dana','Sanchez Condell','MUJER','2026040',NULL,NULL,'2026-04-18 20:33:22','2026-04-18 20:33:22'),(41,NULL,'JOAQUÍN','BELLUCCI','OTRO','A0001',NULL,'2026-04-20 01:36:12','2026-04-20 01:36:12','2026-04-20 01:36:12'),(42,NULL,'LUCAS SEBASTIÁN','BUALO MARTÍNEZ','OTRO','A0002',NULL,'2026-04-20 01:36:12','2026-04-20 01:36:12','2026-04-20 01:36:12'),(43,NULL,'MATEO TIZIANO','CANDIA','OTRO','A0003',NULL,'2026-04-20 01:36:12','2026-04-20 01:36:12','2026-04-20 01:36:12'),(44,NULL,'JOAQUÍN LAUTARO','FLORES','OTRO','A0004',NULL,'2026-04-20 01:36:12','2026-04-20 01:36:12','2026-04-20 01:36:12'),(45,NULL,'KEVIN ARON','GARRIDO','OTRO','A0005',NULL,'2026-04-20 01:36:12','2026-04-20 01:36:12','2026-04-20 01:36:12'),(46,NULL,'STEFANO','GIANBERLUCA','OTRO','A0006',NULL,'2026-04-20 01:36:12','2026-04-20 01:36:12','2026-04-20 01:36:12'),(47,NULL,'AGUSTÍN EMILIO','HADESPEK','OTRO','A0007',NULL,'2026-04-20 01:36:12','2026-04-20 01:36:12','2026-04-20 01:36:12'),(48,NULL,'MONDACA TOMÁS','INOSTROZA','OTRO','A0008',NULL,'2026-04-20 01:36:12','2026-04-20 01:36:12','2026-04-20 01:36:12'),(49,NULL,'BENJAMÍN','REBOLLEDO','OTRO','A0009',NULL,'2026-04-20 01:36:12','2026-04-20 01:36:12','2026-04-20 01:36:12'),(50,NULL,'VALENTINO NICOLÁS','RIVERO','OTRO','A0010',NULL,'2026-04-20 01:36:12','2026-04-20 01:36:12','2026-04-20 01:36:12'),(51,NULL,'SANTINO OMAR','SANSERVINO','OTRO','A0011',NULL,'2026-04-20 01:36:12','2026-04-20 01:36:12','2026-04-20 01:36:12'),(52,NULL,'BRUNO','SANTECCHIA','OTRO','A0012',NULL,'2026-04-20 01:36:12','2026-04-20 01:36:12','2026-04-20 01:36:12'),(53,NULL,'VALENTINA ABRIL','AGUILAR','OTRO','A0013',NULL,'2026-04-20 01:36:12','2026-04-20 01:36:12','2026-04-20 01:36:12'),(54,NULL,'SELENE','DE CELIS','OTRO','A0014',NULL,'2026-04-20 01:36:12','2026-04-20 01:36:12','2026-04-20 01:36:12'),(55,NULL,'GUADALUPE','ESCORZA','OTRO','A0015',NULL,'2026-04-20 01:36:12','2026-04-20 01:36:12','2026-04-20 01:36:12'),(56,NULL,'MIA','FERNANDEZ','OTRO','A0016',NULL,'2026-04-20 01:36:12','2026-04-20 01:36:12','2026-04-20 01:36:12'),(57,NULL,'MATEO SEBASTIAN','GARCIA','OTRO','A0017',NULL,'2026-04-20 01:36:12','2026-04-20 01:36:12','2026-04-20 01:36:12'),(58,NULL,'TIZIANA BELEN','GASPAR','OTRO','A0018',NULL,'2026-04-20 01:36:12','2026-04-20 01:36:12','2026-04-20 01:36:12'),(59,NULL,'MIA JASMINE','KLEIN','OTRO','A0019',NULL,'2026-04-20 01:36:12','2026-04-20 01:36:12','2026-04-20 01:36:12'),(60,NULL,'AGUSTÍN URIEL','MONTENEGRO','OTRO','A0020',NULL,'2026-04-20 01:36:12','2026-04-20 01:36:12','2026-04-20 01:36:12'),(61,NULL,'NAHUEL SEBASTIÁN','MORIGGIA','OTRO','A0021',NULL,'2026-04-20 01:36:12','2026-04-20 01:36:12','2026-04-20 01:36:12'),(62,NULL,'GIULIANA','PENICE','OTRO','A0022',NULL,'2026-04-20 01:36:12','2026-04-20 01:36:12','2026-04-20 01:36:12'),(63,NULL,'FACUNDO JAVIER','QUIÑILEN','OTRO','A0023',NULL,'2026-04-20 01:36:12','2026-04-20 01:36:12','2026-04-20 01:36:12'),(64,NULL,'JULIETA BELÉN','VASQUEZ','OTRO','A0024',NULL,'2026-04-20 01:36:12','2026-04-20 01:36:12','2026-04-20 01:36:12');
/*!40000 ALTER TABLE `alumnos` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER trg_alumnos_before_insert
BEFORE INSERT ON Alumnos
FOR EACH ROW
BEGIN
    SET NEW.fecha_creacion      = NOW();
    SET NEW.fecha_actualizacion = NOW();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER trg_alumnos_before_update
BEFORE UPDATE ON Alumnos
FOR EACH ROW
BEGIN
    SET NEW.fecha_actualizacion = NOW();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Dumping data for table `alumnos_anios`
--

LOCK TABLES `alumnos_anios` WRITE;
/*!40000 ALTER TABLE `alumnos_anios` DISABLE KEYS */;
INSERT INTO `alumnos_anios` VALUES (1,'7°A',7,'A','2026-04-01'),(2,'7°B',7,'B','2026-04-01'),(3,'4°A',4,'A','2026-04-01'),(4,'4°B',4,'B','2026-04-01');
/*!40000 ALTER TABLE `alumnos_anios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `alumnos_asistencias`
--

LOCK TABLES `alumnos_asistencias` WRITE;
/*!40000 ALTER TABLE `alumnos_asistencias` DISABLE KEYS */;
/*!40000 ALTER TABLE `alumnos_asistencias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `alumnos_asistencias_estados`
--

LOCK TABLES `alumnos_asistencias_estados` WRITE;
/*!40000 ALTER TABLE `alumnos_asistencias_estados` DISABLE KEYS */;
INSERT INTO `alumnos_asistencias_estados` VALUES (1,'Presente'),(2,'Ausente'),(3,'Tarde'),(4,'Justificada'),(5,'Retira Antes');
/*!40000 ALTER TABLE `alumnos_asistencias_estados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `alumnos_cursos`
--

LOCK TABLES `alumnos_cursos` WRITE;
/*!40000 ALTER TABLE `alumnos_cursos` DISABLE KEYS */;
INSERT INTO `alumnos_cursos` VALUES (1,'7°A GRUPO 1 INFORMATICA ',1,'INFORMATICA','2026-04-18 18:22:23','2026-04-18 18:22:23',1),(2,'7°A GRUPO 2 INFORMATICA ',2,'INFORMATICA','2026-04-18 18:22:23','2026-04-18 18:25:22',1),(3,'7°B GRUPO 2 INFORMATICA',2,'INFORMATICA','2026-04-18 18:22:23','2026-04-18 18:22:23',2),(4,'7°B GRUPO 3 INFORMATICA',3,'INFORMATICA','2026-04-18 18:22:23','2026-04-18 18:22:23',2),(5,'4°A GRUPO 1 INFORMATICA ',1,'INFORMATICA','2026-04-18 18:22:23','2026-04-18 18:22:23',3),(6,'4°A GRUPO 2 INFORMATICA ',2,'INFORMATICA','2026-04-18 18:22:23','2026-04-18 18:22:23',3);
/*!40000 ALTER TABLE `alumnos_cursos` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER trg_alumnos_cursos_before_insert
BEFORE INSERT ON alumnos_cursos
FOR EACH ROW
BEGIN
    SET NEW.fecha_creacion      = NOW();
    SET NEW.fecha_actualizacion = NOW();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER trg_alumnos_cursos_before_update
BEFORE UPDATE ON alumnos_cursos
FOR EACH ROW
BEGIN
    SET NEW.fecha_actualizacion = NOW();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Dumping data for table `alumnos_grupos_taller`
--

LOCK TABLES `alumnos_grupos_taller` WRITE;
/*!40000 ALTER TABLE `alumnos_grupos_taller` DISABLE KEYS */;
INSERT INTO `alumnos_grupos_taller` VALUES (1,'GRUPO 1',1),(2,'GRUPO 2',2),(3,'GRUPO 3',3);
/*!40000 ALTER TABLE `alumnos_grupos_taller` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `alumnos_notas_trabajos`
--

LOCK TABLES `alumnos_notas_trabajos` WRITE;
/*!40000 ALTER TABLE `alumnos_notas_trabajos` DISABLE KEYS */;
/*!40000 ALTER TABLE `alumnos_notas_trabajos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `docentes`
--

LOCK TABLES `docentes` WRITE;
/*!40000 ALTER TABLE `docentes` DISABLE KEYS */;
INSERT INTO `docentes` VALUES (1,1,'Camilo','Canclini','2002-09-07 00:00:00','2026-03-09 00:00:00','2026-04-18 18:26:32','2026-04-22 22:48:30'),(2,4,'Sofia','Gonzales',NULL,NULL,'2026-04-22 22:48:30','2026-04-22 22:48:30');
/*!40000 ALTER TABLE `docentes` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER trg_docentes_before_insert
BEFORE INSERT ON Docentes
FOR EACH ROW
BEGIN
    SET NEW.fecha_creacion      = NOW();
    SET NEW.fecha_actualizacion = NOW();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER trg_docentes_before_update
BEFORE UPDATE ON Docentes
FOR EACH ROW
BEGIN
    SET NEW.fecha_actualizacion = NOW();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Dumping data for table `docentes_registro_clases`
--

LOCK TABLES `docentes_registro_clases` WRITE;
/*!40000 ALTER TABLE `docentes_registro_clases` DISABLE KEYS */;
INSERT INTO `docentes_registro_clases` VALUES (6,5,NULL,'2026-04-20','Testeando',1,'Probando Registro',NULL,NULL,2),(7,1,NULL,'2026-04-20',NULL,1,NULL,NULL,NULL,1),(8,2,1,'2026-04-20',NULL,1,NULL,NULL,NULL,NULL),(9,5,NULL,'2026-04-21','Testeando',1,'Probando Registro','probando',NULL,1),(10,1,NULL,'2026-04-21',NULL,1,'Repaso Unidad 4: Modelo OSI',NULL,NULL,2),(11,4,NULL,'2026-04-20',NULL,1,'Probando','probando contenidos',NULL,NULL),(12,1,NULL,'2026-04-22',NULL,1,NULL,NULL,NULL,3),(13,1,NULL,'2026-04-23',NULL,1,NULL,NULL,NULL,NULL),(14,1,NULL,'2026-04-24',NULL,1,NULL,NULL,NULL,4);
/*!40000 ALTER TABLE `docentes_registro_clases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `docentes_roles`
--

LOCK TABLES `docentes_roles` WRITE;
/*!40000 ALTER TABLE `docentes_roles` DISABLE KEYS */;
INSERT INTO `docentes_roles` VALUES (1,'Titular'),(2,'Suplente'),(3,'Ayudante');
/*!40000 ALTER TABLE `docentes_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `docentes_trabajos`
--

LOCK TABLES `docentes_trabajos` WRITE;
/*!40000 ALTER TABLE `docentes_trabajos` DISABLE KEYS */;
/*!40000 ALTER TABLE `docentes_trabajos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `materias`
--

LOCK TABLES `materias` WRITE;
/*!40000 ALTER TABLE `materias` DISABLE KEYS */;
INSERT INTO `materias` VALUES (3,'Evaluacion de Proyectos'),(4,'Laboratorio de Hardware');
/*!40000 ALTER TABLE `materias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `materias_dictado`
--

LOCK TABLES `materias_dictado` WRITE;
/*!40000 ALTER TABLE `materias_dictado` DISABLE KEYS */;
INSERT INTO `materias_dictado` VALUES (1,1,3,2026,42),(2,2,3,2026,42),(3,3,3,2026,39),(4,4,3,2026,39),(5,5,4,2026,36),(6,6,4,2026,48);
/*!40000 ALTER TABLE `materias_dictado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `materias_modulos`
--

LOCK TABLES `materias_modulos` WRITE;
/*!40000 ALTER TABLE `materias_modulos` DISABLE KEYS */;
INSERT INTO `materias_modulos` VALUES (34,'12:15:00','14:00:00','LUNES'),(35,'14:30:00','16:20:00','LUNES'),(36,'16:40:00','18:30:00','LUNES'),(37,'12:15:00','14:00:00','MARTES'),(38,'14:30:00','16:20:00','MARTES'),(39,'16:40:00','18:30:00','MARTES'),(40,'12:15:00','14:00:00','MIERCOLES'),(41,'14:30:00','16:20:00','MIERCOLES'),(42,'16:40:00','18:30:00','MIERCOLES'),(43,'12:15:00','14:00:00','JUEVES'),(44,'14:30:00','16:20:00','JUEVES'),(45,'16:40:00','18:30:00','JUEVES'),(46,'12:15:00','14:00:00','VIERNES'),(47,'14:30:00','16:20:00','VIERNES'),(48,'16:40:00','18:30:00','VIERNES');
/*!40000 ALTER TABLE `materias_modulos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `mxm_alumnos_alumnos_anios`
--

LOCK TABLES `mxm_alumnos_alumnos_anios` WRITE;
/*!40000 ALTER TABLE `mxm_alumnos_alumnos_anios` DISABLE KEYS */;
INSERT INTO `mxm_alumnos_alumnos_anios` VALUES (1,1,1,'2026-04-01'),(2,2,1,'2026-04-01'),(3,3,1,'2026-04-01'),(4,4,1,'2026-04-01'),(5,5,1,'2026-04-01'),(6,6,1,'2026-04-01'),(7,7,1,'2026-04-01'),(8,8,1,'2026-04-01'),(9,9,1,'2026-04-01'),(10,10,1,'2026-04-01'),(11,11,1,'2026-04-01'),(12,12,1,'2026-04-01'),(13,13,1,'2026-04-01'),(14,14,1,'2026-04-01'),(15,15,1,'2026-04-01'),(16,16,3,'2026-04-01'),(17,19,3,'2026-04-01'),(18,21,3,'2026-04-01'),(19,23,3,'2026-04-01'),(20,25,3,'2026-04-01'),(21,26,3,'2026-04-01'),(22,17,2,'2026-04-01'),(23,18,2,'2026-04-01'),(24,20,2,'2026-04-01'),(25,22,2,'2026-04-01'),(26,24,2,'2026-04-01'),(27,27,2,'2026-04-01'),(28,28,4,'2026-04-01'),(29,29,4,'2026-04-01'),(30,30,4,'2026-04-01'),(31,31,4,'2026-04-01'),(32,32,4,'2026-04-01'),(33,33,4,'2026-04-01'),(34,34,4,'2026-04-01'),(35,35,4,'2026-04-01'),(36,36,4,'2026-04-01'),(37,37,4,'2026-04-01'),(38,38,4,'2026-04-01'),(39,39,4,'2026-04-01'),(40,40,4,'2026-04-01'),(65,41,5,'2026-04-20'),(66,42,5,'2026-04-20'),(67,43,5,'2026-04-20'),(68,44,5,'2026-04-20'),(69,45,5,'2026-04-20'),(70,46,5,'2026-04-20'),(71,47,5,'2026-04-20'),(72,48,5,'2026-04-20'),(73,49,5,'2026-04-20'),(74,50,5,'2026-04-20'),(75,51,5,'2026-04-20'),(76,52,5,'2026-04-20'),(77,53,6,'2026-04-20'),(78,54,6,'2026-04-20'),(79,55,6,'2026-04-20'),(80,56,6,'2026-04-20'),(81,57,6,'2026-04-20'),(82,58,6,'2026-04-20'),(83,59,6,'2026-04-20'),(84,60,6,'2026-04-20'),(85,61,6,'2026-04-20'),(86,62,6,'2026-04-20'),(87,63,6,'2026-04-20'),(88,64,6,'2026-04-20');
/*!40000 ALTER TABLE `mxm_alumnos_alumnos_anios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `mxm_alumnos_materias`
--

LOCK TABLES `mxm_alumnos_materias` WRITE;
/*!40000 ALTER TABLE `mxm_alumnos_materias` DISABLE KEYS */;
/*!40000 ALTER TABLE `mxm_alumnos_materias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `mxm_docente_materia_dictada`
--

LOCK TABLES `mxm_docente_materia_dictada` WRITE;
/*!40000 ALTER TABLE `mxm_docente_materia_dictada` DISABLE KEYS */;
INSERT INTO `mxm_docente_materia_dictada` VALUES (1,1,1,1),(2,1,1,2),(3,1,1,3),(4,1,1,4),(5,1,1,5),(6,1,1,6);
/*!40000 ALTER TABLE `mxm_docente_materia_dictada` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `mxm_usuarios_usuarios_roles`
--

LOCK TABLES `mxm_usuarios_usuarios_roles` WRITE;
/*!40000 ALTER TABLE `mxm_usuarios_usuarios_roles` DISABLE KEYS */;
INSERT INTO `mxm_usuarios_usuarios_roles` VALUES (1,1,1),(2,4,1),(3,5,2),(4,6,2);
/*!40000 ALTER TABLE `mxm_usuarios_usuarios_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('5eqK7I0zJRCqh9vNambaxGcNtxuAKoa5fbg7SmhB',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0','eyJfdG9rZW4iOiI0ekZxaWl0NkJBZjNueUo2V1ljdTIwRkFqeW9wb09XS0VjWlBjaHFwIiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9kb2NlbnRlc1wvbGlicm8tdGVtYXMiLCJyb3V0ZSI6ImRvY2VudGVzLmxpYnJvLXRlbWFzIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjF9',1776826042),('AVc1mV0tmdIdcseI9ChIS23EdSePYns1ob5WhxUq',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJlYTQ4YmNHckNwNXdWd2tBaGhGZHg2MXZlRzU2UmdkcU1jWTV5Sk5NIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2RvY2VudGVzXC9hbHVtbm9zP2RpY3RhZG9faWQ9NCIsInJvdXRlIjoiZG9jZW50ZXMuYWx1bW5vcyJ9LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MX0=',1776830565);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'ccanclini','Camilo Stephano','Canclini','ccanclini@itlp.edu.ar','$2y$12$00/mut3Kzqq1yS6vUArqFO0Vf9mefh.yaDcBrY6WFKYTJncuN4UB6','ccanclinidev','drRICBJHrTTMXaCoWiOnqWmBDKcCMFBojFYXbriIpMzEamGUPjEaPPgItMvS','HOMBRE',NULL,'2026-04-18 17:49:11','2026-04-22 22:45:05',NULL),(2,'testuser','test','testing','test@gmail.com','pass123','test123',NULL,'HOMBRE',NULL,'2026-04-21 23:29:37','2026-04-22 22:45:05',NULL),(3,'admin','administrator','admin','admin@gmail.com','admin','admin',NULL,'HOMBRE',NULL,'2026-04-22 22:40:22','2026-04-22 22:45:05',NULL),(4,'sgonzales','Sofia','Gonzalez','sgonzales@obralapiedad.com.ar','','sgonzalesdev',NULL,'MUJER',NULL,'2026-04-22 22:40:22','2026-04-22 22:45:05',NULL),(5,'dgonzales','Daniela','Gonzalez','dgonzales@obralapiedad.com.ar','','dgonzalesdev',NULL,'MUJER',NULL,'2026-04-22 22:40:22','2026-04-22 22:45:05',NULL),(6,'pfioriti','Patricia','Fioriti','pfioriti@obralapiedad.com.ar','','pfioritidev',NULL,'MUJER',NULL,'2026-04-22 22:40:22','2026-04-22 22:45:05',NULL);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER trg_usuarios_before_insert
BEFORE INSERT ON Usuarios
FOR EACH ROW
BEGIN
    SET NEW.fecha_creacion      = NOW();
    SET NEW.fecha_actualizacion = NOW();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER trg_usuarios_before_update
BEFORE UPDATE ON Usuarios
FOR EACH ROW
BEGIN
    SET NEW.fecha_actualizacion = NOW();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Dumping data for table `usuarios_roles`
--

LOCK TABLES `usuarios_roles` WRITE;
/*!40000 ALTER TABLE `usuarios_roles` DISABLE KEYS */;
INSERT INTO `usuarios_roles` VALUES (1,'Docente','2026-04-18 17:51:04','2026-04-18 17:53:43'),(2,'Director/a','2026-04-22 22:46:47','2026-04-22 22:46:47'),(3,'Preceptor/a','2026-04-22 22:46:47','2026-04-22 22:46:47'),(4,'Secretario/a','2026-04-22 22:46:47','2026-04-22 22:46:47');
/*!40000 ALTER TABLE `usuarios_roles` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER trg_usuarios_roles_before_insert
BEFORE INSERT ON Usuarios_Roles
FOR EACH ROW
BEGIN
    SET NEW.fecha_creacion      = NOW();
    SET NEW.fecha_actualizacion = NOW();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER trg_usuarios_roles_before_update
BEFORE UPDATE ON Usuarios_Roles
FOR EACH ROW
BEGIN
    SET NEW.fecha_actualizacion = NOW();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Dumping events for database 'sgitlp'
--

--
-- Dumping routines for database 'sgitlp'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-22 23:00:37
