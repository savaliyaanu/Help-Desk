<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DestroyItem extends Model
{
    protected $table = 'destroy_item';
    protected $primaryKey = 'destroy_item_id';
    protected $fillable = ['destroy_id', 'challan_product_id', 'product_id', 'type', 'remark'];

    public function getOptional()
    {
        return $this->hasMany('App\ChallanOptional', 'challan_product_id', 'challan_product_id');
    }

    public function getChallanProduct()
    {
        return $this->belongsTo('App\ChallanProduct', 'challan_product_id', 'challan_product_id');
    }

    public function getProduct()
    {
        return $this->belongsTo('App\Products', 'product_id', 'product_id');
    }
}
