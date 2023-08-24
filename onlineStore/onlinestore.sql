-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2023 at 04:37 AM
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
-- Database: `onlinestore`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT current_timestamp(),
  `login_count` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `username`, `password`, `email`, `created_at`, `last_login`, `login_count`) VALUES
(1, 'calove', 'VXvsjr71!', 'calove@clemson.edu', '2023-07-28 19:27:42', '2023-08-06 15:15:51', 71),
(9, 'test123', 'test123', 'test@gmail.com', '2023-07-29 12:07:55', '2023-08-01 18:21:32', 9),
(17, 'test345', 'test345', 'test345@gmail.com', '2023-08-04 18:54:31', '2023-08-04 18:54:53', 2),
(18, 'test12345', 'test12345', 'test12345@gmail.com', '2023-08-04 18:57:19', '2023-08-04 18:57:27', 2),
(19, 'gary123', 'gary123', 'gary123@gmail.com', '2023-08-04 19:39:01', '2023-08-04 19:39:08', 2);

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `address_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `street_address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `postal_code` varchar(20) NOT NULL,
  `country` varchar(100) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`address_id`, `user_id`, `street_address`, `city`, `state`, `postal_code`, `country`, `phone_number`, `email`) VALUES
(1, 1, '120 Birch River Rd', 'Clemson', 'SC', '29611', 'United States', '8643958464', NULL),
(15, 1, '74 Clemson Place Circle', 'Clemson', 'SC', '29611', 'United States', '8643958464', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `completed_orders`
--

CREATE TABLE `completed_orders` (
  `id` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `selected_address` varchar(255) DEFAULT NULL,
  `selected_shipping` varchar(255) DEFAULT NULL,
  `selected_date` varchar(255) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_title` varchar(255) DEFAULT NULL,
  `item_price` float(10,2) DEFAULT NULL,
  `item_color` varchar(50) DEFAULT NULL,
  `item_size` varchar(50) DEFAULT NULL,
  `item_quantity` int(11) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `completed_orders`
--

INSERT INTO `completed_orders` (`id`, `order_id`, `user_id`, `selected_address`, `selected_shipping`, `selected_date`, `item_id`, `item_title`, `item_price`, `item_color`, `item_size`, `item_quantity`, `order_date`) VALUES
(1, '1_1691535642', 1, '120 Birch River Rd, Clemson, 29611, United States', 'Standard Shipping', 'Standard Delivery', 1, 'Baseball Hat', 12.00, 'Black', 'One Size Fits All', 1, '2023-08-08 23:00:42'),
(2, '1_1691535642', 1, '120 Birch River Rd, Clemson, 29611, United States', 'Standard Shipping', 'Standard Delivery', 1, 'Baseball Hat', 12.00, 'Black', 'One Size Fits All', 1, '2023-08-08 23:00:42'),
(3, '1_1691535642', 1, '120 Birch River Rd, Clemson, 29611, United States', 'Standard Shipping', 'Standard Delivery', 3, 'Top Hat', 102.00, 'black', 'One Size Fits All', 1, '2023-08-08 23:00:42'),
(4, '1_1691535642', 1, '120 Birch River Rd, Clemson, 29611, United States', 'Standard Shipping', 'Standard Delivery', 3, 'Top Hat', 102.00, 'White', 'One Size Fits All', 1, '2023-08-08 23:00:42'),
(5, '1_1691535642', 1, '120 Birch River Rd, Clemson, 29611, United States', 'Standard Shipping', 'Standard Delivery', 3, 'Top Hat', 102.00, 'White', 'One Size Fits All', 1, '2023-08-08 23:00:42'),
(6, '1_1691535642', 1, '120 Birch River Rd, Clemson, 29611, United States', 'Standard Shipping', 'Standard Delivery', 2, 'Cowboy Hat', 52.00, 'Brown', 'One Size Fits All', 1, '2023-08-08 23:00:42'),
(7, '1_1691535642', 1, '120 Birch River Rd, Clemson, 29611, United States', 'Standard Shipping', 'Standard Delivery', 2, 'Cowboy Hat', 52.00, 'Brown', 'One Size Fits All', 1, '2023-08-08 23:00:42'),
(8, '1_1691535642', 1, '120 Birch River Rd, Clemson, 29611, United States', 'Standard Shipping', 'Standard Delivery', 2, 'Cowboy Hat', 52.00, 'Brown', 'One Size Fits All', 1, '2023-08-08 23:00:42'),
(9, '1_1691535642', 1, '120 Birch River Rd, Clemson, 29611, United States', 'Standard Shipping', 'Standard Delivery', 2, 'Cowboy Hat', 52.00, 'Brown', 'One Size Fits All', 1, '2023-08-08 23:00:42'),
(10, '1_1691535642', 1, '120 Birch River Rd, Clemson, 29611, United States', 'Standard Shipping', 'Standard Delivery', 2, 'Cowboy Hat', 52.00, 'Brown', 'One Size Fits All', 1, '2023-08-08 23:00:42'),
(11, '1_1691535642', 1, '120 Birch River Rd, Clemson, 29611, United States', 'Standard Shipping', 'Standard Delivery', 2, 'Cowboy Hat', 52.00, 'Brown', 'One Size Fits All', 1, '2023-08-08 23:00:42'),
(12, '1_1691535642', 1, '120 Birch River Rd, Clemson, 29611, United States', 'Standard Shipping', 'Standard Delivery', 2, 'Cowboy Hat', 52.00, 'Brown', 'One Size Fits All', 1, '2023-08-08 23:00:42'),
(13, '1_1691535642', 1, '120 Birch River Rd, Clemson, 29611, United States', 'Standard Shipping', 'Standard Delivery', 2, 'Cowboy Hat', 52.00, 'Brown', 'One Size Fits All', 1, '2023-08-08 23:00:42'),
(14, '1_1691535642', 1, '120 Birch River Rd, Clemson, 29611, United States', 'Standard Shipping', 'Standard Delivery', 2, 'Cowboy Hat', 52.00, 'Brown', 'One Size Fits All', 1, '2023-08-08 23:00:42'),
(15, '1_1691535642', 1, '120 Birch River Rd, Clemson, 29611, United States', 'Standard Shipping', 'Standard Delivery', 2, 'Cowboy Hat', 52.00, 'Brown', 'One Size Fits All', 1, '2023-08-08 23:00:42'),
(16, '1_1691535642', 1, '120 Birch River Rd, Clemson, 29611, United States', 'Standard Shipping', 'Standard Delivery', 2, 'Cowboy Hat', 52.00, 'Brown', 'One Size Fits All', 1, '2023-08-08 23:00:42'),
(17, '1_1691535642', 1, '120 Birch River Rd, Clemson, 29611, United States', 'Standard Shipping', 'Standard Delivery', 2, 'Cowboy Hat', 52.00, 'Brown', 'One Size Fits All', 3, '2023-08-08 23:00:42'),
(18, '1_1691535642', 1, '120 Birch River Rd, Clemson, 29611, United States', 'Standard Shipping', 'Standard Delivery', 9, 'Chicago Manual of Style', 9.99, 'None', 'None', 1, '2023-08-08 23:00:42'),
(19, '1_1691535642', 1, '120 Birch River Rd, Clemson, 29611, United States', 'Standard Shipping', 'Standard Delivery', 6, 'Sweat-shirt', 22.00, 'Red', 'L', 1, '2023-08-08 23:00:42'),
(20, '1_1691535642', 1, '120 Birch River Rd, Clemson, 29611, United States', 'Standard Shipping', 'Standard Delivery', 6, 'Sweat-shirt', 22.00, 'Red', 'L', 1, '2023-08-08 23:00:42'),
(32, '1_1691546589', 1, '74 Clemson Place Circle, Clemson, 29611, United States', 'Express', 'Next Day Delivery', 12, 'Level 40 Unlocked Shirt Video Gamer 40th Birthday Gifts Tee T-Shirt', 19.99, 'Black', 'S', 1, '2023-08-09 02:03:09'),
(33, '1_1691546589', 1, '74 Clemson Place Circle, Clemson, 29611, United States', 'Express', 'Next Day Delivery', 6, 'Sweatshirt', 22.00, 'Red', 'M', 1, '2023-08-09 02:03:09'),
(34, '1_1691546589', 1, '74 Clemson Place Circle, Clemson, 29611, United States', 'Express', 'Next Day Delivery', 3, 'Top Hat', 102.00, 'White', 'One Size Fits All', 1, '2023-08-09 02:03:09'),
(35, '1_1691546666', 1, '120 Birch River Rd, Clemson, 29611, United States', 'Standard Shipping', 'Standard Delivery', 10, 'Ripley\'s Believe It or Not! 2023', 26.75, 'None', 'None', 4, '2023-08-09 02:04:26'),
(36, '1_1691546748', 1, '74 Clemson Place Circle, Clemson, 29611, United States', 'Standard Shipping', 'Standard Delivery', 6, 'Sweatshirt', 22.00, 'Orange', 'S', 2, '2023-08-09 02:05:48'),
(37, '1_1691548600', 1, '120 Birch River Rd, Clemson, 29611, United States', 'Standard Shipping', 'Next Day Delivery', 10, 'Ripley\'s Believe It or Not! 2023', 26.75, 'None', 'None', 1, '2023-08-09 02:36:40');

-- --------------------------------------------------------

--
-- Table structure for table `shoppingcart`
--

CREATE TABLE `shoppingcart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_title` varchar(75) DEFAULT NULL,
  `item_price` float(8,2) DEFAULT NULL,
  `item_image` varchar(50) DEFAULT NULL,
  `item_color` varchar(25) NOT NULL,
  `item_size` varchar(25) NOT NULL,
  `item_quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Triggers `shoppingcart`
--
DELIMITER $$
CREATE TRIGGER `set_cart_id_after_insert` BEFORE INSERT ON `shoppingcart` FOR EACH ROW BEGIN
  SET NEW.cart_id = NEW.user_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `store_categories`
--

CREATE TABLE `store_categories` (
  `id` int(11) NOT NULL,
  `cat_title` varchar(50) DEFAULT NULL,
  `cat_desc` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `store_categories`
--

INSERT INTO `store_categories` (`id`, `cat_title`, `cat_desc`) VALUES
(1, 'Hats', 'Funky hats in all shapes and sizes!'),
(2, 'Shirts', 'From t-shirts to sweatshirts to polo shirts and beyond.'),
(3, 'Books', 'Paperback, hardback, books for school or play.');

-- --------------------------------------------------------

--
-- Table structure for table `store_items`
--

CREATE TABLE `store_items` (
  `id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `item_title` varchar(75) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `item_price` float(8,2) DEFAULT NULL,
  `item_desc` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `item_image` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `store_items`
--

INSERT INTO `store_items` (`id`, `cat_id`, `item_title`, `item_price`, `item_desc`, `item_image`) VALUES
(1, 1, 'Baseball Hat', 12.00, 'Fancy, low-profile baseball hat.', 'baseballhat.gif'),
(2, 1, 'Cowboy Hat', 52.00, '10 gallon variety.', 'cowboyhat.gif'),
(3, 1, 'Top Hat', 102.00, 'Good for costumes.', 'tophat.gif'),
(4, 2, 'Short-Sleeved T-Shirt', 12.00, '100% cotton, pre-shrunk.', 'sst-shirt.gif'),
(5, 2, 'Long-Sleeved T-Shirt', 15.00, 'Just like the short-sleeved shirt, with longer sleeves.', 'lstshirt.gif'),
(6, 2, 'Sweatshirt', 22.00, 'Heavy and warm.', 'sweatshirt.gif'),
(7, 3, 'Jane\'s Self-Help Book', 12.00, 'Jane gives advice.', 'selfhelp-book.gif'),
(8, 3, 'Generic Academic Book', 32.00, 'Some required reading for school, will put you to sleep.', 'boringbook.gif'),
(9, 3, 'Chicago Manual of Style', 9.99, 'Good for copywriters.', 'chicagostyle.gif'),
(10, 3, 'Ripley\'s Believe It or Not! 2023', 26.75, 'Read all about the extraordinary feats of humanity', 'Ripleys-2023-swirl.gif'),
(11, 3, 'Interesting Facts For Curious Minds: ', 12.89, '1572 Random But Mind-Blowing Facts About History, Science, Pop Culture And Everything In Between', 'curiousminds.gif'),
(12, 2, 'Level 40 Unlocked Shirt Video Gamer 40th Birthday Gifts Tee T-Shirt', 19.99, 'Level 40 Unlocked tshirt 40th video game birthday party. ', '40gamer.gif');

-- --------------------------------------------------------

--
-- Table structure for table `store_item_color`
--

CREATE TABLE `store_item_color` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_color` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `store_item_color`
--

INSERT INTO `store_item_color` (`id`, `item_id`, `item_color`) VALUES
(1, 1, 'Red'),
(2, 1, 'Black'),
(3, 1, 'Blue'),
(4, 2, 'Brown'),
(6, 3, 'White'),
(5, 3, 'Black'),
(7, 6, 'Black'),
(8, 6, 'White'),
(9, 6, 'Red'),
(10, 6, 'Orange'),
(11, 6, 'Yellow'),
(12, 6, 'Green'),
(13, 6, 'Blue'),
(14, 6, 'Indigo'),
(15, 6, 'Violet'),
(16, 4, 'Black'),
(17, 4, 'White'),
(18, 4, 'Red'),
(19, 4, 'Orange'),
(20, 4, 'Yellow'),
(21, 4, 'Green'),
(22, 4, 'Blue'),
(23, 4, 'Indigo'),
(24, 4, 'Violet'),
(25, 5, 'Black'),
(26, 5, 'White'),
(27, 5, 'Red'),
(28, 5, 'Orange'),
(29, 5, 'Yellow'),
(30, 5, 'Green'),
(31, 5, 'Blue'),
(32, 5, 'Indigo'),
(33, 5, 'Violet'),
(34, 12, 'Black');

-- --------------------------------------------------------

--
-- Table structure for table `store_item_size`
--

CREATE TABLE `store_item_size` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_size` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `store_item_size`
--

INSERT INTO `store_item_size` (`id`, `item_id`, `item_size`) VALUES
(1, 1, 'One Size Fits All'),
(2, 2, 'One Size Fits All'),
(3, 3, 'One Size Fits All'),
(4, 4, 'S'),
(5, 4, 'M'),
(6, 4, 'L'),
(7, 4, 'XL'),
(8, 6, 'XS'),
(9, 6, 'S'),
(10, 6, 'M'),
(11, 6, 'L'),
(12, 6, 'XL'),
(13, 12, 'S'),
(14, 12, 'M'),
(15, 12, 'L'),
(16, 12, 'XL');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `completed_orders`
--
ALTER TABLE `completed_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shoppingcart`
--
ALTER TABLE `shoppingcart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `store_categories`
--
ALTER TABLE `store_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cat_title` (`cat_title`);

--
-- Indexes for table `store_items`
--
ALTER TABLE `store_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_item_color`
--
ALTER TABLE `store_item_color`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_item_size`
--
ALTER TABLE `store_item_size`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `completed_orders`
--
ALTER TABLE `completed_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `shoppingcart`
--
ALTER TABLE `shoppingcart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `store_categories`
--
ALTER TABLE `store_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `store_items`
--
ALTER TABLE `store_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `store_item_color`
--
ALTER TABLE `store_item_color`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `store_item_size`
--
ALTER TABLE `store_item_size`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `accounts` (`id`);

--
-- Constraints for table `shoppingcart`
--
ALTER TABLE `shoppingcart`
  ADD CONSTRAINT `shoppingcart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `accounts` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
