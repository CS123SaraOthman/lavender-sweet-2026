-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 05 ديسمبر 2025 الساعة 22:27
-- إصدار الخادم: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lavender`
--

-- --------------------------------------------------------

--
-- بنية الجدول `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`) VALUES
(39, 111, 3, 2),
(40, 111, 9, 1);

-- --------------------------------------------------------

--
-- بنية الجدول `orders`
--

CREATE TABLE `orders` (
  `id` int(50) NOT NULL,
  `user_id` int(50) NOT NULL,
  `total_price` decimal(50,0) NOT NULL,
  `payment_status` varchar(20) DEFAULT 'pending',
  `order_status` varchar(20) DEFAULT 'processing'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `payment_status`, `order_status`) VALUES
(1, 111, 0, 'pending', 'processing'),
(2, 111, 59, 'pending', 'processing'),
(3, 111, 59, 'pending', 'processing'),
(4, 111, 45, 'pending', 'processing'),
(5, 111, 46, 'pending', 'processing'),
(6, 111, 65, 'pending', 'processing'),
(7, 111, 21, 'pending', 'processing'),
(8, 111, 50, 'pending', 'processing'),
(9, 229, 63, 'pending', 'processing'),
(10, 229, 40, 'pending', 'processing');

-- --------------------------------------------------------

--
-- بنية الجدول `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `total`) VALUES
(1, 3, 2, 1, 20.00, 20.00),
(2, 3, 4, 1, 23.00, 23.00),
(3, 3, 17, 2, 5.50, 11.00),
(4, 3, 13, 1, 5.00, 5.00),
(5, 4, 3, 2, 22.50, 45.00),
(6, 5, 3, 1, 22.50, 22.50),
(7, 5, 4, 1, 23.00, 23.00),
(8, 6, 3, 2, 22.50, 45.00),
(9, 6, 2, 1, 20.00, 20.00),
(10, 7, 5, 1, 21.00, 21.00),
(11, 8, 1, 2, 25.00, 50.00),
(12, 9, 2, 2, 20.00, 40.00),
(13, 9, 3, 1, 22.50, 22.50),
(14, 10, 2, 2, 20.00, 40.00);

-- --------------------------------------------------------

--
-- بنية الجدول `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `flavor` varchar(50) NOT NULL,
  `img` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `product`
--

INSERT INTO `product` (`id`, `name`, `type`, `flavor`, `img`, `description`, `price`) VALUES
(1, 'Rose Blossom Box', 'gift', 'dark', 'gd1.jpg', '\"A dark chocolate gift box filled with the essence of fresh roses.\"', 25.00),
(2, 'Evening Touch', 'gift', 'dark', 'gd2.jpg', '\"Rich dark chocolate with a delicate evening-inspired touch.\"', 20.00),
(3, 'Milk Delight', 'gift', 'milk', 'gm1.png', '\"Smooth milk chocolate for a sweet, creamy delight.\"', 22.50),
(4, 'Milk Softness', 'gift', 'milk', 'gm2.png', '\"Soft and creamy milk chocolate that melts in your mouth.\"', 23.00),
(5, 'Sugar White', 'gift', 'white', 'gw2.png', '\"Pure white chocolate with a subtle, sweet elegance.\"', 21.00),
(6, 'Vanilla Touch', 'gift', 'white', 'gw1.jpeg', '\"Velvety white chocolate infused with a hint of vanilla.\"', 22.00),
(7, 'Pearl Family Box', 'family', 'white', 'fw1.jpg', 'A classy white chocolate box perfect for family sharing.', 35.00),
(8, 'White Bliss Family', 'family', 'white', 'fw2.jpeg', 'Sweet white chocolate treats for joyful family moments.', 36.50),
(9, 'Night Family', 'family', 'dark', 'fd1.jpg', 'Decadent dark chocolate assortment for family indulgence.', 38.00),
(10, 'Milk Squares Family', 'family', 'milk', 'fm1.jpg', 'Creamy milk chocolate squares loved by everyone in the family.', 33.99),
(11, 'Cream Family', 'family', 'milk', 'fm2.jpg', 'Smooth milk chocolate with creamy filling for family delight.', 33.50),
(12, 'Pearl Bite', 'single', 'white', 'sw1.jpg', 'A bite-sized white chocolate treat full of elegance.', 5.50),
(13, 'White Shine', 'single', 'white', 'sw2.jpg', 'Bright and smooth white chocolate for a quick sweet delight.', 5.00),
(14, 'Milk Drop', 'single', 'milk', 'sm1.jpg', 'Creamy milk chocolate in a small, delightful bite.', 4.50),
(15, 'Milk Delight Bite', 'single', 'milk', 'sm2.jpg', 'Smooth milk chocolate perfect for a little indulgence.', 4.75),
(16, 'Dark Bite', 'singl', 'dark', 'sd1.jpg', 'Intense dark chocolate in a rich, bite-sized treat', 5.25),
(17, 'Dark Touch', 'single', 'dark', 'sd2.jpeg', 'Decadent dark chocolate with a smooth, luxurious touch.', 5.50),
(18, 'Sunset Strawberry', 'single', 'strawberries', 's1.jpg', 'Sweet strawberry-flavored chocolate, a fruity delight.', 5.75),
(19, 'random box', 'gift', '', 'random box.png', '\"Where artistry meets indulgence. Each fragment is a unique expression, a burst of flavour waiting to unfold. Open this treasure, and embark on a vibrant journey of taste. It\'s an invitation to savour pure moments of delight.\"', 15.00);

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `name`, `type`, `location`, `password`, `email`) VALUES
(111, 'sara', 'admin', 'nablus', 'hanen', NULL),
(222, 'zena', 'client ', 'nablus', '1234', NULL),
(223, 'Sara Othman', 'client', 'nablus', '123456', NULL),
(227, 'sawa', 'client', 'aaa', 'aaaaaa', NULL),
(228, 'زينة عثمان', 'client', 'nablus', '123456', NULL),
(229, 'Sara Shehadi', '', 'nablus', '', 'sarashehadi17@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `fk_cart_user` (`user_id`),
  ADD KEY `fk_cart_product` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=232;

--
-- قيود الجداول المُلقاة.
--

--
-- قيود الجداول `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_cart_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- قيود الجداول `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
