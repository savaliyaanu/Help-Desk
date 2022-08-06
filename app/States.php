<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class States extends Model
{
    protected $connection = 'mysql_topland';
    protected $table='state_master';
    protected $primaryKey='state_id';
    protected $fillable=['state_name'];

}
