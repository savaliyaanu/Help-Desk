<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccessoryMaster extends Model
{
    protected $connection = 'mysql_topland';
    protected $table='accessories_master';
    protected $primaryKey='accessories_id';
    protected $fillable=['accessories_name'];
}
