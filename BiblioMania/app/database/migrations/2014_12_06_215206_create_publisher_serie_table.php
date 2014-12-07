<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublisherSerieTable extends Migration {

	public function up()
	{
		Schema::create('publisher_serie', function($table)
		{
			$table->increments('id');
			$table->date('name')->nullable();
	        $table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('publisher_serie');
	}

}
