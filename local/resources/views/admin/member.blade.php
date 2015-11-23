@extends('/admin/app')

@section('content')

                                    
<div class="container">
     <center><h1>List Data member</h1></center>   
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
         <th>Limit Contacts</th>
         <th>Member Type</th>
         <th colspan="1">Actions</th>
     </tr>
     </thead>
     <tbody>
     @foreach ($users as $user)
         <tr>
             <td>{{ $user->fullname }}</td>
             <td>{{ $user->url }}</td>
             <td>{{ $user->limitcontacts }}</td>
             <td>{{ $user->membertype }}</td>
             <td><a href="{{route('admin.membertype.index',$user->id)}}" class="btn btn-warning">Change Member Type</a></td>
         </tr>
     @endforeach

     </tbody>

	 </table>
	 <div class="pagination"> {!! str_replace('/?', '?', $users->render()); $users->render(); !!} </div>
</div>

@if (isset($success) && $success === true)
<script>
  window.alert('Data successfully stored');
</script>
@endif
@endsection
