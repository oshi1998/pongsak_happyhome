-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2021 at 04:14 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pongsak_happyhome`
--

-- --------------------------------------------------------

--
-- Table structure for table `aboutus`
--

CREATE TABLE `aboutus` (
  `aboutus_content` longtext NOT NULL,
  `aboutus_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `aboutus`
--

INSERT INTO `aboutus` (`aboutus_content`, `aboutus_image`) VALUES
('<h1><strong>Pongsak Happy Home</strong></h1>\n\n<p>บริการที่พัก</p>\n\n<p>- ราคาถูก</p>\n\n<p>- สะอาด</p>\n\n<p>- ปลอดภัย</p>\n\n<p>&nbsp;</p>\n\n<p><img alt=\"\" src=\"http://localhost/pongsak_happyhome/assets/img/ckeditor/aboutus/8acbdae9ad670852ed085a548db43b14.webp\" style=\"float:left; height:200px; width:300px\" /></p>\n', '147bb67239b5fb393613696c8867de7c.webp');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `adm_username` varchar(255) NOT NULL COMMENT 'ชื่อผู้ใช้งาน',
  `adm_firstname` varchar(255) NOT NULL COMMENT 'ชื่อจริง',
  `adm_lastname` varchar(255) NOT NULL COMMENT 'นามสกุล',
  `adm_password` varchar(255) NOT NULL COMMENT 'รหัสผ่าน',
  `adm_created` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่สร้างข้อมูล',
  `adm_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'วันที่อัพเดตข้อมูลล่าสุด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`adm_username`, `adm_firstname`, `adm_lastname`, `adm_password`, `adm_created`, `adm_updated`) VALUES
('admin', 'admin', 'admin', '$2y$10$GxiLs8UynP3xinM23VqcmeiCb7sXrnMqmaZ2CGxjHk0IpaM5Ifj1e', '2021-09-03 14:27:25', '2021-09-06 06:48:15'),
('admin2', 'admin2', 'admin2', '$2y$10$8/XjfwceOp5Ahc.06t9fxuhJ19ZyfClBGStaqug3pQU8ejYRtt/Au', '2021-09-06 06:49:09', '2021-09-06 06:49:09'),
('toy', 'toy', 'toy', '$2y$10$trJQjNfnZG./9mMvAm0oUeQDOP5ro8YI3axmcAKndgALr4zXasCxe', '2021-09-06 05:35:29', '2021-09-06 06:25:56');

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `bank_id` varchar(12) NOT NULL,
  `bank_name` varchar(30) NOT NULL,
  `bank_branch` varchar(255) NOT NULL,
  `bank_owner` varchar(255) NOT NULL,
  `bank_img` text NOT NULL,
  `bank_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`bank_id`, `bank_name`, `bank_branch`, `bank_owner`, `bank_img`, `bank_created`) VALUES
('0332956555', 'กสิกรไทย', 'กระบี่', 'Pongsak Happy Home', '6145a05229e31.jpg', '2021-09-18 08:16:18'),
('4123452689', 'ไทยพาณิชย์', 'กระบี่', 'Pongsak Happy Home', '6145a0b80e52e.jpg', '2021-09-18 08:18:00');

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `b_id` varchar(255) NOT NULL COMMENT 'รหัสจอง',
  `b_cus_username` varchar(255) NOT NULL COMMENT 'ลูกค้า',
  `b_daterange` varchar(30) NOT NULL COMMENT 'ช่วงเวลา',
  `b_duration` int(11) NOT NULL COMMENT 'ระยเวลา',
  `b_check_in` date NOT NULL COMMENT 'เช็คอิน',
  `b_check_out` date NOT NULL COMMENT 'เช็คเอาท์',
  `b_time` time NOT NULL COMMENT 'เวลา',
  `b_cost` decimal(10,2) NOT NULL COMMENT 'ค่าใช้จ่าย',
  `b_rt_id` int(11) NOT NULL COMMENT 'ประเภทห้อง',
  `b_r_id` varchar(10) DEFAULT NULL COMMENT 'รหัสห้อง',
  `b_deposit_slip` text NOT NULL COMMENT 'สลิปค่ามัดจำ',
  `b_deposit_datetime` datetime NOT NULL COMMENT 'วันเวลาที่โอน',
  `b_bank_id` varchar(12) NOT NULL COMMENT 'โอนเข้าบัญชี',
  `b_bank_name` varchar(30) NOT NULL COMMENT 'ชื่อธนาคาร',
  `b_bank_branch` varchar(255) NOT NULL COMMENT 'สาขา',
  `b_bank_owner` varchar(255) NOT NULL COMMENT 'เจ้าของบัญชีที่รับ',
  `b_status` text NOT NULL COMMENT 'สถานะ',
  `b_note` text NOT NULL COMMENT 'หมายเหตุ',
  `b_check_in_datetime` datetime NOT NULL COMMENT 'ลูกค้าเช็คอิน',
  `b_check_out_datetime` datetime NOT NULL COMMENT 'ลูกค้าเช็คเอาท์',
  `b_date` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่จอง',
  `b_last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'อัพเดตล่าสุด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`b_id`, `b_cus_username`, `b_daterange`, `b_duration`, `b_check_in`, `b_check_out`, `b_time`, `b_cost`, `b_rt_id`, `b_r_id`, `b_deposit_slip`, `b_deposit_datetime`, `b_bank_id`, `b_bank_name`, `b_bank_branch`, `b_bank_owner`, `b_status`, `b_note`, `b_check_in_datetime`, `b_check_out_datetime`, `b_date`, `b_last_update`) VALUES
('b-6155a6d522b1f', 'test007', '2021-10-07 - 2021-10-09', 2, '2021-10-07', '2021-10-09', '12:00:00', '1000.00', 6, '113', 'b-6155a6d522b1f.jpg', '2021-09-30 20:53:00', '4123452689', '4123452689', 'กระบี่', 'Pongsak Happy Home', 'สำเร็จ', 'โปรดชำระอีก 50% วันที่เช็คอิน แล้วพบกัน ขอให้ท่านเดินทางมาโดยสวัสดิภาพ', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-09-30 12:00:21', '2021-09-30 13:57:03');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `cus_username` varchar(255) NOT NULL COMMENT 'ชื่อผู้ใช้งาน',
  `cus_firstname` varchar(255) NOT NULL COMMENT 'ชื่อจริง',
  `cus_lastname` varchar(255) NOT NULL COMMENT 'นามสกุล',
  `cus_gender` varchar(10) NOT NULL COMMENT 'เพศ',
  `cus_password` varchar(255) NOT NULL COMMENT 'รหัสผ่าน',
  `cus_email` varchar(255) NOT NULL COMMENT 'อีเมล',
  `cus_address` text NOT NULL COMMENT 'ที่อยู่',
  `cus_phone` char(10) NOT NULL COMMENT 'เบอร์โทรศัพท์',
  `cus_profile` text NOT NULL COMMENT 'ภาพโปรไฟล์',
  `cus_created` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่สร้างข้อมูล',
  `cus_active` varchar(10) NOT NULL DEFAULT 'Enable' COMMENT 'สถานะใช้งาน',
  `cus_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'วันที่อัพเดตข้อมูลล่าสุด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`cus_username`, `cus_firstname`, `cus_lastname`, `cus_gender`, `cus_password`, `cus_email`, `cus_address`, `cus_phone`, `cus_profile`, `cus_created`, `cus_active`, `cus_updated`) VALUES
('test001', 'test001', 'test001', 'ชาย', '$2y$10$IJWYIrnqGqJCF7.6pyf8TeIf7MCkO5BBL41qejMb5ggJ6olo2FLpu', 'test001@gmail.com', 'test', '0955555555', 'test001.jpg', '2021-09-03 12:10:56', 'Enable', '2021-09-07 12:57:01'),
('test002', 'test002', 'test002', 'ชาย', '$2y$10$j9R/0F4eH10a.mnrITHdm.MkTU6kkQ5ERx7KwbLxh1vlCyn2wVsHe', 'test002@gmail.com', 'test', '0955555555', 'avatar_male.JPG', '2021-09-03 12:15:48', 'Enable', '2021-09-06 13:41:03'),
('test003', 'test003', 'test003', 'ชาย', '$2y$10$5lVTBcL./1E5j3zsO95NVedHPa2CyApLPCESYBJ8KIyhD0YdoZLY6', 'test003@gmail.com', 'test', '0955555555', 'avatar_male.JPG', '2021-09-03 12:16:33', 'Enable', '2021-09-06 13:41:03'),
('test004', 'test004', 'test004', 'ชาย', '$2y$10$DMgvyKb9Ma4.WJx7CWawCuNxQZc4dXJbntCDlVfVXdOF8OfNqHRJq', 'test004@gmail.com', 'test', '0955555555', 'avatar_male.JPG', '2021-09-03 12:17:04', 'Enable', '2021-09-06 13:41:03'),
('test005', 'test005', 'test005', 'ชาย', '$2y$10$QQ3XenWUxiP8Yk6xKHh54.ivfsPAPnj1JFBrKDQtb2iYJRIs4su36', 'test004@gmail.com', 'test', '0955555555', 'avatar_male.JPG', '2021-09-03 12:17:17', 'Enable', '2021-09-06 13:41:03'),
('test006', 'test006', 'test006', 'หญิง', '$2y$10$ZW45bY2lUw8haC6Iig8owO6KuQMHXHhQkh8TLchMgKhnloilyHIMO', 'test006@gmail.com', 'test006', '0999999999', 'avatar_female.JPG', '2021-09-06 13:55:35', 'Enable', '2021-09-06 13:55:35'),
('test007', 'test007', 'test007', 'หญิง', '$2y$10$hKYTozyUzrTlCTS2nN9S6O2UDSG8ZZUhF4J6iBPyY82RqmSkIZjuK', 'test007@gmail.com', 'test', '0955555555', 'avatar_female.JPG', '2021-09-06 23:13:15', 'Enable', '2021-09-06 23:13:15'),
('test008', 'test008', 'test008', 'หญิง', '$2y$10$aKW1VghWqDlsrMGKjU.Vle4RF2Auz.sqLGc95.avSMhKem0FS3gCG', 'test008@gmail.com', 'test', '0955555555', 'avatar_female.JPG', '2021-09-06 23:21:09', 'Enable', '2021-09-06 23:21:09'),
('test009', 'test009', 'test009', 'ชาย', '$2y$10$gtAza3iK04M/cSu.9PMrN.SlLpbvzQa.kRWt0zJ8odvyx6kr3wGOi', 'test009@gmail.com', 'test009', '0999999999', 'test009.jpg', '2021-09-06 23:33:03', 'Enable', '2021-09-07 03:27:46');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `img_id` int(11) NOT NULL COMMENT 'รหัสรูป',
  `file_name` text NOT NULL COMMENT 'ชื่อไฟล์',
  `rt_id` int(10) NOT NULL COMMENT 'รหัสประเภทห้อง',
  `img_created` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่เพิ่มรูปภาพ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`img_id`, `file_name`, `rt_id`, `img_created`) VALUES
(15, '61407efb8ebd7.jpg', 4, '2021-09-14 10:52:43'),
(16, '61407efb980dd.jpg', 4, '2021-09-14 10:52:43'),
(17, '61407f294b639.webp', 6, '2021-09-14 10:53:29'),
(18, '61407fcce0d03.webp', 6, '2021-09-14 10:56:12'),
(19, '61407fe15b5cf.webp', 5, '2021-09-14 10:56:33'),
(20, '61407feca02d5.webp', 6, '2021-09-14 10:56:44');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `r_id` varchar(10) NOT NULL COMMENT 'เลขห้อง',
  `rt_id` int(11) NOT NULL COMMENT 'รหัสประเภทห้อง',
  `r_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'วันที่เพิ่มข้อมูล',
  `r_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'วันที่อัพเดตข้อมูลล่าสุด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`r_id`, `rt_id`, `r_created`, `r_updated`) VALUES
('101', 4, '2021-09-07 13:08:55', '2021-09-07 13:08:55'),
('102', 4, '2021-09-07 13:09:01', '2021-09-07 13:09:01'),
('103', 4, '2021-09-07 13:09:05', '2021-09-07 13:09:05'),
('104', 4, '2021-09-07 13:09:09', '2021-09-07 13:09:09'),
('105', 4, '2021-09-07 13:09:13', '2021-09-07 13:09:13'),
('106', 4, '2021-09-07 13:09:17', '2021-09-07 13:09:17'),
('107', 4, '2021-09-07 13:09:22', '2021-09-07 13:09:22'),
('108', 4, '2021-09-07 13:09:28', '2021-09-07 13:09:28'),
('109', 5, '2021-09-07 13:09:54', '2021-09-07 13:09:54'),
('110', 5, '2021-09-07 13:10:00', '2021-09-07 13:10:00'),
('111', 5, '2021-09-07 13:10:05', '2021-09-07 13:10:05'),
('112', 5, '2021-09-07 13:10:12', '2021-09-07 13:10:12'),
('113', 6, '2021-09-07 13:10:25', '2021-09-07 13:10:25');

-- --------------------------------------------------------

--
-- Table structure for table `roomtypes`
--

CREATE TABLE `roomtypes` (
  `rt_id` int(11) NOT NULL COMMENT 'รหัสประเภท',
  `rt_name` varchar(255) NOT NULL COMMENT 'ชื่อประเภท',
  `rt_image` text NOT NULL COMMENT 'รูปภาพหลัก',
  `rt_view` int(11) NOT NULL COMMENT 'ยอดวิว',
  `rt_content` longtext NOT NULL COMMENT 'เนื้อหา',
  `rt_price` decimal(10,2) NOT NULL COMMENT 'ราคาห้องพัก/คืน',
  `rt_created` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่เพิ่มข้อมูล',
  `rt_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'วันที่อัพเดตข้อมูลล่าสุด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roomtypes`
--

INSERT INTO `roomtypes` (`rt_id`, `rt_name`, `rt_image`, `rt_view`, `rt_content`, `rt_price`, `rt_created`, `rt_updated`) VALUES
(4, 'Standard', '40313a15b706e08be92086eb20c2954b.jpg', 4837, 'ห้อง Standard', '300.00', '2021-09-07 13:07:38', '2021-09-30 11:38:10'),
(5, 'Superior', 'b4d3270e1280b00f9721e4368ab5defa.jpeg', 5533, 'ห้อง Superior', '400.00', '2021-09-07 13:08:00', '2021-09-28 10:23:31'),
(6, 'Deluxe', '6fb8525562aeb158e879fb6634b3462b.webp', 4963, 'ห้อง Deluxe', '500.00', '2021-09-07 13:08:16', '2021-09-21 09:47:48');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `sv_id` int(11) NOT NULL,
  `sv_no` int(11) NOT NULL,
  `sv_icon` text NOT NULL,
  `sv_heading` varchar(100) NOT NULL,
  `sv_desc` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`sv_id`, `sv_no`, `sv_icon`, `sv_heading`, `sv_desc`) VALUES
(4, 2, '<i class=\'bx bxs-magic-wand\'></i>', 'ทำความสะอาด', 'มีแม่บ้านบริการทำความสะอาด ตั้งแต่เวลา 09.00 - 17.00 น.'),
(5, 1, '<i class=\'bx bx-shield-quarter\'></i>', 'ดูแลรักษาความปลอดภัย', 'มีเจ้าหน้าที่คอยดูแลรักษาความปลอดภัยตลอด 24 ชั่วโมง'),
(7, 3, '<i class=\'bx bxs-parking\' ></i>', 'ที่จอดรถ', 'พื้นที่จอดรถสะดวก สามารถทจอดได้ทั้งรถมอเตอร์ไซค์ และรถยนต์');

-- --------------------------------------------------------

--
-- Table structure for table `website`
--

CREATE TABLE `website` (
  `web_name` varchar(255) NOT NULL COMMENT 'ชื่อเว็บไซต์',
  `web_description` text NOT NULL COMMENT 'คำอธิบายเว็บไซต์',
  `web_keywords` text NOT NULL COMMENT 'คำค้นหาเว็บไซต์',
  `web_address` text NOT NULL COMMENT 'ทีอยู่เว็บไซต์',
  `web_phone` char(10) NOT NULL COMMENT 'เบอร์โทรศัพท์',
  `web_email` varchar(255) NOT NULL COMMENT 'อีเมล',
  `web_facebook` text NOT NULL COMMENT 'ลิ้ง Facebook',
  `web_ig` text NOT NULL COMMENT 'ลิ้ง IG',
  `web_youtube` text NOT NULL COMMENT 'ลิ้ง Youtube',
  `web_twitter` text NOT NULL COMMENT 'ลิ้ง Twitter',
  `web_google_map` text NOT NULL COMMENT 'Iframe Google map'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `website`
--

INSERT INTO `website` (`web_name`, `web_description`, `web_keywords`, `web_address`, `web_phone`, `web_email`, `web_facebook`, `web_ig`, `web_youtube`, `web_twitter`, `web_google_map`) VALUES
('Pongsak Happy Home', 'บริการที่พัก Pongsak Happy Home', 'Pongsak,happy,home,บริการที่พัก', 'A142/2 ถนนเจ้าฟ้า ตำบลไสไทย อำเภอเมืองกระบี่ กระบี่ 81000', '0616604587', 'pongsak_happyhome@gmail.com', '', '', '', '', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3950.398612746867!2d98.905051!3d8.06076!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb4a0317d7416670b!2z4Lie4LiH4Lio4LmM4Lio4Lix4LiB4LiU4Li04LmMIOC5geC4ruC4m-C4m-C4teC5iSDguYLguK7guKE!5e0!3m2!1sth!2sth!4v1630920140475!5m2!1sth!2sth\" width=\"800\" height=\"600\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\"></iframe>');

-- --------------------------------------------------------

--
-- Table structure for table `welcome`
--

CREATE TABLE `welcome` (
  `welcome_head` text NOT NULL COMMENT 'หัวเรื่อง',
  `welcome_desc` text NOT NULL COMMENT 'คำอธิบาย',
  `welcome_img` text NOT NULL COMMENT 'รูปภาพ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `welcome`
--

INSERT INTO `welcome` (`welcome_head`, `welcome_desc`, `welcome_img`) VALUES
('ยินดีต้อนรับสู่ PONGSAK HAPPY HOME', 'บริการที่พักราคาถูก สะอาด ปลอดภัย', '1bb0bb68630701bdd4a7a16613b951d6.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`adm_username`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`bank_id`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`b_id`),
  ADD KEY `b_cus_username` (`b_cus_username`),
  ADD KEY `b_r_id` (`b_r_id`),
  ADD KEY `b_rt_id` (`b_rt_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`cus_username`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`img_id`),
  ADD KEY `rt_id` (`rt_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`r_id`),
  ADD KEY `rt_id` (`rt_id`);

--
-- Indexes for table `roomtypes`
--
ALTER TABLE `roomtypes`
  ADD PRIMARY KEY (`rt_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`sv_id`),
  ADD KEY `sv_no` (`sv_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสรูป', AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `roomtypes`
--
ALTER TABLE `roomtypes`
  MODIFY `rt_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสประเภท', AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `sv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`b_cus_username`) REFERENCES `customers` (`cus_username`),
  ADD CONSTRAINT `book_ibfk_2` FOREIGN KEY (`b_r_id`) REFERENCES `rooms` (`r_id`),
  ADD CONSTRAINT `book_ibfk_3` FOREIGN KEY (`b_rt_id`) REFERENCES `roomtypes` (`rt_id`);

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`rt_id`) REFERENCES `roomtypes` (`rt_id`);

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`rt_id`) REFERENCES `roomtypes` (`rt_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
