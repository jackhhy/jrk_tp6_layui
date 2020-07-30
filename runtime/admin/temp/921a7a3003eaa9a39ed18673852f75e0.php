<?php /*a:2:{s:67:"D:\phpstudy_pro\WWW\jrk_tp6\app\admin\view\auth_rule\auth_rule.html";i:1596107433;s:61:"D:\phpstudy_pro\WWW\jrk_tp6\app\admin\view\public\window.html";i:1596107433;}*/ ?>

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
                    <label class="layui-form-label">上级菜单：</label>
                    <div class="layui-input-block">
                        <select name="pid" lay-search="">
                            <option value="0" <?php if($pid == '0'): ?> selected <?php endif; ?>>顶级菜单</option>
                            <?php if(is_array($tree) || $tree instanceof \think\Collection || $tree instanceof \think\Paginator): $i = 0; $__LIST__ = $tree;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$t): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo htmlentities($t['id']); ?>" <?php if($pid == $t['id']): ?> selected <?php endif; ?>><?php echo htmlentities($t['title_show']); ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="font_family" value="fa">

                <?php if(isset($info['id'])): ?>
                <input type="hidden" name="id" value="<?php echo htmlentities($info['id']); ?>">
                <?php endif; ?>

                <input type="hidden" name="__token__" id="token" value="<?php echo token(); ?>"/>

                <div class="layui-form-item">
                    <label class="layui-form-label label-required-next">菜单名称：</label>
                    <div class="layui-input-block input-custom-width" style="">
                        <input type="text" name="title" value="" placeholder="请输入菜单或按钮名称" lay-verify="required" lay-vertype="tips" lay-reqtext="请输入菜单名称" autocomplete="off" class="layui-input ">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label  class="layui-form-label">菜单图标：</label>
                    <div class="layui-input-block">
                        <input type="text" id="iconPicker" name="icon" value="" lay-filter="iconPicker" class="hide">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label label-required-next">是否菜单：</label>
                    <div class="layui-input-inline input-custom-width">
                        <input type="radio" name="type" value="1" title="菜单" lay-filter=""  checked>
                        <input type="radio" name="type" value="2" title="按钮" lay-filter="" >
                    </div>
                    <label class="layui-form-label label-required-next">权限验证：</label>
                    <div class="layui-input-inline input-custom-width">
                        <input type="radio" name="auth_open" value="1" title="是" lay-filter=""  checked>
                        <input type="radio" name="auth_open" value="2" title="否" lay-filter="" >
                        <p class="help-block">是否将该菜单加入权限验证！</p>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">地址：<!--<br><span class="nowrap color-desc">允许类型</span>--></label>
                    <div class="layui-input-block input-custom-width" style="">
                        <input type="text" name="name" value="" placeholder="请求地址" lay-verify="" lay-vertype="tips" lay-reqtext="请求地址" autocomplete="off" class="layui-input ">
                        <p class="help-block">格式例如：AuthRule/index（控制器名/方法名）</p>
                    </div>

                </div>


                <div class="layui-form-item">
                    <label class="layui-form-label">是否禁止：</label>
                    <div class="layui-input-inline input-custom-width">
                        <input type="radio" name="status" value="1" title="正常" lay-filter=""  checked>
                        <input type="radio" name="status" value="0" title="禁止" lay-filter="" >
                    </div>
                    <div class="layui-form-mid layui-word-aux"></div>

                    <label class="layui-form-label label-required-next">菜单排序：</label>
                    <div class="layui-input-inline input-custom-width">
                        <input type="number" name="sort"  value="0"   placeholder="排序" lay-verify="" lay-verType="tips" lay-reqText="排序"  autocomplete="off"  class="layui-input">
                        <p class="help-block">数字越大越靠前</p>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">其它参数：</label>
                    <div class="layui-input-block input-custom-width" style="">
                        <input type="text" name="param" value="" placeholder="" lay-verify="" autocomplete="off" class="layui-input ">
                        <p class="help-block">控制器地址请求带的其它参数</p>
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
    layui.use(['element', 'form', 'jquery','iconHhysFa','lucky'], function () {
        var element = layui.element;
        var table = layui.table;
        var form = layui.form;
        var $ = layui.jquery;
        var iconHhysFa = layui.iconHhysFa;
        var lucky=layui.lucky;

        //表单赋值
        var info = <?php echo json_encode($info); ?>;
        form.val("form",info);

        iconHhysFa.render({
            // 选择器，推荐使用input
            elem: '#iconPicker',
            type: 'awsonme',
            // fa 图标接口
            url: "/plugs/font-awesome/less/variables.less",
            // 是否开启搜索：true/false，默认true
            search: true,
            // 是否开启分页：true/false，默认true
            page: true,
            // 每页显示数量，默认12
            limit: 12,
            // 点击回调
            click: function (data) {
                console.log(data);
            },
            // 渲染成功后的回调
            success: function (d) {
                console.log(d);
            }
        });

        form.on('submit(add)', function (data) {
            lucky.FormSubmit("<?php echo url('addAuth'); ?>",data.field,"table_id",1);
            return false;
        });
    })
</script>



</body>
</html>