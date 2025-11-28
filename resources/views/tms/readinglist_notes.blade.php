@extends('master.grids')

@section('custom-assets')
<link rel="stylesheet" href="/assets/plugins/summernote/summernote.css">
@stop

@section('content')
<section class="content-header">
    <h1>{{$title}}</h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-th-large"></i> Dashboard</a></li>
        <li><a href="{{url('/readinglist')}}">Reading List</a></li>
    </ol>
</section>
<hr>
<section class="content">
    <section class="col-lg-4 connectedSortable">
      <div class="box box-primary">
        <div class="box-header">
          <i class="fa fa-book"></i>
          <h3 class="box-title">Notes</h3>
        </div>
        <div class="box-body">
            <ul class="todo-list" id="notes_list">
                @foreach($notes as $note)
                <li>
                <span class="text note_title" id="listtitle-{{$note->id}}"><a href="#">{{$note->title}}</a></span>
                <div class="text note_desc" style="display: none;">{{$note->description}}</div>
                <div class="tools" id="{{$note->id}}">
                <i class="fa fa-edit"></i>
                <i class="fa fa-trash-o"></i>
                </div>

                </li>
            @endforeach
            </ul>
        </div>
        <div class="box-footer clearfix no-border">
          <button class="btn btn-default pull-right" id="addNote"><i class="fa fa-plus"></i> Add Note</button>
        </div>
      </div>
    </section>
    <section class="col-lg-8 connectedSortable">
      <div class="box box-primary" id="notesEditor">
      <div class="box-header">
        <h3 class="box-title" id="noteTitle"></h3>
      </div>
        <div class="box-body">
            <div class="form-group">
                <input class="form-control" name="title" id="editTitle" placeholder="Note name" autocomplete="off">
            </div>
            <div class="form-group">
                <textarea id="viewnote" class="form-control"></textarea>
                <input name="mode" id="mode" type="hidden" value="editNote">
                <input name="nid" id="nid" type="hidden" value="">
                <input name="bid" id="bid" type="hidden" value="{{$bid}}" />
            </div>
        </div>
        <div class="box-footer clearfix no-border" id="editButtons">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
            <button type="reset" class="btn btn-default"><i class="fa fa-remove"></i> Cancel</button>
        </div>
      </div>
    </section>
</section>
@stop

@section('custom-grid')
<script src="/assets/plugins/summernote/summernote.min.js"></script>
<script src="/assets/tms/js/readinglist_notes.js"></script>
<script>
$(function () {
    $('#viewnote').summernote({
        height: 400
    });
});
</script>
@stop
