-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 17 sep. 2020 à 16:24
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `demo`
--

-- --------------------------------------------------------

--
-- Structure de la table `d_bc`
--

DROP TABLE IF EXISTS `d_bc`;
CREATE TABLE IF NOT EXISTS `d_bc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client` varchar(100) NOT NULL,
  `tel` int(11) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `mf` varchar(50) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `d_bs`
--

DROP TABLE IF EXISTS `d_bs`;
CREATE TABLE IF NOT EXISTS `d_bs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client` varchar(100) NOT NULL,
  `tel` int(11) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `mf` varchar(50) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `d_client`
--

DROP TABLE IF EXISTS `d_client`;
CREATE TABLE IF NOT EXISTS `d_client` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nom_prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `img` text NOT NULL,
  `tel` int(11) NOT NULL,
  `password` text NOT NULL,
  `date_ajout` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `d_client`
--

INSERT INTO `d_client` (`id`, `nom_prenom`, `email`, `img`, `tel`, `password`, `date_ajout`) VALUES
(18, 'qqqqqqqqq', 'dhia.realist', 'p-250.png', 55555, '5555555', '2020-07-28'),
(19, 'Dhia Eddine Ben Aicha', 'benaichadhie@gmail.com', '1596667492__108114460_899264603904846_8491095697679289982_n.jpg', 2075555, 'aaaa', '2020-08-05');

-- --------------------------------------------------------

--
-- Structure de la table `d_devis`
--

DROP TABLE IF EXISTS `d_devis`;
CREATE TABLE IF NOT EXISTS `d_devis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client` varchar(100) NOT NULL,
  `tel` int(11) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `mf` varchar(50) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `d_facture`
--

DROP TABLE IF EXISTS `d_facture`;
CREATE TABLE IF NOT EXISTS `d_facture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client` varchar(100) NOT NULL,
  `tel` int(11) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `mf` varchar(50) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `d_facture`
--

INSERT INTO `d_facture` (`id`, `client`, `tel`, `adresse`, `mf`, `date`) VALUES
(36, 'Dhia Eddine Ben Aicha', 20479911, 'kalaa kebira sousse', '000MA1405418', '2020-08-27');

-- --------------------------------------------------------

--
-- Structure de la table `d_fournisseur`
--

DROP TABLE IF EXISTS `d_fournisseur`;
CREATE TABLE IF NOT EXISTS `d_fournisseur` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `raison` varchar(255) NOT NULL,
  `logo` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `tel` int(11) NOT NULL,
  `date_ajout` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `d_fournisseur`
--

INSERT INTO `d_fournisseur` (`id`, `raison`, `logo`, `email`, `tel`, `date_ajout`) VALUES
(25, 'Dhia Eddine Ben Aicha', '1596668429__108114460_899264603904846_8491095697679289982_n.jpg', 'benaichadhie@gmail.com', 20479911, '2020-08-06');

-- --------------------------------------------------------

--
-- Structure de la table `d_ligne_bc`
--

DROP TABLE IF EXISTS `d_ligne_bc`;
CREATE TABLE IF NOT EXISTS `d_ligne_bc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_bc` int(11) NOT NULL,
  `designation` varchar(500) NOT NULL,
  `prix` double(10,3) NOT NULL,
  `qte` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `d_ligne_bs`
--

DROP TABLE IF EXISTS `d_ligne_bs`;
CREATE TABLE IF NOT EXISTS `d_ligne_bs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_bs` int(11) NOT NULL,
  `designation` varchar(500) NOT NULL,
  `prix` double(10,3) NOT NULL,
  `qte` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `d_ligne_devis`
--

DROP TABLE IF EXISTS `d_ligne_devis`;
CREATE TABLE IF NOT EXISTS `d_ligne_devis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_devis` int(11) NOT NULL,
  `designation` varchar(500) NOT NULL,
  `prix` double(10,3) NOT NULL,
  `qte` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `d_ligne_facture`
--

DROP TABLE IF EXISTS `d_ligne_facture`;
CREATE TABLE IF NOT EXISTS `d_ligne_facture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_facture` int(11) NOT NULL,
  `designation` varchar(500) NOT NULL,
  `prix` double(10,3) NOT NULL,
  `qte` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `d_ligne_facture`
--

INSERT INTO `d_ligne_facture` (`id`, `id_facture`, `designation`, `prix`, `qte`) VALUES
(51, 36, 'test 1', 1.000, 1),
(52, 36, 'test 2', 2.000, 2);

-- --------------------------------------------------------

--
-- Structure de la table `d_livreur`
--

DROP TABLE IF EXISTS `d_livreur`;
CREATE TABLE IF NOT EXISTS `d_livreur` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `raison` varchar(255) NOT NULL,
  `logo` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `tel` int(11) NOT NULL,
  `date_ajout` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `d_livreur`
--

INSERT INTO `d_livreur` (`id`, `raison`, `logo`, `email`, `tel`, `date_ajout`) VALUES
(4, 'Dhia Eddine Ben Aicha', '1596668951__108114460_899264603904846_8491095697679289982_n.jpg', 'benaichadhie@gmail.com', 20479911, '2020-08-06');

-- --------------------------------------------------------

--
-- Structure de la table `d_user`
--

DROP TABLE IF EXISTS `d_user`;
CREATE TABLE IF NOT EXISTS `d_user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` varchar(12) NOT NULL,
  `nom_prenom` varchar(255) NOT NULL,
  `img` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `tel` int(11) NOT NULL,
  `password` text NOT NULL,
  `date_ajout` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `d_user`
--

INSERT INTO `d_user` (`id`, `type`, `nom_prenom`, `img`, `email`, `tel`, `password`, `date_ajout`) VALUES
(14, 'Admin', 'aaaaaaaaaa', 'p-250.png', 'aaaaa', 444444, 'aaaaa', '2020-08-05');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
