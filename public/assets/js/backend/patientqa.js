define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'patientqa/index'  + location.search,
                    add_url: 'patientqa/add',
                    edit_url: 'patientqa/edit',
                    del_url: 'patientqa/del',
                    table: 'patientqa',
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
                        {field: 'patient.name', title: __('Name'),operate:'LIKE'},
                        {field: 'patient_id', title: __('Name'),visible:false, operate:false},
                        // {field: 'doctor.id', title: __('doctor'), operate:},
                        // {field: 'doctor.name', title: __('doctor'),searchList: $.getJSON("doctor/list")},
                        {field: 'doctor.name', title: __('doctor')},
                        {field: 'question', title: __('question'), operate:false},

                        {field: 'answer', title: __('answer') , searchList: {2: __('全部'),1: __('已回答'), 0: __('待回答')},
                            formatter: function (value, row, index) {
                                return '<div class="archives-label">' + Table.api.formatter.flag.call(this, (row['answer'])?'':'待回答', row, index) + '</div>';
                            }
                        },
                        {field: 'createtime', title: __('Createtime'), formatter: Table.api.formatter.datetime, operate: 'RANGE', addclass: 'datetimerange'},
                        // {field: 'updatetime', title: __('Updatetime'), formatter: Table.api.formatter.datetime, operate: 'RANGE', addclass: 'datetimerange'},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, 
                        buttons: [
                            {
                                name: 'history',
                                text: __('咨询历史'),
                                title: __('咨询历史'),
                                classname: 'btn btn-xs btn-primary btn-dialog',
                                icon: 'fa fa-list',
                                url: 'patientqa/history/patient_id/{patient_id}',
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
                queryParams: function (params){
                    debugger;
                    var filter = JSON.parse(params.filter);
                    var op = JSON.parse(params.op);
                    if(typeof filter.answer === 'undefined') return params;

                    if(filter.answer == 2){
                        delete op.answer
                        delete filter.answer
                    }else if(filter.answer == 1){
                        op.answer = '<>'
                        filter.answer = ''
                    }else{
                        op.answer = '='
                        filter.answer = ''
                    }

                    params.filter = JSON.stringify(filter)
                    params.op = JSON.stringify(op)
                    // if(params.filter == '{}'){
                    //     params.filter =  JSON.stringify({answer: ''})
                    //     params.op =  JSON.stringify({answer: '='})
                    // }
                    return params;
                },
                // onClickRow: function (item, $element) {
                //     $.ajax({
                //         url: "patientqa/history",
                //         type: 'post',
                //         dataType: 'json',
                //         data: {patient_id: item.patient_id},
                //         success: function (ret) {
                //             if (ret.hasOwnProperty("code")) {
                //                 let data = ret.hasOwnProperty("data") && ret.data != "" ? ret.data : "";
                //                 if (ret.code === 1) {
                //                     // //销毁已有的节点树
                //                     // $("#treeview").jstree("destroy");
                //                     Controller.api.renderList(data);
                //                 } else {
                //                     Backend.api.toastr.error(ret.msg);
                //                 }
                //             }
                //         }, error: function (e) {
                //             Backend.api.toastr.error(e.message);
                //         }
                //     });
                // },
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
            },
            renderList: function(data){
                var s = '';
                data.forEach(x => {
                    var reply = '';
                    if(!! x.answer){
                        reply = "答:" +  x.answer + "";
                    }else{
                        debugger;
                        reply = '<a href="patientqa/edit/ids/' + x.id + '" class="btn btn-xs btn-success btn-editone btn-dialog" data-original-title="编辑">去回答</a>';
                    }

                    s += '\
                    <div class="timeline "> \
                    <span class="timeline-icon"></span> \
                    <span class="year">'  + x.createtime +  '</span> \
                    <div class="timeline-content"> \
                    <div class="description">问:'+ x.question +'</div> \
                    <div class="description">'+ reply +'</div> \
                    </div> \
                </div>';
                })
                
                $('#qaList').html(s);
            }
        }
    };
    return Controller;
});