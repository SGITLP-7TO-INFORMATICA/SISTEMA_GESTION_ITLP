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

-- Dump completed on 2026-04-26 15:34:32
