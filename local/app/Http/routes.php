<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::group(['middleware' => 'user'], function()
{
    Route::get('/user', function()
    {
        // can only access this if type == O
    });

    Route::get('/user/home', 'User\HomeController@index');

	Route::post('/user/getcontact/{friendsonlinecount}/{friendsofflinecount}', function($friendsonlinecount, $friendsofflinecount)
	{
		$countonline =  DB::table('friendsonline')->where('user1', Auth::user()->id)->orWhere('user2', Auth::user()->id)->count() - $friendsonlinecount;
		$countoffline =  DB::table('friendsoffline')->count() - $friendsofflinecount;

		$friendsonline = DB::table('friendsonline')->where('user1', Auth::user()->id)->orWhere('user2', Auth::user()->id)->skip($countonline)->take(5)->get();
		$friendsoffline = DB::table('friendsoffline')->skip($countoffline)->take(5)->get();

		$count = 0;
		$array = array();
		foreach ($friendsonline as $friend)
		{
			if ($friend->user1 == Auth::user()->id)
			{
				$array[$count++] = $friend->user2 . " " .  DB::table('users')->where('id', $friend->user2)->first()->fullname;
			}
            elseif ($friend->user2 == Auth::user()->id)
            {
            	$array[$count++] = $friend->user1 . " " .  DB::table('users')->where('id', $friend->user1)->first()->fullname;
            }
		}
		foreach ($friendsoffline as $friend)
		{
			$array[$count++] = $friend->id . " " .  $friend->fullname;
		}
	    
	    //this route should returns json response
	    return $array;
	});

	Route::post('/user/search', function()
	{
		$friendsoffline = DB::table('friendsoffline')->where('fullname','ilike', "%" . Request::input('search') . "%")->limit(20)->get();
		$friendsonline = DB::table('friendsonline')->where('user1', Auth::user()->id)->orWhere('user2', Auth::user()->id)->get();


		$count = 0;
		$array = array();
		foreach ($friendsonline as $friend)
		{
			if($count == 19)
			{
				break;
			}
			$fullname1 = DB::table('users')->where('id', $friend->user1)->first()->fullname;
			$fullname2 = DB::table('users')->where('id', $friend->user2)->first()->fullname;
			if ($friend->user1 == Auth::user()->id && stripos($fullname2,  Request::input('search')) !== false)
			{
				$array[$count++] = $friend->user2 . " " .  DB::table('users')->where('id', $friend->user2)->first()->fullname;
			}
            elseif ($friend->user2 == Auth::user()->id && stripos($fullname1,  Request::input('search')) !== false)
            {
            	$array[$count++] = $friend->user1 . " " .  DB::table('users')->where('id', $friend->user1)->first()->fullname;
            }
		}
		foreach ($friendsoffline as $friend)
		{
			$array[$count++] = $friend->id . " " .  $friend->fullname;
		}
	    
	    //this route should returns json response
	    return $array;
	});

	Route::post('/user/profile/{id}', function($id)
	{
		$user = DB::table('users')->where('id', $id)->first();

		if($user == null)
		{
			$user = DB::table('friendsoffline')->where('id', $id)->first();
		}

	    //this route should returns json response
	    return Response::json($user);
	});
});

Route::get('createdb',function(){
	Schema::create('users',function($table){
		$table->string('id')->primary();
		$table->string('email',32)->unique();
		$table->string('password',60);
		$table->string('role',32)->default('USER');
		$table->string('remember_token',60)->default('');
		$table->string('fullname',30)->default('');
		$table->string('url', 30)->unique();
		$table->string('phone',30)->default('');
		$table->string('pinbb',30)->default('');
		$table->string('facebook',30)->default('');
		$table->string('twitter',30)->default('');
		$table->string('instagram',30)->default('');
		$table->string('status',30)->default('Welcome to my contact');
		$table->timestamps();
	});
	Schema::create('password_resets',function($table){
		$table->string('email')->index();
		$table->string('token')->index();
		$table->timestamp('created_at');
	});
	Schema::create('friendsonline',function($table){
		$table->string('id')->primary();
		$table->string('user1');
		$table->foreign('user1')->references('id')->on('users');
		$table->string('user2');
		$table->foreign('user2')->references('id')->on('users');
		$table->timestamps();
	});
	Schema::create('friendsoffline',function($table){
		$table->string('id')->primary();
		$table->string('user');
		$table->foreign('user')->references('id')->on('users');
		$table->string('fullname',30)->default('');
		$table->string('email',32)->default('');
		$table->string('phone',30)->default('');
		$table->string('pinbb',30)->default('');
		$table->string('facebook',30)->default('');
		$table->string('twitter',30)->default('');
		$table->string('instagram',30)->default('');
		$table->timestamps();
	});

	return "tables has been created";
});

Route::get('/{url}', [
	    'as' => 'showcontact.show',
	    'uses' => 'ShowContactController@show'
]);