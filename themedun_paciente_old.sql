-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 27-05-2023 a las 19:34:43
-- Versión del servidor: 5.7.23-23
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `themedun_paciente`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `idAdmin` int(15) NOT NULL,
  `nombresAdmin` varchar(50) NOT NULL,
  `apellidosAdmin` varchar(50) NOT NULL,
  `correoAdmin` varchar(50) NOT NULL,
  `contraseñaAdmin` varchar(150) NOT NULL,
  `tokenAdmin` varchar(200) NOT NULL,
  `codigoAdmin` int(6) NOT NULL DEFAULT '0',
  `nacimientoAdmin` date NOT NULL,
  `sexoAdmin` varchar(15) NOT NULL,
  `paisAdmin` varchar(50) NOT NULL,
  `ciudadAdmin` varchar(50) NOT NULL,
  `enmuAdmin` text NOT NULL,
  `fotoperfilAdmin` varchar(100) NOT NULL,
  `estadoAdmin` int(1) NOT NULL DEFAULT '1',
  `adminAdmin` int(15) NOT NULL DEFAULT '0',
  `indicacionesAdmin` varchar(1000) NOT NULL DEFAULT 'Aún no hay observaciones.	'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`idAdmin`, `nombresAdmin`, `apellidosAdmin`, `correoAdmin`, `contraseñaAdmin`, `tokenAdmin`, `codigoAdmin`, `nacimientoAdmin`, `sexoAdmin`, `paisAdmin`, `ciudadAdmin`, `enmuAdmin`, `fotoperfilAdmin`, `estadoAdmin`, `adminAdmin`, `indicacionesAdmin`) VALUES
(1, 'Leandro Santiago', 'Bernal Saavedra', 'leandro190-558@hotmail.com', '$2y$10$VayRw9zJk0iW5ejkZT3DTebuAX550NDGUt/lcpk1UsTJ1dJWOU47G', 'e1534bf709c2b2e35445', 958305, '2003-06-21', 'Masculino', 'Perú', 'Lima', '2022-08-31', '1.jpg', 1, 1, 'Bloquear\r\n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bancos`
--

CREATE TABLE `bancos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `bancos`
--

INSERT INTO `bancos` (`id`, `nombre`) VALUES
(1, 'ALFIN BANCO'),
(2, 'BANCO DE COMERCIO'),
(3, 'BANCO DE CRÉDITO DEL PERÚ'),
(4, 'BANCO DE LA NACIÓN'),
(5, 'BANCO FALABELLA'),
(6, 'BANCO GNB PERÚ'),
(7, 'BANCO INTERAMERICANO DE FINANZAS'),
(8, 'BANCO PICHINCHA'),
(9, 'BANCO RIPLEY'),
(10, 'BANCO SANTANDER PERÚ'),
(11, 'BANK OF CHINA'),
(12, 'BBVA'),
(13, 'CAJA AREQUIPA'),
(14, 'CAJA CUSCO'),
(15, 'CAJA DEL SANTA'),
(16, 'CAJA HUANCAYO'),
(17, 'CAJA ICA'),
(18, 'CAJA MAYNAS'),
(19, 'CAJA METROPOLITANA DE LIMA'),
(20, 'CAJA PAITA'),
(21, 'CAJA PIURA'),
(22, 'CAJA SULLANA'),
(23, 'CAJA TACNA'),
(24, 'CAJA TRUJILLO'),
(25, 'CITY BANK DEL PERÚ'),
(26, 'COMPARTAMOS FINANCIERA'),
(27, 'FINANCIERA CONFIANZA'),
(28, 'FINANCIERA CREDISCOTIA'),
(29, 'FINANCIERA QAPAQ'),
(30, 'ICBC PERÚ BANK'),
(31, 'INTERBANK'),
(32, 'MI BANCO'),
(33, 'SCOTIABANK PERÚ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `idcita` int(15) NOT NULL,
  `id` int(15) NOT NULL,
  `idupro` int(15) NOT NULL,
  `idadmin` int(11) NOT NULL DEFAULT '0',
  `idpay` int(15) NOT NULL,
  `title` varchar(75) COLLATE utf8mb4_spanish_ci NOT NULL,
  `localizacion` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL,
  `color` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL,
  `textColor` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL,
  `start` varchar(25) COLLATE utf8mb4_spanish_ci NOT NULL,
  `ubicacion` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `estado` varchar(10) COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ACTIVO',
  `fechanoti` varchar(25) COLLATE utf8mb4_spanish_ci NOT NULL,
  `leido` varchar(2) COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'NO',
  `leidopro` varchar(2) COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'NO',
  `abonado` varchar(2) COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'NO',
  `asistenciapac` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL,
  `asistencia` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL,
  `fechaabono` varchar(25) COLLATE utf8mb4_spanish_ci NOT NULL,
  `leidoabono` varchar(2) COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`idcita`, `id`, `idupro`, `idadmin`, `idpay`, `title`, `localizacion`, `color`, `textColor`, `start`, `ubicacion`, `estado`, `fechanoti`, `leido`, `leidopro`, `abonado`, `asistenciapac`, `asistencia`, `fechaabono`, `leidoabono`) VALUES
(1, 13, 1, 0, 1314771913, 'Programada... Únete con el link en la fecha y hora correspondientes.', '80', '#0052d4', 'white', '2023-05-18 14:00:00', 'https://us05web.zoom.us/j/82446910722?pwd=Q3VQcDBaK1J3bmlQR2tZV3dqYlFkQT09', 'ACTIVO', '2023-05-07 17:36:53', 'SI', 'SI', 'NO', '', '', '', 'SI'),
(2, 13, 1, 0, 1314771947, 'Programada... Únete con el link en la fecha y hora correspondientes.', '80', '#0052d4', 'white', '2023-05-22 08:00:00', 'https://us05web.zoom.us/j/82958828833?pwd=YVZFQjQ0WGNxMFVtZEFObmwrN1B4UT09', 'ACTIVO', '2023-05-07 17:42:24', 'SI', 'SI', 'NO', '', '', '', 'SI'),
(3, 13, 1, 0, 0, 'Confirmada... Realiza el pago de tu cita lo antes posible.', '80', '#00d418', 'white', '2023-05-28 13:00:00', '', 'CANCELADA', '2023-05-26 22:46:09', 'SI', 'SI', 'NO', '', '', '', 'SI'),
(4, 13, 1, 0, 1314771891, 'Programada... Únete con el link en la fecha y hora correspondientes.', '80', '#0052d4', 'white', '2023-05-16 14:00:00', 'https://us05web.zoom.us/j/89337909299?pwd=SCtWNVFKWlFMZmlzTTlMeCtwdFdtdz09', 'ACTIVO', '2023-05-07 17:31:17', 'SI', 'SI', 'NO', '', '', '', 'SI'),
(5, 13, 1, 0, 1314771935, 'Programada... Únete con el link en la fecha y hora correspondientes.', '80', '#0052d4', 'white', '2023-05-20 16:00:00', 'https://us05web.zoom.us/j/86521932719?pwd=WklIN1I4R3l6ZEo0cFFRQUFhWHkrQT09', 'ACTIVO', '2023-05-07 17:40:47', 'SI', 'SI', 'NO', '', '', '', 'SI'),
(6, 13, 1, 0, 1314773099, 'Programada... Únete con el link en la fecha y hora correspondientes.', '80', '#0052d4', 'white', '2023-05-24 07:00:00', 'https://us05web.zoom.us/j/87440891562?pwd=ZnJYUUQxdktabllFaXQ5b2VhNEJ2dz09', 'ACTIVO', '2023-05-07 17:46:31', 'SI', 'SI', 'NO', '', '', '', 'SI'),
(7, 13, 1, 0, 0, 'Vencida... La fecha de tu cita ha expirado.', '80', '#ff0000', 'white', '2023-05-26 06:00:00', '', 'CANCELADA', '2023-05-26 22:44:27', 'SI', 'SI', 'NO', '', '', '', 'SI'),
(8, 13, 1, 0, 1314773621, 'Programada... Únete con el link en la fecha y hora correspondientes.', '80', '#0052d4', 'white', '2023-05-29 06:00:00', 'https://us05web.zoom.us/j/87266021078?pwd=ZEtOWjFQVVJSNTk4NkY3MVdYSU56Zz09', 'ACTIVO', '2023-05-07 19:45:59', 'SI', 'SI', 'NO', 'Asistió', 'Asistió', '', 'SI'),
(9, 13, 1, 0, 1313128522, 'Programada... Únete con el link en la fecha y hora correspondientes.', '80', '#0052d4', 'white', '2023-05-31 08:00:00', 'https://us05web.zoom.us/j/81977288218?pwd=eGRxd1ptaUFpRTJhWVNEM1J3SGZvdz09', 'ACTIVO', '2023-05-27 07:42:09', 'SI', 'NO', 'NO', '', '', '', 'SI'),
(10, 13, 1, 0, 0, 'Enviada... Espera la confirmación de tu solicitud de cita.', '80', '#FFC107', 'white', '2023-06-03 15:00:00', '', 'CANCELADA', '2023-05-26 22:45:46', 'SI', 'SI', 'NO', '', '', '', 'SI'),
(11, 13, 1, 0, 0, 'Enviada... Espera la confirmación de tu solicitud de cita.', '80', '#FFC107', 'white', '2023-06-03 15:00:00', '', 'CANCELADA', '2023-05-26 22:49:32', 'SI', 'SI', 'NO', '', '', '', 'SI'),
(12, 13, 1, 0, 0, 'Confirmada... Realiza el pago de tu cita lo antes posible.', '80', '#00d418', 'white', '2023-06-03 16:00:00', '', 'ACTIVO', '2023-05-27 07:38:43', 'SI', 'SI', 'NO', '', '', '', 'SI'),
(13, 13, 1, 0, 0, 'Vencida... La fecha de tu cita ha expirado.', '80', '#ff0000', 'white', '2023-05-27 14:00:00', '', 'CANCELADA', '2023-05-27 14:09:58', 'NO', 'NO', 'NO', '', '', '', 'SI'),
(14, 13, 1, 0, 0, 'Vencida... La fecha de tu cita ha expirado.', '80', '#ff0000', 'white', '2023-05-27 07:00:00', '', 'ACTIVO', '2023-05-27 07:24:19', 'SI', 'SI', 'NO', '', '', '', 'SI'),
(15, 13, 1, 0, 1313128516, 'Programada... Únete con el link en la fecha y hora correspondientes.', '80', '#0052d4', 'white', '2023-05-28 11:00:00', 'https://us05web.zoom.us/j/86826539832?pwd=SWMyVGVNK2FPRlk3aWhjdkRTNTdFdz09', 'ACTIVO', '2023-05-27 07:40:13', 'SI', 'SI', 'NO', '', '', '', 'SI');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentabancaria`
--

CREATE TABLE `cuentabancaria` (
  `idcuentas` int(11) NOT NULL,
  `idpro` int(11) NOT NULL,
  `nombrestitular` varchar(50) NOT NULL,
  `apellidostitular` varchar(50) NOT NULL,
  `nombresyape` varchar(50) NOT NULL,
  `apellidosyape` varchar(50) NOT NULL,
  `yape` varchar(15) NOT NULL,
  `tipodoctitular` varchar(50) NOT NULL,
  `numdoctitular` varchar(50) NOT NULL,
  `nacimientotitular` date NOT NULL,
  `direcciontitular` varchar(100) NOT NULL,
  `nombrebanco` varchar(50) NOT NULL,
  `tipocuenta` varchar(50) NOT NULL,
  `codigocuentainterbancaria` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentabancariaadmin`
--

CREATE TABLE `cuentabancariaadmin` (
  `idcuentas` int(11) NOT NULL,
  `idadmin` int(11) NOT NULL,
  `nombrestitular` varchar(50) NOT NULL,
  `apellidostitular` varchar(50) NOT NULL,
  `tipodoctitular` varchar(50) NOT NULL,
  `numdoctitular` varchar(50) NOT NULL,
  `nacimientotitular` date NOT NULL,
  `direcciontitular` varchar(100) NOT NULL,
  `nombrebanco` varchar(50) NOT NULL,
  `tipocuenta` varchar(50) NOT NULL,
  `codigocuentainterbancaria` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `desabilitar_atencion`
--

CREATE TABLE `desabilitar_atencion` (
  `id` int(10) NOT NULL,
  `idupro` int(10) NOT NULL,
  `startDate` varchar(25) NOT NULL,
  `endDate` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `desabilitar_atencion`
--

INSERT INTO `desabilitar_atencion` (`id`, `idupro`, `startDate`, `endDate`) VALUES
(29, 1, '2023-02-11', '2023-02-12'),
(30, 1, '2023-02-10', '2023-02-11'),
(31, 1, '2023-02-21', '2023-02-22'),
(32, 1, '2023-02-26', '2023-02-27'),
(33, 1, '2023-02-18', '2023-02-19'),
(35, 1, '2023-02-13', '2023-02-17'),
(43, 1, '2023-05-10', '2023-05-11'),
(44, 1, '2023-05-11', '2023-05-14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidades`
--

CREATE TABLE `especialidades` (
  `id` int(15) NOT NULL,
  `nombre` varchar(50) COLLATE utf16_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci;

--
-- Volcado de datos para la tabla `especialidades`
--

INSERT INTO `especialidades` (`id`, `nombre`) VALUES
(1, 'Alergología'),
(2, 'Anestesiología'),
(3, 'Cardiología'),
(4, 'Cirugía Cardiovascular'),
(5, 'Cirugía de Cabeza y Cuello'),
(6, 'Cirugía de Mano'),
(7, 'Cirugía General'),
(8, 'Cirugía Oncológica'),
(9, 'Cirugía Pediátrica'),
(10, 'Cirugía Plástica'),
(11, 'Dermatología'),
(12, 'Endocrinología'),
(13, 'Gastroenterología'),
(14, 'Genética Médica'),
(15, 'Geriatría'),
(16, 'Ginecología y Obstetricia'),
(17, 'Hematología'),
(18, 'Infectología'),
(19, 'Medicina del Deporte'),
(20, 'Medicina Familiar y Comunitaria'),
(21, 'Medicina Física y Rehabilitación'),
(22, 'Medicina General'),
(23, 'Medicina Intensiva'),
(24, 'Medicina Interna'),
(25, 'Medicina Ocupacional'),
(26, 'Nefrología'),
(27, 'Neonatología'),
(28, 'Neumología'),
(29, 'Neurocirugía'),
(30, 'Neurología'),
(31, 'Oftalmología'),
(32, 'Oncología'),
(33, 'Otorrinolaringología'),
(34, 'Pediatría'),
(35, 'Psicología'),
(36, 'Psiquiatría'),
(37, 'Radiología'),
(38, 'Reumatología'),
(39, 'Traumatología y Ortopedia'),
(40, 'Urología');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

CREATE TABLE `favoritos` (
  `idfav` int(15) NOT NULL,
  `usuario` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `favoritos`
--

INSERT INTO `favoritos` (`idfav`, `usuario`) VALUES
(14, 61);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hclinica`
--

CREATE TABLE `hclinica` (
  `idhistoria` int(15) NOT NULL,
  `idhc` int(15) NOT NULL,
  `idpx` int(15) NOT NULL,
  `idmed` int(15) NOT NULL,
  `tiempoenf` varchar(500) COLLATE utf8mb4_spanish_ci NOT NULL,
  `inicio` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL,
  `curso` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL,
  `sintomas` varchar(500) COLLATE utf8mb4_spanish_ci NOT NULL,
  `relato` varchar(1000) COLLATE utf8mb4_spanish_ci NOT NULL,
  `anthf` varchar(500) COLLATE utf8mb4_spanish_ci NOT NULL,
  `antpp` varchar(500) COLLATE utf8mb4_spanish_ci NOT NULL,
  `medicamentos` varchar(500) COLLATE utf8mb4_spanish_ci NOT NULL,
  `alergias` varchar(500) COLLATE utf8mb4_spanish_ci NOT NULL,
  `freccar` varchar(5) COLLATE utf8mb4_spanish_ci NOT NULL,
  `frecres` varchar(5) COLLATE utf8mb4_spanish_ci NOT NULL,
  `sato` varchar(5) COLLATE utf8mb4_spanish_ci NOT NULL,
  `presion` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `temperatura` varchar(5) COLLATE utf8mb4_spanish_ci NOT NULL,
  `peso` varchar(5) COLLATE utf8mb4_spanish_ci NOT NULL,
  `talla` varchar(5) COLLATE utf8mb4_spanish_ci NOT NULL,
  `imc` varchar(5) COLLATE utf8mb4_spanish_ci NOT NULL,
  `evalfisica` varchar(1000) COLLATE utf8mb4_spanish_ci NOT NULL,
  `prures` varchar(1000) COLLATE utf8mb4_spanish_ci NOT NULL,
  `diagpre` varchar(500) COLLATE utf8mb4_spanish_ci NOT NULL,
  `diagdef` varchar(500) COLLATE utf8mb4_spanish_ci NOT NULL,
  `tratfarm` varchar(500) COLLATE utf8mb4_spanish_ci NOT NULL,
  `indicec` varchar(500) COLLATE utf8mb4_spanish_ci NOT NULL,
  `indicesp` varchar(500) COLLATE utf8mb4_spanish_ci NOT NULL,
  `archivoc` varchar(250) COLLATE utf8mb4_spanish_ci NOT NULL,
  `grabacion` varchar(250) COLLATE utf8mb4_spanish_ci NOT NULL,
  `anexouno` varchar(250) COLLATE utf8mb4_spanish_ci NOT NULL,
  `anexodos` varchar(250) COLLATE utf8mb4_spanish_ci NOT NULL,
  `anexotres` varchar(250) COLLATE utf8mb4_spanish_ci NOT NULL,
  `anexocuatro` varchar(250) COLLATE utf8mb4_spanish_ci NOT NULL,
  `comentario` varchar(1000) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `hclinica`
--

INSERT INTO `hclinica` (`idhistoria`, `idhc`, `idpx`, `idmed`, `tiempoenf`, `inicio`, `curso`, `sintomas`, `relato`, `anthf`, `antpp`, `medicamentos`, `alergias`, `freccar`, `frecres`, `sato`, `presion`, `temperatura`, `peso`, `talla`, `imc`, `evalfisica`, `prures`, `diagpre`, `diagdef`, `tratfarm`, `indicec`, `indicesp`, `archivoc`, `grabacion`, `anexouno`, `anexodos`, `anexotres`, `anexocuatro`, `comentario`) VALUES
(1, 1314771891, 13, 1, '2 meses', 'Brusco', 'Progresivo', 'Dolor de cabeza', 'Paciente expresa cefalea intensa idiopática', 'Niega', 'Niega', 'Niega', 'Niega', '90', '18', '93', '130/90', '37.4', '62', '1.59', '', '', '', 'Cefalea idiopática', 'Cefalea idiopática', 'Paracetamol', 'Ninguno', 'Ninguno', '1314771891_evidencias_68584571431289WhatsApp Image 2019-11-06 at 5.13.52 PM (1).jpeg', '13147718912.png', '', '', '', '', ''),
(2, 1314771913, 13, 1, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '1314771913A161 (1).jpg', '', '', '', 'Me duele mucho la cabeza desde hace 2 meses.'),
(3, 1314771935, 13, 1, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(4, 1314771947, 13, 1, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(5, 1314773099, 13, 1, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(6, 1314773621, 13, 1, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(7, 1313128516, 13, 1, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(8, 1313128522, 13, 1, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(9, 1313128522, 13, 1, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `idupro` int(15) NOT NULL,
  `ndia` int(1) NOT NULL,
  `nhora` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `horarios`
--

INSERT INTO `horarios` (`idupro`, `ndia`, `nhora`) VALUES
(1, 5, 7),
(1, 1, 9),
(1, 5, 8),
(1, 5, 9),
(1, 6, 15),
(2, 2, 9),
(2, 2, 10),
(2, 2, 11),
(2, 2, 12),
(2, 2, 8),
(2, 3, 13),
(2, 3, 15),
(2, 3, 14),
(2, 3, 16),
(2, 3, 17),
(2, 1, 13),
(2, 1, 14),
(2, 1, 15),
(2, 1, 16),
(2, 1, 17),
(3, 1, 9),
(3, 1, 10),
(3, 1, 11),
(3, 1, 13),
(3, 1, 12),
(3, 2, 14),
(3, 2, 15),
(3, 2, 16),
(3, 2, 17),
(3, 2, 18),
(3, 3, 13),
(3, 3, 12),
(3, 3, 11),
(3, 3, 10),
(3, 3, 9),
(1, 1, 8),
(15, 1, 3),
(15, 1, 4),
(15, 1, 4),
(15, 1, 5),
(15, 1, 6),
(15, 1, 7),
(15, 1, 8),
(15, 2, 11),
(15, 2, 12),
(15, 2, 13),
(15, 2, 14),
(15, 2, 15),
(15, 2, 16),
(15, 2, 17),
(15, 3, 3),
(15, 3, 4),
(15, 3, 5),
(15, 3, 6),
(15, 3, 7),
(15, 3, 8),
(15, 5, 10),
(15, 5, 11),
(15, 5, 12),
(15, 5, 13),
(15, 5, 14),
(15, 5, 15),
(15, 5, 16),
(15, 5, 17),
(15, 6, 3),
(15, 6, 4),
(15, 6, 5),
(15, 6, 6),
(15, 6, 7),
(15, 6, 8),
(15, 6, 9),
(15, 7, 16),
(15, 7, 17),
(15, 7, 18),
(15, 7, 19),
(15, 7, 21),
(15, 7, 20),
(45, 1, 16),
(45, 1, 17),
(45, 1, 18),
(45, 1, 19),
(14, 1, 7),
(14, 1, 8),
(14, 1, 9),
(14, 1, 10),
(14, 2, 7),
(14, 2, 8),
(14, 2, 9),
(14, 2, 10),
(14, 3, 7),
(14, 3, 8),
(14, 3, 9),
(14, 3, 10),
(14, 4, 7),
(14, 4, 8),
(14, 4, 9),
(14, 4, 10),
(14, 5, 15),
(14, 5, 16),
(14, 6, 18),
(14, 6, 19),
(14, 6, 20),
(14, 7, 21),
(14, 7, 22),
(14, 7, 23),
(14, 7, 24),
(14, 6, 17),
(14, 5, 14),
(14, 5, 13),
(1, 1, 7),
(1, 2, 20),
(1, 2, 19),
(1, 2, 18),
(1, 2, 17),
(1, 2, 16),
(1, 2, 15),
(1, 4, 15),
(1, 4, 16),
(1, 4, 17),
(1, 4, 18),
(1, 4, 19),
(1, 4, 20),
(1, 6, 16),
(1, 6, 17),
(1, 6, 18),
(1, 6, 19),
(1, 6, 20),
(1, 7, 10),
(1, 7, 11),
(1, 7, 12),
(1, 7, 13),
(1, 7, 14),
(1, 7, 9),
(1, 7, 8),
(1, 7, 7),
(1, 3, 7),
(1, 3, 8),
(1, 3, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `idiomas`
--

CREATE TABLE `idiomas` (
  `id` int(15) NOT NULL,
  `nombre` varchar(15) COLLATE utf16_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci;

--
-- Volcado de datos para la tabla `idiomas`
--

INSERT INTO `idiomas` (`id`, `nombre`) VALUES
(1, 'Alemán'),
(2, 'Chino'),
(3, 'Coreano'),
(4, 'Español'),
(5, 'Francés'),
(6, 'Holandés'),
(7, 'Inglés'),
(8, 'Italiano'),
(9, 'Japonés'),
(10, 'Portugués'),
(11, 'Ruso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lreclamos`
--

CREATE TABLE `lreclamos` (
  `idrec` int(50) NOT NULL,
  `codigo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `nombres` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `apellidos` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `documento` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `numdoc` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `domicilio` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `correo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `nombrestut` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `apellidostut` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `documentotut` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `numdoctut` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `domiciliotut` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `telefonotut` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `correotut` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tipobien` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `monto` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `numcita` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `reclamo` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `evidencia` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `detalle` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `pedido` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `fecha` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `acciones` varchar(1000) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `lreclamos`
--

INSERT INTO `lreclamos` (`idrec`, `codigo`, `nombres`, `apellidos`, `documento`, `numdoc`, `domicilio`, `telefono`, `correo`, `nombrestut`, `apellidostut`, `documentotut`, `numdoctut`, `domiciliotut`, `telefonotut`, `correotut`, `tipobien`, `monto`, `numcita`, `descripcion`, `reclamo`, `evidencia`, `detalle`, `pedido`, `fecha`, `acciones`) VALUES
(1, '83757171738299', 'Luis', 'Bernal', 'DNI', '71738299', 'San Isidro', '967971932', 'leandro190-558@hotmail.com', '', '', '', '', '', '', '', 'Servicio', '100', '', 'El médico no llegó y quiero mi plata', 'Reclamo', '837571717382992.png', 'Es la cita 2', 'Mis 100 soles', '25/05/2023', 'Estimado Luis, hemos revisado su caso y comprobado lo mencionado. Ahora mismo le devolveremos el 100% de su pago.<br />\r\n<br />\r\nLamentamos lo sucedido y esperamos haber solucionado su inconveniente. Gracias por confiar en The Med Universe.'),
(2, '68584571431289', 'Joselyn', 'Bernal', 'DNI', '71431289', 'CEFERINO RAMIREZ', '949321873', 'leandro190-558@hotmail.com', 'María', 'Bernal', 'DNI', '32344332', 'Ceferino Ramirez', '983209733', 'leandro190-558@hotmail.com', 'Producto', '100', '2', 'Se me fue el internet', 'Queja', '68584571431289WhatsApp Image 2019-11-06 at 5.13.52 PM (1).jpeg', 'El doctor se desconectó cuando me salí y ya no me terminó de atender', 'Que lo retiren de la página', '25/05/2023', 'Aún no hay observaciones ni acciones.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `idp` int(15) NOT NULL,
  `idpago` int(15) NOT NULL,
  `usuario` int(15) NOT NULL,
  `usuariopro` int(15) NOT NULL,
  `metodopago` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `fechahorap` datetime NOT NULL,
  `estadopago` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`idp`, `idpago`, `usuario`, `usuariopro`, `metodopago`, `fechahorap`, `estadopago`) VALUES
(1, 1314771891, 13, 1, 'Tarjeta de crédito', '2023-05-07 17:31:17', 'approved'),
(2, 1314771913, 13, 1, 'Tarjeta de crédito', '2023-05-07 17:36:52', 'approved'),
(3, 1314771935, 13, 1, 'Tarjeta de crédito', '2023-05-07 17:40:46', 'approved'),
(4, 1314771947, 13, 1, 'Tarjeta de crédito', '2023-05-07 17:42:24', 'approved'),
(5, 1314773099, 13, 1, 'Tarjeta de crédito', '2023-05-07 17:46:30', 'approved'),
(6, 1314773621, 13, 1, 'Tarjeta de crédito', '2023-05-07 19:45:59', 'approved'),
(7, 1313128516, 13, 1, 'Tarjeta de crédito', '2023-05-27 07:40:12', 'approved'),
(8, 1313128522, 13, 1, 'Tarjeta de crédito', '2023-05-27 07:42:07', 'approved'),
(9, 1313128522, 13, 1, 'Tarjeta de crédito', '2023-05-27 07:42:08', 'approved');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagosadmin`
--

CREATE TABLE `pagosadmin` (
  `idpago` int(11) NOT NULL,
  `idAdmin` int(15) NOT NULL,
  `idCita` int(15) NOT NULL,
  `abonado` varchar(2) NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

CREATE TABLE `paises` (
  `id` int(11) NOT NULL,
  `iso` char(2) DEFAULT NULL,
  `nombre` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`id`, `iso`, `nombre`) VALUES
(1, 'AF', 'Afganistán'),
(2, 'AX', 'Islas Gland'),
(3, 'AL', 'Albania'),
(4, 'DE', 'Alemania'),
(5, 'AD', 'Andorra'),
(6, 'AO', 'Angola'),
(7, 'AI', 'Anguilla'),
(8, 'AQ', 'Antártida'),
(9, 'AG', 'Antigua y Barbuda'),
(10, 'AN', 'Antillas Holandesas'),
(11, 'SA', 'Arabia Saudí'),
(12, 'DZ', 'Argelia'),
(13, 'AR', 'Argentina'),
(14, 'AM', 'Armenia'),
(15, 'AW', 'Aruba'),
(16, 'AU', 'Australia'),
(17, 'AT', 'Austria'),
(18, 'AZ', 'Azerbaiyán'),
(19, 'BS', 'Bahamas'),
(20, 'BH', 'Bahréin'),
(21, 'BD', 'Bangladesh'),
(22, 'BB', 'Barbados'),
(23, 'BY', 'Bielorrusia'),
(24, 'BE', 'Bélgica'),
(25, 'BZ', 'Belice'),
(26, 'BJ', 'Benin'),
(27, 'BM', 'Bermudas'),
(28, 'BT', 'Bhután'),
(29, 'BO', 'Bolivia'),
(30, 'BA', 'Bosnia y Herzegovina'),
(31, 'BW', 'Botsuana'),
(32, 'BV', 'Isla Bouvet'),
(33, 'BR', 'Brasil'),
(34, 'BN', 'Brunéi'),
(35, 'BG', 'Bulgaria'),
(36, 'BF', 'Burkina Faso'),
(37, 'BI', 'Burundi'),
(38, 'CV', 'Cabo Verde'),
(39, 'KY', 'Islas Caimán'),
(40, 'KH', 'Camboya'),
(41, 'CM', 'Camerún'),
(42, 'CA', 'Canadá'),
(43, 'CF', 'República Centroafricana'),
(44, 'TD', 'Chad'),
(45, 'CZ', 'República Checa'),
(46, 'CL', 'Chile'),
(47, 'CN', 'China'),
(48, 'CY', 'Chipre'),
(49, 'CX', 'Isla de Navidad'),
(50, 'VA', 'Ciudad del Vaticano'),
(51, 'CC', 'Islas Cocos'),
(52, 'CO', 'Colombia'),
(53, 'KM', 'Comoras'),
(54, 'CD', 'República Democrática del Congo'),
(55, 'CG', 'Congo'),
(56, 'CK', 'Islas Cook'),
(57, 'KP', 'Corea del Norte'),
(58, 'KR', 'Corea del Sur'),
(59, 'CI', 'Costa de Marfil'),
(60, 'CR', 'Costa Rica'),
(61, 'HR', 'Croacia'),
(62, 'CU', 'Cuba'),
(63, 'DK', 'Dinamarca'),
(64, 'DM', 'Dominica'),
(65, 'DO', 'República Dominicana'),
(66, 'EC', 'Ecuador'),
(67, 'EG', 'Egipto'),
(68, 'SV', 'El Salvador'),
(69, 'AE', 'Emiratos Árabes Unidos'),
(70, 'ER', 'Eritrea'),
(71, 'SK', 'Eslovaquia'),
(72, 'SI', 'Eslovenia'),
(73, 'ES', 'España'),
(74, 'UM', 'Islas ultramarinas de Estados Unidos'),
(75, 'US', 'Estados Unidos'),
(76, 'EE', 'Estonia'),
(77, 'ET', 'Etiopía'),
(78, 'FO', 'Islas Feroe'),
(79, 'PH', 'Filipinas'),
(80, 'FI', 'Finlandia'),
(81, 'FJ', 'Fiyi'),
(82, 'FR', 'Francia'),
(83, 'GA', 'Gabón'),
(84, 'GM', 'Gambia'),
(85, 'GE', 'Georgia'),
(86, 'GS', 'Islas Georgias del Sur y Sandwich del Sur'),
(87, 'GH', 'Ghana'),
(88, 'GI', 'Gibraltar'),
(89, 'GD', 'Granada'),
(90, 'GR', 'Grecia'),
(91, 'GL', 'Groenlandia'),
(92, 'GP', 'Guadalupe'),
(93, 'GU', 'Guam'),
(94, 'GT', 'Guatemala'),
(95, 'GF', 'Guayana Francesa'),
(96, 'GN', 'Guinea'),
(97, 'GQ', 'Guinea Ecuatorial'),
(98, 'GW', 'Guinea-Bissau'),
(99, 'GY', 'Guyana'),
(100, 'HT', 'Haití'),
(101, 'HM', 'Islas Heard y McDonald'),
(102, 'HN', 'Honduras'),
(103, 'HK', 'Hong Kong'),
(104, 'HU', 'Hungría'),
(105, 'IN', 'India'),
(106, 'ID', 'Indonesia'),
(107, 'IR', 'Irán'),
(108, 'IQ', 'Iraq'),
(109, 'IE', 'Irlanda'),
(110, 'IS', 'Islandia'),
(111, 'IL', 'Israel'),
(112, 'IT', 'Italia'),
(113, 'JM', 'Jamaica'),
(114, 'JP', 'Japón'),
(115, 'JO', 'Jordania'),
(116, 'KZ', 'Kazajstán'),
(117, 'KE', 'Kenia'),
(118, 'KG', 'Kirguistán'),
(119, 'KI', 'Kiribati'),
(120, 'KW', 'Kuwait'),
(121, 'LA', 'Laos'),
(122, 'LS', 'Lesotho'),
(123, 'LV', 'Letonia'),
(124, 'LB', 'Líbano'),
(125, 'LR', 'Liberia'),
(126, 'LY', 'Libia'),
(127, 'LI', 'Liechtenstein'),
(128, 'LT', 'Lituania'),
(129, 'LU', 'Luxemburgo'),
(130, 'MO', 'Macao'),
(131, 'MK', 'ARY Macedonia'),
(132, 'MG', 'Madagascar'),
(133, 'MY', 'Malasia'),
(134, 'MW', 'Malawi'),
(135, 'MV', 'Maldivas'),
(136, 'ML', 'Malí'),
(137, 'MT', 'Malta'),
(138, 'FK', 'Islas Malvinas'),
(139, 'MP', 'Islas Marianas del Norte'),
(140, 'MA', 'Marruecos'),
(141, 'MH', 'Islas Marshall'),
(142, 'MQ', 'Martinica'),
(143, 'MU', 'Mauricio'),
(144, 'MR', 'Mauritania'),
(145, 'YT', 'Mayotte'),
(146, 'MX', 'México'),
(147, 'FM', 'Micronesia'),
(148, 'MD', 'Moldavia'),
(149, 'MC', 'Mónaco'),
(150, 'MN', 'Mongolia'),
(151, 'MS', 'Montserrat'),
(152, 'MZ', 'Mozambique'),
(153, 'MM', 'Myanmar'),
(154, 'NA', 'Namibia'),
(155, 'NR', 'Nauru'),
(156, 'NP', 'Nepal'),
(157, 'NI', 'Nicaragua'),
(158, 'NE', 'Níger'),
(159, 'NG', 'Nigeria'),
(160, 'NU', 'Niue'),
(161, 'NF', 'Isla Norfolk'),
(162, 'NO', 'Noruega'),
(163, 'NC', 'Nueva Caledonia'),
(164, 'NZ', 'Nueva Zelanda'),
(165, 'OM', 'Omán'),
(166, 'NL', 'Países Bajos'),
(167, 'PK', 'Pakistán'),
(168, 'PW', 'Palau'),
(169, 'PS', 'Palestina'),
(170, 'PA', 'Panamá'),
(171, 'PG', 'Papúa Nueva Guinea'),
(172, 'PY', 'Paraguay'),
(173, 'PE', 'Perú'),
(174, 'PN', 'Islas Pitcairn'),
(175, 'PF', 'Polinesia Francesa'),
(176, 'PL', 'Polonia'),
(177, 'PT', 'Portugal'),
(178, 'PR', 'Puerto Rico'),
(179, 'QA', 'Qatar'),
(180, 'GB', 'Reino Unido'),
(181, 'RE', 'Reunión'),
(182, 'RW', 'Ruanda'),
(183, 'RO', 'Rumania'),
(184, 'RU', 'Rusia'),
(185, 'EH', 'Sahara Occidental'),
(186, 'SB', 'Islas Salomón'),
(187, 'WS', 'Samoa'),
(188, 'AS', 'Samoa Americana'),
(189, 'KN', 'San Cristóbal y Nevis'),
(190, 'SM', 'San Marino'),
(191, 'PM', 'San Pedro y Miquelón'),
(192, 'VC', 'San Vicente y las Granadinas'),
(193, 'SH', 'Santa Helena'),
(194, 'LC', 'Santa Lucía'),
(195, 'ST', 'Santo Tomé y Príncipe'),
(196, 'SN', 'Senegal'),
(197, 'CS', 'Serbia y Montenegro'),
(198, 'SC', 'Seychelles'),
(199, 'SL', 'Sierra Leona'),
(200, 'SG', 'Singapur'),
(201, 'SY', 'Siria'),
(202, 'SO', 'Somalia'),
(203, 'LK', 'Sri Lanka'),
(204, 'SZ', 'Suazilandia'),
(205, 'ZA', 'Sudáfrica'),
(206, 'SD', 'Sudán'),
(207, 'SE', 'Suecia'),
(208, 'CH', 'Suiza'),
(209, 'SR', 'Surinam'),
(210, 'SJ', 'Svalbard y Jan Mayen'),
(211, 'TH', 'Tailandia'),
(212, 'TW', 'Taiwán'),
(213, 'TZ', 'Tanzania'),
(214, 'TJ', 'Tayikistán'),
(215, 'IO', 'Territorio Británico del Océano Índico'),
(216, 'TF', 'Territorios Australes Franceses'),
(217, 'TL', 'Timor Oriental'),
(218, 'TG', 'Togo'),
(219, 'TK', 'Tokelau'),
(220, 'TO', 'Tonga'),
(221, 'TT', 'Trinidad y Tobago'),
(222, 'TN', 'Túnez'),
(223, 'TC', 'Islas Turcas y Caicos'),
(224, 'TM', 'Turkmenistán'),
(225, 'TR', 'Turquía'),
(226, 'TV', 'Tuvalu'),
(227, 'UA', 'Ucrania'),
(228, 'UG', 'Uganda'),
(229, 'UY', 'Uruguay'),
(230, 'UZ', 'Uzbekistán'),
(231, 'VU', 'Vanuatu'),
(232, 'VE', 'Venezuela'),
(233, 'VN', 'Vietnam'),
(234, 'VG', 'Islas Vírgenes Británicas'),
(235, 'VI', 'Islas Vírgenes de los Estados Unidos'),
(236, 'WF', 'Wallis y Futuna'),
(237, 'YE', 'Yemen'),
(238, 'DJ', 'Yibuti'),
(239, 'ZM', 'Zambia'),
(240, 'ZW', 'Zimbabue');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicaciones`
--

CREATE TABLE `publicaciones` (
  `idpub` int(15) NOT NULL,
  `usuario` int(15) NOT NULL,
  `imagen` varchar(50) COLLATE utf16_spanish2_ci NOT NULL,
  `contenido` varchar(150) COLLATE utf16_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci;

--
-- Volcado de datos para la tabla `publicaciones`
--

INSERT INTO `publicaciones` (`idpub`, `usuario`, `imagen`, `contenido`) VALUES
(15, 1, '15A7E62B32EB01.jpg', 'Médico Cirujano egresado de la Universidad Nacional José Faustino Sánchez Carrión.'),
(16, 1, '16B9433191FAF4.jpg', 'Jefe del departamento de Cardiología en el Hospital Regional de Huacho.'),
(17, 1, '1730B5DAF5509D.jpg', 'Fundador de The Med Universe, la nueva app que conecta médicos y pacientes de diferentes partes del mundo.'),
(18, 3, '', 'Egresada en Psicología de la Universidad Católica de Colombia.'),
(19, 3, '', 'Laboro en el departamento de Psicología de la clínica Palermo de Bogotá.'),
(20, 2, '', 'Psicólogo egresado de la Universidad de Buenos Aires.\r\n'),
(21, 2, '', 'Catedrático en la Escuela Profesional de Psicología de la Universidad de Buenos Aires.\r\n'),
(22, 2, '', 'Jefe del departamento de Psicología Familiar en el Hospital de Clínicas José de San Martín.'),
(24, 45, '', 'Médica graduada en la Universidad Nacional Mayor de San Marcos de Lima.'),
(25, 45, '', 'Trabajo en el Mercy Hospital de Miami, Estados Unidos.'),
(26, 45, '', 'Fundadora de la ONG \"Health Matters\" que funciona en Miami desde el 2019.'),
(42, 14, '', 'Estudié Medicina Humana en la Universidad del Valle en Cali, Colombia.<br />\r\n'),
(44, 14, '', 'Tengo amplia experiencia en Telesalud, habiendo recibido capacitaciones para el primer nivel de atención.<br />\r\n'),
(45, 49, '', 'Graduado de la Facultad de Medicina Humana por la UNJFSC.'),
(46, 49, '', 'Trabajo en ESSALUD - Red Sabogal Cap III de Huaral desde el 2008.<br />\r\n'),
(47, 49, '', 'Realicé una maestría en Gerencia de Servicios de Salud.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(15) NOT NULL,
  `nombres` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `apellidos` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `correo` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `contraseña` varchar(150) COLLATE utf8mb4_spanish_ci NOT NULL,
  `token` varchar(200) COLLATE utf8mb4_spanish_ci NOT NULL,
  `codigo` int(6) NOT NULL,
  `nacimiento` date NOT NULL,
  `sexo` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL,
  `pais` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `ciudad` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `enmu` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `fotoperfil` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `estado` varchar(1) COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'V',
  `admin` int(15) NOT NULL DEFAULT '0',
  `indicaciones` varchar(1000) COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'Aún no hay observaciones.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombres`, `apellidos`, `correo`, `contraseña`, `token`, `codigo`, `nacimiento`, `sexo`, `pais`, `ciudad`, `enmu`, `fotoperfil`, `estado`, `admin`, `indicaciones`) VALUES
(1, 'María Fernanda', 'García López', 'joselyn2_10@hotmail.com', '$2y$10$sCMv2VuR8j3bW0aktf4MEu6EVFiNEAkIcS2PaLY6TLcwnrasme1kq', '', 0, '2000-05-21', 'Femenino', 'Perú', 'Huacho', '0000-00-00 00:00:00', '1.jpg', '1', 1, 'G'),
(2, 'Luis Felipe', 'Castillo Gómez', 'luis52009@hotmail.com', '$2y$10$T6Cb.XYbv0dIZ5fniWeJA.p6f.PO5MuOEvTP2bwEs4RKp9fWikQVW', '', 0, '1989-03-04', 'Masculino', 'Brasil', 'Río De Janeiro', '0000-00-00 00:00:00', '2.jpg', '1', 0, 'Malas<br />\r\nintenciones<br />\r\ny comentarios'),
(3, 'María Fernanda', 'Bernal Saavedra', 'mafer1404@hotmail.com', '$2y$10$UA2KVQwQ5MFKpfGFNtllsumtOU1twORT9Snut6X6.RKqmmmanXhy2', '', 0, '2016-04-14', 'Femenino', 'Estados Unidos', 'New York', '0000-00-00 00:00:00', 'defect.jpg', '1', 0, 'Aún no hay observaciones.'),
(9, 'Hamer', 'Valderrama', 'hameralbarran@gmail.com', '$2y$10$axmwbw2zuon.NoTD4C8BkOyshZrsmQXlZm1MjA217qW2PaP85XMCm', 'fc543cec0f6c9dc1e282', 736934, '2022-08-23', 'Masculino', 'Perú', 'Lima', '2022-08-23', 'defect.jpg', '1', 1, 'Imagen indebida.'),
(10, 'Hamer Final', 'Valderrama Final', 'hameralbarran222@gmail.com', '$2y$10$vBNYLGQDuT6FWlyNrbKkI.0Qe28R8f.R5XQX9sWf3gBMkkYz7TQ2e', '04e2e5922c68d73da5d7', 883154, '2022-08-23', 'Masculino', 'Perú', 'Lima', '2022-08-23', 'defect.jpg', '1', 0, 'Aún no hay observaciones.'),
(13, 'Leandro Santiago', 'Bernal Saavedra', 'leandro190-558@hotmail.com', '$2y$10$5Zv4V6MZxS8hG82Np6DaM.VHbWVZc68Oe3.sPKq3M14a0oVO1ySYy', '85558ef0b7a73392d6c4', 613814, '1998-06-21', 'Masculino', 'Perú', 'Huacho', '2022-09-07', '13.jpg', '1', 1, 'Bloqueado'),
(36, 'Luis Jaren', 'Montenegro Vargas', 'lmontenegrovargas5@gmail.com', '$2y$10$rclbhA8WHtK9opwSKOxuZ./6n7NxCOg/.zyd8E6FJklRmNqmoiQOu', '5537d4d6f441f5d7807b', 103625, '2005-07-09', 'Masculino', 'Perú', 'Huacho', '2022-12-10', 'defect.jpg', '1', 0, 'Aún no hay observaciones.'),
(56, 'Hary Samanta', 'Ramirez', 'hsamantha12r@gmail.com', '$2y$10$EbWARojoYiU6Mb7SMmGN0OHZLOhO7jdnq.WoCt1tujEW4RYryzVa2', '5b99b6453dc05ad49fe6', 685960, '2002-12-07', 'Femenino', 'Perú', 'Lima', '2023-03-21', 'defect.jpg', '1', 0, 'Aún no hay observaciones.'),
(58, 'Luis Jaren', 'Montenegro Vargas', 'montenegrovargasluis@hotmail.com', '$2y$10$/JVYWPVqqmouVivVNjFn2uPjN9.P16eTFOuVMb4XKFtLjhVYT5tCi', '0f0b202dbcfabbf2295e', 924304, '2000-07-09', 'Masculino', 'Perú', 'Lima', '2023-04-22', '58.jpg', '1', 0, 'Aún no hay observaciones.'),
(61, 'Seguridad', 'Plataforma', 'seguridad@themeduniverse.com', '$2y$10$QIKKoYh48V6ydKib886nG.cP5gFwRIDkxakz7886.bPewjcfzabxS', '6b564731dac591764291', 206357, '2002-02-22', 'Masculino', 'Países Bajos', 'Otro', '2023-05-22', '61.jpg', '1', 0, 'Aún no hay observaciones.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuariospro`
--

CREATE TABLE `usuariospro` (
  `idpro` int(15) NOT NULL,
  `nombrespro` varchar(50) COLLATE utf16_spanish2_ci NOT NULL,
  `apellidospro` varchar(50) COLLATE utf16_spanish2_ci NOT NULL,
  `correopro` varchar(50) COLLATE utf16_spanish2_ci NOT NULL,
  `contraseñapro` varchar(75) COLLATE utf16_spanish2_ci NOT NULL,
  `tokenpro` varchar(25) COLLATE utf16_spanish2_ci NOT NULL,
  `codigopro` int(6) NOT NULL,
  `nacimientopro` date NOT NULL,
  `sexopro` varchar(15) COLLATE utf16_spanish2_ci NOT NULL,
  `especialidad` varchar(50) COLLATE utf16_spanish2_ci NOT NULL,
  `paispro` varchar(50) COLLATE utf16_spanish2_ci NOT NULL,
  `ciudadpro` varchar(50) COLLATE utf16_spanish2_ci NOT NULL,
  `idiomapro` varchar(15) COLLATE utf16_spanish2_ci NOT NULL,
  `colegiatura` varchar(15) COLLATE utf16_spanish2_ci NOT NULL,
  `enmu` text COLLATE utf16_spanish2_ci NOT NULL,
  `precio` int(15) NOT NULL,
  `fototitulo` varchar(250) COLLATE utf16_spanish2_ci NOT NULL,
  `fotocolegiatura` varchar(250) COLLATE utf16_spanish2_ci NOT NULL,
  `fotodocumento` varchar(250) COLLATE utf16_spanish2_ci NOT NULL,
  `fotoperfilpro` varchar(15) COLLATE utf16_spanish2_ci NOT NULL,
  `estado` varchar(15) COLLATE utf16_spanish2_ci NOT NULL,
  `indicaciones` varchar(300) COLLATE utf16_spanish2_ci NOT NULL,
  `ultimaedicion` text COLLATE utf16_spanish2_ci NOT NULL,
  `admin` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci;

--
-- Volcado de datos para la tabla `usuariospro`
--

INSERT INTO `usuariospro` (`idpro`, `nombrespro`, `apellidospro`, `correopro`, `contraseñapro`, `tokenpro`, `codigopro`, `nacimientopro`, `sexopro`, `especialidad`, `paispro`, `ciudadpro`, `idiomapro`, `colegiatura`, `enmu`, `precio`, `fototitulo`, `fotocolegiatura`, `fotodocumento`, `fotoperfilpro`, `estado`, `indicaciones`, `ultimaedicion`, `admin`) VALUES
(1, 'Leandro Santiago', 'Bernal Saavedra', 'leandro190-558@hotmail.com', '$2y$10$1sG47uouaUwqGre.HgYNI.lDIIezqVwyURMEOtM5PGCmReTd5yIzC', '13b43fd25ba63aad6683', 782986, '1993-06-21', 'Masculino', 'Cardiología', 'Perú', 'Huacho', 'Español', '023189', '2022-09-15', 80, '20191024_170825.jpg', '', '', '1.jpg', '1', 'Varias faltas<br />\r\n', '2023-04-21', 1),
(2, 'Felipe Santiago', 'Valladares Marengo', 'santi-1964@hotmail.com', '$2y$10$MR4HDXm6mwjPw5OZE.4.kOTwk.MCeYCy24FXBxMPXoE2tFiFEMN6S', '', 0, '1964-01-10', 'Masculino', 'Psicología', 'Argentina', 'Buenos Aires', 'Español', '028731', '2022-09-12', 40, '139003929_111186790924618_1289996075048743585_n.jp', '', '', '2.jpg', '1', 'Comentario racista.', '2023-04-21', 1),
(3, 'Ruth Luzmila', 'Baltazar Bernilla', 'l-s-b-30@hotmail.com', '$2y$10$wGMRoqrYG39nYxmOogDuo.mtvPeEWt08h0ZRefFDivhNCzdGnt7FO', '', 0, '1981-05-13', 'Femenino', 'Psicología', 'Colombia', 'Bogotá', 'Español', '4093', '0000-00-00 00:00:00', 30, '1571619208904.jpg', '', '', '3.jpg', '1', 'D', '2023-04-21', 1),
(14, 'Hary Samanta', 'Ramirez Ocampo', 'bernalsaavedraleandro@hotmail.com', '$2y$10$tyjwWXAd.mlw1InAuXe9VO0SoDaIDVDAE02gkf.G4giL3Qna/CgpO', '6b51380818364cbc5cb3', 651148, '1995-12-07', 'Femenino', 'Medicina General', 'Colombia', 'Cali', 'Español', '029744', '2023-04-09', 35, 'leandro@hotmail.com1.- U2.jpg', 'leandro@hotmail.comDNI 1.jpg', 'leandro@hotmail.comWhatsApp Image 2022-08-08 at 7.40.23 PM.jpeg', '14.jpg', '1', 'Revisar imágenes.<br />\r\nBorrar todas<br />\r\n', '2023-04-21', 1),
(45, 'Joselyn Sofía', 'Ostos Flores', 'joselyn2_10@hotmail.com', '$2y$10$flNoedMzeIhR5IkcP9hsWuutv8c/H7xzpVS0F4OOjsidneRs2xi.q', '3709ca7eb811c2fa2397', 372570, '1990-05-21', 'Femenino', 'Ginecología y Obstetricia', 'Estados Unidos', 'Miami', 'Español', '012279', '2022-11-26', 70, 'joselyn2_10@hotmail.comWhatsApp Image 2022-11-26 at 9.29.22 PM (3).jpeg', 'joselyn2_10@hotmail.comWhatsApp Image 2022-11-26 at 9.29.22 PM (2).jpeg', 'joselyn2_10@hotmail.comWhatsApp Image 2022-11-26 at 9.29.22 PM (1).jpeg', '45.jpg', '1', '', '2023-04-21', 0),
(49, 'Charles Eyder', 'Alcántara Paredes', 'leandro190-558@hotmail.co', '$2y$10$/OyESgmnyl/nKdfFBBYbY.ZkN54vVSeVjEWuCqoYKdzubdaMI/kPC', 'fc48e100bde935d876f4', 755247, '1970-11-25', 'Masculino', 'Medicina General', 'Perú', 'Santiago De Chuco', 'Español', '027649', '2023-04-02', 50, 'leandro190-558@hotmail.comhttps___themeduniverse.com__complementarios_1312001325WhatsApp Image 2022-12-19 at 11.32.46 PM.jpeg', 'leandro190-558@hotmail.com_evidencias_50327571738299_documentos_themeduniverse@gmail.comWhatsApp Image 2022-12-20 at 2.12.23 AM (1).jpeg', 'leandro190-558@hotmail.comhttps___themeduniverse.com__anexos_1000000032A2Yape TMU.jpg', '49.jpg', '1', 'Imagen 1<br />\r\nImagen 2', '2023-04-21', 2),
(51, 'Luis Jaren', 'Montenegro Vargas', 'montenegrovargasluis@hotmail.com', '$2y$10$ECJXVaYkv9c31yvf1I9QY.ONDBZzBfP.ywYv2ewi9xwJ.jeW3tHvu', '4ea6fe77b5484046e4d7', 322946, '1990-07-09', 'Masculino', 'Endocrinología', 'Perú', 'Lima', 'Español', '024475', '2023-04-23', 50, 'montenegrovargasluis@hotmail.comDIPLOMA DE TITULO PROFESIONAL.jpeg', 'montenegrovargasluis@hotmail.comDIPLOMA DE COLEGIATURA.jpeg', 'montenegrovargasluis@hotmail.comDOCUMENTO DE IDENTIDAD.jpeg', 'defect.jpg', '0', 'Aún no hay observaciones.', '', 1),
(54, '', '', '', '$2y$10$/aNtN5TTfnRo3JW83BWS7OrdUbv5/9YfeKffRyW1yBRCxqccihCHW', '8896aaeb754be05651f9', 229826, '0000-00-00', '', '', '', '', '', '', '2023-05-26', 0, '', '', '', 'defect.jpg', 'V', 'Aún no hay observaciones.', '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoraciones`
--

CREATE TABLE `valoraciones` (
  `id` int(10) NOT NULL,
  `idu` int(10) NOT NULL,
  `idupro` int(10) NOT NULL,
  `valoracion` int(1) NOT NULL,
  `comentarios` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `fechaRegistro` varchar(25) NOT NULL,
  `fechanoti` varchar(25) NOT NULL,
  `leido` varchar(2) NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `valoraciones`
--

INSERT INTO `valoraciones` (`id`, `idu`, `idupro`, `valoracion`, `comentarios`, `fechaRegistro`, `fechanoti`, `leido`) VALUES
(6, 1, 2, 5, '[\"\"]', '2022-08-30 01:43:29', '2022-11-26 22:13:55', 'SI'),
(42, 1, 1, 5, '[\"\"]', '2022-09-06 22:58:45', '2023-04-21 21:29:33', 'SI'),
(48, 2, 1, 5, '[\"\"]', '2022-09-06 23:19:14', '2022-09-06 23:19:14', 'SI'),
(61, 1, 3, 2, '[\"\"]', '2022-10-29 01:56:04', '2022-11-26 23:10:13', 'NO'),
(68, 13, 1, 5, '[\"\"]', '2022-11-16 19:33:58', '2023-05-23 15:38:01', 'SI'),
(76, 2, 2, 5, '[\"\"]', '2022-11-26 22:13:32', '2022-11-26 22:13:32', 'SI'),
(77, 1, 45, 5, '[\"\"]', '2022-11-26 22:30:01', '2023-04-21 22:51:17', 'SI'),
(84, 13, 49, 4, '[\"\"]', '2023-04-03 08:30:37', '2023-04-03 08:30:50', 'NO'),
(96, 1, 14, 4, '[\"\"]', '2023-04-21 22:50:37', '2023-04-21 22:50:37', 'NO'),
(97, 13, 45, 4, '[\"\"]', '2023-04-21 22:51:34', '2023-04-21 22:51:34', 'SI'),
(99, 1, 1, 0, '[\"{\\\"idUser\\\":1,\\\"nombres\\\":\\\"María Fernanda García López\\\",\\\"esMedicoOPaciente\\\":\\\"PACIENTE\\\",\\\"comentario\\\":\\\"Muchas gracias por su atención doctor Bernal.\\\",\\\"leido\\\":\\\"SI\\\",\\\"fecha\\\":\\\"2023-04-13 10:56:30\\\"}\", \"{\\\"idUser\\\":1,\\\"nombres\\\":\\\"Dr. Leandro Santiago Bernal Saavedra\\\",\\\"esMedicoOPaciente\\\":\\\"MEDICO\\\",\\\"comentario\\\":\\\"Es un placer.\\\",\\\"fecha\\\":\\\"2023-05-23 09:29:42\\\"}\"]', '2023-04-23 10:56:31', '2023-04-23 10:56:31', 'SI'),
(100, 2, 1, 0, '[\"{\\\"idUser\\\":2,\\\"nombres\\\":\\\"Luis Felipe Castillo Gómez\\\",\\\"esMedicoOPaciente\\\":\\\"PACIENTE\\\",\\\"comentario\\\":\\\"Lo recomiendo, 5 estrellas.\\\",\\\"leido\\\":\\\"SI\\\",\\\"fecha\\\":\\\"2023-04-23 11:12:10\\\"}\", \"{\\\"idUser\\\":1,\\\"nombres\\\":\\\"Dr. Leandro Santiago Bernal Saavedra\\\",\\\"esMedicoOPaciente\\\":\\\"MEDICO\\\",\\\"comentario\\\":\\\"Muchas gracias!!\\\",\\\"fecha\\\":\\\"2023-05-23 09:30:03\\\"}\"]', '2023-04-23 11:12:11', '2023-04-23 11:12:11', 'SI'),
(101, 61, 14, 5, '[\"\"]', '2023-05-22 06:47:02', '2023-05-22 06:47:02', 'NO'),
(102, 61, 3, 5, '[\"\"]', '2023-05-22 21:49:23', '2023-05-22 21:49:23', 'NO'),
(130, 13, 1, 0, '[\"{\\\"idUser\\\":13,\\\"nombres\\\":\\\"Víctor Jesús Castillo Gómez\\\",\\\"esMedicoOPaciente\\\":\\\"PACIENTE\\\",\\\"comentario\\\":\\\"Gracias Dr. Bernal.\\\",\\\"leido\\\":\\\"SI\\\",\\\"fecha\\\":\\\"2023-05-15 03:04:18\\\"}\", \"{\\\"idUser\\\":1,\\\"nombres\\\":\\\"Dr. Leandro Santiago Bernal Saavedra\\\",\\\"esMedicoOPaciente\\\":\\\"MEDICO\\\",\\\"comentario\\\":\\\"Con mucho gusto.\\\",\\\"fecha\\\":\\\"2023-05-22 03:04:51\\\"}\"]', '2023-05-15 15:04:18', '2023-05-23 15:04:18', 'SI');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`idAdmin`);

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`idcita`);

--
-- Indices de la tabla `cuentabancaria`
--
ALTER TABLE `cuentabancaria`
  ADD PRIMARY KEY (`idcuentas`);

--
-- Indices de la tabla `cuentabancariaadmin`
--
ALTER TABLE `cuentabancariaadmin`
  ADD PRIMARY KEY (`idcuentas`);

--
-- Indices de la tabla `desabilitar_atencion`
--
ALTER TABLE `desabilitar_atencion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `hclinica`
--
ALTER TABLE `hclinica`
  ADD PRIMARY KEY (`idhistoria`);

--
-- Indices de la tabla `idiomas`
--
ALTER TABLE `idiomas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lreclamos`
--
ALTER TABLE `lreclamos`
  ADD PRIMARY KEY (`idrec`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`idp`);

--
-- Indices de la tabla `pagosadmin`
--
ALTER TABLE `pagosadmin`
  ADD PRIMARY KEY (`idpago`);

--
-- Indices de la tabla `paises`
--
ALTER TABLE `paises`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD PRIMARY KEY (`idpub`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuariospro`
--
ALTER TABLE `usuariospro`
  ADD PRIMARY KEY (`idpro`);

--
-- Indices de la tabla `valoraciones`
--
ALTER TABLE `valoraciones`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administradores`
--
ALTER TABLE `administradores`
  MODIFY `idAdmin` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `idcita` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `cuentabancaria`
--
ALTER TABLE `cuentabancaria`
  MODIFY `idcuentas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cuentabancariaadmin`
--
ALTER TABLE `cuentabancariaadmin`
  MODIFY `idcuentas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `desabilitar_atencion`
--
ALTER TABLE `desabilitar_atencion`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `hclinica`
--
ALTER TABLE `hclinica`
  MODIFY `idhistoria` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `idiomas`
--
ALTER TABLE `idiomas`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `lreclamos`
--
ALTER TABLE `lreclamos`
  MODIFY `idrec` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `idp` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `pagosadmin`
--
ALTER TABLE `pagosadmin`
  MODIFY `idpago` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `paises`
--
ALTER TABLE `paises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=241;

--
-- AUTO_INCREMENT de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  MODIFY `idpub` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de la tabla `usuariospro`
--
ALTER TABLE `usuariospro`
  MODIFY `idpro` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `valoraciones`
--
ALTER TABLE `valoraciones`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;