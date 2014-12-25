<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDateTable extends Migration {

	public function up()
	{
		Schema::create('date', function($table)
		{
			$table->increments('id');
	        $table->tinyInteger('day')->nullable;
	        $table->tinyInteger('month')->nullable;
	        $table->integer('year');
		});
	}

	public function down()
	{
		Schema::drop('date');
	}

}
