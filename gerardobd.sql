-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.32-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.7.0.6850
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para gerardo_db
CREATE DATABASE IF NOT EXISTS `gerardo_db` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;
USE `gerardo_db`;

-- Volcando estructura para tabla gerardo_db.accesos
CREATE TABLE IF NOT EXISTS `accesos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `materia_id` int(11) DEFAULT NULL,
  `juego_id` int(11) DEFAULT NULL,
  `proyecto_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `materia_id` (`materia_id`),
  KEY `juego_id` (`juego_id`),
  KEY `proyecto_id` (`proyecto_id`),
  CONSTRAINT `accesos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`),
  CONSTRAINT `accesos_ibfk_2` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`materia_id`),
  CONSTRAINT `accesos_ibfk_3` FOREIGN KEY (`juego_id`) REFERENCES `juegos` (`juego_id`),
  CONSTRAINT `accesos_ibfk_4` FOREIGN KEY (`proyecto_id`) REFERENCES `proyectos` (`proyecto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla gerardo_db.accesos: ~4 rows (aproximadamente)
INSERT INTO `accesos` (`id`, `usuario_id`, `materia_id`, `juego_id`, `proyecto_id`) VALUES
	(1, 1, 1, 2, 1),
	(2, 2, 2, 3, 2),
	(3, 3, 3, 1, 3),
	(4, 4, 4, 4, 4);

-- Volcando estructura para tabla gerardo_db.juegos
CREATE TABLE IF NOT EXISTS `juegos` (
  `juego_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`juego_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla gerardo_db.juegos: ~4 rows (aproximadamente)
INSERT INTO `juegos` (`juego_id`, `nombre`, `descripcion`) VALUES
	(1, 'Juego de Adivinanza', 'Un juego divertido donde tendrás que adivinar palabras a partir de pistas y acertijos.'),
	(2, 'Simulador de Experimentos', 'Este juego te permite crear experimentos científicos de manera virtual.'),
	(3, 'Trivia de Historia', 'Pon a prueba tus conocimientos sobre la historia mundial con preguntas y respuestas.'),
	(4, 'Juego de Trivia Científica', 'Un juego desafiante donde tendrás que responder preguntas sobre temas científicos.');

-- Volcando estructura para tabla gerardo_db.materias
CREATE TABLE IF NOT EXISTS `materias` (
  `materia_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` mediumtext DEFAULT NULL,
  PRIMARY KEY (`materia_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla gerardo_db.materias: ~4 rows (aproximadamente)
INSERT INTO `materias` (`materia_id`, `nombre`, `descripcion`) VALUES
	(1, 'Matemáticas', 'Las matemáticas son el estudio de los números, estructuras, espacio y cambio.'),
	(2, 'Ciencias', 'Las ciencias se centran en entender el mundo natural a través de la observación y experimentación.'),
	(3, 'Historia', 'La historia es el estudio de eventos pasados, sus causas y consecuencias.'),
	(4, 'Física', 'La física estudia las leyes fundamentales del universo.');

-- Volcando estructura para tabla gerardo_db.proyectos
CREATE TABLE IF NOT EXISTS `proyectos` (
  `proyecto_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` mediumtext DEFAULT NULL,
  PRIMARY KEY (`proyecto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla gerardo_db.proyectos: ~4 rows (aproximadamente)
INSERT INTO `proyectos` (`proyecto_id`, `nombre`, `descripcion`) VALUES
	(1, 'Proyecto de Investigación', 'Desarrolla habilidades de investigación a través de proyectos educativos.'),
	(2, 'Proyecto de Biología', 'Aprende sobre la vida y los seres vivos a través de proyectos interactivos.'),
	(3, 'Proyecto de Línea de Tiempo', 'Crea y visualiza eventos históricos en una línea de tiempo interactiva.'),
	(4, 'Proyecto de Astronomía', 'Explora el universo y aprende sobre las estrellas y galaxias.');

-- Volcando estructura para tabla gerardo_db.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `usuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','usuario') DEFAULT 'usuario',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `token` varchar(255) DEFAULT NULL,
  `token_expira` datetime DEFAULT NULL,
  PRIMARY KEY (`usuario_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla gerardo_db.usuarios: ~5 rows (aproximadamente)
INSERT INTO `usuarios` (`usuario_id`, `nombre`, `email`, `password`, `rol`, `created_at`, `token`, `token_expira`) VALUES
	(1, 'Gerardo', 'gerardo@example.com', '$2y$10$eNMxCkADwRykJeBpzAg6qu9EXi10quWI3QOcssNKKN71XMtz2hEgm', 'usuario', '2025-02-10 11:49:41', 'db6c43b4778317ac0ce035ca7ba8a58d0fa3beef69111b511773b396c84ad52c85af17f2ca83b82f291b42a33cc825daa7da', '2025-02-17 23:19:56'),
	(2, 'Josue', 'josue@example.com', '$2y$10$BdU6hk4udfZRhXvawchV0u8XyR41mYB5WdRwRII62m8h3J5G/APju', 'usuario', '2025-02-10 11:49:41', NULL, NULL),
	(3, 'Alexis', 'alexis@example.com', '$2y$10$8Ii0mA6KO93L1iDyEi.7VutK7jNq5s6R1GDa9AXAJq43uUcsBtQ06', 'usuario', '2025-02-10 11:49:42', NULL, NULL),
	(4, 'Yahir', 'yahir@example.com', '$2y$10$LMNOF1IT0a7x2Dt/eJn6ye55qZnG1z0kyTni0wdcChgJYHtHGhsQG', 'usuario', '2025-02-10 11:49:42', NULL, NULL),
	(5, 'Wilber', 'wilber@example.com', '$2y$10$QFiLpCVrD3JdyuCJ1g1P3ehMo7DgfeX0kg/gSXjQdcpWq/Aox8LA6', 'admin', '2025-02-10 11:49:42', NULL, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
