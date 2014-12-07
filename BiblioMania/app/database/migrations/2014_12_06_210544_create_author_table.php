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
			$table->string('image')->nullable();
	        $table->date('date_of_death')->nullable();
	        $table->date('date_of_birth')->nullable();
	        $table->unsignedInteger('country_id');
	        $table->timestamps();
		    $table->foreign('country_id')->references('id')->on('country');
		});
	}

	public function down()
	{
		Schema::drop('author');
	}

}
