@extends('app')

@section('content')
  	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v2.4";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
	</script>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-67268716-2', 'auto');
	  ga('send', 'pageview', 'welcome');
	</script>
	<div class="slider">		
		  <center><img src="img/logo.png" alt="" class="img-responsive" height="683" width="406" /></center> 		
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
										<h4 class="text-bold">What is KontaKKu?</h4>
										<p>KontaKKu is a provider to save your contacts by online and you can share your phone, pin BB, facebook and etc easily too. It is like your contacts phone but with more features. You can use kontakku on web, smartphone and tablet easily.
										</p>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="box-bg">
								<div class="wow bounceInLeft" data-wow-duration="2s" data-wow-delay="0.6s">
									<div class="align-center">
										<h4 class="text-bold">Why use KontaKKu?</h4>
										<p>In daily life, you will face situation where you need to save your contacts in one phone, but when you phone is gone or stealed you need to write your contacts again on your new phone. You don't need to write your contacts many times just saving here and it will be the last. Don't worry if you have many smartphone because your contacts are not saved in your phone but in server. <b>Use kontakku as your second contacts backup.</b> 
										</p>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="box-bg">
								<div class="wow bounceInLeft" data-wow-duration="2s" data-wow-delay="0.2s">
									<div class="align-center">
										<h4 class="text-bold">Friend Online And Offline?</h4>
										<p>If you have friends who are using KontaKKu too you can invite him/her to be your contacts friend online.
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
						<img src="img/money-icon.png" alt="" width="132px" height="65px"> 
						<h4>Is it free?</h4>
						<p>Yes, for now it is 100% free to register. 
						   Register Now <a href={{ url("/auth/register") }}>Here</a>. But if you want more access and capacity you can change your <a href={{ url("/site/membertype") }}>member type</a>.
						</p>
					</div>
				</div>
				<div class="wow bounceInLeft">
					<div class="col-lg-6">
						<img src="img/save-icon.png" alt="" width="65px" height="65px"> 
						<h4>Is it secure?</h4>
						<p>Your contacts will be saved in server and It's secure to save here as long as you don't give your account
						</p>
					</div>
				</div>
			</div>
		</div>	
		<div class="container">
			<center>
				<h4>Download App Free</h4>
				<a href="https://play.google.com/store/apps/details?id=com.ungapps.kontakku" target="_blank"><img src="img/googleplay.png" alt="" class="img-responsive" height="120" width="120" /></a>
			</center>
			<br>
			<center>
				<!-- Your like button code -->
			    <div 
			    	 class="fb-like" 
			         data-href="https://www.facebook.com/kontakku" 
			    	 data-layout="button_count" 
			    	 data-action="like" data-show-faces="true" data-share="true">
			   	</div>
			</center>
			<br>
			<center>
				<h4>Total Users : {{ number_format($totalusers) }}</h4> 
				<h4>Total Contacts : {{ number_format($totalcontacts) }}</h4> 
			</center>
		</div>	
	</div>
	<!-- end column content -->	
@endsection
