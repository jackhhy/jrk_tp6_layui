<?php /*a:3:{s:65:"D:\phpstudy_pro\WWW\jrk_tp6\app\admin\view\queue\queue\index.html";i:1596110728;s:59:"D:\phpstudy_pro\WWW\jrk_tp6\app\admin\view\public\base.html";i:1596107433;s:59:"D:\phpstudy_pro\WWW\jrk_tp6\app\admin\view\public\head.html";i:1596107433;}*/ ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo htmlentities($_name); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" href="/static/css/jrkLoading.css?v=<?php echo time(); ?>"/>
    <script type="text/javascript" src="/static/js/backend/jrk_config.js?v=<?php echo time(); ?>"></script>
    <script type="text/javascript" src="/static/js/backend/jrkLoading.js?v=<?php echo time(); ?>"></script>
    <link href="/plugs/font-awesome/css/font-awesome.css?v=4.7.0" rel="stylesheet">
    <link rel="stylesheet" href="/static/css/animate.min.css" media="all"/>
    <link rel="stylesheet" href="/static/css/jrkadmin.css?v=<?php echo time(); ?>">

    <link rel="stylesheet" href="/static/css/admin.css?v=1">
    <script src="/static/js/jquery.min.js?v=1"></script>
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
                        <label class="layui-form-label">定时任务：</label>
                        <div class="layui-input-inline">
                            <input name="title" class="layui-input" value="" type="text" placeholder="请输入任务名称">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">任务类型：</label>
                        <div class="layui-input-inline">
                            <select name="type" lay-search="">
                                <option value="" >请选择任务类型</option>
                                <?php foreach($typelist as $k=>$v): ?>
                                <option value="<?php echo htmlentities($k); ?>" ><?php echo htmlentities($v); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="layui-inline" style="padding-left: 20px;">
                        <button class="layui-btn icon-btn layui-btn-sm" lay-filter="search" lay-submit="">
                            <i class="layui-icon"></i>搜索
                        </button>
                        <button class="layui-btn icon-btn layui-btn-normal layui-btn-sm" onclick="javascript:window.location.reload();">
                            <i class="layui-icon layui-icon-refresh"></i> 重置
                        </button>
                    </div>

                </div>

            </form>

        </div>

    </div>


    <div class="layui-card">
        <div class="layui-card-body layui-row ">
                <blockquote class="layui-elem-quote layui-text">
                    此功能需要结合Linux的Crontab才可以正常使用，可以定时执行一系列的操作。
                    <br>Linux下使用crontab -e -u 用户名添加一条记录
                    <br>* * * * * /usr/bin/php /www/yoursite/public/index.php /admin/queue.autotask/index > /dev/null  2>&1 &
                </blockquote>
        </div>

    </div>

    <div class="layui-card">

        <div class="layui-card-body">

            <!--表格区-->

            <div class="yys-fluid yys-wrapper">
                <div class="layui-row lay-col-space20">
                    <div class="layui-cos-xs12 layui-col-sm12 layui-col-md12 layui-col-lg12">
                        <section class="yys-body">
                            <div class="yys-body-content clearfix changepwd">
                                <div class="layui-col-lg12 layui-col-md10 layui-col-sm12 layui-col-xs12" style="width:100%">
                                    <div class="user-tables">
                                        <table id="tableFilter" lay-filter="tableFilter"> </table>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



    </div>
</div>


<!-- 主体部分结束 -->
<script type="text/javascript" src="/static/js/clipboard.min.js?v=1"></script>


 <!--js处理区-->

<!--模板-->
<script type="text/html" id="operationTpl">
    <a href="javascript:;" class="layui-btn layui-btn-xs "  data-title="查看日志" lay-event="view"><i class="layui-icon layui-icon-star"></i></a>
    <a href="javascript:;" class="layui-btn layui-btn-normal layui-btn-xs "  data-title="编辑任务" lay-event="edit"><i class="layui-icon"></i></a>
    <a href="javascript:;" class="layui-btn layui-btn-danger layui-btn-xs "  data-title="删除任务" lay-event="del"><i class="layui-icon "></i></a>

</script>

<script type="text/html" id="begintime">
    {{layui.util.toDateString(d.begintime*1000, 'yyyy-MM-dd HH:mm:ss')}}
</script>

<script type="text/html" id="endtime">
    {{layui.util.toDateString(d.endtime*1000, 'yyyy-MM-dd HH:mm:ss')}}
</script>

<script type="text/html" id="nexttime">
    {{layui.util.toDateString(d.nexttime*1000, 'yyyy-MM-dd HH:mm:ss')}}
</script>

<script type="text/html" id="executetime">
    {{layui.util.toDateString(d.executetime*1000, 'yyyy-MM-dd HH:mm:ss')}}
</script>

<script type="text/html" id="status">
    <input type="checkbox" name="status"  lay-data="{{d.status}}" value="{{d.id}}"  lay-filter="status" lay-skin="switch"  lay-text="启用|不启用"  {{ d.status == 1 ? 'checked' : '' }}>
</script>
<script type="text/html" id="toolbarDemo">
    <div class="layui-btn-container">
        <button class="layui-btn layui-btn-sm" lay-event="add"><i class="layui-icon"></i>新增定时任务</button>
        <button class="layui-btn layui-btn-sm layui-btn-danger" lay-event="del"><i class="layui-icon layui-icon-delete"></i>删除</button>
        <button class="layui-btn layui-btn-sm layui-btn-primary" lay-event="reload"><i class="fa fa-refresh"></i> 刷新</button>
    </div>
</script>

<script>
    layui.use(['element', 'table', 'form', 'jquery', 'lucky'], function () {
        var element = layui.element;
        var form = layui.form;
        var table = layui.table;
        var $ = layui.jquery;
        var lucky=layui.lucky;
        form.render();
        table.render({
            elem: '#tableFilter',
            url:"<?php echo url('index'); ?>",
            toolbar: '#toolbarDemo', //开启头部工具栏，并为其绑定左侧模板
            defaultToolbar: ['filter', 'exports', 'print'],
            even: true, //开启隔行背景
            id:'table_id',
            page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
                layout: ['limit', 'count', 'prev', 'page', 'next', 'skip','last'] //自定义分页布局
                //,curr: 5 //设定初始在第 5 页
                ,groups: 5 //只显示 1 个连续页码
                ,first: false //不显示首页
                ,last: false //不显示尾页
                ,limit:50
                ,limits:[50,60,70,80]
            },
            //height: 'full-100',
            text: {
                none: '暂无相关数据'
            },
            cols: [[
                {type: 'checkbox'},
                {field: 'id',  title: 'ID',width:60},
                {field: 'type_text', width: 110, title: '类型', align: 'center'},
                {field: 'title', width: 110, title: '任务标题', align: 'center'},
                {field: 'maximums', width: 110, title: '最多执行', template:function (d) {
                        if (d.maximums==0){
                            return "无限制";
                        } else {
                            return  d.maximums;
                        }
                    }},
                {field: 'executes', width: 110, title: '执行次数', align: 'center'},
                {field: 'begintime', width: 160, title: '开始时间',templet:"#begintime"},
                {field: 'endtime', width: 160, title: '结束时间',templet:"#endtime"},
                {field: 'nexttime', width: 160, title: '下预计时间',templet:"#nexttime"},
                {field: 'executetime', width: 160, title: '最后执行时间',templet:"#executetime"},
                {field: 'weigh', width: 60, title: '权重'},
                {field: 'status', width: 85, title: '状态'},
                {fixed: 'right',templet: '#operationTpl', width: 140, align: 'center', title: '操作'}
            ]],
            done: function (res) {
                layer.closeAll('loading');
            }
        });

        /**
         * 表格搜索
         */
        form.on('submit(search)', function (obj) {
            lucky.CreateSearch("table_id",obj.field); //查询
            return false;
        });


        /**
         * 监听单行工具操作
         */
        table.on('tool(tableFilter)', function (obj) {
            var data = obj.data;
            var _id=parseInt(data.id);
            var layEvent = obj.event;
            if(layEvent==="edit"){
                var url="<?php echo url('editQueue'); ?>?id="+_id;
                lucky.CreateOpenForm("编辑任务",'65%','85%',url,"table_id");
            }else if(layEvent==="del"){
                lucky.FormatData(_id,"<?php echo url('del'); ?>","table_id");
            }else if(layEvent==="view"){
                var url="<?php echo url('viewQueueLog'); ?>?id="+_id;
                lucky.CreateOpenForm("查看日志",'65%','85%',url,"table_id",1);
            }
        });
        table.on('toolbar(tableFilter)', function(obj) {
            var checkStatus = table.checkStatus(obj.config.id);
            var data = checkStatus.data;
            if(obj.event==="add"){
                lucky.CreateOpenForm("添加任务",'65%','85%',"<?php echo url('addQueue'); ?>",obj.config.id,1);
                return false;
            }else if(obj.event==="del"){
                var num=0;
                var id=[];
                for (var i in data) {
                    num++;
                    id.push(data[i].id);
                }
                if (num<1) {
                    layer.msg("请选择一项",{time:1500});return false;
                }
                lucky.FormatData(id,"<?php echo url('del'); ?>",obj.config.id);
                return  false;
            }else if(obj.event==="reload"){
                lucky.CreateReload(obj.config.id);
            }

        });

    });

</script >




<script>
    okLoading.close();
</script>
</body>
</html>