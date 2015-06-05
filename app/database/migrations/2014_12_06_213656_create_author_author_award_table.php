<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorAuthorAwardTable extends Migration {

	public function up()
	{
		Schema::create('author_author_award', function($table)
		{
			$table->increments('id');
			$table->unsignedInteger('author_id');
			$table->unsignedInteger('author_award_id');
	        $table->nullableTimestamps();
		    $table->foreign('author_id')->references('id')->on('author');
		    $table->foreign('author_award_id')->references('id')->on('author_award');
		});
	}

	public function down()
	{
		Schema::drop('author_author_award');
	}

}
