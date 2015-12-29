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
		'user2' => DB::table('users')->where('email', 'admin@kontakku.com')->first()->id,
		'status' => 'ACCEPTED',
		'isfavorite' => 1,
		));

		\App\Models\FriendOnline::create(array(
		'id' => Uuid::generate(),
		'user1' => DB::table('users')->where('email', 'gunantosteven@gmail.com')->first()->id,
		'user2' => DB::table('users')->where('email', 'baru@gmail.com')->first()->id,
		'status' => 'ACCEPTED',
		'isfavorite' => 1,
		));

		\App\Models\FriendOnline::create(array(
		'id' => Uuid::generate(),
		'user1' => DB::table('users')->where('email', 'gunantosteven@gmail.com')->first()->id,
		'user2' => DB::table('users')->where('email', 'baru1@gmail.com')->first()->id,
		'status' => 'DECLINED',
		));
	}
}