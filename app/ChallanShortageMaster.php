<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChallanShortageMaster extends Model
{
    protected $table='shortage_item_master';
    protected $primaryKey='shortage_item_master_id';
    protected $fillable=['category_id','shortage_name','created_id','updated_id','branch_id'];

}
