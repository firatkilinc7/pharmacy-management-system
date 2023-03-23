-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 23 Mar 2023, 14:07:43
-- Sunucu sürümü: 10.4.22-MariaDB
-- PHP Sürümü: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `pharmacy`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `email_settings`
--

CREATE TABLE `email_settings` (
  `id` int(11) UNSIGNED NOT NULL,
  `protocol` varchar(10) COLLATE utf8_turkish_ci DEFAULT NULL,
  `host` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  `port` varchar(10) COLLATE utf8_turkish_ci DEFAULT '',
  `user` varchar(100) COLLATE utf8_turkish_ci DEFAULT '',
  `password` varchar(100) COLLATE utf8_turkish_ci DEFAULT '',
  `from` varchar(100) COLLATE utf8_turkish_ci DEFAULT '',
  `to` varchar(100) COLLATE utf8_turkish_ci DEFAULT '',
  `user_name` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  `isActive` tinyint(1) DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `email_settings`
--

INSERT INTO `email_settings` (`id`, `protocol`, `host`, `port`, `user`, `password`, `from`, `to`, `user_name`, `isActive`, `createdAt`) VALUES
(8, 'smtp', 'smtp.host.com', '587', 'user@user.com', 'pass', 'from@from.com', 'to@to.com', 'TITLE | TITLE', 1, '2022-11-29 17:19:37');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ilaclar`
--

CREATE TABLE `ilaclar` (
  `id` int(11) UNSIGNED NOT NULL,
  `barkod` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `ilac_adi` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `sgk_indirim` int(11) DEFAULT NULL,
  `expired_date` date NOT NULL,
  `ilac_fiyati` int(11) NOT NULL,
  `indirimli_fiyat` float NOT NULL,
  `raf_numarasi` varchar(11) COLLATE utf8_turkish_ci NOT NULL,
  `img_url` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `istendi` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `ilaclar`
--

INSERT INTO `ilaclar` (`id`, `barkod`, `ilac_adi`, `stok`, `sgk_indirim`, `expired_date`, `ilac_fiyati`, `indirimli_fiyat`, `raf_numarasi`, `img_url`, `istendi`) VALUES
(26, '12336987', 'Parol', 3, 40, '2022-12-01', 30, 18, 'B8', 'parol.jpg', 1),
(27, '78945674', 'Majezik', 20, 30, '2023-01-04', 60, 42, 'B7', 'majezik-kapak.png', 1),
(28, '47512354', 'VOONKA B12', 9, 10, '2023-06-15', 70, 63, 'C7', 'vitamin-b12-yeni-g.png', 1),
(29, '58712498', 'OCEAN C Vitamin', 40, 5, '2023-06-09', 140, 133, 'A7', 'ocean-vitamin-c-urun-kare.png', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `siparisler`
--

CREATE TABLE `siparisler` (
  `id` int(11) NOT NULL,
  `siparis_icerikleri` text NOT NULL,
  `toplam_fiyat` decimal(11,0) NOT NULL,
  `eczaci` varchar(30) NOT NULL,
  `siparis_tarihi` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `siparisler`
--

INSERT INTO `siparisler` (`id`, `siparis_icerikleri`, `toplam_fiyat`, `eczaci`, `siparis_tarihi`) VALUES
(54, 'Parol, ', '4278', 'hekocan', '2021-11-18 23:45:59'),
(55, 'Parol, ', '480', 'hekocan', '2022-01-11 23:49:03'),
(56, 'Parol, ', '420', 'firat', '2022-02-11 23:49:03'),
(57, 'Parol, ', '274', 'firat', '2022-03-11 23:49:03'),
(58, 'Parol, ', '347', 'firat', '2022-04-11 23:49:03'),
(59, 'Parol, ', '289', 'firat', '2022-05-11 23:49:03'),
(60, 'Parol, ', '341', 'firat', '2022-06-11 23:49:03'),
(61, 'Parol, ', '514', 'firat', '2022-07-11 23:49:03'),
(62, 'Parol, ', '376', 'firat', '2022-08-11 23:49:03'),
(63, 'Parol, ', '914', 'firat', '2022-09-11 23:49:03'),
(64, 'Parol, ', '870', 'firat', '2022-10-11 23:49:03'),
(65, 'Parol, ', '247', 'firat', '2022-11-11 23:49:03'),
(74, 'Parol, ', '90', 'hekocan', '2022-12-20 15:06:57'),
(75, 'Majezik, ', '100', 'hekocan', '2022-12-21 00:29:51'),
(76, 'Parol, ', '440', 'firat', '2022-12-30 01:49:03'),
(77, 'Parol, ', '1001', 'hekocan', '2023-01-06 01:49:03'),
(79, 'Parol, ', '1250', 'sadomazo', '2023-01-06 23:59:59'),
(80, 'Parol, ', '1477', 'firatkilinc7', '2023-01-07 15:59:59'),
(81, 'Parol, ', '800', 'firatkilinc7', '2023-01-16 15:59:59'),
(82, 'Parol, ', '300', 'firatkilinc7', '2023-01-17 15:59:59'),
(83, 'Parol, VOONKA B12, ', '815', 'hekocan', '2023-01-18 09:20:45'),
(84, 'VOONKA B12, ', '70', 'hekocan', '2023-01-18 14:28:38'),
(85, 'VOONKA B12, ', '70', 'hekocan', '2023-01-18 14:29:20'),
(86, 'VOONKA B12, ', '126', 'hekocan', '2023-01-18 16:10:29'),
(87, 'Parol, VOONKA B12, ', '250', 'hekocan', '2023-02-13 18:11:46'),
(88, 'Parol, VOONKA B12, ', '100', 'hekocan', '2023-03-18 18:11:46'),
(89, 'Parol, VOONKA B12, ', '250', 'hekocan', '2023-02-02 18:11:46'),
(90, 'Parol, VOONKA B12, ', '70', 'hekocan', '2023-03-14 18:11:46'),
(91, 'Parol, VOONKA B12, ', '100', 'firatkilinc7', '2023-03-18 18:11:46'),
(92, 'Parol, VOONKA B12, ', '70', 'sadomazo', '2023-03-14 18:11:46'),
(93, 'Parol, VOONKA B12, ', '15', 'firatkilinc7', '2023-03-23 14:11:46'),
(94, 'Parol, VOONKA B12, ', '40', 'firatkilinc7', '2023-03-22 14:11:46');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_name` varchar(50) COLLATE utf8_turkish_ci DEFAULT NULL,
  `full_name` varchar(50) COLLATE utf8_turkish_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_turkish_ci DEFAULT NULL,
  `password` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  `isActive` tinyint(4) DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `type` varchar(10) COLLATE utf8_turkish_ci NOT NULL DEFAULT 'anon'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `user_name`, `full_name`, `email`, `password`, `isActive`, `createdAt`, `type`) VALUES
(18, 'firatkilinc7', 'Fırat Kılınç', 'firatkilinc7@outlook.com', 'e10adc3949ba59abbe56e057f20f883e', 1, '2022-10-17 21:37:57', 'admin'),
(24, 'hekocan', 'Melih Yılmaz', 'hekoca@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, '2022-11-29 22:07:33', 'admin'),
(32, 'sadomazo', 'Sadikoglu', 'sados@sado.com', 'c8837b23ff8aaa8a2dde915473ce0991', 1, '2022-10-17 21:37:57', 'admin');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `email_settings`
--
ALTER TABLE `email_settings`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ilaclar`
--
ALTER TABLE `ilaclar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `siparisler`
--
ALTER TABLE `siparisler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `email_settings`
--
ALTER TABLE `email_settings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `ilaclar`
--
ALTER TABLE `ilaclar`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Tablo için AUTO_INCREMENT değeri `siparisler`
--
ALTER TABLE `siparisler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
