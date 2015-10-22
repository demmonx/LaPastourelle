-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Serveur: 127.0.0.1
-- Généré le : Mar 05 Avril 2011 à 16:01
-- Version du serveur: 5.1.54
-- Version de PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `pastourebd1`
--

-- --------------------------------------------------------

--
-- Structure de la table `actualite`
--

CREATE TABLE IF NOT EXISTS `actualite` (
  `act_type` varchar(30) NOT NULL,
  `lang` varchar(2) NOT NULL DEFAULT 'fr',
  `act_lieu` varchar(50) NOT NULL,
  `act_date` varchar(10) NOT NULL,
  `act_heure` varchar(5) NOT NULL,
  `act_txt` text NOT NULL,
  `act_img` int(4) DEFAULT NULL,
  PRIMARY KEY (`act_type`,`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `actualite`
--

INSERT INTO `actualite` (`act_type`, `lang`, `act_lieu`, `act_date`, `act_heure`, `act_txt`, `act_img`) VALUES
('danse', 'es', 'TOULOUSE', '19/03/2010', '10H00', 'test2danseES', 23),
('danse', 'fr', 'TOULOUSE', '20/03/2010', '20H00', 'testFRdanse', 23),
('theatre', 'es', 'TOULOUSE', '17/03/2010', '8H00', 'test1theatreES', 22),
('theatre', 'fr', 'TOULOUSE', '21/03/2010', '21H00', 'testFRthea', 22);

-- --------------------------------------------------------

--
-- Structure de la table `annuaire`
--

CREATE TABLE IF NOT EXISTS `annuaire` (
  `pseudo` varchar(30) NOT NULL,
  PRIMARY KEY (`pseudo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `annuaire`
--

INSERT INTO `annuaire` (`pseudo`) VALUES
('Agathe'),
('allocmomo'),
('Anaïs'),
('ANNETTE'),
('Anto'),
('Audrey'),
('Babeth'),
('bourniquet'),
('caroline'),
('Christine'),
('David'),
('DELPHINE'),
('do12'),
('Domi'),
('domit'),
('Estelle'),
('frisou12'),
('Gégé'),
('géraldine'),
('gus'),
('HELENE'),
('hugulu12'),
('jaqouille'),
('JOJO'),
('jupastou'),
('Karine'),
('kinou'),
('laura.b'),
('laure'),
('marieclaire'),
('maya'),
('mimi'),
('mimicut12'),
('nico'),
('nini'),
('ondes12'),
('quentin'),
('Roger'),
('Sophie'),
('tacha'),
('tofe'),
('vince'),
('Yannick'),
('yoann'),
('Zoé');

-- --------------------------------------------------------

--
-- Structure de la table `boutique`
--

CREATE TABLE IF NOT EXISTS `boutique` (
  `pd_num` int(2) NOT NULL AUTO_INCREMENT,
  `lang` varchar(2) NOT NULL DEFAULT 'fr',
  `pd_prix` float(4,2) NOT NULL,
  `pd_img` int(4) NOT NULL,
  `pd_txt` int(4) NOT NULL,
  `pd_nom` varchar(30) NOT NULL,
  PRIMARY KEY (`pd_num`,`lang`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `boutique`
--

INSERT INTO `boutique` (`pd_num`, `lang`, `pd_prix`, `pd_img`, `pd_txt`, `pd_nom`) VALUES
(1, 'es', 10.00, 1, 1, 'Traduction non faite\r\n'),
(1, 'fr', 10.00, 1, 1, 'CD de musique'),
(2, 'es', 5.00, 2, 2, 'Traduction non faite\r\n'),
(2, 'fr', 5.00, 2, 2, 'K7 audio'),
(3, 'es', 2.00, 3, 3, 'Traduction non faite\r\n'),
(3, 'fr', 2.00, 3, 3, 'Boîte de bonbons'),
(4, 'es', 2.00, 4, 4, 'Traduction non faite\r\n'),
(4, 'fr', 2.00, 4, 4, 'Règle'),
(5, 'es', 2.00, 5, 5, 'Traduction non faite\r\n'),
(5, 'fr', 2.00, 5, 5, 'Stylo'),
(6, 'es', 2.00, 6, 6, 'Traduction non faite\r\n'),
(6, 'fr', 2.00, 6, 6, 'Magnet Pastourelle'),
(7, 'es', 2.00, 7, 7, 'Traduction non faite\r\n'),
(7, 'fr', 2.00, 7, 7, 'Porte-Clé Pastourelle');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE IF NOT EXISTS `commentaire` (
  `id_commentaire` int(5) NOT NULL AUTO_INCREMENT,
  `texte` varchar(500) NOT NULL,
  `num_photo` int(5) NOT NULL,
  `auteur` varchar(25) NOT NULL,
  PRIMARY KEY (`id_commentaire`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=235 ;

--
-- Contenu de la table `commentaire`
--

INSERT INTO `commentaire` (`id_commentaire`, `texte`, `num_photo`, `auteur`) VALUES
(233, 'Hum, Une bonne soupe aux fromages. Mais il est où?', 296, 'Karine');

-- --------------------------------------------------------

--
-- Structure de la table `coordonnees`
--

CREATE TABLE IF NOT EXISTS `coordonnees` (
  `coord_adr` text,
  `coord_mail` varchar(40) DEFAULT NULL,
  `coord_tel` varchar(10) DEFAULT NULL,
  `coord_img` int(4) NOT NULL,
  `coord_num` int(2) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`coord_num`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `coordonnees`
--

INSERT INTO `coordonnees` (`coord_adr`, `coord_mail`, `coord_tel`, `coord_img`, `coord_num`) VALUES
('Groupe Folklorique La Pastourelle de Rodez \r\nImmeuble des Sociétés Musicales - Avenue de l''Europe - 12000 RODEZ ', 'pastourelle.rodez@yahoo.fr', '0565759528', 9, 1);

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `img_num` int(11) NOT NULL AUTO_INCREMENT,
  `img_page` varchar(30) NOT NULL DEFAULT '',
  `img_adr` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`img_num`,`img_page`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Contenu de la table `image`
--

INSERT INTO `image` (`img_num`, `img_page`, `img_adr`) VALUES
(1, 'boutique', './image/boutique/48760_cd.JPG'),
(1, 'danse', 'image/danse/danse1.jpg'),
(1, 'ecole', 'image/ecole/ecole1.jpg'),
(1, 'historique', 'image/historique/histo1.jpg'),
(1, 'lien', 'image/lien/fatp-cmc.gif'),
(1, 'revue_presse', './image/revue_presse/16897_La depeche.jpg'),
(1, 'theatre', 'image/theatre/theatre1.jpg'),
(2, 'boutique', './image/boutique/24156_k7 [320x200].jpg'),
(2, 'danse', 'image/danse/danse2.jpg'),
(2, 'ecole', 'image/ecole/ecole2.jpg'),
(2, 'historique', 'image/historique/histo2.jpg'),
(2, 'lien', 'image/lien/festival.jpg'),
(2, 'revue_presse', './image/revue_presse/39792_guy5.jpg.JPG'),
(2, 'theatre', 'image/theatre/theatre2.jpg'),
(3, 'boutique', './image/boutique/49721_IMG_0266.JPG'),
(3, 'danse', 'image/danse/danse3.jpg'),
(3, 'ecole', 'image/ecole/ecole3.jpg'),
(3, 'historique', 'image/historique/histo3.jpg'),
(3, 'revue_presse', './image/revue_presse/27213_1-Le Levezou.jpg'),
(3, 'theatre', 'image/theatre/theatre3.jpg'),
(4, 'boutique', './image/boutique/36407_regle boutique2.jpg'),
(4, 'danse', 'image/danse/danse4.jpg'),
(4, 'ecole', 'image/ecole/ecole4.jpg'),
(4, 'historique', 'image/historique/histo4.jpg'),
(4, 'lien', 'image/lien/rodez.jpg'),
(4, 'revue_presse', './image/revue_presse/32528_guy.jpg'),
(4, 'theatre', 'image/theatre/theatre4.jpg'),
(5, 'boutique', './image/boutique/1763_stylo boutique.jpg'),
(5, 'danse', 'image/danse/danse5.jpg'),
(5, 'historique', 'image/historique/histo5.jpg'),
(5, 'lien', 'image/lien/grand-rodez.jpg'),
(5, 'revue_presse', './image/revue_presse/5_article fev 2010.JPG'),
(5, 'theatre', 'image/theatre/theatre5.jpg'),
(6, 'boutique', './image/boutique/19531_magnet pastourelle.jpg'),
(6, 'danse', 'image/danse/danse6.jpg'),
(6, 'lien', 'image/lien/Urpicha-Perou.png'),
(6, 'revue_presse', './image/revue_presse/29511_rignac la depeche.JPG'),
(6, 'theatre', 'image/theatre/theatre6.jpg'),
(7, 'boutique', './image/boutique/24998_porte cle.jpg'),
(7, 'lien', 'image/lien/cg12.jpg'),
(7, 'revue_presse', './image/revue_presse/43885_ste radegonde.jpg'),
(8, 'lien', './image/lien/23850_logo iut.jpg'),
(9, 'boutique', './image/boutique/46806_boutonsuiv.png'),
(9, 'coordonnees', 'image/coordonnees/plan.jpg'),
(22, 'actualite', 'image/actualite/theatre.jpg'),
(23, 'actualite', 'image/actualite/danse.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `lien_ext`
--

CREATE TABLE IF NOT EXISTS `lien_ext` (
  `id` int(11) NOT NULL,
  `lang` varchar(2) NOT NULL DEFAULT 'fr',
  `lien` varchar(50) NOT NULL DEFAULT '',
  `lien_img` int(4) NOT NULL,
  `lien_txt` int(4) NOT NULL,
  `lien_nom` varchar(150) NOT NULL,
  PRIMARY KEY (`id`,`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `lien_ext`
--

INSERT INTO `lien_ext` (`id`, `lang`, `lien`, `lien_img`, `lien_txt`, `lien_nom`) VALUES
(1, 'es', 'http://urpichaperu.over-blog.com/', 6, 6, 'Traduction non faite\r\n'),
(1, 'fr', 'http://urpichaperu.over-blog.com/', 6, 6, 'Association Urpicha-Pérou'),
(2, 'es', 'http://www.cg12.fr/', 7, 7, 'Traduction non faite\r\n'),
(2, 'fr', 'http://www.cg12.fr/', 7, 7, 'Conseil Général'),
(5, 'es', 'http://www.fatp-cmc.com/', 1, 1, 'Traduction non faite\r\n'),
(5, 'fr', 'http://www.fatp-cmc.com/', 1, 1, 'FDATPCMC'),
(6, 'es', 'http://www.festival-rouergue.com', 2, 2, 'Traduction non faite\r\n'),
(6, 'fr', 'http://www.festival-rouergue.com', 2, 2, 'F.F.I.R.'),
(8, 'es', 'http://www.grand-rodez.com/', 5, 5, 'Traduction non faite\r\n'),
(8, 'fr', 'http://www.grand-rodez.com/', 5, 5, 'Grand Rodez'),
(10, 'es', 'http://www.iut-rodez.fr', 8, 8, 'Traduction non faite\r\n'),
(10, 'fr', 'http://www.iut-rodez.fr', 8, 8, 'IUT de Rodez'),
(11, 'es', 'http://www.mairie-rodez.fr/', 4, 4, 'Traduction non faite\r\n'),
(11, 'fr', 'http://www.mairie-rodez.fr/', 4, 4, 'Ville de Rodez');

-- --------------------------------------------------------

--
-- Structure de la table `livreor`
--

CREATE TABLE IF NOT EXISTS `livreor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `nom` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `confirm` int(1) NOT NULL DEFAULT '0',
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Contenu de la table `livreor`
--

INSERT INTO `livreor` (`id`, `date`, `nom`, `message`, `confirm`) VALUES
(6, '2011-03-24', '', 'Coucou', 1),
(10, '2011-03-24', '', 'dsfghjsdfghj', 1),
(13, '2011-03-24', 'Pierre', 'test', 1),
(14, '2011-03-24', 'Yohan', 'test', 1);

-- --------------------------------------------------------

--
-- Structure de la table `logocarte`
--

CREATE TABLE IF NOT EXISTS `logocarte` (
  `continent` varchar(2) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `logocarte`
--

INSERT INTO `logocarte` (`continent`, `x`, `y`) VALUES
('AS', 512, 212),
('AS', 429, 167),
('EU', 150, 231),
('AS', 224, 387),
('EU', 316, 160),
('AS', 63, 102),
('AS', 275, 246);

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

CREATE TABLE IF NOT EXISTS `photo` (
  `id_photo` int(4) NOT NULL AUTO_INCREMENT,
  `adr_photo` varchar(50) NOT NULL,
  `date_photo` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id_photo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=300 ;

--
-- Contenu de la table `photo`
--

INSERT INTO `photo` (`id_photo`, `adr_photo`, `date_photo`, `description`) VALUES
(297, './image/blog/28208_groupe ste radegonde2.jpg', '2011-03-13 11:43:41', 'TOUJOURS DES SOUVENIRS\r\n'),
(298, './image/blog/24372_groupe ste radegonde2.jpg', '2011-03-13 11:43:50', 'TOUJOURS DES SOUVENIRS\r\n'),
(293, './image/blog/35006_groupe ste radedonde.jpg', '2011-03-13 11:38:38', ''),
(296, './image/blog/9094_ste radegonde michel.jpg', '2011-03-13 11:42:17', '');

-- --------------------------------------------------------

--
-- Structure de la table `planning`
--

CREATE TABLE IF NOT EXISTS `planning` (
  `pl_jour` varchar(10) NOT NULL,
  `pl_date` varchar(10) NOT NULL,
  `pl_lieu` varchar(100) NOT NULL,
  `pl_musiciens` varchar(150) NOT NULL,
  PRIMARY KEY (`pl_date`,`pl_lieu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `planning`
--

INSERT INTO `planning` (`pl_jour`, `pl_date`, `pl_lieu`, `pl_musiciens`) VALUES
('Samedi', '2011/02/12', 'Théâtre à Laguiole', '---------------------------'),
('Samedi', '2011/02/19', 'Répétition', 'Guillaume et Zoé'),
('Dimanche', '2011/02/20', 'MAGRIN : Danses et Théâtre', '---------------------------'),
('Samedi', '2011/03/19', 'Toulouse : Marché Aveyronnais', '---------------------------'),
('Samedi', '2011/03/26', 'Répétition', 'Jean-Marc et Zoé'),
('Dimanche', '2011/04/03', 'Sébazac (La Doline) : Danses pour les anciens', '---------------------------'),
('Samedi', '2011/04/09', 'Répétition', 'Guillaume et Michel'),
('Dimanche', '2011/04/10', 'St Laurent d''Olt - Danses Maisons de retraite', '---------------------------'),
('Samedi', '2011/04/23', 'Danses aux Peyrières', '---------------------------'),
('Vendredi', '2011/04/29', 'Danses aux Peyrières', '---------------------------'),
('Samedi', '2011/04/30', 'Répétition', 'Joël et Zoé'),
('la', '2011/05/03', 'icila', 'ché plus moi...'),
('Dimanche', '2011/05/08', 'Danses aux Peyrières', '---------------------------'),
('Vendredi', '2011/05/13', 'Danses aux Peyrières', '---------------------------'),
('Samedi', '2011/05/14', 'Répétition', 'Jean-Marc et Michel'),
('Mercredi', '2011/05/18', 'Danses aux Peyrières', '---------------------------'),
('Jeudi', '2011/05/26', 'Danses aux Peyrières', '---------------------------'),
('Samedi', '2011/05/28', 'MJC : Danses et Théâtre', '---------------------------'),
('Samedi', '2011/06/04', 'COMPOLIBAT : animation mariage', '---------------------------'),
('Dimanche', '2011/06/05', 'Danses aux Peyrières', '---------------------------'),
('Vendredi', '2011/06/10', 'Danses aux Peyrières', '---------------------------'),
('Samedi', '2011/06/18', 'Danses aux Peyrières', '---------------------------'),
('Dimanche', '2011/06/19', 'Maison de retraite St Cyrice : Théâtre', '---------------------------'),
('Vendredi', '2011/06/24', 'Danses aux Peyrières', '---------------------------'),
('Mercredi', '2011/06/29', 'Danses aux Peyrières', '---------------------------'),
('Samedi', '2011/07/02', 'Répétition', '---------------------------'),
('Samedi', '2011/07/02', 'St CHRISTOPHE : Danses et théâtre à 15h00', '---------------------------'),
('Dimanche', '2011/07/03', 'Danses aux Peyrières', '---------------------------'),
('Vendredi', '2011/07/08', 'Danses aux Peyrières', '---------------------------'),
('Samedi', '2011/07/16', 'PONTIVY : Danses', '---------------------------'),
('Dimanche', '2011/07/17', 'PONTIVY : Danses', '---------------------------'),
('Vendredi', '2011/07/22', 'AMBERT Festival', '---------------------------'),
('Samedi', '2011/07/23', 'AMBERT Festival', '---------------------------'),
('Dimanche', '2011/07/24', 'AMBERT Festival', '---------------------------'),
('Samedi', '2011/07/30', 'BEGAAR (Landes)', '---------------------------'),
('Dimanche', '2011/07/31', 'BEGAAR (Landes)', '---------------------------'),
('Dimanche', '2011/08/21', 'RIVIERE DE RIEUPEYROUX : Théâtre', '---------------------------'),
('Samedi', '2011/08/27', 'Danses aux Peyrières', '---------------------------'),
('Vendredi', '2011/09/02', 'Danses aux Peyrières', '---------------------------'),
('Dimanche', '2011/09/04', 'Danses aux Peyrières', '---------------------------'),
('Vendredi', '2011/09/09', 'Danses aux Peyrières', '---------------------------'),
('Lundi', '2011/09/12', 'Danses aux Peyrières', '---------------------------'),
('Lundi', '2011/09/19', 'Danses aux Peyrières', '---------------------------'),
('Vendredi', '2011/09/30', 'Danses aux Peyrières', '---------------------------'),
('Jeudi', '2011/10/06', 'Danses aux Peyrières', '---------------------------'),
('Vendredi', '2011/10/14', 'Danses aux Peyrières', '---------------------------');

-- --------------------------------------------------------

--
-- Structure de la table `revue_presse`
--

CREATE TABLE IF NOT EXISTS `revue_presse` (
  `num_presse` int(4) NOT NULL AUTO_INCREMENT,
  `presse_img` int(4) NOT NULL,
  `presse_txt` int(4) NOT NULL,
  PRIMARY KEY (`num_presse`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `revue_presse`
--

INSERT INTO `revue_presse` (`num_presse`, `presse_img`, `presse_txt`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5),
(6, 6, 6),
(7, 7, 7);

-- --------------------------------------------------------

--
-- Structure de la table `texte`
--

CREATE TABLE IF NOT EXISTS `texte` (
  `txt_num` int(4) NOT NULL,
  `txt_page` varchar(30) NOT NULL,
  `lang` varchar(2) NOT NULL DEFAULT 'fr',
  `texte` longtext NOT NULL,
  PRIMARY KEY (`txt_num`,`txt_page`,`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `texte`
--

INSERT INTO `texte` (`txt_num`, `txt_page`, `lang`, `texte`) VALUES
(0, 'accueil', 'es', 'Traduction non faite\r\n'),
(0, 'accueil', 'fr', 'NOUS VOIR PROCHAINEMENT\r\n'),
(0, 'avis', 'es', 'Traduction non faite'),
(0, 'avis', 'fr', 'AVIS'),
(0, 'boutique', 'es', 'Traduction non faite'),
(0, 'boutique', 'fr', 'LA BOUTIQUE'),
(0, 'coordonnees', 'es', 'Traduction non faite'),
(0, 'coordonnees', 'fr', 'NOUS CONTACTER'),
(0, 'danse', 'es', 'Traduction non faite'),
(0, 'danse', 'fr', 'LES DANSES'),
(0, 'ecole', 'es', 'Traduction non faite'),
(0, 'ecole', 'fr', 'LES ECOLES DE DANSES'),
(0, 'historique', 'es', 'Traduction non faite'),
(0, 'historique', 'fr', 'HISTORIQUE'),
(0, 'lien', 'es', 'Traduction non faite'),
(0, 'lien', 'fr', 'LES AMIS DE LA PASTOURELLE'),
(0, 'revue_presse', 'es', 'Traduction non faite'),
(0, 'revue_presse', 'fr', 'LES REVUES DE PRESSE'),
(0, 'theatre', 'es', 'Traduction non faite'),
(0, 'theatre', 'fr', 'LE THEATRE'),
(1, 'boutique', 'es', 'Traduction non faite\r\n'),
(1, 'boutique', 'fr', '19 titres en musiques et chants au son du Rouergue'),
(1, 'danse', 'es', 'Traduction non faite\r\n'),
(1, 'danse', 'fr', 'Le groupe folklorique LA PASTOURELLE DE RODEZ fondé en 1947 par Messieurs Fernand BENOIT, Edouard CHAPOT et Jean GUITARD a pour but de rechercher et de conserver tout ce qui touche au folklore rouergat : musiques, chants, danses, costumes et coutumes.\r\n\r\n\r\n«LA PASTOURELLE» a inscrit a son répertoire la plupart des vieilles danses du Rouergue dont un certain nombre parmi les plus simples sont encore pratiquées au cours des fêtes villageoises : les polkas, les scottishs, la valse vienne, les valses et bien sûr la  bourrée.\r\n\r\n\r\nLa plupart des danses effectuées consistent en un jeu de séduction où le cavalier poursuit sa cavalière dans de rapides mouvements croisés et parfois lui donne la main ou l’enlace pour un mouvement en ronde. La bourrée demande aux danseurs beaucoup de souplesse, un sens du rythme et un joli entrain par les sourires des cavalières auxquels répondent les vibrants «OHUES» des cavaliers.\r\n\r\nA ce jour le groupe compte 44 danseurs adultes, 4 musiciens et 18 enfants,tous bénévoles.   \r\n\r\n\r\nToujours le même pas sur une mesure à trois temps, la danse est accompagnée de l’accordéon et de la cabrette.\r\n\r\nLa Cabrette est un instrument de musique typiquement régional. Elle est composée d’un sac fait en peau de chèvre et recouvert de velours, qui est à l’origine de son nom (cabrette : petite chèvre). Cette poche est alimentée en air par un soufflet que «le cabrétaïre» tient sous son bras droit. Par pression de son bras gauche, le musicien comprime l’entrée. Le son est produit par une flûte à sept trous.\r\n\r\n\r\nLe costume est celui des dimanches et fêtes, porté vers 1860 – 1880.\r\n\r\nLes femmes sont coiffées d’une bonnette en dentelle recouvert d’un chapeau de paille. Elles portent un corsage à basque, manches courtes avec dentelle. Une jupe relevée sur le côté gauche laisse entrevoir un large jupon blanc qui cache le long panty. Les bas sont blancs, les souliers noirs. Pour finir elles ont sur les épaules une pointe en fine dentelle.\r\n\r\n\r\nLes hommes sont coiffés du chapeau de feutre noir à large bord. Ils portent une blouse noire brodée, un pantalon rayé en drap de pays, les chaussettes sont blanches et les souliers noirs. Pour finir un foulard aux couleurs vives se noue autour du cou.\r\n\r\n\r\nLe costume des enfants est différent de celui de leurs parents.\r\nLes jeunes filles ont un noeud blanc dans les cheveux. Elles portent une robe manches longues et une large ceinture boutonnée et nouée dans le dos. Le fond de la robe est constitué de plis qui sont lachés au fur et à mesure que l''enfant grandit.\r\nPour compléter la tenue, les filles mettent un panty, des chaussettes blanches et une paire de chaussures noires fermées.\r\n\r\n\r\nLes garçons sont vêtus d''une blouse noire ou d''un gilet sur une chemise blanche à manches longues. Un pantalon noir bouffant aux genoux, des chaussettes blanches et des chaussures noires complètent le costume.\r\n\r\n\r\n\r\n\r\n\r\n\r\nNos prestations sont les suivantes : \r\n\r\n-	Spectacle danses (de 1h00 à 1h15)\r\n-	Animation (40 min maximum)\r\n-	Défilé\r\n-	Spectacle danses et théâtre (de 2h00 à 2h30)\r\n\r\nPour une demande de devis vous pouvez nous contacter en allant à la rubrique : CONTACT – Nos coordonnées.\r\n'),
(1, 'ecole', 'es', 'Traduction non faite\r\n\r\n'),
(1, 'ecole', 'fr', 'La Pastourelle de Rodez dirige deux Ecoles de danses : l''Ecole des Enfants et l''Ecole des Adultes.\r\n\r\n\r\n\r\nL''Ecole des enfants accueille les petits dès l''âge de 6 ans. A raison d''une heure par semaine, environ 30 jeunes apprennent le pas, puis quelques bourrées élaborées. En fin d''année et au travers des danses apprises, les enfants vont présenter un spectacle de danses lors de la traditionnelle soirée à la Maison des Jeunes et de la Culture de Rodez, permettant ainsi de clôturer l''année et montrer les progrès réalisés. Pour quelques uns c''est le premier contact avec la scène et surtout avec le public : moment fort et plein d''émotions pour les enfants, parents et aussi l''encadrement qui reçoit ici la pleine satisfaction du travail accompli durant l''année.\r\n\r\nECOLE DE DANSES DES ENFANTS\r\nImmeuble des Sociétés Musicales\r\nAvenue de l''Europe \r\n12000 RODEZ\r\n\r\nCours : De septembre à juin - tous les vendredi soir à partir de 20h30 (sauf vacances scolaires)\r\n\r\n\r\n___________________________________________________________________________________________\r\n\r\n\r\n\r\nC''est à partir du premier mardi d''octobre que l''Ecole de danses des adultes vous accueille à partir de 21h00 tous les mardis soir. Jeunes et moins jeunes, débutants ou confirmés, viennent apprendre le pas de base, la valse, et de nombreuses bourrées. Accompagnée par des musiciens bénévoles désireux de partager un même plaisir, la musique, l''école de danse des grands est animée par des Pastoureaux dynamiques, toujours soucieux de transmettre les danses dans le plus grand respect de la tradition du folklore rouergat.\r\nBref, un moment chaleureux et convivial.\r\n\r\n                                    ECOLE DE DANSES ADULTES\r\n                                Centre Social des Quatre Saisons\r\n                                       Rue des Narcisses\r\n                                     12850 Onet-Le-Château\r\n\r\n\r\n                        Inscriptions à partir du 1er mardi d''octobre\r\n                   cours : tous les mardi de octobre à juin (sauf vacances scolaires) à 21h00\r\n\r\n'),
(1, 'historique', 'es', 'Traduction non faite\r\n\r\n\r\n'),
(1, 'historique', 'fr', 'Un Soir de mars 1947, Monsieur Fernand BENOIT et son ami Edouard CHAPOT se rencontrent place de la Cité à RODEZ.\r\n\r\nLe Premier fait part de son désir de fonder un groupe folklorique sur sa ville. Monsieur Edouard CHAPOT est emballé. Nous sommes au lendemain de la libération, il faut tout chercher, trouver, composer. Peu importe grâce au dynamisme et à la volonté des deux confidents ce véritable tour de maître est accompli. C’est d’ailleurs à ce moment là qu’un troisième acteur arrive à point nommé : Monsieur Jean GUITARD, accordéoniste de talent et passionné de folklore.\r\n\r\nAinsi fut crée le trio «B.C.G.». Ce sont leurs épouses, Mesdames Mauricette CHAPOT et Huguette GUITARD, amies d’enfance, qui vont se démener pour recruter filles et garçons passionnés de folklore.\r\n\r\nSifflotant l’air d’une chanson rouergate le nom du groupe est apparu comme une évidence, ce sera : LA PASTOURELLE DE RODEZ  (pastourelle : jeune bergère en occitan).\r\n\r\nAprès deux manifestations sur RODEZ et une suivante dans un village aveyronnais les statuts seront déposés en Préfecture en 1948. Le groupe est donc officiellement lancé.\r\n\r\nC’est au début des années 1950, après mûre réflexion, qu’un nouvel élan est donné à la PASTOURELLE DE RODEZ. En effet, c’est avec l’arrivé de Monsieur Adrien VEZINET que la section théâtre voit le jour. Il va diriger les danses tout en écrivant des pièces de théâtre avec la collaboration de Messieurs Henri MOULY et Jean-Marie LACOMBE.\r\n\r\nPoussés par l’amour  du folklore et le désir de franchir les frontières, le Docteur Jean AMANS, Maire de PONT DE SALARS, et Monsieur Fernand BENOIT, vont créer en 1954 le Festival Folklorique de PONT DE SALARS devenu aujourd’hui le Festival Folklorique International du Rouergue (F.F.I.R.).\r\n\r\nA 63 ans d’âge la PASTOURELLE DE RODEZ a toujours autant d’enthousiasme à perpétuer les traditions du folklore et de la langue d’oc. De l’Aubrac au Larzac, du Quercy au couffin de la Lozère, elle sait toujours intéresser un public aimant son terroir.\r\n\r\n\r\n'),
(1, 'lien', 'es', 'Traduction non faite\r\n'),
(1, 'lien', 'fr', 'Fédération des Arts et Traditions Populaires du\r\nCentre et du Massif Central\r\n\r\n'),
(1, 'revue_presse', 'es', 'Traduction non faite\r\n'),
(1, 'revue_presse', 'fr', 'LA DEPECHE DU MIDI du 26 octobre 2010\r\n\r\nCliquer sur la photo pour lire l''article'),
(1, 'theatre', 'es', 'Traduction non faite\r\n\r\n\r\n'),
(1, 'theatre', 'fr', 'La section théatre est composée d''une dizaine d''acteurs amateurs et bénévoles. Toutes les pièces sont jouées en langue d''Oc.\r\n\r\nDepuis les années 1950 dix pièces constituent le répertoire de La Pastourelle. Actuellement, cinq pièces vous sont proposées et une sixième est en préparation.\r\n\r\n\r\n - LA BASTARDA (Comédie en un acte d''Adrien VEZINET - durée : 1h30 environ)\r\nL''histoire se déroule au début du siècle dernier dans une cuisine de campagne, à la Gineste, propriété de Toéno et de sa femme, Irma. \r\nIrma n''a qu''une seule idée en tête, Lucéta, sa fille, doit épouser Pierre, le maître valet. Mais ce dernier est amoureux de Roséta, la servante : c''est une "bastarde". Imaginez un instant le moment où la mère et la fille vont apprendre la relation entre Pierre et Roséta, imaginez la tête de Toéno qui n''a qu''un seul souci : faire fructifier la ferme sans s''occuper de toutes ces histoires. Comment la maîtresse de maison et Palmira vont-elles s''y prendre pour relever cet affront ?\r\n\r\n\r\n- LA SOPA D''ALHS (pièce en "Lengua nostro" - auteur inconnu, reprise par Jean-Marie LACOMBE - durée 1h30 environ)\r\nNous sommes dans une maison paysanne après dîner. Berthe, maîtresse de maison, femme moustachue, a retroussé les manches , lave la vaisselle dans une bassine. Milien... la mine malade, est pâle, maigre. On voit qu''il est habitué...à pâtir et... à ne pas commander. Dehors, on entend dans le voisinage, Gustou, forgeron, le marteau à la main qui frappe sur l''enclume.\r\nVous allez vivre les péripéties d''un brave homme marié à une femme de caractère et particulièrement avare.\r\nCe que vous allez découvrir à travers une drôle de soupe, pas vraiment comme les autres...\r\n\r\n\r\n- VISTALHAS (comedie en un acte d''Adrien VEZINET - durée 1h20 environ)\r\nL''histoire se déroule vers les années 1920, chez Artémon de Gisquet, riche propriétaire de la ferme de la Grifolièra. Sa fille, Lineta, vient de se marier avec Gaston.\r\nPalmira, soeur d''Artémon, est toujours restée à la ferme. Victor, oncle de Gaston, est employé à la préfecture. Tous les deux ont déjà passé la quarantaine et sont célibataires. Linéta et Gaston songent à un possible mariage... et vont tout faire pour y parvenir.\r\nComment vont-ils s''y prendre pour faire accepter cette possible union à Artémon et à sa femme, Justine ? Imaginez la scène : le mari, paysan accroché aux vieux principes et détestant tous ces gratte-papiers de la ville, alors que Justine a toujours rêvé d''aller habiter en ville.\r\n\r\n\r\n- L''AUBERGE DE LAS TRES CATTOS (pièce en "Lengua nostro" de Jean-Marie LACOMBE - durée 1h30)\r\nL''action se passe dans une auberge de l''un de nos villages de l''Aveyron vers les années 1920 - 1930. Elle est tenue par trois vieilles filles : Philomène, Julie et Marinou, surnommées "Los Très Cattos", ayant chacune leur particularité...\r\n\r\n\r\n- LA TATA DE BORNIQUET (comédie en un acte de Henry MOULY et Adrien VEZINET - durée 1h20)\r\nL''histoire se passe dans une cuisine de campagne vers 1900. Jeanine, fille de Borniquet, est amoureuse de Robert.\r\nBorniquet et sa femme rejettent cette liaison. Pensez-donc ! Robert, un simple maître valet peut-il prétendre être accepté par ce couple, riche propriétaire terrien, qui ne vit que pour l''argent ? C''est sans compter sur un personnage clé : la Tata, qui ne va pas ménager ses efforts pour aider nos deux amoureux. Comment va-t-elle s''y prendre ? Réussira-t-elle à renverser la situation ?\r\n\r\n\r\n'),
(2, 'boutique', 'es', 'Traduction non faite\r\n'),
(2, 'boutique', 'fr', 'L''équivalent du CD\r\nau format K7'),
(2, 'lien', 'es', 'Traduction non faite\r\n'),
(2, 'lien', 'fr', 'Festival Folklorique International du Rouergue'),
(2, 'revue_presse', 'es', 'Traduction non faite\r\n'),
(2, 'revue_presse', 'fr', 'CENTRE PRESSE du 24 octobre 2010\r\n\r\nCliquer sur la photo pour lire l''article'),
(3, 'boutique', 'es', 'Traduction non faite\r\n'),
(3, 'boutique', 'fr', 'Boîte métallique contenant\r\ndes bonbons fruités'),
(3, 'lien', 'es', 'Traduction non faite\r\n'),
(3, 'revue_presse', 'es', 'Traduction non faite\r\n'),
(3, 'revue_presse', 'fr', '\r\n	\r\nLE GUIDE DE L''ETE 2010\r\nCentre Presse - Midi Libre\r\n\r\nCliquer sur la photo pour lire l''article'),
(4, 'boutique', 'es', 'Traduction non faite\r\n'),
(4, 'boutique', 'fr', 'Règle en plastique\r\nsouple aux couleurs\r\nde la Pastourelle'),
(4, 'lien', 'es', 'Traduction non faite\r\n'),
(4, 'lien', 'fr', 'Mairie de Rodez'),
(4, 'revue_presse', 'es', 'Traduction non faite\r\n'),
(4, 'revue_presse', 'fr', '\r\n	Hommage à Guy TEULIER\r\n\r\nL''ECHO DE LA FEDERATION - N°61 du 25 février 2010\r\n\r\nArticle : Joël REGOURD\r\n\r\nCliquez sur la photo pour lire l''article'),
(5, 'boutique', 'es', 'Traduction non faite\r\n'),
(5, 'boutique', 'fr', 'Stylo gris avec inscription :\r\n"La Pastourelle de Rodez"\r\nEcriture noire'),
(5, 'lien', 'es', 'Traduction non faite\r\n'),
(5, 'lien', 'fr', 'Communauté agglomération du Grand Rodez'),
(5, 'revue_presse', 'es', 'Traduction non faite\r\n'),
(5, 'revue_presse', 'fr', '	CENTRE PRESSE du 24 février 2010\r\n\r\nThéatre à Laguiole\r\n\r\nCliquez sur la photo pour lire l''article'),
(6, 'boutique', 'es', 'Traduction non faite\r\n'),
(6, 'boutique', 'fr', 'Pastille aimantée'),
(6, 'lien', 'es', 'Traduction non faite\r\n'),
(6, 'lien', 'fr', 'Association de loi 1901 qui accueille et\r\naccompagne des enfants et des jeunes en situation\r\nde risque, dans les zones défavorisées de la\r\nbanlieu de Lima.'),
(6, 'revue_presse', 'es', 'Traduction non faite\r\n'),
(6, 'revue_presse', 'fr', '\r\n	\r\nDanses et Théatre à Rignac\r\n\r\nLA DEPECHE DU MIDI du 21 février 2010\r\n\r\nCliquez sur la photo pour lire l''article'),
(7, 'boutique', 'es', 'Traduction non faite\r\n'),
(7, 'boutique', 'fr', 'Porte-Clé aux couleurs de la Pastourelle\r\nUne face Pastourelle, une face aux couleurs de la\r\nFrance'),
(7, 'lien', 'es', 'Traduction non faite\r\n'),
(7, 'lien', 'fr', 'Description perdue'),
(7, 'revue_presse', 'es', 'Traduction non faite\r\n'),
(7, 'revue_presse', 'fr', 'CENTRE PRESSE du 17 janvier 2010'),
(8, 'lien', 'es', 'Traduction non faite\r\n'),
(8, 'lien', 'fr', 'Institut Universitaire et Technologique de Rodez'),
(16, 'compte_rendu', 'fr', 'REUNION DU BUREAU DU 02 FÉVRIER 2011\r\n\r\nPrésents : Christophe, Hélène, Monique, Dominique, Christian, Sophie, Joël, Géraldine,\r\nKarine,\r\n\r\nAppeler la liste pour dire que le grand père (Mr LABIT) de Marion BERTRAND est décédé (enterrement Vendredi matin à 10h30 aux Sacré Cœur). Demander également pour le thé dansant de dimanche ( Présence et nombre de part de tartes)\r\n\r\nLes nouvelles sorties\r\n\r\n- Fénayrol le 19 Juin 2011, Danses\r\n- MJC changement de date, maintenant c’est le vendredi 27 mai 2011. Pour la location de la salle, au tarif il faut ajouter un coût pour le technicien et pour le surveillant de nuit. De ce fait augmentation du tarif de l’entrée à 6 € pour les adultes et 2 € pour les enfants de 3 à 12 ans.\r\n- Demande de la salle de la doline pour la nuit rouergate le 12 novembre 2011.\r\n\r\nDemande de Sponsor à David pour un coupe vent bleu ciel.\r\n\r\n\r\n\r\nPastourpicha,\r\n\r\nLe plus regardé pour la valise en soute c’est le poids (23 kg). Voir si on prend une cantine ou si tout passe en bagage. Demande pour partir avec une cantine gratuite pour but humanitaire , si une cantine est prise, elle restera là-bas.\r\nSophie , Tofe et Huguette vont faire les courses à Promocash.\r\n\r\nSortie de Magrin le 20 février 2011, la pièce de théâtre jouée sera la sopa d’ahls. Début du spectacle par les danses à 14h30 donc RDV à 13h.\r\n\r\n\r\nPour le 18 février au plus tard apporter tous les dons à la salle de répé. Dire la place en poids qu’il reste par bagage à Gégé afin que l’on puisse faire des sacs de dons en fonction du poids. RDV le samedi 19 février pour faire le tri à 14h.\r\n\r\nFESTIVAL\r\n\r\nLe groupe des jolivettes (Reims) ont répondu présents.\r\n\r\n\r\nProchaine réunion le Mercredi 30 Mars 2011\r\n');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `pseudo` varchar(30) NOT NULL DEFAULT '',
  `motdepasse` varchar(100) DEFAULT NULL,
  `niveau` varchar(20) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `etat_validation` int(1) DEFAULT NULL,
  `telephone` varchar(10) DEFAULT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `adresse` text NOT NULL,
  `etat_annuaire` int(1) NOT NULL,
  PRIMARY KEY (`pseudo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`pseudo`, `motdepasse`, `niveau`, `email`, `etat_validation`, `telephone`, `nom`, `prenom`, `adresse`, `etat_annuaire`) VALUES
('Agathe', '04f9835b456c8f5b42ad3611f1a8f68cbd09ddf9', 'membre', 'agathe.bodio.97@hotmail.fr', 1, '0565670297', 'BODIO', 'Agathe', '22 Camin de Cantaserp 12630 Agen d''Aveyron', 1),
('allocmomo', 'bc5eb067468f083f57b563dac863da1373f721d2', 'membre', 'monique.bozouls@orange.fr', 1, '0631694191', 'lemouzy', 'monique', '7 rue des alots\r\n12340 bozouls', 1),
('Anaïs', 'becb1b07b5e7418402924748493938777e4ce438', 'membre', 'anaism.coulon@laposte.net', 1, '0612530286', 'COULON', 'Anaïs', '19 bd Flaugergues\r\n12000 Rodez', 1),
('ANNETTE', '43c8e193d8c7482693d72e3690a5f9d4c22d63a2', 'membre', 'anne.dalbin@orange.fr', 1, '0565425698', 'DALBIN', 'ANNE', '19 RUE DU MARECHAL LECLERC BAT B\r\n12000 RODEZ', 1),
('Anto', '09cbca8e0a0a596d2801dc833e0a396b5f312ca1', 'membre', 'joel.regourd@orange.fr', 1, '0648120101', 'Regourd', 'Antonin', 'Le Gory\r\n12290\r\nLe Vibal', 1),
('Audrey', 'dd19a4f7fca949c9386dafc607b96f3f21f8db9d', 'membre', 'audreybouyssou@hotmail.fr', 1, '0684665016', 'BOUYSSOU', 'Audrey', 'Ruols\r\n12450 LUC', 1),
('Babeth', '49cbbb3befb61ba486f2b19370386602e3d83ebf', 'membre', 'elisabeth.redoules@orange.fr', 1, '0565673243', 'REDOULES', 'Elisabeth', '62 Avenue Tarayre\r\n12000 RODEZ', 1),
('bourniquet', 'af15ed551030904fae323c5e9792b0f3d77154c2', 'membre', 'gean12850@yahoo.fr', 1, '0565674384', 'laussel', 'gerard', 'istournet \r\nSte Radegonde\r\n12850', 1),
('caroline', 'd5d5ea4df398fe4e5d37c8923d8d3ef1aaba5b90', 'membre', 'caroline.chauzy@orange.fr', 1, '0683963430', 'CHAUZY', 'Caroline', 'Résidence Jean Mermoz, 9 place du Ségala, 12450 La Primaube', 1),
('Christine', 'f181eead32bdaa9604127d0ee41b203fa81edefc', 'membre', 'christine-m-12@hotmail.fr', 1, '0565421665', 'Marre', 'Christine', '610 av du Rouergue\r\n12000 Rodez', 1),
('cyrl', '01f85d40af914617881a0b35657a9af284b2171b', 'membre', 'vioulac.cyril@gmail.com', 1, '0647761343', 'VIOULAC', 'Cyril', 'route de Cassagnes Bégonhès', 0),
('David', '4e2dc2ebc1ba67133d3b6aa47843084ac5220f3b', 'membre', 'dbarrau@bourbon-invest.com', 1, '0692455490', 'BARRAU', 'David', 'Residence BABA FIGUE, Appt 3\r\n20 rue Macabit\r\n97434 Saint Gilles les Bains', 1),
('DELPHINE', 'a7962b5824eb124b99524b373bf130b4449c9dd7', 'membre', 'cathala.delphine@wanadoo.fr', 1, '0565724953', 'CATHALA', 'DELPHINE', 'TOIZAC\r\n12510 OLEMPS', 1),
('do12', '98fed91b7f28267338fd01dba3744a2aa1112299', 'membre', 'dorian.alibert@orange.fr', 1, '0678139849', 'ALIBERT', 'Dorian', 'Résidence les silenes,\r\nbat A appart 4 \r\n1 impasse des jardins\r\n12850 onet le chateau', 1),
('Domi', '43c5ea34d00c829f601d7f891ad1788f09f49b5b', 'membre', 'emilie.conquet@bbox.fr', 1, '0688845031', 'VERGNET', 'Dominique', '34 boulevard de Lattre de Tassigny\r\n12000 RODEZ', 1),
('domit', 'b9121bdf57d36a1e43b95c2212081e67fc89d125', 'membre', 'domitremo@hotmail.fr', 1, '0565779417', 'TREMOLIERES', 'DOMINIQUE', '3 LOT LE GARACEL\r\nLIOUJAS\r\n12740 LA LOUBIERE', 1),
('Estelle', 'e8089d7d7b58dbe71ef65886532269ee7061e4c8', 'membre', 'joel.regourd@orange.fr', 1, '0565468938', 'Regourd', 'Estelle', 'Le Gory \r\n12290\r\nLe Vibal', 1),
('frisou12', '158c1c837a526312d2e3c46fe0f569175a634961', 'membre', 'christian.puel@orange.fr', 1, '0565447929', 'puel', 'christian', 'les places\r\n12500 saint come d''olt', 1),
('Gégé', 'f98a66dd772a147c32cff9934791edbda811425f', 'membre', 'geraldine.foissac@sfr.fr', 1, '0581375626', 'FOISSAC', 'Géraldine', 'Saint Eloi III\r\nBâtiment L\r\n12000 RODEZ', 1),
('GEGE12', '8f6de928473ee47886e37f74cc1cace7e49ed0f8', 'administrateur', 'geraldine.foissac@sfr.fr', 1, '0581199295', 'FOISSAC', 'Géraldine', 'St Eloi\r\n12000 RODEZ', 0),
('Geoffrey', '57325820774f53905e1a3f9487b5bca6815ea7ec', 'administrateur', 'tofe12@free.fr', 1, '0505050505', 'MALAVAL', 'Geoffrey', 'inconnue', 0),
('géraldine', '2dc22d1bfab7efbf1c0f61219f4b540ddefe4df0', 'membre', 'geraldine.laporte@sfr.fr', 1, '0630827865', 'Laporte', 'Géraldine', '41 avenue du centre\r\n12160 Manhac', 1),
('gus', '781a02e9b49f7db08a7559067b093d22b6cfe257', 'membre', 'guillaume.a3@voila.fr', 1, '0681894783', 'fabre', 'guillaume', '1 impasse du cres', 1),
('HELENE', 'a114341c727b8896ddac4bb584db497e8bfafcb1', 'membre', 'jeanmarc.seguret@sfr.fr', 1, '0565743446', 'SEGURET', 'HELENE', 'LES FONTANELLES\r\n12290\r\nCANET DE SALARS', 1),
('hugulu12', '455bbee19b211ef316186a6478627a71afd1107e', 'membre', 'minsk12@wanadoo.fr', 1, '0563036451', 'varin', 'huguette', '668, avenue de beausoleil.\r\n82000 MONTAUBAN', 1),
('IUTprojet', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'administrateur', 'pierre.gaboriaud@gmail.com', 1, '0546958741', 'Patate', 'Pierre', '7 rue patate', 1),
('IUTprojet2', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'membre', 'fr2@fr.fr', 1, '0546859565', 'IUTprojet2', 'IUTprojet2', 'sfdghjk', 0),
('jaqouille', '2489772eddacb71a1b8e4f45d14512747419ea03', 'membre', 'jackmomo.savignac@sfr.fr', 1, '0565731196', 'SAVIGNAC', 'jacques', '8 rue des fleurs\r\n12000 RODEZ', 1),
('JOJO', '891c906c48f7a686ba53db39cfb37f6fbb2d6e14', 'membre', 'joel.regourd@orange.fr', 1, '0565468938', 'REGOURD', 'JOEL', 'LE GORY \r\n12290 LE VIBAL', 1),
('juespitali', 'b3f594e10a9edcf5413cf1190121d45078c62290', 'membre', 'ju11_25@hotmail.fr', 1, '0678639544', 'Espitalier', 'Julie', 'Agnac 12510 Druelle', 0),
('jupastou', 'a679b2dbc200249845a465768131cc2601e0a531', 'membre', 'jupastou@msn.com', 1, '0685062761', 'FAVIER', 'Julie', '5 rue de l''Eglise\r\n29200 BREST', 1),
('Karine', '0f777fbcbc9d14cf9a65e30d7a6961aa82dee485', 'membre', 'karinealcouffe@yahoo.fr', 1, '0565460401', 'ALCOUFFE', 'Karine', '1 Rue des Acacias\r\n12450 LA PRIMAUBE', 1),
('kinou', '43e2c7a71c61bbadca1d46be8db5efc21cbadaff', 'membre', 'christine@combemale.com', 1, '0565726492', 'combemale', 'christine', 'bauzeins\r\nbruéjouls\r\n12330 CLAIRVAUX', 1),
('laura.b', '9258a7360d0586e6d01612b40717932c34ae75f8', 'membre', 'lolo.italia@hotmail.fr', 1, '0565421561', 'BREGOU', 'laura', '7 cité la croux 12630 agen d''aveyron ', 1),
('laure', '92e636799168b673599f8b17f5652e066c8f5d29', 'membre', 'laure.hygonnet@hotmail.fr', 1, '0681664747', 'hygonnet', 'laure', '16 rue henri dunant\r\n12000 rodez', 1),
('marieclaire', 'cab99dd2d21455da24234973adf3e1ec720bcf6a', 'membre', 'mc_anglade@yahoo.fr', 1, '0688491134', 'FRANCOIS', 'Marie-Claire', '89 Rue PELLEPORT\r\n75020 PARIS', 1),
('marylou', '379e52ed9ef307fe9894364b91d5ee67a8aa859c', 'membre', '                      marie-helene.delso', 1, '0682361241', 'delsol', 'marie-helene', '6 route de Rodez 12330 St Christophe Vallon', 0),
('maya', 'b38d7ff278f16f2d2c2ee57cd8cb1d33f07c2101', 'membre', 'maya-vayssou@hotmail.fr', 1, '0630158921', 'Vaysse', 'Maïlys', '335 route saint ambroise, résidence le clos saint ambroise, appart20 bat B, 46000 Cahors', 1),
('michel', 'c32c0814e190f69839521a8c8b745fca73296858', 'membre', 'ginette.d12@orange.fr', 1, '0565724227', 'pouget', 'michel', 'ampiac\r\n12510 Druelle', 0),
('mimi', '105d89c5d8e3aca12a23e2226906d54987f22a89', 'membre', 'emiliepoux2@hotmail.fr', 1, '0675404934', 'Poux', 'Emilie', '3 rue de Paraire 12000 Rodez', 1),
('mimicut12', 'e1983919a69ce4a448263028cd667b57acdd975b', 'membre', 'michele.castellaci@free.fr', 1, '0565482046', 'caumeil', 'michele', 'le theron flaujac\r\n12500espalion', 1),
('nico', 'e4d3d3f0fce651d09aee5480ec5e58268ccc2409', 'membre', 'flo.nico@aliceadsl.fr', 1, '0565783820', 'volpelier', 'nicolas', '5 lot les combes hautes\r\n12130 st martin de lenne', 1),
('nini', '379477043d2167554e69863511117aa185fa3ffb', 'membre', 'cazou.claude@hotmail.fr', 1, '0565682853', 'cazes', 'nicole', 'cazes nicole les villas du manoir bat d no 45 12510 olemps', 1),
('ondes12', '4e993bb7b67cd71ab853d2312e3d1473383f6909', 'membre', 'bea.pat3@wanadoo.fr', 1, '0565673393', 'BERTRAND', 'Marion', '29 rue des Ondes\r\n12000 RODEZ', 1),
('quentin', 'af8978b1797b72acfff9595a5a2a373ec3d9106d', 'membre', 'eragon17@hotmail.fr', 1, '0642197768', 'verdier', 'quentin', 'istournet 12850 sainte radegonde', 1),
('richard', '6c27037c90d34b01dfd2d837f1c05258f3e4ed01', 'administrateur', NULL, 1, NULL, '', '', '', 0),
('Roger', 'c77b8f5c36fcfcd80f5d8bf0350930d98d76bfcf', 'membre', 'ro.bouyssou@wanadoo.fr', 1, '0608434624', 'BOUYSSOU', 'Roger', '15, rue du Bois de l''Ours\r\nRuols\r\n12450 LUC LA PRIMAUBE', 1),
('Sophie', '60ee2ae06a69182f02c75fd9fad8079b501920be', 'membre', 'sophie.bodio@wanadoo.fr', 1, '0565670297', 'BODIO', 'SOPHIE', '22 CAMIN DE CANTASERP\r\n12630 AGEN D''AVEYRON\r\n\r\n', 1),
('tacha', '593229a2563091ade6af3c5623a49e31a574ded1', 'membre', 'karine.mirmand@wanadoo.fr', 1, '0565770613', 'belet', 'natacha', '17 route de la croix de la garde 12850 ste radegonde', 1),
('tofe', '951909282c25644c18cc6cbe0eb94efb03de09ab', 'membre', 'tofe12@free.fr', 1, '0565429130', 'PAGES', 'Christophe', '13 Bis Route de la Vieille Gare\r\n12000 RODEZ\r\n', 1),
('TOFE12', '951909282c25644c18cc6cbe0eb94efb03de09ab', 'administrateur', 'tofe12@free.fr', 1, '0565429130', 'Christophe', 'PAGES', '13 bis route de la vieille gare\r\n12000 RODEZ', 0),
('vince', '299d236668bc0cfb993ea42910fa2f4d6b1dfffe', 'membre', 'v.scudier@spie.com', 1, '0675054873', 'SCUDIER', 'Vincent', 'La Baraque de Turq\r\n12740 La Loubiere', 1),
('Yannick', '9c8b5aa1eb750d6df8081250d665496c37834715', 'membre', 'joel.regourd@orange.fr', 1, '0565468938', 'Regourd', 'Yannick', 'Le Gory \r\n12290\r\nLe VIBAL', 1),
('yoann', 'e7e703d4b285948b70525aca694367f70fb70bb5', 'membre', 'monteillet.beatrice@orange.fr', 1, '0687695531', 'bousquet', 'yoann', '9 allee des ormeaux \r\nles bastides\r\n12510 druelle\r\n', 1),
('Zoé', '548871096bc73803d820d013b7ccec22c9996988', 'membre', 'nicolas.minic@orange.fr', 1, '0565671637', 'NOGUES', 'Eliane', '18 rue des Cyclamens\r\n12850 ONET LE CHATEAU', 1);
