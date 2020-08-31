@extends('master.grids')

@section('content')

<section class="content-header">
    <h1><i class="fa fa-list"></i> Habits <img src="assets/images/q.png" class="help-tooltip" id="habitstp"></h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/app')}}"><i class="fa fa-th-large"></i> Dashboard</a></li>
        <li class="active"><a href="/habits">Habits</a></li>
    </ol>
</section>
<div id="habitstpcontent" style="display: none;">
    <h5><b>Habits</b></h5>
    <ul>
        <li>You can create your own future by changing your behaviors</li>
        <li>Almost 95 percent of everything that you think, feel, do and achieve is the result of habit</li>
        <li>Successful people have "success habits" and unsuccessful people do not</li>
        <li>It takes about 21 days to form a habit pattern</li>
        <li>The key to becoming a great person, and living a great life, is for you to develop the habits of success that lead inevitably to your achieving everything that is possible for you</li>
    </ul>
    <p><b>9 habits of highly successful people, by B.Tracy</b></p>
    <ul>
        <li>Self-Discipline - the ability to make yourself do what you should do, when you should do it, whether you feel like it or not</li>
        <li>Become a Lifelong Optimist - You become what you think about most of the time</li>
        <li>Think About Your Goals - Develop a habit of setting goals and making plans for their accomplishment</li>
        <li>Set Your Goals Each Day</li>
        <li>Identify Key Professional Skills - Develop the habit of continually identifying and working on your weakest key skill</li>
        <li>Commit To Lifelong Learning</li>
        <li>What You See Is What You Will Be</li>
        <li>Be Around the Right People</li>
        <li>Take Initiative</li>
    </ul>
    <p>We highly recommend reading B.Tracy's book "The Power of Habit: 7 Steps to Successful Habits"</p>
    <p><b>Tip:</b> You can edit a row by double clicking on it and save by pressing Enter.</p>
</div>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
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
            <h4 class="box-title" id="habitName"></h4>
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
