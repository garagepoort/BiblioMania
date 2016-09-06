<?php

use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::statement("insert into genre (id, name, parent_id) values (1, 'Adult', null)");
		DB::statement("insert into genre (id, name, parent_id) values (2, 'YA', null)");
		DB::statement("insert into genre (id, name, parent_id) values (3, 'Children', null)");

		DB::statement("insert into genre (id, name, parent_id) values (4, 'Non-fictie', 1)");
		DB::statement("insert into genre (id, name, parent_id) values (5, 'Fictie', 1)");

		DB::statement("insert into genre (id, name, parent_id) values (6, 'Contemporary', 2)");
		DB::statement("insert into genre (id, name, parent_id) values (7, 'Modern classic', 2)");

		DB::statement("insert into genre (id, name, parent_id) values (8, 'Geschiedenis en politiek', 4)");
		DB::statement("insert into genre (id, name, parent_id) values (9, 'Mens en maatschappij', 4)");
		DB::statement("insert into genre (id, name, parent_id) values (10, 'Biografie', 4)");
		DB::statement("insert into genre (id, name, parent_id) values (11, 'Gedichtenbundel', 4)");
		DB::statement("insert into genre (id, name, parent_id) values (12, 'Spelling en grammatica', 4)");
		DB::statement("insert into genre (id, name, parent_id) values (13, 'Filosofie', 4)");
		DB::statement("insert into genre (id, name, parent_id) values (14, 'Satire', 4)");

		DB::statement("insert into genre (id, name, parent_id) values (15, 'Roman', 5)");
		DB::statement("insert into genre (id, name, parent_id) values (16, 'Verhalenbundel', 5)");
		DB::statement("insert into genre (id, name, parent_id) values (17, 'Fantasy', 5)");
		DB::statement("insert into genre (id, name, parent_id) values (18, 'Thriller/detective', 5)");
		DB::statement("insert into genre (id, name, parent_id) values (19, 'Graphic novel', 5)");
		DB::statement("insert into genre (id, name, parent_id) values (20, 'Historische roman', 5)");
		DB::statement("insert into genre (id, name, parent_id) values (21, 'Humor', 5)");
		DB::statement("insert into genre (id, name, parent_id) values (22, 'Modern classic', 5)");
		DB::statement("insert into genre (id, name, parent_id) values (23, 'Novelle', 5)");
	}

}