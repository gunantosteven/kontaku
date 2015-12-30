<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use File;

class InfoStorageController extends Controller {

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
		$sizeDatabase = DB::select(DB::raw('SELECT pg_size_pretty(pg_database_size(\'kontakku\'))'))[0]->pg_size_pretty;
		$fileSizeImages = 0;
	    foreach( File::allFiles(base_path().'/resources/assets/images/photos') as $file)
	    {
	        $fileSizeImages += $file->getSize();
	    }
	    $fileSizeImages = formatSizeUnits($fileSizeImages);

		$tableCategories = DB::select(DB::raw('SELECT pg_size_pretty(pg_relation_size(\'categories\'))'))[0]->pg_size_pretty;
		$tableDetailCategories = DB::select(DB::raw('SELECT pg_size_pretty(pg_relation_size(\'detailcategories\'))'))[0]->pg_size_pretty;
		$tableFriendsOffline = DB::select(DB::raw('SELECT pg_size_pretty(pg_relation_size(\'friendsoffline\'))'))[0]->pg_size_pretty;
		$tableFriendsOnline = DB::select(DB::raw('SELECT pg_size_pretty(pg_relation_size(\'friendsonline\'))'))[0]->pg_size_pretty;
		$tablePasswordResets = DB::select(DB::raw('SELECT pg_size_pretty(pg_relation_size(\'password_resets\'))'))[0]->pg_size_pretty;
		$tableSessions = DB::select(DB::raw('SELECT pg_size_pretty(pg_relation_size(\'sessions\'))'))[0]->pg_size_pretty;
		$tableUsers = DB::select(DB::raw('SELECT pg_size_pretty(pg_relation_size(\'users\'))'))[0]->pg_size_pretty;
		
		return view('/admin/infostorage', compact('sizeDatabase', 'tableCategories', 'tableDetailCategories', 'tableFriendsOffline'
												, 'tableFriendsOnline', 'tablePasswordResets', 'tableSessions', 'tableUsers', 'fileSizeImages'));
	}

}
