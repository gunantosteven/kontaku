@extends('/admin/app')

@section('content')

                                    
<div class="container">
     <center><h3>Change Member Type {{ $user->fullname }}</h3>     

     {!! Form::model($user,['method' => 'POST','route'=>['admin.membertype.update',$user->id]]) !!}
        <div class="block-fluid"> 
            <div class="form-group">
            	<label for="changeMemberType" class="control-label">Member Type : </label>
                <select name="membertype" id="membertype">
	                @if($user->membertype == "MEMBER")
	                  <option selected="true" value="MEMBER">MEMBER</option>
	                @else
	                  <option value="MEMBER">MEMBER</option>
	                @endif
	                @if($user->membertype == "PREMIUM")
	                  <option selected="true" value="PREMIUM">PREMIUM</option>
	                @else
	                  <option value="PREMIUM">PREMIUM</option>
	                @endif
	                @if($user->membertype == "BOSS")
	                  <option selected="true" value="BOSS">BOSS</option>
	                @else
	                  <option value="BOSS">BOSS</option>
	                @endif
                </select>
            </div>
            <div class="row-form clearfix">
                {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>
     {!! Form::close() !!} 
     <br>
     </center>
</div>

@endsection
