<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChallanTestingMaster extends Model
{
    protected $table = 'challan_testing_master';
    protected $primaryKey = 'challan_testing_id';
    protected $fillable = ['challan_id', 'challan_product_id', 'sr_no', 'branch_id'];

    public function getChallanProduct()
    {
        return $this->belongsTo('App\ChallanProduct', 'challan_product_id', 'challan_product_id');
    }

    public function getChallan()
    {
        return $this->belongsTo('App\Challan', 'challan_id', 'challan_id');
    }

}
