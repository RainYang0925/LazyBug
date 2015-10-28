-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015-10-13 04:25:57
-- 服务器版本： 5.6.25
-- PHP Version: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lazybug_api`
--

-- --------------------------------------------------------

--
-- 表的结构 `lb_api_case`
--

CREATE TABLE IF NOT EXISTS `lb_api_case` (
  `id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `module_id` int(10) NOT NULL DEFAULT '0',
  `name` varchar(30) NOT NULL,
  `level` tinyint(1) NOT NULL DEFAULT '3',
  `type` varchar(10) NOT NULL DEFAULT 'GET',
  `param` text,
  `header` text,
  `expectation` text,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `lb_api_config`
--

CREATE TABLE IF NOT EXISTS `lb_api_config` (
  `id` int(10) NOT NULL,
  `package_id` int(10) NOT NULL,
  `type` varchar(10) NOT NULL,
  `keyword` varchar(30) NOT NULL,
  `value` text,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `lb_api_history`
--

CREATE TABLE IF NOT EXISTS `lb_api_history` (
  `id` int(10) NOT NULL,
  `task_id` int(10) NOT NULL,
  `symbol` varchar(20) NOT NULL,
  `runtime` datetime NOT NULL,
  `pass` int(10) NOT NULL DEFAULT '0',
  `fail` int(10) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `lb_api_item`
--

CREATE TABLE IF NOT EXISTS `lb_api_item` (
  `id` int(10) NOT NULL,
  `module_id` int(10) NOT NULL DEFAULT '0',
  `name` varchar(30) NOT NULL,
  `url` text,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `lb_api_job`
--

CREATE TABLE IF NOT EXISTS `lb_api_job` (
  `task_id` int(10) NOT NULL,
  `total` int(10) NOT NULL DEFAULT '0',
  `current` int(10) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `lb_api_module`
--

CREATE TABLE IF NOT EXISTS `lb_api_module` (
  `id` int(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `lb_api_package`
--

CREATE TABLE IF NOT EXISTS `lb_api_package` (
  `id` int(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `lb_api_result`
--

CREATE TABLE IF NOT EXISTS `lb_api_result` (
  `id` int(10) NOT NULL,
  `history_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL DEFAULT '0',
  `case_id` int(10) NOT NULL DEFAULT '0',
  `step_id` tinyint(1) NOT NULL DEFAULT '0',
  `step_type` varchar(30) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `content` text,
  `pass` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `lb_api_step`
--

CREATE TABLE IF NOT EXISTS `lb_api_step` (
  `case_id` int(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'GET',
  `command` varchar(30) NOT NULL DEFAULT 'default',
  `value` text,
  `sequence` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `lb_api_task`
--

CREATE TABLE IF NOT EXISTS `lb_api_task` (
  `id` int(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `package_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL,
  `level` tinyint(1) NOT NULL,
  `runtime` text NOT NULL,
  `hang` tinyint(1) NOT NULL DEFAULT '0',
  `lasttime` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `lb_api_user`
--

CREATE TABLE IF NOT EXISTS `lb_api_user` (
  `id` int(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `passwd` varchar(32) NOT NULL,
  `role` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `lb_api_user`
--

INSERT INTO `lb_api_user` (`id`, `name`, `passwd`, `role`, `status`) VALUES
(1, 'admin', 'f6fdffe48c908deb0f4c3bd36c032e72', 'admin', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lb_api_case`
--
ALTER TABLE `lb_api_case`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lb_api_config`
--
ALTER TABLE `lb_api_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lb_api_history`
--
ALTER TABLE `lb_api_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lb_api_item`
--
ALTER TABLE `lb_api_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lb_api_module`
--
ALTER TABLE `lb_api_module`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lb_api_package`
--
ALTER TABLE `lb_api_package`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lb_api_result`
--
ALTER TABLE `lb_api_result`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lb_api_task`
--
ALTER TABLE `lb_api_task`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lb_api_user`
--
ALTER TABLE `lb_api_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lb_api_case`
--
ALTER TABLE `lb_api_case`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_api_config`
--
ALTER TABLE `lb_api_config`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_api_history`
--
ALTER TABLE `lb_api_history`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_api_item`
--
ALTER TABLE `lb_api_item`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_api_module`
--
ALTER TABLE `lb_api_module`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_api_package`
--
ALTER TABLE `lb_api_package`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_api_result`
--
ALTER TABLE `lb_api_result`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_api_task`
--
ALTER TABLE `lb_api_task`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_api_user`
--
ALTER TABLE `lb_api_user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
