<?php /*a:3:{s:69:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\auth_rule\index.html";i:1597626042;s:65:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\public\base.html";i:1597383421;s:65:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\public\head.html";i:1597626924;}*/ ?>

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

        
<style>
    .layui-tableTree-edit{
        cursor: pointer;
    }
</style>
<div class="layui-col-md12">
    <div class="layui-card">
        <div class="layui-card-body layui-row ">
            <fieldset class="layui-elem-field">
                <legend>搜索区</legend>
                <div class="layui-field-box">
            <form action="" class="layui-form" method="get">
                <div class="layui-form-item layui-form-pane">

                    <div class="layui-inline">
                        <label class="layui-form-label">菜单搜索：</label>
                        <div class="layui-input-inline">
                            <input name="title" class="layui-input" id="title" value="" type="text" placeholder="请输入名称">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <button class="layui-btn icon-btn layui-btn-sm" data-id="table_id" lay-filter="search" lay-submit="">
                            <i class="layui-icon"></i>搜索
                        </button>
                        <button type="reset" class="layui-btn icon-btn layui-btn-normal layui-btn-sm"><i class="layui-icon layui-icon-refresh"></i>重置</button>
                    </div>
                </div>
            </form>
                </div>
            </fieldset>

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
        <button type="button" lay-event="tableTreeEdit" id="btn1" class="layui-btn <?php echo node('AuthRule/addAuth'); ?> layui-btn-sm">新增顶级菜单</button>
        <button type="button" lay-event="tableTreeEdit" id="btn2" class="layui-btn <?php echo node('AuthRule/del'); ?> layui-btn-sm layui-btn-danger">删除菜单</button>
        <button type="button" lay-event="tableTreeEdit" id="btn6" class="layui-btn  layui-btn-sm">关闭所有</button>
        <button type="button" lay-event="tableTreeEdit" id="btn7" class="layui-btn  layui-btn-sm">展开所有</button>
        <button type="button" lay-event="tableTreeEdit" id="btn9" class="layui-btn  layui-btn-sm  layui-btn-primary">刷新表格</button>
        <button type="button" lay-event="tableTreeEdit" id="btn11" class="layui-btn  layui-btn-sm layui-btn-normal">重置搜索</button>
    </div>
</script>


<script type="text/html" id="type">
    {{# if(d.type==1){ }}
    <span class="layui-badge layui-bg-green">菜单</span>
    {{# }else{ }}
    <span class="layui-badge layui-bg-orange">按钮</span>
    {{# } }}
</script>

<script type="text/html" id="auth_open">
    {{# if(d.auth_open==1){ }}
    <span class="layui-badge layui-bg-blue">验证</span>
    {{# }else{ }}
    <span class="layui-badge layui-bg-gray">不验证</span>
    {{# } }}
</script>

<script>
    layui.use(['element', 'table', 'form', 'jquery', 'lucky','tableTree'], function () {
        var element = layui.element;
        var form = layui.form;
        var table = layui.table;
        var $ = layui.jquery;
        var lucky=layui.lucky;
        var tableTree = layui.tableTree;
        form.render();
        String.prototype.format = function () {
            //字符串占位符
            //eg: var str1 = "hello {0}".format("world");
            if (arguments.length == 0) return this;
            var param = arguments[0];
            var s = this;
            if (typeof (param) == 'object') {
                for (var key in param) {
                    s = s.replace(new RegExp("\\{" + key + "\\}", "g"), param[key]);
                }
                return s;
            } else {
                for (var i = 0; i < arguments.length; i++) {
                    s = s.replace(new RegExp("\\{" + i + "\\}", "g"), arguments[i]);
                }
                return s;
            }
        };

      var treeTable = tableTree.render({
            elem: '#table_id',
            url:"<?php echo url('index'); ?>",
            toolbar: '#toolbarDemo', //开启头部工具栏，并为其绑定左侧模板
            even: true, //开启隔行背景
            id:'table_id',
            height: 'full-100',
            defaultToolbar: ['filter', 'exports', 'print'],
           // page: true,
            treeConfig:{ //表格树所需配置
            showField:'title' //表格树显示的字段
                ,treeid:'id' //treeid所对应字段的值在表格数据中必须是唯一的，且不能为空。
                ,treepid:'pid'//父级id字段名称
                ,iconClass:'layui-icon-right' //小图标class样式 窗口图标 layui-icon-layer
                ,showToolbar: true //展示工具栏 false不展示 true展示
             },
            cols: [[
                {type:'checkbox'},
                {field: 'title', width: 360, title: '菜单名称'},
                {field: 'id',  title: 'ID',sort:true,width:80},
                {
                    field: 'icon', width: 70, align: 'center', templet: function (d) {
                        if (d.icon == "") {
                            return '';
                        } else {
                            var a= ('<i class="{0} {1} " ></i>').format(d.font_family,d.icon);
                            return a;
                        }
                    }, title: '图标'
                },
                {field:'type',title:'类型',align: 'center',templet: '#type',width:100 ,unresize: true},
                {field:'auth_open',title:'权限',align: 'center',templet: '#auth_open',width:100 ,unresize: true},
                {field: 'name',style:'cursor: pointer;',align: 'center',title: '菜单url',event:'url',config:{type:'input'},width:200},
                {field: 'sort',style:'cursor: pointer;',align: 'center',title: '排序',width:100,event:'sorts', config:{type:'input'},sort:true},
                {field: 'status', title: '状态',width: 100,align: 'center',templet:function (rd) {
                        var s="";
                        if (rd.status==1){
                            s='<span class="layui-badge layui-bg-green">正常</span>';
                        } else {
                            s='<span class="layui-badge layui-bg-black">禁止</span>';
                        }
                        return s;
                    }},
                {field: 'create_time', title: '添加时间',align: 'center',width:180,sort:true},
                {field: 'param',  title: '额外参数',width:100},
            ]],
            done: function (res) {
                //treeTable.closeAllTreeNodes();
                treeTable.openAllTreeNodes()
            }
        });

        /**
         *表格的增删改都会回调此方法
         * 与table.on(tool(lay-filter))用法一致。
         **/
        tableTree.on('tool(table_id)',function (obj) {
            var field = obj.field; //单元格字段
            var value = obj.value; //修改后的值
            var data = obj.data; //当前行数据
            var event = obj.event; //当前单元格事件属性值
            //event为del为删除 add则新增 edit则修改 async则为异步请求数据。
            if(event !== 'del' && event !== 'add' && event !== 'url' && event !== 'async' && event !== 'sort' && event !== 'sorts'){
                var urls="<?php echo url('addAuth'); ?>?id="+obj.data.id;
                lucky.CreateOpenForm("编辑菜单",urls);
                //console.log(obj)
            }
            if(event === 'url'){
                var updates = {};
                updates[field] = value;
                lucky.Change_status("<?php echo url('common/changeStatus'); ?>","auth_rule",obj.data.id,obj.field,obj.value);
                obj.update(updates);
               // console.log(obj)
            }
            if (event==="sorts"){
                var updated = {};
                updated[field] = value;
                lucky.Change_status("<?php echo url('common/changeStatus'); ?>","auth_rule",obj.data.id,obj.field,obj.value);
                obj.update(updated);
            }

            if (event==="sort"){
                if (obj.data.type==1 && obj.data._no==1){
                    var urls="<?php echo url('addNode'); ?>?id="+obj.data.id;
                    lucky.CreateOpenForm("添加节点",urls);
                }else if (obj.data.type==2){
                    layer.msg("操作节点不可添加子节点",{icon:15,time:1000,shade:0.3});
                    return false;
                }else {
                    layer.msg("当前菜单下有子菜单不可添加操作节点",{icon:15,time:1000,shade:0.3});
                    return false;
                }
               // console.log(obj);
            }
            if(event === 'del'){
                //console.log(obj);
                obj.del();
                lucky.FormatData(obj.data.id,"<?php echo url('del'); ?>","确认删除吗？");
               // console.log(obj);
            }
            //添加子菜单
            if(event === 'add'){ //点击操作栏加号图标时触发
                //异步、同步都可以使用
                //console.log(obj);
                if (obj.data.type===2){
                    layer.msg("按钮不可以添加子菜单",{icon:15,time:1000,shade:0.3});
                    return false;
                }else {
                    var url="<?php echo url('addSon'); ?>?id="+obj.data.id;
                    lucky.CreateOpenForm("添加子菜单",url);
                }
            }
            if(event === 'async'){ //点击方向箭头小图标时触发
               // obj.async([]);
            }
        });

        /**
         *监听复选框选中状态
         **/
        tableTree.on('checkbox(table_id)', function(obj){
         /*   console.log(obj.checked); //当前是否选中状态
            console.log(obj.data); //选中行的相关数据
            console.log(obj.type); //如果触发的是全选，则为：all，如果触发的是单选，则为：one
            console.log(obj.data);*/
        });

        var isAsc = true;
        table.on('toolbar(table_id)', function(obj){
            var id = $(this).attr("id");
            if(id==="btn1"){
                lucky.CreateOpenForm("添加菜单","<?php echo url('addAuth'); ?>");
                return false;
            }else if(id === 'btn2') {
                var data=treeTable.getCheckedTreeNodeData();
                if (data.length < 1){
                    layer.msg("至少选择一个菜单",{icon:15,time:1000,shade:0.3});
                    return false;
                }else {
                    var _id=[];
                    for (var i=0;i<data.length;i++){
                        _id.push(data[i].id)
                    }
                    lucky.FormatData(_id,"<?php echo url('del_all'); ?>","确认删除选中的菜单吗？");
                    return false;
                }

               // console.log(_id)
            }else if(id === 'btn6') {
                treeTable.closeAllTreeNodes();  //关闭所有树节点
            }else if(id === 'btn7') {
                treeTable.openAllTreeNodes(); //展开所有树节点
            }else if(id === 'btn9'){
                treeTable.reload(); //表格树进行reload
            }else if(id === 'btn11') {
                treeTable.clearSearch(); //重置搜索
                $("#title").val("");
                layer.msg("重置搜索成功",{icon:1,time:1000,shade:0.3});
            }
        });


        /**
         * 整个表格树排序，与layui进行了整合。
         */
        table.on('sort(table_id)', function(obj){
            treeTable.sort({field:obj.field,desc:obj.type === 'desc'})
        });

        /**
         * 关键词搜索树
         */
        form.on('submit(search)', function (obj) {
            treeTable.keywordSearch(obj.field.title);
            return false;
        });


    });

</script >



<script>
    okLoading.close();
</script>
</body>
</html>