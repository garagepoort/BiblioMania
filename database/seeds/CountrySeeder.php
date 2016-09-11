<?php

use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::statement("INSERT INTO country(id, code, name) VALUES (1, 'BE', 'België')");
		DB::statement("INSERT INTO country(id, code, name) VALUES (2, 'NL', 'Nederland')");
		DB::statement("INSERT INTO country(id, code, name) VALUES (3, 'UK', 'Groot-Britannië')");
		DB::statement("INSERT INTO country(id, code, name) VALUES (4, 'FR', 'Frankrijk')");
	}

}