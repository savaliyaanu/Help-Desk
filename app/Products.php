<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $connection = 'mysql_topland';
    protected $table='product_master';
    protected $primaryKey='product_id';
    protected $fillable=['product_name'];
}
