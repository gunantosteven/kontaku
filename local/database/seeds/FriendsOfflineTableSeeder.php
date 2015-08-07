<?php

use Illuminate\Database\Seeder;

class FriendsOfflineTableSeeder extends Seeder {
	public function run()
	{
		// kosongkan data tabel Users
		DB::table('friendsoffline')->delete();
		// buat data users
		\App\Models\FriendOffline::create(array(
		'id' => Uuid::generate(),
		'user' => DB::table('users')->where('email', 'gunantosteven@gmail.com')->first()->id,
		'fullname' => 'test',
		'email' => 'test@gmail.com',
		'phone' => '00000',
		'pinbb' => 'asdasd391',
		'facebook' => 'www.facebook.com/test',
		'twitter' => '@test',
		'instagram' => 'test',
		));

		\App\Models\FriendOffline::create(array(
		'id' => Uuid::generate(),
		'user' => DB::table('users')->where('email', 'gunantosteven@gmail.com')->first()->id,
		'fullname' => 'test1',
		'email' => 'test1@gmail.com',
		'phone' => '000001',
		'pinbb' => 'asdasd3911',
		'facebook' => 'www.facebook.com/test1',
		'twitter' => '@test1',
		'instagram' => 'test1',
		));
	}
}