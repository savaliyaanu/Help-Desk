<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChangeSpare extends Model
{
    protected $table = 'challan_change_spare';
    protected $primaryKey = 'challan_change_spare_id';
    protected $fillable = ['challan_product_id', 'product_id', 'qty', 'rate'];

    public function getProduct()
    {
        return $this->belongsTo('App\Products', 'product_id', 'product_id');
    }

    public function getChallanProduct()
    {
        return $this->belongsTo('App\ChallanProduct', 'challan_product_id', 'challan_product_id');
    }

}
