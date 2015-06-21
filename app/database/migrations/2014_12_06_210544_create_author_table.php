<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorTable extends Migration {

	public function up()
	{
		Schema::create('author', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('firstname');
			$table->string('gender');
			$table->string('infix')->nullable();
			$table->string('image')->nullable();
			$table->unsignedInteger('imageHeight');
			$table->unsignedInteger('spritePointer');
			$table->boolean('useSpriteImage');
			$table->unsignedInteger('date_of_death_id')->nullable();
			$table->unsignedInteger('date_of_birth_id')->nullable();
	        $table->unsignedInteger('country_id')->nullable();
	        $table->nullableTimestamps();
		    $table->foreign('country_id')->references('id')->on('country');
			$table->foreign('date_of_death_id')->references('id')->on('date');
			$table->foreign('date_of_birth_id')->references('id')->on('date');
		});
	}

	public function down()
	{
		Schema::drop('author');
	}

}
