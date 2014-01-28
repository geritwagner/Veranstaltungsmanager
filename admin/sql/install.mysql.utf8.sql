DROP TABLE IF EXISTS `#__events_links`;
DROP TABLE IF EXISTS `#__events`;

CREATE TABLE `#__events` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Bezeichnung` varchar(255) NOT NULL,
  `Ort` varchar(255) NOT NULL,
  `Datum_von` date NOT NULL,
  `Datum_bis` date NOT NULL,
  `NewsTelegramm` tinyint(1) NOT NULL,
  `NewsTel_preDays` int(11) NOT NULL,
  `NewsTel_postDays` int(11) NOT NULL,
  `Meisterschaft` enum('BM','DM','EM','WM','OS') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE `#__events_links` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_events` int(10) unsigned NOT NULL,
  `Typ` enum('Ausschreibung','Webseite','Zeitplan','Teilnehmer','Ergebnis','Bericht','Fotogalerie','Videos','Sonstiges') NOT NULL,
  `Bezeichnung` varchar(255) NOT NULL,
  `URL` text NOT NULL,
  `NewsTelegramm` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Wettkampf_ID` (`id_events`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `#__events_links`
  ADD CONSTRAINT `#__events_links_ibfk_1` FOREIGN KEY (`id_events`) REFERENCES `#__events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
