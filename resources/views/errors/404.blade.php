@extends('master.index')

@section('content')

<section class="content">
	<div class="row">
	    <div class="col-md-8 col-md-offset-2">
	        <div class="box box-success">
	            <div class="box-header">
	                <h3 class="box-title"><i class="fa fa-minus-circle"></i> Page Not Found</h3>
	            </div>
	            <div class="box-body">
	                <div class="error-content">
	                    @if (isset($message))
	                        {!!$message!!}
	                    @else
	                    <h2 class="headline text-red"> 404</h2>
	                    <p><a href="{{url('/app')}}">Return to Dashboard</a></p>
	                    @endif
                  	</div>
                </div>
	        </div>
        </div>
    </div>  
</section>


@stop
