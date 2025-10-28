-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2025 at 09:31 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `goldbank`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `bank_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bank_name` varchar(25) NOT NULL,
  `account_number` varchar(25) NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`bank_id`, `user_id`, `bank_name`, `account_number`, `active`) VALUES
(1, 1, 'KBZ', '1234567890', 1),
(2, 1, 'AYA', '1234567890', 1),
(3, 1, 'CB', '1234567890', 1),
(4, 2, 'KBZ', '1234567890', 0),
(5, 2, 'AYA', '1234567890', 0),
(6, 2, 'CB', '1234567890', 0),
(10, 4, 'KBZ', '123456789', 0),
(11, 4, 'AYA', '123456789', 0),
(12, 4, 'CB', '1234567890', 0),
(13, 5, 'KBZ', '1234567890', 1),
(14, 5, 'AYA', '1234567890', 1),
(15, 5, 'CB', '1234567890', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bank_info`
--

CREATE TABLE `bank_info` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `account_holder` varchar(100) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `account_number` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `currency_id` int(11) NOT NULL,
  `currency_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`currency_id`, `currency_name`) VALUES
(1, 'gold'),
(2, 'dollar'),
(3, 'mmk');

-- --------------------------------------------------------

--
-- Table structure for table `currency_price`
--

CREATE TABLE `currency_price` (
  `currency_price_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `changed_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `currency_price`
--

INSERT INTO `currency_price` (`currency_price_id`, `currency_id`, `price`, `changed_at`) VALUES
(63, 1, '4100.00', '2025-10-01 07:47:44'),
(64, 1, '4000.00', '2025-09-30 21:48:03'),
(65, 2, '2099.00', '2025-10-01 06:58:01'),
(66, 2, '2089.00', '2025-10-01 01:58:01'),
(67, 1, '4200.00', '2025-10-02 04:47:51'),
(68, 1, '4100.00', '2025-10-02 01:48:11'),
(69, 2, '2089.00', '2025-10-02 01:01:08'),
(70, 2, '2079.00', '2025-10-02 07:01:08'),
(71, 1, '4150.00', '2025-10-02 17:32:59'),
(72, 1, '4050.00', '2025-10-02 17:33:02'),
(73, 2, '2099.00', '2025-10-03 06:03:01'),
(74, 2, '2089.00', '2025-10-03 02:03:01'),
(75, 1, '4080.00', '2025-10-04 06:48:05'),
(76, 1, '4030.00', '2025-10-04 03:48:05'),
(77, 2, '2050.00', '2025-10-04 01:50:38'),
(78, 2, '2040.00', '2025-10-03 22:53:05'),
(79, 1, '4150.00', '2025-10-04 23:53:30'),
(80, 1, '4050.00', '2025-10-05 09:53:30'),
(81, 2, '2070.00', '2025-10-04 23:54:42'),
(82, 2, '2020.00', '2025-10-05 02:54:42'),
(83, 1, '4075.00', '2025-10-06 06:56:26'),
(84, 1, '4030.00', '2025-10-06 06:56:26'),
(85, 2, '2050.00', '2025-10-06 06:57:57'),
(86, 2, '2040.00', '2025-10-06 06:57:57'),
(87, 1, '4140.00', '2025-10-07 06:59:17'),
(88, 1, '4120.00', '2025-10-07 06:59:17'),
(89, 2, '2080.00', '2025-10-07 07:00:40'),
(90, 2, '2070.00', '2025-10-07 07:00:40'),
(91, 1, '4060.00', '2025-10-08 07:01:55'),
(92, 1, '4040.00', '2025-10-08 07:01:55'),
(93, 2, '2060.00', '2025-10-08 07:03:18'),
(94, 2, '2050.00', '2025-10-08 07:03:18'),
(95, 1, '4190.00', '2025-10-09 07:04:43'),
(96, 1, '4170.00', '2025-10-09 07:04:43'),
(97, 2, '2075.00', '2025-10-09 07:06:08'),
(98, 2, '2065.00', '2025-10-09 07:06:08'),
(99, 1, '4080.00', '2025-10-10 07:07:00'),
(100, 1, '4030.00', '2025-10-10 07:07:00'),
(101, 2, '2035.00', '2025-10-10 07:07:46'),
(102, 2, '2015.00', '2025-10-10 07:07:46'),
(103, 2, '2140.00', '2025-10-11 07:11:12'),
(104, 2, '2080.00', '2025-10-11 07:08:48'),
(105, 1, '4300.00', '2025-10-11 07:09:12'),
(106, 1, '4180.00', '2025-10-11 07:09:12'),
(107, 1, '4250.00', '2025-10-12 07:11:46'),
(108, 1, '4200.00', '2025-10-12 07:11:46'),
(109, 2, '2100.00', '2025-10-12 07:12:36'),
(110, 2, '2060.00', '2025-10-12 07:12:36'),
(111, 1, '4150.00', '2025-10-13 07:14:00'),
(112, 1, '4100.00', '2025-10-13 07:14:00'),
(113, 2, '2120.00', '2025-10-13 07:14:36'),
(114, 2, '2080.00', '2025-10-13 07:14:36'),
(115, 1, '4060.00', '2025-10-14 07:15:59'),
(116, 1, '4010.00', '2025-10-14 07:15:59'),
(117, 2, '2030.00', '2025-10-14 07:16:26'),
(118, 2, '2010.00', '2025-10-14 07:16:26');

-- --------------------------------------------------------

--
-- Table structure for table `gold_purchase`
--

CREATE TABLE `gold_purchase` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `purchased_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gold_purchase`
--

INSERT INTO `gold_purchase` (`id`, `user_id`, `amount`, `price`, `total`, `purchased_at`) VALUES
(1, 3, '0.78', '2645.30', '2063.33', '2025-10-01 15:05:28'),
(2, 3, '1.00', '2645.30', '2645.30', '2025-10-01 15:07:25'),
(3, 3, '0.17', '2645.30', '449.70', '2025-10-01 15:10:26'),
(4, 3, '0.17', '2645.30', '449.70', '2025-10-01 15:13:12'),
(5, 3, '0.10', '2645.30', '264.53', '2025-10-01 15:13:21'),
(6, 3, '0.10', '2645.30', '264.53', '2025-10-01 15:13:28'),
(7, 3, '0.10', '2645.30', '264.53', '2025-10-01 15:13:29'),
(8, 3, '0.17', '2645.30', '449.70', '2025-10-01 15:15:00'),
(9, 3, '0.10', '2645.30', '264.53', '2025-10-01 15:15:07'),
(10, 3, '0.16', '2645.30', '423.25', '2025-10-02 13:45:30'),
(11, 3, '0.10', '2645.30', '264.53', '2025-10-15 13:48:52');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `message_id` int(11) NOT NULL,
  `incoming_msg_id` int(11) NOT NULL,
  `outgoing_msg_id` int(11) NOT NULL,
  `message_text` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_read` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`message_id`, `incoming_msg_id`, `outgoing_msg_id`, `message_text`, `date`, `is_read`) VALUES
(1, 2, 1, 'hi', '2025-09-19 13:44:14', 1),
(2, 2, 1, 'hi', '2025-09-19 13:44:14', 1),
(3, 2, 1, 'hi', '2025-09-19 13:44:14', 1),
(4, 2, 1, 'hi', '2025-09-19 13:44:14', 1),
(5, 2, 1, 'hi', '2025-10-17 07:02:11', 1),
(6, 2, 1, 'hi', '2025-10-17 07:02:11', 1),
(7, 2, 1, 'hi', '2025-10-17 07:02:11', 1),
(8, 2, 1, 'hi', '2025-10-17 07:02:11', 1),
(9, 2, 1, 'hi ale', '2025-10-17 07:02:11', 1),
(10, 2, 1, 'i', '2025-10-17 07:02:11', 1),
(11, 2, 1, 'i want', '2025-10-17 07:02:11', 1),
(14, 2, 1, 'gg', '2025-10-17 07:02:11', 1),
(15, 2, 1, 'hi', '2025-10-17 07:02:11', 1),
(16, 2, 1, 'hi', '2025-10-17 07:02:11', 1),
(17, 2, 1, 'ii', '2025-10-17 07:02:11', 1),
(18, 1, 2, 'dddddddddddddddddddddddddddddddddddddddddd', '2025-09-19 16:59:36', 1),
(19, 1, 2, 'nnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnn', '2025-09-19 17:03:04', 1),
(20, 2, 1, 'uuuuu', '2025-10-17 07:02:11', 1),
(21, 1, 4, 'hello how are you', '2025-10-03 08:36:07', 1),
(22, 1, 2, 'm', '2025-10-03 08:48:18', 1),
(23, 1, 2, 'jjjj', '2025-10-03 08:48:18', 1),
(24, 1, 2, 'ji', '2025-10-03 08:48:18', 1),
(25, 1, 2, 'hhhhh', '2025-10-03 08:48:18', 1),
(26, 2, 1, 'hi', '2025-10-17 07:02:11', 1),
(27, 2, 1, 'hi', '2025-10-17 07:02:11', 1),
(28, 2, 1, 'hi july moe this is good to sne', '2025-10-17 07:02:11', 1),
(29, 2, 1, 'i can send nesssage', '2025-10-17 07:02:11', 1),
(30, 2, 1, 'hi', '2025-10-17 07:02:11', 1),
(31, 2, 1, 'ko ko ko chit tel', '2025-10-17 07:02:11', 1),
(32, 2, 1, 'me love wna', '2025-10-17 07:02:11', 1),
(33, 2, 1, 'hello da jia hao', '2025-10-17 07:02:11', 1),
(34, 2, 1, 'we love', '2025-10-17 07:02:11', 1),
(35, 2, 1, 'wang', '2025-10-17 07:02:11', 1),
(36, 2, 1, 'yi', '2025-10-17 07:02:11', 1),
(37, 2, 1, 'bo', '2025-10-17 07:02:11', 1),
(38, 2, 1, 'we', '2025-10-17 07:02:11', 1),
(39, 2, 1, 'love', '2025-10-17 07:02:11', 1),
(40, 2, 1, 'weeeeeeeeeeeeeeeeeeeee', '2025-10-17 07:02:11', 1),
(41, 1, 8, 'jj', '2025-09-23 08:07:42', 1),
(42, 1, 4, 'hi', '2025-09-23 08:07:24', 1),
(43, 1, 10, 'view china', '2025-09-23 08:14:55', 1),
(44, 1, 13, 'apple', '2025-09-23 08:08:34', 1),
(45, 1, 13, 'hi,i am myat thurein tun', '2025-09-23 08:08:34', 1),
(49, 1, 2, 'hello', '2025-09-26 07:42:06', 1),
(51, 2, 1, 'mg', '2025-10-17 07:02:11', 1),
(52, 12, 1, 'id', '2025-10-02 09:19:59', 0);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `transaction_type` varchar(50) NOT NULL,
  `transaction_status` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_read` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transaction_id`, `user_id`, `currency_id`, `amount`, `price`, `transaction_type`, `transaction_status`, `date`, `is_read`) VALUES
(189, 2, 1, '300.00', '1000.00', 'buy gold', 'complete', '2024-12-31 17:46:32', 0),
(190, 2, 1, '400.00', '1000.00', 'sell gold', 'complete', '2025-01-31 17:46:32', 0),
(191, 2, 1, '500.00', '1000.00', 'buy gold', 'complete', '2025-02-28 17:49:36', 0),
(192, 2, 1, '350.00', '1000.00', 'sell gold', 'complete', '2025-03-31 17:49:21', 0),
(193, 2, 2, '450.00', '2000.00', 'deposit', 'complete', '2025-04-30 17:51:57', 0),
(194, 2, 2, '600.00', '2000.00', 'withdraw', 'complete', '2025-05-31 17:51:57', 0),
(195, 2, 2, '500.00', '2000.00', 'deposit', 'complete', '2025-06-30 17:51:57', 0),
(196, 2, 2, '400.00', '2000.00', 'withdraw', 'complete', '2025-07-31 17:51:57', 0);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_approve`
--

CREATE TABLE `transaction_approve` (
  `approve_id` int(11) NOT NULL,
  `tran_id` int(11) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `reference_number` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_note`
--

CREATE TABLE `transaction_note` (
  `note_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(25) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(20) NOT NULL,
  `last_seen` datetime NOT NULL,
  `img` varchar(50) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expires` datetime DEFAULT NULL,
  `balance` decimal(12,2) DEFAULT 0.00,
  `gold_holding` decimal(12,3) NOT NULL DEFAULT 0.000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `email`, `password`, `user_type`, `created_at`, `status`, `last_seen`, `img`, `phone_number`, `reset_token`, `token_expires`, `balance`, `gold_holding`) VALUES
(1, 'Myat Thurein Tun', 'dmjdid3@gmail.com', '$2y$10$1X1zQfJmGOK7J272xHIyfudFkcGGIrtli4pnLb9.lVqnOCQZPeS.u', 'admin', '2025-10-17 07:17:22', 'Active now', '2025-09-16 13:25:09', 'vip.jpg', '', NULL, NULL, '0.00', '0.000'),
(2, 'Mg Mg', 'mgmg@gmail.com', '123456789', 'user', '2025-09-26 08:57:51', 'Active now', '2025-09-16 13:25:15', 'vip.jpg', '', NULL, NULL, '0.00', '0.000'),
(4, 'Ma Ma', 'mama@gmail.com', '123456789', 'user', '2025-09-19 15:38:31', 'Active now', '2025-09-16 13:25:31', 'vip.jpg', '', NULL, NULL, '0.00', '0.000'),
(5, 'tester', 'tester@gmai.com', '123456789', 'user', '2025-09-21 16:03:10', 'Active now', '2025-09-21 18:01:21', 'vip.jpg', '', NULL, NULL, '0.00', '0.000'),
(6, 'wangyibo', 'wangyibo@gmail.com', '123456789', 'user', '2025-09-21 16:06:58', 'Offline now', '2025-09-21 18:05:21', 'vip.jpg', '', NULL, NULL, '0.00', '0.000'),
(7, 'arar', 'arar@gmail.com', '88552200', 'user', '2025-09-22 06:20:29', 'Active now', '2025-09-21 18:58:54', 'vip.jpg', '', NULL, NULL, '0.00', '0.000'),
(8, 'japan', 'japan@gmail.com', '591591591', 'user', '2025-09-22 06:20:23', 'Active now', '2025-09-21 19:11:16', 'vip.jpg', '', NULL, NULL, '0.00', '0.000'),
(9, 'korea', 'korea@gmail.com', '22222222', 'user', '2025-09-21 17:12:55', 'Active now', '2025-09-21 19:11:49', 'vip.jpg', '', NULL, NULL, '0.00', '0.000'),
(10, 'china', 'china@gmai.com', '55555555', 'user', '2025-09-22 06:23:25', 'Offline now', '2025-09-21 19:11:49', 'vip.jpg', '', NULL, NULL, '0.00', '0.000'),
(11, 'min banyar', 'min banyar@gmail.com', '258258258', 'user', '2025-09-25 06:51:25', 'Offline now', '2025-09-22 08:16:12', 'vip.jpg', '', NULL, NULL, '0.00', '0.000'),
(12, 'thurein', 'thurein@gmail.com', '258258258', 'user', '2025-09-22 06:18:04', 'Active now', '2025-09-22 08:16:12', 'vip.jpg', '', NULL, NULL, '0.00', '0.000'),
(13, 'apple', 'apple@gmail.com', '123456789', 'user', '2025-09-23 07:05:25', 'Active now', '2025-09-23 08:27:00', 'vip.jpg', '', NULL, NULL, '0.00', '0.000'),
(14, 'orange', 'orange@gmail.com', '123456789', 'user', '2025-09-23 09:34:03', 'Active now', '2025-09-23 11:33:29', 'vip.jpg', '', NULL, NULL, '0.00', '0.000'),
(15, 'peach', 'peach@gmail.com', '88888888', 'user', '2025-09-25 06:56:10', 'Active now', '2025-09-25 08:54:29', 'vip.jpg', '', NULL, NULL, '0.00', '0.000'),
(17, 'syc', 'diiig857@gmail.com', '$2y$10$qXIt.bLGVORsyT1FL6.ezegKZyicJ3H84JykaFPYKClCe1HZSZdnW', 'user', '2025-10-16 07:55:44', 'Active now', '2025-10-16 09:55:44', 'vip.jpg', '', NULL, NULL, '0.00', '0.000'),
(18, 'sycthe', 'thisnotforschool@gmail.com', '$2y$10$NoK7cF0PVVxKvxieP/Bf/ezlz7qyJTe1bm8ySF9UfDeMQ6vDm9I22', 'user', '2025-10-17 06:56:45', 'Active now', '2025-10-16 10:01:29', 'vip.jpg', '0937463764', '843f5be0366b0ea3d3de3b6dde3e65377dace393b6ad0a8a0dd5803f7cb4d33c', '2025-10-16 12:01:22', '0.00', '0.000');

-- --------------------------------------------------------

--
-- Table structure for table `wallet`
--

CREATE TABLE `wallet` (
  `wallet_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `amount` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wallet`
--

INSERT INTO `wallet` (`wallet_id`, `user_id`, `currency_id`, `amount`) VALUES
(4, 1, 1, '0.00'),
(5, 1, 2, '0.00'),
(6, 1, 3, '50050000.00'),
(7, 2, 1, '50.00'),
(8, 2, 2, '7500.00'),
(11, 4, 1, '500.00'),
(12, 4, 2, '3500.00'),
(13, 5, 1, '999999999.00'),
(14, 5, 2, '999997593.00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`bank_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `bank_info`
--
ALTER TABLE `bank_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`currency_id`);

--
-- Indexes for table `currency_price`
--
ALTER TABLE `currency_price`
  ADD PRIMARY KEY (`currency_price_id`),
  ADD KEY `currency_id` (`currency_id`);

--
-- Indexes for table `gold_purchase`
--
ALTER TABLE `gold_purchase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `incoming_msg_id` (`incoming_msg_id`),
  ADD KEY `outgoing_msg_id` (`outgoing_msg_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `currency_id` (`currency_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `transaction_approve`
--
ALTER TABLE `transaction_approve`
  ADD PRIMARY KEY (`approve_id`),
  ADD KEY `transaction_id` (`tran_id`),
  ADD KEY `bank_id` (`bank_id`);

--
-- Indexes for table `transaction_note`
--
ALTER TABLE `transaction_note`
  ADD PRIMARY KEY (`note_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `transaction_id` (`transaction_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `wallet`
--
ALTER TABLE `wallet`
  ADD PRIMARY KEY (`wallet_id`),
  ADD KEY `currency_id` (`currency_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `bank_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `bank_info`
--
ALTER TABLE `bank_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `currency_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `currency_price`
--
ALTER TABLE `currency_price`
  MODIFY `currency_price_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `gold_purchase`
--
ALTER TABLE `gold_purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- AUTO_INCREMENT for table `transaction_approve`
--
ALTER TABLE `transaction_approve`
  MODIFY `approve_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `transaction_note`
--
ALTER TABLE `transaction_note`
  MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `wallet`
--
ALTER TABLE `wallet`
  MODIFY `wallet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bank`
--
ALTER TABLE `bank`
  ADD CONSTRAINT `bank_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `currency_price`
--
ALTER TABLE `currency_price`
  ADD CONSTRAINT `currency_price_ibfk_1` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`currency_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`incoming_msg_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`outgoing_msg_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`currency_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaction_approve`
--
ALTER TABLE `transaction_approve`
  ADD CONSTRAINT `transaction_approve_ibfk_1` FOREIGN KEY (`tran_id`) REFERENCES `transaction` (`transaction_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_approve_ibfk_2` FOREIGN KEY (`bank_id`) REFERENCES `bank` (`bank_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaction_note`
--
ALTER TABLE `transaction_note`
  ADD CONSTRAINT `transaction_note_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_note_ibfk_2` FOREIGN KEY (`transaction_id`) REFERENCES `transaction` (`transaction_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wallet`
--
ALTER TABLE `wallet`
  ADD CONSTRAINT `wallet_ibfk_1` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`currency_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wallet_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
