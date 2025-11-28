@extends('master.grids')

@section('content')
<section class="content-header">
    <h1><i class="fa fa-tasks"></i> Daily Goals <img src="assets/images/q.png" class="help-tooltip" id="dailygoalstp"></h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/app')}}"><i class="fa fa-th-large"></i> Dashboard</a></li>
        <li class="active">Daily Goals</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12" id="dailyWrapper">
            <div class="box box-success">
                <div class="box-body">
                    <p><a id="flush" href="{{url('/')}}/dailygoals/flush"><i class="fa fa-sync"></i> Start over</a></p>
                    <table id="goals_daily"><tr><td></td></tr></table>
                    <div id="goals_daily_pager"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="dailygoalstpcontent" style="display: none;">
    <p><b>Daily Goals</b></p>
    <p>Develop a habit of setting your goals daily</p>
    <p>Write down your top 10 goals in the present tense, as though you have already achieved them</p>
    <p>The more specific you can be in terms of what you want and when you want to achieve it, expressed in the positive, 
        present tense, and beginning with the word “I,” the more powerful the effect will be on your subconscious mind</p>
    <p>Goals written and stated in this way activate the Laws of Expectation and Attraction</p> 
    <p>Positive, personal, present tense goals, written down repeatedly each day, activate your subconscious and 
        superconscious minds and step on the accelerator of your own potential</p>       
    <p><b>Tip:</b> You can edit a row by double clicking on it and save by pressing Enter.</p>

</div>
@stop

@section('custom-grid')
    <script src="/assets/tms/js/dailygoals.js"></script>
@stop
