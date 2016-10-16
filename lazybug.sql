-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2016 年 10 月 16 日 15:16
-- 服务器版本: 5.5.27
-- PHP 版本: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `lazybug`
--

-- --------------------------------------------------------

--
-- 表的结构 `lazybug_case`
--

CREATE TABLE IF NOT EXISTS `lazybug_case` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `item_id` int(10) NOT NULL,
  `module_id` int(10) NOT NULL DEFAULT '0',
  `space_id` int(10) NOT NULL DEFAULT '0',
  `name` varchar(30) NOT NULL,
  `level` tinyint(1) NOT NULL DEFAULT '3',
  `stype` varchar(10) NOT NULL DEFAULT 'GET',
  `ctype` varchar(35) NOT NULL DEFAULT 'application/x-www-form-urlencoded',
  `param` text,
  `header` text,
  `expectation` text,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `lazybug_config`
--

CREATE TABLE IF NOT EXISTS `lazybug_config` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `package_id` int(10) NOT NULL,
  `type` varchar(10) NOT NULL,
  `keyword` varchar(30) NOT NULL,
  `value` text,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `lazybug_field`
--

CREATE TABLE IF NOT EXISTS `lazybug_field` (
  `item_id` int(10) NOT NULL,
  `param_name` text NOT NULL,
  `param_value` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `lazybug_history`
--

CREATE TABLE IF NOT EXISTS `lazybug_history` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `task_id` int(10) NOT NULL,
  `guid` varchar(20) NOT NULL,
  `runtime` datetime NOT NULL,
  `pass` int(10) NOT NULL DEFAULT '0',
  `fail` int(10) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `lazybug_item`
--

CREATE TABLE IF NOT EXISTS `lazybug_item` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `module_id` int(10) NOT NULL DEFAULT '0',
  `space_id` int(10) NOT NULL DEFAULT '0',
  `name` varchar(30) NOT NULL,
  `url` text,
  `comment` text,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `lazybug_job`
--

CREATE TABLE IF NOT EXISTS `lazybug_job` (
  `task_id` int(10) NOT NULL,
  `total` int(10) NOT NULL DEFAULT '0',
  `current` int(10) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `lazybug_module`
--

CREATE TABLE IF NOT EXISTS `lazybug_module` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `space_id` int(10) NOT NULL DEFAULT '0',
  `name` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `lazybug_package`
--

CREATE TABLE IF NOT EXISTS `lazybug_package` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `lazybug_result`
--

CREATE TABLE IF NOT EXISTS `lazybug_result` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `history_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL DEFAULT '0',
  `case_id` int(10) NOT NULL DEFAULT '0',
  `step_id` tinyint(1) NOT NULL DEFAULT '0',
  `step_type` varchar(30) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `content` text,
  `value_1` text,
  `value_2` text,
  `value_3` text,
  `value_4` text,
  `value_5` text,
  `pass` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `lazybug_space`
--

CREATE TABLE IF NOT EXISTS `lazybug_space` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `lazybug_step`
--

CREATE TABLE IF NOT EXISTS `lazybug_step` (
  `case_id` int(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'GET',
  `command` varchar(30) NOT NULL DEFAULT 'default',
  `fliter` varchar(100) DEFAULT NULL,
  `value` text,
  `sequence` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `lazybug_system`
--

CREATE TABLE IF NOT EXISTS `lazybug_system` (
  `smtp_server` varchar(100) DEFAULT NULL,
  `smtp_port` int(10) DEFAULT NULL,
  `smtp_user` varchar(50) DEFAULT NULL,
  `smtp_password` varchar(50) DEFAULT NULL,
  `smtp_ssl` tinyint(1) DEFAULT '0',
  `smtp_default_port` tinyint(1) DEFAULT '1',
  `mail_list` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `lazybug_system`
--

INSERT INTO `lazybug_system` (`smtp_server`, `smtp_port`, `smtp_user`, `smtp_password`, `smtp_ssl`, `smtp_default_port`, `mail_list`) VALUES
('', NULL, '', '', 0, 1, '');

-- --------------------------------------------------------

--
-- 表的结构 `lazybug_task`
--

CREATE TABLE IF NOT EXISTS `lazybug_task` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `package_id` int(10) NOT NULL DEFAULT '0',
  `space_id` int(10) NOT NULL,
  `level` tinyint(1) NOT NULL,
  `runtime` text NOT NULL,
  `hang` tinyint(1) NOT NULL DEFAULT '0',
  `lasttime` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `lazybug_temp`
--

CREATE TABLE IF NOT EXISTS `lazybug_temp` (
  `key` varchar(20) NOT NULL,
  `case_id` int(10) DEFAULT '0',
  `name` varchar(20) NOT NULL,
  `value` text,
  `timestamp` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `lazybug_user`
--

CREATE TABLE IF NOT EXISTS `lazybug_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `passwd` varchar(32) NOT NULL,
  `role` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `lazybug_user`
--

INSERT INTO `lazybug_user` (`id`, `name`, `passwd`, `role`, `status`) VALUES
(1, 'admin', 'f6fdffe48c908deb0f4c3bd36c032e72', 'admin', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
