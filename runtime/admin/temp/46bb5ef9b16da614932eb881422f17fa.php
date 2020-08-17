<?php /*a:1:{s:65:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\login\index.html";i:1597388752;}*/ ?>
<!DOCTYPE html>
<html lang="en" class="page-fill">
<head>
    <meta charset="UTF-8">
    <title>Jrk丶Admin_tp6_layui-后台登录</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" href="/plugs/layui/css/layui.css?v=2.5.6"/>
    <link rel="stylesheet" href="/static/css/admin_login.css?v=1.0"/>
</head>
<body class="page-fill">
<div class="page-fill" id="login">
    <form class="layui-form" method="post">
        <div class="login_face"><img src="/static/images/jrk.jpg"></div>
        <div class="layui-form-item input-item">
            <label for="username">用户名</label>
            <input type="text" lay-verify="required" name="username" value="" placeholder="" autocomplete="off" id="username" class="layui-input">
        </div>
        <div class="layui-form-item input-item">
            <label for="password">密码</label>
            <input type="password" lay-verify="required|password" name="password" value="" placeholder="" autocomplete="off" id="password" class="layui-input">
        </div>

        <input type="hidden" name="__token__" id="token" value="<?php echo token(); ?>"/>

        <div class="layui-form-item input-item captcha-box">
            <label for="captcha">验证码</label>
            <input type="text" lay-verify="required" name="captcha" placeholder="" autocomplete="off" id="captcha" maxlength="4" class="layui-input">
            <div>
                <img class="img ok-none-select" src="<?php echo url('Login/captcha'); ?>" alt="" id="captchaImg">
            </div>
        </div>
        <div class="layui-form-item">
            <button class="layui-btn layui-block " lay-filter="login" lay-submit="">登录</button>
        </div>
    </form>
</div>

<!--js逻辑-->
<script src="/plugs/layui/layui.js?v=2.5.6"></script>

<script>
    layui.use(['form','jquery'], function () {
        var form = layui.form;
        var $ = layui.jquery;

        // 刷新验证码操作
        $("#captchaImg").click(function () {
            $(this).attr("src", $(this).attr("src") + '?' + Math.random());
        });

        /**
         * 数据校验
         */
        form.verify({
            password: [/^[\S]{6,12}$/, "密码必须6到12位，且不能出现空格"],
        });

        /**
         * 提交数据
         */
        form.on('submit(login)', function (data) {
            var load=layer.load(2);
            var capt=$("#captchaImg");
            $.ajax({
                url:"<?php echo url('login/loginCheck'); ?>",
                dataType:"json",
                type:'post',
                data:data.field,
                success:function(data){
                    console.log(data);
                    if(data.code==1)
                    {
                        layer.msg(data.msg, {icon: 1, time: 1500, anim: 4,shade:0.5}, function () {
                            layer.close(load);
                            window.location.href = data.url;
                        });
                    }else if(data.code==4){
                        layer.msg(data.msg, {icon: 5, time: 1000, anim: 4,shade:0.5}, function () {
                            capt.attr("src", capt.attr("src") + '?' + Math.random());
                            $("#token").val(data._token);
                            layer.close(load);
                        });
                    }
                    else
                    {
                        layer.msg(data.msg, {icon: 5, time: 1000, anim: 4,shade:0.5}, function () {
                            capt.attr("src", capt.attr("src") + '?' + Math.random());
                            layer.close(load);
                        });
                    }
                },
                error:function () {
                    layer.msg("网络错误", {icon: 5, time: 1000, anim: 4,shade:0.5}, function () {
                        capt.attr("src", capt.attr("src") + '?' + Math.random());
                        layer.close(load);
                    });
                }
            });

            return false;
        });

        /**
         * 表单input组件单击时
         */
        $("#login .input-item .layui-input").click(function (e) {
            e.stopPropagation();
            $(this).addClass("layui-input-focus").find(".layui-input").focus();
        });

        /**
         * 表单input组件获取焦点时
         */
        $("#login .layui-form-item .layui-input").focus(function () {
            $(this).parent().addClass("layui-input-focus");
        });

        /**
         * 表单input组件失去焦点时
         */
        $("#login .layui-form-item .layui-input").blur(function () {
            $(this).parent().removeClass("layui-input-focus");
            if ($(this).val() != "") {
                $(this).parent().addClass("layui-input-active");
            } else {
                $(this).parent().removeClass("layui-input-active");
            }
        })

    });
</script>
</body>
</html>