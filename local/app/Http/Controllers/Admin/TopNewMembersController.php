<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Input;
use DB;
use Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class TopNewMembersController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Input::has('search'))
		{
			$search = Input::get('search'); 
			$users = DB::table('users')
			->select('id', 'fullname', 'url', 'limitcontacts', 'membertype', 'created_at')
	        ->where('fullname', 'LIKE', "%$search%")
	        ->orWhere('url', 'LIKE', "%$search%")
	        ->orderBy('fullname')->get();
		}
		else
		{
			$users = DB::table('users')
			->select('id', 'fullname', 'url', 'limitcontacts', 'membertype', 'created_at')
	        ->get();
		}

		$count = 0;
		$array = array();

		foreach ($users as $user)
		{
			$totalcontacts =  0;

			$friendsonline1 = DB::table('users')
	            ->join('friendsonline', 'users.id', '=', 'friendsonline.user1')
	            ->select('friendsonline.user1 as id', 'users.fullname as fullname')
	            ->where('friendsonline.user2', $user->id)
	            ->where('friendsonline.status', 'ACCEPTED')->count();
	        $friendsonline2 = DB::table('users')
	            ->join('friendsonline', 'users.id', '=', 'friendsonline.user2')
	            ->select('friendsonline.user2 as id', 'users.fullname as fullname')
	            ->where('friendsonline.user1', $user->id)
	            ->where('friendsonline.status', 'ACCEPTED')->count();
	        $friendsoffline = DB::table('friendsoffline')->select('id', 'fullname')->where('user', $user->id)->count();
        	$totalcontacts = $friendsoffline + $friendsonline1 + $friendsonline2;


			$array[$count++] = array("fullname" => $user->fullname, "url" => $user->url, "totalcontacts" => $totalcontacts, "membertype" => $user->membertype, "limitcontacts" => $user->limitcontacts, "created_at" => $user->created_at);
		}

		$array = array_reverse(array_sort($array, function($value)
		{
		    return $value['created_at'];
		}));
		
		//Get current page form url e.g. &page=6
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        //Create a new Laravel collection from the array data
        $collection = new Collection($array);

        //Define how many items we want to be visible in each page
        $perPage = 10;

        //Slice the collection to get the items to display in current page
        $currentPageSearchResults = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();

        //Create our paginator and pass it to the view
        $paginatedSearchResults= new LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage);

		return view('/admin/topnewmembers', ['array' => $paginatedSearchResults]);
	}

}
