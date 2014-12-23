<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublisherSerieTable extends Migration {

	public function up()
	{
		Schema::create('publisher_serie', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->unsignedInteger('publisher_id');
	        $table->nullableTimestamps();
			$table->foreign('publisher_id')->references('id')->on('publisher');
		});
	}

	public function down()
	{
		Schema::drop('publisher_serie');
	}

}
