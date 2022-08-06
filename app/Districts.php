<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Districts extends Model
{
    protected $connection = 'mysql_topland';
    protected $table='district_master';
    protected $primaryKey='district_id';
    protected $fillable=['district_name','state_id'];

    public function getState(){
        return $this->belongsTo('App\States','state_id','state_id');
    }

}
