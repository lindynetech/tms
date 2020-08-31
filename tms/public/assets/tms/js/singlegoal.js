!function(){
var sgOptions = {
    lastSel: 0,
    defaultDate: $.datepicker.formatDate('yy-mm-dd', new Date()),
    status_slt: [ "Not Started:Not Started",
                  "In Progress:In Progress",
                  "On Hold:On Hold",
                  "Cancelled:Cancelled",
                  "Complete:Complete"
                ],
    stage_slt: [ "Definition:Definition",
                 "Planning:Planning",
                 "Execution:Execution",
                 "Closure:Closure"
                ],
    type_slt: [ "Business:Business",
                "Self-Development:Self-Development",
                "Personal:Personal"
                ],
    priority_slt: [ "A:A", "B:B", "C:C" ],
    urgency_slt: [ "1:1", "2:2", "3:3", "4:4", "5:5", "6:6", "7:7", "8:8", "9:9", "10:10"]

};

// CSRF Protection
$.ajaxPrefilter(function(options, originalOptions, xhr) {
    var token = $('meta[name="csrf-token"]').attr('content');
    if (token) {
        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
    }
});

sgwidth = $("#sgWrapper").width() - 30;

$(function() {
    $("#singleGoal").jqGrid({
        url: "/goals/listsingle/" + goalId,
        datatype: "json",
        guiStyle: "bootstrap",
        mtype: "GET",
        colNames: ["Date", "Type", "Goal", "Priority", "Urgency", "Deadline(E)", "Stage", "Status", "S.M.A.R.T.", "Progress"],
        colModel: [
            { name: "created_at", align: "center", width: 50, editoptions:{defaultValue: sgOptions.defaultDate}, formatter:'date', formatoptions: { newformat:'Y-m-d'}, search: false},
            { name: "type", width: 90, align: "center", editable:true, edittype:"select", editoptions:{value: sgOptions.type_slt.join(";")},  formatter:'select'},
            { name: "goal", width: 340, editable:true, formatter: "showlink", formatoptions:{baseLinkUrl:"/tasks/view"}, editrules: { required: true}, search: false },
            { name: "priority", width: 60, align: "center", editable:true, search: false, edittype:"select", editoptions:{value: sgOptions.priority_slt.join(";"), defaultValue: "C"}, search: false},
            { name: "urgency", width: 60, align: "center", editable:true, search: false, edittype:"select", editoptions:{value:sgOptions.urgency_slt.join(";"), defaultValue: "1"}, search: false },
            { name: "deadline", align: 'center', sortable: true, editrules: { date: true}, formatoptions: {newformat: 'Y-m-d'}, search: false,
                    width: 70, editable: true, edittype: 'text', editoptions: {defaultValue:sgOptions.defaultDate, dataInit: function (element) {
                    $(element).datepicker({
                        autoclose: true,
                        format: 'yyyy-mm-dd',
                        todayBtn: 'linked',
                        orientation: "bottom"
                    });
                }},
            },
            { name: "stage", width: 80, align: "center", editable:true, edittype:"select", editoptions:{value: sgOptions.stage_slt.join(";")},  formatter:'select', search: false},
            { name: "status", width: 80, align: "center", editable:true, edittype:"select", editoptions:{value: sgOptions.status_slt.join(";")},  formatter:'select'},
            {name: 'smart', width: 60, align: 'center', editable:true, formatter: 'checkbox', edittype: 'checkbox', editoptions: {value: '1:0', defaultValue: '0'}, search: false},
            { name: "progress", width: 120, sortable: false, search: false}
        ],
        rowNum: 1,
        rowList: [],        // disable page size dropdown
        pgbuttons: false,     // disable page control like next, back button
        pgtext: null,         // disable pager text like 'Page 0 of 10'
        viewrecords: false,
        height: "100%",
        multiSort: false,
        viewrecords: true,
        gridview: true,
        hidegrid: false,
        width: sgwidth,
        /*autowidth: true,*/
        autoencode: false,
        rownumbers: false,
        editurl: '/goals/edit',
        ondblClickRow: function (id) {
            $(this).jqGrid('editRow', id, true, null, null, '', '', function(){
                $(this).trigger("reloadGrid");
            });
        },
        onSelectRow: function (id) {
            if (id && id !== sgOptions.lastSel) {
                if (typeof sgOptions.lastSel !== "undefined") {
                    $(this).jqGrid('restoreRow', sgOptions.lastSel);
                }
                sgOptions.lastSel = id;
            }
        }
    });

    var editOptions = {
        keys: true,
        successfunc: function () {
            var $self = $(this);
            setTimeout(function () {
                $self.trigger("reloadGrid");
            }, 50);
        }
    };

    /*$("#singleGoal").jqGrid('navGrid', '#sg_pager', {add: false, edit: false, del: false, search: false, refresh: false});
    $("#singleGoal").jqGrid('inlineNav', '#sg_pager', {addParams: {position: "last",addRowParams: editOptions}, editParams: editOptions});*/
});
}();




