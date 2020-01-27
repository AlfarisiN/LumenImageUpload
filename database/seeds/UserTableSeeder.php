<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name'  => str_random(20),
            'email' => str_random(10) . '@codepolitan.com',
            'password'  => bcrypt('secret')
        ]);
    }
}
