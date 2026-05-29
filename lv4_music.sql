-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2026 at 01:00 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lv4_music`
--

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `playlist`
--

CREATE TABLE `playlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `song_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `vrijeme_ocjene` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `user_id`, `photo`, `rating`, `created_at`, `vrijeme_ocjene`) VALUES
(1, 1, 'bird.jpg', 5, '2026-05-28 12:58:27', '2026-05-28 17:47:49'),
(2, 1, 'tiger.jpg', 5, '2026-05-28 12:58:35', '2026-05-28 17:47:49'),
(5, 1, 'jaguar.jpg', 4, '2026-05-28 16:52:41', '2026-05-28 17:47:49'),
(16, 1, 'strawberry.jpg', 5, '2026-05-28 16:52:58', '2026-05-28 17:47:49'),
(17, 1, 'tree.jpg', 5, '2026-05-28 16:53:01', '2026-05-28 17:47:49'),
(18, 2, 'bird.jpg', 2, '2026-05-28 17:17:22', '2026-05-28 17:47:49');

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `id` int(11) NOT NULL,
  `naslov` varchar(255) DEFAULT NULL,
  `izvodac` varchar(255) DEFAULT NULL,
  `zanr` varchar(100) DEFAULT NULL,
  `bpm` int(11) DEFAULT NULL,
  `godina` int(11) DEFAULT NULL,
  `popularnost` float DEFAULT NULL,
  `raspolozenje` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`id`, `naslov`, `izvodac`, `zanr`, `bpm`, `godina`, `popularnost`, `raspolozenje`) VALUES
(0, 'song', 'davor', 'rock', 140, 2002, NULL, 'Moody'),
(1, 'Blinding Lights', 'The Weeknd', 'Synthwave', 171, 2020, 4.5, 'Energetic'),
(2, 'Bohemian Rhapsody', 'Queen', 'Rock', 72, 1975, 4.9, 'Dramatic'),
(3, 'Bad Guy', 'Billie Eilish', 'Electropop', 135, 2019, 4.3, 'Dark'),
(4, 'Shape of You', 'Ed Sheeran', 'Pop', 96, 2017, 4.2, 'Happy'),
(5, 'Hotel California', 'Eagles', 'Rock', 74, 1976, 4.8, 'Melancholic'),
(6, 'Levitating', 'Dua Lipa', 'Disco-Pop', 103, 2020, 4.4, 'Cheerful'),
(7, 'Thunderstruck', 'AC/DC', 'Hard Rock', 134, 1990, 4.7, 'Powerful'),
(8, 'Stay', 'The Kid LAROI & Justin Bieber', 'Pop', 170, 2021, 4.1, 'Energetic'),
(9, 'Smells Like Teen Spirit', 'Nirvana', 'Grunge', 117, 1991, 4.9, 'Aggressive'),
(10, 'In the End', 'Linkin Park', 'Nu Metal', 105, 2000, 4.8, 'Emotional'),
(11, 'Superstition', 'Stevie Wonder', 'Funk', 101, 1972, 4.7, 'Groovy'),
(12, 'Don\'t Stop Believin\'', 'Journey', 'Rock', 119, 1981, 4.6, 'Inspirational'),
(13, 'Rolling in the Deep', 'Adele', 'Soul', 105, 2011, 4.7, 'Passionate'),
(14, 'Take Five', 'Dave Brubeck', 'Jazz', 174, 1959, 4.9, 'Relaxed'),
(15, 'One More Time', 'Daft Punk', 'House', 123, 2000, 4.6, 'Festive'),
(16, 'Lose Yourself', 'Eminem', 'Hip Hop', 171, 2002, 4.9, 'Determined'),
(17, 'Dreams', 'Fleetwood Mac', 'Soft Rock', 120, 1977, 4.8, 'Dreamy'),
(18, 'Master of Puppets', 'Metallica', 'Thrash Metal', 212, 1986, 4.9, 'Intense'),
(19, 'Uptown Funk', 'Mark Ronson ft. Bruno Mars', 'Funk', 115, 2014, 4.5, 'Funky'),
(20, 'Billie Jean', 'Michael Jackson', 'Pop', 117, 1982, 4.9, 'Danceable'),
(21, 'Mr. Brightside', 'The Killers', 'Indie Rock', 148, 2004, 4.7, 'Anthemic'),
(22, 'Starboy', 'The Weeknd', 'R&B', 186, 2016, 4.4, 'Moody'),
(23, 'Another One Bites the Dust', 'Queen', 'Funk Rock', 110, 1980, 4.7, 'Confident'),
(24, 'Flowers', 'Miley Cyrus', 'Pop', 118, 2023, 4.3, 'Empowering'),
(25, 'Highway to Hell', 'AC/DC', 'Hard Rock', 116, 1979, 4.8, 'Wild'),
(26, 'Sweet Child O\' Mine', 'Guns N\' Roses', 'Hard Rock', 125, 1987, 4.9, 'Romantic'),
(27, 'Humble', 'Kendrick Lamar', 'Hip Hop', 150, 2017, 4.6, 'Serious'),
(28, 'Seven Nation Army', 'The White Stripes', 'Garage Rock', 124, 2003, 4.7, 'Gritty'),
(29, 'Wake Me Up', 'Avicii', 'EDM', 124, 2013, 4.5, 'Uplifting'),
(30, 'Watermelon Sugar', 'Harry Styles', 'Pop', 95, 2019, 4.2, 'Summer Vibes');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'davor', '$2y$10$bHpBSje1zSD6u.JYATvTZufDjU.ZR8Es8n9dTDfk9kptALN36DNDm', 'user'),
(2, 'rovad', '$2y$10$oJ426TM4L7HLG86s5SslLexFQXC9tU8EAMDYCYJlQUi54wOoCrusu', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `playlist`
--
ALTER TABLE `playlist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`song_id`),
  ADD UNIQUE KEY `unique_playlist` (`user_id`,`song_id`),
  ADD KEY `song_id` (`song_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`photo`),
  ADD UNIQUE KEY `unique_rating` (`user_id`,`photo`),
  ADD UNIQUE KEY `unique_user_photo` (`user_id`,`photo`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `playlist`
--
ALTER TABLE `playlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `playlist`
--
ALTER TABLE `playlist`
  ADD CONSTRAINT `playlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `playlist_ibfk_2` FOREIGN KEY (`song_id`) REFERENCES `songs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
