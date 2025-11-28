@extends('master.grids')

@section('content')
<section class="content-header">
    <h1><i class="fa fa-barcode"></i> Vendors <img src="assets/images/q.png" class="help-tooltip" id="vendorstp"></h1>
    @if (session('vendorStatus'))
    <br>
            <p class="alert alert-danger"><small><i class="fa fa-danger"></i> {{ session('vendorStatus') }} </small></p>
        @endif
    <ol class="breadcrumb">
        <li><a href="{{url('/app')}}"><i class="fa fa-th-large"></i> Dashboard</a></li>
        <li class="active">Vendors</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-body">
                    <table id="vendors"><tr><td></td></tr></table>
                    <div id="vendors_pager"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="vendorstpcontent" style="display: none;">
    <p><b>Vendors</b></p>
    <p>Vendors allow you to delegate your tasks to other people or companies.</p>
    <p>One vendor (you) has been setup for you automatically, don't delete it.</p>
    <p>Before deleting any vendors please reassign all the tasks asssigned to them.</p>
    <p><b>Tip:</b> You can edit a row by double clicking on it and save by pressing Enter or cancel with Esc.</p>
</div>
@stop

@section('custom-grid')
    <script src="assets/tms/js/vendors.js"></script>
@stop
