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
		'email' => 'gunantosteven@gmail.com',
		'password' => Hash::make('admin'),
		'active' => 1,
		'role' => 'USER',
		'remember_token' => '',
		'fullname' => 'Steven Gunanto',
		'url' => 'stevengunanto',
		'phone' => '083854968000',
		'pinbb' => '51EF1391',
		'facebook' => 'www.facebook.com/Tasikutus',
		'twitter' => '@StevenGunanto',
		'instagram' => 'stevengunanto',
		'status' => 'Haiii I\'m the first',
		'privateaccount' => 1,
		));

		\App\Models\User::create(array(
		'id' => Uuid::generate(),
		'email' => 'coba@gmail.com',
		'password' => Hash::make('coba'),
		'active' => 1,
		'role' => 'USER',
		'remember_token' => '',
		'fullname' => 'Coba',
		'url' => 'coba',
		'phone' => '12345678',
		'pinbb' => 'abcdefgh',
		'facebook' => 'www.facebook.com/coba',
		'twitter' => '@coba',
		'instagram' => 'coba',
		'status' => 'Haiii I\'m the second',
		));

		\App\Models\User::create(array(
		'id' => Uuid::generate(),
		'email' => 'baru@gmail.com',
		'password' => Hash::make('baru'),
		'active' => 1,
		'role' => 'USER',
		'remember_token' => '',
		'fullname' => 'Baru',
		'url' => 'baru',
		'phone' => '12345678',
		'pinbb' => 'abcdefgh',
		'facebook' => 'www.facebook.com/baru',
		'twitter' => '@baru',
		'instagram' => 'baru',
		'status' => 'Haiii I\'m the third',
		));

		\App\Models\User::create(array(
		'id' => Uuid::generate(),
		'email' => 'baru1@gmail.com',
		'password' => Hash::make('baru1'),
		'active' => 1,
		'role' => 'USER',
		'remember_token' => '',
		'fullname' => 'Baru1',
		'url' => 'baru1',
		'phone' => '12345678',
		'pinbb' => 'abcdefgh',
		'facebook' => 'www.facebook.com/baru1',
		'twitter' => '@baru1',
		'instagram' => 'baru1',
		'status' => 'Haiii I\'m the forth',
		));

		\App\Models\User::create(array(
		'id' => Uuid::generate(),
		'email' => 'baru2@gmail.com',
		'password' => Hash::make('baru2'),
		'active' => 1,
		'role' => 'USER',
		'remember_token' => '',
		'fullname' => 'Baru2',
		'url' => 'baru2',
		'phone' => '12345678',
		'pinbb' => 'abcdefgh',
		'facebook' => 'www.facebook.com/baru12',
		'twitter' => '@baru2',
		'instagram' => 'baru1',
		'status' => 'Haiii I\'m the fifth',
		));
	}
}