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
        DB::table('users')->insert([
            'name' => 'Daniel',
            'email' => 'd@nielmellema.be',
            'password' => '$2y$10$b1.KdgZOBJJLjJLtvRMJB.VfU3Fzvqv.0n3OSZDQbVlfPgzu1DN.a',
        ]);
    }
}
