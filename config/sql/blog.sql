/*
 Navicat Premium Data Transfer

 Source Server         : local_mac
 Source Server Type    : MySQL
 Source Server Version : 50640
 Source Host           : localhost:3306
 Source Schema         : blog

 Target Server Type    : MySQL
 Target Server Version : 50640
 File Encoding         : 65001

 Date: 02/05/2020 20:58:05
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bs_account_role
-- ----------------------------
DROP TABLE IF EXISTS `bs_account_role`;
CREATE TABLE `bs_account_role` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增主键ID',
  `admin_id` int(10) NOT NULL DEFAULT '0' COMMENT '账号ID',
  `role_id` int(10) NOT NULL DEFAULT '0' COMMENT '角色ID',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_admin_id` (`admin_id`),
  KEY `idx_role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=305 DEFAULT CHARSET=utf8mb4 COMMENT='账号角色关联表';

-- ----------------------------
-- Records of bs_account_role
-- ----------------------------
BEGIN;
INSERT INTO `bs_account_role` VALUES (1, 1, 15);
INSERT INTO `bs_account_role` VALUES (2, 2, 15);
INSERT INTO `bs_account_role` VALUES (3, 18, 15);
INSERT INTO `bs_account_role` VALUES (4, 11, 33);
INSERT INTO `bs_account_role` VALUES (6, 44, 33);
INSERT INTO `bs_account_role` VALUES (41, 29, 19);
INSERT INTO `bs_account_role` VALUES (42, 28, 19);
INSERT INTO `bs_account_role` VALUES (43, 27, 19);
INSERT INTO `bs_account_role` VALUES (44, 26, 19);
INSERT INTO `bs_account_role` VALUES (45, 25, 19);
INSERT INTO `bs_account_role` VALUES (46, 24, 19);
INSERT INTO `bs_account_role` VALUES (47, 23, 19);
INSERT INTO `bs_account_role` VALUES (48, 22, 19);
INSERT INTO `bs_account_role` VALUES (49, 21, 19);
INSERT INTO `bs_account_role` VALUES (50, 20, 19);
INSERT INTO `bs_account_role` VALUES (51, 19, 19);
INSERT INTO `bs_account_role` VALUES (52, 18, 19);
INSERT INTO `bs_account_role` VALUES (53, 17, 19);
INSERT INTO `bs_account_role` VALUES (54, 12, 19);
INSERT INTO `bs_account_role` VALUES (55, 29, 18);
INSERT INTO `bs_account_role` VALUES (97, 12, 21);
INSERT INTO `bs_account_role` VALUES (98, 23, 23);
INSERT INTO `bs_account_role` VALUES (99, 22, 23);
INSERT INTO `bs_account_role` VALUES (100, 24, 23);
INSERT INTO `bs_account_role` VALUES (101, 23, 20);
INSERT INTO `bs_account_role` VALUES (102, 21, 20);
INSERT INTO `bs_account_role` VALUES (103, 27, 20);
INSERT INTO `bs_account_role` VALUES (104, 20, 20);
INSERT INTO `bs_account_role` VALUES (105, 24, 20);
INSERT INTO `bs_account_role` VALUES (118, 31, 20);
INSERT INTO `bs_account_role` VALUES (119, 31, 18);
INSERT INTO `bs_account_role` VALUES (140, 32, 26);
INSERT INTO `bs_account_role` VALUES (141, 31, 26);
INSERT INTO `bs_account_role` VALUES (143, 28, 26);
INSERT INTO `bs_account_role` VALUES (144, 27, 26);
INSERT INTO `bs_account_role` VALUES (145, 26, 26);
INSERT INTO `bs_account_role` VALUES (146, 24, 26);
INSERT INTO `bs_account_role` VALUES (147, 21, 26);
INSERT INTO `bs_account_role` VALUES (148, 20, 26);
INSERT INTO `bs_account_role` VALUES (149, 19, 26);
INSERT INTO `bs_account_role` VALUES (150, 18, 26);
INSERT INTO `bs_account_role` VALUES (151, 17, 26);
INSERT INTO `bs_account_role` VALUES (152, 12, 26);
INSERT INTO `bs_account_role` VALUES (196, 34, 18);
INSERT INTO `bs_account_role` VALUES (197, 34, 21);
INSERT INTO `bs_account_role` VALUES (199, 34, 23);
INSERT INTO `bs_account_role` VALUES (260, 34, 25);
INSERT INTO `bs_account_role` VALUES (261, 34, 22);
INSERT INTO `bs_account_role` VALUES (263, 32, 22);
INSERT INTO `bs_account_role` VALUES (264, 31, 22);
INSERT INTO `bs_account_role` VALUES (266, 28, 22);
INSERT INTO `bs_account_role` VALUES (267, 27, 22);
INSERT INTO `bs_account_role` VALUES (268, 26, 22);
INSERT INTO `bs_account_role` VALUES (269, 21, 22);
INSERT INTO `bs_account_role` VALUES (270, 20, 22);
INSERT INTO `bs_account_role` VALUES (271, 19, 22);
INSERT INTO `bs_account_role` VALUES (272, 18, 22);
INSERT INTO `bs_account_role` VALUES (273, 12, 22);
INSERT INTO `bs_account_role` VALUES (282, 33, 18);
INSERT INTO `bs_account_role` VALUES (283, 33, 21);
INSERT INTO `bs_account_role` VALUES (284, 33, 22);
INSERT INTO `bs_account_role` VALUES (285, 33, 23);
INSERT INTO `bs_account_role` VALUES (286, 33, 25);
INSERT INTO `bs_account_role` VALUES (287, 33, 28);
INSERT INTO `bs_account_role` VALUES (288, 33, 29);
INSERT INTO `bs_account_role` VALUES (289, 33, 30);
INSERT INTO `bs_account_role` VALUES (291, 30, 22);
INSERT INTO `bs_account_role` VALUES (292, 34, 31);
INSERT INTO `bs_account_role` VALUES (293, 33, 31);
INSERT INTO `bs_account_role` VALUES (294, 32, 31);
INSERT INTO `bs_account_role` VALUES (295, 31, 31);
INSERT INTO `bs_account_role` VALUES (296, 30, 31);
INSERT INTO `bs_account_role` VALUES (297, 28, 31);
INSERT INTO `bs_account_role` VALUES (298, 27, 31);
INSERT INTO `bs_account_role` VALUES (299, 26, 31);
INSERT INTO `bs_account_role` VALUES (300, 21, 31);
INSERT INTO `bs_account_role` VALUES (301, 20, 31);
INSERT INTO `bs_account_role` VALUES (302, 19, 31);
INSERT INTO `bs_account_role` VALUES (303, 18, 31);
INSERT INTO `bs_account_role` VALUES (304, 12, 31);
COMMIT;

-- ----------------------------
-- Table structure for bs_admin
-- ----------------------------
DROP TABLE IF EXISTS `bs_admin`;
CREATE TABLE `bs_admin` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT COMMENT '自增主键ID',
  `username` varchar(30) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(50) NOT NULL DEFAULT '' COMMENT '用户密码',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '邮箱',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '管理员类型（99总管理员，1普通管理员）',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态（0禁用，1启用）',
  `last_login_ip` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录IP',
  `last_login_time` int(10) NOT NULL DEFAULT '0' COMMENT '上次登录时间',
  `delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0已删除，1未删除）',
  `edit_time` int(10) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `idx_username` (`username`),
  KEY `idx_delete` (`delete`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COMMENT='后台用户表';

-- ----------------------------
-- Records of bs_admin
-- ----------------------------
BEGIN;
INSERT INTO `bs_admin` VALUES (1, 'admin', '123456', '280784436@qq.com', 99, 0, 0, 1588250701, 1, 1535709752, 1534048314);
INSERT INTO `bs_admin` VALUES (2, 'luoqiang', '420684', 'luoqiang314@163.com', 1, 1, 0, 0, 1, 1535769911, 1534048522);
INSERT INTO `bs_admin` VALUES (12, '利税', '33332233', '4433@qq.com', 1, 0, 0, 1534922797, 0, 1581818719, 1535025361);
INSERT INTO `bs_admin` VALUES (17, '李晨', '111111111', '234432@163.com', 1, 1, 0, 0, 1, 1581833092, 1535207416);
INSERT INTO `bs_admin` VALUES (18, '刘海', '44444444', '432577@qq.com', 1, 1, 0, 0, 0, 1581772907, 1535207479);
INSERT INTO `bs_admin` VALUES (19, '李军', '9999999999', '111222@qq.com', 1, 0, 0, 0, 0, 1581772910, 1535207511);
INSERT INTO `bs_admin` VALUES (20, '小六', '66666666666', 'qq66666@163.com', 1, 1, 0, 0, 0, 1535331844, 1535207586);
INSERT INTO `bs_admin` VALUES (21, '赵海', '123454', '45632@qq.com', 1, 1, 0, 0, 0, 1535508636, 1535207892);
INSERT INTO `bs_admin` VALUES (22, '罗兵', '33333333', '280784436@qq.com', 1, 1, 0, 0, 1, 1581772882, 1535253928);
INSERT INTO `bs_admin` VALUES (23, '罗力', '2222222222', 'ssssss@qq.com', 1, 1, 0, 0, 1, 1581772882, 1535253954);
INSERT INTO `bs_admin` VALUES (24, '罗静', '333334rrs', 'eeee@qq.com', 1, 1, 0, 0, 1, 1581833124, 1535253994);
INSERT INTO `bs_admin` VALUES (25, '杨心', '345r54ss', 'ddddd@qq.com', 1, 0, 0, 0, 1, 1574865030, 1535256067);
INSERT INTO `bs_admin` VALUES (26, '令狐', '12353w22w', 'rrrr@qq.com', 1, 0, 0, 0, 0, 1574260697, 1535459429);
INSERT INTO `bs_admin` VALUES (27, 'asdf', '6666666666', '99888888@qq.com', 1, 1, 0, 0, 0, 1574692277, 1535506235);
INSERT INTO `bs_admin` VALUES (28, 'user000001', '111111qq', '111@qq.com', 1, 0, 0, 0, 0, 1581818791, 1574518366);
INSERT INTO `bs_admin` VALUES (29, 'user000008', '111111qq', '1111@qq.com', 1, 1, 0, 0, 1, 1581772756, 1574518423);
INSERT INTO `bs_admin` VALUES (30, 'admin', '123456', '11@qq.com', 1, 1, 0, 1588250701, 0, 1584103407, 1574608910);
INSERT INTO `bs_admin` VALUES (31, 'system11', '111111q', '22@qq.com', 1, 1, 0, 0, 0, 1581818785, 1574688395);
INSERT INTO `bs_admin` VALUES (32, 'system550', '11111q', '11@qq.com', 1, 0, 0, 0, 0, 1581818783, 1574692787);
INSERT INTO `bs_admin` VALUES (33, 'luo', 'p12345', '6666@qq.com', 1, 1, 0, 1582376070, 0, 1582379165, 1581772139);
INSERT INTO `bs_admin` VALUES (34, 'system', '123456', '44@2777779999992.com', 1, 1, 0, 1584103328, 0, 1582379282, 1581819010);
COMMIT;

-- ----------------------------
-- Table structure for bs_article
-- ----------------------------
DROP TABLE IF EXISTS `bs_article`;
CREATE TABLE `bs_article` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增主键ID',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '标题',
  `content_md` text COMMENT '内容-md',
  `content_html` text COMMENT '内容-html',
  `category_id` smallint(4) NOT NULL DEFAULT '0' COMMENT '分类ID',
  `label_ids` varchar(50) NOT NULL DEFAULT '0' COMMENT '标签ID（如：23,15,42）',
  `read_number` int(10) NOT NULL DEFAULT '0' COMMENT '阅读次数',
  `word_number` int(10) NOT NULL DEFAULT '0' COMMENT '文章字数',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '类型（1原创，2转载）',
  `release` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否发布（0未发布，1已发布）',
  `delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0已删除，1未删除）',
  `edit_time` int(10) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `idx_title` (`title`),
  KEY `idx_category_id` (`category_id`),
  KEY `idx_label_ids` (`label_ids`),
  KEY `idx_release` (`release`),
  KEY `idx_delete` (`delete`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COMMENT='文章表';

-- ----------------------------
-- Records of bs_article
-- ----------------------------
BEGIN;
INSERT INTO `bs_article` VALUES (2, '设计模式之单例模式', '单例模式：三私一公', NULL, 1, '', 0, 0, 1, 1, 0, 1587784780, 1535704740);
INSERT INTO `bs_article` VALUES (3, 'JS提取字符串中文英文数字', '最近在做导出excel的时候，发现导出成功，文件大小也正常，但是Office 2013打不开，检查数据库发现，导出数据中有非中文字符导致Excel异常。\n\n我们知道JS是支持unicode字符集的，符合导出规则的字符应该是”中文”、”英文”、”数字”。\n\n## 正则表达式\n\n```\n/([\\u4e00-\\u9fa5\\w]*)/ig\n```\n## 提取字符串\n```\n/**\n* 获得可打印字符\n* @param str 需要提取的字符串\n*/\nfunction getPrintableChars(str) {\n  const matches = str.match(/([\\u4e00-\\u9fa5\\w]*)/ig;\n \n  let a = \'\';\n  matches.forEach(item=> item && (a += item));\n  return a;\n}\n\n```', '最近在做导出excel的时候，发现导出成功，文件大小也正常，但是Office 2013打不开，检查数据库发现，导出数据中有非中文字符导致Excel异常。我们知道JS是支持unicode字符集的，符合导出规则的字符应该是”中文”、”英文”、”数字”。正则表达式 /([\\u4e00-\\u9fa5\\w]*', 26, '', 0, 343, 1, 1, 0, 1588252780, 1535706544);
INSERT INTO `bs_article` VALUES (4, 'PHP实现“异步”', '众所周知，PHP不使用多线程扩展的情况下是不支持异步的(不算curl之类)。今天无意中看到一个函数fastcgi_finish_request;\n这个方法是PHP5.3+开始提供。\n注释写的很清楚，有耗时操作的时候使用该函数可以尽早结束fastcgi处理过程，提高页面响应速度。\n\n## 代码说明\n### 说明1\n999\n9999\n\n### 说明1\n888 8888\n\n### 说明3\n\n777 77777\n\n#### 说明3-1\n3-1 3-1\n\n#### 说明3-1\n3-2 3-2\n\n```\n<?php\necho 1;\nfastcgi_finish_request();\nsleep(3);\n?>\n```\n\n此时打开浏览器发现响应速度并没有受到sleep函数的影响，基于此点，可以在适当的时候使用该函数以提升用户体验!\n\n## 注意事项\nPHP需要运行在fpm模式下才可以使用本函数。。\n22\n#### 说明3-1\n3-1 3-1\n\n#### 说明3-1\n3-2 3-2\n\n```\n<?php\necho 1;\nfastcgi_finish_request();\nsleep(3);\n?>\n```\n\n此时打开浏览器发现响应速度并没有受到sleep函数的影响，基于此点，可以在适当的时候使用该函数以提升用户体验!\n\n## 注意事项\nPHP需要运行在fpm模式下才可以使用本函数。。\n22\n#### 说明3-1\n3-1 3-1\n\n#### 说明3-1\n3-2 3-2\n\n```\n<?php\necho 1;\nfastcgi_finish_request();\nsleep(3);\n?>\n```\n\n此时打开浏览器发现响应速度并没有受到sleep函数的影响，基于此点，可以在适当的时候使用该函数以提升用户体验!\n\n## 注意事项\nPHP需要运行在fpm模式下才可以使用本函数。。\n22\n#### 说明3-1\n3-1 3-1\n\n#### 说明3-1\n3-2 3-2\n\n```\n<?php\necho 1;\nfastcgi_finish_request();\nsleep(3);\n?>\n```\n\n此时打开浏览器发现响应速度并没有受到sleep函数的影响，基于此点，可以在适当的时候使用该函数以提升用户体验!\n\n## 注意事项\nPHP需要运行在fpm模式下才可以使用本函数。。\n22\n#### 说明3-1\n3-1 3-1\n\n#### 说明3-1\n3-2 3-2\n\n```\n<?php\necho 1;\nfastcgi_finish_request();\nsleep(3);\n?>\n```\n\n此时打开浏览器发现响应速度并没有受到sleep函数的影响，基于此点，可以在适当的时候使用该函数以提升用户体验!\n\n## 注意事项\nPHP需要运行在fpm模式下才可以使用本函数。。\n22\n\n', '众所周知，PHP不使用多线程扩展的情况下是不支持异步的(不算curl之类)。今天无意中看到一个函数fastcgi_finish_request; 这个方法是PHP5.3+开始提供。 注释写的很清楚，有耗时操作的时候使用该函数可以尽早结束fastcgi处理过程，提高页面响应速度。代码说明 说明1 99', 37, '', 0, 746, 1, 1, 0, 1588252774, 1535769830);
INSERT INTO `bs_article` VALUES (15, 'PHP7编译sphinx扩展', '最近在做基于sphinx的全文搜索引擎，使用PHP进行数据读取，但是服务器使用的PHP版本是PHP7，pecl.php.net中没有提供PHP7的版本。手痒点到source code中看了一下。\n看到源代码中有的headers中有个php7的，点击shortlog进去看了一下，最新更新日期是2017-02-10，挺新的，应该是针对PHP7开发的版本，只不过未发布编译版本，想着linux下的软件有源代码基本都能自行编译。故选择了最新的PHP7快照下载。\n## 开始安装\n```\nwget http://git.php.net/?p=pecl/search_engine/sphinx.git;a=snapshot;h=339e123acb0ce7beb2d9d4f9094d6f8bcf15fb54;sf=tgz\ntar xvfz sphinx-339e123.tar.gz\ncd sphinx-339e123\nphpize\n./configure\nmake && make install\n```\n安装完毕后会在PHP的配置文件目录多出sphinx.ini，在扩展目录多出sphinx.so文件。终端执行\n```\nphpenmod sphinx\n```\n即可启用扩展。\n## 本文服务器环境\nUbuntu16.04 Server + PHP7.0(使用apt安装)。\n最近在做基于sphinx的全文搜索引擎，使用PHP进行数据读取，但是服务器使用的PHP版本是PHP7，pecl.php.net中没有提供PHP7的版本。手痒点到source code中看了一下。\n看到源代码中有的headers中有个php7的，点击shortlog进去看了一下，最新更新日期是2017-02-10，挺新的，应该是针对PHP7开发的版本，只不过未发布编译版本，想着linux下的软件有源代码基本都能自行编译。故选择了最新的PHP7快照下载。\n## 开始安装\n```\nwget http://git.php.net/?p=pecl/search_engine/sphinx.git;a=snapshot;h=339e123acb0ce7beb2d9d4f9094d6f8bcf15fb54;sf=tgz\ntar xvfz sphinx-339e123.tar.gz\ncd sphinx-339e123\nphpize\n./configure\nmake && make install\n```\n安装完毕后会在PHP的配置文件目录多出sphinx.ini，在扩展目录多出sphinx.so文件。终端执行\n```\nphpenmod sphinx\n```\n即可启用扩展。\n## 本文服务器环境\nUbuntu16.04 Server + PHP7.0(使用apt安装)。\n最近在做基于sphinx的全文搜索引擎，使用PHP进行数据读取，但是服务器使用的PHP版本是PHP7，pecl.php.net中没有提供PHP7的版本。手痒点到source code中看了一下。\n看到源代码中有的headers中有个php7的，点击shortlog进去看了一下，最新更新日期是2017-02-10，挺新的，应该是针对PHP7开发的版本，只不过未发布编译版本，想着linux下的软件有源代码基本都能自行编译。故选择了最新的PHP7快照下载。\n## 开始安装\n```\nwget http://git.php.net/?p=pecl/search_engine/sphinx.git;a=snapshot;h=339e123acb0ce7beb2d9d4f9094d6f8bcf15fb54;sf=tgz\ntar xvfz sphinx-339e123.tar.gz\ncd sphinx-339e123\nphpize\n./configure\nmake && make install\n```\n安装完毕后会在PHP的配置文件目录多出sphinx.ini，在扩展目录多出sphinx.so文件。终端执行\n```\nphpenmod sphinx\n```\n即可启用扩展。\n## 本文服务器环境\nUbuntu16.04 Server + PHP7.0(使用apt安装)。\n最近在做基于sphinx的全文搜索引擎，使用PHP进行数据读取，但是服务器使用的PHP版本是PHP7，pecl.php.net中没有提供PHP7的版本。手痒点到source code中看了一下。\n看到源代码中有的headers中有个php7的，点击shortlog进去看了一下，最新更新日期是2017-02-10，挺新的，应该是针对PHP7开发的版本，只不过未发布编译版本，想着linux下的软件有源代码基本都能自行编译。故选择了最新的PHP7快照下载。\n## 开始安装\n```\nwget http://git.php.net/?p=pecl/search_engine/sphinx.git;a=snapshot;h=339e123acb0ce7beb2d9d4f9094d6f8bcf15fb54;sf=tgz\ntar xvfz sphinx-339e123.tar.gz\ncd sphinx-339e123\nphpize\n./configure\nmake && make install\n```\n安装完毕后会在PHP的配置文件目录多出sphinx.ini，在扩展目录多出sphinx.so文件。终端执行\n```\nphpenmod sphinx\n```\n即可启用扩展。\n## 本文服务器环境\nUbuntu16.04 Server + PHP7.0(使用apt安装)。\n最近在做基于sphinx的全文搜索引擎，使用PHP进行数据读取，但是服务器使用的PHP版本是PHP7，pecl.php.net中没有提供PHP7的版本。手痒点到source code中看了一下。\n看到源代码中有的headers中有个php7的，点击shortlog进去看了一下，最新更新日期是2017-02-10，挺新的，应该是针对PHP7开发的版本，只不过未发布编译版本，想着linux下的软件有源代码基本都能自行编译。故选择了最新的PHP7快照下载。\n## 开始安装\n```\nwget http://git.php.net/?p=pecl/search_engine/sphinx.git;a=snapshot;h=339e123acb0ce7beb2d9d4f9094d6f8bcf15fb54;sf=tgz\ntar xvfz sphinx-339e123.tar.gz\ncd sphinx-339e123\nphpize\n./configure\nmake && make install\n```\n安装完毕后会在PHP的配置文件目录多出sphinx.ini，在扩展目录多出sphinx.so文件。终端执行\n```\nphpenmod sphinx\n```\n即可启用扩展。\n## 本文服务器环境\nUbuntu16.04 Server + PHP7.0(使用apt安装)。\n最近在做基于sphinx的全文搜索引擎，使用PHP进行数据读取，但是服务器使用的PHP版本是PHP7，pecl.php.net中没有提供PHP7的版本。手痒点到source code中看了一下。\n看到源代码中有的headers中有个php7的，点击shortlog进去看了一下，最新更新日期是2017-02-10，挺新的，应该是针对PHP7开发的版本，只不过未发布编译版本，想着linux下的软件有源代码基本都能自行编译。故选择了最新的PHP7快照下载。\n## 开始安装\n```\nwget http://git.php.net/?p=pecl/search_engine/sphinx.git;a=snapshot;h=339e123acb0ce7beb2d9d4f9094d6f8bcf15fb54;sf=tgz\ntar xvfz sphinx-339e123.tar.gz\ncd sphinx-339e123\nphpize\n./configure\nmake && make install\n```\n安装完毕后会在PHP的配置文件目录多出sphinx.ini，在扩展目录多出sphinx.so文件。终端执行\n```\nphpenmod sphinx\n```\n即可启用扩展。\n## 本文服务器环境\nUbuntu16.04 Server + PHP7.0(使用apt安装)。4444', '最近在做基于sphinx的全文搜索引擎，使用PHP进行数据读取，但是服务器使用的PHP版本是PHP7，pecl.php.net中没有提供PHP7的版本。手痒点到source code中看了一下。 看到源代码中有的headers中有个php7的，点击shortlog进去看了一下，最新更新日期是2017', 1, '', 0, 3345, 1, 1, 0, 1588252752, 1580997387);
INSERT INTO `bs_article` VALUES (17, 'MySQL行锁的使用', '大家可能都有这样一种感觉，Web程序在本地调试的时候一切正常，放到线上也基本是正常，但是偶尔会有数据错误的情况，这种情况在订单系统中特别常见，因为大部分的订单状态更新都是有两个路径（浏览器跳转和支付服务器的异步推送消息），当然，最终数据要以异步结果为准，但是问题是，浏览器跳转也需要更新订单状态，当这两种方式在很短的时间内同时到达数据库时（一般在一秒内），如果数据库没有加锁，那这个订单会被处理两次。\n\n说到建立数据表时，涉及到支付的，都要用InnoDB引擎，该引擎支持行锁，支持事务，外键。\n\n文章开始的解决办法就是采用InnoDB对要操作的数据行进行锁定。\n\n## 数据表结构\n```\n订单ID(主键)  订单金额  订单状态\n```\n## 事务SQL\n```\nBEGIN;\nSELECT * FROM `orders` WHERE `order_id`=100 FOR UPDATE;\nCOMMIT;\n```\n## 释义\n1. BEGIN 手动开启事务（行锁只对开启事务的查询起作用）\n1. FOR UPDATE 独占写（成功获得锁后，只有当前进程能够更新该纪录，其他进程如果需要更新该记录，则需进行“锁等待”）\n1. COMMIT 提交处理\n', '大家可能都有这样一种感觉，Web程序在本地调试的时候一切正常，放到线上也基本是正常，但是偶尔会有数据错误的情况，这种情况在订单系统中特别常见，因为大部分的订单状态更新都是有两个路径（浏览器跳转和支付服务器的异步推送消息），当然，最终数据要以异步结果为准，但是问题是，浏览器跳转也需要更新订单状态，当这', 25, '62,58', 0, 483, 1, 1, 0, 1588252799, 1517694657);
INSERT INTO `bs_article` VALUES (43, 'redis常用实践', 'Redis相信大家都不陌生，而如果只是用来取代memcached做缓存的话，实在是大材小用了。一起来看看生产环境下的常用用法。\n# 分布式锁\n```\n$canLock = $redis->set(\'k\', 1, \'NX\', \'EX\', 2);\nif($canLock) {\n    // 获得锁成功\n}\n```\n锁定键名为k的数据两秒钟，两秒后该方法才能重新获取锁\n```\n$redis->del(\'k\');\n```\n# Hash\n这是redis特有的数据结构，memcached没有。使用场景很多，列举一种常用的，假设有一个需求\n> 加密后的用户id和真实用户id的映射关系保存\n\n这种情况我们可以使用hash，而不是使用多个kv缓存, 需要清空所有的时候比较难处理。代码如下：\n```\n$realId = $redis->hget(\'user_id_map\', \'userId1\');\nif(!empty($realId)) {\n    return $realId;\n}\n$realId = getFromDatabase(\'userId1\'); // 从数据库读取\n$redis->hset(\'user_id_map\',\'userId1\',$realId);\n```', 'Redis相信大家都不陌生，而如果只是用来取代memcached做缓存的话，实在是大材小用了。一起来看看生产环境下的常用用法。分布式锁 $canLock = $redis-set(\'k\', 1, \'NX\', \'EX\', 2); if($canLock) { // 获得锁成功 }锁定键名为k的', 25, '', 0, 497, 1, 1, 0, 1588252765, 1514649773);
INSERT INTO `bs_article` VALUES (54, '个人简介-罗强页页页页页页页页页页页页页页页页页页页', '# 个人简介\n人简介罗强\nEmail: luoqiang314@gmail.com\n喜欢学习，喜欢实践。\n# 开发语言\n* Typescript\n* PHP\n* Golang\n\n', '个人简介 人简介罗强 Email: luoqiang314@gmail.com 喜欢学习，喜欢实践。开发语言 Typescript PHP Golang', 24, '', 0, 77, 1, 1, 0, 1588252735, 1546355098);
INSERT INTO `bs_article` VALUES (55, '在事务中使用闭包函数简化开发罗路路级级级级级级级级级', '最近在做导出excel的时候，发现导出成功，文件大小也正常，但是Office 2013打不开，检查数据库发现，导出数据中有非中文字符导致Excel异常。\n\n我们知道JS是支持unicode字符集的，符合导出规则的字符应该是”中文”、”英文”、”数字”。\n\n## 正则表达式\n\n```\n/([\\u4e00-\\u9fa5\\w]*)/ig\n```\n## 提取字符串\n```\n/**\n* 获得可打印字符\n* @param str 需要提取的字符串\n*/\nfunction getPrintableChars(str) {\n  const matches = str.match(/([\\u4e00-\\u9fa5\\w]*)/ig）;\n \n  let a = \'\';\n  matches.forEach(item=> item && (a += item));\n  return a;\n}\n\n```', '最近在做导出excel的时候，发现导出成功，文件大小也正常，但是Office 2013打不开，检查数据库发现，导出数据中有非中文字符导致Excel异常。我们知道JS是支持unicode字符集的，符合导出规则的字符应该是”中文”、”英文”、”数字”。正则表达式 /([\\u4e00-\\u9fa5\\w]*', 27, '62,58', 0, 344, 1, 1, 0, 1588252791, 1580647805);
INSERT INTO `bs_article` VALUES (56, '在Swoole环境下运行注入Yii2框架的thrift应用777777777777777', '#### yyyyy\n99999\n99999\n\n99999\n\n9999\n# 777777777\n## 99999\n### aaaaaaaa\n![alt](https://ss0.bdstatic.com/94oJfD_bAAcT8t7mm9GUKT-xh_/timg?image&quality=100&size=b4000_4000&sec=1580989447&di=f3765496f9f2570e0725f67cff938c1a&src=http://pic1.win4000.com/wallpaper/c/565bdafb046a5.jpg)', 'yyyyy 99999 99999999999999777777777 99999 aaaaaaaa', 22, '', 0, 50, 1, 1, 0, 1588252725, 1580989514);
INSERT INTO `bs_article` VALUES (58, 'PHP7编译sphinx扩展好好好好好好好好好好好好', '\n\n最近在做基于sphinx的全文搜索引擎，使用PHP进行数据读取，但是服务器使用的PHP版本是PHP7，pecl.php.net中没有提供PHP7的版本。手痒点到source code中看了一下。\n看到源代码中有的headers中有个php7的，点击shortlog进去看了一下，最新更新日期是2017-02-10，挺新的，应该是针对PHP7开发的版本，只不过未发布编译版本，想着linux下的软件有源代码基本都能自行编译。故选择了最新的PHP7快照下载。\n## 开始安装\n```\nwget http://git.php.net/?p=pecl/search_engine/sphinx.git;a=snapshot;h=339e123acb0ce7beb2d9d4f9094d6f8bcf15fb54;sf=tgz\ntar xvfz sphinx-339e123.tar.gz\ncd sphinx-339e123\nphpize\n./configure\nmake && make install\n```\n安装完毕后会在PHP的配置文件目录多出sphinx.ini，在扩展目录多出sphinx.so文件。终端执行\n```\nphpenmod sphinx\n```\n即可启用扩展。\n## 本文服务器环境\nUbuntu16.04 Server + PHP7.0(使用apt安装)。\n最近在做基于sphinx的全文搜索引擎，使用PHP进行数据读取，但是服务器使用的PHP版本是PHP7，pecl.php.net中没有提供PHP7的版本。手痒点到source code中看了一下。\n看到源代码中有的headers中有个php7的，点击shortlog进去看了一下，最新更新日期是2017-02-10，挺新的，应该是针对PHP7开发的版本，只不过未发布编译版本，想着linux下的软件有源代码基本都能自行编译。故选择了最新的PHP7快照下载。\n## 开始安装\n```\nwget http://git.php.net/?p=pecl/search_engine/sphinx.git;a=snapshot;h=339e123acb0ce7beb2d9d4f9094d6f8bcf15fb54;sf=tgz\ntar xvfz sphinx-339e123.tar.gz\ncd sphinx-339e123\nphpize\n./configure\nmake && make install\n```\n安装完毕后会在PHP的配置文件目录多出sphinx.ini，在扩展目录多出sphinx.so文件。终端执行\n```\nphpenmod sphinx\n```\n即可启用扩展。\n## 本文服务器环境\nUbuntu16.04 Server + PHP7.0(使用apt安装)。\n最近在做基于sphinx的全文搜索引擎，使用PHP进行数据读取，但是服务器使用的PHP版本是PHP7，pecl.php.net中没有提供PHP7的版本。手痒点到source code中看了一下。\n看到源代码中有的headers中有个php7的，点击shortlog进去看了一下，最新更新日期是2017-02-10，挺新的，应该是针对PHP7开发的版本，只不过未发布编译版本，想着linux下的软件有源代码基本都能自行编译。故选择了最新的PHP7快照下载。\n## 开始安装\n```\nwget http://git.php.net/?p=pecl/search_engine/sphinx.git;a=snapshot;h=339e123acb0ce7beb2d9d4f9094d6f8bcf15fb54;sf=tgz\ntar xvfz sphinx-339e123.tar.gz\ncd sphinx-339e123\nphpize\n./configure\nmake && make install\n```\n安装完毕后会在PHP的配置文件目录多出sphinx.ini，在扩展目录多出sphinx.so文件。终端执行\n```\nphpenmod sphinx\n```\n即可启用扩展。\n## 本文服务器环境\nUbuntu16.04 Server + PHP7.0(使用apt安装)。\n最近在做基于sphinx的全文搜索引擎，使用PHP进行数据读取，但是服务器使用的PHP版本是PHP7，pecl.php.net中没有提供PHP7的版本。手痒点到source code中看了一下。\n看到源代码中有的headers中有个php7的，点击shortlog进去看了一下，最新更新日期是2017-02-10，挺新的，应该是针对PHP7开发的版本，只不过未发布编译版本，想着linux下的软件有源代码基本都能自行编译。故选择了最新的PHP7快照下载。\n## 开始安装\n```\nwget http://git.php.net/?p=pecl/search_engine/sphinx.git;a=snapshot;h=339e123acb0ce7beb2d9d4f9094d6f8bcf15fb54;sf=tgz\ntar xvfz sphinx-339e123.tar.gz\ncd sphinx-339e123\nphpize\n./configure\nmake && make install\n```\n安装完毕后会在PHP的配置文件目录多出sphinx.ini，在扩展目录多出sphinx.so文件。终端执行\n```\nphpenmod sphinx\n```\n即可启用扩展。\n## 本文服务器环境\nUbuntu16.04 Server + PHP7.0(使用apt安装)。\n最近在做基于sphinx的全文搜索引擎，使用PHP进行数据读取，但是服务器使用的PHP版本是PHP7，pecl.php.net中没有提供PHP7的版本。手痒点到source code中看了一下。\n看到源代码中有的headers中有个php7的，点击shortlog进去看了一下，最新更新日期是2017-02-10，挺新的，应该是针对PHP7开发的版本，只不过未发布编译版本，想着linux下的软件有源代码基本都能自行编译。故选择了最新的PHP7快照下载。\n## 开始安装\n```\nwget http://git.php.net/?p=pecl/search_engine/sphinx.git;a=snapshot;h=339e123acb0ce7beb2d9d4f9094d6f8bcf15fb54;sf=tgz\ntar xvfz sphinx-339e123.tar.gz\ncd sphinx-339e123\nphpize\n./configure\nmake && make install\n```\n安装完毕后会在PHP的配置文件目录多出sphinx.ini，在扩展目录多出sphinx.so文件。终端执行\n```\nphpenmod sphinx\n```\n即可启用扩展。\n## 本文服务器环境\nUbuntu16.04 Server + PHP7.0(使用apt安装)。\n最近在做基于sphinx的全文搜索引擎，使用PHP进行数据读取，但是服务器使用的PHP版本是PHP7，pecl.php.net中没有提供PHP7的版本。手痒点到source code中看了一下。\n看到源代码中有的headers中有个php7的，点击shortlog进去看了一下，最新更新日期是2017-02-10，挺新的，应该是针对PHP7开发的版本，只不过未发布编译版本，想着linux下的软件有源代码基本都能自行编译。故选择了最新的PHP7快照下载。\n## 开始安装\n```\nwget http://git.php.net/?p=pecl/search_engine/sphinx.git;a=snapshot;h=339e123acb0ce7beb2d9d4f9094d6f8bcf15fb54;sf=tgz\ntar xvfz sphinx-339e123.tar.gz\ncd sphinx-339e123\nphpize\n./configure\nmake && make install\n```\n安装完毕后会在PHP的配置文件目录多出sphinx.ini，在扩展目录多出sphinx.so文件。终端执行\n```\nphpenmod sphinx\n```\n即可启用扩展。\n## 本文服务器环境\nUbuntu16.04 Server + PHP7.0(使用apt安装)。4444', '最近在做基于sphinx的全文搜索引擎，使用PHP进行数据读取，但是服务器使用的PHP版本是PHP7，pecl.php.net中没有提供PHP7的版本。手痒点到source code中看了一下。 看到源代码中有的headers中有个php7的，点击shortlog进去看了一下，最新更新日期是2017', 24, '62,18', 0, 3345, 1, 1, 0, 1588255259, 1582447227);
INSERT INTO `bs_article` VALUES (59, '调研', '众所周知，PHP不使用多线程扩展的情况下是不支持异步的(不算curl之类)。今天无意中看到一个函数fastcgi_finish_request;\n这个方法是PHP5.3+开始提供。\n注释写的很清楚，有耗时操作的时候使用该函数可以尽早结束fastcgi处理过程，提高页面响应速度。\n\n## 代码说明\n### 说明1\n999\n9999\n\n### 说明1\n888 8888\n\n### 说明3\n\n777 77777\n\n#### 说明3-1\n3-1 3-1\n\n#### 说明3-1\n3-2 3-2\n\n```\n<?php\necho 1;\nfastcgi_finish_request();\nsleep(3);\n?>\n```\n\n此时打开浏览器发现响应速度并没有受到sleep函数的影响，基于此点，可以在适当的时候使用该函数以提升用户体验!\n\n## 注意事项\nPHP需要运行在fpm模式下才可以使用本函数。。\n22\n#### 说明3-1\n3-1 3-1\n\n#### 说明3-1\n3-2 3-2\n\n```\n<?php\necho 1;\nfastcgi_finish_request();\nsleep(3);\n?>\n```\n\n此时打开浏览器发现响应速度并没有受到sleep函数的影响，基于此点，可以在适当的时候使用该函数以提升用户体验!\n\n## 注意事项\nPHP需要运行在fpm模式下才可以使用本函数。。\n22\n#### 说明3-1\n3-1 3-1\n\n#### 说明3-1\n3-2 3-2\n\n```\n<?php\necho 1;\nfastcgi_finish_request();\nsleep(3);\n?>\n```\n\n此时打开浏览器发现响应速度并没有受到sleep函数的影响，基于此点，可以在适当的时候使用该函数以提升用户体验!\n\n## 注意事项\nPHP需要运行在fpm模式下才可以使用本函数。。\n22\n#### 说明3-1\n3-1 3-1\n\n#### 说明3-1\n3-2 3-2\n\n```\n<?php\necho 1;\nfastcgi_finish_request();\nsleep(3);\n?>\n```\n\n此时打开浏览器发现响应速度并没有受到sleep函数的影响，基于此点，可以在适当的时候使用该函数以提升用户体验!\n\n## 注意事项\nPHP需要运行在fpm模式下才可以使用本函数。。\n22\n#### 说明3-1\n3-1 3-1\n\n#### 说明3-1\n3-2 3-2\n\n```\n<?php\necho 1;\nfastcgi_finish_request();\nsleep(3);\n?>\n```\n\n此时打开浏览器发现响应速度并没有受到sleep函数的影响，基于此点，可以在适当的时候使用该函数以提升用户体验!\n\n## 注意事项\nPHP需要运行在fpm模式下才可以使用本函数。。\n22\n\n', '众所周知，PHP不使用多线程扩展的情况下是不支持异步的(不算curl之类)。今天无意中看到一个函数fastcgi_finish_request; 这个方法是PHP5.3+开始提供。 注释写的很清楚，有耗时操作的时候使用该函数可以尽早结束fastcgi处理过程，提高页面响应速度。代码说明 说明1 99', 41, '', 0, 746, 1, 1, 0, 1588252709, 1587389837);
INSERT INTO `bs_article` VALUES (60, '罗强', '测试呀！', '测试呀！', 41, '', 0, 0, 1, 0, 1, 1588252700, 1587389884);
INSERT INTO `bs_article` VALUES (61, 'test2222', 'test', 'not_has_html', 41, '24,18', 0, 0, 1, 0, 1, 1588252691, 1587826913);
INSERT INTO `bs_article` VALUES (62, 'test11', '最近在做基于sphinx的全文搜索引擎，使用PHP进行数据读取，但是服务器使用的PHP版本是PHP7，pecl.php.net中没有提供PHP7的版本。手痒点到source code中看了一下。\n看到源代码中有的headers中有个php7的，点击shortlog进去看了一下，最新更新日期是2017-02-10，挺新的，应该是针对PHP7开发的版本，只不过未发布编译版本，想着linux下的软件有源代码基本都能自行编译。故选择了最新的PHP7快照下载。\n## 开始安装\n```\nwget http://git.php.net/?p=pecl/search_engine/sphinx.git;a=snapshot;h=339e123acb0ce7beb2d9d4f9094d6f8bcf15fb54;sf=tgz\ntar xvfz sphinx-339e123.tar.gz\ncd sphinx-339e123\nphpize\n./configure\nmake && make install\n```\n安装完毕后会在PHP的配置文件目录多出sphinx.ini，在扩展目录多出sphinx.so文件。终端执行\n```\nphpenmod sphinx\n```\n即可启用扩展。\n## 本文服务器环境\nUbuntu16.04 Server + PHP7.0(使用apt安装)。\n最近在做基于sphinx的全文搜索引擎，使用PHP进行数据读取，但是服务器使用的PHP版本是PHP7，pecl.php.net中没有提供PHP7的版本。手痒点到source code中看了一下。\n看到源代码中有的headers中有个php7的，点击shortlog进去看了一下，最新更新日期是2017-02-10，挺新的，应该是针对PHP7开发的版本，只不过未发布编译版本，想着linux下的软件有源代码基本都能自行编译。故选择了最新的PHP7快照下载。\n## 开始安装\n```\nwget http://git.php.net/?p=pecl/search_engine/sphinx.git;a=snapshot;h=339e123acb0ce7beb2d9d4f9094d6f8bcf15fb54;sf=tgz\ntar xvfz sphinx-339e123.tar.gz\ncd sphinx-339e123\nphpize\n./configure\nmake && make install\n```\n安装完毕后会在PHP的配置文件目录多出sphinx.ini，在扩展目录多出sphinx.so文件。终端执行\n```\nphpenmod sphinx\n```\n即可启用扩展。\n## 本文服务器环境\nUbuntu16.04 Server + PHP7.0(使用apt安装)。\n最近在做基于sphinx的全文搜索引擎，使用PHP进行数据读取，但是服务器使用的PHP版本是PHP7，pecl.php.net中没有提供PHP7的版本。手痒点到source code中看了一下。\n看到源代码中有的headers中有个php7的，点击shortlog进去看了一下，最新更新日期是2017-02-10，挺新的，应该是针对PHP7开发的版本，只不过未发布编译版本，想着linux下的软件有源代码基本都能自行编译。故选择了最新的PHP7快照下载。\n## 开始安装\n```\nwget http://git.php.net/?p=pecl/search_engine/sphinx.git;a=snapshot;h=339e123acb0ce7beb2d9d4f9094d6f8bcf15fb54;sf=tgz\ntar xvfz sphinx-339e123.tar.gz\ncd sphinx-339e123\nphpize\n./configure\nmake && make install\n```\n安装完毕后会在PHP的配置文件目录多出sphinx.ini，在扩展目录多出sphinx.so文件。终端执行\n```\nphpenmod sphinx\n```\n即可启用扩展。\n## 本文服务器环境\nUbuntu16.04 Server + PHP7.0(使用apt安装)。\n最近在做基于sphinx的全文搜索引擎，使用PHP进行数据读取，但是服务器使用的PHP版本是PHP7，pecl.php.net中没有提供PHP7的版本。手痒点到source code中看了一下。\n看到源代码中有的headers中有个php7的，点击shortlog进去看了一下，最新更新日期是2017-02-10，挺新的，应该是针对PHP7开发的版本，只不过未发布编译版本，想着linux下的软件有源代码基本都能自行编译。故选择了最新的PHP7快照下载。\n## 开始安装\n```\nwget http://git.php.net/?p=pecl/search_engine/sphinx.git;a=snapshot;h=339e123acb0ce7beb2d9d4f9094d6f8bcf15fb54;sf=tgz\ntar xvfz sphinx-339e123.tar.gz\ncd sphinx-339e123\nphpize\n./configure\nmake && make install\n```\n安装完毕后会在PHP的配置文件目录多出sphinx.ini，在扩展目录多出sphinx.so文件。终端执行\n```\nphpenmod sphinx\n```\n即可启用扩展。\n## 本文服务器环境\nUbuntu16.04 Server + PHP7.0(使用apt安装)。\n最近在做基于sphinx的全文搜索引擎，使用PHP进行数据读取，但是服务器使用的PHP版本是PHP7，pecl.php.net中没有提供PHP7的版本。手痒点到source code中看了一下。\n看到源代码中有的headers中有个php7的，点击shortlog进去看了一下，最新更新日期是2017-02-10，挺新的，应该是针对PHP7开发的版本，只不过未发布编译版本，想着linux下的软件有源代码基本都能自行编译。故选择了最新的PHP7快照下载。\n## 开始安装\n```\nwget http://git.php.net/?p=pecl/search_engine/sphinx.git;a=snapshot;h=339e123acb0ce7beb2d9d4f9094d6f8bcf15fb54;sf=tgz\ntar xvfz sphinx-339e123.tar.gz\ncd sphinx-339e123\nphpize\n./configure\nmake && make install\n```\n安装完毕后会在PHP的配置文件目录多出sphinx.ini，在扩展目录多出sphinx.so文件。终端执行\n```\nphpenmod sphinx\n```\n即可启用扩展。\n## 本文服务器环境\nUbuntu16.04 Server + PHP7.0(使用apt安装)。\n最近在做基于sphinx的全文搜索引擎，使用PHP进行数据读取，但是服务器使用的PHP版本是PHP7，pecl.php.net中没有提供PHP7的版本。手痒点到source code中看了一下。\n看到源代码中有的headers中有个php7的，点击shortlog进去看了一下，最新更新日期是2017-02-10，挺新的，应该是针对PHP7开发的版本，只不过未发布编译版本，想着linux下的软件有源代码基本都能自行编译。故选择了最新的PHP7快照下载。\n## 开始安装\n```\nwget http://git.php.net/?p=pecl/search_engine/sphinx.git;a=snapshot;h=339e123acb0ce7beb2d9d4f9094d6f8bcf15fb54;sf=tgz\ntar xvfz sphinx-339e123.tar.gz\ncd sphinx-339e123\nphpize\n./configure\nmake && make install\n```\n安装完毕后会在PHP的配置文件目录多出sphinx.ini，在扩展目录多出sphinx.so文件。终端执行\n```\nphpenmod sphinx\n```\n即可启用扩展。\n## 本文服务器环境\nUbuntu16.04 Server + PHP7.0(使用apt安装)。4444', '最近在做基于sphinx的全文搜索引擎，使用PHP进行数据读取，但是服务器使用的PHP版本是PHP7，pecl.php.net中没有提供PHP7的版本。手痒点到source code中看了一下。 看到源代码中有的headers中有个php7的，点击shortlog进去看了一下，最新更新日期是2017', 41, '14', 0, 3345, 1, 1, 1, 1588252691, 1588250501);
INSERT INTO `bs_article` VALUES (63, '44', 'rrrrrrewq', 'rrrrrrewq', 41, '24', 0, 9, 1, 1, 1, 1588252691, 1588252635);
COMMIT;

-- ----------------------------
-- Table structure for bs_article_label
-- ----------------------------
DROP TABLE IF EXISTS `bs_article_label`;
CREATE TABLE `bs_article_label` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增主键ID',
  `article_id` int(10) NOT NULL DEFAULT '0' COMMENT '标题ID',
  `label_id` int(10) NOT NULL DEFAULT '0' COMMENT '标签ID',
  `edit_time` int(10) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `idx_article_id` (`article_id`),
  KEY `idx_label_id` (`label_id`)
) ENGINE=InnoDB AUTO_INCREMENT=317 DEFAULT CHARSET=utf8mb4 COMMENT='文章标签关联表';

-- ----------------------------
-- Records of bs_article_label
-- ----------------------------
BEGIN;
INSERT INTO `bs_article_label` VALUES (294, 61, 24, 0, 0);
INSERT INTO `bs_article_label` VALUES (295, 61, 18, 0, 0);
INSERT INTO `bs_article_label` VALUES (301, 62, 14, 0, 0);
INSERT INTO `bs_article_label` VALUES (302, 63, 24, 0, 0);
INSERT INTO `bs_article_label` VALUES (311, 55, 62, 0, 0);
INSERT INTO `bs_article_label` VALUES (312, 55, 58, 0, 0);
INSERT INTO `bs_article_label` VALUES (313, 17, 62, 0, 0);
INSERT INTO `bs_article_label` VALUES (314, 17, 58, 0, 0);
INSERT INTO `bs_article_label` VALUES (315, 58, 62, 0, 0);
INSERT INTO `bs_article_label` VALUES (316, 58, 18, 0, 0);
COMMIT;

-- ----------------------------
-- Table structure for bs_category
-- ----------------------------
DROP TABLE IF EXISTS `bs_category`;
CREATE TABLE `bs_category` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT COMMENT '自增主键ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `pid` smallint(4) NOT NULL DEFAULT '0' COMMENT '父级ID',
  `delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0已删除，1未删除）',
  `edit_time` int(10) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `idx_delete` (`delete`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COMMENT='分类表';

-- ----------------------------
-- Records of bs_category
-- ----------------------------
BEGIN;
INSERT INTO `bs_category` VALUES (24, 'php', 0, 0, 0, 1581216453);
INSERT INTO `bs_category` VALUES (25, 'mysql', 0, 0, 0, 1581216463);
INSERT INTO `bs_category` VALUES (26, 'js', 0, 0, 0, 1581216471);
INSERT INTO `bs_category` VALUES (27, 'linux', 0, 0, 0, 1581216482);
INSERT INTO `bs_category` VALUES (28, 'docker', 0, 0, 1581240395, 1581216493);
INSERT INTO `bs_category` VALUES (29, '框架', 1, 0, 1581221014, 1581219083);
INSERT INTO `bs_category` VALUES (30, 'git', 0, 0, 1581241831, 1581220826);
INSERT INTO `bs_category` VALUES (33, 'doclll', 28, 0, 1581240314, 1581238595);
INSERT INTO `bs_category` VALUES (35, '11', 24, 0, 1581241271, 1581241101);
INSERT INTO `bs_category` VALUES (36, '99', 27, 0, 1581251071, 1581251034);
INSERT INTO `bs_category` VALUES (37, '55', 24, 0, 0, 1581251087);
INSERT INTO `bs_category` VALUES (40, 'react', 0, 0, 0, 1585986725);
INSERT INTO `bs_category` VALUES (41, 'redux', 0, 0, 0, 1586076946);
COMMIT;

-- ----------------------------
-- Table structure for bs_label
-- ----------------------------
DROP TABLE IF EXISTS `bs_label`;
CREATE TABLE `bs_label` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT COMMENT '自增主键ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `size` tinyint(1) NOT NULL DEFAULT '0' COMMENT '显示级别（1～5，1级别最小，2级别次之，…，5级别最大）',
  `delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0未删除，1已删除）\n',
  `edit_time` int(10) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `idx_delete` (`size`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8mb4 COMMENT='标签表';

-- ----------------------------
-- Records of bs_label
-- ----------------------------
BEGIN;
INSERT INTO `bs_label` VALUES (2, 'curl', 4, 0, 1546139865, 1535536073);
INSERT INTO `bs_label` VALUES (3, '设计模式5', 1, 0, 1546139848, 1535537101);
INSERT INTO `bs_label` VALUES (4, 'http', 0, 0, 0, 1535537810);
INSERT INTO `bs_label` VALUES (5, 'tcp', 5, 0, 1546139826, 1535537820);
INSERT INTO `bs_label` VALUES (6, 'fpm', 0, 0, 0, 1535537872);
INSERT INTO `bs_label` VALUES (7, 'cgi', 0, 0, 1535537938, 1535537894);
INSERT INTO `bs_label` VALUES (8, 'session', 4, 0, 1546139875, 1535593126);
INSERT INTO `bs_label` VALUES (9, 'cookie', 0, 0, 0, 1535593137);
INSERT INTO `bs_label` VALUES (10, 'ssh', 0, 0, 0, 1535593151);
INSERT INTO `bs_label` VALUES (11, 'vuejs-1111111111', 0, 0, 1540302924, 1535593168);
INSERT INTO `bs_label` VALUES (12, '设计模式', 0, 0, 0, 1535593196);
INSERT INTO `bs_label` VALUES (13, 'mysql', 0, 0, 0, 1535593221);
INSERT INTO `bs_label` VALUES (14, 'kafka2', 0, 0, 1535610006, 1535593232);
INSERT INTO `bs_label` VALUES (15, 'lua', 0, 0, 0, 1535593277);
INSERT INTO `bs_label` VALUES (16, 'ggg', 0, 0, 0, 1535708594);
INSERT INTO `bs_label` VALUES (17, '55', 1, 0, 1538188823, 1537585211);
INSERT INTO `bs_label` VALUES (18, 'sphinx', 1, 0, 1538188823, 1537685515);
INSERT INTO `bs_label` VALUES (19, 'label-11', 0, 0, 0, 1540301737);
INSERT INTO `bs_label` VALUES (20, 'label-22', 0, 0, 0, 1540301745);
INSERT INTO `bs_label` VALUES (21, 'label-33', 0, 0, 0, 1540301753);
INSERT INTO `bs_label` VALUES (22, 'uu', 0, 0, 1546013686, 1545574435);
INSERT INTO `bs_label` VALUES (24, 'gt ', 0, 0, 1546017589, 1546014273);
COMMIT;

-- ----------------------------
-- Table structure for bs_menu
-- ----------------------------
DROP TABLE IF EXISTS `bs_menu`;
CREATE TABLE `bs_menu` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增主键ID',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '菜单名',
  `sort` smallint(6) NOT NULL DEFAULT '0' COMMENT '排序权重',
  `pid` int(10) NOT NULL DEFAULT '0' COMMENT '父ID',
  `delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0未删除，1已删除）',
  `edit_time` int(10) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `idx_pid` (`pid`),
  KEY `idx_delete` (`delete`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COMMENT='导航菜单表';

-- ----------------------------
-- Records of bs_menu
-- ----------------------------
BEGIN;
INSERT INTO `bs_menu` VALUES (26, '文章管理', 1, 0, 0, 0, 1572535046);
INSERT INTO `bs_menu` VALUES (27, '标签管理', 1, 0, 1, 1572535349, 1572535234);
INSERT INTO `bs_menu` VALUES (28, '分类管理', 2, 0, 0, 0, 1572535248);
INSERT INTO `bs_menu` VALUES (29, '账号管理', 4, 0, 0, 0, 1572535268);
INSERT INTO `bs_menu` VALUES (30, '日志管理', 5, 0, 0, 0, 1572535281);
INSERT INTO `bs_menu` VALUES (31, '系统设置', 6, 0, 0, 0, 1572535295);
INSERT INTO `bs_menu` VALUES (32, '标签', 1, 27, 0, 0, 1572535324);
INSERT INTO `bs_menu` VALUES (33, '原创文章', 1, 26, 0, 0, 1572775957);
INSERT INTO `bs_menu` VALUES (34, '转载文章', 4, 26, 0, 0, 1572775975);
INSERT INTO `bs_menu` VALUES (35, '开源项目', 1, 26, 0, 1582083984, 1572775986);
INSERT INTO `bs_menu` VALUES (36, '个人简介', 2, 26, 0, 0, 1572775997);
INSERT INTO `bs_menu` VALUES (37, '登录日志', 1, 30, 0, 0, 1572871915);
INSERT INTO `bs_menu` VALUES (38, '操作日志', 1, 30, 0, 0, 1572871931);
INSERT INTO `bs_menu` VALUES (39, '导航菜单', 1, 31, 0, 0, 1572871948);
INSERT INTO `bs_menu` VALUES (40, '节点管理', 1, 31, 0, 1572871992, 1572871966);
INSERT INTO `bs_menu` VALUES (41, '标签管理', 1, 0, 1, 1572872055, 1572872037);
INSERT INTO `bs_menu` VALUES (42, '标签管理', 3, 0, 0, 0, 1572872066);
INSERT INTO `bs_menu` VALUES (43, '访问日志', 1, 30, 1, 1582015590, 1582015402);
COMMIT;

-- ----------------------------
-- Table structure for bs_meta_data
-- ----------------------------
DROP TABLE IF EXISTS `bs_meta_data`;
CREATE TABLE `bs_meta_data` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增主键ID',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '数据类型（1个人简介）',
  `json_data` varchar(256) NOT NULL DEFAULT '' COMMENT 'json格式数据',
  `text_data` text COMMENT 'text文本数据',
  `delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0未删除，1已删除）',
  `edit_time` int(10) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `idx_type` (`type`),
  KEY `idx_delete` (`delete`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COMMENT='元数据表';

-- ----------------------------
-- Records of bs_meta_data
-- ----------------------------
BEGIN;
INSERT INTO `bs_meta_data` VALUES (3, 2, '', '\'', 0, 0, 1570236971);
INSERT INTO `bs_meta_data` VALUES (4, 3, '', '# 个人简介2\n罗强<br/>\nQQ：2807884436<br/>\nEmail: luoqiang314@gmail.com<br/>\n喜欢学习，喜欢实践\n# 开发语言\n* javascript\n* php\n* golang\n\n\n# 技术栈\n## 1.服务端\n* PHP：ThinkPHP5\n* NodeJs: Koa/socket.io\n* Golang: Beego/http\n\n## 2.前端\n* Javascript: Vue/React\n\n## 3.数据库\n* Mysql\n* Redis\n* MongoDB\n\n## 4.操作系统\n* CentOS\n* Ubuntu\n# 个人简介2\n罗强<br/>\nQQ：2807884436<br/>\nEmail: luoqiang314@gmail.com<br/>\n喜欢学习，喜欢实践\n# 开发语言\n* javascript\n* php\n* golang\n\n\n# 技术栈\n## 1.服务端\n* PHP：ThinkPHP5\n* NodeJs: Koa/socket.io\n* Golang: Beego/http\n\n## 2.前端\n* Javascript: Vue/React\n\n## 3.数据库\n* Mysql\n* Redis\n* MongoDB\n\n## 4.操作系统\n* CentOS\n* Ubuntu\n', 1, 1570238624, 1570237145);
INSERT INTO `bs_meta_data` VALUES (5, 1, '', '# 个人简介\n罗强<br/>\nQQ：2807884436<br/>\nEmail: luoqiang314@gmail.com<br/>\n喜欢学习，喜欢实践\n# 开发语言\n* javascript\n* php\n* golang\n\n\n# 技术栈\n## 1.服务端\n* PHP：ThinkPHP5\n* NodeJs: Koa/socket.io\n* Golang: Beego/http\n\n## 2.前端\n* Javascript: Vue/React\n\n## 3.数据库\n* Mysql\n* Redis\n* MongoDB\n\n## 4.操作系统\n* CentOS\n* Ubuntu\n', 1, 1581161194, 1570266375);
INSERT INTO `bs_meta_data` VALUES (6, 11, '22', '# 个人简介2\n罗强<br/>\nQQ：2807884436<br/>\nEmail: luoqiang314@gmail.com<br/>\n喜欢学习，喜欢实践\n# 开发语言\n* javascript\n* php\n* golang\n\n\n# 技术栈\n## 1.服务端\n* PHP：ThinkPHP5\n* NodeJs: Koa/socket.io\n* Golang: Beego/http\n\n## 2.前端\n* Javascript: Vue/React\n\n## 3.数据库\n* Mysql\n* Redis\n* MongoDB\n\n## 4.操作系统\n* CentOS\n* Ubuntu\n', 0, 1570269377, 1570266375);
INSERT INTO `bs_meta_data` VALUES (7, 1, '', '罗强2223333333333111', 1, 1570272440, 1570271985);
INSERT INTO `bs_meta_data` VALUES (8, 1, '', '2222', 1, 1570272734, 1570272447);
INSERT INTO `bs_meta_data` VALUES (9, 1, '', '11', 1, 1581161872, 1581161272);
INSERT INTO `bs_meta_data` VALUES (10, 1, '', '8888', 1, 1581211838, 1581161875);
INSERT INTO `bs_meta_data` VALUES (11, 1, '', '66', 1, 1581212065, 1581212008);
INSERT INTO `bs_meta_data` VALUES (12, 1, '', '1111155', 1, 1581212912, 1581212464);
INSERT INTO `bs_meta_data` VALUES (13, 1, '', '54俄3', 1, 1581213080, 1581213008);
INSERT INTO `bs_meta_data` VALUES (14, 1, '', '555588', 1, 1581213097, 1581213087);
INSERT INTO `bs_meta_data` VALUES (15, 1, '', '777\n# 1 罗强你好呀\n\n# 2 王琼你好呀', 1, 1581213167, 1581213159);
INSERT INTO `bs_meta_data` VALUES (16, 1, '', '人人人人', 1, 1581213238, 1581213231);
INSERT INTO `bs_meta_data` VALUES (17, 1, '', '# 个人简介\n罗强<br/>\nQQ：2807884436<br/>\nEmail: luoqiang314@gmail.com<br/>\n喜欢学习，喜欢实践\n# 开发语言\n* javascript\n* php\n* golang\n\n\n# 技术栈\n## 1.服务端\n* PHP：ThinkPHP5\n* NodeJs: Koa/socket.io\n* Golang: Beego/http\n\n## 2.前端\n* Javascript: Vue/React\n\n## 3.数据库\n* Mysql\n* Redis\n* MongoDB\n\n## 4.操作系统\n* CentOS\n* Ubuntu\n', 0, 1582373971, 1581213569);
COMMIT;

-- ----------------------------
-- Table structure for bs_node
-- ----------------------------
DROP TABLE IF EXISTS `bs_node`;
CREATE TABLE `bs_node` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增主键ID',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '菜单名',
  `node` varchar(32) NOT NULL DEFAULT '' COMMENT '节点',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态（0禁用，1正常）',
  `menu` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否菜单（0否，1正常）',
  `menu_id` int(10) NOT NULL DEFAULT '0' COMMENT '菜单ID',
  `group_id` int(10) NOT NULL DEFAULT '0' COMMENT '组（即节点所属菜单ID）',
  `pid` int(10) NOT NULL DEFAULT '0' COMMENT '父ID',
  `delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0未删除，1已删除）',
  `edit_time` int(10) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_group` (`group_id`),
  KEY `idx_pid` (`pid`),
  KEY `idx_delete` (`delete`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COMMENT='权限节点表';

-- ----------------------------
-- Records of bs_node
-- ----------------------------
BEGIN;
INSERT INTO `bs_node` VALUES (23, '原创文章', 'originArticle', 1, 1, 33, 26, 0, 0, 1582271611, 1573022567);
INSERT INTO `bs_node` VALUES (24, '转载文章', 'transshipmentArticle', 1, 1, 34, 26, 0, 0, 0, 1573022783);
INSERT INTO `bs_node` VALUES (25, '开源项目', 'openSourceProject', 1, 1, 35, 26, 0, 0, 0, 1573022832);
INSERT INTO `bs_node` VALUES (26, '个人简介', 'instruction', 1, 1, 36, 26, 0, 0, 0, 1573023158);
INSERT INTO `bs_node` VALUES (27, '分类', 'category', 1, 0, 0, 28, 0, 0, 1582083744, 1573023264);
INSERT INTO `bs_node` VALUES (28, '标签', 'label', 1, 0, 0, 42, 0, 0, 1582271700, 1573023412);
INSERT INTO `bs_node` VALUES (29, '用户', 'admin', 1, 0, 0, 29, 0, 0, 1582268720, 1573023521);
INSERT INTO `bs_node` VALUES (30, '角色', 'role', 1, 0, 0, 29, 0, 0, 0, 1573023612);
INSERT INTO `bs_node` VALUES (31, '登录日志', 'loginLog', 1, 1, 37, 30, 0, 1, 1574866547, 1573023645);
INSERT INTO `bs_node` VALUES (32, '操作日志', 'operate', 1, 1, 38, 30, 0, 1, 1574866547, 1573023767);
INSERT INTO `bs_node` VALUES (33, '导航菜单', 'menu', 1, 1, 39, 31, 0, 0, 1582084840, 1573024138);
INSERT INTO `bs_node` VALUES (34, '节点管理', 'node', 1, 1, 40, 31, 0, 1, 1573034121, 1573024305);
INSERT INTO `bs_node` VALUES (35, '添加', 'add', 1, 0, 0, -1, 34, 0, 0, 1573026307);
INSERT INTO `bs_node` VALUES (36, '编辑', 'edit', 1, 0, 0, -1, 34, 0, 0, 1573027288);
INSERT INTO `bs_node` VALUES (37, '查询', 'get', 1, 0, 0, -1, 34, 0, 0, 1573027322);
INSERT INTO `bs_node` VALUES (38, '删除', 'delete', 1, 0, 0, -1, 34, 0, 0, 1573029419);
INSERT INTO `bs_node` VALUES (39, '查询', 'get', 0, 0, 0, -1, 29, 0, 0, 1573033370);
INSERT INTO `bs_node` VALUES (40, '添加', 'add', 1, 0, 0, -1, 29, 0, 1582268730, 1573033415);
INSERT INTO `bs_node` VALUES (41, '节点管理', 'node', 1, 1, 40, 31, 0, 0, 1582083815, 1573045203);
INSERT INTO `bs_node` VALUES (42, '查询', 'get', 0, 0, 0, -1, 41, 0, 1582082919, 1573045299);
INSERT INTO `bs_node` VALUES (43, '删除', 'delete', 0, 0, 0, -1, 41, 0, 1582083770, 1573045322);
INSERT INTO `bs_node` VALUES (44, '查询', 'get', 1, 0, 0, -1, 33, 0, 1582084852, 1573046775);
INSERT INTO `bs_node` VALUES (45, '编辑', 'edit', 1, 0, 0, -1, 33, 0, 1582084858, 1573046793);
INSERT INTO `bs_node` VALUES (46, '查询', 'get', 1, 0, 0, -1, 32, 0, 0, 1573046812);
INSERT INTO `bs_node` VALUES (47, '编辑', 'edit', 1, 0, 0, -1, 31, 0, 0, 1573046833);
INSERT INTO `bs_node` VALUES (48, '删除', 'delete', 1, 0, 0, -1, 31, 0, 0, 1573046859);
INSERT INTO `bs_node` VALUES (49, '查询', 'get', 1, 0, 0, -1, 30, 0, 0, 1573046881);
INSERT INTO `bs_node` VALUES (50, '查询', 'get', 0, 0, 0, -1, 28, 0, 0, 1573046911);
INSERT INTO `bs_node` VALUES (51, '删除', 'delete', 0, 0, 0, -1, 27, 0, 1582083291, 1573046943);
INSERT INTO `bs_node` VALUES (52, '查询', 'get', 1, 0, 0, -1, 26, 0, 0, 1573046958);
INSERT INTO `bs_node` VALUES (53, '删除', 'delete', 1, 0, 0, -1, 25, 0, 0, 1573046981);
INSERT INTO `bs_node` VALUES (54, '查询', 'get', 1, 0, 0, -1, 24, 0, 0, 1573047086);
INSERT INTO `bs_node` VALUES (55, '编辑', 'edit', 0, 0, 0, -1, 23, 0, 0, 1573047115);
INSERT INTO `bs_node` VALUES (56, '编辑', 'edit', 0, 0, 0, -1, 41, 0, 1573049243, 1573049229);
INSERT INTO `bs_node` VALUES (57, '添加', 'add', 1, 0, 0, -1, 23, 0, 1582271649, 1574069475);
INSERT INTO `bs_node` VALUES (58, '删除', 'delete', 0, 0, 0, -1, 23, 0, 0, 1574069524);
INSERT INTO `bs_node` VALUES (59, '编辑', 'edit', 1, 0, 0, -1, 26, 0, 0, 1574087274);
INSERT INTO `bs_node` VALUES (60, '导出', 'export', 0, 0, 0, -1, 23, 0, 1582271551, 1574163775);
INSERT INTO `bs_node` VALUES (61, '导出', 'export', 1, 0, 0, -1, 30, 0, 0, 1574866013);
INSERT INTO `bs_node` VALUES (62, '登录日志', 'loginLog', 1, 1, 37, 30, 0, 1, 1582032307, 1574866683);
INSERT INTO `bs_node` VALUES (63, '添加', 'add', 0, 0, 0, -1, 41, 0, 1582083761, 1574866750);
INSERT INTO `bs_node` VALUES (64, '查询', 'get', 1, 0, 0, -1, 62, 0, 0, 1574866790);
INSERT INTO `bs_node` VALUES (65, '导出', 'export', 1, 0, 0, -1, 62, 0, 0, 1574866887);
INSERT INTO `bs_node` VALUES (66, '编辑', 'edit', 0, 0, 0, -1, 27, 0, 0, 1582031115);
INSERT INTO `bs_node` VALUES (67, '导出', 'export', 0, 0, 0, -1, 27, 1, 1582032461, 1582031144);
INSERT INTO `bs_node` VALUES (68, '标签99', '99', 1, 0, 0, 42, 0, 1, 1582031958, 1582031799);
INSERT INTO `bs_node` VALUES (69, '查询1', 'get', 1, 0, 0, -1, 62, 1, 1582032307, 1582032108);
COMMIT;

-- ----------------------------
-- Table structure for bs_open_source_project
-- ----------------------------
DROP TABLE IF EXISTS `bs_open_source_project`;
CREATE TABLE `bs_open_source_project` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增主键ID',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '项目名称',
  `level` tinyint(2) NOT NULL DEFAULT '1' COMMENT '项目级别（1系统，2插件，3组件）',
  `url` varchar(64) NOT NULL DEFAULT '' COMMENT '项目地址',
  `version` char(8) NOT NULL DEFAULT '' COMMENT '项目版本',
  `introduction` tinytext COMMENT '项目简介',
  `release` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否发布（0未发布，1已发布）',
  `delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0已删除，1未删除）',
  `edit_time` int(10) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`),
  KEY `idx_release` (`release`),
  KEY `idx_delete` (`delete`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COMMENT='开源项目表';

-- ----------------------------
-- Records of bs_open_source_project
-- ----------------------------
BEGIN;
INSERT INTO `bs_open_source_project` VALUES (1, '博客后台', 1, 'www.baidu.com', 'V_2.2.3', NULL, 1, 0, 1584973913, 1568364460);
INSERT INTO `bs_open_source_project` VALUES (2, '博客后台', 1, 'www.baidu.com', 'V_2.2.3', NULL, 1, 1, 1568366351, 1568364557);
INSERT INTO `bs_open_source_project` VALUES (3, '博客前台前端', 1, 'www.baid77777777777777777777777u.com', 'V_2.2.3', '1111222  333  rrr r r', 1, 0, 1584973912, 1568365420);
INSERT INTO `bs_open_source_project` VALUES (4, '11', 3, 'www.baidu.com', 'V_3.2.1', NULL, 1, 1, 1568515730, 1568515027);
INSERT INTO `bs_open_source_project` VALUES (5, '11', 2, 'www.baidu.com', 'V_3.2.1', NULL, 0, 1, 1568521113, 1568521110);
INSERT INTO `bs_open_source_project` VALUES (6, '11', 1, 'www.baidu.com', 'V_3.2.1', NULL, 0, 1, 1568522148, 1568522144);
INSERT INTO `bs_open_source_project` VALUES (7, '11', 1, 'www.bai789噢4567834567895画婷189du.com', 'V_3.2.1', '123qw22233 333 3333 33 333 3333333333333333333333\n444444444\n人人人人人人人人\n肉肉肉rrr\n大的点点滴滴\neeeee', 1, 0, 1584973910, 1568556120);
INSERT INTO `bs_open_source_project` VALUES (8, '博客后台前端', 1, 'www.baidu.com', 'V_3.2.1', 'ccs', 0, 0, 0, 1581140625);
COMMIT;

-- ----------------------------
-- Table structure for bs_osp_update_log
-- ----------------------------
DROP TABLE IF EXISTS `bs_osp_update_log`;
CREATE TABLE `bs_osp_update_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增主键ID',
  `osp_id` int(10) NOT NULL COMMENT '开源项目表',
  `version` char(8) NOT NULL DEFAULT '' COMMENT '版本号',
  `content` varchar(256) NOT NULL DEFAULT '' COMMENT '日志内容',
  `delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0已删除，1未删除）',
  `edit_time` int(10) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COMMENT='开源项目更新日志表';

-- ----------------------------
-- Records of bs_osp_update_log
-- ----------------------------
BEGIN;
INSERT INTO `bs_osp_update_log` VALUES (42, 8, 'V_3.2.1', '7777', 0, 1581508663, 1581350400);
INSERT INTO `bs_osp_update_log` VALUES (45, 8, 'V_3.2.2', '1111122', 0, 1581508687, 1582560000);
COMMIT;

-- ----------------------------
-- Table structure for bs_role
-- ----------------------------
DROP TABLE IF EXISTS `bs_role`;
CREATE TABLE `bs_role` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增主键ID',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '角色名',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态（0禁用，1正常）',
  `delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0未删除，1已删除）',
  `edit_time` int(10) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COMMENT='角色表';

-- ----------------------------
-- Records of bs_role
-- ----------------------------
BEGIN;
INSERT INTO `bs_role` VALUES (7, 'j管理员', 1, 1, 1574088320, 1573398303);
INSERT INTO `bs_role` VALUES (15, '管理员2', 1, 1, 1573557798, 1573398923);
INSERT INTO `bs_role` VALUES (16, 'cj管理员', 1, 1, 1574088972, 1573399336);
INSERT INTO `bs_role` VALUES (17, 'yyyy', 1, 1, 1574088972, 1573862903);
INSERT INTO `bs_role` VALUES (18, '文章管理', 1, 0, 1574865892, 1574087310);
INSERT INTO `bs_role` VALUES (19, '普00004444', 1, 1, 1574865000, 1574163680);
INSERT INTO `bs_role` VALUES (20, '66666666666666666666666666666', 0, 1, 1581820201, 1574163815);
INSERT INTO `bs_role` VALUES (21, 'uuuu', 0, 0, 1577881273, 1574260870);
INSERT INTO `bs_role` VALUES (22, '11', 0, 0, 1577881273, 1574518214);
INSERT INTO `bs_role` VALUES (23, '0099', 1, 0, 1581833066, 1574609003);
INSERT INTO `bs_role` VALUES (24, 'ggggg_1', 1, 1, 1574864500, 1574688090);
INSERT INTO `bs_role` VALUES (25, '448', 1, 0, 1587784769, 1574866253);
INSERT INTO `bs_role` VALUES (26, 'uuu0089', 1, 1, 1581818755, 1578194824);
INSERT INTO `bs_role` VALUES (27, '78', 1, 1, 1581832080, 1581832020);
INSERT INTO `bs_role` VALUES (28, '47777', 1, 0, 0, 1581834048);
INSERT INTO `bs_role` VALUES (29, '66', 1, 0, 0, 1581834061);
INSERT INTO `bs_role` VALUES (30, '667', 1, 0, 1581837339, 1581835758);
INSERT INTO `bs_role` VALUES (31, '4499', 1, 0, 1582032397, 1581837569);
INSERT INTO `bs_role` VALUES (32, '00', 1, 1, 1582031886, 1582031876);
COMMIT;

-- ----------------------------
-- Table structure for bs_role_node
-- ----------------------------
DROP TABLE IF EXISTS `bs_role_node`;
CREATE TABLE `bs_role_node` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增主键ID',
  `role_id` int(10) NOT NULL DEFAULT '0' COMMENT '角色ID',
  `node_id` int(10) NOT NULL DEFAULT '0' COMMENT '节点ID',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_role_id` (`role_id`),
  KEY `idx_node_id` (`node_id`)
) ENGINE=InnoDB AUTO_INCREMENT=465 DEFAULT CHARSET=utf8mb4 COMMENT='角色节点关联表';

-- ----------------------------
-- Records of bs_role_node
-- ----------------------------
BEGIN;
INSERT INTO `bs_role_node` VALUES (13, 15, 1);
INSERT INTO `bs_role_node` VALUES (14, 15, 3);
INSERT INTO `bs_role_node` VALUES (15, 15, 5);
INSERT INTO `bs_role_node` VALUES (16, 15, 6);
INSERT INTO `bs_role_node` VALUES (17, 16, 1);
INSERT INTO `bs_role_node` VALUES (18, 16, 3);
INSERT INTO `bs_role_node` VALUES (19, 16, 5);
INSERT INTO `bs_role_node` VALUES (20, 16, 6);
INSERT INTO `bs_role_node` VALUES (36, 17, -26);
INSERT INTO `bs_role_node` VALUES (37, 17, 23);
INSERT INTO `bs_role_node` VALUES (38, 17, 55);
INSERT INTO `bs_role_node` VALUES (39, 17, 57);
INSERT INTO `bs_role_node` VALUES (40, 17, 58);
INSERT INTO `bs_role_node` VALUES (41, 17, 24);
INSERT INTO `bs_role_node` VALUES (42, 17, 54);
INSERT INTO `bs_role_node` VALUES (81, 7, -42);
INSERT INTO `bs_role_node` VALUES (82, 7, 28);
INSERT INTO `bs_role_node` VALUES (83, 7, 50);
INSERT INTO `bs_role_node` VALUES (117, 21, -31);
INSERT INTO `bs_role_node` VALUES (118, 21, 33);
INSERT INTO `bs_role_node` VALUES (119, 21, 44);
INSERT INTO `bs_role_node` VALUES (132, 22, -42);
INSERT INTO `bs_role_node` VALUES (133, 22, 28);
INSERT INTO `bs_role_node` VALUES (134, 22, 50);
INSERT INTO `bs_role_node` VALUES (152, 19, -42);
INSERT INTO `bs_role_node` VALUES (153, 19, 28);
INSERT INTO `bs_role_node` VALUES (154, 19, 50);
INSERT INTO `bs_role_node` VALUES (170, 24, -26);
INSERT INTO `bs_role_node` VALUES (171, 24, 24);
INSERT INTO `bs_role_node` VALUES (172, 24, 54);
INSERT INTO `bs_role_node` VALUES (173, 24, 25);
INSERT INTO `bs_role_node` VALUES (174, 24, 53);
INSERT INTO `bs_role_node` VALUES (297, 18, -42);
INSERT INTO `bs_role_node` VALUES (298, 18, 28);
INSERT INTO `bs_role_node` VALUES (299, 18, 50);
INSERT INTO `bs_role_node` VALUES (300, 18, -28);
INSERT INTO `bs_role_node` VALUES (301, 18, 27);
INSERT INTO `bs_role_node` VALUES (302, 18, 51);
INSERT INTO `bs_role_node` VALUES (303, 18, -29);
INSERT INTO `bs_role_node` VALUES (304, 18, 29);
INSERT INTO `bs_role_node` VALUES (305, 18, 39);
INSERT INTO `bs_role_node` VALUES (306, 18, 40);
INSERT INTO `bs_role_node` VALUES (307, 18, 30);
INSERT INTO `bs_role_node` VALUES (308, 18, 49);
INSERT INTO `bs_role_node` VALUES (309, 18, -30);
INSERT INTO `bs_role_node` VALUES (310, 18, 31);
INSERT INTO `bs_role_node` VALUES (311, 18, 47);
INSERT INTO `bs_role_node` VALUES (312, 18, 48);
INSERT INTO `bs_role_node` VALUES (313, 18, 32);
INSERT INTO `bs_role_node` VALUES (314, 18, 46);
INSERT INTO `bs_role_node` VALUES (315, 18, -31);
INSERT INTO `bs_role_node` VALUES (316, 18, 33);
INSERT INTO `bs_role_node` VALUES (317, 18, 44);
INSERT INTO `bs_role_node` VALUES (318, 18, 45);
INSERT INTO `bs_role_node` VALUES (319, 18, 41);
INSERT INTO `bs_role_node` VALUES (320, 18, 42);
INSERT INTO `bs_role_node` VALUES (321, 18, 43);
INSERT INTO `bs_role_node` VALUES (322, 18, 56);
INSERT INTO `bs_role_node` VALUES (348, 23, -26);
INSERT INTO `bs_role_node` VALUES (349, 23, 23);
INSERT INTO `bs_role_node` VALUES (350, 23, 55);
INSERT INTO `bs_role_node` VALUES (351, 23, 57);
INSERT INTO `bs_role_node` VALUES (352, 23, 58);
INSERT INTO `bs_role_node` VALUES (353, 23, 60);
INSERT INTO `bs_role_node` VALUES (354, 23, 24);
INSERT INTO `bs_role_node` VALUES (355, 23, 54);
INSERT INTO `bs_role_node` VALUES (356, 23, 25);
INSERT INTO `bs_role_node` VALUES (357, 23, 53);
INSERT INTO `bs_role_node` VALUES (358, 23, 26);
INSERT INTO `bs_role_node` VALUES (359, 23, 52);
INSERT INTO `bs_role_node` VALUES (360, 23, 59);
INSERT INTO `bs_role_node` VALUES (361, 23, -42);
INSERT INTO `bs_role_node` VALUES (362, 23, 28);
INSERT INTO `bs_role_node` VALUES (363, 23, 50);
INSERT INTO `bs_role_node` VALUES (364, 23, -28);
INSERT INTO `bs_role_node` VALUES (365, 23, 27);
INSERT INTO `bs_role_node` VALUES (366, 23, 51);
INSERT INTO `bs_role_node` VALUES (370, 26, -28);
INSERT INTO `bs_role_node` VALUES (371, 26, 27);
INSERT INTO `bs_role_node` VALUES (372, 26, 51);
INSERT INTO `bs_role_node` VALUES (373, 26, -26);
INSERT INTO `bs_role_node` VALUES (374, 26, 25);
INSERT INTO `bs_role_node` VALUES (375, 26, 53);
INSERT INTO `bs_role_node` VALUES (376, 20, -26);
INSERT INTO `bs_role_node` VALUES (377, 20, 23);
INSERT INTO `bs_role_node` VALUES (378, 20, 60);
INSERT INTO `bs_role_node` VALUES (379, 20, 24);
INSERT INTO `bs_role_node` VALUES (380, 20, 54);
INSERT INTO `bs_role_node` VALUES (381, 27, -28);
INSERT INTO `bs_role_node` VALUES (382, 27, 27);
INSERT INTO `bs_role_node` VALUES (383, 27, 51);
INSERT INTO `bs_role_node` VALUES (388, 25, -26);
INSERT INTO `bs_role_node` VALUES (389, 25, 23);
INSERT INTO `bs_role_node` VALUES (390, 25, 55);
INSERT INTO `bs_role_node` VALUES (391, 25, 24);
INSERT INTO `bs_role_node` VALUES (392, 28, -28);
INSERT INTO `bs_role_node` VALUES (393, 28, 27);
INSERT INTO `bs_role_node` VALUES (394, 29, -28);
INSERT INTO `bs_role_node` VALUES (395, 29, 27);
INSERT INTO `bs_role_node` VALUES (429, 30, -28);
INSERT INTO `bs_role_node` VALUES (430, 30, 27);
INSERT INTO `bs_role_node` VALUES (431, 30, 51);
INSERT INTO `bs_role_node` VALUES (432, 30, -26);
INSERT INTO `bs_role_node` VALUES (433, 30, 23);
INSERT INTO `bs_role_node` VALUES (434, 30, 55);
INSERT INTO `bs_role_node` VALUES (435, 30, 24);
INSERT INTO `bs_role_node` VALUES (436, 30, 54);
INSERT INTO `bs_role_node` VALUES (437, 30, 25);
INSERT INTO `bs_role_node` VALUES (438, 30, 53);
INSERT INTO `bs_role_node` VALUES (439, 30, 26);
INSERT INTO `bs_role_node` VALUES (440, 30, 52);
INSERT INTO `bs_role_node` VALUES (441, 30, 59);
INSERT INTO `bs_role_node` VALUES (442, 30, -31);
INSERT INTO `bs_role_node` VALUES (443, 30, 33);
INSERT INTO `bs_role_node` VALUES (444, 30, 44);
INSERT INTO `bs_role_node` VALUES (445, 30, 45);
INSERT INTO `bs_role_node` VALUES (449, 32, -26);
INSERT INTO `bs_role_node` VALUES (450, 32, 23);
INSERT INTO `bs_role_node` VALUES (451, 32, 24);
INSERT INTO `bs_role_node` VALUES (452, 32, 54);
INSERT INTO `bs_role_node` VALUES (453, 32, 25);
INSERT INTO `bs_role_node` VALUES (454, 32, 53);
INSERT INTO `bs_role_node` VALUES (455, 32, 26);
INSERT INTO `bs_role_node` VALUES (456, 32, -42);
INSERT INTO `bs_role_node` VALUES (457, 32, 68);
INSERT INTO `bs_role_node` VALUES (458, 31, -28);
INSERT INTO `bs_role_node` VALUES (459, 31, 27);
INSERT INTO `bs_role_node` VALUES (460, 31, 66);
INSERT INTO `bs_role_node` VALUES (461, 31, 67);
INSERT INTO `bs_role_node` VALUES (462, 31, -42);
INSERT INTO `bs_role_node` VALUES (463, 31, 28);
INSERT INTO `bs_role_node` VALUES (464, 31, 50);
COMMIT;

-- ----------------------------
-- Table structure for bs_transshipment_article
-- ----------------------------
DROP TABLE IF EXISTS `bs_transshipment_article`;
CREATE TABLE `bs_transshipment_article` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增主键ID',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '标题',
  `author` varchar(50) NOT NULL DEFAULT '' COMMENT '作者',
  `link` varchar(150) NOT NULL DEFAULT '' COMMENT '原文链接',
  `transshipment_article_content_id` int(10) NOT NULL DEFAULT '0' COMMENT '转载文章内容id',
  `release` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否发布（0未发布，1已发布）',
  `delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0已删除，1未删除）',
  `edit_time` int(10) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `idx_title` (`title`),
  KEY `idx_transshipment_article_content_id` (`transshipment_article_content_id`),
  KEY `idx_release` (`release`),
  KEY `idx_delete` (`delete`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COMMENT='转载文章表';

-- ----------------------------
-- Records of bs_transshipment_article
-- ----------------------------
BEGIN;
INSERT INTO `bs_transshipment_article` VALUES (1, 'react生命周期浅析', 'luoqiang33334444444', 'www.bigswitch888888834567893456789314.cn', 2, 1, 0, 1581045490, 1566115777);
INSERT INTO `bs_transshipment_article` VALUES (2, 'php设计模式入门php设计ghjkiuytgdcvbhdcvbjytrdcv', 'pick', 'www.bigswitch.cn', 3, 1, 0, 1581045293, 1566398650);
INSERT INTO `bs_transshipment_article` VALUES (3, '4', '7', 'yy', 4, 1, 1, 1566400760, 1566400695);
INSERT INTO `bs_transshipment_article` VALUES (4, 'PHP7编译sphinx扩展', '罗强', 'www.com', 5, 1, 0, 1581130081, 1566613912);
INSERT INTO `bs_transshipment_article` VALUES (5, '1', '1', '1', 6, 1, 1, 1566613970, 1566613939);
INSERT INTO `bs_transshipment_article` VALUES (6, '22', '22', '22', 7, 0, 1, 1566613970, 1566613962);
INSERT INTO `bs_transshipment_article` VALUES (7, '2w', '罗爸爸', '22', 8, 1, 1, 1581046894, 1566614308);
COMMIT;

-- ----------------------------
-- Table structure for bs_transshipment_article_content
-- ----------------------------
DROP TABLE IF EXISTS `bs_transshipment_article_content`;
CREATE TABLE `bs_transshipment_article_content` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增主键ID',
  `content_md` text COMMENT '内容（md格式）',
  `edit_time` int(10) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COMMENT='转载文章内容表';

-- ----------------------------
-- Records of bs_transshipment_article_content
-- ----------------------------
BEGIN;
INSERT INTO `bs_transshipment_article_content` VALUES (2, ' 生命周期--生命周期--生命周期--生命周期333333344444444', 1581045490, 1566115777);
INSERT INTO `bs_transshipment_article_content` VALUES (3, '888888\n#### 777777', 1581045293, 1566398650);
INSERT INTO `bs_transshipment_article_content` VALUES (4, '00', 0, 1566400695);
INSERT INTO `bs_transshipment_article_content` VALUES (5, '最近在做基于sphinx的全文搜索引擎，使用PHP进行数据读取，但是服务器使用的PHP版本是PHP7，pecl.php.net中没有提供PHP7的版本。手痒点到source code中看了一下。\n看到源代码中有的headers中有个php7的，点击shortlog进去看了一下，最新更新日期是2017-02-10，挺新的，应该是针对PHP7开发的版本，只不过未发布编译版本，想着linux下的软件有源代码基本都能自行编译。故选择了最新的PHP7快照下载。\n# 开始安装\n```\nwget http://git.php.net/?p=pecl/search_engine/sphinx.git;a=snapshot;h=339e123acb0ce7beb2d9d4f9094d6f8bcf15fb54;sf=tgz\ntar xvfz sphinx-339e123.tar.gz\ncd sphinx-339e123\nphpize\n./configure\nmake && make install\n```\n安装完毕后会在PHP的配置文件目录多出sphinx.ini，在扩展目录多出sphinx.so文件。终端执行\n```\nphpenmod sphinx\n```\n即可启用扩展。\n## 本文服务器环境\nUbuntu16.04 Server + PHP7.0(使用apt安装)。\n最近在做基于sphinx的全文搜索引擎，使用PHP进行数据读取，但是服务器使用的PHP版本是PHP7，pecl.php.net中没有提供PHP7的版本。手痒点到source code中看了一下。\n看到源代码中有的headers中有个php7的，点击shortlog进去看了一下，最新更新日期是2017-02-10，挺新的，应该是针对PHP7开发的版本，只不过未发布编译版本，想着linux下的软件有源代码基本都能自行编译。故选择了最新的PHP7快照下载。\n## 开始安装\n```\nwget http://git.php.net/?p=pecl/search_engine/sphinx.git;a=snapshot;h=339e123acb0ce7beb2d9d4f9094d6f8bcf15fb54;sf=tgz\ntar xvfz sphinx-339e123.tar.gz\ncd sphinx-339e123\nphpize\n./configure\nmake && make install\n```\n安装完毕后会在PHP的配置文件目录多出sphinx.ini，在扩展目录多出sphinx.so文件。终端执行\n```\nphpenmod sphinx\n```\n即可启用扩展。\n## 本文服务器环境\nUbuntu16.04 Server + PHP7.0(使用apt安装)。\n最近在做基于sphinx的全文搜索引擎，使用PHP进行数据读取，但是服务器使用的PHP版本是PHP7，pecl.php.net中没有提供PHP7的版本。手痒点到source code中看了一下。\n看到源代码中有的headers中有个php7的，点击shortlog进去看了一下，最新更新日期是2017-02-10，挺新的，应该是针对PHP7开发的版本，只不过未发布编译版本，想着linux下的软件有源代码基本都能自行编译。故选择了最新的PHP7快照下载。\n## 开始安装\n```\nwget http://git.php.net/?p=pecl/search_engine/sphinx.git;a=snapshot;h=339e123acb0ce7beb2d9d4f9094d6f8bcf15fb54;sf=tgz\ntar xvfz sphinx-339e123.tar.gz\ncd sphinx-339e123\nphpize\n./configure\nmake && make install\n```\n安装完毕后会在PHP的配置文件目录多出sphinx.ini，在扩展目录多出sphinx.so文件。终端执行\n```\nphpenmod sphinx\n```\n即可启用扩展。\n## 本文服务器环境\nUbuntu16.04 Server + PHP7.0(使用apt安装)。\n最近在做基于sphinx的全文搜索引擎，使用PHP进行数据读取，但是服务器使用的PHP版本是PHP7，pecl.php.net中没有提供PHP7的版本。手痒点到source code中看了一下。\n看到源代码中有的headers中有个php7的，点击shortlog进去看了一下，最新更新日期是2017-02-10，挺新的，应该是针对PHP7开发的版本，只不过未发布编译版本，想着linux下的软件有源代码基本都能自行编译。故选择了最新的PHP7快照下载。\n## 开始安装\n```\nwget http://git.php.net/?p=pecl/search_engine/sphinx.git;a=snapshot;h=339e123acb0ce7beb2d9d4f9094d6f8bcf15fb54;sf=tgz\ntar xvfz sphinx-339e123.tar.gz\ncd sphinx-339e123\nphpize\n./configure\nmake && make install\n```\n安装完毕后会在PHP的配置文件目录多出sphinx.ini，在扩展目录多出sphinx.so文件。终端执行\n```\nphpenmod sphinx\n```\n即可启用扩展。\n## 本文服务器环境\nUbuntu16.04 Server + PHP7.0(使用apt安装)。\n最近在做基于sphinx的全文搜索引擎，使用PHP进行数据读取，但是服务器使用的PHP版本是PHP7，pecl.php.net中没有提供PHP7的版本。手痒点到source code中看了一下。\n看到源代码中有的headers中有个php7的，点击shortlog进去看了一下，最新更新日期是2017-02-10，挺新的，应该是针对PHP7开发的版本，只不过未发布编译版本，想着linux下的软件有源代码基本都能自行编译。故选择了最新的PHP7快照下载。\n## 开始安装\n```\nwget http://git.php.net/?p=pecl/search_engine/sphinx.git;a=snapshot;h=339e123acb0ce7beb2d9d4f9094d6f8bcf15fb54;sf=tgz\ntar xvfz sphinx-339e123.tar.gz\ncd sphinx-339e123\nphpize\n./configure\nmake && make install\n```\n安装完毕后会在PHP的配置文件目录多出sphinx.ini，在扩展目录多出sphinx.so文件。终端执行\n```\nphpenmod sphinx\n```\n即可启用扩展。\n## 本文服务器环境\nUbuntu16.04 Server + PHP7.0(使用apt安装)。\n最近在做基于sphinx的全文搜索引擎，使用PHP进行数据读取，但是服务器使用的PHP版本是PHP7，pecl.php.net中没有提供PHP7的版本。手痒点到source code中看了一下。\n看到源代码中有的headers中有个php7的，点击shortlog进去看了一下，最新更新日期是2017-02-10，挺新的，应该是针对PHP7开发的版本，只不过未发布编译版本，想着linux下的软件有源代码基本都能自行编译。故选择了最新的PHP7快照下载。\n## 开始安装\n```\nwget http://git.php.net/?p=pecl/search_engine/sphinx.git;a=snapshot;h=339e123acb0ce7beb2d9d4f9094d6f8bcf15fb54;sf=tgz\ntar xvfz sphinx-339e123.tar.gz\ncd sphinx-339e123\nphpize\n./configure\nmake && make install\n```\n安装完毕后会在PHP的配置文件目录多出sphinx.ini，在扩展目录多出sphinx.so文件。终端执行\n```\nphpenmod sphinx\n```\n即可启用扩展。\n## 本文服务器环境\nUbuntu16.04 Server + PHP7.0(使用apt安装)。4444', 1581130081, 1566613912);
INSERT INTO `bs_transshipment_article_content` VALUES (6, '# 论高效学习方法\n哥哥哥哥哥哥\nrrrrrrrrr\n\nuuuuuuuuuuuuuu\n', 0, 1566613939);
INSERT INTO `bs_transshipment_article_content` VALUES (7, '# 论高效学习方法\n哥哥哥哥哥哥\nrrrrrrrrr\n\nuuuuuuuuuuuuuu\n', 0, 1566613962);
INSERT INTO `bs_transshipment_article_content` VALUES (8, '33333', 1581045220, 1566614308);
COMMIT;

-- ----------------------------
-- Function structure for getAllChdID
-- ----------------------------
DROP FUNCTION IF EXISTS `getAllChdID`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `getAllChdID`( parentID INT ) RETURNS varchar(255) CHARSET latin1
BEGIN
DECLARE
	allChdIdList VARCHAR ( 255 );
DECLARE
	curChdIdList VARCHAR ( 255 );# 存储所有子类

SET allChdIdList = '$';# 存储当前类的子类

SET curChdIdList = cast( parentID AS CHAR );
WHILE
		curChdIdList IS NOT NULL DO# 将当前类的子类添加到所有子类尾部

		SET allChdIdList = concat( allChdIdList, ',', curChdIdList );# 查询当前子类的所有子类并覆盖掉当前子类
	SELECT
		group_concat( id ) INTO curChdIdList
	FROM
		blog.bs_category
	WHERE
		FIND_IN_SET( pid, curChdIdList ) > 0;

END WHILE;
RETURN allChdIdList;

END;
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
