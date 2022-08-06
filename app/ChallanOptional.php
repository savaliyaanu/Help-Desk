<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChallanOptional extends Model
{
    protected $table = 'challan_optional';
    protected $primaryKey = 'challan_optional_id';
    protected $fillable = ['challan_product_id', 'product_id', 'optional_status', 'qty','is_used','created_id','updated_id','challan_id'];

    public function getProduct()
    {
        return $this->belongsTo('App\Products', 'product_id', 'product_id');
    }
    public function getChallanProduct()
    {
        return $this->belongsTo('App\ChallanProduct', 'challan_product_id', 'challan_product_id');
    }
    public function getSpareInspection()
    {
        return $this->hasMany('App\SpareInspectionReport', 'challan_product_id', 'challan_product_id');
    }


}
