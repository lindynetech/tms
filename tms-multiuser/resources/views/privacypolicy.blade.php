<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.headlanding')
    <title>Privacy Policy | {{ config('tms.title') }}</title>
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
            <div class="col-md-10 col-md-offset-1">
              <div class="white-bg text-left" style="margin-top: 40px; padding: 20px;">
                
                <!-- table -->
                <div style="padding: 20px;">
                    <div style="border: 1px solid grey; padding: 20px;">
                    <h6 class="heading"><span>Privacy Policy</span></h6>
                    <p><strong>Privacy Notice</strong> <br>
                        This privacy notice discloses the privacy practices for <span style="text-decoration: underline;">{{ config('tms.webaddress')}}</span>. This privacy notice applies solely to information collected by this website. It will notify you of the following:</p>
                    <ul style="margin-left: 40px;list-style: asterisks;">
                    <li>What personally identifiable information is collected from you through the website, how it is used and with whom it may be shared.</li>
                    <li>What choices are available to you regarding the use of your data.</li>
                    <li>The security procedures in place to protect the misuse of your information.</li>
                    <li>How you can correct any inaccuracies in the information.</li>
                    </ul>
                    <p><strong>Information Collection, Use, and Sharing</strong> <br />We are the sole owners of the information collected on this site. We only have access to/collect information that you voluntarily give us via email or other direct contact from you. We will not sell or rent this information to anyone.</p>
                    <p>We will use your information to respond to you, regarding the reason you contacted us. We will not share your information with any third party outside of our organization, other than as necessary to fulfill your request, e.g. to ship an order.</p>
                    <p>Unless you ask us not to, we may contact you via email in the future to tell you about specials, new products or services, or changes to this privacy policy.</p>
                    <p><strong>Your Access to and Control Over Information</strong> <br />You may opt out of any future contacts from us at any time. You can do the following at any time by contacting us via the email address or phone number given on our website:</p>
                    <ul style="margin-left: 40px;list-style: asterisks;">
                    <li>See what data we have about you, if any.</li>
                    <li>Change/correct any data we have about you.</li>
                    <li>Have us delete any data we have about you.</li>
                    <li>Express any concern you have about our use of your data.</li>
                    </ul>
                    <p><strong>Security</strong> <br />We take precautions to protect your information. When you submit sensitive information via the website, your information is protected both online and offline.</p>
                    <p>Wherever we collect sensitive information, that information is encrypted and transmitted to us in a secure way. You can verify this by looking for a lock icon in the address bar and looking for "https" at the beginning of the address of the Web page.</p>
                    <p>We do not store any financial information, all online financial transactions and security related to them are handled by PayPal inc.</p>
                    <p>While we use encryption to protect sensitive information transmitted online, we also protect your information offline. Only employees who need the information to perform a specific job (for example, billing or customer service) are granted access to personally identifiable information. The computers/servers in which we store personally identifiable information are kept in a secure environment.</p>
                    
                    <p><strong>Registration</strong> <br />In order to use this website, a user must first complete the registration form. During registration a user is required to give certain information (such as name and email address). This information is used to contact you about the products/services on our site in which you have expressed interest.</p>
                    <p style="text-align: justify;"><strong>Subscription</strong> <br />We use 3rd-party service (Paypal Inc) tp handle all the subscription services. Paypal will handle all the communications regarding your subscription status. We do not store any financial information passed to Paypal via subscription process. We only store the status of you subscription.</p>
                    <p style="text-align: justify;"><strong>Cookies</strong> <br />We use "cookies" on this site. A cookie is a piece of data stored on a site visitor's hard drive to help us improve your access to our site and identify repeat visitors to our site. For instance, when we use a cookie to identify you, you would not have to log in a password more than once, thereby saving time while on our site. Cookies can also enable us to track and target the interests of our users to enhance the experience on our site. Usage of a cookie is in no way linked to any personally identifiable information on our site.</p>
                    
                    <p><strong>If you feel that we are not abiding by this privacy policy, you should contact us immediately <span style="text-decoration: underline;"><a class="nav-item" href="/#contacts"></a>via email</span>.</strong></p>
                    
                   
                    </div>
                </div>
    

               
              </div>
                   
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
