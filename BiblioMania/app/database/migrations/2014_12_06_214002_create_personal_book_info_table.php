<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalBookInfoTable extends Migration {

	public function up()
	{
		Schema::create('personal_book_info', function($table)
		{
			$table->increments('id');
			$table->boolean('owned');
			$table->string('reason_not_owned');
			$table->unsignedInteger('book_id')->unique();
			$table->integer('rating');
			$table->double('retail_price')->nullable();
			$table->text('review')->nullable();
	        $table->nullableTimestamps();
		    $table->foreign('book_id')->references('id')->on('book');
		});
	}

	public function down()
	{
		Schema::drop('personal_book_info');
	}

}
