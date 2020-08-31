@extends('master.grids')

@section('content')
<section class="content-header">
    <h1>Daily Goals</h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-th-large"></i> Dashboard</a></li>
        <li class="active">Daily Goals</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12" id="dailyWrapper">
            <div class="box">
                <div class="box-body">
                    <p><a id="flush" href="{{url('/')}}/dailygoals/flush">Start over</a></p>
                    <table id="goals_daily"><tr><td></td></tr></table>
                    <div id="goals_daily_pager"></div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@section('custom-grid')
    <script src="/assets/tms/js/dailygoals.js"></script>
@stop
