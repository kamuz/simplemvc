-- Adminer 4.7.8 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `simplemvc`;
CREATE DATABASE `simplemvc` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `simplemvc`;

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `body` text,
  `create_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE `posts`;
INSERT INTO `posts` (`id`, `user_id`, `title`, `body`, `create_at`) VALUES
(1,	1,	'Awesome PHP',	'This is first article',	'2022-09-22 13:40:46'),
(2,	1,	'Simple JavaScript',	'This is the first page',	'2022-09-22 16:15:21'),
(3,	2,	'Node.js for web artisans',	'Node.js is sever side JavaScript',	'2022-09-22 16:20:16'),
(4,	2,	'Intro to MySQL',	'MySQL is the most popular DBMS for the PHP applications',	'2022-09-22 13:49:07');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE `users`;
INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1,	'Volodymyr Kamuz',	'v.kamuz@gmail.com',	'$2y$10$.32InWLNepl3uevLe9sHH.rksaPtjpKzyx4qIMeG2rDGtv4BPU.7W'),
(2,	'Igor Kamuz',	'i.kamuz@gmail.com',	'$2y$10$f09A.dqDS5fzMQ5Ko4c.luCNYJusdZFYGBtvJ7asmEmXmWWhes/VW');

-- 2022-09-22 13:43:55
