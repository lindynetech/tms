@extends('master.grids')

@section('content')
<script type="text/javascript">
var goalId = <?php echo $gid; ?>;
</script>
<section class="content-header">
    <small><a href="{{url('/goals')}}"><b>Back to Goals</b></a></small>
    <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-th-large"></i> Dashboard</a></li>
        <li><a href="{{url('/goals')}}">Goals</a></li>
        <li class="active">Tasks</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12" id="sgWrapper">
            <div class="box box-success collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-pencil-square-o"></i> {{$goalName}}</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
            </div>
                <div class="box-body">
                    <table id="singleGoal"><tr><td></td></tr></table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12" id="tasksWrapper">
            <div class="box">
                <div class="box-body">
                    <table id="tasks"><tr><td></td></tr></table>
                    <div id="tsk_pager"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Guide</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
                <ul>
                    <li>Review Goal</li>
                    <li>List Tasks / Objectives to complete</li>
                    <li>Set Priorities, Start and Deadline Dates</li>
                    <li>Execute tasks</li>
                </ul>
            </div>
          </div>
        </div>
      </div>
</section>
@stop

@section('custom-grid')
<script src="/assets/tms/js/singlegoal.js"></script>

<script type="text/javascript">
var tasksOptions = {
    lastSel: 0,
    today: new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate(), 0, 0, 0, 0),
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
    priority_slt: [ "A:A", "B:B", "C:C", "D:D" ],
    urgency_slt: [ "1:1", "2:2", "3:3", "4:4", "5:5", "6:6", "7:7", "8:8", "9:9", "10:10"],
    assign_slt: "<?php echo $vendors_list; ?>"
};

// CSRF Protection
$.ajaxPrefilter(function(options, originalOptions, xhr) { // this will run before each request
    var token = $('meta[name="csrf-token"]').attr('content'); // or _token, whichever you are using

    if (token) {
        return xhr.setRequestHeader('X-CSRF-TOKEN', token); // adds directly to the XmlHttpRequest Object
    }
});

outerwidth = $("#tasksWrapper").width() - 30;

$(function () {
$("#tasks").jqGrid({
    url: "/tasks/list/<?php echo $gid; ?>",
    datatype: "json",
    guiStyle: "bootstrap",
/*    iconSet: "fontAwesome",*/
    mtype: "GET",
    colNames: ["Date", "Task", "Type", "Priority", "Urgency", "Start", "Deadline", "Assigned To", "Status"],
    colModel: [
        { name: "created_at", align: "center", width: 70, editoptions:{defaultValue: tasksOptions.defaultDate}, formatter:'date', formatoptions: { newformat:'Y-m-d'}, search: false},
        { name: "task", width: 290, editable:true, editrules: {required: true}, search: false },
        { name: "type", width: 80, align: "center", editable:true, edittype:"select", editoptions:{value:"Task:Task;Objective:Objective"}, search: false},
        { name: "priority", width: 80, align: "center", editable:true, search: false, edittype:"select", editoptions:{value: tasksOptions.priority_slt.join(";"), defaultValue: "C"}, search: false },
        { name: "urgency", width: 80, align: "center", editable:true, search: false, edittype:"select", editoptions:{value: tasksOptions.urgency_slt.join(";"), defaultValue: "1"}, search: false },
        { name: "start", align: 'center', sortable: true, editrules: { date: true}, formatoptions: {newformat: 'Y-m-d'}, search: false, width: 70, editable: true, edittype: 'text', editoptions: {defaultValue:tasksOptions.defaultDate, dataInit: function (element) { $(element).datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                todayBtn: 'linked',
                orientation: "bottom",
                startDate: tasksOptions.today
            });
        }}
        },
        { name: "deadline", align: 'center', sortable: true, editrules: { date: true}, formatoptions: {newformat: 'Y-m-d'}, search: false, width: 70, editable: true, edittype: 'text', editoptions: {defaultValue:tasksOptions.defaultDate, dataInit: function (element) { $(element).datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                todayBtn: 'linked',
                orientation: "bottom",
                startDate: tasksOptions.today
            });
        }}
        },
        { name: "vid", width: 80, align: "center", editable:true, search: false, edittype:"select", editoptions:{value: tasksOptions.assign_slt}, search: false },
        { name: "status", width: 120, align: "center", editable:true, edittype:"select", editoptions:{value: tasksOptions.status_slt.join(";") },
        formatter:'select', stype: 'select', searchoptions:{ sopt:['eq'], value: tasksOptions.status_search.join(";") }}
    ],

    pager: "#tsk_pager",
    rowNum: 50,
    height: "100%",
    multiSort:false,
    sortname: "priority asc, urgency",
    sortorder: "asc",
    rowList: [],
    pgbuttons: true,
    pgtext: null,
    viewrecords: true,
    gridview: true,
    hidegrid: false,
    width: outerwidth,
    /*autowidth: true,*/
    autoencode: false,
    rownumbers: true,
    editurl: "/tasks/edit/<?php echo $gid; ?>",

    ondblClickRow: function (id) {
    $(this).jqGrid('editRow', id, true, null, null, '', '', reloadgr);
    },
    onSelectRow: function (id) {
    if (id && id !== tasksOptions.lastSel) {
      if (typeof tasksOptions.lastSel !== "undefined") {
        $(this).jqGrid('restoreRow', tasksOptions.lastSel);
      }
      tasksOptions.lastSel = id;
    }
    },
    onCellSelect: function(rowid, iCol) {
      //alert(iCol);
    },

    subGrid: true,
    subGridRowExpanded: function(subgrid_id, row_id) {

    var subgrid_table_id, pager_id;
    subgrid_table_id = subgrid_id+"_t";
    pager_id = "p_"+subgrid_table_id;
    $("#"+subgrid_id).html("<table id='"+subgrid_table_id+"' class='scroll'></table><div id='"+pager_id+"' class='scroll'></div>");
    jQuery("#"+subgrid_table_id).jqGrid({
        url:"/subtasks/list/"+row_id,
        datatype: "json",
        guiStyle: "bootstrap",
        /*iconSet: "fontAwesome",*/
        mtype: "GET",
        colNames: ["Date", "Task", "Priority", "Urgency", "Start", "Deadline", "Status"],
        colModel: [
            { name: "created_at", align: "center", width: 100, editoptions:{defaultValue: tasksOptions.defaultDate}, formatter:'date', formatoptions: { newformat:'Y-m-d'}},
            { name: "subtask", width: 500, editable:true, editrules: {required: true} },
            { name: "priority", width: 100, align: "center", editable:true, search: false, edittype:"select", editoptions:{value: tasksOptions.priority_slt.join(";"), defaultValue: "A"} },
            { name: "urgency", width: 100, align: "center", editable:true, search: false, edittype:"select", editoptions:{value: tasksOptions.urgency_slt.join(";"), defaultValue: "1"} },
            { name: "start", align: 'center', sortable: true, editrules: { date: true}, formatoptions: {newformat: 'Y-m-d'}, search: false, width: 100, editable: true, edittype: 'text', editoptions: {defaultValue:tasksOptions.defaultDate, dataInit: function (element) { $(element).datepicker({
                    autoclose: true,
                    format: 'yyyy-mm-dd',
                    todayBtn: 'linked',
                    orientation: "bottom",
                    startDate: tasksOptions.today
                });
            }}
            },
            { name: "deadline", align: 'center', sortable: true, editrules: { date: true}, formatoptions: {newformat: 'Y-m-d'}, search: false, width: 100, editable: true, edittype: 'text', editoptions: {defaultValue:tasksOptions.defaultDate, dataInit: function (element) { $(element).datepicker({
                    autoclose: true,
                    format: 'yyyy-mm-dd',
                    todayBtn: 'linked',
                    orientation: "bottom",
                    startDate: tasksOptions.today,
                });
            }}
            },
            { name: "status", width: 120, align: "center", editable:true, edittype:"select", editoptions:{value: tasksOptions.status_slt.join(";")}, formatter:'select'}
        ],
        rowNum:100,
        pager: pager_id,
        multiSort:true,
        sortname: "priority asc, urgency",
        sortorder: "asc",
        height: '100%',
        rowList: [],        // disable page size dropdown
        pgbuttons: false,     // disable page control like next, back button
        pgtext: null,         // disable pager text like 'Page 0 of 10'
        viewrecords: false,
        idPrefix: "t",
        editurl: "/subtasks/edit/"+row_id,
        ondblClickRow: function (id) {
          $(this).jqGrid('editRow', id, true, null, null, '', '', function(){
              var grid = $("#" + subgrid_table_id);
              $(grid).trigger("reloadGrid");
          });
        },
        loadComplete: function() {
          var grid = $("#"+subgrid_table_id);
          var ids = jQuery(grid).jqGrid('getDataIDs');
          for (var i = 0; i < ids.length; i++) {
            var rowId = ids[i];
            var rowData = jQuery(grid).jqGrid ('getRowData', rowId);
            var task_status = rowData.status;
            if(task_status == 'Complete')
            {
                $("#"+rowId).css("background", "#00c0ef");
            }
          }
        }
    });
    var editsubOptions = {
      keys: true,
        successfunc: function () {
          var $self = $(this);
          setTimeout(function () {
              $self.trigger("reloadGrid");
          }, 50);
      }
    };

    jQuery("#"+subgrid_table_id).jqGrid('navGrid',"#"+pager_id,{edit:false,add:false,del:true, search: false, refresh:false});
    jQuery("#"+subgrid_table_id).jqGrid('inlineNav', "#"+pager_id, {addParams: {position: "last",addRowParams: editsubOptions},editParams: editsubOptions});
    },

    loadComplete: function() {
    var grid = $("#tasks");
    var ids = jQuery(grid).jqGrid('getDataIDs');
    for (var i = 0; i < ids.length; i++) {
      var rowId = ids[i];
      var rowData = jQuery(grid).jqGrid ('getRowData', rowId);
      var task_type = rowData.type;
        var task_status = rowData.status;
        if(task_type == 'Task')
        {
            $("#"+rowId+" td.sgcollapsed",grid[0]).unbind('click').html('');
        }
        if(task_status == 'Complete')
        {
            $("#"+rowId).css("background", "#00c0ef");
        }
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

$("#tasks").jqGrid('navGrid', '#tsk_pager', {add: false, edit: false, del: true, search: false, refresh: false});
$("#tasks").jqGrid('inlineNav', '#tsk_pager', {addParams: {position: "last", addRowParams: editOptions}, editParams: editOptions});
$("#tasks").jqGrid('filterToolbar');
});

function reloadgr(rowid, result) {
  $("#tasks").trigger("reloadGrid");
};
</script>
@stop
