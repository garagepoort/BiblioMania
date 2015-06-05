<?php

class GenreSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::statement("insert into genre (id, name, parent_id, user_id) values (1, 'Adult', null, 1)");
		DB::statement("insert into genre (id, name, parent_id, user_id) values (2, 'YA', null, 1)");
		DB::statement("insert into genre (id, name, parent_id, user_id) values (3, 'Children', null, 1)");

		DB::statement("insert into genre (id, name, parent_id, user_id) values (4, 'Non-fictie', 1, 1)");
		DB::statement("insert into genre (id, name, parent_id, user_id) values (5, 'Fictie', 1, 1)");

		DB::statement("insert into genre (id, name, parent_id, user_id) values (6, 'Geschiedenis en politiek', 4, 1)");
		DB::statement("insert into genre (id, name, parent_id, user_id) values (7, 'Sociale wetenschappen', 4, 1)");
		DB::statement("insert into genre (id, name, parent_id, user_id) values (8, 'Biografie', 4, 1)");
		DB::statement("insert into genre (id, name, parent_id, user_id) values (9, 'Gedichtenbundel', 4, 1)");
		DB::statement("insert into genre (id, name, parent_id, user_id) values (10, 'Grammatica', 4, 1)");
		DB::statement("insert into genre (id, name, parent_id, user_id) values (11, 'Filosofie', 4, 1)");

		DB::statement("insert into genre (id, name, parent_id, user_id) values (12, 'Roman', 5, 1)");
		DB::statement("insert into genre (id, name, parent_id, user_id) values (13, 'Verhalenbundel', 5, 1)");
		DB::statement("insert into genre (id, name, parent_id, user_id) values (14, 'Fantasy', 5, 1)");
		DB::statement("insert into genre (id, name, parent_id, user_id) values (15, 'Thriller/detective', 5, 1)");
		DB::statement("insert into genre (id, name, parent_id, user_id) values (16, 'Graphic novel', 5, 1)");
		DB::statement("insert into genre (id, name, parent_id, user_id) values (17, 'Historische roman', 5, 1)");
		DB::statement("insert into genre (id, name, parent_id, user_id) values (18, 'Humor', 5, 1)");
	}

}