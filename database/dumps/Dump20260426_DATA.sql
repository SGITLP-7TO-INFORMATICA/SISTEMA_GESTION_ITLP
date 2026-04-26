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
INSERT INTO `alumnos` VALUES (65,1,NULL,7,1,'Ruben Maximiliano','Baungartner','HOMBRE','T001',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(66,1,NULL,7,1,'Lisandro Ezequiel','Garcia','HOMBRE','T002',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(67,1,NULL,7,1,'Albano','Gomez Monduzzi','HOMBRE','T003',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(68,1,NULL,7,1,'Jesus Sebastian','Gonzalez Arias','HOMBRE','T004',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(69,1,NULL,7,1,'Agostina Loana','Infante','MUJER','T005',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(70,1,NULL,7,1,'Lautaro Benjamin','Marchant Ortiz','HOMBRE','T006',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(71,1,NULL,7,1,'Valentin','Marozzi','HOMBRE','T007',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(72,1,NULL,7,1,'Valentina Lujan','Mendez','MUJER','T008',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(73,1,NULL,7,1,'Tobias Agustin','Pardal','HOMBRE','T009',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(74,1,NULL,7,1,'Nahuel Agustin','Peralta','HOMBRE','T010',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(75,1,NULL,7,1,'Franco Agustin','Piattoni','HOMBRE','T011',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(76,1,NULL,7,1,'Mariano Alejandro','Ricardes Cotta','HOMBRE','T012',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(77,1,NULL,7,1,'Maria Caterina','Rochon','MUJER','T013',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(78,1,NULL,7,1,'Marco Tomas','Wander','HOMBRE','T014',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(79,1,NULL,7,1,'Benjamin Octavio','Widman','HOMBRE','T015',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(80,1,NULL,7,2,'Ian','Barra Colautti','HOMBRE','T016',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(81,1,NULL,7,2,'Esteban Daniel','Dominguez','HOMBRE','T017',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(82,1,NULL,7,2,'Sofia Belen','Garcia','MUJER','T018',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(83,1,NULL,7,2,'Lautaro Baltazar','Lopez','HOMBRE','T019',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(84,1,NULL,7,2,'Nicolas','Popp','HOMBRE','T020',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(85,1,NULL,8,3,'Lucciano German','Amaya Monsalve','HOMBRE','T021',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(86,1,NULL,8,3,'Albano','Fortunatti','HOMBRE','T022',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(87,1,NULL,8,3,'Marcelo David','Herrera','HOMBRE','T023',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(88,1,NULL,8,3,'Juan Cruz','Maliqueo','HOMBRE','T024',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(89,1,NULL,8,3,'Lucas','Quijada','HOMBRE','T025',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(90,1,NULL,8,3,'Santiago Ismael','Rick','HOMBRE','T026',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(91,1,NULL,8,3,'Lucas Adrian','Schroeder','HOMBRE','T027',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(92,1,NULL,8,4,'Jose Luis','Acuña','HOMBRE','T028',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(93,1,NULL,8,4,'Micaela Belen','Barrionuevo','MUJER','T029',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(94,1,NULL,8,4,'Santino','Basile','HOMBRE','T030',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(95,1,NULL,8,4,'Guillermo Alejandro','Costazos','HOMBRE','T031',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(96,1,NULL,8,4,'Facundo','Ercoli Guerreiro','HOMBRE','T032',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(97,1,NULL,8,4,'Torcuato','Fidani','HOMBRE','T033',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(98,1,NULL,8,4,'Santiago Ezequiel','Gonzalez','HOMBRE','T034',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(99,1,NULL,8,4,'Santiago','Macre','HOMBRE','T035',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(100,1,NULL,8,4,'Lucas Valentino','Miranda Canoves','HOMBRE','T036',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(101,1,NULL,8,4,'Juan Sebastian','Muñoz','HOMBRE','T037',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(102,1,NULL,8,4,'Rihana Sofia','Rando','MUJER','T038',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(103,1,NULL,8,4,'Aldana','Samudio','MUJER','T039',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(104,1,NULL,8,4,'Alice Dana','Sanchez Condell','MUJER','T040',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(105,1,NULL,9,5,'Joaquin','Bellucci','HOMBRE','T041',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(106,1,NULL,9,5,'Lucas Sebastian','Bualo Martinez','HOMBRE','T042',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(107,1,NULL,9,5,'Mateo Tiziano','Candia','HOMBRE','T043',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(108,1,NULL,9,5,'Joaquin Lautaro','Flores','HOMBRE','T044',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(109,1,NULL,9,5,'Kevin Aron','Garrido','HOMBRE','T045',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(110,1,NULL,9,5,'Stefano','Gianberlluca','HOMBRE','T046',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(111,1,NULL,9,5,'Agustin Emilio','Hadespek','HOMBRE','T047',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(112,1,NULL,9,5,'Tomas','Inostroza Mondaca','HOMBRE','T048',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(113,1,NULL,9,5,'Benjamin','Rebolledo','HOMBRE','T049',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(114,1,NULL,9,5,'Valentino Nicolas','Rivero','HOMBRE','T050',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(115,1,NULL,9,5,'Santino Omar','Sanservino','HOMBRE','T051',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(116,1,NULL,9,5,'Bruno','Santecchia','HOMBRE','T052',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(117,1,NULL,9,6,'Valentina Abril','Aguilar','MUJER','T053',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(118,1,NULL,9,6,'Selene','De Celis','MUJER','T054',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(119,1,NULL,9,6,'Guadalupe','Escorza','MUJER','T055',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(120,1,NULL,9,6,'Mia','Fernandez','MUJER','T056',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(121,1,NULL,9,6,'Mateo Sebastian','Garcia','HOMBRE','T057',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(122,1,NULL,9,6,'Tiziana Belen','Gaspar','MUJER','T058',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(123,1,NULL,9,6,'Mia Jasmine','Klein','MUJER','T059',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(124,1,NULL,9,6,'Agustin Uriel','Montenegro','HOMBRE','T060',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(125,1,NULL,9,6,'Nahuel Sebastian','Moriggia','HOMBRE','T061',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(126,1,NULL,9,6,'Giuliana','Penice','MUJER','T062',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(127,1,NULL,9,6,'Facundo Javier','Quiñilen','HOMBRE','T063',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(128,1,NULL,9,6,'Julieta Belen','Vasquez','MUJER','T064',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(129,1,NULL,10,NULL,'Bastian Jonas','Alegre Pellegrinatti','HOMBRE','T065',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(130,1,NULL,10,NULL,'Genaro','Amigo Koch','HOMBRE','T066',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(131,1,NULL,10,NULL,'Alejo','Aroca','HOMBRE','T067',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(132,1,NULL,10,NULL,'Valentin','Blazquez Gomez','HOMBRE','T068',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(133,1,NULL,10,NULL,'Alejo Valentin','Cejas','HOMBRE','T069',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(134,1,NULL,10,NULL,'Benjamin','Cornejo','HOMBRE','T070',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(135,1,NULL,10,NULL,'Joaquin Uriel','De Robles Sosa','HOMBRE','T071',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(136,1,NULL,10,NULL,'Ibrahim','El Haddad','HOMBRE','T072',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(137,1,NULL,10,NULL,'Yago Tomas','Martinez','HOMBRE','T073',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(138,1,NULL,10,NULL,'Mateo','Ojeda','HOMBRE','T074',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(139,1,NULL,10,NULL,'Bruno Joaquin','Pallero','HOMBRE','T075',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(140,1,NULL,10,NULL,'Dino','Rossi','HOMBRE','T076',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(141,1,NULL,10,NULL,'Lucas','Britos','HOMBRE','T077',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(142,1,NULL,10,NULL,'Santiago','Chavez','HOMBRE','T078',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(143,1,NULL,10,NULL,'Sofia Yazmin','Corral Aguilera','MUJER','T079',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(144,1,NULL,10,NULL,'Valentina Belen','Curilem','MUJER','T080',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(145,1,NULL,10,NULL,'Wanda Daiana','Dimes','MUJER','T081',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(146,1,NULL,10,NULL,'Santiago Valentin','Frank','HOMBRE','T082',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(147,1,NULL,10,NULL,'Joel Emanuel','Hidalgo','HOMBRE','T083',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(148,1,NULL,10,NULL,'Micaela Abigail','Inglera','MUJER','T084',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(149,1,NULL,10,NULL,'Emiliano Marcos','Padilla Gonzalez','HOMBRE','T085',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(150,1,NULL,10,NULL,'Abby Marian','Pinilla','MUJER','T086',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34'),(151,1,NULL,10,NULL,'Nahuel Joaquin','Senger','HOMBRE','T087',NULL,NULL,'2026-04-25 19:38:34','2026-04-25 19:38:34');
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
INSERT INTO `alumnos_anios` VALUES (1,'7°A',7,'A','2026-01-01','INFORMATICA'),(2,'7°B',7,'B','2026-01-01','INFORMATICA'),(3,'4°A',4,'A','2026-01-01','INFORMATICA'),(4,'4°B',4,'B','2026-01-01','INFORMATICA');
/*!40000 ALTER TABLE `alumnos_anios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `alumnos_asistencias`
--

LOCK TABLES `alumnos_asistencias` WRITE;
/*!40000 ALTER TABLE `alumnos_asistencias` DISABLE KEYS */;
INSERT INTO `alumnos_asistencias` VALUES (1,105,5,'2026-04-26',18,2,1,NULL,NULL,NULL),(2,106,5,'2026-04-26',18,2,1,NULL,NULL,NULL),(3,107,5,'2026-04-26',18,1,1,NULL,NULL,NULL),(4,108,5,'2026-04-26',18,1,1,NULL,NULL,NULL),(5,109,5,'2026-04-26',18,1,1,NULL,NULL,NULL),(6,110,5,'2026-04-26',18,1,1,NULL,NULL,NULL),(7,111,5,'2026-04-26',18,1,1,NULL,NULL,NULL),(8,112,5,'2026-04-26',18,1,1,NULL,NULL,NULL),(9,113,5,'2026-04-26',18,1,1,NULL,NULL,NULL),(10,114,5,'2026-04-26',18,1,1,NULL,NULL,NULL),(11,115,5,'2026-04-26',18,1,1,NULL,NULL,NULL),(12,116,5,'2026-04-26',18,1,1,NULL,NULL,NULL);
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
INSERT INTO `alumnos_cursos` VALUES (1,'7°A GRUPO 1 INFORMATICA ',1,1,'2026-04-18 18:22:23','2026-04-25 17:30:05'),(2,'7°A GRUPO 2 INFORMATICA ',1,2,'2026-04-18 18:22:23','2026-04-25 17:30:05'),(3,'7°B GRUPO 2 INFORMATICA',2,2,'2026-04-18 18:22:23','2026-04-25 20:23:54'),(4,'7°B GRUPO 3 INFORMATICA',2,3,'2026-04-18 18:22:23','2026-04-25 17:30:05'),(5,'4°A GRUPO 1 INFORMATICA ',3,1,'2026-04-18 18:22:23','2026-04-25 17:30:05'),(6,'4°A GRUPO 2 INFORMATICA ',3,2,'2026-04-18 18:22:23','2026-04-25 17:30:05'),(7,'7°A INFORMATICA',1,NULL,'2026-04-25 19:24:13','2026-04-25 19:24:13'),(8,'7°B INFORMATICA',2,NULL,'2026-04-25 19:24:13','2026-04-25 19:24:13'),(9,'4°A INFORMATICA',3,NULL,'2026-04-25 19:24:13','2026-04-25 19:24:13'),(10,'4°B INFORMATICA',3,NULL,'2026-04-25 19:24:13','2026-04-25 19:24:13'),(11,'CICLO BASICO - 2°B INFORMATICA',NULL,NULL,'2026-04-26 14:04:21','2026-04-26 14:04:21');
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
INSERT INTO `docentes` VALUES (1,1,'Camilo','Canclini','2002-09-07 00:00:00','2026-03-09 00:00:00','2026-04-18 18:26:32','2026-04-22 22:48:30'),(2,4,'Sofia','Gonzales',NULL,NULL,'2026-04-22 22:48:30','2026-04-22 22:48:30'),(3,2,'Jose','Lopez','2000-01-12 00:00:00','2026-04-26 00:00:00','2026-04-26 14:02:33','2026-04-26 14:02:33');
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
INSERT INTO `docentes_registro_clases` VALUES (18,5,NULL,'2026-04-26',NULL,1,NULL,NULL,NULL,2),(19,7,NULL,'2026-04-20',NULL,3,'Probando','Temas Vistos test',NULL,1);
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
INSERT INTO `docentes_trabajos` VALUES (1,1,1,'TP1','Trabajo integrador unidad 1 a la unidad 4','2026-04-22 00:00:00','2026-05-06 00:00:00',NULL,'2026-04-23 04:26:07','2026-04-23 04:27:41'),(3,1,1,'Oral 1: Unidad 1-4','Conceptos Generales hardware, Historia pc\'s, Microprocesador y Motherboard',NULL,NULL,NULL,'2026-04-23 14:06:43','2026-04-23 14:07:26'),(4,1,1,'ORAL 1: UNIDAD 1-4',NULL,NULL,NULL,NULL,'2026-04-23 14:35:24','2026-04-23 14:35:24');
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
-- Dumping data for table `historico_alumno`
--

LOCK TABLES `historico_alumno` WRITE;
/*!40000 ALTER TABLE `historico_alumno` DISABLE KEYS */;
/*!40000 ALTER TABLE `historico_alumno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `historico_alumno_materia`
--

LOCK TABLES `historico_alumno_materia` WRITE;
/*!40000 ALTER TABLE `historico_alumno_materia` DISABLE KEYS */;
/*!40000 ALTER TABLE `historico_alumno_materia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `historico_alumnos_asistencias`
--

LOCK TABLES `historico_alumnos_asistencias` WRITE;
/*!40000 ALTER TABLE `historico_alumnos_asistencias` DISABLE KEYS */;
/*!40000 ALTER TABLE `historico_alumnos_asistencias` ENABLE KEYS */;
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
INSERT INTO `materias` VALUES (3,'Evaluacion de Proyectos',NULL),(4,'Laboratorio de Hardware',NULL),(5,'Introducción a la Programación','2003'),(6,'Introducción a la Robotica','2015');
/*!40000 ALTER TABLE `materias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `materias_dictado`
--

LOCK TABLES `materias_dictado` WRITE;
/*!40000 ALTER TABLE `materias_dictado` DISABLE KEYS */;
INSERT INTO `materias_dictado` VALUES (1,3,2026,39),(2,3,2026,42),(5,4,2026,36),(6,4,2026,48),(7,5,2026,34),(8,6,2026,35);
/*!40000 ALTER TABLE `materias_dictado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `materias_modulos`
--

LOCK TABLES `materias_modulos` WRITE;
/*!40000 ALTER TABLE `materias_modulos` DISABLE KEYS */;
INSERT INTO `materias_modulos` VALUES (34,'12:15:00','14:00:00','LUNES'),(35,'14:30:00','16:20:00','LUNES'),(36,'16:40:00','18:30:00','LUNES'),(37,'12:15:00','14:00:00','MARTES'),(38,'14:30:00','16:20:00','MARTES'),(39,'16:40:00','18:30:00','MARTES'),(40,'12:15:00','14:00:00','MIERCOLES'),(41,'14:30:00','16:20:00','MIERCOLES'),(42,'16:40:00','18:30:00','MIERCOLES'),(43,'12:15:00','14:00:00','JUEVES'),(44,'14:30:00','16:20:00','JUEVES'),(45,'16:40:00','18:30:00','JUEVES'),(46,'12:15:00','14:00:00','VIERNES'),(47,'14:30:00','16:20:00','VIERNES'),(48,'16:40:00','18:30:00','VIERNES'),(49,'07:45:00','08:45:00','LUNES'),(50,'08:45:00','09:45:00','LUNES'),(51,'10:00:00','11:00:00','LUNES'),(52,'11:00:00','12:00:00','LUNES'),(53,'07:45:00','08:45:00','MARTES'),(54,'08:45:00','09:45:00','MARTES'),(55,'10:00:00','11:00:00','MARTES'),(56,'11:00:00','12:00:00','MARTES'),(57,'07:45:00','08:45:00','MIERCOLES'),(58,'08:45:00','09:45:00','MIERCOLES'),(59,'10:00:00','11:00:00','MIERCOLES'),(60,'11:00:00','12:00:00','MIERCOLES'),(61,'07:45:00','08:45:00','JUEVES'),(62,'08:45:00','09:45:00','JUEVES'),(63,'10:00:00','11:00:00','JUEVES'),(64,'11:00:00','12:00:00','JUEVES'),(65,'07:45:00','08:45:00','VIERNES'),(66,'08:45:00','09:45:00','VIERNES'),(67,'10:00:00','11:00:00','VIERNES'),(68,'11:00:00','12:00:00','VIERNES');
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
-- Dumping data for table `mxm_alumnos_materias`
--

LOCK TABLES `mxm_alumnos_materias` WRITE;
/*!40000 ALTER TABLE `mxm_alumnos_materias` DISABLE KEYS */;
INSERT INTO `mxm_alumnos_materias` VALUES (1,65,2),(2,66,2),(3,67,2),(4,68,2),(5,69,2),(6,70,2),(7,71,2),(8,72,2),(9,73,2),(10,74,2),(11,75,2),(12,76,2),(13,77,2),(14,78,2),(15,79,2),(16,80,1),(17,81,1),(18,82,1),(19,83,1),(20,84,1),(21,105,5),(22,106,5),(23,107,5),(24,108,5),(25,109,5),(26,110,5),(27,111,5),(28,112,5),(29,113,5),(30,114,5),(31,115,5),(32,116,5),(33,117,6),(34,118,6),(35,119,6),(36,120,6),(37,121,6),(38,122,6),(39,123,6),(40,124,6),(41,125,6),(42,126,6),(43,127,6),(44,128,6);
/*!40000 ALTER TABLE `mxm_alumnos_materias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `mxm_cursos_materias_dictado`
--

LOCK TABLES `mxm_cursos_materias_dictado` WRITE;
/*!40000 ALTER TABLE `mxm_cursos_materias_dictado` DISABLE KEYS */;
INSERT INTO `mxm_cursos_materias_dictado` VALUES (1,1,2,NULL,NULL),(2,2,1,NULL,NULL),(3,5,5,NULL,NULL),(4,6,6,NULL,NULL),(5,11,7,NULL,NULL),(6,11,8,NULL,NULL);
/*!40000 ALTER TABLE `mxm_cursos_materias_dictado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `mxm_docente_materia_dictada`
--

LOCK TABLES `mxm_docente_materia_dictada` WRITE;
/*!40000 ALTER TABLE `mxm_docente_materia_dictada` DISABLE KEYS */;
INSERT INTO `mxm_docente_materia_dictada` VALUES (1,1,1,1),(2,1,1,2),(3,1,1,5),(4,1,1,6),(5,3,1,7),(6,3,1,8);
/*!40000 ALTER TABLE `mxm_docente_materia_dictada` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `mxm_docentes_trabajos_dictados`
--

LOCK TABLES `mxm_docentes_trabajos_dictados` WRITE;
/*!40000 ALTER TABLE `mxm_docentes_trabajos_dictados` DISABLE KEYS */;
INSERT INTO `mxm_docentes_trabajos_dictados` VALUES (5,1,1),(6,1,2),(9,3,5),(10,4,6);
/*!40000 ALTER TABLE `mxm_docentes_trabajos_dictados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `mxm_usuarios_usuarios_roles`
--

LOCK TABLES `mxm_usuarios_usuarios_roles` WRITE;
/*!40000 ALTER TABLE `mxm_usuarios_usuarios_roles` DISABLE KEYS */;
INSERT INTO `mxm_usuarios_usuarios_roles` VALUES (1,1,1),(2,4,1),(3,5,2),(4,6,2),(5,1,5);
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
INSERT INTO `sessions` VALUES ('WpqvVDhdbmKH2FX82TyQ21NscDbkD6hbY8h42hRu',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJvUEFCdlFDR0trejd4dmZ1NWh5VnlNcnJEWFY5c1d0T0hTYXBOT0RUIiwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEsIl9wcmV2aW91cyI6eyJ1cmwiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMCIsInJvdXRlIjoiZGFzaGJvYXJkIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1777228000),('wQ6Viy4M0RKba06N5xq4wtbF3mGWPfKIK2lL7GZW',2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJ4bTEweklkMzAyZUJ3MVcySlJtZ2RGYVRqaWxXdlZkRmNyMmMwd3M5IiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pbmlzdHJhY2lvblwvYWx1bW5vc1wvYXNpc3RlbmNpYXM/YWx1bW5vX2lkPTEwNSIsInJvdXRlIjoiYWRtaW5pc3RyYWNpb24uYWx1bW5vcy5hc2lzdGVuY2lhcyJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoyfQ==',1777226761);
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
INSERT INTO `usuarios` VALUES (1,'ccanclini','Camilo Stephano','Canclini','ccanclini@itlp.edu.ar','$2y$12$00/mut3Kzqq1yS6vUArqFO0Vf9mefh.yaDcBrY6WFKYTJncuN4UB6','ccanclinidev','RE14n0m7ARz5DYan4LIEDxyNXAWG6WoGHGAvwqpmXbgBigiRAAfcmWz2G8xC','HOMBRE',NULL,'2026-04-18 17:49:11','2026-04-23 11:31:51',NULL),(2,'testuser','test','testing','test@gmail.com','pass123','test123',NULL,'HOMBRE',NULL,'2026-04-21 23:29:37','2026-04-22 22:45:05',NULL),(3,'admin','administrator','admin','admin@gmail.com','admin','admin',NULL,'HOMBRE',NULL,'2026-04-22 22:40:22','2026-04-22 22:45:05',NULL),(4,'sgonzales','Sofia','Gonzalez','sgonzales@obralapiedad.com.ar','','sgonzalesdev',NULL,'MUJER',NULL,'2026-04-22 22:40:22','2026-04-22 22:45:05',NULL),(5,'dgonzales','Daniela','Gonzalez','dgonzales@obralapiedad.com.ar','','dgonzalesdev',NULL,'MUJER',NULL,'2026-04-22 22:40:22','2026-04-22 22:45:05',NULL),(6,'pfioriti','Patricia','Fioriti','pfioriti@obralapiedad.com.ar','','pfioritidev',NULL,'MUJER',NULL,'2026-04-22 22:40:22','2026-04-22 22:45:05',NULL);
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
INSERT INTO `usuarios_roles` VALUES (1,'Docente',0,'2026-04-18 17:51:04','2026-04-23 21:19:55'),(2,'Director/a',0,'2026-04-22 22:46:47','2026-04-23 21:19:55'),(3,'Preceptor/a',0,'2026-04-22 22:46:47','2026-04-23 21:19:55'),(4,'Secretario/a',0,'2026-04-22 22:46:47','2026-04-23 21:19:55'),(5,'Administrador',1,'2026-04-23 21:18:48','2026-04-23 21:19:48');
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

-- Dump completed on 2026-04-26 15:34:49
