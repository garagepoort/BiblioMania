<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilmTable extends Migration {

	public function up()
	{
		Schema::create('film', function($table)
		{
			$table->increments('id');
	        $table->string('title');
	        $table->unsignedInteger('book_id');
	        $table->timestamps();
	        $table->foreign('book_id')->references('id')->on('book');
		});
	}

	public function down()
	{
		Schema::drop('film');
	}

}
