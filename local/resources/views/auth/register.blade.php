@extends('app')

@section('content')
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-67268716-2', 'auto');
  ga('send', 'pageview', 'register');
</script>
<div id="main-content">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Register</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url("/auth/register") }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">Fullname</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="fullname" placeholder="Your Name" value="{{ old('fullname') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Kontakku.com/</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="url" placeholder="yourname" value="{{ old('url') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Active E-Mail Address</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" placeholder="name@example.com" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Confirm Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password_confirmation">
							</div>
						</div>

						<div class="form-group">
							<h6>
								By hitting submit and registering an account, you have read and agree to the Kontakku <a href="{{ url('/site/terms') }}" target="_blank">Terms and Conditions</a> & <a href="{{ url('/site/privacy') }}" target="_blank">Privacy Policy</a>.
							</h6>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-6">
								<button type="submit" class="btn btn-primary">
									Register
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
