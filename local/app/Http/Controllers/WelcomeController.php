<?php namespace App\Http\Controllers;

use DB;

class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$totalusers = DB::table('users')->count();

		$friendsonline = DB::table('friendsonline')->select('id')->where('status', 'ACCEPTED')->count();
        $friendsoffline = DB::table('friendsoffline')->select('id')->count();
        $totalcontacts = $friendsonline + $friendsoffline;

		return view('welcome', compact('totalusers', 'totalcontacts'));
	}

}
