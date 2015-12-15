@extends('/admin/app')

@section('content')

                                    
<div class="container">
     <center><h1>Members Statistics</h1></center>      
     <div class="block-fluid"> 
	     <table class="table" style="width: auto;">
		     <tbody>
		      <tr>
		        <td>Total Members Not Active</td>
		        <td class="text-right">{{ $totalnotactive }}</td>
		      </tr>
		      <tr>
		        <td>Total Members Free</td>
		        <td class="text-right">{{ $totalmembersfree }}</td>
		      </tr>
		      <tr>
		        <td>Total Members Premium</td>
		        <td class="text-right">{{ $totalmemberspremium }}</td>
		      </tr>
		      <tr>
		        <td>Total Members Boss</td>
		        <td class="text-right">{{ $totalmembersboss }}</td>
		      </tr>
		      <tr>
		        <td>Total Members</td>
		        <td class="text-right">{{ $totalmembers }}</td>
		      </tr>
		    </tbody>
	    </table>

	    <table class="table" style="width: auto;">
		     <tbody>
		      <tr>
		        <td>Today Registration</td>
		        <td class="text-right">{{ $todayregistration }}</td>
		      </tr>
		      <tr>
		        <td>Yesterday Registration</td>
		        <td class="text-right">{{ $yesterdayregistration }}</td>
		      </tr>
		      <tr>
		        <td>This Month Registration</td>
		        <td class="text-right">{{ $thismonthregistration }}</td>
		      </tr>
		      <tr>
		        <td>Last Month Registration</td>
		        <td class="text-right">{{ $lastmonthregistration }}</td>
		      </tr>
		    </tbody>
	    </table>
     </div>
</div>

@endsection
