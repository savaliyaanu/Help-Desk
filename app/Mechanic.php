<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mechanic extends Model
{
    protected $connection = 'mysql_topland';
    protected $table='mechanic_master';
    protected $primaryKey='mechanic_id';
    protected $fillable=['mechanic_name'];
}
