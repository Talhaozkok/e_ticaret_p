-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 03 Oca 2022, 11:35:32
-- Sunucu sürümü: 10.4.18-MariaDB
-- PHP Sürümü: 7.4.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `project_1`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tbl_kullanici`
--

CREATE TABLE `tbl_kullanici` (
  `id` int(11) NOT NULL,
  `kullanici_adi` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `sifre` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `tbl_kullanici`
--

INSERT INTO `tbl_kullanici` (`id`, `kullanici_adi`, `sifre`, `type`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 1),
(3, 'sezer', 'e10adc3949ba59abbe56e057f20f883e', 1),
(4, 'ekin', 'e10adc3949ba59abbe56e057f20f883e', 2),
(5, 'test@admin.com', 'e10adc3949ba59abbe56e057f20f883e', 2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tbl_sepet`
--

CREATE TABLE `tbl_sepet` (
  `id` int(11) NOT NULL,
  `urun_id` int(11) NOT NULL,
  `urun_miktari` int(11) NOT NULL,
  `urun_adi` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `urun_fiyati` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `kullanici_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `tbl_sepet`
--

INSERT INTO `tbl_sepet` (`id`, `urun_id`, `urun_miktari`, `urun_adi`, `urun_fiyati`, `kullanici_id`) VALUES
(1, 1, 63, 'test ürün', '12', 3),
(2, 2, 6, 'Deneme ürünü', '100', 3),
(3, 5, 1, 'Deneme ürünü 2', '100', 4),
(4, 5, 5, 'Deneme ürünü 2', '100', 3),
(5, 4, 1, 'Deneme ürünü', '100', 3),
(6, 1, 1, 'test ürün', '12', 5),
(7, 1, 1, 'test ürün', '12', 4),
(8, 4, 1, 'Deneme ürünü', '100', 4),
(9, 47, 1, 'test ', '22', 3),
(10, 46, 1, 'test ürün', '123', 1),
(11, 5, 1, 'Deneme ürünü 2', '100', 1),
(12, 4, 1, 'Deneme ürünü', '100', 1),
(13, 1, 1, 'test ürün', '12', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tbl_urunler`
--

CREATE TABLE `tbl_urunler` (
  `id` int(11) NOT NULL,
  `urun_adi` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `urun_resmi` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `urun_aciklamasi` text COLLATE utf8_turkish_ci NOT NULL,
  `urun_fiyati` float NOT NULL,
  `kategori` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `tbl_urunler`
--

INSERT INTO `tbl_urunler` (`id`, `urun_adi`, `urun_resmi`, `urun_aciklamasi`, `urun_fiyati`, `kategori`) VALUES
(1, 'test ürün', '1638486865.jpg', 'test aciklama', 12, 1),
(4, 'Deneme ürünü', '1638486865.jpg', 'deneme açıklaması   ', 100, 2),
(5, 'Deneme ürünü 2', '1638486865.jpg', 'deneme açıklaması 2', 100, 3),
(46, 'test ürün', '1640462839297.jpg', '123', 123, 4),
(47, 'test ', '1629138714189.jpg', '11', 22, 4);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urun_detay_resim`
--

CREATE TABLE `urun_detay_resim` (
  `id` int(11) NOT NULL,
  `img` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `urun_id` varchar(255) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `urun_detay_resim`
--

INSERT INTO `urun_detay_resim` (`id`, `img`, `urun_id`) VALUES
(7, '4.jpg', '44'),
(8, '1640462101404.jpg', '7'),
(9, '1640462839297.jpg', '8'),
(10, '1640462839297.jpg', '45'),
(11, '1640472760190.jpg', '45'),
(12, '1640472760426.jpg', '45'),
(13, '1640472768235.jpg', '45'),
(14, 'test1.jpg', '45'),
(15, 'test2.jpg', '45'),
(16, '1640462839297.jpg', '46'),
(17, '1640472760190.jpg', '46'),
(18, '1640472760426.jpg', '46'),
(19, '1629138714189.jpg', '47'),
(20, '1640461655525.jpg', '47'),
(21, '1640462081102.jpg', '47');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `tbl_kullanici`
--
ALTER TABLE `tbl_kullanici`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `tbl_sepet`
--
ALTER TABLE `tbl_sepet`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `tbl_urunler`
--
ALTER TABLE `tbl_urunler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `urun_detay_resim`
--
ALTER TABLE `urun_detay_resim`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `tbl_kullanici`
--
ALTER TABLE `tbl_kullanici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `tbl_sepet`
--
ALTER TABLE `tbl_sepet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Tablo için AUTO_INCREMENT değeri `tbl_urunler`
--
ALTER TABLE `tbl_urunler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Tablo için AUTO_INCREMENT değeri `urun_detay_resim`
--
ALTER TABLE `urun_detay_resim`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
