-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2022-10-04 02:04:14
-- 伺服器版本： 10.4.22-MariaDB
-- PHP 版本： 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫: `hgiga`
--

-- --------------------------------------------------------

--
-- 資料表結構 `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `title` varchar(30) CHARACTER SET utf8 NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `comments`
--

INSERT INTO `comments` (`id`, `title`, `content`, `created_at`, `updated_at`, `user_id`) VALUES
(627, 'test', 'testss', '2022-07-01 03:09:46', '2022-07-16 06:43:47', 2),
(629, 'test', 'testss', '2022-07-01 03:10:49', '2022-07-16 06:43:47', 2),
(630, 'test', 'testss', '2022-07-04 09:38:21', '2022-07-16 06:43:47', 2),
(631, 'test', 'testss', '2022-07-04 09:38:41', '2022-07-16 06:43:47', 2),
(635, 'test', 'testss', '2022-07-04 09:42:52', '2022-07-16 06:43:47', 2),
(644, 'test', 'testss', '2022-07-12 04:17:37', '2022-07-16 06:43:47', 2),
(645, 'ss', 'sss', '2022-07-12 04:17:57', '2022-07-16 10:38:14', 2),
(655, 'ss', 'sss', '2022-07-15 09:30:34', '2022-07-20 01:18:29', 7),
(657, 'test', 'testss', '2022-07-15 09:34:49', '2022-07-16 06:43:47', 7),
(658, 'test', 'testss', '2022-07-15 09:37:20', '2022-07-16 06:43:47', 2),
(659, 'test', 'testss', '2022-07-15 09:38:11', '2022-07-16 06:43:47', 2),
(660, 'test', 'testss', '2022-07-15 09:38:31', '2022-07-16 06:43:47', 2),
(661, 'test', 'testss', '2022-07-15 09:38:41', '2022-07-16 06:43:47', 2),
(662, 'test', 'testss', '2022-07-15 09:38:54', '2022-07-16 06:43:47', 2),
(666, 'test', 'testss', '2022-07-15 09:43:53', '2022-07-16 06:43:47', 2),
(674, 'test', 'testss', '2022-07-15 09:52:19', '2022-07-16 06:43:47', 2),
(675, 'test', 'testss', '2022-07-15 09:56:34', '2022-07-16 06:43:47', 2),
(676, 'test', 'testss', '2022-07-15 09:56:40', '2022-07-16 06:43:47', 2),
(681, 'test', 'testss', '2022-07-15 10:03:45', '2022-07-16 06:43:47', 2),
(682, 'test', 'testss', '2022-07-15 10:04:09', '2022-07-16 06:43:47', 7),
(685, 'test', 'testss', '2022-07-15 10:05:10', '2022-07-16 06:43:47', 7),
(686, 'test', 'testss', '2022-07-15 10:06:37', '2022-07-16 06:43:47', 7),
(690, 'test', 'testss', '2022-07-15 10:08:19', '2022-07-16 06:43:47', 7),
(691, 'test', 'testss', '2022-07-15 10:08:54', '2022-07-16 06:43:47', 7),
(693, 'test', 'testss', '2022-07-15 16:03:32', '2022-07-16 06:43:47', 7),
(694, 'test', 'testss', '2022-07-15 16:05:11', '2022-07-16 06:43:47', 7),
(695, 'test', 'testss', '2022-07-15 16:19:23', '2022-07-16 06:43:47', 7),
(696, 'test', 'testss', '2022-07-15 16:19:27', '2022-07-16 06:43:47', 7),
(697, 'test', 'testss', '2022-07-15 16:23:36', '2022-07-16 06:43:47', 7),
(906, 'test', 'tt', '2022-07-16 12:34:48', '2022-07-16 12:34:48', 7),
(907, 'sdfsdf', 'sdf', '2022-07-16 14:14:02', '2022-07-16 14:14:02', 7),
(908, 'sdfsdf', 'sdfs', '2022-07-16 14:17:54', '2022-07-16 14:17:54', 7),
(909, 'sdfsdf', 'sdfsf', '2022-07-16 14:18:39', '2022-07-16 14:18:39', 7),
(913, '12312', '123123', '2022-07-18 05:24:41', '2022-07-18 05:24:41', 7),
(914, '12312', '123123', '2022-07-18 05:24:58', '2022-07-18 05:24:58', 7),
(922, '12312', '123123', '2022-07-18 05:40:12', '2022-07-18 05:40:12', 7),
(926, '12312', '123123', '2022-07-18 05:46:42', '2022-07-18 05:46:42', 7),
(928, '12312', '123123', '2022-07-18 05:52:42', '2022-07-18 05:52:42', 7),
(929, '12312', '123123', '2022-07-18 05:52:48', '2022-07-18 05:52:48', 7),
(930, '12312', '123123', '2022-07-18 06:42:33', '2022-07-18 06:42:33', 7),
(931, '12312', '123123', '2022-07-18 07:14:04', '2022-07-18 07:14:04', 7),
(933, '12312', '123123', '2022-07-18 07:36:53', '2022-07-18 07:36:53', 7),
(935, '12312', '123123', '2022-07-18 09:04:43', '2022-07-18 09:04:43', 7),
(936, '12312', '123123', '2022-07-20 01:15:36', '2022-07-20 01:15:36', 7),
(937, 'test', 'test', '2022-07-20 01:23:42', '2022-07-20 01:23:42', 7),
(938, 'sdf', 'sdf', '2022-07-22 07:46:28', '2022-07-22 07:46:28', 7),
(939, 'sdfsdf', 'sdfs', '2022-07-22 07:46:59', '2022-07-22 07:46:59', 7),
(940, '123123', '123123', '2022-07-22 07:48:36', '2022-07-22 07:48:36', 7),
(941, '12312qq', '123123', '2022-07-22 07:50:36', '2022-07-22 07:50:36', 7),
(943, '12312qq', '123123', '2022-07-22 07:51:14', '2022-07-22 07:51:14', 2),
(947, '12312qq', '123123', '2022-07-22 07:54:38', '2022-07-22 07:54:38', 2),
(948, '12312qq', '123123', '2022-07-22 07:57:21', '2022-07-22 07:57:21', 2),
(950, '12312qq', '123123', '2022-07-22 07:57:47', '2022-07-22 07:57:47', 2),
(951, '12312qq', '123123', '2022-07-22 08:01:02', '2022-07-22 08:01:02', 7),
(952, '12312qq', '123123', '2022-07-22 08:01:23', '2022-07-22 08:01:23', 7),
(953, '12312qq', '123123', '2022-07-22 08:07:02', '2022-07-22 08:07:02', 7),
(954, '12312qq', '123123', '2022-07-22 08:11:54', '2022-07-22 08:11:54', 7),
(955, 'sdfgh', 'sfgd', '2022-10-03 05:40:57', '2022-10-03 05:40:57', 77),
(956, 'sdf1111', 'sdfsdf', '2022-10-03 16:45:48', '2022-10-03 16:45:48', 78),
(957, 'sdfsdf', 'sdfsdf', '2022-10-03 16:46:31', '2022-10-03 16:46:31', 78);

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(30) CHARACTER SET utf8 NOT NULL,
  `email` varchar(30) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'jone', 'jone@example.com', 'password'),
(2, 'a206', 'a206@example.com', '$2y$10$uec.AOcTG8x.hX2he.GEbuaCpTOCf4hsziWIM7VBHcQjFoO6/QhWe'),
(7, 'test', 'test@example.com', '$2y$10$uec.AOcTG8x.hX2he.GEbuaCpTOCf4hsziWIM7VBHcQjFoO6/QhWe'),
(77, 'test1', 'a2068839ss2@gmail.com', '$2y$10$Nq.UyjGeZCODbjz9bhxZWOl.Sa2eS6yz0eNSHU/Qw41zZS3MwMjK6'),
(78, 'test2', 'test@exampsle.com', '$2y$10$tir9apcE1CD/QecU6IG3G.CuNljwk9XyBMt5CAJwdWcCnZxlZi6uO');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=958;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
