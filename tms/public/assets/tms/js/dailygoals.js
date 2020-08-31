!function(){
    var goalsOptions = {
        lastSel: 0,
        defaultDate: $.datepicker.formatDate('yy-mm-dd', new Date()),
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

    dgwidth = $("#dailyWrapper").width() - 30;

    $(function() {

        $('#flush').on('click', function(event) {
            $.get("/dailygoals/flush", function() {
                $('#goals_daily').jqGrid('clearGridData');
            });
            event.preventDefault();
        });
        $("#goals_daily").jqGrid({
            url: "/dailygoals/list",
            datatype: "json",
            guiStyle: "bootstrap",
            mtype: "GET",
            colNames: ["Type", "Goal", "Priority", "Urgency", "Deadline"],
            colModel: [
                    { name: "type", width: 90, align: "center", editable:true, edittype:"select", editoptions:{value: goalsOptions.type_slt.join(";")}},
                    { name: "goal", width: 410, align: "left", editable:true},
                    { name: "priority", width: 70, align: "center", editable:true, edittype:"select", editoptions:{value:goalsOptions.priority_slt.join(";"), defaultValue: "A"}},
                    { name: "urgency", width: 70, align: "center", editable:true, edittype:"select", editoptions:{value:goalsOptions.urgency_slt.join(";"), defaultValue: "1"} },
                    { name: "deadline", align: 'center', sortable: true, editrules: { date: true}, formatoptions: {newformat: 'Y-m-d'}, search: false, width: 70, editable: true, edittype: 'text', editoptions: {defaultValue:goalsOptions.defaultDate, dataInit: function (element) {
                            $(element).datepicker({
                                autoclose: true,
                                format: 'yyyy-mm-dd',
                                todayBtn: 'linked',
                                orientation: "bottom"
                            });
                        }},
                    },
                    ],
            pager: "#goals_daily_pager",
            rowNum: 100,
            rowList: [],
            pgbuttons: false,
            pgtext: null,
            viewrecords: true,
            height: "100%",
            multiSort: true,
            sortname: "priority asc, urgency",
            sortorder: "asc",
            viewrecords: true,
            gridview: true,
            hidegrid: false,
            width: dgwidth,
            autoencode: false,
            rownumbers: true,
            editurl: '/dailygoals/edit',

            ondblClickRow: function (id,iRow) {
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

    $("#goals_daily").jqGrid('navGrid', '#goals_daily_pager', {add: false, edit: false, del: true, search: false, refresh:false});
    $("#goals_daily").jqGrid('inlineNav', '#goals_daily_pager', {addParams: {position: "last",addRowParams: editOptions},editParams: editOptions});
    });

}();
