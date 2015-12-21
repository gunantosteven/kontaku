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
			'fullname' => 'test150',
			'email' => 'test150@gmail.com',
			'phone' => '00000',
			'phone2' => '00002',
			'pinbb' => 'abcdefg',
			'facebook' => 'test150',
			'twitter' => '@test150',
			'instagram' => 'test150',
			'line' => 'test150',
			'isfavorite' => 1,
			));

		// Data dummy
		/*for($i = 0; 1000000 > $i; $i++)
		{
			\App\Models\FriendOffline::create(array(
			'id' => Uuid::generate(),
			'user' => DB::table('users')->where('email', 'gunantosteven@gmail.com')->first()->id,
			'fullname' => 'test' . $i,
			'email' => 'test' . $i . '@gmail.com',
			'phone' => '' . $i,
			'phone2' => '' . ($i+1),
			'pinbb' => '' . $i,
			'facebook' => '' . $i,
			'twitter' => '@' . $i,
			'instagram' => '' . $i,
			'line' => '' . $i,
			));
		}*/
	}
}