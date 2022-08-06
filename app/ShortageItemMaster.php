<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShortageItemMaster extends Model
{
    protected $table = 'shortage_item_master';
    protected $primaryKey = 'shortage_item_master_id';
    protected $fillable = ['shortage_name', 'category_id'];
}
