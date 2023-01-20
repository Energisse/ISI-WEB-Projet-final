-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 20 jan. 2023 à 17:13
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
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` tinyint NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Boissons'),
(2, 'Biscuits'),
(3, 'Fruits secs');

-- --------------------------------------------------------

--
-- Structure de la table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `forname` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `add1` varchar(50) NOT NULL,
  `add2` varchar(50) NOT NULL,
  `add3` varchar(50) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(150) NOT NULL,
  `registered` tinyint NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `customers`
--

INSERT INTO `customers` (`id`, `forname`, `surname`, `add1`, `add2`, `add3`, `postcode`, `phone`, `email`, `registered`) VALUES
(1, 'Sarah', 'Hamida', 'ligne add1', 'ligne add2', 'Meximieux', '01800', '0612345678', 's.hamida@gmail.com', 1),
(2, 'Jean-Benoît', 'Delaroche', 'ligne add1', 'ligne add2', 'Lyon', '69009', '0796321458', 'jb.delaroche@gmx.fr', 1);

-- --------------------------------------------------------

--
-- Structure de la table `delivery_addresses`
--

DROP TABLE IF EXISTS `delivery_addresses`;
CREATE TABLE IF NOT EXISTS `delivery_addresses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `forename` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `add1` varchar(50) NOT NULL,
  `add2` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(150) NOT NULL,
  `user_id` int NOT NULL,
  `previous_id` int DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `delivery_addresses`
--

INSERT INTO `delivery_addresses` (`id`, `forename`, `surname`, `add1`, `add2`, `city`, `postcode`, `phone`, `email`, `user_id`, `previous_id`, `active`) VALUES
(46, 'Christian', 'Hamid', '15 Rue de la paix', '', 'Saint Etienne', '1', '0477213145', 'chr.hamida@gmail.com', 1, NULL, 0),
(47, 'Sarahe', 'Hamidaa', 'ligne add1', 'ligne add2', 'Meximieux', '01800', '0612345678', 'sarah.hamida@gmail.com', 1, NULL, 0),
(48, 'Jean-Benoît', 'Delaroche', 'ligne add1', 'ligne add2', 'Lyon', '69009', '0796321458', 'jb.delaroche@gmx.fr', 1, NULL, 1),
(49, 'Louise', 'Delaroche', '12 avenue condorcet', 'étage 2', 'Saint Priest', '45097', '0526117898', 'louise.delaroche@yahoo.fr', 1, NULL, 1),
(50, 'thomas', 'thomas', 'grand piton', '', 'dax', '40100', '0613256393', 'thomas.halvick@gmail.com', 1, NULL, 0),
(56, 'Christian', 'Hamid', '15 Rue de la paix', '', 'Saint Etienne', '42000', '0477213144', 'chr.hamida@gmail.com', 1, 46, 1),
(57, 'Sarahe', 'Hamidaa', 'ligne add1', 'ligne add2', 'Meximieux', '01800', '0612345678', 'sarah.hamida@gmail.com', 1, 47, 1),
(64, 'test2', 'test2', 'add2.3', '', 'dax', '40100', '0613256393', 'thomas.halvick@etu.univ-lyon1.fr', 1, NULL, 0),
(65, 'test2', 'test2', 'add2.3.1', '', 'dax', '40100', '0613256393', 'thomas.halvick@etu.univ-lyon1.fr', 1, 64, 0),
(66, 'test', 'test', '1741', '145541857', 'DAX', '40100', '0613256393', 'thomas.halvick@gmail.com', 1, NULL, 1),
(67, 'dzqdzq', 'dzqdqz', 'dzqdqzd', 'zqdqzdqzdqz', 'dzqzdqz', '40100', '0612345679', 'dzdqz@dzdqz.dzqdzqdq', 1, NULL, 0),
(68, 'azdaz', 'dzad', 'zadazdaz', 'dadad', 'adad', '40100', '0477213144', 'thomas.halvick@gmail.com', 2, NULL, 1),
(70, 'toto38', 'isere', 'Rue de Lyon', '', 'Villeurbanne', '69100', '0875463322', 'toto38@gmail.com', 7, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `orderitems`
--

DROP TABLE IF EXISTS `orderitems`;
CREATE TABLE IF NOT EXISTS `orderitems` (
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`order_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `orderitems`
--

INSERT INTO `orderitems` (`order_id`, `product_id`, `quantity`) VALUES
(217, 13, 2),
(217, 26, 2),
(218, 9, 3),
(218, 13, 1),
(224, 5, 3),
(226, 14, 1),
(227, 14, 1),
(228, 24, 2),
(229, 17, 1),
(230, 19, 2),
(231, 18, 1),
(238, 22, 1),
(239, 8, 1),
(240, 16, 1),
(241, 17, 1),
(242, 26, 1),
(243, 10, 1),
(243, 23, 1),
(243, 27, 1),
(244, 22, 1),
(245, 25, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=249 DEFAULT CHARSET=utf8mb3;

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
(226, 7, 70, 'moneyCheck', NULL),
(227, 7, 70, 'moneyCheck', NULL),
(228, 7, 70, 'moneyCheck', NULL),
(229, 7, 70, 'moneyCheck', NULL),
(230, 7, 70, 'moneyCheck', NULL),
(231, 7, 70, 'moneyCheck', NULL),
(237, NULL, NULL, NULL, '5p91ms1hrrtfm2k41ofip5vc60'),
(238, 7, 70, 'moneyCheck', NULL),
(239, 7, NULL, NULL, 'sa7ipjahmttdb1et3n03gie0vr'),
(240, 7, 70, 'moneyCheck', NULL),
(241, 7, 70, 'moneyCheck', NULL),
(242, 7, 70, 'moneyCheck', NULL),
(243, 7, 70, 'moneyCheck', NULL),
(244, 7, 70, 'creditCard', NULL),
(245, 7, 70, 'paypal', NULL),
(248, 7, NULL, NULL, 'tl01151b0tmfbcqtomqgdrq0sq');

-- --------------------------------------------------------

--
-- Structure de la table `orderstatus`
--

DROP TABLE IF EXISTS `orderstatus`;
CREATE TABLE IF NOT EXISTS `orderstatus` (
  `order_id` int NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`order_id`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `orderstatus`
--

INSERT INTO `orderstatus` (`order_id`, `date`, `status`) VALUES
(217, '2023-01-17 20:15:13', 0),
(217, '2023-01-17 20:15:41', 1),
(217, '2023-01-17 20:15:44', 2),
(218, '2023-01-17 20:15:15', 0),
(218, '2023-01-17 20:15:16', 1),
(218, '2023-01-17 20:15:21', 2),
(218, '2023-01-17 20:15:21', 3),
(219, '2023-01-17 20:15:21', 0),
(219, '2023-01-17 20:16:58', 1),
(220, '2023-01-17 20:15:44', 0),
(224, '2023-01-18 20:11:50', 0),
(224, '2023-01-18 20:12:10', 1),
(224, '2023-01-18 20:15:26', 2),
(225, '2023-01-18 20:15:26', 0),
(226, '2023-01-18 21:40:31', 0),
(226, '2023-01-18 21:40:46', 1),
(226, '2023-01-18 21:41:05', 2),
(227, '2023-01-18 21:42:43', 0),
(227, '2023-01-18 21:58:29', 1),
(227, '2023-01-18 22:03:00', 2),
(228, '2023-01-18 22:05:55', 0),
(228, '2023-01-18 22:06:00', 1),
(228, '2023-01-18 22:06:09', 2),
(229, '2023-01-18 22:18:29', 0),
(229, '2023-01-18 22:18:44', 1),
(229, '2023-01-18 22:19:04', 2),
(230, '2023-01-18 22:27:45', 0),
(230, '2023-01-18 22:27:48', 1),
(230, '2023-01-18 22:27:55', 2),
(231, '2023-01-18 22:28:52', 0),
(231, '2023-01-18 22:28:56', 1),
(231, '2023-01-18 22:29:05', 2),
(237, '2023-01-19 00:41:19', 0),
(238, '2023-01-19 00:42:48', 0),
(238, '2023-01-19 00:42:54', 1),
(238, '2023-01-19 00:43:06', 2),
(239, '2023-01-19 00:43:56', 0),
(240, '2023-01-20 14:18:27', 0),
(240, '2023-01-20 14:19:41', 1),
(240, '2023-01-20 14:19:48', 2),
(241, '2023-01-20 14:23:56', 0),
(241, '2023-01-20 14:24:13', 1),
(241, '2023-01-20 14:24:21', 2),
(242, '2023-01-20 14:24:53', 0),
(242, '2023-01-20 14:24:54', 1),
(242, '2023-01-20 14:25:00', 2),
(243, '2023-01-20 14:27:03', 0),
(243, '2023-01-20 14:27:05', 1),
(243, '2023-01-20 14:27:12', 2),
(244, '2023-01-20 14:28:08', 0),
(244, '2023-01-20 14:28:10', 1),
(244, '2023-01-20 14:29:22', 2),
(244, '2023-01-20 14:29:22', 3),
(245, '2023-01-20 14:30:11', 0),
(245, '2023-01-20 14:30:13', 1),
(245, '2023-01-20 14:34:02', 2),
(245, '2023-01-20 14:34:03', 3),
(248, '2023-01-20 16:57:02', 0),
(248, '2023-01-20 16:58:20', 1);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `orderwithdata`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `orderwithdata`;
CREATE TABLE IF NOT EXISTS `orderwithdata` (
`id` int
,`user_id` int
,`delivery_add_id` int
,`payment_type` varchar(10)
,`session_id` varchar(255)
,`price` decimal(37,2)
,`delyveryAddress` json
,`orderitems` json
,`statusHistory` json
,`status` bigint
,`quantity` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cat_id` tinyint NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(30) NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `cat_id`, `name`, `description`, `image`, `price`, `quantity`) VALUES
(4, 2, 'Assortiment de biscuits secs', 'Boîte de 20 biscuits composée de galettes, cookies, crêpes dentelles et sablés', 'assortimentBiscuitsSecs.jpg', '12.90', 20),
(5, 2, 'Biscuits de Noël', 'De doux biscuits de Noël à la cannelle, au chocolat, et sablés pour assurer de belles et uniques fêtes de Noël', 'biscuitNoel.png', '10.50', 20),
(6, 2, 'Biscuits aux raisins ', 'De délicieux biscuits aux raisins secs pour éveiller les sens de toute la famille, des plus petits aux plus grands !', 'biscuitRaisin.jpeg', '6.90', 2),
(7, 3, 'Pruneaux secs bio ', 'Sachet de 500g. De délicieux pruneaux issus d agricultures biologiques et responsables ', 'pruneauxSecs.jpg', '7.90', 6),
(8, 3, 'Sachet d\'abricots secs ', 'Sachet d\'un kilogramme. Produit recommandé par de nombreux nutritionnistes. Authentique goût d\'abricot', 'abricotsSecs.jpg', '15.50', 17),
(9, 3, 'Plateau de fruits secs ', 'Plateau de 1kg composé d\'abricots secs, de noix de cajous, pruneaux secs, bananes sèches, copeaux de noix de coco...', 'plateauFruitsSecs.jpg', '32.00', 6),
(10, 3, 'Mélange de fruits secs', 'Composés de différents sachets de 250g : des marrons, des cacahouètes, des amandes grillés et des noisettes.', 'melangeMarrons.jpg', '25.00', 6),
(11, 3, 'Mélange de noisettes', 'Sachet de 500g composé de noisettes, noix et amandes grillées. Une fois goûtés, on ne peut plus s\'en passer', 'melangeNoisettes.png', '8.30', 4),
(12, 3, 'Sachet d\'amandes grillées', 'Sachet de 500g, grillées lentement au four pour plus de plaisir en bouche lors de la dégustation !', 'amandes.jpg', '9.90', 10),
(13, 1, 'Jus de citron', 'Bouteille d\'un litre de jus de citron frais issus d\'agricultures responsables et biologiques', 'jusCitron.jpg', '15.20', 3),
(14, 1, 'Jus de pommes', 'Pommes issues d\'agricultures biologiques.\r\nBouteille d\'un litre dans une bouteille en verre ', 'jusPomme.jpg', '3.20', 6),
(15, 1, 'Jus de pamplemousse', 'Bouteille d\'un litre et demi sans sucre et sans colorant ajoutés. 100% naturel au bon goût de pamplemousse', 'jusPamplemousse.jpg', '7.30', 7),
(16, 1, 'Jus d\'orange', 'Oranges provenant d\'agricultures locales et biologiques.\r\nCette bouteille d\'un litre permet de se réveiller en douceur le matin.', 'jusOrange.jpg', '4.60', 18),
(17, 1, 'Sachet de café en grain', 'sachet d\'un kilogramme de café en grain, pour garder l\'authentique goût du café pour bien commencer la journée', 'cafeGrain.jpg', '15.00', 8),
(18, 1, 'Capsules de café', 'Paquet de 50 capsules. Adaptable pour toute sortes de machines à café avec capsules', 'cafeCapsule.jpg', '45.00', 10),
(19, 1, 'Dosettes de café', 'Paquet de 30 dosettes de café. Longue date de conservation. Emballage recyclable respectant l\'environnement', 'dosetteCafe.png', '28.10', 18),
(20, 1, 'Sachets de thé à la canelle', '15 sachets à l\'authentique gout de thé à la cannelle. Nouveauté chez Web4Shop ! ', 'theCannelle.jpg', '10.50', 9),
(21, 1, 'Infusion à la verveine', 'Recommandé pour profiter de nuits calmes.\r\nVendus par paquet de 15 sachets.', 'infusionVerveine.jpg', '8.90', 4),
(22, 1, 'Thé vert', '20 sachets de thé vert. Les adeptes en raffolent et on comprend bien pourquoi ! ', 'theVert.jpg', '13.90', 11),
(23, 1, 'Infusion au citron', 'Paquet de 20 sachets d\'infusion au citron pour partager un moment unique avec les plus petits ou les plus grands', 'infusionCitron.jpg', '15.30', 14),
(24, 2, 'Macarons tout chocolat', 'Macarons uniques au chocolat. Vendus par 10 macarons dans une très belle boîte ', 'macaronChocolat.jpg', '20.50', 16),
(25, 2, 'Boules de neige', 'Boules aromatisées à la noix de coco.\r\nPlateau de 200g. Idée cadeau qui va plaire aux adeptes de la noix de coco !', 'bouleDeNeigeCoco.jpg', '10.80', 7),
(26, 2, 'Cookies au pépites de chocolat', 'Cookies croquants préparés avec de l\'avoine et des pépites de chocolat fondantes.\r\nPaquet de 15 cookies', 'cookiesChocolat.jpg', '12.30', 9),
(27, 2, 'Biscuits étoile à la cannelle', 'Biscuits secs pour noël à l\'authentique goût de la cannelle. L\'éveil des sens avec ces saveurs est assuré !', 'biscuitsCannelle.jpg', '13.50', 13),
(28, 2, 'Biscuits en forme de tortue', 'Paquet de 20 petits biscuits en forme de tortue. Goût chocolat vanille. Leur très jolie forme va séduire tout le monde !', 'biscuitsTortue.jpg', '25.30', 20);

-- --------------------------------------------------------

--
-- Structure de la table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `product_id` int NOT NULL,
  `stars` int NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `user_id` int NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`product_id`,`user_id`),
  KEY `review/product` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `reviews`
--

INSERT INTO `reviews` (`product_id`, `stars`, `title`, `description`, `user_id`, `date`) VALUES
(4, 3, 'J\'adore', 'très bon produit; sans additif donc très naturel; à essayer sans hésiter! pas ouf quand memetrès bon produit; sans additif donc très naturel; à essayer sans hésiter! pas ouf quand memetrès bon produit; sans additif donc très naturel; à essayer sans hasiaz', 1, '2023-01-12 16:32:31'),
(4, 5, 'Excellent !', 'Ils sont trop bons, je recommande vraiment ces biscuits secs, je ne peux plus m\'en passer ! ', 2, '2023-01-10 20:03:05'),
(5, 4, 'Original', 'Ces biscuits sont excellents; testés récemment! un délice!', 1, '2023-01-10 20:03:05'),
(5, 5, 'de fou', 'FOFOFOFOFOFOF', 6, '2023-01-18 20:00:08'),
(6, 4, 'une tuerie!', 'les biscuits sont vraiment très bons; très garnis; à tester sans modération!', 1, '2023-01-10 20:03:05'),
(6, 3, 'De très bons biscuits ', 'Vraiment trop bon !! ', 2, '2023-01-10 20:03:05'),
(7, 5, 'avant l\'effort', 'des pruneaux d\'un gros calibre; idéal avant une activité sportive ou simplement en cas de petite faim! je recommande!', 1, '2023-01-10 20:03:05'),
(7, 4, 'Une qualité inégalable', 'Les pruneaux sont vraiment excellents je recommande', 2, '2023-01-10 20:03:05'),
(8, 5, 'miam', 'Parfait pour commencer la journée: ces abricots sont excellents; le prix est raisonnable. Je recommande ce produit', 1, '2023-01-10 20:03:05'),
(9, 5, 'idée cadeau', 'ce plateau très garni et excellent est une très bonne idée cadeau; à savourer sans modération ; je vous invite à essayer!', 1, '2023-01-10 20:03:05'),
(10, 4, 'à conseiller', 'un mélange idéal pour le petit déjeuner ou avant l\'effort; les amandes et les noisettes sont excellentes; je recommande', 1, '2023-01-10 20:03:05'),
(11, 4, 'exquis!', 'des fruits secs de bonne qualité; je recommande ce produit sans hésiter', 1, '2023-01-10 20:03:05'),
(11, 4, 'Trop bon et livraison rapide', 'Ces fruits secs sont vraiment à croquer, et ils sont très vite virés à la maison ', 2, '2023-01-10 20:03:05'),
(12, 3, 'très bon produit', 'je recommande ces amandes grillées; elles sont grillées à point et complètent agréablement une recette; à essayer!', 1, '2023-01-10 20:03:05'),
(12, 3, 'Trop bon ! ', 'Les amandes sont vraiment bonnes, le paquet ne fait pas longtemps à la maison ! je recommande ', 2, '2023-01-10 20:03:05'),
(13, 1, '......', 'Tout simplement médiocre', 1, '2023-01-17 18:48:21'),
(13, 1, 'super nullll', 'cool', 2, '2023-01-10 22:51:13'),
(13, 5, 'insert 1', 'descr 1', 3, '2023-01-10 20:56:58'),
(14, 1, '.....', 'je ne m\'attendais à rien et je suis quand même déçu', 1, '2023-01-14 16:49:54'),
(15, 2, 'désaltérant', 'très bon produit; sans additif donc très naturel; à essayer sans hésiter! pas ouf quand meme\r\n', 1, '2023-01-10 21:03:37'),
(15, 5, 'Tellement bon !!', 'Je recommande vivement, j\'achète toujours ce bon jus et il fait l\'unanimité à la maison', 2, '2023-01-10 20:03:05'),
(16, 5, 'Mais c\'est de la merde', 'A ne pas consommer', 1, '2023-01-10 22:43:03'),
(16, 5, 'Tellement bon ! ', 'Ce jus est incroyablement bon c\'est un plaisir de déjeuner le matin avec un jus d\'orange si frais ', 2, '2023-01-10 20:03:05'),
(17, 5, 'à essayer', 'un café doux et savoureux dans un emballage de qualité. le prix est raisonnable; je recommande!', 1, '2023-01-10 20:03:05'),
(18, 5, 'très bien', 'des capsules de très bonne qualité; très bon rapport qualité prix; je recommande ce produit', 1, '2023-01-10 20:03:05'),
(19, 5, 'Oui', 'pas ouf mais cool', 1, '2023-01-10 21:43:11'),
(20, 3, 'bon', 'un produit de qualité; ce thé est parfumé et on apprécie le gout délicat de la cannelle; je vous le recommande.', 1, '2023-01-10 20:03:05'),
(22, 5, 'délicieux', 'une boisson très parfumée; idéale pour bien démarrer la journée; à essayer les yeux fermés.', 1, '2023-01-10 20:03:05'),
(22, 4, 'Juste parfait', 'Le bon plan pour roupiller après manger, en plus c\'est bon pour l\'organisme\r\nAbsolument ravi !!!', 7, '2023-01-20 18:11:30'),
(23, 5, 'bon produit', 'Une infusion excellente pour la digestion. Un gout acidulé et un très bon rapport qualité prix. Je recommande ce produit', 1, '2023-01-10 20:03:05'),
(23, 3, 'Je suis fan', 'Moi qui suis fan d\'infusion, c\'est vraiment de la qualité ! peut être un peu cher mais vraiment le prix a payer pour bénéficier de si bonnes infusions', 2, '2023-01-10 20:03:05'),
(24, 4, 'savoureux', 'des macarons au top; un produit qui est de très bonne qualité; tendre et fondant dans la bouche; à consommer sans modération\r\n', 1, '2023-01-10 20:03:05'),
(24, 4, 'Vraiment excellent ', 'Je recommande vivement ces macarons, ils ont un gout authentiques et en plus ils ne sont pas très chers ', 2, '2023-01-10 20:03:05'),
(24, 5, 'Le top du top', 'Excellent ! Le meilleur pâtissier de France 2023 n\'a qu\'à raccrocher son tablier !', 7, '2023-01-19 01:32:05'),
(25, 3, 'bon', 'Des biscuits assez parfumés, tendre et sucrés juste ce qu\'il faut. bon produit', 1, '2023-01-10 20:03:05'),
(25, 4, 'Bon goût de noix de coco', 'Vraiment bon, pour les fêtes de Noël, chaque années elles sont très appréciées', 2, '2023-01-10 20:03:05'),
(26, 5, 'comme à la maison', 'excellents biscuits; aussi bons que ceux que l\'on fait soi même!', 1, '2023-01-10 20:03:05'),
(26, 4, 'Très bon rapport qualité prix', 'Ils sont vraiment excellents. Je ne sais pas cuisiner alors je les achète et on dirait vraiment des cookies faits maison !', 2, '2023-01-10 20:03:05'),
(26, 3, 'Je recommande !', 'Vraiment bons et très craquants, j\'en rachèterai ', 3, '2023-01-10 20:03:05'),
(26, 5, 'Cook these cookies', 'Je n\'ai jamais goûter d\'aussi bon cookies\r\nOn en devient vite addict', 7, '2023-01-20 18:09:48'),
(27, 5, 'un délice', 'des biscuits très parfumés qui rappellent les biscuits de mon enfance avec ce bon parfum de cannelle! Je vous le recommande...', 1, '2023-01-10 20:03:05'),
(28, 5, 'original!', 'si vous voulez opter pour des biscuits Originaux, vous ne serez pas déçus! et en plus, ils sont bons!', 1, '2023-01-10 20:03:05'),
(28, 5, 'Trop top', 'Trop beau et trop bon ', 2, '2023-01-10 20:03:05');

-- --------------------------------------------------------

--
-- Structure de la table `session`
--

DROP TABLE IF EXISTS `session`;
CREATE TABLE IF NOT EXISTS `session` (
  `id` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `expires` datetime NOT NULL,
  `data` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `session`
--

INSERT INTO `session` (`id`, `expires`, `data`) VALUES
('5p91ms1hrrtfm2k41ofip5vc60', '2023-01-19 00:46:19', 'cached|O:6:\"Cached\":1:{s:4:\"list\";a:0:{}}'),
('5tdm71cgj9h84edvel55rokldj', '2023-01-17 20:22:03', 'cached|O:6:\"Cached\":1:{s:4:\"list\";a:0:{}}User|O:4:\"User\":7:{s:8:\"\0User\0id\";i:2;s:14:\"\0User\0username\";s:5:\"admin\";s:14:\"\0User\0password\";s:60:\"$2y$10$dsy4kS3wcWjJkt0rzn5TJOdHbKzadF9fsuSP8aHUARhfMzAj1/9O6\";s:11:\"\0User\0admin\";b:1;s:11:\"\0User\0image\";s:9:\"homme.jpg\";s:23:\"\0User\0deliveryAddresses\";N;s:12:\"\0User\0orders\";N;}'),
('pclilbas10ovo6g00tbd0r2o6d', '2023-01-17 20:22:09', 'cached|O:6:\"Cached\":1:{s:4:\"list\";a:0:{}}User|O:4:\"User\":7:{s:8:\"\0User\0id\";i:1;s:14:\"\0User\0username\";s:6:\"thomas\";s:14:\"\0User\0password\";s:60:\"$2y$10$dsy4kS3wcWjJkt0rzn5TJOdHbKzadF9fsuSP8aHUARhfMzAj1/9O6\";s:11:\"\0User\0admin\";b:0;s:11:\"\0User\0image\";s:9:\"shrek.jpg\";s:23:\"\0User\0deliveryAddresses\";N;s:12:\"\0User\0orders\";N;}'),
('qs85u5g5oq3st1qjf3qvafjvcs', '2023-01-18 20:20:26', 'cached|O:6:\"Cached\":1:{s:4:\"list\";a:0:{}}User|O:4:\"User\":7:{s:8:\"\0User\0id\";i:1;s:14:\"\0User\0username\";s:6:\"thomas\";s:14:\"\0User\0password\";s:60:\"$2y$10$dsy4kS3wcWjJkt0rzn5TJOdHbKzadF9fsuSP8aHUARhfMzAj1/9O6\";s:11:\"\0User\0admin\";b:0;s:11:\"\0User\0image\";s:9:\"shrek.jpg\";s:23:\"\0User\0deliveryAddresses\";N;s:12:\"\0User\0orders\";N;}'),
('sa7ipjahmttdb1et3n03gie0vr', '2023-01-19 00:48:56', 'cached|O:6:\"Cached\":1:{s:4:\"list\";a:0:{}}User|O:4:\"User\":7:{s:8:\"\0User\0id\";i:7;s:14:\"\0User\0username\";s:7:\"tblumet\";s:14:\"\0User\0password\";s:60:\"$2y$10$tEUUqlb19fCV05iYfkvYiOjgwdryNGKnWsr.6/9ze3H/4rSl/mld6\";s:11:\"\0User\0admin\";b:0;s:11:\"\0User\0image\";s:9:\"homme.jpg\";s:23:\"\0User\0deliveryAddresses\";N;s:12:\"\0User\0orders\";N;}'),
('tl01151b0tmfbcqtomqgdrq0sq', '2023-01-20 17:16:45', 'cached|O:6:\"Cached\":1:{s:4:\"list\";a:0:{}}User|O:4:\"User\":7:{s:8:\"\0User\0id\";i:7;s:14:\"\0User\0username\";s:7:\"tblumet\";s:14:\"\0User\0password\";s:60:\"$2y$10$tEUUqlb19fCV05iYfkvYiOjgwdryNGKnWsr.6/9ze3H/4rSl/mld6\";s:11:\"\0User\0admin\";b:0;s:11:\"\0User\0image\";s:9:\"homme.jpg\";s:23:\"\0User\0deliveryAddresses\";N;s:12:\"\0User\0orders\";N;}');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(64) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `image` varchar(32) NOT NULL DEFAULT 'homme.jpg',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `admin`, `image`) VALUES
(1, 'thomas', '$2y$10$dsy4kS3wcWjJkt0rzn5TJOdHbKzadF9fsuSP8aHUARhfMzAj1/9O6', 0, 'shrek.jpg'),
(2, 'admin', '$2y$10$dsy4kS3wcWjJkt0rzn5TJOdHbKzadF9fsuSP8aHUARhfMzAj1/9O6', 1, 'homme.jpg'),
(3, 'Jean claude', 'rgfsdgnjgjdjdfhfkhfkhfkh', 0, 'homme.jpg'),
(4, 'yoyo', '$2y$10$I836ViPGV1Fj2ifacZMK3uVQ4jsKyJeljXAq7Kwy.K.XVnmKx/7Me', 0, 'homme.jpg'),
(5, 'thomas', '$2y$10$6.9L23BLQ4nPidfwq6CwUu98Inxhp2oIcgxJmjipQwUcyTLLqqXHi', 0, 'homme.jpg'),
(6, 'toto', '$2y$10$h65tWD6IKqX733NXJc8f2./cLomJJ5i4.6trk1kWabjhuKt62.h3S', 0, 'homme.jpg'),
(7, 'tblumet', '$2y$10$tEUUqlb19fCV05iYfkvYiOjgwdryNGKnWsr.6/9ze3H/4rSl/mld6', 0, 'homme.jpg'),
(8, 'Philippe', '$2y$10$MDqcy5mehSZlqXb.US9Hxe8pon0Wt86l8a5G9gp.EPW0MFaN3f3ZW', 0, 'homme.jpg');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `viewproduct`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `viewproduct`;
CREATE TABLE IF NOT EXISTS `viewproduct` (
`id` int
,`cat_id` tinyint
,`name` varchar(150)
,`description` text
,`image` varchar(30)
,`price` decimal(5,2)
,`quantity` int
,`quantity_remaining` decimal(33,0)
);

-- --------------------------------------------------------

--
-- Structure de la vue `orderwithdata`
--
DROP TABLE IF EXISTS `orderwithdata`;

DROP VIEW IF EXISTS `orderwithdata`;
CREATE VIEW orderWithData AS
    SELECT 
            o.*,
            ( SELECT 
                sum(price*oi.quantity)
                FROM products p join orderitems oi
                on p.id = oi.product_id
                where oi.order_id = o.id
            ) as price,
            ( SELECT 
                JSON_OBJECT(
                    'id', d.id,
                    'forename', d.forename,
                    'surname', d.surname,
                    'add1', d.add1,
                    'add2', d.add2,
                    'city', d.city,
                    'postcode', d.postcode,
                    'phone', d.phone,
                    'email', d.email,
                    'user_id', d.user_id,
                    'previous_id', d.previous_id
                    ) 
                FROM delivery_addresses d
                where o.delivery_add_id = d.id
            ) as delyveryAddress,  
            (
                SELECT 
                    JSON_ARRAYAGG(
                        JSON_OBJECT(
                            'order_id',oi.order_id,
                            'product_id',oi.product_id,
                            'quantity',oi.quantity,
                            'product', JSON_OBJECT(
                                    'id',p.id,
                                    'cat_id',p.cat_id,
                                    'name',p.name,
                                    'description',p.description,
                                    'image',p.image,
                                    'price',p.price,
                                    'quantity',p.quantity,
                                    'quantity_remaining',p.quantity_remaining
                                ) 
                        ) 
                    ) 
                FROM  orderitems oi 
                join viewProduct p on  p.id = oi.product_id 
                where o.id = oi.order_id
            ) as orderitems,
            (
                SELECT 
                    JSON_ARRAYAGG(
                        JSON_OBJECT(
                            'status',os.status,
                            'order_id',os.order_id,
                            'date',os.date
                        )
                    ) 
                FROM orderStatus os 
                where o.id = os.order_id  
            ) as statusHistory,
            (
                SELECT 
                    os.status
                FROM orderStatus os 
            where o.id= os.order_id  
            and date = (   
                SELECT 
                    Max(date)
                FROM orderStatus os  
                where o.id= os.order_id 
                ) ORDER BY status DESC LIMIT 1
            ) as status,
            IFNULL((
                SELECT SUM(quantity) FROM orderitems oi where oi.order_id=o.id
            ),0) as quantity
            FROM orders o
            order by id desc;
-- --------------------------------------------------------

--
-- Structure de la vue `viewproduct`
--
DROP TABLE IF EXISTS `viewproduct`;

DROP VIEW IF EXISTS `viewproduct`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewproduct`  AS   with `orderedproduct` as (select `oi`.`product_id` AS `product_id`,sum(`oi`.`quantity`) AS `quantity` from (`orders` `o` join `orderitems` `oi` on((`o`.`id` = `oi`.`order_id`))) where `o`.`id` in (select `orderstatus`.`order_id` from `orderstatus` where (`orderstatus`.`status` > 1)) is false group by `oi`.`product_id`) select `products`.`id` AS `id`,`products`.`cat_id` AS `cat_id`,`products`.`name` AS `name`,`products`.`description` AS `description`,`products`.`image` AS `image`,`products`.`price` AS `price`,`products`.`quantity` AS `quantity`,(`products`.`quantity` - (select ifnull(max(`orderedproduct`.`quantity`),0) from `orderedproduct` where (`orderedproduct`.`product_id` = `products`.`id`))) AS `quantity_remaining` from `products`  ;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `orderitems`
--
ALTER TABLE `orderitems`
  ADD CONSTRAINT `orderitems_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Contraintes pour la table `orderstatus`
--
ALTER TABLE `orderstatus`
  ADD CONSTRAINT `orderstatus_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
