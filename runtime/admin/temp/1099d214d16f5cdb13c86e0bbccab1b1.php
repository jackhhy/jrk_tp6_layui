<?php /*a:2:{s:70:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\article_cate\add.html";i:1597645657;s:67:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\public\window.html";i:1597630457;}*/ ?>

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
            <form class="layui-form" action="" lay-filter="form">


                        <div class="layui-form-item">
                            <label class="layui-form-label">上级栏目：</label>
                            <div class="layui-input-block">
                                <select name="pid" lay-verify="required" >
                                    <option value="0">顶级栏目</option>
                                    <?php echo htmlentities(make_option($tree,'','title_show','id')); ?>
                                </select>
                            </div>
                            <div class="layui-form-mid layui-word-aux"></div>
                        </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">选择模型：</label>
                                <div class="layui-input-block">
                                    <select name="model_id" lay-verify="required" >
                                        <option value="0">请选择</option>
                                        <?php echo htmlentities(make_option($models,'','name','id')); ?>
                                    </select>
                                </div>
                                <div class="layui-form-mid layui-word-aux"></div>
                            </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">栏目名称：</label>
                                <div class="layui-input-block input-custom-width" style="">
                                    <input type="text" name="name" value="" placeholder="请输入栏目名称" lay-verify="required" lay-vertype="tips" lay-reqtext="请输入栏目名称" autocomplete="off" class="layui-input ">
                                </div>
                            </div>


                            <div class="layui-form-item">
                                <label class="layui-form-label">外部链接：</label>
                                <div class="layui-input-block input-custom-width" style="">
                                    <input type="text" name="urls" value="" placeholder="请输入" lay-verify="" lay-vertype="tips" lay-reqtext="请输入" autocomplete="off" class="layui-input ">
                                    <p class="help-block">当选择链接模型的时候有效,链接需http://或https://开头,当选择链接模型的时候有效！</p>
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">是否显示：</label>
                                <div class="layui-input-inline input-custom-width">
                                    <input type="radio" name="is_show" value="1" title="显示" lay-filter=""  checked>
                                    <input type="radio" name="is_show" value="0" title="不显示" lay-filter="" >
                                </div>

                                <label class="layui-form-label">排序：</label>
                                <div class="layui-input-inline input-custom-width">
                                    <input type="number" name="sort" value="0" min="0" class="layui-input" >
                                </div>
                                <div class="layui-form-mid layui-word-aux"></div>
                            </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">描述：</label>
                                <div class="layui-input-block input-custom-width" style="">
                                    <textarea name="description" placeholder="" lay-verify=""  autocomplete="off" class="layui-textarea"></textarea>
                                </div>
                            </div>

                            <?php if(isset($info['id'])): ?>
                            <input type="hidden" name="id" value="<?php echo htmlentities($info['id']); ?>">
                            <?php endif; ?>

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