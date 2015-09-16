<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWidthColumnToAuthorAndBook extends Migration {

	public function up()
	{
		Schema::table('author', function($table)
		{
			$table->unsignedInteger('imageWidth')->default(0);
		});
		Schema::table('book', function($table)
		{
			$table->unsignedInteger('imageWidth')->default(0);
		});
	}

	public function down()
	{
		Schema::table('author', function($table)
		{
			$table->dropColumn('imageWidth');
		});
		Schema::table('book', function($table)
		{
			$table->dropColumn('imageWidth');
		});
	}

}
