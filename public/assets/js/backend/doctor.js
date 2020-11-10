define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'doctor/index',
                    add_url: 'doctor/add',
                    edit_url: 'doctor/edit',
                    del_url: 'doctor/del',
                    import_url: 'doctor/import',
                    multi_url: 'doctor/multi',
                    table: 'doctor',
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
                        {field: 'hospital.name', title: __('hospital')},
                        {field: 'department', title: __('department')},
                        {field: 'mobile', title: __('Mobile')},
                        {field: 'wxid', title: __('wxid')},
                        {field: 'title', title: __('title')},
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
                Layer.confirm("请选择导出的选项<form action='" + Fast.api.fixurl("doctor/export") + "' method='post' target='_blank'><input type='hidden' name='ids' value='' /><input type='hidden' name='filter' ><input type='hidden' name='op'><input type='hidden' name='search'><input type='hidden' name='columns'></form>", {
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
            Controller.api.bindDepartment();
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindDepartment();
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
                $("input[name='row[type]']:checked").trigger("click");
            },
            bindDepartment:function(){
                $('#hospital_id').change(function(){
                    $("#department").val("").trigger("change");//清空
                    $("#department").html("");//清空
                    $.ajax({
                        url: "hospital/department/ids/" + $('#hospital_id').val(), //所需要的列表接口地址	
                        dataType: "json",
                        success: function (data) {
                                $("#department").html("");//清空
                                $("#department").val("");//清空
                                var listFleet = "";
                                $.each(data['list'], function (key, item) {
                                    listFleet += "<option value='" + item['name'] + "'>" + item['name'] + "</option>";
                                });
                                $("#department").append(listFleet); 
                                $('#department').selectpicker('refresh');
                                $('#department').selectpicker('render');
                        },
                        error: function () {
                            console.log("数据传送失败！");
                        }
                    });
                })
                $('#hospital_id').change();
            }
        }
    };
    return Controller;
});