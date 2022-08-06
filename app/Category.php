<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $connection = 'mysql_topland';
    protected $table='category_master';
    protected $primaryKey='category_id';
    protected $fillable=['category_name'];}
