<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReviewAndRatingAreBasedOnReadingDate extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('reading_date', function($table)
		{
			$table->text('review')->nullable();
			$table->integer('rating');
			$table->unsignedInteger('personal_book_info_id');
		});

		DB::statement('DELETE FROM reading_date
				WHERE reading_date.id
				NOT IN (select reading_date_id from personal_book_info_reading_date)');

		DB::statement('UPDATE reading_date, personal_book_info_reading_date
				SET reading_date.personal_book_info_id = personal_book_info_reading_date.personal_book_info_id
				WHERE personal_book_info_reading_date.reading_date_id = reading_date.id');

		DB::statement('UPDATE reading_date, personal_book_info
				SET reading_date.review = personal_book_info.review
				WHERE personal_book_info.id = reading_date.personal_book_info_id');

		DB::statement('UPDATE reading_date, personal_book_info
				SET reading_date.rating = personal_book_info.rating
				WHERE personal_book_info.id = reading_date.personal_book_info_id');

		Schema::table('reading_date', function($table)
		{
			$table->foreign('personal_book_info_id')->references('id')->on('personal_book_info');
		});

		Schema::table('personal_book_info', function($table)
		{
			$table->dropColumn('review');
			$table->dropColumn('rating');
		});

		Schema::drop('personal_book_info_reading_date');
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
