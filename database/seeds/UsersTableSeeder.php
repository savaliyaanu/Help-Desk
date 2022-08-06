<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Kapil',
            'company_id'=>1,
            'branch_id'=>1,
            'role_id'=>1,
            'email' => 'kapilbhalala@gmail.com',
            'password' => bcrypt('Analog@0518'),
        ]);
        DB::table('users')->insert([
            'name' => 'Aniruddh',
            'company_id'=>1,
            'branch_id'=>1,
            'role_id'=>1,
            'email' => 'savaliyaanu02@gmail.com',
            'password' => bcrypt('Analog@0518'),
        ]);
        DB::table('users')->insert([
            'name' => 'Chintan',
            'company_id'=>1,
            'branch_id'=>1,
            'role_id'=>1,
            'email' => 'chintanraiyani96@gmail.com',
            'password' => bcrypt('Analog@0518'),
        ]);
        DB::table('users')->insert([
            'name' => 'Mayur Joshi',
            'company_id'=>1,
            'branch_id'=>1,
            'role_id'=>1,
            'email' => 'service@topland-india.com',
            'password' => bcrypt('123456'),
        ]);

    }
}
