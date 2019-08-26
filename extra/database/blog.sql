-------------------------------
-- 博客数据表
--
-- 1.用户表             -->   bs_admin
-- 2.文章表             -->   bs_article
-- 3.文章标签中间表      -->   bs_article_label
-- 4.分类表             -->   bs_category
-- 5.标签表             -->   bs_label
-- 6.开源项目表          -->   bs_open_source_project
-- 7.开源项目更新日志表   -->   bs_osp_update_log
-- 8.转载文章表          -->   bs_transshipment_article
-- 9.转载文章内容表       -->   bs_transshipment_article_content

-------------------------------




SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- 1.Table structure for bs_admin
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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COMMENT='后台用户表';

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
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COMMENT='文章表';

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
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COMMENT='文章标签关联表';

-- ----------------------------
-- Table structure for bs_category
-- ----------------------------
DROP TABLE IF EXISTS `bs_category`;
CREATE TABLE `bs_category` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT COMMENT '自增主键ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0已删除，1未删除）',
  `edit_time` int(10) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `idx_delete` (`delete`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COMMENT='分类表';

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
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8mb4 COMMENT='标签表';

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
  `release` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否发布（0未发布，1已发布）',
  `delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0已删除，1未删除）',
  `edit_time` int(10) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`),
  KEY `idx_release` (`release`),
  KEY `idx_delete` (`delete`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='开源项目表';

-- ----------------------------
-- Table structure for bs_osp_update_log
-- ----------------------------
DROP TABLE IF EXISTS `bs_osp_update_log`;
CREATE TABLE `bs_osp_update_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增主键ID',
  `ops_id` int(10) NOT NULL COMMENT '开源项目表',
  `version` char(8) NOT NULL DEFAULT '' COMMENT '版本号',
  `content` varchar(256) NOT NULL DEFAULT '' COMMENT '日志内容',
  `delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0已删除，1未删除）',
  `edit_time` int(10) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='开源项目更新日志表';

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

SET FOREIGN_KEY_CHECKS = 1;
