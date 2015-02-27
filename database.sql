-- Table structure for table `barber`
DROP TABLE IF EXISTS `barber`;
CREATE TABLE `barber` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `shopid` smallint(6) NOT NULL,
  `name` varchar(256) NOT NULL,
  `gender` varchar(1) NOT NULL,
  `description` text,
  `email` varchar(256) NOT NULL,
  `yearsofexperience` smallint(6) NOT NULL,
  `Photo` blob,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Table structure for table `shop`
DROP TABLE IF EXISTS `shop`;
CREATE TABLE `shop` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `description` text,
  `address` varchar(256) NOT NULL,
  `Email` varchar(256) NOT NULL,
  `Phone` varchar(256) NOT NULL,
  `Photo` blob,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Table structure for table `categories`
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` smallint(6),
  `name` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `position` smallint(6) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Table structure for table `pm`
DROP TABLE IF EXISTS `pm`;
CREATE TABLE `pm` (
  `id` bigint(20) NOT NULL,
  `id2` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `user1` bigint(20) NOT NULL,
  `user2` bigint(20) NOT NULL,
  `message` text NOT NULL,
  `timestamp` int(10) NOT NULL,
  `user1read` varchar(3) NOT NULL,
  `user2read` varchar(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Table structure for table `topics`
DROP TABLE IF EXISTS `topics`;
CREATE TABLE `topics` (
  `parent` smallint(6) NOT NULL,
  `id` int(11) NOT NULL,
  `id2` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `message` longtext NOT NULL,
  `authorid` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `timestamp2` int(11) NOT NULL,
  PRIMARY KEY  (`id`,`id2`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Table structure for table `users`
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `username` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `avatar` text NOT NULL,
  `signup_date` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
