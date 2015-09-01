<?php namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use Input;
use DB;
use Auth;
use Uuid;


class ShowContactController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function invite()
	{
		//
		$friendsonline1 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user1')
            ->select('friendsonline.user1 as id', 'users.fullname as fullname')
            ->where('friendsonline.user2', Auth::user()->id)
            ->where('friendsonline.user1', Request::input('id'))
            ->count();
        $friendsonline2 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user2')
            ->select('friendsonline.user2 as id', 'users.fullname as fullname')
            ->where('friendsonline.user1', Auth::user()->id)
            ->where('friendsonline.user2', Request::input('id'))
            ->count();
        $combinedCount = $friendsonline1 + $friendsonline2;

		if($combinedCount == 0)
        {
        	$uuid = Uuid::generate();
			\App\Models\FriendOnline::create(array(
				'id' => $uuid,
			    'user1' => Auth::user()->id,
				'user2' => Request::input('id'),
				'status' => 'PENDING',
				));

			// make new invites notification to users who got invitation
			DB::table('users')
	            ->where('id', Request::input('id'))
	            ->update(['newinvitesnotification' => 1]);

	        return redirect('/user/home');
	    }
		
		$url = DB::table('users')
	            ->where('id', Request::input('id'))->first()->url;
		return redirect('/' . $url . '?error=true');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  string  $url
	 * @return Response
	 */
	public function show($url, Request $request)
	{
		//
		$user=DB::table('users')->where('url', $url)->first();

		if(Request::input('error') != "" && $user != null)
		{
			$error = true;
	   		return view('showcontact', compact('user', 'error'));
		}

		if($user == null)
		{
			return view('contactnotfound');
		}
		else
		{
			if($user->privateaccount == true)
			{
				return view('contactisprivate');
			}
			return view('showcontact',compact('user'));
		}	
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
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
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
