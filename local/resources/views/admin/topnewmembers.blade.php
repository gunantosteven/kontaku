@extends('/admin/app')

@section('content')

                                    
<div class="container">
     <center><h1>List Top New Members</h1></center>   
     <hr>
     {!! Form::open(['method' => 'GET', 'route'=>['admin.members.index']]) !!}
	 {!! Form::text('search',null,['class'=>'pull-right']) !!}
	 {!! Form::label('search', 'Search Full Name or Url :&nbsp;',['class'=>'pull-right']) !!}
	 {!! Form::close() !!}
	 </br>
	 </br>
     <table class="table table-striped table-bordered table-hover">
     <thead>
     <tr class="bg-info">
         <th>Full Name</th>
         <th>URL</th>
         <th>Total Contacts</th>
         <th>Limit Contacts</th>
         <th>Member Type</th>
         <th>Created At</th>
     </tr>
     </thead>
     <tbody>
     @foreach ($array as $user)
         <tr>
             <td>{{ $user['fullname'] }}</td>
             <td>{{ $user['url'] }}</td>
             <td>{{ $user['totalcontacts'] }}</td>
             <td>{{ $user['limitcontacts'] }}</td>
             <td>{{ $user['membertype'] }}</td>
             <td>{{ $user['created_at'] }}</td>
        </tr>
     @endforeach

     </tbody>

	 </table>
	 <div class="pagination"> {!! str_replace('/?', '?', $array->render()); $array->render(); !!} </div>
</div>

@if (isset($success) && $success === true)
<script>
  window.alert('Data successfully stored');
</script>
@endif
@endsection
