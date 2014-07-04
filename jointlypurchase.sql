-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 26. Jun 2014 um 22:11
-- Server Version: 5.6.16
-- PHP-Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `jointlypurchase`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `einkaufslisten`
--

CREATE TABLE IF NOT EXISTS `einkaufslisten` (
  `userID` int(11) NOT NULL,
  `listName` varchar(45) NOT NULL,
  `listID` varchar(255) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(24) NOT NULL,
  PRIMARY KEY (`id`)
-- ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=161 ;
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `einkaufslisten`
--

/*INSERT INTO `einkaufslisten` (`userID`, `listName`, `listID`, `id`, `date`) VALUES
(60, '123', '0ffb8460d08197d28aaf795711fc8f65', 139, '01.05.2014 - 02:18'),
(60, 'fdf', '3e217225db245e7285eb3f12bf0dd172', 140, '01.05.2014 - 02:18'),
(60, 'gfgf', 'f4f451881ba63dd33e30ddc621fc3c43', 141, '01.05.2014 - 02:18'),
(59, '123', 'd9dbc51dc534921589adf460c85cd824', 142, '01.05.2014 - 02:19'),
(57, '1234', 'f1887d3f9e6ee7a32fe5e76f4ab80d63', 144, '01.05.2014 - 18:40'),
(58, 'Rewe', '483fe03fda6c394b7908e0fd1a3204a4', 147, '02.05.2014 - 13:55'),
(57, 'Rewe', 'ee6adcb954cc78c1b28a63dbdc833356', 149, '09.05.2014 - 14:17');*/

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `FriendRelation`
--

CREATE TABLE IF NOT EXISTS `FriendRelation` (
  `Relation_id` int(11) NOT NULL AUTO_INCREMENT,
  `AreFriends` tinyint(1) NOT NULL,
  `UserId1` int(11) NOT NULL,
  `UserId2` int(11) NOT NULL,
  PRIMARY KEY (`Relation_id`)
-- ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `FriendRelation`
--

/*INSERT INTO `FriendRelation` (`Relation_id`, `AreFriends`, `UserId1`, `UserId2`) VALUES
(1, 2, 57, 60),
(2, 2, 57, 58),
(3, 2, 57, 59),
(4, 2, 93, 57),
(5, 2, 93, 59),
(6, 2, 60, 93),
(7, 2, 60, 59);*/

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shoppingnotifications`
--

CREATE TABLE IF NOT EXISTS `shoppingnotifications` (
  `s_not_id` int(11) NOT NULL AUTO_INCREMENT,
  `UserId1` int(11) NOT NULL,
  `UserId2` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date` varchar(24) NOT NULL,
  PRIMARY KEY (`s_not_id`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `shoppingnotifications`
--

/*INSERT INTO `shoppingnotifications` (`s_not_id`, `UserId1`, `UserId2`, `product_id`, `status`, `date`) VALUES
(1, 60, 57, '182', 0, '28.04.2014 - 17:56'),
(2, 60, 57, '188', 0, '28.04.2014 - 17:56'),
(3, 57, 60, '186', 3, '28.04.2014 - 23:13'),
(4, 57, 58, '185', 3, '01.05.2014 - 01:16'),
(5, 59, 57, '274', 0, '09.05.2014 - 14:21'),
(6, 93, 57, '275', 0, '10.05.2014 - 13:20'),
(7, 93, 58, '276', 3, '11.05.2014 - 15:22'),
(8, 93, 59, '262', 3, '26.06.2014 - 16:21'),
(9, 93, 59, '264', 3, '26.06.2014 - 16:21');*/

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `produkte`
--

CREATE TABLE IF NOT EXISTS `produkte` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `product` varchar(45) CHARACTER SET utf8 NOT NULL,
  `amount` int(11) NOT NULL,
  `maxPrice` decimal(19,2) NOT NULL,
  `info` mediumtext NOT NULL,
  `list_id` varchar(255) NOT NULL,
  `getFromUser` int(11) NOT NULL,
  PRIMARY KEY (`item_id`)
-- ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=306 ;
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `produkte`
--

/*INSERT INTO `produkte` (`product`, `amount`, `maxPrice`, `info`, `item_id`, `list_id`, `getFromUser`) VALUES
('123123', 1, '0.00', '', 238, '0ffb8460d08197d28aaf795711fc8f65', 0),
('123', 1, '0.00', '', 239, '0ffb8460d08197d28aaf795711fc8f65', 0),
('23', 1, '0.00', '', 240, '0ffb8460d08197d28aaf795711fc8f65', 0),
('123', 1, '0.00', '', 241, '0ffb8460d08197d28aaf795711fc8f65', 0),
('123', 1, '0.00', '', 242, '0ffb8460d08197d28aaf795711fc8f65', 0),
('123123', 1, '0.00', '', 243, '0ffb8460d08197d28aaf795711fc8f65', 0),
('123123123', 1, '0.00', '', 244, '0ffb8460d08197d28aaf795711fc8f65', 0),
('123123123123', 1, '0.00', '', 245, '0ffb8460d08197d28aaf795711fc8f65', 0),
('123123123123123', 1, '0.00', '', 246, '0ffb8460d08197d28aaf795711fc8f65', 0),
('Wer', 1, '0.00', '', 247, '3e217225db245e7285eb3f12bf0dd172', 0),
('Rew', 1, '0.00', '', 248, '3e217225db245e7285eb3f12bf0dd172', 0),
('E', 1, '0.00', '', 249, '3e217225db245e7285eb3f12bf0dd172', 0),
('Wew', 1, '0.00', '', 250, '3e217225db245e7285eb3f12bf0dd172', 0),
('Wewre', 1, '0.00', '', 251, '3e217225db245e7285eb3f12bf0dd172', 0),
('Fds', 1, '0.00', '', 252, 'f4f451881ba63dd33e30ddc621fc3c43', 0),
('Df', 1, '0.00', '', 253, 'f4f451881ba63dd33e30ddc621fc3c43', 0),
('Fd', 1, '0.00', '', 254, 'f4f451881ba63dd33e30ddc621fc3c43', 0),
('Fd', 1, '0.00', '', 255, 'f4f451881ba63dd33e30ddc621fc3c43', 0),
('E', 1, '0.00', '', 256, 'f4f451881ba63dd33e30ddc621fc3c43', 0),
('Fff', 1, '0.00', '', 257, 'f4f451881ba63dd33e30ddc621fc3c43', 0),
('d', 1, '0.00', '', 258, 'f4f451881ba63dd33e30ddc621fc3c43', 0),
('A', 1, '0.00', '', 259, 'f4f451881ba63dd33e30ddc621fc3c43', 0),
('Gwra', 1, '0.00', '', 260, 'f4f451881ba63dd33e30ddc621fc3c43', 0),
('S', 1, '0.00', '', 261, 'f4f451881ba63dd33e30ddc621fc3c43', 0),
('123', 1, '0.00', '', 262, 'd9dbc51dc534921589adf460c85cd824', 93),
('122', 1, '0.00', '', 263, 'd9dbc51dc534921589adf460c85cd824', 0),
('41', 1, '0.00', '', 264, 'd9dbc51dc534921589adf460c85cd824', 93),
('41r', 1, '0.00', '', 265, 'd9dbc51dc534921589adf460c85cd824', 0),
('A', 1, '0.00', '', 266, 'd9dbc51dc534921589adf460c85cd824', 0),
('Fdsa', 1, '0.00', '', 267, 'd9dbc51dc534921589adf460c85cd824', 0),
('Fdsafs', 1, '0.00', '', 268, 'd9dbc51dc534921589adf460c85cd824', 0),
('Fdsa', 1, '0.00', '', 269, 'd9dbc51dc534921589adf460c85cd824', 0),
('Fds', 1, '0.00', '', 270, 'd9dbc51dc534921589adf460c85cd824', 0),
('Reqw', 1, '0.00', '', 271, 'd9dbc51dc534921589adf460c85cd824', 0),
('Eq', 1, '0.00', '', 272, 'd9dbc51dc534921589adf460c85cd824', 0),
('123', 1, '0.00', '', 274, 'f1887d3f9e6ee7a32fe5e76f4ab80d63', 59),
('123', 1, '0.00', '', 275, 'f1887d3f9e6ee7a32fe5e76f4ab80d63', 0),
('3', 1, '0.00', '', 276, 'f1887d3f9e6ee7a32fe5e76f4ab80d63', 0),
('33', 1, '0.00', '', 277, 'f1887d3f9e6ee7a32fe5e76f4ab80d63', 0),
('124', 1, '0.00', '', 278, 'f1887d3f9e6ee7a32fe5e76f4ab80d63', 0),
('A', 1, '1.00', 'a', 280, 'caee8a6464c13ae84af3d2a0bd10bce0', 58),
('123', 1, '0.00', '', 281, '483fe03fda6c394b7908e0fd1a3204a4', 0),
('123', 1, '0.00', '', 282, '483fe03fda6c394b7908e0fd1a3204a4', 0),
('123', 1, '0.00', '', 283, '483fe03fda6c394b7908e0fd1a3204a4', 0),
('123', 1, '0.00', '', 284, '483fe03fda6c394b7908e0fd1a3204a4', 0),
('123', 1, '0.00', '', 285, '483fe03fda6c394b7908e0fd1a3204a4', 0),
('Milch', 1, '1.00', 'fettarm', 286, 'ee6adcb954cc78c1b28a63dbdc833356', 0),
('Brot', 1, '2.00', 'roggen', 287, 'ee6adcb954cc78c1b28a63dbdc833356', 0);*/

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `vorname` varchar(20) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `passwort` varchar(255) DEFAULT NULL,
  `lists` int(11) NOT NULL,
  `profilPic` varchar(50) NOT NULL DEFAULT 'default.png',
  `plz` int(5) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  UNIQUE KEY `ID_2` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`name`, `vorname`, `email`, `passwort`, `lists`, `profilPic`, `plz`, `ID`) VALUES
('NonnengieÃŸer', 'Nicolas', 'brummbrumm1995@googlemail.com', '8d5c6845fa51fd5998cc1b8bc9c41730', 0, '500px-hazard_x.svg-252768683.png', 61381, 1),
('Lustig', 'Peter', 'peter@lustig.de', '8d5c6845fa51fd5998cc1b8bc9c41730', 0, '0664754001398121513.jpg', 61381, 2),
('MÃ¼ller', 'Dieter', 'mueller@gmx.de', '8d5c6845fa51fd5998cc1b8bc9c41730', 0, 'default.png', 60437, 3),
('Einstein', 'Albert', 'albert@gmx.de', '8d5c6845fa51fd5998cc1b8bc9c41730', 0, '0060795001398337684.png', 60437, 4),
('Bernhard', 'Felix', 'mail@felix-bernhard.com', '641073e14ae9b47563b4e19fb322617b', 0, 'default.png', 60437, 5);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
