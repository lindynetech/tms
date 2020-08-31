<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.headlanding')
    <title>Login | {{ config('tms.title') }}</title>
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
              <img class="logo logo-light" src="landing/images/logo-white.png" alt="{{ config('tms.title')}}" />
              <img class="logo logo-color" src="landing/images/logo.png" alt="{{ config('tms.title')}}" />
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
              <h3><i class="fa fa-sign-in-alt"></i> Sign in to start your session</h3>
              <p><a href="{{ url('/') }}" class="loginlink">Register | Start your free trial</a></p>
              @if ($errors->has('email')) <p class="loginwarning">{{ $errors->first('email') }}</p> @endif
              <form id="register-form" class="form-message" action="{{ url('/login') }}" method="POST">
                {!! csrf_field() !!}
                <div class="form-group row fix-gutter-10">
                  <div class="form-field col-sm-12 gutter-10">
                    <input id="email" name="email" type="email" placeholder="Email *" value="" required autocomplete="email" autofocus class="form-control required email">
                  </div>
                </div>
                <div class="form-group row fix-gutter-10">
                  <div class="form-field col-sm-12 gutter-10 form-m-bttm">
                    <input name="password" type="password" id="password" required autocomplete="current-password" placeholder="Password *" class="form-control required">
                  </div>
                </div>
                <div class="form-group row fix-gutter-10">
                  <div class="form-field col-sm-12 gutter-10 form-m-bttm">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" >
                    <label class="loginlink" for="remember">Remember Me</label>
                  </div>
                </div>
                <input type="text" class="hidden" name="form-anti-honeypot" value="">
                <button type="submit" class="button solid-btn sb-h">Login</button><br>
                <a class="loginlink" href="{{ url('password/reset') }}">Forgot Your Password?</a>
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
