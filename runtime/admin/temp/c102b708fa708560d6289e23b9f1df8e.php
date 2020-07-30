<?php /*a:3:{s:73:"D:\phpstudy_pro\WWW\jrk_tp6\app\admin\view\config\sysconfigtab\index.html";i:1596113458;s:59:"D:\phpstudy_pro\WWW\jrk_tp6\app\admin\view\public\base.html";i:1596107433;s:59:"D:\phpstudy_pro\WWW\jrk_tp6\app\admin\view\public\head.html";i:1596107433;}*/ ?>

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
                        <label class="layui-form-label">配置名称：</label>
                        <div class="layui-input-inline">
                            <input name="title" class="layui-input"  value="" type="text" placeholder="请输入配置名称">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label">状态：</label>
                        <div class="layui-input-inline">
                            <select class="layui-select" name="status">
                                <option value="">所有</option>
                                <option value="2">正常</option>
                                <option value="1">停用</option>
                            </select>
                        </div>
                    </div>


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
            <table class="layui-hide" id="tableFilter" lay-filter="tableFilter"></table>
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
    <a href="javascript:;" class="layui-btn layui-btn-normal layui-btn-xs <?php echo node('config.Sysconfigtab/update'); ?>"  data-title="编辑" lay-event="edit"><i class="layui-icon"></i></a>
    {{# if(d.id!=1){  }}
    <a href="javascript:;" class="layui-btn layui-btn-danger layui-btn-xs <?php echo node('config.Sysconfigtab/del'); ?>"  data-title="删除" lay-event="del"><i class="layui-icon "></i></a>
    {{# } }}

</script>

<script type="text/html" id="toolbarDemo">
    <button class="layui-btn layui-btn-sm <?php echo node('config.Sysconfigtab/addConfigTab'); ?>" lay-event="add"><i class="layui-icon"></i>新增</button>
    <button class="layui-btn layui-btn-sm layui-btn-primary" lay-event="reload"><i class="fa fa-refresh"></i> 刷新</button>
    <button class="layui-btn layui-btn-sm <?php echo node('config.Sysconfigtab/del'); ?> layui-btn-danger" lay-event="del"><i class="layui-icon layui-icon-delete"></i>批量删除</button>
</script>
<!-- 链接 -->
<script type="text/html" id="status">
    {{# if(d.status==1){ }}
    <span class="layui-badge layui-bg-blue">正常</span>
    {{# }else{ }}
    <span class="layui-badge layui-bg-gray">禁止</span>
    {{# } }}
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
            ,range: '~'
        });


        table.render({
            elem: '#tableFilter',
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
                ,limits:[20,30,50]
            },
            id:'table_id',
            height: 'full-100',
            text: {
                none: '暂无相关数据'
            },
            cols: [[
                {type:'checkbox'},
                {field: 'id',  title: 'ID',width:60},
                {field: 'title', minWidth: 100, title: '分类名'},
                {field: 'eng_title', width: 250, title: '英文名'},
                {field: 'status', width: 100, title: '状态',templet: "#status"},
                {field: 'beizhu', width: 200, title: '备注'},
                {field: 'create_time', title: '添加时间',align: 'center',width:180,sort:true},
                {templet: '#operationTpl', width: 120, align: 'center', title: '操作'}
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
        table.on('tool(tableFilter)', function (obj) {
            var data = obj.data;
            var _id=parseInt(data.id);
            var layEvent = obj.event;
            if(layEvent==="del"){
                lucky.FormatData(_id,"<?php echo url('del'); ?>","table_id","确认删除吗？");
            }else if(layEvent==="edit"){
                var url = "<?php echo url('update'); ?>?id=" + _id;
                lucky.CreateOpenForm("编辑", '55%', '73%', url, "table_id");
            }
        });

        table.on('toolbar(tableFilter)', function(obj) {
            var checkStatus = table.checkStatus(obj.config.id);
            var data = checkStatus.data;

            if(obj.event==="add"){
                lucky.CreateOpenForm("添加配置分类",'55%','73%',"<?php echo url('addConfigTab'); ?>",obj.config.id);
                return false;
            }else if(obj.event==="reload"){
                lucky.CreateReload(obj.config.id);
            }else if(obj.event==="del"){
                var num=0;
                var id=[];
                for (var i in data) {
                    num++;
                    id.push(data[i].id);
                }
                if (id.length <1){
                    layer.msg("请至少选择一个",{icon:15,time:1000,shade:0.3});
                    return  false;
                }
                lucky.FormatData(id,"<?php echo url('del'); ?>",obj.config.id,"确认删除选择的配置分类吗？");
            }
        });

    });

</script >




<script>
    okLoading.close();
</script>
</body>
</html>