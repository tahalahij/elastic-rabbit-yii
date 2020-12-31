-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 31, 2020 at 01:45 PM
-- Server version: 10.5.8-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testyii`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `title`, `description`, `author_id`) VALUES
(1, 'how to setup elastic on ubuntu', 'update etc/elastic/elasticsearch.yaml :\r\nuncomment node.name\r\nuncomment and change : network.host : 0.0.0.0\r\nuncomment discovery.seed_hosts an change to [\"127.0.0.1\"]\r\nuncomment  cluster.initil_master-node and change to only [\"node-1\"]\r\ncurl XGET 127.0.0.1:9200     // check if installed', 1),
(2, 'how to setup RabbitMQ on an ubuntu', 'approach 1:\r\ninstalling link:\r\nhttps://computingforgeeks.com/how-to-install-latest-rabbitmq-server-on-ubuntu-linux/\r\nerlang is a requirement :\r\nhttps://computingforgeeks.com/how-to-install-latest-erlang-on-ubuntu-linux/\r\nthe management panel:\r\nhttp://localhost:15672/\r\napproach 2:\r\nif docker :\r\ndocker run -it --rm --name rabbitmq -p 5672:5672 -p 15672:15672 rabbitmq:3-management\r\n##it\'s recommended to install Mysql Workbench Community', 1),
(3, 'Working with Forms', 'This section describes how to create a new page with a form for getting data from users. The page will display a form with a name input field and an email input field. After getting those two pieces of information from the user, the page will echo the entered values back for confirmation.\r\n\r\nTo achieve this goal, besides creating an action and two views, you will also create a model.\r\n\r\nThrough this tutorial, you will learn how to:\r\n\r\ncreate a model to represent the data entered by a user through a form,\r\ndeclare rules to validate the data entered,\r\nbuild an HTML form in a view.\r\n', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`) VALUES
(1, 'amir', 'amir'),
(2, 'mani', 'mani');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
