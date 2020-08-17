<?php /*a:2:{s:72:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\auth_rule\add_node.html";i:1597387577;s:67:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\public\window.html";i:1597630457;}*/ ?>

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
        <!-- <div class="layui-card-header"></div>-->

        <div class="layui-card-body" style="padding: 15px;">
            <form class="layui-form" action="" lay-filter="form">

                <div class="layui-form-item">
                    <label class="layui-form-label">所属菜单：</label>
                    <div class="layui-input-block">
                        <input type="text"  value="<?php echo htmlentities($info['title']); ?>" autocomplete="off" class="layui-input " readonly>
                        <p class="help-block">添加的节点所属菜单！</p>
                    </div>
                </div>
                <input type="hidden" name="pid" value="<?php echo htmlentities($pid); ?>">
                <input type="hidden" name="__token__" id="token" value="<?php echo token(); ?>"/>

                <div class="layui-form-item add_node">
                    <div class="leng layui-row">
                        <label class="layui-form-label label-required-next">名称地址：</label>
                        <div class="layui-input-inline input-custom-width">
                            <input type="text" name="title[]" lay-verify="required" lay-vertype="tips" lay-reqtext="请输入节点名称" value="" autocomplete="off" class="layui-input " placeholder="节点名称">
                        </div>
                        <div class="layui-input-inline input-custom-width">
                            <input type="text" name="name[]"  lay-verify="required" lay-vertype="tips" lay-reqtext="请输入节点地址" value="" autocomplete="off" class="layui-input " placeholder="节点地址">
                        </div>
                        <span style="float: right;cursor: pointer;">
                            <i class="layui-icon layui-btn  layui-btn-xs layui-icon-add-circle add"  data-title="添加节点"></i>
                        </span>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label label-required-next">权限验证：</label>
                    <div class="layui-input-inline input-custom-width">
                        <input type="radio" name="auth_open" value="1" title="是" lay-filter=""  checked>
                        <input type="radio" name="auth_open" value="2" title="否" lay-filter="" >
                        <p class="help-block">是否将该菜单加入权限验证！</p>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">是否禁止：</label>
                    <div class="layui-input-inline input-custom-width">
                        <input type="radio" name="status" value="1" title="正常" lay-filter=""  checked>
                        <input type="radio" name="status" value="0" title="禁止" lay-filter="" >
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
    /**
     * 删除
     * @param obj
     */
    function del(obj){
        $(obj).parent().parent().remove();
    }
    layui.use(['element', 'form', 'jquery','iconHhysFa','lucky'], function () {
        var element = layui.element;
        var table = layui.table;
        var form = layui.form;
        var $ = layui.jquery;
        var iconHhysFa = layui.iconHhysFa;
        var lucky=layui.lucky;


        $(".add").click(function () {
            var l=$(".leng").length;
           // alert(l);
            if( l > 5){
                layer.msg("最多只能添加6个节点",{icon:15,time:1000,shade:0.3});
                return false;
            }
            var str='<div class="leng layui-row">\n' +
                '                        <label class="layui-form-label label-required-next">&nbsp;</label>\n' +
                '                        <div class="layui-input-inline input-custom-width">\n' +
                '                            <input type="text" name="title[]"  lay-verify="required" lay-vertype="tips" lay-reqtext="请输入节点名称" value="" autocomplete="off" class="layui-input " placeholder="节点名称">\n' +
                '                        </div>\n' +
                '                        <div class="layui-input-inline input-custom-width">\n' +
                '                            <input type="text" name="name[]" lay-verify="required" lay-vertype="tips" lay-reqtext="请输入节点地址" value="" autocomplete="off" class="layui-input " placeholder="节点地址">\n' +
                '                        </div>\n' +
                '                        <span style="float: right;cursor: pointer;">\n' +
                '                            <i style="color: red;" class="layui-icon layui-icon-delete  delete" onclick="del(this)"  title="删除"></i>\n' +
                '                        </span>\n' +
                '                    </div>';
             $(".add_node").append(str);
        });

        form.on('submit(add)', function (data) {
            lucky.FormSubmit("<?php echo url('addNode'); ?>",data.field,true);
            return false;
        });
    })
</script>



</body>
</html>