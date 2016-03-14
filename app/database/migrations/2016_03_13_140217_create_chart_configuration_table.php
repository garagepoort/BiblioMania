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
			$table->increments('id');
			$table->string('title');
			$table->unsignedInteger('user_id');
			$table->string('type');
			$table->string('xProperty');
			$table->string('yProperty');
			$table->date('created_at');
			$table->date('updated_at');
			$table->foreign('user_id')->references('id')->on('users');
		});

		Schema::create('chart_condition', function($table)
		{
			$table->increments('id');
			$table->string('property');
			$table->string('value');
			$table->string('operator');
			$table->unsignedInteger('chart_configuration_id');
			$table->date('created_at');
			$table->date('updated_at');
			$table->foreign('chart_configuration_id')->references('id')->on('chart_configuration');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('chart_condition');
		Schema::drop('chart_configuration');
	}

}
