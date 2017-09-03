-- phpMyAdmin SQL Dump
-- version 4.7.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 2017 年 9 月 03 日 17:35
-- サーバのバージョン： 5.6.35
-- PHP Version: 7.0.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `todo_manager`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `todo_list`
--

CREATE TABLE `todo_list` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT 'リスト名',
  `created` datetime NOT NULL COMMENT '作成日',
  `modified` datetime NOT NULL COMMENT '更新日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `todo_list`
--

INSERT INTO `todo_list` (`id`, `name`, `created`, `modified`) VALUES
(1, 'テストリスト', '2017-08-27 15:48:23', '2017-08-27 15:48:23'),
(2, 'テストリスト２', '2017-08-27 16:26:45', '2017-08-27 16:26:45'),
(3, 'テスト３０文字以内テスト３０文字以内テスト３０文字以内テスト', '2017-09-03 10:34:58', '2017-09-03 10:34:58'),
(4, 'テスト４', '2017-09-03 11:12:46', '2017-09-03 11:12:46'),
(5, 'テストテストテストテストテストテストテストテストテストテスト', '2017-09-03 11:13:09', '2017-09-03 11:13:09'),
(6, 'テストタイトルテストタイトルテストタイトルテストタイトルテス', '2017-09-03 12:07:13', '2017-09-03 12:07:13'),
(7, 'リスト作成テスト', '2017-09-03 12:16:21', '2017-09-03 12:16:21'),
(8, 'リスト作成テスト２', '2017-09-03 12:17:17', '2017-09-03 12:17:17'),
(9, '新規Todoリスト', '2017-09-03 12:37:42', '2017-09-03 12:37:42'),
(10, 'セッションテスト', '2017-09-03 12:53:08', '2017-09-03 12:53:08'),
(11, 'セッションテスト２', '2017-09-03 12:54:23', '2017-09-03 12:54:23'),
(12, 'にゅーりすと', '2017-09-03 12:55:23', '2017-09-03 12:55:23'),
(13, '開発環境', '2017-09-03 12:56:14', '2017-09-03 12:56:14'),
(14, '新規リスト', '2017-09-03 13:42:21', '2017-09-03 13:42:21'),
(15, '○○旅行準備', '2017-09-03 17:32:02', '2017-09-03 17:32:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `todo_list`
--
ALTER TABLE `todo_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `todo_list`
--
ALTER TABLE `todo_list`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
