<?php /*a:2:{s:59:"D:\phpstudy_pro\WWW\jrk_tp6\app\admin\view\index\index.html";i:1596107433;s:59:"D:\phpstudy_pro\WWW\jrk_tp6\app\admin\view\public\left.html";i:1596107433;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo htmlentities($_name); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" href="/static/css/jrkadmin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/static/css/jrkLoading.css?v=<?php echo time(); ?>"/>
    <script type="text/javascript" src="/static/js/backend/jrk_config.js?v=<?php echo time(); ?>"></script>
    <script type="text/javascript" src="/static/js/backend/jrkLoading.js?v=<?php echo time(); ?>"></script>
    <link href="/plugs/font-awesome/css/font-awesome.css?v=4.7.0" rel="stylesheet">
    <link rel="stylesheet" href="/static/css/animate.min.css" media="all"/>
    <script src="/static/js/jquery.min.js"></script>
</head>
<body class="layui-layout-body">
<!-- 更换主体 Eg:orange_theme|blue_theme -->
<div class="layui-layout layui-layout-admin okadmin blue_theme">
    <!--头部导航-->
    <div class="layui-header okadmin-header">
        <ul class="layui-nav layui-layout-left">
            <li class="layui-nav-item">
                <a class="ok-menu ok-show-menu" href="javascript:" title="菜单切换">
                    <i class="layui-icon layui-icon-shrink-right"></i>
                </a>
            </li>
            <!--天气信息-->
            <li class="ok-nav-item ok-hide-md">
                <div class="weather-ok">
                    <iframe frameborder="0" scrolling="no" class="iframe-style" src="<?php echo url('index/weather'); ?>" frameborder="0"></iframe>
                </div>
            </li>
        </ul>
        <ul class="layui-nav layui-layout-right">

            <li class="no-line layui-nav-item layui-hide-xs">
                <a href="javascript:" class="flex-vc">
                    <marquee width="200">通知：此后台系统开源免费，但请勿进行出售或者上传到任何素材网站，否则将追究相应的责任！</marquee>
                </a>
            </li>

            <li class="layui-nav-item tip_jrk">
                <a class="ok-refresh" href="javascript:" title="刷新">
                    <i class="layui-icon layui-icon-refresh-3"></i>
                </a>
            </li>
            <li class="no-line layui-nav-item layui-hide-xs tip_jrk">
                <a id="notice" class="flex-vc pr10 pl10" href="javascript:" title="系统公告">
                    <i class="ok-icon ok-icon-notice icon-head-i"></i>
                    <span class="layui-badge-dot"></span>
                    <cite></cite>
                </a>
            </li>

            <li class="no-line layui-nav-item layui-hide-xs tip_jrk">
                <a id="lock" class="flex-vc pr10 pl10" href="javascript:" title="锁屏">
                    <i class="ok-icon ok-icon-lock icon-head-i"></i><cite></cite>
                </a>
            </li>

            <!-- 全屏 -->
            <li class="layui-nav-item layui-hide-xs tip_jrk">
                <a id="fullScreen" class=" pr10 pl10" href="javascript:;" title="全屏">
                    <i class="layui-icon layui-icon-screen-full"></i>
                </a>
            </li>

            <li class="no-line layui-nav-item">
                <a href="javascript:">
                    <img src="<?php if(empty($_info['avatar']) || (($_info['avatar'] instanceof \think\Collection || $_info['avatar'] instanceof \think\Paginator ) && $_info['avatar']->isEmpty())): ?>/static/images/avatar.jpg <?php else: ?> <?php echo htmlentities($_info['avatar']); ?> <?php endif; ?>" class="layui-nav-img">
                    <?php echo htmlentities($_info['username']); ?>
                </a>
                <dl id="userInfo" class="layui-nav-child">
                    <dd><a lay-id="u-1" href="javascript:" data-url="/admin/Admin/baseData">基本资料<span
                            class="layui-badge-dot"></span></a></dd>
                   <!-- <dd><a lay-id="u-2" href="javascript:" data-url="pages/member/user-info.html">基本资料</a></dd>-->
                    <dd><a lay-id="u-3" href="javascript:" data-url="/admin/Admin/changPass">修改密码</a></dd>
                    <dd><a lay-id="u-4" href="javascript:" id="alertSkin">皮肤动画</a></dd>
                    <dd>
                        <hr/>
                    </dd>
                    <dd><a href="javascript:void(0)" id="logout">退出登录</a></dd>
                </dl>
            </li>

            <!-- 菜单 -->
            <li class="layui-nav-item layui-hide-xs">
                <a id="okSetting" class="pr10 pl10" href="javascript:;">
                    <i style="font-size: 18px" class="ok-icon ok-icon-moreandroid"></i>
                </a>
            </li>
        </ul>
    </div>
    <!--遮罩层-->
    <div class="ok-make"></div>
    <!--左侧导航区域-->
    <div class="layui-side layui-side-menu okadmin-bg-20222A ok-left">
        <div class="layui-side-scroll okadmin-side">
            <div class="okadmin-logo"><?php echo htmlentities($_name); ?></div>
            <div class="user-photo">
                <a class="img" title="我的头像">
                    <img src="<?php if(empty($_info['avatar']) || (($_info['avatar'] instanceof \think\Collection || $_info['avatar'] instanceof \think\Paginator ) && $_info['avatar']->isEmpty())): ?>/static/images/avatar.jpg <?php else: ?> <?php echo htmlentities($_info['avatar']); ?> <?php endif; ?>"
                         class="userAvatar">
                </a>
                <p>你好！<span class="userName"><?php echo htmlentities($_info['nickname']); ?></span>, 欢迎登录</p>
            </div>

            <!--左侧导航菜单-->
<ul id="navBar" class="layui-nav okadmin-nav okadmin-bg-20222A layui-nav-tree" style="height: 577px;" >
    <li class="layui-nav-item layui-this show_tips" >
        <a lay-id="1" data-url="" is-close="true" >
            <i class="fa fa-home" ></i ><cite >控制台</cite >
        </a >
    </li >

    <?php if(is_array($menulist) || $menulist instanceof \think\Collection || $menulist instanceof \think\Paginator): $k = 0; $__LIST__ = $menulist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;if(isset($v['children'])): ?>
    <li class="layui-nav-item show_tips" >
        <a ><i class="<?php echo htmlentities($v['font_family']); ?> <?php echo htmlentities($v['icon']); ?>"></i><cite ><?php echo htmlentities($v['title']); ?></cite ><span class="layui-nav-more" ></span ></a >
        <dl class="layui-nav-child" >
            <?php if(is_array($v['children']) || $v['children'] instanceof \think\Collection || $v['children'] instanceof \think\Paginator): $k2 = 0; $__LIST__ = $v['children'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$s): $mod = ($k2 % 2 );++$k2;?>

            <dd >
                <?php if(isset($s['children'])): ?>
                <a ><i class="<?php echo htmlentities($s['font_family']); ?> <?php echo htmlentities($s['icon']); ?>"></i><cite ><?php echo htmlentities($s['title']); ?></cite ><span class="layui-nav-more" ></span ></a >

                <dl class="layui-nav-child" >

                    <?php if(is_array($s['children']) || $s['children'] instanceof \think\Collection || $s['children'] instanceof \think\Paginator): $k3 = 0; $__LIST__ = $s['children'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$t): $mod = ($k3 % 2 );++$k3;?>
                    <dd >

                        <?php if(isset($t['children'])): ?>

                        <a ><i class="<?php echo htmlentities($t['font_family']); ?> <?php echo htmlentities($t['icon']); ?>"></i><cite ><?php echo htmlentities($t['title']); ?></cite ><span class="layui-nav-more" ></span ></a >
                        <dl class="layui-nav-child" >

                            <?php if(is_array($t['children']) || $t['children'] instanceof \think\Collection || $t['children'] instanceof \think\Paginator): $k4 = 0; $__LIST__ = $t['children'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$f): $mod = ($k4 % 2 );++$k4;?>

                            <dd >
                                <?php if(isset($f['children'])): ?>

                                <a ><i class="<?php echo htmlentities($f['font_family']); ?> <?php echo htmlentities($f['icon']); ?>"></i><cite ><?php echo htmlentities($f['title']); ?></cite ><span class="layui-nav-more" ></span ></a >
                                <dl class="layui-nav-child" >

                                    <?php if(is_array($f['children']) || $f['children'] instanceof \think\Collection || $f['children'] instanceof \think\Paginator): $k5 = 0; $__LIST__ = $f['children'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$fv): $mod = ($k5 % 2 );++$k5;?>
                                    <dd >
                                        <?php if(isset($fv['children'])): ?>

                                        <a ><i class="<?php echo htmlentities($fv['font_family']); ?> <?php echo htmlentities($fv['icon']); ?>"></i><cite ><?php echo htmlentities($fv['title']); ?></cite ><span class="layui-nav-more" ></span ></a >
                                        <dl class="layui-nav-child" >
                                            <?php if(is_array($fv['children']) || $fv['children'] instanceof \think\Collection || $fv['children'] instanceof \think\Paginator): $k6 = 0; $__LIST__ = $fv['children'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sx): $mod = ($k6 % 2 );++$k6;?>
                                            <dd >
                                                <a lay-id="<?php echo htmlentities($sx['id']); ?>-<?php echo htmlentities($k6); ?>" data-url="<?php if((isset($sx['url']))): ?> <?php echo htmlentities($sx['url']); else: ?> <?php echo htmlentities($sx['name']); ?> <?php endif; ?>" is-close="true" ><i class="<?php echo htmlentities($sx['font_family']); ?> <?php echo htmlentities($sx['icon']); ?>"></i><cite ><?php echo htmlentities($sx['title']); ?></cite ></a >
                                            </dd >

                                            <?php endforeach; endif; else: echo "" ;endif; ?>
                                        </dl>

                                        <?php else: ?>

                                        <a lay-id="<?php echo htmlentities($fv['id']); ?>-<?php echo htmlentities($k5); ?>" data-url="<?php if((isset($fv['url']))): ?> <?php echo htmlentities($fv['url']); else: ?> <?php echo htmlentities($fv['name']); ?> <?php endif; ?>" is-close="true" ><i class="<?php echo htmlentities($fv['font_family']); ?> <?php echo htmlentities($fv['icon']); ?>"></i><cite ><?php echo htmlentities($fv['title']); ?></cite ></a >

                                        <?php endif; ?>

                                    </dd >
                                    <?php endforeach; endif; else: echo "" ;endif; ?>

                                </dl>

                                <?php else: ?>
                                <a lay-id="<?php echo htmlentities($f['id']); ?>-<?php echo htmlentities($k4); ?>" data-url="<?php if((isset($f['url']))): ?> <?php echo htmlentities($f['url']); else: ?> <?php echo htmlentities($f['name']); ?> <?php endif; ?>" is-close="true" ><i class="<?php echo htmlentities($f['font_family']); ?> <?php echo htmlentities($f['icon']); ?>"></i><cite ><?php echo htmlentities($f['title']); ?></cite ></a >
                                <?php endif; ?>
                            </dd >

                            <?php endforeach; endif; else: echo "" ;endif; ?>

                        </dl>

                        <?php else: ?>

                        <a lay-id="<?php echo htmlentities($t['id']); ?>-<?php echo htmlentities($k3); ?>" data-url="<?php if((isset($t['url']))): ?> <?php echo htmlentities($t['url']); else: ?> <?php echo htmlentities($t['name']); ?> <?php endif; ?>" is-close="true" ><i class="<?php echo htmlentities($t['font_family']); ?> <?php echo htmlentities($t['icon']); ?>"></i><cite ><?php echo htmlentities($t['title']); ?></cite ></a >

                        <?php endif; ?>
                    </dd >

                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </dl>
                <?php else: ?>
                <a lay-id="<?php echo htmlentities($s['id']); ?>-<?php echo htmlentities($k2); ?>" data-url="<?php if((isset($s['url']))): ?> <?php echo htmlentities($s['url']); else: ?> <?php echo htmlentities($s['name']); ?> <?php endif; ?>" is-close="true" ><i class="<?php echo htmlentities($s['font_family']); ?> <?php echo htmlentities($s['icon']); ?>"></i><cite ><?php echo htmlentities($s['title']); ?></cite ></a >
                <?php endif; ?>
            </dd >

            <?php endforeach; endif; else: echo "" ;endif; ?>

        </dl >
    </li >

    <?php else: ?>

    <li class="layui-nav-item  show_tips" >
        <a lay-id="<?php echo htmlentities($v['id']); ?>-<?php echo htmlentities($k); ?>" data-url="<?php if((isset($v['url']))): ?> <?php echo htmlentities($v['url']); else: ?> <?php echo htmlentities($v['name']); ?> <?php endif; ?>"  >
            <i class="<?php echo htmlentities($v['font_family']); ?> <?php echo htmlentities($v['icon']); ?>"></i><cite ><?php echo htmlentities($v['title']); ?></cite >
        </a >
    </li >

    <?php endif; ?>

    <?php endforeach; endif; else: echo "" ;endif; ?>

</ul >

        </div>
    </div>

    <!-- 内容主体区域 -->
    <div class="content-body">
        <div class="layui-tab ok-tab" lay-filter="ok-tab" lay-allowClose="true" lay-unauto>
            <div data-id="left" id="okLeftMove"
                 class="ok-icon ok-icon-back okadmin-tabs-control move-left okNavMove"></div>
            <div data-id="right" id="okRightMove"
                 class="ok-icon ok-icon-right okadmin-tabs-control move-right okNavMove"></div>
            <div class="layui-icon okadmin-tabs-control ok-right-nav-menu" style="right: 0;">
                <ul class="okadmin-tab">
                    <li class="no-line okadmin-tab-item">
                        <div class="okadmin-link layui-icon-down" href="javascript:;"></div>
                        <dl id="tabAction" class="okadmin-tab-child layui-anim-upbit layui-anim">
                            <dd><a data-num="1" href="javascript:">关闭当前标签页</a></dd>
                            <dd><a data-num="2" href="javascript:">关闭其他标签页</a></dd>
                            <dd><a data-num="3" href="javascript:">关闭所有标签页</a></dd>
                        </dl>
                    </li>
                </ul>
            </div>

            <ul id="tabTitle" class="layui-tab-title ok-tab-title not-scroll">
                <li class="layui-this" lay-id="1" tab="index">
                    <i class="ok-icon">&#xe654;</i>
                    <cite is-close=false>控制台</cite>
                </li>
            </ul>

            <div id="tabContent" class="layui-tab-content ok-tab-content">
                <div class="layui-tab-item layui-show">
                    <iframe src="<?php echo url('index/home'); ?>" frameborder="0" scrolling="yes" width="100%"
                            height="100%"></iframe>
                </div>
            </div>
        </div>
    </div>

    <!--底部信息-->
    <div class="layui-footer okadmin-text-center">
        Copyright ©2019-©2022 <?php echo htmlentities($_name); ?> <?php echo htmlentities($_version); ?> All Rights Reserved
        <button class="layui-btn layui-btn-danger layui-btn-xs donate">捐赠作者</button>
        <button class="layui-btn layui-btn-danger layui-btn-xs communication">QQ群交流</button>
    </div>
</div>

<!-- 锁屏 -->
<div class="lock-screen">
    <div class="lock-bg">
        <img class="active lock-gradual" src="/static/images/wallpaper/9f28afe0e71b3ba8778e307bea2f006d.jpg" alt=""/>
        <img class="lock-gradual" src="/static/images/wallpaper/29bce2d5cf30fc96866dcb5e287661ea.jpg" alt=""/>
        <img class="lock-gradual" src="/static/images/wallpaper/b4b55f8ec6b2763a737a2d6e1c50b71e.jpg" alt=""/>
        <img class="lock-gradual" src="/static/images/wallpaper/b8df65c6452dcf8b0302b8bfce9e7ec9.jpg" alt=""/>
        <img class="lock-gradual" src="/static/images/wallpaper/b390e4c33b7d656f09dc7fd155759a4f.jpg" alt=""/>
        <img class="lock-gradual" src="/static/images/wallpaper/3fded2e777723f145a4773dfdb68a9e3.jpg" alt=""/>
    </div>
    <div class="lock-content">
        <!--雪花-->
        <div class="snowflake">
            <canvas id="snowflake"></canvas>
        </div>
        <!--雪花 END-->
        <div class="time">
            <div>
                <div class="hhmmss"></div>
                <div class="yyyymmdd"></div>
            </div>
        </div>
        <div class="quit" id="lockQuit">
            <i class="layui-icon layui-icon-logout" title="退出登录"></i>
        </div>
        <table class="unlock">
            <tr>
                <td>
                    <div class="layui-form lock-form">
                        <div class="lock-head">
                            <img src="<?php if(empty($_info['avatar']) || (($_info['avatar'] instanceof \think\Collection || $_info['avatar'] instanceof \think\Paginator ) && $_info['avatar']->isEmpty())): ?>/static/images/avatar.jpg <?php else: ?> <?php echo htmlentities($_info['avatar']); ?> <?php endif; ?>"
                                 alt="avatar.png"/>
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-col-xs8 layui-col-sm8 layui-col-md8">
                                <input type="password" required lay-verify="required" id="lockPassword" name="lock_password" style="border-radius: 0;border:0;height: 44px" placeholder="请输入登录密码" autocomplete="off"
                                       class="layui-input"/>
                            </div>
                            <div class="layui-col-xs4 layui-col-sm4 layui-col-md4">
                                <button style="width: 100%;box-sizing:border-box;border-radius: 0;" type="button" lay-submit lay-filter="lockSubmit"
                                        class="layui-btn lock-btn layui-btn-lg layui-btn-normal">确定
                                </button>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
<!--js逻辑-->
<script src="/plugs/layui/layui.js?v=2.5.6"></script>
<script src="/static/js/backend/snowflake.js?snowflake=XUEHUA"></script>
<script src="/static/js/backend/jrkadmin.js?v=1.0"></script>

<script>
    //顶部鼠标移上显示
    $('.tip_jrk').mouseover(function () {
        var str = $(this).find("a").attr("title");
        layer.tips(str, $(this), {
            tips: [1, '#FF5722'],
            time: 2000
        });
    });

    /**
     * 左侧导航tips提示
     */
    $(document).on('mouseenter', '.show_tips a', function () {
        var tip_index = layer.tips($(this).find('cite').text(), this, {
            time: 0
        });
        $(this).data('tip-index', tip_index);
    });
    $(document).on('mouseleave', '.show_tips a', function () {
        var tip_index = $(this).data('tip-index');
        if (tip_index !== undefined) {
            layer.close(tip_index);
        }
    });

    /**
     * 捐赠作者
     */
    $(".layui-footer button.donate").click(function () {
        layer.tab({
            area: ["330px", "350px"],
            tab: [{
                title: "支付宝",
                content: "<img src='/static/images/zfb.jpeg' width='200' height='300' style='margin: 0 auto; display: block;'>"
            }, {
                title: "微信",
                content: "<img src='/static/images/wx.png' width='200' height='300' style='margin: 0 auto; display: block;'>"
            }]
        });
    });

    /**
     * QQ群交流
     */
    $("body").on("click", ".layui-footer button.communication, #noticeQQ", function () {
        layer.tab({
            area: ["auto", "370px"],
            tab: [{
                title: "QQ群",
                content: "<img src='/static/images/JrkAdmin.png' width='260' height='300' style='margin: 0 auto; display: block;'/>"
            }]
        });
    });
</script>
</body>
</html>
