<?php /*a:2:{s:69:"D:\phpstudy_pro\WWW\jrk_tp6\app\admin\view\queue\queue\add_queue.html";i:1596110967;s:61:"D:\phpstudy_pro\WWW\jrk_tp6\app\admin\view\public\window.html";i:1596107433;}*/ ?>

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

        <div class="layui-card-body" style="padding: 15px;">
            <form class="layui-form" action="" lay-filter="form">

                <div class="layui-form-item">
                    <label class="layui-form-label label-required-next">任务名称：</label>
                    <div class="layui-input-block input-custom-width" style="">
                        <input type="text" name="title" value="" placeholder="请输入任务名称" lay-verify="required" lay-vertype="tips" lay-reqtext="请输入任务名称" autocomplete="off" class="layui-input ">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">任务类型：</label>
                    <div class="layui-input-block">
                        <select name="type" lay-search="">
                            <?php foreach($typelist as $k=>$v): ?>
                            <option value="<?php echo htmlentities($k); ?>" ><?php echo htmlentities($v); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <?php if(isset($info['id'])): ?>
                <input type="hidden" name="id" value="<?php echo htmlentities($info['id']); ?>" >
                <?php endif; ?>

                <div class="layui-form-item">
                    <label class="layui-form-label">内容：</label>
                    <div class="layui-input-block input-custom-width" style="">
                        <textarea name="content" placeholder="" lay-verify="required"  autocomplete="off" class="layui-textarea "></textarea>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label label-required-next">执行周期：</label>
                    <div class="layui-input-block input-custom-width" style="">
                        <input type="text" name="schedule" id="schedule" value="* * * * *" style="font-size:12px;font-family: Verdana;word-spacing:23px;"  lay-verify="required" lay-vertype="tips" lay-reqtext="请输入执行周期" autocomplete="off" class="layui-input ">
                    </div>
                    <div style="margin-left: 100px;">
                        <pre class="layui-code">*    *    *    *    *
-    -    -    -    -
|    |    |    |    +--- day of week (0 - 7) (Sunday=0 or 7)
|    |    |    +-------- month (1 - 12)
|    |    +------------- day of month (1 - 31)
|    +------------------ hour (0 - 23)
+----------------------- min (0 - 59)</pre>
                    </div>

                    <h5 style="margin-left: 110px;font-size: 12px;">接下来<input type="number" id="pickdays" class="layui-input" value="7" style="display: inline-block;width:80px;">次的执行时间</h5>

                    <div style="margin-top: 10px;margin-left: 110px;">
                        <table class="layui-table" lay-size="sm">
                            <thead>
                            <tr>
                                <th>时间</th>
                            </tr>
                            </thead>
                            <tbody id="scheduleresult">
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label label-required-next">最多执行：</label>
                    <div class="layui-input-inline input-custom-width" style="">
                        <input type="number" name="maximums" value="0" size="6" lay-verify="required" lay-vertype="tips" autocomplete="off" class="layui-input ">
                    </div>
                    <label class="layui-form-label label-required-next">权重：</label>
                    <div class="layui-input-inline " style="">
                        <input type="number" name="weigh" value="0" size="6" lay-verify="required" lay-vertype="tips" autocomplete="off" class="layui-input ">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label label-required-next">开始时间：</label>
                    <div class="layui-input-inline input-custom-width" style="">
                        <input type="text" name="begintime" value="" id="test5" placeholder="yyyy-MM-dd HH:mm:ss" lay-verify="required" lay-vertype="tips" autocomplete="off" class="layui-input ">
                    </div>
                    <label class="layui-form-label label-required-next">结束时间：</label>
                    <div class="layui-input-inline input-custom-width" style="">
                        <input type="text" name="endtime" id="test6"  lay-verify="required" placeholder="yyyy-MM-dd HH:mm:ss" lay-vertype="tips" autocomplete="off" class="layui-input ">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label label-required-next">状态：</label>
                    <div class="layui-input-block input-custom-width">
                        <input type="radio" name="status" value="normal" title="正常" lay-filter=""  checked>
                        <input type="radio" name="status" value="hidden" title="禁用" lay-filter="" >
                        <input type="radio" name="status" value="completed" title="已完成" lay-filter="" >
                        <input type="radio" name="status" value="expired" title="已过期" lay-filter="" >
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
    layui.use(['element', 'form', 'jquery','lucky','code','laydate'], function () {
        var element = layui.element;
        var table = layui.table;
        var form = layui.form;
        var $ = layui.jquery;
        var lucky=layui.lucky;
        var laydate = layui.laydate;

        layui.code();

        //日期时间选择器
        laydate.render({
            elem: '#test5'
            ,type: 'datetime'
        });

        //日期时间选择器
        laydate.render({
            elem: '#test6'
            ,type: 'datetime'
        });


        var info = <?php echo json_encode($info); ?>;
        form.val("form", info);
        form.render();

        $('#schedule').on('valid.field', function (e, result) {
            $("#pickdays").trigger("change");
        });

        $(document).on("change", "#pickdays", function () {
                $.post("<?php echo url('get_schedule_future'); ?>",{schedule: $("#schedule").val(), days: $(this).val()},function (data) {
                    var result = [];
                    $.each(data.data, function (i, j) {
                        result.push("<tr><td>" + j + "</td></tr>")
                    });
                    console.log(data);
                    $("#scheduleresult").append(result.join(""));

            });

        });
        $("#pickdays").trigger("change");

        form.on('submit(add)', function (data) {
            lucky.FormSubmit("<?php echo url('addQueue'); ?>",data.field,"table_id",1);
            return false;
        });
    })
</script>



</body>
</html>