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
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` char(36) NOT NULL,
  `post_id` char(36) DEFAULT NULL,
  `user_id` char(36) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `reviews`
--

INSERT INTO `reviews` (`id`, `post_id`, `user_id`, `rating`, `comment`, `created_at`, `updated_at`, `deleted_at`) VALUES
('0d48ca46-ac48-4360-b76c-c2d5a4d97b1f', '6fb40687-b696-4297-a80a-297e51d25737', 'd8c80e08-4383-4fa2-83d7-48fb98dfc27f', 5, 'Bất ngờ đấy...', '2025-04-10 22:33:17', '2025-04-10 22:33:34', '2025-04-10 22:33:34'),
('122cf090-b170-4142-b4b3-1f5a26e9a6ac', '6fb40687-b696-4297-a80a-297e51d25737', 'd8c80e08-4383-4fa2-83d7-48fb98dfc27f', 5, 'Một kết quả bất ngờ...', '2025-04-10 22:33:46', '2025-04-10 22:33:46', NULL),
('1378837b-b64a-46e5-a533-0c7d54a040b7', 'de845afd-1bef-4e33-8236-c914b7ab879e', '0ab4d66b-8556-44bb-a644-812c7d829d13', 1, 'Game ít thôi', '2025-04-03 18:49:18', '2025-04-03 18:49:18', NULL),
('420dd030-5811-4ee0-9268-f476dc0d0826', '38338c27-965e-497d-8fe2-85f0ba6969b5', '0ab4d66b-8556-44bb-a644-812c7d829d13', 1, 'Sao mà ngắn thế.', '2025-04-03 18:49:06', '2025-04-03 18:49:06', NULL),
('54ce6bb9-ad43-4e9d-895b-b4e7ff545233', 'c3fe8800-1518-43b0-850c-04f4bb3d461e', '0ab4d66b-8556-44bb-a644-812c7d829d13', 4, 'Một bài báo ý nghĩa. Ngày ngày mặt trời đi qua trên lăng.', '2025-04-03 18:48:48', '2025-04-03 18:48:48', NULL),
('5da96818-9508-4865-808d-3294eea7a03f', '5ab1e9e9-7cf9-4ff4-b074-ad8ca2fedadc', '0ab4d66b-8556-44bb-a644-812c7d829d13', 4, 'Hãy chuẩn bị khăn giấy trước khi xem', '2025-04-03 18:50:03', '2025-04-03 18:50:03', NULL),
('902f7ad3-4a02-4c92-91ce-3311fdabf293', '38338c27-965e-497d-8fe2-85f0ba6969b5', 'd8c80e08-4383-4fa2-83d7-48fb98dfc27f', 2, 'Không ổn. Không cập nhật đầy đủ.', '2025-04-03 18:46:45', '2025-04-10 17:42:10', '2025-04-10 17:42:10'),
('b073f071-be31-4103-8893-92f33280fabd', '38338c27-965e-497d-8fe2-85f0ba6969b5', '10641914-3e5d-4648-abd9-d4b7771998cf', 4, 'Thông tin hữu ích, nhưng mà hơi ngắn', '2025-04-03 18:46:12', '2025-04-10 17:35:35', NULL),
('c36d3a44-33cc-42fa-a546-f0c90c858106', 'c3fe8800-1518-43b0-850c-04f4bb3d461e', 'd8c80e08-4383-4fa2-83d7-48fb98dfc27f', 5, 'Quá ý nghĩa. Một địa điểm bất kỳ người Việt Nam nào cũng nên qua thăm một lần.', '2025-04-03 18:47:17', '2025-04-03 18:47:17', NULL),
('efabab4a-ff74-4f06-91e8-5b85c7ca0a4b', '2145e19e-59e3-4d76-84a6-bc76ca38e7c9', 'd8c80e08-4383-4fa2-83d7-48fb98dfc27f', 4, 'Chắc chắn xịn hơn Đà Lạt', '2025-04-03 18:47:42', '2025-04-03 18:47:42', NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `magazine_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
