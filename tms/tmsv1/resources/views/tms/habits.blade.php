@extends('master.grids')

@section('content')

<section class="content-header">
    <h1>Habits</h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-th-large"></i> Dashboard</a></li>
        <li class="active"><a href="/habits">Habits</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <table id="habits"><tr><td></td></tr></table>
                    <div id="habits_pager"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div id="habit">
            <h3 class="box-title" id="habitName"></h3>
                <div align="left">
                    <span><a id="reset"><strong>Reset</strong></a></span>
                    <ul id="habitInfo"></ul>
                    <span id="saveResult"></span>
                </div>
                <div class="box-body no-padding">
                    <table id="habitsInterval" class="table table-striped"></table>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@section('custom-grid')
<script src="assets/tms/js/habits.js"></script>
@stop
