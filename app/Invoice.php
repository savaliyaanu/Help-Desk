<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoice';
    protected $primaryKey = 'invoice_id';
    protected $fillable = ['challan_id', 'invoice_date','client_id','client_name', 'lr_date', 'challan_date', 'client_id', 'product_id', 'view_accessories', 'transport_id', 'lr_no', 'remark', 'authorize_person', 'lory_no',
        'gst_no', 'pincode', 'city_id', 'address1', 'address2', 'address3', 'billing_name', 'change_develiry_address', 'phone', 'mobile', 'contact_person', 'created_id', 'updated_id'];

    public function getChallanDetail()
    {
        return $this->belongsTo('App\Challan', 'challan_id', 'challan_id');
    }
    public function getGodownDetail()
    {
        return $this->belongsTo('App\GodownMaster', 'challan_id', 'challan_id');
    }
    public function getChallanItem()
    {
        return $this->belongsTo('App\ChallanProduct', 'challan_id', 'challan_product_id');
    }
    public function getBrand()
    {
        return $this->belongsTo('App\Brands', 'brand_id', 'brand_id');
    }
    public function getCategory()
    {
        return $this->belongsTo('App\Category', 'brand_id', 'brand_id');
    }
}
