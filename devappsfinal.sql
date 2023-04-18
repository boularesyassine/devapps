-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2023 at 05:29 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `devappsfinal`
--

-- --------------------------------------------------------

--
-- Table structure for table `appel_offre`
--

CREATE TABLE `appel_offre` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `quantite` int(11) NOT NULL,
  `budget` float NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `id_utilisateur_id` int(11) DEFAULT NULL,
  `id_categorie_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `appel_offre`
--

INSERT INTO `appel_offre` (`id`, `nom`, `quantite`, `budget`, `description`, `date`, `id_utilisateur_id`, `id_categorie_id`) VALUES
(8, 'Pc acer', 60, 200000, '7i RAM 16 Windows 11', '2023-02-16', 1, 1),
(27, 'projecteur', 100, 500000, 'nouuuv', '2023-03-07', 1, 1),
(28, 'jklm', 233, 13.25, 'nouv', '2023-03-07', 1, 1),
(29, 'aa', 20, 20, 'dd', '2023-03-07', 1, 1),
(30, 'dd', 1, 1, 'ff', '2023-03-07', 1, 1),
(31, 'ddd', 2, 2, 'dd', '2023-03-08', 1, 1),
(32, 'ddd', 1, 1, 'ddd', '2023-03-08', 1, 1),
(33, 'gggg', 600, 12000, 'desccc', '2023-03-08', 1, 1),
(34, 'gggg', 600, 12000, 'desccc', '2023-03-08', 1, 1),
(35, 'ddd', 20, 2000, 'dadadadadada', '2023-03-08', 1, 1),
(36, 'ddd', 20, 2000, 'dadadadadada', '2023-03-08', 1, 1),
(37, 'ddd', 20, 20000, 'dadadadadada', '2023-03-09', 175, 3),
(38, 'ddd', 20000, 2000, 'dadadadadada', '2023-03-09', 175, 3),
(39, 'ddddd', 2000, 2000, 'dadadadadada', '2023-03-09', 175, 3),
(40, 'ddd', 20, 2000, 'ddddddddddd', '2023-03-09', 162, 3),
(41, 'ddddd', 2000, 20000, 'dadadadadada', '2023-03-09', 175, 3),
(42, 'Projecteur', 12, 20000, 'nouveau epson', '2023-03-09', 175, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`id`, `nom`) VALUES
(1, 'technologiques'),
(3, 'bureautiquessss'),
(22, 'meubles'),
(26, 'techno');

-- --------------------------------------------------------

--
-- Table structure for table `demande`
--

CREATE TABLE `demande` (
  `id` int(11) NOT NULL,
  `idutilisateur` int(11) NOT NULL,
  `idproduit` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `demande`
--

INSERT INTO `demande` (`id`, `idutilisateur`, `idproduit`, `date`) VALUES
(1, 1, 21, '2023-03-04'),
(2, 1, 21, '2023-03-04'),
(3, 1, 21, '2023-03-08');

-- --------------------------------------------------------

--
-- Table structure for table `facture`
--

CREATE TABLE `facture` (
  `id_facture` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prix` float NOT NULL,
  `date` date NOT NULL,
  `etat` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `facture`
--

INSERT INTO `facture` (`id_facture`, `numero`, `nom`, `prix`, `date`, `etat`, `description`, `image`, `id_utilisateur`) VALUES
(21, 21, 'SSDS', 23, '2023-02-21', '0', 'kfmslmflsdm', 'dd', 1),
(25, 2021, 'aasasas', 20, '2018-01-01', 'good', 'dadaadad', 'd88f03d03ddaf2bba30676d45e102b62.png', 1),
(28, 20, 'sasasa', 2, '2018-01-01', 'assas', 'sasasasasas', '95bd50fc03bd906009568d7236dff67e.png', 1),
(30, 12, 'GTGTG', 20, '2023-03-07', '0', 'GTGT', 'ddd', 1),
(32, 20, 'asaa', 20, '2023-03-07', 'aa', 'zzz', 'zz', 1),
(35, 225, 'fac1', 50, '2023-03-07', 'etat2', 'desc2', 'img2', 1),
(37, 20, 'dd', 20, '2023-03-08', 'dd', 'dd', 'dd', 1);

-- --------------------------------------------------------

--
-- Table structure for table `favorie`
--

CREATE TABLE `favorie` (
  `id` int(11) NOT NULL,
  `idutilisateur` int(11) NOT NULL,
  `idproduit` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `favorie`
--

INSERT INTO `favorie` (`id`, `idutilisateur`, `idproduit`, `date`) VALUES
(1, 1, 21, '2023-03-04'),
(2, 1, 21, '2023-03-04'),
(3, 1, 21, '2023-03-07'),
(4, 1, 21, '2023-03-07'),
(5, 1, 66, '2023-03-09'),
(6, 175, 21, '2023-03-09'),
(7, 175, 21, '2023-03-09'),
(8, 175, 81, '2023-03-09');

-- --------------------------------------------------------

--
-- Table structure for table `finance`
--

CREATE TABLE `finance` (
  `id` int(11) NOT NULL,
  `taxe` float NOT NULL,
  `tva` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `prix` float NOT NULL,
  `etat` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `id_facture` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `finance`
--

INSERT INTO `finance` (`id`, `taxe`, `tva`, `photo`, `prix`, `etat`, `date`, `id_facture`) VALUES
(2, 10, 44, '20', 10, 'paid', '2018-01-01', 21),
(3, 120, 20, 'adda', 203, 'payee', '2025-01-01', 21),
(14, 22, 10, 'hhh', 20, 'fgjh', '2023-03-07', 21),
(16, 2, 20, 'aa', 20, 'aa', '2023-03-07', 21),
(18, 5, 55, 'fdq', 0, 'qdfsk', '2023-03-08', 35),
(19, 20, 20, 'dd', 20, 'dd', '2023-03-08', 32),
(20, 12, 12, 'ddd', 20, 'dd', '2023-03-08', 21),
(21, 20, 225555, 'dadada', 50, 'eeee', '2018-01-01', 21),
(25, 10, 44, '20', 10, 'paid', '3899-11-30', 21),
(26, 10, 44, '20', 10, 'paid', '3899-11-30', 21);

-- --------------------------------------------------------

--
-- Table structure for table `produit`
--

CREATE TABLE `produit` (
  `id_produit` int(11) NOT NULL,
  `nom_produit` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `prix` float NOT NULL,
  `quantite` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `date` date DEFAULT current_timestamp(),
  `id_categorie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produit`
--

INSERT INTO `produit` (`id_produit`, `nom_produit`, `description`, `prix`, `quantite`, `photo`, `date`, `id_categorie_id`) VALUES
(21, 'chaise', 'chaise pour bureau', 200, 100, 'd471b1594d87ca90bd934bf597a60220.jpg', '2023-02-23', 22),
(66, 'pc', ' pc portable', 14, 100, 'aaa', '2023-03-08', 3),
(79, 'chaise', 'chaise de bureau', 200, 100, 'e46656d9e28bebd71e2572a748f8f163.jpg', '2023-03-09', 22),
(80, 'pc potable', 'pc portable', 400, 101, 'e0e566e0484f505f99ca4d253e598a73.jpg', '2023-03-09', 1),
(81, 'projecteur', 'projecteur techno', 400, 150, '8701d819b88c09bc9747a69df4d266e4.jpg', '2023-03-09', 26);

-- --------------------------------------------------------

--
-- Table structure for table `publicite`
--

CREATE TABLE `publicite` (
  `id` int(11) NOT NULL,
  `nom_pub` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `id_sponsor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `publicite`
--

INSERT INTO `publicite` (`id`, `nom_pub`, `description`, `image`, `id_sponsor_id`) VALUES
(17, 'Ooredoo', 'Ooreedoo Tunisie', 'oord.png', 6),
(18, 'dDDA', 'd', 'c1873df109885e71895c579df6bd93ad.png', 1),
(19, 'Telecom', 'd', '399795202eaa7f50a4da603ac0e98837.jpg', 1),
(30, 'esprit', 'Esprit School', 'Es', 14),
(36, 'ddd', 'ddd', '9d9fed58ffc4d7a9f2047ced81f11463.png', 6),
(39, 'Fendi', 'Fendi clothes brand', '35a3c621e270b820c34b91635f05a213.jpg', 1),
(40, 'Adidas', 'Adidas clothes brand', '8f068203ca1965710a31046b6edc4fa9.jpg', 1),
(41, 'Gucci', 'Gucci clothes brand', '5b7868084e6b8356fe8a7e7349804773.jpg', 1),
(42, 'Louis vuitton', 'Louis vuitton clothes brand', '8dbf29ac4e0f19bd63ca7435790f900e.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `idpub` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`id`, `rate`, `iduser`, `idpub`) VALUES
(15, 3, 1, 17),
(17, 1, 1, 18),
(18, 5, 1, 17),
(19, 5, 1, 18),
(20, 5, 1, 18),
(21, 5, 1, 18),
(22, 4, 1, 36),
(23, 3, 1, 17),
(24, 5, 1, 17),
(25, 2, 1, 30),
(26, 2, 175, 36),
(27, 3, 175, 30),
(28, 3, 175, 30),
(29, 5, 175, 17);

-- --------------------------------------------------------

--
-- Table structure for table `reclamation`
--

CREATE TABLE `reclamation` (
  `id_rec` int(11) NOT NULL,
  `sujet` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `etat` varchar(255) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `id_utilisateur_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reclamation`
--

INSERT INTO `reclamation` (`id_rec`, `sujet`, `email`, `description`, `etat`, `date`, `id_utilisateur_id`) VALUES
(49, 'hello', 'hello', 'hello', 'hello', '1970-01-01', 1),
(52, 'cccc', 'cccc', 'je ne peux pas accéder au services pup', 'traité', '1970-01-01', 1),
(54, 'bbbdd', 'bbbdd', 'je ne peux pas accéder au services pup', 'bb', '2023-03-04', 1),
(55, 'bbb', 'bbb', 'je ne peux pas accéder au services pup', 'bb', '2023-03-04', 1),
(56, 'bbb', 'bbb', 'je ne peux pas accéder au services pup', 'bb', '2023-03-04', 1),
(62, '', 'null', '', '', '2023-03-07', 1),
(63, 'dada', 'dada', 'dada', 'dada', '2023-03-07', 1),
(64, 'DDDDDD', 'mohamedabdelkebir15@gmail.com', 'hahahhaa', 'traité', '2023-03-07', 1),
(65, 'AAAAAAAAAAAA', 'mohamedabdelkebir15@gmail.com', 'Aaaaa20Aaaaa20', 'traité', '2023-03-07', 1),
(66, 'SSSSSSS', 'iheb.zaidi@esprit.tn', 'J\'ai pas trouver le même produit', 'traité', '2023-03-07', 1),
(67, 'WWWWW', 'Jihed.gh@gmail.com', 'mon compte  n\'est pas à jour', 'en cours', '2023-03-07', 1),
(68, 'XXXXXXXX', 'XXXXXXXX', 'gghg', 'en cours', '2018-03-07', 1),
(69, 'ddd', 'null', 'ddd', 'dd', '2018-03-07', 1),
(70, 'ddd', 'null', 'dd', 'dd', '2018-03-08', 1),
(71, 'dd', 'null', 'dd', 'dd', '2023-03-08', 1),
(72, 'dfdfd', 'null', 'fdfd', 'ffffff', '2023-03-08', 1),
(73, 'dd', 'null', 'dd', 'dd', '2023-03-08', 1),
(74, 'dddd', 'null', 'dd', 'dd', '2023-03-08', 1),
(75, 'dd', 'null', 'dd', 'dd', '2023-03-08', 1),
(76, 'hhhhhh', 'null', 'sssd', 'ddddde', '2023-03-08', 1),
(77, 'hhhhhh', 'null', 'sssd', 'ddddde', '2023-03-08', 1),
(78, 'yyyyy', 'null', 'yyyyy', 'yyyyy', '2023-03-08', 1),
(79, 'kjkj,lm', 'null', 'jkklkl', 'fff', '2023-03-08', 1),
(80, 'aaaa', 'null', 'aaa', 'aaa', '2023-03-08', 1),
(81, 'AAAAAA', 'mohamedabdelkebir15@gmail.com', 'Aaaaa20Aaaaa20', 'en cours', '2023-03-08', 1),
(82, 'AAAAAA', 'mohamedabdelkebir15@gmail.com', 'Aaaaa20Aaaaa20', 'traité', '2023-03-08', 1),
(83, 'AAAAAA', 'mohamedabdelkebir15@gmail.com', 'Yyyyyyyyyyyyyyyyyy', 'en cours', '2023-03-09', 175),
(84, 'AAAAAA', 'mohamedabdelkebir15@gmail.com', 'Aaaaa20Aaaaa20', 'en cours', '2023-03-09', 175),
(85, 'AAAAAA', 'mohamedabdelkebir15@gmail.com', 'Aaaaa20Aaaaa20', 'en cours', '2023-03-09', 175),
(86, 'AAAAAA', 'mohamedabdelkebir15@gmail.com', 'Aaaaa20Aaaaa20', 'traité', '2023-03-09', 175),
(87, 'COMPTE', 'iheb.zaidi@esprit.tn', 'mon compte  n\'est pas à jour', 'en cours', '2023-03-09', 175),
(88, 'AAAAAA', 'iheb.zaidi@esprit.tn', 'traitéffffff', 'en cours', '2023-03-09', 175),
(89, 'COMPTE', 'iheb.zaidi@esprit.tn', 'traitéffffff', 'en cours', '2023-03-09', 175),
(90, 'AAAAAA', 'iheb.zaidi@esprit.tn', 'traitébbbbbbb', 'traité', '2023-03-09', 175),
(91, 'COMPTE', 'Jihed.gh@gmail.com', 'Yyyyyyyyyyyyyyyyyy', 'en cours', '2023-03-09', 175),
(92, 'romanaa', 'romanaA', 'romanaa', 'romanaa', '2023-04-10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reponse_offre`
--

CREATE TABLE `reponse_offre` (
  `id` int(11) NOT NULL,
  `nom_produit` varchar(255) NOT NULL,
  `budget` float NOT NULL,
  `Etat` varchar(255) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `id_offre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reponse_offre`
--

INSERT INTO `reponse_offre` (`id`, `nom_produit`, `budget`, `Etat`, `date`, `id_offre`) VALUES
(16, 'hhhhh', 0, '222', '2023-03-07', 8),
(26, 'dd', 22, 'dd', '2023-03-07', 8),
(27, 'ddd', 20, 'ddd', '2023-03-07', 8),
(28, 'ddd', 20, 'dd', '2023-03-07', 8),
(29, 'd', 20, 'dd', '2023-03-07', 28),
(31, 'ddd', 2, 'dd', '2023-03-08', 29),
(32, 'Pc acer', 20, 'good', '2023-03-08', 8),
(33, 'Pc acer', 20, 'good', '2023-03-08', 8),
(34, 'Pc acer', 20, 'good', '2023-03-09', 8),
(35, 'Pc acer', 20, 'good', '2023-03-09', 8),
(36, 'Pc acer', 20, 'good', '2023-03-09', 8),
(37, 'Pc acer', 20, 'waiting', '2023-03-09', 8);

-- --------------------------------------------------------

--
-- Table structure for table `reponse_reclamation`
--

CREATE TABLE `reponse_reclamation` (
  `id_reponse` int(11) NOT NULL,
  `sujet` varchar(255) NOT NULL,
  `etat` varchar(255) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `id_reclamation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reponse_reclamation`
--

INSERT INTO `reponse_reclamation` (`id_reponse`, `sujet`, `etat`, `date`, `id_reclamation`) VALUES
(14, 'eeoffreeeee', 'traitée', '2023-03-04', 52),
(17, 'dd', 'dd', '2023-03-07', 52),
(18, 'aaa', 'traitée', '2023-03-07', 49),
(19, 'AAA', 'traiter', '2023-03-07', 64),
(20, 'dd', 'traiter', '2023-03-07', 65),
(21, 'AAA', 'traiter', '2023-03-07', 65),
(22, 'aaa', 'bbbb', '2023-03-07', 65),
(23, 'SSSSS', 'traiter', '2023-03-07', 66),
(24, 'ddd', 'dd', '2023-03-07', 52),
(25, 'ddd', 'fff', '2023-03-07', 52),
(26, 'ddd', 'ddd', '2023-03-08', 52),
(27, 'ddd', 'ddd', '2023-03-08', 52),
(29, 'publicité', 'traiter', '2023-03-08', 82),
(30, 'dddd', 'ddd', '2023-03-08', 52),
(31, 'publicité', 'ddd', '2023-03-09', 49),
(32, 'aaa', 'traitée', '2023-03-09', 69),
(33, 'publicité', 'dd', '2023-03-09', 49),
(34, 'dd', 'dd', '2023-03-09', 49),
(35, 'publicité', 'dd', '2023-03-09', 64),
(36, 'dd', 'dd', '2023-03-09', 86),
(37, 'publicité', 'ddddd', '2023-03-09', 49),
(38, 'AAA', 'dd', '2023-03-09', 49),
(41, 'dadad', 'dadada', '2023-04-10', 54),
(42, 'dddd', 'ddd', '2023-04-10', 92);

-- --------------------------------------------------------

--
-- Table structure for table `sponsor`
--

CREATE TABLE `sponsor` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `num_tel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sponsor`
--

INSERT INTO `sponsor` (`id`, `nom`, `adresse`, `email`, `num_tel`) VALUES
(1, 'Jihed Gharsallah', 'Bengarden', 'j.garsallah@gmail.com', 27146379),
(6, 'Yassine Boulares', 'Zahrouni', 'yassine99@gmail.com', 25555505),
(13, 'Mohamed Mejdi', 'mednine', 'hamma.m@esprit.n', 22324354),
(14, 'Yassine Boulares', 'Tunisee', 'yas@gmail.com', 271463798),
(19, 'ammar1', 'medenin', 'amar@gmail.com', 20405060);

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT 'USER',
  `age` date NOT NULL,
  `username` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `bloquer` int(11) NOT NULL DEFAULT 0,
  `code` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom`, `prenom`, `password`, `email`, `adresse`, `role`, `age`, `username`, `photo`, `bloquer`, `code`) VALUES
(1, 'mama', 'yassine', 'xdYBVs0YI1vdyO+3T6ZfXQ==', 'mama@mama.com', 'houmt 9ouraych', 'ROLE_USER', '2018-01-01', '+21625555505', 'aebccda2b4040db02a7531cd3329659c.jpg', 1, 25555505),
(162, 'baha', 'baha', 'Qb5pjYEpx1ChrL5RE/+/xA==', 'gg', '789 rue palastine', 'ROLE_ADMIN', '2018-01-01', 'baha', 'e7203d782eec040f478fbc0adbc8449d.jpg', 0, 9458),
(173, 'esprance sportive de tunis mmmmm', 'esprance sportive de tunis mmmmm', 'GJKxP41HzXH0lVJTtxm28w==', 'mejdi.mohamed@esprit.tn', 'esprance sportive de tunis', 'ROLE_USER', '2018-01-19', 'esprance sportive de tunis', 'esprance sportive de tunis ', 0, NULL),
(175, 'mejdi', 'mohamed', 'A9wAMxzRgc7Glizj8Z0UOA==', 'mejdi.mohamed@esprit.tn', 'houmt 9ouraych', 'ROLE_ADMIN', '2019-01-01', 'Hama', 'aebccda2b4040db02a7531cd3329659c.jpg', 1, 25555505),
(176, 'yassine', 'boulares', 'buXH3U1+ORRXGqN70kAsYA==', 'yassine.boulares9@gmail.com', 'rue turkie', 'ROLE_ADMIN', '2020-04-04', 'yassine boularess', '7074a123095ccb093b84a576ae344a05.jpg', 0, 3120),
(177, 'mahdi', 'romdhani', 'JhVy5glJgl1WNjfI/jcZxw==', 'marouen.romdhani@esprit.tn', 'rue tunis', 'ROLE_ADMIN', '2020-10-19', 'mahdiro', '73082afdf6e8f400fa4de1a0c3b6ea16.jpg', 1, 2662),
(178, 'mahdi', 'romdhani', '16k+mj5tdcoSZcgkXQ5ArA==', 'mejdi.mohamed@esprit.tn', 'rue tunisie', 'ROLE_USER', '2018-01-01', 'Medmejdi', 'e85235516d27c1e2a17d65a0b189c850.jpg', 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appel_offre`
--
ALTER TABLE `appel_offre`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk1` (`id_utilisateur_id`),
  ADD KEY `fk10` (`id_categorie_id`);

--
-- Indexes for table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `demande`
--
ALTER TABLE `demande`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dkd` (`idproduit`),
  ADD KEY `ddd` (`idutilisateur`);

--
-- Indexes for table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`id_facture`),
  ADD KEY `fk4` (`id_utilisateur`);

--
-- Indexes for table `favorie`
--
ALTER TABLE `favorie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aaaa` (`idproduit`),
  ADD KEY `aaa` (`idutilisateur`);

--
-- Indexes for table `finance`
--
ALTER TABLE `finance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk3` (`id_facture`);

--
-- Indexes for table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id_produit`),
  ADD KEY `fk5` (`id_categorie_id`);

--
-- Indexes for table `publicite`
--
ALTER TABLE `publicite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk6` (`id_sponsor_id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ffa` (`iduser`),
  ADD KEY `ff2` (`idpub`);

--
-- Indexes for table `reclamation`
--
ALTER TABLE `reclamation`
  ADD PRIMARY KEY (`id_rec`),
  ADD KEY `fk7` (`id_utilisateur_id`);

--
-- Indexes for table `reponse_offre`
--
ALTER TABLE `reponse_offre`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk8` (`id_offre`);

--
-- Indexes for table `reponse_reclamation`
--
ALTER TABLE `reponse_reclamation`
  ADD PRIMARY KEY (`id_reponse`),
  ADD KEY `fk9` (`id_reclamation`);

--
-- Indexes for table `sponsor`
--
ALTER TABLE `sponsor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appel_offre`
--
ALTER TABLE `appel_offre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `demande`
--
ALTER TABLE `demande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `facture`
--
ALTER TABLE `facture`
  MODIFY `id_facture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `favorie`
--
ALTER TABLE `favorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `finance`
--
ALTER TABLE `finance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `produit`
--
ALTER TABLE `produit`
  MODIFY `id_produit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `publicite`
--
ALTER TABLE `publicite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `reclamation`
--
ALTER TABLE `reclamation`
  MODIFY `id_rec` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `reponse_offre`
--
ALTER TABLE `reponse_offre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `reponse_reclamation`
--
ALTER TABLE `reponse_reclamation`
  MODIFY `id_reponse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `sponsor`
--
ALTER TABLE `sponsor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appel_offre`
--
ALTER TABLE `appel_offre`
  ADD CONSTRAINT `fk1` FOREIGN KEY (`id_utilisateur_id`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `fk10` FOREIGN KEY (`id_categorie_id`) REFERENCES `categorie` (`id`);

--
-- Constraints for table `demande`
--
ALTER TABLE `demande`
  ADD CONSTRAINT `ddd` FOREIGN KEY (`idutilisateur`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `dkd` FOREIGN KEY (`idproduit`) REFERENCES `produit` (`id_produit`);

--
-- Constraints for table `facture`
--
ALTER TABLE `facture`
  ADD CONSTRAINT `fk4` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`);

--
-- Constraints for table `favorie`
--
ALTER TABLE `favorie`
  ADD CONSTRAINT `aaa` FOREIGN KEY (`idutilisateur`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `aaaa` FOREIGN KEY (`idproduit`) REFERENCES `produit` (`id_produit`);

--
-- Constraints for table `finance`
--
ALTER TABLE `finance`
  ADD CONSTRAINT `fk3` FOREIGN KEY (`id_facture`) REFERENCES `facture` (`id_facture`);

--
-- Constraints for table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `fk5` FOREIGN KEY (`id_categorie_id`) REFERENCES `categorie` (`id`);

--
-- Constraints for table `publicite`
--
ALTER TABLE `publicite`
  ADD CONSTRAINT `fk6` FOREIGN KEY (`id_sponsor_id`) REFERENCES `sponsor` (`id`);

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `ff2` FOREIGN KEY (`idpub`) REFERENCES `publicite` (`id`),
  ADD CONSTRAINT `ffa` FOREIGN KEY (`iduser`) REFERENCES `utilisateur` (`id`);

--
-- Constraints for table `reclamation`
--
ALTER TABLE `reclamation`
  ADD CONSTRAINT `fk7` FOREIGN KEY (`id_utilisateur_id`) REFERENCES `utilisateur` (`id`);

--
-- Constraints for table `reponse_offre`
--
ALTER TABLE `reponse_offre`
  ADD CONSTRAINT `fk8` FOREIGN KEY (`id_offre`) REFERENCES `appel_offre` (`id`);

--
-- Constraints for table `reponse_reclamation`
--
ALTER TABLE `reponse_reclamation`
  ADD CONSTRAINT `fk9` FOREIGN KEY (`id_reclamation`) REFERENCES `reclamation` (`id_rec`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
