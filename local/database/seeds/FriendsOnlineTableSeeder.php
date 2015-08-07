<?php

use Illuminate\Database\Seeder;

class FriendsOnlineTableSeeder extends Seeder {
	public function run()
	{
		// kosongkan data tabel Users
		DB::table('friendsonline')->delete();
		// buat data 
		\App\Models\FriendOnline::create(array(
		'id' => Uuid::generate(),
		'user1' => DB::table('users')->where('email', 'gunantosteven@gmail.com')->first()->id,
		'user2' => DB::table('users')->where('email', 'coba@gmail.com')->first()->id,
		));
	}
}