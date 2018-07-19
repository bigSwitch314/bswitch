1.节点表
CREATE TABLE `bs_node` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '节点',
  `title` varchar(100) NOT NULL COMMENT '名称',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可用（1可以，0禁用）',
  `pid` int(11) NOT NULL COMMENT '父节点ID',
  `level` tinyint(1) NOT NULL COMMENT '节点等级（1模块，2类，3方法）',
  `sort` smallint(5) NOT NULL DEFAULT '0' COMMENT '排序权重',
  `menu` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否菜单（1菜单，0非菜单）',
  `gid` int(11) NOT NULL DEFAULT '0' COMMENT '节点组ID',
  `module` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin' COMMENT '模块',
  `deleted` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否被删除，1是被删除，0未被删除',
  `edit_time` int(11) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`),
  KEY `idx_level` (`level`),
  KEY `idx_pid` (`pid`),
  KEY `idx_status` (`status`),
  KEY `idx_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='节点表';


2.节点分组表
CREATE TABLE `bs_node_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL COMMENT '名称',
  `pid` int(11) NOT NULL COMMENT '父级ID',
  `sort` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序',
  `display` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示（0不显示，1显示）',
  `deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0未删除，1已删除）',
  `edit_time` int(11) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='节点分组表';


3.角色表
CREATE TABLE `bs_role` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL COMMENT '名称',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '激活状态（0未激活，1已激活）',
  `bus_id` int(11) NOT NULL DEFAULT '0' COMMENT '场馆id',
  `type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '管理员角色类型（99总后台管理员，0普通管理员）',
  `deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除（0未删除，1已删除）',
  `edit_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `idx_bus_id` (`bus_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='角色表';


4.角色节点权限表
CREATE TABLE `bs_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` smallint(6) unsigned NOT NULL COMMENT '角色id',
  `node_id` smallint(6) unsigned NOT NULL COMMENT '节点id',
  PRIMARY KEY (`id`),
  KEY `idx_role_id` (`role_id`),
  KEY `idx_node_id` (`node_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='角色节点权限表';


5.后台管理员表
CREATE TABLE `bs_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bus_id` int(11) NOT NULL DEFAULT '0' COMMENT '场馆id',
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '加密密码',
  `realname` char(15) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '电话号码',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '电子邮箱',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '使用状态（0禁止，1启用）',
  `last_login_ip` varchar(15) NOT NULL COMMENT '最后登录IP',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `deleted` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否删除（0未删除，1已删除）',
  `edit_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `idx_username` (`username`),
  KEY `idx_phone` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='后台管理员表';


6.账号角色关联表
CREATE TABLE `bs_admin_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` smallint(6) NOT NULL COMMENT '账号id',
  `role_id` smallint(6) NOT NULL COMMENT '角色id',
  PRIMARY KEY (`id`),
  KEY `unique` (`admin_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='账号角色关联表';