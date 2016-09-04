<?php

class BookSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::statement("INSERT INTO book (title, subtitle, author_id, ISBN, type_of_cover, coverImage, genre_id, publisher_id, publication_date, number_of_pages, print)
						VALUES ('some title', 'subtitle', 1, '0123456789123', 'Hard Cover', 'test/44scotlandstreetAlexander435_f.jpg', 1, '2014-12-10', 1, 200, 100);");
		DB::statement("INSERT INTO book (title, subtitle, author_id, ISBN, type_of_cover, coverImage, genre_id, publisher_id, publication_date, number_of_pages, print)
						VALUES ('some title', 'subtitle', 1, '0123456789123', 'Hard Cover', 'test/50waystofindaloverLucy1404_f.jpg', 1, '2014-12-10', 1, 200, 100);");
		DB::statement("INSERT INTO book (title, subtitle, author_id, ISBN, type_of_cover, coverImage, genre_id, publisher_id, publication_date, number_of_pages, print)
						VALUES ('some title', 'subtitle', 1, '0123456789123', 'Hard Cover', 'test/9789041762511.jpg', 1, '2014-12-10', 1, 200, 100);");
		DB::statement("INSERT INTO book (title, subtitle, author_id, ISBN, type_of_cover, coverImage, genre_id, publisher_id, publication_date, number_of_pages, print)
						VALUES ('some title', 'subtitle', 1, '0123456789123', 'Hard Cover', 'test/1001004002498880.jpg', 1, '2014-12-10', 1, 200, 100);");
		DB::statement("INSERT INTO book (title, subtitle, author_id, ISBN, type_of_cover, coverImage, genre_id, publisher_id, publication_date, number_of_pages, print)
						VALUES ('some title', 'subtitle', 1, '0123456789123', 'Hard Cover', 'test/A Thousand Splendid Suns - Kha1422f.jpg', 1, '2014-12-10', 1, 200, 100);");
		DB::statement("INSERT INTO book (title, subtitle, author_id, ISBN, type_of_cover, coverImage, genre_id, publisher_id, publication_date, number_of_pages, print)
						VALUES ('some title', 'subtitle', 1, '0123456789123', 'Hard Cover', 'test/a-spot-of-bother.jpg', 1, '2014-12-10', 1, 200, 100);");
		DB::statement("INSERT INTO book (title, subtitle, author_id, ISBN, type_of_cover, coverImage, genre_id, publisher_id, publication_date, number_of_pages, print)
						VALUES ('some title', 'subtitle', 1, '0123456789123', 'Hard Cover', 'test/Aandenken.jpg', 1, '2014-12-10', 1, 200, 100);");
	}

}