<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSpriteFileLocationOnBookTable extends Migration {


	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('book', function($table)
		{
			$table->string('spriteFileLocation')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('book', function($table)
		{
			$table->dropColumn('spriteFileLocation');
		});
	}

}
