<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditNoteItem extends Model
{
    protected $table='credit_note_item';
    protected $primaryKey='credit_note_item_id';
    protected $fillable=['credit_note_id','challan_product_id','product_id','type','amount'];

    public function getOptional()
    {
        return $this->hasMany('App\ChallanOptional', 'challan_product_id', 'challan_product_id');
    }
    public function getProduct()
    {
        return $this->belongsTo('App\Products', 'product_id', 'product_id');
    }
    public function getcreditNote()
    {
        return $this->belongsTo('App\CreditNote', 'credit_note_id', 'credit_note_id');
    }
    public function getchallanProduct()
    {
        return $this->belongsTo('App\ChallanProduct', 'challan_product_id', 'challan_product_id');
    }
}
