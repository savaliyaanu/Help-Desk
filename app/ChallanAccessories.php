<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChallanAccessories extends Model
{
    protected $table='challan_accessories';
    protected $primaryKey='challan_accessories_id';
    protected $fillable=['challan_id','accessories_id','accessories_qty','created_id'];

    public function getAccessory(){
        return $this->belongsTo('App\AccessoryMaster','accessories_id','accessories_id');
    }
}
