@extends('master.index')

@section('content')
<section class="content-header">
    <h1>Profile</h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-th-large"></i> Dashboard</a></li>
        <li class="active">Profile</li>
    </ol>
</section>

<section class="content">
@if (count($errors) > 0)
    <div class="row">
        <div class="col-xs-6">
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> The following errors have occured</h4>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

@if (session('message'))
    <div class="row">
        <div class="col-xs-6">
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success</h4>
                <p>{{ session('message') }}</p>
            </div>
        </div>
    </div>
@endif

<div class="row">
    <div class="col-xs-6">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Change profile</h3>
                <div class="alert alert-info alert-dismissible" style="margin-top: 10px;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <p><i class="icon fa fa-warning"></i><b>Email is used as username for authentication</b></p>
                </div>
            </div>
            <div class="box-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/profile/store') }}">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-6">
                        <input type="text" name="name" class="form-control" value="{{$profile['name']}}" placeholder="Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-6">
                        <input type="email" name="email" class="form-control" value="{{$profile['email']}}" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-danger">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-6">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Change password</h3>
            </div>
            <div class="box-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/profile/resetpass') }}">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="inputPassword" class="col-sm-2 control-label">New Password</label>
                        <div class="col-sm-6">
                        <input type="password" name="password" class="form-control" id="inputPassword" placeholder="New Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword2" class="col-sm-2 control-label">Confirm</label>
                        <div class="col-sm-6">
                        <input type="password" name="password_confirmation" class="form-control" id="inputPassword2" placeholder="Confirm Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-danger">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</section><!-- /.content -->
@stop
