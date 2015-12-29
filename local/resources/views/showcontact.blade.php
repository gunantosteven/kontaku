@extends('app')

@section('content')
<div id="main-content">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading"><center>KontaKKu Contact since {{ date("d F Y",strtotime($user->created_at)) }}</center></div>
        <div class="panel-body">
          <form class="form-horizontal" role="form" method="GET" action={{ url("/asd/asd") }}>

            <div class="form-group">
              @if ( $user->membertype == "PREMIUM" )
                <span class="label label-success">PREMIUM</span>
              @elseif ( $user->membertype == "BOSS")
                <span class="label label-primary">BOSS</span>
              @else
                <span class="label label-default">MEMBER</span>
              @endif
            </div>

          	<div class="form-group">
          		<center><img src={{ url("/image/$user->id") }}></center>
              @if( $user->fullname == "" )
              <center><b>{{ $user->url }}</b></center>
              @else
              <center><b>{{ $user->fullname }}</b></center>
              @endif
              <center>{{ $user->status }}</center>
          	</div>
          @if( $user->showemailinpublic == true )
            <div class="form-group">
              <label class="col-md-4 control-label">Email</label>
              <div class="col-md-6">
                <input type="text" onClick="this.setSelectionRange(0, this.value.length)" class="form-control" name="phone" value="{{ $user->email }}" readonly="">
              </div>
            </div>
          @endif
          @if($user->phone)
            <div class="form-group">
              <label class="col-md-4 control-label">Phone 1</label>
              <div class="col-md-6">
                <input type="text" onClick="this.setSelectionRange(0, this.value.length)" class="form-control" name="phone" value="{{ $user->phone }}" readonly="">
              </div>
            </div>
          @endif
          @if($user->phone2)
            <div class="form-group">
              <label class="col-md-4 control-label">Phone 2</label>
              <div class="col-md-6">
                <input type="text" onClick="this.setSelectionRange(0, this.value.length)" class="form-control" name="phone" value="{{ $user->phone2 }}" readonly="">
              </div>
            </div>
          @endif
          @if($user->address)
            <div class="form-group">
              <label class="col-md-4 control-label">Address</label>
              <div class="col-md-6">
                <textarea onClick="this.setSelectionRange(0, this.value.length)" class="form-control" name="address" readonly="">{{ $user->address }}</textarea>
              </div>
            </div>
          @endif
          @if($user->pinbb)
            <div class="form-group">
              <label class="col-md-4 control-label">PIN BB</label>
              <div class="col-md-6">
                <input type="text" onClick="this.setSelectionRange(0, this.value.length)" class="form-control" name="pinbb" value="{{ $user->pinbb }}" readonly="">
              </div>
            </div>
          @endif
          @if($user->facebook)
            <div class="form-group">
              <label class="col-md-4 control-label">Facebook</label>
              <div class="col-md-6">
                <input type="text" onClick="this.setSelectionRange(0, this.value.length)" class="form-control" name="facebook" value="{{ $user->facebook }}" readonly="">
              </div>
            </div>
          @endif
          @if($user->twitter)
            <div class="form-group">
              <label class="col-md-4 control-label">Twitter</label>
              <div class="col-md-6">
                <input type="text" onClick="this.setSelectionRange(0, this.value.length)" class="form-control" name="twitter" value="{{ $user->twitter }}" readonly="">
              </div>
            </div>
          @endif
          @if($user->instagram)
            <div class="form-group">
              <label class="col-md-4 control-label">Instagram</label>
              <div class="col-md-6">
                <input type="text" onClick="this.setSelectionRange(0, this.value.length)" class="form-control" name="instagram" value="{{ $user->instagram }}" readonly="">
              </div>
            </div>
          @endif
          @if($user->line)
            <div class="form-group">
              <label class="col-md-4 control-label">Line</label>
              <div class="col-md-6">
                <input type="text" onClick="this.setSelectionRange(0, this.value.length)" class="form-control" name="instagram" value="{{ $user->line }}" readonly="">
              </div>
            </div>
          @endif
          </form>
	        @if (Auth::user() && Auth::user()->id != $user->id && !Auth::user()->isFriendOnline($user->id))
	        <form class="form-horizontal" role="form" method="POST" action={{ url("/user/invite") }}>
	          <input type="hidden" name="_token" value="{{ csrf_token() }}">
	          <input type="hidden" name="id" value="{{ $user->id }}">
	          <div class="form-group">
	            <label class="col-md-6"></label>
	            <div class="col-md-6">
	              <input type="submit" class="btn btn-primary active" value="Invite">
	            </div>
	          </div>
	        </form>
	        @endif
        </div>
      </div>
    </div>
  </div>
</div>
@if (isset($error) && $error === true)
<script>
  window.alert('Error, maybe you have invited this contact. \nTry to check your contact list or invitation.');
</script>
@endif
@endsection