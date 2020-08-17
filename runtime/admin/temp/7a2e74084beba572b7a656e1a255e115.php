<?php /*a:2:{s:75:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\auth_group\user_group.html";i:1597386637;s:67:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\public\window.html";i:1597384879;}*/ ?>

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

        .layui-form-label{
            width: 110px !important;
        }
        .layui-input-block {
            margin-left: 140px !important;
        }

    </style >

</head>

<body class="ok-body-scroll">

<script type="text/javascript" src="/static/js/clipboard.min.js?v=1"></script>



<div class="layui-fluid">
    <div class="layui-card">
        <!-- <div class="layui-card-header"></div>-->

        <div class="layui-card-body" style="padding: 15px;">
            <blockquote class="layui-elem-quote layui-text">
                权限组授权给后台管理员，如果去除全部则是删除当前权限组的所有授权人员.
            </blockquote>

            <form class="layui-form" action="" lay-filter="form">

                <input type="hidden" name="group_id" value="<?php echo htmlentities($id); ?>">

                <div class="layui-form-item">
                    <label class="layui-form-label label-required-next">授权人员：</label>
                    <div class="layui-input-block input-custom-width" style="">

                        <?php if(is_array($user) || $user instanceof \think\Collection || $user instanceof \think\Paginator): $i = 0; $__LIST__ = $user;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                        <input type="checkbox" name="uid[]" value="<?php echo htmlentities($v['id']); ?>" title="<?php echo htmlentities($v['username']); ?>"  <?php if(isset($v['checked'])): ?> checked="checked" <?php endif; ?>>
                        <?php endforeach; endif; else: echo "" ;endif; ?>

                    </div>
                </div>

                <div class="layui-form-item layui-layout-admin " style="width: 100%">
                    <div class="layui-input-block">
                        <div class="layui-footer" style="left: 0px;text-align: center;">
                            <button class="layui-btn" lay-submit="" lay-filter="add">提交</button>
                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
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
            lucky.FormSubmit("<?php echo url('userGroup'); ?>",data.field,true);
            return false;
        });
    })
</script>



</body>
</html>