<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
		$this->call('UsersTableSeederTableSeeder');
		$this->call('FriendsOnlineTableSeeder');
		$this->call('FriendsOfflineTableSeeder');
		$this->call('CategoriesTableSeeder');
		$this->call('DetailCategoriesTableSeeder');
		// $this->call('UserTableSeeder');
	}

}
