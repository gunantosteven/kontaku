<?php namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\FriendOnline;
use App\Models\FriendOffline;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Auth;
use DB;

class HomeController extends Controller {

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
		$user = Auth::user();
		if($user)
		{
			$friendsonline = DB::table('friendsonline')->where('user1', $user->id)->orWhere('user2', $user->id)->get();
			$friendsoffline = DB::table('friendsoffline')->where('user', $user->id)->get();
			return view('/user/home', compact('user', 'friendsonline', 'friendsoffline'));
		}
	}

}
