-- Adminer 4.7.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `class_room`;
CREATE TABLE `class_room` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `class_room` (`id`, `class`, `created`, `active`) VALUES
(28,	'ut',	'2016-04-11 15:15:00',	1),
(29,	'repellendus',	'2021-01-10 15:14:17',	1),
(30,	'consequuntur',	'2014-09-15 06:33:09',	1),
(31,	'similique',	'2003-06-10 02:29:35',	0),
(32,	'ipsa',	'1995-06-25 15:11:17',	1);

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210320133346',	'2021-03-20 15:33:57',	57);

-- 2021-03-22 10:00:47
