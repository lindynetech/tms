!function(){
	var mindOptions = {
		lastSel: 0,
		status_slt: ["Not Started:Not Started",
		              "In Progress:In Progress",
		              "Complete:Complete"
		            ],
		status_search: [":Current",
		                 "Not Started:Not Started",
		                 "In Progress:In Progress",
		                 "Complete:Complete",
		                 "All:All"
		                ],
	};

    // CSRF Protection
    $.ajaxPrefilter(function(options, originalOptions, xhr) { // this will run before each request
        var token = $('meta[name="csrf-token"]').attr('content'); // or _token, whichever you are using

        if (token) {
            return xhr.setRequestHeader('X-CSRF-TOKEN', token); // adds directly to the XmlHttpRequest Object
        }
    });

	$(function () {
	    $("#mindstorm").jqGrid({
	        url: "/mindstorm/list",
            guiStyle: "bootstrap",
	        datatype: "json",
	        mtype: "GET",
	        colNames: ["Date", "Goal / Problem", "S.M.A.R.T.", "Status"],
	        colModel: [
	        { name: "created_at", align: "center", width: 70, search: false, formatter:'date', formatoptions: { newformat:'Y-m-d'}},
	        { name: "question", width: 290, editable:true, formatter: "showlink", formatoptions:{baseLinkUrl:"/mindstorm/listideas"}, search: false },
	        { name: 'smart', width: 80, align: 'center', editable:true, formatter: 'checkbox', edittype: 'checkbox', editoptions: {value: '1:0', defaultValue: '0'}, search: false},
	        { name: "status", width: 120, align: "center", editable:true, edittype:"select", editoptions:{value:mindOptions.status_slt.join(";")},  formatter:'select', stype: 'select', searchoptions:{ sopt:['eq'], value: mindOptions.status_search.join(";") }}
	        ],
	        pager: "#mindstorm_pager",
	        rowNum: 50,
	        rowList: [],        // disable page size dropdown
	        pgbuttons: true,     // disable page control like next, back button
	        pgtext: null,         // disable pager text like 'Page 0 of 10'
	        viewrecords: true,
			height: "100%",
	        multiSort:true,
	        sortname: "created_at asc, id",
	        sortorder: "asc",
	        viewrecords: true,
	        gridview: true,
	        hidegrid: false,
			autowidth: true,
	        autoencode: false,
			rownumbers: true,
	        editurl: "mindstorm/edit",

			ondblClickRow: function (id) {
		       	$(this).jqGrid('editRow', id, true, null, null, '', '', function(){
		       		$(this).trigger("reloadGrid");
		       	});
	        },
			onSelectRow: function (id) {
		        if (id && id !== mindOptions.lastSel) {
			        if (typeof mindOptions.lastSel !== "undefined") {
			        	$(this).jqGrid('restoreRow', mindOptions.lastSel);
			        }
			        mindOptions.lastSel = id;
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

	$("#mindstorm").jqGrid('navGrid', '#mindstorm_pager', {add: false, edit: false, del: true, search: false, refresh: false});
	$("#mindstorm").jqGrid('inlineNav', '#mindstorm_pager', {addParams: {position: "last",addRowParams: editOptions},editParams: editOptions});
	$("#mindstorm").jqGrid('filterToolbar');
	});

}();
