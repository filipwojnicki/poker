-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 11 Maj 2017, 00:29
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `poker`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `table`
--

CREATE TABLE IF NOT EXISTS `table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `player1` varchar(255) COLLATE utf8mb4_polish_ci NOT NULL,
  `p1_card1` float NOT NULL,
  `p1_card2` float NOT NULL,
  `p1_result` text COLLATE utf8mb4_polish_ci NOT NULL,
  `player2` varchar(255) COLLATE utf8mb4_polish_ci NOT NULL,
  `p2_card1` float NOT NULL,
  `p2_card2` float NOT NULL,
  `p2_result` text COLLATE utf8mb4_polish_ci NOT NULL,
  `table_card1` float NOT NULL,
  `table_card2` float NOT NULL,
  `table_card3` float NOT NULL,
  `table_card4` float NOT NULL,
  `table_card5` float NOT NULL,
  `round` int(1) NOT NULL DEFAULT '1',
  `wait1` int(11) NOT NULL DEFAULT '1',
  `wait2` int(11) NOT NULL DEFAULT '0',
  `game_token` int(255) NOT NULL,
  `table_name` varchar(255) COLLATE utf8mb4_polish_ci NOT NULL,
  `completed` int(11) NOT NULL DEFAULT '0',
  `win` varchar(11) COLLATE utf8mb4_polish_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
