<?php

use Illuminate\Database\Seeder;

class UsersTableSeederTableSeeder extends Seeder {
	public function run()
	{
		// kosongkan data tabel Users
		DB::table('users')->delete();
		// buat data users
		\App\Models\User::create(array(
		'id' => Uuid::generate(),
		'email' => 'gunantosteven@gmailcom',
		'password' => Hash::make('admin'),
		'fullname' => 'Steven Gunanto',
		'url' => 'stevengunanto',
		'phone' => '083854968000',
		'pinbb' => '51EF1391',
		'facebook' => 'www.facebook.com/Tasikutus',
		'twitter' => '@StevenGunanto',
		'instagram' => 'stevengunanto',
		'status' => 'Haiii I\'m the first',
		));

		\App\Models\User::create(array(
		'id' => Uuid::generate(),
		'email' => 'coba@gmailcom',
		'password' => Hash::make('coba'),
		'fullname' => 'Coba',
		'url' => 'coba',
		'phone' => '12345678',
		'pinbb' => 'abcdefgh',
		'facebook' => 'www.facebook.com/coba',
		'twitter' => '@coba',
		'instagram' => 'coba',
		'status' => 'Haiii I\'m the second',
		));
	}
}