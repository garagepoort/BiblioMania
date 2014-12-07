<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSerieTable extends Migration {

	public function up()
	{
		Schema::create('serie', function($table)
		{
			$table->increments('id');
			$table->date('name')->nullable();
	        $table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('serie');
	}

}
