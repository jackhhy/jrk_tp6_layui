<?php /*a:2:{s:65:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\command\add.html";i:1597392019;s:67:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\public\window.html";i:1597630457;}*/ ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo htmlentities($_name); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
    <link href="/plugs/font-awesome/css/font-awesome.css?v=4.7.0" rel="stylesheet">
    <link rel="stylesheet" href="/static/css/animate.min.css" media="all"/>
    <link rel="stylesheet" href="/plugs/layui/css/layui.css?v=2.5.6">
    <script src="/static/js/jquery.min.js?v=1"></script>
    <script src="/plugs/layui/layui.js?v=2.5.6"></script>
    <script src="/static/js/backend/jrk_common.js?v=<?php echo time(); ?>"></script>
    <script src="/static/js/backend/comm.js?v=<?php echo time(); ?>"></script>

    <style >
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

        .layui-form[wid100] .layui-form-label {
            width: 100px !important;
        }

     /*   .layui-form-label{
            width: 110px !important;
        }
        .layui-input-block {
            margin-left: 140px !important;
        }*/

    </style >

</head>

<body class="ok-body-scroll">

<script type="text/javascript" src="/static/js/clipboard.min.js?v=1"></script>



<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-body" style="padding: 15px;">
            <form class="layui-form" action="" lay-filter="form" id="form">

                <input type="hidden" name="__token__" id="token" value="<?php echo token(); ?>"/>

                <div class="layui-form-item">
                    <label class="layui-form-label label-required-next">模块名：</label>
                    <div class="layui-input-inline input-custom-width" style="">
                        <input type="text" name="app" value="admin" readonly placeholder="请输入模块名" lay-verify="required" lay-vertype="tips" lay-reqtext="请输入模块名" autocomplete="off" class="layui-input ">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label label-required-next">控制名：</label>
                    <div class="layui-input-inline input-custom-width" style="">
                        <input type="text" name="controller" value="" placeholder="请输入控制器" lay-verify="required" lay-vertype="tips" lay-reqtext="请输入控制器" autocomplete="off" class="layui-input ">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label label-required-next">模型名：</label>
                    <div class="layui-input-block input-custom-width" style="">
                        <input type="text" name="model" value="" placeholder="请输入模型名" lay-verify="required" lay-vertype="tips" lay-reqtext="请输入模型名" autocomplete="off" class="layui-input ">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label label-required-next">验证器名：</label>
                    <div class="layui-input-block input-custom-width" style="">
                        <input type="text" name="validate" value="" placeholder="请输入验证器名" lay-verify="required" lay-vertype="tips" lay-reqtext="请输入验证器名" autocomplete="off" class="layui-input ">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label label-required-next">命令行：</label>
                    <div class="layui-input-block input-custom-width" style="">
                        <input type="text" name="command" id="command" value="" readonly placeholder="生成的命令行"  autocomplete="off" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item layui-layout-admin " style="width: 100%">
                    <div class="layui-input-block">
                        <div class="layui-footer" style="left: 0px;text-align: center;">
                            <button class="layui-btn layui-btn-warm" lay-submit="" lay-filter="add">生成命令行</button>
                            <button class="layui-btn" id="docomm" type="button">立即执行</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>


<script>
    layui.use(['element', 'form', 'jquery','lucky'], function () {
        var element = layui.element;
        var table = layui.table;
        var form = layui.form;
        var $ = layui.jquery;
        var lucky=layui.lucky;

        form.on('submit(add)', function (data) {
            var config = {
                url: "<?php echo url('add'); ?>",
                type: "post",
                dataType: "json",
                data: data.field,
                beforeSend: function() {
                    layer.load(2);
                },
                success: function(result) {
                    if (result.code == 1) {
                        $("#command").val(result.data.data);
                    } else {
                       lucky.layerMsg(result.msg,5)
                    }
                },
                complete: function() {
                    layer.closeAll('loading');
                }
            };
            $.ajax(config);
            return false;
        });


        $("#docomm").click(function () {
            lucky.FormSubmit("<?php echo url('doo'); ?>",$("#form").serialize(),true);
            return false;

        });
    })
</script>



</body>
</html>