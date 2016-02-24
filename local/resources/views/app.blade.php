<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KontaKKu Online - Free For Everyone who wants to save contacts</title>
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
    <!-- Bootstrap -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}" />
	<link rel="stylesheet" href="{{ asset('js/fancybox/jquery.fancybox.css') }}" type="text/css" media="screen" />
	<link rel="stylesheet" type="text/css" href="{{ asset('css/isotope.css') }}" media="screen" />
	<link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- google site verification -->
    <meta name="google-site-verification" content="fa1nygFnfM1Eq8XpgyVn70UY1KEaxvQPVbhlnmKl1Zk" />
</head>
<body>
	<header>
		<div class="main-menu">
			<div class="container">
				<div class="row">
					<div class="col-md-4">						
						<h1><a class="navbar-brand" href={{ url("/") }} data-0="line-height:90px;" data-300="line-height:50px;">			KontaKKu
						</a></h1>   						
					</div>						
					<div class="col-md-8">
						<div class="dropdown">
							<ul class="nav nav-pills">
							    <li class="{{ Request::is('/') ? 'active' : '' }}"><a href={{ url("/") }}>Home</a></li>	
							    <li class="{{ Request::is('site/membertype') ? 'active' : '' }}"><a href={{ url("/site/membertype") }}>Member Type</a></li>
							    @if (Auth::guest())					    
									<li class="{{ Request::is('auth/login') ? 'active' : '' }}"><a href={{ url("/auth/login") }}>Login</a></li>
								    <li class="{{ Request::is('auth/register') ? 'active' : '' }}"><a href={{ url("/auth/register") }}>Register</a></li>
							    @else
							    	<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->fullname }} <span class="caret"></span></a>
										<ul class="dropdown-menu" role="menu">
											<li><a href={{ url("/auth/logout") }}>Logout</a></li>
										</ul>
									</li>
								@endif
								<li class="{{ Request::is('/site/contact') ? 'active' : '' }}"><a href={{ url("/site/contact") }}>Contact Us</a></li>
							</ul>
						</div>
					</div>	
				</div>				
			</div>
		</div>
	</header>

	@yield('content')

	<footer>
		<section id="footer" class="section footer">
			<div class="container">
				<div class="row animated opacity mar-bot20" data-andown="fadeIn" data-animation="animation">
					<div class="col-sm-12 align-center">
						<ul class="social-network social-circle">
							<li><a href="#" class="icoRss" title="Rss"><i class="fa fa-rss"></i></a></li>
							<li><a href="https://www.facebook.com/kontakku/" class="icoFacebook" title="Facebook"><i class="fa fa-facebook"></i></a></li>
							<li><a href="#" class="icoTwitter" title="Twitter"><i class="fa fa-twitter"></i></a></li>
							<li><a href="#" class="icoGoogle" title="Google +"><i class="fa fa-google-plus"></i></a></li>
							<li><a href="#" class="icoLinkedin" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
						</ul>				
					</div>
				</div>
				<div class="row align-center copyright">
					<p><a href="{{ url("/site/privacy") }}" title="Privacy Policy" target="_new">Privacy Policy</a> - <a href="{{ url("/site/terms") }}" title="Terms and Conditions" target="_new">Terms and Conditions</a></p>
					<div class="col-sm-12"><p>Copyright &copy; {{ date("Y") }} kontakku.com - template by <a href="http://bootstraptaste.com">Bootstraptaste</a></p></div>
				</div>
			</div>
		</section>
		<a href="#" class="scrollup"><i class="fa fa-chevron-up"> </i></a>
	</footer>		
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{ asset('js/jquery-1.12.0.min.js') }}"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/jquery.isotope.min.js') }}"></script>
	<script src="{{ asset('js/fancybox/jquery.fancybox.pack.js') }}"></script>
	<script src="{{ asset('js/wow.min.js') }}"></script>
	<script src="{{ asset('js/functions.js') }}"></script>

</body>
</html>
