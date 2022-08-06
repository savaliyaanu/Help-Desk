<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table='challan_image';
    protected $primaryKey='image_id';
    protected $fillable=['challan_id','challan_product_id','image_name','created_id'];
}
