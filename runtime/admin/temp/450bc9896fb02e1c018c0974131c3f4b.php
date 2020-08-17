<?php /*a:3:{s:71:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\data_backup\index.html";i:1597388093;s:65:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\public\base.html";i:1597383421;s:65:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\public\head.html";i:1597626924;}*/ ?>

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

        

<div class="layui-col-md12">
    <div class="layui-card">

        <div class="layui-card-body">

            <div class="layui-form">
                <a id="export" class="layui-btn layui-btn-sm" href="javascript:;" autocomplete="off">立即备份</a>
                <a id="optimize " href="javascript:" class="layui-btn layui-btn-sm">优化表</a>
                <a id="repair" href="javascript:" class="layui-btn layui-btn-sm">修复表</a>
                <a  id="huanyuan" href="javascript:" class="layui-btn layui-btn-sm">还原数据库</a>
                <form id="export-form" method="post" action="<?php echo url('DataBackup/export'); ?>">
                    <table class="layui-table" lay-size="sm">
                        <thead>
                        <tr>
                            <th width="48"><input lay-skin="primary" class="check-all" checked="chedked" type="checkbox" value=""></th>
                            <th>表名</th>
                            <th>数据量</th>
                            <th>数据大小</th>
                            <th>数据引擎</th>
                            <th>排序规则</th>
                            <th>表注释</th>
                            <th>创建时间</th>
                            <th>备份状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): if( count($list)==0 ) : echo "" ;else: foreach($list as $key=>$table): ?>
                        <tr>
                            <td>
                                <input class="ids" checked="chedked" lay-skin="primary" type="checkbox" name="tables[]" value="<?php echo htmlentities($table['name']); ?>">
                            </td>
                            <td><?php echo htmlentities($table['name']); ?></td>
                            <td><?php echo htmlentities($table['rows']); ?></td>
                            <td><?php echo htmlentities(format_bytes($table['data_length'])); ?></td>
                            <td><?php echo htmlentities($table['engine']); ?></td>
                            <td><?php echo htmlentities($table['collation']); ?></td>
                            <td><?php echo htmlentities($table['comment']); ?></td>
                            <td><?php echo htmlentities($table['create_time']); ?></td>
                            <td class="info">备份未开始</td>
                            <td>
                                <a  class="optimize layui-btn layui-btn-xs " data-dz="<?php echo url('DataBackup/optimize',['tables'=>$table['name']]); ?>" href="javascript:">优化表</a>&nbsp;
                                <a  class="repair layui-btn layui-btn-xs layui-btn-warm" data-dz="<?php echo url('DataBackup/repair',['tables'=>$table['name']]); ?>" href="javascript:">修复表</a>
                                <a  href="javascript:;" class="layui-btn layui-btn-xs layui-btn-normal show" data-table="<?php echo htmlentities($table['name']); ?>">查看表</a>
                            </td>
                        </tr>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>


                    </table>
                </form>
            </div>

        </div>
    </div>

</div>



    </div>
</div>


<!-- 主体部分结束 -->
<script type="text/javascript" src="/static/js/clipboard.min.js?v=1"></script>


 <!--js处理区-->

<script>
    layui.use(['element', 'table', 'form', 'jquery', 'okTab','lucky'], function () {
        var element = layui.element;
        var form = layui.form;
        var table = layui.table;
        var $ = layui.jquery;
        var lucky=layui.lucky;
        var okTab=layui.okTab();
        form.render();

        /**
         * 查看表详细
         */
        $(".show").click(function () {
            var table=$(this).attr("data-table");
            lucky.CreateOpenForm("查看表详情","/admin/DataBackup/showtable/table/"+table,"70%","75%");
            return false;
        });


        /**
         * 还原数据库
         */
        $("#huanyuan").click(function () {
            var url = "<?php echo url('DataBackup/importlist'); ?>";
            var page = '<div lay-id="add-1" data-url="' + url + '"><cite>还原数据库</cite></div>';
            okTab.tabAdd(page);
        });

        //备份表方法
        $("#export").click(function(){
            $(this).html("正在发送备份请求...");
            $.post("<?php echo url('DataBackup/export'); ?>",$("#export-form").serialize(),function (res) {
                if(res.code==1){
                    $("#export").html( "开始备份，请不要关闭本页面！");
                    backup(res.data.tab);
                    window.onbeforeunload = function(){ return "正在备份数据库，请不要关闭！" }
                }else{
                    layer.tips(res.msg, "#export", {
                        tips: [1, '#3595CC'],
                        time: 4000
                    });
                    $("#export").html("立即备份");
                }
            });
            return false;
        });
        //递归备份表
        function backup(tab,status){
            status && showmsg(tab.id, "开始备份...(0%)");
            $.get( $("#export-form").attr("action"), tab, function(data){
                // console.log(data)
                if(data.code==1){
                    showmsg(tab, data.msg);

                    if(!$.isPlainObject(data.data.tab)){
                        $("#export").html("备份完成");
                        window.onbeforeunload = function(){ return null }
                        return;
                    }

                    backup(data.data.tab, tab.id != data.data.tab.id);
                } else {
                    $("#export").html("立即备份");
                }
            }, "json");

        }
        //修改备份状态
        function showmsg(tab, msg){
            $("table tbody tr").eq(tab.id).find(".info").html(msg)
        }


        $(".optimize").click(function () {
            $.post($(this).attr("data-dz"), {}, function(data){
                if (data.code==1){
                    layer.msg(data.msg,{icon:1,time:1000,shade:0.3});
                }else {
                    layer.msg(data.msg,{icon:15,time:1000,shade:0.3});
                }
            }, "json");
            return false;
        });

        $(".repair").click(function () {
            $.post($(this).attr("data-dz"), {}, function(data){
                if (data.code==1){
                    layer.msg(data.msg,{icon:1,time:1000,shade:0.3});
                }else {
                    layer.msg(data.msg,{icon:15,time:1000,shade:0.3});
                }
            }, "json");
            return false;
        });


        //优化表
        $("#optimize").click(function(){
            $.post("<?php echo url('DataBackup/optimize'); ?>", $("#export-form").serialize(), function(data){
                if (data.code==1){
                    layer.msg(data.msg,{icon:1,time:1000,shade:0.3});
                }else {
                    layer.msg(data.msg,{icon:15,time:1000,shade:0.3});
                }
            }, "json");
            return false;
        });

        //修复表
        $("#repair").on("click",function(e){
            $.post("<?php echo url('DataBackup/repair'); ?>", $("#export-form").serialize(), function(data){
                if (data.code==1){
                    layer.msg(data.msg,{icon:1,time:1000,shade:0.3});
                }else {
                    layer.msg(data.msg,{icon:15,time:1000,shade:0.3});
                }
            }, "json");
            return false;
        });
    });


</script >




<script>
    okLoading.close();
</script>
</body>
</html>