<?php /*a:3:{s:70:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\system_log\index.html";i:1597389042;s:65:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\public\base.html";i:1597383421;s:65:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\public\head.html";i:1597397144;}*/ ?>

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
        <div class="layui-card-body layui-row ">

            <form action="" class="layui-form" method="get">
                <div class="layui-form-item layui-form-pane">

                    <div class="layui-inline">
                        <label class="layui-form-label">选择时间：</label>
                        <div class="layui-input-inline">
                            <input name="time" class="layui-input" id="time" value="" type="text" placeholder="请选择日期范围">
                        </div>
                    </div>

                    <div class="layui-inline" style="padding-left: 20px;">
                        <button class="layui-btn icon-btn layui-btn-sm" data-id="table_id" lay-filter="search" lay-submit="">
                            <i class="layui-icon"></i>搜索
                        </button>
                        <button type="reset" class="layui-btn icon-btn layui-btn-normal layui-btn-sm">重置</button>
                    </div>
                </div>
            </form>

        </div>

    </div>
    <div class="layui-card">
        <div class="layui-card-body">
            <!--表格区-->
            <table class="layui-hide" id="table_id" lay-filter="table_id"></table>
        </div>
    </div>

</div>



    </div>
</div>


<!-- 主体部分结束 -->
<script type="text/javascript" src="/static/js/clipboard.min.js?v=1"></script>


 <!--js处理区-->


<script type="text/html" id="toolbarDemo">
    <button class="layui-btn layui-btn-sm layui-btn-primary" lay-event="reload"><i class="fa fa-refresh"></i> 刷新</button>
    <button class="layui-btn layui-btn-sm <?php echo node('SystemLog/del'); ?> layui-btn-danger" lay-event="del"><i class="layui-icon layui-icon-delete"></i>删除</button>
</script>

<script>
    layui.use(['element', 'table', 'form', 'jquery', 'lucky','laydate'], function () {
        var element = layui.element;
        var form = layui.form;
        var table = layui.table;
        var $ = layui.jquery;
        var lucky=layui.lucky;
        var laydate = layui.laydate;

        form.render();

        //日期范围
        laydate.render({
            elem: '#time'
            ,type: 'month'
        });
        table.render({
            elem: '#table_id',
            url:"<?php echo url('index'); ?>",
            toolbar: '#toolbarDemo', //开启头部工具栏，并为其绑定左侧模板
            defaultToolbar: ['filter', 'exports', 'print'],
            even: true, //开启隔行背景
            page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
                layout: ['limit', 'count', 'prev', 'page', 'next', 'skip','last'] //自定义分页布局
                ,groups: 5 //只显示 1 个连续页码
                ,first: false //不显示首页
                ,last: false //不显示尾页
                ,limit:20
                ,limits:[20,30,50,100,200]
            },
            id:'table_id',
            height: 'full-100',
            text: {
                none: '暂无相关数据'
            },
            cols: [[
                {type:'checkbox'},
                {field: 'id',  title: 'ID',width:60},
                {field: 'title', width: 100, title: '请求者'},
                {field: 'method', width: 80, title: '方式'},
                {field: 'url', width: 150, title: '地址'},
                {field: 'ip', width: 120, title: 'IP'},
                {field: 'os', width: 100, title: '操作系统'},
                {field: 'brower', width: 130, title: '浏览器'},
                {field: 'content', minWidth: 150, title: '请求内容'},
                {field: 'create_time', title: '添加时间',align: 'center',width:180,sort:true,templet: function (d) {
                    return lucky.timeToTime(d.create_time,2);
                    }},
            ]],
            done: function (res) {
                layer.closeAll('loading');
            }
        });

        /**
         * 关键词搜索树
         */
        form.on('submit(search)', function (obj) {
            lucky.CreateSearch("table_id",obj.field);
            return false;
        });


        /**
         * 监听单行工具操作
         */
        table.on('tool(table_id)', function (obj) {
            var data = obj.data;
            var _id=parseInt(data.id);
            var layEvent = obj.event;
            if(layEvent==="del"){
                lucky.FormatData(_id,"<?php echo url('del'); ?>","确认删除吗？");
            }
        });

        table.on('toolbar(table_id)', function(obj) {
            var checkStatus = table.checkStatus(obj.config.id);
            var data = checkStatus.data;
            if(obj.event==="reload"){
                lucky.CreateReload();
            }else if(obj.event==="del"){
                var num=0;
                var id=[];
                for (var i in data) {
                    num++;
                    id.push(data[i].id);
                }
                if (id.length <1){
                    layer.msg("请至少选择一个附件",{icon:15,time:1000,shade:0.3});
                    return  false;
                }
               var time_=$("#time").val();
                layer.confirm("确定删除选中的日志", {skin: lucky.randomSkin(), icon: 3, title: "提示", anim: lucky.randomAnim()},function(index){
                    layer.close(index);
                    $.ajax({
                        beforeSend:function(){
                        },
                        url: "<?php echo url('del'); ?>",
                        type: "post",
                        async: true,
                        dataType: "json",
                        data:{id:id,times:time_},
                        error: function(error) {
                            layer.msg("服务器错误或超时");
                            return false;
                        },
                        success: function(data) {
                            if (data.code==1) {
                                   lucky.layerMsg(data.msg,1,function () {
                                       setTimeout(function(){
                                           lucky.CreateReload();//重载表格
                                       },500);
                                   });
                            }else{
                                lucky.layerMsg(data.msg,15);
                            }
                        },
                        complete:function(){
                        }
                    });
                });
            }
        });

    });

</script >




<script>
    okLoading.close();
</script>
</body>
</html>