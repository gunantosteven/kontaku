@extends('app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">Home</div>
        <div class="panel-body">
          <p>We have sent an email to {{ $email }}.</p>

		  <p>Please click the link in it to activate your account.</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection