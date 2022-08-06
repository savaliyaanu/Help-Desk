<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChallanProduct extends Model
{
    protected $table = 'challan_item_master';
    protected $primaryKey = 'challan_product_id';
    protected $fillable = ['category_id', 'challan_id','product_charge', 'product_id', 'production_no', 'brand_id', 'packing_type', 'warranty', 'serial_no', 'bill_no', 'bill_date', 'application', 'hour_run', 'created_id', 'is_main', 'is_used'];

    public function getOptional()
    {
        return $this->hasMany('App\ChallanOptional', 'challan_product_id', 'challan_product_id');
    }

    public function getShortageList()
    {
        return $this->hasMany('App\ChallanShortageItem', 'challan_product_id', 'challan_product_id');
    }

    public function getOptionalSpare()
    {
        return $this->hasMany('App\ChallanOptional', 'challan_product_id', 'challan_product_id')->where('optional_status', '=', 'Spare');
    }

    public function getOptionalSparePending()
    {
        return $this->hasMany('App\ChallanOptional', 'challan_product_id', 'challan_product_id')->where('optional_status', '=', 'Spare')->where('is_used', '=', 'N');
    }

    public function getOptionalIsUsed()
    {
        return $this->hasMany('App\ChallanOptional', 'challan_product_id', 'challan_product_id')->where('is_used', '=', 'N');
    }

    public function getBrand()
    {
        return $this->belongsTo('App\Brands', 'brand_id', 'brand_id');
    }

    public function getProduct()
    {
        return $this->belongsTo('App\Products', 'product_id', 'product_id');
    }

    public function getCategory()
    {
        return $this->belongsTo('App\Category', 'category_id', 'category_id');
    }

    public function getInspection()
    {
        return $this->belongsTo('App\InspectionReport', 'challan_product_id', 'challan_product_id');
    }

    public function getChangeSpareInfo()
    {
        return $this->hasMany('App\ChangeSpare', 'challan_product_id', 'challan_product_id');
    }
    public function getInspectionReport()
    {
        return $this->hasMany('App\InspectionReport', 'challan_product_id', 'challan_product_id');
    }


}
