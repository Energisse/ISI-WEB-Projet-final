-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 20 jan. 2023 à 13:00
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `web4shop`
--

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `delivery_add_id` int DEFAULT NULL,
  `payment_type` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `session_id` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `session_id` (`session_id`)
) ENGINE=InnoDB AUTO_INCREMENT=236 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `delivery_add_id`, `payment_type`, `session_id`) VALUES
(217, 1, 48, 'moneyCheck', NULL),
(218, 2, 68, 'paypal', NULL),
(219, 2, NULL, NULL, '5tdm71cgj9h84edvel55rokldj'),
(220, 1, NULL, NULL, 'pclilbas10ovo6g00tbd0r2o6d'),
(224, 1, 48, 'moneyCheck', NULL),
(225, 1, NULL, NULL, 'qs85u5g5oq3st1qjf3qvafjvcs'),
(226, 1, 71, 'paypal', NULL),
(227, NULL, NULL, NULL, '54giceeaelmamgmdvif34ighb4'),
(228, NULL, NULL, NULL, '3huaejauhs6rsdtknt0ivml25p'),
(229, NULL, NULL, NULL, 'q3150bbt87e0ndjit31dsg5ju3'),
(230, NULL, NULL, NULL, '6r51bl6l3a0dsat7csrc88dt3a'),
(231, 1, 49, 'moneyCheck', NULL),
(232, 1, 71, 'creditCard', NULL),
(234, 1, 49, 'moneyCheck', NULL),
(235, 1, NULL, NULL, 'cgfo6v31vjbgc8se5e1klji1q0');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
