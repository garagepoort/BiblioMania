<?php

use Illuminate\Database\Migrations\Migration;

class CreateTableWishlist extends Migration {

	public function up()
	{
		Schema::create('wishlist', function($table)
		{
			$table->increments('id');
			$table->unsignedInteger('user_id');
			$table->unsignedInteger('book_id');
			$table->foreign('book_id')->references('id')->on('book');
			$table->foreign('user_id')->references('id')->on('users');
			$table->date('created_at');
			$table->date('updated_at');
		});
	}

	public function down()
	{
		Schema::drop('wishlist');
	}
}
