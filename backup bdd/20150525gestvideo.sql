-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 25 Mai 2015 à 16:47
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `gestvideo`
--

-- --------------------------------------------------------

--
-- Structure de la table `tappartenir`
--

CREATE TABLE IF NOT EXISTS `tappartenir` (
  `id_titre` int(8) NOT NULL AUTO_INCREMENT,
  `den_categ` varchar(30) NOT NULL,
  PRIMARY KEY (`id_titre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `tcategories`
--

CREATE TABLE IF NOT EXISTS `tcategories` (
  `idcategorie` int(6) NOT NULL AUTO_INCREMENT,
  `dencategorie` varchar(30) NOT NULL,
  PRIMARY KEY (`idcategorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `tcontenir`
--

CREATE TABLE IF NOT EXISTS `tcontenir` (
  `idsupport` int(8) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idsupport`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `tpersonnes`
--

CREATE TABLE IF NOT EXISTS `tpersonnes` (
  `idpersonne` int(6) NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `codepostal` int(6) NOT NULL,
  `localite` varchar(30) NOT NULL,
  `telephone` int(14) NOT NULL,
  `gsm` int(14) NOT NULL,
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`idpersonne`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `tsupports`
--

CREATE TABLE IF NOT EXISTS `tsupports` (
  `idsupport` int(8) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idsupport`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ttitres`
--

CREATE TABLE IF NOT EXISTS `ttitres` (
  `idtitre` int(6) NOT NULL AUTO_INCREMENT,
  `titre` varchar(50) NOT NULL,
  `datetitre` datetime NOT NULL,
  PRIMARY KEY (`idtitre`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Contenu de la table `ttitres`
--

INSERT INTO `ttitres` (`idtitre`, `titre`, `datetitre`) VALUES
(1, '100 GIRLS', '2015-04-27 00:00:00'),
(2, 'tintin', '2015-05-04 19:05:51'),
(3, 'milou', '2015-05-04 19:06:41'),
(13, 'violetta3', '2015-05-19 16:56:12'),
(21, 'test3', '2015-05-19 21:12:28'),
(23, 'M Pokora', '2015-05-21 21:20:35'),
(27, 'test4', '2015-05-21 22:57:49'),
(29, 'test5', '2015-05-25 15:03:32');

-- --------------------------------------------------------

--
-- Structure de la table `ttypesupports`
--

CREATE TABLE IF NOT EXISTS `ttypesupports` (
  `idtypesupport` int(8) NOT NULL AUTO_INCREMENT,
  `typesupport` varchar(20) NOT NULL,
  PRIMARY KEY (`idtypesupport`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
