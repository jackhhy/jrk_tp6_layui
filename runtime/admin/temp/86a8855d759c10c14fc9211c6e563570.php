<?php /*a:3:{s:70:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\admin\chang_pass.html";i:1597383421;s:65:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\public\base.html";i:1597383421;s:65:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\public\head.html";i:1597626924;}*/ ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo htmlentities($_name); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" href="/static/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/static/css/jrkLoading.css?v=<?php echo time(); ?>"/>
    <script type="text/javascript" src="/static/js/backend/jrk_config.js?v=<?php echo time(); ?>"></script>
    <script type="text/javascript" src="/static/js/backend/jrkLoading.js?v=<?php echo time(); ?>"></script>
    <link href="/plugs/font-awesome/css/font-awesome.css?v=4.7.0" rel="stylesheet">
    <link rel="stylesheet" href="/static/css/animate.min.css" media="all"/>

    <link rel="stylesheet" href="/static/css/jrkadmin.css?v=<?php echo time(); ?>">

    <script src="/static/js/jquery.min.js?v=1"></script>

    <script type="text/javascript" src="/static/js/backend/jrk_common.js?v=<?php echo time(); ?>"></script>

    <style>
        .layui-form[wid100] .layui-form-label {
            width: 100px !important;
        }
        .help-block{
            color: #999;
            font-size: 12px;
        }
        .color-desc {
            color: #999!important;
        }
        .nowrap {
            white-space: nowrap!important;
        }
        .label-required-next:after {
            top: 6px;
            right: 5px;
            color: red;
            content: '*';
            position: absolute;
            margin-left: 4px;
            font-weight: 700;
            line-height: 1.8em;
        }
        .layui-form-label{
            width: 110px !important;
        }
        .layui-input-block {
            margin-left: 140px !important;
        }
      /*  .layui-table-cell{
            height: auto;
            white-space: normal;
            cursor: pointer;
        }*/
    </style>
</head>
<body class="ok-body-scroll">



<!--js逻辑-->
<script src="/plugs/layui/layui.js?v=2.5.6"></script>

<script src="/static/js/backend/comm.js?v=<?php echo time(); ?>"></script>

<!-- 主体部分开始 -->
<div class="layui-fluid">

    <div class="layui-row layui-col-space10" style="margin-top: 8px;">

        

<div class="layui-col-md12" >

    <div class="layui-card" >

        <div class="layui-card-body" >

            <div class="layui-card-header" >修改密码</div >
            <div class="layui-card-body" >

                <div class="layui-form" lay-filter="" >

                    <div class="layui-form-item" >
                        <label class="layui-form-label " >当前密码：</label >
                        <div class="layui-input-inline" >
                            <input type="password" name="oldpassword" lay-verify="required" lay-vertype="tips"  placeholder="请输入当前密码" class="layui-input layui-form-danger" >
                        </div >
                    </div >
                    <input type="hidden" name="__token__" id="token" value="<?php echo token(); ?>"/>

                    <div class="layui-form-item" >
                        <label class="layui-form-label" >新密码：</label >
                        <div class="layui-input-inline" >
                            <input type="password" name="password" lay-verify="required" lay-vertype="tips" placeholder="请输入新密码" autocomplete="off" class="layui-input" >
                        </div >
                        <div class="layui-form-mid layui-word-aux" >6到16个字符</div >
                    </div >

                    <div class="layui-form-item" >
                        <label class="layui-form-label" >确认密码：</label >
                        <div class="layui-input-inline" >
                            <input type="password" name="repassword" lay-verify="required" lay-vertype="tips" autocomplete="off" class="layui-input" >
                        </div >
                    </div >

                    <div class="layui-form-item" >
                        <div class="layui-input-block" >
                            <button class="layui-btn" lay-submit="" lay-filter="setmypass" >确认修改</button >
                        </div >
                    </div >

                </div >

            </div >


        </div >
    </div >

</div >




    </div>
</div>


<!-- 主体部分结束 -->
<script type="text/javascript" src="/static/js/clipboard.min.js?v=1"></script>


 <!--js处理区-->

<script >

    layui.use(['element', 'form', 'jquery', 'lucky'], function () {
        var element = layui.element;
        var form = layui.form;
        var $ = layui.jquery;
        var lucky = layui.lucky;

        form.render();

        /**
         * 表格提交
         */
        form.on('submit(setmypass)', function (data) {
            lucky.FormSubmit("<?php echo url('Admin/changPass'); ?>", data.field);
            return false;
        });

    });

</script >




<script>
    okLoading.close();
</script>
</body>
</html>