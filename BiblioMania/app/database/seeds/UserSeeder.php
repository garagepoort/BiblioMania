<?php

class UserSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{

                User::create(array(
                        'email' => 'testUserTests@bendani.com',
                        'password' => Hash::make('xxx')
                        )
                );

                User::create(array(
                	'email' => 'testUserAdmin@bendani.com',
                	'password' => Hash::make('xxx')
                	)
                );
	}

}