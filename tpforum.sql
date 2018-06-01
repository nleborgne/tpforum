-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 01 juin 2018 à 07:15
-- Version du serveur :  5.7.21
-- Version de PHP :  7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `tpforum`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `nom_categorie` varchar(80) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`ID`, `nom_categorie`) VALUES
(1, 'TP'),
(2, 'DS');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_message` int(11) NOT NULL,
  `ID_utilisateur` int(11) NOT NULL,
  `contenu` varchar(8000) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`ID`, `ID_message`, `ID_utilisateur`, `contenu`, `date`) VALUES
(1, 1, 1, 'tout à fait d\'accord', '2018-05-25'),
(2, 2, 1, 'j\'adore', '2018-05-30'),
(3, 1, 1, 'pas du tout d\'accord', '2018-05-31');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_utilisateur` int(11) NOT NULL,
  `date` date NOT NULL,
  `contenu` varchar(8000) NOT NULL,
  `ID_categorie` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`ID`, `ID_utilisateur`, `date`, `contenu`, `ID_categorie`) VALUES
(1, 1, '2018-05-23', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam finibus egestas euismod. Morbi lobortis dignissim quam ac pharetra. ', 1),
(2, 1, '2018-05-16', 'TEST', 2),
(3, 1, '2018-05-23', 'aaaa', 2),
(4, 2, '2018-05-25', 'test', 2),
(5, 1, '2018-05-29', 'test', 1),
(6, 3, '2018-05-31', 'hello', 1),
(7, 3, '2018-05-31', 'À réviser, le chapitre 3 et 4', 2);

-- --------------------------------------------------------

--
-- Structure de la table `personne`
--

DROP TABLE IF EXISTS `personne`;
CREATE TABLE IF NOT EXISTS `personne` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(8000) NOT NULL,
  `email` varchar(8000) NOT NULL,
  `mot_de_passe` varchar(8000) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `personne`
--

INSERT INTO `personne` (`ID`, `nom`, `email`, `mot_de_passe`) VALUES
(1, 'Nicolas Le Borgne', 'nico.le.borgne@gmail.com', '$2y$10$xr52rK8xBFGMzflJIQsASuYNPr46fHEusRQHxb7uFFRhVheQLhMYC'),
(2, 'test', 'test@email.fr', '$2y$10$ZRYH1o.YWxVubrZpHNnxKewuYZBVkc9f3ABJnchetGL/dIkxfTf0G'),
(3, 'Jean Michel', 'jean@email.com', '$2y$10$rp.7hl40nkdJAj48AxdwXu37JeKHdv.2ptGL4FFbJ7b20XdkDmBIa');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
