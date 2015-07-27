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
});

Route::get('createdb',function(){
	Schema::create('users',function($table){
		$table->string('id')->primary();
		$table->string('email',32)->unique();
		$table->string('password',60);
		$table->string('role',32)->default('USER');;
		$table->string('remember_token',60)->default('');
		$table->string('fullname',30)->default('');;
		$table->string('url', 30)->unique();
		$table->string('phone',30)->default('');;
		$table->string('pinbb',30)->default('');;
		$table->string('facebook',30)->default('');;
		$table->string('twitter',30)->default('');;
		$table->string('instagram',30)->default('');;
		$table->string('status',30)->default('Welcome to my contact');;
		$table->timestamps();
	});
	Schema::create('friends',function($table){
		$table->string('id')->primary();
		$table->string('user1');
		$table->foreign('user1')->references('id')->on('users');
		$table->string('user2');
		$table->foreign('user2')->references('id')->on('users');
		$table->date('since');
		$table->timestamps();
	});

	return "tables has been created";
});

Route::get('/{url}', [
	    'as' => 'showcontact.show',
	    'uses' => 'ShowContactController@show'
]);