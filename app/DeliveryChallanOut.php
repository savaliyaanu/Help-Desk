<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryChallanOut extends Model
{
    protected $table = 'delivery_challan_out';
    protected $primaryKey = 'delivery_challan_out_id';
    protected $fillable = ['challan_id', 'branch_id', 'supplier_id', 'lr_no', 'status', 'created_id', 'updated_id', 'financial_id', 'delivery_challan_no', 'despatched_through', 'destination', 'transport_vehicle'];

    public function getChallan()
    {
        return $this->belongsTo('App\Challan', 'challan_id', 'challan_id');
    }
}
