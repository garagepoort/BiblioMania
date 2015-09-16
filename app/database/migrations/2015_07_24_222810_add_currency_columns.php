<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCurrencyColumns extends Migration {

	public function up()
	{
		Schema::table('buy_info', function($table)
		{
			$table->string('currency')->default("EUR");
		});

		Schema::table('book', function($table)
		{
			$table->string('currency')->default("EUR");
		});
	}

	public function down()
	{
		Schema::table('buy_info', function($table)
		{
			$table->dropColumn('currency');
		});

		Schema::table('book', function($table)
		{
			$table->dropColumn('currency');
		});
	}

}
