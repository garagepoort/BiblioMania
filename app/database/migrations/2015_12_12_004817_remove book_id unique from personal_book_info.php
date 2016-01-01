<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveBookIdUniqueFromPersonalBookInfo extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('personal_book_info', function($table)
		{
			$table->dropForeign('personal_book_info_book_id_foreign');
			$table->dropUnique('personal_book_info_book_id_unique');
			$table->foreign('book_id')->references('id')->on('book');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('personal_book_info', function($table)
		{
			$table->unique('book_id');
		});
	}

}
