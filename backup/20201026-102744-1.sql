-- -----------------------------
-- Think MySQL Data Transfer 
-- 
-- Host     : 127.0.0.1
-- Port     : 3306
-- Database : jrk_admin_tp6
-- 
-- Part : #1
-- Date : 2020-10-26 10:27:44
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
INSERT INTO `jrk_admin` VALUES ('1', 'jrkadmintp6', '超级管理员', '/uploads/adminuser/avatar/20200702/5e19638241c47d668ad937cd5fde4847.jpg', '1', '$2y$10$XxyKGjfAtyo5I9.9HBY21O1frCziHTOzuWhhdiDypvUldM24xXVzW', '1', '1603679241', '127.0.0.1', '', '1593179425', '1603679241', '13141962690', 'jackhhy520@qq.com', '1995-06-05', '18');
INSERT INTO `jrk_admin` VALUES ('2', 'test', '人事专员', '/uploads/adminuser/avatar/20200814/9fb56f259b55337ef9f1f2ac90d0dcab.jpg', '0', '$2y$10$3YQI7c/fbHn2I9j3DeERzeKxbXUaldYXhX6GDDphuhN4MhfyH096y', '1', '1597930258', '127.0.0.1', '', '1593179425', '1597930258', '13141962698', '', '', '3');
INSERT INTO `jrk_admin` VALUES ('3', 'ce', '测试员1', '/uploads/adminuser/avatar/20200630/acd1e53a97ec152c14b5fca6f7ffb40d.jpg', '1', '$2y$10$WLfde3sqoLFRppVrn7m8Tu/kiydOefnefYeRtt92rALWXNh6U0Ti.', '1', '0', '', '', '1593505184', '1597386201', '13141962690', '13141962690@163.com', '2020-06-30', '0');
INSERT INTO `jrk_admin` VALUES ('4', 'testsss', '测试2_5_-', '/uploads/adminuser/avatar/20200630/92a02b58dc5c02e895a0d519765835ae.jpg', '0', '$2y$10$Q9dXmkFiVTsjs.WsNUxfIuy5etKwGd6a7K5612dhEzso1sgSu/btS', '1', '0', '', '', '1593505714', '1597386214', '13141962698', '', '2020-06-24', '0');

-- -----------------------------
-- Table structure for `jrk_articles`
-- -----------------------------
DROP TABLE IF EXISTS `jrk_articles`;
CREATE TABLE `jrk_articles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cate_id` int(11) NOT NULL COMMENT '栏目ID',
  `title` varchar(180) NOT NULL COMMENT '标题',
  `title_color` varchar(255) DEFAULT NULL COMMENT '标题颜色',
  `range` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文章等级',
  `keywords` varchar(255) DEFAULT NULL COMMENT '关键词',
  `description` varchar(255) NOT NULL COMMENT '文章描述',
  `img_url` varchar(255) DEFAULT NULL COMMENT '封面图',
  `author` varchar(90) NOT NULL COMMENT '作者',
  `origin` varchar(90) NOT NULL DEFAULT '原创' COMMENT '原创或者转载',
  `content` mediumtext NOT NULL COMMENT '内容',
  `hits` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '点击量',
  `admin_id` int(11) NOT NULL,
  `love` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '喜欢量',
  `comment_num` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论数量',
  `is_recommend` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1是0否，是否推荐',
  `is_top` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1是0否，是否置顶',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1是0否，是否在栏目显示',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1正常，0删除',
  `url` varchar(255) DEFAULT NULL COMMENT '地址或者链接',
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) DEFAULT '0',
  `delete_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间，软删除',
  PRIMARY KEY (`id`),
  KEY `cate_id` (`cate_id`) USING BTREE COMMENT '栏目ID',
  KEY `is_show` (`is_show`) USING BTREE,
  KEY `status` (`status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='文章表';

-- -----------------------------
-- Records of `jrk_articles`
-- -----------------------------
INSERT INTO `jrk_articles` VALUES ('1', '2', '测试标题', '', '0', '奥德赛大所,123', '&lt;p&gt;搭搭撒撒多&lt;/p&gt;&lt;p&gt;大萨达撒多撒&lt;/p&gt;&lt;p&gt;打撒大大&lt;/p&gt;&lt;p&gt;国风大赏...', '', 'jrkadmintp6', '原创', '<p>搭搭撒撒多</p><p>大萨达撒多撒</p><p>打撒大大</p><p>国风大赏鬼地方个地方</p><p>gfhgfjhghgjgh萨顶顶撒奥</p><p>更大的郭德纲的观点</p>', '0', '1', '0', '0', '0', '0', '1', '1', '', '1597219278', '1597224466', '1597224466');
INSERT INTO `jrk_articles` VALUES ('2', '2', '大萨达十大大萨达撒', '#2B6199', '4', '敖德萨多', '阿达打算', '', 'jrkadmintp6', '原创', '# 敖德萨多撒\n### 大萨达\n> 奥德赛大\n\n##### 达大撒多所', '11', '1', '11', '12', '0', '0', '1', '1', '/index/article/show.html?id=2', '1597219392', '1597310195', '0');

-- -----------------------------
-- Table structure for `jrk_articles_cate`
-- -----------------------------
DROP TABLE IF EXISTS `jrk_articles_cate`;
CREATE TABLE `jrk_articles_cate` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT '栏目名称',
  `url` varchar(200) NOT NULL COMMENT '栏目地址',
  `param` varchar(255) DEFAULT NULL COMMENT '参数',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'pID',
  `model_id` int(25) NOT NULL COMMENT '模型ID',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '0不显示1显示',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `description` varchar(255) DEFAULT NULL COMMENT '栏目描述',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  `admin_id` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `is-show` (`is_show`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='文章栏目表';

-- -----------------------------
-- Records of `jrk_articles_cate`
-- -----------------------------
INSERT INTO `jrk_articles_cate` VALUES ('1', '技术分享', '/index/articles/index.html?cate=1', '{\"cate\":\"1\"}', '0', '2', '1', '10', '111', '1597195786', '1597195786', '1');
INSERT INTO `jrk_articles_cate` VALUES ('2', 'php', '/index/videos/lists.html?cate=2', '{\"cate\":\"2\"}', '1', '6', '1', '10', '111', '1597197517', '1597203519', '1');

-- -----------------------------
-- Table structure for `jrk_articles_comment`
-- -----------------------------
DROP TABLE IF EXISTS `jrk_articles_comment`;
CREATE TABLE `jrk_articles_comment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL COMMENT '文章ID',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `cate_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论的上级用户ID',
  `content` varchar(255) NOT NULL COMMENT '评论内容',
  `ip` varchar(100) NOT NULL COMMENT '评论IP',
  `browser` varchar(255) DEFAULT NULL COMMENT '浏览器',
  `os` varchar(255) DEFAULT NULL COMMENT '系统',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0不显示1显示',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0未审核1已审核',
  PRIMARY KEY (`id`),
  KEY `is_show` (`is_show`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='文章评论表';

-- -----------------------------
-- Records of `jrk_articles_comment`
-- -----------------------------
INSERT INTO `jrk_articles_comment` VALUES ('1', '2', '1', '2', '0', '测试内容dsasadsad', '127.0.0.1', 'cent', 'windows', '1', '1597219278', '1597327984', '1');
INSERT INTO `jrk_articles_comment` VALUES ('2', '2', '2', '2', '1', '回复上级的测试内容', '127.0.0.1', 'cent', 'windows', '1', '1597219278', '0', '1');

-- -----------------------------
-- Table structure for `jrk_articles_models`
-- -----------------------------
DROP TABLE IF EXISTS `jrk_articles_models`;
CREATE TABLE `jrk_articles_models` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '模型名称',
  `tablename` char(20) NOT NULL DEFAULT '' COMMENT '表名',
  `index_template` char(30) NOT NULL DEFAULT 'index' COMMENT '封面页模板',
  `list_template` char(30) NOT NULL DEFAULT 'list' COMMENT '列表模板',
  `show_template` char(30) NOT NULL DEFAULT 'show' COMMENT '详情页模板',
  `sort` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'asc 排序',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  `ip` varchar(80) DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COMMENT='模型表';

-- -----------------------------
-- Records of `jrk_articles_models`
-- -----------------------------
INSERT INTO `jrk_articles_models` VALUES ('1', '单页模型', 'page', 'index', 'list', 'show', '2', '1583305903', '0', '');
INSERT INTO `jrk_articles_models` VALUES ('2', '文章模型', 'articles', 'index', 'list', 'show', '10', '1583305903', '0', '');
INSERT INTO `jrk_articles_models` VALUES ('3', '图集模型', 'picture', 'index', 'list', 'show', '3', '1583305903', '0', '');
INSERT INTO `jrk_articles_models` VALUES ('4', '链接模型', 'link', 'index', 'list', 'show', '5', '1583305903', '0', '');
INSERT INTO `jrk_articles_models` VALUES ('5', '下载模型', 'downloads', 'index', 'list', 'show', '4', '1583305903', '0', '');
INSERT INTO `jrk_articles_models` VALUES ('6', '视频模型', 'videos', 'index', 'list', 'show', '0', '1583305903', '0', '');

-- -----------------------------
-- Table structure for `jrk_articles_user`
-- -----------------------------
DROP TABLE IF EXISTS `jrk_articles_user`;
CREATE TABLE `jrk_articles_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nickname` varchar(100) NOT NULL COMMENT '昵称',
  `avatar` varchar(255) NOT NULL COMMENT '头像',
  `qq` varchar(25) NOT NULL COMMENT 'qq',
  `os` varchar(100) DEFAULT NULL COMMENT '系统',
  `browser` varchar(100) DEFAULT NULL COMMENT '浏览器',
  `ip` varchar(50) DEFAULT NULL COMMENT 'IP',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1正常0拉黑',
  `zan` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点赞数',
  `fen` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='文章用户表';

-- -----------------------------
-- Records of `jrk_articles_user`
-- -----------------------------
INSERT INTO `jrk_articles_user` VALUES ('1', '邵东丶贺哥', 'http://q.qlogo.cn/headimg_dl?dst_uin=2237696522&spec=100', '2237696522', 'windows', 'Chrome/80.0.3987.163', '127.0.0.1', '1597324041', '1597324041', '1', '0', '0');
INSERT INTO `jrk_articles_user` VALUES ('2', 'JrkAdmin', 'http://q.qlogo.cn/headimg_dl?dst_uin=1668862539&spec=100', '1668862539', 'windows', 'Chrome/80.0.3987.163', '127.0.0.1', '1597324832', '1597324832', '1', '0', '0');

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='附件管理表';

-- -----------------------------
-- Records of `jrk_attachment`
-- -----------------------------
INSERT INTO `jrk_attachment` VALUES ('1', 'c7761412650fbc743b9cf26d995054f2.jpg', '/uploads/attachment/images/20200702/c7761412650fbc743b9cf26d995054f2.jpg', '/uploads/attachment/images/20200702/c7761412650fbc743b9cf26d995054f2.jpg', '370198', 'attachment/images', 'image/jpeg', '1593678336', '1', '1', '1593678336', 'jpeg');
INSERT INTO `jrk_attachment` VALUES ('2', 'f0253fbbd7e198bbfe7cdc825c0d7bd0.jpg', '/uploads/attachment/images/20200702/f0253fbbd7e198bbfe7cdc825c0d7bd0.jpg', '/uploads/attachment/images/20200702/f0253fbbd7e198bbfe7cdc825c0d7bd0.jpg', '275219', 'attachment/images', 'image/jpeg', '1593680457', '1', '1', '1593680457', 'jpg');
INSERT INTO `jrk_attachment` VALUES ('3', 'ad0d4cf96c124f7ecd1c5a8307eb6101.txt', '/uploads/attachment/files/20200702/ad0d4cf96c124f7ecd1c5a8307eb6101.txt', '', '4481', 'attachment/files', 'text/plain', '1593680776', '1', '1', '1593680776', 'txt');
INSERT INTO `jrk_attachment` VALUES ('4', '7ac160ff6f9b3b798d1d3174ab379cb6.jpeg', '/uploads/adminuser/avatar/20200702/7ac160ff6f9b3b798d1d3174ab379cb6.jpeg', '/uploads/adminuser/avatar/20200702/7ac160ff6f9b3b798d1d3174ab379cb6.jpeg', '156571', 'adminuser/avatar', 'image/jpeg', '1593694575', '1', '1', '1593694575', 'jpeg');
INSERT INTO `jrk_attachment` VALUES ('5', '91a0b83b7e61d518a7a3ceee6cf53491.jpg', '/uploads/adminuser/avatar/20200702/91a0b83b7e61d518a7a3ceee6cf53491.jpg', '/uploads/adminuser/avatar/20200702/91a0b83b7e61d518a7a3ceee6cf53491.jpg', '37399', 'adminuser/avatar', 'image/jpg', '1593694742', '1', '1', '1593694742', 'jpg');
INSERT INTO `jrk_attachment` VALUES ('6', '5e19638241c47d668ad937cd5fde4847.jpg', '/uploads/adminuser/avatar/20200702/5e19638241c47d668ad937cd5fde4847.jpg', '/uploads/adminuser/avatar/20200702/5e19638241c47d668ad937cd5fde4847.jpg', '119892', 'adminuser/avatar', 'image/jpeg', '1593695855', '1', '1', '1593695855', 'jpg');
INSERT INTO `jrk_attachment` VALUES ('7', '9fb56f259b55337ef9f1f2ac90d0dcab.jpg', '/uploads/adminuser/avatar/20200814/9fb56f259b55337ef9f1f2ac90d0dcab.jpg', '/uploads/adminuser/avatar/20200814/9fb56f259b55337ef9f1f2ac90d0dcab.jpg', '66243', 'adminuser/avatar', 'image/jpeg', '1597386063', '1', '1', '1597386063', 'jpg');
INSERT INTO `jrk_attachment` VALUES ('8', '929662552e9dbbf4926d7be6853ea00a.jpg', '/uploads/attachment/images/20200817/929662552e9dbbf4926d7be6853ea00a.jpg', '/uploads/attachment/images/20200817/929662552e9dbbf4926d7be6853ea00a.jpg', '168009', 'attachment/images', 'image/jpeg', '1597633346', '1', '1', '1597633346', 'jpg');
INSERT INTO `jrk_attachment` VALUES ('9', 'ff08af9f69367ac0f041b17968ff5efb.jpeg', '/uploads/article/images/20200817/ff08af9f69367ac0f041b17968ff5efb.jpeg', '/uploads/article/images/20200817/ff08af9f69367ac0f041b17968ff5efb.jpeg', '1687469', 'article/images', 'image/jpeg', '1597633355', '1', '1', '1597633355', 'jpeg');

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
INSERT INTO `jrk_auth_group` VALUES ('2', '1593444916', '1597930173', '1', '人事权限', '2,6,13,15,1,3,33,9,34,35,36,26,27,32,28,37,38,39,40,41,45,68,69,51,65,66,67', '0');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='权限关系表';

-- -----------------------------
-- Records of `jrk_auth_group_access`
-- -----------------------------
INSERT INTO `jrk_auth_group_access` VALUES ('1', '2', '2', '1593248783', '0');
INSERT INTO `jrk_auth_group_access` VALUES ('2', '4', '2', '1597930242', '0');

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
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='菜单表';

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
INSERT INTO `jrk_auth_rule` VALUES ('13', '6', 'AuthGroup/addGroups', '添加和编辑', '2', '1', '', '0', '1', '', 'fa', '1593508580', '1597931278', '');
INSERT INTO `jrk_auth_rule` VALUES ('14', '6', 'AuthGroup/del', '删除', '2', '1', '', '0', '1', '', 'fa', '1593508598', '1593508598', '');
INSERT INTO `jrk_auth_rule` VALUES ('16', '0', '', '数据备份', '1', '1', '', '0', '2', 'fa-bank', 'fa', '1593570323', '1593570323', '');
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
INSERT INTO `jrk_auth_rule` VALUES ('45', '37', 'Command/index', 'CURD命令', '1', '1', '', '0', '1', 'fa-behance', 'fa', '1597392241', '1597392241', '');
INSERT INTO `jrk_auth_rule` VALUES ('46', '0', '', '内容管理', '1', '1', '', '0', '1', 'fa-align-justify', 'fa', '1597394661', '1597394661', '');
INSERT INTO `jrk_auth_rule` VALUES ('47', '46', 'Article/index', '文章列表', '1', '1', '', '0', '1', 'fa-bars', 'fa', '1597394695', '1597394695', '');
INSERT INTO `jrk_auth_rule` VALUES ('48', '46', 'ArticleModel/index', '文章模型', '1', '1', '', '0', '1', 'fa-bomb', 'fa', '1597394752', '1597394752', '');
INSERT INTO `jrk_auth_rule` VALUES ('49', '46', 'ArticleCate/index', '文章栏目', '1', '1', '', '0', '1', 'fa-amazon', 'fa', '1597394826', '1597394826', '');
INSERT INTO `jrk_auth_rule` VALUES ('50', '46', 'ArticleComment/index', '文章评论', '1', '1', '', '0', '1', 'fa-bullhorn', 'fa', '1597394856', '1597394856', '');
INSERT INTO `jrk_auth_rule` VALUES ('51', '37', 'Friendlink/index', '友情链接', '1', '1', '', '0', '1', 'fa-chain', 'fa', '1597394895', '1597394895', '');
INSERT INTO `jrk_auth_rule` VALUES ('52', '46', 'ArticleUser/index', '内容用户', '1', '1', '', '0', '1', 'fa-address-book-o', 'fa', '1597649685', '1597649685', '');
INSERT INTO `jrk_auth_rule` VALUES ('53', '52', 'ArticleUser/del', '删除', '2', '1', '', '0', '1', '', 'fa', '1597650267', '0', '');
INSERT INTO `jrk_auth_rule` VALUES ('54', '50', 'ArticleComment/del', '删除', '2', '1', '', '0', '1', '', 'fa', '1597650331', '0', '');
INSERT INTO `jrk_auth_rule` VALUES ('55', '50', 'ArticleComment/edit', '编辑', '2', '1', '', '0', '1', '', 'fa', '1597650331', '0', '');
INSERT INTO `jrk_auth_rule` VALUES ('56', '50', 'ArticleComment/check', '审核', '2', '1', '', '0', '1', '', 'fa', '1597650331', '0', '');
INSERT INTO `jrk_auth_rule` VALUES ('57', '49', 'ArticleCate/edit', '编辑', '2', '1', '', '0', '1', '', 'fa', '1597650386', '0', '');
INSERT INTO `jrk_auth_rule` VALUES ('58', '49', 'ArticleCate/del', '删除', '2', '1', '', '0', '1', '', 'fa', '1597650386', '0', '');
INSERT INTO `jrk_auth_rule` VALUES ('59', '49', 'ArticleCate/add', '新增', '2', '1', '', '0', '1', '', 'fa', '1597650386', '0', '');
INSERT INTO `jrk_auth_rule` VALUES ('60', '48', 'ArticleModel/edit', '编辑', '2', '1', '', '0', '1', '', 'fa', '1597650417', '0', '');
INSERT INTO `jrk_auth_rule` VALUES ('61', '47', 'Article/edit', '编辑', '2', '1', '', '0', '1', '', 'fa', '1597650476', '0', '');
INSERT INTO `jrk_auth_rule` VALUES ('62', '47', 'Article/del', '删除', '2', '1', '', '0', '1', '', 'fa', '1597650476', '0', '');
INSERT INTO `jrk_auth_rule` VALUES ('63', '47', 'Article/add', '新增', '2', '1', '', '0', '1', '', 'fa', '1597650476', '0', '');
INSERT INTO `jrk_auth_rule` VALUES ('64', '47', 'Article/recycle', '回收站', '2', '1', '', '0', '1', '', 'fa', '1597650476', '0', '');
INSERT INTO `jrk_auth_rule` VALUES ('65', '51', 'Friendlink/edit', '编辑', '2', '1', '', '0', '1', '', 'fa', '1597650538', '0', '');
INSERT INTO `jrk_auth_rule` VALUES ('66', '51', 'Friendlink/add', '新增', '2', '1', '', '0', '1', '', 'fa', '1597650538', '0', '');
INSERT INTO `jrk_auth_rule` VALUES ('67', '51', 'Friendlink/del', '删除', '2', '1', '', '0', '1', '', 'fa', '1597650538', '0', '');
INSERT INTO `jrk_auth_rule` VALUES ('68', '45', 'Command/del', '删除', '2', '1', '', '0', '1', '', 'fa', '1597650591', '0', '');
INSERT INTO `jrk_auth_rule` VALUES ('69', '45', 'Command/add', '新增', '2', '1', '', '0', '1', '', 'fa', '1597650591', '0', '');
INSERT INTO `jrk_auth_rule` VALUES ('70', '6', 'AuthGroup/getRoles', '获取授权菜单', '2', '1', '', '0', '1', '', 'fa', '1597931377', '0', '');

-- -----------------------------
-- Table structure for `jrk_commands`
-- -----------------------------
DROP TABLE IF EXISTS `jrk_commands`;
CREATE TABLE `jrk_commands` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL COMMENT '执行者',
  `name` varchar(80) DEFAULT NULL,
  `app` varchar(255) NOT NULL DEFAULT 'admin' COMMENT '模块名',
  `command` varchar(255) NOT NULL COMMENT '命令',
  `controller` varchar(100) NOT NULL COMMENT '控制器',
  `model` varchar(100) NOT NULL COMMENT '模型',
  `validate` varchar(100) NOT NULL COMMENT '验证器',
  `ext` varchar(255) DEFAULT NULL COMMENT '序列化值',
  `do_time` datetime DEFAULT NULL COMMENT '命令执行时间',
  `status` tinyint(1) unsigned zerofill NOT NULL DEFAULT '1' COMMENT '执行状态：0失败，1成功',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COMMENT='在线命令管理';

-- -----------------------------
-- Records of `jrk_commands`
-- -----------------------------
INSERT INTO `jrk_commands` VALUES ('3', '1', '生成菜单', 'admin', 'php think make:jrkadmin_curd Article Articles Article --app admin', 'Article', 'Articles', 'Article', '[\"Article\",\"Articles\",\"Article\",\"--app\",\"admin\"]', '2020-08-14 16:24:03', '1', '1597393443', '1597393443');
INSERT INTO `jrk_commands` VALUES ('4', '1', '生成菜单', 'admin', 'php think make:jrkadmin_curd ArticleCate ArticleCates ArticleCate --app admin', 'ArticleCate', 'ArticleCates', 'ArticleCate', '[\"ArticleCate\",\"ArticleCates\",\"ArticleCate\",\"--app\",\"admin\"]', '2020-08-14 16:27:12', '1', '1597393632', '1597393632');
INSERT INTO `jrk_commands` VALUES ('5', '1', '生成菜单', 'admin', 'php think make:jrkadmin_curd ArticleComment ArticleComments ArticleComment --app admin', 'ArticleComment', 'ArticleComments', 'ArticleComment', '[\"ArticleComment\",\"ArticleComments\",\"ArticleComment\",\"--app\",\"admin\"]', '2020-08-14 16:31:07', '1', '1597393867', '1597393867');
INSERT INTO `jrk_commands` VALUES ('6', '1', '生成菜单', 'admin', 'php think make:jrkadmin_curd ArticleModel ArticleModels ArticleModel --app admin', 'ArticleModel', 'ArticleModels', 'ArticleModel', '[\"ArticleModel\",\"ArticleModels\",\"ArticleModel\",\"--app\",\"admin\"]', '2020-08-14 16:32:05', '1', '1597393925', '1597393925');
INSERT INTO `jrk_commands` VALUES ('7', '1', '生成菜单', 'admin', 'php think make:jrkadmin_curd Friendlink Friendlinks Friendlink --app admin', 'Friendlink', 'Friendlinks', 'Friendlink', '[\"Friendlink\",\"Friendlinks\",\"Friendlink\",\"--app\",\"admin\"]', '2020-08-14 16:48:41', '1', '1597394921', '1597394921');
INSERT INTO `jrk_commands` VALUES ('8', '1', '生成菜单', 'admin', 'php think make:jrkadmin_curd ArticleUser ArticleUsers ArticleUser --app admin', 'ArticleUser', 'ArticleUsers', 'ArticleUser', '[\"ArticleUser\",\"ArticleUsers\",\"ArticleUser\",\"--app\",\"admin\"]', '2020-08-17 15:22:18', '1', '1597648938', '1597648938');

-- -----------------------------
-- Table structure for `jrk_friendlinks`
-- -----------------------------
DROP TABLE IF EXISTS `jrk_friendlinks`;
CREATE TABLE `jrk_friendlinks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT '链接名称',
  `url` varchar(150) NOT NULL COMMENT '链接地址',
  `admin_id` int(11) unsigned NOT NULL,
  `site_link` tinyint(1) NOT NULL COMMENT '所属平台, 1=> ''PC'',2=> ''WAP站'',3=> ''小程序'', 4=> ''APP应用''',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1正常0禁止',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='友情链接';

-- -----------------------------
-- Records of `jrk_friendlinks`
-- -----------------------------
INSERT INTO `jrk_friendlinks` VALUES ('2', '测试', 'http://ht.1230t.com/', '1', '1', '1', '1597396368', '1597396368');

-- -----------------------------
-- Table structure for `jrk_member`
-- -----------------------------
DROP TABLE IF EXISTS `jrk_member`;
CREATE TABLE `jrk_member` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_login_time` int(11) unsigned NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `create_ip` varchar(50) DEFAULT NULL,
  `last_login_ip` varchar(50) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `type_id` tinyint(1) NOT NULL DEFAULT '1',
  `sex` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='api 模块测试-会员表';

-- -----------------------------
-- Records of `jrk_member`
-- -----------------------------
INSERT INTO `jrk_member` VALUES ('1', 'hhy@qq.com', 'hhy@qq.com', '$2y$10$nL/lLXYe1qSC/sqLzQ9xpeYmG3vfupCRzGTGcqMEx1lt0YtPG18B2', '1603675607', '1603675572', '127.0.0.1', '127.0.0.1', '1', '1', '0');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='配置分类表';

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

