-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 10-Abr-2018 às 15:08
-- Versão do servidor: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pew_bolsasemcouro`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `pew_cores_relacionadas`
--

CREATE TABLE `pew_cores_relacionadas` (
  `id` int(11) NOT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `id_relacao` int(11) DEFAULT NULL,
  `data_controle` datetime DEFAULT NULL,
  `status` tinyint(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pew_cores_relacionadas`
--

INSERT INTO `pew_cores_relacionadas` (`id`, `id_produto`, `id_relacao`, `data_controle`, `status`) VALUES
(84, 10, 5, '2018-04-10 03:04:48', 1),
(85, 5, 10, '2018-04-10 03:04:48', 1),
(86, 10, 9, '2018-04-10 03:04:48', 1),
(87, 9, 10, '2018-04-10 03:04:48', 1),
(88, 11, 5, '2018-04-10 03:06:00', 1),
(89, 5, 11, '2018-04-10 03:06:00', 1),
(90, 11, 9, '2018-04-10 03:06:00', 1),
(91, 9, 11, '2018-04-10 03:06:00', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pew_cores_relacionadas`
--
ALTER TABLE `pew_cores_relacionadas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pew_cores_relacionadas`
--
ALTER TABLE `pew_cores_relacionadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
