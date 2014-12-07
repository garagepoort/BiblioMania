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
			$table->unsignedInteger('author_id');
			$table->string('ISBN', 13);
			$table->string('type_of_cover');
			$table->string('coverImage');
			$table->unsignedInteger('genre_id');
			$table->unsignedInteger('publisher_id');
			$table->date('publication_date')->nullable();
			$table->unsignedInteger('country_id')->nullable();
			$table->unsignedInteger('language_id');
			$table->integer('number_of_pages');
			$table->integer('number_of_prints');
			$table->unsignedInteger('serie_id')->nullable();
			$table->unsignedInteger('publisher_serie_id')->nullable();
			$table->boolean('read');
			$table->boolean('owned');
			$table->unsignedInteger('buy_info_id')->nullable();
			$table->unsignedInteger('gift_info_id')->nullable();
			$table->integer('rating');
			$table->double('retail_price')->nullable();
			$table->unsignedInteger('first_print_info_id')->nullable();
	        $table->timestamps();

		    $table->foreign('publisher_id')->references('id')->on('publisher');
		    $table->foreign('country_id')->references('id')->on('country');
		    $table->foreign('author_id')->references('id')->on('author');
		    $table->foreign('language_id')->references('id')->on('language');
		    $table->foreign('genre_id')->references('id')->on('genre');
		    $table->foreign('serie_id')->references('id')->on('serie');
		    $table->foreign('publisher_serie_id')->references('id')->on('publisher_serie');
		    $table->foreign('gift_info_id')->references('id')->on('gift_info');
		    $table->foreign('buy_info_id')->references('id')->on('buy_info');
		    $table->foreign('first_print_info_id')->references('id')->on('first_print_info');
		});
	}

	public function down()
	{
		Schema::drop('book');
	}


}
