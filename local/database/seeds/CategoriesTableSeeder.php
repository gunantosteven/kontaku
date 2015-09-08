<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder {
	public function run()
	{
		// kosongkan data tabel Users
		DB::table('categories')->delete();
		// buat data 
		\App\Models\Category::create(array(
		'id' => Uuid::generate(),
		'user' => DB::table('users')->where('email', 'gunantosteven@gmail.com')->first()->id,
		'title' => 'Friends',
		));

		\App\Models\Category::create(array(
		'id' => Uuid::generate(),
		'user' => DB::table('users')->where('email', 'gunantosteven@gmail.com')->first()->id,
		'title' => 'Family',
		));
	}
}