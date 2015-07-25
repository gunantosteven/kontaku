@extends('app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">Contact Not Found</div>
        <div class="panel-body">
        <h3>New Registration<a href={{ url("/auth/register") }}> Click Here</a></h3>
          
        </div>
      </div>
    </div>
  </div>
</div>
@endsection