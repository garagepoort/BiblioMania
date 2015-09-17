<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookTagTable extends Migration {


	public function up()
	{
		Schema::create('book_tag', function($table)
		{
			$table->increments('id');
			$table->unsignedInteger('book_id');
			$table->unsignedInteger('tag_id');
			$table->nullableTimestamps();
			$table->foreign('book_id')->references('id')->on('book');
			$table->foreign('tag_id')->references('id')->on('tag');
		});
	}

	public function down()
	{
		Schema::drop('book_tag');
	}


}
