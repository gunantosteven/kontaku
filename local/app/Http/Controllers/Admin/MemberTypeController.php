<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Input;
use DB;
use Request;

class MemberTypeController extends Controller {

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
	public function index($id)
	{
		$user=User::find($id);
   		return view('/admin/membertype',compact('user'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
		$userUpdate = Request::all();
		$limitContacts = 0;

		if($userUpdate['membertype'] == "BOSS")
		{
			$limitContacts = 1000;
		}
		else if($userUpdate['membertype'] == "PREMIUM")
		{
			$limitContacts = 500;
		}
		else
		{
			$limitContacts = 250;
		}

   		DB::table('users')
            ->where('id', $id)
            ->update(['membertype' => $userUpdate['membertype'], 
            		'limitcontacts' => $limitContacts]);

   		return redirect('admin/members?success=true');
	}

}
