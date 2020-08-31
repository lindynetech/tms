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
            <div class="box">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-list"></i> Daily Goals</h3>
            </div>
                <div class="box-body">
                    <p><a id="flush" href="{{url('/')}}/dailygoals/flush">Start over</a></p>
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
            <div class="box">
            <div class="box-header" style="color: #FFF;background-color: #00a65a;">
                <h3 class="box-title"><i class="fa fa-frog"></i> Eat That Frog <i class="fa fa-arrow-right" style="padding: 0 10px;"></i> Goal #1</h3>
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
      <div class="box box-primary">
        <div class="box-header">
          <i class="fa fa-tasks"></i>
          <h3 class="box-title">To do today <small class="label label-danger"><i class="fa fa-clock-o"></i> <?php echo date('Y-m-d') ?></small></h3>
          <div class="box-tools pull-right" style="padding-top: 5px;">
            <a href="#" id="resetTodo">Reset</a>
          </div>
        </div>
        <div class="box-body">
            <ul class="todo-list" id="todoList"></ul>
        </div>
        <div class="box-footer clearfix no-border">
            <div class="col-sm-10">
            <input class="form-control" id="newtask" placeholder="New Task" type="text">
            </div>
            <button class="btn btn-default pull-right" id="addItem"><i class="fa fa-plus"></i> Add</button>
        </div>
      </div>
    </section>
    <!-- TodoList End -->
    <section class="col-lg-6">
      <!-- Eat Frog Tasks -->
      <div class="box box-primary">
        <div class="box-header">
            <i class="fa fa-tasks"></i>
            <h3 class="box-title">Uncompleted tasks of Goal #1</h3>
            <div class="box-tools pull-right" style="padding-top: 5px;">
                <a href="{{url('/')}}/goals/eatfrog">Goal Overview</a>
          </div>
        </div>
        <div class="box-body">
            @if (isset($frogMessage))
                {!!$frogMessage!!}
            @else
                <ul class="todo-list">
                    @foreach($frogTasks as $frogTask)
                    <li>
                        <span class="text">1</span>
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
    <div class="row">
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
            <p><i class="fa fa-question"></i></p>
          </div>
          <div class="icon">
            <i class="fa fa-question"></i>
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
@stop

@section('custom-scripts')
@include('grids.scripts')
@stop

@section('custom-grid')
<script src="/assets/tms/js/dailygoals.js"></script>
<script src="/assets/tms/js/singlegoal.js"></script>
<script src="/assets/tms/js/todolist.js"></script>
@stop
