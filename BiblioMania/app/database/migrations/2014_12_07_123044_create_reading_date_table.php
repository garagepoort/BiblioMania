<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReadingDateTable extends Migration {

	public function up()
	{
		Schema::create('reading_date', function($table)
		{
			$table->increments('id');
	        $table->date('date');
		});
	}

	public function down()
	{
		Schema::drop('reading_date');
	}

}
