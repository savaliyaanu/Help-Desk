<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brands extends Model
{

    protected $connection = 'mysql_topland';
    protected $table='brand_master';
    protected $primaryKey='brand_id';
    protected $fillable=['brand_name'];

}
