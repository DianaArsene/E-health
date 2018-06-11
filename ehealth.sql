-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 11 Iun 2018 la 22:10
-- Versiune server: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ehealth`
--

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `programari`
--

CREATE TABLE `programari` (
  `Id` int(11) UNSIGNED NOT NULL,
  `Id_pacient` int(11) UNSIGNED NOT NULL,
  `Id_tip_analiza` int(5) UNSIGNED NOT NULL,
  `Data` date NOT NULL,
  `Id_medic` int(11) UNSIGNED NOT NULL,
  `Status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `rezultate_analize`
--

CREATE TABLE `rezultate_analize` (
  `Id` int(11) UNSIGNED NOT NULL,
  `Id_programare` int(11) UNSIGNED NOT NULL,
  `Rezultat_analize` varchar(100) NOT NULL,
  `Interpretare` varchar(100) NOT NULL,
  `Observatii` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `tip_analize`
--

CREATE TABLE `tip_analize` (
  `Id` int(11) UNSIGNED NOT NULL,
  `Nume` varchar(10) NOT NULL,
  `Descriere` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `utilizatori`
--

CREATE TABLE `utilizatori` (
  `Id` int(11) UNSIGNED NOT NULL,
  `Nume` varchar(100) NOT NULL,
  `Prenume` varchar(100) NOT NULL,
  `Telefon` int(10) NOT NULL,
  `Cnp` int(13) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Varsta` int(5) NOT NULL,
  `Parola` varchar(100) NOT NULL,
  `Status` int(1) NOT NULL,
  `Tip` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `utilizatori`
--

INSERT INTO `utilizatori` (`Id`, `Nume`, `Prenume`, `Telefon`, `Cnp`, `Email`, `Varsta`, `Parola`, `Status`, `Tip`) VALUES
(1, 'Popescu', 'Ionut', 975634264, 2147483647, 'popescu_ion@gmail.com', 35, '123qweasdzxc', 0, 1),
(2, 'Ionescu', 'Daniela', 957352749, 2147483647, 'danielapop@yahoo.com', 22, '123qwe', 0, 2),
(3, 'admin', 'admin', 0, 0, 'admin@gmail.com', 45, '12345678', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `programari`
--
ALTER TABLE `programari`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_pacient` (`Id_pacient`),
  ADD KEY `programari_ibfk_2` (`Id_tip_analiza`),
  ADD KEY `Id_medic` (`Id_medic`);

--
-- Indexes for table `rezultate_analize`
--
ALTER TABLE `rezultate_analize`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `rezultate_analize_ibfk_1` (`Id_programare`);

--
-- Indexes for table `tip_analize`
--
ALTER TABLE `tip_analize`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `utilizatori`
--
ALTER TABLE `utilizatori`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `programari`
--
ALTER TABLE `programari`
  MODIFY `Id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rezultate_analize`
--
ALTER TABLE `rezultate_analize`
  MODIFY `Id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tip_analize`
--
ALTER TABLE `tip_analize`
  MODIFY `Id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `utilizatori`
--
ALTER TABLE `utilizatori`
  MODIFY `Id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrictii pentru tabele sterse
--

--
-- Restrictii pentru tabele `programari`
--
ALTER TABLE `programari`
  ADD CONSTRAINT `programari_ibfk_1` FOREIGN KEY (`Id_pacient`) REFERENCES `utilizatori` (`Id`),
  ADD CONSTRAINT `programari_ibfk_2` FOREIGN KEY (`Id_tip_analiza`) REFERENCES `tip_analize` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `programari_ibfk_3` FOREIGN KEY (`Id_medic`) REFERENCES `utilizatori` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrictii pentru tabele `rezultate_analize`
--
ALTER TABLE `rezultate_analize`
  ADD CONSTRAINT `rezultate_analize_ibfk_1` FOREIGN KEY (`Id_programare`) REFERENCES `programari` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
