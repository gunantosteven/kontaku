@extends('app')

@section('content')
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-67268716-2', 'auto');
  ga('send', 'pageview', 'contactisnotactive');
</script>
<div id="main-content">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">Contact Is Not Active</div>
        <div class="panel-body">
          <h3>This contact cannot be seen until this contact is active</h3>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection