<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchMasterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('branch_master')->insert([
            'branch_id' => 1,
            'company_id' => 1,
            'branch_name' => 'PATEL FIELDMARSHAL AGENCIES',
            'address1' => 'TOPLAND',
            'address2' => 'DHEBAR ROAD',
            'address3' => 'OPP. BUS STATION',
            'city_id' => 825,
            'district_id' => 283,
            'state_id' => 21,
            'gst_no' => '24AACFP7930Q1ZR',
            'pincode' => '360001',
            'created_id'=> '1'

        ]);
        DB::table('branch_master')->insert([
            'branch_id' => 2,
            'company_id' => 2,
            'branch_name' => 'Analog Cloud Tech',
            'address1' => 'Rajkot',
            'address2' => 'Rajkot',
            'address3' => 'Rajkot',
            'city_id' => 825,
            'district_id' => 283,
            'state_id' => 21,
            'gst_no' => '24AACFP7930Q1ZR',
            'pincode' => '360001',
            'created_id'=> '1'

        ]);

    }
}
