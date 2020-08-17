<?php /*a:2:{s:77:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\attach_ments\get_images.html";i:1597633340;s:67:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\public\window.html";i:1597630457;}*/ ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo htmlentities($_name); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
    <link href="/plugs/font-awesome/css/font-awesome.css?v=4.7.0" rel="stylesheet">
    <link rel="stylesheet" href="/static/css/animate.min.css" media="all"/>
    <link rel="stylesheet" href="/plugs/layui/css/layui.css?v=2.5.6">
    <script src="/static/js/jquery.min.js?v=1"></script>
    <script src="/plugs/layui/layui.js?v=2.5.6"></script>
    <script src="/static/js/backend/jrk_common.js?v=<?php echo time(); ?>"></script>
    <script src="/static/js/backend/comm.js?v=<?php echo time(); ?>"></script>

    <style >
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

        .layui-form[wid100] .layui-form-label {
            width: 100px !important;
        }

     /*   .layui-form-label{
            width: 110px !important;
        }
        .layui-input-block {
            margin-left: 140px !important;
        }*/

    </style >

</head>

<body class="ok-body-scroll">

<script type="text/javascript" src="/static/js/clipboard.min.js?v=1"></script>



<link rel="stylesheet" href="/static/css/fileCommon.css">
<style >
    @media screen and (max-width: 420px) {
        .btnDiv {
            padding-top: 30px;
            text-align: left;
        }
    }
    .showBB .bottomBar {
        display: block;
    }

</style >

<!-- 正文开始 -->
<div class="layui-fluid">
    <div class="layui-row layui-col-space10">
        <div class="layui-col-md12">

            <div class="layui-card" style="margin-top: 15px;">
                <div class="layui-card-header">
                    <div class="layadmin-homepage-pad-ver" style="text-align: left">
                        <div class="layui-btn-group">
                            <button type="button" class="layui-btn layui-btn-normal layui-btn-sm" id="upload">上传图片</button>
                        </div>
                    </div>
                </div>
                <div class="layui-card-body">

                    <div class="layui-form">

                        <div class="file-list">
                            <?php if(is_array($data['data']) || $data['data'] instanceof \think\Collection || $data['data'] instanceof \think\Paginator): $i = 0; $__LIST__ = $data['data'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <div class="file-list-item"  data-url="<?php echo htmlentities($vo['att_dir']); ?>" data-name="<?php echo htmlentities($vo['name']); ?>" data-ext="<?php echo htmlentities($vo['ext']); ?>"   data-title="<?php echo htmlentities($vo['name']); ?>">
                                <div class="file-list-img media " data-id="<?php echo htmlentities($vo['id']); ?>" >
                                    <img class="lazy" alt="ss" data-original="<?php echo htmlentities($vo['att_dir']); ?>"  />
                                </div>
                                <div class="file-list-name"><?php echo htmlentities($vo['name']); ?></div>
                                <div class="file-list-ck layui-form">
                                    <input type="radio" name="imgCk" value="<?php echo htmlentities($vo['att_dir']); ?>" lay-skin="primary" />
                                </div>
                            </div>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>

                        <!--分页开始-->
                        <div class="layui-row" style="text-align: center;">
                            <?php echo $page; ?>
                        </div>
                        <!--分页结束-->

                        <div class="layui-form-item" >
                            <div class="layui-input-block">
                                <div class="layui-footer" style="left: 0px;text-align: right;">
                                    <button class="layui-btn" lay-submit="" lay-filter="add">确认选择</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
<!-- 下拉菜单 -->
<div class="dropdown-menu dropdown-anchor-top-left" id="dropdownFile">
    <div class="dropdown-anchor"></div>
    <ul>
        <li><a id="open"><i class="layui-icon layui-icon-file"></i> 查看 </a></li>
    </ul>
</div>

<script type="text/javascript" src=/static/js/jquery.lazyload.min.js?v=1.9.1"></script>

<script type="text/javascript" charset="utf-8">
    $(function() {
        $("img.lazy").lazyload({effect: "fadeIn",threshold: 100});
    });
</script>

<script>

    layui.use(['jquery', 'layer', 'element', 'upload',  'util' ,'form'], function () {
        var $ = layui.jquery;
        var layer = layui.layer;
        var element = layui.element;
        var upload = layui.upload;
        var util = layui.util;
        var form = layui.form;

        form.render();

        var mUrl; //素材地址
        var show; //素材类型
        var names; //原始名称
        var _id; //素材id
        // 列表点击事件
        $('body').on('click', '.file-list-item > .file-list-img', function (e) {
            var name = $(this).parent().data('name');
            mUrl = $(this).parent().data('url');
            show=$(this).parent().data('ext');
            names=name;
            _id=parseInt( $(this).data('id'));

            var $target = $(this);
            $('#dropdownFile').css({
                'top': $target.offset().top + 90,
                'left': $target.offset().left + 25
            });
            $('#dropdownFile').addClass('dropdown-opened');
            if (e !== void 0) {
                e.preventDefault();
                e.stopPropagation();
            }
        });


        // 点击空白隐藏下拉框
        $('html').off('click.dropdown').on('click.dropdown', function () {
            $('#dropdownFile').removeClass('dropdown-opened');
        });


        // 打开
        $('#open').click(function () {
            layer.photos({
                photos: {
                    title: "查看图片",
                    data: [{
                        src: mUrl
                    }]
                },
                shade: .01,
                closeBtn: 1,
                anim: 5
            });
        });

        upload.render({
            elem: '#upload'
            ,url: "<?php echo url( 'admin/common/UpImagesList'); ?> " //上传地址
            ,accept:'images'
            ,acceptMime:'image/*'
            ,size: 1024*12 //最大允许上传的文件大小
            ,before: function(obj){
                //预读本地文件
            }
            ,done: function(data){
                //上传完毕回调
                if (data.code==1){
                    layer.msg(data.msg, {icon: 1, time: 1000},function () {
                        //上传成功
                        location.reload();
                    });
                } else {
                    layer.msg(data.msg, {icon: 5, time: 1000});
                }
            }
            ,error: function(){
                //请求异常回调
                layer.msg("网络错误 ", {icon: 5, time: 1500});
            }
        });

        form.on('submit(add)', function (data) {
            var val=$('input:radio[name=imgCk]:checked').val();
           // console.log(val);
            if (val==undefined || val===""){
                layer.msg("请选择一张图片",{kin: 'layui-layer-lan', icon:5,time:1500,shade:0.7});
                return  false;
            }
            parent.mFsUrls = val;
            parent.layer.close(parent.layer.getFrameIndex(window.name));
        });

    });
</script>




</body>
</html>