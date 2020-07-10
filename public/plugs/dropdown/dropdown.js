/* layui_dropdown v1.0.3 by Microanswer,doc:http://test.microanswer.cn/dropdown.html */
layui.define(["jquery", "laytpl"], function (i) {
    "use strict";

    function e(i, t) {
        "string" == typeof i && (i = d(i)), this.$dom = i, this.option = d.extend({
            downid: String(Math.random()).split(".")[1],
            filter: i.attr("lay-filter")
        }, n, t), this.init()
    }

    var d = layui.jquery || layui.$, o = layui.laytpl, s = d(window.document.body), h = "a", a = {},
        l = window.MICROANSWER_DROPDOWAN || "dropdown",
        r = "<div tabindex='0' class='layui-anim layui-anim-upbit dropdown-root' " + l + "-id='{{d.downid}}' style='min-width: {{d.minWidth}}px;min-height: {{d.minHeight}}px;max-height: {{d.maxHeight}}px;overflow: auto;z-index: {{d.zIndex}}'>",
        u = "</div>",
        m = r + "{{# layui.each(d.menus, function(index, item){ }}{{# if ('hr' === item) { }}<hr>{{# } else if (item.header) { }}{{# if (item.withLine) { }}<fieldset class=\"layui-elem-field layui-field-title menu-header\" style=\"margin-left:0;margin-bottom: 0;margin-right: 0\"><legend>{{item.header}}</legend></fieldset>{{# } else { }}<div class='menu-header' style='text-align: {{item.align||'left'}}'>{{item.header}}</div>{{# } }}{{# } else { }}<div class='menu-item'><a href='javascript:;' lay-event='{{item.event}}'>{{# if (item.layIcon){ }}<i class='layui-icon {{item.layIcon}}'></i>&nbsp;{{# } }}<span>{{item.txt}}</span></a></div>{{# } }}{{# }); }}" + u,
        n = {showBy: "click", align: "left", minWidth: 10, minHeight: 10, maxHeight: 300, zIndex: 102, gap: 4};

    function t(i, o) {
        d(i || "[lay-" + l + "]").each(function () {
            var i = d(this), t = new Function("return " + (i.attr("lay-" + l) || "{}"))(),
                n = i.data(l) || new e(i, d.extend({}, t, o || {}));
            i.data(l, n)
        })
    }

    e.prototype.init = function () {
        var t = this;
        if (t.option.menus && 0 < t.option.menus.length) o(m).render(t.option, function (i) {
            t.$down = d(i), t.$dom.after(t.$down), t.initEvent()
        }); else if (t.option.template) {
            var i;
            i = -1 === t.option.template.indexOf("#") ? "#" + t.option.template : t.option.template;
            var n = d.extend({
                downid: t.option.downid,
                minWidth: t.option.minWidth,
                minHeight: t.option.minHeight,
                maxHeight: t.option.maxHeight,
                zIndex: t.option.zIndex
            }, t.option.data || {});
            o(r + d(i).html() + u).render(n, function (i) {
                t.$down = d(i), t.$dom.after(t.$down), t.option.success && t.option.success(t.$down), t.initEvent()
            })
        } else layui.hint().error("下拉框目前即没配置菜单项，也没配置下拉模板。[#" + (t.$dom.attr("id") || "") + ",filter=" + t.option.filter + "]")
    }, e.prototype.initPosition = function () {
        var i, t, n = this.$dom.offset(), o = this.$dom.outerHeight(), e = this.$dom.outerWidth(), d = n.left,
            s = n.top - window.scrollY, h = this.$down.outerHeight(), a = this.$down.outerWidth();
        i = "right" === this.option.align ? d + e - a : "center" === this.option.align ? d + (e - a) / 2 : d, (t = o + s + this.option.gap) + h >= window.innerHeight && (t = s - h - this.option.gap), i + a >= window.innerWidth && (i = window.innerWidth - a - this.option.gap), this.$down.css("left", i), this.$down.css("top", t)
    }, e.prototype.show = function () {
        var n, i;
        this.initPosition(), this.$down.addClass("layui-show"), this.opened = !0, n = this, i = a[h] || [], d.each(i, function (i, t) {
            t(n)
        }), this.option.onShow && this.option.onShow(this.$dom, this.$down)
    }, e.prototype.hide = function () {
        this.fcd = !1, this.$down.removeClass("layui-show"), this.opened = !1, this.option.onHide && this.option.onHide(this.$dom, this.$down)
    }, e.prototype.hideWhenCan = function () {
        this.mouseInCompoent || this.fcd || this.hide()
    }, e.prototype.toggle = function () {
        this.opened ? this.hide() : this.show()
    }, e.prototype.initEvent = function () {
        var i, t, n, o = this;
        t = function (i) {
            i !== o && o.hide()
        }, (n = a[i = h] || []).push(t), a[i] = n, o.$dom.mouseenter(function () {
            o.mouseInCompoent = !0, "hover" === o.option.showBy && (o.fcd = !0, o.$down.focus(), o.show())
        }), o.$dom.mouseleave(function () {
            o.mouseInCompoent = !1
        }), o.$down.mouseenter(function () {
            o.mouseInCompoent = !0, o.$down.focus()
        }), o.$down.mouseleave(function () {
            o.mouseInCompoent = !1
        }), "click" === o.option.showBy && o.$dom.on("click", function () {
            o.fcd = !0, o.toggle()
        }), s.on("click", function () {
            o.mouseInCompoent || (o.fcd = !1, o.hideWhenCan())
        }), d(window).on("scroll", function () {
            o.initPosition()
        }), d(window).on("resize", function () {
            o.initPosition()
        }), o.$dom.on("blur", function () {
            o.fcd = !1, o.hideWhenCan()
        }), o.$down.on("blur", function () {
            o.fcd = !1, o.hideWhenCan()
        }), o.option.menus && d("[" + l + "-id='" + o.option.downid + "']").on("click", "a", function () {
            var i = (d(this).attr("lay-event") || "").trim();
            i ? (layui.event.call(this, l, l + "(" + o.option.filter + ")", i), o.hide()) : layui.hint().error("菜单条目[" + this.outerHTML + "]未设置event。")
        })
    }, t(), i(l, {
        suite: t, onFilter: function (i, t) {
            layui.onevent(l, l + "(" + i + ")", function (i) {
                t && t(i)
            })
        }, version: "1.0.3"
    })
});