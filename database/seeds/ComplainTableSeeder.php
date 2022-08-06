<?php

use App\Complain;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComplainTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('complain')->insert([
            'complain_id' => 1,
            'branch_id' => 1,
            'complain_no' => 1,
            'client_id' => 1,
            'complain_status' => 'Draft',
            'created_id' => 1,
            'client_name' => 'ajay traders',
            'address' => 'rajkot',
            'mobile' => '1234657890',
            'city_id' => 25,
            'district' => 'rajkot',
            'state' => 'gujarat',
            'medium_id' => 1,
        ]);
        DB::table('complain')->insert([
            'complain_id' => 2,
            'branch_id' => 2,
            'complain_no' => 2,
            'client_id' => 2,
            'complain_status' => 'Draft',
            'created_id' => 2,
            'client_name' => 'ajay traders',
            'address' => 'rajkot',
            'mobile' => '1234657890',
            'city_id' => 25,
            'district' => 'rajkot',
            'state' => 'gujarat',
            'medium_id' => 2,
        ]);

        DB::table('complain_item_details')->insert([
            'cid_id'=> 1,
            'complain_id'=> 1,
            'category_id'=> 1,
            'product_id'=> 1,
            'serial_no'=> 1,
            'complain'=> 'jaghegi',
            'application'=> 'ajkdjh',
            'solution'=> 'ajkdjh',
            'created_id'=> 1,
            'is_delete'=> 'N',
            'complain_status'=> 'Pending',
        ]);
        DB::table('complain_item_details')->insert([
            'cid_id'=> 2,
            'complain_id'=> 2,
            'category_id'=> 2,
            'product_id'=> 2,
            'serial_no'=> 2,
            'complain'=> 'jaghegi',
            'application'=> 'ajkdjh',
            'solution'=> 'ajkdjh',
            'created_id'=> 2,
            'is_delete'=> 'N',
            'complain_status'=> 'Pending',
        ]);

        DB::table('complain_item_details')->insert([
            'cid_id'=> 3,
            'complain_id'=> 3,
            'category_id'=> 3,
            'product_id'=> 3,
            'serial_no'=> 3,
            'complain'=> 'gsdgsd',
            'application'=> 'adgssfdgdsfjkdjh',
            'solution'=> 'ajdsgdsfgdskdjh',
            'created_id'=> 3,
            'is_delete'=> 'N',
            'complain_status'=> 'Pending',
        ]);
        DB::table('complain')->insert([
        'complain_id' => 3,
        'branch_id' => 4,
        'complain_no' => 3,
        'client_id' => 3,
        'complain_status' => 'Draft',
        'created_id' => 3,
        'client_name' => 'ajay traders',
        'address' => 'rajkozbzcvt',
        'mobile' => '1234657890',
        'city_id' => 56,
        'district' => 'rbghgrajkot',
        'state' => 'gujarat',
        'medium_id' => 1,
    ]);
    }
}
