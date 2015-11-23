<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Input;
use DB;
use Request;

class MemberController extends Controller {

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
	        ->where('fullname', 'LIKE', "%$search%")
	        ->orWhere('url', 'LIKE', "%$search%")
	        ->orderBy('fullname')
	        ->paginate(30);
		}
		else
		{
			$users = DB::table('users')
			->orderBy('fullname')
	        ->paginate(10);
		}

		if(Request::input('success') == true)
		{
			$success = true;
			return view('/admin/member', compact('users', 'success'));
		}
		
		return view('/admin/member', compact('users'));
	}

}
