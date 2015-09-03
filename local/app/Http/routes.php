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

////////////////////////////////////Cordova API///////////////////////////////////////////////
// cordova/phonegap login
Route::post('/login', function()
{
	$remember = Input::get('remember');
	$credentials = array(
		'email' => Input::get('email'), 
		'password' => Input::get('password')
	);

	if (Auth::attempt( $credentials, Request::has('remember') ))
	{
		return response()->json(['status' => true]);
	 	//return Redirect::to_action('user@index'); you'd use this if it's not AJAX request
	}else{
		return Response::json('Error logging in', 400);
		/*return Redirect::to_action('home@login')
		-> with_input('only', array('new_username')) 
		-> with('login_errors', true);*/
    }
});
Route::post('/checkauthlogin', function()
{
	if (Auth::user() != null)
	{
		return response()->json(['status' => true]);
	 	//return Redirect::to_action('user@index'); you'd use this if it's not AJAX request
	}else{
		return response()->json(['status' => false]);
		/*return Redirect::to_action('home@login')
		-> with_input('only', array('new_username')) 
		-> with('login_errors', true);*/
    }
});
////////////////////cordova//////////////////////////////////////////////////////////////////////


Route::get('/', 'WelcomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);



Route::get('/activate/{code}', 'Auth\AuthController@activateAccount');
Route::get('/resendEmail', 'Auth\AuthController@resendEmail');

Route::group(['middleware' => 'user'], function()
{
    Route::get('/user', function()
    {
        // can only access this if type == O
    });

    Route::get('/user/home', 'User\HomeController@index');

    // in showcontact page
    Route::post('/user/invite', [
		    'as' => 'showcontact.invite',
		    'uses' => 'ShowContactController@invite'
	]);


    Route::post('/user/getcontact', function()
	{
		$friendscount =  0;

		$friendsonline1 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user1')
            ->select('friendsonline.user1 as id', 'users.fullname as fullname', DB::raw("'ONLINE' as onlineoffline"))
            ->where('friendsonline.user2', Auth::user()->id)
            ->where('friendsonline.status', 'ACCEPTED');
        $friendsonline2 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user2')
            ->select('friendsonline.user2 as id', 'users.fullname as fullname', DB::raw("'ONLINE' as onlineoffline"))
            ->where('friendsonline.user1', Auth::user()->id)
            ->where('friendsonline.status', 'ACCEPTED');
        $friendsoffline = DB::table('friendsoffline')->select('id', 'fullname', DB::raw("'OFFLINE' as onlineoffline"))->where('user', Auth::user()->id);
        $combined = $friendsoffline->unionAll($friendsonline1)->unionAll($friendsonline2)->take(20)->orderBy('fullname')->get();

		$count = 0;
		$array = array();

		foreach ($combined as $friend)
		{
			$array[$count++] = array( "id" => $friend->id, "fullname" => $friend->fullname, "onlineoffline" => $friend->onlineoffline);
			$friendscount++;
		}

	    //this route should returns json response
	    return response()->json(['friendscount' => $friendscount, 'friends' => $array]);
	});
    
	Route::post('/user/getcontact/{friendscount}', function($friendscount)
	{
		$friendsonline1 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user1')
            ->select('friendsonline.user1 as id', 'users.fullname as fullname', DB::raw("'ONLINE' as onlineoffline"))
            ->where('friendsonline.user2', Auth::user()->id)
            ->where('friendsonline.status', 'ACCEPTED');
        $friendsonline2 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user2')
            ->select('friendsonline.user2 as id', 'users.fullname as fullname', DB::raw("'ONLINE' as onlineoffline"))
            ->where('friendsonline.user1', Auth::user()->id)
            ->where('friendsonline.status', 'ACCEPTED');
        $friendsoffline = DB::table('friendsoffline')->select('id', 'fullname', DB::raw("'OFFLINE' as onlineoffline"))->where('user', Auth::user()->id);
        $combined = $friendsoffline->unionAll($friendsonline1)->unionAll($friendsonline2)->skip($friendscount)->take(10)->orderBy('fullname')->get();

		$count = 0;
		$array = array();

		foreach ($combined as $friend)
		{
			$array[$count++] = array( "id" => $friend->id, "fullname" => $friend->fullname, "onlineoffline" => $friend->onlineoffline);
			$friendscount++;
		}
	    
	    ///this route should returns json response
	    return response()->json(['friendscount' => $friendscount, 'friends' => $array]);
	});

	Route::post('/user/search', function()
	{
		$friendsonline1 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user1')
            ->select('friendsonline.user1 as id', 'users.fullname as fullname', DB::raw("'ONLINE' as onlineoffline"))
            ->where('friendsonline.user2', Auth::user()->id)
            ->where('users.fullname', 'ilike', "%" . Request::input('search') . "%")
            ->where('friendsonline.status', 'ACCEPTED');
        $friendsonline2 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user2')
            ->select('friendsonline.user2 as id', 'users.fullname as fullname', DB::raw("'ONLINE' as onlineoffline"))
            ->where('friendsonline.user1', Auth::user()->id)
            ->where('users.fullname', 'ilike', "%" . Request::input('search') . "%")
            ->where('friendsonline.status', 'ACCEPTED');
        $friendsoffline = DB::table('friendsoffline')->select('id', 'fullname', DB::raw("'OFFLINE' as onlineoffline"))->where('user', Auth::user()->id)->where('fullname', 'ilike', "%" . Request::input('search') . "%");
        $combined = $friendsoffline->unionAll($friendsonline1)->unionAll($friendsonline2)->take(20)->orderBy('fullname')->get();

		$count = 0;
		$array = array();
		foreach ($combined as $friend)
		{
			$array[$count++] = array( "id" => $friend->id, "fullname" => $friend->fullname, "onlineoffline" => $friend->onlineoffline);
		}
	    
	    //this route should returns json response
	    return response()->json(['count' => $count, 'friends' => $array]);
	});

	Route::post('/user/profile', function()
	{
		$user = Auth::user();
		//this route should returns json response
	    return Response::json($user);
	});

	Route::post('/user/friendprofile', function()
	{
		$id = Request::input('id');
		// security check if this profile is her/his friend.
		$friendsonline1 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user1')
            ->select('friendsonline.user1 as id', 'users.fullname as fullname')
            ->where('friendsonline.user2', Auth::user()->id)
            ->where('friendsonline.user1', $id)
            ->where('friendsonline.status', 'ACCEPTED')->count();
        $friendsonline2 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user2')
            ->select('friendsonline.user2 as id', 'users.fullname as fullname')
            ->where('friendsonline.user1', Auth::user()->id)
            ->where('friendsonline.user2', $id)
            ->where('friendsonline.status', 'ACCEPTED')->count();
        $friendsoffline = DB::table('friendsoffline')->select('id', 'fullname')->where('id', $id)->where('user', Auth::user()->id)->count();
        $combinedCount = $friendsoffline + $friendsonline1 + $friendsonline2;

        if($combinedCount > 0)
        {	
        	// if friend is friend online
        	$user = DB::table('users')->where('id', $id)->first();

        	// if friend is friend offline
			if($user == null)
			{
				$user = DB::table('friendsoffline')->where('id', $id)->first();
				$user->onlineoffline = 'offline';

				//this route should returns json response
		    	return Response::json($user);
			}

			$user->onlineoffline = 'online';

		    //this route should returns json response
		    return Response::json($user);
        }

		return Response::json(null);
		
	});


	// create friendoffline
	Route::post('/user/create/friendoffline', function()
	{
		parse_str(Request::input('formData'), $output);
		$id = Uuid::generate();
		\App\Models\FriendOffline::create(array(
			'id' => $id,
		    'user' => Auth::user()->id,
		    'fullname' => $output['fullname'],
		    'email' => $output['email'],
		    'phone' => $output['phone'],
		    'pinbb' => $output['pinbb'],
		    'facebook' => $output['facebook'],
		    'twitter' => $output['twitter'],
		    'instagram' => $output['instagram'],
		    'line' => $output['line'],
			));
   		return response()->json(['status' => true, 'id' => $id, 'fullname' => $output['fullname']]);
	});

	// edit friendoffline
	Route::post('user/edit/friendoffline', function()
	{
		$output = Input::all();
		DB::table('friendsoffline')
            ->where('id', $output['id'])
            ->update(['fullname' => $output['fullname'], 
            		'email' => $output['email'], 
            		'phone' => $output['phone'], 
            		'pinbb' => $output['pinbb'], 
            		'facebook' => $output['facebook'],
            		'twitter' => $output['twitter'],
            		'instagram' => $output['instagram'],
            		'line' => $output['line']]);

        $createImage = Image::make($output['photo']);
		$createImage->resize(65, 65);
		$createImage->save(base_path() . '/resources/assets/images/photos/' . $output['id'] . '.png' );

   		return response()->json(['status' => true]);
	});

	// delete friend
	Route::delete('user/delete/friend', function()
	{
		$id = Request::input('id');
		$onlineoffline = Request::input('onlineoffline');
		if($onlineoffline == "online")
		{
			// if user1 is authentic user
			DB::table('friendsonline')->where('user1', Auth::user()->id)->where('user2', $id)->where('status', 'ACCEPTED')->delete();
			// if user2 is authentic user
			DB::table('friendsonline')->where('user1', $id)->where('user2', Auth::user()->id)->where('status', 'ACCEPTED')->delete();
		}
		else if($onlineoffline == "offline")
		{
			DB::table('friendsoffline')->where('id', $id)->delete();
		}
		else
		{
			return response()->json(['status' => false]);
		}

   		return response()->json(['status' => true]);
	});

	// edit my profile
	Route::post('user/editprofile', function()
	{
		$output = Input::all();
		$id = Auth::user()->id;
		DB::table('users')
            ->where('id', $id)
            ->update(['fullname' => $output['fullname'], 
            		'phone' => $output['phone'], 
            		'pinbb' => $output['pinbb'], 
            		'facebook' => $output['facebook'],
            		'twitter' => $output['twitter'],
            		'instagram' => $output['instagram'],
            		'line' => $output['line']]);

        $createImage = Image::make($output['photo']);
		$createImage->resize(65, 65);
		$createImage->save(base_path() . '/resources/assets/images/photos/' . $id . '.png' );

   		return response()->json(['status' => true]);
	});

	// sent invitation
	Route::post('/user/sentinvitation', function()
	{
        $friendsonline = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user2')
            ->select('friendsonline.user2 as id', 'users.fullname as fullname', 'friendsonline.status as status', 'friendsonline.created_at as created_at')
            ->where('friendsonline.user1', Auth::user()->id)
            ->where(function($query)
            {
                $query->where('friendsonline.status', 'DECLINED')
                      ->orWhere('friendsonline.status', 'PENDING');
            })->orderBy('created_at')->get();

		$count = 0;
		$array = array();

		foreach ($friendsonline as $friend)
		{
			$array[$count++] = array( "id" => $friend->id, "fullname" => $friend->fullname, 'status' => $friend->status);
		}

	    //this route should returns json response
	    return response()->json(['users' => $array]);
	});

	// got invitation
	Route::post('/user/gotinvitation', function()
	{
        $friendsonline = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user1')
            ->select('friendsonline.user1 as id', 'users.fullname as fullname', 'friendsonline.status as status', 'friendsonline.created_at as created_at')
            ->where('friendsonline.user2', Auth::user()->id)
            ->where('friendsonline.status', 'PENDING')->orderBy('created_at')->get();

		$count = 0;
		$array = array();

		foreach ($friendsonline as $friend)
		{
			$array[$count++] = array( "id" => $friend->id, "fullname" => $friend->fullname, 'status' => $friend->status);
		}

	    //this route should returns json response
	    return response()->json(['users' => $array]);
	});

	// count invitation
	Route::post('/user/countinvitation', function()
	{
		// sent invitation
        $friendsonlinesent = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user2')
            ->select('friendsonline.user2 as id')
            ->where('friendsonline.user1', Auth::user()->id)
            ->where(function($query)
            {
                $query->where('friendsonline.status', 'DECLINED')
                      ->orWhere('friendsonline.status', 'PENDING');
            })->count();
        // got invitation
        $friendsonlinegot = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user1')
            ->select('friendsonline.user1 as id')
            ->where('friendsonline.user2', Auth::user()->id)
            ->where('friendsonline.status', 'PENDING')->count();
        $combinedcount = $friendsonlinesent + $friendsonlinegot;

	    //this route should returns json response
	    return response()->json(['count' => $combinedcount, 'newinvitesnotification' => Auth::user()->newinvitesnotification]);
	});

	// search friend online
	Route::post('/user/searchaddfriendsonline', function()
	{
		parse_str(Request::input('formData'), $output);
		$usersearch = DB::table('users')->where('url', $output['search'])->first();
		if($usersearch == null)
		{
			return response()->json(['status' => false]);
		}

		$friendsonline1 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user1')
            ->select('friendsonline.user1 as id', 'users.fullname as fullname', 'friendsonline.status as status')
            ->where('friendsonline.user2', $usersearch->id)
            ->where('friendsonline.user1', Auth::user()->id)
            ->where(function($query)
            {
                $query->where('friendsonline.status', 'DECLINED')
                      ->orWhere('friendsonline.status', 'PENDING')
                      ->orWhere('friendsonline.status', 'ACCEPTED');
            });
        $friendsonline2 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user2')
            ->select('friendsonline.user2 as id', 'users.fullname as fullname', 'friendsonline.status as status')
            ->where('friendsonline.user1', $usersearch->id)
            ->where('friendsonline.user2', Auth::user()->id)
            ->where(function($query)
            {
                $query->where('friendsonline.status', 'DECLINED')
                      ->orWhere('friendsonline.status', 'PENDING')
                      ->orWhere('friendsonline.status', 'ACCEPTED');
            });
        $combinedcount = $friendsonline1->unionAll($friendsonline2)->get();

        foreach ($combinedcount as $friend)
		{
			return response()->json(['status' => false]);
		}

        $array = array();
    	$array[0] = array( "id" => $usersearch->id, "fullname" => $usersearch->fullname);
    	//this route should returns json response
    	return response()->json(['status' => true, 'users' => $array]);
	});

	// create friendonline
	Route::post('/user/create/friendonline', function()
	{
		parse_str(Request::input('formData'), $output);
		$id = Uuid::generate();
		\App\Models\FriendOnline::create(array(
			'id' => $id,
		    'user1' => Auth::user()->id,
			'user2' => $output['id'],
			'status' => 'PENDING',
			));

		// make new invites notification to users who got invitation
		DB::table('users')
            ->where('id', $output['id'])
            ->update(['newinvitesnotification' => 1]);


   		return response()->json(['status' => true]);
	});

	// accept invitation (make status to be ACCEPTED)
	Route::post('user/acceptinvitation', function()
	{
		$id = Request::input('id');
		DB::table('friendsonline')
            ->where('user1', $id)
            ->where('user2', Auth::user()->id)
            ->update(['status' => "ACCEPTED"]);

   		return response()->json(['status' => true]);
	});

	// decline invitation (make status to be DECLINED)
	Route::post('user/declineinvitation', function()
	{
		$id = Request::input('id');
		DB::table('friendsonline')
            ->where('user1', $id)
            ->where('user2', Auth::user()->id)
            ->update(['status' => "DECLINED"]);

   		return response()->json(['status' => true]);
	});

	// delete invitation
	Route::delete('user/deleteinvitation', function()
	{
		$id = Request::input('id');
		DB::table('friendsonline')
            ->where('user1', Auth::user()->id)
            ->where('user2', $id)
            ->delete();

   		return response()->json(['status' => true]);
	});

	Route::post('user/changepassword', function() 
	{
		parse_str(Request::input('formData'), $output);
		// authenticated user
		if($output['new_password'] == $output['new_password2'])
		{
			$new_password = $output['new_password'];
			$user = Auth::user();
			$user->password = Hash::make($new_password);
			// finally we save the authenticated user
			$user->save();
	   		return response()->json(['status' => true]);
		}

		return response()->json(['status' => false]);
	});

	// edit my private account status
	Route::put('user/changeprivateaccount', function()
	{
		$id = Auth::user()->id;
		$privateaccount = 0;
		if( Request::input('privateaccount') == "yes")
		{
			$privateaccount = 1;
		}
		else
		{
			$privateaccount = 0;
		}
		DB::table('users')
            ->where('id', $id)
            ->update(['privateaccount' => $privateaccount]);

   		return response()->json(['status' => true]);
	});

	// edit newinvitesnotificationoff user
	Route::put('user/newinvitesnotificationoff', function()
	{
		DB::table('users')
            ->where('id', Auth::user()->id)
            ->update(['newinvitesnotification' => 0]);

   		return response()->json(['status' => true]);
	});

	Route::post('/user/totalcontacts', function()
	{
		$totalcontacts =  0;

		$friendsonline1 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user1')
            ->select('friendsonline.user1 as id', 'users.fullname as fullname')
            ->where('friendsonline.user2', Auth::user()->id)
            ->where('friendsonline.status', 'ACCEPTED')->count();
        $friendsonline2 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user2')
            ->select('friendsonline.user2 as id', 'users.fullname as fullname')
            ->where('friendsonline.user1', Auth::user()->id)
            ->where('friendsonline.status', 'ACCEPTED')->count();
        $friendsoffline = DB::table('friendsoffline')->select('id', 'fullname')->where('user', Auth::user()->id)->count();
        $totalcontacts = $friendsoffline + $friendsonline1 + $friendsonline2;

	    //this route should returns json response
	    return response()->json(['totalcontacts' => $totalcontacts]);
	});

	// get image
	Route::get('/user/images/photos/{id}', function($id)
	{
		// security check if this profile is her/his friend.
		$friendsonline1 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user1')
            ->select('friendsonline.user1 as id', 'users.fullname as fullname')
            ->where('friendsonline.user2', Auth::user()->id)
            ->where('friendsonline.user1', $id)->count();
        $friendsonline2 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user2')
            ->select('friendsonline.user2 as id', 'users.fullname as fullname')
            ->where('friendsonline.user1', Auth::user()->id)
            ->where('friendsonline.user2', $id)->count();
        $friendsoffline = DB::table('friendsoffline')->select('id', 'fullname')->where('id', $id)->where('user', Auth::user()->id)->count();
        $combinedCount = $friendsoffline + $friendsonline1 + $friendsonline2;

        if($combinedCount > 0)
        {
        	if(File::exists(base_path() . '/resources/assets/images/photos/' . $id . '.png'))
			{
				// open an image file
				$img = Image::make(base_path() . '/resources/assets/images/photos/' . $id . '.png' );
			}
			else
			{
				// open an image file
				$img = Image::make(base_path() . '/resources/assets/images/photos/user.png' );
			}
        }

		// now you are able to resize the instance
		$img->resize(45, 45);

		return $img->response('png');
	});

	// get image from friendprofile
	Route::get('/user/images/photos/friendsprofile/{id}', function($id)
	{
		// security check if this profile is her/his friend.
		$friendsonline1 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user1')
            ->select('friendsonline.user1 as id', 'users.fullname as fullname')
            ->where('friendsonline.user2', Auth::user()->id)
            ->where('friendsonline.user1', $id)->count();
        $friendsonline2 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user2')
            ->select('friendsonline.user2 as id', 'users.fullname as fullname')
            ->where('friendsonline.user1', Auth::user()->id)
            ->where('friendsonline.user2', $id)->count();
        $friendsoffline = DB::table('friendsoffline')->select('id', 'fullname')->where('id', $id)->where('user', Auth::user()->id)->count();
        $combinedCount = $friendsoffline + $friendsonline1 + $friendsonline2;

        if($combinedCount > 0)
        {
        	if(File::exists(base_path() . '/resources/assets/images/photos/' . $id . '.png'))
			{
				// open an image file
				$img = Image::make(base_path() . '/resources/assets/images/photos/' . $id . '.png' );
			}
			else
			{
				// open an image file
				$img = Image::make(base_path() . '/resources/assets/images/photos/user.png' );
			}
        }

		// now you are able to resize the instance
		$img->resize(65, 65);

		return $img->response('png');
	});
});

Route::get('createdb',function(){
	Schema::create('users',function($table){
		$table->string('id')->primary();
		$table->string('email',32)->unique();
		$table->string('password',60);
		$table->string('activation_code')->default('');
		$table->boolean('active')->default(0);
		$table->tinyInteger('resent')->unsigned()->default(0);
		$table->string('role',32)->default('USER');
		$table->string('remember_token',60)->default('');
		$table->string('fullname',30)->default('');
		$table->string('url', 30)->unique();
		$table->string('phone',30)->default('');
		$table->string('pinbb',30)->default('');
		$table->string('facebook',30)->default('');
		$table->string('twitter',30)->default('');
		$table->string('instagram',30)->default('');
		$table->string('line',30)->default('');
		$table->string('status',30)->default('Welcome to my contact');
		$table->boolean('privateaccount')->default(0);
		$table->boolean('newinvitesnotification')->default(0);
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
		$table->string('status');
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
		$table->string('line',30)->default('');
		$table->timestamps();
	});

	return "tables has been created";
});

Route::get('/{url}', [
	    'as' => 'showcontact.show',
	    'uses' => 'ShowContactController@show'
]);

