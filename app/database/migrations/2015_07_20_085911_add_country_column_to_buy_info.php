<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCountryColumnToBuyInfo extends Migration {


	public function up()
	{
		Schema::table('buy_info', function($table)
		{
			$table->unsignedInteger('country_id')->nullable();
			$table->foreign('country_id')->references('id')->on('country');
		});
	}

	public function down()
	{
		Schema::table('buy_info', function($table)
		{
			$table->dropForeign('buy_info_country_id_foreign');
			$table->dropColumn('country_id');
		});
	}

}
