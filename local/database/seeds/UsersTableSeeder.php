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
		'email' => 'coba@gmail.com',
		'password' => Hash::make('coba'),
		'active' => 1,
		'role' => 'USER',
		'remember_token' => '',
		'fullname' => 'Coba',
		'url' => 'coba',
		'phone' => '12345678',
		'phone2' => '87654321',
		'pinbb' => 'abcdefgh',
		'facebook' => 'coba',
		'twitter' => '@coba',
		'instagram' => 'coba',
		'line' => 'coba',
		'status' => 'Haiii I\'m the second',
		'membertype' => 'PREMIUM',
		'limitcontacts' => 500,
		));
		
		\App\Models\User::create(array(
		'id' => Uuid::generate(),
		'email' => 'gunantosteven@gmail.com',
		'password' => Hash::make('admin'),
		'active' => 1,
		'role' => 'ADMIN',
		'remember_token' => '',
		'fullname' => 'Steven Gunanto',
		'url' => 'stevengunanto',
		'phone' => '083854968000',
		'phone2' => '+6283854968000',
		'address' => 'Jl. Sesuatu No.1',
		'pinbb' => '51EF1391',
		'facebook' => 'https://www.facebook.com/profile.php?id=1671663690',
		'twitter' => '@StevenGunanto',
		'instagram' => 'stevengunanto',
		'line' => 'stevengunanto',
		'status' => 'Haiii I\'m the first',
		'privateaccount' => 0,
		'newinvitesnotification' => 1,
		'membertype' => 'BOSS',
		'limitcontacts' => 1000,
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
		'phone2' => '12345679',
		'pinbb' => 'abcdefgh',
		'facebook' => 'baru',
		'twitter' => '@baru',
		'instagram' => 'baru',
		'line' => 'baru',
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
		'phone2' => '123123123',
		'pinbb' => 'abcdefgh',
		'facebook' => 'baru1',
		'twitter' => '@baru1',
		'instagram' => 'baru1',
		'line' => 'baru1',
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
		'phone2' => '8712654321',
		'pinbb' => 'abcdefgh',
		'facebook' => 'baru12',
		'twitter' => '@baru2',
		'instagram' => 'baru2',
		'line' => 'baru2',
		'status' => 'Haiii I\'m the fifth',
		));
	}
}