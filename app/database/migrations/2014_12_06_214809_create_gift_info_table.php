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
			$table->string('reason')->nullable();
			$table->unsignedInteger('personal_book_info_id')->unique();
	        $table->nullableTimestamps();
		    $table->foreign('personal_book_info_id')->references('id')->on('personal_book_info');
		});
	}

	public function down()
	{
		Schema::drop('gift_info');
	}

}
