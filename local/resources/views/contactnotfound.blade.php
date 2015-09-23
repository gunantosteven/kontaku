@extends('app')

@section('content')
<div id="main-content">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">Contact Not Found</div>
        <div class="panel-body">
          <h3>You can register this url <a href={{ url("/auth/register") }}> Click Here to register</a></h3>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection