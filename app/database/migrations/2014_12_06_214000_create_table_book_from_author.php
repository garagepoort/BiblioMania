<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBookFromAuthor extends Migration {

	public function up()
	{
		Schema::create('book_from_author', function($table)
		{
			$table->increments('id');
	        $table->string('title');
	        $table->string('publication_year');
	        $table->unsignedInteger('author_id');
	        $table->nullableTimestamps();
	        $table->foreign('author_id')->references('id')->on('author');
		});
	}

	public function down()
	{
		Schema::drop('book_from_author');
	}

}
