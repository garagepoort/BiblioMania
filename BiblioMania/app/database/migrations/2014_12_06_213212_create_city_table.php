<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCityTable extends Migration {

	public function up()
	{
		Schema::create('city', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->unsignedInteger('country_id');
	        $table->nullableTimestamps();
		    $table->foreign('country_id')->references('id')->on('country');
		});
	}

	public function down()
	{
		Schema::drop('city');
	}

}
