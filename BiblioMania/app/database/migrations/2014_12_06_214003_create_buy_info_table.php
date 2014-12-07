<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyInfoTable extends Migration {

	public function up()
	{
		Schema::create('buy_info', function($table)
		{
			$table->increments('id');
			$table->date('buy_date')->nullable();
			$table->double('price_payed')->nullable();
			$table->string('reason')->nullable();
			$table->string('shop')->nullable();
			$table->unsignedInteger('city_id')->nullable();
	        $table->timestamps();
		    $table->foreign('city_id')->references('id')->on('city');
		});
	}

	public function down()
	{
		Schema::drop('buy_info');
	}

}
