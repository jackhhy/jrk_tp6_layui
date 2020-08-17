layui.define(['jquery', 'layer'], function(exports) {
    "use strict";
    // 声明变量
    var $ = layui.$;
    var layer = layui.layer;
    var table_id='table_id';
    //声明类
    var lucky = {
        /**
         * 表格搜索
         * @param tableid
         * @param data
         * @constructor
         */
        CreateSearch: function(data) {
            if (data == "" || data == undefined) {
                data = [];
            }
            var index = layer.msg("查询中，请稍后...", { icon: 16, time: false, shade: 0.3, anim: 4 });
            setTimeout(function() {
                //执行重载
                layui.table.reload(table_id, {
                    page: {
                        curr: 1 //重新从第 1 页开始
                    },
                    where: data
                }, 'data');
                layer.close(index);
            }, 500);
        },

        /**
         * 查看大图
         * @param src
         */
        imageView:function(src){
            if ($.common.isMobile()) {
                width = 'auto';
                height = 'auto';
                layer.open({
                    title: false,
                    type: 1,
                    closeBtn: true,
                    shadeClose: true,
                    area: ['auto', 'auto'],
                    content: "<img src='" + src + "' height='" + height + "' width='" + width + "'/>"
                });
            }else {
                layer.open({
                    title:false,
                    type: 1,
                    content: '<div class="layui-card text-center">\n' +
                    '    <div class="layui-card-body">\n' +
                    '        <div class="layadmin-homepage-pad-ver">\n' +
                    '            <img class="layadmin-homepage-pad-img" src="'+src+'" width="450" height="485">\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '</div>',
                    area: ["auto"],
                    anim: 5,
                    closeBtn:1
                });
            }
        },

        /**
         * 先关闭然后刷新父页面
         * @param tableid
         */
        CloseLayerReload: function() {
            var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
            parent.layui.table.reload(table_id, 'data');
        },


        /**
         * 关闭父级页面不刷新
         */
        CloseLayer: function() {
            var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
        },

        /**
         * //先刷新父页面后关闭
         */
        CloseFa: function() {
            parent.location.reload();
            var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
        },

        /**
         * 表格重载
         * @constructor
         */
        CreateReload: function() {
            layui.table.reload(table_id, { where: {} }, 'data');
        },

        /**
         *
         * @param url   提交地址
         * @param data  表单数据
         * @param reload 关闭弹窗刷新父页面的表格
         * @param cloeFa 关闭弹窗刷新父页面
         * @constructor
         */
        FormSubmit: function(url, data, reload,cloeFa) {
            $.ajax({
                url: url,
                type: 'post',
                data: data,
                error: function(error) {
                    var json = JSON.parse(error.responseText);
                    $.each(json.errors, function(idx, obj) {
                        layer.msg(obj[0], { icon: 15, time: 1500, shade: 0.3, anim: 4 });
                        return false;
                    });
                },
                beforeSend: function() {
                    layer.load(2);
                },
                success: function(data) {
                    if (data.code == 1) {
                        if ($.common.isNotEmpty(reload)){
                            layer.msg(data.msg, { icon: 1, time: 1500, shade: 0.3, anim: 4 });
                            setTimeout(function() {
                                lucky.CloseLayerReload(table_id); //重载父页面表格
                            }, 500);
                        }else if($.common.isNotEmpty(cloeFa)){
                            layer.msg(data.msg, { icon: 1, time: 1500, shade: 0.3, anim: 4 });
                            setTimeout(function() {
                                lucky.CloseLayer(table_id); //关闭弹窗
                            }, 500);
                        }else {
                            layer.msg(data.msg, { icon: 1, time: 1500, shade: 0.3, anim: 4 }, function() {
                                window.location.reload();
                            });
                        }
                    } else {
                        layer.msg(data.msg, { icon: 15, time: 1500, shade: 0.3, anim: 4 });
                    }
                },
                complete: function() {
                    layer.closeAll('loading');
                }
            });
        },


        /**
         *
         * @param title 标题
         * @param url 地址
         * @param w  宽
         * @param h  高
         * @param is_full 最大化
         * @constructor
         */
        CreateOpenForm: function(title, url, w, h, is_full) {
            if ($.common.isMobile()) {
                w = 'auto';
                h = 'auto';
            }else {
                w=$.common.isNotEmpty(w)?w:'60%';
                h=$.common.isNotEmpty(h)?w:'80%';
            }
            if ($.common.isEmpty(url)) {
                url = "/404.html";
            }
            var full = layer.open({
                title: title,
                type: 2,
                area: [w, h],
                offset: 'auto',
                maxmin: true,
                zIndex: layer.zIndex,
                skin: 'layui-layer-molv',
                shade: 0.5,
                content: url,
                end: function() {
                    /* if (table_id){
                         setTimeout(function(){
                             lucky.CreateReload(table_id);//重载表格
                         },500);
                     }*/
                }
            });
            if ($.common.isNotEmpty(is_full)){
                layer.full(full); //最大化
            }
        },


        /**
         * 表格数据选择提交操作 （批量删除，批量更改状态等等）
         * @param ids
         * @param URL
         * @param msg
         * @param load
         * @returns {boolean}
         */
        FormatData: function(ids, URL, msg, load) {
            if ($.isArray(ids)) {
                ids = ids.join(',');
            }
            if ($.common.isEmpty(ids)) {
                layer.msg("没选择任何数据", { time: 1500 });
                return false;
            }
            var msgs=$.common.isNotEmpty(msg)?msg:"确认删除？";
            layer.confirm(msgs, { skin: lucky.randomSkin(), icon: 3, title: "提示", anim: lucky.randomAnim() }, function(index) {
                layer.close(index);
                $.ajax({
                    beforeSend: function() {
                        if (load) {
                            layer.load(2);
                        }
                    },
                    url: URL,
                    type: "POST",
                    async: true,
                    dataType: "json",
                    data: {
                        ids: ids,
                    },
                    error: function(error) {
                        layer.msg("服务器错误或超时");
                        return false;
                    },
                    success: function(data) {
                        if (data.code == 1) {
                            lucky.layerMsg(data.msg, 1, function() {
                                setTimeout(function() {
                                    lucky.CreateReload(table_id); //重载表格数据
                                }, 500);
                            });
                        } else {
                            lucky.layerMsg(data.msg, 15, function() {
                                lucky.CreateReload(table_id);
                            });
                        }
                    },
                    complete: function() {
                        if (load) {
                            layer.closeAll('loading');
                        }
                    }
                });
            });
        },

        /**
         * 提交数据确认
         * @param url
         * @param data
         * @param message
         * @param table_id
         */
        formConfirm: function(url, data, message, reload) {
            layer.confirm(message, { skin: lucky.randomSkin(), icon: 3, title: "提示", anim: lucky.randomAnim() }, function(index) {
                layer.close(index);
                $.ajax({
                    beforeSend: function() {},
                    url: url,
                    type: type,
                    async: true,
                    dataType: "json",
                    data: data,
                    error: function(error) {
                        layer.msg("服务器错误或超时");
                        return false;
                    },
                    success: function(data) {
                        if (data.code == 1) {
                            lucky.layerMsg(data.msg, 1);
                            if ($.common.isNotEmpty(reload)) {
                                window.location.reload();
                            } else {
                                setTimeout(function() {
                                    lucky.CreateReload(table_id); //重载表格
                                }, 500);
                            }

                        } else {
                            lucky.layerMsg(data.msg, 15);
                        }
                    },
                    complete: function() {}
                });
            });
        },

        /**
         * 数据异步提交
         * @param url
         * @param data
         * @param reload
         * @constructor
         */
        Ajax: function(url, data, reload ) {
            $.ajax({
                beforeSend: function() {
                    layer.load(2);
                },
                url: url,
                type: "POST",
                async: true,
                dataType: "json",
                data: data,
                error: function(error) {
                    layer.msg("服务器错误或超时");
                    return false;
                },
                success: function(data) {
                    if (data.code == 1) {
                        lucky.layerMsg(data.msg, 1, function() {
                            if ($.common.isNotEmpty(reload)) {
                                window.location.reload();
                            }else{
                                setTimeout(function() {
                                    lucky.CreateReload(table_id); //重载表格
                                }, 500);
                            }
                        });
                    } else {
                        layer.msg(data.msg, { icon: 15, time: 1000, shade: 0.3 });
                    }
                },
                complete: function() {
                    layer.closeAll('loading');
                }
            });
        },

        Change_status: function(Change_status_url, tablename, id, field, status) {
            $.ajax({
                url: Change_status_url,
                type: 'post',
                async: true,
                dataType: "json",
                data: {
                    id: id,
                    table: tablename,
                    field: field,
                    status: status
                },
                error: function(error) {
                    layer.msg("服务器错误或超时");
                    return false;
                },
                beforeSend: function() {
                    layer.load(2);
                },
                success: function(res) {
                    layer.msg(res.msg, { icon: 1, time: 1000, shade: 0.3 }, {
                        time: 1000
                    }, function() {
                        lucky.CreateReload(table_id);
                    });
                },
                complete: function() {
                    layer.closeAll('loading');
                }
            });
        },
        /**
         * 创建树菜单
         * @returns {Array}
         * @constructor
         */
        CreateTree: function(rows) {
            var nodes = [];
            for (var i = 0; i < rows.length; i++) {
                var row = rows[i];
                if (!lucky.Exists(rows, row.pid)) {
                    nodes.push({
                        id: row.id,
                        name: row.name,
                        value: row.value,
                        children: row.children
                    });
                }
            }
            var toDo = [];

            for (var i = 0; i < nodes.length; i++) {
                toDo.push(nodes[i]);
            }

            for (var i = 0; i < nodes.length; i++) {
                toDo.push(nodes[i]);
            }
            while (toDo.length) {
                var node = toDo.shift(); // the parent node
                // get the children nodes
                for (var i = 0; i < rows.length; i++) {
                    var row = rows[i];
                    if (row.pId == node.id) {
                        var child = { id: row.id, name: row.name, pId: node.id, value: row.value, children: row.children };
                        if (node.children) {
                            node.children.push(child);
                        } else {
                            node.children = [child];
                        }
                        toDo.push(child);
                    }
                }
            }
            return nodes;
        },

        /**
         * 某个是否存在
         * @param rows
         * @param pId
         * @returns {boolean}
         * @constructor
         */
        Exists: function(rows, pId) {
            for (var i = 0; i < rows.length; i++) {
                if (rows[i].id == pId) return true;
            }
            return false;
        },

        /**
         * 时间格式化
         * @param inputTime
         * @param t
         * @returns {string}
         * @constructor
         */
        timeToTime: function(inputTime, t = 1) {
            var date = new Date(inputTime * 1000); //时间戳为10位需*1000，时间戳为13位的话不需乘1000
            var y = date.getFullYear();
            var m = date.getMonth() + 1;
            m = m < 10 ? ('0' + m) : m;
            var d = date.getDate();
            d = d < 10 ? ('0' + d) : d;
            var h = date.getHours();
            h = h < 10 ? ('0' + h) : h;
            var minute = date.getMinutes();
            var second = date.getSeconds();
            minute = minute < 10 ? ('0' + minute) : minute;
            second = second < 10 ? ('0' + second) : second;
            let k;
            if (t == 1) {
                k = y + '-' + m + '-' + d;
            } else {
                k = y + '-' + m + '-' + d + ' ' + h + ':' + minute + ':' + second;
            }
            return k;
        },

        /**
         * layer-msg
         * @param msg
         * @param icon
         * @param callbackFunction
         */
        layerMsg: function(msg, icon, callbackFunction) {
            //1-绿色勾,2-红色叉,3-黄色问号,4-灰色锁,5-红色哭脸,6-绿色笑脸,7-黄色感叹号,15-返回失败
            let options = { icon: icon || lucky.randomIcon(), time: 1500, shade: 0.4, anim: lucky.randomAnim() };
            layer.msg(msg, options, callbackFunction);
        },

        /**
         * 随机layui 弹窗皮肤颜色
         * @returns {string}
         */
        randomSkin: function(yan = "jrk") {
            var skinArray = ["", "layui-layer-molv", "layui-layer-lan"];
            if (lucky.inArray(yan, skinArray)) {
                return yan;
            } else {
                return skinArray[Math.floor(Math.random() * skinArray.length)];
            }
        },

        /**
         * 弹窗随机动画
         * @param Anim
         * @returns {string|number}
         */
        randomAnim: function(Anim = "7") {
            var animArray = ["0", "1", "2", "3", "4", "5", "6"];
            if (lucky.inArray(Anim, animArray)) {
                return Anim;
            } else {
                return Math.floor(Math.random() * animArray.length);
            }
        },
        /**
         * 随机图标
         * @returns {number}
         */
        randomIcon: function() {
            // 绿色勾,红色叉,黄色问号,灰色锁,红色哭脸,绿色笑脸,黄色感叹号
            var iconArray = [1, 2, 3, 4, 5, 6, 7];
            return Math.floor(Math.random() * iconArray.length);
        },

        /**
         * js判断字符串是否在数组中
         * @param stringToSearch 字符串
         * @param arrayToSearch 数组
         * @returns {boolean}
         */
        inArray: function(stringToSearch, arrayToSearch) {
            for (var s = 0; s < arrayToSearch.length; s++) {
                var thisEntry = arrayToSearch[s].toString();
                if (thisEntry == stringToSearch) {
                    return true;
                }
            }
            return false;
        },



        /**
         * 给一个元素同时多个事件
         * @param element 需要绑定事件的元素 Dom Object
         * @param eventName 需要绑定的事件类型名称 string
         * @param fn  回调函数 function
         */
        addSeveralEvent: function(element, eventName, fn) {
            var oddEvent = element["on" + eventName];
            if (oddEvent == null) {
                element["on" + eventName] = fn;
            } else {
                element["on" + eventName] = function() {
                    oddEvent();
                    fn();
                }
            }
        },



        /**
         * html实体转换
         * @param str
         * @returns {*}
         */
        htmlspecialchars: function(str) {
            str = str.replace(/&/g, '&amp;');
            str = str.replace(/</g, '&lt;');
            str = str.replace(/>/g, '&gt;');
            str = str.replace(/"/g, '&quot;');
            str = str.replace(/'/g, '&#039;');
            return str;
        },
        /**
         * 小提示
         * @param obj
         * @param attr
         */
        tip: function(obj, attr) {
            attr = attr || "data-title";
            var row = $(obj).attr(attr); //获取显示内容
            //小tips
            layer.tips(row, obj, {
                tips: [1, "black"],
                time: 1000
            });
        },

        /**
         * 鼠标移上显示
         * @param obj
         * @param attr
         */
        hoverTip: function(obj, attr) {
            attr = attr || "data-title";
            $(obj).hover(function() {
                layer.tips(attr, $(this), {
                    tips: [1, "black"],
                    time: 1000
                });
            }, function() {
                layer.closeAll();
            });
        }

    };

    /**
     * 输出模块(此模块接口是对象)
     */
    exports('lucky', lucky);

});