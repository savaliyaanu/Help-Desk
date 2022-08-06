<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $table='invoice_items';
    protected $primaryKey='invoice_item_id';
    protected $fillable=['invoice_id','challan_product_id','type','created_id','updated_id','is_used'];



    public function getProduct()
    {
        return $this->belongsTo('App\Products', 'product_id', 'product_id');
    }
    public function getOptional()
    {
        return $this->hasMany('App\ChallanOptional', 'challan_product_id', 'challan_product_id');
    }

}
