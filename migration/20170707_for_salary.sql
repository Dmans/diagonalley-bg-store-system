-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- 主機: localhost
-- 產生時間： 2017 年 07 月 08 日 10:41
-- 伺服器版本: 10.1.21-MariaDB
-- PHP 版本： 7.0.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `diagonalley`
--

-- --------------------------------------------------------

--
-- 資料表結構 `dia_salary`
--

CREATE TABLE `dia_salary` (
  `say_num` int(12) NOT NULL COMMENT '薪資流水號',
  `say_month` varchar(12) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '薪資月份',
  `usr_num` int(12) NOT NULL COMMENT '使用者流水號',
  `say_extra_hours` int(8) NOT NULL DEFAULT '0' COMMENT '加班工時',
  `say_extra_salary` int(8) NOT NULL DEFAULT '0' COMMENT '加班薪資',
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改時間'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='薪資資料表';

-- --------------------------------------------------------

--
-- 資料表結構 `dia_salary_options`
--

CREATE TABLE `dia_salary_options` (
  `dso_num` int(12) NOT NULL COMMENT '薪資項目流水號',
  `say_num` int(12) NOT NULL COMMENT '薪資流水號',
  `dso_type` int(4) NOT NULL COMMENT '項目類型(0:加給 1:獎金 2:預支 3:扣薪)',
  `dso_desc` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '項目說明',
  `dso_value` int(8) NOT NULL COMMENT '項目金額'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='薪資項目資料表';

-- --------------------------------------------------------

--
-- 資料表結構 `dia_salary_stores`
--

CREATE TABLE `dia_salary_stores` (
  `dss_num` int(12) NOT NULL COMMENT '薪資店舖流水號',
  `say_num` int(12) NOT NULL COMMENT '薪資流水號',
  `sto_num` int(8) NOT NULL COMMENT '店舖流水號',
  `dss_hours` int(8) NOT NULL DEFAULT '0' COMMENT '店舖工時',
  `dss_salary` int(8) NOT NULL DEFAULT '0' COMMENT '店舖薪資'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='薪資店舖資料表';

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `dia_salary`
--
ALTER TABLE `dia_salary`
  ADD PRIMARY KEY (`say_num`);

--
-- 資料表索引 `dia_salary_options`
--
ALTER TABLE `dia_salary_options`
  ADD PRIMARY KEY (`dso_num`);

--
-- 資料表索引 `dia_salary_stores`
--
ALTER TABLE `dia_salary_stores`
  ADD PRIMARY KEY (`dss_num`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `dia_salary`
--
ALTER TABLE `dia_salary`
  MODIFY `say_num` int(12) NOT NULL AUTO_INCREMENT COMMENT '薪資流水號', AUTO_INCREMENT=12;
--
-- 使用資料表 AUTO_INCREMENT `dia_salary_options`
--
ALTER TABLE `dia_salary_options`
  MODIFY `dso_num` int(12) NOT NULL AUTO_INCREMENT COMMENT '薪資項目流水號', AUTO_INCREMENT=3;
--
-- 使用資料表 AUTO_INCREMENT `dia_salary_stores`
--
ALTER TABLE `dia_salary_stores`
  MODIFY `dss_num` int(12) NOT NULL AUTO_INCREMENT COMMENT '薪資店舖流水號', AUTO_INCREMENT=27;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
