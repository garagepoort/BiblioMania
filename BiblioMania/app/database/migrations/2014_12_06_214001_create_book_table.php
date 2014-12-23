<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookTable extends Migration {

	public function up()
	{
		Schema::create('book', function($table)
		{
			$table->increments('id');
			$table->string('title');
			$table->string('subtitle')->nullable();
			$table->string('ISBN', 13);
			$table->string('type_of_cover');
			$table->string('coverImage');
			$table->unsignedInteger('genre_id');
			$table->unsignedInteger('publisher_id');
			$table->date('publication_date')->nullable();
			$table->integer('number_of_pages');
			$table->integer('print');
			$table->double('retail_price')->nullable();
			$table->unsignedInteger('serie_id')->nullable();
			$table->unsignedInteger('publisher_serie_id')->nullable();
			$table->unsignedInteger('first_print_info_id')->nullable();
			$table->unsignedInteger('user_id');
			$table->unsignedInteger('book_from_author_id')->nullable();
	        $table->nullableTimestamps();

		    $table->foreign('publisher_id')->references('id')->on('publisher');
		    $table->foreign('genre_id')->references('id')->on('genre');
		    $table->foreign('serie_id')->references('id')->on('serie');
		    $table->foreign('publisher_serie_id')->references('id')->on('publisher_serie');
		    $table->foreign('first_print_info_id')->references('id')->on('first_print_info');
		    $table->foreign('user_id')->references('id')->on('users');
		    $table->foreign('book_from_author_id')->references('id')->on('book_from_author');
		});
	}

	public function down()
	{
		Schema::drop('book');
	}


}
