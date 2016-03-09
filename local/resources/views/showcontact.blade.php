@extends('app')

@section('content')
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-67268716-2', 'auto');
  ga('send', 'pageview', 'showcontact');
</script>
<div id="main-content">
  <div class="container">
    <center>
      <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
      <!-- show contact -->
      <ins class="adsbygoogle"
           style="display:block"
           data-ad-client="ca-pub-5254482915141018"
           data-ad-slot="8091177484"
           data-ad-format="auto"></ins>
      <script>
      (adsbygoogle = window.adsbygoogle || []).push({});
      </script>
      <br>
    </center>
  </div>
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading"><center>Registered since {{ date("d F Y",strtotime($user->created_at)) }}</center></div>
        <div class="panel-body">
          <form class="form-horizontal" role="form" method="GET" >

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
          @if($user->phone && !$user->privatephone1)
            <div class="form-group">
              <label class="col-md-4 control-label">Phone 1</label>
              <div class="col-md-6">
                <input type="text" onClick="this.setSelectionRange(0, this.value.length)" class="form-control" name="phone" value="{{ $user->phone }}" readonly="">
              </div>
            </div>
          @endif
          @if($user->phone2 && !$user->privatephone2)
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