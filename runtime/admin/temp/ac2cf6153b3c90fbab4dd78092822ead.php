<?php /*a:3:{s:70:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\friendlink\index.html";i:1597626601;s:65:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\public\base.html";i:1597383421;s:65:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\public\head.html";i:1597626924;}*/ ?>

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
            <fieldset class="layui-elem-field">
                <legend>搜索区</legend>
                <div class="layui-field-box">

                    <form action="" class="layui-form" method="get">
                        <div class="layui-form-item layui-form-pane">
                            <div class="layui-inline">
                                <label class="layui-form-label">名称：</label>
                                <div class="layui-input-inline">
                                    <input name="name" class="layui-input" value="" type="text" placeholder="请输入名称">
                                </div>
                            </div>

                            <div class="layui-inline">
                                <label class="layui-form-label">所属平台：</label>
                                <div class="layui-input-inline">
                                    <select class="layui-select" name="site_link">
                                        <option value="">所有</option>
                                        <?php if(is_array($site_link) || $site_link instanceof \think\Collection || $site_link instanceof \think\Paginator): $i = 0; $__LIST__ = $site_link;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                                        <option value="<?php echo htmlentities($key); ?>"><?php echo htmlentities($v); ?></option>
                                        <?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="layui-inline">
                                <label class="layui-form-label">状态：</label>
                                <div class="layui-input-inline">
                                    <select class="layui-select" name="status">
                                        <option value="">所有</option>
                                        <option value="1">停用</option>
                                        <option value="2">正常</option>
                                    </select>
                                </div>
                            </div>

                            <div class="layui-inline">
                                <label class="layui-form-label">选择时间：</label>
                                <div class="layui-input-inline">
                                    <input name="time" class="layui-input" id="time" value="" type="text" placeholder="请选择时间范围">
                                </div>
                            </div>

                            <div class="layui-inline">
                                <button class="layui-btn icon-btn layui-btn-sm" data-id="table_id" lay-filter="search" lay-submit="">
                                    <i class="layui-icon"></i>搜索
                                </button>
                                <button type="reset" class="layui-btn icon-btn layui-btn-normal layui-btn-sm"><i class="layui-icon layui-icon-refresh"></i>重置

                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </fieldset>
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

<!--模板-->
<script type="text/html" id="operationTpl">
    <a href="javascript:;" class="layui-btn layui-btn-normal layui-btn-xs <?php echo node('Friendlink/edit'); ?>" data-title="编辑" lay-event="edit"><i class="layui-icon"></i></a>
    <a href="javascript:;" class="layui-btn layui-btn-danger layui-btn-xs <?php echo node('Friendlink/del'); ?>" data-title="删除" lay-event="del"><i class="layui-icon "></i></a>
</script>

<script type="text/html" id="toolbarDemo">
    <button class="layui-btn layui-btn-sm <?php echo node('Friendlink/add'); ?>" lay-event="add"><i class="layui-icon"></i>新增
    </button>
    <button class="layui-btn layui-btn-sm layui-btn-primary" lay-event="reload"><i class="fa fa-refresh"></i> 刷新
    </button>
    <button class="layui-btn layui-btn-sm <?php echo node('Friendlink/del'); ?> layui-btn-danger" lay-event="del"><i class="layui-icon layui-icon-delete"></i>批量删除
    </button>
</script>
<!-- 链接 -->

<script type="text/html" id="status">
    {{# if(d.status==1){ }}
    <span class="layui-badge layui-bg-green">正常</span>
    {{# }else{ }}
    <span class="layui-badge layui-bg-orange">禁止</span>
    {{# } }}
</script>

<script type="text/html" id="url">
    <a href="{{d.url}}" target="_blank">{{d.url}}</a>
</script>

<script>
    layui.use(['element', 'table', 'form', 'jquery', 'lucky', 'laydate', 'okTab', 'upload'], function () {
        var element = layui.element;
        var form = layui.form;
        var table = layui.table;
        var $ = layui.jquery;
        var lucky = layui.lucky;
        var upload = layui.upload;
        var laydate = layui.laydate;
        var okTab = layui.okTab();
        form.render();

        //日期范围
        laydate.render({
            elem: '#time'
            , range: '~'
        });

        table.render({
            elem: '#table_id',
            url: "<?php echo url('index'); ?>",
            toolbar: '#toolbarDemo', //开启头部工具栏，并为其绑定左侧模板
            defaultToolbar: ['filter', 'exports', 'print'],
            even: true, //开启隔行背景
            page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
                layout: ['limit', 'count', 'prev', 'page', 'next', 'skip', 'last'] //自定义分页布局
                , groups: 5 //只显示 1 个连续页码
                , first: false //不显示首页
                , last: false //不显示尾页
                , limit: 20
                , limits: [20, 30, 50]
            },
            id: 'table_id',
            height: 'full-100',
            text: {
                none: '暂无相关数据'
            },
            cols: [[
                {type: 'checkbox'},
                {field: 'id', title: 'ID', width: 60},
                {field: 'name', width: 120, title: '友链名'},
                {field: 'url', width: 250, title: '友链地址', templet: '#url'},
                {field: 'site_link', width: 100, title: '所属平台'},
                {field: 'status', width: 90, title: '状态', templet: '#status'},
                {field: 'create_time', title: '添加时间', align: 'center', width: 180, sort: true},
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
            lucky.CreateSearch(obj.field);
            return false;
        });

        /**
         * 监听单行工具操作
         */
        table.on('tool(table_id)', function (obj) {
            var data = obj.data;
            var _id = parseInt(data.id);
            var layEvent = obj.event;
            if (layEvent === "del") {
                lucky.FormatData(_id, "<?php echo url('del'); ?>", "确认删除吗？");
            } else if (layEvent === "edit") {
                var url = "<?php echo url('edit'); ?>?id=" + _id;
                lucky.CreateOpenForm("编辑", url);
            }
        });

        table.on('toolbar(table_id)', function (obj) {
            var checkStatus = table.checkStatus(obj.config.id);
            var data = checkStatus.data;

            if (obj.event === "add") {
                lucky.CreateOpenForm("添加", "<?php echo url('add'); ?>");
                return false;
            } else if (obj.event === "reload") {
                lucky.CreateReload();
            } else if (obj.event === "del") {
                var num = 0;
                var id = [];
                for (var i in data) {
                    num++;
                    id.push(data[i].id);
                }
                if (id.length < 1) {
                    layer.msg("请至少选择一个", {icon: 15, time: 1000, shade: 0.3});
                    return false;
                }
                lucky.FormatData(id, "<?php echo url('del'); ?>", "确认删除吗？");
            }
        });

    });

</script>


<script>
    okLoading.close();
</script>
</body>
</html>