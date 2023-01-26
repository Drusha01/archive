SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `admin` (`email`, `password`) VALUES
('andre@gmail.com', '123'),
('sherinata@gmail.com', '123');

DROP TABLE IF EXISTS `appointment`;
CREATE TABLE IF NOT EXISTS `appointment` (
  `appoid` int(11) NOT NULL AUTO_INCREMENT,
  `patientid` int(10) DEFAULT NULL,
  `apponum` int(3) DEFAULT NULL,
  `schedid` int(10) DEFAULT NULL,
  `appodate` date DEFAULT NULL,
  PRIMARY KEY (`appoid`),
  KEY `patientid` (`patientid`),
  KEY `schedid` (`schedid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `appointment` (`appoid`, `patientid`, `apponum`, `schedid`, `appodate`) VALUES
(1, 1, 1, 1, '11/27/2022'),
(2, 2, 2, 2, '12/27/2022'),
(3, 3, 3, 3, '1/27/2023');

DROP TABLE IF EXISTS `dentist`;
CREATE TABLE IF NOT EXISTS `dentist` (
  `dentid` int(11) NOT NULL AUTO_INCREMENT,
  `dentemail` varchar(255) DEFAULT NULL,
  `dentname` varchar(255) DEFAULT NULL,
  `dentpassword` varchar(255) DEFAULT NULL,
  `dentnum` varchar(15) DEFAULT NULL,
  `specialties` int(2) DEFAULT NULL,
  PRIMARY KEY (`dentid`),
  KEY `specialties` (`specialties`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `dentist` (`dentid`, `dentemail`, `dentname`, `dentpassword`, `dentnum`, `specialties`) VALUES
(1, 'jopay@gmail.com', 'Jopaywagkanangmawala', '1234', '09363134097', '1'),
(2, 'sherinata@gmail.com', 'sheshe', '1234', '0936313343', '3'),
(3, 'dunkit@gmail.com', 'jonathan', '1234', '0936313343', '4'),
(4, 'alkhayzel@gmail.com', 'khayzel', '1234', '0936313343', '4'),
(5, 'hanz@gmail.com', 'hanzel', '1234', '0936313343', '2'),
(6, 'abdar@gmail.com', 'abdal', '1234', '0936313343', '5'),
(7, 'sidrick@gmail.com', 'sedreek', '1234', '0936313343', '6'),
(8, 'abraham@gmail.com', 'abrahamz', '1234', '0936313343', '7');

DROP TABLE IF EXISTS `patient`;
CREATE TABLE IF NOT EXISTS `patient` (
  `patientid` int(11) NOT NULL AUTO_INCREMENT,
  `patientemail` varchar(255) DEFAULT NULL,
  `patientname` varchar(255) DEFAULT NULL,
  `patientpassword` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `patientdob` date DEFAULT NULL,
  `patientphone` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`patientid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `patient` (`patientid`, `patientemail`, `patientname`, `patientpassword`, `address`, `patientdob`, `patientphone`) VALUES
(1, 'Eva@gmail.com', 'Eva Elfie', '1234', 'Moscow','05/19/2001', '09232131232'),
(2, 'stella@gmail.com', 'Stella Cox', '1234', 'Canada','07/19/2001', '0923213434'),
(3, 'wally@gmail.com', 'Wally Bayola', '1234', 'Manila','05/19/2001', '09231231212'),
(4, 'test@gmail.com', 'testaccount', '1234', 'test','05/19/2001', '0923223232');

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE IF NOT EXISTS `schedule` (
  `schedid` int(11) NOT NULL AUTO_INCREMENT,
  `dentid` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `scheddate` date DEFAULT NULL,
  `schedtime` time DEFAULT NULL,
  `nop` int(4) DEFAULT NULL,
  PRIMARY KEY (`schedid`),
  KEY `dentid` (`dentid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `schedule` (`schedid`, `dentid`, `title`, `scheddate`, `schedtime`, `nop`) VALUES
(1, '1', 'Test1', '01-05-2022', '3:30', 1),
(2, '2', 'Test2', '02-06-2022', '4:30', 5),
(3, '3', 'Test3', '03-07-2022', '5:30', 3),
(4, '14', 'Test4', '04-08-2022', '6:30', 2);

DROP TABLE IF EXISTS `specialties`;
CREATE TABLE IF NOT EXISTS `specialties` (
  `id` int(2) NOT NULL,
  `sname` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `specialties` (`id`, `sname`) VALUES
(1, 'General Dentist'),
(2, 'Pedodontist or Pediatric Dentist'),
(3, 'Orthodontist'),
(4, 'Periodontist or Gum Specialist'),
(5, 'Endodontist or Root Canal Specialist'),
(6, 'Oral Pathologist or Oral Surgeon'),
(7, 'Prosthodontist');

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `email` varchar(255) NOT NULL,
  `usertype` char(1) DEFAULT NULL,
  PRIMARY KEY (`email`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `user` (`email`, `usertype`) VALUES
('jopay@gmail.com', 'admin'),
('dunkit@gmail.com', 'dentist'),
('eva@gmail.com', 'patient'),
('stella@gmail.com', 'patient'),
('andre@gmail.com', 'admin'),
('sherinata@gmail.com', 'admin');
COMMIT;

