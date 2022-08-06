<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryChallanOutProduct extends Model
{
    protected $table = 'delivery_challan_out_product';
    protected $primaryKey = 'delivery_challan_product_id';
    protected $fillable = ['delivery_challan_out_id', 'challan_product_id', 'is_inward', 'branch_id', 'financial_id', 'created_id', 'updated_id'];

    public function getChallanProduct()
    {
        return $this->belongsTo('App\ChallanProduct', 'challan_product_id', 'challan_product_id');
    }
}
