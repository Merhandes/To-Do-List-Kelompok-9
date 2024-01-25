-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2023 at 01:48 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `todolist`
--

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `taskid` int(11) NOT NULL,
  `tasklabel` varchar(50) NOT NULL,
  `createdat` timestamp NOT NULL DEFAULT current_timestamp(),
  `due_date` date NOT NULL,
  `description` varchar(100) NOT NULL,
  `taskstatus` enum('not_started','in_progress','waiting_on','completed','canceled') NOT NULL DEFAULT 'not_started'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`taskid`, `tasklabel`, `createdat`, `due_date`, `description`, `taskstatus`) VALUES
(60, 'Tugas UTS', '2023-10-24 11:47:21', '2023-10-24', 'To Do List Project Web Prog Lab', 'in_progress'),
(61, 'Tugas UTS', '2023-10-24 11:47:56', '2023-10-24', 'Website Restoran Project Web Prog Lec', 'in_progress');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(128) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`) VALUES
(1, 'Farrelius Kevin', 'kevin@gmail.com', '$2y$10$j/ibUjiJn.5KFfJtglgZjuf16Pxqd70nlF/hzPVcW1dTaKF6h3Yuu'),
(2, 'Genadi Ikhsan Jaya', 'genadi@gmail.com', '$2y$10$JaczFWDXKwYzsn5L0jM1zelsUegmOwHKCoZvqVRJh19JYYlTmiMFm'),
(3, 'Merhandes Gunawan', 'merhandes@gmail.com', '$2y$10$BGnV9SR/oXobNlv5krHtX.dw0hLc1zBxvTc3BYzoLVeLBX50Qvd0y'),
(4, 'Marcellus Eugene Kaparang', 'marcellus@gmail.com', '$2y$10$Aug3CbO3d.wiNFcYvAY9i.fSj4V/BOCooOa3VDTN8sNBpr3entWAC'),
(5, 'Nicholas Terence Siahaan', 'nicholas@gmail.com', '$2y$10$Br.qe5jfPWHK1mzBMou1fevUfJ.pyOLeaeJlFBpz5IVE1eUOdZdTG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`taskid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `taskid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
