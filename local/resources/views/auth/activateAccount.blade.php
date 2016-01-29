@extends('app')

@section('content')
<div id="main-content">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">Activation</div>
        <div class="panel-body">
          <p>We have sent an email to {{ $email }}.</p>

		  <p>Please check your spam folder just in case the confirmation email got delivered there instead of your inbox.</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection