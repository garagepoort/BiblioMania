<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorAwardTable extends Migration {

	public function up()
	{
		Schema::create('author_award', function($table)
		{
			$table->increments('id');
	        $table->string('name');
	        $table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('author_award');
	}

}
