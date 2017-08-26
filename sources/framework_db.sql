-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 12 Février 2016 à 08:23
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `framework_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

CREATE TABLE IF NOT EXISTS `administrateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `identifiant` varchar(50) NOT NULL,
  `mdp` varchar(50) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `access` text NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `connexion` datetime NOT NULL,
  `create_date` datetime NOT NULL,
  `access_all` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `administrateur`
--

INSERT INTO `administrateur` (`id`, `nom`, `prenom`, `identifiant`, `mdp`, `photo`, `access`, `active`, `connexion`, `create_date`, `access_all`) VALUES
(1, 'DECANET', 'FRAMEWORK', 'framework', 'f178867da2879cae0f60630a6a2da174e0c2328e', '15012016162648logo.png', '', 1, '2016-02-12 02:29:43', '2015-01-13 10:48:29', 1);

-- --------------------------------------------------------

--
-- Structure de la table `admin_groupe`
--

CREATE TABLE IF NOT EXISTS `admin_groupe` (
  `id_administrateur` int(11) NOT NULL,
  `id_groupe` int(11) NOT NULL,
  PRIMARY KEY (`id_administrateur`,`id_groupe`),
  KEY `id_groupe` (`id_groupe`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `admin_groupe`
--

INSERT INTO `admin_groupe` (`id_administrateur`, `id_groupe`) VALUES
(2, 9),
(3, 10);

-- --------------------------------------------------------

--
-- Structure de la table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `name` varchar(100) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `config`
--

INSERT INTO `config` (`name`, `value`) VALUES
('caching', 'disk'),
('cgv', '5'),
('contact_adresse', 'Rue de Berne 44 1201 Genève Suisse'),
('contact_article', '1'),
('contact_email', 'contact@cafrintel.com'),
('contact_localisation', ''),
('contact_nbwords', '600'),
('contact_phone_fixe', '+00 000 000 000'),
('contact_phone_mobile', '+00 000 000 000'),
('contact_website', 'cafrintel.com'),
('db_cache', '1'),
('default_idlang', 'fr'),
('default_lang', '1'),
('homeslider', 'a:3:{s:5:"title";a:4:{i:0;s:0:"";i:1;s:0:"";i:2;s:54:"faucibus orci luctus et ultrices posuere cubilia Curae";i:3;s:45:"Curabitur aliquet quam id dui posuere blandit";}s:4:"desc";a:4:{i:0;s:0:"";i:1;s:0:"";i:2;s:234:"Curabitur non nulla sit amet nisl tempus convallis quis ac lectus.\r\n\r\nVestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.";i:3;s:128:"Curabitur aliquet quam id dui posuere blandit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin eget tortor risus.";}s:3:"img";a:4:{i:0;s:15:"homeslide-1.jpg";i:1;s:15:"homeslide-2.jpg";i:2;s:15:"homeslide-4.jpg";i:3;s:15:"homeslide-3.jpg";}}'),
('logo', 'cafrintel-logo-bleu.png'),
('mail_authentification', '1'),
('mail_host', 'smtp.gmail.com'),
('mail_port', '465'),
('mail_pwd', 'chouchou1989'),
('mail_sercure', 'ssl'),
('mail_serveur', 'smtp'),
('mail_sitemail', 'lucalfredmbida@gmail.com'),
('mail_sitemailname', 'Cafrintel'),
('mail_user', 'lucalfredmbida@gmail.com'),
('maintenance', '1'),
('maintenance_ip', '127.0.0.1'),
('memcache_servers', '[{"ip":"127.0.0.1","port":"11211"},{"ip":"","port":""},{"ip":"","port":""},{"ip":"","port":""},{"ip":"","port":""}]'),
('minifycss', '0'),
('minifyhtml', '0'),
('minifyjs', '0'),
('mod_actu', '9'),
('psid', 'cafrintelsa01TEST'),
('securepage', ''),
('securite', '0'),
('sec_SHAIN', 'Cafrintelsa012015!?'),
('sec_SHAOUT', ''),
('smarty_cache', '1'),
('smarty_cachetime', '3600'),
('smarty_forcecompile', '0'),
('social_facebook', 'https://www.facebook.com/'),
('social_googleplus', 'https://www.google.cm/?gws_rd=cr,ssl&ei=S5fMVdL2G8qnaKSgtbAF'),
('social_intagram', 'http://intagram.com/'),
('social_twitter', 'http://tweeter.com/'),
('unifycss', '0'),
('unifyjs', '0');

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

CREATE TABLE IF NOT EXISTS `groupe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_ets` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `access` text NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `creation_date` datetime NOT NULL,
  `salles` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_ets` (`id_ets`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `groupe`
--

INSERT INTO `groupe` (`id`, `id_ets`, `nom`, `access`, `active`, `creation_date`, `salles`) VALUES
(9, 1, 'Gestionnaire', '{"view_1":1,"view_1_1":1,"view_2":1,"view_2_2":1,"add_2_2":1,"edit_2_2":1,"del_2_2":1}', 1, '2015-01-14 11:16:57', '["18","20"]'),
(10, 2, 'Adminstrateur', '{"view_0":1,"add_0":1,"edit_0":1,"del_0":1,"view_1":1,"view_1_1":1,"view_2":1,"view_2_1":1,"add_2_1":1,"edit_2_1":1,"del_2_1":1,"view_2_2":1,"add_2_2":1,"edit_2_2":1,"del_2_2":1,"view_2_3":1,"add_2_3":1,"edit_2_3":1,"del_2_3":1,"view_3":1,"view_3_1":1,"view_3_2":1,"view_3_3":1,"view_3_4":1}', 1, '2015-01-14 11:16:57', ''),
(11, 2, 'Editeur', '{"view_0":1,"add_0":1,"edit_0":1,"del_0":1,"view_1":1,"view_1_1":1,"view_2":1,"view_2_1":1,"add_2_1":1,"edit_2_1":1,"del_2_1":1,"add_2":1,"edit_2":1,"del_2":1,"view_2_2":1,"add_2_2":1,"edit_2_2":1,"del_2_2":1,"view_3":1,"view_3_1":1,"view_3_2":1,"view_3_3":1,"view_3_4":1}', 1, '2015-01-14 11:16:57', '');

-- --------------------------------------------------------

--
-- Structure de la table `historique`
--

CREATE TABLE IF NOT EXISTS `historique` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(16) NOT NULL,
  `dateheure` datetime NOT NULL,
  `id_user` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '1',
  `service` varchar(255) NOT NULL,
  `avant` text NOT NULL,
  `apres` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `historique`
--

INSERT INTO `historique` (`id`, `ip`, `dateheure`, `id_user`, `action`, `is_admin`, `service`, `avant`, `apres`) VALUES
(1, '127.0.0.1', '2015-03-18 09:51:27', 1, 'connexion', 1, '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `lang`
--

CREATE TABLE IF NOT EXISTS `lang` (
  `id_lang` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `active` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `iso_code` char(2) NOT NULL,
  `language_code` char(5) NOT NULL,
  `date_format_lite` char(32) NOT NULL DEFAULT 'Y-m-d',
  `date_format_full` char(32) NOT NULL DEFAULT 'Y-m-d H:i:s',
  `is_rtl` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_lang`),
  KEY `lang_iso_code` (`iso_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `lang`
--

INSERT INTO `lang` (`id_lang`, `name`, `active`, `iso_code`, `language_code`, `date_format_lite`, `date_format_full`, `is_rtl`) VALUES
(1, 'Français (French)', 1, 'fr', 'fr-fr', 'd/m/Y', 'd/m/Y H:i:s', 0),
(3, 'Anglais', 1, 'en', 'en-en', 'Y-m-d', 'Y-m-d H:i:s', 0);

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE IF NOT EXISTS `membre` (
  `membre_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `membre_connexion` datetime NOT NULL,
  `membre_identifiant` varchar(100) NOT NULL,
  `membre_pass` varchar(100) NOT NULL,
  `membre_droits` text NOT NULL,
  `membre_actif` int(11) NOT NULL,
  `membre_info_perso` text NOT NULL,
  `membre_inscription` datetime NOT NULL,
  `membre_type` enum('admin','site','cafrintel') NOT NULL DEFAULT 'cafrintel',
  `membre_club` tinyint(1) NOT NULL DEFAULT '1',
  `membre_lang` varchar(10) NOT NULL DEFAULT 'FR',
  `membre_group` int(11) NOT NULL DEFAULT '1',
  `membre_deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`membre_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `membre`
--

INSERT INTO `membre` (`membre_id`, `membre_connexion`, `membre_identifiant`, `membre_pass`, `membre_droits`, `membre_actif`, `membre_info_perso`, `membre_inscription`, `membre_type`, `membre_club`, `membre_lang`, `membre_group`, `membre_deleted`) VALUES
(1, '2015-06-20 05:52:33', 'Ben', '253701f517141ceb38e22657194240638acb7c41', '{"1_0":1,"3_0":1,"17_0":1,"2_0":1,"2_3":1,"2_1":1,"2_2":1,"2_4":1,"4_0":1,"5_0":1,"6_0":1,"7_0":1,"8_0":1,"12_0":1,"12_1":1,"12_2":1,"12_3":1,"13_0":1,"18_0":1,"14_0":1,"14_1":1,"14_2":1,"14_3":1}', 1, '', '0000-00-00 00:00:00', 'admin', 1, 'FR', 1, 0),
(2, '2015-08-17 19:56:02', 'leocedric2000@yahoo.fr', '217181a7c820abfe7bba925f1488fc32e1ae85bb', '', 1, 'a:10:{s:6:"gender";s:2:"M.";s:6:"prenom";s:7:"Lionnel";s:3:"nom";s:4:"Nana";s:14:"postal_address";s:17:"1123 Rue cardenas";s:11:"postal_code";s:5:"15896";s:5:"ville";s:8:"Yaoundé";s:7:"fix_tel";s:10:"6454164815";s:10:"mobile_tel";s:11:"64816816511";s:9:"ohter_tel";s:0:"";s:10:"profession";s:5:"Marin";}', '2015-08-17 19:56:01', 'cafrintel', 1, 'FR', 1, 0),
(3, '2015-10-11 11:04:59', 'mbidalucalfred@yahoo.fr', '1e45aaae5e357dfbab6f453112d0bc5d5e10d0ed', '', 1, 'a:10:{s:6:"gender";s:2:"M.";s:6:"prenom";s:10:"Luc Alfred";s:3:"nom";s:5:"MBIDA";s:14:"postal_address";s:17:"1123 Rue cardenas";s:11:"postal_code";s:5:"15896";s:5:"ville";s:8:"Yaoundé";s:7:"fix_tel";s:10:"6454164815";s:10:"mobile_tel";s:11:"64816816511";s:9:"ohter_tel";s:0:"";s:10:"profession";s:13:"Informaticien";}', '2015-10-08 06:57:13', 'cafrintel', 1, 'FR', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `membre_groups`
--

CREATE TABLE IF NOT EXISTS `membre_groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  PRIMARY KEY (`group_id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `url`
--

CREATE TABLE IF NOT EXISTS `url` (
  `page` varchar(200) NOT NULL,
  `id_url` int(11) NOT NULL AUTO_INCREMENT,
  `date_add` date NOT NULL,
  `date_upd` date NOT NULL,
  `baniere` varchar(512) NOT NULL,
  PRIMARY KEY (`id_url`),
  UNIQUE KEY `page` (`page`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Contenu de la table `url`
--

INSERT INTO `url` (`page`, `id_url`, `date_add`, `date_upd`, `baniere`) VALUES
('connexion', 1, '2015-08-08', '2015-08-10', ''),
('mon-compte', 2, '2015-08-09', '2015-08-10', ''),
('services', 3, '2015-08-09', '2015-08-10', ''),
('agenda', 4, '2015-08-09', '2015-08-10', ''),
('cms-article', 5, '2015-08-09', '2015-08-10', ''),
('cms-category', 6, '2015-08-09', '2015-08-10', ''),
('formations', 7, '2015-08-09', '2015-10-22', '2210201520033013841911ml.jpg'),
('annuaire', 8, '2015-08-09', '2015-08-12', ''),
('contact', 9, '2015-08-11', '2015-08-11', ''),
('accept-paiement', 10, '2015-10-07', '2015-10-07', ''),
('cancel-paiement', 11, '2015-10-07', '2015-10-07', ''),
('ipn-paiement', 12, '2015-10-10', '2015-10-10', ''),
('cipn-paiement', 13, '2015-10-10', '2015-10-10', ''),
('accueil', 14, '2015-10-22', '2015-10-22', ''),
('staff', 15, '2015-12-02', '2015-12-02', '');

-- --------------------------------------------------------

--
-- Structure de la table `url_lang`
--

CREATE TABLE IF NOT EXISTS `url_lang` (
  `id_url` int(11) NOT NULL,
  `id_lang` int(11) NOT NULL,
  `name` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `url` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id_url`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `url_lang`
--

INSERT INTO `url_lang` (`id_url`, `id_lang`, `name`, `url`) VALUES
(1, 1, 'connexion', 'connexion'),
(1, 3, 'connexion', 'connexion'),
(2, 1, 'Mon compte', 'mon-compte'),
(2, 3, 'my account', 'my-account'),
(3, 1, 'Nos services', 'nos-services'),
(3, 3, 'Ours services', 'ours-services'),
(4, 1, 'Agenda', 'agenda'),
(4, 3, 'Agenda', 'agenda'),
(5, 1, 'article', 'article'),
(5, 3, 'content', 'content'),
(6, 1, 'categorie', 'categorie'),
(6, 3, 'category', 'category'),
(7, 1, 'Nos formations', 'nos-formations'),
(7, 3, 'Ours Formations', 'ours-formations'),
(8, 1, 'Annuaire Business to Businness', 'annuaire-business-to-businness'),
(8, 3, 'Business to Business Directory', 'business-to-business-directory'),
(9, 1, 'Nous contacter', 'nous-contacter'),
(9, 3, 'Contact us', 'contact-us'),
(10, 1, 'accept-paiement', 'accept-paiement'),
(10, 3, 'accept-paiement', 'accept-paiement'),
(11, 1, 'cancel-paiement', 'cancel-paiement'),
(11, 3, 'cancel-paiement', 'cancel-paiement'),
(12, 1, 'ipn-paiement', 'ipn-paiement'),
(12, 3, 'ipn-paiement', 'ipn-paiement'),
(13, 1, 'cipn-paiement', 'cipn-paiement'),
(13, 3, 'cipn-paiement', 'cipn-paiement'),
(14, 1, 'accueil', 'accueil'),
(14, 3, 'home', 'home'),
(15, 1, 'staff', 'staff'),
(15, 3, 'staff', 'staff');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
