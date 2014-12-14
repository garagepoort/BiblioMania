<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// $this->call('AuthorSeeder');
		$this->call('CountrySeeder');
		$this->call('GenreSeeder');
		$this->call('LanguageSeeder');
	}

}
