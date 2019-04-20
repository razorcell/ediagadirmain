-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for ediagadir_user_mgn
CREATE DATABASE IF NOT EXISTS `ediagadir_user_mgn` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `ediagadir_user_mgn`;

-- Dumping structure for table ediagadir_user_mgn.audit
CREATE TABLE IF NOT EXISTS `audit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `page` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ip` varchar(255) NOT NULL,
  `viewed` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table ediagadir_user_mgn.audit: ~8 rows (approximately)
DELETE FROM `audit`;
/*!40000 ALTER TABLE `audit` DISABLE KEYS */;
INSERT INTO `audit` (`id`, `user`, `page`, `timestamp`, `ip`, `viewed`) VALUES
	(1, 0, '4', '2019-04-17 15:35:07', '::1', 0),
	(2, 0, '4', '2019-04-18 13:52:14', '::1', 0),
	(3, 0, '4', '2019-04-18 13:53:42', '::1', 0),
	(4, 0, '111', '2019-04-18 14:09:30', '::1', 0),
	(5, 2, '4', '2019-04-18 16:20:11', '::1', 0),
	(6, 0, '111', '2019-04-18 16:33:20', '::1', 0),
	(7, 0, '4', '2019-04-19 14:05:22', '::1', 0),
	(8, 0, '111', '2019-04-19 14:27:28', '::1', 0),
	(9, 0, '111', '2019-04-19 16:13:34', '::1', 0),
	(10, 0, '4', '2019-04-19 18:49:39', '::1', 0),
	(11, 0, '4', '2019-04-19 19:46:16', '::1', 0),
	(12, 19, '107', '2019-04-19 19:58:21', '::1', 0),
	(13, 19, '107', '2019-04-19 19:58:25', '::1', 0),
	(14, 19, '107', '2019-04-19 19:58:34', '::1', 0),
	(15, 19, '121', '2019-04-19 20:24:53', '::1', 0),
	(16, 19, '121', '2019-04-19 20:37:27', '::1', 0),
	(17, 19, '121', '2019-04-19 20:37:29', '::1', 0),
	(18, 19, '121', '2019-04-19 20:41:33', '::1', 0),
	(19, 19, '121', '2019-04-19 20:41:42', '::1', 0),
	(20, 19, '121', '2019-04-19 20:41:51', '::1', 0),
	(21, 19, '121', '2019-04-19 20:41:56', '::1', 0),
	(22, 19, '122', '2019-04-19 21:07:25', '::1', 0),
	(23, 19, '122', '2019-04-19 21:07:28', '::1', 0),
	(24, 19, '121', '2019-04-19 21:08:37', '::1', 0),
	(25, 19, '122', '2019-04-19 21:08:40', '::1', 0),
	(26, 19, '122', '2019-04-19 21:11:28', '::1', 0),
	(27, 19, '121', '2019-04-19 21:11:46', '::1', 0),
	(28, 19, '122', '2019-04-19 21:11:48', '::1', 0),
	(29, 19, '122', '2019-04-19 21:16:16', '::1', 0),
	(30, 19, '122', '2019-04-19 21:20:56', '::1', 0);
/*!40000 ALTER TABLE `audit` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.crons
CREATE TABLE IF NOT EXISTS `crons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` int(1) NOT NULL DEFAULT '1',
  `sort` int(3) NOT NULL,
  `name` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `createdby` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table ediagadir_user_mgn.crons: ~1 rows (approximately)
DELETE FROM `crons`;
/*!40000 ALTER TABLE `crons` DISABLE KEYS */;
INSERT INTO `crons` (`id`, `active`, `sort`, `name`, `file`, `createdby`, `created`, `modified`) VALUES
	(1, 0, 100, 'Auto-Backup', 'backup.php', 1, '2017-09-16 07:49:22', '2017-11-11 21:15:36');
/*!40000 ALTER TABLE `crons` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.crons_logs
CREATE TABLE IF NOT EXISTS `crons_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cron_id` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table ediagadir_user_mgn.crons_logs: ~0 rows (approximately)
DELETE FROM `crons_logs`;
/*!40000 ALTER TABLE `crons_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `crons_logs` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.email
CREATE TABLE IF NOT EXISTS `email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `website_name` varchar(100) NOT NULL,
  `smtp_server` varchar(100) NOT NULL,
  `smtp_port` int(10) NOT NULL,
  `email_login` varchar(150) NOT NULL,
  `email_pass` varchar(100) NOT NULL,
  `from_name` varchar(100) NOT NULL,
  `from_email` varchar(150) NOT NULL,
  `transport` varchar(255) NOT NULL,
  `verify_url` varchar(255) NOT NULL,
  `email_act` int(1) NOT NULL,
  `debug_level` int(1) NOT NULL DEFAULT '0',
  `isSMTP` int(1) NOT NULL DEFAULT '0',
  `isHTML` varchar(5) NOT NULL DEFAULT 'true',
  `useSMTPauth` varchar(6) NOT NULL DEFAULT 'true',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table ediagadir_user_mgn.email: ~1 rows (approximately)
DELETE FROM `email`;
/*!40000 ALTER TABLE `email` DISABLE KEYS */;
INSERT INTO `email` (`id`, `website_name`, `smtp_server`, `smtp_port`, `email_login`, `email_pass`, `from_name`, `from_email`, `transport`, `verify_url`, `email_act`, `debug_level`, `isSMTP`, `isHTML`, `useSMTPauth`) VALUES
	(1, 'EDI Agadir systems', 'smtp.gmail.com', 587, 'k.rmili@exchange-data.com', '149121720252833', 'EDI Agadir Systems (Admin)', 'k.rmili@exchange-data.com', 'tls', 'http://localhost/ediagadir/', 0, 2, 1, 'true', 'true');
/*!40000 ALTER TABLE `email` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.groups_menus
CREATE TABLE IF NOT EXISTS `groups_menus` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) unsigned NOT NULL,
  `menu_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

-- Dumping data for table ediagadir_user_mgn.groups_menus: 30 rows
DELETE FROM `groups_menus`;
/*!40000 ALTER TABLE `groups_menus` DISABLE KEYS */;
INSERT INTO `groups_menus` (`id`, `group_id`, `menu_id`) VALUES
	(30, 2, 9),
	(29, 0, 8),
	(28, 0, 7),
	(27, 0, 21),
	(5, 0, 3),
	(6, 0, 1),
	(7, 0, 2),
	(8, 0, 51),
	(9, 0, 52),
	(10, 0, 37),
	(11, 0, 38),
	(12, 2, 39),
	(13, 2, 40),
	(14, 2, 41),
	(15, 2, 42),
	(16, 2, 43),
	(17, 2, 44),
	(18, 2, 45),
	(19, 0, 46),
	(20, 0, 47),
	(21, 0, 49),
	(26, 0, 20),
	(25, 0, 18),
	(31, 2, 10),
	(32, 2, 11),
	(33, 2, 12),
	(34, 2, 13),
	(35, 2, 14),
	(36, 2, 15),
	(37, 0, 16);
/*!40000 ALTER TABLE `groups_menus` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.keys
CREATE TABLE IF NOT EXISTS `keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stripe_ts` varchar(255) NOT NULL,
  `stripe_tp` varchar(255) NOT NULL,
  `stripe_ls` varchar(255) NOT NULL,
  `stripe_lp` varchar(255) NOT NULL,
  `recap_pub` varchar(100) NOT NULL,
  `recap_pri` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table ediagadir_user_mgn.keys: ~0 rows (approximately)
DELETE FROM `keys`;
/*!40000 ALTER TABLE `keys` DISABLE KEYS */;
/*!40000 ALTER TABLE `keys` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.logs
CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(3) NOT NULL,
  `logdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `logtype` varchar(25) NOT NULL,
  `lognote` text NOT NULL,
  `ip` varchar(75) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=latin1;

-- Dumping data for table ediagadir_user_mgn.logs: 75 rows
DELETE FROM `logs`;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
INSERT INTO `logs` (`id`, `user_id`, `logdate`, `logtype`, `lognote`, `ip`) VALUES
	(1, 1, '2019-04-17 14:45:57', 'System Updates', 'Inserted ip to logs table', '::1'),
	(2, 1, '2019-04-17 14:45:57', 'System Updates', 'Update 2ZB9mg1l0JXe successfully deployed.', '::1'),
	(3, 1, '2019-04-17 14:45:57', 'System Updates', 'Update B9t6He7qmFXa successfully deployed.', '::1'),
	(4, 1, '2019-04-17 14:45:57', 'System Updates', 'Updated group_menu int columns to 11 and unsigned', '::1'),
	(5, 1, '2019-04-17 14:45:57', 'System Updates', 'Updated users int columns to 11 and unsigned', '::1'),
	(6, 1, '2019-04-17 14:45:57', 'System Updates', 'Update 86FkFVV4TGRg successfully deployed.', '::1'),
	(7, 1, '2019-04-17 14:45:57', 'System Updates', 'Added default language to settings table', '::1'),
	(8, 1, '2019-04-17 14:45:57', 'System Updates', 'Added default language to settings table', '::1'),
	(9, 1, '2019-04-17 14:45:57', 'System Updates', 'Added language info to settings table', '::1'),
	(10, 1, '2019-04-17 14:45:58', 'System Updates', 'Added default language to settings table', '::1'),
	(11, 1, '2019-04-17 14:45:58', 'System Updates', 'Modified menus for multilanguage', '::1'),
	(12, 1, '2019-04-17 14:45:58', 'System Updates', 'Modified menus for multilanguage', '::1'),
	(13, 1, '2019-04-17 14:45:58', 'System Updates', 'Modified menus for multilanguage', '::1'),
	(14, 1, '2019-04-17 14:45:58', 'System Updates', 'Modified menus for multilanguage', '::1'),
	(15, 1, '2019-04-17 14:45:58', 'System Updates', 'Modified menus for multilanguage', '::1'),
	(16, 1, '2019-04-17 14:45:58', 'System Updates', 'Modified menus for multilanguage', '::1'),
	(17, 1, '2019-04-17 14:45:58', 'System Updates', 'Modified menus for multilanguage', '::1'),
	(18, 1, '2019-04-17 14:45:58', 'System Updates', 'Modified menus for multilanguage', '::1'),
	(19, 1, '2019-04-17 14:45:58', 'System Updates', 'Modified menus for multilanguage', '::1'),
	(20, 1, '2019-04-17 14:45:58', 'System Updates', 'Modified menus for multilanguage', '::1'),
	(21, 1, '2019-04-17 14:45:58', 'System Updates', 'Modified menus for multilanguage', '::1'),
	(22, 1, '2019-04-17 14:45:58', 'System Updates', 'Modified menus for multilanguage', '::1'),
	(23, 1, '2019-04-17 14:45:58', 'System Updates', 'Modified menus for multilanguage', '::1'),
	(24, 1, '2019-04-17 14:45:58', 'System Updates', 'Modified menus for multilanguage', '::1'),
	(25, 1, '2019-04-17 14:45:58', 'System Updates', 'Modified menus for multilanguage', '::1'),
	(26, 1, '2019-04-17 14:45:58', 'System Updates', 'Update y4A1Y0u9n2Rt successfully deployed.', '::1'),
	(27, 1, '2019-04-17 14:45:58', 'System Updates', 'Modified menus for multilanguage', '::1'),
	(28, 1, '2019-04-17 14:45:58', 'System Updates', 'Update Tm5xY22MM8eC successfully deployed.', '::1'),
	(29, 1, '2019-04-17 14:45:58', 'System Updates', 'Update 0YXdrInkjV86F successfully deployed.', '::1'),
	(30, 1, '2019-04-17 14:46:40', 'User', 'User logged in.', NULL),
	(31, 1, '2019-04-17 15:35:15', 'User', 'User logged in.', NULL),
	(32, 1, '2019-04-18 13:49:19', 'User', 'User logged in.', NULL),
	(33, 1, '2019-04-18 13:50:03', 'User', 'User logged in.', NULL),
	(34, 1, '2019-04-18 13:50:28', 'User Manager', 'Updated password for Sample.', '::1'),
	(35, 1, '2019-04-18 13:52:32', 'User', 'User logged in.', NULL),
	(36, 1, '2019-04-18 13:58:13', 'User', 'User logged in.', NULL),
	(37, 1, '2019-04-18 14:09:02', 'Pages Manager', 'Added 1 permission(s) to excelanalyzer/index.php.', '::1'),
	(38, 1, '2019-04-18 14:09:02', 'Pages Manager', 'Retitled \'excelanalyzer/index.php\' to \'Home page of Excel analyzer\'.', '::1'),
	(39, 2, '2019-04-18 14:10:22', 'User', 'User logged in.', NULL),
	(40, 2, '2019-04-18 14:11:52', 'User', 'User logged in.', NULL),
	(41, 2, '2019-04-18 15:07:38', 'User', 'User logged in.', NULL),
	(42, 11, '2019-04-18 16:26:51', 'User', 'Registration completed.', '::1'),
	(43, 12, '2019-04-18 16:32:57', 'User', 'Registration completed.', '::1'),
	(44, 1, '2019-04-19 13:11:02', 'Email Settings', 'Updated website_name from User Spice to EDI Agadir systems.', '::1'),
	(45, 1, '2019-04-19 13:11:02', 'Email Settings', 'Updated email_login.', '::1'),
	(46, 1, '2019-04-19 13:11:02', 'Email Settings', 'Updated email_pass.', '::1'),
	(47, 1, '2019-04-19 13:11:02', 'Email Settings', 'Updated from_name from User Spice to Khalifa rmili.', '::1'),
	(48, 1, '2019-04-19 13:11:02', 'Email Settings', 'Updated from_email from yourEmail@gmail.com to khalifa.rmili@gmail.com.', '::1'),
	(49, 1, '2019-04-19 13:11:02', 'Email Settings', 'Updated verify_url from http://localhost/43 to http://localhost/ediagadir.', '::1'),
	(50, 1, '2019-04-19 13:11:02', 'Email Settings', 'Updated email_act from 0 to 4.', '::1'),
	(51, 1, '2019-04-19 13:19:50', 'Email Settings', 'Updated isSMTP from 0 to 1.', '::1'),
	(52, 1, '2019-04-19 13:22:25', 'Email Settings', 'Updated useSMTPauth from true to false.', '::1'),
	(53, 1, '2019-04-19 13:31:16', 'Email Settings', 'Updated email_act from 4 to 2.', '::1'),
	(54, 1, '2019-04-19 13:31:16', 'Email Settings', 'Updated useSMTPauth from false to true.', '::1'),
	(55, 1, '2019-04-19 13:40:02', 'Email Settings', 'Updated email_login.', '::1'),
	(56, 1, '2019-04-19 13:40:02', 'Email Settings', 'Updated email_pass.', '::1'),
	(57, 1, '2019-04-19 13:42:10', 'Email Settings', 'Updated email_act from 0 to 1.', '::1'),
	(58, 1, '2019-04-19 13:42:49', 'Email Settings', 'Updated from_name from Khalifa rmili to Khalifa rmili (Admin).', '::1'),
	(59, 1, '2019-04-19 13:42:50', 'Email Settings', 'Updated from_email from khalifa.rmili@gmail.com to k.rmili@exchange-data.com.', '::1'),
	(60, 1, '2019-04-19 13:43:51', 'Email Settings', 'Updated from_name from Khalifa rmili (Admin) to EDI Agadir Systems (Admin).', '::1'),
	(61, 1, '2019-04-19 13:55:12', 'User Manager', 'Deleted user named Khalifa.', '::1'),
	(62, 13, '2019-04-19 13:55:27', 'User', 'Registration completed and verification email sent.', '::1'),
	(63, 13, '2019-04-19 13:56:38', 'User', 'User logged in.', NULL),
	(64, 13, '2019-04-19 13:57:38', 'User', 'Verification completed via vericode.', '::1'),
	(65, 1, '2019-04-19 14:05:25', 'User', 'User logged in.', NULL),
	(66, 1, '2019-04-19 14:05:37', 'Email Settings', 'Updated verify_url from http://localhost/ediagadir to http://localhost/ediagadir/.', '::1'),
	(67, 1, '2019-04-19 14:06:22', 'User Manager', 'Deleted user named Tesetuserfname.', '::1'),
	(68, 14, '2019-04-19 14:08:01', 'User', 'Registration completed and verification email sent.', '::1'),
	(69, 14, '2019-04-19 14:08:21', 'User', 'Verification completed via vericode.', '::1'),
	(70, 14, '2019-04-19 14:08:36', 'User', 'User logged in.', NULL),
	(71, 14, '2019-04-19 14:15:50', 'User', 'User logged in.', NULL),
	(72, 1, '2019-04-19 14:26:56', 'User', 'User logged in.', NULL),
	(73, 1, '2019-04-19 14:27:15', 'User Manager', 'Updated first name for Tesetuserfname from Tesetuserfname to Tarik.', '::1'),
	(74, 1, '2019-04-19 14:27:15', 'User Manager', 'Updated last name for Tesetuserfname from Testuserlname to Boutzad.', '::1'),
	(75, 14, '2019-04-19 14:27:36', 'User', 'User logged in.', NULL),
	(76, 14, '2019-04-19 16:43:41', 'User', 'User logged in.', NULL),
	(77, 1, '2019-04-19 16:48:07', 'User Manager', 'Deleted user named Tarik.', '::1'),
	(78, 15, '2019-04-19 18:29:24', 'User', 'Registration completed and verification email sent.', '::1'),
	(79, 15, '2019-04-19 18:29:39', 'User', 'Verification completed via vericode.', '::1'),
	(80, 15, '2019-04-19 18:30:02', 'User', 'User logged in.', NULL),
	(81, 1, '2019-04-19 18:49:40', 'User', 'User logged in.', NULL),
	(82, 1, '2019-04-19 18:49:46', 'User Manager', 'Deleted user named Jamal.', '::1'),
	(83, 16, '2019-04-19 18:50:29', 'User', 'Registration completed and verification email sent.', '::1'),
	(84, 1, '2019-04-19 19:04:57', 'User Manager', 'Deleted user named Jamal.', '::1'),
	(85, 1, '2019-04-19 19:19:54', 'User Manager', 'Deleted user named Jamal.', '::1'),
	(86, 18, '2019-04-19 19:21:38', 'User', 'Registration completed and verification email sent.', '::1'),
	(87, 1, '2019-04-19 19:33:57', 'User Manager', 'Deleted user named Jamal.', '::1'),
	(88, 19, '2019-04-19 19:34:28', 'User', 'Registration completed and verification email sent.', '::1'),
	(89, 19, '2019-04-19 19:38:19', 'User', 'User logged in.', NULL),
	(90, 19, '2019-04-19 19:38:26', 'User', 'Verification completed via vericode.', '::1'),
	(91, 19, '2019-04-19 19:38:41', 'User', 'User logged in.', NULL),
	(92, 1, '2019-04-19 19:46:18', 'User', 'User logged in.', NULL),
	(93, 1, '2019-04-19 19:47:00', 'Email Settings', 'Updated email_act from 1 to 0.', '::1'),
	(94, 1, '2019-04-19 19:59:43', 'Pages Manager', 'Added 1 permission(s) to excelanalyzer/data_browser_page.php.', '::1'),
	(95, 1, '2019-04-19 21:12:05', 'Pages Manager', 'Added 1 permission(s) to excelanalyzer/administration.php.', '::1'),
	(96, 19, '2019-04-19 21:15:34', 'User', 'User logged in.', NULL),
	(97, 1, '2019-04-19 21:21:18', 'User', 'User logged in.', NULL);
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.logs_exempt
CREATE TABLE IF NOT EXISTS `logs_exempt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `createdby` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `logs_exempt_type` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table ediagadir_user_mgn.logs_exempt: 0 rows
DELETE FROM `logs_exempt`;
/*!40000 ALTER TABLE `logs_exempt` DISABLE KEYS */;
/*!40000 ALTER TABLE `logs_exempt` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.menus
CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `menu_title` varchar(255) NOT NULL,
  `parent` int(10) NOT NULL,
  `dropdown` int(1) NOT NULL,
  `logged_in` int(1) NOT NULL,
  `display_order` int(10) NOT NULL,
  `label` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `icon_class` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

-- Dumping data for table ediagadir_user_mgn.menus: 22 rows
DELETE FROM `menus`;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` (`id`, `menu_title`, `parent`, `dropdown`, `logged_in`, `display_order`, `label`, `link`, `icon_class`) VALUES
	(1, 'main', 2, 0, 1, 1, '{{home}}', '', 'fa fa-fw fa-home'),
	(2, 'main', -1, 1, 1, 14, '', '', 'fa fa-fw fa-cogs'),
	(3, 'main', -1, 0, 1, 11, '{{username}}', 'users/account.php', 'fa fa-fw fa-user'),
	(4, 'main', -1, 1, 0, 3, '{{help}}', '', 'fa fa-fw fa-life-ring'),
	(5, 'main', -1, 0, 0, 2, '{{register}}', 'users/join.php', 'fa fa-fw fa-plus-square'),
	(6, 'main', -1, 0, 0, 1, '{{login}}', 'users/login.php', 'fa fa-fw fa-sign-in'),
	(7, 'main', 2, 0, 1, 2, '{{account}}', 'users/account.php', 'fa fa-fw fa-user'),
	(8, 'main', 2, 0, 1, 3, '{{hr}}', '', ''),
	(9, 'main', 2, 0, 1, 4, '{{dashboard}}', 'users/admin.php', 'fa fa-fw fa-cogs'),
	(10, 'main', 2, 0, 1, 5, '{{users}}', 'users/admin.php?view=users', 'fa fa-fw fa-user'),
	(11, 'main', 2, 0, 1, 6, '{{perms}}', 'users/admin.php?view=permissions', 'fa fa-fw fa-lock'),
	(12, 'main', 2, 0, 1, 7, '{{pages}}', 'users/admin.php?view=pages', 'fa fa-fw fa-wrench'),
	(13, 'main', 2, 0, 1, 8, '{{messages}}', 'users/admin.php?view=messages', 'fa fa-fw fa-envelope'),
	(14, 'main', 2, 0, 1, 9, '{{logs}}', 'users/admin.php?view=logs', 'fa fa-fw fa-search'),
	(15, 'main', 2, 0, 1, 10, '{{hr}}', '', ''),
	(16, 'main', 2, 0, 1, 11, '{{logout}}', 'users/logout.php', 'fa fa-fw fa-sign-out'),
	(17, 'main', -1, 0, 0, 0, '{{home}}', '', 'fa fa-fw fa-home'),
	(18, 'main', -1, 0, 1, 10, '{{home}}', '', 'fa fa-fw fa-home'),
	(19, 'main', 4, 0, 0, 1, '{{forgot}}', 'users/forgot_password.php', 'fa fa-fw fa-wrench'),
	(20, 'main', -1, 0, 1, 12, '{{notifications}}', '', ''),
	(21, 'main', -1, 0, 1, 13, '{{messages}}', '', ''),
	(22, 'main', 4, 0, 0, 99999, '{{resend}}', 'users/verify_resend.php', 'fa fa-exclamation-triangle');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.messages
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msg_from` int(11) NOT NULL,
  `msg_to` int(11) NOT NULL,
  `msg_body` text NOT NULL,
  `msg_read` int(1) NOT NULL,
  `msg_thread` int(11) NOT NULL,
  `deleted` int(1) NOT NULL,
  `sent_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table ediagadir_user_mgn.messages: ~2 rows (approximately)
DELETE FROM `messages`;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` (`id`, `msg_from`, `msg_to`, `msg_body`, `msg_read`, `msg_thread`, `deleted`, `sent_on`) VALUES
	(1, 1, 2, '&lt;p&gt;fgds&lt;/p&gt;', 1, 1, 0, '2017-08-06 00:13:47'),
	(2, 1, 2, '&lt;p&gt;Did it work?&lt;/p&gt;', 1, 2, 0, '2017-09-09 15:10:09');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.message_threads
CREATE TABLE IF NOT EXISTS `message_threads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msg_to` int(11) NOT NULL,
  `msg_from` int(11) NOT NULL,
  `msg_subject` varchar(255) NOT NULL,
  `last_update` datetime NOT NULL,
  `last_update_by` int(11) NOT NULL,
  `archive_from` int(1) NOT NULL DEFAULT '0',
  `archive_to` int(1) NOT NULL DEFAULT '0',
  `hidden_from` int(1) NOT NULL DEFAULT '0',
  `hidden_to` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table ediagadir_user_mgn.message_threads: ~2 rows (approximately)
DELETE FROM `message_threads`;
/*!40000 ALTER TABLE `message_threads` DISABLE KEYS */;
INSERT INTO `message_threads` (`id`, `msg_to`, `msg_from`, `msg_subject`, `last_update`, `last_update_by`, `archive_from`, `archive_to`, `hidden_from`, `hidden_to`) VALUES
	(1, 2, 1, 'Testiing123', '2017-08-06 00:13:47', 1, 0, 0, 0, 0),
	(2, 2, 1, 'Testing Message Badge', '2017-09-09 15:10:09', 1, 0, 0, 0, 0);
/*!40000 ALTER TABLE `message_threads` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.notifications
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `message` mediumtext NOT NULL,
  `is_read` tinyint(4) NOT NULL,
  `is_archived` tinyint(1) DEFAULT '0',
  `date_created` datetime DEFAULT NULL,
  `date_read` datetime DEFAULT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Dumping data for table ediagadir_user_mgn.notifications: ~0 rows (approximately)
DELETE FROM `notifications`;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.pages
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(100) NOT NULL,
  `title` varchar(50) NOT NULL,
  `private` int(11) NOT NULL DEFAULT '0',
  `re_auth` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8;

-- Dumping data for table ediagadir_user_mgn.pages: ~49 rows (approximately)
DELETE FROM `pages`;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` (`id`, `page`, `title`, `private`, `re_auth`) VALUES
	(1, 'index.php', 'Home', 0, 0),
	(2, 'z_us_root.php', '', 0, 0),
	(3, 'users/account.php', 'Account Dashboard', 1, 0),
	(4, 'users/admin.php', 'Admin Dashboard', 1, 0),
	(14, 'users/forgot_password.php', 'Forgotten Password', 0, 0),
	(15, 'users/forgot_password_reset.php', 'Reset Forgotten Password', 0, 0),
	(16, 'users/index.php', 'Home', 0, 0),
	(17, 'users/init.php', '', 0, 0),
	(18, 'users/join.php', 'Join', 0, 0),
	(19, 'users/joinThankYou.php', 'Join', 0, 0),
	(20, 'users/login.php', 'Login', 0, 0),
	(21, 'users/logout.php', 'Logout', 0, 0),
	(24, 'users/user_settings.php', 'User Settings', 1, 0),
	(25, 'users/verify.php', 'Account Verification', 0, 0),
	(26, 'users/verify_resend.php', 'Account Verification', 0, 0),
	(31, 'users/oauth_success.php', '', 0, 0),
	(33, 'users/fb-callback.php', '', 0, 0),
	(38, 'users/google_helpers.php', '', 0, 0),
	(41, 'users/messages.php', 'Messages', 1, 0),
	(42, 'users/message.php', 'Messages', 1, 0),
	(45, 'users/maintenance.php', 'Maintenance', 0, 0),
	(49, 'users/admin_verify.php', 'Password Verification', 1, 0),
	(68, 'users/update.php', 'Update Manager', 1, 0),
	(74, 'users/admin_notifications.php', 'Notifications Manager', 1, 0),
	(76, 'users/enable2fa.php', 'Enable 2 Factor Auth', 1, 0),
	(77, 'users/disable2fa.php', 'Disable 2 Factor Auth', 1, 0),
	(82, 'users/manage2fa.php', 'Manage Two FA', 1, 0),
	(83, 'users/manage_sessions.php', 'Session Manager', 1, 0),
	(86, 'users/SSP.php', '', 1, 0),
	(87, 'users/features.ini.php', '', 1, 0),
	(88, 'users/loader.php', '', 1, 0),
	(89, 'users/twofa.php', '', 1, 0),
	(90, 'users/user_agreement_acknowledge.php', '', 1, 0),
	(104, 'usersc/empty.php', '', 1, 0),
	(106, 'excelanalyzer/addnewsource.php', '', 1, 0),
	(107, 'excelanalyzer/data_browser_page.php', '', 1, 0),
	(108, 'excelanalyzer/delete_source.php', '', 1, 0),
	(110, 'excelanalyzer/get_the_correct_columns_parameter_for_datatables.php', '', 1, 0),
	(111, 'excelanalyzer/index.php', 'Home page of Excel analyzer', 1, 0),
	(112, 'excelanalyzer/process_csv_file.php', '', 1, 0),
	(113, 'excelanalyzer/send_datables_data_as_json.php', '', 1, 0),
	(114, 'excelanalyzer/send_logs.php', '', 1, 0),
	(115, 'excelanalyzer/send_progress_json.php', '', 1, 0),
	(116, 'excelanalyzer/send_sources_list.php', '', 1, 0),
	(119, 'excelanalyzer/upload_script.php', '', 1, 0),
	(120, 'usersc/login.php', '', 1, 0),
	(121, 'excelanalyzer/manuals.php', '', 1, 0),
	(122, 'excelanalyzer/administration.php', '', 1, 0);
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table ediagadir_user_mgn.permissions: ~2 rows (approximately)
DELETE FROM `permissions`;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` (`id`, `name`) VALUES
	(1, 'User'),
	(2, 'Administrator');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.permission_page_matches
CREATE TABLE IF NOT EXISTS `permission_page_matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_id` int(15) NOT NULL,
  `page_id` int(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

-- Dumping data for table ediagadir_user_mgn.permission_page_matches: ~51 rows (approximately)
DELETE FROM `permission_page_matches`;
/*!40000 ALTER TABLE `permission_page_matches` DISABLE KEYS */;
INSERT INTO `permission_page_matches` (`id`, `permission_id`, `page_id`) VALUES
	(2, 2, 27),
	(3, 1, 24),
	(4, 1, 22),
	(5, 2, 13),
	(6, 2, 12),
	(7, 1, 11),
	(8, 2, 10),
	(9, 2, 9),
	(10, 2, 8),
	(11, 2, 7),
	(12, 2, 6),
	(13, 2, 5),
	(14, 2, 4),
	(15, 1, 3),
	(16, 2, 37),
	(17, 2, 39),
	(19, 2, 40),
	(21, 2, 41),
	(23, 2, 42),
	(27, 1, 42),
	(28, 1, 27),
	(29, 1, 41),
	(30, 1, 40),
	(31, 2, 44),
	(32, 2, 47),
	(33, 2, 51),
	(34, 2, 50),
	(35, 2, 49),
	(36, 2, 53),
	(37, 2, 52),
	(38, 2, 68),
	(39, 2, 55),
	(40, 2, 56),
	(41, 2, 71),
	(42, 2, 58),
	(43, 2, 57),
	(44, 2, 53),
	(45, 2, 74),
	(46, 2, 75),
	(47, 1, 75),
	(48, 1, 76),
	(49, 2, 76),
	(50, 1, 77),
	(51, 2, 77),
	(52, 2, 78),
	(53, 2, 80),
	(54, 1, 81),
	(55, 1, 82),
	(56, 1, 83),
	(57, 2, 84),
	(58, 1, 111),
	(59, 1, 107),
	(60, 2, 122);
/*!40000 ALTER TABLE `permission_page_matches` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.profiles
CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `bio` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Dumping data for table ediagadir_user_mgn.profiles: ~2 rows (approximately)
DELETE FROM `profiles`;
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
INSERT INTO `profiles` (`id`, `user_id`, `bio`) VALUES
	(1, 1, '&lt;h1&gt;This is the Admin&#039;s bio.&lt;/h1&gt;'),
	(2, 2, 'This is your bio');
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `recaptcha` int(1) NOT NULL DEFAULT '0',
  `force_ssl` int(1) NOT NULL,
  `css_sample` int(1) NOT NULL,
  `us_css1` varchar(255) NOT NULL,
  `us_css2` varchar(255) NOT NULL,
  `us_css3` varchar(255) NOT NULL,
  `site_name` varchar(100) NOT NULL,
  `language` varchar(255) NOT NULL,
  `track_guest` int(1) NOT NULL,
  `site_offline` int(1) NOT NULL,
  `force_pr` int(1) NOT NULL,
  `glogin` int(1) NOT NULL DEFAULT '0',
  `fblogin` int(1) NOT NULL,
  `gid` varchar(255) NOT NULL,
  `gsecret` varchar(255) NOT NULL,
  `gredirect` varchar(255) NOT NULL,
  `ghome` varchar(255) NOT NULL,
  `fbid` varchar(255) NOT NULL,
  `fbsecret` varchar(255) NOT NULL,
  `fbcallback` varchar(255) NOT NULL,
  `graph_ver` varchar(255) NOT NULL,
  `finalredir` varchar(255) NOT NULL,
  `req_cap` int(1) NOT NULL,
  `req_num` int(1) NOT NULL,
  `min_pw` int(2) NOT NULL,
  `max_pw` int(3) NOT NULL,
  `min_un` int(2) NOT NULL,
  `max_un` int(3) NOT NULL,
  `messaging` int(1) NOT NULL,
  `snooping` int(1) NOT NULL,
  `echouser` int(11) NOT NULL,
  `wys` int(1) NOT NULL,
  `change_un` int(1) NOT NULL,
  `backup_dest` varchar(255) NOT NULL,
  `backup_source` varchar(255) NOT NULL,
  `backup_table` varchar(255) NOT NULL,
  `msg_notification` int(1) NOT NULL,
  `permission_restriction` int(1) NOT NULL,
  `auto_assign_un` int(1) NOT NULL,
  `page_permission_restriction` int(1) NOT NULL,
  `msg_blocked_users` int(1) NOT NULL,
  `msg_default_to` int(1) NOT NULL,
  `notifications` int(1) NOT NULL,
  `notif_daylimit` int(3) NOT NULL,
  `recap_public` varchar(100) NOT NULL,
  `recap_private` varchar(100) NOT NULL,
  `page_default_private` int(1) NOT NULL,
  `navigation_type` tinyint(1) NOT NULL,
  `copyright` varchar(255) NOT NULL,
  `custom_settings` int(1) NOT NULL,
  `system_announcement` varchar(255) NOT NULL,
  `twofa` int(1) DEFAULT '0',
  `force_notif` tinyint(1) DEFAULT NULL,
  `cron_ip` varchar(255) DEFAULT NULL,
  `registration` tinyint(1) DEFAULT NULL,
  `join_vericode_expiry` int(9) unsigned NOT NULL,
  `reset_vericode_expiry` int(9) unsigned NOT NULL,
  `admin_verify` tinyint(1) NOT NULL,
  `admin_verify_timeout` int(9) NOT NULL,
  `session_manager` tinyint(1) NOT NULL,
  `template` varchar(255) DEFAULT 'default',
  `saas` tinyint(1) DEFAULT NULL,
  `redirect_uri_after_login` text,
  `show_tos` tinyint(1) DEFAULT '1',
  `default_language` varchar(11) DEFAULT NULL,
  `allow_language` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table ediagadir_user_mgn.settings: ~1 rows (approximately)
DELETE FROM `settings`;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` (`id`, `recaptcha`, `force_ssl`, `css_sample`, `us_css1`, `us_css2`, `us_css3`, `site_name`, `language`, `track_guest`, `site_offline`, `force_pr`, `glogin`, `fblogin`, `gid`, `gsecret`, `gredirect`, `ghome`, `fbid`, `fbsecret`, `fbcallback`, `graph_ver`, `finalredir`, `req_cap`, `req_num`, `min_pw`, `max_pw`, `min_un`, `max_un`, `messaging`, `snooping`, `echouser`, `wys`, `change_un`, `backup_dest`, `backup_source`, `backup_table`, `msg_notification`, `permission_restriction`, `auto_assign_un`, `page_permission_restriction`, `msg_blocked_users`, `msg_default_to`, `notifications`, `notif_daylimit`, `recap_public`, `recap_private`, `page_default_private`, `navigation_type`, `copyright`, `custom_settings`, `system_announcement`, `twofa`, `force_notif`, `cron_ip`, `registration`, `join_vericode_expiry`, `reset_vericode_expiry`, `admin_verify`, `admin_verify_timeout`, `session_manager`, `template`, `saas`, `redirect_uri_after_login`, `show_tos`, `default_language`, `allow_language`) VALUES
	(1, 0, 0, 0, '../users/css/color_schemes/bootstrap.min.css', '../users/css/sb-admin.css', '../users/css/custom.css', 'EDI Agadir Systems', 'en', 1, 0, 1, 0, 0, '', '', '', '', '', '', '', '', '', 0, 0, 6, 30, 4, 30, 1, 1, 0, 1, 0, '/', 'everything', '', 0, 0, 0, 0, 0, 1, 1, 7, '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI', '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe', 1, 1, 'EDI Morocco', 1, '', 0, 1, 'off', 1, 24, 15, 1, 120, 0, 'default', NULL, NULL, 0, 'en-US', 0);
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.updates
CREATE TABLE IF NOT EXISTS `updates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `migration` varchar(15) NOT NULL,
  `applied_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_skipped` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

-- Dumping data for table ediagadir_user_mgn.updates: ~31 rows (approximately)
DELETE FROM `updates`;
/*!40000 ALTER TABLE `updates` DISABLE KEYS */;
INSERT INTO `updates` (`id`, `migration`, `applied_on`, `update_skipped`) VALUES
	(15, '1XdrInkjV86F', '2018-02-18 23:33:24', NULL),
	(16, '3GJYaKcqUtw7', '2018-04-25 17:51:08', NULL),
	(17, '3GJYaKcqUtz8', '2018-04-25 17:51:08', NULL),
	(18, '69qa8h6E1bzG', '2018-04-25 17:51:08', NULL),
	(19, '2XQjsKYJAfn1', '2018-04-25 17:51:08', NULL),
	(20, '549DLFeHMNw7', '2018-04-25 17:51:08', NULL),
	(21, '4Dgt2XVjgz2x', '2018-04-25 17:51:08', NULL),
	(22, 'VLBp32gTWvEo', '2018-04-25 17:51:08', NULL),
	(23, 'Q3KlhjdtxE5X', '2018-04-25 17:51:08', NULL),
	(24, 'ug5D3pVrNvfS', '2018-04-25 17:51:08', NULL),
	(25, '69FbVbv4Jtrz', '2018-04-25 17:51:09', NULL),
	(26, '4A6BdJHyvP4a', '2018-04-25 17:51:09', NULL),
	(27, '37wvsb5BzymK', '2018-04-25 17:51:09', NULL),
	(28, 'c7tZQf926zKq', '2018-04-25 17:51:09', NULL),
	(29, 'ockrg4eU33GP', '2018-04-25 17:51:09', NULL),
	(30, 'XX4zArPs4tor', '2018-04-25 17:51:09', NULL),
	(31, 'pv7r2EHbVvhD', '2018-04-26 01:00:00', NULL),
	(32, 'uNT7NpgcBDFD', '2018-04-26 01:00:00', NULL),
	(33, 'mS5VtQCZjyJs', '2018-12-11 15:19:16', NULL),
	(34, '23rqAv5elJ3G', '2018-12-11 15:19:51', NULL),
	(35, 'hcA5B3PLhq6E', '2019-04-17 14:45:56', NULL),
	(36, 'FyMYJ2oeGCTX', '2019-04-17 14:45:56', NULL),
	(37, 'iit5tHSLatiS', '2019-04-17 14:45:56', NULL),
	(38, 'VNEno3E4zaNz', '2019-04-17 14:45:57', NULL),
	(39, 'qPEARSh49fob', '2019-04-17 14:45:57', NULL),
	(40, '2ZB9mg1l0JXe', '2019-04-17 14:45:57', NULL),
	(41, 'B9t6He7qmFXa', '2019-04-17 14:45:57', NULL),
	(42, '86FkFVV4TGRg', '2019-04-17 14:45:57', NULL),
	(43, 'y4A1Y0u9n2Rt', '2019-04-17 14:45:57', NULL),
	(44, 'Tm5xY22MM8eC', '2019-04-17 14:45:58', NULL),
	(45, '0YXdrInkjV86F', '2019-04-17 14:45:58', NULL);
/*!40000 ALTER TABLE `updates` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(155) NOT NULL,
  `email_new` varchar(155) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `pin` varchar(255) DEFAULT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `permissions` int(11) NOT NULL,
  `logins` int(11) unsigned NOT NULL,
  `account_owner` tinyint(4) NOT NULL DEFAULT '0',
  `account_id` int(11) NOT NULL DEFAULT '0',
  `company` varchar(255) NOT NULL,
  `join_date` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `email_verified` tinyint(4) NOT NULL DEFAULT '0',
  `vericode` varchar(15) NOT NULL,
  `active` int(1) NOT NULL,
  `oauth_provider` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `oauth_uid` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `gpluslink` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `fb_uid` varchar(255) NOT NULL,
  `un_changed` int(1) NOT NULL,
  `msg_exempt` int(1) NOT NULL DEFAULT '0',
  `last_confirm` datetime DEFAULT NULL,
  `protected` int(1) NOT NULL DEFAULT '0',
  `dev_user` int(1) NOT NULL DEFAULT '0',
  `msg_notification` int(1) NOT NULL DEFAULT '1',
  `force_pr` int(1) NOT NULL DEFAULT '0',
  `twoKey` varchar(16) DEFAULT NULL,
  `twoEnabled` int(1) DEFAULT '0',
  `twoDate` datetime DEFAULT NULL,
  `cloak_allowed` tinyint(1) NOT NULL DEFAULT '0',
  `org` int(11) DEFAULT NULL,
  `account_mgr` int(11) DEFAULT '0',
  `oauth_tos_accepted` tinyint(1) DEFAULT NULL,
  `vericode_expiry` datetime DEFAULT NULL,
  `language` varchar(255) DEFAULT 'en-US',
  PRIMARY KEY (`id`),
  KEY `EMAIL` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- Dumping data for table ediagadir_user_mgn.users: ~4 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `email`, `email_new`, `username`, `password`, `pin`, `fname`, `lname`, `permissions`, `logins`, `account_owner`, `account_id`, `company`, `join_date`, `last_login`, `email_verified`, `vericode`, `active`, `oauth_provider`, `oauth_uid`, `gender`, `locale`, `gpluslink`, `picture`, `created`, `modified`, `fb_uid`, `un_changed`, `msg_exempt`, `last_confirm`, `protected`, `dev_user`, `msg_notification`, `force_pr`, `twoKey`, `twoEnabled`, `twoDate`, `cloak_allowed`, `org`, `account_mgr`, `oauth_tos_accepted`, `vericode_expiry`, `language`) VALUES
	(1, 'userspicephp@gmail.com', NULL, 'admin', '$2y$12$1v06jm2KMOXuuo3qP7erTuTIJFOnzhpds1Moa8BadnUUeX0RV3ex.', NULL, 'The', 'Admin', 1, 11, 1, 0, 'UserSpice', '2016-01-01 00:00:00', '2019-04-19 21:21:18', 1, 'nlPsJDtyeqFWsS', 0, '', '', '', '', '', '', '0000-00-00 00:00:00', '1899-11-30 00:00:00', '', 0, 1, '2017-10-08 15:24:37', 1, 0, 1, 0, NULL, 0, NULL, 0, NULL, 0, 1, NULL, 'en-US'),
	(2, 'noreply@userspice.com', NULL, 'user', '$2y$12$uLS6lMVLhNTA.Hqgb3f5TuBfVbJ3/ivwBGtdnAAROj28dOMoC9j12', NULL, 'Sample', 'User', 1, 3, 1, 0, 'none', '2016-01-02 00:00:00', '2019-04-18 15:07:38', 1, '2jIQKBVphCDEKef', 1, '', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 0, NULL, 0, 0, 1, 0, NULL, 0, NULL, 0, NULL, 0, 1, '2019-04-18 14:05:28', 'en-US'),
	(12, 'qsdqsd@gmail.com', NULL, 'user4', '$2y$12$CZvr6AZlLXho9PHT0kJsH.IMdLH40giMAcR3mT5wvnwA7NT99age.', NULL, 'Qsdqsd', 'Qsdqsdqsd', 1, 0, 1, 0, '', '2019-04-18 16:32:56', '0000-00-00 00:00:00', 1, 'sJZl18Pt0pxxfe', 1, '', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 0, NULL, 0, 0, 1, 0, NULL, 0, NULL, 0, NULL, 0, 1, '2019-04-18 16:32:56', 'en-US'),
	(19, 'khalifa.rmili@gmail.com', NULL, 'jamal_benhimouda', '$2y$12$OwonLw3JmDmrMBr/5tYZw.xd/Q9oTkQQHW46YXII.YTQJVVxwsrFu', NULL, 'Jamal', 'Benhimouda', 1, 3, 1, 0, '', '2019-04-19 19:34:25', '2019-04-19 21:15:34', 1, 'thNgaHX7lFe1MO4', 1, '', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 0, NULL, 0, 0, 1, 0, NULL, 0, NULL, 0, NULL, 0, 1, '2019-04-19 19:38:26', 'en-US');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.users_online
CREATE TABLE IF NOT EXISTS `users_online` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) NOT NULL,
  `timestamp` varchar(15) NOT NULL,
  `user_id` int(10) NOT NULL,
  `session` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Dumping data for table ediagadir_user_mgn.users_online: ~4 rows (approximately)
DELETE FROM `users_online`;
/*!40000 ALTER TABLE `users_online` DISABLE KEYS */;
INSERT INTO `users_online` (`id`, `ip`, `timestamp`, `user_id`, `session`) VALUES
	(1, '::1', '1555705285', 1, ''),
	(3, '::1', '1555600811', 2, ''),
	(4, '::1', '1555678598', 13, ''),
	(5, '::1', '1555688851', 14, ''),
	(6, '::1', '1555695002', 15, ''),
	(7, '::1', '1555704956', 19, '');
/*!40000 ALTER TABLE `users_online` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.users_session
CREATE TABLE IF NOT EXISTS `users_session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `uagent` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table ediagadir_user_mgn.users_session: ~0 rows (approximately)
DELETE FROM `users_session`;
/*!40000 ALTER TABLE `users_session` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_session` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.user_permission_matches
CREATE TABLE IF NOT EXISTS `user_permission_matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8;

-- Dumping data for table ediagadir_user_mgn.user_permission_matches: ~5 rows (approximately)
DELETE FROM `user_permission_matches`;
/*!40000 ALTER TABLE `user_permission_matches` DISABLE KEYS */;
INSERT INTO `user_permission_matches` (`id`, `user_id`, `permission_id`) VALUES
	(100, 1, 1),
	(101, 1, 2),
	(102, 2, 1),
	(112, 12, 1),
	(119, 19, 1);
/*!40000 ALTER TABLE `user_permission_matches` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.us_announcements
CREATE TABLE IF NOT EXISTS `us_announcements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dismissed` int(11) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `ignore` varchar(50) DEFAULT NULL,
  `class` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table ediagadir_user_mgn.us_announcements: ~2 rows (approximately)
DELETE FROM `us_announcements`;
/*!40000 ALTER TABLE `us_announcements` DISABLE KEYS */;
INSERT INTO `us_announcements` (`id`, `dismissed`, `link`, `title`, `message`, `ignore`, `class`) VALUES
	(1, 3, 'https://www.userspice.com/updates', 'New Version', 'December 11, 2018 - Thank you for trying UserSpice Beta!', '4.5.0', 'warning'),
	(2, 14, '#', 'New Version!', 'April 12, 2019 - UserSpice 4.4.09 Released. Speed and bug fixes.', '4.4.09', 'success');
/*!40000 ALTER TABLE `us_announcements` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.us_fingerprints
CREATE TABLE IF NOT EXISTS `us_fingerprints` (
  `kFingerprintID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fkUserID` int(11) NOT NULL,
  `Fingerprint` varchar(32) NOT NULL,
  `Fingerprint_Expiry` datetime NOT NULL,
  `Fingerprint_Added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`kFingerprintID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table ediagadir_user_mgn.us_fingerprints: ~0 rows (approximately)
DELETE FROM `us_fingerprints`;
/*!40000 ALTER TABLE `us_fingerprints` DISABLE KEYS */;
/*!40000 ALTER TABLE `us_fingerprints` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.us_fingerprint_assets
CREATE TABLE IF NOT EXISTS `us_fingerprint_assets` (
  `kFingerprintAssetID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fkFingerprintID` int(11) NOT NULL,
  `IP_Address` varchar(255) NOT NULL,
  `User_Browser` varchar(255) NOT NULL,
  `User_OS` varchar(255) NOT NULL,
  PRIMARY KEY (`kFingerprintAssetID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table ediagadir_user_mgn.us_fingerprint_assets: ~0 rows (approximately)
DELETE FROM `us_fingerprint_assets`;
/*!40000 ALTER TABLE `us_fingerprint_assets` DISABLE KEYS */;
/*!40000 ALTER TABLE `us_fingerprint_assets` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.us_forms
CREATE TABLE IF NOT EXISTS `us_forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table ediagadir_user_mgn.us_forms: ~0 rows (approximately)
DELETE FROM `us_forms`;
/*!40000 ALTER TABLE `us_forms` DISABLE KEYS */;
/*!40000 ALTER TABLE `us_forms` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.us_form_validation
CREATE TABLE IF NOT EXISTS `us_form_validation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `params` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Dumping data for table ediagadir_user_mgn.us_form_validation: ~13 rows (approximately)
DELETE FROM `us_form_validation`;
/*!40000 ALTER TABLE `us_form_validation` DISABLE KEYS */;
INSERT INTO `us_form_validation` (`id`, `value`, `description`, `params`) VALUES
	(1, 'min', 'Minimum # of Characters', 'number'),
	(2, 'max', 'Maximum # of Characters', 'number'),
	(3, 'is_numeric', 'Must be a number', 'true'),
	(4, 'valid_email', 'Must be a valid email address', 'true'),
	(5, '<', 'Must be a number less than', 'number'),
	(6, '>', 'Must be a number greater than', 'number'),
	(7, '<=', 'Must be a number less than or equal to', 'number'),
	(8, '>=', 'Must be a number greater than or equal to', 'number'),
	(9, '!=', 'Must not be equal to', 'text'),
	(10, '==', 'Must be equal to', 'text'),
	(11, 'is_integer', 'Must be an integer', 'true'),
	(12, 'is_timezone', 'Must be a valid timezone name', 'true'),
	(13, 'is_datetime', 'Must be a valid DateTime', 'true');
/*!40000 ALTER TABLE `us_form_validation` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.us_form_views
CREATE TABLE IF NOT EXISTS `us_form_views` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_name` varchar(255) NOT NULL,
  `view_name` varchar(255) NOT NULL,
  `fields` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table ediagadir_user_mgn.us_form_views: ~0 rows (approximately)
DELETE FROM `us_form_views`;
/*!40000 ALTER TABLE `us_form_views` DISABLE KEYS */;
/*!40000 ALTER TABLE `us_form_views` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.us_ip_blacklist
CREATE TABLE IF NOT EXISTS `us_ip_blacklist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) NOT NULL,
  `last_user` int(11) NOT NULL DEFAULT '0',
  `reason` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Dumping data for table ediagadir_user_mgn.us_ip_blacklist: ~3 rows (approximately)
DELETE FROM `us_ip_blacklist`;
/*!40000 ALTER TABLE `us_ip_blacklist` DISABLE KEYS */;
INSERT INTO `us_ip_blacklist` (`id`, `ip`, `last_user`, `reason`) VALUES
	(3, '192.168.0.21', 1, 0),
	(4, '192.168.0.22', 1, 0),
	(10, '192.168.0.222', 0, 0);
/*!40000 ALTER TABLE `us_ip_blacklist` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.us_ip_list
CREATE TABLE IF NOT EXISTS `us_ip_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table ediagadir_user_mgn.us_ip_list: ~1 rows (approximately)
DELETE FROM `us_ip_list`;
/*!40000 ALTER TABLE `us_ip_list` DISABLE KEYS */;
INSERT INTO `us_ip_list` (`id`, `ip`, `user_id`, `timestamp`) VALUES
	(1, '::1', 1, '2019-04-19 21:21:18');
/*!40000 ALTER TABLE `us_ip_list` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.us_ip_whitelist
CREATE TABLE IF NOT EXISTS `us_ip_whitelist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table ediagadir_user_mgn.us_ip_whitelist: ~2 rows (approximately)
DELETE FROM `us_ip_whitelist`;
/*!40000 ALTER TABLE `us_ip_whitelist` DISABLE KEYS */;
INSERT INTO `us_ip_whitelist` (`id`, `ip`) VALUES
	(2, '192.168.0.21'),
	(3, '192.168.0.23');
/*!40000 ALTER TABLE `us_ip_whitelist` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.us_plugins
CREATE TABLE IF NOT EXISTS `us_plugins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plugin` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `updates` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table ediagadir_user_mgn.us_plugins: ~0 rows (approximately)
DELETE FROM `us_plugins`;
/*!40000 ALTER TABLE `us_plugins` DISABLE KEYS */;
/*!40000 ALTER TABLE `us_plugins` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.us_saas_levels
CREATE TABLE IF NOT EXISTS `us_saas_levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` varchar(255) NOT NULL,
  `users` int(11) NOT NULL,
  `details` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table ediagadir_user_mgn.us_saas_levels: ~0 rows (approximately)
DELETE FROM `us_saas_levels`;
/*!40000 ALTER TABLE `us_saas_levels` DISABLE KEYS */;
/*!40000 ALTER TABLE `us_saas_levels` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.us_saas_orgs
CREATE TABLE IF NOT EXISTS `us_saas_orgs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org` varchar(255) NOT NULL,
  `owner` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table ediagadir_user_mgn.us_saas_orgs: ~0 rows (approximately)
DELETE FROM `us_saas_orgs`;
/*!40000 ALTER TABLE `us_saas_orgs` DISABLE KEYS */;
/*!40000 ALTER TABLE `us_saas_orgs` ENABLE KEYS */;

-- Dumping structure for table ediagadir_user_mgn.us_user_sessions
CREATE TABLE IF NOT EXISTS `us_user_sessions` (
  `kUserSessionID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fkUserID` int(11) unsigned NOT NULL,
  `UserFingerprint` varchar(255) NOT NULL,
  `UserSessionIP` varchar(255) NOT NULL,
  `UserSessionOS` varchar(255) NOT NULL,
  `UserSessionBrowser` varchar(255) NOT NULL,
  `UserSessionStarted` datetime NOT NULL,
  `UserSessionLastUsed` datetime DEFAULT NULL,
  `UserSessionLastPage` varchar(255) NOT NULL,
  `UserSessionEnded` tinyint(1) NOT NULL DEFAULT '0',
  `UserSessionEnded_Time` datetime DEFAULT NULL,
  PRIMARY KEY (`kUserSessionID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table ediagadir_user_mgn.us_user_sessions: ~0 rows (approximately)
DELETE FROM `us_user_sessions`;
/*!40000 ALTER TABLE `us_user_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `us_user_sessions` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
