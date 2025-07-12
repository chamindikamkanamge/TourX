-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2024 at 12:12 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `update`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `username` varchar(50) NOT NULL,
  `where_to` varchar(50) NOT NULL,
  `how_many` varchar(50) NOT NULL,
  `arrivals_date` date NOT NULL,
  `leaving_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`username`, `where_to`, `how_many`, `arrivals_date`, `leaving_date`) VALUES
('Thakshila', 'sigiriya', '2', '2024-05-22', '2024-05-26'),
('sithmini', 'galle', '2', '2024-06-10', '2024-06-20');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `phone`, `subject`) VALUES
(1, 'chamindi', 'chamindikamkanamge@gmail.com', '', 'service');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` varchar(50) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`name`, `email`, `number`, `subject`, `message`) VALUES
('chamindi', 'chamindikamkanamge@gmail.com', '1', 'dfdfd', 'dgfddg'),
('chamindi', 'chamindikamkanamge@gmail.com', '2', 'good services', 'edefe'),
('', '', '', '', ''),
('', '', '', '', ''),
('', '', '', '', ''),
('', '', '', '', ''),
('', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `image` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `name`, `price`, `description`, `image`) VALUES
(21, 'galle', '2000.00', 'Maru hebei', 0x31342e706e67),
(22, 'yala', '9000.00', 'mala painawa', 0x342e706e67),
(23, 'safari', '9000.00', 'wwww', 0x372e706e67),
(24, 'ambalangoda', '7500.00', 'amazing historical places', 0x362e706e67),
(25, 'hikkaduwa', '7500.00', 'amazing', 0x352e706e67),
(26, 'polonnaruwa', '10000.00', 'historical place', 0x31302e706e67),
(27, 'katharagama', '12000.00', 'Sacred kovil of god katharagama', 0x31372e706e67),
(28, 'sigiriya', '15000.00', 'historical place', 0x382e706e67);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `rdate` date NOT NULL,
  `reviewName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `package_id`, `rating`, `comment`, `rdate`, `reviewName`) VALUES
(1, 6, 3, 5, 'amazing', '2024-06-01', 'Hilter'),
(18, 0, 0, 0, 'beautiful', '2024-06-10', 'maria'),
(37, 0, 0, 0, 'wonderful', '2024-06-11', 'shanika'),
(38, 0, 0, 0, 'this is a rest', '2024-06-11', 'Test'),
(51, 0, 0, 0, 'kela poddak gala blnna', '2024-06-13', 'chaaaa');

-- --------------------------------------------------------

--
-- Table structure for table `signup`
--

CREATE TABLE `signup` (
  `Username` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `signup`
--

INSERT INTO `signup` (`Username`, `Email`, `Password`) VALUES
('Thakshila', 'chamindikamkanamge@gmail.com', '20021025');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `usertype`) VALUES
(1, 'Thakshila', 'thakshi216@gmail.com', '$2y$10$hyGiaKhd1QY6ymAyXc6VaO31qAqFLKNtFjDGOT6pJ1fTjr3TIQLfC', ''),
(2, 'kalani', 'chamindikamkanamge@gmail.com', '20021025', 'user'),
(6, 'cha', 'cha@gmail.com', '20021025', 'admin'),
(13, 'hesh', 'hesh@gmail.com', '80230@CHE', 'user'),
(14, 'bawa', 'bawa@gmail.com', '$2y$10$66lyA0yVFIbMkVxZWRCoseYZREX.YZ9SjZErL.w7fJwYAkbM.NgQO', 'admin'),
(16, 'cheth', 'baw@gmail.com', '$2y$10$7e5dvQtVGtnbIvY7bXt.wu1OUNW8PQBIK4tr9tbdbaJ9f8aonsVEm', 'admin'),
(17, 'wew', 'bawqa@gmail.com', '$2y$10$M9q7RGBLHDJH.Tj0X82NbeyqLBfG4cNnfHtzaRwM2SMumDHykIQQu', 'admin'),
(18, 'wqqw', 'bawwwwwa@gmail.com', '$2y$10$zcpAPix24Hzp1bKLQyXkZ.bEo1t3TRUCPHtPphowGO2qITSD5KnTm', 'admin'),
(19, 'qwqwq', 'bawaqqq@gmail.com', '$2y$10$3kJz5MnLhI0FlZClww9NuemALTNRrcJ4bXQ42kVyJ/oEAN8SAjcZ2', 'admin'),
(20, 'wewewe', 'bawawwww@gmail.com', '$2y$10$RSvtvqTYM2ho/fF8Kj9x8uiycleuHIMARFsxOv7p5VFFgHbhKmRWW', 'admin'),
(21, 'rewq', 'bawawqw@gmail.com', '$2y$10$4nzK.Tf0LDEFed6gFjElXusCHvk35Ueue2ajt/TmewJHS205RDufK', 'admin'),
(22, 'nawa', 'baawa@gmail.com', '$2y$10$8bS6hPwOCFrKgdoMDHWAGub0VAzQmutaWReMCMtHWBt7CJUY/YfeK', 'admin'),
(23, 'chami', 'chami@gmail.com', '80230@CHE', 'user'),
(24, 'chakka', 'chakka@gmail.com', '$2y$10$3qBNBJ39eqFg0A4lyX.Ypu0hRk.M6.oLW.08juGsBUQPNN3wyzeIy', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
