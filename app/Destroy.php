<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Destroy extends Model
{
    protected $table = 'destroy';
    protected $primaryKey = 'destroy_id';
    protected $fillable = ['challan_id', 'created_id','branch_id','financial_id','updated_id','financial_id'];

    public function getChallanDetail()
    {
        return $this->belongsTo('App\Challan', 'challan_id', 'challan_id');
    }
}
