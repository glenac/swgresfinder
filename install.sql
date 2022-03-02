-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Hôte : front-ha-mysql-01.shpv.fr:3306
-- Généré le : mer. 02 mars 2022 à 01:57
-- Version du serveur :  5.7.34-log
-- Version de PHP : 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `resources`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id_category` int(10) UNSIGNED NOT NULL,
  `id_parent` int(10) UNSIGNED NOT NULL,
  `id_shop_default` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `level_depth` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `nleft` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `nright` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `date_add` datetime NOT NULL,
  `date_upd` datetime NOT NULL,
  `position` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `is_root_category` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `category_lang`
--

CREATE TABLE `category_lang` (
  `id_category` int(10) UNSIGNED NOT NULL,
  `id_shop` int(11) UNSIGNED NOT NULL DEFAULT '1',
  `id_lang` int(10) UNSIGNED NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` text,
  `link_rewrite` varchar(128) NOT NULL,
  `meta_title` varchar(128) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `category_resource`
--

CREATE TABLE `category_resource` (
  `id_category_resource` int(5) NOT NULL,
  `id_category` int(5) NOT NULL,
  `id_resource` int(5) NOT NULL,
  `type_id` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `resources`
--

CREATE TABLE `resources` (
  `id_resource` int(5) NOT NULL,
  `name` varchar(128) NOT NULL,
  `galaxy_id` int(3) NOT NULL,
  `galaxy_name` varchar(64) NOT NULL,
  `enter_date` varchar(128) NOT NULL,
  `type_id` varchar(128) NOT NULL,
  `type_name` varchar(128) NOT NULL,
  `group_id` varchar(128) NOT NULL,
  `CR` int(11) NOT NULL,
  `CD` int(11) NOT NULL,
  `DR` int(11) NOT NULL,
  `FL` int(11) NOT NULL,
  `HR` int(11) NOT NULL,
  `MA` int(11) NOT NULL,
  `PE` int(11) NOT NULL,
  `OQ` int(11) NOT NULL,
  `SR` int(11) NOT NULL,
  `UT` int(11) NOT NULL,
  `ER` int(11) NOT NULL,
  `unavailable_date` int(11) DEFAULT NULL,
  `planets` varchar(512) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `resources_all`
--

CREATE TABLE `resources_all` (
  `id_resource` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `galaxy_id` int(3) NOT NULL,
  `galaxy_name` varchar(64) NOT NULL,
  `enter_date` varchar(128) NOT NULL,
  `type_id` varchar(128) NOT NULL,
  `type_name` varchar(128) NOT NULL,
  `group_id` varchar(128) NOT NULL,
  `CR` int(11) NOT NULL,
  `CD` int(11) NOT NULL,
  `DR` int(11) NOT NULL,
  `FL` int(11) NOT NULL,
  `HR` int(11) NOT NULL,
  `MA` int(11) NOT NULL,
  `PE` int(11) NOT NULL,
  `OQ` int(11) NOT NULL,
  `SR` int(11) NOT NULL,
  `UT` int(11) NOT NULL,
  `ER` int(11) NOT NULL,
  `unavailable_date` int(11) DEFAULT NULL,
  `planets` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`),
  ADD KEY `category_parent` (`id_parent`),
  ADD KEY `nleftrightactive` (`nleft`,`nright`,`active`),
  ADD KEY `level_depth` (`level_depth`),
  ADD KEY `nright` (`nright`),
  ADD KEY `activenleft` (`active`,`nleft`),
  ADD KEY `activenright` (`active`,`nright`);

--
-- Index pour la table `category_lang`
--
ALTER TABLE `category_lang`
  ADD PRIMARY KEY (`id_category`,`id_shop`,`id_lang`),
  ADD KEY `category_name` (`name`);

--
-- Index pour la table `category_resource`
--
ALTER TABLE `category_resource`
  ADD PRIMARY KEY (`id_category_resource`),
  ADD UNIQUE KEY `id_category` (`id_category`,`type_id`),
  ADD UNIQUE KEY `id_category_2` (`id_category`);


--
-- Index pour la table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`id_resource`),
  ADD UNIQUE KEY `name` (`name`,`type_id`),
  ADD KEY `name_2` (`name`);

--
-- Index pour la table `resources_all`
--
ALTER TABLE `resources_all`
  ADD PRIMARY KEY (`id_resource`),
  ADD UNIQUE KEY `name` (`name`,`galaxy_id`,`type_id`);


--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `category_resource`
--
ALTER TABLE `category_resource`
  MODIFY `id_category_resource` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `resources`
--
ALTER TABLE `resources`
  MODIFY `id_resource` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `resources_all`
--
ALTER TABLE `resources_all`
  MODIFY `id_resource` int(11) NOT NULL AUTO_INCREMENT;

;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
