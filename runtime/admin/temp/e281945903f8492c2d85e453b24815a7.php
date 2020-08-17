<?php /*a:2:{s:68:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\friendlink\add.html";i:1597396352;s:67:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\public\window.html";i:1597384879;}*/ ?>

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
            <form class="layui-form" action="" lay-filter="form">
                <div class="layui-form-item">
                    <label class="layui-form-label">所属平台：</label>
                    <div class="layui-input-block">
                        <select name="site_link" lay-search="">
                            <?php if(is_array($site_link) || $site_link instanceof \think\Collection || $site_link instanceof \think\Paginator): $i = 0; $__LIST__ = $site_link;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$t): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo htmlentities($key); ?>" ><?php echo htmlentities($t); ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>

                    </div>
                </div>

                <?php if(isset($info['id'])): ?>
                <input type="hidden" name="id" value="<?php echo htmlentities($info['id']); ?>">
                <?php endif; ?>

                <input type="hidden" name="__token__" id="token" value="<?php echo token(); ?>"/>

                <div class="layui-form-item">
                    <label class="layui-form-label label-required-next">友链名称：</label>
                    <div class="layui-input-block input-custom-width" style="">
                        <input type="text" name="name" value="" placeholder="请输入友链名称" lay-verify="required" lay-vertype="tips" lay-reqtext="请输入友链名称" autocomplete="off" class="layui-input ">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label label-required-next">友链地址：</label>
                    <div class="layui-input-block input-custom-width" style="">
                        <input type="text" name="url" value="" placeholder="请输入友链地址" lay-verify="required|url" lay-vertype="tips" lay-reqtext="请输入友链地址" autocomplete="off" class="layui-input ">
                        <p class="help-block">地址以http://开头！！！</p>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">状态：</label>
                    <div class="layui-input-inline input-custom-width">
                        <input type="radio" name="status" value="1" title="正常" lay-filter=""  checked>
                        <input type="radio" name="status" value="0" title="禁止" lay-filter="" >
                    </div>
                    <div class="layui-form-mid layui-word-aux"></div>
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

        //表单赋值
        var info = <?php echo json_encode($info); ?>;
        form.val("form",info);

        form.on('submit(add)', function (data) {
            lucky.FormSubmit("<?php echo url('upAndAdd'); ?>",data.field,true);
            return false;
        });
    })
</script>



</body>
</html>