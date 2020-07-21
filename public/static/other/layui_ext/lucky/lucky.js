layui.define(['jquery', 'layer'], function(exports) {
    "use strict";
    // 声明变量
    var $ = layui.$;
    var layer = layui.layer;

    //声明类
    var lucky = {
        /**
         * 表格搜索
         * @param tableid
         * @param data
         * @constructor
         */
        CreateSearch: function(tableid, data) {
            if (data == "" || data == undefined) {
                data = [];
            }
            var index = layer.msg("查询中，请稍后...", { icon: 16, time: false, shade: 0.3, anim: 4 });
            setTimeout(function() {
                //执行重载
                layui.table.reload(tableid, {
                    page: {
                        curr: 1 //重新从第 1 页开始
                    },
                    where: data
                }, 'data');
                layer.close(index);
            }, 500);
        },

        /**
         * 先关闭然后刷新父页面
         * @param tableid
         */
        CloseLayerReload: function(tableid) {
            var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
            parent.layui.table.reload(tableid, 'data');
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
         * @param tableid
         * @constructor
         */
        CreateReload: function(tableid) {
            layui.table.reload(tableid, { where: {} }, 'data');
        },

        /**
         * 表单数据提交
         * @param url
         * @param data
         * @param table_id
         * @param is_close
         * @param r
         * @constructor
         */
        FormSubmit: function(url, data, table_id = 0, is_close = 0, r = 0) {
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
                        //表格id 为空则刷新本页面
                        var ie = lucky.isEmpty(table_id);
                        if (table_id == 0 || ie) {
                            layer.msg(data.msg, { icon: 1, time: 1500, shade: 0.3, anim: 4 }, function() {
                                window.location.reload();
                            });
                        } else {
                            if (is_close != 0) { //只要不是0其它任何数字都可以
                                layer.msg(data.msg, { icon: 1, time: 1500, shade: 0.3, anim: 4 });
                                setTimeout(function() {
                                    lucky.CloseLayerReload(table_id); //重载父页面表格
                                }, 500);

                            } else if (r != 0) {
                                layer.msg(data.msg, { icon: 1, time: 1500, shade: 0.3, anim: 4 });
                                setTimeout(function() {
                                    lucky.CloseFa(table_id); //重载父页面表格
                                }, 500);
                            } else {
                                layer.msg(data.msg, { icon: 1, time: 1500, shade: 0.3, anim: 4 });
                                setTimeout(function() {
                                    lucky.CloseLayer(table_id); //关闭弹窗
                                }, 500);
                            }
                        }

                    } else if (data.code == 4) {
                        layer.msg(data.msg, { icon: 15, time: 1500, shade: 0.3, anim: 4 }, function() {
                            $("#token").val(data.data._token);
                        });
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
         * 弹窗
         * @param title
         * @param w
         * @param h
         * @param url
         * @param table_id
         * @param is_full
         * @constructor
         */
        CreateOpenForm: function(title, w, h, url, table_id, is_full = "") {
            title ? title : '管理界面';
            w ? w : '40%';
            h ? h : '60%';
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
            if (lucky.isEmpty(is_full) == false) {
                layer.full(full); //最大化
            }
        },


        /**
         * 表格数据选择提交操作 （批量删除，批量更改状态等等）
         * @param ids
         * @param URL
         * @param table_id
         * @param msg
         * @param load
         * @returns {boolean}
         */
        FormatData: function(ids, URL, table_id, msg = '确定删除吗？', load = false) {
            if ($.isArray(ids)) {
                ids = ids.join(',');
            }
            if (lucky.isEmpty(ids)) {
                layer.msg("没选择任何数据", { time: 1500 });
                return false;
            }
            layer.confirm(msg, { skin: lucky.randomSkin(), icon: 3, title: "提示", anim: lucky.randomAnim() }, function(index) {
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
        formConfirm: function(url, data, message, table_id) {
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
                            if (lucky.isEmpty(table_id)) {
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
         * @param table_id
         * @param reload
         * @constructor
         */
        Ajax: function(url, data, table_id = null, reload = 0) {
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
                            if (reload == 1) {
                                window.location.reload();
                            } else if (lucky.isEmpty(table_id) == false) {
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
        Change_status: function(Change_status_url, table_id, tablename, id, field, status) {
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
         * 判断字符串是否为空
         */
        isEmpty: function(str) {
            if (str == null || typeof str == "undefined" || str == "") {
                return true;
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
         * 邮箱格式验证
         * @param str
         * @returns {boolean}
         */
        isEmail: function(str) {
            var reg = /^[a-z0-9]([a-z0-9\\.]*[-_]{0,4}?[a-z0-9-_\\.]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+([\.][\w_-]+){1,5}$/i;
            if (reg.test(str)) {
                return true;
            } else {
                return false;
            }
        },
        /**
         *  手机号格式验证
         * @param tel
         * @returns {boolean}
         */
        isMobile: function(tel) {
            var reg = /(^1[3|4|5|7|8][0-9]{9}$)/;
            if (reg.test(tel)) {
                return true;
            } else {
                return false;
            };
        },

        /**
         * 首字母大写
         * @param str
         * @returns {string}
         */
        upCase: function(str) {
            if (lucky.isEmpty(str)) {
                return;
            }
            return str.substring(0, 1).toUpperCase() + str.substring(1);
        },
        /**
         * 金额数字转大写
         * @param num
         * @returns {string}
         */
        upDigit: function(num) {
            var fraction = ['角', '分', '厘'];
            var digit = ['零', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖'];
            var unit = [
                ['元', '万', '亿'],
                ['', '拾', '佰', '仟']
            ];
            var head = num < 0 ? '欠人民币' : '人民币';
            num = Math.abs(num);
            var s = '';
            for (var i = 0; i < fraction.length; i++) {
                s += (digit[Math.floor(num * 10 * Math.pow(10, i)) % 10] + fraction[i]).replace(/零./, '');
            }
            s = s || '整';
            num = Math.floor(num);
            for (var i = 0; i < unit[0].length && num > 0; i++) {
                var p = '';
                for (var j = 0; j < unit[1].length && num > 0; j++) {
                    p = digit[num % 10] + unit[1][j] + p;
                    num = Math.floor(num / 10);
                }
                s = p.replace(/(零.)*零$/, '').replace(/^$/, '零') + unit[0][i] + s;
                //s = p + unit[0][i] + s;
            }
            return head + s.replace(/(零.)*零元/, '元').replace(/(零.)+/g, '零').replace(/^整$/, '零元整');
        },
        /**
         * 设置cookie,单位分钟
         * @param name
         * @param value
         * @param iDay
         */
        setCookie: function(name, value, iDay) {
            var oDate = new Date();
            oDate.setDate(oDate.getDate() + (iDay * 60 * 1000));
            document.cookie = name + '=' + value + ';expires=' + oDate;
        },

        /**
         * 获取cookie
         * @param name
         * @returns {string|null}
         */
        getCookie: function(name) {
            var arr = document.cookie.split('; ');
            for (var i = 0; i < arr.length; i++) {
                var arr2 = arr[i].split('=');
                if (arr2[0] == name) {
                    return arr2[1];
                }
            }
            return null;
        },
        /**
         * 删除Cookie
         * @param name
         */
        removeCookie: function(name) {
            this.setCookie(name, 1, -1);
        },

        /**
         * 元素显示
         * @param obj
         */
        objShow: function(obj) {
            var blockArr = ['div', 'li', 'ul', 'ol', 'dl', 'table', 'article', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'hr', 'header', 'footer', 'details', 'summary', 'section', 'aside', '']
            if (blockArr.indexOf(obj.tagName.toLocaleLowerCase()) === -1) {
                obj.style.display = 'inline';
            } else {
                obj.style.display = 'block';
            }
        },

        /**
         * 隐藏元素
         * @param obj
         */
        objHide: function(obj) {
            obj.style.display = "none";
        },

        /**
         * 数据类型判断
         * 案例：istype([],'array')
         */
        istype: function(o, type) {
            if (type) {
                var _type = type.toLowerCase();
            }
            switch (_type) {
                case 'string':
                    return Object.prototype.toString.call(o) === '[object String]';
                case 'number':
                    return Object.prototype.toString.call(o) === '[object Number]';
                case 'boolean':
                    return Object.prototype.toString.call(o) === '[object Boolean]';
                case 'undefined':
                    return Object.prototype.toString.call(o) === '[object Undefined]';
                case 'null':
                    return Object.prototype.toString.call(o) === '[object Null]';
                case 'function':
                    return Object.prototype.toString.call(o) === '[object Function]';
                case 'array':
                    return Object.prototype.toString.call(o) === '[object Array]';
                case 'object':
                    return Object.prototype.toString.call(o) === '[object Object]';
                case 'nan':
                    return isNaN(o);
                case 'elements':
                    return Object.prototype.toString.call(o).indexOf('HTML') !== -1
                default:
                    return Object.prototype.toString.call(o)
            }
        },

        /**
         * 关键字加标签（多个关键词用空格隔开）
         * 案例：findKey('守侯我oaks接到了来自下次你离开快乐吉祥留在开城侯','守侯 开','i')
         * @param str
         * @param key
         * @param el
         * @returns {*}
         */
        replaceKey: function(str, key, el) {
            var arr = null,
                regStr = null,
                content = null,
                Reg = null,
                _el = el || 'span';
            arr = key.split(/\s+/);
            //alert(regStr); //    如：(前端|过来)
            regStr = this.createKeyExp(arr);
            content = str;
            //alert(Reg);//        /如：(前端|过来)/g
            Reg = new RegExp(regStr, "g");
            //过滤html标签 替换标签，往关键字前后加上标签
            content = content.replace(/<\/?[^>]*>/g, '')
            return content.replace(Reg, "<" + _el + ">$1</" + _el + ">");
        },

        /**
         * 获取URL参数
         * 调用：getUrlParam('http://xxxx?Id=100011938')
         * @param url
         */
        getUrlParam: function(url) {
            url = url ? url : window.location.href;
            var _pa = url.substring(url.indexOf('?') + 1),
                _arrS = _pa.split('&'),
                _rs = {};
            for (var i = 0, _len = _arrS.length; i < _len; i++) {
                var pos = _arrS[i].indexOf('=');
                if (pos == -1) {
                    continue;
                }
                var name = _arrS[i].substring(0, pos),
                    value = window.decodeURIComponent(_arrS[i].substring(pos + 1));
                _rs[name] = value;
            }
            return _rs;
        },

        /**
         * 设置URL参数
         * 调用：setUrlParam({'a':1,'b':2})
         * @param obj
         * @returns {string}
         */
        setUrlParam: function(obj) {
            var _rs = [];
            for (var p in obj) {
                if (obj[p] != null && obj[p] != '') {
                    _rs.push(p + '=' + obj[p])
                }
            }
            return _rs.join('&');
        },

        /**
         * 随机产生颜色
         * @returns {string}
         */
        randomColor: function() {
            return '#' + Math.random().toString(16).substring(2).substr(0, 6);
        },

        /**
         * 随机返回一定范围的数字
         * @param n1
         * @param n2
         * @returns {number}
         */
        randomNumber: function(n1, n2) {
            //randomNumber(5,10)
            //返回5-10的随机整数，包括5，10
            if (arguments.length === 2) {
                return Math.round(n1 + Math.random() * (n2 - n1));
            }
            //randomNumber(10)
            //返回0-10的随机整数，包括0，10
            else if (arguments.length === 1) {
                return Math.round(Math.random() * n1)
            }
            //randomNumber()
            //返回0-255的随机整数，包括0，255
            else {
                return Math.round(Math.random() * 255)
            }
        },

        /**
         * 数字排序
         * 调用：numberSort(arr,'a,b')a是第一排序条件，b是第二排序条件
         * @param arr
         * @param sort
         * @returns {*}
         */
        numberSort: function(arr, sort) {
            if (!sort) {
                return arr
            }
            var _sort = sort.split(',').reverse(),
                _arr = arr.slice(0);
            for (var i = 0, len = _sort.length; i < len; i++) {
                _arr.sort(function(n1, n2) {
                    return n1[_sort[i]] - n2[_sort[i]]
                })
            }
            return _arr;
        },
        /**
         * console 打印
         * @param obj
         * @constructor
         */
        Console: function(obj) {
            console.log(obj);
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
         * 添加事件的方法
         * @param element 需要绑定事件的元素 Dom Object
         * @param eventName 需要绑定的事件类型名称 string
         * @param fn 回调函数 function
         */
        addEvent: function(element, eventName, fn) {
            if (element.addEventListener) { // 谷歌和火狐
                element.addEventListener(eventName, fn, false);
            } else if (element.attachEvent) { // IE8
                element.attachEvent("on" + eventName, fn);
            } else { // 所有浏览器
                element["on" + eventName] = fn;
            }
        },


        /**
         * 移除事件的兼容方法
         * @param element 需要绑定事件的元素 Dom Object
         * @param eventName 需要绑定的事件类型名称 string
         * @param fn 回调函数 function
         */
        removeEvent: function(element, eventName, fn) {
            if (element.removeEventListener) { // 谷歌和火狐
                element.removeEventListener(eventName, fn, false);
            } else if (element.attachEvent) { // IE8
                element.attachEvent("on" + eventName, fn);
            } else { // 所有浏览器
                element["on" + eventName] = null;
            }
        },

        picView: function(obj, src) {
            if (lucky.isEmpty(src)) return false;
            var ext = src.substring(src.length, src.lastIndexOf('.'));
            if (ext != '.png' && ext != '.jpg' && ext != '.gif' && ext != '.jpeg') return false;
            layer.tips('<img src="' + lucky.htmlspecialchars(src) + '" height="120">', obj, {
                tips: [1, '#fff']
            });
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
                })
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