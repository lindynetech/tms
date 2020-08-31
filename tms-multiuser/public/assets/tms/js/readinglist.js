(function(){

	var readingOptions = {
	    lastSel: 0,
	    defaultDate: $.datepicker.formatDate('yy-mm-dd', new Date()),
	    status_slt: [   "Pending:Pending",
	                    "Reading:Reading",
	                    "On_Hold:On_Hold",
	                    "Complete:Complete",
	                ],
	    status_search: [ ":Current",
	                     "Pending:Pending",
	                     "Reading:Reading",
	                     "On_Hold:On_Hold",
	                     "Complete:Complete",
	                     "All:All"
	                    ],
	    priority_slt: [ "A:A", "B:B", "C:C"]
	};

    // CSRF Protection
    $.ajaxPrefilter(function(options, originalOptions, xhr) { // this will run before each request
        var token = $('meta[name="csrf-token"]').attr('content'); // or _token, whichever you are using

        if (token) {
            return xhr.setRequestHeader('X-CSRF-TOKEN', token); // adds directly to the XmlHttpRequest Object
        }
    });

	$(function () {
		$("#readingList").jqGrid({
			url: "/readinglist/list",
			datatype: "json",
            guiStyle: "bootstrap",
			mtype: "GET",
			colNames: ["Added", "Title", "Category", "Priority", "Status"],
			colModel: [
			{ name: "created_at", align: "center", width: 80, formatter:'date', formatoptions: { newformat:'Y-m-d'}, search: false },
			{ name: "title", width: 350, editable: true, search: false, editrules: { required: true}, formatoptions:{}},
			{ name: "category", width: 150, align: "center", editable:true, search: false, editrules: { required: true}},
			{ name: "priority", width: 150, align: "center", editable:true, edittype:"select", editoptions:{value: readingOptions.priority_slt.join(";")}, search: false },
			{ name: "status", width: 150, align: "center", editable:true, edittype:"select", editoptions:{value: readingOptions.status_slt.join(";")}, formatter:'select', stype: 'select', searchoptions:{ sopt:['eq'], value: readingOptions.status_search.join(";")}}
			],
			pager: "#readingList_pager",
			rowNum: 50,
			rowList: [],
			pgbuttons: true,
			pgtext: null,
			viewrecords: true,
			height: '100%',
			sortname: "priority",
			sortorder: "asc",
			viewrecords: true,
			gridview: true,
			hidegrid: false,
			autowidth: true,
			autoencode: true,
			rownumbers: true,
			editurl: '/readinglist/edit',

			ondblClickRow: function (id) {
				$(this).jqGrid('editRow', id, true, null, null, '', '', function(){
					$(this).trigger("reloadGrid");
				});
			},
			onSelectRow: function (id) {
				if (id && id !== readingOptions.lastSel) {
					if (typeof readingOptions.lastSel !== "undefined") {
						$(this).jqGrid('restoreRow', readingOptions.lastSel);
					}
					readingOptions.lastSel = id;
				}
			},

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
	$("#readingList").jqGrid('navGrid', '#readingList_pager', {add: false, edit: false, del: true, search: false, refresh: false });
	$("#readingList").jqGrid('inlineNav', '#readingList_pager', {addParams: {position: "last", addRowParams: editOptions},editParams: editOptions});
	jQuery("#readingList").jqGrid('filterToolbar');
	});

})();
