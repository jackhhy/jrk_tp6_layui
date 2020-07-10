-- -----------------------------
-- Think MySQL Data Transfer 
-- 
-- Host     : 127.0.0.1
-- Port     : 3306
-- Database : jrk_admin
-- 
-- Part : #1
-- Date : 2020-07-02 22:09:35
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
INSERT INTO `jrk_admin` VALUES ('1', 'jrkadmintp6', '超级管理员', '/uploads/adminuser/avatar/20200702/5e19638241c47d668ad937cd5fde4847.jpg', '1', '$2y$10$XxyKGjfAtyo5I9.9HBY21O1frCziHTOzuWhhdiDypvUldM24xXVzW', '1', '1593697536', '127.0.0.1', '', '1593179425', '1593695858', '13141962690', 'jackhhy520@qq.com', '1995-06-05', '11');
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
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='菜单表';

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

-- -----------------------------
-- Table structure for `jrk_sys_config`
-- -----------------------------
DROP TABLE IF EXISTS `jrk_sys_config`;
CREATE TABLE `jrk_sys_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(80) NOT NULL COMMENT '配置分组名',
  `name` varchar(80) NOT NULL COMMENT '配置名',
  `value` varchar(255) DEFAULT NULL COMMENT '配置值',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `beizhu` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='配置表';

-- -----------------------------
-- Records of `jrk_sys_config`
-- -----------------------------
INSERT INTO `jrk_sys_config` VALUES ('1', 'upload', 'accessKey', 'accessKey', '1593354333', '');
INSERT INTO `jrk_sys_config` VALUES ('2', 'upload', 'secretKey', 'secretKey', '1593354333', '');
INSERT INTO `jrk_sys_config` VALUES ('3', 'upload', 'uploadUrl', 'uploadUrl', '1593354333', '');
INSERT INTO `jrk_sys_config` VALUES ('4', 'upload', 'storage_name', 'storage_name', '1593354333', '');
INSERT INTO `jrk_sys_config` VALUES ('5', 'upload', 'storage_region', 'storage_region', '1593354333', '');
INSERT INTO `jrk_sys_config` VALUES ('14', 'site', 'site_name', '网站名称', '1593354333', '');
INSERT INTO `jrk_sys_config` VALUES ('15', 'site', 'site_url', '网站地址', '1593354333', '');
INSERT INTO `jrk_sys_config` VALUES ('16', 'site', 'site_logo', '站点LOGO', '1593354333', '');
INSERT INTO `jrk_sys_config` VALUES ('17', 'site', 'site_phone', '站点联系电话', '1593354333', '');
INSERT INTO `jrk_sys_config` VALUES ('18', 'site', 'site_seo_title', 'SEO标题', '1593354333', '');
INSERT INTO `jrk_sys_config` VALUES ('19', 'site', 'site_email', '站点联系邮箱', '1593354333', '');
INSERT INTO `jrk_sys_config` VALUES ('20', 'site', 'site_qq', '站点联系QQ', '1593354333', '');
INSERT INTO `jrk_sys_config` VALUES ('21', 'site', 'site_close', '网站关闭', '1593354333', '0=>开启\\n1=>PC端关闭\\n2=>WAP端关闭(含微信)\\n3=>全部关闭');
INSERT INTO `jrk_sys_config` VALUES ('22', 'upload', 'upload_type', '1', '1593354333', '1=>本地存储\\n2=>七牛云存储\\n3=>阿里云OSS\\n4=>腾讯COS');

-- -----------------------------
-- Table structure for `jrk_system_log_202007`
-- -----------------------------
DROP TABLE IF EXISTS `jrk_system_log_202007`;
CREATE TABLE `jrk_system_log_202007` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `admin_id` int(10) unsigned DEFAULT '0' COMMENT '管理员ID',
  `url` varchar(1500) NOT NULL DEFAULT '' COMMENT '操作页面',
  `method` varchar(50) NOT NULL COMMENT '请求方法',
  `title` varchar(100) DEFAULT '' COMMENT '日志标题',
  `content` text NOT NULL COMMENT '内容',
  `ip` varchar(50) NOT NULL DEFAULT '' COMMENT 'IP',
  `useragent` varchar(255) DEFAULT '' COMMENT 'User-Agent',
  `create_time` int(10) DEFAULT NULL COMMENT '操作时间',
  `os` varchar(100) DEFAULT NULL,
  `brower` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='后台操作日志表 - 202007';

-- -----------------------------
-- Records of `jrk_system_log_202007`
-- -----------------------------
INSERT INTO `jrk_system_log_202007` VALUES ('116', '1', '/admin/DataBackup/export.html', 'post', '超级管理员', 'a:1:{s:6:\"tables\";a:7:{i:0;s:9:\"jrk_admin\";i:1;s:14:\"jrk_attachment\";i:2;s:14:\"jrk_auth_group\";i:3;s:21:\"jrk_auth_group_access\";i:4;s:13:\"jrk_auth_rule\";i:5;s:14:\"jrk_sys_config\";i:6;s:21:\"jrk_system_log_202007\";}}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36', '1593698975', 'windows', 'Chrome/80.0.3987.163');
