<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookBookAwardTable extends Migration {

	public function up()
	{
		Schema::create('book_book_award', function($table)
		{
			$table->increments('id');
			$table->unsignedInteger('book_id');
			$table->unsignedInteger('book_award_id');
	        $table->nullableTimestamps();
		    $table->foreign('book_id')->references('id')->on('book');
		    $table->foreign('book_award_id')->references('id')->on('book_award');
		});
	}

	public function down()
	{
		Schema::drop('book_book_award');
	}


}
