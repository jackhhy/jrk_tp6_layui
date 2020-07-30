-- -----------------------------
-- Think MySQL Data Transfer 
-- 
-- Host     : 127.0.0.1
-- Port     : 3306
-- Database : jrk_admin
-- 
-- Part : #1
-- Date : 2020-07-30 20:59:39
-- -----------------------------

SET FOREIGN_KEY_CHECKS = 0;


-- -----------------------------
-- Table structure for `jrk_admin`
-- -----------------------------
DROP TABLE IF EXISTS `jrk_admin`;
CREATE TABLE `jrk_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL COMMENT '用户名',
  `nickname` varchar(25) DEFAULT NULL COMMENT '昵称',
  `avatar` varchar(120) DEFAULT NULL COMMENT '头像',
  `sex` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0男1女2未知',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态0 拉黑 1正常',
  `login_time` int(11) unsigned DEFAULT '0' COMMENT '登录时间',
  `login_ip` varchar(25) DEFAULT NULL COMMENT '登录IP',
  `token` varchar(150) DEFAULT NULL COMMENT '登录token，需要做单一登录的时候才有',
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) DEFAULT '0',
  `phone` varchar(20) DEFAULT NULL COMMENT '手机号',
  `email` varchar(30) DEFAULT NULL COMMENT '邮箱号',
  `birthday` varchar(80) DEFAULT NULL COMMENT '出生日期',
  `logins` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='后台管理员表';

-- -----------------------------
-- Records of `jrk_admin`
-- -----------------------------
INSERT INTO `jrk_admin` VALUES ('1', 'jrkadmintp6', '超级管理员', '/uploads/adminuser/avatar/20200702/5e19638241c47d668ad937cd5fde4847.jpg', '1', '$2y$10$XxyKGjfAtyo5I9.9HBY21O1frCziHTOzuWhhdiDypvUldM24xXVzW', '1', '1596110838', '127.0.0.1', '', '1593179425', '1596110838', '13141962690', 'jackhhy520@qq.com', '1995-06-05', '13');
INSERT INTO `jrk_admin` VALUES ('2', 'test', '人事专员', '', '0', '$2y$10$XxyKGjfAtyo5I9.9HBY21O1frCziHTOzuWhhdiDypvUldM24xXVzW', '1', '1593450107', '127.0.0.1', '', '1593179425', '0', '13141962698', '', '', '2');
INSERT INTO `jrk_admin` VALUES ('3', 'ceshi', '测试员1', '/uploads/adminuser/avatar/20200630/acd1e53a97ec152c14b5fca6f7ffb40d.jpg', '1', '$2y$10$WLfde3sqoLFRppVrn7m8Tu/kiydOefnefYeRtt92rALWXNh6U0Ti.', '1', '0', '', '', '1593505184', '1593505220', '13141962690', '13141962690@163.com', '2020-06-30', '0');
INSERT INTO `jrk_admin` VALUES ('4', 'test2', '测试2_5_-', '/uploads/adminuser/avatar/20200630/92a02b58dc5c02e895a0d519765835ae.jpg', '0', '$2y$10$Q9dXmkFiVTsjs.WsNUxfIuy5etKwGd6a7K5612dhEzso1sgSu/btS', '1', '0', '', '', '1593505714', '1593505847', '13141962698', '', '2020-06-24', '0');

-- -----------------------------
-- Table structure for `jrk_attachment`
-- -----------------------------
DROP TABLE IF EXISTS `jrk_attachment`;
CREATE TABLE `jrk_attachment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '附件名称',
  `att_dir` varchar(200) NOT NULL DEFAULT '' COMMENT '附件路径',
  `satt_dir` varchar(200) DEFAULT NULL COMMENT '压缩图片路径',
  `size` char(30) NOT NULL DEFAULT '' COMMENT '附件大小',
  `img_dir` varchar(100) NOT NULL DEFAULT '' COMMENT '图片存储的文件夹',
  `type` char(30) NOT NULL DEFAULT '' COMMENT '附件类型',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '上传时间',
  `image_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '图片上传类型 1本地 2七牛云 3OSS 4COS ',
  `module_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '图片上传模块类型 1 后台上传 2 用户生成',
  `update_time` int(11) unsigned DEFAULT '0',
  `ext` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='附件管理表';

-- -----------------------------
-- Records of `jrk_attachment`
-- -----------------------------
INSERT INTO `jrk_attachment` VALUES ('1', 'c7761412650fbc743b9cf26d995054f2.jpg', '/uploads/attachment/images/20200702/c7761412650fbc743b9cf26d995054f2.jpg', '/uploads/attachment/images/20200702/c7761412650fbc743b9cf26d995054f2.jpg', '370198', 'attachment/images', 'image/jpeg', '1593678336', '1', '1', '1593678336', 'jpeg');
INSERT INTO `jrk_attachment` VALUES ('2', 'f0253fbbd7e198bbfe7cdc825c0d7bd0.jpg', '/uploads/attachment/images/20200702/f0253fbbd7e198bbfe7cdc825c0d7bd0.jpg', '/uploads/attachment/images/20200702/f0253fbbd7e198bbfe7cdc825c0d7bd0.jpg', '275219', 'attachment/images', 'image/jpeg', '1593680457', '1', '1', '1593680457', 'jpg');
INSERT INTO `jrk_attachment` VALUES ('3', 'ad0d4cf96c124f7ecd1c5a8307eb6101.txt', '/uploads/attachment/files/20200702/ad0d4cf96c124f7ecd1c5a8307eb6101.txt', '', '4481', 'attachment/files', 'text/plain', '1593680776', '1', '1', '1593680776', 'txt');
INSERT INTO `jrk_attachment` VALUES ('4', '7ac160ff6f9b3b798d1d3174ab379cb6.jpeg', '/uploads/adminuser/avatar/20200702/7ac160ff6f9b3b798d1d3174ab379cb6.jpeg', '/uploads/adminuser/avatar/20200702/7ac160ff6f9b3b798d1d3174ab379cb6.jpeg', '156571', 'adminuser/avatar', 'image/jpeg', '1593694575', '1', '1', '1593694575', 'jpeg');
INSERT INTO `jrk_attachment` VALUES ('5', '91a0b83b7e61d518a7a3ceee6cf53491.jpg', '/uploads/adminuser/avatar/20200702/91a0b83b7e61d518a7a3ceee6cf53491.jpg', '/uploads/adminuser/avatar/20200702/91a0b83b7e61d518a7a3ceee6cf53491.jpg', '37399', 'adminuser/avatar', 'image/jpg', '1593694742', '1', '1', '1593694742', 'jpg');
INSERT INTO `jrk_attachment` VALUES ('6', '5e19638241c47d668ad937cd5fde4847.jpg', '/uploads/adminuser/avatar/20200702/5e19638241c47d668ad937cd5fde4847.jpg', '/uploads/adminuser/avatar/20200702/5e19638241c47d668ad937cd5fde4847.jpg', '119892', 'adminuser/avatar', 'image/jpeg', '1593695855', '1', '1', '1593695855', 'jpg');

-- -----------------------------
-- Table structure for `jrk_auth_group`
-- -----------------------------
DROP TABLE IF EXISTS `jrk_auth_group`;
CREATE TABLE `jrk_auth_group` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态1正常0拉黑',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '角色组',
  `rules` text COMMENT '权限',
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='角色组管理';

-- -----------------------------
-- Records of `jrk_auth_group`
-- -----------------------------
INSERT INTO `jrk_auth_group` VALUES ('1', '1593248783', '0', '1', '超级管理', 'all', '0');
INSERT INTO `jrk_auth_group` VALUES ('2', '1593444916', '1593697699', '1', '人事权限', '2,6,1,33,34,35,36,26,27,32,28', '0');

-- -----------------------------
-- Table structure for `jrk_auth_group_access`
-- -----------------------------
DROP TABLE IF EXISTS `jrk_auth_group_access`;
CREATE TABLE `jrk_auth_group_access` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  `create_time` int(11) DEFAULT '0' COMMENT '添加时间',
  `update_time` int(11) DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`) USING BTREE,
  KEY `uid` (`uid`) USING BTREE,
  KEY `group_id` (`group_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='权限关系表';

-- -----------------------------
-- Records of `jrk_auth_group_access`
-- -----------------------------
INSERT INTO `jrk_auth_group_access` VALUES ('1', '2', '2', '1593248783', '0');

-- -----------------------------
-- Table structure for `jrk_auth_rule`
-- -----------------------------
DROP TABLE IF EXISTS `jrk_auth_rule`;
CREATE TABLE `jrk_auth_rule` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '控制器/方法',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '菜单名称',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1菜单 2按钮',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '菜单状态0 禁止 1正常',
  `condition` char(100) DEFAULT '',
  `sort` mediumint(8) NOT NULL DEFAULT '0' COMMENT '排序',
  `auth_open` tinyint(2) unsigned DEFAULT '1' COMMENT '1 需验证 2不需验证',
  `icon` varchar(50) DEFAULT '' COMMENT '图标',
  `font_family` varchar(25) NOT NULL DEFAULT 'fa' COMMENT '图标类型',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(11) unsigned DEFAULT '0' COMMENT '更新时间',
  `param` varchar(50) DEFAULT '' COMMENT '参数',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='菜单表';

-- -----------------------------
-- Records of `jrk_auth_rule`
-- -----------------------------
INSERT INTO `jrk_auth_rule` VALUES ('1', '2', 'AuthRule/index', '菜单规则', '1', '1', '', '98', '1', 'fa-home', 'fa', '1593354333', '1593354333', '');
INSERT INTO `jrk_auth_rule` VALUES ('2', '0', '', '权限管理', '1', '1', '', '90', '1', 'fa-cog', 'fa', '1593352451', '1593352729', '');
INSERT INTO `jrk_auth_rule` VALUES ('3', '1', 'AuthRule/addAuth', '新增', '2', '1', '', '30', '1', '', 'fa', '1593353629', '1593353629', '');
INSERT INTO `jrk_auth_rule` VALUES ('4', '1', 'AuthRule/addSon', '新增子菜单', '2', '1', '', '10', '1', '', 'fa', '1593354311', '1593509572', '');
INSERT INTO `jrk_auth_rule` VALUES ('5', '1', 'AuthRule/del', '删除', '2', '1', '', '20', '1', '', 'fa', '1593354333', '1593354333', '');
INSERT INTO `jrk_auth_rule` VALUES ('6', '2', 'AuthGroup/index', '角色组', '1', '1', '', '100', '1', 'fa-address-book-o', 'fa', '1593441632', '1593441632', '');
INSERT INTO `jrk_auth_rule` VALUES ('9', '33', 'Admin/addAdmin', '添加', '2', '1', '', '0', '1', '', 'fa', '1593508446', '1593508446', '');
INSERT INTO `jrk_auth_rule` VALUES ('10', '33', 'Admin/del', '删除', '2', '1', '', '0', '1', '', 'fa', '1593508463', '1593508463', '');
INSERT INTO `jrk_auth_rule` VALUES ('11', '33', 'Admin/addAdmin', '编辑', '2', '1', '', '0', '1', '', 'fa', '1593508493', '1593508986', '');
INSERT INTO `jrk_auth_rule` VALUES ('12', '6', 'AuthGroup/userGroup', '角色授权', '2', '1', '', '0', '1', '', 'fa', '1593508559', '1593508559', '');
INSERT INTO `jrk_auth_rule` VALUES ('13', '6', 'AuthGroup/addGroups', '编辑', '2', '1', '', '0', '1', '', 'fa', '1593508580', '1593508580', '');
INSERT INTO `jrk_auth_rule` VALUES ('14', '6', 'AuthGroup/del', '删除', '2', '1', '', '0', '1', '', 'fa', '1593508598', '1593508598', '');
INSERT INTO `jrk_auth_rule` VALUES ('15', '6', 'AuthGroup/addGroups', '新增', '2', '1', '', '0', '1', '', 'fa', '1593508625', '1593508625', '');
INSERT INTO `jrk_auth_rule` VALUES ('16', '0', 'DataBackup/index', '数据备份', '1', '1', '', '0', '2', 'fa-bank', 'fa', '1593570323', '1593570323', '');
INSERT INTO `jrk_auth_rule` VALUES ('17', '16', 'DataBackup/index', '数据表列表', '1', '1', '', '0', '2', 'fa-align-left', 'fa', '1593570431', '1593570431', '');
INSERT INTO `jrk_auth_rule` VALUES ('18', '16', 'DataBackup/importlist', '备份列表', '1', '1', '', '0', '2', 'fa-align-right', 'fa', '1593573590', '1593573590', '');
INSERT INTO `jrk_auth_rule` VALUES ('25', '1', 'AuthRule/addNode', '添加节点', '2', '1', '', '0', '1', '', 'fa', '1593661475', '0', '');
INSERT INTO `jrk_auth_rule` VALUES ('26', '0', '', '系统管理', '1', '1', '', '0', '1', 'fa-cogs', 'fa', '1593661642', '1593661642', '');
INSERT INTO `jrk_auth_rule` VALUES ('27', '26', 'AttachMents/index', '附件管理', '1', '1', '', '0', '1', 'fa-link', 'fa', '1593661815', '1593661815', '');
INSERT INTO `jrk_auth_rule` VALUES ('28', '26', 'SystemLog/index', '日志管理', '1', '1', '', '0', '1', 'fa-book', 'fa', '1593669289', '1593669289', '');
INSERT INTO `jrk_auth_rule` VALUES ('29', '28', 'SystemLog/del', '删除', '2', '1', '', '0', '1', '', 'fa', '1593669410', '0', '');
INSERT INTO `jrk_auth_rule` VALUES ('30', '27', 'AttachMents/uploadAttachment', '上传', '2', '1', '', '0', '1', '', 'fa', '1593670168', '0', '');
INSERT INTO `jrk_auth_rule` VALUES ('31', '27', 'AttachMents/del', '删除', '2', '1', '', '0', '1', '', 'fa', '1593670168', '0', '');
INSERT INTO `jrk_auth_rule` VALUES ('32', '27', 'AttachMents/download', '打包下载', '2', '1', '', '0', '1', '', 'fa', '1593680898', '0', '');
INSERT INTO `jrk_auth_rule` VALUES ('33', '2', 'Admin/index', '管理员管理', '1', '1', '', '0', '1', 'fa-address-book', 'fa', '1593692881', '1593692881', '');
INSERT INTO `jrk_auth_rule` VALUES ('34', '2', '', '基本设置', '1', '1', '', '0', '1', 'fa-address-book-o', 'fa', '1593693025', '1593693025', '');
INSERT INTO `jrk_auth_rule` VALUES ('35', '34', 'Admin/baseData', '基本资料', '1', '1', '', '0', '1', 'fa-address-card', 'fa', '1593693110', '1593693233', '');
INSERT INTO `jrk_auth_rule` VALUES ('36', '34', 'Admin/changPass', '修改密码', '1', '1', '', '0', '1', 'fa-amazon', 'fa', '1593693191', '1593693191', '');
INSERT INTO `jrk_auth_rule` VALUES ('37', '0', '', '模块管理', '1', '1', '', '0', '1', 'fa-book', 'fa', '1596108938', '1596108938', '');
INSERT INTO `jrk_auth_rule` VALUES ('38', '37', '', '站长推送', '1', '1', '', '0', '1', 'fa-adn', 'fa', '1596108969', '1596108969', '');
INSERT INTO `jrk_auth_rule` VALUES ('39', '38', 'Push/bindex', '百度推送', '1', '1', '', '0', '1', 'fa-ban', 'fa', '1596109006', '1596109006', '');
INSERT INTO `jrk_auth_rule` VALUES ('40', '38', 'Push/xindex', '熊掌推送', '1', '1', '', '0', '1', 'fa-external-link', 'fa', '1596109037', '1596109037', '');
INSERT INTO `jrk_auth_rule` VALUES ('41', '37', 'queue.queue/index', '定时任务', '1', '1', '', '0', '1', 'fa-align-center', 'fa', '1596110140', '1596110140', '');
INSERT INTO `jrk_auth_rule` VALUES ('42', '26', '', '系统配置', '1', '1', '', '0', '1', 'fa-bullseye', 'fa', '1596111745', '1596111745', '');
INSERT INTO `jrk_auth_rule` VALUES ('43', '42', 'config.Sysconfig/index', '配置列表', '1', '1', '', '0', '1', 'fa-bank', 'fa', '1596111773', '1596111773', '');
INSERT INTO `jrk_auth_rule` VALUES ('44', '42', 'config.Sysconfigtab/index', '配置分类', '1', '1', '', '0', '1', 'fa-amazon', 'fa', '1596111801', '1596111801', '');

-- -----------------------------
-- Table structure for `jrk_sys_config`
-- -----------------------------
DROP TABLE IF EXISTS `jrk_sys_config`;
CREATE TABLE `jrk_sys_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分组ID',
  `group` varchar(80) NOT NULL COMMENT '配置分组名',
  `name` varchar(80) NOT NULL COMMENT '配置名',
  `value` varchar(255) DEFAULT NULL COMMENT '配置值',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `beizhu` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='配置表';

-- -----------------------------
-- Records of `jrk_sys_config`
-- -----------------------------
INSERT INTO `jrk_sys_config` VALUES ('1', '3', 'upload', 'accessKey', 'accessKey', '1593354333', '');
INSERT INTO `jrk_sys_config` VALUES ('2', '3', 'upload', 'secretKey', 'secretKey', '1593354333', '');
INSERT INTO `jrk_sys_config` VALUES ('3', '3', 'upload', 'uploadUrl', 'uploadUrl', '1593354333', '');
INSERT INTO `jrk_sys_config` VALUES ('4', '3', 'upload', 'storage_name', 'storage_name', '1593354333', '');
INSERT INTO `jrk_sys_config` VALUES ('5', '3', 'upload', 'storage_region', 'storage_region', '1593354333', '');
INSERT INTO `jrk_sys_config` VALUES ('14', '2', 'site', 'site_name', '网站名称', '1593354333', '');
INSERT INTO `jrk_sys_config` VALUES ('15', '2', 'site', 'site_url', '网站地址', '1593354333', '');
INSERT INTO `jrk_sys_config` VALUES ('16', '2', 'site', 'site_logo', '站点LOGO', '1593354333', '');
INSERT INTO `jrk_sys_config` VALUES ('17', '2', 'site', 'site_phone', '站点联系电话', '1593354333', '');
INSERT INTO `jrk_sys_config` VALUES ('18', '2', 'site', 'site_seo_title', 'SEO标题', '1593354333', '');
INSERT INTO `jrk_sys_config` VALUES ('19', '2', 'site', 'site_email', '站点联系邮箱', '1593354333', '');
INSERT INTO `jrk_sys_config` VALUES ('20', '2', 'site', 'site_qq', '站点联系QQ', '1593354333', '');
INSERT INTO `jrk_sys_config` VALUES ('21', '2', 'site', 'site_close', '网站关闭', '1593354333', '0=>开启1=>PC端关闭2=>WAP端关闭(含微信)3=>全部关闭');
INSERT INTO `jrk_sys_config` VALUES ('22', '3', 'upload', 'upload_type', '1', '1593354333', '1=>本地存储2=>七牛云存储3=>阿里云OSS4=>腾讯COS');
INSERT INTO `jrk_sys_config` VALUES ('23', '4', 'push', 'xzappid', 'xzappid熊掌号的appid', '1596099671', '');
INSERT INTO `jrk_sys_config` VALUES ('24', '4', 'push', 'xztoken', 'xztoken 熊掌号的token', '1596099698', '');
INSERT INTO `jrk_sys_config` VALUES ('25', '4', 'push', 'zz_site', '1', '1596099776', '百度站长的站点');
INSERT INTO `jrk_sys_config` VALUES ('26', '4', 'push', 'zz_token', '2', '1596099819', '百度站长token');
INSERT INTO `jrk_sys_config` VALUES ('27', '2', 'site', 'site_keywords', 'keywords', '1596101048', '');
INSERT INTO `jrk_sys_config` VALUES ('28', '2', 'site', 'site_description', 'description', '1596101062', '');

-- -----------------------------
-- Table structure for `jrk_sys_config_tab`
-- -----------------------------
DROP TABLE IF EXISTS `jrk_sys_config_tab`;
CREATE TABLE `jrk_sys_config_tab` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL COMMENT '配置分类名称',
  `eng_title` varchar(100) NOT NULL COMMENT '分类英文名',
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '0禁止1正常',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `beizhu` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='配置分类表';

-- -----------------------------
-- Records of `jrk_sys_config_tab`
-- -----------------------------
INSERT INTO `jrk_sys_config_tab` VALUES ('1', '默认分类', 'moren', '0', '1', '1596095169', '1596095169', '没有分配分类的配置');
INSERT INTO `jrk_sys_config_tab` VALUES ('2', '站点配置', 'site', '0', '1', '1596095705', '1596095705', '后端站点所有配置');
INSERT INTO `jrk_sys_config_tab` VALUES ('3', '上传配置', 'upload', '0', '1', '1596096079', '1596096079', '');
INSERT INTO `jrk_sys_config_tab` VALUES ('4', '地址推送', 'push', '0', '1', '1596099565', '1596099565', '百度站长，熊掌号推送链接');

-- -----------------------------
-- Table structure for `jrk_sys_queue`
-- -----------------------------
DROP TABLE IF EXISTS `jrk_sys_queue`;
CREATE TABLE `jrk_sys_queue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `type` varchar(10) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '事件类型',
  `title` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '事件标题',
  `content` text CHARACTER SET utf8 NOT NULL COMMENT '事件内容',
  `schedule` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT 'Crontab格式',
  `sleep` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '延迟秒数执行',
  `maximums` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最大执行次数 0为不限',
  `executes` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '已经执行的次数',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `begintime` int(10) DEFAULT '0' COMMENT '开始时间',
  `endtime` int(10) DEFAULT '0' COMMENT '结束时间',
  `executetime` int(10) DEFAULT '0' COMMENT '最后执行时间',
  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '权重',
  `status` enum('completed','expired','hidden','normal') CHARACTER SET utf8 NOT NULL DEFAULT 'normal' COMMENT '状态',
  `ip` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='定时任务表';

