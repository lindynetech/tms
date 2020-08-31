!function(){
    var goalsOptions = {
        lastSel: 0,
        defaultDate: $.datepicker.formatDate('yy-mm-dd', new Date()),
        status_slt: [ "Not Started:Not Started",
                      "In Progress:In Progress",
                      "On Hold:On Hold",
                      "Cancelled:Cancelled",
                      "Complete:Complete"
                    ],
        status_search: [ ":Current",
                         "Not Started:Not Started",
                         "In Progress:In Progress",
                         "On Hold:On Hold",
                         "Cancelled:Cancelled",
                         "Complete:Complete",
                         "All:All"
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
        type_search: [ ":All",
                     "Business:Business",
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

    outerwidth = $("#goalsWrapper").width() - 30;

    $(function() {
        $("#goals").jqGrid({
            url: "/goals/list",
            datatype: "json",
            guiStyle: "bootstrap",
            mtype: "GET",
            colNames: ["Date", "Type", "Goal", "Priority", "Urgency", "Deadline(E)", "Stage", "Status", "S.M.A.R.T.", "Progress"],
            colModel: [
                        { name: "created_at", align: "center", width: 50, editoptions:{defaultValue: goalsOptions.defaultDate}, formatter:'date', formatoptions: { newformat:'Y-m-d'}, search: false},
                        { name: "type", width: 90, align: "center", editable:true, edittype:"select", editoptions:{value: goalsOptions.type_slt.join(";")},  formatter:'select', stype: 'select', searchoptions:{ sopt:['eq'], value: goalsOptions.type_search.join(";") }},
                        { name: "goal", width: 340, editable:true, formatter: "showlink", formatoptions:{baseLinkUrl:"/tasks/view"}, editrules: { required: true}, search: false },
                        { name: "priority", width: 60, align: "center", editable:true, search: false, edittype:"select", editoptions:{value: goalsOptions.priority_slt.join(";"), defaultValue: "C"}, search: false},
                        { name: "urgency", width: 60, align: "center", editable:true, search: false, edittype:"select", editoptions:{value:goalsOptions.urgency_slt.join(";"), defaultValue: "1"}, search: false },
                        { name: "deadline", align: 'center', sortable: true, editrules: { date: true}, formatoptions: {newformat: 'Y-m-d'}, search: false,
                                width: 70, editable: true, edittype: 'text', editoptions: {defaultValue:goalsOptions.defaultDate, dataInit: function (element) {
                                $(element).datepicker({
                                    autoclose: true,
                                    format: 'yyyy-mm-dd',
                                    todayBtn: 'linked',
                                    orientation: "auto"
                                });
                            }},
                        },
                        { name: "stage", width: 80, align: "center", editable:true, edittype:"select", editoptions:{value: goalsOptions.stage_slt.join(";")},  formatter:'select', search: false},
                        { name: "status", width: 80, align: "center", editable:true, edittype:"select", editoptions:{value: goalsOptions.status_slt.join(";")},  formatter:'select', stype: 'select', searchoptions:{ sopt:['eq'], value: goalsOptions.status_search.join(";") }},
                        {name: 'smart', width: 60, align: 'center', editable:true, formatter: 'checkbox', edittype: 'checkbox', editoptions: {value: '1:0', defaultValue: '0'}, search: false},
                        { name: "progress", width: 120, sortable: false, search: false}
                        ],
            pager: "#goals_pager",
            rowNum: 50,
            rowList: [],        // disable page size dropdown
            pgbuttons: true,     // disable page control like next, back button
            pgtext: null,         // disable pager text like 'Page 0 of 10'
            viewrecords: true,
            height: "100%",
            multiSort: true,
            /*sortname: "type, priority asc, urgency",*/
            sortname: "priority asc, urgency",
            sortorder: "asc",
            viewrecords: true,
            gridview: true,
            hidegrid: false,
            /*autowidth: true,*/
            width: outerwidth,
/*            shrinkToFit: true,*/
            autoencode: false,
            rownumbers: true,
            editurl: '/goals/edit',
            ondblClickRow: function (id) {
                $(this).jqGrid('editRow', id, true, null, null, '', '', function(){
                    $(this).trigger("reloadGrid");
                });
            },
            onSelectRow: function (id) {
                if (id && id !== goalsOptions.lastSel) {
                    if (typeof goalsOptions.lastSel !== "undefined") {
                        $(this).jqGrid('restoreRow', goalsOptions.lastSel);
                    }
                    goalsOptions.lastSel = id;
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

    $("#goals").jqGrid('navGrid', '#goals_pager', {add: false, edit: false, del: true, search: false, refresh: false});
    $("#goals").jqGrid('inlineNav', '#goals_pager', {addParams: {position: "last",addRowParams: editOptions},editParams: editOptions});
    $("#goals").jqGrid('filterToolbar');
    });
}();




