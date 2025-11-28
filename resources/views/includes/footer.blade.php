<footer class="main-footer hidden-xs">
    <div class="pull-right">
    <small>{!!config('tms.copyright')!!}</small>
    </div>
    <small>
    {{config('tms.title')}} | Version {{config('tms.version')}} | <a href="https://github.com/lindynetech/tms" target="_blank" title="View on GitHub"><i class="fab fa-github"></i></a> | <a href="{{ url('/')}}"><i class="fa fa-home"></i> Home</a> | <a href="{{ url('/#contacts')}}"><i class="fa fa-envelope"></i> Support</a> | <a href="{{ url('/logout')}}"><i class="fa fa-sign-out-alt"></i> Logout</a></small>
</footer>
