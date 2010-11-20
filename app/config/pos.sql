-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 20, 2010 at 04:26 PM
-- Server version: 5.1.44
-- PHP Version: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(2) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `item_count` int(5) NOT NULL DEFAULT '0',
  `employee_id` int(5) unsigned zerofill NOT NULL DEFAULT '00000',
  `deleted` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` VALUES(01, 'Hardware ', 4, 00001, 0, '2010-11-16 00:50:44', '2010-11-16 00:50:44');
INSERT INTO `categories` VALUES(02, 'Software', 2, 00001, 0, '2010-11-16 04:45:06', '2010-11-16 04:45:06');
INSERT INTO `categories` VALUES(03, 'Cables', 1, 00001, 0, '2010-11-16 04:45:17', '2010-11-16 04:45:17');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `mobile` bigint(12) unsigned zerofill DEFAULT NULL,
  `phone` bigint(12) unsigned zerofill DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL,
  `employee_id` int(5) unsigned zerofill NOT NULL DEFAULT '00000',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` VALUES(00000, 'Guest', NULL, NULL, NULL, 0, 00000, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `customers` VALUES(00004, 'Mohamed', NULL, NULL, '', 0, 00001, '2010-11-15 02:47:44', '2010-11-15 02:47:44');
INSERT INTO `customers` VALUES(00005, 'Abdullah', NULL, NULL, '', 0, 00001, '2010-11-15 02:49:03', '2010-11-15 02:49:03');
INSERT INTO `customers` VALUES(00006, 'Fahad', NULL, NULL, '', 0, 00001, '2010-11-15 02:49:19', '2010-11-15 02:49:19');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rank` smallint(1) NOT NULL DEFAULT '0',
  `profit_percent` decimal(4,2) NOT NULL DEFAULT '1.00',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` VALUES(00001, 'Owner', '111', '18187b5ada40451cf8e40a7437d88214e744b94e', 9, -99.99, 0, '0000-00-00 00:00:00', '2010-11-09 12:01:23');
INSERT INTO `employees` VALUES(00002, 'Manager', '222', '18187b5ada40451cf8e40a7437d88214e744b94e', 8, 0.20, 0, '2010-11-09 11:38:28', '2010-11-09 12:06:14');
INSERT INTO `employees` VALUES(00004, 'Cashier', '333', '18187b5ada40451cf8e40a7437d88214e744b94e', 5, 0.50, 0, '2010-11-09 11:53:58', '2010-11-09 12:01:38');
INSERT INTO `employees` VALUES(00008, 'Technician', '444', '18187b5ada40451cf8e40a7437d88214e744b94e', 1, 1.00, 0, '2010-11-09 11:56:08', '2010-11-09 12:00:54');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `barcode` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `cost_price` decimal(11,2) NOT NULL,
  `sell_price` decimal(11,2) NOT NULL,
  `stock` int(5) NOT NULL DEFAULT '0',
  `reorder_level` int(5) NOT NULL DEFAULT '0',
  `category_id` int(2) unsigned zerofill DEFAULT NULL,
  `supplier_id` int(5) unsigned zerofill DEFAULT '00000',
  `serialized` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `employee_id` int(5) unsigned zerofill NOT NULL DEFAULT '00000',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `barcode` (`barcode`),
  UNIQUE KEY `name` (`name`),
  KEY `category_id` (`category_id`),
  KEY `supplier_id` (`supplier_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` VALUES(00001, '1332432', 'Hard Disk 500GB', '', 200.00, 600.00, 635, 5, 01, 00001, 1, 0, 00001, '2010-11-15 02:41:30', '2010-11-20 06:44:08');
INSERT INTO `items` VALUES(00002, '108765484', 'Laptop Mouse', 'Small laptop mouse', 0.00, 25.00, 507, 4, 02, 00002, 0, 0, 00001, '2010-11-15 02:42:20', '2010-11-20 06:37:56');
INSERT INTO `items` VALUES(00003, '36574896', '10m Network Cable', '10m Network Cable', 5.00, 10.00, -2, 3, 03, 00003, 0, 0, 00001, '2010-11-15 02:43:15', '2010-11-20 06:37:56');
INSERT INTO `items` VALUES(00004, '87657', 'Dell XPS', 'Very good laptop', 0.00, 3200.00, 2, 2, 01, 00004, 1, 0, 00001, '2010-11-15 02:43:47', '2010-11-16 06:17:38');
INSERT INTO `items` VALUES(00005, '6754', 'Kasper Antivirus 2010', '', 60.00, 140.00, 1, 4, 02, 00005, 1, 0, 00001, '2010-11-15 02:44:28', '2010-11-16 06:44:42');
INSERT INTO `items` VALUES(00006, '97654', 'Flash Drive', '', 5.00, 25.00, 153, 10, 01, 00002, 0, 0, 00001, '2010-11-16 00:50:44', '2010-11-20 07:12:16');
INSERT INTO `items` VALUES(00014, '86754', 'Pen', '1', 50.00, 90.00, 2, 10, 01, 00002, 0, 0, 00001, '2010-11-16 00:57:05', '2010-11-16 06:44:49');

-- --------------------------------------------------------

--
-- Table structure for table `item_tracks`
--

CREATE TABLE `item_tracks` (
  `id` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `item_id` int(5) unsigned zerofill NOT NULL DEFAULT '00000',
  `employee_id` int(5) unsigned zerofill NOT NULL DEFAULT '00000',
  `stock` int(5) NOT NULL DEFAULT '0',
  `change` int(5) NOT NULL DEFAULT '0',
  `reason` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `item_tracks`
--

INSERT INTO `item_tracks` VALUES(00001, 00001, 00001, 635, 0, 'Sale #00018 (S/N: 132)', '2010-11-20 06:44:08');
INSERT INTO `item_tracks` VALUES(00002, 00006, 00001, 152, 0, 'Sale #00007', '2010-11-20 07:08:27');
INSERT INTO `item_tracks` VALUES(00003, 00006, 00001, 152, 0, 'Sale #00007', '2010-11-20 07:10:24');
INSERT INTO `item_tracks` VALUES(00004, 00006, 00001, 153, 1, 'Refund of Sale #00007', '2010-11-20 07:12:16');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `sender_id` int(5) unsigned zerofill NOT NULL DEFAULT '00000',
  `receiver_id` int(5) unsigned zerofill NOT NULL DEFAULT '00000',
  `subject` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `reply_to` int(5) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` VALUES(00001, 00002, 00000, 'Q', 'Does this work now?', NULL, 0, '2010-11-18 05:47:44', '2010-11-18 05:47:44');
INSERT INTO `messages` VALUES(00002, 00001, 00002, 'Q1', 'Does this work?', NULL, 0, '2010-11-18 05:48:50', '2010-11-18 05:48:50');
INSERT INTO `messages` VALUES(00003, 00002, 00001, 'A1', 'I think so!', NULL, 1, '2010-11-18 05:49:11', '2010-11-20 01:42:43');
INSERT INTO `messages` VALUES(00004, 00001, 00002, 'Q2', 'What about this?', NULL, 0, '2010-11-18 05:49:44', '2010-11-18 05:49:44');
INSERT INTO `messages` VALUES(00005, 00002, 00001, 'A2', 'Works too!<br />\n<br />\nWe need to find a solution for deleting...', NULL, 1, '2010-11-18 05:50:31', '2010-11-18 05:53:11');
INSERT INTO `messages` VALUES(00006, 00001, 00002, 'Q3', 'Did this fix the problem!?', 5, 0, '2010-11-18 05:52:19', '2010-11-18 05:52:19');
INSERT INTO `messages` VALUES(00007, 00001, 00008, 'Test', 'Message text!<br />\n<br />\nYou are fired!!!', 0, 1, '2010-11-18 19:43:10', '2010-11-20 01:42:45');
INSERT INTO `messages` VALUES(00008, 00008, 00001, 'Why!?', 'Why !?', 7, 0, '2010-11-18 19:43:36', '2010-11-18 19:43:36');
INSERT INTO `messages` VALUES(00009, 00008, 00001, 'jkh', 'hjk<br />\n', 7, 1, '2010-11-18 23:25:20', '2010-11-20 01:42:51');
INSERT INTO `messages` VALUES(00010, 00001, 00004, '768', '47', 0, 0, '2010-11-19 23:19:16', '2010-11-19 23:19:16');
INSERT INTO `messages` VALUES(00011, 00001, 00004, '12', '31', 0, 0, '2010-11-19 23:19:53', '2010-11-19 23:19:53');
INSERT INTO `messages` VALUES(00012, 00004, 00001, '2', '21', 11, 0, '2010-11-19 23:21:33', '2010-11-19 23:21:33');
INSERT INTO `messages` VALUES(00013, 00008, 00001, '1', '12', 0, 0, '2010-11-19 23:22:51', '2010-11-19 23:22:51');
INSERT INTO `messages` VALUES(00014, 00001, 00008, '123', 'momomno', 0, 0, '2010-11-19 23:28:40', '2010-11-19 23:28:40');

-- --------------------------------------------------------

--
-- Table structure for table `ordered_items`
--

CREATE TABLE `ordered_items` (
  `id` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `order_id` int(5) unsigned zerofill NOT NULL DEFAULT '00000',
  `item_id` int(5) unsigned zerofill NOT NULL DEFAULT '00000',
  `quantity` int(11) NOT NULL,
  `cost_price` decimal(11,2) NOT NULL DEFAULT '0.00',
  `net_price` decimal(11,2) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `receiving_id` (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ordered_items`
--

INSERT INTO `ordered_items` VALUES(00001, 00001, 00001, 1, 200.00, 200.00, 0);
INSERT INTO `ordered_items` VALUES(00002, 00001, 00002, 1, 0.00, 0.00, 0);
INSERT INTO `ordered_items` VALUES(00003, 00001, 00003, 1, 5.00, 5.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `supplier_id` int(5) unsigned zerofill NOT NULL DEFAULT '00000',
  `total` decimal(11,2) NOT NULL DEFAULT '0.00',
  `invoice_no` varchar(30) NOT NULL,
  `discount` decimal(11,2) NOT NULL DEFAULT '0.00',
  `payment` decimal(11,2) NOT NULL DEFAULT '0.00',
  `balance` decimal(11,2) NOT NULL DEFAULT '0.00',
  `text` text NOT NULL,
  `employee_id` int(5) unsigned zerofill NOT NULL DEFAULT '00000',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` VALUES(00001, 00003, 205.00, '243', 205.00, 0.00, 0.00, '', 00001, 0, '2010-11-19 22:10:59', '2010-11-19 22:10:59');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `employee_id` int(5) unsigned zerofill NOT NULL DEFAULT '00000',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `packages`
--


-- --------------------------------------------------------

--
-- Table structure for table `package_items`
--

CREATE TABLE `package_items` (
  `id` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `package_id` int(11) unsigned zerofill NOT NULL,
  `item_id` int(5) unsigned zerofill NOT NULL DEFAULT '00000',
  `quantity` int(5) NOT NULL DEFAULT '1',
  `employee_id` int(5) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `package_id` (`package_id`,`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `package_items`
--


-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` decimal(11,2) NOT NULL DEFAULT '0.00',
  `min_price` decimal(11,2) NOT NULL DEFAULT '0.00',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` VALUES(00001, 'Format (Winsows XP)', 50.00, 30.00, 0, '2010-11-15 02:46:57', '2010-11-15 02:46:57');
INSERT INTO `requests` VALUES(00002, 'Format (Windows 7)', 70.00, 40.00, 0, '2010-11-15 02:47:10', '2010-11-15 02:47:10');
INSERT INTO `requests` VALUES(00003, 'Replace hard disk', 80.00, 140.00, 0, '2010-11-15 02:47:30', '2010-11-19 01:36:28');
INSERT INTO `requests` VALUES(00004, '11', 11.00, 11.00, 0, '2010-11-19 01:36:40', '2010-11-19 01:36:40');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `customer_id` int(5) unsigned zerofill NOT NULL DEFAULT '00000',
  `total` decimal(11,2) NOT NULL DEFAULT '0.00',
  `payment` decimal(11,2) NOT NULL DEFAULT '0.00',
  `balance` decimal(11,2) NOT NULL DEFAULT '0.00',
  `text` text NOT NULL,
  `employee_id` int(5) unsigned zerofill NOT NULL DEFAULT '00000',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` VALUES(00001, 00000, 140.00, 140.00, 0.00, '', 00002, 0, '2010-11-18 05:45:49', '2010-11-18 05:45:49');
INSERT INTO `sales` VALUES(00007, 00000, 0.00, 30.00, -30.00, '', 00001, 0, '2010-11-19 21:06:33', '2010-11-19 21:06:33');
INSERT INTO `sales` VALUES(00008, 00005, 0.00, 40.00, -42.00, '', 00001, 0, '2010-11-19 23:30:35', '2010-11-19 23:30:35');
INSERT INTO `sales` VALUES(00009, 00000, 140.00, 140.00, 0.00, '', 00001, 0, '2010-11-20 01:58:15', '2010-11-20 01:58:15');
INSERT INTO `sales` VALUES(00010, 00000, 600.00, 700.00, -100.00, '', 00001, 0, '2010-11-20 01:59:01', '2010-11-20 01:59:01');
INSERT INTO `sales` VALUES(00011, 00000, 1200.00, 3000.00, -1800.00, '', 00001, 0, '2010-11-20 02:04:39', '2010-11-20 02:04:39');
INSERT INTO `sales` VALUES(00012, 00000, -20.00, 0.00, -20.00, '', 00001, 0, '2010-11-20 02:06:41', '2010-11-20 02:06:41');
INSERT INTO `sales` VALUES(00013, 00000, 600.00, 900.00, -300.00, '', 00001, 0, '2010-11-20 02:08:42', '2010-11-20 02:08:42');
INSERT INTO `sales` VALUES(00014, 00000, 600.00, 900.00, -300.00, '', 00001, 0, '2010-11-20 02:09:20', '2010-11-20 02:09:20');
INSERT INTO `sales` VALUES(00015, 00000, 1200.00, 1200.00, 0.00, '', 00001, 0, '2010-11-20 02:15:35', '2010-11-20 02:15:35');
INSERT INTO `sales` VALUES(00016, 00000, 1200.00, 1200.00, 0.00, '', 00001, 0, '2010-11-20 02:16:28', '2010-11-20 02:16:28');
INSERT INTO `sales` VALUES(00017, 00000, 1200.00, 1220.00, -20.00, '', 00001, 0, '2010-11-20 02:18:29', '2010-11-20 02:18:29');
INSERT INTO `sales` VALUES(00018, 00000, 0.00, 1230.00, -1860.00, '', 00001, 0, '2010-11-20 02:43:55', '2010-11-20 02:43:55');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL DEFAULT '',
  `data` text,
  `expires` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` VALUES('1cc8f7fe252fe1d8fd88acc96b99ed44', 'Config|a:3:{s:9:"userAgent";s:32:"4672f5da14df60c12b07c2529bf38641";s:4:"time";i:1290270712;s:7:"timeout";i:10;}Settings|a:4:{i:0;a:1:{s:7:"Setting";a:4:{s:2:"id";s:5:"00001";s:4:"name";s:4:"name";s:5:"value";s:7:"FixTech";s:7:"deleted";s:1:"0";}}i:1;a:1:{s:7:"Setting";a:4:{s:2:"id";s:5:"00002";s:4:"name";s:7:"address";s:5:"value";s:42:"Al-Izdihar Area<br />Othman bin Affan Road";s:7:"deleted";s:1:"0";}}i:2;a:1:{s:7:"Setting";a:4:{s:2:"id";s:5:"00003";s:4:"name";s:5:"phone";s:5:"value";s:11:"96614299999";s:7:"deleted";s:1:"0";}}i:3;a:1:{s:7:"Setting";a:4:{s:2:"id";s:5:"00004";s:4:"name";s:12:"sell_message";s:5:"value";s:15:"Visit us again!";s:7:"deleted";s:1:"0";}}}Employee|a:1:{s:2:"id";s:5:"00001";}Message|a:0:{}Auth|a:1:{s:8:"Employee";a:9:{s:2:"id";s:5:"00001";s:4:"name";s:5:"Owner";s:8:"username";s:3:"111";s:4:"rank";s:1:"9";s:14:"profit_percent";s:6:"-99.99";s:7:"deleted";s:1:"0";s:7:"created";s:19:"0000-00-00 00:00:00";s:8:"modified";s:19:"2010-11-09 12:01:23";s:6:"search";s:11:"Owner (111)";}}', 1290270712);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` VALUES(00001, 'name', 'FixTech', 0);
INSERT INTO `settings` VALUES(00002, 'address', 'Al-Izdihar Area<br />Othman bin Affan Road', 0);
INSERT INTO `settings` VALUES(00003, 'phone', '96614299999', 0);
INSERT INTO `settings` VALUES(00004, 'sell_message', 'Visit us again!', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sold_items`
--

CREATE TABLE `sold_items` (
  `id` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `sale_id` int(5) unsigned zerofill NOT NULL DEFAULT '00000',
  `item_id` int(5) unsigned zerofill NOT NULL DEFAULT '00000',
  `quantity` int(11) NOT NULL,
  `last_change` int(11) NOT NULL DEFAULT '0',
  `refunded` int(11) NOT NULL DEFAULT '0',
  `discount` decimal(11,2) NOT NULL DEFAULT '0.00',
  `net_price` decimal(11,2) NOT NULL,
  `serial` varchar(32) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `sale_id` (`sale_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `sold_items`
--

INSERT INTO `sold_items` VALUES(00001, 00001, 00005, 1, 0, 0, 0.00, 140.00, '', 0);
INSERT INTO `sold_items` VALUES(00002, 00007, 00006, 0, 1, 1, 0.00, 0.00, '', 0);
INSERT INTO `sold_items` VALUES(00003, 00008, 00003, 1, 0, 0, 0.00, 25.00, '', 0);
INSERT INTO `sold_items` VALUES(00004, 00008, 00002, 0, 0, 1, 0.00, 0.00, '', 0);
INSERT INTO `sold_items` VALUES(00005, 00009, 00005, 1, 0, 0, 0.00, 140.00, '', 0);
INSERT INTO `sold_items` VALUES(00006, 00010, 00001, 1, 0, 0, 0.00, 600.00, '', 0);
INSERT INTO `sold_items` VALUES(00007, 00011, 00001, 1, 0, 0, 0.00, 600.00, '123', 0);
INSERT INTO `sold_items` VALUES(00008, 00011, 00001, 1, 0, 0, 0.00, 600.00, '', 0);
INSERT INTO `sold_items` VALUES(00009, 00012, 00001, 1, 0, 0, 1220.00, -620.00, '123', 0);
INSERT INTO `sold_items` VALUES(00010, 00012, 00001, 1, 0, 0, 0.00, 600.00, '', 0);
INSERT INTO `sold_items` VALUES(00011, 00013, 00001, 1, 0, 0, 0.00, 600.00, '213', 0);
INSERT INTO `sold_items` VALUES(00012, 00014, 00001, 1, 0, 0, 0.00, 600.00, '', 0);
INSERT INTO `sold_items` VALUES(00013, 00015, 00001, 1, 0, 0, 0.00, 600.00, '123', 0);
INSERT INTO `sold_items` VALUES(00014, 00015, 00001, 1, 0, 0, 0.00, 600.00, '', 0);
INSERT INTO `sold_items` VALUES(00015, 00016, 00001, 1, 0, 0, 0.00, 600.00, '132', 0);
INSERT INTO `sold_items` VALUES(00016, 00016, 00001, 1, 0, 0, 0.00, 600.00, '', 0);
INSERT INTO `sold_items` VALUES(00017, 00017, 00001, 1, 0, 0, 0.00, 600.00, '', 0);
INSERT INTO `sold_items` VALUES(00018, 00017, 00001, 1, 0, 0, 0.00, 600.00, '123', 0);
INSERT INTO `sold_items` VALUES(00019, 00018, 00001, 0, 0, 1, 0.00, 0.00, '132', 0);
INSERT INTO `sold_items` VALUES(00020, 00018, 00001, 0, 0, 1, 0.00, 0.00, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` bigint(12) NOT NULL,
  `phone` bigint(12) NOT NULL,
  `address` text NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `item_count` int(5) NOT NULL DEFAULT '0',
  `employee_id` int(5) unsigned zerofill NOT NULL DEFAULT '00000',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `name_2` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` VALUES(00001, 'Western Digital', '', 0, 0, '', 0, 1, 00001, '2010-11-15 02:41:30', '2010-11-15 02:41:30');
INSERT INTO `suppliers` VALUES(00002, 'China', '', 0, 0, '', 0, 3, 00001, '2010-11-15 02:42:20', '2010-11-15 02:42:20');
INSERT INTO `suppliers` VALUES(00003, 'Cable Company', '', 0, 0, '', 0, 1, 00001, '2010-11-15 02:43:15', '2010-11-15 02:43:15');
INSERT INTO `suppliers` VALUES(00004, 'Dell', '', 0, 0, '', 0, 1, 00001, '2010-11-15 02:43:47', '2010-11-16 04:54:27');
INSERT INTO `suppliers` VALUES(00005, 'Kaspersky', '', 0, 0, '', 0, 1, 00001, '2010-11-15 02:44:28', '2010-11-15 02:44:28');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `customer_id` int(5) unsigned zerofill NOT NULL DEFAULT '00000',
  `employee_id` int(5) unsigned zerofill NOT NULL DEFAULT '00000',
  `technician_id` int(5) unsigned zerofill NOT NULL DEFAULT '00000',
  `finish` datetime NOT NULL,
  `devices` text NOT NULL,
  `additional_costs` decimal(11,2) NOT NULL DEFAULT '0.00',
  `total` decimal(11,2) NOT NULL DEFAULT '0.00',
  `text` text NOT NULL,
  `status` smallint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` VALUES(00006, 00005, 00001, 00008, '0000-00-00 00:00:00', 'Charger, Bag, Pen', 0.00, 70.00, '', 2, 0, '2010-11-18 22:45:28', '2010-11-19 08:41:07');
INSERT INTO `tickets` VALUES(00007, 00005, 00001, 00008, '0000-00-00 00:00:00', 'Charger, Bag, Pen', 0.00, 60.00, '', 2, 0, '2010-11-18 22:48:07', '2010-11-19 23:41:06');
INSERT INTO `tickets` VALUES(00008, 00005, 00001, 00008, '2010-11-15 21:00:00', '', 0.00, 80.00, '', 0, 0, '2010-11-18 22:51:41', '2010-11-19 00:22:15');
INSERT INTO `tickets` VALUES(00009, 00004, 00001, 00008, '2010-11-20 21:00:00', 'Charger, Bag, Pen', 100.00, 180.00, '', 2, 0, '2010-11-19 20:44:31', '2010-11-19 20:52:40');
INSERT INTO `tickets` VALUES(00010, 00006, 00001, 00008, '2010-11-20 17:00:00', '', 0.00, 150.00, '', 0, 0, '2010-11-19 22:07:19', '2010-11-19 22:07:19');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_requests`
--

CREATE TABLE `ticket_requests` (
  `id` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `ticket_id` int(5) unsigned zerofill NOT NULL,
  `request_id` int(5) unsigned zerofill NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `price` decimal(11,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `ticket_requests`
--

INSERT INTO `ticket_requests` VALUES(00001, 00022, 00002, 0, 0.00);
INSERT INTO `ticket_requests` VALUES(00002, 00023, 00002, 0, 70.00);
INSERT INTO `ticket_requests` VALUES(00003, 00024, 00001, 0, 0.00);
INSERT INTO `ticket_requests` VALUES(00004, 00025, 00001, 0, 0.00);
INSERT INTO `ticket_requests` VALUES(00005, 00026, 00002, 0, 0.00);
INSERT INTO `ticket_requests` VALUES(00006, 00027, 00001, 0, 0.00);
INSERT INTO `ticket_requests` VALUES(00007, 00028, 00001, 0, 10.00);
INSERT INTO `ticket_requests` VALUES(00008, 00028, 00003, 0, 10.00);
INSERT INTO `ticket_requests` VALUES(00009, 00001, 00002, 0, 10.00);
INSERT INTO `ticket_requests` VALUES(00010, 00001, 00003, 0, 80.00);
INSERT INTO `ticket_requests` VALUES(00011, 00002, 00001, 0, 50.00);
INSERT INTO `ticket_requests` VALUES(00012, 00002, 00002, 0, 70.00);
INSERT INTO `ticket_requests` VALUES(00013, 00002, 00003, 0, 80.00);
INSERT INTO `ticket_requests` VALUES(00014, 00003, 00001, 0, 31.00);
INSERT INTO `ticket_requests` VALUES(00015, 00004, 00001, 0, 50.00);
INSERT INTO `ticket_requests` VALUES(00016, 00005, 00002, 0, 70.00);
INSERT INTO `ticket_requests` VALUES(00017, 00006, 00002, 1, 70.00);
INSERT INTO `ticket_requests` VALUES(00018, 00007, 00001, 1, 50.00);
INSERT INTO `ticket_requests` VALUES(00019, 00008, 00003, 0, 80.00);
INSERT INTO `ticket_requests` VALUES(00020, 00009, 00002, 1, 80.00);
INSERT INTO `ticket_requests` VALUES(00021, 00010, 00001, 0, 150.00);

-- --------------------------------------------------------

--
-- Table structure for table `todos`
--

CREATE TABLE `todos` (
  `id` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `text` varchar(255) NOT NULL,
  `employee_id` int(5) unsigned zerofill NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `todos`
--

INSERT INTO `todos` VALUES(00001, 'addadas', 00001, 1, '2010-11-18 00:26:48', '2010-11-18 00:51:11');
INSERT INTO `todos` VALUES(00002, 'das', 00001, 1, '2010-11-18 00:26:48', '2010-11-18 00:26:58');
INSERT INTO `todos` VALUES(00003, 'ads', 00001, 1, '2010-11-18 00:26:50', '2010-11-18 00:26:55');
INSERT INTO `todos` VALUES(00004, 'Love myself!', 00001, 1, '2010-11-18 00:26:59', '2010-11-18 00:52:17');
INSERT INTO `todos` VALUES(00005, 'ad', 00001, 1, '2010-11-18 00:39:45', '2010-11-18 00:40:01');
INSERT INTO `todos` VALUES(00006, 'ad', 00001, 1, '2010-11-18 00:39:45', '2010-11-18 00:39:59');
INSERT INTO `todos` VALUES(00007, 'ad', 00001, 1, '2010-11-18 00:39:47', '2010-11-18 00:39:58');
INSERT INTO `todos` VALUES(00008, 'ad', 00001, 1, '2010-11-18 00:39:49', '2010-11-18 00:39:53');
INSERT INTO `todos` VALUES(00009, 'Love my self again!', 00001, 1, '2010-11-18 00:40:04', '2010-11-18 00:52:19');
INSERT INTO `todos` VALUES(00010, 'And again...', 00001, 1, '2010-11-18 00:40:09', '2010-11-18 00:52:20');
INSERT INTO `todos` VALUES(00011, 'da', 00001, 1, '2010-11-18 00:40:11', '2010-11-18 00:52:07');
INSERT INTO `todos` VALUES(00012, 'addas', 00001, 1, '2010-11-18 00:45:40', '2010-11-18 00:46:16');
INSERT INTO `todos` VALUES(00013, 'da', 00001, 1, '2010-11-18 00:45:58', '2010-11-18 00:46:19');
INSERT INTO `todos` VALUES(00014, 'asdsd', 00001, 1, '2010-11-18 00:46:05', '2010-11-18 00:46:17');
INSERT INTO `todos` VALUES(00015, 'adsda', 00001, 1, '2010-11-18 00:46:26', '2010-11-18 00:47:28');
INSERT INTO `todos` VALUES(00016, 'adasd', 00000, 0, '2010-11-18 00:47:22', '2010-11-18 00:47:22');
INSERT INTO `todos` VALUES(00017, 'dadas', 00000, 0, '2010-11-18 00:47:34', '2010-11-18 00:47:34');
INSERT INTO `todos` VALUES(00018, 'asdgagd', 00001, 1, '2010-11-18 00:50:48', '2010-11-18 00:52:08');
INSERT INTO `todos` VALUES(00019, 'Have fun!', 00001, 0, '2010-11-18 01:20:44', '2010-11-20 01:52:09');
INSERT INTO `todos` VALUES(00020, 'lkj', 00001, 1, '2010-11-18 01:21:30', '2010-11-18 02:21:01');
INSERT INTO `todos` VALUES(00021, 'Drink latte!', 00001, 1, '2010-11-18 04:46:57', '2010-11-20 01:52:04');
INSERT INTO `todos` VALUES(00022, 'dsafa', 00001, 1, '2010-11-18 04:47:48', '2010-11-18 04:47:53');
INSERT INTO `todos` VALUES(00023, 'afds', 00001, 1, '2010-11-18 04:47:49', '2010-11-18 04:47:51');
INSERT INTO `todos` VALUES(00024, 'fsa', 00002, 0, '2010-11-18 05:44:36', '2010-11-18 05:44:36');
INSERT INTO `todos` VALUES(00025, 'Drink latte and green tea!', 00001, 1, '2010-11-18 19:42:06', '2010-11-18 19:42:22');
INSERT INTO `todos` VALUES(00026, 'sdfg', 00001, 1, '2010-11-18 19:44:19', '2010-11-18 19:47:47');
INSERT INTO `todos` VALUES(00027, 'sgdf', 00001, 1, '2010-11-18 19:44:20', '2010-11-18 19:47:48');
INSERT INTO `todos` VALUES(00028, 'gsdf', 00001, 1, '2010-11-18 19:44:22', '2010-11-18 19:48:00');
INSERT INTO `todos` VALUES(00029, 'gsfd', 00001, 1, '2010-11-18 19:44:24', '2010-11-18 19:47:49');
INSERT INTO `todos` VALUES(00030, 'gfsd', 00001, 1, '2010-11-18 19:44:25', '2010-11-18 19:47:58');
INSERT INTO `todos` VALUES(00031, 'gsfd', 00001, 1, '2010-11-18 19:44:26', '2010-11-18 19:47:51');
INSERT INTO `todos` VALUES(00032, 'gsd', 00001, 1, '2010-11-18 19:44:28', '2010-11-18 19:47:54');
INSERT INTO `todos` VALUES(00033, 'sgdf', 00001, 1, '2010-11-18 19:44:29', '2010-11-18 19:47:56');
INSERT INTO `todos` VALUES(00034, 'gsdf', 00001, 0, '2010-11-18 19:44:30', '2010-11-18 19:44:30');
INSERT INTO `todos` VALUES(00035, 'asd', 00008, 0, '2010-11-18 23:20:34', '2010-11-18 23:20:34');
INSERT INTO `todos` VALUES(00036, 'afs', 00008, 1, '2010-11-18 23:21:00', '2010-11-18 23:24:34');
INSERT INTO `todos` VALUES(00037, 'fsa', 00008, 0, '2010-11-18 23:21:02', '2010-11-18 23:21:02');
INSERT INTO `todos` VALUES(00038, 'ads', 00008, 1, '2010-11-18 23:21:11', '2010-11-18 23:24:30');
INSERT INTO `todos` VALUES(00039, 'ads', 00008, 1, '2010-11-18 23:21:16', '2010-11-18 23:24:29');
INSERT INTO `todos` VALUES(00040, 'dsadsf', 00008, 0, '2010-11-18 23:24:35', '2010-11-18 23:24:38');
INSERT INTO `todos` VALUES(00041, 'afd', 00001, 1, '2010-11-19 09:48:05', '2010-11-19 09:49:58');
INSERT INTO `todos` VALUES(00042, 'fasd', 00001, 1, '2010-11-19 09:48:07', '2010-11-19 09:49:56');
INSERT INTO `todos` VALUES(00043, 'afsd', 00001, 1, '2010-11-19 09:48:09', '2010-11-19 09:49:54');
INSERT INTO `todos` VALUES(00044, 'af', 00001, 1, '2010-11-19 09:48:11', '2010-11-19 09:49:50');
INSERT INTO `todos` VALUES(00045, 'das', 00001, 1, '2010-11-19 09:49:44', '2010-11-19 09:49:53');
