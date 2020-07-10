/*引入layui 扩展*/
layui.config({
    base: '../../static/other/layui_ext/'
}).extend({
    lucky: 'lucky/lucky', //主方法
    iconHhysFa: 'iconHhys/iconHhysFa', //图标
    authtree: 'authtree/authtree', //
    inputTags: 'inputTags/inputTags', //
    openTable: 'openTable/openTable',
    tableEdit: 'tableTree/tableEdit',//表格树依赖我另外写的tableEdit模块
    tableTree: 'tableTree/tableTree', //表格树
    opTable:'opTable/opTable', //展开表
    tip:'lucky_tip/tip', //提示
}).use(['element','jquery', 'tip'],function () {
    var element = layui.element;
    var $ = layui.jquery;
    var tip=layui.tip;
    //开启小提示
    tip.tipStart();
});

