<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeTranslatorColumnOnBookNullable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('ALTER TABLE book MODIFY translator VARCHAR(100) NULL;');
		DB::statement('ALTER TABLE book MODIFY print INTEGER NULL;');
		DB::statement('ALTER TABLE book MODIFY number_of_pages INTEGER NULL;');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
