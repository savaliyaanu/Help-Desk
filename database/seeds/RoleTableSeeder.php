<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role')->insert([
            'role_name' => 'Super Admin'
        ]);
        DB::table('role')->insert([
            'role_name' => 'Admin'
        ]);
        DB::table('role')->insert([
            'role_name' => 'User'
        ]);
    }
}
