<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $connection = 'mysql_topland';
    protected $table='client_master';
    protected $primaryKey='client_id';
    protected $fillable=['client_name','city_id','gst_no'];

    public function getCity()
    {
        return $this->belongsTo('App\Citys', 'city_id', 'city_id');
    }
}
