<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguageTable extends Migration {

	public function up()
	{
		Schema::create('language', function($table)
		{
			$table->increments('id');
			$table->String('language')->unique();
		});
	}

	public function down()
	{
		Schema::drop('language');
	}

}
