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
        // \App\Models\User::factory(10)->create();
        DB::table('types')->insert([
            'name' => 'admin'
        ]);
        DB::table('types')->insert([
            'name' => 'client'
        ]);
        DB::table('types')->insert([
            'name' => 'driver'
        ]);
    }
}
