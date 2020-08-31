@extends('master.index')

@section('custom-assets')
@include('grids.assets')
<script type="text/javascript">
var goalId = <?php echo $frogId; ?>;
</script>
@stop

@section('content')
<!-- Content Section -->
<section class="content">
    <!-- Daily Goals -->
    <div class="row">
        <div class="col-xs-12" id="dailyWrapper">
            <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-list"></i> Daily Goals <img src="assets/images/q.png" class="help-tooltip" id="dailygoalstp"></h3>
            </div>
                <div class="box-body">
                    <p><a id="flush" href="{{url('/')}}/dailygoals/flush"><i class="fa fa-sync"></i> Start over</a></p>
                    <table id="goals_daily"><tr><td></td></tr></table>
                    <div id="goals_daily_pager"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Daily Goals End -->
    <!-- Frog Goal-->
    <div class="row">
        <div class="col-xs-12" id="sgWrapper">
            <div class="box box-success">
            <div class="box-header" style="color: #FFF;background-color: #00a65a;">
                <h3 class="box-title"><i class="fa fa-frog"></i> Eat That Frog <i class="fa fa-arrow-right" style="padding: 0 10px;"></i> Goal #1 <img src="assets/images/q.png" class="help-tooltip" id="eatthatfrogtp"></h3>
            </div>
                <div class="box-body">
                @if (isset($frogMessage))
                    <b>{!!$frogMessage!!}</b>
                @else
                    <table id="singleGoal"><tr><td></td></tr></table>
                @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Frog Goal End -->
    <!-- Grid Row -->
    <div class="row">
    <!-- TodoList -->
    <section class="col-lg-6">
      <div class="box box-success">
        <div class="box-header">
          <i class="fa fa-tasks"></i>
          <h3 class="box-title">To Do Today / Ad-hoc tasks <img src="assets/images/q.png" class="help-tooltip" id="todotp"></h3>
          <div class="box-tools pull-right" style="padding-top: 5px;">
            <a href="#" id="resetTodo"><i class="fa fa-sync"></i> Reset</a>
          </div>
        </div>
        <div class="box-body">
            <ul class="todo-list" id="todoList"></ul>
        </div>
        <div class="box-footer clearfix no-border">
            <div class="col-sm-10">
            <input class="form-control" id="newtask" placeholder="New Task" type="text">
            </div>
            <button class="btn btn-primary pull-right" id="addItem"><i class="fa fa-plus"></i> Add</button>
        </div>
      </div>
    </section>
    <!-- TodoList End -->
    <section class="col-lg-6">
      <!-- Eat Frog Tasks -->
      <div class="box box-success">
        <div class="box-header">
            <i class="fa fa-frog"></i>
            <h3 class="box-title">Uncompleted tasks of Goal #1 <img src="assets/images/q.png" class="help-tooltip" id="uncompletefrogtp"></h3>
            <div class="box-tools pull-right" style="padding-top: 5px;">
                <a href="{{url('/')}}/goals/eatfrog"><i class="fa fa-frog"></i> Goal Overview</a>
          </div>
        </div>
        <div class="box-body">
            @if (isset($frogMessage))
                {!!$frogMessage!!}
            @else
                <ul class="todo-list">
                    @foreach($frogTasks as $frogTask)
                    <li>
                        <span class="text">{{$loop->iteration}}.</span>
                        <span class="text">{{$frogTask->task}}</span>
                        <small class="label label-danger"><i class="fa fa-clock-o"></i> Due: {{$frogTask->deadline}}</small>
                    </li>
                    @endforeach
               </ul>
            @endif
        </div>
      </div>
      <!-- Eat Frog Tasks End -->

    </section>
    </div>
      <!-- Module Boxes -->
    <div class="row" style="padding-top: 20px;">
        <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3><a href="{{url('/')}}/goals">Goals</a></h3>
            <p><i class="fa fa-tasks"></i></p>
          </div>
          <div class="icon">
            <i class="fa fa-tasks"></i>
          </div>
          <a href="{{url('/')}}/goals" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
        </div>
        </div>
        <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-orange">
          <div class="inner">
            <h3><a href="{{url('/')}}/habits">Habits</a></h3>
            <p><i class="fa fa-list"></i></p>
          </div>
          <div class="icon">
            <i class="fa fa-list"></i>
          </div>
          <a href="{{url('/')}}/habits" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
        </div>
        </div>
        <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3><a href="{{url('/')}}/mindstorm">Mindstorming</a></h3>
            <p><i class="fa fa-lightbulb"></i></p>
          </div>
          <div class="icon">
            <i class="fa fa-lightbulb"></i>
          </div>
          <a href="{{url('/')}}/mindstorm" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
        </div>
        </div>
        <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red">
          <div class="inner">
            <h3><a href="{{url('/')}}/readinglist">Reading List</a></h3>
            <p><i class="fa fa-book"></i></p>
          </div>
          <div class="icon">
            <i class="fa fa-book"></i>
          </div>
          <a href="{{url('/')}}/readinglist" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
        </div>
        </div>
    </div>
    <!-- Module Boxes End -->
    <!-- Grid Row End -->
</section>
<!-- Content Section End -->
<!-- Tooltips -->
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
<div id="eatthatfrogtpcontent" style="display: none;">
  <p><b>Eat That Frog!</b></p>
    <ul>
      <li>To setup a frog goal choose the most important goal, set priority A and urgency 1</li>
      <li>Your frog is your biggest, most important task, the one you are most likely to procrastinate on if you dont do 
    something about it</li>
      <li>If you have to eat a live frog at all, it doesnt pay to sit and look at it for very long</li>
      <li>The key to reaching high levels of performance and productivity is to develop the lifelong habit of tackling your major task first thing each morning</li>
      <li style="color: #00a65a;font-weight: bold;">Start working on this goal right now!</li>
    </ul>
</div>
<div id="todotpcontent" style="display: none;">
    <p><b>Quick todo tasks for today</b></p>
    <ul>
      <li>Quick todo/Ad-hoc tasks</li>
      <li>Plan your day</li>
      <li>Set reminders</li>
    </ul>
</div>
<div id="uncompletefrogtpcontent" style="display: none;">
    <p><b>Complete these tasks today!</b></p>
    <p>You are most likely to procrastinate on these tasks if you dont do something about it</p>
    <p>Resist the temptation to clear up small things first - do this tasks right now, they are most important things you can do right now</p>
    <p>Feel overwhelmed? Slice and dice that tasks into smaller pieces</p>
</div>
@stop

@section('custom-scripts')
@include('grids.scripts')
@stop

@section('custom-grid')
<script src="/assets/tms/js/dailygoals.js"></script>
<script src="/assets/tms/js/singlegoal.js"></script>
<script src="/assets/tms/js/todolist.js"></script>
@stop
