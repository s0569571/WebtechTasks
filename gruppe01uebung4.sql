-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 02. Apr 2020 um 21:21
-- Server-Version: 10.4.8-MariaDB
-- PHP-Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `gruppe01uebung4`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `produkte`
--

CREATE TABLE `produkte` (
  `id` int(11) NOT NULL,
  `produkt` varchar(45) NOT NULL,
  `preis` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `produkte`
--

INSERT INTO `produkte` (`id`, `produkt`, `preis`) VALUES
(1, 'Broetchen', '0.15'),
(2, 'Schokolade', '1.00'),
(3, 'Butter', '0.50'),
(4, 'Schwarzbrot', '1.50'),
(5, 'Quark', '0.50'),
(6, 'Bonbons', '1.50'),
(7, 'Pizza', '2.39'),
(8, 'Toilettenpapier', '1.20'),
(9, 'Veganes Eis', '9.90'),
(10, 'Olivenoel', '2.99'),
(11, 'Rapsoel', '2.98'),
(12, 'Leinoel', '2.50'),
(13, 'Frischer Fisch', '2.99'),
(14, 'Hamburger', '1.50'),
(15, 'Bienenstich', '5.99'),
(16, 'Chips', '1.59'),
(17, 'Energy Drink', '2.50'),
(18, 'Kaffee', '6.99'),
(19, 'Schwarztee', '1.99'),
(20, 'Kamillentee', '1.89');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `produkte`
--
ALTER TABLE `produkte`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
