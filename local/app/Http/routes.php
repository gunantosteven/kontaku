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
Route::get('/site/privacy', 'PrivacyController@index');
Route::get('/site/terms', 'TermsController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('/activate/{code}', 'Auth\AuthController@activateAccount');
Route::get('/resendEmail', 'Auth\AuthController@resendEmail');

Route::group(['middleware' => 'admin'], function()
{
    Route::get('/admin', function()
    {
        // can only access this if type == O
    });

    Route::get('/admin/dashboard', 'Admin\DashboardController@index');
});

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
		$friendsonline1 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user1')
            ->select('friendsonline.user1 as id', 'users.fullname as fullname', 'users.membertype as membertype', DB::raw("'ONLINE' as onlineoffline"))
            ->where('friendsonline.user2', Auth::user()->id)
            ->where('friendsonline.status', 'ACCEPTED')
            ->where('friendsonline.isfavorite', 0);
        $friendsonline2 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user2')
            ->select('friendsonline.user2 as id', 'users.fullname as fullname', 'users.membertype as membertype', DB::raw("'ONLINE' as onlineoffline"))
            ->where('friendsonline.user1', Auth::user()->id)
            ->where('friendsonline.status', 'ACCEPTED')
            ->where('friendsonline.isfavorite', 0);
        $friendsoffline = DB::table('friendsoffline')->select('id', 'fullname', DB::raw("'' as membertype"), DB::raw("'OFFLINE' as onlineoffline"))->where('user', Auth::user()->id)->where('isfavorite', 0);
        $combined = $friendsoffline->unionAll($friendsonline1)->unionAll($friendsonline2)->take(20)->orderBy('fullname')->get();

		$count = 0;
		$array = array();

		foreach ($combined as $friend)
		{
			$array[$count++] = array( "id" => $friend->id, "fullname" => $friend->fullname, "membertype" => $friend->membertype, "onlineoffline" => $friend->onlineoffline);
		}

	    //this route should returns json response
	    return response()->json(['friendscount' => $count, 'friends' => $array]);
	});
    
	Route::post('/user/getcontact/{friendscount}', function($friendscount)
	{
		$friendsonline1 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user1')
            ->select('friendsonline.user1 as id', 'users.fullname as fullname', 'users.membertype as membertype', DB::raw("'ONLINE' as onlineoffline"))
            ->where('friendsonline.user2', Auth::user()->id)
            ->where('friendsonline.status', 'ACCEPTED')
            ->where('friendsonline.isfavorite', 0);
        $friendsonline2 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user2')
            ->select('friendsonline.user2 as id', 'users.fullname as fullname', 'users.membertype as membertype', DB::raw("'ONLINE' as onlineoffline"))
            ->where('friendsonline.user1', Auth::user()->id)
            ->where('friendsonline.status', 'ACCEPTED')
            ->where('friendsonline.isfavorite', 0);
        $friendsoffline = DB::table('friendsoffline')->select('id', 'fullname', DB::raw("'' as membertype"), DB::raw("'OFFLINE' as onlineoffline"))->where('user', Auth::user()->id)->where('isfavorite', 0);
        $combined = $friendsoffline->unionAll($friendsonline1)->unionAll($friendsonline2)->skip($friendscount)->take(10)->orderBy('fullname')->get();

		$count = 0;
		$array = array();

		foreach ($combined as $friend)
		{
			$array[$count++] = array( "id" => $friend->id, "fullname" => $friend->fullname, "membertype" => $friend->membertype, "onlineoffline" => $friend->onlineoffline);
			$friendscount++;
		}
	    
	    ///this route should returns json response
	    return response()->json(['friendscount' => $friendscount, 'friends' => $array]);
	});

	Route::post('/user/getfavorites', function()
	{
		$friendsonline1 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user1')
            ->select('friendsonline.user1 as id', 'users.fullname as fullname', 'users.membertype as membertype', DB::raw("'ONLINE' as onlineoffline"))
            ->where('friendsonline.user2', Auth::user()->id)
            ->where('friendsonline.status', 'ACCEPTED')
            ->where('friendsonline.isfavorite', 1);
        $friendsonline2 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user2')
            ->select('friendsonline.user2 as id', 'users.fullname as fullname', 'users.membertype as membertype', DB::raw("'ONLINE' as onlineoffline"))
            ->where('friendsonline.user1', Auth::user()->id)
            ->where('friendsonline.status', 'ACCEPTED')
            ->where('friendsonline.isfavorite', 1);
        $friendsoffline = DB::table('friendsoffline')->select('id', 'fullname', DB::raw("'' as membertype"), DB::raw("'OFFLINE' as onlineoffline"))->where('user', Auth::user()->id)->where('isfavorite', 1);
        $combined = $friendsoffline->unionAll($friendsonline1)->unionAll($friendsonline2)->orderBy('fullname')->get();

		$count = 0;
		$array = array();

		foreach ($combined as $friend)
		{
			$array[$count++] = array( "id" => $friend->id, "fullname" => $friend->fullname, "membertype" => $friend->membertype, "onlineoffline" => $friend->onlineoffline);
		}

	    //this route should returns json response
	    return response()->json(['friends' => $array]);
	});

	Route::post('/user/search', function()
	{
		$friendsonline1 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user1')
            ->select('friendsonline.user1 as id', 'users.fullname as fullname', 'users.membertype as membertype', DB::raw("'ONLINE' as onlineoffline"))
            ->where('friendsonline.user2', Auth::user()->id)
            ->where('users.fullname', 'ilike', "%" . Request::input('search') . "%")
            ->where('friendsonline.status', 'ACCEPTED');
        $friendsonline2 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user2')
            ->select('friendsonline.user2 as id', 'users.fullname as fullname', 'users.membertype as membertype', DB::raw("'ONLINE' as onlineoffline"))
            ->where('friendsonline.user1', Auth::user()->id)
            ->where('users.fullname', 'ilike', "%" . Request::input('search') . "%")
            ->where('friendsonline.status', 'ACCEPTED');
        $friendsoffline = DB::table('friendsoffline')->select('id', 'fullname', DB::raw("'' as membertype"), DB::raw("'OFFLINE' as onlineoffline"))->where('user', Auth::user()->id)->where('fullname', 'ilike', "%" . Request::input('search') . "%");
        $combined = $friendsoffline->unionAll($friendsonline1)->unionAll($friendsonline2)->take(20)->orderBy('fullname')->get();

		$count = 0;
		$array = array();
		foreach ($combined as $friend)
		{
			$array[$count++] = array( "id" => $friend->id, "fullname" => $friend->fullname, "membertype" => $friend->membertype, "onlineoffline" => $friend->onlineoffline);
		}
	    
	    //this route should returns json response
	    return response()->json(['searchfriendscount' => $count, 'friends' => $array]);
	});

	Route::post('/user/search/{searchfriendscount}', function($searchfriendscount)
	{
		$friendsonline1 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user1')
            ->select('friendsonline.user1 as id', 'users.fullname as fullname', 'users.membertype as membertype', DB::raw("'ONLINE' as onlineoffline"))
            ->where('friendsonline.user2', Auth::user()->id)
            ->where('users.fullname', 'ilike', "%" . Request::input('search') . "%")
            ->where('friendsonline.status', 'ACCEPTED');
        $friendsonline2 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user2')
            ->select('friendsonline.user2 as id', 'users.fullname as fullname', 'users.membertype as membertype', DB::raw("'ONLINE' as onlineoffline"))
            ->where('friendsonline.user1', Auth::user()->id)
            ->where('users.fullname', 'ilike', "%" . Request::input('search') . "%")
            ->where('friendsonline.status', 'ACCEPTED');
        $friendsoffline = DB::table('friendsoffline')->select('id', 'fullname', DB::raw("'' as membertype"), DB::raw("'OFFLINE' as onlineoffline"))->where('user', Auth::user()->id)->where('fullname', 'ilike', "%" . Request::input('search') . "%");
        $combined = $friendsoffline->unionAll($friendsonline1)->unionAll($friendsonline2)->skip($searchfriendscount)->take(20)->orderBy('fullname')->get();

		$count = 0;
		$array = array();
		foreach ($combined as $friend)
		{
			$array[$count++] = array( "id" => $friend->id, "fullname" => $friend->fullname, "membertype" => $friend->membertype, "onlineoffline" => $friend->onlineoffline);
			$searchfriendscount++;
		}
	    
	    //this route should returns json response
	    return response()->json(['searchfriendscount' => $searchfriendscount, 'friends' => $array]);
	});

	Route::post('/user/getallcontactforgroup', function()
	{
		$detailcategories = DB::table('detailcategories')
			->select('friendid')
			->where('category', Request::input('categoryid'))->get();
		$count = 0;
		$array = array();
		foreach ($detailcategories as $detailcategory)
		{
			$array[$count++] = $detailcategory->friendid;
		}

		$friendsonline1 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user1')
            ->select('friendsonline.user1 as id', 'users.fullname as fullname', DB::raw("'ONLINE' as onlineoffline"))
            ->where('friendsonline.user2', Auth::user()->id)
            ->where('friendsonline.user1', 'ACCEPTED')
            ->whereNotIn('friendsonline.user1', $array);
        $friendsonline2 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user2')
            ->select('friendsonline.user2 as id', 'users.fullname as fullname', DB::raw("'ONLINE' as onlineoffline"))
            ->where('friendsonline.user1', Auth::user()->id)
            ->where('friendsonline.status', 'ACCEPTED')
            ->whereNotIn('friendsonline.user2', $array);
        $friendsoffline = DB::table('friendsoffline')->select('id', 'fullname', DB::raw("'OFFLINE' as onlineoffline"))->where('user', Auth::user()->id)->where('isfavorite', 0)->whereNotIn('id', $array);
        $combined = $friendsoffline->unionAll($friendsonline1)->unionAll($friendsonline2)->orderBy('fullname')->get();

		$count = 0;
		$array = array();

		foreach ($combined as $friend)
		{
			$array[$count++] = array( "id" => $friend->id, "fullname" => $friend->fullname, "onlineoffline" => $friend->onlineoffline);
		}

	    //this route should returns json response
	    return response()->json(['friends' => $array]);
	});

	Route::post('/user/getmygroups', function()
	{
        $categories = DB::table('categories')
        				->select('id', 'title')
        				->where('user', Auth::user()->id)
        				->orderBy('title')->get();

		$count = 0;
		$array = array();

		foreach ($categories as $category)
		{
			$countCategory = DB::table('detailcategories')->where('category', $category->id)->count();
			$array[$count++] = array( "id" => $category->id, "title" => $category->title, "count" => $countCategory);
		}

	    //this route should returns json response
	    return response()->json(['categories' => $array]);
	});

	Route::post('/user/create/groups', function()
	{
		parse_str(Request::input('formData'), $output);

		// Setup the validator
		$rules = array('title' => 'required|max:30');
		$validator = Validator::make($output, $rules);

		// Validate the input and return correct response
		if ($validator->fails())
		{
		    return Response::json(array(
		        'status' => false,
		        'errors' => $validator->getMessageBag()->toArray()

		    ), 400); // 400 being the HTTP code for an invalid request.
		}

		$id = Uuid::generate();
		\App\Models\Category::create(array(
			'id' => $id,
		    'user' => Auth::user()->id,
		    'title' => $output['title'],
		));
   		return response()->json(['status' => true]);
	});

	Route::post('/user/delete/groups', function()
	{
		$categoriesid = Request::input('categoriesid');
		for($i=0;$i<count($categoriesid);$i++){
			DB::table('detailcategories')->where('category', $categoriesid[$i])->delete();
			DB::table('categories')->where('id', $categoriesid[$i])->delete();
        }
   		return response()->json(['status' => true]);
	});

	Route::post('/user/getdetailgroups', function()
	{
        $detailcategories = DB::table('detailcategories')
        				->select('id', 'friendid', 'onlineoffline')
        				->where('category', Request::input('categoryid'))->get();

		$count = 0;
		$array = array();

		foreach ($detailcategories as $detailcategory)
		{
			if($detailcategory->onlineoffline == "ONLINE")
			{
				$array[$count++] = array( "id" => $detailcategory->id, 
				"friendid" => $detailcategory->friendid,
				"fullname" => DB::table('users')->select('fullname')->where('id', $detailcategory->friendid)->first()->fullname, 
				"onlineoffline" => $detailcategory->onlineoffline);
			}
			else
			{
				$array[$count++] = array( "id" => $detailcategory->id, 
				"friendid" => $detailcategory->friendid,
				"fullname" => DB::table('friendsoffline')->select('fullname')->where('id', $detailcategory->friendid)->first()->fullname, 
				"onlineoffline" => $detailcategory->onlineoffline);
			}
		}

	    //this route should returns json response
	    return response()->json(['detailcategories' => $array]);
	});

	Route::post('/user/create/detailgroups', function()
	{
		$friends = Request::input('friends');
		for($i=0;$i<count($friends);$i++){
			$split = explode(";", $friends[$i]);
			$id = Uuid::generate();
			\App\Models\DetailCategory::create(array(
				'id' => $id,
			    'category' => Request::input('categoryid'),
			    'friendid' => $split[0],
			    'onlineoffline' => $split[1],
			));
        }
   		return response()->json(['status' => true]);
	});

	Route::post('user/delete/detailgroups', function()
	{
		$detailcategoriesid = Request::input('detailcategoriesid');
		for($i=0;$i<count($detailcategoriesid);$i++){
			DB::table('detailcategories')->where('id', $detailcategoriesid[$i])->delete();
        }
   		return response()->json(['status' => true]);
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
            ->select('friendsonline.isfavorite as isfavorite')
            ->where('friendsonline.user2', Auth::user()->id)
            ->where('friendsonline.user1', $id)
            ->where('friendsonline.status', 'ACCEPTED');
        $friendsonline2 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user2')
            ->select('friendsonline.isfavorite as isfavorite')
            ->where('friendsonline.user1', Auth::user()->id)
            ->where('friendsonline.user2', $id)
            ->where('friendsonline.status', 'ACCEPTED');
        $friendsoffline = DB::table('friendsoffline')->select('isfavorite')->where('id', $id)->where('user', Auth::user()->id);
        $combined = $friendsoffline->unionAll($friendsonline1)->unionAll($friendsonline2)->first();

        $isfavorite = $combined->isfavorite;

        if($isfavorite == 0 || $isfavorite == 1)
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

			$user->isfavorite = $isfavorite;

		    //this route should returns json response
		    return Response::json($user);
        }

		return Response::json(null);
		
	});


	// create friendoffline
	Route::post('/user/create/friendoffline', function()
	{
		parse_str(Request::input('formData'), $output);

		// Setup the validator
		$rules = array('fullname' => 'required|max:30', 'phone' => 'phone|max:30', 'phone2' => 'phone|max:30');
		$validator = Validator::make($output, $rules);

		// Validate the input and return correct response
		if ($validator->fails())
		{
		    return Response::json(array(
		        'status' => false,
		        'errors' => $validator->getMessageBag()->toArray()

		    ), 400); // 400 being the HTTP code for an invalid request.
		}

		$friendsonline1 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user1')
            ->select('friendsonline.user1 as id', 'users.fullname as fullname')
            ->where('friendsonline.user2', Auth::user()->id)->count();
        $friendsonline2 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user2')
            ->select('friendsonline.user2 as id', 'users.fullname as fullname')
            ->where('friendsonline.user1', Auth::user()->id)->count();
        $friendsoffline = DB::table('friendsoffline')->select('id', 'fullname')->where('user', Auth::user()->id)->count();
        $totalcontacts = $friendsoffline + $friendsonline1 + $friendsonline2;

        if(($totalcontacts + 1) > Auth::user()->limitcontacts)
        {
        	return response()->json(['status' => true, 'over' => "You have reached a limit for adding contacts"]);
        }
        else
        {
        	$id = Uuid::generate();
			\App\Models\FriendOffline::create(array(
				'id' => $id,
			    'user' => Auth::user()->id,
			    'fullname' => $output['fullname'],
			    'phone' => $output['phone'],
			    'phone2' => $output['phone2'],
				));
	   		return response()->json(['status' => true, 'id' => $id, 'fullname' => $output['fullname']]);
        }
	});

	// edit friendoffline
	Route::post('user/edit/friendoffline', function()
	{
		$output = Input::all();

		// Setup the validator
		$rules = array('fullname' => 'required|max:30', 'email' => 'email|max:32', 'phone' => 'phone|max:30', 'phone2' => 'phone|max:30', 'address' => 'max:90', 'pinbb' => 'max:8', 'facebook' => 'max:100', 'twitter' => 'max:30', 'instagram' => 'max:30', 'line' => 'max:30', 'photo' => 'image|mimes:jpeg,png');
		$validator = Validator::make($output, $rules);

		// Validate the input and return correct response
		if ($validator->fails())
		{
		    return Response::json(array(
		        'status' => false,
		        'errors' => $validator->getMessageBag()->toArray()

		    ), 400); // 400 being the HTTP code for an invalid request.
		}

		DB::table('friendsoffline')
            ->where('id', $output['id'])
            ->update(['fullname' => $output['fullname'], 
            		'email' => $output['email'], 
            		'phone' => $output['phone'], 
            		'phone2' => $output['phone2'], 
            		'address' => $output['address'], 
            		'pinbb' => $output['pinbb'], 
            		'facebook' => $output['facebook'],
            		'twitter' => $output['twitter'],
            		'instagram' => $output['instagram'],
            		'line' => $output['line']]);

        if(isset($output['photo']) && !empty($output['photo']))
        {
        	$createImage = Image::make($output['photo']);
			$createImage->resize(65, 65);
			$createImage->save(base_path() . '/resources/assets/images/photos/' . $output['id'] . '.png' );
        }
        
   		return response()->json(['status' => true]);
	});

	// delete friend
	Route::delete('user/delete/friend', function()
	{
		$id = Request::input('id');
		$onlineoffline = Request::input('onlineoffline');

		// delete in detailcategories table
		DB::table('detailcategories')->where('friendid', $id)->delete();

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

		// Setup the validator
		$rules = array('fullname' => 'required|max:30', 'phone' => 'phone|max:30', 'phone2' => 'phone|max:30', 'address' => 'max:90', 'pinbb' => 'max:8', 'facebook' => 'max:100', 'twitter' => 'max:30', 'instagram' => 'max:30', 'line' => 'max:30', 'status' => 'max:100', 'photo' => 'image|mimes:jpeg,png');
		$validator = Validator::make($output, $rules);

		// Validate the input and return correct response
		if ($validator->fails())
		{
		    return Response::json(array(
		        'status' => false,
		        'errors' => $validator->getMessageBag()->toArray()

		    ), 400); // 400 being the HTTP code for an invalid request.
		}

		$id = Auth::user()->id;
		DB::table('users')
            ->where('id', $id)
            ->update(['fullname' => $output['fullname'], 
            		'phone' => $output['phone'], 
            		'phone2' => $output['phone2'], 
            		'address' => $output['address'],
            		'pinbb' => $output['pinbb'], 
            		'facebook' => $output['facebook'],
            		'twitter' => $output['twitter'],
            		'instagram' => $output['instagram'],
            		'line' => $output['line'],
            		'status' => $output['status']]);

        if(isset($output['photo']) && !empty($output['photo']))
        {
        	$createImage = Image::make($output['photo']);
			$createImage->resize(65, 65);
			$createImage->save(base_path() . '/resources/assets/images/photos/' . $id . '.png' );
        }
        

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
        $combined = $friendsonline1->unionAll($friendsonline2)->get();

        foreach ($combined as $friend)
		{
			if($friend->status == "ACCEPTED")
			{
				return response()->json(['status' => false, 'msg' => $usersearch->fullname . " is your friend"]);
			}
			else if($friend->status == "PENDING")
			{
				return response()->json(['status' => false, 'msg' => "You have invited " . $usersearch->fullname  . " but still PENDING"]);
			}
			else if($friend->status == "DECLINED")
			{
				return response()->json(['status' => false, 'msg' => "You have invited " . $usersearch->fullname  . " but has been DECLINED"]);
			}
		}

        $array = array();
    	$array[0] = array( "id" => $usersearch->id, "fullname" => $usersearch->fullname);
    	//this route should returns json response
    	return response()->json(['status' => true, 'users' => $array]);
	});

	// create friendonline
	Route::post('/user/create/friendonline', function()
	{
		$friendsonline1 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user1')
            ->select('friendsonline.user1 as id', 'users.fullname as fullname')
            ->where('friendsonline.user2', Auth::user()->id)->count();
        $friendsonline2 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user2')
            ->select('friendsonline.user2 as id', 'users.fullname as fullname')
            ->where('friendsonline.user1', Auth::user()->id)->count();
        $friendsoffline = DB::table('friendsoffline')->select('id', 'fullname')->where('user', Auth::user()->id)->count();
        $totalcontacts = $friendsoffline + $friendsonline1 + $friendsonline2;

        if(($totalcontacts + 1) > Auth::user()->limitcontacts)
        {
        	return response()->json(['status' => true, 'over' => "You have reached a limit for adding contacts"]);
        }

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
		if(Hash::check($output['old_password'], Auth::user()->password))
		{
			if($output['new_password'] == $output['new_password2'])
			{
				$new_password = $output['new_password'];
				$user = Auth::user();
				$user->password = Hash::make($new_password);
				// finally we save the authenticated user
				$user->save();

				if(isset($output['logoutAllDevices']) && $output['logoutAllDevices'] == "on")
				{
					\DB::table('sessions')->where('user', \Auth::user()->id)->where('sessionId', '!=', \Session::getId())->delete();
				}

		   		return response()->json(['status' => true]);
			}
			else
			{
				return response()->json(['status' => false, 'message' => "New Password And Retype Password don't mismatch"]);
			}
		}
		else
		{
			return response()->json(['status' => false, 'message' => "Current Password is not valid"]);
		}
	});

	Route::put('user/showemailinpublic', function()
	{
		$id = Auth::user()->id;
		$showemailinpublic = 0;
		if( Request::input('showemailinpublic') == "yes")
		{
			$showemailinpublic = 1;
		}
		else
		{
			$showemailinpublic = 0;
		}
		DB::table('users')
            ->where('id', $id)
            ->update(['showemailinpublic' => $showemailinpublic]);

   		return response()->json(['status' => true]);
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

	Route::post('/user/getbubblecount', function()
	{
		$totalcontacts =  0;
		$favoritescount = 0;

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

        $friendsonline1 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user1')
            ->select('friendsonline.user1 as id', 'users.fullname as fullname', DB::raw("'ONLINE' as onlineoffline"))
            ->where('friendsonline.user2', Auth::user()->id)
            ->where('friendsonline.status', 'ACCEPTED')
            ->where('friendsonline.isfavorite', 1)->count();
        $friendsonline2 = DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user2')
            ->select('friendsonline.user2 as id', 'users.fullname as fullname', DB::raw("'ONLINE' as onlineoffline"))
            ->where('friendsonline.user1', Auth::user()->id)
            ->where('friendsonline.status', 'ACCEPTED')
            ->where('friendsonline.isfavorite', 1)->count();
        $friendsoffline = DB::table('friendsoffline')->select('id', 'fullname', DB::raw("'OFFLINE' as onlineoffline"))->where('user', Auth::user()->id)->where('isfavorite', 1)->count();
        $favoritescount = $friendsoffline + $friendsonline1 + $friendsonline2;

	    //this route should returns json response
	    return response()->json(['totalcontacts' => $totalcontacts, 'favoritescount' => $favoritescount]);
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
		$friendsonline = DB::table('users')->where('id', $id)->count();
        $friendsoffline = DB::table('friendsoffline')->select('id', 'fullname')->where('id', $id)->where('user', Auth::user()->id)->count();
        $combinedCount = $friendsonline + $friendsoffline;

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
        else
        {
        	$img = Image::make(base_path() . '/resources/assets/images/photos/imagenotfound.png' );
        }

		// now you are able to resize the instance
		$img->resize(65, 65);

		return $img->response('png');
	});

	// edit my private account status
	Route::put('user/changefavorite', function()
	{
		$id = Request::input('id');
		$isfavorite = 0;

		if( Request::input('isfavorite') == "yes")
		{
			$isfavorite = 1;
		}
		else
		{
			$isfavorite = 0;
		}

		if(Request::input('onlineoffline') == "online")
		{
			DB::table('friendsonline')
            ->where('friendsonline.user2', Auth::user()->id)
            ->where('friendsonline.user1', $id)
            ->where('friendsonline.status', 'ACCEPTED')
            ->update(['isfavorite' => $isfavorite]);

            DB::table('friendsonline')
            ->where('friendsonline.user2', $id)
            ->where('friendsonline.user1', Auth::user()->id)
            ->where('friendsonline.status', 'ACCEPTED')
            ->update(['isfavorite' => $isfavorite]);
		}
		else
		{
			DB::table('friendsoffline')
            ->where('id', $id)
            ->update(['isfavorite' => $isfavorite]);
		}
		
		

   		return response()->json(['status' => true]);
	});

	// get image from friendprofile
	Route::get('/user/photo', function()
	{
		if(File::exists(base_path() . '/resources/assets/images/photos/' . Auth::user()->id . '.png'))
		{
			// open an image file
			$img = Image::make(base_path() . '/resources/assets/images/photos/' . Auth::user()->id . '.png' );
		}
		else
		{
			// open an image file
			$img = Image::make(base_path() . '/resources/assets/images/photos/user.png' );
		}

		// now you are able to resize the instance
		$img->resize(65, 65);

		return $img->response('png');
	});

	Route::post('/user/fullname', function()
	{
	    //this route should returns json response
	    return response()->json(['fullname' => Auth::user()->fullname]);
	});

	Route::post('/user/removephoto', function()
	{
	    if(File::exists(base_path() . '/resources/assets/images/photos/' . Auth::user()->id . '.png'))
		{
			File::delete(base_path() . '/resources/assets/images/photos/' . Auth::user()->id . '.png');
		}

	    return response()->json(['status' => true]);
	});

	Route::post('/user/removefriendphoto', function()
	{
        $friendsoffline = DB::table('friendsoffline')->select('id', 'fullname')->where('id', Request::input('id'))->where('user', Auth::user()->id)->count();
        
        if($friendsoffline > 0)
        {
        	if(File::exists(base_path() . '/resources/assets/images/photos/' . Request::input('id') . '.png'))
			{
				File::delete(base_path() . '/resources/assets/images/photos/' . Request::input('id') . '.png');
			}
        }
	    
	    return response()->json(['status' => true]);
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
		$table->string('phone2',30)->default('');
		$table->string('address',90)->default('');
		$table->string('pinbb',8)->default('');
		$table->string('facebook',100)->default('');
		$table->string('twitter',30)->default('');
		$table->string('instagram',30)->default('');
		$table->string('line',30)->default('');
		$table->string('status',100)->default('Welcome to my contact');
		$table->boolean('showemailinpublic')->default(0);
		$table->boolean('privateaccount')->default(0);
		$table->boolean('newinvitesnotification')->default(0);
		$table->integer('limitcontacts')->default(1000);
		$table->string('membertype')->default('MEMBER');
		$table->timestamps();
	});
	Schema::create('password_resets',function($table){
		$table->string('email')->index();
		$table->string('token')->index();
		$table->timestamp('created_at');
	});
	Schema::create('sessions',function($table){
		$table->string('id')->primary();
		$table->string('user');
		$table->foreign('user')->references('id')->on('users');
		$table->string('sessionId',60)->default('');
	});
	Schema::create('friendsonline',function($table){
		$table->string('id')->primary();
		$table->string('user1');
		$table->foreign('user1')->references('id')->on('users');
		$table->string('user2');
		$table->foreign('user2')->references('id')->on('users');
		$table->string('status');
		$table->boolean('isfavorite')->default(0);
		$table->timestamps();
	});
	Schema::create('friendsoffline',function($table){
		$table->string('id')->primary();
		$table->string('user');
		$table->foreign('user')->references('id')->on('users');
		$table->string('fullname',30)->default('');
		$table->string('email',32)->default('');
		$table->string('phone',30)->default('');
		$table->string('phone2',30)->default('');
		$table->string('address',90)->default('');
		$table->string('pinbb',8)->default('');
		$table->string('facebook',100)->default('');
		$table->string('twitter',30)->default('');
		$table->string('instagram',30)->default('');
		$table->string('line',30)->default('');
		$table->boolean('isfavorite')->default(0);
		$table->timestamps();
	});

	Schema::create('categories',function($table){
		$table->string('id')->primary();
		$table->string('user');
		$table->foreign('user')->references('id')->on('users');
		$table->string('title',30)->unique();
		$table->timestamps();
	});

	Schema::create('detailcategories',function($table){
		$table->string('id')->primary();
		$table->string('category');
		$table->foreign('category')->references('id')->on('categories');
		$table->string('friendid');
		$table->string('onlineoffline')->default('');
		$table->timestamps();
	});

	return "tables has been created";
});

Route::get('/image/{id}', [
	    'as' => 'showcontact.image',
	    'uses' => 'ShowContactController@image'
]);

Route::get('/{url}', [
	    'as' => 'showcontact.show',
	    'uses' => 'ShowContactController@show'
]);

