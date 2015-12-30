@extends('/admin/app')

@section('content')

                                    
<div class="container">
     <center><h1>Info Storage</h1></center>      
     <div class="block-fluid"> 
	     <table class="table" style="width: auto;">
		     <tbody>
		      <tr>
		        <td>Size Database</td>
		        <td class="text-right">{{ $sizeDatabase }}</td>
		      </tr>
		      <tr>
		        <td>Size Images</td>
		        <td class="text-right">{{ $fileSizeImages }}</td>
		      </tr>
		      <tr>
		        <td>Total</td>
		        <td class="text-right">{{ $total }}</td>
		      </tr>
		    </tbody>
	    </table>
     </div>
     <div class="block-fluid"> 
	     <table class="table" style="width: auto;">
		     <tbody>
		      <tr>
		        <td>Table Categories</td>
		        <td class="text-right">{{ $tableCategories }}</td>
		      </tr>
		       <tr>
		        <td>Table Detail Categories</td>
		        <td class="text-right">{{ $tableDetailCategories }}</td>
		      </tr>
		      <tr>
		        <td>Table Friends Offline</td>
		        <td class="text-right">{{ $tableFriendsOffline }}</td>
		      </tr>
		      <tr>
		        <td>Table Friends Online</td>
		        <td class="text-right">{{ $tableFriendsOnline }}</td>
		      </tr>
		      <tr>
		        <td>Table Password Resets</td>
		        <td class="text-right">{{ $tablePasswordResets }}</td>
		      </tr>
		      <tr>
		        <td>Table Sessions</td>
		        <td class="text-right">{{ $tableSessions }}</td>
		      </tr>
		      <tr>
		        <td>Table Users</td>
		        <td class="text-right">{{ $tableUsers }}</td>
		      </tr>
		    </tbody>
	    </table>
     </div>
</div>

@endsection
