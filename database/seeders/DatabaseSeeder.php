<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'admin',
            'name' => 'Admin',
            'nik' => '3228889990000017',
            'card' => '22299933393',
            'tel' => '0339933993',
            'email' => 'admin@argon.com',
            'password' => bcrypt('secret')
        ]);
    }
}
