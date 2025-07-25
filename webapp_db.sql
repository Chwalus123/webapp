-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Lip 25, 2025 at 01:53 AM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webapp_db`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `firstName` varchar(13) NOT NULL,
  `lastName` varchar(51) NOT NULL,
  `company` varchar(60) NOT NULL,
  `phone` varchar(13) NOT NULL
) ;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `firstName`, `lastName`, `company`, `phone`) VALUES
(1, 'Halina', 'Modrzejewska', 'AxCompany', '+48936963587'),
(2, 'Leszek', 'Filus', 'WesternW', '+48664219709'),
(3, 'Michał', 'Babiak', 'MichalsCompany', '+48997615138');

--
-- Wyzwalacze `clients`
--
DELIMITER $$
CREATE TRIGGER `trg_clients_phone_insert` BEFORE INSERT ON `clients` FOR EACH ROW BEGIN
  IF LEFT(NEW.phone, 3) <> '+48' THEN
    SET NEW.phone = CONCAT('+48', NEW.phone);
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_clients_phone_update` BEFORE UPDATE ON `clients` FOR EACH ROW BEGIN
  IF LEFT(NEW.phone, 3) <> '+48' THEN
    SET NEW.phone = CONCAT('+48', NEW.phone);
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `client_employee`
--

CREATE TABLE `client_employee` (
  `client_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client_employee`
--

INSERT INTO `client_employee` (`client_id`, `employee_id`) VALUES
(1, 1),
(1, 3),
(2, 2),
(2, 3),
(3, 1),
(3, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `firstName` varchar(13) NOT NULL,
  `lastName` varchar(51) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `firstName`, `lastName`) VALUES
(1, 'Aleksandra', 'Uszyńska'),
(2, 'Tymoteusz', 'Wrona'),
(3, 'Roksana', 'Dziak');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `client_employee`
--
ALTER TABLE `client_employee`
  ADD PRIMARY KEY (`client_id`,`employee_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indeksy dla tabeli `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `client_employee`
--
ALTER TABLE `client_employee`
  ADD CONSTRAINT `client_employee_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `client_employee_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
