-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-02-2024 a las 18:55:08
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_srol`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alertas`
--

CREATE TABLE `alertas` (
  `idAlertas` int(11) NOT NULL,
  `mensajeAlertas` text NOT NULL,
  `tipoAlertas` varchar(20) NOT NULL,
  `creationDateAlertas` timestamp NULL DEFAULT current_timestamp(),
  `updateDateAlerta` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alertas`
--

INSERT INTO `alertas` (`idAlertas`, `mensajeAlertas`, `tipoAlertas`, `creationDateAlertas`, `updateDateAlerta`) VALUES
(1, 'Registró completado correctamente.', 'Correcto', '2023-08-03 19:40:16', '2023-08-05 23:20:52'),
(2, 'No se ha conseguido completar el registro.', 'Error', '2023-08-03 19:44:35', '2023-08-05 21:41:41'),
(3, 'Acceso al sistema correcto', 'Correcto', '2023-08-05 16:33:48', '2023-08-05 16:33:48'),
(4, 'Cuenta de usuario, se encuentra desactivada.', 'Error', '2023-08-05 16:36:30', '2023-08-05 16:36:30'),
(5, 'Las credenciales ingresadas son incorrectos.', 'Error', '2023-08-05 16:38:50', '2023-08-05 16:38:50'),
(6, 'Ingrese usuario y contraseña', 'Información', '2023-08-05 16:43:01', '2023-08-05 21:03:39'),
(7, 'Rol se encuentra desactivado', 'Información', '2023-08-05 20:16:01', '2023-08-05 20:16:01'),
(8, 'Trabajador se encuentra desactivado', 'Información', '2023-08-05 20:17:19', '2023-08-05 20:17:19'),
(9, 'Persona se encuentra desactivada', 'Información', '2023-08-05 20:22:09', '2023-08-05 20:22:09'),
(10, 'Empresa se encuentra desactivada', 'Información', '2023-08-05 20:42:19', '2023-08-05 20:42:19'),
(11, 'No cumple con el formato solicitado.', 'Error', '2023-08-05 20:44:09', '2023-08-05 22:44:14'),
(12, 'Complete los campos que son obligatorios.', 'Error', '2023-08-05 22:42:40', '2023-08-05 22:46:20'),
(13, 'Asegúrese de seleccionar un elemento de la lista.', 'Error', '2023-08-05 22:38:44', '2023-08-05 22:38:44'),
(15, 'No es posible eliminar este registro, ya que está relacionado con otro registro.', 'Error', '2023-08-08 02:39:52', '2023-08-08 02:39:52'),
(16, 'Registró eliminado correctamente.', 'Correcto', '2023-08-08 02:45:25', '2023-08-08 02:45:25'),
(17, 'No se ha conseguido eliminar el registro.', 'Error', '2023-08-08 02:45:46', '2023-08-08 02:45:46'),
(19, 'Registró actualizado correctamente.', 'Correcto', '2023-08-19 13:28:29', '2023-08-19 13:28:29'),
(20, 'No se ha conseguido completar la actualizacion del registro.', 'Error', '2023-08-19 13:30:42', '2023-08-19 13:30:42'),
(21, 'El token enviado es invalido, o ya existe un registro con ese nombre', 'Error', '2023-08-19 16:22:17', '2024-01-26 14:46:55'),
(22, 'Token vencido por favor refresque la pagina', 'Error', '2023-08-19 16:23:29', '2023-08-19 16:23:29'),
(23, 'No se encontró el campo token en este formulario', 'Error', '2023-08-19 16:23:54', '2023-08-19 16:23:54'),
(24, 'Registro duplicado', 'Error', '2023-08-19 16:50:33', '2023-08-26 22:35:12'),
(25, 'El registro que está intentando localizar ya cuenta con un registro asociado.', 'Error', '2024-02-07 16:35:52', '2024-02-07 16:35:52'),
(26, 'Registro no encontrado', 'Error', '2024-02-07 16:39:31', '2024-02-07 16:39:31'),
(27, 'El registro ya cuenta con registro vinculado', 'Error', '2024-02-07 16:58:09', '2024-02-07 16:58:09'),
(28, 'Token no creado', 'Error', '2024-02-08 18:51:07', '2024-02-08 18:51:07'),
(29, 'Propietario se encuentra desactivado', 'Información', '2024-02-08 21:15:26', '2024-02-08 21:15:26'),
(30, 'El peso del archivo que se selecciono sobrepasa el limite permitido', 'Error', '2024-02-09 20:54:22', '2024-02-09 21:05:57'),
(31, 'No se logro subir el archivo al servidor', 'Error', '2024-02-09 21:13:50', '2024-02-09 21:13:50'),
(32, 'No se pudo eliminar el directorio', 'Error', '2024-02-13 13:56:22', '2024-02-13 13:56:53'),
(33, 'No se logro eliminar el archivo de manera correcta', 'Error', '2024-02-13 14:12:56', '2024-02-13 14:12:56'),
(34, 'Las contraseñas no coinciden', 'Información', '2024-02-13 21:01:25', '2024-02-13 21:01:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alquiler`
--

CREATE TABLE `alquiler` (
  `idAlquiler` int(11) NOT NULL,
  `initialDateAlquiler` date DEFAULT NULL,
  `endDateAlquiler` date DEFAULT NULL,
  `paidAlquiler` char(1) DEFAULT '1',
  `statusAlquiler` char(1) NOT NULL DEFAULT '1',
  `creationDateAlquiler` timestamp NOT NULL DEFAULT current_timestamp(),
  `updateDateAlquiler` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `empresa_idEmpresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alquiler`
--

INSERT INTO `alquiler` (`idAlquiler`, `initialDateAlquiler`, `endDateAlquiler`, `paidAlquiler`, `statusAlquiler`, `creationDateAlquiler`, `updateDateAlquiler`, `empresa_idEmpresa`) VALUES
(13, '2024-02-13', '2024-02-21', '0', '1', '2024-02-13 17:20:44', '2024-02-13 17:20:44', 22);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuraciones`
--

CREATE TABLE `configuraciones` (
  `idConfiguraciones` int(11) NOT NULL,
  `nameConfiguraciones` varchar(45) NOT NULL,
  `descriptionConfiguraciones` text DEFAULT NULL,
  `statusConfiguraciones` varchar(45) NOT NULL,
  `creationDateConfiguraciones` timestamp NOT NULL DEFAULT current_timestamp(),
  `updateDateConfiguraciones` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `container`
--

CREATE TABLE `container` (
  `idContainer` int(11) NOT NULL,
  `nameContainer` varchar(45) NOT NULL,
  `descritpionContainer` text DEFAULT NULL,
  `statusContainer` char(1) DEFAULT '1',
  `creationDateContainer` timestamp NOT NULL DEFAULT current_timestamp(),
  `updateDateContainer` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `container`
--

INSERT INTO `container` (`idContainer`, `nameContainer`, `descritpionContainer`, `statusContainer`, `creationDateContainer`, `updateDateContainer`) VALUES
(1, 'Login', 'Contenedor login', '1', '2023-05-26 15:15:43', '2023-06-02 13:50:53'),
(2, 'Modulo', 'Contenedor Modulo', '1', '2023-05-26 15:18:58', '2023-06-01 02:45:49'),
(3, 'Persona', NULL, '1', '2023-05-26 15:18:58', '2023-05-26 15:18:58'),
(4, 'Roles', '', '1', '2023-05-26 15:19:17', '2023-05-26 15:19:28'),
(5, 'Sexo', NULL, '1', '2023-05-26 15:19:17', '2023-05-26 15:19:17'),
(6, 'Documento', NULL, '1', '2023-05-26 15:48:41', '2023-05-26 15:48:41'),
(7, 'Dashboard', NULL, '1', '2023-05-26 15:49:05', '2023-05-26 15:49:05'),
(8, 'Contenedor', NULL, '1', '2023-05-26 18:25:40', '2023-05-26 18:26:09'),
(9, 'Propietario', 'Propietario', '1', '2023-05-31 15:28:44', '2023-06-01 15:48:16'),
(14, 'Empresa', '', '1', '2023-06-02 14:39:38', '2023-06-02 14:39:38'),
(15, 'Alquiler', 'Alquiler', '1', '2023-06-20 20:40:37', '2023-06-20 20:40:37'),
(16, 'Rubro', 'Rubro', '1', '2023-06-20 20:40:47', '2023-06-20 20:40:47'),
(17, 'Trabajador', '', '1', '2023-06-23 01:24:12', '2023-06-23 01:24:12'),
(18, 'Usuario', '', '1', '2023-06-23 01:24:21', '2023-06-23 01:24:21'),
(19, 'Alerta', 'Alerta', '1', '2023-07-24 15:01:17', '2023-07-24 15:01:17'),
(20, 'Profile', 'Profile', '1', '2023-07-30 02:41:29', '2024-02-05 19:37:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `idEmpresa` int(11) NOT NULL,
  `ruc` char(16) NOT NULL,
  `nameEmpresa` varchar(45) NOT NULL,
  `descriptionEmpresa` text DEFAULT NULL,
  `statusEmpresa` char(1) NOT NULL DEFAULT '1',
  `iconEmpresa` text NOT NULL,
  `creationDateEmpresa` timestamp NOT NULL DEFAULT current_timestamp(),
  `updateDateEmpresa` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `propietario_idPropietario` int(11) NOT NULL,
  `rubros_idRubros` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`idEmpresa`, `ruc`, `nameEmpresa`, `descriptionEmpresa`, `statusEmpresa`, `iconEmpresa`, `creationDateEmpresa`, `updateDateEmpresa`, `propietario_idPropietario`, `rubros_idRubros`) VALUES
(1, '10734486529', 'C&D TECH', 'Sin informacion', '1', '10734486529/logo.png', '2023-05-05 19:18:00', '2024-02-14 16:30:02', 1, 1),
(22, '12345678911', 'Bodega el Eden', 'Bodega el Edén', '1', '12345678911/bdgaeden.png', '2023-06-16 02:42:52', '2023-06-19 22:45:23', 16, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo`
--

CREATE TABLE `modulo` (
  `idModulo` int(11) NOT NULL,
  `container_idContainer` int(11) NOT NULL,
  `nameModulo` varchar(45) NOT NULL,
  `descriptionModulo` text DEFAULT NULL,
  `statusModulo` char(1) NOT NULL DEFAULT '1',
  `creationDateModulo` timestamp NOT NULL DEFAULT current_timestamp(),
  `updateDateModulo` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `modulo`
--

INSERT INTO `modulo` (`idModulo`, `container_idContainer`, `nameModulo`, `descriptionModulo`, `statusModulo`, `creationDateModulo`, `updateDateModulo`) VALUES
(1, 1, 'Login', 'Es el formulario de inicio de sesión', '1', '2023-05-05 19:14:07', '2023-07-07 15:34:34'),
(2, 7, 'Dashboard', 'Sin información', '1', '2023-05-09 15:52:16', '2023-05-26 15:49:19'),
(3, 4, 'nuevoRol', 'Sin información', '1', '2023-05-10 14:13:44', '2023-08-13 16:14:52'),
(4, 1, 'forgotPassword', 'Este módulo nos permite recuperar nuestra contraseña de nuestra cuenta', '1', '2023-05-12 02:16:24', '2023-05-26 15:16:44'),
(5, 6, 'nuevoDocumento', NULL, '1', '2023-05-12 15:47:29', '2023-05-26 15:49:28'),
(6, 5, 'nuevoSexo', 'Sin información', '1', '2023-05-12 15:47:29', '2023-06-20 03:19:52'),
(7, 3, 'nuevoPersona', 'NuevaPersona', '1', '2023-05-22 14:57:13', '2023-05-26 17:33:28'),
(8, 4, 'listaRolDU', 'Muestra un listado de todos los roles y también se puede editar y eliminar', '1', '2023-05-16 14:09:50', '2023-05-26 15:47:25'),
(9, 2, 'nuevoModulo', 'nuevoModulo', '1', '2023-05-19 14:28:29', '2023-05-26 15:49:47'),
(10, 2, 'listaModuloDU', 'En esta vista se puede editar los nombres de los módulos como también eliminar, pero se debe tener en cuenta que si se va a hacer un cambio en el nombre del módulo deberá ser cambiado en el código y sus nombres, las librerías que usa.', '1', '2023-05-24 03:36:19', '2023-05-26 15:49:41'),
(11, 6, 'listaDocumentoDU', 'ListaDocumentoDU', '1', '2023-05-25 01:59:48', '2023-05-26 15:49:36'),
(12, 5, 'listaSexoDU', 'ListaSexoDU', '1', '2023-05-26 14:39:53', '2023-05-27 01:38:23'),
(13, 8, 'nuevoContenedor', 'NuevoContenedor', '1', '2023-05-26 18:26:17', '2023-05-26 23:49:33'),
(14, 8, 'listaContenedorDU', 'ListaContenedorDU', '1', '2023-05-27 01:20:18', '2023-05-27 01:46:50'),
(15, 3, 'listaPersonaDU', 'ListaPersonaDU', '1', '2023-05-31 14:57:17', '2023-05-31 14:57:17'),
(16, 9, 'nuevoPropietario', 'NuevoPropietario', '1', '2023-05-31 15:29:06', '2023-05-31 15:29:06'),
(17, 9, 'listaPropietarioDU', 'ListaPropietarioDU', '1', '2023-06-01 16:13:47', '2023-06-01 16:13:47'),
(18, 14, 'nuevaEmpresa', 'Sin información', '1', '2023-06-02 14:40:41', '2023-06-02 14:41:09'),
(19, 14, 'listaEmpresaDU', 'ListaEmpresaDU', '1', '2023-06-02 14:41:30', '2023-06-02 14:41:30'),
(20, 15, 'nuevoAlquiler', 'NuevoAlquiler', '1', '2023-06-20 20:41:14', '2023-06-20 20:41:14'),
(21, 15, 'listaAlquilerDU', 'ListaAlquilerDU', '1', '2023-06-20 20:41:30', '2023-06-20 20:41:30'),
(22, 16, 'nuevoRubro', 'NuevoRubro', '1', '2023-06-20 20:41:45', '2023-06-20 20:41:45'),
(23, 16, 'listaRubroDU', 'ListaRubroDU', '1', '2023-06-20 20:41:57', '2023-06-20 20:41:57'),
(24, 18, 'nuevoUsuario', 'Sin información', '1', '2023-06-23 01:26:00', '2023-06-23 01:28:16'),
(25, 18, 'listaUsuarioDU', 'Sin información', '1', '2023-06-23 01:27:19', '2023-06-23 01:28:28'),
(26, 17, 'nuevoTrabajador', 'Sin información', '1', '2023-06-23 01:27:40', '2023-06-23 01:28:38'),
(27, 17, 'listaTrabajadorDU', 'Sin información', '1', '2023-06-23 01:27:52', '2023-06-23 01:28:52'),
(28, 14, 'moduloEmpresaCU', 'ModuloEmpresaCU', '1', '2023-06-21 15:00:52', '2023-06-21 15:04:55'),
(29, 4, 'moduloRolCU', 'ModuloRolCU', '1', '2023-07-17 15:16:19', '2023-07-17 15:18:59'),
(30, 19, 'nuevoAlerta', 'NuevoAlerta', '1', '2023-07-25 01:50:05', '2023-07-25 01:50:37'),
(31, 19, 'listaAlertaDU', 'ListaAlertaDU', '1', '2023-07-25 01:50:21', '2023-07-25 01:50:42'),
(32, 20, 'detail', 'Sin información', '1', '2023-07-30 02:43:28', '2023-08-03 01:17:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `moduloempresa`
--

CREATE TABLE `moduloempresa` (
  `idModuloEmpresa` int(11) NOT NULL,
  `titleModuloEmpresa` varchar(45) NOT NULL,
  `empresa_idEmpresa` int(11) NOT NULL,
  `modulo_idModulo` int(11) NOT NULL,
  `statusModuloEmpresa` char(1) NOT NULL DEFAULT '1',
  `creationDateModuloEmpresa` timestamp NOT NULL DEFAULT current_timestamp(),
  `updateDateModuloEmpresa` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `moduloempresa`
--

INSERT INTO `moduloempresa` (`idModuloEmpresa`, `titleModuloEmpresa`, `empresa_idEmpresa`, `modulo_idModulo`, `statusModuloEmpresa`, `creationDateModuloEmpresa`, `updateDateModuloEmpresa`) VALUES
(1, 'Inicio de Sesión', 1, 1, '1', '2023-09-03 03:01:54', '2024-02-13 15:35:43'),
(2, 'Olvide mi contraseña', 1, 4, '1', '2023-09-03 03:02:10', '2023-09-03 03:02:10'),
(3, 'Dashboard', 1, 2, '1', '2023-09-03 03:02:24', '2023-09-03 03:02:24'),
(4, 'Lista Empresa', 1, 19, '1', '2023-09-03 03:03:40', '2023-09-03 03:03:40'),
(5, 'Asignar Módulos', 1, 28, '1', '2023-09-03 03:05:01', '2023-09-03 03:05:01'),
(6, 'nuevoModulo', 1, 9, '1', '2023-09-03 03:05:24', '2023-09-03 03:05:24'),
(7, 'listaModuloDU', 1, 10, '1', '2023-09-03 03:05:28', '2023-09-03 03:05:28'),
(8, 'nuevoPersona', 1, 7, '1', '2023-09-03 03:05:29', '2023-09-03 03:05:29'),
(9, 'listaPersonaDU', 1, 15, '1', '2023-09-03 03:05:30', '2023-09-03 03:05:30'),
(10, 'nuevoRol', 1, 3, '1', '2023-09-03 03:05:31', '2023-09-03 03:05:31'),
(11, 'listaRolDU', 1, 8, '1', '2023-09-03 03:05:31', '2023-09-03 03:05:31'),
(12, 'moduloRolCU', 1, 29, '1', '2023-09-03 03:05:32', '2023-09-03 03:05:32'),
(13, 'nuevoSexo', 1, 6, '1', '2023-09-03 03:05:33', '2023-09-03 03:05:33'),
(14, 'listaSexoDU', 1, 12, '1', '2023-09-03 03:05:34', '2023-09-03 03:05:34'),
(15, 'nuevoDocumento', 1, 5, '1', '2023-09-03 03:05:35', '2023-09-03 03:05:35'),
(16, 'listaDocumentoDU', 1, 11, '1', '2023-09-03 03:05:35', '2023-09-03 03:05:35'),
(17, 'nuevoContenedor', 1, 13, '1', '2023-09-03 03:05:37', '2023-09-03 03:05:37'),
(18, 'listaContenedorDU', 1, 14, '1', '2023-09-03 03:05:37', '2023-09-03 03:05:37'),
(19, 'nuevoPropietario', 1, 16, '1', '2023-09-03 03:05:38', '2023-09-03 03:05:38'),
(20, 'listaPropietarioDU', 1, 17, '1', '2023-09-03 03:05:39', '2023-09-03 03:05:39'),
(21, 'nuevaEmpresa', 1, 18, '1', '2023-09-03 03:05:41', '2023-09-03 03:05:41'),
(22, 'nuevoAlquiler', 1, 20, '1', '2023-09-03 03:05:43', '2023-09-03 03:05:43'),
(23, 'listaAlquilerDU', 1, 21, '1', '2023-09-03 03:05:44', '2023-09-03 03:05:44'),
(24, 'nuevoRubro', 1, 22, '1', '2023-09-03 03:05:45', '2023-09-03 03:05:45'),
(25, 'listaRubroDU', 1, 23, '1', '2023-09-03 03:05:45', '2023-09-03 03:05:45'),
(26, 'nuevoTrabajador', 1, 26, '1', '2023-09-03 03:05:47', '2023-09-03 03:11:18'),
(27, 'listaTrabajadorDU', 1, 27, '1', '2023-09-03 03:05:47', '2023-09-03 03:11:19'),
(28, 'nuevoUsuario', 1, 24, '1', '2023-09-03 03:05:49', '2023-09-03 03:11:20'),
(29, 'listaUsuarioDU', 1, 25, '1', '2023-09-03 03:05:51', '2023-09-03 03:11:22'),
(30, 'nuevoAlerta', 1, 30, '1', '2023-09-03 03:05:52', '2023-09-03 03:11:24'),
(31, 'listaAlertaDU', 1, 31, '1', '2023-09-03 03:05:52', '2024-02-13 15:36:14'),
(32, 'detail', 1, 32, '1', '2023-09-03 03:05:53', '2023-09-03 03:11:23'),
(33, 'Login', 22, 1, '1', '2023-09-03 21:10:22', '2023-10-11 02:55:04'),
(34, 'forgotPassword', 22, 4, '1', '2023-09-03 21:10:23', '2023-10-11 02:55:05'),
(35, 'Dashboard', 22, 2, '1', '2023-09-03 21:10:30', '2023-09-03 21:10:30'),
(36, 'nuevoRubro', 22, 22, '1', '2023-10-11 02:27:20', '2023-10-11 02:27:20'),
(37, 'listaRubroDU', 22, 23, '1', '2023-10-11 02:27:20', '2023-10-11 02:27:20'),
(38, 'nuevoTrabajador', 22, 26, '1', '2023-10-11 02:27:23', '2023-10-11 02:27:23'),
(39, 'listaTrabajadorDU', 22, 27, '1', '2023-10-11 02:27:23', '2023-10-11 02:27:23'),
(40, 'listaRolDU', 22, 8, '0', '2023-10-11 02:27:26', '2023-10-11 02:55:28'),
(41, 'nuevoRol', 22, 3, '0', '2023-10-11 02:55:17', '2023-10-11 02:55:23'),
(42, 'moduloRolCU', 22, 29, '0', '2023-10-11 02:55:43', '2023-10-11 02:55:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `idPersona` int(11) NOT NULL,
  `namePersona` varchar(45) NOT NULL,
  `lastName` varchar(45) NOT NULL,
  `birthdate` date NOT NULL,
  `tiposexo_idTipoSexo` int(11) NOT NULL,
  `tipodocumento_idTipoDocumento` int(11) NOT NULL,
  `documentNumber` char(11) NOT NULL,
  `statusPersona` char(1) NOT NULL DEFAULT '1',
  `creationDatePersona` timestamp NOT NULL DEFAULT current_timestamp(),
  `updateDatePersona` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`idPersona`, `namePersona`, `lastName`, `birthdate`, `tiposexo_idTipoSexo`, `tipodocumento_idTipoDocumento`, `documentNumber`, `statusPersona`, `creationDatePersona`, `updateDatePersona`) VALUES
(1, 'Yeison Danner', 'Carhuapoma Dett', '2000-01-01', 1, 1, '73448652', '1', '2023-05-05 19:16:22', '2023-08-05 21:24:05'),
(3, 'Jhon David', 'Altamirano Altamirano', '2000-01-01', 1, 1, '73448651', '1', '2023-06-01 17:57:27', '2023-06-01 17:57:27'),
(14, 'Maria Elena', 'Diaz Ibañez', '2005-03-01', 4, 1, '73448653', '1', '2024-02-07 17:20:11', '2024-02-07 17:20:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `propietario`
--

CREATE TABLE `propietario` (
  `idPropietario` int(11) NOT NULL,
  `codePropietario` char(10) NOT NULL,
  `statusPropietario` char(1) NOT NULL DEFAULT '1',
  `creationDatePropietario` timestamp NOT NULL DEFAULT current_timestamp(),
  `updateDatePropietario` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `persona_idPersona` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `propietario`
--

INSERT INTO `propietario` (`idPropietario`, `codePropietario`, `statusPropietario`, `creationDatePropietario`, `updateDatePropietario`, `persona_idPersona`) VALUES
(1, 'YC73448652', '1', '2023-05-05 19:16:56', '2024-02-08 19:44:30', 1),
(16, 'JA73448651', '1', '2023-06-16 02:42:03', '2024-02-08 21:18:43', 3),
(27, 'MD73448653', '1', '2024-02-08 21:01:30', '2024-02-08 21:01:30', 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idRol` int(11) NOT NULL,
  `empresa_idEmpresa` int(11) NOT NULL DEFAULT 0,
  `nameRol` char(45) NOT NULL,
  `descriptionRol` text DEFAULT NULL,
  `statusRol` char(1) NOT NULL DEFAULT '1',
  `creationDateRol` timestamp NOT NULL DEFAULT current_timestamp(),
  `updateDateRol` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idRol`, `empresa_idEmpresa`, `nameRol`, `descriptionRol`, `statusRol`, `creationDateRol`, `updateDateRol`) VALUES
(1, 1, 'Super Administrador', 'Sin información', '1', '2023-07-10 14:40:24', '2024-02-14 17:44:33'),
(32, 22, 'Super Administrador', 'Este rolo puede acceder el administrador del sistema', '1', '2023-09-03 03:08:54', '2024-01-22 21:09:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_has_moduloempresa`
--

CREATE TABLE `rol_has_moduloempresa` (
  `idRol_has_ModuloEmpresa` int(11) NOT NULL,
  `rol_idRol` int(11) NOT NULL,
  `moduloempresa_idModuloEmpresa` int(11) NOT NULL,
  `statusRolModuloEmpresa` char(1) NOT NULL DEFAULT '1',
  `creationDateRolModuloEmpresa` timestamp NOT NULL DEFAULT current_timestamp(),
  `updateDateRolModuloEmpresa` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol_has_moduloempresa`
--

INSERT INTO `rol_has_moduloempresa` (`idRol_has_ModuloEmpresa`, `rol_idRol`, `moduloempresa_idModuloEmpresa`, `statusRolModuloEmpresa`, `creationDateRolModuloEmpresa`, `updateDateRolModuloEmpresa`) VALUES
(1, 1, 3, '1', '2023-09-03 03:02:54', '2023-09-03 03:02:54'),
(2, 1, 4, '1', '2023-09-03 03:03:53', '2023-09-03 03:03:53'),
(3, 1, 5, '1', '2023-09-03 03:05:17', '2023-09-03 03:05:17'),
(4, 1, 11, '1', '2023-09-03 03:06:54', '2023-09-03 03:06:54'),
(5, 1, 12, '1', '2023-09-03 03:06:54', '2023-09-03 03:06:54'),
(6, 1, 1, '1', '2023-09-03 03:07:41', '2024-02-13 14:55:53'),
(7, 1, 2, '1', '2023-09-03 03:07:41', '2023-09-03 03:07:41'),
(8, 1, 6, '1', '2023-09-03 03:07:42', '2023-09-03 03:07:42'),
(9, 1, 7, '1', '2023-09-03 03:07:43', '2023-09-03 03:07:43'),
(10, 1, 10, '1', '2023-09-03 03:07:44', '2023-09-03 03:07:44'),
(11, 1, 8, '1', '2023-09-03 03:07:45', '2023-09-29 02:33:24'),
(12, 1, 9, '1', '2023-09-03 03:07:46', '2023-09-03 03:07:46'),
(13, 1, 14, '1', '2023-09-03 03:07:47', '2024-01-24 20:39:28'),
(14, 1, 13, '1', '2023-09-03 03:07:48', '2024-01-24 20:39:27'),
(15, 1, 15, '1', '2023-09-03 03:07:49', '2023-09-03 03:07:49'),
(16, 1, 16, '1', '2023-09-03 03:07:49', '2023-09-03 03:07:49'),
(17, 1, 17, '1', '2023-09-03 03:07:50', '2023-09-03 03:07:50'),
(18, 1, 18, '1', '2023-09-03 03:07:51', '2023-09-03 03:07:51'),
(19, 1, 19, '1', '2023-09-03 03:07:52', '2023-09-03 03:07:52'),
(20, 1, 20, '1', '2023-09-03 03:07:53', '2023-09-03 03:07:53'),
(21, 1, 21, '1', '2023-09-03 03:07:54', '2023-09-03 03:07:54'),
(22, 1, 22, '1', '2023-09-03 03:07:58', '2023-09-03 03:07:58'),
(23, 1, 23, '1', '2023-09-03 03:07:59', '2023-09-03 03:07:59'),
(24, 1, 24, '1', '2023-09-03 03:08:00', '2023-09-03 03:08:00'),
(25, 1, 25, '1', '2023-09-03 03:08:01', '2023-09-03 03:08:01'),
(26, 1, 28, '1', '2023-09-03 03:08:01', '2023-09-03 03:08:01'),
(27, 1, 29, '1', '2023-09-03 03:08:02', '2023-09-03 03:08:02'),
(28, 1, 26, '1', '2023-09-03 03:08:08', '2023-09-03 03:08:08'),
(29, 1, 27, '1', '2023-09-03 03:08:22', '2023-09-03 03:08:22'),
(30, 1, 30, '1', '2023-09-03 03:08:23', '2023-09-03 03:08:23'),
(31, 1, 31, '1', '2023-09-03 03:08:23', '2023-09-03 03:08:23'),
(32, 1, 32, '1', '2023-09-03 03:08:25', '2024-02-13 15:36:24'),
(33, 32, 35, '1', '2023-09-03 21:18:42', '2024-01-24 20:38:57'),
(34, 32, 40, '1', '2023-10-11 02:27:37', '2023-10-11 02:27:37'),
(35, 32, 38, '1', '2023-10-11 02:27:38', '2023-10-11 02:27:38'),
(36, 32, 36, '1', '2023-10-11 02:30:03', '2023-10-11 02:30:03'),
(37, 32, 37, '1', '2023-10-11 02:30:03', '2023-10-11 02:30:03'),
(38, 32, 39, '1', '2023-10-11 02:30:04', '2023-10-11 02:30:04'),
(39, 32, 33, '0', '2023-10-11 02:56:01', '2024-02-13 14:54:01'),
(42, 32, 34, '0', '2024-02-13 14:54:01', '2024-02-13 14:54:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rubros`
--

CREATE TABLE `rubros` (
  `idRubros` int(11) NOT NULL,
  `nameRubros` varchar(45) NOT NULL,
  `descriptionRubros` text NOT NULL,
  `statusRubros` char(1) NOT NULL DEFAULT '1',
  `creationDateRubros` timestamp NOT NULL DEFAULT current_timestamp(),
  `updateDateRubros` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rubros`
--

INSERT INTO `rubros` (`idRubros`, `nameRubros`, `descriptionRubros`, `statusRubros`, `creationDateRubros`, `updateDateRubros`) VALUES
(1, 'Desarrollo de Software', 'Desarrollo de Software', '1', '2023-06-13 20:31:32', '2023-07-03 15:31:15'),
(2, 'Abarrotes', 'Abarrotes', '1', '2023-06-16 20:04:18', '2023-07-03 15:31:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabajadorempresa`
--

CREATE TABLE `tabajadorempresa` (
  `idTrabajadorEmpresa` int(11) NOT NULL,
  `codigoTrabajador` char(19) NOT NULL,
  `persona_idPersona` int(11) NOT NULL,
  `empresa_idEmpresa` int(11) NOT NULL,
  `statusTrabajadorEmpresa` char(1) NOT NULL DEFAULT '1',
  `creationDateTrabajadorEmpresa` timestamp NOT NULL DEFAULT current_timestamp(),
  `updateDateTrabajadorEmpresa` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tabajadorempresa`
--

INSERT INTO `tabajadorempresa` (`idTrabajadorEmpresa`, `codigoTrabajador`, `persona_idPersona`, `empresa_idEmpresa`, `statusTrabajadorEmpresa`, `creationDateTrabajadorEmpresa`, `updateDateTrabajadorEmpresa`) VALUES
(7, '20230725095630YC73', 1, 1, '1', '2023-07-25 14:56:36', '2023-08-05 21:23:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipodocumento`
--

CREATE TABLE `tipodocumento` (
  `idTipoDocumento` int(11) NOT NULL,
  `nameDocumento` varchar(45) NOT NULL,
  `abbreviationDocumento` char(10) NOT NULL,
  `descriptionDocumento` text DEFAULT NULL,
  `statusDocumento` char(1) NOT NULL DEFAULT '1',
  `creationDateDocumento` timestamp NOT NULL DEFAULT current_timestamp(),
  `updateDateDocumento` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipodocumento`
--

INSERT INTO `tipodocumento` (`idTipoDocumento`, `nameDocumento`, `abbreviationDocumento`, `descriptionDocumento`, `statusDocumento`, `creationDateDocumento`, `updateDateDocumento`) VALUES
(1, 'Documento Nacional de Identidad', 'DNI', 'Documento nacional de identidad', '1', '2023-05-25 01:46:38', '2023-05-25 17:53:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposexo`
--

CREATE TABLE `tiposexo` (
  `idTipoSexo` int(11) NOT NULL,
  `nameSexo` varchar(45) NOT NULL,
  `abbreviationSexo` char(10) NOT NULL,
  `descriptionSexo` text DEFAULT NULL,
  `statusSexo` char(1) NOT NULL DEFAULT '1',
  `creationDateSexo` timestamp NOT NULL DEFAULT current_timestamp(),
  `updateDateSexo` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tiposexo`
--

INSERT INTO `tiposexo` (`idTipoSexo`, `nameSexo`, `abbreviationSexo`, `descriptionSexo`, `statusSexo`, `creationDateSexo`, `updateDateSexo`) VALUES
(1, 'Masculino', 'M', 'Sexo para varones', '1', '2023-05-25 01:45:41', '2024-01-24 20:44:43'),
(4, 'Femenino', 'F', 'Sin información', '1', '2023-06-08 00:44:25', '2023-08-19 18:29:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `userUsuario` varchar(45) NOT NULL,
  `passwordUsuario` text NOT NULL,
  `statusUsuario` char(1) NOT NULL DEFAULT '1',
  `creationDateUsuario` timestamp NOT NULL DEFAULT current_timestamp(),
  `updateDateUsuario` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `rol_idRol` int(11) NOT NULL,
  `tabajadorempresa_idTrabajadorEmpresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `userUsuario`, `passwordUsuario`, `statusUsuario`, `creationDateUsuario`, `updateDateUsuario`, `rol_idRol`, `tabajadorempresa_idTrabajadorEmpresa`) VALUES
(23, 'admin', 'N3J5clpNZlkwSGIyak4zak94VmV1dz09', '1', '2024-02-14 17:23:58', '2024-02-14 17:23:58', 1, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_has_configuraciones`
--

CREATE TABLE `usuario_has_configuraciones` (
  `usuario_idUsuario` int(11) NOT NULL,
  `configuraciones_idConfiguraciones` int(11) NOT NULL,
  `codeUsuarioConfiguraciones` char(11) DEFAULT NULL,
  `statusUsuarioConfiguraciones` char(1) NOT NULL DEFAULT '1',
  `creationDateUsuarioConfiguraciones` timestamp NOT NULL DEFAULT current_timestamp(),
  `updateDateUsuarioConfiguraciones` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alertas`
--
ALTER TABLE `alertas`
  ADD PRIMARY KEY (`idAlertas`);

--
-- Indices de la tabla `alquiler`
--
ALTER TABLE `alquiler`
  ADD PRIMARY KEY (`idAlquiler`),
  ADD KEY `empresa_idEmpresa` (`empresa_idEmpresa`);

--
-- Indices de la tabla `configuraciones`
--
ALTER TABLE `configuraciones`
  ADD PRIMARY KEY (`idConfiguraciones`);

--
-- Indices de la tabla `container`
--
ALTER TABLE `container`
  ADD PRIMARY KEY (`idContainer`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`idEmpresa`),
  ADD UNIQUE KEY `ruc` (`ruc`),
  ADD KEY `empresa_ibfk_1` (`rubros_idRubros`),
  ADD KEY `empresa_ibfk_2` (`propietario_idPropietario`);

--
-- Indices de la tabla `modulo`
--
ALTER TABLE `modulo`
  ADD PRIMARY KEY (`idModulo`),
  ADD KEY `container_idContainer` (`container_idContainer`);

--
-- Indices de la tabla `moduloempresa`
--
ALTER TABLE `moduloempresa`
  ADD PRIMARY KEY (`idModuloEmpresa`),
  ADD KEY `empresa_idEmpresa` (`empresa_idEmpresa`),
  ADD KEY `moduloempresa_ibfk_2` (`modulo_idModulo`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`idPersona`),
  ADD UNIQUE KEY `documentNumber` (`documentNumber`),
  ADD KEY `tiposexo_idTipoSexo` (`tiposexo_idTipoSexo`),
  ADD KEY `tipodocumento_idTipoDocumento` (`tipodocumento_idTipoDocumento`);

--
-- Indices de la tabla `propietario`
--
ALTER TABLE `propietario`
  ADD PRIMARY KEY (`idPropietario`),
  ADD UNIQUE KEY `codigoEmpresa` (`idPropietario`),
  ADD UNIQUE KEY `codigopropietario` (`codePropietario`) USING BTREE,
  ADD UNIQUE KEY `persona_idPersona` (`persona_idPersona`),
  ADD UNIQUE KEY `idPersona` (`persona_idPersona`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idRol`),
  ADD KEY `foreing_empresa_idEmpresa_idEmpresa` (`empresa_idEmpresa`);

--
-- Indices de la tabla `rol_has_moduloempresa`
--
ALTER TABLE `rol_has_moduloempresa`
  ADD PRIMARY KEY (`idRol_has_ModuloEmpresa`),
  ADD KEY `rol_has_moduloempresa_ibfk_1` (`rol_idRol`),
  ADD KEY `rol_has_moduloempresa_ibfk_2` (`moduloempresa_idModuloEmpresa`);

--
-- Indices de la tabla `rubros`
--
ALTER TABLE `rubros`
  ADD PRIMARY KEY (`idRubros`);

--
-- Indices de la tabla `tabajadorempresa`
--
ALTER TABLE `tabajadorempresa`
  ADD PRIMARY KEY (`idTrabajadorEmpresa`),
  ADD UNIQUE KEY `codigopropietario` (`codigoTrabajador`),
  ADD KEY `persona_idPersona` (`persona_idPersona`),
  ADD KEY `empresa_idEmpresa` (`empresa_idEmpresa`);

--
-- Indices de la tabla `tipodocumento`
--
ALTER TABLE `tipodocumento`
  ADD PRIMARY KEY (`idTipoDocumento`);

--
-- Indices de la tabla `tiposexo`
--
ALTER TABLE `tiposexo`
  ADD PRIMARY KEY (`idTipoSexo`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `userUsuario` (`userUsuario`),
  ADD UNIQUE KEY `tabajadorempresa_idTrabajadorEmpresa` (`tabajadorempresa_idTrabajadorEmpresa`) USING BTREE,
  ADD KEY `usuario_ibfk_1` (`rol_idRol`);

--
-- Indices de la tabla `usuario_has_configuraciones`
--
ALTER TABLE `usuario_has_configuraciones`
  ADD KEY `usuario_idUsuario` (`usuario_idUsuario`),
  ADD KEY `configuraciones_idConfiguraciones` (`configuraciones_idConfiguraciones`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alertas`
--
ALTER TABLE `alertas`
  MODIFY `idAlertas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `alquiler`
--
ALTER TABLE `alquiler`
  MODIFY `idAlquiler` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `configuraciones`
--
ALTER TABLE `configuraciones`
  MODIFY `idConfiguraciones` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `container`
--
ALTER TABLE `container`
  MODIFY `idContainer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `idEmpresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `modulo`
--
ALTER TABLE `modulo`
  MODIFY `idModulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `moduloempresa`
--
ALTER TABLE `moduloempresa`
  MODIFY `idModuloEmpresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `idPersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `propietario`
--
ALTER TABLE `propietario`
  MODIFY `idPropietario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idRol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `rol_has_moduloempresa`
--
ALTER TABLE `rol_has_moduloempresa`
  MODIFY `idRol_has_ModuloEmpresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `rubros`
--
ALTER TABLE `rubros`
  MODIFY `idRubros` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tabajadorempresa`
--
ALTER TABLE `tabajadorempresa`
  MODIFY `idTrabajadorEmpresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tipodocumento`
--
ALTER TABLE `tipodocumento`
  MODIFY `idTipoDocumento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tiposexo`
--
ALTER TABLE `tiposexo`
  MODIFY `idTipoSexo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alquiler`
--
ALTER TABLE `alquiler`
  ADD CONSTRAINT `alquiler_ibfk_1` FOREIGN KEY (`empresa_idEmpresa`) REFERENCES `empresa` (`idEmpresa`);

--
-- Filtros para la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD CONSTRAINT `empresa_ibfk_1` FOREIGN KEY (`rubros_idRubros`) REFERENCES `rubros` (`idRubros`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `empresa_ibfk_2` FOREIGN KEY (`propietario_idPropietario`) REFERENCES `propietario` (`idPropietario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `modulo`
--
ALTER TABLE `modulo`
  ADD CONSTRAINT `modulo_ibfk_1` FOREIGN KEY (`container_idContainer`) REFERENCES `container` (`idContainer`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `moduloempresa`
--
ALTER TABLE `moduloempresa`
  ADD CONSTRAINT `moduloempresa_ibfk_1` FOREIGN KEY (`empresa_idEmpresa`) REFERENCES `empresa` (`idEmpresa`),
  ADD CONSTRAINT `moduloempresa_ibfk_2` FOREIGN KEY (`modulo_idModulo`) REFERENCES `modulo` (`idModulo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `persona_ibfk_1` FOREIGN KEY (`tiposexo_idTipoSexo`) REFERENCES `tiposexo` (`idTipoSexo`),
  ADD CONSTRAINT `persona_ibfk_2` FOREIGN KEY (`tipodocumento_idTipoDocumento`) REFERENCES `tipodocumento` (`idTipoDocumento`);

--
-- Filtros para la tabla `propietario`
--
ALTER TABLE `propietario`
  ADD CONSTRAINT `propietario_ibfk_1` FOREIGN KEY (`persona_idPersona`) REFERENCES `persona` (`idPersona`);

--
-- Filtros para la tabla `rol`
--
ALTER TABLE `rol`
  ADD CONSTRAINT `foreing_empresa_idEmpresa_idEmpresa` FOREIGN KEY (`empresa_idEmpresa`) REFERENCES `empresa` (`idEmpresa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `rol_has_moduloempresa`
--
ALTER TABLE `rol_has_moduloempresa`
  ADD CONSTRAINT `rol_has_moduloempresa_ibfk_1` FOREIGN KEY (`rol_idRol`) REFERENCES `rol` (`idRol`),
  ADD CONSTRAINT `rol_has_moduloempresa_ibfk_2` FOREIGN KEY (`moduloempresa_idModuloEmpresa`) REFERENCES `moduloempresa` (`idModuloEmpresa`);

--
-- Filtros para la tabla `tabajadorempresa`
--
ALTER TABLE `tabajadorempresa`
  ADD CONSTRAINT `tabajadorempresa_ibfk_1` FOREIGN KEY (`persona_idPersona`) REFERENCES `persona` (`idPersona`),
  ADD CONSTRAINT `tabajadorempresa_ibfk_2` FOREIGN KEY (`empresa_idEmpresa`) REFERENCES `empresa` (`idEmpresa`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`rol_idRol`) REFERENCES `rol` (`idRol`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`tabajadorempresa_idTrabajadorEmpresa`) REFERENCES `tabajadorempresa` (`idTrabajadorEmpresa`);

--
-- Filtros para la tabla `usuario_has_configuraciones`
--
ALTER TABLE `usuario_has_configuraciones`
  ADD CONSTRAINT `usuario_has_configuraciones_ibfk_1` FOREIGN KEY (`usuario_idUsuario`) REFERENCES `usuario` (`idUsuario`),
  ADD CONSTRAINT `usuario_has_configuraciones_ibfk_2` FOREIGN KEY (`configuraciones_idConfiguraciones`) REFERENCES `configuraciones` (`idConfiguraciones`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
