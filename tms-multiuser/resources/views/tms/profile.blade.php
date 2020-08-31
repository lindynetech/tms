@extends('master.index')

@section('content')
<section class="content-header">
    <h1><i class="fa fa-user-cog"></i> My Account</h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/app')}}"><i class="fa fa-th-large"></i> Dashboard</a></li>
        <li class="active">My Account</li>
    </ol>
</section>

<section class="content">
@if (count($errors) > 0)
    <div class="row">
        <div class="col-xs-6">
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
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
                <p><i class="icon fa fa-check"></i> {{ session('message') }}</p>
            </div>
        </div>
    </div>
@endif

<div class="row">
    <div class="col-md-6">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-user"></i> Change profile</h3>
            </div>
            <div class="box-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/profile/store') }}">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="inputName" class="col-sm-3 control-label">Name</label>
                        <div class="col-sm-6">
                        <input type="text" name="name" class="form-control" value="{{$profile['name']}}" placeholder="Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="col-sm-3 control-label">Email/Username</label>
                        <div class="col-sm-6">
                        <input type="email" name="email" class="form-control" value="{{$profile['email']}}" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-10">
                        <button type="submit" class="btn btn-primary btn-xs"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-lock"></i> Change password</h3>
            </div>
            <div class="box-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/profile/resetpass') }}">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="inputPassword" class="col-sm-3 control-label">New Password</label>
                        <div class="col-sm-6">
                        <input type="password" name="password" class="form-control" id="inputPassword" placeholder="New Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword2" class="col-sm-3 control-label">Confirm Password</label>
                        <div class="col-sm-6">
                        <input type="password" name="password_confirmation" class="form-control" id="inputPassword2" placeholder="Confirm New Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-10">
                        <button type="submit" class="btn btn-primary btn-xs"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-dollar-sign"></i> Billing <img src="assets/images/q.png" class="help-tooltip" id="billingtp"></h3>
            </div>
            <div class="box-body">
                <table class="table table-striped table-bordered table-hover table-responsive">
                    <tr>
                        <td><b>Account Created</b></td><td>{{$account_created}}</td>
                    </tr>
                    <tr>
                        <td><b>Account Status</b></td><td>{{$payment_status}}</td>
                    </tr>
                    <tr>
                        <td><b>Trial Expires</b></td><td>{{$trial_expires}}</td>
                    </tr>
                    @if ($payment_status == 'Not Subscribed')
                    <tr>
                        <td align="middle">
                            <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
                            <input type="hidden" name="cmd" value="_s-xclick">
                            <input type="hidden" name="hosted_button_id" value="NZR29D8TZBWQE">
                            <table>
                            <tr><td><input type="hidden" name="on0" value=""></td></tr><tr><td><select name="os0">
                                <option value="Option 1">Option 1 : $4.99 USD - monthly</option>
                                <option value="Option 2">Option 2 : $49.99 USD - yearly</option>
                            </select> </td></tr>
                            </table>
                            <input type="hidden" name="currency_code" value="USD">
                            <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                            <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
                            </form>

                        </td>
                        <td></td>
                    </tr>
                    @endif
                    <!-- <tr>
                        <td align="middle"><button class="btn btn-primary">Subscribe $4.99/month</button></td>
                        <td></td>
                    </tr> -->
                    @if ($payment_status == 'Subscribed')
                    <tr>
                        <td align="middle"><button class="btn btn-danger">Unsubscribe</button></td>
                        <td></td>
                    </tr>
                    @endif                    
                </table>
            </div>
        </div>
    </div>
</div>
</section>
<div id="billingtpcontent" style="display: none;">
    <p><b>Billing</b></p>
    <p>Please consider subscribing after your free trial is expired after 31 days.</p>
    <p>Upon expiration of free trial there will be a button to subscribe.</p>
    <p>You can cancel your subscription at any time from this page as well.</p>
</div>
@stop
