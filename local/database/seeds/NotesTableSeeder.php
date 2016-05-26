<?php

use Illuminate\Database\Seeder;

class NoteTableSeeder extends Seeder {
	public function run()
	{
		DB::table('notes')->delete();
		// buat data users

		/*\App\Models\Note::create(array(
			'id' => Uuid::generate(),
			'user' => DB::table('users')->where('email', 'gunantosteven@gmail.com')->first()->id,
			'notes' => 'awal',
			));*/

		// Data dummy
		for($i = 0; 5 > $i; $i++)
		{
			\App\Models\Note::create(array(
			'id' => Uuid::generate(),
			'user' => DB::table('users')->where('email', 'gunantosteven@gmail.com')->first()->id,
			'note' => 'test' . $i . "\r\n" .'asdasdasdasdasdasdasdabcdef',
			));
		}
	}
}