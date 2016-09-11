<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{

                User::create(array(
                        'username' => 'Elisa',
                        'email' => 'elisa@bendani.com',
                        'password' => Hash::make('xxx'),
                        'admin' => true,
                        )
                );
                User::create(array(
                        'username' => 'testUserTests@bendani.com',
                        'email' => 'testUserTests@bendani.com',
                        'password' => Hash::make('xxx'),
                        'admin' => false
                        )
                );

                User::create(array(
                        'username' => 'testUserAdmin@bendani.com',
                	'email' => 'testUserAdmin@bendani.com',
                	'password' => Hash::make('xxx'),
                        'admin' => false
                	)
                );
	}

}