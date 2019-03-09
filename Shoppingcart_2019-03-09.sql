# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.6.40)
# Database: Shoppingcart
# Generation Time: 2019-03-09 10:58:06 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table Carts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Carts`;

CREATE TABLE `Carts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer` int(11) DEFAULT NULL,
  `status` enum('sold','open') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `Carts` WRITE;
/*!40000 ALTER TABLE `Carts` DISABLE KEYS */;

INSERT INTO `Carts` (`id`, `customer`, `status`)
VALUES
	(19,1,'sold'),
	(20,1,'sold'),
	(22,1,'open');

/*!40000 ALTER TABLE `Carts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Customers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Customers`;

CREATE TABLE `Customers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `Customers` WRITE;
/*!40000 ALTER TABLE `Customers` DISABLE KEYS */;

INSERT INTO `Customers` (`id`, `name`)
VALUES
	(1,'Stefan'),
	(2,'Martin'),
	(3,'Sandra');

/*!40000 ALTER TABLE `Customers` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Products
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Products`;

CREATE TABLE `Products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `calories` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `Products` WRITE;
/*!40000 ALTER TABLE `Products` DISABLE KEYS */;

INSERT INTO `Products` (`id`, `name`, `weight`, `price`, `calories`)
VALUES
	(1,'Brot',300,3.2,300),
	(2,'Milch',500,1.2,500),
	(3,'Zucker',600,2,700);

/*!40000 ALTER TABLE `Products` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Sales
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Sales`;

CREATE TABLE `Sales` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cart` int(11) DEFAULT NULL,
  `product` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `etag` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `Sales` WRITE;
/*!40000 ALTER TABLE `Sales` DISABLE KEYS */;

INSERT INTO `Sales` (`id`, `cart`, `product`, `amount`, `etag`)
VALUES
	(3,19,2,12,'a09c4b528c69f839e98ab1917190f43c'),
	(5,19,3,2,'a09c4b528c69f839e98ab1917190f43c'),
	(7,20,3,2,'new'),
	(8,20,2,4,'new'),
	(10,22,2,4,'a09c4b528c69f839e98ab1917190f43c');

/*!40000 ALTER TABLE `Sales` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
