-- phpMyAdmin SQL Dump
-- version 4.7.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 2017 年 9 月 03 日 17:36
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
-- テーブルの構造 `todo_detail`
--

CREATE TABLE `todo_detail` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT 'TODO名',
  `listNum` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'リストナンバー',
  `period` varchar(30) NOT NULL DEFAULT '' COMMENT '期限',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'ステータス',
  `created` datetime NOT NULL COMMENT '作成日',
  `modified` datetime NOT NULL COMMENT '更新日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `todo_detail`
--

INSERT INTO `todo_detail` (`id`, `name`, `listNum`, `period`, `status`, `created`, `modified`) VALUES
(1, 'Todoテスト', 1, '2017-09-05', 1, '2017-09-03 04:35:42', '2017-09-03 17:28:56'),
(2, '企画書の作成', 1, '2017-09-06', 1, '2017-09-03 04:37:07', '2017-09-03 17:28:57'),
(4, 'リスト２のTodo', 2, '2017-09-07', 1, '2017-09-03 09:29:39', '2017-09-03 17:31:42'),
(5, 'mampのインストール', 13, '2017-09-03', 1, '2017-09-03 12:56:47', '2017-09-03 13:29:08'),
(8, 'スケジュール作成', 14, '2017-09-04', 0, '2017-09-03 13:42:46', '2017-09-03 13:42:46'),
(10, '企画書の作成', 2, '2017-09-07', 1, '2017-09-03 17:30:10', '2017-09-03 17:31:40'),
(11, 'テスト', 3, '2017-09-05', 1, '2017-09-03 17:30:45', '2017-09-03 17:31:34'),
(12, 'テスト', 3, '2017-09-04', 1, '2017-09-03 17:30:52', '2017-09-03 17:31:32'),
(13, 'HISへ行く', 15, '2017-09-10', 0, '2017-09-03 17:32:27', '2017-09-03 17:32:27'),
(14, '期間を決める', 15, '2017-09-05', 1, '2017-09-03 17:32:41', '2017-09-03 17:32:58'),
(15, '予算を決める', 15, '2017-09-05', 0, '2017-09-03 17:32:55', '2017-09-03 17:32:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `todo_detail`
--
ALTER TABLE `todo_detail`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `todo_detail`
--
ALTER TABLE `todo_detail`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
