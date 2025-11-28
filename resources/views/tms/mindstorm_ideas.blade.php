@extends('master.grids')

@section('content')

<section class="content-header">
    <small><a href="{{url('/mindstorm')}}"><i class="fa fa-arrow-left"></i> <b>Back to Mindstorming</b></a></small>
    <ol class="breadcrumb">
        <li><a href="{{url('/app')}}"><i class="fa fa-th-large"></i> Dashboard</a></li>
        <li><a href="/mindstorm">Mindstorming</a></li>
        <li class="active">{{$question ?? 'Mindstorming'}}</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12" id="sgWrapper">
            <div class="box box-success collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-lightbulb"></i> {{$question ?? 'Mindstorming'}}</h3>
            </div>
                <div class="box-body">
                    <table id="singleGoal"><tr><td></td></tr></table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-body">
                    <table id="ideas"><tr><td></td></tr></table>
                    <div id="ideas_pager"></div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@section('custom-grid')
<script>
    !function(){
    var ideasOptions = {
        lastSel: 0,
        defaultDate: $.datepicker.formatDate('yy-mm-dd', new Date()),
        priority_slt: [ "A:A", "B:B", "C:C", "D:D" ],
        urgency_slt: [
        "1:1", "2:2", "3:3", "4:4", "5:5", "6:6", "7:7", "8:8", "9:9", "10:10", "11:11", "12:12", "13:13", "14:14", "15:15", "16:16", "17:17", "18:18", "19:19", "20:20"
        ]
    };

    // CSRF Protection
    $.ajaxPrefilter(function(options, originalOptions, xhr) { // this will run before each request
        var token = $('meta[name="csrf-token"]').attr('content'); // or _token, whichever you are using

        if (token) {
            return xhr.setRequestHeader('X-CSRF-TOKEN', token); // adds directly to the XmlHttpRequest Object
        }
    });

    $(function () {
        $("#ideas").jqGrid({
            url: "/mindstorm/listallideas/<?php echo $rid; ?>",
            datatype: "json",
            guiStyle: "bootstrap",
            mtype: "GET",
            colNames: ["Date", "Idea", "Priority", "Urgency"],
            colModel: [
                { name: "created_at", align: "center", width: 70, formatter:'date', formatoptions: { newformat:'Y-m-d'}},
                { name: "idea", width: 600, editable:true, editrules: { required: true} },
                { name: "priority", width: 80, align: "center", editable:true, search: false, edittype:"select", editoptions:{value: ideasOptions.priority_slt.join(";"), defaultValue: "A"}},
                { name: "urgency", width: 80, align: "center", editable:true, search: false, edittype:"select", editoptions:{value: ideasOptions.urgency_slt.join(";"), defaultValue: "1"}}
            ],
            pager: "#ideas_pager",
            rowNum: 100,
            height: "100%",
            multiSort:true,
            sortname: "priority asc, urgency",
            sortorder: "asc",
            rowList: [],
            pgbuttons: false,
            pgtext: null,
            viewrecords: true,
            gridview: true,
            hidegrid: false,
            autowidth: true,
            autoencode: false,
            rownumbers: true,
            caption: "",
            editurl: "/mindstorm/editideas/<?php echo $rid; ?>",

            ondblClickRow: function (id) {
                $(this).jqGrid('editRow', id, true, null, null, '', '', function() {
                    $(this).trigger("reloadGrid");
                });
            },
            onSelectRow: function (id) {
                if (id && id !== ideasOptions.lastSel) {
                    if (typeof ideasOptions.lastSel !== "undefined") {
                    $(this).jqGrid('restoreRow', ideasOptions.lastSel);
                    }
                    ideasOptions.lastSel = id;
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

    $("#ideas").jqGrid('navGrid', '#ideas_pager', {add: false, edit: false, del: true, search: false, refresh: false});
    $("#ideas").jqGrid('inlineNav', '#ideas_pager', {addParams: {position: "last",addRowParams: editOptions},editParams: editOptions});
    });
}();
</script>
@stop
