<?php /*a:3:{s:69:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\admin\base_data.html";i:1597383421;s:65:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\public\base.html";i:1597383421;s:65:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\public\head.html";i:1597626924;}*/ ?>

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

            <div class="layui-card-header">设置我的资料</div>
            <div class="layui-card-body" >

                <div class="layui-form" lay-filter="">

                   <input type="hidden" name="id"  value="<?php echo htmlentities($info['id']); ?>">

                    <div class="layui-form-item">
                        <label class="layui-form-label">头像：</label>
                        <div class="layui-input-inline">
                            <input name="avatar" lay-verify="" lay-verType="tips" lay-reqText="" id="path_" placeholder="" value="<?php echo htmlentities($info['avatar']); ?>"  readonly class="layui-input">
                        </div>
                        <div class="layui-input-inline layui-btn-container" style="width: auto;">
                            <button type="button" class="layui-btn layui-btn-primary" id="LAY_up">
                                <i class="layui-icon">&#xe67c;</i>修改头像
                            </button>
                            <a class="layui-btn layui-btn-warm" id="chan_pic">素材库选择</a >
                        </div>
                    </div>
                    <div class="layui-form-item ">
                        <label class="layui-form-label">图片显示：</label>
                        <div class="layui-input-inline">
                            <div class="layui-upload">
                                <div class="layui-upload-list">
                                    <img class="layui-upload-img" style="cursor: pointer;" title="点击查看大图" src="<?php if($info['avatar'] != null): ?><?php echo htmlentities($info['avatar']); else: ?>/static/images/default_upload.png<?php endif; ?>" id="s_show" width="150" height="110">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label label-required-next">用户名：</label>
                        <div class="layui-input-inline input-custom-width" style="">
                            <input type="text" name="username" value="<?php echo htmlentities($info['username']); ?>" placeholder="请输入管理员用户名" lay-verify="required" lay-vertype="tips" lay-reqtext="请输入管理员用户名" autocomplete="off" class="layui-input ">
                        </div>
                        <label class="layui-form-label ">昵称：</label>
                        <div class="layui-input-inline input-custom-width" style="">
                            <input type="text" name="nickname" value="<?php echo htmlentities($info['nickname']); ?>" placeholder="管理员昵称" lay-verify="" lay-vertype="tips" lay-reqtext="请输入管理员昵称" autocomplete="off" class="layui-input ">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">手机号：</label>
                        <div class="layui-input-inline input-custom-width" style="">
                            <input type="text" name="phone" value="<?php echo htmlentities($info['phone']); ?>" placeholder="请输入手机号" lay-verify="" lay-vertype="tips" lay-reqtext="请输入手机号" autocomplete="off" class="layui-input ">
                        </div>
                        <label class="layui-form-label ">邮箱：</label>
                        <div class="layui-input-inline input-custom-width" style="">
                            <input type="text" name="email" value="<?php echo htmlentities($info['email']); ?>" placeholder="管理员邮箱" lay-verify="" lay-vertype="tips" lay-reqtext="请输入管理员邮箱" autocomplete="off" class="layui-input ">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">生日：</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input" value="<?php echo htmlentities($info['birthday']); ?>" name="birthday" id="test1" placeholder="yyyy-MM-dd">
                        </div>
                    </div>


                    <div class="layui-form-item">
                        <label class="layui-form-label">性别：</label>
                        <div class="layui-input-block">
                            <input type="radio" name="sex" value="0" <?php if($info['sex'] == '0'): ?>  checked <?php endif; ?> title="男">
                            <input type="radio" name="sex" value="1" <?php if($info['sex'] == '1'): ?>  checked <?php endif; ?> title="女" >
                            <input type="radio" name="sex" value="2" <?php if($info['sex'] == '2'): ?>  checked <?php endif; ?> title="保密" >
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">状态：</label>
                        <div class="layui-input-inline input-custom-width">
                            <input type="radio" name="status" value="1" title="正常"  lay-filter=""  <?php if($info['status'] == '1'): ?>  checked <?php endif; ?>>
                            <input type="radio" name="status" value="2" title="拉黑" lay-filter="" <?php if($info['status'] == '2'): ?>  checked <?php endif; ?>>
                        </div>
                    </div>

                    <input type="hidden" name="__token__" id="token" value="<?php echo token(); ?>"/>

                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit lay-filter="setmyinfo">确认修改</button>
                        </div>
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

<script>

    layui.use(['element','form', 'jquery','lucky','laydate','upload'], function () {
        var element = layui.element;
        var form = layui.form;
        var $ = layui.jquery;
        var lucky=layui.lucky;
        var upload = layui.upload;
        var laydate = layui.laydate;

        form.render();

        //常规用法
        laydate.render({
            elem: '#test1'
        });


        //图片上传
        upload.render({
            elem:'#LAY_up'
            ,url: "<?php echo url('Common/UpImg'); ?>" //图片上传地址
            ,accept: 'images' //
            ,acceptMime: 'image/*'
            ,size: 1024*12
            ,before:function (res) {
                loading = layer.load(2, {
                    shade: [0.2, '#000'] //0.2透明度的白色背景
                });
            }
            ,done: function(data){
                layer.close(loading);
                if (data.code==1){
                    layer.msg(data.msg, {icon: 1, time: 1000},function () {
                        $("#s_show").attr("src",data.data.dir);
                        $("#path_").val(data.data.dir);
                    });
                } else {
                    layer.msg(data.msg, {icon: 5, time: 1000});
                }
            }
            ,error:function (red) {
                layer.close(loading);
                layer.msg("网络错误", {icon: 5, time: 1500});
            }
        });



        // 弹窗选择
        $('#chan_pic').click(function () {
            layer.open({
                title:"选择素材图片",
                type: 2,
                area: ["80%", "90%"],
                offset:'auto',
                maxmin : true,
                skin:'layui-layer-molv',
                shade: 0.5,
                content: "<?php echo url('AttachMents/getImages'); ?>",
                success:function(){
                    setTimeout(function(){
                        layui.layer.tips('点击此处返回列表', '.layui-layer-setwin .layui-layer-close', {
                            tips: 3,time:1000
                        });
                    },500)
                },
                end:function () {
                    if (typeof(mFsUrls) != "undefined" && mFsUrls.length > 0) {
                        $("#path_").val(mFsUrls);
                        $("#s_show").attr("src",mFsUrls);
                    }
                }
            });
            return false;
        });


        /**
         * 点击查看大图
         */
        $("#s_show").click(function () {
            layer.photos({
                photos: {
                    title: "查看图片",
                    data: [{
                        src: $(this).attr("src")
                    }]
                },
                shade: .01,
                closeBtn: 1,
                anim: 5
            });
        });

        /**
         * 鼠标显示
         */
        $('#path_').hover(function(){
            var img = "<img class='img_msg' src='"+$(this).val()+"' style='width:100%;max-height: 600px;' />";
            img_show = layer.tips(img, this,{
                tips:[2, 'rgba(41,41,41,.0)']
                ,area: ['12%']
            });
        },function(){
            layer.close(img_show);
        });

        /**
         * 表格提交
         */
        form.on('submit(setmyinfo)', function (data) {
            lucky.FormSubmit("<?php echo url('Admin/baseData'); ?>",data.field);
            return false;
        });

    });

</script >




<script>
    okLoading.close();
</script>
</body>
</html>