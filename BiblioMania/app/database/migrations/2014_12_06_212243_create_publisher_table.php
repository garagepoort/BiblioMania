<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublisherTable extends Migration {


	public function up()
	{
		Schema::create('publisher', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->unsignedInteger('user_id');
	        $table->nullableTimestamps();
	        $table->foreign('user_id')->references('id')->on('users');
		});
	}

	public function down()
	{
		Schema::drop('publisher');
	}

}
