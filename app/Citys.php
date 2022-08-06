<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Citys extends Model
{
    protected $connection = 'mysql_topland';
    protected $table='city_master';
    protected $primaryKey='city_id';
    protected $fillable=['city_name','district_id'];

    public function getDistrict(){
        return $this->belongsTo('App\Districts','district_id','district_id');
    }

}
