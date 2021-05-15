<h1 align="center"> JrkAdmin（TP6.0.6版本） —— 你值得信赖的后端开发框架</h1> 
<p align="center">
<img src="https://gitee.com/luckygyl/jrk_tp6_layui/badge/star.svg?theme=dark"  /> 
<img src="https://gitee.com/luckygyl/jrk_tp6_layui/badge/fork.svg?theme=dark"  /> 
<a href="http://www.php.net/" target="_blank">
<img src="https://img.shields.io/badge/php-%3E%3D7.1-8892BF.svg"  /> 
</a>

</p>
<p align="center">    
    <b>如果对您有帮助，您可以点右上角 "Star" 支持一下 谢谢！</b>
</p>


## 项目介绍
JrkAdmin_Tp6_Layui（完整版）是ThinkPHP6.0和layui的快速开发的后台管理系统。<br>
后台采用RABC权限验证，不懂的同学可以查看相关文档<br>
实现管理员管理，权限管理，角色管理，菜单管理，附件管理，日志管理
phpquerylist数据采集，phpword导出word文档，API接口管理，
OSS,COS等云端图片上传，jpush极光推送，queue队列定时任务,
批量邮件发送，多语言化，优化权限认证新增不需验证和不需登录验证，
后台灵活开启谷歌验证码验证。

## CURD命令

~~~
php think make:jrkadmin_curd Hello Hello Hello --app admin [ # 普通CURD增删改查+验证器+模型+视图 ]
                             控制器 模型  验证器       模块名 
~~~

### 导航栏目


 | [官网地址](http://www.luckyhhy.cn)
 | [TP6开发手册](https://www.kancloud.cn/manual/thinkphp6_0/1037479)
 | [服务器](https://promotion.aliyun.com/ntms/yunparter/invite.html?userCode=dligum2z)

- - -

## Stargazers over time
[![Stargazers over time](https://whnb.wang/img/luckygyl/jrk_tp6_layui)](https://whnb.wang/luckygyl/jrk_tp6_layui)



### QQ交流群
 JrkAdminQQ交流群: 498186248 <a target="_blank" href="//shang.qq.com/wpa/qunwpa?idkey=9ad90a1a2a7cd611cc3343b9b8f59a8ab2a8bbffa2bed243344c41824ebc7f35"><img border="0" src="//pub.idqqimg.com/wpa/images/group.png" alt="JrkAdmin" title="JrkAdmin"></a>

### 微信交流群
如果二维码失效，可以添加作者微信拉你进技术交流群：hhz_9898

<img src="https://images.gitee.com/uploads/images/2021/0515/103014_f81481a3_1513275.png" width="200" height="400" alt="" />

### 开源版使用须知
1.允许用于个人学习、毕业设计、教学案例、公益事业;

2.如果商用必须保留版权信息，请自觉遵守。

3.禁止将本项目的代码和资源进行任何形式的出售，产生的一切任何后果责任由侵权者自负。

4.版权所有Copyright © 2019-2022 by LuckyHHY (http://www.luckhhy.cn) All rights reserved。



## 安装
使用git安装
~~~
git clone https://gitee.com/luckygyl/jrk_tp6_layui.git
~~~

1、sql 文件在 backup 文件夹下面 <br>
2、修改 .env 里面的数据库配置  <br>
3、数据库导入 sql <br>
4、超管账号密码： jrkadmintp6   123456 <br>
5、在项目根目录下执行命令：
~~~
 composer update
~~~

##演示地址
http://hzd.luckyhhy.cn/

### 环境
推荐使用 Nginx + php7.3 + mysql 

### 浏览器
推荐使用 谷歌，百分，火狐 浏览器

## 项目截图
![输入图片说明](https://images.gitee.com/uploads/images/2020/0702/221414_cbdabe55_1513275.png "2020-7-2 22-7-30.png")
![输入图片说明](https://images.gitee.com/uploads/images/2020/0702/221428_bece0912_1513275.png "2020-7-2 22-7-56.png")

### 特别鸣谢

1. [ok-admin](https://gitee.com/bobi1234/ok-admin/tree/v2.0/)
2. [layui](http://www.layui.com)
3. [thinkphp](http://www.thinkphp.cn)


### 往期项目

1. [图标选择器](https://gitee.com/luckygyl/iconFonts)
2. [JrkAdmin_Tp5.1](https://gitee.com/luckygyl/JrkAdmin)
2. [jrkadmin_tp6_bootstrap项目](https://gitee.com/luckygyl/jrk_tp6_hhy)