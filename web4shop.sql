-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 18 jan. 2023 à 20:16
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
-- Structure de la vue `viewproduct`
--

DROP VIEW IF EXISTS `viewproduct`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewproduct`  AS   with `orderedproduct` as (select `oi`.`product_id` AS `product_id`,sum(`oi`.`quantity`) AS `quantity` from (`orders` `o` join `orderitems` `oi` on((`o`.`id` = `oi`.`order_id`))) where `o`.`id` in (select `orderstatus`.`order_id` from `orderstatus` where (`orderstatus`.`status` > 1)) is false group by `oi`.`product_id`) select `products`.`id` AS `id`,`products`.`cat_id` AS `cat_id`,`products`.`name` AS `name`,`products`.`description` AS `description`,`products`.`image` AS `image`,`products`.`price` AS `price`,`products`.`quantity` AS `quantity`,(`products`.`quantity` - (select ifnull(max(`orderedproduct`.`quantity`),0) from `orderedproduct` where (`orderedproduct`.`product_id` = `products`.`id`))) AS `quantity_remaining` from `products`  ;

--
-- VIEW `viewproduct`
-- Données : Aucun(e)
--

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
