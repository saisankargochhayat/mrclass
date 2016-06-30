-- phpMyAdmin SQL Dump
-- version 3.4.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 08, 2015 at 09:48 PM
-- Server version: 5.1.60
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mrclass`
--

-- --------------------------------------------------------

--
-- Table structure for table `businesses`
--

CREATE TABLE IF NOT EXISTS `businesses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) NOT NULL,
  `min_age_group` tinyint(3) NOT NULL,
  `max_age_group` tinyint(3) NOT NULL,
  `facilities` mediumtext NOT NULL,
  `about_us` mediumtext NOT NULL,
  `logo` varchar(255) NOT NULL,
  `city_id` int(11) NOT NULL,
  `locality_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `landmark` varchar(255) NOT NULL,
  `pincode` int(6) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `price` float(10,2) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `business_galleries`
--

CREATE TABLE IF NOT EXISTS `business_galleries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL,
  `media` varchar(255) NOT NULL,
  `sequence` tinyint(3) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `business_ratings`
--

CREATE TABLE IF NOT EXISTS `business_ratings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `name` varchar(155) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `category_image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `name`, `status`, `category_image`, `description`, `created`) VALUES
(1, 0, 'Art & Craft', 1, '', '', '0000-00-00 00:00:00'),
(2, 1, 'Drawing', 1, '', '', '0000-00-00 00:00:00'),
(3, 1, 'Clay Art', 1, '', '', '0000-00-00 00:00:00'),
(4, 0, 'Cooking', 1, '', '', '0000-00-00 00:00:00'),
(5, 4, 'North Indian', 1, '', '', '0000-00-00 00:00:00'),
(6, 4, 'South Indian', 1, '', '', '0000-00-00 00:00:00'),
(7, 4, 'Baking', 1, '', '', '0000-00-00 00:00:00'),
(8, 4, 'Desert', 1, '', '', '0000-00-00 00:00:00'),
(9, 4, 'Snacks', 1, '', '', '0000-00-00 00:00:00'),
(10, 0, 'Dance', 1, '', '', '0000-00-00 00:00:00'),
(11, 0, 'Beauty & Fashion', 1, '', '', '0000-00-00 00:00:00'),
(12, 0, 'Education', 1, '', '', '0000-00-00 00:00:00'),
(13, 0, 'Film & Acting', 1, '', '', '0000-00-00 00:00:00'),
(14, 0, 'Fitness & Health', 1, '', '', '0000-00-00 00:00:00'),
(15, 0, 'Language', 1, '', '', '0000-00-00 00:00:00'),
(16, 0, 'Music', 1, '', '', '0000-00-00 00:00:00'),
(17, 0, 'Photography', 1, '', '', '0000-00-00 00:00:00'),
(18, 12, 'Academic', 1, '', '', '0000-00-00 00:00:00'),
(19, 12, 'Vocational', 1, '', '', '0000-00-00 00:00:00'),
(20, 3, 'Hip-Hop', 1, '', '', '0000-00-00 00:00:00'),
(21, 4, 'Chienese', 1, 'cooking_classes.jpg', '', '2015-09-08 15:10:47');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(155) NOT NULL,
  `status` tinyint(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `status`) VALUES
(1, 'Bhubaneswar', 1),
(2, 'Cuttack', 1),
(3, 'Berhampur', 0),
(4, 'Sonepur', 0),
(5, 'Rourkela', 0),
(6, 'Koraput', 1),
(8, 'Sambalpur', 1);

-- --------------------------------------------------------

--
-- Table structure for table `localities`
--

CREATE TABLE IF NOT EXISTS `localities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `localities`
--

INSERT INTO `localities` (`id`, `city_id`, `name`, `status`) VALUES
(1, 1, 'Saheed Nagar', 1),
(2, 1, 'Acharya Vihar', 1),
(3, 2, 'CDA Sectoe-1', 1),
(13, 6, 'Jeypore', 1),
(5, 2, 'Link Roads', 1),
(6, 3, 'Annapurna Market', 1),
(7, 3, 'Gandhi Nagar', 1),
(8, 3, 'Bada Bazaar', 1),
(9, 3, 'Gate Bazaar', 1),
(10, 4, 'Ainthapalli', 1),
(11, 1, 'VSS Nagar', 1),
(12, 2, 'Ranihat', 1),
(14, 1, 'Kharvel Nagar - Unit 3', 1),
(15, 5, 'Matikhalo', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `verification_code` varchar(10) NOT NULL,
  `type` tinyint(2) NOT NULL COMMENT '1 - Admin , 2 - User',
  `city` varchar(50) NOT NULL,
  `pincode` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `phone`, `verification_code`, `type`, `city`, `pincode`, `photo`, `created`, `last_login`, `status`) VALUES
(1, 'chinmaya panigrahi', 'test123', 'chinmaya.p2014@gmail.com', 'a79bc759c7a4a2678ca1f5f4340a250e', '+919778817818', '', 1, 'Berhampur', 760010, '', '2015-09-03 14:43:48', '2015-09-07 03:52:13', 1),
(2, 'Suhani Padhi', 'test1234', 'a.ndola.smruti@gmail.com', 'f45cff8a322cebc4cf671ef457009148', '9692222311', '', 0, 'Berhampur', 0, '', '2015-09-04 13:11:02', '2015-09-04 01:11:42', 1),
(3, 'Suhani Pftry', '', 'admin@ofs.com', 'f45cff8a322cebc4cf671ef457009148', '9861878747', '', 0, 'Berhampur', 0, '', '2015-09-07 16:20:41', '0000-00-00 00:00:00', 1),
(4, 'Astha Padhi', '', 'test.chinmaya.as@gmwail.com', 'be406a7f98552827ca7c99bec4b0834b', '9692222311', '', 0, 'Sambalpur', 0, '', '2015-09-08 10:01:25', '0000-00-00 00:00:00', 1),
(5, 'Sam', '', 's@we.com', 'ab82b3cd212d48569441d479f476059e', '1111111111', '', 0, 'BBSR', 0, '', '2015-09-08 13:06:06', '0000-00-00 00:00:00', 1),
(6, 'Sam', '', 's@we.com', 'ab82b3cd212d48569441d479f476059e', '1111111111', '', 0, 'BBSR', 0, '', '2015-09-08 13:06:52', '0000-00-00 00:00:00', 1),
(7, 'Sam', '', 's@we.com', 'ab82b3cd212d48569441d479f476059e', '1111111111', '', 0, 'BBSR', 0, '', '2015-09-08 13:07:40', '0000-00-00 00:00:00', 1),
(8, 'Sam', '', 's@we.com', 'ab82b3cd212d48569441d479f476059e', '1111111111', '', 0, 'BBSR', 0, '', '2015-09-08 13:09:16', '0000-00-00 00:00:00', 1),
(9, 'Sam', '', 's@we.com', 'ab82b3cd212d48569441d479f476059e', '1111111111', '', 0, 'BBSR', 0, '', '2015-09-08 13:10:06', '0000-00-00 00:00:00', 1),
(10, 'Suhani Pftry', '', 'admin@ofs.com', 'be406a7f98552827ca7c99bec4b0834b', '9861878747', '', 0, 'Berhampur', 0, '', '2015-09-08 13:10:34', '0000-00-00 00:00:00', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
