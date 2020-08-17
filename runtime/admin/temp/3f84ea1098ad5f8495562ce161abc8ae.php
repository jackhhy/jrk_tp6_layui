<?php /*a:3:{s:76:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\data_backup\importlist.html";i:1597383421;s:65:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\public\base.html";i:1597383421;s:65:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\public\head.html";i:1597626924;}*/ ?>

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

                <a  class="layui-btn" href="javascript:;" autocomplete="off"> 数据库还原  </a>
                <table class="layui-table">
                    <thead>
                    <tr>
                        <th>数据库名称</th>
                        <th>卷数</th>
                        <th>压缩</th>
                        <th>数据大小</th>
                        <th>备份时间</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): if( count($list)==0 ) : echo "" ;else: foreach($list as $key=>$data): ?>
                    <tr>
                        <td><?php echo htmlentities(ftime($data['time'])); ?></td>
                        <td><?php echo htmlentities($data['part']); ?></td>
                        <td><?php echo htmlentities($data['compress']); ?></td>
                        <td><?php echo htmlentities(format_bytes($data['size'])); ?></td>
                        <td><?php echo htmlentities($key); ?></td>
                        <td class="status">-</td>
                        <td class="action">
                            <a class="db-down layui-btn layui-btn-xs layui-btn-normal" href="<?php echo url('DataBackup/down',['time'=>$data['time']]); ?>">下载</a>&nbsp;
                         <!--   <a class="db-import" href="<?php echo url('DataBackup/import',['time'=>$data['time']]); ?>">还原</a>&nbsp;-->
                            <a class="ajax-get confirm layui-btn layui-btn-xs " href="<?php echo url('DataBackup/del',['time'=>$data['time']]); ?>">删除</a>
                        </td>
                    </tr>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>

                </table>

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
    layui.use(['jquery','layer'],function(){
        window.$ = layui.$;
        var layer = layui.layer;

        $(".db-import").click(function(){
            var self = this, status = ".";
            $(this).parent().prevAll('.status').html("").html('等待还原');

            $.get(self.href, success, "json");
            window.onbeforeunload = function(){ return "正在还原数据库，请不要关闭！" }
            return false;

            function success(data){
                if(data.code==1){
                    $(self).parent().prev().text(data.msg);
                    if(data.data.part){
                        $.get(self.href,
                            {"part" : data.data.part, "start" : data.data.start},
                            success,
                            "json"
                        );
                    }  else {
                        layer.alert(data.msg);
                        //window.onbeforeunload = function(){ return null; }
                    }
                } else {
                    layer.alert(data.msg);
                }
            }
        });
    });

</script >




<script>
    okLoading.close();
</script>
</body>
</html>