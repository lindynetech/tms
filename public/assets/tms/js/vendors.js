(function(){
	var vendorsOptions = {
		lastSel: 0,
		defaultDate: $.datepicker.formatDate('yy-mm-dd', new Date()),
		status_slt: [ "Active:Active", "Inactive:Inactive"],
		role_slt: [ "Assignee:Assignee", "Vendor:Vendor"]
	};

    // CSRF Protection
    $.ajaxPrefilter(function(options, originalOptions, xhr) { // this will run before each request
        var token = $('meta[name="csrf-token"]').attr('content'); // or _token, whichever you are using

        if (token) {
            return xhr.setRequestHeader('X-CSRF-TOKEN', token); // adds directly to the XmlHttpRequest Object
        }
    });

	$(function () {
		$('#vendors').jqGrid({
			url: "/vendors/list",
            guiStyle: "bootstrap",
			datatype: "json",
			mtype: "GET",
			colNames: ["Added", "Name", "Role", "Status", "Contacts"],
			colModel: [
			{ name: "created_at", align: "center", width: 70, editoptions: { defaultValue: vendorsOptions.defaultDate }, search: false, formatter:'date', formatoptions: { newformat:'Y-m-d'}},
			{ name: "name", width: 100, editable:true, editrules: { required: true}, search: false },
			{ name: "role", width: 70, align: "center", editable:true, edittype:"select",
			editoptions:{value:vendorsOptions.role_slt.join(";"), defaultValue: "Assignee"},	formatter:'select', search: false},
			{ name: "status", width: 70, align: "center", editable:true, edittype:"select",
			editoptions:{value:vendorsOptions.status_slt.join(";"), defaultValue: "Active"},	formatter:'select', search: false},
			{ name: "contact", width: 300, align: "left", editable:true, search: false}
			],

			pager: "#vendors_pager",
			rowNum: 100,
			height: "100%",
			sortname: "id",
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

			editurl: "/vendors/edit",

			ondblClickRow: function (id) {
				$(this).jqGrid('editRow', id, true, null, null, '','',function() {
					$(this).trigger("reloadGrid");
				});
			},
			onSelectRow: function (id) {
				if (id && id !== vendorsOptions.lastSel) {
					if (typeof vendorsOptions.lastSel !== "undefined") {
						$(this).jqGrid('restoreRow', vendorsOptions.lastSel);
					}
					vendorsOptions.lastSel = id;
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

		$('#vendors').jqGrid('navGrid', '#vendors_pager', { add: false, edit: false, del: true, search: false, refresh: false});
		$('#vendors').jqGrid('inlineNav', '#vendors_pager', { addParams: {position: "last", addRowParams: editOptions}, editParams: editOptions });
		$('#vendors').jqGrid('filterToolbar');
	});

})();
