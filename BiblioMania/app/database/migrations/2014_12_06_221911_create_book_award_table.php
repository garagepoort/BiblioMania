<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookAwardTable extends Migration {


	public function up()
	{
		Schema::create('book_award', function($table)
		{
			$table->increments('id');
	        $table->string('name');
	        $table->nullableTimestamps();
		});
	}

	public function down()
	{
		Schema::drop('book_award');
	}

}
