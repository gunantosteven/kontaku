@extends('app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">{{ $user->fullname }} Contact :D</div>
        <div class="panel-body">

          <form class="form-horizontal" role="form" method="GET" action="">

            <div class="form-group">
              <label class="col-md-4 control-label">Phone</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="phone" value="{{ $user->phone }}" readonly="">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label">PIN BB</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="pinbb" value="{{ $user->pinbb }}" readonly="">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label">Facebook</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="facebook" value="{{ $user->facebook }}" readonly="">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label">Twitter</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="twitter" value="{{ $user->twitter }}" readonly="">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label">Instagram</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="instagram" value="{{ $user->instagram }}" readonly="">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label">Status</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="status" value="{{ $user->status }}" readonly="">
              </div>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection