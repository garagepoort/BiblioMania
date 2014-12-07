<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountryTable extends Migration {

	public function up()
	{
		Schema::create('country', function($table)
		{
			$table->increments('id');
	        $table->string('name')->unique();
	        $table->string('code')->nullable();
	        $table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('country');
	}

}
