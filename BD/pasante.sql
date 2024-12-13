-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2024 at 09:38 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pasante`
--

-- --------------------------------------------------------

--
-- Table structure for table `empresas`
--

CREATE TABLE `empresas` (
  `id` int(11) NOT NULL,
  `rif` varchar(15) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `ubicacion` varchar(150) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `empresas`
--

INSERT INTO `empresas` (`id`, `rif`, `nombre`, `ubicacion`, `descripcion`) VALUES
(1, 'J-12345678-9', 'Tech Solutions', 'Caracas, Venezuela', 'Desarrollo de software y soluciones tecnológicas.'),
(2, 'J-98765432-1', 'EcoTurismo', 'Mérida, Venezuela', 'Agencia de turismo ecológico en los Andes.'),
(3, 'J-45678901-2', 'Publicidad Creativa', 'Valencia, Venezuela', 'Agencia de publicidad y diseño gráfico.'),
(4, 'J-65432109-3', 'Innova Administración', 'Maracaibo, Venezuela', 'Consultoría en administración de empresas.'),
(5, 'J-11121314-5', 'Digital Marketing Pro', 'Barquisimeto, Venezuela', 'Especialistas en marketing digital y redes sociales.');

-- --------------------------------------------------------

--
-- Table structure for table `internships`
--

CREATE TABLE `internships` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `estado` enum('pendiente','aceptado','rechazado','cambio_solicitado') DEFAULT 'pendiente',
  `nueva_empresa` text DEFAULT NULL,
  `motivo_cambio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pasantias`
--

CREATE TABLE `pasantias` (
  `id` int(11) NOT NULL,
  `cedula` varchar(9) NOT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `estado` enum('pendiente','confirmada','rechazada') NOT NULL DEFAULT 'pendiente',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `cedula` varchar(9) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `carrera` enum('turismo','informatica','publicidad','administracion') NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `turno` enum('mañana','noche','sabado') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `cedula`, `password`, `email`, `carrera`, `nombres`, `apellidos`, `turno`, `created_at`) VALUES
(1, '31657336', '$2y$10$HsVZtcwmUCv7T.J1R/5HgOvMMfh7xG/9Znhzj28SN6.Dq9yAJRL4q', 'cristianjcastilloa11@gmail.com', 'informatica', 'Cristian Jesus', 'Castillo Alvarado', 'noche', '2024-12-07 03:06:45'),
(2, '12636266', '$2y$10$AdTzzMjuGb2IA9FIX3B6l.nk.Mfp1NybOuZOHjFz4A/2WG.Hdz8KW', 'marisela@gmail.com', 'turismo', 'marisela', 'alvarado rondon', '', '2024-12-07 03:28:58'),
(3, '11194889', '$2y$10$h9szyIWKVcDXyhwP2NrBEu2v01/SKj92ltNjnAfJIwgybfmSovxp6', 'casticj679@gmail.com', 'administracion', 'julio cesar', 'Castillo garcia', 'noche', '2024-12-07 03:35:34'),
(4, '301116677', '$2y$10$bYTymXI3aJFQVX59F12P/eBq4Hl9NIfl299ZLl7wdjxJ7HZe3nA0u', 'jhonge@gmail.con', 'turismo', 'jhogny', '3243242', 'noche', '2024-12-07 14:33:10'),
(5, '10782818', '$2y$10$PUUueA6CUT48QqUZqaAZ.ODxh3gLCUSJz/vfLyFmT.kMemBqQVHwK', 'edith@gmail.com', '', 'Edith', 'Novoa', '', '2024-12-08 05:44:43'),
(6, '10340123', '$2y$10$V8TO7aB0h9U405YXyrmC0uJxMqD7CS/t55yRA4xAKJ282D5vifjpO', 'Nata@gmail.com', 'turismo', 'Jhoneyker', 'Correa', 'mañana', '2024-12-08 06:03:53'),
(7, '123456789', '$2y$10$p0PX78HRO7VwZinqFUIzoew9lulYp.Vpoj/Va0Ip1DuSBLVDTV9.m', '12@gmail.com', 'turismo', '12', '12', 'noche', '2024-12-08 06:05:57'),
(8, '222222222', '$2y$10$yHSxnTBI/lGgcAmnOlKXiuS7RKu.ODgpJ/vgXyy3pqvNxNsZ/R9wK', 'marco@gmail.com', 'turismo', 'marco', 'Torres', 'mañana', '2024-12-08 06:08:58'),
(9, '28180479', '$2y$10$sCOvRwwNFLAicwar3a2Nq.dlyuNkr9QJXV.YZeCCI490448mgkCZ6', 'jhoneykercorrea@gmail.com', 'informatica', 'Jhoneyker', 'Correa', 'noche', '2024-12-08 07:04:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rif` (`rif`);

--
-- Indexes for table `internships`
--
ALTER TABLE `internships`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pasantias`
--
ALTER TABLE `pasantias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cedula` (`cedula`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cedula` (`cedula`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `internships`
--
ALTER TABLE `internships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pasantias`
--
ALTER TABLE `pasantias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `internships`
--
ALTER TABLE `internships`
  ADD CONSTRAINT `internships_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `pasantias`
--
ALTER TABLE `pasantias`
  ADD CONSTRAINT `pasantias_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `users` (`cedula`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
