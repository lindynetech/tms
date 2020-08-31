<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.headlanding')
    <title>Reset Password | {{ config('tms.title') }}</title>
</head>
<body class="overflow-scroll">
  <div id="home" class="header-section half-header section gradiant-background header-flat header-software">
    <div id="navigation" class="navigation is-transparent" data-spy="affix" data-offset-top="5">
      <nav class="navbar navbar-default">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#site-collapse-nav" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand hidden-xs" href="{{ url('/') }}">
              <img class="logo logo-light" src="/landing/images/logo-white.png" alt="{{ config('tms.title')}}" />
              <img class="logo logo-color" src="/landing/images/logo.png" alt="{{ config('tms.title')}}" />
            </a>
          </div>
          <div class="collapse navbar-collapse font-secondary" id="site-collapse-nav">
            <ul class="nav nav-list navbar-nav navbar-right">
              <li><a class="nav-item" href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
              <li><a class="nav-item" href="{{ url('/') }}"><i class="fa fa-user"></i> Register</a></li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
    
    <div class="header-content">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-md-offset-4">
            <div class="contact-form white-bg text-center" style="margin-top: 40px;">
              <h3><i class="fa fa-btn fa-envelope"></i> Reset your password</h3>
              @if (session('status'))
                  <p class="loginwarning">{{ session('status') }}</p>
              @endif
              @if ($errors->has('email'))<p class="loginwarning">{{ $errors->first('email') }}</p>@endif
              <form id="register-form" class="form-message" role="form" method="POST" action="{{ url('/password/email') }}">
                {!! csrf_field() !!}
                <div class="form-group row fix-gutter-10">
                  <div class="form-field col-sm-12 gutter-10 pt-40 pb-40">
                    <input name="email" type="email" placeholder="Email *" value="{{ old('email') }}" class="form-control required" required>
                  </div>
                </div>
                <br>
                <input type="text" class="hidden" name="form-anti-honeypot" value="">
                <button type="submit" class="button solid-btn sb-h">Send Password Reset Link</button>                  
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>    
  @include('includes.footerlanding')
  @include('includes.scriptslanding')
</body>
</html>
