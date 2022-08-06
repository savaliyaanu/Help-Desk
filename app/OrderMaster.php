<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderMaster extends Model
{
    protected $connection = 'mysql_topland';
    protected $table = 'order_master';
    protected $primaryKey = 'order_id';
    protected $fillable=['order_id'];
}
