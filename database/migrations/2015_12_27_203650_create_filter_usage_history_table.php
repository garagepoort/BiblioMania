<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilterUsageHistoryTable extends Migration {

	public function up()
	{
		Schema::create('filter_history', function($table)
		{
			$table->increments('id');
			$table->string('filter_id');
			$table->integer('times_used');
		});
	}

	public function down()
	{
		Schema::drop('filter_history');
	}


}
