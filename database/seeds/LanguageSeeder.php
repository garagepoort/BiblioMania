<?php

use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::statement("INSERT INTO language (language) VALUES ('Nederlands')");
		DB::statement("INSERT INTO language (language) VALUES ('Engels')");
		DB::statement("INSERT INTO language (language) VALUES ('Frans')");
	}

}