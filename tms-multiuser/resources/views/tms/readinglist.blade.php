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
    <script src="/assets/tms/js/readinglist.js"></script>
@stop
