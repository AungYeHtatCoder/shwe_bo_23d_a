-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 172.31.36.25
-- Generation Time: Feb 12, 2024 at 01:13 AM
-- Server version: 8.0.24
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ibet_sbo`
--

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `id` int NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `username` varchar(150) DEFAULT NULL,
  `password` text,
  `register_type` varchar(20) DEFAULT NULL,
  `third_party_id` varchar(100) DEFAULT NULL,
  `token` varchar(200) DEFAULT NULL,
  `device_id` varchar(200) DEFAULT NULL,
  `fcm_token` varchar(500) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `role` int NOT NULL DEFAULT '0',
  `gem` int NOT NULL DEFAULT '0',
  `bonus` int NOT NULL DEFAULT '0',
  `limit` int DEFAULT '0',
  `limit3` int DEFAULT '0',
  `cor` int DEFAULT '0',
  `cor3` int DEFAULT '0',
  `zero` int DEFAULT NULL,
  `remark` varchar(150) DEFAULT NULL,
  `chk` varchar(100) DEFAULT NULL,
  `photo` varchar(5) NOT NULL DEFAULT '0',
  `language` varchar(2) NOT NULL DEFAULT 'my',
  `active` datetime DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`id`, `name`, `phone`, `username`, `password`, `register_type`, `third_party_id`, `token`, `device_id`, `fcm_token`, `status`, `role`, `gem`, `bonus`, `limit`, `limit3`, `cor`, `cor3`, `zero`, `remark`, `chk`, `photo`, `language`, `active`, `created`, `updated`) VALUES
(12222, 'phyo', '09451816368', NULL, '6a8e824b207aac5992a449cb33a9799192621a8eff3f8758267e9b450cce5650', NULL, NULL, '12222-YQkVb0sN', 'QKQ1.191014.001', 'f0VZdhTjSR6PWtmm9lw-of:APA91bFmFoStmz_VJ10AlW9ENW-UNWvyVo3uVEc3Dlg4-HjxtZGYPTsPJVtsEORowutSAplUNs73AY-Hb2qcUsaHqHksiPuMIHcdWtRA6r_CO1grJDBdyQEn1xGYfluO7QnJ3XU9pHrA', 1, 1, 0, 0, 0, 0, 0, 0, NULL, NULL, '', '0', 'my', '2024-02-11 20:40:14', '2024-02-11 14:07:11', '2024-02-11 14:10:13'),
(12221, NULL, '09782568519', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, '047991', '0', 'my', NULL, '2024-02-11 14:06:09', '2024-02-11 14:06:09'),
(12220, NULL, '09663096846', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, '799958', '0', 'my', '2024-02-11 20:32:41', '2024-02-11 13:57:53', '2024-02-11 13:59:22'),
(12219, NULL, '09403081675', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '0', 'my', '2024-02-11 19:46:44', '2024-02-11 13:16:41', '2024-02-11 13:16:41'),
(12218, NULL, '09680944230', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '0', 'my', '2024-02-11 19:46:17', '2024-02-11 13:15:55', '2024-02-11 13:15:55'),
(12217, 'Hlaing Hlaing win', '09778421625', NULL, 'dfd65117f5a90cf87c1664e5f6db4d68b2d1e70e6bc2e96f9a5e40e995b0c066', NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0, NULL, NULL, '', '0', 'my', '2024-02-11 17:35:16', '2024-02-11 11:04:52', '2024-02-11 11:05:16'),
(12216, NULL, '09677022705', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '0', 'my', '2024-02-11 16:48:06', '2024-02-11 10:17:48', '2024-02-11 10:17:48'),
(12215, NULL, '09697203684', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '0', 'my', NULL, '2024-02-11 08:30:18', '2024-02-11 08:30:18'),
(12214, NULL, '09783198308', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '0', 'my', '2024-02-11 15:33:48', '2024-02-11 08:25:03', '2024-02-11 08:25:03'),
(12213, NULL, '09257031942', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '0', 'my', '2024-02-11 14:19:10', '2024-02-11 07:49:07', '2024-02-11 07:49:07'),
(12212, NULL, '09946250056', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '0', 'my', '2024-02-11 14:19:01', '2024-02-11 07:48:48', '2024-02-11 07:48:48'),
(12211, NULL, '09696703910', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '0', 'my', '2024-02-11 17:01:22', '2024-02-11 05:05:00', '2024-02-11 05:05:00'),
(12210, 'yeyekhai', '09779372454', NULL, '865f115199083fa41fae09e093926abb989971297bb664d8f4bb6deef6ac2cdc', NULL, NULL, '12210-xdjmfiKp', 'OPM1.171019.011', 'cJLki800T_Ky8UA9aCzhfY:APA91bEfmd5vGg7hlfJnPA6GoNA-GU0QmbtAIPuai7azeQS0nGT85zUuLUD_bgOd0NNOl5vu0x0LTTg6bmXHy0GyKvj6D7PCgwO3Ehj8HBXh2BCVcjPS0er9uo8cV3N96lhF0ruVxokO', 1, 1, 0, 0, 0, 0, 0, 0, NULL, NULL, '', '0', 'my', '2024-02-11 09:12:28', '2024-02-11 02:38:32', '2024-02-11 02:40:29'),
(12209, 'La Wi', '09789511262', NULL, 'eb641412c3183c270f697cabd72e0d46c91829b85dd6cb1807c943f04b4ed639', NULL, NULL, '12209-LRjx4mIE', 'UP1A.231005.007_NONFC', 'd-vu44xISFWlH75huDo7IC:APA91bHK581bsfMkBcgbNR3K3_swMW8tSDqVxCYlXfvTwYkIEVvTKInRVj2lXCy9qjF88vyvk0VAitYMSyfMHFN0vXPOysuuNg7eJXqPEI3SKriTwjoPLi0MogCBbugr0_pGdq030gf_', 1, 1, 0, 0, 0, 0, 0, 0, NULL, NULL, '', '0', 'my', '2024-02-11 22:01:20', '2024-02-10 16:45:24', '2024-02-11 15:31:19'),
(12208, 'Sein', '09455831602', NULL, '16ff9799639745d2b1165e369e8c7130effd4361d028391c032e1df78088be33', NULL, NULL, '12208-JXotjSKp', 'UP1A.231005.007', 'fQhZ65m9TDamNQEHqvLxhg:APA91bGax5VFuyAnD7iTkjnqQdGVBQp3X8Fz4J3P3VwTyzFjPwZGgAv__20PmL1M_mRmEw2AXoSaD0GjZfVgEJj9PDS1FbVmUQnoNEVdU9dQ5hEdErM10KhKdcVuyjgF1D2u20t1oNs_', 1, 1, 0, 0, 0, 0, 0, 0, NULL, NULL, '', '0', 'my', '2024-02-10 18:15:49', '2024-02-10 11:42:02', '2024-02-10 11:43:19'),
(12207, 'Buny', '09798535540', NULL, 'afc403aa04742bd8058af68d6cc3f6f20d7b73e277e65d0bc60ca19b060b0eee', NULL, NULL, '12207-izVQ9HI6', 'SP1A.210812.016', 'fiRQX0DMTyO0m9YGnWT9zQ:APA91bF-mksYkGoRskXefDCmuZv6_T_zq3HT6atTG9K-ecQNJutoFuuK1eqXBe_i6xONXJ7_oHe8XCrYwh_cT5B189cJdv5-WPzMHlXfoRpKtf6g0Pfu86DkJjrMq-Bnn1hQbxOG3wVW', 1, 1, 0, 0, 0, 0, 0, 0, NULL, NULL, '', '0', 'my', '2024-02-11 19:36:57', '2024-02-10 11:25:24', '2024-02-11 13:06:57'),
(12206, 'Sai Kyaw', '09400399699', NULL, '017390239faa20a05eda11b41cf394bb045bbb2d167df5adc05f32d07132547d', NULL, NULL, '12206-oN8p2mwM', 'UP1A.231005.007', 'fbeAJ5iQQqqqMZrYVR9Ndh:APA91bEwlNfYWVOnfy25kEEc6WX1erzFeIy4nLWTXLg0GSM_fhS_WnoNh8AP_4zVHQmnITAd74Y7YQiISPlUSmZh46AEkWZ4ppdimY_0IpRR5tPpIq1iEimak9dqxlqUaC5LUx24h_oA', 1, 1, 0, 0, 0, 0, 0, 0, NULL, NULL, '', '0', 'my', '2024-02-10 10:42:45', '2024-02-10 04:10:33', '2024-02-10 04:12:45'),
(12205, 'myo gyi', '09698033241', NULL, '32f5416086e1d726154bd455d4f78fe2b94e272c60401be12773a76313333a67', NULL, NULL, '12205-LsgNPorb', 'PPR1.180610.011', 'dFjhWzBlQJGNQtMK6Iw7Df:APA91bGZdOGeHg6S5pE31CZ2uJrjgivNaqODQ3AJ257QLD1WSZYnMY7WgRU8pJ4lk3NJIHrimxjUqhKmjeNOhJzej8J8SkVKPPRVakkg1S6-pzHUDa-NKq8pYn73gGJHUZ37d81zLs11', 1, 1, 5000, 0, 0, 0, 0, 0, NULL, NULL, NULL, '0', 'my', '2024-02-10 13:34:11', '2024-02-09 10:31:02', '2024-02-10 06:58:50'),
(12204, 'Tun Tun', '09688539808', NULL, '90b6e93d6b800287c97cd2a1165a0f8c337eb802a3eacb6eabcdb2c2213c3c44', NULL, NULL, '12204-SIimXWUL', 'RP1A.200720.012', 'e81XpGQpQzSDad4-E9Zysd:APA91bEETbBAHD4HOy3q-xzn4l_qJXqZbZU2E633huTRdRU0nGhp2zV09fpkIDLoCAJW371sNvFKiIg6T95Q7GWWO4WU8xobanmXyvvnvQi3qCqGh4V6FBVn_pjdvFgd8DcSMyZuMOv6', 1, 1, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '0', 'my', '2024-02-11 18:18:00', '2024-02-09 10:29:59', '2024-02-11 11:47:53'),
(12197, 'Amayarmg', '09970000591', NULL, '87a5b0b6059c9b68099f53e74c38fb70f6e2aca7b98d350931eba9f2f50f1451', NULL, NULL, '12197-PKaBBN2k', 'PKQ1.180904.001', 'dnwxA7aGRtGQKkXmgRsfqd:APA91bEqfE-lfMdTZHp2Ez2Q-Xf5SrXhcIbN2-JcppObgvqbsJE1EPrcxArtfgZXmh3igiUWS9atY8o1zSlYWW3vZnziWEaHekr5-THsNnLJ-pifDSv8zWtTsAh42p6oKYfT3uV66NyS', 1, 1, 0, 0, 0, 0, 0, 0, NULL, NULL, '', '0', 'my', '2024-02-10 08:06:11', '2024-02-09 06:25:18', '2024-02-10 01:35:56'),
(12194, 'Aye   Ko', '09780301641', NULL, '1c1732a02cb32812316732f41c5d813f4e140b9a3346f15ba402633c944b2096', NULL, NULL, '12194-laHhQXbY', 'HUAWEIDUB-LX2', 'cQlo9H5GRVKLeOTjRI2sPP:APA91bFaQXCrYU4XN6ngn9JX6V4BNaLLlKRvEAMp8WkjXVzaK_MyfaHT-HTgW3oViyhguMTJOCqkGMJ92VxUWYvyAQQ-JmDthjaO6d2eI9mEnafeudJbXOVIob68ZBqzOBYBmL0fFXKj', 1, 1, 13500, 0, 0, 0, 0, 0, NULL, NULL, '', '0', 'my', '2024-02-10 14:02:14', '2024-02-09 03:03:49', '2024-02-10 07:50:37'),
(12193, 'Lucky Libera', '09699808157', NULL, '5b7b69aed678781c74938dbdd70c8951cf0eb9b437532725d46213524a34795a', NULL, NULL, '12193-Qpr0WF0C', 'MRA58K', 'eHJMchJTTgWERY_dD1CoVz:APA91bHoiEoDukn2NQ6IjXlfO_ju0g3RuOtsbWPCPKqteDLXwkphF9AcTYW-SswGwm6yK2gIVqEj7NRAWh6ZZg_mcYJjxny-Pt5fdkNHj0WYRKRB2Uc-IldyERhvn05ELK9t5K7zPCQZ', 1, 1, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '0', 'my', '2024-02-09 16:36:26', '2024-02-09 02:37:46', '2024-02-09 10:06:18'),
(12192, 'zuzukyi', '09264059105', NULL, '7b1daeadce94f357847b340f72790e124250e7ef3fa87cf8cb46a732906c1b42', NULL, NULL, '12192-4566jw6g', 'SP1A.210812.016', 'dd3_KqDvQ0KkHAWTwAmo58:APA91bFv-HYDRFudCwEy9BYROB2UJwkcrL2TxItgnOyaqo2HW0mGwlJKBPcrU-im_gxu1vdomI0Vc---KXsdYP7B_QG1_8YnZlDoMsS5eq_2bAamzJkUe9a2rCH2a7o69leFPagsno5z', 1, 1, 0, 0, 0, 0, 0, 0, NULL, NULL, '', '0', 'my', '2024-02-11 10:11:57', '2024-02-09 01:54:44', '2024-02-11 03:41:57'),
(12191, 'Hnin wai khaing', '09797044046', NULL, 'a4cd336bc565a2500d2bfd228bea180cabc21d206477bc3708a9eeb1a5d6d20f', NULL, NULL, '12191-NlvJoEpc', 'RP1A.200720.011', 'eScjxqcmQoyHfumzu-8z3q:APA91bHjmhaSRxQnJMjkz9171IHjP25xcSDcwWdlLo_-eqFbgfWaAMM3_c-mvLxPhhiGkbyO-oseLdYumNoM5SgOhV2RAmZFl4mItSKid4CsxGX_DaQXsIEwgJ5B-McfO_yzN2EAgZX1', 1, 1, 0, 0, 0, 0, 0, 0, NULL, NULL, '', '0', 'my', '2024-02-08 22:40:12', '2024-02-08 16:02:42', '2024-02-08 16:07:24'),
(12186, 'naymyo', '09440434535', NULL, 'dd3ae0563356fbdec28be9a72c9f33000be52bf817200356694bee8e9fdbf0f2', NULL, NULL, '12186-sH6CeJiF', 'TP1A.220624.014', 'cz__YRH5QjO1Q644SQ_VXo:APA91bGdmyV1XS3tImNiahH9iFuw38QCv9LIXjpCshL36ZhyzF8d7KTAmV_8IZXFjVLh_CEEPWigniboGBxAS7aiEICTewe3MrpU6Nc0H06jiYTRG2cbyL5krjnH_PjfGT5bxB1azy4A', 1, 1, 0, 0, 0, 0, 0, 0, NULL, NULL, '', '0', 'my', '2024-02-08 17:48:58', '2024-02-08 05:54:35', '2024-02-08 11:15:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12223;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
