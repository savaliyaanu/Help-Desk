<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GodownMaster extends Model
{
    protected $connection = 'mysql_topland';
    protected $table='godown_master';
    protected $primaryKey='godown_id';
    protected $fillable=['godown_name','company_id'];
}
