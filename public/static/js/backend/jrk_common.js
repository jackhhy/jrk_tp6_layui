/**
 * Luckhhy
 */
(function ($) {
    $.extend({
        //通用方法封装
        common:{
            /**
             * 判断字符串是否为空
             * @param value
             * @returns {boolean}
             */
            isEmpty: function (value) {
                if (value == null || this.trim(value) == "") {
                    return true;
                }
                return false;
            },
            /**
             * 查看大图
             * @param src
             */
            imageClickView:function(src){
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
             * 判断一个字符串是否为非空串
             * @param value
             * @returns {boolean}
             */
            isNotEmpty: function (value) {
                return !$.common.isEmpty(value);
            },
            /**
             * 空对象转字符串
             * @param value
             * @returns {string|*}
             */
            nullToStr: function(value) {
                if ($.common.isEmpty(value)) {
                    return "-";
                }
                return value;
            },
            /**
             * 是否显示数据 为空默认为显示
             * @param value
             * @returns {boolean}
             */
            visible: function (value) {
                if ($.common.isEmpty(value) || value == true) {
                    return true;
                }
                return false;
            },
            /**
             * 首字母大写
             * @param str
             * @returns {string}
             */
            upCase: function(str) {
                if ($.common.isEmpty(str)) {
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
                if ($.common.isEmpty(src)) return false;
                var ext = src.substring(src.length, src.lastIndexOf('.'));
                if (ext != '.png' && ext != '.jpg' && ext != '.gif' && ext != '.jpeg') return false;
                layer.tips('<img src="' + lucky.htmlspecialchars(src) + '" height="120">', obj, {
                    tips: [1, '#fff']
                });
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
             * 时间格式化
             * @param inputTime
             * @param t
             * @returns {string}
             */
            timeToTime:function(inputTime,t=1){
                var date = new Date(inputTime* 1000); //时间戳为10位需*1000，时间戳为13位的话不需乘1000
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
                if (t==1){
                    k= y + '-' + m + '-' + d;
                } else{
                    k= y + '-' + m + '-' + d+' '+h+':'+minute+':'+second;
                }
                return k;
            },
            /**
             * js判断字符串是否在数组中
             * @param stringToSearch 字符串
             * @param arrayToSearch 数组
             * @returns {boolean}
             */
            inArray:function (stringToSearch, arrayToSearch) {
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
            isEmail: function(str){
                var reg = /^[a-z0-9]([a-z0-9\\.]*[-_]{0,4}?[a-z0-9-_\\.]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+([\.][\w_-]+){1,5}$/i;
                if(reg.test(str)){
                    return true;
                }else{
                    return false;
                }
            },
            /**
             * 空格截取
             * @param value
             * @returns {string}
             */
            trim: function (value) {
                if (value == null) {
                    return "";
                }
                return value.toString().replace(/(^\s*)|(\s*$)|\r|\n/g, "");
            },
            /**
             * 比较两个字符串（大小写敏感）
             * @param str
             * @param that
             * @returns {boolean}
             */
            equals: function (str, that) {
                return str == that;
            },
            /**
             * 比较两个字符串（大小写不敏感）
             * @param str
             * @param that
             * @returns {boolean}
             */
            equalsIgnoreCase: function (str, that) {
                return String(str).toUpperCase() === String(that).toUpperCase();
            },
            /**
             * 将字符串按指定字符分割
             * @param str
             * @param sep
             * @param maxLen
             * @returns {null|string[]}
             */
            split: function (str, sep, maxLen) {
                if ($.common.isEmpty(str)) {
                    return null;
                }
                var value = String(str).split(sep);
                return maxLen ? value.slice(0, maxLen - 1) : value;
            },
            /**
             * 字符串格式化(%s )
             * @param str
             * @returns {*}
             */
            sprintf: function (str) {
                var args = arguments, flag = true, i = 1;
                str = str.replace(/%s/g, function () {
                    var arg = args[i++];
                    if (typeof arg === 'undefined') {
                        flag = false;
                        return '';
                    }
                    return arg;
                });
                return flag ? str : '';
            },
            /**
             *  获取节点数据，支持多层级访问
             * @param item
             * @param field
             * @returns {*}
             */
            getItemField: function (item, field) {
                var value = item;
                if (typeof field !== 'string' || item.hasOwnProperty(field)) {
                    return item[field];
                }
                var props = field.split('.');
                for (var p in props) {
                    value = value && value[props[p]];
                }
                return value;
            },
            /**
             * 指定随机数返回
             * @param min
             * @param max
             * @returns {number}
             */
            random: function (min, max) {
                return Math.floor((Math.random() * max) + min);
            },
            /**
             * 判断字符串是否是以start开头
             * @param value
             * @param start
             * @returns {boolean}
             */
            startWith: function(value, start) {
                var reg = new RegExp("^" + start);
                return reg.test(value)
            },
            /**
             * 判断字符串是否是以end结尾
             * @param value
             * @param end
             * @returns {boolean}
             */
            endWith: function(value, end) {
                var reg = new RegExp(end + "$");
                return reg.test(value)
            },
            /**
             * 数组去重
             * @param array
             * @returns {[]}
             */
            uniqueFn: function(array) {
                var result = [];
                var hashObj = {};
                for (var i = 0; i < array.length; i++) {
                    if (!hashObj[array[i]]) {
                        hashObj[array[i]] = true;
                        result.push(array[i]);
                    }
                }
                return result;
            },
            /**
             * 数组中的所有元素放入一个字符串
             * @param array
             * @param separator
             * @returns {null|*}
             */
            join: function(array, separator) {
                if ($.common.isEmpty(array)) {
                    return null;
                }
                return array.join(separator);
            },
            /**
             * 获取form下所有的字段并转换为json对象
             * @param formId
             * @returns {{}}
             */
            formToJSON: function(formId) {
                var json = {};
                $.each($("#" + formId).serializeArray(), function(i, field) {
                    if(json[field.name]) {
                        json[field.name] += ("," + field.value);
                    } else {
                        json[field.name] = field.value;
                    }
                });
                return json;
            },
            /**
             * 数据字典转下拉框
             * @param datas
             * @param value
             * @param name
             * @returns {string}
             */
            dictToSelect: function(datas, value, name) {
                var actions = [];
                actions.push($.common.sprintf("<select class='form-control' name='%s'>", name));
                $.each(datas, function(index, dict) {
                    actions.push($.common.sprintf("<option value='%s'", dict.dictValue));
                    if (dict.dictValue == ('' + value)) {
                        actions.push(' selected');
                    }
                    actions.push($.common.sprintf(">%s</option>", dict.dictLabel));
                });
                actions.push('</select>');
                return actions.join('');
            },
            /**
             * 获取obj对象长度
             * @param obj
             * @returns {number}
             */
            getLength: function(obj) {
                var count = 0;
                for (var i in obj) {
                    if (obj.hasOwnProperty(i)) {
                        count++;
                    }
                }
                return count;
            },
            /**
             * 首字母大写
             * @param str
             * @returns {string}
             */
            upCase: function(str){
                if (lucky.isEmpty(str)) {
                    return ;
                }
                return str.substring(0,1).toUpperCase() + str.substring(1);
            },
            /**
             * 金额数字转大写
             * @param num
             * @returns {string}
             */
            upDigit: function(num){
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
            setCookie :function(name, value, iDay){
                var oDate = new Date();
                oDate.setDate(oDate.getDate() + (iDay*60*1000));
                document.cookie = name + '=' + value + ';expires=' + oDate;
            },

            /**
             * 获取cookie
             * @param name
             * @returns {string|null}
             */
            getCookie: function(name){
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
            removeCookie: function(name){
                this.setCookie(name, 1, -1);
            },
            /**
             *  手机号格式验证
             * @param tel
             * @returns {boolean}
             */
            isPhone: function(tel){
                var reg = /(^1[3|4|5|7|8][0-9]{9}$)/;
                if (reg.test(tel)) {
                    return true;
                }else{
                    return false;
                };
            },
            /**
             * 数据类型判断
             * 案例：istype([],'array')
             */
            istype: function(o, type){
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
             * 获取URL参数
             * 调用：getUrlParam('http://xxxx?Id=100011938')
             * @param url
             */
            getUrlParam: function(url){
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
            setUrlParam: function(obj){
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
            randomColor: function(){
                return '#' + Math.random().toString(16).substring(2).substr(0, 6);
            },
            /**
             * html实体转换
             * @param str
             * @returns {*}
             */
            htmlspecialchars:function (str) {
                str = str.replace(/&/g, '&amp;');
                str = str.replace(/</g, '&lt;');
                str = str.replace(/>/g, '&gt;');
                str = str.replace(/"/g, '&quot;');
                str = str.replace(/'/g, '&#039;');
                return str;
            },
            /**
             * 数字排序
             * 调用：numberSort(arr,'a,b')a是第一排序条件，b是第二排序条件
             * @param arr
             * @param sort
             * @returns {*}
             */
            numberSort: function(arr, sort){
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
             * 随机返回一定范围的数字
             * @param n1
             * @param n2
             * @returns {number}
             */
            randomNumber: function(n1, n2){
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
             * 判断移动端
             * @returns {RegExpMatchArray}
             */
            isMobile: function () {
                return navigator.userAgent.match(/(Android|iPhone|SymbianOS|Windows Phone|iPad|iPod)/i);
            }
        }
    })
})(jQuery);