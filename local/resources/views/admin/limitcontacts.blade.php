@extends('/admin/app')

@section('content')

                                    
<div class="container">
     <center><h3>Change Limit Contact Member {{ $user->fullname }}</h3>     

     {!! Form::model($user,['method' => 'POST','route'=>['admin.limitcontacts.update',$user->id]]) !!}
        <div class="block-fluid"> 
            <div class="form-group">
            	<label for="changeMemberType" class="control-label">Limit Contact : </label>
                <select name="limitcontacts" id="limitcontacts">
                	@if($user->limitcontacts == 250)
	                  <option selected="true" value="250">250</option>
	                @else
	                  <option value="250">250</option>
	                @endif
	                @if($user->limitcontacts == 500)
	                  <option selected="true" value="500">500</option>
	                @else
	                  <option value="500">500</option>
	                @endif
	                @if($user->limitcontacts == 1000)
	                  <option selected="true" value="1000">1000</option>
	                @else
	                  <option value="1000">1000</option>
	                @endif
	                @if($user->limitcontacts == 1500)
	                  <option selected="true" value="1500">1500</option>
	                @else
	                  <option value="1500">1500</option>
	                @endif
	                @if($user->limitcontacts == 2000)
	                  <option selected="true" value="2000">2000</option>
	                @else
	                  <option value="2000">2000</option>
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
