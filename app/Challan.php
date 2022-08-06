<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Challan extends Model
{
    protected $table = 'challan';
    protected $primaryKey = 'challan_id';
    protected $fillable = ['challan_no', 'billty_id', 'change_bill_address', 'billing_name', 'address1', 'other_shortage_item', 'address2', 'address3', 'city_id', 'pincode', 'gst_no', 'contact_person', 'phone', 'mobile', 'is_completed'];


    public function getBilltyDetail()
    {
        return $this->belongsTo('App\Billty', 'billty_id', 'billty_id');
    }

    public function getChallanItems()
    {
        return $this->hasMany('App\ChallanProduct', 'challan_id', 'challan_id');
    }

    public function getCity()
    {
        return $this->belongsTo('App\Citys', 'city_id', 'city_id');
    }

    public function getCreditnote()
    {
        return $this->hasMany('App\CreditNote', 'challan_id', 'challan_id');
    }

    public function getInvoice()
    {
        return $this->hasMany('App\Invoice', 'challan_id', 'challan_id');
    }

    public function getDestroy()
    {
        return $this->hasMany('App\Destroy', 'challan_id', 'challan_id');
    }

    public function getPendingChallanItems()
    {
        return $this->hasMany('App\ChallanProduct', 'challan_id', 'challan_id')->where('is_main', '=', 'Y')->where('is_used', '=', 'N');
    }

    public function getPendingChallanSpareItems()
    {
        return $this->hasMany('App\ChallanProduct', 'challan_id', 'challan_id')->where('is_main', '=', 'N');
    }


}
