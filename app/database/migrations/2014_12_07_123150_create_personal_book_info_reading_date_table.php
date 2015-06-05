<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalBookInfoReadingDateTable extends Migration {

	public function up()
	{
		Schema::create('personal_book_info_reading_date', function($table)
		{
			$table->increments('id');
	        $table->unsignedInteger('personal_book_info_id');
	        $table->unsignedInteger('reading_date_id');
	        $table->foreign('personal_book_info_id')->references('id')->on('personal_book_info');
	        $table->foreign('reading_date_id')->references('id')->on('reading_date');
		});
	}

	public function down()
	{
		Schema::drop('personal_book_info_reading_date');
	}

}
