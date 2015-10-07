# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.6.26)
# Database: student_consultation
# Generation Time: 2015-10-07 19:10:47 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;

INSERT INTO `category` (`id`, `category_name`)
VALUES
	(1,'Mental'),
	(2,'Advice'),
	(3,'Thesis');

/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table consultations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `consultations`;

CREATE TABLE `consultations` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `student_id` int(100) NOT NULL,
  `teacher_id` int(100) NOT NULL,
  `category_id` int(100) NOT NULL,
  `comment` varchar(255) NOT NULL DEFAULT '',
  `time_in` timestamp NULL DEFAULT NULL,
  `time_out` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `consultation_student` (`student_id`),
  KEY `consulation_teacher` (`teacher_id`),
  KEY `consultation_category` (`category_id`),
  CONSTRAINT `consulation_teacher` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `consultation_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `consultation_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `consultations` WRITE;
/*!40000 ALTER TABLE `consultations` DISABLE KEYS */;

INSERT INTO `consultations` (`id`, `student_id`, `teacher_id`, `category_id`, `comment`, `time_in`, `time_out`)
VALUES
	(5,4,11,2,'FFF','2015-10-07 17:59:41','2015-10-07 19:09:13'),
	(6,4,11,2,'Comments are Nice','2015-10-07 19:00:50','2015-10-07 19:09:13'),
	(7,4,11,2,'Coments','2015-10-07 19:06:54','2015-10-07 19:09:13'),
	(8,4,11,1,'SSS','2015-10-07 19:08:42','2015-10-07 19:09:13'),
	(9,4,11,1,'HSS','2015-10-07 19:09:11','2015-10-07 19:09:13');

/*!40000 ALTER TABLE `consultations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table students
# ------------------------------------------------------------

DROP TABLE IF EXISTS `students`;

CREATE TABLE `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(100) NOT NULL,
  `course` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `student_users` (`user_id`),
  CONSTRAINT `student_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;

INSERT INTO `students` (`id`, `user_id`, `course`)
VALUES
	(4,22,'BSIT');

/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table teachers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `teachers`;

CREATE TABLE `teachers` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `user_id` int(100) NOT NULL,
  `department` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `teacher_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `teachers` WRITE;
/*!40000 ALTER TABLE `teachers` DISABLE KEYS */;

INSERT INTO `teachers` (`id`, `user_id`, `department`)
VALUES
	(11,21,'Philiosophy Major');

/*!40000 ALTER TABLE `teachers` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `user_type` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `username`, `password`, `user_type`, `first_name`, `last_name`)
VALUES
	(14,'Admin','dc647eb65e6711e155375218212b3964',3,'Root','User'),
	(21,'Teacher','dc647eb65e6711e155375218212b3964',2,'Padsz','LimeLight'),
	(22,'Student','dc647eb65e6711e155375218212b3964',1,'Ares','Totle');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
