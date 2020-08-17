<?php /*a:3:{s:65:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\admin\index.html";i:1597386627;s:65:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\public\base.html";i:1597383421;s:65:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\public\head.html";i:1597397144;}*/ ?>

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
                        <label class="layui-form-label">管理员：</label>
                        <div class="layui-input-inline">
                            <input name="username" class="layui-input" id="title" value="" type="text" placeholder="请输入用户名">
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
    <div class="layui-btn-container">
        <button type="button" lay-event="add"  class="layui-btn <?php echo node('Admin/addAdmin'); ?> layui-btn-sm">添加管理员</button>
        <button type="button" lay-event="del"  class="layui-btn <?php echo node('Admin/del'); ?> layui-btn-sm layui-btn-danger">删除管理员</button>
        <button type="button" lay-event="close"  class="layui-btn  layui-btn-sm">关闭所有</button>
        <button type="button" lay-event="open"  class="layui-btn  layui-btn-sm">展开所有</button>
        <button type="button" lay-event="reload"  class="layui-btn  layui-btn-sm  layui-btn-primary">刷新表格</button>
    </div>
</script>


<script type="text/html" id="operationTpl">
    {{# if(d.id==1){ }}
     不可编辑
    {{# }else{ }}
    <a href="javascript:;" class="layui-btn layui-btn-normal layui-btn-xs <?php echo node('Admin/addAdmin'); ?>" data-title="编辑管理员" lay-event="edit"><i class="layui-icon"></i></a>
    <a href="javascript:;" class="layui-btn layui-btn-danger layui-btn-xs <?php echo node('Admin/del'); ?>" data-title="删除管理员" lay-event="del"><i class="layui-icon "></i></a>
    {{# } }}
</script>

<script type="text/html" id="sex">
    {{# if(d.sex==0){ }}
    <span class="layui-badge layui-bg-blue">男</span>
    {{# }else if(d.sex==1){ }}
    <span class="layui-badge layui-bg-orange">女</span>
    {{# }else{ }}
    <span class="layui-badge layui-bg-gray">未知</span>
    {{# } }}
</script>

<script>
    layui.use(['element', 'table', 'form', 'jquery', 'lucky','opTable'], function () {
        var element = layui.element;
        var form = layui.form;
        var table = layui.table;
        var $ = layui.jquery;
        var lucky=layui.lucky;
        var opTable = layui.opTable;
        form.render();

        var opTables = opTable.render({
            elem: '#table_id',
            url:"<?php echo url('index'); ?>",
            toolbar: '#toolbarDemo', //开启头部工具栏，并为其绑定左侧模板
            defaultToolbar: ['filter', 'exports', 'print'],
            even: true, //开启隔行背景
            id:'table_id',
            page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
                layout: ['limit', 'count', 'prev', 'page', 'next', 'skip','last'] //自定义分页布局
                ,groups: 5 //只显示 1 个连续页码
                ,first: false //不显示首页
                ,last: false //不显示尾页
                ,limit:20
                ,limits:[10,20,30,50]
            },
            height: 'full-100',
            // 第一列显示展开
            openColumnIndex: 0,
            // 不单独占一列
            isAloneColumn: true
            , opOrientation: 'h',
            text: {
                none: '暂无相关数据'
            },
            cols: [[
                {field: 'id',  title: 'ID',width:60},
                {field: 'avatar', title: '头像',width: 100,align: 'center',templet:function (rd) {
                        var s="";
                        if (rd.avatar==null || rd.avatar==""){
                            s='暂无';
                        } else {
                            s="<img src='"+rd.avatar+"' class='layui-nav-img' />";
                        }
                        return s;
                    }},
                {field: 'username', width: 130, title: '用户名'},
                {field: 'nickname', width: 130, title: '昵称'},
                {field: 'sex', templet: '#sex', width: 80, title: '性别'},
                {field: 'status', title: '状态',width: 100,align: 'center',templet:function (rd) {
                        var s="";
                        if (rd.status==1){
                            s='<span class="layui-badge layui-bg-green">正常</span>';
                        } else {
                            s='<span class="layui-badge layui-bg-black">禁止</span>';
                        }
                        return s;
                    }},
                {field: 'logins', title: '登录次数',width:90},
                {field: 'login_time', title: '最近登录时间',width:180,templet:function (d) {
                        if (d.login_time===0){
                            return "暂无";
                        }else {
                            return lucky.timeToTime(d.login_time,2);
                        }
                    }},
                {field: 'create_time', title: '添加时间',align: 'center',width:180,sort:true},
                {templet: '#operationTpl', width: 160, align: 'center', title: '操作'}
            ]],
            //  展开的列配置
            openCols: [
            {field: 'token', title: 'TOKEN'}
            , {field: 'email', title: '邮箱'}
            , {field: 'birthday', title: '生日'}
            , {field: 'login_ip', title: '近登录IP'}
            , {field: 'phone', title: '手机号'}

          ], openType: 0,
            done: function (res) {
                layer.closeAll('loading');
            }
        });


        /**
         * 监听单行工具操作
         */
        table.on('tool(table_id)', function (obj) {
            var data = obj.data;
            // console.log(JSON.stringify(data));
            var _id=parseInt(data.id);
            var layEvent = obj.event;
            if(layEvent==="edit"){
                var urls="<?php echo url('addAdmin'); ?>?id="+_id;
                lucky.CreateOpenForm("编辑管理员",urls);

            }else if(layEvent==="del"){
                lucky.FormatData(_id,"<?php echo url('del'); ?>");
            }
        });



        table.on('toolbar(table_id)', function(obj){
            var checkStatus = table.checkStatus(obj.config.id);
            var data = checkStatus.data;
            if(obj.event==="add"){
                lucky.CreateOpenForm("添加管理员","<?php echo url('addAdmin'); ?>");
                return false;
            }else if(obj.event==="close"){
                opTables.closeAll();
            }else if(obj.event==="open"){
                opTables.openAll();
            }else if(obj.event==="reload"){
                lucky.CreateReload();
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
                lucky.FormatData(id,"<?php echo url('del'); ?>");
                return  false;
            }
        });

        /**
         * 关键词搜索树
         */
        form.on('submit(search)', function (obj) {
            lucky.CreateSearch(obj.field);
            return false;
        });
    });

</script >



<script>
    okLoading.close();
</script>
</body>
</html>