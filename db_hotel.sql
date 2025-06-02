/*
SQLyog Community v13.1.9 (64 bit)
MySQL - 8.0.30 : Database - db_hotel
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `booking` */

DROP TABLE IF EXISTS `booking`;

CREATE TABLE `booking` (
  `booking_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `member_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `adult` int DEFAULT '0',
  `child` int DEFAULT '0',
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `special_request` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `total` decimal(10,1) DEFAULT '0.0',
  `currency` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `room_number` int DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `payment_method` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `property_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `room_type_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `room_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `expired_date` datetime DEFAULT NULL,
  `approved_date` datetime DEFAULT NULL,
  `tanggal_perubahan` datetime DEFAULT NULL,
  `status_hapus` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`booking_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `booking` */

insert  into `booking`(`booking_id`,`created_date`,`start_date`,`end_date`,`member_id`,`adult`,`child`,`status`,`special_request`,`total`,`currency`,`room_number`,`description`,`payment_method`,`property_id`,`room_type_id`,`room_id`,`user_id`,`expired_date`,`approved_date`,`tanggal_perubahan`,`status_hapus`) values 
('0WI0CE7U6Z','2025-05-05 08:59:04','2025-05-05','2025-05-06','NKKTQGT7KM',1,0,'Draft',NULL,36.6,'USD',NULL,NULL,NULL,'0DZTF6EPZA','5Z1N0ME271','CLP90D6OVF',NULL,'2025-05-05 09:29:04',NULL,NULL,'0'),
('1IG8KO9KGS','2025-05-05 08:54:51','2025-05-05','2025-05-06','NKKTQGT7KM',1,0,'Draft',NULL,36.6,'USD',NULL,NULL,NULL,'0DZTF6EPZA','5Z1N0ME271','CLP90D6OVF',NULL,'2025-05-05 09:24:51',NULL,NULL,'0'),
('GEYA39S9HS','2025-05-05 08:58:39','2025-05-05','2025-05-06','NKKTQGT7KM',1,0,'Draft',NULL,36.6,'USD',NULL,NULL,NULL,'0DZTF6EPZA','5Z1N0ME271','CLP90D6OVF',NULL,'2025-05-05 09:28:39',NULL,NULL,'0'),
('I3QQOG2DFV','2025-04-25 22:32:44','2025-04-24','2025-04-25','NKKTQGT7KM',1,0,'Completed',NULL,500000.0,'IDR',10,'pengunjung menginginkan laundry nanti siang',NULL,'0DZTF6EPZA','5Z1N0ME271','CLP90D6OVF','A6LFHUY4FW',NULL,'2025-04-29 20:32:07',NULL,'0'),
('OMZXNFY910','2025-05-04 13:24:22','2025-05-03','2025-05-04','NKKTQGT7KM',1,1,'Cancelled',NULL,36.5,'USD',NULL,NULL,NULL,'0DZTF6EPZA','5Z1N0ME271','CLP90D6OVF',NULL,'2025-05-04 13:54:22',NULL,NULL,'0'),
('Q61XUDBVTV','2025-05-04 13:00:36','2025-05-03','2025-05-04','NKKTQGT7KM',1,1,'Booked',NULL,36.5,'USD',NULL,NULL,NULL,'0DZTF6EPZA','5Z1N0ME271','CLP90D6OVF',NULL,'2025-05-04 13:30:36',NULL,NULL,'0'),
('X4Z3KKVWOO','2025-05-05 09:00:18','2025-05-05','2025-05-06','NKKTQGT7KM',1,0,'Booked','saya ingin ada bunga',36.6,'USD',NULL,NULL,'Pay at Hotel','0DZTF6EPZA','5Z1N0ME271','CLP90D6OVF',NULL,'2025-05-05 09:30:18',NULL,NULL,'0');

/*Table structure for table `facility` */

DROP TABLE IF EXISTS `facility`;

CREATE TABLE `facility` (
  `facility_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `category` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `facility_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_hapus` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_hapus` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_hapus` datetime DEFAULT NULL,
  PRIMARY KEY (`facility_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `facility` */

insert  into `facility`(`facility_id`,`created_date`,`category`,`facility_name`,`status_hapus`,`user_hapus`,`tanggal_hapus`) values 
('47PPAASV4M',NULL,'In-room Facilities','Cable TV','0',NULL,NULL),
('4Q6TUTDDZA',NULL,'General','Heater','0',NULL,NULL),
('5SZOMU7RZ5',NULL,'In-room Facilities','Safety deposit box','0',NULL,NULL),
('6K0J36BQAX',NULL,'Amenities & Toiletries','Tissue','0',NULL,NULL),
('8W6KW2ECZC',NULL,'General','Air Conditioner','0',NULL,NULL),
('9ZFSLZEEON',NULL,'Amenities & Toiletries','Shower Gel','0',NULL,NULL),
('HUFVTFABNO',NULL,'General','Laundry service','0',NULL,NULL),
('IY28NOD4SW',NULL,'In-room Facilities','Shower','0',NULL,NULL),
('J7ON81ZXUU',NULL,NULL,'Air Conditioner','1','A6LFHUY4FW','2025-04-21 12:59:41'),
('K2667J66SO',NULL,'In-room Facilities','Room service','0',NULL,NULL),
('KYKI6I78LS',NULL,'Amenities & Toiletries','Shampoo Gel','0',NULL,NULL),
('M8QJ4E9W7E',NULL,'General','Parking 24/7','0',NULL,NULL),
('M9QE5KBUZC',NULL,'General','Smoking area','0',NULL,NULL),
('OAXQA2LSF8',NULL,'In-room Facilities','Desk','0',NULL,NULL),
('SUDWTZ2TSA',NULL,'Amenities & Toiletries','Towel','0',NULL,NULL),
('VASA3E5RDU',NULL,'Amenities & Toiletries','Sitting Toilet','0',NULL,NULL),
('WRMLLIGN6K',NULL,'In-room Facilities','TV','0',NULL,NULL),
('WTWLGM6OL9',NULL,'In-room Facilities','Telephone','0',NULL,NULL),
('XKH9Z9YIVT',NULL,'Amenities & Toiletries','Bathtub','0',NULL,NULL);

/*Table structure for table `gallery` */

DROP TABLE IF EXISTS `gallery`;

CREATE TABLE `gallery` (
  `gallery_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `upload_date` datetime DEFAULT NULL,
  `gallery_url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `size` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `room_type_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_hapus` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_hapus` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_hapus` datetime DEFAULT NULL,
  PRIMARY KEY (`gallery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `gallery` */

insert  into `gallery`(`gallery_id`,`upload_date`,`gallery_url`,`size`,`room_type_id`,`user_id`,`status_hapus`,`user_hapus`,`tanggal_hapus`) values 
('0KPZY3UHSN','2025-04-21 12:29:22','uploads/roomtype/1745213362_room-1.jpg','39,82','5Z1N0ME271','A6LFHUY4FW','1','A6LFHUY4FW','2025-04-30 12:27:57'),
('1B63VPHNL7','2025-04-21 12:22:54','uploads/roomtype/1745213411_room-3.jpg','98,56','5Z1N1TDY1Y','A6LFHUY4FW','0','',NULL),
('3MZOEA8XZD','2025-04-21 12:30:11','uploads/roomtype/1745213411_room-3.jpg','44,81','GMQV5QVK9B','A6LFHUY4FW','0',NULL,NULL),
('EZXH7BED87','2025-04-21 00:29:54','uploads/1745170194_WIN_20231001_18_42_05_Pro.jpg','98,56','5Z1N1TDY1Y','A6LFHUY4FW','1',NULL,NULL),
('GQIGCPQ43N','2025-04-21 00:43:14','uploads/1745170994_WIN_20231001_18_42_12_Pro.jpg','110,85','5Z1N0ME271','A6LFHUY4FW','','',NULL),
('HDWB8I42Y9','2025-04-30 12:24:03','uploads/roomtype/1745990643_room1.jpg','53,08','5Z1N0ME271','A6LFHUY4FW','0',NULL,NULL),
('IA9QP0RI6X','2025-04-21 00:43:44','uploads/roomtype/1745213411_room-3.jpg','116,01','5Z1N1TDY1Y','A6LFHUY4FW','0','','2025-04-21 01:27:10'),
('ORZPQAXAY7','2025-04-21 12:23:14','uploads/roomtype/1745212994_WIN_20231001_18_42_30_Pro.jpg','83,04','5Z1N0ME271','A6LFHUY4FW','1','A6LFHUY4FW','2025-04-21 12:23:22'),
('PQ4X69M3EH','2025-04-21 00:43:50','uploads/1745171030_WIN_20231001_18_42_30_Pro.jpg','83,04','5Z1N0ME271','A6LFHUY4FW','1','A6LFHUY4FW','2025-04-21 01:27:28'),
('Q0O0YW09ME','2025-04-21 12:29:58','uploads/roomtype/1745213398_room-2.jpg','30,56','B1TUGN5WR4','A6LFHUY4FW','0',NULL,NULL),
('S4632JE1DI','2025-04-21 12:22:00','uploads/roomtype/1745212920_WIN_20231001_18_42_05_Pro.jpg','98,56','5Z1N0ME271','A6LFHUY4FW','1','A6LFHUY4FW','2025-04-21 12:22:27');

/*Table structure for table `member` */

DROP TABLE IF EXISTS `member`;

CREATE TABLE `member` (
  `member_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fullname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gender` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mobile_number` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `nationality` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `member_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `member_type_date` datetime DEFAULT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `point` int DEFAULT '0',
  `confirmation_code` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_hapus` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_hapus` datetime DEFAULT NULL,
  `user_hapus` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `member` */

insert  into `member`(`member_id`,`created_date`,`email`,`password`,`fullname`,`gender`,`mobile_number`,`birthdate`,`nationality`,`member_type`,`member_type_date`,`status`,`point`,`confirmation_code`,`status_hapus`,`tanggal_hapus`,`user_hapus`) values 
('7JI89C6RMR','2025-04-21 23:10:42','angga.putra0186@gmail.com','e10adc3949ba59abbe56e057f20f883e',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Pending',NULL,'482499','1',NULL,NULL),
('NKKTQGT7KM','2025-04-21 23:16:19','angga.putra0186@gmail.com','e10adc3949ba59abbe56e057f20f883e','Angga Putra Perdana','Male','082174311883','1986-01-01','Indonesia','Platinum','2025-04-21 23:16:19','Active',1000,'236837','0',NULL,NULL);

/*Table structure for table `member_log` */

DROP TABLE IF EXISTS `member_log`;

CREATE TABLE `member_log` (
  `member_log_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `member_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `point` int DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`member_log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `member_log` */

insert  into `member_log`(`member_log_id`,`created_date`,`member_id`,`user_id`,`type`,`point`,`description`) values 
('F8MSONH3IR','2025-04-28 17:19:56','NKKTQGT7KM','A6LFHUY4FW','Upgrade',500,'Upgrade member to <b>Gold</b>, point added 500 '),
('GUVRN867TQ','2025-04-28 17:21:00','NKKTQGT7KM','A6LFHUY4FW','Upgrade',500,'Upgrade member to <b>Platinum</b>, added 500 points ');

/*Table structure for table `member_type` */

DROP TABLE IF EXISTS `member_type`;

CREATE TABLE `member_type` (
  `member_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `urutan` int DEFAULT NULL,
  `point` int DEFAULT NULL,
  PRIMARY KEY (`member_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `member_type` */

insert  into `member_type`(`member_type`,`urutan`,`point`) values 
('Gold',2,500),
('Platinum',3,500),
('Silver',1,0);

/*Table structure for table `merchant` */

DROP TABLE IF EXISTS `merchant`;

CREATE TABLE `merchant` (
  `merchant_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `merchant_url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `merchant_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_hapus` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`merchant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `merchant` */

insert  into `merchant`(`merchant_id`,`created_date`,`name`,`email`,`password`,`status`,`merchant_url`,`address`,`phone`,`merchant_type`,`status_hapus`) values 
('A6LFHUY4FW',NULL,'Baba Restaurant','baba@gmail.com','e10adc3949ba59abbe56e057f20f883e','Admin','uploads/merchant/A6LFHUY4FW_baba restaurant.jpg','Jl. Kenangan','23103219030','Food','0'),
('EKJI0DDJ3F',NULL,'Kidzilla Batam','kidzillabatam@gmail.com',NULL,'Active','uploads/merchant/EKJI0DDJ3F_kidzillabatam.jpg','Grand Batam Mall, L3, Batu Selicin, Lubuk Baja, Batam City, Riau Islands 29444','02139229292','Goodies','0');

/*Table structure for table `merchant_type` */

DROP TABLE IF EXISTS `merchant_type`;

CREATE TABLE `merchant_type` (
  `merchant_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_hapus` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `merchant_type` */

insert  into `merchant_type`(`merchant_type`,`status_hapus`) values 
('Food','0'),
('Playground','0'),
('Goodies','0');

/*Table structure for table `newsletter` */

DROP TABLE IF EXISTS `newsletter`;

CREATE TABLE `newsletter` (
  `newsletter_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_hapus` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_hapus` datetime DEFAULT NULL,
  PRIMARY KEY (`newsletter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `newsletter` */

insert  into `newsletter`(`newsletter_id`,`created_date`,`email`,`status_hapus`,`tanggal_hapus`) values 
('9Z6OIVFC2M','2025-05-03 21:40:58','angga.putra0186@gmail.com','0',NULL);

/*Table structure for table `voucher` */

DROP TABLE IF EXISTS `voucher`;

CREATE TABLE `voucher` (
  `voucher_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `voucher_title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `voucher_url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `merchant_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `status_hapus` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`voucher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `voucher` */

insert  into `voucher`(`voucher_id`,`created_date`,`voucher_title`,`start_date`,`end_date`,`voucher_url`,`status`,`merchant_id`,`description`,`status_hapus`) values 
('TYHGBHNJKL','2025-04-30 15:49:24','Want Discount 20% per Transaction','2025-05-01','2025-05-15','uploads/voucher/TYHGBHNJKL_voucher10seafood.jpg','Publish','A6LFHUY4FW','Want 20% discount from every transaction? Book Orangesky hotel Now. \r\n','0'),
('ZD7KQFCLD0','2025-04-30 15:49:24','Discount Epic Sale up to 60%','2025-05-01','2025-05-31','uploads/voucher/ZD7KQFCLD0_kidzillavoucher.jpg','Publish','EKJI0DDJ3F','you can enjoy discounts of up to 60% on various travel-related products, including Kidzilla Batam tickets. This vouchertion is valid until May 31, 2025.','0');

/*Table structure for table `property` */

DROP TABLE IF EXISTS `property`;

CREATE TABLE `property` (
  `property_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `property_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telp` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `city` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `property_url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_hapus` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `property` */

insert  into `property`(`property_id`,`property_name`,`telp`,`email`,`city`,`address`,`property_url`,`status_hapus`) values 
('0DZTF6EPZA','OS Style Hotel Batam Centre','(62)778469004','info@orangeskygroup.co.id','Batam','Jl. Raja H. Fisabillilah, Komp. BTC Palm Spring  Blok B1 No 1, Batam Centre, Batam 29432. Kepulauan Riau, Indonesia','uploads/property/0DZTF6EPZA_os_batamcenter.jpg','0'),
('A6QHXM7D1K','OS Style Hotel Sagulung Batam','0813-6521-2020','info@orangeskygroup.co.id','Batam','Putri Hijau Complex, Jalan Letjen R. Suprapto, Sungai Langkai, Kec. Sagulung, Kota Batam, Kepulauan Riau 29425','uploads/property/A6QHXM7D1K_os_sagulung.jpg','0'),
('CQPXUHAFEM','OS Hotel Batu Aji Batam','(62)7784121004','osbatuaji@gmail.com','Batam','Ruko Limanda Blok D No 1 - 3, Batu Aji, 29348 Batam Center, Indonesia','uploads/property/CQPXUHAFEM_os_batu_aji.jpg','0'),
('CZRI3Y4YF9','OS Hotel Airport Batam','0823-2243-0555','info@orangeskygroup.co.id','Batam','Komplek Buana Vista Indah 1 Blok K No.100, Belian, Kec. Batam Kota, Kota Batam, Kepulauan Riau 29464','uploads/property/CZRI3Y4YF9_os_airport.jpg','0');

/*Table structure for table `room` */

DROP TABLE IF EXISTS `room`;

CREATE TABLE `room` (
  `room_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `room_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `room_type_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `property_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `discount` int DEFAULT NULL,
  `breakfast_price` int DEFAULT NULL,
  `is_breakfast` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_smoking` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_wifi` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_fitness` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_parking` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `adult` int DEFAULT NULL,
  `child` int DEFAULT NULL,
  `bed` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `total` int DEFAULT NULL,
  `status` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_hapus` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `room` */

insert  into `room`(`room_id`,`room_name`,`room_type_id`,`property_id`,`discount`,`breakfast_price`,`is_breakfast`,`is_smoking`,`is_wifi`,`is_fitness`,`is_parking`,`adult`,`child`,`bed`,`total`,`status`,`status_hapus`,`description`) values 
('CLP90D6OVF','With Breakfast','5Z1N0ME271','0DZTF6EPZA',NULL,100000,'1','1','1','1','1',2,1,'King',10,'Publish','0',''),
('JL0SBFUFH7','No Breakfast','5Z1N0ME271','0DZTF6EPZA',NULL,100000,'0','0','1','1','1',2,1,'Queen',10,'Publish','0','Perbaikan keran air');

/*Table structure for table `room_facility` */

DROP TABLE IF EXISTS `room_facility`;

CREATE TABLE `room_facility` (
  `room_facility_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `room_type_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `facility_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_hapus` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`room_facility_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `room_facility` */

insert  into `room_facility`(`room_facility_id`,`room_type_id`,`facility_id`,`status_hapus`) values 
('1P004Q8Z8G','5Z1N1TDY1Y','XKH9Z9YIVT','0'),
('4Q6TUTDDZA','5Z1N0ME271','4Q6TUTDDZA','0'),
('8W6KW2ECZC','B1TUGN5WR4','XKH9Z9YIVT','0'),
('E1SLDLJBLW','5Z1N0ME271','K2667J66SO','0'),
('EXCM6WOCT4','5Z1N0ME271','HUFVTFABNO','0'),
('II909KYIS0','5Z1N1TDY1Y','KYKI6I78LS','0'),
('J2GJS0YCIF','5Z1N0ME271','M8QJ4E9W7E','0'),
('OQDZWZ5G8R','5Z1N0ME271','47PPAASV4M','0'),
('TRQZKB8LWX','5Z1N0ME271','XKH9Z9YIVT','0'),
('VCXHYYQDVU','B1TUGN5WR4','9ZFSLZEEON','0'),
('WJIB1CVWPK','5Z1N1TDY1Y','9ZFSLZEEON','0'),
('YGTJ1UHH4N','QWSDF45FGT','XKH9Z9YIVT','0');

/*Table structure for table `room_type` */

DROP TABLE IF EXISTS `room_type`;

CREATE TABLE `room_type` (
  `room_type_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `room_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `property_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `space` int DEFAULT NULL,
  `price` int DEFAULT NULL,
  `price_usd` int DEFAULT NULL,
  `description` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_hapus` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`room_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `room_type` */

insert  into `room_type`(`room_type_id`,`room_type`,`property_id`,`space`,`price`,`price_usd`,`description`,`status_hapus`) values 
('5Z1N0ME271','Deluxe Twin Room','0DZTF6EPZA',20,500000,35,'Enjoy our deluxe twin room. This room has a twin bed with space around 20 meter square','0'),
('5Z1N1TDY1Y','Deluxe King Room','CZRI3Y4YF9',20,500000,35,'Enjoy our deluxe twin room. This room has a king bed with space around 20 meter square','0'),
('B1TUGN5WR4','Superior King Room','0DZTF6EPZA',34,600000,40,'This Superior room has a king bed with space around 34 meter square','0'),
('GMQV5QVK9B','Executive King Room','A6QHXM7D1K',42,600000,40,'This Executive room has a king bed with space around 42 meter square','0'),
('QWSDF45FGT','Executive Twin Room','0DZTF6EPZA',42,750000,45,'This Executive room has a twin bed with space around 42 meter square','0'),
('YHGNAHNJMK','Superior Twin Room','CQPXUHAFEM',34,750000,45,'This Superior room has a twin bed with space around 34 meter square','0');

/*Table structure for table `setting` */

DROP TABLE IF EXISTS `setting`;

CREATE TABLE `setting` (
  `setting_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `youtube` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `instagram` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `facebook` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `twitter` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `usd` int DEFAULT NULL,
  `last_update` date DEFAULT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `setting` */

insert  into `setting`(`setting_id`,`phone`,`email`,`address`,`youtube`,`instagram`,`facebook`,`twitter`,`usd`,`last_update`) values 
('RETWGBHYJK','0811-6687-008','info@orangeskygroup.co.id','Komplek Palm Spring Business Trade Centre, Jl. Gajah Mada No.1 - 3, Taman Baloi, Batam Kota, Batam City, Riau Islands 29432',NULL,'https://www.google.com/url?sa=t&source=web&rct=j&opi=89978449&url=https://www.instagram.com/orangeskyindonesia/&ved=2ahUKEwjygsvvv4aNAxWHyzgGHdbZOPoQ9zB6BAgnEAM&usg=AOvVaw2sfN2mg27OZNR1WWq22o_4',NULL,NULL,16459,'2025-05-07');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_hapus` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

insert  into `users`(`user_id`,`name`,`username`,`password`,`email`,`user_type`,`user_url`,`status_hapus`) values 
('2Q3JZWX8U3',NULL,'anton','e10adc3949ba59abbe56e057f20f883e',NULL,'Admin','uploads/users/2Q3JZWX8U3_Foto Profile.jpg','1'),
('9QHVJAGJZ7','Agus Salim','operator','e10adc3949ba59abbe56e057f20f883e','testputrind4@gmail.com','User','uploads/users/9QHVJAGJZ7_person.jpg','1'),
('A6LFHUY4FW','Anton Sujayanto','supri','e10adc3949ba59abbe56e057f20f883e','supri@yahoo.com','Admin','uploads/users/A6LFHUY4FW_Foto Profile.jpg','0'),
('GYBZQRLSBU','Hasta','hasta','e10adc3949ba59abbe56e057f20f883e','hasta@yahoo.com','Admin','uploads/users/GYBZQRLSBU_e-avatar.jpg','0'),
('WFRYK194X4','Deni Prasetyo','deni','e10adc3949ba59abbe56e057f20f883e','denipras@gmail.com','Admin','uploads/users/WFRYK194X4_d-avatar.jpg','0'),
('Y45EJXEZ8H','Anton Sujayanto','anton','e10adc3949ba59abbe56e057f20f883e',NULL,'Admin','uploads/users/Y45EJXEZ8H_Foto Profile.jpg','1'),
('ZJSOWXD10W','Deni Prasetyo','deni','e10adc3949ba59abbe56e057f20f883e','denipras@gmail.com','Admin','uploads/users/ZJSOWXD10W_d-avatar.jpg','1');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
