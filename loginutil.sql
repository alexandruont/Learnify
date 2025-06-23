-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Gazdă: 127.0.0.1
-- Timp de generare: mai 27, 2024 la 08:45 PM
-- Versiune server: 10.4.18-MariaDB
-- Versiune PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Bază de date: `loginutil`
--

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `dash_text`
--

CREATE TABLE `dash_text` (
  `Id` int(11) NOT NULL,
  `user_type_id` varchar(255) DEFAULT NULL,
  `content_text` varchar(255) DEFAULT NULL,
  `titlu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Eliminarea datelor din tabel `dash_text`
--

INSERT INTO `dash_text` (`Id`, `user_type_id`, `content_text`, `titlu`) VALUES
(1, '1', 'BIfsadfasfasfads!', 'Dash admin'),
(2, '2', 'BIne ai venit, utilizator de tip utilizator!', 'Dash utilzator');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `drepturi`
--

CREATE TABLE `drepturi` (
  `Id` int(11) NOT NULL,
  `IdPage` varchar(255) DEFAULT NULL,
  `IdUser` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Eliminarea datelor din tabel `drepturi`
--

INSERT INTO `drepturi` (`Id`, `IdPage`, `IdUser`) VALUES
(1, '1', '1'),
(2, '2', '1'),
(3, '1', '2'),
(4, '3', '1'),
(5, '3', '2'),
(6, '4', '1'),
(7, '5', '2'),
(8, '6', '1'),
(9, '6', '2');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `pagini`
--

CREATE TABLE `pagini` (
  `Id` int(11) NOT NULL,
  `nume_meniu` varchar(255) DEFAULT NULL,
  `pagina` varchar(255) DEFAULT NULL,
  `Meniu` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Eliminarea datelor din tabel `pagini`
--

INSERT INTO `pagini` (`Id`, `nume_meniu`, `pagina`, `Meniu`) VALUES
(1, 'funct1', 'func1.php', '1'),
(2, 'func2', 'func2.php', '0'),
(3, 'funct3', 'f3.php', '0'),
(4, 'Home', 'dashboard.php', '1'),
(5, 'Home', 'dashboardu.php', '1'),
(6, 'Logout', 'logout.php', '1');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `users`
--

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `nume` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Eliminarea datelor din tabel `users`
--

INSERT INTO `users` (`Id`, `nume`, `username`, `password`, `type`) VALUES
(1, 'admin', 'admin', '111', '1'),
(2, 'user', 'user', 'user', '2');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `user_types`
--

CREATE TABLE `user_types` (
  `Id` int(11) NOT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `redirect` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Eliminarea datelor din tabel `user_types`
--

INSERT INTO `user_types` (`Id`, `desc`, `redirect`) VALUES
(1, 'admin', 'dashboard.php'),
(2, 'user', 'dashboardu.php');

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `dash_text`
--
ALTER TABLE `dash_text`
  ADD PRIMARY KEY (`Id`);

--
-- Indexuri pentru tabele `drepturi`
--
ALTER TABLE `drepturi`
  ADD PRIMARY KEY (`Id`);

--
-- Indexuri pentru tabele `pagini`
--
ALTER TABLE `pagini`
  ADD PRIMARY KEY (`Id`);

--
-- Indexuri pentru tabele `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`);

--
-- Indexuri pentru tabele `user_types`
--
ALTER TABLE `user_types`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT pentru tabele eliminate
--

--
-- AUTO_INCREMENT pentru tabele `dash_text`
--
ALTER TABLE `dash_text`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pentru tabele `drepturi`
--
ALTER TABLE `drepturi`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pentru tabele `pagini`
--
ALTER TABLE `pagini`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pentru tabele `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pentru tabele `user_types`
--
ALTER TABLE `user_types`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
