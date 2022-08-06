<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChallanShortageItem extends Model
{
    protected $table='challan_shortage_item';
    protected $primaryKey='challan_shortage_item_id';
    protected $fillable=['shortage_item_master_id','challan_id','challan_product_id','created_id'];

    public function getShortageName()
    {
        return $this->belongsTo('App\ChallanShortageMaster', 'shortage_item_master_id', 'shortage_item_master_id');
    }

}
