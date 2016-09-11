<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChartConfigurationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('chart_configuration', function($table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('title');
			$table->unsignedInteger('user_id');
			$table->string('type');
			$table->string('xProperty');
			$table->string('xLabel');
			$table->string('yProperty');
			$table->string('filters', 2000);
			$table->date('created_at');
			$table->date('updated_at');
			$table->foreign('user_id')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('chart_configuration');
	}

}
