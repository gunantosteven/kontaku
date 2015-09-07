<?php

use Illuminate\Database\Seeder;

class FriendsOfflineTableSeeder extends Seeder {
	public function run()
	{
		// kosongkan data tabel Users
		DB::table('friendsoffline')->delete();
		// buat data users

		for($i = 0; 150 > $i; $i++)
		{
			\App\Models\FriendOffline::create(array(
			'id' => Uuid::generate(),
			'user' => DB::table('users')->where('email', 'gunantosteven@gmail.com')->first()->id,
			'fullname' => 'test' . $i,
			'email' => 'test' . $i . '@gmail.com',
			'phone' => '00000' . $i,
			'pinbb' => 'abcdefg' . $i,
			'facebook' => 'test' . $i,
			'twitter' => '@test' . $i,
			'instagram' => 'test' . $i,
			'line' => 'test' . $i,
			));
		}

		\App\Models\FriendOffline::create(array(
			'id' => Uuid::generate(),
			'user' => DB::table('users')->where('email', 'gunantosteven@gmail.com')->first()->id,
			'fullname' => 'test150',
			'email' => 'test150@gmail.com',
			'phone' => '00000',
			'pinbb' => 'abcdefg',
			'facebook' => 'test150',
			'twitter' => '@test150',
			'instagram' => 'test150',
			'line' => 'test150',
			'isfavorite' => 1,
			));
	}
}