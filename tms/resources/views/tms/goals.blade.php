@extends('master.grids')

@section('content')
<section class="content-header">
    <h1>Goals</h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-th-large"></i> Dashboard</a></li>
        <li class="active">Goals</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12" id="goalsWrapper">
            <div class="box">
                <div class="box-body box-jqrid-custom">
                    <table id="goals"><tr><td></td></tr></table>
                    <div id="goals_pager"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- /.col -->
        <div class="col-md-6">
          <div class="box box-success collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title">Types of Goals</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
                <ul>
                    <li>What Goals - Business, Career and Financial Goals </li>
                    <li>How Goals - Personal and Professional Growth, Self-Development Goals</li>
                    <li>Why Goals - Personal, Family and Health Goals</li>
                </ul>
            </div>
          </div>
        </div>
      </div>
</section>
@stop

@section('custom-grid')
    <script src="/assets/tms/js/goals.js"></script>
@stop
