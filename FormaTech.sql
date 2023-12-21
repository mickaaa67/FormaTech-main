-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 18 déc. 2023 à 15:16
-- Version du serveur : 8.0.31
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `formatech`
--

-- --------------------------------------------------------

--
-- Structure de la table `composer`
--

DROP TABLE IF EXISTS `composer`;
CREATE TABLE IF NOT EXISTS `composer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_1` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_1` (`id_1`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `connexion`
--

DROP TABLE IF EXISTS `connexion`;
CREATE TABLE IF NOT EXISTS `connexion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilisateur` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `mot_de_passe` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `idEmploye` int DEFAULT NULL,
  `idIntervenant` int DEFAULT NULL,
  `idEtudiant` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `utilisateur` (`utilisateur`),
  KEY `idEmploye` (`idEmploye`),
  KEY `idIntervenant` (`idIntervenant`),
  KEY `idEtudiant` (`idEtudiant`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `formation`
--

DROP TABLE IF EXISTS `formation`;
CREATE TABLE IF NOT EXISTS `formation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `duree` bigint DEFAULT NULL,
  `abreviation` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `niveau_RNCP` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `formation`
--

INSERT INTO `formation` (`id`, `nom`, `duree`, `abreviation`, `niveau_RNCP`) VALUES
(1, 'Technicien en maintenance robotique', 24, 'TMR', 5),
(2, 'Bachelor administrateur en technologies novatrices', 12, 'BATN', 6),
(3, 'Ingénieur expert en fusion cybernétique', 24, 'IEFC', 7),
(4, 'Technicien en maintenance robotique', 24, 'TMR', 5),
(5, 'Bachelor administrateur en technologies novatrices', 12, 'BATN', 6),
(6, 'Ingénieur expert en fusion cybernétique', 24, 'IEFC', 7),
(7, 'Technicien en maintenance robotique', 24, 'TMR', 5),
(8, 'Bachelor administrateur en technologies novatrices', 12, 'BATN', 6),
(9, 'Ingénieur expert en fusion cybernétique', 24, 'IEFC', 7);

-- --------------------------------------------------------

--
-- Structure de la table `intervient`
--

DROP TABLE IF EXISTS `intervient`;
CREATE TABLE IF NOT EXISTS `intervient` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_1` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_1` (`id_1`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `le_module`
--

DROP TABLE IF EXISTS `le_module`;
CREATE TABLE IF NOT EXISTS `le_module` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `duree` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `idFormation` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Le_Module_Formation` (`idFormation`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `le_module`
--

INSERT INTO `le_module` (`id`, `nom`, `duree`, `idFormation`) VALUES
(17, 'Découverte de la robotique', '70', 'TMR'),
(18, 'Programmation assistée par IA', '98', 'TMR'),
(19, 'Conception robotique', '105', 'BATN'),
(20, 'Concepteur de réalités alternatives', '140', 'BATN'),
(21, 'Développement d\'intelligences articielles', '70', 'BATN'),
(22, 'Informatique quantique', '105', 'IEFC'),
(23, 'Développement d\'énergies nouvelles et expérimental', '140', 'IEFC'),
(24, 'Ingénierie spatiale', '1119', 'IEFC');

-- --------------------------------------------------------

--
-- Structure de la table `participe`
--

DROP TABLE IF EXISTS `participe`;
CREATE TABLE IF NOT EXISTS `participe` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_1` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_1` (`id_1`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personne`
--

DROP TABLE IF EXISTS `personne`;
CREATE TABLE IF NOT EXISTS `personne` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `prenom` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `mail` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `date_naissance` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `utilisateur` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `mot_de_passe` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `idFormation` int DEFAULT NULL,
  `poste` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `utilisateur` (`utilisateur`),
  UNIQUE KEY `mail` (`mail`),
  KEY `idFormation` (`idFormation`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `possede`
--

DROP TABLE IF EXISTS `possede`;
CREATE TABLE IF NOT EXISTS `possede` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_1` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_1` (`id_1`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `promotion`
--

DROP TABLE IF EXISTS `promotion`;
CREATE TABLE IF NOT EXISTS `promotion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `formation` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `annee` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_Emargement` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_Fin` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

DROP TABLE IF EXISTS `salle`;
CREATE TABLE IF NOT EXISTS `salle` (
  `id` int NOT NULL AUTO_INCREMENT,
  `batiment` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nom` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `capacite` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `salle`
--

INSERT INTO `salle` (`id`, `batiment`, `nom`, `capacite`) VALUES
(1, '1', 'Tesla', 10),
(2, '1', 'Hawking', 15),
(3, '1', 'Lovelace', 20),
(4, '1', 'Amphithéâtre Boris Mallick', 200),
(5, '2', 'Schrödinger', 25),
(6, '2', 'Bohr', 25),
(7, '2', 'Laboratoire Marie Curie', 50);

-- --------------------------------------------------------

--
-- Structure de la table `session`
--

DROP TABLE IF EXISTS `session`;
CREATE TABLE IF NOT EXISTS `session` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date_Session` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `heure_Debut` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `heure_Fin` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nomModule` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `idPromotion` int DEFAULT NULL,
  `id_1` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_1` (`id_1`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `se_deroule`
--

DROP TABLE IF EXISTS `se_deroule`;
CREATE TABLE IF NOT EXISTS `se_deroule` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_1` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_1` (`id_1`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
