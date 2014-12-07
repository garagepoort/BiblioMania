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
	        $table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('publisher');
	}

}
