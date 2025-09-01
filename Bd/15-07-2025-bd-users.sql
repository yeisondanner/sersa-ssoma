-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.32-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para bd_users
DROP DATABASE IF EXISTS `bd_users`;
CREATE DATABASE IF NOT EXISTS `bd_users` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `bd_users`;

-- Volcando estructura para tabla bd_users.tb_configuration
DROP TABLE IF EXISTS `tb_configuration`;
CREATE TABLE IF NOT EXISTS `tb_configuration` (
  `idConfiguration` int(11) NOT NULL AUTO_INCREMENT,
  `c_name` varchar(255) NOT NULL,
  `c_logo` varchar(255) NOT NULL DEFAULT 'sin-content.png',
  `c_description` text NOT NULL,
  `c_color_primary` char(10) NOT NULL DEFAULT '#4da8da',
  `c_color_secondary` char(10) NOT NULL DEFAULT '#004e89',
  `c_company_name` varchar(255) NOT NULL DEFAULT 'Innova Master',
  `c_ruc` char(11) NOT NULL DEFAULT '0',
  `c_address` text NOT NULL,
  `c_phone` char(9) NOT NULL DEFAULT '',
  `c_mail` text NOT NULL,
  `c_registrationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `c_updateDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`idConfiguration`) USING BTREE,
  UNIQUE KEY `RUC` (`c_ruc`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla bd_users.tb_configuration: ~1 rows (aproximadamente)
DELETE FROM `tb_configuration`;
INSERT INTO `tb_configuration` (`idConfiguration`, `c_name`, `c_logo`, `c_description`, `c_color_primary`, `c_color_secondary`, `c_company_name`, `c_ruc`, `c_address`, `c_phone`, `c_mail`, `c_registrationDate`, `c_updateDate`) VALUES
	(1, 'Sistema de Roles', '6866b8b7b72ed.png', 'Sistema de gestión de roles y usuarios', '#ff0000', '#940000', 'YDCD', '10734486529', 'Jron Amazonas', '910367611', 'yeisoncarhuapoma@gmail.com', '2025-07-03 16:53:40', '2025-07-05 20:48:06');

-- Volcando estructura para tabla bd_users.tb_interface
DROP TABLE IF EXISTS `tb_interface`;
CREATE TABLE IF NOT EXISTS `tb_interface` (
  `idInterface` int(11) NOT NULL AUTO_INCREMENT,
  `i_name` varchar(250) NOT NULL,
  `i_description` text DEFAULT NULL,
  `i_url` varchar(250) DEFAULT NULL,
  `i_isOption` char(1) DEFAULT '0',
  `i_isPublic` char(1) DEFAULT '0',
  `i_isListNav` char(1) DEFAULT '1',
  `i_status` enum('Activo','Inactivo') DEFAULT 'Activo',
  `i_registrationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `i_updateDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `module_id` int(11) NOT NULL,
  PRIMARY KEY (`idInterface`),
  KEY `module_id` (`module_id`),
  CONSTRAINT `tb_interface_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `tb_module` (`idModule`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla bd_users.tb_interface: ~10 rows (aproximadamente)
DELETE FROM `tb_interface`;
INSERT INTO `tb_interface` (`idInterface`, `i_name`, `i_description`, `i_url`, `i_isOption`, `i_isPublic`, `i_isListNav`, `i_status`, `i_registrationDate`, `i_updateDate`, `module_id`) VALUES
	(1, 'Inicio de Sesion', NULL, 'login', '0', '1', '0', 'Activo', '2025-01-26 15:17:34', '2025-02-02 22:06:32', 1),
	(2, 'Dashboard', NULL, 'dashboard', '0', '0', '0', 'Activo', '2025-01-26 19:37:54', '2025-02-02 18:58:08', 1),
	(3, 'Gestion de Usuarios', NULL, 'users', '0', '0', '1', 'Activo', '2025-01-26 20:10:27', '2025-01-30 23:30:05', 1),
	(4, 'Gestion de Roles', NULL, 'roles', '0', '0', '1', 'Activo', '2025-01-28 22:21:22', '2025-02-02 21:52:15', 1),
	(5, 'Listado de Logs', NULL, 'logs', '0', '0', '1', 'Activo', '2025-01-31 21:49:03', '2025-01-31 21:49:03', 2),
	(6, 'Configuracion del Sistema', NULL, 'system', '0', '0', '1', 'Activo', '2025-02-01 22:29:47', '2025-02-01 22:29:47', 1),
	(7, 'Perfil del usuario', NULL, 'profile', '0', '0', '0', 'Activo', '2025-02-02 16:23:26', '2025-02-02 16:34:31', 1),
	(8, 'Pagina de error 404', NULL, '404', '0', '0', '0', 'Activo', '2025-07-05 19:38:02', '2025-07-05 19:38:02', 1),
	(9, 'Gestionar notificaciones', NULL, 'notification', '0', '0', '1', 'Activo', '2025-07-05 21:55:52', '2025-07-05 22:00:07', 3),
	(20, 'Bloqueo de Sesión', NULL, 'lock', '0', '0', '0', 'Activo', '2025-05-20 13:21:56', '2025-05-20 13:21:56', 1);

-- Volcando estructura para tabla bd_users.tb_log
DROP TABLE IF EXISTS `tb_log`;
CREATE TABLE IF NOT EXISTS `tb_log` (
  `idLog` int(11) NOT NULL AUTO_INCREMENT,
  `l_title` varchar(200) NOT NULL,
  `l_description` text DEFAULT NULL,
  `l_registrationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `l_updateDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `typelog_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`idLog`),
  KEY `user_id` (`user_id`),
  KEY `tb_log_ibfk_1` (`typelog_id`),
  CONSTRAINT `tb_log_ibfk_1` FOREIGN KEY (`typelog_id`) REFERENCES `tb_typelog` (`idTypeLog`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla bd_users.tb_log: ~0 rows (aproximadamente)
DELETE FROM `tb_log`;

-- Volcando estructura para tabla bd_users.tb_module
DROP TABLE IF EXISTS `tb_module`;
CREATE TABLE IF NOT EXISTS `tb_module` (
  `idModule` int(11) NOT NULL AUTO_INCREMENT,
  `m_name` varchar(250) NOT NULL,
  `m_icon` varchar(250) NOT NULL DEFAULT '<i class="fa fa-microchip" aria-hidden="true"></i>',
  `m_description` text DEFAULT NULL,
  `m_status` enum('Activo','Inactivo') DEFAULT 'Activo',
  `m_registrationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `m_updateDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`idModule`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla bd_users.tb_module: ~3 rows (aproximadamente)
DELETE FROM `tb_module`;
INSERT INTO `tb_module` (`idModule`, `m_name`, `m_icon`, `m_description`, `m_status`, `m_registrationDate`, `m_updateDate`) VALUES
	(1, 'Configuracion del sistema', '<i class="fa fa-cog" aria-hidden="true"></i>', 'Aqui se encuentra toda la configuracion inicial del sistema', 'Activo', '2025-01-26 15:17:10', '2025-02-02 22:46:08'),
	(2, 'Logs', '<i class="fa fa-microchip" aria-hidden="true"></i>', 'Aqui se visualizara los logs del sistema', 'Activo', '2025-01-31 21:32:16', '2025-01-31 21:48:21'),
	(3, 'Gestion de notificaciones', '<i class="fa fa-bell-o" aria-hidden="true"></i>', 'Aqui se gestiona todas las notificaciones que se realiza, como tambien enviar notificaciones a los usuarios o todos los usuarios dle sistema', 'Activo', '2025-07-05 21:54:58', '2025-07-05 21:54:58');

-- Volcando estructura para tabla bd_users.tb_notification
DROP TABLE IF EXISTS `tb_notification`;
CREATE TABLE IF NOT EXISTS `tb_notification` (
  `idNotification` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único de la notificación',
  `user_id` int(11) NOT NULL COMMENT 'ID del usuario destinatario de la notificación',
  `n_title` varchar(255) NOT NULL COMMENT 'Título breve de la notificación',
  `n_description` text DEFAULT NULL COMMENT 'Descripción detallada o cuerpo de la notificación',
  `n_link` text DEFAULT NULL COMMENT 'Enlace relevante que acompaña a la notificación (si aplica)',
  `n_icon` varchar(255) DEFAULT 'fa-envelope' COMMENT 'Clase del icono (FontAwesome u otro)',
  `n_color` varchar(255) DEFAULT 'primary',
  `n_type` enum('info','success','warning','error','custom') DEFAULT 'info' COMMENT 'Tipo de notificación',
  `n_priority` tinyint(4) DEFAULT 1 COMMENT 'Nivel de prioridad (1 = baja, 2 = media, 3 = alta)',
  `n_is_read` tinyint(1) DEFAULT 0 COMMENT 'Indica si la notificación ya fue leída',
  `n_status` enum('activo','inactivo') DEFAULT 'activo' COMMENT 'Estado de la notificación (por si se desactiva o elimina lógicamente)',
  `n_created_at` datetime DEFAULT current_timestamp() COMMENT 'Fecha y hora de creación',
  `n_updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Última fecha de actualización',
  PRIMARY KEY (`idNotification`) USING BTREE,
  KEY `idx_user_read` (`user_id`,`n_is_read`),
  KEY `idx_priority_type` (`n_priority`,`n_type`),
  CONSTRAINT `tb_notification_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`idUser`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla bd_users.tb_notification: ~0 rows (aproximadamente)
DELETE FROM `tb_notification`;

-- Volcando estructura para tabla bd_users.tb_role
DROP TABLE IF EXISTS `tb_role`;
CREATE TABLE IF NOT EXISTS `tb_role` (
  `idRole` int(11) NOT NULL AUTO_INCREMENT,
  `r_name` varchar(250) NOT NULL,
  `r_description` text DEFAULT NULL,
  `r_status` enum('Activo','Inactivo') DEFAULT 'Activo',
  `r_registrationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `r_updateDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`idRole`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla bd_users.tb_role: ~1 rows (aproximadamente)
DELETE FROM `tb_role`;
INSERT INTO `tb_role` (`idRole`, `r_name`, `r_description`, `r_status`, `r_registrationDate`, `r_updateDate`) VALUES
	(1, 'Root', 'El rol Root es el usuario con los privilegios más elevados dentro del sistema. Tiene control total sobre la configuración, la administración de usuarios, la seguridad y la gestión de recursos. Este rol está destinado exclusivamente a tareas de administración crítica y debe ser utilizado con precaución para evitar daños en el sistema.', 'Activo', '2025-01-26 21:34:50', '2025-07-02 13:43:04');

-- Volcando estructura para tabla bd_users.tb_typelog
DROP TABLE IF EXISTS `tb_typelog`;
CREATE TABLE IF NOT EXISTS `tb_typelog` (
  `idTypeLog` int(11) NOT NULL AUTO_INCREMENT,
  `tl_name` varchar(100) NOT NULL,
  `tl_description` text DEFAULT NULL,
  `tl_status` enum('Activo','Inactivo') DEFAULT 'Activo',
  `tl_registrationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `tl_updateDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`idTypeLog`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla bd_users.tb_typelog: ~3 rows (aproximadamente)
DELETE FROM `tb_typelog`;
INSERT INTO `tb_typelog` (`idTypeLog`, `tl_name`, `tl_description`, `tl_status`, `tl_registrationDate`, `tl_updateDate`) VALUES
	(1, 'Error', NULL, 'Activo', '2025-01-26 15:14:03', '2025-01-26 15:14:03'),
	(2, 'Correcto', NULL, 'Activo', '2025-01-27 05:26:47', '2025-01-27 05:26:47'),
	(3, 'Información', NULL, 'Activo', '2025-01-27 05:26:57', '2025-01-27 05:26:57');

-- Volcando estructura para tabla bd_users.tb_user
DROP TABLE IF EXISTS `tb_user`;
CREATE TABLE IF NOT EXISTS `tb_user` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `u_user` text NOT NULL,
  `u_password` text NOT NULL,
  `u_email` text NOT NULL,
  `u_profile` text DEFAULT NULL,
  `u_fullname` varchar(200) NOT NULL,
  `u_gender` enum('Masculino','Femenino','Otro') NOT NULL,
  `u_dni` char(8) NOT NULL,
  `u_status` enum('Activo','Inactivo') DEFAULT 'Activo',
  `u_registrationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `u_updateDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `u_online` tinyint(4) NOT NULL DEFAULT 0,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `u_dni` (`u_dni`),
  UNIQUE KEY `u_user` (`u_user`) USING HASH,
  UNIQUE KEY `u_email` (`u_email`) USING HASH,
  KEY `role_id` (`role_id`),
  CONSTRAINT `tb_user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `tb_role` (`idRole`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla bd_users.tb_user: ~1 rows (aproximadamente)
DELETE FROM `tb_user`;
INSERT INTO `tb_user` (`idUser`, `u_user`, `u_password`, `u_email`, `u_profile`, `u_fullname`, `u_gender`, `u_dni`, `u_status`, `u_registrationDate`, `u_updateDate`, `u_online`, `role_id`) VALUES
	(1, 'OHl4NXRSbFRqbSs1UW9mbEpxNnNPQT09', 'OHl4NXRSbFRqbSs1UW9mbEpxNnNPQT09', 'VTJxUmZLN2x5N0FrKzJMamRtLzR3Zz09', '68766c8ecada3.png', 'Super Administrador Sistema Roles', 'Otro', '12345678', 'Activo', '2025-01-28 18:49:20', '2025-07-15 14:59:04', 1, 1);

-- Volcando estructura para tabla bd_users.tb_userroledetail
DROP TABLE IF EXISTS `tb_userroledetail`;
CREATE TABLE IF NOT EXISTS `tb_userroledetail` (
  `idUserRoleDetail` int(11) NOT NULL AUTO_INCREMENT,
  `interface_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `urd_status` enum('Activo','Inactivo') DEFAULT 'Activo',
  `urd_registrationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `urd_updateDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`idUserRoleDetail`),
  KEY `tb_userroledetail_ibfk_1` (`interface_id`),
  KEY `tb_userroledetail_ibfk_2` (`role_id`),
  CONSTRAINT `tb_userroledetail_ibfk_1` FOREIGN KEY (`interface_id`) REFERENCES `tb_interface` (`idInterface`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tb_userroledetail_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `tb_role` (`idRole`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla bd_users.tb_userroledetail: ~10 rows (aproximadamente)
DELETE FROM `tb_userroledetail`;
INSERT INTO `tb_userroledetail` (`idUserRoleDetail`, `interface_id`, `role_id`, `urd_status`, `urd_registrationDate`, `urd_updateDate`) VALUES
	(1, 1, 1, 'Activo', '2025-01-30 22:56:54', '2025-07-05 21:57:19'),
	(2, 2, 1, 'Activo', '2025-07-05 19:38:33', '2025-07-05 21:57:22'),
	(3, 3, 1, 'Activo', '2025-01-30 22:57:13', '2025-07-05 21:57:25'),
	(4, 4, 1, 'Activo', '2025-01-30 22:57:45', '2025-07-05 21:57:38'),
	(5, 5, 1, 'Activo', '2025-01-30 22:58:01', '2025-07-05 21:57:43'),
	(6, 6, 1, 'Activo', '2025-07-05 21:56:11', '2025-07-05 21:57:47'),
	(7, 7, 1, 'Activo', '2025-01-31 21:49:27', '2025-07-05 21:57:50'),
	(8, 8, 1, 'Activo', '2025-02-01 22:30:01', '2025-07-05 21:57:53'),
	(9, 9, 1, 'Activo', '2025-05-20 13:22:11', '2025-07-05 21:57:56'),
	(20, 20, 1, 'Activo', '2025-02-02 21:49:55', '2025-07-05 21:58:12');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
