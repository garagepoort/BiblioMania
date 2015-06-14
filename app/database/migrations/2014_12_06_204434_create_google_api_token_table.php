<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoogleApiTokenTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('google_api_tokens', function($table)
		{
		    $table->increments('id');
		    $table->string('username')->unique();
		    $table->string('access_token', 255);
		    $table->string('refresh_token', 255);
		    $table->date('created_at');
		    $table->date('updated_at');
		    $table->foreign('username')->references('username')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('google_api_tokens');
	}

}
