<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeBookBookFromAuthorRelationshipManyToMany extends Migration {

	public function up()
	{
		Schema::create('book_book_from_author', function($table)
		{
			$table->increments('id');
			$table->unsignedInteger('book_id');
			$table->unsignedInteger('book_from_author_id');
			$table->nullableTimestamps();
			$table->foreign('book_id')->references('id')->on('book');
			$table->foreign('book_from_author_id')->references('id')->on('book_from_author');
		});

		$books = Book::all();
		foreach($books as $book){
			if($book->book_from_author_id !== null){
				DB::statement("INSERT INTO book_book_from_author (book_id, book_from_author_id) VALUES ($book->id, $book->book_from_author_id);");
			}
		}

		Schema::table('book', function($table)
		{
			$table->dropForeign('book_book_from_author_id_foreign');
			$table->dropColumn('book_from_author_id');
		});
	}

	public function down()
	{
	}

}
