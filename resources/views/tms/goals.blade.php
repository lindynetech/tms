@extends('master.grids')

@section('content')
<section class="content-header">
    <h1><i class="fa fa-tasks"></i> Goals <img src="assets/images/q.png" class="help-tooltip" id="goalstp"></h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/app')}}"><i class="fa fa-th-large"></i> Dashboard</a></li>
        <li class="active">Goals</li>
    </ol>
</section>
<div id="goalstpcontent" style="display: none;">
    <h5><b>Goals</b></h5>
    <p><b><b>The ability to set goals and to create tasks for their accomplishment is the master skill of success</b></b></p>
    <p><b>3 Types of Goals</b></p>
    <hr>
    <ul>
       <li><b>Why Goals - Personal and Family Goals</b> - Reasons why you alive, what you want to accomplish for yourself and your family</li>
       <li><b>What Goals - Business, Career, Financial, Material Goals</b> - What is it that you want to accomplish in the exterior world</li>
       <li><b>How Goals - Self-Development Goals</b> - Your ability, your willingness in developing yourself is the key in accomplishing everything else, your personal and professional growth goals</li>
     </ul>
     <p><b>How to set goals</b></p>
     <hr>
     <ul>
        <li>Make your goals S.M.A.R.T</li>
        <li>Write them in present tense as if you already accomplished them</li>
        <li>Express goals in the positive, present tense, and begin with the word "I"</li>
        <ul>
            <li>"I earn 100K a year by the end of 2021"</li>
        </ul>
        <li>Goals written and stated in this way activate the Laws of Expectation and Attraction</li>
        <li>Deadline(E) - <b>E</b>stimated Deadline</li>
        <li>You can type dates manually in format YYYY-MM-DD</li>
        <li>Click on the year in datepicker to switch between months or years quicker</li>
      </ul>

    <p><b>Tip:</b> You can edit a row by double clicking on it and save by pressing Enter.</p>
</div>

<section class="content">
    <div class="row">
        <div class="col-xs-12" id="goalsWrapper">
            <div class="box box-success">
                <div class="box-body box-jqrid-custom">
                    <table id="goals"><tr><td></td></tr></table>
                    <div id="goals_pager"></div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@section('custom-grid')
    <script src="/assets/tms/js/goals.js"></script>
@stop
