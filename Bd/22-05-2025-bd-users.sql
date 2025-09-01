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
  `c_logo` varchar(255) NOT NULL,
  `c_description` text NOT NULL,
  `c_registrationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `c_updateDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`idConfiguration`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla bd_users.tb_configuration: ~0 rows (aproximadamente)
DELETE FROM `tb_configuration`;
INSERT INTO `tb_configuration` (`idConfiguration`, `c_name`, `c_logo`, `c_description`, `c_registrationDate`, `c_updateDate`) VALUES
	(1, 'Sistema Roles', 'Sistema Roles-group.png', 'Sistema de usuarios y control de accesos seguro y eficiente. Gestiona permisos, roles y autenticación con facilidad. Optimiza la seguridad y administración de accesos en tu empresa o plataforma.', '2025-02-02 00:49:12', '2025-02-03 03:36:54');

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

-- Volcando datos para la tabla bd_users.tb_interface: ~8 rows (aproximadamente)
DELETE FROM `tb_interface`;
INSERT INTO `tb_interface` (`idInterface`, `i_name`, `i_description`, `i_url`, `i_isOption`, `i_isPublic`, `i_isListNav`, `i_status`, `i_registrationDate`, `i_updateDate`, `module_id`) VALUES
	(1, 'Inicio de Sesion', NULL, 'login', '0', '1', '0', 'Activo', '2025-01-26 15:17:34', '2025-02-02 22:06:32', 1),
	(2, 'Dashboard', NULL, 'dashboard', '0', '0', '0', 'Activo', '2025-01-26 19:37:54', '2025-02-02 18:58:08', 1),
	(3, 'Gestion de Usuarios', NULL, 'users', '0', '0', '1', 'Activo', '2025-01-26 20:10:27', '2025-01-30 23:30:05', 1),
	(4, 'Gestion de Roles', NULL, 'roles', '0', '0', '1', 'Activo', '2025-01-28 22:21:22', '2025-02-02 21:52:15', 1),
	(5, 'Listado de Logs', NULL, 'logs', '0', '0', '1', 'Activo', '2025-01-31 21:49:03', '2025-01-31 21:49:03', 2),
	(6, 'Configuracion del Sistema', NULL, 'system', '0', '0', '1', 'Activo', '2025-02-01 22:29:47', '2025-02-01 22:29:47', 1),
	(7, 'Perfil del usuario', NULL, 'profile', '0', '0', '0', 'Activo', '2025-02-02 16:23:26', '2025-02-02 16:34:31', 1),
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
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla bd_users.tb_log: ~72 rows (aproximadamente)
DELETE FROM `tb_log`;
INSERT INTO `tb_log` (`idLog`, `l_title`, `l_description`, `l_registrationDate`, `l_updateDate`, `typelog_id`, `user_id`) VALUES
	(1, 'Inicio de sesion exitoso', 'El usuario Super Administrador Sistema Roles, completo de manera satisfactoria el inicio de sesion', '2025-05-20 13:13:54', '2025-05-20 13:13:54', 2, 1),
	(2, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:13:56', '2025-05-20 13:13:56', 3, 1),
	(3, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:14:05', '2025-05-20 13:14:05', 3, 1),
	(4, 'Información de navegación', 'El usuario entro a :Gestión de Roles', '2025-05-20 13:14:14', '2025-05-20 13:14:14', 3, 1),
	(5, 'Información de navegación', 'El usuario entro a :Gestión de Roles', '2025-05-20 13:14:24', '2025-05-20 13:14:24', 3, 1),
	(6, 'Información de navegación', 'El usuario entro a :Gestión de Roles', '2025-05-20 13:15:53', '2025-05-20 13:15:53', 3, 1),
	(7, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:15:55', '2025-05-20 13:15:55', 3, 1),
	(8, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:16:43', '2025-05-20 13:16:43', 3, 1),
	(9, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:19:00', '2025-05-20 13:19:00', 3, 1),
	(10, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:05', '2025-05-20 13:20:05', 3, 1),
	(11, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:19', '2025-05-20 13:20:19', 3, 1),
	(12, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:20', '2025-05-20 13:20:20', 3, 1),
	(13, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:20', '2025-05-20 13:20:20', 3, 1),
	(14, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:20', '2025-05-20 13:20:20', 3, 1),
	(15, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:20', '2025-05-20 13:20:20', 3, 1),
	(16, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:20', '2025-05-20 13:20:20', 3, 1),
	(17, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:20', '2025-05-20 13:20:20', 3, 1),
	(18, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:20', '2025-05-20 13:20:20', 3, 1),
	(19, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:20', '2025-05-20 13:20:20', 3, 1),
	(20, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:20', '2025-05-20 13:20:20', 3, 1),
	(21, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:20', '2025-05-20 13:20:20', 3, 1),
	(22, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:20', '2025-05-20 13:20:20', 3, 1),
	(23, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:20', '2025-05-20 13:20:20', 3, 1),
	(24, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:21', '2025-05-20 13:20:21', 3, 1),
	(25, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:21', '2025-05-20 13:20:21', 3, 1),
	(26, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:21', '2025-05-20 13:20:21', 3, 1),
	(27, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:21', '2025-05-20 13:20:21', 3, 1),
	(28, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:21', '2025-05-20 13:20:21', 3, 1),
	(29, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:21', '2025-05-20 13:20:21', 3, 1),
	(30, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:21', '2025-05-20 13:20:21', 3, 1),
	(31, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:21', '2025-05-20 13:20:21', 3, 1),
	(32, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:21', '2025-05-20 13:20:21', 3, 1),
	(33, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:22', '2025-05-20 13:20:22', 3, 1),
	(34, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:22', '2025-05-20 13:20:22', 3, 1),
	(35, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:22', '2025-05-20 13:20:22', 3, 1),
	(36, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:22', '2025-05-20 13:20:22', 3, 1),
	(37, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:22', '2025-05-20 13:20:22', 3, 1),
	(38, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:22', '2025-05-20 13:20:22', 3, 1),
	(39, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:22', '2025-05-20 13:20:22', 3, 1),
	(40, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:22', '2025-05-20 13:20:22', 3, 1),
	(41, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:22', '2025-05-20 13:20:22', 3, 1),
	(42, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:22', '2025-05-20 13:20:22', 3, 1),
	(43, 'Información de navegación', 'Cuenta de usuario bloqueada por inactividad', '2025-05-20 13:20:44', '2025-05-20 13:20:44', 3, 1),
	(44, 'Cierre de sesion forzado', 'La cuenta no tiene permiso a ingresar en esta vist, por lo que se esta forzando a cerrar sesion', '2025-05-20 13:20:44', '2025-05-20 13:20:44', 3, 1),
	(45, 'Información de navegación', 'El usuario entró a :Bloqueo de pantalla', '2025-05-20 13:20:44', '2025-05-20 13:20:44', 3, 1),
	(46, 'Cierre de sesion', 'El usuario Super Administrador Sistema Roles ah cerrado sesion en el sistema', '2025-05-20 13:20:44', '2025-05-20 13:20:44', 2, 1),
	(47, 'Inicio de sesion exitoso', 'El usuario Super Administrador Sistema Roles, completo de manera satisfactoria el inicio de sesion', '2025-05-20 13:20:53', '2025-05-20 13:20:53', 2, 1),
	(48, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:20:54', '2025-05-20 13:20:54', 3, 1),
	(49, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:22:15', '2025-05-20 13:22:15', 3, 1),
	(50, 'Información de navegación', 'Cuenta de usuario bloqueada por inactividad', '2025-05-20 13:22:45', '2025-05-20 13:22:45', 3, 1),
	(51, 'Información de navegación', 'El usuario entró a :Bloqueo de pantalla', '2025-05-20 13:22:45', '2025-05-20 13:22:45', 3, 1),
	(52, 'Ocurrió un error inesperado', 'El usuario OHl4NXRSbFRqbSs1UW9mbEpxNnNPQT09 o contraseña NDlKY09zOXdweWsvOVdGd2J3d1M3dz09 que esta intentando ingresar no existe', '2025-05-20 13:22:54', '2025-05-20 13:22:54', 1, 1),
	(53, 'Inicio de sesion exitoso', 'El usuario Super Administrador Sistema Roles, completo de manera satisfactoria el desbloqueo del sistema', '2025-05-20 13:22:57', '2025-05-20 13:22:57', 2, 1),
	(54, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:22:58', '2025-05-20 13:22:58', 3, 1),
	(55, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:23:13', '2025-05-20 13:23:13', 3, 1),
	(56, 'Información de navegación', 'El usuario entro a :Gestión de Roles', '2025-05-20 13:23:24', '2025-05-20 13:23:24', 3, 1),
	(57, 'Información de navegación', 'El usuario entro a :Gestion de Usuarios', '2025-05-20 13:23:26', '2025-05-20 13:23:26', 3, 1),
	(58, 'Información de navegación', 'El usuario entro a :Historial de registros', '2025-05-20 13:23:30', '2025-05-20 13:23:30', 3, 1),
	(59, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:24:07', '2025-05-20 13:24:07', 3, 1),
	(60, 'Información de navegación', 'El usuario entro a :Gestión de Roles', '2025-05-20 13:24:11', '2025-05-20 13:24:11', 3, 1),
	(61, 'Información de navegación', 'El usuario entro a :Gestion de Usuarios', '2025-05-20 13:24:12', '2025-05-20 13:24:12', 3, 1),
	(62, 'Información de navegación', 'El usuario entro a :Configruacion del Sistema', '2025-05-20 13:24:13', '2025-05-20 13:24:13', 3, 1),
	(63, 'Información de navegación', 'El usuario entro a :Configruacion del Sistema', '2025-05-20 13:24:17', '2025-05-20 13:24:17', 3, 1),
	(64, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 13:29:52', '2025-05-20 13:29:52', 3, 1),
	(65, 'Tiempo de inactividad', 'El usuario ha estado inactivo durante -Tiempo inactivo: 5 minutos y 39 segundos.', '2025-05-20 13:29:52', '2025-05-20 13:29:52', 3, 1),
	(66, 'Tiempo de inactividad', 'El usuario ha estado inactivo durante -Tiempo inactivo: 1 minutos y 57 segundos.', '2025-05-20 13:31:49', '2025-05-20 13:31:49', 3, 1),
	(67, 'Información de navegación', 'Cuenta de usuario bloqueada por inactividad', '2025-05-20 15:17:28', '2025-05-20 15:17:28', 3, 1),
	(68, 'Información de navegación', 'El usuario entró a :Bloqueo de pantalla', '2025-05-20 15:17:28', '2025-05-20 15:17:28', 3, 1),
	(69, 'Inicio de sesion exitoso', 'El usuario Super Administrador Sistema Roles, completo de manera satisfactoria el desbloqueo del sistema', '2025-05-20 15:17:32', '2025-05-20 15:17:32', 2, 1),
	(70, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 15:17:33', '2025-05-20 15:17:33', 3, 1),
	(71, 'Información de navegación', 'Cuenta de usuario bloqueada por inactividad', '2025-05-20 17:10:12', '2025-05-20 17:10:12', 3, 1),
	(72, 'Información de navegación', 'El usuario entró a :Bloqueo de pantalla', '2025-05-20 17:10:12', '2025-05-20 17:10:12', 3, 1),
	(73, 'Información de navegación', 'El usuario entró a :Bloqueo de pantalla', '2025-05-20 17:17:38', '2025-05-20 17:17:38', 3, 1),
	(74, 'Ocurrió un error inesperado', 'El usuario OHl4NXRSbFRqbSs1UW9mbEpxNnNPQT09 o contraseña cy8vQXlEUFVuSm5mK2ZpWC9rR3psZz09 que esta intentando ingresar no existe', '2025-05-20 17:17:45', '2025-05-20 17:17:45', 1, 1),
	(75, 'Ocurrió un error inesperado', 'El usuario OHl4NXRSbFRqbSs1UW9mbEpxNnNPQT09 o contraseña N04zZjJLRENBd3RaS1dMYUFlazJidz09 que esta intentando ingresar no existe', '2025-05-20 17:17:53', '2025-05-20 17:17:53', 1, 1),
	(76, 'Inicio de sesion exitoso', 'El usuario Super Administrador Sistema Roles, completo de manera satisfactoria el desbloqueo del sistema', '2025-05-20 17:17:58', '2025-05-20 17:17:58', 2, 1),
	(77, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-05-20 17:17:59', '2025-05-20 17:17:59', 3, 1),
	(78, 'Cierre de sesion', 'El usuario Super Administrador Sistema Roles ah cerrado sesion en el sistema', '2025-05-20 17:19:00', '2025-05-20 17:19:00', 2, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla bd_users.tb_module: ~2 rows (aproximadamente)
DELETE FROM `tb_module`;
INSERT INTO `tb_module` (`idModule`, `m_name`, `m_icon`, `m_description`, `m_status`, `m_registrationDate`, `m_updateDate`) VALUES
	(1, 'Configuracion del sistema', '<i class="fa fa-cog" aria-hidden="true"></i>', 'Aqui se encuentra toda la configuracion inicial del sistema', 'Activo', '2025-01-26 15:17:10', '2025-02-02 22:46:08'),
	(2, 'Logs', '<i class="fa fa-microchip" aria-hidden="true"></i>', 'Aqui se visualizara los logs del sistema', 'Activo', '2025-01-31 21:32:16', '2025-01-31 21:48:21');

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla bd_users.tb_role: ~0 rows (aproximadamente)
DELETE FROM `tb_role`;
INSERT INTO `tb_role` (`idRole`, `r_name`, `r_description`, `r_status`, `r_registrationDate`, `r_updateDate`) VALUES
	(1, 'Root', 'El rol Root es el usuario con los privilegios más elevados dentro del sistema. Tiene control total sobre la configuración, la administración de usuarios, la seguridad y la gestión de recursos. Este rol está destinado exclusivamente a tareas de administración crítica y debe ser utilizado con precaución para evitar daños en el sistema.', 'Activo', '2025-01-26 21:34:50', '2025-02-02 22:52:24');

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
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `u_dni` (`u_dni`),
  UNIQUE KEY `u_user` (`u_user`) USING HASH,
  UNIQUE KEY `u_email` (`u_email`) USING HASH,
  KEY `role_id` (`role_id`),
  CONSTRAINT `tb_user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `tb_role` (`idRole`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla bd_users.tb_user: ~0 rows (aproximadamente)
DELETE FROM `tb_user`;
INSERT INTO `tb_user` (`idUser`, `u_user`, `u_password`, `u_email`, `u_profile`, `u_fullname`, `u_gender`, `u_dni`, `u_status`, `u_registrationDate`, `u_updateDate`, `role_id`) VALUES
	(1, 'OHl4NXRSbFRqbSs1UW9mbEpxNnNPQT09', 'OHl4NXRSbFRqbSs1UW9mbEpxNnNPQT09', 'VTJxUmZLN2x5N0FrKzJMamRtLzR3Zz09', 'OHl4NXRSbFRqbSs1UW9mbEpxNnNPQT09-group.png', 'Super Administrador Sistema Roles', 'Otro', '12345678', 'Activo', '2025-01-28 18:49:20', '2025-02-05 21:01:49', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla bd_users.tb_userroledetail: ~7 rows (aproximadamente)
DELETE FROM `tb_userroledetail`;
INSERT INTO `tb_userroledetail` (`idUserRoleDetail`, `interface_id`, `role_id`, `urd_status`, `urd_registrationDate`, `urd_updateDate`) VALUES
	(1, 2, 1, 'Activo', '2025-01-30 22:56:54', '2025-02-04 03:54:12'),
	(3, 4, 1, 'Activo', '2025-01-30 22:57:13', '2025-01-31 20:57:48'),
	(4, 3, 1, 'Activo', '2025-01-30 22:57:45', '2025-01-31 21:26:09'),
	(5, 1, 1, 'Activo', '2025-01-30 22:58:01', '2025-01-31 20:57:51'),
	(7, 5, 1, 'Activo', '2025-01-31 21:49:27', '2025-01-31 21:49:27'),
	(8, 6, 1, 'Activo', '2025-02-01 22:30:01', '2025-02-01 22:30:01'),
	(9, 20, 1, 'Activo', '2025-05-20 13:22:11', '2025-05-20 13:22:11'),
	(11, 7, 1, 'Activo', '2025-02-02 21:49:55', '2025-02-02 21:49:55');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
