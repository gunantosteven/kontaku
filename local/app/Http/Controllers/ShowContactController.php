<?php namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use Input;
use DB;


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
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  string  $url
	 * @return Response
	 */
	public function show($url)
	{
		//
		$user=DB::table('users')->where('url', $url)->first();
		if($user == null)
		{
			return view('contactnotfound');
		}
		else
		{
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
