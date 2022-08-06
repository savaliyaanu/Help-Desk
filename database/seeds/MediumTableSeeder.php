<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MediumTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('medium')->insert([
            'medium_name' => 'TELEPHONE'
        ]);
        DB::table('medium')->insert([
            'medium_name' =>'POST/COURIER'
        ]);
        DB::table('medium')->insert([
            'medium_name' => 'WHATSAPP'
        ]);
        DB::table('medium')->insert([
            'medium_name' => 'E-MAIL'
        ]);
        DB::table('medium')->insert([
            'medium_name' => 'PERSONALY'
        ]);
        DB::table('medium')->insert([
            'medium_name' =>'MARKETING STAFF'
        ]);
        DB::table('medium')->insert([
            'medium_name' => 'WEBSITE'
        ]);
    }
}
