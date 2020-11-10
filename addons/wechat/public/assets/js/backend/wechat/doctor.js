define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'wechat/doctor/index',
                    add_url: 'wechat/doctor/add',
                    edit_url: 'wechat/doctor/edit',
                    del_url: 'wechat/doctor/del',
                    import_url: 'wechat/doctor/import',
                    multi_url: 'wechat/doctor/multi',
                    table: 'wechat_doctor',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {field: 'state', checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'avatar', title: __('Avatar'), formatter: Table.api.formatter.image},
                        {field: 'name', title: __('Name')},
                        {field: 'mobile', title: __('Mobile')},
                        {field: 'category', title: __('Category')},
                        {field: 'createtime', title: __('Createtime'), formatter: Table.api.formatter.datetime, operate: 'RANGE', addclass: 'datetimerange', sortable: true},
                        {field: 'updatetime', title: __('Updatetime'), formatter: Table.api.formatter.datetime, operate: 'RANGE', addclass: 'datetimerange', sortable: true},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);

            

            $(document).on("click", ".btn-export", function () {
                var ids = Table.api.selectedids(table);
                var page = table.bootstrapTable('getData');
                var all = table.bootstrapTable('getOptions').totalRows;
                console.log(ids, page, all);
                Layer.confirm("请选择导出的选项<form action='" + Fast.api.fixurl("wechat/doctor/export") + "' method='post' target='_blank'><input type='hidden' name='ids' value='' /><input type='hidden' name='filter' ><input type='hidden' name='op'><input type='hidden' name='search'><input type='hidden' name='columns'></form>", {
                    title: '导出数据',
                    btn: ["选中项(" + ids.length + "条)", "本页(" + page.length + "条)", "全部(" + all + "条)"],
                    success: function (layero, index) {
                        $(".layui-layer-btn a", layero).addClass("layui-layer-btn0");
                    }
                    , yes: function (index, layero) {
                        // submitForm(ids.join(","), layero);
                        $(layero).find('form input[name=ids]').val(ids.join(","))
                        Form.api.submit($(layero).find('form'));
                        return false;
                    }
                    ,
                    btn2: function (index, layero) {
                        var ids = [];
                        $.each(page, function (i, j) {
                            ids.push(j.id);
                        });
                        // submitForm(ids.join(","), layero);
                        $(layero).find('form input[name=ids]').val(ids.join(","))
                        Form.api.submit($(layero).find('form'));
                        return false;
                    }
                    ,
                    btn3: function (index, layero) {
                        // submitForm("all", layero);
                        $(layero).find('form input[name=ids]').val(all)
                        Form.api.submit($(layero).find('form'));
                        return false;
                    }
                })
            })            
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
                $("input[name='row[type]']:checked").trigger("click");
            }
        }
    };
    return Controller;
});