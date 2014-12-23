<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookAuthorTable extends Migration {

		public function up()
	{
		Schema::create('book_author', function($table)
		{
			$table->increments('id');
			$table->unsignedInteger('book_id');
			$table->unsignedInteger('author_id');
	        $table->nullableTimestamps();
		    $table->foreign('book_id')->references('id')->on('book');
		    $table->foreign('author_id')->references('id')->on('author');
		});
	}

	public function down()
	{
		Schema::drop('book_author');
	}

}
