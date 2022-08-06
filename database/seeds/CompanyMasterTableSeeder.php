<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompanyMasterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('company_master')->insert([
            'company_id' => 1,
            'company_name' => 'PATEL FIELDMARSHAL AGENCIES',
            'address1' => 'TOPLAND',
            'address2' => 'DHEBAR ROAD',
            'address3' => 'OPP. BUS STATION',
            'city_id' => 825,
            'district_id' => 'RAJKOT',
            'state_id' =>'SAURASHTRA',
            'phone' => '0281-2224966,2234966',
            'pincode' => '360001',
            'email' => 'info@topland-india.com',
            'created_id' => '1'
        ]);
        DB::table('company_master')->insert([
            'company_id' => 2,
            'company_name' => 'Analog Cloud Technology',
            'address1' => 'Rajkot',
            'address2' => 'Rajkot',
            'address3' => 'Rajkot',
            'city_id' => 825,
            'district_id' => 'RAJKOT',
            'state_id' => 'SAURASHTRA',
            'phone' => '9510094599',
            'pincode' => '360001',
            'email' => 'analog@gmail.com',
            'created_id' => '1'
        ]);

    }
}
