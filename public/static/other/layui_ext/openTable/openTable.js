/**
 @ Name：表格冗余列可展开显示
 @ Author：hbm
 @ License：MIT
 */

layui.define(['form', 'table'], function (exports) {
  var $ = layui.$
      , table = layui.table
      , form = layui.form
      , VERSION = 3.0, MOD_NAME = 'openTable', ELEM = '.layui-openTable', ON = 'on', OFF = 'off'

      //外部接口
      , openTable = {
        index: layui.openTable ? (layui.openTable.index + 10000) : 0

        //设置全局项
        , set: function (options) {
          var that = this;
          that.config = $.extend({}, that.config, options);
          return that;
        }

        //事件监听
        , on: function (events, callback) {
          return layui.onevent.call(this, MOD_NAME, events, callback);
        }
      }

      //操作当前实例
      , thisIns = function () {
        var that = this
            , options = that.config
            , id = options.id || options.index;

        return {
          reload: function (options) {
            //暂时停用 更新操作走 render()
            that.reload.call(that, options);
          }
          , config: options
        }
      }

      //构造器
      , Class = function (options) {
        var that = this;
        that.index = ++openTable.index;
        that.config = $.extend({}, that.config, openTable.config, options);
        that.render();
        return this;
      };

  //默认配置
  Class.prototype.config = {
    openType: 0
  };

  //渲染视图
  Class.prototype.render = function () {
    var that = this
        , options = that.config
        , colArr = options.cols[0]
        , openCols = options.openCols || []
        , openNetwork = options.openNetwork || null
        , done = options.done;

    delete options["done"];
    //  1、在第一列 插入可展开操作
    colArr.splice(0, 0, {
      align: 'left',
      width: 50,
      templet: function (item) {
        return "<i class='openTable-i-table-open ' status='off'  data='"
            //  把当前列的数据绑定到控件
            + (JSON.stringify(item))
            + "' title='展开'></i>";
      }
    });


    //  2、表格Render
    table.render(
        $.extend({
          done: function (res, curr, count) {
            initExpandedListener();
            if (done) {
              done(res, curr, count)
            }
          }
        }, options));


    // 3、展开事件
    function initExpandedListener() {


      //扩大点击事件范围 为父级div
      $(".openTable-i-table-open")
          .parent()
          .unbind()
          .click(function () {
            var that = $(this).children(), _this = this;

            // 关闭类型
            if (options.openType === 0) {
              var sta = $(".openTable-open-dow").attr("status"),
                  isThis = (that.attr("data") === $(".openTable-open-dow").attr("data"));
              //1、关闭展开的
              $(".openTable-open-dow")
                  .addClass("openTable-open-up")
                  .removeClass("openTable-open-dow")
                  .attr("status", OFF);

              //2、如果当前 = 展开 && 不等于当前的 关闭
              if (sta === ON && isThis) {
                $(".openTable-open-td").slideUp(100, function () {
                  $(".openTable-open-td").remove();
                });

                return;
              } else {
                that.attr("status", OFF)
                $(".openTable-open-td").remove();
              }
            }

            var _this = this
                , bindOpenData = JSON.parse(that.attr("data"))
                , status = that.attr("status") === 'on';

            //  1、如果当前为打开，再次点击则关闭
            if (status) {
              that.removeClass("openTable-open-dow");
              that.attr("status", 'off');
              this.addTR.find("div").slideUp(100, function () {
                _this.addTR.remove();
              });
              return;
            }


            // 把添加的 tr 绑定到当前 移除时使用
            this.addTR = $([
              "<tr><td class='openTable-open-td'  colspan='" + (colArr.length + 1) + "'>"
              , "<div style='margin-left: 50px;display: none'></div>"
              , "</td></tr>"].join("")
            );
            that.parent().parent().parent().after(this.addTR);
            var html = [];

            // 从网络获取
            if (openNetwork) {
              openNetwork.reload = openNetwork.reload || true;
              loadNetwork();
            } else {
              //  2、从左到右依次排列 Item
              openCols.forEach(function (val, index) {
                appendItem(val, bindOpenData);
              });
              $(".openTable-open-td >div").append(html.join(''));
              this.addTR.find("div").slideDown(200);
              bindBlur(bindOpenData);
            }


            function loadNetwork() {
              $(".openTable-open-td >div")
                  .empty()
                  .append('<div class="openTable-network-message" ><i class="layui-icon layui-icon-loading layui-icon layui-anim layui-anim-rotate layui-anim-loop" data-anim="layui-anim-rotate layui-anim-loop"></i></div>');
              _this.addTR.find("div").slideDown(200);


              openNetwork.onNetwork(bindOpenData
                  //加载成功
                  , function (obj) {

                    //  2、从左到右依次排列 Item
                    openNetwork.openCols.forEach(function (val, index) {
                      appendItem(val, obj);
                    });

                    // 填充展开数据
                    $(".openTable-open-td >div").empty().append(html.join(''));
                    bindBlur(obj);
                  }
                  , function (msg) {
                    $(".openTable-open-td >div")
                        .empty()
                        .append("<div class='openTable-reload openTable-network-message' style='text-align: center;margin-top: 20px'>" + (msg || "没有数据") + "</div>")

                    if (openNetwork.reload) {
                      $(".openTable-reload")
                          .unbind()
                          .click(function (e) {
                            loadNetwork();
                          });
                    }
                  })
            }


            /**
             * 添加item
             * @param colsItem  cols配置信息
             * @param openData  展开数据
             */
            function appendItem(colsItem, openData) {
              //  1、自定义模板
              if (colsItem.templet) {
                html.push("<div class='openTable-open-item-div'>")
                html.push(colsItem.templet(openData));
                html.push("</div>")
                //  2、可下拉选择类型
              } else if (colsItem.type && colsItem.type === 'select') {
                var child = ["<div id='" + colsItem.field + "' class='openTable-open-item-div' >"];
                child.push("<span style='color: #99a9bf'>" + colsItem["title"] + "：</span>");
                child.push("<div class='layui-input-inline'><select  lay-filter='" + colsItem.field + "'>");
                colsItem.items.forEach(function (it) {
                  it = colsItem.onDraw(it, openData);
                  child.push("<option value='" + it.id + "' ");
                  child.push(it.isSelect ? " selected='selected' " : "");
                  child.push(" >" + it.value + "</option>");
                });
                child.push("</select></div>");
                child.push("</div>");
                html.push(child.join(""));
                setTimeout(function () {
                  layui.form.render();
                  //  监听 select 修改
                  layui.form.on('select(' + colsItem.field + ')', function (data) {
                    if (options.edit && colsItem.onSelect(data, openData)) {
                      var json = {};
                      json.value = data.value;
                      json.field = colsItem.field;
                      openData[colsItem.field] = data.value;
                      json.data = JSON.parse(JSON.stringify(openData));
                      options.edit(json);
                    }
                  });
                }, 20);
              } else {
                var text = openData.onDraw ? openData.onDraw(openData) : openData[colsItem["field"]];
                // 3、默认类型
                html.push("<div class='openTable-open-item-div'>");
                html.push("<span class='openTable-item-title'>" + colsItem["title"] + "：</span>");
                html.push((colsItem.edit ?
                        ("<input  class='openTable-exp-value openTable-exp-value-edit' autocomplete='off' name='" + colsItem["field"] + "' value='" + text + "'/>")
                        : ("<span class='openTable-exp-value' >" + text + "</span>")
                ));
                html.push("</div>");
              }

            }


            /**
             * 绑定监听 修改失焦点监听
             * @param bindOpenData
             */
            function bindBlur(bindOpenData) {
              $(".openTable-exp-value-edit")
                  .blur(function () {
                    var that = $(this), name = that.attr("name"), val = that.val();
                    // 设置了回调 &&发生了修改
                    if (options.edit && bindOpenData[name] + "" !== val) {
                      var json = {};
                      json.value = that.val();
                      json.field = that.attr("name");
                      bindOpenData[name] = val;
                      json.data = bindOpenData;
                      options.edit(json);
                    }
                  })
                  .keypress(function (even) {
                    even.which === 13 && $(this).blur()
                  })
            }

            that.addClass("openTable-open-dow");
            that.attr("status", 'on');
          });

    }

    //  4、监听排序事件
    var elem = $(options.elem).attr("lay-filter");

    //  5、监听表格排序
    table.on('sort(' + elem + ')', function (obj) {
      if (options.sort) {
        options.sort(obj)
      }
      // 重新绑定事件
      initExpandedListener();
    });

    //  6、单元格编辑
    layui.table.on('edit(' + elem + ')', function (obj) {
      if (options.edit) {
        options.edit(obj)
      }
    });

  };

  //核心入口
  openTable.render = function (options) {
    var ins = new Class(options);
    return thisIns.call(ins);
  };

    layui.link('./openTable.css?v=1');

 /* //加载组件所需样式
  layui.link(layui.cache.base + 'openTable/openTable.css?v=1' + VERSION, function () {
    //此处的“openTable”要对应 openTable.css 中的样式： html #layuicss-openTable{}
  }, 'openTable');
*/
  exports('openTable', openTable);
});
