<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiftInfoTable extends Migration {

	public function up()
	{
		Schema::create('gift_info', function($table)
		{
			$table->increments('id');
			$table->date('receipt_date')->nullable();
			$table->string('from')->nullable();
			$table->string('occasion')->nullable();
	        $table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('gift_info');
	}

}
