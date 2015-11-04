<?php namespace App\Services;

use App\Models\User;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

use Uuid;
use Hash;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'fullname' => 'required|max:30',
			'url' => 'required|max:39|min:1|regex:/(^[A-Za-z0-9]+$)+/|unique:users,url',
			'email' => 'required|email|max:32|unique:users',
			'password' => 'required|confirmed|min:6|max:60',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
		return User::create([
			'id' => Uuid::generate(),
			'url' => $data['url'],
			'email' => $data['email'],
			'password' => Hash::make($data['password']),
		]);
	}

}
