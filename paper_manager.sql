-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: 2018-05-25 03:09:06
-- 服务器版本： 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `paper_manager`
--

-- --------------------------------------------------------

--
-- 表的结构 `think_achievement`
--

DROP TABLE IF EXISTS `think_achievement`;
CREATE TABLE IF NOT EXISTS `think_achievement` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_number` varchar(255) NOT NULL,
  `achievement_id` varchar(20) NOT NULL,
  `achievement_type` int(10) DEFAULT NULL,
  `project_id` int(10) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `institute_name` varchar(255) DEFAULT NULL,
  `publish_time` date DEFAULT NULL,
  `file_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `achievement_id` (`achievement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_achievement`
--

INSERT INTO `think_achievement` (`id`, `user_number`, `achievement_id`, `achievement_type`, `project_id`, `title`, `institute_name`, `publish_time`, `file_id`) VALUES
(1, '110', '1', 1, 2, '语音检测', '中国科学院', '2018-05-23', 43),
(2, '110', '2', 2, 2, '语音识别', '12', '2017-05-24', 44),
(5, '140410414', '2', 1, NULL, '图像检测算法', 'chinese image', '2017-05-02', 51);

-- --------------------------------------------------------

--
-- 表的结构 `think_achievement_type`
--

DROP TABLE IF EXISTS `think_achievement_type`;
CREATE TABLE IF NOT EXISTS `think_achievement_type` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_achievement_type`
--

INSERT INTO `think_achievement_type` (`id`, `type_name`) VALUES
(1, '期刊论文'),
(2, '会议论文'),
(3, '学术专著'),
(4, '专利'),
(5, '会议报告'),
(6, '标准'),
(7, '软件著作权'),
(8, '科研奖励'),
(9, '举办或参加学术会议');

-- --------------------------------------------------------

--
-- 表的结构 `think_area`
--

DROP TABLE IF EXISTS `think_area`;
CREATE TABLE IF NOT EXISTS `think_area` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_area`
--

INSERT INTO `think_area` (`id`, `user_id`, `keyword`) VALUES
(1, 1, '人工智能');

-- --------------------------------------------------------

--
-- 表的结构 `think_author`
--

DROP TABLE IF EXISTS `think_author`;
CREATE TABLE IF NOT EXISTS `think_author` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `achievement_id` varchar(20) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `author_workplace` varchar(255) DEFAULT NULL,
  `author_email` varchar(255) DEFAULT NULL,
  `is_contact` varchar(255) DEFAULT NULL,
  `is_first` varchar(255) DEFAULT NULL,
  `is_main` varchar(255) DEFAULT NULL,
  `is_company` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_author`
--

INSERT INTO `think_author` (`id`, `achievement_id`, `author_name`, `author_workplace`, `author_email`, `is_contact`, `is_first`, `is_main`, `is_company`) VALUES
(1, '1', 'xcg', '哈工大', 'xcg@qq.com', '', '是', '是', ''),
(2, '1', 'wxq', '哈工大', 'wxq@qq.com', '', '', '是', ''),
(3, '2', '徐小明', '哈工大', '', '', '是', '是', ''),
(4, '2', '徐小西', '哈工大', '', '', '', '是', '是'),
(5, '3', 'wxq', '哈工大', 'wxq@qq.com', '', '是', '是', ''),
(6, '3', 'root', '哈工大', 'root@qq.com', '', '', '', ''),
(7, '1', '王小强', '哈工大', 'wxq2@qq.com', '是', '', '是', ''),
(9, '5', '徐小光', '哈工大', 'xcg@qq.com', '', '是', '是', ''),
(14, '5', '王强', '哈工大', 'wq@qq.com', '是', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `think_conferenceinvolved`
--

DROP TABLE IF EXISTS `think_conferenceinvolved`;
CREATE TABLE IF NOT EXISTS `think_conferenceinvolved` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_number` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `title_zh` varchar(255) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `institute` varchar(255) DEFAULT NULL,
  `holder` varchar(255) DEFAULT NULL,
  `people_num` int(15) DEFAULT NULL,
  `content` varchar(1000) DEFAULT NULL,
  `paper_link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `think_conferencepaper`
--

DROP TABLE IF EXISTS `think_conferencepaper`;
CREATE TABLE IF NOT EXISTS `think_conferencepaper` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_number` varchar(255) NOT NULL,
  `title_zh` varchar(255) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `abstract` varchar(1000) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `language` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `conference_name` varchar(255) DEFAULT NULL,
  `conference_address` varchar(255) DEFAULT NULL,
  `organizer` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `publish_date` date DEFAULT NULL,
  `start_page` int(10) DEFAULT NULL,
  `end_page` int(10) DEFAULT NULL,
  `sub_type` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `doi` varchar(255) DEFAULT NULL,
  `paper_num` varchar(255) DEFAULT NULL,
  `inbox_status` varchar(255) DEFAULT NULL,
  `refer_num` int(10) DEFAULT NULL,
  `mark` varchar(255) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `paper_link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_conferencepaper`
--

INSERT INTO `think_conferencepaper` (`id`, `user_number`, `title_zh`, `title_en`, `abstract`, `keywords`, `language`, `type`, `conference_name`, `conference_address`, `organizer`, `start_date`, `end_date`, `publish_date`, `start_page`, `end_page`, `sub_type`, `country`, `city`, `doi`, `paper_num`, `inbox_status`, `refer_num`, `mark`, `content`, `paper_link`) VALUES
(2, '110', '语音识别', 'yuyinshibie', '语音识别', '语音识别', '中文', '邀请会议论文', '12', '1', '12', '2018-05-01', '2017-05-03', '2017-05-24', 0, 0, NULL, '', '', '123', '23', 'EI;', 0, '未标注', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `think_conferencereport`
--

DROP TABLE IF EXISTS `think_conferencereport`;
CREATE TABLE IF NOT EXISTS `think_conferencereport` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_number` varchar(255) NOT NULL,
  `report_type` varchar(255) DEFAULT NULL,
  `conference_type` varchar(255) DEFAULT NULL,
  `title_zh` varchar(255) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `abstract` varchar(1000) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `conference_zh` varchar(255) DEFAULT NULL,
  `conference_en` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `content` varchar(1000) DEFAULT NULL,
  `paper_link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `think_contributions`
--

DROP TABLE IF EXISTS `think_contributions`;
CREATE TABLE IF NOT EXISTS `think_contributions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_number` varchar(20) NOT NULL,
  `type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `file_id` int(10) DEFAULT NULL,
  `status` int(10) DEFAULT '0',
  `members` varchar(255) DEFAULT NULL,
  `approval_first` varchar(255) DEFAULT NULL,
  `approval_second` varchar(255) DEFAULT NULL,
  `time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_contributions`
--

INSERT INTO `think_contributions` (`id`, `user_number`, `type`, `name`, `content`, `file_id`, `status`, `members`, `approval_first`, `approval_second`, `time`) VALUES
(2, '140410414', '期刊论文', 'test', 'test', 35, 6, NULL, '110', '001', '2018-05-08 17:50:42'),
(3, '110', '会议论文', 'teacherPaper', 'teacherPaper', 39, 6, NULL, NULL, NULL, '2018-05-09 15:35:30'),
(4, '110', '学术专著', '语音处理', '语音处理', 40, 5, NULL, NULL, NULL, '2018-05-14 16:44:27');

-- --------------------------------------------------------

--
-- 表的结构 `think_deliver_record`
--

DROP TABLE IF EXISTS `think_deliver_record`;
CREATE TABLE IF NOT EXISTS `think_deliver_record` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_number` varchar(20) NOT NULL,
  `con_id` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `file_id` int(10) DEFAULT NULL,
  `time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_deliver_record`
--

INSERT INTO `think_deliver_record` (`id`, `user_number`, `con_id`, `description`, `file_id`, `time`) VALUES
(1, '140410414', '9', '1', 33, '2018-05-07 17:18:50'),
(2, '140410414', '9', '2', 0, '2018-05-07 17:18:56'),
(3, '140410414', '9', '3', NULL, '2018-05-07 17:21:22'),
(7, '140410414', '2', '121', 37, '2018-05-07 20:13:39'),
(8, '140410414', '2', '66的', 38, '2018-05-08 15:31:02'),
(9, '140410414', '2', '66的', 38, '2018-05-08 15:31:02'),
(10, '140410414', '2', '66的', 38, '2018-05-08 15:31:02'),
(11, '140410414', '2', '66的', 38, '2018-05-08 15:31:02'),
(12, '140410414', '2', '66的', 38, '2018-05-08 15:31:02'),
(13, '140410414', '2', '66的', 38, '2018-05-08 15:31:02'),
(14, '140410414', '2', '66的', 38, '2018-05-08 15:31:02'),
(15, '140410414', '2', '66的', 38, '2018-05-08 15:31:02'),
(16, '140410414', '2', '66的', 38, '2018-05-08 15:31:02'),
(17, '140410414', '2', '66的', 38, '2018-05-08 15:31:02'),
(18, '140410414', '2', '66的', 38, '2018-05-08 15:31:02'),
(19, '140410414', '2', '66的', 38, '2018-05-08 15:31:02'),
(20, '140410414', '2', '66的', 38, '2018-05-08 15:31:02'),
(21, '140410414', '2', '66的', 38, '2018-05-08 15:31:02'),
(22, '140410414', '2', '66的', 38, '2018-05-08 15:31:02'),
(23, '140410414', '2', '66的', 38, '2018-05-08 15:31:02'),
(24, '140410414', '2', '66的', 38, '2018-05-08 15:31:02'),
(25, '140410414', '2', '66的', 38, '2018-05-08 15:31:02'),
(26, '140410414', '2', '66的', 38, '2018-05-08 15:31:02'),
(27, '140410414', '2', '66的', 38, '2018-05-08 15:31:02'),
(28, '140410414', '2', '66的', 38, '2018-05-08 15:31:02'),
(29, '140410414', '2', '66的', 38, '2018-05-08 15:31:02'),
(30, '140410414', '2', '66的', 38, '2018-05-08 15:31:02'),
(31, '140410414', '2', '66的', 38, '2018-05-08 15:31:02'),
(32, '110', '3', '1', NULL, '2018-05-09 15:32:48'),
(33, '110', '3', '2', NULL, '2018-05-09 15:32:57'),
(35, '110', '3', '3', NULL, '2018-05-09 15:35:25'),
(36, '110', '4', '增加信息', 41, '2018-05-14 16:45:10');

-- --------------------------------------------------------

--
-- 表的结构 `think_excel`
--

DROP TABLE IF EXISTS `think_excel`;
CREATE TABLE IF NOT EXISTS `think_excel` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `upload_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_excel`
--

INSERT INTO `think_excel` (`id`, `name`, `upload_time`, `path`) VALUES
(13, 'AchiImportTpl.xlsx', '2017-05-29 15:43:11', '592bd10f654b7.xlsx'),
(14, 'AchiImportTpl.xlsx', '2017-05-29 19:16:13', '592c02fd425f5.xlsx'),
(15, 'AchiImportTpl.xlsx', '2017-06-01 19:05:27', '592ff4f7c4955.xlsx'),
(16, 'AchiImportTpl.xlsx', '2017-06-13 16:16:41', '593f9f69ecbf7.xlsx');

-- --------------------------------------------------------

--
-- 表的结构 `think_feedback`
--

DROP TABLE IF EXISTS `think_feedback`;
CREATE TABLE IF NOT EXISTS `think_feedback` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `teacher_number` varchar(20) NOT NULL,
  `affair_type` varchar(255) NOT NULL,
  `affair_id` varchar(255) NOT NULL,
  `feedback_content` varchar(1000) DEFAULT NULL,
  `level` int(10) NOT NULL,
  `time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_feedback`
--

INSERT INTO `think_feedback` (`id`, `teacher_number`, `affair_type`, `affair_id`, `feedback_content`, `level`, `time`) VALUES
(1, '110', 'Contributions', '9', 'good', 1, '2018-05-03 17:17:58'),
(2, '001', 'Contributions', '9', 'very good', 2, '2018-05-03 17:25:08'),
(3, '110', 'Contributions', '2', 'good', 1, '2018-05-07 19:47:30'),
(4, '001', 'Contributions', '2', 'very good', 2, '2018-05-07 19:48:17');

-- --------------------------------------------------------

--
-- 表的结构 `think_file`
--

DROP TABLE IF EXISTS `think_file`;
CREATE TABLE IF NOT EXISTS `think_file` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `achievement_id` varchar(20) DEFAULT NULL,
  `user_number` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `upload_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `type` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_file`
--

INSERT INTO `think_file` (`id`, `achievement_id`, `user_number`, `name`, `description`, `upload_time`, `type`, `path`) VALUES
(38, '2', '140410414', '毕设需求.txt', NULL, '2018-05-08 15:31:02', 'Contributions', 'Uploads/Contributions/5af15236cc487.txt'),
(37, '2', '140410414', '例子.docx', NULL, '2018-05-07 20:13:39', 'Contributions', 'Uploads/Contributions/5af042f37e76d.docx'),
(35, NULL, '140410414', '开题报告.doc', NULL, '2018-05-07 19:45:42', 'Contributions', 'Uploads/Contributions/5af03c66b0caf.doc'),
(33, '9', '140410414', '开题报告.doc', NULL, '2018-05-07 17:18:50', 'Contributions', 'Uploads/Contributions/5af019fa5633b.doc'),
(29, NULL, '140410414', '开题报告.doc', NULL, '2018-05-03 17:17:30', 'Contributions', 'Uploads/Contributions/5aead3aac6c94.doc'),
(32, '9', '140410414', '开题报告.doc', NULL, '2018-05-07 17:15:37', 'Contributions', 'Uploads/Contributions/5af0193977b35.doc'),
(31, '9', '140410414', '开题报告.doc', NULL, '2018-05-07 16:37:28', 'Contributions', 'Uploads/Contributions/5af0104823443.doc'),
(30, '9', '140410414', '开题报告.doc', NULL, '2018-05-07 16:20:53', 'Contributions', 'Uploads/Contributions/5af00c6506060.doc'),
(39, NULL, '110', '开题报告.doc', NULL, '2018-05-09 15:32:36', 'Contributions', 'Uploads/Contributions/5af2a41402ac1.doc'),
(40, NULL, '110', '例子.docx', NULL, '2018-05-14 16:44:27', 'Contributions', 'Uploads/Contributions/5af94c6bdb19d.docx'),
(48, NULL, '110', '开题报告.doc', NULL, '2018-05-22 09:51:00', NULL, 'Uploads/TrainStudent/5b0377843b5b8.doc'),
(42, '1', '140410414', '系统框架.ppt', NULL, '2018-05-14 17:24:58', 'Project', 'Uploads/Projects/5af955ea0912d.ppt'),
(43, '1', '110', '论文.pdf', '语音检测', '2018-05-16 17:13:35', 'Achievement', 'Uploads/Achievements/5afbf63f17391.pdf'),
(44, '2', '110', '论文.pdf', '会议论文', '2018-05-17 17:36:20', 'Achievement', 'Uploads/Achievements/5afd4d14c0a8f.pdf'),
(45, '3', '140410414', '论文.pdf', 'test', '2018-05-21 11:08:34', 'Achievement', 'Uploads/Achievements/5b023832eabe0.pdf'),
(47, NULL, '110', '开题报告.doc', NULL, '2018-05-22 09:47:48', NULL, 'Uploads/TrainStudent/5b0376c47c4d3.doc'),
(50, NULL, '140410414', '证书.pdf', NULL, '2018-05-23 11:28:02', NULL, 'Uploads/Prizes/5b04dfc27e461.pdf'),
(51, '5', '140410414', '论文.pdf', '图像检测算法', '2018-05-23 16:25:28', 'Achievement', 'Uploads/Achievements/5b0525783037e.pdf');

-- --------------------------------------------------------

--
-- 表的结构 `think_git`
--

DROP TABLE IF EXISTS `think_git`;
CREATE TABLE IF NOT EXISTS `think_git` (
  `id` varchar(20) NOT NULL,
  `type` varchar(255) NOT NULL,
  `project_num` varchar(255) NOT NULL,
  `institute` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `money` varchar(255) NOT NULL,
  `content` varchar(1000) DEFAULT NULL,
  `state` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_git`
--

INSERT INTO `think_git` (`id`, `type`, `project_num`, `institute`, `name`, `owner`, `money`, `content`, `state`) VALUES
('592d690be3bf0', '国家自然科学基金项目', '61202325', '哈尔滨工业大学', '科研成果在线管理系统', '张维刚', '132', '毕业设计题目', 0);

-- --------------------------------------------------------

--
-- 表的结构 `think_git_activity`
--

DROP TABLE IF EXISTS `think_git_activity`;
CREATE TABLE IF NOT EXISTS `think_git_activity` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `project_id` varchar(20) NOT NULL,
  `person_number` varchar(255) NOT NULL,
  `activity` varchar(1000) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `time` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_git_activity`
--

INSERT INTO `think_git_activity` (`id`, `project_id`, `person_number`, `activity`, `type`, `time`) VALUES
(1, '1', '140410414', '更新了项目的初始化模块', '更新项目状态', '2018-05-14 16:09:46'),
(2, '1', '140410401', '撰写报告，增加模块', '更新项目状态', '2018-05-14 16:28:18'),
(3, '1', '140410401', '修改模块内容', '更新项目状态', '2018-05-14 16:28:29'),
(4, '1', '110', '增加新功能1', '更新项目状态', '2018-05-14 16:28:54'),
(5, '1', '110', '更改数据库表单', '更新项目状态', '2018-05-14 16:29:17'),
(6, '1', '140410414', '修复新bug', '更新项目状态', '2018-05-14 16:29:50'),
(7, '1', '140410414', '增加新功能', '更新项目状态', '2018-05-14 16:30:11'),
(8, '1', '140410414', '系统框架.ppt', '上传了新文档', '2018-05-14 17:24:58');

-- --------------------------------------------------------

--
-- 表的结构 `think_git_cost`
--

DROP TABLE IF EXISTS `think_git_cost`;
CREATE TABLE IF NOT EXISTS `think_git_cost` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(20) NOT NULL,
  `git_id` varchar(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `content` varchar(1000) DEFAULT NULL,
  `state` int(1) NOT NULL DEFAULT '0',
  `time` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_git_cost`
--

INSERT INTO `think_git_cost` (`id`, `user_id`, `git_id`, `title`, `cost`, `content`, `state`, `time`) VALUES
(2, 2, '592d690be3bf0', '购买服务器', '10000.00', '购买服务器', 2, '2017-05-30'),
(3, 2, '592d690be3bf0', '购买无人机', '10000.00', '用于拍摄道路情况', 2, '2017-05-31'),
(4, 2, '592d690be3bf0', '论文查重费用', '200.00', '论文查重费用', 1, '2017-06-01'),
(5, 2, '592d690be3bf0', '测试', '123.00', '123', 0, '2017-06-01');

-- --------------------------------------------------------

--
-- 表的结构 `think_git_doc`
--

DROP TABLE IF EXISTS `think_git_doc`;
CREATE TABLE IF NOT EXISTS `think_git_doc` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `git_id` varchar(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `upload_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `path` varchar(255) DEFAULT NULL,
  `user_id` int(10) NOT NULL,
  `author` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_git_doc`
--

INSERT INTO `think_git_doc` (`id`, `git_id`, `title`, `description`, `upload_time`, `path`, `user_id`, `author`) VALUES
(12, '592d690be3bf0', '祝贺信.pdf', 'CSC公派硕士祝贺信', '2017-05-31 13:43:10', '592e57ee64158.pdf', 2, '张维刚'),
(13, '592d690be3bf0', '出国留学人员须知.pdf', '公派留学须知', '2017-06-01 15:25:58', '592fc186171b2.pdf', 2, '张维刚');

-- --------------------------------------------------------

--
-- 表的结构 `think_git_member`
--

DROP TABLE IF EXISTS `think_git_member`;
CREATE TABLE IF NOT EXISTS `think_git_member` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `git_id` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_git_member`
--

INSERT INTO `think_git_member` (`id`, `user_id`, `git_id`) VALUES
(30, 1, '592d690be3bf0'),
(31, 2, '592d690be3bf0'),
(32, 3, '592d690be3bf0'),
(33, 4, '592d690be3bf0'),
(34, 5, '592d690be3bf0'),
(35, 6, '592d690be3bf0'),
(36, 0, '5af2a80fbb2bc'),
(37, 0, '5af2c4c09b37a');

-- --------------------------------------------------------

--
-- 表的结构 `think_git_notice`
--

DROP TABLE IF EXISTS `think_git_notice`;
CREATE TABLE IF NOT EXISTS `think_git_notice` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `project_id` varchar(20) NOT NULL,
  `user_number` int(10) NOT NULL,
  `state` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `time` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_git_notice`
--

INSERT INTO `think_git_notice` (`id`, `project_id`, `user_number`, `state`, `title`, `content`, `time`) VALUES
(1, '1', 140410414, '已读', '准备资料', '收集相关资料，为项目架构设计准备', '2018-05-11 16:54:45'),
(2, '1', 140410401, '未读', '准备资料', '收集相关资料，为项目架构设计准备', '2018-05-11 16:40:23'),
(3, '1', 140410414, '未读', 'test1', 'test1', '2018-05-11 16:59:09'),
(4, '1', 140410401, '未读', 'test1', 'test1', '2018-05-11 16:59:09'),
(5, '1', 140410414, '已读', 'test2', 'test2', '2018-05-14 15:24:35'),
(6, '1', 140410414, '已读', 'test3', 'test3', '2018-05-14 15:17:08'),
(7, '1', 140410401, '未读', 'test3', 'test3', '2018-05-11 16:59:32'),
(8, '1', 140410414, '已读', 'test4', 'test4', '2018-05-14 15:07:53'),
(9, '1', 140410401, '未读', 'test4', 'test4', '2018-05-11 16:59:43');

-- --------------------------------------------------------

--
-- 表的结构 `think_git_upload`
--

DROP TABLE IF EXISTS `think_git_upload`;
CREATE TABLE IF NOT EXISTS `think_git_upload` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_number` varchar(20) NOT NULL,
  `project_id` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `file_id` int(10) DEFAULT NULL,
  `time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_git_upload`
--

INSERT INTO `think_git_upload` (`id`, `user_number`, `project_id`, `description`, `file_id`, `time`) VALUES
(1, '140410414', '1', '系统框架', 42, '2018-05-14 17:24:58');

-- --------------------------------------------------------

--
-- 表的结构 `think_journalpaper`
--

DROP TABLE IF EXISTS `think_journalpaper`;
CREATE TABLE IF NOT EXISTS `think_journalpaper` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_number` varchar(255) NOT NULL,
  `title_zh` varchar(255) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `abstract` varchar(1000) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `language` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `journal_name` varchar(255) DEFAULT NULL,
  `publish_date` date DEFAULT NULL,
  `doi` varchar(255) DEFAULT NULL,
  `paper_num` varchar(255) DEFAULT NULL,
  `inbox_status` varchar(255) DEFAULT NULL,
  `refer_num` int(10) DEFAULT '0',
  `juan_num` varchar(255) DEFAULT NULL,
  `qi_num` varchar(255) DEFAULT NULL,
  `not_have_page` varchar(255) DEFAULT NULL,
  `start_page` int(10) DEFAULT NULL,
  `end_page` int(10) DEFAULT NULL,
  `paper_link` varchar(255) DEFAULT NULL,
  `mark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_journalpaper`
--

INSERT INTO `think_journalpaper` (`id`, `user_number`, `title_zh`, `title_en`, `abstract`, `keywords`, `language`, `status`, `journal_name`, `publish_date`, `doi`, `paper_num`, `inbox_status`, `refer_num`, `juan_num`, `qi_num`, `not_have_page`, `start_page`, `end_page`, `paper_link`, `mark`) VALUES
(1, '110', '语音检测', 'yuyinjiance', '语音检测算法的应用', '语音检测', '中文', '已发表', '中国科学院', '2018-05-23', '1', '11', 'SSCI;', 12, '1', '12', 'no', 0, 0, '', '第一标注'),
(2, '140410414', '图像检测算法', 'tuxuangjiance', '图像检测算法的应用', '图像检测算法', '中文', '已发表', 'chinese image', '2017-05-02', '', '', 'SSCI;EI;', 12, '', '', NULL, 0, 0, '', '第二标注');

-- --------------------------------------------------------

--
-- 表的结构 `think_monograph`
--

DROP TABLE IF EXISTS `think_monograph`;
CREATE TABLE IF NOT EXISTS `think_monograph` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_number` varchar(255) NOT NULL,
  `title_zh` varchar(255) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `book_name` varchar(255) DEFAULT NULL,
  `books_name` varchar(255) DEFAULT NULL,
  `language` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `isbn` varchar(255) DEFAULT NULL,
  `editor` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `start_page` int(20) DEFAULT NULL,
  `end_page` int(20) DEFAULT NULL,
  `words_num` int(20) DEFAULT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `publish_date` date DEFAULT NULL,
  `relationship` varchar(255) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `paper_link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `think_msg_record`
--

DROP TABLE IF EXISTS `think_msg_record`;
CREATE TABLE IF NOT EXISTS `think_msg_record` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `train_id` varchar(20) NOT NULL,
  `title` varchar(20) NOT NULL,
  `content` varchar(20) DEFAULT NULL,
  `date` datetime NOT NULL,
  `file_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_msg_record`
--

INSERT INTO `think_msg_record` (`id`, `train_id`, `title`, `content`, `date`, `file_id`) VALUES
(1, '1', '开题', '开题报告内容待修改，文本格式不正确', '2018-05-22 09:47:48', 47);

-- --------------------------------------------------------

--
-- 表的结构 `think_patent`
--

DROP TABLE IF EXISTS `think_patent`;
CREATE TABLE IF NOT EXISTS `think_patent` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_number` varchar(255) NOT NULL,
  `country` varchar(255) DEFAULT NULL,
  `title_zh` varchar(255) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `patent_num` varchar(100) DEFAULT NULL,
  `abstract` varchar(1000) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `owner` varchar(255) DEFAULT NULL,
  `ipc` varchar(255) DEFAULT NULL,
  `cpc` varchar(255) DEFAULT NULL,
  `applyer` varchar(255) DEFAULT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `patent_type` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `content` varchar(1000) DEFAULT NULL,
  `paper_link` varchar(255) DEFAULT NULL,
  `apply_date` date DEFAULT NULL,
  `tran_status` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `think_prize`
--

DROP TABLE IF EXISTS `think_prize`;
CREATE TABLE IF NOT EXISTS `think_prize` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_number` varchar(255) NOT NULL,
  `prize_title` varchar(255) NOT NULL,
  `prize_institute` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `file_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_prize`
--

INSERT INTO `think_prize` (`id`, `user_number`, `prize_title`, `prize_institute`, `date`, `file_id`) VALUES
(1, '140410414', '科技创新一等奖', '计算机学院', '2018-05-23 11:28:02', 50);

-- --------------------------------------------------------

--
-- 表的结构 `think_project`
--

DROP TABLE IF EXISTS `think_project`;
CREATE TABLE IF NOT EXISTS `think_project` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `project_num` varchar(255) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `institute` varchar(255) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `money` varchar(255) DEFAULT NULL,
  `owner` varchar(255) NOT NULL,
  `inner_member` varchar(255) DEFAULT NULL,
  `outer_member` varchar(255) DEFAULT NULL,
  `achievement_id` varchar(255) DEFAULT NULL,
  `time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `status` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_project`
--

INSERT INTO `think_project` (`id`, `type`, `project_num`, `project_name`, `institute`, `content`, `money`, `owner`, `inner_member`, `outer_member`, `achievement_id`, `time`, `status`) VALUES
(1, '国家自然科学基金项目', '65535', '图像识别', '哈工大', '', '100', '110', '140410414,110,140410401', 'ming|hong', NULL, '2018-05-10 17:33:10', 0),
(2, '863计划课题', '65533', '语音检测', '哈工大', '基于 语音识别算法的应用', '100', '110', '140410414,110,140410401', '', NULL, '2018-05-17 16:36:30', 1);

-- --------------------------------------------------------

--
-- 表的结构 `think_project_member`
--

DROP TABLE IF EXISTS `think_project_member`;
CREATE TABLE IF NOT EXISTS `think_project_member` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_number` varchar(255) NOT NULL,
  `project_id` int(10) DEFAULT NULL,
  `project_num` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_project_member`
--

INSERT INTO `think_project_member` (`id`, `user_number`, `project_id`, `project_num`) VALUES
(1, '140410414', 1, '65535'),
(2, '110', 1, '65535'),
(3, '140410401', 1, '65535'),
(4, '140410414', 2, '65533'),
(5, '110', 2, '65533'),
(6, '140410401', 2, '65533');

-- --------------------------------------------------------

--
-- 表的结构 `think_project_type`
--

DROP TABLE IF EXISTS `think_project_type`;
CREATE TABLE IF NOT EXISTS `think_project_type` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_project_type`
--

INSERT INTO `think_project_type` (`id`, `type_name`) VALUES
(1, '国家自然科学基金项目'),
(2, '863计划课题'),
(3, '973计划课题'),
(4, '国家科技支撑计划课题'),
(5, '国家重点研发计划课题'),
(6, '其他国家级纵向项目'),
(7, '中国博士后科学基金资助'),
(8, '省自然科学基金项目'),
(9, '其他省部级纵向项目'),
(10, '产学研横向合作项目');

-- --------------------------------------------------------

--
-- 表的结构 `think_reward`
--

DROP TABLE IF EXISTS `think_reward`;
CREATE TABLE IF NOT EXISTS `think_reward` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_number` varchar(255) NOT NULL,
  `title_zh` varchar(255) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `abstract` varchar(1000) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `reward_type` varchar(255) DEFAULT NULL,
  `specific` varchar(255) DEFAULT NULL,
  `reward_level` varchar(255) DEFAULT NULL,
  `institute` varchar(255) DEFAULT NULL,
  `publish_date` date DEFAULT NULL,
  `reward_num` varchar(255) DEFAULT NULL,
  `relationship` varchar(1000) DEFAULT NULL,
  `content` varchar(1000) DEFAULT NULL,
  `paper_link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `think_software`
--

DROP TABLE IF EXISTS `think_software`;
CREATE TABLE IF NOT EXISTS `think_software` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_number` varchar(255) NOT NULL,
  `title_zh` varchar(255) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `reg_num` varchar(255) DEFAULT NULL,
  `get_type` varchar(255) DEFAULT NULL,
  `right_type` varchar(255) DEFAULT NULL,
  `specific` varchar(255) DEFAULT NULL,
  `over_date` date DEFAULT NULL,
  `content` varchar(1000) DEFAULT NULL,
  `paper_link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `think_standard`
--

DROP TABLE IF EXISTS `think_standard`;
CREATE TABLE IF NOT EXISTS `think_standard` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_number` varchar(255) NOT NULL,
  `country` varchar(255) DEFAULT NULL,
  `title_zh` varchar(255) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `standard_num` varchar(255) DEFAULT NULL,
  `institute` varchar(255) DEFAULT NULL,
  `standard_type` varchar(255) DEFAULT NULL,
  `publish_date` date DEFAULT NULL,
  `content` varchar(1000) DEFAULT NULL,
  `paper_link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `think_train_student`
--

DROP TABLE IF EXISTS `think_train_student`;
CREATE TABLE IF NOT EXISTS `think_train_student` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `stunum` varchar(20) NOT NULL,
  `stuname` varchar(20) NOT NULL,
  `major` varchar(20) NOT NULL,
  `title` varchar(30) NOT NULL,
  `content` varchar(255) DEFAULT NULL,
  `teacherNum` varchar(20) NOT NULL,
  `status` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_train_student`
--

INSERT INTO `think_train_student` (`id`, `stunum`, `stuname`, `major`, `title`, `content`, `teacherNum`, `status`) VALUES
(1, '140410413', '徐崇广', '计算机科学与技术', '科研实验室综合信息管理系统的设计与实现', '', '110', 0);

-- --------------------------------------------------------

--
-- 表的结构 `think_user`
--

DROP TABLE IF EXISTS `think_user`;
CREATE TABLE IF NOT EXISTS `think_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_number` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `lab_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `institute` varchar(255) DEFAULT NULL,
  `major` varchar(255) DEFAULT NULL,
  `work_title` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `degree` varchar(255) DEFAULT NULL,
  `degree_edu` varchar(255) DEFAULT NULL,
  `degree_year` varchar(4) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `teacher_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_user`
--

INSERT INTO `think_user` (`id`, `user_number`, `user_name`, `password`, `lab_name`, `email`, `institute`, `major`, `work_title`, `phone`, `address`, `degree`, `degree_edu`, `degree_year`, `position`, `teacher_id`) VALUES
(1, '140410414', '徐小光', 'dd78b5f11755d1aab0ebd2c42f9867e2', NULL, 'wxq@qq.com', NULL, '计算机科学与技术', '本科', NULL, NULL, '本科', NULL, NULL, 2, '110'),
(2, '110', '徐小东', '63a9f0ea7bb98050796b649e85481845', NULL, 'root@qq.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(3, '001', 'admin', '21232f297a57a5a743894a0e4a801fc3', NULL, 'admin@qq.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(4, '140410401', '徐小西', 'dd78b5f11755d1aab0ebd2c42f9867e2', NULL, 'wxq2@qq.com', NULL, '计算机科学与技术', '本科', NULL, NULL, '本科', NULL, NULL, 2, '110');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
