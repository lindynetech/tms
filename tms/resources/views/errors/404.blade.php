@extends('master.index')

@section('content')
<section class="content">
<div class="error-page">
  <h2 class="headline text-red"> 404</h2>
  <div class="error-content">
    @if (isset($message))
        {!!$message!!}
    @else
        <h3><i class="fa fa-warning text-red"></i> Oops! Page not found.</h3>
        <p>We could not find the page you were looking for. Meanwhile, you may <a href="{{url('/')}}">return to dashboard</a> or try using the search form. </p>
    @endif
  </div><!-- /.error-content -->
</div><!-- /.error-page -->
</section>
@stop
