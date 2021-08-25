-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2021-08-25 11:03:06
-- 服务器版本： 5.7.26
-- PHP 版本： 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `jrk_admin_tp6`
--

-- --------------------------------------------------------

--
-- 表的结构 `jrk_admin`
--

CREATE TABLE `jrk_admin` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(25) NOT NULL COMMENT '用户名',
  `nickname` varchar(25) DEFAULT NULL COMMENT '昵称',
  `avatar` varchar(120) DEFAULT NULL COMMENT '头像',
  `sex` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '0男1女2未知',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态0 拉黑 1正常',
  `login_time` int(11) UNSIGNED DEFAULT '0' COMMENT '登录时间',
  `login_ip` varchar(25) DEFAULT NULL COMMENT '登录IP',
  `token` varchar(150) DEFAULT NULL COMMENT '登录token，需要做单一登录的时候才有',
  `create_time` int(11) UNSIGNED NOT NULL,
  `update_time` int(11) DEFAULT '0',
  `phone` varchar(20) DEFAULT NULL COMMENT '手机号',
  `email` varchar(30) DEFAULT NULL COMMENT '邮箱号',
  `birthday` varchar(80) DEFAULT NULL COMMENT '出生日期',
  `logins` mediumint(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '登录次数',
  `secret` varchar(255) DEFAULT NULL COMMENT '谷歌秘钥',
  `google_url` text COMMENT '谷歌验证二位码'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='后台管理员表' ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `jrk_admin`
--

INSERT INTO `jrk_admin` (`id`, `username`, `nickname`, `avatar`, `sex`, `password`, `status`, `login_time`, `login_ip`, `token`, `create_time`, `update_time`, `phone`, `email`, `birthday`, `logins`, `secret`, `google_url`) VALUES
(1, 'jrkadmintp6', '超级管理员', '/uploads/adminuser/avatar/20200702/5e19638241c47d668ad937cd5fde4847.jpg', 1, '$2y$10$XxyKGjfAtyo5I9.9HBY21O1frCziHTOzuWhhdiDypvUldM24xXVzW', 1, 1629703073, '127.0.0.1', '', 1593179425, 1629703073, '13141962690', 'jackhhy520@qq.com', '1995-06-05', 22, '2NEDPBG2YIM5642L', 'https://api.qrserver.com/v1/create-qr-code/?data=otpauth%3A%2F%2Ftotp%2Fjrkadmintp6%3Fsecret%3D2NEDPBG2YIM5642L&size=200x200&ecc=M'),
(5, 'test', 'test', '/uploads/adminuser/avatar/20210313/c38869c36842c2b686f7913ba394e86c.png', 0, '$2y$10$LNwbAqBCfgjCw9n4e6ND8eqT8jZ0uty2Ih1nN0DxpB1Lx2OofyAte', 1, 1629770327, '127.0.0.1', '', 1615648969, 1629770327, '13141962698', '', '2021-03-17', 2, 'SRKIVUCGTFDXBHO2', 'https://api.qrserver.com/v1/create-qr-code/?data=otpauth%3A%2F%2Ftotp%2Ftest%3Fsecret%3DSRKIVUCGTFDXBHO2&size=200x200&ecc=M');

-- --------------------------------------------------------

--
-- 表的结构 `jrk_articles`
--

CREATE TABLE `jrk_articles` (
  `id` int(11) UNSIGNED NOT NULL,
  `cate_id` int(11) NOT NULL COMMENT '栏目ID',
  `title` varchar(180) NOT NULL COMMENT '标题',
  `title_color` varchar(255) DEFAULT NULL COMMENT '标题颜色',
  `range` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '文章等级',
  `keywords` varchar(255) DEFAULT NULL COMMENT '关键词',
  `description` varchar(255) NOT NULL COMMENT '文章描述',
  `img_url` varchar(255) DEFAULT NULL COMMENT '封面图',
  `author` varchar(90) NOT NULL COMMENT '作者',
  `origin` varchar(90) NOT NULL DEFAULT '原创' COMMENT '原创或者转载',
  `content` mediumtext NOT NULL COMMENT '内容',
  `hits` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '点击量',
  `love` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '喜欢量',
  `comment_num` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '评论数量',
  `is_recommend` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '1是0否，是否推荐',
  `is_top` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '1是0否，是否置顶',
  `is_show` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1是0否，是否在栏目显示',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1正常，0删除',
  `url` varchar(255) DEFAULT NULL COMMENT '地址或者链接',
  `create_time` int(11) UNSIGNED NOT NULL,
  `update_time` int(11) DEFAULT '0',
  `delete_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '删除时间，软删除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='文章表';

--
-- 转存表中的数据 `jrk_articles`
--

INSERT INTO `jrk_articles` (`id`, `cate_id`, `title`, `title_color`, `range`, `keywords`, `description`, `img_url`, `author`, `origin`, `content`, `hits`, `love`, `comment_num`, `is_recommend`, `is_top`, `is_show`, `status`, `url`, `create_time`, `update_time`, `delete_time`) VALUES
(1, 2, '测试标题', '', 0, '奥德赛大所,123', '&lt;p&gt;搭搭撒撒多&lt;/p&gt;&lt;p&gt;大萨达撒多撒&lt;/p&gt;&lt;p&gt;打撒大大&lt;/p&gt;&lt;p&gt;国风大赏...', '', 'jrkadmintp6', '原创', '<p>搭搭撒撒多</p><p>大萨达撒多撒</p><p>打撒大大</p><p>国风大赏鬼地方个地方</p><p>gfhgfjhghgjgh萨顶顶撒奥</p><p>更大的郭德纲的观点</p>', 0, 0, 0, 0, 0, 1, 1, '', 1597219278, 1597224466, 1597224466),
(2, 2, '大萨达十大大萨达撒', '#2B6199', 4, '敖德萨多', '阿达打算', '/uploads/attachment/images/20200817/929662552e9dbbf4926d7be6853ea00a.jpg', 'jrkadmintp6', '原创', '# 敖德萨多撒\n### 大萨达\n> 奥德赛大\n\n##### 达大撒多所', 11, 11, 12, 2, 0, 1, 1, '/index/article/show.html?id=2', 1597219392, 1615649184, 0),
(3, 2, 'xxxxx', '#00060a', 0, 'xxx', 'sdasd', '/uploads/attachment/images/20210823/49f396058080bb4d48c7d84f54004113.jpg', 'test', '原创', '<p>dsadasdasadsadsasd</p>', 0, 0, 0, 2, 0, 1, 1, '/index/article/show.html?id=3', 1629772437, 1629772437, 0),
(4, 2, 'xasdxasx', '#00060a', 3, 'xsxs', 'dasdasdasdasdasd', '/uploads/article/images/20200817/ff08af9f69367ac0f041b17968ff5efb.jpeg', 'test', '原创', '<p>asdasdasdasdasdasdasdasdasdasdasd</p>', 0, 0, 0, 2, 0, 1, 1, '/index/article/show.html?id=4', 1629772736, 1629772736, 0);

-- --------------------------------------------------------

--
-- 表的结构 `jrk_articles_cate`
--

CREATE TABLE `jrk_articles_cate` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL COMMENT '栏目名称',
  `url` varchar(200) NOT NULL COMMENT '栏目地址',
  `param` varchar(255) DEFAULT NULL COMMENT '参数',
  `pid` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'pID',
  `model_id` int(25) NOT NULL COMMENT '模型ID',
  `is_show` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '0不显示1显示',
  `sort` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
  `description` varchar(255) DEFAULT NULL COMMENT '栏目描述',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='文章栏目表';

--
-- 转存表中的数据 `jrk_articles_cate`
--

INSERT INTO `jrk_articles_cate` (`id`, `name`, `url`, `param`, `pid`, `model_id`, `is_show`, `sort`, `description`, `create_time`, `update_time`) VALUES
(1, '技术分享', '/index/articles/index.html?cate=1', '{\"cate\":\"1\"}', 0, 2, 1, 10, '111', 1597195786, 1597195786),
(2, 'php', '/index/videos/lists.html?cate=2', '{\"cate\":\"2\"}', 1, 6, 1, 10, '111', 1597197517, 1597203519);

-- --------------------------------------------------------

--
-- 表的结构 `jrk_articles_comment`
--

CREATE TABLE `jrk_articles_comment` (
  `id` int(11) UNSIGNED NOT NULL,
  `article_id` int(11) NOT NULL COMMENT '文章ID',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `cate_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `pid` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '评论的上级用户ID',
  `content` varchar(255) NOT NULL COMMENT '评论内容',
  `ip` varchar(100) NOT NULL COMMENT '评论IP',
  `browser` varchar(255) DEFAULT NULL COMMENT '浏览器',
  `os` varchar(255) DEFAULT NULL COMMENT '系统',
  `is_show` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '0不显示1显示',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '0未审核1已审核'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='文章评论表';

--
-- 转存表中的数据 `jrk_articles_comment`
--

INSERT INTO `jrk_articles_comment` (`id`, `article_id`, `user_id`, `cate_id`, `pid`, `content`, `ip`, `browser`, `os`, `is_show`, `create_time`, `update_time`, `status`) VALUES
(1, 2, 1, 2, 0, '测试内容dsasadsad', '127.0.0.1', 'cent', 'windows', 1, 1597219278, 1597327984, 1),
(2, 2, 2, 2, 1, '回复上级的测试内容', '127.0.0.1', 'cent', 'windows', 1, 1597219278, 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `jrk_articles_models`
--

CREATE TABLE `jrk_articles_models` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '模型名称',
  `tablename` char(20) NOT NULL DEFAULT '' COMMENT '表名',
  `index_template` char(30) NOT NULL DEFAULT 'index' COMMENT '封面页模板',
  `list_template` char(30) NOT NULL DEFAULT 'list' COMMENT '列表模板',
  `show_template` char(30) NOT NULL DEFAULT 'show' COMMENT '详情页模板',
  `sort` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'asc 排序',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  `ip` varchar(80) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='模型表';

--
-- 转存表中的数据 `jrk_articles_models`
--

INSERT INTO `jrk_articles_models` (`id`, `name`, `tablename`, `index_template`, `list_template`, `show_template`, `sort`, `create_time`, `update_time`, `ip`) VALUES
(1, '单页模型', 'page', 'index', 'list', 'show', 2, 1583305903, 0, ''),
(2, '文章模型', 'articles', 'index', 'list', 'show', 10, 1583305903, 0, ''),
(3, '图集模型', 'picture', 'index', 'list', 'show', 3, 1583305903, 0, ''),
(4, '链接模型', 'link', 'index', 'list', 'show', 5, 1583305903, 0, ''),
(5, '下载模型', 'downloads', 'index', 'list', 'show', 4, 1583305903, 0, ''),
(6, '视频模型', 'videos', 'index', 'list', 'show', 0, 1583305903, 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `jrk_articles_user`
--

CREATE TABLE `jrk_articles_user` (
  `id` int(11) UNSIGNED NOT NULL,
  `nickname` varchar(100) NOT NULL COMMENT '昵称',
  `avatar` varchar(255) NOT NULL COMMENT '头像',
  `qq` varchar(25) NOT NULL COMMENT 'qq',
  `os` varchar(100) DEFAULT NULL COMMENT '系统',
  `browser` varchar(100) DEFAULT NULL COMMENT '浏览器',
  `ip` varchar(50) DEFAULT NULL COMMENT 'IP',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1正常0拉黑',
  `zan` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '点赞数',
  `fen` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '积分'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='文章用户表';

--
-- 转存表中的数据 `jrk_articles_user`
--

INSERT INTO `jrk_articles_user` (`id`, `nickname`, `avatar`, `qq`, `os`, `browser`, `ip`, `create_time`, `update_time`, `status`, `zan`, `fen`) VALUES
(1, '邵东丶贺哥', 'http://q.qlogo.cn/headimg_dl?dst_uin=2237696522&spec=100', '2237696522', 'windows', 'Chrome/80.0.3987.163', '127.0.0.1', 1597324041, 1597324041, 1, 0, 0),
(2, 'JrkAdmin', 'http://q.qlogo.cn/headimg_dl?dst_uin=1668862539&spec=100', '1668862539', 'windows', 'Chrome/80.0.3987.163', '127.0.0.1', 1597324832, 1597324832, 1, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `jrk_attachment`
--

CREATE TABLE `jrk_attachment` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '附件名称',
  `att_dir` varchar(200) NOT NULL DEFAULT '' COMMENT '附件路径',
  `satt_dir` varchar(200) DEFAULT NULL COMMENT '压缩图片路径',
  `size` char(30) NOT NULL DEFAULT '' COMMENT '附件大小',
  `img_dir` varchar(100) NOT NULL DEFAULT '' COMMENT '图片存储的文件夹',
  `type` char(30) NOT NULL DEFAULT '' COMMENT '附件类型',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '上传时间',
  `image_type` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '图片上传类型 1本地 2七牛云 3OSS 4COS ',
  `module_type` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '图片上传模块类型 1 后台上传 2 用户生成',
  `update_time` int(11) UNSIGNED DEFAULT '0',
  `ext` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='附件管理表' ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `jrk_attachment`
--

INSERT INTO `jrk_attachment` (`id`, `name`, `att_dir`, `satt_dir`, `size`, `img_dir`, `type`, `create_time`, `image_type`, `module_type`, `update_time`, `ext`) VALUES
(1, 'c7761412650fbc743b9cf26d995054f2.jpg', '/uploads/attachment/images/20200702/c7761412650fbc743b9cf26d995054f2.jpg', '/uploads/attachment/images/20200702/c7761412650fbc743b9cf26d995054f2.jpg', '370198', 'attachment/images', 'image/jpeg', 1593678336, 1, 1, 1593678336, 'jpeg'),
(2, 'f0253fbbd7e198bbfe7cdc825c0d7bd0.jpg', '/uploads/attachment/images/20200702/f0253fbbd7e198bbfe7cdc825c0d7bd0.jpg', '/uploads/attachment/images/20200702/f0253fbbd7e198bbfe7cdc825c0d7bd0.jpg', '275219', 'attachment/images', 'image/jpeg', 1593680457, 1, 1, 1593680457, 'jpg'),
(3, 'ad0d4cf96c124f7ecd1c5a8307eb6101.txt', '/uploads/attachment/files/20200702/ad0d4cf96c124f7ecd1c5a8307eb6101.txt', '', '4481', 'attachment/files', 'text/plain', 1593680776, 1, 1, 1593680776, 'txt'),
(4, '7ac160ff6f9b3b798d1d3174ab379cb6.jpeg', '/uploads/adminuser/avatar/20200702/7ac160ff6f9b3b798d1d3174ab379cb6.jpeg', '/uploads/adminuser/avatar/20200702/7ac160ff6f9b3b798d1d3174ab379cb6.jpeg', '156571', 'adminuser/avatar', 'image/jpeg', 1593694575, 1, 1, 1593694575, 'jpeg'),
(5, '91a0b83b7e61d518a7a3ceee6cf53491.jpg', '/uploads/adminuser/avatar/20200702/91a0b83b7e61d518a7a3ceee6cf53491.jpg', '/uploads/adminuser/avatar/20200702/91a0b83b7e61d518a7a3ceee6cf53491.jpg', '37399', 'adminuser/avatar', 'image/jpg', 1593694742, 1, 1, 1593694742, 'jpg'),
(6, '5e19638241c47d668ad937cd5fde4847.jpg', '/uploads/adminuser/avatar/20200702/5e19638241c47d668ad937cd5fde4847.jpg', '/uploads/adminuser/avatar/20200702/5e19638241c47d668ad937cd5fde4847.jpg', '119892', 'adminuser/avatar', 'image/jpeg', 1593695855, 1, 1, 1593695855, 'jpg'),
(7, '9fb56f259b55337ef9f1f2ac90d0dcab.jpg', '/uploads/adminuser/avatar/20200814/9fb56f259b55337ef9f1f2ac90d0dcab.jpg', '/uploads/adminuser/avatar/20200814/9fb56f259b55337ef9f1f2ac90d0dcab.jpg', '66243', 'adminuser/avatar', 'image/jpeg', 1597386063, 1, 1, 1597386063, 'jpg'),
(8, '929662552e9dbbf4926d7be6853ea00a.jpg', '/uploads/attachment/images/20200817/929662552e9dbbf4926d7be6853ea00a.jpg', '/uploads/attachment/images/20200817/929662552e9dbbf4926d7be6853ea00a.jpg', '168009', 'attachment/images', 'image/jpeg', 1597633346, 1, 1, 1597633346, 'jpg'),
(9, 'ff08af9f69367ac0f041b17968ff5efb.jpeg', '/uploads/article/images/20200817/ff08af9f69367ac0f041b17968ff5efb.jpeg', '/uploads/article/images/20200817/ff08af9f69367ac0f041b17968ff5efb.jpeg', '1687469', 'article/images', 'image/jpeg', 1597633355, 1, 1, 1597633355, 'jpeg'),
(10, 'c6a42c6da171515a2385965503f72c1d.txt', '/uploads/attachment/files/20201026/c6a42c6da171515a2385965503f72c1d.txt', '', '17', 'attachment/files', 'text/plain', 1603715063, 1, 1, 1603715063, 'txt'),
(11, '226064c96335b956e9772638ca6a9bd0.txt', '/uploads/attachment/files/20201026/226064c96335b956e9772638ca6a9bd0.txt', '', '17', 'attachment/files', 'text/plain', 1603715155, 1, 1, 1603715155, 'txt'),
(12, 'e59c56d844bb93c87588ef2534a9df44.txt', '/uploads/attachment/files/20201026/e59c56d844bb93c87588ef2534a9df44.txt', '', '17', 'attachment/files', 'text/plain', 1603715239, 1, 1, 1603715239, 'txt'),
(13, '6efd5cdd633c8925d38ffae5aab6e055.txt', '/uploads/attachment/files/20201026/6efd5cdd633c8925d38ffae5aab6e055.txt', '', '17', 'attachment/files', 'text/plain', 1603715291, 1, 1, 1603715291, 'txt'),
(14, '7afacb819fb8a41a54d3d41f7c75b78c.txt', '/uploads/attachment/files/20201026/7afacb819fb8a41a54d3d41f7c75b78c.txt', '', '17', 'attachment/files', 'text/plain', 1603716388, 1, 1, 1603716388, 'txt'),
(15, '8aea3d1a1cf4529600c47b0378d17e68.txt', '/uploads/attachment/files/20201026/8aea3d1a1cf4529600c47b0378d17e68.txt', '', '17', 'attachment/files', 'text/plain', 1603716570, 1, 1, 1603716570, 'txt'),
(16, 'd42ea01b59c8b0144b9b335941ffed70.txt', '/uploads/attachment/files/20201026/d42ea01b59c8b0144b9b335941ffed70.txt', '', '17', 'attachment/files', 'text/plain', 1603716612, 1, 1, 1603716612, 'txt'),
(17, 'c38869c36842c2b686f7913ba394e86c.png', '/uploads/adminuser/avatar/20210313/c38869c36842c2b686f7913ba394e86c.png', '/uploads/adminuser/avatar/20210313/c38869c36842c2b686f7913ba394e86c.png', '202953', 'adminuser/avatar', 'image/png', 1615648940, 1, 1, 1615648940, 'png'),
(18, '81fea32fb9c7fb0a1c81d3cd8450f4a4.png', '/uploads/attachment/images/20210823/81fea32fb9c7fb0a1c81d3cd8450f4a4.png', '/uploads/attachment/images/20210823/81fea32fb9c7fb0a1c81d3cd8450f4a4.png', '258545', 'attachment/images', 'image/png', 1629703372, 1, 1, 1629703372, 'png'),
(19, '49f396058080bb4d48c7d84f54004113.jpg', '/uploads/attachment/images/20210823/49f396058080bb4d48c7d84f54004113.jpg', '/uploads/attachment/images/20210823/49f396058080bb4d48c7d84f54004113.jpg', '6449', 'attachment/images', 'image/jpeg', 1629703372, 1, 1, 1629703372, 'jpg'),
(20, '06b5939d679d189fb38ec3c5496d1f52.png', '/uploads/article/images/20210824/06b5939d679d189fb38ec3c5496d1f52.png', '/uploads/article/images/20210824/06b5939d679d189fb38ec3c5496d1f52.png', '159303', 'article/images', 'image/png', 1629770584, 1, 1, 1629770584, 'png');

-- --------------------------------------------------------

--
-- 表的结构 `jrk_auth_group`
--

CREATE TABLE `jrk_auth_group` (
  `id` int(8) UNSIGNED NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态1正常0拉黑',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '角色组',
  `rules` text COMMENT '权限',
  `pid` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='角色组管理' ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `jrk_auth_group`
--

INSERT INTO `jrk_auth_group` (`id`, `create_time`, `update_time`, `status`, `title`, `rules`, `pid`) VALUES
(1, 1593248783, 0, 1, '超级管理', 'all', 0),
(3, 1629688335, 1629688335, 1, '文章', '2,34,35,36,46,47,61,62,63,64,48,60,49,57,58,59,50,54,55,56,52,53', 1);

-- --------------------------------------------------------

--
-- 表的结构 `jrk_auth_group_access`
--

CREATE TABLE `jrk_auth_group_access` (
  `id` int(11) UNSIGNED NOT NULL,
  `uid` mediumint(8) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL,
  `create_time` int(11) DEFAULT '0' COMMENT '添加时间',
  `update_time` int(11) DEFAULT '0' COMMENT '修改时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='权限关系表' ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `jrk_auth_group_access`
--

INSERT INTO `jrk_auth_group_access` (`id`, `uid`, `group_id`, `create_time`, `update_time`) VALUES
(1, 2, 2, 1593248783, 0),
(2, 4, 2, 1597930242, 0),
(3, 3, 2, 1615645565, 0),
(4, 5, 3, 1629688361, 0);

-- --------------------------------------------------------

--
-- 表的结构 `jrk_auth_rule`
--

CREATE TABLE `jrk_auth_rule` (
  `id` int(11) UNSIGNED NOT NULL,
  `pid` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父ID',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '控制器/方法',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '菜单名称',
  `type` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1菜单 2按钮',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '菜单状态0 禁止 1正常',
  `condition` char(100) DEFAULT '',
  `sort` mediumint(8) NOT NULL DEFAULT '0' COMMENT '排序',
  `auth_open` tinyint(2) UNSIGNED DEFAULT '1' COMMENT '1 需验证 2不需验证',
  `icon` varchar(50) DEFAULT '' COMMENT '图标',
  `font_family` varchar(25) NOT NULL DEFAULT 'fa' COMMENT '图标类型',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(11) UNSIGNED DEFAULT '0' COMMENT '更新时间',
  `param` varchar(50) DEFAULT '' COMMENT '参数'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='菜单表' ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `jrk_auth_rule`
--

INSERT INTO `jrk_auth_rule` (`id`, `pid`, `name`, `title`, `type`, `status`, `condition`, `sort`, `auth_open`, `icon`, `font_family`, `create_time`, `update_time`, `param`) VALUES
(1, 2, 'AuthRule/index', '菜单规则', 1, 1, '', 98, 1, 'fa-home', 'fa', 1593354333, 1593354333, ''),
(2, 0, '', '权限管理', 1, 1, '', 90, 1, 'fa-cog', 'fa', 1593352451, 1593352729, ''),
(3, 1, 'AuthRule/addAuth', '新增', 2, 1, '', 30, 1, '', 'fa', 1593353629, 1593353629, ''),
(4, 1, 'AuthRule/addSon', '新增子菜单', 2, 1, '', 10, 1, '', 'fa', 1593354311, 1593509572, ''),
(5, 1, 'AuthRule/del', '删除', 2, 1, '', 20, 1, '', 'fa', 1593354333, 1593354333, ''),
(6, 2, 'AuthGroup/index', '角色组', 1, 1, '', 100, 1, 'fa-address-book-o', 'fa', 1593441632, 1593441632, ''),
(9, 33, 'Admin/addAdmin', '添加', 2, 1, '', 0, 1, '', 'fa', 1593508446, 1593508446, ''),
(10, 33, 'Admin/del', '删除', 2, 1, '', 0, 1, '', 'fa', 1593508463, 1593508463, ''),
(11, 33, 'Admin/addAdmin', '编辑', 2, 1, '', 0, 1, '', 'fa', 1593508493, 1593508986, ''),
(12, 6, 'AuthGroup/userGroup', '角色授权', 2, 1, '', 0, 1, '', 'fa', 1593508559, 1593508559, ''),
(13, 6, 'AuthGroup/addGroups', '添加和编辑', 2, 1, '', 0, 1, '', 'fa', 1593508580, 1597931278, ''),
(14, 6, 'AuthGroup/del', '删除', 2, 1, '', 0, 1, '', 'fa', 1593508598, 1593508598, ''),
(16, 0, '', '数据备份', 1, 1, '', 0, 2, 'fa-bank', 'fa', 1593570323, 1593570323, ''),
(17, 16, 'DataBackup/index', '数据表列表', 1, 1, '', 0, 2, 'fa-align-left', 'fa', 1593570431, 1593570431, ''),
(18, 16, 'DataBackup/importlist', '备份列表', 1, 1, '', 0, 2, 'fa-align-right', 'fa', 1593573590, 1593573590, ''),
(25, 1, 'AuthRule/addNode', '添加节点', 2, 1, '', 0, 1, '', 'fa', 1593661475, 0, ''),
(26, 0, '', '系统管理', 1, 1, '', 0, 1, 'fa-cogs', 'fa', 1593661642, 1593661642, ''),
(27, 26, 'AttachMents/index', '附件管理', 1, 1, '', 0, 1, 'fa-link', 'fa', 1593661815, 1593661815, ''),
(28, 26, 'SystemLog/index', '日志管理', 1, 1, '', 0, 1, 'fa-book', 'fa', 1593669289, 1593669289, ''),
(29, 28, 'SystemLog/del', '删除', 2, 1, '', 0, 1, '', 'fa', 1593669410, 0, ''),
(30, 27, 'AttachMents/uploadAttachment', '上传', 2, 1, '', 0, 1, '', 'fa', 1593670168, 0, ''),
(31, 27, 'AttachMents/del', '删除', 2, 1, '', 0, 1, '', 'fa', 1593670168, 0, ''),
(32, 27, 'AttachMents/download', '打包下载', 2, 1, '', 0, 1, '', 'fa', 1593680898, 0, ''),
(33, 2, 'Admin/index', '管理员管理', 1, 1, '', 0, 1, 'fa-address-book', 'fa', 1593692881, 1593692881, ''),
(34, 2, '', '基本设置', 1, 1, '', 0, 1, 'fa-address-book-o', 'fa', 1593693025, 1593693025, ''),
(35, 34, 'Admin/baseData', '基本资料', 1, 1, '', 0, 1, 'fa-address-card', 'fa', 1593693110, 1593693233, ''),
(36, 34, 'Admin/changPass', '修改密码', 1, 1, '', 0, 1, 'fa-amazon', 'fa', 1593693191, 1593693191, ''),
(37, 0, '', '模块管理', 1, 1, '', 0, 1, 'fa-book', 'fa', 1596108938, 1596108938, ''),
(38, 37, '', '站长推送', 1, 1, '', 0, 1, 'fa-adn', 'fa', 1596108969, 1596108969, ''),
(39, 38, 'Push/bindex', '百度推送', 1, 1, '', 0, 1, 'fa-ban', 'fa', 1596109006, 1596109006, ''),
(40, 38, 'Push/xindex', '熊掌推送', 1, 1, '', 0, 1, 'fa-external-link', 'fa', 1596109037, 1596109037, ''),
(41, 37, 'queue.queue/index', '定时任务', 1, 1, '', 0, 1, 'fa-align-center', 'fa', 1596110140, 1596110140, ''),
(42, 26, '', '系统配置', 1, 1, '', 0, 1, 'fa-bullseye', 'fa', 1596111745, 1596111745, ''),
(43, 42, 'config.Sysconfig/index', '配置列表', 1, 1, '', 0, 1, 'fa-bank', 'fa', 1596111773, 1596111773, ''),
(44, 42, 'config.Sysconfigtab/index', '配置分类', 1, 1, '', 0, 1, 'fa-amazon', 'fa', 1596111801, 1596111801, ''),
(45, 37, 'Command/index', 'CURD命令', 1, 1, '', 0, 1, 'fa-behance', 'fa', 1597392241, 1597392241, ''),
(46, 0, '', '内容管理', 1, 1, '', 0, 1, 'fa-align-justify', 'fa', 1597394661, 1597394661, ''),
(47, 46, 'Article/index', '文章列表', 1, 1, '', 0, 1, 'fa-bars', 'fa', 1597394695, 1597394695, ''),
(48, 46, 'ArticleModel/index', '文章模型', 1, 1, '', 0, 1, 'fa-bomb', 'fa', 1597394752, 1597394752, ''),
(49, 46, 'ArticleCate/index', '文章栏目', 1, 1, '', 0, 1, 'fa-amazon', 'fa', 1597394826, 1597394826, ''),
(50, 46, 'ArticleComment/index', '文章评论', 1, 1, '', 0, 1, 'fa-bullhorn', 'fa', 1597394856, 1597394856, ''),
(51, 37, 'Friendlink/index', '友情链接', 1, 1, '', 0, 1, 'fa-chain', 'fa', 1597394895, 1597394895, ''),
(52, 46, 'ArticleUser/index', '内容用户', 1, 1, '', 0, 1, 'fa-address-book-o', 'fa', 1597649685, 1597649685, ''),
(53, 52, 'ArticleUser/del', '删除', 2, 1, '', 0, 1, '', 'fa', 1597650267, 0, ''),
(54, 50, 'ArticleComment/del', '删除', 2, 1, '', 0, 1, '', 'fa', 1597650331, 0, ''),
(55, 50, 'ArticleComment/edit', '编辑', 2, 1, '', 0, 1, '', 'fa', 1597650331, 0, ''),
(56, 50, 'ArticleComment/check', '审核', 2, 1, '', 0, 1, '', 'fa', 1597650331, 0, ''),
(57, 49, 'ArticleCate/edit', '编辑', 2, 1, '', 0, 1, '', 'fa', 1597650386, 0, ''),
(58, 49, 'ArticleCate/del', '删除', 2, 1, '', 0, 1, '', 'fa', 1597650386, 0, ''),
(59, 49, 'ArticleCate/add', '新增', 2, 1, '', 0, 1, '', 'fa', 1597650386, 0, ''),
(60, 48, 'ArticleModel/edit', '编辑', 2, 1, '', 0, 1, '', 'fa', 1597650417, 0, ''),
(61, 47, 'Article/edit', '编辑', 2, 1, '', 0, 1, '', 'fa', 1597650476, 0, ''),
(62, 47, 'Article/del', '删除', 2, 1, '', 0, 1, '', 'fa', 1597650476, 0, ''),
(63, 47, 'Article/add', '新增', 2, 1, '', 0, 1, '', 'fa', 1597650476, 0, ''),
(64, 47, 'Article/recycle', '回收站', 2, 1, '', 0, 1, '', 'fa', 1597650476, 0, ''),
(65, 51, 'Friendlink/edit', '编辑', 2, 1, '', 0, 1, '', 'fa', 1597650538, 0, ''),
(66, 51, 'Friendlink/add', '新增', 2, 1, '', 0, 1, '', 'fa', 1597650538, 0, ''),
(67, 51, 'Friendlink/del', '删除', 2, 1, '', 0, 1, '', 'fa', 1597650538, 0, ''),
(68, 45, 'Command/del', '删除', 2, 1, '', 0, 1, '', 'fa', 1597650591, 0, ''),
(69, 45, 'Command/add', '新增', 2, 1, '', 0, 1, '', 'fa', 1597650591, 0, ''),
(70, 6, 'AuthGroup/getRoles', '获取授权菜单', 2, 1, '', 0, 1, '', 'fa', 1597931377, 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `jrk_commands`
--

CREATE TABLE `jrk_commands` (
  `id` int(11) UNSIGNED NOT NULL,
  `admin_id` int(11) NOT NULL COMMENT '执行者',
  `name` varchar(80) DEFAULT NULL,
  `app` varchar(255) NOT NULL DEFAULT 'admin' COMMENT '模块名',
  `command` varchar(255) NOT NULL COMMENT '命令',
  `controller` varchar(100) NOT NULL COMMENT '控制器',
  `model` varchar(100) NOT NULL COMMENT '模型',
  `validate` varchar(100) NOT NULL COMMENT '验证器',
  `ext` varchar(255) DEFAULT NULL COMMENT '序列化值',
  `do_time` datetime DEFAULT NULL COMMENT '命令执行时间',
  `status` tinyint(1) UNSIGNED ZEROFILL NOT NULL DEFAULT '1' COMMENT '执行状态：0失败，1成功',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='在线命令管理';

-- --------------------------------------------------------

--
-- 表的结构 `jrk_friendlinks`
--

CREATE TABLE `jrk_friendlinks` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL COMMENT '链接名称',
  `url` varchar(150) NOT NULL COMMENT '链接地址',
  `admin_id` int(11) UNSIGNED NOT NULL,
  `site_link` tinyint(1) NOT NULL COMMENT '所属平台, 1=> ''PC'',2=> ''WAP站'',3=> ''小程序'', 4=> ''APP应用''',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1正常0禁止',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='友情链接';

--
-- 转存表中的数据 `jrk_friendlinks`
--

INSERT INTO `jrk_friendlinks` (`id`, `name`, `url`, `admin_id`, `site_link`, `status`, `create_time`, `update_time`) VALUES
(2, '测试', 'http://www.lovegyl.cn', 1, 1, 1, 1597396368, 1615646047);

-- --------------------------------------------------------

--
-- 表的结构 `jrk_member`
--

CREATE TABLE `jrk_member` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_login_time` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `create_ip` varchar(50) DEFAULT NULL,
  `last_login_ip` varchar(50) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `type_id` tinyint(1) NOT NULL DEFAULT '1',
  `sex` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='api 模块测试-会员表';

--
-- 转存表中的数据 `jrk_member`
--

INSERT INTO `jrk_member` (`id`, `username`, `email`, `password`, `last_login_time`, `create_time`, `create_ip`, `last_login_ip`, `status`, `type_id`, `sex`) VALUES
(1, 'hhy@qq.com', 'hhy@qq.com', '$2y$10$nL/lLXYe1qSC/sqLzQ9xpeYmG3vfupCRzGTGcqMEx1lt0YtPG18B2', 1629701341, 1603675572, '127.0.0.1', '127.0.0.1', 1, 1, 0),
(2, '123@qq.com', '123@qq.com', '$2y$10$e66TXb2CLC.5ruhyTO3qHeGkgHO6hfGu1FJAFjWp0lJfJpwGoJ3J6', 1629702209, 1629702209, '127.0.0.1', '127.0.0.1', 1, 1, 0),
(3, '12ss3@qq.com', '12ss3@qq.com', '$2y$10$pj1/FXfkGDTmWAdDY9bXfO2pl0Al9kJSNf.5k43YLvMDLbX/Bwyl6', 1629702294, 1629702294, '127.0.0.1', '127.0.0.1', 1, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `jrk_system_log_202108`
--

CREATE TABLE `jrk_system_log_202108` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'ID',
  `admin_id` int(10) UNSIGNED DEFAULT '0' COMMENT '管理员ID',
  `url` varchar(1500) NOT NULL DEFAULT '' COMMENT '操作页面',
  `method` varchar(50) NOT NULL COMMENT '请求方法',
  `title` varchar(100) DEFAULT '' COMMENT '日志标题',
  `content` text NOT NULL COMMENT '内容',
  `ip` varchar(50) NOT NULL DEFAULT '' COMMENT 'IP',
  `useragent` varchar(255) DEFAULT '' COMMENT 'User-Agent',
  `os` varchar(100) DEFAULT '' COMMENT 'os',
  `brower` varchar(100) DEFAULT '' COMMENT 'brower',
  `create_time` int(10) DEFAULT NULL COMMENT '操作时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='后台操作日志表 - 202108' ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `jrk_system_log_202108`
--

INSERT INTO `jrk_system_log_202108` (`id`, `admin_id`, `url`, `method`, `title`, `content`, `ip`, `useragent`, `os`, `brower`, `create_time`) VALUES
(10, 1, '/admin/SystemLog/del.html', 'post', '超级管理员', 'a:2:{s:2:\"id\";a:9:{i:0;s:1:\"9\";i:1;s:1:\"8\";i:2;s:1:\"7\";i:3;s:1:\"6\";i:4;s:1:\"5\";i:5;s:1:\"4\";i:6;s:1:\"3\";i:7;s:1:\"2\";i:8;s:1:\"1\";}s:5:\"times\";s:0:\"\";}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36', 'windows', 'Chrome/86.0.4240.198', 1629703391),
(11, 1, '/admin/Command/del.html', 'post', '超级管理员', 'a:1:{s:3:\"ids\";s:11:\"3,4,5,6,7,8\";}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36', 'windows', 'Chrome/86.0.4240.198', 1629703406),
(12, 1, '/admin/DataBackup/export.html', 'post', '超级管理员', 'a:1:{s:6:\"tables\";a:18:{i:0;s:9:\"jrk_admin\";i:1;s:12:\"jrk_articles\";i:2;s:17:\"jrk_articles_cate\";i:3;s:20:\"jrk_articles_comment\";i:4;s:19:\"jrk_articles_models\";i:5;s:17:\"jrk_articles_user\";i:6;s:14:\"jrk_attachment\";i:7;s:14:\"jrk_auth_group\";i:8;s:21:\"jrk_auth_group_access\";i:9;s:13:\"jrk_auth_rule\";i:10;s:12:\"jrk_commands\";i:11;s:15:\"jrk_friendlinks\";i:12;s:10:\"jrk_member\";i:13;s:14:\"jrk_sys_config\";i:14;s:18:\"jrk_sys_config_tab\";i:15;s:13:\"jrk_sys_queue\";i:16;s:21:\"jrk_system_log_202108\";i:17;s:14:\"jrk_user_token\";}}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36', 'windows', 'Chrome/86.0.4240.198', 1629705102),
(13, 5, '/admin/login/loginCheck.html', 'post', 'test', 'a:3:{s:8:\"username\";s:4:\"test\";s:9:\"__token__\";s:32:\"28359214dcf7ddecd944f0d383987118\";s:7:\"captcha\";s:3:\"xxw\";}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36', 'windows', 'Chrome/86.0.4240.198', 1629770327),
(14, 5, '/admin/Common/UpArticlePic.html', 'post', 'test', 'a:0:{}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36', 'windows', 'Chrome/86.0.4240.198', 1629770584),
(15, 5, '/admin/Article/upAndAdd.html', 'post', 'test', 'a:16:{s:7:\"cate_id\";s:1:\"2\";s:5:\"title\";s:9:\"asdasdasd\";s:11:\"title_color\";s:7:\"#00060a\";s:5:\"range\";s:1:\"4\";s:7:\"img_url\";s:71:\"/uploads/adminuser/avatar/20200702/5e19638241c47d668ad937cd5fde4847.jpg\";s:4:\"file\";s:0:\"\";s:8:\"keywords\";s:4:\"xxxx\";s:11:\"description\";s:9:\"sdaasdasd\";s:7:\"is_show\";s:1:\"1\";s:6:\"is_top\";s:1:\"0\";s:6:\"author\";s:4:\"test\";s:4:\"hits\";s:1:\"0\";s:6:\"origin\";s:6:\"原创\";s:3:\"url\";s:0:\"\";s:12:\"is_recommend\";s:1:\"2\";s:7:\"content\";s:34:\"&lt;p&gt;dasasdasdasdasd&lt;/p&gt;\";}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36', 'windows', 'Chrome/86.0.4240.198', 1629770982),
(16, 5, '/admin/Article/upAndAdd.html', 'post', 'test', 'a:16:{s:7:\"cate_id\";s:1:\"2\";s:5:\"title\";s:9:\"asdasdasd\";s:11:\"title_color\";s:7:\"#00060a\";s:5:\"range\";s:1:\"4\";s:7:\"img_url\";s:71:\"/uploads/adminuser/avatar/20200702/5e19638241c47d668ad937cd5fde4847.jpg\";s:4:\"file\";s:0:\"\";s:8:\"keywords\";s:4:\"xxxx\";s:11:\"description\";s:9:\"sdaasdasd\";s:7:\"is_show\";s:1:\"1\";s:6:\"is_top\";s:1:\"0\";s:6:\"author\";s:4:\"test\";s:4:\"hits\";s:1:\"0\";s:6:\"origin\";s:6:\"原创\";s:3:\"url\";s:0:\"\";s:12:\"is_recommend\";s:1:\"2\";s:7:\"content\";s:34:\"&lt;p&gt;dasasdasdasdasd&lt;/p&gt;\";}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36', 'windows', 'Chrome/86.0.4240.198', 1629770987),
(17, 5, '/admin/Article/upAndAdd.html', 'post', 'test', 'a:16:{s:7:\"cate_id\";s:1:\"2\";s:5:\"title\";s:9:\"asdasdasd\";s:11:\"title_color\";s:7:\"#00060a\";s:5:\"range\";s:1:\"4\";s:7:\"img_url\";s:71:\"/uploads/adminuser/avatar/20200702/5e19638241c47d668ad937cd5fde4847.jpg\";s:4:\"file\";s:0:\"\";s:8:\"keywords\";s:4:\"xxxx\";s:11:\"description\";s:9:\"sdaasdasd\";s:7:\"is_show\";s:1:\"1\";s:6:\"is_top\";s:1:\"0\";s:6:\"author\";s:4:\"test\";s:4:\"hits\";s:1:\"0\";s:6:\"origin\";s:6:\"原创\";s:3:\"url\";s:0:\"\";s:12:\"is_recommend\";s:1:\"2\";s:7:\"content\";s:94:\"&lt;p&gt;dasasdasdasdasd&lt;/p&gt;&lt;p&gt;sdaasdasdasdasd&lt;/p&gt;&lt;p&gt;dasdasd&lt;/p&gt;\";}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36', 'windows', 'Chrome/86.0.4240.198', 1629771089),
(18, 5, '/admin/Article/upAndAdd.html', 'post', 'test', 'a:16:{s:7:\"cate_id\";s:1:\"2\";s:5:\"title\";s:9:\"asdasdasd\";s:11:\"title_color\";s:7:\"#00060a\";s:5:\"range\";s:1:\"4\";s:7:\"img_url\";s:71:\"/uploads/adminuser/avatar/20200702/5e19638241c47d668ad937cd5fde4847.jpg\";s:4:\"file\";s:0:\"\";s:8:\"keywords\";s:4:\"xxxx\";s:11:\"description\";s:9:\"sdaasdasd\";s:7:\"is_show\";s:1:\"1\";s:6:\"is_top\";s:1:\"0\";s:6:\"author\";s:4:\"test\";s:4:\"hits\";s:1:\"0\";s:6:\"origin\";s:6:\"原创\";s:3:\"url\";s:0:\"\";s:12:\"is_recommend\";s:1:\"2\";s:7:\"content\";s:94:\"&lt;p&gt;dasasdasdasdasd&lt;/p&gt;&lt;p&gt;sdaasdasdasdasd&lt;/p&gt;&lt;p&gt;dasdasd&lt;/p&gt;\";}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36', 'windows', 'Chrome/86.0.4240.198', 1629771120),
(19, 5, '/admin/Article/upAndAdd.html', 'post', 'test', 'a:16:{s:7:\"cate_id\";s:1:\"1\";s:5:\"title\";s:9:\"SDASADASD\";s:11:\"title_color\";s:7:\"#00060a\";s:5:\"range\";s:1:\"0\";s:7:\"img_url\";s:71:\"/uploads/adminuser/avatar/20210313/c38869c36842c2b686f7913ba394e86c.png\";s:4:\"file\";s:0:\"\";s:8:\"keywords\";s:3:\"XXX\";s:11:\"description\";s:6:\"SADASD\";s:7:\"is_show\";s:1:\"1\";s:6:\"is_top\";s:1:\"0\";s:6:\"author\";s:4:\"test\";s:4:\"hits\";s:1:\"0\";s:6:\"origin\";s:6:\"原创\";s:3:\"url\";s:0:\"\";s:12:\"is_recommend\";s:1:\"2\";s:7:\"content\";s:28:\"&lt;p&gt;DASADSASD&lt;/p&gt;\";}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36', 'windows', 'Chrome/86.0.4240.198', 1629771433),
(20, 5, '/admin/Article/upAndAdd.html', 'post', 'test', 'a:16:{s:7:\"cate_id\";s:1:\"1\";s:5:\"title\";s:9:\"SDASADASD\";s:11:\"title_color\";s:7:\"#00060a\";s:5:\"range\";s:1:\"0\";s:7:\"img_url\";s:71:\"/uploads/adminuser/avatar/20210313/c38869c36842c2b686f7913ba394e86c.png\";s:4:\"file\";s:0:\"\";s:8:\"keywords\";s:3:\"XXX\";s:11:\"description\";s:6:\"SADASD\";s:7:\"is_show\";s:1:\"1\";s:6:\"is_top\";s:1:\"0\";s:6:\"author\";s:4:\"test\";s:4:\"hits\";s:1:\"0\";s:6:\"origin\";s:6:\"原创\";s:3:\"url\";s:0:\"\";s:12:\"is_recommend\";s:1:\"2\";s:7:\"content\";s:28:\"&lt;p&gt;DASADSASD&lt;/p&gt;\";}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36', 'windows', 'Chrome/86.0.4240.198', 1629771516),
(21, 5, '/admin/Article/upAndAdd.html', 'post', 'test', 'a:16:{s:7:\"cate_id\";s:1:\"2\";s:5:\"title\";s:5:\"xxxxx\";s:11:\"title_color\";s:7:\"#00060a\";s:5:\"range\";s:1:\"0\";s:7:\"img_url\";s:72:\"/uploads/attachment/images/20210823/49f396058080bb4d48c7d84f54004113.jpg\";s:4:\"file\";s:0:\"\";s:8:\"keywords\";s:3:\"xxx\";s:11:\"description\";s:5:\"sdasd\";s:7:\"is_show\";s:1:\"1\";s:6:\"is_top\";s:1:\"0\";s:6:\"author\";s:4:\"test\";s:4:\"hits\";s:1:\"0\";s:6:\"origin\";s:6:\"原创\";s:3:\"url\";s:0:\"\";s:12:\"is_recommend\";s:1:\"2\";s:7:\"content\";s:37:\"&lt;p&gt;dsadasdasadsadsasd&lt;/p&gt;\";}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36', 'windows', 'Chrome/86.0.4240.198', 1629772324),
(22, 5, '/admin/Article/upAndAdd.html', 'post', 'test', 'a:16:{s:7:\"cate_id\";s:1:\"2\";s:5:\"title\";s:5:\"xxxxx\";s:11:\"title_color\";s:7:\"#00060a\";s:5:\"range\";s:1:\"0\";s:7:\"img_url\";s:72:\"/uploads/attachment/images/20210823/49f396058080bb4d48c7d84f54004113.jpg\";s:4:\"file\";s:0:\"\";s:8:\"keywords\";s:3:\"xxx\";s:11:\"description\";s:5:\"sdasd\";s:7:\"is_show\";s:1:\"1\";s:6:\"is_top\";s:1:\"0\";s:6:\"author\";s:4:\"test\";s:4:\"hits\";s:1:\"0\";s:6:\"origin\";s:6:\"原创\";s:3:\"url\";s:0:\"\";s:12:\"is_recommend\";s:1:\"2\";s:7:\"content\";s:37:\"&lt;p&gt;dsadasdasadsadsasd&lt;/p&gt;\";}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36', 'windows', 'Chrome/86.0.4240.198', 1629772437),
(23, 5, '/admin/Article/upAndAdd.html', 'post', 'test', 'a:16:{s:7:\"cate_id\";s:1:\"2\";s:5:\"title\";s:8:\"xasdxasx\";s:11:\"title_color\";s:7:\"#00060a\";s:5:\"range\";s:1:\"3\";s:7:\"img_url\";s:70:\"/uploads/article/images/20200817/ff08af9f69367ac0f041b17968ff5efb.jpeg\";s:4:\"file\";s:0:\"\";s:8:\"keywords\";s:4:\"xsxs\";s:11:\"description\";s:16:\"dasdasdasdasdasd\";s:7:\"is_show\";s:1:\"1\";s:6:\"is_top\";s:1:\"0\";s:6:\"author\";s:4:\"test\";s:4:\"hits\";s:1:\"0\";s:6:\"origin\";s:6:\"原创\";s:3:\"url\";s:0:\"\";s:12:\"is_recommend\";s:1:\"2\";s:7:\"content\";s:52:\"&lt;p&gt;asdasdasdasdasdasdasdasdasdasdasd&lt;/p&gt;\";}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36', 'windows', 'Chrome/86.0.4240.198', 1629772736),
(24, 5, '/admin/DataBackup/export.html', 'post', 'test', 'a:1:{s:6:\"tables\";a:17:{i:0;s:9:\"jrk_admin\";i:1;s:12:\"jrk_articles\";i:2;s:17:\"jrk_articles_cate\";i:3;s:20:\"jrk_articles_comment\";i:4;s:19:\"jrk_articles_models\";i:5;s:17:\"jrk_articles_user\";i:6;s:14:\"jrk_attachment\";i:7;s:14:\"jrk_auth_group\";i:8;s:21:\"jrk_auth_group_access\";i:9;s:13:\"jrk_auth_rule\";i:10;s:12:\"jrk_commands\";i:11;s:15:\"jrk_friendlinks\";i:12;s:10:\"jrk_member\";i:13;s:14:\"jrk_sys_config\";i:14;s:18:\"jrk_sys_config_tab\";i:15;s:13:\"jrk_sys_queue\";i:16;s:14:\"jrk_user_token\";}}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36', 'windows', 'Chrome/86.0.4240.198', 1629773583);

-- --------------------------------------------------------

--
-- 表的结构 `jrk_sys_config`
--

CREATE TABLE `jrk_sys_config` (
  `id` int(11) UNSIGNED NOT NULL,
  `group_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分组ID',
  `group` varchar(80) NOT NULL COMMENT '配置分组名',
  `name` varchar(80) NOT NULL COMMENT '配置名',
  `value` varchar(255) DEFAULT NULL COMMENT '配置值',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `beizhu` varchar(255) DEFAULT NULL COMMENT '备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='配置表' ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `jrk_sys_config`
--

INSERT INTO `jrk_sys_config` (`id`, `group_id`, `group`, `name`, `value`, `create_time`, `beizhu`) VALUES
(1, 3, 'upload', 'accessKey', 'accessKey', 1593354333, ''),
(2, 3, 'upload', 'secretKey', 'secretKey', 1593354333, ''),
(3, 3, 'upload', 'uploadUrl', 'uploadUrl', 1593354333, ''),
(4, 3, 'upload', 'storage_name', 'storage_name', 1593354333, ''),
(5, 3, 'upload', 'storage_region', 'storage_region', 1593354333, ''),
(14, 2, 'site', 'site_name', '网站名称', 1593354333, ''),
(15, 2, 'site', 'site_url', '网站地址', 1593354333, ''),
(16, 2, 'site', 'site_logo', '站点LOGO', 1593354333, ''),
(17, 2, 'site', 'site_phone', '站点联系电话', 1593354333, ''),
(18, 2, 'site', 'site_seo_title', 'SEO标题', 1593354333, ''),
(19, 2, 'site', 'site_email', '站点联系邮箱', 1593354333, ''),
(20, 2, 'site', 'site_qq', '站点联系QQ', 1593354333, ''),
(21, 2, 'site', 'site_close', '网站关闭', 1593354333, '0=>开启1=>PC端关闭2=>WAP端关闭(含微信)3=>全部关闭'),
(22, 3, 'upload', 'upload_type', '1', 1593354333, '1=>本地存储2=>七牛云存储3=>阿里云OSS4=>腾讯COS'),
(23, 4, 'push', 'xzappid', 'xzappid熊掌号的appid', 1596099671, ''),
(24, 4, 'push', 'xztoken', 'xztoken 熊掌号的token', 1596099698, ''),
(25, 4, 'push', 'zz_site', '1', 1596099776, '百度站长的站点'),
(26, 4, 'push', 'zz_token', '2', 1596099819, '百度站长token'),
(27, 2, 'site', 'site_keywords', 'keywords', 1596101048, ''),
(28, 2, 'site', 'site_description', 'description', 1596101062, '');

-- --------------------------------------------------------

--
-- 表的结构 `jrk_sys_config_tab`
--

CREATE TABLE `jrk_sys_config_tab` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL COMMENT '配置分类名称',
  `eng_title` varchar(100) NOT NULL COMMENT '分类英文名',
  `pid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '0禁止1正常',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `beizhu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='配置分类表' ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `jrk_sys_config_tab`
--

INSERT INTO `jrk_sys_config_tab` (`id`, `title`, `eng_title`, `pid`, `status`, `create_time`, `update_time`, `beizhu`) VALUES
(1, '默认分类', 'moren', 0, 1, 1596095169, 1596095169, '没有分配分类的配置'),
(2, '站点配置', 'site', 0, 1, 1596095705, 1596095705, '后端站点所有配置'),
(3, '上传配置', 'upload', 0, 1, 1596096079, 1596096079, ''),
(4, '地址推送', 'push', 0, 1, 1596099565, 1596099565, '百度站长，熊掌号推送链接');

-- --------------------------------------------------------

--
-- 表的结构 `jrk_sys_queue`
--

CREATE TABLE `jrk_sys_queue` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'ID',
  `type` varchar(10) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '事件类型',
  `title` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '事件标题',
  `content` text CHARACTER SET utf8 NOT NULL COMMENT '事件内容',
  `schedule` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT 'Crontab格式',
  `sleep` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '延迟秒数执行',
  `maximums` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '最大执行次数 0为不限',
  `executes` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '已经执行的次数',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `begintime` int(10) DEFAULT '0' COMMENT '开始时间',
  `endtime` int(10) DEFAULT '0' COMMENT '结束时间',
  `executetime` int(10) DEFAULT '0' COMMENT '最后执行时间',
  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '权重',
  `status` enum('completed','expired','hidden','normal') CHARACTER SET utf8 NOT NULL DEFAULT 'normal' COMMENT '状态',
  `ip` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='定时任务表';

-- --------------------------------------------------------

--
-- 表的结构 `jrk_user_token`
--

CREATE TABLE `jrk_user_token` (
  `token` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Token',
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '会员ID',
  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',
  `expiretime` int(10) DEFAULT NULL COMMENT '过期时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='会员Token表';

--
-- 转存表中的数据 `jrk_user_token`
--

INSERT INTO `jrk_user_token` (`token`, `user_id`, `createtime`, `expiretime`) VALUES
('25e29a992a80a2096dda3b139d5ddb1947f723e0', 3, 1629702294, 1632294294),
('888522a6c35c8fc41a7d2297a2db6251dbf0497f', 1, 1629701341, 1632293341),
('f4d9b6032869bcdfa7b3bff4270442ae9024ab41', 2, 1629702209, 1632294209);

--
-- 转储表的索引
--

--
-- 表的索引 `jrk_admin`
--
ALTER TABLE `jrk_admin`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `jrk_articles`
--
ALTER TABLE `jrk_articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cate_id` (`cate_id`) USING BTREE COMMENT '栏目ID',
  ADD KEY `is_show` (`is_show`) USING BTREE,
  ADD KEY `status` (`status`) USING BTREE;

--
-- 表的索引 `jrk_articles_cate`
--
ALTER TABLE `jrk_articles_cate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `is-show` (`is_show`) USING BTREE;

--
-- 表的索引 `jrk_articles_comment`
--
ALTER TABLE `jrk_articles_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `is_show` (`is_show`) USING BTREE;

--
-- 表的索引 `jrk_articles_models`
--
ALTER TABLE `jrk_articles_models`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `jrk_articles_user`
--
ALTER TABLE `jrk_articles_user`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `jrk_attachment`
--
ALTER TABLE `jrk_attachment`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `jrk_auth_group`
--
ALTER TABLE `jrk_auth_group`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `jrk_auth_group_access`
--
ALTER TABLE `jrk_auth_group_access`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `uid_group_id` (`uid`,`group_id`) USING BTREE,
  ADD KEY `uid` (`uid`) USING BTREE,
  ADD KEY `group_id` (`group_id`) USING BTREE;

--
-- 表的索引 `jrk_auth_rule`
--
ALTER TABLE `jrk_auth_rule`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `jrk_commands`
--
ALTER TABLE `jrk_commands`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `jrk_friendlinks`
--
ALTER TABLE `jrk_friendlinks`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `jrk_member`
--
ALTER TABLE `jrk_member`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `jrk_system_log_202108`
--
ALTER TABLE `jrk_system_log_202108`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `jrk_sys_config`
--
ALTER TABLE `jrk_sys_config`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `jrk_sys_config_tab`
--
ALTER TABLE `jrk_sys_config_tab`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `jrk_sys_queue`
--
ALTER TABLE `jrk_sys_queue`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `jrk_user_token`
--
ALTER TABLE `jrk_user_token`
  ADD PRIMARY KEY (`token`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `jrk_admin`
--
ALTER TABLE `jrk_admin`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `jrk_articles`
--
ALTER TABLE `jrk_articles`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `jrk_articles_cate`
--
ALTER TABLE `jrk_articles_cate`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `jrk_articles_comment`
--
ALTER TABLE `jrk_articles_comment`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `jrk_articles_models`
--
ALTER TABLE `jrk_articles_models`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `jrk_articles_user`
--
ALTER TABLE `jrk_articles_user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `jrk_attachment`
--
ALTER TABLE `jrk_attachment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- 使用表AUTO_INCREMENT `jrk_auth_group`
--
ALTER TABLE `jrk_auth_group`
  MODIFY `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `jrk_auth_group_access`
--
ALTER TABLE `jrk_auth_group_access`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `jrk_auth_rule`
--
ALTER TABLE `jrk_auth_rule`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- 使用表AUTO_INCREMENT `jrk_commands`
--
ALTER TABLE `jrk_commands`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `jrk_friendlinks`
--
ALTER TABLE `jrk_friendlinks`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `jrk_member`
--
ALTER TABLE `jrk_member`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `jrk_system_log_202108`
--
ALTER TABLE `jrk_system_log_202108`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=25;

--
-- 使用表AUTO_INCREMENT `jrk_sys_config`
--
ALTER TABLE `jrk_sys_config`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- 使用表AUTO_INCREMENT `jrk_sys_config_tab`
--
ALTER TABLE `jrk_sys_config_tab`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `jrk_sys_queue`
--
ALTER TABLE `jrk_sys_queue`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
