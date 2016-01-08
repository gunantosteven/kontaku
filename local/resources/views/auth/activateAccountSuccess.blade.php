@extends('app')

@section('content')
<div id="main-content">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">Activation Success</div>
        <div class="panel-body">
          <p>Your account has been activated.</p>

		  <p>Please login in to continue. <a href="{{ url('/auth/login') }}">Log in</a></p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection