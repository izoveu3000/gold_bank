-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2025 at 07:21 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
  `account_holder` varchar(100) NOT NULL,
  `bank_name` varchar(25) NOT NULL,
  `account_number` varchar(25) NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`bank_id`, `user_id`, `account_holder`, `bank_name`, `account_number`, `active`) VALUES
(13, 5, '', 'KBZ', '1234567890', 1),
(14, 5, '', 'AYA', '1234567890', 1),
(15, 5, '', 'CB', '1234567890', 1),
(17, 1, 'Lynn Htet', 'KBZ', '520520520', 1);

-- --------------------------------------------------------

--
-- Table structure for table `gold_price_history`
--

CREATE TABLE `gold_price_history` (
  `currency_price_id` int(11) NOT NULL,
  `base_buy_price` decimal(10,2) NOT NULL,
  `base_sell_price` decimal(10,2) NOT NULL,
  `changed_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gold_price_history`
--

INSERT INTO `gold_price_history` (`currency_price_id`, `base_buy_price`, `base_sell_price`, `changed_at`) VALUES
(197, 7950000.00, 8000000.00, '2025-10-24 17:10:51'),
(198, 7950000.00, 8050000.00, '2025-10-25 03:09:10'),
(199, 8000000.00, 8050000.00, '2025-10-26 08:38:37');

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
(53, 5, 1, 'hi myat thurein tun', '2025-10-26 16:28:57', 1);

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

INSERT INTO `transaction` (`transaction_id`, `user_id`, `amount`, `price`, `transaction_type`, `transaction_status`, `date`, `is_read`) VALUES
(340, 5, 50000.00, 1000.00, 'deposit', 'approve', '2025-10-26 10:06:33', 0),
(341, 5, 50000.00, 1000.00, 'deposit', 'cancel', '2025-10-26 10:12:07', 0),
(342, 5, 1.00, 8050.00, 'user_gold_buy', 'cancel', '2025-10-26 10:12:39', 0),
(343, 5, 4444.00, 1000.00, 'withdraw', 'cancel', '2025-10-26 10:13:15', 0),
(344, 5, 5.00, 8050.00, 'user_gold_buy', 'approve', '2025-10-26 10:13:57', 0),
(345, 5, 1.00, 8000.00, 'user_gold_sell', 'cancel', '2025-10-26 10:14:18', 0),
(346, 5, 5.00, 8000.00, 'user_gold_sell', 'pending', '2025-10-26 10:31:24', 0),
(347, 5, 1000.00, 1000.00, 'deposit', 'pending', '2025-10-26 16:19:55', 0),
(348, 5, 500.00, 1000.00, 'withdraw', 'reject', '2025-10-26 17:26:19', 0),
(349, 5, 100.00, 1000.00, 'withdraw', 'pending', '2025-10-26 17:14:22', 0),
(350, 5, 0.50, 8050.00, 'user_gold_buy', 'pending', '2025-10-26 17:21:01', 0),
(351, 5, 0.10, 8050.00, 'user_gold_buy', 'approve', '2025-10-26 17:22:11', 0),
(352, 5, 0.10, 8000.00, 'user_gold_sell', 'pending', '2025-10-26 17:22:18', 0);

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

--
-- Dumping data for table `transaction_approve`
--

INSERT INTO `transaction_approve` (`approve_id`, `tran_id`, `bank_id`, `reference_number`, `image`) VALUES
(88, 340, 17, '50000', 'proof_68fdf289b7b485.10346677.jpg'),
(89, 341, 17, '123456789', 'proof_68fdf2d77d06e9.01386160.jpg'),
(90, 343, 14, '', ''),
(91, 347, 17, '1000', 'proof_68fe4a2bea2e06.79355701.jpg'),
(92, 348, 13, '', ''),
(93, 349, 13, '', '');

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
(1, 'ko ko ', 'dmjdid3@gmail.com', '$2y$10$IMzeLWLArhRM/oBJHoGlAOCZY/5Un3DqTieHJNJfgKmqvXyDozbs2', 'admin', '2025-10-25 15:40:01', 'Active now', '2025-09-16 13:25:09', 'vip.jpg', '09698621321', 'bbdc274087834e405c4cd363362f95f3eb5a150420264ef28d485507652b0074', '2025-10-19 18:45:50', 0.00, 0.000),
(5, 'tester', 'tester@gmail.com', '$2y$10$IMzeLWLArhRM/oBJHoGlAOCZY/5Un3DqTieHJNJfgKmqvXyDozbs2', 'user', '2025-10-26 17:00:34', 'Active now', '2025-09-21 18:01:21', 'vip.jpg', '', NULL, NULL, 0.00, 0.000);

-- --------------------------------------------------------

--
-- Table structure for table `user_balance`
--

CREATE TABLE `user_balance` (
  `wallet_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `actual_coin_balance` decimal(20,2) NOT NULL,
  `available_coin_balance` decimal(20,2) NOT NULL,
  `actual_gold_balance` decimal(20,2) NOT NULL,
  `available_gold_balance` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_balance`
--

INSERT INTO `user_balance` (`wallet_id`, `user_id`, `actual_coin_balance`, `available_coin_balance`, `actual_gold_balance`, `available_gold_balance`) VALUES
(15, 5, 8534.45, 3869.20, 5.10, 0.00);

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
-- Indexes for table `gold_price_history`
--
ALTER TABLE `gold_price_history`
  ADD PRIMARY KEY (`currency_price_id`);

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
-- Indexes for table `user_balance`
--
ALTER TABLE `user_balance`
  ADD PRIMARY KEY (`wallet_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `bank_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `gold_price_history`
--
ALTER TABLE `gold_price_history`
  MODIFY `currency_price_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=353;

--
-- AUTO_INCREMENT for table `transaction_approve`
--
ALTER TABLE `transaction_approve`
  MODIFY `approve_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `transaction_note`
--
ALTER TABLE `transaction_note`
  MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_balance`
--
ALTER TABLE `user_balance`
  MODIFY `wallet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bank`
--
ALTER TABLE `bank`
  ADD CONSTRAINT `bank_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `user_balance`
--
ALTER TABLE `user_balance`
  ADD CONSTRAINT `user_balance_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
