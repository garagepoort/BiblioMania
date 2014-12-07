<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFirstPrintInfoTable extends Migration {

	public function up()
	{
		Schema::create('first_print_info', function($table)
		{
			$table->increments('id');
			$table->string('title')->nullable();
			$table->unsignedInteger('publisher_id')->nullable();
			$table->date('publication_date')->nullable();
			$table->unsignedInteger('country_id')->nullable();
			$table->unsignedInteger('language_id')->nullable();
			$table->String('ISBN', 13)->nullable()->unique();
			$table->string('cover_image')->nullable();
	        $table->timestamps();

		    $table->foreign('publisher_id')->references('id')->on('publisher');
		    $table->foreign('country_id')->references('id')->on('country');
		    $table->foreign('language_id')->references('id')->on('language');
		});
	}

	public function down()
	{
		Schema::drop('first_print_info');
	}

}
