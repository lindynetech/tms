@extends('master.index')

@section('content')
<section class="content-header">
    <h1>Support</h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/app')}}"><i class="fa fa-th-large"></i> Dashboard</a></li>
        <li class="active">Support</li>
    </ol>
</section>

<section class="content">
<div class="row">
    <div class="col-xs-6">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">Request Support</h3>
            </div>
            <div class="box-body">
                <p><b>Please email to <a href="mailto:lindynetech@gmail.com">lindynetech@gmail.com</a> to request a new feature or report bugs.</b></p>
            </div>
        </div>
    </div>
</div>
</section>
@stop
