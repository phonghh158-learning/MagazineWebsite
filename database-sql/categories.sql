-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 13, 2025 lúc 06:49 PM
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
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` char(36) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `icon`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
('32257766-2d1d-4d76-a1ac-e6bce75f3780', 'GGWP', '<i class=\'bx bx-joystick-alt\'></i>', 'Những trò chơi nổi bật, hay xuất sắc hoặc dở ghê người.', '2025-04-01 15:23:46', '2025-04-01 15:23:46', NULL),
('44793393-6a42-4762-ba65-5e6ea7fdfb55', 'Ẩm thực', '<i class=\'bx bx-dish\'></i>', 'Mọi món ăn tuyệt hảo đều có ở đây', '2025-04-01 16:39:14', '2025-04-01 16:39:14', NULL),
('74aae3fd-5850-4ff8-97dd-53032a33e7f6', 'Non nước', '<i class=\'bx bx-directions\'></i>', 'Những địa điểm du lịch, khu vui chơi tuyệt vời trên khắp Việt Nam.\r\nĐất nước mình còn lạ, cần chi đâu nước ngoài.', '2025-04-01 15:26:05', '2025-04-01 15:26:05', NULL),
('bc5d80d0-08eb-11f0-a777-fc3497151179', 'Âm nhạc', '<i class=\'bx bxs-music\'></i>', 'Cập nhật nhạc mới, idol, BXH, xu hướng nghe nhạc', '2025-03-24 20:08:21', '2025-03-24 20:18:25', NULL),
('bc5d97e8-08eb-11f0-a777-fc3497151179', 'Phim ảnh', '<i class=\'bx bxs-movie-play\'></i>', 'Review, phim hot, series trending, điện ảnh & TV', '2025-03-24 20:08:21', '2025-03-24 20:19:12', NULL),
('bc5d99b7-08eb-11f0-a777-fc3497151179', 'Thể thao', '<i class=\'bx bx-football\'></i>', 'Bóng đá, NBA, game đấu giải, streamer nổi bật', '2025-03-24 20:08:21', '2025-03-27 13:01:04', NULL),
('bc5d9a2f-08eb-11f0-a777-fc3497151179', 'Sách - Truyện', '<i class=\'bx bxs-book\'></i>', 'Review sách, manga, tiểu thuyết, webtoon', '2025-03-24 20:08:21', '2025-03-24 20:20:07', NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
