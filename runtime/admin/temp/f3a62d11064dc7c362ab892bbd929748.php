<?php /*a:2:{s:65:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\article\add.html";i:1597643339;s:67:"D:\phpstudy_pro\WWW\jrk_tp6_layui\app\admin\view\public\window.html";i:1597630457;}*/ ?>

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



<div class="layui-fluid">
    <div class="layui-card">

        <div class="layui-card-body" style="padding: 15px;">
            <form class="layui-form" action="" lay-filter="form">
            <div class="layui-tab layui-tab-brief">
                <ul class="layui-tab-title">
                    <li class="layui-this">基本内容</li>
                    <li>文章内容</li>
                </ul>
                <div class="layui-tab-content" style="margin-top: 20px;">

                    <div class="layui-tab-item layui-show">

                        <div class="layui-form-item">
                            <label class="layui-form-label">文章栏目：</label>
                            <div class="layui-input-block">
                                <select name="cate_id" lay-verify="required" >
                                    <option value="0">请选择</option>
                                    <?php echo htmlentities(make_option($cate,'','title_show','id')); ?>
                                </select>
                            </div>
                            <div class="layui-form-mid layui-word-aux"></div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">文章标题：</label>
                            <div class="layui-input-block input-custom-width" style="">
                                <input type="text" name="title" value="" placeholder="请输入文章标题" lay-verify="required" lay-vertype="tips" lay-reqtext="请输入文章标题" autocomplete="off" class="layui-input ">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">标题颜色：</label>
                            <div class="layui-input-inline" style="width: 120px;">
                                <input type="text" value="#00060a" name="title_color" placeholder="请选择颜色" class="layui-input" id="test-form-input">
                            </div>
                            <div class="layui-inline" style="left: -11px;">
                                <div id="test-form"></div>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">评分等级：</label>
                            <div class="layui-input-inline input-custom-width" style="">
                                <div id="test7"></div>
                            </div>
                            <div class="layui-input-inline input-custom-width" style="">
                                <input type="number"  id="tt" name="range" value="1" placeholder="" autocomplete="off" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">封面图：</label>
                            <div class="layui-input-inline">
                                <input name="img_url" lay-verify="required" lay-verType="tips" lay-reqText="" id="path_" placeholder="" value="" readonly class="layui-input">
                            </div>
                            <div class="layui-input-inline layui-btn-container" style="width: auto;">
                                <button type="button" class="layui-btn layui-btn-primary" id="LAY_up">
                                    <i class="layui-icon">&#xe67c;</i>修改封面图
                                </button>
                                <a class="layui-btn layui-btn-warm" id="chan_pic">素材库选择</a >
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">关键词：</label>
                            <div class="layui-input-block input-custom-width" style="">
                                <input type="text" name="keywords" value="" placeholder="请输入关键词" lay-verify="required" lay-vertype="tips" lay-reqtext="请输入关键词" autocomplete="off" class="layui-input ">
                                <p class="help-block">关键词以英文逗号隔开！！！</p>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">文章摘要：</label>
                            <div class="layui-input-block input-custom-width" style="">
                                <textarea name="description" placeholder="" lay-verify=""  autocomplete="off" class="layui-textarea"></textarea>
                                <p class="help-block">留空时默认截取内容的前100个字符！</p>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">是否显示：</label>
                            <div class="layui-input-inline input-custom-width">
                                <input type="radio" name="is_show" value="1" title="显示" lay-filter=""  checked>
                                <input type="radio" name="is_show" value="0" title="不显示" lay-filter="" >
                            </div>

                            <label class="layui-form-label">是否置顶：</label>
                            <div class="layui-input-inline input-custom-width">
                                <input type="radio" name="is_top" value="1" title="是" lay-filter=""  >
                                <input type="radio" name="is_top" value="0" title="否" lay-filter="" checked>
                            </div>

                            <div class="layui-form-mid layui-word-aux"></div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">作者：</label>
                            <div class="layui-input-inline input-custom-width">
                                <input type="text" name="author" value="<?php echo htmlentities($_info['username']); ?>" placeholder="请输入作者" lay-verify="required" lay-vertype="tips" lay-reqtext="请输入作者" autocomplete="off" class="layui-input ">
                            </div>

                            <label class="layui-form-label">点击量：</label>
                            <div class="layui-input-inline input-custom-width">
                                <input type="number" min="0" name="hits" value="0" placeholder="" lay-verify="required" lay-vertype="tips" lay-reqtext="" autocomplete="off" class="layui-input ">
                            </div>
                            <div class="layui-form-mid layui-word-aux"></div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">文章来源：</label>
                            <div class="layui-input-inline input-custom-width">
                                <input type="text" name="origin" value="原创" placeholder="请输入文章来源" lay-verify="required" lay-vertype="tips" lay-reqtext="请输入文章来源" autocomplete="off" class="layui-input ">
                            </div>

                            <label class="layui-form-label">链接地址：</label>
                            <div class="layui-input-inline input-custom-width">
                                <input type="text" name="url" value="" placeholder="" lay-verify="" lay-vertype="tips" lay-reqtext="" autocomplete="off" class="layui-input ">
                                <p class="help-block">有来源的时候填写来源的地址！</p>
                          </div>

                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">是否推荐：</label>
                            <div class="layui-input-inline input-custom-width">
                                <input type="radio" name="is_recommend" value="1" title="是" lay-filter=""  >
                                <input type="radio" name="is_recommend" value="2" title="否" lay-filter="" checked>
                            </div>
                        </div>

                        <?php if(isset($info['id'])): ?>
                        <input type="hidden" name="id" value="<?php echo htmlentities($info['id']); ?>">
                        <?php endif; ?>
                    </div>

                    <div class="layui-tab-item">

                     <textarea name="content" placeholder="" style="max-width: 90%" id="content"  lay-verify="required" lay-verType="tips" lay-reqText="内容不能为空"></textarea>
                        <?php if(isset($info['id'])): ?>
                        <?php echo build_ueditor(['name'=>'content','h'=>330,'content'=>$info['content']]); else: ?>
                         <?php echo build_ueditor(['name'=>'content','h'=>330]); ?>
                        <?php endif; ?>

                    </div>
                </div>

            </div>
                <div class="layui-form-item layui-layout-admin " style="width: 100%">
                    <div class="layui-input-block">
                        <div class="layui-footer" style="left: 0px;text-align: center;">
                            <button class="layui-btn" lay-submit="" lay-filter="add">提交</button>
                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>




<script>
    layui.use(['element', 'form', 'jquery','lucky','upload','laydate','rate','colorpicker'], function () {
        var element = layui.element;
        var table = layui.table;
        var form = layui.form;
        var $ = layui.jquery;
        var lucky=layui.lucky;
        var upload = layui.upload;
        var laydate = layui.laydate;
        var rate=layui.rate;
        var colorpicker=layui.colorpicker;


        //表单赋值
        var info = <?php echo json_encode($info); ?>;
        form.val("form",info);

        //表单赋值
        colorpicker.render({
            elem: '#test-form'
            ,color: '#1c97f5'
            ,done: function(color){
                $('#test-form-input').val(color);
            }
        });

        rate.render({
            elem: '#test7'
            ,length: 5
            ,setText: function(value){
                $("#tt").val(value);
            },
            value:info.range
        });

        //图片上传
        upload.render({
            elem:'#LAY_up'
            ,url: "<?php echo url('Common/UpArticlePic'); ?>" //图片上传地址
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
                    }
                }
            });
            return false;
        });


        form.on('submit(add)', function (data) {
            lucky.FormSubmit("<?php echo url('upAndAdd'); ?>",data.field,true);
            return false;
        });
    })
</script>



</body>
</html>