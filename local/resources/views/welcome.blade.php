<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KontaKKu Online - Free For Everyone who wants to save contacts</title>
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
  </head>
  <body>
    <header>
		<div class="main-menu">
			<div class="container">
				<div class="row">
					<div class="col-md-4">						
						<h1><a class="navbar-brand" href="" data-0="line-height:90px;" data-300="line-height:50px;">			KontaKKu
						</a></h1>   						
					</div>						
					<div class="col-md-8">
						<div class="dropdown">
							<ul class="nav nav-pills">
							    <li class="active"><a href="">Home</a></li>							    
								<li><a href={{ url("/auth/login") }}>Login</a></li>
							    <li><a href={{ url("/auth/register") }}>Register</a></li>
							</ul>
						</div>
					</div>	
				</div>				
			</div>
		</div>
	</header>
	<div class="slider">		
		  <center><img src="{{ asset('img/logo.jpg') }}" alt="" class="img-responsive" height="683" width="750" /></center> 		
	</div>	
	<!-- column content -->
	<div id="main-content">
		<div class="container">
			<div class="row">
				<div class="big-box">
					<div class="col-lg-12">
						<div class="col-md-4">
							<div class="box-bg">
								<div class="wow bounceInLeft" data-wow-duration="2s" data-wow-delay="0.9s">
									<div class="align-center">
										<h4 class="text-bold">What is KontaKKu</h4>
										<p>KontaKKu is a provider to save your contact by online. You can use kontakku on web, smartphone and tablet easily.
										</p>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="box-bg">
								<div class="wow bounceInLeft" data-wow-duration="2s" data-wow-delay="0.6s">
									<div class="align-center">
										<h4 class="text-bold">Why KontaKKu</h4>
										<p>You don't need to write your friends contact many times just saving here it will be last.
										</p>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="box-bg">
								<div class="wow bounceInLeft" data-wow-duration="2s" data-wow-delay="0.2s">
									<div class="align-center">
										<h4 class="text-bold">Friend Online Or Offline</h4>
										<p>If you have friends who using KontaKKu too you just invite him/her to be your contact friends online.
											But if your friends haven't used KontaKKu you can save him/her contact too through friends offline.
										</p>
									</div>
								</div>
							</div>
						</div>						
					</div>
				</div>					
			</div>
		</div>	
		<div class="container">
			<div class="row">					
				<div class="wow bounceInRight">	
					<div class="col-lg-6">
						<h4>Is it free</h4>
						<p>Yes, for now it is 100% free to register. 
						   Register Now <a href={{ url("/auth/register") }}>Here</a>.
						</p>
						<!--<a href="#" class="thumbnail">
							<img src="img/thumbnails/outline-1.jpg" alt=""> 
						</a>!-->
					</div>
				</div>
				<div class="wow bounceInLeft">
					<div class="col-lg-6">
						<h4>Is it save</h4>
						<p>Your friend contacts will be saved in server and It's secure to save here as long as you don't give your account
						</p>
						<!--<a href="#" class="thumbnail">
							<img src="img/thumbnails/ipad.jpg" alt="">
						</a>!-->
					</div>
				</div>
			</div>
		</div>	
		<div class="container">
			<center>
				<h4>Download App Free</h4>
				<img src="img/googleplay.png" alt="" class="img-responsive" height="120" width="120" />
			</center>
		</div>	
	</div>
	<!-- end column content -->	
	<footer>
		<section id="footer" class="section footer">
			<div class="container">
				<div class="row animated opacity mar-bot20" data-andown="fadeIn" data-animation="animation">
					<div class="col-sm-12 align-center">
						<ul class="social-network social-circle">
							<li><a href="#" class="icoRss" title="Rss"><i class="fa fa-rss"></i></a></li>
							<li><a href="#" class="icoFacebook" title="Facebook"><i class="fa fa-facebook"></i></a></li>
							<li><a href="#" class="icoTwitter" title="Twitter"><i class="fa fa-twitter"></i></a></li>
							<li><a href="#" class="icoGoogle" title="Google +"><i class="fa fa-google-plus"></i></a></li>
							<li><a href="#" class="icoLinkedin" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
						</ul>				
					</div>
				</div>
				<div class="row align-center copyright">
					<div class="col-sm-12"><p>Copyright &copy; 2015 kontakku.com - by <a href="http://bootstraptaste.com">Bootstraptaste</a></p></div>
				</div>
			</div>
		</section>
		<a href="#" class="scrollup"><i class="fa fa-chevron-up"> </i></a>
	</footer>		
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{ asset('js/jquery-1.11.1.min.js') }}"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/jquery.isotope.min.js') }}"></script>
	<script src="{{ asset('js/fancybox/jquery.fancybox.pack.js') }}"></script>
	<script src="{{ asset('js/wow.min.js') }}"></script>
	<script src="{{ asset('js/functions.js') }}"></script>
  </body>
</html>
