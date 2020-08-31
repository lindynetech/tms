<!DOCTYPE html>
<html lang="en">
<head>
	@include('includes.headlanding')
	<link rel="stylesheet" href="landing/colorbox/colorbox.css">
	<title>{{ config('tms.title') }}</title>
	
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
						<a class="navbar-brand" href="{{ url('/') }}">
							<img class="logo logo-light" src="landing/images/logo.png" alt="{{ config('tms.title')}}" />
							<img class="logo logo-color" src="landing/images/logo.png" alt="{{ config('tms.title')}}" />
						</a>
					</div>
					<div class="collapse navbar-collapse font-secondary" id="site-collapse-nav">
						<ul class="nav nav-list navbar-nav navbar-right">
							<li><a class="nav-item" href="#home"><i class="fa fa-home"></i> Home</a></li>
							<li><a class="nav-item" href="#tour"><i class="fa fa-arrow-right"></i> Take a Tour</a></li>
							<li><a class="nav-item" href="#features"><i class="fa fa-list"></i> Features</a></li>
							<li><a class="nav-item" href="#frog"><i class="fa fa-frog"></i> Eat it</a></li>
							<li><a class="nav-item" href="#pricing"><i class="fa fa-tag"></i> Pricing</a></li>
							<li><a class="nav-item" href="#faq"><i class="fa fa-question"></i> FAQ</a></li>
							<!-- <li><a class="nav-item" href="#testimonial">Testimonial</a></li> -->
							<li><a class="nav-item" href="#contacts"><i class="fa fa-envelope"></i> Contact Us</a></li>
							<li>
								@if (Auth::check())
								<a class="nav-item" href="{{ url('/app') }}"><i class="fa fa-th-large"></i> Dashboard</a>
								@else
								<a class="nav-item" href="{{ url('/login') }}"><i class="fa fa-sign-in-alt"></i> Login</a>
								@endif
								
							</li>
						</ul>
					</div>
				</div>
			</nav>
		</div>
		
		<div class="header-content">
			<div class="container">
				<div class="row">
					<div class="col-md-8">
						<div class="header-texts">
							<h1 class="cd-headline clip is-full-width wow fadeInUp" data-wow-duration=".2s">
								<span>Take Control of </span> 
								<span class="cd-words-wrapper">
									<b class="is-visible">Your Time</b>
									<b>Your Goals</b>
									<b>Your Priorities</b>
									<b>Your Productivity</b>
									<b>Your Success</b>
								</span>
							</h1>
							<p class="lead wow fadeInUp" data-wow-duration=".5s" data-wow-delay=".3s">
								Discover the master skills of success, get a sense of direction in your life.
							</p>
							<p class="lead wow fadeInUp" data-wow-duration=".5s" data-wow-delay=".3s">
								Learn the daily routine most successful people use - setting goals, developing plans, setting priorities, and eating that frog - your most important, biggest goal.
							</p>
							<p class="lead wow fadeInUp" data-wow-duration=".5s" data-wow-delay=".3s">
								In a month you will be completely different person with clear understanding of where you are going.
							</p>
							<p class="lead wow fadeInUp" data-wow-duration=".5s" data-wow-delay=".3s">
								"If you don't have clear goals for you life you are condemened to work for those who do." - Brian Tracy
							</p>
							
							<ul class="buttons">
								<li><a href="#tour" class="nav-item button alt wow fadeInUp" data-wow-duration=".5s" data-wow-delay=".9s">TAKE A TOUR</a></li>
							</ul>
						</div>
					</div>
					<div class="col-md-4">
						<div class="contact-form white-bg text-center">
							<h3>Start your free trial</h3>
							<p style="font-size: 10px; margin-bottom: 5px;">No Payment Required</p>
							<p style="margin-bottom: 5px;"><a href="{{ url('/login') }}" class="loginlink">Already Registered? Login here</a></p>
							@if ($errors->has('email')) <p class="loginwarning">{{ $errors->first('email') }}</p> @endif
							@if ($errors->has('password')) <p class="loginwarning">{{ $errors->first('password') }}</p> @endif
							@if ($errors->has('password_confirmation')) <p class="loginwarning">{{ $errors->first('password_confirmation') }}</p> @endif
							<form id="register-form" class="form-message" action="{{ url('/register') }}" method="POST">
								{!! csrf_field() !!}
								<div class="form-group row fix-gutter-10">
									<div class="form-field col-sm-12 gutter-10 form-m-bttm">
										<input name="name" type="text" placeholder="Name *" class="form-control required" value="{{ old('name') }}" required>
									</div>
								</div>
								<div class="form-group row fix-gutter-10">
									<div class="form-field col-sm-12 gutter-10">
										<input name="email" type="email" placeholder="Email *" class="form-control required email" value="{{ old('email') }}" required>
									</div>
								</div>
								<div class="form-group row fix-gutter-10">
									<div class="form-field col-sm-12 gutter-10 form-m-bttm">
										<input name="password" type="password" placeholder="Password *" class="form-control required" required>
									</div>
								</div>
								<div class="form-group row fix-gutter-10">
									<div class="form-field col-sm-12 gutter-10">
										<input name="password_confirmation" type="password" placeholder="Confirm password *" class="form-control required" required>
									</div>
								</div>
								<input type="text" class="hidden" name="form-anti-honeypot" value="">
								<button type="submit" class="button solid-btn sb-h">Sign Up</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>		
	
	<div id="tour" class="about-section section pb-40 white-bg half-header-about">
		<div class="container tab-fix">
			<div class="section-head text-center">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<h2 class="heading"><span>Take A Tour</span></h2>
					</div>
				</div>
			</div>
			<div class="row text-center tab-center mobile-center">
				<div class="col-md-10 col-md-offset-1">
					<div class="header-laptop-mockup black wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".6s" >
						<a class="group1" href="landing/images/tour/1-dashboard.png" title="Dashboard">
							<img src="landing/images/tour/tour.png" alt="Take a tour">
						</a>
						<div style="display: none;">
							<a class="group1" href="landing/images/tour/1-dashboardfull.png" title="Dashboard"></a>
							<a class="group1" href="landing/images/tour/5-goals.png" title="Goals"></a>
							<a class="group1" href="landing/images/tour/4-tasks.png" title="Tasks"></a>
							<a class="group1" href="landing/images/tour/2-habits.png" title="Habits"></a>
							<a class="group1" href="landing/images/tour/6-mindstorming.png" title="Mindstorming"></a>
							<a class="group1" href="landing/images/tour/7-readinglist.png" title="Reading List"></a>
							<a class="group1" href="landing/images/tour/3-help.png" title="Help"></a>
							<a class="group1" href="landing/images/tour/5-helpsystem.png" title="Help System"></a>
							<a class="group1" href="landing/images/tour/4-account.png" title="Account"></a>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
	
	<div id="features" class="features-section section gradiant-background overflowvisible">
		<div class="container tab-fix">
			<div class="features-content pt-10">
				<div class="row">
					<div class="col-md-12">
						<div class="section-head heading-light mobile-center tab-center text-center">
							<div class="row">
								<div class="col-md-10 col-md-offset-1">
									<h2 class="heading heading-light">Features</h2>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="features-list">
									<div class="single-features">
										<em class="ti ti-list"></em>
										<h4> Goals</h4>
										<p>Develop a habit of setting your goals daily, prioritize your goals, set your most important goal and start implementing it.</p>
									</div>
									<div class="single-features">
										<em class="ti ti-check"></em>
										<h4>Habits</h4>
										<p>Develop 7 habits of most successful people.</p>
									</div>
									<div class="single-features">
										<em class="ti ti-light-bulb"></em>
										<h4>Mindstorming</h4>
										<p>Use simple technique to tackle any problem by listing at least 20 solutions to it.</p>
									</div>
								</div>
								
							</div>
							<div class="col-md-6">
								<div class="features-list">
									<div class="single-features">
										<em class="ti ti-book"></em>
										<h4>Reading List</h4>
										<p>Track all your reading/self-education activities.</p>
									</div>
									<div class="single-features">
										<em class="ti ti-user"></em>
										<h4>Simple</h4>
										<p>Based of simple 21 rules and concepts of personal time management, productivity and success by Brian Tracy.</p>
									</div>
									<div class="single-features">
										<em class="ti ti-cloud"></em>
										<h4>Secure</h4>
										<p>All your information is encrypted in transit (TLS 1.2), at rest in database and is behind robust and secure Amazon Web Services Cloud infrastructure.</p>
									</div>
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div id="frog" class="section steps-section pb-40">
		<div class="container">
			<div class="section-head text-center">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<h2 class="heading"><span>Eat That Frog</span></h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-5 col-md-offset-0 col-sm-8 col-sm-offset-2">
					<ul class="nav nav-tabs">
						<li class="active" data-toggle="tab" data-target="#tab1">
							<div class="steps">
								<h4>What is the Frog?</h4>
								<p>Frog in 3 sentences</p>
							</div>
						</li>
						<li data-toggle="tab" data-target="#tab2">
							<div class="steps">
								<h4>5 Big Ideas</h4>
								<p>Always keep this in mind</p>
							</div>
						</li>
						<li data-toggle="tab" data-target="#tab3">
							<div class="steps">
								<h4>21 Rules of Success</h4>
								<p>Short overview of rules to follow on daily basis</p>
							</div>
						</li>
						<li data-toggle="tab" data-target="#tab4">
							<div class="steps">
								<h4>All Time Classic</h4>
								<p>Watch this video on Personal Time Management</p>
							</div>
						</li>
					</ul>
				</div>
				<div class="col-md-7 col-sm-12 col-md-offset-0 text-center">
					<div class="tab-content no-pd">
						<div class="tab-pane fade in active" id="tab1">
							<div class="tabsfrog">
								<h4>1. Your frog is your biggest, most important task.</h4>
								<h4>2. If you have two frogs, eat the ugliest one first.</h4>
								<h4>3. If you have to eat a frog, don't procrastinate on it.</h4>
							</div>						
						</div>
						<div class="tab-pane fade" id="tab2">
							<div class="tabsfrog">
								<h4>1. The key to reaching high levels of performance and productivity is to develop the lifelong habit of tackling your major task first thing each morning.</h4>
								<h4>2. Think about your goals and review them daily. Every morning when you begin, take action on the most important task you can accomplish to achieve your most important goal at the moment.</h4>
								<h4>3. Think on paper - always write your goals.</h4>
								<h4>4. Always work from the list.</h4>
								<h4>5. Your ability to choose between the important and the unimportant is the key determinant of your success in life and work.</h4>
							</div>
						</div>
						<div class="tab-pane fade" id="tab3">
							<div class="tabsfrog">
								<h6>21 Rules from "Eat That Frog" by Brian Tracy</h6>
								<ol style="list-style-type: all;font-size: 14px;">
								   <li>Set the table and clearly write your goals and objectives.</li>
								   <li>Plan every day in advance by thinking on paper.</li>
								   <li>Apply the 80/20 rule to everything and focus on the top 20%.</li>
								   <li>Consider the consequences of not doing your biggest projects.</li>
								   <li>Practice the ABCDE method of prioritizing your tasks.</li>
								   <li>Focus on key result areas. The areas that are most important in your job or career.</li>
								   <li>Practice the law of forced efficiency.</li>
								   <li>Prepare thoroughly before you begin.</li>
								   <li>Upgrade your skills.</li>
								   <li>Leverage your special talents and give it your best.</li>
								   <li>Identify the bottlenecks that are holding you back and resolve them.</li>
								   <li>Take it one step at a time.</li>
								   <li>Put the pressure on yourself.</li>
								   <li>Maximize your personal powers. Get rest and work in your optimal productive hours.</li>
								   <li>Motivate yourself into action by being optimistic.</li>
								   <li>Practice procrastination on items that are low value.</li>
								   <li>Do the most difficult task first.</li>
								   <li>Slice and dice the task into smaller pieces.</li>
								   <li>Organize your day into larger groups of productive time.</li>
								   <li>Develop a sense of urgency.</li>
								   <li>Single handle every task, set priorities and complete before moving on</li>
								 </ol>
							</div>
						</div>
						<div class="tab-pane  steps-screen" id="tab4">
							<div class="video">
								<img src="landing/images/about-vid.png" alt="Personal Time Management" />
								<div class="video-overlay gradiant-background"></div>
								<a href="https://www.youtube.com/watch?v=670Zm15WOK4" class="video-play" data-effect="mfp-3d-unfold"><i class="fa fa-play"></i></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="pricing" class="pricing-section section  gradiant-background pb-40">
		<div class="gradiant-background gradiant-overlay gradiant-light"></div>
		<div class="container tab-fix">
			<div class="section-head heading-light text-center">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
					<h2 class="heading heading-light">Pricing</h2>
				
					</div>
				</div>
			</div>
			<div class="row text-center">
				<div class="col-md-4 col-sm-12">
					<div class="pricing-box pricing-box-curbed wow fadeIn" data-wow-duration="1s">
						<div class="pricing-top gradiant-background">
							<h5>Free Trial</h5>
							<h5>1 Month</h5>
						</div>
						<div class="pricing-bottom">
							<ul class="text-left">
								<li><em class="ti ti-check"></em>No Payment Required</li>
								<li><em class="ti ti-check"></em>Pay after a month of free trial</li>
								<li><em class="ti ti-check"></em>Pay with Credit Card or Paypal</li>
							</ul>
							<a href="#home" class="button button-uppercase"> Sign Up</a>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-12">
					<div class="pricing-box pricing-box-curbed wow fadeIn" data-wow-duration="1s">
						<div class="pricing-top gradiant-background">
							
							<h5>Monthly Plan</h5>
							<h5>$4.99/Month</h5>
						</div>
						<div class="pricing-bottom">
							<ul class="text-left">
								<li><em class="ti ti-check"></em>Pay after a month of free trial</li>
								<li><em class="ti ti-check"></em>Pay with Credit Card or Paypal</li>
								<li><em class="ti ti-check"></em>Cancel Anytime</li>
							</ul>
							<a href="#home" class="button button-uppercase"> Sign Up</a>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-12">
					<div class="pricing-box pricing-box-curbed wow fadeIn" data-wow-duration="1s">
						<div class="pricing-top gradiant-background">
							<h5>Annual Plan</h5>
							<h5>$49.99/Year</h5>
						</div>
						<div class="pricing-bottom">
							<ul class="text-left">
								<li><em class="ti ti-check"></em>Pay after a month of free trial</li>
								<li><em class="ti ti-check"></em>Pay with Credit Card or Paypal</li>
								<li><em class="ti ti-check"></em>Cancel Anytime</li>
							</ul>
							<a href="#home" class="button button-uppercase"> Sign Up</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div id="faq" class="faq-section section white-bg pt-40 pb-40">
		<div class="container">
			<div class="faq-alt">
				<div class="row tab-fix">
					<div class="col-md-6">
						<div class="panel-group accordion" id="another" role="tablist" aria-multiselectable="true">
							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="accordion-i1">
									<h6 class="panel-title">
										<a role="button" data-toggle="collapse" data-parent="#another" href="#accordion-pane-i1" aria-expanded="false">
											Is my information and data secure?
											<span class="plus-minus"><span></span></span>
										</a>
									</h6>
								</div>
								<div id="accordion-pane-i1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="accordion-i1">
									<div class="panel-body">
										  <p>All your information and data are encrypted in transit (https/TLS 1.2), at rest in database and are behind robust and secure Amazon Web Services Cloud infrastructure. We do not share any of your information with any 3rd-parties.</p>
									</div>
								</div>
							</div> 
							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="accordion-i2">
									<h6 class="panel-title">
										<a class="collapsed" role="button" data-toggle="collapse" data-parent="#another" href="#accordion-pane-i2" aria-expanded="false">
											What payment methods do you accept?
											<span class="plus-minus"><span></span></span>
										</a>
									</h6>
								</div>
								<div id="accordion-pane-i2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="accordion-i2">
									<div class="panel-body">
										  <p>We accept all major credit cards and paypal. You do not need to have a paypal account to subscribe.</p>
									</div>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="accordion-i3">
									<h6 class="panel-title">
										<a class="collapsed" role="button" data-toggle="collapse" data-parent="#another" href="#accordion-pane-i3" aria-expanded="false">
											Do I need a credit card to start a free trial?
											<span class="plus-minus"><span></span></span>
										</a>
									</h6>
								</div>
								<div id="accordion-pane-i3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="accordion-i3">
									<div class="panel-body">
										  <p>No, your free trial starts immediately upon signup, after 31 days you will need to subscribe to the service.</p>
									</div>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="accordion-i4">
									<h6 class="panel-title">
										<a class="collapsed" role="button" data-toggle="collapse" data-parent="#another" href="#accordion-pane-i4" aria-expanded="false">
											Can I request a new feature?
											<span class="plus-minus"><span></span></span>
										</a>
									</h6>
								</div>
								<div id="accordion-pane-i4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="accordion-i4">
									<div class="panel-body">
										  <p>Yes, you can. Please use contact form at the bottom of home page to contact us.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4 tab-center mobile-center col-md-offset-1">
						<div class="side-heading">
							<h2 class="heading"><span>Frequently Asked Questions</span></h2>
							<p><a class="nav-item" href="#contacts">Contact us</a> if you have any other questions, want to submit feature request, report technical issues or ask about billing.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	

	<div id="contacts" class="contact-section section gradiant-background pb-10">
		<div class="container">
			<div class="section-head heading-light text-center">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<h2 class="heading heading-light">Get In Touch</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div class="contact-form white-bg text-center">
						<h3>Contact Us</h3>
						<p><small>Contact us if you want to submit feature request, report technical issues or ask any other questions</small></p>
						<form role="form" method="POST" action="#" id="contactForm">
							{!! csrf_field() !!}
							<div class="form-results" id="contactstatus" style="color: #F93D66;font-weight: bold;"></div>
							<!-- <div class="col-md-10 col-md-offset-4">
								<p style="color:red;font-weight: bold" id="contactstatus"></p>
							</div> -->
							<div class="form-group row fix-gutter-10">
								<div class="form-field col-sm-6 gutter-10 form-m-bttm">
									<input name="name" type="text" placeholder="Name *" class="form-control required" required @if (Auth::check()) value="{{auth()->user()->name}}" @endif>
								</div>
								<div class="form-field col-sm-6 gutter-10">
									<input name="email" type="email" placeholder="Email *" class="form-control required email" required @if (Auth::check()) value="{{auth()->user()->email}}" @endif>
								</div>
							</div>
							<div class="form-group row">
								<div class="form-field col-md-12">
									<input name="subject" type="text" placeholder="Subject *" class="form-control required" required>
								</div>
							</div>
							<div class="form-group row">
								<div class="form-field col-md-12">
									<textarea name="message" placeholder="Message *" class="txtarea form-control required" required></textarea>
								</div>
							</div>
							<input type="text" class="hidden" name="form-anti-honeypot" value=""><br>
							<button type="submit" class="button solid-btn sb-h">Submit</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	@include('includes.footerlanding')
	@include('includes.scriptslanding')
	<script src="landing/colorbox/jquery.colorbox-min.js"></script>
	<script>
			$(document).ready(function(){
				$(".group1").colorbox({rel:'group1', width:"90%", height:"90%"});
			});
		</script>
@include('cookieConsent::index')	
</body>
</html>
