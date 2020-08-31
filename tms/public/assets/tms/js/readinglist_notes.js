$(document).ready(function() {

    // CSRF Protection
    $.ajaxPrefilter(function(options, originalOptions, xhr) { // this will run before each request
        var token = $('meta[name="csrf-token"]').attr('content'); // or _token, whichever you are using

        if (token) {
            return xhr.setRequestHeader('X-CSRF-TOKEN', token); // adds directly to the XmlHttpRequest Object
        }
    });

    resetEditor();

    /*View*/
    $('#notes_list').on('click', '.note_title a', function(){
        resetEditor();
        $('#notesEditor').show();
        var title = $(this).text();
        var desc = $(this).parent().next('.note_desc').text();

        //$(this).parent().next().next('.tools').show();
        $('#noteTitle').show();
        $('#noteTitle').text(title);
        $('#viewnote').summernote('code', desc);
        $('#viewnote').summernote('disable');

    });

    /*Cancel*/
    $('#editButtons :reset').on('click', function(){
        resetEditor();
        $('#addNote').prop("disabled", false);
    });

    /*Delete*/
    $('#notes_list').on('click', '.fa + .fa-trash-o', function(){
        if (confirm("Delete this note?")) {
            var nid = $(this).closest('div').attr('id');
            var list_item = $(this).closest('li');
            if(nid !== 'undefined' && !isNaN(parseInt(nid))) {
                var data = {
                    nid: nid,
                    mode: 'deleteNote'
                };

                $.post("/readinglist/editnotes", data)
                .done(function(r) {
                    list_item.remove();
                    resetEditor();
                });
            }
        }
    });

    /*Edit*/
    $('#notes_list').on('click', '.fa-edit', function(){
        var nid = $(this).closest('div').attr('id');
        var title = $(this).parent().prevAll('.note_title').text();
        var desc = $(this).parent().prev('.note_desc').text();
        if(nid !== 'undefined' && !isNaN(parseInt(nid))) {
            $('#notesEditor').show();
            $('#viewnote').summernote('enable');
            $('#noteTitle').text('Edit note');
            $('#editTitle').show();
            $('#editTitle').val(title);
            $('#editButtons').show();
            $('#viewnote').summernote('code', desc);
            $("#nid").val(nid);
            $("#mode").val('editNote');
            $('#addNote').prop("disabled", true);
        }
    });

    /*Add*/
    $('#addNote').click(function() {
        $('#viewnote').summernote('enable');
        $('#viewnote').summernote('reset');

        $('#notesEditor').show();
        $('#editButtons').show();
        $('#noteTitle').text('Add note');
        $('#editTitle').show();
        $('#editTitle').val('');

        $("#mode").val('addNote');
        $('#addNote').prop("disabled", true);

    });

    /*Save*/
    $('#editButtons :submit').click(function (e) {
        e.preventDefault();

        var mode = $('#mode').val();
        var title = $('#editTitle');
        var desc = $('#viewnote').summernote('code');
        var bid = $('#bid').val();
        var nid = $('#nid').val();


        if (title.val()=='') {
            title.css('border', '1px solid red');
            return false;
        } else {
            title.css('border', '1px solid #3c8dbc');
        }

        if ($('#viewnote').summernote('isEmpty')) {
            alert("Please add some notes!");
            return false;
        }

        var data = {
            mode: mode,
            note: title.val(),
            description: desc,
            bid: bid,
            nid: nid
        };

        $.ajax({
            url: "/readinglist/editnotes",
            type: "POST",
            data: data,
            cache: false
        })
        .done(function(r){
            window.location.reload();
            /*if(mode === 'addNote') {
                resetEditor();

                var noteId = parseInt(r);
                var lid = "listtitle-"
                var content = '<span class="text note_title" id="' + lid +noteId + '"><a href="#">' + title.val() + '</a></span>';

                content += '<div class="text note_desc" style="display: none;">' + desc + '</div>';
                content += '<div class="tools" id="' + noteId + '">';
                content += '<i class="fa fa-edit"></i><i class="fa fa-trash-o"></i></div>';

                $('#notes_list').append('<li>' + content + '</li>');

            } else if(mode === 'editNote') {
                var noteTitle = $('#listtitle-' + nid).children();
                noteTitle.text(title.val());

                var noteDesc = $('#listtitle-' + nid).next();
                noteDesc.html(desc);
            }
        });
        return false;*/
        });
    });

    function resetEditor() {
        $('#notesEditor').hide();
        $('#viewnote').summernote('reset');
        $('#viewnote').summernote('disable');
        $('#editButtons').hide();
        $('#editTitle').hide();
        $('#addNote').prop("disabled", false);
    }

});	//ready
