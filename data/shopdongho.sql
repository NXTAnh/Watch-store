-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 06, 2025 lúc 05:26 PM
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
-- Cơ sở dữ liệu: `shopdongho`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `binhluan`
--

CREATE TABLE `binhluan` (
  `id` int(11) NOT NULL,
  `nguoidung_id` int(11) NOT NULL,
  `mathang_id` int(11) NOT NULL,
  `noidung` text NOT NULL,
  `ngay` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `binhluan`
--

INSERT INTO `binhluan` (`id`, `nguoidung_id`, `mathang_id`, `noidung`, `ngay`) VALUES
(1, 29, 41, 'Hay', '2025-05-04 17:18:54'),
(2, 19, 41, 'Đẹp', '2025-05-04 17:24:01'),
(3, 30, 42, 'Xịn', '2025-05-04 17:59:35'),
(4, 19, 40, 'haha', '2025-05-04 18:01:05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhmuc`
--

CREATE TABLE `danhmuc` (
  `id` int(11) NOT NULL,
  `tendanhmuc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `danhmuc`
--

INSERT INTO `danhmuc` (`id`, `tendanhmuc`) VALUES
(13, 'Đồng Hồ Huawei'),
(14, 'Apple Watch');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `diachi`
--

CREATE TABLE `diachi` (
  `id` int(11) NOT NULL,
  `nguoidung_id` int(11) NOT NULL,
  `diachi` varchar(255) NOT NULL,
  `macdinh` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `diachi`
--

INSERT INTO `diachi` (`id`, `nguoidung_id`, `diachi`, `macdinh`) VALUES
(57, 19, 'g', 1),
(58, 19, 'gg', 1),
(59, 19, 'tt', 1),
(62, 19, 'ff', 1),
(64, 19, 'An Giang', 1),
(65, 19, 'an giang', 1),
(66, 19, 'Tri Tôn', 1),
(67, 19, 'Long Xuyên', 1),
(68, 19, 'Tân Châu', 1),
(69, 19, 'Long Xuyên, An Giang', 1),
(70, 30, 'Châu Đốc', 1),
(71, 30, 'Tri Tôn', 1),
(72, 19, 'aa', 1),
(73, 19, 'aa', 1),
(74, 19, 'Long Xuyên, An Giang', 1),
(75, 19, 'ds', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhang`
--

CREATE TABLE `donhang` (
  `id` int(11) NOT NULL,
  `nguoidung_id` int(11) NOT NULL,
  `diachi_id` int(11) DEFAULT NULL,
  `ngay` datetime NOT NULL DEFAULT current_timestamp(),
  `tongtien` float NOT NULL DEFAULT 0,
  `ghichu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `donhang`
--

INSERT INTO `donhang` (`id`, `nguoidung_id`, `diachi_id`, `ngay`, `tongtien`, `ghichu`) VALUES
(65, 19, 65, '2025-04-14 15:31:57', 15490000, NULL),
(67, 19, 67, '2025-04-14 15:56:23', 5490000, NULL),
(68, 19, 68, '2025-04-16 17:39:46', 1777780, NULL),
(69, 19, 69, '2025-04-16 19:54:17', 14980000, NULL),
(70, 30, 70, '2025-05-04 14:47:24', 4000000, NULL),
(71, 30, 71, '2025-05-04 18:34:52', 1777780, NULL),
(74, 19, 74, '2025-05-05 10:23:07', 9490000, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhangct`
--

CREATE TABLE `donhangct` (
  `id` int(11) NOT NULL,
  `donhang_id` int(11) NOT NULL,
  `mathang_id` int(11) DEFAULT NULL,
  `dongia` float NOT NULL DEFAULT 0,
  `soluong` int(11) NOT NULL DEFAULT 1,
  `thanhtien` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `donhangct`
--

INSERT INTO `donhangct` (`id`, `donhang_id`, `mathang_id`, `dongia`, `soluong`, `thanhtien`) VALUES
(89, 65, 40, 5000000, 2, 10000000),
(90, 65, 39, 5490000, 1, 5490000),
(92, 67, 39, 5490000, 1, 5490000),
(93, 68, 42, 888888, 2, 1777780),
(94, 69, 39, 5490000, 2, 10980000),
(95, 69, 38, 4000000, 1, 4000000),
(96, 70, 38, 4000000, 1, 4000000),
(97, 71, 42, 888888, 2, 1777780),
(100, 74, 38, 4000000, 1, 4000000),
(101, 74, 39, 5490000, 1, 5490000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khuyenmai`
--

CREATE TABLE `khuyenmai` (
  `id` int(11) NOT NULL,
  `tenkhuyenmai` varchar(255) NOT NULL,
  `mota` text DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `phantramgiam` decimal(5,2) NOT NULL,
  `ngaybatdau` date NOT NULL,
  `ngayketthuc` date NOT NULL,
  `trangthai` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `khuyenmai`
--

INSERT INTO `khuyenmai` (`id`, `tenkhuyenmai`, `mota`, `banner`, `phantramgiam`, `ngaybatdau`, `ngayketthuc`, `trangthai`) VALUES
(6, 'Giảm giá cho lễ 30/4-1/5', 'giảm tất cả các mặc hàng', 'images/anhkm2.png', 25.00, '2024-01-01', '2024-02-02', 0),
(8, 'Lễ 30/4-1/5', 'Lễ 30/4-1/5', 'images/anhkm1.png', 15.00, '2024-11-12', '2025-02-01', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mathang`
--

CREATE TABLE `mathang` (
  `id` int(11) NOT NULL,
  `tenmathang` varchar(255) NOT NULL,
  `mota` text DEFAULT NULL,
  `giagoc` float NOT NULL DEFAULT 0,
  `giaban` float NOT NULL DEFAULT 0,
  `soluongton` int(11) NOT NULL DEFAULT 0,
  `hinhanh` varchar(255) DEFAULT NULL,
  `danhmuc_id` int(11) NOT NULL,
  `luotxem` int(11) NOT NULL DEFAULT 0,
  `luotmua` int(11) NOT NULL DEFAULT 0,
  `trangthai` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `mathang`
--

INSERT INTO `mathang` (`id`, `tenmathang`, `mota`, `giagoc`, `giaban`, `soluongton`, `hinhanh`, `danhmuc_id`, `luotxem`, `luotmua`, `trangthai`) VALUES
(38, 'Đồng hồ thông minh Huawei Watch GT 5', '<p>Đồng hồ vjp</p>', 4200000, 4000000, 7, 'images/products/hwei1.jpg', 13, 14, 0, 1),
(39, 'Đồng hồ thông minh Huawei Watch GT 5 Pro', 'Đồng hồ vjp', 5999000, 5490000, 5, 'images/products/hwei2.jpg', 13, 17, 0, 1),
(40, 'Đồng hồ thông minh Huawei Watch GT 5', '<p>đồng hồ</p>', 10000000, 5000000, 7, 'images/products/hwei1.jpg', 13, 17, 0, 1),
(41, 'Đồng hồ thông minh Huawei Watch GT 5', '<p>1</p>', 999999, 111111, 1, 'images/products/hwei3.jpg', 13, 54, 0, 1),
(42, 'Apple Watch Ultra 2 2024 49mm 4G Viền Titan Dây Titan Size S', 'đồng hồ', 999999, 888888, 14, 'images/products/z6495765274947_43aa19ada980b2ffb4053a0ec80da3ca.jpg', 14, 9, 0, 1),
(46, 'Đồng hồ thông minh Huawei Watch GT 5', 'Vjp', 100000, 99000, 10, 'images/products/hwei3.jpg', 13, 5, 0, 1),
(48, 'Đồng hồ thông minh Apple Watch Vjp', 'Vjp', 500000, 999000, 10, 'images/products/z6495765274947_43aa19ada980b2ffb4053a0ec80da3ca.jpg', 14, 1, 0, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mathang_khuyenmai`
--

CREATE TABLE `mathang_khuyenmai` (
  `id` int(11) NOT NULL,
  `khuyenmai_id` int(11) NOT NULL,
  `mathang_id` int(11) NOT NULL,
  `soluong` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `mathang_khuyenmai`
--

INSERT INTO `mathang_khuyenmai` (`id`, `khuyenmai_id`, `mathang_id`, `soluong`, `created_at`) VALUES
(21, 8, 36, 1, '2025-04-09 08:39:09'),
(22, 8, 36, 1, '2025-04-09 08:39:37'),
(23, 9, 36, 1, '2025-04-09 08:40:42'),
(24, 9, 35, 1, '2025-04-09 08:40:42'),
(25, 9, 34, 1, '2025-04-09 08:40:42'),
(26, 8, 35, 2, '2025-04-09 08:42:06'),
(27, 8, 34, 2, '2025-04-09 08:42:06');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoidung`
--

CREATE TABLE `nguoidung` (
  `id` int(11) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `sodienthoai` varchar(10) NOT NULL,
  `matkhau` varchar(255) NOT NULL,
  `hoten` varchar(255) NOT NULL,
  `loai` tinyint(4) NOT NULL DEFAULT 3,
  `trangthai` tinyint(4) NOT NULL DEFAULT 1,
  `hinhanh` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoidung`
--

INSERT INTO `nguoidung` (`id`, `email`, `sodienthoai`, `matkhau`, `hoten`, `loai`, `trangthai`, `hinhanh`) VALUES
(1, 'Admin@gmail.com', '0988994683', '202cb962ac59075b964b07152d234b70', 'Tuong Anh', 1, 1, 'hwei2.jpg'),
(19, 'khachhang1@gmail.com', '0123456789', 'e10adc3949ba59abbe56e057f20f883e', 'khách hàng 1', 3, 1, NULL),
(20, 'nhanvien1@abc.com', '0123456789', 'e10adc3949ba59abbe56e057f20f883e', 'nhân viên 1', 2, 1, NULL),
(29, 'khachhang4@gmail.com', '0123456789', 'e10adc3949ba59abbe56e057f20f883e', 'khach hang 4', 3, 1, NULL),
(30, 'khachhang2@gmail.com', '0123456789', '202cb962ac59075b964b07152d234b70', 'khach hang 2', 3, 1, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `binhluan`
--
ALTER TABLE `binhluan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nguoidung_id` (`nguoidung_id`),
  ADD KEY `mathang_id` (`mathang_id`);

--
-- Chỉ mục cho bảng `danhmuc`
--
ALTER TABLE `danhmuc`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `diachi`
--
ALTER TABLE `diachi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nguoidung_id` (`nguoidung_id`);

--
-- Chỉ mục cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nguoidung_id` (`nguoidung_id`),
  ADD KEY `diachi_id` (`diachi_id`);

--
-- Chỉ mục cho bảng `donhangct`
--
ALTER TABLE `donhangct`
  ADD PRIMARY KEY (`id`),
  ADD KEY `donhang_id` (`donhang_id`),
  ADD KEY `mathang_id` (`mathang_id`);

--
-- Chỉ mục cho bảng `khuyenmai`
--
ALTER TABLE `khuyenmai`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `mathang`
--
ALTER TABLE `mathang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `danhmuc_id` (`danhmuc_id`);

--
-- Chỉ mục cho bảng `mathang_khuyenmai`
--
ALTER TABLE `mathang_khuyenmai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `khuyenmai_id` (`khuyenmai_id`),
  ADD KEY `mathang_id` (`mathang_id`);

--
-- Chỉ mục cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `binhluan`
--
ALTER TABLE `binhluan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `danhmuc`
--
ALTER TABLE `danhmuc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `diachi`
--
ALTER TABLE `diachi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT cho bảng `donhang`
--
ALTER TABLE `donhang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT cho bảng `donhangct`
--
ALTER TABLE `donhangct`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT cho bảng `khuyenmai`
--
ALTER TABLE `khuyenmai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `mathang`
--
ALTER TABLE `mathang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT cho bảng `mathang_khuyenmai`
--
ALTER TABLE `mathang_khuyenmai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `binhluan`
--
ALTER TABLE `binhluan`
  ADD CONSTRAINT `binhluan_ibfk_1` FOREIGN KEY (`nguoidung_id`) REFERENCES `nguoidung` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `binhluan_ibfk_2` FOREIGN KEY (`mathang_id`) REFERENCES `mathang` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `diachi`
--
ALTER TABLE `diachi`
  ADD CONSTRAINT `diachi_ibfk_1` FOREIGN KEY (`nguoidung_id`) REFERENCES `nguoidung` (`id`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `donhang_ibfk_1` FOREIGN KEY (`nguoidung_id`) REFERENCES `nguoidung` (`id`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `donhangct`
--
ALTER TABLE `donhangct`
  ADD CONSTRAINT `donhangct_ibfk_1` FOREIGN KEY (`donhang_id`) REFERENCES `donhang` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `donhangct_ibfk_2` FOREIGN KEY (`mathang_id`) REFERENCES `mathang` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `mathang`
--
ALTER TABLE `mathang`
  ADD CONSTRAINT `mathang_ibfk_1` FOREIGN KEY (`danhmuc_id`) REFERENCES `danhmuc` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
