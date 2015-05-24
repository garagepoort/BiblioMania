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
			$table->text('summary')->nullable();
			$table->string('type_of_cover');
			$table->string('translator');
			$table->string('coverImage');
			$table->unsignedInteger('genre_id');
			$table->unsignedInteger('publisher_id');
			$table->unsignedInteger('publisher_country_id');
			$table->unsignedInteger('publication_date_id')->nullable();
			$table->integer('number_of_pages');
			$table->integer('print');
			$table->double('retail_price')->nullable();
			$table->unsignedInteger('serie_id')->nullable();
			$table->unsignedInteger('publisher_serie_id')->nullable();
			$table->unsignedInteger('first_print_info_id')->nullable();
			$table->unsignedInteger('user_id');
			$table->unsignedInteger('book_from_author_id')->nullable();
			$table->unsignedInteger('language_id')->nullable();
	        $table->nullableTimestamps();

		    $table->foreign('publisher_id')->references('id')->on('publisher');
		    $table->foreign('publisher_country_id')->references('id')->on('country');
		    $table->foreign('genre_id')->references('id')->on('genre');
		    $table->foreign('serie_id')->references('id')->on('serie');
		    $table->foreign('publisher_serie_id')->references('id')->on('publisher_serie');
		    $table->foreign('first_print_info_id')->references('id')->on('first_print_info');
		    $table->foreign('user_id')->references('id')->on('users');
		    $table->foreign('book_from_author_id')->references('id')->on('book_from_author');
		    $table->foreign('publication_date_id')->references('id')->on('date');
			$table->foreign('language_id')->references('id')->on('language');
		});

	}

	public function down()
	{
		Schema::drop('book');
	}


}
