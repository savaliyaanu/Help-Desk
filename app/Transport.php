<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    protected $connection = 'mysql_topland';
    protected $table = 'transport_master';
    protected $primaryKey = 'transport_id';
    protected $fillable=['transport_name','city_id'];

    public function getCity()
    {
        return $this->belongsTo('App\Citys', 'city_id', 'city_id');
    }
}
