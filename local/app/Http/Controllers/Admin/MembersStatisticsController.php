<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class MembersStatisticsController extends Controller {

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
		$totalmembers =  0;

		$totalmembers = DB::table('users')->count();
		$totalnotactive = DB::table('users')->where('activation_code','!=', '')->count();
		$totalmembersfree = DB::table('users')->where('membertype', 'MEMBER')->where('activation_code', '')->count();
		$totalmemberspremium = DB::table('users')->where('membertype', 'PREMIUM')->count();
		$totalmembersboss = DB::table('users')->where('membertype', 'BOSS')->count();

		$todayregistration = DB::table('users')->where('created_at','>=', Carbon::now()->format('Y-m-d'))->count();
		$yesterdayregistration = DB::table('users')->where('created_at','>=', Carbon::now()->subDays(1)->format('Y-m-d'))
												   ->where('created_at','<', Carbon::now()->format('Y-m-d'))->count();
		$thismonthregistration = DB::table('users')->whereRaw('extract(month from created_at) = ?', [Carbon::now()->format('m')])->count();
		$lastmonthregistration = DB::table('users')->whereRaw('extract(month from created_at) = ?', [Carbon::now()->format('m')-1])->count();

		return view('/admin/membersstatistics', compact('totalmembers', 'totalnotactive', 'totalmembersfree', 'totalmemberspremium', 'totalmembersboss',
														'todayregistration', 'yesterdayregistration', 'thismonthregistration', 'lastmonthregistration'));
	}

}
