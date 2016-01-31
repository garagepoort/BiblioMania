<?php

return array(
	'connections' => array(

		'sqlite' => array(
			'driver'   => 'sqlite',
			'database' => __DIR__.'/../database/production.sqlite',
			'prefix'   => '',
		),

		'mysql' => array(
			'driver'    => 'mysql',
			'host'      => 'localhost',
			'database'  =>  $_ENV['DATABASE_NAME'],
			'username'  => $_ENV['DATABASE_USERNAME'],
			'password'  => $_ENV['DATABASE_PASSWORD'],
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
			'port'    => '3306',
		)
	)
);
