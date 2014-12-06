-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 05, 2014 at 07:22 PM
-- Server version: 5.5.25a
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `demeter`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_fund_logs_tb`
--

CREATE TABLE IF NOT EXISTS `add_fund_logs_tb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `funds_id` int(11) NOT NULL,
  `demeter_charge_amount_amount` decimal(10,0) NOT NULL,
  `net_fund_amount` decimal(10,0) NOT NULL,
  `date_added` point NOT NULL,
  `paypal_callback_log` varchar(255) NOT NULL,
  `total_amount` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `attach_file_tb`
--

CREATE TABLE IF NOT EXISTS `attach_file_tb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `message_id` int(11) NOT NULL,
  `attachby_user_id` int(11) NOT NULL,
  `date_added` date NOT NULL,
  `notes` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `billing_tb`
--

CREATE TABLE IF NOT EXISTS `billing_tb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `paidby_user_id` int(11) NOT NULL,
  `paidto_user_id` int(11) NOT NULL,
  `timelogs` varchar(255) NOT NULL,
  `notes` varchar(255) NOT NULL,
  `date_added` date NOT NULL,
  `date_paid` date NOT NULL,
  `is_completed` tinyint(1) NOT NULL,
  `total_hours` int(3) NOT NULL,
  `rate_per_hour` decimal(10,0) NOT NULL,
  `total_amount` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `company_tb`
--

CREATE TABLE IF NOT EXISTS `company_tb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `url` varchar(255) NOT NULL,
  `owner` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telephone` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `logo` varchar(200) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `company_tb`
--

INSERT INTO `company_tb` (`id`, `name`, `url`, `owner`, `email`, `telephone`, `address`, `logo`, `date_added`) VALUES
(2, 'FlairCity', 'http://flaicity,com', '1', 'rex@centraleffects.com', '222-12345', 'Davao City', '', '0000-00-00 00:00:00'),
(5, 'Philippine Diamond Trading Ltd', 'http://diamon.ph', '1', 'rex@centraleffects.com', '222-12345', '', '', '2014-01-12 01:13:09'),
(6, 'Malagamot Foundation Inc.', 'http://flaicity.com', '1', 'rex@centraleffects.com', '', '', '', '2014-01-11 11:43:00');

-- --------------------------------------------------------

--
-- Table structure for table `company_user`
--

CREATE TABLE IF NOT EXISTS `company_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_joined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `position` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `email` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `company_user`
--

INSERT INTO `company_user` (`id`, `company_id`, `user_id`, `date_joined`, `position`, `is_active`, `email`) VALUES
(2, 2, 1, '2014-01-11 12:07:18', '', 0, ''),
(9, 2, 0, '2014-01-12 05:48:17', '', 0, 'centraleffects@gmail.com'),
(10, 5, 0, '2014-01-16 10:40:41', '', 0, 'centraleffects@hotmail.com'),
(11, 5, 0, '2014-01-16 10:40:54', '', 0, 'dexter@yahoo.com'),
(12, 5, 1, '2014-01-29 22:02:04', '', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `fund_tb`
--

CREATE TABLE IF NOT EXISTS `fund_tb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `outstanding_amount` decimal(10,0) NOT NULL,
  `lat_added_fund_logs_id` int(11) NOT NULL,
  `last_widthraw_logs_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jobs_skills_tags`
--

CREATE TABLE IF NOT EXISTS `jobs_skills_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) NOT NULL,
  `skills_tags_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jobs_tb`
--

CREATE TABLE IF NOT EXISTS `jobs_tb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postion_title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `postedby_user_id` int(11) NOT NULL,
  `date_added` date NOT NULL,
  `rate_min` decimal(10,0) NOT NULL,
  `rate_max` decimal(10,0) NOT NULL,
  `location` varchar(255) NOT NULL,
  `rate` decimal(10,0) NOT NULL,
  `is_hourly` tinyint(1) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `company_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `job_applicant_tb`
--

CREATE TABLE IF NOT EXISTS `job_applicant_tb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jobs_id` int(11) NOT NULL,
  `applicant_user_id` int(11) NOT NULL,
  `date_applied` date NOT NULL,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `messages_tb`
--

CREATE TABLE IF NOT EXISTS `messages_tb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `createdby_user_id` int(11) NOT NULL,
  `date_added` int(200) NOT NULL,
  `parent_message_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `messages_tb`
--

INSERT INTO `messages_tb` (`id`, `project_id`, `subject`, `content`, `createdby_user_id`, `date_added`, `parent_message_id`) VALUES
(1, 3, 'Your ability to view job details and submit propos', 'dfsdfdsfds\r\ndsf\r\ndsf\r\ndsf\r\ndsfdsfdsf', 1, 2014, 0),
(2, 3, 'Your ability to view job details and submit propos', 'dfsdfdsfds\r\ndsf\r\ndsf\r\ndsf\r\ndsfdsfdsf', 1, 2014, 0),
(3, 3, 'Your ability to view job details and submit propos', 'dfsdfdsfds\r\ndsf\r\ndsf\r\ndsf\r\ndsfdsfdsf', 1, 2014, 0),
(4, 3, 'Your ability to view job details and submit propos', 'dfsdfdsfds\r\ndsf\r\ndsf\r\ndsf\r\ndsfdsfdsf', 1, 2014, 0),
(5, 3, 'Your ability to view job details and submit propos', 'dfsdfdsfds\r\ndsf\r\ndsf\r\ndsf\r\ndsfdsfdsf', 1, 2014, 0),
(6, 3, 'Your ability to view job details and submit proposals has been suspended.', 'dsfdsfdsfdsfdsfdsf', 1, 2014, 0),
(8, 0, '', 'testste', 1, 2014, 3),
(9, 0, '', 'dfgdfgdfgdfg', 1, 2014, 3),
(10, 0, '', 'dfgdfgdfg', 1, 2014, 3),
(11, 0, '', 'fgdfgdf', 1, 2014, 3),
(12, 0, '', 'gfhgf', 1, 2014, 3),
(13, 3, 'Project kick off5467', 'gfhgfhgfh', 1, 1391043309, 0),
(14, 0, '', 'ghjghj', 1, 1391043318, 13),
(15, 0, '', 'fghgfh', 1, 1391043644, 13),
(16, 0, '', 'ghgfhgf', 1, 1391133604, 13),
(17, 0, '', 'hgfhgf', 1, 1391106094, 13);

-- --------------------------------------------------------

--
-- Table structure for table `message_dashboard_tb`
--

CREATE TABLE IF NOT EXISTS `message_dashboard_tb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `sender_user_id` int(11) NOT NULL,
  `send_to` int(11) NOT NULL,
  `is_trash` tinyint(1) NOT NULL,
  `is_read` tinyint(1) NOT NULL,
  `date_sent` int(200) NOT NULL,
  `is_archive` tinyint(1) NOT NULL,
  `date_read` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `message_dashboard_tb`
--

INSERT INTO `message_dashboard_tb` (`id`, `subject`, `content`, `sender_user_id`, `send_to`, `is_trash`, `is_read`, `date_sent`, `is_archive`, `date_read`) VALUES
(36, 'Subject', 'Greetings!', 1, 2, 0, 0, 1391571909, 0, '0000-00-00 00:00:00'),
(37, 'Sample', 'HelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHello', 1, 2, 0, 1, 1391660284, 0, '0000-00-00 00:00:00'),
(38, 'sample', 'aaaaaaaaaaaaaaHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHello', 2, 1, 0, 1, 1391660696, 0, '0000-00-00 00:00:00'),
(39, 'sample', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, 2, 0, 1, 1391661395, 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `message_user_tb`
--

CREATE TABLE IF NOT EXISTS `message_user_tb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message_id` int(11) NOT NULL,
  `added_user_id` int(11) NOT NULL,
  `date_added` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `message_user_tb`
--

INSERT INTO `message_user_tb` (`id`, `message_id`, `added_user_id`, `date_added`) VALUES
(1, 3, 1, '2014-01-29'),
(3, 5, 1, '2014-01-29'),
(4, 13, 1, '2014-01-30');

-- --------------------------------------------------------

--
-- Table structure for table `milestone_tb`
--

CREATE TABLE IF NOT EXISTS `milestone_tb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL,
  `addedby_user_id` int(11) NOT NULL,
  `assigned_to_userid` int(20) NOT NULL,
  `date_due` datetime NOT NULL,
  `date_completed` datetime NOT NULL,
  `is_completed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `milestone_tb`
--

INSERT INTO `milestone_tb` (`id`, `project_id`, `name`, `description`, `date_added`, `addedby_user_id`, `assigned_to_userid`, `date_due`, `date_completed`, `is_completed`) VALUES
(3, 3, 'Design and Concepts', 'Create flat UIX Designs', '2014-01-13 06:49:40', 1, 1, '2014-01-27 12:00:00', '2014-01-17 03:24:58', 1),
(4, 3, 'Database Planning and Engineering', 'Design database according to required functionality', '2014-01-13 04:15:37', 1, 1, '2014-01-22 12:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `project_tb`
--

CREATE TABLE IF NOT EXISTS `project_tb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `company_id` int(11) NOT NULL,
  `user_id` int(20) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `project_tb`
--

INSERT INTO `project_tb` (`id`, `name`, `description`, `date_added`, `company_id`, `user_id`, `is_active`) VALUES
(3, 'Company Website', 'This is a website that will serves information to media and press.', '2014-01-12 04:27:07', 5, 1, 1),
(4, 'Product Listing', 'Listing of products to Amazon', '2014-01-12 04:35:56', 5, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `project_user_tb`
--

CREATE TABLE IF NOT EXISTS `project_user_tb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_added` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `screenshoot_tb`
--

CREATE TABLE IF NOT EXISTS `screenshoot_tb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `screenshot_id` varchar(255) NOT NULL,
  `date_added` date NOT NULL,
  `date_taken` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `skills_tags_tb`
--

CREATE TABLE IF NOT EXISTS `skills_tags_tb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `date_added` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `task_assigned_tb`
--

CREATE TABLE IF NOT EXISTS `task_assigned_tb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `assigned_user_id` int(11) NOT NULL,
  `assignedby_userid` int(11) NOT NULL,
  `date_added` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `task_tb`
--

CREATE TABLE IF NOT EXISTS `task_tb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `milestone_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `addedby_userid` int(11) NOT NULL,
  `assignedto_userid` int(20) NOT NULL,
  `start_date` datetime NOT NULL,
  `date_due` datetime NOT NULL,
  `date_completed` datetime NOT NULL,
  `is_done` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `task_tb`
--

INSERT INTO `task_tb` (`id`, `milestone_id`, `name`, `description`, `addedby_userid`, `assignedto_userid`, `start_date`, `date_due`, `date_completed`, `is_done`) VALUES
(1, 3, 'Information Gatheringss', 'Wordpress has recently released the latest, most awesome version of Wordpress in it''s 3.8 - if you need help backing up your site before you upgrade please ask us and we''ll help!', 1, 0, '2014-01-24 12:00:00', '2014-01-27 12:00:00', '0000-00-00 00:00:00', 0),
(3, 4, 'Double check the theme before creating QA tasks for specific functionality/theme components', 'See project description notebook for  the attribution link in the footer should go, what it should say', 1, 1, '2014-01-31 12:00:00', '2014-02-03 12:00:00', '2014-01-22 02:02:09', 1);

-- --------------------------------------------------------

--
-- Table structure for table `timelogs_tb`
--

CREATE TABLE IF NOT EXISTS `timelogs_tb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `datetime_start` date NOT NULL,
  `datetime_end` date NOT NULL,
  `date_added` date NOT NULL,
  `is_billable` tinyint(1) NOT NULL,
  `is_billed` tinyint(1) NOT NULL,
  `screenshot_id` int(11) NOT NULL,
  `is_offline` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_meta_tb`
--

CREATE TABLE IF NOT EXISTS `user_meta_tb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meta_key` varchar(255) NOT NULL,
  `meta_value` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_added` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_password_tb`
--

CREATE TABLE IF NOT EXISTS `user_password_tb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_new` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user_password_tb`
--

INSERT INTO `user_password_tb` (`id`, `user_id`, `password`, `is_new`) VALUES
(1, 1, 'de8b560317cf145882ea02b9b24133e66b4023d367b91c97f19597c4069337d3 ', 1),
(2, 2, 'de8b560317cf145882ea02b9b24133e6e10adc3949ba59abbe56e057f20f883e', 1),
(4, 4, 'de8b560317cf145882ea02b9b24133e65e8ff9bf55ba3508199d22e984129be6', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_tb`
--

CREATE TABLE IF NOT EXISTS `user_tb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `paypal_email` varchar(50) NOT NULL,
  `image_filename` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `date_joined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `session_user_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user_tb`
--

INSERT INTO `user_tb` (`id`, `firstname`, `lastname`, `username`, `email`, `paypal_email`, `image_filename`, `type`, `date_joined`, `session_user_id`) VALUES
(1, 'Rex', 'Bengil', 'rex', 'centraleffects@yahoo.com', 'centraleffects@yahoo.com', '', '', '0000-00-00 00:00:00', ''),
(2, 'Marc lester', 'Comia', 'mac', 'mac@gmail.com', '', '8pk3q140201110149.jpg', '', '2014-01-31 03:40:05', ''),
(4, 'Marc', 'Sample', 'macdroid', 'lestercomia@gmail.com', '', '', '', '2014-02-04 15:30:45', '');

-- --------------------------------------------------------

--
-- Table structure for table `widthraw_log_tb`
--

CREATE TABLE IF NOT EXISTS `widthraw_log_tb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `funds_id` int(11) NOT NULL,
  `demeter_charge_amount` decimal(10,0) NOT NULL,
  `net_fund_amount` decimal(10,0) NOT NULL,
  `date_added` date NOT NULL,
  `paypal_callback_log` varchar(255) NOT NULL,
  `total_amount` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
