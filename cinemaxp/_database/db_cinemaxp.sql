-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2019 at 12:55 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_cinemaxp`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_booked_seats`
--

CREATE TABLE `tbl_booked_seats` (
  `id` int(11) UNSIGNED NOT NULL,
  `booking_id` int(11) UNSIGNED NOT NULL,
  `row_id` smallint(1) UNSIGNED NOT NULL,
  `col_id` smallint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_booked_seats`
--

INSERT INTO `tbl_booked_seats` (`id`, `booking_id`, `row_id`, `col_id`) VALUES
(1, 5, 3, 4),
(2, 5, 3, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bookings`
--

CREATE TABLE `tbl_bookings` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` mediumint(8) UNSIGNED NOT NULL,
  `cinema_id` int(11) UNSIGNED NOT NULL,
  `movie_id` int(11) UNSIGNED NOT NULL,
  `showtime_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_bookings`
--

INSERT INTO `tbl_bookings` (`id`, `user_id`, `cinema_id`, `movie_id`, `showtime_id`) VALUES
(5, 2, 6, 18, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categories`
--

CREATE TABLE `tbl_categories` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_categories`
--

INSERT INTO `tbl_categories` (`id`, `name`) VALUES
(1, 'Action'),
(2, 'Adventure'),
(3, 'Comedy'),
(4, 'Crime'),
(5, 'Drama'),
(6, 'Fantasy'),
(7, 'Horror'),
(8, 'Romance'),
(9, 'Science Fiction'),
(10, 'Thriller'),
(11, 'Western'),
(12, 'Animation');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cinemas`
--

CREATE TABLE `tbl_cinemas` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(8) NOT NULL,
  `movie_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_cinemas`
--

INSERT INTO `tbl_cinemas` (`id`, `name`, `movie_id`) VALUES
(1, 'Cinema 1', 14),
(2, 'Cinema 2', 18),
(3, 'Cinema 3', 15),
(4, 'Cinema 4', 16),
(5, 'Cinema 5', 17),
(6, 'Cinema 6', 13);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_login_attempts`
--

CREATE TABLE `tbl_login_attempts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `attempts` tinyint(1) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `lock` int(11) DEFAULT NULL,
  `user_id` mediumint(8) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_login_attempts`
--

INSERT INTO `tbl_login_attempts` (`id`, `attempts`, `ip_address`, `lock`, `user_id`) VALUES
(1, 1, '::1', 1558612639, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_login_sessions`
--

CREATE TABLE `tbl_login_sessions` (
  `user_id` mediumint(8) UNSIGNED NOT NULL,
  `expiration` int(11) NOT NULL,
  `sess_identifier` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_login_sessions`
--

INSERT INTO `tbl_login_sessions` (`user_id`, `expiration`, `sess_identifier`) VALUES
(1, 1561204372, '00d08e3b1c67a94a7e9b8001f0ef5467'),
(1, 1561204424, 'cfa107d5b7db89afd4bc60fc72683933'),
(1, 1561223894, '444ecab7ac55a2ed0a460a895d8ad2a4'),
(1, 1561288236, '4fe3085c2df177a02741eb3f21cfb0e0'),
(1, 1561304207, '8c81053b5ecda650d478565f09e8bfc9'),
(1, 1561306607, 'eea0548710b693c037f0d70d72be71c3'),
(2, 1561306976, 'bfc280cbd28a16eccf50ef86053f5e47'),
(2, 1561308736, '7f507a6b5c6c58cabfc20d04e93725ac'),
(1, 1561308796, '460516b207a52888fd35c84c57a079a5'),
(2, 1561308886, 'de1da437795d927d25f061767557a503'),
(1, 1561309496, 'd22c6a6d0b6da077e23d7f484444c145'),
(2, 1561309880, '4b393f819a5da867d1b4e55189470702'),
(2, 1561310121, '04b1d0a2e0775003a163701d0b44cd8c'),
(1, 1561310818, '9f90af757208e6fe3703a5b9d0151b9b'),
(2, 1561311203, 'c058ff52430ccc4155dcbad549aa2869'),
(1, 1561312078, '08315662a7f58b5b53a373c06c6bb5e1'),
(1, 1561316083, 'e85274d41c0b51defc78878e6bdb6bba'),
(2, 1561318803, 'ed102bd3e7930532e161c79f3f761dd1'),
(1, 1561319225, 'b98e66d39f99417d4b3de80817457e83'),
(2, 1561329240, '2eb0d5ee10ca089951a2ea63e6060008'),
(2, 1561365358, 'f611d273106926299dd73f0e776733c0'),
(1, 1561484576, '4d925733fb9dd2c86f0bf72d24025665'),
(1, 1561568173, '92d2c1308f5c0daf1384c93bf8df5cc6'),
(2, 1561578520, '8f92b812f9ebd2517ae19056ba9ebfad'),
(1, 1561588800, 'e4dbe9fa8fd33f9160a0c88df177bc3d');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_movies`
--

CREATE TABLE `tbl_movies` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(250) NOT NULL,
  `slug` varchar(250) NOT NULL,
  `release_date` varchar(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `actors` varchar(250) NOT NULL,
  `writers` varchar(250) NOT NULL,
  `directors` varchar(250) NOT NULL,
  `price` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_movies`
--

INSERT INTO `tbl_movies` (`id`, `title`, `slug`, `release_date`, `rating`, `actors`, `writers`, `directors`, `price`) VALUES
(13, 'Shazam', 'shazam', '01/02/2019', 4, 'John Stone, Ponnappa Priya, Mia Wong', 'John Stone, Ponnappa Priya', 'John Stone', '€6.50'),
(14, 'Avengers: End Game', 'avengers-end-game', '01/02/2019', 3, 'Quentin, Perry ,Shana Wilson, Tyler Pena', 'Quentin, Perry, Shana Wilson', 'Quentin, Perry', '€6.50'),
(15, 'Aladdin', 'aladdin', '01/03/2019', 1, 'Rose Tyler, Roman Bryant, Nolan Nelson', 'Rose Tyler, Roman Bryant', 'Rose Tyler', '€6.50'),
(16, 'Detective Pikachu', 'detective-pikachu', '01/04/2019', 1, 'Dwayne Walsh, Ronald Johnston, Kaitlynn Garza', 'Dwayne Walsh, Ronald Johnston', 'Dwayne Walsh', '€6.50'),
(17, 'Spider-Man: Into The Spiderverse', 'spider-man-into-the-spiderverse', '01/05/2019', 2, 'Colton Wade, Jacquelyn Harris, Briana Chandler', 'Colton Wade, Jacquelyn Harris', 'Colton Wade', '€6.50'),
(18, 'A Star is Born', 'a-star-is-born', '01/06/2019', 4, 'Shannon Soto, Selena Hampton, Nicholas Chen', 'Shannon Soto, Selena Hampton', 'Shannon Soto', '€6.50');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_movie_category`
--

CREATE TABLE `tbl_movie_category` (
  `movie_id` int(11) UNSIGNED NOT NULL,
  `category_id` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_movie_category`
--

INSERT INTO `tbl_movie_category` (`movie_id`, `category_id`) VALUES
(14, 1),
(14, 2),
(13, 3),
(13, 4),
(15, 5),
(15, 6),
(16, 7),
(16, 8),
(17, 9),
(17, 10),
(18, 11),
(18, 12);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_permissions`
--

CREATE TABLE `tbl_permissions` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `access` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_permissions`
--

INSERT INTO `tbl_permissions` (`id`, `name`, `access`) VALUES
(1, 'BACKEND_ACCESS', 3),
(2, 'ADD_USERS', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ratings`
--

CREATE TABLE `tbl_ratings` (
  `id` int(11) NOT NULL,
  `rating` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_ratings`
--

INSERT INTO `tbl_ratings` (`id`, `rating`) VALUES
(1, 'U'),
(2, 'PG13'),
(3, '15'),
(4, 'M');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`id`, `name`) VALUES
(1, 'Administrator'),
(2, 'Editor'),
(4, 'Subscriber'),
(8, 'Guest');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_seat_columns`
--

CREATE TABLE `tbl_seat_columns` (
  `id` smallint(1) UNSIGNED NOT NULL,
  `seat_column` smallint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_seat_columns`
--

INSERT INTO `tbl_seat_columns` (`id`, `seat_column`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_seat_rows`
--

CREATE TABLE `tbl_seat_rows` (
  `id` smallint(1) UNSIGNED NOT NULL,
  `seat_row` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_seat_rows`
--

INSERT INTO `tbl_seat_rows` (`id`, `seat_row`) VALUES
(1, 'A'),
(2, 'B'),
(3, 'C'),
(4, 'D'),
(5, 'E'),
(6, 'F'),
(7, 'G');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_showtimes`
--

CREATE TABLE `tbl_showtimes` (
  `id` int(10) UNSIGNED NOT NULL,
  `showtime` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_showtimes`
--

INSERT INTO `tbl_showtimes` (`id`, `showtime`) VALUES
(1, '14:00'),
(2, '16:15'),
(3, '18:30'),
(4, '21:00'),
(5, '23:15');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `email` varchar(500) NOT NULL,
  `password` varchar(150) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `role_id` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `email`, `password`, `salt`, `role_id`) VALUES
(1, 'admin@email.com', '$2y$10$P7d2wHA/jI4kxAcRl/Yy3OBnrf33m8SCzmZjAhJTcFfbABdG6OnjC', 'b6db88cb83cac528', 1),
(2, 'guest@email.com', '$2y$10$C3pIP.qOCuCP0SB/I2NmxOSnO6ErqhZYp0MV7.IRAe7Iwy0ww7OKi', '5fe2f48f76cb9fd2', 8);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_details`
--

CREATE TABLE `tbl_user_details` (
  `user_id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(500) NOT NULL,
  `surname` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_user_details`
--

INSERT INTO `tbl_user_details` (`user_id`, `name`, `surname`) VALUES
(1, 'Jason', 'Mamoa'),
(2, 'Shia', 'LaBeouf');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_booked_seats`
--
ALTER TABLE `tbl_booked_seats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `col_id` (`col_id`),
  ADD KEY `row_id` (`row_id`);

--
-- Indexes for table `tbl_bookings`
--
ALTER TABLE `tbl_bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cinema_id` (`cinema_id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `showtime_id` (`showtime_id`);

--
-- Indexes for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_cinemas`
--
ALTER TABLE `tbl_cinemas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Indexes for table `tbl_login_attempts`
--
ALTER TABLE `tbl_login_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tbl_login_attempts_tbl_users1_idx` (`user_id`);

--
-- Indexes for table `tbl_login_sessions`
--
ALTER TABLE `tbl_login_sessions`
  ADD KEY `fk_tbl_login_sessions_tbl_users1_idx` (`user_id`);

--
-- Indexes for table `tbl_movies`
--
ALTER TABLE `tbl_movies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rating` (`rating`);

--
-- Indexes for table `tbl_movie_category`
--
ALTER TABLE `tbl_movie_category`
  ADD KEY `fk_tbl_article_category_tbl_articles_idx` (`movie_id`),
  ADD KEY `fk_tbl_article_category_tbl_categories1_idx` (`category_id`);

--
-- Indexes for table `tbl_permissions`
--
ALTER TABLE `tbl_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_ratings`
--
ALTER TABLE `tbl_ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_seat_columns`
--
ALTER TABLE `tbl_seat_columns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_seat_rows`
--
ALTER TABLE `tbl_seat_rows`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_showtimes`
--
ALTER TABLE `tbl_showtimes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tbl_users_tbl_roles1_idx` (`role_id`);

--
-- Indexes for table `tbl_user_details`
--
ALTER TABLE `tbl_user_details`
  ADD KEY `fk_tbl_user_details_tbl_users1_idx` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_booked_seats`
--
ALTER TABLE `tbl_booked_seats`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_bookings`
--
ALTER TABLE `tbl_bookings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_cinemas`
--
ALTER TABLE `tbl_cinemas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_login_attempts`
--
ALTER TABLE `tbl_login_attempts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_movies`
--
ALTER TABLE `tbl_movies`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_permissions`
--
ALTER TABLE `tbl_permissions`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_ratings`
--
ALTER TABLE `tbl_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_seat_columns`
--
ALTER TABLE `tbl_seat_columns`
  MODIFY `id` smallint(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_seat_rows`
--
ALTER TABLE `tbl_seat_rows`
  MODIFY `id` smallint(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_showtimes`
--
ALTER TABLE `tbl_showtimes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_booked_seats`
--
ALTER TABLE `tbl_booked_seats`
  ADD CONSTRAINT `tbl_booked_seats_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `tbl_bookings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_booked_seats_ibfk_2` FOREIGN KEY (`col_id`) REFERENCES `tbl_seat_columns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_booked_seats_ibfk_3` FOREIGN KEY (`row_id`) REFERENCES `tbl_seat_rows` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_bookings`
--
ALTER TABLE `tbl_bookings`
  ADD CONSTRAINT `tbl_bookings_ibfk_1` FOREIGN KEY (`cinema_id`) REFERENCES `tbl_cinemas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_bookings_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `tbl_movies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_bookings_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_bookings_ibfk_4` FOREIGN KEY (`showtime_id`) REFERENCES `tbl_showtimes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_cinemas`
--
ALTER TABLE `tbl_cinemas`
  ADD CONSTRAINT `tbl_cinemas_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `tbl_movies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_login_attempts`
--
ALTER TABLE `tbl_login_attempts`
  ADD CONSTRAINT `fk_tbl_login_attempts_tbl_users1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_login_sessions`
--
ALTER TABLE `tbl_login_sessions`
  ADD CONSTRAINT `fk_tbl_login_sessions_tbl_users1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_movies`
--
ALTER TABLE `tbl_movies`
  ADD CONSTRAINT `tbl_movies_ibfk_1` FOREIGN KEY (`rating`) REFERENCES `tbl_ratings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_movie_category`
--
ALTER TABLE `tbl_movie_category`
  ADD CONSTRAINT `fk_tbl_movie_category_tbl_articles` FOREIGN KEY (`movie_id`) REFERENCES `tbl_movies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tbl_movie_category_tbl_categories1` FOREIGN KEY (`category_id`) REFERENCES `tbl_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD CONSTRAINT `fk_tbl_users_tbl_roles1` FOREIGN KEY (`role_id`) REFERENCES `tbl_roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_user_details`
--
ALTER TABLE `tbl_user_details`
  ADD CONSTRAINT `fk_tbl_user_details_tbl_users1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
