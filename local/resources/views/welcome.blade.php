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
	<div class="slider">		
		  <center><img src="" alt="" class="img-responsive" height="683" width="750" /></center> 		
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
		</div>	
		<div class="container">

		</div>
	</div>
	<!-- end column content -->	
@endsection
