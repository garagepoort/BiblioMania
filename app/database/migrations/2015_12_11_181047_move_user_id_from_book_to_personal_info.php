<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveUserIdFromBookToPersonalInfo extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('personal_book_info', function ($table) {
			$table->unsignedInteger('user_id');

			$table->foreign('user_id')->references('id')->on('users');
		});

		DB::statement('UPDATE personal_book_info, book
				SET personal_book_info.user_id = book.user_id
				WHERE book.id = personal_book_info.book_id');

		Schema::table('book', function ($table) {
			$table->dropForeign('book_user_id_foreign');
			$table->dropColumn('user_id');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('book', function ($table) {
			$table->unsignedInteger('user_id');

			$table->foreign('user_id')->references('id')->on('users');
		});

		DB::statement('UPDATE book, personal_book_info
				SET book.user_id = personal_book_info.user_id
				WHERE book.id = personal_book_info.book_id');

		Schema::table('personal_book_info', function ($table) {
			$table->dropColumn('user_id');
		});

	}

}
