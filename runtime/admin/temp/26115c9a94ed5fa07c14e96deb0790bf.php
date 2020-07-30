<?php /*a:1:{s:58:"D:\phpstudy_pro\WWW\jrk_tp6\app\admin\view\index\home.html";i:1596107433;}*/ ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>后台管理系统</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" href="/static/css/oksub.css?v=1">
    <link rel="stylesheet" href="/static/css/admin.css?v=1">
    <link href="/static/css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <link rel="stylesheet" href="/static/css/animate.min.css" media="all"/>
    <script src="/static/js/jquery.min.js"></script>
    <!--js逻辑-->
    <script src="/plugs/layui/layui.js?v=2.5.6"></script>
    <script type="text/javascript" src="/plugs/echarts/echarts.min.js"></script>
</head>

<body class="ok-body-scroll console">

<div class="ok-body home">

    <div class="layui-row layui-col-space15">
        <div class="layui-col-sm6 layui-col-md3">
            <div class="layui-card">
                <div class="layui-card-header">
                    文章总数量
                    <span class="layui-badge layui-bg-blue layuiadmin-badge">篇</span>
                </div>
                <div class="layui-card-body layuiadmin-card-list">
                    <p class="layuiadmin-big-font">9</p>
                </div>
            </div>
        </div>
        <div class="layui-col-sm6 layui-col-md3">
            <div class="layui-card">
                <div class="layui-card-header">
                    用户总数
                    <span class="layui-badge layui-bg-cyan layuiadmin-badge">个</span>
                </div>
                <div class="layui-card-body layuiadmin-card-list">
                    <p class="layuiadmin-big-font">7</p>
                </div>
            </div>
        </div>
        <div class="layui-col-sm6 layui-col-md3">
            <div class="layui-card">
                <div class="layui-card-header">
                    留言总数
                    <span class="layui-badge layui-bg-green layuiadmin-badge">条</span>
                </div>
                <div class="layui-card-body layuiadmin-card-list">

                    <p class="layuiadmin-big-font">1</p>

                </div>
            </div>
        </div>
        <div class="layui-col-sm6 layui-col-md3">
            <div class="layui-card">
                <div class="layui-card-header">
                    名言名句
                    <span class="layui-badge layui-bg-orange layuiadmin-badge">条</span>
                </div>
                <div class="layui-card-body layuiadmin-card-list">
                    <p class="layuiadmin-big-font">5</p>
                </div>
            </div>
        </div>

    </div>


    <div class="layui-row layui-col-space15">

        <!--作者语录-->
        <div class="layui-col-sm6 layui-col-md6">

            <div class="layui-card">
                <div class="layui-card-header">
                    作者心语
                    <i class="layui-icon layui-icon-tips" lay-tips="要支持的噢" lay-offset="5"></i>
                </div>
                <div class="layui-card-body layui-text layadmin-text">
                    <p>感谢一路走来有你的陪伴，在未来的道路上，我会更加努力，争取把最好的东西呈献给最可爱的你们。</p>
                    <p>请尊重Jrk_Admin开发者的劳动成果，请别将该源码上传到任何的素材网站进行售卖！一经发现将追究责任！</p>
                    <p>感谢 <a href="http://ok-admin.xlbweb.cn/" target="_blank" >ok-admin</a >优秀的后台模板。</p>
                    <p>—— Jrk_Admin_Tp6（<a href="http://www.luckyhhy.cn/" target="_blank">luckyhhy.cn</a>）</p>
                </div>
            </div>


        </div>

        <!--版本信息-->
        <div class="layui-col-sm6 layui-col-md6">
            <div class="layui-card">
                <div class="layui-card-header">版本信息</div>
                <div class="layui-card-body layui-text">
                    <table class="layui-table">
                        <colgroup>
                            <col width="100">
                            <col>
                        </colgroup>
                        <tbody>
                        <tr>
                            <td>当前版本</td>
                            <td>
                              <?php echo htmlentities($_name); ?>_<?php echo htmlentities($_version); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>基于框架</td>
                            <td>
                                <a href="https://www.layui.com/" target="_blank">layui-2.5.6</a> + <a href="http://www.thinkphp.cn/" target="_blank">Thinkphp<?php echo htmlentities($config['version']); ?></a>
                            </td>
                        </tr>
                        <tr>
                            <td>运行环境</td>
                            <td>
                                <p><?php echo htmlentities($config['server_os']); ?>-&nbsp;PHP<?php echo htmlentities($config['php_version']); ?>-&nbsp;<?php echo htmlentities($config['server_soft']); ?>-&nbsp;Mysql:<?php echo htmlentities($config['mysql_version']); ?> </p>
                            </td>
                        </tr>
                        <tr>
                            <td>Gitee地址</td>
                            <td><p><a href="https://gitee.com/luckygyl/jrk_tp6" target="_blank">
                                <img src="https://gitee.com/luckygyl/jrk_tp6/badge/star.svg?theme=dark" alt="star"></a>
                                <a href="https://gitee.com/luckygyl/jrk_tp6" target="_blank">
                                    <img src="https://gitee.com/luckygyl/jrk_tp6/badge/fork.svg?theme=dark" alt="fork">
                                </a></p></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>



    <div class="layui-row layui-col-space15">
        <div class="layui-col-sm6 layui-col-md6" >
            <div class="layui-card" >
                <div class="layui-card-header" >统计每月用户访问量</div >
                <div class="layui-card-body" >

                    <div class="flot-chart" style="height:350px;width: 100%;">
                        <div class="flot-chart-content" id="table11" style="height:350px; width: 100%">
                            <script type="text/javascript">
                                var dom = document.getElementById("table11");
                                var myChart = echarts.init(dom);
                                var app = {};
                                option = null;
                                var posList = [
                                    'left', 'right', 'top', 'bottom',
                                    'inside',
                                    'insideTop', 'insideLeft', 'insideRight', 'insideBottom',
                                    'insideTopLeft', 'insideTopRight', 'insideBottomLeft', 'insideBottomRight'
                                ];
                                app.configParameters = {
                                    rotate: {
                                        min: -90,
                                        max: 90
                                    },
                                    align: {
                                        options: {
                                            left: 'left',
                                            center: 'center',
                                            right: 'right'
                                        }
                                    },
                                    verticalAlign: {
                                        options: {
                                            top: 'top',
                                            middle: 'middle',
                                            bottom: 'bottom'
                                        }
                                    },
                                    position: {
                                        options: echarts.util.reduce(posList, function (map, pos) {
                                            map[pos] = pos;
                                            return map;
                                        }, {})
                                    },
                                    distance: {
                                        min: 0,
                                        max: 100
                                    }
                                };
                                app.config = {
                                    rotate: 90,
                                    align: 'left',
                                    verticalAlign: 'middle',
                                    position: 'insideBottom',
                                    distance: 15,
                                    onChange: function () {
                                        var labelOption = {
                                            normal: {
                                                rotate: app.config.rotate,
                                                align: app.config.align,
                                                verticalAlign: app.config.verticalAlign,
                                                position: app.config.position,
                                                distance: app.config.distance
                                            }
                                        };
                                        myChart.setOption({
                                            series: [{
                                                label: labelOption
                                            }, {
                                                label: labelOption
                                            }, {
                                                label: labelOption
                                            }, {
                                                label: labelOption
                                            }]
                                        });
                                    }
                                };
                                var labelOption = {
                                    normal: {
                                        show: true,
                                        position: app.config.position,
                                        distance: app.config.distance,
                                        align: app.config.align,
                                        verticalAlign: app.config.verticalAlign,
                                        rotate: app.config.rotate,
                                        formatter: '{c}',
                                        fontSize: 16,
                                        rich: {
                                            name: {
                                                textBorderColor: '#fff'
                                            }
                                        }
                                    }
                                };
                                option = {
                                    title : {
                                        //text: '年各部门后勤故障报修情况',
                                        subtext: '仅统计2020年的数据！'
                                    },
                                    color: ['#006699'],
                                    tooltip: {
                                        trigger: 'axis',
                                        axisPointer: {
                                            type: 'shadow'
                                        }
                                    },
                                    legend: {
                                        data: ['每月访问量']
                                    },
                                    toolbox: {
                                        show: true,
                                        orient: 'vertical',
                                        left: 'right',
                                        top: 'center',
                                        feature: {
                                            mark: {show: true},
                                            dataView: {show: true, readOnly: false},
                                            magicType: {show: true, type: ['line', 'bar', 'stack', 'tiled']},
                                            restore: {show: true},
                                            saveAsImage: {show: true}
                                        }
                                    },
                                    calculable: true,
                                    xAxis: [
                                        {
                                            type: 'category',
                                            axisTick: {show: false},
                                            data : ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']
                                        }
                                    ],
                                    yAxis: [
                                        {
                                            type: 'value'
                                        }
                                    ],
                                    series: [
                                        {
                                            name: '每月访问量',
                                            type: 'line',
                                            barGap: 0,
                                            label: labelOption,
                                            data:[1,2,3,4,5,6,7,8,9,6,5,6],
                                            markPoint : {
                                                data : [
                                                    {type : 'max', name: '最高'},
                                                    {type : 'min', name: '最低'}
                                                ]
                                            },
                                            markLine : {
                                                data : [
                                                    {type : 'average', name: '平均'}
                                                ]
                                            }
                                        }
                                    ]
                                };;
                                if (option && typeof option === "object") {
                                    myChart.setOption(option, true);
                                }
                            </script>
                        </div>
                    </div>


                </div >
            </div >

        </div>


        <div class="layui-col-sm6 layui-col-md6" >

            <div class="layui-card" >
                <div class="layui-card-header" >最新访问者</div >
                <div class="layui-card-body" >

                    <table class="layui-table layuiadmin-page-table" lay-skin="line" >
                        <thead >
                        <tr >
                            <th >IP</th >
                            <th >地址</th >
                            <th >浏览器</th >
                            <th >时间</th >
                        </tr >
                        </thead >
                        <tbody >



                        </tbody >
                    </table >

                </div >
            </div >

        </div>


    </div>




</div>

</body>

</html>