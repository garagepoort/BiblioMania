<?php

class LanguageSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::statement("INSERT INTO LANGUAGE (language) VALUES ('Nederlands')");
		DB::statement("INSERT INTO LANGUAGE (language) VALUES ('Engels')");
	}

}