<?php /*a:3:{s:70:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\auth_group\index.html";i:1597386627;s:65:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\public\base.html";i:1597383421;s:65:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\public\head.html";i:1597397111;}*/ ?>

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
            <blockquote class="layui-elem-quote layui-text">
                角色组可以有多个,角色有上下级层级关系,如果子角色有角色组和管理员的权限则可以派生属于自己组别的下级角色组或管理员
            </blockquote>
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

<!--模板-->
<script type="text/html" id="operationTpl">
    {{# if(d.id==1){ }}
      超级管理不允许编辑
    {{# }else{ }}
    <a href="javascript:;" class="layui-btn layui-btn-xs <?php echo node('AuthGroup/userGroup'); ?>"  data-title="角色组授权" lay-event="quan"><i class="layui-icon layui-icon-set-fill"></i></a>
    <a href="javascript:;" class="layui-btn layui-btn-normal layui-btn-xs <?php echo node('AuthGroup/addGroups'); ?>"  data-title="编辑" lay-event="edit"><i class="layui-icon"></i></a>
    <a href="javascript:;" class="layui-btn layui-btn-danger layui-btn-xs <?php echo node('AuthGroup/del'); ?>"  data-title="删除" lay-event="del"><i class="layui-icon "></i></a>
    {{# } }}
</script>

<script type="text/html" id="toolbarDemo">
    <button class="layui-btn layui-btn-sm <?php echo node('AuthGroup/addGroups'); ?>" lay-event="add"><i class="layui-icon"></i>新增角色组</button>
    <button class="layui-btn layui-btn-sm layui-btn-primary" lay-event="reload"><i class="fa fa-refresh"></i> 刷新</button>
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
                ,limits:[10,20,30,50]
            },
            id:'table_id',
            height: 'full-100',
            text: {
                none: '暂无相关数据'
            },
            cols: [[
                {field: 'id',  title: 'ID',width:60},
                {field: 'html', width: 160, title: '名称'},
                {field: 'status', title: '状态',width: 100,align: 'center',templet:function (rd) {
                        var s="";
                        if (rd.status==1){
                            s='<span class="layui-badge layui-bg-green">正常</span>';
                        } else {
                            s='<span class="layui-badge layui-bg-black">禁止</span>';
                        }
                        return s;
                    }},
                {field: 'rules',style:'cursor: pointer;',title: '授权节点',minWidth:150},
                {field: 'create_time', title: '添加时间',align: 'center',width:180,sort:true},
                {fixed: 'right',templet: '#operationTpl', width: 160, align: 'center', title: '操作'}
            ]],
            done: function (res) {
                layer.closeAll('loading');
            }
        });

        /**
         * 监听单行工具操作
         */
        table.on('tool(table_id)', function (obj) {
            var data = obj.data;
            var _id=parseInt(data.id);
            var layEvent = obj.event;
            if (layEvent==="quan") {
                var urls = "<?php echo url('userGroup'); ?>?id=" + _id;
                lucky.CreateOpenForm("角色组授权",urls);
            }else if(layEvent==="edit"){
                var url = "<?php echo url('addGroups'); ?>?id=" + _id;
                lucky.CreateOpenForm("编辑", url);
            }else if(layEvent==="del"){
                lucky.FormatData(_id,"<?php echo url('del'); ?>","确认删除吗？");
            }
        });

        table.on('toolbar(table_id)', function(obj) {
            var checkStatus = table.checkStatus(obj.config.id);
            var data = checkStatus.data;
            if(obj.event==="add"){
                lucky.CreateOpenForm("添加角色组","<?php echo url('addGroups'); ?>");
                return false;
            }else if(obj.event==="reload"){
                lucky.CreateReload();
            }

        });

    });

</script >




<script>
    okLoading.close();
</script>
</body>
</html>