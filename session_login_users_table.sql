-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-06-10 22:40:16
-- サーバのバージョン： 10.4.32-MariaDB
-- PHP のバージョン: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `gs_l10_01_work`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `session_login_users_table`
--

CREATE TABLE `session_login_users_table` (
  `id` int(12) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `is_admin` int(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- テーブルのデータのダンプ `session_login_users_table`
--

INSERT INTO `session_login_users_table` (`id`, `username`, `password`, `is_admin`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'testuser01', '111111', 1, '2024-06-09 00:26:54', '2024-06-09 00:26:54', NULL),
(2, 'testuser02', '222222', 0, '2024-06-09 00:26:54', '2024-06-09 00:26:54', NULL),
(3, 'testuser03', '333333', 0, '2024-06-09 00:26:54', '2024-06-09 00:26:54', NULL),
(4, 'testuser04', '444444', 0, '2024-06-09 00:26:54', '2024-06-10 21:46:16', NULL),
(7, 'testuser05', '555555', 0, '2024-06-10 23:34:34', '2024-06-10 23:34:34', NULL);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `session_login_users_table`
--
ALTER TABLE `session_login_users_table`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `session_login_users_table`
--
ALTER TABLE `session_login_users_table`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
