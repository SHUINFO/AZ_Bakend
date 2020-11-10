define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'patient/index',
                    add_url: 'patient/add',
                    edit_url: 'patient/edit',
                    del_url: 'patient/del',
                    table: 'patient',
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
                        {field: 'id', title: __('Name'),visible:true},
                        {field: 'name', title: __('Name')},
                        {field: 'mobile', title: __('Mobile')},
                        {field: 'birth_year', title: __('Age')},
                        {field: 'disease', title: __('disease')},
                        {field: 'diagnose_at', title: __('diagnose_at')},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, 
                        buttons: [
                            {
                                name: 'history',
                                text: __('咨询历史'),
                                title: __('咨询历史'),
                                classname: 'btn btn-xs btn-primary btn-dialog',
                                icon: 'fa fa-list',
                                url: 'patientqa/history/patient_id/{id}',
                                callback: function (data) {
                                },
                                visible: function (row) {
                                    return true;
                                }
                            }
                        ],
                        formatter: Table.api.formatter.operate}

                    ]
                ],
                onClickRow: function (item, $element) {
                    for(let ss in item){
                        $('#patientDetail *[data-rel="' + ss + '"]').html(item[ss]);
                    }
                },
            });
            // 为表格绑定事件
            Table.api.bindevent(table);

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
            }
        }
    };
    return Controller;
});