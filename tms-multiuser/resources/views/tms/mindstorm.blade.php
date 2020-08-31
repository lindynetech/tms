@extends('master.grids')

@section('content')
<section class="content-header">
    <h1><i class="fa fa-lightbulb"></i> Mindstorming <img src="assets/images/q.png" class="help-tooltip" id="mindstormtp"></h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/app')}}"><i class="fa fa-th-large"></i> Dashboard</a></li>
        <li class="active">Mindstorming</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-body">
                    <table id="mindstorm"><tr><td></td></tr></table>
                    <div id="mindstorm_pager"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="mindstormtpcontent" style="display: none;">
    <p><b>Mindstorming</b></p>
    <ul>
        <li>Mindstorming is a great mental exercise to hone your problem solving skills</li>
        <li>Try to come up with at least 20 solutions to solve the problem or accomplish the goal</li>
        <li>First 10 will come easily, the rest will take hard work and perseverance</li>
    </ul>
    <p><b>Tip:</b> You can edit a row by double clicking on it and save by pressing Enter.</p>
</div>
@stop

@section('custom-grid')
    <script src="assets/tms/js/mindstorm.js"></script>
@stop
