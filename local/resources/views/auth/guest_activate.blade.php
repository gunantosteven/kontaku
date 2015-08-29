@extends('app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">Home</div>
        <div class="panel-body">
          <p>An email was sent to {{ $email }} on {{ $date }}.</p>

          <p>Please click the link in it to activate your account.</p>
          
          <p><a href={{ URL::to('/resendEmail') }}>'Click here to resend the email.',</a></p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection