$(document).ready(function() {

	$('select').change(function() {
	   $(this).closest('form').find('#submit').click();
	});	

	$('#submit').click(function () {		
		var settheme = $("#settheme").val();
		var setfont = $("#setfont").val();
		var setsize = $("#setsize").val();
		var pass = $("#pass").val();

		if (pass == '' && !$("#pass").prop('disabled') ) {
			$("#pass").addClass('ui-state-highlight');
			return false;
		} else {
			$("#pass").removeClass('ui-state-highlight');
		}

		if ($("#pass").prop('disabled')) {
			pass = '';
		}

		var data = {
			settheme: settheme,
			setfont: setfont,
			setsize: setsize,
			pass: pass
		};
				
		$.ajax({
			url: "index.php?module=settings&action=update",	
			type: "POST",
			data: data,		
			cache: false,
			async: true	
		})
		.done(function(data){
			window.location.reload(true);
			$("#svd").text("Saved!");
			$("#checkEn").prop("checked", false);
			$("#pass").prop("disabled", true);
		});
		return false;
	});

	$('#checkEn').on('click', function () {
	   $('#pass').prop("disabled",!$('#pass').prop("disabled"));
	   $("#pass").removeClass('ui-state-highlight');
	});	

});	//ready