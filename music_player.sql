-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2019 at 10:05 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `music_player`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_tracks` ()  BEGIN
SELECT * FROM track;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_tracks_of_artist` (IN `VAR1` INT, OUT `VAR2` INT)  BEGIN
SELECT * FROM track WHERE track_id IN (SELECT track_id FROM track_artist WHERE artist_id=VAR1);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE `album` (
  `album_id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `genre` int(11) NOT NULL,
  `artwork_path` varchar(500) NOT NULL,
  `created_by_artist` int(11) NOT NULL,
  `number_of_tracks` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`album_id`, `title`, `genre`, `artwork_path`, `created_by_artist`, `number_of_tracks`) VALUES
(1, 'Naruto Shippuden', 3, 'assets/images/artwork/heros_come_back.jpg', 4, 8),
(2, 'Death Note', 7, 'assets/images/artwork/DeathNote.jpg', 6, 5),
(4, 'Spider-Man: Into the Spider-Verse ', 3, 'assets/images/artwork/spider-man-into-the-spider-verse.jpg\r\n', 11, 4),
(5, 'Love Ni Bhavai', 3, 'assets/images/artwork/spider-man-into-the-spider-verse.jpg', 1, 2);

-- --------------------------------------------------------

--
-- Stand-in structure for view `album_number_of_tracks`
-- (See below for the actual view)
--
CREATE TABLE `album_number_of_tracks` (
`number_of_tracks` bigint(21)
,`album_id` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `dummy`
--

CREATE TABLE `dummy` (
  `id` int(11) NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dummy`
--

INSERT INTO `dummy` (`id`, `time`) VALUES
(1, '00:01:25'),
(2, '01:26:00');

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `genre_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`genre_id`, `name`) VALUES
(1, 'Rock'),
(2, 'Pop'),
(3, 'Hip-Hop'),
(4, 'Classical'),
(5, 'Techno'),
(6, 'Rap'),
(7, 'Instrumental'),
(8, 'Romantic');

-- --------------------------------------------------------

--
-- Table structure for table `playlist`
--

CREATE TABLE `playlist` (
  `playlist_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `number_of_tracks` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `playlist`
--

INSERT INTO `playlist` (`playlist_id`, `title`, `number_of_tracks`, `user_id`, `date_created`) VALUES
(9, 'Myplaylist', 0, 8, '2019-10-02'),
(11, 'Myplaylist2', 1, 4, '2019-10-02'),
(12, 'MariPlaylist', 4, 4, '2019-10-03'),
(13, 'Playlist1', 3, 1, '2019-10-04'),
(14, 'myplaylist', 1, 1, '2019-10-22'),
(15, 'chill', 1, 11, '2019-10-22'),
(16, 'rndom', 1, 1, '2019-10-22'),
(17, 'Myplaying', 2, 2, '2019-10-22'),
(18, 'test', 1, 1, '2019-10-23'),
(19, 'play', 1, 12, '2019-11-02');

-- --------------------------------------------------------

--
-- Table structure for table `playlist_track`
--

CREATE TABLE `playlist_track` (
  `track_id` int(11) NOT NULL,
  `playlist_id` int(11) NOT NULL,
  `playlist_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `playlist_track`
--

INSERT INTO `playlist_track` (`track_id`, `playlist_id`, `playlist_order`) VALUES
(2, 12, 0),
(3, 12, 2),
(3, 13, 2),
(4, 13, 0),
(5, 12, 4),
(5, 13, 1),
(7, 11, 0),
(8, 12, 3),
(10, 17, 0),
(11, 15, 0),
(11, 17, 1),
(11, 19, 0),
(12, 14, 0),
(12, 16, 0),
(12, 18, 0);

--
-- Triggers `playlist_track`
--
DELIMITER $$
CREATE TRIGGER `playlist_number_of_tracks_update` AFTER INSERT ON `playlist_track` FOR EACH ROW if new.playlist_id is not null THEN UPDATE playlist set number_of_tracks=number_of_tracks+1 where playlist_id=new.playlist_id; END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `track`
--

CREATE TABLE `track` (
  `track_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `album_id` int(11) NOT NULL,
  `genre` int(11) NOT NULL,
  `duration` varchar(8) NOT NULL,
  `path` varchar(500) NOT NULL,
  `album_order` int(11) NOT NULL,
  `plays` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `track`
--

INSERT INTO `track` (`track_id`, `title`, `album_id`, `genre`, `duration`, `path`, `album_order`, `plays`) VALUES
(1, 'Blue Bird', 1, 2, '3:28', 'assets/music/blue-bird.mp3', 2, 57),
(2, 'Heros Come Back', 1, 1, '4:33', 'assets/music/heros-come-back.mp3', 1, 75),
(3, 'Hotaru No Hikari', 1, 2, '4:00', 'assets/music/hotaru-no-hikari.mp3', 3, 91),
(4, 'Kuroi Light', 2, 7, '1:57', 'assets/music/Kuroi_Light.mp3', 1, 58),
(5, 'L Theme', 2, 7, '3:03', 'assets/music/L_Theme.mp3', 2, 76),
(6, 'L Theme B', 2, 7, '2:53', 'assets/music/L_Theme_B.mp3', 3, 53),
(7, 'Light\'s Theme', 2, 7, '3:23', 'assets/music/Light_Theme.mp3', 4, 48),
(8, 'Lovers', 1, 5, '4:50', 'assets/music/lovers.mp3', 4, 48),
(9, 'Sing', 1, 4, '3:33', 'assets/music/sing.mp3', 5, 57),
(10, 'Niji', 1, 4, '04:17', 'assets/music/Niji.mp3', 6, 10),
(11, 'Whats Up Danger', 4, 3, '03:43', 'assets/music/Whats-Up-Danger.mp3', 1, 16),
(12, 'Sunflower', 4, 3, '02:41', 'assets/music/Sunflower.mp3', 2, 8),
(13, 'Hide', 4, 3, '03:26', 'assets/music/Hide.mp3', 3, 12),
(14, 'Way Up', 4, 3, '02:34', 'assets/music/Way-Up.mp3', 4, 5),
(15, 'Dhun Lagi', 2, 8, '4:34', 'assets/music/KZMIyoDmsB0Ej239.mp3', 5, 1),
(16, 'Dhun Lagi', 5, 8, '4:34', 'assets/music/ZPhVaFYtmfrBfbe6.mp3', 1, 3),
(17, 'Vhalam Aavo Ne', 5, 8, '5:19', 'assets/music/CuIDOwgS16exWDCA.mp3', 2, 1);

--
-- Triggers `track`
--
DELIMITER $$
CREATE TRIGGER `number_of_tracks_update` AFTER INSERT ON `track` FOR EACH ROW IF new.album_id is not null THEN UPDATE album SET number_of_tracks=number_of_tracks+1 WHERE album_id = new.album_id; END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `track_artist`
--

CREATE TABLE `track_artist` (
  `artist_id` int(11) NOT NULL,
  `track_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `track_artist`
--

INSERT INTO `track_artist` (`artist_id`, `track_id`) VALUES
(1, 4),
(1, 7),
(1, 15),
(1, 16),
(1, 17),
(2, 3),
(2, 8),
(2, 9),
(4, 1),
(4, 2),
(4, 3),
(4, 8),
(6, 2),
(6, 4),
(6, 5),
(6, 6),
(6, 7),
(8, 10),
(11, 11),
(11, 12),
(11, 13),
(11, 14);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `contact` varchar(20) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(32) NOT NULL,
  `photo` varchar(511) DEFAULT NULL,
  `description` text,
  `is_artist` tinyint(1) DEFAULT '0',
  `sign_up_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `address`, `date_of_birth`, `contact`, `username`, `password`, `photo`, `description`, `is_artist`, `sign_up_date`) VALUES
(1, 'Harsh Mistry', 'mistryharsh28@gmail.com', '19/10, OLD AIR INDIA COLONY, KALINA, SANTACRUZ(EAST)', '1999-11-28', '9969879437', 'Harsh', 'b0aa651c991deca550252ed6cbba99ba', 'assets/images/profile_pic/itachi_Uchiha.jpg', NULL, 1, '2019-09-06 00:00:00'),
(2, 'Itachi Uchiha', 'itachi_uchiha@gmail.com', 'Leaf Village', '1999-11-28', '9987585298', 'Itachi', 'ed52bad12534085693087a150b13a004', 'assets/images/profile_pic/itachi_Uchiha.jpg', NULL, 1, '2019-09-06 00:00:00'),
(3, 'Yogesh Mistry', 'yogeshmistry08@yahoo.in', '19/10, OLD AIR INDIA COLONY, KALINA, SANTACRUZ(EAST)', '1968-08-30', '8104451902', 'Yogesh', '12c04508f5ba285e8f7f8cb661eee006', 'assets/images/profile_pic/itachi_Uchiha.jpg', NULL, 1, '2019-09-06 00:00:00'),
(4, 'Naruto Uzumaki', 'naruto_uzumaki@kohona.com', 'Hidden Leaf Village', '1999-09-25', '9969879438', 'Naruto', '884ecc7ac05cb5d52aa970f523a3b7e6', 'assets/images/profile_pic/itachi_Uchiha.jpg', NULL, 1, '2019-09-07 00:00:00'),
(6, 'L. Lawliet', 'lisgod@gmail.com', 'try to find me if you can', '1999-11-20', '7894563217', 'Lawliet', '5f4dcc3b5aa765d61d8327deb882cf99', 'assets/images/profile-pic/itachi_Uchiha.jpg', NULL, 1, '2019-09-07 00:00:00'),
(7, 'Harshil Vakharia', 'harshilvakaka@gmail.com', 'Home', '1999-11-11', '8124865896', 'Harshil', 'ee059a260e2b0ee69c1942a94aa5deff', 'assets/images/profile_pic/itachi_Uchiha.jpg', NULL, 0, '2019-09-26 00:00:00'),
(8, 'Shivam Bhamre', 'shivambhamre8@gmail.com', '19/21, OLD AIR INDIA COLONY, KALINA, SANTACRUZ(EAST)', '2001-01-08', '9137220122', 'Shivam', '4f73954d7ffa07973f2d28bde12fca4d', 'assets/images/profile_pic/itachi_Uchiha.jpg', NULL, 1, '2019-10-02 00:00:00'),
(9, 'Abhi Thummar', 'abhithummar1999@gmail.com', 'Mira Road East ', '1999-09-01', '9323551111', 'AbhiThummar', '167784d36ab99e49738fe6a6a98798b7', 'assets/images/profile_pic/itachi_Uchiha.jpg', NULL, 1, '2019-10-09 00:00:00'),
(10, 'Dhairya Shah', 'dhairyashah@gmail.com', 'Borivalli', '1999-01-01', '9968959648', 'Dhairya', 'a54252270e22fded3a0fac0ac6cec3da', 'assets/images/profile_pic/itachi_Uchiha.jpg', NULL, 0, '2019-10-10 00:00:00'),
(11, 'Black Way and Black Caviar', 'dummy@gmail.com', 'America', '1986-10-01', '3698521475', 'Black', 'b0aa651c991deca550252ed6cbba99ba', 'assets/images/profile_pic/itachi_Uchiha.jpg', NULL, 1, '2019-10-22 00:00:00'),
(12, 'abhijit', 'abhijitsahoo9118@gmail.com', '19/10, OLD AIR INDIA COLONY, KALINA, SANTACRUZ(EAST)', '1999-12-17', '09894914859', 'abhijit9118', '3c08d2893d74a1886d3245bda3619016', 'assets/images/profile_pic/itachi_Uchiha.jpg', NULL, 1, '2019-11-02 00:00:00');

-- --------------------------------------------------------

--
-- Structure for view `album_number_of_tracks`
--
DROP TABLE IF EXISTS `album_number_of_tracks`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `album_number_of_tracks`  AS  select count(`track`.`track_id`) AS `number_of_tracks`,`track`.`album_id` AS `album_id` from `track` group by `track`.`album_id` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`album_id`),
  ADD KEY `created_by_artist` (`created_by_artist`),
  ADD KEY `genre` (`genre`);

--
-- Indexes for table `dummy`
--
ALTER TABLE `dummy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `time` (`time`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`genre_id`);

--
-- Indexes for table `playlist`
--
ALTER TABLE `playlist`
  ADD PRIMARY KEY (`playlist_id`),
  ADD UNIQUE KEY `unique_index` (`title`,`user_id`),
  ADD KEY `playlist_ibfk_1` (`user_id`);

--
-- Indexes for table `playlist_track`
--
ALTER TABLE `playlist_track`
  ADD PRIMARY KEY (`track_id`,`playlist_id`),
  ADD KEY `playlist_id` (`playlist_id`);

--
-- Indexes for table `track`
--
ALTER TABLE `track`
  ADD PRIMARY KEY (`track_id`),
  ADD KEY `album_id` (`album_id`),
  ADD KEY `genre` (`genre`);

--
-- Indexes for table `track_artist`
--
ALTER TABLE `track_artist`
  ADD PRIMARY KEY (`artist_id`,`track_id`),
  ADD KEY `track_id` (`track_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `album`
--
ALTER TABLE `album`
  MODIFY `album_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `genre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `playlist`
--
ALTER TABLE `playlist`
  MODIFY `playlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `track`
--
ALTER TABLE `track`
  MODIFY `track_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `album_ibfk_1` FOREIGN KEY (`created_by_artist`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `album_ibfk_2` FOREIGN KEY (`genre`) REFERENCES `genre` (`genre_id`);

--
-- Constraints for table `playlist`
--
ALTER TABLE `playlist`
  ADD CONSTRAINT `playlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `playlist_track`
--
ALTER TABLE `playlist_track`
  ADD CONSTRAINT `playlist_track_ibfk_1` FOREIGN KEY (`track_id`) REFERENCES `track` (`track_id`),
  ADD CONSTRAINT `playlist_track_ibfk_2` FOREIGN KEY (`playlist_id`) REFERENCES `playlist` (`playlist_id`);

--
-- Constraints for table `track`
--
ALTER TABLE `track`
  ADD CONSTRAINT `track_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `album` (`album_id`),
  ADD CONSTRAINT `track_ibfk_2` FOREIGN KEY (`genre`) REFERENCES `genre` (`genre_id`);

--
-- Constraints for table `track_artist`
--
ALTER TABLE `track_artist`
  ADD CONSTRAINT `track_artist_ibfk_1` FOREIGN KEY (`artist_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `track_artist_ibfk_2` FOREIGN KEY (`track_id`) REFERENCES `track` (`track_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
