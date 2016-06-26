-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 26, 2016 at 02:31 PM
-- Server version: 5.5.49
-- PHP Version: 5.4.45-0+deb7u2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ajaxdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE IF NOT EXISTS `chat` (
  `TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `uid` int(11) NOT NULL,
  `touid` int(11) NOT NULL,
  `message` text NOT NULL,
  `Number` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Number`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`TIMESTAMP`, `uid`, `touid`, `message`, `Number`) VALUES
('2016-06-25 15:25:58', 1, 2, 'Hey, there this is the first message!', 1),
('2016-06-25 15:26:35', 2, 1, 'Hi bro!', 2),
('2016-06-25 18:59:07', 1, 2, 'undefined', 3),
('2016-06-25 19:02:14', 1, 2, 'undefined', 4),
('2016-06-25 19:03:10', 1, 2, 'undefined', 5),
('2016-06-25 19:05:12', 1, 2, 'So whats new?', 6),
('2016-06-25 19:07:10', 1, 2, 'Lol', 7),
('2016-06-25 19:07:48', 1, 2, 'Don''t you wanna see if apostrophe works?', 8),
('2016-06-25 20:26:31', 1, 2, 'Real time test', 9),
('2016-06-25 20:26:45', 2, 1, 'Success! Received', 10),
('2016-06-25 20:28:28', 1, 2, 'Hey', 11),
('2016-06-25 20:29:10', 1, 2, 'hi', 12),
('2016-06-25 20:29:35', 2, 1, 'hi', 13),
('2016-06-25 20:29:54', 2, 1, 'hi', 14),
('2016-06-26 08:45:08', 1, 2, 'Hey', 25);

--
-- Triggers `chat`
--
DROP TRIGGER IF EXISTS `autohist`;
DELIMITER //
CREATE TRIGGER `autohist` AFTER INSERT ON `chat`
 FOR EACH ROW BEGIN
DECLARE updatecount INT;
set @updatecount := (SELECT count(*) from history where uid=NEW.UID AND touid=NEW.touid );
if(updatecount<=0)
  then
     insert into history values (NEW.uid,NEW.touid);
  end if;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `uid` int(11) NOT NULL,
  `touid` int(11) NOT NULL,
  PRIMARY KEY (`uid`,`touid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`uid`, `touid`) VALUES
(1, 2),
(2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `uid` int(11) NOT NULL,
  `touid` int(11) NOT NULL,
  `TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `message` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `message`
--
DROP TRIGGER IF EXISTS `insinchat`;
DELIMITER //
CREATE TRIGGER `insinchat` BEFORE DELETE ON `message`
 FOR EACH ROW insert into chat (uid,touid,TIMESTAMP,message) values (OLD.uid,OLD.touid,OLD.TIMESTAMP,OLD.message)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `uname`, `pass`) VALUES
(1, 'karthik', 'karthik'),
(2, 'adnan', 'adnan');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
