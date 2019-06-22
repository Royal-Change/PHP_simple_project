# Host: 127.0.0.1  (Version: 5.5.53)
# Date: 2019-06-22 15:23:09
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "quotes"
#

DROP TABLE IF EXISTS `quotes`;
CREATE TABLE `quotes` (
  `quote_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `quote` text NOT NULL,
  `source` varchar(100) NOT NULL,
  `favorite` tinyint(1) unsigned NOT NULL,
  `data_entered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`quote_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

#
# Data for table "quotes"
#

/*!40000 ALTER TABLE `quotes` DISABLE KEYS */;
INSERT INTO `quotes` VALUES (1,'Nothing astonishes men so much as common sense and plain dealing.','Ralph Waldo Emerson',0,'2019-03-31 15:31:09'),(2,'It is the mark of an educated mind to be able to entertain a thought without accepting it.','Aristotle',1,'2019-03-31 15:38:11'),(3,'Although the world is full of suffering，it is full also of the overcoming of it。','Hellen Keller',1,'2019-03-31 15:43:17'),(4,'In order to conquer, what we need is to dare, still to dare, and always to dare.','Georges Danton',0,'2019-03-31 23:35:28');
/*!40000 ALTER TABLE `quotes` ENABLE KEYS */;
