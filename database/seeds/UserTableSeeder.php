<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Daniel',
            'email' => 'd@nielmellema.be',
            'password' => bcrypt('1990'),
        ]);
        DB::table('users')->insert([
            'name' => 'Vanessa',
            'email' => 'v@nessawieme.be',
            'password' => bcrypt('1985'),
        ]);
    }
}
