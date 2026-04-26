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
-- Table structure for table `alumnos`
--

DROP TABLE IF EXISTS `alumnos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alumnos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `activo` tinyint(4) DEFAULT 0,
  `id_usuario` int(10) unsigned DEFAULT NULL,
  `id_curso_actual` int(10) unsigned DEFAULT NULL,
  `id_grupo_taller_actual` int(10) unsigned DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `Genero` enum('HOMBRE','MUJER','OTRO') NOT NULL,
  `legajo` varchar(255) NOT NULL,
  `fecha_nacimiento` datetime DEFAULT NULL,
  `fecha_ingreso` datetime DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `legajo` (`legajo`),
  UNIQUE KEY `Alumnos_index_0` (`legajo`),
  KEY `fk_alumnos_usuario` (`id_usuario`),
  KEY `fk_alumno_curso_idx` (`id_curso_actual`),
  KEY `fk_alumno_grupo_taller_idx` (`id_grupo_taller_actual`),
  CONSTRAINT `fk_alumno_curso` FOREIGN KEY (`id_curso_actual`) REFERENCES `alumnos_cursos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_alumno_grupo_taller` FOREIGN KEY (`id_grupo_taller_actual`) REFERENCES `alumnos_cursos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_alumnos_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
-- Table structure for table `alumnos_anios`
--

DROP TABLE IF EXISTS `alumnos_anios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alumnos_anios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `anio` int(11) NOT NULL,
  `division` varchar(1) NOT NULL,
  `anio_dictado` date DEFAULT NULL,
  `modalidad` enum('INFORMATICA','ELECTROMECANICA') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumnos_anios`
--

LOCK TABLES `alumnos_anios` WRITE;
/*!40000 ALTER TABLE `alumnos_anios` DISABLE KEYS */;
INSERT INTO `alumnos_anios` VALUES (1,'7°A',7,'A','2026-01-01','INFORMATICA'),(2,'7°B',7,'B','2026-01-01','INFORMATICA'),(3,'4°A',4,'A','2026-01-01','INFORMATICA'),(4,'4°B',4,'B','2026-01-01','INFORMATICA');
/*!40000 ALTER TABLE `alumnos_anios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alumnos_asistencias`
--

DROP TABLE IF EXISTS `alumnos_asistencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alumnos_asistencias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_Alumno` int(10) unsigned NOT NULL,
  `id_materia_dictada` int(10) unsigned DEFAULT NULL,
  `Fecha` date NOT NULL,
  `Id_Registro_Clase` int(10) unsigned DEFAULT NULL,
  `Id_Estado` int(10) unsigned NOT NULL,
  `Id_Usuario_Verificador` int(10) unsigned DEFAULT NULL,
  `Observaciones` varchar(255) DEFAULT NULL,
  `Hora_Tarde` time DEFAULT NULL,
  `Hora_Retiro` time DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_asist_alumno` (`id_Alumno`),
  KEY `fk_asist_registro_clase` (`Id_Registro_Clase`),
  KEY `fk_asist_verificador` (`Id_Usuario_Verificador`),
  KEY `fk_asist_estado` (`Id_Estado`),
  KEY `fk_asist_materia_idx` (`id_materia_dictada`),
  CONSTRAINT `fk_asist_alumno` FOREIGN KEY (`id_Alumno`) REFERENCES `alumnos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_asist_estado` FOREIGN KEY (`Id_Estado`) REFERENCES `alumnos_asistencias_estados` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_asist_materia` FOREIGN KEY (`id_materia_dictada`) REFERENCES `materias_dictado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_asist_registro_clase` FOREIGN KEY (`Id_Registro_Clase`) REFERENCES `docentes_registro_clases` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_asist_verificador` FOREIGN KEY (`Id_Usuario_Verificador`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumnos_asistencias`
--

LOCK TABLES `alumnos_asistencias` WRITE;
/*!40000 ALTER TABLE `alumnos_asistencias` DISABLE KEYS */;
INSERT INTO `alumnos_asistencias` VALUES (1,105,5,'2026-04-26',18,2,1,NULL,NULL,NULL),(2,106,5,'2026-04-26',18,2,1,NULL,NULL,NULL),(3,107,5,'2026-04-26',18,1,1,NULL,NULL,NULL),(4,108,5,'2026-04-26',18,1,1,NULL,NULL,NULL),(5,109,5,'2026-04-26',18,1,1,NULL,NULL,NULL),(6,110,5,'2026-04-26',18,1,1,NULL,NULL,NULL),(7,111,5,'2026-04-26',18,1,1,NULL,NULL,NULL),(8,112,5,'2026-04-26',18,1,1,NULL,NULL,NULL),(9,113,5,'2026-04-26',18,1,1,NULL,NULL,NULL),(10,114,5,'2026-04-26',18,1,1,NULL,NULL,NULL),(11,115,5,'2026-04-26',18,1,1,NULL,NULL,NULL),(12,116,5,'2026-04-26',18,1,1,NULL,NULL,NULL);
/*!40000 ALTER TABLE `alumnos_asistencias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alumnos_asistencias_estados`
--

DROP TABLE IF EXISTS `alumnos_asistencias_estados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alumnos_asistencias_estados` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Estado` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumnos_asistencias_estados`
--

LOCK TABLES `alumnos_asistencias_estados` WRITE;
/*!40000 ALTER TABLE `alumnos_asistencias_estados` DISABLE KEYS */;
INSERT INTO `alumnos_asistencias_estados` VALUES (1,'Presente'),(2,'Ausente'),(3,'Tarde'),(4,'Justificada'),(5,'Retira Antes');
/*!40000 ALTER TABLE `alumnos_asistencias_estados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alumnos_cursos`
--

DROP TABLE IF EXISTS `alumnos_cursos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alumnos_cursos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `id_anio` int(11) DEFAULT NULL,
  `grupo_taller` int(1) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cursos_anios_idx` (`id_anio`),
  CONSTRAINT `fk_cursos_anios` FOREIGN KEY (`id_anio`) REFERENCES `alumnos_anios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
-- Table structure for table `alumnos_notas_trabajos`
--

DROP TABLE IF EXISTS `alumnos_notas_trabajos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alumnos_notas_trabajos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_alumno` int(10) unsigned NOT NULL,
  `id_trabajo` int(10) unsigned NOT NULL,
  `nota_individual` decimal(4,2) unsigned DEFAULT NULL,
  `grupo` varchar(1) DEFAULT NULL,
  `nota_grupal` decimal(4,2) unsigned DEFAULT NULL,
  `observaciones` varchar(400) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_alumnos_notas_trabajos_alumno_trabajo` (`id_alumno`,`id_trabajo`),
  KEY `fk_alu_notas_tra_id_alumno_idx` (`id_alumno`),
  KEY `fk_alu_notas_tra_id_trabajo_idx` (`id_trabajo`),
  CONSTRAINT `fk_alu_notas_tra_id_alumno` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_alu_notas_tra_id_trabajo` FOREIGN KEY (`id_trabajo`) REFERENCES `docentes_trabajos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumnos_notas_trabajos`
--

LOCK TABLES `alumnos_notas_trabajos` WRITE;
/*!40000 ALTER TABLE `alumnos_notas_trabajos` DISABLE KEYS */;
/*!40000 ALTER TABLE `alumnos_notas_trabajos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `docentes`
--

DROP TABLE IF EXISTS `docentes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `docentes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` int(10) unsigned NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `fecha_nacimiento` datetime DEFAULT NULL,
  `fecha_ingreso` datetime DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_docentes_usuario` (`id_usuario`),
  CONSTRAINT `fk_docentes_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
-- Table structure for table `docentes_registro_clases`
--

DROP TABLE IF EXISTS `docentes_registro_clases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `docentes_registro_clases` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Id_Dictado_Materia` int(10) unsigned NOT NULL,
  `id_Usuario_Verificador` int(10) unsigned DEFAULT NULL,
  `Fecha_Clase` date NOT NULL,
  `Observaciones` varchar(255) DEFAULT NULL,
  `id_Docente_A_Cargo` int(10) unsigned DEFAULT NULL,
  `Objetivo_Clase` varchar(255) DEFAULT NULL,
  `Contenidos_Vistos` varchar(255) DEFAULT NULL,
  `Actividades_Desarrolladas` varchar(255) DEFAULT NULL,
  `Numero_Clase` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_fecha_idMateriaDictada` (`Fecha_Clase`,`Id_Dictado_Materia`),
  UNIQUE KEY `uq_numero_clase` (`Id_Dictado_Materia`,`id_Docente_A_Cargo`,`Numero_Clase`),
  KEY `fk_reg_clase_verificador` (`id_Usuario_Verificador`),
  KEY `fk_reg_clase_docente_idx` (`id_Docente_A_Cargo`),
  CONSTRAINT `fk_reg_clase_dictado` FOREIGN KEY (`Id_Dictado_Materia`) REFERENCES `materias_dictado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_reg_clase_docente` FOREIGN KEY (`id_Docente_A_Cargo`) REFERENCES `docentes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_reg_clase_verificador` FOREIGN KEY (`id_Usuario_Verificador`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `docentes_registro_clases`
--

LOCK TABLES `docentes_registro_clases` WRITE;
/*!40000 ALTER TABLE `docentes_registro_clases` DISABLE KEYS */;
INSERT INTO `docentes_registro_clases` VALUES (18,5,NULL,'2026-04-26',NULL,1,NULL,NULL,NULL,2),(19,7,NULL,'2026-04-20',NULL,3,'Probando','Temas Vistos test',NULL,1);
/*!40000 ALTER TABLE `docentes_registro_clases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `docentes_roles`
--

DROP TABLE IF EXISTS `docentes_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `docentes_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `docentes_roles`
--

LOCK TABLES `docentes_roles` WRITE;
/*!40000 ALTER TABLE `docentes_roles` DISABLE KEYS */;
INSERT INTO `docentes_roles` VALUES (1,'Titular'),(2,'Suplente'),(3,'Ayudante');
/*!40000 ALTER TABLE `docentes_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `docentes_trabajos`
--

DROP TABLE IF EXISTS `docentes_trabajos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `docentes_trabajos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_docente_creador` int(10) unsigned NOT NULL,
  `numero_trabajo` int(11) DEFAULT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` varchar(400) DEFAULT NULL,
  `fecha_apertura` datetime DEFAULT NULL,
  `fecha_cierre` datetime DEFAULT NULL,
  `enlace` varchar(255) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_doc_tra_docente_creador_idx` (`id_docente_creador`),
  CONSTRAINT `fk_doc_tra_docente_creador` FOREIGN KEY (`id_docente_creador`) REFERENCES `docentes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `docentes_trabajos`
--

LOCK TABLES `docentes_trabajos` WRITE;
/*!40000 ALTER TABLE `docentes_trabajos` DISABLE KEYS */;
INSERT INTO `docentes_trabajos` VALUES (1,1,1,'TP1','Trabajo integrador unidad 1 a la unidad 4','2026-04-22 00:00:00','2026-05-06 00:00:00',NULL,'2026-04-23 04:26:07','2026-04-23 04:27:41'),(3,1,1,'Oral 1: Unidad 1-4','Conceptos Generales hardware, Historia pc\'s, Microprocesador y Motherboard',NULL,NULL,NULL,'2026-04-23 14:06:43','2026-04-23 14:07:26'),(4,1,1,'ORAL 1: UNIDAD 1-4',NULL,NULL,NULL,NULL,'2026-04-23 14:35:24','2026-04-23 14:35:24');
/*!40000 ALTER TABLE `docentes_trabajos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historico_alumno`
--

DROP TABLE IF EXISTS `historico_alumno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `historico_alumno` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_alumno` int(10) unsigned DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `historico_alumnocol` varchar(45) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `genero` enum('HOMBRE','MUJER','OTRO') DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `legajo` int(11) DEFAULT NULL,
  `fecha_egreso` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_historico_alumno_id_idx` (`id_alumno`),
  CONSTRAINT `fk_historico_alumno_id` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historico_alumno`
--

LOCK TABLES `historico_alumno` WRITE;
/*!40000 ALTER TABLE `historico_alumno` DISABLE KEYS */;
/*!40000 ALTER TABLE `historico_alumno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historico_alumno_materia`
--

DROP TABLE IF EXISTS `historico_alumno_materia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `historico_alumno_materia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_alumno_historico` int(11) NOT NULL,
  `materia` varchar(255) DEFAULT NULL,
  `anio_cursada` int(11) DEFAULT NULL,
  `nota` decimal(4,2) DEFAULT NULL,
  `promedio_asistencia` decimal(4,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_historico_alumno_materia_idx` (`id_alumno_historico`),
  CONSTRAINT `fk_historico_alumno_materia` FOREIGN KEY (`id_alumno_historico`) REFERENCES `historico_alumno` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historico_alumno_materia`
--

LOCK TABLES `historico_alumno_materia` WRITE;
/*!40000 ALTER TABLE `historico_alumno_materia` DISABLE KEYS */;
/*!40000 ALTER TABLE `historico_alumno_materia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historico_alumnos_asistencias`
--

DROP TABLE IF EXISTS `historico_alumnos_asistencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `historico_alumnos_asistencias` (
  `id` int(11) NOT NULL,
  `id_alumno_historico` int(11) DEFAULT NULL,
  `materia` varchar(100) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `hora_retiro` time DEFAULT NULL,
  `hora_tarde` time DEFAULT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `historico_alumnos_asistenciascol` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_historico_asistencias_id_alumno_idx` (`id_alumno_historico`),
  CONSTRAINT `fk_historico_asistencias_id_alumno` FOREIGN KEY (`id_alumno_historico`) REFERENCES `historico_alumno` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historico_alumnos_asistencias`
--

LOCK TABLES `historico_alumnos_asistencias` WRITE;
/*!40000 ALTER TABLE `historico_alumnos_asistencias` DISABLE KEYS */;
/*!40000 ALTER TABLE `historico_alumnos_asistencias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materias`
--

DROP TABLE IF EXISTS `materias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `materias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) NOT NULL,
  `plan` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materias`
--

LOCK TABLES `materias` WRITE;
/*!40000 ALTER TABLE `materias` DISABLE KEYS */;
INSERT INTO `materias` VALUES (3,'Evaluacion de Proyectos',NULL),(4,'Laboratorio de Hardware',NULL),(5,'Introducción a la Programación','2003'),(6,'Introducción a la Robotica','2015');
/*!40000 ALTER TABLE `materias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materias_dictado`
--

DROP TABLE IF EXISTS `materias_dictado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `materias_dictado` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_Materia` int(10) unsigned NOT NULL,
  `Anio_Dictado` int(11) NOT NULL,
  `id_Modulo_Horario` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_dictado_materia` (`id_Materia`),
  KEY `fk_dictado_modulo_idx` (`id_Modulo_Horario`),
  CONSTRAINT `fk_dictado_materia` FOREIGN KEY (`id_Materia`) REFERENCES `materias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_dictado_modulo` FOREIGN KEY (`id_Modulo_Horario`) REFERENCES `materias_modulos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materias_dictado`
--

LOCK TABLES `materias_dictado` WRITE;
/*!40000 ALTER TABLE `materias_dictado` DISABLE KEYS */;
INSERT INTO `materias_dictado` VALUES (1,3,2026,39),(2,3,2026,42),(5,4,2026,36),(6,4,2026,48),(7,5,2026,34),(8,6,2026,35);
/*!40000 ALTER TABLE `materias_dictado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materias_modulos`
--

DROP TABLE IF EXISTS `materias_modulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `materias_modulos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Horario_Desde` time NOT NULL,
  `Horario_Hasta` time NOT NULL,
  `Dia` enum('LUNES','MARTES','MIERCOLES','JUEVES','VIERNES') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materias_modulos`
--

LOCK TABLES `materias_modulos` WRITE;
/*!40000 ALTER TABLE `materias_modulos` DISABLE KEYS */;
INSERT INTO `materias_modulos` VALUES (34,'12:15:00','14:00:00','LUNES'),(35,'14:30:00','16:20:00','LUNES'),(36,'16:40:00','18:30:00','LUNES'),(37,'12:15:00','14:00:00','MARTES'),(38,'14:30:00','16:20:00','MARTES'),(39,'16:40:00','18:30:00','MARTES'),(40,'12:15:00','14:00:00','MIERCOLES'),(41,'14:30:00','16:20:00','MIERCOLES'),(42,'16:40:00','18:30:00','MIERCOLES'),(43,'12:15:00','14:00:00','JUEVES'),(44,'14:30:00','16:20:00','JUEVES'),(45,'16:40:00','18:30:00','JUEVES'),(46,'12:15:00','14:00:00','VIERNES'),(47,'14:30:00','16:20:00','VIERNES'),(48,'16:40:00','18:30:00','VIERNES'),(49,'07:45:00','08:45:00','LUNES'),(50,'08:45:00','09:45:00','LUNES'),(51,'10:00:00','11:00:00','LUNES'),(52,'11:00:00','12:00:00','LUNES'),(53,'07:45:00','08:45:00','MARTES'),(54,'08:45:00','09:45:00','MARTES'),(55,'10:00:00','11:00:00','MARTES'),(56,'11:00:00','12:00:00','MARTES'),(57,'07:45:00','08:45:00','MIERCOLES'),(58,'08:45:00','09:45:00','MIERCOLES'),(59,'10:00:00','11:00:00','MIERCOLES'),(60,'11:00:00','12:00:00','MIERCOLES'),(61,'07:45:00','08:45:00','JUEVES'),(62,'08:45:00','09:45:00','JUEVES'),(63,'10:00:00','11:00:00','JUEVES'),(64,'11:00:00','12:00:00','JUEVES'),(65,'07:45:00','08:45:00','VIERNES'),(66,'08:45:00','09:45:00','VIERNES'),(67,'10:00:00','11:00:00','VIERNES'),(68,'11:00:00','12:00:00','VIERNES');
/*!40000 ALTER TABLE `materias_modulos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mxm_alumnos_materias`
--

DROP TABLE IF EXISTS `mxm_alumnos_materias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mxm_alumnos_materias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_Alumno` int(10) unsigned NOT NULL,
  `id_Materia_Dictado` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_mxm_am_alumno` (`id_Alumno`),
  KEY `fk_mxm_am_dictado` (`id_Materia_Dictado`),
  CONSTRAINT `fk_mxm_am_alumno` FOREIGN KEY (`id_Alumno`) REFERENCES `alumnos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mxm_am_dictado` FOREIGN KEY (`id_Materia_Dictado`) REFERENCES `materias_dictado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mxm_alumnos_materias`
--

LOCK TABLES `mxm_alumnos_materias` WRITE;
/*!40000 ALTER TABLE `mxm_alumnos_materias` DISABLE KEYS */;
INSERT INTO `mxm_alumnos_materias` VALUES (1,65,2),(2,66,2),(3,67,2),(4,68,2),(5,69,2),(6,70,2),(7,71,2),(8,72,2),(9,73,2),(10,74,2),(11,75,2),(12,76,2),(13,77,2),(14,78,2),(15,79,2),(16,80,1),(17,81,1),(18,82,1),(19,83,1),(20,84,1),(21,105,5),(22,106,5),(23,107,5),(24,108,5),(25,109,5),(26,110,5),(27,111,5),(28,112,5),(29,113,5),(30,114,5),(31,115,5),(32,116,5),(33,117,6),(34,118,6),(35,119,6),(36,120,6),(37,121,6),(38,122,6),(39,123,6),(40,124,6),(41,125,6),(42,126,6),(43,127,6),(44,128,6);
/*!40000 ALTER TABLE `mxm_alumnos_materias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mxm_cursos_materias_dictado`
--

DROP TABLE IF EXISTS `mxm_cursos_materias_dictado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mxm_cursos_materias_dictado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_curso` int(10) unsigned NOT NULL,
  `id_materia_dictado` int(10) unsigned NOT NULL,
  `fecha_desde` date DEFAULT NULL,
  `fecha_hasta` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_mxm_cursos_idx` (`id_curso`),
  KEY `fk_mxm_materias_dictado_idx` (`id_materia_dictado`),
  CONSTRAINT `fk_mxm_cursos` FOREIGN KEY (`id_curso`) REFERENCES `alumnos_cursos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mxm_materias_dictado` FOREIGN KEY (`id_materia_dictado`) REFERENCES `materias_dictado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mxm_cursos_materias_dictado`
--

LOCK TABLES `mxm_cursos_materias_dictado` WRITE;
/*!40000 ALTER TABLE `mxm_cursos_materias_dictado` DISABLE KEYS */;
INSERT INTO `mxm_cursos_materias_dictado` VALUES (1,1,2,NULL,NULL),(2,2,1,NULL,NULL),(3,5,5,NULL,NULL),(4,6,6,NULL,NULL),(5,11,7,NULL,NULL),(6,11,8,NULL,NULL);
/*!40000 ALTER TABLE `mxm_cursos_materias_dictado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mxm_docente_materia_dictada`
--

DROP TABLE IF EXISTS `mxm_docente_materia_dictada`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mxm_docente_materia_dictada` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_Docente` int(10) unsigned NOT NULL,
  `id_Docente_Rol` int(10) unsigned NOT NULL,
  `id_Materia_Dictado` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_mxm_dmd_docente` (`id_Docente`),
  KEY `fk_mxm_dmd_rol` (`id_Docente_Rol`),
  KEY `fk_mxm_dmd_dictado` (`id_Materia_Dictado`),
  CONSTRAINT `fk_mxm_dmd_dictado` FOREIGN KEY (`id_Materia_Dictado`) REFERENCES `materias_dictado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mxm_dmd_docente` FOREIGN KEY (`id_Docente`) REFERENCES `docentes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mxm_dmd_rol` FOREIGN KEY (`id_Docente_Rol`) REFERENCES `docentes_roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mxm_docente_materia_dictada`
--

LOCK TABLES `mxm_docente_materia_dictada` WRITE;
/*!40000 ALTER TABLE `mxm_docente_materia_dictada` DISABLE KEYS */;
INSERT INTO `mxm_docente_materia_dictada` VALUES (1,1,1,1),(2,1,1,2),(3,1,1,5),(4,1,1,6),(5,3,1,7),(6,3,1,8);
/*!40000 ALTER TABLE `mxm_docente_materia_dictada` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mxm_docentes_trabajos_dictados`
--

DROP TABLE IF EXISTS `mxm_docentes_trabajos_dictados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mxm_docentes_trabajos_dictados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_trabajo` int(10) unsigned NOT NULL,
  `id_dictado` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_mxm_dtd_trabajo_idx` (`id_trabajo`),
  KEY `fk_mxm_dtd_dictado_idx` (`id_dictado`),
  CONSTRAINT `fk_mxm_dtd_dictado` FOREIGN KEY (`id_dictado`) REFERENCES `materias_dictado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mxm_dtd_trabajo` FOREIGN KEY (`id_trabajo`) REFERENCES `docentes_trabajos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mxm_docentes_trabajos_dictados`
--

LOCK TABLES `mxm_docentes_trabajos_dictados` WRITE;
/*!40000 ALTER TABLE `mxm_docentes_trabajos_dictados` DISABLE KEYS */;
INSERT INTO `mxm_docentes_trabajos_dictados` VALUES (5,1,1),(6,1,2),(9,3,5),(10,4,6);
/*!40000 ALTER TABLE `mxm_docentes_trabajos_dictados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mxm_usuarios_usuarios_roles`
--

DROP TABLE IF EXISTS `mxm_usuarios_usuarios_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mxm_usuarios_usuarios_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` int(10) unsigned NOT NULL,
  `id_rol` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `MxM_Usuarios_Roles_index_0` (`id_usuario`),
  KEY `MxM_Usuarios_Roles_index_1` (`id_rol`),
  CONSTRAINT `fk_mxm_ur_rol` FOREIGN KEY (`id_rol`) REFERENCES `usuarios_roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mxm_ur_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mxm_usuarios_usuarios_roles`
--

LOCK TABLES `mxm_usuarios_usuarios_roles` WRITE;
/*!40000 ALTER TABLE `mxm_usuarios_usuarios_roles` DISABLE KEYS */;
INSERT INTO `mxm_usuarios_usuarios_roles` VALUES (1,1,1),(2,4,1),(3,5,2),(4,6,2),(5,1,5);
/*!40000 ALTER TABLE `mxm_usuarios_usuarios_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('WpqvVDhdbmKH2FX82TyQ21NscDbkD6hbY8h42hRu',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJvUEFCdlFDR0trejd4dmZ1NWh5VnlNcnJEWFY5c1d0T0hTYXBOT0RUIiwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEsIl9wcmV2aW91cyI6eyJ1cmwiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMCIsInJvdXRlIjoiZGFzaGJvYXJkIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1777228000),('wQ6Viy4M0RKba06N5xq4wtbF3mGWPfKIK2lL7GZW',2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJ4bTEweklkMzAyZUJ3MVcySlJtZ2RGYVRqaWxXdlZkRmNyMmMwd3M5IiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pbmlzdHJhY2lvblwvYWx1bW5vc1wvYXNpc3RlbmNpYXM/YWx1bW5vX2lkPTEwNSIsInJvdXRlIjoiYWRtaW5pc3RyYWNpb24uYWx1bW5vcy5hc2lzdGVuY2lhcyJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoyfQ==',1777226761);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_usuario` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contrasenia` varchar(255) NOT NULL,
  `contrasenia_dev` varchar(40) DEFAULT NULL,
  `token_web` varchar(255) DEFAULT NULL,
  `Genero` enum('HOMBRE','MUJER','OTRO') DEFAULT NULL,
  `fecha_email_validacion` datetime DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL,
  `fecha_ultimo_inicio_sesion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
-- Table structure for table `usuarios_roles`
--

DROP TABLE IF EXISTS `usuarios_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `es_admin` tinyint(4) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
-- Temporary view structure for view `view_alumnos_por_dictado_docente`
--

DROP TABLE IF EXISTS `view_alumnos_por_dictado_docente`;
/*!50001 DROP VIEW IF EXISTS `view_alumnos_por_dictado_docente`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_alumnos_por_dictado_docente` AS SELECT 
 1 AS `USUARIO_ID`,
 1 AS `DICTADO_ID`,
 1 AS `ALUMNO_ID`,
 1 AS `ALUMNO_NOMBRE`,
 1 AS `ALUMNO_APELLIDO`,
 1 AS `ALUMNO_LEGAJO`,
 1 AS `ALUMNO_GENERO`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_docentes_materias_dictadas`
--

DROP TABLE IF EXISTS `view_docentes_materias_dictadas`;
/*!50001 DROP VIEW IF EXISTS `view_docentes_materias_dictadas`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_docentes_materias_dictadas` AS SELECT 
 1 AS `USUARIO_ID`,
 1 AS `DICTADO_ID`,
 1 AS `DOCENTE_ID`,
 1 AS `DOCENTE_NOMBRE`,
 1 AS `MATERIA_ID`,
 1 AS `MATERIA_NOMBRE`,
 1 AS `CURSO_ID`,
 1 AS `CURSO_NOMBRE`,
 1 AS `MODULO_DIA`,
 1 AS `MODULO_HORARIO_DESDE`,
 1 AS `MODULO_HORARIO_HASTA`,
 1 AS `MODULO_HORARIO_DESDE_HASTA`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_docentes_registro_clases`
--

DROP TABLE IF EXISTS `view_docentes_registro_clases`;
/*!50001 DROP VIEW IF EXISTS `view_docentes_registro_clases`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_docentes_registro_clases` AS SELECT 
 1 AS `REGISTRO_CLASE_ID`,
 1 AS `DOCENTE_A_CARGO_ID`,
 1 AS `REGISTRO_CLASE_DICTADO_ID`,
 1 AS `DOCENTE_NOMBRE`,
 1 AS `USUARIO_VERIFICADOR_ID`,
 1 AS `USUARIO_VERIFICADOR_NOMBRE`,
 1 AS `REGISTRO_CLASE_FECHA`,
 1 AS `REGISTRO_CLASE_FECHA_DIA`,
 1 AS `REGISTRO_CLASE_NUMERO`,
 1 AS `REGISTRO_CLASE_CURSO`,
 1 AS `REGISTRO_CLASE_OBSERVACIONES`,
 1 AS `REGISTRO_CLASE_HORA_DESDE`,
 1 AS `REGISTRO_CLASE_HORA_HASTA`,
 1 AS `REGISTRO_CLASE_OBJETIVO`,
 1 AS `REGISTRO_CLASE_CONTENIDOS`,
 1 AS `REGISTRO_CLASE_ACTIVIDADES`*/;
SET character_set_client = @saved_cs_client;

--
-- Dumping events for database 'sgitlp'
--

--
-- Dumping routines for database 'sgitlp'
--

--
-- Final view structure for view `view_alumnos_por_dictado_docente`
--

/*!50001 DROP VIEW IF EXISTS `view_alumnos_por_dictado_docente`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_alumnos_por_dictado_docente` AS select `u`.`id` AS `USUARIO_ID`,`md`.`id` AS `DICTADO_ID`,`a`.`id` AS `ALUMNO_ID`,`a`.`nombre` AS `ALUMNO_NOMBRE`,`a`.`apellido` AS `ALUMNO_APELLIDO`,`a`.`legajo` AS `ALUMNO_LEGAJO`,`a`.`Genero` AS `ALUMNO_GENERO` from (((((`materias_dictado` `md` join `mxm_docente_materia_dictada` `mxm_dmd` on(`mxm_dmd`.`id_Materia_Dictado` = `md`.`id`)) join `docentes` `d` on(`d`.`id` = `mxm_dmd`.`id_Docente`)) join `usuarios` `u` on(`u`.`id` = `d`.`id_usuario`)) join `mxm_alumnos_materias` `mxm_am` on(`mxm_am`.`id_Materia_Dictado` = `md`.`id`)) join `alumnos` `a` on(`a`.`id` = `mxm_am`.`id_Alumno`)) where `a`.`activo` = 1 union select `u`.`id` AS `USUARIO_ID`,`md`.`id` AS `DICTADO_ID`,`a`.`id` AS `ALUMNO_ID`,`a`.`nombre` AS `ALUMNO_NOMBRE`,`a`.`apellido` AS `ALUMNO_APELLIDO`,`a`.`legajo` AS `ALUMNO_LEGAJO`,`a`.`Genero` AS `ALUMNO_GENERO` from (((((`materias_dictado` `md` join `mxm_docente_materia_dictada` `mxm_dmd` on(`mxm_dmd`.`id_Materia_Dictado` = `md`.`id`)) join `docentes` `d` on(`d`.`id` = `mxm_dmd`.`id_Docente`)) join `usuarios` `u` on(`u`.`id` = `d`.`id_usuario`)) join `mxm_cursos_materias_dictado` `cmd` on(`cmd`.`id_materia_dictado` = `md`.`id`)) join `alumnos` `a` on(`a`.`id_grupo_taller_actual` = `cmd`.`id_curso`)) where `a`.`activo` = 1 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_docentes_materias_dictadas`
--

/*!50001 DROP VIEW IF EXISTS `view_docentes_materias_dictadas`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_docentes_materias_dictadas` AS select `u`.`id` AS `USUARIO_ID`,`md`.`id` AS `DICTADO_ID`,`d`.`id` AS `DOCENTE_ID`,concat(`u`.`nombre`,' ',`u`.`apellido`) AS `DOCENTE_NOMBRE`,`m`.`id` AS `MATERIA_ID`,`m`.`Nombre` AS `MATERIA_NOMBRE`,`c`.`id` AS `CURSO_ID`,`c`.`nombre` AS `CURSO_NOMBRE`,`mm`.`Dia` AS `MODULO_DIA`,`mm`.`Horario_Desde` AS `MODULO_HORARIO_DESDE`,`mm`.`Horario_Hasta` AS `MODULO_HORARIO_HASTA`,concat(`mm`.`Horario_Desde`,' - ',`mm`.`Horario_Hasta`) AS `MODULO_HORARIO_DESDE_HASTA` from (((((((`materias_dictado` `md` left join `mxm_docente_materia_dictada` `mxm_dmd` on(`mxm_dmd`.`id_Materia_Dictado` = `md`.`id`)) left join `docentes` `d` on(`mxm_dmd`.`id_Docente` = `d`.`id`)) left join `usuarios` `u` on(`d`.`id_usuario` = `u`.`id`)) left join `materias` `m` on(`md`.`id_Materia` = `m`.`id`)) left join `mxm_cursos_materias_dictado` `cmd` on(`md`.`id` = `cmd`.`id_materia_dictado`)) left join `alumnos_cursos` `c` on(`cmd`.`id_curso` = `c`.`id`)) left join `materias_modulos` `mm` on(`md`.`id_Modulo_Horario` = `mm`.`id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_docentes_registro_clases`
--

/*!50001 DROP VIEW IF EXISTS `view_docentes_registro_clases`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_docentes_registro_clases` AS select `drc`.`id` AS `REGISTRO_CLASE_ID`,`drc`.`id_Docente_A_Cargo` AS `DOCENTE_A_CARGO_ID`,`drc`.`Id_Dictado_Materia` AS `REGISTRO_CLASE_DICTADO_ID`,concat(`ud`.`nombre`,' ',`ud`.`apellido`) AS `DOCENTE_NOMBRE`,`drc`.`id_Docente_A_Cargo` AS `USUARIO_VERIFICADOR_ID`,concat(`uv`.`nombre`,' ',`uv`.`apellido`) AS `USUARIO_VERIFICADOR_NOMBRE`,`drc`.`Fecha_Clase` AS `REGISTRO_CLASE_FECHA`,case dayofweek(`drc`.`Fecha_Clase`) when 1 then 'DOMINGO' when 2 then 'LUNES' when 3 then 'MARTES' when 4 then 'MIERCOLES' when 5 then 'JUEVES' when 6 then 'VIERNES' when 7 then 'SABADO' end AS `REGISTRO_CLASE_FECHA_DIA`,`drc`.`Numero_Clase` AS `REGISTRO_CLASE_NUMERO`,concat(`c`.`nombre`,' - ',`m`.`Nombre`) AS `REGISTRO_CLASE_CURSO`,`drc`.`Observaciones` AS `REGISTRO_CLASE_OBSERVACIONES`,`mm`.`Horario_Desde` AS `REGISTRO_CLASE_HORA_DESDE`,`mm`.`Horario_Hasta` AS `REGISTRO_CLASE_HORA_HASTA`,`drc`.`Objetivo_Clase` AS `REGISTRO_CLASE_OBJETIVO`,`drc`.`Contenidos_Vistos` AS `REGISTRO_CLASE_CONTENIDOS`,`drc`.`Actividades_Desarrolladas` AS `REGISTRO_CLASE_ACTIVIDADES` from ((((((((`docentes_registro_clases` `drc` left join `docentes` `d` on(`drc`.`id_Docente_A_Cargo` = `d`.`id`)) left join `usuarios` `ud` on(`d`.`id_usuario` = `ud`.`id`)) left join `usuarios` `uv` on(`drc`.`id_Usuario_Verificador` = `uv`.`id`)) left join `materias_dictado` `md` on(`drc`.`Id_Dictado_Materia` = `md`.`id`)) left join `materias_modulos` `mm` on(`md`.`id_Modulo_Horario` = `mm`.`id`)) left join `mxm_cursos_materias_dictado` `cmd` on(`md`.`id` = `cmd`.`id_materia_dictado`)) left join `alumnos_cursos` `c` on(`cmd`.`id_curso` = `c`.`id`)) left join `materias` `m` on(`md`.`id_Materia` = `m`.`id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-26 15:34:00
