<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropIsbnUniqueKeyOnFirstPrint extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
//		Schema::table('first_print_info', function($table)
//		{
//			$table->dropUnique('first_print_info_isbn_unique');
//		});
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
