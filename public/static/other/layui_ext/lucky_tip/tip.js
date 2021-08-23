
layui.define(['jquery','layer'], function(exports) {
    "use strict";
    // 声明变量
    var $ = layui.$;
    var layer=layui.layer;
    var show_id=0;

    //声明类
    var tip={
         //开启
        tipStart:function () {
              $(document).on("mouseenter",".layui-btn",function () {
                   tip.tipS(this);
              }).on("mouseleave",".layui-btn",function () {
                    tip.tipH(this);
              });
        },
        //显示 tips
        tipS:function (obj) {
           if (show_id) return false;
           //获取显示内容
           var title=$(obj).attr("data-title");
           if(!title) return  false;
           show_id=layer.tips(title,obj,{
               tips:[1,"black"],
               time:3000
           });
        },

        //关闭 tip
        tipH:function () {
            layer.close(show_id);
            show_id=0;
        }
    };

    /**
     * 输出模块(此模块接口是对象)
     */
    exports('tip', tip);

});