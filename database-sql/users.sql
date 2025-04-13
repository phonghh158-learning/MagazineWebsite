-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 13, 2025 lúc 06:48 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `magazine_db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` char(36) NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `fullname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `status` enum('active','banned','deleted') DEFAULT 'active',
  `remember_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `fullname`, `email`, `email_verified_at`, `password`, `role`, `avatar`, `bio`, `status`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
('01eb5ea9-a488-439e-a46e-ff0a0aa30590', 'phonghh158', 'Hoàng Hồng Phong', 'phonghh.forme@gmail.com', NULL, '$argon2id$v=19$m=65536,t=4,p=1$V0MwWFFrOUVMalVLdjlKMQ$TnJZK1m3f9sJwCawy1TLJAw5RfKbR88TgOqefKckDco', 'user', NULL, NULL, 'active', '', '2025-03-24 10:34:01', '2025-03-24 10:51:11', NULL),
('0ab4d66b-8556-44bb-a644-812c7d829d13', 'usertest3', 'Nông Văn C', 'usertest3@gmail.com', NULL, '$argon2id$v=19$m=65536,t=4,p=1$MHpTTWgzaHhZWUUxUzVETA$mvkBWUgITwMrFngKVl9wtKm0wHffjP4l3a0IRbAHJrI', 'user', NULL, NULL, 'active', '', '2025-03-24 10:35:42', '2025-04-03 18:50:13', NULL),
('0b2949f2-ca9b-47d9-97d7-2034fc2bcd0c', 'admin', 'Hoàng Hồng Phong', 'admin@website.com', NULL, '$argon2id$v=19$m=65536,t=4,p=1$anh3UzFQT2NIdVpTSlNiUQ$cBt6RXHk0uXhTCfpsdtyhVrjCO3v7QHqj7A0kd5QzDY', 'admin', 'upload/images/users/1744389817-0b2949f2-ca9b-47d9-97d7-2034fc2bcd0c.jpg', NULL, 'active', '', '2025-03-24 10:36:26', '2025-04-11 16:59:20', NULL),
('10641914-3e5d-4648-abd9-d4b7771998cf', 'usertest1', 'Nguyễn Văn A', 'usertest1@gmail.com', NULL, '$argon2id$v=19$m=65536,t=4,p=1$aWVCY0lELkkzVTJCeFBOMg$mIzLs0nJDW8RMn+GKKk2GU7d4YMPwNaf9np9e3q7lm0', 'user', NULL, NULL, 'active', '', '2025-03-24 10:26:02', '2025-03-31 20:00:16', NULL),
('9d9fb46e-b7bc-47c1-b75c-8ef3717a1d96', 'usertest5', 'Trần Văn D', 'usertest5@gmail.com', NULL, '$argon2id$v=19$m=65536,t=4,p=1$UUdvN3RRS0EyWFVVek9KUw$pv8Q/JfzgNi/De12qih3SW+LNEcIcgF3UktBGsmRPTA', 'user', NULL, NULL, 'active', NULL, '2025-03-29 22:03:56', '2025-03-29 22:03:56', NULL),
('d8c80e08-4383-4fa2-83d7-48fb98dfc27f', 'usertest2', 'Lê Thị B', 'usertest2@gmail.com', NULL, '$argon2id$v=19$m=65536,t=4,p=1$bDc2ZTE0NmkzWlBhNll6bg$dZtk+i8uAzCwioBQzNhpLpQ+PUkYekxtexXSBrbp/+8', 'user', 'upload/images/users/1744394322-d8c80e08-4383-4fa2-83d7-48fb98dfc27f.jpg', NULL, 'active', '', '2025-03-24 10:34:37', '2025-04-11 17:58:42', NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
