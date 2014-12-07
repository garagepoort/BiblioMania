<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGenreTable extends Migration {

	public function up()
	{
		Schema::create('genre', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->unsignedInteger('parent_id')->nullable();
	        $table->timestamps();
		    $table->foreign('parent_id')->references('id')->on('genre');
		});
	}

	public function down()
	{
		Schema::drop('genre');
	}

}
