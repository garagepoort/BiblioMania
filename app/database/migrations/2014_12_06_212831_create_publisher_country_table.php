<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublisherCountryTable extends Migration {

	public function up()
	{
		Schema::create('publisher_country', function($table)
		{
			$table->increments('id');
			$table->unsignedInteger('publisher_id');
			$table->unsignedInteger('country_id');
	        $table->nullableTimestamps();
		    $table->foreign('publisher_id')->references('id')->on('publisher');
		    $table->foreign('country_id')->references('id')->on('country');
		});
	}

	public function down()
	{
		Schema::drop('publisher_country');
	}

}
