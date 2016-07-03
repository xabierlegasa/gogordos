# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.6.31)
# Database: gogordos
# Generation Time: 2016-06-26 19:04:43 +0000
# ************************************************************



# Dump of table category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `canonical_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;

INSERT INTO `category` (`id`, `name`, `canonical_name`)
VALUES
	(1,'Americano','americano'),
	(2,'Andaluz','analuz'),
	(3,'Árabe','arabe'),
	(4,'Argentino','argentino'),
	(5,'Arrocería','arroceria'),
	(6,'Asador','asador'),
	(7,'Asiático','asiatico'),
	(8,'Asturiano','asturiano'),
	(9,'Belga','belga'),
	(10,'Brasería. Carnes','braseria_carnes'),
	(11,'Brasileño','brasileno'),
	(12,'Camboyano','camoyano'),
	(13,'Castellano','castellano'),
	(14,'Catalán','catalan'),
	(15,'Chino','chino'),
	(16,'Colombiano','colombiano'),
	(17,'Coreano','coreano'),
	(18,'Creativo','creativo'),
	(19,'Cubano','cubano'),
	(20,'De Fusión','de_fusion'),
	(21,'De mercado','de_mercado'),
	(22,'Español','espanol'),
	(23,'Etíope','etiope'),
	(24,'Europa del este','europa_del_este'),
	(25,'Extremeño','extrameno'),
	(26,'Francés','frances'),
	(27,'Gallego','gallego'),
	(28,'Griego','griego'),
	(29,'Indio','indio'),
	(30,'Inglés','ingles'),
	(31,'Internacional','internacional'),
	(32,'Iraní','irani'),
	(33,'Italino','italiano'),
	(34,'Japonés','japones'),
	(35,'Latino','latino'),
	(36,'Libanés','libanes'),
	(37,'Marisquería','marisqueria'),
	(38,'Marroquí','marroqui'),
	(39,'Mediterraneo','mediterraneo'),
	(40,'Mexicano','mexicano'),
	(41,'Navarro','navarro'),
	(42,'Peruano','peruano'),
	(43,'Portugués','portugues'),
	(44,'Suizo','suizo'),
	(45,'Ruso','ruso'),
	(46,'Suizo','suizo'),
	(47,'Tailandés','tailandes'),
	(48,'Turco','turco'),
	(49,'Vasco','vasco'),
	(50,'Vegetariano','vegetariano'),
	(51,'Vietnamita','vietnamita');

/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `is_admin` tinyint(0) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_957A647992FC23A8` (`username`),
  UNIQUE KEY `UNIQ_957A6479A0D96FBF` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;


/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table recommendation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `recommendation`;

CREATE TABLE `recommendation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `city` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `restaurant_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_433224D212469DE2` (`category_id`),
  KEY `IDX_433224D2A76ED395` (`user_id`),
  CONSTRAINT `FK_433224D212469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  CONSTRAINT `FK_433224D2A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
