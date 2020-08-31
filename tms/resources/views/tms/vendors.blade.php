@extends('master.grids')

@section('content')
<section class="content-header">
    <h1>Vendors</h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-th-large"></i> Dashboard</a></li>
        <li class="active">Vendors</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <table id="vendors"><tr><td></td></tr></table>
                    <div id="vendors_pager"></div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@section('custom-grid')
    <script src="assets/tms/js/vendors.js"></script>
@stop
