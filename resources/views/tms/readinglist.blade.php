@extends('master.grids')

@section('content')
<section class="content-header">
    <h1><i class="fa fa-book"></i> Reading List <img src="assets/images/q.png" class="help-tooltip" id="readinglisttp"></h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/app')}}"><i class="fa fa-th-large"></i> Dashboard</a></li>
        <li class="active">Reading List</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-body">
                    <table id="readingList"><tr><td></td></tr></table>
                    <div id="readingList_pager"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="notesSection" style="display: none;">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-sticky-note-o"></i> <span id="bookTitle"></span> - Notes</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" id="closeNotes"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div id="notesContent">
                        <p class="text-center text-muted">Loading notes...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="readinglisttpcontent" style="display: none;">
    <p><b>Reading List</b></p>
    <ul>
        <li>Continuous learning is the minimum requirement for success in any field</li>
        <li>Learn more to earn more</li>
        <li>Become the most educated person in your profession by listening audiobooks while driving, leverage coffee
        breaks, lunch time, flying etc</li>
        <li>Attend professional conferences, pursue certifications in your field</li>
        <li>Use gifts of time to educate yourself</li>
        <li>Add every book that you read, audiobook that you listened or conference you attended in this table.</li>
        <li>As time progresses you will be astonished by the size of the list and amount of knowledge you gained.</li>
    </ul>
    <p><b>Tip:</b> You can edit a row by double clicking on it and save by pressing Enter.</p>
</div>
@stop

@section('custom-grid')
    <style>
        #notesSection .todo-list > li {
            padding: 15px;
            border-bottom: 1px solid #f4f4f4;
            position: relative;
        }
        #notesSection .todo-list > li:last-child {
            border-bottom: none;
        }
        #notesSection .note_title a {
            font-weight: 600;
            color: #3c8dbc;
            font-size: 15px;
            text-decoration: none;
        }
        #notesSection .note_title a:hover {
            color: #2a6496;
            text-decoration: underline;
        }
        #notesSection .note_title a:before {
            content: "\f0da";
            font-family: 'FontAwesome';
            margin-right: 8px;
            color: #999;
        }
        #notesSection .note_desc {
            display: none;
            margin-top: 10px;
            padding: 10px 15px;
            background-color: #f9f9f9;
            border-left: 3px solid #3c8dbc;
            color: #666;
            font-size: 13px;
        }
        #notesSection .tools {
            display: none;
        }
        #notesContent a.btn {
            color: #fff;
        }
    </style>
    <script src="/assets/tms/js/readinglist.js?v={{ time() }}"></script>
@stop
